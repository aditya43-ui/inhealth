<?php

/**
 * This is the model class for table "informasikamarinap_v".
 *
 * The followings are the available columns in table 'informasikamarinap_v':
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $ruangan_jenispelayanan
 * @property string $ruangan_lokasi
 * @property string $ruangan_singkatan
 * @property string $ruangan_fasilitas
 * @property string $ruangan_image
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $kelaspelayanan_namalainnya
 * @property boolean $kelaspelayanan_aktif
 * @property string $kamarruangan_nokamar
 * @property integer $kamarruangan_jmlbed
 * @property string $kamarruangan_nobed
 * @property boolean $kamarruangan_status
 * @property boolean $kamarruangan_aktif
 * @property string $kamarruangan_image
 */
class InformasikamarinapV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasikamarinapV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public $totalbed;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasikamarinap_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, instalasi_id, kelaspelayanan_id, kamarruangan_jmlbed', 'numerical', 'integerOnly'=>true),
			array('ruangan_nama, ruangan_namalainnya, ruangan_jenispelayanan, ruangan_lokasi, kelaspelayanan_nama, kelaspelayanan_namalainnya', 'length', 'max'=>50),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('ruangan_image, kamarruangan_image', 'length', 'max'=>100),
			array('kamarruangan_nokamar, kamarruangan_nobed', 'length', 'max'=>10),
			array('ruangan_fasilitas, kelaspelayanan_aktif, kamarruangan_status, kamarruangan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, instalasi_id, ruangan_nama, kamarruangan_id, ruangan_namalainnya, ruangan_jenispelayanan, ruangan_lokasi, ruangan_singkatan, ruangan_fasilitas, ruangan_image, kelaspelayanan_id, kelaspelayanan_nama, kelaspelayanan_namalainnya, kelaspelayanan_aktif, kamarruangan_nokamar, kamarruangan_jmlbed, kamarruangan_nobed, kamarruangan_status, kamarruangan_aktif, kamarruangan_image', 'safe', 'on'=>'search'),
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
                    'kamarruangan'=>array(self::HAS_MANY,'KamarruanganM','kamarruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ruangan_id' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_namalainnya' => 'Ruangan Namalainnya',
			'ruangan_jenispelayanan' => 'Ruangan Jenispelayanan',
			'ruangan_lokasi' => 'Ruangan Lokasi',
			'ruangan_singkatan' => 'Ruangan Singkatan',
			'ruangan_fasilitas' => 'Ruangan Fasilitas',
			'ruangan_image' => 'Ruangan Image',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'kelaspelayanan_namalainnya' => 'Kelaspelayanan Namalainnya',
			'kelaspelayanan_aktif' => 'Kelaspelayanan Aktif',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_jmlbed' => 'Kamarruangan Jmlbed',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'kamarruangan_status' => 'Kamarruangan Status',
			'kamarruangan_aktif' => 'Kamarruangan Aktif',
			'kamarruangan_image' => 'Kamarruangan Image',
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

		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruangan_namalainnya)',strtolower($this->ruangan_namalainnya),true);
		$criteria->compare('LOWER(ruangan_jenispelayanan)',strtolower($this->ruangan_jenispelayanan),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
		$criteria->compare('LOWER(ruangan_fasilitas)',strtolower($this->ruangan_fasilitas),true);
		$criteria->compare('LOWER(ruangan_image)',strtolower($this->ruangan_image),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('kelaspelayanan_aktif',$this->kelaspelayanan_aktif);
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('kamarruangan_jmlbed',$this->kamarruangan_jmlbed);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('kamarruangan_status',$this->kamarruangan_status);
		$criteria->compare('kamarruangan_aktif',$this->kamarruangan_aktif);
		$criteria->compare('LOWER(kamarruangan_image)',strtolower($this->kamarruangan_image),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruangan_namalainnya)',strtolower($this->ruangan_namalainnya),true);
		$criteria->compare('LOWER(ruangan_jenispelayanan)',strtolower($this->ruangan_jenispelayanan),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
		$criteria->compare('LOWER(ruangan_fasilitas)',strtolower($this->ruangan_fasilitas),true);
		$criteria->compare('LOWER(ruangan_image)',strtolower($this->ruangan_image),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('kelaspelayanan_aktif',$this->kelaspelayanan_aktif);
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('kamarruangan_jmlbed',$this->kamarruangan_jmlbed);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('kamarruangan_status',$this->kamarruangan_status);
		$criteria->compare('kamarruangan_aktif',$this->kamarruangan_aktif);
		$criteria->compare('LOWER(kamarruangan_image)',strtolower($this->kamarruangan_image),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}