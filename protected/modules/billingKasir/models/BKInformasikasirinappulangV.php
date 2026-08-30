<?php
class BKInformasikasirinappulangV extends InformasikasirinappulangV
{
        public $ceklis, $tgl_awalAdmisi, $tgl_akhirAdmisi;
        public $tgl_awal,$tgl_akhir,$tgl_awal_admisi,$tgl_akhir_admisi;
        public $statusBayar;
        public $kamarruangan_id;
        public $rencana;
        public $pake_tanggal = false;
        public $kelastanggungan_id;
        public $kelastanggungan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganriV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRI()
	{

            $criteria=new CDbCriteria;
            
            /*
            if($this->ceklis==0){
                    $criteria->addBetweenCondition('DATE(t.tgladmisi)',$this->tgl_awal_admisi,$this->tgl_akhir_admisi);	       
            }else{
                    $criteria->addBetweenCondition('DATE(t.tglpulang)',$this->tgl_awal,$this->tgl_akhir);
                    
            }
             * 
             */
            if ($this->pake_tanggal) {
                $criteria->addBetweenCondition('DATE(t.tgladmisi)',$this->tgl_awal_admisi,$this->tgl_akhir_admisi);	       
            }
            
            $tb = "case when n.total_belum is null then 0 else n.total_belum end";
                $tt = "case when n.total_tindakan is null then 0 else n.total_tindakan end";
                $ob = "case when o.total_oa_belum is null then 0 else o.total_oa_belum end";
                $ot = "case when o.total_oa is null then 0 else o.total_oa end";
                
                $criteria->select = "t.*, ap.kelastanggunganasuransi_id as kelastanggungan_id, "
                        . "kt.kelaspelayanan_nama as kelastanggungan_nama, "
                        . "${tb} as total_belum,
                            ${tt} as total_tindakan,
                            ${ob} as total_oa_belum,
                            ${ot} as total_oa";
                
                $criteria->join = "
                left join pasienadmisi_t pa on pa.pendaftaran_id = t.pendaftaran_id 
                left join pendaftaran_t pd on pd.pendaftaran_id = t.pendaftaran_id 
                left join asuransipasien_m ap on ap.asuransipasien_id = pd.asuransipasien_id 
                left join kelaspelayanan_m kt on kt.kelaspelayanan_id = ap.kelastanggunganasuransi_id

                left join 
                (select 
                p.pendaftaran_id, 
                sum(case when p.tindakansudahbayar_id is null then 1 else 0 end) as total_belum,
                count(p.tindakanpelayanan_id) as total_tindakan

                from tindakanpelayanan_t p
                group by p.pendaftaran_id
                ) n on n.pendaftaran_id = t.pendaftaran_id

                left join 
                (select 
                p.pendaftaran_id, 
                sum(case when p.oasudahbayar_id is null then 1 else 0 end) as total_oa_belum,
                count(p.obatalkespasien_id) as total_oa

                from obatalkespasien_t p
                group by p.pendaftaran_id
                ) o on o.pendaftaran_id = t.pendaftaran_id
            ";
                
                
                
                
            /*   
            $criteria->addCondition("(((${tb}) <> 0 or (${ob}) <> 0))");
            */
            
            //$criteria->addCondition('t.pembayaranpelayanan_id IS NULL');
            $criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
            $criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
            $criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
            $criteria->compare('t.dokterpenerima_id',$this->dokterpenerima_id);
            $criteria->compare('t.no_identitas_pasien',$this->no_identitas_pasien);
            // $criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
            
            if (!empty($this->pegawai_id)) {
                $peg_id = $this->pegawai_id;
                $criteria->addCondition("(t.pegawai_id = ${peg_id} or t.dpjp2_id = ${peg_id} or t.dpjp3_id = ${peg_id})");
            }
            
            // $criteria->addCondition('pa.pasienpulang_id is null');
            
            // $criteria->compare('pa.kamarruangan_id', $this->kamarruangan_id);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition('t.pendaftaran_id = '.$this->pendaftaran_id);
			}
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            
            $criteria->compare('ap.kelastanggunganasuransi_id',$this->kelastanggungan_id);
            
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition('t.pasienadmisi_id = '.$this->pasienadmisi_id);
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
			}
            $criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
			}
            $criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition('t.kelaspelayanan_id = '.$this->kelaspelayanan_id);
			}
            $criteria->compare('LOWER(t.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			if(!empty($this->propinsi_id)){
				$criteria->addCondition('t.propinsi_id = '.$this->propinsi_id);
			}
			if(!empty($this->kabupaten_id)){
				$criteria->addCondition('t.kabupaten_id = '.$this->kabupaten_id);
			}
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition('t.kecamatan_id = '.$this->kecamatan_id);
			}
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition('t.kelurahan_id = '.$this->kelurahan_id);
			}
            $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			
            if(!empty($this->instalasi_id)){
				$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
			}
                        
			if(!empty($this->ruanganakhir_id)){
				$criteria->addCondition('t.ruangan_id = '.$this->ruanganakhir_id);
			}
            
                        if(!empty($this->rencana)){
                           if ($this->rencana == 1) { // belum rencana
                $criteria->addCondition('pa.rencanapulang is null');
            } else if ($this->rencana == 2) { // sudah rencana
                $criteria->addCondition('pa.rencanapulang is not null');
            } 
                        }else{// sudah rencana
                            $criteria->addCondition('pa.rencanapulang is not null');
                        }
            
            
            $criteria->addCondition("(
            (case when n.total_belum is null then 0 else n.total_belum end) <> 0
            or 
            (case when o.total_oa_belum is null then 0 else o.total_oa_belum end) <> 0
            )");
            
            $criteria->order = 't.tgladmisi DESC';
            
            
            //$criteria->compare('LOWER(statusperiksa)',strtolower(Params::STATUSPERIKSA_SUDAH_DIPERIKSA));

            /*
            if ($this->statusBayar == "BELUM LUNAS") {
                $criteria->addCondition("(${tb}) > 0 or (${ob}) > 0 or (${tt}) = 0");
            } else if ($this->statusBayar == "LUNAS") {
                $criteria->addCondition("(${tb}) = 0 and (${ob}) = 0 and (${tt}) > 0");
            }
             * 
             */
            
            
            // var_dump($criteria); die;
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function getCombineTglPendaftaran()
        {
            $this->tgladmisi = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($this->tgladmisi, 'yyyy-MM-dd hh:mm:ss'),'medium','medium');
            $this->tglpulang = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($this->tglpulang, 'yyyy-MM-dd hh:mm:ss'),'medium','medium');
            return $this->tgladmisi.' <br> '.$this->tglpulang;
        }        

	public function getRuanganItems($instalasi_id=null)
        {
            if($instalasi_id==null){
            return RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama', 'condition'=>'ruangan_aktif = true'));
            }else{
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id, 'ruangan_aktif'=>'true'),array('order'=>'ruangan_nama'));   
            }
        }
}