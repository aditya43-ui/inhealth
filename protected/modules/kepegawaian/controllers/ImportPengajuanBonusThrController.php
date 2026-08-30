<?php

class ImportPengajuanBonusThrController extends MyAuthController
{
  public $path_view = "kepegawaian.views.importBonusThr.";

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Import Pajak Thr / Bonus";
    if (isset($_POST['PengbonusthrdetailT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      try {
        if (isset($_POST['PengbonusthrdetailT'])) {

          foreach ($_POST['PengbonusthrdetailT'] as $id => $val) {
            $model = PengbonusthrdetailT::model()->findByPk($id);
            $totalpajak = 0;
            $totaltarif = 0;
            $tunjanganpph21 = 0;

            if (isset($val['pph21']) && !empty($val['pph21']) && $val['pph21'] > 0) {
              $totalpajak = $val['pph21'];
            }
            if (isset($val['totaltarif']) && !empty($val['totaltarif']) && $val['totaltarif'] > 0) {
              $totaltarif = $val['totaltarif'];
            }
            if (isset($val['tunjanganpph21']) && !empty($val['tunjanganpph21']) && $val['tunjanganpph21'] > 0) {
              $tunjanganpph21 = $val['tunjanganpph21'];
            }
            // echo print_r($_POST['PengbonusthrdetailT']).exit();
            if ($model->jenisgaji == 'Bonus') {
              $model->pajakbonus = $totalpajak;
              $model->thp_bonus = $totaltarif;
              $model->tunjangan_pph_21_bonus = $tunjanganpph21;
            } else {
              $model->totalpajak = $totalpajak;
              $model->totalthr = $totaltarif;
              $model->tunjangan_pph_21_thr = $tunjanganpph21;
            }
            // $model->isimport = true;
            $ok = $ok && $model->save();
          }
        }

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('index', 'sukses' => 1));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }


    $this->render($this->path_view . 'index', array());
  }

  public function actionUpload()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $str = "";
    $msg = "Data Tidak Ditemukan";
    $suksesupload = 0;

    if (isset($_FILES['file'])) {
      try {
        $file_path = $_FILES['file']['tmp_name'];

        $sheet = Yii::app()->yexcel->readActiveSheet($file_path);
        $jenisgaji = $_POST['jenisgaji'];
        $cr = new CDbCriteria();
        $cr->select = "t.pengbonusthrdetail_id, t.pegawai_id, peng.periodebonusthr, t.totalthr, t.totalpajak, t.nilaibonus, t.pajakbonus";
        $cr->join = 'join pegawai_m p on p.pegawai_id = t.pegawai_id
                JOIN pengbonusthr_t peng on peng.pengbonusthr_id = t.pengbonusthr_id';
        $cr->addCondition("trim(p.nomorindukpegawai) = :nip");
        $cr->addCondition("peng.jenisgaji = :jenisgaji");
        $cr->addCondition("peng.periodebonusthr = :periode");
        // $cr->addCondition("t.isimport = false");

        $cnt = 0;
        $cnt_ada = 0;
        $no = 1;
        $array = array();
        foreach ($sheet[1] as $idx => $row) {
          $array[strtolower($row)] = $idx;
        }

        foreach ($sheet as $idx => $row) {

          if ($idx == 1) {
            continue;
          }

          $kode = $row[$array[strtolower('Nik')]];
          $kode = str_replace("‘", "", $kode);
          $kode = str_replace("'", "", $kode);
          $kode = str_replace("`", "", $kode);

          $cr->params[':nip'] = $kode;
          $cr->params[':jenisgaji'] = $jenisgaji;
          $cr->params[':periode'] = $row[$array[strtolower('tahun')]] . "-" . str_pad($row[$array[strtolower('masa')]], 2, 0, STR_PAD_LEFT) . "-01";

          $gaji = PengbonusthrdetailT::model()->find($cr);

          if (!empty($gaji)) {
            $msg = "";
            $suksesupload = 1;
            $str .= $this->renderPartial($this->path_view . "_rowImport", array(
              'model' => $gaji,
              'tahun' => $row[$array[strtolower('tahun')]],
              'row' => $row,
              'indexRow' => $array,
              'no' => $no,
              'jenisgaji' => $jenisgaji

            ), true);
            $cnt_ada++;
            $no++;
          }

          $cnt++;
        }

        echo CJSON::encode(array(
          'ok' => $suksesupload,
          'msg' => $msg,
          'html' => $str,
          'total' => $cnt,
          'ada' => $cnt_ada,
        ));
      } catch (Exception $ex) {
        echo CJSON::encode(array(
          'ok' => 0,
          'msg' => $ex->getMessage(),
          'html' => '',
          'total' => 0,
          'ada' => 0
        ));
      }
    }
  }

  public function actionDownloadTemplate()
  {
    $this->layout = '//layouts/printExcel';
    $jenisgaji = (!empty($_GET['jenisgaji']) ? $_GET['jenisgaji'] : null);
    $this->render($this->path_view . '_templateExcel', array('jenisgaji' => $jenisgaji));
  }
}
