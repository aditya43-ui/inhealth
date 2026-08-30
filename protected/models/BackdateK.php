<?php

/**
 * This is the model class for table "backdate_k".
 *
 * The followings are the available columns in table 'backdate_k':
 * @property integer $backdate_id
 * @property integer $modul_id
 * @property string $deskripsi_menu
 * @property string $deskripsi_backdate
 * @property boolean $isbackdate
 */
class BackdateK extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'backdate_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('modul_id', 'required'),
			array('modul_id', 'numerical', 'integerOnly'=>true),
			array('deskripsi_menu, deskripsi_backdate, isbackdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('backdate_id, modul_id, deskripsi_menu, deskripsi_backdate, isbackdate', 'safe', 'on'=>'search'),
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
                    'modul' => array(self::BELONGS_TO, 'ModulK', 'modul_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'backdate_id' => 'Backdate',
			'modul_id' => 'Modul',
			'deskripsi_menu' => 'Deskripsi Menu',
			'deskripsi_backdate' => 'Deskripsi Backdate',
			'isbackdate' => 'Backdate ?',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('backdate_id',$this->backdate_id);
		$criteria->compare('modul_id',$this->modul_id);
		$criteria->compare('deskripsi_menu',$this->deskripsi_menu,true);
		$criteria->compare('deskripsi_backdate',$this->deskripsi_backdate,true);
		$criteria->compare('isbackdate',$this->isbackdate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BackdateK the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
