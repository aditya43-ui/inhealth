<?php

/**
 * Class model tabel "returdarah_t" pada module Bank Darah
 * 
 * @author     Elham Budianto <elhambudianto1@gmail.com>
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package    application.modules.bankDarah
 * @subpackage models
 * @category   model
 */
class BDReturdarahT extends ReturdarahT {

    public $no_kantongdarah, $ruangan_tgl_penyerahan_text,
            $nama_pasien, $no_rekam_medik, $ruangan_nama,$gol_darah,$ruangan_id,$asaldarah,
            $jenis_komponen_darah, $golongan_darah, $pilih1, $pilih2, $pilih3, $petugas_penerima_nama, $tgl_awal, $tgl_akhir;
    public $asal_darah;
    public $jeniskantongdarah_id;
    public $komponendarah_id;
    public $rhesus;
    public $petugas_analisa_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param  string $className active record class name.
     * @return ReturdarahT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * Menampilkan informasi penerimaan darah kembali
     * @return \CActiveDataProvider
     */
    public function searchInformasi() {
        $criteria = new CDbCriteria;
        $criteria->select = 't.returdarah_id,t.kesimpulan,t.is_itd,t.is_ruangan,t.is_bdt,'
                . 't.petugas_analisa_id,t.tgl_retur_darah,penerima.nama_pegawai as petugas_penerima_nama,'
                . 'pasien.nama_pasien,pasien.no_rekam_medik,pasien.golongandarah,'
                    . 'kantong.no_kantongdarah,'
                    . 'pendonor.gol_darah,pendonor.rhesus,'
                    . 'komponen.singkatan_komp as jenis_komponen_darah,'
                    . 'uji.ujikompatibilitas_id,'
                    . 'ruangan.ruangan_nama,ruangan.ruangan_id';
        $criteria->join = ' LEFT JOIN pegawai_m as penerima ON penerima.pegawai_id = t.petugas_penerima_id '
                . ' LEFT JOIN ujikompatibilitas_t as uji ON t.ujikompatibilitas_id=uji.ujikompatibilitas_id '
                . ' LEFT JOIN stokkantongdarah_t as stok ON uji.stokkantongdarah_id=stok.stokkantongdarah_id '
                . ' LEFT JOIN kantongdarah_t as kantong ON stok.kantongdarah_id=kantong.kantongdarah_id '
                . ' LEFT JOIN komponendarah_m as komponen ON kantong.komponendarah_id=komponen.komponendarah_id '
                . ' LEFT JOIN pendonor_m as pendonor ON kantong.pendonor_id=pendonor.pendonor_id '
                . ' LEFT JOIN pasien_m as pasien ON uji.pasien_id = pasien.pasien_id '
                . ' LEFT JOIN pendaftaran_t as pendaftaran ON uji.pendaftaran_id = pendaftaran.pendaftaran_id '
                . ' LEFT JOIN ruangan_m as ruangan ON pendaftaran.ruangan_id = ruangan.ruangan_id ';
        $criteria->group = 't.returdarah_id,t.tgl_retur_darah,penerima.nama_pegawai,'
                . 'pasien.nama_pasien,pasien.no_rekam_medik,pasien.golongandarah,'
                    . 'kantong.no_kantongdarah,'
                    . 'pendonor.gol_darah,pendonor.rhesus,'
                    . 'komponen.singkatan_komp,'
                    . 'uji.ujikompatibilitas_id,'
                    . 'ruangan.ruangan_nama,ruangan.ruangan_id';
        $criteria->addBetweenCondition('DATE(t.tgl_retur_darah)', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->nama_pasien)){
            $criteria->compare("LOWER(pasien.nama_pasien)", strtolower($this->nama_pasien),true);
        }
        if(!empty($this->no_rekam_medik)){
            $criteria->compare("LOWER(pasien.no_rekam_medik)", strtolower($this->no_rekam_medik),true);
        }
        if(!empty($this->petugas_penerima_nama)){
            $criteria->compare("LOWER(penerima.nama_pegawai)", strtolower($this->petugas_penerima_nama),true);
        }
        if(!empty($this->ruangan_id)){
            $criteria->addCondition("ruangan.ruangan_id =".$this->ruangan_id);
        }
        if(!empty($this->no_kantongdarah)){
            $criteria->compare("LOWER(kantong.no_kantongdarah)", strtolower($this->no_kantongdarah),true);
        }
        if(!empty($this->jenis_komponen_darah)){
            $criteria->compare("LOWER(komponen.singkatan_komp)", strtolower($this->jenis_komponen_darah),true);
        }
        if(!empty($this->gol_darah)){
            $criteria->compare("LOWER(pendonor.gol_darah)", strtolower($this->gol_darah),true);
        }
        if(!empty($this->asaldarah)){
            if($this->asaldarah == 1){
                $criteria->addCondition("t.is_ruangan = true");
            }else if($this->asaldarah == 2){
                $criteria->addCondition("t.is_bdt = true");
            }else if($this->asaldarah == 3){
                $criteria->addCondition("t.is_itd = true");
            }
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

     /** Pencarian data retur darah yang belum dianalisa.
     * 
     * @return \CActiveDataProvider
     */
    public function searchReturKantongDarah() {
        $cr = new CDbCriteria();
        $cr->join = 'join ujikompatibilitas_t u on u.ujikompatibilitas_id = t.ujikompatibilitas_id '
            . 'join pasien_m p on p.pasien_id = u.pasien_id '
            . 'join stokkantongdarah_t s on s.stokkantongdarah_id = u.stokkantongdarah_id '
            . 'join kantongdarah_t kantong on s.kantongdarah_id = kantong.kantongdarah_id '
            . 'join komponendarah_m komponen on kantong.komponendarah_id = komponen.komponendarah_id '
            . 'join jeniskantongdarah_m jk on jk.jeniskantongdarah_id = s.jeniskantongdarah_id '
            . 'left join permintaandarahdet_t d on d.permintaandarahdet_id = u.permintaandarahdet_id '
            . 'left join permintaandarah_t pd on pd.permintaandarah_id = d.permintaandarah_id '
            . 'left join ruangan_m r on r.ruangan_id = pd.ruanganpemesan_id '
            . 'left join pegawai_m pg on pg.pegawai_id = t.petugas_penerima_id';
        $cr->select = 't.*, p.nama_pasien, p.no_rekam_medik, r.ruangan_nama, komponen.singkatan_komp as jenis_komponen_darah, '
            . 's.golongan_darah as golongan_darah, s.rhesus, u.nomorbarcode as no_kantongdarah';
        $cr->compare('lower(u.nomorbarcode)', strtolower($this->no_kantongdarah), true);
        $cr->compare('lower(nama_pasien)', strtolower($this->nama_pasien), true);
        $cr->compare('lower(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        //$cr->compare('jk.jeniskantongdarah_id', $this->jeniskantongdarah_id);
        if(!empty($this->komponendarah_id)){
            $cr->compare('komponen.komponendarah_id', $this->komponendarah_id);
        }
        $cr->addCondition("t.kesimpulan is null");
        
        return new CActiveDataProvider($this, array(
			'criteria'=>$cr,
		));
    }
    
    /**
     * Load data retur darah.
     * 
     * @param  mixed $json apakah hasil data array-nya di convert menjadi format json atau tidak.
     * @return mixed Data JSON/array.
     */
    public function jsonReturDarah($json = true) {
        $res = $this->attributes;
        $res['nama_pasien'] = $this->nama_pasien;
        $res['no_rekam_medik'] = $this->no_rekam_medik;
        $res['ruangan_nama'] = $this->ruangan_nama;
        $res['jenis_komponen_darah'] = $this->jenis_komponen_darah;
        $res['golongan_darah'] = $this->golongan_darah." / ".$this->rhesus;
        $res['no_kantongdarah'] = $this->no_kantongdarah;
        
        $res['asal_darah'] = "";
        if ($this->is_ruangan) {
            $res['asal_darah'] = "Ruangan".(empty($this->ruangan_tgl_penyerahan) ? "" : 
                (" - ".MyFormatter::formatDateTimeForUser($this->ruangan_tgl_penyerahan)));
        } else if ($this->is_bdt) {
            $res['asal_darah'] = "BDT".(empty($this->bdt_suhucoolbox) ? "" : (" - ".$this->bdt_suhucoolbox."&deg;"));
        } else if ($this->is_itd) {
            $res['asal_darah'] = "ITD";
        }
        
        $res['petugas_penerima_nama'] = "";
        if (!empty($this->petugas_penerima_id)) {
            $peg = PegawaiM::model()->findByPk($this->petugas_penerima_id);
            
            $res['petugas_penerima_nama'] = $peg->nama_pegawai;
        }
        
        $res['tgl_retur_darah'] = MyFormatter::formatDateTimeForUser($this->tgl_retur_darah);
        
        return $json ? CJSON::encode($res) : $res;
    }
    
    /**
     * Simpan analisa retur. Jika kesimpulannya tidak layak, maka tidak akan ditambah stok-nya.
     * 
     * @param  mixed $post data POST
     * @return boolean Hasil penyimpanan. True jika sukses disimpan.
     */
    public function saveAnalisaRetur($post) {
        
        $ok = true;
        
        $this->attributes = $post['BDReturdarahT'];
        $this->tgl_retur_darah = MyFormatter::formatDateTimeForDB($this->tgl_retur_darah);
        $this->tgl_analisa = MyFormatter::formatDateTimeForDB($this->tgl_analisa);
        
        $this->is_kadaluarsa = $this->is_kadaluarsa == 1;
        $this->is_sealer_habis = $this->is_sealer_habis == 1;
        $this->is_tabung_terbuka = $this->is_tabung_terbuka == 1;
        $this->is_bocor = $this->is_bocor == 1;
        $this->is_gumpalan_plasma = $this->is_gumpalan_plasma == 1;
        $this->is_hemolisis = $this->is_hemolisis == 1;
        $this->is_endapan = $this->is_endapan == 1;
        $this->is_plasma_pink = $this->is_plasma_pink == 2;
        
        $ok = $ok && $this->save();
        
        // simpan stok baru...
        $uji = UjikompatibilitasT::model()->findByPk($this->ujikompatibilitas_id);
        
        if (!empty($uji->stokkantongdarah_id) && $this->kesimpulan == 'Layak') {
            $stok = StokkantongdarahT::model()->findByPk($uji->stokkantongdarah_id);
            $stok_baru = new StokkantongdarahT;
            
            $stok_baru->unsetAttributes();
            $stok_baru->attributes = $stok->attributes;
            $stok_baru->kantongdarah_id = $stok->kantongdarah_id;
            $stok_baru->update_time = $stok_baru->update_loginpemakai_id = null;
            
            if ($stok_baru->validate()) {
                $ok = $ok && $stok_baru->save();
            } else {
                $ok = false;
            }
        }
        
        
        return $ok;
    }
}

?>
