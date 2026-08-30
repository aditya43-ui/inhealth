<?php

class ReturPenerimaanUmumController extends MyAuthController
{
  protected $successSave = true;

  public function actionIndex()
  {
    if (!empty($_GET['frame']) && !empty($_GET['idPenerimaan'])) {
      $this->layout = "//layouts/iframe";
      $idPenerimaan = $_GET['idPenerimaan'];
      $modPenerimaan = BKPenerimaanUmumT::model()->findByPk($idPenerimaan);
      $modBuktiBayar = BKTandabuktibayarT::model()->findByPk($modPenerimaan->tandabuktibayar_id);

      $modBuktiKeluar = new BKTandabuktikeluarT;
      $modBuktiKeluar->tahun = date('Y');
      $modBuktiKeluar->namapenerima = $modBuktiBayar->darinama_bkm;
      $modBuktiKeluar->alamatpenerima = $modBuktiBayar->alamat_bkm;
      $modBuktiKeluar->untukpembayaran = 'Retur Tagihan Pasien';
      $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
      $modBuktiKeluar->jmlkaskeluar = number_format($modPenerimaan->totalharga);
      $modBuktiKeluar->biayaadministrasi = number_format($modBuktiKeluar->biayaadministrasi);
      $modRetur = new BKReturPenerimaanUmumT;
      $modRetur->penerimaanumum_id = $modPenerimaan->penerimaanumum_id;
      $modRetur->tandabuktibayar_id = $modPenerimaan->tandabuktibayar_id;
    } else {
      $modPenerimaan = new BKPenerimaanUmumT;
      $modBuktiBayar = new BKTandabuktibayarT;
    }

    if (isset($_POST['BKReturPenerimaanUmumT'])) {
      $idPenerimaan = $_POST['BKReturPenerimaanUmumT']['penerimaanumum_id'];
      $modPenerimaan = BKPenerimaanUmumT::model()->findByPk($idPenerimaan);
      $modBuktiBayar = BKTandabuktibayarT::model()->findByPk($modPenerimaan->tandabuktibayar_id);

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRetur = $this->saveReturPenerimaan($_POST['BKReturPenerimaanUmumT']);
        $modBuktiKeluar = $this->saveBuktiKeluar($_POST['BKTandabuktikeluarT'], $modRetur);
        $this->updateTandaBuktiBayar($modPenerimaan->tandabuktibayar_id, $modRetur);

        $successSave = $this->successSave;
        if ($successSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'modPenerimaan' => $modPenerimaan,
      'modBuktiBayar' => $modBuktiBayar,
      'modBuktiKeluar' => $modBuktiKeluar,
      'modRetur' => $modRetur
    ));
  }

  protected function saveReturPenerimaan($postRetur)
  {
    $format = new MyFormatter;
    $modRetur = new BKReturPenerimaanUmumT;
    $modRetur->attributes = $postRetur;
    $modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modRetur->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modRetur->create_time = date("Y-m-d H:i:s");
    $modRetur->create_loginpemakai_id = Yii::app()->user->id;
    $modRetur->tglreturumum = $format->formatDateTimeForDb($_POST['BKReturPenerimaanUmumT']['tglreturumum']);
    if ($modRetur->validate()) {
      $modRetur->save();
      $this->successSave = $this->successSave && true;
    } else {
      $this->successSave = false;
    }

    return $modRetur;
  }

  protected function saveBuktiKeluar($postBuktiKeluar, $modRetur)
  {
    $modBuktiKeluar = new BKTandabuktikeluarT;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->tglkaskeluar = $modRetur->tglreturumum;
    $modBuktiKeluar->returpenerimaanumum_id = $modRetur->returpenerimaanumum_id;
    $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->create_time = date("Y-m-d H:i:s");
    $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
    $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');

    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->successSave = $this->successSave && true;
    } else {
      $this->successSave = false;
    }

    return $modBuktiKeluar;
  }

  protected function updateTandaBuktiBayar($idBuktiBayar, $modRetur)
  {
    BKTandabuktibayarT::model()->updateByPk($idBuktiBayar, array('returpenerimaanumum_id' => $modRetur->returpenerimaanumum_id));
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

  public function actionPrintPenerimaanUmum($tandabuktibayar_id)
  {
    if (!empty($tandabuktibayar_id)) {
      $this->layout = '//layouts/printWindows';

      $attributes = array(
        'returpenerimaanumum_id' => $tandabuktibayar_id
      );
      $judulLaporan = 'KUITANSI RETUR PENERIMAAN UMUM';
      $retur = BKTandabuktikeluarT::model()->findByAttributes($attributes);
      //$model_tandabuktibayar = BKTandabuktibayarT::model()->with('pembayaran')->findByAttributes(array('tandabuktibayar_id'=>$return->tandabuktibayar_id));
      $judulLaporan = 'Tanda Bukti Return Penerimaan Umum';
      $this->render(
        'kwitansiReturPenerimaanUmum',
        array(
          'model' => $retur,
          //'tandabuktibayar'=>$model_tandabuktibayar,
          'judulLaporan' => $judulLaporan,
        )
      );
    }
  }

  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
