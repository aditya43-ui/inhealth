<?php
class BKInformasipenjualanaresepV extends InformasipenjualanaresepV
{
        public $ruangan_nama;
        public $umur;
        public $penanggungjawab_id;
        public $nama_pj;
        public $pengantar;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipenjualanaresepV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * menampilkan pasien masuk penunjang group by pendaftaran
         */
        public function criteriaGroupByPenjualan(){
            $criteria = new CDbCriteria();
            $criteria->group = 't.pendaftaran_id,t.pasien_id, t.pasienpegawai_id,t.no_rekam_medik, t.namadepan, t.nama_pasien, t.nama_bin, t.jeniskelamin, t.tempat_lahir, t.tanggal_lahir, t.alamat_pasien, t.rt, t.rw, t.penjualanresep_id, t.jenispenjualan,'
                    . ' t.agama, t.golongandarah, t.photopasien, t.alamatemail, t.tglresep, t.noresep, t.carabayar_id, t.penjamin_id, t.ruanganasal_nama, t.carabayar_nama, t.penjamin_nama, t.tglpenjualan, t.instalasiasal_nama';
            $criteria->select = $criteria->group;
            return $criteria;
        }
                
        /**
         * menampilkan data kunjungan pasien 
         * model & criteria harus sama dengan PembayaranPenjualanApotekController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialog(){
            $format = new MyFormatter();
            $criteria = $this->criteriaGroupByPenjualan();
            $criteria->compare('LOWER(t.noresep)', strtolower($this->noresep), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
            $criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
            $criteria->compare('LOWER(t.penjamin_nama)', strtolower($this->penjamin_nama), true);
            $criteria->compare('LOWER(t.jenispenjualan)', strtolower($this->jenispenjualan), true);
            $criteria->addCondition("(true <> (lower(t.instalasiasal_nama) ilike '%rawat jalan%' and t.penjamin_id = 1))");
            $criteria->order = 't.tglpenjualan DESC';
            //$criteria->limit = 5;
            
            return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        //'pagination'=>false,
                ));
        }
        
        public function searchDialogPenjualanResep(){
            $format = new MyFormatter();
            $criteria = $this->criteriaGroupByPenjualan();
            //$criteria->join = "LEFT JOIN pembayaranpelayanan_t pp ON t.pembayaranpelayanan_id = pp.pembayaranpelayanan_id";
            $criteria->compare('LOWER(t.noresep)', strtolower($this->noresep), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
            if (!empty($this->tglpenjualan)){
                $criteria->addBetweenCondition("t.tglpenjualan",MyFormatter::formatDateTimeForDb($this->tglpenjualan).' 00:00:00', MyFormatter::formatDateTimeForDb($this->tglpenjualan).' 23:59:59');
            }
            //$criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
            //$criteria->compare('LOWER(t.penjamin_nama)', strtolower($this->penjamin_nama), true);
            if (!empty($this->carabayar_id))
            {
                $criteria->addCondition(" t.carabayar_id = '".$this->carabayar_id."' ");
            }
            $criteria->addCondition(" LOWER(t.jenispenjualan) = '".strtolower($this->jenispenjualan)."' ");
//            $criteria->compare('LOWER(t.jenispenjualan)', strtolower($this->jenispenjualan), true);
            $criteria->addCondition("(true <> (lower(t.instalasiasal_nama) ilike '%rawat jalan%' and t.penjamin_id = 1))");            
            //$criteria->addCondition(" ( pp.statusbayar = '".Params::STATUSBAYAR_BELUM_LUNAS."' OR pp.statusbayar IS NULL) ");
            $criteria->addCondition(" t.tandabuktibayar_id IS NULL ");
            $criteria->order = 't.tglpenjualan DESC';
            //$criteria->limit = 5;
            
            return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        //'pagination'=>false,
                ));
        }
        
        
        /**
         * menampilkan terakhir masuk penunjang
         */
        public function getPenunjangAkhir(){
            $criteria = new CdbCriteria();
            if(!empty($this->pendaftaran_id)){
                $criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);
                $criteria->order = "penjualanresep_id DESC";
                $criteria->limit = 1;
                $model = $this->find($criteria);
            }else if(!empty($this->pasienpegawai_id)){
                $criteria->addCondition("pasienpegawai_id = ".$this->pasienpegawai_id);
                $criteria->order = "penjualanresep_id DESC";
                $criteria->limit = 1;
                $model = $this->find($criteria);
            }
            if(!empty($this->penjualanresep_id)){
                $criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);
                $criteria->order = "penjualanresep_id DESC";
                $criteria->limit = 1;
                $model = $this->find($criteria);
            }
            if(isset($model)){
                return $model;
            }else{
                return new $this;
            }
            
        }
        
}