<?php

/**
 * This is the model class for table "chat".
 *
 * The followings are the available columns in table 'chat':
 * @property integer $chat_id
 * @property string $chat_from
 * @property string $chat_to
 * @property string $chat_message
 * @property string $chat_sent
 * @property integer $chat_recd
 */
class MOChat extends Chat
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOChat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}