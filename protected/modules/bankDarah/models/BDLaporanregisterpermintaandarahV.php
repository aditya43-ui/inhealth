<?php
/**
 * Digunakan untuk memanggil view laporanregisterpermintaandarah_v, hanya untuk modul bankDarah
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage models  
 */
class BDLaporanregisterpermintaandarahV extends LaporanregisterpermintaandarahV {
    
    public  $tgl_awal, $tgl_akhir,$bln_awal, $bln_akhir,$thn_awal, $thn_akhir, $data, $jumlah, $tick, $jns_periode;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporanregisterpermintaandarahV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * Filter tabel laporan buku register
     * @return \CActiveDataProvider
     */
    public function searchTable() {

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /** 
     * Fungsi untuk generate filter / criteria pada frame grafik
     * $model adalah model yang akan digunakan untuk grafik
     * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
     * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
     * 
     * @param type $model
     * @param type $type
     * @param type $addCols
     * @return \CDbCriteria
     */
    public static function criteriaGrafik($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(pendaftaran_id) as jumlah';
        
        if ($_GET['tampilGrafik'] == 'wilayah'){
            if (!empty($model->kabupaten_id)) {
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
        }elseif ($_GET['tampilGrafik'] == 'instalasi'){
            $criteria->select .= ', instalasipemesan_nama as '.$type;
            $criteria->group = 'instalasipemesan_nama';
        }elseif ($_GET['tampilGrafik'] == 'ruangan'){
            $criteria->select .= ', ruanganpemesan_nama as '.$type;
            $criteria->group = 'ruanganpemesan_nama';
        }

        if (is_array($addCols) && count((array)$addCols) > 0){
            foreach ($addCols as $i => $v){
                $criteria->group .= ','.$v;
                $criteria->select .= ','.$v.' as '.$i;
            }      
        }

        return $criteria;
    }

    /**
     * Filtering frame grafik laporan buku register
     * @return \CActiveDataProvider
     */
    public function searchGrafik() {

        $criteria = $this->criteriaGrafik($this);
        $format = new MyFormatter();
        
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tglpermintaan)', $this->tgl_awal, $this->tgl_akhir);
        
        if(!empty($this->propinsi_id)){
            $criteria->addInCondition('propinsi_id',$this->propinsi_id);
        }
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        
        if(!empty($this->kabupaten_id)){
            $criteria->addInCondition('kabupaten_id', $this->kabupaten_id);
        }
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		
        if(!empty($this->carabayar_id)){
            $criteria->addInCondition('carabayar_id', $this->carabayar_id);
        }
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		
        if(!empty($this->penjamin_id)){
            $criteria->addInCondition('penjamin_id', $this->penjamin_id);
        }
        if(!empty($this->instalasipemesan_id)){
            $criteria->addInCondition('instalasipemesan_id', $this->instalasipemesan_id);
        }
        if(!empty($this->ruanganpemesan_id)){
            $criteria->addInCondition('ruanganpemesan_id', $this->ruanganpemesan_id);
        }
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->order = "jumlah DESC";
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Filtering cetak data laporan buku register
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Criteria pencarian untuk filter data tabel dan print laporan buku register
     * @return \CDbCriteria
     */
    protected function functionCriteria() {
        $criteria = new CDbCriteria();
        $format = new MyFormatter();
        
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tglpermintaan)', $this->tgl_awal, $this->tgl_akhir);
        
        if(!empty($this->permintaandarah_id)){
            $criteria->addInCondition('permintaandarah_id', $this->permintaandarah_id);
        }
        $criteria->compare('no_permintaandarah',$this->no_permintaandarah,true);
        $criteria->compare('jenispermintaan',$this->jenispermintaan,true);
        if(!empty($this->pegpemesan_id)){
            $criteria->addInCondition('pegpemesan_id', $this->pegpemesan_id);
        }
        $criteria->compare('gelardepan',$this->gelardepan,true);
        $criteria->compare('nama_pegawai',$this->nama_pegawai,true);
        if(!empty($this->pasien_id)){
            $criteria->addInCondition('pasien_id', $this->pasien_id);
        }
        $criteria->compare('gejala_transfusi',$this->gejala_transfusi,true);
        if(!empty($this->ruanganpemesan_id)){
            $criteria->addInCondition('ruanganpemesan_id', $this->ruanganpemesan_id);
        }
        $criteria->compare('ruanganpemesan_nama',$this->ruanganpemesan_nama,true);
        if(!empty($this->instalasipemesan_id)){
            $criteria->addInCondition('instalasipemesan_id', $this->instalasipemesan_id);
        }
        $criteria->compare('instalasipemesan_nama',$this->instalasipemesan_nama,true);
        $criteria->compare('jenisidentitas',$this->jenisidentitas,true);
        $criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
        $criteria->compare('jeniskelamin',$this->jeniskelamin,true);
        $criteria->compare('tempat_lahir',$this->tempat_lahir,true);
        $criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
        $criteria->compare('alamat_pasien',$this->alamat_pasien,true);
        $criteria->compare('rt',$this->rt);
        $criteria->compare('rw',$this->rw);
        $criteria->compare('statusperkawinan',$this->statusperkawinan,true);
        $criteria->compare('agama',$this->agama,true);
        $criteria->compare('golongandarah',$this->golongandarah,true);
        $criteria->compare('rhesus',$this->rhesus,true);
        $criteria->compare('no_mobile_pasien',$this->no_mobile_pasien,true);
        $criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
        $criteria->compare('namadepan',$this->namadepan,true);
        $criteria->compare('nama_pasien',$this->nama_pasien,true);
        $criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
        if(!empty($this->propinsi_id)){
            $criteria->addInCondition('propinsi_id', $this->propinsi_id);
        }
        $criteria->compare('propinsi_nama',$this->propinsi_nama,true);
        if(!empty($this->kabupaten_id)){
            $criteria->addInCondition('kabupaten_id', $this->kabupaten_id);
        }
        $criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
        if(!empty($this->pendaftaran_id)){
            $criteria->addInCondition('pendaftaran_id', $this->pendaftaran_id);
        }
        $criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
        $criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
        $criteria->compare('statusperiksa',$this->statusperiksa,true);
        $criteria->compare('statuspasien',$this->statuspasien,true);
        $criteria->compare('kunjungan',$this->kunjungan,true);
        $criteria->compare('umur',$this->umur,true);
        $criteria->compare('tglselesaiperiksa',$this->tglselesaiperiksa,true);
        if(!empty($this->instalasikunjungan_id)){
            $criteria->addInCondition('instalasikunjungan_id', $this->instalasikunjungan_id);
        }
        $criteria->compare('instalasikunjungan_nama',$this->instalasikunjungan_nama,true);        
        if(!empty($this->ruangankunjunggan_id)){
            $criteria->addInCondition('ruangankunjunggan_id', $this->ruangankunjunggan_id);
        }
        $criteria->compare('ruangankunjunggan_nama',$this->ruangankunjunggan_nama,true);
        if(!empty($this->carabayar_id)){
            $criteria->addInCondition('carabayar_id', $this->carabayar_id);
        }
        $criteria->compare('carabayar_nama',$this->carabayar_nama,true);
        if(!empty($this->penjamin_id)){
            $criteria->addInCondition('penjamin_id', $this->penjamin_id);
        }
        $criteria->compare('penjamin_nama',$this->penjamin_nama,true);
        $criteria->compare('tglpenyiapandarah',$this->tglpenyiapandarah,true);
        $criteria->compare('lamapenyiapan_detik',$this->lamapenyiapan_detik);
        $criteria->compare('ket_penyiapan',$this->ket_penyiapan,true);
        $criteria->order = "tglpermintaan ASC";
        return $criteria;
    }

}

?>
