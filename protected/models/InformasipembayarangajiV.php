<?php

/**
 * This is the model class for table "informasipembayarangaji_v".
 *
 * The followings are the available columns in table 'informasipembayarangaji_v':
 * @property integer $jenispengeluaran_id
 * @property string $jenispengeluaran_kode
 * @property string $jenispengeluaran_nama
 * @property integer $pengeluaranumum_id
 * @property string $kelompoktransaksi
 * @property string $nopengeluaran
 * @property string $tglpengeluaran
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property integer $penggajianpeg_id
 * @property string $tglpenggajian
 * @property string $nopenggajian
 * @property integer $pegawai_id
 * @property string $pegawai_nip
 * @property string $pegawai_jenisidentitas
 * @property string $pegawai_noidentitas
 * @property string $pegawai_gelardepan
 * @property string $pegawai_nama
 * @property string $pegawai_gelarbelakang
 * @property string $keterangan
 * @property double $totalterima
 * @property double $totalpajak
 * @property double $totalpotongan
 * @property double $penerimaanbersih
 * @property string $periodegaji
 * @property double $gajipertahun
 * @property double $biayajabatan
 * @property double $potonganpensiun
 * @property string $kodeptkp
 * @property double $ptkppertahun
 * @property double $penerimaanbersihpertahun
 * @property double $pkp
 * @property integer $persentasepph21
 * @property double $pph21pertahun
 * @property double $pph21perbulan
 * @property double $volume
 * @property string $satuanvol
 * @property double $hargasatuan
 * @property double $totalharga
 * @property double $biayaadministrasi
 * @property string $keterangankeluar
 * @property boolean $isurainkeluarumum
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class InformasipembayarangajiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipembayarangajiV the static model class
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
		return 'informasipembayarangaji_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispengeluaran_id, pengeluaranumum_id, tandabuktikeluar_id, penggajianpeg_id, pegawai_id, persentasepph21', 'numerical', 'integerOnly'=>true),
			array('totalterima, totalpajak, totalpotongan, penerimaanbersih, gajipertahun, biayajabatan, potonganpensiun, ptkppertahun, penerimaanbersihpertahun, pkp, pph21pertahun, pph21perbulan, volume, hargasatuan, totalharga, biayaadministrasi', 'numerical'),
			array('jenispengeluaran_kode, pegawai_jenisidentitas', 'length', 'max'=>20),
			array('jenispengeluaran_nama, pegawai_noidentitas', 'length', 'max'=>100),
			array('kelompoktransaksi, nopengeluaran, nokaskeluar, nopenggajian, pegawai_nama, satuanvol', 'length', 'max'=>50),
			array('pegawai_nip', 'length', 'max'=>30),
			array('pegawai_gelardepan', 'length', 'max'=>10),
			array('pegawai_gelarbelakang', 'length', 'max'=>15),
			array('kodeptkp', 'length', 'max'=>5),
			array('tglpengeluaran, tglkaskeluar, tglpenggajian, keterangan, periodegaji, keterangankeluar, isurainkeluarumum, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispengeluaran_id, jenispengeluaran_kode, jenispengeluaran_nama, pengeluaranumum_id, kelompoktransaksi, nopengeluaran, tglpengeluaran, tandabuktikeluar_id, tglkaskeluar, nokaskeluar, penggajianpeg_id, tglpenggajian, nopenggajian, pegawai_id, pegawai_nip, pegawai_jenisidentitas, pegawai_noidentitas, pegawai_gelardepan, pegawai_nama, pegawai_gelarbelakang, keterangan, totalterima, totalpajak, totalpotongan, penerimaanbersih, periodegaji, gajipertahun, biayajabatan, potonganpensiun, kodeptkp, ptkppertahun, penerimaanbersihpertahun, pkp, persentasepph21, pph21pertahun, pph21perbulan, volume, satuanvol, hargasatuan, totalharga, biayaadministrasi, keterangankeluar, isurainkeluarumum, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jenispengeluaran_id' => 'Jenispengeluaran',
			'jenispengeluaran_kode' => 'Jenispengeluaran Kode',
			'jenispengeluaran_nama' => 'Jenispengeluaran Nama',
			'pengeluaranumum_id' => 'Pengeluaranumum',
			'kelompoktransaksi' => 'Kelompoktransaksi',
			'nopengeluaran' => 'No. Pengeluaran',
			'tglpengeluaran' => 'Tglpengeluaran',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'penggajianpeg_id' => 'Penggajianpeg',
			'tglpenggajian' => 'Tglpenggajian',
			'nopenggajian' => 'No. Penggajian',
			'pegawai_id' => 'Pegawai',
			'pegawai_nip' => 'No. Karyawan',
			'pegawai_jenisidentitas' => 'Pegawai Jenisidentitas',
			'pegawai_noidentitas' => 'Pegawai Noidentitas',
			'pegawai_gelardepan' => 'Pegawai Gelardepan',
			'pegawai_nama' => 'Nama Karyawan',
			'pegawai_gelarbelakang' => 'Pegawai Gelarbelakang',
			'keterangan' => 'Keterangan',
			'totalterima' => 'Total Gaji',
			'totalpajak' => 'Totalpajak',
			'totalpotongan' => 'Totalpotongan',
			'penerimaanbersih' => 'Gaji Bersih',
			'periodegaji' => 'Periode Penggajian',
			'gajipertahun' => 'Gajipertahun',
			'biayajabatan' => 'Biayajabatan',
			'potonganpensiun' => 'Potonganpensiun',
			'kodeptkp' => 'Kodeptkp',
			'ptkppertahun' => 'Ptkppertahun',
			'penerimaanbersihpertahun' => 'Penerimaanbersihpertahun',
			'pkp' => 'Pkp',
			'persentasepph21' => 'Persentasepph21',
			'pph21pertahun' => 'Pph21pertahun',
			'pph21perbulan' => 'Pph21perbulan',
			'volume' => 'Volume',
			'satuanvol' => 'Satuanvol',
			'hargasatuan' => 'Hargasatuan',
			'totalharga' => 'Totalharga',
			'biayaadministrasi' => 'Biaya Administrasi',
			'keterangankeluar' => 'Keterangankeluar',
			'isurainkeluarumum' => 'Isurainkeluarumum',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(nokaskeluar)',strtolower($this->nokaskeluar),true);
		if(!empty($this->periodegaji)){
			$criteria->addBetweenCondition('date(periodegaji)',$this->periodegaji,$this->periodegaji);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}