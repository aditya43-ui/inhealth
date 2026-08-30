<?php
Yii::import('rekamMedis.controllers.ResumeMedisController');
Yii::import('rekamMedis.models.*');
Yii::import('rekamMedis.views.*');

class ResumeMedisPIController extends ResumeMedisController
{

  public $path_view = "rekamMedis.views.resumeMedis.";

  // dicopy dari laboratorium.controller.pemakaianBmhp
  public function actionIndex($pendaftaran_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Resume Medis";
    return ResumeMedisController::actionIndex($pendaftaran_id);
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    return ResumeMedisController::actionAutocompleteKunjungan();
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    return ResumeMedisController::actionGetDataKunjungan();
  }

  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataIkhisar()
  {
    return ResumeMedisController::actionGetDataIkhisar();
  }

  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataDiagnosisKelainan()
  {
    return ResumeMedisController::actionGetDataDiagnosisKelainan();
  }

  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataDiagnosisSementara()
  {
    return ResumeMedisController::actionGetDataDiagnosisSementara();
  }

  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataDiagnosisAkhir()
  {
    return ResumeMedisController::actionGetDataDiagnosisAkhir();
  }

  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataObatSementara()
  {
    return ResumeMedisController::actionGetDataObatSementara();
  }

  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataObatPulang()
  {
    return ResumeMedisController::actionGetDataObatPulang();
  }

  public function actionPrint($pendaftaran_id)
  {
    return ResumeMedisController::actionPrint($pendaftaran_id);
  }

  public function actionPrintResumePasien($pendaftaran_id)
  {
    return ResumeMedisController::actionPrintResumePasien($pendaftaran_id);
  }

  public function actionGetDataResumeMedis()
  {
    return ResumeMedisController::actionGetDataResumeMedis();
  }
}
