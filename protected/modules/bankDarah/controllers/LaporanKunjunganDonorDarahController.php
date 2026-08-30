<?php

/**
 * Digunakan sebagai Laporan Kunjungan Donor Darah
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class LaporanKunjunganDonorDarahController extends MyAuthController {

    /**
     * Digunakan untuk laporan Kunjungan Donor Darah
     */
    public function actionIndex() {

        $criteria = new CDbCriteria();
        $model = new LapkunjungandonorV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->tampilGrafik = isset($_GET['LapkunjungandonorV']['tampilGrafik']) ? $_GET['LapkunjungandonorV']['tampilGrafik'] : 'ruangan';
        if (isset($_GET['LapkunjungandonorV'])) {
            $model->attributes = $_GET['LapkunjungandonorV'];
            $model->jns_periode = $_GET['LapkunjungandonorV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LapkunjungandonorV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LapkunjungandonorV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LapkunjungandonorV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LapkunjungandonorV']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));

            switch ($model->jns_periode) {
                case 'bulan' : $model->tgl_awal = $model->bln_awal . "-01";
                    $model->tgl_akhir = $bln_akhir;
                    break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal . "-01-01";
                    $model->tgl_akhir = $thn_akhir;
                    break;
                default : null;
            }

            $model->ruangan_rekruitmen_id = !empty($_GET['LapkunjungandonorV']['ruangan_rekruitmen_id']) ? $_GET['LapkunjungandonorV']['ruangan_rekruitmen_id'] : null;
        }

        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $model->tgl_awal, $model->tgl_akhir);
        if (!empty($model->ruangan_rekruitmen_id)) {
            $criteria->addInCondition('ruangan_rekruitmen_id', $model->ruangan_rekruitmen_id);
        }
        $modShow2 = LapkunjungandonorV::model()->findAll($criteria);

        //Grouping
        $criteria->group = 'DATE(waktu_pendaftaran), ruangan_rekruitmen_id';
        $criteria->select = 'DATE(waktu_pendaftaran) as waktu_pendaftaran, ruangan_rekruitmen_id';
        $criteria->order = 'DATE(waktu_pendaftaran) ASC';
        $criteria->limit = 10;
        $criteria->offset = !empty($_GET['page']) ? $_GET['page'] + 8 : 0;

        //Cari Data
        $modShow = LapkunjungandonorV::model()->findAll($criteria);
        $count = LapkunjungandonorV::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $b = array();
        foreach ($modShow2 as $hasil) {
            $tglpendaftaran = date('Y-m-d', strtotime($hasil->waktu_pendaftaran));
            $tglsekarang = 'sekarang';
            $ruangrekrutmen = $hasil->ruangan_rekruitmen_id;

            //Jumlah keseluruhan
            if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
            } else {
                $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
            }

            //Berdasarkan Jenis Kelamin
            $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
            $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;

            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI) {
                if (isset($b["$tglpendaftaran"]['det']["$laki"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$laki"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$laki"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$laki"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }
            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN) {
                if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }

            //Berdasarkan Donor Ke
            $satu = 1;
            $lebihdarisatu = !1;
            if ($hasil->donor_itd_ke == 1) {
                if (isset($b["$tglpendaftaran"]['det']["$satu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$satu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$satu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$satu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }
            
            if ($hasil->donor_itd_ke != 1 && $hasil->donor_itd_ke != 0) {
                if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }

            //Berdasarkan Jenis Donor
            $skrl = 'Sukarela';
            $al = 'Autologus';
            $pggt = 'Pengganti';
            if ($hasil->jenisdonor == 'Sukarela') {
                if (isset($b["$tglpendaftaran"]['det']["$skrl"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }
            if ($hasil->jenisdonor == 'Autologus') {
                if (isset($b["$tglpendaftaran"]['det']["$al"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$al"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$al"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$al"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }
            if ($hasil->jenisdonor == 'Pengganti') {
                if (isset($b["$tglpendaftaran"]['det']["$pggt"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }
        }

        $this->render('admin', array(
            'model' => $model,
            'modShow' => $modShow,
            'b' => $b,
            'pages' => $pages
        ));
    }

    /**
     * Digunakan untuk menampilkan grafik
     */
    public function actionFrameGrafikKunjunganDonor() {
        $this->layout = '//layouts/iframe';

        $model = new LapkunjungandonorV('searchGrafikKunjungan');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Kunjungan Donor Darah';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

        if (isset($_GET['LapkunjungandonorV'])) {
            $model->attributes = $_GET['LapkunjungandonorV'];
            $model->jns_periode = $_GET['LapkunjungandonorV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LapkunjungandonorV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LapkunjungandonorV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LapkunjungandonorV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LapkunjungandonorV']['bln_akhir']);
            $model->thn_awal = $_GET['LapkunjungandonorV']['thn_awal'];
            $model->thn_akhir = $_GET['LapkunjungandonorV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));

            switch ($model->jns_periode) {
                case 'bulan' : $model->tgl_awal = $model->bln_awal . "-01";
                    $model->tgl_akhir = $bln_akhir;
                    break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal . "-01-01";
                    $model->tgl_akhir = $thn_akhir;
                    break;
                default : null;
            }
            $model->ruangan_rekruitmen_id = !empty($_GET['LapkunjungandonorV']['ruangan_rekruitmen_id']) ? $_GET['LapkunjungandonorV']['ruangan_rekruitmen_id'] : null;
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    /**
     * Cetak laporan kunjungan donor darah
     */
    public function actionPrintKunjunganDonor() {
        $criteria = new CDbCriteria();
        $model = new LapkunjungandonorV('searchPrint');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Kunjungan Donor Darah';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Kunjungan Donor Darah';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
        if (isset($_REQUEST['LapkunjungandonorV'])) {
            $model->attributes = $_REQUEST['LapkunjungandonorV'];
            $model->jns_periode = $_GET['LapkunjungandonorV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LapkunjungandonorV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LapkunjungandonorV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LapkunjungandonorV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LapkunjungandonorV']['bln_akhir']);
            $model->thn_awal = $_GET['LapkunjungandonorV']['thn_awal'];
            $model->thn_akhir = $_GET['LapkunjungandonorV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
            switch ($model->jns_periode) {
                case 'bulan' : $model->tgl_awal = $model->bln_awal . "-01";
                    $model->tgl_akhir = $bln_akhir;
                    break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal . "-01-01";
                    $model->tgl_akhir = $thn_akhir;
                    break;
                default : null;
            }
            $model->ruangan_rekruitmen_id = !empty($_GET['LapkunjungandonorV']['ruangan_rekruitmen_id']) ? $_GET['LapkunjungandonorV']['ruangan_rekruitmen_id'] : null;
        }

        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $model->tgl_awal, $model->tgl_akhir);
        if (!empty($model->ruangan_rekruitmen_id)) {
            $criteria->addInCondition('ruangan_rekruitmen_id', $model->ruangan_rekruitmen_id);
        }
        $modShow2 = LapkunjungandonorV::model()->findAll($criteria);

        //Grouping
        $criteria->group = 'DATE(waktu_pendaftaran), ruangan_rekruitmen_id';
        $criteria->select = 'DATE(waktu_pendaftaran) as waktu_pendaftaran, ruangan_rekruitmen_id';
        $criteria->order = 'DATE(waktu_pendaftaran) ASC';
        
        //Cari Data
        $modShow = LapkunjungandonorV::model()->findAll($criteria);
        $b = array();
        foreach ($modShow2 as $hasil) {
            $tglpendaftaran = date('Y-m-d', strtotime($hasil->waktu_pendaftaran));
            $tglsekarang = 'sekarang';
            $ruangrekrutmen = $hasil->ruangan_rekruitmen_id;

            //Jumlah keseluruhan
            if (isset($b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
            } else {
                $b["$tglpendaftaran"]['det']["$tglsekarang"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
            }

            //Berdasarkan Jenis Kelamin
            $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
            $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;

            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI) {
                if (isset($b["$tglpendaftaran"]['det']["$laki"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$laki"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$laki"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$laki"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }
            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN) {
                if (isset($b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$perempuan"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }

            //Berdasarkan Donor Ke
            $satu = 1;
            $lebihdarisatu = !1;
            if ($hasil->donor_itd_ke == 1) {
                if (isset($b["$tglpendaftaran"]['det']["$satu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$satu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$satu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$satu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }
            
            if ($hasil->donor_itd_ke != 1 && $hasil->donor_itd_ke != 0) {
                if (isset($b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$lebihdarisatu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }

            //Berdasarkan Jenis Donor
            $skrl = 'Sukarela';
            $al = 'Autologus';
            $pggt = 'Pengganti';
            if ($hasil->jenisdonor == 'Sukarela') {
                if (isset($b["$tglpendaftaran"]['det']["$skrl"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$skrl"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }
            if ($hasil->jenisdonor == 'Autologus') {
                if (isset($b["$tglpendaftaran"]['det']["$al"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$al"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$al"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$al"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }
            if ($hasil->jenisdonor == 'Pengganti') {
                if (isset($b["$tglpendaftaran"]['det']["$pggt"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"])) {
                    $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] + 1;
                } else {
                    $b["$tglpendaftaran"]['det']["$pggt"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] = 1;
                }
            }
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = '_print';

        $arr = array('modShow' => $modShow, 'b' => $b);

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, '', $arr);
    }

    /**
     * Fungsi print 
     * @param type $model
     * @param type $data
     * @param type $caraPrint
     * @param type $judulLaporan
     * @param type $target
     * @param type $tab
     * @param type $variabel
     */
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab = 'rs', $variabel = array()) {
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows3';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait

            $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 10), true));

            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 20, 20, 20, 47, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
