<?php

/**
 * This is the model class for table "postgambar_m".
 *
 * The followings are the available columns in table 'postgambar_m':
 * @property integer $postgambar_id
 * @property integer $post_id
 * @property integer $update_loginpemakai_id
 * @property string $pathgambar
 */
class PostgambarM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PostgambarM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'postgambar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('post_id', 'required'),
			array('post_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('pathgambar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('postgambar_id, post_id, update_loginpemakai_id, pathgambar', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'postgambar_id' => 'Postgambar',
			'post_id' => 'Post',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'pathgambar' => 'Pathgambar',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('postgambar_id',$this->postgambar_id);
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('pathgambar',$this->pathgambar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}