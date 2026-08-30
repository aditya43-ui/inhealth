<?php
class AnamnesaRDController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $modAnamnesa = new AnamnesaT;
    if (isset($_POST['AnamnesaT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modAnamnesa->attributes = $_POST['AnamnesaT'];
        $modAnamnesa->pegawai_id = $_POST['AnamnesaT']['pegawai_id'];
        $modAnamnesa->pendaftaran_id = $_POST['pendaftaran_id'];
        $modAnamnesa->pasien_id = $_POST['pasien_id'];
        $modAnamnesa->tglanamnesis = $format->formatDateTimeForDb($_POST['AnamnesaT']['tglanamnesis']);
        $modAnamnesa->keluhanutama = (count((array)$_POST['AnamnesaT']['keluhanutama']) > 0) ? implode(', ', $_POST['AnamnesaT']['keluhanutama']) : '';
        $modAnamnesa->keluhantambahan = (count((array)$_POST['AnamnesaT']['keluhantambahan']) > 0) ? implode(', ', $_POST['AnamnesaT']['keluhantambahan']) : '';
        $modAnamnesa->save();
        $updateStatusPeriksa = PendaftaranT::model()->updateByPk($_POST['pendaftaran_id'], array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
        $transaction->commit();
        Yii::app()->user->setFlash('success', "Data Anamnesa Pasien " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . " berhasil disimpan");
        //                    $this->redirect($_POST['url']);       
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modAnamnesa->tglanamnesis = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modAnamnesa->tglanamnesis, 'yyyy-MM-dd hh:mm:ss')
    );

    $modDataDiagnosa = new SADiagnosaM('search');
    $modDataDiagnosa->unsetAttributes();
    if (isset($_GET['SADiagnosaM']))
      $modDataDiagnosa->attributes = $_GET['SADiagnosaM'];

    $this->render('index', array(
      'modAnamnesa' => $modAnamnesa,
      'modDiagnosa' => $modDiagnosa,
      'modDataDiagnosa' => $modDataDiagnosa,
    ));
  }
}
