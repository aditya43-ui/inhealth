<?php

class FALaporanpenjualanobatV extends LaporanpenjualanobatV {

    public $statusbayar;
    public $labarugi;
    
    public $tot_total;
    public $tot_labarugi;
    public $hpp;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function search10Besar() {
        $criteria = new CDbCriteria();
        $criteria->select = 'obatalkes_kode, obatalkes_nama , hargajual_oa ,count(obatalkes_id) as jumlah';
        $criteria->group = 'obatalkes_kode, obatalkes_nama , hargajual_oa';
        $criteria->order = 'jumlah DESC';
        $criteria->limit = '10';
        return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false
        ));
    }
    
    public function searchTabelKategori() {
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);

        $criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
        $criteria->order = 'jenisobatalkes_id DESC';
        return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
        ));
    }
    
    public function searchPrintKategori(){
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
        $criteria->order = 'jenisobatalkes_id DESC';
        return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
        ));
    }
    
    public function searchGrafikKategori(){
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
        $criteria->select = 'count(noresep) as jumlah, jenisobatalkes_id as data';
        $criteria->group = 'jenisobatalkes_id';
        return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
        ));
    }
    
    /**
     * data provider untuk table
     */
    public function searchTable(){
        $criteria = $this->functionCriteria(true);
        
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    /**
     * data provider untuk print
     */
    public function searchPrint(){
        $criteria = $this->functionCriteria(true);
        
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
    /**
     * data provider untuk grafik
     */
    public function searchGrafik(){
        $criteria2 = new CDbCriteria;
        $criteria2->select = 'count(noresep) as jumlah,penjamin_nama as data,tglpenjualan,no_rekam_medik';
        $criteria2->group = 'tglpenjualan,penjamin_nama,no_rekam_medik';
            $criteria2->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
            if(isset($this->statusbayar)){
                if($this->statusbayar=='Sudah Bayar'){
                    $criteria2->addCondition('oasudahbayar_id IS NOT NULL');
                }else{
                    $criteria2->addCondition('oasudahbayar_id IS NULL');
                }
            }
        
        
        
        return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria2,
        ));
        
    }
    
    /**
     * method untuk criteria
     * @return CDbCriteria 
     */
    public function functionCriteria($params = null)
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            if (isset($params)){
                $criteria->select = 'tglpenjualan,tglresep,jenispenjualan,noresep,no_rekam_medik, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, umur, totalhargajual, totaltarifservice,biayaadministrasi, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya,carabayar_nama, penjamin_nama, instalasiasal_nama, ruanganasal_nama,oasudahbayar_id';
                $criteria->group = 'tglpenjualan,tglresep,jenispenjualan,noresep,no_rekam_medik, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, umur, totalhargajual, totaltarifservice,biayaadministrasi, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya,carabayar_nama, penjamin_nama, instalasiasal_nama, ruanganasal_nama,oasudahbayar_id';
            }else{
//            $criteria->select = array('tglpenjualan', 'tglresep','jenispenjualan','noresep','no_rekam_medik','no_pendaftaran', 'nama_pasien', 'nama_bin', 'jeniskelamin', 'umur', 'totalhargajual', 'totaltarifservice','biayaadministrasi', 'subsidiasuransi', 'subsidipemerintah', 'subsidirs', 'iurbiaya','carabayar_nama', 'penjamin_nama', 'instalasiasal_nama', 'ruanganasal_nama');
                $criteria->select = 'obatalkes_nama, tglpenjualan,tglresep,jenispenjualan,noresep,no_rekam_medik, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, umur, totalhargajual, totaltarifservice,biayaadministrasi, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya,carabayar_nama, penjamin_nama, instalasiasal_nama, ruanganasal_nama,oasudahbayar_id';
                $criteria->group = 'obatalkes_nama, tglpenjualan,tglresep,jenispenjualan,noresep,no_rekam_medik, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, umur, totalhargajual, totaltarifservice,biayaadministrasi, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya,carabayar_nama, penjamin_nama, instalasiasal_nama, ruanganasal_nama,oasudahbayar_id';
            }
            $criteria->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
            if(!empty($this->jenispenjualan)){
                $criteria->addInCondition("jenispenjualan", $this->jenispenjualan);
            }
            //$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
			if(!empty($this->carabayar_id)){
				$criteria->addInCondition("carabayar_id", $this->carabayar_id);						
			}
           // $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);            
//            (!is_array($this->penjamin_id)) ? $this->penjamin_id = 0 : '' ;
            //(empty($this->penjamin_id)) ? $this->penjamin_id = 0 : $this->penjamin_id;
            if(!empty($this->penjamin_id)){
                    $criteria->addInCondition("penjamin_id",$this->penjamin_id);						
            }
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
            //$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            
            if (!empty($this->instalasiasal_nama)){
                	$criteria->addInCondition("instalasiasal_nama", $this->instalasiasal_nama);						
            }
            
            if (!empty($this->ruanganasal_nama)){
                	$criteria->addInCondition("ruanganasal_nama", $this->ruanganasal_nama);						
            }
		//	$criteria->addInCondition("instalasiasal_nama", $this->instalasiasal_nama);						
			//$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
          //  (!is_array($this->ruanganasal_nama)) ? $this->ruanganasal_nama = 0 : '' ;
            
            //$this->ruanganasal_nama = (is_array($this->ruanganasal_nama) ? array_map('strtolower', $this->ruanganasal_nama) : strtolower($this->ruanganasal_nama));;
            //$criteria->compare('LOWER(ruanganasal_nama)',  $this->ruanganasal_nama);

            if(isset($this->statusbayar)){
                if($this->statusbayar=='Sudah Bayar'){
                    $criteria->addCondition('oasudahbayar_id IS NOT NULL');
                }elseif($this->statusbayar=='Belum Bayar'){
                    $criteria->addCondition('oasudahbayar_id IS NULL');
                }
            }
			
			if(!empty($this->nama_pasien)){
				$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			}
			
            return $criteria;
    }
    
    public function searchData()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->compare('noresep',$this->noresep);
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);						
			}
            $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
            $criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);						
			}
            $criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id);						
			}
            $criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
			if(!empty($this->sumberdana_id)){
				$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);						
			}
            $criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
            $criteria->compare('qty_oa',$this->qty_oa);
            $criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
            $criteria->compare('hargajual_oa',$this->hargajual_oa);
			if(!empty($this->oasudahbayar_id)){
				$criteria->addCondition("oasudahbayar_id = ".$this->oasudahbayar_id);						
			}
			if(!empty($this->racikan_id)){
				$criteria->addCondition("racikan_id = ".$this->racikan_id);						
			}
            $criteria->compare('LOWER(r)',strtolower($this->r),true);
            $criteria->compare('rke',$this->rke);
            $criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
    
    /**
     * Method untuk mendapatkan nama Model
     * @return String 
     */
    public function getNamaModel(){
        return __CLASS__;
    }
    
    public function getSubTotal(){
        return $this->qty_oa*$this->hargasatuan_oa;
    }
    
    /**
     * data provider untuk table penjualan obat
     */
    public function searchPenjualanObat(){
        $criteria = new CDbCriteria;
    //    var_dump($this->obatalkes_nama);
        $criteria->select = "*, (harganetto_oa * ((100 + t.persenppnjual) / 100)) as hpp, ((hargasatuan_oa * qty_oa) - discount_oa)- (harganetto_oa * qty_oa * ((100 + persenppnjual) / 100)) as labarugi";
        
        
        if (!empty($this->jenispenjualan)){
            $criteria->addInCondition("jenispenjualan", $this->jenispenjualan);
        }
        
        // if (!empty($_GET['FALaporanpenjualanobatV']['pegawai_id'])){
        if (!empty($this->pegawai_id)) {
            $criteria->addInCondition("pegawai_id", $this->pegawai_id);
            $criteria->addInCondition("jenispenjualan",array(Params::JENISPENJUALAN_DOKTER,Params::JENISPENJUALAN_RESEP));
        }
        
        $criteria->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->addCondition('oasudahbayar_id is not null');
		
		
		$criteria->compare(" LOWER(obatalkes_nama) ", strtolower($this->obatalkes_nama), true);
		$criteria->compare(" LOWER(obatalkes_kategori) ", strtolower($this->obatalkes_kategori), true);
		$criteria->compare(" LOWER(obatalkes_golongan) ", strtolower($this->obatalkes_golongan), true);
        
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    /**
     * data provider untuk print penjualan obat
     */
    public function searchPrintPenjualanObat(){
        $criteria = new CDbCriteria;
        
        $criteria->select = "t.*, (harganetto_oa * ((100 + t.persenppnjual) / 100)) as hpp, ((hargasatuan_oa * qty_oa) - discount_oa)- (harganetto_oa * qty_oa * ((100 + persenppnjual) / 100)) as labarugi";
        
        if (!empty($this->jenispenjualan)){
            $criteria->addInCondition("jenispenjualan", $this->jenispenjualan);
        }
        
        // if (!empty($_GET['FALaporanpenjualanobatV']['pegawai_id'])){
        if (!empty($this->pegawai_id)) {
            $criteria->addInCondition("pegawai_id", $this->pegawai_id);
            $criteria->addInCondition("jenispenjualan",array(Params::JENISPENJUALAN_DOKTER,Params::JENISPENJUALAN_RESEP));
        }
        
        $criteria->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->addCondition('oasudahbayar_id is not null');
		
		
		$criteria->compare(" LOWER(obatalkes_nama) ", strtolower($this->obatalkes_nama), true);
		$criteria->compare(" LOWER(obatalkes_kategori) ", strtolower($this->obatalkes_kategori), true);
		$criteria->compare(" LOWER(obatalkes_golongan) ", strtolower($this->obatalkes_golongan), true);
        $criteria->limit = -1;
        
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
    
    public function searchGrafikPenjualanObat(){
        $criteria = new CDbCriteria;
       $format = new MyFormatter();
        if (isset($_GET['FALaporanpenjualanobatV']['tgl_awal'])){
            $this->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_awal']);
        }
        if (isset($_GET['FALaporanpenjualanobatV']['tgl_akhir'])){
            $this->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_akhir']);
        }
        if (isset($_GET['FALaporanpenjualanobatV']['jenispenjualan'])){
            $this->jenispenjualan = $_GET['FALaporanpenjualanobatV']['jenispenjualan'];
        }
        
        if (!empty($this->jenispenjualan)){
            $criteria->addInCondition("jenispenjualan", $this->jenispenjualan);
        }
        
        if (!empty($_GET['FALaporanpenjualanobatV']['pegawai_id'])){
            $criteria->addInCondition("pegawai_id", $_GET['FALaporanpenjualanobatV']['pegawai_id']);
            $criteria->addInCondition("jenispenjualan",array(Params::JENISPENJUALAN_DOKTER,Params::JENISPENJUALAN_RESEP));
        }
        
        $criteria->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->addCondition('oasudahbayar_id is not null');
        $criteria2 = $criteria;
        $criteria2->select = 'count(noresep) as jumlah';
         if (!empty($this->carabayar_nama)){
            $criteria2->select .= ', penjamin_nama as data'; 
            $criteria2->group = 'penjamin_nama';
        }
        else if (!empty($this->instalasiasal_nama)){
            $criteria2->select .= ', ruanganasal_nama as data'; 
            $criteria2->group = 'ruanganasal_nama';
        }
        else{
            $criteria2->select .= ', carabayar_nama as data'; 
            $criteria2->group = 'carabayar_nama';
        }
        
        
        
        return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria2,
        ));
    }
    
    public function getPenjaminItems($carabayar_id=null)
    {
        if(!empty($carabayar_id))
                return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
        else
                return array();
                //return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
    }
}