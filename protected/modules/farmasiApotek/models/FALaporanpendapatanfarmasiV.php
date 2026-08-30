<?php

class FALaporanpendapatanfarmasiV extends LaporanpendapatanfarmasiV
{
        public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode,$data, $jumlah;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpendapatanfarmasiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->addBetweenCondition('date(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);

                if(is_array($this->jenispenjualan)){
                    $jenispenjualans[] = null;
                    foreach ($this->jenispenjualan AS $i=>$jenis){
                        $jenispenjualans[$i] = strtolower($jenis);
                    }
                    $criteria->addInCondition('LOWER(jenispenjualan)',$jenispenjualans);
                }
                if(is_array($this->jenisobatalkes_id)){
                    $criteria->addInCondition('jenisobatalkes_id',$this->jenisobatalkes_id);
                }
		return $criteria;
	}

    public function functionCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('date(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);						
		}
        $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
        $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
        $criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
        return $criteria;
    }
     public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();

//        $criteria->select = 'count(obatalkes_id) as jumlah, obatalkes_nama as data';
//        $criteria->group = 'obatalkes_id,obatalkes_nama';
//        if (!empty($this->jenisobatalkes_id)) {
//            $criteria->select .= ', jenisobatalkes_nama as tick';
//            $criteria->group .= ', jenisobatalkes_nama';
//        } else {
//            $criteria->select .= ',jenisobatalkes_nama as tick';
//            $criteria->group .= ', jenisobatalkes_nama';
//        }
        $criteria->select = 'sum(harganetto_oa) as jumlah, jenispenjualan as data';
        $criteria->group = 'jenispenjualan';
        

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
        /**
         * searchTablePendapatanTransaksi digunakan di farmasiApotek/LaporanFarmasi/LaporanPendapatanTransaksi
         * @param type $limit
         * @return \CActiveDataProvider
         */
        public function searchTablePendapatanTransaksi($limit = true){
            $criteria = $this->criteriaSearch();
            $criteria->group = "penjualanresep_id, tglpenjualan, noresep, jenispenjualan";
            $criteria->select = $criteria->group.", sum(hargajual_oa) AS hargajual_oa, sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa * qty_oa) AS harganetto_oa, sum(hpp) AS hpp";
            $criteria->order = $criteria->group;
            $pagination = array('pageSize'=>10);
            if(!$limit){
                $criteria->limit = -1;
                $pagination = false;
            }
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>$pagination,
            ));
        }
        public function getTrJual($kolom = "", $sum = false){
            $hasil = 0;
            $format = new MyFormatter;
            if(isset($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']) && isset($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir'])){
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
            }
            $criteria = $this->criteriaSearch();
            $criteria->group = "tglpenjualan, noresep, jenispenjualan";
            $criteria->select = $criteria->group.", sum(hargajual_oa) AS hargajual_oa, sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa * qty_oa) AS harganetto_oa";
            $criteria->order = $criteria->group;
            if($sum){
                $hasils = $this->model()->findAll($criteria);
                foreach($hasils AS $i => $value){
                    $hasil += $value->$kolom;
                }
            }else{
                $criteria->addCondition("noresep = '".$this->noresep."'");
                $hasil = $this->model()->find($criteria)->$kolom;
            }
            return $hasil;
            
        }
        public function getTrRetur($kolom = "", $sum = false){
            $hasil = 0;
            $format = new MyFormatter;
            if(isset($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']) && isset($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir'])){
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
            }
            $criteria = $this->criteriaSearch();
            $criteria->group = "tglpenjualan, noresep, jenispenjualan";
            $criteria->select = $criteria->group.", sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa * qty_oa) AS harganetto_oa";
            $criteria->addCondition('returresep_id > 0');
            $criteria->order = $criteria->group;
            
            if($sum){
                $hasils = $this->model()->findAll($criteria);
                foreach($hasils AS $i => $value){
                    $hasil += $value->$kolom;
                    // echo $hasil; 
                }
            }else{
                 // $echo $this->noresep; exit(); 
                $criteria->addCondition("penjualanresep_id=".$this->penjualanresep_id);
                $hasil = isset($this->model()->find($criteria)->$kolom)?$this->model()->find($criteria)->$kolom:0;
            }
            // exit();
            return $hasil;
            
        }
        public function getTrTotal($kolom = "", $sum = false){
            $hasil = 0;
            $format = new MyFormatter;
            if(isset($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']) && isset($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir'])){
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
            }
            $criteria = $this->criteriaSearch();
            $criteria->group = "tglpenjualan, penjualanresep_id, jenispenjualan";
            $criteria->select = $criteria->group.", sum(hargajual_oa) AS hargajual_oa, sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa * qty_oa) AS harganetto_oa, sum(hpp) AS hpp";
//            $criteria->addCondition('returresep_id = NULL'); untuk mendapatkan hasil null tidak bisa dengan = / == tapi menggunakan is , maka dari itu hppnya jadi 0
            $criteria->addCondition('returresep_id is null');
            $criteria->order = $criteria->group;
            
            if($sum){
                $hasils = $this->model()->findAll($criteria);
                foreach($hasils AS $i => $value){
                    $hasil += $value->$kolom;
                }
            }else{
                $criteria->addCondition("penjualanresep_id = '".$this->penjualanresep_id."'");
                $hasil = isset($this->model()->find($criteria)->$kolom)?$this->model()->find($criteria)->$kolom:0;
            }
            return $hasil;
        }

        /**
         * searchTablePendapatanObatAlkes digunakan di farmasiApotek/LaporanFarmasi/LaporanPendapatanObatAlkes
         * @param type $limit
         * @return \CActiveDataProvider
         */
        public function searchTablePendapatanObatAlkes($limit = true){
            $criteria = $this->criteriaSearch();
            $criteria->group = "obatalkes_id, obatalkes_kode, obatalkes_nama, obatalkes_kategori, obatalkes_golongan, jenisobatalkes_id, jenisobatalkes_nama";
            $criteria->select = $criteria->group.", sum(qty_oa) AS qty_oa, sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa * qty_oa) AS harganetto_oa, sum(hpp * qty_oa) AS hpp";
            // $criteria->order = "jenisobatalkes_id, obatalkes_kode, obatalkes_nama";
            $pagination = array('pageSize'=>10);
            if(!$limit){
                $criteria->limit = -1;
                $pagination = false;
            }
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>$pagination,
            ));
        }
        /**
         * menampilkan data retur per kolom
         * @param type $kolom
         * @return type
         */

        public function getOaJual($kolom = "", $sum = false){
            $hasil = 0;
            $format = new MyFormatter;
            if(isset($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']) && isset($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir'])){
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
            }
            $criteria = $this->criteriaSearch();
            $criteria->group = "obatalkes_id, obatalkes_kode, obatalkes_nama, obatalkes_kategori, obatalkes_golongan, jenisobatalkes_id, jenisobatalkes_nama, returresep_id";
            $criteria->select = $criteria->group.", sum(qty_oa) AS qty_oa, sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa * qty_oa) AS harganetto_oa, sum(hpp * qty_oa) AS hpp";
            // $criteria->order = "jenisobatalkes_id, obatalkes_kode, obatalkes_nama";
            if($sum){
                $hasils = $this->model()->findAll($criteria);
                foreach($hasils AS $i => $value){
                    $hasil += $value->$kolom;
                }
            }else{
                $criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
                $hasil = $this->model()->find($criteria)->$kolom;
            }
            return $hasil;
            
        }
        /**
         * menampilkan data retur per kolom
         * @param type $kolom
         * @return type
         */
        public function getOaRetur($kolom = "", $sum = false){
            $hasil = 0;
            $format = new MyFormatter;
            if(isset($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']) && isset($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir'])){
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
            }
            $criteria = $this->criteriaSearch();
            $criteria->group = "obatalkes_id, obatalkes_kode, obatalkes_nama, obatalkes_kategori, obatalkes_golongan, jenisobatalkes_id, jenisobatalkes_nama, returresep_id";
            $criteria->select = $criteria->group.", sum(qty_oa) AS qty_oa, sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa * qty_oa) AS harganetto_oa";
             $criteria->addCondition('returresep_id IS NOT NULL');
            // $criteria->order = "jenisobatalkes_id, obatalkes_kode, obatalkes_nama";
            if($sum){ 
                $hasils = $this->model()->findAll($criteria);
                foreach($hasils AS $i => $value){
                    $hasil += $value->$kolom;
                }
            }else{ 
                $criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
                $hasil = isset($this->model()->find($criteria)->$kolom)?$this->model()->find($criteria)->$kolom:0;
            }
            return $hasil;
            
        }
        /**
         * menampilkan data total per kolom
         * @param type $kolom
         * @return type
         */
        public function getOaTotal($kolom = "", $sum = false){
            $hasil = 0;
            $format = new MyFormatter;
            if(isset($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']) && isset($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir'])){
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
            }
            $criteria = $this->criteriaSearch();
            $criteria->group = "obatalkes_id, obatalkes_kode, obatalkes_nama, obatalkes_kategori, obatalkes_golongan, jenisobatalkes_id, jenisobatalkes_nama, returresep_id";
            $criteria->select = $criteria->group.", sum(qty_oa) AS qty_oa, sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa * qty_oa) AS harganetto_oa, sum(hpp * qty_oa) AS hpp";
            $criteria->addCondition('returresep_id IS NULL');
            // $criteria->order = "jenisobatalkes_id, obatalkes_kode, obatalkes_nama";
            if($sum){
                $hasils = $this->model()->findAll($criteria);
                foreach($hasils AS $i => $value){
                    $hasil += $value->$kolom;
                }
            }else{
                $criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
                $hasil = isset($this->model()->find($criteria)->$kolom)?$this->model()->find($criteria)->$kolom:0;
            }
            return $hasil;
        }

        /**
         * searchTableTotalPendapatanFarmasi digunakan di farmasiApotek/LaporanFarmasi/LaporanPendapatanTotalFarmasi
         * @param type $limit
         * @return \CActiveDataProvider
         */
        public function searchTableTotalPendapatan()// jangan di hapus
        {
        $criteria=new CDbCriteria;
        $criteria->group = "jenisobatalkes_id, jenisobatalkes_nama, returresep_id";
        $criteria->select = $criteria->group.",sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa) AS harganetto_oa, sum(hpp * qty_oa) AS hpp";
        $criteria->order = "jenisobatalkes_id";
        $criteria->addBetweenCondition('date(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id);						
		}
		if(!empty($this->returresep_id)){
			$criteria->addCondition("returresep_id = ".$this->returresep_id);						
		}
        return $criteria;

        // return new CActiveDataProvider($this, array(
        //  'criteria'=>$criteria,
        // ));
        }

        public function searchTableTotalPendapatanFarmasi($limit = true){
            $criteria = $this->criteriaSearch();
            $criteria->group = "jenisobatalkes_id, jenisobatalkes_nama";
            // $criteria->group = "obatalkes_id, obatalkes_kode, obatalkes_nama, obatalkes_kategori, obatalkes_golongan, jenisobatalkes_id, jenisobatalkes_nama";
            $criteria->select = $criteria->group.", sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa * qty_oa) AS harganetto_oa, sum(hpp * qty_oa) AS hpp";
            // $criteria->order = "jenisobatalkes_id";
            // echo '<pre>';var_dump($criteria);die;
            $pagination = array('pageSize'=>10);
            if(!$limit){
                $criteria->limit = -1;
                $pagination = false;
            }
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>$pagination,
            ));
        }
        /**
         * menampilkan data retur per kolom
         * @param type $kolom
         * @return type
         */

        public function getTpJual($kolom = "", $sum = false){
            $hasil = 0;
            $format = new MyFormatter;
            if(isset($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']) && isset($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir'])){
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
            }
            $criteria = $this->criteriaSearch();
            $criteria->group = "jenisobatalkes_id, jenisobatalkes_nama";
            // $criteria->group = "obatalkes_id, obatalkes_kode, obatalkes_nama, obatalkes_kategori, obatalkes_golongan, jenisobatalkes_id, jenisobatalkes_nama";
            $criteria->select = $criteria->group.", sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa * qty_oa) AS harganetto_oa, sum(hpp * qty_oa) AS hpp";
            // $criteria->order = "jenisobatalkes_id";
            if($sum){
                $hasils = $this->model()->findAll($criteria);
                foreach($hasils AS $i => $value){
                    $hasil += $value->$kolom;
                }
            }else{
                $criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
                $hasil = $this->model()->find($criteria)->$kolom;
            }
            return $hasil;
            
        }
        /**
         * menampilkan data retur per kolom
         * @param type $kolom
         * @return type
         */
        public function getTpRetur($kolom = "", $sum = false, $jenisobatalkes_id=null){
            $hasil = 0;
            $format = new MyFormatter;
            if(isset($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']) && isset($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir'])){
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
            }
            $criteria = $this->criteriaSearch();
            $criteria->group = "jenisobatalkes_id, jenisobatalkes_nama";
            $criteria->select = $criteria->group.",sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa) AS harganetto_oa";
            $criteria->addCondition('returresep_id IS NOT NULL');
            // $criteria->order = "jenisobatalkes_id";
            if($sum){
                $hasils = $this->model()->findAll($criteria);
                foreach($hasils AS $i => $value){
                    $hasil += $value->$kolom;
                }
            }else{
                if ($jenisobatalkes_id !== null):
                    $criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
                endif;
                
//			RND-5946
//              $hasil = $this->model()->find($criteria);
                $hasil = isset($this->model()->find($criteria)->$kolom)?$this->model()->find($criteria)->$kolom:0;
            }
            return $hasil;
            
        }
        /**
         * menampilkan data total per kolom
         * @param type $kolom
         * @return type
         */
        public function getTpTotal($kolom = "", $sum = false,$jenisobatalkes_id=null){
            $hasil = 0;
            $format = new MyFormatter;
            if(isset($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']) && isset($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir'])){
                $this->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_awal']);
                $this->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpendapatanfarmasiV']['tgl_akhir']);
            }
            $criteria = $this->criteriaSearch();
            $criteria->group = "jenisobatalkes_id, jenisobatalkes_nama";
            $criteria->select = $criteria->group.",sum(hargajual_oa) AS hargajual_oa, sum(discount) AS discount, min(ppn_persen) AS ppn_persen, sum(harganetto_oa * qty_oa) AS harganetto_oa, sum(hpp * qty_oa) AS hpp";
            $criteria->addCondition('returresep_id IS NULL');
            // $criteria->order = "jenisobatalkes_id";
            if($sum){
                $hasils = $this->model()->findAll($criteria);
                foreach($hasils AS $i => $value){
                    $hasil += $value->$kolom;
                }
            }else{
                 if ($jenisobatalkes_id !== null):
                    $criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
                endif;
                
                $hasil = isset($this->model()->find($criteria)->$kolom)?$this->model()->find($criteria)->$kolom:0;
            }
            return $hasil;
        }

        // public function getNettoJumlah(){
        //     $nettojual = $this->getTpJual('harganetto_oa',true);
        //     return $nettojual
        // }        
}