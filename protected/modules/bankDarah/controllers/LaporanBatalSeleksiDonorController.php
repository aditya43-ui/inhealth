<?php

/**
 * Controller untuk Laporan Batal Seleksi Donor
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 */
class LaporanBatalSeleksiDonorController extends MyAuthController {

    public $path_view = 'bankDarah.views.laporan.batalseleksidonor.';

    /**
     * Halaman index Laporan Batal Seleksi Donor
     */
    public function actionIndex() {
        $format = new MyFormatter();
        $criteria = new CDbCriteria();
        $model = new LaporandonorbatalseleksiV();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['LaporandonorbatalseleksiV'])) {
            $model->attributes = $_GET['LaporandonorbatalseleksiV'];
            $model->jns_periode = $_GET['LaporandonorbatalseleksiV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LaporandonorbatalseleksiV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporandonorbatalseleksiV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LaporandonorbatalseleksiV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LaporandonorbatalseleksiV']['bln_akhir']);
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

        $criteria->addBetweenCondition('DATE(tglseleksidonor)', $model->tgl_awal, $model->tgl_akhir);
        $criteria->order = 'pendonor_id, waktu_pendaftaran ASC';
        $modcek = LaporandonorbatalseleksiV::model()->findAll($criteria);
        $modShow2 = LaporandonorbatalseleksiV::model()->findAll($criteria);
        $no = 0;

        $b = array();
        $previousId = '';
        $jenisdonasi = 'baru';
        foreach ($modShow2 as $hasil) {
            //Berdasarkan Donor Ke
            $baru = 0;
            $lama = 1;

            //Berdasarkan bb_rendah
            $bb_rendah = 'bb_rendah';
            $usia_kurang = 'usia_kurang';
            $hb_rendah = 'hb_rendah';
            $medis_tk_tinggi = 'medis_tk_tinggi';
            $medis_td_rendah = 'medis_td_rendah';
            $minum_obat = 'minum_obat';
            $medis_pasca_op = 'medis_pasca_op';
            $medis_hb_17 = 'medis_hb_17';
            $medis_vaksin = 'medis_vaksin';
            $perilakuberesiko_homo = 'perilakuberesiko_homo';
            $perilakuberesiko_tatto = 'perilakuberesiko_tatto';
            $perilakuberesiko_freesx = 'perilakuberesiko_freesx';
            $perilakuberesiko_penasun = 'perilakuberesiko_penasun';
            $perilakuberesiko_napi = 'perilakuberesiko_napi';
            $riwbepergian_endemik = 'riwbepergian_endemik';
            $riwbepergian_hiv = 'riwbepergian_hiv';
            $riwbepergian_sapigila = 'riwbepergian_sapigila';
            $lain_lain_tdkkembali = 'lain_lain_tdkkembali';
            $lain_lain_donortua = 'lain_lain_donortua';

            //Pertama cari ada data sebelumnya atau tidak. jika ada, maka donasi lama baris 88
            if ($previousId !== '' && $previousId !== $hasil->waktu_pendaftaran) {
                //Cek jika ada baris sebelumnya, dan jika donasi_ke == 0 : baru
                foreach ($modcek as $key => $hasilnya) {
                    if ($hasilnya->pendonor_id == $hasil->pendonor_id && $hasilnya->waktu_pendaftaran == $hasil->waktu_pendaftaran) {
                        //Cek pendonor sebelumnya adalah pendonor saat ini (dia pernah melakukan donor sebelumnya). 
                        if($modcek[$key - 1]->pendonor_id == $hasil->pendonor_id){
                            //Cek donor sebelumnya donasi_ke nya 0 atau != 0. jika 0 maka baru else lama
                            if($modcek[$key - 1]->donasi_ke == 0){
                                $jenisdonasi = 'baru';
                                $no = 0;
                            }else{
                                $jenisdonasi = 'lama';
                                $no++;
                            }
                        }else{
                            $jenisdonasi = 'baru';
                            $no = 0;
                        }
                    }
                }
            } 
            $previousId = $hasil->waktu_pendaftaran;
            
            //Jenis Kelamin
            $laki = strtolower(Params::JENIS_KELAMIN_LAKI_LAKI);
            $perempuan = strtolower(Params::JENIS_KELAMIN_PEREMPUAN);

            if ($jenisdonasi == 'lama' && strtolower($hasil->jenis_kelamin) == $laki) {
                //17
                //17 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] = 1;
                    }
                }
                //17 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] = 1;
                    }
                }

                //18 - 24
                //18 - 24 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                //25 - 44 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] = 1;
                    }
                }

                //45 - 64
                //45 - 64 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] = 1;
                    }
                }

                //Lebih dari 65
                //Lebih dari 65 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] = 1;
                    }
                }
            } else if ($jenisdonasi == 'lama' && strtolower($hasil->jenis_kelamin) == $perempuan) {

                //17
                //17 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] = 1;
                    }
                }

                //18 - 24
                //18 - 24 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                //25 - 44 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] = 1;
                    }
                }

                //45 - 64
                //45 - 64 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] = 1;
                    }
                }

                //Lebih dari 65
                //Lebih dari 65 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] = 1;
                    }
                }
            }
            if ($jenisdonasi == 'baru' && strtolower($hasil->jenis_kelamin) == $laki) {
                //17
                //17 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] = 1;
                    }
                }
                //17 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] = 1;
                    }
                }

                //18 - 24
                //18 - 24 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                //25 - 44 bb_rendah 
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] = 1;
                    }
                }

                //45 - 64
                //45 - 64 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] = 1;
                    }
                }

                //Lebih dari 65
                //Lebih dari 65 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] = 1;
                    }
                }
            } else if ($jenisdonasi == 'baru' && strtolower($hasil->jenis_kelamin) == $perempuan) {

                //17
                //17 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] = 1;
                    }
                }

                //18 - 24
                //18 - 24 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                //25 - 44 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] = 1;
                    }
                }

                //45 - 64
                //45 - 64 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] = 1;
                    }
                }

                //Lebih dari 65
                //Lebih dari 65 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] = 1;
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
        $model = new LaporandonorbatalseleksiV('searchPrint');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'LEMBAR PERHITUNGAN DONOR BATAL DI SELEKSI DONOR';

        if (isset($_GET['LaporandonorbatalseleksiV'])) {
            $model->attributes = $_GET['LaporandonorbatalseleksiV'];
            $model->jns_periode = $_GET['LaporandonorbatalseleksiV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LaporandonorbatalseleksiV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporandonorbatalseleksiV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LaporandonorbatalseleksiV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LaporandonorbatalseleksiV']['bln_akhir']);
            $model->thn_awal = $_GET['LaporandonorbatalseleksiV']['thn_awal'];
            $model->thn_akhir = $_GET['LaporandonorbatalseleksiV']['thn_akhir'];
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


        $criteria->addBetweenCondition('DATE(tglseleksidonor)', $model->tgl_awal, $model->tgl_akhir);
        $criteria->order = 'pendonor_id, waktu_pendaftaran ASC';
        $modcek = LaporandonorbatalseleksiV::model()->findAll($criteria);
        $modShow2 = LaporandonorbatalseleksiV::model()->findAll($criteria);
        $no = 0;

        $b = array();
        $previousId = '';
        $jenisdonasi = 'baru';
        foreach ($modShow2 as $hasil) {
            //Berdasarkan Donor Ke
            $baru = 0;
            $lama = 1;

            //Berdasarkan bb_rendah
            $bb_rendah = 'bb_rendah';
            $usia_kurang = 'usia_kurang';
            $hb_rendah = 'hb_rendah';
            $medis_tk_tinggi = 'medis_tk_tinggi';
            $medis_td_rendah = 'medis_td_rendah';
            $minum_obat = 'minum_obat';
            $medis_pasca_op = 'medis_pasca_op';
            $medis_hb_17 = 'medis_hb_17';
            $medis_vaksin = 'medis_vaksin';
            $perilakuberesiko_homo = 'perilakuberesiko_homo';
            $perilakuberesiko_tatto = 'perilakuberesiko_tatto';
            $perilakuberesiko_freesx = 'perilakuberesiko_freesx';
            $perilakuberesiko_penasun = 'perilakuberesiko_penasun';
            $perilakuberesiko_napi = 'perilakuberesiko_napi';
            $riwbepergian_endemik = 'riwbepergian_endemik';
            $riwbepergian_hiv = 'riwbepergian_hiv';
            $riwbepergian_sapigila = 'riwbepergian_sapigila';
            $lain_lain_tdkkembali = 'lain_lain_tdkkembali';
            $lain_lain_donortua = 'lain_lain_donortua';

            //Pertama cari ada data sebelumnya atau tidak. jika ada, maka donasi lama baris 88
            if ($previousId !== '' && $previousId !== $hasil->waktu_pendaftaran) {
                //Cek jika ada baris sebelumnya, dan jika donasi_ke == 0 : baru
                foreach ($modcek as $key => $hasilnya) {
                    if ($hasilnya->pendonor_id == $hasil->pendonor_id && $hasilnya->waktu_pendaftaran == $hasil->waktu_pendaftaran) {
                        //Cek pendonor sebelumnya adalah pendonor saat ini (dia pernah melakukan donor sebelumnya). 
                        if($modcek[$key - 1]->pendonor_id == $hasil->pendonor_id){
                            //Cek donor sebelumnya donasi_ke nya 0 atau != 0. jika 0 maka baru else lama
                            if($modcek[$key - 1]->donasi_ke == 0){
                                $jenisdonasi = 'baru';
                                $no = 0;
                            }else{
                                $jenisdonasi = 'lama';
                                $no++;
                            }
                        }else{
                            $jenisdonasi = 'baru';
                            $no = 0;
                        }
                    }
                }
            } 
            $previousId = $hasil->waktu_pendaftaran;
            
            //Jenis Kelamin
            $laki = strtolower(Params::JENIS_KELAMIN_LAKI_LAKI);
            $perempuan = strtolower(Params::JENIS_KELAMIN_PEREMPUAN);
            
            if ($jenisdonasi == 'lama' && strtolower($hasil->jenis_kelamin) == $laki) {
                //17
                //17 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] = 1;
                    }
                }
                //17 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] = 1;
                    }
                }

                //18 - 24
                //18 - 24 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                //25 - 44 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] = 1;
                    }
                }

                //45 - 64
                //45 - 64 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] = 1;
                    }
                }

                //Lebih dari 65
                //Lebih dari 65 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] = 1;
                    }
                }
            } else if ($jenisdonasi == 'lama' && strtolower($hasil->jenis_kelamin) == $perempuan) {

                //17
                //17 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] = 1;
                    }
                }

                //18 - 24
                //18 - 24 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                //25 - 44 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] = 1;
                    }
                }

                //45 - 64
                //45 - 64 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] = 1;
                    }
                }

                //Lebih dari 65
                //Lebih dari 65 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'])) {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] = $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$lama"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] = 1;
                    }
                }
            }
            if ($jenisdonasi == 'baru' && strtolower($hasil->jenis_kelamin) == $laki) {
                //17
                //17 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['umur17'] = 1;
                    }
                }
                //17 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['umur17'] = 1;
                    }
                }
                //17 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['umur17'] = 1;
                    }
                }
                //17 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['umur17'] = 1;
                    }
                }

                //18 - 24
                //18 - 24 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                //25 - 44 bb_rendah 
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['25sampai44'] = 1;
                    }
                }

                //45 - 64
                //45 - 64 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['45sampai64'] = 1;
                    }
                }

                //Lebih dari 65
                //Lebih dari 65 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$laki"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$laki"]['lebih65'] = 1;
                    }
                }
            } else if ($jenisdonasi == 'baru' && strtolower($hasil->jenis_kelamin) == $perempuan) {

                //17
                //17 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['umur17'] = 1;
                    }
                }
                //17 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '17 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['umur17'] = 1;
                    }
                }

                //18 - 24
                //18 - 24 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['18sampai24'] = 1;
                    }
                }
                //18 - 24 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '18 - 24 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['18sampai24'] = 1;
                    }
                }

                //25 - 44
                //25 - 44 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['25sampai44'] = 1;
                    }
                }
                //25 - 44 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '25 - 44 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['25sampai44'] = 1;
                    }
                }

                //45 - 64
                //45 - 64 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['45sampai64'] = 1;
                    }
                }
                //45 - 64 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '45 - 64 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['45sampai64'] = 1;
                    }
                }

                //Lebih dari 65
                //Lebih dari 65 bb_rendah
                if ($hasil->bb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$bb_rendah"]['bb_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 usia_kurang
                if ($hasil->usia_kurang == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$usia_kurang"]['usia_kurang']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 hb_rendah
                if ($hasil->hb_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$hb_rendah"]['hb_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_tk_tinggi
                if ($hasil->medis_tk_tinggi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_tk_tinggi"]['medis_tk_tinggi']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_td_rendah
                if ($hasil->medis_td_rendah == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_td_rendah"]['medis_td_rendah']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 minum_obat
                if ($hasil->minum_obat == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$minum_obat"]['minum_obat']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_pasca_op
                if ($hasil->medis_pasca_op == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_pasca_op"]['medis_pasca_op']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_hb_17
                if ($hasil->medis_hb_17 == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_hb_17"]['medis_hb_17']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 medis_vaksin
                if ($hasil->medis_vaksin == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$medis_vaksin"]['medis_vaksin']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_homo
                if ($hasil->perilakuberesiko_homo == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_homo"]['perilakuberesiko_homo']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_tatto
                if ($hasil->perilakuberesiko_tatto == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_tatto"]['perilakuberesiko_tatto']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_freesx
                if ($hasil->perilakuberesiko_freesx == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_freesx"]['perilakuberesiko_freesx']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_penasun
                if ($hasil->perilakuberesiko_penasun == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_penasun"]['perilakuberesiko_penasun']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 perilakuberesiko_napi
                if ($hasil->perilakuberesiko_napi == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$perilakuberesiko_napi"]['perilakuberesiko_napi']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_endemik
                if ($hasil->riwbepergian_endemik == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_endemik"]['riwbepergian_endemik']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_hiv
                if ($hasil->riwbepergian_hiv == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_hiv"]['riwbepergian_hiv']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 riwbepergian_sapigila
                if ($hasil->riwbepergian_sapigila == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$riwbepergian_sapigila"]['riwbepergian_sapigila']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_donortua
                if ($hasil->lain_lain_donortua == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_donortua"]['lain_lain_donortua']["$perempuan"]['lebih65'] = 1;
                    }
                }
                //Lebih dari 65 lain_lain_tdkkembali
                if ($hasil->lain_lain_tdkkembali == true && $hasil->kelompok_umur == '> 65 Th') {
                    if (isset($b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'])) {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] = $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] + 1;
                    } else {
                        $b["$baru"]['det']["$lain_lain_tdkkembali"]['lain_lain_tdkkembali']["$perempuan"]['lebih65'] = 1;
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
        $periode = date('d M Y', strtotime($model->tgl_awal)) . ' - ' . date('d M Y', strtotime($model->tgl_akhir));
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
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI_LANDSCAPE, '', '', '', '', 20, 20, 20, 20, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
