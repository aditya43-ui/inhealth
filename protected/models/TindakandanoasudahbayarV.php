<?php

/**
 * This is the model class for table "tindakandanoasudahbayar_v".
 *
 * The followings are the available columns in table 'tindakandanoasudahbayar_v':
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $tindakansudahbayar_id
 * @property double $qty_tindakan
 * @property double $jmlbiaya_tindakan
 * @property double $jmlsubsidi_asuransi
 * @property double $jmlsubsidi_pemerintah
 * @property double $jmlsubsidi_rs
 * @property double $jmliurbiaya
 * @property double $jmlpembebasan
 * @property double $jmlbayar_tindakan
 * @property double $jmlsisabayar_tindakan
 * @property integer $pembayaranpelayanan_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $nopembayaran
 * @property string $tglpembayaran
 * @property integer $carabayar_id
 * @property integer $penjamin_id
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
 * @property integer $ruanganpelakhir_id
 */
class TindakandanoasudahbayarV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakandanoasudahbayarV the static model class
	 */
    
        public $tgl_awal,$tgl_akhir;
        
        public $nama_pasien,$no_rekam_medik;
        public $totalbayartindakan, $bulan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tindakandanoasudahbayar_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, kelompoktindakan_id, ruangan_id, tindakansudahbayar_id, pembayaranpelayanan_id, pasien_id, pendaftaran_id, pasienadmisi_id, carabayar_id, penjamin_id, ruanganpelakhir_id', 'numerical', 'integerOnly'=>true),
			array('qty_tindakan, jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totalbayartindakan, totaldiscount, totalpembebasan, totalsisatagihan', 'numerical'),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('kelompoktindakan_nama, ruangan_nama, nopembayaran', 'length', 'max'=>50),
			array('daftartindakan_kode, tglpembayaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('daftartindakan_id, daftartindakan_kode, tgl_awal, bulan, nama_pasien, totalbayartindakan, tgl_akhir, daftartindakan_nama, kelompoktindakan_id, kelompoktindakan_nama, ruangan_id, ruangan_nama, tindakansudahbayar_id, qty_tindakan, jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan, pembayaranpelayanan_id, pasien_id, pendaftaran_id, pasienadmisi_id, nopembayaran, tglpembayaran, carabayar_id, penjamin_id, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totalbayartindakan, totaldiscount, totalpembebasan, totalsisatagihan, ruanganpelakhir_id', 'safe', 'on'=>'search'),
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
                    'pembayaran'=>array(self::BELONGS_TO, 'PembayaranpelayananT','pembayaranpelayanan_id'),
                    'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'kelompoktindakan_id' => 'Kelompoktindakan',
			'kelompoktindakan_nama' => 'Kelompoktindakan Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'tindakansudahbayar_id' => 'Tindakansudahbayar',
			'qty_tindakan' => 'Jumlah Tindakan',
			'jmlbiaya_tindakan' => 'Jmlbiaya Tindakan',
			'jmlsubsidi_asuransi' => 'Jmlsubsidi Asuransi',
			'jmlsubsidi_pemerintah' => 'Jmlsubsidi Pemerintah',
			'jmlsubsidi_rs' => 'Jmlsubsidi Rs',
			'jmliurbiaya' => 'Jmliurbiaya',
			'jmlpembebasan' => 'Jmlpembebasan',
			'jmlbayar_tindakan' => 'Jmlbayar Tindakan',
			'jmlsisabayar_tindakan' => 'Jmlsisabayar Tindakan',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'nopembayaran' => 'No. Pembayaran',
			'tglpembayaran' => 'Tgl. Pembayaran',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
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
			'ruanganpelakhir_id' => 'Ruanganpelakhir',
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

		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('jmlbiaya_tindakan',$this->jmlbiaya_tindakan);
		$criteria->compare('jmlsubsidi_asuransi',$this->jmlsubsidi_asuransi);
		$criteria->compare('jmlsubsidi_pemerintah',$this->jmlsubsidi_pemerintah);
		$criteria->compare('jmlsubsidi_rs',$this->jmlsubsidi_rs);
		$criteria->compare('jmliurbiaya',$this->jmliurbiaya);
		$criteria->compare('jmlpembebasan',$this->jmlpembebasan);
		$criteria->compare('jmlbayar_tindakan',$this->jmlbayar_tindakan);
		$criteria->compare('jmlsisabayar_tindakan',$this->jmlsisabayar_tindakan);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(nopembayaran)',strtolower($this->nopembayaran),true);
		$criteria->compare('LOWER(tglpembayaran)',strtolower($this->tglpembayaran),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
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
		$criteria->compare('ruanganpelakhir_id',$this->ruanganpelakhir_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('jmlbiaya_tindakan',$this->jmlbiaya_tindakan);
		$criteria->compare('jmlsubsidi_asuransi',$this->jmlsubsidi_asuransi);
		$criteria->compare('jmlsubsidi_pemerintah',$this->jmlsubsidi_pemerintah);
		$criteria->compare('jmlsubsidi_rs',$this->jmlsubsidi_rs);
		$criteria->compare('jmliurbiaya',$this->jmliurbiaya);
		$criteria->compare('jmlpembebasan',$this->jmlpembebasan);
		$criteria->compare('jmlbayar_tindakan',$this->jmlbayar_tindakan);
		$criteria->compare('jmlsisabayar_tindakan',$this->jmlsisabayar_tindakan);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(nopembayaran)',strtolower($this->nopembayaran),true);
		$criteria->compare('LOWER(tglpembayaran)',strtolower($this->tglpembayaran),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
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
		$criteria->compare('ruanganpelakhir_id',$this->ruanganpelakhir_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}