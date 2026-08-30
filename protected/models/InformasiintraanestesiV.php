<?php

/**
 * This is the model class for table "informasiintraanestesi_v".
 *
 * The followings are the available columns in table 'informasiintraanestesi_v':
 * @property integer $intraanestesi_id
 * @property string $nointraanestesi
 * @property string $tglintraanestesi
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $dokter_id
 * @property string $nama_dokter
 * @property integer $perawat1_id
 * @property string $nama_perawat1
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property integer $praanestesi_id
 */
class InformasiintraanestesiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiintraanestesiV the static model class
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
		return 'informasiintraanestesi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('intraanestesi_id, pasienanastesi_id, pasien_id, dokter_id, perawat1_id, kamarruangan_id, praanestesi_id', 'numerical', 'integerOnly'=>true),
			array('nointraanestesi', 'length', 'max'=>20),
			array('no_rekam_medik, kamarruangan_nobed', 'length', 'max'=>10),
			array('nama_pasien, nama_dokter, nama_perawat1', 'length', 'max'=>50),
			array('kamarruangan_nokamar', 'length', 'max'=>25),
			array('tglintraanestesi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('intraanestesi_id, nointraanestesi, tglintraanestesi, pasienanastesi_id, pasien_id, no_rekam_medik, nama_pasien, dokter_id, nama_dokter, perawat1_id, nama_perawat1, kamarruangan_id, kamarruangan_nokamar, kamarruangan_nobed, praanestesi_id', 'safe', 'on'=>'search'),
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
			'intraanestesi_id' => 'Intra Anestesi',
			'nointraanestesi' => 'No. Intra Anestesi',
			'tglintraanestesi' => 'Tgl. Intra Anestesi',
			'pasienanastesi_id' => 'Pasien Anestesi',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'dokter_id' => 'Dokter',
			'nama_dokter' => 'Nama Dokter',
			'perawat1_id' => 'Perawat 1',
			'nama_perawat1' => 'Perawat 1',
			'kamarruangan_id' => 'Kamar Ruangan',
			'kamarruangan_nokamar' => 'Kamar Ruangan No. Kamar',
			'kamarruangan_nobed' => 'Kamar Ruangan No. Bed',
			'praanestesi_id' => 'Pra Anestesi',
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

		if(!empty($this->intraanestesi_id)){
			$criteria->addCondition('intraanestesi_id = '.$this->intraanestesi_id);
		}
		$criteria->compare('LOWER(nointraanestesi)',strtolower($this->nointraanestesi),true);
		//$criteria->compare('LOWER(tglintraanestesi)',strtolower($this->tglintraanestesi),true);
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
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
		}
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		if(!empty($this->praanestesi_id)){
			$criteria->addCondition('praanestesi_id = '.$this->praanestesi_id);
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