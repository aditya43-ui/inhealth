<?php

/**
 * This is the model class for table "informasikartustokbarang_v".
 *
 * The followings are the available columns in table 'informasikartustokbarang_v':
 * @property integer $barang_id
 * @property integer $jenisbarang_id
 * @property string $barang_type
 * @property string $barang_kode
 * @property string $barang_nama
 * @property string $barang_namalainnya
 * @property string $barang_merk
 * @property string $barang_noseri
 * @property string $barang_ukuran
 * @property string $barang_bahan
 * @property string $barang_thnbeli
 * @property string $barang_warna
 * @property boolean $barang_statusregister
 * @property integer $barang_ekonomis_thn
 * @property string $barang_satuan
 * @property integer $barang_jmldlmkemasan
 * @property string $barang_image
 * @property double $barang_harga
 * @property integer $bidang_id
 * @property string $bidang_kode
 * @property string $bidang_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $ruangan_lokasi
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property double $qtystok_in
 * @property double $qtystok_out
 * @property integer $terimapersdetail_id
 * @property integer $terimapersediaan_id
 * @property string $nopenerimaan
 * @property integer $mutasibrg_id
 * @property string $nomutasibrg
 * @property string $jenisbarang_nama
 */
class InformasikartustokbarangV extends CActiveRecord
{
    
    public $tgl_awal, $tgl_akhir, $transaksi, $pilihTgl;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasikartustokbarangV the static model class
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
		return 'informasikartustokbarang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, jenisbarang_id, barang_ekonomis_thn, barang_jmldlmkemasan, bidang_id, ruangan_id, instalasi_id, terimapersdetail_id, terimapersediaan_id, mutasibrg_id, batalmutasibrg_id, pemakaianbarang_id', 'numerical', 'integerOnly'=>true),
			array('barang_harga, qtystok_in, qtystok_out', 'numerical'),
			array('barang_type, barang_kode, barang_merk, barang_warna, barang_satuan, bidang_kode, ruangan_nama, ruangan_lokasi, instalasi_nama, nopenerimaan, nomutasibrg, jenisbarang_nama, nobatalmutasibrg', 'length', 'max'=>50),
			array('barang_nama, barang_namalainnya, bidang_nama', 'length', 'max'=>100),
			array('barang_noseri, barang_ukuran, barang_bahan, nopemakaianbrg', 'length', 'max'=>20),
			array('barang_thnbeli', 'length', 'max'=>5),
			array('barang_image', 'length', 'max'=>200),
			array('barang_statusregister', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('barang_id, jenisbarang_id, barang_type, barang_kode, barang_nama, barang_namalainnya, barang_merk, barang_noseri, barang_ukuran, barang_bahan, barang_thnbeli, barang_warna, barang_statusregister, barang_ekonomis_thn, barang_satuan, barang_jmldlmkemasan, barang_image, barang_harga, bidang_id, bidang_kode, bidang_nama, ruangan_id, ruangan_nama, ruangan_lokasi, instalasi_id, instalasi_nama, qtystok_in, qtystok_out, terimapersdetail_id, terimapersediaan_id, nopenerimaan, mutasibrg_id, nomutasibrg, jenisbarang_nama, batalmutasibrg_id, pemakaianbarang_id, nobatalmutasibrg, nopemakaianbrg', 'safe', 'on'=>'search'),
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
			'barang_id' => 'Barang',
			'jenisbarang_id' => 'Jenis Barang',
			'barang_type' => 'Type Barang',
			'barang_kode' => 'Kode Barang',
			'barang_nama' => 'Nama Barang',
			'barang_namalainnya' => 'Barang Namalainnya',
			'barang_merk' => 'Barang Merk',
			'barang_noseri' => 'Barang Noseri',
			'barang_ukuran' => 'Barang Ukuran',
			'barang_bahan' => 'Barang Bahan',
			'barang_thnbeli' => 'Barang Thnbeli',
			'barang_warna' => 'Barang Warna',
			'barang_statusregister' => 'Barang Statusregister',
			'barang_ekonomis_thn' => 'Barang Ekonomis Thn',
			'barang_satuan' => 'Barang Satuan',
			'barang_jmldlmkemasan' => 'Barang Jmldlmkemasan',
			'barang_image' => 'Barang Image',
			'barang_harga' => 'Barang Harga',
			'bidang_id' => 'Bidang',
			'bidang_kode' => 'Bidang Kode',
			'bidang_nama' => 'Bidang Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_lokasi' => 'Ruangan Lokasi',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'qtystok_in' => 'Stok Masuk',
			'qtystok_out' => 'Stok Keluar',
			'terimapersdetail_id' => 'Terimapersdetail',
			'terimapersediaan_id' => 'Terima Persediaan',
			'nopenerimaan' => 'No. Penerimaan',
			'mutasibrg_id' => 'Mutasibrg',
			'nomutasibrg' => 'No. Mutasi',
			'jenisbarang_nama' => 'Jenis Barang',
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
		$criteria->addBetweenCondition("date(tgltransaksi)", $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('jenisbarang_id',$this->jenisbarang_id);
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_namalainnya',$this->barang_namalainnya,true);
		$criteria->compare('barang_merk',$this->barang_merk,true);
		$criteria->compare('barang_noseri',$this->barang_noseri,true);
		$criteria->compare('barang_ukuran',$this->barang_ukuran,true);
		$criteria->compare('barang_bahan',$this->barang_bahan,true);
		$criteria->compare('barang_thnbeli',$this->barang_thnbeli,true);
		$criteria->compare('barang_warna',$this->barang_warna,true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('barang_image',$this->barang_image,true);
		$criteria->compare('barang_harga',$this->barang_harga);
		$criteria->compare('bidang_id',$this->bidang_id);
		$criteria->compare('bidang_kode',$this->bidang_kode,true);
		$criteria->compare('bidang_nama',$this->bidang_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_lokasi',$this->ruangan_lokasi,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('qtystok_in',$this->qtystok_in);
		$criteria->compare('qtystok_out',$this->qtystok_out);
		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('nopenerimaan',$this->nopenerimaan,true);
		$criteria->compare('mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('nomutasibrg',$this->nomutasibrg,true);
		$criteria->compare('jenisbarang_nama',$this->jenisbarang_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchInformasiPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition("date(tgltransaksi)", $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('jenisbarang_id',$this->jenisbarang_id);
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_namalainnya',$this->barang_namalainnya,true);
		$criteria->compare('barang_merk',$this->barang_merk,true);
		$criteria->compare('barang_noseri',$this->barang_noseri,true);
		$criteria->compare('barang_ukuran',$this->barang_ukuran,true);
		$criteria->compare('barang_bahan',$this->barang_bahan,true);
		$criteria->compare('barang_thnbeli',$this->barang_thnbeli,true);
		$criteria->compare('barang_warna',$this->barang_warna,true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('barang_image',$this->barang_image,true);
		$criteria->compare('barang_harga',$this->barang_harga);
		$criteria->compare('bidang_id',$this->bidang_id);
		$criteria->compare('bidang_kode',$this->bidang_kode,true);
		$criteria->compare('bidang_nama',$this->bidang_nama,true);
		if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GUDANG_FARMASI){			
			$criteria->addCondition('ruangan_id ='.Yii::app()->user->getState('ruangan_id'));
			$criteria->addCondition('instalasi_id ='.Yii::app()->user->getState('instalasi_id'));
		}else{
			if (!empty($this->ruangan_id)){
				$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
			}
			
			if (!empty($this->instalasi_id)){
				$criteria->addCondition('instalasi_id ='.$this->instalasi_id);
			}
		}
		$criteria->compare('qtystok_in',$this->qtystok_in);
		$criteria->compare('qtystok_out',$this->qtystok_out);
		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('nopenerimaan',$this->nopenerimaan,true);
		$criteria->compare('mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('nomutasibrg',$this->nomutasibrg,true);
		$criteria->compare('jenisbarang_nama',$this->jenisbarang_nama,true);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
    
    public function getNoTransaksi() {
        if (!empty($this->nopenerimaan)) return $this->nopenerimaan;
        
        if (!empty($this->nomutasibrg)) return $this->nomutasibrg;
        
        if (!empty($this->invbarang_no)) return $this->invbarang_no;
        
        if (!empty($this->nobatalmutasibrg)) return $this->nobatalmutasibrg;
        
        if (!empty($this->nopemakaianbrg)) return $this->nopemakaianbrg;
        return "-";
    }
    public function getKeteranganTransaksi() {
        if (!empty($this->nopenerimaan)) return "Penerimaan Barang";
        
        if (!empty($this->nomutasibrg)) return "Mutasi";
        
        if (!empty($this->invbarang_no)) return "Inventarisasi Barang ".$this->invbarang_jenis;
        
        if (!empty($this->pemakaianbarang_id)) return "Pemakaian Barang";
        
        if (!empty($this->batalmutasibrg_id)) return "Batal Mutasi Barang";
        
        return "-";
    }
    
    public function getSisaStok($qtystok_in, $qtystok_out, $barang_satuan) {
        $total = $qtystok_in - $qtystok_out;
        if($total < 0){
            $total = 0;
        }
        return $total.' '.$barang_satuan;
    }
    
    public function getNamaTransaksiKartuStok(){
            $transaksi = array(
//                    'terimapersdetail_id'=>"Terima Barang",//$this->getAttributeLabel("mutasioaruangan_id"),
                    'terimapersediaan_id'=>"Penerimaan Barang",//$this->getAttributeLabel("terimamutasi_id"),    
                 'mutasibrg_id'=>"Mutasi",//$this->getAttributeLabel("terimamutasi_id"),    
                    'invbarang_id'=>"Inventarisasi Barang",
                'batalmutasibrg_id'=>"Batal Mutasi Barang",
                'pemakaianbarang_id'=>"Pemakaian Barang",                
//                    'returpembelian_id'=>"Retur Faktur",//$this->getAttributeLabel("returpembelian_id"),
//                    'pemakaianobat_id'=>'Pemakaian di Ruangan',
//                    'pemusnahanobatalkes_id'=>$this->getAttributeLabel("pemusnahanobatalkes_id"),                          
//                    'penjualanresep_id'=>$this->getAttributeLabel("penjualanresep_id"),			
//                    //'returpenerimaan_id'=>$this->getAttributeLabel("returpenerimaan_id"),
//                    'returresep_id'=>$this->getAttributeLabel("returresep_id"),
//                    'stokopname_id_1'=>"Stok Opname Awal",//$this->getAttributeLabel("stokopname_id"),								
//                    'stokopname_id_2'=>"Stok Opname Penyesuaian",//$this->getAttributeLabel("stokopname_id"),								
            );
            return $transaksi;
    }
    
    public function searchStokBarang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//		$criteria->addBetweenCondition("date(tgltransaksi)", $this->tgl_awal, $this->tgl_akhir);
                  if(!empty($this->barang_id)){
                      $criteria->addCondition("barang_id = ".$this->barang_id);
//                      $criteria->compare('barang_id',$this->barang_id);
                  }
                    if(!empty($this->jenisbarang_id)){
                        $criteria->addCondition("jenisbarang_id = ".$this->jenisbarang_id);
//                        $criteria->compare('jenisbarang_id',$this->jenisbarang_id);
                    }
		
		
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_namalainnya',$this->barang_namalainnya,true);
		$criteria->compare('barang_merk',$this->barang_merk,true);
		$criteria->compare('barang_noseri',$this->barang_noseri,true);
		$criteria->compare('barang_ukuran',$this->barang_ukuran,true);
		$criteria->compare('barang_bahan',$this->barang_bahan,true);
		$criteria->compare('barang_thnbeli',$this->barang_thnbeli,true);
		$criteria->compare('barang_warna',$this->barang_warna,true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('barang_image',$this->barang_image,true);
		$criteria->compare('barang_harga',$this->barang_harga);
		$criteria->compare('bidang_id',$this->bidang_id);
		$criteria->compare('bidang_kode',$this->bidang_kode,true);
		$criteria->compare('bidang_nama',$this->bidang_nama,true);
                if(!empty($this->ruangan_id)){
                    $criteria->addCondition("ruangan_id =".$this->ruangan_id);
                }
//		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_lokasi',$this->ruangan_lokasi,true);
                if(!empty($this->instalasi_id)){
                    $criteria->addCondition("instalasi_id =".$this->instalasi_id);
                }
//		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
//		$criteria->compare('qtystok_in',$this->qtystok_in);
//		$criteria->compare('qtystok_out',$this->qtystok_out);
                if(!empty($this->terimapersdetail_id)){
                     $criteria->addCondition("terimapersdetail_id = ".$this->terimapersdetail_id);
                }
		 if(!empty($this->terimapersediaan_id)){
                     $criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);
//                     $criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
                 }
		
		$criteria->compare('nopenerimaan',$this->nopenerimaan,true);
		
                if(!empty($this->mutasibrg_id)){
                    $criteria->addCondition("mutasibrg_id = ".$this->mutasibrg_id);
//                    $criteria->compare('mutasibrg_id',$this->mutasibrg_id);
                }
		$criteria->compare('nomutasibrg',$this->nomutasibrg,true);
		$criteria->compare('jenisbarang_nama',$this->jenisbarang_nama,true);
                
                if($this->transaksi){
                    if ($this->transaksi == "invbarang_no") {
                        $criteria->addCondition($this->transaksi.' is not null'); 
                    } else {
                        $criteria->addCondition($this->transaksi.' > 0 and '.$this->transaksi.' is not null'); 
                    }
                }
                $criteria->addCondition('(qtystok_in <> 0 or qtystok_out <> 0)');
                $criteria->order="tgltransaksi ASC";
               
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
}