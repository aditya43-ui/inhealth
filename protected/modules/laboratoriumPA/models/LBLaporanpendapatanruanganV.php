<?php

class LBLaporanpendapatanruanganV extends LaporanpendapatanruanganV {
        public $bulan,$tahun,$tanggal,$pend_seharusnya, $pend_sebenarnya,$sisa,$no_masukpenunjang;
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $rujukan_id;
        public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();

        $criteria->select = 'count(pendaftaran_id) as jumlah, kelaspelayanan_nama as data';
        $criteria->group = 'kelaspelayanan_nama';
        if (!empty($this->carabayar_id)) {
            $criteria->select .= ', penjamin_nama as tick';
            $criteria->group .= ', penjamin_nama';
        } else {
            $criteria->select .= ', carabayar_nama as tick';
            $criteria->group .= ', carabayar_nama';
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
    
    public function functionCriteria(){
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
        $criteria->compare('anakke', $this->anakke);
        $criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
        $criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
        $criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
        $criteria->compare('LOWER(warga_negara)', strtolower($this->warga_negara), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(namaperusahaan)', strtolower($this->namaperusahaan), true);
        $criteria->compare('LOWER(tglselesaiperiksa)', strtolower($this->tglselesaiperiksa), true);
		if(!empty($this->penjamin_id)){
			if(is_array($this->penjamin_id)){
				$criteria->addInCondition('penjamin_id',$this->penjamin_id);
			}else{
				$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
			}
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if (!empty($this->kelaspelayanan_id)){
			if(is_array($this->kelaspelayanan_id)){
				$criteria->addInCondition('kelaspelayanan_id',$this->kelaspelayanan_id);
			}else{
				$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
			}
        }
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition('tipepaket_id = '.$this->tipepaket_id);
		}
        $criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
        $criteria->compare('tarif_rsakomodasi', $this->tarif_rsakomodasi);
        $criteria->compare('tarif_medis', $this->tarif_medis);
        $criteria->compare('tarif_paramedis', $this->tarif_paramedis);
        $criteria->compare('tarif_bhp', $this->tarif_bhp);
        $criteria->compare('tarif_satuan', $this->tarif_satuan);
        $criteria->compare('tarif_tindakan', $this->tarif_tindakan);
        //$criteria->compare('LOWER(satuantindakan)', strtolower($this->satuantindakan), true);
        $criteria->compare('qty_tindakan', $this->qty_tindakan);
        //$criteria->compare('cyto_tindakan', $this->cyto_tindakan);
        $criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
        $criteria->compare('discount_tindakan', $this->discount_tindakan);
        $criteria->compare('pembebasan_tindakan', $this->pembebasan_tindakan);
        $criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
        $criteria->compare('subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
        $criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
        $criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		if(!empty($this->tindakansudahbayar_id)){
			$criteria->addCondition('tindakansudahbayar_id = '.$this->tindakansudahbayar_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
        $criteria->compare('LOWER(shift_nama)', strtolower($this->shift_nama), true);
        $criteria->compare('LOWER(dokterpemeriksa1_id)', strtolower($this->dokterpemeriksa1_id), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(dokterpemeriksa2_id)', strtolower($this->dokterpemeriksa2_id), true);
        $criteria->compare('LOWER(dokterpendamping_id)', strtolower($this->dokterpendamping_id), true);
        $criteria->compare('LOWER(dokteranastesi_id)', strtolower($this->dokteranastesi_id), true);
        $criteria->compare('LOWER(dokterdelegasi_id)', strtolower($this->dokterdelegasi_id), true);
        $criteria->compare('LOWER(bidan_id)', strtolower($this->bidan_id), true);
        $criteria->compare('LOWER(suster_id)', strtolower($this->suster_id), true);
		if(!empty($this->perawat_id)){
			$criteria->addCondition('perawat_id = '.$this->perawat_id);
		}
        
        return $criteria;
    }
    
    public function searchPendapatan(){
         $cond = array(
                "DATE(tindakanpelayanan_t.tgl_tindakan) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                "pasienmasukpenunjang_t.ruangan_id = 18"
            );
        $query = "SELECT pasienmasukpenunjang_t.no_masukpenunjang, pasien_m.nama_pasien, 
                       asalrujukan_m.asalrujukan_id, asalrujukan_m.asalrujukan_nama,
                       sum(pembayaranpelayanan_t.totalbiayapelayanan) as pend_seharusnya,
                       sum(pembayaranpelayanan_t.totalbayartindakan) as pend_sebenarnya,
                       sum(pembayaranpelayanan_t.totalsisatagihan) as sisa
                   FROM tindakanpelayanan_t
                   JOIN pasienmasukpenunjang_t ON tindakanpelayanan_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                   JOIN tindakansudahbayar_t ON tindakanpelayanan_t.tindakansudahbayar_id = tindakansudahbayar_t.tindakansudahbayar_id
                   JOIN pembayaranpelayanan_t ON tindakansudahbayar_t.pembayaranpelayanan_id = pembayaranpelayanan_t.pembayaranpelayanan_id
                   JOIN pendaftaran_t ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                   JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id
                   LEFT JOIN rujukan_t ON pendaftaran_t.rujukan_id = rujukan_t.rujukan_id
                   LEFT JOIN asalrujukan_m ON rujukan_t.asalrujukan_id = asalrujukan_m.asalrujukan_id
                   JOIN ruangan_m ON tindakanpelayanan_t.ruangan_id = ruangan_m.ruangan_id
                   JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id
                   JOIN tipepaket_m ON tindakanpelayanan_t.tipepaket_id = tipepaket_m.tipepaket_id
                   JOIN shift_m ON tindakanpelayanan_t.shift_id = shift_m.shift_id
                   LEFT JOIN pegawai_m ON tindakanpelayanan_t.dokterpemeriksa1_id = pegawai_m.pegawai_id
                   ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."
                  GROUP BY pasienmasukpenunjang_t.no_masukpenunjang, pasien_m.nama_pasien,asalrujukan_m.asalrujukan_id, 
                           asalrujukan_m.asalrujukan_nama";
         $data = Yii::app()->db->createCommand($query)->queryAll();
            return new CArrayDataProvider($data);
    }
    public function searchPrintPendapatan(){
         $cond = array(
                "DATE(tindakanpelayanan_t.tgl_tindakan) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                "pasienmasukpenunjang_t.ruangan_id = 18"
            );
        $query = "SELECT pasienmasukpenunjang_t.no_masukpenunjang, pasien_m.nama_pasien, 
                       asalrujukan_m.asalrujukan_id, asalrujukan_m.asalrujukan_nama,
                       sum(pembayaranpelayanan_t.totalbiayapelayanan) as pend_seharusnya,
                       sum(pembayaranpelayanan_t.totalbayartindakan) as pend_sebenarnya,
                       sum(pembayaranpelayanan_t.totalsisatagihan) as sisa
                   FROM tindakanpelayanan_t
                   JOIN pasienmasukpenunjang_t ON tindakanpelayanan_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                   JOIN tindakansudahbayar_t ON tindakanpelayanan_t.tindakansudahbayar_id = tindakansudahbayar_t.tindakansudahbayar_id
                   JOIN pembayaranpelayanan_t ON tindakansudahbayar_t.pembayaranpelayanan_id = pembayaranpelayanan_t.pembayaranpelayanan_id
                   JOIN pendaftaran_t ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                   JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id
                   LEFT JOIN rujukan_t ON pendaftaran_t.rujukan_id = rujukan_t.rujukan_id
                   LEFT JOIN asalrujukan_m ON rujukan_t.asalrujukan_id = asalrujukan_m.asalrujukan_id
                   JOIN ruangan_m ON tindakanpelayanan_t.ruangan_id = ruangan_m.ruangan_id
                   JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id
                   JOIN tipepaket_m ON tindakanpelayanan_t.tipepaket_id = tipepaket_m.tipepaket_id
                   JOIN shift_m ON tindakanpelayanan_t.shift_id = shift_m.shift_id
                   LEFT JOIN pegawai_m ON tindakanpelayanan_t.dokterpemeriksa1_id = pegawai_m.pegawai_id
                   ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."
                  GROUP BY pasienmasukpenunjang_t.no_masukpenunjang, pasien_m.nama_pasien,asalrujukan_m.asalrujukan_id, 
                           asalrujukan_m.asalrujukan_nama";
         $data = Yii::app()->db->createCommand($query)->queryAll();
            return new CArrayDataProvider($data,array('pagination'=>false));
    }

    public function searchGrafikPendapatan()
        {
            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteriaPendapatan();
            $criteria->select = "count(t.pasien_id) AS jumlah, (CASE WHEN pe.rujukan_id IS NULL THEN 'Rumah Sakit' ELSE r.nama_perujuk END) AS data";
            $criteria->group = "pe.rujukan_id, r.nama_perujuk";
            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                )
            );
        }

    public function searchTableLaporan()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteriaPendapatan();
        $criteria->order = " t.no_pendaftaran ASC";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrintLaporan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteriaPendapatan();
        $criteria->order = " t.no_pendaftaran ASC";

        return new CActiveDataProvider($this, array(
                    'pagination' => false,
                    'criteria' => $criteria,
                ));
    }
    
    public function functionCriteriaPendapatan(){
        $criteria = new CDbCriteria();
        $criteria->join = " JOIN pendaftaran_t pe ON pe.pendaftaran_id = t.pendaftaran_id "
                        . " LEFT JOIN rujukan_t r ON r.rujukan_id = pe.rujukan_id ";
        $criteria->select = 'nama_pasien, namadepan, pe.rujukan_id,
                             sum(tarif_tindakan) as pend_seharusnya,
                             sum(iurbiaya_tindakan) as pend_sebenarnya,
                             sum(tarif_tindakan - iurbiaya_tindakan) as sisa, t.no_pendaftaran';
        $criteria->group = 'nama_pasien, t.no_pendaftaran, namadepan, pe.rujukan_id';        
        $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tgl_tindakan)', $this->tgl_awal, $this->tgl_akhir,true);
        $criteria->addCondition("t.no_pendaftaran not like '%LB%'");
                        
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
        $criteria->compare('anakke', $this->anakke);
        $criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
        $criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
        $criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
        $criteria->compare('LOWER(warga_negara)', strtolower($this->warga_negara), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(namaperusahaan)', strtolower($this->namaperusahaan), true);
        $criteria->compare('LOWER(tglselesaiperiksa)', strtolower($this->tglselesaiperiksa), true);
		if(!empty($this->penjamin_id)){
			if(is_array($this->penjamin_id)){
				$criteria->addInCondition('t.penjamin_id',$this->penjamin_id);
			}else{
				$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
			}
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition('tipepaket_id = '.$this->tipepaket_id);
		}
        $criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
        $criteria->compare('tarif_rsakomodasi', $this->tarif_rsakomodasi);
        $criteria->compare('tarif_medis', $this->tarif_medis);
        $criteria->compare('tarif_paramedis', $this->tarif_paramedis);
        $criteria->compare('tarif_bhp', $this->tarif_bhp);
        $criteria->compare('tarif_satuan', $this->tarif_satuan);
        $criteria->compare('tarif_tindakan', $this->tarif_tindakan);
        $criteria->compare('qty_tindakan', $this->qty_tindakan);
        $criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
        $criteria->compare('discount_tindakan', $this->discount_tindakan);
        $criteria->compare('pembebasan_tindakan', $this->pembebasan_tindakan);
        $criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
        $criteria->compare('subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
        $criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
        $criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		if(!empty($this->tindakansudahbayar_id)){
			$criteria->addCondition('tindakansudahbayar_id = '.$this->tindakansudahbayar_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
        $criteria->compare('LOWER(shift_nama)', strtolower($this->shift_nama), true);
        $criteria->compare('LOWER(dokterpemeriksa1_id)', strtolower($this->dokterpemeriksa1_id), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(dokterpemeriksa2_id)', strtolower($this->dokterpemeriksa2_id), true);
        $criteria->compare('LOWER(dokterpendamping_id)', strtolower($this->dokterpendamping_id), true);
        $criteria->compare('LOWER(dokteranastesi_id)', strtolower($this->dokteranastesi_id), true);
        $criteria->compare('LOWER(dokterdelegasi_id)', strtolower($this->dokterdelegasi_id), true);
        $criteria->compare('LOWER(bidan_id)', strtolower($this->bidan_id), true);
        $criteria->compare('LOWER(suster_id)', strtolower($this->suster_id), true);
		if(!empty($this->perawat_id)){
			$criteria->addCondition('perawat_id = '.$this->perawat_id);
		}
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));

        return $criteria;
    }
    
    public function functionCriteriaPendapatanLuar(){
        $criteria = new CDbCriteria();
        
         $criteria = new CDbCriteria();
        $criteria->join = " JOIN pendaftaran_t pe ON pe.pendaftaran_id = t.pendaftaran_id "
                        . " LEFT JOIN rujukan_t r ON r.rujukan_id = pe.rujukan_id ";
        $criteria->select = 'nama_pasien, namadepan, pe.rujukan_id,
                             sum(tarif_tindakan) as pend_seharusnya,
                             sum(iurbiaya_tindakan) as pend_sebenarnya,
                             sum(tarif_tindakan - iurbiaya_tindakan) as sisa, t.no_pendaftaran';
        $criteria->group = 'nama_pasien, t.no_pendaftaran, namadepan, pe.rujukan_id';           
        $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tgl_tindakan)', $this->tgl_awal, $this->tgl_akhir,true);
        $criteria->addCondition("t.no_pendaftaran like '%LB%'"); //pendapatan luar
             
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
        $criteria->compare('anakke', $this->anakke);
        $criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
        $criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
        $criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
        $criteria->compare('LOWER(warga_negara)', strtolower($this->warga_negara), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(namaperusahaan)', strtolower($this->namaperusahaan), true);
        $criteria->compare('LOWER(tglselesaiperiksa)', strtolower($this->tglselesaiperiksa), true);
		if(!empty($this->penjamin_id)){
			if(is_array($this->penjamin_id)){
				$criteria->addInCondition('t.penjamin_id',$this->penjamin_id);
			}else{
				$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
			}
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition('tipepaket_id = '.$this->tipepaket_id);
		}
        $criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
        $criteria->compare('tarif_rsakomodasi', $this->tarif_rsakomodasi);
        $criteria->compare('tarif_medis', $this->tarif_medis);
        $criteria->compare('tarif_paramedis', $this->tarif_paramedis);
        $criteria->compare('tarif_bhp', $this->tarif_bhp);
        $criteria->compare('tarif_satuan', $this->tarif_satuan);
        $criteria->compare('tarif_tindakan', $this->tarif_tindakan);
        $criteria->compare('qty_tindakan', $this->qty_tindakan);
        $criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
        $criteria->compare('discount_tindakan', $this->discount_tindakan);
        $criteria->compare('pembebasan_tindakan', $this->pembebasan_tindakan);
        $criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
        $criteria->compare('subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
        $criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
        $criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		if(!empty($this->tindakansudahbayar_id)){
			$criteria->addCondition('tindakansudahbayar_id = '.$this->tindakansudahbayar_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
        $criteria->compare('LOWER(shift_nama)', strtolower($this->shift_nama), true);
        $criteria->compare('LOWER(dokterpemeriksa1_id)', strtolower($this->dokterpemeriksa1_id), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(dokterpemeriksa2_id)', strtolower($this->dokterpemeriksa2_id), true);
        $criteria->compare('LOWER(dokterpendamping_id)', strtolower($this->dokterpendamping_id), true);
        $criteria->compare('LOWER(dokteranastesi_id)', strtolower($this->dokteranastesi_id), true);
        $criteria->compare('LOWER(dokterdelegasi_id)', strtolower($this->dokterdelegasi_id), true);
        $criteria->compare('LOWER(bidan_id)', strtolower($this->bidan_id), true);
        $criteria->compare('LOWER(suster_id)', strtolower($this->suster_id), true);
		if(!empty($this->perawat_id)){
			$criteria->addCondition('perawat_id = '.$this->perawat_id);
		}
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        
        return $criteria;
    }
    
    public function searchPendapatanLuar()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteriaPendapatanLuar();
        $criteria->order = " t.no_pendaftaran ASC";
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrintPendapatanLuar() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteriaPendapatanLuar();
        $criteria->order = " t.no_pendaftaran ASC";
        return new CActiveDataProvider($this, array(
                    'pagination' => false,
                    'criteria' => $criteria,
                ));
    }
    public function getNamaModel() {
        return __CLASS__;
    }
}

?>
