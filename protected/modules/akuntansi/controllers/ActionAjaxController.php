<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAjaxController extends MyAuthController
{
  /* jurnal rek penjamin */
  public function actionGetRekeningEditDebitPenjamin()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $rekening5_id = $_POST['rekening5_id'];
      $penjamin_id = $_POST['penjamin_id'];
      $penjaminrek_id = $_POST['penjaminrek_id'];

      $update =  AKPenjaminRekM::model()->updateByPk($penjaminrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }


  public function actionGetRekeningEditKreditPenjamin()

  {
    if (Yii::app()->request->isAjaxRequest) {

      $rekening5_id = $_POST['rekening5_id'];

      $penjamin_id = $_POST['penjamin_id'];
      $penjaminrek_id = $_POST['penjaminrek_id'];

      $update =  AKPenjaminRekM::model()->updateByPk($penjaminrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }


  /*end jurnal rek penjamin */

  public function actionGetRekeningEditDebitPelayananRek()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rekening1_id = $_POST['rekening1_id'];
      $rekening2_id = $_POST['rekening2_id'];
      $rekening3_id = $_POST['rekening3_id'];
      $rekening4_id = $_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];

      $pelayananrek_id = $_POST['pelayananrek_id'];

      $update = AKPelayananRekM::model()->updateByPk($pelayananrek_id, array(
        'rekening1_id' => $rekening1_id,
        'rekening2_id' => $rekening2_id,
        'rekening3_id' => $rekening3_id,
        'rekening4_id' => $rekening4_id,
        'rekening5_id' => $rekening5_id
      ));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }


  /* jurnal rek penerimaan */
  public function actionGetRekeningEditKreditPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //              $rekening1_id =$_POST['rekening1_id'];
      //              $rekening2_id =$_POST['rekening2_id'];
      //              $rekening3_id =$_POST['rekening3_id'];
      //              $rekening4_id =$_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $jenispenerimaan_id = $_POST['jenispenerimaan_id'];
      $jnspenerimaanrek_id = $_POST['jnspenerimaanrek_id'];
      //              $saldonormal =$_POST['saldonormal'];

      $update =  AKJnsPenerimaanRekM::model()->updateByPk($jnspenerimaanrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetRekeningEditDebitPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //              $rekening1_id =$_POST['rekening1_id'];
      //              $rekening2_id =$_POST['rekening2_id'];
      //              $rekening3_id =$_POST['rekening3_id'];
      //              $rekening4_id =$_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $jenispenerimaan_id = $_POST['jenispenerimaan_id'];
      $jnspenerimaanrek_id = $_POST['jnspenerimaanrek_id'];
      //              $saldonormal =$_POST['saldonormal'];

      $update =  AKJnsPenerimaanRekM::model()->updateByPk($jnspenerimaanrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /*end jurnal rek penerimaan */



  //getRekeningEditDebitKreditSupplier
  public function actionGetRekeningEditDebitKreditSupplier()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rekening1_id   = $_POST['rekening1_id'];
      $rekening2_id   = $_POST['rekening2_id'];
      $rekening3_id   = $_POST['rekening3_id'];
      $rekening4_id   = $_POST['rekening4_id'];
      $rekening5_id   = $_POST['rekening5_id'];
      $supplier_id    = $_POST['supplier_id'];
      $supplierrek_id = $_POST['supplierrek_id'];
      $saldonormal    = $_POST['saldonormal'];

      $update = AKSupplierRekM::model()->updateByPk($supplierrek_id, array(
        'rekening1_id' => $rekening1_id,
        'rekening2_id' => $rekening2_id,
        'rekening3_id' => $rekening3_id,
        'rekening4_id' => $rekening4_id,
        'rekening5_id' => $rekening5_id
      ));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  //getRekeningEditDebitKreditSumberdana
  public function actionGetRekeningEditDebitKreditSumberdana()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rekening1_id     = $_POST['rekening1_id'];
      $rekening2_id     = $_POST['rekening2_id'];
      $rekening3_id     = $_POST['rekening3_id'];
      $rekening4_id     = $_POST['rekening4_id'];
      $rekening5_id     = $_POST['rekening5_id'];
      $sumberdana_id    = $_POST['sumberdana_id'];
      $sumberdanarek_id = $_POST['sumberdanarek_id'];
      $saldonormal      = $_POST['saldonormal'];

      $update = AKSumberdanaRekM::model()->updateByPk($sumberdanarek_id, array(
        'rekening1_id' => $rekening1_id,
        'rekening2_id' => $rekening2_id,
        'rekening3_id' => $rekening3_id,
        'rekening4_id' => $rekening4_id,
        'rekening5_id' => $rekening5_id
      ));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  //getRekeningEditDebitKreditCarabayar
  public function actionGetRekeningEditDebitKreditCarabayar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rekening1_id     = $_POST['rekening1_id'];
      $rekening2_id     = $_POST['rekening2_id'];
      $rekening3_id     = $_POST['rekening3_id'];
      $rekening4_id     = $_POST['rekening4_id'];
      $rekening5_id     = $_POST['rekening5_id'];
      $carabayar_id     = $_POST['carabayar_id'];
      $carapembrek_id   = $_POST['carapembrek_id'];
      $saldonormal      = $_POST['saldonormal'];

      $update = AKCarapembayarRekM::model()->updateByPk($carapembrek_id, array(
        'rekening1_id' => $rekening1_id,
        'rekening2_id' => $rekening2_id,
        'rekening3_id' => $rekening3_id,
        'rekening4_id' => $rekening4_id,
        'rekening5_id' => $rekening5_id
      ));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /* Jurnal Pengeluaran */
  public function actionGetRekeningEditKreditPengeluaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //              $rekening1_id =$_POST['rekening1_id'];
      //              $rekening2_id =$_POST['rekening2_id'];
      //              $rekening3_id =$_POST['rekening3_id'];
      //              $rekening4_id =$_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $jenispengeluaran_id = $_POST['jenispengeluaran_id'];
      $jnspengeluaranrek_id = $_POST['jnspengeluaranrek_id'];
      //              $saldonormal =$_POST['saldonormal'];

      $update =  AKJnsPengeluaranRekM::model()->updateByPk($jnspengeluaranrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetRekeningEditDebitPengeluaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //              $rekening1_id =$_POST['rekening1_id'];
      //              $rekening2_id =$_POST['rekening2_id'];
      //              $rekening3_id =$_POST['rekening3_id'];
      //              $rekening4_id =$_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $jenispengeluaran_id = $_POST['jenispengeluaran_id'];
      $jnspengeluaranrek_id = $_POST['jnspengeluaranrek_id'];
      //              $saldonormal =$_POST['saldonormal'];

      $update =  AKJnsPengeluaranRekM::model()->updateByPk($jnspengeluaranrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /*end jurnal pengeluaran */

  /* rekening bank */
  public function actionGetRekeningEditKreditBank()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rekening1_id = $_POST['rekening1_id'];
      $rekening2_id = $_POST['rekening2_id'];
      $rekening3_id = $_POST['rekening3_id'];
      $rekening4_id = $_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $bank_id = $_POST['bank_id'];
      $bankrek_id = $_POST['bankrek_id'];
      $saldonormal = $_POST['saldonormal'];

      $update =  AKBankRekM::model()->updateByPk($bankrek_id, array(
        'rekening1_id' => $rekening1_id,
        'rekening2_id' => $rekening2_id,
        'rekening3_id' => $rekening3_id,
        'rekening4_id' => $rekening4_id,
        'rekening5_id' => $rekening5_id
      ));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetRekeningEditDebitBank()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rekening1_id = $_POST['rekening1_id'];
      $rekening2_id = $_POST['rekening2_id'];
      $rekening3_id = $_POST['rekening3_id'];
      $rekening4_id = $_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $bank_id = $_POST['bank_id'];
      $bankrek_id = $_POST['bankrek_id'];
      $saldonormal = $_POST['saldonormal'];

      $update =  AKBankRekM::model()->updateByPk($bankrek_id, array(
        'rekening1_id' => $rekening1_id,
        'rekening2_id' => $rekening2_id,
        'rekening3_id' => $rekening3_id,
        'rekening4_id' => $rekening4_id,
        'rekening5_id' => $rekening5_id
      ));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /*end rekening bank */
}
