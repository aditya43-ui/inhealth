<?php

/**
 * This is the model class for table "verifikasidiagnosa_t".
 *
 * The followings are the available columns in table 'verifikasidiagnosa_t':
 * @property integer $verifikasidiagnosa_id
 * @property string $tgl_verifikasi
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $petugasverifikasi_id
 * @property string $keteranganverifikasi
 * @property string $log_perubahan
 * @property string $log_penghapusan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 * @property PegawaiM $petugasverifikasi
 */
class VerifikasidiagnosaT extends CActiveRecord
{
    public $petugasverifikasi_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerifikasidiagnosaT the static model class
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
		return 'verifikasidiagnosa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgl_verifikasi, pendaftaran_id, ruangan_id', 'required'),
			array('pendaftaran_id, ruangan_id, petugasverifikasi_id', 'numerical', 'integerOnly'=>true),
			array('keteranganverifikasi, log_perubahan, log_penghapusan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verifikasidiagnosa_id, tgl_verifikasi, pendaftaran_id, ruangan_id, petugasverifikasi_id, keteranganverifikasi, log_perubahan, log_penghapusan', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'petugasverifikasi' => array(self::BELONGS_TO, 'PegawaiM', 'petugasverifikasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'verifikasidiagnosa_id' => 'Verifikasidiagnosa',
			'tgl_verifikasi' => 'Tgl. Verifikasi',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'petugasverifikasi_id' => 'Petugas Verifikasi',
			'keteranganverifikasi' => 'Keterangan',
			'log_perubahan' => 'Log Perubahan',
			'log_penghapusan' => 'Log Penghapusan',
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

		if(!empty($this->verifikasidiagnosa_id)){
			$criteria->addCondition('verifikasidiagnosa_id = '.$this->verifikasidiagnosa_id);
		}
		$criteria->compare('LOWER(tgl_verifikasi)',strtolower($this->tgl_verifikasi),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->petugasverifikasi_id)){
			$criteria->addCondition('petugasverifikasi_id = '.$this->petugasverifikasi_id);
		}
		$criteria->compare('LOWER(keteranganverifikasi)',strtolower($this->keteranganverifikasi),true);
		$criteria->compare('LOWER(log_perubahan)',strtolower($this->log_perubahan),true);
		$criteria->compare('LOWER(log_penghapusan)',strtolower($this->log_penghapusan),true);

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