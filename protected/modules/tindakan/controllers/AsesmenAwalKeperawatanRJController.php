
<?php

class AsesmenAwalKeperawatanRJController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatJalan.views.asesmenAwalKeperawatan.';
    public $tersimpanAsesmenAwalKep = false;
    public $tersimpanKebEdukasi = false;

    /**
     * edit assemen awal keperawatan
     */
    public function actionEdit($pendaftaran_id,$pasienadmisi_id,$asesmenawalkeperawatan_id){
        $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $criFla = new CDbCriteria();
        $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
        $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
        $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
        $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);

        $getFlaCcs = null;

        $dataFlaCcs = array();
        $cekFlaCcs = array();
        $modAsesmenkebutuhanEdukasidetT = null;

        if (!empty($asesmenawalkeperawatan_id)) {
            $model = RJAsesmenawalkeperawatanT::model()->findByPk($asesmenawalkeperawatan_id);
            $model->kepala_hasilperiksa = ($model->kepala_hasilperiksa == true) ? 1 : 0;
            $model->mata_hasilperiksa = ($model->mata_hasilperiksa == true) ? 1 : 0;
            $model->leher_hasilperiksa = ($model->leher_hasilperiksa == true) ? 1 : 0;
            $model->hidung_hasilperiksa = ($model->hidung_hasilperiksa == true) ? 1 : 0;
            $model->telinga_hasilperiksa = ($model->telinga_hasilperiksa == true) ? 1 : 0;
            $model->mulut_hasilperiksa = ($model->mulut_hasilperiksa == true) ? 1 : 0;
            $model->jantung_hasilperiksa = ($model->jantung_hasilperiksa == true) ? 1 : 0;
            $model->paru_hasilperiksa = ($model->paru_hasilperiksa == true) ? 1 : 0;
            $model->abdomen_hasilperiksa = ($model->abdomen_hasilperiksa == true) ? 1 : 0;
            $model->genitalia_hasilperiksa = ($model->genitalia_hasilperiksa == true) ? 1 : 0;
            $model->extremitasatas_hasilperiksa = ($model->extremitasatas_hasilperiksa == true) ? 1 : 0;
            $model->extremitasbawah_hasilperiksa = ($model->extremitasbawah_hasilperiksa == true) ? 1 : 0;
            $model->kulit_hasilperiksa = ($model->kulit_hasilperiksa == true) ? 1 : 0;
            $model->statusmerokok = ($model->statusmerokok == true) ? 1 : 0;
            $model->deskripsinyeri_ismenjalar = ($model->deskripsinyeri_ismenjalar == true) ? 1 : 0;
            $model->deformitas_status = ($model->deformitas_status == true) ? 1 : 0;
            $model->gangguantidur_status = ($model->gangguantidur_status == true) ? 1 : 0;
            $model->keb_nutricairan_rasahausberlebih = ($model->keb_nutricairan_rasahausberlebih == true) ? 1 : 0;
            $model->keb_nutricairan_edemastatus = ($model->keb_nutricairan_edemastatus == true) ? 1 : 0;
            $model->riwayatjatuh_3bln_terakhir = ($model->riwayatjatuh_3bln_terakhir) ? 1 : 0;
            $model->riwayatjatuh_alatbantu = ($model->riwayatjatuh_alatbantu) ? 1 : 0;

            if (!empty($model->statusalergipasien)) {
                if ($model->statusalergipasien == 'Tidak Ada') {
                    $model->statusalergipasien = 1;
                } else if ($model->statusalergipasien == 'Tidak Tahu') {
                    $model->statusalergipasien = 2;
                } else if ($model->statusalergipasien == 'Ada') {
                    $model->statusalergipasien = 3;
                }
            }
            if ($model->isskrinninggizidewasa) {
                $model->skrinninggizi_jwb_penurunanbb_dewasa_text = $model->skrinninggizi_skor_penurunanbb_dewasa;
                $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = $model->skrinninggizi_skor_asupanmakanan_dewasa;

                $model->skrinninggizi_jwb_tampakkurus_text = null;
                $model->skrinninggizi_jwb_penurunanbb_text = null;
                $model->skrinninggizi_jwb_kondisi_text = null;
                $model->skrinninggizi_jwb_penyakit_text = null;
            } else {
                $model->skrinninggizi_jwb_penurunanbb_dewasa_text = null;
                $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = null;

                $model->skrinninggizi_jwb_tampakkurus_text = $model->skrinninggizi_skor_tampakkurus;
                $model->skrinninggizi_jwb_penurunanbb_text = $model->skrinninggizi_skor_penurunanbb;
                $model->skrinninggizi_jwb_kondisi_text = $model->skrinninggizi_skor_kondisi;
                $model->skrinninggizi_jwb_penyakit_text = $model->skrinninggizi_skor_penyakit;
            }

            $model->riwayatjatuh_penilaian_text = $model->riwayatjatuh_penilaian;
            $model->diagnosismedis_penilaian_text = $model->diagnosismedis_skor;
            $model->alatbantujalan_penilaian_text = (($model->alatbantujalan_skor != null) ? $model->alatbantujalan_skor : null);
            $model->memakaiterapiheparin_penilaian_text = $model->memakaiterapiheparin_penilaian;
            $model->caraberjalan_penilaian_text = (($model->caraberjalan_skor != null) ? $model->caraberjalan_skor : null);
            $model->statusmental_penilaian_text = (($model->statusmental_skor != null) ? $model->statusmental_skor : null);
            $model->usia_anak_text = $model->skor_usia_anak;
            $model->jeniskelamin_anak_text = $model->skor_jeniskelamin_anak;
            $model->diagnosa_asessment_anak_text = $model->skor_diagnosa_anak;
            $model->gangguan_kognitif_anak_text = $model->skor_gangguan_kognitif_anak;

            $model->faktor_lingkungan_anak_text = $model->skor_faktor_lingkungan_anak;
            $model->responterhadap_pembedahan_anak_text = $model->skor_responterhadap_pembedahan_anak;
            $model->penggunaan_medikamentosa_text = $model->skor_medikamentosa_anak;

            if ($model->jenisasesmen == 'asesmen_anak') {
                $model->isasesmenawalkep = 2;
                $model->jam_masukruangan_anak = $model->jam_masukruangan;
                $model->tgl_assesmen_awal_anak = $model->tgl_assesmen_awal;
            } else if ($model->jenisasesmen == 'asesmen_dewasa') {

                $model->isasesmenawalkep = 3;
                $model->resikojatuhkhususrj_hasilpenilaian_a = (isset($model->resikojatuhkhususrj_hasilpenilaian_a)?(($model->resikojatuhkhususrj_hasilpenilaian_a)? 1:0):null);
                $model->resikojatuhkhususrj_hasilpenilaian_b = (isset($model->resikojatuhkhususrj_hasilpenilaian_b)?(($model->resikojatuhkhususrj_hasilpenilaian_b)? 1:0):null);
                $model->jam_masukruangan_dws = $model->jam_masukruangan;
                $model->tgl_assesmen_awal_dws = $model->tgl_assesmen_awal;
                $model->keluhanutama_dws = $model->keluhanutama;
                $model->keluhantambahan_dws = $model->keluhantambahan;
                $model->kondisiumum_dws = $model->kondisiumum;
                $model->kepala_abnormalketerangan_dws = $model->kepala_abnormalketerangan;
                $model->mata_abnormalketerangan_dws = $model->mata_abnormalketerangan;
                $model->leher_abnormalketerangan_dws = $model->leher_abnormalketerangan;
                $model->hidung_abnormalketerangan_dws = $model->hidung_abnormalketerangan;
                $model->telinga_abnormalketerangan_dws = $model->telinga_abnormalketerangan;
                $model->mulut_abnormalketerangan_dws = $model->mulut_abnormalketerangan;
                $model->jantung_abnormalketerangan_dws = $model->jantung_abnormalketerangan;
                $model->paru_abnormalketerangan_dws = $model->paru_abnormalketerangan;
                $model->abdomen_abnormalketerangan_dws = $model->abdomen_abnormalketerangan;
                $model->genitalia_abnormalketerangan_dws = $model->genitalia_abnormalketerangan;
                $model->extremitasatas_abnormalketerangan_dws = $model->extremitasatas_abnormalketerangan;
                $model->extremitasbawah_abnormalketerangan_dws = $model->extremitasbawah_abnormalketerangan;
                $model->kulit_abnormalketerangan_dws = $model->kulit_abnormalketerangan;
                $model->neonatus_kebsosialekonomi_statusperkawinan_dws = $model->neonatus_kebsosialekonomi_statusperkawinan;
                $model->neonatus_tinggalbersamalainnya_notlp_dws = $model->neonatus_tinggalbersamalainnya_notlp;
                $model->neonatus_tinggalbersamalainnya_nama_dws = $model->neonatus_tinggalbersamalainnya_nama;
                $model->neonatus_tinggalbersama_dws = $model->neonatus_tinggalbersama;
                $model->neonatus_pekerjaanortu_dws = $model->neonatus_pekerjaanortu;
                $model->neonatus_warganegaraortu_dws = $model->neonatus_warganegaraortu;
                $model->neonatus_pendidikanortu_dws = $model->neonatus_pendidikanortu;
                $model->neonatus_kebiasaanortualkohol_status_dws = $model->neonatus_kebiasaanortualkohol_status;
                $model->neonatus_kebiasaanortualkohol_jenis_dws = $model->neonatus_kebiasaanortualkohol_jenis;
                $model->neonatus_kebiasaanortualkohol_jml_dws = $model->neonatus_kebiasaanortualkohol_jml;
                $model->neonatus_kebiasaanortulainnya_dws = $model->neonatus_kebiasaanortulainnya;
                $model->neonatus_agamaortu_dws = $model->neonatus_agamaortu;
            } else if ($model->jenisasesmen == 'asesmen_neonatus') {
                $model->isasesmenawalkep = 1;

                $model->keb_eliminasi_bab_keluhanstatus_neonatus = (($model->keb_eliminasi_bab_keluhanstatus) ? 1 : 0);
                $model->keb_eliminasi_bab_ispendarahan_neonatus = $model->keb_eliminasi_bab_ispendarahan;
                $model->keb_eliminasi_bab_ishemorroid_neonatus = $model->keb_eliminasi_bab_ishemorroid;
                $model->keb_eliminasi_bab_iskonstipasi_neonatus = $model->keb_eliminasi_bab_iskonstipasi;
                $model->keb_eliminasi_bab_iskeluhanlainnya_neonatus = $model->keb_eliminasi_bab_iskeluhanlainnya;
                $model->keb_eliminasi_bab_jeniskeluhanlainnya_neonatus = $model->keb_eliminasi_bab_jeniskeluhanlainnya;
                $model->keb_eliminasi_bak_keluhanstatus_neonatus = (($model->keb_eliminasi_bak_keluhanstatus) ? 1 : 0);
                $model->keb_eliminasi_bak_isnyeri_neonatus = $model->keb_eliminasi_bak_isnyeri;
                $model->keb_eliminasi_bak_ispendarahan_neonatus = $model->keb_eliminasi_bak_ispendarahan;
                $model->keb_eliminasi_bak_iskeluhanlainnya_neonatus = $model->keb_eliminasi_bak_iskeluhanlainnya;
                $model->keb_eliminasi_bak_jeniskeluhanlainnya_neonatus = $model->keb_eliminasi_bak_jeniskeluhanlainnya;
                $model->statusalergipasien_neonatus = $model->statusalergipasien;
                $model->riwayatalergiobat_neonatus = $model->riwayatalergiobat;
                $model->riwayatalergimakanan_neonatus = $model->riwayatalergimakanan;
                $model->riwayatalergilainnya_neonatus = $model->riwayatalergilainnya;
                $model->ispasangtandaalergi_neonatus = $model->ispasangtandaalergi;

                $model->isneonatus_cries_crying = $model->neonatus_cries_cryingnilai;
                $model->isneonatus_cries_requires = $model->neonatus_cries_requiresnilai;
                $model->isneonatus_cries_increased = $model->neonatus_cries_increasednilai;
                $model->isneonatus_cries_expression = $model->neonatus_cries_expressionnilai;
                $model->isneonatus_cries_sleepless = $model->neonatus_cries_sleeplessnilai;
            } else if ($model->jenisasesmen == 'asesmen_obgyn') {
                $model->isasesmenawalkep = 4;

                $model->jam_masukruangan_obgyn = $model->jam_masukruangan;
                $model->tgl_assesmen_awal_obgyn = $model->tgl_assesmen_awal;
                $model->keluhanutama_obgyn = $model->keluhanutama;
                $model->keluhantambahan_obgyn = $model->keluhantambahan;

                // $model->keb_eliminasi_bab_keluhanstatus_neonatus = (($model->keb_eliminasi_bab_keluhanstatus)?1:0);
                // $model->keb_eliminasi_bab_ispendarahan_neonatus = $model->keb_eliminasi_bab_ispendarahan;
                // $model->keb_eliminasi_bab_ishemorroid_neonatus = $model->keb_eliminasi_bab_ishemorroid;
                // $model->keb_eliminasi_bab_iskonstipasi_neonatus = $model->keb_eliminasi_bab_iskonstipasi;
                // $model->keb_eliminasi_bab_iskeluhanlainnya_neonatus = $model->keb_eliminasi_bab_iskeluhanlainnya;
                // $model->keb_eliminasi_bab_jeniskeluhanlainnya_neonatus = $model->keb_eliminasi_bab_jeniskeluhanlainnya;
                // $model->keb_eliminasi_bak_keluhanstatus_neonatus = (($model->keb_eliminasi_bak_keluhanstatus)?1:0);
                // $model->keb_eliminasi_bak_isnyeri_neonatus = $model->keb_eliminasi_bak_isnyeri;
                // $model->keb_eliminasi_bak_ispendarahan_neonatus = $model->keb_eliminasi_bak_ispendarahan;
                // $model->keb_eliminasi_bak_iskeluhanlainnya_neonatus = $model->keb_eliminasi_bak_iskeluhanlainnya;
                // $model->keb_eliminasi_bak_jeniskeluhanlainnya_neonatus = $model->keb_eliminasi_bak_jeniskeluhanlainnya;
                // $model->statusalergipasien_neonatus = $model->statusalergipasien;
                // $model->riwayatalergiobat_neonatus = $model->riwayatalergiobat;
                // $model->riwayatalergimakanan_neonatus = $model->riwayatalergimakanan;
                // $model->riwayatalergilainnya_neonatus = $model->riwayatalergilainnya;
                // $model->ispasangtandaalergi_neonatus = $model->ispasangtandaalergi;
                //
             // $model->isneonatus_cries_crying = $model->neonatus_cries_cryingnilai;
                // $model->isneonatus_cries_requires = $model->neonatus_cries_requiresnilai;
                // $model->isneonatus_cries_increased = $model->neonatus_cries_increasednilai;
                // $model->isneonatus_cries_expression = $model->neonatus_cries_expressionnilai;
                // $model->isneonatus_cries_sleepless = $model->neonatus_cries_sleeplessnilai;
            }





            $modSkrinningnyerianakdetT = RJSkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
            if (count($modSkrinningnyerianakdetT) > 0) {
                $getFlaCcs = $modSkrinningnyerianakdetT;

                if (count($getFlaCcs) > 0) {
                    foreach ($getFlaCcs as $det) {
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->skrinningnyerianakdet_id;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->asesmenawalkeperawatan_id;
                    }
                }
            } else {
                $modSkrinningnyerianakdetT = new RJSkrinningnyerianakdetT();
            }

            $modAsesmenkebutuhanEdukasiT = RJAsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
            if (isset($modAsesmenkebutuhanEdukasiT)) {
                $modAsesmenkebutuhanEdukasidetT = RJAsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));

                if ($model->jenisasesmen == 'asesmen_neonatus') {
                    $modAsesmenkebutuhanEdukasiT->bicara_status_neonatus = $modAsesmenkebutuhanEdukasiT->bicara_status;
                    $modAsesmenkebutuhanEdukasiT->mulaiseranganawal_neonatus = $modAsesmenkebutuhanEdukasiT->mulaiseranganawal;
                    $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status_neonatus = $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status;
                    $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_jenisbahasa_neonatus = $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_jenisbahasa;
                    $modAsesmenkebutuhanEdukasiT->bahasaisyarat_status_neonatus = $modAsesmenkebutuhanEdukasiT->bahasaisyarat_status;
                }
            } else {
                $modAsesmenkebutuhanEdukasiT = new RJAsesmenkebutuhanEdukasiT();
                $modAsesmenkebutuhanEdukasidetT = new RJAsesmenkebutuhanEdukasidetT();
            }
            $modRiwayatObstetrikPasien = RiwayatobstetrikpasienT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

            if (empty($modRiwayatObstetrikPasien)) {
                $modRiwayatObstetrikPasien = array();
            }
        } else {
            $model = new RJAsesmenawalkeperawatanT();
            $modSkrinningnyerianakdetT = new RJSkrinningnyerianakdetT();
            $model->tgl_assesmen_awal = date('d M Y H:i:s');
            $model->tgl_assesmen_awal_anak = date('d M Y H:i:s');
            $model->obgyn_taksiranpersalinan = date('d M Y');
            $model->obgyn_golongandarah = (!empty($modPasien->golongandarah) ? $modPasien->golongandarah : null);
            $modAsesmenkebutuhanEdukasiT = new RJAsesmenkebutuhanEdukasiT();
            $modAsesmenkebutuhanEdukasidetT = new RJAsesmenkebutuhanEdukasidetT();
            $modRiwayatObstetrikPasien = array();
        }

        $model->dokterpemeriksa_id = $modPendaftaran->pegawai_id;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->pasien_id = $modPendaftaran->pasien_id;

        $modAsesmenkebutuhanEdukasiT->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modAsesmenkebutuhanEdukasiT->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->is_dbn = true;
        if (!empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BALITA) || !empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_ANAK) || !empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI) || !empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR)) {
            $model->isskrinninggizidewasa = false;
            $model->isresikojatuh = 1;
            $model->is_keluhannyeri_dewasa = false;
        } else {
           // $modPasien->kelompokumur_id = 3;
            $model->isskrinninggizidewasa = true;
            $model->is_keluhannyeri_dewasa = true;
            if (!empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_DEWASA)) {
                $model->isresikojatuh = 0;
            } else if (!empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_LANSIA)) {
                $model->isresikojatuh = 2;
            }
        }
        foreach ($modNyeriFlaCcs as $dtF) {
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama ? $dtF->kat_skalanyeri_nama : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori_id"] = $dtF->kat_skalanyeri_id ? $dtF->kat_skalanyeri_id : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_anak_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_kat_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_params"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['params']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['params'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_nilai"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
                'id' => isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null,
                'keterangan' => $dtF->skalanyeriflaccs_desc
            );
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] : null;
        }

        $this->render($this->path_view . 'edit', array('modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'modSkrinningnyerianakdetT' => $modSkrinningnyerianakdetT,
            'dataFlaCcs' => $dataFlaCcs,
            'getFlaCcs' => $getFlaCcs,
            'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,
            'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,
            'modRiwayatObstetrikPasien' => $modRiwayatObstetrikPasien
        ));

    }


    public function actionIndex() {

        $pendaftaran_id = (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null);
        $pasienadmisi_id = (isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null);
        $asesmenawalkeperawatan_id = (isset($_GET['asesmenawalkeperawatan_id']) ? $_GET['asesmenawalkeperawatan_id'] : null);

        $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);


        $criFla = new CDbCriteria();
        $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
        $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
        $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
        $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);

        $getFlaCcs = null;

        $dataFlaCcs = array();
        $cekFlaCcs = array();
        $modAsesmenkebutuhanEdukasidetT = null;

        if (!empty($asesmenawalkeperawatan_id)) {
            $model = RJAsesmenawalkeperawatanT::model()->findByPk($asesmenawalkeperawatan_id);
            $model->kepala_hasilperiksa = ($model->kepala_hasilperiksa == true) ? 1 : 0;
            $model->mata_hasilperiksa = ($model->mata_hasilperiksa == true) ? 1 : 0;
            $model->leher_hasilperiksa = ($model->leher_hasilperiksa == true) ? 1 : 0;
            $model->hidung_hasilperiksa = ($model->hidung_hasilperiksa == true) ? 1 : 0;
            $model->telinga_hasilperiksa = ($model->telinga_hasilperiksa == true) ? 1 : 0;
            $model->mulut_hasilperiksa = ($model->mulut_hasilperiksa == true) ? 1 : 0;
            $model->jantung_hasilperiksa = ($model->jantung_hasilperiksa == true) ? 1 : 0;
            $model->paru_hasilperiksa = ($model->paru_hasilperiksa == true) ? 1 : 0;
            $model->abdomen_hasilperiksa = ($model->abdomen_hasilperiksa == true) ? 1 : 0;
            $model->genitalia_hasilperiksa = ($model->genitalia_hasilperiksa == true) ? 1 : 0;
            $model->extremitasatas_hasilperiksa = ($model->extremitasatas_hasilperiksa == true) ? 1 : 0;
            $model->extremitasbawah_hasilperiksa = ($model->extremitasbawah_hasilperiksa == true) ? 1 : 0;
            $model->kulit_hasilperiksa = ($model->kulit_hasilperiksa == true) ? 1 : 0;
            $model->statusmerokok = ($model->statusmerokok == true) ? 1 : 0;
            $model->deskripsinyeri_ismenjalar = ($model->deskripsinyeri_ismenjalar == true) ? 1 : 0;
            $model->deformitas_status = ($model->deformitas_status == true) ? 1 : 0;
            $model->gangguantidur_status = ($model->gangguantidur_status == true) ? 1 : 0;
            $model->keb_nutricairan_rasahausberlebih = ($model->keb_nutricairan_rasahausberlebih == true) ? 1 : 0;
            $model->keb_nutricairan_edemastatus = ($model->keb_nutricairan_edemastatus == true) ? 1 : 0;
            $model->riwayatjatuh_3bln_terakhir = ($model->riwayatjatuh_3bln_terakhir) ? 1 : 0;
            $model->riwayatjatuh_alatbantu = ($model->riwayatjatuh_alatbantu) ? 1 : 0;

            if (!empty($model->statusalergipasien)) {
                if ($model->statusalergipasien == 'Tidak Ada') {
                    $model->statusalergipasien = 1;
                } else if ($model->statusalergipasien == 'Tidak Tahu') {
                    $model->statusalergipasien = 2;
                } else if ($model->statusalergipasien == 'Ada') {
                    $model->statusalergipasien = 3;
                }
            }
            if ($model->isskrinninggizidewasa) {
                $model->skrinninggizi_jwb_penurunanbb_dewasa_text = $model->skrinninggizi_skor_penurunanbb_dewasa;
                $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = $model->skrinninggizi_skor_asupanmakanan_dewasa;

                $model->skrinninggizi_jwb_tampakkurus_text = null;
                $model->skrinninggizi_jwb_penurunanbb_text = null;
                $model->skrinninggizi_jwb_kondisi_text = null;
                $model->skrinninggizi_jwb_penyakit_text = null;
            } else {
                $model->skrinninggizi_jwb_penurunanbb_dewasa_text = null;
                $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = null;

                $model->skrinninggizi_jwb_tampakkurus_text = $model->skrinninggizi_skor_tampakkurus;
                $model->skrinninggizi_jwb_penurunanbb_text = $model->skrinninggizi_skor_penurunanbb;
                $model->skrinninggizi_jwb_kondisi_text = $model->skrinninggizi_skor_kondisi;
                $model->skrinninggizi_jwb_penyakit_text = $model->skrinninggizi_skor_penyakit;
            }

            $model->riwayatjatuh_penilaian_text = $model->riwayatjatuh_penilaian;
            $model->diagnosismedis_penilaian_text = $model->diagnosismedis_skor;
            $model->alatbantujalan_penilaian_text = (($model->alatbantujalan_skor != null) ? $model->alatbantujalan_skor : null);
            $model->memakaiterapiheparin_penilaian_text = $model->memakaiterapiheparin_penilaian;
            $model->caraberjalan_penilaian_text = (($model->caraberjalan_skor != null) ? $model->caraberjalan_skor : null);
            $model->statusmental_penilaian_text = (($model->statusmental_skor != null) ? $model->statusmental_skor : null);
            $model->usia_anak_text = $model->skor_usia_anak;
            $model->jeniskelamin_anak_text = $model->skor_jeniskelamin_anak;
            $model->diagnosa_asessment_anak_text = $model->skor_diagnosa_anak;
            $model->gangguan_kognitif_anak_text = $model->skor_gangguan_kognitif_anak;

            $model->faktor_lingkungan_anak_text = $model->skor_faktor_lingkungan_anak;
            $model->responterhadap_pembedahan_anak_text = $model->skor_responterhadap_pembedahan_anak;
            $model->penggunaan_medikamentosa_text = $model->skor_medikamentosa_anak;

            if ($model->jenisasesmen == 'asesmen_anak') {
                $model->isasesmenawalkep = 2;
                $model->jam_masukruangan_anak = $model->jam_masukruangan;
                $model->tgl_assesmen_awal_anak = $model->tgl_assesmen_awal;
            } else if ($model->jenisasesmen == 'asesmen_dewasa') {

                $model->isasesmenawalkep = 3;
                $model->resikojatuhkhususrj_hasilpenilaian_a = (isset($model->resikojatuhkhususrj_hasilpenilaian_a)?(($model->resikojatuhkhususrj_hasilpenilaian_a)? 1:0):null);
                $model->resikojatuhkhususrj_hasilpenilaian_b = (isset($model->resikojatuhkhususrj_hasilpenilaian_b)?(($model->resikojatuhkhususrj_hasilpenilaian_b)? 1:0):null);
                $model->jam_masukruangan_dws = $model->jam_masukruangan;
                $model->tgl_assesmen_awal_dws = $model->tgl_assesmen_awal;
                $model->keluhanutama_dws = $model->keluhanutama;
                $model->keluhantambahan_dws = $model->keluhantambahan;
                $model->kondisiumum_dws = $model->kondisiumum;
                $model->kepala_abnormalketerangan_dws = $model->kepala_abnormalketerangan;
                $model->mata_abnormalketerangan_dws = $model->mata_abnormalketerangan;
                $model->leher_abnormalketerangan_dws = $model->leher_abnormalketerangan;
                $model->hidung_abnormalketerangan_dws = $model->hidung_abnormalketerangan;
                $model->telinga_abnormalketerangan_dws = $model->telinga_abnormalketerangan;
                $model->mulut_abnormalketerangan_dws = $model->mulut_abnormalketerangan;
                $model->jantung_abnormalketerangan_dws = $model->jantung_abnormalketerangan;
                $model->paru_abnormalketerangan_dws = $model->paru_abnormalketerangan;
                $model->abdomen_abnormalketerangan_dws = $model->abdomen_abnormalketerangan;
                $model->genitalia_abnormalketerangan_dws = $model->genitalia_abnormalketerangan;
                $model->extremitasatas_abnormalketerangan_dws = $model->extremitasatas_abnormalketerangan;
                $model->extremitasbawah_abnormalketerangan_dws = $model->extremitasbawah_abnormalketerangan;
                $model->kulit_abnormalketerangan_dws = $model->kulit_abnormalketerangan;
                $model->neonatus_kebsosialekonomi_statusperkawinan_dws = $model->neonatus_kebsosialekonomi_statusperkawinan;
                $model->neonatus_tinggalbersamalainnya_notlp_dws = $model->neonatus_tinggalbersamalainnya_notlp;
                $model->neonatus_tinggalbersamalainnya_nama_dws = $model->neonatus_tinggalbersamalainnya_nama;
                $model->neonatus_tinggalbersama_dws = $model->neonatus_tinggalbersama;
                $model->neonatus_pekerjaanortu_dws = $model->neonatus_pekerjaanortu;
                $model->neonatus_warganegaraortu_dws = $model->neonatus_warganegaraortu;
                $model->neonatus_pendidikanortu_dws = $model->neonatus_pendidikanortu;
                $model->neonatus_kebiasaanortualkohol_status_dws = $model->neonatus_kebiasaanortualkohol_status;
                $model->neonatus_kebiasaanortualkohol_jenis_dws = $model->neonatus_kebiasaanortualkohol_jenis;
                $model->neonatus_kebiasaanortualkohol_jml_dws = $model->neonatus_kebiasaanortualkohol_jml;
                $model->neonatus_kebiasaanortulainnya_dws = $model->neonatus_kebiasaanortulainnya;
                $model->neonatus_agamaortu_dws = $model->neonatus_agamaortu;
            } else if ($model->jenisasesmen == 'asesmen_neonatus') {
                $model->isasesmenawalkep = 1;

                $model->keb_eliminasi_bab_keluhanstatus_neonatus = (($model->keb_eliminasi_bab_keluhanstatus) ? 1 : 0);
                $model->keb_eliminasi_bab_ispendarahan_neonatus = $model->keb_eliminasi_bab_ispendarahan;
                $model->keb_eliminasi_bab_ishemorroid_neonatus = $model->keb_eliminasi_bab_ishemorroid;
                $model->keb_eliminasi_bab_iskonstipasi_neonatus = $model->keb_eliminasi_bab_iskonstipasi;
                $model->keb_eliminasi_bab_iskeluhanlainnya_neonatus = $model->keb_eliminasi_bab_iskeluhanlainnya;
                $model->keb_eliminasi_bab_jeniskeluhanlainnya_neonatus = $model->keb_eliminasi_bab_jeniskeluhanlainnya;
                $model->keb_eliminasi_bak_keluhanstatus_neonatus = (($model->keb_eliminasi_bak_keluhanstatus) ? 1 : 0);
                $model->keb_eliminasi_bak_isnyeri_neonatus = $model->keb_eliminasi_bak_isnyeri;
                $model->keb_eliminasi_bak_ispendarahan_neonatus = $model->keb_eliminasi_bak_ispendarahan;
                $model->keb_eliminasi_bak_iskeluhanlainnya_neonatus = $model->keb_eliminasi_bak_iskeluhanlainnya;
                $model->keb_eliminasi_bak_jeniskeluhanlainnya_neonatus = $model->keb_eliminasi_bak_jeniskeluhanlainnya;
                $model->statusalergipasien_neonatus = $model->statusalergipasien;
                $model->riwayatalergiobat_neonatus = $model->riwayatalergiobat;
                $model->riwayatalergimakanan_neonatus = $model->riwayatalergimakanan;
                $model->riwayatalergilainnya_neonatus = $model->riwayatalergilainnya;
                $model->ispasangtandaalergi_neonatus = $model->ispasangtandaalergi;

                $model->isneonatus_cries_crying = $model->neonatus_cries_cryingnilai;
                $model->isneonatus_cries_requires = $model->neonatus_cries_requiresnilai;
                $model->isneonatus_cries_increased = $model->neonatus_cries_increasednilai;
                $model->isneonatus_cries_expression = $model->neonatus_cries_expressionnilai;
                $model->isneonatus_cries_sleepless = $model->neonatus_cries_sleeplessnilai;
            } else if ($model->jenisasesmen == 'asesmen_obgyn') {
                $model->isasesmenawalkep = 4;

                $model->jam_masukruangan_obgyn = $model->jam_masukruangan;
                $model->tgl_assesmen_awal_obgyn = $model->tgl_assesmen_awal;
                $model->keluhanutama_obgyn = $model->keluhanutama;
                $model->keluhantambahan_obgyn = $model->keluhantambahan;

                // $model->keb_eliminasi_bab_keluhanstatus_neonatus = (($model->keb_eliminasi_bab_keluhanstatus)?1:0);
                // $model->keb_eliminasi_bab_ispendarahan_neonatus = $model->keb_eliminasi_bab_ispendarahan;
                // $model->keb_eliminasi_bab_ishemorroid_neonatus = $model->keb_eliminasi_bab_ishemorroid;
                // $model->keb_eliminasi_bab_iskonstipasi_neonatus = $model->keb_eliminasi_bab_iskonstipasi;
                // $model->keb_eliminasi_bab_iskeluhanlainnya_neonatus = $model->keb_eliminasi_bab_iskeluhanlainnya;
                // $model->keb_eliminasi_bab_jeniskeluhanlainnya_neonatus = $model->keb_eliminasi_bab_jeniskeluhanlainnya;
                // $model->keb_eliminasi_bak_keluhanstatus_neonatus = (($model->keb_eliminasi_bak_keluhanstatus)?1:0);
                // $model->keb_eliminasi_bak_isnyeri_neonatus = $model->keb_eliminasi_bak_isnyeri;
                // $model->keb_eliminasi_bak_ispendarahan_neonatus = $model->keb_eliminasi_bak_ispendarahan;
                // $model->keb_eliminasi_bak_iskeluhanlainnya_neonatus = $model->keb_eliminasi_bak_iskeluhanlainnya;
                // $model->keb_eliminasi_bak_jeniskeluhanlainnya_neonatus = $model->keb_eliminasi_bak_jeniskeluhanlainnya;
                // $model->statusalergipasien_neonatus = $model->statusalergipasien;
                // $model->riwayatalergiobat_neonatus = $model->riwayatalergiobat;
                // $model->riwayatalergimakanan_neonatus = $model->riwayatalergimakanan;
                // $model->riwayatalergilainnya_neonatus = $model->riwayatalergilainnya;
                // $model->ispasangtandaalergi_neonatus = $model->ispasangtandaalergi;
                //
             // $model->isneonatus_cries_crying = $model->neonatus_cries_cryingnilai;
                // $model->isneonatus_cries_requires = $model->neonatus_cries_requiresnilai;
                // $model->isneonatus_cries_increased = $model->neonatus_cries_increasednilai;
                // $model->isneonatus_cries_expression = $model->neonatus_cries_expressionnilai;
                // $model->isneonatus_cries_sleepless = $model->neonatus_cries_sleeplessnilai;
            }





            $modSkrinningnyerianakdetT = RJSkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
            if (count($modSkrinningnyerianakdetT) > 0) {
                $getFlaCcs = $modSkrinningnyerianakdetT;

                if (count($getFlaCcs) > 0) {
                    foreach ($getFlaCcs as $det) {
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->skrinningnyerianakdet_id;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->asesmenawalkeperawatan_id;
                    }
                }
            } else {
                $modSkrinningnyerianakdetT = new RJSkrinningnyerianakdetT();
            }

            $modAsesmenkebutuhanEdukasiT = RJAsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
            if (isset($modAsesmenkebutuhanEdukasiT)) {
                 $modAsesmenkebutuhanEdukasidetT = RJAsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));

                if ($model->jenisasesmen == 'asesmen_neonatus') {
                    $modAsesmenkebutuhanEdukasiT->bicara_status_neonatus = $modAsesmenkebutuhanEdukasiT->bicara_status;
                    $modAsesmenkebutuhanEdukasiT->mulaiseranganawal_neonatus = $modAsesmenkebutuhanEdukasiT->mulaiseranganawal;
                    $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status_neonatus = $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status;
                    $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_jenisbahasa_neonatus = $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_jenisbahasa;
                    $modAsesmenkebutuhanEdukasiT->bahasaisyarat_status_neonatus = $modAsesmenkebutuhanEdukasiT->bahasaisyarat_status;
                }
            } else {
                $modAsesmenkebutuhanEdukasiT = new RJAsesmenkebutuhanEdukasiT();
                $modAsesmenkebutuhanEdukasidetT = new RJAsesmenkebutuhanEdukasidetT();
            }
            $modRiwayatObstetrikPasien = RiwayatobstetrikpasienT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

            if (empty($modRiwayatObstetrikPasien)) {
                $modRiwayatObstetrikPasien = array();
            }
        } else {
            $model = new RJAsesmenawalkeperawatanT();

            $anamnesa = AnamnesaT::model()->find("pendaftaran_id = $pendaftaran_id");
            if(!empty($anamnesa)) {
                $model->keluhanutama = !empty($anamnesa->keluhanutama) ? $anamnesa->keluhanutama : '';
                $model->keluhantambahan = !empty($anamnesa->keluhantambahan) ? $anamnesa->keluhantambahan : '';         
            }

            $modSkrinningnyerianakdetT = new RJSkrinningnyerianakdetT();
            $model->tgl_assesmen_awal = date('d M Y H:i:s');
            $model->tgl_assesmen_awal_anak = date('d M Y H:i:s');
            $model->obgyn_taksiranpersalinan = date('d M Y');
            $model->obgyn_golongandarah = (!empty($modPasien->golongandarah) ? $modPasien->golongandarah : null);
            $modAsesmenkebutuhanEdukasiT = new RJAsesmenkebutuhanEdukasiT();
            $modAsesmenkebutuhanEdukasidetT = new RJAsesmenkebutuhanEdukasidetT();
            $modRiwayatObstetrikPasien = array();
        }

        $model->dokterpemeriksa_id = $modPendaftaran->pegawai_id;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->pasien_id = $modPendaftaran->pasien_id;

        $modAsesmenkebutuhanEdukasiT->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modAsesmenkebutuhanEdukasiT->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->is_dbn = true;
        // if (empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BALITA) || empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_ANAK) || empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI) || empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR)) {
        //     $model->isskrinninggizidewasa = false;
        //     $model->isresikojatuh = 1;
        //     $model->is_keluhannyeri_dewasa = false;
        // } else {
        //     $model->isskrinninggizidewasa = true;
        //     $model->is_keluhannyeri_dewasa = true;
        //     if (empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_DEWASA)) {
        //         $model->isresikojatuh = 0;
        //     } else if (empty($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_LANSIA)) {
        //         $model->isresikojatuh = 2;
        //     }
        // }
        foreach ($modNyeriFlaCcs as $dtF) {
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori_id"] = $dtF->kat_skalanyeri_id;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_anak_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_kat_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_params"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['params']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['params'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_nilai"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
                'id' => isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null,
                'keterangan' => $dtF->skalanyeriflaccs_desc
            );
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] : null;
        }

        $this->render($this->path_view . 'index', array('modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'modSkrinningnyerianakdetT' => $modSkrinningnyerianakdetT,
            'dataFlaCcs' => $dataFlaCcs,
            'getFlaCcs' => $getFlaCcs,
            'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,
            'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,
            'modRiwayatObstetrikPasien' => $modRiwayatObstetrikPasien
        ));
    }

    public function actionMasterKeluhan() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(keluhananamnesis_nama)', strtolower($_GET['tag']), true);
            $criteria->order = "keluhananamnesis_nama ASC";
            $keluhans = KeluhananamnesisM::model()->findAll($criteria);
            $data = array();
            foreach ($keluhans as $i => $keluhan) {
                $data[$i] = array('key' => $keluhan->keluhananamnesis_nama,
                    'value' => $keluhan->keluhananamnesis_nama);
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionMasterKeadaanUmum() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(keadaanumum_nama)', strtolower($_GET['tag']), true);
            $criteria->order = "keadaanumum_nama ASC";
            $keluhans = KeadaanumumM::model()->findAll($criteria);
            $data = array();
            foreach ($keluhans as $i => $keluhan) {
                $data[$i] = array('key' => $keluhan->keadaanumum_nama,
                    'value' => $keluhan->keadaanumum_nama);
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionGetfromDevice() {
        if (Yii::app()->request->isAjaxRequest) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $file = dirname('c:/OstarP2/x') . '/OstarXML.xml';
            } else {
                $file = Yii::app()->getBaseUrl('webroot') . '/data/xml/ostar.xml';
            }

            $data2 = simplexml_load_file($file);
            $a = $data2->BPMRecord[0]['H'];
            $b = $data2->BPMRecord[0]['L'];
            $c = $data2->BPMRecord[0]['P'];

            $tambah = '';
            if (strlen($a) < 3) {
                for ($i = strlen($a); $i < 3; $i++) {
                    $tambah = $tambah . '0';
                }
                $a = $tambah . $a;
            }
            $tambah = '';
            if (strlen($b) < 3) {
                for ($i = strlen($b); $i < 3; $i++) {
                    $tambah = $tambah . '0';
                }
                $b = $tambah . $b;
            }

            $data['sys'] = "$a";
            $data['dias'] = "$b";
            $data['detaknadi'] = "$c";
            $data['tekanandarah'] = $a . ' / ' . $b;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionSimpanOrLoad() {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $sukses = 0;
            $pesan = "Data Error Disimpan!!";
            // echo '<pre>';
            // print_r($_POST);
            // exit();
            if (isset($_POST['RJAsesmenawalkeperawatanT'])) {
                $transaction = Yii::app()->db->beginTransaction();

                try {
                    $pendaftaran_id = $_POST['RJAsesmenawalkeperawatanT']['pendaftaran_id'];
                    $pasienadmisi_id = (!empty($_POST['RJAsesmenawalkeperawatanT']['pasienadmisi_id']) ? $_POST['RJAsesmenawalkeperawatanT']['pasienadmisi_id'] : null);
                    $jenisasesmen = $_POST['RJAsesmenawalkeperawatanT']['jenisasesmen'];
                    $asesmenawalkeperawatan_id = (isset($_POST['RJAsesmenawalkeperawatanT']['asesmenawalkeperawatan_id']) && !empty($_POST['RJAsesmenawalkeperawatanT']['asesmenawalkeperawatan_id']) ? $_POST['RJAsesmenawalkeperawatanT']['asesmenawalkeperawatan_id'] : null);

                    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
                    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
                    $modAsesmenkebutuhanEdukasidetT = null;

                    if (!empty($asesmenawalkeperawatan_id)) {
                        $modAsesmenawalkeperawatanT = RJAsesmenawalkeperawatanT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $asesmenawalkeperawatan_id));

                        if (!isset($modAsesmenawalkeperawatanT)) {
                            $modAsesmenawalkeperawatanT = new RJAsesmenawalkeperawatanT();
                            $modSkrinningnyerianakdetT = new RJSkrinningnyerianakdetT();

                            $modAsesmenawalkeperawatanT->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                            $modAsesmenawalkeperawatanT->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                            $modAsesmenawalkeperawatanT->pasien_id = $modPendaftaran->pasien_id;

                            $modAsesmenkebutuhanEdukasiT = new RJAsesmenkebutuhanEdukasiT();
                            $modAsesmenkebutuhanEdukasidetT = new RJAsesmenkebutuhanEdukasidetT();
                        } else {
                            $modSkrinningnyerianakdetT = RJSkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));
                            if (count($modSkrinningnyerianakdetT) > 0) {
                                $getFlaCcs = $modSkrinningnyerianakdetT;

                                if (count($getFlaCcs) > 0) {
                                    foreach ($getFlaCcs as $det) {
                                        $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->skrinningnyerianakdet_id;
                                        $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
                                        $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
                                        $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
                                        $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->asesmenawalkeperawatan_id;
                                    }
                                }
                            } else {
                                $modSkrinningnyerianakdetT = new RJSkrinningnyerianakdetT();
                            }

                            $modAsesmenkebutuhanEdukasiT = RJAsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));
                            if (isset($modAsesmenkebutuhanEdukasiT)) {
                                $modAsesmenkebutuhanEdukasidetT = RJAsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));
                            } else {
                                $modAsesmenkebutuhanEdukasiT = new RJAsesmenkebutuhanEdukasiT();
                                $modAsesmenkebutuhanEdukasidetT = new RJAsesmenkebutuhanEdukasidetT();
                            }
                        }
                    } else {
                        if ($_POST['checksimpan'] == 'simpan') {
                            $modAsesmenawalkeperawatanT = RJAsesmenawalkeperawatanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'jenisasesmen' => $jenisasesmen));

                            if (!isset($modAsesmenawalkeperawatanT)) {
                                $modAsesmenawalkeperawatanT = new RJAsesmenawalkeperawatanT();
                                $modSkrinningnyerianakdetT = new RJSkrinningnyerianakdetT();

                                $modAsesmenawalkeperawatanT->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                                $modAsesmenawalkeperawatanT->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                                $modAsesmenawalkeperawatanT->pasien_id = $modPendaftaran->pasien_id;

                                $modAsesmenkebutuhanEdukasiT = new RJAsesmenkebutuhanEdukasiT();
                                $modAsesmenkebutuhanEdukasidetT = new RJAsesmenkebutuhanEdukasidetT();
                            } else {
                                $modSkrinningnyerianakdetT = RJSkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));
                                if (count($modSkrinningnyerianakdetT) > 0) {
                                    $getFlaCcs = $modSkrinningnyerianakdetT;

                                    if (count($getFlaCcs) > 0) {
                                        foreach ($getFlaCcs as $det) {
                                            $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->skrinningnyerianakdet_id;
                                            $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
                                            $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
                                            $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
                                            $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->asesmenawalkeperawatan_id;
                                        }
                                    }
                                } else {
                                    $modSkrinningnyerianakdetT = new RJSkrinningnyerianakdetT();
                                }

                                $modAsesmenkebutuhanEdukasiT = RJAsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                                if (isset($modAsesmenkebutuhanEdukasiT)) {
                                    $modAsesmenkebutuhanEdukasidetT = RJAsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));
                                } else {
                                    $modAsesmenkebutuhanEdukasiT = new RJAsesmenkebutuhanEdukasiT();
                                    $modAsesmenkebutuhanEdukasidetT = new RJAsesmenkebutuhanEdukasidetT();
                                }
                            }
                        } else {
                            $modAsesmenawalkeperawatanT = new RJAsesmenawalkeperawatanT();
                            $modSkrinningnyerianakdetT = new RJSkrinningnyerianakdetT();
                            $modAsesmenkebutuhanEdukasiT = new RJAsesmenkebutuhanEdukasiT();
                            $modAsesmenkebutuhanEdukasidetT = new RJAsesmenkebutuhanEdukasidetT();
                        }
                    }

                    $tersimpandetailNyeri = true;
                    $tersimpandetailEdukasi = true;
                    $tersimpanTumbuhKembang = true;
                    $tersimpanRiwayatObs = true;

                    if (isset($_POST['RJAsesmenawalkeperawatanT'])) {
                        $modAsesmenawalkeperawatanT->attributes = $_POST['RJAsesmenawalkeperawatanT'];
                        // $modAsesmenawalkeperawatanT->pendaftaran_id = $_POST['RDAsesmenawalkeperawatanT']['pendaftaran_id'];
                        // $modAsesmenawalkeperawatanT->pasienadmisi_id = $_POST['RDAsesmenawalkeperawatanT']['pasienadmisi_id'];
                        // $modAsesmenawalkeperawatanT->pasien_id = $_POST['RDAsesmenawalkeperawatanT']['pasien_id'];

                        $modAsesmenkebutuhanEdukasiT->pendaftaran_id = $modAsesmenawalkeperawatanT->pendaftaran_id;
                        $modAsesmenkebutuhanEdukasiT->pasienadmisi_id = $modAsesmenawalkeperawatanT->pasienadmisi_id;

                        if ($modAsesmenawalkeperawatanT->jenisasesmen == 'asesmen_anak') {
                            $modAsesmenawalkeperawatanT->jam_masukruangan = $_POST['RJAsesmenawalkeperawatanT']['jam_masukruangan_anak'];
                            $modAsesmenawalkeperawatanT->tgl_assesmen_awal = MyFormatter::formatDateTimeForDb($_POST['RJAsesmenawalkeperawatanT']['tgl_assesmen_awal_anak']);
                            $modAsesmenawalkeperawatanT->keluhanutama = isset($_POST['RJAsesmenawalkeperawatanT']['keluhanutama']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['keluhanutama']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['keluhanutama']) : '') : '';
                            $modAsesmenawalkeperawatanT->keluhantambahan = isset($_POST['RJAsesmenawalkeperawatanT']['keluhantambahan']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['keluhantambahan']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['keluhantambahan']) : '') : '';
                            $modAsesmenawalkeperawatanT->kondisiumum = isset($_POST['RJAsesmenawalkeperawatanT']['kondisiumum']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['kondisiumum']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['kondisiumum']) : '') : '';
                        } else if ($modAsesmenawalkeperawatanT->jenisasesmen == 'asesmen_dewasa') {
                            $modAsesmenawalkeperawatanT->jam_masukruangan = $_POST['RJAsesmenawalkeperawatanT']['jam_masukruangan_dws'];
                            $modAsesmenawalkeperawatanT->tgl_assesmen_awal = MyFormatter::formatDateTimeForDb($_POST['RJAsesmenawalkeperawatanT']['tgl_assesmen_awal_dws']);
                            $modAsesmenawalkeperawatanT->keluhanutama = isset($_POST['RJAsesmenawalkeperawatanT']['keluhanutama_dws']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['keluhanutama_dws']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['keluhanutama_dws']) : '') : '';
                            $modAsesmenawalkeperawatanT->keluhantambahan = isset($_POST['RJAsesmenawalkeperawatanT']['keluhantambahan_dws']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['keluhantambahan_dws']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['keluhantambahan_dws']) : '') : '';
                            $modAsesmenawalkeperawatanT->kondisiumum = isset($_POST['RJAsesmenawalkeperawatanT']['kondisiumum_dws']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['kondisiumum_dws']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['kondisiumum_dws']) : '') : '';
                            $modAsesmenawalkeperawatanT->kepala_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['kepala_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['kepala_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->mata_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['mata_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['mata_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->leher_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['leher_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['leher_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->hidung_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['hidung_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['hidung_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->telinga_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['telinga_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['telinga_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->mulut_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['mulut_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['mulut_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->jantung_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['jantung_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['jantung_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->paru_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['paru_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['paru_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->abdomen_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['abdomen_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['abdomen_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->genitalia_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['genitalia_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['genitalia_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->extremitasatas_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['extremitasatas_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['extremitasatas_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->extremitasbawah_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['extremitasbawah_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['extremitasbawah_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->kulit_abnormalketerangan = isset($_POST['RJAsesmenawalkeperawatanT']['kulit_abnormalketerangan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['kulit_abnormalketerangan_dws'] : null;
                            $modAsesmenawalkeperawatanT->neonatus_kebsosialekonomi_statusperkawinan = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan_dws'] : null;
                            $modAsesmenawalkeperawatanT->neonatus_tinggalbersamalainnya_notlp = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_tinggalbersamalainnya_notlp_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_tinggalbersamalainnya_notlp_dws'] : null;
                            $modAsesmenawalkeperawatanT->neonatus_tinggalbersamalainnya_nama = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_tinggalbersamalainnya_nama_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_tinggalbersamalainnya_nama_dws'] : null;
                            $modAsesmenawalkeperawatanT->neonatus_tinggalbersama = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_tinggalbersama_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_tinggalbersama_dws'] : null;
                            $modAsesmenawalkeperawatanT->neonatus_pekerjaanortu = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_pekerjaanortu_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_pekerjaanortu_dws'] : null;
                            $modAsesmenawalkeperawatanT->neonatus_warganegaraortu = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_warganegaraortu_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_warganegaraortu_dws'] : null;
                            $modAsesmenawalkeperawatanT->neonatus_pendidikanortu = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_pendidikanortu_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_pendidikanortu_dws'] : null;

                            $modAsesmenawalkeperawatanT->neonatus_kebiasaanortualkohol_status = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_status_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_status_dws'] : null;
                            $modAsesmenawalkeperawatanT->neonatus_kebiasaanortualkohol_jenis = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_jenis_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_jenis_dws'] : null;
                            $modAsesmenawalkeperawatanT->neonatus_kebiasaanortualkohol_jml = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_jml_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_jml_dws'] : null;
                            $modAsesmenawalkeperawatanT->neonatus_kebiasaanortulainnya = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_kebiasaanortulainnya_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_kebiasaanortulainnya_dws'] : null;
                            $modAsesmenawalkeperawatanT->neonatus_agamaortu = isset($_POST['RJAsesmenawalkeperawatanT']['neonatus_agamaortu_dws']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_agamaortu_dws'] : null;
                            $modAsesmenawalkeperawatanT->resikojatuhkhususrj_hasilpenilaian_a = isset($_POST['RJAsesmenawalkeperawatanT']['resikojatuhkhususrj_hasilpenilaian_a']) ? $_POST['RJAsesmenawalkeperawatanT']['resikojatuhkhususrj_hasilpenilaian_a'] : null;
                            $modAsesmenawalkeperawatanT->resikojatuhkhususrj_hasilpenilaian_b = isset($_POST['RJAsesmenawalkeperawatanT']['resikojatuhkhususrj_hasilpenilaian_b']) ? $_POST['RJAsesmenawalkeperawatanT']['resikojatuhkhususrj_hasilpenilaian_b'] : null;
                            $modAsesmenawalkeperawatanT->resikojatuhkhususrj_hasilpengkajian = isset($_POST['RJAsesmenawalkeperawatanT']['resikojatuhkhususrj_hasilpengkajian']) ? $_POST['RJAsesmenawalkeperawatanT']['resikojatuhkhususrj_hasilpengkajian'] : null;
                            $modAsesmenawalkeperawatanT->resikojatuhkhususrj_tindakanygdiperlukan = isset($_POST['RJAsesmenawalkeperawatanT']['resikojatuhkhususrj_tindakanygdiperlukan']) ? $_POST['RJAsesmenawalkeperawatanT']['resikojatuhkhususrj_tindakanygdiperlukan'] : null;
                        } else if ($modAsesmenawalkeperawatanT->jenisasesmen == 'asesmen_neonatus') {
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bab_keluhanstatus = $_POST['RJAsesmenawalkeperawatanT']['keb_eliminasi_bab_keluhanstatus_neonatus'];
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bab_ispendarahan = $_POST['RJAsesmenawalkeperawatanT']['keb_eliminasi_bab_ispendarahan_neonatus'];
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bab_ishemorroid = $_POST['RJAsesmenawalkeperawatanT']['keb_eliminasi_bab_ishemorroid_neonatus'];
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bab_iskonstipasi = $_POST['RJAsesmenawalkeperawatanT']['keb_eliminasi_bab_iskonstipasi_neonatus'];
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bab_iskeluhanlainnya = $_POST['RJAsesmenawalkeperawatanT']['keb_eliminasi_bab_iskeluhanlainnya_neonatus'];
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bab_jeniskeluhanlainnya = $_POST['RJAsesmenawalkeperawatanT']['keb_eliminasi_bab_jeniskeluhanlainnya_neonatus'];
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bak_keluhanstatus = $_POST['RJAsesmenawalkeperawatanT']['keb_eliminasi_bak_keluhanstatus_neonatus'];
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bak_isnyeri = $_POST['RJAsesmenawalkeperawatanT']['keb_eliminasi_bak_isnyeri_neonatus'];
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bak_ispendarahan = $_POST['RJAsesmenawalkeperawatanT']['keb_eliminasi_bak_ispendarahan_neonatus'];
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bak_iskeluhanlainnya = $_POST['RJAsesmenawalkeperawatanT']['keb_eliminasi_bak_iskeluhanlainnya_neonatus'];
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bak_jeniskeluhanlainnya = $_POST['RJAsesmenawalkeperawatanT']['keb_eliminasi_bak_jeniskeluhanlainnya_neonatus'];
                            $modAsesmenawalkeperawatanT->statusalergipasien = $_POST['RJAsesmenawalkeperawatanT']['statusalergipasien_neonatus'];
                            $modAsesmenawalkeperawatanT->riwayatalergiobat = $_POST['RJAsesmenawalkeperawatanT']['riwayatalergiobat_neonatus'];
                            $modAsesmenawalkeperawatanT->riwayatalergimakanan = $_POST['RJAsesmenawalkeperawatanT']['riwayatalergimakanan_neonatus'];
                            $modAsesmenawalkeperawatanT->riwayatalergilainnya = $_POST['RJAsesmenawalkeperawatanT']['riwayatalergilainnya_neonatus'];
                            $modAsesmenawalkeperawatanT->ispasangtandaalergi = $_POST['RJAsesmenawalkeperawatanT']['ispasangtandaalergi_neonatus'];
                        } else if ($modAsesmenawalkeperawatanT->jenisasesmen == 'asesmen_obgyn') {
                            $modAsesmenawalkeperawatanT->jam_masukruangan = $_POST['RJAsesmenawalkeperawatanT']['jam_masukruangan_obgyn'];
                            $modAsesmenawalkeperawatanT->tgl_assesmen_awal = MyFormatter::formatDateTimeForDb($_POST['RJAsesmenawalkeperawatanT']['tgl_assesmen_awal_obgyn']);
                            $modAsesmenawalkeperawatanT->keluhanutama = isset($_POST['RJAsesmenawalkeperawatanT']['keluhanutama_obgyn']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['keluhanutama_obgyn']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['keluhanutama_obgyn']) : null) : null;
                            $modAsesmenawalkeperawatanT->keluhantambahan = isset($_POST['RJAsesmenawalkeperawatanT']['keluhantambahan_obgyn']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['keluhantambahan_obgyn']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['keluhantambahan_obgyn']) : null) : null;

                            $modAsesmenawalkeperawatanT->obgyn_mensterakhir = (!empty($_POST['RJAsesmenawalkeperawatanT']['obgyn_mensterakhir']) ? MyFormatter::formatDateTimeForDb($_POST['RJAsesmenawalkeperawatanT']['obgyn_mensterakhir']) : null);
                            $modAsesmenawalkeperawatanT->obgyn_taksiranpersalinan = (!empty($_POST['RJAsesmenawalkeperawatanT']['obgyn_taksiranpersalinan']) ? MyFormatter::formatDateTimeForDb($_POST['RJAsesmenawalkeperawatanT']['obgyn_taksiranpersalinan']) : null);


                            // $modAsesmenawalkeperawatanT->kondisiumum = isset($_POST['RIAsesmenawalkeperawatanT']['kondisiumum_dws']) ? ((count($_POST['RIAsesmenawalkeperawatanT']['kondisiumum_dws'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['kondisiumum_dws']) : '') : '';
                            // $modAsesmenawalkeperawatanT->kepala_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['kepala_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['kepala_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->mata_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['mata_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['mata_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->leher_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['leher_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['leher_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->hidung_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['hidung_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['hidung_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->telinga_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['telinga_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['telinga_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->mulut_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['mulut_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['mulut_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->jantung_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['jantung_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['jantung_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->paru_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['paru_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['paru_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->abdomen_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['abdomen_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['abdomen_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->genitalia_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['genitalia_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['genitalia_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->extremitasatas_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['extremitasatas_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['extremitasatas_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->extremitasbawah_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['extremitasbawah_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['extremitasbawah_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->kulit_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['kulit_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['kulit_abnormalketerangan_dws']:null;
                            // $modAsesmenawalkeperawatanT->neonatus_kebsosialekonomi_statusperkawinan = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan_dws']:null;
                            // $modAsesmenawalkeperawatanT->neonatus_tinggalbersamalainnya_notlp = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersamalainnya_notlp_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersamalainnya_notlp_dws']:null;
                            // $modAsesmenawalkeperawatanT->neonatus_tinggalbersamalainnya_nama = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersamalainnya_nama_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersamalainnya_nama_dws']:null;
                            // $modAsesmenawalkeperawatanT->neonatus_tinggalbersama = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama_dws']:null;
                            // $modAsesmenawalkeperawatanT->neonatus_pekerjaanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu_dws']:null;
                            // $modAsesmenawalkeperawatanT->neonatus_warganegaraortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu_dws']:null;
                            // $modAsesmenawalkeperawatanT->neonatus_pendidikanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu_dws']:null;
                            //
                    // $modAsesmenawalkeperawatanT->neonatus_kebiasaanortualkohol_status = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_status_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_status_dws']:null;
                            // $modAsesmenawalkeperawatanT->neonatus_kebiasaanortualkohol_jenis = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_jenis_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_jenis_dws']:null;
                            // $modAsesmenawalkeperawatanT->neonatus_kebiasaanortualkohol_jml = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_jml_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_kebiasaanortualkohol_jml_dws']:null;
                            // $modAsesmenawalkeperawatanT->neonatus_kebiasaanortulainnya = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_kebiasaanortulainnya_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_kebiasaanortulainnya_dws']:null;
                            // $modAsesmenawalkeperawatanT->neonatus_agamaortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu_dws'])?$_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu_dws']:null;
                        } else {
                            $modAsesmenawalkeperawatanT->jam_masukruangan = $_POST['RJAsesmenawalkeperawatanT']['jam_masukruangan'];
                            $modAsesmenawalkeperawatanT->tgl_assesmen_awal = MyFormatter::formatDateTimeForDb($_POST['RJAsesmenawalkeperawatanT']['tgl_assesmen_awal']);
                            $modAsesmenawalkeperawatanT->keluhanutama = isset($_POST['RJAsesmenawalkeperawatanT']['keluhanutama']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['keluhanutama']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['keluhanutama']) : null) : null;
                            $modAsesmenawalkeperawatanT->keluhantambahan = isset($_POST['RJAsesmenawalkeperawatanT']['keluhantambahan']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['keluhantambahan']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['keluhantambahan']) : null) : null;
                            $modAsesmenawalkeperawatanT->kondisiumum = isset($_POST['RJAsesmenawalkeperawatanT']['kondisiumum']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['kondisiumum']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['kondisiumum']) : null) : null;
                        }
                        $modAsesmenawalkeperawatanT->neonatus_tgllahirbayi = (!empty($_POST['RJAsesmenawalkeperawatanT']['neonatus_tgllahirbayi']) ? MyFormatter::formatDateTimeForDb($_POST['RJAsesmenawalkeperawatanT']['neonatus_tgllahirbayi']) : null);
                        $modAsesmenawalkeperawatanT->neonatus_jamlahir = (!empty($_POST['RJAsesmenawalkeperawatanT']['neonatus_jamlahir']) ? $_POST['RJAsesmenawalkeperawatanT']['neonatus_jamlahir'] : null);

                        $modAsesmenawalkeperawatanT->riwayatkelahiran = isset($_POST['RJAsesmenawalkeperawatanT']['riwayatkelahiran']) ? ((count($_POST['RJAsesmenawalkeperawatanT']['riwayatkelahiran']) > 0) ? implode(', ', $_POST['RJAsesmenawalkeperawatanT']['riwayatkelahiran']) : null) : null;
                        $modAsesmenawalkeperawatanT->riwayatperjalanan_penyakitpasien = isset($_POST['RJAsesmenawalkeperawatanT']['riwayatperjalanan_penyakitpasien']) ? $_POST['RJAsesmenawalkeperawatanT']['riwayatperjalanan_penyakitpasien'] : null;

                        $statusAlergi = null;
                        if (!empty($modAsesmenawalkeperawatanT->statusalergipasien)) {
                            if ($modAsesmenawalkeperawatanT->statusalergipasien == '1') {
                                $statusAlergi = "Tidak Ada";
                            } else if ($modAsesmenawalkeperawatanT->statusalergipasien == '2') {
                                $statusAlergi = "Tidak Tahu";
                            } else if ($modAsesmenawalkeperawatanT->statusalergipasien == '3') {
                                $statusAlergi = "Ada";
                            }
                        }
                        $modAsesmenawalkeperawatanT->statusalergipasien = $statusAlergi;

                        if ($modAsesmenawalkeperawatanT->neonatus_dukungansosialdr_issuami) {
                            $modAsesmenawalkeperawatanT->neonatus_dukungansosialdr = "Suami";
                        }

                        if ($modAsesmenawalkeperawatanT->neonatus_dukungansosialdr_isistri) {
                            $modAsesmenawalkeperawatanT->neonatus_dukungansosialdr = "Istri";
                        }

                        if ($modAsesmenawalkeperawatanT->neonatus_dukungansosialdr_isortu) {
                            $modAsesmenawalkeperawatanT->neonatus_dukungansosialdr = "Orang Tua";
                        }

                        if ($modAsesmenawalkeperawatanT->neonatus_dukungansosialdr_iskeluarga) {
                            $modAsesmenawalkeperawatanT->neonatus_dukungansosialdr = "Keluarga";
                        }

                        if ($modAsesmenawalkeperawatanT->neonatus_dukungansosialdr_islainnya) {
                            $modAsesmenawalkeperawatanT->neonatus_dukungansosialdr = "Lainnya";
                        }

                        if ($modAsesmenawalkeperawatanT->kebutuhankhusus_isgigipalsu) {
                            $modAsesmenawalkeperawatanT->kebutuhankhusus_ketgigipalsu = "Gigi Palsu";
                        }

                        if ($modAsesmenawalkeperawatanT->kebutuhankhusus_isalatbantudengar) {
                            $modAsesmenawalkeperawatanT->kebutuhankhusus_ketalatbantudengar = "Alat Bantu Dengar";
                        }

                        if ($modAsesmenawalkeperawatanT->kebutuhankhusus_ispakaikacamata) {
                            $modAsesmenawalkeperawatanT->kebutuhankhusus_ketpakaikacamata = "Kacamata";
                        }

                        if ($modAsesmenawalkeperawatanT->kebutuhankhusus_istongkat) {
                            $modAsesmenawalkeperawatanT->kebutuhankhusus_kettongkat = "Tongkat";
                        }

                        if ($modAsesmenawalkeperawatanT->kebutuhankhusus_islainnya) {
                            $modAsesmenawalkeperawatanT->kebutuhankhusus_ketlainnya = "Lainnya";
                        }

                        if ($modAsesmenawalkeperawatanT->statuspsikologis_isstabil) {
                            $modAsesmenawalkeperawatanT->statuspsikologis_ketstabil = "Stabil / Tenang";
                        }

                        if ($modAsesmenawalkeperawatanT->statuspsikologis_iscemas) {
                            $modAsesmenawalkeperawatanT->kebutuhankhusus_ketcemas = "Cemas / Takut";
                        }

                        if ($modAsesmenawalkeperawatanT->statuspsikologis_ismarah) {
                            $modAsesmenawalkeperawatanT->statuspsikologis_ketmarah = "Marah";
                        }

                        if ($modAsesmenawalkeperawatanT->statuspsikologis_issedih) {
                            $modAsesmenawalkeperawatanT->statuspsikologis_ketsedih = "Sedih";
                        }

                        if (!isset($modAsesmenawalkeperawatanT->is_keluhannyeri_dewasa) || empty($modAsesmenawalkeperawatanT->is_keluhannyeri_dewasa)) {
                            $modAsesmenawalkeperawatanT->score_skalanyeri = (isset($_POST['RJAsesmenawalkeperawatanT']['score_skalanyeri_anak']) ? $_POST['RJAsesmenawalkeperawatanT']['score_skalanyeri_anak'] : null);
                            $modAsesmenawalkeperawatanT->keteranganskala_nyeri = (isset($_POST['RJAsesmenawalkeperawatanT']['keteranganskala_nyeri_anak']) ? $_POST['RJAsesmenawalkeperawatanT']['keteranganskala_nyeri_anak'] : null);
                        }

                        if ($modAsesmenawalkeperawatanT->isnyerihilangdgn_minumobat) {
                            $modAsesmenawalkeperawatanT->nyerihilangdgn_minumobatket = "Minum Obat";
                        }

                        if ($modAsesmenawalkeperawatanT->isnyerihilangdgn_berubahposisi) {
                            $modAsesmenawalkeperawatanT->nyerihilangdgn_berubahposisiket = "Berubah posisi/tidur";
                        }

                        if ($modAsesmenawalkeperawatanT->isnyerihilangdgn_istirahat) {
                            $modAsesmenawalkeperawatanT->nyerihilangdgn_istirahatket = "Istirahat";
                        }

                        if ($modAsesmenawalkeperawatanT->isnyerihilangdgn_dengarmusik) {
                            $modAsesmenawalkeperawatanT->nyerihilangdgn_dengarmusikket = "Mendengarkan Musik";
                        }

                        if ($modAsesmenawalkeperawatanT->isnyerihilangdgn_lainlain) {
                            $modAsesmenawalkeperawatanT->nyerihilangdgn_lainlainket = "Lain-lain";
                        }

                        if ($modAsesmenawalkeperawatanT->keb_nutricairankeluhan_ismual) {
                            $modAsesmenawalkeperawatanT->keb_nutricairankeluhan_mualket = "Mual";
                        }
                        if ($modAsesmenawalkeperawatanT->keb_nutricairankeluhan_ismuntah) {
                            $modAsesmenawalkeperawatanT->keb_nutricairankeluhan_muntahket = "Muntah";
                        }
                        if ($modAsesmenawalkeperawatanT->keb_nutricairankeluhan_isgangguanmengunyah) {
                            $modAsesmenawalkeperawatanT->keb_nutricairankeluhan_gangguanmengunyahket = "Gangguan Mengunyah";
                        }
                        if ($modAsesmenawalkeperawatanT->keb_nutricairankeluhan_isgangguanmenelan) {
                            $modAsesmenawalkeperawatanT->keb_nutricairankeluhan_gangguanmenelanket = "Gangguan Menelan";
                        }

                        if ($modAsesmenawalkeperawatanT->keb_eliminasi_bab_ispendarahan) {
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bab_ketpendarahan = "Pendarahan";
                        }

                        if ($modAsesmenawalkeperawatanT->keb_eliminasi_bab_ishemorroid) {
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bab_kethemorroid = "Hemorroid";
                        }

                        if ($modAsesmenawalkeperawatanT->keb_eliminasi_bab_iskonstipasi) {
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bab_ketkonstipasi = "Konstipasi";
                        }

                        if ($modAsesmenawalkeperawatanT->keb_eliminasi_bab_iskeluhanlainnya) {
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bab_ketkeluhanlainnya = "Lainnya";
                        }

                        if ($modAsesmenawalkeperawatanT->keb_eliminasi_bak_ispendarahan) {
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bak_ketpendarahan = "Pendarahan";
                        }

                        if ($modAsesmenawalkeperawatanT->keb_eliminasi_bak_isnyeri) {
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bak_ketnyeri = "Nyeri";
                        }

                        if ($modAsesmenawalkeperawatanT->keb_eliminasi_bak_iskeluhanlainnya) {
                            $modAsesmenawalkeperawatanT->keb_eliminasi_bak_ketkeluhanlainnya = "Lainnya";
                        }

                        if ($modAsesmenawalkeperawatanT->identifikasipenyakit_ismenular) {
                            $modAsesmenawalkeperawatanT->identifikasipenyakit_ketmenular = "Penyakit Menular";
                        }

                        if ($modAsesmenawalkeperawatanT->identifikasipenyakit_ispenyakitjiwa) {
                            $modAsesmenawalkeperawatanT->identifikasipenyakit_ketpenyakitjiwa = "Penyakit Jiwa";
                        }

                        if ($modAsesmenawalkeperawatanT->identifikasipenyakitjiwa_iscenderungbunuhdiri) {
                            $modAsesmenawalkeperawatanT->identifikasipenyakit_ketcenderungbunuhdiri = "cenderung Bunuh Diri";
                        }

                        if ($modAsesmenawalkeperawatanT->identifikasipenyakitjiwa_isberlakuagresif) {
                            $modAsesmenawalkeperawatanT->identifikasipenyakit_ketberlakuagresif = "Berlaku Agresif";
                        }

                        if ($modAsesmenawalkeperawatanT->identifikasipenyakitjiwa_islainnya) {
                            $modAsesmenawalkeperawatanT->identifikasipenyakit_ketlainnya = "Lainnya";
                        }

                        if (!empty($modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id)) {
                            $modAsesmenawalkeperawatanT->update_time = date('Y-m-d H:i:s');
                            $modAsesmenawalkeperawatanT->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                        } else {
                            $modAsesmenawalkeperawatanT->create_time = date('Y-m-d H:i:s');
                            $modAsesmenawalkeperawatanT->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                        }
                        $modAsesmenawalkeperawatanT->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                        $modAsesmenawalkeperawatanT->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");

                        $arrRisikoInfeksi = array();

                        if (isset($_POST['RisikoInfeksi']) && count($_POST['RisikoInfeksi']) > 0) {
                            foreach ($_POST['RisikoInfeksi'] as $dataRisiko) {
                                if (isset($dataRisiko['isRisiko']) && $dataRisiko['isRisiko'] == 1) {
                                    $arrRisikoInfeksi[] = $dataRisiko['jenisrisiko'];
                                }
                            }
                        }

                        if (count($arrRisikoInfeksi) > 0) {
                            $modAsesmenawalkeperawatanT->jenisrisikoinfeksi = json_encode($arrRisikoInfeksi);
                        }

                        $arrAddtional = array();

                        if (isset($_POST['Addtional']) && count($_POST['Addtional']) > 0) {
                            foreach ($_POST['Addtional'] as $dataAddtion) {
                                if (isset($dataAddtion['isaddtional_precaution']) && $dataAddtion['isaddtional_precaution'] == 1) {
                                    $arrAddtional[] = $dataAddtion['addtional_precaution'];
                                }
                            }
                        }
                        if (count($arrAddtional) > 0) {
                            $modAsesmenawalkeperawatanT->addtional_precaution = json_encode($arrAddtional);
                        }

                        $arrKualitasNyeri = array();

                        if (isset($_POST['KualitasNyeri']) && count($_POST['KualitasNyeri']) > 0) {
                            foreach ($_POST['KualitasNyeri'] as $dataKualitas) {
                                if (isset($dataKualitas['isKualitas']) && $dataKualitas['isKualitas'] == 1) {
                                    $arrKualitasNyeri[] = $dataKualitas['nama'];
                                }
                            }
                        }
                        if (count($arrKualitasNyeri) > 0) {
                            $modAsesmenawalkeperawatanT->kualitasnyeri = json_encode($arrKualitasNyeri);
                        }

                        $arrFrekuensiNyeri = array();

                        if (isset($_POST['FrekuensiNyeri']) && count($_POST['FrekuensiNyeri']) > 0) {
                            foreach ($_POST['FrekuensiNyeri'] as $dataFrekuensi) {
                                if (isset($dataFrekuensi['isFrekuensi']) && $dataFrekuensi['isFrekuensi'] == 1) {
                                    $arrFrekuensiNyeri[] = $dataFrekuensi['nama'];
                                }
                            }
                        }
                        if (count($arrFrekuensiNyeri) > 0) {
                            $modAsesmenawalkeperawatanT->deskripsinyeri_frekuensinyeri = json_encode($arrFrekuensiNyeri);
                        }

                        $arrKeluhanHamil = array();

                        if (isset($_POST['KeluhanHamil']) && count($_POST['KeluhanHamil']) > 0) {
                            foreach ($_POST['KeluhanHamil'] as $dataKeluhan) {
                                if (isset($dataFrekuensi['isFrekuensi']) && $dataFrekuensi['isFrekuensi'] == 1) {
                                    $arrKeluhanHamil[] = $dataFrekuensi['nama'];
                                }
                            }
                        }
                        if (count($arrKeluhanHamil) > 0) {
                            $modAsesmenawalkeperawatanT->obgyn_keluhansaathamil = json_encode($arrKeluhanHamil);
                        }

                        // $modAsesmenawalkeperawatanT->resikojatuh_tingkat = 'Risiko Rendah';

                        if ($modAsesmenawalkeperawatanT->save()) {
                            $this->tersimpanAsesmenAwalKep = true;

                            if (isset($_POST['RJSkrinningnyerianakdetT'])) {
                                if (count($_POST['RJSkrinningnyerianakdetT']) > 0) {
                                    RJSkrinningnyerianakdetT::model()->deleteAllByAttributes(array('asesmenawalkeperawatan_id' => $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                                    foreach ($_POST['RJSkrinningnyerianakdetT'] as $dataDet) {
                                        if (!empty($dataDet['kat_skalanyeri_id'])) {
                                            $modelDet = new RJSkrinningnyerianakdetT();
                                            $modelDet->kat_skalanyeri_id = $dataDet['kat_skalanyeri_id'];
                                            $modelDet->skalanyeriflaccs_param = $dataDet['skalanyeriflaccs_param'];
                                            $modelDet->skalanyeriflaccs_nilai = $dataDet['skalanyeriflaccs_nilai'];
                                            $modelDet->tgl_asesmentnyerianakdet = date('Y-m-d H:i:s');

                                            $modelDet->asesmenawalkeperawatan_id = $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id;
                                            $modelDet->create_time = date('Y-m-d H:i:s');
                                            $modelDet->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                            $modelDet->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                                            $modelDet->create_pegawaipengisi_id = Yii::app()->user->getState("pegawai_id");

                                            if (!$modelDet->save()) {
                                                $tersimpandetailNyeri = false;
                                            }
                                        }
                                    }
                                }
                            }

                            if (isset($_POST['AsesmentumbuhkembanganakT'])) {
                                if (count($_POST['AsesmentumbuhkembanganakT']) > 0) {
                                    AsesmentumbuhkembanganakT::model()->deleteAllByAttributes(array('asesmenawalkeperawatan_id' => $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                                    foreach ($_POST['AsesmentumbuhkembanganakT'] as $dataTmb) {
                                        if (!empty($dataTmb['ischeckbox']) && $dataTmb['ischeckbox'] == '1') {
                                            $modelDet = new AsesmentumbuhkembanganakT();
                                            $modelDet->tumbuhkembanganak_jenis = $dataTmb['tumbuhkembanganak_jenis'];
                                            $modelDet->tumbuhkembanganak_usia = $dataTmb['tumbuhkembanganak_usia'];
                                            $modelDet->asesmenawalkeperawatan_id = $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id;

                                            if (!$modelDet->save()) {
                                                $tersimpanTumbuhKembang = false;
                                            }
                                        }
                                    }
                                }
                            }

                            if (isset($_POST['RiwayatKehamilan'])) {
                                if (count($_POST['RiwayatKehamilan']) > 0) {
                                    RiwayatobstetrikpasienT::model()->deleteAllByAttributes(array('asesmenawalkeperawatan_id' => $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                                    foreach ($_POST['RiwayatKehamilan'] as $dataTmb) {
                                        $modelDetObs = new RiwayatobstetrikpasienT();
                                        $modelDetObs->asesmenawalkeperawatan_id = $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id;
                                        $modelDetObs->kehamilan_hamilke = $dataTmb['hamilke'];
                                        $modelDetObs->kehamilan_umur = $dataTmb['umurkehamilan'];
                                        $modelDetObs->anak_beratbadanlahir = $dataTmb['beratbadan'];
                                        $modelDetObs->anak_satuanberatbadan = $dataTmb['beratbadan_status'];
                                        $modelDetObs->anak_jeniskelamin = $dataTmb['jeniskelamin'];
                                        $modelDetObs->persalinan_cara = $dataTmb['carapersalinan'];
                                        $modelDetObs->persalinan_penolong = $dataTmb['penolongpersalinan'];
                                        $modelDetObs->persalinan_tempat = $dataTmb['tempatpersalinan'];
                                        $modelDetObs->isabortur = (!empty($dataTmb['abortus']) ? (($dataTmb['abortus'] == 'Ya') ? true : false) : false);
                                        $modelDetObs->persalinan_komplikasiket = $dataTmb['keterangan'];

                                        if (!$modelDetObs->save()) {
                                            $tersimpanRiwayatObs = false;
                                        }
                                    }
                                }
                            }

                            if (isset($_POST['RJAsesmenkebutuhanEdukasiT'])) {
                                $modAsesmenkebutuhanEdukasiT->attributes = $_POST['RJAsesmenkebutuhanEdukasiT'];
                                $modAsesmenkebutuhanEdukasiT->asesmenawalkeperawatan_id = $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id;

                                if ($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_pasien) {
                                    $modAsesmenkebutuhanEdukasiT->penerimaedukasi_pasien = "Pasien";
                                }

                                if ($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_pasien) {
                                    $modAsesmenkebutuhanEdukasiT->penerimaedukasi_keluargapasien = "Keluarga Pasien";
                                }

                                if ($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_lainnya) {
                                    $modAsesmenkebutuhanEdukasiT->penerimaedukasi_lainnya = "Lainnya";
                                }

                                if ($modAsesmenawalkeperawatanT->jenisasesmen == 'asesmen_neonatus') {
                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_bahasa_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_bahasa = "Bahasa";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_pendengaran_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_pendengaran = "Pendengaran";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_penglihatan_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_penglihatan = "Penglihatan";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_motivasi_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_motivasi = "Motivasi";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_fisik_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_fisik = "Fisik";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_emosi_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_emosi = "Emosi";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_butahuruf_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_butahuruf = "Buta Huruf";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_usia_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_usia = "Usia";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_kognitif_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_kognitif = "Kognitif";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_tidakada_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_tidakada = "Tida Ada";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_menulis_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_menulis = "Menulis";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_audiovisual_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_audiovisual = "Audio-Visul/ gambar";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_diskusi_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_diskusi = "Diskusi";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_demonstrasi_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_demonstrasi = "Demonstrasi";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_membaca_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_membaca = "Membaca";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_mendengarkan_neonatus) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_mendengarkan = "Mendengarkan";
                                    }

                                    $modAsesmenkebutuhanEdukasiT->bicara_status = $_POST['RJAsesmenkebutuhanEdukasiT']['bicara_status_neonatus'];
                                    $modAsesmenkebutuhanEdukasiT->mulaiseranganawal = (isset($_POST['RJAsesmenkebutuhanEdukasiT']['mulaiseranganawal_neonatus']) ? $_POST['RJAsesmenkebutuhanEdukasiT']['mulaiseranganawal_neonatus'] : null);
                                    $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status = (isset($_POST['RJAsesmenkebutuhanEdukasiT']['kebutuhanpenerjemah_status_neonatus']) ? $_POST['RJAsesmenkebutuhanEdukasiT']['kebutuhanpenerjemah_status_neonatus'] : null);
                                    $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_jenisbahasa = (isset($_POST['RJAsesmenkebutuhanEdukasiT']['kebutuhanpenerjemah_jenisbahasa_neonatus']) ? $_POST['RJAsesmenkebutuhanEdukasiT']['kebutuhanpenerjemah_jenisbahasa_neonatus'] : null);
                                    $modAsesmenkebutuhanEdukasiT->bahasaisyarat_status = (isset($_POST['RJAsesmenkebutuhanEdukasiT']['bahasaisyarat_status_neonatus']) ? $_POST['RJAsesmenkebutuhanEdukasiT']['bahasaisyarat_status_neonatus'] : null);
                                } else {
                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_bahasa) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_bahasa = "Bahasa";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_pendengaran) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_pendengaran = "Pendengaran";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_penglihatan) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_penglihatan = "Penglihatan";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_motivasi) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_motivasi = "Motivasi";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_fisik) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_fisik = "Fisik";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_emosi) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_emosi = "Emosi";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_butahuruf) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_butahuruf = "Buta Huruf";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_usia) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_usia = "Usia";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_kognitif) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_kognitif = "Kognitif";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_tidakada) {
                                        $modAsesmenkebutuhanEdukasiT->hambatanbelajar_tidakada = "Tida Ada";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_menulis) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_menulis = "Menulis";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_audiovisual) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_audiovisual = "Audio-Visul/ gambar";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_diskusi) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_diskusi = "Diskusi";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_demonstrasi) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_demonstrasi = "Demonstrasi";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_membaca) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_membaca = "Membaca";
                                    }

                                    if ($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_mendengarkan) {
                                        $modAsesmenkebutuhanEdukasiT->carabelajardisukai_mendengarkan = "Mendengarkan";
                                    }
                                }



                                if (!empty($modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id)) {
                                    $modAsesmenkebutuhanEdukasiT->update_time = date('Y-m-d H:i:s');
                                    $modAsesmenkebutuhanEdukasiT->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                } else {
                                    $modAsesmenkebutuhanEdukasiT->create_time = date('Y-m-d H:i:s');
                                    $modAsesmenkebutuhanEdukasiT->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                }
                                $modAsesmenkebutuhanEdukasiT->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                                $modAsesmenkebutuhanEdukasiT->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");




                                if ($modAsesmenkebutuhanEdukasiT->save()) {
                                    $this->tersimpanKebEdukasi = true;

                                    if (isset($_POST['RJAsesmenkebutuhanEdukasidetT']) && count($_POST['RJAsesmenkebutuhanEdukasidetT']) > 0) {
                                        RJAsesmenkebutuhanEdukasidetT::model()->deleteAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));

                                        foreach ($_POST['RJAsesmenkebutuhanEdukasidetT'] as $dataEduDet) {
                                            if (!empty($dataEduDet['isedukasipasien']) && $dataEduDet['isedukasipasien'] == '1') {
                                                $modelDet = new RJAsesmenkebutuhanEdukasidetT();
                                                $modelDet->asesmenkebutuhan_edukasi_id = $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id;
                                                $modelDet->edukasipasien = $dataEduDet['edukasipasien'];
                                                $modelDet->edukasipasien_lainnya = isset($dataEduDet['edukasipasien_lainnya']) ? $dataEduDet['edukasipasien_lainnya'] : null;

                                                if (!$modelDet->save()) {
                                                    $tersimpandetailEdukasi = false;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $this->tersimpanKebEdukasi = false;
                                }
                            }
                        } else {
                            $this->tersimpanAsesmenAwalKep = false;
                        }
                    }


                    // echo $this->tersimpanAsesmenAwalKep.' == '.$tersimpandetailNyeri.' == '.$this->tersimpanKebEdukasi.' == '.$tersimpandetailEdukasi.' == '.$tersimpanTumbuhKembang .' == '. $tersimpanRiwayatObs;
                    // exit();
                    if ($this->tersimpanAsesmenAwalKep == true && $tersimpandetailNyeri == true && $this->tersimpanKebEdukasi == true && $tersimpandetailEdukasi == true && $tersimpanTumbuhKembang == true && $tersimpanRiwayatObs == true) {
                        $transaction->commit();
                        $sukses = 1;
                        $pesan = "Data Berhasil disimpan!!";
                    } else {
                        $transaction->rollback();
                        $sukses = 0;
                        $pesan = "Data gagal Disimpan 2!!";
                    }
                } catch (Exception $ex) {
                    // echo '<pre>';
                    // print_r($ex);
                    // exit();
                    $transaction->rollback();
                    $sukses = 0;
                    $pesan = "Data gagal Disimpan!! " . MyExceptionMessage::getMessage($ex, true);
                }
            }
            $data['sukses'] = $sukses;
            $data['pesan'] = $pesan;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionDetail($asesmenawalkeperawatan_id) {
        $this->layout = '//layouts/iframe';

        $model = RJAsesmenawalkeperawatanT::model()->findByPk($asesmenawalkeperawatan_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
        $modPasien = PasienM::model()->findByPk($model->pasien_id);
        $ruanganid = $modPendaftaran->ruangan_id;

        if (isset($modPasienAdmisi) && !empty($modPasienAdmisi)) {
            $ruanganid = $modPasienAdmisi->ruangan_id;
        }

        $criFla = new CDbCriteria();
        $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
        $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
        $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
        $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);

        $getFlaCcs = null;

        $dataFlaCcs = array();
        $cekFlaCcs = array();

        $modSkrinningnyerianakdetT = array();
        $modAsesmenkebutuhanEdukasidetT = null;

        if (isset($model)) {
            $modSkrinningnyerianakdetT = SkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

            $modAsesmenkebutuhanEdukasiT = AsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

            if (isset($modAsesmenkebutuhanEdukasiT)) {
                $modAsesmenkebutuhanEdukasidetT = AsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));
            } else {
                $modAsesmenkebutuhanEdukasiT = new AsesmenkebutuhanEdukasiT();
                $modAsesmenkebutuhanEdukasidetT = new AsesmenkebutuhanEdukasidetT();
            }
        } else {
            $modAsesmenkebutuhanEdukasiT = new AsesmenkebutuhanEdukasiT();
            $modAsesmenkebutuhanEdukasidetT = new AsesmenkebutuhanEdukasidetT();
        }

        if (count($modSkrinningnyerianakdetT) > 0) {
            $getFlaCcs = $modSkrinningnyerianakdetT;

            if (count($getFlaCcs) > 0) {
                foreach ($getFlaCcs as $det) {
                    $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->skrinningnyerianakdet_id;
                    $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
                    $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
                    $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
                    $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->asesmenawalkeperawatan_id;
                }
            }
        } else {
            $modSkrinningnyerianakdetT = new SkrinningnyerianakdetT();
        }

        foreach ($modNyeriFlaCcs as $dtF) {
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori_id"] = $dtF->kat_skalanyeri_id;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_anak_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_kat_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_params"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['params']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['params'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_nilai"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
                'id' => isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null,
                'keterangan' => $dtF->skalanyeriflaccs_desc
            );
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] : null;
        }

        $model->kepala_hasilperiksa = ($model->kepala_hasilperiksa == true) ? 1 : 0;
        $model->mata_hasilperiksa = ($model->mata_hasilperiksa == true) ? 1 : 0;
        $model->leher_hasilperiksa = ($model->leher_hasilperiksa == true) ? 1 : 0;
        $model->hidung_hasilperiksa = ($model->hidung_hasilperiksa == true) ? 1 : 0;
        $model->telinga_hasilperiksa = ($model->telinga_hasilperiksa == true) ? 1 : 0;
        $model->mulut_hasilperiksa = ($model->mulut_hasilperiksa == true) ? 1 : 0;
        $model->jantung_hasilperiksa = ($model->jantung_hasilperiksa == true) ? 1 : 0;
        $model->paru_hasilperiksa = ($model->paru_hasilperiksa == true) ? 1 : 0;
        $model->abdomen_hasilperiksa = ($model->abdomen_hasilperiksa == true) ? 1 : 0;
        $model->genitalia_hasilperiksa = ($model->genitalia_hasilperiksa == true) ? 1 : 0;
        $model->extremitasatas_hasilperiksa = ($model->extremitasatas_hasilperiksa == true) ? 1 : 0;
        $model->extremitasbawah_hasilperiksa = ($model->extremitasbawah_hasilperiksa == true) ? 1 : 0;
        $model->kulit_hasilperiksa = ($model->kulit_hasilperiksa == true) ? 1 : 0;
        $model->statusmerokok = ($model->statusmerokok == true) ? 1 : 0;
        $model->deskripsinyeri_ismenjalar = ($model->deskripsinyeri_ismenjalar == true) ? 1 : 0;
        $model->deformitas_status = ($model->deformitas_status == true) ? 1 : 0;
        $model->gangguantidur_status = ($model->gangguantidur_status == true) ? 1 : 0;
        $model->keb_nutricairan_rasahausberlebih = ($model->keb_nutricairan_rasahausberlebih == true) ? 1 : 0;
        $model->keb_nutricairan_edemastatus = ($model->keb_nutricairan_edemastatus == true) ? 1 : 0;
        $model->riwayatjatuh_3bln_terakhir = ($model->riwayatjatuh_3bln_terakhir) ? 1 : 0;
        $model->riwayatjatuh_alatbantu = ($model->riwayatjatuh_alatbantu) ? 1 : 0;


        if ($model->isskrinninggizidewasa) {
            $model->skrinninggizi_jwb_penurunanbb_dewasa_text = $model->skrinninggizi_skor_penurunanbb_dewasa;
            $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = $model->skrinninggizi_skor_asupanmakanan_dewasa;

            $model->skrinninggizi_jwb_tampakkurus_text = null;
            $model->skrinninggizi_jwb_penurunanbb_text = null;
            $model->skrinninggizi_jwb_kondisi_text = null;
            $model->skrinninggizi_jwb_penyakit_text = null;
        } else {
            $model->skrinninggizi_jwb_penurunanbb_dewasa_text = null;
            $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = null;

            $model->skrinninggizi_jwb_tampakkurus_text = $model->skrinninggizi_skor_tampakkurus;
            $model->skrinninggizi_jwb_penurunanbb_text = $model->skrinninggizi_skor_penurunanbb;
            $model->skrinninggizi_jwb_kondisi_text = $model->skrinninggizi_skor_kondisi;
            $model->skrinninggizi_jwb_penyakit_text = $model->skrinninggizi_skor_penyakit;
        }

        $model->riwayatjatuh_penilaian_text = $model->riwayatjatuh_penilaian;
        $model->diagnosismedis_penilaian_text = $model->diagnosismedis_skor;
        $model->alatbantujalan_penilaian_text = (($model->alatbantujalan_skor != null) ? $model->alatbantujalan_skor : null);
        $model->memakaiterapiheparin_penilaian_text = $model->memakaiterapiheparin_penilaian;
        $model->caraberjalan_penilaian_text = (($model->caraberjalan_skor != null) ? $model->caraberjalan_skor : null);
        $model->statusmental_penilaian_text = (($model->statusmental_skor != null) ? $model->statusmental_skor : null);
        $model->usia_anak_text = $model->skor_usia_anak;
        $model->jeniskelamin_anak_text = $model->skor_jeniskelamin_anak;
        $model->diagnosa_asessment_anak_text = $model->skor_diagnosa_anak;
        $model->gangguan_kognitif_anak_text = $model->skor_gangguan_kognitif_anak;

        $model->faktor_lingkungan_anak_text = $model->skor_faktor_lingkungan_anak;
        $model->responterhadap_pembedahan_anak_text = $model->skor_responterhadap_pembedahan_anak;
        $model->penggunaan_medikamentosa_text = $model->skor_medikamentosa_anak;



        $modAsesmenpasinIgd = AsesmenpasienigdT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruanganid));
        $masalahKeperawatan = "";
        $rencanaKeperawatan = "";
        $tindakanKeperawatan = "";

        if (isset($modAsesmenpasinIgd)) {
            $modAskepMasalah = AsesmenmasalahkepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));

            if (count($modAskepMasalah) > 0) {

                foreach ($modAskepMasalah as $i => $askepMasalah) {
                    if ($i > 0) {
                        $masalahKeperawatan .= ", ";
                    }
                    $masalahKeperawatan .= (isset($askepMasalah->masalahkeperawatan) ? $askepMasalah->masalahkeperawatan->masalahkeperawatan_nama : "");
                }
            }

            $modAskepRencana = AsesmenrencanakepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));
            if (count($modAskepRencana) > 0) {

                foreach ($modAskepRencana as $i => $askepRencana) {
                    if ($i > 0) {
                        $rencanaKeperawatan .= "<br />";
                    }

                    $rencanaKeperawatan .= "- " . (isset($askepRencana->rencanakeperawatanigd) ? $askepRencana->rencanakeperawatanigd->rencanakeperawatan_nama : "");
                }
            }

            $modAskepTindakan = AsesmentindakankepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));
            if (count($modAskepTindakan) > 0) {
                foreach ($modAskepTindakan as $i => $askepTindakan) {
                    if ($i > 0) {
                        $tindakanKeperawatan .= "<br />";
                    }

                    $tindakanKeperawatan .= "- " . (isset($askepTindakan->tindakankeperawatan) ? $askepTindakan->tindakankeperawatan->tindakankeperawatan_nama : "");
                }
            }
        }

        $target = $this->path_view . '_detailRiwayat';
        if ($model->jenisasesmen == 'asesmen_dewasa') {
            $target = $this->path_view . '_detailRiwayatDewasa';
        } else if ($model->jenisasesmen == 'asesmen_neonatus') {
            $target = $this->path_view . '_detailRiwayatNeonatus';
        } else if ($model->jenisasesmen == 'asesmen_obgyn') {
            $target = $this->path_view . '_detailRiwayatObgyn';
        }

        $this->render($target, array('model' => $model,
            'modPendaftaran' => $modPendaftaran,
            'modPasienAdmisi' => $modPasienAdmisi,
            'modPasien' => $modPasien,
            'dataFlaCcs' => $dataFlaCcs,
            'getFlaCcs' => $getFlaCcs,
            'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,
            'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,
            'masalahKeperawatan' => $masalahKeperawatan,
            'rencanaKeperawatan' => $rencanaKeperawatan,
            'tindakanKeperawatan' => $tindakanKeperawatan,
            'modSkrinningnyerianakdetT' => $modSkrinningnyerianakdetT
        ));
    }

    public function actionPrint($asesmenawalkeperawatan_id) {
        $this->layout = '//layouts/printWindows_baru';

        $model = RJAsesmenawalkeperawatanT::model()->findByPk($asesmenawalkeperawatan_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
        $modPasien = PasienM::model()->findByPk($model->pasien_id);
        $ruanganid = $modPendaftaran->ruangan_id;

        if (isset($modPasienAdmisi) && !empty($modPasienAdmisi)) {
            $ruanganid = $modPasienAdmisi->ruangan_id;
        }

        $criFla = new CDbCriteria();
        $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
        $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
        $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
        $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);

        $getFlaCcs = null;

        $dataFlaCcs = array();
        $cekFlaCcs = array();

        $modSkrinningnyerianakdetT = array();
        $modAsesmenkebutuhanEdukasidetT = null;

        if (isset($model)) {
            $modSkrinningnyerianakdetT = SkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

            $modAsesmenkebutuhanEdukasiT = AsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

            if (isset($modAsesmenkebutuhanEdukasiT)) {
                $modAsesmenkebutuhanEdukasidetT = AsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));
            } else {
                $modAsesmenkebutuhanEdukasiT = new AsesmenkebutuhanEdukasiT();
                $modAsesmenkebutuhanEdukasidetT = new AsesmenkebutuhanEdukasidetT();
            }
        } else {
            $modAsesmenkebutuhanEdukasiT = new AsesmenkebutuhanEdukasiT();
            $modAsesmenkebutuhanEdukasidetT = new AsesmenkebutuhanEdukasidetT();
        }

        if (count($modSkrinningnyerianakdetT) > 0) {
            $getFlaCcs = $modSkrinningnyerianakdetT;

            if (count($getFlaCcs) > 0) {
                foreach ($getFlaCcs as $det) {
                    $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->skrinningnyerianakdet_id;
                    $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
                    $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
                    $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
                    $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->asesmenawalkeperawatan_id;
                }
            }
        } else {
            $modSkrinningnyerianakdetT = new SkrinningnyerianakdetT();
        }

        foreach ($modNyeriFlaCcs as $dtF) {
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori_id"] = $dtF->kat_skalanyeri_id;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_anak_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_kat_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_params"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['params']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['params'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_nilai"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai'] : null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
                'id' => isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null,
                'keterangan' => $dtF->skalanyeriflaccs_desc
            );
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] : null;
        }

        $model->kepala_hasilperiksa = ($model->kepala_hasilperiksa == true) ? 1 : 0;
        $model->mata_hasilperiksa = ($model->mata_hasilperiksa == true) ? 1 : 0;
        $model->leher_hasilperiksa = ($model->leher_hasilperiksa == true) ? 1 : 0;
        $model->hidung_hasilperiksa = ($model->hidung_hasilperiksa == true) ? 1 : 0;
        $model->telinga_hasilperiksa = ($model->telinga_hasilperiksa == true) ? 1 : 0;
        $model->mulut_hasilperiksa = ($model->mulut_hasilperiksa == true) ? 1 : 0;
        $model->jantung_hasilperiksa = ($model->jantung_hasilperiksa == true) ? 1 : 0;
        $model->paru_hasilperiksa = ($model->paru_hasilperiksa == true) ? 1 : 0;
        $model->abdomen_hasilperiksa = ($model->abdomen_hasilperiksa == true) ? 1 : 0;
        $model->genitalia_hasilperiksa = ($model->genitalia_hasilperiksa == true) ? 1 : 0;
        $model->extremitasatas_hasilperiksa = ($model->extremitasatas_hasilperiksa == true) ? 1 : 0;
        $model->extremitasbawah_hasilperiksa = ($model->extremitasbawah_hasilperiksa == true) ? 1 : 0;
        $model->kulit_hasilperiksa = ($model->kulit_hasilperiksa == true) ? 1 : 0;
        $model->statusmerokok = ($model->statusmerokok == true) ? 1 : 0;
        $model->deskripsinyeri_ismenjalar = ($model->deskripsinyeri_ismenjalar == true) ? 1 : 0;
        $model->deformitas_status = ($model->deformitas_status == true) ? 1 : 0;
        $model->gangguantidur_status = ($model->gangguantidur_status == true) ? 1 : 0;
        $model->keb_nutricairan_rasahausberlebih = ($model->keb_nutricairan_rasahausberlebih == true) ? 1 : 0;
        $model->keb_nutricairan_edemastatus = ($model->keb_nutricairan_edemastatus == true) ? 1 : 0;
        $model->riwayatjatuh_3bln_terakhir = ($model->riwayatjatuh_3bln_terakhir) ? 1 : 0;
        $model->riwayatjatuh_alatbantu = ($model->riwayatjatuh_alatbantu) ? 1 : 0;


        if ($model->isskrinninggizidewasa) {
            $model->skrinninggizi_jwb_penurunanbb_dewasa_text = $model->skrinninggizi_skor_penurunanbb_dewasa;
            $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = $model->skrinninggizi_skor_asupanmakanan_dewasa;

            $model->skrinninggizi_jwb_tampakkurus_text = null;
            $model->skrinninggizi_jwb_penurunanbb_text = null;
            $model->skrinninggizi_jwb_kondisi_text = null;
            $model->skrinninggizi_jwb_penyakit_text = null;
        } else {
            $model->skrinninggizi_jwb_penurunanbb_dewasa_text = null;
            $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = null;

            $model->skrinninggizi_jwb_tampakkurus_text = $model->skrinninggizi_skor_tampakkurus;
            $model->skrinninggizi_jwb_penurunanbb_text = $model->skrinninggizi_skor_penurunanbb;
            $model->skrinninggizi_jwb_kondisi_text = $model->skrinninggizi_skor_kondisi;
            $model->skrinninggizi_jwb_penyakit_text = $model->skrinninggizi_skor_penyakit;
        }

        $model->riwayatjatuh_penilaian_text = $model->riwayatjatuh_penilaian;
        $model->diagnosismedis_penilaian_text = $model->diagnosismedis_skor;
        $model->alatbantujalan_penilaian_text = (($model->alatbantujalan_skor != null) ? $model->alatbantujalan_skor : null);
        $model->memakaiterapiheparin_penilaian_text = $model->memakaiterapiheparin_penilaian;
        $model->caraberjalan_penilaian_text = (($model->caraberjalan_skor != null) ? $model->caraberjalan_skor : null);
        $model->statusmental_penilaian_text = (($model->statusmental_skor != null) ? $model->statusmental_skor : null);
        $model->usia_anak_text = $model->skor_usia_anak;
        $model->jeniskelamin_anak_text = $model->skor_jeniskelamin_anak;
        $model->diagnosa_asessment_anak_text = $model->skor_diagnosa_anak;
        $model->gangguan_kognitif_anak_text = $model->skor_gangguan_kognitif_anak;

        $model->faktor_lingkungan_anak_text = $model->skor_faktor_lingkungan_anak;
        $model->responterhadap_pembedahan_anak_text = $model->skor_responterhadap_pembedahan_anak;
        $model->penggunaan_medikamentosa_text = $model->skor_medikamentosa_anak;



        $modAsesmenpasinIgd = AsesmenpasienigdT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruanganid));
        $masalahKeperawatan = "";
        $masalahKeperawatanNeonatus = "";
        $rencanaKeperawatan = "";
        $tindakanKeperawatan = "";

        if (isset($modAsesmenpasinIgd)) {
            $modAskepMasalah = AsesmenmasalahkepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));

            if (count($modAskepMasalah) > 0) {
                foreach ($modAskepMasalah as $i => $askepMasalah) {
                    if ($i > 0) {
                        $masalahKeperawatanNeonatus .= "<br />";
                    }
                    $masalahKeperawatanNeonatus .= "- " . (isset($askepMasalah->masalahkeperawatan) ? $askepMasalah->masalahkeperawatan->masalahkeperawatan_nama : "");

                    if ($i > 0) {
                        $masalahKeperawatan .= ", ";
                    }
                    $masalahKeperawatan .= (isset($askepMasalah->masalahkeperawatan) ? $askepMasalah->masalahkeperawatan->masalahkeperawatan_nama : "");
                }
            }

            $modAskepRencana = AsesmenrencanakepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));
            if (count($modAskepRencana) > 0) {

                foreach ($modAskepRencana as $i => $askepRencana) {
                    if ($i > 0) {
                        $rencanaKeperawatan .= "<br />";
                    }

                    $rencanaKeperawatan .= "- " . (isset($askepRencana->rencanakeperawatanigd) ? $askepRencana->rencanakeperawatanigd->rencanakeperawatan_nama : "");
                }
            }

            $modAskepTindakan = AsesmentindakankepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));
            if (count($modAskepTindakan) > 0) {
                foreach ($modAskepTindakan as $i => $askepTindakan) {
                    if ($i > 0) {
                        $tindakanKeperawatan .= "<br />";
                    }

                    $tindakanKeperawatan .= "- " . (isset($askepTindakan->tindakankeperawatan) ? $askepTindakan->tindakankeperawatan->tindakankeperawatan_nama : "");
                }
            }
        }

        $target = $this->path_view . '/anak/print';
        if ($model->jenisasesmen == 'asesmen_dewasa') {
            $target = $this->path_view . '/dewasa/print';
        } else if ($model->jenisasesmen == 'asesmen_neonatus') {
            $target = $this->path_view . 'PrintAwalAskepNeonatus';
        } else if ($model->jenisasesmen == 'asesmen_obgyn') {
            $target = $this->path_view . '/obgyn/print';
        }

        $this->render($target, array('model' => $model,
            'modPendaftaran' => $modPendaftaran,
            'modPasienAdmisi' => $modPasienAdmisi,
            'modPasien' => $modPasien,
            'dataFlaCcs' => $dataFlaCcs,
            'getFlaCcs' => $getFlaCcs,
            'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,
            'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,
            'masalahKeperawatan' => $masalahKeperawatan,
            'rencanaKeperawatan' => $rencanaKeperawatan,
            'tindakanKeperawatan' => $tindakanKeperawatan,
            'modSkrinningnyerianakdetT' => $modSkrinningnyerianakdetT,
            'masalahKeperawatanNeonatus' => $masalahKeperawatanNeonatus
        ));
    }

    public function actionHapusRiwayat() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $message = "";
            $sukses = 0;

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model = RJAsesmenawalkeperawatanT::model()->findByPk($id);
                $deleteData = false;
                $deleteSkrining = true;
                $deleteEdukasi = true;
                $deleteEdukasiDet = true;
                $deleteTumbuhkembang = true;

                if (isset($model)) {
                    $skrining = RJSkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

                    if (count($skrining) > 0) {
                        $deleteSkrining = RJSkrinningnyerianakdetT::model()->deleteAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
                    }


                    $modAsesmenkebutuhanEdukasiT = AsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
                    if (isset($modAsesmenkebutuhanEdukasiT)) {
                        $edukasiDet = AsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));
                        if (count($edukasiDet) > 0) {
                            $deleteEdukasiDet = AsesmenkebutuhanEdukasidetT::model()->deleteAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));
                        }

                        $deleteEdukasi = AsesmenkebutuhanEdukasiT::model()->deleteAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
                    }
                    $tumbuhkembang = AsesmentumbuhkembanganakT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

                    if (count($tumbuhkembang) > 0) {
                        $deleteTumbuhkembang = AsesmentumbuhkembanganakT::model()->deleteAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
                    }

                    $deleteData = RJAsesmenawalkeperawatanT::model()->deleteByPk($model->asesmenawalkeperawatan_id);
                }

                if ($deleteData && $deleteSkrining && $deleteEdukasi && $deleteEdukasiDet && $deleteTumbuhkembang) {
                    $transaction->commit();
                    $message = "Data Berhasil Dihapus!";
                    $sukses = 1;
                } else {
                    $transaction->rollback();
                    $message = "Data gagal Dihapus!";
                    $sukses = 0;
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $message = "Data gagal Dihapus! " . MyExceptionMessage::getMessage($exc, true);
                $sukses = 0;
            }

            echo CJSON::encode(array(
                'sukses' => $sukses,
                'msg' => $message,
            ));
            exit;
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

}
