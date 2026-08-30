<?php

class ImportPajakDokterController extends MyAuthController
{
  public $path_view = "keuangan.views.importPajakDokter.";

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Import Jasa Dokter";
    if (isset($_POST['PembayaranjasaT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      try {
        if (isset($_POST['PembayaranjasaT'])) {

          foreach ($_POST['PembayaranjasaT'] as $id => $val) {
            $model = PembayaranjasaT::model()->findByPk($id);
            $model->total_pajak = $val['total_pajak'];
            //                        $model->totalbayarjasa = $val['totalbayarjasa'];
            $model->totalbayarjasa = ($model->totaljasa + $model->totaladjsument - $model->total_pajak);
            $model->isimport = true;
            $ok = $ok && $model->save();

            $modPajakDokter = PajakdokterT::model()->findByPk($model->pajakdokter_id);

            if (!empty($modPajakDokter)) {
              $modPajakDokter->pajakprogressif = $model->total_pajak;
              $ok = $ok && $modPajakDokter->save();
            }
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

    if (isset($_FILES['file'])) {
      try {
        $file_path = $_FILES['file']['tmp_name'];

        $sheet = Yii::app()->yexcel->readActiveSheet($file_path);

        $cr = new CDbCriteria();
        $cr->join = 'join pegawai_m p on p.pegawai_id = t.pegawai_id';
        $cr->addCondition("trim(p.nomorindukpegawai) = :npwp");
        $cr->addCondition("t.periodejasa = :periode");
        $cr->addCondition("t.isimport = false");

        $cnt = 0;
        $cnt_ada = 0;

        $array = array();
        foreach ($sheet[1] as $idx => $row) {
          $array[strtolower($row)] = $idx;
        }
        $no = 1;
        foreach ($sheet as $idx => $row) {

          if ($idx == 1) {
            continue;
          }

          $kode = $row[$array[strtolower('Nik')]];
          $kode = str_replace("‘", "", $kode);
          $kode = str_replace("'", "", $kode);
          $kode = str_replace("`", "", $kode);

          $cr->params[':npwp'] = $kode;
          $cr->params[':periode'] = $row[$array[strtolower('tahun')]] . "-" . str_pad($row[$array[strtolower('masa')]], 2, 0, STR_PAD_LEFT) . "-01";

          $gaji = PembayaranjasaT::model()->find($cr);

          if (!empty($gaji)) {
            $str .= $this->renderPartial($this->path_view . "_rowImport", array(
              'model' => $gaji,
              'tahun' => $row[$array[strtolower('tahun')]],
              'row' => $row,
              'indexRow' => $array,
              'no' => $no
            ), true);
            $cnt_ada++;
            $no++;
          }
          $cnt++;
        }

        echo CJSON::encode(array(
          'ok' => 1,
          'msg' => '',
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
    $this->render('_templateExcel', array());
  }
}
