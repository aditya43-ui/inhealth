<?php

/**
 * This is the model class for table "informasipenyiapandarah_v".
 *
 * The followings are the available columns in table 'informasipenyiapandarah_v':
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 * @property integer $instalasiasal_id
 * @property string $instalasiasal_nama
 * @property integer $pasienkirimkeunitlain_id
 * @property string $tgl_kirimpasien
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property integer $pemeriksaangoldar_id
 * @property string $kesimpulan
 * @property integer $permintaankepenunjang_id
 * @property string $jumlah_kantong
 * @property string $diambil
 * @property string $dititip
 * @property string $jenis_volume
 * @property integer $stokkantongdarah_id
 * @property string $nomorbarcode
 * @property integer $komponendarah_id
 * @property string $namakomponendrh
 * @property string $singkatan_komp
 * @property integer $jeniskomponendarah_id
 * @property string $jeniskomponenedarah_nama
 * @property string $jeniskantongdarah_singkatan
 * @property integer $penyiapandarah_id
 * @property string $tglpenyiapandarah
 * @property integer $peg_penerimapermintaan_id
 * @property string $tgl_terimadarah
 * @property string $reaksi_transfusi
 * @property string $kategori_gejalatransfusi
 * @property string $gejala_reaksitransfusi
 * @property integer $pasienmasukpenunjang_id
 * @property string $tglmasukpenunjang
 * @property string $no_masukpenunjang
 */
class InformasipenyiapandarahV extends CActiveRecord
{
	public $tgl_awal, $tgl_akhir;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasipenyiapandarah_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, ruanganasal_id, instalasiasal_id, pasienkirimkeunitlain_id, pegawai_id, gelarbelakang_id, pemeriksaangoldar_id, permintaankepenunjang_id, stokkantongdarah_id, komponendarah_id, jeniskomponendarah_id, penyiapandarah_id, peg_penerimapermintaan_id, pasienmasukpenunjang_id', 'numerical', 'integerOnly'=>true),
			array('nama_pasien, ruanganasal_nama, instalasiasal_nama, nomorbarcode, namakomponendrh, jeniskomponenedarah_nama', 'length', 'max'=>100),
			array('no_rekam_medik, diambil, dititip, jenis_volume, jeniskantongdarah_singkatan', 'length', 'max'=>10),
			array('no_pendaftaran, no_masukpenunjang', 'length', 'max'=>20),
			array('gelardepan', 'length', 'max'=>16),
			array('nama_pegawai', 'length', 'max'=>50),
			array('kesimpulan, jumlah_kantong, reaksi_transfusi, kategori_gejalatransfusi, gejala_reaksitransfusi', 'length', 'max'=>255),
			array('singkatan_komp', 'length', 'max'=>5),
			array('tgl_pendaftaran, tgl_kirimpasien, tglpenyiapandarah, tgl_terimadarah, tglmasukpenunjang', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pasien_id, nama_pasien, no_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, ruanganasal_id, ruanganasal_nama, instalasiasal_id, instalasiasal_nama, pasienkirimkeunitlain_id, tgl_kirimpasien, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_id, pemeriksaangoldar_id, kesimpulan, permintaankepenunjang_id, jumlah_kantong, diambil, dititip, jenis_volume, stokkantongdarah_id, nomorbarcode, komponendarah_id, namakomponendrh, singkatan_komp, jeniskomponendarah_id, jeniskomponenedarah_nama, jeniskantongdarah_singkatan, penyiapandarah_id, tglpenyiapandarah, peg_penerimapermintaan_id, tgl_terimadarah, reaksi_transfusi, kategori_gejalatransfusi, gejala_reaksitransfusi, pasienmasukpenunjang_id, tglmasukpenunjang, no_masukpenunjang', 'safe', 'on'=>'search'),
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
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'ruanganasal_id' => 'Ruanganasal',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'instalasiasal_id' => 'Instalasiasal',
			'instalasiasal_nama' => 'Instalasiasal Nama',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'tgl_kirimpasien' => 'Tgl Kirimpasien',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'pemeriksaangoldar_id' => 'Pemeriksaangoldar',
			'kesimpulan' => 'Kesimpulan',
			'permintaankepenunjang_id' => 'Permintaankepenunjang',
			'jumlah_kantong' => 'Jumlah Kantong',
			'diambil' => 'Diambil',
			'dititip' => 'Dititip',
			'jenis_volume' => 'Jenis Volume',
			'stokkantongdarah_id' => 'Stokkantongdarah',
			'nomorbarcode' => 'Nomorbarcode',
			'komponendarah_id' => 'Komponendarah',
			'namakomponendrh' => 'Namakomponendrh',
			'singkatan_komp' => 'Singkatan Komp',
			'jeniskomponendarah_id' => 'Jeniskomponendarah',
			'jeniskomponenedarah_nama' => 'Jeniskomponenedarah Nama',
			'jeniskantongdarah_singkatan' => 'Jeniskantongdarah Singkatan',
			'penyiapandarah_id' => 'Penyiapandarah',
			'tglpenyiapandarah' => 'Tglpenyiapandarah',
			'peg_penerimapermintaan_id' => 'Peg Penerimapermintaan',
			'tgl_terimadarah' => 'Tgl Terimadarah',
			'reaksi_transfusi' => 'Reaksi Transfusi',
			'kategori_gejalatransfusi' => 'Kategori Gejalatransfusi',
			'gejala_reaksitransfusi' => 'Gejala Reaksitransfusi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'tglmasukpenunjang' => 'Tglmasukpenunjang',
			'no_masukpenunjang' => 'No Masukpenunjang',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('ruanganasal_nama',$this->ruanganasal_nama,true);
		$criteria->compare('instalasiasal_id',$this->instalasiasal_id);
		$criteria->compare('instalasiasal_nama',$this->instalasiasal_nama,true);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('tgl_kirimpasien',$this->tgl_kirimpasien,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('pemeriksaangoldar_id',$this->pemeriksaangoldar_id);
		$criteria->compare('kesimpulan',$this->kesimpulan,true);
		$criteria->compare('permintaankepenunjang_id',$this->permintaankepenunjang_id);
		$criteria->compare('jumlah_kantong',$this->jumlah_kantong,true);
		$criteria->compare('diambil',$this->diambil,true);
		$criteria->compare('dititip',$this->dititip,true);
		$criteria->compare('jenis_volume',$this->jenis_volume,true);
		$criteria->compare('stokkantongdarah_id',$this->stokkantongdarah_id);
		$criteria->compare('nomorbarcode',$this->nomorbarcode,true);
		$criteria->compare('komponendarah_id',$this->komponendarah_id);
		$criteria->compare('namakomponendrh',$this->namakomponendrh,true);
		$criteria->compare('singkatan_komp',$this->singkatan_komp,true);
		$criteria->compare('jeniskomponendarah_id',$this->jeniskomponendarah_id);
		$criteria->compare('jeniskomponenedarah_nama',$this->jeniskomponenedarah_nama,true);
		$criteria->compare('jeniskantongdarah_singkatan',$this->jeniskantongdarah_singkatan,true);
		$criteria->compare('penyiapandarah_id',$this->penyiapandarah_id);
		$criteria->compare('tglpenyiapandarah',$this->tglpenyiapandarah,true);
		$criteria->compare('peg_penerimapermintaan_id',$this->peg_penerimapermintaan_id);
		$criteria->compare('tgl_terimadarah',$this->tgl_terimadarah,true);
		$criteria->compare('reaksi_transfusi',$this->reaksi_transfusi,true);
		$criteria->compare('kategori_gejalatransfusi',$this->kategori_gejalatransfusi,true);
		$criteria->compare('gejala_reaksitransfusi',$this->gejala_reaksitransfusi,true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('tglmasukpenunjang',$this->tglmasukpenunjang,true);
		$criteria->compare('no_masukpenunjang',$this->no_masukpenunjang,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchInformasi()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->group = 'pasien_id, nama_pasien, no_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, ruanganasal_id, ruanganasal_nama, instalasiasal_id, instalasiasal_nama, pasienkirimkeunitlain_id, tgl_kirimpasien, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_id, pemeriksaangoldar_id, kesimpulan, pasienmasukpenunjang_id, tglmasukpenunjang, no_masukpenunjang, tglpenyiapandarah, nomorbarcode, tgl_terimadarah, peg_penerimapermintaan_id';
		$criteria->select = $criteria->group . ", 
		STRING_AGG(jeniskomponenedarah_nama::text, '<br><hr>') AS jeniskomponenedarah_nama, 
		STRING_AGG((jumlah_kantong::text || ' ' || jenis_volume::text), '<br><hr>') AS jumlah_kantong,
		STRING_AGG(diambil::text, '<br><hr>') AS diambil, 
		STRING_AGG(dititip::text, '<br><hr>') AS dititip,
		STRING_AGG(singkatan_komp::text, '<br><hr>') AS singkatan_komp
		
		";

		if(!empty($this->no_masukpenunjang)) {
			$criteria->addCondition('no_masukpenunjang =' . $this->no_masukpenunjang);
		}
		if(!empty($this->no_rekam_medik)) {
			$criteria->addCondition('no_rekam_medik =' . $this->no_rekam_medik);
		}
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		if(!empty($this->instalasiasal_id)) {
			$criteria->addCondition('instalasiasal_id =' . $this->instalasiasal_id);
		}
		if(!empty($this->ruanganasal_id)) {
			$criteria->addCondition('ruanganasal_id =' . $this->ruanganasal_id);
		}
		$criteria->addBetweenCondition('tglpenyiapandarah', $this->tgl_awal, $this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasipenyiapandarahV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getNamaLengkap(){
		$modGelarBelakang = GelarbelakangM::model()->findByPk($this->gelarbelakang_id);

		$gelarbelakang_nama = '';
		if(!empty($modGelarBelakang)){
			$gelarbelakang_nama = ", ". $modGelarBelakang->gelarbelakang_nama;
		}
		return $this->gelardepan." ".$this->nama_pegawai.$gelarbelakang_nama;
	}
}
