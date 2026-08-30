<?php

Yii::import("billingKasir.controllers.ReturTagihanPasienController");

class ReturObatPasienController extends ReturTagihanPasienController
{
  /**
   * Retur khusus obat saja
   * @param type $idReturResep = jika transaksi dilakukan dari dialog informasi billingKasir/informasiReturObatAlkes
   * @param type $idReturBayar
   */
  public function actionIndex($idReturResep = null, $idReturBayar = null)
  {
    if (!empty($_GET['frame'])) {
      $this->layout = 'iframe';
    }
    $modPendaftaran = new BKPendaftaranT;
    $modPasien = new BKPasienM;
    $modBuktiKeluar = new BKTandabuktikeluarT;
    $modReturResep = new BKReturresepT;
    $modReturResepDets = array();
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->untukpembayaran = 'Retur Obat Pasien';
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();

    $modRetur = new BKReturbayarpelayananT;
    $modRetur->noreturbayar = MyGenerator::noReturBayarPelayanan();
    $modRetur->biayaadministrasi = 0;
    $modRetur->totaloaretur = 0;
    $modRetur->totaltindakanretur = 0;
    $modRetur->totalbiayaretur = 0;
    $totalReturOA = 0;
    if (!empty($idReturResep)) {
      $modReturResep = BKReturresepT::model()->findByPk($idReturResep);
      $modReturResepDets = BKReturresepdetT::model()->findAllByAttributes(array('returresep_id' => $idReturResep));
      if (count((array)$modReturResepDets) > 0) {
        foreach ($modReturResepDets as $i => $detail) {
          $totalReturOA += $detail->qty_retur * $detail->hargasatuan;
        }
      }
      $modRetur->totaloaretur = $totalReturOA;
      $modRetur->totaltindakanretur = 0;
      $modRetur->totalbiayaretur = $totalReturOA;
      $modPendaftaran = BKPendaftaranT::model()->findByPk($modReturResep->pendaftaran_id);
      if (!$modPendaftaran) {
        $modPendaftaran = new BKPendaftaranT;
      }
      $modPasien = BKPasienM::model()->findByPk($modReturResep->pasien_id);
      if (!$modPasien) {
        $modPasien = new BKPasienM;
      }
    }
    if (!empty($idReturBayar)) {
      $modRetur = BKReturbayarpelayananT::model()->findByPk($idReturBayar);
      $modPendaftaran = BKPendaftaranT::model()->findByPk($modReturResep->pendaftaran_id);
      if (!$modPendaftaran) {
        $modPendaftaran = new BKPendaftaranT;
      }
      $modPasien = BKPasienM::model()->findByPk($modReturResep->pasien_id);
      if (!$modPasien) {
        $modPasien = new BKPasienM;
      }
    }
    $url_batal = Yii::app()->createAbsoluteUrl(
      Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
    );

    $successSave = false;
    if (isset($_POST['BKReturbayarpelayananT']) && isset($_POST['BKTandabuktikeluarT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRetur = $this->saveReturBayarPelayanan($_POST['BKReturbayarpelayananT']);
        $modBuktiKeluar = $this->saveTandaBuktiKeluar($modRetur, $_POST['BKTandabuktikeluarT']);

        $successSave = $this->successSave;
        if ($successSave) {
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $transaction->commit();
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }

    $this->render(
      'index',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modBuktiKeluar' => $modBuktiKeluar,
        'modRetur' => $modRetur,
        'successSave' => $successSave,
        'url_batal' => $url_batal
      )
    );
  }

  public function actionCekLogin($task = 'Retur')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $idRuangan = Yii::app()->user->getState('ruangan_id');

      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $username,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $data['status'] = 'Gagal Login';
      } else {
        // cek password
        if ($user->katakunci_pemakai !== $user->encrypt($password)) {
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $data['status'] = 'Gagal Login';
        } else {
          // cek ruangan
          $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array(
            'loginpemakai_id' => $user->loginpemakai_id,
            'ruangan_id' => $idRuangan
          ));
          if ($ruangan_user === null) {
            $data['error'] = 'ruangan salah!';
            $data['status'] = 'Gagal Login';
          } else {
            $data['error'] = '';
            $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari MyAuthController
            if ($cek) {
              $data['status'] = 'success';
              $data['userid'] = $user->loginpemakai_id;
              $data['username'] = $user->nama_pemakai;
            } else {
              $data['status'] = 'Anda tidak memiliki hak melakukan proses ini!';
            }
          }
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
