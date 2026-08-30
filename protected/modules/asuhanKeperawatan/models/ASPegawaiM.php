<?php

/**
 * Extend transaksi dan informasi pesan barang dari modul gudang umum
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 */
class ASPegawaiM extends PegawaiM {
    
    public $jabatan_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PegawaiM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Pencarian perawat
     * @return \CActiveDataProvider
     */
    public function searchPerawat() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('gelarbelakang_id', $this->gelarbelakang_id);
        $criteria->compare('kelompokpegawai_id', $this->kelompokpegawai_id);
        $criteria->compare('pendkualifikasi_id', $this->pendkualifikasi_id);
        $criteria->compare('jabatan_id', $this->jabatan_id);
        $criteria->compare('pendidikan_id', $this->pendidikan_id);
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('pangkat_id', $this->pangkat_id);
        $criteria->compare('kabupaten_id', $this->kabupaten_id);
        $criteria->compare('LOWER(nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(no_kartupegawainegerisipil)', strtolower($this->no_kartupegawainegerisipil), true);
        $criteria->compare('LOWER(no_karis_karsu)', strtolower($this->no_karis_karsu), true);
        $criteria->compare('LOWER(no_taspen)', strtolower($this->no_taspen), true);
        $criteria->compare('LOWER(no_askes)', strtolower($this->no_askes), true);
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(nama_keluarga)', strtolower($this->nama_keluarga), true);
        $criteria->compare('LOWER(tempatlahir_pegawai)', strtolower($this->tempatlahir_pegawai), true);
        if (!empty($this->tgl_lahirpegawai)) {
            $criteria->addCondition("DATE(tgl_lahirpegawai) = '" . MyFormatter::formatDateTimeForDb($this->tgl_lahirpegawai) . "'");
        }
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(alamat_pegawai)', strtolower($this->alamat_pegawai), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(notelp_pegawai)', strtolower($this->notelp_pegawai), true);
        $criteria->compare('LOWER(nomobile_pegawai)', strtolower($this->nomobile_pegawai), true);
        $criteria->compare('LOWER(warganegara_pegawai)', strtolower($this->warganegara_pegawai), true);
        $criteria->compare('LOWER(jeniswaktukerja)', strtolower($this->jeniswaktukerja), true);
        $criteria->compare('LOWER(kelompokjabatan)', strtolower($this->kelompokjabatan), true);
        $criteria->compare('LOWER(kategoripegawai)', strtolower($this->kategoripegawai), true);
        $criteria->compare('LOWER(kategoripegawaiasal)', strtolower($this->kategoripegawaiasal), true);
        $criteria->compare('LOWER(photopegawai)', strtolower($this->photopegawai), true);
        $criteria->compare('pegawai_aktif', isset($this->pegawai_aktif) ? $this->pegawai_aktif : true);
        $criteria->compare('esselon_id', $this->esselon_id);
        $criteria->compare('statuskepemilikanrumah_id', $this->statuskepemilikanrumah_id);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(noidentitas)', strtolower($this->noidentitas), true);
        $criteria->compare('LOWER(nofingerprint)', strtolower($this->nofingerprint), true);
        $criteria->compare('tinggibadan', $this->tinggibadan);
        $criteria->compare('beratbadan', $this->beratbadan);
        $criteria->compare('unit_perusahaan', $this->unit_perusahaan);
        $criteria->compare('suratizinpraktek', $this->suratizinpraktek);
        $criteria->compare('LOWER(kemampuanbahasa)', strtolower($this->kemampuanbahasa), true);
        $criteria->compare('LOWER(warnakulit)', strtolower($this->warnakulit), true);
        $criteria->compare('LOWER(deskripsi)', strtolower($this->deskripsi), true);
        $criteria->order = 'pegawai_id ASC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                //'pagination' => false,
        ));
    }

    /**
     * Pencarian petugas
     * @return \CActiveDataProvider
     */
    public function searchPetugas() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $kelompokpegawai = [2, 20, 28];
        $criteria = new CDbCriteria;
        $criteria->compare('gelarbelakang_id', $this->gelarbelakang_id);
        $criteria->addInCondition('kelompokpegawai_id', $kelompokpegawai);
        $criteria->compare('pendkualifikasi_id', $this->pendkualifikasi_id);
        $criteria->compare('jabatan_id', $this->jabatan_id);
        $criteria->compare('pendidikan_id', $this->pendidikan_id);
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('pangkat_id', $this->pangkat_id);
        $criteria->compare('kabupaten_id', $this->kabupaten_id);
        $criteria->compare('LOWER(nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(no_kartupegawainegerisipil)', strtolower($this->no_kartupegawainegerisipil), true);
        $criteria->compare('LOWER(no_karis_karsu)', strtolower($this->no_karis_karsu), true);
        $criteria->compare('LOWER(no_taspen)', strtolower($this->no_taspen), true);
        $criteria->compare('LOWER(no_askes)', strtolower($this->no_askes), true);
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(nama_keluarga)', strtolower($this->nama_keluarga), true);
        $criteria->compare('LOWER(tempatlahir_pegawai)', strtolower($this->tempatlahir_pegawai), true);
        if (!empty($this->tgl_lahirpegawai)) {
            $criteria->addCondition("DATE(tgl_lahirpegawai) = '" . MyFormatter::formatDateTimeForDb($this->tgl_lahirpegawai) . "'");
        }
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(alamat_pegawai)', strtolower($this->alamat_pegawai), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(notelp_pegawai)', strtolower($this->notelp_pegawai), true);
        $criteria->compare('LOWER(nomobile_pegawai)', strtolower($this->nomobile_pegawai), true);
        $criteria->compare('LOWER(warganegara_pegawai)', strtolower($this->warganegara_pegawai), true);
        $criteria->compare('LOWER(jeniswaktukerja)', strtolower($this->jeniswaktukerja), true);
        $criteria->compare('LOWER(kelompokjabatan)', strtolower($this->kelompokjabatan), true);
        $criteria->compare('LOWER(kategoripegawai)', strtolower($this->kategoripegawai), true);
        $criteria->compare('LOWER(kategoripegawaiasal)', strtolower($this->kategoripegawaiasal), true);
        $criteria->compare('LOWER(photopegawai)', strtolower($this->photopegawai), true);
        $criteria->addCondition('pegawai_aktif IS TRUE');
        $criteria->compare('esselon_id', $this->esselon_id);
        $criteria->compare('statuskepemilikanrumah_id', $this->statuskepemilikanrumah_id);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(noidentitas)', strtolower($this->noidentitas), true);
        $criteria->compare('LOWER(nofingerprint)', strtolower($this->nofingerprint), true);
        $criteria->compare('tinggibadan', $this->tinggibadan);
        $criteria->compare('beratbadan', $this->beratbadan);
        $criteria->compare('unit_perusahaan', $this->unit_perusahaan);
        $criteria->compare('suratizinpraktek', $this->suratizinpraktek);
        $criteria->compare('LOWER(kemampuanbahasa)', strtolower($this->kemampuanbahasa), true);
        $criteria->compare('LOWER(warnakulit)', strtolower($this->warnakulit), true);
        $criteria->compare('LOWER(deskripsi)', strtolower($this->deskripsi), true);
        $criteria->order = 'pegawai_id ASC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                //'pagination' => false,
        ));
    }

    /**
     * Pencarian petugas
     * @return \CActiveDataProvider
     */
    public function searchDialogPerawatBidan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $pegawailogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.kepalaunitpeg_id IS NOT NULL");
        $criteria->addCondition("t.unitkerja_aktif IS TRUE");
        $cekKepalaUnit = UnitkerjaM::model()->findAll($criteria);
        $kepalaunit = array();

        foreach ($cekKepalaUnit as $value):
            $kepalaunit[] = $value->kepalaunitpeg_id;
        endforeach;

        $criteria2 = new CDbCriteria;
        $criteria2->addInCondition("t.pegawai_id", $kepalaunit);
        $criteria2->addCondition("t.pegawai_id = " . $pegawailogin->pegawai_id);
        $modPegawai = PegawaiM::model()->find($criteria2);

        if (!empty($modPegawai)) {
            $unitkerja_id = !empty($modPegawai->unitkerja_id) ? $modPegawai->unitkerja_id : '';
        }else{
            $unitkerja_id = '';
        }
        
        $kelompokpegawai = [Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN];
        
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, jabatan_m.jabatan_nama, unitkerja_m.namaunitkerja';
        $criteria->join = 'LEFT JOIN jabatan_m ON jabatan_m.jabatan_id = t.jabatan_id '
                        . 'JOIN unitkerja_m ON unitkerja_m.unitkerja_id = t.unitkerja_id';
        
//        if($unitkerja_id != ''){
//            $criteria->addCondition('t.unitkerja_id = '. $unitkerja_id);
//        }
        $criteria->addInCondition('t.kelompokpegawai_id', $kelompokpegawai);
        $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(jabatan_m.jabatan_nama)', strtolower($this->jabatan_nama), true);
        $criteria->addCondition('pegawai_aktif IS TRUE');
        $criteria->order = 'nama_pegawai ASC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                //'pagination' => false,
        ));
    }

    /**
     * Pencarian perawat
     * @return \CActiveDataProvider
     */
    public function searchDialogPerawat() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $kelompokpegawai = [Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN];
        
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, jabatan_m.jabatan_nama, unitkerja_m.namaunitkerja';
        $criteria->join = 'LEFT JOIN jabatan_m ON jabatan_m.jabatan_id = t.jabatan_id '
                        . 'LEFT JOIN unitkerja_m ON unitkerja_m.unitkerja_id = t.unitkerja_id';
        
        $criteria->addInCondition('t.kelompokpegawai_id', $kelompokpegawai);
        $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(jabatan_m.jabatan_nama)', strtolower($this->jabatan_nama), true);
        $criteria->compare('LOWER(unitkerja_m.namaunitkerja)', strtolower($this->namaunitkerja), true);
        $criteria->addCondition('pegawai_aktif IS TRUE');
        $criteria->order = 'nama_pegawai ASC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                //'pagination' => false,
        ));
    }

    public function searchDialogJabatanPerawat() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, jabatan_m.jabatan_nama, unitkerja_m.namaunitkerja';
        $criteria->join = 'LEFT JOIN jabatan_m ON jabatan_m.jabatan_id = t.jabatan_id '
                        . 'JOIN unitkerja_m ON unitkerja_m.unitkerja_id = t.unitkerja_id';
        
//        if($unitkerja_id != ''){
//            $criteria->addCondition('t.unitkerja_id = '. $unitkerja_id);
//        }
        $this->jabatan_nama = 'Perawat';
        $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(jabatan_m.jabatan_nama)', strtolower($this->jabatan_nama), false);
        $criteria->compare('LOWER(unitkerja_m.namaunitkerja)', strtolower($this->namaunitkerja), false);
        $criteria->addCondition('pegawai_aktif IS TRUE');
        $criteria->order = 'nama_pegawai ASC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                //'pagination' => false,
        ));
    }
}
