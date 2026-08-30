<?php

class GFInfostokobatalkesruanganV extends InfostokobatalkesruanganV{
    public $tick,$data,$jumlah,$totalharga,$qtyinnetto,$qtyoutnetto,$qtycurrentnetto,$isGroupObat;
    public $tgl_awal,$tgl_akhir;
    public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public $harganetto_oa;
    public $jenisobatalkes_kode;
    public $jnskelompok, $lookup_name;
    public $status, $stok, $ceklisminimal;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /* ============================= Stok Obat Alkes ========================================== */
//                GAK DIPAKE YA???
//                public function criteriaCategory()
//                {
//		$criteria=new CDbCriteria;
//
//                                $criteria->select =
//                                        'hargajual, harganetto_oa, jenisobatalkes_id, obatalkes_nama,obatalkes_kode,jenisobatalkes_nama,obatalkes_golongan,sumberdana_nama,satuankecil_nama,
//                                        tglkadaluarsa,
//                                        SUM(qtystok_in) AS qtystok_in,
//                                        SUM(qtystok_out) AS qtystok_out,
//                                        SUM(qtystok_current) AS qtystok_current,
//                                        SUM(qtystok_in * harganetto_oa) As qtyinnetto,
//                                        SUM(qtystok_out * harganetto_oa) As qtyoutnetto,
//                                        SUM(qtystok_current * harganetto_oa) As qtycurrentnetto';
//                                $criteria->group = 'jenisobatalkes_id, obatalkes_nama,obatalkes_kode,jenisobatalkes_nama,obatalkes_golongan,sumberdana_nama,satuankecil_nama,
//                                                    hargajual, harganetto_oa,  tglkadaluarsa';
//		$criteria->compare('obatalkes_id',$this->obatalkes_id);
//                $criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));
//                $criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
//		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
//		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
//		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
//		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
//		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
//		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
//		$criteria->compare('kemasanbesar',$this->kemasanbesar);
//		$criteria->compare('kekuatan',$this->kekuatan);
//		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
//		$criteria->compare('minimalstok',$this->minimalstok);
//		$criteria->compare('satuankecil_id',$this->satuankecil_id);
//		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
//		$criteria->compare('sumberdana_id',$this->sumberdana_id);
//		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
//		$criteria->compare('ruangan_id',$ruangansession);
//		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
//		$criteria->compare('instalasi_id',$this->instalasi_id);
//		$criteria->compare('LOWER(tglstok_in)',strtolower($this->tglstok_in),true);
//		$criteria->compare('LOWER(tglstok_out)',strtolower($this->tglstok_out),true);
//		$criteria->compare('qtystok_in',$this->qtystok_in);
//		$criteria->compare('qtystok_out',$this->qtystok_out);
//		$criteria->compare('qtystok_current',$this->qtystok_current);
//		$criteria->compare('harganetto_oa',$this->harganetto_oa);
//		$criteria->compare('hargajual',$this->hargajual);
//		$criteria->compare('discount',$this->discount);
//		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
//		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
//		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
//		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
//		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
//		$criteria->compare('penerimaandetail_id',$this->penerimaandetail_id);
//                $criteria->addCondition('qtystok_current > 0');
//		$criteria->addBetweenCondition('tglstok_in',$this->tgl_awal,$this->tgl_akhir);
//                
//                                return $criteria;
//                }
//                
//	public function searchCategoryprint()
//        {
//        // Warning: Please modify the following code to remove attributes that
//        // should not be searched.
//
//        return new CActiveDataProvider($this, array(
//                'criteria'=>$this->criteriaCategory(),
//                                        'pagination'=>false,
//                ));
//        }
      
                
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
                                

		//Group berdasarkan Obat
		if($this->isGroupObat == 1){
			$criteria->select = "jenisobatalkes_id,jenisobatalkes_nama,obatalkes_id,obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, sumberdana_id, sumberdana_nama, satuankecil_nama, 
				SUM(harganetto_oa) AS harganetto_oa, SUM(hargajual) AS hargajual, SUM(qtystok_in) AS qtystok_in, SUM(qtystok_out) AS qtystok_out";
			$criteria->group = "jenisobatalkes_id,jenisobatalkes_nama,obatalkes_id,obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, sumberdana_id, sumberdana_nama, satuankecil_nama";
		}
//                UNTUK GUDANG BISA MENGETAHUI STOK DI SEMUA RUANGAN
//                $ruangansession = Yii::app()->user->ruangan_id;
//                $criteria->compare('ruangan_id',$ruangansession);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->addBetweenCondition('DATE(tglstok_in)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('minimalstok',$this->minimalstok);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
		}
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(tglstok_in)',strtolower($this->tglstok_in),true);
		$criteria->compare('LOWER(tglstok_out)',strtolower($this->tglstok_out),true);
		$criteria->compare('qtystok_in',$this->qtystok_in);
		$criteria->compare('qtystok_out',$this->qtystok_out);
//		$criteria->compare('qtystok_current',$this->qtystok_current);
//		$criteria->compare('harganetto_oa',$this->harganetto_oa);
//		$criteria->compare('hargajual',$this->hargajual);
//		$criteria->compare('discount',$this->discount);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->penerimaandetail_id)){
			$criteria->addCondition('penerimaandetail_id = '.$this->penerimaandetail_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchInformasiStok(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		//Group berdasarkan Obat
		$criteria->select = "jenisobatalkes_id,jenisobatalkes_nama,obatalkes_id,obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, sumberdana_id, sumberdana_nama, satuankecil_nama, 
			SUM(harganetto_oa) AS harganetto_oa, SUM(hargajual) AS hargajual, SUM(qtystok_in) AS qtystok_in, SUM(qtystok_out) AS qtystok_out, ruangan_id, ruangan_nama";
		$criteria->group = "jenisobatalkes_id,jenisobatalkes_nama,obatalkes_id,obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, sumberdana_id, sumberdana_nama, satuankecil_nama, ruangan_id, ruangan_nama";
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('minimalstok',$this->minimalstok);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
		}
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchPrintInformasi()
	{
		$this->searchInformasi();
	}
        
                
       // End Added in March, 6 2013       
        
        // Modify in February, 21 2013 //
//         public function getQtystock_in()
//         {
//             $criteria=$this->criteriaCategory();
//             $criteria->select = 'SUM(qtystok_in)';
//             return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
//         }
//                
//         public function getTotalqtystok_in()
//        {
//            $criteria=$this->criteriaCategory();
//            $criteria->select = 'SUM(qtystok_in)';
//            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
//        }
//        
//        public function getTotalhargajual()
//        {
//            $criteria=$this->criteriaCategory();
//            $criteria->select = 'SUM(hargajual)';
//            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
//        }
//        
//        public function getTotalharga()
//        {
//            $criteria=$this->criteriaCategory();
//            $criteria->select = '(SUM(hargajual) * SUM(qtystok_in)) AS totalharga';
//            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
//        }
        
	public function searchGrafik()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                    
                $filter = isset($_REQUEST['filter'])?$_REQUEST['filter']:null;
                if ($filter == 'jenis'){
                    $criteria->select = "(SUM(qtystok_in) - SUM(qtystok_out)) as jumlah, ( CASE WHEN jenisobatalkes_nama = '' THEN 'Jenis Obat Tidak Diketahui' ELSE jenisobatalkes_nama END) as data";
                    $criteria->group = 'jenisobatalkes_nama';
                }elseif ($filter == 'kategori'){
                    $criteria->select = "(SUM(qtystok_in) - SUM(qtystok_out)) as jumlah, ( CASE WHEN obatalkes_kategori = '' THEN 'Kategori Obat Tidak Diketahui' ELSE obatalkes_kategori END) as data";
                    $criteria->group = 'obatalkes_kategori';
                }elseif ($filter == 'golongan'){
                    $criteria->select = "(SUM(qtystok_in) - SUM(qtystok_out)) as jumlah, ( CASE WHEN obatalkes_golongan = '' THEN 'Golongan Obat Tidak Diketahui' ELSE obatalkes_golongan END) as data";
                    $criteria->group = 'obatalkes_golongan';
                }else{
                    $criteria->select = "(SUM(qtystok_in) - SUM(qtystok_out)) as jumlah, ( CASE WHEN jenisobatalkes_nama = '' THEN 'Jenis Obat Tidak Diketahui' ELSE jenisobatalkes_nama END) as data";
                    $criteria->group = 'jenisobatalkes_nama';
                }
                
                
		if (!empty($this->jenisobatalkes_id)){
                    $criteria->addInCondition(" jenisobatalkes_id ", $this->jenisobatalkes_id);
                }
                if (!empty($this->obatalkes_kategori)){
                    $criteria->addInCondition(" obatalkes_kategori ", $this->obatalkes_kategori);
                }

                if (!empty($this->obatalkes_golongan)){
                    $criteria->addInCondition(" obatalkes_golongan ", $this->obatalkes_golongan);
                }


                $criteria->addCondition('ruangan_id = '.Yii::app()->user->ruangan_id);

                if($this->qtystok_in == true){
                    $criteria->addCondition("qtystok_in = 0 ");          
                }

                if($this->qtystok_out == true){
                    $criteria->addCondition('qtystok_out = 0');

                }
//		$criteria->compare('qtystok_current',$this->qtystok_current);
		$criteria->compare('LOWER(ruangan_id)',strtolower($this->ruangan_id),true);
//                $criteria->addBetweenCondition('tglstok_in',$this->tgl_awal, $this->tgl_akhir);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
               // $criteria->limit=-1; 
               // if($this->qtystok_in == null)
              //  $criteria->addCondition('qtystok_in != 0');
            
               // if($this->qtystok_out == null)
              //  $criteria->addCondition('qtystok_out != 0');
                $criteria->order = "jumlah DESC";

                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteria(),
                        'criteria'=>$criteria,
                ));
        }
          public function search()
	{
              /*
		$criteria=new CDbCriteria();
                $ruangansession = Yii::app()->user->ruangan_id;
                $criteria->compare('jenisobatalkes_nama',$this->jenisobatalkes_nama);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('ruangan_id',$ruangansession);
		$criteria->compare('qtystok_in',$this->qtystok_in);
		$criteria->compare('qtystok_out',$this->qtystok_out);
		$criteria->compare('qtystok_current',$this->qtystok_current);
		$criteria->compare('penerimaandetail_id',$this->penerimaandetail_id);
                */
		return new CActiveDataProvider($this, array(
                    'criteria'=>$this->Criteria(),
                    'pagination'=>array(
                        'pageSize'=>10,
                    ),
                    'sort'=>array(
                        'defaultOrder'=>'obatalkes_nama asc',
                    )
		));
	}
        
        public function searchPrint()
        {
                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteria(),
                        'pagination'=>false,
                        'sort'=>array(
                            'defaultOrder'=>'obatalkes_nama asc',
                        )
                ));
        }
         public function Criteria()
        {
            $criteria=new CDbCriteria;
//            $criteria->with=array('obatalkes');
//            $criteria->join = 'LEFT JOIN obatalkes_m ON obatalkes_m.obatalkes_id=stokobatalkes_t.obatalkes_id';
            $criteria->select = 'l.lookup_name, t.obatalkes_kategori, t.obatalkes_golongan,t.satuankecil_nama,t.jenisobatalkes_nama, t.obatalkes_kode,  t.obatalkes_nama, SUM(t.qtystok_in) AS qty_in, SUM(t.qtystok_out) AS qty_out, 
                                (SUM(t.qtystok_in) - SUM(t.qtystok_out)) AS qty_current, oa.hargajual';
            $criteria->group = 'l.lookup_name, t.obatalkes_kategori, t.obatalkes_golongan,t.satuankecil_nama,t.obatalkes_kode,  t.obatalkes_nama,t.jenisobatalkes_nama, oa.hargajual';//hargajual,
			
            $criteria->join = " JOIN obatalkes_m oa ON t.obatalkes_id = oa.obatalkes_id "
                                . " LEFT JOIN lookup_m l ON oa.jnskelompok = l.lookup_value";
            
            if (!empty($this->jenisobatalkes_id)){
                $criteria->addInCondition(" t.jenisobatalkes_id ", $this->jenisobatalkes_id);
            }
            if (!empty($this->obatalkes_kategori)){
                $criteria->addInCondition(" t.obatalkes_kategori ", $this->obatalkes_kategori);
            }
            
            if (!empty($this->obatalkes_golongan)){
                $criteria->addInCondition(" t.obatalkes_golongan ", $this->obatalkes_golongan);
            }
            
            
            $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->ruangan_id);
            
            if($this->qtystok_in == true){
                $criteria->addCondition("t.qtystok_in = 0 ");          
            }
            
            if($this->qtystok_out == true){
                $criteria->addCondition('t.qtystok_out = 0');
                
            }
            
//            if($this->qtystok_out)
            
            return $criteria;
        }
        
        // End Modify //
        public function searchDataObat()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
                $criteria->select = "obatalkes_id,obatalkes_nama,obatalkes_golongan,obatalkes_kategori,jenisobatalkes_id,jenisobatalkes_nama,obatalkes_kode,satuankecil_nama";
                //var_dump($this->instalasi_id);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
                }else{
                    $criteria->addCondition('instalasi_id is NULL ');
                }
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
                
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
                }else{
                   $criteria->addCondition('ruangan_id is NULL ');
                }
		//$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}		
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);		
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}		
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);		
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);		
                if(!empty($this->tglkadaluarsa)){
			 $criteria->addCondition("tglkadaluarsa ='$this->tglkadaluarsa'");
		 }
               
		
		$criteria->compare('qtystok',$this->qtystok);
                $criteria->group = 'obatalkes_id, obatalkes_nama,obatalkes_golongan,obatalkes_kategori, jenisobatalkes_id,jenisobatalkes_nama,obatalkes_kode,satuankecil_nama';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                        'defaultOrder'=>'obatalkes_nama',
                    )
            ));
        }
        
        public function searchDataObatInformasi()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            
                $criteria->group = 't.obatalkes_id, t.ruangan_id,t.qtystokoa, t.instalasi_nama, t.ruangan_nama, t.jenisobatalkes_nama, t.obatalkes_kode, t.obatalkes_nama, t.minimalstok, t.tglkadaluarsa, t.satuankecil_nama';
                $criteria->select = $criteria->group.', sum(t.qtystokoa_baik) as qtystokoa_baik, sum(t.qtystokoa_rusak) as qtystokoa_rusak, sum(t.qtystokoa) as qtystokoa';
                $criteria->join = "LEFT JOIN stokminimal_t ON stokminimal_t.obatalkes_id = t.obatalkes_id AND stokminimal_t.ruangan_id = t.ruangan_id";
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
                }
                
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
                }
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}		
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);
		}		
		$criteria->compare('LOWER(t.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(t.obatalkes_nama)',strtolower($this->obatalkes_nama),true);		
		$criteria->compare('LOWER(t.obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
               
                if($this->ceklisminimal){
                    $modKonfigF = KonfigfarmasiK::model()->find();
                    
                    if($modKonfigF->isstokminimalfarmasi){
                        $criteria->addCondition("t.qtystokoa <= t.minimalstok AND t.qtystokoa !='0' OR t.qtystokoa !='null'");    
                    }else{
                        $criteria->addCondition("t.qtystokoa <= stokminimal_t.jmlminimalstok AND t.qtystokoa !='0' OR t.qtystokoa !='null'");    
                    }
                }

               
    
                $criteria->order = "t.qtystokoa ASC";


            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function getStokObatRuanganPemesan($ruangan_id = null){ // menampilkan stok obat berdasarkan ruangan pemesan
            if(isset($_GET['pesanobatalkes_id'])){
                    $modInfoOa = GFInformasipesanobatalkesV::model()->findByAttributes(array('pesanobatalkes_id'=>$_GET['pesanobatalkes_id']));
                    if(!empty($modInfoOa)){
                            return StokobatalkesT::getJumlahStok($this->obatalkes_id,$modInfoOa->ruanganpemesan_id, $this->tglkadaluarsa);
                    }else{
                            return 0;
                    }
            }else{
                    if (empty($ruangan_id)) $ruangan_id = $this->ruangan_id;
                    return StokobatalkesT::getJumlahStok($this->obatalkes_id,$ruangan_id, $this->tglkadaluarsa);
            }
	}
        
        
        public function searchObatAlkesKadaluarsa() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionObatAlkesKadaluarsa();
            $criteria->order = 'instalasi_nama ASC, ruangan_nama ASC';

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        public function searchObatAlkesKadaluarsaPrint() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionObatAlkesKadaluarsa();
            $criteria->order = 'instalasi_nama ASC, ruangan_nama ASC, obatalkes_nama ASC';
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination' => false,
                    ));
        }

        protected function functionObatAlkesKadaluarsa() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.            
            $criteria = new CDbCriteria;
            $criteria->select = "ruangan_id,harganetto,instalasi_nama, ruangan_nama,obatalkes_id,obatalkes_nama,obatalkes_golongan,obatalkes_kategori,jenisobatalkes_id,jenisobatalkes_nama,obatalkes_kode,satuankecil_nama, tglkadaluarsa";                        
            $criteria->addBetweenCondition('tglkadaluarsa',$this->tgl_awal,$this->tgl_akhir,true);                                               
            $criteria->compare("obatalkes_nama",$this->obatalkes_nama,TRUE);
            $criteria->compare("obatalkes_kode",$this->obatalkes_kode,TRUE);
            if(!empty($this->ruangan_id)){                    
                $criteria->addInCondition('ruangan_id', $this->ruangan_id);
            }else{
               if (!empty($this->instalasi_id)){
                    $criteria->addInCondition('instalasi_id', $this->instalasi_id);
                  
               }
            }
            if (!empty($this->status)){
                   
            
                if(empty($this->status[1])){    
                        if ($this->status[0] == '1'){
                            $criteria->addCondition(" tglkadaluarsa <= date(now()) ");
                        }else if($this->status[0] == '2'){
                            $criteria->addCondition(" tglkadaluarsa >= date(now()) ");
                        }
                    }else{
                       $criteria->addCondition(" tglkadaluarsa >= date(now()) or tglkadaluarsa <= date(now()) ");

                    }
                }
            $criteria->group = 'ruangan_id,harganetto,instalasi_nama, ruangan_nama,obatalkes_id, obatalkes_nama,obatalkes_golongan,obatalkes_kategori, jenisobatalkes_id,jenisobatalkes_nama,obatalkes_kode,satuankecil_nama, tglkadaluarsa';


            return $criteria;
        }

        public function searchGrafikObatAlkesKadaluarsa()
        {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                $criteria=new CDbCriteria;

                //$criteria->select = "count(formuliropname_id) as jumlah, (CASE WHEN stokopname_id IS NOT NULL THEN 'Sudah Stok Opname' ELSE 'Belum Stok Opname' END) as data";
                $criteria->select = "ruangan_id,harganetto,instalasi_nama, ruangan_nama,count(obatalkes_id) as jumlah,obatalkes_nama,obatalkes_golongan,obatalkes_kategori,jenisobatalkes_id,jenisobatalkes_nama,obatalkes_kode,satuankecil_nama, (CASE WHEN (tglkadaluarsa <= now()) THEN 'Sudah Kedaluwarsa' ELSE 'Belum Kedaluwarsa' END ) as data";                        
                $criteria->addBetweenCondition('tglkadaluarsa',$this->tgl_awal,$this->tgl_akhir,true);                           
                $criteria->compare("obatalkes_nama",$this->obatalkes_nama,TRUE);
                $criteria->compare("obatalkes_kode",$this->obatalkes_kode,TRUE);
                if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                      $criteria->addInCondition('instalasi_id', $this->instalasi_id);
                   }
                }                
                  if(empty($this->status[1])){    
                        if ($this->status == '1'){
                            $criteria->addCondition(" tglkadaluarsa <= date(now()) ");
                        }else if($this->status == '2'){
                            $criteria->addCondition(" tglkadaluarsa >= date(now()) ");
                        }
                    }else{
                       $criteria->addCondition(" tglkadaluarsa >= date(now()) or tglkadaluarsa <= date(now()) ");

                    }
                $criteria->group = 'ruangan_id,harganetto,instalasi_nama, ruangan_nama,obatalkes_id, obatalkes_nama,obatalkes_golongan,obatalkes_kategori, jenisobatalkes_id,jenisobatalkes_nama,obatalkes_kode,satuankecil_nama, tglkadaluarsa';
               


                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }  
        
        
        
        /**
	 * sisa stok bulan sebelumnya untuk informasi stok
	 * @return int
	 */
	public function getStokSebelum() {
		$criteria = new CDbCriteria();
		$criteria->addCondition('stokoa_aktif IS TRUE');
		$criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
                $criteria->addCondition("ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
		
		$tgl_awal = "2015-01-01"; //perkiraan awal implementasi
		$tgl_akhir = date("Y-m-t", strtotime("-1 month"));
		$criteria->addCondition("(DATE(tglstok_in) BETWEEN '" . $tgl_awal . "' AND '" . $tgl_akhir . "') OR (DATE(tglstok_out) BETWEEN '" . $tgl_awal . "' AND '" . $tgl_akhir . "')");
		$criteria->group = "obatalkes_id, ruangan_id";
		$criteria->select = "sum(qtystok_in - qtystok_out) AS qtystok";
		$model = StokobatalkesT::model()->find($criteria);
		if (isset($model->qtystok)) {
			return $model->qtystok;
		} else {
			return 0;
		}
	}
	/**
	 * stok masuk untuk informasi stok obatalkes
	 */
	public function getStokMasuk() {
		$criteria = new CDbCriteria();
		$format = new MyFormatter();
		$tgl_awal = date('Y-m-01');
		$tgl_akhir = date('Y-m-d');
		$criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
                $criteria->addCondition("ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
		$criteria->addBetweenCondition('DATE(tglstok_in)', $tgl_awal, $tgl_akhir);
		$criteria->group = "obatalkes_id, ruangan_id";
		$criteria->select = "sum(qtystok_in) AS qtystok_in";
		$model = StokobatalkesT::model()->find($criteria);

		if (isset($model->qtystok_in)) {
			return $model->qtystok_in;
		} else {
			return 0;
		}
	}
	
	
	/**
	 * untuk stok keluar di informasi stok obat alkes
	 * @return int
	 */
	public function getStokKeluar() {
		$criteria = new CDbCriteria();
		$format = new MyFormatter();
		$criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
                $criteria->addCondition("ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
		$tgl_awal = date('Y-m-01');
		$tgl_akhir = date('Y-m-d');
		$criteria->addBetweenCondition('DATE(tglstok_out)', $tgl_awal, $tgl_akhir);
		$criteria->group = "obatalkes_id, ruangan_id";
		$criteria->select = "sum(qtystok_out) AS qtystok_out";
		$model = StokobatalkesT::model()->find($criteria);
		if (isset($model->qtystok_out)) {
			return $model->qtystok_out;
		} else {
			return 0;
		}
	}
        
        public function searchDataObatInformasiPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            
               $criteria->group = 't.obatalkes_id, t.ruangan_id, t.instalasi_nama, t.ruangan_nama, t.jenisobatalkes_nama, t.obatalkes_kode, t.obatalkes_nama, t.minimalstok, t.tglkadaluarsa, t.satuankecil_nama';
                $criteria->select = $criteria->group.', sum(t.qtystokoa_baik) as qtystokoa_baik, sum(t.qtystokoa_rusak) as qtystokoa_rusak, sum(qtystokoa) as qtystokoa';
                $criteria->join = "LEFT JOIN stokminimal_t ON stokminimal_t.obatalkes_id = t.obatalkes_id AND stokminimal_t.ruangan_id = t.ruangan_id";
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
                }
                
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
                }
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}		
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);
		}		
		$criteria->compare('LOWER(t.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(t.obatalkes_nama)',strtolower($this->obatalkes_nama),true);		
		$criteria->compare('LOWER(t.obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
               
                if($this->ceklisminimal){
                    $modKonfigF = KonfigfarmasiK::model()->find();
                    
                    if($modKonfigF->isstokminimalfarmasi){
                        $criteria->addCondition('t.qtystokoa <= t.minimalstok');    
                    }else{
                        $criteria->addCondition('t.qtystokoa <= stokminimal_t.jmlminimalstok');    
                    }
                }
                $criteria->order = "t.obatalkes_nama ASC";

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                'pagination'=>false,
            ));
        }
        
}

?>
