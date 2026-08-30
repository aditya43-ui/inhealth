<?php

/**
 * This is the model class for table "informasikartustokbahanmakanan_v".
 *
 * The followings are the available columns in table 'informasikartustokbahanmakanan_v':
 * @property integer $bahanmakanan_id
 * @property string $sumberdanabhn
 * @property string $jenisbahanmakanan
 * @property string $kelbahanmakanan
 * @property string $namabahanmakanan
 * @property double $jmlpersediaan
 * @property string $satuanbahan
 * @property double $harganettobahan
 * @property double $hargajualbahan
 * @property double $discount
 * @property string $tglkadaluarsabahan
 * @property integer $jmlminimal
 * @property integer $jmldlmkemasan
 * @property string $ket_spesifikasibahanmakanan
 * @property integer $golbahanmakanan_id
 * @property string $golbahanmakanan_nama
 * @property string $tgltransaksi
 * @property double $qty_masuk
 * @property double $qty_keluar
 * @property double $qty_current
 * @property integer $terimabahandetail_id
 * @property string $nopenerimaanbahan
 * @property integer $pemakaianbhnmkndet_id
 * @property string $no_pemakaianbhnmkn
 */
class InformasikartustokbahanmakananV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir, $transaksi, $pilihTgl;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasikartustokbahanmakananV the static model class
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
		return 'informasikartustokbahanmakanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahanmakanan_id, jmlminimal, jmldlmkemasan, golbahanmakanan_id, terimabahandetail_id, pemakaianbhnmkndet_id, returpenbahanmakandetail_id, stokopnamedet_awal_id, stokopnamedet_penyesuaian_id', 'numerical', 'integerOnly'=>true),
			array('jmlpersediaan, harganettobahan, hargajualbahan, discount, qty_masuk, qty_keluar, qty_current', 'numerical'),
			array('sumberdanabhn, jenisbahanmakanan, kelbahanmakanan, satuanbahan, nopenerimaanbahan, noreturbahanmakan', 'length', 'max'=>50),
			array('namabahanmakanan, golbahanmakanan_nama', 'length', 'max'=>100),
			array('no_pemakaianbhnmkn, nostokopname_awal, nostokopname_penyesuaian', 'length', 'max'=>20),
			array('tglkadaluarsabahan, ket_spesifikasibahanmakanan, tgltransaksi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bahanmakanan_id, sumberdanabhn, jenisbahanmakanan, kelbahanmakanan, namabahanmakanan, jmlpersediaan, satuanbahan, harganettobahan, hargajualbahan, discount, tglkadaluarsabahan, jmlminimal, jmldlmkemasan, ket_spesifikasibahanmakanan, golbahanmakanan_id, golbahanmakanan_nama, tgltransaksi, qty_masuk, qty_keluar, qty_current, terimabahandetail_id, nopenerimaanbahan, pemakaianbhnmkndet_id, no_pemakaianbhnmkn, returpenbahanmakandetail_id, stokopnamedet_awal_id, stokopnamedet_penyesuaian_id, noreturbahanmakan, nostokopname_awal, nostokopname_penyesuaian', 'safe', 'on'=>'search'),
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
			'bahanmakanan_id' => 'Bahanmakanan',
			'sumberdanabhn' => 'Sumberdanabhn',
			'jenisbahanmakanan' => 'Jenisbahanmakanan',
			'kelbahanmakanan' => 'Kelbahanmakanan',
			'namabahanmakanan' => 'Namabahanmakanan',
			'jmlpersediaan' => 'Jmlpersediaan',
			'satuanbahan' => 'Satuanbahan',
			'harganettobahan' => 'Harganettobahan',
			'hargajualbahan' => 'Hargajualbahan',
			'discount' => 'Keringanan',
			'tglkadaluarsabahan' => 'Tglkadaluarsabahan',
			'jmlminimal' => 'Jmlminimal',
			'jmldlmkemasan' => 'Jmldlmkemasan',
			'ket_spesifikasibahanmakanan' => 'Ket Spesifikasibahanmakanan',
			'golbahanmakanan_id' => 'Golbahanmakanan',
			'golbahanmakanan_nama' => 'Golbahanmakanan Nama',
			'tgltransaksi' => 'Tgltransaksi',
			'qty_masuk' => 'Qty Masuk',
			'qty_keluar' => 'Qty Keluar',
			'qty_current' => 'Qty Current',
			'terimabahandetail_id' => 'Terimabahandetail',
			'nopenerimaanbahan' => 'Nopenerimaanbahan',
			'pemakaianbhnmkndet_id' => 'Pemakaianbhnmkndet',
			'no_pemakaianbhnmkn' => 'No Pemakaianbhnmkn',
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

		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('sumberdanabhn',$this->sumberdanabhn,true);
		$criteria->compare('jenisbahanmakanan',$this->jenisbahanmakanan,true);
		$criteria->compare('kelbahanmakanan',$this->kelbahanmakanan,true);
		$criteria->compare('namabahanmakanan',$this->namabahanmakanan,true);
		$criteria->compare('jmlpersediaan',$this->jmlpersediaan);
		$criteria->compare('satuanbahan',$this->satuanbahan,true);
		$criteria->compare('harganettobahan',$this->harganettobahan);
		$criteria->compare('hargajualbahan',$this->hargajualbahan);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('tglkadaluarsabahan',$this->tglkadaluarsabahan,true);
		$criteria->compare('jmlminimal',$this->jmlminimal);
		$criteria->compare('jmldlmkemasan',$this->jmldlmkemasan);
		$criteria->compare('ket_spesifikasibahanmakanan',$this->ket_spesifikasibahanmakanan,true);
		$criteria->compare('golbahanmakanan_id',$this->golbahanmakanan_id);
		$criteria->compare('golbahanmakanan_nama',$this->golbahanmakanan_nama,true);
		$criteria->compare('tgltransaksi',$this->tgltransaksi,true);
		$criteria->compare('qty_masuk',$this->qty_masuk);
		$criteria->compare('qty_keluar',$this->qty_keluar);
		$criteria->compare('qty_current',$this->qty_current);
		$criteria->compare('terimabahandetail_id',$this->terimabahandetail_id);
		$criteria->compare('nopenerimaanbahan',$this->nopenerimaanbahan,true);
		$criteria->compare('pemakaianbhnmkndet_id',$this->pemakaianbhnmkndet_id);
		$criteria->compare('no_pemakaianbhnmkn',$this->no_pemakaianbhnmkn,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchStokBahanMakanan()
	{

            $criteria=new CDbCriteria;
            if(!empty($this->bahanmakanan_id)){
                $criteria->addCondition("bahanmakanan_id = ".$this->bahanmakanan_id);
            }
                
            if($this->transaksi){
                $criteria->addCondition($this->transaksi.' > 0 and '.$this->transaksi.' is not null'); 
            }
            $criteria->addCondition('(qty_masuk <> 0 or qty_keluar <> 0)');
            $criteria->order = "tgltransaksi ASC";
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
        
    public function getKeteranganTransaksi() {
//        if (!empty($this->nopenerimaanbahan)) return "Penerimaan Bahan Makanan";
//        
//        if (!empty($this->no_pemakaianbhnmkn)) return "Pemakaian Bahan Makanan";
        
        if(!empty($this->terimabahandetail_id)){
            return 'Penerimaan Bahan Makanana';
        }else if(!empty($this->pemakaianhbnmkndet_id)){
            return 'Pemakaian Bahan Makanan';
        }else if(!empty($this->returpenbahanmakandetail_id)){
            return "Retur Penerimaan Bahan Makanan";
        }else if(!empty($this->stokopnamedet_awal_id)){
            return "Stok Opname Awal";
        }else if(!empty($this->stokopnamedet_penyesuaian_id)){
            return "Stok Opname Penyesuaian";
        }
        
        return "-";
    }
    
    public function getNoTransaksi() {
        if(!empty($this->nopenerimaanbahan)){
            return $this->nopenerimaanbahan;
        }else if(!empty($this->no_pemakaianbhnmkn)){
            return $this->no_pemakaianbhnmkn;
        }else if(!empty($this->noreturbahanmakan)){
            return $this->noreturbahanmakan;
        }else if(!empty($this->nostokopname_awal)){
            return $this->nostokopname_awal;
        }else if(!empty($this->nostokopname_penyesuaian)){
            return $this->nostokopname_penyesuaian;
        }
        return "-";
    }
    
    public function getNamaTransaksiKartuStok(){
            $transaksi = array(
                'terimabahandetail_id'=>"Penerimaan Bahan Makanan",//$this->getAttributeLabel("terimamutasi_id"),    
                 'pemakaianbhnmkndet_id'=>"Pemakaian Bahan Makanan",//$this->getAttributeLabel("terimamutasi_id"),    
                'returpenbahanmakandetail_id'=>"Retur Penerimaan Bahan Makanan",
                'stokopnamedet_awal_id'=>"Stok Opname Awal",
                'stokopnamedet_penyesuaian_id'=>"Stok Opname Penyesuaian",
                
            );
            return $transaksi;
    }
}