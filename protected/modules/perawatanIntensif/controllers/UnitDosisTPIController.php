<?php
class UnitDosisTPIController extends MyAuthController
{
  protected $successSave = false;

  public function actionIndex($pendaftaran_id = null, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/iframe';
    $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
    $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $diagnosaPasien = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $dietPasien = DietpasienT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $fisikPasien = PemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'pemeriksaanfisik_id desc', 'limit' => 1));

    $idDiagnosa = array();
    $idJenisDiet = array();
    $idAlergi = array();
    foreach ($diagnosaPasien as $key => $diagnosas) {
      $idDiagnosa[] = $diagnosas->diagnosa_id;
      if (empty($diagnosas->diagnosa_id)) {
        $idDiagnosa[] = null;
      }
      $criteria = new CDbCriteria();
      $criteria->addInCondition('diagnosa_id', $idDiagnosa);
      $diagnosa = DiagnosaM::model()->findAll($criteria);
    }

    foreach ($dietPasien as $i => $diet) {
      $idJenisDiet[] = $diet->jenisdiet_id;
      if (empty($diet->jenisdiet_id)) {
        $idJenisDiet[] = null;
      }
      $criteriaDiet = new CDbCriteria();
      $criteriaDiet->addInCondition('jenisdiet_id', $idJenisDiet);
      $jenisdiet = JenisdietM::model()->findAll($criteriaDiet);
    }

    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modUnitDosis = new PIUnitdosisT;
    $modUnitDosisDetail = new PIUnitdosisdetailT;
    $modUnitDosis->tgluntidosis = date('d M Y h:i:s');
    $modUnitDosis->beratbadan_kg = $fisikPasien[0]->beratbadan_kg;
    $modUnitDosis->tinggibadan_cm = $fisikPasien[0]->tinggibadan_cm;
    if (isset($_POST['PIUnitdosisT'])) {
      //                echo "a";exit;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        //                    echo "b";exit;
        $this->saveUnitDosis($_POST, $modPendaftaran);

        if ($this->successSave) {
          //                        echo "c";exit;
          $transaction->commit();
          $modUnitDosis->isNewRecord = FALSE;
          $modUnitDosisDetail->isNewRecord = FALSE;
          Yii::app()->user->setFlash('success', "Data Resep berhasil disimpan");
        } else {
          echo "d";
          exit;
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        //                    echo "e";exit;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    if (isset($_GET['test'])) {
      $_GET['term'] = (isset($_GET['term'])) ? $_GET['term'] : null;
      $_GET['term2'] = (isset($_GET['term2'])) ? $_GET['term2'] : null;
      $_GET['term3'] = (isset($_GET['term3'])) ? $_GET['term3'] : null;
      $_GET['term4'] = (isset($_GET['term4'])) ? $_GET['term4'] : null;
      if (Yii::app()->request->isAjaxRequest) {
        $criteria = new CDbCriteria();
        $criteria->with = array('satuankecil', 'satuanbesar');
        $criteria->compare('LOWER(t.obatalkes_kode)', strtolower($_GET['obatalkes_kode']), true);
        $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($_GET['obatalkes_nama']), true);
        $criteria->compare('LOWER(satuankecil.satuankecil_nama)', strtolower($_GET['satuankecil_nama']), true);
        $criteria->compare('LOWER(satuanbesar.satuanbesar_nama)', strtolower($_GET['satiambesar_nama']), true);
        $criteria->order = 't.obatalkes_nama';

        $models = 'ObatalkesM';

        $dataProvider = new CActiveDataProvider($models, array(
          'criteria' => $criteria,
        ));
        $route = Yii::app()->createUrl($this->route, array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'idObat' => $_GET['idObat']));
        $route2 = Yii::app()->createUrl($this->route, array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'idObat' => $_GET['idObat']));
        $route3 = Yii::app()->createUrl($this->route, array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'idObat' => $_GET['idObat']));
        $route4 = Yii::app()->createUrl($this->route, array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'idObat' => $_GET['idObat']));

        $this->renderPartial('_dialog', array('dataProvider' => $dataProvider, 'models' => $models, 'route' => $route, 'route2' => $route2, 'route3' => $route3, 'route4' => $route4));
        Yii::app()->end();
      }
    }

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modUnitDosis' => $modUnitDosis,
      'modAdmisi' => $modAdmisi,
      'modUnitDosisDetail' => $modUnitDosisDetail,
      'diagnosa' => $diagnosa,
      'jenisdiet' => $jenisdiet,
      'models' => $models
    ));
  }

  protected function saveUnitDosis($post, $modPendaftaran)
  {
    //            echo "f";exit;
    $format = new MyFormatter();
    $unitDosis = new PIUnitdosisT;
    $unitDosis->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $unitDosis->pasien_id = $modPendaftaran->pasien_id;
    $unitDosis->pegawai_id = $modPendaftaran->pegawai_id;
    $unitDosis->diagnosa_id = $post['PIUnitdosisT']['diagnosa_id'];
    $unitDosis->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $unitDosis->jenisdiet_id = $post['PIUnitdosisT']['jenisdiet_id'];
    $unitDosis->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $unitDosis->kamarruangan_id = $modPendaftaran->pasienadmisi->kamarruangan_id;
    $unitDosis->nounitdosis = $post['PIUnitdosisT']['nounitdosis'];
    $unitDosis->tgluntidosis = $format->formatDateTimeForDb($post['PIUnitdosisT']['tgluntidosis']);
    $unitDosis->ruanganunitdosis_id = Yii::app()->user->getState('ruangan_id');
    $unitDosis->beratbadan_kg = $post['PIUnitdosisT']['beratbadan_kg'];
    $unitDosis->tinggibadan_cm = $post['PIUnitdosisT']['tinggibadan_cm'];
    $unitDosis->alergiobat = $post['PIUnitdosisT']['alergiobat'];
    if ($unitDosis->validate()) {
      //                echo "g";exit;
      $unitDosis->save();
      $unitDosis->isNewRecord = FALSE;
      $this->saveDetailDosis($_POST['PIUnitdosisdetailT'], $unitDosis);
    } else {
      //                echo print_r($unitDosis->errors,1);
      echo "h";
      exit;
      $this->successSave = false;
    }
  }

  protected function saveDetailDosis($post, $unitDosis)
  {
    //            echo "i";exit;
    $format = new MyFormatter();
    $valid = true;
    if (count((array)$post) > 0) {
      foreach ($post as $i => $datas) {
        //                echo "a";exit;
        $detail = new PIUnitdosisdetailT;
        $detail->attributes = $datas;
        $detail->unitdosis_id = $unitDosis->unitdosis_id;
        $detail->satuankecil_id = $datas['satuankecil_id'];
        $detail->racikan_id = '';
        $detail->sumberdana_id = $datas['sumberdana_id'];
        $detail->obatalkes_id = $datas['obatalkes_id'];
        $detail->r = 'R/';
        $detail->rke = $datas['rke'];
        $detail->signa = $datas['dosis1'] . " X " . $datas['dosis2'];
        $detail->jmlhari = $datas['jmlhari'];
        $detail->jmlobat = $datas['jmlobat'];
        $detail->tglinsmulai = $format->formatDateTimeForDb($datas['tglinsmulai']);
        $detail->jaminsmulai = $datas['jaminsmulai'];
        $detail->tglinsstop =  $format->formatDateTimeForDb($datas['tglinsstop']);
        $detail->jaminsstop = $datas['jaminsstop'];
        $detail->etiket = $datas['etiket'];

        $detail->harganetto = $datas['harganetto'];
        $detail->hargasatuan = $datas['hargasatuan'];
        $detail->hargajual = $datas['hargajual'];

        $detail->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $detail->create_loginpemakai_id = YIi::app()->user->id;
        $detail->create_time = date('Y-m-d H:i:s');
        $valid = $detail->validate() && $valid;
        //                    echo "<pre>";
        //                    echo print_r($detail->getAttributes());
        //                    echo print_r($detail->errors,1);
        if ($valid) {
          //                        echo "a";
          $detail->save();
          $detail->isNewRecord = FALSE;
        } else {
          //                        echo "b";
        }
      }
      //                exit;
    }

    $this->successSave = ($valid) ? true : false;
  }
}
