<?php
class CPPTController extends MyAuthController
{
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rawatDarurat.views.cppt.';
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id, $frame = 0)
    {
        $modPenunjang = null;
        
        $modelRiwayat = new RDCpptpasienT();
        $modelRiwayat->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modelRiwayat->unsetAttributes();


        // if (!empty($_GET['frame'])) {
        if(Yii::app()->user->getState('instalasi_id') !== Params::INSTALASI_ID_MIKROBIOLOGI) {
            $this->layout = '//layouts/iframe';
        }
        // } 

        // $this->registerReferer();

        if (isset($_GET['RDCpptpasienT'])) {
            $modelRiwayat->attributes = $_GET['RDCpptpasienT'];
        }

        $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        // var_dump($modPendaftaran);die;
        $modAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'create_time DESC'));
        $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), ['order' => 'tglperiksafisik DESC']);
        $modPasienMorb = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA), ['order' => 'pasienmorbiditas_id DESC']);
        $modPasienicd9cm = Pasienicd9cmT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

        $modPermintaanpenunjang = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));



        $modReseptur = ResepturT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = new RDCpptpasienT();
        $ruangan_id = Yii::app()->user->getState("ruangan_id");
        if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_GIZI) {
            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_GIZI;
        } else {
            $kelompok_id = !empty(Yii::app()->user->getState('pegawai_id')->kelompokpegawai_id) ? Yii::app()->user->getState('pegawai_id')->kelompokpegawai_id : '' ;
            $jabatan_id = !empty(Yii::app()->user->getState('pegawai_id')->jabatan_id) ? Yii::app()->user->getState('pegawai_id')->jabatan_id : '' ;
            // var_dump($kelompok_id);die;
            $kelompokpegawai = PegawaiM::model()->findByPk($kelompok_id);
            $jabatan = PegawaiM::model()->findByPk($jabatan_id);
            if (!empty($kelompokpegawai)) {
                if (!empty($jabatan)) {
                    if ($kelompokpegawai == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK) {
                        if ($jabatan == Params::JABATAN_ID_DOKTER_UMUM) {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_DOKTER_UMUM;
                        } else if ($jabatan == Params::JABATAN_ID_DOKTER_SPESIALIS) {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID;
                        } else {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_DOKTER;
                        }
                    } else if ($kelompokpegawai ==  Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
                        $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_PERAWAT;
                    } else if ($kelompokpegawai ==  Params::KELOMPOKPEGAWAI_ID_BIDAN) {
                        $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_PERAWAT;
                    } else if ($kelompokpegawai ==  Params::KELOMPOKPEGAWAI_ID_TENAGA_NONKEPERAWATAN) {
                        if ($jabatan == Params::JABATAN_ID_APOTEKER || $jabatan == Params::JABATAN_ID_KEPALA_APOTEKER) {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_APOTEKER;
                        } else if ($jabatan == Params::JABATAN_ID_FISIOTERAPI || $jabatan == Params::JABATAN_ID_KEPALA_FISIOTERAPI) {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_FISIO;
                        } else {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_LAINNYA;
                        }
                    } else {
                        $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_LAINNYA;
                    }
                } else {
                    $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_LAINNYA;
                }
            } else {
                $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_LAINNYA;
            }
        }
        $modLookup = LookupM::model()->findByAttributes(['lookup_type' => 'cppt_pemberiasuhan', 'lookup_value' => $model->ppa_jenis]);
        $model->ppa_namajenis = !empty($modLookup->lookup_name) ? $modLookup->lookup_name : "-";
        $model->pegawaippa_id = Yii::app()->user->getState('pegawai_id');
        $model->ruangan_id = $ruangan_id;

        if (isset($_GET['cpptpasien_id']) && !empty($_GET['cpptpasien_id'])) {
            $model = RDCpptpasienT::model()->findByPk($_GET['cpptpasien_id']);
            if(empty($model)) {
                $model = new RDCpptpasienT();
            }
            
        } else {
            $model->tanggal_cppt =  date('d M Y H:i:s');
        }
        if(!empty($model)) {
            $model->dpjp_id = $modPendaftaran->pegawai_id;
        }

        if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_REHAB || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_GIZI) {
            $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
            
            if (!empty($modPendaftaran)) {
                $model->dpjp_id = $modPendaftaran->dokterasal_id ?? null;
            }  else {
                $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
                $model->dpjp_id = $modPendaftaran->pegawai_id;
            }
        } else if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD) {
            if (Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_VK) {
                $modPendaftaran = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
                $model->dpjp_id = $modPendaftaran->pegawai_id;
            }
        }

        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
    
        $model->soap_subjective = 
        'Keluhan Utama :'.($modAnamnesa->keluhanutama ?? "-").'<br>'.
        'Keluhan Tambahan :'.($modAnamnesa->keluhantambahan ?? "-").'<br>'.
        'Sejak :'.($modAnamnesa->sejak ?? "-");
                             
 
        $model->soap_objective = 
       'Keadaan Umum :'.($modPemeriksaanFisik->keadaanumum ?? "-").'<br>'.
       'Tekanan Darah :'.($modPemeriksaanFisik->tekanandarah ?? "-").' mmHg <br>'.
       'Detak Nadi :'.($modPemeriksaanFisik->detaknadi ?? "-").' x/Menit <br>'.
       'Denyut Jantung :'.($modPemeriksaanFisik->denyutjantung ?? "-").' ms <br>'.
       'Pernapasan :'.($modPemeriksaanFisik->pernapasan ?? "-").' x/Menit <br>'.
       'Suhu Tubuh :'.($modPemeriksaanFisik->suhutubuh ?? "-").'  C <br>'.
       'Tinggi Badan :'.($modPemeriksaanFisik->tinggibadan_cm ?? "-").'  Cm <br>'.
       'Berat Badan :'.($modPemeriksaanFisik->beratbadan_kg ?? "-").'  Cm';

      

        $model->soap_asesmen = 
        'Keterangan Diagnosa :'.($modPasienMorb->ket_diagnosa ?? "-").'<br>'.
        'Status Diagnosa Pasien :'.($modPasienMorb->statusdiagnosapasien ?? "-").'<br>'.
        'Diagnosa Nama :'.($modPasienMorb->diagnosam->diagnosa_nama ?? "-").'<br>'. 
        'Diagnosa Kode :'.($modPasienMorb->diagnosam->diagnosa_kode ?? "-").'<br>'. 
        'Diagnosa Nama Lainnya :'.($modPasienMorb->diagnosam->diagnosa_namalainnya ?? "-").'<br>'; 
        
        // $modPendaftaran->diagnosa->ket_diagnosa ?? ""  ;
        // $modPendaftaran->diagnosa->statusdiagnosapasien ?? "-";
        // $modPendaftaran->diagnosa->diagnosam->diagnosa_nama ?? "-";
        // $modPendaftaran->diagnosa->diagnosam->diagnosa_kode ?? "-";
        // $modPendaftaran->diagnosa->diagnosam->diagnosa_namalainnya ?? "-";
        
        if (!isset($_GET['cpptpasien_id'])) {
        
            // $model->soap_planning = 
            // 'Nama Diagnosa ICD IX  :'.($modPasienicd9cm->diagnosatindakan->diagnosaicdix_nama ?? "-").'<br>'.
            // 'Diagnosa ICD IX Kode :'.($modPasienicd9cm->diagnosatindakan->diagnosaicdix_kode ?? "-").'<br>'.
            // 'Diagnosa ICD IX Nama Lainnya :'.($modPasienicd9cm->diagnosatindakan->diagnosaicdix_namalainnya ?? "-").'<br>'.          
            // 'Nomor Permintaan Penunjang :'.($modPermintaanpenunjang->permintaanpenunjang->noperminatanpenujang ?? "-").'<br>'.
            // 'Tanggal Permintaan Penunjang :'.($modPermintaanpenunjang->permintaanpenunjang->tglpermintaankepenunjang ?? "-").'<br>'.
            // 'Nama Pemeriksaan RAD  :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanrad->pemeriksaanrad_nama ?? "-").'<br>'.
            // 'Pemeriksaan RAD Nama Lainnya :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanrad->pemeriksaanrad_namalainnya ?? "-").'<br>'.
            // 'Daftar Tindakan RAD Nama Lainnya :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanrad->daftartindakan_nama ?? "-").'<br>'.
            // 'Nama Pemeriksaan LAB  :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanlab->pemeriksaanlab_nama ?? "-").'<br>'.
            // 'Pemeriksaan LAB Nama Lainnya :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanlab->pemeriksaanlab_namalainnya ?? "-").'<br>'.
            // 'Daftar Tindakan LAB Nama Lainnya :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanlab->daftartindakan_nama ?? "-").'<br>'.
    
            // 'Nama Daftar Tindakan :'.($modPermintaanpenunjang->permintaanpenunjang->daftartindakan->daftartindakan_nama ?? "-").'<br>'.
            // 'Nama Komponen Unit :'.($modPermintaanpenunjang->permintaanpenunjang->daftartindakan->komponenunit_nama ?? "-").'<br>'.
            // 'Nama Kategori Unit :'.($modPermintaanpenunjang->permintaanpenunjang->daftartindakan->kategoritindakan_nama ?? "-").'<br>'.
            // 'Tindakan Medis :'.($modPermintaanpenunjang->permintaanpenunjang->daftartindakan->tindakanmedis_nama ?? "-").'<br>'.
            // 'Nama Operasi :'.($modPermintaanpenunjang->permintaanpenunjang->operasi->operasi_nama ?? "-").'<br>'.
            // 'Tanggal Reseptur :'.($modReseptur->tglreseptur ?? "-").'<br>'.
            // 'Nomor Resep :'.($modReseptur->noresep ?? "-").'<br>'.
            // 'Tanggal Resep :'.($modReseptur->penjualanresep->tglresep ?? "-").'<br>'.
            // 'Nama Obat Alkes :'.($modReseptur->penjualanresep->obatalkes->obatalkes_nama ?? "-").'<br>'.
            // 'R KE :'.($modReseptur->penjualanresep->obatalkes->obatalkespasienTs->rke ?? "-").'<br>'.
            // 'Nama Obat Alkes :'.($modReseptur->penjualanresep->obatalkes->obatalkespasienTs->obatalkes_nama ?? "-").'<br>'.
            // 'Etiket :'.($modReseptur->penjualanresep->obatalkes->obatalkespasienTs->etiket ?? "-").'<br>'.
            // 'Keterangan :'.($modReseptur->penjualanresep->obatalkes->obatalkespasienTs->keterangan ?? "-");
        }
      
          

        //  'Pemeriksaan LAB Nama :'.($modPermintaanpenunjang->pemeriksaanlab->pemeriksaanlab_nama ?? "-");
        //  'Pemeriksaan LAB Kode :'.($modPermintaanpenunjang->pemeriksaanlab->pemeriksaanlab_kode ?? "-");
        //  'Pemeriksaan LAB Urutan :'.($modPermintaanpenunjang->pemeriksaanlab->pemeriksaanlab_urutan ?? "-");

        //   $modPendaftaran->kirimkeunitlain->antibiotik_hari ?? "-";
        //   $modPendaftaran->kirimkeunitlain->kelaspelayanan->urutankelas ?? "-";
        //   $modPendaftaran->kirimkeunitlain->kelaspelayanan->kelaspelayanan_namalainnya ?? "-";
        //   $modPendaftaran->kirimkeunitlain->kelaspelayanan->jeniskelas_nama ?? "-";
        //   $modPendaftaran->kirimkeunitlain->kelaspelayanan->kelaspelayanan_nama ?? "-";
        //   $modPendaftaran->diagnosa->diagnosatindakanm->diagnosatindakan_nama ?? "-";
        //   $modPendaftaran->diagnosa->diagnosatindakanm->diagnosatindakan_namalainnya ?? "-";
        //   $modPendaftaran->diagnosa->diagnosatindakanm->diagnosatindakan_kode ?? "-";
        //   $modPendaftaran->hasilpemeriksaanlab->statusperiksahasil ?? "-";
        //   $modPendaftaran->hasilpemeriksaanlab->catatanlabklinik ?? "-";
        //   $modPendaftaran->hasilpemeriksaanlab->statushasilpemeriksaan ?? "-";
        //   $modPendaftaran->tindakanpelayanan->daftartindakan->daftartindakan_nama ?? "-";
        //   $modPendaftaran->tindakanpelayanan->tgl_tindakan ?? "-";
        //   $modPendaftaran->tindakanpelayanan->jeniskasuspenyakit->jeniskasuspenyakit_nama ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->pemeriksaanlab_nama ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->pemeriksaanlab_kode ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->pemeriksaanlab_namalainnya ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_kode ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_namalainnya ?? "-";
        //   $modPendaftaran-> resepturTs->tglreseptur ??"-";
        //   $modPendaftaran-> resepturTs->noresep ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->r ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->rke ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->permintaan_reseptur ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->jmlkemasan_reseptur ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->kekuatan_reseptur ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->satuankekuatan ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->qty_reseptur ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->etiket ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->racikan->racikan_nama ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->racikan->racikan_singkatan ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_barcode ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_kode ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_nama ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_namalain ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_golongan ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_kategori ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_kadarobat ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->formularium ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->kemasanbesar ??"-";
        //   $modPendaftaran->hasilpemeriksaanradTs->hasilexpertise ?? "-";
        //   $modPendaftaran->hasilpemeriksaanradTs->kesan_hasilrad ?? "-";
        //   $modPendaftaran->hasilpemeriksaanradTs->kesimpulan_hasilrad ?? "-";
        //   $modPendaftaran->hasilpemeriksaanradTs->pemeriksaanrad->pemeriksaanrad_nama ?? "-" ;  
        //   $modPendaftaran->hasilpemeriksaanradTs->pemeriksaanrad->pemeriksaanrad_namalainnya ?? "-" ;  
        //   $modPendaftaran->hasilpemeriksaanradTs->pemeriksaanrad->jenispemeriksaanrad_nama ?? "-" ;  
        //   $modPendaftaran->hasilpemeriksaanradTs->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama ?? "-";
        //   $modPendaftaran->hasilpemeriksaanradTs->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_namalain ?? "-";
          
          

        $modAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);

        // Kosongin semua pengisian SOAP
        // if (empty($model->cpptpasien_id)) {
        //     $morbi = new PasienmorbiditasT;
        //     $morbi->pendaftaran_id = $model->pendaftaran_id;
        //     $model->attributes = $morbi->cekSoapi();
        // }

        if (isset($modAdmisi)) {

            if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RJ || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_PI || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_REHAB || in_array(Yii::app()->user->getState('instalasi_id'), Params::INSTALASI_ID_RI_ARR)) {
                // $model->dpjp_id = $modAdmisi->dokterpenerima_id;
                $model->dpjp_id = $modAdmisi->pegawai_id;
               $model->supervisi_id = $modAdmisi->pegawai_id;
                
            }
        } else {
            $model->dpjp_id = $modPendaftaran->pegawai_id;
           $model->supervisi_id = $modPendaftaran->pegawai_id;
            
        }

        if(isset($_GET['pasienmasukpenunjang_id'])) {
            $modPenunjang = PasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
            if(!empty($modPenunjang)) {
                $model->dpjp_id = $modPenunjang->pegawai_id;
                $modPendaftaran->pegawai_id = $modPenunjang->pegawai_id;
            }
        }

        if(isset($_GET['pasienadmisi_id'])) {
            $modPendaftaran->pegawai_id = $modPendaftaran->admisi->pegawai_id;
        }
        

        if (isset($_POST['RDCpptpasienT'])) {
            // echo '<pre>';var_dump($_POST);die;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                // echo "<pre>";
                // var_dump($_POST['RDCpptpasienT']['pegawaippa_id']);die;
                $model->attributes = $_POST['RDCpptpasienT'];
                $model->tanggal_cppt = (!empty($_POST['RDCpptpasienT']['tanggal_cppt']) ? MyFormatter::formatDateTimeForDb($_POST['RDCpptpasienT']['tanggal_cppt']) : null);
                $model->isverifikasidpjp = false;
                $model->isverifikasisupervisi = false;

                // Cek Riwayatnya ada atau enggak
                // $daftar1 = PendaftaranT::model()->findByPk($pendaftaran_id);
                // $modelRiwayat->pasien_id = $daftar1->pasien_id;
                // $data = $modelRiwayat->searchRiwayat();
                // echo '<pre>';var_dump(empty($_POST['RDCpptpasienT']['pegawaippa_id'] == $_POST['RDCpptpasienT']['dpjp_id']));die;
                // var_dump($data->data.$_POST['RDCpptpasienT']['pegawaippa_id']. $_POST['RDCpptpasienT']['dpjp_id'] );die;
                // if (empty($data->data)) {
                //     if ($_POST['RDCpptpasienT']['pegawaippa_id'] == $_POST['RDCpptpasienT']['dpjp_id']) {
                //         //make new anamnesa
                //         $modAnamnesa = new AnamnesaT;
                //         $modAnamnesa->pendaftaran_id =  $_POST['RDCpptpasienT']['pendaftaran_id'];
                //         $modAnamnesa->pasien_id =  $_POST['RDCpptpasienT']['pasien_id'];
                //         $modAnamnesa->pasienadmisi_id =  $_POST['RDCpptpasienT']['pasienadmisi_id'];
                //         $modAnamnesa->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                //         $modAnamnesa->supervisi_id = $_POST['RDCpptpasienT']['dpjp_id'];
                //         $modAnamnesa->keluhanutama = $_POST['RDCpptpasienT']['soap_subjective'];
                //         $modAnamnesa->create_time = date('Y-m-d H:i:s');
                //         $modAnamnesa->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                //         $modAnamnesa->create_ruangan = Yii::app()->user->getState("ruangan_id");


                //         //Make new PasienmorbiditasT
                //         $daftar1 = PendaftaranT::model()->findByPk($_POST['RDCpptpasienT']['pendaftaran_id']);
                //         $modPasienMorb = new PasienmorbiditasT;
                //         $modPasienMorb->jeniskasuspenyakit_id = $_POST['RDCpptpasienT']['ppa_jenis'];
                //         $modPasienMorb->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];

                //         $modPasienMorb->ruangan_id = Yii::app()->user->getState("ruangan_id");
                //         $modPasienMorb->kelompokumur_id = $daftar1->kelompokumur_id;
                //         $modPasienMorb->diagnosa_id = 20652;
                //         $modPasienMorb->pasien_id = $_POST['RDCpptpasienT']['pasien_id'];
                //         $modPasienMorb->kelompokdiagnosa_id = 2;
                //         $modPasienMorb->golonganumur_id = $modPasienMorb->kelompokumur_id;
                //         $modPasienMorb->pendaftaran_id = $_POST['RDCpptpasienT']['pendaftaran_id'];
                //         $modPasienMorb->ket_diagnosa = $_POST['RDCpptpasienT']['soap_asesmen'];
                //         $modPasienMorb->tglmorbiditas = Myformatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
                //         $modPasienMorb->kasusdiagnosa = 'KASUS BARU';
                //         $modPasienMorb->save();

                //         // if (!empty($modPasienMorb)) {
                //         //     $modPasienMorb->ket_diagnosa = $_POST['RDCpptpasienT']['soap_asesmen'];
                //         //     $modPasienMorb->update();
                //         // }

                //         //New PemeriksaanfisikT
                //         $modPemeriksaanFisik = new PemeriksaanfisikT;
                //         $modPemeriksaanFisik->pendaftaran_id = $_POST['RDCpptpasienT']['pendaftaran_id'];
                //         $modPemeriksaanFisik->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                //         $modPemeriksaanFisik->pasienadmisi_id = $_POST['RDCpptpasienT']['pasienadmisi_id'];
                //         $modPemeriksaanFisik->supervisi_id = $_POST['RDCpptpasienT']['dpjp_id'];
                //         $modPemeriksaanFisik->pasien_id = $_POST['RDCpptpasienT']['pasien_id'];
                //         $modPemeriksaanFisik->tglperiksafisik = Myformatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
                //         $modPemeriksaanFisik->keadaanumum = $_POST['RDCpptpasienT']['soap_objective'];
                //         $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
                //         $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                //         $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState("ruangan_id");
                //     } else {
                //         //New anamnesa
                //         $modAnamnesa = new AnamnesaT;
                //         $modAnamnesa->pendaftaran_id =  $_POST['RDCpptpasienT']['pendaftaran_id'];
                //         $modAnamnesa->pasien_id =  $_POST['RDCpptpasienT']['pasien_id'];
                //         $modAnamnesa->pasienadmisi_id =  $_POST['RDCpptpasienT']['pasienadmisi_id'];
                //         $modAnamnesa->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                //         $modAnamnesa->keluhanutama = $_POST['RDCpptpasienT']['soap_subjective'];
                //         $modAnamnesa->create_time = date('Y-m-d H:i:s');
                //         $modAnamnesa->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                //         $modAnamnesa->create_ruangan = Yii::app()->user->getState("ruangan_id");

                //         //New PemeriksaanfisikT
                //         $modPemeriksaanFisik = new PemeriksaanfisikT;
                //         $modPemeriksaanFisik->pendaftaran_id = $_POST['RDCpptpasienT']['pendaftaran_id'];
                //         $modPemeriksaanFisik->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                //         $modPemeriksaanFisik->pasienadmisi_id = $_POST['RDCpptpasienT']['pasienadmisi_id'];
                //         $modPemeriksaanFisik->pasien_id = $_POST['RDCpptpasienT']['pasien_id'];
                //         $modPemeriksaanFisik->tglperiksafisik = Myformatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
                //         $modPemeriksaanFisik->keadaanumum = $_POST['RDCpptpasienT']['soap_objective'];
                //         $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
                //         $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                //         $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState("ruangan_id");
                //     }
                // } else {
                //     //New anamnesa
                //     $modAnamnesa = new AnamnesaT;
                //     $modAnamnesa->pendaftaran_id =  $_POST['RDCpptpasienT']['pendaftaran_id'];
                //     $modAnamnesa->pasien_id =  $_POST['RDCpptpasienT']['pasien_id'];
                //     $modAnamnesa->pasienadmisi_id =  $_POST['RDCpptpasienT']['pasienadmisi_id'];
                //     $modAnamnesa->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                //     $modAnamnesa->supervisi_id = isset($_POST['RDCpptpasienT']['supervisi_id']) ? $_POST['RDCpptpasienT']['supervisi_id'] : '';
                //     $modAnamnesa->keluhanutama = isset($_POST['RDCpptpasienT']['soap_subjective']) ? $_POST['RDCpptpasienT']['soap_subjective'] : '';
                //     $modAnamnesa->create_time = date('Y-m-d H:i:s');
                //     $modAnamnesa->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                //     $modAnamnesa->create_ruangan = Yii::app()->user->getState("ruangan_id");

                //     //New PemeriksaanfisikT
                //     $modPemeriksaanFisik = new PemeriksaanfisikT;
                //     $modPemeriksaanFisik->pendaftaran_id = $_POST['RDCpptpasienT']['pendaftaran_id'];
                //     $modPemeriksaanFisik->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                //     $modPemeriksaanFisik->pasienadmisi_id = $_POST['RDCpptpasienT']['pasienadmisi_id'];
                //     $modPemeriksaanFisik->supervisi_id = isset($_POST['RDCpptpasienT']['supervisi_id']) ? $_POST['RDCpptpasienT']['supervisi_id'] : '';
                //     $modPemeriksaanFisik->pasien_id = $_POST['RDCpptpasienT']['pasien_id'];
                //     $modPemeriksaanFisik->tglperiksafisik = Myformatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
                //     $modPemeriksaanFisik->keadaanumum = $_POST['RDCpptpasienT']['soap_objective'];
                //     $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
                //     $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                //     $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState("ruangan_id");
                // }

                

                if (!empty($model->cpptpasien_id)) {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                } else {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                // // echo "<pre>";
                // var_dump($modAnamnesa);
                // die;
                // // var_dump($modAnamnesa->save());
                // // die;
                if ($model->save()) {
                    $this->tersimpan = true;
                    $p = PendaftaranT::model()->findByPk($model->pendaftaran_id);
                    if(!empty($modAnamnesa)) {
                        $modAnamnesa->is_cppt = true;
                        $modAnamnesa->save();
                    }
                    if(!empty($modPemeriksaanFisik)) {
                        $modPemeriksaanFisik->is_cppt = true;
                        $modPemeriksaanFisik->save();
                    }


                    if (!empty($p)) {
                        $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
                    }
                } else {
                    $this->tersimpan = false;
                }

                if ($this->tersimpan == true) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                    $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id, 'cpptpasien_id' => $model->cpptpasien_id,'sukses' => 1));
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan!");
                }
            } catch (Exception $ex) {
                // var_dump($ex->getMessage());
                // die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'riwayatcppt-t-grid') {
                $this->renderPartial($this->path_view.'_riwayatCPPT', array('modelRiwayat'=>$modelRiwayat,'modPendaftaran'=>$modPendaftaran));
                Yii::app()->end();
            }
        }

        // echo "<pre>";
        // var_dump($model);die;
        $this->render($this->path_view . 'index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modPenunjang' => $modPenunjang,
            'model' => $model,
            'modelRiwayat' => $modelRiwayat
        ));
    }




    public function actionIndexFA($pendaftaran_id, $frame = 0)
    {
        $modelRiwayat = new RDCpptpasienT();
        $modelRiwayat->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modelRiwayat->unsetAttributes();


        // if (!empty($_GET['frame'])) {
        // $this->layout = '//layouts/column1';
        // } 

        // $this->registerReferer();

        if (isset($_GET['RDCpptpasienT'])) {
            $modelRiwayat->attributes = $_GET['RDCpptpasienT'];
        }

        $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        // var_dump($modPendaftaran);die;
        $modAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPasienMorb = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPasienicd9cm = Pasienicd9cmT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPermintaanpenunjang = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modReseptur = ResepturT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = new RDCpptpasienT();
        $ruangan_id = Yii::app()->user->getState("ruangan_id");
        if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_GIZI) {
            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_GIZI;
        } else {
            $kelompokpegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->kelompokpegawai_id;
            $jabatan = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->jabatan_id;
            if (!empty($kelompokpegawai)) {
                if (!empty($jabatan)) {
                    if ($kelompokpegawai == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK) {
                        if ($jabatan == Params::JABATAN_ID_DOKTER_UMUM) {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_DOKTER_UMUM;
                        } else if ($jabatan == Params::JABATAN_ID_DOKTER_SPESIALIS) {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID;
                        } else {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_DOKTER;
                        }
                    } else if ($kelompokpegawai ==  Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
                        $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_PERAWAT;
                    } else if ($kelompokpegawai ==  Params::KELOMPOKPEGAWAI_ID_BIDAN) {
                        $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_PERAWAT;
                    } else if ($kelompokpegawai ==  Params::KELOMPOKPEGAWAI_ID_TENAGA_NONKEPERAWATAN) {
                        if ($jabatan == Params::JABATAN_ID_APOTEKER || $jabatan == Params::JABATAN_ID_KEPALA_APOTEKER) {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_APOTEKER;
                        } else if ($jabatan == Params::JABATAN_ID_FISIOTERAPI || $jabatan == Params::JABATAN_ID_KEPALA_FISIOTERAPI) {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_FISIO;
                        } else {
                            $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_LAINNYA;
                        }
                    } else {
                        $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_LAINNYA;
                    }
                } else {
                    $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_LAINNYA;
                }
            } else {
                $model->ppa_jenis = Params::CPPT_JENIS_PPA_ID_LAINNYA;
            }
        }
        $modLookup = LookupM::model()->findByAttributes(['lookup_type' => 'cppt_pemberiasuhan', 'lookup_value' => $model->ppa_jenis]);
        $model->ppa_namajenis = !empty($modLookup->lookup_name) ? $modLookup->lookup_name : "-";
        $model->pegawaippa_id = Yii::app()->user->getState('pegawai_id');

        if (isset($_GET['cpptpasien_id']) && !empty($_GET['cpptpasien_id'])) {
            $model = RDCpptpasienT::model()->findByPk($_GET['cpptpasien_id']);
            
        } else {
            $model->tanggal_cppt =  date('d M Y H:i:s');
        }
        $model->dpjp_id = $modPendaftaran->pegawai_id;

        if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_REHAB || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_GIZI) {
            $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
            $model->dpjp_id = $modPendaftaran->dokterasal_id;
        } else if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD) {
            if (Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_VK) {
                $modPendaftaran = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
                $model->dpjp_id = $modPendaftaran->pegawai_id;
            }
        }

        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
    
        $model->soap_subjective = 
        'Keluhan Utama :'.($modAnamnesa->keluhanutama ?? "-").'<br>'.
        'Keluhan Tambahan :'.($modAnamnesa->keluhantambahan ?? "-").'<br>'.
        'Sejak :'.($modAnamnesa->sejak ?? "-");
                             
 
        $model->soap_objective = 
       'Keadaan Umum :'.($modPemeriksaanFisik->keadaanumum ?? "-").'<br>'.
       'Tekanan Darah :'.($modPemeriksaanFisik->tekanandarah ?? "-").' mmHg <br>'.
       'Detak Nadi :'.($modPemeriksaanFisik->detaknadi ?? "-").' x/Menit <br>'.
       'Denyut Jantung :'.($modPemeriksaanFisik->denyutjantung ?? "-").' ms <br>'.
       'Pernapasan :'.($modPemeriksaanFisik->pernapasan ?? "-").' x/Menit <br>'.
       'Suhu Tubuh :'.($modPemeriksaanFisik->suhutubuh ?? "-").'  C <br>'.
       'Tinggi Badan :'.($modPemeriksaanFisik->tinggibadan_cm ?? "-").'  Cm <br>'.
       'Berat Badan :'.($modPemeriksaanFisik->beratbadan_kg ?? "-").'  Cm';

      

        $model->soap_asesmen = 
        'Keterangan Diagnosa :'.($modPasienMorb->ket_diagnosa ?? "-").'<br>'.
        'Status Diagnosa Pasien :'.($modPasienMorb->statusdiagnosapasien ?? "-").'<br>'.
        'Diagnosa Nama :'.($modPasienMorb->diagnosam->diagnosa_nama ?? "-").'<br>'. 
        'Diagnosa Kode :'.($modPasienMorb->diagnosam->diagnosa_kode ?? "-").'<br>'. 
        'Diagnosa Nama Lainnya :'.($modPasienMorb->diagnosam->diagnosa_namalainnya ?? "-").'<br>'; 
        
        // $modPendaftaran->diagnosa->ket_diagnosa ?? ""  ;
        // $modPendaftaran->diagnosa->statusdiagnosapasien ?? "-";
        // $modPendaftaran->diagnosa->diagnosam->diagnosa_nama ?? "-";
        // $modPendaftaran->diagnosa->diagnosam->diagnosa_kode ?? "-";
        // $modPendaftaran->diagnosa->diagnosam->diagnosa_namalainnya ?? "-";
        
 
        $model->soap_planning = 
        'Nama Diagnosa ICD IX  :'.($modPasienicd9cm->diagnosatindakan->diagnosaicdix_nama ?? "-").'<br>'.
        'Diagnosa ICD IX Kode :'.($modPasienicd9cm->diagnosatindakan->diagnosaicdix_kode ?? "-").'<br>'.
        'Diagnosa ICD IX Nama Lainnya :'.($modPasienicd9cm->diagnosatindakan->diagnosaicdix_namalainnya ?? "-").'<br>'.          
        'Nomor Permintaan Penunjang :'.($modPermintaanpenunjang->permintaanpenunjang->noperminatanpenujang ?? "-").'<br>'.
        'Tanggal Permintaan Penunjang :'.($modPermintaanpenunjang->permintaanpenunjang->tglpermintaankepenunjang ?? "-").'<br>'.
        'Nama Pemeriksaan RAD  :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanrad->pemeriksaanrad_nama ?? "-").'<br>'.
        'Pemeriksaan RAD Nama Lainnya :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanrad->pemeriksaanrad_namalainnya ?? "-").'<br>'.
        'Daftar Tindakan RAD Nama Lainnya :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanrad->daftartindakan_nama ?? "-").'<br>'.
        'Nama Pemeriksaan LAB  :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanlab->pemeriksaanlab_nama ?? "-").'<br>'.
        'Pemeriksaan LAB Nama Lainnya :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanlab->pemeriksaanlab_namalainnya ?? "-").'<br>'.
        'Daftar Tindakan LAB Nama Lainnya :'.($modPermintaanpenunjang->permintaanpenunjang->pemeriksaanlab->daftartindakan_nama ?? "-").'<br>'.

       'Nama Daftar Tindakan :'.($modPermintaanpenunjang->permintaanpenunjang->daftartindakan->daftartindakan_nama ?? "-").'<br>'.
       'Nama Komponen Unit :'.($modPermintaanpenunjang->permintaanpenunjang->daftartindakan->komponenunit_nama ?? "-").'<br>'.
       'Nama Kategori Unit :'.($modPermintaanpenunjang->permintaanpenunjang->daftartindakan->kategoritindakan_nama ?? "-").'<br>'.
      // 'Nama Kelompok Tindakan :'.($modPermintaanpenunjang->permintaanpenunjang->daftartindakan->kelompoktindakan_nama ?? "-").'<br>'.
       'Tindakan Medis :'.($modPermintaanpenunjang->permintaanpenunjang->daftartindakan->tindakanmedis_nama ?? "-").'<br>'.
       'Nama Operasi :'.($modPermintaanpenunjang->permintaanpenunjang->operasi->operasi_nama ?? "-").'<br>'.
      // 'Operasi Nama Lainnya :'.($modPermintaanpenunjang->permintaanpenunjang->operasi->operasi_namalainnya ?? "-").'<br>'.

       'Tanggal Reseptur :'.($modReseptur->tglreseptur ?? "-").'<br>'.
       'Nomor Resep :'.($modReseptur->noresep ?? "-").'<br>'.
       'Tanggal Resep :'.($modReseptur->penjualanresep->tglresep ?? "-").'<br>'.
       'Nama Obat Alkes :'.($modReseptur->penjualanresep->obatalkes->obatalkes_nama ?? "-").'<br>'.
      // 'Kadar Obat Alkes :'.($modReseptur->penjualanresep->obatalkes->obatalkes_kadarobat ?? "-").'<br>'.
     //  'Kekuatan :'.($modReseptur->penjualanresep->obatalkes->kekuatan ?? "-").'<br>'.
      // 'Satuan Kekuatan :'.($modReseptur->penjualanresep->obatalkes->satuankekuatan ?? "-").'<br>'.
      // 'Tangal Kadaluarsa :'.($modReseptur->penjualanresep->obatalkes->tglkadaluarsa ?? "-").'<br>'.
       'R KE :'.($modReseptur->penjualanresep->obatalkes->obatalkespasienTs->rke ?? "-").'<br>'.
      // 'Signa Obat Alkes :'.($modReseptur->penjualanresep->obatalkes->obatalkespasienTs->signa_oa ?? "-").'<br>'.
       'Nama Obat Alkes :'.($modReseptur->penjualanresep->obatalkes->obatalkespasienTs->obatalkes_nama ?? "-").'<br>'.
      // 'Kategori Obat Alkes :'.($modReseptur->penjualanresep->obatalkes->obatalkespasienTs->obatalkes_kategori ?? "-").'<br>'.
       'Etiket :'.($modReseptur->penjualanresep->obatalkes->obatalkespasienTs->etiket ?? "-").'<br>'.
       'Keterangan :'.($modReseptur->penjualanresep->obatalkes->obatalkespasienTs->keterangan ?? "-");
       
      // 'No. Resep Resep:'.($modReseptur->penjualanresep->noresep ?? "-").'<br>'.

       
       // 'No. Resep Resep:'.($modReseptur->penjualanresep->noresep ?? "-").'<br>'.

        
        
      
          

        //  'Pemeriksaan LAB Nama :'.($modPermintaanpenunjang->pemeriksaanlab->pemeriksaanlab_nama ?? "-");
        //  'Pemeriksaan LAB Kode :'.($modPermintaanpenunjang->pemeriksaanlab->pemeriksaanlab_kode ?? "-");
        //  'Pemeriksaan LAB Urutan :'.($modPermintaanpenunjang->pemeriksaanlab->pemeriksaanlab_urutan ?? "-");

        //   $modPendaftaran->kirimkeunitlain->antibiotik_hari ?? "-";
        //   $modPendaftaran->kirimkeunitlain->kelaspelayanan->urutankelas ?? "-";
        //   $modPendaftaran->kirimkeunitlain->kelaspelayanan->kelaspelayanan_namalainnya ?? "-";
        //   $modPendaftaran->kirimkeunitlain->kelaspelayanan->jeniskelas_nama ?? "-";
        //   $modPendaftaran->kirimkeunitlain->kelaspelayanan->kelaspelayanan_nama ?? "-";
        //   $modPendaftaran->diagnosa->diagnosatindakanm->diagnosatindakan_nama ?? "-";
        //   $modPendaftaran->diagnosa->diagnosatindakanm->diagnosatindakan_namalainnya ?? "-";
        //   $modPendaftaran->diagnosa->diagnosatindakanm->diagnosatindakan_kode ?? "-";
        //   $modPendaftaran->hasilpemeriksaanlab->statusperiksahasil ?? "-";
        //   $modPendaftaran->hasilpemeriksaanlab->catatanlabklinik ?? "-";
        //   $modPendaftaran->hasilpemeriksaanlab->statushasilpemeriksaan ?? "-";
        //   $modPendaftaran->tindakanpelayanan->daftartindakan->daftartindakan_nama ?? "-";
        //   $modPendaftaran->tindakanpelayanan->tgl_tindakan ?? "-";
        //   $modPendaftaran->tindakanpelayanan->jeniskasuspenyakit->jeniskasuspenyakit_nama ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->pemeriksaanlab_nama ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->pemeriksaanlab_kode ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->pemeriksaanlab_namalainnya ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_kode ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama ?? "-";
        //   $modPendaftaran->tindakanpelayanan->detailhasilpemeriksaanlab->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_namalainnya ?? "-";
        //   $modPendaftaran-> resepturTs->tglreseptur ??"-";
        //   $modPendaftaran-> resepturTs->noresep ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->r ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->rke ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->permintaan_reseptur ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->jmlkemasan_reseptur ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->kekuatan_reseptur ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->satuankekuatan ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->qty_reseptur ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->etiket ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->racikan->racikan_nama ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->racikan->racikan_singkatan ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_barcode ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_kode ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_nama ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_namalain ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_golongan ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_kategori ?? "-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->obatalkes_kadarobat ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->formularium ??"-";
        //   $modPendaftaran-> resepturTs->detailresep->obatalkes->kemasanbesar ??"-";
        //   $modPendaftaran->hasilpemeriksaanradTs->hasilexpertise ?? "-";
        //   $modPendaftaran->hasilpemeriksaanradTs->kesan_hasilrad ?? "-";
        //   $modPendaftaran->hasilpemeriksaanradTs->kesimpulan_hasilrad ?? "-";
        //   $modPendaftaran->hasilpemeriksaanradTs->pemeriksaanrad->pemeriksaanrad_nama ?? "-" ;  
        //   $modPendaftaran->hasilpemeriksaanradTs->pemeriksaanrad->pemeriksaanrad_namalainnya ?? "-" ;  
        //   $modPendaftaran->hasilpemeriksaanradTs->pemeriksaanrad->jenispemeriksaanrad_nama ?? "-" ;  
        //   $modPendaftaran->hasilpemeriksaanradTs->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama ?? "-";
        //   $modPendaftaran->hasilpemeriksaanradTs->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_namalain ?? "-";
          
          

        $modAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);

        // Kosongin semua pengisian SOAP
        // if (empty($model->cpptpasien_id)) {
        //     $morbi = new PasienmorbiditasT;
        //     $morbi->pendaftaran_id = $model->pendaftaran_id;
        //     $model->attributes = $morbi->cekSoapi();
        // }

        if (isset($modAdmisi)) {

            if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RJ || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_PI || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_REHAB) {
                // $model->dpjp_id = $modAdmisi->dokterpenerima_id;
                $model->dpjp_id = $modAdmisi->pegawai_id;
               $model->supervisi_id = $modAdmisi->pegawai_id;
                
            }
        } else {
            $model->dpjp_id = $modPendaftaran->pegawai_id;
           $model->supervisi_id = $modPendaftaran->pegawai_id;
            
        }
        
       

        if (isset($_POST['RDCpptpasienT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {
                // echo "<pre>";
                // var_dump($_POST['RDCpptpasienT']['pegawaippa_id']);die;
                $model->attributes = $_POST['RDCpptpasienT'];
                $model->tanggal_cppt = (!empty($_POST['RDCpptpasienT']['tanggal_cppt']) ? MyFormatter::formatDateTimeForDb($_POST['RDCpptpasienT']['tanggal_cppt']) : null);
                $model->isverifikasidpjp = false;
                $model->isverifikasisupervisi = false;

                // Cek Riwayatnya ada atau enggak
                $daftar1 = PendaftaranT::model()->findByPk($pendaftaran_id);
                $modelRiwayat->pasien_id = $daftar1->pasien_id;
                $data = $modelRiwayat->searchRiwayat();
                // var_dump($data->data.$_POST['RDCpptpasienT']['pegawaippa_id']. $_POST['RDCpptpasienT']['dpjp_id'] );die;
                if (empty($data->data)) {
                    if ($_POST['RDCpptpasienT']['pegawaippa_id'] == $_POST['RDCpptpasienT']['dpjp_id']) {
                        //make new anamnesa
                        $modAnamnesa = new AnamnesaT;
                        $modAnamnesa->pendaftaran_id =  $_POST['RDCpptpasienT']['pendaftaran_id'];
                        $modAnamnesa->pasien_id =  $_POST['RDCpptpasienT']['pasien_id'];
                        $modAnamnesa->pasienadmisi_id =  $_POST['RDCpptpasienT']['pasienadmisi_id'];
                        $modAnamnesa->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                       // $modAnamnesa->supervisi_id = $_POST['RDCpptpasienT']['supervisi_id'];
                        $modAnamnesa->keluhanutama = $_POST['RDCpptpasienT']['soap_subjective'];
                        $modAnamnesa->create_time = date('Y-m-d H:i:s');
                        $modAnamnesa->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                        $modAnamnesa->create_ruangan = Yii::app()->user->getState("ruangan_id");


                        //Make new PasienmorbiditasT
                        $daftar1 = PendaftaranT::model()->findByPk($_POST['RDCpptpasienT']['pendaftaran_id']);
                        $modPasienMorb = new PasienmorbiditasT;
                        $modPasienMorb->jeniskasuspenyakit_id = $_POST['RDCpptpasienT']['ppa_jenis'];
                        $modPasienMorb->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                        //$modPasienMorb->supervisi_id = $_POST['RDCpptpasienT']['supervisi_id'];
                        $modPasienMorb->ruangan_id = Yii::app()->user->getState("ruangan_id");
                        $modPasienMorb->kelompokumur_id = $daftar1->kelompokumur_id;
                        $modPasienMorb->diagnosa_id = 20652;
                        $modPasienMorb->pasien_id = $_POST['RDCpptpasienT']['pasien_id'];
                        $modPasienMorb->kelompokdiagnosa_id = 2;
                        $modPasienMorb->golonganumur_id = $modPasienMorb->kelompokumur_id;
                        $modPasienMorb->pendaftaran_id = $_POST['RDCpptpasienT']['pendaftaran_id'];
                        $modPasienMorb->ket_diagnosa = $_POST['RDCpptpasienT']['soap_asesmen'];
                        $modPasienMorb->tglmorbiditas = Myformatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
                        $modPasienMorb->kasusdiagnosa = 'KASUS BARU';
                        $modPasienMorb->save();

                        // if (!empty($modPasienMorb)) {
                        //     $modPasienMorb->ket_diagnosa = $_POST['RDCpptpasienT']['soap_asesmen'];
                        //     $modPasienMorb->update();
                        // }

                        //New PemeriksaanfisikT
                        $modPemeriksaanFisik = new PemeriksaanfisikT;
                        $modPemeriksaanFisik->pendaftaran_id = $_POST['RDCpptpasienT']['pendaftaran_id'];
                        $modPemeriksaanFisik->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                        $modPemeriksaanFisik->pasienadmisi_id = $_POST['RDCpptpasienT']['pasienadmisi_id'];
                      //  $modPemeriksaanFisik->supervisi_id = $_POST['RDCpptpasienT']['supervisi_id'];
                        $modPemeriksaanFisik->pasien_id = $_POST['RDCpptpasienT']['pasien_id'];
                        $modPemeriksaanFisik->tglperiksafisik = Myformatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
                        $modPemeriksaanFisik->keadaanumum = $_POST['RDCpptpasienT']['soap_objective'];
                        $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
                        $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                        $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState("ruangan_id");
                    } else {
                        //New anamnesa
                        $modAnamnesa = new AnamnesaT;
                        $modAnamnesa->pendaftaran_id =  $_POST['RDCpptpasienT']['pendaftaran_id'];
                        $modAnamnesa->pasien_id =  $_POST['RDCpptpasienT']['pasien_id'];
                        $modAnamnesa->pasienadmisi_id =  $_POST['RDCpptpasienT']['pasienadmisi_id'];
                        $modAnamnesa->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                        $modAnamnesa->keluhanutama = $_POST['RDCpptpasienT']['soap_subjective'];
                        $modAnamnesa->create_time = date('Y-m-d H:i:s');
                        $modAnamnesa->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                        $modAnamnesa->create_ruangan = Yii::app()->user->getState("ruangan_id");

                        //New PemeriksaanfisikT
                        $modPemeriksaanFisik = new PemeriksaanfisikT;
                        $modPemeriksaanFisik->pendaftaran_id = $_POST['RDCpptpasienT']['pendaftaran_id'];
                        $modPemeriksaanFisik->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                        $modPemeriksaanFisik->pasienadmisi_id = $_POST['RDCpptpasienT']['pasienadmisi_id'];
                        $modPemeriksaanFisik->pasien_id = $_POST['RDCpptpasienT']['pasien_id'];
                        $modPemeriksaanFisik->tglperiksafisik = Myformatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
                        $modPemeriksaanFisik->keadaanumum = $_POST['RDCpptpasienT']['soap_objective'];
                        $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
                        $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                        $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState("ruangan_id");
                    }
                } else {
                    //New anamnesa
                    $modAnamnesa = new AnamnesaT;
                    $modAnamnesa->pendaftaran_id =  $_POST['RDCpptpasienT']['pendaftaran_id'];
                    $modAnamnesa->pasien_id =  $_POST['RDCpptpasienT']['pasien_id'];
                    $modAnamnesa->pasienadmisi_id =  $_POST['RDCpptpasienT']['pasienadmisi_id'];
                    $modAnamnesa->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                    //$modAnamnesa->supervisi_id = $_POST['RDCpptpasienT']['supervisi_id'];
                    $modAnamnesa->keluhanutama = $_POST['RDCpptpasienT']['soap_subjective'];
                    $modAnamnesa->create_time = date('Y-m-d H:i:s');
                    $modAnamnesa->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                    $modAnamnesa->create_ruangan = Yii::app()->user->getState("ruangan_id");

                    //New PemeriksaanfisikT
                    $modPemeriksaanFisik = new PemeriksaanfisikT;
                    $modPemeriksaanFisik->pendaftaran_id = $_POST['RDCpptpasienT']['pendaftaran_id'];
                    $modPemeriksaanFisik->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                    $modPemeriksaanFisik->pasienadmisi_id = $_POST['RDCpptpasienT']['pasienadmisi_id'];
                   // $modPemeriksaanFisik->supervisi_id = $_POST['RDCpptpasienT']['supervisi_id'];
                    $modPemeriksaanFisik->pasien_id = $_POST['RDCpptpasienT']['pasien_id'];
                    $modPemeriksaanFisik->tglperiksafisik = Myformatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
                    $modPemeriksaanFisik->keadaanumum = $_POST['RDCpptpasienT']['soap_objective'];
                    $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
                    $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->getState("pegawai_id");
                    $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState("ruangan_id");
                }

                // die;

                // //make new anamnesa
                // $modAnamnesa = new AnamnesaT;
                // $modAnamnesa->pendaftaran_id =  $_POST['RDCpptpasienT']['pendaftaran_id'];
                // $modAnamnesa->pasien_id =  $_POST['RDCpptpasienT']['pasien_id'];
                // $modAnamnesa->pasienadmisi_id =  $_POST['RDCpptpasienT']['pasienadmisi_id'];
                // $modAnamnesa->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                // $modAnamnesa->keluhanutama = $_POST['RDCpptpasienT']['soap_subjective'];
                // $modAnamnesa->save();
                // // if (!empty($modAnamnesa)) {
                // //     $modAnamnesa->keluhanutama = $_POST['RDCpptpasienT']['soap_subjective'];
                // //     $modAnamnesa->update();
                // // }

                // //Make new PasienmorbiditasT
                // $daftar1 = PendaftaranT::model()->findByPk($_POST['RDCpptpasienT']['pendaftaran_id']);
                // $modPasienMorb = new PasienmorbiditasT;
                // $modPasienMorb->jeniskasuspenyakit_id = $_POST['RDCpptpasienT']['ppa_jenis'];
                // $modPasienMorb->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                // $modPasienMorb->ruangan_id = Yii::app()->user->getState("ruangan_id");
                // $modPasienMorb->kelompokumur_id = $daftar1->kelompokumur_id;
                // $modPasienMorb->diagnosa_id = 20652;
                // $modPasienMorb->pasien_id = $_POST['RDCpptpasienT']['pasien_id'];
                // $modPasienMorb->kelompokdiagnosa_id = 2;
                // $modPasienMorb->golonganumur_id = $modPasienMorb->kelompokumur_id;
                // $modPasienMorb->pendaftaran_id = $_POST['RDCpptpasienT']['pendaftaran_id'];
                // $modPasienMorb->ket_diagnosa = $_POST['RDCpptpasienT']['soap_asesmen'];
                // $modPasienMorb->tglmorbiditas = Myformatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
                // $modPasienMorb->kasusdiagnosa = 'KASUS BARU';
                // $modPasienMorb->save();

                // // if (!empty($modPasienMorb)) {
                // //     $modPasienMorb->ket_diagnosa = $_POST['RDCpptpasienT']['soap_asesmen'];
                // //     $modPasienMorb->update();
                // // }

                // //New PemeriksaanfisikT
                // $modPemeriksaanFisik = new PemeriksaanfisikT;
                // $modPemeriksaanFisik->pendaftaran_id = $_POST['RDCpptpasienT']['pendaftaran_id'];
                // $modPemeriksaanFisik->pegawai_id = $_POST['RDCpptpasienT']['pegawaippa_id'];
                // $modPemeriksaanFisik->pasienadmisi_id = $_POST['RDCpptpasienT']['pasienadmisi_id'];
                // $modPemeriksaanFisik->pasien_id = $_POST['RDCpptpasienT']['pasien_id'];
                // $modPemeriksaanFisik->tglperiksafisik = Myformatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
                // $modPemeriksaanFisik->keadaanumum = $_POST['RDCpptpasienT']['soap_objective'];
                // $modPemeriksaanFisik->save();
                // if (!empty($modPemeriksaanFisik)){
                //     $modPemeriksaanFisik->keadaanumum = $_POST['RDCpptpasienT']['soap_objective'];
                //     $modPemeriksaanFisik->update();

                // }

                if (!empty($model->cpptpasien_id)) {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                } else {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                // // echo "<pre>";
                // var_dump($modAnamnesa);
                // die;
                // // var_dump($modAnamnesa->save());
                // // die;
                if ($model->save()) {
                    $this->tersimpan = true;
                    $p = PendaftaranT::model()->findByPk($model->pendaftaran_id);
                    $modAnamnesa->save();
                    $modPemeriksaanFisik->save();

                    if (!empty($p)) {
                        $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
                    }
                } else {
                    $this->tersimpan = false;
                }

                if ($this->tersimpan == true) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                    $this->redirect(array('indexFA', 'pendaftaran_id' => $model->pendaftaran_id, 'sukses' => 1));
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan!");
                }
            } catch (Exception $ex) {
                var_dump($ex->getMessage());
                die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        // echo "<pre>";
        // var_dump($model);die;
        $this->render($this->path_view . 'indexFA', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'modelRiwayat' => $modelRiwayat
        ));
    }


    public function actionInformasiRiwayatPasien()
    {
        $modelRiwayat = new RDCpptpasienT();
        $pendaftaran_id = $_GET['pendaftaran_id'];
        $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $ruangan_id = Yii::app()->user->getState("ruangan_id");

        if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_GIZI) {
            $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
        } else if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD) {
            if (Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_VK) {
                $modPendaftaran = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
            }
        }

        if (isset($_GET['RDCpptpasienT'])) {
            $modelRiwayat->attributes = $_GET['RDCpptpasienT'];
        }

        $this->render($this->path_view . '_riwayatCPPT', array(
            'modelRiwayat' => $modelRiwayat,
            'modPendaftaran' => $modPendaftaran
        ));
    }

    public function actionReviewVerifikasiDpjp($cpptpasien_id, $type)
    {
        $this->layout = '//layouts/iframe';
        $model = RDCpptpasienT::model()->findByPk($cpptpasien_id);
        $model->verifikasidpjp_tanggal = date('d M Y H:i:s');

        if (isset($_POST['RDCpptpasienT'])) {
            $model->attributes = $_POST['RDCpptpasienT'];
            $model->verifikasidpjp_tanggal = (!empty($_POST['RDCpptpasienT']['verifikasidpjp_tanggal']) ? MyFormatter::formatDateTimeForDb($_POST['RDCpptpasienT']['verifikasidpjp_tanggal']) : null);
            $model->isverifikasidpjp = true;

            if ($model->save()) {
                $this->redirect(array('reviewVerifikasiDpjp', 'cpptpasien_id' => $cpptpasien_id, 'type' => $type, 'sukses' => 1));
            }
        }

        if ($type == 'verifikasi') {
            $this->render($this->path_view . '_verifikasiDpjp', array(
                'model' => $model
            ));
        }
        if ($type == 'review') {
            $this->render($this->path_view . '_hasilReview', array(
                'model' => $model
            ));
        }
    }

    public function actionReviewVerifikasiSupervisi($cpptpasien_id, $type)
    {
        $this->layout = '//layouts/iframe';
        $model = RDCpptpasienT::model()->findByPk($cpptpasien_id);
        $model->verifikasidpjp_tanggal = date('d M Y H:i:s');

        if (isset($_POST['RDCpptpasienT'])) {
            $model->attributes = $_POST['RDCpptpasienT'];
            $model->verifikasisupervisi_tanggal = (!empty($_POST['RDCpptpasienT']['verifikasisupervisi_tanggal']) ? MyFormatter::formatDateTimeForDb($_POST['RDCpptpasienT']['verifikasisupervisi_tanggal']) : null);
            $model->verifikasidpjp_hasilreview = (!empty($_POST['RDCpptpasienT']['verifikasidpjp_hasilreview']) ? $_POST['RDCpptpasienT']['verifikasidpjp_hasilreview'] : null);
            $model->verifikasisupervisi_keterangan = (!empty($_POST['RDCpptpasienT']['verifikasisupervisi_keterangan']) ? $_POST['RDCpptpasienT']['verifikasisupervisi_keterangan'] : null);
            $model->isverifikasisupervisi = true;


            if ($model->save()) {
                $this->redirect(array('reviewVerifikasiSupervisi', 'cpptpasien_id' => $cpptpasien_id, 'type' => $type, 'sukses' => 1));
            }
        }

        if ($type == 'verifikasi') {
            $this->render($this->path_view . '_verifikasiSupervisi', array(
                'model' => $model
            ));
        }
        if ($type == 'review') {
            $this->render($this->path_view . '_hasilReview', array(
                'model' => $model
            ));
        }
    }




    public function actionHapusRiwayatCPPT()
    {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $deleteData = CpptpasienT::model()->deleteByPk($id);

            $message = "";
            $sukses = 0;

            if ($deleteData) {
                $message = "Data Berhasil Dihapus!";
                $sukses = 1;
            } else {
                $message = "Data gagal Dihapus!";
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

    public function actionPrint($pendaftaran_id)
    {
        $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $ruangan_id = Yii::app()->user->getState("ruangan_id");

        if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_GIZI) {
            $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
        } else if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD) {
            if (Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_VK) {
                $modPendaftaran = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
            }
        }
        $criteriaData = new CDbCriteria;
        $criteriaData->addCondition('pasien_id ='.$modPendaftaran->pasien_id);
        $criteriaData->order = 'tanggal_cppt desc';
        $data = RDCpptpasienT::model()->findAll($criteriaData);
        // $data = RDCpptpasienT::model()->findAllByAttributes(array(
        //     'pasien_id' => $modPendaftaran->pasien_id,
        // ));
        // echo "<pre>";
        // var_dump($data);die;
        $res = new RDCpptpasienT;
        $res->unsetAttributes();
        $res->pendaftaran_id = $pendaftaran_id;
        if (isset($_GET['RDCpptpasienT'])) {
            $res->attributes = $_GET['RDCpptpasienT'];
        }

        $prov = $res->searchRiwayat();
        $prov->pagination = false;

        $model = $prov->data;
        // echo "<pre>";
        // var_dump($model, $_GET, $data);die;
        //print
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('data'=> $data,'res' => $res, 'model' => $model, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);

            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 20, 15, 15);
            $judulLaporan = "SURAT PERSETUJUAN UMUM";
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('data'=> $data,'res' => $res, 'model' => $model, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }

    public function actionAutocompletePPA($term = "")
    {

        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modPPA = new PegawairuanganV('search');
        $modPPA->unsetAttributes();
        $modPPA->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPPA->nama_pegawai = $term;

        $prov = $modPPA->search();
        $prov->sort->defaultOrder = 'nama_pegawai';

        $res = array();
        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['nama_pegawai'] = $item->namaLengkap;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->namaLengkap;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    public function actionAutocompleteDPJP($term = "")
    {

        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modPPA = new PegawaiM('search');
        $modPPA->unsetAttributes();
        $modPPA->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK;
        // $modPPA->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPPA->nama_pegawai = $term;

        $prov = $modPPA->search();
        $prov->sort->defaultOrder = 'nama_pegawai';

        $res = array();
        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['nama_pegawai'] = $item->namaLengkap;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->namaLengkap;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }
}
