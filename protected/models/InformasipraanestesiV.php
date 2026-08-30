<?php

/**
 * This is the model class for table "informasipraanestesi_v".
 *
 * The followings are the available columns in table 'informasipraanestesi_v':
 * @property integer $praanestesi_id
 * @property string $tglpraanestesi
 * @property string $nopraanestesi
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $dokter_id
 * @property string $nama_dokter
 * @property integer $perawat1_id
 * @property string $nama_perawat1
 * @property integer $perawat2_id
 * @property string $nama_perawat2
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 */
class InformasipraanestesiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipraanestesiV the static model class
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
		return 'informasipraanestesi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('praanestesi_id, pasienanastesi_id, pasien_id, dokter_id, perawat1_id, perawat2_id, kamarruangan_id', 'numerical', 'integerOnly'=>true),
			array('nopraanestesi', 'length', 'max'=>20),
			array('no_rekam_medik, kamarruangan_nobed', 'length', 'max'=>10),
			array('nama_pasien, nama_dokter, nama_perawat1, nama_perawat2', 'length', 'max'=>50),
			array('kamarruangan_nokamar', 'length', 'max'=>25),
			array('tglpraanestesi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('praanestesi_id, tglpraanestesi, nopraanestesi, pasienanastesi_id, pasien_id, no_rekam_medik, nama_pasien, dokter_id, nama_dokter, perawat1_id, nama_perawat1, perawat2_id, nama_perawat2, kamarruangan_id, kamarruangan_nokamar, kamarruangan_nobed', 'safe', 'on'=>'search'),
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
			'praanestesi_id' => 'Praanestesi',
			'tglpraanestesi' => 'Tglpraanestesi',
			'nopraanestesi' => 'Nopraanestesi',
			'pasienanastesi_id' => 'Pasienanastesi',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'dokter_id' => 'Dokter',
			'nama_dokter' => 'Nama Dokter',
			'perawat1_id' => 'Perawat1',
			'nama_perawat1' => 'Nama Perawat1',
			'perawat2_id' => 'Perawat2',
			'nama_perawat2' => 'Nama Perawat2',
			'kamarruangan_id' => 'Kamarruangan',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
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

		if(!empty($this->praanestesi_id)){
			$criteria->addCondition('praanestesi_id = '.$this->praanestesi_id);
		}
		$criteria->compare('LOWER(tglpraanestesi)',strtolower($this->tglpraanestesi),true);
		$criteria->compare('LOWER(nopraanestesi)',strtolower($this->nopraanestesi),true);
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
		if(!empty($this->perawat1_id)){
			$criteria->addCondition('perawat1_id = '.$this->perawat1_id);
		}
		$criteria->compare('LOWER(nama_perawat1)',strtolower($this->nama_perawat1),true);
		if(!empty($this->perawat2_id)){
			$criteria->addCondition('perawat2_id = '.$this->perawat2_id);
		}
		$criteria->compare('LOWER(nama_perawat2)',strtolower($this->nama_perawat2),true);
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
		}
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);

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