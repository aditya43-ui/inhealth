<?php
class FormInventarisasiBarangController extends MyAuthController
{
  public $path_view = 'gudangUmum.views.formInventarisasiBarang.';
  public $forminventarisasitersimpan = false;
  public $forminventarisasidetailtersimpan = true; // untuk looping

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Formulir Inventarisasi Barang";
    $format = new MyFormatter();
    $modBarang = new GUBarangV();
    $model = new GUFormulirinvbarangR();
    $modDetail = array();

    $model->forminvbarang_no = '-- Otomatis --';
    $model->forminvbarang_tgl = date('Y-m-d H:i:s');
    $model->forminvbarang_totalvolume = 0;
    $model->forminvbarang_totalharga = 0;

    if (!empty($_GET['formulirinvbarang_id'])) {
      $model = GUFormulirinvbarangR::model()->findByPk($_GET['formulirinvbarang_id']);
      $modDetail = GUForminvbarangdetR::model()->findAllByAttributes(array('formulirinvbarang_id' => $model->formulirinvbarang_id));
    }

    if (isset($_POST['GUFormulirinvbarangR'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['GUFormulirinvbarangR'];
        $model->forminvbarang_no = MyGenerator::noFormInventarisasiBarang();
        $model->forminvbarang_tgl = $format->formatDateTimeForDb($_POST['GUFormulirinvbarangR']['forminvbarang_tgl']);
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        if ($model->save()) {
          if (isset($_POST['GUBarangV'])) {
            if (count((array)$_POST['GUBarangV']) > 0) {
              foreach ($_POST['GUBarangV'] as $i => $detail) {
                if (isset($detail['cekList'])) {
                  $modelDetail[$i] = $this->simpanFormInventarisasiDetail($model, $detail);
                }
              }
            }
          }
          $this->forminventarisasitersimpan = true;
        } else {
          $this->forminventarisasitersimpan = false;
        }

        if ($this->forminventarisasitersimpan && $this->forminventarisasidetailtersimpan) {
          $transaction->commit();
          $model->isNewRecord = FALSE;
          Yii::app()->user->setFlash('success', "Data nomor Formulir Inventarisasi Barang " . $model->forminvbarang_no . " berhasil disimpan !");
          $this->redirect(array('index', 'formulirinvbarang_id' => $model->formulirinvbarang_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Inventarisasi Barang gagal disimpan!");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Inventarisasi Barang gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    if (isset($_GET['GUBarangV'])) {
      $modBarang->unsetAttributes();
      $modBarang->attributes = $_GET['GUBarangV'];
      $modBarang->barang_kode = $_GET['GUBarangV']['barang_kode'];
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modBarang' => $modBarang,
      'model' => $model,
      'modDetail' => $modDetail
    ));
  }

  /**
   * simpan GUInvbarangdetT
   * @param type $model
   * @param type $detail
   * @return \GUInvbarangdetT
   */
  public function simpanFormInventarisasiDetail($model, $detail)
  {
    $format = new MyFormatter();
    $modFormInvDetail = new GUForminvbarangdetR;
    $modFormInvDetail->attributes = $detail;
    $modFormInvDetail->formulirinvbarang_id = $model->formulirinvbarang_id;

    if ($modFormInvDetail->validate()) {
      $modFormInvDetail->save();
      $this->forminventarisasidetailtersimpan &= true;
    } else {
      $this->forminventarisasidetailtersimpan &= false;
    }

    return $modFormInvDetail;
  }

  public function actionPrint($formulirinvbarang_id)
  {
    $format = new MyFormatter();
    $model = GUFormulirinvbarangR::model()->findByPK($formulirinvbarang_id);
    $modDetails = GUForminvbarangdetR::model()->findAllByAttributes(array('formulirinvbarang_id' => $formulirinvbarang_id));

    $judulLaporan = 'Data Formulir Inventarisasi Barang';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view . 'Print', array(
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint,
      'modDetails' => $modDetails,
      'format' => $format
    ));
  }
}
