<?php
/**
 * Doctor.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::setPathOfAlias('Doctor', Yii::getPathOfAlias('application.models.Doctor'));

class Doctor extends CModelEvent implements DoctorInterface, StateInterface {
    private $name = '';
    private $state = self::STATE_DOCTOR_WAITING_PATIENT;

    /** @var Queue */
    public $queue = null;

    /**
     * @var Sickness[]
     * какие болезни лечит врач
     */
    protected $sickness = null;

    public function __construct()
    {
        $this->sickness = new \CList();
        $this->queue = new Queue();
        $this->onTreatPatient = [new Notifer(), 'treatPatient'];
    }

    public function getName()
    {
        return str_pad('Dr. [' . $this->name . ']', 27);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $type class name
     * @return Doctor|Doctor\Therapeutist
     * @throws CException
     */
    public static function create($type)
    {
        $className = '\Doctor\\' . $type;
        if (class_exists($className)) { // @todo проверка
            /** @var Doctor $d */
            $d = new $className;
            $d->setName($type);
            return $d;
        }
        throw new CException('No ' . $type . ' doctor');
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function isFree()
    {
        return $this->getState() == self::STATE_DOCTOR_WAITING_PATIENT;
    }

    public function getSickness()
    {
        return $this->sickness;
    }

    /**
     * @return Patient
     */
    public function getCurrentPatient()
    {
        return $this->queue->peek();
    }

    public function hasPatient()
    {
        return (bool)$this->queue->count;
    }

    /**
     * Вылечивает пациента
     * @return Patient
     */
    public function treatPatient()
    {
        /** @var Patient $patient */
        $patient = $this->queue->dequeue();
        $patient->setTreatDoctor($this);
        $this->onTreatPatient(new CModelEvent($patient));
        $patient->removeSickness($patient->currentSickness);
        $patient->setState(self::STATE_PATIENT_HEALTHY);
        $patient->currentSickness = null;

        if (!$this->hasPatient()) {
            $this->setState(self::STATE_DOCTOR_WAITING_PATIENT);
        }
        return $patient;
    }

    public function onTreatPatient(CEvent $event)
    {
        $this->raiseEvent('onTreatPatient', $event);
    }
}
