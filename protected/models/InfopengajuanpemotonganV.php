<?php

/**
 * This is the model class for table "infopengajuanpemotongan_v".
 *
 * The followings are the available columns in table 'infopengajuanpemotongan_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $alamat_pegawai
 * @property string $kategoripegawai
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $keanggotaan_id
 * @property string $nokeanggotaan
 * @property integer $potongansumber_id
 * @property string $namapotongan
 * @property integer $pengajuanpembayaran_id
 * @property string $tglpengajuanpemb
 * @property string $nopengajuan
 * @property string $tglpembjthtempo
 * @property string $sampaidgntgljthtempo
 * @property double $simpananwajib
 * @property double $simpanansukarela
 * @property double $jmlpokok_pengangs
 * @property double $jmljasaangs_pengangs
 * @property double $jmldendaangs_pengangs
 * @property double $jmlpengajuan_pengangsuran
 * @property double $jmlsisapeng_pengangs
 * @property integer $pembayaranangsuran_id
 * @property string $tglpembayaranangsuran
 * @property integer $byrangsuranke
 * @property integer $lamahari_sdhjthtempo
 * @property double $jmlsisa_pembangsuran
 * @property double $jmlbayar_pembangsuran
 * @property integer $buktikasmasukkop_id
 * @property string $tglbuktibayar
 * @property string $nobuktimasuk
 * @property string $carapembayaran
 * @property string $sebagaipembayaran_bkm
 * @property double $jmlpembayaran
 * @property double $uangditerima
 * @property string $tgldibuat_pengpemb
 * @property integer $dibuatoleh_id_pengpemb
 * @property string $tgldiperiksa_pengpemb
 * @property integer $diperiksaoleh_id_pengpemb
 * @property string $tgldisetujui_pengpemb
 * @property integer $disetujuioleh_id_pengpemb
 */
class InfopengajuanpemotonganV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopengajuanpemotonganV the static model class
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
		return 'infopengajuanpotongan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, golonganpegawai_id, jabatan_id, pangkat_id, keanggotaan_id, potongansumber_id, pengajuanpembayaran_id, pembayaranangsuran_id, byrangsuranke, lamahari_sdhjthtempo, buktikasmasukkop_id, dibuatoleh_id_pengpemb, diperiksaoleh_id_pengpemb, disetujuioleh_id_pengpemb', 'numerical', 'integerOnly'=>true),
			array('simpananwajib, simpanansukarela, jmlpokok_pengangs, jmljasaangs_pengangs, jmldendaangs_pengangs, jmlpengajuan_pengangsuran, jmlsisapeng_pengangs, jmlsisa_pembangsuran, jmlbayar_pembangsuran, jmlpembayaran, uangditerima', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, golonganpegawai_nama, pangkat_nama, nokeanggotaan, nopengajuan, nobuktimasuk, carapembayaran', 'length', 'max'=>50),
			array('jeniskelamin', 'length', 'max'=>20),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama, namapotongan, sebagaipembayaran_bkm', 'length', 'max'=>100),
			array('tgl_lahirpegawai, alamat_pegawai, tglpengajuanpemb, tglpembjthtempo, sampaidgntgljthtempo, tglpembayaranangsuran, tglbuktibayar, tgldibuat_pengpemb, tgldiperiksa_pengpemb, tgldisetujui_pengpemb', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, alamat_pegawai, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, jabatan_id, jabatan_nama, pangkat_id, pangkat_nama, keanggotaan_id, nokeanggotaan, potongansumber_id, namapotongan, pengajuanpembayaran_id, tglpengajuanpemb, nopengajuan, tglpembjthtempo, sampaidgntgljthtempo, simpananwajib, simpanansukarela, jmlpokok_pengangs, jmljasaangs_pengangs, jmldendaangs_pengangs, jmlpengajuan_pengangsuran, jmlsisapeng_pengangs, pembayaranangsuran_id, tglpembayaranangsuran, byrangsuranke, lamahari_sdhjthtempo, jmlsisa_pembangsuran, jmlbayar_pembangsuran, buktikasmasukkop_id, tglbuktibayar, nobuktimasuk, carapembayaran, sebagaipembayaran_bkm, jmlpembayaran, uangditerima, tgldibuat_pengpemb, dibuatoleh_id_pengpemb, tgldiperiksa_pengpemb, diperiksaoleh_id_pengpemb, tgldisetujui_pengpemb, disetujuioleh_id_pengpemb', 'safe', 'on'=>'search'),
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
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kategoripegawai' => 'Kategoripegawai',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'keanggotaan_id' => 'Keanggotaan',
			'nokeanggotaan' => 'No Keanggotaan',
			'potongansumber_id' => 'Potongan Sumber',
			'namapotongan' => 'Namapotongan',
			'pengajuanpembayaran_id' => 'Pengajuanpembayaran',
			'tglpengajuanpemb' => 'Tglpengajuanpemb',
			'nopengajuan' => 'No. Pengajuan',
			'tglpembjthtempo' => 'Tglpembjthtempo',
			'sampaidgntgljthtempo' => 'Sampaidgntgljthtempo',
			'simpananwajib' => 'Simpananwajib',
			'simpanansukarela' => 'Simpanansukarela',
			'jmlpokok_pengangs' => 'Jmlpokok Pengangs',
			'jmljasaangs_pengangs' => 'Jmljasaangs Pengangs',
			'jmldendaangs_pengangs' => 'Jmldendaangs Pengangs',
			'jmlpengajuan_pengangsuran' => 'Jmlpengajuan Pengangsuran',
			'jmlsisapeng_pengangs' => 'Jmlsisapeng Pengangs',
			'pembayaranangsuran_id' => 'Pembayaranangsuran',
			'tglpembayaranangsuran' => 'Tglpembayaranangsuran',
			'byrangsuranke' => 'Byrangsuranke',
			'lamahari_sdhjthtempo' => 'Lamahari Sdhjthtempo',
			'jmlsisa_pembangsuran' => 'Jmlsisa Pembangsuran',
			'jmlbayar_pembangsuran' => 'Jmlbayar Pembangsuran',
			'buktikasmasukkop_id' => 'Buktikasmasukkop',
			'tglbuktibayar' => 'Tglbuktibayar',
			'nobuktimasuk' => 'Nobuktimasuk',
			'carapembayaran' => 'Carapembayaran',
			'sebagaipembayaran_bkm' => 'Sebagaipembayaran Bkm',
			'jmlpembayaran' => 'Jmlpembayaran',
			'uangditerima' => 'Uang Diterima',
			'tgldibuat_pengpemb' => 'Tgldibuat Pengpemb',
			'dibuatoleh_id_pengpemb' => 'Dibuatoleh Id Pengpemb',
			'tgldiperiksa_pengpemb' => 'Tgldiperiksa Pengpemb',
			'diperiksaoleh_id_pengpemb' => 'Diperiksaoleh Id Pengpemb',
			'tgldisetujui_pengpemb' => 'Tgldisetujui Pengpemb',
			'disetujuioleh_id_pengpemb' => 'Disetujuioleh Id Pengpemb',
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
		$criteria->compare('tempatlahir_pegawai',$this->tempatlahir_pegawai,true);
		$criteria->compare('tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('pangkat_nama',$this->pangkat_nama,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('potongansumber_id',$this->potongansumber_id);
		$criteria->compare('namapotongan',$this->namapotongan,true);
		$criteria->compare('pengajuanpembayaran_id',$this->pengajuanpembayaran_id);
		$criteria->compare('tglpengajuanpemb',$this->tglpengajuanpemb,true);
		$criteria->compare('nopengajuan',$this->nopengajuan,true);
		$criteria->compare('tglpembjthtempo',$this->tglpembjthtempo,true);
		$criteria->compare('sampaidgntgljthtempo',$this->sampaidgntgljthtempo,true);
		$criteria->compare('simpananwajib',$this->simpananwajib);
		$criteria->compare('simpanansukarela',$this->simpanansukarela);
		$criteria->compare('jmlpokok_pengangs',$this->jmlpokok_pengangs);
		$criteria->compare('jmljasaangs_pengangs',$this->jmljasaangs_pengangs);
		$criteria->compare('jmldendaangs_pengangs',$this->jmldendaangs_pengangs);
		$criteria->compare('jmlpengajuan_pengangsuran',$this->jmlpengajuan_pengangsuran);
		$criteria->compare('jmlsisapeng_pengangs',$this->jmlsisapeng_pengangs);
		$criteria->compare('pembayaranangsuran_id',$this->pembayaranangsuran_id);
		$criteria->compare('tglpembayaranangsuran',$this->tglpembayaranangsuran,true);
		$criteria->compare('byrangsuranke',$this->byrangsuranke);
		$criteria->compare('lamahari_sdhjthtempo',$this->lamahari_sdhjthtempo);
		$criteria->compare('jmlsisa_pembangsuran',$this->jmlsisa_pembangsuran);
		$criteria->compare('jmlbayar_pembangsuran',$this->jmlbayar_pembangsuran);
		$criteria->compare('buktikasmasukkop_id',$this->buktikasmasukkop_id);
		$criteria->compare('tglbuktibayar',$this->tglbuktibayar,true);
		$criteria->compare('nobuktimasuk',$this->nobuktimasuk,true);
		$criteria->compare('carapembayaran',$this->carapembayaran,true);
		$criteria->compare('sebagaipembayaran_bkm',$this->sebagaipembayaran_bkm,true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('uangditerima',$this->uangditerima);
		$criteria->compare('tgldibuat_pengpemb',$this->tgldibuat_pengpemb,true);
		$criteria->compare('dibuatoleh_id_pengpemb',$this->dibuatoleh_id_pengpemb);
		$criteria->compare('tgldiperiksa_pengpemb',$this->tgldiperiksa_pengpemb,true);
		$criteria->compare('diperiksaoleh_id_pengpemb',$this->diperiksaoleh_id_pengpemb);
		$criteria->compare('tgldisetujui_pengpemb',$this->tgldisetujui_pengpemb,true);
		$criteria->compare('disetujuioleh_id_pengpemb',$this->disetujuioleh_id_pengpemb);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchInformasi() {
		$provider = $this->search();

		$provider->criteria->select = $provider->criteria->group =
		'nopengajuan, tglpengajuanpemb, namaunit, namapotongan, nokeanggotaan, nama_pegawai,
		simpananwajib, simpanansukarela, jmlpokok_pengangs, jmljasaangs_pengangs, jmljasaangs_pengangs,
		jmlpengajuan_pengangsuran, jmlpengajuan_pengangsuran, pengajuanpembayaran_id, potongansumber_id, jmldendaangs_pengangs
		 ';

		return $provider;
	}

	public function searchNoPermintaan() {
		$criteria = new CDbCriteria();
		//$criteria->join = "left join pembayaranangsuran_t p on p.pengajuanpembayaran_id = t.pengajuanpembayaran_id";
		$criteria->select = $criteria->group = "t.potongansumber_id, t.tglpengajuanpemb, t.nopengajuan, t.dibuatoleh_id_pengpemb, t.diperiksaoleh_id_pengpemb, t.disetujuioleh_id_pengpemb";
		$criteria->addCondition('t.buktikasmasukkop_id is null');
		$criteria->compare('lower(t.nopengajuan)', strtolower($this->nopengajuan), true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}