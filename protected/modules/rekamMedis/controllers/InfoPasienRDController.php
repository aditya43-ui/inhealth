<?php
// Yii::import('pendaftaranPenjadwalan.controllers.InfoKunjunganRDController');
// Yii::import('pendaftaranPenjadwalan.views.infoKunjunganRD');
Yii::import('pendaftaranPenjadwalan.models.*');
Yii::import('rawatDarurat.models.*');
class InfoPasienRDController extends MyAuthController
{
    public $path_view = 'rekamMedis.views.infoPasienRD.';
    public $asuransipasientersimpan = false;

    public function actionIndex()
    {
        $this->pageTitle = Yii::app()->name . " - Rawat Darurat";
        $format = new MyFormatter();
        $modInfoKunjunganRDV = new PPInfoKunjunganRDV;
        $modInfoKunjunganRDV->tgl_awal = date("Y-m-d");
        $modInfoKunjunganRDV->tgl_akhir = date("Y-m-d");
        $modInfoKunjunganRDV->tgl_awall = date('Y-m-d');
        $modInfoKunjunganRDV->tgl_akhirl = date('Y-m-d');
        $modInfoKunjunganRDV->ceklis = false;
        $modInfoKunjunganRDV->statusperiksa = Params::STATUSPERIKSA_SUDAH_PULANG;
        if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
            $modInfoKunjunganRDV->attributes = $_REQUEST['PPInfoKunjunganRDV'];
            $modInfoKunjunganRDV->ceklis = $_REQUEST['PPInfoKunjunganRDV']['ceklis'];
            $modInfoKunjunganRDV->carakeluar_id = $_REQUEST['PPInfoKunjunganRDV']['carakeluar_id'];
            $modInfoKunjunganRDV->kondisikeluar_id = $_REQUEST['PPInfoKunjunganRDV']['kondisikeluar_id'];
            $modInfoKunjunganRDV->is_verifikasidiagnosa = $_REQUEST['PPInfoKunjunganRDV']['is_verifikasidiagnosa'];
            $modInfoKunjunganRDV->rujukandari_id = $_REQUEST['PPInfoKunjunganRDV']['rujukandari_id'];
            $modInfoKunjunganRDV->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
            $modInfoKunjunganRDV->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
            $modInfoKunjunganRDV->tgl_awall = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awall']);
            $modInfoKunjunganRDV->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhirl']);
        }

        if(Yii::app()->request->isAjaxRequest) {
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'PPInfoKunjungan-v') {
            $this->renderPartial($this->path_view . '_table', ['modInfoKunjunganRDV' => $modInfoKunjunganRDV]);
            Yii::app()->end();
        }
        }
        $this->render($this->path_view . 'index', array(
        'format' => $format,
        'modInfoKunjunganRDV' => $modInfoKunjunganRDV,
        'model' => $modInfoKunjunganRDV
        ));
    }


    public function actionPrintStiker($pendaftaran_id)
    {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $posisi = 'P'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', array(100, 135));
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial($this->path_view . 'printStiker', array(
                'modPendaftaran' => $modPendaftaran,
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }

    //==================================Awal batal Periksa============================================================================        
    public function actionUbahPeriksa()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
        $statusperiksa = $_POST['statusperiksa'];
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $tglbatal = $_POST['tglbatal'];
        $keterangan_batal = $_POST['keterangan_batal'];
        //                $data['message']='Masih Dalam Pengembangan Karena TAbel dan View Belum Ada';
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modBatalPeriksa = new PasienbatalperiksaR;
        $modBatalPeriksa->pasien_id = $modPendaftaran->pasien_id;
        $modBatalPeriksa->pendaftaran_id = $pendaftaran_id;
        $modBatalPeriksa->tglbatal =  MyFormatter::formatDateTimeForDb($tglbatal);
        $modBatalPeriksa->keterangan_batal = $keterangan_batal;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $updatePendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA));
            if ($modBatalPeriksa->save() && $updatePendaftaran) {
            $attributes = array(
                'pasienbatalperiksa_id' => $modBatalPeriksa->pasienbatalperiksa_id,
                'update_time' => date('Y-m-d H:i:s'),
                'update_loginpemakai_id' => Yii::app()->user->id,
            );
            $updatePendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);
            $transaction->commit();
            $data['message'] = 'Batal periksa berhasil dilakukan.';
            $data['success'] = true;
            } else {
            $transaction->rollback();
            $data['message'] = 'Gagal Batal Periksa! Data tidak valid.';
            $data['success'] = false;
            }
        } catch (Exception $exc) {
            $transaction->rollback();
            $data['message'] = 'Gagal Batal Periksa!';
        }


        echo json_encode($data);
        Yii::app()->end();
        }
    }

    //================================================Awal Print Lembar Poli============================================================
    public function actionPrintLembarPoli($pendaftaran_id)
    {
        $this->layout = '//layouts/printLembarPoli';
        $sql = "SELECT pendaftaran_t.no_pendaftaran,
                            pendaftaran_t.no_urutantri,
                            pendaftaran_t.tgl_pendaftaran,
                            pendaftaran_t.umur,
                            ruangan_m.ruangan_nama,
                            pasien_m.no_rekam_medik, 
                            penjaminpasien_m.penjamin_nama, 
                            carabayar_m.carabayar_nama, 
                            pasien_m.jeniskelamin, 
                            pasien_m.nama_pasien, 
                            pasien_m.nama_bin,
                            pasien_m.alamat_pasien, 
                            pasien_m.tanggal_lahir  
                        FROM pendaftaran_t
                        JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
                        JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id 
                        JOIN carabayar_m ON carabayar_m.carabayar_id = pendaftaran_t.carabayar_id
                        JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
                        
                        WHERE pendaftaran_t.pendaftaran_id ='$pendaftaran_id'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        //            daftartindakan_m.daftartindakan_nama
        //                                       tindakanpelayanan_t.tarif_tindakan

        //             tipepaket_m.tipepaket_nama,
        //                                LEFT JOIN pegawai_m ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
        //            LEFT JOIN tindakanpelayanan_t ON tindakanpelayanan_t.no_pendaftaran = pendaftaran_t.no_pendaftaran 
        //                    LEFT JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
        //                    LEFT JOIN tipepaket_m ON tipepaket_m.tipepaket_id = tindakanpelayanan_t.tipepaket_id
        // pegawai_m.nama_pegawai,
        $this->render('printLembarPoli', array(
        //'model'=>$model,
        //'noPendaftaran'=>$idx,
        'data' => $result,
        ));
    }
    //==========================================================Akhir Print Lembar Poli===================================================        

    /**
     * Action untuk mengubah kelompok penyakit
     */
    public function actionUbahKelompokPenyakit()
    {
        $model = new PPPendaftaranT;
        $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
        if (isset($_POST['PPPendaftaranT'])) {
        if ($_POST['PPPendaftaranT']['jeniskasuspenyakit_id'] != "") {
            $model->attributes = $_POST['PPPendaftaranT'];
            $transaction = Yii::app()->db->beginTransaction();
            try {
            $attributes = array('jeniskasuspenyakit_id' => $_POST['PPPendaftaranT']['jeniskasuspenyakit_id']);
            $save = $model::model()->updateByPk($_POST['PPPendaftaranT']['pendaftaran_id'], $attributes);
            if ($save) {
                $transaction->commit();
                echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Berhasil merubah Kelompok Penyakit.</div>",
                ));
            } else {
                echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                ));
            }
            exit;
            } catch (Exception $exc) {
            $transaction->rollback();
            }
        } else {
            echo CJSON::encode(
            array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Berhasil merubah Kelompok Penyakit.</div>",
            )
            );
            exit;
        }
        }

        if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
            'status' => 'create_form',
            'div' => $this->renderPartial('_formUbahKelompokPenyakit', array('model' => $model, 'menu' => $menu), true)
        ));
        exit;
        }
    }

    // public function actionUbahCaraBayar()
    // {
    //   $this->layout = 'iframe';
    //   $model = new UbahcarabayarR;
    //   $modPendaftaran = PPPendaftaranT::model()->findByPk($id);
    //   $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    //   $modRujukanBpjs = new PPRujukanbpjsT;
    //   $modAsuransiPasien = new PPAsuransipasienM;
    //   $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
    //   $modSep = new PPSepT;

    //   if (isset($idSep)) {
    //     $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($modPendaftaran->rujukan_id);
    //     $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($modPendaftaran->asuransipasien_id);
    //     $modSep = PPSepT::model()->findByPk($idSep);
    //   }

    //   if (isset($_POST['UbahcarabayarR'])) {
    //     $pendaftaran_id = $_POST['pendaftaran_id'];
    //     $model->attributes = $_POST['UbahcarabayarR'];
    //     $model->pendaftaran_id = $_POST['pendaftaran_id'];
    //     $model->carabayar_id = $_POST['PPPendaftaranT']['carabayar_id'];
    //     $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    //     $model->tglubahcarabayar = date('Y-m-d H:i:s');

    //     // echo "<pre>"; print_r($model->attributes);exit();
    //     $transaction = Yii::app()->db->beginTransaction();
    //     try {

    //       $modPendaftaran = PPPendaftaranT::model()->findByPk(
    //         $model->pendaftaran_id
    //       );

    //       if (isset($_POST['PPPendaftaranT'])) {
    //         $modPendaftaran->attributes = $_POST['PPPendaftaranT'];
    //       }

    //       $modPendaftaran->carabayar_id = $model->carabayar_id;
    //       $modPendaftaran->penjamin_id = $model->penjamin_id;
    //       if ($model->save()) {



    //         if (isset($_POST['PPRujukanbpjsT'])) {
    //           $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
    //         } else {
    //           $this->rujukantersimpan = true;
    //         }



    //         if (isset($_POST['PPAsuransipasienM'])) {
    //           if (isset($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
    //             if ($_POST['PPAsuransipasienM']['asuransipasien_id'] == "") {
    //               $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
    //             }
    //           }
    //           $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienM']);
    //         } else {
    //           $this->asuransipasientersimpan = true;
    //         }
    //         if (isset($_POST['PPAsuransipasienbpjsM'])) {
    //           if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
    //             if ($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'] == "") {
    //               $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
    //             }
    //           }
    //           $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienbpjsM']);
    //         } else {
    //           $this->asuransipasientersimpan = true;
    //         }

    //         if (!empty($modRujukanBpjs->rujukan_id) && !empty($modAsuransiPasienBpjs->asuransipasien_id)) {
    //           PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id, 'rujukan_id' => $modRujukanBpjs->rujukan_id, 'asuransipasien_id' => $modAsuransiPasienBpjs->asuransipasien_id));
    //         } else if (!empty($modAsuransiPasien->asuransipasien_id)) {
    //           PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id, 'asuransipasien_id' => $modAsuransiPasien->asuransipasien_id));
    //         } else {
    //           PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id));
    //         }

    //         if (isset($_POST['PPSepT'])) {
    //           $modSep = $this->simpanSep($modPendaftaran, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
    //         }




    //         $transaction->commit();

    //         $this->notifUbahBayar($model);

    //         if (isset($modSep->nosep)) {
    //           $this->redirect(array('ubahCaraBayar', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1));
    //         } else {
    //           $this->redirect(array('ubahCaraBayar', 'id' => $model->pendaftaran_id, 'sukses' => 1));
    //         }
    //       } else {
    //         $transaction->rollback();
    //         Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
    //       }
    //     } catch (Exception $exc) {
    //       $transaction->rollback();
    //       Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
    //     }
    //   }

    //   $this->render(
    //     $this->path_view . '_formUbahCaraBayar',
    //     array(
    //       'model' => $model,
    //       'modPendaftaran' => $modPendaftaran,
    //       'modAsuransiPasien' => $modAsuransiPasien,
    //       'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
    //       'modRujukanBpjs' => $modRujukanBpjs,
    //       'modSep' => $modSep,
    //     )
    //   );
    // }
    /**
     * untuk mengubah cara bayar
     */
    public function actionUbahCaraBayar($id = null, $idSep = null)
    {
        $this->layout = '//layouts/iframe';
        $model = new UbahcarabayarR;
        $modPendaftaran = PPPendaftaranT::model()->findByPk($id);
        $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modRujukanBpjs = new PPRujukanbpjsT;
        $modAsuransiPasien = PPAsuransipasienM::model()->findByAttributes(array('pasien_id'=>$modPendaftaran->pasien_id));
        $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
        $modSep = new PPSepT;

        if (empty($modAsuransiPasien)){
        $modAsuransiPasien = new PPAsuransipasienM;
        }
        if (isset($idSep)) {
        $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($modPendaftaran->rujukan_id);
        $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($modPendaftaran->asuransipasien_id);
        $modSep = PPSepT::model()->findByPk($idSep);
        }

        if (isset($_POST['UbahcarabayarR'])) {
        // var_dump($_POST); die;
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $model->attributes = $_POST['UbahcarabayarR'];
        $model->pendaftaran_id = $_POST['pendaftaran_id'];
        $model->carabayar_id = $_POST['PPPendaftaranT']['carabayar_id'];
        $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
        $model->tglubahcarabayar = date('Y-m-d H:i:s');
        $model->create_time = date('Y-m-d H:i:s');
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;
        $model->create_loginpemakai_id = Yii::app()->user->id;
        // echo "<pre>"; print_r($model->attributes);exit();
        $transaction = Yii::app()->db->beginTransaction();
        $ok = true;
        try {

            $modPendaftaran = PPPendaftaranT::model()->findByPk(
            $model->pendaftaran_id
            );
            // var_dump($modPendaftaran->pendaftaran_id.' -'.$modPendaftaran->penjamin_id);die;

            if (isset($_POST['PPPendaftaranT'])) {
            $modPendaftaran->attributes = $_POST['PPPendaftaranT'];
            }
            
            $modPendaftaran->carabayar_id =$_POST['PPPendaftaranT']['carabayar_id'];
            $modPendaftaran->penjamin_id = $_POST['UbahcarabayarR']['penjamin_id'];
            $modPendaftaran->status_konfirmasi = "-";
            $modPendaftaran->asuransipasien_id = null;
            if (isset($_POST['PPAsuransipasienM'])) {
            if (isset($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
                if ($_POST['PPAsuransipasienM']['asuransipasien_id'] == "") {
                $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
                }
            }

            if (empty($modAsuransiPasien)) {
                $modAsuransiPasien = new PPAsuransipasienM;
            }

            $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienM']);
            $modPendaftaran->status_konfirmasi = $modAsuransiPasien->status_konfirmasi;
            $modPendaftaran->tgl_konfirmasi = $modAsuransiPasien->tgl_konfirmasi;
            $modPendaftaran->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
            }else {
            $this->asuransipasientersimpan = true;
            // $modPendaftaran->status_konfirmasi = $modAsuransiPasien->status_konfirmasi;
            // $modPendaftaran->tgl_konfirmasi = $modAsuransiPasien->tgl_konfirmasi;
            // $modPendaftaran->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
            }
        
        
    
            $modPendaftaran->carabayar_id = $model->carabayar_id;
            $modPendaftaran->penjamin_id = $model->penjamin_id;
            if ($model->save()) {
            $modPendaftaran->save();
            
            // $ok = $ok && $this->updateKarcis($modPendaftaran);
            
        
            if (isset($_POST['PPRujukanbpjsT'])) {
                $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
            } else {
                $this->rujukantersimpan = true;
            }

            $tindaanBaru =  JenistarifpenjaminM::model()->findByAttributes(
                ['penjamin_id'=>$_POST['UbahcarabayarR']['penjamin_id'],
            ]);
            $jenis = TariftindakanM::model()->findByAttributes(['jenistarif_id'=>$tindaanBaru->jenistarif_id]);
            $updatetindakan = TindakanpelayananT::model()->findAll("pendaftaran_id = ".$modPendaftaran->pendaftaran_id." AND tindakansudahbayar_id IS NULL ");
            if (!empty($updatetindakan)) {
                foreach ($updatetindakan as $key => $tindakan) {
                $ok = $ok && $this->updateTindakan($tindakan, $modPendaftaran);
                // var_dump($tindakan);die;
                }
            }

            $updateobat = ObatalkespasienT::model()->findAll("pendaftaran_id = ".$modPendaftaran->pendaftaran_id." AND oasudahbayar_id IS NULL ");

            if (!empty($updateobat)) {
                $jualResep = [];
                foreach ($updateobat as $key => $obatpas) {
                $obatpas->carabayar_id = $modPendaftaran->carabayar_id;
                $obatpas->penjamin_id = $modPendaftaran->penjamin_id;
                
                $ok &= $obatpas->save(false);
                }
            }
            
            if (isset($_POST['PPAsuransipasienbpjsM'])) {
                //var_dump($_POST['PPAsuransipasienbpjsM']); die;
                if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
                if ($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'] != "") {
                    $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
                }
                }

                if (empty($modAsuransiPasienBpjs)) {
                $modAsuransiPasienBpjs = new PPAsuransipasienM;
                }

                $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienbpjsM']);
                $modPendaftaran->status_konfirmasi = $modAsuransiPasienBpjs->status_konfirmasi;
                $modPendaftaran->tgl_konfirmasi = $modAsuransiPasienBpjs->tgl_konfirmasi;
                $modPendaftaran->asuransipasien_id = $modAsuransiPasienBpjs->asuransipasien_id;

                $modPendaftaran->save();
            } else {
                $this->asuransipasientersimpan = true;
            }

            if (!empty($modRujukanBpjs->rujukan_id) && !empty($modAsuransiPasienBpjs->asuransipasien_id)) {
                PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id, 'rujukan_id' => $modRujukanBpjs->rujukan_id, 'asuransipasien_id' => $modAsuransiPasienBpjs->asuransipasien_id));
            } else if (!empty($modAsuransiPasien->asuransipasien_id)) {
                PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id, 'asuransipasien_id' => $modAsuransiPasien->asuransipasien_id));
            } else {
                PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id));
            }

            if (isset($_POST['PPSepT'])) {
                $modSep = $this->simpanSep($modPendaftaran, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
            }

            // var_dump($ok, $modAsuransiPasien->attributes); die;
            // var_dump($ok); die;
            //die;
            if ($ok) {

                $this->notifUbahBayar($modPendaftaran);

                $transaction->commit();
                $this->notifUbahBayar($model);
                if (isset($modSep->nosep)) {
                $this->redirect(array('ubahCaraBayar', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1));
                } else {
                $this->redirect(array('ubahCaraBayar', 'id' => $model->pendaftaran_id, 'sukses' => 1));
                }
            } else {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data pasien gagal disimpan err1 !");
            }
            } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data pasien gagal disimpan err2 !");
            }
        } catch (Exception $exc) {
            $transaction->rollback(); var_dump($exc->getMessage(), $exc->getTraceAsString()); die;
            Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! (X)" . $exc->getMessage());
        }
        }
        // var_dump($modAsuransiPasien);die;
        $this->render(
        $this->path_view . '_formUbahCaraBayar',
        array(
            'model' => $model,
            'modPendaftaran' => $modPendaftaran,
            'modAsuransiPasien' => $modAsuransiPasien,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
            'modRujukanBpjs' => $modRujukanBpjs,
            'modSep' => $modSep,
        )
        );
    }

    private function updateTindakan($post, $daftar) {
        $ok = true;
        $tarif_tindakan = $post->getTarifSatuan($post->daftartindakan_id, $post->kelaspelayanan_id, $daftar, $ubah = true);
        
        // $post->kelaspelayanan_id = $daftar->kelaspelayanan_id;
        $post->carabayar_id = $daftar->carabayar_id;
        $post->penjamin_id = $daftar->penjamin_id;
        $post->tarif_satuan = !empty($tarif_tindakan) ? $tarif_tindakan : 0;
        $post->tarif_tindakan = $post->tarif_satuan * $post->qty_tindakan;
        $post->iurbiaya_tindakan = $post->tarif_tindakan - ($post->subsidiasuransi_tindakan + $post->subsidipemerintah_tindakan + $post->subsisidirumahsakit_tindakan);
        $post->cyto_tindakan = !empty($post->cyto_tindakan)?$post->cyto_tindakan:0;
        $tinkom = TindakankomponenT::model()->deleteAll(" tindakanpelayanan_id = ".$post->tindakanpelayanan_id);
        
        $detailLab = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array(
            'tindakanpelayanan_id'=>$post->tindakanpelayanan_id,
        ));
        $detailRad = HasilpemeriksaanradT::model()->findAllByAttributes(array(
            'tindakanpelayanan_id'=>$post->tindakanpelayanan_id,
        ));
        $detailRehab = HasilpemeriksaanrmT::model()->findAllByAttributes(array(
            'tindakanpelayanan_id'=>$post->tindakanpelayanan_id,
        ));
        $detailOperasi = RencanaoperasiT::model()->findAllByAttributes(array(
            'tindakanpelayanan_id'=>$post->tindakanpelayanan_id,
        ));

        // $new = clone $post;   
        // $new->isNewRecord = true;
        // $new->tindakanpelayanan_id = null;
        
        if ($post->save()) {
            foreach ($detailLab as $item) {
                $item->tindakanpelayanan_id = $post->tindakanpelayanan_id;
                $item->save();
            }
            foreach ($detailRad as $item) {
                $item->tindakanpelayanan_id = $post->tindakanpelayanan_id;
                $item->save();
            }
            foreach ($detailRehab as $item) {
                $item->tindakanpelayanan_id = $post->tindakanpelayanan_id;
                $item->save();
            }
            foreach ($detailOperasi as $item) {
                $item->tindakanpelayanan_id = $post->tindakanpelayanan_id;
                $item->save();
            }

            // $post->delete();
            $this->saveTindakanKomponen($post, $tarif_tindakan);

            $ok = true;
        } else {            
            $ok = false;
        }        
        return $ok;
    }

    protected function saveTindakanKomponen($tindakan, $tarif_tindakan)
    {   
        $res = Yii::app()->db
        ->createCommand("select ins_aftertindakanpelayanan_fix_id(".$tindakan->tindakanpelayanan_id.") as simpan")
        ->queryRow();

        // var_dump($res);
    }
    /**
     * untuk mengubah status periksa RD
     */
    public function actionUbahStatusPeriksaRD()
    {
        $pendaftaran_id = Yii::app()->session['pendaftaran_id'];
        $format = new MyFormatter();
        $model = PPPendaftaranT::model()->findByPk($pendaftaran_id);
        $model->statusperiksa = Params::STATUSPERIKSA_BATAL_PERIKSA;
        $modBatalPeriksa = new PasienbatalperiksaR;
        $model->tglselesaiperiksa = date('Y-m-d h:i:s');
        if (isset($_POST['PPPendaftaranT'])) {
        $update = PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => $_POST['PPPendaftaranT']['statusperiksa'], 'tglselesaiperiksa' => ($_POST['PPPendaftaranT']['tglselesaiperiksa'])));
        if (isset($_POST['PPPendaftaranT']['statusperiksa']) == "BATAL PERIKSA") {
            $modBatalPeriksa = new PasienbatalperiksaR;
            $modBatalPeriksa->pendaftaran_id = $pendaftaran_id;
            $modBatalPeriksa->pasien_id = $model->pasien_id;
            $modBatalPeriksa->tglbatal = $format->formatDateTimeForDb($_POST['PasienbatalperiksaR']['tglbatal']);
            $modBatalPeriksa->keterangan_batal = $_POST['PasienbatalperiksaR']['keterangan_batal'];
            $modBatalPeriksa->create_time = date('Y-m-d');
            $modBatalPeriksa->update_time = date('Y-m-d');
            $modBatalPeriksa->create_loginpemakai_id = Yii::app()->user->id;
            $modBatalPeriksa->update_loginpemakai_id = Yii::app()->user->id;
            $modBatalPeriksa->create_ruangan = Yii::app()->user->getState('ruangan_id');

            if ($modBatalPeriksa->validate()) {
            if ($modBatalPeriksa->save()) {
                PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienbatalperiksa_id' => $modBatalPeriksa->pasienbatalperiksa_id));
            }
            }
            if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
            ));
            exit;
            }
        }

        if ($update) {
            if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
            ));
            exit;
            }
        } else {

            if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
            ));
            exit;
            }
        }
        }

        if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
            'status' => 'create_form',
            'div' => $this->renderPartial('_ubahStatusPeriksa', array('model' => $model, 'modBatalPeriksa' => $modBatalPeriksa), true)
        ));
        exit;
        }
    }


    public function actionUbahKelasPelayanan()
    {
        $model = new PendaftaranT;
        $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
        if (isset($_POST['PendaftaranT'])) {
        if ($_POST['PendaftaranT']['kelaspelayanan_id'] != "") {
            $model->attributes = $_POST['PendaftaranT'];
            $transaction = Yii::app()->db->beginTransaction();
            try {
            $attributes = array('kelaspelayanan_id' => $_POST['PendaftaranT']['kelaspelayanan_id']);
            $save = $model::model()->updateByPk($_POST['PendaftaranT']['pendaftaran_id'], $attributes);
            if ($save) {
                $transaction->commit();
                echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Berhasil merubah Kelas Pelayanan.</div>",
                ));
            } else {
                echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                ));
            }
            exit;
            } catch (Exception $exc) {
            $transaction->rollback();
            }
        } else {
            echo CJSON::encode(
            array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Berhasil merubah data Kelas Pelayanan.</div>",
            )
            );
            exit;
        }
        }

        if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
            'status' => 'create_form',
            'div' => $this->renderPartial($this->path_view . '_formUbahKelasPelayananRJ', array('model' => $model, 'menu' => $menu), true)
        ));
        exit;
        }
    }

    /*
            * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
            * and open the template in the editor.
            */
    public function actionSetDropdownKelasPelayanan()
    {
        if (Yii::app()->request->isAjaxRequest) {
        $ruangan_id = $_POST['ruangan_id'];
        if ($ruangan_id) {
            $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=' . $ruangan_id . ' and kelaspelayanan_aktif = true');
            $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
        }
        if (empty($kelasPelayanan)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            foreach ($kelasPelayanan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }
        }
        Yii::app()->end();
    }

    public function actionGetListCaraBayar()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
        $idCaraBayar = $_POST['idCaraBayar'];

        $carabayars = CarabayarM::model()->findAllByAttributes(array('carabayar_aktif' => true), array('order' => 'carabayar_nama'));
        $carabayars = CHtml::listData($carabayars, 'carabayar_id', 'carabayar_nama');
        $Option = "";
        foreach ($carabayars as $value => $name) {
            if ($value == $idCaraBayar)
            $Option .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
            else
            $Option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }

        $dataList['listCaraBayar'] = $Option;

        $penjamins = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $idCaraBayar, 'penjamin_aktif' => true), array('order' => 'penjamin_nama'));
        $penjamins = CHtml::listData($penjamins, 'penjamin_id', 'penjamin_nama');
        $Option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        foreach ($penjamins as $value => $name) {
            if ($value == $idCaraBayar)
            $Option .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
            else
            $Option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }

        $dataList['listPenjamin'] = $Option;

        echo json_encode($dataList);
        Yii::app()->end();
        }
    }

    public function actionGetDataPendaftaranRI()
    {
        if (Yii::app()->request->isAjaxRequest) {
        $id_pendaftaran = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
        $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
            $returnVal["$attribute"] = $model->$attribute;
        }
        echo json_encode($returnVal);
        Yii::app()->end();
        }
    }

    public function actionGetListPenjamin()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
        $idCaraBayar = $_POST['idCaraBayar'];
        $idPenjamin = (isset($_POST['idPenjamin'])) ? $_POST['idPenjamin'] : '';

        $penjamins = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $idCaraBayar, 'penjamin_aktif' => true), array('order' => 'penjamin_nama'));
        $penjamins = CHtml::listData($penjamins, 'penjamin_id', 'penjamin_nama');
        $Option = "";
        foreach ($penjamins as $value => $name) {
            if ($value == $idPenjamin)
            $Option .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
            else
            $Option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }

        $dataList['listPenjamin'] = $Option;

        echo json_encode($dataList);
        Yii::app()->end();
        }
    }

    public function actionUbahKeteranganPendaftaran()
    {
        $model = new PendaftaranT;
        if (isset($_POST['PendaftaranT'])) {
        if ($_POST['PendaftaranT']['keterangan_pendaftaran'] != "") {
            $model->attributes = $_POST['PendaftaranT'];
            $transaction = Yii::app()->db->beginTransaction();
            try {
            $attributes = array('keterangan_pendaftaran' => $_POST['PendaftaranT']['keterangan_pendaftaran']);
            $save = $model::model()->updateByPk($_POST['PendaftaranT']['pendaftaran_id'], $attributes);
            if ($save) {
                $transaction->commit();
                echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Berhasil merubah Keterangan Pendaftaran.</div>",
                ));
            } else {
                echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                ));
            }
            exit;
            } catch (Exception $exc) {
            $transaction->rollback();
            }
        } else {
            echo CJSON::encode(
            array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Berhasil merubah data Keterangan Pendaftaran.</div>",
            )
            );
            exit;
        }
        }

        if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
            'status' => 'create_form',
            'div' => $this->renderPartial($this->path_view . '_formUbahKeterangan', array('model' => $model), true)
        ));
        exit;
        }
    }

    public function actionGetDataPendaftaranRD()
    {
        if (Yii::app()->request->isAjaxRequest) {
        $id_pendaftaran = $_POST['pendaftaran_id'];
        $model = InfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
            $returnVal["$attribute"] = $model->$attribute;
        }
        $returnVal['gelardepan'] = (empty($model->gelardepan) ? "" : $model->gelardepan);
        $returnVal['dokter'] = $model->nama_pegawai;
        $returnVal['gelarbelakang_nama'] = (empty($model->gelarbelakang_nama) ? "" : $model->gelarbelakang_nama);
        echo json_encode($returnVal);
        Yii::app()->end();
        }
    }

    /**
     * untuk load data dokter di Informasi Kunjungan Rawat Jalan
     */
    public function actionGetDataPendaftaranRJ()
    {
        if (Yii::app()->request->isAjaxRequest) {
        $id_pendaftaran = $_POST['pendaftaran_id'];
        $model = InfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
            $returnVal["$attribute"] = $model->$attribute;
        }
        $returnVal["no_pendaftaran"] = $model->no_pendaftaran;
        $returnVal["pendaftaran_id"] = $model->pendaftaran_id;
        $returnVal["gelardepan"] = (isset($model->gelardepan) ? $model->gelardepan : "");
        $returnVal["gelarbelakang_nama"] = (isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "");
        echo json_encode($returnVal);
        Yii::app()->end();
        }
    }

    public function actionGetKasusPenyakit()
    {
        if (Yii::app()->request->isAjaxRequest) {
        $ruangan_id = $_POST['id_ruangan'];
        $jenisKasusPenyakit = array();
        if (!empty($ruangan_id)) {
            $sql = "SELECT jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama 
                                FROM jeniskasuspenyakit_m
                                JOIN kasuspenyakitruangan_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id
                                JOIN ruangan_m ON kasuspenyakitruangan_m.ruangan_id = ruangan_m.ruangan_id
                                WHERE ruangan_m.ruangan_id = '$ruangan_id'
                                ORDER BY jeniskasuspenyakit_m.jeniskasuspenyakit_nama ASC";
            $modJenKasusPenyakit = JeniskasuspenyakitM::model()->findAllBySql($sql);

            $jenisKasusPenyakit = CHtml::listData($modJenKasusPenyakit, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
        }
        if (empty($jenisKasusPenyakit)) {
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            foreach ($jenisKasusPenyakit as $value => $name) {
            $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }
        $dataList['listPenyakit'] = $option;
        echo json_encode($dataList);
        Yii::app()->end();
        }
    }

    public function actionGetRuanganPasienRD()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
        $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
        $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
        $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
        $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);
        $jenisKasusPenyakit = null;
        if (isset($_POST['jeniskasuspenyakit_id'])) {
            $jeniskasuspenyakit_id = (isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null);
            $criteria = new CDbCriteria;
            $criteria->select = 't.ruangan_id, t.jeniskasuspenyakit_id, ruangan_m.ruangan_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,
                                            jeniskasuspenyakit_aktif';
            if (!empty($ruangan_id)) {
            $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
            }
            if (!empty($jeniskasuspenyakit_id)) {
            $criteria->addCondition("t.jeniskasuspenyakit_id = " . $jeniskasuspenyakit_id);
            }
            $criteria->addCondition('jeniskasuspenyakit_m.jeniskasuspenyakit_aktif is true');
            $criteria->join = 'LEFT JOIN ruangan_m on t.ruangan_id = ruangan_m.ruangan_id
                                        LEFT JOIN jeniskasuspenyakit_m on t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
                                            ';
            $dataJenisPenyakit = KasuspenyakitruanganM::model()->findAll($criteria);
            //                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');

            foreach ($dataJenisPenyakit as $jenisPenyakit) {
            if ($jenisPenyakit['jeniskasuspenyakit_id'] == $jeniskasuspenyakit_id) {
                $jenisKasusPenyakit .= '<option value="' . $jenisPenyakit['jeniskasuspenyakit_id'] . '" selected="selected">' . $jenisPenyakit['jeniskasuspenyakit_nama'] . '</option>';
            } else {
                $jenisKasusPenyakit .= '<option value="' . $jenisPenyakit['jeniskasuspenyakit_id'] . '">' . $jenisPenyakit['jeniskasuspenyakit_nama'] . '</option>';
            }
            }
            $data['jenisKasusPenyakit'] = $jenisKasusPenyakit;
        }

        if (isset($_POST['pegawai_id'])) {
            $dokter = null;
            $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            $criteria = new CDbCriteria;
            $criteria->select = 't.ruangan_id, t.pegawai_id, t.nama_pegawai';
            if (!empty($ruangan_id)) {
            $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
            }
            if (!empty($jeniskasuspenyakit_id)) {
            $criteria->addCondition("t.pegawai_id = " . $pegawai_id);
            }
            $dataDokter = DokterV::model()->findAll($criteria);
            //                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');

            foreach ($dataDokter as $dokters) {
            if ($dokters['pegawai_id'] == $pegawai_id) {
                $dokter .= '<option value="' . $dokters['pegawai_id'] . '" selected="selected">' . $dokters['nama_pegawai'] . '</option>';
            } else {
                $dokter .= '<option value="' . $dokters['pegawai_id'] . '">' . $dokters['nama_pegawai'] . '</option>';
            }
            }
            $data['dokter'] = $dokter;
        }

        $dropDown = '';
        $criteria2 = new CDbCriteria;
        $criteria2->select = 't.ruangan_id, t.instalasi_id, ruangan_m.ruangan_nama, instalasi_m.instalasi_nama,
                                            ruangan_m.ruangan_aktif';
        //					if(!empty($instalasi_id)){$criteria->addCondition("t.instalasi_id = ".$instalasi_id); }
        $criteria2->addCondition('t.instalasi_id in (3,14)');
        //                if(!empty($ruangan_id)){
        //						$criteria->addCondition("t.ruangan_id = ".$ruangan_id);
        //                }
        $criteria2->addCondition('ruangan_m.ruangan_aktif is true');
        $criteria2->join = 'LEFT JOIN ruangan_m on t.ruangan_id = ruangan_m.ruangan_id
                                        LEFT JOIN instalasi_m on t.instalasi_id = instalasi_m.instalasi_id
                                            ';
        $dataRuangan = InstalasipenddaruratV::model()->findAll($criteria2);
        //            $dataRuangan =InstalasipenddaruratV::model()->findAll('instalasi_id='.$instalasi_id.' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
        foreach ($dataRuangan as $tampilRuangan) {
            if ($tampilRuangan['ruangan_id'] == $ruangan_id) {
            $dropDown .= '<option value="' . $tampilRuangan['ruangan_id'] . '" selected="selected" onchange="getKasusPenyakit(' . $ruangan_id . ')">' . $tampilRuangan['ruangan_nama'] . '</option>';
            } else {
            $dropDown .= '<option value="' . $tampilRuangan['ruangan_id'] . '" onchange="return getKasusPenyakit(' . $ruangan_id . ')">' . $tampilRuangan['ruangan_nama'] . '</option>';
            }
        }
        $data['dropDown'] = $dropDown;
        echo json_encode($data);
        Yii::app()->end();
        }
    }

    /**
     * method untuk pindah ruangan poli klinik
     * digunakan di :
     * 1. Pendaftaran Penjadwalan -> informasi Rawat Jalan -> poliklinik
     * 2. Pendaftaran Penjadwalan -> informasi Rawat Darurat -> rawat darurat
     * 3. Pendaftaran Penjadwalan -> informasi Rawat Inap -> ruangan
     */
    /**
     * untuk merubah ruangan  (copy dari InfoKunjunganRJ)
     */
    public function actionUbahRuangan()
    {
        $updatetindakan = false;
        parse_str($_POST['post'], $post);
        $model = PendaftaranT::model()->findByPk($post['pendaftaran_id']);
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = "Data perubahan ruangan gagal disimpan! ";
        $transaction = Yii::app()->db->beginTransaction();
        try {
        $sukses = false;
        $modRiwayat = new UbahruanganR;
        $modRiwayat->ruanganawal_id = $model->ruangan_id;
        $modRiwayat->menjadiruangan_id = $post['ruangan_id_ganti'];
        $modRiwayat->alasanperubahan = $post['alasanperubahan'];
        $modRiwayat->pendaftaran_id = $model->pendaftaran_id;
        $modRiwayat->tglperubahan = date('Y-m-d H:i:s');
        $modRiwayat->pasien_id = $model->pasien_id;
        if ($modRiwayat->validate()) {
            if ($modRiwayat->save()) {
            $sukses = true;
            }
            $model->ruangan_id = $post['ruangan_id_ganti'];
            $model->jeniskasuspenyakit_id = $post['jeniskasuspenyakit_id_ganti'];
            $model->pegawai_id = $post['pegawai_id_ganti'];
            $model->no_urutantri = MyGenerator::noAntrianJanjiPoli($model->ruangan_id);
            if ($model->update()) {
            $sukses &= true;
            if (isset($post['is_ubahkarcis'])) { //checked
                $tindakanpelayanan = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id IS NULL");
                if (count((array)$tindakanpelayanan) > 0) {
                $data['pesan'] = "Data perubahan ruangan gagal disimpan! Pendaftaran ini sudah pernah input tindakan!";
                } else {
                if (!empty($model->karcis_id)) {
                    $karcis_id_hapus = $model->karcis_id;
                    $model->karcis_id = null;
                    $model->update();
                    TindakanpelayananT::model()->deleteAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id, 'karcis_id' => $karcis_id_hapus));
                }
                $modTindakan = new TindakanpelayananT;
                $modTindakan->attributes = $model->attributes;
                $modTindakan->tgl_tindakan = date("Y-m-d H:i:s");
                $modTindakan->karcis_id = $post['TindakanpelayananT']['idKarcis'];
                $modTindakan->daftartindakan_id = $post['TindakanpelayananT']['idTindakan'];
                $modTindakan->tarif_satuan = $post['TindakanpelayananT']['tarifSatuan'];
                $modTindakan->qty_tindakan = 1;
                $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
                $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
                $modTindakan->cyto_tindakan = (!empty($modTindakan->cyto_tindakan) ? $modTindakan->cyto_tindakan : 0);
                $modTindakan->tarifcyto_tindakan = ($modTindakan->cyto_tindakan ? ($modTindakan->tarifcyto_tindakan > 0 ? $modTindakan->tarifcyto_tindakan : 0) : 0);
                $modTindakan->discount_tindakan = 0;
                $modTindakan->tipepaket_id = $this->tipePaketKarcis($model, $modTindakan);
                $modTindakan->subsidiasuransi_tindakan = 0;
                $modTindakan->subsidipemerintah_tindakan = 0;
                $modTindakan->subsisidirumahsakit_tindakan = 0;
                $modTindakan->iurbiaya_tindakan = 0;
                $modTindakan->create_time = date("Y-m-d H:i:s");
                $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
                $modTindakan->validate();
                if ($modTindakan->validate()) {
                    $modTindakan->save();
                    $model->karcis_id = $modTindakan->karcis_id;
                    $model->update();
                    $sukses &= true;
                } else {
                    $data['pesan'] = "Data karcis gagal disimpan!";
                    $sukses &= false;
                }
                }
            }
            } else {
            $sukses &= false;
            }
        }

        if ($sukses) {
            $data['sukses'] = 1;
            $data['pesan'] = "Data perubahan ruangan / poliklinik berhasil disimpan!";
            $transaction->commit();
        } else {
            $transaction->rollback();
        }
        } catch (Exception $exc) {
        $data['pesan'] = 'Gagal Disimpan! ' . $exc;
        $transaction->rollback();
        }

        echo CJSON::encode($data);
        Yii::app()->end();
    }

    public function tipePaketKarcis($model, $karcis)
    {
        $criteria = new CDbCriteria;

        $daftartindakan_id = (isset($karcis->daftartindakan_id) ? $karcis->daftartindakan_id : null);
        $criteria->with = array('tipepaket');
        if (!empty($daftartindakan_id)) {
        $criteria->addCondition("daftartindakan_id = " . $daftartindakan_id);
        }
        if (!empty($model->carabayar_id)) {
        $criteria->addCondition("tipepaket.carabayar_id = " . $model->carabayar_id);
        }
        if (!empty($model->penjamin_id)) {
        $criteria->addCondition("tipepaket.penjamin_id = " . $model->penjamin_id);
        }
        if (!empty($model->kelaspelayanan_id)) {
        $criteria->addCondition("tipepaket.kelaspelayanan_id = " . $model->kelaspelayanan_id);
        }
        $result = Params::TIPEPAKET_ID_NONPAKET;
        $paket = PaketpelayananM::model()->find($criteria);
        if (isset($paket->tipepaket_id)) $result = $paket->tipepaket_id;

        return $result;
    }

    public function actionUbahJenisKelamin()
    {
        $model = new PasienM;
        if (isset($_POST['PasienM'])) {
        $model->attributes = $_POST['PasienM'];
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $attributes = array('jeniskelamin' => $_POST['PasienM']['jeniskelamin']);
            $save = PasienM::model()->updateByPk($_POST['PasienM']['pasien_id'], $attributes);
            if ($save) {
            $transaction->commit();
            echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Berhasil merubah data Jenis Kelamin Pasien.</div>",
            ));
            } else {
            echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
            }
            exit;
        } catch (Exception $exc) {
            $transaction->rollback();
        }
        }

        if (Yii::app()->request->isAjaxRequest) {

        echo CJSON::encode(array(
            'status' => 'create_form',
            'div' => $this->renderPartial('_formUbahJenisKelamin', array('model' => $model), true)
        ));
        exit;
        }
    }

    public function actionUbahDokterPeriksa()
    {
        $model = new PPPendaftaranT;
        $modUbahDokter = new PPUbahdokterR;
        $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
        if (isset($_POST['PPPendaftaranT'])) {
        if ($_POST['PPPendaftaranT']['pegawai_id'] != "") {
            $model->attributes = $_POST['PPPendaftaranT'];
            $modUbahDokter->attributes = $_POST['PPUbahdokterR'];
            $modUbahDokter->pendaftaran_id = $_POST['PPPendaftaranT']['pendaftaran_id'];
            $modUbahDokter->dokterbaru_id = $_POST['PPPendaftaranT']['pegawai_id'];
            $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
            $modUbahDokter->create_time = date('Y-m-d H:i:s');
            $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
            $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $transaction = Yii::app()->db->beginTransaction();
            try {
            $attributes = array('pegawai_id' => $_POST['PPPendaftaranT']['pegawai_id']);
            $save = $model::model()->updateByPk($_POST['PPPendaftaranT']['pendaftaran_id'], $attributes);
            if ($save) {
                $modUbahDokter->save();
                $transaction->commit();
                echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
                ));
            } else {
                echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                ));
            }
            exit;
            } catch (Exception $exc) {
            $transaction->rollback();
            }
        } else {
            echo CJSON::encode(
            array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
            )
            );
            exit;
        }
        }

        if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
            'status' => 'create_form',
            'div' => $this->renderPartial($this->path_view . '_formUbahDokterPeriksa', array('model' => $model, 'menu' => $menu, 'modUbahDokter' => $modUbahDokter), true)
        ));
        exit;
        }
    }

    public function actionListDokterRuangan()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
        $idPegawai = null;
        if (isset($_POST['idPegawai'])) $idPegawai = $_POST['idPegawai'];
        if (!empty($_POST['idRuangan'])) {
            $idRuangan = $_POST['idRuangan'];
            $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
            $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');

            if (empty($data)) {
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            } else {
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            foreach ($data as $value => $name) {
                if ($value == $idPegawai) continue;
                $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            }

            $dataList['listDokter'] = $option;
        } else {
            $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }

        echo json_encode($dataList);
        Yii::app()->end();
        }
    }

    public function actionBuatSessionUbahStatus()
    {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        if (!empty($_POST['pendaftaran_id'])) {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        Yii::app()->session['pendaftaran_id'] = $pendaftaran_id;
        }
        Yii::app()->session['pendaftaran_id'] =  $pendaftaran_id;
        echo CJSON::encode(array(
        'pendaftaran_id' => Yii::app()->session['pendaftaran_id']
        ));
    }

    /**
     * Mengatur dropdown kabupaten
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
        $modPasien = new PPPasienM;
        if ($model_nama !== '' && $attr == '') {
            $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
        } elseif ($model_nama == '' && $attr !== '') {
            $propinsi_id = $_POST["$attr"];
        } elseif ($model_nama !== '' && $attr !== '') {
            $propinsi_id = $_POST["$model_nama"]["$attr"];
        }
        $kabupaten = null;
        if ($propinsi_id) {
            $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
            $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
        }
        if ($encode) {
            echo CJSON::encode($kabupaten);
        } else {
            if (empty($kabupaten)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            foreach ($kabupaten as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            }
        }
        }
        Yii::app()->end();
    }
    /**
     * Mengatur dropdown kecamatan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
        $modPasien = new PPPasienM;
        if ($model_nama !== '' && $attr == '') {
            $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
        } elseif ($model_nama == '' && $attr !== '') {
            $kabupaten_id = $_POST["$attr"];
        } elseif ($model_nama !== '' && $attr !== '') {
            $kabupaten_id = $_POST["$model_nama"]["$attr"];
        }
        $kecamatan = null;
        if ($kabupaten_id) {
            $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
            $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
        }

        if ($encode) {
            echo CJSON::encode($kecamatan);
        } else {
            if (empty($kecamatan)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            foreach ($kecamatan as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            }
        }
        }
        Yii::app()->end();
    }
    /**
     * Mengatur dropdown kelurahan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
        $modPasien = new PPPasienM;
        if ($model_nama !== '' && $attr == '') {
            $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
        } elseif ($model_nama == '' && $attr !== '') {
            $kecamatan_id = $_POST["$attr"];
        } elseif ($model_nama !== '' && $attr !== '') {
            $kecamatan_id = $_POST["$model_nama"]["$attr"];
        }
        $kelurahan = null;
        if ($kecamatan_id) {
            $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
            //                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
            $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
        }

        if ($encode) {
            echo CJSON::encode($kelurahan);
        } else {
            if (empty($kelurahan)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            foreach ($kelurahan as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            }
        }
        }
        Yii::app()->end();
    }
    /**
     * set dropdown daerah pasien berdasarkan
     * propinsi_id
     * kabupaten_id
     * kecamatan_id
     * kelurahan_id
     * pasien_id
     */
    public function actionSetDropdownDaerahPasien()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
        $modPasien = new PPPasienM;
        $propinsi_id = $_POST['propinsi_id'];
        $kabupaten_id = $_POST['kabupaten_id'];
        $kecamatan_id = $_POST['kecamatan_id'];
        $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

        $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
        $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
        $propinsiOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
        foreach ($propinsis as $value => $name) {
            if ($value == $propinsi_id)
            $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
            else
            $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
        //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
        $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
        $kabupatenOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
        foreach ($kabupatens as $value => $name) {
            if ($value == $kabupaten_id)
            $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
            else
            $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
        //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
        $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
        $kecamatanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
        foreach ($kecamatans as $value => $name) {
            if ($value == $kecamatan_id)
            $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
            else
            $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
        $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
        $kelurahanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
        foreach ($kelurahans as $value => $name) {
            if ($value == $kelurahan_id)
            $kelurahanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
            else
            $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }

        $dataList['listPropinsi'] = $propinsiOption;
        $dataList['listKabupaten'] = $kabupatenOption;
        $dataList['listKecamatan'] = $kecamatanOption;
        $dataList['listKelurahan'] = $kelurahanOption;

        echo json_encode($dataList);
        Yii::app()->end();
        }
    }

    public function actionGetPenjaminPasien($encode = false, $namaModel = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
        $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

        if ($encode) {
            echo CJSON::encode($penjamin);
        } else {
            if (empty($carabayar_id)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            } else {
            $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
            if (count((array)$penjamin) > 1) {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            }
            $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
            foreach ($penjamin as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            }
        }
        }
        Yii::app()->end();
    }

    /**
     * menampilkan karcis (copy dari InfoKunjunganRJ)
     */
    public function actionListKarcis()
    {
        if (Yii::app()->request->isAjaxRequest) {
        $kelasPelayanan = $_POST['kelasPelayanan'];
        $ruangan = $_POST['ruangan'];
        $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
        $modPendaftaran =  PendaftaranT::model()->findByPk($pendaftaran_id);
        $penjamin_id = $modPendaftaran->penjamin_id;
        //                $penjamin_id=$_POST['penjamin_id'];
        $modelKarcis = null;
        $form = '';
        if (!empty($ruangan)) {
            $karcis = Yii::app()->user->getState('karcisbarulama');
            if ($karcis) {
            $pasienLama = (isset($_POST['pasienLama']) ? (($_POST['pasienLama'] > 0) ? false : true) : false);
            $modelKarcis = KarcisV::model()->findByAttributes(array('penjamin_id' => $penjamin_id, "kelaspelayanan_id" => $kelasPelayanan, "ruangan_id" => $ruangan, 'pasienbaru_karcis' => $pasienLama));
            } else {
            $modelKarcis = KarcisV::model()->findByAttributes(array('penjamin_id' => $penjamin_id, "kelaspelayanan_id" => $kelasPelayanan, "ruangan_id" => $ruangan));
            }
            $modKarcisV = KarcisV::model()->findAll('kelaspelayanan_id=' . $kelasPelayanan . ' AND ruangan_id=' . $ruangan . ' AND penjamin_id=' . $penjamin_id . '');
            foreach ($modKarcisV as $tampil) {
            if ($karcis) {
                if ($ruangan == Params::RUANGAN_ID_LAB) {
                $form .= '<tr>
                                            <td><a data-karcis="' . $tampil['karcis_id'] . '"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,' . $tampil['daftartindakan_id'] . ',' . $tampil['harga_tariftindakan'] . ',' . $tampil['karcis_id'] . ');return false;">
                                                <i class="icon-form-check"></i>
                                                </a></td>                                    
                                            <td>' . $tampil['karcis_nama'] . '</td>
                                            <td>' . CHtml::hiddenField('tarifKarcis', $tampil['harga_tariftindakan']) . $tampil['harga_tariftindakan'] . '</td>
                                        </tr>';
                } else if ($ruangan == Params::RUANGAN_ID_RAD) {
                $form .= '<tr>
                                            <td><a data-karcis="' . $tampil['karcis_id'] . '"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,' . $tampil['daftartindakan_id'] . ',' . $tampil['harga_tariftindakan'] . ',' . $tampil['karcis_id'] . ');return false;">
                                                <i class="icon-form-check"></i>
                                                </a></td>                                    
                                            <td>' . $tampil['karcis_nama'] . '</td>
                                            <td>' . CHtml::hiddenField('tarifKarcis', $tampil['harga_tariftindakan']) . $tampil['harga_tariftindakan'] . '</td>
                                        </tr>';
                } else {
                //                                if (in_array($tampil['karcis_id'], $karcisM))
                //                                {
                $form .= '<tr>
                                                <td>' . $tampil['karcis_nama'] . '</td>
                                                <td>' . CHtml::hiddenField('tarifKarcis', $tampil['harga_tariftindakan']) . $tampil['harga_tariftindakan'] . '</td>
                                                <td><a data-karcis="' . $tampil['karcis_id'] . '"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,' . $tampil['daftartindakan_id'] . ',' . $tampil['harga_tariftindakan'] . ',' . $tampil['karcis_id'] . ');return false;">
                                                    <i class="icon-form-check"></i>
                                                    </a></td>    
                                            </tr>';
                //                                }                                
                }
            } else {
                $form .= '<tr>
                                        <td>' . $tampil['karcis_nama'] . '</td>
                                        <td>' . $tampil['harga_tariftindakan'] . '</td>
                                        <td><a data-karcis="' . $tampil['karcis_id'] . '"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,' . $tampil['daftartindakan_id'] . ',' . $tampil['harga_tariftindakan'] . ',' . $tampil['karcis_id'] . ');return false;">
                                            <i class="icon-form-check"></i>
                                            </a></td>    
                                    </tr>';
            }
            }
        }
        $data['karcis'] = (!empty($modelKarcis)) ? ((isset($modelKarcis->attributes)) ? $modelKarcis->attributes : 0) : 0;
        $data['form'] = $form;
        echo json_encode($data);
        Yii::app()->end();
        }
    }
    public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien)
    {
        $format = new MyFormatter();
        $modAsuransiPasien->attributes = $postAsuransiPasien;
        $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
        $modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id']) ? $postPendaftaran['penjamin_id'] : null;
        $modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
        $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
        $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);

        if (empty($modAsuransiPasien->nopeserta)) $modAsuransiPasien->nopeserta = $modAsuransiPasien->nokartuasuransi;

        if ($modAsuransiPasien->save()) {
        $this->asuransipasientersimpan = true;
        }
        return $modAsuransiPasien;
    }

    public function actionCariPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
        $noRM = (isset($_POST['norekammedik']) ? $_POST['norekammedik'] : null);

        $model = PasienM::model()->findByAttributes(array('no_rekam_medik' => $noRM));
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
            $returnVal["$attribute"] = $model->$attribute;
        }

        echo json_encode($returnVal);
        Yii::app()->end();
        }
    }

    /**
     * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * 
     * - digunakan untuk membuat notifikasi, jika ada perubahan cara bayar
     * @param type $model
     * @return type
     */
    public function notifUbahBayar($model)
    {

        $judul = 'Perubahan Jenis Penjamin & Penjamin';

        $isi = $model->no_pendaftaran . ' ' . $model->pasien->no_rekam_medik . ' ' . $model->pasien->nama_pasien;
        $r = RuanganM::model()->findByPk($model->ruangan_id);

        return CustomFunction::broadcastNotif($judul, $isi, array(
        //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),											   
        array('instalasi_id' => $r->instalasi_id, 'ruangan_id' => $r->ruangan_id, 'modul_id' => $r->modul_id),
        ));
    }


    public function actionBatalRawatInap($pendaftaran_id) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = RDPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modPasienBatalPulang = new PasienbatalpulangT;
        $tersimpan = 'tidak';

        if (!empty($_POST['PasienbatalpulangT'])) {


            $pasienPulangId = $_POST['pasienpulang_id'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $format = new MyFormatter();
            $modPasienBatalPulang->attributes = $_POST['PasienbatalpulangT'];
            $modPasienBatalPulang->create_time = date('Y-m-d H:i:s');
            $modPasienBatalPulang->update_time = date('Y-m-d H:i:s');
            $modPasienBatalPulang->tglpembatalan = $format->formatDateTimeForDb($modPasienBatalPulang->tglpembatalan);
            $modPasienBatalPulang->namauser_otorisasi = Yii::app()->user->name;
            $modPasienBatalPulang->iduser_otorisasi = Yii::app()->user->id;
            $modPasienBatalPulang->create_loginpemakai_id = Yii::app()->user->id;
            $modPasienBatalPulang->update_loginpemakai_id = Yii::app()->user->id;
            $modPasienBatalPulang->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPasienBatalPulang->pasienpulang_id = $pasienPulangId;
            if ($modPasienBatalPulang->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($modPasienBatalPulang->save()) {
                        $pulang = RDPasienPulangT::model()->updateByPk($pasienPulangId, array('pasienbatalpulang_id' => $modPasienBatalPulang->pasienbatalpulang_id));
                        $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id' => null, 'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));

                        if ($pulang && $pendaftaran) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                            $tersimpan = 'Ya';
                            //                          
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "Data gagal disimpan");
                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpanx");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, false));
                }
            } else {
                Yii::app()->user->setFlash('error', "Data gagal disimpan");
            }
        }
        $this->render('formBatalRawatInap', array('modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modPasienBatalPulang' => $modPasienBatalPulang, 'tersimpan' => $tersimpan));
    }

    /**
         * actionPasienPulang = transaksi - pasien pulang
         */
        public function actionPasienPulang($pendaftaran_id = null, $dialog = false) {
        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
        $smspasien = 1;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id', $modul_id);
        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
        if (isset($_POST['tujuansms'])) {
            $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

        if ($dialog)
            $this->layout = '//layouts/iframe';
        $tersimpan = false;
        $gagalSimpanAlert = false;
        if (!empty($pendaftaran_id)) {
            $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
            if (!$modPendaftaran) {
                Yii::app()->user->setFlash('error', 'Pendaftaran Tidak Ditemukan !');
            } else {
                $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
            }
            //                if(!empty($modPendaftaran->pasienpulang_id)){
            //                    echo "Pasien Telah Ditindaklanjut Dari Rawat Darurat !";
            //                    exit;
            //                }
        } else {
            $modPendaftaran = new RDPendaftaranT;
            $modPasien = new RDPasienM;
        }
        $modelPulang = new RDPasienPulangT;
        $modRujukanKeluar = new PasiendirujukkeluarT;

        $modelPulang->tglpasienpulang = date('d M Y H:i:s');
        $modelPulang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modelPulang->pasien_id = $modPasien->pasien_id;

        $modRujukanKeluar->pegawai_id = PendaftaranT::model()->findByPk($pendaftaran_id)->pegawai_id;
        $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id'); //ruangan asal itu diasumsikan ruangan terakhir dia dari mana
        $modRujukanKeluar->tgldirujuk = date('d M Y H:i:s');
        $modRujukanKeluar->tglberlakusurat = date('d M Y H:i:s');
        $format = new MyFormatter();
        $date1 = $format->formatDateTimeForDb($modPendaftaran->tgl_pendaftaran);
        $date2 = date('Y-m-d H:i:s');
        $diff = abs(strtotime($date2) - strtotime($date1));
        $hours = floor(($diff) / 3600);
        $selisihHariRawat = CustomFunction::hitungHariRawat($date1);

        $modelPulang->lamarawat = $hours;
        $modelPulang->hariperawatan = $selisihHariRawat;

        $modUbahStatus = new PengirimanrmT;
        $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');
        $modUbahStatus->petugaspengirim = Yii::app()->user->name;
        $modUbahStatus->petugaspengirim_id = Yii::app()->user->getState('pegawai_id');
        $modUbahStatus->ruangan_id = Params::RUANGAN_ID_REKAM_MEDIS;
        $modUbahStatus->instalasi_id = Params::INSTALASI_ID_RM;

        if (isset($_POST['RDPasienPulangT'])) {
            if (!empty($_POST['RDPendaftaranT']['pendaftaran_id']))
                $modPendaftaran = $modPendaftaran->findByPk($_POST['RDPendaftaranT']['pendaftaran_id']);
            if (!empty($_POST['RDPasienM']['pasien_id']))
                $modPasien = $modPasien->findByPk($_POST['RDPasienM']['pasien_id']);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modelPulang = $this->savePasienPulang($modelPulang, $_POST['RDPasienPulangT']);



                if (isset($_POST['pakeRujukan'])) {
                    $modelPulang->pakeRujukan = true;
                    $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar, $modelPulang, $_POST['PasiendirujukkeluarT']);
                } else {
                    $this->validRujukan = true;
                }

                if (isset($_POST['isDead'])) {
                    // $modPasien = PasienM::model()->findByPk(Yii::app()->session['pasien_id']);
                    $modPasien = PasienM::model()->findByPk($_POST['RDPasienPulangT']['pasien_id']);
                    $modPasien->tgl_meninggal = !empty($_POST['RDPasienPulangT']['tgl_meninggal']) ? $format->formatDateTimeForDb($_POST['RDPasienPulangT']['tgl_meninggal']) : date('Y-m-d H:i:s');
                    $modPasien->save();
                }
                //var_dump($this->validPulang && $this->validRujukan);
                //var_dump($modPasien->attributes); die;
                if ($this->validPulang && $this->validRujukan) {

                    $ok = true;


                    if ($modelPulang->carakeluar_id != Params::CARAKELUAR_ID_RAWATINAP) {

                        if ($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) {
                            $this->notifPasienMeninggal($modPasien, $modelPulang);
                        } else {
                            PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'statusperiksa' => 'SUDAH PULANG'));
                            $ok = $this->notifPasienPulang($modPendaftaran, $modelPulang);
                        }
                    } else {
                        PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'statusperiksa' => Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO));
                        $this->notifPasienRujukKeRawatInap($modPendaftaran);
                    }

                    //var_dump($_POST['PengirimanrmT']);die;
                    if (isset($_POST['PengirimanrmT'])) {

                        $ok = $ok && $this->simpanPengirimanDokRM($modPendaftaran, $_POST['PengirimanrmT'], $modPasien->dokrekammedis_id);
                    }

                    PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'pasienpulang_id' => $modelPulang->pasienpulang_id));
                    //var_dump($ok);
                    //die;
                    // var_dump($ok); die;
                    // SMS GATEWAY

                    $modCaraKeluar = $modelPulang->carakeluar;
                    $modKondisiKeluar = $modelPulang->kondisikeluar;
                    $sms = new Sms();
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $modPasien->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }
                            $attributes = $modelPulang->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }
                            $attributes = $modKondisiKeluar->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }
                            $attributes = $modCaraKeluar->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }
                            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modelPulang->tglpasienpulang), $isiPesan);

                            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                                if (!empty($modPasien->no_mobile_pasien)) {
                                    $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                                } else {
                                    $smspasien = 0;
                                }
                            }
                        }
                    }


                    if (Yii::app()->user->getState('isbridging') == true && isset($_POST['SepT'])) {
                        $sep = SepT::model()->findByPk($modPendaftaran->sep_id);
                        if (!empty($sep)) {
                            $sep->attributes = $_POST['SepT'];
                            $sep->tgl_meninggal = $modelPulang->tgl_meninggal;
                            $sep->statuspulang_kode = $modelPulang->carakeluar_id;
                            $sep->tglpulang = $modelPulang->tglpasienpulang;
                            $sep->nosurat_ketmeninggal = !empty($sep->nosurat_ketmeninggal) ? $sep->nosurat_ketmeninggal : null;

                            if ($sep->statuspulang_kode == Params::CARAKELUAR_ID_MENINGGAL) {
                                $sep->kll_nolaporan_polisi = null;
                            } else if ($sep->statuspulang_kode == Params::CARAKELUAR_ID_MELARIKANDIRI) {
                                $sep->nosurat_ketmeninggal = null;
                                $sep->tgl_meninggal = null;
                            } else {
                                $sep->kll_nolaporan_polisi = null;
                                $sep->nosurat_ketmeninggal = null;
                                $sep->tgl_meninggal = null;
                            }

                            $sep->save();

                            $carakeluar = CarakeluarM::model()->findByPk($sep->statuspulang_kode);
                            $kode_status = "";
                            if (!empty($carakeluar)) {
                                $kode_status = $carakeluar->kode_carakeluar_bpjs;
                            }

                            // var_dump($modelPulang->attributes, $sep->attributes, $_POST['SepT']); die;
                            $bpjs = new Bpjs_Vklaim();
                            $reqSep = json_decode($bpjs->update_sep_pulang_2($sep->nosep, $sep->tglpulang, $kode_status, $sep->tgl_meninggal, $sep->nosurat_ketmeninggal, Yii::app()->user->getState('nama_pemakai'), $sep->kll_nolaporan_polisi), true);

                            // var_dump($reqSep); die;
                            if ($reqSep['metaData']['code'] != 200) {
                                Yii::app()->user->setFlash('warning', 'BPJS Error ' . $reqSep['metaData']['code'] . " : " . $reqSep['metaData']['message']);
                            } else {
                                $sep->nosep_updatetglpulang = $reqSeq['response'];
                                $sep->update(array('nosep_updatetglpulang'));
                            }
                        }
                    }


                    // END SMS GATEWAY
                    // die; 
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan !');
                    if ($dialog) {
                        $tersimpan = true;
                    } else
                        $this->redirect(Yii::app()->createUrl($this->route)); //refresh dgn menghilangkan $_get
                }
            } catch (CException $cexc) {
                $transaction->rollback();
                if (YII_DEBUG == true) {
                    $gagalSimpanAlert = true;
                    //                                    Yii::app()->user->setFlash('error',"Data gagal disimpan. ".MyExceptionMessage::getMessage($cexc,true, true));
                } else {
                    $gagalSimpanAlert = true;
                    //                                    Yii::app()->user->setFlash('error',"Data gagal disimpan.<br/> ".$cexc->getMessage());
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render('formPasienPulang', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modelPulang' => $modelPulang,
            'modRujukanKeluar' => $modRujukanKeluar,
            'smspasien' => $smspasien,
            'tersimpan' => $tersimpan,
            'gagalSimpanAlert' => $gagalSimpanAlert,
            'modUbahStatus' => $modUbahStatus
        ));
    }

    public function actionVerifikasiTindakLanjut() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }


        $ok = 1;
        $msg = "";
        $id = $_POST['id'];

        $is_confirm = 0;

        $reseptur = ResepturT::model()->findByAttributes(array(
            'pendaftaran_id' => $id,
                ), array(
            'condition' => 'penjualanresep_id is null'
        ));

        $p = PendaftaranT::model()->findByPk($id);
        if ($p->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
            $ok = 0;
            $msg = "Pasien masih dalam status " . $p->statusperiksa . ".";

            goto outs;
        }

        // ============= Reseptur belum di verifikasi =====================
        // if (!empty($reseptur)) {
        //     $ok = 0;
        //     $msg = "Pasien memiliki reseptur yang belum diverifikasi.";

        //     goto outs;
        // }

        // ============= Pemeriksaan belum diapprove di lab/rad ===========
        $kirim = PasienkirimkeunitlainV::model()->findByAttributes(array(
            'pendaftaran_id' => $id,
            'ruangan_id' => array(Params::RUANGAN_ID_LAB_KLINIK, Params::RUANGAN_ID_RAD),
                ), array(
            'condition' => 'pasienmasukpenunjang_id is null',
        ));

        if (!empty($kirim)) {
            $ok = 0;
            $msg = "Pemeriksaan Laboratorium/Radiologi belum dilakukan verifikasi, akan Anda melanjutkan ?";
            $is_confirm = 1;

            goto outs;
        }


        // ============= Pemeriksaan belum muncul di modul lab/rad ========
        $penunjang = PasienmasukpenunjangT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $id,
            'ruangan_id' => array(Params::RUANGAN_ID_LAB_KLINIK, Params::RUANGAN_ID_RAD),
        ));


        $is_lab = false;
        $is_rad = false;

        foreach ($penunjang as $item) {
            if ($item->ruangan_id == Params::RUANGAN_ID_RAD) {
                $criRad = new CDbCriteria();
                $criRad->addCondition(" pendaftaran_id = '" . $item->pendaftaran_id . "' AND pasienmasukpenunjang_id = '" . $item->pasienmasukpenunjang_id . "' ");
                $criRad->addCondition(" (statusperiksahasil = '" . Params::STATUSPERIKSAHASIL_BELUM . "') OR (statusperiksahasil IS NULL)  ");
                $rad = HasilpemeriksaanradT::model()->findAll($criRad);

                if (count((array) $rad) > 0) {
                    $ok = 0;
                    $is_rad = true;
                }
            } else if ($item->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
                $hasil = HasilpemeriksaanlabT::model()->findByAttributes(array(
                    'pasienmasukpenunjang_id' => $item->pasienmasukpenunjang_id
                ));

                if (empty($hasil) || $hasil->statusperiksahasil == Params::STATUSPERIKSAHASIL_BELUM) {
                    $ok = 0;
                    $is_lab = true;
                }
            }
        }

        if ($is_lab || $is_rad) {
            $ruangan = array();
            if ($is_lab) {
                $ruangan[] = "Laboratorium";
            }
            if ($is_rad) {
                $ruangan[] = "Radiologi";
            }

            $ok = 0;
            $msg = "Belum ada hasil pemeriksaan pada " . (implode(" dan ", $ruangan)) . ". Anda yakin untuk melanjutkan ?";
            $is_confirm = 1;

            goto outs;
        }

        outs:
        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg, 'is_confirm' => $is_confirm));
    }

    public function actionUbahDataPerujuk() {
        $this->layout = '//layouts/iframe';
        $modRujukan= new PPRujukanT;
        $pendaftaran_id = $_GET['id']; 
        
        $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    
        if (!empty( $modPendaftaran->rujukan_id)) {
            $modRujukan = PPRujukanT::model()->findByPk($modPendaftaran->rujukan_id);
            $modRujukan->tanggal_rujukan = date("d/m/Y", strtotime($modRujukan->tanggal_rujukan));
        }
        
        if (isset($_POST['PPRujukanT'])) {
        
            $transaction = Yii::app()->db->beginTransaction();
            $ok = false;
            try {
    
                if (empty($modPendaftaran->rujukan_id)){
                $modRujukan = new PPRujukanT;
                }
            
                $modRujukan->attributes = $_POST['PPRujukanT'];
                $kdDiagnosa = implode(', ', $_POST['PPRujukanT']['kddiagnosa_rujukan']);
                $diagnosa = implode(', ', $_POST['PPRujukanT']['diagnosa_rujukan']);
            
                $modRujukan->kddiagnosa_rujukan = $kdDiagnosa;
                $modRujukan->diagnosa_rujukan = $diagnosa;
                $modRujukan->save();
    
                if ($modRujukan->save()){
                $modPendaftaran->rujukan_id = $modRujukan->rujukan_id;
                if($modPendaftaran->save()){
                    $ok = true;
                }
                }
    
            if ($ok) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', "Data rujukan berhasil disimpan");
                $this->redirect(array('ubahDataPerujuk', 'id' => $modPendaftaran->pendaftaran_id, 'rujukan_id' => $modRujukan->rujukan_id, 'sukses' => 1));
            } else {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data pasien gagal disimpan err1 !");
            }
            } catch (Exception $exc) {
            var_dump( $exc);die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! (X)" . MyExceptionMessage::getMessage($exc, true));
            }
        }
    
        $this->render(
                $this->path_view . '_formRujukan', array(
            'modRujukan' => $modRujukan,
                )
        );
    }

    function actionPrintKepalaLes($pendaftaran_id = null) {
        $this->layout = '//layouts/printWindows4';
        $format = new MyFormatter;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $this->render($this->path_view . 'print/printKepalaLes', array(
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,

        ));

        

        
    
    }
}
