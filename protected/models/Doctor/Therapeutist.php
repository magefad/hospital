<?php
/**
 * Therapeutist.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
 

namespace Doctor;


class Therapeutist extends \Doctor {
    const IS_THERAPEUTIST = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function send()
    {

    }

    public function getDirectForPatient(\Patient $patient, \CList $doctor)
    {
        echo PHP_EOL . $this->getName() . ' <- ' . $patient->getName() . PHP_EOL;
        foreach ($patient->getSickness() as $sickness) {
            /** @var \Doctor $doc */
            foreach ($doctor as $doc) {
                foreach ($doc->getSickness() as $dSickness) {
                    if ($sickness == $dSickness) {
                        $patient->currentSickness = $sickness;
                        $patient->toDoctor($doc);
                        /*$patient->currentSickness = $sickness;
                        if (!$doc->attach($patient)) {
                            $patient->currentSickness = null;
                            echo '// <b>[' . $doc->getName() . '</b>] already with patient <b>' . $doc->getCurrentPatient()->getName() . '</b><br />';
                            $patient->setState(\StateInterface::STATE_PATIENT_WAITING);
                        }*/
                    }
                }
            }
            //print_r($patient);
            if (!$patient->currentSickness) {
                //echo 'No specialist for <b>[' . $patient->getName() . ']</b><br />';
            }
        }
    }
}
