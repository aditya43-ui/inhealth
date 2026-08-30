<?php

class KUInformasiorderbatalbayaruangmukaV extends InformasiorderbatalbayaruangmukaV
{
		
    public $pegawai_id;
    public $status;
    public $tgl_awal, $tgl_akhir;
    
	/**
        * Returns the static model of the specified AR class.
        * @param string $className active record class name.
        * @return InfopasienmasukkamarV the static model class
        */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
        
        public function sisaPembayaran($jmlpembayaran, $jumlahuangmuka) {
			$sisaPembayaran = '';
			$sisa = 0;
			if ($jmlpembayaran > $jumlahuangmuka) {
				$sisa = $jmlpembayaran - $jumlahuangmuka;
				$sisaPembayaran = "" . number_format($sisa, 0, ",", ".");
			} elseif ($jmlpembayaran < $jumlahuangmuka) {
				$sisa = $jumlahuangmuka - $jmlpembayaran;
				$sisaPembayaran = "" . number_format($sisa, 0, ",", ".");
			} else {
				$sisaPembayaran = "0";
			}

			return $sisaPembayaran;
		}
		
		public function searchInformasi() {
			$prov = $this->search();
			
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $prov->criteria->addBetweenCondition('t.tglorderbatal::date', $this->tgl_awal, $this->tgl_akhir);
            }
			
			
			$prov->criteria->group = $prov->criteria->select =
				"t.pendaftaran_id, t.tgl_pendaftaran, t.tgluangmuka, t.nouangmuka, t.no_pendaftaran, t.no_rekam_medik, t.nama_pasien, "
				. "t.carabayar_nama, t.penjamin_nama, t.jumlahuangmuka, "
				. "t.pemakaianuangmuka, t.sisauangmuka, t.jmlpembayaran, "
				. "t.jumlahuangmuka, t.keteranganuangmuka, t.tglperjanjian, "
				. "t.keterangan_perjanjian, t.bayaruangmuka_id, t.instalasi_nama, t.ruangan_nama, "
                    . "t.jmlpembulatan, t.uangmukadipakai, t.carabayar_id, t.orderbataluangmuka_id, t.is_verifikasiorderbatal, t.tglorderbatal";
			
            $prov->criteria->join = 'left join bayaruangmuka_t b on b.bayaruangmuka_id = t.bayaruangmuka_id '
                . 'left join loginpemakai_k lp on lp.loginpemakai_id = b.create_loginpemakai_id '
                . 'left join pembatalanuangmuka_t bu on bu.bayaruangmuka_id = t.bayaruangmuka_id ';
            
            $prov->criteria->compare('lp.pegawai_id', $this->pegawai_id);
            
            if ($this->status == 2) {
                $prov->criteria->addCondition('t.is_verifikasiorderbatal = true');
            } else if ($this->status == 1) {
                $prov->criteria->addCondition('t.is_verifikasiorderbatal = false');
            }
            
            $prov->sort->defaultOrder = 't.tglorderbatal desc';
            
            
			return $prov;
		}
	
}