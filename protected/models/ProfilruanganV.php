<?php

/**
 * This is the model class for table "profilruangan_v".
 *
 * The followings are the available columns in table 'profilruangan_v':
 * @property string $hari
 * @property string $jmabuka
 * @property string $jammulai
 * @property string $jamtutup
 * @property integer $maxantiranpoli
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $kelaspelayanan_namalainnya
 * @property integer $jeniskelas_id
 * @property string $jeniskelas_nama
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property string $ruangan_jenispelayanan
 * @property string $ruangan_namalainnya
 * @property string $ruangan_lokasi
 * @property boolean $ruangan_aktif
 * @property string $ruangan_singkatan
 * @property integer $riwayatruangan_id
 * @property string $ruangan_fasilitas
 * @property string $ruangan_image
 * @property string $Map_Warna
 * @property string $Map_Kode_Warna
 */
class ProfilruanganV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfilruanganV the static model class
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
		return 'profilruangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('maxantiranpoli, kelaspelayanan_id, jeniskelas_id, ruangan_id, instalasi_id, riwayatruangan_id', 'numerical', 'integerOnly'=>true),
			array('hari', 'length', 'max'=>20),
			array('jmabuka, kelaspelayanan_nama, kelaspelayanan_namalainnya, ruangan_nama, ruangan_jenispelayanan, ruangan_namalainnya, ruangan_lokasi, Map_Warna', 'length', 'max'=>50),
			array('jeniskelas_nama', 'length', 'max'=>25),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('ruangan_image, Map_Kode_Warna', 'length', 'max'=>100),
			array('jammulai, jamtutup, ruangan_aktif, ruangan_fasilitas', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hari, jmabuka, jammulai, jamtutup, maxantiranpoli, kelaspelayanan_id, kelaspelayanan_nama, kelaspelayanan_namalainnya, jeniskelas_id, jeniskelas_nama, ruangan_id, instalasi_id, ruangan_nama, ruangan_jenispelayanan, ruangan_namalainnya, ruangan_lokasi, ruangan_aktif, ruangan_singkatan, riwayatruangan_id, ruangan_fasilitas, ruangan_image, Map_Warna, Map_Kode_Warna', 'safe', 'on'=>'search'),
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
                                    'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hari' => 'Hari',
			'jmabuka' => 'Jmabuka',
			'jammulai' => 'Jammulai',
			'jamtutup' => 'Jamtutup',
			'maxantiranpoli' => 'Maxantiranpoli',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'kelaspelayanan_namalainnya' => 'Kelaspelayanan Namalainnya',
			'jeniskelas_id' => 'Jeniskelas',
			'jeniskelas_nama' => 'Jeniskelas Nama',
			'ruangan_id' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_jenispelayanan' => 'Ruangan Jenispelayanan',
			'ruangan_namalainnya' => 'Ruangan Namalainnya',
			'ruangan_lokasi' => 'Ruangan Lokasi',
			'ruangan_aktif' => 'Ruangan Aktif',
			'ruangan_singkatan' => 'Ruangan Singkatan',
			'riwayatruangan_id' => 'Riwayatruangan',
			'ruangan_fasilitas' => 'Ruangan Fasilitas',
			'ruangan_image' => 'Ruangan Image',
			'Map_Warna' => 'Map Warna',
			'Map_Kode_Warna' => 'Map Kode Warna',
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

		$criteria->compare('LOWER(hari)',strtolower($this->hari),true);
		$criteria->compare('LOWER(jmabuka)',strtolower($this->jmabuka),true);
		$criteria->compare('LOWER(jammulai)',strtolower($this->jammulai),true);
		$criteria->compare('LOWER(jamtutup)',strtolower($this->jamtutup),true);
		$criteria->compare('maxantiranpoli',$this->maxantiranpoli);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruangan_jenispelayanan)',strtolower($this->ruangan_jenispelayanan),true);
		$criteria->compare('LOWER(ruangan_namalainnya)',strtolower($this->ruangan_namalainnya),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('ruangan_aktif',$this->ruangan_aktif);
		$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(ruangan_fasilitas)',strtolower($this->ruangan_fasilitas),true);
		$criteria->compare('LOWER(ruangan_image)',strtolower($this->ruangan_image),true);
		$criteria->compare('LOWER(Map_Warna)',strtolower($this->Map_Warna),true);
		$criteria->compare('LOWER(Map_Kode_Warna)',strtolower($this->Map_Kode_Warna),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('LOWER(hari)',strtolower($this->hari),true);
		$criteria->compare('LOWER(jmabuka)',strtolower($this->jmabuka),true);
		$criteria->compare('LOWER(jammulai)',strtolower($this->jammulai),true);
		$criteria->compare('LOWER(jamtutup)',strtolower($this->jamtutup),true);
		$criteria->compare('maxantiranpoli',$this->maxantiranpoli);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruangan_jenispelayanan)',strtolower($this->ruangan_jenispelayanan),true);
		$criteria->compare('LOWER(ruangan_namalainnya)',strtolower($this->ruangan_namalainnya),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('ruangan_aktif',$this->ruangan_aktif);
		$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(ruangan_fasilitas)',strtolower($this->ruangan_fasilitas),true);
		$criteria->compare('LOWER(ruangan_image)',strtolower($this->ruangan_image),true);
		$criteria->compare('LOWER(Map_Warna)',strtolower($this->Map_Warna),true);
		$criteria->compare('LOWER(Map_Kode_Warna)',strtolower($this->Map_Kode_Warna),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}