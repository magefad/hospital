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

        $hospital = new Hospital();//первоначальные данные в конструкторе
        $hospital->statistics();
        $hospital->open();
        $hospital->working();

        $hospital->statistics();
        //Когда принимает терапевт, к нему идут все за направлением или справкой.
        //Если у пациента заболевание, не относящееся к текущему врачу, то он ждет нужного специалиста.

	}
}
