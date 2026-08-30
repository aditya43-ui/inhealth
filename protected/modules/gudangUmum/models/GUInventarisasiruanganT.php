<?php
class GUInventarisasiruanganT extends InventarisasiruanganT
{
	public $barang_type,$barang_kode,$barang_nama,$barang_namalainnya,$barang_merk,$barang_noseri,$barang_ukuran,$barang_bahan,$barang_thnbeli,$barang_warna,$barang_statusregister,$barang_ekonomis_thn
			,$barang_satuan,$barang_jmldlmkemasan,$barang_image,$ruangan_nama;
    public $jenisbarang_nama;
    
    public $qtystok_awal, $qtystok_in, $qtystok_out, $qtystok_akhir;
    public $nilaistok_awal, $nilaistok_in, $nilaistok_out, $nilaistok_akhir;
    
    public $data, $jumlah;
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'inventarisasi_id' => 'ID',
			'terimapersdetail_id' => 'Terimapersdetail',
			'mutasibrgdetail_id' => 'Mutasibrgdetail',
			'barang_id' => 'Barang',
			'ruangan_id' => 'Ruangan',
			'batalmutasibrg_id' => 'Batalmutasibrg',
			'tgltransaksi' => 'Tgl transaksi',
			'inventarisasi_kode' => 'Inventarisasi Kode',
			'inventarisasi_hargabeli' => 'Harga Beli',
			'inventarisasi_hargasatuan' => 'Harga Satuan',
			'inventarisasi_qty_in' => 'Qty In',
			'inventarisasi_qty_out' => 'Qty Out',
			'inventarisasi_qty_skrg' => 'Qty Skrg',
			'inventarisasi_jmlmin' => 'Jml min',
			'inventarisasi_keadaan' => 'Keadaan',
			'inventarisasi_keterangan' => 'Inventarisasi Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'invbarangdet_id' => 'Invbarangdet',
			'pemakaianbrgdetail_id' => 'Pemakaianbrgdetail T',
			'retpendetail_id' => 'Retpendetail',
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDialogPersediaan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$this->barang_type = Params::BARANG_TYPE_PERSEDIAAN;
		$criteria->with = array('barang');
		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('mutasibrgdetail_id',$this->mutasibrgdetail_id);
		if(!empty($this->barang_id)){
			$criteria->addCondition("t.barang_id = ".$this->barang_id);			
		}
		if(!empty($this->bidang_id)){
			$criteria->addCondition("bidang_id = ".$this->bidang_id);			
		}
		$criteria->compare('LOWER(barang.barang_nama)',strtolower($this->tgltransaksi),true);
		$criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('batalmutasibrg_id',$this->batalmutasibrg_id);
		$criteria->compare('LOWER(tgltransaksi)',strtolower($this->tgltransaksi),true);
		$criteria->compare('LOWER(inventarisasi_kode)',strtolower($this->inventarisasi_kode),true);
		$criteria->compare('inventarisasi_hargabeli',$this->inventarisasi_hargabeli);
		$criteria->compare('inventarisasi_hargasatuan',$this->inventarisasi_hargasatuan);
		$criteria->compare('inventarisasi_qty_in',$this->inventarisasi_qty_in);
		$criteria->compare('inventarisasi_qty_out',$this->inventarisasi_qty_out);
		$criteria->addCondition("inventarisasi_qty_skrg > 0");	
		$criteria->compare('inventarisasi_jmlmin',$this->inventarisasi_jmlmin);
		$criteria->compare('LOWER(inventarisasi_keadaan)',strtolower($this->inventarisasi_keadaan),true);
		$criteria->compare('LOWER(inventarisasi_keterangan)',strtolower($this->inventarisasi_keterangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		
		$criteria->compare('LOWER(barang.barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang.barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang.barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang.barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(barang.barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang.barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang.barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang.barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang.barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang.barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang.barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang.barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('LOWER(barang.barang_satuan)',strtolower($this->barang_satuan),true);
		$criteria->compare('barang.barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('LOWER(barang.barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang.barang_aktif',isset($this->barang_aktif)?$this->barang_aktif:true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    
    public function searchLaporanStokInventaris() {
        $tgl_awal = $this->tgl_awal;
        $tgl_akhir = $this->tgl_akhir;
        
        // var_dump($tgl_awal, $tgl_akhir);
        
        $criteria = new CDbCriteria;
        
        
        
        $criteria->group = 't.barang_id, b.barang_nama, t.barang_id, b.barang_nama, 
            b.barang_kode, b.barang_type, b.jenisbarang_id, jb.jenisbarang_nama,
            t.ruangan_id,  r.ruangan_nama, b.barang_satuan';
        
        $criteria->select = $criteria->group;
        
        // qty
        $criteria->select .= ", sum(case when t.tgltransaksi <= '${tgl_awal} 00:00:00' then (t.inventarisasi_qty_in - t.inventarisasi_qty_out) else 0 end) as qtystok_awal";
        $criteria->select .= ", sum(case when t.tgltransaksi between '${tgl_awal} 00:00:00' and '${tgl_akhir} 23:59:59' then t.inventarisasi_qty_in else 0 end) as qtystok_in";
        $criteria->select .= ", sum(case when t.tgltransaksi between '${tgl_awal} 00:00:00' and '${tgl_akhir} 23:59:59' then t.inventarisasi_qty_out else 0 end) as qtystok_out";
        $criteria->select .= ", sum(case when t.tgltransaksi <= '${tgl_akhir} 23:59:59' then (t.inventarisasi_qty_in - t.inventarisasi_qty_out) else 0 end) as qtystok_akhir";
        
        // nilai
        $criteria->select .= ", sum(case when t.tgltransaksi <= '${tgl_awal} 00:00:00' then (t.inventarisasi_qty_in - t.inventarisasi_qty_out) * t.inventarisasi_hargasatuan else 0 end) as nilaistok_awal";
        $criteria->select .= ", sum(case when t.tgltransaksi between '${tgl_awal} 00:00:00' and '${tgl_akhir} 23:59:59' then t.inventarisasi_qty_in * t.inventarisasi_hargasatuan else 0 end) as nilaistok_in";
        $criteria->select .= ", sum(case when t.tgltransaksi between '${tgl_awal} 00:00:00' and '${tgl_akhir} 23:59:59' then t.inventarisasi_qty_out * t.inventarisasi_hargasatuan else 0 end) as nilaistok_out";
        $criteria->select .= ", sum(case when t.tgltransaksi <= '${tgl_akhir} 23:59:59' then (t.inventarisasi_qty_in - t.inventarisasi_qty_out) * t.inventarisasi_hargasatuan else 0 end) as nilaistok_akhir";
        
        $criteria->join = 'join ruangan_m r on r.ruangan_id = t.ruangan_id
            join barang_m b on b.barang_id = t.barang_id
            left join jenisbarang_m jb on jb.jenisbarang_id = b.jenisbarang_id';
        
        $criteria->compare('t.ruangan_id', $this->ruangan_id);
		$criteria->addCondition(" t.inventarisasiruangan_aktif = TRUE ");
        // $criteria->addBetweenCondition('t.tgltransaksi::date', $this->tgl_awal, $this->tgl_akhir);
        
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>array(
                'defaultOrder'=>'b.barang_nama',
            )
		));    
        
       
    }
    
    public function searchPrintLaporanStokInventaris() {
        $prov = $this->searchLaporanStokInventaris();
        $prov->pagination = false;
        
        return $prov;
    }
    
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('barang','ruangan');
//		RND-8594		-> data (dialogbox) yg ditampilkan data yg stok nya masih ada.
//		$criteria->join = "JOIN inventarisasiruangan_t ON inventarisasiruangan_t.barang_id = t.barang_id";
		if(!empty($this->barang_id)){
			$criteria->addCondition("t.barang_id = ".$this->barang_id);			
		}
		$criteria->addCondition("t.ruangan_id = ".Yii::app()->user->getState('ruangan_id'));	
		$criteria->addCondition("t.inventarisasi_qty_skrg > 0");	
		$criteria->compare('LOWER(barang.barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(t.inventarisasi_kode)',strtolower($this->inventarisasi_kode),true);
		$criteria->compare('LOWER(inventarisasi_keadaan)',strtolower($this->inventarisasi_keadaan),true);
		$criteria->compare('LOWER(inventarisasi_keterangan)',strtolower($this->inventarisasi_keterangan),true);
//		$criteria->addCondition('inventarisasiruangan_t.inventarisasi_qty_skrg > 0 ');
		$criteria->limit = 10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	public static function getJumlahStok($inventarisasi_id = null){
            $criteria = new CDbCriteria();
            $criteria->addCondition('inventarisasi_id = '.$inventarisasi_id);
            $criteria->select = "sum(inventarisasi_qty_in - inventarisasi_qty_out) AS inventarisasi_qty_skrg";
            $model = InventarisasiruanganT::model()->find($criteria);
            if(isset($model->inventarisasi_qty_skrg)){
                return $model->inventarisasi_qty_skrg;
            }else{
                return 0;
            }
        }
        
        
    public function searchLaporanFastMoving() {
        $criteria = new CDbCriteria();
        $criteria->join = 'join barang_m b on b.barang_id = t.barang_id';
        $criteria->group = 't.barang_id, b.barang_nama, b.barang_kode, b.barang_type, b.barang_satuan';
        $criteria->select = $criteria->group.", "
                ."sum(case when t.tgltransaksi::date between '".$this->tgl_awal."'::date and '".$this->tgl_akhir."'::date then t.inventarisasi_qty_out else 0 end) as qtystok_out, "
                ."sum(case when t.tgltransaksi::date <= '".$this->tgl_akhir."'::date then (inventarisasi_qty_in - inventarisasi_qty_out) else 0 end) as qtystok_akhir";
        
        $criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('b.barang_type', $this->barang_type);
        // $criteria->addCondition('t.inventarisasiruangan_aktif = true');
        $criteria->order = "sum(case when t.tgltransaksi::date between '".$this->tgl_awal."'::date and '".$this->tgl_akhir."'::date then t.inventarisasi_qty_out else 0 end) desc";
        
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
		));
    }
    
    public function searchLaporanSlowMoving() {
        $criteria = new CDbCriteria();
        $criteria->join = 'join barang_m b on b.barang_id = t.barang_id';
        $criteria->group = 't.barang_id, b.barang_nama, b.barang_kode, b.barang_type, b.barang_satuan';
        $criteria->select = $criteria->group.", "
                ."sum(case when t.tgltransaksi::date between '".$this->tgl_awal."'::date and '".$this->tgl_akhir."'::date then t.inventarisasi_qty_out else 0 end) as qtystok_out, "
                ."sum(case when t.tgltransaksi::date <= '".$this->tgl_akhir."'::date then (inventarisasi_qty_in - inventarisasi_qty_out) else 0 end) as qtystok_akhir";
        
        $criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('b.barang_type', $this->barang_type);
        // $criteria->addCondition('t.inventarisasiruangan_aktif = true');
        $criteria->order = "sum(case when t.tgltransaksi::date between '".$this->tgl_awal."'::date and '".$this->tgl_akhir."'::date then t.inventarisasi_qty_out else 0 end) asc";
        
        $criteria->having = "sum(case when t.tgltransaksi::date between '".$this->tgl_awal."'::date and '".$this->tgl_akhir."'::date then t.inventarisasi_qty_out else 0 end) > 0";
        
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
		));
    }
    
    
    
    public function searchGrafikFastMoving() {
        $prov = $this->searchLaporanFastMoving();
        
        $prov->criteria->group = 'b.barang_nama';
        $prov->criteria->select = "b.barang_nama as data, "
                . "sum(case when t.tgltransaksi::date between '".$this->tgl_awal."'::date and '".$this->tgl_akhir."'::date then t.inventarisasi_qty_out else 0 end) as jumlah";

        // $prov->sort->defaultOrder = 't.ruangantujuan_nama';
        
        return $prov;
    }
    
    public function searchGrafikSlowMoving() {
        $prov = $this->searchLaporanSlowMoving();
        
        $prov->criteria->group = 'b.barang_nama';
        $prov->criteria->select = "b.barang_nama as data, "
                . "sum(case when t.tgltransaksi::date between '".$this->tgl_awal."'::date and '".$this->tgl_akhir."'::date then t.inventarisasi_qty_out else 0 end) as jumlah";

        // $prov->sort->defaultOrder = 't.ruangantujuan_nama';
        
        return $prov;
    }

}