<?php
error_reporting(E_ALL);
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once(dirname(__FILE__) . '/../yii/framework/yii.php');
Yii::createWebApplication(dirname(__FILE__) . '/protected/config/main.php')->run();
