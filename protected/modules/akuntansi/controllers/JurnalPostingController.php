<?php

class JurnalPostingController extends MyAuthController
{
  protected $path_view = 'akuntansi.views.jurnalPosting.';
  public $success = true, $pesan = "";

  public function actionIndexPosting()
  {
    $model = new AKInformasijurnaltransaksiV();
    $model->tgl_awal = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
    $model->tgl_akhir = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
    if (isset($_GET['AKInformasijurnaltransaksiV'])) {
      $model->attributes = $_GET['AKInformasijurnaltransaksiV'];
      $model->tgl_awal = isset($_GET['AKInformasijurnaltransaksiV']['tgl_awal']) ? MyFormatter::formatDateTimeForDb($_GET['AKInformasijurnaltransaksiV']['tgl_awal']) : null;
      $model->tgl_akhir = isset($_GET['AKInformasijurnaltransaksiV']['tgl_akhir']) ? MyFormatter::formatDateTimeForDb($_GET['AKInformasijurnaltransaksiV']['tgl_akhir']) : null;
    }

    if (isset($_POST['AKInformasijurnaltransaksiV'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $data = array();
        foreach ($_POST['AKInformasijurnaltransaksiV'] as $key => $value) {
          if (isset($value['cekList'])) {
            $criteria = new CDbCriteria();
            $criteria->addCondition("DATE(tglperiodeposting_awal) <= '" . date("Y-m-d") . "' AND DATE(tglperiodeposting_akhir) >= '" . date("Y-m-d") . "'");

            $format = new MyFormatter();
            $data[] = $value['jurnaldetail_id'];
            $modPosting = new AKJurnalpostingT();
            $modPosting->tgljurnalpost = date("Y-m-d H:i:s");
            $modPosting->periodeposting_id = PeriodepostingM::model()->find($criteria)->periodeposting_id;
            $modPosting->jurnaldetail_id = $value['jurnaldetail_id'];
            $modPosting->keterangan = $value['urianjurnal'];
            $modPosting->create_time = date("Y-m-d H:i:s");
            $modPosting->create_loginpemekai_id = Yii::app()->user->id;
            $modPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
            if ($modPosting->validate()) {
              $modPosting->save();
              $this->success = true;
            } else {
              $this->pesan = $modPosting->getErrors();
              $this->success = false;
            }
            $parameter = array(
              'jurnalposting_id' => $modPosting->jurnalposting_id,
              'koreksi' => true,
            );
            $id = $key;
            $updateDetail = true;
            if ($updateDetail == true && $this->success) {
              $update = JurnaldetailT::model()->updateByPk($key, $parameter);
            } else {
              echo "Jurnal Detail gagal di update";
            }
          }
        }
        if ($this->success && $update) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('indexPosting', 'sukses' => 1));
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        echo $exc;
        $this->pesan = $exc;
        $this->success = false;
      }
    }

    $this->render($this->path_view . 'indexPosting', array('model' => $model));
  }
}
