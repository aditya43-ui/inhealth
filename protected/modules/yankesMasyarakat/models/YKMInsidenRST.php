<?php

/**
 * Model untuk tabel insidenrs_t hanya untuk model pelayanan kesehatan masyarakat
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage models
 */
class YKMInsidenRST extends InsidenrsT {

    public $no_rekam_medik, $nama_pasien, $tindaklanjut, $tgl_awal, $tgl_akhir, $namaunitkerja, $ruangan_nama, $kategoripenolakan, $alasan_persetujuan;
    public $tglawallapor, $tglakhirlapor, $tglawalinsiden, $tglakhirinsiden, $tingkatrisiko_nama, $data, $jumlah,
            $gradingrisiko, $gradinginsidenrs_id, $statuslaporan, $regradingrisiko, $tindakan, $tingkatrisiko_id,
            $tgl_laporan, $keterangan, $tipeLapor, $tipeInsiden, $grader2;
    public $bln_awal, $instalasi_id, $ruangan_id;
    public $bln_akhir;
    public $thn_awal;
    public $thn_akhir;
    public $jns_periode;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InsidenrsT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Pencarian untuk Informasi Laporan Insiden Rumah Sakit Modul Pelayanan Kesehatan Masyarakat
     * @return \CActiveDataProvider
     */
    public function searchInformasi() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("gr.tgl_kirimpelaporan IS NOT NULL");
        $criteria->select = "t.*, "
                . "CASE
                                        WHEN t.pendaftaran_id is null THEN t.nama_pasien::text
                                        ELSE ps.nama_pasien::text
                                    END AS nama_pasien, 
                                    CASE
                                        WHEN t.pendaftaran_id is null THEN t.norekammedik::text
                                        ELSE ps.no_rekam_medik::text
                                    END AS no_rekam_medik,"
                . "tr.tingkatrisiko_nama, "
                . "gr.gradingrisiko, gr.gradinginsidenrs_id, gr.statuslaporan, gr.tindakan, "
                . "gr.regradingrisiko, gr.tingkatrisiko_id, gr.grader2, gr.tindaklanjut";
        $criteria->join = "LEFT JOIN pendaftaran_t p ON t.pendaftaran_id = p.pendaftaran_id "
                . "LEFT JOIN pasien_m ps ON p.pasien_id = ps.pasien_id "
                . "LEFT JOIN gradinginsidenrs_t gr ON t.insidenrs_id = gr.insidenrs_id "
                . "LEFT JOIN tingkatrisiko_m tr ON gr.tingkatrisiko_id = tr.tingkatrisiko_id ";

        if ($this->tipeInsiden == true) {
            $criteria->addBetweenCondition("date(t.insidenrs_tglinsiden)", $this->tglawalinsiden, $this->tglakhirinsiden);
            $criteria->order = 'insidenrs_tglinsiden DESC';
        }


        if ($this->tipeLapor == true) {
            $criteria->addBetweenCondition("date(t.insidenrs_tgllapor)", $this->tglawallapor, $this->tglakhirlapor);
            $criteria->order = 'insidenrs_tgllapor DESC';
        }

        $criteria->compare('ps.no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('gr.statuslaporan', $this->statuslaporan, true);
        $criteria->compare('gr.regradingrisiko', $this->regradingrisiko, true);
        $criteria->compare('gr.tingkatrisiko_id', $this->tingkatrisiko_id);
        $criteria->compare('lokasikejadian_id', $this->lokasikejadian_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data laporan
     * @return \CDbCriteria
     */
    public function criLaporan() {
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition("date(t.insidenrs_tgllapor)", $this->tgl_awal, $this->tgl_akhir);

        if (!empty($this->kategoripenolakan)) {
            $criteria->compare('grading.kategoripenolakan', $this->kategoripenolakan);
        }
        if (!empty($this->ruangan_id)) {
            $criteria->addInCondition('t.lokasikejadian_id', $this->ruangan_id);
        }
        $criteria->select = "t.*, grading.*, unit.namaunitkerja, ruangan.ruangan_nama ";
        $criteria->join = "join gradinginsidenrs_t grading on t.insidenrs_id = grading.insidenrs_id
                            join unitkerja_m unit on t.unitkerjatempat_id = unit.unitkerja_id
                            join ruangan_m ruangan on t.lokasikejadian_id = ruangan.ruangan_id";
        $criteria->addCondition("grading.statuslaporan = '" . Params::STATUS_LAPORAN_INSIDEN_DITOLAK . "'");
        return $criteria;
    }

    /**
     * Tabel Laporan 
     * @return \CActiveDataProvider
     */
    public function searchLaporanDitolak() {
        $criteria = $this->criLaporan();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Cetak Laporan 
     * @return \CActiveDataProvider
     */
    public function searchLaporanDitolakPrint() {
        $criteria = $this->criLaporan();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load grafik
     * @return \CActiveDataProvider
     */
    public function searchGrafikDitolak() {
        $criteria = $this->criLaporan();
        $criteria->select = 'count(kategoripenolakan) as jumlah, kategoripenolakan as data';
        $criteria->group = 'kategoripenolakan';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
