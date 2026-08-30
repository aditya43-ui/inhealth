<?php

/**
 * Model untuk beranda 
 * @author Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @package application.modules.pengadaan
 * @subpackage models
 * @category model
 */
Class ADBeranda extends PeriodeanggaranK {
    public $tgl_awal;
    public $tgl_akhir;
    public $pejabatpengadaan_id;
    public $periodeanggaran_id, $sumberbiaya, $pptk_id, $pegawaikpa_id;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PeriodeanggaranK the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Generate seluruh tampilan 
     * @return array
     */
    public function search() {
        $params = [
            'periodeanggaran_id' => $this->periodeanggaran_id,
            'pejabatpengadaan_id' => $this->pejabatpengadaan_id,
            'pptk_id' => $this->pptk_id,
            'pegawaikpa_id' => $this->pegawaikpa_id,
            'sumberbiaya' => $this->sumberbiaya,
        ];

        $count = $this->getCount($params);
        $bar = $this->getBar($params);
        $pie = $this->getPie1($params);
        $grafik_pengadaan = $this->getGrafikPengadaan($params);
        $load = [
            'grafik' => [
                'tiga_grafik' => [
                    'bar' => [
                        'datasets' => $bar,
                    ],
                ],
                'grafik_pengadaan' => [
                    'bar' => $grafik_pengadaan,
                ],
                'pie' => $pie['pie_1'],
                'pie2' => $pie['pie_2'],
            ]
        ];

        $result = [
            'count' => $count,
            'load' => $load,
        ];

        return $result;
    }

    /**
     * Load pejabat pengadaan  
     * @return type
     */
    public function getPejabat() {
        $cri = new CDbCriteria();
        $cri->addCondition("jabatan_pengadaan LIKE '%" . Params::JABATAN_PENGADAAN_PPK . "%'");
        $cri->join = "join pegawai_m on t.pegawai_id = pegawai_m.pegawai_id";
        $cri->order = "nama_pegawai asc";
        $modelPPK = PejabatpengadaanM::model()->findAll($cri);

        $dt['ppk'] = array();
        foreach ($modelPPK as $det) {
            $modPegawai = PegawaiM::model()->findByPk($det->pegawai_id);
            $dt['ppk'][$det->pegawai_id] = $modPegawai->namaLengkap;
        }

        $cri2 = new CDbCriteria();
        $cri2->addCondition("jabatan_pengadaan LIKE '%" . Params::JABATAN_PENGADAAN_KPA . "%'");
        $cri2->join = "join pegawai_m on t.pegawai_id = pegawai_m.pegawai_id";
        $cri2->order = "nama_pegawai asc";
        $modelKPA = PejabatpengadaanM::model()->findAll($cri2);

        $dt['kpa'] = array();
        foreach ($modelKPA as $det) {
            $modPegawai = PegawaiM::model()->findByPk($det->pegawai_id);
            $dt['kpa'][$det->pegawai_id] = $modPegawai->namaLengkap;
        }

        $cri3 = new CDbCriteria();
        $cri3->addCondition("jabatan_pengadaan LIKE '%" . Params::JABATAN_PENGADAAN_PPTK . "%'");
        $cri3->join = "join pegawai_m on t.pegawai_id = pegawai_m.pegawai_id";
        $cri3->order = "nama_pegawai asc";
        $modelPPTK = PejabatpengadaanM::model()->findAll($cri3);

        $dt['pptk'] = array();
        foreach ($modelPPTK as $det) {
            $modPegawai = PegawaiM::model()->findByPk($det->pegawai_id);
            $dt['pptk'][$det->pegawai_id] = $modPegawai->namaLengkap;
        }

        asort($dt['ppk']);
        asort($dt['kpa']);
        asort($dt['pptk']);
        return $dt;
    }

    /**
     * Load periode 
     * @return type
     */
    public function getPeriode() {
        $criteria = new CDbCriteria;
        $criteria->addCondition('isclosing_closinganggaran = false');
        $criteria->order = 'tahunanggaran, periodeanggaran_id';
        $data = PeriodeanggaranK::model()->findAll($criteria);
        $out = CHtml::listData($data, 'periodeanggaran_id', 'anggaran_nama');

        return $out;
    }

    /**
     * Load tile 
     * @param type $params
     * @return type
     */
    public function getCount($params = "") {
        $rup_penyedia = 0;
        $spk_penyedia = 0;
        $nota_pptk = 0;
        $rup_swakelola = 0;
        $nota_swakelola = 0;
        
        /**
         * Data Tile
         */
        $crit1 = new CDbCriteria();
        $crit1->select = "COUNT(rencanaumumpengadaan_id) AS total";
        $crit1->addCondition("kode_rup is not null and rencanaumumpengadaan_kategori = 'Penyedia' AND rencanaumumpengadaan_status <> 'Dibatalkan'");
        $crit1->join = "left join programkerja_v on t.subkegiatanprogram_id = programkerja_v.subkegiatanprogram_id "
                    . "left join pemetaansubkegiatanpengadaan_m on t.subkegiatanprogram_id = pemetaansubkegiatanpengadaan_m.subkegiatanprogram_id ";
        if (!empty($params['periodeanggaran_id'])) {
            $crit1->addCondition('t.periodeanggaran_id = ' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $crit1->addCondition('t.pegawaippk_id = ' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $crit1->addCondition('t.pegawaikpa_id = ' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $crit1->addCondition('pemetaansubkegiatanpengadaan_m.pptk_id = ' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $crit1->addCondition("programkerja_v.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }

        $rup_penyedia = RencanaumumpengadaanT::model()->find($crit1);

        $crit2 = new CDbCriteria();
        $crit2->select = "COUNT(suratperjanjiankerja_id) AS total";
        if (!empty($params['periodeanggaran_id'])) {
            $crit2->addCondition('r.periodeanggaran_id = ' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $crit2->addCondition('r.pegawaippk_id = ' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $crit2->addCondition('r.pegawaikpa_id = ' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $crit2->addCondition('pemetaansubkegiatanpengadaan_m.pptk_id = ' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $crit2->addCondition("programkerja_v.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }
        $crit2->join = "join rencanaumumpengadaan_t r on t.rencanaumumpengadaan_id = r.rencanaumumpengadaan_id
                        left join programkerja_v on r.subkegiatanprogram_id = programkerja_v.subkegiatanprogram_id 
                        left join pemetaansubkegiatanpengadaan_m on r.subkegiatanprogram_id = pemetaansubkegiatanpengadaan_m.subkegiatanprogram_id";
        $crit2->addCondition("r.rencanaumumpengadaan_kategori = 'Penyedia' AND r.rencanaumumpengadaan_status <> 'Dibatalkan'");
        $spk_penyedia = InformasidokumenpengadaanV::model()->find($crit2);


        $crit3 = new CDbCriteria();
        $crit3->select = "COUNT(notadinaspptk_id) AS total";
        $crit3->join = "join mappingrekeninganggaran_m mapping on t.mappingrekeninganggaran_id = mapping.mappingrekeninganggaran_id
                        left join programkerja_v on mapping.subkegiatanprogram_id = programkerja_v.subkegiatanprogram_id 
                        left join pemetaansubkegiatanpengadaan_m on mapping.subkegiatanprogram_id = pemetaansubkegiatanpengadaan_m.subkegiatanprogram_id";
        $crit3->addCondition('suratperjanjiankerja_id IS NOT NULL');
        if (!empty($params['periodeanggaran_id'])) {
            $crit3->addCondition('pemetaansubkegiatanpengadaan_m.periodeanggaran_id = ' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $crit3->addCondition('t.pegppk_id = ' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $crit3->addCondition('pemetaansubkegiatanpengadaan_m.kpa_id = ' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $crit3->addCondition('t.pegpptk_id = ' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $crit3->addCondition("programkerja_v.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }
        $nota_pptk = NotadinaspptkT::model()->find($crit3);

        $crit4 = new CDbCriteria();
        $crit4->select = 'COUNT(rencanaumumpengadaan_id) AS total';
        $crit4->addCondition("kode_rup is not null and rencanaumumpengadaan_kategori = 'Swakelola' AND rencanaumumpengadaan_status <> 'Dibatalkan' ");
        $crit4->join = "left join programkerja_v on t.subkegiatanprogram_id = programkerja_v.subkegiatanprogram_id "
                . "left join pemetaansubkegiatanpengadaan_m on t.subkegiatanprogram_id = pemetaansubkegiatanpengadaan_m.subkegiatanprogram_id ";
        if (!empty($params['periodeanggaran_id'])) {
            $crit4->addCondition('t.periodeanggaran_id = ' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $crit4->addCondition('t.pegawaippk_id = ' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $crit4->addCondition('t.pegawaikpa_id = ' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $crit4->addCondition('pemetaansubkegiatanpengadaan_m.pptk_id = ' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $crit4->addCondition("programkerja_v.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }

        $rup_swakelola = RencanaumumpengadaanT::model()->find($crit4);


        $crit5 = new CDbCriteria();
        $crit5->select = "COUNT(notadinaspptk_id) AS total";
        $crit5->addCondition("kategori_pengadaan = 'Swakelola'");
        $crit5->join = "left join rencanaumumpengadaan_t r on t.rencanaumumpengadaan_id = r.rencanaumumpengadaan_id "
                . "left join programkerja_v on r.subkegiatanprogram_id = programkerja_v.subkegiatanprogram_id "
                . "left join pemetaansubkegiatanpengadaan_m on r.subkegiatanprogram_id = pemetaansubkegiatanpengadaan_m.subkegiatanprogram_id ";
        if (!empty($params['periodeanggaran_id'])) {
            $crit5->addCondition('r.periodeanggaran_id = ' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $crit5->addCondition('r.pegawaippk_id = ' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $crit5->addCondition('r.pegawaikpa_id = ' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $crit5->addCondition('pemetaansubkegiatanpengadaan_m.pptk_id = ' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $crit5->addCondition("programkerja_v.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }
        $nota_swakelola = NotadinaspptkT::model()->find($crit5);

        $result = [
            'rup_penyedia' => $rup_penyedia['total'],
            'spk_penyedia' => $spk_penyedia['total'],
            'nota_pptk' => $nota_pptk['total'],
            'rup_swakelola' => $rup_swakelola['total'],
            'nota_swakelola' => $nota_swakelola['total'],
        ];

        return $result;
    }

    /**
     * Load data bar 
     * @param type $params
     * @return type
     */
    public function getBar($params = "") {
        $crit1 = new CDbCriteria();
        $crit1->select = "COALESCE(SUM(total_pagu), 0) AS total";
        $crit1->addCondition("rencanaumumpengadaan_status = 'RUP Diumumkan' AND rencanaumumpengadaan_kategori = 'Penyedia'");
        $crit1->join = "left join programkerja_v on t.subkegiatanprogram_id = programkerja_v.subkegiatanprogram_id "
                . "left join pemetaansubkegiatanpengadaan_m on t.subkegiatanprogram_id = pemetaansubkegiatanpengadaan_m.subkegiatanprogram_id ";
        if (!empty($params['periodeanggaran_id'])) {
            $crit1->addCondition('t.periodeanggaran_id = ' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $crit1->addCondition('t.pegawaippk_id = ' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $crit1->addCondition('t.pegawaikpa_id = ' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $crit1->addCondition('pemetaansubkegiatanpengadaan_m.pptk_id = ' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $crit1->addCondition("programkerja_v.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }

        $p_t = RencanaumumpengadaanT::model()->find($crit1);

        $crit2 = new CDbCriteria();
        $crit2->select = "COALESCE(SUM(total_pagu), 0) AS total";
        $crit2->addCondition("rencanaumumpengadaan_status = 'Draft' AND rencanaumumpengadaan_kategori = 'Penyedia'");
        $crit2->join = "left join programkerja_v on t.subkegiatanprogram_id = programkerja_v.subkegiatanprogram_id "
                . "left join pemetaansubkegiatanpengadaan_m on t.subkegiatanprogram_id = pemetaansubkegiatanpengadaan_m.subkegiatanprogram_id ";
        if (!empty($params['periodeanggaran_id'])) {
            $crit2->addCondition('t.periodeanggaran_id = ' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $crit2->addCondition('t.pegawaippk_id = ' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $crit2->addCondition('t.pegawaikpa_id = ' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $crit2->addCondition('pemetaansubkegiatanpengadaan_m.pptk_id = ' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $crit2->addCondition("programkerja_v.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }

        $p_d = RencanaumumpengadaanT::model()->find($crit2);


        $crit3 = new CDbCriteria();
        $crit3->addCondition("rencanaumumpengadaan_status = 'RUP Diumumkan' AND rencanaumumpengadaan_kategori = 'Swakelola'");
        $crit3->select = "COALESCE(SUM(total_pagu), 0) AS total";
        $crit3->join = "left join programkerja_v on t.subkegiatanprogram_id = programkerja_v.subkegiatanprogram_id "
                . "left join pemetaansubkegiatanpengadaan_m on t.subkegiatanprogram_id = pemetaansubkegiatanpengadaan_m.subkegiatanprogram_id ";
        if (!empty($params['periodeanggaran_id'])) {
            $crit3->addCondition('t.periodeanggaran_id = ' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $crit3->addCondition('t.pegawaippk_id = ' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $crit3->addCondition('t.pegawaikpa_id = ' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $crit3->addCondition('pemetaansubkegiatanpengadaan_m.pptk_id = ' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $crit3->addCondition("programkerja_v.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }
        $s_t = RencanaumumpengadaanT::model()->find($crit3);

        $crit4 = new CDbCriteria();
        $crit4->select = "COALESCE(SUM(total_pagu), 0) AS total";
        $crit4->addCondition("rencanaumumpengadaan_status = 'Draft' AND rencanaumumpengadaan_kategori = 'Swakelola'");
        $crit4->join = "left join programkerja_v on t.subkegiatanprogram_id = programkerja_v.subkegiatanprogram_id "
                . "left join pemetaansubkegiatanpengadaan_m on t.subkegiatanprogram_id = pemetaansubkegiatanpengadaan_m.subkegiatanprogram_id ";
        if (!empty($params['periodeanggaran_id'])) {
            $crit4->addCondition('t.periodeanggaran_id = ' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $crit4->addCondition('t.pegawaippk_id = ' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $crit4->addCondition('t.pegawaikpa_id = ' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $crit4->addCondition('pemetaansubkegiatanpengadaan_m.pptk_id = ' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $crit4->addCondition("programkerja_v.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }
        $s_d = RencanaumumpengadaanT::model()->find($crit4);

        /**
         * Deklarasi 
         */
        $item_1 = [
                [
                'data' => [$p_t['total']],
                'backgroundColor' => ['#FF7B89'],
                'label' => ['Penyedia Terumumkan'],
            ]
        ];
        $item_2 = [
                [
                'data' => [$p_d['total']],
                'backgroundColor' => ['#FFBA92'],
                'label' => ['Penyedia Draft'],
            ]
        ];
        $item_3 = [
                [
                'data' => [$s_t['total']],
                'backgroundColor' => ['#F0F696'],
                'label' => ['Swakelola Terumumkan'],
            ]
        ];
        $item_4 = [
                [
                'data' => [$s_d['total']],
                'backgroundColor' => ['#6C541E'],
                'label' => ['Swakelola Draft'],
            ]
        ];

        $merge = array_merge($item_1, $item_2, $item_3, $item_4);

        return $merge;
    }

    /**
     * Grafik Pengadaan
     * @param type $params
     * @return type
     */
    public function getGrafikPengadaan($params = "") {
        $criteria = new CDbCriteria();
        if (!empty($params['periodeanggaran_id'])) {
            $criteria->addCondition('t.periodeanggaran_id =' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $criteria->addCondition('t.pegawaippk_id =' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $criteria->addCondition('t.pegawaikpa_id =' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $criteria->addCondition('t.pptk_id =' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $criteria->addCondition("t.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }

        // pencarian dikelompokkan ke 2 kategori pengadaan : Penyedia dan Swakelola 
        $criteria->select = "rencanaumumpengadaan_kategori,
                            COALESCE(SUM(nominal_rup), 0) AS nominal_rup,
                            sum(total_rup) as total_rup,
                            COALESCE(SUM(nominal_kontrak), 0) AS nominal_kontrak,
                            sum(total_kontrak) as total_kontrak,
                            COALESCE(SUM(nominal_bast), 0) AS nominal_bast,
                            sum(total_bast) as total_bast,
                            COALESCE(SUM(nominal_bapbj), 0) AS nominal_bapbj,
                            sum(total_bapbj) as total_bapbj,
                            COALESCE(SUM(nominal_pjphp), 0) AS nominal_pjphp,
                            sum(total_pjphp) as total_pjphp,
                            COALESCE(SUM(nominal_notadinaspptk), 0) AS nominal_notadinaspptk,
                            sum(total_notadinas) AS total_notadinas,
                            COALESCE(SUM(nominal_verifikasi), 0) AS nominal_verifikasi,
                            sum(total_verifikasi) AS total_verifikasi,
                            COALESCE(SUM(nominal_realisasi), 0) AS nominal_realisasi,
                            sum(total_realisasi) AS total_realisasi";
        $criteria->group = "rencanaumumpengadaan_kategori";
        $modDashboard = DashboardperjalanandokumenpengadaanjumlahV::model()->findAll($criteria);
        
        $arrGrafikPengadaan = array();
        $grafikPengadaan = array();
        $data_grafik = array();

        // generate jumlah dan label untuk masing-masing batang 
        foreach ($modDashboard as $det) {
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][0]['jumlah'] = !empty($det['nominal_rup']) ? $det['nominal_rup'] : 0;
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][0]['label'] = "RUP";
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][0]['total'] = $det['total_rup'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][1]['jumlah'] = $det['nominal_kontrak'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][1]['label'] = "Kontrak";
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][1]['total'] = $det['total_kontrak'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][2]['jumlah'] = $det['nominal_bast'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][2]['label'] = "Serah Terima";
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][2]['total'] = $det['total_bast'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][3]['jumlah'] = $det['nominal_bapbj'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][3]['total'] = $det['total_bapbj'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][3]['label'] = "Penyerahan Barang/Jasa";
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][4]['jumlah'] = $det['nominal_pjphp'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][4]['total'] = $det['total_pjphp'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][4]['label'] = "PPHP / PjPHP";
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][5]['jumlah'] = $det['nominal_notadinaspptk'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][5]['total'] = $det['total_notadinas'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][5]['label'] = "Nota Dinas";
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][6]['jumlah'] = $det['nominal_verifikasi'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][6]['total'] =  $det['total_verifikasi'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][6]['label'] = "Verifikasi";
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][7]['jumlah'] = $det['nominal_realisasi'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][7]['total'] = $det['total_realisasi'];
            $grafikPengadaan[$det['rencanaumumpengadaan_kategori']]['det'][7]['label'] = "Realisasi";
            $arrGrafikPengadaan[$det['rencanaumumpengadaan_kategori']] = $det['rencanaumumpengadaan_kategori'];
        }

        $cekIden = array();
        $i = 0;
        
        // jumlah yang di-generate ada 14 
        $cekIden = array();
        $i = 0;
        foreach($grafikPengadaan as $key => $det){
            $jumlah = $iden = 0;
            if (strtoupper($key) == Params::KATEGORI_PENGADAAN_PENYEDIA) {
                $iden = 1;
            } 
            
            foreach($det['det'] as $key2 => $data) {
                $data_grafik['labels'][$key2] = $data['label']; // label untuk masing-masing batang 
                $jumlah = !empty($data['jumlah']) ? $data['jumlah'] : 0;
                $total = !empty($data['total']) ? $data['total'] : 0;
 
                // default warna batang 
                if (strtoupper($key) == Params::KATEGORI_PENGADAAN_PENYEDIA) {
                    $col = '#FF7B89'; // merah
                } else {
                    $col = '#FFBA92'; // oranye 
                }

                $data_grafik['datasets'][$i]['data'][] = $jumlah;     
                $data_grafik['datasets'][$i]['total'][] = $total; // total data 
                $data_grafik['datasets'][$i]['backgroundColor'][] = $col; 
                $data_grafik['datasets'][$i]['label'] = $key; // key = kategori (Pengadaan dan Penyedia)
            }            
            $i++;
        }

//        echo "<pre>";
//        var_dump($data_grafik);
//        die;
        
        return $data_grafik;
    }

    /**
     * Load data pie 
     * @param type $params
     * @return type
     */
    public function getPie1($params = "") {
        $labels = [];
        $labels2 = [];
        $warna = [];
        $warna2 = [];
        $isi = [];
        $isi2 = [];

        $crit1 = new CDbCriteria();
        $crit1->select = "COUNT(t.rencanaumumpengadaan_id) as data , COALESCE(metode_pengadaan, 'Kosong') as labels";
        if (!empty($params['periodeanggaran_id'])) {
            $crit1->addCondition('t.periodeanggaran_id = ' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $crit1->addCondition('t.pegawaippk_id = ' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $crit1->addCondition('t.pegawaikpa_id = ' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $crit1->addCondition('pemetaansubkegiatanpengadaan_m.pptk_id = ' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $crit1->addCondition("programkerja_v.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }

        $crit1->join = "left join programkerja_v on t.subkegiatanprogram_id = programkerja_v.subkegiatanprogram_id "
                . "left join pemetaansubkegiatanpengadaan_m on t.subkegiatanprogram_id = pemetaansubkegiatanpengadaan_m.subkegiatanprogram_id ";

        $crit1->addCondition("rencanaumumpengadaan_status <> 'Dibatalkan'");
        $crit1->group = "metode_pengadaan";
        $data = RencanaumumpengadaanT::model()->findAll($crit1);


        $crit2 = new CDbCriteria();
        if (!empty($params['periodeanggaran_id'])) {
            $crit2->addCondition('r.periodeanggaran_id = ' . $params['periodeanggaran_id']);
        }

        if (!empty($params['pejabatpengadaan_id'])) {
            $crit2->addCondition('r.pegawaippk_id = ' . $params['pejabatpengadaan_id']);
        }

        if (!empty($params['pegawaikpa_id'])) {
            $crit2->addCondition('r.pegawaikpa_id = ' . $params['pegawaikpa_id']);
        }

        if (!empty($params['pptk_id'])) {
            $crit1->addCondition('pemetaansubkegiatanpengadaan_m.pptk_id = ' . $params['pptk_id']);
        }

        if (!empty($params['sumberbiaya'])) {
            $crit1->addCondition("programkerja_v.sumberbiaya ='" . $params['sumberbiaya'] . "'");
        }

        $crit2->select = "COUNT(t.rencanaumumpengadaan_id) as data, COALESCE(jenispengadaan_nama, 'Kosong') AS labels ";
        $crit2->join = "left join  rencanaumumpengadaan_t r on r.rencanaumumpengadaan_id = t.rencanaumumpengadaan_id "
                . "left join programkerja_v on r.subkegiatanprogram_id = programkerja_v.subkegiatanprogram_id "
                . "left join pemetaansubkegiatanpengadaan_m on r.subkegiatanprogram_id = pemetaansubkegiatanpengadaan_m.subkegiatanprogram_id ";
        $crit2->addCondition("rencanaumumpengadaan_status <> 'Dibatalkan'");
        $crit2->group = "jenispengadaan_nama";
        $data2 = PengadaanjenisT::model()->findAll($crit2);

        $put = [];
        foreach ($data AS $key => $val) {
            if ($val['labels'] != 'Kosong') {
                $labels[] = $val['labels'];
                $warna[] = '#' . substr(md5(rand()), 0, 6);
                $isi[] = $val['data'];
            }
        }
        $put['labels'] = $labels;
        $put['datasets'][] = [
            'backgroundColor' => $warna,
            'data' => $isi,
        ];

        $out = [];
        foreach ($data2 AS $key2 => $val2) {
            $labels2[] = $val2['labels'];
            $warna2[] = '#' . substr(md5(rand()), 0, 6);
            $isi2[] = $val2['data'];
        }
        $out['labels'] = $labels2;
        $out['datasets'][] = [
            'backgroundColor' => $warna2,
            'data' => $isi2,
        ];

        $result = [
            'pie_1' => $put,
            'pie_2' => $out,
        ];

        return $result;
    }

}
