<?php

/**
 * This is the model class for table "alatmedis_m".
 *
 * The followings are the available columns in table 'alatmedis_m':
 * @property integer $alatmedis_id
 * @property integer $instalasi_id
 * @property integer $jenisalatmedis_id
 * @property integer $alatmedis_noaset
 * @property string $alatmedis_nama
 * @property string $alatmedis_namalain
 * @property boolean $alatmedis_aktif
 * @property string $alatmedis_kode
 * @property string $alatmedis_format
 *
 * The followings are the available model relations:
 * @property PengambilansampleT[] $pengambilansampleTs
 * @property InstalasiM $instalasi
 * @property JenisalatmedisM $jenisalatmedis
 * @property TindakanpelayananT[] $tindakanpelayananTs
 */
class AlatmedisM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AlatmedisM the static model class
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
		return 'alatmedis_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, jenisalatmedis_id, alatmedis_nama, alatmedis_kode', 'required'),
			array('instalasi_id, jenisalatmedis_id, alatmedis_noaset', 'numerical', 'integerOnly'=>true),
			array('alatmedis_nama, alatmedis_namalain', 'length', 'max'=>100),
			array('alatmedis_kode', 'length', 'max'=>2),
			array('alatmedis_format', 'length', 'max'=>10),
			array('alatmedis_harga, alatmedis_merk, alatmedis_trgtbep_sat, alatmedis_trgtbep, alatmedis_tglkalibrasi, alatmedis_hppperhari, alatmedis_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('alatmedis_id, instalasi_id, jenisalatmedis_id, alatmedis_noaset, alatmedis_nama, alatmedis_namalain, alatmedis_aktif, alatmedis_kode, alatmedis_format', 'safe', 'on'=>'search'),
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
			'pengambilansampleTs' => array(self::HAS_MANY, 'PengambilansampleT', 'alatmedis_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'jenisalatmedis' => array(self::BELONGS_TO, 'JenisalatmedisM', 'jenisalatmedis_id'),
			'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'alatmedis_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'alatmedis_id' => 'ID',
			'instalasi_id' => 'Instalasi',
			'jenisalatmedis_id' => 'Jenis Alat Medis',
			'alatmedis_noaset' => 'No. Aset',
			'alatmedis_nama' => 'Nama Alat Medis',
			'alatmedis_namalain' => 'Nama Lain',
			'alatmedis_aktif' => 'Alat medis Aktif',
			'alatmedis_kode' => 'Kode',
			'alatmedis_format' => 'Format',
                        'alatmedis_harga' => 'Harga',
                        'alatmedis_merk' => 'Merk',
                        'alatmedis_trgtbep' => 'Target BEP',
                        'alatmedis_tglkalibrasi' => 'Tanggal Kalibrasi',
                        'alatmedis_hppperhari' => 'HPP/Hari'
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

		if(!empty($this->alatmedis_id)){
			$criteria->addCondition('alatmedis_id = '.$this->alatmedis_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->jenisalatmedis_id)){
			$criteria->addCondition('jenisalatmedis_id = '.$this->jenisalatmedis_id);
		}
		if(!empty($this->alatmedis_noaset)){
			$criteria->addCondition('alatmedis_noaset = '.$this->alatmedis_noaset);
		}
		$criteria->compare('LOWER(alatmedis_nama)',strtolower($this->alatmedis_nama),true);
		$criteria->compare('LOWER(alatmedis_namalain)',strtolower($this->alatmedis_namalain),true);
		$criteria->compare('alatmedis_aktif',$this->alatmedis_aktif);
		$criteria->compare('LOWER(alatmedis_kode)',strtolower($this->alatmedis_kode),true);
		$criteria->compare('LOWER(alatmedis_format)',strtolower($this->alatmedis_format),true);

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