<?php
Yii::import('laboratorium.controllers.PencatatanHasilPemeriksaanController');

/**
 * controller utama untuk mengelola informasi daftar pasien laboratorium
 * 
 * @package application.modules.laboratorium
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class DaftarPasienController extends MyAuthController
{
  public $successPengambilanSample = false;
  public $successKirimSample = false;
  public $successSave = false;
  public $path_view = 'laboratorium.views.daftarPasien.';
  public $path_view_lab = 'laboratorium.views.pencatatanHasilPemeriksaan.';
  public $path_view_pendaftaran = "laboratorium.views.pendaftaranLaboratorium.";
  public $path_view_rj = "rawatJalan.views.tindakan.";

  /**
   * action ini digunakan untuk masuk ke halaman informasi daftar pasien laboratorium
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Daftar Pasien";
    // if(Yii::app()->user->getState('ruangan_id')==Params::RUANGAN_ID_LAB_KLINIK){
    $modPasienMasukPenunjang = new LBPasienMasukPenunjangV;
    // }else{
    //     $modPasienMasukPenunjang = new LBPasienmasukpenunjangT;
    // } 
    $format = new MyFormatter();
    $modPasienMasukPenunjang->statusperiksahasil = NULL;
    //		$modPasienMasukPenunjang->tgl_awal = date('Y-m-d', strtotime('-5 days'));
    $modPasienMasukPenunjang->tgl_awal = date('Y-m-d');
    $modPasienMasukPenunjang->tgl_akhir = date('Y-m-d');
    $modPasienMasukPenunjang->tgl_awall = date('Y-m-d');
    $modPasienMasukPenunjang->tgl_akhirl = date('Y-m-d');
    $modPasienMasukPenunjang->ceklis = false;
    if (isset($_REQUEST['LBPasienMasukPenunjangV'])) {
      $modPasienMasukPenunjang->attributes = $_REQUEST['LBPasienMasukPenunjangV'];
      $modPasienMasukPenunjang->ceklis = $_REQUEST['LBPasienMasukPenunjangV']['ceklis'];
      $modPasienMasukPenunjang->statusperiksahasil = $_REQUEST['LBPasienMasukPenunjangV']['statusperiksahasil'];
      $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBPasienMasukPenunjangV']['tgl_awal']);
      $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBPasienMasukPenunjangV']['tgl_akhir']);
      $modPasienMasukPenunjang->tgl_awall = $format->formatDateTimeForDb($_REQUEST['LBPasienMasukPenunjangV']['tgl_awall']);
      $modPasienMasukPenunjang->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['LBPasienMasukPenunjangV']['tgl_akhirl']);
      $modPasienMasukPenunjang->prefix_pendaftaran = $_REQUEST['LBPasienMasukPenunjangV']['prefix_pendaftaran'];
    }

    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'daftarpasien-v-grid') {
        $daftar = $modPasienMasukPenunjang->searchLab();
        if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LAB_ANATOMI) {
            $daftar = $modPasienMasukPenunjang->searchLabAnatomi();
        }
        $this->renderPartial('_tablePasien', ['daftar' => $daftar]);
        Yii::app()->end();
      }
    }
    $this->render('index', array('format' => $format, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang));
  }

  /**
   * update sample
   * @param type $pendaftaran_id
   * @param type $pasienmasukpenunjang_id
   */
  public function actionUpdateSample($pendaftaran_id, $pasienmasukpenunjang_id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_OPERATING)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));} 
    $format = new MyFormatter();
    $modPasienMasukPenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPengambilanSamples = LBPengambilanSampleT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPengambilanSample = new LBPengambilanSampleT;
    $modKirimSample = new LBKirimSampleLabT;

    $modPengambilanSample->tglpengambilansample = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd hh:mm:ss')
    );
    $modPengambilanSample->no_pengambilansample = "- Otomatis-";

    if (isset($_POST['LBPengambilanSampleT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        //var_dump($_POST['LBKirimSampleLabT']);die;
        foreach ($_POST['LBPengambilanSampleT'] as $i => $postPengambilanSample) {
          if (!empty($postPengambilanSample['pengambilansample_id'])) {
            $modPengambilanSample = LBPengambilanSampleT::model()->findByPk($postPengambilanSample['pengambilansample_id']);
            if (isset($_POST['LBKirimSampleLabT'][$i]['kirimsamplelab_id'])) {
              $modPengambilanSample = LBKirimSampleLabT::model()->findByPk($_POST['LBKirimSampleLabT'][$i]['kirimsamplelab_id']);
            } else {
              $modKirimSample = new LBKirimSampleLabT;
            }
          } else {
            $modPengambilanSample = new LBPengambilanSampleT;
            $modKirimSample = new LBKirimSampleLabT;
          }
          // echo "<pre>"; print_r($_POST);exit();
          if (isset($_POST['LBKirimSampleLabT'][$i]['isKirimSample'])) {
            if ($_POST['LBKirimSampleLabT'][$i]['isKirimSample'] == 1) { //Jika User MengisiKan Kirim Sample
              $modKirimSample->attributes = $_POST['LBKirimSampleLabT'][$i];
              $modKirimSample->nokirimsample = MyGenerator::noKirimsample();
              $modKirimSample->tglkirimsample = $format->formatDateTimeForDb($_POST['LBKirimSampleLabT'][$i]['tglkirimsample']);
              if ($modKirimSample->validate()) {
                $modKirimSample->save();
                $modPengambilanSample->kirimsamplelab_id = $modKirimSample->kirimsamplelab_id;
                $this->successKirimSample = TRUE;
              } else {
                $this->successKirimSample = FALSE;
              }
            } else {
              $this->successKirimSample = TRUE;
            }
          } else {
            $this->successKirimSample = TRUE;
          }

          $modPengambilanSample->attributes = $postPengambilanSample;
          $modPengambilanSample->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
          $modPengambilanSample->tglpengambilansample = $format->formatDateTimeForDb($postPengambilanSample['tglpengambilansample']);
          if ($modPengambilanSample->isNewRecord) {
            $modPengambilanSample->no_pengambilansample = MyGenerator::noPengambilanSample($modPengambilanSample->alatmedis_id);
            $modPengambilanSample->create_time = date("Y-m-d H:i:s");
            $modPengambilanSample->create_loginpemakai_id = Yii::app()->user->id;
            $modPengambilanSample->create_ruangan = Yii::app()->user->getState('ruangan_id');
          } else {
            $modPengambilanSample->update_time = date("Y-m-d H:i:s");
            $modPengambilanSample->update_loginpemakai_id = Yii::app()->user->id;
          }
          if ($modPengambilanSample->validate()) {
            $modPengambilanSample->save();
            LBKirimSampleLabT::model()->updateByPk($modKirimSample->kirimsamplelab_id, array('pengambilansample_id' => $modPengambilanSample->pengambilansample_id));
            $this->successPengambilanSample = TRUE;
            //Update status periksa
            $modHasilpemeriksaanLab = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));
            if(!empty($modHasilpemeriksaanLab)) {
              $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG; // SEDANG
              $modHasilpemeriksaanLab->update();
            }
          }
        }
        if ($this->successKirimSample && $this->successPengambilanSample) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
          //$this->redirect(array('index'));
          $this->redirect(array('updateSample', 'pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $this->render('updateSample', array(
      'modPengambilanSample' => $modPengambilanSample,
      'modPengambilanSamples' => $modPengambilanSamples,
      'modKirimSample' => $modKirimSample,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
  }

  public function actionKirimwadp2()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
      $modPendaftaran = LBPendaftaranT::model()->findByPk($pasienmasukpenunjang_id);
      $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

      $nama_modul = Yii::app()->controller->module->id;
      $nama_controller = Yii::app()->controller->id;
      $nama_action = Yii::app()->controller->action->id;
      $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
      $criteria = new CDbCriteria;
      $criteria->compare('modul_id', $modul_id);
      $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
      $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
      if (isset($_POST['tujuansms'])) {
        $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
      }
      $data['wadp'] = 1;
      $data['nama_pegawai'] = '';
      echo ($modPendaftaran->pegawai->nomobile_pegawai);
      die;
      if (isset($pasienMasukPenunjang)) {

        // SMS GATEWAY
        $modPasienPenunjang = $pasienMasukPenunjang->pasien;
        $modPendaftaran = LBPendaftaranT::model()->findByPk($modPasienPenunjang->pasien_id);

        $wadp = 1;
        $status = 'ok';


        if (!empty($modPendaftaran->pegawai->nomobile_pegawai)) {
          $wadp = 1;
          $status = 'ok';
          $this->kirimWhatsApp($pasienmasukpenunjang_id, $modPendaftaran);
          // $this->kirimWA($pasienmasukpenunjang_id, $modPasien);
          // $sms->kirim($modPendaftaran->pegawai->nomobile_pegawai, $isiPesan);
        } else {
          $status = 'gagal';
          $wadp = 0;
        }
        // END SMS GATEWAY
        $data['status'] = $status;
        $data['wadp'] = $wadp;
        $data['nama_pegawai'] = $modPendaftaran->pegawai->nama_pegawai;
      }

      $attributes = $pasienMasukPenunjang->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $pasienMasukPenunjang->$attribute;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionKirimwadp()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
      $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

      $nama_modul = Yii::app()->controller->module->id;
      $nama_controller = Yii::app()->controller->id;
      $nama_action = Yii::app()->controller->action->id;
      $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
      $criteria = new CDbCriteria;
      $criteria->compare('modul_id', $modul_id);
      $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
      $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
      if (isset($_POST['tujuansms'])) {
        $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
      }
      $data['wapasien'] = 1;
      $data['nama_pasien'] = '';

      if (isset($pasienMasukPenunjang)) {

        // SMS GATEWAY
        // $modPasienPenunjang2 = $pasienMasukPenunjang2->penanggungjawab;
        $modPasienPenunjang = $pasienMasukPenunjang->pasien;
        // $penanggungjawab = PenanggungjawabM::model()->findByPk($pasienMasukPenunjang2->penanggungjawab_id);
        $modPasien = LBPasienM::model()->findByPk($modPasienPenunjang->pasien_id);


        $pasienmasukpenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id); 

        // $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
        //   array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
        // );
        $modKirimUnitlain = PasienkirimkeunitlainT::model()->findByPk($pasienmasukpenunjang->pasienkirimkeunitlain_id);
        // $pegawai = PegawaiM::model()->findByPk($modKirimUnitlain->pegawai_id);
        // $pegawai = PegawaiM::model()->findByAttributes(array('nama_pegawai'=>$modKirimUnitlain->nama_pegawai));


        // $pasienmasukpenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id); 
        $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
          array('pasienkirimkeunitlain_id' => $modKirimUnitlain->pasienkirimkeunitlain_id)
        );
        $pegawai = PegawaiM::model()->findByPk($masukpenunjang->dokterasal_id);

        // $modKirimUnitlain = PasienkirimkeunitlainT::model()->findByPk($pasienmasukpenunjang->pasienkirimkeunitlain_id);
        // $pegawai = PegawaiM::model()->findByPk($modKirimUnitlain->pegawai_id);
        // $pegawai = PegawaiM::model()->findByAttributes(array(
        //   'nama_pegawai' => $pasienMasukPenunjang->nama_dokterasal,
        // ));
        // $pegawai = PegawaiM::model()->findByPk($modPasienPenunjang->pegawai_id);

        $wapasien = 1;
        $status = 'ok';


        if (!empty($pegawai->nomobile_pegawai)) {
          $wapasien = 1;
          $status = 'ok';
          $this->kirimPesanWAPJ($pasienmasukpenunjang_id, $modPasien, $pegawai);
          // $this->kirimWhatsApp($pasienmasukpenunjang_id, $modPasien);
          // $this->kirimWA($pasienmasukpenunjang_id, $modPasien);
          // $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
        } else {
          $wapasien = 0;
          $status = 'gagal';
        }
        // END SMS GATEWAY
        $data['status'] = $status;
        $data['wapasien'] = $wapasien;
        $data['nama_pasien'] = $modPasien->nama_pasien;
        $data['dpjp'] = $pegawai->nama_pegawai;
        $data['aris']= $pegawai->nomobile_pegawai;
      }

      $attributes = $pasienMasukPenunjang->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $pasienMasukPenunjang->$attribute;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionKirimwapas()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
      $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

      $nama_modul = Yii::app()->controller->module->id;
      $nama_controller = Yii::app()->controller->id;
      $nama_action = Yii::app()->controller->action->id;
      $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
      $criteria = new CDbCriteria;
      $criteria->compare('modul_id', $modul_id);
      $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
      $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
      if (isset($_POST['tujuansms'])) {
        $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
      }
      $data['wapasien'] = 1;
      $data['nama_pasien'] = '';

      if (isset($pasienMasukPenunjang)) {

        $modPasienPenunjang = $pasienMasukPenunjang->pasien;
        $modPasien = LBPasienM::model()->findByPk($modPasienPenunjang->pasien_id);

        $wapasien = 1;
        $status = 'ok';


        if (!empty($modPasien->no_mobile_pasien)) {
          $wapasien = 1;
          $status = 'ok';
          $this->kirimPesanWAPasien($pasienmasukpenunjang_id, $modPasien);
          // $this->kirimWhatsApp($pasienmasukpenunjang_id, $modPasien);
          // $this->kirimWA($pasienmasukpenunjang_id, $modPasien);
          // $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
        } else {
          $wapasien = 0;
          $status = 'gagal';
        }
        // END SMS GATEWAY
        $data['status'] = $status;
        $data['wapasien'] = $wapasien;
        $data['nama_pasien'] = $modPasien->nama_pasien;
        $data['aris']='ok '.$modPasien->no_mobile_pasien;
      }

      $attributes = $pasienMasukPenunjang->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $pasienMasukPenunjang->$attribute;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function loadModel($id)
  {
    $model =  LBPendaftaranT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function kirimWhatsApp($pasienmasukpenunjang_id, $modPasien, $caraPrint = null)
  {
    $modHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);

    $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
      array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
    );
    $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
    $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
      array(
        'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
      )
    );

    $data = array();


    foreach ($modDetailHasilPemeriksaans as $dt) {
      $jenispemeriksaanlab_id = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
      $kelompokdet = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
      $nilairujukan_id = $dt->pemeriksaandetail->nilairujukan_id;
      $dtperiksa = $dt->pemeriksaanlab_id . $dt->tindakanpelayanan_id;
      //	if (isset($data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"])){
      //	$total = $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"] = $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"] + 1;
      //	}else{
      //	$total = 1;
      //	}


      $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_nama"] = $dt->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
      $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_id"] = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->pemeriksaanlab->pemeriksaanlab_nama;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->pemeriksaanlab_id;
      /*$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"] = $total;			
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;			
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;			
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama.' '.(($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-')?$dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan:'');									*/
      //change
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;
      //$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"]['total'] = $kelompokdet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_min;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_max;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama . ' ' . (($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-') ? $dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan : '');
    }

    $format = new MyFormatter();
    $str = "Yth.\n";
    // $str .= "Selamat Datang di ((nama_rs))\n\n";
    $str .= $modPasien->nama_pasien . "/" . $modPasien->no_rekam_medik . ".\n\n"; //$modPasien->namadepan.
    // $str .= $modPasien->namadepan.$modPasien->nama_pasien." dengan No RM ".$modPasien->no_rekam_medik." ";
    // $str .= "terdaftar sebagai pasien pada tanggal ".MyFormatter::formatDateTimeForUser($pasienMasukPenunjang->tgl_pendaftaran);
    $str .= "Terima kasih telah menggunakan layanan kami untuk pemeriksaan kesehatan Anda.\n";
    // $str .= $pasienMasukPenunjang->ruangan->ruangan_nama.".\n\n";
    $str .= "Berikut ini kami sampaikan hasil pemeriksaan laboratorium Anda di Laboratorium ((nama_rs)).\n";
    $str .= "*) Silakan gunakan password tanggal, bulan, tahun lahir Anda (ddmmyyyy) untuk membuka hasil.\n";
    $str .= "**) Apabila membutuhkan hasil cetak, harap konfirmasi dengan menghubungi Customer Service kami.\n";
    $str .= "Semoga informasi ini dapat bermanfaat bagi Anda.\n\n";

    //$str .= "Kamar ".(empty($modPasienAdmisi->kamarruangan) ? "-" : $modPasienAdmisi->kamarruangan->kamarruangan_nokamar)." - ";
    //$str .= (empty($modPasienAdmisi->kamarruangan) ? "-" : $modPasienAdmisi->kamarruangan->kamarruangan_nobed)."\n\n";

    $str .= "Bila anda membutuhkan informasi lebih lanjut silahkan menghubungi Customer Service kami.\n";
    $str .= "Dengan senang hati kami akan melayani Anda.\n\n";

    $str .= "Hormat kami,\n((nama_rs))"; // - ((lokasi))

    $str = str_replace("((nama_rs))", ucwords(strtolower((Yii::app()->user->getState('nama_rumahsakit')))), $str);
    // $str = str_replace("((lokasi))", Yii::app()->user->getState('kabupaten_nama'), $str);


    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    $judulLaporan = str_replace(" ", "_", $judulLaporan);
    $judulLaporan = str_replace(".", "_", $judulLaporan);

    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');     // Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');          // Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    //$mpdf->useOddEven = 2;
    $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);

    $mpdf->WriteHTML($this->renderPartial($this->path_view . 'print_hasil', array(

      'format' => $format,
      'masukpenunjang' => $masukpenunjang,
      'pemeriksa' => $pemeriksa,
      'modHasilPeriksa' => $modHasilPeriksa,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'judulLaporan' => $judulLaporan, 
      'caraPrint' => $caraPrint,
      'data' => $data
    ), true));
    // $result = $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'S');
    $nama_file = $modPasien->nama_pasien . '_' . $judulLaporan . '_' . date('Y-m-d'); // H:i:s
    $nama_file = str_replace(" ", "_", $nama_file);
    $nama_file = str_replace(".", "_", $nama_file);
    // $nama_file = $judulLaporan.".pdf";

    // $result = $mpdf->Output(Params::pathHasilPeriksaLab().$nama_file. '.pdf', "F");
    $result = $mpdf->Output(Params::pathFileRMPasienDirectory() . $nama_file . '.pdf', "F");

    $wa = new WhatsApp();
    $this->broadcastNotifDaftarLab($masukpenunjang, $modPasien);

    // $res = $wa->kirimFile($modPasien->no_mobile_pasien, $str, Params::pathHasilPeriksaLab().$nama_file, "dokumen", Yii::app()->user->getState('nama_rumahsakit'), "pdf");

    $res = $wa->kirimFile($modPasien->no_mobile_pasien, $str, Params::pathFileRMPasienDirectory() . $nama_file, "dokumen", Yii::app()->user->getState('nama_rumahsakit'), "pdf");
    // echo ($res);die;
    // if($res){
    $res = $wa->kirimIndividu($modPasien->no_mobile_pasien, $str);
    // }
    // $res = $wa->kirimIndividu("085606615990", $str);

    // var_dump($res, $str, $modPasien->attributes);
    // die;
  }

  protected function broadcastNotifDaftarLab($masukpenunjang, $modPasien)
  {
    $judul = "Pesan Whatsapp Terkirim";
    $isi = $modPasien->nama_pasien . "/" . $modPasien->no_rekam_medik;

    $linkDaftarPasien = Yii::app()->createUrl('/laboratorium/daftarPasien/index', array(
      'LBPasienMasukPenunjangV[tgl_awal]' => date('d F Y', strtotime($masukpenunjang->tglmasukpenunjang)),
      'LBPasienMasukPenunjangV[tgl_akhir]' => date('d F Y', strtotime($masukpenunjang->tglmasukpenunjang)),
      'LBPasienMasukPenunjangV[no_pendaftaran]' => $masukpenunjang->no_pendaftaran,
      'LBPasienMasukPenunjangV[statusperiksahasil]' => '',
      'LBPasienMasukPenunjangV[tgl_awall]' => date('Y-m-d'),
      'LBPasienMasukPenunjangV[tgl_akhirl]' => date('Y-m-d'),
      'LBPasienMasukPenunjangV[prefix_pendaftaran]' => '',
      'LBPasienMasukPenunjangV[ceklis]' => 0,
    ));


    // var_dump($judul, $isi, $linkDaftarPasien); die;

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => Params::INSTALASI_ID_LAB, 'ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK, 'modul_id' => Params::MODUL_ID_LAB,  'link_proses' => $linkDaftarPasien), //, 'link_proses'=>$link_rj
    ));
  }

  public function loadDetailHasilPemeriksaans($modHasilPemeriksaan)
  {
    $criteria = new CDbCriteria();
    $criteria->join = "
                        JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
						JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id  
                        JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                        JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
    $criteria->order = "jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    //$criteria->order = "pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = LBDetailHasilPemeriksaanLabT::model()->findAll($criteria);
    return $modDetailHasilPemeriksaans;
  }

  public function kirimPesanWAPasien($pasienmasukpenunjang_id, $modPasien)
  {
    $modHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);

    $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
      array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
    );
    $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
    $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
      array(
        'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
      )
    );


    $file = DokfilermR::model()->findByAttributes(
      array(
        'pasien_id' => $modPasien->pasien_id
      )
    );

    
    if (empty($file)){
        echo 'Tidak memiliki file rekam medis';
        exit;
    }

    $files = Params::pathFileRMPasienDirectory().$modPasien->no_rekam_medik.'/'.$file->dokfilerm_filepath;                        


    $format = new MyFormatter();
    $str = "Assalamualaikum.Wr.Wb\n\n";
    $str .= "Yth.\n";
    $str .= $modPasien->namadepan.' '. $modPasien->nama_pasien . "/" . $modPasien->no_rekam_medik . ".\n\n"; //$modPasien->namadepan.
    $str .= "Terima kasih telah menggunakan layanan kami untuk pemeriksaan kesehatan Anda.\n";
    $str .= "Berikut ini kami sampaikan hasil pemeriksaan laboratorium Anda di Laboratorium Rumah Sakit Sari Asih.\n";
    // $str .= "Berikut ini kami sampaikan hasil pemeriksaan laboratorium Anda di Laboratorium ((nama_rs)).\n";
    $str .= "*) Silakan gunakan password tanggal, bulan, tahun lahir Anda (ddmmyyyy) untuk membuka hasil.\n";
    $str .= "**) Apabila membutuhkan hasil cetak, harap konfirmasi dengan menghubungi Customer Service kami.\n";
    $str .= "Semoga informasi ini dapat bermanfaat bagi Anda.\n\n";

    $str .= "Bila anda membutuhkan informasi lebih lanjut silahkan menghubungi Customer Service kami.\n";
    $str .= "Dengan senang hati kami akan melayani Anda.\n\n";

    $str .= "Hormat kami,\nRumah Sakit Sari Asih"; // - ((lokasi))
    // $str .= "Hormat kami,\n((nama_rs))"; // - ((lokasi))

    $str = str_replace("((nama_rs))", ucwords(strtolower((Yii::app()->user->getState('nama_rumahsakit')))), $str);

    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    $judulLaporan = str_replace(" ", "_", $judulLaporan);
    $judulLaporan = str_replace(".", "_", $judulLaporan);


    $nama_file = $modPasien->nama_pasien . '_' . $judulLaporan . '_' . date('Y-m-d'); // H:i:s
    $nama_file = str_replace(" ", "_", $nama_file);
    $nama_file = str_replace(".", "_", $nama_file);


    $wa = new WhatsApp();
    $this->broadcastNotifDaftarLab($masukpenunjang, $modPasien);

    // $res = $wa->kirimIndividu($modPasien->no_mobile_pasien, $str);
    // $wa->kirimIndividu('082199275053',$str);
    // $res = $wa->kirimFile($modPasien->no_mobile_pasien, $str, Params::pathFileRMPasienDirectory() . $nama_file, "dokumen", Yii::app()->user->getState('nama_rumahsakit'), "pdf");
    // $res = $wa->kirimFile($modPasien->no_mobile_pasien, $str, Params::pathFileRMPasienDirectory() . $nama_file, "dokumen", Yii::app()->user->getState('nama_rumahsakit'), "pdf");
    $res = $wa->kirimFile($modPasien->no_mobile_pasien, $str, $files, "dokumen", Yii::app()->user->getState('nama_rumahsakit'), "pdf");
  }
  public function kirimPesanWAPJ($pasienmasukpenunjang_id, $modPasien, $pegawai)
  {
    $modHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);
    
    $pasienmasukpenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id); 

    // $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
    //   array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
    // );
    $modKirimUnitlain = PasienkirimkeunitlainT::model()->findByPk($pasienmasukpenunjang->pasienkirimkeunitlain_id);
    $pegawai = PegawaiM::model()->findByPk($modKirimUnitlain->pegawai_id);
    $ruanganAsal = RuanganM::model()->findByPk($pasienmasukpenunjang->ruanganasal_id);

    $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
      array(
        'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
      )
    );


    $file = DokfilermR::model()->findByAttributes(
      array(
        'pasien_id' => $modPasien->pasien_id
      )
    );

    
    if (empty($file)){
        echo 'Tidak memiliki file rekam medis';
        exit;
    }

    $files = Params::pathFileRMPasienDirectory().$modPasien->no_rekam_medik.'/'.$file->dokfilerm_filepath;                        


    $format = new MyFormatter();
    $str = "Assalamualaikum.Wr.Wb\n\n";
    $str .= "Yth.\n";
    // $str .= $files."Yth.\n";
    $str .= empty($pegawai) ? "-" : $pegawai->gelardepan. ' ' .$pegawai->nama_pegawai . ".\n\n"; //$modPasien->namadepan.
    $str .= "Kami dari Rumah Sakit Sari Asih Ciputat.\n";
    // $str .= "Kami dari ((nama_rs)).\n";
    $str .= "Berikut kami lampirkan file hasil pemeriksaan laboratorium, pasien ".$modPasien->namadepan.''. $modPasien->nama_pasien .' '. $ruanganAsal->ruangan_nama.".\n\n";
    // $str .= "Dengan ini kami sampaikan hasil pemeriksaan laboratorium Darah Lengkap (nama pemeriksaan) pasien $modPasien->nama_pasien Rawat Inap/Rawat Jalan Poliklinik Penyakit Dalam (poli pasien).\n";
    // $str .= "Status hasil pemeriksaan kritis (hasil lab) dengan nilai (nilai pemeriksaan).\n\n";
    
    $str .= "Terimakasih\n";
    $str .= "Rumah Sakit Sari Asih Ciputat - KOTA TANGERANG SELATAN\n\n";
    
    $str .= "Sariasihgroup\n";
    $str .= "(https://sariasihgroup.com/salive/antrian)Sari Asih Live\n";
    $str .= "Sari Asih Live Aplication By Sari Asih\n\n";

    $str .= "Sariasihgroup (https://sariasihgroup.com/salive/antrian)\n";
    $str .= "Sari Asih Live\n";
    $str .= "Sari Asih Live Aplication By Sari Asih\n\n";
    
    $str .= "Hormat kami,\n((nama_rs))"; // - ((lokasi))

    $str = str_replace("((nama_rs))", ucwords(strtolower((Yii::app()->user->getState('nama_rumahsakit')))), $str);

    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    $judulLaporan = str_replace(" ", "_", $judulLaporan);
    $judulLaporan = str_replace(".", "_", $judulLaporan);


    $nama_file = $modPasien->nama_pasien . '_' . $judulLaporan . '_' . date('Y-m-d'); // H:i:s
    $nama_file = str_replace(" ", "_", $nama_file);
    $nama_file = str_replace(".", "_", $nama_file);

    $wa = new WhatsApp();
    $this->broadcastNotifDaftarLab($pasienmasukpenunjang, $modPasien);
    
    // $res = $wa->kirimIndividu($pegawai->nomobile_pegawai, $str);
    // $wa->kirimIndividu('082199275053',$str);
    // $res = $wa->kirimFile($pegawai->nomobile_pegawai, $str, Params::pathFileRMPasienDirectory() . $nama_file, "dokumen", Yii::app()->user->getState('nama_rumahsakit'), "pdf");
    $res = $wa->kirimFile($pegawai->nomobile_pegawai, $str, $files, "dokumen", Yii::app()->user->getState('nama_rumahsakit'), "pdf");
  }
  // public function actionKirimWAFilePwdNotifPasien()
  // {
  //   if (Yii::app()->request->isAjaxRequest) {
  //     $format = new MyFormatter();
  //     $data = array();
  //     $data['pesan'] = "Whatsapp Gagal Terkirim Ke Pasien";
  //     $data['status'] = false;

  //     $modHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
  //     $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);
  
  //     $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
  //       array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
  //     );
  //     $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
  //     $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
  //       array(
  //         'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
  //       )
  //     );
  //     // $pendaftaran_id = ($_POST['pendaftaran_id']);
  //     // $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);

  //     $modKirimUnitlain = PasienkirimkeunitlainT::model()->findByPk($pasienmasukpenunjang_id);
  //     $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
  //     $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

  //     if (!empty($modKirimUnitlain) && !empty($modPendaftaran) && !empty($modPasien->no_mobile_pasien)) {
  //       $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
  //       $nourut = null;
  //       $intalasi_nama = null;
  //       $ruangan_nama = null;
  //       $penjamin_id = $modPendaftaran->penjamin_id;

  //       $dokter = $modKirimUnitlain->pegawai->namaLengkap;

  //       if (!empty($modPenunjang)) {
  //         $nourut = $modPenunjang->ruangan->ruangan_singkatan . "-" . $modPenunjang->no_urutperiksa;
  //       }
  //       $ruanganAsal = RuanganM::model()->findByPk($modKirimUnitlain->create_ruangan);

  //       $intalasi_nama = $ruanganAsal->instalasi->instalasi_nama;
  //       $ruangan_nama = $ruanganAsal->ruangan_nama;

  //       if ($ruanganAsal->instalasi_id != Params::INSTALASI_ID_RJ) {
  //         $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
  //         $penjamin_id = (!empty($modAdmisi) ? $modAdmisi->penjamin_id : $modPendaftaran->penjamin_id);
  //       }
  //       $modPenjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
  //       $penjamin_nama = $modPenjamin->penjamin_nama;
  //       $carabayar_nama = $modPenjamin->carabayar->carabayar_nama;
  //       $waktupemeriksaan = "";
  //       $jenispemeriksaan = "";

  //       $modPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $modKirimUnitlain->pasienkirimkeunitlain_id));

  //       if (!empty($modPermintaan)) {
  //         $jenisperiksa = array();
  //         foreach ($modPermintaan as $itemtindakan) {
  //           if (empty($itemtindakan->pemeriksaanrad_id)) {
  //             continue;
  //           }
  //           $modPemeriksaan = PemeriksaanradM::model()->findByPk($itemtindakan->pemeriksaanrad_id);

  //           $jenisperiksa[$modPemeriksaan->jenispemeriksaanrad_id]['jenispemeriksaan'] = $modPemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
  //           $jenisperiksa[$modPemeriksaan->jenispemeriksaanrad_id]['waktupemeriksaan'] = (!empty($itemtindakan->tglpermintaankepenunjang) ? MyFormatter::formatDateTimeForUser($itemtindakan->tglpermintaankepenunjang) : "");
  //         }
  //       }

  //       $modProfil = ProfilrumahsakitM::model()->find();
  //       $str = "Yth.\n";
  //       // $str .= "Selamat Datang di ((nama_rs))\n\n";
  //       $str .= $modPasien->nama_pasien . "/" . $modPasien->no_rekam_medik . ".\n\n"; //$modPasien->namadepan.
  //       // $str .= $modPasien->namadepan.$modPasien->nama_pasien." dengan No RM ".$modPasien->no_rekam_medik." ";
  //       // $str .= "terdaftar sebagai pasien pada tanggal ".MyFormatter::formatDateTimeForUser($pasienMasukPenunjang->tgl_pendaftaran);
  //       $str .= "Terima kasih telah menggunakan layanan kami untuk pemeriksaan kesehatan Anda.\n";
  //       // $str .= $pasienMasukPenunjang->ruangan->ruangan_nama.".\n\n";
  //       $str .= "Berikut ini kami sampaikan hasil pemeriksaan laboratorium Anda di Laboratorium ((nama_rs)).\n";
  //       $str .= "*) Silakan gunakan password tanggal, bulan, tahun lahir Anda (ddmmyyyy) untuk membuka hasil.\n";
  //       $str .= "**) Apabila membutuhkan hasil cetak, harap konfirmasi dengan menghubungi Customer Service kami.\n";
  //       $str .= "Semoga informasi ini dapat bermanfaat bagi Anda.\n\n";

  //       //$str .= "Kamar ".(empty($modPasienAdmisi->kamarruangan) ? "-" : $modPasienAdmisi->kamarruangan->kamarruangan_nokamar)." - ";
  //       //$str .= (empty($modPasienAdmisi->kamarruangan) ? "-" : $modPasienAdmisi->kamarruangan->kamarruangan_nobed)."\n\n";

  //       $str .= "Bila anda membutuhkan informasi lebih lanjut silahkan menghubungi Customer Service kami.\n";
  //       $str .= "Dengan senang hati kami akan melayani Anda.\n\n";

  //       $str .= "Hormat kami,\n((nama_rs))"; // - ((lokasi))

  //       $str = str_replace("((nama_rs))", ucwords(strtolower((Yii::app()->user->getState('nama_rumahsakit')))), $str);
        
  //       $wa = new WhatsApp();

  //       $this->broadcastNotifDaftarLab($masukpenunjang, $modPasien);

  //       // $res = $wa->kirimFile($modPasien->no_mobile_pasien, $str, Params::pathHasilPeriksaLab().$nama_file, "dokumen", Yii::app()->user->getState('nama_rumahsakit'), "pdf");
    
  //       $res = $wa->kirimFile($modPasien->no_mobile_pasien, $str, Params::pathUploads() . $nama_file, "dokumen", Yii::app()->user->getState('nama_rumahsakit'), "pdf");
  //       // echo ($res);die;
  //       // if($res){
  //       $res = $wa->kirimIndividu($modPasien->no_mobile_pasien, $str);
  //       // }

  //       if (!empty($res)) {
  //         $data['pesan'] = "Whatsapp Berhasil Terkirim Ke Pasien";
  //         $data['status'] = true;

  //         PasienkirimkeunitlainT::model()->updateByPk($modKirimUnitlain->pasienkirimkeunitlain_id, array('iskirimwa_pasien' => true));
  //       }
  //     }


  //     echo CJSON::encode($data);
  //     Yii::app()->end();
  //   } else
  //     throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  // }

  /**
   * load data hasil pemeriksaan
   * @param type $pendaftaran_id
   * @param type $pasien_id
   * @param type $pasienmasukpenunjang_id
   */
  public function actionHasilPemeriksaan($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id)
  {
    $modPasienMasukPenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPasienKirimKeUnitLain = LBPasienKirimKeUnitLainT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPendaftaran = LBPendaftaranMp::model()->findByPk($pendaftaran_id);
    $modRujukanT = LBRujukanT::model()->findByPk($modPendaftaran->rujukan_id);
    $format = new MyFormatter();
    $modRujukanT = array();
    $kelompokUmur = (strtolower($modPasienMasukPenunjang->golonganumur_nama)) == 'bayi' ? 'dewasa' : 'dewasa';
    $modHasilpemeriksaanLab = LBHasilPemeriksaanLabT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
      'pasien_id' => $pasien_id
    ));
    $criteria = new CDbCriteria();
    $criteria->together = true;
    $criteria->with = array('pemeriksaanlab', 'pemeriksaandetail', 'pemeriksaandetail.nilairujukan');
    if (!empty($modHasilpemeriksaanLab->hasilpemeriksaanlab_id)) {
      $criteria->addCondition('hasilpemeriksaanlab_id = ' . $modHasilpemeriksaanLab->hasilpemeriksaanlab_id);
    }
    $criteria->compare('LOWER(nilairujukan_jeniskelamin)', strtolower(trim($modPasienMasukPenunjang->jeniskelamin)));
    $criteria->compare('LOWER(kelompokumur)', strtolower($kelompokUmur));
    $criteria->order = "pemeriksaanlab_urutan, pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaanLab = LBDetailHasilPemeriksaanLabT::model()->findAll($criteria);
    //jika belum ada hasil/pemeriksaan, maka input/pilih dulu pemeriksaannya
    if (empty($modDetailHasilPemeriksaanLab)) {
      $this->redirect($this->createUrl('pemeriksaanPasienLaboratorium/index', array(
        'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
        'modul_id' => Yii::app()->session['modul_id']
      )));
    }
    $modNilaiRujukan = LBNilaiRujukanM::model()->findByAttributes(array(
      'kelompokumur' => strtoupper($modHasilpemeriksaanLab->hasil_kelompokumur),
      'nilairujukan_jeniskelamin' => strtoupper($modHasilpemeriksaanLab->hasil_jeniskelamin)
    ));
    $modHasilPemeriksaanPA = LBHasilPemeriksaanPAT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
      'pasien_id' => $pasien_id
    ));
    $modHasilpemeriksaanLab->tglpengambilanhasil = $format->formatDateTimeForUser($modHasilpemeriksaanLab->tglpengambilanhasil);


    if (isset($_POST['LBDetailHasilPemeriksaanLabT']) || isset($_POST['LBHasilPemeriksaanPAT'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (isset($_POST['LBRujukanT'])) { // Update Dokter Perujuk pada RujukanT
          $modRujukanDari = RujukandariM::model()->findByPk($_POST['LBRujukanT']['rujukandari_id']);
          $modRujukanT->nama_perujuk = $modRujukanDari->namaperujuk;
          $modRujukanT->update();
        }
        if (isset($_POST['LBDetailHasilPemeriksaanLabT'])) {

          $jumlahDetalHasilPemesiksaan = count((array)$_POST['LBDetailHasilPemeriksaanLabT']['detailhasilpemeriksaanlab_id']);

          for ($j = 0; $j < $jumlahDetalHasilPemesiksaan; $j++) :
            $idHasilPemeriksaan = $_POST['LBDetailHasilPemeriksaanLabT']['detailhasilpemeriksaanlab_id'][$j];
            $modDetailHasilPemeriksaanLab = LBDetailHasilPemeriksaanLabT::model()->findByPk($idHasilPemeriksaan);
            $modDetailHasilPemeriksaanLab->hasilpemeriksaan = $_POST['LBDetailHasilPemeriksaanLabT']['hasilpemeriksaan'][$j];
            $modDetailHasilPemeriksaanLab->nilairujukan = $_POST['LBDetailHasilPemeriksaanLabT']['nilairujukan'][$j];
            $modDetailHasilPemeriksaanLab->hasilpemeriksaan_satuan = $_POST['LBDetailHasilPemeriksaanLabT']['hasilpemeriksaan_satuan'][$j];
            $modDetailHasilPemeriksaanLab->hasilpemeriksaan_metode = $_POST['LBDetailHasilPemeriksaanLabT']['hasilpemeriksaan_metode'][$j];
            $modDetailHasilPemeriksaanLab->update();
          endfor;

          $modHasilpemeriksaanLab = LBHasilPemeriksaanLabT::model()->findByPk($_POST['LBHasilPemeriksaanLabT']['hasilpemeriksaanlab_id']);
          $modHasilpemeriksaanLab->catatanlabklinik = $_POST['LBHasilPemeriksaanLabT']['catatanlabklinik'];
          $modHasilpemeriksaanLab->tglpengambilanhasil = $format->formatDateTimeForDb($_POST['LBHasilPemeriksaanLabT']['tglpengambilanhasil']);
          $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG;
          $modHasilpemeriksaanLab->printhasillab = false;
          $modHasilpemeriksaanLab->update();
        }

        if (isset($_POST['LBHasilPemeriksaanPAT'])) {
          $this->saveHasilPemeriksaan($_POST['LBHasilPemeriksaanPAT']);
        }
        //Update dokter pemeriksa (pegawai_id) pada pasien masuk penunjang
        LBPasienmasukpenunjangT::model()->updateByPk($pasienmasukpenunjang_id, array('pegawai_id' => $_POST['LBPasienmasukpenunjangT']['pegawai_id']));
        $transaction->commit();
        Yii::app()->user->setFlash('success', "Data Hasil Pemeriksaan berhasil Disimpan");
        //                    $this->redirect($this->createUrl("index")); 
        $this->redirect($this->createUrl("/laboratorium/daftarPasien/Details", array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $pasien_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'caraPrint' => 'PRINT')));
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $this->render('hasilPemeriksaan', array(
      'modHasilpemeriksaanLab' => $modHasilpemeriksaanLab,
      'modNilaiRujukan' => $modNilaiRujukan,
      'modDetailHasilPemeriksaanLab' => $modDetailHasilPemeriksaanLab,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modHasilPemeriksaanPA' => $modHasilPemeriksaanPA,
      'modPasienKirimKeUnitLain' => $modPasienKirimKeUnitLain,
      //'modRincian'=>$modRincian,
      'modRujukanT' => $modRujukanT,
    ));
  }

  /**
   * mengubah status pemeriksaan menjadi SUDAH
   * @param type $pasienmasukpenunjang_id
   * @param type $pendaftaran_id
   */
  public function actionApprovePemeriksaan($pasienmasukpenunjang_id, $pendaftaran_id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_OPERATING)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));} 
    $modHasilpemeriksaanLab = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));
    $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH; // SUDAH

    if ($modHasilpemeriksaanLab->update())
      Yii::app()->user->setFlash('success', "Pemeriksaan Berhasil Disetujui!");
    else
      Yii::app()->user->setFlash('error', "Pemeriksaan Gagal Disetujui!");
    $this->redirect(array('index'));
  }

  /**
   * mengubah status pemeriksaan menjadi SUDAH via ajax 
   */
  public function actionApprovePemeriksaanAjax()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $status = 'ok';
      try {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $idPenunjang = $_POST['idPenunjang'];
        $modHasilpemeriksaanLab = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $idPenunjang, 'pendaftaran_id' => $pendaftaran_id));
        $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH; // SUDAH

        if ($modHasilpemeriksaanLab->update()) {

          $up = PasienmasukpenunjangT::model()->findByPk($idPenunjang);
          $up->statusperiksa = Params::STATUSPERIKSA_SUDAH_DIPERIKSA;
          $up->update_time = date('Y-m-d H:i:s');
          $up->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $up->save();

          $transaction->commit();
          $status = 'ok';
        } else {
          $transaction->rollback();
          $status = 'gagal';
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'gagal';
        $transaction->rollback();
      }
      $data['status'] = $status;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * fungsi untuk mencatatkan data hasil pemeriksaan, ke database
   * @param type $arrHasil
   */
  protected function saveHasilPemeriksaan($arrHasil)
  {
    foreach ($arrHasil as $i => $hasil) {
      LBHasilPemeriksaanPAT::model()->updateByPk($hasil['hasilpemeriksaanpa_id'], array(
        'makroskopis' => $hasil['makroskopis'],
        'mikroskopis' => $hasil['mikroskopis'],
        'catatanpa' => $hasil['catatanpa'],
        'saranpa' => $hasil['saranpa']
      ));
    }
  }

  /**
   * membatalkan pemeriksaan yang sudah di verifikasi
   * @param type $pasienmasukpenunjang_id
   * @param type $pendaftaran_id
   */
  public function actionCancelPemeriksaan($pasienmasukpenunjang_id, $pendaftaran_id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_OPERATING)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));} 
    $modHasilpemeriksaanLab = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));
    $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG; // SEDANG
    if ($modHasilpemeriksaanLab->update())
      Yii::app()->user->setFlash('success', "Pemeriksaan Berhasil Dibatalkan !");
    else
      Yii::app()->user->setFlash('error', "Pemeriksaan Gagal Di Dicktion !");
    $this->redirect(array('index'));
  }

  /**
   * membatalkan hasil verifikasi
   */
  public function actionCancelPemeriksaanAjax()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $status = 'ok';
      try {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $idPenunjang = $_POST['idPenunjang'];
        $modHasilpemeriksaanLab = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $idPenunjang, 'pendaftaran_id' => $pendaftaran_id));
        $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG; // SEDANG
        if ($modHasilpemeriksaanLab->update()) {
          $up = PasienmasukpenunjangT::model()->findByPk($idPenunjang);
          $up->statusperiksa = Params::STATUSPERIKSA_SEDANG_PERIKSA;
          $up->update_time = date('Y-m-d H:i:s');
          $up->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $up->save();

          $transaction->commit();
          $status = 'ok';
        } else {
          $transaction->rollback();
          $status = 'gagal';
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'gagal';
        $transaction->rollback();
      }
      $data['status'] = $status;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * mengenerate detail hasil pemeriksaan
   * @param type $pendaftaran_id
   * @param type $pasien_id
   * @param type $pasienmasukpenunjang_id
   */
  public function actionDetails($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';

    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LAB_KLINIK) {


      //            $cek_penunjang = LBPasienMasukPenunjangV::model()->findAllByAttributes(
      //                array('pendaftaran_id'=>$pendaftaran_id)
      //            );
      //            
      //            $data_rad = array();
      //            if(count((array)$cek_penunjang) > 1)
      //            {
      //                 // echo "aa";
      //                 // exit;
      //                $masukpenunjangRad=LBPasienMasukPenunjangV::model()->findByAttributes(
      //                    array(
      //                        'pendaftaran_id'=>$pendaftaran_id,                        
      //                        'ruangan_id'=>Params::RUANGAN_ID_RAD,
      //                    )
      //                );
      //                $modHasilPeriksaRad = HasilpemeriksaanradV::model()->findAllByAttributes(
      //                    array(
      //                        'pasienmasukpenunjang_id'=>$masukpenunjangRad['pasienmasukpenunjang_id']
      //                    ),
      //                    array(
      //                        'order'=>'pemeriksaanrad_urutan'
      //                    )
      //                );
      //                
      //                foreach($modHasilPeriksaRad as $i=>$val)
      //                {
      //                    $data_rad[] = array(
      //                        'pemeriksaan'=>$val['pemeriksaanrad_nama'],
      //                       // 'hasil'=>'Hasil Pemeriksaan ' . $val['pemeriksaanrad_nama'] . ' terlampir',
      //                        'hasil'=>'Hasil terlampir'
      //                    );
      //                }
      //                    
      //            }

      $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
        array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
      );
      $unitLain = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

      if (isset($unitLain) > 0) {
        $perujuk = PegawaiM::model()->findByAttributes(array('pegawai_id' => $unitLain->pegawai_id));
      } else {
        $perujuk = PegawaiM::model()->findByAttributes(array('pegawai_id' => $masukpenunjang->pegawai_id));
      }
      $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);

      $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );

      $kelompokUmur = (strtolower($masukpenunjang->golonganumur_nama)) == 'bayi' ? 'dewasa' : 'dewasa';
      $query = "
                SELECT * FROM detailhasilpemeriksaanlab_t 
                JOIN pemeriksaanlab_m ON detailhasilpemeriksaanlab_t.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id 
                JOIN pemeriksaanlabdet_m ON detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id = pemeriksaanlabdet_m.pemeriksaanlabdet_id 
                JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id
                WHERE detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = '" . $modHasilPeriksa->hasilpemeriksaanlab_id . "'
                    AND LOWER(nilairujukan_m.nilairujukan_jeniskelamin) = '" . strtolower(trim($masukpenunjang->jeniskelamin)) . "'
                    AND LOWER(nilairujukan_m.kelompokumur) = '" . $kelompokUmur . "'
                ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan,pemeriksaanlab_urutan,pemeriksaanlabdet_nourut
            ";
      $detailHasil = Yii::app()->db->createCommand($query)->queryAll();
      $data = array();
      $kelompokDet = null;
      $idx = 0;
      $temp = '';
      $goldarah = 0;
      foreach ($detailHasil as $i => $detail) {
        $id_jenisPeriksa = $detail['jenispemeriksaanlab_id'];
        $jenisPeriksa = $detail['jenispemeriksaanlab_nama'];
        $kelompokDet = $detail['kelompokdet'];
        if ($detail['pemeriksaanlab_id'] == '99') {
          $goldarah++;
        }
        if ($id_jenisPeriksa == '72') {
          $query = "
                        SELECT jenispemeriksaanlab_m.* FROM pemeriksaanlabdet_m
                        JOIN pemeriksaanlab_m ON pemeriksaanlabdet_m.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id
                        JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                        WHERE nilairujukan_id = " . $detail['nilairujukan_id'] . " AND pemeriksaanlab_m.jenispemeriksaanlab_id <> " . $id_jenisPeriksa . "
                    ";
          $rec = Yii::app()->db->createCommand($query)->queryRow();
          $id_jenisPeriksa = $rec['jenispemeriksaanlab_id'];
          $jenisPeriksa = $rec['jenispemeriksaanlab_nama'];
        }

        if ($temp != $kelompokDet) {
          $idx = 0;
        }

        $data[$id_jenisPeriksa]['tittle'] = $jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['id'] = $id_jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['nama'] = $jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['kelompok'] = $kelompokDet;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['kelompok'] = $kelompokDet;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan_det'] = $detail['pemeriksaanlab_nama'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan'] = $detail['namapemeriksaandet'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['id_pemeriksaan'] = $detail['nilairujukan_id'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['normal'] = $detail['nilairujukan_nama'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['metode'] = $detail['nilairujukan_metode'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['hasil'] = $detail['hasilpemeriksaan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['nilairujukan'] = $detail['nilairujukan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['satuan'] = $detail['hasilpemeriksaan_satuan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['keterangan'] = $detail['nilairujukan_keterangan'];
        $temp = $kelompokDet;
        $idx++;
      }
    } else {
      $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
        array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
      );
      $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
      $modHasilPeriksa = HasilpemeriksaanpaT::model()->findByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );
      $unitLain = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $perujuk = PegawaiM::model()->findByAttributes(array('pegawai_id' => $unitLain->pegawai_id));
      $data = HasilpemeriksaanpaT::model()->findAllByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );
    }
    $this->render(
      'details',
      array(
        'modHasilPeriksa' => $modHasilPeriksa,
        'masukpenunjang' => $masukpenunjang,
        'pemeriksa' => $pemeriksa,
        'unitLain' => $unitLain,
        'perujuk' => $perujuk,
        'data' => $data,
        //               'data_rad'=>$data_rad,
        'goldarah' => $goldarah
      )
    );
  }

  /**
   * mencetak hasil pemeriksaan ke dalam bentuk printout
   * @param type $pasienmasukpenunjang_id
   * @param type $pendaftaran_id
   * @param type $caraPrint
   */
  public function actionPrintHasil($pasienmasukpenunjang_id, $pendaftaran_id, $caraPrint)
  {
    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LAB_KLINIK) {
      $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
        array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
      );
      $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);

      $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );
      $kelompokUmur = (strtolower($masukpenunjang->golonganumur_nama)) == 'bayi' ? 'dewasa' : 'dewasa';
      $query = "
                SELECT * FROM detailhasilpemeriksaanlab_t 
                JOIN pemeriksaanlab_m ON detailhasilpemeriksaanlab_t.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id 
                JOIN pemeriksaanlabdet_m ON detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id = pemeriksaanlabdet_m.pemeriksaanlabdet_id 
                JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id
                WHERE detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = '" . $modHasilPeriksa->hasilpemeriksaanlab_id . "'
                    AND LOWER(nilairujukan_m.nilairujukan_jeniskelamin) = '" . strtolower(trim($masukpenunjang->jeniskelamin)) . "'
                    AND LOWER(nilairujukan_m.kelompokumur) = '" . $kelompokUmur . "'
                ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan, pemeriksaanlab_urutan, pemeriksaanlabdet_nourut
            ";
      $detailHasil = Yii::app()->db->createCommand($query)->queryAll();

      $data = array();
      $kelompokDet = null;
      $idx = 0;
      $temp = '';

      foreach ($detailHasil as $i => $detail) {
        $id_jenisPeriksa = $detail['jenispemeriksaanlab_id'];
        $jenisPeriksa = $detail['jenispemeriksaanlab_nama'];
        $kelompokDet = $detail['kelompokdet'];
        if ($id_jenisPeriksa == '72') {
          $query = "
                        SELECT jenispemeriksaanlab_m.* FROM pemeriksaanlabdet_m
                        JOIN pemeriksaanlab_m ON pemeriksaanlabdet_m.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id
                        JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                        WHERE nilairujukan_id = " . $detail['nilairujukan_id'] . " AND pemeriksaanlab_m.jenispemeriksaanlab_id <> " . $id_jenisPeriksa . "
                    ";
          $rec = Yii::app()->db->createCommand($query)->queryRow();
          $id_jenisPeriksa = $rec['jenispemeriksaanlab_id'];
          $jenisPeriksa = $rec['jenispemeriksaanlab_nama'];
        }

        if ($temp != $kelompokDet) {
          $idx = 0;
        }
        $data[$id_jenisPeriksa]['tittle'] = $jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['id'] = $id_jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['nama'] = $jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['kelompok'] = $kelompokDet;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['kelompok'] = $kelompokDet;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan_det'] = $detail['pemeriksaanlab_nama'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan'] = $detail['namapemeriksaandet'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['id_pemeriksaan'] = $detail['nilairujukan_id'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['normal'] = $detail['nilairujukan_nama'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['metode'] = $detail['nilairujukan_metode'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['hasil'] = $detail['hasilpemeriksaan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['nilairujukan'] = $detail['nilairujukan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['satuan'] = $detail['hasilpemeriksaan_satuan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['keterangan'] = $detail['nilairujukan_keterangan'];

        $temp = $kelompokDet;
        $idx++;
      }
    } else {
      $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
        array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
      );
      $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
      $modHasilPeriksa = HasilpemeriksaanpaT::model()->findByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );
      $data = HasilpemeriksaanpaT::model()->findAllByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );
    }

    $judulLaporan = 'hasil_pemeriksaan_lab';
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        'print_hasil',
        array(
          'judulLaporan' => $judulLaporan,
          'modHasilPeriksa' => $modHasilPeriksa,
          'detailHasil' => $detailHasil,
          'caraPrint' => $caraPrint,
          'hasil' => $data,
          'masukpenunjang' => $masukpenunjang,
          'pemeriksa' => $pemeriksa,
          'data' => $data
        )
      );
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render(
        'Print',
        array(
          'judulLaporan' => $judulLaporan,
          'caraPrint' => $caraPrint,
          'modHasilPeriksa' => $modHasilPeriksa,
          'detailHasil' => $detailHasil,
          'hasil' => $hasil,
          'masukpenunjang' => $masukpenunjang,
          'pemeriksa' => $pemeriksa,
          'data' => $data
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $this->layout = '//layouts/iframe';

      //                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $ukuranKertasPDF = 'LAB';      //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //                //$mpdf->useOddEven = 2;  
      //                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      //                $mpdf->WriteHTML($stylesheet,1);
      /*
             * cara ambil margin
             * tinggi_header * 72 / (72/25.4)
             *  tinggi_header = inchi
             */
      $header = 1.14 * 72 / (72 / 25.4);
      $mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 5, 0, 0);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'print_hasil',
          array(
            'caraPrint' => $caraPrint,
            'judulLaporan' => $judulLaporan,
            'modHasilPeriksa' => $modHasilPeriksa,
            'detailHasil' => $detailHasil,
            'hasil' => $hasil,
            'masukpenunjang' => $masukpenunjang,
            'pemeriksa' => $pemeriksa,
            'data' => $data,
            //                            'data_rad'=>$data_rad
          ),
          true
        )
      );
      $nama_file = $judulLaporan . ".pdf";
      $mpdf->Output("uploads/" . $nama_file, 'F');
      // $mpdf->Output();
    }
  }

  /**
   * mengenerate data hasil pemneriksaan ke dalam bentuk printout
   * @param type $pasienmasukpenunjang_id
   * @param type $pendaftaran_id
   * @param type $caraPrint
   */
  public function actionPrint($pasienmasukpenunjang_id, $pendaftaran_id, $caraPrint)
  {
    $judulLaporan = 'Laporan Detail Permintaan Penawaran';
    //            $masukpenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);  
    $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
    $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modHasilpemeriksaanLab = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));
    $modHasilpemeriksaanLab->printhasillab = true;
    $modHasilpemeriksaanLab->update();
    $detailHasil = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id' => $modHasilPeriksa->hasilpemeriksaanlab_id), array('order' => 'detailhasilpemeriksaanlab_id'));

    $data = array();
    $kelompokDet = null;
    $idx = 0;
    $temp = '';
    foreach ($detailHasil as $i => $detail) {
      $id_jenisPeriksa = $detail->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_id;
      $jenisPeriksa = $detail->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
      $kelompokDet = $detail->pemeriksaandetail->nilairujukan->kelompokdet;

      if ($temp != $kelompokDet) {
        $idx = 0;
      }

      $data[$id_jenisPeriksa][$kelompokDet]['id'] = $id_jenisPeriksa;
      $data[$id_jenisPeriksa][$kelompokDet]['nama'] = $jenisPeriksa;
      $data[$id_jenisPeriksa][$kelompokDet]['kelompok'] = $kelompokDet;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['kelompok'] = $kelompokDet;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan_det'] = $detail->pemeriksaanlab->pemeriksaanlab_nama;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan'] = $detail->pemeriksaandetail->nilairujukan->namapemeriksaandet;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['id_pemeriksaan'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_id;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['normal'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_nama;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['metode'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_metode;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['hasil'] = $detail->hasilpemeriksaan;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['nilairujukan'] = $detail->nilairujukan;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['satuan'] = $detail->hasilpemeriksaan_satuan;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['keterangan'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_keterangan;

      $temp = $kelompokDet;
      $idx++;
    }

    $hasil = array();
    foreach ($detailHasil as $i => $detail) {
      $jenisPeriksa = $detail->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
      $kelompokDet = $detail->pemeriksaandetail->nilairujukan->kelompokdet;
      $hasil[$jenisPeriksa][$kelompokDet][$i]['namapemeriksaan'] = $detail->pemeriksaandetail->nilairujukan->namapemeriksaandet;
      $hasil[$jenisPeriksa][$kelompokDet][$i]['hasil'] = $detail->hasilpemeriksaan;
      $hasil[$jenisPeriksa][$kelompokDet][$i]['nilairujukan'] = $detail->nilairujukan;
      $hasil[$jenisPeriksa][$kelompokDet][$i]['satuan'] = $detail->hasilpemeriksaan_satuan;
      $hasil[$jenisPeriksa][$kelompokDet][$i]['keterangan'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_keterangan;
    }

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      //                $this->render('Print',array('judulLaporan'=>$judulLaporan,
      //                                            'caraPrint'=>$caraPrint,
      //                                            'modPermintaanPenawaran'=>$modPermintaanPenawaran,
      //                                            'modPermintaanPenawaranDetails'=>$modPermintaanPenawaranDetails));

      $this->render(
        'Print',
        array(
          'judulLaporan' => $judulLaporan,
          'caraPrint' => $caraPrint,
          'modHasilPeriksa' => $modHasilPeriksa,
          'detailHasil' => $detailHasil,
          'hasil' => $hasil,
          'masukpenunjang' => $masukpenunjang,
          'pemeriksa' => $pemeriksa,
          'data' => $data
        )
      );
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render(
        'Print',
        array(
          'judulLaporan' => $judulLaporan,
          'caraPrint' => $caraPrint,
          'modHasilPeriksa' => $modHasilPeriksa,
          'detailHasil' => $detailHasil,
          'hasil' => $hasil,
          'masukpenunjang' => $masukpenunjang,
          'pemeriksa' => $pemeriksa,
          'data' => $data
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'Print',
          array(
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint,
            'modHasilPeriksa' => $modHasilPeriksa,
            'detailHasil' => $detailHasil,
            'hasil' => $hasil,
            'masukpenunjang' => $masukpenunjang,
            'pemeriksa' => $pemeriksa,
            'data' => $data
          ),
          true
        )
      );

      $mpdf->Output();
    }
  }

  /**
   * fungsi pembatalan pemeriksaan penunjang
   */
  public function actionBatalPenunjang()
  {
    $idKirimUnit = null;
    $keterangan = "";
    $nama_pasien = "";

    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $ok = true;
      try {
        $id = $_POST['pendaftaran_id'];
        $idPenunjang = $_POST['idPenunjang'];
        $keterangan_batal = $_POST['keterangan_batal'];

        $pendaftaran = PendaftaranT::model()->findByPk($id);
        $penunjang = PasienmasukpenunjangT::model()->findByPk($idPenunjang);
        $nama_pasien = $pendaftaran->pasien->nama_pasien;
        $hasil = HasilpemeriksaanlabT::model()->findByAttributes(array(
          'pasienmasukpenunjang_id' => $idPenunjang
        ));

        if (!empty($hasil)) {
          $sysmex = new Sysmex;
          $sysmex->kirim_tambah($hasil->hasilpemeriksaanlab_id, Sysmex::ORDER_CONTROL_BATAL);
        }

        // periksa tindakan
        $criteria = new CDbCriteria();
        $criteria->select = "count(tindakanpelayanan_id) as tindakanpelayanan_id";
        $criteria->addCondition("pasienmasukpenunjang_id = " . $idPenunjang . " and tindakansudahbayar_id is not null");
        $tindakan = TindakanpelayananT::model()->find($criteria);

        if ($tindakan->tindakanpelayanan_id > 0) {
          $pesan = 'exist';
          $keterangan = "<div class='flash-success'>Pasien <b> " . $pendaftaran->pasien->nama_pasien . " 
                                </b> sudah melakukan pembayaran pemeriksaan </div>";
          $ok = false;
        } else {
          $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id' => $idPenunjang,
          ));

          foreach ($tindakan as $item) {
            $item->detailhasilpemeriksaanlab_id = null;
            $item->hasilpemeriksaanrm_id = null;
            $item->hasilpemeriksaanrad_id = null;
            $item->hasilpemeriksaanpa_id = null;

            $item->save();

            DetailhasilpemeriksaanlabT::model()->updateAll(array(
              'tindakanpelayanan_id' => null,
            ), "tindakanpelayanan_id = " . $item->tindakanpelayanan_id);
          }

          /*
                    TindakanpelayananT::model()->updateAll(array(
                        'detailhasilpemeriksaanlab_id' => null,
                        'hasilpemeriksaanrm_id' => null,
                        'hasilpemeriksaanrad_id' => null,
                        'hasilpemeriksaanpa_id' => null,
                            ), 'pasienmasukpenunjang_id = ' . $idPenunjang);
                     * 
                     */

          TindakanpelayananT::model()->deleteAllByAttributes(array(
            'pasienmasukpenunjang_id' => $idPenunjang,
          ));
          // $ok = $ok && PasienmasukpenunjangT::model()->deleteByPk();
        }

        //var_dump($ok);
        // simpan batal periksa penunjang
        $model = new PasienbatalperiksaR();
        $model->pendaftaran_id = $id;
        $model->pasien_id = $pendaftaran->pasien_id;
        $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
        $model->pasienkirimkeunitlain_id = $penunjang->pasienkirimkeunitlain_id;
        $model->tglbatal = date('Y-m-d');
        $model->keterangan_batal = $keterangan_batal;
        $model->create_time = date('Y-m-d H:i:s');
        $model->update_time = null;
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else
          $ok = false;

        //var_dump($ok);

        if (empty($penunjang->pasienkirimkeunitlain_id) && $pendaftaran->ruangan_id == $penunjang->ruangan_id) {
          $attributes = array(
            'statusperiksa' => 'BATAL PERIKSA',
            'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
            'update_time' => date('Y-m-d H:i:s'),
            'update_loginpemakai_id' => Yii::app()->user->id
          );
          $ok = $ok && PendaftaranT::model()->updateByPk($id, $attributes);
        } else {
          $attributes = array(
            'statusperiksa' => 'BATAL PERIKSA',
            'update_time' => date('Y-m-d H:i:s'),
            'update_loginpemakai_id' => Yii::app()->user->id
          );
          $this->notifPasienBatalPemeriksaan($penunjang);
          $ok = $ok && PasienmasukpenunjangT::model()->updateByPk($idPenunjang, $attributes);
        }

        // die;

        $oa = ObatalkespasienT::model()->findAllByAttributes(array(
          'pasienmasukpenunjang_id' => $idPenunjang,
        ));
        foreach ($oa as $item) {
          StokobatalkesT::model()->deleteAllByAttributes(array(
            'obatalkespasien_id' => $item->obatalkespasien_id,
          ));
          ObatalkespasienT::model()->deleteByPk($item->obatalkespasien_id);
        }

        if ($ok) {
          $transaction->commit();
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $pesan = "<div class='flash-error'>Pemeriksaan untuk Pasien <b> " . $pendaftaran->pasien->nama_pasien . " 
                                </b> gagal dibatalkan. " . $ex->getMessage() . " </div>";
        $status = 'not';
        $transaction->rollback();
      }

      $data['pesan'] = $pesan;
      $data['status'] = $status;
      $data['keterangan'] = $keterangan;
      //$data['smspasien'] = $smspasien;
      $data['nama_pasien'] = $nama_pasien;

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  /**
   * mengirimkan notifikasi batal pemeriksaan
   * @param type $pasienMasukPenunjang
   */
  public function notifPasienBatalPemeriksaan($pasienMasukPenunjang)
  {
    // var_dump($pasienMasukPenunjang->attributes); die;

    if (!empty($pasienMasukPenunjang->pasienkirimkeunitlain_id)) {
      $ki = PasienkirimkeunitlainT::model()->findByPk($pasienMasukPenunjang->pasienkirimkeunitlain_id);
      $modRuangan = RuanganM::model()->findByPk($ki->create_ruangan);
    } else {
      $modRuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOKET);
    }

    // var_dump($modRuangan->attributes); die;
    //$modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain->create_ruangan);
    $pasien_id = $pasienMasukPenunjang->pasien_id;
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul = 'Pasien Batal Pemeriksaan Laboratorium';

    $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;

    //var_dump($judul." , ".$isi);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $modRuangan->instalasi_id, 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
    ));
  }

  /**
   * Hapus tindakan dan hasil pada laboratorium.
   * @param type PasienmasukpenunjangT $pasienMasukPenunjang data pasien penunjang.
   */
  public function hapusTindakanPemeriksaan($pasienMasukPenunjang)
  {
    $ok = true;
    $hasil = HasilpemeriksaanlabT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
    ));
    $detail = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array(
      'hasilpemeriksaanlab_id' => $hasil->hasilpemeriksaanlab_id,
    ));

    $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
    ));

    $oa = ObatalkespasienT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
    ));

    foreach ($detail as $item) {
      $ok = $ok && DetailhasilpemeriksaanlabT::model()->deleteByPk($item->detailhasilpemeriksaanlab_id);
    }
    $ok = $ok && HasilpemeriksaanlabT::model()->deleteByPk($hasil->hasilpemeriksaanlab_id);

    foreach ($tindakan as $item) {
      $ok = $ok && TindakankomponenT::model()->deleteAllByAttributes(array(
        'tindakanpelayanan_id' => $item->tindakanpelayanan_id,
      ));
      $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
    }



    // TODO : Hapus Obatalkes

    foreach ($oa as $item) {
      $ok = $ok && StokobatalkesT::model()->deleteAllByAttributes(array(
        'obatalkespasien_id' => $item->obatalkespasien_id,
      ));
      $ok = $ok && ObatalkespasienT::model()->deleteByPk($item->obatalkespasien_id);
    }

    //var_dump($ok); die;
  }

  /**
   * pembatalan pemeriksaan pasien luar
   */
  public function actionBatalPeriksaPasienLuar2()
  { //ini fungsi yang lama tapi jangan Di HAPUS, takut minta di rubah lagi
    // if(!Yii::app()->user->checkAccess(Params::DEFAULT_OPERATING)){
    //     throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
    // }
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';

      try {
        $pendaftaran_id = $_POST['pendaftaran_id'];

        /*
                 * cek data pendaftaran pasien masuk penunjang
                 */
        $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(
          array(
            'pendaftaran_id' => $pendaftaran_id
          )
        );

        $model = new PasienbatalperiksaR();
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasien_id = $pasienMasukPenunjang->pasien_id;
        $model->tglbatal = date('Y-m-d');
        $model->keterangan_batal = "Batal Laboratorium";
        $model->create_time = date('Y-m-d H:i:s');
        $model->update_time = null;
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        // echo "A"; exit();

        if (!$model->save()) {
          $status = 'not';
        }

        if (empty($pasienMasukPenunjang->pasienkirimkeunitlain_id)) {
          // echo "B"; exit();
          $attributes = array(
            'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
            'update_time' => date('Y-m-d H:i:s'),
            'update_loginpemakai_id' => Yii::app()->user->id
          );
          $pendaftaran = LBPendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

          $attributes = array(
            'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
          );
          $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
        }

        $attributes = array(
          'statusperiksa' => 'BATAL PERIKSA',
          'update_time' => date('Y-m-d H:i:s'),
          'update_loginpemakai_id' => Yii::app()->user->id
        );
        $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);

        if (!$penunjang) {
          $status = 'not';
        }


        /*
                 * cek data tindakan_pelayanan
                 */
        $attributes = array(
          'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
          'tindakansudahbayar_id' => null
        );
        // echo "C"; exit();
        $tindakan = LBTindakanPelayananT::model()->findAllByAttributes($attributes);
        // echo count((array)$tindakan); exit();
        // echo "<pre>";
        // print_r($tindakan);
        // exit;
        if (count((array)$tindakan) > 0) {
          foreach ($tindakan as $val => $key) {
            $attributes = array(
              'tindakanpelayanan_id' => $key->tindakanpelayanan_id
            );
            $hapus_det_tindakan = LBDetailHasilPemeriksaanLabT::model()->deleteAllByAttributes($attributes);
          }


          $attributes = array(
            'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
          );
          $hapus_tindakan = LBTindakanPelayananT::model()->deleteAllByAttributes($attributes);
          if (!$hapus_tindakan) {
            $status = 'not';
          }
        } else {
          $pesan = 'exist';
        }

        /*
                 * kondisi_commit
                 */
        if ($status == 'ok') {
          $transaction->commit();
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }

      $data['pesan'] = $pesan;
      $data['status'] = $status;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * pembatalan pasien luar laboratorium
   * @throws Exception
   */
  public function actionBatalPeriksaPasienLuarTidakDipakai()
  {
    $ajax = Yii::app()->request->isAjaxRequest;
    // if(!Yii::app()->user->checkAccess(Params::DEFAULT_OPERATING)){
    //     throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
    // } 
    if ($ajax) {
      $pendaftaran_id = $_POST['idpendaftaran'];
      $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);
      $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasien_id' => $pendaftaran->pasien_id));
      $hasilPemeriksaanLab = HasilpemeriksaanlabT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

      $pasienKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => 5));
      $detailHasilPemeriksaanLab = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id' => $hasilPemeriksaanLab->hasilpemeriksaanlab_id));

      $cekPasien = substr($pendaftaran->no_pendaftaran, 0, 2);
      //                jika pasien berasal dari pendaftaran pasien luar
      if ($cekPasien == 'LB') {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          //                   update rujuakan_id = null terlebih dahulu di pendaftaran_t
          $updateRujuakan = PendaftaranT::model()->updateByPk($pendaftaran_id, array('rujukan_id' => null));
          //                    delete tabel rujukan sesuai dengan id_rujuan yang berada di pendaftaran_t
          $deletePasienRujukan = RujukanT::model()->deleteByPk($pendaftaran->rujukan_id);
          //                    delete penagambilan sampel berdasarkan pasienmasukpenunjang_id di pasienmasukpenunjang_t
          $deletePengambilanSample = PengambilansampleT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id));
          //                    delete detailhasilpemeriksaanlab_t berdasarkan dengan hasilpemeriksaanlab_id
          $deleteDetailPemeriksaanLab = DetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(array('hasilpemeriksaanlab_id' => $hasilPemeriksaanLab->hasilpemeriksaanlab_id));
          //                    delete hasilpemeriksaanlab_t berdasarkan pendaftaran_id
          $deleteHasilPemeriksaanLab = HasilpemeriksaanlabT::model()->deleteAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
          //                    delete uabahcarabayar_t berdasarkan pendaftaran_id
          $deleteUbahCarabayar = UbahcarabayarR::model()->deleteAll('pendaftaran_id = ' . $pendaftaran_id);
          //                    delete tindakanpelayanan_t berdasarkan pendaftaran_id
          $deleteTindakanPelayanan = TindakanpelayananT::model()->deleteAll('pendaftaran_id = ' . $pendaftaran_id);
          //                    delete pasienmasuk penunjang berdasarkan pendaftaran_t
          $deletePasienMasukPenunjang = PasienmasukpenunjangT::model()->deleteAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
          //                    delete pendaftaran berdasarkan id_pendaftaran
          $deletePendaftaran = PendaftaranT::model()->deleteByPk($pendaftaran_id);
          //                    delete pasie_m berdasarkan pasien_id
          //                        $deletePasien               = PasienM::model()->deleteByPk($pasien->pasien_id);
          //                    
          //                    $delete = $deletePasienRujukan && $deletePengambilanSample && $deleteUbahCarabayar && $deleteHasilPemeriksaanLab && $deleteTindakanPelayanan && $deletePasien && $deletePendaftaran;

          if ($deletePasien && $pendaftaran) {
            $data['status'] = 'success';
            $transaction->commit();
          } else {
            $data['status'] = 'gagal';
            $transaction->rollback();
            throw new Exception("Pasien tidak bisa dibatalkan");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          $data['status'] = 'gagal';
          $data['info'] = $ex;
        }
      } else {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          //                        echo "pasienkirimke unit lain->".$pasienKirimKeUnitLain->pasienmasukpenunjang_id;
          //                        echo "----pasien masuk penunjang ->".$pasienKirimKeUnitLain->pasienmasukpenunjang_id;
          $updatePasienKirimKeUnitLain = PasienkirimkeunitlainT::model()->updateByPk(
            $pasienKirimKeUnitLain->pasienkirimkeunitlain_id,
            array('pasienmasukpenunjang_id' => null)
          );

          $deleteDetailPemeriksaanLab = DetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(
            array('hasilpemeriksaanlab_id' => $hasilPemeriksaanLab->hasilpemeriksaanlab_id)
          );

          foreach ($detailHasilPemeriksaanLab as $key => $deleteDetailHasil) {
            $deleteTindakanPelayanan = TindakanpelayananT::model()->deleteByPk($deleteDetailHasil->tindakanpelayanan_id);
          }

          $deleteHasilPemeriksaanLab = HasilpemeriksaanlabT::model()->deleteAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
          //                        $deletePasienMasukPenunjang = PasienmasukpenunjangT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id)); 
          $deletePasienMasukPenunjang = PasienmasukpenunjangT::model()->deleteByPk($pasienKirimKeUnitLain->pasienmasukpenunjang_id);
          if ($deletePasienMasukPenunjang) {
            $data['status'] = 'success';
            $transaction->commit();
          } else {
            $data['status'] = 'gagal';
            $transaction->rollback();
            throw new Exception("Pasien tidak bisa dibatalkan");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          $data['status'] = 'gagal';
          $data['info'] = $ex;
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * fungsi untuk mengubah data pasien
   * @param type $id
   * @param type $pendaftaran_id
   */
  public function actionUbahPasien($id, $pendaftaran_id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = LBPasienM::model()->findByPk($id);
    $modPendaftaran = LBPendaftaranT::model()->findByPk($pendaftaran_id);
    $format = new MyFormatter();
    $temLogo = $model->photopasien;
    $model->update_time = date('Y-m-d');
    $model->update_loginpemakai_id = Yii::app()->user->id;
    $model->tgl_rekam_medik = $format->formatDateTimeForUser($model->tgl_rekam_medik);
    if (isset($_POST['LBPasienM'])) {
      $random = rand(0000000, 9999999);
      $model->attributes = $_POST['LBPasienM'];
      $model->umur = $_POST['LBPasienM']['umur'];
      //                    $modPendaftaran->attributes = $_POST['LBPendaftaranT'];

      $model->umur = $_POST['LBPasienM']['umur'];
      $model->tanggal_lahir = $format->formatDateTimeForDb($model->tanggal_lahir);
      $model->kelompokumur_id = CustomFunction::getKelompokUmur($model->tanggal_lahir);
      $model->photopasien = CUploadedFile::getInstance($model, 'photopasien');
      $gambar = $model->photopasien;
      $model->tgl_rekam_medik = $format->formatDateTimeForDb($model->tgl_rekam_medik);

      if (!empty($model->photopasien)) { //if user input the photo of patient
        $model->photopasien = $random . $model->photopasien;

        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = $model->photopasien;
        $fullImgSource = Params::pathPasienDirectory() . $fullImgName;
        $fullThumbSource = Params::pathPasienTumbsDirectory() . 'kecil_' . $fullImgName;

        if ($model->save()) {
          if (!empty($temLogo)) {
            if (file_exists(Params::pathPasienDirectory() . $temLogo))
              unlink(Params::pathPasienDirectory() . $temLogo);
            if (file_exists(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo))
              unlink(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo);
          }
          $gambar->saveAs($fullImgSource);
          $thumb->create($fullImgSource)
            ->resize(200, 200)
            ->save($fullThumbSource);
          LBPendaftaranT::model()->updateByPk($pendaftaran_id, array('umur' => $model->umur));
          //                            $model->updateByPk($id, array('tgl_rekam_medik'=>$model->tgl_rekam_medik));
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          //                            $this->redirect(array('cariPasien'));
        } else {
          Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
        }
      } else { //if user not input the photo
        $model->photopasien = $temLogo;
        if ($model->save()) {
          //                            $model->updateByPk($id, array('tgl_rekam_medik'=>$model->tgl_rekam_medik));
          LBPendaftaranT::model()->updateByPk($pendaftaran_id, array('umur' => $model->umur));
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          //                            $this->redirect(array('cariPasien'));
        }
      }
    }
    $this->render($this->path_view . 'ubahPasien', array('model' => $model));
  }

  /**
   * actionPrintKartuGolonganDarah
   * @param type $pendaftaran_id
   * @param type $pasienmasukpenunjang_id
   * @param type $caraPrint
   */
  public function actionPrintKartuGolonganDarah($pasienmasukpenunjang_id, $pendaftaran_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = LBPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modHasilPemeriksaan = HasilpemeriksaanlabT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPeriksaGolonganDarah = DetailhasilpemeriksaanlabT::model()->findByAttributes(array('hasilpemeriksaanlab_id' => $modHasilPemeriksaan->hasilpemeriksaanlab_id, 'pemeriksaanlab_id' => Params::PERIKSA_GOLONGANDARAH_ID));
    $modPeriksaRhesus = DetailhasilpemeriksaanlabT::model()->findByAttributes(array('hasilpemeriksaanlab_id' => $modHasilPemeriksaan->hasilpemeriksaanlab_id, 'pemeriksaanlab_id' => Params::PERIKSA_RHESUS_ID));
    if ($modPeriksaGolonganDarah) {
      if (empty($modPeriksaGolonganDarah->hasilpemeriksaan)) {
        echo "Hasil pemeriksaan golongan darah masih kosong !";
      } else {
        if ($_REQUEST['caraPrint'] == 'PDF') {
          $this->layout = '//layouts/iframe';

          //                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
          $ukuranKertasPDF = 'KGDLAB';      //Ukuran Kertas Pdf
          $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
          $mpdf = new MyPDF60('', $ukuranKertasPDF);
          //$mpdf->useOddEven = 2;
          $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
          $mpdf->WriteHTML($stylesheet, 1);
          /*
                     * cara ambil margin
                     * tinggi_header * 72 / (72/25.4)
                     *  tinggi_header = inchi
                     */
          $header = 0.4 * 72 / (72 / 25.4);
          $mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 2, 0, 0);
          $mpdf->WriteHTML(
            $this->renderPartial('PrintKartuGolonganDarah', array(
              'caraPrint' => $caraPrint,
              'modPasien' => $modPasien,
              'modPendaftaran' => $modPendaftaran,
              'modHasilPemeriksaan' => $modHasilPemeriksaan,
              'modPeriksaGolonganDarah' => $modPeriksaGolonganDarah,
              'modPeriksaRhesus' => $modPeriksaRhesus,
            ), true)
          );
          $mpdf->Output();
        } else if ($caraPrint == 'PRINT') {
          $this->layout = '//layouts/printWindows';
          $this->render('PrintKartuGolonganDarah', array(
            'caraPrint' => $caraPrint,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'modHasilPemeriksaan' => $modHasilPemeriksaan,
            'modPeriksaGolonganDarah' => $modPeriksaGolonganDarah,
            'modPeriksaRhesus' => $modPeriksaRhesus,
          ));
        }
      }
    } else {
      echo "Pasien " . $modPasien->no_rekam_medik . " - " . $modPasien->nama_pasien . " tidak melakukan pemeriksaan golongan darah";
    }
  }

  /**
   * mengenerate umur
   */
  public function actionGetUmur()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter;
      $tglLahir = $format->formatDateTimeForDb($_POST['tglLahir']);
      $dob = $tglLahir;
      $today = date("Y-m-d");
      list($y, $m, $d) = explode('-', $dob);
      list($ty, $tm, $td) = explode('-', $today);
      if ($td - $d < 0) {
        $day = ($td + 30) - $d;
        $tm--;
      } else {
        $day = $td - $d;
      }
      if ($tm - $m < 0) {
        $month = ($tm + 12) - $m;
        $ty--;
      } else {
        $month = $tm - $m;
      }
      $year = $ty - $y;

      // $data['umur'] = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';
      $data['thn'] = str_pad($year, 2, '0', STR_PAD_LEFT);
      $data['bln'] = str_pad($month, 2, '0', STR_PAD_LEFT);
      $data['hr'] = str_pad($day, 2, '0', STR_PAD_LEFT);
      //$data['umur'] = $dob;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * mengenerate kabupaten dalam bentuk dropdown
   */
  public function actionAddKabupaten()
  {
    $modelKab = new KabupatenM;
    $modProp = PropinsiM::model()->findAll();

    if (isset($_POST['KabupatenM'])) {
      $modelKab->attributes = $_POST['KabupatenM'];
      $modelKab->kabupaten_aktif = true;
      if ($modelKab->save()) {
        $data = KabupatenM::model()->findAllByAttributes(array('propinsi_id' => $_POST['KabupatenM']['propinsi_id'],), array('order' => 'kabupaten_nama'));
        $data = CHtml::listData($data, 'kabupaten_id', 'kabupaten_nama');

        if (empty($data)) {
          $kabupatenOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $kabupatenOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Kabupaten <b>" . $_POST['KabupatenM']['kabupaten_nama'] . "</b> berhasil ditambahkan </div>",
            'kabupaten' => $kabupatenOption,
          ));
          exit;
        }
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formAddKabupaten', array('model' => $modelKab, 'modProp' => $modProp), true)
      ));
      exit;
    }
  }

  /**
   * action ketika tombol panggil di klik
   */
  public function actionPanggil()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
      $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
      $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

      $nama_modul = Yii::app()->controller->module->id;
      $nama_controller = Yii::app()->controller->id;
      $nama_action = Yii::app()->controller->action->id;
      $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
      $criteria = new CDbCriteria;
      $criteria->compare('modul_id', $modul_id);
      $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
      $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
      if (isset($_POST['tujuansms'])) {
        $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
      }
      $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
      $data['smspasien'] = 1;
      $data['nama_pasien'] = '';

      if (isset($pasienMasukPenunjang)) {

        $ruangan = RuanganM::model()->findByPk($pasienMasukPenunjang->ruangan_id);
        $data['ruangan_singkatan'] = $ruangan->ruangan_singkatan;

        if ($pasienMasukPenunjang->panggilantrian == true) {
          if ($keterangan == "batal") {
            $pasienMasukPenunjang->panggilantrian = false;
            if ($pasienMasukPenunjang->update()) {
              // SMS GATEWAY
              $modPasien = $pasienMasukPenunjang->pasien;
              $sms = new Sms();
              $smspasien = 1;
              foreach ($modSmsgateway as $i => $smsgateway) {
                $isiPesan = $smsgateway->templatesms;

                $attributes = $modPasien->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $pasienMasukPenunjang->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }

                if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                  if (!empty($modPasien->no_mobile_pasien)) {
                    $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                  } else {
                    $smspasien = 0;
                  }
                }
              }
              // END SMS GATEWAY
              $data['smspasien'] = $smspasien;
              $data['nama_pasien'] = $modPasien->nama_pasien;
              $data['pesan'] = "Pemanggilan no. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dibatalkan !";
            }
          } else {
            $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dipanggil !";
          }
        } else {
          $pasienMasukPenunjang->panggilantrian = true;
          if ($pasienMasukPenunjang->update()) {
            $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dipanggil !";
            // $data_telnet = $pasienMasukPenunjang->ruangan->ruangan_nama.", ".$pasienMasukPenunjang->ruangan->ruangan_singkatan."-".$pasienMasukPenunjang->no_urutperiksa;
            //              AKAN DIGANTI MENGGUNAKAN NODE JS
            // self::postTelnet($data_telnet);
          }
        }
      }

      $attributes = $pasienMasukPenunjang->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $pasienMasukPenunjang->$attribute;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * memanggil no antrian selanjutnya dari antrian terakhir yang dipanggil
   * @throws CHttpException
   */
  public function actionGetAntrianTerakhir()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $data['pesan'] = "";
      $criteria = new CDbCriteria;
      $criteria->addCondition('panggilantrian != TRUE');
      $criteria->addCondition('date(tglmasukpenunjang) BETWEEN \'' . date('d M Y') . '\' AND \'' . date('d M Y') . '\'');
      $criteria->order = 'no_urutperiksa ASC';

      $model = PasienmasukpenunjangV::model()->find($criteria);
      if (!empty($model)) {
        $data['pasienmasukpenunjang_id'] = $model->pasienmasukpenunjang_id;
        $data['ruangan_singkatan'] = $model->ruangan_singkatan;
        $data['no_urutperiksa'] = $model->no_urutperiksa;
        $data['ruangan_id'] = $model->ruangan_id;
      } else {
        $data['pesan'] = "Tidak ada antrian!";
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * mengenerate data kelurahan dalam bentuk dropdown
   */
  public function actionAddKelurahan()
  {
    $modelKel = new KelurahanM;

    if (isset($_POST['KelurahanM'])) {
      $modelKel->attributes = $_POST['KelurahanM'];
      $modelKel->kelurahan_aktif = true;
      if ($modelKel->save()) {
        $data = KelurahanM::model()->findAllByAttributes(array('kecamatan_id' => $_POST['KelurahanM']['kecamatan_id']), array('order' => 'kelurahan_nama'));
        $data = CHtml::listData($data, 'kelurahan_id', 'kelurahan_nama');

        if (empty($data)) {
          $kelurahanOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih-'), true);
        } else {
          $kelurahanOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih-'), true);
          foreach ($data as $value => $name) {
            $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Kelurahan <b>" . $_POST['KelurahanM']['kelurahan_nama'] . "</b> berhasil ditambahkan </div>",
            'kelurahan' => $kelurahanOption,
          ));
          exit;
        }
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formAddKelurahan', array('model' => $modelKel,), true)
      ));
      exit;
    }
  }

  /**
   * menambahkan fungsi untuk menghapus data sample
   */
  public function actionAjaxDeleteDataSample()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pengambilansample_id = $_POST['id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modKirimSample = LBKirimSampleLabT::model()->findByAttributes(
          array(
            'pengambilansample_id' => $pengambilansample_id
          )
        );
        $data['success'] = true;
        if (!empty($modKirimSample)) {
          LBPengambilanSampleT::model()->updateByPk($pengambilansample_id, array('kirimsamplelab_id' => null));
          $deleteKirimSample = LBKirimSampleLabT::model()->deleteAllByAttributes(
            array(
              'pengambilansample_id' => $pengambilansample_id
            )
          );

          $deletePengambilanSample = LBPengambilanSampleT::model()->deleteByPk($pengambilansample_id);
          if (!$deleteKirimSample) {
            $data['success'] = false;
          }
        } else {
          $deletePengambilanSample = LBPengambilanSampleT::model()->deleteByPk($pengambilansample_id);
        }

        if ($deletePengambilanSample && $data['success']) {
          $data['success'] = true;
          $transaction->commit();
        } else {
          $data['success'] = false;
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        echo MyExceptionMessage::getMessage($exc, true);
        $data['success'] = false;
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * - digunakan untuk mencetak data
   * @param type $pasienmasukpenunjang_id
   */
  public function actionPrintPermintaan($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/printWindows';

    $judulLaporan = "";

    $modKunjungan = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPeriksa = TindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modSample = PengambilansampleT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

    $this->render('printPemeriksaan', array(
      'modKunjungan' => $modKunjungan,
      'modPeriksa' => $modPeriksa,
      'modSample' => $modSample,
      'judulLaporan' => $judulLaporan,
    ));
  }

  public function actionAmbilHasil($pendaftaran_id, $pasienmasukpenunjang_id, $hasilpemeriksaanlab_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPasienMasukPenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPasien = LBPasienM::model()->findByPk($modPasienMasukPenunjang->pasien_id);
    $modHasilLab = LBHasilPemeriksaanLabT::model()->findByPk($hasilpemeriksaanlab_id);
    $modHasilLab->namaygmenyerahkan = Yii::app()->user->getState('nama_pegawai');
    if (isset($_POST['LBHasilPemeriksaanLabT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        //var_dump($_POST['LBHasilPemeriksaanLabT']);die;


        $modHasilLab->attributes = $_POST['LBHasilPemeriksaanLabT'];
        $modHasilLab->tglpengambilanhasil = $format->formatDateTimeForDb($_POST['LBHasilPemeriksaanLabT']['tglpengambilanhasil']);


        if ($modHasilLab->validate()) {
          $modHasilLab->save();
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
          $this->redirect(array('ambilHasil', 'pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'hasilpemeriksaanlab_id' => $hasilpemeriksaanlab_id, 'frame' => 1, 'popup' => 'true', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('ambilHasil', array(
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modPasien' => $modPasien,
      'modHasilLab' => $modHasilLab,
      'format' => $format,
    ));
  }

  ///n
  public function actionDiagnosa($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');

    $modPendaftaran = LBPendaftaranT::model()->findByPk($pendaftaran_id);
    //             echo $pendaftaran_id;
    //             echo $modPendaftaran->pendaftaran_id;
    //            exit();
    $modPasien = LBPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $konsul = KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    if (!empty($konsul)) {
      $modPendaftaran->pegawai_id = $konsul->pegawai_id;
    }
    //            echo $pendaftaran_id;
    //            exit();
    $modDiagnosa = new DiagnosaV('searchDiagnosis');
    $modDiagnosa->unsetAttributes();  // clear any default values
    if (isset($_GET['DiagnosaV']))
      $modDiagnosa->attributes = $_GET['DiagnosaV'];

    $modMorbiditas[0] = new LBPasienmorbiditasT;
    $modMorbiditas[0]->pendaftaran_id = $pendaftaran_id;
    $modMorbiditas[0]->pasien_id = $modPendaftaran->pasien_id;
    $modMorbiditas[0]->ruangan_id = $ruangan_id;
    $modMorbiditas[0]->kelompokumur_id = $modPasien->kelompokumur_id;
    $modMorbiditas[0]->golonganumur_id = $modPendaftaran->golonganumur_id;
    $modMorbiditas[0]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modMorbiditas[0]->pegawai_id = $modPendaftaran->pegawai_id;

    $modKasuspenyakitDiagnosa = new KasuspenyakitdiagnosaV('search');
    $modKasuspenyakitDiagnosa->unsetAttributes();  // clear any default values
    $modKasuspenyakitDiagnosa->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    if (isset($_GET['KasuspenyakitdiagnosaV'])) {
      $modKasuspenyakitDiagnosa->attributes = $_GET['KasuspenyakitdiagnosaV'];
      $modKasuspenyakitDiagnosa->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    }

    $modDiagnosaicdixM = new LBDiagnosaicdixM('search');
    $modDiagnosaicdixM->unsetAttributes();  // clear any default values
    if (isset($_GET['LBDiagnosaicdixM']))
      $modDiagnosaicdixM->attributes = $_GET['LBDiagnosaicdixM'];
    $modSebabDiagnosa = LBSebabDiagnosaM::model()->findAll();

    $newInput = false;
    if (isset($_POST['Morbiditas'])) {
      //echo "<pre>".print_r($_POST['Morbiditas'],1)."</pre>";exit;
      $newInput = true;
      $modMorbiditas = $this->saveDiagnosa($_POST['Morbiditas'], $modPasien, $modPendaftaran);
    }

    $listMorbiditas = LBPasienMorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $this->render($this->path_view . 'indexv2', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modDiagnosa' => $modDiagnosa,
      'modDiagnosaicdixM' => $modDiagnosaicdixM,
      'modKasuspenyakitDiagnosa' => $modKasuspenyakitDiagnosa,
      'modSebabDiagnosa' => $modSebabDiagnosa,
      'modMorbiditas' => $modMorbiditas,
      'listMorbiditas' => $listMorbiditas,
      'successSave' => $this->successSave,
      'newInput' => $newInput
    ));
  }

  protected function saveDiagnosa($diagnosas, $modPasien, $modPendaftaran)
  {
    $valid = true;
    foreach ($diagnosas as $i => $diagnosa) {
      $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
      $morbiditas[$i] = new LBPasienMorbiditasT;
      $morbiditas[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $morbiditas[$i]->pasien_id = $modPendaftaran->pasien_id;
      $morbiditas[$i]->ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $morbiditas[$i]->kelompokumur_id = $modPasien->kelompokumur_id;
      $morbiditas[$i]->golonganumur_id = $modPendaftaran->golonganumur_id;
      //                $morbiditas[$i]->$golUmur = 1;
      $morbiditas[$i]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
      $morbiditas[$i]->pegawai_id = $modPendaftaran->pegawai_id;
      $morbiditas[$i]->diagnosa_id = $diagnosa['diagnosa'];
      $morbiditas[$i]->kelompokdiagnosa_id = $diagnosa['kelompokDiagnosa'];
      $morbiditas[$i]->diagnosaicdix_id = $diagnosa['diagnosaTindakan'];
      $morbiditas[$i]->sebabdiagnosa_id = $diagnosa['sebabDiagnosa'];
      $morbiditas[$i]->infeksinosokomial = '0'; //$diagnosa['infeksiNosokomial'];
      $morbiditas[$i]->tglmorbiditas = $_POST['LBPasienMorbiditasT'][0]['tglmorbiditas'];
      //$morbiditas[$i]->kasusdiagnosa = $_POST['LBPasienMorbiditasT'][0]['kasusdiagnosa'];
      $morbiditas[$i]->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $diagnosa['diagnosa']);
      $morbiditas[$i]->pegawai_id = $_POST['LBPasienMorbiditasT'][0]['pegawai_id'];
      $valid = $morbiditas[$i]->validate() && $valid;
    }
    if ($valid) {
      foreach ($morbiditas as $j => $morbiditasPasien) {
        $morbiditasPasien->save();
        $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
        $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);
        $updateStatusPeriksa = PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'))); // LNG-959
        if ($modPendaftaran->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA)
          $updateStatusPeriksa = PendaftaranT::model()->broadcastNotifSudahPeriksa($modPendaftaran->pendaftaran_id);
      }
      //echo 'VALID';
      $this->successSave = true;
      Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
      return $morbiditas;
    } else {
      //echo 'TIDAK VALID';
      Yii::app()->user->setFlash('error', "Data tidak valid ");
      return $morbiditas;
    }
  }

  protected function getKasusDiagnosa($pasien_id, $idDiagnosa)
  {
    $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $pasien_id, 'diagnosa_id' => $idDiagnosa));
    if (!empty($modMorbiditas))
      return Params::KASUSDIAGNOSA_KASUS_LAMA;
    else
      return Params::KASUSDIAGNOSA_KASUS_BARU;
  }

  private function cekGolonganUmur($idGolonganUmur)
  {
    switch ($idGolonganUmur) {
      case 1:
        return 'umur_0_28hr';
      case 2:
        return 'umur_28hr_1thn';
      case 3:
        return 'umur_1_4thn';
      case 4:
        return 'umur_5_14thn';
      case 5:
        return 'umur_15_24thn';
      case 6:
        return 'umur_25_44thn';
      case 7:
        return 'umur_45_64thn';
      case 8:
        return 'umur_65';

      default:
        break;
    }
  }

  public function actionAjaxDeleteDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idDiagnosa = $_POST['idDiagnosa'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $pasienMorbiditas = LBPasienMorbiditasT::model()->findAllByAttributes(
          array(
            'diagnosa_id' => $idDiagnosa
          )
        );
        $data['success'] = true;
        if (count((array)$pasienMorbiditas) > 0) {
          $deleteDiagnosa = LBPasienMorbiditasT::model()->deleteAllByAttributes(
            array(
              'diagnosa_id' => $idDiagnosa
            )
          );
          if (!$deleteDiagnosa) {
            $data['success'] = false;
          }
        } else {
          $deleteDiagnosa = LBPasienMorbiditasT::model()->deleteAllByAttributes(
            array(
              'diagnosa_id' => $idDiagnosa
            )
          );
        }

        if ($deleteDiagnosa && $data['success']) {
          $data['success'] = true;
          $transaction->commit();
        } else {
          $data['success'] = false;
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        echo MyExceptionMessage::getMessage($exc, true);
        $data['success'] = false;
      }


      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrintDiagnosa($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modPendaftaran = LBPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = LBPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $listMorbiditas = LBPasienMorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modMorbiditas = LBPasienMorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judul_print = 'Diagnosa';
    $this->render($this->path_view . 'print', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'listMorbiditas' => $listMorbiditas,
      'modMorbiditas' => $modMorbiditas
    ));
  }

  public function actionLoadFormDiagnosis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idDiagnosa = isset($_POST['idDiagnosa']) ? $_POST['idDiagnosa'] : null;
      $idKelDiagnosa = isset($_POST['idKelDiagnosa']) ? $_POST['idKelDiagnosa'] : null;
      $tglDiagnosa = isset($_POST['tglDiagnosa']) ? $_POST['tglDiagnosa'] : null;

      $modDiagnosaicdixM = DiagnosaicdixM::model()->findAll();
      $modSebabDiagnosa = SebabdiagnosaM::model()->findAll();
      $modDiagnosa = DiagnosaM::model()->findByPk($idDiagnosa);

      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial($this->path_view . '_formLoadDiagnosis', array(
          'modDiagnosa' => $modDiagnosa,
          'idKelDiagnosa' => $idKelDiagnosa,
          'modDiagnosaicdixM' => $modDiagnosaicdixM,
          'modSebabDiagnosa' => $modSebabDiagnosa,
          'tglDiagnosa' => $tglDiagnosa
        ), true)
      ));
      exit;
    }
  }

  public function actionSaveDiagnosis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $IdPendaftaran = $_POST['IdPendaftaran'];
      $modPendaftaran = LBPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array('pendaftaran_id' => $IdPendaftaran));

      $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
        'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
        'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
      ), array(
        'order' => 'tglkonsulpoli desc',
      ));

      if (!empty($konsul)) {
        $modPendaftaran->pegawai_id = $konsul->pegawai_id;
        $modPendaftaran->ruangan_id = $konsul->ruangan_id;
      }

      $modPasien = LBPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $morbiditas = new LBPasienMorbiditasT;
      $morbiditas->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $morbiditas->pasien_id = $modPendaftaran->pasien_id;
      $morbiditas->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $morbiditas->kelompokumur_id = $modPasien->kelompokumur_id;
      $morbiditas->golonganumur_id = $modPendaftaran->golonganumur_id;
      $morbiditas->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
      $morbiditas->pegawai_id = $modPendaftaran->pegawai_id;
      $morbiditas->diagnosa_id = $_POST['idDiagnosa'];
      $morbiditas->kelompokdiagnosa_id = $_POST['kelompokDiagnosa'];
      $morbiditas->infeksinosokomial = '0';
      $morbiditas->tglmorbiditas = (isset($_POST['tglDiagnosa']) ? $_POST['tglDiagnosa'] : null);

      $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $modPendaftaran->pasien_id, 'diagnosa_id' => $morbiditas->diagnosa_id));
      if (!empty($modMorbiditas))
        $morbiditas->kasusdiagnosa = 'KASUS LAMA';
      else
        $morbiditas->kasusdiagnosa = 'KASUS BARU';

      $valid = $morbiditas->validate();
      if ($valid) {
        $morbiditas->save();

        $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
        $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);
        PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s')));

        if ($modPendaftaran->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA)
          PendaftaranT::model()->broadcastNotifSudahPeriksa($modPendaftaran->pendaftaran_id);
      }
    }
  }

  public function actionSetTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $drop = '<option value="">-- Pilih --</option>';

      $modTindakans = LBTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {




          $modTindakan->pemeriksaanlab_id = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->pemeriksaanlab_id;
          $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
          $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
          $modTindakan->tarif_satuan = $format->formatNumberForUser($modTindakan->tarif_satuan);

          $rows .= $this->renderPartial($this->path_view_pendaftaran . "_rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $modTindakan), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows,
        'drop' => $drop,
      ));
    }
    Yii::app()->end();
  }

  public function actionPrintUlangTindakan($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = LBPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = LBPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modViewTindakans = LBTindakanPelayananT::model()
      ->with(
        'daftartindakan',
        'dokter1',
        'dokter2',
        'dokterPendamping',
        'dokterAnastesi',
        'dokterDelegasi',
        'bidan',
        'suster',
        'perawat',
        'tipePaket'
      )
      ->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id)); // RND-6244

      // var_dump(count($modViewTindakans)); die;

      $update = true;

      if(!empty($modViewTindakans)) {

        foreach($modViewTindakans as $td) {


          $cetakan = !empty($td->cetakan) ? intval($td->cetakan) : 1;
          $ke = $cetakan + 1;

          if($ke < 2) {
            $ke = 2;
          }

          $tind = TindakanpelayananT::model()->findByPk($td->tindakanpelayanan_id);

          $tind->cetakan = $ke;
          $update &= $tind->save();

          // echo '<pre>'; var_dump(Yii::app()->user->getState('ruangan_id')); die;


        }
      }

      if($update) {


    $dataTindakan = [];
    if(count($modViewTindakans) > 0) {
      foreach($modViewTindakans as $i => $data) {
        if($data->nopelayanan != null) {
          $dataTindakan[$data->nopelayanan][] = $data;
        }
      }
    }


    $modViewTindakans = $dataTindakan;


    $modViewBmhp = ObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judul_print = 'Tindakan Pasien ' . $modPasien->nama_pasien;
    $this->render(
      $this->path_view . 'print/printUlangPerNota',
      array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modPendaftaran' => $modPendaftaran,
        'modTindakans' => $modViewTindakans,
        'modViewBmhp' => $modViewBmhp,
        'modPasien' => $modPasien
      )
    );
    
      }

    

  }
}