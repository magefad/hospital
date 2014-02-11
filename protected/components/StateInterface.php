<?php
/**
 * StateInterface.php class file.
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */


interface StateInterface {
    const STATE_PATIENT_NEW            = 'new patient            ';
    const STATE_PATIENT_WAITING        = 'waiting................';
    const STATE_PATIENT_WAITING_DOCTOR = 'waiting for free doctor';
    const STATE_PATIENT_PROCESSING     = 'at the doctor..........';
    const STATE_PATIENT_NO_DOCTOR      = 'no doctor..............';

    const STATE_DOCTOR_WITH_PATIENT    = 'attached with patient';
    const STATE_DOCTOR_WAITING_PATIENT = 'waiting patient......';

    public function setState($state);

    public function getState();
}
