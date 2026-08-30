<?php
class PerawatanLinenLangsungController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'laundry.views.perawatanLinenLangsung.';
  public $path_view_tips = 'laundry.views.perawatanLinen.';
  public $perawatanlinentersimpan = false;
  public $perawatanlinendetailtersimpan = true;
  public $perawatanbahantersimpan = true;

  public function actionIndex($perawatanlinen_id = null)
  {
    $format = new MyFormatter();
    $modPenerimaanLinen = new LAPenerimaanlinenT;
    $modPenerimaanLinenDetail = new LAPenerimaanlinendetailT('searchPenerimaanLinenDetail');
    $modPenerimaanLinenDetail->tgl_awal = date('Y-m-d H:i:s');
    $modPenerimaanLinenDetail->tgl_akhir = date('Y-m-d H:i:s');
    $modPenerimaanLinenDetail->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modPenerimaanLinenDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPenerimaanLinenDetail->jenisperawatanlinen = Params::JENISPERAWATAN_PERAWATAN;
    $modPerawatanLinen = new LAPerawatanlinenT;
    $modPerawatanLinen->tglperawatanlinen = date('Y-m-d H:i:s');
    $modPerawatanLinen->noperawatan = '-- Otomatis --';
    $modPerawatanLinenDetail = array();
    $modPerawatanBahan = array();

    if (!empty($perawatanlinen_id)) {
      $modPerawatanLinen = LAPerawatanlinenT::model()->findByPk($perawatanlinen_id);
      $modPerawatanLinen->pegperawat_nama = !empty($modPerawatanLinen->pegperawatan->NamaLengkap) ? $modPerawatanLinen->pegperawatan->NamaLengkap : "";
      $modPerawatanLinen->pegmengetahui_nama = !empty($modPerawatanLinen->pegmengetahui->NamaLengkap) ? $modPerawatanLinen->pegmengetahui->NamaLengkap : "";
      $modPerawatanLinenDetail = LAPerawatanlinendetailT::model()->findAllByAttributes(array('perawatanlinen_id' => $perawatanlinen_id));

      $modDetalsRuangan = LAPerawatanlinendetailT::model()->findByAttributes(array('perawatanlinen_id' => $perawatanlinen_id));
      $instalasiID = RuanganM::model()->findByPk($modDetalsRuangan->ruangan_id);
      $modPenerimaanLinenDetail->instalasi_id = $instalasiID->instalasi_id;
      $modPenerimaanLinenDetail->ruangan_id = $modDetalsRuangan->ruangan_id;
    }

    $instalasiTujuans = CHtml::listData(LAInstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(LARuanganM::getRuanganByInstalasi($modPenerimaanLinenDetail->instalasi_id), 'ruangan_id', 'ruangan_nama');

    if (isset($_POST['LAPerawatanlinenT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modPerawatanLinen->attributes = $_POST['LAPerawatanlinenT'];
        $modPerawatanLinen->noperawatan = MyGenerator::noPerawatanLinen();
        $modPerawatanLinen->tglperawatanlinen = $format->formatDateTimeForDb($_POST['LAPerawatanlinenT']['tglperawatanlinen']);
        $modPerawatanLinen->pegperawatan_id = Yii::app()->user->id;
        $modPerawatanLinen->create_time = date('Y-m-d H:i:s');
        $modPerawatanLinen->create_loginpemakai_id = Yii::app()->user->id;
        $modPerawatanLinen->create_ruangan = Yii::app()->user->ruangan_id;

        if ($modPerawatanLinen->save()) {
          $this->perawatanlinentersimpan = true;
          if (isset($_POST['LAPerawatanlinendetailT'])) {
            if (count((array)$_POST['LAPerawatanlinendetailT']) > 0) {
              foreach ($_POST['LAPerawatanlinendetailT'] as $i => $detail) {
                if ($detail['checklist'] == 1) {
                  $modPerawatanLinenDetail[$i] = $this->simpanPerawatanDetail($modPerawatanLinen, $detail);
                }
              }
            }
          }

          if (isset($_POST['LAPerawatanbahanT'])) {
            if (count((array)$_POST['LAPerawatanbahanT']) > 0) {
              foreach ($_POST['LAPerawatanbahanT'] as $i => $bahan) {
                $modPerawatanBahan[$i] = $this->simpanPerawatanBahan($modPerawatanLinen, $bahan);
              }
            }
          }
        } else {
          echo "b";
          exit;
          $this->perawatanlinentersimpan = false;
        }
        if ($this->perawatanlinentersimpan && $this->perawatanlinendetailtersimpan && $this->perawatanbahantersimpan) {
          $transaction->commit();
          $modPerawatanLinen->isNewRecord = FALSE;
          $this->redirect(array('index', 'perawatanlinen_id' => $modPerawatanLinen->perawatanlinen_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Perawatan Linen gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Perawatan Linen gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    if (isset($_GET['LAPenerimaanlinendetailT'])) {
      $modPenerimaanLinenDetail->unsetAttributes();
      $modPenerimaanLinenDetail->attributes  = $_GET['LAPenerimaanlinendetailT'];
      $modPenerimaanLinenDetail->tgl_awal    = $format->formatDateTimeForDb($_GET['LAPenerimaanlinendetailT']['tgl_awal']);
      $modPenerimaanLinenDetail->tgl_akhir  = $format->formatDateTimeForDb($_GET['LAPenerimaanlinendetailT']['tgl_akhir']);
      $modPenerimaanLinenDetail->nopenerimaanlinen  = $_GET['LAPenerimaanlinendetailT']['nopenerimaanlinen'];
      $modPenerimaanLinenDetail->ruangan_id  = $_GET['LAPenerimaanlinendetailT']['ruangan_id'];
      $modPenerimaanLinenDetail->jenisperawatanlinen  = $_GET['LAPenerimaanlinendetailT']['jenisperawatanlinen'];
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modPenerimaanLinen' => $modPenerimaanLinen,
      'modPenerimaanLinenDetail' => $modPenerimaanLinenDetail,
      'modPerawatanLinen' => $modPerawatanLinen,
      'modPerawatanLinenDetail' => $modPerawatanLinenDetail,
      'modPerawatanBahan' => $modPerawatanBahan,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
    ));
  }
}
