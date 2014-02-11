<?php

class SiteController extends CController
{
    /**
     * This is the default action that displays the phonebook Flex client.
     */
    public function actionIndex()
    {
        $this->render('index');
    }

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
