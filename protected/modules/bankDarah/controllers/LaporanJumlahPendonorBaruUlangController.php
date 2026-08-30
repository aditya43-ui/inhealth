<?php

/**
 * Controller untuk Laporan Jumlah Pendonor Baru/Ulang
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 */
class LaporanJumlahPendonorBaruUlangController extends MyAuthController {

    public $path_view = 'bankDarah.views.laporan.jumlahPendonorBaruUlang.';

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
        $modShow2 = LaporanpermenkesjumlahpendonorV::model()->findAll($criteria);

        $b = array();
        foreach ($modShow2 as $hasil) {
            $kelompok_umur = $hasil->kelompok_umur;
            $y = $hasil->seleksi_umur;

            //Berdasarkan Donor Ke
            $satu = 1;
            $lebihdarisatu = !1;

            //Berdasarkan Golongan Darah
            $goldarahA = 'A';
            $goldarahB = 'B';
            $goldarahO = 'O';
            $goldarahAB = 'AB';
            
            //Berdasarkan Rhesus
            $Positif = 'Positif';
            $Negatif = 'Negatif';

            if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'A' && strtolower($hasil->rhesus) == 'positif') 
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            }
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'A'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'B'  && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            }
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'B'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'O'  && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'O'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'AB' && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'AB' && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            }
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'A'  && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            }
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'A'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'B'  && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            }
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'B'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'O'  && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'O'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'AB' && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'AB' && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] = 1;
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
        $modShow2 = LaporanpermenkesjumlahpendonorV::model()->findAll($criteria);

        $b = array();
        foreach ($modShow2 as $hasil) {
            $kelompok_umur = $hasil->kelompok_umur;
            $y = $hasil->seleksi_umur;

            //Berdasarkan Donor Ke
            $satu = 1;
            $lebihdarisatu = !1;

            //Berdasarkan Golongan Darah
            $goldarahA = 'A';
            $goldarahB = 'B';
            $goldarahO = 'O';
            $goldarahAB = 'AB';
            
            //Berdasarkan Rhesus
            $Positif = 'Positif';
            $Negatif = 'Negatif';

            if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'A' && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            }
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'A'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] = $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'B'  && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            }
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'B'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] = $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'O'  && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'O'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] = $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'AB' && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke == 1 && $hasil->gol_darah == 'AB' && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] = $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$satu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            }
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'A'  && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            }
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'A'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahA"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'B'  && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            }
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'B'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahB"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'O'  && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'O'  && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahO"]['rhesus']["$Negatif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'AB' && strtolower($hasil->rhesus) == 'positif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Positif"]['lebih61'] = 1;
                    }
                }
            } 
            else if ($hasil->donasi_ke > 1 && $hasil->gol_darah == 'AB' && strtolower($hasil->rhesus) == 'negatif')  
                {
                //Jumlah Semuanya
                if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'])) {
                    $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] + 1;
                } else {
                    $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($y < 18) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($y >= 18 && $y <= 24) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($y >= 25 && $y <= 44) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['25sampai44'] = 1;
                    }
                }

                //45 - 59
                if ($y >= 45 && $y <= 59) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['45sampai59'] = 1;
                    }
                }

                //Lebih dari 61
                if ($y > 61) {
                    if (isset($b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'])) {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] = $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] + 1;
                    } else {
                        $b["$lebihdarisatu"]['det']["$goldarahAB"]['rhesus']["$Negatif"]['lebih61'] = 1;
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
