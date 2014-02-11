<?php
/**
 * Sickness.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
 

class Sickness implements SicknessInterface {
    public function getName()
    {
        return __CLASS__;
    }

    /**
     * @param string $type class name
     * @return mixed
     * @throws CException
     */
    public static function create($type)
    {
        $className = '\Sickness\\' . $type;
        if (class_exists($className)) { // @todo проверка
            /** @var Sickness $d */
            $s = new $className;
            return $s;
        }
        throw new CException('No ' . $type . ' sickness');
    }
}
