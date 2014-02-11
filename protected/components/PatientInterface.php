<?php
/**
 * PatientInterface.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
 

interface PatientInterface {
    public function __construct($name = 'No name', $sickness);

    public function addSickness($sicknessName);

    public function removeSickness($sickness);
}