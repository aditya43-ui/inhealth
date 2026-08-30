<?php

/**
 * This is the model class for table "laporanreturpelayanan_v".
 *
 * The followings are the available columns in table 'laporanreturpelayanan_v':
 * @property string $tglreturpelayanan
 * @property string $noreturbayar
 * @property double $totaloaretur
 * @property double $totaltindakanretur
 * @property double $totalbiayaretur
 * @property string $keteranganretur
 * @property string $user_nm_otorisasi
 * @property integer $user_id_otorisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property string $carabayarkeluar
 * @property double $jmlkaskeluar
 * @property double $biayaadministrasi
 * @property integer $tandabuktibayar_id
 * @property string $tglbuktibayar
 * @property string $nobuktibayar
 * @property double $jmlpembayaran
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property integer $pembayaranpelayanan_id
 * @property integer $ruanganakhir_id
 * @property string $ruanganakhir_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $nama_pemakai
 */
class LaporanreturpelayananV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode;
    public $instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanreturpelayananV the static model class
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
		return 'laporanreturpelayanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id_otorisasi, tandabuktikeluar_id, tandabuktibayar_id, pasien_id, pendaftaran_id, pembayaranpelayanan_id, ruanganakhir_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('totaloaretur, totaltindakanretur, totalbiayaretur, jmlkaskeluar, biayaadministrasi, jmlpembayaran', 'numerical'),
			array('noreturbayar, user_nm_otorisasi, nokaskeluar, carabayarkeluar, nobuktibayar, nama_pasien, ruanganakhir_nama, ruangan_nama', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, no_pendaftaran, nama_pemakai', 'length', 'max'=>20),
			array('nama_bin, umur', 'length', 'max'=>30),
			array('tglreturpelayanan, keteranganretur, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglkaskeluar, tglbuktibayar, alamat_pasien, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglreturpelayanan, noreturbayar, totaloaretur, totaltindakanretur, totalbiayaretur, keteranganretur, user_nm_otorisasi, user_id_otorisasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tandabuktikeluar_id, tglkaskeluar, nokaskeluar, carabayarkeluar, jmlkaskeluar, biayaadministrasi, tandabuktibayar_id, tglbuktibayar, nobuktibayar, jmlpembayaran, pasien_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, alamat_pasien, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, umur, pembayaranpelayanan_id, ruanganakhir_id, ruanganakhir_nama, ruangan_id, ruangan_nama, nama_pemakai', 'safe', 'on'=>'search'),
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
			'tglreturpelayanan' => 'Tglreturpelayanan',
			'noreturbayar' => 'Noreturbayar',
			'totaloaretur' => 'Totaloaretur',
			'totaltindakanretur' => 'Totaltindakanretur',
			'totalbiayaretur' => 'Totalbiayaretur',
			'keteranganretur' => 'Keteranganretur',
			'user_nm_otorisasi' => 'User Nm Otorisasi',
			'user_id_otorisasi' => 'User Id Otorisasi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'carabayarkeluar' => 'Cara Bayar Keluar',
			'jmlkaskeluar' => 'Jumlah Kas Keluar',
			'biayaadministrasi' => 'Biaya Administrasi',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'tglbuktibayar' => 'Tglbuktibayar',
			'nobuktibayar' => 'Nobuktibayar',
			'jmlpembayaran' => 'Jmlpembayaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'umur' => 'Umur',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'ruanganakhir_id' => 'Ruanganakhir',
			'ruanganakhir_nama' => 'Ruanganakhir Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'nama_pemakai' => 'Nama Pemakai',
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

		$criteria->compare('LOWER(tglreturpelayanan)',strtolower($this->tglreturpelayanan),true);
		$criteria->compare('LOWER(noreturbayar)',strtolower($this->noreturbayar),true);
		$criteria->compare('totaloaretur',$this->totaloaretur);
		$criteria->compare('totaltindakanretur',$this->totaltindakanretur);
		$criteria->compare('totalbiayaretur',$this->totalbiayaretur);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('LOWER(user_nm_otorisasi)',strtolower($this->user_nm_otorisasi),true);
		$criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('LOWER(tglkaskeluar)',strtolower($this->tglkaskeluar),true);
		$criteria->compare('LOWER(nokaskeluar)',strtolower($this->nokaskeluar),true);
		$criteria->compare('LOWER(carabayarkeluar)',strtolower($this->carabayarkeluar),true);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('ruanganakhir_id',$this->ruanganakhir_id);
		$criteria->compare('LOWER(ruanganakhir_nama)',strtolower($this->ruanganakhir_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(nama_pemakai)',strtolower($this->nama_pemakai),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('LOWER(tglreturpelayanan)',strtolower($this->tglreturpelayanan),true);
		$criteria->compare('LOWER(noreturbayar)',strtolower($this->noreturbayar),true);
		$criteria->compare('totaloaretur',$this->totaloaretur);
		$criteria->compare('totaltindakanretur',$this->totaltindakanretur);
		$criteria->compare('totalbiayaretur',$this->totalbiayaretur);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('LOWER(user_nm_otorisasi)',strtolower($this->user_nm_otorisasi),true);
		$criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('LOWER(tglkaskeluar)',strtolower($this->tglkaskeluar),true);
		$criteria->compare('LOWER(nokaskeluar)',strtolower($this->nokaskeluar),true);
		$criteria->compare('LOWER(carabayarkeluar)',strtolower($this->carabayarkeluar),true);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('ruanganakhir_id',$this->ruanganakhir_id);
		$criteria->compare('LOWER(ruanganakhir_nama)',strtolower($this->ruanganakhir_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(nama_pemakai)',strtolower($this->nama_pemakai),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
         public function getRuangankasirItems()
    {
        return RuangankasirV::model()->findAll();
    }
    
       
}