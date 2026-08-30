<?php

/**
 * This is the model class for table "pengadaanjadwalpemeriksaandet_t".
 *
 * The followings are the available columns in table 'pengadaanjadwalpemeriksaandet_t':
 * @property integer $pengadaanjadwalpemeriksaandet_id
 * @property integer $pengadaanjadwalpemeriksaan_id
 * @property integer $pegpemeriksa_id
 *
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 * The followings are the available model relations:
 * @property PegawaiM $pegpemeriksa
 * @property PengadaanjadwalpemeriksaanT $pengadaanjadwalpemeriksaan
 */
class PengadaanjadwalpemeriksaandetT extends CActiveRecord
{
        public $pegpemeriksa_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengadaanjadwalpemeriksaandetT the static model class
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
		return 'pengadaanjadwalpemeriksaandet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengadaanjadwalpemeriksaan_id, pegpemeriksa_id', 'required'),
			array('pengadaanjadwalpemeriksaan_id, pegpemeriksa_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengadaanjadwalpemeriksaandet_id, pengadaanjadwalpemeriksaan_id, pegpemeriksa_id', 'safe', 'on'=>'search'),
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
			'pegpemeriksa' => array(self::BELONGS_TO, 'PegawaiM', 'pegpemeriksa_id'),
			'pengadaanjadwalpemeriksaan' => array(self::BELONGS_TO, 'PengadaanjadwalpemeriksaanT', 'pengadaanjadwalpemeriksaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengadaanjadwalpemeriksaandet_id' => 'Pengadaanjadwalpemeriksaandet',
			'pengadaanjadwalpemeriksaan_id' => 'Pengadaanjadwalpemeriksaan',
			'pegpemeriksa_id' => 'Pegpemeriksa',
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

		$criteria->compare('pengadaanjadwalpemeriksaandet_id',$this->pengadaanjadwalpemeriksaandet_id);
		$criteria->compare('pengadaanjadwalpemeriksaan_id',$this->pengadaanjadwalpemeriksaan_id);
		$criteria->compare('pegpemeriksa_id',$this->pegpemeriksa_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}