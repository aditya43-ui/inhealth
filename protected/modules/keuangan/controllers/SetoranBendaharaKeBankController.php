<?php

class SetoranBendaharaKeBankController extends MyAuthController
{
  public $path_view = "keuangan.views.setoranBendaharaKeBank.";

  public function actionAutoCompletePegawai()
  {
    //$this->render('autoCompletePegawai');
  }

  public function actionAutoCompletePegawaiMengetahui()
  {
    //$this->render('autoCompletePegawaiMengetahui');
  }

  public function actionDetail()
  {
    $this->render($this->path_view . 'detail');
  }

  public function actionIndex($id = null, $closing_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Setoran Ke Bank";
    $model = new KUSetoranbdharaT;
    $setorbank = new SetorbankT;

    $detail = array();
    $detailTotal = 0;

    // $model->nosetoranbdhara = MyGenerator::noSetoranBendahara();
    $model->nosetoranbdhara = "-- Otomatis --"; // MyGenerator::generateNoBKK();
    $model->tglsetoranbdhara = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
    $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
    $model->tgl_awal = $model->tgl_akhir = MyFormatter::formatDateTimeForUser(date('Y-m-d'));

    $p = PegawaiM::model()->findByPk($model->pegawai_id);
    if (!empty($p)) $model->pegawai_nama = $p->namaLengkap;

    if (!empty($closing_id)) {
      $detail[$closing_id] = ClosingkasirT::model()->findByPk($closing_id);
      $detailTotal += $detail[$closing_id]->nilaiclosingtrans - $detail[$closing_id]->jumlahnontunai;
    }


    if (isset($_POST['KUSetoranbdharaT']) && isset($_POST['detail'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {
        $model->attributes = $_POST['KUSetoranbdharaT'];
        //var_dump($model->attributes);die;
        $model->tglsetoranbdhara = MyFormatter::formatDateTimeForDb($model->tglsetoranbdhara);
        $model->profilrs_id = Yii::app()->user->getState('profilrs_id');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->tglmengetahui = date('Y-m-d H:i:s');
        $model->nosetoranbdhara = MyGenerator::noSetoranBendahara();

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else $ok = false;


        // var_dump($_POST); die;

        if (isset($_POST['SetorbankT'])) {
          $setorbank->attributes = $_POST['SetorbankT'];
          $setorbank->tgldisetor = $model->tglsetoranbdhara;
          $setorbank->jumlahsetoran = $_POST['total'];
          $setorbank->ygmenyetor_id = $model->pegawai_id;
          $setorbank->create_time = date('Y-m-d H:i:s');
          $setorbank->create_loginpemakai_id = Yii::app()->user->id;
          if ($setorbank->validate()) {
            $ok = $ok && $setorbank->save();
            $model->setorbank_id = $setorbank->setorbank_id;
            $ok = $ok && $model->save();
          }
        }

        // die;

        foreach ($_POST['detail'] as $closingkasir_id => $item) {
          // foreach ($detail as $kelompoktindakan_id => $item) {
          $det = new RinciansetoranbdharaT;
          $det->attributes = $item;
          $det->setoranbdhara_id = $model->setoranbdhara_id;
          $det->closingkasir_id = $closingkasir_id;
          // $det->kelompoktindakan_id = $kelompoktindakan_id;

          // var_dump($det->attributes); die;

          if ($det->validate()) {
            $ok = $ok && $det->save();
            if (!empty($setorbank->setorbank_id)) {
              ClosingkasirT::model()->updateByPk($closingkasir_id, array(
                'setorbank_id' => $setorbank->setorbank_id,
              ));
            }
          } else $ok = false;

          // var_dump($det->attributes);

          // }
        }

        // var_dump($model->attributes, $setorbank->attributes); die;

        $ok = $ok && $this->simpanTandaBuktiKeluar($model, $setorbank, $_POST);

        if (!empty($model->setoranbdhara_id) && $ok) {
          $res = Yii::app()->db
            ->createCommand("select ins_setsetorbank_fix(" . $model->setoranbdhara_id . ") as simpan")
            ->queryRow();

          if (!empty($res)) {
            $ok = $ok && $res['simpan'];
          }
        }

        // var_dump($ok); die;
        // die;
        if ($ok) {
          $this->notifSetorBank($model, $setorbank);
          // die;
          $trans->commit();
          Yii::app()->user->setFlash("success", "Data Berhasil Disimpan.");
          $this->redirect(array('index', 'id' => $model->setoranbdhara_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash("error", "Data Gagal Disimpan.");
        }
      } catch (Exception $e) {
        $trans->rollback();
        // var_dump($e->getMessage()); die;
        Yii::app()->user->setFlash('error', "Data pembayaran gagal disimpan " . MyExceptionMessage::getMessage($e, true));
      }
      //var_dump($_POST, $model->validate(), $model->errors, $model->attributes); die;
    }

    if (isset($id)) {
      $model = KUSetoranbdharaT::model()->findByPk($id);
      $setorbank = SetorbankT::model()->findByPk($model->setorbank_id);

      if (!empty($model->pegawai_id)) {
        $p = PegawaiM::model()->findByPk($model->pegawai_id);
        $model->pegawai_nama = $p->namaLengkap;
      }
      if (!empty($model->mengetahui_id)) {
        $p = PegawaiM::model()->findByPk($model->mengetahui_id);
        $model->mengetahui_nama = $p->namaLengkap;
      }
    }

    $this->render($this->path_view . 'index', array('model' => $model, 'detail' => $detail, 'setorbank' => $setorbank, 'id' => $id, 'detailTotal' => $detailTotal));
  }

  public function notifSetorBank($model, $setorbank)
  {
    $newMod = KUSetoranbdharaT::model()->findByPk($model->setoranbdhara_id);

    $peg = PegawaiM::model()->findByPk($newMod->pegawai_id);
    if (empty($peg)) $peg = new PegawaiM;

    // var_dump($newMod->attributes); die;


    $judul = "Setoran ke Bank";
    $isi = "Disetor oleh " . $peg->namaLengkap . " sebesar " . MyFormatter::formatNumberForPrint($setorbank->jumlahsetoran);

    // var_dump($judul, $isi); die;

    $cur = array(
      array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_FINANCE, 'modul_id' => Params::MODUL_ID_KEUANGAN),
      array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_BENDAHARA, 'modul_id' => Params::MODUL_ID_KEUANGAN),
    );

    // var_dump($judul, $isi, $cur, $modKunjungan->attributes); die;

    return CustomFunction::broadcastNotif($judul, $isi, $cur);
  }

  public function simpanTandaBuktiKeluar($model, $setorbank, $post)
  {
    $ok = true;

    $bkk = new TandabuktikeluarT();
    $bkk->setorbank_id = $setorbank->setorbank_id;
    $bkk->setoranbdhara_id = $model->setoranbdhara_id;
    $bkk->shift_id = Yii::app()->user->getState('shift_id');
    $bkk->ruangan_id = $model->ruangan_id;
    $bkk->tahun = date('Y', strtotime($model->tglsetoranbdhara));
    $bkk->tglkaskeluar = $model->tglsetoranbdhara;
    $bkk->nokaskeluar = MyGenerator::noBuktiKeluar();
    $bkk->carabayarkeluar = 'TUNAI';
    $bkk->melalubank = $setorbank->namabank;
    $bkk->denganrekening = $setorbank->norekening;
    $bkk->atasnamarekening = $bkk->namapenerima = $setorbank->atasnama;
    $bkk->untukpembayaran = "Setoran ke Bank - " . MyFormatter::formatDateTimeForUser($model->tglsetoranbdhara);
    $bkk->jmlkaskeluar = $setorbank->jumlahsetoran;
    $bkk->biayaadministrasi = 0;
    $bkk->keterangan_pengeluaran = '-';
    $bkk->create_time = date('Y-m-d H:i:s');
    $bkk->create_loginpemakai_id = Yii::app()->user->id;
    $bkk->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $bkk->biayaongkos_kirim = 0;

    // var_dump($bkk->attributes); die;

    if ($bkk->validate()) {
      $ok = $ok && $bkk->save();
      $model->nosetoranbdhara = $bkk->nokaskeluar;
      $model->save();
    } else {
      $ok = false;
      // var_dump($bkk->errors); die;
    }


    // var_dump($ok, $bkk->attributes, $model->attributes, $setorbank->attributes, $post); die;

    return $ok;
  }

  public function actionInformasi()
  {
    $model = new InformasisetoranbendaharaV();
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d 23:59:59');

    if (isset($_GET['InformasisetoranbendaharaV'])) {
      $model->attributes = $_GET['InformasisetoranbendaharaV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($model->tgl_akhir);
    }

    $this->render($this->path_view . 'informasi', array(
      'model' => $model,
    ));
  }

  public function actionRincianSetoran($id, $frame = null)
  {
    $this->layout = '//layouts/printWindows';
    if (!empty($frame)) {
      $this->layout = '//layouts/iframe';
    }

    $model = KUSetoranbdharaT::model()->findByPk($id);
    $setorbank = SetorbankT::model()->findByPk($model->setorbank_id);
    $nip = array('', '');
    if (!empty($model->pegawai_id)) {
      $p = PegawaiM::model()->findByPk($model->pegawai_id);
      $model->pegawai_nama = $p->namaLengkap;
      $nip[0] = $p->nomorindukpegawai;
    }
    if (!empty($model->mengetahui_id)) {
      $p = PegawaiM::model()->findByPk($model->mengetahui_id);
      $model->mengetahui_nama = $p->namaLengkap;
      $nip[1] = $p->nomorindukpegawai;
    }

    $det = array();
    $mdet = RinciansetoranbdharaT::model()->findAllByAttributes(array(
      'setoranbdhara_id' => $model->setoranbdhara_id,
    ));

    $total = 0;

    $cnt = 1;
    foreach ($mdet as $item) {
      // var_dump($item->attributes);

      $rek = Rekening5M::model()->findByPk($item->rekening5_id);
      $closing = ClosingkasirT::model()->findByPk($item->closingkasir_id);

      if (empty($closing)) continue;
      // $kel = KelompoktindakanM::model()->findByPk($item->kelompoktindakan_id);
      /*
			if (empty($det[$item->closingkasir_id])) {
				$set = SetorankasirT::model()->findByPk($item->setorankasir_id);
				
				$det[$item->setorankasir_id] = array(
					'no'=>$set->nosetorankasir,
					'det'=>array(),
				);
				
				
			}
             * 
             */

      $link = $closing->closingkasir_no;
      $str = "Closing Kasir " . $link . " - " . MyFormatter::formatDateTimeForUser($closing->tglclosingkasir);

      $det[$item->closingkasir_id] = array(
        'no' => $cnt++,
        'id' => $closing->closingkasir_id,
        'rek' => $rek->kdrekening5 . " - " . $rek->nmrekening5,
        'kel' => $str,
        'nilai' => $item->jmlsetoranbdhara,
      );

      $total += $item->jmlsetoranbdhara;
    }

    $this->render($this->path_view . 'printRincian', array('model' => $model, 'det' => $det, 'nip' => $nip, 'setorbank' => $setorbank, 'total' => $total));
  }

  public function actionLoadSetoran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tgl_awal = isset($_POST['tgl_awal']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_awal']) : null;
      $tgl_akhir = isset($_POST['tgl_akhir']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_akhir']) : null;

      $c = new CDbCriteria();
      $c->addBetweenCondition('t.kirim_tgl::date', $tgl_awal, $tgl_akhir);
      $c->join = 'left join rinciansetoranbdhara_t s on s.closingkasir_id = t.closingkasir_id';
      $c->addCondition('s.closingkasir_id is null and t.is_kirim = true');

      $setoran = ClosingkasirT::model()->findAll($c);
      $detail = $this->tabularDetailSetoranKasir($setoran);

      //var_dump(count((array)$setoran));
      // var_dump($detail); die;

      $total = 0;

      foreach ($detail as $item) {
        $total += $item->nilaiclosingtrans - $item->jumlahnontunai;
      }

      echo CJSON::encode(array(
        'html' => $this->renderPartial($this->path_view . 'sub/_tabdetail', array('detail' => $detail), true),
        'footer' => $this->renderPartial($this->path_view . 'sub/_tabtotal', array('total' => $total), true),
      ));
    }
    Yii::app()->end();
  }

  private function tabularDetailSetoranKasir($setoran)
  {
    $res = array();

    foreach ($setoran as $item) {
      $res[$item->closingkasir_id] = $item;
    }


    return $res;
  }

  public function actionPrint($id, $frame = null)
  {
    $this->layout = '//layouts/printWindows';
    if (!empty($frame)) {
      $this->layout = '//layouts/iframe';
    }

    $model = KUSetoranbdharaT::model()->findByPk($id);
    $setorbank = SetorbankT::model()->findByPk($model->setorbank_id);
    $nip = array('', '');
    if (!empty($model->pegawai_id)) {
      $p = PegawaiM::model()->findByPk($model->pegawai_id);
      $model->pegawai_nama = $p->namaLengkap;
      $nip[0] = $p->nomorindukpegawai;
    }
    if (!empty($model->mengetahui_id)) {
      $p = PegawaiM::model()->findByPk($model->mengetahui_id);
      $model->mengetahui_nama = $p->namaLengkap;
      $nip[1] = $p->nomorindukpegawai;
    }

    $det = array();
    $mdet = RinciansetoranbdharaT::model()->findAllByAttributes(array(
      'setoranbdhara_id' => $model->setoranbdhara_id,
    ));

    $total = 0;

    $cnt = 1;
    foreach ($mdet as $item) {
      // var_dump($item->attributes);

      $rek = Rekening5M::model()->findByPk($item->rekening5_id);
      $closing = ClosingkasirT::model()->findByPk($item->closingkasir_id);

      if (empty($closing)) continue;
      // $kel = KelompoktindakanM::model()->findByPk($item->kelompoktindakan_id);
      /*
			if (empty($det[$item->closingkasir_id])) {
				$set = SetorankasirT::model()->findByPk($item->setorankasir_id);
				
				$det[$item->setorankasir_id] = array(
					'no'=>$set->nosetorankasir,
					'det'=>array(),
				);
				
				
			}
             * 
             */

      $link = $closing->closingkasir_no;
      $str = "Closing Kasir " . $link . " - " . MyFormatter::formatDateTimeForUser($closing->tglclosingkasir);

      $det[$item->closingkasir_id] = array(
        'no' => $cnt++,
        'id' => $closing->closingkasir_id,
        'rek' => $rek->kdrekening5 . " - " . $rek->nmrekening5,
        'kel' => $str,
        'nilai' => $item->jmlsetoranbdhara,
      );

      $total += $item->jmlsetoranbdhara;
    }

    $this->render($this->path_view . 'print', array('model' => $model, 'det' => $det, 'nip' => $nip, 'setorbank' => $setorbank, 'total' => $total));
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
