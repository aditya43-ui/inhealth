<?php

/**
 * This is the model class for table "pasienanastesi_t".
 *
 * The followings are the available columns in table 'pasienanastesi_t':
 * @property integer $pasienanastesi_id
 * @property integer $anastesi_id
 * @property integer $pendaftaran_id
 * @property integer $jenisanastesi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $typeanastesi_id
 * @property integer $pasien_id
 * @property integer $rencanaoperasi_id
 * @property string $tglanastesi
 * @property string $dokteranastesi_id
 * @property string $perawatanastesi_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PasienanastesiT extends CActiveRecord
{
        public $pakeAnastesi = FALSE;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienanastesiT the static model class
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
		return 'pasienanastesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, jenisanastesi_id, pasienmasukpenunjang_id, pasien_id, tglanastesi, dokteranastesi_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('anastesi_id, pendaftaran_id, jenisanastesi_id, pasienmasukpenunjang_id, pasien_id, rencanaoperasi_id', 'numerical', 'integerOnly'=>true),
			array('typeanastesi_id', 'length', 'max'=>10),
			array('perawatanastesi_id, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienanastesi_id, anastesi_id, pendaftaran_id, jenisanastesi_id, pasienmasukpenunjang_id, typeanastesi_id, pasien_id, rencanaoperasi_id, tglanastesi, dokteranastesi_id, perawatanastesi_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'perawatanastesi' => array(self::BELONGS_TO,'PegawaiM','perawatanastesi_id'),
			'dokteranastesi' => array(self::BELONGS_TO,'PegawaiM','dokteranastesi_id'),
			'jenisanastesi' => array(self::BELONGS_TO,'JenisAnastesiM','jenisanastesi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienanastesi_id' => 'Pasienanastesi',
			'anastesi_id' => 'Anastesi',
			'pendaftaran_id' => 'Pendaftaran',
			'jenisanastesi_id' => 'Jenis Anastesi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'typeanastesi_id' => 'Type Anastesi',
			'pasien_id' => 'Pasien',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'tglanastesi' => 'Tglanastesi',
			'dokteranastesi_id' => 'Dokter Anastesi',
			'perawatanastesi_id' => 'Perawat Anastesi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'tglanastesi' => 'Tanggal Anestesi',
                        'noanestesi' => 'No. Anestesi'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('anastesi_id',$this->anastesi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('jenisanastesi_id',$this->jenisanastesi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(typeanastesi_id)',strtolower($this->typeanastesi_id),true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('LOWER(tglanastesi)',strtolower($this->tglanastesi),true);
		$criteria->compare('LOWER(dokteranastesi_id)',strtolower($this->dokteranastesi_id),true);
		$criteria->compare('LOWER(perawatanastesi_id)',strtolower($this->perawatanastesi_id),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('anastesi_id',$this->anastesi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('jenisanastesi_id',$this->jenisanastesi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(typeanastesi_id)',strtolower($this->typeanastesi_id),true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('LOWER(tglanastesi)',strtolower($this->tglanastesi),true);
		$criteria->compare('LOWER(dokteranastesi_id)',strtolower($this->dokteranastesi_id),true);
		$criteria->compare('LOWER(perawatanastesi_id)',strtolower($this->perawatanastesi_id),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}