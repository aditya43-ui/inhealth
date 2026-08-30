<?php

/**
 * This is the model class for table "mcu_pemeriksaanlainlain_t".
 * @author Rusdiyanto <rusdiyanto@.com>
 * @package application.models
 * The followings are the available columns in table 'mcu_pemeriksaanlainlain_t':
 * @property integer $checkup_lainlain_id
 * @property string $tgl_pemeriksaan
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $hasil_pap_smeer
 * @property string $pemeriksaan_mamma
 * @property string $visus_kanan
 * @property string $visus_kiri
 * @property string $refraksi
 * @property string $tekanan_bola_mata
 * @property string $persepsi_warna
 * @property string $kecamata_lama
 * @property string $key_lainlain
 * @property string $tht
 * @property integer $dokterpemeriksa_id
 * @property boolean $mata_normal
 * @property boolean $mata_abnormal
 * @property string $mata_keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class McuPemeriksaanlainlainT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return McuPemeriksaanlainlainT the static model class
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
		return 'mcu_pemeriksaanlainlain_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasien_id, dokterpemeriksa_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('visus_kanan, visus_kiri', 'length', 'max'=>10),
			array('refraksi, tekanan_bola_mata, persepsi_warna, kecamata_lama, mata_keterangan', 'length', 'max'=>100),
			array('tgl_pemeriksaan, hasil_pap_smeer, pemeriksaan_mamma, key_lainlain, tht, mata_normal, mata_abnormal, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('checkup_lainlain_id, tgl_pemeriksaan, pendaftaran_id, pasien_id, hasil_pap_smeer, pemeriksaan_mamma, visus_kanan, visus_kiri, refraksi, tekanan_bola_mata, persepsi_warna, kecamata_lama, key_lainlain, tht, dokterpemeriksa_id, mata_normal, mata_abnormal, mata_keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
            'dokterpemeriksa'=>array(self::BELONGS_TO, 'PegawaiM', 'dokterpemeriksa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'checkup_lainlain_id' => 'Checkup Lainlain',
			'tgl_pemeriksaan' => 'Tgl. Pemeriksaan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'hasil_pap_smeer' => 'Hasil Pap Smeer',
			'pemeriksaan_mamma' => 'Pemeriksaan Mamma',
			'visus_kanan' => 'Visus Kanan',
			'visus_kiri' => 'Visus Kiri',
			'refraksi' => 'Refraksi',
			'tekanan_bola_mata' => 'Tekanan Bola Mata',
			'persepsi_warna' => 'Persepsi Warna',
			'kecamata_lama' => 'Kecamata Lama',
			'key_lainlain' => 'Key Lainlain',
			'tht' => 'Tht',
			'dokterpemeriksa_id' => 'Dokterpemeriksa',
			'mata_normal' => 'Mata Normal',
			'mata_abnormal' => 'Mata Abnormal',
			'mata_keterangan' => 'Mata Keterangan',
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

		if(!empty($this->checkup_lainlain_id)){
			$criteria->addCondition('checkup_lainlain_id = '.$this->checkup_lainlain_id);
		}
		$criteria->compare('LOWER(tgl_pemeriksaan)',strtolower($this->tgl_pemeriksaan),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(hasil_pap_smeer)',strtolower($this->hasil_pap_smeer),true);
		$criteria->compare('LOWER(pemeriksaan_mamma)',strtolower($this->pemeriksaan_mamma),true);
		$criteria->compare('LOWER(visus_kanan)',strtolower($this->visus_kanan),true);
		$criteria->compare('LOWER(visus_kiri)',strtolower($this->visus_kiri),true);
		$criteria->compare('LOWER(refraksi)',strtolower($this->refraksi),true);
		$criteria->compare('LOWER(tekanan_bola_mata)',strtolower($this->tekanan_bola_mata),true);
		$criteria->compare('LOWER(persepsi_warna)',strtolower($this->persepsi_warna),true);
		$criteria->compare('LOWER(kecamata_lama)',strtolower($this->kecamata_lama),true);
		$criteria->compare('LOWER(key_lainlain)',strtolower($this->key_lainlain),true);
		$criteria->compare('LOWER(tht)',strtolower($this->tht),true);
		if(!empty($this->dokterpemeriksa_id)){
			$criteria->addCondition('dokterpemeriksa_id = '.$this->dokterpemeriksa_id);
		}
		$criteria->compare('mata_normal',$this->mata_normal);
		$criteria->compare('mata_abnormal',$this->mata_abnormal);
		$criteria->compare('LOWER(mata_keterangan)',strtolower($this->mata_keterangan),true);
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

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
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