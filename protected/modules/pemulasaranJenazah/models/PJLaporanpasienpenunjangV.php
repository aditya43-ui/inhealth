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
class PJLaporanpasienpenunjangV extends LaporanpasienpenunjangV {

    public $tgl_awal,$tgl_akhir;
    public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
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

    /** fungsi untuk generate filter / criteria pada model untuk grafik
    * $model adalah model yang akan digunakan untuk grafik
    * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
    * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
    */
    public static function criteriaGrafik($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(pendaftaran_id) as jumlah';
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

        if (!isset($_GET['filter'])){
            $criteria->select .= ', propinsi_nama as '.$type;
            $criteria->group .= 'propinsi_nama';
        }

        if (count((array)$addCols) > 0){
            if (is_array($addCols)){
                foreach ($addCols as $i => $v){
                    $criteria->group .= ','.$v;
                    $criteria->select .= ','.$v.' as '.$i;
                }
            }            
        }

        return $criteria;
    }
    
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->functionCriteria();
        $criteria->select = 'count(pendaftaran_id) as jumlah';
         if ($_GET['tampilGrafik'] == 'kunjungan'){
            $criteria->select = 'count(pendaftaran_id) as jumlah, kunjungan as data';
            $criteria->group = 'kunjungan';
        }elseif ($_GET['tampilGrafik'] == 'carabayar'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, carabayar_nama as data';
            $criteria->group = 'carabayar_nama';
        }elseif ($_GET['tampilGrafik'] == 'jenispemeriksaan'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, jenispemeriksaanlab_nama as data';
            $criteria->group = 'jenispemeriksaanlab_nama';
        }elseif ($_GET['tampilGrafik'] == 'instalasiasal'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, instalasiasal_nama as data';
            $criteria->group = 'instalasiasal_nama';
        }elseif ($_GET['tampilGrafik'] == 'ruanganasal'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, ruanganasal_nama as data';
            $criteria->group = 'ruanganasal_nama';
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
                    'pagination' => false
                ));
    }

    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->kunjungan)){
            if (!is_array($this->kunjungan)){
               $this->kunjungan = 0;
           }else{
               $data = array();
               foreach(  $this->kunjungan as $i => $values ){

                   if( $values == "KUNJUNGAN ULANG"){
                       $data[]="KUNJUNGAN LAMA";
                   } else{
                       $data[]=$values;
                   }
               }                                            
               $criteria->addInCondition('kunjungan', $data);
           }
        }
        
        $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('pasien_id', $this->pasien_id);
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
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
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
        $criteria->compare('shift_id', $this->shift_id);
        if (!empty($this->ruanganasal_id)){
            if (is_array($this->ruanganasal_id)){
                $criteria->addInCondition(" ruanganasal_id ", $this->ruanganasal_id);
            }else{
                $criteria->addCondition(" ruanganasal_id = '".$this->ruanganasal_id."' ");
            }
        }
        $criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
        $criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->compare('LOWER(no_masukpenunjang)', strtolower($this->no_masukpenunjang), true);
        $criteria->compare('LOWER(tglmasukpenunjang)', strtolower($this->tglmasukpenunjang), true);
        $criteria->compare('LOWER(no_urutperiksa)', strtolower($this->no_urutperiksa), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('ruanganpenunj_id', Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruanganpenunj_nama)', strtolower($this->ruanganpenunj_nama), true);
        
        if (!empty($this->instalasiasal_id)){
            if (is_array($this->instalasiasal_id)){
                $criteria->addInCondition(" instalasiasal_id ", $this->instalasiasal_id);
            }else{
                $criteria->addCondition(" instalasiasal_id = '".$this->instalasiasal_id."' ");
            }
        }
        
        $criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
        $criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
        $criteria->compare('kunjungan', $this->kunjungan);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        $criteria->compare('pasienkirimkeunitlain_id', $this->pasienkirimkeunitlain_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('gelarbelakang_id', $this->gelarbelakang_id);
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        
        if (!empty($this->carabayar_id)){
            if (is_array($this->carabayar_id)){
                $criteria->addInCondition(" carabayar_id ", $this->carabayar_id);
            }else{
                $criteria->addCondition(" carabayar_id = '".$this->carabayar_id."' ");
            }
        }
        
        if (!empty($this->kabupaten_id)){
            if (is_array($this->kabupaten_id)){
                $criteria->addInCondition(" kabupaten_id ", $this->kabupaten_id);
            }else{
                $criteria->addCondition(" kabupaten_id = '".$this->kabupaten_id."' ");
            }
        }
        
        if (!empty($this->propinsi_id)){
            if (is_array($this->propinsi_id)){
                $criteria->addInCondition(" propinsi_id ", $this->propinsi_id);
            }else{
                $criteria->addCondition(" propinsi_id = '".$this->propinsi_id."' ");
            }
        }
        
        if (!empty($this->propinsi_id)){
            if (is_array($this->propinsi_id)){
                $criteria->addInCondition(" propinsi_id ", $this->propinsi_id);
            }else{
                $criteria->addCondition(" propinsi_id = '".$this->propinsi_id."' ");
            }
        }

        return $criteria;
    }    
    
    public function getNamaModel(){
        return __CLASS__;
    }
}

?>
