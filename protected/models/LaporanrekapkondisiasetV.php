<?php

/**
 * This is the model class for table "laporanrekapkondisiaset_v".
 *
 * The followings are the available columns in table 'laporanrekapkondisiaset_v':
 * @property integer $lokasi_id
 * @property string $lokasiaset_namalokasi
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $gedung_id
 * @property string $gedung_nama
 * @property string $baik_medik
 * @property string $rusakringan_medik
 * @property string $rusakberat_medik
 * @property string $baik_nonmedik
 * @property string $rusakringan_nonmedik
 * @property string $rusakberat_nonmedik
 */
class LaporanrekapkondisiasetV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrekapkondisiasetV the static model class
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
		return 'laporanrekapkondisiaset_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lokasi_id, ruangan_id, gedung_id', 'numerical', 'integerOnly'=>true),
			array('lokasiaset_namalokasi, gedung_nama', 'length', 'max'=>100),
			array('ruangan_nama', 'length', 'max'=>50),
			array('baik_medik, rusakringan_medik, rusakberat_medik, baik_nonmedik, rusakringan_nonmedik, rusakberat_nonmedik', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lokasi_id, lokasiaset_namalokasi, ruangan_id, ruangan_nama, gedung_id, gedung_nama, baik_medik, rusakringan_medik, rusakberat_medik, baik_nonmedik, rusakringan_nonmedik, rusakberat_nonmedik', 'safe', 'on'=>'search'),
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
			'lokasi_id' => 'Lokasi',
			'lokasiaset_namalokasi' => 'Lokasiaset Namalokasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'gedung_id' => 'Gedung',
			'gedung_nama' => 'Gedung Nama',
			'baik_medik' => 'Baik Medik',
			'rusakringan_medik' => 'Rusakringan Medik',
			'rusakberat_medik' => 'Rusakberat Medik',
			'baik_nonmedik' => 'Baik Nonmedik',
			'rusakringan_nonmedik' => 'Rusakringan Nonmedik',
			'rusakberat_nonmedik' => 'Rusakberat Nonmedik',
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

		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('lokasiaset_namalokasi',$this->lokasiaset_namalokasi,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('gedung_id',$this->gedung_id);
		$criteria->compare('gedung_nama',$this->gedung_nama,true);
		$criteria->compare('baik_medik',$this->baik_medik,true);
		$criteria->compare('rusakringan_medik',$this->rusakringan_medik,true);
		$criteria->compare('rusakberat_medik',$this->rusakberat_medik,true);
		$criteria->compare('baik_nonmedik',$this->baik_nonmedik,true);
		$criteria->compare('rusakringan_nonmedik',$this->rusakringan_nonmedik,true);
		$criteria->compare('rusakberat_nonmedik',$this->rusakberat_nonmedik,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}