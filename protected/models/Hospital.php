<?php
use Doctor\Therapeutist;

/**
 * Hospital.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
 

class Hospital implements HospitalInterface {
   public static $doctorClasses = ['Oculist', 'Otorhinolaryngologist', 'Therapeutist'];

    /** @var Patient[] */
    private $patient;

    /** @var Doctor[] */
    private $doctor;

    /** @var Sickness[] */
    private $sickness;

    public function __construct()
    {
        $this->patient = new CList();
        $this->doctor = new CList();

        $patientSickness = [
            'Bregnev'  => ['Eyesight'],
            'Pugachev' => ['Ear', 'Throat'],
            'Ivanov'   => ['Head', 'Throat'],
            'Bolnoy'   => ['Head'],
            'Babushka' => ['Ear', 'Eyesight', 'Throat', 'Head'],
        ];

        foreach ($patientSickness as $name => $sickness) {
            $patient = new Patient($name);
            foreach ($sickness as $sicknessName) {
                $patient->addSickness($sicknessName);
            }
            $this->patient->add($patient);
        }

        foreach (self::$doctorClasses as $doctorType) {
            $this->doctor->add(Doctor::create($doctorType));
        }
    }

    public function open()
    {
        echo PHP_EOL . '____________________Attach patients to doctors_________________________' . PHP_EOL;
        $therapeutist = $this->getTherapeutist();
        echo $therapeutist->getName() . ' gives directions...........................' . PHP_EOL;
        foreach ($this->getPatientByStatus() as $patient) {
            $therapeutist->getDirectForPatient($patient, $this->doctor);
        }
    }

    public function working()
    {
        echo PHP_EOL . '___________________________WORKING________________________________';
        echo PHP_EOL . 'Patient List.......................................................' . PHP_EOL;

        foreach ($this->getDoctorByStatus(Doctor::STATE_DOCTOR_WITH_PATIENT) as $doctor) {
            $doctor->treatPatient()->toDoctor($this->getTherapeutist()); // для выдачи справок направляем к терапевту
        }
    }

    public function statistics()
    {
        echo PHP_EOL . '__________________________STATISTICS______________________________';
        echo PHP_EOL . 'Patient List.......................................................' . PHP_EOL;
        foreach ($this->patient as $patient) {
            echo $patient->card() . PHP_EOL . PHP_EOL;
        }

        echo PHP_EOL . 'Doctor List........................................................' . PHP_EOL;
        foreach ($this->doctor as $doctor) {
            echo $doctor->getName() . "\t";
            echo $doctor->getState() . "\t";
            echo $doctor->hasPatient() ? $doctor->getCurrentPatient()->getName() : '';
            echo PHP_EOL;
        }
        //echo '_______________________________________________________________________' . PHP_EOL;
    }

    /**
     * @return Therapeutist|null
     */
    protected function getTherapeutist()
    {
        foreach ($this->doctor as $doctor) {
            if ($doctor::IS_THERAPEUTIST) {
                return $doctor;
            }
        }
        return null;
    }

    /**
     * @param string $state
     * @return Patient[]
     */
    protected function getPatientByStatus($state = StateInterface::STATE_PATIENT_NEW)
    {
        $patients = [];
        foreach ($this->patient as $patient) {
            if ($patient->getState() == $state) {
                $patients[] = $patient;
            }
        }
        return $patients;
    }

    /**
     * @param string $state
     * @return Doctor[]
     */
    protected function getDoctorByStatus($state = StateInterface::STATE_DOCTOR_WAITING_PATIENT)
    {
        $doctors = [];
        foreach ($this->doctor as $doctor) {
            if ($doctor->getState() == $state) {
                $doctors[] = $doctor;
            }
        }
        return $doctors;
    }
} 