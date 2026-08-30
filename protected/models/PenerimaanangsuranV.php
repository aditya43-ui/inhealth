<?php

/**
 * This is the model class for table "penerimaanangsuran_v".
 *
 * The followings are the available columns in table 'penerimaanangsuran_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $alamat_pegawai
 * @property string $kategoripegawai
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $keanggotaan_id
 * @property string $nokeanggotaan
 * @property integer $angsuran_ke
 * @property string $tglangsuran
 * @property string $tgljatuhtempoangs
 * @property double $jmlpokok_angsuran
 * @property double $jmljasa_angsuran
 * @property double $jmldenda_angsuran
 * @property double $jmlpokok_byrangsuran
 * @property double $jmljasa_byrangsuran
 * @property double $jmldenda_byrangsuran
 * @property double $jmlsisa_pembangsuran
 * @property double $jmlbayar_pembangsuran
 * @property integer $pengajuanpembayaran_id
 * @property integer $potongansumber_id
 * @property string $namapotongan
 * @property integer $pinjaman_id
 * @property string $tglpengajuanpemb
 * @property string $tglpembjthtempo
 * @property string $sampaidgntgljthtempo
 * @property double $jmlpotongan_sumber
 * @property string $tgldibuat_pengpemb
 * @property integer $dibuatoleh_id_pengpemb
 * @property string $tgldiperiksa_pengpemb
 * @property integer $diperiksaoleh_id_pengpemb
 * @property string $tgldisetujui_pengpemb
 * @property integer $disetujuioleh_id_pengpemb
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property double $simpananwajib
 * @property double $simpanansukarela
 */
class PenerimaanangsuranV extends CActiveRecord
{
        public $nopengajuan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaanangsuranV the static model class
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
		return 'penerimaanangsuran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, golonganpegawai_id, jabatan_id, keanggotaan_id, angsuran_ke, pengajuanpembayaran_id, potongansumber_id, pinjaman_id, dibuatoleh_id_pengpemb, diperiksaoleh_id_pengpemb, disetujuioleh_id_pengpemb, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jmlpokok_angsuran, jmljasa_angsuran, jmldenda_angsuran, jmlpokok_byrangsuran, jmljasa_byrangsuran, jmldenda_byrangsuran, jmlsisa_pembangsuran, jmlbayar_pembangsuran, jmlpotongan_sumber, simpananwajib, simpanansukarela', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, golonganpegawai_nama, nokeanggotaan', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin', 'length', 'max'=>20),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama, namapotongan', 'length', 'max'=>100),
			array('tgl_lahirpegawai, alamat_pegawai, tglangsuran, tgljatuhtempoangs, tglpengajuanpemb, tglpembjthtempo, sampaidgntgljthtempo, tgldibuat_pengpemb, tgldiperiksa_pengpemb, tgldisetujui_pengpemb, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, alamat_pegawai, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, jabatan_id, jabatan_nama, keanggotaan_id, nokeanggotaan, angsuran_ke, tglangsuran, tgljatuhtempoangs, jmlpokok_angsuran, jmljasa_angsuran, jmldenda_angsuran, jmlpokok_byrangsuran, jmljasa_byrangsuran, jmldenda_byrangsuran, jmlsisa_pembangsuran, jmlbayar_pembangsuran, pengajuanpembayaran_id, potongansumber_id, namapotongan, pinjaman_id, tglpengajuanpemb, tglpembjthtempo, sampaidgntgljthtempo, jmlpotongan_sumber, tgldibuat_pengpemb, dibuatoleh_id_pengpemb, tgldiperiksa_pengpemb, diperiksaoleh_id_pengpemb, tgldisetujui_pengpemb, disetujuioleh_id_pengpemb, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, simpananwajib, simpanansukarela', 'safe', 'on'=>'search'),
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
			'alamat_pegawai' => 'Alamat Pegawai',
			'kategoripegawai' => 'Kategoripegawai',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'keanggotaan_id' => 'Keanggotaan',
			'nokeanggotaan' => 'Nokeanggotaan',
			'angsuran_ke' => 'Angsuran Ke',
			'tglangsuran' => 'Tglangsuran',
			'tgljatuhtempoangs' => 'Tgljatuhtempoangs',
			'jmlpokok_angsuran' => 'Jmlpokok Angsuran',
			'jmljasa_angsuran' => 'Jmljasa Angsuran',
			'jmldenda_angsuran' => 'Jmldenda Angsuran',
			'jmlpokok_byrangsuran' => 'Jmlpokok Byrangsuran',
			'jmljasa_byrangsuran' => 'Jmljasa Byrangsuran',
			'jmldenda_byrangsuran' => 'Jmldenda Byrangsuran',
			'jmlsisa_pembangsuran' => 'Jmlsisa Pembangsuran',
			'jmlbayar_pembangsuran' => 'Jmlbayar Pembangsuran',
			'pengajuanpembayaran_id' => 'Pengajuanpembayaran',
			'potongansumber_id' => 'Sumber Potongan',
			'namapotongan' => 'Namapotongan',
			'pinjaman_id' => 'Pinjaman',
			'tglpengajuanpemb' => 'Tglpengajuanpemb',
			'tglpembjthtempo' => 'Tglpembjthtempo',
			'sampaidgntgljthtempo' => 'Sampaidgntgljthtempo',
			'jmlpotongan_sumber' => 'Jmlpotongan Sumber',
			'tgldibuat_pengpemb' => 'Tgldibuat Pengpemb',
			'dibuatoleh_id_pengpemb' => 'Dibuatoleh Id Pengpemb',
			'tgldiperiksa_pengpemb' => 'Tgldiperiksa Pengpemb',
			'diperiksaoleh_id_pengpemb' => 'Diperiksaoleh Id Pengpemb',
			'tgldisetujui_pengpemb' => 'Tgldisetujui Pengpemb',
			'disetujuioleh_id_pengpemb' => 'Disetujuioleh Id Pengpemb',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'simpananwajib' => 'Simpananwajib',
			'simpanansukarela' => 'Simpanansukarela',
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
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('angsuran_ke',$this->angsuran_ke);
		$criteria->compare('tglangsuran',$this->tglangsuran,true);
		$criteria->compare('tgljatuhtempoangs',$this->tgljatuhtempoangs,true);
		$criteria->compare('jmlpokok_angsuran',$this->jmlpokok_angsuran);
		$criteria->compare('jmljasa_angsuran',$this->jmljasa_angsuran);
		$criteria->compare('jmldenda_angsuran',$this->jmldenda_angsuran);
		$criteria->compare('jmlpokok_byrangsuran',$this->jmlpokok_byrangsuran);
		$criteria->compare('jmljasa_byrangsuran',$this->jmljasa_byrangsuran);
		$criteria->compare('jmldenda_byrangsuran',$this->jmldenda_byrangsuran);
		$criteria->compare('jmlsisa_pembangsuran',$this->jmlsisa_pembangsuran);
		$criteria->compare('jmlbayar_pembangsuran',$this->jmlbayar_pembangsuran);
		$criteria->compare('pengajuanpembayaran_id',$this->pengajuanpembayaran_id);
		$criteria->compare('potongansumber_id',$this->potongansumber_id);
		$criteria->compare('namapotongan',$this->namapotongan,true);
		$criteria->compare('pinjaman_id',$this->pinjaman_id);
		$criteria->compare('tglpengajuanpemb',$this->tglpengajuanpemb,true);
		$criteria->compare('tglpembjthtempo',$this->tglpembjthtempo,true);
		$criteria->compare('sampaidgntgljthtempo',$this->sampaidgntgljthtempo,true);
		$criteria->compare('jmlpotongan_sumber',$this->jmlpotongan_sumber);
		$criteria->compare('tgldibuat_pengpemb',$this->tgldibuat_pengpemb,true);
		$criteria->compare('dibuatoleh_id_pengpemb',$this->dibuatoleh_id_pengpemb);
		$criteria->compare('tgldiperiksa_pengpemb',$this->tgldiperiksa_pengpemb,true);
		$criteria->compare('diperiksaoleh_id_pengpemb',$this->diperiksaoleh_id_pengpemb);
		$criteria->compare('tgldisetujui_pengpemb',$this->tgldisetujui_pengpemb,true);
		$criteria->compare('disetujuioleh_id_pengpemb',$this->disetujuioleh_id_pengpemb);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('simpananwajib',$this->simpananwajib);
		$criteria->compare('simpanansukarela',$this->simpanansukarela);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public $sisa;
	public function searchPengajuPotongan() {
		$criteria = new CDbCriteria;

                        $criteria->group = '
                              t.pengajuanpembayaran_id, t.keanggotaan_id, t.simpananwajib, t.simpanansukarela, t.jmlpokok_angsuran, t.jmljasa_angsuran,
                              t.jmlpotongan_sumber, t.potongansumber_id, t.tgljatuhtempoangs, t.nama_pegawai, t.nokeanggotaan, p.jmlpengajuan_pengangsuran';

                              $criteria->select = $criteria->group.', (case when ((p.jmlpengajuan_pengangsuran - t.simpananwajib - t.simpanansukarela) - sum(t.jmlbayar_pembangsuran)) is null
                  then p.jmlpengajuan_pengangsuran
                  else
                  ((p.jmlpengajuan_pengangsuran - t.simpananwajib - t.simpanansukarela) - sum(t.jmlbayar_pembangsuran))
                      end) as sisa';

                              $criteria->join =
                              'join pengajuanpembayaran_t p on p.pengajuanpembayaran_id = t.pengajuanpembayaran_id
                              left join pembayaranangsuran_t a on a.pengajuanpembayaran_id = p.pengajuanpembayaran_id';

                              $criteria->having = '(case when ((p.jmlpengajuan_pengangsuran - t.simpananwajib - t.simpanansukarela) - sum(t.jmlbayar_pembangsuran)) is null
                  then p.jmlpengajuan_pengangsuran
                  else
                  ((p.jmlpengajuan_pengangsuran - t.simpananwajib - t.simpanansukarela) - sum(t.jmlbayar_pembangsuran))
                      end) > 0';

                              //if (isset($this->tglAwal) && isset($this->tglAkhir)) {
                              if (isset($this->nopengajuan)) {
                                      //$criteria->addBetweenCondition('t.tgljatuhtempoangs', $this->tglAwal, $this->tglAkhir);
                                      $criteria->compare('lower(p.nopengajuan)', strtolower($this->nopengajuan), true);
                                      if(!empty($this->potongansumber_id))$criteria->addCondition('t.potongansumber_id = '.$this->potongansumber_id);
                                      //$criteria->compare('t.potongansumber_id', $this->potongansumber_id);
                                      //$criteria->compare('lower(nopengajuan)', strtolower$this->);
                                      //$criteria->addCondition('a.pengajuanpembayaran_id is null');
                                      //$criteria->having = '((p.jmlpengajuan_pengangsuran - t.simpananwajib - t.simpanansukarela) - sum(t.jmlbayar_pembangsuran)) > 0';
                              } else $criteria->compare('t.nokeanggotaan', '-');

		return new CActiveDataProvider($this, array('criteria'=>$criteria, 'pagination'=>false));
	}

}