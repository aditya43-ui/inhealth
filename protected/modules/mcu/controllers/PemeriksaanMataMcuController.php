<?php
Yii::import('rawatJalan.models.*');
class PemeriksaanMataMcuController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $periksakacamatatersimpan = false;
  public $ukurankacamatatersimpan = false;
  protected $path_view = 'mcu.views.pemeriksaanMataMcu.';

  public function actionIndex($pendaftaran_id, $id = null)
  {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPeriksaKacamata = new MCPeriksakacamataT();
    $modUkuranKacamata = new MCUkurankacamataT();
    $modPeriksaKacamata->jatuhtempo_kacamata = date('Y-m-d H:i:s');
    $modPeriksaKacamata->tglperiksakacamata = date('Y-m-d H:i:s');
    $modDetails = array();

    if (!empty($id)) {
      $modPeriksaKacamata = MCPeriksakacamataT::model()->findByPk($id);
    }

    if (isset($_POST['MCPeriksakacamataT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPeriksaKacamata = $this->simpanKacamata($modPendaftaran, $modPeriksaKacamata, $_POST['MCPeriksakacamataT']);
        if (count((array)$_POST['MCUkurankacamataT']) > 0) {
          foreach ($_POST['MCUkurankacamataT'] as $i => $details) {
            $modDetails[$i] = $this->simpanUkuranKacamata($_POST['MCUkurankacamataT'], $details, $modPeriksaKacamata);
          }
        }

        if ($this->periksakacamatatersimpan && $this->ukurankacamatatersimpan) {
          $transaction->commit();
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'id' => $modPeriksaKacamata->periksakacamata_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pemeriksaan Kacamata gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data Pemeriksaan Kacamata gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPeriksaKacamata' => $modPeriksaKacamata,
      'modUkuranKacamata' => $modUkuranKacamata
    ));
  }

  /**
   * proses simpan data periksa kacamata
   * @param type $model
   * @param type $post
   * @return type
   */
  public function simpanKacamata($modPendaftaran, $post, $modPeriksaKacamata)
  {
    $format = new MyFormatter();
    $modPeriksaKacamata = new MCPeriksakacamataT;
    $modPeriksaKacamata->attributes = $_POST['MCPeriksakacamataT'];
    $modPeriksaKacamata->pasien_id = $modPendaftaran->pasien_id;
    $modPeriksaKacamata->ruangan_id = $modPendaftaran->ruangan_id;
    $modPeriksaKacamata->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modPeriksaKacamata->pegawai_id = $modPendaftaran->pegawai_id;
    $modPeriksaKacamata->tglperiksakacamata = $format->formatDateTimeForDb($post['tglperiksakacamata']);
    $modPeriksaKacamata->jatuhtempo_kacamata = $format->formatDateTimeForDb($post['jatuhtempo_kacamata']);
    $modPeriksaKacamata->create_time = date('Y-m-d H:i:s');
    $modPeriksaKacamata->create_loginpemakai_id = Yii::app()->user->id;
    $modPeriksaKacamata->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modPeriksaKacamata->validate()) {
      $modPeriksaKacamata->save();
      $this->periksakacamatatersimpan = true;
    }

    return $modPeriksaKacamata;
  }

  /**
   * simpan TreadmilldetailT
   * @param type $model
   * @param type $postKacamata
   * @return \TreadmilldetailT
   */
  protected function simpanUkuranKacamata($postUkuranKacamata, $details, $postPeriksaKacamata)
  {

    $format = new MyFormatter;
    $modUkuranKacamata = new MCUkurankacamataT();
    $modUkuranKacamata->attributes = $details;
    $modUkuranKacamata->periksakacamata_id = $postPeriksaKacamata->periksakacamata_id;

    if ($modUkuranKacamata->validate()) {
      $modUkuranKacamata->save();
      $this->ukurankacamatatersimpan = true;
    } else {
      $this->ukurankacamatatersimpan = false;
    }
    return $modUkuranKacamata;
  }

  /**
   * untuk print data treadmill
   */
  public function actionPrint($periksakacamata_id, $pendaftaran_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modPeriksaKacamata = MCPeriksakacamataT::model()->findByPk($periksakacamata_id);
    $modUkuranKacamata = MCUkurankacamataT::model()->findAllByAttributes(array('periksakacamata_id' => $periksakacamata_id), array('order' => 'ukurankacamata_id asc'));
    $modPendaftaran = MCPendaftaranT::model()->findByPk($modPeriksaKacamata->pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $judul_print = 'UKURAN KACAMATA <br/> Dubbel Focus <br/> Biasa';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else if ($caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/iframeNeon';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPeriksaKacamata' => $modPeriksaKacamata,
      'modUkuranKacamata' => $modUkuranKacamata,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'caraPrint' => $caraPrint
    ));
  }
}
