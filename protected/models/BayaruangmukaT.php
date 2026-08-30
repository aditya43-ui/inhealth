<?php

/**
 * This is the model class for table "bayaruangmuka_t".
 *
 * The followings are the available columns in table 'bayaruangmuka_t':
 * @property integer $bayaruangmuka_id
 * @property integer $pembatalanuangmuka_id
 * @property integer $pasienadmisi_id
 * @property integer $pemakaianuangmuka_id
 * @property integer $tandabuktibayar_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $tgluangmuka
 * @property double $jumlahuangmuka
 * @property string $keteranganuangmuka
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $tglperjanjian
 * @property string $keterangan_perjanjian
 * @property integer $pembayarankapitasidetail_id
 *
 * The followings are the available model relations:
 * @property PembatalanuangmukaT[] $pembatalanuangmukaTs
 * @property PembayarankapitasidetailT $pembayarankapitasidetail
 * @property PemakaianuangmukaT $pemakaianuangmuka
 * @property PembatalanuangmukaT $pembatalanuangmuka
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 * @property TandabuktibayarT $tandabuktibayar
 * @property TandabuktibayarT[] $tandabuktibayarTs
 * @property PemakaianuangmukaT[] $pemakaianuangmukaTs
 */
class BayaruangmukaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BayaruangmukaT the static model class
	 */
	public $longitude, $latitude,$longitude_kab, $latitude_kab;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bayaruangmuka_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pasien_id, pendaftaran_id, tgluangmuka, jumlahuangmuka, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pembatalanuangmuka_id, pasienadmisi_id, pemakaianuangmuka_id, tandabuktibayar_id, ruangan_id, pasien_id, pendaftaran_id, pembayarankapitasidetail_id', 'numerical', 'integerOnly'=>true),
			array('jumlahuangmuka', 'numerical'),
			array('keterangan_perjanjian', 'length', 'max'=>200),
			array('keteranganuangmuka, update_time, update_loginpemakai_id, tglperjanjian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bayaruangmuka_id, pembatalanuangmuka_id, pasienadmisi_id, pemakaianuangmuka_id, tandabuktibayar_id, ruangan_id, pasien_id, pendaftaran_id, tgluangmuka, jumlahuangmuka, keteranganuangmuka, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglperjanjian, keterangan_perjanjian, pembayarankapitasidetail_id', 'safe', 'on'=>'search'),
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
			'pembatalanuangmukaTs' => array(self::HAS_MANY, 'PembatalanuangmukaT', 'bayaruangmuka_id'),
			'pembayarankapitasidetail' => array(self::BELONGS_TO, 'PembayarankapitasidetailT', 'pembayarankapitasidetail_id'),
			'pemakaianuangmuka' => array(self::BELONGS_TO, 'PemakaianuangmukaT', 'pemakaianuangmuka_id'),
			'pembatalanuangmuka' => array(self::BELONGS_TO, 'PembatalanuangmukaT', 'pembatalanuangmuka_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'tandabuktibayar' => array(self::BELONGS_TO, 'TandabuktibayarT', 'tandabuktibayar_id'),
			'tandabuktibayarTs' => array(self::HAS_MANY, 'TandabuktibayarT', 'bayaruangmuka_id'),
			'pemakaianuangmukaTs' => array(self::HAS_MANY, 'PemakaianuangmukaT', 'bayaruangmuka_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bayaruangmuka_id' => 'Bayaruangmuka',
			'pembatalanuangmuka_id' => 'Pembatalanuangmuka',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pemakaianuangmuka_id' => 'Pemakaianuangmuka',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'tgluangmuka' => 'Tgluangmuka',
			'jumlahuangmuka' => 'Jumlahuangmuka',
			'keteranganuangmuka' => 'Keteranganuangmuka',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tglperjanjian' => 'Tglperjanjian',
			'keterangan_perjanjian' => 'Keterangan Perjanjian',
			'pembayarankapitasidetail_id' => 'Pembayarankapitasidetail',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->bayaruangmuka_id)){
			$criteria->addCondition('bayaruangmuka_id = '.$this->bayaruangmuka_id);
		}
		if(!empty($this->pembatalanuangmuka_id)){
			$criteria->addCondition('pembatalanuangmuka_id = '.$this->pembatalanuangmuka_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pemakaianuangmuka_id)){
			$criteria->addCondition('pemakaianuangmuka_id = '.$this->pemakaianuangmuka_id);
		}
		if(!empty($this->tandabuktibayar_id)){
			$criteria->addCondition('tandabuktibayar_id = '.$this->tandabuktibayar_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(tgluangmuka)',strtolower($this->tgluangmuka),true);
		$criteria->compare('jumlahuangmuka',$this->jumlahuangmuka);
		$criteria->compare('LOWER(keteranganuangmuka)',strtolower($this->keteranganuangmuka),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(tglperjanjian)',strtolower($this->tglperjanjian),true);
		$criteria->compare('LOWER(keterangan_perjanjian)',strtolower($this->keterangan_perjanjian),true);
		if(!empty($this->pembayarankapitasidetail_id)){
			$criteria->addCondition('pembayarankapitasidetail_id = '.$this->pembayarankapitasidetail_id);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}