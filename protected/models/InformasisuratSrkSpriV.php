<?php

/**
 * This is the model class for table "informasisurat_srk_spri_v".
 *
 * The followings are the available columns in table 'informasisurat_srk_spri_v':
 * @property integer $surat_id
 * @property integer $jenissurat
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property integer $sep_id
 * @property string $tglsep
 * @property string $nosep
 * @property string $tglsurat
 * @property string $nomorsurat
 * @property string $nomorsurat_bpjs
 * @property string $tglrenkontrol
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property string $ruangan_id
 * @property string $ruangan_nama
 * @property string $respon_bpjs
 */
class InformasisuratSrkSpriV extends CActiveRecord
{
	public $tgl_awal, $tgl_akhir, $cari_berdasarkan, $katakunci;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasisurat_srk_spri_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('surat_id, jenissurat, pendaftaran_id, pasien_id, sep_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran, namadepan', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien, instalasi_nama, ruangan_nama', 'length', 'max'=>50),
			array('nosep', 'length', 'max'=>100),
			array('tgl_pendaftaran, tglsep, tglsurat, nomorsurat, nomorsurat_bpjs, tglrenkontrol, ruangan_id, respon_bpjs', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('surat_id, jenissurat, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, pasien_id, no_rekam_medik, namadepan, nama_pasien, sep_id, tglsep, nosep, tglsurat, nomorsurat, nomorsurat_bpjs, tglrenkontrol, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, respon_bpjs', 'safe', 'on'=>'search'),
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
			'surat_id' => 'Surat',
			'jenissurat' => 'Jenis Kontrol',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Peserta',
			'sep_id' => 'Sep',
			'tglsep' => 'Tanggal SEP',
			'nosep' => 'Nomor SEP',
			'tglsurat' => 'Tanggal Pembuatan',
			'nomorsurat' => 'Nomorsurat',
			'nomorsurat_bpjs' => 'No. Surat Kontrol/Inap',
			'tglrenkontrol' => 'Tanggal Rencana Kontrol/Inap',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Poli Tujuan',
			'ruangan_nama' => 'Ruangan Nama',
			'respon_bpjs' => 'Respon Bpjs',
			'nokartuasuransi' => 'No. Kartu Pasien',
			'pegawai_id' => 'Dokter',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('surat_id',$this->surat_id);
		$criteria->compare('jenissurat',$this->jenissurat);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('tglsep',$this->tglsep,true);
		$criteria->compare('nosep',$this->nosep,true);
		$criteria->compare('tglsurat',$this->tglsurat,true);
		$criteria->compare('nomorsurat',$this->nomorsurat,true);
		$criteria->compare('nomorsurat_bpjs',$this->nomorsurat_bpjs,true);
		$criteria->compare('tglrenkontrol',$this->tglrenkontrol,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('respon_bpjs',$this->respon_bpjs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchInformasi() {
		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition("t.".$this->cari_berdasarkan."::date", $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('jenissurat', $this->jenissurat);

		if (!empty($this->katakunci)) {
			$arr_kolom = array(
				//'t.pendaftaran_id', 
				//'t.tgl_pendaftaran', 
				't.no_pendaftaran',
				't.no_rekam_medik', 
				't.nama_pasien', 
				//'t.tglsep', 
				't.nosep',
				//'t.tglsurat',
				't.nomorsurat',
				't.nomorsurat_bpjs',
				//'t.tglrenkontrol',
				't.instalasi_nama',
				't.ruangan_nama',
				't.ruangankontrol_nama',
				't.nama_pegawai',
			);

			foreach ($arr_kolom as $idx => $item) {
				$arr_kolom[$idx] = $item." ilike '%".$this->katakunci."%' ";
			}
			$criteria->addCondition("(".implode(" or ", $arr_kolom).")");

		}
		// var_dump($criteria); die;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasisuratSrkSpriV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
