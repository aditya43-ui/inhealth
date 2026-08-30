<?php

/**
 * This is the model class for table "rinciantagihanpasienberhutang_v".
 *
 * The followings are the available columns in table 'rinciantagihanpasienberhutang_v':
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $suratketjaminan_id
 * @property string $tglskj
 * @property string $no_skj
 * @property string $namapenjamin_skj
 * @property string $hubungan_skj
 * @property string $jeniskelamin_skj
 * @property string $alamat_skj
 * @property string $jenisidentitas_skj
 * @property string $no_identitas_skj
 * @property string $nomoblie_skj
 * @property string $notelepon_skj
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property string $kunjungan
 * @property boolean $alihstatus
 * @property string $umur
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $tandabuktibayar_id
 * @property string $nopembayaran
 * @property string $tglpembayaran
 * @property double $totalbiayaoa
 * @property double $totalbiayatindakan
 * @property double $totalbiayapelayanan
 * @property double $totalsubsidiasuransi
 * @property double $totalsubsidipemerintah
 * @property double $totalsubsidirs
 * @property double $totaliurbiaya
 * @property double $totalbayartindakan
 * @property double $totaldiscount
 * @property double $totalpembebasan
 * @property double $totalsisatagihan
 * @property integer $bayarangsuranpelayanan_id
 * @property integer $bayarke
 * @property double $jmlbayarangsuran
 * @property double $sisaangsuran
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 */
class RinciantagihanpasienberhutangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RinciantagihanpasienberhutangV the static model class
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
		return 'rinciantagihanpasienberhutang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, suratketjaminan_id, pendaftaran_id, jeniskasuspenyakit_id, tandabuktibayar_id, bayarangsuranpelayanan_id, bayarke', 'numerical', 'integerOnly'=>true),
			array('totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totalbayartindakan, totaldiscount, totalpembebasan, totalsisatagihan, jmlbayarangsuran, sisaangsuran', 'numerical'),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, no_pendaftaran, no_mobile_pasien', 'length', 'max'=>20),
			array('nama_pasien, no_skj, hubungan_skj, jenisidentitas_skj, no_identitas_skj, statusperiksa, statuspasien, kunjungan, nopembayaran, nobuktibayar', 'length', 'max'=>50),
			array('nama_bin, jeniskelamin_skj, umur', 'length', 'max'=>30),
			array('tempat_lahir', 'length', 'max'=>25),
			array('namapenjamin_skj, nomoblie_skj, notelepon_skj, jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('no_telepon_pasien', 'length', 'max'=>15),
			array('tanggal_lahir, alamat_pasien, tglskj, alamat_skj, tgl_pendaftaran, alihstatus, tglpembayaran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglbuktibayar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, suratketjaminan_id, tglskj, no_skj, namapenjamin_skj, hubungan_skj, jeniskelamin_skj, alamat_skj, jenisidentitas_skj, no_identitas_skj, nomoblie_skj, notelepon_skj, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, statusperiksa, statuspasien, kunjungan, alihstatus, umur, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, tandabuktibayar_id, nopembayaran, tglpembayaran, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totalbayartindakan, totaldiscount, totalpembebasan, totalsisatagihan, bayarangsuranpelayanan_id, bayarke, jmlbayarangsuran, sisaangsuran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, no_telepon_pasien, no_mobile_pasien, nobuktibayar, tglbuktibayar', 'safe', 'on'=>'search'),
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
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'suratketjaminan_id' => 'Suratketjaminan',
			'tglskj' => 'Tglskj',
			'no_skj' => 'No. Skj',
			'namapenjamin_skj' => 'Namapenjamin Skj',
			'hubungan_skj' => 'Hubungan Skj',
			'jeniskelamin_skj' => 'Jeniskelamin Skj',
			'alamat_skj' => 'Alamat Skj',
			'jenisidentitas_skj' => 'Jenisidentitas Skj',
			'no_identitas_skj' => 'No. Identitas Skj',
			'nomoblie_skj' => 'Nomoblie Skj',
			'notelepon_skj' => 'Notelepon Skj',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'statusperiksa' => 'Statusperiksa',
			'statuspasien' => 'Statuspasien',
			'kunjungan' => 'Kunjungan',
			'alihstatus' => 'Alihstatus',
			'umur' => 'Umur',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'nopembayaran' => 'No. Pembayaran',
			'tglpembayaran' => 'Tgl. Pembayaran',
			'totalbiayaoa' => 'Totalbiayaoa',
			'totalbiayatindakan' => 'Totalbiayatindakan',
			'totalbiayapelayanan' => 'Totalbiayapelayanan',
			'totalsubsidiasuransi' => 'Totalsubsidiasuransi',
			'totalsubsidipemerintah' => 'Totalsubsidipemerintah',
			'totalsubsidirs' => 'Totalsubsidirs',
			'totaliurbiaya' => 'Totaliurbiaya',
			'totalbayartindakan' => 'Totalbayartindakan',
			'totaldiscount' => 'Total Keringanan',
			'totalpembebasan' => 'Totalpembebasan',
			'totalsisatagihan' => 'Totalsisatagihan',
			'bayarangsuranpelayanan_id' => 'Bayarangsuranpelayanan',
			'bayarke' => 'Bayarke',
			'jmlbayarangsuran' => 'Jmlbayarangsuran',
			'sisaangsuran' => 'Sisaangsuran',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('suratketjaminan_id',$this->suratketjaminan_id);
		$criteria->compare('tglskj',$this->tglskj,true);
		$criteria->compare('no_skj',$this->no_skj,true);
		$criteria->compare('namapenjamin_skj',$this->namapenjamin_skj,true);
		$criteria->compare('hubungan_skj',$this->hubungan_skj,true);
		$criteria->compare('jeniskelamin_skj',$this->jeniskelamin_skj,true);
		$criteria->compare('alamat_skj',$this->alamat_skj,true);
		$criteria->compare('jenisidentitas_skj',$this->jenisidentitas_skj,true);
		$criteria->compare('no_identitas_skj',$this->no_identitas_skj,true);
		$criteria->compare('nomoblie_skj',$this->nomoblie_skj,true);
		$criteria->compare('notelepon_skj',$this->notelepon_skj,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('statusperiksa',$this->statusperiksa,true);
		$criteria->compare('statuspasien',$this->statuspasien,true);
		$criteria->compare('kunjungan',$this->kunjungan,true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('tglpembayaran',$this->tglpembayaran,true);
		$criteria->compare('totalbiayaoa',$this->totalbiayaoa);
		$criteria->compare('totalbiayatindakan',$this->totalbiayatindakan);
		$criteria->compare('totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('totalsubsidiasuransi',$this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidipemerintah',$this->totalsubsidipemerintah);
		$criteria->compare('totalsubsidirs',$this->totalsubsidirs);
		$criteria->compare('totaliurbiaya',$this->totaliurbiaya);
		$criteria->compare('totalbayartindakan',$this->totalbayartindakan);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('totalpembebasan',$this->totalpembebasan);
		$criteria->compare('totalsisatagihan',$this->totalsisatagihan);
		$criteria->compare('bayarangsuranpelayanan_id',$this->bayarangsuranpelayanan_id);
		$criteria->compare('bayarke',$this->bayarke);
		$criteria->compare('jmlbayarangsuran',$this->jmlbayarangsuran);
		$criteria->compare('sisaangsuran',$this->sisaangsuran);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('no_telepon_pasien',$this->no_telepon_pasien,true);
		$criteria->compare('no_mobile_pasien',$this->no_mobile_pasien,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}