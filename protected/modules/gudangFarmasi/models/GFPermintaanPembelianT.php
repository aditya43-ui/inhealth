<?php

class GFPermintaanPembelianT extends PermintaanpembelianT
{
        public $tglkadaluarsa, $total_harganetto;
        public $tgl_awal, $tgl_akhir;
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $tick;
        public $data,$sumberdana_id_langsung;
        public $jumlah;
        public $obatAlkes;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchPenerimaanItems()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('date(tglterimabarang)',$this->tglterimabarang);
		$criteria->compare('LOWER(nopermintaan)',strtolower($this->nopermintaan),true);
                $criteria->addCondition('penerimaanbarang_id isNUll');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = 'supplier';
		$criteria->addBetweenCondition('date(t.tglpermintaanpembelian)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(nopermintaan)',strtolower($this->nopermintaan),true);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		if(!empty($this->syaratbayar_id)){
			$criteria->addCondition('t.syaratbayar_id = '.$this->syaratbayar_id);
		}
		$criteria->addCondition('penerimaanbarang_id is null');
		$criteria->addCondition("supplier.supplier_jenis='Farmasi'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        /*
         * untuk Laporan Permintaan Pembelian
         */
        public function searchPermintaanPembelian()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = 't.supplier_id, t.permintaanpembelian_id, supplier_m.supplier_nama, supplier_m.supplier_alamat, t.nopermintaan, t.tglpermintaanpembelian,
							 sum(obatalkes_m.harganetto) as total_harganetto
							 ';
		$criteria->group = 't.supplier_id, t.permintaanpembelian_id, supplier_m.supplier_nama, supplier_m.supplier_alamat, t.nopermintaan, t.tglpermintaanpembelian';
		$criteria->addBetweenCondition('date(t.tglpermintaanpembelian)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(t.nopermintaan)',strtolower($this->nopermintaan),true);
                if(!empty($this->supplier_id)){
			if (is_array($this->supplier_id)){
				$criteria->addInCondition('t.supplier_id',$this->supplier_id);
			}else{
				$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
			}
		}
		if(!empty($this->syaratbayar_id)){
			$criteria->addCondition('t.syaratbayar_id = '.$this->syaratbayar_id);
		}
		$criteria->addCondition('t.penerimaanbarang_id is null');
		$criteria->addCondition("supplier_m.supplier_jenis='Farmasi'");
		$criteria->join = 'LEFT JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id
						   LEFT JOIN permintaandetail_t ON t.permintaanpembelian_id = permintaandetail_t.permintaanpembelian_id
						   LEFT JOIN obatalkes_m ON permintaandetail_t.obatalkes_id = obatalkes_m.obatalkes_id
						';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchPrintPermintaanPembelian()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = 't.supplier_id, t.permintaanpembelian_id,supplier_m.supplier_nama, supplier_m.supplier_alamat, t.nopermintaan, t.tglpermintaanpembelian,
							 sum(obatalkes_m.harganetto) as total_harganetto
							 ';
		$criteria->group = 't.supplier_id, t.permintaanpembelian_id,supplier_m.supplier_nama, supplier_m.supplier_alamat, t.nopermintaan, t.tglpermintaanpembelian';
		$criteria->addBetweenCondition('date(t.tglpermintaanpembelian)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(t.nopermintaan)',strtolower($this->nopermintaan),true);
		if(!empty($this->supplier_id)){
			if (is_array($this->supplier_id)){
				$criteria->addInCondition('t.supplier_id',$this->supplier_id);
			}else{
				$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
			}
		}
		if(!empty($this->syaratbayar_id)){
			$criteria->addCondition('t.syaratbayar_id = '.$this->syaratbayar_id);
		}
		$criteria->addCondition('t.penerimaanbarang_id is null');
		$criteria->addCondition("supplier_m.supplier_jenis='Farmasi'");
		$criteria->join = 'LEFT JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id
						   LEFT JOIN permintaandetail_t ON t.permintaanpembelian_id = permintaandetail_t.permintaanpembelian_id
						   LEFT JOIN obatalkes_m ON permintaandetail_t.obatalkes_id = obatalkes_m.obatalkes_id
						';
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}

	public function searchGrafik()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//                $criteria->with = 'supplier';
		$criteria->select = 'COUNT(t.supplier_id) as jumlah, supplier_m.supplier_nama as data';
		$criteria->group = 't.supplier_id, supplier_m.supplier_nama';
		$criteria->addBetweenCondition('date(t.tglpermintaanpembelian)',$this->tgl_awal,$this->tgl_akhir);
				
		$criteria->compare('LOWER(t.nopermintaan)',strtolower($this->nopermintaan),true);
		if(!empty($this->supplier_id)){
			$criteria->addInCondition('t.supplier_id', $this->supplier_id);
		}
		if(!empty($this->syaratbayar_id)){
			$criteria->addCondition('t.syaratbayar_id = '.$this->syaratbayar_id);
		}
		$criteria->addCondition('t.penerimaanbarang_id is null');
		//$criteria->addCondition("supplier.supplier_jenis='Farmasi'");
		$criteria->join = 'LEFT JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /*
         * end Laporan Permintaan Pembelian
         */
        
        public function getSupplierItems()
        {
            return SupplierM::model()->findAll("supplier_aktif=TRUE AND supplier_jenis='Farmasi' ORDER BY supplier_nama");
        }
        
        public function getSyaratBayarItems()
        {
            return SyaratbayarM::model()->findAll('syaratbayar_aktif=TRUE ORDER BY syaratbayar_nama');
        }
//		RND-7067       
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
        
        public function beforeSave() 
        {          
            if($this->tglterimabarang===null || trim($this->tglterimabarang)==''){
	        $this->setAttribute('tglterimabarang', null);
            }
            
            return parent::beforeSave();
        }

        public function getSupplierforInformasi()
        {
            return SupplierM::model()->findAll('supplier_aktif=TRUE ORDER BY supplier_nama');
        }
        
}