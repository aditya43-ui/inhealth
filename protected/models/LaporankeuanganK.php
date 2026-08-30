<?php

/**
 * This is the model class for table "laporankeuangan_k".
 *
 * The followings are the available columns in table 'laporankeuangan_k':
 * @property integer $laporankeuangan_id
 * @property integer $menu_id
 * @property string $menu_url
 * @property string $keterangan
 * @property string $levelrek
 *
 * The followings are the available model relations:
 * @property MenumodulK $menu
 */
class LaporankeuanganK extends CActiveRecord
{
	public $menu_nama;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporankeuangan_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_id', 'numerical', 'integerOnly'=>true),
			array('menu_url', 'length', 'max'=>100),
			array('keterangan, levelrek', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('laporankeuangan_id, menu_id, menu_url, keterangan, levelrek', 'safe', 'on'=>'search'),
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
			'menu' => array(self::BELONGS_TO, 'MenumodulK', 'menu_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'laporankeuangan_id' => 'Laporankeuangan',
			'menu_id' => 'Nama Menu',
			'menu_url' => 'URL Menu',
			'keterangan' => 'Keterangan',
			'levelrek' => 'Level Rekening',
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
		$criteria->with = array('menu');
		$criteria->compare('lower(menu.menu_nama)',strtolower($this->menu_nama),true);
		$criteria->compare('lower(t.menu_url)',strtolower($this->menu_url),true);
		$criteria->compare('lower(t.keterangan)',strtolower($this->keterangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('menu');
		$criteria->compare('lower(menu.menu_nama)',strtolower($this->menu_nama),true);
		$criteria->compare('lower(t.menu_url)',strtolower($this->menu_url),true);
		$criteria->compare('lower(t.keterangan)',strtolower($this->keterangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LaporankeuanganK the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
