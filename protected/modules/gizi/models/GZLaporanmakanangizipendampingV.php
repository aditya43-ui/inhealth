<?php

/**
 * Extend dari model LaporanmakanangizipendampingV
 *
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 */
class GZLaporanmakanangizipendampingV extends LaporanmakanangizipendampingV {

    public $jns_periode, $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $instalasi_id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->join = 'join ruangan_m r on r.ruangan_id = t.ruangan_id';
        $criteria->addBetweenCondition('DATE(t.tglkirimmenu)', $this->tgl_awal, $this->tgl_akhir, true);
        $criteria->compare('t.pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(t.gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(t.alamat_pegawai)', strtolower($this->alamat_pegawai), true);
        $criteria->compare('t.kirimmenudiet_id', $this->kirimmenudiet_id);
        $criteria->compare('LOWER(t.tglkirimmenu)', strtolower($this->tglkirimmenu), true);
        $criteria->compare('LOWER(t.jenispesanmenu)', strtolower($this->jenispesanmenu), true);
        $criteria->compare('LOWER(t.keterangan_kirim)', strtolower($this->keterangan_kirim), true);
        $criteria->compare('t.jenisdiet_id', $this->jenisdiet_id);
        $criteria->compare('LOWER(t.jenisdiet_nama)', strtolower($this->jenisdiet_nama), true);
        $criteria->compare('t.menudiet_id', $this->menudiet_id);
        $criteria->compare('t.jml_kirim', $this->jml_kirim);
        $criteria->compare('LOWER(t.satuanjml_urt)', strtolower($this->satuanjml_urt), true);
        $criteria->compare('t.jeniswaktu_id', $this->jeniswaktu_id);
        $criteria->compare('LOWER(t.jeniswaktu_nama)', strtolower($this->jeniswaktu_nama), true);
        $criteria->compare('LOWER(t.menudiet_nama)', strtolower($this->menudiet_nama), true);
        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        $criteria->compare('r.instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(t.ruangan_lokasi)', strtolower($this->ruangan_lokasi), true);
        $criteria->compare('LOWER(t.jeniswaktu_jam)', strtolower($this->jeniswaktu_jam), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint() {
        $prop = $this->searchTable();
        $prop->pagination = false;
        return $prop;
    }

}
