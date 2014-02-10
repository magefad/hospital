<?php
/**
 * Observer.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */


abstract class Observer implements SplObserver
{
    private $observable;

    function attach(Observable $observable)
    {
        $this->observable = $observable;
        $observable->attach($this);
    }

    function update(SplSubject $subject)
    {
        if($subject === $this->observable)
        {
            $this->doUpdate($subject);
        }
    }

    abstract function doUpdate(Observable $observable);

    /**
     * @return mixed
     */
    public function getObservable()
    {
        return $this->observable;
    }
}
