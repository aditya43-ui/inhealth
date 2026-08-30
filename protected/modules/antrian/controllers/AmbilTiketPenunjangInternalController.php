<?php

class AmbilTiketPenunjangInternalController extends Controller
{
  public $layout = '//layouts/kiosAntrian';

  public $pathView = 'antrian.views.ambilTiketPenunjangInternal.';
  public $pathView_umum_asuransi = 'antrian.views.ambilTiketUmumAsuransi.';
  public $pathView_bpjs = 'antrian.views.ambilTiketBpjs.';

  public function actionIndexLab()
  {
    $this->layout = '//layouts/kiosAntrian';
    $criteria = new CdbCriteria();
    $criteria->addCondition('loket_aktif = true');
    $criteria->order = "loket_nourut";
    $modLokets = ANLoketM::model()->find("is_penunjang = TRUE AND loket_aktif=TRUE and lower(loket_singkatan) ilike 'l' ORDER BY loket_nourut");
    $model = new ANAntrianT;

    $this->render($this->pathView . 'index', array('model' => $model, 'modLokets' => $modLokets));
  }

  public function actionIndexRad()
  {
    $this->layout = '//layouts/kiosAntrian';
    $criteria = new CdbCriteria();
    $criteria->addCondition('loket_aktif = true');
    $criteria->order = "loket_nourut";
    $modLokets = ANLoketM::model()->find("is_penunjang = TRUE AND loket_aktif=TRUE and lower(loket_singkatan) ilike 'r' ORDER BY loket_nourut");
    $model = new ANAntrianT;



    $this->render($this->pathView . 'index', array('model' => $model, 'modLokets' => $modLokets));
  }
  /**
   * untuk menyimpan tiket (ajax)
   */
  public function actionSimpanTiket()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $data['pesan'] = "Data gagal disimpan! ";
      if (isset($_POST['data'])) {
        parse_str($_POST['data'], $post);
        $model = new ANAntrianT;
        $model->attributes = $post['ANAntrianT'];
        $model->profilrs_id = Params::getDefaultProfilRS();
        $model->ruangan_id = Params::DEFAULT_RUANGAN_KIOSK;
        $model->tglantrian = date('Y-m-d H:i:s');
        $model->noantrian = (empty($model->noantrian) ? MyGenerator::noAntrianLoket($model->loket_id, $model->loket->loket_formatnomor) : $model->noantrian);

        $loket = LoketM::model()->findByPk($model->loket_id);

        // menentukan tgl dilayani
        $model->tglakandilayani = $this->hitungTglDilayani($model);

        $delaytombol = $this->actionGetDelayTombolAntrian();
        if ($model->validate()) {
          $model->save();
          $data['model'] = $model;
          $data['singkatan'] = $loket->loket_singkatan;
          $data['nomor_lanjut'] = MyGenerator::noAntrianLoket($model->loket_id, $model->loket->loket_formatnomor);
          $data['delaytombol'] = $delaytombol;
          $data['pesan'] = "Data berhasil disimpan!";
        } else {
          $data['pesan'] = "Data gagal disimpan! " . CHtml::errorSummary($model);
        }
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  public function hitungTglDilayani($model)
  {
    $loket = LoketM::model()->findByPk($model->loket_id);

    $tgl_buka = new DateTime(date('Y-m-d') . " " . $loket->bukaloketantrian);
    $tgl_antrian = new DateTime($model->tglantrian);

    if ($model->noantrian == '001') {
      if ($tgl_antrian < $tgl_buka) {
        return $tgl_buka->format('Y-m-d H:i:s');
      }
      return $tgl_antrian->format('Y-m-d H:i:s');
    }

    $cr = new CDbCriteria();
    $cr->order = 'antrian_id desc';
    $cr->compare('loket_id', $model->loket_id);
    $cr->addCondition("tglantrian::date = current_date");

    $antrian = AntrianT::model()->find($cr);

    $tgl_layanan_akhir = new DateTime($antrian->tglakandilayani);


    if (!empty($loket->estimasiantrian)) {

      if ($tgl_layanan_akhir < $tgl_antrian) {
        $tgl_antrian->add(new DateInterval("PT" . $loket->estimasiantrian . "M"));
        return $tgl_antrian->format('Y-m-d H:i:s');
      }
      $tgl_layanan_akhir->add(new DateInterval("PT" . $loket->estimasiantrian . "M"));
    }


    return $tgl_layanan_akhir->format('Y-m-d H:i:s');
  }

  public function actionPrint($antrian_id)
  {
    $modAntrian = ANAntrianT::model()->findByPk($antrian_id);
    $this->layout = '//layouts/printWindows';
    $this->render($this->pathView . 'printNoAntrian', array('modAntrian' => $modAntrian));
  }

  public function actionGetRunningText()
  {
    //konfig tidak ngambil dari session (state) karena tidak ada login untuk controller ini
    $konfig = KonfigsystemK::model()->find();

    $text = $konfig->running_text_kiosk;

    echo json_encode($text);
  }

  public function actionGetDelayTombolAntrian()
  {
    //konfig tidak ngambil dari session (state) karena tidak ada login untuk controller ini
    $konfig = KonfigsystemK::model()->find();

    $delaytombol = $konfig->delaytombolantrian;

    return $delaytombol;
  }

  public function actionIndexUmumAsuransi()
  {
    $criteria = new CdbCriteria();
    $criteria->addCondition('loket_aktif = true');
    $criteria->order = "loket_nourut";

    $modLokets = ANLoketM::model()->findAll('loket_id in(' . Params::LOKET_ID_UMUM . ',' . Params::LOKET_ID_ASURANSI . ') AND ispendaftaran = TRUE AND loket_aktif=TRUE ORDER BY loket_nourut');
    $model = new ANAntrianT;

    $this->render($this->pathView_umum_asuransi . 'index', array('model' => $model, 'modLokets' => $modLokets));
  }

  public function actionIndexBpjs()
  {
    $criteria = new CdbCriteria();
    $criteria->addCondition('loket_aktif = true');
    $criteria->order = "loket_nourut";

    $modLokets = ANLoketM::model()->findAll('loket_id = ' . Params::LOKET_ID_BPJS . ' AND ispendaftaran = TRUE AND loket_aktif=TRUE ORDER BY loket_nourut');
    $model = new ANAntrianT;

    $this->render($this->pathView_bpjs . 'index', array('model' => $model, 'modLokets' => $modLokets));
  }
}
