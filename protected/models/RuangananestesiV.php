<?php

/**
 * This is the model class for table "ruangananestesi_v".
 *
 * The followings are the available columns in table 'ruangananestesi_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $ruangan_singkatan
 * @property boolean $ruangan_aktif
 * @property integer $riwayatruangan_id
 * @property string $ruangan_jenispelayanan
 * @property string $ruangan_fasilitas
 * @property string $ruangan_lokasi
 * @property string $ruangan_image
 */
class RuangananestesiV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ruangananestesi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, riwayatruangan_id', 'numerical', 'integerOnly'=>true),
			array('instalasi_nama, ruangan_nama, ruangan_namalainnya, ruangan_jenispelayanan, ruangan_lokasi', 'length', 'max'=>50),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('ruangan_image', 'length', 'max'=>100),
			array('ruangan_aktif, ruangan_fasilitas', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, ruangan_namalainnya, ruangan_singkatan, ruangan_aktif, riwayatruangan_id, ruangan_jenispelayanan, ruangan_fasilitas, ruangan_lokasi, ruangan_image', 'safe', 'on'=>'search'),
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_namalainnya' => 'Ruangan Namalainnya',
			'ruangan_singkatan' => 'Ruangan Singkatan',
			'ruangan_aktif' => 'Ruangan Aktif',
			'riwayatruangan_id' => 'Riwayatruangan',
			'ruangan_jenispelayanan' => 'Ruangan Jenispelayanan',
			'ruangan_fasilitas' => 'Ruangan Fasilitas',
			'ruangan_lokasi' => 'Ruangan Lokasi',
			'ruangan_image' => 'Ruangan Image',
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

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_namalainnya',$this->ruangan_namalainnya,true);
		$criteria->compare('ruangan_singkatan',$this->ruangan_singkatan,true);
		$criteria->compare('ruangan_aktif',$this->ruangan_aktif);
		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('ruangan_jenispelayanan',$this->ruangan_jenispelayanan,true);
		$criteria->compare('ruangan_fasilitas',$this->ruangan_fasilitas,true);
		$criteria->compare('ruangan_lokasi',$this->ruangan_lokasi,true);
		$criteria->compare('ruangan_image',$this->ruangan_image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RuangananestesiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
