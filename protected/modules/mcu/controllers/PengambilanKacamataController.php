<?php
class PengambilanKacamataController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "mcu.views.pengambilanKacamata.";

  public $pergantiankacamatatersimpan = false;

  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null)
  {
    $format = new MyFormatter();
    $model = new MCGantikacamataT();
    $modPegawai = new PegawaiV();

    if (!empty($id)) {
      $model = MCGantikacamataT::model()->findByPk($id);
      $model->nama_pegawai = $model->pegawai->NamaLengkap;
      $modPegawai->nomorindukpegawai = $model->pegawai->nomorindukpegawai;;
      $model->vod_spheris = sprintf("%.2f", $model->vod_spheris);
      $model->vod_cylindrys = sprintf("%.2f", $model->vod_cylindrys);
      $model->vos_spheris = sprintf("%.2f", $model->vos_spheris);
      $model->vos_cylindrys = sprintf("%.2f", $model->vos_cylindrys);
      $model->add_kacamata = sprintf("%.2f", $model->add_kacamata);
    }

    if (isset($_POST['MCGantikacamataT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = $this->simpanPengambilanKacamata($model, $_POST['MCGantikacamataT']);
        if ($this->pergantiankacamatatersimpan) {
          $transaction->commit();
          $this->redirect(array('index', 'id' => $model->gantikacamata_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pengambilan kacamata gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data pengambilan kacamata gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'model' => $model,
      'modPegawai' => $modPegawai,
      'format' => $format
    ));
  }

  /**
   * proses simpan data pasien
   * @param type $model
   * @param type $post
   * @return type
   */
  public function simpanPengambilanKacamata($model, $post)
  {
    $format = new MyFormatter();
    if (isset($post['gantikacamata_id']) && (!empty($post['gantikacamata_id']))) {
      $load = new $model;
      $model = $load->findByPk($post['gantikacamata_id']);
    }
    $model->attributes = $post;
    $model->tglgantikacamata = $format->formatDateTimeForDb($model->tglgantikacamata);
    $model->tglpenyerahan = $format->formatDateTimeForDb($model->tglpenyerahan);
    $model->duedata_kacamata = $format->formatDateTimeForDb($model->duedata_kacamata);
    $model->create_time = date('Y-m-d H:i:s');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $model->jnstransaksi_km = $post['jnstransaksi_km'];
    $model->vod_spheris = !empty($post['vod_spheris']) ? $post['vod_spheris'] : null;
    $model->vod_cylindrys = !empty($post['vod_cylindrys']) ? $post['vod_cylindrys'] : null;
    $model->vos_spheris = !empty($post['vos_spheris']) ? $post['vos_spheris'] : null;
    $model->vos_cylindrys = !empty($post['vos_cylindrys']) ? $post['vos_cylindrys'] : null;
    $model->add_kacamata = !empty($post['add_kacamata']) ? $post['add_kacamata'] : null;

    if ($model->save()) {
      $this->pergantiankacamatatersimpan = true;
    }

    return $model;
  }

  /**
   * Mengurai data pegawai berdasarkan pegawai_id
   * @throws CHttpException
   */
  public function actionGetDataPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pegawai_id)) {
        $criteria->addCondition("pegawai_id = " . $pegawai_id);
      }
      $model = PegawaiM::model()->find($criteria);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tgl_lahirpegawai"] = date("d/m/Y", strtotime($model->tgl_lahirpegawai));
      if (!empty($model->pegawai_id)) {
        $returnVal['nomorindukpegawai'] = $model->nomorindukpegawai;
        $returnVal['nama_pegawai'] = $model->NamaLengkap;
        $returnVal['departement_peg'] = $model->unit_perusahaan;
        //				$returnVal['jabatan_nama'] = isset($model->jabatan->jabatan_nama) ? $model->jabatan_nama : "";
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk menampilkan pegawai dari autocomplete
   * 1. nomorindukpegawai
   */
  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->nomorindukpegawai;
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * set duedata_kacamata dari tglpenyerahan
   */
  public function actionSetTglDueDate_old()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter();
      $estimasitahun = 1;
      $data['tgl_duedate'] = null;
      $data['status_duedate'] = true;
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $modGantiKacamata = MCGantikacamataT::model()->findByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'gantikacamata_id desc'));
      if (!empty($modGantiKacamata)) {
        $tglduedate_sebelumnya = $format->formatDateTimeForDb($modGantiKacamata->duedata_kacamata);
        $tglduedate_setahun = strtotime($tglduedate_sebelumnya . ' + ' . $estimasitahun . ' years');


        if ($_POST['tglpenyerahan'] > $tglduedate_setahun) {
          $data['status_duedate'] = true; //transaksi dapat dilakukan
        } else {
          $data['status_duedate'] = false; // transaksi tidak dapat dilakukan
        }
      }

      if (isset($_POST['tglpenyerahan']) && !empty($_POST['tglpenyerahan'])) {
        if (!empty($_POST['tglpenyerahan'])) {
          $tglpenyerahan = $format->formatDateTimeForDb($_POST['tglpenyerahan']);
          $tanggal = strtotime($tglpenyerahan . ' + ' . $estimasitahun . ' years');
          $tgl_duedate = date('Y-m-d H:i:s', $tanggal);
        } else {
          $tanggal = date('Y-m-d H:i:s');
          $tanggal = strtotime($tanggal . ' + ' . $estimasitahun . ' years');
          $tgl_duedate = date('Y-m-d H:i:s', $tanggal);
        }
        $data['tgl_duedate'] = (!empty($tgl_duedate) ? date("d/m/Y H:i:s", strtotime($tgl_duedate)) : null);
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }


  public function actionSetTglGantiKacamata()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter();
      $data['duedate'] = null;
      $data['tglganti'] = null;
      $data['is_pasienbaru'] = false;
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      if ($_POST['jnstransaksi_km'] == 'Frame dan Lensa') { // "Frame dan Lensa" adalah value dari lookup_m
        $estimasitahun = 2;
      } else {
        $estimasitahun = 1;
      }

      $modGantiKacamata = MCGantikacamataT::model()->findByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'gantikacamata_id desc'));
      if (!empty($modGantiKacamata)) {
        $data['duedate'] = $format->formatDateTimeForDb($modGantiKacamata->tglgantikacamata);
        $data['tglganti'] = strtotime($data['duedate'] . ' + ' . $estimasitahun . ' years');
        $data['tglganti'] = date('Y-m-d', $data['tglganti']);
      } else {
        $data['is_pasienbaru'] = true;
        if (!empty($_POST['duedata_kacamata'])) {
          $data['tglganti'] = strtotime($format->formatDateTimeForDb($_POST['duedata_kacamata']) . ' + ' . $estimasitahun . ' years');
          $data['tglganti'] = date('Y-m-d', $data['tglganti']);
        }
      }

      $data['duedate'] = (!empty($data['duedate']) ? date("d/m/Y", strtotime($data['duedate'])) : null);
      $data['tglganti'] = (!empty($data['tglganti']) ? date("d/m/Y", strtotime($data['tglganti'])) : null);
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetTglGantiKacamataDariTglSerah()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter();
      $data['duedate'] = null;
      $data['tglganti'] = null;
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $pegawai_id = isset($_POST['tglpenyerahan']) ? $_POST['tglpenyerahan'] : null;
      if ($_POST['jnstransaksi_km'] == 'Frame dan Lensa') { // "Frame dan Lensa" adalah value dari lookup_m
        $estimasitahun = 2;
      } else {
        $estimasitahun = 1;
      }

      $data['duedate'] = $format->formatDateTimeForDb($_POST['tglpenyerahan']);
      $data['tglganti'] = strtotime($data['duedate'] . ' + ' . $estimasitahun . ' years');
      $data['tglganti'] = date('Y-m-d', $data['tglganti']);

      $data['duedate'] = (!empty($data['duedate']) ? date("d/m/Y", strtotime($data['duedate'])) : null);
      $data['tglganti'] = (!empty($data['tglganti']) ? date("d/m/Y", strtotime($data['tglganti'])) : null);
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrint($id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $model = MCGantikacamataT::model()->findByPk($id);
    $model->vod_spheris = sprintf("%.2f", $model->vod_spheris);
    $model->vod_cylindrys = sprintf("%.2f", $model->vod_cylindrys);
    $model->vos_spheris = sprintf("%.2f", $model->vos_spheris);
    $model->vos_cylindrys = sprintf("%.2f", $model->vos_cylindrys);
    $model->add_kacamata = sprintf("%.2f", $model->add_kacamata);
    $judul_print = 'Pergantian Kacamata';

    $this->render('Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
    ));
  }
}
