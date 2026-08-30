<?php

/**
 * This is the model class for table "pesananpascaanastesi_t".
 * @author rusdiyanto <rusdiyanto@.com>
 * @package application.models
 * The followings are the available columns in table 'pesananpascaanastesi_t':
 * @property integer $pesananpascaanastesi_t
 * @property integer $pegawai_id
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $infus
 * @property string $puasa
 * @property string $minum
 * @property string $jam_minum
 * @property string $makan
 * @property string $jam_makan
 * @property string $bila
 * @property integer $tensi_sistolik
 * @property integer $tensi_diastolik
 * @property integer $nadi
 * @property string $kesadaran
 * @property string $produksi_urine
 * @property string $perfusi
 * @property string $lain_lain
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 */
class PesananpascaanastesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesananpascaanastesiT the static model class
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
		return 'pesananpascaanastesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id', 'required'),
			array('pegawai_id, pasienanastesi_id, pasien_id, pendaftaran_id, tensi_sistolik, tensi_diastolik, nadi', 'numerical', 'integerOnly'=>true),
			array('minum, makan, bila, kesadaran, produksi_urine, perfusi', 'length', 'max'=>100),
			array('infus, puasa, jam_minum, jam_makan, lain_lain, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, pasienanastesi_id, pasien_id, pendaftaran_id, infus, puasa, minum, jam_minum, makan, jam_makan, bila, tensi_sistolik, tensi_diastolik, nadi, kesadaran, produksi_urine, perfusi, lain_lain, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'pesananpascaanastesi_id' => 'Pesananpascaanastesi T',
			'pegawai_id' => 'Pegawai',
			'pasienanastesi_id' => 'Pasienanastesi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'infus' => 'Infus',
			'puasa' => 'Puasa',
			'minum' => 'Minum',
			'jam_minum' => 'Jam Minum',
			'makan' => 'Makan',
			'jam_makan' => 'Jam Makan',
			'bila' => 'Bila',
			'tensi_sistolik' => 'Tensi Sistolik',
			'tensi_diastolik' => 'Tensi Diastolik',
			'nadi' => 'Nadi',
			'kesadaran' => 'Kesadaran',
			'produksi_urine' => 'Produksi Urine',
			'perfusi' => 'Perfusi',
			'lain_lain' => 'Lain Lain',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		if(!empty($this->pesananpascaanastesi_id)){
			$criteria->addCondition('pesananpascaanastesi_id = '.$this->pesananpascaanastesi_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->pasienanastesi_id)){
			$criteria->addCondition('pasienanastesi_id = '.$this->pasienanastesi_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(infus)',strtolower($this->infus),true);
		$criteria->compare('LOWER(puasa)',strtolower($this->puasa),true);
		$criteria->compare('LOWER(minum)',strtolower($this->minum),true);
		$criteria->compare('LOWER(jam_minum)',strtolower($this->jam_minum),true);
		$criteria->compare('LOWER(makan)',strtolower($this->makan),true);
		$criteria->compare('LOWER(jam_makan)',strtolower($this->jam_makan),true);
		$criteria->compare('LOWER(bila)',strtolower($this->bila),true);
		if(!empty($this->tensi_sistolik)){
			$criteria->addCondition('tensi_sistolik = '.$this->tensi_sistolik);
		}
		if(!empty($this->tensi_diastolik)){
			$criteria->addCondition('tensi_diastolik = '.$this->tensi_diastolik);
		}
		if(!empty($this->nadi)){
			$criteria->addCondition('nadi = '.$this->nadi);
		}
		$criteria->compare('LOWER(kesadaran)',strtolower($this->kesadaran),true);
		$criteria->compare('LOWER(produksi_urine)',strtolower($this->produksi_urine),true);
		$criteria->compare('LOWER(perfusi)',strtolower($this->perfusi),true);
		$criteria->compare('LOWER(lain_lain)',strtolower($this->lain_lain),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);

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