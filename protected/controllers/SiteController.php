<?php

class SiteController extends CController
{
    public function actionTest()
    {
        echo '<pre>';
        Yii::setPathOfAlias('Sickness', Yii::getPathOfAlias('application.models.Sickness'));

        $hospital = new Hospital(); //первоначальные данные в конструкторе
        $hospital->statistics(); // исходные данные
        $hospital->open(); //запись к врачам через терапевта
        $hospital->working(); //врачи лечат

        $hospital->statistics();
    }
}
