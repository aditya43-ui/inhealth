<?php
Yii::import('rekamMedis.controllers.PeminjamanBerkasRekamMedisController');
class PeminjamanLuarBerkasRMController extends PeminjamanBerkasRekamMedisController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view_luar = 'rekamMedis.views.peminjamanLuarBerkasRM.';
  public $path_view = 'rekamMedis.views.peminjamanBerkasRekamMedis.';
  public $peminjamandokumenrmtersimpan = false;

  public function actionIndex($id = null)
  {
    $format = new MyFormatter();
    if (isset($id)) {
      $model = RKPeminjamanrmT::model()->findByPk($id);
      $modPengiriman = RKDokumenpasienrmlamaV::model()->findByAttributes(array('peminjamanrm_id' => $model->peminjamanrm_id));
      if (isset($modPengiriman)) {
        $model->lokasirak_nama = $modPengiriman->lokasirak_nama;
        $model->subrak_nama = $modPengiriman->subrak_nama;
        $model->warnadokrm_namawarna = $modPengiriman->warnadokrm_namawarna;
      }
      $modRekamMedis = RKDokrekammedisM::model()->with('pasien')->findByPk($model->dokrekammedis_id);
      $model->no_rekam_medik = $modRekamMedis->pasien->no_rekam_medik;
      $model->nama_pasien = $modRekamMedis->pasien->nama_pasien;
      $model->jenis_kelamin = $modRekamMedis->pasien->jeniskelamin;
      $model->tanggal_lahir = $format->formatDateTimeForUser($modRekamMedis->pasien->tanggal_lahir);
    } else {
      $model = new RKPeminjamanrmT;
      $model->tglakandikembalikan = date('Y-m-d H:i:s');
      $model->tglpeminjamanrm = date('Y-m-d H:i:s');
    }

    if (isset($_POST['RKPeminjamanrmT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['RKPeminjamanrmT'];
        $model->nourut_pinjam = MyGenerator::noUrutPinjamRM();
        $model->tglpeminjamanrm = isset($_POST['RKPeminjamanrmT']['tglpeminjamanrm']) ? $format->formatDateTimeForDb($_POST['RKPeminjamanrmT']['tglpeminjamanrm']) : date('Y-m-d H:i:s');
        $model->tglakandikembalikan = isset($_POST['RKPeminjamanrmT']['tglakandikembalikan']) ? $format->formatDateTimeForDb($_POST['RKPeminjamanrmT']['tglakandikembalikan']) : date('Y-m-d H:i:s');
        $model->ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
          $this->peminjamandokumenrmtersimpan = true;
          $model->save();
          PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('pengirimanrm_id' => null, 'peminjamanrm_id' => $model->peminjamanrm_id));
        } else {
          $this->peminjamandokumenrmtersimpan = false;
        }

        if ($this->peminjamandokumenrmtersimpan) {
          $transaction->commit();
          $this->redirect(array('index', 'id' => $model->peminjamanrm_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Peminjaman Dokumen Rekam Medis gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data Peminjaman Dokumen Rekam Medis gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view_luar . 'index', array(
      'model' => $model
    ));
  }
}
