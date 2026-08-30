<?php

/**
 * Controller untuk Laporan Jumlah Pendonor
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 */
class LaporanJumlahPendonorController extends MyAuthController {

    public $path_view = 'bankDarah.views.laporan.jumlahPendonor.';

    /**
     * Halaman index Laporan Jumlah Pendonor
     */
    public function actionIndex() {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $criteria = new CDbCriteria();
        $model = new LaporanpermenkesjumlahpendonorV();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['LaporanpermenkesjumlahpendonorV'])) {
            $model->attributes = $_GET['LaporanpermenkesjumlahpendonorV'];
            $model->jns_periode = $_GET['LaporanpermenkesjumlahpendonorV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LaporanpermenkesjumlahpendonorV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporanpermenkesjumlahpendonorV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LaporanpermenkesjumlahpendonorV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LaporanpermenkesjumlahpendonorV']['bln_akhir']);
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
        }

        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $model->tgl_awal, $model->tgl_akhir);
        $criteria->addCondition("donasi_ke > 0");
        $modShow2 = LaporanpermenkesjumlahpendonorV::model()->findAll($criteria);

        $b = array();
        foreach ($modShow2 as $hasil) {
            $kelompok_umur = $hasil->kelompok_umur;
            $y = $hasil->seleksi_umur;

            // Jumlah keseluruhan
            if (isset($b['det']['jumlahnya']['jumlah'])) {
                $b['det']['jumlahnya']['jumlah'] = $b['det']['jumlahnya']['jumlah'] + 1;
            } else {
                $b['det']['jumlahnya']['jumlah'] = 1;
            }

            //Kurang < 18
            if ($y < 18) {
                if (isset($b['det']['jumlahnya']['umur<18'])) {
                    $b['det']['jumlahnya']['umur<18'] = $b['det']['jumlahnya']['umur<18'] + 1;
                } else {
                    $b['det']['jumlahnya']['umur<18'] = 1;
                }
            }

            //18 - 24
            if ($y >= 18 && $y <= 24) {
                if (isset($b['det']['jumlahnya']['18sampai24'])) {
                    $b['det']['jumlahnya']['18sampai24'] = $b['det']['jumlahnya']['18sampai24'] + 1;
                } else {
                    $b['det']['jumlahnya']['18sampai24'] = 1;
                }
            }

            //25 - 44
            if ($y >= 25 && $y <= 44) {
                if (isset($b['det']['jumlahnya']['25sampai44'])) {
                    $b['det']['jumlahnya']['25sampai44'] = $b['det']['jumlahnya']['25sampai44'] + 1;
                } else {
                    $b['det']['jumlahnya']['25sampai44'] = 1;
                }
            }

            //45 - 59
            if ($y >= 45 && $y <= 59) {
                if (isset($b['det']['jumlahnya']['45sampai59'])) {
                    $b['det']['jumlahnya']['45sampai59'] = $b['det']['jumlahnya']['45sampai59'] + 1;
                } else {
                    $b['det']['jumlahnya']['45sampai59'] = 1;
                }
            }

            //Lebih dari 61
            if ($y > 61) {
                if (isset($b['det']['jumlahnya']['lebih61'])) {
                    $b['det']['jumlahnya']['lebih61'] = $b['det']['jumlahnya']['lebih61'] + 1;
                } else {
                    $b['det']['jumlahnya']['lebih61'] = 1;
                }
            }

            //Berdasarkan Jenis Kelamin
            $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
            $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;

            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI) {
                if (isset($b['det']["$laki"]['jumlah'])) {
                    $b['det']["$laki"]['jumlah'] = $b['det']["$laki"]['jumlah'] + 1;
                } else {
                    $b['det']["$laki"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b['det']["$laki"]['umur<18'])) {
                        $b['det']["$laki"]['umur<18'] = $b['det']["$laki"]['umur<18'] + 1;
                    } else {
                        $b['det']["$laki"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b['det']["$laki"]['18sampai24'])) {
                        $b['det']["$laki"]['18sampai24'] = $b['det']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b['det']["$laki"]['18sampai24'] = 1;
                    }
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b['det']["$laki"]['25sampai44'])) {
                        $b['det']["$laki"]['25sampai44'] = $b['det']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b['det']["$laki"]['25sampai44'] = 1;
                    }
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b['det']["$laki"]['45sampai59'])) {
                        $b['det']["$laki"]['45sampai59'] = $b['det']["$laki"]['45sampai59'] + 1;
                    } else {
                        $b['det']["$laki"]['45sampai59'] = 1;
                    }
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b['det']["$laki"]['lebih61'])) {
                        $b['det']["$laki"]['lebih61'] = $b['det']["$laki"]['lebih61'] + 1;
                    } else {
                        $b['det']["$laki"]['lebih61'] = 1;
                    }
                }
            }
            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN) {
                if (isset($b['det']["$perempuan"]['jumlah'])) {
                    $b['det']["$perempuan"]['jumlah'] = $b['det']["$perempuan"]['jumlah'] + 1;
                } else {
                    $b['det']["$perempuan"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b['det']["$perempuan"]['umur<18'])) {
                        $b['det']["$perempuan"]['umur<18'] = $b['det']["$perempuan"]['umur<18'] + 1;
                    } else {
                        $b['det']["$perempuan"]['umur<18'] = 1;
                    }
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b['det']["$perempuan"]['18sampai24'])) {
                        $b['det']["$perempuan"]['18sampai24'] = $b['det']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b['det']["$perempuan"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b['det']["$perempuan"]['25sampai44'])) {
                        $b['det']["$perempuan"]['25sampai44'] = $b['det']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b['det']["$perempuan"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b['det']["$perempuan"]['45sampai59'])) {
                        $b['det']["$perempuan"]['45sampai59'] = $b['det']["$perempuan"]['45sampai59'] + 1;
                    } else {
                        $b['det']["$perempuan"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b['det']["$perempuan"]['lebih61'])) {
                        $b['det']["$perempuan"]['lebih61'] = $b['det']["$perempuan"]['lebih61'] + 1;
                    } else {
                        $b['det']["$perempuan"]['lebih61'] = 1;
                    }
                }
            }

            //Berdasarkan Jenis Donor
            $skrl = 'Sukarela';
            $al = 'Autologus';
            $pggt = 'Pengganti';
            if ($hasil->jenisdonor == 'Sukarela') {
                if (isset($b['det']["$skrl"]['jumlah'])) {
                    $b['det']["$skrl"]['jumlah'] = $b['det']["$skrl"]['jumlah'] + 1;
                } else {
                    $b['det']["$skrl"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b['det']["$skrl"]['umur<18'])) {
                        $b['det']["$skrl"]['umur<18'] = $b['det']["$skrl"]['umur<18'] + 1;
                    } else {
                        $b['det']["$skrl"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b['det']["$skrl"]['18sampai24'])) {
                        $b['det']["$skrl"]['18sampai24'] = $b['det']["$skrl"]['18sampai24'] + 1;
                    } else {
                        $b['det']["$skrl"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b['det']["$skrl"]['25sampai44'])) {
                        $b['det']["$skrl"]['25sampai44'] = $b['det']["$skrl"]['25sampai44'] + 1;
                    } else {
                        $b['det']["$skrl"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b['det']["$skrl"]['45sampai59'])) {
                        $b['det']["$skrl"]['45sampai59'] = $b['det']["$skrl"]['45sampai59'] + 1;
                    } else {
                        $b['det']["$skrl"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b['det']["$skrl"]['lebih61'])) {
                        $b['det']["$skrl"]['lebih61'] = $b['det']["$skrl"]['lebih61'] + 1;
                    } else {
                        $b['det']["$skrl"]['lebih61'] = 1;
                    }
                }
            }
            if ($hasil->jenisdonor == 'Autologus') {
                if (isset($b['det']["$al"]['jumlah'])) {
                    $b['det']["$al"]['jumlah'] = $b['det']["$al"]['jumlah'] + 1;
                } else {
                    $b['det']["$al"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b['det']["$al"]['umur<18'])) {
                        $b['det']["$al"]['umur<18'] = $b['det']["$al"]['umur<18'] + 1;
                    } else {
                        $b['det']["$al"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b['det']["$al"]['18sampai24'])) {
                        $b['det']["$al"]['18sampai24'] = $b['det']["$al"]['18sampai24'] + 1;
                    } else {
                        $b['det']["$al"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b['det']["$al"]['25sampai44'])) {
                        $b['det']["$al"]['25sampai44'] = $b['det']["$al"]['25sampai44'] + 1;
                    } else {
                        $b['det']["$al"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b['det']["$al"]['45sampai59'])) {
                        $b['det']["$al"]['45sampai59'] = $b['det']["$al"]['45sampai59'] + 1;
                    } else {
                        $b['det']["$al"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b['det']["$al"]['lebih61'])) {
                        $b['det']["$al"]['lebih61'] = $b['det']["$al"]['lebih61'] + 1;
                    } else {
                        $b['det']["$al"]['lebih61'] = 1;
                    }
                }
            }
            if ($hasil->jenisdonor == 'Pengganti') {
                if (isset($b['det']["$pggt"]['jumlah'])) {
                    $b['det']["$pggt"]['jumlah'] = $b['det']["$pggt"]['jumlah'] + 1;
                } else {
                    $b['det']["$pggt"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b['det']["$pggt"]['umur<18'])) {
                        $b['det']["$pggt"]['umur<18'] = $b['det']["$pggt"]['umur<18'] + 1;
                    } else {
                        $b['det']["$pggt"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b['det']["$pggt"]['18sampai24'])) {
                        $b['det']["$pggt"]['18sampai24'] = $b['det']["$pggt"]['18sampai24'] + 1;
                    } else {
                        $b['det']["$pggt"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b['det']["$pggt"]['25sampai44'])) {
                        $b['det']["$pggt"]['25sampai44'] = $b['det']["$pggt"]['25sampai44'] + 1;
                    } else {
                        $b['det']["$pggt"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b['det']["$pggt"]['45sampai59'])) {
                        $b['det']["$pggt"]['45sampai59'] = $b['det']["$pggt"]['45sampai59'] + 1;
                    } else {
                        $b['det']["$pggt"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b['det']["$pggt"]['lebih61'])) {
                        $b['det']["$pggt"]['lebih61'] = $b['det']["$pggt"]['lebih61'] + 1;
                    } else {
                        $b['det']["$pggt"]['lebih61'] = 1;
                    }
                }
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modShow2' => $modShow2,
            'b' => $b,
        ));
    }

    /**
     * Digunakan untuk cetak laporan jumlan pendonor
     */
    public function actionPrint() {
        $criteria = new CDbCriteria();
        $model = new LaporanpermenkesjumlahpendonorV('searchPrint');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Penyadapan Darah';

        if (isset($_GET['LaporanpermenkesjumlahpendonorV'])) {
            $model->attributes = $_GET['LaporanpermenkesjumlahpendonorV'];
            $model->jns_periode = $_GET['LaporanpermenkesjumlahpendonorV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LaporanpermenkesjumlahpendonorV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporanpermenkesjumlahpendonorV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LaporanpermenkesjumlahpendonorV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LaporanpermenkesjumlahpendonorV']['bln_akhir']);
            $model->thn_awal = $_GET['LaporanpermenkesjumlahpendonorV']['thn_awal'];
            $model->thn_akhir = $_GET['LaporanpermenkesjumlahpendonorV']['thn_akhir'];
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
            $model->tgl_awal = $model->tgl_awal . " 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
        }


        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $model->tgl_awal, $model->tgl_akhir);
        $criteria->addCondition("donasi_ke > 0");
        $modShow2 = LaporanpermenkesjumlahpendonorV::model()->findAll($criteria);

        $b = array();
        foreach ($modShow2 as $hasil) {
            $kelompok_umur = $hasil->kelompok_umur;
            $y = $hasil->seleksi_umur;

            // Jumlah keseluruhan
            if (isset($b['det']['jumlahnya']['jumlah'])) {
                $b['det']['jumlahnya']['jumlah'] = $b['det']['jumlahnya']['jumlah'] + 1;
            } else {
                $b['det']['jumlahnya']['jumlah'] = 1;
            }

            //Kurang < 18
            if ($y < 18) {
                if (isset($b['det']['jumlahnya']['umur<18'])) {
                    $b['det']['jumlahnya']['umur<18'] = $b['det']['jumlahnya']['umur<18'] + 1;
                } else {
                    $b['det']['jumlahnya']['umur<18'] = 1;
                }
            }

            //18 - 24
            if ($y >= 18 && $y <= 24) {
                if (isset($b['det']['jumlahnya']['18sampai24'])) {
                    $b['det']['jumlahnya']['18sampai24'] = $b['det']['jumlahnya']['18sampai24'] + 1;
                } else {
                    $b['det']['jumlahnya']['18sampai24'] = 1;
                }
            }

            //25 - 44
            if ($y >= 25 && $y <= 44) {
                if (isset($b['det']['jumlahnya']['25sampai44'])) {
                    $b['det']['jumlahnya']['25sampai44'] = $b['det']['jumlahnya']['25sampai44'] + 1;
                } else {
                    $b['det']['jumlahnya']['25sampai44'] = 1;
                }
            }

            //45 - 59
            if ($y >= 45 && $y <= 59) {
                if (isset($b['det']['jumlahnya']['45sampai59'])) {
                    $b['det']['jumlahnya']['45sampai59'] = $b['det']['jumlahnya']['45sampai59'] + 1;
                } else {
                    $b['det']['jumlahnya']['45sampai59'] = 1;
                }
            }

            //Lebih dari 61
            if ($y > 61) {
                if (isset($b['det']['jumlahnya']['lebih61'])) {
                    $b['det']['jumlahnya']['lebih61'] = $b['det']['jumlahnya']['lebih61'] + 1;
                } else {
                    $b['det']['jumlahnya']['lebih61'] = 1;
                }
            }

            //Berdasarkan Jenis Kelamin
            $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
            $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;

            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI) {
                if (isset($b['det']["$laki"]['jumlah'])) {
                    $b['det']["$laki"]['jumlah'] = $b['det']["$laki"]['jumlah'] + 1;
                } else {
                    $b['det']["$laki"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b['det']["$laki"]['umur<18'])) {
                        $b['det']["$laki"]['umur<18'] = $b['det']["$laki"]['umur<18'] + 1;
                    } else {
                        $b['det']["$laki"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b['det']["$laki"]['18sampai24'])) {
                        $b['det']["$laki"]['18sampai24'] = $b['det']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b['det']["$laki"]['18sampai24'] = 1;
                    }
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b['det']["$laki"]['25sampai44'])) {
                        $b['det']["$laki"]['25sampai44'] = $b['det']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b['det']["$laki"]['25sampai44'] = 1;
                    }
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b['det']["$laki"]['45sampai59'])) {
                        $b['det']["$laki"]['45sampai59'] = $b['det']["$laki"]['45sampai59'] + 1;
                    } else {
                        $b['det']["$laki"]['45sampai59'] = 1;
                    }
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b['det']["$laki"]['lebih61'])) {
                        $b['det']["$laki"]['lebih61'] = $b['det']["$laki"]['lebih61'] + 1;
                    } else {
                        $b['det']["$laki"]['lebih61'] = 1;
                    }
                }
            }
            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN) {
                if (isset($b['det']["$perempuan"]['jumlah'])) {
                    $b['det']["$perempuan"]['jumlah'] = $b['det']["$perempuan"]['jumlah'] + 1;
                } else {
                    $b['det']["$perempuan"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b['det']["$perempuan"]['umur<18'])) {
                        $b['det']["$perempuan"]['umur<18'] = $b['det']["$perempuan"]['umur<18'] + 1;
                    } else {
                        $b['det']["$perempuan"]['umur<18'] = 1;
                    }
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b['det']["$perempuan"]['18sampai24'])) {
                        $b['det']["$perempuan"]['18sampai24'] = $b['det']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b['det']["$perempuan"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b['det']["$perempuan"]['25sampai44'])) {
                        $b['det']["$perempuan"]['25sampai44'] = $b['det']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b['det']["$perempuan"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b['det']["$perempuan"]['45sampai59'])) {
                        $b['det']["$perempuan"]['45sampai59'] = $b['det']["$perempuan"]['45sampai59'] + 1;
                    } else {
                        $b['det']["$perempuan"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b['det']["$perempuan"]['lebih61'])) {
                        $b['det']["$perempuan"]['lebih61'] = $b['det']["$perempuan"]['lebih61'] + 1;
                    } else {
                        $b['det']["$perempuan"]['lebih61'] = 1;
                    }
                }
            }

            //Berdasarkan Jenis Donor
            $skrl = 'Sukarela';
            $al = 'Autologus';
            $pggt = 'Pengganti';
            if ($hasil->jenisdonor == 'Sukarela') {
                if (isset($b['det']["$skrl"]['jumlah'])) {
                    $b['det']["$skrl"]['jumlah'] = $b['det']["$skrl"]['jumlah'] + 1;
                } else {
                    $b['det']["$skrl"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b['det']["$skrl"]['umur<18'])) {
                        $b['det']["$skrl"]['umur<18'] = $b['det']["$skrl"]['umur<18'] + 1;
                    } else {
                        $b['det']["$skrl"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b['det']["$skrl"]['18sampai24'])) {
                        $b['det']["$skrl"]['18sampai24'] = $b['det']["$skrl"]['18sampai24'] + 1;
                    } else {
                        $b['det']["$skrl"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b['det']["$skrl"]['25sampai44'])) {
                        $b['det']["$skrl"]['25sampai44'] = $b['det']["$skrl"]['25sampai44'] + 1;
                    } else {
                        $b['det']["$skrl"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b['det']["$skrl"]['45sampai59'])) {
                        $b['det']["$skrl"]['45sampai59'] = $b['det']["$skrl"]['45sampai59'] + 1;
                    } else {
                        $b['det']["$skrl"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b['det']["$skrl"]['lebih61'])) {
                        $b['det']["$skrl"]['lebih61'] = $b['det']["$skrl"]['lebih61'] + 1;
                    } else {
                        $b['det']["$skrl"]['lebih61'] = 1;
                    }
                }
            }
            if ($hasil->jenisdonor == 'Autologus') {
                if (isset($b['det']["$al"]['jumlah'])) {
                    $b['det']["$al"]['jumlah'] = $b['det']["$al"]['jumlah'] + 1;
                } else {
                    $b['det']["$al"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b['det']["$al"]['umur<18'])) {
                        $b['det']["$al"]['umur<18'] = $b['det']["$al"]['umur<18'] + 1;
                    } else {
                        $b['det']["$al"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b['det']["$al"]['18sampai24'])) {
                        $b['det']["$al"]['18sampai24'] = $b['det']["$al"]['18sampai24'] + 1;
                    } else {
                        $b['det']["$al"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b['det']["$al"]['25sampai44'])) {
                        $b['det']["$al"]['25sampai44'] = $b['det']["$al"]['25sampai44'] + 1;
                    } else {
                        $b['det']["$al"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b['det']["$al"]['45sampai59'])) {
                        $b['det']["$al"]['45sampai59'] = $b['det']["$al"]['45sampai59'] + 1;
                    } else {
                        $b['det']["$al"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b['det']["$al"]['lebih61'])) {
                        $b['det']["$al"]['lebih61'] = $b['det']["$al"]['lebih61'] + 1;
                    } else {
                        $b['det']["$al"]['lebih61'] = 1;
                    }
                }
            }
            if ($hasil->jenisdonor == 'Pengganti') {
                if (isset($b['det']["$pggt"]['jumlah'])) {
                    $b['det']["$pggt"]['jumlah'] = $b['det']["$pggt"]['jumlah'] + 1;
                } else {
                    $b['det']["$pggt"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b['det']["$pggt"]['umur<18'])) {
                        $b['det']["$pggt"]['umur<18'] = $b['det']["$pggt"]['umur<18'] + 1;
                    } else {
                        $b['det']["$pggt"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b['det']["$pggt"]['18sampai24'])) {
                        $b['det']["$pggt"]['18sampai24'] = $b['det']["$pggt"]['18sampai24'] + 1;
                    } else {
                        $b['det']["$pggt"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b['det']["$pggt"]['25sampai44'])) {
                        $b['det']["$pggt"]['25sampai44'] = $b['det']["$pggt"]['25sampai44'] + 1;
                    } else {
                        $b['det']["$pggt"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b['det']["$pggt"]['45sampai59'])) {
                        $b['det']["$pggt"]['45sampai59'] = $b['det']["$pggt"]['45sampai59'] + 1;
                    } else {
                        $b['det']["$pggt"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b['det']["$pggt"]['lebih61'])) {
                        $b['det']["$pggt"]['lebih61'] = $b['det']["$pggt"]['lebih61'] + 1;
                    } else {
                        $b['det']["$pggt"]['lebih61'] = 1;
                    }
                }
            }
        }

        $caraPrint = $_GET['caraPrint'];
        $target = $this->path_view . '_print';

        $arr = array('b' => $b);

        $this->printFunction($model, $caraPrint, $judulLaporan, $target, '', $arr);
    }

    /**
     * Fungsi print 
     * 
     * @param type $model
     * @param type $caraPrint
     * @param type $judulLaporan
     * @param type $target
     * @param type $tab
     * @param type $variabel
     */
    protected function printFunction($model, $caraPrint, $judulLaporan, $target, $tab = 'rs', $variabel = array()) {
        $format = new MyFormatter();
        $periode = date('d M Y',strtotime($model->tgl_awal)) . ' s/d ' . date('d M Y',strtotime($model->tgl_akhir));
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows3';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($caraPrint == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
//            $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'colspan' => 10), true));
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI_LANDSCAPE, '', '', '', '', 20, 20, 20, 30, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
