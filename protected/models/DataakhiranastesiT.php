<?php

/**
 * This is the model class for table "dataakhiranastesi_t".
 *
 * The followings are the available columns in table 'dataakhiranastesi_t':
 * @property integer $dataakhiranastesi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $rencanaoperasi_id
 * @property double $jumlah_urine
 * @property double $jumlah_perdarahan
 * @property double $jumlah_cairanim
 * @property string $lama_anastesi
 * @property string $lama_pembedahan
 * @property string $catatan_akhiranastesi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property RencanaoperasiT $rencanaoperasi
 */
class DataakhiranastesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DataakhiranastesiT the static model class
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
		return 'dataakhiranastesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, pasienmasukpenunjang_id', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jumlah_urine, jumlah_perdarahan, jumlah_cairanim', 'numerical'),
			array('lama_anastesi, lama_pembedahan', 'length', 'max'=>50),
			array('catatan_akhiranastesi, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dataakhiranastesi_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, jumlah_urine, jumlah_perdarahan, jumlah_cairanim, lama_anastesi, lama_pembedahan, catatan_akhiranastesi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'rencanaoperasi' => array(self::BELONGS_TO, 'RencanaoperasiT', 'rencanaoperasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dataakhiranastesi_id' => 'Dataakhiranastesi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'jumlah_urine' => 'Jumlah Urine',
			'jumlah_perdarahan' => 'Jumlah Perdarahan (&plusmn;)',
			'jumlah_cairanim' => 'Jumlah Cairan (IM)',
			'lama_anastesi' => 'Lama Anastesi',
			'lama_pembedahan' => 'Lama Pembedahan',
			'catatan_akhiranastesi' => 'Catatan Akhir',
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

		if(!empty($this->dataakhiranastesi_id)){
			$criteria->addCondition('dataakhiranastesi_id = '.$this->dataakhiranastesi_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->rencanaoperasi_id)){
			$criteria->addCondition('rencanaoperasi_id = '.$this->rencanaoperasi_id);
		}
		$criteria->compare('jumlah_urine',$this->jumlah_urine);
		$criteria->compare('jumlah_perdarahan',$this->jumlah_perdarahan);
		$criteria->compare('jumlah_cairanim',$this->jumlah_cairanim);
		$criteria->compare('LOWER(lama_anastesi)',strtolower($this->lama_anastesi),true);
		$criteria->compare('LOWER(lama_pembedahan)',strtolower($this->lama_pembedahan),true);
		$criteria->compare('LOWER(catatan_akhiranastesi)',strtolower($this->catatan_akhiranastesi),true);
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