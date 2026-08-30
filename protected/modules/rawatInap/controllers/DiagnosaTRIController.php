<?php
//Yii::import('rawatJalan.controllers.DiagnosaController');
//Yii::import('rawatJalan.models.*');
//class DiagnosaTRIController extends DiagnosaController
//{
//        
//}
class DiagnosaTRIController extends MyAuthController
{
  protected $successSave;
  public $layout = '//layouts/iframe';
  public function actionIndex($pendaftaran_id, $pasienadmisi_id)
  {
    $successSave = true;
    $printaktif = false;
    $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
    $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modDiagnosa = new RIDiagnosaM('searchDiagnosis');
    $modDiagnosa->unsetAttributes();  // clear any default values

    if (isset($_GET['RIDiagnosaM']))
      $modDiagnosa->attributes = $_GET['RIDiagnosaM'];

    $modMorbiditas[0] = new RIPasienMorbiditasT;
    $modMorbiditas[0]->pendaftaran_id = $pendaftaran_id;
    $modMorbiditas[0]->pasien_id = $modPendaftaran->pasien_id;
    $modMorbiditas[0]->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modMorbiditas[0]->kelompokumur_id = $modPasien->kelompokumur_id;
    $modMorbiditas[0]->golonganumur_id = $modPendaftaran->golonganumur_id;
    $modMorbiditas[0]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modMorbiditas[0]->pegawai_id = $modAdmisi->pegawai_id;

    $modKasuspenyakitDiagnosa = new KasuspenyakitdiagnosaV('search');
    $modKasuspenyakitDiagnosa->unsetAttributes();  // clear any default values
    $modKasuspenyakitDiagnosa->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    if (isset($_GET['RIKasusPenyakitDiagnosaM'])) {
      $modKasuspenyakitDiagnosa->attributes = $_GET['RIKasusPenyakitDiagnosaM'];
      $modKasuspenyakitDiagnosa->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
      $modKasuspenyakitDiagnosa->diagnosa_kode = $_GET['RIKasusPenyakitDiagnosaM']['diagnosa_kode'];
    }

    $modDiagnosaicdixM = new RIDiagnosaicdixM('search');
    $modDiagnosaicdixM->unsetAttributes();  // clear any default values
    if (isset($_GET['RIDiagnosaicdixM']))
      $modDiagnosaicdixM->attributes = $_GET['RIDiagnosaicdixM'];
    $modSebabDiagnosa = RISebabDiagnosaM::model()->findAll();

    $newInput = false;
    if (isset($_POST['Morbiditas'])) {
      $newInput = true;
      $modMorbiditas = $this->saveDiagnosa($_POST['Morbiditas'], $modPasien, $modPendaftaran);
      $successSave = $this->successSave;
    }

    $listMorbiditas = RIPasienMorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $printaktif = (count((array)$listMorbiditas) > 0) ? true : false;

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modDiagnosa' => $modDiagnosa,
      'modKasuspenyakitDiagnosa' => $modKasuspenyakitDiagnosa,
      'modDiagnosaicdixM' => $modDiagnosaicdixM,
      'modSebabDiagnosa' => $modSebabDiagnosa,
      'modMorbiditas' => $modMorbiditas,
      'listMorbiditas' => $listMorbiditas,
      'successSave' => $successSave,
      'newInput' => $newInput,
      'printaktif' => $printaktif,
      'modAdmisi' => $modAdmisi
    ));
  }

  protected function saveDiagnosa($diagnosas, $modPasien, $modPendaftaran)
  {
    $valid = true;
    $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
    foreach ($diagnosas as $i => $diagnosa) {
      $morbiditas[$i] = new RIPasienMorbiditasT;
      $morbiditas[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $morbiditas[$i]->pasien_id = $modPendaftaran->pasien_id;
      $morbiditas[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $morbiditas[$i]->kelompokumur_id = $modPasien->kelompokumur_id;
      $morbiditas[$i]->golonganumur_id = $modPendaftaran->golonganumur_id;
      $morbiditas[$i]->$golUmur = 1;
      $morbiditas[$i]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
      $morbiditas[$i]->pegawai_id = $modPendaftaran->pegawai_id;
      $morbiditas[$i]->diagnosa_id = $diagnosa['diagnosa'];
      $morbiditas[$i]->kelompokdiagnosa_id = $diagnosa['kelompokDiagnosa'];
      $morbiditas[$i]->diagnosaicdix_id = $diagnosa['diagnosaTindakan'];
      $morbiditas[$i]->sebabdiagnosa_id = $diagnosa['sebabDiagnosa'];
      $morbiditas[$i]->infeksinosokomial = '0'; //$diagnosa['infeksiNosokomial'];
      $morbiditas[$i]->tglmorbiditas = $_POST['RIPasienMorbiditasT'][0]['tglmorbiditas'];
      //$morbiditas[$i]->kasusdiagnosa = $_POST['RIPasienMorbiditasT'][0]['kasusdiagnosa'];
      $morbiditas[$i]->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $diagnosa['diagnosa']);
      $morbiditas[$i]->pegawai_id = $_POST['RIPasienMorbiditasT'][0]['pegawai_id'];
      $morbiditas[$i]->pasienadmisi_id = $_GET['pasienadmisi_id'];
      $valid = $morbiditas[$i]->validate() && $valid;
    }
    if ($valid) {
      foreach ($morbiditas as $j => $morbiditasPasien) {
        $morbiditasPasien->save();
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
        $pasienMorbiditas = RIPasienMorbiditasT::model()->findAllByAttributes(
          array(
            'diagnosa_id' => $idDiagnosa
          )
        );
        $data['success'] = true;
        if (count((array)$pasienMorbiditas) > 0) {
          $deleteDiagnosa = RIPasienMorbiditasT::model()->deleteAllByAttributes(
            array(
              'diagnosa_id' => $idDiagnosa
            )
          );
          if (!$deleteDiagnosa) {
            $data['success'] = false;
          }
        } else {
          $deleteDiagnosa = RIPasienMorbiditasT::model()->deleteAllByAttributes(
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
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $listMorbiditas = RIPasienMorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modMorbiditas = RIPasienMorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));


    $judul_print = 'Diagnosa';
    $this->render('print', array(
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
      $idDiagnosa = (isset($_POST['idDiagnosa']) ? $_POST['idDiagnosa'] : null);
      $idKelDiagnosa = (isset($_POST['idKelDiagnosa']) ? $_POST['idKelDiagnosa'] : null);
      $tglDiagnosa = (isset($_POST['tglDiagnosa']) ? $_POST['tglDiagnosa'] : null);

      if (!empty($idKelDiagnosa)) {
        $modDiagnosaicdixM = DiagnosaicdixM::model()->findAll();
        $modSebabDiagnosa = SebabdiagnosaM::model()->findAll();
        $modDiagnosa = DiagnosaM::model()->findByPk($idDiagnosa);

        echo CJSON::encode(array(
          'status' => 'create_form',
          'form' => $this->renderPartial('/diagnosaTRI/_formLoadDiagnosis', array(
            'modDiagnosa' => $modDiagnosa,
            'idKelDiagnosa' => $idKelDiagnosa,
            'modDiagnosaicdixM' => $modDiagnosaicdixM,
            'modSebabDiagnosa' => $modSebabDiagnosa,
            'tglDiagnosa' => $tglDiagnosa
          ), true)
        ));
        exit;
      } else {
        echo CJSON::encode(array('status' => 'fail', 'pesan' => 'Pilih terlebih dahulu kelompok diagnosa!'));
        exit;
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
