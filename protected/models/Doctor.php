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

class Doctor extends Observer implements DoctorInterface, StateInterface {
    private $name = '';
    private $state = self::STATE_DOCTOR_FREE;
    private $currentPatient = null;

    /** @var CQueue */
    public $queue = null;

    /**
     * @var SicknessAbstract[]
     * какие болезни лечит врач
     */
    protected $sickness = null;

    /** @noinspection PhpHierarchyChecksInspection */
    protected function __construct()
    {
        $this->sickness = new \CList();
        $this->queue = new CQueue();
    }

    public function getName()
    {
        return '[Dr. <b>' . $this->name . '</b>]';
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
     * @return mixed
     * @throws CException
     */
    public static function load($type)
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

    /**
     * @param Observable|Patient $observable
     */
    function doUpdate(Observable $observable)
    {
        $this->setState(self::STATE_DOCTOR_BUSY);
        $observable->setState(self::STATE_PATIENT_PROCESSING);
        echo 'Patient <b>[' . $observable->getName() . ']</b> attached to Dr. <b>[' . $this->getName(
            ) . ']</b> with <b>[' .  $observable->currentSickness->getName() . ']</b><br />';
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
        return $this->getState() == self::STATE_DOCTOR_FREE;
    }

    public function getSickness()
    {
        return $this->sickness;
    }

    /**
     * @param Observable|Patient $observable
     * @return bool|void
     */
    public function attach(Observable $observable)
    {
        if (!$this->hasPatient()) {
            $this->currentPatient = $observable;
            parent::attach($observable);
            $observable->notify();
            return true;
        }
        $this->queue->enqueue($observable);
        return false;
    }

    /**
     * @return Patient
     */
    public function getCurrentPatient()
    {
        return $this->currentPatient;
    }

    public function hasPatient()
    {
        return $this->currentPatient instanceof Patient;
    }
}
