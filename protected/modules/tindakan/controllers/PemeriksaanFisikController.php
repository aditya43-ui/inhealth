<?php

class PemeriksaanFisikController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    protected $path_view = 'rawatJalan.views.pemeriksaanFisik.';
    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $simpanpemeriksaanfisik = false;
    public $simpanpemeriksaangambar = true;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionIndex($pendaftaran_id = null, $id = null, $jnstransaksi = null, $is_triage = null, $notriage_pasien_id = null, $pasienmasukpenunjang_id = null) {
        $format = new MyFormatter();
        $modBagianTubuh = new RJBagiantubuhM();
        $modGambarTubuh = new RJGambartubuhM();
        $modRJMetodeGSCM = RJMetodeGCSM::model()->findAll('metodegcs_aktif=TRUE ORDER BY metodegcs_id');
        $modPemeriksaanGambar = array(); //RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modGambar = RJGambartubuhM::model()->find(array("condition" => "poliklinik_id = " . Yii::app()->user->getState('ruangan_id'), "order" => "gambartubuh_id"));

        $modPendaftaran = null;
        $modPasien = null;
        
        // Asesmen Nyeri (Fisioterapi)
        $modFlaCcs = new AsesmennyeriflaccsT;
        $dataFlaCcs = array();
        $getFlaCcs = null;
        $cekFlaCcs = array();

        $criFla = new CDbCriteria();
        $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
        $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
        $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
        $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);

        foreach ($modNyeriFlaCcs as $dtF) {
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
                'id' => $dtF->skalanyeriflaccs_id,
                'keterangan' => $dtF->skalanyeriflaccs_desc,
                'value' => isset($cekFlaCcs["$dtF->skalanyeriflaccs_id"]) ? $cekFlaCcs["$dtF->skalanyeriflaccs_id"] : null,
            );
        }

        $cekPemeriksaanFisik = null;
        $tabelPemeriksaan = null;
        $tabelPemeriksaanPasien = null;
        $konsul = null;
        $modIntegumen = new IntegumenT();
        $modPemeriksaanFisik = new RJPemeriksaanFisikT;
        $modPemeriksaanFisik->conjuctiva = 'Normal';
        $modTriagePasien = null;

        if(!empty($pendaftaran_id)) {

            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

            $modPpds = PpdsM::model()->findByPk($modPendaftaran->ppds_id);
            $cekPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            $tabelPemeriksaan = RJPemeriksaanFisikT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'create_time DESC'));
            if(!empty($cekPemeriksaanFisik)) {
                $tabelPemeriksaanPasien = RJPemeriksaanFisikT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'create_time DESC'));
            } else {
                $tabelPemeriksaanPasien = null;
            }

            $modPemeriksaanFisik->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modPemeriksaanFisik->pasien_id = $modPasien->pasien_id;

            if(!empty($pasienmasukpenunjang_id)) {
                $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
                if(!empty($modPenunjang)) {
                    $modPemeriksaanFisik->pegawai_id = $modPenunjang->pegawai_id;

                }
               
            } else {
                $modPemeriksaanFisik->pegawai_id = $modPendaftaran->pegawai_id;
            }
     
            $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
                'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
                'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                    ), array(
                'order' => 'tglkonsulpoli desc',
            ));
        }
            if (!empty($modGambar)) {
                if (!empty($modGambar->jeniskelamin)) {
                    $modGambar = RJGambartubuhM::model()->findByAttributes(array(
                        'jeniskelamin' => $modPasien->jeniskelamin
                    ));
                }
                $gambartubuh_id = $modGambar->gambartubuh_id;
                $nama_file_gbr = $modGambar->nama_file_gbr;
            } else if (empty($modGambar)) {
                $gambartubuh_id = 0;
                $nama_file_gbr = '';
            }
           
            $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $modPemeriksaanFisik->paramedis_nama = empty($pegawai) ? null : $pegawai->nama_pegawai;

            $modPemeriksaanFisik->tglperiksafisik = date('Y-m-d H:i:s');
            $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
            $modPemeriksaanFisik->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->id;
            $modPemeriksaanFisik->gambartubuh_id = $gambartubuh_id;
            $modPemeriksaanFisik->temp_file = $nama_file_gbr;
    
            if (!empty($konsul)) {
                $modPendaftaran->pegawai_id = $konsul->pegawai_id;
                $modPendaftaran->ruangan_id = $konsul->ruangan_id;
                $modPemeriksaanFisik->pegawai_id = $konsul->pegawai_id;
            }
    
            if (!empty($id)) {
                $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByPk($id);
                $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAll("pemeriksaanfisik_id = $id");
                if (empty($modPemeriksaanGambar)) {
                    $modPemeriksaanGambar = array();
                } else {
                    $modGambarTubuh = RJGambartubuhM::model()->findByPk($modPemeriksaanGambar[0]->gambartubuh_id);
                    $modPemeriksaanFisik->gambartubuh_id = $modGambarTubuh->gambartubuh_id;
                }
            }else{
                //leher
                $modPemeriksaanFisik->leher_reflekpupil = 1;
                $modPemeriksaanFisik->leher_kelgetahbening_teraba = 0;
                $modPemeriksaanFisik->leher_kelenjartiroid_teraba = 0;
                $modPemeriksaanFisik->leher_jvp = 0;
                
                $modPemeriksaanFisik->ppds_id =$modPendaftaran->ppds_id ?? "";
                //ttv
                $modPemeriksaanFisik->denyutjantung = 'REGULER';
                
                //gcs
                $modPemeriksaanFisik->gcs_eye = ParamsConst::DEFAULT_PERIKSAFISIK_GCS_EYE;
                $modPemeriksaanFisik->gcs_verbal = ParamsConst::DEFAULT_PERIKSAFISIK_GCS_VERBAL;
                $modPemeriksaanFisik->gcs_motorik = ParamsConst::DEFAULT_PERIKSAFISIK_GCS_MOTORIK;
                $modPemeriksaanFisik->gcs_eye = 4;
                
                //thorax
                $modPemeriksaanFisik->au_parurhkanan_1 = $modPemeriksaanFisik->au_parurhkanan_2 = $modPemeriksaanFisik->au_parurhkanan_3 = '-';
                $modPemeriksaanFisik->au_parurhkiri_1 = $modPemeriksaanFisik->au_parurhkiri_2 = $modPemeriksaanFisik->au_parurhkiri_3 = '-';
                
                $modPemeriksaanFisik->au_paruwhkanan_1 = $modPemeriksaanFisik->au_paruwhkanan_2 = $modPemeriksaanFisik->au_paruwhkanan_3 = '-';
                $modPemeriksaanFisik->au_paruwhkiri_1 = $modPemeriksaanFisik->au_paruwhkiri_2 = $modPemeriksaanFisik->au_paruwhkiri_3 = '-';
                
                $modPemeriksaanFisik->au_cardios1 = $modPemeriksaanFisik->au_cardios2 = 'Reguler';
            }


        if(isset($is_triage)) {
            $this->layout= '//layouts/mainNeonSidebar';
            $modTriagePasien = NotriagePasienT::model()->findByPk($notriage_pasien_id);
            $modPemeriksaanFisik->nomor_triage = $modTriagePasien->no_bed_triage . " - " . $modTriagePasien->no_triage_pasien;
        }
        
            $modPemeriksaanFisik->pemeriksaanfisiksebelum_id = $id;
            $modPemeriksaanFisik->jnstransaksi = $jnstransaksi;
            
            // if(!empty($pendaftaran_id)) {
            // $fisikakhir = RJPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')), array('order' => 'create_time DESC'));
            // if (!empty($fisikakhir)){
            //     $modPemeriksaanFisik->td_systolic = $fisikakhir->td_systolic;
            //     $modPemeriksaanFisik->td_diastolic = $fisikakhir->td_diastolic;
            //     $modPemeriksaanFisik->tekanandarah = $fisikakhir->tekanandarah;
            //     $modPemeriksaanFisik->meanarteripressure = $fisikakhir->meanarteripressure;
            //     $modPemeriksaanFisik->detaknadi = $fisikakhir->detaknadi;
            //     $modPemeriksaanFisik->denyutjantung = $fisikakhir->denyutjantung;
            //     $modPemeriksaanFisik->pernapasan = $fisikakhir->pernapasan;            
            //     $modPemeriksaanFisik->suhutubuh = $fisikakhir->suhutubuh;
            //     $modPemeriksaanFisik->tinggibadan_cm = $fisikakhir->tinggibadan_cm;
            //     $modPemeriksaanFisik->beratbadan_kg = $fisikakhir->beratbadan_kg;
            //     $modPemeriksaanFisik->bb_ideal = $fisikakhir->bb_ideal;
            //     $modPemeriksaanFisik->tandavital_reflekcahaya = $fisikakhir->tandavital_reflekcahaya;
            //     $modPemeriksaanFisik->tandavital_spo2 = $fisikakhir->tandavital_spo2;           
            // }
        // }

        if(isset($id)) {
            $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByPk($id);
            // $modPemeriksaanFisik->tekanandarah = 'testing testing';
            // var_dump('tes'); die;
        }
        $modPemeriksaanFisik->jnstransaksi = $jnstransaksi;

        if (isset($_POST['RJPemeriksaanFisikT'])) {
            // var_dump($_POST); die;

            $transaction = Yii::app()->db->beginTransaction();
            try {

                $modPemeriksaanFisik->attributes = $_POST['RJPemeriksaanFisikT'];
                $modPemeriksaanFisik->conjuctiva = isset($_POST['RJPemeriksaanFisikT']['conjuctiva']) ? $_POST['RJPemeriksaanFisikT']['conjuctiva'] : '';
                $modPemeriksaanFisik->keadaanumum = isset($_POST['RJPemeriksaanFisikT']['keadaanumum']) ? $_POST['RJPemeriksaanFisikT']['keadaanumum'] : "";
                $modPemeriksaanFisik->tglperiksafisik = $format->formatDateTimeForDb($_POST['RJPemeriksaanFisikT']['tglperiksafisik']);
                $modPemeriksaanFisik->denyutjantung = isset($_POST['RJPemeriksaanFisikT']['denyutjantung']) ? $_POST['RJPemeriksaanFisikT']['denyutjantung'] : "";
                
                $modPemeriksaanFisik->leher_kelgetahbening_teraba = isset($_POST['RJPemeriksaanFisikT']['leher_kelgetahbening_teraba']) ? $_POST['RJPemeriksaanFisikT']['leher_kelgetahbening_teraba'] : "";
                $modPemeriksaanFisik->leher_reflekpupil = isset($_POST['RJPemeriksaanFisikT']['leher_reflekpupil']) ? $_POST['RJPemeriksaanFisikT']['leher_reflekpupil'] : "";
                $modPemeriksaanFisik->leher_kelenjartiroid_teraba = isset($_POST['RJPemeriksaanFisikT']['leher_kelenjartiroid_teraba']) ? $_POST['RJPemeriksaanFisikT']['leher_kelenjartiroid_teraba'] : "";
                $modPemeriksaanFisik->leher_jvp = isset($_POST['RJPemeriksaanFisikT']['leher_jvp']) ? $_POST['RJPemeriksaanFisikT']['leher_jvp'] : "";
                $modPemeriksaanFisik->leher_mata =  isset($_POST['RJPemeriksaanFisikT']['leher_mata']) ? $_POST['RJPemeriksaanFisikT']['leher_mata'] : "";
                $modPemeriksaanFisik->leher_telinga =  isset($_POST['RJPemeriksaanFisikT']['leher_telinga']) ? $_POST['RJPemeriksaanFisikT']['leher_telinga'] : "";
                $modPemeriksaanFisik->ppds_id = isset($_POST['RJPemeriksaanFisikT']['ppds_id']) ? $_POST['RJPemeriksaanFisikT']['ppds_id'] : "";
     
                $modPemeriksaanFisik->jn_paten = isset($_POST['RJPemeriksaanFisikT']['jn_paten']) ? true : false; 
                $modPemeriksaanFisik->jn_obstruktifpartial = isset($_POST['RJPemeriksaanFisikT']['jn_obstruktifpartial']) ? true : false; 
                $modPemeriksaanFisik->jn_obstruktifnormal = isset($_POST['RJPemeriksaanFisikT']['jn_obstruktifnormal']) ? true : false; 
                $modPemeriksaanFisik->jn_stridor = isset($_POST['RJPemeriksaanFisikT']['jn_stridor']) ? true : false; 
                $modPemeriksaanFisik->jn_gargling = isset($_POST['RJPemeriksaanFisikT']['jn_gargling']) ? true : false; 
                $modPemeriksaanFisik->pgp_normal = isset($_POST['RJPemeriksaanFisikT']['pgp_normal']) ? true : false; 
                $modPemeriksaanFisik->pgp_kussmaul = isset($_POST['RJPemeriksaanFisikT']['pgp_kussmaul']) ? true : false; 
                $modPemeriksaanFisik->pgp_takipnea =  isset($_POST['RJPemeriksaanFisikT']['pgp_takipnea']) ? true : false; 
                $modPemeriksaanFisik->pgp_retraktif = isset($_POST['RJPemeriksaanFisikT']['pgp_retraktif']) ? true : false; 
                $modPemeriksaanFisik->pgp_dangkal = isset($_POST['RJPemeriksaanFisikT']['pgp_dangkal']) ? true : false; 
                $modPemeriksaanFisik->pgd_simetri = isset($_POST['RJPemeriksaanFisikT']['pgd_simetri']) ? true : false; 
                $modPemeriksaanFisik->pgd_asimetri = isset($_POST['RJPemeriksaanFisikT']['pgd_asimetri']) ? true : false; 
                $modPemeriksaanFisik->sirkulasi_nadicarotis = isset($_POST['RJPemeriksaanFisikT']['sirkulasi_nadicarotis']) ? $_POST['RJPemeriksaanFisikT']['sirkulasi_nadicarotis'] : 0; 
                $modPemeriksaanFisik->sirkulasi_nadiradialis = isset($_POST['RJPemeriksaanFisikT']['sirkulasi_nadiradialis']) ? $_POST['RJPemeriksaanFisikT']['sirkulasi_nadiradialis'] : 0; 
                $modPemeriksaanFisik->cfr_kecil_2 = isset($_POST['RJPemeriksaanFisikT']['cfr_kecil_2']) ? true : false; 
                $modPemeriksaanFisik->cfr_besar_2 = isset($_POST['RJPemeriksaanFisikT']['cfr_besar_2']) ? true : false; 
                $modPemeriksaanFisik->kulit_normal = isset($_POST['RJPemeriksaanFisikT']['kulit_normal']) ? true : false; 
                $modPemeriksaanFisik->kulit_jaundice = isset($_POST['RJPemeriksaanFisikT']['kulit_jaundice']) ? true : false; 
                $modPemeriksaanFisik->kulit_cyanosis = isset($_POST['RJPemeriksaanFisikT']['kulit_cyanosis']) ? true : false; 
                $modPemeriksaanFisik->kulit_pucat = isset($_POST['RJPemeriksaanFisikT']['kulit_pucat']) ? true : false; 
                $modPemeriksaanFisik->kulit_berkeringat = isset($_POST['RJPemeriksaanFisikT']['kulit_berkeringat']) ? true : false; 
                $modPemeriksaanFisik->akral = isset($_POST['RJPemeriksaanFisikT']['akral']) ? $_POST['RJPemeriksaanFisikT']['akral'] : ""; 
                $modPemeriksaanFisik->is_masalahperkawinan_cerai = isset($_POST['RJPemeriksaanFisikT']['is_masalahperkawinan_cerai']) ? true : false;
                $modPemeriksaanFisik->is_masalahperkawinan_simpanan = isset($_POST['RJPemeriksaanFisikT']['is_masalahperkawinan_simpanan']) ? true : false;
                $modPemeriksaanFisik->is_masalahperkawinan_istribaru = isset($_POST['RJPemeriksaanFisikT']['is_masalahperkawinan_istribaru']) ? true : false;
                $modPemeriksaanFisik->is_masalahperkawinan_lainlain = isset($_POST['RJPemeriksaanFisikT']['is_masalahperkawinan_lainlain']) ? true : false;
                $modPemeriksaanFisik->suhutubuh = isset($_POST['RJPemeriksaanFisikT']['suhutubuh']) ? str_replace(',', '.', $_POST['RJPemeriksaanFisikT']['suhutubuh']) : null;

                $modPemeriksaanFisik->gcs_kesadaran = isset($_POST['RJPemeriksaanFisikT']['gcs_kesadaran']) ? $_POST['RJPemeriksaanFisikT']['gcs_kesadaran'] : null;


                if (!empty($modPemeriksaanFisik->tl_homecare_tgl)) {
                    $modPemeriksaanFisik->tl_homecare_tgl = MyFormatter::formatDateTimeForDb($modPemeriksaanFisik->tl_homecare_tgl);
                } else {
                    $modPemeriksaanFisik->tl_homecare_tgl = null;
                }

                // sensibilitas
                if (
                        !empty($modPemeriksaanFisik->sensibilitas_panasdingin) || !empty($modPemeriksaanFisik->sensibilitas_tajamtumpul) || !empty($modPemeriksaanFisik->sensibilitas_kasarhalus) || !empty($modPemeriksaanFisik->sensibilitas_titik)
                ) {
                    $modPemeriksaanFisik->ada_sensibilitas = true;

                    $modPemeriksaanFisik->sensibilitas_panasdingin = implode(":", $modPemeriksaanFisik->sensibilitas_panasdingin);
                    $modPemeriksaanFisik->sensibilitas_tajamtumpul = implode(":", $modPemeriksaanFisik->sensibilitas_tajamtumpul);
                    $modPemeriksaanFisik->sensibilitas_kasarhalus = implode(":", $modPemeriksaanFisik->sensibilitas_kasarhalus);
                    $modPemeriksaanFisik->sensibilitas_titik = implode(":", $modPemeriksaanFisik->sensibilitas_titik);
                }

                $modPemeriksaanFisik->mews_suhu = str_replace(",", ".", $modPemeriksaanFisik->mews_suhu);
                $modPemeriksaanFisik->ews_suhu = str_replace(",", ".", $modPemeriksaanFisik->ews_suhu);

                if (!empty($modPemeriksaanFisik->mews_totalkriteria)) {
                    $modPemeriksaanFisik->mews_totalkriteria = implode(".", $modPemeriksaanFisik->mews_totalkriteria);
                }


                if ($modPemeriksaanFisik->validate()) {
                    if ($modPemeriksaanFisik->jnstransaksi == 'salin') {
                        unset($modPemeriksaanFisik->pemeriksaanfisik_id);
                        $modPemeriksaanFisik->IsNewRecord = true;
                        $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    }


                if(isset($notriage_pasien_id)) {
                    $modPemeriksaanFisik->notriage_pasien_id = $notriage_pasien_id;
                }

                    // var_dump($this->simpanpemeriksaanfisik, $modPemeriksaanFisik->save()); die;

                    if ($modPemeriksaanFisik->save()) {

                        if(isset($pendaftaran_id)) {

                            $p = PendaftaranT::model()->findByPk($pendaftaran_id);
                        $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
                        $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');

                        if (empty($p->waktumulaiperiksa)) {
                            PendaftaranT::model()->updateByPk($p->pendaftaran_id, array('waktumulaiperiksa' => date('Y-m-d H:i:s')));
                        }

                        $st = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')));
                        if (!empty($st)) {
                            $pasienpenunjang = PasienmasukpenunjangT::model()->updateByPk($st->pasienmasukpenunjang_id, array(
                                'statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA
                            ));
                            // echo '<pre>'; var_dump('st1', $st->pasienmasukpenunjang_id, $a->statusperiksa);die;
                        }

                        $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
                        if (!empty($konsulPoli)) {
                            $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
                        }
                        $this->simpanpemeriksaanfisik = true;
                        $this->simpanDiagnosaKerja($modPemeriksaanFisik, $_POST['RJPemeriksaanFisikT']);
                        if (isset($_POST['IntegumenT'])) {
                            $this->simpanIntegumen($modPemeriksaanFisik, $_POST['IntegumenT']);
                        }

                        }

                        $this->simpanpemeriksaanfisik = true;
                        
                    }
                }
                if (isset($_POST['RJPemeriksaangambarT'])) {
                    if (count((array) $_POST['RJPemeriksaangambarT']) > 0) {
                        foreach ($_POST['RJPemeriksaangambarT'] as $i => $postperiksagbr) {
                            $this->simpanpemeriksaangambar &= $this->simpanPemeriksaanGambar($postperiksagbr, $modPemeriksaanFisik, $modGambarTubuh);
                        }
                    }
                }

                $ok = true;
                if (isset($_POST['AsesmennyeriflaccsT']['flaccs'])) {
                    foreach ($_POST['AsesmennyeriflaccsT']['flaccs'] as $ii => $val) {
                        $modFlaCcs->attributes = $_POST['AsesmennyeriflaccsT']['flaccs'][$ii];
                        if ($modPemeriksaanFisik->jnstransaksi != 'salin') {
                            $cek = AsesmennyeriflaccsT::model()->findByAttributes(array('pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id, 'skalanyeriflaccs_id' => $modFlaCcs->skalanyeriflaccs_id));
                        } else {
                            $cek = AsesmennyeriflaccsT::model()->findByAttributes(array('pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisiksebelum_id, 'skalanyeriflaccs_id' => $modFlaCcs->skalanyeriflaccs_id));
                        }
                        if (empty($cek)) {
                            $modFlaCcs = new AsesmennyeriflaccsT;
                            $modFlaCcs->attributes = $_POST['AsesmennyeriflaccsT']['flaccs'][$ii];
                            $modFlaCcs->pemeriksaanfisik_id = $modPemeriksaanFisik->pemeriksaanfisik_id;
                            $ok = $ok && $modFlaCcs->save();
                        } else {
                            if ($modPemeriksaanFisik->jnstransaksi != 'salin') {
                                if (!empty($cekFlaCcs)) {
                                    unset($cekFlaCcs[$modFlaCcs->skalanyeriflaccs_id]);
                                }
                            } else {
                                unset($cek->pemeriksaanfisik_id);
                                $cek->IsNewRecord = true;
                                $cek->save();
                            }
                        }
                    }
                    $delFlaCcs = $cekFlaCcs;
                    if (!empty($delFlaCcs)) {
                        $delete = array();
                        foreach ($delFlaCcs as $d) {
                            $delete[] = $d;
                        }
                        $cri = new CDbCriteria();
                        $cri->addCondition("pemeriksaanfisik_id = '" . $modPemeriksaanFisik->pemeriksaanfisik_id . "' ");
                        $cri->addInCondition('skalanyeriflaccs_id', $delete);
                        $up = AsesmennyeriflaccsT::model()->deleteAll($cri);
                    }
                } else {
                    $delFlaCcs = $cekFlaCcs;

                    if (!empty($delFlaCcs)) {
                        $delete = array();
                        foreach ($delFlaCcs as $d) {
                            $delete[] = $d;
                        }

                        $cri = new CDbCriteria();
                        $cri->addCondition("pemeriksaanfisik_id = '" . $modPemeriksaanFisik->pemeriksaanfisik_id . "' ");
                        $cri->addInCondition('skalanyeriflaccs_id', $delete);
                        $up = AsesmennyeriflaccsT::model()->deleteAll($cri);
                    }
                }

                // echo '<pre>'; var_dump($this->simpanpemeriksaanfisik, $this->simpanpemeriksaangambar, $ok); die;

                if ($this->simpanpemeriksaanfisik && $this->simpanpemeriksaangambar && $ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Pemeriksaan Fisik berhasil disimpan");
                
                    if(isset($pendaftaran_id)) {
                        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'id' => $modPemeriksaanFisik->pemeriksaanfisik_id));
                    } else {
                        $this->redirect(array('index', 'is_triage' => $is_triage, 'notriage_pasien_id' => $notriage_pasien_id, 'id' => $modPemeriksaanFisik->pemeriksaanfisik_id, 'tipe' => 'sukses', 'sukses' => 1));
                    }
                } else {
                    //die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
                    //$this->redirect($_POST['url']); 
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Pemeriksaan Fisik gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                echo '<pre>';var_dump($exc);die;
            }
        }


        $modPemeriksaanFisik->tglperiksafisik = Yii::app()->dateFormatter->formatDateTime(
                CDateTimeParser::parse($modPemeriksaanFisik->tglperiksafisik, 'yyyy-MM-dd hh:mm:ss')
        );

        if (empty(Params::getModulRDRI(Yii::app()->user->getState('modul_id')))) {
            $this->render($this->path_view . 'index', array(
                'modPasien' => $modPasien,
                'modPemeriksaanFisik' => $modPemeriksaanFisik,
                'modPendaftaran' => $modPendaftaran,
                'modRJMetodeGSCM' => $modRJMetodeGSCM,
                'modBagianTubuh' => $modBagianTubuh,
                'modGambarTubuh' => $modGambarTubuh,
                'modPemeriksaanGambar' => $modPemeriksaanGambar,
                'tabelPemeriksaan' => $tabelPemeriksaan,
                'tabelPemeriksaanPasien' => $tabelPemeriksaanPasien,
                'modFlaCcs' => $modFlaCcs,
                'dataFlaCcs' => $dataFlaCcs,
                'getFlaCcs' => $getFlaCcs,
                'modIntegumen' => $modIntegumen,
            ));
        } else if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RI) {
            $this->render($this->path_view . 'indexInap', array(
                'modPasien' => $modPasien,
                'modPemeriksaanFisik' => $modPemeriksaanFisik,
                'modPendaftaran' => $modPendaftaran,
                'modRJMetodeGSCM' => $modRJMetodeGSCM,
                'modBagianTubuh' => $modBagianTubuh,
                'modGambarTubuh' => $modGambarTubuh,
                'modPemeriksaanGambar' => $modPemeriksaanGambar,
                'tabelPemeriksaan' => $tabelPemeriksaan,
                'tabelPemeriksaanPasien' => $tabelPemeriksaanPasien,
                'modIntegumen' => $modIntegumen,
            ));
        } else {
            $this->render($this->path_view . 'indexDarurat', array(
                'modPasien' => $modPasien,
                'modPemeriksaanFisik' => $modPemeriksaanFisik,
                'modPendaftaran' => $modPendaftaran,
                'modRJMetodeGSCM' => $modRJMetodeGSCM,
                'modBagianTubuh' => $modBagianTubuh,
                'modGambarTubuh' => $modGambarTubuh,
                'modPemeriksaanGambar' => $modPemeriksaanGambar,
                'tabelPemeriksaan' => $tabelPemeriksaan,
                'tabelPemeriksaanPasien' => $tabelPemeriksaanPasien,
                'modIntegumen' => $modIntegumen,
            ));
        }
    }



    public function actionIndex2($jnstransaksi = null, $is_triage = null) {
        $format = new MyFormatter();

        $notriage_pasien_id = $_GET['notriage_pasien_id'];
        $pemeriksaanfisik_id = $_GET['pemeriksaanfisik_id'];

        $modBagianTubuh = new RJBagiantubuhM();
        $modGambarTubuh = new RJGambartubuhM();
        $modRJMetodeGSCM = RJMetodeGCSM::model()->findAll('metodegcs_aktif=TRUE ORDER BY metodegcs_id');
        $modPemeriksaanGambar = array(); //RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modGambar = RJGambartubuhM::model()->find(array("condition" => "poliklinik_id = " . Yii::app()->user->getState('ruangan_id'), "order" => "gambartubuh_id"));

        $modPendaftaran = null;
        $modPasien = null;
        
        // Asesmen Nyeri (Fisioterapi)
        $modFlaCcs = new AsesmennyeriflaccsT;
        $dataFlaCcs = array();
        $getFlaCcs = null;
        $cekFlaCcs = array();

        $criFla = new CDbCriteria();
        $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
        $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
        $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
        $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);

        foreach ($modNyeriFlaCcs as $dtF) {
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
                'id' => $dtF->skalanyeriflaccs_id,
                'keterangan' => $dtF->skalanyeriflaccs_desc,
                'value' => isset($cekFlaCcs["$dtF->skalanyeriflaccs_id"]) ? $cekFlaCcs["$dtF->skalanyeriflaccs_id"] : null,
            );
        }

        $cekPemeriksaanFisik = null;
        $tabelPemeriksaan = null;
        $tabelPemeriksaanPasien = null;
        $konsul = null;
        $modIntegumen = new IntegumenT();
        $modPemeriksaanFisik = new RJPemeriksaanFisikT;
        $modPemeriksaanFisik->conjuctiva = 'Normal';
        $modTriagePasien = null;

        if(!empty($pendaftaran_id)) {

            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

            $modPpds = PpdsM::model()->findByPk($modPendaftaran->ppds_id);
            $cekPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByPk(array('pendaftaran_id' => $pendaftaran_id));
            $tabelPemeriksaan = RJPemeriksaanFisikT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'create_time DESC'));
            if(!empty($cekPemeriksaanFisik)) {
                $tabelPemeriksaanPasien = RJPemeriksaanFisikT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'create_time DESC'));
            } else {
                $tabelPemeriksaanPasien = null;
            }

            $modPemeriksaanFisik->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modPemeriksaanFisik->pasien_id = $modPasien->pasien_id;
            $modPemeriksaanFisik->pegawai_id = $modPendaftaran->pegawai_id;
     
            $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
                'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
                'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                    ), array(
                'order' => 'tglkonsulpoli desc',
            ));
        }
            if (!empty($modGambar)) {
                if (!empty($modGambar->jeniskelamin)) {
                    $modGambar = RJGambartubuhM::model()->findByAttributes(array(
                        'jeniskelamin' => $modPasien->jeniskelamin
                    ));
                }
                $gambartubuh_id = $modGambar->gambartubuh_id;
                $nama_file_gbr = $modGambar->nama_file_gbr;
            } else if (empty($modGambar)) {
                $gambartubuh_id = 0;
                $nama_file_gbr = '';
            }
           
            $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $modPemeriksaanFisik->paramedis_nama = empty($pegawai) ? null : $pegawai->nama_pegawai;

            $modPemeriksaanFisik->tglperiksafisik = date('Y-m-d H:i:s');
            $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
            $modPemeriksaanFisik->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->id;
            $modPemeriksaanFisik->gambartubuh_id = $gambartubuh_id;
            $modPemeriksaanFisik->temp_file = $nama_file_gbr;
    
            if (!empty($konsul)) {
                $modPendaftaran->pegawai_id = $konsul->pegawai_id;
                $modPendaftaran->ruangan_id = $konsul->ruangan_id;
                $modPemeriksaanFisik->pegawai_id = $konsul->pegawai_id;
            }
    
            if (!empty($pemeriksaanfisik_id)) {
                $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByPk($pemeriksaanfisik_id);
                $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAll("pemeriksaanfisik_id = $pemeriksaanfisik_id");
                if (empty($modPemeriksaanGambar)) {
                    $modPemeriksaanGambar = array();
                } else {
                    $modGambarTubuh = RJGambartubuhM::model()->findByPk($modPemeriksaanGambar[0]->gambartubuh_id);
                    $modPemeriksaanFisik->gambartubuh_id = $modGambarTubuh->gambartubuh_id;
                }
            }else{
                //leher
                $modPemeriksaanFisik->leher_reflekpupil = 1;
                $modPemeriksaanFisik->leher_kelgetahbening_teraba = 0;
                $modPemeriksaanFisik->leher_kelenjartiroid_teraba = 0;
                $modPemeriksaanFisik->leher_jvp = 0;
                
                $modPemeriksaanFisik->ppds_id =$modPendaftaran->ppds_id ?? "";
                //ttv
                $modPemeriksaanFisik->denyutjantung = 'REGULER';
                
                //gcs
                $modPemeriksaanFisik->gcs_eye = ParamsConst::DEFAULT_PERIKSAFISIK_GCS_EYE;
                $modPemeriksaanFisik->gcs_verbal = ParamsConst::DEFAULT_PERIKSAFISIK_GCS_VERBAL;
                $modPemeriksaanFisik->gcs_motorik = ParamsConst::DEFAULT_PERIKSAFISIK_GCS_MOTORIK;
                $modPemeriksaanFisik->gcs_eye = 4;
                
                //thorax
                $modPemeriksaanFisik->au_parurhkanan_1 = $modPemeriksaanFisik->au_parurhkanan_2 = $modPemeriksaanFisik->au_parurhkanan_3 = '-';
                $modPemeriksaanFisik->au_parurhkiri_1 = $modPemeriksaanFisik->au_parurhkiri_2 = $modPemeriksaanFisik->au_parurhkiri_3 = '-';
                
                $modPemeriksaanFisik->au_paruwhkanan_1 = $modPemeriksaanFisik->au_paruwhkanan_2 = $modPemeriksaanFisik->au_paruwhkanan_3 = '-';
                $modPemeriksaanFisik->au_paruwhkiri_1 = $modPemeriksaanFisik->au_paruwhkiri_2 = $modPemeriksaanFisik->au_paruwhkiri_3 = '-';
                
                $modPemeriksaanFisik->au_cardios1 = $modPemeriksaanFisik->au_cardios2 = 'Reguler';
            }


        if(isset($is_triage)) {
            $this->layout= '//layouts/mainNeonSidebar';
            $modTriagePasien = NotriagePasienT::model()->findByPk($notriage_pasien_id);
            $modPemeriksaanFisik->nomor_triage = $modTriagePasien->no_bed_triage . " - " . $modTriagePasien->no_triage_pasien;
        }
        
            $modPemeriksaanFisik->pemeriksaanfisiksebelum_id = $pemeriksaanfisik_id;
            $modPemeriksaanFisik->jnstransaksi = $jnstransaksi;
            
            // if(!empty($pendaftaran_id)) {
            // $fisikakhir = RJPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')), array('order' => 'create_time DESC'));
            // if (!empty($fisikakhir)){
            //     $modPemeriksaanFisik->td_systolic = $fisikakhir->td_systolic;
            //     $modPemeriksaanFisik->td_diastolic = $fisikakhir->td_diastolic;
            //     $modPemeriksaanFisik->tekanandarah = $fisikakhir->tekanandarah;
            //     $modPemeriksaanFisik->meanarteripressure = $fisikakhir->meanarteripressure;
            //     $modPemeriksaanFisik->detaknadi = $fisikakhir->detaknadi;
            //     $modPemeriksaanFisik->denyutjantung = $fisikakhir->denyutjantung;
            //     $modPemeriksaanFisik->pernapasan = $fisikakhir->pernapasan;            
            //     $modPemeriksaanFisik->suhutubuh = $fisikakhir->suhutubuh;
            //     $modPemeriksaanFisik->tinggibadan_cm = $fisikakhir->tinggibadan_cm;
            //     $modPemeriksaanFisik->beratbadan_kg = $fisikakhir->beratbadan_kg;
            //     $modPemeriksaanFisik->bb_ideal = $fisikakhir->bb_ideal;
            //     $modPemeriksaanFisik->tandavital_reflekcahaya = $fisikakhir->tandavital_reflekcahaya;
            //     $modPemeriksaanFisik->tandavital_spo2 = $fisikakhir->tandavital_spo2;           
            // }
        // }

        if(isset($pemeriksaanfisik_id)) {
            $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByPk($pemeriksaanfisik_id);
            // $modPemeriksaanFisik->tekanandarah = 'testing testing';
            // var_dump('tes'); die;
        }
 

        if (isset($_POST['RJPemeriksaanFisikT'])) {
            // var_dump($_POST); die;

            $transaction = Yii::app()->db->beginTransaction();
            try {

                $modPemeriksaanFisik->attributes = $_POST['RJPemeriksaanFisikT'];
                $modPemeriksaanFisik->conjuctiva = isset($_POST['RJPemeriksaanFisikT']['conjuctiva']) ? $_POST['RJPemeriksaanFisikT']['conjuctiva'] : '';
                $modPemeriksaanFisik->keadaanumum = isset($_POST['RJPemeriksaanFisikT']['keadaanumum']) ? $_POST['RJPemeriksaanFisikT']['keadaanumum'] : "";
                $modPemeriksaanFisik->tglperiksafisik = $format->formatDateTimeForDb($_POST['RJPemeriksaanFisikT']['tglperiksafisik']);
                $modPemeriksaanFisik->denyutjantung = isset($_POST['RJPemeriksaanFisikT']['denyutjantung']) ? $_POST['RJPemeriksaanFisikT']['denyutjantung'] : "";
                
                $modPemeriksaanFisik->leher_kelgetahbening_teraba = isset($_POST['RJPemeriksaanFisikT']['leher_kelgetahbening_teraba']) ? $_POST['RJPemeriksaanFisikT']['leher_kelgetahbening_teraba'] : "";
                $modPemeriksaanFisik->leher_reflekpupil = isset($_POST['RJPemeriksaanFisikT']['leher_reflekpupil']) ? $_POST['RJPemeriksaanFisikT']['leher_reflekpupil'] : "";
                $modPemeriksaanFisik->leher_kelenjartiroid_teraba = isset($_POST['RJPemeriksaanFisikT']['leher_kelenjartiroid_teraba']) ? $_POST['RJPemeriksaanFisikT']['leher_kelenjartiroid_teraba'] : "";
                $modPemeriksaanFisik->leher_jvp = isset($_POST['RJPemeriksaanFisikT']['leher_jvp']) ? $_POST['RJPemeriksaanFisikT']['leher_jvp'] : "";
                $modPemeriksaanFisik->leher_mata =  isset($_POST['RJPemeriksaanFisikT']['leher_mata']) ? $_POST['RJPemeriksaanFisikT']['leher_mata'] : "";
                $modPemeriksaanFisik->leher_telinga =  isset($_POST['RJPemeriksaanFisikT']['leher_telinga']) ? $_POST['RJPemeriksaanFisikT']['leher_telinga'] : "";
                $modPemeriksaanFisik->ppds_id = isset($_POST['RJPemeriksaanFisikT']['ppds_id']) ? $_POST['RJPemeriksaanFisikT']['ppds_id'] : "";
     
                $modPemeriksaanFisik->jn_paten = isset($_POST['RJPemeriksaanFisikT']['jn_paten']) ? true : false; 
                $modPemeriksaanFisik->jn_obstruktifpartial = isset($_POST['RJPemeriksaanFisikT']['jn_obstruktifpartial']) ? true : false; 
                $modPemeriksaanFisik->jn_obstruktifnormal = isset($_POST['RJPemeriksaanFisikT']['jn_obstruktifnormal']) ? true : false; 
                $modPemeriksaanFisik->jn_stridor = isset($_POST['RJPemeriksaanFisikT']['jn_stridor']) ? true : false; 
                $modPemeriksaanFisik->jn_gargling = isset($_POST['RJPemeriksaanFisikT']['jn_gargling']) ? true : false; 
                $modPemeriksaanFisik->pgp_normal = isset($_POST['RJPemeriksaanFisikT']['pgp_normal']) ? true : false; 
                $modPemeriksaanFisik->pgp_kussmaul = isset($_POST['RJPemeriksaanFisikT']['pgp_kussmaul']) ? true : false; 
                $modPemeriksaanFisik->pgp_takipnea =  isset($_POST['RJPemeriksaanFisikT']['pgp_takipnea']) ? true : false; 
                $modPemeriksaanFisik->pgp_retraktif = isset($_POST['RJPemeriksaanFisikT']['pgp_retraktif']) ? true : false; 
                $modPemeriksaanFisik->pgp_dangkal = isset($_POST['RJPemeriksaanFisikT']['pgp_dangkal']) ? true : false; 
                $modPemeriksaanFisik->pgd_simetri = isset($_POST['RJPemeriksaanFisikT']['pgd_simetri']) ? true : false; 
                $modPemeriksaanFisik->pgd_asimetri = isset($_POST['RJPemeriksaanFisikT']['pgd_asimetri']) ? true : false; 
                $modPemeriksaanFisik->sirkulasi_nadicarotis = isset($_POST['RJPemeriksaanFisikT']['sirkulasi_nadicarotis']) ? $_POST['RJPemeriksaanFisikT']['sirkulasi_nadicarotis'] : 0; 
                $modPemeriksaanFisik->sirkulasi_nadiradialis = isset($_POST['RJPemeriksaanFisikT']['sirkulasi_nadiradialis']) ? $_POST['RJPemeriksaanFisikT']['sirkulasi_nadiradialis'] : 0; 
                $modPemeriksaanFisik->cfr_kecil_2 = isset($_POST['RJPemeriksaanFisikT']['cfr_kecil_2']) ? true : false; 
                $modPemeriksaanFisik->cfr_besar_2 = isset($_POST['RJPemeriksaanFisikT']['cfr_besar_2']) ? true : false; 
                $modPemeriksaanFisik->kulit_normal = isset($_POST['RJPemeriksaanFisikT']['kulit_normal']) ? true : false; 
                $modPemeriksaanFisik->kulit_jaundice = isset($_POST['RJPemeriksaanFisikT']['kulit_jaundice']) ? true : false; 
                $modPemeriksaanFisik->kulit_cyanosis = isset($_POST['RJPemeriksaanFisikT']['kulit_cyanosis']) ? true : false; 
                $modPemeriksaanFisik->kulit_pucat = isset($_POST['RJPemeriksaanFisikT']['kulit_pucat']) ? true : false; 
                $modPemeriksaanFisik->kulit_berkeringat = isset($_POST['RJPemeriksaanFisikT']['kulit_berkeringat']) ? true : false; 
                $modPemeriksaanFisik->akral = isset($_POST['RJPemeriksaanFisikT']['akral']) ? $_POST['RJPemeriksaanFisikT']['akral'] : ""; 
                $modPemeriksaanFisik->is_masalahperkawinan_cerai = isset($_POST['RJPemeriksaanFisikT']['is_masalahperkawinan_cerai']) ? true : false;
                $modPemeriksaanFisik->is_masalahperkawinan_simpanan = isset($_POST['RJPemeriksaanFisikT']['is_masalahperkawinan_simpanan']) ? true : false;
                $modPemeriksaanFisik->is_masalahperkawinan_istribaru = isset($_POST['RJPemeriksaanFisikT']['is_masalahperkawinan_istribaru']) ? true : false;
                $modPemeriksaanFisik->is_masalahperkawinan_lainlain = isset($_POST['RJPemeriksaanFisikT']['is_masalahperkawinan_lainlain']) ? true : false;
                $modPemeriksaanFisik->suhutubuh = isset($_POST['RJPemeriksaanFisikT']['suhutubuh']) ? str_replace(',', '.', $_POST['RJPemeriksaanFisikT']['suhutubuh']) : null;

                $modPemeriksaanFisik->gcs_kesadaran = isset($_POST['RJPemeriksaanFisikT']['gcs_kesadaran']) ? $_POST['RJPemeriksaanFisikT']['gcs_kesadaran'] : null;


                if (!empty($modPemeriksaanFisik->tl_homecare_tgl)) {
                    $modPemeriksaanFisik->tl_homecare_tgl = MyFormatter::formatDateTimeForDb($modPemeriksaanFisik->tl_homecare_tgl);
                } else {
                    $modPemeriksaanFisik->tl_homecare_tgl = null;
                }

                // sensibilitas
                if (
                        !empty($modPemeriksaanFisik->sensibilitas_panasdingin) || !empty($modPemeriksaanFisik->sensibilitas_tajamtumpul) || !empty($modPemeriksaanFisik->sensibilitas_kasarhalus) || !empty($modPemeriksaanFisik->sensibilitas_titik)
                ) {
                    $modPemeriksaanFisik->ada_sensibilitas = true;

                    $modPemeriksaanFisik->sensibilitas_panasdingin = implode(":", $modPemeriksaanFisik->sensibilitas_panasdingin);
                    $modPemeriksaanFisik->sensibilitas_tajamtumpul = implode(":", $modPemeriksaanFisik->sensibilitas_tajamtumpul);
                    $modPemeriksaanFisik->sensibilitas_kasarhalus = implode(":", $modPemeriksaanFisik->sensibilitas_kasarhalus);
                    $modPemeriksaanFisik->sensibilitas_titik = implode(":", $modPemeriksaanFisik->sensibilitas_titik);
                }

                $modPemeriksaanFisik->mews_suhu = str_replace(",", ".", $modPemeriksaanFisik->mews_suhu);
                $modPemeriksaanFisik->ews_suhu = str_replace(",", ".", $modPemeriksaanFisik->ews_suhu);

                if (!empty($modPemeriksaanFisik->mews_totalkriteria)) {
                    $modPemeriksaanFisik->mews_totalkriteria = implode(".", $modPemeriksaanFisik->mews_totalkriteria);
                }


                if ($modPemeriksaanFisik->validate()) {
                    if ($modPemeriksaanFisik->jnstransaksi == 'salin') {
                        unset($modPemeriksaanFisik->pemeriksaanfisik_id);
                        $modPemeriksaanFisik->IsNewRecord = true;
                    }


                if(isset($notriage_pasien_id)) {
                    $modPemeriksaanFisik->notriage_pasien_id = $notriage_pasien_id;
                }

                    // var_dump($this->simpanpemeriksaanfisik, $modPemeriksaanFisik->save()); die;

                    if ($modPemeriksaanFisik->save()) {

                        if(isset($pendaftaran_id)) {

                            $p = PendaftaranT::model()->findByPk($pendaftaran_id);
                        $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
                        $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');

                        if (empty($p->waktumulaiperiksa)) {
                            PendaftaranT::model()->updateByPk($p->pendaftaran_id, array('waktumulaiperiksa' => date('Y-m-d H:i:s')));
                        }

                        $st = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')));
                        if (!empty($st)) {
                            $pasienpenunjang = PasienmasukpenunjangT::model()->updateByPk($st->pasienmasukpenunjang_id, array(
                                'statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA
                            ));
                            // echo '<pre>'; var_dump('st1', $st->pasienmasukpenunjang_id, $a->statusperiksa);die;
                        }

                        $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
                        if (!empty($konsulPoli)) {
                            $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
                        }
                        $this->simpanpemeriksaanfisik = true;
                        $this->simpanDiagnosaKerja($modPemeriksaanFisik, $_POST['RJPemeriksaanFisikT']);
                        if (isset($_POST['IntegumenT'])) {
                            $this->simpanIntegumen($modPemeriksaanFisik, $_POST['IntegumenT']);
                        }

                        }

                        $this->simpanpemeriksaanfisik = true;
                        
                    }
                }
                if (isset($_POST['RJPemeriksaangambarT'])) {
                    if (count((array) $_POST['RJPemeriksaangambarT']) > 0) {
                        foreach ($_POST['RJPemeriksaangambarT'] as $i => $postperiksagbr) {
                            $this->simpanpemeriksaangambar &= $this->simpanPemeriksaanGambar($postperiksagbr, $modPemeriksaanFisik, $modGambarTubuh);
                        }
                    }
                }

                $ok = true;
                if (isset($_POST['AsesmennyeriflaccsT']['flaccs'])) {
                    foreach ($_POST['AsesmennyeriflaccsT']['flaccs'] as $ii => $val) {
                        $modFlaCcs->attributes = $_POST['AsesmennyeriflaccsT']['flaccs'][$ii];
                        if ($modPemeriksaanFisik->jnstransaksi != 'salin') {
                            $cek = AsesmennyeriflaccsT::model()->findByAttributes(array('pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id, 'skalanyeriflaccs_id' => $modFlaCcs->skalanyeriflaccs_id));
                        } else {
                            $cek = AsesmennyeriflaccsT::model()->findByAttributes(array('pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisiksebelum_id, 'skalanyeriflaccs_id' => $modFlaCcs->skalanyeriflaccs_id));
                        }
                        if (empty($cek)) {
                            $modFlaCcs = new AsesmennyeriflaccsT;
                            $modFlaCcs->attributes = $_POST['AsesmennyeriflaccsT']['flaccs'][$ii];
                            $modFlaCcs->pemeriksaanfisik_id = $modPemeriksaanFisik->pemeriksaanfisik_id;
                            $ok = $ok && $modFlaCcs->save();
                        } else {
                            if ($modPemeriksaanFisik->jnstransaksi != 'salin') {
                                if (!empty($cekFlaCcs)) {
                                    unset($cekFlaCcs[$modFlaCcs->skalanyeriflaccs_id]);
                                }
                            } else {
                                unset($cek->pemeriksaanfisik_id);
                                $cek->IsNewRecord = true;
                                $cek->save();
                            }
                        }
                    }
                    $delFlaCcs = $cekFlaCcs;
                    if (!empty($delFlaCcs)) {
                        $delete = array();
                        foreach ($delFlaCcs as $d) {
                            $delete[] = $d;
                        }
                        $cri = new CDbCriteria();
                        $cri->addCondition("pemeriksaanfisik_id = '" . $modPemeriksaanFisik->pemeriksaanfisik_id . "' ");
                        $cri->addInCondition('skalanyeriflaccs_id', $delete);
                        $up = AsesmennyeriflaccsT::model()->deleteAll($cri);
                    }
                } else {
                    $delFlaCcs = $cekFlaCcs;

                    if (!empty($delFlaCcs)) {
                        $delete = array();
                        foreach ($delFlaCcs as $d) {
                            $delete[] = $d;
                        }

                        $cri = new CDbCriteria();
                        $cri->addCondition("pemeriksaanfisik_id = '" . $modPemeriksaanFisik->pemeriksaanfisik_id . "' ");
                        $cri->addInCondition('skalanyeriflaccs_id', $delete);
                        $up = AsesmennyeriflaccsT::model()->deleteAll($cri);
                    }
                }

                // echo '<pre>'; var_dump($this->simpanpemeriksaanfisik, $this->simpanpemeriksaangambar, $ok); die;

                if ($this->simpanpemeriksaanfisik && $this->simpanpemeriksaangambar && $ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Pemeriksaan Fisik berhasil disimpan");
                
                    if(isset($pendaftaran_id)) {
                        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'id' => $modPemeriksaanFisik->pemeriksaanfisik_id));
                    } else {
                        $this->redirect(array('index', 'is_triage' => $is_triage, 'notriage_pasien_id' => $notriage_pasien_id, 'id' => $modPemeriksaanFisik->pemeriksaanfisik_id, 'tipe' => 'sukses'));
                    }
                } else {
                    //die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
                    //$this->redirect($_POST['url']); 
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Pemeriksaan Fisik gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }


        $modPemeriksaanFisik->tglperiksafisik = Yii::app()->dateFormatter->formatDateTime(
                CDateTimeParser::parse($modPemeriksaanFisik->tglperiksafisik, 'yyyy-MM-dd hh:mm:ss')
        );

        if (empty(Params::getModulRDRI(Yii::app()->user->getState('modul_id')))) {
            $this->render($this->path_view . 'index', array(
                'modPasien' => $modPasien,
                'modPemeriksaanFisik' => $modPemeriksaanFisik,
                'modPendaftaran' => $modPendaftaran,
                'modRJMetodeGSCM' => $modRJMetodeGSCM,
                'modBagianTubuh' => $modBagianTubuh,
                'modGambarTubuh' => $modGambarTubuh,
                'modPemeriksaanGambar' => $modPemeriksaanGambar,
                'tabelPemeriksaan' => $tabelPemeriksaan,
                'tabelPemeriksaanPasien' => $tabelPemeriksaanPasien,
                'modFlaCcs' => $modFlaCcs,
                'dataFlaCcs' => $dataFlaCcs,
                'getFlaCcs' => $getFlaCcs,
                'modIntegumen' => $modIntegumen,
            ));
        } else if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RI) {
            $this->render($this->path_view . 'indexInap', array(
                'modPasien' => $modPasien,
                'modPemeriksaanFisik' => $modPemeriksaanFisik,
                'modPendaftaran' => $modPendaftaran,
                'modRJMetodeGSCM' => $modRJMetodeGSCM,
                'modBagianTubuh' => $modBagianTubuh,
                'modGambarTubuh' => $modGambarTubuh,
                'modPemeriksaanGambar' => $modPemeriksaanGambar,
                'tabelPemeriksaan' => $tabelPemeriksaan,
                'tabelPemeriksaanPasien' => $tabelPemeriksaanPasien,
                'modIntegumen' => $modIntegumen,
            ));
        } else {
            $this->render($this->path_view . 'indexDarurat', array(
                'modPasien' => $modPasien,
                'modPemeriksaanFisik' => $modPemeriksaanFisik,
                'modPendaftaran' => $modPendaftaran,
                'modRJMetodeGSCM' => $modRJMetodeGSCM,
                'modBagianTubuh' => $modBagianTubuh,
                'modGambarTubuh' => $modGambarTubuh,
                'modPemeriksaanGambar' => $modPemeriksaanGambar,
                'tabelPemeriksaan' => $tabelPemeriksaan,
                'tabelPemeriksaanPasien' => $tabelPemeriksaanPasien,
                'modIntegumen' => $modIntegumen,
            ));
        }
    }

    public function simpanIntegumen($model, $post) {

        $mod = new IntegumenT();
        if ($model->jnstransaksi == 'ubah') {
            $cekInteg = IntegumenT::model()->findByAttributes([
                'pemeriksaanfisik_id' => $model->pemeriksaanfisik_id
            ]);
            if (!empty($cekInteg)) {
                $mod = $cekInteg;
            }
        }
        $mod->attributes = $post;
        $mod->pemeriksaanfisik_id = $model->pemeriksaanfisik_id;

        if (!empty($mod->warna['val'])) {
            if ($mod->warna['val'] == 'Lain2') {
                $mod->warna = $mod->warna['lain2'];
            } else {
                $mod->warna = $mod->warna['val'];
            }
        } else {
            $mod->warna = "";
        }
        if (!empty($mod->integritas['val'])) {
            if ($mod->integritas['val'] == 'Lain2') {
                $mod->integritas = $mod->integritas['lain2'];
            } else {
                $mod->integritas = $mod->integritas['val'];
            }
        } else {
            $mod->integritas = "";
        }

        $mod->save();
    }

    /**
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     * 
     * Menyimpan data Diagnosa kerja (jika ada).
     * 
     * @param RIPemeriksaanfisikT $model data pemeriksaan fisik
     * @param mixed $post data post submit.
     */
    public function simpanDiagnosaKerja($model, $post) {
        if ($model->jnstransaksi != 'salin') {
            DiagnosakerjaT::model()->deleteAllByAttributes(array(
                'pemeriksaanfisik_id' => $model->pemeriksaanfisik_id,
            ));
        }

        if (isset($post['periksa_penunjang_detail'])) {
            foreach ($post['periksa_penunjang_detail'] as $item) {
                $mod = new DiagnosakerjaT();
                $mod->pemeriksaanfisik_id = $model->pemeriksaanfisik_id;
                $mod->diagnosakerja_isi = $item;
                $this->simpanpemeriksaanfisik = $this->simpanpemeriksaanfisik && $mod->save();
                //var_dump($mod->save(), $mod->attributes);
            }
        }

        //var_dump($this->simpanpemeriksaanfisik, $model->attributes, $post);
        // die;
    }

    //-- Rawat Jalan --//
    //function ajax get Text Tekanan Body Mass Index untuk form Pemeriksaan Fisik
    public function actionGetBMIText() {
        if (Yii::app()->request->isAjaxRequest) {
            $bmi = (isset($_POST['bmi']) ? $_POST['bmi'] : null);
            $criteria2 = new CDbCriteria();
            $criteria2->select = 'max(bmi_minimum) as max_bmi';
            $modBMI = BodymassindexM::model()->find($criteria2);
            $criteria = new CDbCriteria();

            if ($bmi > $modBMI->max_bmi) {

                if ($bmi < 30) {
                    $criteria->condition = 'bmi_minimum <= ' . $bmi . ' and bmi_maksimum = 0';
                } else {
                    $criteria->condition = 'bmi_minimum >= 30 and bmi_maksimum = 100';
                }
            } else {
                if ($bmi < 30) {
                    $criteria->addCondition($bmi . ' >= bmi_minimum');
                    $criteria->addCondition($bmi . ' <= bmi_maksimum');
                }
            }
            $data = array();
            $bmi = BodymassindexM::model()->find($criteria);

            $data['text'] = (isset($bmi->bmi_defenisi) ? $bmi->bmi_defenisi : "");
            $data['id'] = (isset($bmi) ? $bmi->bodymassindex_id : "");
            echo json_encode($data);
        }
        Yii::app()->end();
    }

    // function untuk simpan data pemeriksaan gambar
    // RND-RND-7611
    public function simpanPemeriksaanGambar($postperiksagbr, $modPemeriksaanFisik, $modGambarTubuh) {
        $format = new MyFormatter;

        // ar_dump($postperiksagbr); die;
        if (empty($postperiksagbr['pemeriksaangambar_id'])) {
            $modPemeriksaanGambar = new RJPemeriksaangambarT;
            $modPemeriksaanGambar->attributes = $postperiksagbr;
            $modPemeriksaanGambar->pemeriksaanfisik_id = $modPemeriksaanFisik->pemeriksaanfisik_id;
            // $modPemeriksaanGambar->gambartubuh_id = $modGambarTubuh->DataGambarAnatomi->gambartubuh_id; 
            $modPemeriksaanGambar->pendaftaran_id = $modPemeriksaanFisik->pendaftaran_id;
            $modPemeriksaanGambar->pasien_id = $modPemeriksaanFisik->pasien_id;
            $modPemeriksaanGambar->tglpemeriksaan = date('Y-m-d H:i:s');
            $modPemeriksaanGambar->create_time = date('Y-m-d H:i:s');
            $modPemeriksaanGambar->create_loginpemakai_id = Yii::app()->user->id;
            $modPemeriksaanGambar->create_ruangan = Yii::app()->user->getState('ruangan_id');

            if ($modPemeriksaanGambar->validate()) {
                return $modPemeriksaanGambar->save();
            } else {
                return false;
            }
        } else {
            if ($modPemeriksaanFisik->jnstransaksi == 'salin') {
                $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findByPk($postperiksagbr['pemeriksaangambar_id']);
                $modPemeriksaanGambar->pemeriksaanfisik_id = $modPemeriksaanFisik->pemeriksaanfisik_id;
                unset($modPemeriksaanGambar->pemeriksaangambar_id);
                $modPemeriksaanGambar->IsNewRecord = true;
                return $modPemeriksaanGambar->save();
            } else {
                return true;
            }
        }
    }

    public function actionGambarJK() {

        if (Yii::app()->request->isAjaxRequest) {

            $data = array();

            $jeniskelamin = $_POST['jeniskelamin'];

            $modGambar = RJGambartubuhM::model()->findByAttributes(array(
                'jeniskelamin' => $jeniskelamin
            ));

            //render form gambar

            $modGambarTubuh = new RJGambartubuhM();
            $data['div'] = $this->renderPartial($this->path_view . "_formGambarRD", array('modGambarTubuh' => $modGambarTubuh));

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    //-- Rawat Jalan --//
    //function ajax get Text Tekanan Darah untuk form Pemeriksaan Fisik
    public function actionGetTextTekananDarah() {
        if (Yii::app()->request->isAjaxRequest) {

            $criteria = new CDbCriteria();
            $sis = $_POST['systolic'];
            $dias = $_POST['diastolic'];

            $sis_ok = false;
            $dias_ok = false;
            $aktif = false;
            $teks = '';

            $modTD = KlasifikasitekanadarahM::model()->findAll();

            // echo '<pre>';

            if (!empty($sis) && !empty($dias)) {
                foreach ($modTD as $td) {

                    $sis_ok = (intval($sis) >= $td->sistolik_min) && (intval($sis) <= $td->sistolik_maks);
                    $dias_ok = (intval($dias) >= $td->diastolik_min) && (intval($dias) <= $td->diastolik_miks);
                    $aktif = $td->klasifikasitekanadarah_aktif;

                    if ($sis_ok && $dias_ok && $aktif) {
                        $teks = $td->klasifikasitekanadarah;
                    }
                    // var_dump(intval($sis), $td->sistolik_min, $td->sistolik_maks);
                    // var_dump(intval($dias), $td->diastolik_min, $td->diastolik_miks);
                }
            }

            // die();

            $data['text'] = $teks;
            echo json_encode($data);
        }
        Yii::app()->end();
    }

    /**
     * @param type $pendaftaran_id
     */
    public function actionPrintPemeriksaanFisik($pendaftaran_id, $pemeriksaanfisik_id = null) {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        if (!empty($pemeriksaanfisik_id)) {
            $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByAttributes(array('pemeriksaanfisik_id' => $pemeriksaanfisik_id));
            $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $pemeriksaanfisik_id));
        } else {
            $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        }
        $modGambarTubuh = new RJGambartubuhM();
        $modBagianTubuh = new RJBagiantubuhM();
        if ((!empty($modPemeriksaanFisik->gcs_eye)) && (!empty($modPemeriksaanFisik->gcs_verbal)) && (!empty($modPemeriksaanFisik->gcs_motorik))) {
            $modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
        }

        // Asesmen Nyeri (Fisioterapi)
        $modFlaCcs = new AsesmennyeriflaccsT;
        $dataFlaCcs = array();
        $getFlaCcs = null;
        $cekFlaCcs = array();

        $criFla = new CDbCriteria();
        $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
        $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
        $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
        $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);

        foreach ($modNyeriFlaCcs as $dtF) {

            $datas = AsesmennyeriflaccsT::model()->findByAttributes(array(
                'pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id,
                'skalanyeriflaccs_id' => $dtF->skalanyeriflaccs_id,
            ));

            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
            $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
                'id' => $dtF->skalanyeriflaccs_id,
                'keterangan' => $dtF->skalanyeriflaccs_desc,
                'value' => empty($datas) ? false : true,
            );
        }

        $judul_print = 'PEMERIKSAAN FISIK';
        if ((Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) || (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) || (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_PERSALINAN)) {
            $pr_path = 'printV3';
        } else if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_PERSALINAN) {
            $pr_path = 'printV4';
        } else {
            $pr_path = 'print';
        }

        $this->render($this->path_view . $pr_path, array(
            //$this->render($this->path_view.'print', array(
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            'judul_print' => $judul_print,
            'modPasien' => $modPasien,
            'modPemeriksaanFisik' => $modPemeriksaanFisik,
            'modPemeriksaanGambar' => $modPemeriksaanGambar,
            'modGambarTubuh' => $modGambarTubuh,
            'modBagianTubuh' => $modBagianTubuh,
            'modFlaCcs' => $modFlaCcs,
            'dataFlaCcs' => $dataFlaCcs,
            'getFlaCcs' => $getFlaCcs
        ));
    }

    //action pindahan dari Controller/ActionAjaxController
    public function actionGetMetodeGCS() {
        if (Yii::app()->request->isAjaxRequest) {
            $gcs_eye = $_POST['gcs_eye'];
            $gcs_motorik = $_POST['gcs_motorik'];
            $gcs_verbal = $_POST['gcs_verbal'];

            $jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;

            $namaGCS = GcsM::model()->find($jumlah . ' >= gcs_nilaimin AND ' . $jumlah . ' <= gcs_nilaimax AND gcs_aktif = TRUE');

            if (count((array) $namaGCS) > 0) {//Jika Nilai GCprintoutSnya ada
                $data['idGCS'] = $namaGCS->gcs_id;
                $data['namaGCS'] = $namaGCS->gcs_nama;
                echo json_encode($data);
                Yii::app()->end();
            } else {
                $data['pesan'] = 'Nilai GCS Tidak Ditemukan';
                echo json_encode($data);
                Yii::app()->end();
            }
        }
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

    public function actionMasterKeadaanUmum() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(keadaanumum_nama)', strtolower($_GET['tag']), true);
            $criteria->order = "keadaanumum_nama ASC";
            $keluhans = KeadaanumumM::model()->findAll($criteria);
            $data = array();
            foreach ($keluhans as $i => $keluhan) {
                $data[$i] = array(
                    'key' => $keluhan->keadaanumum_nama,
                    'value' => $keluhan->keadaanumum_nama
                );
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    // RND-5044 action pindahan dari Controller/ActionAutoCompleteController
    public function actionAutocompleteParamedisRJ() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 10;
            $models = ParamedisV::model()->findAll($criteria);
            foreach ($models as $item) {
                $arr[] = $item->nama_pegawai;
            }

            echo CJSON::encode($arr);
        }
        Yii::app()->end();
    }

    public function actionTambahBagianTubuh() {
        if (Yii::app()->request->isAjaxRequest) {
            $pesan = '';
            $form = '';
            if (!empty($_POST['bagiantubuh_id'])) {
                $modPemeriksaanGbr = new RJPemeriksaangambarT();
                $modPemeriksaanGbr->bagiantubuh_id = $_POST['bagiantubuh_id'];
                $modPemeriksaanGbr->namabagtubuh = $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
                $modPemeriksaanGbr->keterangan_periksa_gbr = $_POST['keterangan'];
                $modPemeriksaanGbr->kordinat_tubuh_x = $_POST['pic_x'];
                $modPemeriksaanGbr->kordinat_tubuh_y = $_POST['pic_y'];
                $modPemeriksaanGbr->gambartubuh_id = $_POST['gambartubuh_id'];

                $modPemeriksaanGbr->look = isset($_POST['look']) ? $_POST['look'] : null;

                $modPemeriksaanGbr->feel = isset($_POST['feel']) ? $_POST['feel'] : null;
                $modPemeriksaanGbr->move = isset($_POST['move']) ? $_POST['move'] : null;
                $modPemeriksaanGbr->sensory = isset($_POST['sensory']) ? $_POST['sensory'] : null;
                $modPemeriksaanGbr->motorik = isset($_POST['motorik']) ? $_POST['motorik'] : null;

                $form = $this->renderPartial($this->path_view . '_rowDetail', array('modPemeriksaanGbr' => $modPemeriksaanGbr), true);
                $axis['x'] = $modPemeriksaanGbr->kordinat_tubuh_x;
                $axis['y'] = $modPemeriksaanGbr->kordinat_tubuh_y;
                echo CJSON::encode(array('pesan' => $pesan, 'form' => $form, 'axis' => $axis, 'bagiantubuh_id' => $modPemeriksaanGbr->bagiantubuh_id));
            } else {
                $pesan = 'Bagian tubuh tidak boleh kosong!';
                echo CJSON::encode(array('pesan' => $pesan));
            }
        }
        Yii::app()->end();
    }

    public function actionHapusBagianTubuh() {
        if (Yii::app()->request->isAjaxRequest) {
            $pesan = '';
            $ok = 0;
            $del = true;

            $ok = RJPemeriksaangambarT::model()->findByAttributes(
                    array(
                        'pemeriksaangambar_id' => $_POST['pemeriksaangambar_id'],
                        'gambartubuh_id' => $_POST['gambartubuh_id'],
                        'bagiantubuh_id' => $_POST['bagiantubuh_id'],
                        'keterangan_periksa_gbr' => $_POST['keterangan_periksa_gbr'],
                    )
            );

            if (!empty($ok)) {
                $del = $del && $ok->delete();
            }



            if ($del) {
                $pesan = 'Data Berhasil Dihapus dari database';
                $ok = 1;
                echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
            } else {
                $ok = 0;
                $pesan = "Bagian Tubuh gagal dihapus!";
                echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
            }
        }
        Yii::app()->end();
    }

    public function actionGetBagianTubuhId() {
        if (Yii::app()->request->isAjaxRequest) {
            $pesan = '';
            $data = array();
            $kordinat_x = $_POST['kordinat_x'];
            $kordinat_y = $_POST['kordinat_y'];

            $gambartubuh_id = $_POST['gambartubuh_id'];
            //				$loadPemeriskaanGamabr = RJPemeriksaangambarT::model()->findByPk($_POST['pemeriksaangambar_id']);
            $cr = new CDbCriteria();
            $cr->addCondition("" . $kordinat_x . " between kordinat_x and kordinat_x2");
            $cr->addCondition("" . $kordinat_y . " between kordinat_y and kordinat_y2");
            $cr->compare('gambartubuh_id', $gambartubuh_id);
            $cr->order = ('bagiantubuh_urutan asc');

            $result = BagiantubuhM::model()->find($cr);
            if ($result) {
                $data['kakitangan'] = '';
                $tangan = stristr($result['namabagtubuh'], 'tangan');
                $lengan = stristr($result['namabagtubuh'], 'lengan');
                $paha = stristr($result['namabagtubuh'], 'paha');
                $lutut = stristr($result['namabagtubuh'], 'lutut');
                $betis = stristr($result['namabagtubuh'], 'betis');
                $kaki = stristr($result['namabagtubuh'], 'kaki');
                if (!empty($tangan) or ! empty($lengan) or ! empty($paha) or ! empty($lutut) or ! empty($betis) or ! empty($kaki)) {
                    $data['kakitangan'] = 'ok';
                }
                $data['pesan'] = '';
                $data['namabagtubuh'] = $result['namabagtubuh'];
                $data['bagiantubuh_id'] = $result['bagiantubuh_id'];
                echo json_encode($data);
            } else {
                $pesan = "Bagian tubuh belum disetting!";
                echo CJSON::encode(array('pesan' => $pesan));
            }
        }
        Yii::app()->end();
    }

    public function actionAjaxDetailFisik() {
        if (Yii::app()->request->isAjaxRequest) {
            $idFisik = $_POST['idFisik'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
            $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByPk($idFisik);
            $jumlah = 0;
            $hasil = null;
            $gcs_eye = $modPemeriksaanFisik->gcs_eye;
            $gcs_motorik = $modPemeriksaanFisik->gcs_motorik;
            $gcs_verbal = $modPemeriksaanFisik->gcs_verbal;
            $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pemeriksaanfisik_id' => $idFisik));
            $modGambarTubuh = !empty($modPemeriksaanGambar) ? RJGambartubuhM::model()->findByPk($modPemeriksaanGambar[0]->gambartubuh_id) : new RJGambartubuhM;
            $modBagianTubuh = new RJBagiantubuhM();
            $jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;
            $namaGCS = GcsM::model()->find('' . $jumlah . '>=gcs_nilaimin AND ' . $jumlah . '<=gcs_nilaimax AND gcs_aktif=TRUE');
            if (!empty($namaGCS)) { //Jika Nilai GCSnya ada
                $hasil = $namaGCS->gcs_nama;
            } else {
                $hasil = 'Nilai GCS Tidak Ditemukan';
            }

            // Asesmen Nyeri (Fisioterapi)
            $modFlaCcs = new AsesmennyeriflaccsT;
            $dataFlaCcs = array();
            $getFlaCcs = null;
            $cekFlaCcs = array();

            $criFla = new CDbCriteria();
            $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
            $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
            $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
            $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);

            foreach ($modNyeriFlaCcs as $dtF) {

                $datas = AsesmennyeriflaccsT::model()->findByAttributes(array(
                    'pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id,
                    'skalanyeriflaccs_id' => $dtF->skalanyeriflaccs_id,
                ));

                $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
                $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
                    'id' => $dtF->skalanyeriflaccs_id,
                    'keterangan' => $dtF->skalanyeriflaccs_desc,
                    'value' => empty($datas) ? false : true,
                );
            }
            $data['result'] = $this->renderPartial($this->path_view . '_viewDetailFisik', array(
                'modPemeriksaanFisik' => $modPemeriksaanFisik,
                'modPendaftaran' => $modPendaftaran,
                'hasil' => $hasil,
                'modPemeriksaanGambar' => $modPemeriksaanGambar,
                'modGambarTubuh' => $modGambarTubuh,
                'modBagianTubuh' => $modBagianTubuh,
                'modFlaCcs' => $modFlaCcs,
                'dataFlaCcs' => $dataFlaCcs,
                'getFlaCcs' => $getFlaCcs
                    ), true);

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionHapusRiwayatPemeriksaan() {
        if (Yii::app()->request->isAjaxRequest) {
            $idPemeriksaanFisik = (isset($_POST['pemeriksaanfisik_id']) ? $_POST['pemeriksaanfisik_id'] : null);
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                DiagnosakerjaT::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
                AsesmennyeriflaccsT::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
                PemeriksaangambarT::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
                PemeriksaankalaT::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
                PengkajianaskepT::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
                RiwayatthtR::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
                $deletePemeriksaanFisik = RJPemeriksaanFisikT::model()->deleteByPk($idPemeriksaanFisik);
                if ($deletePemeriksaanFisik) {
                    $data['pesan'] = "Riwayat Pemeriksaan Fisik Berhasil Dihapus!";
                    $data['sukses'] = 1;
                    $transaction->commit();
                } else {
                    $data['pesan'] = "Gagal Menghapus Pemeriksaan Fisik";
                    $data['sukses'] = 0;
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $data['pesan'] = "Hapus Data Gagal :" . MyExceptionMessage::getMessage($exc, true, true);
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionLoadGambarTubuh() {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $gambartubuh_id = $_POST['gambartubuh_id'];
            $modBagianTubuh = GambartubuhM::model()->findByPk($gambartubuh_id);
            if (!empty($modBagianTubuh)) {
                $id = $modBagianTubuh->gambartubuh_id;
                $nama_gambar = $modBagianTubuh->nama_file_gbr;
                $data['html'] = $this->renderPartial($this->path_view . '_formGambarRD2', array('id' => $id, 'temp_file' => $nama_gambar), true);
            }

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    public function actionLoadGambarTubuhRD() {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();

            $gambartubuh_id = $_POST['gambartubuh_id'];
            $modBagianTubuh = GambartubuhM::model()->findByPk($gambartubuh_id);
            //                        echo '<pre>';            var_dump($modBagianTubuh->attributes); die();

            $id = $modBagianTubuh->gambartubuh_id;
            $nama_gambar = $modBagianTubuh->nama_file_gbr;

            $data['html'] = $this->renderPartial($this->path_view . "_formGambarRD", array('dat' => "nyoba", 'gambartubuh_id' => $id, 'nama_file_gbr' => $nama_gambar));
            echo json_encode($data);
            echo '<pre>';
            var_dump($data);
            die();
        }
        Yii::app()->end();
    }

    public function actionSetDropdownGambarTubuh($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {


            $models = null;

            $jk = $_POST['RJPemeriksaanFisikT']['jeniskelamin'];

            if ($jk != '') {
                $models = CHtml::listData(GambartubuhM::model()->findAll("jeniskelamin = '$jk'"), 'gambartubuh_id', 'nama_gambar');
            } else {
                $models = CHtml::listData(GambartubuhM::model()->findAll(), 'gambartubuh_id', 'nama_gambar');
            }



            if ($encode) {
                echo CJSON::encode($models);
            } else {
                if (count((array) $models) > 1) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                }
                if (count((array) $models) > 0) {
                    foreach ($models as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }   

    public function actionPeriksaTandaVital($pendaftaran_id) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')), array('order' => 'create_time DESC'));
        $modAnamnesa = new RJAnamnesaT;

        $cekAnamnesa = RJAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')), array('order' => 'create_time DESC'));
        if (!empty($cekAnamnesa)) {
            $modAnamnesa = $cekAnamnesa;
        }

        if (empty($modPemeriksaanFisik)) {
            $modPemeriksaanFisik = new RJPemeriksaanFisikT;
            $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $modPemeriksaanFisik->paramedis_nama = empty($pegawai) ? null : $pegawai->nama_pegawai;
            $modPemeriksaanFisik->pegawai_id = $modPendaftaran->pegawai_id;            
            $modPemeriksaanFisik->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modPemeriksaanFisik->pasien_id = $modPasien->pasien_id;            
            $modPemeriksaanFisik->tglperiksafisik = date('Y-m-d H:i:s');
        }
        
        if (isset($_POST['RJPemeriksaanFisikT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modPemeriksaanFisik->attributes = $_POST['RJPemeriksaanFisikT'];


                $modPemeriksaanFisik->tglperiksafisik = MyFormatter::formatDateTimeForDb($modPemeriksaanFisik->tglperiksafisik);                
                
                if($this->module->id != 'rawatDarurat') {
                    $modPemeriksaanFisik->pendaftaran_id = $pendaftaran_id;
                    $modPemeriksaanFisik->pasien_id = $modPendaftaran->pasien_id;
                }

                if (!empty($modPemeriksaanFisik->pemeriksaanfisik_id)) {
                    $modPemeriksaanFisik->update_time = date('Y-m-d H:i:s');
                    $modPemeriksaanFisik->update_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                    $modPemeriksaanFisik->update_loginpemakai_id = Yii::app()->user->id;
                } else {
                    $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
                    $modPemeriksaanFisik->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                    $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->id;
                }

                $modPemeriksaanFisik->suhutubuh = isset($_POST['RJPemeriksaanFisikT']['suhutubuh']) ? str_replace(',', '.', $_POST['RJPemeriksaanFisikT']['suhutubuh']) : null;

                $tersimpan = false;

                if ($modPemeriksaanFisik->save()) {
                    $tersimpan = true;
                }                                

                if (isset($_POST['RJAnamnesaT'])) {
                    $modAnamnesa->attributes = $_POST['RJAnamnesaT'];

                    $modAnamnesa->keluhanutama = isset($_POST['RJAnamnesaT']['keluhanutama']) ? ((count((array) $_POST['RJAnamnesaT']['keluhanutama']) > 0) ? implode(', ', $_POST['RJAnamnesaT']['keluhanutama']) : '') : '';
                    $modAnamnesa->keluhantambahan = isset($_POST['RJAnamnesaT']['keluhantambahan']) ? ((count((array) $_POST['RJAnamnesaT']['keluhantambahan']) > 0) ? implode(', ', $_POST['RJAnamnesaT']['keluhantambahan']) : '') : '';
                    $modAnamnesa->tglanamnesis = MyFormatter::formatDateTimeForDb($modPemeriksaanFisik->tglperiksafisik);

                    if($this->module->id != 'rawatDarurat') {
                        $modAnamnesa->pendaftaran_id = $pendaftaran_id;
                        $modAnamnesa->pasien_id = $modPendaftaran->pasien_id;
                    }
                    
                    if (empty($modAnamnesa->anamesa_id)) {
                        $modAnamnesa->pasien_id = $modPemeriksaanFisik->pasien_id;
                        $modAnamnesa->pegawai_id = $modPemeriksaanFisik->pegawai_id;                        
                        $modAnamnesa->pendaftaran_id = $modPemeriksaanFisik->pendaftaran_id;                        
                        $modAnamnesa->create_time = date("Y-m-d H:i:s");
                        $modAnamnesa->create_loginpemakai_id = Yii::app()->user->id;
                        $modAnamnesa->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    } else {
                        $modAnamnesa->update_time = date("Y-m-d H:i:s");
                        $modAnamnesa->update_loginpemakai_id = Yii::app()->user->id;
                    }

                    // echo '<pre>'; var_dump($modAnamnesa->attributes); die;

                    $tersimpan &= $modAnamnesa->save();
                }

                if ($tersimpan) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('periksaTandaVital', 'pendaftaran_id' => $pendaftaran_id, 'id' => $modPemeriksaanFisik->pemeriksaanfisik_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Pemeriksaan Fisik gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'periksaTandaVital', array(
            'modPemeriksaanFisik' => $modPemeriksaanFisik, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,
            'modAnamnesa' => $modAnamnesa));
    }
    
    public function actionDetailPemeriksaanTandaVital($pendaftaran_id) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
        $ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan' => $ruangan_id), array('order' => 'tglperiksafisik desc'));

        if (empty($modPemeriksaanFisik)) {
            echo "Lakukan transaksi Periksa Fisik sebelum melihat detail ini.";
            Yii::app()->end();
        }

        $this->render($this->path_view . 'detailPemeriksaanTandaVital', array('modPendaftaran' => $modPendaftaran, 'modPemeriksaanFisik' => $modPemeriksaanFisik));
    }

}