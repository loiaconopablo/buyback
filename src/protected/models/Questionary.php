<?php

Yii::import('application.models._base.BaseQuestionary');

class Questionary extends BaseQuestionary
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}