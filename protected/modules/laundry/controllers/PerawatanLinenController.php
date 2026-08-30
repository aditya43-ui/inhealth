<?php

/**
 * controller utama untuk mengakses fungsi - fungsi pada transaksi perawatan linen
 * @package application.modules.laundry
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 */
class PerawatanLinenController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'laundry.views.perawatanLinen.';
  public $perawatanlinentersimpan = false;
  public $perawatanlinendetailtersimpan = true;
  public $perawatanbahantersimpan = true;

  /**
   * action utama untuk mengakses menu perawatan linen
   * @param type $perawatanlinen_id
   */
  public function actionIndex($perawatanlinen_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Perawatan Linen";
    $format = new MyFormatter();
    $modPenerimaanLinen = new LAPenerimaanlinenT;
    $modPenerimaanLinenDetail = new LAPenerimaanlinendetailT('searchPenerimaanLinenDetail');
    $modPenerimaanLinenDetail->tgl_awal = date('Y-m-d');
    $modPenerimaanLinenDetail->tgl_akhir = date('Y-m-d');
    $modPenerimaanLinenDetail->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modPenerimaanLinenDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPenerimaanLinenDetail->jenisperawatanlinen = Params::JENISPERAWATAN_PERAWATAN;
    $modPerawatanLinen = new LAPerawatanlinenT;
    $modPerawatanLinen->tglperawatanlinen = date('Y-m-d H:i:s');
    $modPerawatanLinen->noperawatan = '-- Otomatis --';
    $modPerawatanLinenDetail = array();
    $modPerawatanBahan = array();

    if (isset($_GET['penerimaanlinen_id'])) {
      $modPenerimaanLinen = LAPenerimaanlinenT::model()->findbyPk($_GET['penerimaanlinen_id']);
      $ruanganMod = RuanganM::model()->findbyPk($modPenerimaanLinen->ruangan_id);
      $instalasiMod = InstalasiM::model()->findByAttributes(array('instalasi_id' => $ruanganMod->instalasi_id));
      $modPenerimaanLinen->tglpenerimaanlinen = $format->formatDateTimeForUser($modPenerimaanLinen->tglpenerimaanlinen);
      $modPenerimaanLinen->instalasi_nama =  $instalasiMod->instalasi_nama;
      $modPenerimaanLinen->ruangan_nama =  $ruanganMod->ruangan_nama;
      $modPenerimaanLinenDetail->instalasi_id = $instalasiMod->instalasi_id;
      $modPenerimaanLinenDetail->ruangan_id = $ruanganMod->ruangan_id;
      $modPenerimaanLinenDetail->nopenerimaanlinen = $modPenerimaanLinen->nopenerimaanlinen;
    }

    if (!empty($perawatanlinen_id)) {
      $modPerawatanLinen = LAPerawatanlinenT::model()->findByPk($perawatanlinen_id);
      $modPerawatanLinen->pegperawat_nama = !empty($modPerawatanLinen->pegperawatan->NamaLengkap) ? $modPerawatanLinen->pegperawatan->NamaLengkap : "";
      $modPerawatanLinen->pegmengetahui_nama = !empty($modPerawatanLinen->pegmengetahui->NamaLengkap) ? $modPerawatanLinen->pegmengetahui->NamaLengkap : "";
      $modPerawatanLinenDetail = LAPerawatanlinendetailT::model()->findAllByAttributes(array('perawatanlinen_id' => $perawatanlinen_id));

      $modDetalsRuangan = LAPerawatanlinendetailT::model()->findByAttributes(array('perawatanlinen_id' => $perawatanlinen_id));
      //			$instalasiID = RuanganM::model()->findByPk($modDetalsRuangan->ruangan_id);
      //			$modPenerimaanLinenDetail->instalasi_id = $instalasiID->instalasi_id;
      //			$modPenerimaanLinenDetail->ruangan_id = $modDetalsRuangan->ruangan_id;
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

        $modPerawatanLinen->iskirimkeluar = $_POST['LAPerawatanlinenT']['iskirimkeluar'];
        if ($modPerawatanLinen->iskirimkeluar == 1) {
          $modPerawatanLinen->iskirimkeluar = true;
          $modPerawatanLinen->tglkirimkeluar = date('Y-m-d H:i:s');
          if (!empty($_POST['LAPerawatanlinenT']['tglkirimkeluar'])) {
            $tglkirim = $format->formatDateTimeForDb($_POST['LAPerawatanlinenT']['tglkirimkeluar']);
            $timekirim = date("H:i:s");
            $modPerawatanLinen->tglkirimkeluar = $tglkirim . " " . $timekirim;
          }

          //                                    $modPerawatanLinen->tglkirimkeluar=!empty($_POST['LAPerawatanlinenT']['tglkirimkeluar']) ? $format->formatDateTimeForDb($_POST['LAPerawatanlinenT']['tglkirimkeluar']) : date('Y-m-d H:i:s');
          $modPerawatanLinen->alasankirimkeluar = $_POST['LAPerawatanlinenT']['alasankirimkeluar'];
          $modPerawatanLinen->ketkirimkeluar = $_POST['LAPerawatanlinenT']['ketkirimkeluar'];
        } else {
          $modPerawatanLinen->iskirimkeluar = false;
          $modPerawatanLinen->tglkirimkeluar = null;
          $modPerawatanLinen->alasankirimkeluar = "";
          $modPerawatanLinen->ketkirimkeluar = "";
        }


        if ($modPerawatanLinen->save()) {
          $this->perawatanlinentersimpan = true;

          if (isset($_POST['LAPerawatanlinendetailT'])) {
            if (count((array)$_POST['LAPerawatanlinendetailT']) > 0) {
              foreach ($_POST['LAPerawatanlinendetailT'] as $i => $detail) {
                if (isset($detail['checklist']) && $detail['checklist'] == 1) {
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

  /**
   * simpan LAPerawatanlinendetailT
   * @param type $modPerawatanLinenDetail
   * @param type $detail
   * @return \LAPerawatanlinendetailT
   */
  public function simpanPerawatanDetail($modPerawatanLinen, $detail)
  {
    $format = new MyFormatter();
    $modPerawatanDetail = new LAPerawatanlinendetailT;
    $modPerawatanDetail->attributes = $detail;
    $modPerawatanDetail->perawatanlinen_id = $modPerawatanLinen->perawatanlinen_id;
    //		$modPerawatanDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPerawatanDetail->ruangan_id = $detail['ruangan_id'];
    //		$modPerawatanDetail->jenisperawatan = Yii::app()->user->getState('ruangan_id');
    $modPerawatanDetail->jenisperawatan = Params::JENISPERAWATAN_PERAWATAN;

    if ($modPerawatanDetail->validate()) {
      $modPerawatanDetail->save();
      $this->perawatanlinendetailtersimpan &= true;
    } else {
      $this->perawatanlinentersimpan &= false;
    }
    return $modPerawatanDetail;
  }

  /**
   * simpan LAPerawatanbahanT
   * @param type $modPerawatanBahan
   * @param type $bahan
   * @return \LAPerawatanbahanT
   */
  public function simpanPerawatanBahan($modPerawatanLinen, $bahan)
  {
    $format = new MyFormatter();
    $modPerawatanBahan = new LAPerawatanbahanT;
    $modPerawatanBahan->attributes = $bahan;
    $modPerawatanBahan->perawatanlinen_id = $modPerawatanLinen->perawatanlinen_id;

    if ($modPerawatanBahan->validate()) {
      $modPerawatanBahan->save();
      $this->perawatanbahantersimpan &= true;
    } else {
      $this->perawatanbahantersimpan &= false;
    }
    return $modPerawatanBahan;
  }
  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(LARuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * load data pegawai sesuai yang diketikkan
   */
  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = LAPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * load bahan perawatan sesuai yang diketikkan
   */
  public function actionAutocompleteBahanPerawatan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(bahanperawatan_nama)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = LABahanperawatanM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->bahanperawatan_jenis . "-" . $model->bahanperawatan_nama;
        $returnVal[$i]['value'] = $model->bahanperawatan_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * load detail bahan perawatan
   */
  public function actionSetFormDetailBahanPerawatan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $bahanperawatan_id = isset($_POST['bahanperawatan_id']) ? $_POST['bahanperawatan_id'] : null;
      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : null;
      $satuan = isset($_POST['satuan']) ? $_POST['satuan'] : null;
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modBahanPerawatan = LABahanperawatanM::model()->findByPk($bahanperawatan_id);
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modPerawatanbahan = array();
      if ($modBahanPerawatan) {
        $modPerawatanbahan = new LAPerawatanbahanT;
        $modPerawatanbahan->bahanperawatan_id = $modBahanPerawatan->bahanperawatan_id;
        $modPerawatanbahan->jmlbahanpemakaian = $jumlah;
        $modPerawatanbahan->satuanpemakaian = $satuan;
        $modPerawatanbahan->bahanperawatan_nama = $modBahanPerawatan->bahanperawatan_nama;
        $form = $this->renderPartial($this->path_view . '_rowBahanLinen', array('modDetail' => $modPerawatanbahan), true);
      } else {
        $pesan = "Obat alkes tidak ada!";
      }
      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * untuk print data perawatan linen
   */
  public function actionPrint($perawatanlinen_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $modPerawatan = LAPerawatanlinenT::model()->findByPk($perawatanlinen_id);
    $modPerawatanDetail = LAPerawatanlinendetailT::model()->findAllByAttributes(array('perawatanlinen_id' => $perawatanlinen_id));
    $modPerawatanBahan = array();

    if (isset($modPerawatan)) {
      if ($modPerawatan->iskirimkeluar != true) {
        $modPerawatanBahan = LAPerawatanbahanT::model()->findAllByAttributes(array('perawatanlinen_id' => $perawatanlinen_id));
      }
    }
    $judul_print = 'Perawatan Linen';

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPerawatan' => $modPerawatan,
      'modPerawatanDetail' => $modPerawatanDetail,
      'modPerawatanBahan' => $modPerawatanBahan,
      'caraprint' => $caraprint
    ));
  }
}
