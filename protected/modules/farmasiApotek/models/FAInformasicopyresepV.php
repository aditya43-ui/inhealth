<?php
class FAInformasicopyresepV extends InformasicopyresepV
{
        public $tglpenjualan,$jenispenjualan,$penjualanresep_id;
        public $pasienpegawai_id,$nama_pegawai;
        public $jeniskelamin,$nama_pasien,$alamat_pasien,$pasien_id;
        public $tglcopy,$keterangancopy;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchCopyResep()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select='pj.penjualanresep_id,pj.tglpenjualan,r.noresep,r.tglreseptur,pj.jenispenjualan,pj.pegawai_id,ps.nama_pasien,
						   ps.jeniskelamin,pd.umur,ps.pasien_id,ps.alamat_pasien,pg.nama_pegawai,t.tglcopy,t.keterangancopy';
		$criteria->addBetweenCondition('DATE(t.tglreseptur)',$this->tgl_awal,$this->tgl_akhir,true);
				
		if(!empty($this->copyresep_id)){
			$criteria->addCondition("copyresep_id = ".$this->copyresep_id);						
		}
		$criteria->compare('LOWER(keterangancopy)',strtolower($this->keterangancopy),true);
		$criteria->compare('jmlcopy',$this->jmlcopy);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);						
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);						
		}
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);						
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);						
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);						
		}
		if(!empty($this->kelompokumur_id)){
			$criteria->addCondition("kelompokumur_id = ".$this->kelompokumur_id);						
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id);						
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);						
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);						
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);						
		}
		$criteria->compare('LOWER(r.noresep)',strtolower($this->noresep),true);
		if(!empty($this->ruanganreseptur_id)){
			$criteria->addCondition("ruanganreseptur_id = ".$this->ruanganreseptur_id);						
		}
		$criteria->compare('LOWER(fileresep)',strtolower($this->fileresep),true);
		if(!empty($this->resepturdetail_id)){
			$criteria->addCondition("resepturdetail_id = ".$this->resepturdetail_id);						
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);						
		}
		if(!empty($this->racikan_id)){
			$criteria->addCondition("racikan_id = ".$this->racikan_id);						
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);						
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);						
		}
		if(!empty($this->reseptur_id)){
			$criteria->addCondition("reseptur_id = ".$this->reseptur_id);						
		}
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('permintaan_reseptur',$this->permintaan_reseptur);
		$criteria->compare('jmlkemasan_reseptur',$this->jmlkemasan_reseptur);
		$criteria->compare('kekuatan_reseptur',$this->kekuatan_reseptur);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('qty_obat',$this->qty_obat);
		$criteria->compare('hargasatuan_reseptur',$this->hargasatuan_reseptur);
		$criteria->compare('LOWER(signa_reseptur)',strtolower($this->signa_reseptur),true);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('hargajual',$this->hargajual);
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);						
		}
                $criteria->join = 'LEFT JOIN penjualanresep_t as pj ON t.penjualanresep_id = pj.penjualanresep_id
                                   LEFT JOIN reseptur_t as r ON t.reseptur_id = r.reseptur_id
                                   LEFT JOIN resepturdetail_t as rd ON t.resepturdetail_id = rd.resepturdetail_id
                                   LEFT JOIN pasien_m as ps ON t.pasien_id = ps.pasien_id
                                   LEFT JOIN pendaftaran_t as pd ON t.pendaftaran_id = pd.pendaftaran_id
                                   LEFT JOIN pegawai_m as pg ON pj.pegawai_id = pg.pegawai_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getNamaPegawai($pegawai_id)
        {
            $dokter = PegawaiM::model()->findByAttributes(
                array('pegawai_id'=>$pegawai_id)
            );
            return $dokter->nama_pegawai;
        }         

}

?>