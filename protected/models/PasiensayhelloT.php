<?php

/**
 * This is the model class for table "pasiensayhello_t".
 *
 * The followings are the available columns in table 'pasiensayhello_t':
 * @property integer $pasiensayhello_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $pasiensayhello_tgl
 * @property string $pasiensayhello_media
 * @property string $pasiensayhello_deskripsi
 * @property string $pasiensayhello_kritik
 * @property string $pasiensayhello_saran
 * @property integer $petugassayhello_id
 * @property integer $mengetahuisayhello_id
 * @property string $sayhello_createtime
 * @property string $sayhello_updatetime
 * @property integer $sayhello_ruangan_id
 * @property string $sayhello_create_login
 * @property string $sayhello_update_login
 */
class PasiensayhelloT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasiensayhelloT the static model class
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
		return 'pasiensayhello_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, pasiensayhello_tgl, pasiensayhello_media, pasiensayhello_deskripsi, sayhello_createtime, sayhello_ruangan_id, sayhello_create_login', 'required'),
			array('pasien_id, pendaftaran_id, petugassayhello_id, mengetahuisayhello_id, sayhello_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('pasiensayhello_media, sayhello_create_login, sayhello_update_login', 'length', 'max'=>20),
			array('pasiensayhello_kritik, pasiensayhello_saran, kesimpulan', 'length', 'max'=>100),
			array('sayhello_updatetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasiensayhello_id, pasien_id, pendaftaran_id, pasiensayhello_tgl, pasiensayhello_media, pasiensayhello_deskripsi, pasiensayhello_kritik, pasiensayhello_saran, petugassayhello_id, mengetahuisayhello_id, sayhello_createtime, sayhello_updatetime, sayhello_ruangan_id, sayhello_create_login, sayhello_update_login, kesimpulan', 'safe', 'on'=>'search'),
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
			'pasiensayhello_id' => 'Pasiensayhello',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasiensayhello_tgl' => 'Tanggal Say Hello',
			'pasiensayhello_media' => 'Media',
			'pasiensayhello_deskripsi' => 'Deskripsi',
			'pasiensayhello_kritik' => 'Kritik',
			'pasiensayhello_saran' => 'Saran',
			'petugassayhello_id' => 'Petugassayhello',
			'mengetahuisayhello_id' => 'Mengetahuisayhello',
			'sayhello_createtime' => 'Sayhello Createtime',
			'sayhello_updatetime' => 'Sayhello Updatetime',
			'sayhello_ruangan_id' => 'Sayhello Ruangan',
			'sayhello_create_login' => 'Sayhello Create Login',
			'sayhello_update_login' => 'Sayhello Update Login',
			'kesimpulan'=>'kesimpulan',
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

		if(!empty($this->pasiensayhello_id)){
			$criteria->addCondition('pasiensayhello_id = '.$this->pasiensayhello_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(pasiensayhello_tgl)',strtolower($this->pasiensayhello_tgl),true);
		$criteria->compare('LOWER(pasiensayhello_media)',strtolower($this->pasiensayhello_media),true);
		$criteria->compare('LOWER(pasiensayhello_deskripsi)',strtolower($this->pasiensayhello_deskripsi),true);
		$criteria->compare('LOWER(pasiensayhello_kritik)',strtolower($this->pasiensayhello_kritik),true);
		$criteria->compare('LOWER(pasiensayhello_saran)',strtolower($this->pasiensayhello_saran),true);
		if(!empty($this->petugassayhello_id)){
			$criteria->addCondition('petugassayhello_id = '.$this->petugassayhello_id);
		}
		if(!empty($this->mengetahuisayhello_id)){
			$criteria->addCondition('mengetahuisayhello_id = '.$this->mengetahuisayhello_id);
		}
		$criteria->compare('LOWER(sayhello_createtime)',strtolower($this->sayhello_createtime),true);
		$criteria->compare('LOWER(sayhello_updatetime)',strtolower($this->sayhello_updatetime),true);
		if(!empty($this->sayhello_ruangan_id)){
			$criteria->addCondition('sayhello_ruangan_id = '.$this->sayhello_ruangan_id);
		}
		$criteria->compare('LOWER(sayhello_create_login)',strtolower($this->sayhello_create_login),true);
		$criteria->compare('LOWER(sayhello_update_login)',strtolower($this->sayhello_update_login),true);

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