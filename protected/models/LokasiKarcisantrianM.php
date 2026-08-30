<?php

/**
 * This is the model class for table "lokasi_karcisantrian_m".
 *
 * The followings are the available columns in table 'lokasi_karcisantrian_m':
 * @property integer $lokasi_karcisantrian_id
 * @property string $lokasi_karcisantrian_nama
 * @property string $keterangan
 * @property boolean $lokasi_karcisantrian_aktif
 */
class LokasiKarcisantrianM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LokasiKarcisantrianM the static model class
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
		return 'lokasi_karcisantrian_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lokasi_karcisantrian_nama', 'length', 'max'=>150),
			array('set_antrian, lokasi_karcisantrian_judul, lokasi_karcisantrian_tinggitombol, lokasi_karcisantrian_lebartombol,keterangan, lokasi_karcisantrian_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lokasi_karcisantrian_id, lokasi_karcisantrian_nama, keterangan, lokasi_karcisantrian_aktif', 'safe', 'on'=>'search'),
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
			'lokasi_karcisantrian_id' => 'Lokasi Karcisantrian',
			'lokasi_karcisantrian_nama' => 'Lokasi Karcis Antrian',
			'keterangan' => 'Keterangan',
                        'lokasi_karcisantrian_judul' => 'Judul',
			'lokasi_karcisantrian_aktif' => 'Status',
                        'lokasi_karcisantrian_lebartombol' => 'Lebar Tombol',
                        'lokasi_karcisantrian_tinggitombol' => 'Tinggi Tombol',
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

		$criteria->compare('lokasi_karcisantrian_id',$this->lokasi_karcisantrian_id);
		$criteria->compare('LOWER(lokasi_karcisantrian_nama)', strtolower($this->lokasi_karcisantrian_nama),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('LOWER(lokasi_karcisantrian_judul)', strtolower($this->lokasi_karcisantrian_judul),true);                

		if(isset($this->lokasi_karcisantrian_aktif)) {
			$criteria->compare('lokasi_karcisantrian_aktif', $this->lokasi_karcisantrian_aktif);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lokasi_karcisantrian_id',$this->lokasi_karcisantrian_id);
		$criteria->compare('LOWER(lokasi_karcisantrian_nama)', strtolower($this->lokasi_karcisantrian_nama),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('LOWER(lokasi_karcisantrian_judul)', strtolower($this->lokasi_karcisantrian_judul),true);                

		if(isset($this->lokasi_karcisantrian_aktif)) {
			$criteria->compare('lokasi_karcisantrian_aktif', $this->lokasi_karcisantrian_aktif);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}
}