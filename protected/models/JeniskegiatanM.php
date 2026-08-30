<?php

/**
 * This is the model class for table "jeniskegiatan_m".
 *
 * The followings are the available columns in table 'jeniskegiatan_m':
 * @property integer $jeniskegiatan_id
 * @property string $jeniskegiatan_kode
 * @property string $jeniskegiatan_nama
 * @property boolean $jeniskegiatan_aktif
 * @property string $jeniskegiatan_ruangan
 *
 * The followings are the available model relations:
 * @property DaftartindakanM[] $daftartindakanMs
 */
class JeniskegiatanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JeniskegiatanM the static model class
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
		return 'jeniskegiatan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskegiatan_nama, jeniskegiatan_ruangan', 'required'),
			array('jeniskegiatan_kode', 'length', 'max'=>25),
			array('jeniskegiatan_nama', 'length', 'max'=>100),
			array('jeniskegiatan_ruangan', 'length', 'max'=>50),
			array('jeniskegiatan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jeniskegiatan_id, jeniskegiatan_kode, jeniskegiatan_nama, jeniskegiatan_aktif, jeniskegiatan_ruangan', 'safe', 'on'=>'search'),
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
			'daftartindakanMs' => array(self::HAS_MANY, 'DaftartindakanM', 'jeniskegiatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jeniskegiatan_id' => 'ID',
			'jeniskegiatan_kode' => 'Kode Jenis Kegiatan',
			'jeniskegiatan_nama' => 'Nama Jenis Kegiatan',
			'jeniskegiatan_aktif' => 'Aktif',
			'jeniskegiatan_ruangan' => 'Ruang Jenis Kegiatan',
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

		$criteria->compare('jeniskegiatan_id',$this->jeniskegiatan_id);
		$criteria->compare('LOWER(jeniskegiatan_kode)',  strtolower($this->jeniskegiatan_kode),true);
		$criteria->compare('LOWER(jeniskegiatan_nama)',strtolower($this->jeniskegiatan_nama),true);
		$criteria->compare('jeniskegiatan_aktif',$this->jeniskegiatan_aktif);
		$criteria->compare('LOWER(jeniskegiatan_ruangan)',$this->jeniskegiatan_ruangan,true);
                $criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jeniskegiatan_id',$this->jeniskegiatan_id);
		$criteria->compare('LOWER(jeniskegiatan_kode)',  strtolower($this->jeniskegiatan_kode),true);
		$criteria->compare('LOWER(jeniskegiatan_nama)',strtolower($this->jeniskegiatan_nama),true);
		$criteria->compare('jeniskegiatan_aktif',$this->jeniskegiatan_aktif);
		$criteria->compare('LOWER(jeniskegiatan_ruangan)',$this->jeniskegiatan_ruangan,true);
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false
		));
	}
}