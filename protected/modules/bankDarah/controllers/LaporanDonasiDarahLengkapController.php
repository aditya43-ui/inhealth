<?php

/**
 * Controller untuk Laporan Donasi Donor Darah Lengkap
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 */
class LaporanDonasiDarahLengkapController extends MyAuthController {

    public $path_view = 'bankDarah.views.laporan.donasiDarahLengkap.';

    /**
     * Halaman index 
     */
    public function actionIndex() {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $criteria = new CDbCriteria();
        $criteria3 = new CDbCriteria();
        $criteria4 = new CDbCriteria();
        $model = new LaporanpermenkesbankdarahV();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['LaporanpermenkesbankdarahV'])) {
            $model->attributes = $_GET['LaporanpermenkesbankdarahV'];
            $model->jns_periode = $_GET['LaporanpermenkesbankdarahV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LaporanpermenkesbankdarahV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporanpermenkesbankdarahV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LaporanpermenkesbankdarahV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LaporanpermenkesbankdarahV']['bln_akhir']);
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
        $modShow2 = LaporanpermenkesbankdarahV::model()->findAll($criteria);

        //Grouping
        $criteria->group = 'kelompok_umur';
        $criteria->select = 'distinct(kelompok_umur)';
        $criteria->limit = 10;
        $criteria->offset = !empty($_GET['page']) ? $_GET['page'] + 8 : 0;
        $criteria->addCondition("bataldonordarah IS NULL"); 
        //Cari Data
        $modShow = LaporanpermenkesbankdarahV::model()->findAll($criteria);
        $count = LaporanpermenkesbankdarahV::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $criteria3->group = 'gagal_seleksi';
        $criteria3->select = 'gagal_seleksi';
        $criteria3->order = 'gagal_seleksi ASC';
        $modShow3 = LaporanpermenkesbankdarahV::model()->findAll($criteria3);

        $b = array();
        foreach ($modShow2 as $hasil) {
            $kelompok_umur = $hasil->kelompok_umur;

            // Jumlah keseluruhan
            if (!empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']['jumlahnya']['jumlah'])) {
                    $b['det']['jumlahnya']['jumlah'] = $b['det']['jumlahnya']['jumlah'] + 1;
                } else {
                    $b['det']['jumlahnya']['jumlah'] = 1;
                }
            }

            //Kurang dari 18
            if ($kelompok_umur == 'kelompok_18' && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b["$kelompok_umur"]['det']['umur<18'])) {
                    $b["$kelompok_umur"]['det']['umur<18'] = $b["$kelompok_umur"]['det']['umur<18'] + 1;
                } else {
                    $b["$kelompok_umur"]['det']['umur<18'] = 1;
                }
            }

            //18 - 24
            if ($kelompok_umur == 'kelompok_24' && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b["$kelompok_umur"]['det']['18sampai24'])) {
                    $b["$kelompok_umur"]['det']['18sampai24'] = $b["$kelompok_umur"]['det']['18sampai24'] + 1;
                } else {
                    $b["$kelompok_umur"]['det']['18sampai24'] = 1;
                }
            }

            //25 - 44
            if ($kelompok_umur == 'kelompok_44' && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b["$kelompok_umur"]['det']['25sampai44'])) {
                    $b["$kelompok_umur"]['det']['25sampai44'] = $b["$kelompok_umur"]['det']['25sampai44'] + 1;
                } else {
                    $b["$kelompok_umur"]['det']['25sampai44'] = 1;
                }
            }

            //45 - 59 
            if ($kelompok_umur == 'kelompok_59' && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b["$kelompok_umur"]['det']['45sampai59'])) {
                    $b["$kelompok_umur"]['det']['45sampai59'] = $b["$kelompok_umur"]['det']['45sampai59'] + 1;
                } else {
                    $b["$kelompok_umur"]['det']['45sampai59'] = 1;
                }
            }

            //> 60
            if ($kelompok_umur == 'kelompok_60' && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b["$kelompok_umur"]['det']['lebih61'])) {
                    $b["$kelompok_umur"]['det']['lebih61'] = $b["$kelompok_umur"]['det']['lebih61'] + 1;
                } else {
                    $b["$kelompok_umur"]['det']['lebih61'] = 1;
                }
            }


            //Berdasarkan Jenis Kelamin
            $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
            $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;

            // Jenis Kelamin Laki-laki
            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$laki"]['jumlah'])) {
                    $b['det']["$laki"]['jumlah'] = $b['det']["$laki"]['jumlah'] + 1;
                } else {
                    $b['det']["$laki"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$laki"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$laki"]['umur<18'] = $b["$kelompok_umur"]['det']["$laki"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$laki"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$laki"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$laki"]['18sampai24'] = $b["$kelompok_umur"]['det']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$laki"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$laki"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$laki"]['25sampai44'] = $b["$kelompok_umur"]['det']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$laki"]['25sampai44'] = 1;
                    }
                }

                //44 - 59 
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$laki"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$laki"]['45sampai59'] = $b["$kelompok_umur"]['det']["$laki"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$laki"]['45sampai59'] = 1;
                    }
                }

                //> 61 
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$laki"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$laki"]['lebih61'] = $b["$kelompok_umur"]['det']["$laki"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$laki"]['lebih61'] = 1;
                    }
                }
            }

            // Jenis Kelamin Perempuan 
            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$perempuan"]['jumlah'])) {
                    $b['det']["$perempuan"]['jumlah'] = $b['det']["$perempuan"]['jumlah'] + 1;
                } else {
                    $b['det']["$perempuan"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$perempuan"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$perempuan"]['umur<18'] = $b["$kelompok_umur"]['det']["$perempuan"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$perempuan"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$perempuan"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$perempuan"]['18sampai24'] = $b["$kelompok_umur"]['det']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$perempuan"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$perempuan"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$perempuan"]['25sampai44'] = $b["$kelompok_umur"]['det']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$perempuan"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$perempuan"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$perempuan"]['45sampai59'] = $b["$kelompok_umur"]['det']["$perempuan"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$perempuan"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$perempuan"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$perempuan"]['lebih61'] = $b["$kelompok_umur"]['det']["$perempuan"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$perempuan"]['lebih61'] = 1;
                    }
                }
            }

            $gol_a = 'A';
            $a_positif = 'a_positif';
            $a_negatif = 'a_negatif';
            $gol_b = 'B';
            $b_positif = 'b_positif';
            $b_negatif = 'b_negatif';
            $gol_o = 'O';
            $gol_ab = 'AB';
            $o_negatif = 'o_negatif';
            $o_positif = 'o_positif';
            $ab_positif = 'ab_positif';
            $ab_negatif = 'ab_negatif';
            $rh_positif = 'Positif';
            $rh_negatif = 'Negatif';

            // Golongan Darah A Positif
            if ($hasil->gol_darah == $gol_a && $hasil->rhesus == $rh_positif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$a_positif"]['jumlah'])) {
                    $b['det']["$a_positif"]['jumlah'] = $b['det']["$a_positif"]['jumlah'] + 1;
                } else {
                    $b['det']["$a_positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$a_positif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$a_positif"]['umur<18'] = $b["$kelompok_umur"]['det']["$a_positif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_positif"]['umur<18'] = 1;
                    }
                }

                //18 -24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$a_positif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$a_positif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$a_positif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_positif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$a_positif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$a_positif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$a_positif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_positif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$a_positif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$a_positif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$a_positif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_positif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$a_positif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$a_positif"]['lebih61'] = $b["$kelompok_umur"]['det']["$a_positif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_positif"]['lebih61'] = 1;
                    }
                }
            }
            // =================== END OF A POSITIF 
            // Golongan darah A Negatif
            if ($hasil->gol_darah == $gol_a && $hasil->rhesus == $rh_negatif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$a_negatif"]['jumlah'])) {
                    $b['det']["$a_negatif"]['jumlah'] = $b['det']["$a_negatif"]['jumlah'] + 1;
                } else {
                    $b['det']["$a_negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$a_negatif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['umur<18'] = $b["$kelompok_umur"]['det']["$a_negatif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$a_negatif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$a_negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$a_negatif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$a_negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$a_negatif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$a_negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$a_negatif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['lebih61'] = $b["$kelompok_umur"]['det']["$a_negatif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF A NEGATIF
            // Golongan darah B Positif
            if ($hasil->gol_darah == $gol_b && $hasil->rhesus == $rh_positif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$b_positif"]['jumlah'])) {
                    $b['det']["$b_positif"]['jumlah'] = $b['det']["$b_positif"]['jumlah'] + 1;
                } else {
                    $b['det']["$b_positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$b_positif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$b_positif"]['umur<18'] = $b["$kelompok_umur"]['det']["$b_positif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$b_positif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$b_positif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$b_positif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_positif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$b_positif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$b_positif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$b_positif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_positif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$b_positif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$b_positif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$b_positif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_positif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$b_positif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$b_positif"]['lebih61'] = $b["$kelompok_umur"]['det']["$b_positif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_positif"]['lebih61'] = 1;
                    }
                }
            }
            // END OF NEGATIF
            // Golongan darah B Negatif
            if ($hasil->gol_darah == $gol_b && $hasil->rhesus == $rh_negatif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$b_negatif"]['jumlah'])) {
                    $b['det']["$b_negatif"]['jumlah'] = $b['det']["$b_negatif"]['jumlah'] + 1;
                } else {
                    $b['det']["$b_negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$b_negatif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['umur<18'] = $b["$kelompok_umur"]['det']["$b_negatif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$b_negatif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$b_negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$b_negatif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$b_negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$b_negatif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$b_negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$b_negatif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['lebih61'] = $b["$kelompok_umur"]['det']["$b_negatif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF B NEGATIF
            // Golongan darah AB Positif
            if ($hasil->gol_darah == $gol_ab && $hasil->rhesus == $rh_positif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$ab_positif"]['jumlah'])) {
                    $b['det']["$ab_positif"]['jumlah'] = $b['det']["$ab_positif"]['jumlah'] + 1;
                } else {
                    $b['det']["$ab_positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_positif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['umur<18'] = $b["$kelompok_umur"]['det']["$ab_positif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_positif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$ab_positif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_positif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$ab_positif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_positif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$ab_positif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_positif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['lebih61'] = $b["$kelompok_umur"]['det']["$ab_positif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF AB POSITIF
            // Golongan darah AB NEGATIF
            if ($hasil->gol_darah == $gol_ab && $hasil->rhesus == $rh_negatif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$ab_negatif"]['jumlah'])) {
                    $b['det']["$ab_negatif"]['jumlah'] = $b['det']["$ab_negatif"]['jumlah'] + 1;
                } else {
                    $b['det']["$ab_negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_negatif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['umur<18'] = $b["$kelompok_umur"]['det']["$ab_negatif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_negatif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$ab_negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_negatif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$ab_negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_negatif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$ab_negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_negatif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['lebih61'] = $b["$kelompok_umur"]['det']["$ab_negatif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF AB NEGATIF
            // Golongan darah O POSITIF
            if ($hasil->gol_darah == $gol_o && $hasil->rhesus == $rh_positif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$o_positif"]['jumlah'])) {
                    $b['det']["$o_positif"]['jumlah'] = $b['det']["$o_positif"]['jumlah'] + 1;
                } else {
                    $b['det']["$o_positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$o_positif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$o_positif"]['umur<18'] = $b["$kelompok_umur"]['det']["$o_positif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$o_positif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$o_positif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$o_positif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_positif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$o_positif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$o_positif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$o_positif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_positif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$o_positif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$o_positif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$o_positif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_positif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$o_positif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$o_positif"]['lebih61'] = $b["$kelompok_umur"]['det']["$o_positif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_positif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF O POSITIF
            // Golongan darah O NEGATIF
            if ($hasil->gol_darah == $gol_o && $hasil->rhesus == $rh_negatif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$o_negatif"]['jumlah'])) {
                    $b['det']["$o_negatif"]['jumlah'] = $b['det']["$o_negatif"]['jumlah'] + 1;
                } else {
                    $b['det']["$o_negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$o_negatif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['umur<18'] = $b["$kelompok_umur"]['det']["$o_negatif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$o_negatif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$o_negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$o_negatif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$o_negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$o_negatif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$o_negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$o_negatif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['lebih61'] = $b["$kelompok_umur"]['det']["$o_negatif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF O NEGATIF
            //Donasi Sukarela Baru 
            $donasi_sukarela_baru = 'donasi_sukerela_baru';
            $donasi_sukarela_ulang = 'donasi_sukerela_ulang';
            $donasi_pengganti = 'donasi_pengganti';
            $donasi_luar_baru = 'donasi_luar_baru';
            $donasi_luar_ulang = 'donasi_luar_ulang';

            // Donor Sukerala Baru di ITD 
            if ($hasil->jenisdonor == Params::DONOR_SUKARELA && $hasil->donasi_ke == 1 && $hasil->ruangan_nama == Params::RUANGAN_NAMA_TRANSFUSI_DARAH && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$donasi_sukarela_baru"]['jumlah'])) {
                    $b['det']["$donasi_sukarela_baru"]['jumlah'] = $b['det']["$donasi_sukarela_baru"]['jumlah'] + 1;
                } else {
                    $b['det']["$donasi_sukarela_baru"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['umur<18'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['18sampai24'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['25sampai44'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['45sampai59'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['lebih61'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['lebih61'] = 1;
                    }
                }
            }
            //  END OF Donor Sukerala Baru di ITD 
            // Donasi Sukarela Ulang di ITD 
            if ($hasil->jenisdonor == Params::DONOR_SUKARELA && $hasil->donasi_ke > 1 && $hasil->ruangan_nama == Params::RUANGAN_NAMA_TRANSFUSI_DARAH && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$donasi_sukarela_ulang"]['jumlah'])) {
                    $b['det']["$donasi_sukarela_ulang"]['jumlah'] = $b['det']["$donasi_sukarela_ulang"]['jumlah'] + 1;
                } else {
                    $b['det']["$donasi_sukarela_ulang"]['jumlah'] = 1;
                }

                // < 18 
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['umur<18'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['18sampai24'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['25sampai44'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['45sampai59'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['lebih61'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['lebih61'] = 1;
                    }
                }
            }
            // END OF Donasi Sukarela Ulang ITD
            // Donasi Pengganti ITD 
            // Tidak ada filter donasi_ke
            if ($hasil->jenisdonor == Params::DONOR_PENGGANTI && $hasil->ruangan_nama == Params::RUANGAN_NAMA_TRANSFUSI_DARAH && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$donasi_pengganti"]['jumlah'])) {
                    $b['det']["$donasi_pengganti"]['jumlah'] = $b['det']["$donasi_pengganti"]['jumlah'] + 1;
                } else {
                    $b['det']["$donasi_pengganti"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_pengganti"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['umur<18'] = $b["$kelompok_umur"]['det']["$donasi_pengganti"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_pengganti"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['18sampai24'] = $b["$kelompok_umur"]['det']["$donasi_pengganti"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_pengganti"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['25sampai44'] = $b["$kelompok_umur"]['det']["$donasi_pengganti"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_pengganti"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['45sampai59'] = $b["$kelompok_umur"]['det']["$donasi_pengganti"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_pengganti"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['lebih61'] = $b["$kelompok_umur"]['det']["$donasi_pengganti"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['lebih61'] = 1;
                    }
                }
            }
            // END OF Donasi Pengganti di ITD
            // Donasi Sukarela Baru Selain ITD
            if ($hasil->jenisdonor == Params::DONOR_SUKARELA && $hasil->donasi_ke == 1 && $hasil->ruangan_nama != Params::RUANGAN_NAMA_TRANSFUSI_DARAH && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$donasi_luar_baru"]['jumlah'])) {
                    $b['det']["$donasi_luar_baru"]['jumlah'] = $b['det']["$donasi_luar_baru"]['jumlah'] + 1;
                } else {
                    $b['det']["$donasi_luar_baru"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['umur<18'] = $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['18sampai24'] = $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['25sampai44'] = $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['45sampai59'] = $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['lebih61'] = $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['lebih61'] = 1;
                    }
                }
            }
            // End of Donasi Sukarela Baru Selain ITD 
            // Donasi Sukarela Ulang Selain ITD
            if ($hasil->jenisdonor == Params::DONOR_SUKARELA && $hasil->donasi_ke > 1 && $hasil->ruangan_nama != Params::RUANGAN_NAMA_TRANSFUSI_DARAH && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$donasi_luar_ulang"]['jumlah'])) {
                    $b['det']["$donasi_luar_ulang"]['jumlah'] = $b['det']["$donasi_luar_ulang"]['jumlah'] + 1;
                } else {
                    $b['det']["$donasi_luar_ulang"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['umur<18'] = $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['18sampai24'] = $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['25sampai44'] = $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['45sampai59'] = $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['lebih61'] = $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['lebih61'] = 1;
                    }
                }
            }
            // END OF DONASI LUAR ULANG SELAIN ITD
            // Alasan Penolakan 
            $hb_rendah = 'hb_rendah';
            $bb_rendah = 'bb_rendah';
            $medis_hb_17 = 'medis_hb_17';
            $medis_td_rendah = 'medis_td_rendah';
            $medis_tk_tinggi = 'medis_tk_tinggi';
            $medis_bb_lebih = 'medis_bb_lebih';
            $medis_vaksin = 'medis_vaksin';
            $perilakuberesiko = 'perilakuberesiko';
            $riwberpergian = 'riwberpergian';
            $lain_lain = 'lain_lain';

            // BB Rendah
            if ($hasil->is_gagalseleksi == true && $hasil->bb_rendah == true && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$bb_rendah"]['jumlah'])) {
                    $b['det']["$bb_rendah"]['jumlah'] = $b['det']["$bb_rendah"]['jumlah'] + 1;
                } else {
                    $b['det']["$bb_rendah"]['jumlah'] = 1;
                }
            }
            // END OF BB RENDAH
            // HB Rendah
            if ($hasil->is_gagalseleksi == true && $hasil->gagal_seleksi == 'hb_rendah' && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$hb_rendah"]['jumlah'])) {
                    $b['det']["$hb_rendah"]['jumlah'] = $b['det']["$hb_rendah"]['jumlah'] + 1;
                } else {
                    $b['det']["$hb_rendah"]['jumlah'] = 1;
                }
            }
            // END OF HB RENDAH
            // Riwayat Bepergian
            if ($hasil->is_gagalseleksi == true && $hasil->gagal_seleksi == $riwberpergian && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$riwberpergian"]['jumlah'])) {
                    $b['det']["$riwberpergian"]['jumlah'] = $b['det']["$riwberpergian"]['jumlah'] + 1;
                } else {
                    $b['det']["$riwberpergian"]['jumlah'] = 1;
                }
            }
            // END OF Riwayat Bepergian
            // Medis HB 17
            if ($hasil->is_gagalseleksi == true && $hasil->gagal_seleksi == $medis_hb_17 && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$medis_hb_17"]['jumlah'])) {
                    $b['det']["$medis_hb_17"]['jumlah'] = $b['det']["$medis_hb_17"]['jumlah'] + 1;
                } else {
                    $b['det']["$medis_hb_17"]['jumlah'] = 1;
                }
            }
            // END OF Medis HB 17
            // Medis HB 17
            if ($hasil->is_gagalseleksi == true && $hasil->gagal_seleksi == $lain_lain && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$lain_lain"]['jumlah'])) {
                    $b['det']["$lain_lain"]['jumlah'] = $b['det']["$lain_lain"]['jumlah'] + 1;
                } else {
                    $b['det']["$lain_lain"]['jumlah'] = 1;
                }
            }
            // END OF Medis HB 17
            // Perilaku Beresiko
            if ($hasil->is_gagalseleksi == true && $hasil->gagal_seleksi == $perilakuberesiko && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$perilakuberesiko"]['jumlah'])) {
                    $b['det']["$perilakuberesiko"]['jumlah'] = $b['det']["$perilakuberesiko"]['jumlah'] + 1;
                } else {
                    $b['det']["$perilakuberesiko"]['jumlah'] = 1;
                }
            }
            // END OF Perilaku Beresiko       
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modShow' => $modShow,
            'modShow2' => $modShow2,
            'modShow3' => $modShow3,
            'b' => $b,
            'pages' => $pages));
    }

    /**
     * Cetak Laporan Donasi Darah Lengkap
     */
    public function actionPrintDonasiDarahLengkap() {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $criteria = new CDbCriteria();
        $criteria3 = new CDbCriteria();
        $criteria4 = new CDbCriteria();
        $model = new LaporanpermenkesbankdarahV();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Donasi Darah Lengkap';

        //Data Grafik
        $data['title'] = 'Grafik Donasi Darah Lengkap';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
        if (isset($_GET['LaporanpermenkesbankdarahV'])) {
            $model->attributes = $_GET['LaporanpermenkesbankdarahV'];
            $model->jns_periode = $_GET['LaporanpermenkesbankdarahV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LaporanpermenkesbankdarahV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporanpermenkesbankdarahV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LaporanpermenkesbankdarahV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LaporanpermenkesbankdarahV']['bln_akhir']);
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
        $modShow2 = LaporanpermenkesbankdarahV::model()->findAll($criteria);

        //Grouping
        $criteria->group = 'kelompok_umur';
        $criteria->select = 'distinct(kelompok_umur)';
        $criteria->addCondition("bataldonordarah IS NULL"); 
        $criteria->limit = 10;
        $criteria->offset = !empty($_GET['page']) ? $_GET['page'] + 8 : 0;

        //Cari Data
        $modShow = LaporanpermenkesbankdarahV::model()->findAll($criteria);
        $count = LaporanpermenkesbankdarahV::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $criteria3->group = 'gagal_seleksi';
        $criteria3->select = 'gagal_seleksi';
        $criteria3->order = 'gagal_seleksi ASC';
        $modShow3 = LaporanpermenkesbankdarahV::model()->findAll($criteria3);

        $b = array();
        foreach ($modShow2 as $hasil) {
            $kelompok_umur = $hasil->kelompok_umur;

            // Jumlah keseluruhan
            if (!empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']['jumlahnya']['jumlah'])) {
                    $b['det']['jumlahnya']['jumlah'] = $b['det']['jumlahnya']['jumlah'] + 1;
                } else {
                    $b['det']['jumlahnya']['jumlah'] = 1;
                }
            }

            //Kurang dari 18
            if ($kelompok_umur == 'kelompok_18' && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b["$kelompok_umur"]['det']['umur<18'])) {
                    $b["$kelompok_umur"]['det']['umur<18'] = $b["$kelompok_umur"]['det']['umur<18'] + 1;
                } else {
                    $b["$kelompok_umur"]['det']['umur<18'] = 1;
                }
            }

            //18 - 24
            if ($kelompok_umur == 'kelompok_24' && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b["$kelompok_umur"]['det']['18sampai24'])) {
                    $b["$kelompok_umur"]['det']['18sampai24'] = $b["$kelompok_umur"]['det']['18sampai24'] + 1;
                } else {
                    $b["$kelompok_umur"]['det']['18sampai24'] = 1;
                }
            }

            //25 - 44
            if ($kelompok_umur == 'kelompok_44' && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b["$kelompok_umur"]['det']['25sampai44'])) {
                    $b["$kelompok_umur"]['det']['25sampai44'] = $b["$kelompok_umur"]['det']['25sampai44'] + 1;
                } else {
                    $b["$kelompok_umur"]['det']['25sampai44'] = 1;
                }
            }

            //45 - 59 
            if ($kelompok_umur == 'kelompok_59' && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b["$kelompok_umur"]['det']['45sampai59'])) {
                    $b["$kelompok_umur"]['det']['45sampai59'] = $b["$kelompok_umur"]['det']['45sampai59'] + 1;
                } else {
                    $b["$kelompok_umur"]['det']['45sampai59'] = 1;
                }
            }

            //> 60
            if ($kelompok_umur == 'kelompok_60' && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b["$kelompok_umur"]['det']['lebih61'])) {
                    $b["$kelompok_umur"]['det']['lebih61'] = $b["$kelompok_umur"]['det']['lebih61'] + 1;
                } else {
                    $b["$kelompok_umur"]['det']['lebih61'] = 1;
                }
            }


            //Berdasarkan Jenis Kelamin
            $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
            $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;

            // Jenis Kelamin Laki-laki
            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_LAKI_LAKI && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$laki"]['jumlah'])) {
                    $b['det']["$laki"]['jumlah'] = $b['det']["$laki"]['jumlah'] + 1;
                } else {
                    $b['det']["$laki"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$laki"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$laki"]['umur<18'] = $b["$kelompok_umur"]['det']["$laki"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$laki"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$laki"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$laki"]['18sampai24'] = $b["$kelompok_umur"]['det']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$laki"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$laki"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$laki"]['25sampai44'] = $b["$kelompok_umur"]['det']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$laki"]['25sampai44'] = 1;
                    }
                }

                //44 - 59 
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$laki"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$laki"]['45sampai59'] = $b["$kelompok_umur"]['det']["$laki"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$laki"]['45sampai59'] = 1;
                    }
                }

                //> 61 
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$laki"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$laki"]['lebih61'] = $b["$kelompok_umur"]['det']["$laki"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$laki"]['lebih61'] = 1;
                    }
                }
            }

            // Jenis Kelamin Perempuan 
            if ($hasil->jenis_kelamin == Params::JENIS_KELAMIN_PEREMPUAN && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$perempuan"]['jumlah'])) {
                    $b['det']["$perempuan"]['jumlah'] = $b['det']["$perempuan"]['jumlah'] + 1;
                } else {
                    $b['det']["$perempuan"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$perempuan"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$perempuan"]['umur<18'] = $b["$kelompok_umur"]['det']["$perempuan"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$perempuan"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$perempuan"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$perempuan"]['18sampai24'] = $b["$kelompok_umur"]['det']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$perempuan"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$perempuan"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$perempuan"]['25sampai44'] = $b["$kelompok_umur"]['det']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$perempuan"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$perempuan"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$perempuan"]['45sampai59'] = $b["$kelompok_umur"]['det']["$perempuan"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$perempuan"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$perempuan"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$perempuan"]['lebih61'] = $b["$kelompok_umur"]['det']["$perempuan"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$perempuan"]['lebih61'] = 1;
                    }
                }
            }

            $gol_a = 'A';
            $a_positif = 'a_positif';
            $a_negatif = 'a_negatif';
            $gol_b = 'B';
            $b_positif = 'b_positif';
            $b_negatif = 'b_negatif';
            $gol_o = 'O';
            $gol_ab = 'AB';
            $o_negatif = 'o_negatif';
            $o_positif = 'o_positif';
            $ab_positif = 'ab_positif';
            $ab_negatif = 'ab_negatif';
            $rh_positif = 'Positif';
            $rh_negatif = 'Negatif';

            // Golongan Darah A Positif
            if ($hasil->gol_darah == $gol_a && $hasil->rhesus == $rh_positif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$a_positif"]['jumlah'])) {
                    $b['det']["$a_positif"]['jumlah'] = $b['det']["$a_positif"]['jumlah'] + 1;
                } else {
                    $b['det']["$a_positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$a_positif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$a_positif"]['umur<18'] = $b["$kelompok_umur"]['det']["$a_positif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_positif"]['umur<18'] = 1;
                    }
                }

                //18 -24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$a_positif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$a_positif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$a_positif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_positif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$a_positif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$a_positif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$a_positif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_positif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$a_positif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$a_positif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$a_positif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_positif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$a_positif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$a_positif"]['lebih61'] = $b["$kelompok_umur"]['det']["$a_positif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_positif"]['lebih61'] = 1;
                    }
                }
            }
            // =================== END OF A POSITIF 
            // Golongan darah A Negatif
            if ($hasil->gol_darah == $gol_a && $hasil->rhesus == $rh_negatif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$a_negatif"]['jumlah'])) {
                    $b['det']["$a_negatif"]['jumlah'] = $b['det']["$a_negatif"]['jumlah'] + 1;
                } else {
                    $b['det']["$a_negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$a_negatif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['umur<18'] = $b["$kelompok_umur"]['det']["$a_negatif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$a_negatif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$a_negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$a_negatif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$a_negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$a_negatif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$a_negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$a_negatif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['lebih61'] = $b["$kelompok_umur"]['det']["$a_negatif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$a_negatif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF A NEGATIF
            // Golongan darah B Positif
            if ($hasil->gol_darah == $gol_b && $hasil->rhesus == $rh_positif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$b_positif"]['jumlah'])) {
                    $b['det']["$b_positif"]['jumlah'] = $b['det']["$b_positif"]['jumlah'] + 1;
                } else {
                    $b['det']["$b_positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$b_positif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$b_positif"]['umur<18'] = $b["$kelompok_umur"]['det']["$b_positif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$b_positif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$b_positif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$b_positif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_positif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$b_positif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$b_positif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$b_positif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_positif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$b_positif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$b_positif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$b_positif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_positif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$b_positif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$b_positif"]['lebih61'] = $b["$kelompok_umur"]['det']["$b_positif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_positif"]['lebih61'] = 1;
                    }
                }
            }
            // END OF NEGATIF
            // Golongan darah B Negatif
            if ($hasil->gol_darah == $gol_b && $hasil->rhesus == $rh_negatif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$b_negatif"]['jumlah'])) {
                    $b['det']["$b_negatif"]['jumlah'] = $b['det']["$b_negatif"]['jumlah'] + 1;
                } else {
                    $b['det']["$b_negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$b_negatif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['umur<18'] = $b["$kelompok_umur"]['det']["$b_negatif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$b_negatif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$b_negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$b_negatif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$b_negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$b_negatif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$b_negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$b_negatif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['lebih61'] = $b["$kelompok_umur"]['det']["$b_negatif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$b_negatif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF B NEGATIF
            // Golongan darah AB Positif
            if ($hasil->gol_darah == $gol_ab && $hasil->rhesus == $rh_positif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$ab_positif"]['jumlah'])) {
                    $b['det']["$ab_positif"]['jumlah'] = $b['det']["$ab_positif"]['jumlah'] + 1;
                } else {
                    $b['det']["$ab_positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_positif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['umur<18'] = $b["$kelompok_umur"]['det']["$ab_positif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_positif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$ab_positif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_positif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$ab_positif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_positif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$ab_positif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_positif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['lebih61'] = $b["$kelompok_umur"]['det']["$ab_positif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_positif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF AB POSITIF
            // Golongan darah AB NEGATIF
            if ($hasil->gol_darah == $gol_ab && $hasil->rhesus == $rh_negatif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$ab_negatif"]['jumlah'])) {
                    $b['det']["$ab_negatif"]['jumlah'] = $b['det']["$ab_negatif"]['jumlah'] + 1;
                } else {
                    $b['det']["$ab_negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_negatif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['umur<18'] = $b["$kelompok_umur"]['det']["$ab_negatif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_negatif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$ab_negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_negatif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$ab_negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_negatif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$ab_negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$ab_negatif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['lebih61'] = $b["$kelompok_umur"]['det']["$ab_negatif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$ab_negatif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF AB NEGATIF
            // Golongan darah O POSITIF
            if ($hasil->gol_darah == $gol_o && $hasil->rhesus == $rh_positif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$o_positif"]['jumlah'])) {
                    $b['det']["$o_positif"]['jumlah'] = $b['det']["$o_positif"]['jumlah'] + 1;
                } else {
                    $b['det']["$o_positif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$o_positif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$o_positif"]['umur<18'] = $b["$kelompok_umur"]['det']["$o_positif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_positif"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$o_positif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$o_positif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$o_positif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_positif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$o_positif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$o_positif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$o_positif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_positif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$o_positif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$o_positif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$o_positif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_positif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$o_positif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$o_positif"]['lebih61'] = $b["$kelompok_umur"]['det']["$o_positif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_positif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF O POSITIF
            // Golongan darah O NEGATIF
            if ($hasil->gol_darah == $gol_o && $hasil->rhesus == $rh_negatif && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$o_negatif"]['jumlah'])) {
                    $b['det']["$o_negatif"]['jumlah'] = $b['det']["$o_negatif"]['jumlah'] + 1;
                } else {
                    $b['det']["$o_negatif"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$o_negatif"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['umur<18'] = $b["$kelompok_umur"]['det']["$o_negatif"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$o_negatif"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['18sampai24'] = $b["$kelompok_umur"]['det']["$o_negatif"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$o_negatif"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['25sampai44'] = $b["$kelompok_umur"]['det']["$o_negatif"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$o_negatif"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['45sampai59'] = $b["$kelompok_umur"]['det']["$o_negatif"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$o_negatif"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['lebih61'] = $b["$kelompok_umur"]['det']["$o_negatif"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$o_negatif"]['lebih61'] = 1;
                    }
                }
            }
            // ===================== END OF O NEGATIF
            //Donasi Sukarela Baru 
            $donasi_sukarela_baru = 'donasi_sukerela_baru';
            $donasi_sukarela_ulang = 'donasi_sukerela_ulang';
            $donasi_pengganti = 'donasi_pengganti';
            $donasi_luar_baru = 'donasi_luar_baru';
            $donasi_luar_ulang = 'donasi_luar_ulang';

            // Donor Sukerala Baru di ITD 
            if ($hasil->jenisdonor == Params::DONOR_SUKARELA && $hasil->donasi_ke == 1 && $hasil->ruangan_nama == Params::RUANGAN_NAMA_TRANSFUSI_DARAH && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$donasi_sukarela_baru"]['jumlah'])) {
                    $b['det']["$donasi_sukarela_baru"]['jumlah'] = $b['det']["$donasi_sukarela_baru"]['jumlah'] + 1;
                } else {
                    $b['det']["$donasi_sukarela_baru"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['umur<18'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['18sampai24'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['25sampai44'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['45sampai59'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['lebih61'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_baru"]['lebih61'] = 1;
                    }
                }
            }
            //  END OF Donor Sukerala Baru di ITD 
            // Donasi Sukarela Ulang di ITD 
            if ($hasil->jenisdonor == Params::DONOR_SUKARELA && $hasil->donasi_ke > 1 && $hasil->ruangan_nama == Params::RUANGAN_NAMA_TRANSFUSI_DARAH && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$donasi_sukarela_ulang"]['jumlah'])) {
                    $b['det']["$donasi_sukarela_ulang"]['jumlah'] = $b['det']["$donasi_sukarela_ulang"]['jumlah'] + 1;
                } else {
                    $b['det']["$donasi_sukarela_ulang"]['jumlah'] = 1;
                }

                // < 18 
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['umur<18'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['18sampai24'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['25sampai44'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['45sampai59'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['lebih61'] = $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_sukarela_ulang"]['lebih61'] = 1;
                    }
                }
            }
            // END OF Donasi Sukarela Ulang ITD
            // Donasi Pengganti ITD 
            // Tidak ada filter donasi_ke
            if ($hasil->jenisdonor == Params::DONOR_PENGGANTI && $hasil->ruangan_nama == Params::RUANGAN_NAMA_TRANSFUSI_DARAH && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$donasi_pengganti"]['jumlah'])) {
                    $b['det']["$donasi_pengganti"]['jumlah'] = $b['det']["$donasi_pengganti"]['jumlah'] + 1;
                } else {
                    $b['det']["$donasi_pengganti"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_pengganti"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['umur<18'] = $b["$kelompok_umur"]['det']["$donasi_pengganti"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_pengganti"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['18sampai24'] = $b["$kelompok_umur"]['det']["$donasi_pengganti"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_pengganti"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['25sampai44'] = $b["$kelompok_umur"]['det']["$donasi_pengganti"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_pengganti"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['45sampai59'] = $b["$kelompok_umur"]['det']["$donasi_pengganti"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_pengganti"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['lebih61'] = $b["$kelompok_umur"]['det']["$donasi_pengganti"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_pengganti"]['lebih61'] = 1;
                    }
                }
            }
            // END OF Donasi Pengganti di ITD
            // Donasi Sukarela Baru Selain ITD
            if ($hasil->jenisdonor == Params::DONOR_SUKARELA && $hasil->donasi_ke == 1 && $hasil->ruangan_nama != Params::RUANGAN_NAMA_TRANSFUSI_DARAH && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$donasi_luar_baru"]['jumlah'])) {
                    $b['det']["$donasi_luar_baru"]['jumlah'] = $b['det']["$donasi_luar_baru"]['jumlah'] + 1;
                } else {
                    $b['det']["$donasi_luar_baru"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['umur<18'] = $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['umur<18'] = 1;
                    }
                }

                //18 - 24 
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['18sampai24'] = $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['25sampai44'] = $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['45sampai59'] = $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['lebih61'] = $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_baru"]['lebih61'] = 1;
                    }
                }
            }
            // End of Donasi Sukarela Baru Selain ITD 
            // Donasi Sukarela Ulang Selain ITD
            if ($hasil->jenisdonor == Params::DONOR_SUKARELA && $hasil->donasi_ke > 1 && $hasil->ruangan_nama != Params::RUANGAN_NAMA_TRANSFUSI_DARAH && !empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$donasi_luar_ulang"]['jumlah'])) {
                    $b['det']["$donasi_luar_ulang"]['jumlah'] = $b['det']["$donasi_luar_ulang"]['jumlah'] + 1;
                } else {
                    $b['det']["$donasi_luar_ulang"]['jumlah'] = 1;
                }

                //Kurang < 18
                if ($kelompok_umur == 'kelompok_18') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['umur<18'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['umur<18'] = $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['umur<18'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['umur<18'] = 1;
                    }
                }

                //18 - 24
                if ($kelompok_umur == 'kelompok_24') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['18sampai24'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['18sampai24'] = $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['18sampai24'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['18sampai24'] = 1;
                    }
                }

                // 25 - 44
                if ($kelompok_umur == 'kelompok_44') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['25sampai44'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['25sampai44'] = $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['25sampai44'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['25sampai44'] = 1;
                    }
                }

                // 45 - 59
                if ($kelompok_umur == 'kelompok_59') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['45sampai59'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['45sampai59'] = $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['45sampai59'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['45sampai59'] = 1;
                    }
                }

                // Lebih dari 60
                if ($kelompok_umur == 'kelompok_60') {
                    if (isset($b["$kelompok_umur"]['det']["$donasi_luar_baru"]['lebih61'])) {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['lebih61'] = $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['lebih61'] + 1;
                    } else {
                        $b["$kelompok_umur"]['det']["$donasi_luar_ulang"]['lebih61'] = 1;
                    }
                }
            }
            // END OF DONASI LUAR ULANG SELAIN ITD
            // Alasan Penolakan 
            $hb_rendah = 'hb_rendah';
            $bb_rendah = 'bb_rendah';
            $medis_hb_17 = 'medis_hb_17';
            $medis_td_rendah = 'medis_td_rendah';
            $medis_tk_tinggi = 'medis_tk_tinggi';
            $medis_bb_lebih = 'medis_bb_lebih';
            $medis_vaksin = 'medis_vaksin';
            $perilakuberesiko = 'perilakuberesiko';
            $riwberpergian = 'riwberpergian';
            $lain_lain = 'lain_lain';

            // BB Rendah
            if ($hasil->is_gagalseleksi == true && $hasil->bb_rendah == true && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$bb_rendah"]['jumlah'])) {
                    $b['det']["$bb_rendah"]['jumlah'] = $b['det']["$bb_rendah"]['jumlah'] + 1;
                } else {
                    $b['det']["$bb_rendah"]['jumlah'] = 1;
                }
            }
            // END OF BB RENDAH
            // HB Rendah
            if ($hasil->is_gagalseleksi == true && $hasil->gagal_seleksi == 'hb_rendah' && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$hb_rendah"]['jumlah'])) {
                    $b['det']["$hb_rendah"]['jumlah'] = $b['det']["$hb_rendah"]['jumlah'] + 1;
                } else {
                    $b['det']["$hb_rendah"]['jumlah'] = 1;
                }
            }
            // END OF HB RENDAH
            // Riwayat Bepergian
            if ($hasil->is_gagalseleksi == true && $hasil->gagal_seleksi == $riwberpergian && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$riwberpergian"]['jumlah'])) {
                    $b['det']["$riwberpergian"]['jumlah'] = $b['det']["$riwberpergian"]['jumlah'] + 1;
                } else {
                    $b['det']["$riwberpergian"]['jumlah'] = 1;
                }
            }
            // END OF Riwayat Bepergian
            // Medis HB 17
            if ($hasil->is_gagalseleksi == true && $hasil->gagal_seleksi == $medis_hb_17 && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$medis_hb_17"]['jumlah'])) {
                    $b['det']["$medis_hb_17"]['jumlah'] = $b['det']["$medis_hb_17"]['jumlah'] + 1;
                } else {
                    $b['det']["$medis_hb_17"]['jumlah'] = 1;
                }
            }
            // END OF Medis HB 17
            // Medis HB 17
            if ($hasil->is_gagalseleksi == true && $hasil->gagal_seleksi == $lain_lain && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$lain_lain"]['jumlah'])) {
                    $b['det']["$lain_lain"]['jumlah'] = $b['det']["$lain_lain"]['jumlah'] + 1;
                } else {
                    $b['det']["$lain_lain"]['jumlah'] = 1;
                }
            }
            // END OF Medis HB 17
            // Perilaku Beresiko
            if ($hasil->is_gagalseleksi == true && $hasil->gagal_seleksi == $perilakuberesiko && empty($hasil->nomorbarcode_utama)) {
                if (isset($b['det']["$perilakuberesiko"]['jumlah'])) {
                    $b['det']["$perilakuberesiko"]['jumlah'] = $b['det']["$perilakuberesiko"]['jumlah'] + 1;
                } else {
                    $b['det']["$perilakuberesiko"]['jumlah'] = 1;
                }
            }
            // END OF Perilaku Beresiko 
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view . '_print';

        $arr = array('modShow' => $modShow, 'b' => $b);

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, '', $arr);
    }

    /**
     * Fungsi print 
     * @author Aida Rahmawati <aidarahmawati@.com>
     * 
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
        $periode = date('Y', strtotime($model->tgl_awal));
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows3';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = 'L';                           //Posisi L->Landscape,P->Portait

            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 20, 50, 20, 20, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }
}