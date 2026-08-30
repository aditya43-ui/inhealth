<?php

/**
 * This is the model class for table "ruangan_m".
 *
 * The followings are the available columns in table 'ruangan_m':
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $ruangan_jenispelayanan
 * @property string $ruangan_lokasi
 * @property boolean $ruangan_aktif
 * @property string $ruangan_singkatan
 * @property integer $riwayatruangan_id
 * @property string $ruangan_fasilitas
 * @property string $ruangan_image
 */
class RIRuanganM extends RuanganM
{
	public $instalasi_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RuanganM the static model class
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
		return 'ruangan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_nama', 'required'),
			array('instalasi_id, riwayatruangan_id', 'numerical', 'integerOnly'=>true),
			array('ruangan_nama, ruangan_namalainnya, ruangan_jenispelayanan, ruangan_lokasi', 'length', 'max'=>50),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('ruangan_image', 'length', 'max'=>100),
			array('ruangan_aktif, ruangan_fasilitas', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, instalasi_id, ruangan_nama, ruangan_namalainnya, ruangan_jenispelayanan, ruangan_lokasi, ruangan_aktif, ruangan_singkatan, riwayatruangan_id, ruangan_fasilitas, ruangan_image', 'safe', 'on'=>'search'),
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
                                        'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ruangan_id' => 'ID',
			'instalasi_id' => 'Instalasi',
			'ruangan_nama' => 'Ruangan ',
			'ruangan_namalainnya' => 'Nama Lainnya',
			'ruangan_jenispelayanan' => 'Jenis Pelayanan',
			'ruangan_lokasi' => 'Lokasi',
			'ruangan_aktif' => 'Aktif',
			'ruangan_singkatan' => 'Singkatan',
			'riwayatruangan_id' => 'Riwayat Ruangan',
			'ruangan_fasilitas' => 'Fasilitas',
			'ruangan_image' => 'Photo Image',
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

		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 	
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id); 	
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruangan_namalainnya)',strtolower($this->ruangan_namalainnya),true);
		$criteria->compare('LOWER(ruangan_jenispelayanan)',strtolower($this->ruangan_jenispelayanan),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('ruangan_aktif',$this->ruangan_aktif);
		$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
		if(!empty($this->riwayatruangan_id)){
			$criteria->addCondition("riwayatruangan_id = ".$this->riwayatruangan_id); 	
		}
		$criteria->compare('LOWER(ruangan_fasilitas)',strtolower($this->ruangan_fasilitas),true);
		$criteria->compare('LOWER(ruangan_image)',strtolower($this->ruangan_image),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;

			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 	
			}
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 	
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			$criteria->compare('LOWER(ruangan_namalainnya)',strtolower($this->ruangan_namalainnya),true);
			$criteria->compare('LOWER(ruangan_jenispelayanan)',strtolower($this->ruangan_jenispelayanan),true);
			$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
			$criteria->compare('ruangan_aktif',$this->ruangan_aktif);
			$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
			if(!empty($this->riwayatruangan_id)){
				$criteria->addCondition("riwayatruangan_id = ".$this->riwayatruangan_id); 	
			}
			$criteria->compare('LOWER(ruangan_fasilitas)',strtolower($this->ruangan_fasilitas),true);
			$criteria->compare('LOWER(ruangan_image)',strtolower($this->ruangan_image),true);
			// Klo limit lebih kecil dari nol itu berarti ga ada limit 
			$criteria->limit=-1; 

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
			));
        }
        
         public function beforeSave() {
            //$this->ruangan_nama = ucwords(strtolower($this->ruangan_nama));
            $this->ruangan_namalainnya = strtoupper($this->ruangan_namalainnya);
            $this->ruangan_singkatan = strtoupper($this->ruangan_singkatan);
            $this->ruangan_lokasi = ucwords(strtolower($this->ruangan_lokasi));
            return parent::beforeSave();
        }
        
        public function getInstalasiItems()
        {
            return InstalasiM::model()->findAll('instalasi_adakamar=TRUE AND instalasi_aktif=TRUE ORDER BY instalasi_nama');
        }
        
        // public function getRuanganByInstalasi($instalasi)
        // {
        //     return RuanganM::model()->findAll('instalasi_id = '.$instalasi.' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
        // }
        
        /**
     * static agar bisa menerima nilai dari parameter
     * @param type $instalasi_id
     * @return type
     */
    public static function getItems($instalasi_id = null) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("ruangan_aktif = TRUE");
        $criteria->order = 'ruangan_nama ASC';
        if (!empty($instalasi_id)) {
            $criteria->addCondition("instalasi_id = " . $instalasi_id);
            return self::model()->findAll($criteria);
        } else {
            return array();
        }
    }
}