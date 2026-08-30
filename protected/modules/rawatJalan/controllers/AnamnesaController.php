<?php

class AnamnesaController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatJalan.views.anamnesa.';

    public function actionIndex($pendaftaran_id = null, $id = null, $tipe = null, $is_triage = null, $notriage_pasien_id = null) {
        // if ($tipe === 'salin') {
        //   $id = null;
        // }

        if($is_triage == 1) {
            $this->layout = '//layouts/mainNeonSideBar';
        }

        $format = new MyFormatter();
        $modAnamnesa = new RJAnamnesaT;

        $modTriagePasien = null;
        $modPendaftaran = null;
        $modPasien = null;

        $tabelAnamnesa = null;
        $cekAnamnesa = null;
        $tabelAnamnesaPasien = null;

        if(isset($id)) {
            $modAnamnesa = RJAnamnesaT::model()->findByPk($id);
        }


        if(!empty($notriage_pasien_id)) {
            $this->layout= '//layouts/mainNeonSidebar';
            // if($is_triage == 1) {
                $tabelAnamnesa = RJAnamnesaT::model()->findAllByAttributes(array('notriage_pasien_id' => $notriage_pasien_id, 'is_medis' => false), array('order' => 'create_time DESC'));
                $tabelAnamnesaPasien = $tabelAnamnesa;
            // }

        } else {
            $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
            $tabelAnamnesa = RJAnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'is_medis' => false), array('order' => 'create_time DESC'));
            
            $cekAnamnesa = RJAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modPpds = PpdsM::model()->findByPk($modPendaftaran->ppds_id);
            $tabelAnamnesaPasien = RJAnamnesaT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id, 'is_medis' => false), array('order' => 'create_time DESC'));
    
    
            $dataPendaftaran = RJPendaftaranT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'tgl_pendaftaran DESC'));
            $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
                        'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
                        'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                            ), array(
                        'order' => 'tglkonsulpoli desc',
            ));
    
            $i = 1;
            if (count((array) $dataPendaftaran) > 1) {
                foreach ($dataPendaftaran as $row) {
                    if ($i == 2) {
                        $lastPendaftaran = $row->pendaftaran_id;
                    }
                    $i++;
                }
            } else {
                $lastPendaftaran = $pendaftaran_id;
            }

            $cekAnamnesa = null; //RJAnamnesaT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            $modDiagnosa = new RJDiagnosaM;
    
            if (!empty($cekAnamnesa)) {  //Jika Pasien Sudah Melakukan Anamnesa Sebelumnya				
                $modAnamnesa = new RJAnamnesaT;
    
                $detTriase = (isset($_POST['RJTriase']) ? $_POST['RJTriase'] : null);
                if (isset($detTriase)) {
                    if (count((array) $detTriase) > 0) {
                        foreach ($detTriase as $i => $triase) {
                            $modAnamnesa->triase_id = $triase['triase_id'];
                        }
                    }
                }
    
                $modAnamnesa = $cekAnamnesa;
    
                // $lama = explode(" ", $modAnamnesa->lamasakit);
                // $modAnamnesa->lamasakit = $lama[0];
                // if (!empty($lama[1]))
                //     $modAnamnesa->satuanWaktu = $lama[1];
    
                //if ($modAnamnesa->paramedis_nama) $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                //$modAnamnesa->paramedis_nama = empty($pegawai)?null:$pegawai->nama_pegawai;
                //$modAnamnesa->riwayatimunisasi = $modPendaftaran->statuspasien;
            } else {
                ////Jika Pasien Belum Pernah melakukan Anamnesa
                $modAnamnesa = new RJAnamnesaT;
                $modAnamnesa->pegawai_id = $modPendaftaran->pegawai_id;
                if(isset($_GET['pasienmasukpenunjang_id'])) {
                    $modPenunjang = PasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
                    if(!empty($modPenunjang)) {
                        $modAnamnesa->pegawai_id = $modPenunjang->pegawai_id;
                    }
                }
                //                $modAnamnesa->paramedis_nama = "Rina Trianasari, AMd. AK";
                $modAnamnesa->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modAnamnesa->pasien_id = $modPendaftaran->pasien_id;
                $modAnamnesa->tglanamnesis = date('Y-m-d H:i:s');
                $modAnamnesa->update_loginpemakai_id = Yii::app()->user->id;
                $modAnamnesa->create_loginpemakai_id = Yii::app()->user->id;
                $modAnamnesa->create_ruangan =Yii::app()->user->getState('ruangan_id');
                $modAnamnesa->create_time = date('Y-m-d H:i:s');
               // $modAnamnesa->statusmerokok = 0;
                $modAnamnesa->ppds_id =$modPendaftaran->ppds_id ?? "" ;
              //  $modAnamnesa->isbayianak_kelainanconginetal = "Tidak";
               // $modAnamnesa->keb_konsumsialkohol = "Tidak";
               // $modAnamnesa->riwayatperiksa_diagnosahiv = "Tidak";
              //  $modAnamnesa->ispasienwanitahamil = "Tidak";
               // $modAnamnesa->ispasienwanitamenyusui = "Tidak";
               // $modAnamnesa->keb_olahraga = "Tidak";
    
                if (!empty($id)) {
                    $modAnamnesa = RJAnamnesaT::model()->findByPk($id);
                    if ($modAnamnesa->is_keputihan !== null) {
                        $modAnamnesa->is_keputihan = ($modAnamnesa->is_keputihan === false) ? 0 : 1;
                    }
                }
                //$isPasien = RJPendaftaranT::model()->findByPk($pendaftaran_id)->statuspasien;
                //                $sql = "SELECT c(diagnosa_id) FROM pasienimunisasi_t WHERE pendaftaran_id = $pendaftaran_id";
                //                $stoks = Yii::app()->db->createCommand($sql)->queryAll();
                if (!empty($konsul)) {
                    $modPendaftaran->pegawai_id = $konsul->pegawai_id;
                    $modPendaftaran->ruangan_id = $konsul->ruangan_id;
                    $modAnamnesa->pegawai_id = $konsul->pegawai_id;
                }

                $critlast = new CDbCriteria;
                $critlast->addCondition('pendaftaran_id = ' .$pendaftaran_id . ' and create_ruangan = ' . Yii::app()->user->getState('ruangan_id') . ' and is_cppt is not true');
                $critlast->order = 'create_time desc';
                
                $anamnesakhir = RJAnamnesaT::model()->find($critlast);

                if (!empty($anamnesakhir)){
                    $modAnamnesa->keluhanutama = $anamnesakhir->keluhanutama;
                    $modAnamnesa->keluhantambahan = $anamnesakhir->keluhantambahan;
                }
                $modAnamnesa->paramedis_nama = Yii::app()->user->getState('nama_pegawai');
            }

            if ($modPendaftaran->statuspasien == "PENGUNJUNG LAMA") {
                $modDiagnosaTerdahulu = RJPasienMorbiditasT::model()->with('diagnosa')->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id, 'pendaftaran_id' => $lastPendaftaran));
    
                $hasilImunisasi = array();
                $hasilDiagnosaDahulu = array();
                foreach ($modDiagnosaTerdahulu as $row) {
                    if ($row->diagnosa->diagnosa_imunisasi == true)
                        $hasilImunisasi[] = (isset($row->diagnosa->diagnosa_nama) ? $row->diagnosa->diagnosa_nama : "");
                    else
                        $hasilDiagnosaDahulu[] = (isset($row->diagnosa->diagnosa_nama) ? $row->diagnosa->diagnosa_nama : "");
                }
                if (empty($modAnamnesa->riwayatimunisasi)) {
                    $modAnamnesa->riwayatimunisasi = implode(', ', $hasilImunisasi);
                }
                // if (empty($modAnamnesa->riwayatpenyakitterdahulu)) {
                //     $modAnamnesa->riwayatpenyakitterdahulu = implode(', ', $hasilDiagnosaDahulu);
                // }
            }
    
        }

        if(!empty($notriage_pasien_id)) {
            $modTriagePasien = NotriagePasienT::model()->findByPk($notriage_pasien_id);
            $modAnamnesa->nomor_triage = $modTriagePasien->no_bed_triage . " - " . $modTriagePasien->no_triage_pasien;
        }
       
        //echo $modAnamnesa->riwayatpenyakitterdahulu;exit();
        if (isset($_POST['RJAnamnesaT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            if ($tipe === 'salin') {
                $modAnamnesa = new RJAnamnesaT;

                if(isset($pendaftaran_id)) {
                    $modAnamnesa->pendaftaran_id = $pendaftaran_id;
                    $modAnamnesa->pasien_id = $modPendaftaran->pasien_id;
                }

            }
            try {
                
                $detTriase = (isset($_POST['RJTriase']) ? $_POST['RJTriase'] : null);
                $modAnamnesa->attributes = $_POST['RJAnamnesaT'];
                $modAnamnesa->paramedis_id = Yii::app()->user->getState('pegawai_id');
                $modAnamnesa->lamasakit .= " " . (!empty($_POST['RJAnamnesaT']['satuanWaktu']) ? $_POST['RJAnamnesaT']['satuanWaktu'] : "");
               // $modAnamnesa->konsultasi_dpjp = $_POST['RJAnamnesaT']['konsultasi_dpjp'];


                if (empty($modAnamnesa->hpht))
                  $modAnamnesa->hpht = null;
                if (empty($modAnamnesa->tgl_persalinan))
                  $modAnamnesa->tgl_persalinan = null;
                if (isset($detTriase)) {
                  if (count((array)$detTriase) > 0) {
                    foreach ($detTriase as $i => $triase) {
                      $modAnamnesa->triase_id = $triase['triase_id'];
                    }
                  }
                }
                $modAnamnesa->tglanamnesis = $format->formatDateTimeForDb($modAnamnesa->tglanamnesis);
                $modAnamnesa->reproduksi_tafsirpersalinan = !empty($modAnamnesa->reproduksi_tafsirpersalinan)?$format->formatDateTimeForDb($modAnamnesa->reproduksi_tafsirpersalinan):null;
                    $modAnamnesa->keluhanutama = isset($_POST['RJAnamnesaT']['keluhanutama']) ? $_POST['RJAnamnesaT']['keluhanutama'] : null;
                  $modAnamnesa->riwayatkelahiran = isset($_POST['RJAnamnesaT']['riwayatkelahiran']) ? ((count((array)$_POST['RJAnamnesaT']['riwayatkelahiran']) > 0) ? implode(', ', $_POST['RJAnamnesaT']['riwayatkelahiran']) : '') : '';
                  $modAnamnesa->keluhantambahan = isset($_POST['RJAnamnesaT']['keluhantambahan']) ? ((count((array)$_POST['RJAnamnesaT']['keluhantambahan']) > 0) ? implode(', ', $_POST['RJAnamnesaT']['keluhantambahan']) : '') : '';
               //   $modAnamnesa->keluhanutama = isset($_POST['RJAnamnesaT']['keluhanutama']) ? ((count((array) $_POST['RJAnamnesaT']['keluhanutama']) > 0) ? implode(', ', $_POST['RJAnamnesaT']['keluhanutama']) : '') : '';
                
               // $modAnamnesa->keluhantambahan = isset($_POST['RJAnamnesaT']['keluhantambahan']) ? $_POST['RJAnamnesaT']['keluhantambahan'] : null;
                $modAnamnesa->riwayatperjalananpasien = isset($_POST['RJAnamnesaT']['riwayatperjalananpasien']) ? $_POST['RJAnamnesaT']['riwayatperjalananpasien'] : null;
                $modAnamnesa->tglanamnesis = $format->formatDateTimeForDb($_POST['RJAnamnesaT']['tglanamnesis']);
                $modAnamnesa->petugas_triase_id = isset($_POST['RJAnamnesaT']['petugas_triase_id']) ? $_POST['RJAnamnesaT']['petugas_triase_id'] : null;
              //  $modAnamnesa->hpht_tanggal = isset($_POST['RJAnamnesaT']['hpht_tanggal']) ? $format->formatDateTimeForDb($_POST['RJAnamnesaT']['hpht_tanggal']) : null;
                $modAnamnesa->ppds_id = isset($_POST['RJAnamnesaT']['ppds_id']) ? $_POST['RJAnamnesaT']['ppds_id'] : "";
                // $modAnamnesa->statusmerokok = isset($_POST['RJAnamnesaT']['statusmerokok']) ? 1 : 0;
                // $modAnamnesa->keb_minumkopi = isset($_POST['RJAnamnesaT']['keb_minumkopi']) ? 1 : 0;
                // $modAnamnesa->keb_minumteh = isset($_POST['RJAnamnesaT']['keb_minumteh']) ? 1 : 0;
                // $modAnamnesa->keb_minumsoda = isset($_POST['RJAnamnesaT']['keb_minumsoda']) ? 1 : 0;
               
     
                if (!empty($modAnamnesa->hpht))
                    $modAnamnesa->hpht = MyFormatter::formatDateTimeForDb($modAnamnesa->hpht);
                if (!empty($modAnamnesa->tgl_persalinan))
                    $modAnamnesa->tgl_persalinan = MyFormatter::formatDateTimeForDb($modAnamnesa->tgl_persalinan);

                if(isset($pendaftaran_id)) {
                $p = PendaftaranT::model()->findByPk($pendaftaran_id);
                $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);

                if (empty($p->waktumulaiperiksa)){
                    PendaftaranT::model()->updateByPk($p->pendaftaran_id,array('waktumulaiperiksa'=> date('Y-m-d H:i:s'))); 
                }

                $st = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')));
                if (!empty($st)) {
                    $pasienpenunjang = PasienmasukpenunjangT::model()->updateByPk($st->pasienmasukpenunjang_id, array(
                        'statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA
                    ));
                    // echo '<pre>'; var_dump('st1', $st->pasienmasukpenunjang_id, $a->statusperiksa);die;
                }
            }



                /* ================================================ */
                /* Proses update status periksa KonsulPoli EHS-179  */
                /* ================================================ */
                $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
                if (!empty($konsulPoli)) {
                    $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
                }
                $modAnamnesa->create_time = date("Y-m-d H:i:s");
                $modAnamnesa->create_loginpemakai_id = Yii::app()->user->id;
                $modAnamnesa->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                if (Yii::app()->user->getState('pegawai_id') == $modAnamnesa->pegawai_id) {
                    $modAnamnesa->dokterverifikasi_id = $modAnamnesa->pegawai_id;
                }
                /* ================================================ */

                $modAnamnesa->riwayat_vaksinasi = CJSON::encode($modAnamnesa->riwayat_vaksinasi);
                $modAnamnesa->nutrisi_tipemakan = CJSON::encode($modAnamnesa->nutrisi_tipemakan);

                // if (empty($modAnamnesa->eliminasi_buangairbesar) || !in_array("Lain-Lain", $modAnamnesa->eliminasi_buangairbesar)) {
                // $modAnamnesa->eliminasi_buangairbesar_lain2 = "";
                // }
                // if (empty($modAnamnesa->eliminasi_buangairbesar) || !in_array("Diare", $modAnamnesa->eliminasi_buangairbesar)) {
                //   $modAnamnesa->eliminasi_buangairbesar_diarehari = "";
                // }
                // if (empty($modAnamnesa->eliminasi_buangairkecil) || !in_array("Lain-Lain", $modAnamnesa->eliminasi_buangairkecil)) {
                //   $modAnamnesa->eliminasi_buangairbesar_lain2 = "";
                // }
                if (empty($modAnamnesa->eliminasi_buangairbesar)) {
                    $modAnamnesa->eliminasi_buangairbesar_lain2 = "";
                    $modAnamnesa->eliminasi_buangairbesar_diarehari = "";
                }

                if (empty($modAnamnesa->eliminasi_buangairkecil)) {
                    $modAnamnesa->eliminasi_buangairbesar_lain2 = "";
                }

                if (!empty($modAnamnesa->eliminasi_buangairbesar) && is_array($modAnamnesa->eliminasi_buangairbesar)) {
                    if (!in_array("Diare", $modAnamnesa->eliminasi_buangairbesar)) {
                        $modAnamnesa->eliminasi_buangairbesar_lain2 = "";
                        $modAnamnesa->eliminasi_buangairbesar_diarehari = "";
                    }
                }

                if (!empty($modAnamnesa->eliminasi_buangairkecil) && is_array($modAnamnesa->eliminasi_buangairkecil)) {
                    if (!in_array("Lain-Lain", $modAnamnesa->eliminasi_buangairkecil)) {
                        $modAnamnesa->eliminasi_buangairbesar_lain2 = "";
                    }
                }

                $modAnamnesa->eliminasi_buangairbesar = CJSON::encode($modAnamnesa->eliminasi_buangairbesar);
                $modAnamnesa->eliminasi_buangairkecil = CJSON::encode($modAnamnesa->eliminasi_buangairkecil);
                $modAnamnesa->nutrisi_kondisi = CJSON::encode($modAnamnesa->nutrisi_kondisi);

                if(isset($notriage_pasien_id)) {
                    $modAnamnesa->notriage_pasien_id = $notriage_pasien_id;
                }
                // var_dump($modAnamnesa->getErrors());
                // die;

                // var_dump($modAnamnesa);
                // die;
                
                if ($modAnamnesa->save()) {
                    Yii::app()->user->setFlash('success', "Data anamnesa berhasil disimpan");
                    $transaction->commit();
                    //$this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                    if(isset($pendaftaran_id)) {
                        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'id' => $modAnamnesa->anamesa_id, 'tipe' => 'sukses', 'sukses' => 1));
                    } else {
                        $this->redirect(array('index', 'is_triage' => $is_triage, 'notriage_pasien_id' => $notriage_pasien_id, 'id' => $modAnamnesa->anamesa_id, 'tipe' => 'sukses'));
                    }
                } else {
                    Yii::app()->user->setFlash('error', "Data anamnesa gagal disimpan " . CHtml::errorSummary($modAnamnesa));
                }
            } catch (Exception $exc) {
                // var_dump($exc->getMessage());
                // die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }


        $modAnamnesa->tglanamnesis = $format->formatDateTimeForUser($modAnamnesa->tglanamnesis);

        $modDiagnosa = new RJDiagnosaM('searchDiagnosaAnamnesa');
        $modDiagnosa->unsetAttributes();
        if (isset($_GET['RJDiagnosaM']))
            $modDiagnosa->attributes = $_GET['RJDiagnosaM'];
        
        $index = !empty($notriage_pasien_id) == 1 ? 'indexTriage' : 'index';

        $this->render($this->path_view . $index, array(
            'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,
            'modAnamnesa' => $modAnamnesa, 'modDiagnosa' => $modDiagnosa,
            'modTriagePasien' => $modTriagePasien,
            'tabelAnamnesa' => $tabelAnamnesa,
            'tabelAnamnesaPasien' => $tabelAnamnesaPasien,
        ));
    }

    /**
     * @param type $pendaftaran_id
     */
    public function actionPrintAnamnesa($pendaftaran_id, $anamnesa_id = null) {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAnamnesa = RJAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

        if(!empty($anamesa_id)) {
            $modAnamnesa = RJAnamnesaT::model()->findByPk($anamesa_id);
        }

        $judul_print = 'ANAMNESIS';
        $this->render($this->path_view . 'printAnamnesa', array(
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            'judul_print' => $judul_print,
            'modPasien' => $modPasien,
            'modAnamnesa' => $modAnamnesa,
        ));
    }


    public function actionPrintAnamnesaTriage($anamesa_id) {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = RJPendaftaranT::model()->findByPk($anamesa_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id ?? "");
        $modAnamnesa = RJAnamnesaT::model()->findByAttributes(array('anamesa_id' => $anamesa_id));

        $judul_print = 'ANAMNESIS';
        $this->render($this->path_view .'printAnamnesa3', array(
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            'judul_print' => $judul_print,
         'modPasien' => $modPasien,
            'modAnamnesa' => $modAnamnesa,
        ));
    }
   



    public function actionPrintAnamnesa2($anamesa_id) {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modAnamnesa = RJAnamnesaT::model()->findByAttributes(array('anamesa_id' => $anamesa_id));
        $modPendaftaran = RJPendaftaranT::model()->findByPk($modAnamnesa->pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);


        $judul_print = 'ANAMNESIS';
        $this->render($this->path_view . 'printAnamnesa2', array(
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            'judul_print' => $judul_print,
         'modPasien' => $modPasien,
            'modAnamnesa' => $modAnamnesa,
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
                $data[$i] = array(
                    'key' => $keluhan->keluhananamnesis_nama,
                    'value' => $keluhan->keluhananamnesis_nama
                );
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    /* */

    /**
     * actionGetTriasePasien untuk Triase Tabulasi Anamnesa:
     * issue		: RND-6415
     */
    public function actionGetTriasePasien() {

        if (Yii::app()->request->isAjaxRequest) {
            $triase_id = $_POST['triase_id'];

            $modDetail = new RJTriase;
            $modTriase = RJTriase::model()->findByPk($triase_id);
            $warna = RJTriase::model()->getKodeWarnaId($triase_id);
            $tr = "<tr>
                            <td> " . CHtml::hiddenField('noUrut', '', array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
                    CHtml::activeHiddenField($modDetail, '[' . $triase_id . ']triase_id', array('value' => $modTriase->triase_id, 'class' => 'triase_id'))
                    . "<div class='colorPicker-picker' style='background-color:#" . $warna . ";'> </div>" .
                    "</td>
                            <td>" . $modTriase->triase_nama . "</td>
                            <td>" . $modTriase->keterangan_triase . "</td>
                            <td>" . CHtml::link("<span class='icon-remove'>&nbsp;</span>", '', array('href' => '#', 'onClick' => 'batalTriase();return false;', 'style' => 'text-decoration:none;')) . "</td>
                         </tr>   
                        ";
            $data['tr'] = $tr;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionHapusTriase() {
        if (Yii::app()->request->isPostRequest) {
            $anamesa_id = $_POST['anamesa_id'];
            $triase_id = $_POST['triase_id'];
            $modAnamnesa = AnamnesaT::model()->findByPk($anamesa_id);
            if (!empty($modAnamnesa->triase_id)) {
                $update = AnamnesaT::model()->updateByPk($anamesa_id, array('triase_id' => null));
            }

            if ($update) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                        'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                    ));
                    exit;
                }
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionGetPegawaiTriase() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai ASC';
            $models = RJPegawaiM::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]['label'] = $model->NamaLengkap;
                    $returnVal[$i]['value'] = $model->NamaLengkap;
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionAjaxDetailAnamnesa() {
        if (Yii::app()->request->isAjaxRequest) {
            $idAnamnesis = $_POST['idAnamnesis'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
            $modAnamnesa = AnamnesaT::model()->findByPk($idAnamnesis);

            $data['result'] = $this->renderPartial($this->path_view . '_viewDetailAnamnesa', array('modAnamnesa' => $modAnamnesa, 'modPendaftaran' => $modPendaftaran), true);

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionAjaxDetailAnamnesa2() {
        if (Yii::app()->request->isAjaxRequest) {
            $idAnamnesis = $_POST['idAnamnesis'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
            $modAnamnesa = AnamnesaT::model()->findByPk($idAnamnesis);

            $data['result'] = $this->renderPartial($this->path_view . '_viewDetailAnamnesa2', array('modAnamnesa' => $modAnamnesa, 'modPendaftaran' => $modPendaftaran), true);

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionHapusRiwayatAnamnesa() {
        if (Yii::app()->request->isAjaxRequest) {
            $idAnamnesa = (isset($_POST['anamesa_id']) ? $_POST['anamesa_id'] : null);
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $deleteAnamnesa = AnamnesaT::model()->deleteByPk($idAnamnesa);
                if ($deleteAnamnesa) {
                    $data['pesan'] = "Riwayat Anamnesa Berhasil Dihapus!";
                    $data['sukses'] = 1;
                    $transaction->commit();
                } else {
                    $data['pesan'] = "Gagal Menghapus Anamnesa";
                    $data['sukses'] = 0;
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $data['pesan'] = "Hapus Data Gagal :" . MyExceptionMessage::getMessage($exc, true);
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionSetTafsiranKelahiran() {

        if (Yii::app()->request->isAjaxRequest) {
            $hpht = $_POST['tgl_hpht'];
            $hpht = MyFormatter::formatDateTimeForDb($_POST['tgl_hpht']);
            $hpht = explode(" ", $hpht);
            
            $plus7hari = date('Y-m-d', strtotime('+7 days', strtotime($hpht[0])));
            $min3bulan = date('Y-m-d', strtotime('-3 month', strtotime($plus7hari)));
            $plus1tahun = date('Y-m-d', strtotime('+1 year', strtotime($min3bulan)));
            $tglPersalinan = MyFormatter::formatDateTimeForUser($plus1tahun);

            $data['tafsiran'] = $tglPersalinan . " " . $hpht[1];
            echo json_encode($data);
            Yii::app()->end();
        }
    }

        
    public function actionAjaxDetailAnamnesaTriage() {
        if (Yii::app()->request->isAjaxRequest) {
            $idAnamnesis = $_POST['idAnamnesis'];
            $notriage_pasien_id = $_POST['notriage_pasien_id'];
            $modTriage = NotriagePasienT::model()->findByPk($notriage_pasien_id);
            $modAnamnesa = AnamnesaT::model()->findByPk($idAnamnesis);

            $data['result'] = $this->renderPartial($this->path_view . '_viewDetailAnamnesaTriage', array('modAnamnesa' => $modAnamnesa, 'modTriage' => $modTriage), true);

            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    
     /**
     * @param type $pendaftaran_id
     */




}