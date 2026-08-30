
<?php

class AsesmenAwalKeperawatanController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatInap.views.asesmenAwalKeperawatan.';
    public $tersimpanAsesmenAwalKep = false;
    public $tersimpanKebEdukasi = false;

    public function actionIndex()
    {
        
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'list-diagnosa-m-grid'){
                    $this->renderPartial($this->path_view.'grid/_daftarDiagnosa');
                }
                Yii::app()->end();
            }
        }
    // var_dump($_POST);die;
      $pendaftaran_id = (isset($_GET['pendaftaran_id'])?$_GET['pendaftaran_id']:null);
      $pasienadmisi_id = (isset($_GET['pasienadmisi_id'])?$_GET['pasienadmisi_id']:null);
      $asesmenawalkeperawatan_id = (isset($_GET['asesmenawalkeperawatan_id'])?$_GET['asesmenawalkeperawatan_id']:null);

      $modPendaftaran= RIPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);

        $criFla = new CDbCriteria();
        $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
        $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
        $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
        $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);

        $getFlaCcs = null;

        $dataFlaCcs = array();
        $cekFlaCcs = array();
        $modAsesmenkebutuhanEdukasidetT = null;
        $updateCek = false;


        if(!empty($asesmenawalkeperawatan_id)){
            $updateCek = true;
            $model = RIAsesmenawalkeperawatanT::model()->findByPk($asesmenawalkeperawatan_id);
            $model->kepala_hasilperiksa=($model->kepala_hasilperiksa==true)?1:0;
            $model->mata_hasilperiksa=($model->mata_hasilperiksa==true)?1:0;
            $model->leher_hasilperiksa=($model->leher_hasilperiksa==true)?1:0;
            $model->hidung_hasilperiksa=($model->hidung_hasilperiksa==true)?1:0;
            $model->telinga_hasilperiksa=($model->telinga_hasilperiksa==true)?1:0;
            $model->mulut_hasilperiksa=($model->mulut_hasilperiksa==true)?1:0;
            $model->jantung_hasilperiksa=($model->jantung_hasilperiksa==true)?1:0;
            $model->paru_hasilperiksa=($model->paru_hasilperiksa==true)?1:0;
            $model->abdomen_hasilperiksa=($model->abdomen_hasilperiksa==true)?1:0;
            $model->genitalia_hasilperiksa=($model->genitalia_hasilperiksa==true)?1:0;
            $model->extremitasatas_hasilperiksa=($model->extremitasatas_hasilperiksa==true)?1:0;
            $model->extremitasbawah_hasilperiksa=($model->extremitasbawah_hasilperiksa==true)?1:0;
            $model->kulit_hasilperiksa=($model->kulit_hasilperiksa==true)?1:0;
            $model->statusmerokok=($model->statusmerokok==true)?1:0;
            $model->deskripsinyeri_ismenjalar=($model->deskripsinyeri_ismenjalar==true)?1:0;
            $model->deformitas_status=($model->deformitas_status==true)?1:0;
            $model->gangguantidur_status=($model->gangguantidur_status==true)?1:0;
            $model->keb_nutricairan_rasahausberlebih=($model->keb_nutricairan_rasahausberlebih==true)?1:0;
            $model->keb_nutricairan_edemastatus=($model->keb_nutricairan_edemastatus==true)?1:0;
            $model->riwayatjatuh_3bln_terakhir = ($model->riwayatjatuh_3bln_terakhir)?1:0;
            $model->riwayatjatuh_alatbantu = ($model->riwayatjatuh_alatbantu)?1:0;

            if(!empty($model->statusalergipasien)){
                if($model->statusalergipasien == 'Tidak Ada'){
                    $model->statusalergipasien = 1;
                }else if($model->statusalergipasien == 'Tidak Tahu'){
                    $model->statusalergipasien = 2;
                }else if($model->statusalergipasien == 'Ada'){
                    $model->statusalergipasien = 3;
                }
            }
           if(!$model->isskrinninggizidewasa){
                $model->skrinninggizi_jwb_penurunanbb_dewasa_text = $model->skrinninggizi_skor_penurunanbb_dewasa;
                $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = $model->skrinninggizi_skor_asupanmakanan_dewasa;

                $model->skrinninggizi_jwb_tampakkurus_text = null;
                $model->skrinninggizi_jwb_penurunanbb_text = null;
                $model->skrinninggizi_jwb_kondisi_text = null;
                $model->skrinninggizi_jwb_penyakit_text = null;
           }else{
                $model->skrinninggizi_jwb_penurunanbb_dewasa_text = null;
                $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = null;

                $model->skrinninggizi_jwb_tampakkurus_text = $model->skrinninggizi_skor_tampakkurus;
                $model->skrinninggizi_jwb_penurunanbb_text = $model->skrinninggizi_skor_penurunanbb;
                $model->skrinninggizi_jwb_kondisi_text = $model->skrinninggizi_skor_kondisi;
                $model->skrinninggizi_jwb_penyakit_text = $model->skrinninggizi_skor_penyakit;
           }

           $model->riwayatjatuh_penilaian_text = $model->riwayatjatuh_penilaian;
           $model->diagnosismedis_penilaian_text = $model->diagnosismedis_skor;
           $model->alatbantujalan_penilaian_text = (($model->alatbantujalan_skor != null) ? $model->alatbantujalan_skor:null);
           $model->memakaiterapiheparin_penilaian_text = $model->memakaiterapiheparin_penilaian;
           $model->caraberjalan_penilaian_text = (($model->caraberjalan_skor != null) ? $model->caraberjalan_skor:null);
           $model->statusmental_penilaian_text = (($model->statusmental_skor != null) ? $model->statusmental_skor:null);
           $model->usia_anak_text = $model->skor_usia_anak;
           $model->jeniskelamin_anak_text = $model->skor_jeniskelamin_anak;
           $model->diagnosa_asessment_anak_text = $model->skor_diagnosa_anak;
           $model->gangguan_kognitif_anak_text = $model->skor_gangguan_kognitif_anak;

           $model->faktor_lingkungan_anak_text = $model->skor_faktor_lingkungan_anak;
           $model->responterhadap_pembedahan_anak_text = $model->skor_responterhadap_pembedahan_anak;
           $model->penggunaan_medikamentosa_text = $model->skor_medikamentosa_anak;

           if($model->jenisasesmen == 'asesmenri_anak'){
             $model->isasesmenawalkep = 2;
             $model->jam_masukruangan_anak = $model->jam_masukruangan;
             $model->tgl_assesmen_awal_anak = $model->tgl_assesmen_awal;
           }
           else if($model->jenisasesmen == 'asesmenri_dewasa'){
             $model->isasesmenawalkep = 3;
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
             $model->isada_anak = $model->isada_anak;
             $model->isadaresikojatuh = $model->isadaresikojatuh;
           }else if($model->jenisasesmen == 'asesmenri_neonatus'){
             $model->isasesmenawalkep = 1;
             $model->jam_masukruangan_neonatus = $model->jam_masukruangan;
             $model->tgl_assesmen_awal_neonatus = $model->tgl_assesmen_awal;
             $model->keluhanutama_neonatus = $model->keluhanutama;
             $model->keluhantambahan_neonatus = $model->keluhantambahan;

             $model->keb_eliminasi_bab_keluhanstatus_neonatus = (($model->keb_eliminasi_bab_keluhanstatus)?1:0);
             $model->keb_eliminasi_bab_ispendarahan_neonatus = $model->keb_eliminasi_bab_ispendarahan;
             $model->keb_eliminasi_bab_ishemorroid_neonatus = $model->keb_eliminasi_bab_ishemorroid;
             $model->keb_eliminasi_bab_iskonstipasi_neonatus = $model->keb_eliminasi_bab_iskonstipasi;
             $model->keb_eliminasi_bab_iskeluhanlainnya_neonatus = $model->keb_eliminasi_bab_iskeluhanlainnya;
             $model->keb_eliminasi_bab_jeniskeluhanlainnya_neonatus = $model->keb_eliminasi_bab_jeniskeluhanlainnya;
             $model->keb_eliminasi_bak_keluhanstatus_neonatus = (($model->keb_eliminasi_bak_keluhanstatus)?1:0);
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

             if($model->is_keluhannyeri_dewasa == null && !empty($model->neonatus_cries_totalnilai)){
               $model->is_keluhannyeri_dewasa = 2;
             }
           }else if($model->jenisasesmen == 'asesmenri_obgyn'){
             $model->isasesmenawalkep = 4;

             $model->jam_masukruangan_obgyn = $model->jam_masukruangan;
             $model->tgl_assesmen_awal_obgyn = $model->tgl_assesmen_awal;
             $model->keluhanutama_obgyn = $model->keluhanutama;
             $model->keluhantambahan_obgyn = $model->keluhantambahan;
           }else if($model->jenisasesmen == 'asesmenri_geriatri'){
             $model->isasesmenawalkep = 5;

             $model->jam_masukruangan_geriatri = $model->jam_masukruangan;
             $model->tgl_assesmen_awal_geriatri = MyFormatter::formatDateTimeForUser($model->tgl_assesmen_awal);
             $model->keluhanutama_geriatri = $model->keluhanutama;
             $model->keluhantambahan_geriatri = $model->keluhantambahan;
             $model->kondisiumum_geriatri = $model->kondisiumum;
           }

           $model->kekerasanfisiket = (($model->kekerasanfisiket==true)?"Pernah":"Tidak Pernah");
           $model->gangguantidur_status = (($model->gangguantidur_status==true)?"Ada":"Tidak Ada");

            $modSkrinningnyerianakdetT = RISkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));
            if(count((array)$modSkrinningnyerianakdetT)>0){
                $getFlaCcs = $modSkrinningnyerianakdetT;

                if (count((array)$getFlaCcs)>0){
                     foreach($getFlaCcs as $det){
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->skrinningnyerianakdet_id;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
                        $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->asesmenawalkeperawatan_id;
                    }
                }
            }else{
                 $modSkrinningnyerianakdetT = new RISkrinningnyerianakdetT();
            }

            $modAsesmenkebutuhanEdukasiT = RIAsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));
            if(isset($modAsesmenkebutuhanEdukasiT)){
                $modAsesmenkebutuhanEdukasidetT = RIAsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id'=>$modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));

                if($model->jenisasesmen == 'asesmenri_neonatus'){
                  $modAsesmenkebutuhanEdukasiT->bicara_status_neonatus = $modAsesmenkebutuhanEdukasiT->bicara_status;
                  $modAsesmenkebutuhanEdukasiT->mulaiseranganawal_neonatus = $modAsesmenkebutuhanEdukasiT->mulaiseranganawal;
                  $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status_neonatus = $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status;
                  $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_jenisbahasa_neonatus = $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_jenisbahasa;
                  $modAsesmenkebutuhanEdukasiT->bahasaisyarat_status_neonatus = $modAsesmenkebutuhanEdukasiT->bahasaisyarat_status;
                }
            }else{
                $modAsesmenkebutuhanEdukasiT = new RIAsesmenkebutuhanEdukasiT();
                $modAsesmenkebutuhanEdukasidetT = new RIAsesmenkebutuhanEdukasidetT();
            }

            $modBarthelindex = BarthelindexadlT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));

            if(!isset($modBarthelindex)){
              $modBarthelindex = new BarthelindexadlT();
            }

            if($model->jenis_statusfungsional == 'jenis_fungsionaladl'){
              $model->isfungsional = 2;
            }else if($model->jenis_statusfungsional == 'jenis_fungsional'){
              $model->isfungsional = 1;
            }

            $modPeriksaFisikNeonatusRI = PeriksafisikneonatusriT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));

            if(!isset($modPeriksaFisikNeonatusRI)){
              $modPeriksaFisikNeonatusRI = new PeriksafisikneonatusriT();
            }

            $modAskepgeriatriT = AskepgeriatriT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));

            if(!isset($modAskepgeriatriT)){
              $modAskepgeriatriT = new AskepgeriatriT();
              $modPenilaianRenPulang = array();
              $modMinimentalexampasienT = array();
              $modMinimentalexampasiendetT = array();
            }else{
              $modPenilaianRenPulang = PenilaianrencanapulangT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

              $modMinimentalexampasienT = MinimentalexampasienT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

              if(count((array)$modMinimentalexampasienT) > 0){
                $modMinimentalexampasiendetT = array();
                if(count((array)$modMinimentalexampasienT)){
                  foreach($modMinimentalexampasienT as $oriMinimentalexamp){
                      $modMinimentalexampasiendetT = MinimentalexampasiendetT::model()->findAllByAttributes(array('minimentalexampasien_id'=>$oriMinimentalexamp->minimentalexampasien_id));
                  }
                }
              }else{
                $modMinimentalexampasienT = array();
                $modMinimentalexampasiendetT = array();
              }
            }

        }else{
          $model = new RIAsesmenawalkeperawatanT();
          $modSkrinningnyerianakdetT = new RISkrinningnyerianakdetT();
          $model->tgl_assesmen_awal = date('d M Y H:i:s');
          $model->tgl_assesmen_awal_anak = date('d M Y H:i:s');
          $model->obgyn_taksiranpersalinan = date('d M Y');
          $model->obgyn_golongandarah = (!empty($modPasien->golongandarah)?$modPasien->golongandarah:null);
          $modAsesmenkebutuhanEdukasiT = new RIAsesmenkebutuhanEdukasiT();
          $modAsesmenkebutuhanEdukasidetT = new RIAsesmenkebutuhanEdukasidetT();
          $modBarthelindex = new BarthelindexadlT();
          $modPeriksaFisikNeonatusRI = new PeriksafisikneonatusriT();
          $modAskepgeriatriT = new AskepgeriatriT();
          $modPenilaianRenPulang = array();
          $modMinimentalexampasienT = array();
          $modMinimentalexampasiendetT = array();
        }

        $model->dokterpemeriksa_id = $modPendaftaran->pegawai_id;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->pasien_id = $modPendaftaran->pasien_id;

        $modAsesmenkebutuhanEdukasiT->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modAsesmenkebutuhanEdukasiT->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->is_dbn = true;
        if($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BALITA || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_ANAK || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR){
            $model->isskrinninggizidewasa = false;
            $model->isresikojatuh = 1;
            if($updateCek==false){
                $model->is_keluhannyeri_dewasa = 0;
            }
        }else{
            $model->isskrinninggizidewasa = true;
            if($updateCek==false){
                $model->is_keluhannyeri_dewasa = 1;
            }
            if($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_DEWASA){
                $model->isresikojatuh = 0;
            }else if($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_LANSIA){
                $model->isresikojatuh = 2;
            }
        }

        foreach ($modNyeriFlaCcs as $dtF){
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori_id"] = $dtF->kat_skalanyeri_id;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_anak_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']:null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_kat_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id']:null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_params"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['params'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]['params']:null;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_nilai"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai']:null;
            
            $dtSkala = array(
                'id' => isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']:null,
                'keterangan' => $dtF->skalanyeriflaccs_desc
            );
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = $dtSkala;
            // $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'])?$cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id']:null;
        }

        $this->render($this->path_view.'index',
            array('modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'model'=>$model,
                'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT,
                'dataFlaCcs' => $dataFlaCcs,
                'getFlaCcs' => $getFlaCcs,
                'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,
                'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,
                'modBarthelindex'=>$modBarthelindex,
                'modPeriksaFisikNeonatusRI'=>$modPeriksaFisikNeonatusRI,
                'modAskepgeriatriT'=>$modAskepgeriatriT,
                'modPenilaianRenPulang'=>$modPenilaianRenPulang,
                'modMinimentalexampasienT'=>$modMinimentalexampasienT,
                'modMinimentalexampasiendetT'=>$modMinimentalexampasiendetT
        ));
    }

    public function actionMasterKeluhan()
    {
        if (Yii::app()->request->isAjaxRequest){
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(keluhananamnesis_nama)', strtolower($_GET['tag']),true);
            $criteria->order = "keluhananamnesis_nama ASC";
            $keluhans = KeluhananamnesisM::model()->findAll($criteria);
            $data = array();
            foreach ($keluhans as $i => $keluhan) {
                $data[$i] = array('key'=>$keluhan->keluhananamnesis_nama,
                                  'value'=>$keluhan->keluhananamnesis_nama);
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionMasterKeadaanUmum()
    {
        if (Yii::app()->request->isAjaxRequest){
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(keadaanumum_nama)', strtolower($_GET['tag']),true);
            $criteria->order = "keadaanumum_nama ASC";
            $keluhans = KeadaanumumM::model()->findAll($criteria);
            $data = array();
            foreach ($keluhans as $i => $keluhan) {
                $data[$i] = array('key'=>$keluhan->keadaanumum_nama,
                                  'value'=>$keluhan->keadaanumum_nama);
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionGetfromDevice(){
        if (Yii::app()->request->isAjaxRequest){
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $file = dirname('c:/OstarP2/x').'/OstarXML.xml';
            } else {
                $file = Yii::app()->getBaseUrl('webroot').'/data/xml/ostar.xml';
            }

            $data2 = simplexml_load_file($file);
            $a = $data2->BPMRecord[0]['H'];
            $b = $data2->BPMRecord[0]['L'];
            $c = $data2->BPMRecord[0]['P'];

            $tambah = '';
            if (strlen($a) < 3){
                for($i = strlen($a); $i < 3; $i++){
                    $tambah = $tambah.'0';
                }
                $a = $tambah.$a;
            }
            $tambah = '';
            if (strlen($b) < 3){
                for($i = strlen($b); $i < 3; $i++){
                    $tambah = $tambah.'0';
                }
                $b = $tambah.$b;
            }

            $data['sys'] = "$a";
            $data['dias'] = "$b";
            $data['detaknadi'] = "$c";
            $data['tekanandarah'] = $a.' / '.$b;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionSimpanOrLoad(){
      if (Yii::app()->request->isAjaxRequest) {
        $data = array();
        $sukses = 0;
        $pesan = "Data Error Disimpan!!";
        // echo '<pre>';
        // print_r($_POST)
        // exit();

        if (isset($_POST['RIAsesmenawalkeperawatanT'])) {
          $transaction = Yii::app()->db->beginTransaction();

          try {
              $pendaftaran_id = $_POST['RIAsesmenawalkeperawatanT']['pendaftaran_id'];
              $pasienadmisi_id = (!empty($_POST['RIAsesmenawalkeperawatanT']['pasienadmisi_id'])?$_POST['RIAsesmenawalkeperawatanT']['pasienadmisi_id']:null);
              $jenisasesmen = $_POST['RIAsesmenawalkeperawatanT']['jenisasesmen'];
              $asesmenawalkeperawatan_id = (isset($_POST['RIAsesmenawalkeperawatanT']['asesmenawalkeperawatan_id']) && !empty($_POST['RIAsesmenawalkeperawatanT']['asesmenawalkeperawatan_id'])? $_POST['RIAsesmenawalkeperawatanT']['asesmenawalkeperawatan_id']: null);

              $modPendaftaran= RIPendaftaranT::model()->findByPk($pendaftaran_id);
              $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
              $modAsesmenkebutuhanEdukasidetT = null;

              if(!empty($asesmenawalkeperawatan_id)){
                $modAsesmenawalkeperawatanT = RIAsesmenawalkeperawatanT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$asesmenawalkeperawatan_id));

                if(!isset($modAsesmenawalkeperawatanT)){
                  $modAsesmenawalkeperawatanT = new RIAsesmenawalkeperawatanT();
                  $modSkrinningnyerianakdetT = new RISkrinningnyerianakdetT();

                  $modAsesmenawalkeperawatanT->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                  $modAsesmenawalkeperawatanT->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                  $modAsesmenawalkeperawatanT->pasien_id = $modPendaftaran->pasien_id;

                  $modAsesmenkebutuhanEdukasiT = new RIAsesmenkebutuhanEdukasiT();
                  $modAsesmenkebutuhanEdukasidetT = new RIAsesmenkebutuhanEdukasidetT();
                  $modBarthelindex = new BarthelindexadlT();
                  $modPeriksaFisikNeonatus = new PeriksafisikneonatusriT();
                  $modAskepgeriatriT = new AskepgeriatriT();
                  $modPenilaianRenPulang = array();
                  $modMinimentalexampasienT = array();
                  $modMinimentalexampasiendetT = array();
                }else{
                  $modSkrinningnyerianakdetT = RISkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));
                  if(count((array)$modSkrinningnyerianakdetT)>0){
                      $getFlaCcs = $modSkrinningnyerianakdetT;

                      if (count((array)$getFlaCcs)>0){
                           foreach($getFlaCcs as $det){
                              $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->skrinningnyerianakdet_id;
                              $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
                              $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
                              $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
                              $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->asesmenawalkeperawatan_id;
                          }
                      }
                  }else{
                       $modSkrinningnyerianakdetT = new RISkrinningnyerianakdetT();
                  }

                  $modAsesmenkebutuhanEdukasiT = RIAsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));
                  if(isset($modAsesmenkebutuhanEdukasiT)){
                      $modAsesmenkebutuhanEdukasidetT = RIAsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id'=>$modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));
                  }else{
                      $modAsesmenkebutuhanEdukasiT = new RIAsesmenkebutuhanEdukasiT();
                      $modAsesmenkebutuhanEdukasidetT = new RIAsesmenkebutuhanEdukasidetT();
                  }

                  $modBarthelindex = BarthelindexadlT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                  if(!isset($modBarthelindex)){
                      $modBarthelindex = new BarthelindexadlT();
                  }

                  $modPeriksaFisikNeonatus = PeriksafisikneonatusriT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                  if(!isset($modPeriksaFisikNeonatus)){
                      $modPeriksaFisikNeonatus = new PeriksafisikneonatusriT();
                  }

                  $modAskepgeriatriT = AskepgeriatriT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                  if(!isset($modAskepgeriatriT)){
                      $modAskepgeriatriT = new AskepgeriatriT();
                      $modPenilaianRenPulang = array();
                  }else{
                    $modPenilaianRenPulang = PenilaianrencanapulangT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

                    $modMinimentalexampasienT = MinimentalexampasienT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

                    if(count((array)$modMinimentalexampasienT) > 0){
                      $modMinimentalexampasiendetT = array();
                      if(count((array)$modMinimentalexampasienT)){
                        foreach($modMinimentalexampasienT as $oriMinimentalexamp){
                            $modMinimentalexampasiendetT = MinimentalexampasiendetT::model()->findAllByAttributes(array('minimentalexampasien_id'=>$oriMinimentalexamp->minimentalexampasien_id));
                        }
                      }
                    }else{
                      $modMinimentalexampasienT = array();
                      $modMinimentalexampasiendetT = array();
                    }
                  }

                }

              }else{
                if($_POST['checksimpan']=='simpan'){
                  $modAsesmenawalkeperawatanT = RIAsesmenawalkeperawatanT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'jenisasesmen'=>$jenisasesmen));

                  if(!isset($modAsesmenawalkeperawatanT)){
                    $modAsesmenawalkeperawatanT = new RIAsesmenawalkeperawatanT();
                    $modSkrinningnyerianakdetT = new RISkrinningnyerianakdetT();

                    $modAsesmenawalkeperawatanT->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modAsesmenawalkeperawatanT->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                    $modAsesmenawalkeperawatanT->pasien_id = $modPendaftaran->pasien_id;

                    $modAsesmenkebutuhanEdukasiT = new RIAsesmenkebutuhanEdukasiT();
                    $modAsesmenkebutuhanEdukasidetT = new RIAsesmenkebutuhanEdukasidetT();
                    $modBarthelindex = new BarthelindexadlT();
                    $modPeriksaFisikNeonatus = new PeriksafisikneonatusriT();
                    $modAskepgeriatriT = new AskepgeriatriT();
                    $modPenilaianRenPulang = array();
                    $modMinimentalexampasienT = array();
                    $modMinimentalexampasiendetT = array();
                  }else{
                    $modSkrinningnyerianakdetT = RISkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));
                    if(count((array)$modSkrinningnyerianakdetT)>0){
                        $getFlaCcs = $modSkrinningnyerianakdetT;

                        if (count((array)$getFlaCcs)>0){
                             foreach($getFlaCcs as $det){
                                $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->skrinningnyerianakdet_id;
                                $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
                                $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
                                $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
                                $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->asesmenawalkeperawatan_id;
                            }
                        }
                    }else{
                         $modSkrinningnyerianakdetT = new RISkrinningnyerianakdetT();
                    }

                    $modAsesmenkebutuhanEdukasiT = RIAsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                    if(isset($modAsesmenkebutuhanEdukasiT)){
                        $modAsesmenkebutuhanEdukasidetT = RIAsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id'=>$modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));
                    }else{
                        $modAsesmenkebutuhanEdukasiT = new RIAsesmenkebutuhanEdukasiT();
                        $modAsesmenkebutuhanEdukasidetT = new RIAsesmenkebutuhanEdukasidetT();
                    }
                    $modBarthelindex = BarthelindexadlT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                    if(!isset($modBarthelindex)){
                        $modBarthelindex = new BarthelindexadlT();
                    }

                    $modPeriksaFisikNeonatus = PeriksafisikneonatusriT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                    if(!isset($modPeriksaFisikNeonatus)){
                        $modPeriksaFisikNeonatus = new PeriksafisikneonatusriT();
                    }

                    $modAskepgeriatriT = AskepgeriatriT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                    if(!isset($modAskepgeriatriT)){
                        $modAskepgeriatriT = new AskepgeriatriT();
                    }else{
                      $modPenilaianRenPulang = PenilaianrencanapulangT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

                      $modMinimentalexampasienT = MinimentalexampasienT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

                      if(count((array)$modMinimentalexampasienT) > 0){
                        $modMinimentalexampasiendetT = array();
                        if(count((array)$modMinimentalexampasienT)){
                          foreach($modMinimentalexampasienT as $oriMinimentalexamp){
                              $modMinimentalexampasiendetT = MinimentalexampasiendetT::model()->findAllByAttributes(array('minimentalexampasien_id'=>$oriMinimentalexamp->minimentalexampasien_id));
                          }
                        }
                      }else{
                        $modMinimentalexampasienT = array();
                        $modMinimentalexampasiendetT = array();
                      }
                    }
                  }
                }else{
                  $modAsesmenawalkeperawatanT = new RIAsesmenawalkeperawatanT();
                  $modSkrinningnyerianakdetT = new RISkrinningnyerianakdetT();
                  $modAsesmenkebutuhanEdukasiT = new RIAsesmenkebutuhanEdukasiT();
                  $modAsesmenkebutuhanEdukasidetT = new RIAsesmenkebutuhanEdukasidetT();
                  $modBarthelindex = new BarthelindexadlT();
                  $modPeriksaFisikNeonatus = new PeriksafisikneonatusriT();
                  $modAskepgeriatriT = new AskepgeriatriT();
                  $modPenilaianRenPulang = array();
                  $modMinimentalexampasienT = array();
                  $modMinimentalexampasiendetT = array();
                }
              }

              $tersimpandetailNyeri = true;
               $tersimpandetailEdukasi = true;
               $tersimpanTumbuhKembang = true;
               $tersimpanRiwayatObs = true;
               $tersimpanBathelindex = true;
               $tersimpanPeriksaFisikNeonatus = true;
               $tersimpanAskepGeriatri = true;

             if(isset($_POST['RIAsesmenawalkeperawatanT'])){
               $modAsesmenawalkeperawatanT->attributes = $_POST['RIAsesmenawalkeperawatanT'];

               $modAsesmenkebutuhanEdukasiT->pendaftaran_id = $modAsesmenawalkeperawatanT->pendaftaran_id;
               $modAsesmenkebutuhanEdukasiT->pasienadmisi_id = $modAsesmenawalkeperawatanT->pasienadmisi_id;

               
                 if($modAsesmenawalkeperawatanT->jenisasesmen == 'asesmenri_anak'){
                    $modAsesmenawalkeperawatanT->jam_masukruangan = $_POST['RIAsesmenawalkeperawatanT']['jam_masukruangan_anak'];
                    $modAsesmenawalkeperawatanT->tgl_assesmen_awal = MyFormatter::formatDateTimeForDb($_POST['RIAsesmenawalkeperawatanT']['tgl_assesmen_awal_anak']);
                    $modAsesmenawalkeperawatanT->keluhanutama = isset($_POST['RIAsesmenawalkeperawatanT']['keluhanutama']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhanutama'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhanutama']) : '') : '';
                    $modAsesmenawalkeperawatanT->keluhantambahan = isset($_POST['RIAsesmenawalkeperawatanT']['keluhantambahan']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhantambahan'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhantambahan']) : '') : '';
                    $modAsesmenawalkeperawatanT->kondisiumum = isset($_POST['RIAsesmenawalkeperawatanT']['kondisiumum']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['kondisiumum'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['kondisiumum']) : '') : '';

                    $modAsesmenawalkeperawatanT->kekerasanfisiket = ((!empty($_POST['RIAsesmenawalkeperawatanT']['kekerasanfisiket']) && $_POST['RIAsesmenawalkeperawatanT']['kekerasanfisiket'] =='Pernah')? true: false);
                    $modAsesmenawalkeperawatanT->gangguantidur_status = ((!empty($_POST['RIAsesmenawalkeperawatanT']['gangguantidur_status']) && $_POST['RIAsesmenawalkeperawatanT']['gangguantidur_status'] =='Ada')? true: false);
                    $modAsesmenawalkeperawatanT->neonatus_kebsosialekonomi_statusperkawinan = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan']:null;
                    $modAsesmenawalkeperawatanT->neonatus_pendidikanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_warganegaraortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_tinggalbersama = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama']:null;
                    $modAsesmenawalkeperawatanT->neonatus_agamaortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_pekerjaanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu']:null;
                    // $modAsesmenawalkeperawatanT->neonatus_konsulpsikologortu = ((!empty($_POST['RIAsesmenawalkeperawatanT']['neonatus_konsulpsikologortu']) && $_POST['RIAsesmenawalkeperawatanT']['neonatus_konsulpsikologortu'] =='Ada')? true: false);
                 }
                 else if($modAsesmenawalkeperawatanT->jenisasesmen == 'asesmenri_dewasa'){
                    $modAsesmenawalkeperawatanT->jam_masukruangan = $_POST['RIAsesmenawalkeperawatanT']['jam_masukruangan_dws'];
                    $modAsesmenawalkeperawatanT->tgl_assesmen_awal = MyFormatter::formatDateTimeForDb($_POST['RIAsesmenawalkeperawatanT']['tgl_assesmen_awal_dws']);
                    $modAsesmenawalkeperawatanT->keluhanutama = isset($_POST['RIAsesmenawalkeperawatanT']['keluhanutama_dws']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhanutama_dws'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhanutama_dws']) : '') : '';
                    $modAsesmenawalkeperawatanT->keluhantambahan = isset($_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_dws']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_dws'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_dws']) : '') : '';
                    $modAsesmenawalkeperawatanT->kondisiumum = isset($_POST['RIAsesmenawalkeperawatanT']['kondisiumum_dws']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['kondisiumum_dws'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['kondisiumum_dws']) : '') : '';
                    $modAsesmenawalkeperawatanT->kepala_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['kepala_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['kepala_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->mata_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['mata_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['mata_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->leher_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['leher_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['leher_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->hidung_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['hidung_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['hidung_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->telinga_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['telinga_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['telinga_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->mulut_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['mulut_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['mulut_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->jantung_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['jantung_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['jantung_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->paru_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['paru_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['paru_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->abdomen_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['abdomen_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['abdomen_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->genitalia_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['genitalia_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['genitalia_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->extremitasatas_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['extremitasatas_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['extremitasatas_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->extremitasbawah_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['extremitasbawah_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['extremitasbawah_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->kulit_abnormalketerangan = isset($_POST['RIAsesmenawalkeperawatanT']['kulit_abnormalketerangan_dws'])?$_POST['RIAsesmenawalkeperawatanT']['kulit_abnormalketerangan_dws']:null;
                    $modAsesmenawalkeperawatanT->neonatus_kebsosialekonomi_statusperkawinan = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan_dws']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan_dws']:null;
                    $modAsesmenawalkeperawatanT->neonatus_pendidikanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu_dws']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu_dws']:null;
                    $modAsesmenawalkeperawatanT->neonatus_warganegaraortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu_dws']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu_dws']:null;
                    $modAsesmenawalkeperawatanT->neonatus_tinggalbersama = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama_dws']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama_dws']:null;
                    $modAsesmenawalkeperawatanT->neonatus_agamaortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu_dws']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu_dws']:null;
                    $modAsesmenawalkeperawatanT->neonatus_pekerjaanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu_dws']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu_dws']:null;
                    $modAsesmenawalkeperawatanT->isada_anak = isset($_POST['RIAsesmenawalkeperawatanT']['isada_anak']) ? $_POST['RIAsesmenawalkeperawatanT']['isada_anak']:null;
                    $modAsesmenawalkeperawatanT->isadaresikojatuh = isset($_POST['RIAsesmenawalkeperawatanT']['isadaresikojatuh']) ? $_POST['RIAsesmenawalkeperawatanT']['isadaresikojatuh']:null;
                    // var_dump($_POST['RIAsesmenawalkeperawatanT']);die;
                    $modAsesmenawalkeperawatanT->kekerasanfisiket = ((!empty($_POST['RIAsesmenawalkeperawatanT']['kekerasanfisiket']) && $_POST['RIAsesmenawalkeperawatanT']['kekerasanfisiket'] =='Pernah')? true: false);
                    $modAsesmenawalkeperawatanT->gangguantidur_status = ((!empty($_POST['RIAsesmenawalkeperawatanT']['gangguantidur_status']) && $_POST['RIAsesmenawalkeperawatanT']['gangguantidur_status'] =='Ada')? true: false);

                    if(!empty($_POST['RIAsesmenawalkeperawatanT']['kesadaranpasien_pengkajiannyeri']) && $_POST['RIAsesmenawalkeperawatanT']['kesadaranpasien_pengkajiannyeri'] == 'Tidak Sadar'){
                      $modAsesmenawalkeperawatanT->score_skalanyeri = isset($_POST['RIAsesmenawalkeperawatanT']['score_skalanyeri_dws'])?$_POST['RIAsesmenawalkeperawatanT']['score_skalanyeri_dws']:null;
                      $modAsesmenawalkeperawatanT->keteranganskala_nyeri = isset($_POST['RIAsesmenawalkeperawatanT']['keteranganskala_nyeri_dws'])?$_POST['RIAsesmenawalkeperawatanT']['keteranganskala_nyeri_dws']:null;
                    }
                 }else if($modAsesmenawalkeperawatanT->jenisasesmen == 'asesmenri_neonatus'){
                   $modAsesmenawalkeperawatanT->keb_eliminasi_bab_keluhanstatus = (!empty($_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_keluhanstatus_neonatus'])?$_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_keluhanstatus_neonatus']:null);
                   $modAsesmenawalkeperawatanT->keb_eliminasi_bab_ispendarahan = (!empty($_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_ispendarahan_neonatus']) ? $_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_ispendarahan_neonatus']: null);
                   $modAsesmenawalkeperawatanT->keb_eliminasi_bab_ishemorroid = (!empty($_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_ishemorroid_neonatus'])?$_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_ishemorroid_neonatus']:null);
                   $modAsesmenawalkeperawatanT->keb_eliminasi_bab_iskonstipasi = (!empty($_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_iskonstipasi_neonatus'])?$_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_iskonstipasi_neonatus']:null);
                   $modAsesmenawalkeperawatanT->keb_eliminasi_bab_iskeluhanlainnya = (!empty($_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_iskeluhanlainnya_neonatus'])?$_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_iskeluhanlainnya_neonatus']:null);
                   $modAsesmenawalkeperawatanT->keb_eliminasi_bab_jeniskeluhanlainnya = (!empty($_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_jeniskeluhanlainnya_neonatus'])?$_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bab_jeniskeluhanlainnya_neonatus']:null);
                   $modAsesmenawalkeperawatanT->keb_eliminasi_bak_keluhanstatus = (!empty($_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bak_keluhanstatus_neonatus'])?$_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bak_keluhanstatus_neonatus']:null);
                   $modAsesmenawalkeperawatanT->keb_eliminasi_bak_isnyeri = (!empty($_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bak_isnyeri_neonatus'])?$_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bak_isnyeri_neonatus']:null);
                   $modAsesmenawalkeperawatanT->keb_eliminasi_bak_ispendarahan = (!empty($_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bak_ispendarahan_neonatus'])?$_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bak_ispendarahan_neonatus']:null);
                   $modAsesmenawalkeperawatanT->keb_eliminasi_bak_iskeluhanlainnya = (!empty($_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bak_iskeluhanlainnya_neonatus'])?$_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bak_iskeluhanlainnya_neonatus']:null);
                   $modAsesmenawalkeperawatanT->keb_eliminasi_bak_jeniskeluhanlainnya = (!empty($_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bak_jeniskeluhanlainnya_neonatus'])?$_POST['RIAsesmenawalkeperawatanT']['keb_eliminasi_bak_jeniskeluhanlainnya_neonatus']:null);
                   $modAsesmenawalkeperawatanT->ispasangtandaalergi = (!empty($_POST['RIAsesmenawalkeperawatanT']['ispasangtandaalergi_neonatus'])?$_POST['RIAsesmenawalkeperawatanT']['ispasangtandaalergi_neonatus']:null);
                   $modAsesmenawalkeperawatanT->jam_masukruangan = $_POST['RIAsesmenawalkeperawatanT']['jam_masukruangan_neonatus'];
                   $modAsesmenawalkeperawatanT->tgl_assesmen_awal = MyFormatter::formatDateTimeForDb($_POST['RIAsesmenawalkeperawatanT']['tgl_assesmen_awal_neonatus']);
                   $modAsesmenawalkeperawatanT->keluhanutama = isset($_POST['RIAsesmenawalkeperawatanT']['keluhanutama_neonatus']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhanutama_neonatus'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhanutama_neonatus']) : null) : null;
                   $modAsesmenawalkeperawatanT->keluhantambahan = isset($_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_neonatus']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_neonatus'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_neonatus']) : null) : null;
                   $modAsesmenawalkeperawatanT->neonatus_tgllahirbayi = (!empty($_POST['RIAsesmenawalkeperawatanT']['neonatus_tgllahirbayi'])? MyFormatter::formatDateTimeForDb($_POST['RIAsesmenawalkeperawatanT']['neonatus_tgllahirbayi']) : null);
                   $modAsesmenawalkeperawatanT->neonatus_tglpersalinan = (!empty($_POST['RIAsesmenawalkeperawatanT']['neonatus_tglpersalinan'])? MyFormatter::formatDateTimeForDb($_POST['RIAsesmenawalkeperawatanT']['neonatus_tglpersalinan']) : null);
                   $modAsesmenawalkeperawatanT->neonatus_jampersalinan = (!empty($_POST['RIAsesmenawalkeperawatanT']['neonatus_jampersalinan'])? $_POST['RIAsesmenawalkeperawatanT']['neonatus_jampersalinan'] : null);
                   $modAsesmenawalkeperawatanT->neonatus_jamketubanpecah = (!empty($_POST['RIAsesmenawalkeperawatanT']['neonatus_jamketubanpecah'])? $_POST['RIAsesmenawalkeperawatanT']['neonatus_jamketubanpecah'] : null);
                   $modAsesmenawalkeperawatanT->neonatus_jamlahir = (!empty($_POST['RIAsesmenawalkeperawatanT']['neonatus_jamlahir'])? $_POST['RIAsesmenawalkeperawatanT']['neonatus_jamlahir'] : null);

                    $modAsesmenawalkeperawatanT->neonatus_kebsosialekonomi_statusperkawinan = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan']:null;
                    $modAsesmenawalkeperawatanT->neonatus_pendidikanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_warganegaraortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_tinggalbersama = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama']:null;
                    $modAsesmenawalkeperawatanT->neonatus_agamaortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_pekerjaanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu']:null;

                   if(isset($_POST['RIAsesmenawalkeperawatanT']['is_keluhannyeri_dewasa'])){
                     if($_POST['RIAsesmenawalkeperawatanT']['is_keluhannyeri_dewasa'] == 0){
                       $modAsesmenawalkeperawatanT->is_keluhannyeri_dewasa = false;
                     }else if($_POST['RIAsesmenawalkeperawatanT']['is_keluhannyeri_dewasa'] == 1){
                       $modAsesmenawalkeperawatanT->is_keluhannyeri_dewasa = true;
                       $modAsesmenawalkeperawatanT->b1_rr = isset($_POST['RIAsesmenawalkeperawatanT']['b1_rr']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_rr']:null;
                       $modAsesmenawalkeperawatanT->b1_spo2 = isset($_POST['RIAsesmenawalkeperawatanT']['b1_spo2']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_spo2']:null;
                       $modAsesmenawalkeperawatanT->b1_iramapernapasan = isset($_POST['RIAsesmenawalkeperawatanT']['b1_iramapernapasan']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_iramapernapasan']:null;
                       $modAsesmenawalkeperawatanT->b1_polapernapasan = isset($_POST['RIAsesmenawalkeperawatanT']['b1_polapernapasan']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_polapernapasan']:null;
                       $modAsesmenawalkeperawatanT->b1_jenispernapasan = isset($_POST['RIAsesmenawalkeperawatanT']['b1_jenispernapasan']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_jenispernapasan']:null;
                       $modAsesmenawalkeperawatanT->b1_jalannapas = isset($_POST['RIAsesmenawalkeperawatanT']['b1_jalannapas']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_jalannapas']:null;
                       $modAsesmenawalkeperawatanT->b1_suaranafas = isset($_POST['RIAsesmenawalkeperawatanT']['b1_suaranafas']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_suaranafas']:null;
                       $modAsesmenawalkeperawatanT->b1_kesulitanbernafas = isset($_POST['RIAsesmenawalkeperawatanT']['b1_kesulitanbernafas']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_kesulitanbernafas']:null;
                       $modAsesmenawalkeperawatanT->b1_jmloksigenperliter = isset($_POST['RIAsesmenawalkeperawatanT']['b1_jmloksigenperliter']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_jmloksigenperliter']:null;
                       $modAsesmenawalkeperawatanT->b1_jenisterapioksigen = isset($_POST['RIAsesmenawalkeperawatanT']['b1_jenisterapioksigen']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_jenisterapioksigen']:null;
                       $modAsesmenawalkeperawatanT->b1_keluhanlain = isset($_POST['RIAsesmenawalkeperawatanT']['b1_keluhanlain']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_keluhanlain']:null;
                       $modAsesmenawalkeperawatanT->b1_pernapasan = isset($_POST['RIAsesmenawalkeperawatanT']['b1_pernapasan']) ? $_POST['RIAsesmenawalkeperawatanT']['b1_pernapasan']:null;
                        
                       $modAsesmenawalkeperawatanT->b2_td_systolic = isset($_POST['RIAsesmenawalkeperawatanT']['b2_td_systolic']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_td_systolic']:null;
                       $modAsesmenawalkeperawatanT->b2_td_diastolic = isset($_POST['RIAsesmenawalkeperawatanT']['b2_td_diastolic']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_td_diastolic']:null;
                       $modAsesmenawalkeperawatanT->b2_nadi = isset($_POST['RIAsesmenawalkeperawatanT']['b2_nadi']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_nadi']:null;
                       $modAsesmenawalkeperawatanT->b2_denyutjantung = isset($_POST['RIAsesmenawalkeperawatanT']['b2_denyutjantung']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_denyutjantung']:null;
                       $modAsesmenawalkeperawatanT->b2_akral = isset($_POST['RIAsesmenawalkeperawatanT']['b2_akral']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_akral']:null;
                       $modAsesmenawalkeperawatanT->b2_crt = isset($_POST['RIAsesmenawalkeperawatanT']['b2_crt']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_crt']:null;
                       $modAsesmenawalkeperawatanT->b2_isnyerdada = isset($_POST['RIAsesmenawalkeperawatanT']['b2_isnyerdada']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_isnyerdada']:null;
                       $modAsesmenawalkeperawatanT->b2_sirkulasinadi = isset($_POST['RIAsesmenawalkeperawatanT']['b2_sirkulasinadi']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_sirkulasinadi']:null;
                       $modAsesmenawalkeperawatanT->b2_ispendarahan = isset($_POST['RIAsesmenawalkeperawatanT']['b2_ispendarahan']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_ispendarahan']:null;
                       $modAsesmenawalkeperawatanT->b2_isoedem = isset($_POST['RIAsesmenawalkeperawatanT']['b2_isoedem']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_isoedem']:null;
                       $modAsesmenawalkeperawatanT->b2_lokasioedem = isset($_POST['RIAsesmenawalkeperawatanT']['b2_lokasioedem']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_lokasioedem']:null;
                       $modAsesmenawalkeperawatanT->b2_keluhanlain = isset($_POST['RIAsesmenawalkeperawatanT']['b2_keluhanlain']) ? $_POST['RIAsesmenawalkeperawatanT']['b2_keluhanlain']:null;
                                
                       $modAsesmenawalkeperawatanT->b3_kesadaran = isset($_POST['RIAsesmenawalkeperawatanT']['b3_kesadaran']) ? $_POST['RIAsesmenawalkeperawatanT']['b3_kesadaran']:null;
                       $modAsesmenawalkeperawatanT->b3_gcseye_nilai = isset($_POST['RIAsesmenawalkeperawatanT']['b3_gcseye_nilai']) ? $_POST['RIAsesmenawalkeperawatanT']['b3_gcseye_nilai']:null;
                       $modAsesmenawalkeperawatanT->b3_gcsverbal_nilai = isset($_POST['RIAsesmenawalkeperawatanT']['b3_gcsverbal_nilai']) ? $_POST['RIAsesmenawalkeperawatanT']['b3_gcsverbal_nilai']:null;
                       $modAsesmenawalkeperawatanT->b3_gcsmotoric_nilai = isset($_POST['RIAsesmenawalkeperawatanT']['b3_gcsmotoric_nilai']) ? $_POST['RIAsesmenawalkeperawatanT']['b3_gcsmotoric_nilai']:null;
                       $modAsesmenawalkeperawatanT->b3_kesimetrisanpupil = isset($_POST['RIAsesmenawalkeperawatanT']['b3_kesimetrisanpupil']) ? $_POST['RIAsesmenawalkeperawatanT']['b3_kesimetrisanpupil']:null;
                       $modAsesmenawalkeperawatanT->b3_ukuranreflek_pupilkanan = isset($_POST['RIAsesmenawalkeperawatanT']['b3_ukuranreflek_pupilkanan']) ? $_POST['RIAsesmenawalkeperawatanT']['b3_ukuranreflek_pupilkanan']:null;
                       $modAsesmenawalkeperawatanT->b3_ukuranreflek_pupilkiri = isset($_POST['RIAsesmenawalkeperawatanT']['b3_ukuranreflek_pupilkiri']) ? $_POST['RIAsesmenawalkeperawatanT']['b3_ukuranreflek_pupilkiri']:null;
                       $modAsesmenawalkeperawatanT->b3_paresa = isset($_POST['RIAsesmenawalkeperawatanT']['b3_paresa']) ? $_POST['RIAsesmenawalkeperawatanT']['b3_paresa']:null;
                       $modAsesmenawalkeperawatanT->b3_kejang = isset($_POST['RIAsesmenawalkeperawatanT']['b3_kejang']) ? $_POST['RIAsesmenawalkeperawatanT']['b3_kejang']:null;
                       $modAsesmenawalkeperawatanT->b3_keluhanlain = isset($_POST['RIAsesmenawalkeperawatanT']['b3_keluhanlain']) ? $_POST['RIAsesmenawalkeperawatanT']['b3_keluhanlain']:null;
                       
                       $modAsesmenawalkeperawatanT->b4_bakfrekuensi = isset($_POST['RIAsesmenawalkeperawatanT']['b4_bakfrekuensi']) ? $_POST['RIAsesmenawalkeperawatanT']['b4_bakfrekuensi']:null;
                       $modAsesmenawalkeperawatanT->b4_bakwarnaurin = isset($_POST['RIAsesmenawalkeperawatanT']['b4_bakwarnaurin']) ? $_POST['RIAsesmenawalkeperawatanT']['b4_bakwarnaurin']:null;
                       $modAsesmenawalkeperawatanT->b4_isnyeritekankandungkemih = isset($_POST['RIAsesmenawalkeperawatanT']['b4_isnyeritekankandungkemih']) ? $_POST['RIAsesmenawalkeperawatanT']['b4_isnyeritekankandungkemih']:null;
                       $modAsesmenawalkeperawatanT->b4_gangguan = isset($_POST['RIAsesmenawalkeperawatanT']['b4_gangguan']) ? $_POST['RIAsesmenawalkeperawatanT']['b4_gangguan']:null;
                       $modAsesmenawalkeperawatanT->b4_keluhanlain = isset($_POST['RIAsesmenawalkeperawatanT']['b4_keluhanlain']) ? $_POST['RIAsesmenawalkeperawatanT']['b4_keluhanlain']:null;
                     
                       $modAsesmenawalkeperawatanT->b5_statusnafasumakan = isset($_POST['RIAsesmenawalkeperawatanT']['b5_statusnafasumakan']) ? $_POST['RIAsesmenawalkeperawatanT']['b5_statusnafasumakan']:null;
                       $modAsesmenawalkeperawatanT->b5_mukosamulut = isset($_POST['RIAsesmenawalkeperawatanT']['b5_mukosamulut']) ? $_POST['RIAsesmenawalkeperawatanT']['b5_mukosamulut']:null;
                       $modAsesmenawalkeperawatanT->b5_abdomen_kesimetrisan = isset($_POST['RIAsesmenawalkeperawatanT']['b5_abdomen_kesimetrisan']) ? $_POST['RIAsesmenawalkeperawatanT']['b5_abdomen_kesimetrisan']:null;
                       $modAsesmenawalkeperawatanT->b5_abdomen_istegang = isset($_POST['RIAsesmenawalkeperawatanT']['b5_abdomen_istegang']) ? $_POST['RIAsesmenawalkeperawatanT']['b5_abdomen_istegang']:null;
                       $modAsesmenawalkeperawatanT->b5_abdomen_isascites = isset($_POST['RIAsesmenawalkeperawatanT']['b5_abdomen_isascites']) ? $_POST['RIAsesmenawalkeperawatanT']['b5_abdomen_isascites']:null;
                       $modAsesmenawalkeperawatanT->b5_abdomen_isnyeritekan = isset($_POST['RIAsesmenawalkeperawatanT']['b5_abdomen_isnyeritekan']) ? $_POST['RIAsesmenawalkeperawatanT']['b5_abdomen_isnyeritekan']:null;
                       $modAsesmenawalkeperawatanT->b5_abdomen_nyeritekanlokasi = isset($_POST['RIAsesmenawalkeperawatanT']['b5_abdomen_nyeritekanlokasi']) ? $_POST['RIAsesmenawalkeperawatanT']['b5_abdomen_nyeritekanlokasi']:null;
                       $modAsesmenawalkeperawatanT->b5_babfrekuensi = isset($_POST['RIAsesmenawalkeperawatanT']['b5_babfrekuensi']) ? $_POST['RIAsesmenawalkeperawatanT']['b5_babfrekuensi']:null;
                       $modAsesmenawalkeperawatanT->b5_warnafeces = isset($_POST['RIAsesmenawalkeperawatanT']['b5_warnafeces']) ? $_POST['RIAsesmenawalkeperawatanT']['b5_warnafeces']:null;
                       $modAsesmenawalkeperawatanT->b5_keluhanlain = isset($_POST['RIAsesmenawalkeperawatanT']['b5_keluhanlain']) ? $_POST['RIAsesmenawalkeperawatanT']['b5_keluhanlain']:null;
                       
                       $modAsesmenawalkeperawatanT->b6_suhutubuh = isset($_POST['RIAsesmenawalkeperawatanT']['b6_suhutubuh']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_suhutubuh']:null;
                       $modAsesmenawalkeperawatanT->b6_caraukursuhutubuh = isset($_POST['RIAsesmenawalkeperawatanT']['b6_caraukursuhutubuh']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_caraukursuhutubuh']:null;
                       $modAsesmenawalkeperawatanT->b6_pergerakan = isset($_POST['RIAsesmenawalkeperawatanT']['b6_pergerakan']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_pergerakan']:null;
                       $modAsesmenawalkeperawatanT->b6_isfraktur = isset($_POST['RIAsesmenawalkeperawatanT']['b6_isfraktur']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_isfraktur']:null;
                       $modAsesmenawalkeperawatanT->b6_jenisfraktur = isset($_POST['RIAsesmenawalkeperawatanT']['b6_jenisfraktur']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_jenisfraktur']:null;
                       $modAsesmenawalkeperawatanT->b6_lokasifraktur = isset($_POST['RIAsesmenawalkeperawatanT']['b6_lokasifraktur']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_lokasifraktur']:null;
                       $modAsesmenawalkeperawatanT->b6_warnakulit = isset($_POST['RIAsesmenawalkeperawatanT']['b6_warnakulit']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_warnakulit']:null;
                       $modAsesmenawalkeperawatanT->b6_otot = isset($_POST['RIAsesmenawalkeperawatanT']['b6_otot']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_otot']:null;
                       $modAsesmenawalkeperawatanT->b6_turgorkulit = isset($_POST['RIAsesmenawalkeperawatanT']['b6_turgorkulit']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_turgorkulit']:null;
                       $modAsesmenawalkeperawatanT->b6_lokasioedema = isset($_POST['RIAsesmenawalkeperawatanT']['b6_lokasioedema']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_lokasioedema']:null;
                       $modAsesmenawalkeperawatanT->b6_berkeringatbanyak = isset($_POST['RIAsesmenawalkeperawatanT']['b6_berkeringatbanyak']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_berkeringatbanyak']:null;
                       $modAsesmenawalkeperawatanT->b6_isresikodekubitus = isset($_POST['RIAsesmenawalkeperawatanT']['b6_isresikodekubitus']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_isresikodekubitus']:null;
                       $modAsesmenawalkeperawatanT->b6_skorbraden = isset($_POST['RIAsesmenawalkeperawatanT']['b6_skorbraden']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_skorbraden']:null;
                       $modAsesmenawalkeperawatanT->b6_isluka = isset($_POST['RIAsesmenawalkeperawatanT']['b6_isluka']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_isluka']:null;
                       $modAsesmenawalkeperawatanT->b6_lokasiluka = isset($_POST['RIAsesmenawalkeperawatanT']['b6_lokasiluka']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_lokasiluka']:null;
                       $modAsesmenawalkeperawatanT->b6_keluhanlain = isset($_POST['RIAsesmenawalkeperawatanT']['b6_keluhanlain']) ? $_POST['RIAsesmenawalkeperawatanT']['b6_keluhanlain']:null;

                       $modAsesmenawalkeperawatanT->istaatberibadah = isset($_POST['RIAsesmenawalkeperawatanT']['istaatberibadah']) ? $_POST['RIAsesmenawalkeperawatanT']['istaatberibadah']:null;
                       $modAsesmenawalkeperawatanT->orangterdekat = isset($_POST['RIAsesmenawalkeperawatanT']['orangterdekat']) ? $_POST['RIAsesmenawalkeperawatanT']['orangterdekat']:null;
                       $modAsesmenawalkeperawatanT->perasaansaatini = isset($_POST['RIAsesmenawalkeperawatanT']['perasaansaatini']) ? $_POST['RIAsesmenawalkeperawatanT']['perasaansaatini']:null;
                       $modAsesmenawalkeperawatanT->psikososialspiritual_keadaanumum = isset($_POST['RIAsesmenawalkeperawatanT']['psikososialspiritual_keadaanumum']) ? $_POST['RIAsesmenawalkeperawatanT']['psikososialspiritual_keadaanumum']:null;
                       $modAsesmenawalkeperawatanT->gangguanorientasi_terhadap = isset($_POST['RIAsesmenawalkeperawatanT']['gangguanorientasi_terhadap']) ? $_POST['RIAsesmenawalkeperawatanT']['gangguanorientasi_terhadap']:null;
                       $modAsesmenawalkeperawatanT->psikososialspriritual_keluhanlain = isset($_POST['RIAsesmenawalkeperawatanT']['psikososialspriritual_keluhanlain']) ? $_POST['RIAsesmenawalkeperawatanT']['psikososialspriritual_keluhanlain']:null;




                     }else if($_POST['RIAsesmenawalkeperawatanT']['is_keluhannyeri_dewasa'] == 2){
                       $modAsesmenawalkeperawatanT->is_keluhannyeri_dewasa = null;
                     }
                   }

                 }else if($modAsesmenawalkeperawatanT->jenisasesmen == 'asesmenri_obgyn'){
                    $modAsesmenawalkeperawatanT->jam_masukruangan = $_POST['RIAsesmenawalkeperawatanT']['jam_masukruangan_obgyn'];
                    $modAsesmenawalkeperawatanT->tgl_assesmen_awal = MyFormatter::formatDateTimeForDb($_POST['RIAsesmenawalkeperawatanT']['tgl_assesmen_awal_obgyn']);
                    $modAsesmenawalkeperawatanT->keluhanutama = isset($_POST['RIAsesmenawalkeperawatanT']['keluhanutama_obgyn']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhanutama_obgyn'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhanutama_obgyn']) : null) : null;
                    $modAsesmenawalkeperawatanT->keluhantambahan = isset($_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_obgyn']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_obgyn'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_obgyn']) : null) : null;

                    $modAsesmenawalkeperawatanT->obgyn_mensterakhir = (!empty($_POST['RIAsesmenawalkeperawatanT']['obgyn_mensterakhir'])? MyFormatter::formatDateTimeForDb($_POST['RIAsesmenawalkeperawatanT']['obgyn_mensterakhir']) : null);
                    $modAsesmenawalkeperawatanT->obgyn_taksiranpersalinan = (!empty($_POST['RIAsesmenawalkeperawatanT']['obgyn_taksiranpersalinan'])? MyFormatter::formatDateTimeForDb($_POST['RIAsesmenawalkeperawatanT']['obgyn_taksiranpersalinan']) : null);
                    $modAsesmenawalkeperawatanT->neonatus_kebsosialekonomi_statusperkawinan = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan']:null;
                    $modAsesmenawalkeperawatanT->neonatus_pendidikanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_warganegaraortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_tinggalbersama = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama']:null;
                    $modAsesmenawalkeperawatanT->neonatus_agamaortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_pekerjaanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu']:null;
                 }else if($modAsesmenawalkeperawatanT->jenisasesmen == 'asesmenri_geriatri'){
                   $modAsesmenawalkeperawatanT->jam_masukruangan = $_POST['RIAsesmenawalkeperawatanT']['jam_masukruangan_geriatri'];
                    $modAsesmenawalkeperawatanT->tgl_assesmen_awal = MyFormatter::formatDateTimeForDb($_POST['RIAsesmenawalkeperawatanT']['tgl_assesmen_awal_geriatri']);
                    $modAsesmenawalkeperawatanT->keluhanutama = isset($_POST['RIAsesmenawalkeperawatanT']['keluhanutama_geriatri']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhanutama_geriatri'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhanutama_geriatri']) : null) : null;
                    $modAsesmenawalkeperawatanT->keluhantambahan = isset($_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_geriatri']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_geriatri'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhantambahan_geriatri']) : null) : null;
                    $modAsesmenawalkeperawatanT->kondisiumum = isset($_POST['RIAsesmenawalkeperawatanT']['kondisiumum_geriatri']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['kondisiumum_geriatri'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['kondisiumum_geriatri']) : null) : null;
                    $modAsesmenawalkeperawatanT->neonatus_kebsosialekonomi_statusperkawinan = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_kebsosialekonomi_statusperkawinan']:null;
                    $modAsesmenawalkeperawatanT->neonatus_pendidikanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_pendidikanortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_warganegaraortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_warganegaraortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_tinggalbersama = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_tinggalbersama']:null;
                    $modAsesmenawalkeperawatanT->neonatus_agamaortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_agamaortu']:null;
                    $modAsesmenawalkeperawatanT->neonatus_pekerjaanortu = isset($_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu']) ? $_POST['RIAsesmenawalkeperawatanT']['neonatus_pekerjaanortu']:null;
                 }
                 else{
                   $modAsesmenawalkeperawatanT->jam_masukruangan = $_POST['RIAsesmenawalkeperawatanT']['jam_masukruangan'];
                   $modAsesmenawalkeperawatanT->tgl_assesmen_awal = MyFormatter::formatDateTimeForDb($_POST['RIAsesmenawalkeperawatanT']['tgl_assesmen_awal']);
                   $modAsesmenawalkeperawatanT->keluhanutama = isset($_POST['RIAsesmenawalkeperawatanT']['keluhanutama']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhanutama'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhanutama']) : null) : null;
                   $modAsesmenawalkeperawatanT->keluhantambahan = isset($_POST['RIAsesmenawalkeperawatanT']['keluhantambahan']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['keluhantambahan'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['keluhantambahan']) : null) : null;
                   $modAsesmenawalkeperawatanT->kondisiumum = isset($_POST['RIAsesmenawalkeperawatanT']['kondisiumum']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['kondisiumum'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['kondisiumum']) : null) : null;
                 }
                $modAsesmenawalkeperawatanT->neonatus_tgllahirbayi = (!empty($_POST['RIAsesmenawalkeperawatanT']['neonatus_tgllahirbayi'])? MyFormatter::formatDateTimeForDb($_POST['RIAsesmenawalkeperawatanT']['neonatus_tgllahirbayi']):null);
                $modAsesmenawalkeperawatanT->neonatus_jamlahir = (!empty($_POST['RIAsesmenawalkeperawatanT']['neonatus_jamlahir'])? $_POST['RIAsesmenawalkeperawatanT']['neonatus_jamlahir']:null);

                 $modAsesmenawalkeperawatanT->riwayatkelahiran = isset($_POST['RIAsesmenawalkeperawatanT']['riwayatkelahiran']) ? ((count((array)$_POST['RIAsesmenawalkeperawatanT']['riwayatkelahiran'])>0) ? implode(', ', $_POST['RIAsesmenawalkeperawatanT']['riwayatkelahiran']) : null) : null;
                 $modAsesmenawalkeperawatanT->riwayatperjalanan_penyakitpasien = isset($_POST['RIAsesmenawalkeperawatanT']['riwayatperjalanan_penyakitpasien'])?$_POST['RIAsesmenawalkeperawatanT']['riwayatperjalanan_penyakitpasien']:null;

                 $statusAlergi = null;
                 if(!empty($modAsesmenawalkeperawatanT->statusalergipasien)){
                     if($modAsesmenawalkeperawatanT->statusalergipasien == '1'){
                         $statusAlergi = "Tidak Ada";
                     }else if($modAsesmenawalkeperawatanT->statusalergipasien == '2'){
                         $statusAlergi = "Tidak Tahu";
                     }else if($modAsesmenawalkeperawatanT->statusalergipasien == '3'){
                         $statusAlergi = "Ada";
                     }
                 }
                 $modAsesmenawalkeperawatanT->statusalergipasien = $statusAlergi;

                 if($modAsesmenawalkeperawatanT->neonatus_dukungansosialdr_issuami){
                     $modAsesmenawalkeperawatanT->neonatus_dukungansosialdr = "Suami";
                 }

                 if($modAsesmenawalkeperawatanT->neonatus_dukungansosialdr_isistri){
                     $modAsesmenawalkeperawatanT->neonatus_dukungansosialdr = "Istri";
                 }

                 if($modAsesmenawalkeperawatanT->neonatus_dukungansosialdr_isortu){
                     $modAsesmenawalkeperawatanT->neonatus_dukungansosialdr = "Orang Tua";
                 }

                 if($modAsesmenawalkeperawatanT->neonatus_dukungansosialdr_iskeluarga){
                     $modAsesmenawalkeperawatanT->neonatus_dukungansosialdr = "Keluarga";
                 }

                 if($modAsesmenawalkeperawatanT->neonatus_dukungansosialdr_islainnya){
                     $modAsesmenawalkeperawatanT->neonatus_dukungansosialdr = "Lainnya";
                 }

                 if($modAsesmenawalkeperawatanT->kebutuhankhusus_isgigipalsu){
                     $modAsesmenawalkeperawatanT->kebutuhankhusus_ketgigipalsu = "Gigi Palsu";
                 }

                 if($modAsesmenawalkeperawatanT->kebutuhankhusus_isalatbantudengar){
                     $modAsesmenawalkeperawatanT->kebutuhankhusus_ketalatbantudengar = "Alat Bantu Dengar";
                 }

                 if($modAsesmenawalkeperawatanT->kebutuhankhusus_ispakaikacamata){
                     $modAsesmenawalkeperawatanT->kebutuhankhusus_ketpakaikacamata = "Kacamata";
                 }

                 if($modAsesmenawalkeperawatanT->kebutuhankhusus_istongkat){
                     $modAsesmenawalkeperawatanT->kebutuhankhusus_kettongkat = "Tongkat";
                 }

                 if($modAsesmenawalkeperawatanT->kebutuhankhusus_islainnya){
                     $modAsesmenawalkeperawatanT->kebutuhankhusus_ketlainnya = "Lainnya";
                 }

                 if($modAsesmenawalkeperawatanT->statuspsikologis_isstabil){
                     $modAsesmenawalkeperawatanT->statuspsikologis_ketstabil = "Stabil / Tenang";
                 }

                 if($modAsesmenawalkeperawatanT->statuspsikologis_iscemas){
                     $modAsesmenawalkeperawatanT->kebutuhankhusus_ketcemas = "Cemas / Takut";
                 }

                 if($modAsesmenawalkeperawatanT->statuspsikologis_ismarah){
                     $modAsesmenawalkeperawatanT->statuspsikologis_ketmarah = "Marah";
                 }

                 if($modAsesmenawalkeperawatanT->statuspsikologis_issedih){
                     $modAsesmenawalkeperawatanT->statuspsikologis_ketsedih = "Sedih";
                 }

                 if(!isset($modAsesmenawalkeperawatanT->is_keluhannyeri_dewasa) || empty($modAsesmenawalkeperawatanT->is_keluhannyeri_dewasa)){
                     $modAsesmenawalkeperawatanT->score_skalanyeri = (isset($_POST['RIAsesmenawalkeperawatanT']['score_skalanyeri_anak'])?$_POST['RIAsesmenawalkeperawatanT']['score_skalanyeri_anak']:null);
                     $modAsesmenawalkeperawatanT->keteranganskala_nyeri = (isset($_POST['RIAsesmenawalkeperawatanT']['keteranganskala_nyeri_anak'])?$_POST['RIAsesmenawalkeperawatanT']['keteranganskala_nyeri_anak']:null);
                 }

                 if($modAsesmenawalkeperawatanT->isnyerihilangdgn_minumobat){
                     $modAsesmenawalkeperawatanT->nyerihilangdgn_minumobatket = "Minum Obat";
                 }

                 if($modAsesmenawalkeperawatanT->isnyerihilangdgn_berubahposisi){
                     $modAsesmenawalkeperawatanT->nyerihilangdgn_berubahposisiket = "Berubah posisi/tidur";
                 }

                 if($modAsesmenawalkeperawatanT->isnyerihilangdgn_istirahat){
                     $modAsesmenawalkeperawatanT->nyerihilangdgn_istirahatket = "Istirahat";
                 }

                 if($modAsesmenawalkeperawatanT->isnyerihilangdgn_dengarmusik){
                     $modAsesmenawalkeperawatanT->nyerihilangdgn_dengarmusikket = "Mendengarkan Musik";
                 }

                 if($modAsesmenawalkeperawatanT->isnyerihilangdgn_lainlain){
                     $modAsesmenawalkeperawatanT->nyerihilangdgn_lainlainket = "Lain-lain";
                 }

                 if($modAsesmenawalkeperawatanT->keb_nutricairankeluhan_ismual){
                     $modAsesmenawalkeperawatanT->keb_nutricairankeluhan_mualket = "Mual";
                 }
                 if($modAsesmenawalkeperawatanT->keb_nutricairankeluhan_ismuntah){
                     $modAsesmenawalkeperawatanT->keb_nutricairankeluhan_muntahket = "Muntah";
                 }
                 if($modAsesmenawalkeperawatanT->keb_nutricairankeluhan_isgangguanmengunyah){
                     $modAsesmenawalkeperawatanT->keb_nutricairankeluhan_gangguanmengunyahket = "Gangguan Mengunyah";
                 }
                 if($modAsesmenawalkeperawatanT->keb_nutricairankeluhan_isgangguanmenelan){
                     $modAsesmenawalkeperawatanT->keb_nutricairankeluhan_gangguanmenelanket = "Gangguan Menelan";
                 }

                 if($modAsesmenawalkeperawatanT->keb_eliminasi_bab_ispendarahan){
                     $modAsesmenawalkeperawatanT->keb_eliminasi_bab_ketpendarahan = "Pendarahan";
                 }

                 if($modAsesmenawalkeperawatanT->keb_eliminasi_bab_ishemorroid){
                     $modAsesmenawalkeperawatanT->keb_eliminasi_bab_kethemorroid = "Hemorroid";
                 }

                 if($modAsesmenawalkeperawatanT->keb_eliminasi_bab_iskonstipasi){
                     $modAsesmenawalkeperawatanT->keb_eliminasi_bab_ketkonstipasi = "Konstipasi";
                 }

                 if($modAsesmenawalkeperawatanT->keb_eliminasi_bab_iskeluhanlainnya){
                     $modAsesmenawalkeperawatanT->keb_eliminasi_bab_ketkeluhanlainnya = "Lainnya";
                 }

                 if($modAsesmenawalkeperawatanT->keb_eliminasi_bak_ispendarahan){
                     $modAsesmenawalkeperawatanT->keb_eliminasi_bak_ketpendarahan = "Pendarahan";
                 }

                 if($modAsesmenawalkeperawatanT->keb_eliminasi_bak_isnyeri){
                     $modAsesmenawalkeperawatanT->keb_eliminasi_bak_ketnyeri = "Nyeri";
                 }

                 if($modAsesmenawalkeperawatanT->keb_eliminasi_bak_iskeluhanlainnya){
                     $modAsesmenawalkeperawatanT->keb_eliminasi_bak_ketkeluhanlainnya = "Lainnya";
                 }

                 if($modAsesmenawalkeperawatanT->identifikasipenyakit_ismenular){
                     $modAsesmenawalkeperawatanT->identifikasipenyakit_ketmenular = "Penyakit Menular";
                 }

                 if($modAsesmenawalkeperawatanT->identifikasipenyakit_ispenyakitjiwa){
                     $modAsesmenawalkeperawatanT->identifikasipenyakit_ketpenyakitjiwa = "Penyakit Jiwa";
                 }

                 if($modAsesmenawalkeperawatanT->identifikasipenyakitjiwa_iscenderungbunuhdiri){
                     $modAsesmenawalkeperawatanT->identifikasipenyakit_ketcenderungbunuhdiri = "cenderung Bunuh Diri";
                 }

                 if($modAsesmenawalkeperawatanT->identifikasipenyakitjiwa_isberlakuagresif){
                     $modAsesmenawalkeperawatanT->identifikasipenyakit_ketberlakuagresif = "Berlaku Agresif";
                 }

                 if($modAsesmenawalkeperawatanT->identifikasipenyakitjiwa_islainnya){
                     $modAsesmenawalkeperawatanT->identifikasipenyakit_ketlainnya = "Lainnya";
                 }

                 if(!empty($modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id)){
                     $modAsesmenawalkeperawatanT->update_time = date('Y-m-d H:i:s');
                     $modAsesmenawalkeperawatanT->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                 }else{
                    $modAsesmenawalkeperawatanT->create_time = date('Y-m-d H:i:s');
                     $modAsesmenawalkeperawatanT->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                 }
                 $modAsesmenawalkeperawatanT->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                 $modAsesmenawalkeperawatanT->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");

                 $arrRisikoInfeksi = array();

                 if (isset($_POST['RisikoInfeksi']) && count((array)$_POST['RisikoInfeksi']) > 0) {
                     foreach ($_POST['RisikoInfeksi'] as $dataRisiko) {
                         if (isset($dataRisiko['isRisiko']) && $dataRisiko['isRisiko'] == 1) {
                             $arrRisikoInfeksi[] = $dataRisiko['jenisrisiko'];
                         }
                     }
                 }

                 if(count((array)$arrRisikoInfeksi) > 0){
                    $modAsesmenawalkeperawatanT->jenisrisikoinfeksi = json_encode($arrRisikoInfeksi);
                 }

                 $arrAddtional = array();

                 if (isset($_POST['Addtional']) && count((array)$_POST['Addtional']) > 0) {
                     foreach ($_POST['Addtional'] as $dataAddtion) {
                         if (isset($dataAddtion['isaddtional_precaution']) && $dataAddtion['isaddtional_precaution'] == 1) {
                             $arrAddtional[] = $dataAddtion['addtional_precaution'];
                         }
                     }
                 }
                 if(count((array)$arrAddtional) > 0){
                    $modAsesmenawalkeperawatanT->addtional_precaution = json_encode($arrAddtional);
                 }

                 $arrKualitasNyeri = array();

                 if (isset($_POST['KualitasNyeri']) && count((array)$_POST['KualitasNyeri']) > 0) {
                     foreach ($_POST['KualitasNyeri'] as $dataKualitas) {
                         if (isset($dataKualitas['isKualitas']) && $dataKualitas['isKualitas'] == 1) {
                             $arrKualitasNyeri[] = $dataKualitas['nama'];
                         }
                     }
                 }
                 if(count((array)$arrKualitasNyeri) > 0){
                    $modAsesmenawalkeperawatanT->kualitasnyeri = json_encode($arrKualitasNyeri);
                 }

                 $arrFrekuensiNyeri = array();

                 if (isset($_POST['FrekuensiNyeri']) && count((array)$_POST['FrekuensiNyeri']) > 0) {
                     foreach ($_POST['FrekuensiNyeri'] as $dataFrekuensi) {
                         if (isset($dataFrekuensi['isFrekuensi']) && $dataFrekuensi['isFrekuensi'] == 1) {
                             $arrFrekuensiNyeri[] = $dataFrekuensi['nama'];
                         }
                     }
                 }
                 if(count((array)$arrFrekuensiNyeri) > 0){
                    $modAsesmenawalkeperawatanT->deskripsinyeri_frekuensinyeri = json_encode($arrFrekuensiNyeri);
                 }

                 $arrKeluhanHamil = array();

                 if (isset($_POST['KeluhanHamil']) && count((array)$_POST['KeluhanHamil']) > 0) {
                     foreach ($_POST['KeluhanHamil'] as $dataKeluhan) {
                         if (isset($dataKeluhan['iskeluhanhamil']) && $dataKeluhan['iskeluhanhamil'] == 1) {
                             $arrKeluhanHamil[] = $dataKeluhan['keluhanhamil'];
                         }
                     }
                 }
                 if(count((array)$arrKeluhanHamil) > 0){
                    $modAsesmenawalkeperawatanT->obgyn_keluhansaathamil = json_encode($arrKeluhanHamil);
                 }

                 $arrResikoPasien = array();

                 if (isset($_POST['Resikotinggipasien']) && count((array)$_POST['Resikotinggipasien']) > 0) {
                     foreach ($_POST['Resikotinggipasien'] as $dataResikoPasien) {
                         if (isset($dataResikoPasien['ischeck']) && $dataResikoPasien['ischeck'] == 1) {
                             $arrResikoPasien[] = $dataResikoPasien['nama'];
                         }
                     }
                 }
                 if(count((array)$arrResikoPasien) > 0){
                    $modAsesmenawalkeperawatanT->resikotinggi_pasien = json_encode($arrResikoPasien);
                 }

                 $arrJenisPernapasan = array();
                 if (isset($_POST['Jenispernapasan']) && count((array)$_POST['Jenispernapasan']) > 0) {
                     foreach ($_POST['Jenispernapasan'] as $dataJenisPernapasan) {
                         if (isset($dataJenisPernapasan['isJenis']) && $dataJenisPernapasan['isJenis'] == 1) {
                             $arrJenisPernapasan[] = $dataJenisPernapasan['jenis'];
                         }
                     }
                 }
                 if(count((array)$arrJenisPernapasan) > 0){
                    $modAsesmenawalkeperawatanT->b1_jenispernapasan = json_encode($arrJenisPernapasan);
                 }

                 $arrPolaPernapasan = array();
                 if (isset($_POST['Polapernapasan']) && count((array)$_POST['Polapernapasan']) > 0) {
                     foreach ($_POST['Polapernapasan'] as $dataPolaPernapasan) {
                         if (isset($dataPolaPernapasan['isPola']) && $dataPolaPernapasan['isPola'] == 1) {
                             $arrPolaPernapasan[] = $dataPolaPernapasan['pola'];
                         }
                     }
                 }
                 if(count((array)$arrPolaPernapasan) > 0){
                    $modAsesmenawalkeperawatanT->b1_polapernapasan = json_encode($arrPolaPernapasan);
                 }

                 $arrSuaraNafas = array();
                 if (isset($_POST['Suaranafas']) && count((array)$_POST['Suaranafas']) > 0) {
                     foreach ($_POST['Suaranafas'] as $dataSuaraNafas) {
                         if (isset($dataSuaraNafas['isSuaranafas']) && $dataSuaraNafas['isSuaranafas'] == 1) {
                             $arrSuaraNafas[] = $dataSuaraNafas['suaranafas'];
                         }
                     }
                 }
                 if(count((array)$arrSuaraNafas) > 0){
                    $modAsesmenawalkeperawatanT->b1_suaranafas = json_encode($arrSuaraNafas);
                 }




                 $arrPernafasan = array();
                 if (isset($_POST['Pernapasan']) && count((array)$_POST['Pernapasan']) > 0) {
                     foreach ($_POST['Pernapasan'] as $dataPernafasan) {
                         if (isset($dataPernafasan['isPernapasan']) && $dataPernafasan['isPernapasan'] == 1) {
                             $arrPernafasan[] = $dataPernafasan['pernapasan'];
                         }
                     }
                 }
                 if(count((array)$arrPernafasan) > 0){
                    $modAsesmenawalkeperawatanT->b1_pernapasan = json_encode($arrPernafasan);
                 }



                 $arrB3Kejang = array();
                 if (isset($_POST['B3Kejang']) && count((array)$_POST['B3Kejang']) > 0) {
                     foreach ($_POST['B3Kejang'] as $dataB3Kejang) {
                         if (isset($dataB3Kejang['isKejang']) && $dataB3Kejang['isKejang'] == 1) {
                             $arrB3Kejang[] = $dataB3Kejang['kejang'];
                         }
                     }
                 }
                 if(count((array)$arrB3Kejang) > 0){
                    $modAsesmenawalkeperawatanT->b3_kejang = json_encode($arrB3Kejang);
                 }

                 $arrB4Gangguan = array();
                 if (isset($_POST['B4Gangguan']) && count((array)$_POST['B4Gangguan']) > 0) {
                     foreach ($_POST['B4Gangguan'] as $dataB4Gangguan) {
                         if (isset($dataB4Gangguan['isGangguan']) && $dataB4Gangguan['isGangguan'] == 1) {
                             $arrB4Gangguan[] = $dataB4Gangguan['gangguan'];
                         }
                     }
                 }
                 if(count((array)$arrB4Gangguan) > 0){
                    $modAsesmenawalkeperawatanT->b4_gangguan = json_encode($arrB4Gangguan);
                 }

                 $arrB6Warnakulit = array();
                 if (isset($_POST['B6Warnakulit']) && count((array)$_POST['B6Warnakulit']) > 0) {
                     foreach ($_POST['B6Warnakulit'] as $dataB6Warnakulit) {
                         if (isset($dataB6Warnakulit['iswarnakulit']) && $dataB6Warnakulit['iswarnakulit'] == 1) {
                             $arrB6Warnakulit[] = $dataB6Warnakulit['warnakulit'];
                         }
                     }
                 }
                 if(count((array)$arrB6Warnakulit) > 0){
                    $modAsesmenawalkeperawatanT->b6_warnakulit = json_encode($arrB6Warnakulit);
                 }

                 $arrB6Otot = array();
                 if (isset($_POST['B6Otot']) && count((array)$_POST['B6Otot']) > 0) {
                     foreach ($_POST['B6Otot'] as $dataB6Otot) {
                         if (isset($dataB6Otot['isOtot']) && $dataB6Otot['isOtot'] == 1) {
                             $arrB6Otot[] = $dataB6Otot['otot'];
                         }
                     }
                 }
                 if(count((array)$arrB6Otot) > 0){
                    $modAsesmenawalkeperawatanT->b6_otot = json_encode($arrB6Otot);
                 }

                 $arrKomplikasiKehamilan = array();
                 if (isset($_POST['KomplikasiKehamilan']) && count((array)$_POST['KomplikasiKehamilan']) > 0) {
                     foreach ($_POST['KomplikasiKehamilan'] as $dataKomplikasiKehamilan) {
                         if (isset($dataKomplikasiKehamilan['iskomplikasi']) && $dataKomplikasiKehamilan['iskomplikasi'] == 1) {
                             $arrKomplikasiKehamilan[] = $dataKomplikasiKehamilan['komplikasi'];
                         }
                     }
                 }
                 if(count((array)$arrKomplikasiKehamilan) > 0){
                    $modAsesmenawalkeperawatanT->neonatus_kompilkasikehamilan = json_encode($arrKomplikasiKehamilan);
                 }

                 $arrKebiasaanKehamilan = array();
                 if (isset($_POST['KebiasaanKehamilan']) && count((array)$_POST['KebiasaanKehamilan']) > 0) {
                     foreach ($_POST['KebiasaanKehamilan'] as $dataKebiasaanKehamilan) {
                         if (isset($dataKebiasaanKehamilan['iskebiasaan']) && $dataKebiasaanKehamilan['iskebiasaan'] == 1) {
                             $arrKebiasaanKehamilan[] = $dataKebiasaanKehamilan['kebiasaan'];
                         }
                     }
                 }
                 if(count((array)$arrKebiasaanKehamilan) > 0){
                    $modAsesmenawalkeperawatanT->neonatus_kebiasaansaathamil = json_encode($arrKebiasaanKehamilan);
                 }


                 if($modAsesmenawalkeperawatanT->save()){
                     $this->tersimpanAsesmenAwalKep = true;

                     if(isset($_POST['RISkrinningnyerianakdetT'])){
                        if(count((array)$_POST['RISkrinningnyerianakdetT']) > 0){
                             RISkrinningnyerianakdetT::model()->deleteAllByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                             foreach ($_POST['RISkrinningnyerianakdetT'] as $dataDet){
                                 if(!empty($dataDet['kat_skalanyeri_id'])){
                                     $modelDet = new RISkrinningnyerianakdetT();
                                     $modelDet->kat_skalanyeri_id = $dataDet['kat_skalanyeri_id'];
                                     $modelDet->skalanyeriflaccs_param = $dataDet['skalanyeriflaccs_param'];
                                     $modelDet->skalanyeriflaccs_nilai = $dataDet['skalanyeriflaccs_nilai'];
                                     $modelDet->tgl_asesmentnyerianakdet = date('Y-m-d H:i:s');

                                     $modelDet->asesmenawalkeperawatan_id = $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id;
                                     $modelDet->create_time = date('Y-m-d H:i:s');
                                     $modelDet->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                      $modelDet->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                                      $modelDet->create_pegawaipengisi_id = Yii::app()->user->getState("pegawai_id");

                                      if(!$modelDet->save()){
                                          $tersimpandetailNyeri = false;
                                      }
                                 }
                             }
                         }
                     }

                     if(isset($_POST['AsesmentumbuhkembanganakT'])){
                        if(count((array)$_POST['AsesmentumbuhkembanganakT']) > 0){
                             AsesmentumbuhkembanganakT::model()->deleteAllByAttributes(array('asesmenawalkeperawatan_id'=>$modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id));

                             foreach ($_POST['AsesmentumbuhkembanganakT'] as $dataTmb){
                                 if(!empty($dataTmb['ischeckbox']) && $dataTmb['ischeckbox']=='1'){
                                     $modelDet = new AsesmentumbuhkembanganakT();
                                     $modelDet->tumbuhkembanganak_jenis = $dataTmb['tumbuhkembanganak_jenis'];
                                     $modelDet->tumbuhkembanganak_usia = $dataTmb['tumbuhkembanganak_usia'];
                                     $modelDet->asesmenawalkeperawatan_id = $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id;

                                      if(!$modelDet->save()){
                                          $tersimpanTumbuhKembang = false;
                                      }
                                 }
                             }
                         }
                     }

                     if(isset($_POST['RiwayatKehamilan'])){
                        if(count((array)$_POST['RiwayatKehamilan']) > 0){

                             foreach ($_POST['RiwayatKehamilan'] as $dataTmb){
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
                                 $modelDetObs->isabortur = (!empty($dataTmb['abortus'])?(($dataTmb['abortus']=='Ya')?true:false):false);
                                 $modelDetObs->persalinan_komplikasiket = $dataTmb['keterangan'];

                                  if(!$modelDetObs->save()){
                                      $tersimpanRiwayatObs = false;
                                  }
                             }
                         }
                     }

                     if(isset($_POST['RIAsesmenkebutuhanEdukasiT'])){
                        // echo '<pre>';
                        // var_dump($_POST['RIAsesmenkebutuhanEdukasiT']);die;
                         $modAsesmenkebutuhanEdukasiT->attributes = $_POST['RIAsesmenkebutuhanEdukasiT'];
                         $modAsesmenkebutuhanEdukasiT->asesmenawalkeperawatan_id = $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id;

                         if($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_pasien){
                             $modAsesmenkebutuhanEdukasiT->penerimaedukasi_pasien = "Pasien";
                         }

                         if($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_pasien ){
                             $modAsesmenkebutuhanEdukasiT->penerimaedukasi_keluargapasien = "Keluarga Pasien";
                         }

                         if($modAsesmenkebutuhanEdukasiT->ispenerimaedukasi_lainnya){
                             $modAsesmenkebutuhanEdukasiT->penerimaedukasi_lainnya = "Lainnya";
                         }

                         if($modAsesmenawalkeperawatanT->jenisasesmen == 'asesmenri_neonatus'){
                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_bahasa_neonatus){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_bahasa = "Bahasa";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_pendengaran_neonatus){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_pendengaran = "Pendengaran";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_penglihatan_neonatus){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_penglihatan = "Penglihatan";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_motivasi_neonatus){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_motivasi = "Motivasi";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_fisik_neonatus){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_fisik = "Fisik";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_emosi_neonatus){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_emosi = "Emosi";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_butahuruf_neonatus){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_butahuruf = "Buta Huruf";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_usia_neonatus){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_usia = "Usia";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_kognitif_neonatus){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_kognitif = "Kognitif";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_tidakada_neonatus){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_tidakada = "Tida Ada";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_menulis_neonatus){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_menulis = "Menulis";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_audiovisual_neonatus){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_audiovisual = "Audio-Visul/ gambar";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_diskusi_neonatus){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_diskusi = "Diskusi";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_demonstrasi_neonatus){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_demonstrasi = "Demonstrasi";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_membaca_neonatus){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_membaca = "Membaca";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_mendengarkan_neonatus){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_mendengarkan = "Mendengarkan";
                           }

                             $modAsesmenkebutuhanEdukasiT->bicara_status = (!empty($_POST['RIAsesmenkebutuhanEdukasiT']['bicara_status_neonatus'])?$_POST['RIAsesmenkebutuhanEdukasiT']['bicara_status_neonatus']:null);
                             $modAsesmenkebutuhanEdukasiT->mulaiseranganawal = (isset($_POST['RIAsesmenkebutuhanEdukasiT']['mulaiseranganawal_neonatus'])?$_POST['RIAsesmenkebutuhanEdukasiT']['mulaiseranganawal_neonatus']:null);
                             $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_status = (isset($_POST['RIAsesmenkebutuhanEdukasiT']['kebutuhanpenerjemah_status_neonatus'])?$_POST['RIAsesmenkebutuhanEdukasiT']['kebutuhanpenerjemah_status_neonatus']:null);
                             $modAsesmenkebutuhanEdukasiT->kebutuhanpenerjemah_jenisbahasa = (isset($_POST['RIAsesmenkebutuhanEdukasiT']['kebutuhanpenerjemah_jenisbahasa_neonatus'])? $_POST['RIAsesmenkebutuhanEdukasiT']['kebutuhanpenerjemah_jenisbahasa_neonatus']:null);
                             $modAsesmenkebutuhanEdukasiT->bahasaisyarat_status = (isset($_POST['RIAsesmenkebutuhanEdukasiT']['bahasaisyarat_status_neonatus'])?$_POST['RIAsesmenkebutuhanEdukasiT']['bahasaisyarat_status_neonatus']:null);

                         }else{
                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_bahasa){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_bahasa = "Bahasa";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_pendengaran){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_pendengaran = "Pendengaran";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_penglihatan){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_penglihatan = "Penglihatan";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_motivasi){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_motivasi = "Motivasi";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_fisik){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_fisik = "Fisik";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_emosi){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_emosi = "Emosi";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_butahuruf){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_butahuruf = "Buta Huruf";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_usia){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_usia = "Usia";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_kognitif){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_kognitif = "Kognitif";
                           }

                           if($modAsesmenkebutuhanEdukasiT->ishambatanbelajar_tidakada){
                               $modAsesmenkebutuhanEdukasiT->hambatanbelajar_tidakada = "Tida Ada";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_menulis){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_menulis = "Menulis";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_audiovisual){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_audiovisual = "Audio-Visul/ gambar";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_diskusi){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_diskusi = "Diskusi";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_demonstrasi){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_demonstrasi = "Demonstrasi";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_membaca){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_membaca = "Membaca";
                           }

                           if($modAsesmenkebutuhanEdukasiT->iscarabelajardisukai_mendengarkan){
                               $modAsesmenkebutuhanEdukasiT->carabelajardisukai_mendengarkan = "Mendengarkan";
                           }
                         }



                         if(!empty($modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id)){
                             $modAsesmenkebutuhanEdukasiT->update_time = date('Y-m-d H:i:s');
                             $modAsesmenkebutuhanEdukasiT->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                         }else{
                             $modAsesmenkebutuhanEdukasiT->create_time = date('Y-m-d H:i:s');
                             $modAsesmenkebutuhanEdukasiT->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                         }
                         $modAsesmenkebutuhanEdukasiT->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                         $modAsesmenkebutuhanEdukasiT->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");




                         if($modAsesmenkebutuhanEdukasiT->save()){
                             $this->tersimpanKebEdukasi = true;

                             if(isset($_POST['RIAsesmenkebutuhanEdukasidetT']) && count((array)$_POST['RIAsesmenkebutuhanEdukasidetT']) > 0){
                                 RIAsesmenkebutuhanEdukasidetT::model()->deleteAllByAttributes(array('asesmenkebutuhan_edukasi_id'=>$modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));

                                 foreach ($_POST['RIAsesmenkebutuhanEdukasidetT'] as $dataEduDet){
                                     if(!empty($dataEduDet['isedukasipasien']) && $dataEduDet['isedukasipasien']=='1'){
                                         $modelDet = new RIAsesmenkebutuhanEdukasidetT();
                                         $modelDet->asesmenkebutuhan_edukasi_id = $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id;
                                         $modelDet->edukasipasien = $dataEduDet['edukasipasien'];
                                         $modelDet->edukasipasien_lainnya = isset($dataEduDet['edukasipasien_lainnya'])?$dataEduDet['edukasipasien_lainnya']:null;

                                         if(!$modelDet->save()){
                                              $tersimpandetailEdukasi = false;
                                          }
                                     }
                                 }
                             }
                         }else{
                             $this->tersimpanKebEdukasi = false;
                         }
                     }

                     if(isset($_POST['PeriksafisikneonatusriT'])){
                       $modPeriksaFisikNeonatus->attributes = $_POST['PeriksafisikneonatusriT'];
                       $modPeriksaFisikNeonatus->asesmenawalkeperawatan_id = $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id;

                       if(!empty($modPeriksaFisikNeonatus->periksafisikneonatusri_id)){
                           $modPeriksaFisikNeonatus->update_time = date('Y-m-d H:i:s');
                           $modPeriksaFisikNeonatus->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                       }else{
                           $modPeriksaFisikNeonatus->create_time = date('Y-m-d H:i:s');
                           $modPeriksaFisikNeonatus->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                       }
                       $modPeriksaFisikNeonatus->create_ruangan = Yii::app()->user->getState("ruangan_id");

                       if(!$modPeriksaFisikNeonatus->save()){
                         $tersimpanPeriksaFisikNeonatus = false;
                       }
                     }


                     if(isset($_POST['BarthelindexadlT']) && !empty($_POST['BarthelindexadlT']['perawat_id'])){
                       $modBarthelindex->attributes = $_POST['BarthelindexadlT'];
                       $modBarthelindex->asesmenawalkeperawatan_id = $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id;

                       if(!empty($modBarthelindex->barthelindexadl_id)){
                           $modBarthelindex->update_time = date('Y-m-d H:i:s');
                           $modBarthelindex->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                       }else{
                           $modBarthelindex->create_time = date('Y-m-d H:i:s');
                           $modBarthelindex->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                       }
                       $modBarthelindex->create_ruangan = Yii::app()->user->getState("ruangan_id");

                       if(!$modBarthelindex->save()){
                         $tersimpanBathelindex = false;
                       }
                     }

                     if(isset($_POST['AskepgeriatriT'])){
                       $modAskepgeriatriT->attributes = $_POST['AskepgeriatriT'];
                       $modAskepgeriatriT->asesmenawalkeperawatan_id = $modAsesmenawalkeperawatanT->asesmenawalkeperawatan_id;

                       if(!empty($modAskepgeriatriT->askepgeriatri_id)){
                           $modAskepgeriatriT->update_time = date('Y-m-d H:i:s');
                           $modAskepgeriatriT->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                       }else{
                           $modAskepgeriatriT->create_time = date('Y-m-d H:i:s');
                           $modAskepgeriatriT->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                           $modAskepgeriatriT->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                           $modAskepgeriatriT->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                       }

                       $arrPerasaan = array();
                       if (isset($_POST['Perasaan']) && count((array)$_POST['Perasaan']) > 0) {
                           foreach ($_POST['Perasaan'] as $dataPerasaan) {
                               if (isset($dataPerasaan['isPerasaan']) && $dataPerasaan['isPerasaan'] == 1) {
                                   $arrPerasaan[] = $dataPerasaan['name'];
                               }
                           }
                       }
                       if(count((array)$arrPerasaan) > 0){
                          $modAskepgeriatriT->perasaanyg_dirasakan = json_encode($arrPerasaan);
                       }



                       if($modAskepgeriatriT->save()){
                         $tersimpanRenPulang = true;
                         $tersimpanMMSE = true;

                         if(!empty($_POST['PenilaianrencanapulangT'])){
                              PenilaianrencanapulangT::model()->deleteAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

                              foreach ($_POST['PenilaianrencanapulangT'] as $dataDet){
                                  if(!empty($dataDet['hasil'])){
                                    if(isset($dataDet['penilaianrencanapulang_id']) && !empty($dataDet['penilaianrencanapulang_id'])){
                                      $modRenPul = PenilaianrencanapulangT::model()->findByPk($dataDet['penilaianrencanapulang_id']);
                                      if(!isset($modRenPul) || empty($modRenPul)){
                                          $modRenPul = new PenilaianrencanapulangT();
                                      }
                                    }else{
                                      $modRenPul = new PenilaianrencanapulangT();
                                    }

                                      $modRenPul->attributes = $dataDet;
                                      $modRenPul->askepgeriatri_id = $modAskepgeriatriT->askepgeriatri_id;

                                      if(!empty($modRenPul->penilaianrencanapulang_id)){
                                        $modRenPul->update_time = date('Y-m-d H:i:s');
                                        $modRenPul->update_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
                                      }else{
                                        $modRenPul->create_time = date('Y-m-d H:i:s');
                                        $modRenPul->create_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
                                         $modRenPul->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                                      }

                                       if(!$modRenPul->save()){
                                           $tersimpanRenPulang = false;
                                       }
                                  }
                              }
                          }

                          if(!empty($_POST['MinimentalexampasienT'])){
                               foreach ($_POST['MinimentalexampasienT'] as $dataDet){
                                 $mmse_uploadgambar = CUploadedFile::getInstancesByName('uploadgambar_mmse');

                                   if((!empty($dataDet['nilai_responden'])) || (isset($mmse_uploadgambar) && count($mmse_uploadgambar) > 0)){
                                     if(isset($dataDet['minimentalexampasien_id']) && !empty($dataDet['minimentalexampasien_id'])){
                                       $modMMSE = MinimentalexampasienT::model()->findByPk($dataDet['minimentalexampasien_id']);
                                       if(!isset($modMMSE) || empty($modMMSE)){
                                         $modMMSE = new MinimentalexampasienT();
                                       }
                                     }else{
                                       $modMMSE = new MinimentalexampasienT();
                                     }
                                       $modMMSE->attributes = $dataDet;
                                       $modMMSE->askepgeriatri_id = $modAskepgeriatriT->askepgeriatri_id;

                                       if(!empty($modMMSE->minimentalexampasien_id)){
                                         $modMMSE->update_time = date('Y-m-d H:i:s');
                                         $modMMSE->update_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
                                       }else{
                                         $modMMSE->create_time = date('Y-m-d H:i:s');
                                         $modMMSE->create_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
                                        $modMMSE->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                                       }

                                        if($modMMSE->save()){
                                          $simpanMMSEDet = true;
                                          $minimaxMaster = MinimentalexamM::model()->findByAttributes(array('minimentalexam_id'=>$modMMSE->minimentalexam_id,'isupload_gambar'=>true));

                                          if(count((array)$mmse_uploadgambar) > 0 && (isset($minimaxMaster) && !empty($minimaxMaster))){
                                            foreach($mmse_uploadgambar as $dataUploadDet){
                                              $random = rand(0000000, 9999999);
                                              $modMMSEDet = new MinimentalexampasiendetT();
                                              $modMMSEDet->minimentalexampasien_id = $modMMSE->minimentalexampasien_id;
                                              $modMMSEDet->gambar =  $random . $dataUploadDet;
                                              $fullImgSource = Params::pathMasterMinimentalexam() . $modMMSEDet->gambar;

                                              if ($modMMSEDet->save()) {
                                                $dataUploadDet->saveAs($fullImgSource);
                                              }else{
                                                $simpanMMSEDet = false;
                                              }
                                            }
                                          }
                                          if($simpanMMSEDet==false){
                                              $tersimpanMMSE = false;
                                          }
                                        }else{
                                          $tersimpanMMSE = false;
                                        }
                                   }
                               }
                           }

                          if($tersimpanRenPulang == false && $tersimpanMMSE == false){
                            $tersimpanAskepGeriatri = false;
                          }
                       }else{
                         $tersimpanAskepGeriatri = false;
                       }
                     }
                 }else{
                     $this->tersimpanAsesmenAwalKep = false;
                 }

             }


             
                 if ($this->tersimpanAsesmenAwalKep == true && $tersimpandetailNyeri == true && $this->tersimpanKebEdukasi == true && $tersimpandetailEdukasi== true && $tersimpanTumbuhKembang == true && $tersimpanRiwayatObs == true && $tersimpanBathelindex == true && $tersimpanPeriksaFisikNeonatus == true && $tersimpanAskepGeriatri == true){
                     $transaction->commit();
                     $sukses = 1;
                     $pesan = "Data Berhasil disimpan!!";
                 }else{
                   $transaction->rollback();
                   $sukses = 0;
                   $pesan = "Data gagal Disimpan!!";
                 }
             } catch (Exception $ex) {
               // echo '<pre>';
               // print_r($ex);
               // exit();
                 $transaction->rollback();
                 $sukses = 0;
                 $pesan = "Data gagal Disimpan!! ".MyExceptionMessage::getMessage($ex,true);
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

        $model = RIAsesmenawalkeperawatanT::model()->findByPk($asesmenawalkeperawatan_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
        $modPasien = PasienM::model()->findByPk($model->pasien_id);
        $ruanganid = $modPendaftaran->ruangan_id;

        if(isset($modPasienAdmisi) && !empty($modPasienAdmisi)){
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
        $modRiwayatObstertikpasien = array();
        $modMinimentalexampasienT = array();
        $modMinimentalexampasiendetT = array();
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

            $modBarthelindexadlT = BarthelindexadlT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
            if(!isset($modBarthelindexadlT)){
              $modBarthelindexadlT = new BarthelindexadlT();
            }
            $modPeriksaFisikNeonatus = PeriksafisikneonatusriT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));

            if(!isset($modPeriksaFisikNeonatus)){
                $modPeriksaFisikNeonatus = new PeriksafisikneonatusriT();
            }

            $modAskepgeriatriT = AskepgeriatriT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));

            if(!isset($modAskepgeriatriT)){
                $modAskepgeriatriT = new AskepgeriatriT();
                $modPenilaianRenPulang = array();
            }else{
              $modPenilaianRenPulang = PenilaianrencanapulangT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

              $modMinimentalexampasienT = MinimentalexampasienT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

              if(count((array)$modMinimentalexampasienT) > 0){
                $modMinimentalexampasiendetT = array();
                foreach($modMinimentalexampasienT as $dataMiniMentalPasien){
                    $modMinimentalexampasiendetT = MinimentalexampasiendetT::model()->findAllByAttributes(array('minimentalexampasien_id'=>$dataMiniMentalPasien->minimentalexampasien_id));
                }
              }else{
                $modMinimentalexampasienT = array();
                $modMinimentalexampasiendetT = array();
              }
            }

            $modRiwayatObstertikpasien = RiwayatobstetrikpasienT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));
        }else{
          $modAsesmenkebutuhanEdukasiT = new AsesmenkebutuhanEdukasiT();
          $modAsesmenkebutuhanEdukasidetT = new AsesmenkebutuhanEdukasidetT();
          $modBarthelindexadlT = new BarthelindexadlT();
          $modPeriksaFisikNeonatus = new PeriksafisikneonatusriT();
          $modAskepgeriatriT = new AskepgeriatriT();
          $modPenilaianRenPulang = array();
          $modMinimentalexampasienT = array();
          $modMinimentalexampasiendetT = array();
        }

        if (count((array)$modSkrinningnyerianakdetT) > 0) {
            $getFlaCcs = $modSkrinningnyerianakdetT;

            if (count((array)$getFlaCcs) > 0) {
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

        $model->kepala_hasilperiksa=($model->kepala_hasilperiksa==true)?1:0;
        $model->mata_hasilperiksa=($model->mata_hasilperiksa==true)?1:0;
        $model->leher_hasilperiksa=($model->leher_hasilperiksa==true)?1:0;
        $model->hidung_hasilperiksa=($model->hidung_hasilperiksa==true)?1:0;
        $model->telinga_hasilperiksa=($model->telinga_hasilperiksa==true)?1:0;
        $model->mulut_hasilperiksa=($model->mulut_hasilperiksa==true)?1:0;
        $model->jantung_hasilperiksa=($model->jantung_hasilperiksa==true)?1:0;
        $model->paru_hasilperiksa=($model->paru_hasilperiksa==true)?1:0;
        $model->abdomen_hasilperiksa=($model->abdomen_hasilperiksa==true)?1:0;
        $model->genitalia_hasilperiksa=($model->genitalia_hasilperiksa==true)?1:0;
        $model->extremitasatas_hasilperiksa=($model->extremitasatas_hasilperiksa==true)?1:0;
        $model->extremitasbawah_hasilperiksa=($model->extremitasbawah_hasilperiksa==true)?1:0;
        $model->kulit_hasilperiksa=($model->kulit_hasilperiksa==true)?1:0;
        $model->statusmerokok=($model->statusmerokok==true)?1:0;
        $model->deskripsinyeri_ismenjalar=($model->deskripsinyeri_ismenjalar==true)?1:0;
        $model->deformitas_status=($model->deformitas_status==true)?1:0;
        $model->gangguantidur_status=($model->gangguantidur_status==true)?1:0;
        $model->keb_nutricairan_rasahausberlebih=($model->keb_nutricairan_rasahausberlebih==true)?1:0;
        $model->keb_nutricairan_edemastatus=($model->keb_nutricairan_edemastatus==true)?1:0;
        $model->riwayatjatuh_3bln_terakhir = ($model->riwayatjatuh_3bln_terakhir)?1:0;
        $model->riwayatjatuh_alatbantu = ($model->riwayatjatuh_alatbantu)?1:0;


       if($model->isskrinninggizidewasa){
            $model->skrinninggizi_jwb_penurunanbb_dewasa_text = $model->skrinninggizi_skor_penurunanbb_dewasa;
            $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = $model->skrinninggizi_skor_asupanmakanan_dewasa;

            $model->skrinninggizi_jwb_tampakkurus_text = null;
            $model->skrinninggizi_jwb_penurunanbb_text = null;
            $model->skrinninggizi_jwb_kondisi_text = null;
            $model->skrinninggizi_jwb_penyakit_text = null;
       }else{
            $model->skrinninggizi_jwb_penurunanbb_dewasa_text = null;
            $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = null;

            $model->skrinninggizi_jwb_tampakkurus_text = $model->skrinninggizi_skor_tampakkurus;
            $model->skrinninggizi_jwb_penurunanbb_text = $model->skrinninggizi_skor_penurunanbb;
            $model->skrinninggizi_jwb_kondisi_text = $model->skrinninggizi_skor_kondisi;
            $model->skrinninggizi_jwb_penyakit_text = $model->skrinninggizi_skor_penyakit;
       }

       $model->riwayatjatuh_penilaian_text = $model->riwayatjatuh_penilaian;
       $model->diagnosismedis_penilaian_text = $model->diagnosismedis_skor;
       $model->alatbantujalan_penilaian_text = (($model->alatbantujalan_skor != null) ? $model->alatbantujalan_skor:null);
       $model->memakaiterapiheparin_penilaian_text = $model->memakaiterapiheparin_penilaian;
       $model->caraberjalan_penilaian_text = (($model->caraberjalan_skor != null) ? $model->caraberjalan_skor:null);
       $model->statusmental_penilaian_text = (($model->statusmental_skor != null) ? $model->statusmental_skor:null);
       $model->usia_anak_text = $model->skor_usia_anak;
       $model->jeniskelamin_anak_text = $model->skor_jeniskelamin_anak;
       $model->diagnosa_asessment_anak_text = $model->skor_diagnosa_anak;
       $model->gangguan_kognitif_anak_text = $model->skor_gangguan_kognitif_anak;

       $model->faktor_lingkungan_anak_text = $model->skor_faktor_lingkungan_anak;
       $model->responterhadap_pembedahan_anak_text = $model->skor_responterhadap_pembedahan_anak;
       $model->penggunaan_medikamentosa_text = $model->skor_medikamentosa_anak;

       $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id,'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id, 'ruangan_id' => $ruanganid));
       $diagnosaUtama = "";
       $diagnosaTambahan = "";
       $diagnosa_id = null;

       if (count((array)$pasienMorbid) > 0) {
           $indexKel2 = 0;
           $indexKel3 = 0;

           foreach ($pasienMorbid as $datamorbid) {
               $diagnosa_id = $datamorbid->diagnosa_id;
               if ($datamorbid->kelompokdiagnosa_id == 2) {
                   if ($indexKel2 > 0) {
                       $diagnosaUtama .= ", ";
                   }
                   $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                   $indexKel2++;
               }

               if ($datamorbid->kelompokdiagnosa_id == 3) {
                   if ($indexKel3 > 0) {
                       $diagnosaTambahan .= ", ";
                   }
                   $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                   $indexKel3++;
               }
           }
           $model->diagnosa_utama = "Diagnosa Utama: " . $diagnosaUtama . " \n\n Diagnosa Tambahan: " . $diagnosaTambahan;
       }


       $modAsesmenpasinIgd = AsesmenpasienigdT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id'=>$ruanganid));
       $masalahKeperawatan = "";
       $rencanaKeperawatan = "";
       $tindakanKeperawatan = "";

       if (isset($modAsesmenpasinIgd)) {
           $modAskepMasalah = AsesmenmasalahkepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));

           if (count((array)$modAskepMasalah) > 0) {

               foreach ($modAskepMasalah as $i => $askepMasalah) {
                 if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_PI){
                   if ($i > 0) {
                       $masalahKeperawatan .= "<br/>";
                   }
                   $masalahKeperawatan .= (isset($askepMasalah->masalahkeperawatan) ? "- ".$askepMasalah->masalahkeperawatan->masalahkeperawatan_nama : "");
                 }else{
                   if ($i > 0) {
                       $masalahKeperawatan .= ", ";
                   }
                   $masalahKeperawatan .= (isset($askepMasalah->masalahkeperawatan) ? $askepMasalah->masalahkeperawatan->masalahkeperawatan_nama : "");
                 }
               }
           }

           $modAskepRencana = AsesmenrencanakepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));
           if (count((array)$modAskepRencana) > 0) {

               foreach ($modAskepRencana as $i => $askepRencana) {
                   if ($i > 0) {
                       $rencanaKeperawatan .= "<br />";
                   }

                   $rencanaKeperawatan .= "- " . (isset($askepRencana->rencanakeperawatanigd) ? $askepRencana->rencanakeperawatanigd->rencanakeperawatan_nama : "");
               }
           }

           $modAskepTindakan = AsesmentindakankepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));
           if (count((array)$modAskepTindakan) > 0) {
               foreach ($modAskepTindakan as $i => $askepTindakan) {
                   if ($i > 0) {
                       $tindakanKeperawatan .= "<br />";
                   }

                   $tindakanKeperawatan .= "- " . (isset($askepTindakan->tindakankeperawatan) ? $askepTindakan->tindakankeperawatan->tindakankeperawatan_nama : "");
               }
           }
       }

       if($model->jenisasesmen == 'asesmenri_anak'){
            $target = $this->path_view.'anak/detail/_detailRiwayatRI';
        }else if($model->jenisasesmen == 'asesmenri_dewasa'){
            $target = $this->path_view.'dewasa/_detailRiwayatDewasa';
        }else if($model->jenisasesmen == 'asesmenri_neonatus'){
            $target = $this->path_view.'neonatus/_detailRiwayat';
        }else if($model->jenisasesmen == 'asesmenri_obgyn'){
            $target = $this->path_view.'obgyn/_detailRiwayat';
        }else if($model->jenisasesmen == 'asesmenri_geriatri'){
            $target = $this->path_view.'geriatri/_detailRiwayat';
        }

        $this->render($target,
                array('model'=>$model,
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasienAdmisi'=>$modPasienAdmisi,
                    'modPasien'=>$modPasien,
                    'dataFlaCcs' => $dataFlaCcs,
                    'getFlaCcs' => $getFlaCcs,
                    'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,
                    'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,
                    'masalahKeperawatan' => $masalahKeperawatan,
                    'rencanaKeperawatan' => $rencanaKeperawatan,
                    'tindakanKeperawatan' => $tindakanKeperawatan,
                    'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT,
                    'modBarthelindexadlT'=>$modBarthelindexadlT,
                    'modPeriksaFisikNeonatus'=>$modPeriksaFisikNeonatus,
                    'modAskepgeriatriT'=>$modAskepgeriatriT,
                    'modMinimentalexampasienT'=>$modMinimentalexampasienT,
                    'modMinimentalexampasiendetT'=>$modMinimentalexampasiendetT,
                    'modPenilaianRenPulang'=>$modPenilaianRenPulang,
                    'modRiwayatObstertikpasien'=>$modRiwayatObstertikpasien
        ));
    }

    public function actionPrint($asesmenawalkeperawatan_id) {
        $this->layout = '//layouts/printWindows_baru';

        $model = RIAsesmenawalkeperawatanT::model()->findByPk($asesmenawalkeperawatan_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
        $modPasien = PasienM::model()->findByPk($model->pasien_id);
        $ruanganid = $modPendaftaran->ruangan_id;

        if(isset($modPasienAdmisi) && !empty($modPasienAdmisi)){
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
        $modRiwayatObstertikpasien = array();
        $modMinimentalexampasienT = array();
        $modMinimentalexampasiendetT = array();
        
        if (isset($model)) {
            $modSkrinningnyerianakdetT = SkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

            $modAsesmenkebutuhanEdukasiT = AsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

            if (isset($modAsesmenkebutuhanEdukasiT)) {
                $modAsesmenkebutuhanEdukasidetT = AsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));
            } else {
              $modAsesmenkebutuhanEdukasiT = new AsesmenkebutuhanEdukasiT();
              $modAsesmenkebutuhanEdukasidetT = new AsesmenkebutuhanEdukasidetT();
            }
            $modBarthelindexadlT = BarthelindexadlT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
            if(!isset($modBarthelindexadlT)){
              $modBarthelindexadlT = new BarthelindexadlT();
            }
            $modAskepgeriatriT = AskepgeriatriT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));

            if(!isset($modAskepgeriatriT)){
                $modAskepgeriatriT = new AskepgeriatriT();
                $modPenilaianRenPulang = array();
            }else{
              $modPenilaianRenPulang = PenilaianrencanapulangT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

              $modMinimentalexampasienT = MinimentalexampasienT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

              if(count((array)$modMinimentalexampasienT) > 0){
                $modMinimentalexampasiendetT = array();
                foreach($modMinimentalexampasienT as $dataMiniMentalPasien){
                    $modMinimentalexampasiendetT = MinimentalexampasiendetT::model()->findAllByAttributes(array('minimentalexampasien_id'=>$dataMiniMentalPasien->minimentalexampasien_id));
                }
              }else{
                $modMinimentalexampasienT = array();
                $modMinimentalexampasiendetT = array();
              }
            }
            $modRiwayatObstertikpasien = RiwayatobstetrikpasienT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));
        }else{
          $modAsesmenkebutuhanEdukasiT = new AsesmenkebutuhanEdukasiT();
          $modAsesmenkebutuhanEdukasidetT = new AsesmenkebutuhanEdukasidetT();
          $modBarthelindexadlT = new BarthelindexadlT();
          $modAskepgeriatriT = new AskepgeriatriT();
          $modPenilaianRenPulang = array();
          $modMinimentalexampasienT = array();
          $modMinimentalexampasiendetT = array();

        }

        if (count((array)$modSkrinningnyerianakdetT) > 0) {
            $getFlaCcs = $modSkrinningnyerianakdetT;

            if (count((array)$getFlaCcs) > 0) {
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

        $model->kepala_hasilperiksa=($model->kepala_hasilperiksa==true)?1:0;
        $model->mata_hasilperiksa=($model->mata_hasilperiksa==true)?1:0;
        $model->leher_hasilperiksa=($model->leher_hasilperiksa==true)?1:0;
        $model->hidung_hasilperiksa=($model->hidung_hasilperiksa==true)?1:0;
        $model->telinga_hasilperiksa=($model->telinga_hasilperiksa==true)?1:0;
        $model->mulut_hasilperiksa=($model->mulut_hasilperiksa==true)?1:0;
        $model->jantung_hasilperiksa=($model->jantung_hasilperiksa==true)?1:0;
        $model->paru_hasilperiksa=($model->paru_hasilperiksa==true)?1:0;
        $model->abdomen_hasilperiksa=($model->abdomen_hasilperiksa==true)?1:0;
        $model->genitalia_hasilperiksa=($model->genitalia_hasilperiksa==true)?1:0;
        $model->extremitasatas_hasilperiksa=($model->extremitasatas_hasilperiksa==true)?1:0;
        $model->extremitasbawah_hasilperiksa=($model->extremitasbawah_hasilperiksa==true)?1:0;
        $model->kulit_hasilperiksa=($model->kulit_hasilperiksa==true)?1:0;
        $model->statusmerokok=($model->statusmerokok==true)?1:0;
        $model->deskripsinyeri_ismenjalar=($model->deskripsinyeri_ismenjalar==true)?1:0;
        $model->deformitas_status=($model->deformitas_status==true)?1:0;
        $model->gangguantidur_status=($model->gangguantidur_status==true)?1:0;
        $model->keb_nutricairan_rasahausberlebih=($model->keb_nutricairan_rasahausberlebih==true)?1:0;
        $model->keb_nutricairan_edemastatus=($model->keb_nutricairan_edemastatus==true)?1:0;
        $model->riwayatjatuh_3bln_terakhir = ($model->riwayatjatuh_3bln_terakhir)?1:0;
        $model->riwayatjatuh_alatbantu = ($model->riwayatjatuh_alatbantu)?1:0;


       if($model->isskrinninggizidewasa){
            $model->skrinninggizi_jwb_penurunanbb_dewasa_text = $model->skrinninggizi_skor_penurunanbb_dewasa;
            $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = $model->skrinninggizi_skor_asupanmakanan_dewasa;

            $model->skrinninggizi_jwb_tampakkurus_text = null;
            $model->skrinninggizi_jwb_penurunanbb_text = null;
            $model->skrinninggizi_jwb_kondisi_text = null;
            $model->skrinninggizi_jwb_penyakit_text = null;
       }else{
            $model->skrinninggizi_jwb_penurunanbb_dewasa_text = null;
            $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = null;

            $model->skrinninggizi_jwb_tampakkurus_text = $model->skrinninggizi_skor_tampakkurus;
            $model->skrinninggizi_jwb_penurunanbb_text = $model->skrinninggizi_skor_penurunanbb;
            $model->skrinninggizi_jwb_kondisi_text = $model->skrinninggizi_skor_kondisi;
            $model->skrinninggizi_jwb_penyakit_text = $model->skrinninggizi_skor_penyakit;
       }

       $model->riwayatjatuh_penilaian_text = $model->riwayatjatuh_penilaian;
       $model->diagnosismedis_penilaian_text = $model->diagnosismedis_skor;
       $model->alatbantujalan_penilaian_text = (($model->alatbantujalan_skor != null) ? $model->alatbantujalan_skor:null);
       $model->memakaiterapiheparin_penilaian_text = $model->memakaiterapiheparin_penilaian;
       $model->caraberjalan_penilaian_text = (($model->caraberjalan_skor != null) ? $model->caraberjalan_skor:null);
       $model->statusmental_penilaian_text = (($model->statusmental_skor != null) ? $model->statusmental_skor:null);
       $model->usia_anak_text = $model->skor_usia_anak;
       $model->jeniskelamin_anak_text = $model->skor_jeniskelamin_anak;
       $model->diagnosa_asessment_anak_text = $model->skor_diagnosa_anak;
       $model->gangguan_kognitif_anak_text = $model->skor_gangguan_kognitif_anak;

       $model->faktor_lingkungan_anak_text = $model->skor_faktor_lingkungan_anak;
       $model->responterhadap_pembedahan_anak_text = $model->skor_responterhadap_pembedahan_anak;
       $model->penggunaan_medikamentosa_text = $model->skor_medikamentosa_anak;



       $modAsesmenpasinIgd = AsesmenpasienigdT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id'=>$ruanganid));
       $masalahKeperawatan = "";
       $masalahKeperawatanNeonatus = "";
       $rencanaKeperawatan = "";
       $tindakanKeperawatan = "";

       $arrMasalahKeperawatan = array();
       if (isset($modAsesmenpasinIgd)) {
          $masalah = MasalahkeperawatanM::model()->findAll('masalahkeperawatan_aktif = true order by masalahkeperawatan_grup_order');
          $tindakan = TindakankeperawatanM::model()->findAll('tindakankeperawatan_aktif = true order by tindakankeperawatan_grup_order, tindakankeperawatan_order');
          $rencana = RencanakeperawatanigdM::model()->findAll('rencanakeperawatan_aktif = true order by rencanakeperawatan_grup_order, rencanakeperawatan_order');

          $modAskepMasalah = AsesmenmasalahkepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));
          $modAskepRencana = AsesmenrencanakepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));
          $modAskepTindakan = AsesmentindakankepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));

          if(count((array)$masalah) > 0){
              foreach($masalah as $mslAskep){
                $arrMasalahKeperawatan[$mslAskep->masalahkeperawatan_grup_order] = array(
                    'masalah'=>array(),
                    'tindakan'=>array(),
                    'rencana'=>array(),
                );
                $mslAskep->isCheck = false;
                if (count((array)$modAskepMasalah) > 0) {
                    foreach ($modAskepMasalah as $i => $askepMasalah) {
                      if($mslAskep->masalahkeperawatan_id == $askepMasalah->masalahkeperawatan_id){
                        $mslAskep->isCheck = true;
                      }

                      if($mslAskep->has_input == true){
                        $mslAskep->isCheck = true;
                        $mslAskep->keteranganCheck = $askepMasalah->masalahkeperawatan_ket;
                      }
                    }
                }
                array_push($arrMasalahKeperawatan[$mslAskep->masalahkeperawatan_grup_order]['masalah'], $mslAskep);
              }
          }

          foreach($tindakan as $item) {
            $item->isCheck = false;
            if (count((array)$modAskepTindakan) > 0) {
                foreach ($modAskepTindakan as $i => $askepTindakan) {
                  if($item->tindakankeperawatan_id == $askepTindakan->tindakankeperawatan_id){
                    $item->isCheck = true;
                  }

                  if($item->has_input == true){
                    $item->isCheck = true;
                    $item->keteranganCheck = $askepTindakan->tindakankeperawatan_ket;
                  }
                }
            }
              array_push($arrMasalahKeperawatan[$item->tindakankeperawatan_grup_order]['tindakan'], $item);
          }
          foreach($rencana as $item) {
            $item->isCheck = false;
            if (count((array)$modAskepRencana) > 0) {
                foreach ($modAskepRencana as $i => $askepRencana) {
                  if($item->rencanakeperawatanigd_id == $askepRencana->rencanakeperawatanigd_id){
                    $item->isCheck = true;
                  }

                  if($item->has_input == true){
                    $item->isCheck = true;
                    $item->keteranganCheck = $askepRencana->rencanakeperawatan_ket;
                  }
                }
            }

              array_push($arrMasalahKeperawatan[$item->rencanakeperawatan_grup_order]['rencana'], $item);
          }

           if (count((array)$modAskepMasalah) > 0) {
               foreach ($modAskepMasalah as $i => $askepMasalah) {
                 if ($i > 0) {
                     $masalahKeperawatanNeonatus .= "<br />";
                 }
                 $masalahKeperawatanNeonatus .= "- ".(isset($askepMasalah->masalahkeperawatan) ? $askepMasalah->masalahkeperawatan->masalahkeperawatan_nama : "");

                   if ($i > 0) {
                       $masalahKeperawatan .= ", ";
                   }
                   $masalahKeperawatan .= (isset($askepMasalah->masalahkeperawatan) ? $askepMasalah->masalahkeperawatan->masalahkeperawatan_nama : "");
               }
           }


           if (count((array)$modAskepRencana) > 0) {

               foreach ($modAskepRencana as $i => $askepRencana) {
                   if ($i > 0) {
                       $rencanaKeperawatan .= "<br />";
                   }

                   $rencanaKeperawatan .= "- " . (isset($askepRencana->rencanakeperawatanigd) ? $askepRencana->rencanakeperawatanigd->rencanakeperawatan_nama : "");
               }
           }


           if (count((array)$modAskepTindakan) > 0) {
               foreach ($modAskepTindakan as $i => $askepTindakan) {
                   if ($i > 0) {
                       $tindakanKeperawatan .= "<br />";
                   }

                   $tindakanKeperawatan .= "- " . (isset($askepTindakan->tindakankeperawatan) ? $askepTindakan->tindakankeperawatan->tindakankeperawatan_nama : "");
               }
           }
       }else{
         $modAsesmenpasinIgd = new AsesmenpasienigdT();
       }
       $modAsesmenTriasae = AsesmentriaseT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id'=>$ruanganid));


       if(!isset($modAsesmenTriasae)){
         $modAsesmenTriasae = new AsesmentriaseT();
         $modAsesmenTriasaedet = new AsesmentriasedetT();
       }else{
         $modAsesmenTriasaedet = AsesmentriasedetT::model()->findAllByAttributes(array('asesmentriase_id'=>$modAsesmenTriasae->asesmentriase_id));

         if(count((array)$modAsesmenTriasaedet) <0){
           $modAsesmenTriasaedet = new AsesmentriasedetT();
         }
       }

       $modFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'create_ruangan'=>$ruanganid));

       if(!isset($modFisik)){
         $modFisik = new PemeriksaanfisikT();
       }

       $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruanganid));
       $diagnosaUtama = "";
       $diagnosaTambahan = "";
       $diagnosa_id = null;

       if (count((array)$pasienMorbid) > 0) {
           $indexKel2 = 0;
           $indexKel3 = 0;

           foreach ($pasienMorbid as $datamorbid) {
               $diagnosa_id = $datamorbid->diagnosa_id;
               if ($datamorbid->kelompokdiagnosa_id == 2) {
                   if ($indexKel2 > 0) {
                       $diagnosaUtama .= ", ";
                   }
                   $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                   $indexKel2++;
               }

               if ($datamorbid->kelompokdiagnosa_id == 3) {
                   if ($indexKel3 > 0) {
                       $diagnosaTambahan .= ", ";
                   }
                   $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                   $indexKel3++;
               }
           }
       }
       $model->diagnosa_utama = $diagnosaUtama;
       $model->diagnosa_tambahan = $diagnosaTambahan;

       $obvKompherensif = ObservasiKomprehensifT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan' => $ruanganid));

       if(count((array)$obvKompherensif) < 0){
         $obvKompherensif = array();
       }

       $modPasienPulang = PasienpulangT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id));

       if(!isset($modPasienPulang)){
         $modPasienPulang = new PasienpulangT();
       }

       $target = $this->path_view.'anak/print/printRI';

       if($model->jenisasesmen == 'asesmenri_dewasa'){
        $target = $this->path_view.'dewasa/print/printRI';
       }else if($model->jenisasesmen == 'asesmenri_neonatus'){
         $target = $this->path_view.'PrintAwalAskepNeonatus';
       }else if($model->jenisasesmen == 'asesmenri_obgyn'){
         $target = $this->path_view.'obgyn/print/print';
       }
       else if($model->jenisasesmen == 'asesmenri_geriatri'){
         $target = $this->path_view.'geriatri/print/print';
       }

        $this->render($target,
                array('model'=>$model,
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasienAdmisi'=>$modPasienAdmisi,
                    'modPasien'=>$modPasien,
                    'dataFlaCcs' => $dataFlaCcs,
                    'getFlaCcs' => $getFlaCcs,
                    'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,
                    'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,
                    'masalahKeperawatan' => $masalahKeperawatan,
                    'rencanaKeperawatan' => $rencanaKeperawatan,
                    'tindakanKeperawatan' => $tindakanKeperawatan,
                    'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT,
                    'masalahKeperawatanNeonatus'=>$masalahKeperawatanNeonatus,
                    'modAsesmenTriasae'=>$modAsesmenTriasae,
                    'modAsesmenTriasaedet'=>$modAsesmenTriasaedet,
                    'modFisik'=>$modFisik,
                    'modBarthelindexadlT'=>$modBarthelindexadlT,
                    'arrMasalahKeperawatan'=>$arrMasalahKeperawatan,
                    'modAsesmenpasinIgd'=>$modAsesmenpasinIgd,
                    'obvKompherensif'=>$obvKompherensif,
                    'modPasienPulang'=>$modPasienPulang,
                    'modAskepgeriatriT'=>$modAskepgeriatriT,
                    'modMinimentalexampasienT'=>$modMinimentalexampasienT,
                    'modMinimentalexampasiendetT'=>$modMinimentalexampasiendetT,
                    'modPenilaianRenPulang'=>$modPenilaianRenPulang,
                    'modRiwayatObstertikpasien'=>$modRiwayatObstertikpasien
        ));
    }

    public function actionPrintAskep($asesmenawalkeperawatan_id) {
        $this->layout = '//layouts/printWindows_baru';

        $model = RIAsesmenawalkeperawatanT::model()->findByPk($asesmenawalkeperawatan_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
        $modPasien = PasienM::model()->findByPk($model->pasien_id);
        $ruanganid = $modPendaftaran->ruangan_id;

        if(isset($modPasienAdmisi) && !empty($modPasienAdmisi)){
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
        $modRiwayatObstertikpasien = array();
        $modMinimentalexampasienT = array();
        $modMinimentalexampasiendetT = array();
        
        if (isset($model)) {
            $modSkrinningnyerianakdetT = SkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

            $modAsesmenkebutuhanEdukasiT = AsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));

            if (isset($modAsesmenkebutuhanEdukasiT)) {
                $modAsesmenkebutuhanEdukasidetT = AsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));
            } else {
              $modAsesmenkebutuhanEdukasiT = new AsesmenkebutuhanEdukasiT();
              $modAsesmenkebutuhanEdukasidetT = new AsesmenkebutuhanEdukasidetT();
            }
            $modBarthelindexadlT = BarthelindexadlT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
            if(!isset($modBarthelindexadlT)){
              $modBarthelindexadlT = new BarthelindexadlT();
            }
            $modAskepgeriatriT = AskepgeriatriT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));

            if(!isset($modAskepgeriatriT)){
                $modAskepgeriatriT = new AskepgeriatriT();
                $modPenilaianRenPulang = array();
            }else{
              $modPenilaianRenPulang = PenilaianrencanapulangT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

              $modMinimentalexampasienT = MinimentalexampasienT::model()->findAllByAttributes(array('askepgeriatri_id'=>$modAskepgeriatriT->askepgeriatri_id));

              if(count((array)$modMinimentalexampasienT) > 0){
                $modMinimentalexampasiendetT = array();
                foreach($modMinimentalexampasienT as $dataMiniMentalPasien){
                    $modMinimentalexampasiendetT = MinimentalexampasiendetT::model()->findAllByAttributes(array('minimentalexampasien_id'=>$dataMiniMentalPasien->minimentalexampasien_id));
                }
              }else{
                $modMinimentalexampasienT = array();
                $modMinimentalexampasiendetT = array();
              }
            }
            $modRiwayatObstertikpasien = RiwayatobstetrikpasienT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));
        }else{
          $modAsesmenkebutuhanEdukasiT = new AsesmenkebutuhanEdukasiT();
          $modAsesmenkebutuhanEdukasidetT = new AsesmenkebutuhanEdukasidetT();
          $modBarthelindexadlT = new BarthelindexadlT();
          $modAskepgeriatriT = new AskepgeriatriT();
          $modPenilaianRenPulang = array();
          $modMinimentalexampasienT = array();
          $modMinimentalexampasiendetT = array();

        }

        if (count((array)$modSkrinningnyerianakdetT) > 0) {
            $getFlaCcs = $modSkrinningnyerianakdetT;

            if (count((array)$getFlaCcs) > 0) {
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

        $model->kepala_hasilperiksa=($model->kepala_hasilperiksa==true)?1:0;
        $model->mata_hasilperiksa=($model->mata_hasilperiksa==true)?1:0;
        $model->leher_hasilperiksa=($model->leher_hasilperiksa==true)?1:0;
        $model->hidung_hasilperiksa=($model->hidung_hasilperiksa==true)?1:0;
        $model->telinga_hasilperiksa=($model->telinga_hasilperiksa==true)?1:0;
        $model->mulut_hasilperiksa=($model->mulut_hasilperiksa==true)?1:0;
        $model->jantung_hasilperiksa=($model->jantung_hasilperiksa==true)?1:0;
        $model->paru_hasilperiksa=($model->paru_hasilperiksa==true)?1:0;
        $model->abdomen_hasilperiksa=($model->abdomen_hasilperiksa==true)?1:0;
        $model->genitalia_hasilperiksa=($model->genitalia_hasilperiksa==true)?1:0;
        $model->extremitasatas_hasilperiksa=($model->extremitasatas_hasilperiksa==true)?1:0;
        $model->extremitasbawah_hasilperiksa=($model->extremitasbawah_hasilperiksa==true)?1:0;
        $model->kulit_hasilperiksa=($model->kulit_hasilperiksa==true)?1:0;
        $model->statusmerokok=($model->statusmerokok==true)?1:0;
        $model->deskripsinyeri_ismenjalar=($model->deskripsinyeri_ismenjalar==true)?1:0;
        $model->deformitas_status=($model->deformitas_status==true)?1:0;
        $model->gangguantidur_status=($model->gangguantidur_status==true)?1:0;
        $model->keb_nutricairan_rasahausberlebih=($model->keb_nutricairan_rasahausberlebih==true)?1:0;
        $model->keb_nutricairan_edemastatus=($model->keb_nutricairan_edemastatus==true)?1:0;
        $model->riwayatjatuh_3bln_terakhir = ($model->riwayatjatuh_3bln_terakhir)?1:0;
        $model->riwayatjatuh_alatbantu = ($model->riwayatjatuh_alatbantu)?1:0;


       if($model->isskrinninggizidewasa){
            $model->skrinninggizi_jwb_penurunanbb_dewasa_text = $model->skrinninggizi_skor_penurunanbb_dewasa;
            $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = $model->skrinninggizi_skor_asupanmakanan_dewasa;

            $model->skrinninggizi_jwb_tampakkurus_text = null;
            $model->skrinninggizi_jwb_penurunanbb_text = null;
            $model->skrinninggizi_jwb_kondisi_text = null;
            $model->skrinninggizi_jwb_penyakit_text = null;
       }else{
            $model->skrinninggizi_jwb_penurunanbb_dewasa_text = null;
            $model->skrinninggizi_jwb_asupanmakanan_dewasa_text = null;

            $model->skrinninggizi_jwb_tampakkurus_text = $model->skrinninggizi_skor_tampakkurus;
            $model->skrinninggizi_jwb_penurunanbb_text = $model->skrinninggizi_skor_penurunanbb;
            $model->skrinninggizi_jwb_kondisi_text = $model->skrinninggizi_skor_kondisi;
            $model->skrinninggizi_jwb_penyakit_text = $model->skrinninggizi_skor_penyakit;
       }

       $model->riwayatjatuh_penilaian_text = $model->riwayatjatuh_penilaian;
       $model->diagnosismedis_penilaian_text = $model->diagnosismedis_skor;
       $model->alatbantujalan_penilaian_text = (($model->alatbantujalan_skor != null) ? $model->alatbantujalan_skor:null);
       $model->memakaiterapiheparin_penilaian_text = $model->memakaiterapiheparin_penilaian;
       $model->caraberjalan_penilaian_text = (($model->caraberjalan_skor != null) ? $model->caraberjalan_skor:null);
       $model->statusmental_penilaian_text = (($model->statusmental_skor != null) ? $model->statusmental_skor:null);
       $model->usia_anak_text = $model->skor_usia_anak;
       $model->jeniskelamin_anak_text = $model->skor_jeniskelamin_anak;
       $model->diagnosa_asessment_anak_text = $model->skor_diagnosa_anak;
       $model->gangguan_kognitif_anak_text = $model->skor_gangguan_kognitif_anak;

       $model->faktor_lingkungan_anak_text = $model->skor_faktor_lingkungan_anak;
       $model->responterhadap_pembedahan_anak_text = $model->skor_responterhadap_pembedahan_anak;
       $model->penggunaan_medikamentosa_text = $model->skor_medikamentosa_anak;



       $modAsesmenpasinIgd = AsesmenpasienigdT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id'=>$ruanganid));
       $masalahKeperawatan = "";
       $masalahKeperawatanNeonatus = "";
       $rencanaKeperawatan = "";
       $tindakanKeperawatan = "";

       $arrMasalahKeperawatan = array();
       if (isset($modAsesmenpasinIgd)) {
          $masalah = MasalahkeperawatanM::model()->findAll('masalahkeperawatan_aktif = true order by masalahkeperawatan_grup_order');
          $tindakan = TindakankeperawatanM::model()->findAll('tindakankeperawatan_aktif = true order by tindakankeperawatan_grup_order, tindakankeperawatan_order');
          $rencana = RencanakeperawatanigdM::model()->findAll('rencanakeperawatan_aktif = true order by rencanakeperawatan_grup_order, rencanakeperawatan_order');

          $modAskepMasalah = AsesmenmasalahkepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));
          $modAskepRencana = AsesmenrencanakepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));
          $modAskepTindakan = AsesmentindakankepT::model()->findAllByAttributes(array('asesmenpasienigd_id' => $modAsesmenpasinIgd->asesmenpasienigd_id));

          if(count((array)$masalah) > 0){
              foreach($masalah as $mslAskep){
                $arrMasalahKeperawatan[$mslAskep->masalahkeperawatan_grup_order] = array(
                    'masalah'=>array(),
                    'tindakan'=>array(),
                    'rencana'=>array(),
                );
                $mslAskep->isCheck = false;
                if (count((array)$modAskepMasalah) > 0) {
                    foreach ($modAskepMasalah as $i => $askepMasalah) {
                      if($mslAskep->masalahkeperawatan_id == $askepMasalah->masalahkeperawatan_id){
                        $mslAskep->isCheck = true;
                      }

                      if($mslAskep->has_input == true){
                        $mslAskep->isCheck = true;
                        $mslAskep->keteranganCheck = $askepMasalah->masalahkeperawatan_ket;
                      }
                    }
                }
                array_push($arrMasalahKeperawatan[$mslAskep->masalahkeperawatan_grup_order]['masalah'], $mslAskep);
              }
          }

          foreach($tindakan as $item) {
            $item->isCheck = false;
            if (count((array)$modAskepTindakan) > 0) {
                foreach ($modAskepTindakan as $i => $askepTindakan) {
                  if($item->tindakankeperawatan_id == $askepTindakan->tindakankeperawatan_id){
                    $item->isCheck = true;
                  }

                  if($item->has_input == true){
                    $item->isCheck = true;
                    $item->keteranganCheck = $askepTindakan->tindakankeperawatan_ket;
                  }
                }
            }
              array_push($arrMasalahKeperawatan[$item->tindakankeperawatan_grup_order]['tindakan'], $item);
          }
          foreach($rencana as $item) {
            $item->isCheck = false;
            if (count((array)$modAskepRencana) > 0) {
                foreach ($modAskepRencana as $i => $askepRencana) {
                  if($item->rencanakeperawatanigd_id == $askepRencana->rencanakeperawatanigd_id){
                    $item->isCheck = true;
                  }

                  if($item->has_input == true){
                    $item->isCheck = true;
                    $item->keteranganCheck = $askepRencana->rencanakeperawatan_ket;
                  }
                }
            }

              array_push($arrMasalahKeperawatan[$item->rencanakeperawatan_grup_order]['rencana'], $item);
          }

           if (count((array)$modAskepMasalah) > 0) {
               foreach ($modAskepMasalah as $i => $askepMasalah) {
                 if ($i > 0) {
                     $masalahKeperawatanNeonatus .= "<br />";
                 }
                 $masalahKeperawatanNeonatus .= "- ".(isset($askepMasalah->masalahkeperawatan) ? $askepMasalah->masalahkeperawatan->masalahkeperawatan_nama : "");

                   if ($i > 0) {
                       $masalahKeperawatan .= ", ";
                   }
                   $masalahKeperawatan .= (isset($askepMasalah->masalahkeperawatan) ? $askepMasalah->masalahkeperawatan->masalahkeperawatan_nama : "");
               }
           }


           if (count((array)$modAskepRencana) > 0) {

               foreach ($modAskepRencana as $i => $askepRencana) {
                   if ($i > 0) {
                       $rencanaKeperawatan .= "<br />";
                   }

                   $rencanaKeperawatan .= "- " . (isset($askepRencana->rencanakeperawatanigd) ? $askepRencana->rencanakeperawatanigd->rencanakeperawatan_nama : "");
               }
           }


           if (count((array)$modAskepTindakan) > 0) {
               foreach ($modAskepTindakan as $i => $askepTindakan) {
                   if ($i > 0) {
                       $tindakanKeperawatan .= "<br />";
                   }

                   $tindakanKeperawatan .= "- " . (isset($askepTindakan->tindakankeperawatan) ? $askepTindakan->tindakankeperawatan->tindakankeperawatan_nama : "");
               }
           }
       }else{
         $modAsesmenpasinIgd = new AsesmenpasienigdT();
       }
       $modAsesmenTriasae = AsesmentriaseT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id'=>$ruanganid));


       if(!isset($modAsesmenTriasae)){
         $modAsesmenTriasae = new AsesmentriaseT();
         $modAsesmenTriasaedet = new AsesmentriasedetT();
       }else{
         $modAsesmenTriasaedet = AsesmentriasedetT::model()->findAllByAttributes(array('asesmentriase_id'=>$modAsesmenTriasae->asesmentriase_id));

         if(count((array)$modAsesmenTriasaedet) <0){
           $modAsesmenTriasaedet = new AsesmentriasedetT();
         }
       }

       $modFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'create_ruangan'=>$ruanganid));

       if(!isset($modFisik)){
         $modFisik = new PemeriksaanfisikT();
       }

       $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruanganid));
       $diagnosaUtama = "";
       $diagnosaTambahan = "";
       $diagnosa_id = null;

       if (count((array)$pasienMorbid) > 0) {
           $indexKel2 = 0;
           $indexKel3 = 0;

           foreach ($pasienMorbid as $datamorbid) {
               $diagnosa_id = $datamorbid->diagnosa_id;
               if ($datamorbid->kelompokdiagnosa_id == 2) {
                   if ($indexKel2 > 0) {
                       $diagnosaUtama .= ", ";
                   }
                   $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                   $indexKel2++;
               }

               if ($datamorbid->kelompokdiagnosa_id == 3) {
                   if ($indexKel3 > 0) {
                       $diagnosaTambahan .= ", ";
                   }
                   $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                   $indexKel3++;
               }
           }
       }
       $model->diagnosa_utama = $diagnosaUtama;
       $model->diagnosa_tambahan = $diagnosaTambahan;

       $obvKompherensif = ObservasiKomprehensifT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan' => $ruanganid));

       if(count((array)$obvKompherensif) < 0){
         $obvKompherensif = array();
       }

       $modPasienPulang = PasienpulangT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id));

       if(!isset($modPasienPulang)){
         $modPasienPulang = new PasienpulangT();
       }

    //    var_dump($model->jenisasesmen);die;
       $target = $this->path_view.'PrintNew/anak/print/printRI';

       if($model->jenisasesmen == 'asesmenri_dewasa' || $model->jenisasesmen == 'asesmen_dewasa'){
        $target = $this->path_view.'PrintNew/dewasa/print/printRI';
       }else if($model->jenisasesmen == 'asesmenri_neonatus' || $model->jenisasesmen == 'asesmen_neonatus'){
         $target = $this->path_view.'PrintAwalAskepNeonatus';
       }else if($model->jenisasesmen == 'asesmenri_obgyn' || $model->jenisasesmen == 'asesmen_obgyn'){
         $target = $this->path_view.'PrintNew/obgyn/print/print';
       }
       else if($model->jenisasesmen == 'asesmenri_geriatri'){
         $target = $this->path_view.'PrintNew/geriatri/print/print';
       }

        $this->render($target,
                array('model'=>$model,
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasienAdmisi'=>$modPasienAdmisi,
                    'modPasien'=>$modPasien,
                    'dataFlaCcs' => $dataFlaCcs,
                    'getFlaCcs' => $getFlaCcs,
                    'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,
                    'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,
                    'masalahKeperawatan' => $masalahKeperawatan,
                    'rencanaKeperawatan' => $rencanaKeperawatan,
                    'tindakanKeperawatan' => $tindakanKeperawatan,
                    'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT,
                    'masalahKeperawatanNeonatus'=>$masalahKeperawatanNeonatus,
                    'modAsesmenTriasae'=>$modAsesmenTriasae,
                    'modAsesmenTriasaedet'=>$modAsesmenTriasaedet,
                    'modFisik'=>$modFisik,
                    'modBarthelindexadlT'=>$modBarthelindexadlT,
                    'arrMasalahKeperawatan'=>$arrMasalahKeperawatan,
                    'modAsesmenpasinIgd'=>$modAsesmenpasinIgd,
                    'obvKompherensif'=>$obvKompherensif,
                    'modPasienPulang'=>$modPasienPulang,
                    'modAskepgeriatriT'=>$modAskepgeriatriT,
                    'modMinimentalexampasienT'=>$modMinimentalexampasienT,
                    'modMinimentalexampasiendetT'=>$modMinimentalexampasiendetT,
                    'modPenilaianRenPulang'=>$modPenilaianRenPulang,
                    'modRiwayatObstertikpasien'=>$modRiwayatObstertikpasien
        ));
    }

    public function actionHapusRiwayat(){
        if(Yii::app()->request->isPostRequest)
        {
            $id = $_POST['id'];
            $message = "";
            $sukses = 0;

            $transaction = Yii::app()->db->beginTransaction();
            try {
              $model = RIAsesmenawalkeperawatanT::model()->findByPk($id);
              $deleteData = false;
              $deleteSkrining = true;
              $deleteEdukasi = true;
              $deleteEdukasiDet = true;
              $deleteTumbuhkembang = true;
              $deleteBarthelindex = true;
              $deletePeriksafisikneonatusri = true;

              if(isset($model)){
                $skrining = RISkrinningnyerianakdetT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));

                if(count((array)$skrining) > 0){
                  foreach($skrining as $dataDet){
                    $deleteSkrining = $dataDet->delete();
                  }
                }

                $modAsesmenkebutuhanEdukasiT = AsesmenkebutuhanEdukasiT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
                if(isset($modAsesmenkebutuhanEdukasiT)){
                  $edukasiDet = AsesmenkebutuhanEdukasidetT::model()->findAllByAttributes(array('asesmenkebutuhan_edukasi_id' => $modAsesmenkebutuhanEdukasiT->asesmenkebutuhan_edukasi_id));
                  if(count((array)$edukasiDet) > 0){
                      foreach($edukasiDet as $dataDet){
                        $deleteEdukasiDet = $dataDet->delete();
                      }
                  }
                  $deleteEdukasi = $modAsesmenkebutuhanEdukasiT->delete();
                }
                $tumbuhkembang = AsesmentumbuhkembanganakT::model()->findAllByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));

                if(count((array)$tumbuhkembang) > 0){
                  foreach($tumbuhkembang as $dataDet){
                    $deleteTumbuhkembang = $dataDet->delete();
                  }
                }
                $oriBarthelindexdlt = BarthelindexadlT::model()->findByAttributes(array('asesmenawalkeperawatan_id' => $model->asesmenawalkeperawatan_id));
                if(!empty($oriBarthelindexdlt)){
                    $deleteBarthelindex = $oriBarthelindexdlt->delete();
                }

                $oriPeriksafisikneonatusri = PeriksafisikneonatusriT::model()->findByAttributes(array('asesmenawalkeperawatan_id'=>$model->asesmenawalkeperawatan_id));
                if(!empty($oriPeriksafisikneonatusri)){
                    $deletePeriksafisikneonatusri = $oriPeriksafisikneonatusri->delete();
                }

                $deleteData = RIAsesmenawalkeperawatanT::model()->deleteByPk($model->asesmenawalkeperawatan_id);
              }

              // echo $deleteData .' && '. $deleteSkrining .' && '. $deleteEdukasi .' && '. $deleteEdukasiDet .' && '. $deleteTumbuhkembang .' && '. $deleteBarthelindex .' && '. $deletePeriksafisikneonatusri;
              // exit();
              if($deleteData && $deleteSkrining && $deleteEdukasi && $deleteEdukasiDet && $deleteTumbuhkembang && $deleteBarthelindex && $deletePeriksafisikneonatusri){
                    $transaction->commit();
                    $message = "Data Berhasil Dihapus!";
                    $sukses = 1;
                }else{
                  $transaction->rollback();
                  $message = "Data gagal Dihapus!";
                  $sukses = 0;
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $message = "Data gagal Dihapus! ".MyExceptionMessage::getMessage($exc,true);
                $sukses = 0;
            }

            echo CJSON::encode(array(
                    'sukses'=> $sukses,
                    'msg'=>$message,
                    ));
            exit;
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionHapusMMSEDetail(){
        if(Yii::app()->request->isPostRequest)
        {
            $id = $_POST['id'];
            $message = "";
            $sukses = 0;

            $transaction = Yii::app()->db->beginTransaction();
            try {
              $model = MinimentalexampasiendetT::model()->findByPk($id);
              $deleteData = false;

              if(isset($model)){
                $deleteData = MinimentalexampasiendetT::model()->deleteByPk($model->minimentalexampasiendet_id);
              }

              if($deleteData){
                    $transaction->commit();
                    $message = "Data Berhasil Dihapus!";
                    $sukses = 1;
                }else{
                  $transaction->rollback();
                  $message = "Data gagal Dihapus!";
                  $sukses = 0;
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $message = "Data gagal Dihapus! ".MyExceptionMessage::getMessage($exc,true);
                $sukses = 0;
            }

            echo CJSON::encode(array(
                    'sukses'=> $sukses,
                    'msg'=>$message,
                    ));
            exit;
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
}
