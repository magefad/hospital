<?php
/**
 * Oculist.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
 

namespace Doctor;


use Sickness\Eyesight;

class Oculist extends \Doctor {
    public function __construct()
    {
        parent::__construct();
        $this->sickness->add(new Eyesight());
    }
} 