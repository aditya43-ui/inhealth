<?php

class FALaporanpejulanresepdokterV extends LaporanpejulanresepdokterV {
	public $tgl_awal, $tgl_akhir;
        public $bln_awal, $bln_akhir;
        public $thn_awal, $thn_akhir;
        public $jns_periode, $jumlah, $data, $tick;
        public $dokter;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/*
	 * untuk data pencarian Laporan Jasa Services
	 */
	public function searchTabelServices(){
		
		$criteria=new CDbCriteria;
                $criteria->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
		//$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		//$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		//$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->rt)){
			$criteria->addCondition('rt = '.$this->rt);
		}
		if(!empty($this->rw)){
			$criteria->addCondition('rw = '.$this->rw);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		//$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->reseptur_id)){
			$criteria->addCondition('reseptur_id = '.$this->reseptur_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addInCondition('pegawai_id', $this->pegawai_id);
		}
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('totharganetto',$this->totharganetto);
		$criteria->compare('totalhargajual',$this->totalhargajual);
//		$criteria->compare('totaltarifservice',$this->totaltarifservice);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayakonseling',$this->biayakonseling);
		$criteria->compare('pembulatanharga',$this->pembulatanharga);
		$criteria->compare('jasadokterresep',$this->jasadokterresep);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);
		if(!empty($this->lamapelayanan)){
			$criteria->addCondition('lamapelayanan = '.$this->lamapelayanan);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition('penjualanresep_id = '.$this->penjualanresep_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
		}
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		if(!empty($this->oasudahbayar_id)){
			$criteria->addCondition('oasudahbayar_id = '.$this->oasudahbayar_id);
		}
		if(!empty($this->racikan_id)){
			$criteria->addCondition('racikan_id = '.$this->racikan_id);
		}
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		if(!empty($this->rke)){
			$criteria->addCondition('rke = '.$this->rke);
		}
		//$criteria->addCondition('totaltarifservice>=0');
		
		return  new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
		));
	}
	
	public function searchPrintServices(){

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->rt)){
			$criteria->addCondition('rt = '.$this->rt);
		}
		if(!empty($this->rw)){
			$criteria->addCondition('rw = '.$this->rw);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->reseptur_id)){
			$criteria->addCondition('reseptur_id = '.$this->reseptur_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('totharganetto',$this->totharganetto);
		$criteria->compare('totalhargajual',$this->totalhargajual);
//		$criteria->compare('totaltarifservice',$this->totaltarifservice);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayakonseling',$this->biayakonseling);
		$criteria->compare('pembulatanharga',$this->pembulatanharga);
		$criteria->compare('jasadokterresep',$this->jasadokterresep);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);
		if(!empty($this->lamapelayanan)){
			$criteria->addCondition('lamapelayanan = '.$this->lamapelayanan);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition('penjualanresep_id = '.$this->penjualanresep_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
		}
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		if(!empty($this->oasudahbayar_id)){
			$criteria->addCondition('oasudahbayar_id = '.$this->oasudahbayar_id);
		}
		if(!empty($this->racikan_id)){
			$criteria->addCondition('racikan_id = '.$this->racikan_id);
		}
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		if(!empty($this->rke)){
			$criteria->addCondition('rke = '.$this->rke);
		}
		//$criteria->addCondition('totaltarifservice>0');
		
		return  new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
		));
	}
        
        public function searchFrameGrafikJasaServices(){

		$criteria=new CDbCriteria;
                $criteria->join = " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id "
                                . " JOIN gelarbelakang_m gb ON gb.gelarbelakang_id = p.gelarbelakang_id ";//gelardepan +' '+t.nama_pegawai+' '+gb.gelarbelakang_nama
                $criteria->select = "count(t.pendaftaran_id) as jumlah, "
                        . "(CONCAT(t.gelardepan, ' ', t.nama_pegawai,' ',gb.gelarbelakang_nama) ) as data";
		$criteria->compare('LOWER(t.tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('LOWER(t.jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('LOWER(t.tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('t.pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->rt)){
			$criteria->addCondition('t.rt = '.$this->rt);
		}
		if(!empty($this->rw)){
			$criteria->addCondition('t.rw = '.$this->rw);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('t.pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.umur)',strtolower($this->umur),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('t.pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->reseptur_id)){
			$criteria->addCondition('t.reseptur_id = '.$this->reseptur_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addInCondition('t.pegawai_id', $this->pegawai_id);
		}
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('t.totharganetto',$this->totharganetto);
		$criteria->compare('t.totalhargajual',$this->totalhargajual);
//		$criteria->compare('totaltarifservice',$this->totaltarifservice);
		$criteria->compare('t.biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('t.biayakonseling',$this->biayakonseling);
		$criteria->compare('t.pembulatanharga',$this->pembulatanharga);
		$criteria->compare('t.jasadokterresep',$this->jasadokterresep);
		if(!empty($this->ruanganasal_nama)){                    
                    $criteria->addInCondition('ruanganasal_nama', $this->ruanganasal_nama);
                }else{
                   if (!empty($this->instalasiasal_nama)){
                       $criteria->addCondition("instalasiasal_nama = '".$this->instalasiasal_nama."' ");
                   }
                }
		$criteria->compare('t.discount',$this->discount);
		$criteria->compare('t.subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('t.subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('t.subsidirs',$this->subsidirs);
		$criteria->compare('t.iurbiaya',$this->iurbiaya);
		if(!empty($this->lamapelayanan)){
			$criteria->addCondition('t.lamapelayanan = '.$this->lamapelayanan);
		}
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition('t.penjualanresep_id = '.$this->penjualanresep_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(t.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(t.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(t.obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(t.obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(t.obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(t.satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(t.jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('t.sumberdana_id = '.$this->sumberdana_id);
		}
		$criteria->compare('LOWER(t.sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('t.qty_oa',$this->qty_oa);
		$criteria->compare('t.hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('t.hargajual_oa',$this->hargajual_oa);
		if(!empty($this->oasudahbayar_id)){
			$criteria->addCondition('t.oasudahbayar_id = '.$this->oasudahbayar_id);
		}
		if(!empty($this->racikan_id)){
			$criteria->addCondition('t.racikan_id = '.$this->racikan_id);
		}
		$criteria->compare('LOWER(t.r)',strtolower($this->r),true);
		if(!empty($this->rke)){
			$criteria->addCondition('t.rke = '.$this->rke);
		}
                $criteria->group = 't.gelardepan,t.nama_pegawai,gb.gelarbelakang_nama';
		//$criteria->addCondition('totaltarifservice>0');
		$criteria->order = "jumlah DESC";
		return  new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
		));
	}
	
	public function getNamaBin($pasien_id){
		$modNama = PasienM::model()->findByPk($pasien_id);
                if (empty($modNama)):
                    return '';
                else:    
                    return (isset($modNama->nama_bin)? $modNama->nama_pasien."/".$modNama->nama_bin : $modNama->nama_pasien);
                endif;
		
    }
}

