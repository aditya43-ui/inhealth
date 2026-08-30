<?php

/**
 * This is the model class for table "laporanrekapumuraset_v".
 *
 * The followings are the available columns in table 'laporanrekapumuraset_v':
 * @property integer $lokasi_id
 * @property string $lokasiaset_namalokasi
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $gedung_id
 * @property string $gedung_nama
 * @property string $range1
 * @property string $range2
 * @property string $range3
 * @property string $range4
 * @property string $range5
 */
class LaporanrekapumurasetV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrekapumurasetV the static model class
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
		return 'laporanrekapumuraset_v';
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
			array('range1, range2, range3, range4, range5', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lokasi_id, lokasiaset_namalokasi, ruangan_id, ruangan_nama, gedung_id, gedung_nama, range1, range2, range3, range4, range5', 'safe', 'on'=>'search'),
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
			'range1' => 'Range1',
			'range2' => 'Range2',
			'range3' => 'Range3',
			'range4' => 'Range4',
			'range5' => 'Range5',
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
		$criteria->compare('range1',$this->range1,true);
		$criteria->compare('range2',$this->range2,true);
		$criteria->compare('range3',$this->range3,true);
		$criteria->compare('range4',$this->range4,true);
		$criteria->compare('range5',$this->range5,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}