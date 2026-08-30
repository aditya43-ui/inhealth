<?php
Yii::import('antrian.controllers.AmbilKarcisFarmasiController');
Yii::import('antrian.models.ANAntrianfarmasiT');
class AmbilKarcisFarmasiApotekController extends AmbilKarcisFarmasiController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'antrian.views.ambilKarcisFarmasiResep.';

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionIndex($id = null, $reseptur_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Ambil Karcis Antrian Farmasi";
    $model = new ANAntrianfarmasiT;
    $model->noantrian = "Otomatis";
    // $model->url_referrer = Yii::app()->request->urlReferrer;


    // $model->noantrian_kasir = "Otomatis";

    if (!empty($id)) {
      $model = ANAntrianfarmasiT::model()->findByPk($id);
      $modAntrianKasir = AntrianT::model()->findByPk($model->antrian_id);
      $model->noantrian_kasir = $modAntrianKasir->loket->loket_singkatan . "-" . $modAntrianKasir->noantrian;
      $model->loker_kasir_id = $modAntrianKasir->loket->loket_id;
      $model->noresep = FAInformasiresepturV::model()->findByAttributes(array('reseptur_id' => $model->reseptur_id))->noreseptur;
    }

    if (!empty($reseptur_id)) {
      $reseptur = ResepturT::model()->findByPk($reseptur_id);
      if (!empty($reseptur)) {
        $model->reseptur_id = $reseptur_id;
        $model->noresep = $reseptur->noresep;
        $detail = ResepturdetailT::model()->findByAttributes(array(
          'racikan_id' => Params::RACIKAN_ID_RACIKAN
        ));

        if (!empty($detail)) {
          $model->racikan_id = Params::RACIKAN_ID_RACIKAN;
        } else {
          $model->racikan_id = Params::RACIKAN_ID_NONRACIKAN;
        }
        if (!empty($reseptur->pasienadmisi_id)) {
          $pendaftaran = PasienadmisiT::model()->findByPk($reseptur->pasienadmisi_id);
          $carabayar_id = $pendaftaran->carabayar_id;
        } else {
          $pendaftaran = PendaftaranT::model()->findByPk($reseptur->pendaftaran_id);
          $carabayar_id = $pendaftaran->carabayar_id;
        }

        if (in_array($carabayar_id, array(Params::CARABAYAR_ID_MEMBAYAR))) {
          $model->modelantrian_id = 1;
        } else if (in_array($carabayar_id, array(Params::CARABAYAR_ID_ASURANSI))) {
          $model->modelantrian_id = 3;
        } else if (in_array($carabayar_id, array(Params::CARABAYAR_ID_BPJS, Params::CARABAYAR_ID_BPJS_TENAGAKERJA))) {
          $model->modelantrian_id = 2;
        }
      }
    }


    if (isset($_POST['ANAntrianfarmasiT'])) {



      $transaction = Yii::app()->db->beginTransaction();
      try {
        $format = new MyFormatter();
        $model->attributes = $_POST['ANAntrianfarmasiT'];

        // $res = array('1111');
        $reseptur_id = explode(", ", $_POST['ANAntrianfarmasiT']['reseptur_id']);

        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->tglambilantrian = date('Y-m-d H:i:s');

        $model->noantrian = MyGenerator::noAntrianFarmasiLoket($model->racikan_id, $model->modelantrian_id);
        
        $model->panggilantrian = false;
        $model->antrianlewat = false;
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');


        $model->url_referrer = $_POST['ANAntrianfarmasiT']['url_referrer'];
        /*
                $model2 = new AntrianT;
                $model2->loket_id = $model->loker_kasir_id;
                $model2->carabayar_id = $model2->loket->carabayar_id;
                $model2->profilrs_id = Params::getDefaultProfilRS();
                $model2->ruangan_id = Params::RUANGAN_ID_KASIR;
                $model2->tglantrian = date('Y-m-d H:i:s');
                $model2->noantrian = (empty($model2->noantrian) ? MyGenerator::noAntrianLoket($model2->loket_id, $model2->loket->loket_formatnomor) : $model2->noantrian);

                $model2->save();
                $model->antrian_id = $model2->antrian_id;
                 * 
                 */

        if ($model->save()) {

          $ok = true;
          if(count($reseptur_id) > 1) {
            $model->reseptur_id = "";
            
            foreach($reseptur_id as $rs) {
  
              $modAntReseptur = new Antrianreseptur;
              $modAntReseptur->antrianfarmasi_id = $model->antrianfarmasi_id;
              $modAntReseptur->reseptur_id = $rs;
              $ok &= $modAntReseptur->save();
  
            }
  
  
          } else if (count($reseptur_id) == 1){
            $model->reseptur_id = $reseptur_id[0];
          }

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan.");
          $this->redirect(array('index'));
        }
        $transaction->rollback();
      } catch (Exception $exc) {
        echo '<pre>'; var_dump($exc); die;
        $transaction->rollback();
        $sukses = 0;
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
    ));
  }

  /**
   * actionPrintKwPenjualanResep digunakan untuk print karcis antrian
   * @param type $id
   */
  public function actionPrintKarcisFarmasi($id, $caraprint = null)
  {
    $this->layout = '//layouts/iframe';
    if ($caraprint == 'PRINT') {
      $this->layout = '//layouts/printWindowstiket';
    }
    $format = new MyFormatter();
    $modAntrian = ANAntrianfarmasiT::model()->findByPk($id);
    $judulLaporan = 'Antrian Farmasi';

    $this->render($this->path_view . 'PrintKarcisFarmasi', array('format' => $format, 'modAntrian' => $modAntrian, 'judulLaporan' => $judulLaporan));
  }

  /**
   * Autocomplete resep pasien
   */
  public function actionAutocompleteResep()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(noreseptur)', strtolower($_GET['noresep']), true);
      $criteria->addCondition('penjualanresep_id is null');
      $criteria->order = 'noreseptur';
      $criteria->limit = 10;
      $models = FAInformasiresepturV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();

        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->noreseptur;
        $returnVal[$i]['value'] = $model->reseptur_id;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
