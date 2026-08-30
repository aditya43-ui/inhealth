<?php

/**
 * This is the model class for table "pengangkatanpns_t".
 *
 * The followings are the available columns in table 'pengangkatanpns_t':
 * @property integer $pengangkatanpns_id
 * @property integer $realisasipns_id
 * @property integer $usulanpns_id
 * @property integer $pegawai_id
 * @property integer $perspeng_id
 * @property string $jabatan
 * @property string $pangkat
 * @property string $pendidikan
 * @property string $keterangan
 * @property string $pimpinannama
 */
class PengangkatanpnsT extends CActiveRecord
{
        public $cekPersetujuan, $cekRealisasi;
        public $nomorindukpegawai, $gelardepan, $nama_pegawai, $nama_keluarga, $tempatlahir_pegawai, $tgl_lahirpegawai, $jeniskelamin, $statusperkawinan;
        public $alamat_pegawai, $agama;
        public $usulanpns_gajipokok, $usulanpns_masakerjatahun, $usulanpns_masakerjabulan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengangkatanpnsT the static model class
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
		return 'pengangkatanpns_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, keterangan', 'required'),
			array('realisasipns_id, usulanpns_id, pegawai_id, perspeng_id', 'numerical', 'integerOnly'=>true),
			array('jabatan, pangkat, pendidikan, pimpinannama', 'length', 'max'=>100),
                        array('usulanpns_gajipokok, usulanpns_masakerjatahun, usulanpns_masakerjabulan, cekRealisasi, cekPersetujuan, nomorindukpegawai, gelardepan, nama_pegawai, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, statusperkawinan, alamat_pegawai, agama, ','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengangkatanpns_id, nomorindukpegawai, gelardepan, nama_pegawai, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, statusperkawinan, alamat_pegawai, agama, realisasipns_id, usulanpns_id, pegawai_id, perspeng_id, jabatan, pangkat, pendidikan, keterangan, pimpinannama', 'safe', 'on'=>'search'),
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
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'realisasipns'=>array(self::BELONGS_TO, 'RealisasipnsR','realisasipns_id'),
                    'perspeng'=>array(self::BELONGS_TO, 'PerspengpnsR','perspeng_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengangkatanpns_id' => 'Pengangkatan PNS',
			'realisasipns_id' => 'Realisasi PNS',
			'usulanpns_id' => 'Usulan PNS',
			'pegawai_id' => 'Pegawai',
			'perspeng_id' => 'Persetujuan Pengangkatan',
			'jabatan' => 'Jabatan',
			'pangkat' => 'Pangkat',
			'pendidikan' => 'Pendidikan',
			'keterangan' => 'Keterangan',
			'pimpinannama' => 'Pimpinan Nama',
                        'nomorindukpegawai'=>'NIP',
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
                
                $criteria->with = array('pegawai');
		$criteria->compare('pengangkatanpns_id',$this->pengangkatanpns_id);
		$criteria->compare('realisasipns_id',$this->realisasipns_id);
		$criteria->compare('usulanpns_id',$this->usulanpns_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('perspeng_id',$this->perspeng_id);
		$criteria->compare('LOWER(jabatan)',strtolower($this->jabatan),true);
		$criteria->compare('LOWER(pangkat)',strtolower($this->pangkat),true);
		$criteria->compare('LOWER(pendidikan)',strtolower($this->pendidikan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(pimpinannama)',strtolower($this->pimpinannama),true);
                $criteria->compare('LOWER(pegawai.nomorindukpegawai)', strtolower($this->nomorindukpegawai),true);
                $criteria->compare('LOWER(pegawai.gelardepan)',strtolower($this->gelardepan),true);
                $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(pegawai.nama_keluarga)',strtolower($this->nama_keluarga),true);
                $criteria->compare('LOWER(pegawai.tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
                $criteria->compare('LOWER(pegawai.jeniskelamin)',strtolower($this->jeniskelamin),true);
                $criteria->compare('LOWER(pegawai.statusperkawinan)',strtolower($this->statusperkawinan),true);
                $criteria->compare('LOWER(pegawai.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
                $criteria->compare('LOWER(pegawai.agama)',strtolower($this->agama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pengangkatanpns_id',$this->pengangkatanpns_id);
		$criteria->compare('realisasipns_id',$this->realisasipns_id);
		$criteria->compare('usulanpns_id',$this->usulanpns_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('perspeng_id',$this->perspeng_id);
		$criteria->compare('LOWER(jabatan)',strtolower($this->jabatan),true);
		$criteria->compare('LOWER(pangkat)',strtolower($this->pangkat),true);
		$criteria->compare('LOWER(pendidikan)',strtolower($this->pendidikan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(pimpinannama)',strtolower($this->pimpinannama),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}