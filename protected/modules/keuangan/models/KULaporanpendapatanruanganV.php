<?php

class KULaporanpendapatanruanganV extends LaporanpendapatanruanganV {
        public $bulan,$tahun,$tanggal,$pend_seharusnya, $pend_sebenarnya,$sisa,$no_masukpenunjang;
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $rujukan_id;
		public $totalpendapatan;
		
        public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.       

        $criteria = $this->functionCriteria();
		$criteria->select = " t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama, t.kelaspelayanan_nama, t.ruangan_nama ,pp.tglpembayaran, pp.nopembayaran, pp.totalbayartindakan as totalpendapatan ";
		$criteria->group = " t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama, t.kelaspelayanan_nama, t.ruangan_nama ,pp.tglpembayaran, pp.nopembayaran, pp.totalbayartindakan";
		$criteria->order = "  pp.tglpembayaran ASC";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
					/*'sort'=>array(
						'defaultOrder'=>array(
						  'pp.tglpembayaran'=>true
						)
					  )*/
                ));
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        
        //$criteria = $this->functionCriteria();

        $criteria->select = 'sum(pp.totalbayartindakan) as jumlah, ruangan_nama as data';
        $criteria->group = 'ruangan_nama';
        $criteria->order = " jumlah DESC ";
		
		$model = new PembayaranpelayananT;

        return new CActiveDataProvider($model, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        

        $criteria = $this->functionCriteria();
		$criteria->select = " t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama, t.kelaspelayanan_nama, t.ruangan_nama ,pp.tglpembayaran, pp.nopembayaran, pp.totalbayartindakan as totalpendapatan ";
		$criteria->group = " t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama, t.kelaspelayanan_nama, t.ruangan_nama ,pp.tglpembayaran, pp.nopembayaran, pp.totalbayartindakan";
		$criteria->order = "  pp.tglpembayaran ASC";
		$criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
    
    public function functionCriteria(){
        $criteria = new CDbCriteria();
        $criteria->join = " JOIN tindakansudahbayar_t tsb ON tsb.tindakansudahbayar_id = t.tindakansudahbayar_id "
						. "	JOIN pembayaranpelayanan_t pp ON pp.pembayaranpelayanan_id = tsb.pembayaranpelayanan_id ";
        //$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);	
		$criteria->addBetweenCondition('DATE(pp.tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);	
		
		if (is_array($this->penjamin_id)){
            $criteria->addInCondition('t.penjamin_id', $this->penjamin_id);
        }else{
            //$criteria->addCondition('penjamin_id is null');
        }
		
		if (is_array($this->carabayar_id)){
            $criteria->addInCondition('t.carabayar_id', $this->carabayar_id);
        }else{
            //$criteria->addCondition('penjamin_id is null');
        }
        if (is_array($this->kelaspelayanan_id)){
            $criteria->addInCondition('t.kelaspelayanan_id', $this->kelaspelayanan_id);
        }else{
            //$criteria->addCondition('kelaspelayanan_id is null');
        }
		
		if (is_array($this->instalasi_id)){
            $criteria->addInCondition('t.instalasi_id', $this->instalasi_id);
        }else{
          $criteria->addInCondition('t.instalasi_id', Params::getArrayInstalasiBiayaPelayanan());
        }
		
		if (is_array($this->ruangan_id)){
            $criteria->addInCondition('t.ruangan_id', $this->ruangan_id);
        }else{
           
        }
		
		if (is_array($this->dokterpemeriksa1_id)){
            $criteria->addInCondition('t.dokterpemeriksa1_id', $this->dokterpemeriksa1_id);
        }else{
           
        }
		
        return $criteria;
    }
    
    public function getNamaModel() {
        return __CLASS__;
    }
}

?>
