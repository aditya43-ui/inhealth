<?php

/**
 * This is the model class for table "laporanteknikanestesi_v".
 *
 * The followings are the available columns in table 'laporanteknikanestesi_v':
 * @property string $tgl_tindakananestesi
 * @property integer $anastesi_id
 * @property string $anastesi_nama
 * @property integer $jenisanastesi_id
 * @property string $jenisanastesi_nama
 * @property integer $total
 */
class LaporanteknikanestesiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanteknikanestesiV the static model class
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
		return 'laporanteknikanestesi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('anastesi_id, jenisanastesi_id, total', 'numerical', 'integerOnly'=>true),
			array('anastesi_nama, jenisanastesi_nama', 'length', 'max'=>50),
			array('tgl_tindakananestesi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_tindakananestesi, anastesi_id, anastesi_nama, jenisanastesi_id, jenisanastesi_nama, total', 'safe', 'on'=>'search'),
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
			'tgl_tindakananestesi' => 'Tgl Tindakananestesi',
			'anastesi_id' => 'Anastesi',
			'anastesi_nama' => 'Anastesi Nama',
			'jenisanastesi_id' => 'Jenisanastesi',
			'jenisanastesi_nama' => 'Jenisanastesi Nama',
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

		$criteria->compare('tgl_tindakananestesi',$this->tgl_tindakananestesi,true);
		$criteria->compare('anastesi_id',$this->anastesi_id);
		$criteria->compare('anastesi_nama',$this->anastesi_nama,true);
		$criteria->compare('jenisanastesi_id',$this->jenisanastesi_id);
		$criteria->compare('jenisanastesi_nama',$this->jenisanastesi_nama,true);
		$criteria->compare('total',$this->total);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}