<?php
/**
 * HospitalInterface.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
 

interface HospitalInterface {
    const FIRST_DOCTOR_CLASS = 'Therapeutist';

    public function open();
    public function statistics();
}