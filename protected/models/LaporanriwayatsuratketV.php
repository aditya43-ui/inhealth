<?php

/**
 * This is the model class for table "laporanriwayatsuratket_v".
 *
 * The followings are the available columns in table 'laporanriwayatsuratket_v':
 * @property integer $suratketerangan_id
 * @property string $tglsurat
 * @property integer $jenissurat_id
 * @property string $jenissurat_nama
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property string $judulsurat
 * @property string $nomorsurat
 * @property string $create_loginpemakai_id
 * @property string $nama_pemakai
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 */
class LaporanriwayatsuratketV extends CActiveRecord
{
        public $jns_periode;
        public $tgl_awal;
        public $tgl_akhir;
        public $bln_awal;
        public $bln_akhir;
        public $thn_awal;
        public $thn_akhir;        
        public $data;
        public $jumlah;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanriwayatsuratketV the static model class
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
		return 'laporanriwayatsuratket_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('suratketerangan_id, jenissurat_id, pendaftaran_id, pasien_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('jenissurat_nama, judulsurat', 'length', 'max'=>200),
			array('no_pendaftaran, namadepan, nama_pemakai', 'length', 'max'=>20),
			array('nama_pasien, nama_pegawai', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nomorsurat', 'length', 'max'=>100),
			array('tglsurat, create_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('suratketerangan_id, tglsurat, jenissurat_id, jenissurat_nama, pendaftaran_id, no_pendaftaran, pasien_id, namadepan, nama_pasien, no_rekam_medik, judulsurat, nomorsurat, create_loginpemakai_id, nama_pemakai, pegawai_id, nama_pegawai', 'safe', 'on'=>'search'),
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
			'suratketerangan_id' => 'Suratketerangan',
			'tglsurat' => 'Tglsurat',
			'jenissurat_id' => 'Jenissurat',
			'jenissurat_nama' => 'Jenissurat Nama',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'judulsurat' => 'Judulsurat',
			'nomorsurat' => 'Nomorsurat',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'nama_pemakai' => 'Nama Pemakai',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
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

		$criteria->compare('suratketerangan_id',$this->suratketerangan_id);
		$criteria->compare('tglsurat',$this->tglsurat,true);
		$criteria->compare('jenissurat_id',$this->jenissurat_id);
		$criteria->compare('jenissurat_nama',$this->jenissurat_nama,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('judulsurat',$this->judulsurat,true);
		$criteria->compare('nomorsurat',$this->nomorsurat,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('nama_pemakai',$this->nama_pemakai,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}