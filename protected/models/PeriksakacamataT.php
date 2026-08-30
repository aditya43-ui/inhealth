<?php

/**
 * This is the model class for table "periksakacamata_t".
 *
 * The followings are the available columns in table 'periksakacamata_t':
 * @property integer $periksakacamata_id
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $pegawai_id
 * @property string $tglperiksakacamata
 * @property string $pro_kacamata
 * @property string $permintaanke_kacamata
 * @property string $jatuhtempo_kacamata
 * @property string $hasil_penglihatan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PeriksakacamataT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeriksakacamataT the static model class
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
		return 'periksakacamata_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pasien_id, tglperiksakacamata, hasil_penglihatan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, ruangan_id, pasien_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pro_kacamata, permintaanke_kacamata', 'length', 'max'=>100),
			array('hasil_penglihatan', 'length', 'max'=>20),
			array('jatuhtempo_kacamata, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('periksakacamata_id, pendaftaran_id, ruangan_id, pasien_id, pegawai_id, tglperiksakacamata, pro_kacamata, permintaanke_kacamata, jatuhtempo_kacamata, hasil_penglihatan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'periksakacamata_id' => 'Periksa Kacamata',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'pegawai_id' => 'Pegawai',
			'tglperiksakacamata' => 'Tanggal Pemeriksaan',
			'pro_kacamata' => 'Pro Kacamata',
			'permintaanke_kacamata' => 'Permintaan Ke',
			'jatuhtempo_kacamata' => 'Jatuh Tempo',
			'hasil_penglihatan' => 'Hasil Pemeriksaan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->periksakacamata_id)){
			$criteria->addCondition('periksakacamata_id = '.$this->periksakacamata_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(tglperiksakacamata)',strtolower($this->tglperiksakacamata),true);
		$criteria->compare('LOWER(pro_kacamata)',strtolower($this->pro_kacamata),true);
		$criteria->compare('LOWER(permintaanke_kacamata)',strtolower($this->permintaanke_kacamata),true);
		$criteria->compare('LOWER(jatuhtempo_kacamata)',strtolower($this->jatuhtempo_kacamata),true);
		$criteria->compare('LOWER(hasil_penglihatan)',strtolower($this->hasil_penglihatan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
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