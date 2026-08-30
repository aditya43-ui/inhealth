<?php
class EKPendaftaranT extends PendaftaranT
{
    public $kunjunganperhari,$jeniskelamin,$pekerjaan_nama,$no_rekam_medik,$nama_pasien,$kamarruangan_nobed,$alamat_pasien,
			$tgl_pendaftaran_cari,$instalasi_nama,$ruangan_nama,$carabayar_nama,$jeniskasuspenyakit_nama,$kelaspelayanan_nama,
			$pendidikan_nama,$agama,$statusperkawinan,$penjamin_nama,$kamarruangan_nokamar,$tempat_lahir,$tanggal_lahir,
			$tahun, $namaLengkap;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getInstalasiResepturItems(){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('instalasi_id',array(
                        Params::INSTALASI_ID_RI, 
                        Params::INSTALASI_ID_RJ, 
                        Params::INSTALASI_ID_RD) 
                    );
            $criteria->order = 'instalasi_nama';
            $modInstalasis = InstalasiM::model()->findAll($criteria);
            if(count($modInstalasis) > 0)
                return $modInstalasis;
            else
                return null;
        }
        
        public function searchDialogKunjungan(){
            $criteria = new CDbCriteria();
            $criteria->with = array('pasien');
            $criteria->addCondition('t.pasienbatalperiksa_id is null');
            $criteria->compare('LOWER(pasien.jeniskelamin)',  strtolower($this->jeniskelamin),TRUE);
            $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->no_rekam_medik),TRUE);
            $criteria->compare('LOWER(t.no_pendaftaran)',  strtolower($this->no_pendaftaran),TRUE);
            $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->nama_pasien),TRUE);
            $criteria->compare('t.carabayar_id', $this->carabayar_id);
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
            
        }
        
        public function searchDialog() {
            $format = new MyFormatter();
		$criteria = new CDbCriteria();
		$criteria->select = 't.*,pasien.*,pekerjaan.*,pendidikan.*,ruangan.*,instalasi.*';
		$criteria->join = 'JOIN pasien_m AS pasien ON pasien.pasien_id = t.pasien_id 
						   JOIN instalasi_m AS instalasi ON instalasi.instalasi_id = t.instalasi_id 
						   JOIN ruangan_m AS ruangan ON ruangan.ruangan_id = t.ruangan_id 
						   JOIN pekerjaan_m AS pekerjaan ON pekerjaan.pekerjaan_id = pasien.pekerjaan_id
						   JOIN pendidikan_m AS pendidikan ON pendidikan.pendidikan_id = pasien.pendidikan_id';
//		$criteria->with = array('pasien', 'instalasi', 'ruangan');
//		$this->tgl_pendaftaran = empty($this->tgl_pendaftaran) ? date("Y-m-d") : $this->tgl_pendaftaran;
				$tgl_pendaftaran = $this->tgl_pendaftaran;
				$Tgl1 = (explode(" - ",$tgl_pendaftaran));

				//harus di format date dulu karena hasil dri widget tidak sama seperti format DB
				$Tgl1[0] = DateTime::createFromFormat('m/d/Y', $Tgl1[0]);
				$Tgl1[0] = $Tgl1[0]->format('Y-m-d');
				$Tgl1[1] = DateTime::createFromFormat('m/d/Y', $Tgl1[1]);
				$Tgl1[1] = $Tgl1[1]->format('Y-m-d');
				
				$criteria->addCondition("DATE(t.tgl_pendaftaran) BETWEEN '".$Tgl1[0]."' AND '".$Tgl1[1]."'");
		
		$criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(pasien.alamat_pasien)', strtolower($this->alamat_pasien), true);
		$criteria->compare('LOWER(pasien.jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(ruangan.ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(instalasi.instalasi_nama)', strtolower($this->instalasi_nama), true);
		if (!empty($this->instalasi_id)) {
			$criteria->addCondition("instalasi_id = " . $this->instalasi_id);
		}
		if (!empty($this->ruangan_id)) {
			$criteria->addCondition("ruangan_id = " . $this->ruangan_id);
		}
		$criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
//		$criteria->addCondition("DATE(t.tgl_pendaftaran) = '" .$this->tgl_pendaftaran . "'");
//		if (!empty($this->tgl_pendaftaran_cari))
//			$criteria->addBetweenCondition('t.tgl_pendaftaran', $format->formatDateTimeForDb($this->tgl_pendaftaran_cari) . " 00:00:00", $format->formatDateTimeForDb($this->tgl_pendaftaran_cari) . " 23:59:59");
		$criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
		$criteria->compare('LOWER(t.statuspasien)', strtolower($this->statuspasien), true);
//		$criteria->limit = 5;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
//			'pagination' => false,
		));
	}

}
