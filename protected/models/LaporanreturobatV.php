<?php

/**
 * This is the model class for table "laporanreturobat_v".
 *
 * The followings are the available columns in table 'laporanreturobat_v':
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
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $nomorindukpegawai
 * @property integer $obatalkes_id
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_nama
 * @property integer $sumberdana_id
 * @property string $sumberdana_nama
 * @property integer $oasudahbayar_id
 * @property integer $racikan_id
 * @property string $r
 * @property integer $rke
 * @property integer $returresep_id
 * @property string $tglretur
 * @property string $noreturresep
 * @property string $alasanretur
 * @property string $keteranganretur
 * @property double $totalretur
 * @property double $qty_retur
 * @property double $hargasatuan
 * @property string $kondisibrg
 * @property integer $returresepdet_id
 * @property string $jenispenjualan
 * @property integer $pasienpegawai_id
 * @property integer $pasienprofilrs_id
 * @property integer $pasieninstalasiunit_id
 */
class LaporanreturobatV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanreturobatV the static model class
	 */
        public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanreturobat_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, pendaftaran_id, carabayar_id, penjamin_id, pegawai_id, obatalkes_id, satuankecil_id, jenisobatalkes_id, sumberdana_id, oasudahbayar_id, racikan_id, rke, returresep_id, returresepdet_id, pasienpegawai_id, pasienprofilrs_id, pasieninstalasiunit_id', 'numerical', 'integerOnly'=>true),
			array('totalretur, qty_retur, hargasatuan', 'numerical'),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, no_pendaftaran, obatalkes_kadarobat', 'length', 'max'=>20),
			array('nama_pasien, carabayar_nama, penjamin_nama, nama_pegawai, obatalkes_golongan, obatalkes_kategori, satuankecil_nama, jenisobatalkes_nama, sumberdana_nama, noreturresep, kondisibrg', 'length', 'max'=>50),
			array('nama_bin, umur, nomorindukpegawai', 'length', 'max'=>30),
			array('tempat_lahir', 'length', 'max'=>25),
			array('obatalkes_kode, obatalkes_nama, alasanretur', 'length', 'max'=>200),
			array('r', 'length', 'max'=>2),
			array('jenispenjualan', 'length', 'max'=>100),
			array('tanggal_lahir, alamat_pasien, tgl_pendaftaran, tglretur, keteranganretur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, no_rekam_medik, tgl_awal, tgl_akhir, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, umur, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, pegawai_id, gelardepan, nama_pegawai, nomorindukpegawai, obatalkes_id, obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, satuankecil_id, satuankecil_nama, jenisobatalkes_id, jenisobatalkes_nama, sumberdana_id, sumberdana_nama, oasudahbayar_id, racikan_id, r, rke, returresep_id, tglretur, noreturresep, alasanretur, keteranganretur, totalretur, qty_retur, hargasatuan, kondisibrg, returresepdet_id, jenispenjualan, pasienpegawai_id, pasienprofilrs_id, pasieninstalasiunit_id', 'safe', 'on'=>'search'),
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
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'umur' => 'Umur',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Cara Bayar ',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Nama Pegawai',
			'nomorindukpegawai' => 'NIP',
			'obatalkes_id' => 'Obat Alkes',
			'obatalkes_kode' => 'Kode Obat ',
			'obatalkes_nama' => 'Obat Alkes',
			'obatalkes_golongan' => 'Golongan Obat ',
			'obatalkes_kategori' => 'Kategori Obat',
			'obatalkes_kadarobat' => 'Kadar Obat',
			'satuankecil_id' => 'Satuan Kecil',
			'satuankecil_nama' => 'Satuan Kecil',
			'jenisobatalkes_id' => 'Jenis Obat Alkes',
			'jenisobatalkes_nama' => 'Jenis Obat Alkes',
			'sumberdana_id' => 'Sumber Dana',
			'sumberdana_nama' => 'Sumber Dana',
			'oasudahbayar_id' => 'Obat Alkes Sudah Bayar',
			'racikan_id' => 'Racikan',
			'r' => 'R',
			'rke' => 'Rke',
			'returresep_id' => 'Retur Resep',
			'tglretur' => 'Tanggal Retur',
			'noreturresep' => 'No. Retur Resep',
			'alasanretur' => 'Alasan Retur',
			'keteranganretur' => 'Keterangan Retur',
			'totalretur' => 'Total Retur',
			'qty_retur' => 'Jumlah Retur',
			'hargasatuan' => 'Harga Satuan',
			'kondisibrg' => 'Kondisi Barang',
			'returresepdet_id' => 'Detail Retur Resep',
			'jenispenjualan' => 'Jenis Penjualan',
			'pasienpegawai_id' => 'Pasien Pegawai',
			'pasienprofilrs_id' => 'Pasien Profil RS.',
			'pasieninstalasiunit_id' => 'Pasien Instalasi Unit',
                        'tgl_awal'=>'Tanggal Retur Obat',
                        'tgl_akhir'=>'Sampai Dengan',
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
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->compare('qty_retur',$this->qty_retur);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('LOWER(kondisibrg)',strtolower($this->kondisibrg),true);
		$criteria->compare('returresepdet_id',$this->returresepdet_id);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('pasienpegawai_id',$this->pasienpegawai_id);
		$criteria->compare('pasienprofilrs_id',$this->pasienprofilrs_id);
		$criteria->compare('pasieninstalasiunit_id',$this->pasieninstalasiunit_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->compare('qty_retur',$this->qty_retur);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('LOWER(kondisibrg)',strtolower($this->kondisibrg),true);
		$criteria->compare('returresepdet_id',$this->returresepdet_id);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('pasienpegawai_id',$this->pasienpegawai_id);
		$criteria->compare('pasienprofilrs_id',$this->pasienprofilrs_id);
		$criteria->compare('pasieninstalasiunit_id',$this->pasieninstalasiunit_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}