<?php

/**
 * This is the model class for table "laporanklasifikasiasa_v".
 *
 * The followings are the available columns in table 'laporanklasifikasiasa_v':
 * @property string $tgl_laporan
 * @property integer $typeanastesi_id
 * @property string $typeanastesi_nama
 * @property integer $total
 */
class LaporanklasifikasiasaV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanklasifikasiasaV the static model class
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
		return 'laporanklasifikasiasa_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeanastesi_id, total', 'numerical', 'integerOnly'=>true),
			array('typeanastesi_nama', 'length', 'max'=>500),
			array('tgl_laporan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_laporan, typeanastesi_id, typeanastesi_nama, total', 'safe', 'on'=>'search'),
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
			'tgl_laporan' => 'Tgl Laporan',
			'typeanastesi_id' => 'Typeanastesi',
			'typeanastesi_nama' => 'Typeanastesi Nama',
			'total' => 'Total',
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

		$criteria->compare('tgl_laporan',$this->tgl_laporan,true);
		$criteria->compare('typeanastesi_id',$this->typeanastesi_id);
		$criteria->compare('typeanastesi_nama',$this->typeanastesi_nama,true);
		$criteria->compare('total',$this->total);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}