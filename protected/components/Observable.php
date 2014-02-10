<?php
/**
 * Observable.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */


/**
 * В PHP осуществляется встроенная поддержка этого шаблона через входящее в поставку
 * расширение SPL (Standard PHP Library):
 * SplObserver - интерфейс для Observer (наблюдателя),
 * SplSubject - интерфейс Observable (наблюдаемого),
 * SplObjectStorage - вспомогательный класс (обеспечивает улучшенное сохранение и удаление
 * объектов, в частности, реализованы методы attach() и detach()).
 */
class Observable implements SplSubject
{
    private $storage;
    function __construct()
    {
        $this->storage = new SplObjectStorage();
    }

    function attach(SplObserver $observer)
    {
        $this->storage->attach($observer);
    }

    function detach(SplObserver $observer)
    {
        $this->storage->detach($observer);
    }

    function notify()
    {
        foreach($this->storage as $obj)
        {
            /** @var $obj Observer */
            $obj->update($this);
        }
    }
    //...
}