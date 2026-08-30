<?php

/**
 * This is the model class for table "infopinjaman_v".
 *
 * The followings are the available columns in table 'infopinjaman_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $agama
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property string $kode_pos
 * @property string $kategoripegawai
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $keanggotaan_id
 * @property string $nokeanggotaan
 * @property integer $pinjaman_id
 * @property string $tglpinjaman
 * @property string $jatuh_tempo
 * @property string $no_pinjaman
 * @property double $jml_pinjaman
 * @property integer $jangka_waktu_bln
 * @property double $persen_jasa_pinjaman
 * @property integer $jml_kali_angsur
 * @property double $jasapinjaman
 * @property double $biaya_administrasi
 * @property double $biaya_materai
 * @property string $untuk_keperluan
 * @property string $jaminan_berupa
 * @property integer $permohonanpinjaman_id
 * @property string $tglpermohonanpinjaman
 * @property string $nopermohonan
 * @property integer $approval_id
 * @property string $tglapproval
 * @property integer $potonganasuransi_id
 * @property string $tglpotonganasuransi
 * @property integer $umuranggota_thn
 * @property integer $lamaasuransi_thn
 * @property double $premi_asuransi_persen
 * @property double $jml_biayaasuransi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InfopinjamanV extends CActiveRecord
{
        public $tglAwal, $tglAkhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopinjamanV the static model class
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
		return 'infopinjaman_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, kelurahan_id, golonganpegawai_id, pangkat_id, jabatan_id, keanggotaan_id, pinjaman_id, jangka_waktu_bln, jml_kali_angsur, permohonanpinjaman_id, approval_id, potonganasuransi_id, umuranggota_thn, lamaasuransi_thn, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jml_pinjaman, persen_jasa_pinjaman, jasapinjaman, biaya_administrasi, biaya_materai, premi_asuransi_persen, jml_biayaasuransi', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, kelurahan_nama, golonganpegawai_nama, pangkat_nama, nokeanggotaan, no_pinjaman, nopermohonan', 'length', 'max'=>50),
			array('gelarbelakang_nama, kode_pos', 'length', 'max'=>15),
			array('jeniskelamin, agama, statusperkawinan', 'length', 'max'=>20),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama, jaminan_berupa', 'length', 'max'=>100),
			array('tgl_lahirpegawai, alamat_pegawai, tglpinjaman, jatuh_tempo, untuk_keperluan, tglpermohonanpinjaman, tglapproval, tglpotonganasuransi, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, agama, statusperkawinan, alamat_pegawai, kelurahan_id, kelurahan_nama, kode_pos, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, pangkat_id, pangkat_nama, jabatan_id, jabatan_nama, keanggotaan_id, nokeanggotaan, pinjaman_id, tglpinjaman, jatuh_tempo, no_pinjaman, jml_pinjaman, jangka_waktu_bln, persen_jasa_pinjaman, jml_kali_angsur, jasapinjaman, biaya_administrasi, biaya_materai, untuk_keperluan, jaminan_berupa, permohonanpinjaman_id, tglpermohonanpinjaman, nopermohonan, approval_id, tglapproval, potonganasuransi_id, tglpotonganasuransi, umuranggota_thn, lamaasuransi_thn, premi_asuransi_persen, jml_biayaasuransi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'agama' => 'Agama',
			'statusperkawinan' => 'Statusperkawinan',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kode_pos' => 'Kode Pos',
			'kategoripegawai' => 'Kategoripegawai',
			'golonganpegawai_id' => 'Golongan',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'keanggotaan_id' => 'Keanggotaan',
			'nokeanggotaan' => 'Nokeanggotaan',
			'pinjaman_id' => 'Pinjaman',
			'tglpinjaman' => 'Tglpinjaman',
			'jatuh_tempo' => 'Jatuh Tempo',
			'no_pinjaman' => 'No Pinjaman',
			'jml_pinjaman' => 'Jml Pinjaman',
			'jangka_waktu_bln' => 'Jangka Waktu Bln',
			'persen_jasa_pinjaman' => 'Persen Jasa Pinjaman',
			'jml_kali_angsur' => 'Jml Kali Angsur',
			'jasapinjaman' => 'Jasapinjaman',
			'biaya_administrasi' => 'Biaya Administrasi',
			'biaya_materai' => 'Biaya Materai',
			'untuk_keperluan' => 'Untuk Keperluan',
			'jaminan_berupa' => 'Jaminan Berupa',
			'permohonanpinjaman_id' => 'Permohonanpinjaman',
			'tglpermohonanpinjaman' => 'Tglpermohonanpinjaman',
			'nopermohonan' => 'Nopermohonan',
			'approval_id' => 'Approval',
			'tglapproval' => 'Tglapproval',
			'potonganasuransi_id' => 'Potonganasuransi',
			'tglpotonganasuransi' => 'Tglpotonganasuransi',
			'umuranggota_thn' => 'Umuranggota Thn',
			'lamaasuransi_thn' => 'Lamaasuransi Thn',
			'premi_asuransi_persen' => 'Premi Asuransi Persen',
			'jml_biayaasuransi' => 'Jml Biayaasuransi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('tempatlahir_pegawai',$this->tempatlahir_pegawai,true);
		$criteria->compare('tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kode_pos',$this->kode_pos,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('pangkat_nama',$this->pangkat_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('pinjaman_id',$this->pinjaman_id);
		$criteria->compare('tglpinjaman',$this->tglpinjaman,true);
		$criteria->compare('jatuh_tempo',$this->jatuh_tempo,true);
		$criteria->compare('no_pinjaman',$this->no_pinjaman,true);
		$criteria->compare('jml_pinjaman',$this->jml_pinjaman);
		$criteria->compare('jangka_waktu_bln',$this->jangka_waktu_bln);
		$criteria->compare('persen_jasa_pinjaman',$this->persen_jasa_pinjaman);
		$criteria->compare('jml_kali_angsur',$this->jml_kali_angsur);
		$criteria->compare('jasapinjaman',$this->jasapinjaman);
		$criteria->compare('biaya_administrasi',$this->biaya_administrasi);
		$criteria->compare('biaya_materai',$this->biaya_materai);
		$criteria->compare('untuk_keperluan',$this->untuk_keperluan,true);
		$criteria->compare('jaminan_berupa',$this->jaminan_berupa,true);
		$criteria->compare('permohonanpinjaman_id',$this->permohonanpinjaman_id);
		$criteria->compare('tglpermohonanpinjaman',$this->tglpermohonanpinjaman,true);
		$criteria->compare('nopermohonan',$this->nopermohonan,true);
		$criteria->compare('approval_id',$this->approval_id);
		$criteria->compare('tglapproval',$this->tglapproval,true);
		$criteria->compare('potonganasuransi_id',$this->potonganasuransi_id);
		$criteria->compare('tglpotonganasuransi',$this->tglpotonganasuransi,true);
		$criteria->compare('umuranggota_thn',$this->umuranggota_thn);
		$criteria->compare('lamaasuransi_thn',$this->lamaasuransi_thn);
		$criteria->compare('premi_asuransi_persen',$this->premi_asuransi_persen);
		$criteria->compare('jml_biayaasuransi',$this->jml_biayaasuransi);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPeminjamAsuransi() {
		$criteria = new CDbCriteria;
		//$criteria->addCondition('potonganasuransi_id is not null');
		$criteria->join = 'join potonganasuransi_t p on p.potonganasuransi_id = t.potonganasuransi_id';
		$criteria->addCondition('p.buktikaskeluarkop_id is null');

		if(!empty($this->unit_id))$criteria->addCondition('t.unit_id = '.$this->unit_id);
		//$criteria->compare('t.unit_id',$this->unit_id);
		if(!empty($this->golonganpegawai_id))$criteria->addCondition('t.golonganpegawai_id = '.$this->golonganpegawai_id);
		//$criteria->compare('t.golonganpegawai_id',$this->golonganpegawai_id);

		if ($this->tglAwal != null && $this->tglAkhir != null) {
			$criteria->addBetweenCondition('t.tglpinjaman', $this->tglAwal, $this->tglAkhir);
		} else {
			$criteria->compare('t.tglpinjam', '-');
		}

		//var_dump($this->tglAwal); die;
		//var_dump($criteria); die;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}