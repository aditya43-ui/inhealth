<?php

class BKRinciantagihanpasienpenunjangV extends RinciantagihanpasienpenunjangV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakankomponenT the static model class
	 */
        public $totaltagihan;
        public $is_sudahbayar;
		public $statusperiksa;
        public $instalasipenunjang_id;
        public $is_alkes;
        public $komponenunit_id;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function searchCriteria() {
        $criteria=new CDbCriteria;
            
            $str_bayar = '(case when t.tindakansudahbayar_id is null then true else false end)';
            
            $criteria->group = 't.tgl_pendaftaran,t.no_pendaftaran, t.pendaftaran_id, t.no_rekam_medik, t.namadepan, t.nama_pasien, t.nama_bin ,t.pendaftaran_id, t.carabayar_nama, t.penjamin_nama, ruanganpenunjang.instalasi_id, ruanganpenunjang.ruangan_nama, t.pembayaranpelayanan_id, t.instalasi_id, t.instalasi_nama, p.statusperiksa, '
                    . $str_bayar;
            $criteria->select = 't.tgl_pendaftaran,t.no_pendaftaran, t.pendaftaran_id, t.no_rekam_medik, t.namadepan, t.nama_pasien, t.nama_bin ,t.pendaftaran_id, t.carabayar_nama, t.penjamin_nama, ruanganpenunjang.instalasi_id as instalasipenunjang_id, ruanganpenunjang.ruangan_nama, t.pembayaranpelayanan_id, t.instalasi_id, t.instalasi_nama, p.statusperiksa, '
                    .' sum(case when t.tindakansudahbayar_id is null then t.tarif_tindakan else 0 end) as totaltagihan, '
                    . $str_bayar;
			$criteria->join = 'join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id = p.pendaftaran_id';
            
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('date(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
            }
            $criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);					
			}
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
			if(!empty($this->tindakanpelayanan_id)){
				$criteria->addCondition("t.tindakanpelayanan_id = ".$this->tindakanpelayanan_id);					
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id);					
			}
            $criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id);					
			}
            $criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
            $criteria->compare('t.tarif_tindakan',$this->tarif_tindakan);
            $criteria->compare('p.pegawai_id', $this->pegawai_id);
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition("t.jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);					
			}
			$criteria->compare('lower(p.statusperiksa)', strtolower($this->statusperiksa));
            
            $criteria->compare('t.ruanganpenunjang_id', $this->ruangan_id);
            $criteria->compare('r.instalasi_id', $this->instalasi_id);
            $criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
            
            
            
            $criteria->join = "join ruangan_m r on r.ruangan_id = t.ruangan_id "
                    . "left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id "
                    . "left join ruangan_m ruanganpenunjang on ruanganpenunjang.ruangan_id = t.ruanganpenunjang_id";
            
            $criteria->addInCondition("ruanganpenunjang.instalasi_id", array(Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_REHAB, Params::INSTALASI_ID_JZ, Params::INSTALASI_ID_UMUM_PENUNJANG));
            
            // $criteria->addCondition("ruanganpenunjang.instalasi_id not in (2, 3, 4, ".Params::INSTALASI_ID_HD.")");
            
            if ($this->statusBayar == 'LUNAS'){
                $criteria->addCondition($str_bayar.' = false');
            }else if ($this->statusBayar == 'BELUM LUNAS'){
                $criteria->addCondition($str_bayar.' = true');
            }
            
            
            // $criteria->compare('p.statusperiksa', $this->statusperiksa);
            $criteria->order = 't.tgl_pendaftaran desc';
            
            return $criteria;
    }
        
        public function searchRincianTagihan()
        {
            $criteria=$this->searchCriteria();
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function searchRincianTagihanNonAmbulans()
        {
            if(empty($this->statusperiksa)){
                $this->statusperiksa = Params::STATUSPERIKSA_SUDAH_DIPERIKSA;
            }
            $criteria=$this->searchCriteria();
            
            // $criteria->addCondition("t.ruangan_id = t.ruanganpenunjang_id");
            $criteria->addCondition("t.ruangan_id <> '".Params::RUANGAN_ID_AMBULANCE."'");
            // echo '<pre>';
            // print_r($criteria);
            // exit();
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function searchRincianTagihanAmbulans()
        {
            $criteria=$this->searchCriteria();
            
            $criteria->addCondition("t.ruangan_id = '".Params::RUANGAN_ID_AMBULANCE."'");
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        
        
        public function getNamaNamaBIN()
        {
            return $this->nama_pasien.' bin '.$this->nama_bin;
        }
        
        public function getCaraBayarPenjamin()
        {
                return $this->carabayar_nama.' / '.$this->penjamin_nama;
        }
        
        public function getAlamatRTRW()
        {
            return $this->alamat_pasien.'<br>'.$this->rt.' / '.$this->rw;
        }
        
        public function getNoRMNoPend(){
            return $this->no_rekam_medik.'<br/>'.$this->no_pendaftaran;
        }
        
        public function getTglMasukNoPenunjang(){
            return $this->tglmasukpenunjang.'<br/>'.PHP_EOL.$this->no_masukpenunjang;
        }
        
        public function getJenisKelaminUmur(){
            return $this->jeniskelamin.'<br/>'.$this->umur;
        }
        public function getInstalasiRuangan(){
            return $this->instalasiasal_nama.'<br/>'.$this->ruanganasal_nama;
        }
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
}

?>
