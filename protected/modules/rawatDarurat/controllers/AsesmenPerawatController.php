<?php

/**
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * 
 * Menu Asesemen Perawat / Pasien IGD ini berisi form pencatatan atas apa yang dilakukan
 * perawat pada pasien di IGD.
 */

Yii::import('application.modules.rawatJalan.models.RJObatAlkesM');

class AsesmenPerawatController extends Controller
{
  public $path_view = 'rawatDarurat.views.asesmenPerawat.';

  public function actionIndex($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';

    $model = AsesmenpasienigdT::model()->findData($pendaftaran_id);
    $masalahKeperawatan = $this->getMasalahKeperawatan();
    $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modTindakan = array();
    $terapi = array();

    if (empty($model)) {
      $model = new AsesmenpasienigdT;
    } else {
      $edukasi = CHtml::listData(AsesmenedukasipasienT::model()->findAllByAttributes(array(
        'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
      )), 'edukasipasien', 'edukasipasien');
      $model->edukasipasien = $edukasi;

      $modTindakan = AsesmenigdtindakT::model()->findAllByAttributes(array(
        'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
      ));

      $terapi = AsesmenigdterapiT::model()->findAllByAttributes(array(
        'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
      ));

      // var_dump($model->attributes); die;

      if (!empty($model->tindakanlanjutan)) {
        $model->rujukan = 1;
      } else if (!empty($model->rujukankeluar_id)) {
        $model->rujukan = 2;
      } else if (!empty($model->dipulangkan) || !empty($model->dipulangkan_tgl)) {
        $model->rujukan = 3;
        if (!empty($model->dipulangkan_tgl)) {
          $model->dipulangkan_tgl = MyFormatter::formatDateTimeForUser($model->dipulangkan_tgl);
        }
      }
    }




    if (isset($_POST['AsesmenpasienigdT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      // var_dump($_POST);

      try {

        // var_dump($_POST);
        $model->rujukankeluar_id = null;
        $model->dipulangkan = null;
        $model->dipulangkan_tgl = null;
        $model->tindakanlanjutan = null;


        $model->attributes = $_POST['AsesmenpasienigdT'];
        $model->pendaftaran_id = $pendaftaran->pendaftaran_id;
        $model->pasien_id = $pendaftaran->pasien_id;
        $model->asesmenpasienigd_tgl = date('Y-m-d H:i:s');
        $model->asesmenpasienigd_no = MyGenerator::noAsesmentPasien();
        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        if (!empty($model->dipulangkan_tgl)) {
          $model->dipulangkan_tgl = MyFormatter::formatDateTimeForDB($model->dipulangkan_tgl);
        }

        // var_dump($model->attributes); die;

        if ($model->validate() || $model->validate()) {
          $ok = $ok && $model->save();
        } else $ok = false;

        // edukasi pasien;
        AsesmenedukasipasienT::model()->deleteAllByAttributes(array(
          'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
        ));
        if (isset($_POST['AsesmenpasienigdT']['edukasipasien'])) {

          foreach ($_POST['AsesmenpasienigdT']['edukasipasien'] as $item) {
            $edukasi = new AsesmenedukasipasienT();
            $edukasi->asesmenpasienigd_id = $model->asesmenpasienigd_id;
            $edukasi->edukasipasien = $item;
            $ok = $ok && $edukasi->save();

            // var_dump($edukasi->attributes);
          }
        }

        // var_dump($model->attributes); die;

        // die;

        // dokumen keperawatan

        AsesmenmasalahkepT::model()->deleteAllByAttributes(array(
          'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
        ));
        AsesmentindakankepT::model()->deleteAllByAttributes(array(
          'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
        ));
        AsesmenigdterapiT::model()->deleteAllByAttributes(array(
          'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
        ));
        AsesmenigdtindakT::model()->deleteAllByAttributes(array(
          'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
        ));



        if (isset($_POST['pie'])) {

          if (isset($_POST['pie']['masalah'])) {
            foreach ($_POST['pie']['masalah'] as $id => $item) {
              $masalah = new AsesmenmasalahkepT();
              $masalah->asesmenpasienigd_id = $model->asesmenpasienigd_id;
              $masalah->masalahkeperawatan_id = $id;
              $ok = $ok && $masalah->save();

              // var_dump($masalah->attributes);
            }
          }
          if (isset($_POST['pie']['tindakan'])) {
            foreach ($_POST['pie']['tindakan'] as $id => $item) {
              $tindakan = new AsesmentindakankepT();
              $tindakan->asesmenpasienigd_id = $model->asesmenpasienigd_id;
              $tindakan->tindakankeperawatan_id = $id;
              $ok = $ok && $tindakan->save();

              // var_dump($tindakan->attributes);
            }
          }
        }


        if (isset($_POST['det'])) {
          $ok = $ok && $this->simpanTindakan($model, $_POST['det']);
        }

        if (isset($_POST['terapi'])) {
          $ok = $ok && $this->simpanTerapi($model, $_POST['terapi']);
        }

        // var_dump($ok, $model->attributes, $model->errors); 

        // die;

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
        } else {
          //var_dump($modFisik->getErrors());die;
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data asesmen pasien IGD gagal disimpan " . CHtml::errorSummary($model));
          // die;
        }
      } catch (Exception $exc) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        echo $exc->getMessage();
        die;
      }
    }

    $this->render($this->path_view.'index', array(
      'model' => $model,
      'masalahKeperawatan' => $masalahKeperawatan,
      'pendaftaran' => $pendaftaran,
      'terapi' => $terapi,
      'modTindakan' => $modTindakan,
    ));
  }

  function simpanTindakan($model, $post)
  {
    $ok = true;

    foreach ($post as $item) {
      $tindakan = new AsesmenigdtindakT;
      $tindakan->attributes = $item;
      $tindakan->asesmenigdtindak_tgl = MyFormatter::formatDateTimeForDB($tindakan->asesmenigdtindak_tgl);
      $tindakan->asesmenpasienigd_id = $model->asesmenpasienigd_id;

      $ok = $ok && $tindakan->save();
      // var_dump($tindakan->attributes);
    }

    return $ok;
  }

  function simpanTerapi($model, $post)
  {
    $ok = true;

    foreach ($post as $item) {
      $terapi = new AsesmenigdterapiT;
      $terapi->attributes = $item;
      $terapi->asesmenigdterapi_tgl = MyFormatter::formatDateTimeForDB($terapi->asesmenigdterapi_tgl);

      $terapi->asesmenpasienigd_id = $model->asesmenpasienigd_id;

      $ok = $ok && $terapi->save();

      // var_dump($terapi->attributes);
    }

    return $ok;
  }

  function actionPrint($id)
  {
    $this->layout = '//layouts/printWindows';

    $model = AsesmenpasienigdT::model()->findData(null, $id);
    $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
    $pasien = PasienM::model()->findByPk($model->pasien_id);
    $masalahKeperawatan = $this->getMasalahKeperawatan();

    $edukasi = CHtml::listData(AsesmenedukasipasienT::model()->findAllByAttributes(array(
      'asesmenpasienigd_id' => $model->asesmenpasienigd_id,
    )), 'edukasipasien', 'edukasipasien');
    $model->edukasipasien = $edukasi;

    $this->render($this->path_view.'print', array(
      'model' => $model,
      'pendaftaran' => $pendaftaran,
      'pasien' => $pasien,
      'masalahKeperawatan' => $masalahKeperawatan,
    ));
  }


  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * Menambil data ceklis Masalah dan Tindakan Keperawatan
   * 
   * @return array
   */
  function getMasalahKeperawatan()
  {
    $arr = array();
    $masalah = MasalahkeperawatanM::model()->findAll('masalahkeperawatan_aktif = true order by masalahkeperawatan_grup_order');
    $tindakan = TindakankeperawatanM::model()->findAll('tindakankeperawatan_aktif = true order by tindakankeperawatan_grup_order, tindakankeperawatan_order');

    foreach ($masalah as $item) {
      if (empty($arr[$item->masalahkeperawatan_grup_order])) {
        $arr[$item->masalahkeperawatan_grup_order] = array(
          'masalah' => array(),
          'tindakan' => array(),
        );
      }

      array_push($arr[$item->masalahkeperawatan_grup_order]['masalah'], $item->attributes);
    }

    foreach ($tindakan as $item) {
      array_push($arr[$item->tindakankeperawatan_grup_order]['tindakan'], $item->attributes);
    }

    return $arr;
  }

  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * Fungsi ajax load data Master Rujukan Keluar untuk autocomplete Rujukan Keluar
   * @param type $term
   */
  public function actionGetRujukanKeluar($term)
  {
    $cr = new CDbCriteria;
    $cr->compare('lower(rumahsakitrujukan)', strtolower($term), true);

    $model = RujukankeluarM::model()->findAll();
    $res = array();

    foreach ($model as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->rumahsakitrujukan;
      $sub['value'] = $item->rujukankeluar_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }


  // ------------------- Autocomplete Tindakan ------------------------------


  public function actionAutocompleteTindakan($term = '')
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $modTindakan = new TindakanruanganV('search');
    $modTindakan->unsetAttributes();
    $modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTindakan->daftartindakan_nama = $term;

    $prov = $modTindakan->searchTindakanAsesmen();
    $prov->sort->defaultOrder = 'daftartindakan_nama';

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->daftartindakan_nama;
      $sub['value'] = $item->daftartindakan_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  public function actionAutocompleteTindakanPegawai($term = '')
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $modPegawaiTindakan = new PegawaiV('search');
    $modPegawaiTindakan->unsetAttributes();
    $modPegawaiTindakan->kelompokpegawai_id = array(
      Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
      Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN
    );

    $modPegawaiTindakan->nama_pegawai = $term;

    $prov = $modPegawaiTindakan->search();
    $prov->sort->defaultOrder = 'nama_pegawai';

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  // ------------------- Auto Complete Terapi--------------------------------

  public function actionAutocompleteTerapi($term = '')
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $modObatDialog = new RJObatAlkesM('searchObatFarmasiRuangan');
    $modObatDialog->unsetAttributes();
    $modObatDialog->ruangan_id = Params::RUANGAN_ID_APOTEK_1;
    $modObatDialog->obatalkes_nama = $term;


    $prov = $modObatDialog->searchObatFarmasiRuangan();
    $prov->sort->defaultOrder = 'obatalkes_nama';

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->obatalkes_nama;
      $sub['value'] = $item->obatalkes_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  public function actionAutocompleteTerapiPeriksa($term = '')
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $modDokterTerapi = new PegawaiV('search');
    $modDokterTerapi->unsetAttributes();
    $modDokterTerapi->nama_pegawai = $term;

    $prov = $modDokterTerapi->searchDokter();
    $prov->sort->defaultOrder = 'nama_pegawai';

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  public function actionAutocompleteTerapiPemberi($term = '')
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $modPemberiTerapi = new PegawaiV('search');
    $modPemberiTerapi->unsetAttributes();
    $modPemberiTerapi->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
    $modPemberiTerapi->nama_pegawai = $term;

    $prov = $modPemberiTerapi->search();
    $prov->sort->defaultOrder = 'nama_pegawai';

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
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
