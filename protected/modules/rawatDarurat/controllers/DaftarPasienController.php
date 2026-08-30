<?php

class DaftarPasienController extends MyAuthController {

    public $validRujukan = false;
    public $validPulang = false;

    public $path_view = 'rawatDarurat.views.daftarPasien.';

    
    public function actionRincian($id) {
        $this->layout = '//layouts/iframe';
        $data['judulLaporan'] = 'Rincian Tagihan Pasien';
        $modPendaftaran = RDPendaftaranT::model()->findByPk($id);
        $modRincian = RDRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
        $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
        //            $modRincian->pendaftaran_id = $id;
        $this->render('/rinciantagihanpasienV/rincian', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data));
    }


  public function simpanPPDS($pendaftaran_id,$urutan_ppds,$ppds_id,$pasienadmisi_id, $post)
  {
    foreach ($post as $i => $ppds) {
      if (empty($ppds['pasien_ppds_id'])) {
        $model = new PasienPpdsT();
        $model->attributes = $ppds;
        $model->pendaftaran_id = $pendaftaran_id;
        $model->urutan_ppds = $urutan_ppds;
        $model->ppds_id = $urutan_ppds;        
        $model->pasienadmisi_id = $pasienadmisi_id;        
    
        if (!$model->save()) {
          $this->ppdsTersimpan &= false;
        }
      }
    }
  }

  public function actionCreate($pendaftaran_id = null, $pasienadmisi_id = null, $ppds_id = null, $urutan_ppds = null)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;    
    $model = new PasienPpdsT;
    
    if (isset($_POST['PasienPpdsT'])) {  
     $transaction = Yii::app()->db->beginTransaction();
     $ok = true;

        foreach ($_POST['PasienPpdsT'] as $idx=>$item) {

          $modDetail = new PasienPpdsT;
          $modDetail->ppds_id = $item['ppds_id'];
          $modDetail->urutan_ppds = $idx == 'i' ? 1 :($idx + 1);
          $modDetail->pendaftaran_id = $pendaftaran_id;
          $modDetail->pasienadmisi_id = $pasienadmisi_id;

          $ok = $ok && $modDetail->save();
        }

        if ($ok && !empty(Yii::app()->user->getState('pegawai_id'))) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', '<strong>Sukses!</strong> Data berhasil disimpan!');
            $this->redirect(array('create', 'pendaftaran_id'=>$pendaftaran_id, 'sukses' => 1));

        } else {
          $transaction->rollback();
         Yii::app()->user->setFlash('error', '<strong>Perhatian!</strong> Nama PPDS Tidak Sesuai login Anda!');
          
        }
      }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'model2' => $model2,
      'modPpds'=>$modPpds,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan'=> $modRuangan,
      'modDetail' => $modDetail
    ));
  }


  public function actionSetResponTime($id) {

    $this->layout = '//layouts/iframe';

    $model = PendaftaranT::model()->findByPk($id);
    $respon = RespontimeR::model()->findByAttributes(array(
      'pendaftaran_id'=>$id,
    ));

    $wpss = AsesmentriagewpssT::model()->find('pendaftaran_id = ' . $id . ' order by asesmentriagewpss_id desc');
    $konsul = KonsulpoliT::model()->find('pendaftaran_id = ' . $id . ' order by konsulpoli_id desc');
    $pulang = PasienpulangT::model()->find('pasien_id = ' . $model->pasien_id . ' order by pasienpulang_id desc');

    // echo '<pre>'; var_dump($wpss->asesmentriagewpss_id, $konsul->konsulpoli_id, $pulang->pasienpulang_id); die;
    // echo '<pre>'; var_dump($pulang->attributes); die;
    

    if (empty($respon)) {
        $respon = new RespontimeR;
    }

    if(!empty($wpss)) {
        $respon->tgldatang = !empty($wpss->waktu_datang) ? MyFormatter::formatDateTimeForUser($wpss->waktu_datang) : MyFormatter::formatDateTimeForUser($respon->tgldatang);
        $respon->tglperiksa = !empty($wpss->waktu_periksa) ? MyFormatter::formatDateTimeForUser($wpss->waktu_periksa) : MyFormatter::formatDateTimeForUser($respon->tglperiksa);
    }

    if(!empty($konsul)) {
        $respon->tglkonsul =  !empty( $konsul->tglkonsulpoli) ? MyFormatter::formatDateTimeForUser($konsul->tglkonsulpoli) : MyFormatter::formatDateTimeForUser( $respon->tglkonsul);
        $respon->tglrespon =  !empty( $konsul->tgljawabpoli) ? MyFormatter::formatDateTimeForUser($konsul->tgljawabpoli) : MyFormatter::formatDateTimeForUser( $respon->tglrespon);
    }

    if(!empty($pulang)) {
        $respon->tglkeluar =  !empty($pulang->tglkeluar) ? MyFormatter::formatDateTimeForUser($pulang->tglkeluar) : MyFormatter::formatDateTimeForUser( $respon->tglkeluar);
    }

    if(!empty($model->pendaftaran_id)) {
        $pasienadmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
        if(!empty($pasienadmisi)) {
            $respon->tglkeluar = MyFormatter::formatDateTimeForUser($pasienadmisi->tgladmisi);
        }
    }


    if (isset($_POST['RespontimeR'])) {
        $respon->attributes = $_POST['RespontimeR'];
        $respon->pendaftaran_id = $id;
        $respon->tgldatang = empty($respon->tgldatang) ? null : MyFormatter::formatDateTimeForDB($respon->tgldatang);
        $respon->tglperiksa = empty($respon->tglperiksa) ? null : MyFormatter::formatDateTimeForDB($respon->tglperiksa);
        $respon->tglkonsul = empty($respon->tglkonsul) ? null : MyFormatter::formatDateTimeForDB($respon->tglkonsul);
        $respon->tglrespon = empty($respon->tglrespon) ? null : MyFormatter::formatDateTimeForDB($respon->tglrespon);
        $respon->tglkeluar = empty($respon->tglkeluar) ? null : MyFormatter::formatDateTimeForDB($respon->tglkeluar);
        $respon->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $respon->create_time = date('Y-m-d H:i:s');
        $respon->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $respon->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if (!isset($_POST['nama_pegawai']) || trim($_POST['nama_pegawai']) == "") {
            $respon->pegawai_id = null;
        }
    
        // echo '<pre>';var_dump($respon->save(), $respon->getErrors());die;
        if ($respon->save()) {

            Yii::app()->user->setFlash('success',"Data berhasil disimpan");
            $this->redirect(array('setResponTime', 'id'=>$id));
        } else {
            Yii::app()->user->setFlash('error',"Data gagal disimpan");
        }
    }

    // $respon->tgldatang = empty($respon->tgldatang) ? null : MyFormatter::formatDateTimeForUser($respon->tgldatang);
    // $respon->tglperiksa = empty($respon->tglperiksa) ? null : MyFormatter::formatDateTimeForUser($respon->tglperiksa);
    // $respon->tglkonsul = empty($respon->tglkonsul) ? null : MyFormatter::formatDateTimeForUser($respon->tglkonsul);
    // $respon->tglrespon = empty($respon->tglrespon) ? null : MyFormatter::formatDateTimeForUser($respon->tglrespon);
    // $respon->tglkeluar = empty($respon->tglkeluar) ? null : MyFormatter::formatDateTimeForUser($respon->tglkeluar);
  

    $this->render('_formInputRespon', array(
      'respon'=>$respon,
    ));
  
  }


  public function actionCekResponTime() {

    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new RDInfoKunjunganRDV;
    $model->unsetAttributes();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    
    

    if (isset($_POST['RDInfoKunjunganRDV'])) {
      $model->attributes = $_POST['RDInfoKunjunganRDV'];
      $model->ceklis = $_POST['RDInfoKunjunganRDV']['ceklis'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_POST['RDInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_POST['RDInfoKunjunganRDV']['tgl_akhir']);
      $model->tgl_awall = MyFormatter::formatDateTimeForDb($_POST['RDInfoKunjunganRDV']['tgl_awall']);
      $model->tgl_akhirl = MyFormatter::formatDateTimeForDb($_POST['RDInfoKunjunganRDV']['tgl_akhirl']);
      $model->prefix_pendaftaran = isset($_POST['RDInfoKunjunganRDV']['prefix_pendaftaran']) ? $_POST['RDInfoKunjunganRDV']['prefix_pendaftaran'] : null;
    }

    $prov = $model->searchRD();
    $prov->pagination = false;


    $belum_ada = array();
    foreach ($prov->data as $item) {
      $respon = RespontimeR::model()->findByAttributes(array(
        'pendaftaran_id' => $item->pendaftaran_id,
      ));
      if (empty($respon)) {
        $belum_ada[] = $item->namadepan.$item->nama_pasien." (".$item->no_rekam_medik.")";
      }
    }

    $total = count($belum_ada);
    $msg = "";
    if ($total > 0) {
      $msg = "Beberapa pasien belum dilakukan input respon time:\n";
      foreach ($belum_ada as $idx => $item) {
        $msg .= ($idx+1).". ".$item."\n";
      }
      $msg .= "\nSilahkan input respon time pasien diatas.";
    }

    echo CJSON::encode(array(
      'total'=>$total,
      'msg'=>$msg,
    ));

  }

  public function actionAutoPPDS()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'ppds_nama';
                $criteria->limit = 10;
                $models = PpdsM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->ppds_nama;
                    $returnVal[$i]['value'] = $model->ppds_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}

  public function actionPPDSRJ($pendaftaran_id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    //$pendaftaran_id = $_GET['pendaftaran_id'];

    $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;
    
    $model2->ppds_nama;
    
    $this->render('_formPPDSRJ', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan'=> $modRuangan,
      'model2' => $model2,
      'modPpds'=>$modPpds,
      'modDetail' => $modDetail
   //   'datatable' => $datatable
    ));
  }

    public function actionPrint($id = null) {
        //$this->layout='//layouts/iframe';
        //  $modPendaftaran = RDPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
        $modPendaftaran = RDPendaftaranT::model()->findByPk($id);
        $modRincian = RDRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
        $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;


        $judulLaporan = 'Data Rincian';
        $caraPrint = $_REQUEST['caraPrint'];

        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('/rinciantagihanpasienV/detailRincian', array(
                'modPendaftaran' => $modPendaftaran,
                'modRincian' => $modRincian,
                // 'modPasien'=>$modPasien, 
                'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
            ));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('/rinciantagihanpasienV/detailRincian', array(
                'modPendaftaran' => $modPendaftaran,
                'modRincian' => $modRincian,
                //  'modPasien'=>$modPasien,
                'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
            ));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {

            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            //$mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('/rinciantagihanpasienV/detailRincian', array(
                        'modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian,
                        // 'modPasien'=>$modPasien,
                        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
                            ), true));
            $mpdf->Output();
        }
    }

    public function actionIndex() {
        
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'draft-asesmen-triage-grid'){
                    echo $this->renderPartial('grid/_daftarDraft',[], true);
                    exit;
                }
            }
        }
        // echo '<pre>';var_dump(Yii::app()->user->getState('jabatan_id'));die;
        $format = new MyFormatter();
        $this->pageTitle = Yii::app()->name . " - Daftar Pasien Rawat Darurat";
        $model = new RDInfoKunjunganRDV;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->tgl_awall = date('Y-m-d');
        $model->tgl_akhirl = date('Y-m-d');
        $model->ceklis = false;
        if (isset($_REQUEST['RDInfoKunjunganRDV'])) {
            $model->attributes = $_REQUEST['RDInfoKunjunganRDV'];
            $model->ceklis = $_REQUEST['RDInfoKunjunganRDV']['ceklis'];
            $model->no_rekam_medik = $_REQUEST['RDInfoKunjunganRDV']['no_rekam_medik'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RDInfoKunjunganRDV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RDInfoKunjunganRDV']['tgl_akhir']);
            $model->tgl_awall = $format->formatDateTimeForDb($_REQUEST['RDInfoKunjunganRDV']['tgl_awall']);
            $model->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['RDInfoKunjunganRDV']['tgl_akhirl']);
            $model->prefix_pendaftaran = isset($_REQUEST['RDInfoKunjunganRDV']['prefix_pendaftaran']) ? $_REQUEST['RDInfoKunjunganRDV']['prefix_pendaftaran'] : null;
            //$model->ceklis = $_REQUEST['RDInfoKunjunganRDV']['ceklis'];
        }
        if (Yii::app()->request->isAjaxRequest) {
            echo $this->renderPartial('_tablePasien', array('model' => $model));
        } else {
            $this->render('index', array('format' => $format, 'model' => $model));
        }
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
                        MortalitasR::model()->deleteAllByAttributes(['pendaftaran_id' => $pendaftaran_id]);
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
    public function actionPasienPulang($pendaftaran_id = null, $dialog = false, $carakeluar_id = null) {
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
            $modAsesmentriageWpss= AsesmentriagewpssT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);


            // untuk form surat kematian pasien
            $modKematian = new RDSuratKeteranganR();
            $modKematian->pendaftaran_id = $pendaftaran_id;
            $modKematian->pasien_id = $modPendaftaran->pasien_id;
            $modKematian->nourutsurat = $modKematian->getNoUrut();
            $modKematian->nomorsurat = $modKematian->getNoSuratKematian(Yii::app()->user->getState('ruangan_id'));
            $modKematian->tglsurat = date('d M Y H:i:s');
            $modKematian->judulsurat = 'SURAT KETERANGAN KEMATIAN';
            $modKematian->jmlprint_surat = 1;
            $modKematian->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modKematian->profilrs_id = Params::getDefaultProfilRS();
            $modKematian->jenissurat_id = Params::SURAT_KETERANGAN_KEMATIAN;

            $pegawaiLogin = PegawaiM::model()->findByPk( Yii::app()->user->getState('pegawai_id'));
            if(!empty($pegawaiLogin)) {
                $modKematian->mengetahui_surat = $pegawaiLogin->namaLengkap;
            }

        } else {
            $modPendaftaran = new RDPendaftaranT;
            $modPasien = new RDPasienM;
            $modAsesmentriageWpss= new AsesmentriagewpssT();
            $modKematian = new RDSuratketeranganR;
        }
        $modelPulang = new RDPasienPulangT;
        $modRujukanKeluar = new PasiendirujukkeluarT;

        $modelPulang->tglpasienpulang = date('d M Y H:i:s');
        $modelPulang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modelPulang->pasien_id = $modPasien->pasien_id;
        if(!empty($carakeluar_id)) {
            $modelPulang->carakeluar_id = $carakeluar_id;
        }

        $modRujukanKeluar->pegawai_id = PendaftaranT::model()->findByPk($pendaftaran_id)->pegawai_id;
        $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id'); //ruangan asal itu diasumsikan ruangan terakhir dia dari mana
        $modRujukanKeluar->tgldirujuk = date('d M Y H:i:s');
        $modRujukanKeluar->tglberlakusurat = date('d M Y H:i:s');


        $tanggalAwalRawat = $modPendaftaran->tgl_pendaftaran;
        if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_IGD) {
            if(!empty($modAsesmentriageWpss->waktudatang)) {
                $tanggalAwalRawat = $modAsesmentriageWpss->waktudatang;
            }
        }

        $format = new MyFormatter();
        $date1 = $format->formatDateTimeForDb($tanggalAwalRawat);
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
            // echo '<pre>';var_dump($_POST);die;
            if (!empty($_POST['RDPendaftaranT']['pendaftaran_id']))
                $modPendaftaran = $modPendaftaran->findByPk($_POST['RDPendaftaranT']['pendaftaran_id']);
            if (!empty($_POST['RDPasienM']['pasien_id']))
                $modPasien = $modPasien->findByPk($_POST['RDPasienM']['pasien_id']);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                // throw new CException("Test Error");
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

                    //save surat kematian
                    if(isset($_POST['RDSuratKeteranganR'])) {
                        // echo '<pre>';var_dump($_POST);die;
                        $modKematian->penyebabkematian = $_POST['RDSuratKeteranganR']['penyebabkematian'];
                        $modKematian->jenissurat_id = Params::SURAT_KETERANGAN_KEMATIAN;

                        // echo '<pre>';var_dump($modKematian);die;
                        if ($modKematian->validate()) {
                            $modKematian->save();
                        }
                    }
                }
                //var_dump($this->validPulang && $this->validRujukan);
                //var_dump($modPasien->attributes); die;
                if ($this->validPulang && $this->validRujukan) {

                    $ok = true;
                    // var_dump($modelPulang->carakeluar_id); die;
                    // var_dump("OK"); die;


                    if ($modelPulang->carakeluar_id != Params::CARAKELUAR_ID_RAWATINAP) {

                        if ($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) {
                            $this->notifPasienMeninggal($modPasien, $modelPulang);
                        } else {
                            if($modelPulang->carakeluar_id == 3) {
                                PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG));
                            } else if ($modelPulang->carakeluar_id == 1) {
                                PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
                            } else {
                                PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s')));
                            }
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

                    if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) {
                        if($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
                            $statusperiksa = Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO;
                        } else {
                            $statusperiksa = Params::STATUSPERIKSA_SUDAH_PULANG;
                        }
                        PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'pasienpulang_id' => $modelPulang->pasienpulang_id, 'statusperiksa' => $statusperiksa));
                    } else {
                        PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'pasienpulang_id' => $modelPulang->pasienpulang_id));
                    }
                
                    RespontimeR::setPasienKeluar($modelPulang->pendaftaran_id, $modelPulang->tglpasienpulang);
     
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
                                $sep->nosep_updatetglpulang = $reqSep['response'];
                                $sep->update(array('nosep_updatetglpulang'));
                            }
                        }
                    }

                    // echo '<pre>';var_dump($_POST);die;
                    if(isset($_POST['Diagnosa'])) {

                        foreach ($_POST['Diagnosa'] as $ii => $data) {
                            $insert = new MortalitasR();
                            $insert->tanggal = date('Y-m-d H:i:s');
                            $insert->diagnosa_id = $data['diagnosa_id'];
                            $insert->diagnosa_nama = $data['diagnosa_nama'];
                            $insert->jumlah = 1;
                            $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                            $insert->created_by = Yii::app()->user->getState('loginpemakai_id');
                            $insert->created_time = date('Y-m-d H:i:s');
                            $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
                            $insert->pegawai_id = Yii::app()->user->getState('pegawai_id');
                            if ($insert->save()) {
                                $modelPulang->isDead = true;
                            }
                        }
                        // echo '<pre>';var_dump($insert->save(), $insert->getErrors());
                    }

                 
                    // echo '<pre>';var_dump('clear');die;


                    // END SMS GATEWAY
                    // die; 
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan !');
                    if ($dialog) {
                        $tersimpan = true;
                    } else
                        $this->redirect(Yii::app()->createUrl($this->route, ['sukses' => 1])); //refresh dgn menghilangkan $_get
                }
            } catch (CException $cexc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan. ".$cexc->getMessage()." - File ".$cexc->getFile().":".$cexc->getLine());
                // echo '<pre>';var_dump($cexc);die;
                /*
                if (YII_DEBUG == true) {
                    $gagalSimpanAlert = true;
                    //                                    Yii::app()->user->setFlash('error',"Data gagal disimpan. ".MyExceptionMessage::getMessage($cexc,true, true));
                } else {
                    $gagalSimpanAlert = true;
                    //                                    Yii::app()->user->setFlash('error',"Data gagal disimpan.<br/> ".$cexc->getMessage());
                }
                */
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'PPdiagnosa-m-grid') {
                $this->renderPartial($this->path_view . 'grid/_dignosa');
                Yii::app()->end();
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
            'modUbahStatus' => $modUbahStatus,
            'modKematian' => $modKematian
        ));
    }

    function simpanDiagnosaResume($modResume) {
        // icd 10
        $cri = new CDbCriteria;
        $cri->select = [
            " kd.kelompokdiagnosa_nama, array_to_string(array_agg(distinct d.diagnosa_nama),', ') as diagnosa_nama, d.diagnosa_kode, d.diagnosa_id, t.pasienmorbiditas_id, kd.kelompokdiagnosa_id, t.ket_diagnosa"
        ];
        $cri->group = " kd.kelompokdiagnosa_nama, d.diagnosa_kode, d.diagnosa_id, t.pasienmorbiditas_id, kd.kelompokdiagnosa_id, t.ket_diagnosa";
        $cri->join = "  JOIN diagnosa_m d ON d.diagnosa_id = t.diagnosa_id 
                        JOIN kelompokdiagnosa_m kd ON kd.kelompokdiagnosa_id = t.kelompokdiagnosa_id
                        JOIN ruangan_m r on r.ruangan_id = t.ruangan_id 
                ";
        $cri->addCondition("t.pendaftaran_id = " . $modResume->pendaftaran_id);
        if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_REKAMMEDIS){
            $cri->addCondition("t.is_verifikasidiagnosa = true");
        }else{
            $cri->addCondition("t.is_verifikasidiagnosa = false");
            if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RD) {
                // jika rawat darurat maka munculkan seluruh diagnosa yang di inputkan di seluruh instalasi rawat darurat + diagnosa per pegawai logi
                $cri->addCondition('r.instalasi_id =' . Yii::app()->user->getState('instalasi_id'));
                $cri->addCondition('t.pegawai_id =' . Yii::app()->user->getState('pegawai_id'));
            }

            if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ) {
                // jika rawat jalan maka munculkan seluruh diagnosa yang di inputkan di seluruh instalasi rawat jalan
                $cri->addCondition('r.instalasi_id =' . Yii::app()->user->getState('instalasi_id'));
            }

            if(in_array(Yii::app()->user->getState('instalasi_id'), Params::INSTALASI_ID_RI_ARR)) {
                $cri->addInCondition('r.instalasi_id',  Params::INSTALASI_ID_RI_ARR);
            }
        }
        $cri->order = "kd.kelompokdiagnosa_nama Desc";

        $modMorbi = PasienmorbiditasR::model()->findAll($cri);
        // echo '<pre>';var_dump($modMorbi);die;
        if(!empty($modMorbi) && count($modMorbi) > 0) {
            foreach($modMorbi as $val) {
                $resummorbiR = new ResumemedisMorbiditasR();
                $resummorbiR->resumemedis_id = $modResume->resumemedis_id;
                $resummorbiR->diagnosa_id = $val->diagnosa_id;
                $resummorbiR->diagnosa_kode = $val->diagnosa_kode;
                $resummorbiR->diagnosa_nama = $val->diagnosa_nama;
                $resummorbiR->kelompokdiagnosa_id = $val->kelompokdiagnosa_id;
                $resummorbiR->keterangan = $val->ket_diagnosa;
                $cek = PasienmorbiditasT::model()->findByAttributes(['pendaftaran_id' => $modResume->pendaftaran_id, 'diagnosa_id' => $resummorbiR->diagnosa_id]);
                if(!empty($cek)) {
                    $resummorbiR->pasienmorbiditas_id = $val->pasienmorbiditas_id;
                }
                $resummorbiR->created_time = date('Y-m-d H:i:s');

                if($resummorbiR->validate()) {
                    $resummorbiR->save();
                }
            }
        }


        // icd9cm
        $criteriaICD9 = new CDbCriteria();
        $criteriaICD9->addCondition('t.pendaftaran_id=' . $modResume->pendaftaran_id);
        $criteriaICD9->join = 'JOIN ruangan_m r on r.ruangan_id = t.create_ruangan_id';
        if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_REKAMMEDIS) {
            $criteriaICD9->addCondition('is_verifikasidiagnosa is true');
        } else {
            $criteriaICD9->addCondition('is_verifikasidiagnosa is false');

            if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RD) {
                // jika rawat darurat maka munculkan seluruh diagnosa yang di inputkan di seluruh instalasi rawat darurat + diagnosa per pegawai logi
                $criteriaICD9->addCondition('r.instalasi_id =' . Yii::app()->user->getState('instalasi_id'));
                $criteriaICD9->addCondition('t.pegawai_id =' . Yii::app()->user->getState('pegawai_id'));
            }

            if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ) {
                // jika rawat jalan maka munculkan seluruh diagnosa yang di inputkan di seluruh instalasi rawat jalan
                $criteriaICD9->addCondition('r.instalasi_id =' . Yii::app()->user->getState('instalasi_id'));
            }

            if(in_array(Yii::app()->user->getState('instalasi_id'), Params::INSTALASI_ID_RI_ARR)) {
                $criteriaICD9->addInCondition('r.instalasi_id',  Params::INSTALASI_ID_RI_ARR);
            }
        }
        $modelPasienICDIX = Pasienicd9cmR::model()->findAll($criteriaICD9);
        // echo '<pre>';var_dump($modelPasienICDIX);die;
        if(!empty($modelPasienICDIX) && count($modelPasienICDIX) > 0){
            foreach ($modelPasienICDIX as $key => $value) {
                $icdresume9 = new ResumemedisIcd9R();
                $icdresume9->resumemedis_id = $modResume->resumemedis_id;
                $icdresume9->diagnosaicdix_id = $value->diagnosaicdix_id;
                $diagnosa = DiagnosaicdixM::model()->findByPk($value->diagnosaicdix_id);
                if(!empty($diagnosa)) {
                    $icdresume9->diagnosaicdix_kode = $diagnosa->diagnosaicdix_kode;
                    $icdresume9->diagnosaicdix_nama = $diagnosa->diagnosaicdix_nama;
                }
                $cek = Pasienicd9cmT::model()->findByAttributes(['pendaftaran_id' => $modResume->pendaftaran_id, 'diagnosaicdix_id' => $value->diagnosaicdix_id]);
                if(!empty($cek)){
                    $icdresume9->pasienicd9cm_id = $value->pasienicd9cm_id;
                }
                $icdresume9->kelompokdiagnosa_id = $value->kelompokdiagnosa_id;
                $icdresume9->create_time = date('Y-m-d H:i:s');
                $icdresume9->keterangan = $value->keterangan;

                // var_dump($icdresume9->validate());
                if($icdresume9->validate()) {
                    $icdresume9->save();
                }
                
            }

        }
    }

    function getDataResume($modPendaftaran) {
        
        $data['keluhanutama'] = '';
        $data['riwayatalergi'] = '';
        $data['riwayatpenyakitterdahulu'] = '';
        $data['anamnesa'] = '';
        $data['planning'] = '';
        $data['tandavital'] = '';
        $data['pemeriksaanpenunjang'] = '';

        $pendaftaran_id = $modPendaftaran->pendaftaran_id;

        if(!empty($modPendaftaran->pendaftaran_id)) {
            $cri = new CDbCriteria;
            $cri->addCondition("pendaftaran_id = " . $pendaftaran_id);
            $cri->order = "anamesa_id DESC";
            $model = AnamnesaT::model()->find($cri);

            if (!empty($model)) {
                //keluhan utama
                $data['keluhanutama'] .= (!empty($model->keluhanutama) ? $model->keluhanutama : '-');
                
                //riwayat alergi
                $data['riwayatalergi'] .= 'Obat : ' . (!empty($model->riwayatalergiobat) ? $model->riwayatalergiobat : '-').'<br /><br />';
                $data['riwayatalergi'] .= 'Makanan : ' . (!empty($model->riwayatmakanan) ? $model->riwayatmakanan : '-');

                $data['riwayatpenyakitterdahulu'] .= (!empty($model->riwayatperjalananpasien) ? $model->riwayatperjalananpasien : '-');
            }

            // diagnosa masuk
            if(!empty($modPendaftaran->diagnosamasuk)) {
                $data['diagnosamasuk'] = $modPendaftaran->diagnosamasuk;
            }
        }

        // pemeriksaan fisik dan keadaan umum mengambil data paling awal
        $modPemeriksaanFisikAwal = PemeriksaanfisikT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id],['order' => 'tglperiksafisik asc']);

        $cri = new CDbCriteria;
        $cri->addCondition("pendaftaran_id = " . $pendaftaran_id);
        $cri->order = "anamesa_id ASC";
        $modAnamnesa = AnamnesaT::model()->find($cri);
        
        if(!empty($modAnamnesa)) {
            $data['anamnesa'] .= 'Keluhan Utama : ' . (!empty($modAnamnesa->keluhanutama) ? $modAnamnesa->keluhanutama : '-');
            $data['anamnesa'] .= '<br \>';
            $data['anamnesa'] .= 'Keluhan Tambahan : ' . (!empty($modAnamnesa->keluhantambahan) ? $modAnamnesa->keluhantambahan : '-');
            $data['anamnesa'] .= '<br \>';
        }

        if(!empty($modPemeriksaanFisikAwal)) {
            if(!empty($modPemeriksaanFisikAwal->tekanandarah)) {
                $data['anamnesa'] .= "Tekanan darah : " . $modPemeriksaanFisikAwal->tekanandarah . " mmHg <br>";
            }
            if(!empty($modPemeriksaanFisikAwal->suhutubuh)) {
                $data['anamnesa'] .= "Suhu Temperatur : " . $modPemeriksaanFisikAwal->suhutubuh . " °C <br>";
            }
            if(!empty($modPemeriksaanFisikAwal->detaknadi)) {
                $data['anamnesa'] .= "Nadi : " . $modPemeriksaanFisikAwal->detaknadi . " x/menit <br>";
            }
            if(!empty($modPemeriksaanFisikAwal->pernapasan)) {
                $data['anamnesa'] .= "Frekunsi Nafas : " . $modPemeriksaanFisikAwal->pernapasan . " x/menit <br>";
            }
            if(!empty($modPemeriksaanFisikAwal->pernapasan)) {
                $data['anamnesa'] .= "Skala Nyeri : -";
            }
            $data['anamnesa'] .= '<br \>';
        }
        if(!empty($modAnamnesa)) {
            $data['anamnesa'] .= 'Keterangan Lain : ' . (!empty($modAnamnesa->keterangananamesa) ? strip_tags($modAnamnesa->keterangananamesa) : '-');
            $data['anamnesa'] .= '<br \>';
        }


        //pemeriksaan penunjang
        $listRad = '';
        $listLab = '';

        $cri = new CDbCriteria;
        $cri->select = $cri->group = " pemeriksaanlab_nama, pemeriksaanrad_nama ";
        $cri->addCondition(" pendaftaran_id = " . $pendaftaran_id);
        $cri->order = " pemeriksaanlab_nama ASC, pemeriksaanrad_nama ASC ";                
        $model = PasienkirimkeunitlainallV::model()->findAll($cri);

        foreach ($model as $key => $val) {
            if (!empty($val->pemeriksaanlab_nama)) {
                $listLab .= '- ' . $val->pemeriksaanlab_nama . '<br/>';
            }

            if (!empty($val->pemeriksaanrad_nama)) {
                $listRad .= '- ' . $val->pemeriksaanrad_nama . '<br/>';
            }
        }

        if (!empty($listRad))
            $data['pemeriksaanpenunjang'] .= 'Radiologi : <br />';

        $data['pemeriksaanpenunjang'] .= $listRad;
        if (!empty($data['pemeriksaanpenunjang'])) {
            $data['pemeriksaanpenunjang'] .= '<br />';
        }

        if (!empty($listLab)) {
            $data['pemeriksaanpenunjang'] .= 'Laboratorium : <br />';
        }

        $data['pemeriksaanpenunjang'] .= $listLab;

        //planning                
        $cri = new CDbCriteria;
        $cri->select = $cri->group = " soap_planning ";
        $cri->addCondition(" pendaftaran_id = " . $pendaftaran_id);
        $cri->order = " soap_planning ASC ";
        $model = CpptpasienT::model()->findAll($cri);

        if (!empty($model)) {
            $data['planning'] .= 'Planning : <br/>';
            foreach ($model as $key => $val) {
                $data['planning'] .= '- ' . $val->soap_planning . '<br />';
            }
        }

        $cri = new CDbCriteria;
        $cri->select = $cri->group = " d.daftartindakan_nama ";
        $cri->join = " JOIN daftartindakan_m d ON d.daftartindakan_id = t.daftartindakan_id ";
        $cri->addCondition(" pendaftaran_id = " . $pendaftaran_id);
        $cri->order = " d.daftartindakan_nama ASC ";
        $model = TindakanpelayananT::model()->findAll($cri);

        if (!empty($model)) {
            if (!empty($data['planning']))
                $data['planning'] .= '<br/>';

            $data['planning'] .= 'Tindakan : <br/>';
            foreach ($model as $key => $val) {
                $data['planning'] .= '- ' . $val->daftartindakan_nama . '<br />';
            }
        }

        // tanda vital
        $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id], ['order' => 'tglperiksafisik desc']);
            
        if (!empty($modPemeriksaanFisik)) {

            if(!empty($modPemeriksaanFisik->tekanandarah)) {
                $data['tandavital'] .= "Tekanan darah : " . $modPemeriksaanFisik->tekanandarah . " mmHg <br>";
            }
            if(!empty($modPemeriksaanFisik->suhutubuh)) {
                $data['tandavital'] .= "Suhu Temperatur : " . $modPemeriksaanFisik->suhutubuh . " °C <br>";
            }
            if(!empty($modPemeriksaanFisik->detaknadi)) {
                $data['tandavital'] .= "Nadi : " . $modPemeriksaanFisik->detaknadi . " x/menit <br>";
            }
            if(!empty($modPemeriksaanFisik->pernapasan)) {
                $data['tandavital'] .= "Frekunsi Nafas : " . $modPemeriksaanFisik->pernapasan . " x/menit <br>";
            }
            if(!empty($modPemeriksaanFisik->pernapasan)) {
                $data['tandavital'] .= "Skala Nyeri : -";
            }
        }

        return $data;
    }

    function actionAddRowDiagnosa() {
        $jumlahtr = $_POST['jumlahtr'];
        $diagnosa_id = $_POST['diagnosa_id'];
        $diagnosa_kode = $_POST['diagnosa_kode'];
        $diagnosa_nama = $_POST['diagnosa_nama'];
        $diagnosa_namalainnya = $_POST['diagnosa_namalainnya'];

        $data['html'] = $this->renderPartial($this->path_view . 'grid/_rowDiagnosa', [
            'jumlahtr' => $jumlahtr,
            'diagnosa_id' => $diagnosa_id,
            'diagnosa_nama' => $diagnosa_nama,
            'diagnosa_kode' => $diagnosa_kode,
            'diagnosa_namalainnya' => $diagnosa_namalainnya
        ], true);

        echo json_encode($data);

    }

    function actionCekSPRI() {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        
        $modSurat = SuratperintahranapT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);
        if(!empty($modSurat)) {
            $data['adaSPRI'] = 1;
        } else {
            $data['adaSPRI'] = 0;
        }

        echo json_encode($data);
    }

    public function notifPasienMeninggal($modPasien, $modelPulang) {

        $modCaraKeluar = CarakeluarM::model()->findByPk($modelPulang->carakeluar_id);
        $modKondisiKeluar = KondisiKeluarM::model()->findByPk($modelPulang->kondisikeluar_id);

        $judul = "Pasien Meninggal";

        $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->namadepan . $modPasien->nama_pasien . ' '
                . 'Pasien ' . strtoupper($modCaraKeluar->carakeluar_nama) . ' dengan kondisi ' . $modKondisiKeluar->kondisikeluar_nama . ' pada tanggal '
                . MyFormatter::formatDateTimeForUser($modPasien->tgl_meninggal);

        return CustomFunction::broadcastNotif($judul, $isi, array(
                    array('instalasi_id' => Params::INSTALASI_ID_JZ, 'ruangan_id' => Params::RUANGAN_ID_FORENSIC, 'modul_id' => Params::MODUL_ID_JENAZAH),
        ));
    }

    public function notifPasienPulang($modPendaftaran, $modelPulang) {
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modCaraKeluar = CarakeluarM::model()->findByPk($modelPulang->carakeluar_id);
        $modKondisiKeluar = KondisiKeluarM::model()->findByPk($modelPulang->kondisikeluar_id);

        if ($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_DIPULANGKAN) {
            $judul = 'Pasien Pulang';
        } else {
            $judul = 'Pasien ' . $modCaraKeluar->carakeluar_nama;
        }

        $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->namadepan . $modPasien->nama_pasien . ' '
                . 'Pasien ' . strtoupper($modCaraKeluar->carakeluar_nama) . ' dengan kondisi ' . $modKondisiKeluar->kondisikeluar_nama . ' pada tanggal '
                . MyFormatter::formatDateTimeForUser($modelPulang->tglpasienpulang);

        // var_dump($judul, $isi); die;
        if ($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_DIPULANGKAN) {
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                        array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK),
            ));
        }

        return CustomFunction::broadcastNotif($judul, $isi, array(
                    // array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),							
                    array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
                    array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->session['modul_id']),
        ));
    }

    protected function notifPasienRujukKeRawatInap($modPendaftaran) {
        $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
        $modInstalasi = InstalasiM::model()->findByPk($modRuangan->instalasi_id);
        $pasien_id = $modPendaftaran->pasien_id;
        $modPasien = PasienM::model()->findByPk($pasien_id);

        $judul = 'Pasien Rujuk ke Rawat Inap';

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien
                . ' - ' . $modInstalasi->instalasi_nama . ' - ' . $modRuangan->ruangan_nama;

        $link = $this->createUrl('/pendaftaranPenjadwalan/PendaftaranRawatInapDariRJRD/index', array(
            'pendaftarantindaklanjut_id' => $modPendaftaran->pendaftaran_id,
        ));

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                    array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN, 'link_proses' => $link),
                    array('instalasi_id' => Params::INSTALASI_ID_RD, 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Params::MODUL_ID_RD),
        ));
    }

    protected function savePasienPulang($modPasienPulang, $attrPasienPulang, $pasienadmisi_id = '') {
        $modelPulangNew = new RDPasienPulangT;
        $modelPulangNew->attributes = $attrPasienPulang;
        $modelPulangNew->satuanlamarawat = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? Params::SATUAN_LAMARAWAT_RD : Params::SATUAN_LAMARAWAT_RI;
        $modelPulangNew->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_time = date('Y-m-d H:i:s');
        $modelPulangNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
        $modelPulangNew->pasienadmisi_id = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? null : $pasienadmisi_id;

        // var_dump($modelPulangNew->attributes); die;

        if (!$modelPulangNew->cekSisaPembayaranUntukPulang()) {
        //     throw new CException("Sisa tagihan pasien yang akan dipulangkan belum dibayarkan.");
        }

        // var_dump($modelPulangNew->attributes); die;

        if ($modelPulangNew->save()) {
            $this->validPulang = true;
        }

        return $modelPulangNew;
    }

    protected function saveRujukanKeluar($modRujukanKeluar, $modelPulang, $attrRujukanKeluar) {
        $modRujukanKeluarNew = new PasiendirujukkeluarT;
        $modRujukanKeluarNew->attributes = $attrRujukanKeluar;
        $modRujukanKeluarNew->pendaftaran_id = $modelPulang->pendaftaran_id;
        $modRujukanKeluarNew->pasien_id = $modelPulang->pasien_id;
        $modRujukanKeluarNew->create_time = date('Y-m-d H:i:s');
        $modRujukanKeluarNew->create_loginpemakai_id = Yii::app()->user->id;
        $modRujukanKeluarNew->tglberlakusurat = date('Y-m-d H:i:s');
        $modRujukanKeluarNew->sampaidengan = date('Y-m-d H:i:s', strtotime("+30 days"));
        if ($modRujukanKeluarNew->save()) {
            $this->validRujukan = true;
        } else {
            $this->validRujukan = false;
        }
        return $modRujukanKeluarNew;
    }

    /**
     * Mengatur dropdown kabupaten
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropDownKondisiKeluar($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {

            $sudah_bayar = 0;
            $options = "";
            $statusdokrm = '';

            if (
                    isset($_POST['RDPasienPulangT']['pendaftaran_id']) && isset($_POST["RDPasienPulangT"]['carakeluar_id']) &&
                    $_POST['RDPasienPulangT']['carakeluar_id'] == Params::CARAKELUAR_ID_RAWATINAP
            ) {

                // print_r($_POST['RDPasienPulangT']['carakeluar_id']); die;

                $id = $_POST['RDPasienPulangT']['pendaftaran_id'];
                $carakeluar = $_POST['RDPasienPulangT']['carakeluar_id'];

                // tindakan
                $basetindakan = TindakanpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id' => $id,
                ));
                $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
                    'pendaftaran_id' => $id,
                        ), array(
                    'condition' => 'tindakansudahbayar_id is null',
                ));

                // oa
                $baseoa = ObatalkespasienT::model()->findByAttributes(array(
                    'pendaftaran_id' => $id,
                ));
                $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                    'pendaftaran_id' => $id,
                        ), array(
                    'condition' => 'oasudahbayar_id is null',
                ));


                if (!empty($basetindakan) || !empty($baseoa)) {
                    if (count((array) $tindakan) + count((array) $oa) == 0)
                        $sudah_bayar = 1;
                }
            }

            if ($sudah_bayar == 0) {
                $model = new RDPasienPulangT;
                if ($model_nama !== '' && $attr == '') {
                    $carakeluar_id = $_POST["$model_nama"]['carakeluar_id'];
                } elseif ($model_nama == '' && $attr !== '') {
                    $carakeluar_id = $_POST["$attr"];
                } elseif ($model_nama !== '' && $attr !== '') {
                    $carakeluar_id = $_POST["$model_nama"]["$attr"];
                }
                $kondisikeluar = null;
                if ($carakeluar_id) {
                    $kondisikeluar = $model->getKondisikeluarItems($carakeluar_id);
                    $kondisikeluar = CHtml::listData($kondisikeluar, 'kondisikeluar_id', 'kondisikeluar_nama');
                }
                if ($encode) {
                    $options .= CJSON::encode($kondisikeluar);
                } else {
                    if (empty($kondisikeluar)) {
                        $options .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    } else {
                        if (count((array) $kondisikeluar) != 1)
                            $options .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                        foreach ($kondisikeluar as $value => $name) {
                            $options .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                        }
                    }
                }

                $pen = PendaftaranT::model()->findByPk($_POST['RDPasienPulangT']['pendaftaran_id']);

                if ($_POST["RDPasienPulangT"]['carakeluar_id'] != Params::CARAKELUAR_ID_RAWATINAP) {
                    if (!empty($pen->pengirimanrm_id)) {
                        if (Yii::app()->user->getState('ruangan_id') == $pen->pengirimanrm->ruanganpenerima_id) {
                            if (empty($pen->pengirimanrm->tglterimadokrm)) {
                                $statusdokrm = 'belum-diterima';
                            } else {
                                $statusdokrm = 'belum-dikembalikan';
                            }
                        }
                    }
                } else {
                    $statusdokrm = '';
                }
            }else{
                $model = new RDPasienPulangT;
                if ($model_nama !== '' && $attr == '') {
                    $carakeluar_id = $_POST["$model_nama"]['carakeluar_id'];
                } elseif ($model_nama == '' && $attr !== '') {
                    $carakeluar_id = $_POST["$attr"];
                } elseif ($model_nama !== '' && $attr !== '') {
                    $carakeluar_id = $_POST["$model_nama"]["$attr"];
                }
                $kondisikeluar = null;
                if ($carakeluar_id) {
                    $kondisikeluar = $model->getKondisikeluarItems($carakeluar_id);
                    $kondisikeluar = CHtml::listData($kondisikeluar, 'kondisikeluar_id', 'kondisikeluar_nama');
                }
                if ($encode) {
                    $options .= CJSON::encode($kondisikeluar);
                } else {
                    if (empty($kondisikeluar)) {
                        $options .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    } else {
                        if (count((array) $kondisikeluar) != 1)
                            $options .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                        foreach ($kondisikeluar as $value => $name) {
                            $options .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                        }
                    }
                }

                $pen = PendaftaranT::model()->findByPk($_POST['RDPasienPulangT']['pendaftaran_id']);

                if ($_POST["RDPasienPulangT"]['carakeluar_id'] != Params::CARAKELUAR_ID_RAWATINAP) {
                    if (!empty($pen->pengirimanrm_id)) {
                        if (Yii::app()->user->getState('ruangan_id') == $pen->pengirimanrm->ruanganpenerima_id) {
                            if (empty($pen->pengirimanrm->tglterimadokrm)) {
                                $statusdokrm = 'belum-diterima';
                            } else {
                                $statusdokrm = 'belum-dikembalikan';
                            }
                        }
                    }
                } else {
                    $statusdokrm = '';
                }
            }

            echo CJSON::encode(array('sudah_bayar' => $sudah_bayar, 'options' => $options, 'statusdokrm' => $statusdokrm));
        }
        Yii::app()->end();
    }

    /**
     * batal periksa pasien RND-5542
     */
    public function actionBatalPeriksa() {
        if (Yii::app()->request->isAjaxRequest) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
                $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

                $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id' => $pendaftaran_id,
                        ), array(
                    'condition' => 'tindakansudahbayar_id is not null'
                ));
                $oa = ObatalkespasienT::model()->findByAttributes(array(
                    'pendaftaran_id' => $pendaftaran_id,
                        ), array(
                    'condition' => 'oasudahbayar_id is not null'
                ));

                $ada = false;

                if (!empty($tindakan) || !empty($oa)) {
                    $ada = true;
                    $pesan = "Pasien sudah melakukan pembayaran. "
                            . "Mohon pembayaran sebelumnya dibatalkan terlebih dahulu sebelum melakukan pembatalan pemeriksaan.";
                    $status = false;
                    goto onco; // loncat ke label 'onco'
                }

                /*
                 * cek data pendaftaran pasien masuk penunjang
                 */
                $criteria = new CDbCriteria();
                if (!empty($pendaftaran_id)) {
                    $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
                }

                $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);

                $pesan = '';
                $status = false;
                $model = new PasienbatalperiksaR();
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPendaftaran->pasien_id;
                $model->tglbatal = date('Y-m-d');
                $model->keterangan_batal = $keterangan_batal;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($model->save()) {
                    $status = true;
                    $pesan = "Pemeriksaan pasien berhasil dibatalkan!";
                } else {
                    $status = false;
                    $pesan = "Pemeriksaan gagal dibatalkan! " . CHtml::errorSummary($model);
                }

                $attributes = array(
                    'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
                    'update_time' => date('Y-m-d H:i:s'),
                    'update_loginpemakai_id' => Yii::app()->user->id,
                    'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA
                );
                $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

                // hapus sep BPJS
                /*
                  if (!empty($modPendaftaran->sep_id)) {
                  $sep = SepT::model()->findByPk($modPendaftaran->sep_id);

                  if (!empty($sep)) {
                  $bpjs = new BpjsVklaim;

                  $reqSep = json_decode($bpjs->delete_transaksi_sep($sep->nosep, Yii::app()->user->getState('nama_pegawai')));

                  // var_dump($sep->nosep, Yii::app()->user->getState('nama_pegawai'), $reqSep); die;
                  }
                  }
                 */

                onco:

                /*
                 * kondisi_commit
                 */
                if ($status == true && $ada == false) {
                    $transaction->commit();
                    $this->hapusSepBatal($modPendaftaran);
                } else {
                    $transaction->rollback();
                }
            } catch (Exception $ex) {
                var_dump($ex);
                die;
                //					print_r($ex);
                $status = false;
                $pesan = "exist";
                $transaction->rollback();
            }

            $data = array(
                'pesan' => $pesan,
                'status' => $status
            );
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function hapusSepBatal($modPendaftaran) {
        $sep = SepT::model()->findByPk($modPendaftaran->sep_id);
        if (empty($sep)) {
            return false;
        }

        $no_sep = $sep->nosep;
        if (empty($no_sep)) {
            return false;
        }

        $bpjs = new Bpjs_Vklaim;
        $bpjs->delete_transaksi_sep($no_sep, Yii::app()->user->getState('nama_pemakai'));

        PendaftaranT::model()->updateAll(array('sep_id' => null), 'sep_id = ' . $sep->sep_id);
        PasiendirujukkeluarT::model()->deleteAllByAttributes(array('sep_id' => $sep->sep_id));

        $sep->delete();
    }

    /**
     * Mengatur dropdown kasus penyakit
     */
    public function actionSetDropdownKasusPenyakit() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;

            $jeniskasuspenyakit = JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif = TRUE ORDER BY jeniskasuspenyakit_nama ASC');
            $jeniskasuspenyakit = CHtml::listData($jeniskasuspenyakit, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');

            $jeniskasuspenyakitOptions = CHtml::dropDownList('jeniskasuspenyakit_id', '', $jeniskasuspenyakit, array("onchange" => "saveKasusPenyakit(this,$pendaftaran_id)", "style" => "width:140px;", "options" => array($jeniskasuspenyakit_id => array("selected" => true))));

            $dataList['kasusPenyakit'] = $jeniskasuspenyakitOptions;

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    /**
     * Mengatur dropdown kasus penyakit
     */
    public function actionSaveKasusPenyakit() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;
            $pesan = 'gagal';

            $update = RDPendaftaranT::model()->updateByPk($pendaftaran_id, array('jeniskasuspenyakit_id' => $jeniskasuspenyakit_id));
            if ($update) {
                $pesan = 'berhasil';
            } else {
                $pesan = 'gagal';
            }
            $data['pesan'] = $pesan;

            echo json_encode($data);
            Yii::app()->end();
        }
    }


    public function actionGetSubSpesialis()
    {
        $data = [];
        $data['sukses'] = 0;
        $data['pesan'] = 'Tidak Ada Kiriman Data Seperti Yang Diminta';
        if(isset($_POST['pegawai_id'])) {
            $modPegawai = PegawaiM::model()->findByPk($_POST['pegawai_id']);

            if(!empty($modPegawai)) {
                $modSpesialissub = SpesialissubspesialisM::model()->findByPk($modPegawai->spesialissubspesialis_id);
                if(!empty($modSpesialissub)) {
                    $data['sukses'] = 1;
                    $data['spesialissubspesialis_nama'] = $modSpesialissub->spesialissubspesialis_nama;
                    $data['spesialissubspesialis_id'] = $modSpesialissub->spesialissubspesialis_id;
                }
                $data['pesan'] = 'Sub Spesialis Tidak Ditemukan';
            } else {
                $data['pesan'] = 'Data Doker Tidak Ditemukan';
            }
        }

        echo json_encode($data);die;
    }

    /**
     * untuk Ubah Dokter
     */
    public function actionUbahDokterPeriksa($pendaftaran_id = null)
    {

        $this->layout = '//layouts/iframe';

        $modUbahDokter = new RDUbahdokterR;
        $modAlihLeader = new RDUbahdokterR();

        // var_dump($pendaftaran_id);die;
        $modRiwayatUbahDokter = UbahdokterR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id], ['order' => 'create_time desc']);

        // var_dump($pendaftaran_id);die;
        $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPemindahan = PemindahanpasienT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);
        
        if(!empty($modPendaftaran)) {
            $modUbahDokter->dokterlama_id = $modPendaftaran->pegawai_id;
            $modUbahDokter->dokterlama_nama = $modPendaftaran->pegawai->namaLengkap;
            $modPendaftaran->nama_pasien = $modPendaftaran->pasien->nama_pasien;
            $modPendaftaran->alamat_pasien = $modPendaftaran->pasien->alamat_pasien;
            if(!empty($modPemindahan)) {
                $modPendaftaran->ruangan_nama = $modPemindahan->ruangantujuan->ruangan_nama;
                $modPendaftaran->ruangan_id = $modPemindahan->ruangantujuan_id;
            } else {
                $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
            }
            $modPendaftaran->no_rekam_medik = $modPendaftaran->pasien->no_rekam_medik;


            // tab alih leader
            $modAlihLeader->dokterlama_nama = $modPendaftaran->pegawai->namaLengkap;
            $modAlihLeader->dokterlama_id = $modPendaftaran->pegawai_id;

            // echo '<pre>';
            // var_dump($modPendaftaran->pegawai->spesialissubspesialis);die;
            if(!empty($modPendaftaran->pegawai->spesialissubspesialis_id)) {
                $modSpesialissub = SpesialissubspesialisM::model()->findByPk($modPendaftaran->pegawai->spesialissubspesialis_id);
                if(!empty($modSpesialissub)) {
                    $modAlihLeader->spesialissubspesialis_nama = $modSpesialissub->spesialissubspesialis_nama ?? '';
                }
            }
            
        }
 
        // var_dump($modUbahDokter, $modRiwayatUbahDokter);die;
        
        if(empty($modPendaftaran)) {
            $modPendaftaran = new RDPendaftaranT();
        }

        // echo '<pre>';
        // var_dump($model);die;

        if (isset($_POST['RDPendaftaranT'])) {

            // echo '<pre>';
            // var_dump($_POST);die;
            $transaction = Yii::app()->db->beginTransaction();

            if(isset($_POST['formalihleader'])) {
                if ($_POST['RDUbahdokterR']['spesialis_id'] != "") {
                    $modUbahDokter->attributes = $_POST['RDUbahdokterR'];
                    $modUbahDokter->pendaftaran_id = $_POST['RDPendaftaranT']['pendaftaran_id'];
                    $modUbahDokter->tglubahdokter = MyFormatter::formatDateTimeForDb($_POST['tglubahdokter']);
                    $modUbahDokter->create_time = date('Y-m-d H:i:s');
                    $modUbahDokter->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modUbahDokter->alasanperubahandokter = 'ALIH LEADER';
                    $modUbahDokter->keterangan = 'ALIH LEADER';
    
                    // echo '<pre>';
                    // var_dump($modUbahDokter->attributes);die;
                    try {
    
                        // $attributes = array('pegawai_id' => $_POST['RDUbahdokterR']['dokterbaru_id']);
            
                        // $save = RDPendaftaranT::model()->updateByPk($_POST['RDPendaftaranT']['pendaftaran_id'], $attributes);
            
                        // if ($save) {
                        if($modUbahDokter->save()) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', 'Data Berhasil Disimpan !');
                            $this->redirect(array('UbahDokterPeriksa', 'pendaftaran_id'=>$pendaftaran_id, 'sukses' => 1));

                        } else {
                            $transaction->rollback();
                            // var_dump($modUbahDokter->getErrors());die;
                            Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan !');

                        }
                        // } else {
                        //     $transaction->rollback();
                        //     Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan {2}!');
    
    
                        // }
                        
                    } catch (Exception $exc) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan {3}!');
    
                    }
                }
            } else {
                // echo '<pre>';
                // var_dump($_POST);die;
                if ($_POST['RDUbahdokterR']['spesialis_id'] != "") {
                    $modAlihLeader->attributes = $_POST['RDUbahdokterR'];
                    $modAlihLeader->pendaftaran_id = $_POST['RDPendaftaranT']['pendaftaran_id'];
                    $modAlihLeader->tglubahdokter = MyFormatter::formatDateTimeForDb($_POST['tglubahdokter']);
                    $modAlihLeader->create_time = date('Y-m-d H:i:s');
                    $modAlihLeader->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modAlihLeader->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modAlihLeader->keterangan = $_POST['RDUbahdokterR']['alasanperubahandokter'];


                    try {
    
                        // $attributes = array('pegawai_id' => $_POST['RDUbahdokterR']['dokterbaru_id']);
            
                        // $save = RDPendaftaranT::model()->updateByPk($_POST['RDPendaftaranT']['pendaftaran_id'], $attributes);
            
                        // if ($save) {
                        if($modAlihLeader->save()) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', 'Data Berhasil Disimpan !');
                            $this->redirect(array('UbahDokterPeriksa', 'pendaftaran_id'=>$pendaftaran_id, 'sukses' => 1));

                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan !');

                        }
                        // } else {
                        //     $transaction->rollback();
                        //     Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan {2}!');
    
    
                        // }
                        
                    } catch (Exception $exc) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan {3}!');
    
                    }
                }
            }
        }

   
        $this->render($this->path_view . '_formUbahDokterPeriksa', array(
            'modPendaftaran' => $modPendaftaran, 
            'modUbahDokter' => $modUbahDokter, 
            'modDokter' => $modUbahDokter, 
            'modRiwayatUbahDokter' => $modRiwayatUbahDokter,
            'modAlihLeader' => $modAlihLeader
        ));
        
    }

    function actionBatalDisposisi() {
        $ubahdokter_id = $_POST['ubahdokter_id'];
        $pendaftaran_id = $_POST['pendaftaran_id'];

        if(UbahdokterR::model()->deleteByPk($ubahdokter_id)) {
            $data['sukses'] = 1;
        } else {
            $data['sukses'] = 0;
        }
        $modRiwayatUbahDokter = UbahdokterR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id], ['order' => 'create_time desc']);
        $data['html'] = $this->renderPartial('ubahdokterperiksa/_trRiwayat', ['modRiwayatUbahDokter' => $modRiwayatUbahDokter], true);

        echo json_encode($data);
    }

    public function actionUbahDPJP($pendaftaran_id = null)
    {

        $this->layout = '//layouts/iframe';

        $modUbahDokter = new RDUbahdokterR;
        

        // var_dump($pendaftaran_id);die;
        $modRiwayatUbahDokter = UbahdokterR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id], ['order' => 'create_time desc']);

        // var_dump($pendaftaran_id);die;
        $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);

        if(!empty($modPendaftaran)) {
            $modUbahDokter->dokterlama_id = $modPendaftaran->pegawai_id;
            $modUbahDokter->dokterlama_nama = $modPendaftaran->pegawai->nama_pegawai;
            $modPendaftaran->nama_pasien = $modPendaftaran->pasien->nama_pasien;
            $modPendaftaran->alamat_pasien = $modPendaftaran->pasien->alamat_pasien;
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
            $modPendaftaran->no_rekam_medik = $modPendaftaran->pasien->no_rekam_medik;
            
        }
        
        // var_dump($modUbahDokter, $modRiwayatUbahDokter);die;
        
        if(empty($modPendaftaran)) {
            $modPendaftaran = new RDPendaftaranT();
        }

        // echo '<pre>';
        // var_dump($model);die;

        if (isset($_POST['RDPendaftaranT'])) {

            // echo '<pre>';
            // var_dump($_POST);die;
            $transaction = Yii::app()->db->beginTransaction();

           
            // echo '<pre>';
            // var_dump($_POST);die;
            if ($_POST['RDUbahdokterR']['dokterbaru_id'] != "") {
                $modUbahDokter->attributes = $_POST['RDUbahdokterR'];
                $modUbahDokter->pendaftaran_id = $_POST['RDPendaftaranT']['pendaftaran_id'];
                $modUbahDokter->tglubahdokter = MyFormatter::formatDateTimeForDb($_POST['tglubahdokter']);
                $modUbahDokter->create_time = date('Y-m-d H:i:s');
                $modUbahDokter->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
                // echo '<pre>';var_dump($modUbahDokter);die;
                try {

                    $attributes = array('pegawai_id' => $_POST['RDUbahdokterR']['dokterbaru_id']);
        
                    $save = RDPendaftaranT::model()->updateByPk($_POST['RDPendaftaranT']['pendaftaran_id'], $attributes);
                    // echo '<pre>';var_dump($save, $modUbahDokter->validate());die;
                    if ($save) {
                        if($modUbahDokter->save()) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', 'Data Berhasil Disimpan !');
                            $this->redirect(array('UbahDPJP', 'pendaftaran_id'=>$pendaftaran_id, 'sukses' => 1));

                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan !');

                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan {2}!');


                    }
                    
                } catch (Exception $exc) {
                    echo '<pre>';var_dump($exc);die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan {3}!');

                }
            }
            
        }

   
        $this->render($this->path_view . 'dpjp/_formUbahDPJP', array(
            'modPendaftaran' => $modPendaftaran, 
            'modUbahDokter' => $modUbahDokter, 
            'modDokter' => $modUbahDokter, 
            'modRiwayatUbahDokter' => $modRiwayatUbahDokter,
        ));
        
    }



    public function actionUbahDokterPeriksa2()
    {

        // var_dump($_POST); die;
        
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
        $modDokter = RDUbahdokterR::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
    
        $modPendaftaran->pegawai_id =  Yii::app()->user->getState('pegawai_id');
        $modPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id );
        $modPegawai->nama_pegawai;


      $model = new RDPendaftaranT();
      $modUbahDokter = new RDUbahdokterR;
      $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
      if (isset($_POST['RDPendaftaranT'])) {
        if ($_POST['RDPendaftaranT']['pegawai_id'] != "") {
          $modUbahDokter->attributes = $_POST['RDUbahdokterR'];
          $modUbahDokter->pendaftaran_id = $_POST['RDPendaftaranT']['pendaftaran_id'];
          $modUbahDokter->dokterbaru_id = $_POST['RDPendaftaranT']['pegawai_id'];
          $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
        //   $modUbahDokter->create_time = date('Y-m-d H:i:s');
          $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
          $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $transaction = Yii::app()->db->beginTransaction();
          try {
            $attributes = array('pegawai_id' => $_POST['RDPendaftaranT']['pegawai_id']);
  
            $save = RDPendaftaranT::model()->updateByPk($_POST['RDPendaftaranT']['pendaftaran_id'], $attributes);
  
            if ($save) {
              $modUbahDokter->save();
              $transaction->commit();
              echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='alert-success'>Berhasil merubah Dokter Periksa.</div>",
              ));
            } else {
              echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='alert-error'>Data gagal disimpan.</div>",
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
              'div' => "<div class='alert-success'>Berhasil merubah Dokter Periksa.</div>",
            )
          );
          exit;
        }
      }
  
   $this->renderPartial('_formUbahDokterPeriksa2', array('model' => $model,'modPendaftaran'=>$modPendaftaran,
   'modDokter'=>$modDokter,
   'modPegawai'=>$modPegawai, 'modUbahDokter' => $modUbahDokter, 'menu' => $menu));
 
    }

    public function actionTambahTriage() {
        $model = new RDNotriagePasienT;
        $model->no_bed_triage = '- Otomatis -';

        if (isset($_POST['RDNotriagePasienT'])) {

            if ($_POST['RDNotriagePasienT'] != "") {

                $transaction = Yii::app()->db->beginTransaction();
                $ok = true;
                try {
                    $model->attributes = $_POST['RDNotriagePasienT'];
                    $model->no_bed_triage = MyGenerator::noTriagePasien();
                    $model->no_triage_pasien = ($model->bed_triage_id < 10) ? 'A0' . $model->bed_triage_id : 'A' . $model->bed_triage_id;
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $ok && $model->save();

                    if ($ok) {
                        $transaction->commit();
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-success'>Berhasil menambahkan pasien IGD.</div>",
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
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'create_form',
                'div' => $this->renderPartial('_formTambahPasienIGD', array('model' => $model), true)
            ));
            exit;
        }
    }

    public function actionTambahTriagePasien() {
        $model = new RDNotriagePasienT;
        $model->no_bed_triage = '- Otomatis -';

        if (isset($_POST['RDNotriagePasienT'])) {

            if ($_POST['RDNotriagePasienT'] != "") {
                $transaction = Yii::app()->db->beginTransaction();
                $ok = true;
                try {
                    $model->attributes = $_POST['RDNotriagePasienT'];
                    $model = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $_POST['RDNotriagePasienT']['notriage_pasien_id']));
                    $model->pendaftaran_id = $_POST['RDNotriagePasienT']['pendaftaran_id'];
                    $model->pasien_id = $_POST['RDNotriagePasienT']['pasien_id'];
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $ok && $model->save();

                    if ($ok) {
                        $transaction->commit();
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-success'>Berhasil menambahkan pasien IGD.</div>",
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
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'create_form',
                'div' => $this->renderPartial('_formTambahTriagePasienIGD', array('model' => $model), true)
            ));
            exit;
        }
    }

    public function actionGetDataPendaftaranRD() {
        if (Yii::app()->request->isAjaxRequest) {
            $id_pendaftaran = $_POST['pendaftaran_id'];
            $model = RDInfoKunjunganRDV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
                $returnVal["gelarbelakang_nama"] = isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "";
                $returnVal["gelardepan"] = isset($model->gelardepan) ? $model->gelardepan : "";
            }
            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }

    public function actionLoadTriage() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];

            $model = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $id));
            $attributes = $model->attributeNames();

            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }

            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }

    public function actionGetDataPendaftaran() {
        if (Yii::app()->request->isAjaxRequest) {
            $id_pendaftaran = $_POST['pendaftaran_id'];
            $model = RDInfoKunjunganRDV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }

    public function actionListDokterRuangan() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (!empty($_POST['idRuangan'])) {
                $idRuangan = $_POST['idRuangan'];
                $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
                $data = CHtml::listData($data, 'pegawai_id', 'nama_pegawai');

                if (empty($data)) {
                    $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($data as $value => $name) {
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

    public function actionTerimaDokumen() {
        if (Yii::app()->request->isAjaxRequest) {
            $pendaftaran = $_POST['pendaftaran_id'];
            $pengirimanrm_id = $_POST['pengirimanrm_id'];

            $model = PendaftaranT::model()->findByPk($pendaftaran);
            if (!empty($pengirimanrm_id)) {
                $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
                $modPenerimaanRm->tglterimadokrm = date('Y-m-d H:i:s');
                $modPenerimaanRm->petugaspenerima_id = Yii::app()->user->id;
                $modPenerimaanRm->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');

                // print_r($modPenerimaanRm->attributes); die;

                if ($modPenerimaanRm->save()) {
                    $model->statusdokrm = 'SUDAH DITERIMA';
                    $model->save();

                    $judul = 'Penerimaan Berkas Rekam Medis';

                    $isi = $modPenerimaanRm->pasien->no_rekam_medik . ' - ' . $modPenerimaanRm->pasien->nama_pasien;


                    CustomFunction::broadcastNotif($judul, $isi, array(
                        array('instalasi_id' => $modPenerimaanRm->ruanganpengirim->instalasi->instalasi_id, 'ruangan_id' => $modPenerimaanRm->ruanganpengirim->ruangan_id, 'modul_id' => !empty($modPenerimaanRm->ruanganpengirim->modul_id) ? $modPenerimaanRm->ruanganpengirim->modul_id : null),
                    ));

                    $update = true;
                } else {
                    $update = false;
                }
            }

            if ($update == true) {
                $status = 'proses_form';
                $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil diterima </div>";
            } else {
                $status = 'proses_form';
                $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal diterima </div>";
            }

            echo CJSON::encode(array(
                'status' => $status,
                'div' => $div,
            ));
            exit;
        }
    }

    public function actionKirimDokumen($pengirimanrm_id, $pendaftaran_id) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $status = false;
        if (!empty($pengirimanrm_id)) {
            $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        } else {
            $modPengirimanRm = new PengirimanrmT();
        }

        $modUbahStatus = new PengirimanrmT;
        $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');

        if (isset($_POST['PengirimanrmT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modUbahStatus->attributes = $_POST['PengirimanrmT'];
                $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
                $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
                $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
                $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
                $modUbahStatus->kelengkapandokumen = TRUE;
                $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
                $modUbahStatus->create_time = date('Y-m-d H:i:s');
                $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
                $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');

                if ($modUbahStatus->save()) {
                    $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
                    $modPendaftaran->save();

                    $transaction->commit();
                    $status = true;
                    Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
                } else {
                    $status = false;
                    Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $status = false;
                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render('_formStatusDokumen', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modPengirimanRm' => $modPengirimanRm,
            'modUbahStatus' => $modUbahStatus,
            'status' => $status
        ));
    }

    public function actionStatusDokumenKirim($pengirimanrm_id, $pendaftaran_id) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAdmisi = null;
        $status = false;
        if (!empty($pengirimanrm_id)) {
            $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        } else {
            $modPengirimanRm = new PengirimanrmT();
        }



        $pegawai_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id;
        $modUbahStatus = new PengirimanrmT;
        $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');
        $modUbahStatus->petugaspengirim = Yii::app()->user->name;
        $modUbahStatus->petugaspengirim_id = $pegawai_id;


        if (!empty($modPendaftaran->pasienadmisi_id)) {
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modUbahStatus->instalasi_id = Params::INSTALASI_ID_RI;
            $modUbahStatus->ruangan_id = $modAdmisi->ruangan_id;

            // var_dump($modUbahStatus->attributes); die;
        }

        if (isset($_POST['PengirimanrmT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modUbahStatus->attributes = $_POST['PengirimanrmT'];
                //var_dump($_POST);die;
                $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
                $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
                $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
                $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
                $modUbahStatus->kelengkapandokumen = TRUE;
                $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
                $modUbahStatus->create_time = date('Y-m-d H:i:s');
                $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
                $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
                $modUbahStatus->ruanganpenerima_id = $_POST['PengirimanrmT']['ruangan_id'];

                if ($modUbahStatus->save()) {
                    $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
                    $modPendaftaran->pengirimanrm_id = $modUbahStatus->pengirimanrm_id;
                    $modPendaftaran->save();

                    $judul = 'Pengiriman Berkas Rekam Medis';

                    $isi = $modUbahStatus->pendaftaran->no_pendaftaran . ' - ' . $modUbahStatus->pasien->no_rekam_medik . ' - ' . $modUbahStatus->pasien->nama_pasien;

                    CustomFunction::broadcastNotif($judul, $isi, array(
                        array('instalasi_id' => $modUbahStatus->ruangantujuan->instalasi->instalasi_id, 'ruangan_id' => $modUbahStatus->ruangantujuan->ruangan_id, 'modul_id' => !empty($modUbahStatus->ruangantujuan->modul_id) ? $modUbahStatus->ruangantujuan->modul_id : null),
                    ));

                    $transaction->commit();
                    $status = true;
                    Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
                } else {
                    $status = false;
                    Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $status = false;
                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render('_formStatusDokumen', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modPengirimanRm' => $modPengirimanRm,
            'modUbahStatus' => $modUbahStatus,
            'modAdmisi' => $modAdmisi,
            'status' => $status
        ));
    }

    public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if ($model_nama !== '' && $attr == '') {
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            } else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            } else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

            if ($encode) {
                echo CJSON::encode($models);
            } else {
                if (count((array) $models) > 1) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } elseif (count((array) $models) == 0) {
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

    /**
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     * 
     * @param type $term data dari Text Input
     */
    public function actionGetDokterPenerima($term = null) {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();

        $prov = PegawaiV::model()->searchDokter();
        $prov->criteria->compare('lower(nama_pegawai)', strtolower($term), true);
        $prov->sort->defaultOrder = 'nama_pegawai';
        $prov->pagination = false;

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->pegawai_id;
            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }


    public function actionViewRiwayatDPJP($pendaftaran_id)
    {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
        $modRiwayatUbahDokter = RDUbahdokterR::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
    
        $modPendaftaran->pegawai_id =  Yii::app()->user->getState('pegawai_id');
        $modPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id );
        $modPegawai->nama_pegawai;

        $this->render('_formRiwayatDPJP', array('modPendaftaran'=>$modPendaftaran,
        'modRiwayatUbahDokter'=>$modRiwayatUbahDokter,
        'modPegawai'=>$modPegawai
        ));
    }
  
    /**
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     * 
     * Ambil data dokter Umum dari autocomplete.
     * 
     * @param type $term data dari Text Input
     */
    public function actionGetDokterDPJP($term = null) {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();

        $prov = PegawaiV::model()->searchDokter();
        $prov->criteria->compare('lower(nama_pegawai)', strtolower($term), true);
        $prov->sort->defaultOrder = 'nama_pegawai';
        $prov->pagination = false;

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->pegawai_id;
            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    public function simpanPengirimanDokRM($modPendaftaran, $post, $dokrekammedis_id) {
        $modUbahStatus = new PengirimanrmT;
        $modUbahStatus->attributes = $post;
        $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
        $modUbahStatus->dokrekammedis_id = $dokrekammedis_id;
        $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
        $modUbahStatus->tglpengirimanrm = MyFormatter::formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
        $modUbahStatus->kelengkapandokumen = TRUE;
        $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
        $modUbahStatus->create_time = date('Y-m-d H:i:s');
        $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpenerima_id = $_POST['PengirimanrmT']['ruangan_id'];

        if ($modUbahStatus->save()) {


            PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('statusdokrm' => 'SUDAH DIKIRIM', 'pengirimanrm_id' => $modUbahStatus->pengirimanrm_id));

            $judul = 'Pengiriman Berkas Rekam Medis';

            $isi = $modUbahStatus->pendaftaran->no_pendaftaran . ' - ' . $modUbahStatus->pasien->no_rekam_medik . ' - ' . $modUbahStatus->pasien->nama_pasien;

            CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => $modUbahStatus->ruangantujuan->instalasi->instalasi_id, 'ruangan_id' => $modUbahStatus->ruangantujuan->ruangan_id, 'modul_id' => !empty($modUbahStatus->ruangantujuan->modul_id) ? $modUbahStatus->ruangantujuan->modul_id : null),
            ));

            return true;
        } else {
            return false;
        }
    }

    public function actionRiwayatDokfilerm($pendaftaran_id) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $crit = new CDbCriteria();
        $crit->addCondition('pasien_id =' . $modPasien->pasien_id);
        $modDokfilerm = DokfilermR::model()->findAll($crit);
        $modDokfilerms = [];
        foreach ($modDokfilerm as $dok) {
            // if (in_array(Yii::app()->user->getState('instalasi_id'), (array) $dok->instalasi_ids)) {
                $modDokfilerms[] = $dok;
            // }
        }
        $this->render('_listDokfilerm', array('modDokfilerm' => $modDokfilerms));
    }

    public function actionDetailScanRM($dokfilerm_id) {
        $this->layout = '//layouts/iframe';

        $file = DokfilermR::model()->findByPk($dokfilerm_id);

        $this->render("detail", array(
            'file' => $file,
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
        $is_notif = 0;
    
        $reseptur = ResepturT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $id,
        ), array(
        'condition' => 'penjualanresep_id is null',
        'order' => 'tglreseptur asc',
        ));


        $crTriage = new CDbCriteria;
        $crTriage->join = "join notriage_pasien_t n on n.notriage_pasien_id = t.notriage_pasien_id 
        left join obatalkespasien_t o on o.pengambilanobat_triage_id = t.pengambilanobat_triage_id";
        $crTriage->compare('n.pendaftaran_id', $id);
        $crTriage->addCondition('o.pengambilanobat_triage_id is null');
        $crTriage->order = 't.noresep_triage asc';
        $oaTriage = PengambilanobatTriageT::model()->findAll($crTriage);

        $oaTriage2 = PengambilanobatTriageT::model()->findAll("pendaftaran_id = $id and is_jual is false");

        
    
        // ============= Pemeriksaan belum diapprove di lab/rad ===========
        $kirim = PasienkirimkeunitlainT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $id,
        'instalasi_id' => array(Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_IBS, Params::INSTALASI_ID_REHAB),
        ), array(
        'condition' => 'tglrencanapemeriksaan is null',
        ));

        // cek resume medis juga
        $modResume = ResumemedisR::model()->findAllByAttributes(['pendaftaran_id' => $id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')]);

        // var_dump(count($kirim), count($reseptur), count($oaTriage2)); die;
    
        if (count($kirim) > 0 || count($reseptur) > 0 || count($oaTriage2) > 0 || count($modResume) < 1) {
        $ok = 0;
        $is_notif = 1;

    
        $grup_kirim = array(
            Params::INSTALASI_ID_LAB => array(
            'nama'=>'Pemeriksaan Laboratorium',
            'detail'=>array(),
            ),
            Params::INSTALASI_ID_RAD => array(
            'nama'=>'Pemeriksaan Radiologi',
            'detail'=>array(),
            ),
            Params::INSTALASI_ID_IBS => array(
            'nama'=>'Tindakan Bedah',
            'detail'=>array(),
            ),
            Params::INSTALASI_ID_REHAB => array(
            'nama'=>'Tindakan Fisioterapi',
            'detail'=>array(),
            ),
        );
    
        foreach ($kirim as $item) {
            $grup_kirim[$item->instalasi_id]['detail'][] = $item;
        }
    
        $msg = $this->renderPartial($this->path_view."_notifPenunjang", array(
            'grup_kirim'=>$grup_kirim, 'reseptur'=>$reseptur, 'oaTriage'=>$oaTriage, 'oaTriage2'=>$oaTriage2, 'modResume' => $modResume
        ), true);
    
        goto outs;
        }
    
        if (count((array)$reseptur) > 0) {
        $is_belum = false;
        foreach ($reseptur as $item) {
            $pen = PenjualanresepT::model()->findByAttributes(array(
            'reseptur_id' => $item->reseptur_id
            ));
            if (empty($pen)) {
            $is_belum = true;
            break;
            }
        }
    
        if ($is_belum) {
            $ok = 0;
            $msg = "Pasien memiliki reseptur yang belum diverifikasi. Silahkan lakukan penjualan terlebih dahulu.";
            
            goto outs;
        }
        }
    
        outs:
        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg, 'is_confirm' => $is_confirm, 'is_notif'=>$is_notif));
    }

    public function actionUpdateTriagePasien($pendaftaran_id, $notriage_pasien_id = null) {

        $this->layout = '//layouts/iframe';
        $sukses = false;
        $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
        $model = new RDNotriagePasienT;
        if (!empty($notriage_pasien_id)) {
            $model = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id));
        } else {
            $cekNo = RDNotriagePasienT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            if (!empty($cekNo)) {
                $model = $cekNo;
            }
        }

        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        if (isset($_POST['RDNotriagePasienT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {
                $clone = clone $model;
                if (!empty($_POST['RDNotriagePasienT']['notriage_pasien_id'])) {
                    $cek = RDNotriagePasienT::model()->findByPk($_POST['RDNotriagePasienT']['notriage_pasien_id']);
                    if (!empty($cek)) {
                        $model = $cek;
                    }
                }
                $model->attributes = $_POST['RDNotriagePasienT'];
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $ok && $model->update();

                // echo '<pre>'; var_dump($model->attributes, $clone->attributes); die();

                if($_POST['RDNotriagePasienT']['notriage_pasien_id']) {
                    $anamnesa = AnamnesaT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);
        
                    $pemeriksaanfisik = PemeriksaanfisikT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);
        
                  
                    if (!empty($anamnesa)) {
                        $anamnesa->pendaftaran_id = $model->pendaftaran_id;
                        $anamnesa->pasien_id = $model->pasien_id;
                        $anamnesa->update_time = date('Y-m-d H:i:s');
                        $anamnesa->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $anamnesa->update();
                    }
        
                    if (!empty($pemeriksaanfisik)) {
                        $pemeriksaanfisik->pendaftaran_id = $model->pendaftaran_id;
                        $pemeriksaanfisik->pasien_id = $model->pasien_id;
                        $pemeriksaanfisik->update_time = date('Y-m-d H:i:s');
                        $pemeriksaanfisik->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $pemeriksaanfisik->update();
                    }
                } else {
                    $anamnesa = AnamnesaT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);
        
                    $pemeriksaanfisik = PemeriksaanfisikT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);
        
                  
                    if (!empty($anamnesa)) {
                        $anamnesa->pendaftaran_id = null;
                        $anamnesa->pasien_id = null;
                        $anamnesa->update_time = date('Y-m-d H:i:s');
                        $anamnesa->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $anamnesa->update();
                    }
        
                    if (!empty($pemeriksaanfisik)) {
                        $pemeriksaanfisik->pendaftaran_id = null;
                        $pemeriksaanfisik->pasien_id = null;
                        $pemeriksaanfisik->update_time = date('Y-m-d H:i:s');
                        $pemeriksaanfisik->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $pemeriksaanfisik->update();
                    }
                }

                if (!empty($clone->notriage_pasien_id)) {
                    // if ($clone->notriage_pasien_id != $model->notriage_pasien_id) {
                        $clone->pendaftaran_id = null;
                        $clone->pasien_id = null;
                        $clone->update();

                    //     $wpss = AsesmentriagewpssT::model()->findByAttributes([
                    //         'notriage_pasien_id' => $clone->notriage_pasien_id
                    //     ]);
                    //     // var_dump(1, $clone->notriage_pasien_id);die;
                    //     if (!empty($wpss)) {
                    //         $wpss->pendaftaran_id = null;
                    //         $wpss->pasien_id = null;
                    //         $wpss->update();
                    //     }
                    // } else {
                        $wpss = AsesmentriagewpssT::model()->findByAttributes([
                            'notriage_pasien_id' => $model->notriage_pasien_id
                        ]);

                        if (!empty($wpss)) {
                            $wpss->pendaftaran_id = $model->pendaftaran_id;
                            $wpss->pasien_id = $model->pasien_id;
                            $wpss->update();
                        }

                        
                    // }
                }

                if ($ok) {

                    $trans->commit();
                    $sukses = true;
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ! ");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . $ex->getMessage());
            }
        }

        $this->render('_formTambahTriagePasienIGD', array('model' => $model, 'sukses' => $sukses));
    }

    public function actionTambahAsesmenTriage() {
        
        $model = new RDAsesmentriaseT;
        $model->tglasesmentriase = date('d M Y');
        
        $modDraft = new DraftasesmentriaseT;

        if (isset($_POST['RDAsesmentriaseT'])) {
            $pesan = '';
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                
                $proses = RDAsesmentriaseT::simpanData($model, $_POST['RDAsesmentriaseT']);
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];
                $model = $proses['model'];
                
                $_POST['DraftasesmentriaseT']['asesmentriase_id'] = $model->asesmentriase_id;
                
                $proses = DraftasesmentriaseT::simpanData($modDraft, $_POST['DraftasesmentriaseT']);
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];
                
                
                $modDraft = $proses['model'];

                $ok &= $model->save();
                                

                if ($ok) {
                    $transaction->commit();
                    echo CJSON::encode(array(
                        'form' => 'simpan',
                    ));
                } else {
                    echo CJSON::encode(array(
                        'form' => 'gagal',
                        'pesan' => $pesan
                    ));
                }
                exit;
            } catch (Exception $exc) {                
                $transaction->rollback();
                echo CJSON::encode(array(
                    'form' => 'gagal',
                    'pesan' => $pesan.' '.$exc->getMessage()
                ));
                exit;
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'form' => 'tambah',
                'div' => $this->renderPartial('_formTambahAsesmenTriase', array(
                    'model' => $model,
                    'modDraft' => $modDraft
                ), true),                
            ));
            exit;
        }
    }

    public function actionSetAsesmenTriage(){
        if (Yii::app()->request->isAjaxRequest){
            
            $asesmenId = isset($_POST['asesmenId'])?$_POST['asesmenId']:null;
            $daftarId = isset($_POST['daftarId'])?$_POST['daftarId']:null;
            
            $sukses = 1;
            
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $ases = AsesmentriaseT::model()->findByPk($asesmenId);
                $ases->pendaftaran_id = $daftarId;
                $ases->pasien_id = $ases->pendaftaran->pasien_id;
                $ok &= $ases->update(['pendaftaran_id','pasien_id']);
                
                if ($ok){
                    $trans->commit();
                    $sukses = 1;
                }else{
                    $trans->rollback();
                    $sukses = 0;
                }                
            }catch (Exception $e){
                $trans->rollback();
                $sukses = 0;
            }
            
            echo json_encode([
                'sukses' => $sukses
            ]);
            exit;
        }
    }

    public function actionRiwayatPelayanan($pendaftaran_id) {

        $this->layout = '//layouts/iframe';
        $sukses = 'tidak';
        $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPengirim = PengirimanrmT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
        $modFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
        
//var_dump($modFisik); die;

        $this->render('_riwayatPelayanan', array('modPengirim'=>$modPengirim,'modFisik'=>$modFisik,'modPendaftaran' => $modPendaftaran));
    }

    /**
     * Jawab konsul poli pasien
     * @param integer $konsulpoli_id
     */
    public function actionKonsultasiInternal($konsulpoli_id)
    {
        Yii::import("rawatJalan.models.*");

        $this->layout = '//layouts/iframe';
        $model = RJKonsulPoliT::model()->findByPk($konsulpoli_id);
        $model->uraian_konsul = strip_tags($model->uraian_konsul);

        if (empty($model)) {
            echo "Pasien belum melakukan konsultasi poliklinik";
            Yii::app()->end();
        }

        $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit', 'kelaspelayanan')->findByPk($model->pendaftaran_id);
        $modPasien = $modPendaftaran->pasien;
        $pasienMorbiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
        $modUraian = new RJPasienMorbiditasT();
        $modMorbiditas = RJPasienMorbiditasT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
            'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
        ));

        $model->tgljawabpoli = !empty($model->tgljawabpoli) ? $model->tgljawabpoli : date('d M Y H:i:s');
        if (!empty($model->pegawaikonsul_id)) {
            $model->nama_pegawai = PegawaiM::model()->findByPk($model->pegawaikonsul_id)->nama_pegawai;
        }

        if (isset($_POST['RJKonsulPoliT'])) {
            $sukses = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RJKonsulPoliT'];
                $model->uraian_konsul = isset($_POST['RJKonsulPoliT']['uraian_konsul']) ? $_POST['RJKonsulPoliT']['uraian_konsul'] : $model->uraian_konsul;
                $model->uraian_konsuljawaban = isset($_POST['RJKonsulPoliT']['uraian_konsuljawaban']) ? $_POST['RJKonsulPoliT']['uraian_konsuljawaban'] : $model->uraian_konsuljawaban;
                if ($model->save()) {

                    if (isset($_POST['RJPasienMorbiditasT'])) {
                        foreach ($_POST['RJPasienMorbiditasT'] as $key => $val) {
                            if ($val['pasienmorbiditas_id'] == null || $val['pasienmorbiditas_id'] == "") {
                                $insert = new RJPasienMorbiditasT();
                                $insert->attributes = $val;
                                $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
                                $insert->kelompokumur_id = $modPasien->kelompokumur_id;
                                $insert->golonganumur_id = $modPendaftaran->golonganumur_id;
                                $insert->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                                $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
                                $insert->kasusdiagnosa = $val['kasusdiagnosa'];
                                $insert->pasien_id = $modPendaftaran->pasien_id;
                                $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                                $insert->pegawai_id = $val['pegawai_id'];
                                $insert->$golUmur = 1;
                                if ($insert->save()) {
                                    $sukses &= true;
                                } else {
                                    $sukses &= false;
                                }
                            }
                        }
                    }
                } else {
                    $sukses &= false;
                }

                // var_dump($sukses); die;

                if ($sukses) {
                    $transaction->commit();

                    $ruangan_id = "";
                    $daftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);

                    if (!empty($daftar->pasienadmisi_id)) {
                        $admisiMod = PasienadmisiT::model()->findBypk($daftar->pasienadmisi_id);
                        $ruangan_id = (isset($admisiMod) ? $admisiMod->ruangan_id : "");
                    } else {
                        $ruangan_id = (isset($daftar) ? $daftar->ruangan_id : "");
                    }

                    if (!empty($ruangan_id)) {
                        $ruanganMod = RuanganM::model()->findByPk($ruangan_id);
                        $ruangKonsul = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

                        if (isset($ruanganMod)) {
                            $judul = 'Pasien Konsultasi Internal';
                            $isi = 'Pasien ' . $modPasien->nama_pasien . ' dengan nomor rekam medik ' . $modPasien->no_rekam_medik . ' Telah melakukan konsultasi Internal di ' . $ruangKonsul->ruangan_nama . ' pada ' . $model->tgljawabpoli;
                            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                                array('instalasi_id' => $ruanganMod->instalasi_id, 'ruangan_id' => $ruanganMod->ruangan_id, 'modul_id' => $ruanganMod->modul_id),
                            ));
                        }
                    }

                    Yii::app()->user->setFlash('success', "Data berhasil update");
                    $this->redirect(array('KonsultasiInternal', 'konsulpoli_id' => $konsulpoli_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('danger', "Data tidak berhasil update");
                }
            } catch (Exception $ex) {
                $transaction->rollback(); var_dump($ex->getMessage()); die;
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('konsultasiInternal/index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'pasienMorbiditas' => $pasienMorbiditas,
            'modUraian' => $modUraian,
            'modMorbiditas' => $modMorbiditas,
        ));
    }

    /**
     * Untuk cek golongan umur
     * @param type $idGolonganUmur
     */
    private function cekGolonganUmur($idGolonganUmur)
    {
        switch ($idGolonganUmur) {
            case 1:
                return 'umur_5_14thn';
            case 2:
                return 'umur_15_24thn';
            case 3:
                return 'umur_25_44thn';
            case 4:
                return 'umur_45_64thn';
            case 5:
                return 'umur_65';
            case 9:
                return 'umur_65';
            case 10:
                return 'umur_65';
            case 6:
                return 'umur_0_28hr';
            case 7:
                return 'umur_28hr_1thn';
            case 8:
                return 'umur_1_4thn';
            default:
                break;
        }
    }

    function actionCekPersetujualAlihLeader() {
        $tgl_awal = $_POST['tgl_awal'];
        $tgl_akhir = $_POST['tgl_akhir'];

        $criteria = new CDbCriteria();
        $criteria->addCondition("create_ruangan = " . Yii::app()->user->getState('ruangan_id'));
        $criteria->addCondition("is_approve is null and (alasanperubahandokter = 'Disposisi' OR alasanperubahandokter = 'ALIH LEADER')");
        $criteria->addCondition('dokterbaru_id = ' . Yii::app()->user->getState('pegawai_id'));
        $criteria->addCondition('spesialissubspesialis_id = ' . Yii::app()->user->getState('spesialissubspesialis_id') . ' and is_approve is null', 'OR');
        $criteria->addBetweenCondition('DATE(tglubahdokter)', $tgl_awal, $tgl_akhir);

        $belumApproveAlihLeader = UbahdokterR::model()->findAll($criteria);


        $total = count($belumApproveAlihLeader);
        $data['total'] = $total;
        $msg = '';
        if ($total > 0) {
            $msg = "Silahkan lakukan persetujuan pasien disposisi/alih leader berikut : \n";
            foreach ($belumApproveAlihLeader as $idx => $item) {
                $nama = '';
                $no_rekam_medik = '';
                $namadokter = '';
                if(!empty($item->pendaftaran->pasien->nama_pasien)) {
                    $nama = $item->pendaftaran->pasien->nama_pasien;
                }
                if(!empty($item->pendaftaran->pasien->no_rekam_medik)) {
                    $no_rekam_medik = $item->pendaftaran->pasien->no_rekam_medik;
                }
                if(!empty($item->dokterbaru)) {
                    $namadokter = $item->dokterbaru->namaLengkap ?? '';
                }
                $msg .= ($idx+1).". ".$nama. " ( " . $no_rekam_medik ." ) ( " . $item->alasanperubahandokter ." ) ( " . $namadokter. ")\n";
            }
           
        }

        $data['msg'] = $msg;

        echo json_encode($data);
    }

    function actionApproveAlihLeader() {
        $ubahdokter_id = $_POST['ubahdokter_id'];
        $data['sukses'] = 0;

        $modUbahDokter = UbahdokterR::model()->findByPk($_POST['ubahdokter_id']);

        $dokterLama = PegawaiM::model()->findByPk($modUbahDokter->dokterlama_id);
        // sekarang yang menerima itu boleh siapa saja, soalnya pada daftar pasien pasien yang muncul sudah per spesialisnya
        $dokterBaru = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

        $modPendaftaran = PendaftaranT::model()->findByPk($modUbahDokter->pendaftaran_id);
        $modPemindahan = PemindahanpasienT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
        $update = UbahdokterR::model()->updateByPk($ubahdokter_id, [
            'is_approve' => true,
            'dokterbaru_id' => Yii::app()->user->getState('pegawai_id')
        ]);
        if($update) {
            $updatePendaftaran = PendaftaranT::model()->updateByPk($modUbahDokter->pendaftaran_id, [
                'pegawai_id' => Yii::app()->user->getState('pegawai_id')
            ]);
            if($modUbahDokter->alasanperubahandokter == 'Disposisi') {
                $simpantindakan = $this->simpanTindakan($modPendaftaran);
            }
            if($updatePendaftaran) {
                $judul = 'Persetujuan Disposisi / Alih Leader';
                $isi = 'Disposisi / Alih Leader Disetujui Dari ' . $dokterLama->namaLengkap . ' Ke ' . $dokterBaru->namaLengkap;
               
                if(!empty($modPemindahan)) {
                    CustomFunction::broadcastNotif($judul, $isi, array(
                        array(
                            'instalasi_id' => Yii::app()->user->getState('instalasi_id'), 
                            'ruangan_id' => $modPemindahan->ruangantujuan_id, 
                            'modul_id' => 6,  
                            // 'link_proses' => $link_rj
                        ),
                        array(
                            'instalasi_id' => Yii::app()->user->getState('instalasi_id'), 
                            'ruangan_id' => $modPemindahan->ruanganasal_id, 
                            'modul_id' => 6,  
                            // 'link_proses' => $link_rj
                        )
                    ));
                } else {
                    CustomFunction::broadcastNotif($judul, $isi, array(
                        array(
                            'instalasi_id' => Yii::app()->user->getState('instalasi_id'), 
                            'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 
                            'modul_id' => 6,  
                            // 'link_proses' => $link_rj
                        )
                    ));
                }
                $data['sukses'] = 1;
                $data['msg'] = 'Berhasil Disetujui';
            }
        } else {
            $data['msg'] = 'Gagal Disetujui';
        }

        echo json_encode($data);

    }

    function simpanTindakan($modPendaftaran, $modUbahDokter = null) {

        $getDaftarTindakanDisposisi = DaftartindakanM::model()->findAll('daftartindakan_disposisi is true and daftartindakan_aktif is true');

        $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");
        if(!empty($md_noawal)) {
            $noawal = intval($md_noawal->nopelayanan);
        } else {
            $noawal = 1;
        }

        // $valid = true;

        if(!empty($getDaftarTindakanDisposisi)) {
            foreach ($getDaftarTindakanDisposisi as $i => $val) {
                $modTindakan = new TindakanpelayananT();
                $modTindakan->pegawai_id = Yii::app()->user->getState('pegawai_id');
        
                $modTindakan->daftartindakan_id = $val->daftartindakan_id;
        
                
                $modTarif = TariftindakanM::model()->findByAttributes(['daftartindakan_id' => $val->daftartindakan_id, 'komponentarif_id' => 6]);
                if(!empty($modTarif)) {
                    $modTindakan->tariftindakan_id = $modTarif->tariftindakan_id;
                    $modTindakan->tarif_tindakan = $modTarif->harga_tariftindakan;
                    $modTindakan->tarif_satuan = $modTarif->harga_tariftindakan; //RND-7250
                }
        
        
                $modTindakan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                $modTindakan->pasien_id = $modPendaftaran->pasien_id;
        
                $modTindakan->carabayar_id = $modPendaftaran->carabayar_id;
                $modTindakan->penjamin_id = $modPendaftaran->penjamin_id;
                $modTindakan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        
                $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
                $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
        
                $modTindakan->discount_tindakan = 0;
        
                $modTindakan->subsidiasuransi_tindakan = 0;
                $modTindakan->subsidipemerintah_tindakan = 0;
                $modTindakan->subsisidirumahsakit_tindakan = 0;
                $modTindakan->iurbiaya_tindakan = 0; //$tindakan->iurbiaya;
                $modTindakan->tarifcyto_tindakan = 0;
        
        
                $modTindakan->ruangan_id =  Yii::app()->user->getState('ruangan_id'); // RND-6244
                $modTindakan->instalasi_id =Yii::app()->user->getState('instalasi_id');
                // $modTindakan->alatmedis_id = $this->cekAlatmedis($modTindakan->daftartindakan_id);
        
                if (empty($modTindakan->kelaspelayanan_id)) {
                    $modTindakan->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                }
        
                $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_VISITE; //'KALI';
        
                $modTindakan->nopelayanan = str_pad($noawal+1,3,"0",STR_PAD_LEFT);
                
                $valid = $modTindakan->validate();

                if($valid) {
                    $valid = $modTindakan->save();
                }
                
            }
        }

        return $valid;
    }

    function actionRejectedAlihLeader($ubahdokter_id) {
        $this->layout = '//layouts/iframe';
        $modUbahDokter = UbahdokterR::model()->findByPk($ubahdokter_id);
        $dokterLama = PegawaiM::model()->findByPk($modUbahDokter->dokterlama_id);
        $dokterBaru = PegawaiM::model()->findByPk($modUbahDokter->dokterbaru_id);

        if(isset($_POST['UbahdokterR'])) {
            $modUbahDokter->keterangan = $_POST['UbahdokterR']['keterangan'];
            $modUbahDokter->is_approve = false;
            $modUbahDokter->update_time = $_POST['UbahdokterR']['tglubahdokter'];


            if($modUbahDokter->save()) {
                $judul = 'Persetujuan Disposisi / Alih Leader';
                $isi = 'Disposisi / Alih Leader Ditolak Dari ' 
                        . $dokterLama->namaLengkap . ' Ke ' . $dokterBaru->namaLengkap 
                        . '<br> <b>Dengan Alasan </b> :' . $modUbahDokter->keterangan;
                CustomFunction::broadcastNotif($judul, $isi, array(
                    array(
                        'instalasi_id' => Yii::app()->user->getState('instalasi_id'), 
                        'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 
                        'modul_id' => 6,  
                        // 'link_proses' => $link_rj
                    )
                ));
                Yii::app()->user->setFlash('success', "Data berhasil update");
                $this->redirect(array('RejectedAlihLeader', 'ubahdokter_id' => $modUbahDokter->ubahdokter_id, 'sukses' => 1));
            }
        }

        $modUbahDokter->keterangan = '';
        $this->render('_formPenolakanDisposAlihLeader', [
            'modUbahDokter' => $modUbahDokter
        ]);
    }

    function actionCekJawabanKonsul() {

        $tgl_awal = MyFormatter::formatDateTimeForDb($_POST['tgl_awal']);
        $tgl_akhir = MyFormatter::formatDateTimeForDb($_POST['tgl_akhir']);

        $modKonsul = KonsulpoliT::model()->findAllByAttributes(['pegawai_id' => Yii::app()->user->getState('pegawai_id')],
        "(tglkonsulpoli::date BETWEEN '$tgl_awal' and '$tgl_akhir') and ruangan_id is null and jawaban_konsul is null");

        $total = count($modKonsul);
        $data['total'] = $total;
        $msg = '';
        if ($total > 0) {
            $msg = "Silahkan lakukan jawaban konsultasi pada pasien berikut : \n";
            foreach ($modKonsul as $idx => $item) {
                $nama = '';
                $no_rekam_medik = '';
                if(!empty($item->pendaftaran->pasien->nama_pasien)) {
                    $nama = $item->pendaftaran->pasien->nama_pasien;
                }
                if(!empty($item->pendaftaran->pasien->no_rekam_medik)) {
                    $no_rekam_medik = $item->pendaftaran->pasien->no_rekam_medik;
                }
                $msg .= ($idx+1).". ".$nama. "| RM" . $no_rekam_medik ." | Konsultasi Ke " . $item->pegawai->namaLengkap . "  \n";
            }
           
        }

        $data['msg'] = $msg;

        echo json_encode($data);
    }

    function actionSetDokterBaru() {
        $jeniskasuspenyakit_id = $_POST['jeniskasuspenyakit_id'];
        if($jeniskasuspenyakit_id == '') {
            $criteria = new CDbCriteria();
            $criteria->select = 'nama_pegawai, gelarbelakang_nama, gelardepan, pegawai_id';
            $criteria->addCondition("instalasi_id != 3 and jabatan_id != 23 and gelarbelakang_nama != 'Sp.EM' and pegawai_aktif is true");
            $criteria->group = 'nama_pegawai, gelarbelakang_nama, gelardepan, pegawai_id';
            $criteria->order = "nama_pegawai, gelardepan";
            $modPegawai = DokterV::model()->findAll($criteria);
        } else {
            $modPegawai = PegawaiM::model()->findAllByAttributes(['spesialis_id' => $jeniskasuspenyakit_id]);
        }

        $option = "<option value>-- Pilih --</option>";
        if(!empty($modPegawai)) {
            foreach ($modPegawai as $i => $value) {
                $option .= "<option value='" . $value->pegawai_id . "'>" . $value->namaLengkap . "</option>"; 
            }
        }

        echo json_encode(['option' => $option]);
    }

    function actionSetSpesialis() {
        $pegawai_id = $_GET['pegawai_id'];

        $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
        
        echo json_encode(['spesialis_id' => $modPegawai->spesialis_id]);

    }

    public function actionVerifikasiPJA() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        
        $pendaftaran_id = $_POST['verifikasi']['pendaftaran_id'];
        $tgl = MyFormatter::formatDateTimeForDB($_POST['verifikasi']['tanggal_approvaltindaklanjut'] ?? date('Y-m-d H:i:s'));
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $trans = Yii::app()->db->beginTransaction();
        $ok = true;

        try {

            // fungsi ini hanya untuk pasien yang baru tindak lanjut ke RI (belum sampai pasien admisi)
            if (!empty($pendaftaran->pasienadmisi_id)) {
                echo CJSON::encode(array(
                    'ok'=>1,
                    'msg'=>'Pasien sudah dilakukan admisi ke rawat inap.',
                ));
                Yii::app()->end();
            }

            $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
            ), array(
                'condition'=>'isapprovaltindaklanjut = false or isapprovaltindaklanjut is null'
            ));
            $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
            ), array(
                'condition'=>'isapprovaltindaklanjut = false or isapprovaltindaklanjut is null'
            ));

            foreach ($tindakan as $item) {
                $item->userapprovaltindaklanjut_id = $_POST['verifikasi']['userapprovaltindaklanjut_id'];
                $item->tanggal_approvaltindaklanjut = $tgl;
                $item->isapprovaltindaklanjut = true;
                $item->ruangan_id_approvaltindaklanjut = Yii::app()->user->getState('ruangan_id');


                // $item->userpembatalanapprovaltl_id = null;
                // $item->tanggalbatal_approvaltl = null;
                $item->ispembatalanapprovaltl = false;
                
                $ok = $ok && $item->save(false, array(
                    'userapprovaltindaklanjut_id', 'tanggal_approvaltindaklanjut', 'isapprovaltindaklanjut',
                    // 'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl',
                    'ispembatalanapprovaltl', 'ruangan_id_approvaltindaklanjut'
                ));

                
            }

            foreach ($oa as $item) {
                $item->userapprovaltindaklanjut_id = $_POST['verifikasi']['userapprovaltindaklanjut_id'];
                $item->tanggal_approvaltindaklanjut = $tgl;
                $item->isapprovaltindaklanjut = true;
                $item->ruangan_id_approvaltindaklanjut = Yii::app()->user->getState('ruangan_id');
                
                // $item->userpembatalanapprovaltl_id = null;
                // $item->tanggalbatal_approvaltl = null;
                $item->ispembatalanapprovaltl = false;
                
                $ok = $ok && $item->save(false, array(
                    'userapprovaltindaklanjut_id', 'tanggal_approvaltindaklanjut', 'isapprovaltindaklanjut',
                    // 'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl',
                    'ispembatalanapprovaltl', 'ruangan_id_approvaltindaklanjut'
                ));

                
            }

            $ok = $ok && $this->kirimNotifPJA($pendaftaran, $tgl, $_POST['verifikasi']['userapprovaltindaklanjut_id']);

            if ($ok) {
                $trans->commit();
                echo CJSON::encode(array(
                    'ok'=>1,
                    'msg'=>'Validasi PJA berhasil disimpan.',
                ));
                Yii::app()->end();
            } else {
                $trans->rollback();
                echo CJSON::encode(array(
                    'ok'=>0,
                    'msg'=>'Validasi PJA gagal disimpan.',
                ));
                Yii::app()->end();
            }
            
            // var_dump($_POST); die;


        } catch (CException $e) {
            $trans->rollback();
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'ERROR - '.$e->getMessage(),
            ));
            Yii::app()->end();
        }

        
    }

    public function actionBatalPJA() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $pendaftaran_id = $_POST['pendaftaran_id'];
        $tgl = date('Y-m-d H:i:s');
        $peg_id = Yii::app()->user->getState('pegawai_id');
        $trans = Yii::app()->db->beginTransaction();
        $ok = true;

        try {

            $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
                'ruangan_id_approvaltindaklanjut'=>Yii::app()->user->getState('ruangan_id'),
            ));
            $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
                'ruangan_id_approvaltindaklanjut'=>Yii::app()->user->getState('ruangan_id'),
            ));

            foreach ($tindakan as $item) {
                // $item->userapprovaltindaklanjut_id = null;
                // $item->tanggal_approvaltindaklanjut = null;
                $item->isapprovaltindaklanjut = false;

                $item->userpembatalanapprovaltl_id = $peg_id;
                $item->tanggalbatal_approvaltl = $tgl;
                $item->ispembatalanapprovaltl = true;
                $item->ruangan_id_approvaltindaklanjut = null;

                
                $ok = $ok && $item->save(true, array(
                    'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl', 'ispembatalanapprovaltl',
                    'isapprovaltindaklanjut', 'ruangan_id_approvaltindaklanjut'
                ));

                // var_dump($ok, $item->isapprovaltindaklanjut);
            }

            foreach ($oa as $item) {
                // $item->userapprovaltindaklanjut_id = null;
                // $item->tanggal_approvaltindaklanjut = null;
                $item->isapprovaltindaklanjut = false;


                $item->userpembatalanapprovaltl_id = $peg_id;
                $item->tanggalbatal_approvaltl = $tgl;
                $item->ispembatalanapprovaltl = true;
                $item->ruangan_id_approvaltindaklanjut = null;
                
                

                $ok = $ok && $item->save(false, array(
                    'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl', 'ispembatalanapprovaltl',
                    'isapprovaltindaklanjut', 'ruangan_id_approvaltindaklanjut'
                ));

                // var_dump($item->attributes);
            }

            // var_dump($ok); die;

            if ($ok) {
                $trans->commit();
                echo CJSON::encode(array(
                    'ok'=>1,
                    'msg'=>'Validasi PJA berhasil dibatalkan.',
                ));
                Yii::app()->end();
            } else {
                $trans->rollback();
                echo CJSON::encode(array(
                    'ok'=>0,
                    'msg'=>'Validasi PJA gagal dibatalkan.',
                ));
                Yii::app()->end();
            }

        } catch (CException $e) {
            $trans->rollback();
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'ERROR - '.$e->getMessage(),
            ));
            Yii::app()->end();
        }

    }

    function kirimNotifPJA($pendaftaran, $tgl, $approval_id) {
        $msg = "Telah divalidasi PJA atas nama {{nama_pasien}} dengan {{no_rekam_medik}} pada {{tanggal_validasi}}";

        $msg = str_replace("{{nama_pasien}}", $pendaftaran->pasien->nama_pasien, $msg);
        $msg = str_replace("{{no_rekam_medik}}", $pendaftaran->pasien->no_rekam_medik, $msg);
        $msg = str_replace("{{tanggal_validasi}}", MyFormatter::formatDateTimeForUser($tgl), $msg);

        $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_KEUANGAN);

        // var_dump($ruangan_keuangan->attributes); die;

        return CustomFunction::broadcastNotif("Validasi PJA", $msg, array(
            array('instalasi_id' => $ruangan_keuangan->instalasi_id, 'ruangan_id' => $ruangan_keuangan->ruangan_id, 'modul_id' =>$ruangan_keuangan->modul_id),
        ));

        // var_dump($msg); die;
    }

    function actionCekNoTriage() {
        $pendaftaran_id = $_GET['pendaftaran_id'];

        $cekTriage = RDNotriagePasienT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        
        if(!empty($cekTriage)) {
            $data['triage'] = 1;
        } else {
            $data['triage'] = 0;
        }

        echo json_encode($data);
    }
}