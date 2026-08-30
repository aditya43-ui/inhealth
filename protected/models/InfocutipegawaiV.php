<?php

/**
 * This is the model class for table "infocutipegawai_v".
 *
 * The followings are the available columns in table 'infocutipegawai_v':
 * @property integer $pegawaicuti_id
 * @property string $tglmulaicuti
 * @property string $tglakhircuti
 * @property string $lamacuti
 * @property string $noskcuti
 * @property string $tglditetapkanskcuti
 * @property string $keterangan
 * @property string $keperluancuti
 * @property string $gelardepan
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $jabatan_nama
 * @property integer $jeniscuti_id
 * @property string $jeniscuti_nama
 * @property string $pegmengetahui_gelardepan
 * @property integer $pejabatmengetahui
 * @property string $pegmengetahui
 * @property string $pegmengetahui_gelarblkg
 * @property string $pegmengetahui_jabatan
 * @property string $tgl_menyetujui
 * @property string $pegmenyetujui_gelardepan
 * @property integer $pejabatmenyetujui
 * @property string $pegmenyetujui
 * @property string $pegmenyetujui_gelarblkg
 * @property string $pegmenyetujui_jabatan
 * @property string $tanggal_transaksi
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $user_pembuat
 * @property integer $pengganti_id
 * @property string $nama_pengganti
 * @property string $pengganti_jabatan
 * @property string $gelardepan_pengganti
 * @property string $gelarbelakang_pengganti
 * @property string $status_cuti
 */
class InfocutipegawaiV extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $pengganti;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfocutipegawaiV the static model class
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
		return 'infocutipegawai_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawaicuti_id, pegawai_id, jeniscuti_id, pejabatmengetahui, pejabatmenyetujui, ruangan_id, user_pembuat, pengganti_id', 'numerical', 'integerOnly'=>true),
			array('lamacuti, noskcuti, tglditetapkanskcuti, gelardepan, pegmengetahui_gelardepan, pegmenyetujui_gelardepan, gelardepan_pengganti', 'length', 'max'=>10),
			array('nama_pegawai, pegmengetahui, pegmenyetujui, ruangan_nama, nama_pengganti, status_cuti', 'length', 'max'=>50),
			array('gelarbelakang_nama, pegmengetahui_gelarblkg, pegmenyetujui_gelarblkg, gelarbelakang_pengganti', 'length', 'max'=>15),
			array('jabatan_nama, jeniscuti_nama, pegmengetahui_jabatan, pegmenyetujui_jabatan, pengganti_jabatan', 'length', 'max'=>100),
			array('tglmulaicuti, tglakhircuti, keterangan, keperluancuti, tgl_menyetujui, tanggal_transaksi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawaicuti_id, tglmulaicuti, tglakhircuti, lamacuti, noskcuti, tglditetapkanskcuti, keterangan, keperluancuti, gelardepan, pegawai_id, nama_pegawai, gelarbelakang_nama, jabatan_nama, jeniscuti_id, jeniscuti_nama, pegmengetahui_gelardepan, pejabatmengetahui, pegmengetahui, pegmengetahui_gelarblkg, pegmengetahui_jabatan, tgl_menyetujui, pegmenyetujui_gelardepan, pejabatmenyetujui, pegmenyetujui, pegmenyetujui_gelarblkg, pegmenyetujui_jabatan, tanggal_transaksi, ruangan_id, ruangan_nama, user_pembuat, pengganti_id, nama_pengganti, pengganti_jabatan, gelardepan_pengganti, gelarbelakang_pengganti, status_cuti', 'safe', 'on'=>'search'),
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
			'pegawaicuti_id' => 'Pegawaicuti',
			'tglmulaicuti' => 'Mulai Cuti',
			'tglakhircuti' => 'Akhir Cuti',
			'lamacuti' => 'Lama Cuti',
			'noskcuti' => 'No SK',
			'tglditetapkanskcuti' => 'Tanggal Ditetapkan',
			'keterangan' => 'Keterangan',
			'keperluancuti' => 'Keperluan Cuti',
			'gelardepan' => 'Gelardepan',
			'pegawai_id' => 'Yang Mengajukan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'jabatan_nama' => 'Jabatan Nama',
			'jeniscuti_id' => 'Jenis Cuti',
			'jeniscuti_nama' => 'Jeniscuti Nama',
			'pegmengetahui_gelardepan' => 'Pegmengetahui Gelardepan',
			'pejabatmengetahui' => 'Atasan Langsung',
			'pegmengetahui' => 'Mengetahui',
			'pegmengetahui_gelarblkg' => 'Pegmengetahui Gelarblkg',
			'pegmengetahui_jabatan' => 'Pegmengetahui Jabatan',
			'tgl_menyetujui' => 'Tgl. Menyetujui',
			'pegmenyetujui_gelardepan' => 'Pegmenyetujui Gelardepan',
			'pejabatmenyetujui' => 'Kabag Umum',
			'pegmenyetujui' => 'Menyetujui',
			'pegmenyetujui_gelarblkg' => 'Pegmenyetujui Gelarblkg',
			'pegmenyetujui_jabatan' => 'Pegmenyetujui Jabatan',
			'tanggal_transaksi' => 'Tanggal Transaksi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'user_pembuat' => 'User Pembuat',
			'pengganti_id' => 'Pengganti',
			'nama_pengganti' => 'Nama Pengganti',
			'pengganti_jabatan' => 'Pengganti Jabatan',
			'gelardepan_pengganti' => 'Gelardepan Pengganti',
			'gelarbelakang_pengganti' => 'Gelarbelakang Pengganti',
			'status_cuti' => 'Status Cuti',
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

		$criteria->compare('pegawaicuti_id',$this->pegawaicuti_id);
		$criteria->compare('tglmulaicuti',$this->tglmulaicuti,true);
		$criteria->compare('tglakhircuti',$this->tglakhircuti,true);
		$criteria->compare('lamacuti',$this->lamacuti,true);
		$criteria->compare('noskcuti',$this->noskcuti,true);
		$criteria->compare('tglditetapkanskcuti',$this->tglditetapkanskcuti,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('keperluancuti',$this->keperluancuti,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('jeniscuti_id',$this->jeniscuti_id);
		$criteria->compare('jeniscuti_nama',$this->jeniscuti_nama,true);
		$criteria->compare('pegmengetahui_gelardepan',$this->pegmengetahui_gelardepan,true);
		$criteria->compare('pejabatmengetahui',$this->pejabatmengetahui);
		$criteria->compare('pegmengetahui',$this->pegmengetahui,true);
		$criteria->compare('pegmengetahui_gelarblkg',$this->pegmengetahui_gelarblkg,true);
		$criteria->compare('pegmengetahui_jabatan',$this->pegmengetahui_jabatan,true);
		$criteria->compare('tgl_menyetujui',$this->tgl_menyetujui,true);
		$criteria->compare('pegmenyetujui_gelardepan',$this->pegmenyetujui_gelardepan,true);
		$criteria->compare('pejabatmenyetujui',$this->pejabatmenyetujui);
		$criteria->compare('pegmenyetujui',$this->pegmenyetujui,true);
		$criteria->compare('pegmenyetujui_gelarblkg',$this->pegmenyetujui_gelarblkg,true);
		$criteria->compare('pegmenyetujui_jabatan',$this->pegmenyetujui_jabatan,true);
		$criteria->compare('tanggal_transaksi',$this->tanggal_transaksi,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('user_pembuat',$this->user_pembuat);
		$criteria->compare('pengganti_id',$this->pengganti_id);
		$criteria->compare('nama_pengganti',$this->nama_pengganti,true);
		$criteria->compare('pengganti_jabatan',$this->pengganti_jabatan,true);
		$criteria->compare('gelardepan_pengganti',$this->gelardepan_pengganti,true);
		$criteria->compare('gelarbelakang_pengganti',$this->gelarbelakang_pengganti,true);
		$criteria->compare('status_cuti',$this->status_cuti,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * - digunakan untuk menampilkan nama lengkap yang mengajukan beserta gelarnya
         * @return type
         */
        public function getNamaLengkapPemohon(){
            return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
        }
        
        /**
         * - digunakan untuk menampilkan nama lengkap yang mengetahui beserta gelarnya
         * @return type
         */
        public function getNamaLengkapMengetahui(){
            return $this->pegmengetahui_gelardepan.' '.$this->pegmengetahui.' '.$this->pegmengetahui_gelarblkg;
        }
        
        /**
         * - digunakan untuk menampilkan nama lengkap yang menyetujui beserta gelarnya
         * @return type
         */
        public function getNamaLengkapMenyetujui(){
            return $this->pegmenyetujui_gelardepan.' '.$this->pegmenyetujui.' '.$this->pegmenyetujui_gelarblkg;
        }
        
        /**
         * - digunakan untuk menampilkan nama lengkap pegawai pengganti beserta gelarnya
         * @return type
         */
        public function getNamaLengkapPengganti(){
            return $this->gelardepan_pengganti.' '.$this->nama_pengganti.' '.$this->gelarbelakang_pengganti;
        }
}