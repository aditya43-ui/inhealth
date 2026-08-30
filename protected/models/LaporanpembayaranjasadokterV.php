<?php

/**
 * This is the model class for table "laporanpembayaranjasadokter_v".
 *
 * The followings are the available columns in table 'laporanpembayaranjasadokter_v':
 * @property integer $pembayaranjasa_id
 * @property integer $tandabuktikeluar_id
 * @property integer $rujukandari_id
 * @property integer $pegawai_id
 * @property string $tglbayarjasa
 * @property string $nobayarjasa
 * @property string $periodejasa
 * @property string $sampaidgn
 * @property double $totaltarif
 * @property double $totaljasa
 * @property double $totalbayarjasa
 * @property double $totalsisajasa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $asalrujukan_id
 * @property string $namaperujuk
 * @property string $spesialis
 * @property string $alamatlengkap
 * @property string $notelp
 * @property string $asalrujukan_nama
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $shift_id
 * @property integer $ruangan_tandabukti
 * @property string $tahun
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property string $carabayarkeluar
 * @property string $melalubank
 * @property string $denganrekening
 * @property string $atasnamarekening
 * @property string $namapenerima
 * @property string $alamatpenerima
 * @property string $untukpembayaran
 * @property double $jmlkaskeluar
 * @property double $biayaadministrasi
 * @property string $keterangan_pengeluaran
 */
class LaporanpembayaranjasadokterV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpembayaranjasadokterV the static model class
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
		return 'laporanpembayaranjasadokter_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayaranjasa_id, tandabuktikeluar_id, rujukandari_id, pegawai_id, asalrujukan_id, shift_id, ruangan_tandabukti', 'numerical', 'integerOnly'=>true),
			array('totaltarif, totaljasa, totalbayarjasa, totalsisajasa, jmlkaskeluar, biayaadministrasi', 'numerical'),
			array('nobayarjasa, gelardepan', 'length', 'max'=>10),
			array('namaperujuk, notelp, melalubank, denganrekening, atasnamarekening, namapenerima, untukpembayaran', 'length', 'max'=>100),
			array('spesialis, asalrujukan_nama, nama_pegawai, nokaskeluar, carabayarkeluar', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('tahun', 'length', 'max'=>4),
			array('tglbayarjasa, periodejasa, sampaidgn, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, alamatlengkap, tglkaskeluar, alamatpenerima, keterangan_pengeluaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembayaranjasa_id, tandabuktikeluar_id, rujukandari_id, pegawai_id, tglbayarjasa, nobayarjasa, periodejasa, sampaidgn, totaltarif, totaljasa, totalbayarjasa, totalsisajasa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, asalrujukan_id, namaperujuk, spesialis, alamatlengkap, notelp, asalrujukan_nama, gelardepan, nama_pegawai, gelarbelakang_nama, shift_id, ruangan_tandabukti, tahun, tglkaskeluar, nokaskeluar, carabayarkeluar, melalubank, denganrekening, atasnamarekening, namapenerima, alamatpenerima, untukpembayaran, jmlkaskeluar, biayaadministrasi, keterangan_pengeluaran', 'safe', 'on'=>'search'),
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
			'pembayaranjasa_id' => 'Pembayaran Jasa',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'rujukandari_id' => 'Rujukan Dari',
			'pegawai_id' => 'Pegawai',
			'tglbayarjasa' => 'Tanggal Bayar Jasa',
			'nobayarjasa' => 'No. Bayar Jasa',
			'periodejasa' => 'Periode Jasa',
			'sampaidgn' => 'Sampai dengan',
			'totaltarif' => 'Total Tarif',
			'totaljasa' => 'Total Jasa',
			'totalbayarjasa' => 'Total Bayar Jasa',
			'totalsisajasa' => 'Total Sisa Jasa',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'asalrujukan_id' => 'Asal Rujukan',
			'namaperujuk' => 'Nama Perujuk',
			'spesialis' => 'Spesialis',
			'alamatlengkap' => 'Alamat Lengkap',
			'notelp' => 'No. Telepon',
			'asalrujukan_nama' => 'Asal Rujukan',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'shift_id' => 'Shift',
			'ruangan_tandabukti' => 'Ruangan Tandabukti',
			'tahun' => 'Tahun',
			'tglkaskeluar' => 'Tanggal Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'carabayarkeluar' => 'Cara Bayar Kas',
			'melalubank' => 'Melalu Bank',
			'denganrekening' => 'Rekening',
			'atasnamarekening' => 'Atas Nama Rekening',
			'namapenerima' => 'Nama Penerima',
			'alamatpenerima' => 'Alamat Penerima',
			'untukpembayaran' => 'Untuk Pembayaran',
			'jmlkaskeluar' => 'Jml Kaskeluar',
			'biayaadministrasi' => 'Biaya Administrasi',
			'keterangan_pengeluaran' => 'Keterangan Pengeluaran',
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

		$criteria->compare('pembayaranjasa_id',$this->pembayaranjasa_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('rujukandari_id',$this->rujukandari_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglbayarjasa)',strtolower($this->tglbayarjasa),true);
		$criteria->compare('LOWER(nobayarjasa)',strtolower($this->nobayarjasa),true);
		$criteria->compare('LOWER(periodejasa)',strtolower($this->periodejasa),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('totaltarif',$this->totaltarif);
		$criteria->compare('totaljasa',$this->totaljasa);
		$criteria->compare('totalbayarjasa',$this->totalbayarjasa);
		$criteria->compare('totalsisajasa',$this->totalsisajasa);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(namaperujuk)',strtolower($this->namaperujuk),true);
		$criteria->compare('LOWER(spesialis)',strtolower($this->spesialis),true);
		$criteria->compare('LOWER(alamatlengkap)',strtolower($this->alamatlengkap),true);
		$criteria->compare('LOWER(notelp)',strtolower($this->notelp),true);
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('ruangan_tandabukti',$this->ruangan_tandabukti);
		$criteria->compare('LOWER(tahun)',strtolower($this->tahun),true);
		$criteria->compare('LOWER(tglkaskeluar)',strtolower($this->tglkaskeluar),true);
		$criteria->compare('LOWER(nokaskeluar)',strtolower($this->nokaskeluar),true);
		$criteria->compare('LOWER(carabayarkeluar)',strtolower($this->carabayarkeluar),true);
		$criteria->compare('LOWER(melalubank)',strtolower($this->melalubank),true);
		$criteria->compare('LOWER(denganrekening)',strtolower($this->denganrekening),true);
		$criteria->compare('LOWER(atasnamarekening)',strtolower($this->atasnamarekening),true);
		$criteria->compare('LOWER(namapenerima)',strtolower($this->namapenerima),true);
		$criteria->compare('LOWER(alamatpenerima)',strtolower($this->alamatpenerima),true);
		$criteria->compare('LOWER(untukpembayaran)',strtolower($this->untukpembayaran),true);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('LOWER(keterangan_pengeluaran)',strtolower($this->keterangan_pengeluaran),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pembayaranjasa_id',$this->pembayaranjasa_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('rujukandari_id',$this->rujukandari_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglbayarjasa)',strtolower($this->tglbayarjasa),true);
		$criteria->compare('LOWER(nobayarjasa)',strtolower($this->nobayarjasa),true);
		$criteria->compare('LOWER(periodejasa)',strtolower($this->periodejasa),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('totaltarif',$this->totaltarif);
		$criteria->compare('totaljasa',$this->totaljasa);
		$criteria->compare('totalbayarjasa',$this->totalbayarjasa);
		$criteria->compare('totalsisajasa',$this->totalsisajasa);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(namaperujuk)',strtolower($this->namaperujuk),true);
		$criteria->compare('LOWER(spesialis)',strtolower($this->spesialis),true);
		$criteria->compare('LOWER(alamatlengkap)',strtolower($this->alamatlengkap),true);
		$criteria->compare('LOWER(notelp)',strtolower($this->notelp),true);
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('ruangan_tandabukti',$this->ruangan_tandabukti);
		$criteria->compare('LOWER(tahun)',strtolower($this->tahun),true);
		$criteria->compare('LOWER(tglkaskeluar)',strtolower($this->tglkaskeluar),true);
		$criteria->compare('LOWER(nokaskeluar)',strtolower($this->nokaskeluar),true);
		$criteria->compare('LOWER(carabayarkeluar)',strtolower($this->carabayarkeluar),true);
		$criteria->compare('LOWER(melalubank)',strtolower($this->melalubank),true);
		$criteria->compare('LOWER(denganrekening)',strtolower($this->denganrekening),true);
		$criteria->compare('LOWER(atasnamarekening)',strtolower($this->atasnamarekening),true);
		$criteria->compare('LOWER(namapenerima)',strtolower($this->namapenerima),true);
		$criteria->compare('LOWER(alamatpenerima)',strtolower($this->alamatpenerima),true);
		$criteria->compare('LOWER(untukpembayaran)',strtolower($this->untukpembayaran),true);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('LOWER(keterangan_pengeluaran)',strtolower($this->keterangan_pengeluaran),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
//        RND-6992 Format date langsung diedit di view nya. 
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
//                        }
//            }
//            return true;
//        }
}