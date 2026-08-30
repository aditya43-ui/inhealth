<?php

/**
 * View Catatan Anestesi
 *
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 */
class CatatanAnestesiController extends MyAuthController
{
  public $path_view = "bedahSentral.views.catatanAnestesi.";

  public function actionIndex($pasienmasukpenunjang_id)
  {
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

    $this->render($this->path_view . "index", array(
      'model' => $model,
      'rencana' => $rencana,
      'diagnosa' => $diagnosa,
      'anestesi' => $anestesi,
    ));
  }
}
