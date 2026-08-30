<?php

/**
 * This is the model class for table "displayantrianpasien_v".
 *
 * The followings are the available columns in table 'displayantrianpasien_v':
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $no_urutantri
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $statusperiksa
 */
class DisplayantrianpasienV extends CActiveRecord
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DisplayantrianpasienV the static model class
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
		return 'displayantrianpasien_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('no_urutantri', 'length', 'max'=>6),
			array('no_pendaftaran, jeniskelamin', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien, statusperiksa', 'length', 'max'=>50),
			array('tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, pendaftaran_id, no_urutantri, tgl_pendaftaran, no_pendaftaran, no_rekam_medik, nama_pasien, jeniskelamin, statusperiksa', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'no_urutantri' => 'No. Antrian Poliklinik',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'statusperiksa' => 'Status',
                        'ruangan_nama'=>'Poliklinik'
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function primaryKey() {
            return 'pendaftaran_id';
        }
        
        public function getTanggalDaftar(){
            $format = new MyFormatter();
            $tgl = explode(' ',$this->tgl_pendaftaran);
            return $format->formatDateIna($tgl[0]);
        }
        
        public function getJamDaftar(){
            $format = new MyFormatter();
            $tgl = explode(' ',$this->tgl_pendaftaran);
            return $tgl[1];
        }
}