<?php
class FAInformasikasirinappulangV extends InformasikasirinappulangV
{
        public $ceklis, $tgl_awalAdmisi, $tgl_akhirAdmisi;
        public $tgl_awal,$tgl_akhir;
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
            $criteria->join = "left join pasienadmisi_t admisi on admisi.pasienadmisi_id = t.pasienadmisi_id";
            
            
            //if($this->ceklis==0){
            //        $criteria->addBetweenCondition('DATE(t.tglpulang)',$this->tgl_awal,$this->tgl_akhir);	
            //}else{
                    $criteria->addBetweenCondition('DATE(t.tgladmisi)',$this->tgl_awal,$this->tgl_akhir);	
            //}
            
            // $criteria->addCondition('t.pembayaranpelayanan_id IS NULL');
            $criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
            $criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
            $criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);						
			}
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition("t.pasienadmisi_id = ".$this->pasienadmisi_id);						
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id);						
			}
            $criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id);						
			}
            $criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("t.kelaspelayanan_id = ".$this->kelaspelayanan_id);						
			}
            $criteria->compare('LOWER(t.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			if(!empty($this->propinsi_id)){
				$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id);						
			}
			if(!empty($this->kabupaten_id)){
				$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id);						
			}
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("t.kecamatan_id = ".$this->kecamatan_id);						
			}
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("t.kelurahan_id = ".$this->kelurahan_id);						
			}
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);						
			}
            $criteria->compare('t.ruangan_id', $this->ruangan_id);
            $criteria->compare('admisi.pegawai_id', $this->pegawai_id);
            $criteria->compare('admisi.kamarruangan_id', $this->kamarruangan_id);
            $criteria->order = 't.tgladmisi DESC';
            //$criteria->compare('LOWER(statusperiksa)',strtolower(Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
            
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

        public function getFarmasiStatus($id){
            $modPendaftaran = PendaftaranT::model()->findByPK($id);
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            
            $true = 'APPROVE';
            $false = 'VERIFIKASI';
            if($modAdmisi->statusfarmasi == true){
                $status = '<button id="green" class="btn btn-danger" name="yt1">'.$true.'</button>';
            }else{
                $status = '<button id="red" class="btn btn-primary" name="yt1" onclick="ubahStatusFarmasi('.$id.')">'.$false.'</button>';
            }
        return $status;
    }
	
}