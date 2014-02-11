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
        /** @var Patient $patient */
        $patient = $event->sender->queue->end();
        $count = $event->sender->queue->getCount() - 1;
        $type = $count === 0 ? ' => ' : " queue ({$count}) ";
        echo ' ' . $patient->getName() . "\t" . $type . $event->sender->getName() . ' with [' . $patient->currentSickness->getName() . ']' . PHP_EOL;
    }

    public function alreadyAtDoctor(CEvent $event)
    {
        /** @var Patient $patient */
        #$patient = $event->sender->queue->end();
        $count = $event->sender->queue->getCount() - 1;
        $type = $count == 0 ? '=>' : 'in queue (' . $count . ')';
        echo ' ' /*. $patient->getName()*/ . "\t already {$type} to " . $event->sender->getName() . PHP_EOL;
    }

    public function noDoctor(CEvent $event)
    {
        echo "\t No doctor for " . $event->sender->getName() . PHP_EOL;
    }
}
