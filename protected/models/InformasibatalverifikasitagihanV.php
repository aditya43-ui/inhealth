<?php

/**
 * This is the model class for table "informasibatalverifikasitagihan_v".
 *
 * The followings are the available columns in table 'informasibatalverifikasitagihan_v':
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $tindakanpelayanan_id
 * @property string $tgl_tindakan
 * @property string $nopelayanan
 * @property integer $ruangantindakan_id
 * @property string $ruangantindakan_nama
 * @property integer $instalasitindakan_id
 * @property string $intalasitindakan_nama
 * @property string $daftartindakan_nama
 * @property integer $verifrenctindakan_id
 * @property string $tglverifikasirenc
 * @property string $noverifikasi_renc
 * @property string $keterangan_verifrenc
 * @property integer $petugas_verif_id
 * @property string $petugas_verif_nama
 * @property integer $mengetahui_id
 * @property string $mengetahui_nama
 * @property integer $bataltindakanpelayanan_id
 * @property integer $petugasbatal_id
 * @property string $petugasbatal_nama
 */
class InformasibatalverifikasitagihanV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasibatalverifikasitagihan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, ruangan_id, instalasi_id, pegawai_id, gelarbelakang_id, carabayar_id, penjamin_id, ruangantindakan_id, instalasitindakan_id, verifrenctindakan_id, petugas_verif_id, mengetahui_id, bataltindakanpelayanan_id, petugasbatal_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran, namadepan', 'length', 'max'=>20),
			array('ruangan_nama, instalasi_nama, penjamin_nama, nama_pasien, ruangantindakan_nama, intalasitindakan_nama', 'length', 'max'=>100),
			array('gelardepan, no_rekam_medik', 'length', 'max'=>10),
			array('nama_pegawai, carabayar_nama, nopelayanan, noverifikasi_renc, petugas_verif_nama, mengetahui_nama, petugasbatal_nama', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('daftartindakan_nama', 'length', 'max'=>400),
			array('tgl_pendaftaran, tindakanpelayanan_id, tgl_tindakan, tglverifikasirenc, keterangan_verifrenc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pendaftaran_id, no_pendaftaran, tgl_pendaftaran, pasien_id, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, no_rekam_medik, namadepan, nama_pasien, tindakanpelayanan_id, tgl_tindakan, nopelayanan, ruangantindakan_id, ruangantindakan_nama, instalasitindakan_id, intalasitindakan_nama, daftartindakan_nama, verifrenctindakan_id, tglverifikasirenc, noverifikasi_renc, keterangan_verifrenc, petugas_verif_id, petugas_verif_nama, mengetahui_id, mengetahui_nama, bataltindakanpelayanan_id, petugasbatal_id, petugasbatal_nama', 'safe', 'on'=>'search'),
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
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'pasien_id' => 'Pasien',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'no_rekam_medik' => 'No Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'tgl_tindakan' => 'Tgl Tindakan',
			'nopelayanan' => 'Nopelayanan',
			'ruangantindakan_id' => 'Ruangantindakan',
			'ruangantindakan_nama' => 'Ruangantindakan Nama',
			'instalasitindakan_id' => 'Instalasitindakan',
			'intalasitindakan_nama' => 'Intalasitindakan Nama',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'verifrenctindakan_id' => 'Verifrenctindakan',
			'tglverifikasirenc' => 'Tglverifikasirenc',
			'noverifikasi_renc' => 'Noverifikasi Renc',
			'keterangan_verifrenc' => 'Keterangan Verifrenc',
			'petugas_verif_id' => 'Petugas Verif',
			'petugas_verif_nama' => 'Petugas Verif Nama',
			'mengetahui_id' => 'Mengetahui',
			'mengetahui_nama' => 'Mengetahui Nama',
			'bataltindakanpelayanan_id' => 'Bataltindakanpelayanan',
			'petugasbatal_id' => 'Petugasbatal',
			'petugasbatal_nama' => 'Petugasbatal Nama',
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

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id,true);
		$criteria->compare('tgl_tindakan',$this->tgl_tindakan,true);
		$criteria->compare('nopelayanan',$this->nopelayanan,true);
		$criteria->compare('ruangantindakan_id',$this->ruangantindakan_id);
		$criteria->compare('ruangantindakan_nama',$this->ruangantindakan_nama,true);
		$criteria->compare('instalasitindakan_id',$this->instalasitindakan_id);
		$criteria->compare('intalasitindakan_nama',$this->intalasitindakan_nama,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('verifrenctindakan_id',$this->verifrenctindakan_id);
		$criteria->compare('tglverifikasirenc',$this->tglverifikasirenc,true);
		$criteria->compare('noverifikasi_renc',$this->noverifikasi_renc,true);
		$criteria->compare('keterangan_verifrenc',$this->keterangan_verifrenc,true);
		$criteria->compare('petugas_verif_id',$this->petugas_verif_id);
		$criteria->compare('petugas_verif_nama',$this->petugas_verif_nama,true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('mengetahui_nama',$this->mengetahui_nama,true);
		$criteria->compare('bataltindakanpelayanan_id',$this->bataltindakanpelayanan_id);
		$criteria->compare('petugasbatal_id',$this->petugasbatal_id);
		$criteria->compare('petugasbatal_nama',$this->petugasbatal_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasibatalverifikasitagihanV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
