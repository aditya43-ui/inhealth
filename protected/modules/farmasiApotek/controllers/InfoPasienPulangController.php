<?php

class InfoPasienPulangController extends MyAuthController
{

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $modRJ = new FAInformasikasirrawatjalanV;
    $modRI = new FAInformasikasirinappulangV;
    $modRD = new FAInformasikasirrdpulangV;
    $cekRJ = true;
    $cekRI = false;
    $cekRD = false;
    $modRJ->tgl_awal = date('Y-m-d');
    $modRJ->tgl_akhir = date('Y-m-d');
    $modRI->tgl_awal = date('Y-m-d');
    $modRI->tgl_akhir = date('Y-m-d');
    $modRD->tgl_awal = date('Y-m-d');
    $modRD->tgl_akhir = date('Y-m-d');


    if (isset($_POST['instalasi'])) {
      switch ($_POST['instalasi']) {
        case 'RJ':
          $cekRJ = true;
          $cekRI = false;
          $cekRD = false;
          $modRJ->attributes = $_POST['FAInformasikasirrawatjalanV'];
          if (!empty($_POST['FAInformasikasirrawatjalanV']['tgl_awal'])) {
            $modRJ->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FAInformasikasirrawatjalanV']['tgl_awal']);
          }
          if (!empty($_POST['FAInformasikasirrawatjalanV']['tgl_akhir'])) {
            $modRJ->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FAInformasikasirrawatjalanV']['tgl_akhir']);
          }

          break;

        case 'RI':
          $cekRI = true;
          $cekRJ = false;
          $cekRD = false;
          $modRI->attributes = $_POST['FAInformasikasirinappulangV'];
          if (!empty($_POST['FAInformasikasirinappulangV']['tgl_awal'])) {
            $modRI->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FAInformasikasirinappulangV']['tgl_awal']);
          }
          if (!empty($_POST['FAInformasikasirinappulangV']['tgl_awal'])) {
            $modRI->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FAInformasikasirinappulangV']['tgl_akhir']);
          }
          break;

        case 'RD':
          $cekRD = true;
          $cekRI = false;
          $cekRJ = false;
          $modRD->attributes = $_POST['FAInformasikasirrdpulangV'];
          if (!empty($_POST['FAInformasikasirrdpulangV']['tgl_awal'])) {
            $modRD->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FAInformasikasirrdpulangV']['tgl_awal']);
          }
          if (!empty($_POST['FAInformasikasirrdpulangV']['tgl_awal'])) {
            $modRD->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FAInformasikasirrdpulangV']['tgl_akhir']);
          }

          break;
      }
    }

    $this->render('index', array(
      'modRJ' => $modRJ,
      'modRI' => $modRI,
      'modRD' => $modRD,
      'cekRJ' => $cekRJ,
      'cekRI' => $cekRI,
      'cekRD' => $cekRD,
      'format' => $format,
    ));
  }

  public function actionIndexRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Pulang";
    $format = new MyFormatter();
    $modRJ = new FAInformasikasirrawatjalanV;
    $modRJ->tgl_awal = date('Y-m-d');
    $modRJ->tgl_akhir = date('Y-m-d');

    if (isset($_GET['FAInformasikasirrawatjalanV'])) {
      $modRJ->attributes = $_GET['FAInformasikasirrawatjalanV'];
      if (!empty($_GET['FAInformasikasirrawatjalanV']['tgl_awal'])) {
        $modRJ->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasikasirrawatjalanV']['tgl_awal']);
      }
      if (!empty($_GET['FAInformasikasirrawatjalanV']['tgl_awal'])) {
        $modRJ->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasikasirrawatjalanV']['tgl_akhir']);
      }
      if (!empty($_GET['FAInformasikasirrawatjalanV']['pegawai_id'])) {
        $modRJ->pegawai_id = $_GET['FAInformasikasirrawatjalanV']['pegawai_id'];
      }
    }

    $this->render('indexRJ', array(
      'modRJ' => $modRJ, 'format' => $format,
    ));
  }

  public function actionIndexRI()
  {
    $format = new MyFormatter();
    $modRI = new FAInformasikasirinappulangV;
    $modRI->tgl_awal = date('Y-m-d');
    $modRI->tgl_akhir = date('Y-m-d');

    if (isset($_GET['FAInformasikasirinappulangV'])) {
      $modRI->attributes = $_GET['FAInformasikasirinappulangV'];
      if (!empty($_GET['FAInformasikasirinappulangV']['tgl_awal'])) {
        $modRI->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasikasirinappulangV']['tgl_awal']);
      }
      if (!empty($_GET['FAInformasikasirinappulangV']['tgl_awal'])) {
        $modRI->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasikasirinappulangV']['tgl_akhir']);
      }
      if (!empty($_GET['FAInformasikasirinappulangV']['pegawai_id'])) {
        $modRI->pegawai_id = $_GET['FAInformasikasirinappulangV']['pegawai_id'];
      }
      if (!empty($_GET['FAInformasikasirinappulangV']['ruangan_id'])) {
        $modRI->ruangan_id = $_GET['FAInformasikasirinappulangV']['ruangan_id'];
      }
      if (!empty($_GET['FAInformasikasirinappulangV']['kamarruangan_id'])) {
        $modRI->kamarruangan_id = $_GET['FAInformasikasirinappulangV']['kamarruangan_id'];
      }
    }

    $this->render('indexRI', array(
      'modRI' => $modRI, 'format' => $format,
    ));
  }

  public function actionIndexRD()
  {
    $format = new MyFormatter();
    $modRD = new FAInformasikasirrdpulangV;
    $modRD->tgl_awal = date('Y-m-d');
    $modRD->tgl_akhir = date('Y-m-d');

    if (isset($_GET['FAInformasikasirrdpulangV'])) {
      $modRD->attributes = $_GET['FAInformasikasirrdpulangV'];
      if (!empty($_GET['FAInformasikasirrdpulangV']['tgl_awal'])) {
        $modRD->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasikasirrdpulangV']['tgl_awal']);
      }
      if (!empty($_GET['FAInformasikasirrdpulangV']['tgl_awal'])) {
        $modRD->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasikasirrdpulangV']['tgl_akhir']);
      }
      if (!empty($_GET['FAInformasikasirrdpulangV']['pegawai_id'])) {
        $modRD->pegawai_id = $_GET['FAInformasikasirrdpulangV']['pegawai_id'];
      }
    }

    $this->render('indexRD', array(
      'modRD' => $modRD, 'format' => $format,
    ));
  }

  /*
     * untuk informasi di farmasiApotek/InfoPasienPulang
     */
  public function actionUbahStatusFarmasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idpendaftaran = $_POST['idpendaftaran'];
      $status = $_POST['status'];
      //                $format = new MyFormatter();
      $model = PendaftaranT::model()->findByPk($idpendaftaran);
      if ($status == "RI") {
        $update = PasienadmisiT::model()->updateByPk($model->pasienadmisi_id, array('statusfarmasi' => true));
        if ($update) {
          $data['pesan'] = 'Berhasil';
        } else {
          $data['pesan'] = 'Gagal';
        }
      } else {
        $update = PendaftaranT::model()->updateByPk($idpendaftaran, array('statusfarmasi' => true));
        if ($update) {
          $data['pesan'] = 'Berhasil';
        } else {
          $data['pesan'] = 'Gagal';
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
