<?php

class KelahiranbayiTController extends MyAuthController
{
  public function actionIndex($id, $bayi = null)
  {
    $format = new MyFormatter();
    $model = new PSKelahiranbayiT;
    $modPendaftaran = PSPendaftaranT::model()->findByPk($id);
    $modPasien = PSPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPersalinan = PSPersalinanT::model()->findByAttributes(array('pendaftaran_id' => $id, 'pasien_id' => $modPasien->pasien_id), array('order' => 'persalinan_id Desc'));
    $dataKelahiran = array();
    if (!isset($modPersalinan)) {
      Yii::app()->user->setFlash('error', "Data Persalinan Pasien tidak ditemukan. Silakan lakukan transaksi persalinan terlebih dahulu!");
      $redirect = isset($_POST['returnUrl']) ? $_POST['returnUrl'] : Yii::app()->createUrl($this->module->id . '/daftarPasien/index');
      echo "<script type='text/javascript'>setTimeout(function(){window.location.href = '" . $redirect . "';},5000);</script>";
    }
    if (isset($modPersalinan->persalinan_id)) {
      $modKelahiran = KelahiranbayiT::model()->with('persalinan')->findAllByAttributes(array('persalinan_id' => $modPersalinan->persalinan_id));
      $dataKelahiran = PSKelahiranbayiT::model()->findAllByAttributes(array('persalinan_id' => $modPersalinan->persalinan_id));
      $modKelahiranTerdahulu = PSKelahiranbayiT::model()->with('persalinan')->findByAttributes(array('persalinan_id' => $modPersalinan->persalinan_id));
    } else {
      $modKelahiran = array();
      $dataKelahiran = array();
      $modKelahiranTerdahulu = array();
    }
    if (count((array)$dataKelahiran) > 0) {
      if (($model->islahirtunggal == 0) || ($model->islahirtunggal == '')) {
        //$dataKelahiran = PSKelahiranbayiT::model()->findAllByAttributes(array('persalinan_id'=>$modPersalinan->persalinan_id));
        $jumlahKelahiranBayi = count((array)$dataKelahiran);
        $jumlahKembar = $modKelahiranTerdahulu->jmlkembar;

        if ($jumlahKelahiranBayi < $jumlahKembar) {
          $model = new PSKelahiranbayiT;
          $model->tgllahirbayi = date('d M Y');
          $model->jamlahir = date('H:i:s');
          $model->islahirtunggal = $modKelahiranTerdahulu->islahirtunggal;
          $model->jmlkembar = $modKelahiranTerdahulu->jmlkembar;
          $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        } else {
          if (isset($bayi)) {
            $model = PSKelahiranbayiT::model()->findByAttributes(array('kelahiranbayi_id' => $bayi));
          } else {
            $model = PSKelahiranbayiT::model()->findByAttributes(array('persalinan_id' => $modPersalinan->persalinan_id), array('limit' => 1, 'order' => 'kelahiranbayi_id asc'));
          }
        }
      } else {
        if (isset($bayi)) {
          $model = PSKelahiranbayiT::model()->findByAttributes(array('kelahiranbayi_id' => $bayi));
        } else {
          $model = PSKelahiranbayiT::model()->findByAttributes(array('persalinan_id' => $modPersalinan->persalinan_id), array('limit' => 1, 'order' => 'kelahiranbayi_id asc'));
        }
      }
    } else {
      $model = new PSKelahiranbayiT;
      $model->tgllahirbayi = date('d M Y');
      $model->jamlahir = date('H:i:s');
      $jumlahKembar = 0;
      $model->namabayi = 'Bayi Ny. ' . $modPasien->nama_pasien;
    }


    if (!empty($model->tb_cm)) {
      $model->tb_cm = number_format($model->tb_cm, 2, ",", "");
    }
    if (!empty($model->ld_cm)) {
      $model->ld_cm = number_format($model->ld_cm, 2, ",", "");
    }
    if (!empty($model->ll_cm)) {
      $model->ll_cm = number_format($model->ll_cm, 2, ",", "");
    }
    if (!empty($model->lk_cm)) {
      $model->lk_cm = number_format($model->lk_cm, 2, ",", "");
    }

    $appgards = PSMetodeapgarM::model()->findAll(array('order' => 'metodeapgar_id'), "metodeapgar_aktif = TRUE");
    if (isset($_POST['PSKelahiranbayiT'])) {
      $newRecord = $model->isNewRecord;

      // print_r($_POST); die;

      $model->attributes = $_POST['PSKelahiranbayiT'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->persalinan_id = $modPersalinan->persalinan_id;

      $model->nourutbayi = MyGenerator::noUrutBayi($modPasien->pasien_id);

      if (empty($model->namabayi)) {
        $model->namabayi = 'Bayi Ny. ' . $modPasien->nama_pasien;
      }
      $model->create_time = date('d M Y H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $jumlahappgard = count((array)$_POST['appgard']);

      if ($jumlahappgard == count((array)$appgards)) {
        $model->metodeApgar = 5;
      }

      $det_normal = isset($_POST['PSKelahiranbayiT']['detnormal']) ? $_POST['PSKelahiranbayiT']['detnormal'] : null;

      if (!empty($det_normal)) {
        $model->bayilahir_normal_tindakan = implode('///', $det_normal);
      }

      $det_aspiksia = isset($_POST['PSKelahiranbayiT']['detaspiksia']) ? $_POST['PSKelahiranbayiT']['detaspiksia'] : null;
      if (!empty($det_aspiksia)) {
        $model->bayilahir_aspiksia_tindakan = implode('///', $det_aspiksia);
      }

      if ($model->jmlkembar > 1) {
        $model->islahirtunggal = false;
      }

      if (!empty($model->tb_cm)) {
        $model->tb_cm = MyFormatter::formatRupiahForDB($model->tb_cm);
      }
      if (!empty($model->ld_cm)) {
        $model->ld_cm = MyFormatter::formatRupiahForDB($model->ld_cm);
      }
      if (!empty($model->ll_cm)) {
        $model->ll_cm = MyFormatter::formatRupiahForDB($model->ll_cm);
      }
      if (!empty($model->lk_cm)) {
        $model->lk_cm = MyFormatter::formatRupiahForDB($model->lk_cm);
      }


      if ($model->validate()) {
        $model->tgllahirbayi = date('Y-m-d', strtotime($model->tgllahirbayi));

        if (count((array)$dataKelahiran) > 0) {
          $model->islahirtunggal = $modKelahiranTerdahulu->islahirtunggal;
        }

        $model->tgllahirbayi = $model->tgllahirbayi . ' ' . $model->jamlahir;
        $interpretasi = 0;
        $as = $_POST['appgard'];
        foreach ($as as $key => $data) {
          $isi = substr($data, 0, 1);

          $interpretasi = $isi + $interpretasi;
          $model->warnakulit = substr($as[1], 1);
          $model->denyutjantung = substr($as[2], 1);
          $model->responrefleks = substr($as[3], 1);
          $model->pernapasan = substr($as[5], 1);
          $model->aktivitasotot = substr($as[4], 1);
        }

        $interpretasiMod = PSInterpretasiskorM::model()->findAllByAttributes(array(), array('order' => 'interpretasimax'));
        foreach ($interpretasiMod as $baris) {
          if ($interpretasi >= $baris->interpretasimin) {
            if ($interpretasi <= $baris->interpretasimax) {
              $interpretasiSkor = $baris->interpretasiskor_id;
            }
          }
        }
        $modInterpretasi = PSInterpretasiskorM::model()->findByPk($interpretasiSkor);
        $model->interpretasi = $modInterpretasi->intepretasi_nama;
        $success = true;
        $jumlahKelahiranBayi = 0;
        $transaction = Yii::app()->db->beginTransaction();

        // var_dump($model->attributes); die;

        try {
          if ($model->save()) {

            //jika bayi kembar
            if (isset($_POST['KelahiranbayiT'])) {
              $post = $_POST['KelahiranbayiT'];
              foreach ($post as $i => $item) {

                // var_dump($item); die;

                if (isset($item['kelahiranbayi_id'])) {
                  $modKelahirans[$i] = KelahiranbayiT::model()->findByPk($item['kelahiranbayi_id']);
                } else {
                  $modKelahirans[$i] = new KelahiranbayiT;
                }


                $modKelahirans[$i]->attributes = $item;
                $modKelahirans[$i]->tgllahirbayi = $format->formatDateTimeForDb($_POST['KelahiranbayiT'][$i]['tgllahirbayi']);
                $modKelahirans[$i]->islahirtunggal = $model->islahirtunggal;
                $modKelahirans[$i]->lahirkembar = $model->lahirkembar;
                $modKelahirans[$i]->jmlkembar = $model->jmlkembar;
                $modKelahirans[$i]->warnakulit = $model->warnakulit;
                $modKelahirans[$i]->denyutjantung = $model->denyutjantung;
                $modKelahirans[$i]->responrefleks = $model->responrefleks;
                $modKelahirans[$i]->pernapasan = $model->pernapasan;
                $modKelahirans[$i]->aktivitasotot = $model->aktivitasotot;
                $modKelahirans[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modKelahirans[$i]->persalinan_id = $modPersalinan->persalinan_id;
                $modKelahirans[$i]->nourutbayi = $model->nourutbayi;
                $modKelahirans[$i]->menitke = $model->menitke;
                $modKelahirans[$i]->metodeApgar = $model->metodeApgar;

                $modKelahirans[$i]->tgllahirbayi = date('Y-m-d', strtotime($modKelahirans[$i]->tgllahirbayi));
                $modKelahirans[$i]->tgllahirbayi .= " " . $_POST['KelahiranbayiT'][$i]['jamlahir'];

                if (!empty($modKelahirans[$i]->tb_cm)) {
                  $modKelahirans[$i]->tb_cm = MyFormatter::formatRupiahForDB($modKelahirans[$i]->tb_cm);
                }
                if (!empty($modKelahirans[$i]->ld_cm)) {
                  $modKelahirans[$i]->ld_cm = MyFormatter::formatRupiahForDB($modKelahirans[$i]->ld_cm);
                }
                if (!empty($modKelahirans[$i]->ll_cm)) {
                  $modKelahirans[$i]->ll_cm = MyFormatter::formatRupiahForDB($modKelahirans[$i]->ll_cm);
                }
                if (!empty($modKelahirans[$i]->lk_cm)) {
                  $modKelahirans[$i]->lk_cm = MyFormatter::formatRupiahForDB($modKelahirans[$i]->lk_cm);
                }


                if ($modKelahirans[$i]->isNewRecord) {
                  $modKelahirans[$i]->create_time = date('Y-m-d H:i:s');
                  $modKelahirans[$i]->create_loginpemakai_id = Yii::app()->user->id;
                  $modKelahirans[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                  $modKelahirans[$i]->update_time = date('Y-m-d H:i:s');
                  $modKelahirans[$i]->update_loginpemakai_id = Yii::app()->user->id;
                }
                $det_normalKembar = isset($_POST['KelahiranbayiT'][$i]['detnormal']) ? $_POST['KelahiranbayiT'][$i]['detnormal'] : null;
                if (!empty($det_normalKembar)) {
                  $modKelahirans[$i]->bayilahir_normal_tindakan = implode('///', $det_normalKembar);
                }

                $det_aspiksiaKembar = isset($_POST['KelahiranbayiT'][$i]['detaspiksia']) ? $_POST['KelahiranbayiT'][$i]['detaspiksia'] : null;
                if (!empty($det_aspiksiaKembar)) {
                  $modKelahirans[$i]->bayilahir_aspiksia_tindakan = implode('///', $det_aspiksiaKembar);
                }
                // var_dump($item); 
                // die;
                // simpan apgar
                $as2 = $item['metodeApgar'];
                $interpretasi = 0;
                foreach ($as2 as $key => $data) {
                  $isi = substr($data, 0, 1);

                  $interpretasi = $isi + $interpretasi;
                  $modKelahirans[$i]->warnakulit = substr($as[1], 1);
                  $modKelahirans[$i]->denyutjantung = substr($as[2], 1);
                  $modKelahirans[$i]->responrefleks = substr($as[3], 1);
                  $modKelahirans[$i]->pernapasan = substr($as[5], 1);
                  $modKelahirans[$i]->aktivitasotot = substr($as[4], 1);
                }



                $interpretasiMod = PSInterpretasiskorM::model()->findAllByAttributes(array(), array('order' => 'interpretasimax'));
                foreach ($interpretasiMod as $baris) {
                  if ($interpretasi >= $baris->interpretasimin) {
                    if ($interpretasi <= $baris->interpretasimax) {
                      $interpretasiSkor = $baris->interpretasiskor_id;
                    }
                  }
                }
                $modInterpretasi = PSInterpretasiskorM::model()->findByPk($interpretasiSkor);
                $modKelahirans[$i]->interpretasi = $modInterpretasi->intepretasi_nama;

                if ($modKelahirans[$i]->save()) {
                } else {
                  $success = false;
                }

                //                                    var_dump($modKelahirans[$i]->attributes); die;


                foreach ($as2 as $key => $data) {

                  $isi = $isi = substr($data, 0, 1);
                  $modScoreApgar = new PSApgarscoreT;
                  $modScoreApgar->kelahiranbayi_id = $modKelahirans[$i]->kelahiranbayi_id;
                  $modScoreApgar->metodeapgar_id = $key;
                  $modScoreApgar->interpretasiskor_id = $interpretasiSkor;
                  $modScoreApgar->tglapgarscore = date('d M Y H:i:s');
                  $modScoreApgar->nilai_apgar = $isi;
                  $modScoreApgar->menitke = $modKelahirans[$i]->menitke;
                  $modScoreApgar->jmlscore = $interpretasi;
                  $modScoreApgar->create_time = date('d M Y');
                  $modScoreApgar->create_loginpemakai_id = Yii::app()->user->id;
                  $modScoreApgar->create_ruangan = Yii::app()->user->getState('ruangan_id');

                  if ($modScoreApgar->save()) {
                  } else {
                    $success = false;
                  }
                }
              }
            }

            //                            echo '<pre>';
            //                            print_r($_POST['KelahiranbayiT']);
            //                            exit();
            $menitKeApgar = PSApgarscoreT::model()->findByAttributes(array('menitke' => $model->menitke, 'kelahiranbayi_id' => $model->kelahiranbayi_id));
            //if (count((array)$menitKeApgar) > 0){
            //    $message = "Menit Ke-$model->menitke telah terisi";
            //    $success = false;
            //}
            foreach ($as as $key => $data) {

              $isi = $isi = substr($data, 0, 1);
              $modScoreApgar = new PSApgarscoreT;
              $modScoreApgar->kelahiranbayi_id = $model->kelahiranbayi_id;
              $modScoreApgar->metodeapgar_id = $key;
              $modScoreApgar->interpretasiskor_id = $interpretasiSkor;
              $modScoreApgar->tglapgarscore = date('d M Y H:i:s');
              $modScoreApgar->nilai_apgar = $isi;
              $modScoreApgar->menitke = $model->menitke;
              $modScoreApgar->jmlscore = $interpretasi;
              $modScoreApgar->create_time = date('d M Y');
              $modScoreApgar->create_loginpemakai_id = Yii::app()->user->id;
              $modScoreApgar->create_ruangan = Yii::app()->user->getState('ruangan_id');

              if ($modScoreApgar->save()) {
              } else {
                $success = false;
              }
            }
          } else {
            $success = false;
          }

          if ($newRecord) {
            $this->notifKelahiranBayi($model);
          }


          if ($success == false) {
            $transaction->rollback();

            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          } else {
            $transaction->commit();

            Yii::app()->user->setFlash('success', "Data Berhasil disimpan ");
            // if ($jumlahKelahiranBayi+1 < $jumlahKembar){  
            if (!empty($bayi)) {
              $this->redirect(Yii::app()->createUrl($this->module->id . '/kelahiranbayiT/index', array('id' => $id, 'bayi' => $bayi)));
            } else {
              $this->redirect(Yii::app()->createUrl($this->module->id . '/kelahiranbayiT/index', array('id' => $id)));
            }
            //} else {
            //   $this->redirect(Yii::app()->createUrl($this->module->id.'/daftarPasien/index'));
            //}
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
      } else {
        echo CHtml::errorSummary($model);
        exit();
        Yii::app()->user->setFlash('error', "Data gagal disimpan !");
      }
    }

    $this->render('index', array('model' => $model, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPersalinan' => $modPersalinan, 'appgards' => $appgards, 'modKelahiran' => $modKelahiran));
  }

  function actionJumlahBayiKembar()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $jmlKembar = $_POST['jmlKembar'];
      $jmlKembar = $jmlKembar - 1;
      $namaby = $_POST['namaby'];
      $model = new KelahiranbayiT;

      $form = $this->renderPartial("_formKelahiranKembar", array('model' => $model, 'jmlKembar' => $jmlKembar, 'namaby' => $namaby), true);

      $data['sukses'] = 1;
      $data['form'] = $form;

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  public function notifKelahiranBayi($model)
  {

    if (empty($model->persalinan_id)) {
      return;
    }

    $judul = "Pasien Melahirkan";

    $persalinan = PersalinanT::model()->findByPk($model->persalinan_id);
    $pendaftaran = PendaftaranT::model()->findByPk($persalinan->pendaftaran_id);
    $pasien = PasienM::model()->findByPk($persalinan->pasien_id);

    $isi = $pendaftaran->no_pendaftaran . " - " . $pasien->no_rekam_medik . " - " . $pasien->nama_pasien
      . " - " . Yii::app()->user->getState('instalasi_nama') . " - " . Yii::app()->user->getState('ruangan_nama');

    $link_daftar = $this->createUrl('/pendaftaranPenjadwalan/pendaftaranBayiBaruLahir/index', array(
      'pendaftaranibu_id' => $persalinan->pendaftaran_id,
    ));


    $notifDaftar = array(
      'instalasi_id' => Params::INSTALASI_ID_RM,
      'ruangan_id' => Params::RUANGAN_ID_LOKET_PENDAFTARAN,
      'modul_id' => Params::MODUL_ID_PENDAFTARAN,
      'link_proses' => $link_daftar
    );

    CustomFunction::broadcastNotif($judul, $isi, array($notifDaftar));


    //var_dump($judul, $isi, $notifDaftar, $pendaftaran->attributes,  $persalinan->attributes, $model->attributes); die;
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

  public function actionDataApgar()
  {

    if (Yii::app()->request->isAjaxRequest)
      $kelahiran = (isset($_POST['kelahiranbayi_id']) ? $_POST['kelahiranbayi_id'] : null);
    $menitke = PSApgarscoreT::model()->findAll(array(
      'select' => 't.menitke',
      'condition' => 'kelahiranbayi_id = ' . $kelahiran,
      'order' => 'menitke',
      'distinct' => true,
    ));
    $modApgarScore = PSApgarscoreT::model()->findAllByAttributes(array('kelahiranbayi_id' => $kelahiran));
    echo CJSON::encode(array(
      'status' => 'create_form',
      'div' => $this->renderPartial('_dataApgar', array('menitke' => $menitke, 'modApgarScore' => $modApgarScore, 'noid' => $kelahiran), true)
    ));
    exit;
  }

  public function actionGetMenitKe()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $menitke = $_POST['menitke'];
      $kelahiranbayi_id = $_POST['kelahiranbayi_id'];

      $hasil = ApgarscoreT::model()->findAllByAttributes(array('menitke' => $menitke, 'kelahiranbayi_id' => $kelahiranbayi_id));
      if (count((array)$hasil) > 0) {
        $hasil = true;
      } else {
        $hasil = false;
      }

      echo CJSON::encode($hasil);
      exit;
    }
  }

  public function actionHapusApgar()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $ok = 1;
    $msg = "Data apgar berhasil dihapus.";

    if (!ApgarscoreT::model()->deleteAllByAttributes(array(
      'kelahiranbayi_id' => $_POST['id'],
      'menitke' => $_POST['menitke'],
    ))) {
      $ok = 0;
      $msg = "Data apgar gagal dihapus.";
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }

  public function actionUpdateApgar()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }
    $id = $_POST['id'];
    $menitke = $_POST['menitke'];

    $kelahiran = KelahiranbayiT::model()->findByPk($id);

    $modApgarScore = PSApgarscoreT::model()->findAllByAttributes(array('kelahiranbayi_id' => $id, 'menitke' => $_POST['menitke']));

    echo CJSON::encode(array(
      'html' => $this->renderPartial('_updateApgar', array('menitke' => $menitke, 'modApgarScore' => $modApgarScore), true),
      'judul' => 'Update Apgar - ' . $kelahiran->namabayi . " - Menit ke-" . $menitke,
    ));
  }

  public function actionSubmitUpdateApgar()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['kelahiranbayi_id'];
    $menitke = $_POST['menitke'];

    $ok = 1;
    $msg = "Data apgar berhasil disimpan.";
    $trans = Yii::app()->db->beginTransaction();

    try {

      $skor = ApgarscoreT::model()->findByAttributes(array(
        'kelahiranbayi_id' => $id,
        'menitke' => $menitke,
      ));


      $total_skor = 0;
      foreach ($_POST['nilai_apgar'] as $metode_id => $nilai) {
        $total_skor += $nilai;
      }

      $crIn = new CDbCriteria();
      $crIn->addCondition($total_skor . ' between interpretasimin and interpretasimax');
      $crIn->addCondition('interpretasiskor_aktif = true');

      $inter = InterpretasiskorM::model()->find($crIn);


      ApgarscoreT::model()->deleteAllByAttributes(array(
        'kelahiranbayi_id' => $id,
        'menitke' => $menitke,
      ));

      foreach ($_POST['nilai_apgar'] as $metode_id => $nilai) {
        $det = new ApgarscoreT();
        $det->kelahiranbayi_id = $skor->kelahiranbayi_id;
        $det->tglapgarscore = $skor->tglapgarscore;
        $det->menitke = $skor->menitke;
        $det->interpretasiskor_id = $inter->interpretasiskor_id;
        $det->metodeapgar_id = $metode_id;
        $det->nilai_apgar = $nilai;
        $det->jmlscore = $total_skor;

        $det->create_time = date('Y-m-d H:i:s');
        $det->create_loginpemakai_id = Yii::app()->user->id;
        $det->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($det->validate()) {
          if (!$det->save()) {
            $ok = 0;
          }
        } else {
          $ok = 0;
        }
      }

      if ($ok == 1) {
        $trans->commit();
      } else {
        $trans->rollback();
        $msg = "Data apgar gagal disimpan";
      }
    } catch (Exception $ex) {
      $trans->rollback();
      $ok = 0;
      $msg = "Data apgar gagal disimpan.<br/>" . $ex->getMessage();
    }

    echo CJSON::encode(array(
      'ok' => $ok,
      'msg' => $msg,
    ));
  }
}
