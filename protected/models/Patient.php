<?php
/**
 * Patient.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
 

class Patient extends CModelEvent implements PatientInterface, StateInterface {
    /** @var Sickness[] */
    private $sickness = null;

    /** @var string */
    private $state = self::STATE_PATIENT_NEW;

    private $name = '';

    /** @var Sickness */
    public $currentSickness = null;

    /** @var Doctor */
    private $treatDoctor = null;

    /**
     * @param string $name
     * @param string $sickness название болезни
     */
    public function __construct($name = 'No name', $sickness = null)
    {
        parent::__construct();
        $this->name = $name;
        $this->sickness = new CList();
        if ($sickness) {
            $this->addSickness($sickness);
        }
        $this->onToDoctor = [new Notifer(), 'toDoctor'];
        $this->onAlreadyAtDoctor = [new Notifer(), 'alreadyAtDoctor'];
        $this->onNoDoctor = [new Notifer(), 'noDoctor'];
    }

    public function toDoctor(Doctor $doctor)
    {
        $event = new CModelEvent($doctor);

        if ($doctor->queue->contains($this)) {
            //$this->setState(StateInterface::STATE_PATIENT_WAITING);
            $this->onAlreadyAtDoctor($event);
        } else {
            $doctor->queue->enqueue($this);
            $this->setState(StateInterface::STATE_PATIENT_PROCESSING);
            $this->onToDoctor($event);
        }
        $doctor->setState(StateInterface::STATE_DOCTOR_WITH_PATIENT);
        return $event->isValid;
    }

    public function noDoctor(Sickness $sickness)
    {
        $this->setState(self::STATE_PATIENT_NO_DOCTOR);
        $this->onNoDoctor(new CModelEvent($sickness));
    }

    public function onToDoctor(CEvent $event)
    {
        $this->raiseEvent('onToDoctor', $event);
    }

    /**
     * Информирует о том, что пациент уже в очереди
     * @param CEvent $event
     */
    public function onAlreadyAtDoctor(CEvent $event)
    {
        $this->raiseEvent('onAlreadyAtDoctor', $event);
    }

    public function onNoDoctor(CEvent $event)
    {
        $this->raiseEvent('onNoDoctor', $event);
    }

    /**
     * @param string $sicknessName
     */
    public function addSickness($sicknessName)
    {
        $this->sickness->add(Sickness::create($sicknessName));
    }

    /**
     * @param \Sickness $sickness
     */
    public function removeSickness($sickness)
    {
        $this->sickness->remove($sickness);
    }

    /**
     * @param int $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Pt. [' . $this->name . ']';
    }

    public function card()
    {
        $sicknessNames = [];
        if ($this->sickness->count) {
            foreach ($this->sickness as $sickness) {
                /** @var Sickness $sickness */
                $sicknessNames[] = str_replace('Sickness\\', '', $sickness->getName());
            }
        }
        $sicknessNames = implode(', ', $sicknessNames);
        return "{$this->getName()}\t{$this->getState()}\t[$sicknessNames]";
    }

    /**
     * @return Sickness[]
     */
    public function getSickness()
    {
        return $this->sickness;
    }

    /**
     * @return \Doctor
     */
    public function getTreatDoctor()
    {
        return $this->treatDoctor;
    }

    /**
     * Лечащий врач в данный момент
     * @param \Doctor $doctor
     */
    public function setTreatDoctor(Doctor $doctor)
    {
        $this->treatDoctor = $doctor;
    }
}
