<?php
class InformasiAbnormalAbsenController extends MyAuthController
{
  public $layout = '//layouts/column1';
  protected $path_view = "kepegawaian.views.informasiAbnormalAbsen.";
  
  public function actionIndex()
  {
    $model = new AbnormalabsenT();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tglpersensi_awal = date('Y-m-d');
    $model->tglpersensi_akhir = date('Y-m-d');
    $model->ceklis = false;

    if (isset($_GET['AbnormalabsenT'])) {
      $model->attributes = $_GET['AbnormalabsenT'];
      $model->ceklis = $_GET['AbnormalabsenT']['ceklis'];
      $model->tgl_awal = $format->formatDateTimeForDB($_GET['AbnormalabsenT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDB($_GET['AbnormalabsenT']['tgl_akhir']);
      $model->tglpersensi_awal = $format->formatDateTimeForDB($_GET['AbnormalabsenT']['tglpersensi_awal']);
      $model->tglpersensi_akhir = $format->formatDateTimeForDB($_GET['AbnormalabsenT']['tglpersensi_akhir']);
      $model->nomorindukpegawai = $_GET['AbnormalabsenT']['nomorindukpegawai'];
      $model->nama_pegawai = $_GET['AbnormalabsenT']['nama_pegawai'];
      $model->nama_unitkerja = $_GET['AbnormalabsenT']['nama_unitkerja'];
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }

  public function actionApprove($abnormalabsen_id, $type, $approve_status = null)
  {
    $this->layout = '//layouts/iframe';
    $model = AbnormalabsenT::model()->findByAttributes(array('abnormalabsen_id' => $abnormalabsen_id));

    if($type == 'mengetahui'){
      if ($approve_status == Params::STATUS_ABNORMALABSEN_DISETUJUI) {
        $update = AbnormalabsenT::model()->updateByPk($abnormalabsen_id, array('tglmengetahui' => date("Y-m-d H:i:s")));
        if ($update) {
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('Approve', 'abnormalabsen_id' => $abnormalabsen_id, 'type'=>$type, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
        }
      }
    }else if($type == 'menyetujui'){
      if ($approve_status == Params::STATUS_ABNORMALABSEN_DISETUJUI) {
        $update = AbnormalabsenT::model()->updateByPk($abnormalabsen_id, array('tglmenyetujui' => date("Y-m-d H:i:s"), 'statuspersetujuan' => $approve_status));
        if ($update) {
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('Approve', 'abnormalabsen_id' => $abnormalabsen_id, 'type'=>$type, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
        }
      }else if ($approve_status == Params::STATUS_ABNORMALABSEN_DITOLAK) {
        $update = AbnormalabsenT::model()->updateByPk($abnormalabsen_id, array('tglmenyetujui' => date("Y-m-d H:i:s"), 'statuspersetujuan' => $approve_status));
        if ($update) {
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('Approve', 'abnormalabsen_id' => $abnormalabsen_id, 'type'=>$type, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
        }
      }
    }

    $this->render($this->path_view . '_pegawaiApprove', array(
      'model' => $model,
      'type'=>$type
    ));
  }

}
