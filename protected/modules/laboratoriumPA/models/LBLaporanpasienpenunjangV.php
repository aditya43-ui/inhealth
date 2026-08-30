<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ROLaporanpasienpenunjangV
 *
 * @author sujana
 */
class LBLaporanpasienpenunjangV extends LaporanpasienpenunjangV {

    public $bulan,$tahun,$tgl,$pasienmasukpenunjang_id,$jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public $tgl_awal, $tgl_akhir, $data, $jumlah, $tick;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        $criteria->order = 'tglmasukpenunjang ASC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchTableDBD() {
        
        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        $criteria->order = 'tglmasukpenunjang ASC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /** fungsi untuk generate filter / criteria pada model untuk grafik
    * $model adalah model yang akan digunakan untuk grafik
    * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
    * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
    */
    public static function criteriaGrafik($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(pendaftaran_id) as jumlah';
        
        
        if ($_GET['tampilGrafik'] == 'wilayah'){
            if (!empty($model->kelurahan_id)) {
                    $criteria->select .= ', kelurahan_nama as '.$type;
                    $criteria->group .= 'kelurahan_nama';
                } else if (!empty($model->kecamatan_id)) {
                    $criteria->select .= ', kelurahan_nama as '.$type;
                    $criteria->group .= 'kelurahan_nama';
                } else if (!empty($model->kabupaten_id)) {
                    $criteria->select .= ', kecamatan_nama as '.$type;
                    $criteria->group .= 'kecamatan_nama';
                } else if (!empty($model->propinsi_id)) {
                    $criteria->select .= ', kabupaten_nama as '.$type;
                    $criteria->group .= 'kabupaten_nama';
                } else {
                    $criteria->select .= ', propinsi_nama as '.$type;
                    $criteria->group .= 'propinsi_nama';
                }
        }elseif ($_GET['tampilGrafik'] == 'carabayar'){
            $criteria->select .= ', carabayar_nama as '.$type;
            $criteria->group .= 'carabayar_nama';
        }elseif ($_GET['tampilGrafik'] == 'instalasiasal'){
            $criteria->select .= ', instalasiasal_nama as '.$type;
            $criteria->group .= 'instalasiasal_nama';
        }elseif ($_GET['tampilGrafik'] == 'ruanganasal'){
            $criteria->select .= ', ruanganasal as '.$type;
            $criteria->group .= 'ruanganasal';
        }elseif ($_GET['tampilGrafik'] == 'kunjungan'){
            $criteria->select .= ', kunjungan as '.$type;
            $criteria->group .= 'kunjungan';
        }
        
        /*
        if (isset($_GET['filter'])){
            if ($_GET['filter'] == 'carabayar') {
                if (!empty($model->penjamin_id)) {
                    $criteria->select .= ', penjamin_nama as '.$type;
                    $criteria->group .= 'penjamin_nama';
                } else if (!empty($model->carabayar_id)) {
                    $criteria->select .= ', penjamin_nama as '.$type;
                    $criteria->group = 'penjamin_nama';
                } else {
                    $criteria->select .= ', carabayar_nama as '.$type;
                    $criteria->group = 'carabayar_nama';
                }
            } else if ($_GET['filter'] == 'wilayah') {
                if (!empty($model->kelurahan_id)) {
                    $criteria->select .= ', kelurahan_nama as '.$type;
                    $criteria->group .= 'kelurahan_nama';
                } else if (!empty($model->kecamatan_id)) {
                    $criteria->select .= ', kelurahan_nama as '.$type;
                    $criteria->group .= 'kelurahan_nama';
                } else if (!empty($model->kabupaten_id)) {
                    $criteria->select .= ', kecamatan_nama as '.$type;
                    $criteria->group .= 'kecamatan_nama';
                } else if (!empty($model->propinsi_id)) {
                    $criteria->select .= ', kabupaten_nama as '.$type;
                    $criteria->group .= 'kabupaten_nama';
                } else {
                    $criteria->select .= ', propinsi_nama as '.$type;
                    $criteria->group .= 'propinsi_nama';
                }
            }
        }
        

        if (!isset($_GET['filter'])){
            $criteria->select .= ', propinsi_nama as '.$type;
            $criteria->group .= 'propinsi_nama';
        }
         * */
         

        if (count($addCols) > 0){
            if (is_array($addCols)){
                foreach ($addCols as $i => $v){
                    $criteria->group .= ','.$v;
                    $criteria->select .= ','.$v.' as '.$i;
                }
            }            
        }

        $criteria->order = "jumlah DESC";
        
        return $criteria;
    }
    
//    public function searchGrafik() {
//        // Warning: Please modify the following code to remove attributes that
//        // should not be searched.
//		
//        $criteria = new CDbCriteria;
//        $criteria = $this->criteriaGrafik($this, 'tick');
////        if (!empty($criteria->group) &&(!empty($this->pilihanx))){
////            $criteria->group .=',';
////        }
//        $criteria->select .= ', kunjungan as data';
//        $criteria->group .= ', kunjungan';
//        $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
//        $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
//        $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
//		if(!empty($this->carabayar_id)){
//			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
//		}
//        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
//		if(!empty($this->penjamin_id)){
//			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
//		}
//        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
//		if(!empty($this->propinsi_id)){
//			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
//		}
//        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
//		if(!empty($this->kabupaten_id)){
//			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
//		}
//        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
//		if(!empty($this->kecamatan_id)){
//			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
//		}
//        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
//		if(!empty($this->kelurahan_id)){
//			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
//		}
//        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
//        $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));
//        if(!is_array($this->kunjungan)){
//            $this->kunjungan = 0;
//        }
//        $criteria->compare('kunjungan', $this->kunjungan);
//
//        return new CActiveDataProvider($this, array(
//                    'criteria' => $criteria,
//                ));
//    }
	
	public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        
        $criteria->select = "count(pendaftaran_id) as jumlah, kunjungan as data";
        $criteria->group = 'kunjungan';
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();
        $criteria->order = 'tglmasukpenunjang ASC';
		$criteria->limit=-1;
        return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
    }

    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $format = new MyFormatter();
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
        
        
            if(!is_array($this->kunjungan)){
                $this->kunjungan = 0;
            }else{
                $data = array();
				//$data = new CDbCriteria;
				//$data->
                foreach(  $this->kunjungan as $i => $values ){

                    if( $values == "KUNJUNGAN ULANG"){
                        $data[]="KUNJUNGAN LAMA";
                    } else{
                        $data[]=$values;
                    }
                }                                            
              //  var_dump($this->kunjungan);
                if (!empty($this->kunjungan)){
                    $criteria->addInCondition('kunjungan', $data);
                }

            }
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
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
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('byphone', $this->byphone);
        $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->ruanganasal_id)){
			$criteria->addInCondition('ruanganasal_id', $this->ruanganasal_id);
		}
        $criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->compare('LOWER(no_masukpenunjang)', strtolower($this->no_masukpenunjang), true);
        $criteria->compare('LOWER(tglmasukpenunjang)', strtolower($this->tglmasukpenunjang), true);
        $criteria->compare('LOWER(no_urutperiksa)', strtolower($this->no_urutperiksa), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruanganpenunj_nama)', strtolower($this->ruanganpenunj_nama), true);
		if(!empty($this->instalasiasal_id)){
			$criteria->addInCondition('instalasiasal_id', $this->instalasiasal_id);
		}
        $criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		if(!empty($this->pasienkirimkeunitlain_id)){
			$criteria->addCondition('pasienkirimkeunitlain_id = '.$this->pasienkirimkeunitlain_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		if(!empty($this->gelarbelakang_id)){
			$criteria->addCondition('gelarbelakang_id = '.$this->gelarbelakang_id);
		}
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
		if(!empty($this->carabayar_id)){
			$criteria->addInCondition('carabayar_id', $this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition('penjamin_id', $this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		
        return $criteria;
    }
    
    
//    public function searchPasienDBD()
//    {
//            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
//            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
//             $cond = array(
//                "DATE(pendaftaran_t.tgl_pendaftaran) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
//                "pasienmasukpenunjang_t.ruangan_id = 18"
//            );
//            $query = "select 
//                            pasien_m.no_rekam_medik,
//                            pasien_m.nama_pasien,
//                            pasien_m.jeniskelamin,
//                            pasien_m.alamat_pasien,
//                            kabupaten_m.kabupaten_nama,
//                            propinsi_m.propinsi_nama,
//                            pendaftaran_t.tgl_pendaftaran,
//                            pendaftaran_t.no_pendaftaran,
//                            pendaftaran_t.umur,
//                            pasienmasukpenunjang_t.no_masukpenunjang
//                    from tindakanpelayanan_t b
//                    LEFT JOIN pasienmasukpenunjang_t 
//                            ON b.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
//                    LEFT JOIN pendaftaran_t 
//                            ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
//                    LEFT JOIN pasien_m 
//                            ON pendaftaran_t.pasien_id = pasien_m.pasien_id
//                    LEFT JOIN detailhasilpemeriksaanlab_t 
//                            ON b.tindakanpelayanan_id = detailhasilpemeriksaanlab_t.tindakanpelayanan_id	
//                    LEFT JOIN hasilpemeriksaanlab_t 
//                            ON detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = hasilpemeriksaanlab_t.hasilpemeriksaanlab_id
//                    LEFT JOIN pemeriksaanlabdet_m 
//                            ON detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id = pemeriksaanlabdet_m.pemeriksaanlabdet_id
//                    LEFT JOIN pemeriksaanlab_m
//                            ON pemeriksaanlabdet_m.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id
//                    LEFT JOIN daftartindakan_m 
//                            ON daftartindakan_m.daftartindakan_id = b.daftartindakan_id 
//                    LEFT JOIN jenispemeriksaanlab_m 
//                            ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id
//                    LEFT JOIN kabupaten_m 
//                            ON pasien_m.kabupaten_id = kabupaten_m.kabupaten_id
//                    LEFT JOIN propinsi_m 
//                            ON pasien_m.propinsi_id = propinsi_m.propinsi_id
//                    ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."	
//                    GROUP BY 
//                            pasien_m.no_rekam_medik,
//                            pasien_m.nama_pasien,
//                            pasien_m.jeniskelamin,
//                            pasien_m.alamat_pasien,
//                            kabupaten_m.kabupaten_nama,
//                            propinsi_m.propinsi_nama,
//                            pendaftaran_t.tgl_pendaftaran,
//                            pendaftaran_t.no_pendaftaran,
//                            pendaftaran_t.umur,
//                            pasienmasukpenunjang_t.no_masukpenunjang";
//            $data = Yii::app()->db->createCommand($query)->queryAll();
//            return new CArrayDataProvider($data);
//    }
    public function searchPasienDBD()
    {
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
             $cond = array(
                "DATE(pendaftaran_t.tgl_pendaftaran) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                "pasienmasukpenunjang_t.ruangan_id =  '".Params::RUANGAN_ID_LAB_KLINIK."' "
            );
            $query = "select 
                            pasien_m.no_rekam_medik,
                            pasien_m.nama_pasien,
                            pasien_m.jeniskelamin,
                            pasien_m.alamat_pasien,
                            kabupaten_m.kabupaten_nama,
                            propinsi_m.propinsi_nama,
                            pendaftaran_t.tgl_pendaftaran,
                            pendaftaran_t.no_pendaftaran,
                            pendaftaran_t.umur,
                            pasienmasukpenunjang_t.no_masukpenunjang
                    from tindakanpelayanan_t b
                    LEFT JOIN pasienmasukpenunjang_t 
                            ON b.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                    LEFT JOIN pendaftaran_t 
                            ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                    LEFT JOIN pasien_m 
                            ON pendaftaran_t.pasien_id = pasien_m.pasien_id
                    LEFT JOIN detailhasilpemeriksaanlab_t 
                            ON b.tindakanpelayanan_id = detailhasilpemeriksaanlab_t.tindakanpelayanan_id	
                    LEFT JOIN hasilpemeriksaanlab_t 
                            ON detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = hasilpemeriksaanlab_t.hasilpemeriksaanlab_id
                    LEFT JOIN pemeriksaanlabdet_m 
                            ON detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id = pemeriksaanlabdet_m.pemeriksaanlabdet_id
                    LEFT JOIN pemeriksaanlab_m
                            ON pemeriksaanlabdet_m.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id
                    LEFT JOIN daftartindakan_m 
                            ON daftartindakan_m.daftartindakan_id = b.daftartindakan_id 
                    LEFT JOIN jenispemeriksaanlab_m 
                            ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id
                    LEFT JOIN kabupaten_m 
                            ON pasien_m.kabupaten_id = kabupaten_m.kabupaten_id
                    LEFT JOIN propinsi_m 
                            ON pasien_m.propinsi_id = propinsi_m.propinsi_id
                    ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."	
                    GROUP BY 
                            pasien_m.no_rekam_medik,
                            pasien_m.nama_pasien,
                            pasien_m.jeniskelamin,
                            pasien_m.alamat_pasien,
                            kabupaten_m.kabupaten_nama,
                            propinsi_m.propinsi_nama,
                            pendaftaran_t.tgl_pendaftaran,
                            pendaftaran_t.no_pendaftaran,
                            pendaftaran_t.umur,
                            pasienmasukpenunjang_t.no_masukpenunjang";
            $data = Yii::app()->db->createCommand($query)->queryAll();
            var_dump($query);
//            return new CArrayDataProvider($data);
            return new CActiveDataProvider($this, array(
                        'criteria' => $data,
                    ));
    }
    
    public function searchPrintPasienDBD()
    {
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
           $cond = array(
                "DATE(pendaftaran_t.tgl_pendaftaran) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                "pasienmasukpenunjang_t.ruangan_id = 18"
            );
            $query = "select 
                            pasien_m.no_rekam_medik,
                            pasien_m.nama_pasien,
                            pasien_m.jeniskelamin,
                            pasien_m.alamat_pasien,
                            kabupaten_m.kabupaten_nama,
                            propinsi_m.propinsi_nama,
                            pendaftaran_t.tgl_pendaftaran,
                            pendaftaran_t.no_pendaftaran,
                            pendaftaran_t.umur,
                            pasienmasukpenunjang_t.no_masukpenunjang
                    from tindakanpelayanan_t b
                    LEFT JOIN pasienmasukpenunjang_t 
                            ON b.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                    LEFT JOIN pendaftaran_t 
                            ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                    LEFT JOIN pasien_m 
                            ON pendaftaran_t.pasien_id = pasien_m.pasien_id
                    LEFT JOIN detailhasilpemeriksaanlab_t 
                            ON b.tindakanpelayanan_id = detailhasilpemeriksaanlab_t.tindakanpelayanan_id	
                    LEFT JOIN hasilpemeriksaanlab_t 
                            ON detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = hasilpemeriksaanlab_t.hasilpemeriksaanlab_id
                    LEFT JOIN pemeriksaanlabdet_m 
                            ON detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id = pemeriksaanlabdet_m.pemeriksaanlabdet_id
                    LEFT JOIN pemeriksaanlab_m
                            ON pemeriksaanlabdet_m.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id
                    LEFT JOIN daftartindakan_m 
                            ON daftartindakan_m.daftartindakan_id = b.daftartindakan_id 
                    LEFT JOIN jenispemeriksaanlab_m 
                            ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id
                    LEFT JOIN kabupaten_m 
                            ON pasien_m.kabupaten_id = kabupaten_m.kabupaten_id
                    LEFT JOIN propinsi_m 
                            ON pasien_m.propinsi_id = propinsi_m.propinsi_id
                    ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."	
                    GROUP BY 
                            pasien_m.no_rekam_medik,
                            pasien_m.nama_pasien,
                            pasien_m.jeniskelamin,
                            pasien_m.alamat_pasien,
                            kabupaten_m.kabupaten_nama,
                            propinsi_m.propinsi_nama,
                            pendaftaran_t.tgl_pendaftaran,
                            pendaftaran_t.no_pendaftaran,
                            pendaftaran_t.umur,
                            pasienmasukpenunjang_t.no_masukpenunjang";
            $data = Yii::app()->db->createCommand($query)->queryAll();
            return new CArrayDataProvider($data,array('pagination'=>false));
    }
    
    public function getNamaModel(){
        return __CLASS__;
    }
}

?>
