<?php

class BKObatalkesPasienT extends ObatalkespasienT
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AnamnesaT the static model class
     */
    public $tgl_awal,$tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode,$filter_tab, $nama_pasien, $no_rekam_medik, $no_pendaftaran, $tgl_pendaftaran, $obatalkes_nama, $penjamin_nama, $jeniskelamin, $umur, $jenisobatalkes_nama, $obatalkes_kategori, $ruangan_nama, $instalasi_nama,$tarif_satuan,$discount_tindakan,$qty_tindakan,$tarifcyto_tindakan,$iurbiaya_tindakan,$tgl_tindakan;
    public $is_pilihoa;
    public $subtotaloa = 0;
    public $biayalain = 0;
    public $qty_stok;
    public $total;
    public $stokobatalkes_id;
    public $satuankecil_nama;
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getNamaModel(){
        return __CLASS__;
    }
    
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
            'satuankecil'=>array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
            'daftartindakan'=>array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
            'penjualanresep'=>array(self::BELONGS_TO, 'PenjualanresepT', 'penjualanresep_id'), //untuk handling relasi dengan penjualan resep
            'oasudahbayar'=>array(self::BELONGS_TO, 'OasudahbayarT', 'oasudahbayar_id'), // handling relasi dengan oasudahbayar
            'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT','pendaftaran_id'),
            'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
            'penjamin'=>array(self::BELONGS_TO, 'PenjaminpasienM','penjamin_id'),
        );
    }
    
    public function searchTable()
    {
        $criteria = $this->functionCriteria(true);
        $criteria->with = array('pasien','pendaftaran', 'penjualanresep');
        $criteria->compare('pendaftaran.no_pendaftaran',$this->no_pendaftaran);
        $criteria->compare('pasien.no_rekam_medik',$this->no_rekam_medik);
        $criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
		if(is_array($this->penjamin_id)){
			$criteria->addInCondition("pendaftaran.penjamin_id",$this->penjamin_id);					
		}else{
//			$criteria->addCondition("pendaftaran.penjamin_id = ".$this->penjamin_id);
		}
        $criteria->addCondition('t.penjualanresep_id IS NOT NULL');
        $criteria->order = 'no_rekam_medik, no_pendaftaran';
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));        
    }
        
    public function printTableRekap()
    {
        $criteria = $this->functionCriteria();
        $criteria->with = array('pasien','pendaftaran', 'penjualanresep');
        $criteria->addBetweenCondition('tglpelayanan',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('pendaftaran.no_pendaftaran',$this->no_pendaftaran);
        $criteria->compare('pasien.no_rekam_medik',$this->no_rekam_medik);
        $criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
		if(!empty($this->penjamin_id)){
			if(is_array($this->penjamin_id)){
				$criteria->addInCondition('pendaftaran.penjamin_id',$this->penjamin_id);
			}else{
				//$criteria->addCondition("pendaftaran.penjamin_id = ".$this->penjamin_id);
			} 
		}   
        $criteria->addCondition('t.penjualanresep_id IS NOT NULL');
        $criteria->order = 'oa';        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));        
    }
    
    public function searchGroupTable()
    {
//        $criteria = $this->functionCriteria(true);
//        $criteria->with = array('pasien','pendaftaran', 'penjualanresep');
        $criteria = new CDbCriteria;
        $criteria->select = '
            pendaftaran_t.pendaftaran_id AS pendaftaran_id,
            pendaftaran_t.no_pendaftaran AS no_pendaftaran,
            pasien_m.no_rekam_medik AS no_rekam_medik,
            pasien_m.nama_pasien AS nama_pasien,
            ruangan_m.ruangan_nama AS ruangan_nama,
            instalasi_m.instalasi_nama,
            penjaminpasien_m.penjamin_nama AS penjamin_nama
        ';
        $criteria->join = '
            JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
            JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
            JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
            JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
        ';
		$criteria->addBetweenCondition('tglpelayanan',$this->tgl_awal,$this->tgl_akhir,true);
        $criteria->addCondition('t.penjualanresep_id IS NOT NULL');
        $criteria->compare('no_pendaftaran',$this->no_pendaftaran);
        $criteria->compare('no_rekam_medik',$this->no_rekam_medik);
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		if(!empty($this->penjamin_id)){
			if(is_array($this->penjamin_id)){
				$criteria->addInCondition('pendaftaran_t.penjamin_id',$this->penjamin_id);
			}else{
				$criteria->addCondition("pendaftaran_t.penjamin_id = ".$this->penjamin_id);
			} 
		}        
        $criteria->group = 'pendaftaran_t.pendaftaran_id, no_pendaftaran, no_rekam_medik, nama_pasien, ruangan_nama, instalasi_nama, penjamin_nama';
        $criteria->order = 'no_rekam_medik, no_pendaftaran';
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));          
    }
    
    public function searchPrintLaporan()
    {
//        $criteria = $this->functionCriteria(true);
//        $criteria->with = array('pasien','pendaftaran', 'penjualanresep');
        $criteria = new CDbCriteria;
        $criteria->select = '
            pendaftaran_t.pendaftaran_id AS pendaftaran_id,
            pendaftaran_t.no_pendaftaran AS no_pendaftaran,
            pasien_m.no_rekam_medik AS no_rekam_medik,
            pasien_m.nama_pasien AS nama_pasien,
            ruangan_m.ruangan_nama AS ruangan_nama,
            instalasi_m.instalasi_nama,
            penjaminpasien_m.penjamin_nama AS penjamin_nama
        ';
        $criteria->join = '
            JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
            JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
            JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
            JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
        ';
		$criteria->addBetweenCondition('tglpelayanan',$this->tgl_awal,$this->tgl_akhir,true);
        $criteria->compare('no_pendaftaran',$this->no_pendaftaran);
        $criteria->compare('no_rekam_medik',$this->no_rekam_medik);
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		if(!empty($this->penjamin_id)){
			if(is_array($this->penjamin_id)){
				$criteria->addInCondition('pendaftaran_t.penjamin_id',$this->penjamin_id);
			}else{
				$criteria->addCondition("pendaftaran_t.penjamin_id = ".$this->penjamin_id);
			} 
		}      
        $criteria->addCondition('t.penjualanresep_id IS NOT NULL');
        $criteria->group = 'pendaftaran_t.pendaftaran_id, no_pendaftaran, no_rekam_medik, nama_pasien, ruangan_nama, instalasi_nama, penjamin_nama';
        $criteria->order = 'no_rekam_medik, no_pendaftaran';
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));          
    }
    
    public function functionCriteria()
    {
            $criteria=new CDbCriteria;
            
            $criteria->addBetweenCondition('DATE(tglpelayanan)', $this->tgl_awal, $this->tgl_akhir);
            return $criteria;
    }
    
    public function getAsalBarang()
    {
        $record = SumberdanaM::model()->findByPk($this->sumberdana_id);
        return $record['sumberdana_nama'];
    }
    
    public function getJenisObat()
    {
        $criteria=new CDbCriteria;
        $criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
        $record = ObatalkesM::model()->find($criteria);
        return $record['jenisobatalkes']['jenisobatalkes_nama'];
    }
    
    public function getPoliklinik()
    {
        $criteria=new CDbCriteria;
        $criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
        $record = ObatalkesM::model()->find($criteria);
        return $record['jenisobatalkes']['jenisobatalkes_nama'];
    }  
    
    public function getPenjaminTagihan()
	{
		$modPenjamin = PenjaminpasienM::model()->findAllByAttributes(array('penjamin_id'=>$this->penjamin_id));
		return $modPenjamin;
	}
    
}