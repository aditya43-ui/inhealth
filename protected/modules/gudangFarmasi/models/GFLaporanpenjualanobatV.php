<?php
/**
 * perbaikan format Laporan
 * BMB-295
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * @subpackage models
 */
class GFLaporanpenjualanobatV extends LaporanpenjualanobatV {

    public $statusbayar;
	public $obatalkes_nama;
	public $jenisobatalkes_nama;
	public $jenisobatalkes_id;
	public $tot_qty1;
	public $tot_qty;
	public $obatalkes_kode;
	public $obatalkes_kategori;
	public $obatalkes_golongan;
	public $satuankecil_nama;
	public $tglpenjualan;	
	public $tahun;
	public $bulan;
	public $status;
	public $tabmenu;	

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
        $criteria->compare('obatalkes_kategori',$this->obatalkes_kategori);
        $criteria->order = 'obatalkes_kategori DESC';
        return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
        ));
    }
    
    public function searchPrintKategori(){
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('obatalkes_kategori',$this->obatalkes_kategori);
        $criteria->order = 'obatalkes_kategori DESC';
        return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
        ));
    }
    
    public function searchGrafikKategori(){
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('obatalkes_kategori',$this->obatalkes_kategori);
        $criteria->select = 'count(noresep) as jumlah, obatalkes_kategori as data';
        $criteria->group = 'obatalkes_kategori';
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
            $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            
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
        
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    /**
     * data provider untuk print penjualan obat
     */
    public function searchPrintPenjualanObat(){
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
	
	public function functionObatTerpakai(){
		 
		//$criteria = new CDbCriteria();		
		//$criteria->join = " RIGHT JOIN obatalkes_m o ON o.obatalkes_id = t.obatalkes_id "
		//				. "	LEFT JOIN jenisobatalkes_m jo ON jo.jenisobatalkes_id = o.jenisobatalkes_id "
		//				. "	LEFT JOIN satuankecil_m sk ON sk.satuankecil_id = o.satuankecil_id ";
		
		//search
		//$criteria->addBetweenCondition(" DATE(tglpenjualan) ", $this->tgl_awal, $this->tgl_akhir);
		
		$string = " (
SELECT o.obatalkes_id, o.obatalkes_nama, jo.jenisobatalkes_nama, jo.jenisobatalkes_id,o.obatalkes_golongan, o.obatalkes_kategori, o.obatalkes_kode, sk.satuankecil_nama, 
	(
		CASE WHEN 
			(SELECT sum(qty_oa) FROM laporanpenjualanobat_v lpo where lpo.obatalkes_id = o.obatalkes_id AND (DATE(lpo.tglpenjualan) BETWEEN '".date('Y-m-01', strtotime($this->tahun.'-'.$this->bulan.'-01'))."' AND '".date('Y-m-t', strtotime($this->tahun.'-'.$this->bulan.'-01'))."') ) IS NULL  
				THEN
					CASE WHEN (SELECT sum(qty_oa) FROM laporanpenjualanobat_v lpo where lpo.obatalkes_id = o.obatalkes_id AND (DATE(lpo.tglpenjualan) BETWEEN '".date('Y-m-01', strtotime($this->tahun.'-'.$this->bulan.'-01'.' -'.Params::OBAT_TIDAK_TERPAKAI_STUCK.' month'))."' AND '".date('Y-m-t', strtotime($this->tahun.'-'.$this->bulan.'-01'))."') ) IS NULL 
							THEN
								-1
							ELSE
								CASE WHEN 
											(SELECT sum(qty_oa) FROM laporanpenjualanobat_v lpo where lpo.obatalkes_id = o.obatalkes_id AND (DATE(lpo.tglpenjualan) BETWEEN '".date('Y-m-01', strtotime($this->tahun.'-'.$this->bulan.'-01'))."' AND '".date('Y-m-t', strtotime($this->tahun.'-'.$this->bulan.'-01'))."') ) IS NULL 
										THEN 0 
										ELSE (SELECT sum(qty_oa) FROM laporanpenjualanobat_v lpo where lpo.obatalkes_id = o.obatalkes_id AND (DATE(lpo.tglpenjualan) BETWEEN '".date('Y-m-01', strtotime($this->tahun.'-'.$this->bulan.'-01'))."' AND '".date('Y-m-t', strtotime($this->tahun.'-'.$this->bulan.'-01'))."') )
								END
							END
				ELSE (SELECT sum(qty_oa) FROM laporanpenjualanobat_v lpo where lpo.obatalkes_id = o.obatalkes_id AND (DATE(lpo.tglpenjualan) BETWEEN '".date('Y-m-01', strtotime($this->tahun.'-'.$this->bulan.'-01'))."' AND '".date('Y-m-t', strtotime($this->tahun.'-'.$this->bulan.'-01'))."') )
		END				
	) as tot_qty from laporanpenjualanobat_v t
RIGHT JOIN obatalkes_m o ON o.obatalkes_id = t.obatalkes_id 
LEFT JOIN jenisobatalkes_m jo ON jo.jenisobatalkes_id = t.jenisobatalkes_id 
LEFT JOIN satuankecil_m sk ON sk.satuankecil_id = o.satuankecil_id 
GROUP BY o.obatalkes_id, o.obatalkes_nama, jo.jenisobatalkes_nama, jo.jenisobatalkes_id, o.obatalkes_golongan, o.obatalkes_kategori, o.obatalkes_kode, sk.satuankecil_nama 
ORDER BY o.obatalkes_id ASC) ";
	
$condition = '';
				
if (!empty($this->jenisobatalkes_id)){
	$jns_array = '';
	$i = 1;
	foreach ($this->jenisobatalkes_id as $jns){
		if ($i == count((array)$this->jenisobatalkes_id)){
			$jns_array .= $jns;
		}else{
			$jns_array .= $jns.', ';
		}
		$i++;
	}
	$condition .= " dd.jenisobatalkes_id IN (".$jns_array.") ";
}

if (!empty($this->obatalkes_golongan)){
	$jns_array = '';
	$i = 1;
	foreach ($this->obatalkes_golongan as $jns){
		if ($i == count((array)$this->obatalkes_golongan)){
			$jns_array .= "'$jns'";
		}else{
			$jns_array .= "'$jns',";
		}
		$i++;
	}
	if (!empty($condition)){
		$condition .= " AND dd.obatalkes_golongan IN (".$jns_array.") ";
	}else{
		$condition .= " dd.obatalkes_golongan IN (".$jns_array.") ";
	}
}

if (!empty($this->obatalkes_kategori)){
	$jns_array = '';
	$i = 1;
	foreach ($this->obatalkes_kategori as $jns){
		if ($i == count((array)$this->obatalkes_kategori)){
			$jns_array .= "'$jns'";
		}else{
			$jns_array .= "'$jns',";
		}
		$i++;
	}
	if (!empty($condition)){
		$condition .= " AND dd.obatalkes_kategori IN (".$jns_array.") ";
	}else{
		$condition .= " dd.obatalkes_kategori IN (".$jns_array.") ";
	}
}



				
                $sql= " (select dd.*, "
					. "(CASE WHEN "
					. "		dd.tot_qty <= -1 THEN '".Params::STATUS_OBAT_TERPAKAI_STUCK."' "
					. " WHEN (dd.tot_qty >= 0 AND dd.tot_qty <= 3) THEN '".Params::STATUS_OBAT_TERPAKAI_SLOW."' "
					. " WHEN (dd.tot_qty >= 4 AND dd.tot_qty <= 19) THEN '".Params::STATUS_OBAT_TERPAKAI_MIDDLE."' "
					. " WHEN (dd.tot_qty >= 20 ) THEN '".Params::STATUS_OBAT_TERPAKAI_FAST."' "
					. " END) as status "
					. " from $string as dd  ".(!empty($condition)?'WHERE '.$condition.' ':'').") ";					
		
		return $sql;
	}
	
	public function searchObatTerpakai(){
		/*$criteria = $this->functionObatTerpakai();
		$criteria->select = " o.obatalkes_id, o.obatalkes_nama, jo.jenisobatalkes_nama, o.obatalkes_golongan, o.obatalkes_kategori, o.obatalkes_kode, sk.satuankecil_nama, "
			. "(SELECT sum(qty_oa) FROM laporanpenjualanobat_v lpo WHERE lpo.obatalkes_id = o.obatalkes_id AND  ( DATE(tglpenjualan) BETWEEN '".date('Y-m-01', strtotime($this->tahun.'-'.$this->bulan.'-01'))."' AND '".date('Y-m-t', strtotime($this->tahun.'-'.$this->bulan.'-01'))."' ) )  as tot_qty  ";
		$criteria->group = " o.obatalkes_id, o.obatalkes_nama, jo.jenisobatalkes_nama, o.obatalkes_golongan, o.obatalkes_kategori, o.obatalkes_kode, sk.satuankecil_nama ";
		$criteria->limit = 10;
		$criteria->order = " o.obatalkes_id ASC ";
		
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,                    
            ));*/
		$sql = $criteria = $this->functionObatTerpakai();
		
		$condition1 = '';
		if (!empty($this->status)){
			$jns_array = '';
			$i = 1;
			foreach ($this->status as $jns){
				if ($i == count((array)$this->status)){
					$jns_array .= "'$jns'";
				}else{
					$jns_array .= "'$jns',";
				}
				$i++;
			}
			if (!empty($condition)){
				$condition1 .= " AND cc.status IN (".$jns_array.") ";
			}else{
				$condition1 .= " cc.status IN (".$jns_array.") ";
			}
		}
		
				
				
				
				$sql2 = " (select * from $sql as cc ".(!empty($condition1)?'WHERE '.$condition1.' ':'')." ) ";
				
				$count = Yii::app()->db->createCommand(" select count(*) from $sql2 as bb ")->queryScalar();
              return  new CSqlDataProvider($sql2, array(
				  'totalItemCount'=>$count,
				  'keyField' => 'obatalkes_id',
				  'pagination'=>array(
						'pageSize'=>10,
					),

				));
				
			//	return new CActiveDataProvider($dataProvider, array(
              //      'criteria'=>$criteria,                    
            //));

			
	}
	
	public function searchPrintObatTerpakai(){
		
		//$criteria = $this->functionObatTerpakai();
		//$criteria->select = " o.obatalkes_nama, jo.jenisobatalkes_nama, o.obatalkes_golongan, o.obatalkes_kategori, o.obatalkes_kode, sk.satuankecil_nama, sum(t.qty_oa) as tot_qty  ";
		//$criteria->group = " o.obatalkes_nama, jo.jenisobatalkes_nama, o.obatalkes_golongan, o.obatalkes_kategori, o.obatalkes_kode, sk.satuankecil_nama ";
		//$criteria->limit = -1;
		
		//return new CActiveDataProvider($this, array(
          //          'criteria'=>$criteria,
            //        'pagination'=>false,
            //));
		
		$sql = $criteria = $this->functionObatTerpakai();
		
		$condition1 = '';
		if (!empty($this->status)){
			$jns_array = '';
			$i = 1;
			foreach ($this->status as $jns){
				if ($i == count((array)$this->status)){
					$jns_array .= "'$jns'";
				}else{
					$jns_array .= "'$jns',";
				}
				$i++;
			}
			if (!empty($condition)){
				$condition1 .= " AND cc.status IN (".$jns_array.") ";
			}else{
				$condition1 .= " cc.status IN (".$jns_array.") ";
			}
		}
		
				
				
				
				$sql2 = " (select * from $sql as cc ".(!empty($condition1)?'WHERE '.$condition1.' ':'')." ) ";
				
				$count = Yii::app()->db->createCommand(" select count(*) from $sql2 as bb ")->queryScalar();
              return  new CSqlDataProvider($sql2, array(
				  'totalItemCount'=>$count,
				  'keyField' => 'obatalkes_id',
				  'pagination'=>false

				));
	}
	
	public function searchGrafikObatTerpakai(){
		$sql = $criteria = $this->functionObatTerpakai();
		
		$condition1 = '';
		if (!empty($this->status)){
			$jns_array = '';
			$i = 1;
			foreach ($this->status as $jns){
				if ($i == count((array)$this->status)){
					$jns_array .= "'$jns'";
				}else{
					$jns_array .= "'$jns',";
				}
				$i++;
			}
			if (!empty($condition)){
				$condition1 .= " AND cc.status IN (".$jns_array.") ";
			}else{
				$condition1 .= " cc.status IN (".$jns_array.") ";
			}
		}
		
				
				
				
				$sql2 = " (select count(cc.obatalkes_id) as jumlah, status as data from $sql as cc ".(!empty($condition1)?'WHERE '.$condition1.' ':'')." group by data order by jumlah DESC )  ";
				
				$count = Yii::app()->db->createCommand(" select count(*) from $sql2 as bb ")->queryScalar();
              return  new CSqlDataProvider($sql2, array(				  
				   'totalItemCount'=>$count,
				  'keyField' => 'jumlah',
				  'pagination'=>array(
						'pageSize'=>$count,
					),

				));
			  
		//return new CActiveDataProvider($this, array(
          //          'criteria'=>$criteria,                    
            //));
	}
	
	
	public function functionRekapPakaiObat(){
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition("DATE(tglpenjualan)", date('Y-m-01', strtotime($this->tahun.'-'.$this->bulan.'-01')), date('Y-m-t', strtotime($this->tahun.'-'.$this->bulan.'-01')));
		if (!empty($this->jenisobatalkes_id)){
			$criteria->addInCondition("jenisobatalkes_id", $this->jenisobatalkes_id);
		}
		
		if (!empty($this->obatalkes_kategori)){
			$criteria->addInCondition("obatalkes_kategori", $this->obatalkes_kategori);
		}
		
		if (!empty($this->obatalkes_golongan)){
			$criteria->addInCondition("obatalkes_golongan", $this->obatalkes_golongan);
		}
		
		if (!empty($this->jenispenjualan)){
			$criteria->addInCondition("jenispenjualan", $this->jenispenjualan);
		}
		
		return $criteria;
	}
	
	public function searchRekapPakaiObat(){
		$criteria = $this->functionRekapPakaiObat();
		$criteria->select = " satuankecil_nama,jenispenjualan,noresep,DATE(tglpenjualan) as tglpenjualan,obatalkes_kode,obatalkes_nama, sum(qty_oa) as tot_qty ";
		$criteria->group = " satuankecil_nama,jenispenjualan,noresep,DATE(tglpenjualan),obatalkes_kode,obatalkes_nama";
		$criteria->limit = 10;
		$criteria->order = " DATE(tglpenjualan) ASC ";
		
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,                    
        ));
	}
	
	public function searchPrintsRekapPakaiObat(){
		$criteria = $this->functionRekapPakaiObat();
		$criteria->select = "  satuankecil_nama,jenispenjualan,noresep,DATE(tglpenjualan) as tglpenjualan,obatalkes_kode,obatalkes_nama, sum(qty_oa) as tot_qty ";
		$criteria->group = " satuankecil_nama,jenispenjualan,noresep,DATE(tglpenjualan),obatalkes_kode,obatalkes_nama";
		$criteria->limit = -1;
		$criteria->order = " DATE(tglpenjualan) ASC ";
		
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,                    
					'pagination' =>false
        ));
	}
	
	public function frameGrafikRekapPakaiObat(){
		$criteria = $this->functionRekapPakaiObat();
		$criteria->select = " count(obatalkes_id) as jumlah  ,jenispenjualan as data  ";
		$criteria->group = " data";		
		$criteria->order = " jumlah DESC ";
		
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,                    
					'pagination' =>false
        ));
	}
}