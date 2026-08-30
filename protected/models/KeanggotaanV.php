<?php

/**
 * This is the model class for table "keanggotaaan_v".
 *
 * The followings are the available columns in table 'keanggotaaan_v':
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang
 * @property string $nama_keluarga
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $alamat_pegawai
 * @property string $tglkeanggotaaan
 * @property string $nokeanggotaan
 * @property integer $keanggotaan_id
 * @property string $tglpermintaanberhenti
 * @property string $tglberhenti_dipecat
 * @property string $sebabberhenti
 * @property string $alasanberhenti
 * @property string $tgldisetujuiperm
 * @property string $mengetahui
 * @property integer $unit_id
 * @property string $namaunit
 * @property string $photopegawai
 * @property string $norekening
 * @property string $banknorekening
 * @property string $npwp
 * @property string $kategoripegawai
 * @property string $jeniswaktukerja
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $jenisidentitas
 * @property string $noidentitas
 * @property string $nomorindukpegawai
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 */
class KeanggotaanV extends CActiveRecord
{
	public $golonganpegawai_id, $umur;
        public $tgl_awal, $tgl_akhir;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'keanggotaan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, keanggotaan_id, unit_id, jabatan_id, pangkat_id', 'numerical', 'integerOnly'=>true),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, gelarbelakang, nama_keluarga, nokeanggotaan, mengetahui, kategoripegawai, notelp_pegawai, nomobile_pegawai, nomorindukpegawai, pangkat_nama', 'length', 'max'=>50),
			array('tempatlahir_pegawai', 'length', 'max'=>30),
			array('jeniskelamin, jeniswaktukerja, statusperkawinan, agama, jenisidentitas', 'length', 'max'=>20),
			array('sebabberhenti, photopegawai', 'length', 'max'=>200),
			array('namaunit, norekening, banknorekening, noidentitas, jabatan_nama', 'length', 'max'=>100),
			array('npwp', 'length', 'max'=>25),
			array('tgl_lahirpegawai, golonganpegawai_id, alamat_pegawai, no_kartupegawainegerisipil, nomorindukpegawai, tglkeanggotaaan, tglpermintaanberhenti, tglberhenti_dipecat, alasanberhenti, tgldisetujuiperm', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pegawai_id, gelardepan, golonganpegawai_id, nama_pegawai, no_kartupegawainegerisipil, gelarbelakang, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, alamat_pegawai, tglkeanggotaaan, nokeanggotaan, keanggotaan_id, tglpermintaanberhenti, tglberhenti_dipecat, sebabberhenti, alasanberhenti, tgldisetujuiperm, mengetahui, unit_id, namaunit, photopegawai, norekening, banknorekening, npwp, kategoripegawai, jeniswaktukerja, notelp_pegawai, nomobile_pegawai, statusperkawinan, agama, jenisidentitas, noidentitas, nomorindukpegawai, jabatan_id, jabatan_nama, pangkat_id, pangkat_nama', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang' => 'Gelarbelakang',
			'nama_keluarga' => 'Nama Keluarga',
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pegawai' => 'Alamat Anggota',
			'tglkeanggotaaan' => 'Tanggal Keanggotaan',
			'nokeanggotaan' => 'No Keanggotaan',
			'keanggotaan_id' => 'Keanggotaan',
			'tglpermintaanberhenti' => 'Tglpermintaanberhenti',
			'tglberhenti_dipecat' => 'Tglberhenti Dipecat',
			'sebabberhenti' => 'Sebabberhenti',
			'alasanberhenti' => 'Alasanberhenti',
			'tgldisetujuiperm' => 'Tgldisetujuiperm',
			'mengetahui' => 'Mengetahui',
			'unit_id' => 'Unit',
			'namaunit' => 'Unit',
			'photopegawai' => 'Photopegawai',
			'norekening' => 'No Nekening',
			'banknorekening' => 'Banknorekening',
			'npwp' => 'Npwp',
			'kategoripegawai' => 'Kategoripegawai',
			'jeniswaktukerja' => 'Jeniswaktukerja',
			'notelp_pegawai' => 'Notelp Pegawai',
			'nomobile_pegawai' => 'Nomobile Pegawai',
			'statusperkawinan' => 'Statusperkawinan',
			'agama' => 'Agama',
			'jenisidentitas' => 'Jenisidentitas',
			'noidentitas' => 'Noidentitas',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
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
		// $criteria->join='left join pegawai_m pegawai on pegawai.pegawai_id = t.pegawai_id left join golonganpegawai_m golonganpegawai on golonganpegawai.golonganpegawai_id = pegawai.golonganpegawai_id';
		//$criteria->compare('golonganpegawai.golonganpegawai_nama',$this->golonganpegawai_nama);
		if(!empty($this->golonganpegawai_id)) $criteria->addCondition('t.golonganpegawai_id = '.$this->golonganpegawai_id);
		//$criteria->compare('pegawai.golonganpegawai_id',$this->golonganpegawai_id);
		if(!empty($this->pegawai_id)) $criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		//$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('lower(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('lower(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',  strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('t.nama_keluarga',$this->nama_keluarga,true);
		$criteria->compare('lower(t.tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('t.tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('lower(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('lower(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('t.tglkeanggotaaan',$this->tglkeanggotaaan,true);
		$criteria->compare('t.nokeanggotaan',$this->nokeanggotaan,true);
		if(!empty($this->keanggotaan_id)) $criteria->addCondition('t.keanggotaan_id = '.$this->keanggotaan_id);
		//$criteria->compare('t.keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('t.tglpermintaanberhenti',$this->tglpermintaanberhenti,true);
		$criteria->compare('t.tglberhenti_dipecat',$this->tglberhenti_dipecat,true);
		$criteria->compare('t.sebabberhenti',$this->sebabberhenti,true);
		$criteria->compare('t.alasanberhenti',$this->alasanberhenti,true);
		$criteria->compare('t.tgldisetujuiperm',$this->tgldisetujuiperm,true);
		$criteria->compare('t.mengetahui',$this->mengetahui,true);
		
		$criteria->compare('t.photopegawai',$this->photopegawai,true);
		$criteria->compare('t.no_rekening',$this->no_rekening,true);
		$criteria->compare('t.bank_no_rekening',$this->bank_no_rekening,true);
		$criteria->compare('t.npwp',$this->npwp,true);
		$criteria->compare('t.kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('t.jeniswaktukerja',$this->jeniswaktukerja,true);
		$criteria->compare('t.notelp_pegawai',$this->notelp_pegawai,true);
		$criteria->compare('t.nomobile_pegawai',$this->nomobile_pegawai,true);
		$criteria->compare('t.statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('t.agama',$this->agama,true);
		$criteria->compare('t.jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('t.noidentitas',$this->noidentitas,true);
		$criteria->compare('t.nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('t.jabatan_id',$this->jabatan_id);
		$criteria->compare('lower(t.jabatan_nama)',strtolower($this->jabatan_nama),true);
		if(!empty($this->pangkat_id)) $criteria->addCondition('t.pangkat_id = '.$this->pangkat_id);
		//$criteria->compare('t.pangkat_id',$this->pangkat_id);
		$criteria->compare('t.pangkat_nama',$this->pangkat_nama,true);
		$criteria->order='t.tglkeanggotaaan desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint() {
		$criteria = $this->search()->criteria;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination'=>false,
		));
	}

	public $no_pinjaman, $tglpinjaman, $jml_pinjaman;
	public function searchAnggotaPeminjam() {
		$criteria = new CDbCriteria;
		$criteria->select = 't.*, p.no_pinjaman, p.tglpinjaman, p.jml_pinjaman';
		$criteria->join = 'join pinjaman_t p on p.keanggotaan_id = t.keanggotaan_id';

		$criteria->compare('lower(t.nokeanggotaan)',strtolower($this->nokeanggotaan),true);
		$criteria->compare('lower(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->unit_id))$criteria->addCondition('unit_id = '.$this->unit_id);
		//$criteria->compare('unit_id',$this->unit_id);
		return new CActiveDataProvider($this, array('criteria'=>$criteria));
	}

	public function searchAnggotaSimpananSD() {
		$criteria = $this->searchAnggota()->criteria;
		$criteria->group = "
			t.unit_id, t.namaunit, t.golonganpegawai_nama, t.golonganpegawai_id, t.jeniskelamin, t.alamat_pegawai,
			t.nomorindukpegawai, t.no_kartupegawainegerisipil, t.noidentitas,
			t.nama_pegawai, t.tempatlahir_pegawai, t.nokeanggotaan
		";
		$criteria->select = $criteria->group;
		$criteria->join = "join simpanan_t s on s.keanggotaan_id = t.keanggotaan_id";
		$criteria->addCondition('s.jenissimpanan_id in(3,4)');
		//$criteria->compare("s.jenissimpanan_id", array(3,4));
		$criteria->addCondition('s.pemintaanberhenti_id is null and s.pengambilansimpanan_id is null');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchAnggota() {
		//var_dump($this->attributes); die;

		$criteria = new CDbCriteria;

		//$criteria->with = array('pegawai');
		if(!empty($this->unit_id))$criteria->addCondition('t.unit_id = '.$this->unit_id);
		//$criteria->compare('t.unit_id', $this->unit_id);
		if(!empty($this->golonganpegawai_id))$criteria->addCondition('t.golonganpegawai_id = '.$this->golonganpegawai_id);
		//$criteria->compare('t.golonganpegawai_id', $this->golonganpegawai_id);
		$criteria->compare('lower(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('lower(t.alamat_pegawai)', strtolower($this->alamat_pegawai), true);
		$criteria->compare('lower(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
		$criteria->compare('lower(t.no_kartupegawainegerisipil)', strtolower($this->no_kartupegawainegerisipil), true);
		$criteria->compare('lower(t.noidentitas)', strtolower($this->noidentitas), true);
		$criteria->compare('lower(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
		$criteria->compare('lower(t.tempatlahir_pegawai)', strtolower($this->tempatlahir_pegawai), true);
		$criteria->compare('lower(t.nokeanggotaan)', strtolower($this->nokeanggotaan), true);
		$criteria->order='t.nama_pegawai';
		return new CActiveDataProvider($this, array('criteria'=>$criteria));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KeanggotaanV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getNamaGolongan(){
		$id = PegawaiM::model()->findByPk($this->pegawai_id);
									$golongan = GolonganpegawaiM::model()->findByPk($id->golonganpegawai_id);
									return $golongan->golonganpegawai_nama;
	}
        
        public function getNamaLengkap()
        {
            return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
        }
}
