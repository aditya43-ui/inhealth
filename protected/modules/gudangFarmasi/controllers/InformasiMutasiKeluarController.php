<?php

class InformasiMutasiKeluarController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiMutasiKeluar.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Mutasi Obat Alkes Keluar";
    $model = new GFInformasimutasioaruanganV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $instalasiTujuans = CHtml::listData(GFInstalasiM::getInstalasiTujuanMutasis(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis(Params::INSTALASI_ID_FARMASI), 'ruangan_id', 'ruangan_nama');

    if (isset($_GET['GFInformasimutasioaruanganV'])) {
      $model->attributes = $_GET['GFInformasimutasioaruanganV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasimutasioaruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasimutasioaruanganV']['tgl_akhir']);
      $model->status_terima = $_GET['GFInformasimutasioaruanganV']['status_terima'];
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
    ));
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
        $instalasi_id = $_POST["$model_nama"]['instalasitujuanmutasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($instalasi_id), 'ruangan_id', 'ruangan_nama');

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
   * membatalkan transaksi mutasi
   */
  public function actionBatalMutasi()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $data['pesan'] = 'Mutasi gagal dibatalkan karena sudah diterima!';
      $data['sukses'] = 0;
      if (isset($_POST['mutasioaruangan_id'])) {
        $loadMutasi = MutasioaruanganT::model()->findByPk($_POST['mutasioaruangan_id']);
        if ($loadMutasi) {
          if (empty($loadMutasi->terimamutasi_id)) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
              // update pesan_oa
              $pesan = PesanobatalkesT::model()->findByAttributes(array(
                'mutasioaruangan_id' => $_POST['mutasioaruangan_id'],
              ));
              $pesan->mutasioaruangan_id = null;
              $pesan->save();

              $deletedetail = MutasioadetailT::model()->deleteAllByAttributes(array('mutasioaruangan_id' => $loadMutasi->mutasioaruangan_id));
              //untuk penghapusan stokobatalkes_t tidak perlu karna relasi sudah CASCADE
              $delete = $loadMutasi->delete();
              if ($delete && $deletedetail) {
                $transaction->commit();
                $data['pesan'] = 'Mutasi berhasil dibatalkan!';
                $data['sukses'] = 1;
              } else {
                $transaction->rollback();
                $data['pesan'] = 'Detail mutasi gagal dihapus!';
              }
            } catch (Exception $e) {
              $transaction->rollback();
              $data['pesan'] = 'Mutasi gagal dibatalkan !<br/>' . $e->getMessage();
            }
          }
        } else {
          $data['pesan'] = 'Mutasi gagal dibatalkan karena data tidak ditemukan di database!';
        }
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }
}
