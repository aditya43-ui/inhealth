<?php
class PengajuanPenggantianKacamataController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "mcu.views.pengajuanPenggantianKacamata.";

  public $pengajuankacamatatersimpan = false;

  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null)
  {
    $format = new MyFormatter();
    $model = new MCPengajuangantikmT();
    $modPengajuan = array();
    $modGantiKacamata = new MCGantikacamataT('searchGantiKacamata');
    $modGantiKacamata->tgl_awal = date('Y-m-d H:i:s');
    $modGantiKacamata->tgl_akhir = date('Y-m-d H:i:s');
    $model->tglpengajuan_km = date('Y-m-d H:i:s');

    if (isset($_POST['MCPengajuangantikmT'])) {
      if (isset($_POST['MCGantikacamataT'])) {
        $transaction = Yii::app()->db->beginTransaction();
        if (count((array)$_POST['MCGantikacamataT']) > 0) {
          foreach ($_POST['MCGantikacamataT'] as $i => $details) {
            if (isset($details['cekList'])) {
              $modPengajuan[$i] = $this->simpanPengambilanKacamata($_POST['MCPengajuangantikmT'], $details, $_POST['MCGantikacamataT']);
            }
          }
        }
        try {
          if ($this->pengajuankacamatatersimpan) {
            $transaction->commit();
            $this->redirect(array('index', 'id' => $_POST['MCPengajuangantikmT']['no_pengajuan'], 'sukses' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data pengajuan kacamata gagal disimpan !");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
            . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
            . "</a>";
          Yii::app()->user->setFlash('error', "Data pengajuan kacamata gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
        }
      } else {
        Yii::app()->user->setFlash('error', "Tabel pergantian kacamata tidak boleh kosong !");
      }
    }

    if (isset($_GET['MCGantikacamataT'])) {
      $modGantiKacamata->unsetAttributes();
      $modGantiKacamata->attributes = $_GET['MCGantikacamataT'];
      $modGantiKacamata->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MCGantikacamataT']['tgl_awal']);
      $modGantiKacamata->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MCGantikacamataT']['tgl_akhir']);
    }

    $this->render('index', array(
      'model' => $model,
      'modGantiKacamata' => $modGantiKacamata,
      'format' => $format
    ));
  }

  /**
   * simpan PengajuangantikmT
   * @param type $model
   * @param type $postKacamata
   * @return \PengajuangantikmT
   */
  protected function simpanPengambilanKacamata($postPengajuan, $details, $postKacamata)
  {
    $format = new MyFormatter;
    $model = new MCPengajuangantikmT;
    $model->attributes = $postPengajuan;
    $model->tglpengajuan_km = $format->formatDateTimeForDb($model->tglpengajuan_km);
    $model->tglprint_pengajuan = date('Y-m-d H:i:s');
    $model->jmlprint_pengajuan = 1;
    $model->create_time = date('Y-m-d H:i:s');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($model->validate()) {
      $model->save();
      $modGantiKacamata = MCGantikacamataT::model()->findByPk($details['gantikacamata_id']);
      $modGantiKacamata->pengajuangantikm_id = $model->pengajuangantikm_id;
      $modGantiKacamata->save();
      $this->pengajuankacamatatersimpan = true;
    } else {
      $this->pengajuankacamatatersimpan = false;
    }
    return $model;
  }
}
