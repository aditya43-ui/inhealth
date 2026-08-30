<?php

/**
 * This is the model class for table "informasipascaanestesi_v".
 *
 * The followings are the available columns in table 'informasipascaanestesi_v':
 * @property integer $pascaanestesi_id
 * @property string $nopascaanestesi
 * @property string $tglpascaanestesi
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $dokter_id
 * @property string $nama_dokter
 * @property integer $perawatruangan_id
 * @property string $nama_perawat
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property integer $intraanestesi_id
 */
class InformasipascaanestesiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipascaanestesiV the static model class
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
		return 'informasipascaanestesi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pascaanestesi_id, pasienanastesi_id, pasien_id, dokter_id, perawatruangan_id, kamarruangan_id, intraanestesi_id', 'numerical', 'integerOnly'=>true),
			array('nopascaanestesi', 'length', 'max'=>20),
			array('no_rekam_medik, kamarruangan_nobed', 'length', 'max'=>10),
			array('nama_pasien, nama_dokter, nama_perawat', 'length', 'max'=>50),
			array('kamarruangan_nokamar', 'length', 'max'=>25),
			array('tglpascaanestesi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pascaanestesi_id, nopascaanestesi, tglpascaanestesi, pasienanastesi_id, pasien_id, no_rekam_medik, nama_pasien, dokter_id, nama_dokter, perawatruangan_id, nama_perawat, kamarruangan_id, kamarruangan_nokamar, kamarruangan_nobed, intraanestesi_id', 'safe', 'on'=>'search'),
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
			'pascaanestesi_id' => 'Pascaanestesi',
			'nopascaanestesi' => 'Nopascaanestesi',
			'tglpascaanestesi' => 'Tglpascaanestesi',
			'pasienanastesi_id' => 'Pasienanastesi',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'dokter_id' => 'Dokter',
			'nama_dokter' => 'Nama Dokter',
			'perawatruangan_id' => 'Perawatruangan',
			'nama_perawat' => 'Nama Perawat',
			'kamarruangan_id' => 'Kamarruangan',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'intraanestesi_id' => 'Intraanestesi',
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

		if(!empty($this->pascaanestesi_id)){
			$criteria->addCondition('pascaanestesi_id = '.$this->pascaanestesi_id);
		}
		$criteria->compare('LOWER(nopascaanestesi)',strtolower($this->nopascaanestesi),true);
		$criteria->compare('LOWER(tglpascaanestesi)',strtolower($this->tglpascaanestesi),true);
		if(!empty($this->pasienanastesi_id)){
			$criteria->addCondition('pasienanastesi_id = '.$this->pasienanastesi_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		if(!empty($this->dokter_id)){
			$criteria->addCondition('dokter_id = '.$this->dokter_id);
		}
		$criteria->compare('LOWER(nama_dokter)',strtolower($this->nama_dokter),true);
		if(!empty($this->perawatruangan_id)){
			$criteria->addCondition('perawatruangan_id = '.$this->perawatruangan_id);
		}
		$criteria->compare('LOWER(nama_perawat)',strtolower($this->nama_perawat),true);
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
		}
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		if(!empty($this->intraanestesi_id)){
			$criteria->addCondition('intraanestesi_id = '.$this->intraanestesi_id);
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