<?php
class InformasiSterilisasiController extends MyAuthController
{
  public $path_view = 'sterilisasi.views.informasiSterilisasi.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Sterilisasi";
    $format = new MyFormatter();
    $modSterilisasi = new STSterilisasiT('searchInformasi');
    $modSterilisasi->tgl_awal = date("Y-m-d");
    $modSterilisasi->tgl_akhir = date("Y-m-d");

    if (isset($_GET['STSterilisasiT'])) {
      $modSterilisasi->attributes = $_GET['STSterilisasiT'];
      $modSterilisasi->tgl_awal = $format->formatDateTimeForDb($_GET['STSterilisasiT']['tgl_awal']);
      $modSterilisasi->tgl_akhir = $format->formatDateTimeForDb($_GET['STSterilisasiT']['tgl_akhir']);
      $modSterilisasi->ruangan_id = $_GET['STSterilisasiT']['ruangan_id'];
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $modSterilisasi
    ));
  }


  public function actionDetail($id = null)
  {
    $this->layout = 'iframe';

    $model = STSterilisasiT::model()->findByPk($id);
    $modDetail = STSterilisasidetailT::model()->findAllByAttributes(array('sterilisasi_id' => $id));


    $this->render($this->path_view . '_detailSterilisasi', array(
      'model' => $model,
      'modDetail' => $modDetail,
    ));
  }
  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
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
      $models = CHtml::listData(STRuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionSetStatusSterilisasi()
  {

    if (Yii::app()->request->isAjaxRequest) {
      $sterilisasi_id = isset($_POST['sterilisasi_id']) ? $_POST['sterilisasi_id'] : null;
      $modSterilisasi = SterilisasiT::model()->findByPk($sterilisasi_id);
      if (!empty($modSterilisasi) && $modSterilisasi->sterilisasi_status == 'BELUM') {
        $modSterilisasi->tglmulaisterilisasi = date('Y-m-d H:i:s');
        $modSterilisasi->sterilisasi_status = 'SEDANG';
        $modSterilisasi->update();
        $data['status'] = true;
      } else if (!empty($modSterilisasi) && $modSterilisasi->sterilisasi_status == 'SEDANG') {
        $modSterilisasi->tglselesaisterilisasi = date('Y-m-d H:i:s');
        $modSterilisasi->sterilisasi_status = 'SUDAH';
        $modSterilisasi->update();
        $data['status'] = true;
      } else {
        $data['status'] = false;
        $data['pesan'] = 'Update Gagal Di Lakukan !';
      }



      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk insert hasil indikator
   */
  public function actionInsertHasilIndikator()
  {
    $model = new STHasilindikatorT;

    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");

    if (isset($_POST['STHasilindikatorT'])) {
      if ($_POST['STHasilindikatorT']['sterilisasi_id'] != "") {
        $model->attributes = $_POST['STHasilindikatorT'];
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;

        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->indikator_hslkimia_2 = '-';
        $model->indikator_hslkimia_3 = '-';

        $modSterilisasi = SterilisasiT::model()->findByPk($_POST['STHasilindikatorT']['sterilisasi_id']);
        $modSterilisasi->sterilisasi_status = 'SUDAH';
        $modSterilisasi->tglselesaisterilisasi = date('Y-m-d H:i:s');
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($model->save() && $modSterilisasi->update()) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data Monitoring Berhasil disimpan');
            echo CJSON::encode(
              array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Hasil Indikator Berhasil Di Simpan!.</div>",
              )
            );
          } else {
            echo CJSON::encode(
              array(
                'status' => 'proses_form',
                'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
              )
            );
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Hasil Indikator Di Lakukan!.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'div' => $this->renderPartial($this->path_view . '_formHasilIndikator', array('model' => $model, 'menu' => $menu), true)
        )
      );
      exit;
    }
  }

  /*
     * insert untuk monitoring
     * 
     */
  public function actionInsertMonitoringSterilisasi()
  {

    $model = new STMonitoringsterilisasiT();

    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['STMonitoringsterilisasiT'])) {
      if ($_POST['STMonitoringsterilisasiT']['sterilisasi_id'] != "") {
        $model->attributes = $_POST['STMonitoringsterilisasiT'];
        $model->tlgmonitoringsterilisasi = date('Y-m-d H:i:s');
        $model->tglujikontrol = MyFormatter::formatDateTimeForDb($_POST['STMonitoringsterilisasiT']['tglujikontrol']);
        $model->tgl_inkubasi = MyFormatter::formatDateTimeForDb($_POST['STMonitoringsterilisasiT']['tgl_inkubasi']);
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($model->save()) {
            $transaction->commit();
            echo CJSON::encode(
              array(
                'status' => 'proses_form',
                'sukses' => 1,
                'div' => "<div class='flash-success'>Hasil Monitoring Sterilisasi Berhasil Di Simpan!.</div>",
              )
            );
          } else {
            echo CJSON::encode(
              array(
                'status' => 'proses_form',
                'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
              )
            );
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Hasil Indikator Di Lakukan!.</div>",
          )
        );
        exit;
      }
    }
    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'div' => $this->renderPartial($this->path_view . '_formMonitoringSterilisasi', array('model' => $model, 'menu' => $menu), true)
        )
      );
      exit;
    }
  }
}
