<?php

/**
 * This is the model class for table "statusduranteroperasi_t".
 *
 * The followings are the available columns in table 'statusduranteroperasi_t':
 * @property integer $statusduranteroperasi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $jam_mulaianestesi
 * @property string $jam_selesaianestesi
 * @property string $statusanestesi
 * @property string $jam_mulaitindakanbedah
 * @property string $jam_selesaitindakanbedah
 * @property string $status_tindakanbedah
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
 */
class StatusduranteroperasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatusduranteroperasiT the static model class
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
		return 'statusduranteroperasi_t';
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
			array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('statusanestesi, status_tindakanbedah', 'length', 'max'=>50),
			array('jam_mulaianestesi, jam_selesaianestesi, jam_mulaitindakanbedah, jam_selesaitindakanbedah, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('statusduranteroperasi_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, jam_mulaianestesi, jam_selesaianestesi, statusanestesi, jam_mulaitindakanbedah, jam_selesaitindakanbedah, status_tindakanbedah, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'statusduranteroperasi_id' => 'Statusduranteroperasi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'jam_mulaianestesi' => 'Mulai Anestesi/Sedasi (Intubasi)',
			'jam_selesaianestesi' => 'Selesai Anestesi/Sedasi (Ekstubasi)',
			'statusanestesi' => 'Statusanestesi',
			'jam_mulaitindakanbedah' => 'Mulai Tindakan Bedah',
			'jam_selesaitindakanbedah' => 'Selesai Tindakan Bedah',
			'status_tindakanbedah' => 'Status Tindakanbedah',
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

		if(!empty($this->statusduranteroperasi_id)){
			$criteria->addCondition('statusduranteroperasi_id = '.$this->statusduranteroperasi_id);
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
		$criteria->compare('LOWER(jam_mulaianestesi)',strtolower($this->jam_mulaianestesi),true);
		$criteria->compare('LOWER(jam_selesaianestesi)',strtolower($this->jam_selesaianestesi),true);
		$criteria->compare('LOWER(statusanestesi)',strtolower($this->statusanestesi),true);
		$criteria->compare('LOWER(jam_mulaitindakanbedah)',strtolower($this->jam_mulaitindakanbedah),true);
		$criteria->compare('LOWER(jam_selesaitindakanbedah)',strtolower($this->jam_selesaitindakanbedah),true);
		$criteria->compare('LOWER(status_tindakanbedah)',strtolower($this->status_tindakanbedah),true);
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