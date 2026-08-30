<?php

/**
 * This is the model class for table "inventarisasiruangan_t".
 *
 * The followings are the available columns in table 'inventarisasiruangan_t':
 * @property integer $inventarisasi_id
 * @property integer $terimapersdetail_id
 * @property integer $mutasibrgdetail_id
 * @property integer $barang_id
 * @property integer $ruangan_id
 * @property integer $batalmutasibrg_id
 * @property string $tgltransaksi
 * @property string $inventarisasi_kode
 * @property double $inventarisasi_hargabeli
 * @property double $inventarisasi_hargasatuan
 * @property double $inventarisasi_qty_in
 * @property double $inventarisasi_qty_out
 * @property double $inventarisasi_qty_skrg
 * @property double $inventarisasi_jmlmin
 * @property string $inventarisasi_keadaan
 * @property string $inventarisasi_keterangan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class InventarisasiruanganT extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InventarisasiruanganT the static model class
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
		return 'inventarisasiruangan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, ruangan_id, tgltransaksi, inventarisasi_kode, inventarisasi_hargabeli, inventarisasi_hargasatuan, inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, inventarisasi_keadaan', 'required'),
			array('terimapersdetail_id, mutasibrgdetail_id, barang_id, ruangan_id, batalmutasibrg_id', 'numerical', 'integerOnly'=>true),
			array('inventarisasi_hargabeli, inventarisasi_hargasatuan, inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, inventarisasi_jmlmin', 'numerical'),
			array('inventarisasi_kode, inventarisasi_keadaan', 'length', 'max'=>50),
			array('inventarisasi_keterangan, update_time, update_loginpemakai_id', 'safe'),
                        array('create_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_ruangan', 'default','value'=>Yii::app()->user->getState('ruangan_id'), 'setOnEmpty'=>false, 'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('inventarisasi_id, terimapersdetail_id, mutasibrgdetail_id, barang_id, ruangan_id, batalmutasibrg_id, tgltransaksi, inventarisasi_kode, inventarisasi_hargabeli, inventarisasi_hargasatuan, inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, inventarisasi_jmlmin, inventarisasi_keadaan, inventarisasi_keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'inventarisasi_id' => 'Inventarisasi',
			'terimapersdetail_id' => 'Terimapersdetail',
			'mutasibrgdetail_id' => 'Mutasibrgdetail',
			'barang_id' => 'Barang',
			'ruangan_id' => 'Ruangan',
			'batalmutasibrg_id' => 'Batalmutasibrg',
			'tgltransaksi' => 'Tgltransaksi',
			'inventarisasi_kode' => 'Inventarisasi Kode',
			'inventarisasi_hargabeli' => 'Inventarisasi Hargabeli',
			'inventarisasi_hargasatuan' => 'Inventarisasi Hargasatuan',
			'inventarisasi_qty_in' => 'Inventarisasi Jumlah In',
			'inventarisasi_qty_out' => 'Inventarisasi Jumlah Out',
			'inventarisasi_qty_skrg' => 'Inventarisasi Jumlah Skrg',
			'inventarisasi_jmlmin' => 'Inventarisasi Jmlmin',
			'inventarisasi_keadaan' => 'Inventarisasi Keadaan',
			'inventarisasi_keterangan' => 'Inventarisasi Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('mutasibrgdetail_id',$this->mutasibrgdetail_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('batalmutasibrg_id',$this->batalmutasibrg_id);
		$criteria->compare('LOWER(tgltransaksi)',strtolower($this->tgltransaksi),true);
		$criteria->compare('LOWER(inventarisasi_kode)',strtolower($this->inventarisasi_kode),true);
		$criteria->compare('inventarisasi_hargabeli',$this->inventarisasi_hargabeli);
		$criteria->compare('inventarisasi_hargasatuan',$this->inventarisasi_hargasatuan);
		$criteria->compare('inventarisasi_qty_in',$this->inventarisasi_qty_in);
		$criteria->compare('inventarisasi_qty_out',$this->inventarisasi_qty_out);
		$criteria->compare('inventarisasi_qty_skrg',$this->inventarisasi_qty_skrg);
		$criteria->compare('inventarisasi_jmlmin',$this->inventarisasi_jmlmin);
		$criteria->compare('LOWER(inventarisasi_keadaan)',strtolower($this->inventarisasi_keadaan),true);
		$criteria->compare('LOWER(inventarisasi_keterangan)',strtolower($this->inventarisasi_keterangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('mutasibrgdetail_id',$this->mutasibrgdetail_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('batalmutasibrg_id',$this->batalmutasibrg_id);
		$criteria->compare('LOWER(tgltransaksi)',strtolower($this->tgltransaksi),true);
		$criteria->compare('LOWER(inventarisasi_kode)',strtolower($this->inventarisasi_kode),true);
		$criteria->compare('inventarisasi_hargabeli',$this->inventarisasi_hargabeli);
		$criteria->compare('inventarisasi_hargasatuan',$this->inventarisasi_hargasatuan);
		$criteria->compare('inventarisasi_qty_in',$this->inventarisasi_qty_in);
		$criteria->compare('inventarisasi_qty_out',$this->inventarisasi_qty_out);
		$criteria->compare('inventarisasi_qty_skrg',$this->inventarisasi_qty_skrg);
		$criteria->compare('inventarisasi_jmlmin',$this->inventarisasi_jmlmin);
		$criteria->compare('LOWER(inventarisasi_keadaan)',strtolower($this->inventarisasi_keadaan),true);
		$criteria->compare('LOWER(inventarisasi_keterangan)',strtolower($this->inventarisasi_keterangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public static function validasiStok($qty, $id){
            $sql = "SELECT inventarisasi_id,inventarisasi_qty_in,inventarisasi_qty_out,inventarisasi_qty_skrg FROM inventarisasiruangan_t WHERE barang_id = $id AND ruangan_id = ".Yii::app()->user->getState('ruangan_id')." ORDER BY tgltransaksi";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            $selesai = false;
            $hasil = true;
            $out = 0;
            $in = 0;
            if (count((array)$stoks) == 0){
                $hasil = false;
            }
            foreach ($stoks as $i => $stok) {
                  $in += $stok['inventarisasi_qty_in'];
                  $out += $stok['inventarisasi_qty_out'];
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
		
		public static function tampilStok($id){	
			
            /*$sql = "SELECT inventarisasi_id,inventarisasi_qty_in,inventarisasi_qty_out,inventarisasi_qty_skrg FROM inventarisasiruangan_t WHERE barang_id = $id ORDER BY tgltransaksi";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            $selesai = false;
            $hasil = true;
            $out = 0;
            $in = 0;
            if (count((array)$stoks) == 0){
                $hasil = 0;
            }
            foreach ($stoks as $i => $stok) {
                  $in += $stok['inventarisasi_qty_in'];
                  $out += $stok['inventarisasi_qty_out'];
            }
            $selisih = $in - $out;
            //$selisih = $selisih-$qty;

            if ($selisih < 0){
                $hasil = 0;
            } else {
                $hasil = $selisih;
            }

            return $hasil;*/
			$b = new GUInformasistokbarangV;
			$b->barang_id = $id;
			$b->ruangan_id = Yii::app()->user->getState('ruangan_id');
			$prov = $b->search();

			$tot = 0;
			foreach ($prov->data as $item) {
				$tot += $item->inventarisasi_stok;
			}
			
			return $tot;
        }
        
        
        public static function simpanStokMutasi($mutasi, $detail) {
            $ok = true;
            
            $qty = $detail->qty_mutasi;
            
            $stoks = self::cekStokInRuanganAktif($detail->barang_id,  $mutasi->create_ruangan);
            
            // var_dump(count((array)$stoks)); die;
            
            foreach ($stoks as $item) {
                if ($qty == 0) break;
                
                $res = self::getSisaStokIn($item);
                $val = 0;
			
                if ($res > $qty) {
                    $val = $qty;
                    $qty = 0;
                } else {
                    $val = $res;
                    $qty -= $res;
                    $res = 0;
                }
                $nstock = new InventarisasiruanganT();

                $nstock->attributes = $item->attributes;
                // $nstock->produk_unit = $item->produk_unit;

                // nullify
                self::unsetIDStok($nstock);

                // simpan stok out
                $nstock_in = clone $nstock;
                $nstock->inventarisasiruanganasal_id = $item->inventarisasi_id;
                $nstock->mutasibrgdetail_id = $detail->mutasibrgdetail_id;
                $nstock->inventarisasi_qty_in = 0;
                $nstock->inventarisasi_qty_out = $val;
                $nstock->inventarisasi_qty_skrg = -$val;
                $nstock->tgltransaksi = $mutasi->tglmutasibrg;
                $nstock->inventarisasi_kode = MyGenerator::kodeMutasiBarang();
                
                if ($nstock->validate() || $nstock->validate()) {
                    $ok = $ok && $nstock->save();
                } else $ok = false;
                
                
                // simpan stok in
                $nstock_in->mutasibrgdetail_id = $detail->mutasibrgdetail_id;
                $nstock_in->inventarisasi_qty_in = $val;
                $nstock_in->inventarisasi_qty_out = 0;
                $nstock_in->inventarisasi_qty_skrg = $val;
                $nstock_in->tgltransaksi = $mutasi->tglmutasibrg;
                $nstock_in->inventarisasi_kode = MyGenerator::kodeTerimaMutasi();
                $nstock_in->ruangan_id = $mutasi->ruangantujuan_id;
                
                if ($nstock_in->validate() || $nstock_in->validate()) {
                    $ok = $ok && $nstock_in->save();
                } else $ok = false;
                
                if ($res == 0) self::nonAktifStokIn($item->inventarisasi_id); 
                
                // var_dump($nstock->attributes, $nstock_in->attributes);
                
                
                // die;
            }
            
            return $ok;
            
            
        }
        
        public static function simpanStokPemakaian($pemakaian, $detail) {
            $ok = true;
            
            $qty = $detail->jmlpakai;
            
            $stoks = self::cekStokInRuanganAktif($detail->barang_id,  $pemakaian->ruangan_id);
            
            // var_dump(count((array)$stoks)); die;
            
            foreach ($stoks as $item) {
                if ($qty == 0) break;
                
                $res = self::getSisaStokIn($item);
                $val = 0;
			
                if ($res > $qty) {
                    $val = $qty;
                    $qty = 0;
                } else {
                    $val = $res;
                    $qty -= $res;
//                    if (Yii::app()->user->getState('isstokumumminus') == false){
                        $res = 0;
//                    }
                }
                $nstock = new InventarisasiruanganT();

                $nstock->attributes = $item->attributes;
                // $nstock->produk_unit = $item->produk_unit;

                // nullify
                self::unsetIDStok($nstock);
//                echo '===============  '.$val;
//                exit();
                // simpan stok out
                // $nstock_in = clone $nstock;
                $nstock->inventarisasiruanganasal_id = $item->inventarisasi_id;
                $nstock->pemakaianbarang_id = $detail->pemakaianbarang_id;
                $nstock->inventarisasi_qty_in = 0;
                $nstock->inventarisasi_qty_out = $val;
                $nstock->inventarisasi_qty_skrg = -$val;
                $nstock->tgltransaksi = $pemakaian->tglpemakaianbrg;
                $nstock->inventarisasi_kode = MyGenerator::kodePemakaianBarang();
                
                if ($nstock->validate() || $nstock->validate()) {
                    $ok = $ok && $nstock->save();
                } else $ok = false;
                
                if ($res == 0) self::nonAktifStokIn($item->inventarisasi_id); 
                
                // var_dump($nstock->attributes, $nstock_in->attributes);
                
                
                // die;
            }
            
            return $ok;
            
            
        }
        
        public static function nonAktifStokIn($id) {
            $cstok = self::model()->findAllByAttributes(array(
                'inventarisasiruanganasal_id'=>$id,
            ));
            self::model()->updateByPk($id, array(
                'inventarisasiruangan_aktif'=>false,
            ));
            foreach ($cstok as $item2) {
                self::model()->updateByPk($item2->inventarisasi_id, array(
                    'inventarisasiruangan_aktif'=>false,
                ));
            }
        }
        
        public static function cekStokInRuanganAktif($barang_id, $ruangan_id) {
            $cr = new CDbCriteria();
            $cr->addCondition('inventarisasiruangan_aktif = true');
            $cr->order = 'inventarisasi_id asc';
            $cr->compare('barang_id', $barang_id);
            $cr->compare('ruangan_id', $ruangan_id);
            $cr->addCondition('(inventarisasi_qty_in - inventarisasi_qty_out) > 0');
            $cr->addCondition('inventarisasiruangan_aktif is true');
            
            // var_dump($cr); die;
            
            // $cr->addCondition("'".date('Y-m-d')."'::date <= tglkadaluarsa::date");


            return self::model()->findAll($cr);
        }
        
        
        public static function getSisaStokIn($item) {
            $tot_in = $item->inventarisasi_qty_in - $item->inventarisasi_qty_out;
            $tot_out = 0;

            $srel = self::model()->findAllByAttributes(array(
                'inventarisasiruanganasal_id'=>$item->inventarisasi_id,
                'inventarisasiruangan_aktif'=>true
            ));

            foreach ($srel as $item2) {
                $tot_in += $item2->inventarisasi_qty_in;
                $tot_out += $item2->inventarisasi_qty_out;
            }

            return ($tot_in - $tot_out);
        }
        
        
        public static function unsetIDStok(&$nstock) {
            
            // var_dump($nstock->attributes); die;
            
            $nstock->terimapersdetail_id = null;
            $nstock->mutasibrgdetail_id = null;
            $nstock->batalmutasibrg_id = null;
            $nstock->invbarangdet_id = null;
            $nstock->inventarisasi_id = null;
        }
        
        public static function batalStokMutasi($batalMutasi) {
        
            $ok = true;

            $detail = MutasibrgdetailT::model()->findByAttributes(array(
                'barang_id'=>$batalMutasi->barang_id,
                'mutasibrg_id'=>$batalMutasi->mutasibrg_id,
            ));
            $mutasi = MutasibrgT::model()->findByPk($batalMutasi->mutasibrg_id);

            $stok_keluar_asal = InventarisasiruanganT::model()->findAllByAttributes(array(
                'mutasibrgdetail_id'=>$detail->mutasibrgdetail_id,
                'ruangan_id'=>$mutasi->create_ruangan,
            ));

            $stok_masuk_tujuan = InventarisasiruanganT::model()->findAllByAttributes(array(
                'mutasibrgdetail_id'=>$detail->mutasibrgdetail_id,
                'ruangan_id'=>$mutasi->ruangantujuan_id,
            ));

            $qty_keluar = $batalMutasi->qty_mutasi;
            $qty_masuk = $batalMutasi->qty_mutasi;

            // kembalikan stok keluar asal
            foreach ($stok_keluar_asal as $item) {

                $selisih = $item->inventarisasi_qty_out - $item->inventarisasi_qty_in;

                // pengecekan selisih stok
                $qty = $qty_keluar;
                if ($qty_keluar > $selisih) {
                    $qty = $selisih;
                    $qty_keluar -= $selisih;
                } else {
                    $qty_keluar = 0;
                }

                // stok baru
                $stok_baru = new InventarisasiruanganT;
                $stok_baru->attributes = $item->attributes;
                self::unsetIDStok($stok_baru);

                $stok_baru->batalmutasibrg_id = $batalMutasi->batalmutasibrg_id;
                $stok_baru->inventarisasiruanganasal_id = null;
                $stok_baru->inventarisasi_qty_in = $qty;
                $stok_baru->inventarisasi_qty_out = 0;
                $stok_baru->inventarisasi_qty_skrg = $stok_baru->inventarisasi_qty_in - $stok_baru->inventarisasi_qty_out;
                $stok_baru->inventarisasi_kode = MyGenerator::kodeBatalMutasiBarang();
                $stok_baru->tgltransaksi = $batalMutasi->tglbatalmutasibrg;

                if ($stok_baru->validate()) {
                    $ok = $ok && $stok_baru->save();
                    //self::aktifStokIn($stok_baru->inventarisasiruanganasal_id);
                } else {
                    $ok = false;
                }
            }


            // nilangkan stok masuk tujuan
            foreach ($stok_masuk_tujuan as $item) {

                $selisih = self::getSisaStokIn($item);

                // pengecekan selisih stok
                $qty = $qty_masuk;
                $sisa = $selisih - $qty;
                if ($qty_masuk > $selisih) {
                    $sisa = 0;
                    $qty = $selisih;
                    $qty_masuk -= $selisih;
                } else {
                    $qty_masuk = 0;
                }

                // stok baru
                $stok_baru = new InventarisasiruanganT;
                $stok_baru->attributes = $item->attributes;
                self::unsetIDStok($stok_baru);

                $stok_baru->batalmutasibrg_id = $batalMutasi->batalmutasibrg_id;
                $stok_baru->inventarisasiruanganasal_id = $item->inventarisasi_id;
                $stok_baru->inventarisasi_qty_in = 0;
                $stok_baru->inventarisasi_qty_out = $qty;
                $stok_baru->inventarisasi_qty_skrg = $stok_baru->inventarisasi_qty_in - $stok_baru->inventarisasi_qty_out;
                $stok_baru->inventarisasi_kode = MyGenerator::kodeBatalMutasiBarang();
                $stok_baru->tgltransaksi = $batalMutasi->tglbatalmutasibrg;

                if ($stok_baru->validate()) {
                    $ok = $ok && $stok_baru->save();
                    if ($sisa == 0) {
                        self::nonAktifStokIn($stok_baru->inventarisasiruanganasal_id);
                    }
                } else {
                    $ok = false;
                }
            }

            if ($qty_keluar == 0 && $qty_masuk == 0) {
                return $ok;
            } else {
                return false;
            }
        }
        
        
        public static function kurangiStok($qty, $id) {
            $sql = "SELECT inventarisasi_id,inventarisasi_qty_in,inventarisasi_qty_out,inventarisasi_qty_skrg FROM inventarisasiruangan_t WHERE barang_id = $id ORDER BY tgltransaksi";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            $selesai = false;
            foreach ($stoks as $i => $stok) {
                if ($qty <= $stok['inventarisasi_qty_skrg']) {
                    $stok_current = $stok['inventarisasi_qty_skrg'] - $qty;
                    $stok_out = $stok['inventarisasi_qty_out'] + $qty;
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                    $selesai = true;
                    break;
                } else {
                    $qty = $qty - $stok['inventarisasi_qty_skrg'];
                    $stok_current = 0;
                    $stok_out = $stok['inventarisasi_qty_out'] + $stok['inventarisasi_qty_skrg'];
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                }
            }
        }
        
        public static function kembalikanStok($qty, $id){
            $sql = "SELECT inventarisasi_id,inventarisasi_qty_in,inventarisasi_qty_out,inventarisasi_qty_skrg FROM inventarisasiruangan_t WHERE barang_id = $id ORDER BY tgltransaksi";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($stoks as $i => $stok) {
                if ($qty <= $stok['inventarisasi_qty_out']) {
                    $stok_current = $stok['inventarisasi_qty_skrg'] + $qty;
                    $stok_out = $stok['inventarisasi_qty_out'] - $qty;
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                    $selesai = true;
                    break;
                } else {
                    $qty = $qty - $stok['inventarisasi_qty_out'];
                    $stok_current = $stok['inventarisasi_qty_out'];
                    $stok_out = 0;
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                }
            }
        }
        
        public static function kurangiStokBerdasarkanInventaris($qty, $id) {
            $sql = "SELECT inventarisasi_id,inventarisasi_qty_in,inventarisasi_qty_out,inventarisasi_qty_skrg FROM inventarisasiruangan_t WHERE inventarisasi_id = $id ORDER BY tgltransaksi";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            $selesai = false;
            foreach ($stoks as $i => $stok) {
                if ($qty <= $stok['inventarisasi_qty_skrg']) {
                    $stok_current = $stok['inventarisasi_qty_skrg'] - $qty;
                    $stok_out = $stok['inventarisasi_qty_out'] + $qty;
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                    $selesai = true;
                    break;
                } else {
                    $qty = $qty - $stok['inventarisasi_qty_skrg'];
                    $stok_current = 0;
                    $stok_out = $stok['inventarisasi_qty_out'] + $stok['inventarisasi_qty_skrg'];
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                }
            }
        }
        
        public static function kembalikanStokBerdasarkanRuangan($qty, $id, $ruangan_id){
            $sql = "SELECT inventarisasi_id,inventarisasi_qty_in,inventarisasi_qty_out,inventarisasi_qty_skrg FROM inventarisasiruangan_t WHERE barang_id = $id and ruangan_id = $ruangan_id ORDER BY tgltransaksi ASC";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($stoks as $i => $stok) {
                if ($qty <= $stok['inventarisasi_qty_out']) {
                    $stok_current = $stok['inventarisasi_qty_skrg'] + $qty;
                    $stok_out = $stok['inventarisasi_qty_out'] - $qty;
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                    $selesai = true;
                    break;
                } else {
                    $qty = $qty - $stok['inventarisasi_qty_out'];
                    $stok_current = $stok['inventarisasi_qty_out'];
                    $stok_out = 0;
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                }
            }
        }
}