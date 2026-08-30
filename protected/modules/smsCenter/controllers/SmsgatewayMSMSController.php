<?php

Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.SmsgatewayMController');

class SmsgatewayMSMSController extends SmsgatewayMController
{
  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    return SmsgatewayMController::actionView($id);
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate()
  {
    return SmsgatewayMController::actionCreate();
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    return SmsgatewayMController::actionUpdate($id);
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    return SmsgatewayMController::actionDelete($id);
  }

  /**
   * Memanggil dan menonaktifkan status 
   */
  public function actionNonActive($id)
  {
    return SmsgatewayMController::actionNonActive($id);
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    return SmsgatewayMController::actionIndex();
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    return SmsgatewayMController::actionAdmin();
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    return SmsgatewayMController::actionPrint();
  }

  public function actionGetControllers($encode = false)
  {
    return SmsgatewayMController::actionGetControllers($encode);
  }

  public function actionGetActions($encode = false)
  {
    return SmsgatewayMController::actionGetActions($encode);
  }

  public function actionAutocompleteGetActions()
  {
    return SmsgatewayMController::actionAutocompleteGetActions();
  }
}
