<?php

/**
 * controller utama untuk mengakses fungsi - fungsi pada transaksi penyimpanan linen
 * @package application.modules.laundry
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 */
class PenyimpananLinenController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'laundry.views.penyimpananLinen.';
  public $penyimpananlinentersimpan = true;
  public $penyimpananlinendetailtersimpan = true;

  /**
   * action ini digunakan untuk masuk ke menu transaksi penyimpanan linen
   * @param type $penyimpananlinen_id
   */
  public function actionIndex($penyimpananlinen_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Penyimpanan Linen";
    $format = new MyFormatter();
    $modPenyimpananLinen = new LAPenyimpananlinenT;
    $modPenyimpananLinen->tglpenyimpananlinen = date('Y-m-d H:i:s');
    //		$modPenyimpananLinen->nopenyimpamanlinen = "-- Otomatis --";
    $modPenyimpananLinen->nopenyimpananlinen = "-- Otomatis --";
    $modPenyimpananLinenDetail = array();
    //		$modInfoPencucian = new LAPencuciandetailT('searchPencucianLinen');
    $modInfoPencucian = new PenyimpananlinendetailV('searchPenyimpanan');
    $modInfoPencucian->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modInfoPencucian->tgl_awal = date('Y-m-d');
    $modInfoPencucian->tgl_akhir = date('Y-m-d');
    $instalasiTujuans = CHtml::listData(LAInstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(LARuanganM::getRuanganByInstalasi($modInfoPencucian->instalasi_id), 'ruangan_id', 'ruangan_nama');

    if (isset($_GET['pencucianlinen_id'])) {
      $modPencucianT = PencucianlinenT::model()->findByPk($_GET['pencucianlinen_id']);
      $modInfoPencucian = PenyimpananlinendetailV::model()->findByAttributes(array('no_linen' => $modPencucianT->nopencucianlinen, 'tgl_linen' => $modPencucianT->tglpencucianlinen));
      $modInfoPencucian->tgl_awal = $format->formatDateTimeForUser($modInfoPencucian->tgl_linen);
      $modInfoPencucian->tgl_akhir = $format->formatDateTimeForUser($modInfoPencucian->tgl_linen);
      $ruanganModM = RuanganM::model()->findByPk($modInfoPencucian->ruangan_id);
      $modInfoPencucian->ruangan_nama = $ruanganModM->ruangan_nama;
      $instalasiModM = InstalasiM::model()->findByPk($ruanganModM->instalasi_id);
      $modInfoPencucian->instalasi_id = $instalasiModM->instalasi_id;
      $modInfoPencucian->instalasi_nama = $instalasiModM->instalasi_nama;
    }
    if (isset($_GET['perawatanlinen_id'])) {
      $modPerawatanT = PerawatanlinenT::model()->findByPk($_GET['perawatanlinen_id']);
      $modInfoPencucian = PenyimpananlinendetailV::model()->findByAttributes(array('no_linen' => $modPerawatanT->noperawatan, 'tgl_linen' => $modPerawatanT->tglperawatanlinen));
      $modInfoPencucian->tgl_awal = $format->formatDateTimeForUser($modInfoPencucian->tgl_linen);
      $modInfoPencucian->tgl_akhir = $format->formatDateTimeForUser($modInfoPencucian->tgl_linen);
      $ruanganModM = RuanganM::model()->findByPk($modInfoPencucian->ruangan_id);
      $modInfoPencucian->ruangan_nama = $ruanganModM->ruangan_nama;
      $instalasiModM = InstalasiM::model()->findByPk($ruanganModM->instalasi_id);
      $modInfoPencucian->instalasi_id = $instalasiModM->instalasi_id;
      $modInfoPencucian->instalasi_nama = $instalasiModM->instalasi_nama;
    }



    if (!empty($penyimpananlinen_id)) {
      $modPenyimpananLinen = LAPenyimpananlinenT::model()->findByPk($penyimpananlinen_id);
      $modPenyimpananLinen->pegmengetahui_nama = !empty($modPenyimpananLinen->pegmengetahui->NamaLengkap) ? $modPenyimpananLinen->pegmengetahui->NamaLengkap : "";
      $modPenyimpananLinenDetail = LAPenyimpananlinendetT::model()->findAllByAttributes(array('penyimpananlinen_id' => $modPenyimpananLinen->penyimpananlinen_id));
    }

    if (isset($_POST['LAPenyimpananlinenT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modPenyimpananLinen->attributes = $_POST['LAPenyimpananlinenT'];
        $modPenyimpananLinen->nopenyimpananlinen = MyGenerator::noPenyimpananLinen();
        $modPenyimpananLinen->tglpenyimpananlinen = $format->formatDateTimeForDb($_POST['LAPenyimpananlinenT']['tglpenyimpananlinen']);
        $modPenyimpananLinen->petugas_id = Yii::app()->user->id;
        $modPenyimpananLinen->create_time = date('Y-m-d H:i:s');
        $modPenyimpananLinen->update_time = date('Y-m-d H:i:s');
        $modPenyimpananLinen->create_loginpemakai_id = Yii::app()->user->id;
        $modPenyimpananLinen->update_loginpemakai_id = Yii::app()->user->id;
        $modPenyimpananLinen->create_ruangan = Yii::app()->user->ruangan_id;

        if ($modPenyimpananLinen->save()) {
          $this->penyimpananlinentersimpan = true;
          if (isset($_POST['LAPenyimpananlinendetT'])) {
            if (count((array)$_POST['LAPenyimpananlinendetT']) > 0) {
              foreach ($_POST['LAPenyimpananlinendetT'] as $i => $post) {
                if (isset($post['checklist']) && $post['checklist'] == 1) {
                  $modPenyimpananLinenDetail[$i] = $this->simpanPenyimpananLinenDetail($modPenyimpananLinen, $post);
                }
              }
            }
          } else {
            $this->penyimpananlinendetailtersimpan = false;
          }
        }

        if ($this->penyimpananlinentersimpan && $this->penyimpananlinendetailtersimpan) {
          $transaction->commit();
          $modPenyimpananLinen->isNewRecord = FALSE;
          $this->redirect(array('index', 'penyimpananlinen_id' => $modPenyimpananLinen->penyimpananlinen_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Penyimpanan Linen gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penyimpanan Linen gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    if (isset($_GET['PenyimpananlinendetailV'])) {
      $modInfoPencucian->unsetAttributes();
      $modInfoPencucian->attributes  = $_GET['PenyimpananlinendetailV'];
      $modInfoPencucian->tgl_awal    = $format->formatDateTimeForDb($_GET['PenyimpananlinendetailV']['tgl_awal']);
      $modInfoPencucian->tgl_akhir  = $format->formatDateTimeForDb($_GET['PenyimpananlinendetailV']['tgl_akhir']);
      $modInfoPencucian->no_linen  = $_GET['PenyimpananlinendetailV']['no_linen'];
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modPenyimpananLinen' => $modPenyimpananLinen,
      'modPenyimpananLinenDetail' => $modPenyimpananLinenDetail,
      'modInfoPencucian' => $modInfoPencucian,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
    ));
  }

  /**
   * simpan LAPenyimpananlinendetT
   * @param type $modPenyimpananLinenDetail
   * @param type $detail
   * @return \LAPenyimpananlinendetT
   */
  public function simpanPenyimpananLinenDetail($modPenyimpananLinen, $detail)
  {
    $format = new MyFormatter();
    $modPenyimpananLinenDetail = new LAPenyimpananlinendetT();
    $modPenyimpananLinenDetail->attributes = $detail;
    $modPenyimpananLinenDetail->penyimpananlinen_id = $modPenyimpananLinen->penyimpananlinen_id;
    //        $modPenyimpananLinenDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPenyimpananLinenDetail->ruangan_id = $detail['ruangan_id'];
    $modPenyimpananLinenDetail->keterangan_penyimpaanlinen = $detail['keterangan_penyimpananlinen'];

    if ($modPenyimpananLinenDetail->validate()) {
      $modPenyimpananLinenDetail->save();
      $this->penyimpananlinendetailtersimpan &= true;
    } else {
      $this->penyimpananlinendetailtersimpan &= false;
    }

    return $modPenyimpananLinenDetail;
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
   * untuk print data perawatan linen
   */
  public function actionPrint($penyimpananlinen_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $modPenyimpananLinen = LAPenyimpananlinenT::model()->findByPk($penyimpananlinen_id);
    $modPenyimpananLinenDetail = LAPenyimpananlinendetT::model()->findAllByAttributes(array('penyimpananlinen_id' => $modPenyimpananLinen->penyimpananlinen_id));

    $judul_print = 'Penyimpanan Linen';

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPenyimpananLinen' => $modPenyimpananLinen,
      'modPenyimpananLinenDetail' => $modPenyimpananLinenDetail,
      'caraprint' => $caraprint
    ));
  }


  /**
   * load data sesuai dari lokasi rak
   */
  public function actionAjaxGetRakDariLokasi()
  {
    if (!Yii::app()->request->isAjaxRequest || !isset($_POST['id'])) {
      Yii::app()->end();
    }

    $rak = RakpenyimpananM::model()->findAllByAttributes(array(
      'lokasipenyimpanan_id' => $_POST['id']
    ), array(
      'order' => 'rakpenyimpanan_nama',
    ));

    $tr = '';
    if (!empty($rak)) {
      $tr .= '<option value="">-- Pilih --</option>';
      foreach ($rak as $item) {
        $tr .= '<option value="' . $item->rakpenyimpanan_id . '">' . $item->rakpenyimpanan_nama . '</option>';
      }
    } else {
      $tr .= '<option value="">-- Pilih --</option>';
    }

    echo CJSON::encode(array('list' => $tr));
  }
}
