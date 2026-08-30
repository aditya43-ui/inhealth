<?php
Yii::import('rawatJalan.models.*');
class DiagnosaController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $successSave;
  protected $path_view = 'rawatJalan.views.diagnosa.';
  public function actionIndex($pendaftaran_id)
  {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modDiagnosa = new RJDiagnosaM('searchDiagnosis');
    $modDiagnosa->unsetAttributes();  // clear any default values
    if (isset($_GET['RJDiagnosaM']))
      $modDiagnosa->attributes = $_GET['RJDiagnosaM'];

    $modMorbiditas[0] = new RJPasienMorbiditasT;
    $modMorbiditas[0]->pendaftaran_id = $pendaftaran_id;
    $modMorbiditas[0]->pasien_id = $modPendaftaran->pasien_id;
    $modMorbiditas[0]->ruangan_id = $ruangan_id;
    $modMorbiditas[0]->kelompokumur_id = $modPasien->kelompokumur_id;
    $modMorbiditas[0]->golonganumur_id = $modPendaftaran->golonganumur_id;
    $modMorbiditas[0]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modMorbiditas[0]->pegawai_id = $modPendaftaran->pegawai_id;

    $modKasuspenyakitDiagnosa = new RJKasusPenyakitDiagnosaM('search');
    $modKasuspenyakitDiagnosa->unsetAttributes();  // clear any default values
    $modKasuspenyakitDiagnosa->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    if (isset($_GET['RJKasusPenyakitDiagnosaM'])) {
      $modKasuspenyakitDiagnosa->attributes = $_GET['RJKasusPenyakitDiagnosaM'];
      $modKasuspenyakitDiagnosa->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    }

    $modDiagnosaicdixM = new RJDiagnosaicdixM('search');
    $modDiagnosaicdixM->unsetAttributes();  // clear any default values
    if (isset($_GET['RJDiagnosaicdixM']))
      $modDiagnosaicdixM->attributes = $_GET['RJDiagnosaicdixM'];
    $modSebabDiagnosa = RJSebabDiagnosaM::model()->findAll();

    $newInput = false;
    if (isset($_POST['Morbiditas'])) {
      //echo "<pre>".print_r($_POST['Morbiditas'],1)."</pre>";exit;
      $newInput = true;
      $modMorbiditas = $this->saveDiagnosa($_POST['Morbiditas'], $modPasien, $modPendaftaran);
    }

    $listMorbiditas = RJPasienMorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modDiagnosa' => $modDiagnosa,
      'modDiagnosaicdixM' => $modDiagnosaicdixM,
      'modKasuspenyakitDiagnosa' => $modKasuspenyakitDiagnosa,
      'modSebabDiagnosa' => $modSebabDiagnosa,
      'modMorbiditas' => $modMorbiditas,
      'listMorbiditas' => $listMorbiditas,
      'successSave' => $this->successSave,
      'newInput' => $newInput
    ));
  }

  protected function saveDiagnosa($diagnosas, $modPasien, $modPendaftaran)
  {
    $valid = true;
    foreach ($diagnosas as $i => $diagnosa) {
      $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
      $morbiditas[$i] = new RJPasienMorbiditasT;
      $morbiditas[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $morbiditas[$i]->pasien_id = $modPendaftaran->pasien_id;
      $morbiditas[$i]->ruangan_id = Params::RUANGAN_ID_KLINIK_MCU;
      $morbiditas[$i]->kelompokumur_id = $modPasien->kelompokumur_id;
      $morbiditas[$i]->golonganumur_id = $modPendaftaran->golonganumur_id;
      //                $morbiditas[$i]->$golUmur = 1;
      $morbiditas[$i]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
      $morbiditas[$i]->pegawai_id = $modPendaftaran->pegawai_id;
      $morbiditas[$i]->diagnosa_id = $diagnosa['diagnosa'];
      $morbiditas[$i]->kelompokdiagnosa_id = $diagnosa['kelompokDiagnosa'];
      $morbiditas[$i]->diagnosaicdix_id = $diagnosa['diagnosaTindakan'];
      $morbiditas[$i]->sebabdiagnosa_id = $diagnosa['sebabDiagnosa'];
      $morbiditas[$i]->infeksinosokomial = '0'; //$diagnosa['infeksiNosokomial'];
      $morbiditas[$i]->tglmorbiditas = $_POST['RJPasienMorbiditasT'][0]['tglmorbiditas'];
      //$morbiditas[$i]->kasusdiagnosa = $_POST['RJPasienMorbiditasT'][0]['kasusdiagnosa'];
      $morbiditas[$i]->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $diagnosa['diagnosa']);
      $morbiditas[$i]->pegawai_id = $_POST['RJPasienMorbiditasT'][0]['pegawai_id'];
      $valid = $morbiditas[$i]->validate() && $valid;
    }
    if ($valid) {
      foreach ($morbiditas as $j => $morbiditasPasien) {
        $morbiditasPasien->save();
        $updateStatusPeriksa = PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
      }
      //echo 'VALID';
      $this->successSave = true;
      Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
      return $morbiditas;
    } else {
      //echo 'TIDAK VALID';
      Yii::app()->user->setFlash('error', "Data tidak valid ");
      return $morbiditas;
    }
  }

  protected function getKasusDiagnosa($pasien_id, $idDiagnosa)
  {
    $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $pasien_id, 'diagnosa_id' => $idDiagnosa));
    if (!empty($modMorbiditas))
      return Params::KASUSDIAGNOSA_KASUS_LAMA;
    else
      return Params::KASUSDIAGNOSA_KASUS_BARU;
  }

  private function cekGolonganUmur($idGolonganUmur)
  {
    switch ($idGolonganUmur) {
      case 1:
        return 'umur_0_28hr';
      case 2:
        return 'umur_28hr_1thn';
      case 3:
        return 'umur_1_4thn';
      case 4:
        return 'umur_5_14thn';
      case 5:
        return 'umur_15_24thn';
      case 6:
        return 'umur_25_44thn';
      case 7:
        return 'umur_45_64thn';
      case 8:
        return 'umur_65';

      default:
        break;
    }
  }

  public function actionAjaxDeleteDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idDiagnosa = $_POST['idDiagnosa'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $pasienMorbiditas = RJPasienMorbiditasT::model()->findAllByAttributes(
          array(
            'diagnosa_id' => $idDiagnosa
          )
        );
        $data['success'] = true;
        if (count((array)$pasienMorbiditas) > 0) {
          $deleteDiagnosa = RJPasienMorbiditasT::model()->deleteAllByAttributes(
            array(
              'diagnosa_id' => $idDiagnosa
            )
          );
          if (!$deleteDiagnosa) {
            $data['success'] = false;
          }
        } else {
          $deleteDiagnosa = RJPasienMorbiditasT::model()->deleteAllByAttributes(
            array(
              'diagnosa_id' => $idDiagnosa
            )
          );
        }

        if ($deleteDiagnosa && $data['success']) {
          $data['success'] = true;
          $transaction->commit();
        } else {
          $data['success'] = false;
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        echo MyExceptionMessage::getMessage($exc, true);
        $data['success'] = false;
      }


      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrintDiagnosa($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $listMorbiditas = RJPasienMorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modMorbiditas = RJPasienMorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judul_print = 'Diagnosa';
    $this->render($this->path_view . 'print', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'listMorbiditas' => $listMorbiditas,
      'modMorbiditas' => $modMorbiditas
    ));
  }

  public function actionLoadFormDiagnosis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idDiagnosa = isset($_POST['idDiagnosa']) ? $_POST['idDiagnosa'] : null;
      $idKelDiagnosa = isset($_POST['idKelDiagnosa']) ? $_POST['idKelDiagnosa'] : null;
      $tglDiagnosa = isset($_POST['tglDiagnosa']) ? $_POST['tglDiagnosa'] : null;

      $modDiagnosaicdixM = DiagnosaicdixM::model()->findAll();
      $modSebabDiagnosa = SebabdiagnosaM::model()->findAll();
      $modDiagnosa = DiagnosaM::model()->findByPk($idDiagnosa);

      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial('_formLoadDiagnosis', array(
          'modDiagnosa' => $modDiagnosa,
          'idKelDiagnosa' => $idKelDiagnosa,
          'modDiagnosaicdixM' => $modDiagnosaicdixM,
          'modSebabDiagnosa' => $modSebabDiagnosa,
          'tglDiagnosa' => $tglDiagnosa
        ), true)
      ));
      exit;
    }
  }


  public function actionSaveDiagnosis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $IdPendaftaran = $_POST['IdPendaftaran'];
      $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array('pendaftaran_id' => $IdPendaftaran));
      $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $morbiditas = new RJPasienMorbiditasT;
      $morbiditas->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $morbiditas->pasien_id = $modPendaftaran->pasien_id;
      $morbiditas->ruangan_id = Params::RUANGAN_ID_KLINIK_MCU;
      $morbiditas->kelompokumur_id = $modPasien->kelompokumur_id;
      $morbiditas->golonganumur_id = $modPendaftaran->golonganumur_id;
      $morbiditas->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
      $morbiditas->pegawai_id = $modPendaftaran->pegawai_id;
      $morbiditas->diagnosa_id = $_POST['idDiagnosa'];
      $morbiditas->kelompokdiagnosa_id = $_POST['kelompokDiagnosa'];
      $morbiditas->infeksinosokomial = '0';
      $morbiditas->tglmorbiditas = (isset($_POST['tglDiagnosa']) ? $_POST['tglDiagnosa'] : null);

      $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $modPendaftaran->pasien_id, 'diagnosa_id' => $morbiditas->diagnosa_id));
      if (!empty($modMorbiditas))
        $morbiditas->kasusdiagnosa = Params::KASUSDIAGNOSA_KASUS_LAMA;
      else
        $morbiditas->kasusdiagnosa = Params::KASUSDIAGNOSA_KASUS_BARU;

      $valid = $morbiditas->validate();
      if ($valid) {
        $morbiditas->save();
      }
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
