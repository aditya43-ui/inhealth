<?php

/**
 * This is the model class for table "stokbahanmakanan_t".
 *
 * The followings are the available columns in table 'stokbahanmakanan_t':
 * @property integer $stokbahanmakanan_id
 * @property integer $terimabahandetail_id
 * @property integer $bahanmakanan_id
 * @property string $tgltransaksi
 * @property double $qty_masuk
 * @property double $qty_keluar
 * @property string $keterangan_makanan
 */
class StokbahanmakananT extends CActiveRecord
{
    public $jenis_opname;
    public $jenisbahanmakanan, $golbahanmakanan_id, $golbahanmakanan_nama, $namabahanmakanan, $satuanbahan, $kelbahanmakanan;
    
    public $volume_sistem;
    public $volume_fisik;
    public $volume_selisih;
    public $qtystok, $returpenbahanmakandetail_id;
    
    public $stokopnamebahanmakanandet_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StokbahanmakananT the static model class
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
		return 'stokbahanmakanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahanmakanan_id, tgltransaksi, qty_masuk, qty_keluar', 'required'),
			array('terimabahandetail_id, bahanmakanan_id, pemakaianhbnmkndet_id, returpenbahanmakandetail_id, stokopnamegizidet_id', 'numerical', 'integerOnly'=>true),
			array('qty_masuk, qty_keluar, qty_current', 'numerical'),
			array('keterangan_makanan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stokbahanmakanan_id, terimabahandetail_id, bahanmakanan_id, tgltransaksi, qty_masuk, qty_keluar, keterangan_makanan, pemakaianhbnmkndet_id, returpenbahanmakandetail_id, stokopnamegizidet_id', 'safe', 'on'=>'search'),
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
			'stokbahanmakanan_id' => 'Stok Bahan Makanan',
			'terimabahandetail_id' => 'Terima Bahan Detail',
			'bahanmakanan_id' => 'Bahan Makanan',
			'tgltransaksi' => 'Tanggal Transaksi',
			'qty_masuk' => 'Jumlah Masuk',
			'qty_keluar' => 'Jumlah Keluar',
			'keterangan_makanan' => 'Keterangan Makanan',
            'namabahanmakanan' => 'Nama Bahan Makanan',
            'satuanbahan' => 'Satuan Bahan',
            'jenisbahanmakanan' => 'Jenis Bahan Makanan',
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

		$criteria->compare('stokbahanmakanan_id',$this->stokbahanmakanan_id);
		$criteria->compare('terimabahandetail_id',$this->terimabahandetail_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('LOWER(tgltransaksi)',strtolower($this->tgltransaksi),true);
		$criteria->compare('qty_masuk',$this->qty_masuk);
		$criteria->compare('qty_keluar',$this->qty_keluar);
		$criteria->compare('LOWER(keterangan_makanan)',strtolower($this->keterangan_makanan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('stokbahanmakanan_id',$this->stokbahanmakanan_id);
		$criteria->compare('terimabahandetail_id',$this->terimabahandetail_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('LOWER(tgltransaksi)',strtolower($this->tgltransaksi),true);
		$criteria->compare('qty_masuk',$this->qty_masuk);
		$criteria->compare('qty_keluar',$this->qty_keluar);
		$criteria->compare('LOWER(keterangan_makanan)',strtolower($this->keterangan_makanan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public static function validasiStok($qty, $id) {
            $sql = "SELECT stokbahanmakanan_id,qty_masuk,qty_keluar FROM stokbahanmakanan_t WHERE bahanmakanan_id = $id ORDER BY tgltransaksi";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            $selesai = false;
            $hasil = true;
            $out = 0;
            $in = 0;
            
            if (count((array)$stoks) == 0){
                $hasil = false;
            }
            foreach ($stoks as $i => $stok) {
                  $in += $stok['qty_masuk'];
                  $out += $stok['qty_keluar'];
            }
            $selisih = $in - $out;
            $selisih = $selisih-$qty;
            
            if ($selisih < 0){
                $hasil = false;
            } else {
                $hasil = true;
            }

            return $hasil;
        }
        
        public static function kurangiStokMenu($qty, $id) { //id = $menudiet_id; $qty = jumlahkirim
            $bahanMakanan = BahanMenuDietM::model()->findAllByAttributes(array('menudiet_id'=>$id));
			
			//var_dump($id);
			
            if (count((array)$bahanMakanan) > 0){								
                foreach ($bahanMakanan as $row){
                    $sql = "SELECT stokbahanmakanan_id,qty_masuk,qty_keluar, qty_current FROM stokbahanmakanan_t WHERE bahanmakanan_id = $row->bahanmakanan_id ORDER BY tgltransaksi";
                    $stoks = Yii::app()->db->createCommand($sql)->queryAll();
                    $selesai = false;
                    $qty = $qty*$row->jmlbahan;
                    foreach ($stoks as $i => $stok) {                        
                        if ($qty <= $stok['qty_current']) {							
                            $stok_current = $stok['qty_current'] - $qty;
                            $stok_out = $stok['qty_keluar'] + $qty;
                            StokbahanmakananT::model()->updateByPk($stok['stokbahanmakanan_id'], array('qty_current' => $stok_current, 'qty_keluar' => $stok_out));
                            $selesai = true;
                            break;
                        } else {							
                            $qty = $qty - $stok['qty_current'];
                            $stok_current = 0;
                            $stok_out = $stok['qty_keluar'] + $stok['qty_current'];
                            StokbahanmakananT::model()->updateByPk($stok['stokbahanmakanan_id'], array('qty_current' => $stok_current, 'qty_keluar' => $stok_out));
                        }
                    }
                }
            }
            else{
                return false;
            }
        }
        
        public static function validasiStokMenu($qty, $id) { // id = menudiet_id
            $hasil = true;
            $bahanMakanan = BahanMenuDietM::model()->findAllByAttributes(array('menudiet_id'=>$id));
            if (count((array)$bahanMakanan) > 0){
                foreach ($bahanMakanan as $row){
                    $sql = "SELECT stokbahanmakanan_id,qty_masuk,qty_keluar FROM stokbahanmakanan_t WHERE bahanmakanan_id = $row->bahanmakanan_id ORDER BY tgltransaksi";
                    $stoks = Yii::app()->db->createCommand($sql)->queryAll();
                    $selesai = false;
                    $hasil = true;
                    $out = 0;
                    $in = 0;
                    $qty = $qty*$row->jmlbahan;
                    if (count((array)$stoks) == 0){
                        $hasil = false;
                    }
                    foreach ($stoks as $i => $stok) {
                          $in += $stok['qty_masuk'];
                          $out += $stok['qty_keluar'];
                    }
                    $selisih = $in - $out;
                    $selisih = $selisih-$qty;
					//var_dump($selisih);
                    if ($selisih < 0){
                        $hasil = $hasil && false;
                    } else {
                        $hasil = $hasil && true;
                    }
                }
            }

            return $hasil;
        }
		
        public static function getJumlahStok($bahanmakan_id){
            $criteria = new CDbCriteria();
            $criteria->select = "sum(qty_masuk - qty_keluar) AS qtystok";
            $criteria->addCondition('bahanmakanan_id = '.$bahanmakan_id);
           
            $criteria->group = "bahanmakanan_id";            
            $model = StokbahanmakananT::model()->find($criteria);
            
            if(isset($model->qtystok)){
                return $model->qtystok;
            }else{
                return 0;
            }
        }
		 
        
        public function searchBahanMakananOpname() {
            $model = $this;
            $criteria=new CDbCriteria;
            $criteria->limit = 250; //RTN-1095 //RND-9703 Reduce limit from 1000 to 50
            if(!Yii::app()->request->isAjaxRequest){//data hanya muncul setelah melakukan pencarian
                $criteria->limit = 0;
            }
    
            if(isset($_GET['formuliropnamegizi_id'])){
                $model = new FormuliropnamegizidetR;
                $criteria->join = "join bahanmakanan_m b on b.bahanmakanan_id = t.bahanmakanan_id "
                        . "left join golbahanmakanan_m g on g.golbahanmakanan_id = b.golbahanmakanan_id "
                        . "left join ("
                        . "select bahanmakanan_id, sum(qty_masuk - qty_keluar) as qtystok from stokbahanmakanan_t group by bahanmakanan_id"
                        . ") stok on stok.bahanmakanan_id = t.bahanmakanan_id";
                $criteria->select = "t.*, b.jenisbahanmakanan, b.namabahanmakanan, g.golbahanmakanan_nama, stok.qtystok";
                $criteria->addCondition('t.formuliropnamegizi_id = '.$_GET['formuliropnamegizi_id']);
                $criteria->addCondition('t.stokopnamegizidet_id IS NULL');
                $criteria->limit = -1;
            }else if(isset($_GET['stokopnamegizi_id'])){
                $model = new StokopnamegizidetT;
                $criteria->join = "join bahanmakanan_m b on b.bahanmakanan_id = t.bahanmakanan_id "
                        . "left join golbahanmakanan_m g on g.golbahanmakanan_id = b.golbahanmakanan_id";
                $criteria->select = "t.*, b.jenisbahanmakanan, b.namabahanmakanan, g.golbahanmakanan_nama, t.volume_sistem as qtystok";
                $criteria->addCondition('t.stokopnamegizi_id = '.$_GET['stokopnamegizi_id']);
                $criteria->limit = -1;
            }else{
                if(!empty($this->bahanmakanan_id)){
                    $criteria->addCondition('t.bahanmakanan_id = '.$this->bahanmakanan_id);
                }
    
                $criteria->compare('t.bahanmakanan_id', $this->bahanmakanan_id);
                if($this->jenis_opname == Params::JENISSTOKOPNAME_PENYESUAIAN){
                                        $criteria->compare('lower(o.jenisbahanmakanan)', strtolower($this->jenisbahanmakanan), true);
                                        $criteria->addCondition("o.namabahanmakanan ILIKE '".$this->namabahanmakanan."%' ");
                                        $criteria->compare('lower(o.kelbahanmakanan)', strtolower($this->kelbahanmakanan), true);
    
                                        if(!empty($this->golbahanmakanan_id)){
                                            $criteria->addCondition("o.golbahanmakanan_id = ".$this->golbahanmakanan_id);
                                        }
                                        $criteria->compare('lower(o.satuanbahan)', strtolower($this->satuanbahan), true);
                                        $criteria->group = "o.jenisbahanmakanan, t.bahanmakanan_id,"
                                                . "o.namabahanmakanan, o.golbahanmakanan_id, g.golbahanmakanan_nama, o.kelbahanmakanan";
                    $criteria->select = $criteria->group.", sum(t.qty_masuk - qty_keluar) as qtystok";
    
                                        $criteria->join = "join bahanmakanan_m o on o.bahanmakanan_id = t.bahanmakanan_id "
                                                . "left join golbahanmakanan_m g on g.golbahanmakanan_id = o.golbahanmakanan_id";
    
                                        $criteria->addCondition('o.bahanmakanan_aktif = true');
                                        $criteria->order = 'o.namabahanmakanan asc';
    
                                        $model = $this;
                }else{
                    $model = new BahanmakananM;
                                        $criteria->select = "t.*, b.golbahanmakanan_nama";
                                        $criteria->compare('lower(t.jenisbahanmakanan)', strtolower($this->jenisbahanmakanan), true);
                                        $criteria->addCondition("t.namabahanmakanan ILIKE '".$this->namabahanmakanan."%' ");
                                        if(!empty($this->golbahanmakanan_id)){
                                            $criteria->addCondition("t.golbahanmakanan_id = ".$this->golbahanmakanan_id);
                                        }
                                        $criteria->compare('lower(t.satuanbahan)', strtolower($this->satuanbahan), true);
    
                                        $criteria->compare('lower(t.kelbahanmakanan)', strtolower($this->kelbahanmakanan), true);
                                        $criteria->join = "left join informasistokbahanmakanan_v i on i.bahanmakanan_id = t.bahanmakanan_id "
                                                . "left join golbahanmakanan_m b on b.golbahanmakanan_id = t.golbahanmakanan_id";
                                        $criteria->addCondition("i.bahanmakanan_id is null");
                                        $criteria->addCondition('t.bahanmakanan_aktif = true');
                                        //$criteria->addCondition('i.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                                        $criteria->order = 't.namabahanmakanan asc';
                                }
            }
    
                        // var_dump($criteria); die;
    
            return new CActiveDataProvider($model, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}