<?php
/**
 * Model extend untuk laporanoppekeperawatan_v di modul asuhan keperawatan
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASLaporanoppekeperawatanV extends LaporanoppekeperawatanV {

    public $tgl_awal, $tgl_akhir, $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jenis, $data, $jumlah, $type;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporanoppekeperawatanV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Pencarian laporan 
     * @return \CActiveDataProvider
     */
    public function searchLaporan() {
        $criteria = new CDbCriteria();
        $tgl_awal = date('Y-m-01', strtotime(MyFormatter::formatMonthForDb($this->tgl_awal)));
        $tgl_akhir = date('Y-m-t', strtotime(MyFormatter::formatMonthForDb($this->tgl_akhir))); 
        $criteria->addBetweenCondition('date(periodebulan)', $tgl_awal, $tgl_akhir);
        $criteria->select = "t.indikatoroppekeperawatan_id, 
                            i.nama_indikator, 
                            (sum(t.standar_nilai) / count(t.indikatoroppekeperawatan_id)) as standar_nilai,
                            (sum(t.capaian) / count(t.indikatoroppekeperawatan_id)) as capaian,
                            (sum(t.skor) / count(t.indikatoroppekeperawatan_id)) as skor";
        $criteria->group = "t.indikatoroppekeperawatan_id, i.nama_indikator";
        $criteria->join = "left join indikatoroppekeperawatan_m i on i.indikatoroppekeperawatan_id = t.indikatoroppekeperawatan_id ";
        $criteria->order = "i.nama_indikator asc";
        if (!empty($this->jenis) && !empty($this->pegawai_id)) {
            if ($this->jenis == 'Unit') {
                $criteria->addCondition('t.unitkerja_id = ' . $this->pegawai_id);
            } else if($this->jenis == 'Pegawai') {
                $criteria->addCondition('t.pegawai_id = ' . $this->pegawai_id);
            }
        }

        if (!empty($this->golongan_indikator)) {
            $criteria->addInCondition('t.indikatoroppekeperawatan_id', $this->golongan_indikator);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data untuk pencarian laporan 
     * @return \CActiveDataProvider
     */
    public function searchPrintLaporan() {
        $criteria = new CDbCriteria();
        $tgl_awal = date('Y-m-01', strtotime(MyFormatter::formatMonthForDb($this->tgl_awal)));
        $tgl_akhir = date('Y-m-t', strtotime(MyFormatter::formatMonthForDb($this->tgl_akhir))); 
        $criteria->addBetweenCondition('date(periodebulan)', $tgl_awal, $tgl_akhir);

        $criteria->select = "t.indikatoroppekeperawatan_id, 
                            (sum(t.standar_nilai) / count(t.indikatoroppekeperawatan_id)) as standar_nilai,
                            (sum(t.capaian) / count(t.indikatoroppekeperawatan_id)) as capaian,
                            (sum(t.skor) / count(t.indikatoroppekeperawatan_id)) as skor";
        $criteria->group = "t.indikatoroppekeperawatan_id";
        if (!empty($this->jenis) && !empty($this->pegawai_id)) {
            if ($this->jenis == 'Unit') {
                $criteria->addCondition('t.unitkerja_id = ' . $this->pegawai_id);
            } else if($this->jenis == 'Pegawai') {
                $criteria->addCondition('t.pegawai_id = ' . $this->pegawai_id);
            }
        }

        if (!empty($this->golongan_indikator)) {
            $criteria->addInCondition('t.indikatoroppekeperawatan_id', $this->golongan_indikator);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * List data untuk pencarian 
     * @return \CDbCriteria
     */
    public function criteriaLaporan() {
        $criteria = new CDbCriteria();
        $tgl_awal = date('Y-m-01', strtotime(MyFormatter::formatMonthForDb($this->tgl_awal)));
        $tgl_akhir = date('Y-m-t', strtotime(MyFormatter::formatMonthForDb($this->tgl_akhir))); 
        $criteria->addBetweenCondition('date(periodebulan)', $tgl_awal, $tgl_akhir);
        $criteria->select = "t.*, i.*";
        if (!empty($this->jenis) && !empty($this->pegawai_id)) {
            if ($this->jenis == 'Unit') {
                $criteria->addCondition('t.unitkerja_id = ' . $this->pegawai_id);
            } else if($this->jenis == 'Pegawai') {
                $criteria->addCondition('t.pegawai_id = ' . $this->pegawai_id);
            }
        }

        if (!empty($this->golongan_indikator)) {
            $criteria->addInCondition('t.indikatoroppekeperawatan_id', $this->golongan_indikator);
        }
        $criteria->join = "left join indikatoroppekeperawatan_m i on i.indikatoroppekeperawatan_id = t.indikatoroppekeperawatan_id ";
        $criteria->order = "i.nama_indikator asc";
        return $criteria;
    }

    /**
     * Load data grafik
     * @return \CActiveDataProvider
     */
    public function searchGrafik() {
        $criteria = $this->criteriaLaporan();
        $criteria->select = '(sum(t.skor) / count(t.indikatoroppekeperawatan_id)) as jumlah, '
                . 'i.nama_indikator as data';
        $criteria->group = 't.indikatoroppekeperawatan_id, i.nama_indikator';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
