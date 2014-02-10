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
    /** @var CTypedList */
    private $sickness = null;

    /** @var string */
    private $state = self::STATE_PATIENT_NEW;

    private $name = '';

    /** @var SicknessAbstract */
    public $currentSickness = null;

    public function __construct($name = 'No name', $sickness = null)
    {
        parent::__construct();
        $this->name = $name;
        $this->sickness = new CList();
        $this->addSickness($sickness);
        $this->onToDoctor = [new Notifer(), 'toDoctor'];
        $this->onAlreadyInDoctor = [new Notifer(), 'alreadyInDoctor'];
    }

    public function toDoctor(Doctor $doctor)
    {
        $event = new CModelEvent($doctor);
        if ($doctor->queue->contains($this)) {
            //$this->setState(StateInterface::STATE_PATIENT_WAITING);
            $this->onAlreadyInDoctor($event);
        } else {
            $doctor->queue->enqueue($this);
            $this->setState(StateInterface::STATE_PATIENT_PROCESSING);
            $this->onToDoctor($event);
        }
        $doctor->setState(StateInterface::STATE_DOCTOR_BUSY);
        return $event->isValid;
    }

    public function onToDoctor($event)
    {
        $this->raiseEvent('onToDoctor', $event);
    }

    public function onAlreadyInDoctor($event)
    {
        $this->raiseEvent('onAlreadyInDoctor', $event);
    }

    /**
     * @param \SicknessAbstract $sickness
     */
    public function addSickness($sickness)
    {
        if ($sickness instanceof SicknessAbstract) {
            $this->sickness->add($sickness);
        }
    }

    /**
     * @param \SicknessAbstract $sickness
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
        return 'Patient <b>[' . $this->name . ']</b>';
    }

    public function card()
    {
        $sicknessNames = [];
        if ($this->sickness->count) {
            foreach ($this->sickness as $sickness) {
                /** @var SicknessAbstract $sickness */
                $sicknessNames[] = str_replace('Sickness\\', '', $sickness->getName());
            }
        }
        $sicknessNames = implode(', ', $sicknessNames);
        return <<<HTML
<table border="1" cellspacing="0" width="500px">
    <tr>
        <th>Patient Name</th><th>Sickness</th><th>State</th>
    </tr>
    <tr><td>{$this->getName()}</td><td>{$sicknessNames}</td><td>{$this->getState()}</td></tr>
</table>
HTML;
        //@todo табличка все время, но нет времени делать
    }

    /**
     * @return SicknessAbstract[]
     */
    public function getSickness()
    {
        return $this->sickness;
    }

    public function update()
    {
        echo 'updated' . $this->getName();
    }

}
