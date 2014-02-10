<?php
/**
 * Notifer.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2014 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
 

class Notifer {
    public function toDoctor(CEvent $event)
    {
        $count = $event->sender->queue->getCount() - 1;
        $type = $count === 0 ? ' going ' : " queue ({$count})";
        echo ' &nbsp;&nbsp;' . $type . $event->sender->getName() . '</b><br />';
    }

    public function alreadyInDoctor(CEvent $event)
    {
        echo ' &nbsp;&nbsp;already in queue ' . $event->sender->getName() . '</b><br />';
    }
} 