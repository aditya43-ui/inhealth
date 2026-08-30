<?php

/**
 * This is the model class for table "kriteriahasildet_m".
 *
 * The followings are the available columns in table 'kriteriahasildet_m':
 * @property integer $kriteriahasildet_id
 * @property integer $kriteriahasil_id
 * @property string $kriteriahasildet_indikator
 * @property boolean $kriteriahasildet_aktif
 *
 * The followings are the available model relations:
 * @property PilihrencanaaskepT[] $pilihrencanaaskepTs
 * @property KriteriahasilM $kriteriahasil
 */
class KriteriahasildetM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KriteriahasildetM the static model class
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
		return 'kriteriahasildet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kriteriahasil_id, kriteriahasildet_indikator, kriteriahasildet_aktif', 'required'),
			array('kriteriahasil_id, kriteriahasil_daftar_id', 'numerical', 'integerOnly'=>true),
			array('kriteriahasildet_indikator', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kriteriahasildet_id, kriteriahasil_id, kriteriahasildet_indikator, kriteriahasildet_aktif', 'safe', 'on'=>'search'),
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
			'pilihrencanaaskepTs' => array(self::HAS_MANY, 'PilihrencanaaskepT', 'kriteriahasildet_id'),
			'kriteriahasil' => array(self::BELONGS_TO, 'KriteriahasilM', 'kriteriahasil_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kriteriahasildet_id' => 'Kriteriahasildet',
			'kriteriahasil_id' => 'Kriteriahasil',
			'kriteriahasildet_indikator' => 'Kriteriahasildet Indikator',
			'kriteriahasildet_aktif' => 'Kriteriahasildet Aktif',
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

		$criteria->compare('kriteriahasildet_id',$this->kriteriahasildet_id);
		$criteria->compare('kriteriahasil_id',$this->kriteriahasil_id);
		$criteria->compare('kriteriahasildet_indikator',$this->kriteriahasildet_indikator,true);
		$criteria->compare('kriteriahasildet_aktif',$this->kriteriahasildet_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}