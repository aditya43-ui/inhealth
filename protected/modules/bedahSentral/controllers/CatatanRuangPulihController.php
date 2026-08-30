<?php

/**
 * View Catatan Anestesi
 *
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 */
class CatatanRuangPulihController extends MyAuthController
{
  public $path_view = "bedahSentral.views.catatanRuangPulih.";

  public function actionIndex($pasienmasukpenunjang_id)
  {
    $model = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $penunjang = $model;

    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $diagnosa = PasienmorbiditasT::model()->findByAttributes(array(
      'pendaftaran_id' => $model->pendaftaran_id,
      'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
    ), array(
      'condition' => "tglmorbiditas::date <= '" . MyFormatter::formatDateTimeForDB($rencana->tglrencanaoperasi) . "'::date",
    ));

    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    //        var_dump($rencana->attributes); die;

    if (!empty($rencana)) {
      $anamnesa = AnamnesaT::model()->findByAttributes(array(
        'pendaftaran_id' => $model->pendaftaran_id,
      ), array(
        'condition' => "tglanamnesis::date <= '" . MyFormatter::formatDateTimeForDB($rencana->tglrencanaoperasi) . "'::date",
        'order' => 'anamesa_id desc'
      ));
    } else {
      $rencana = null;
    }

    $status = StatusduranteroperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusduranteroperasiT();
      $status->pasien_id = $penunjang->pasien_id;
      $status->pendaftaran_id = $penunjang->pendaftaran_id;
      $status->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $status->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
    }

    $this->render($this->path_view . "index", array(
      'model' => $model,
      'rencana' => $rencana,
      'diagnosa' => $diagnosa,
      'anestesi' => $anestesi,
      'status' => $status,
      'anamnesa' => $anamnesa,
    ));
  }


  public function actionLaporan($pasienmasukpenunjang_id, $caraPrint = null)
  {

    $this->layout = '//layouts/iframe';

    if (!empty($caraPrint)) {
      $this->layout = '//layouts/printWindows_delay';
    }

    $model = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));



    $diagnosa = PasienmorbiditasT::model()->findByAttributes(array(
      'pendaftaran_id' => $model->pendaftaran_id,
      'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
    ), array(
      'condition' => "tglmorbiditas::date <= '" . MyFormatter::formatDateTimeForDB($rencana->tglrencanaoperasi) . "'::date",
    ));

    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $status = StatusduranteroperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusduranteroperasiT();
      $status->pasien_id = $penunjang->pasien_id;
      $status->pendaftaran_id = $penunjang->pendaftaran_id;
      $status->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $status->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
    }

    $anamnesa = null;
    if (!empty($rencana)) {
      $anamnesa = AnamnesaT::model()->findByAttributes(array(
        'pendaftaran_id' => $model->pendaftaran_id,
      ), array(
        'condition' => "tglanamnesis::date <= '" . MyFormatter::formatDateTimeForDB($rencana->tglrencanaoperasi) . "'::date",
        'order' => 'anamesa_id desc'
      ));
    } else {
      $rencana = null;
    }

    if ($caraPrint == "PDF") {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->render($this->path_view . "view", array(
        'model' => $model,
        'rencana' => $rencana,
        'diagnosa' => $diagnosa,
        'anestesi' => $anestesi,
        'status' => $status,
        'anamnesa' => $anamnesa,
        'caraPrint' => $caraPrint,
      ), 'true'));
      $mpdf->Output();
    } else {
      $this->render($this->path_view . "view", array(
        'model' => $model,
        'rencana' => $rencana,
        'diagnosa' => $diagnosa,
        'anestesi' => $anestesi,
        'status' => $status,
        'anamnesa' => $anamnesa,
        'caraPrint' => $caraPrint,
      ));
    }
  }
}
