<?php

/**
 * This is the model class for table "hasilpemeriksaanlab_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaanlab_t':
 * @property integer $hasilpemeriksaanlab_id
 * @property integer $pendaftaran_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property string $nohasilperiksalab
 * @property string $tglhasilpemeriksaanlab
 * @property string $tglpengambilanhasil
 * @property string $hasil_kelompokumur
 * @property string $hasil_jeniskelamin
 * @property string $statusperiksahasil
 * @property string $catatanlabklinik
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 */
class LBHasilPemeriksaanLabT extends HasilpemeriksaanlabT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanlabT the static model class
	 */
		public $waktuhasil, $is_sendiri, $statushasilpemeriksaan;
		public $bulan, $tahun, $tgl, $pasienmasukpenunjang_id, $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
        public $tgl_awal, $tgl_akhir, $data, $jumlah, $tick;
        public $no_rekam_medik,$nama_pasien,$namadepan,$jeniskelamin,$instalasi_nama,$ruangan_nama,$penjamin_nama,$carabayar_nama;
        public $setHasilPemeriksa;

        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
		/*
         *Fungsi untuk kriteria kritis 
         */
        public function criteriaSearchKritis(){
            $criteria = new CDbCriteria;
            $format = new MyFormatter();
            $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
            $criteria->addBetweenCondition('date(t.tglhasilpemeriksaanlab)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->addCondition("t.statushasilpemeriksaan = 'KRITIS'");
            $criteria->select = 'pasien.no_rekam_medik,pasien.namadepan , pasien.nama_pasien ,pasien.jeniskelamin, t.hasilpemeriksaanlab_id, '
                                . 'ruangan.ruangan_nama, instalasi.instalasi_nama , carabayar.carabayar_nama, penjamin.penjamin_nama';
            $criteria->join= 'LEFT JOIN pasienmasukpenunjang_t as pasienmasukpenunjang ON t.pasienmasukpenunjang_id = pasienmasukpenunjang.pasienmasukpenunjang_id '
                            . 'LEFT JOIN pasien_m as pasien ON t.pasien_id = pasien.pasien_id '
                            . 'LEFT JOIN pendaftaran_t as pendaftaran ON t.pendaftaran_id = pendaftaran.pendaftaran_id '
                            . 'JOIN ruangan_m as ruangan ON pasienmasukpenunjang.ruanganasal_id = ruangan.ruangan_id '
                            . 'JOIN instalasi_m as instalasi ON ruangan.instalasi_id = instalasi.instalasi_id '
                            . 'JOIN penjaminpasien_m as penjamin ON pendaftaran.penjamin_id = penjamin.penjamin_id '
                            . 'JOIN carabayar_m as carabayar ON pendaftaran.carabayar_id = carabayar.carabayar_id ';
            
            return $criteria;
        }
        
        /**
         * Menampilkan data kritis
         * @return \CActiveDataProvider
         */
        public function searchTableKritis() {
            $criteria = new CDbCriteria;
            $criteria = $this->criteriaSearchKritis();

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }
        
        /**
         * Menampilkan grafik kritis
         * @return \CActiveDataProvider
         */
        public function searchGrafik() {
            $criteria = new CDbCriteria;
            $format = new MyFormatter();
            $criteria->select = 'count(t.hasilpemeriksaanlab_id) as jumlah , DATE(t.tglhasilpemeriksaanlab) as data';
            $criteria->group = 'date(t.tglhasilpemeriksaanlab)';
            $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
            $criteria->addBetweenCondition('date(t.tglhasilpemeriksaanlab)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->addCondition("t.statushasilpemeriksaan = 'KRITIS'");
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
        }
        
        /**
         * Mencetak data kritis
         * @return \CActiveDataProvider
         */
        public function searchPrintKritis() {
            $criteria = new CDbCriteria;
            $criteria = $this->criteriaSearchKritis();
            $criteria->limit = -1;
            
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination'=>false,
                    ));
        }

}