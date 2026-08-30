<?php

class InformasiRencanaPenerimaanPiutangController extends MyAuthController
{
  public $layout = '//layouts/column1';

  public function actionIndex()
  {
    $format = new MyFormatter();

    $modKlaimPiutang = new KUPengajuanklaimpiutangT;
    $modKlaimPiutang->tgl_awalPengajuan = date("d-m-Y");
    $modKlaimPiutang->tgl_akhirPengajuan = date("d-m-Y");
    $modKlaimPiutang->tgl_awalJatuhTempo = date("d-m-Y H:i:s");
    $modKlaimPiutang->tgl_akhirJatuhTempo = date("d-m-Y H:i:s");
    $modKlaimDetail = new KUPengajuanklaimdetailT('searchInformasi');
    $modKlaimDetail->unsetAttributes();  // clear any default values
    if (isset($_GET['KUPengajuanklaimpiutangT'])) {
      $modKlaimDetail->attributes = $_GET['KUPengajuanklaimpiutangT'];
      $modKlaimDetail->tgl_awalPengajuan = $format->formatDateTimeForDb($_GET['KUPengajuanklaimpiutangT']['tgl_awalPengajuan']);
      $modKlaimDetail->tgl_akhirPengajuan = $format->formatDateTimeForDb($_GET['KUPengajuanklaimpiutangT']['tgl_akhirPengajuan']);
      if ($_GET['berdasarkanJatuhTempo'] > 0) {
        $modKlaimDetail->tgl_awalJatuhTempo = $format->formatDateTimeForDb($_GET['KUPengajuanklaimpiutangT']['tgl_awalJatuhTempo']);
        $modKlaimDetail->tgl_akhirJatuhTempo = $format->formatDateTimeForDb($_GET['KUPengajuanklaimpiutangT']['tgl_akhirJatuhTempo']);
      } else {
        $modKlaimDetail->tgl_awalJatuhTempo = null;
        $modKlaimDetail->tgl_akhirJatuhTempo = null;
      }
      $modKlaimDetail->carabayar_id = $_GET['KUPengajuanklaimpiutangT']['carabayar_id'];
      $modKlaimDetail->penjamin_id = $_GET['KUPengajuanklaimpiutangT']['penjamin_id'];
    }

    $this->render('index', array(
      'modKlaimDetail' => $modKlaimDetail,
      'modKlaimPiutang' => $modKlaimPiutang,
    ));
  }

  public function actionGetPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
