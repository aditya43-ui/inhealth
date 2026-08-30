<?php

/**
 * digunakan untuk transaksi surveilans tab pemeriksaan pasien
 * @author      Rusdiyanto <rusdsiyanto@.com>
 * @author      Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package     application.modules.rawatJalan
 * @subpackage  controllers
 */
class SurveilansTController extends MyAuthController
{

  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $path_view = 'rawatJalan.views.surveilans.';
  public $path_view_dialog_pasien = 'rawatJalan.views.surveilans.';

  /**
   * digunakan untuk insert data via Pemeriksaan Pasien
   * @param integer $pendaftaran_id
   */
  public function actionIndex($pendaftaran_id, $surveilans_id = null)
  {
    $format = new MyFormatter();
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modLoginpemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
    $modPegawai = PegawaiM::model()->findByPk($modLoginpemakai->pegawai_id);
    $modRiwayatSurveilans = array();
    $modSurveilans = new RJSurveilansT;
    //        $modSurveilans->vap = true;
    $modSurveilans->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modSurveilans->surveilans_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d'));


    if (!empty($surveilans_id)) {
      $modSurveilans = RJSurveilansT::model()->findByPk($surveilans_id);
      $modSurveilans->surveilans_tgl = MyFormatter::formatDateTimeForUser($modSurveilans->surveilans_tgl);
      $modSurveilans->pelepasan_tgl = MyFormatter::formatDateTimeForUser($modSurveilans->pelepasan_tgl);
      $modSurveilans->infeksi_tgl = MyFormatter::formatDateTimeForUser($modSurveilans->infeksi_tgl);
    }
    if (isset($_POST['RJSurveilansT'])) {
      $transaction = Yii::app()->db->beginTransaction();

      try {
        $modSurveilans->attributes = $_POST['RJSurveilansT'];
        $modSurveilans->cdl = $_POST['RJSurveilansT']['cdl'];
        $modSurveilans->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modSurveilans->pasien_id = $modPasien->pasien_id;
        $modSurveilans->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modSurveilans->create_loginpemakai_id = Yii::app()->user->id;
        $modSurveilans->pegawai_id = $modPegawai->pegawai_id;
        if (!empty($modSurveilans->surveilans_tgl)) {
          $modSurveilans->surveilans_tgl = $format->formatDateTimeForDb($_POST['RJSurveilansT']['surveilans_tgl']);
        }
        if (!empty($modSurveilans->pelepasan_tgl)) {
          $modSurveilans->pelepasan_tgl = $format->formatDateTimeForDb($_POST['RJSurveilansT']['pelepasan_tgl']);
        }
        if (!empty($modSurveilans->infeksi_tgl)) {
          $modSurveilans->infeksi_tgl = $format->formatDateTimeForDb($_POST['RJSurveilansT']['infeksi_tgl']);
        }

        $modSurveilans->pelepasan_tgl = empty($modSurveilans->pelepasan_tgl) ? null : $modSurveilans->pelepasan_tgl;
        $modSurveilans->infeksi_tgl = empty($modSurveilans->infeksi_tgl) ? null : $modSurveilans->infeksi_tgl;

        // var_dump($modSurveilans->attributes); die;


        if ($modSurveilans->save()) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Surveilans HAis berhasil disimpan");

          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $modRiwayatSurveilans = RJSurveilansT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id));

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modSurveilans' => $modSurveilans,
      'modRiwayatSurveilans' => $modRiwayatSurveilans,
      'path_view' => $this->path_view,
    ));
  }

  /**
   * digunakan untuk insert data via Menu
   * @param integer $pendaftaran_id
   */
  public function actionPeriksa($pendaftaran_id = null, $surveilans_id = null)
  {

    $this->layout = '//layouts/mainNeonSidebar';

    $format = new MyFormatter();
    $modPendaftaran = new RJPendaftaranT; //RJPendaftaranT::model()->findByPk($pendaftaran_id); 
    $modPasien = new RJPasienM; //RJPasienM::model()->findByPk($modPendaftaran->pasien_id);  
    $modLoginpemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
    $modPegawai = PegawaiM::model()->findByPk($modLoginpemakai->pegawai_id);
    $modRiwayatSurveilans = array();
    $modSurveilans = new RJSurveilansT;
    //        $modSurveilans->vap = true;
    $modSurveilans->surveilans_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d'));


    if (!empty($pendaftaran_id)) {
      $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

      $json = $modPendaftaran->getJSONKunjunganPasienUntukSurveilance();

      $modPendaftaran->tgl_pendaftaran = $json['tgl_pendaftaran'];
      $modPendaftaran->jeniskasuspenyakit_nama = $json['jeniskasuspenyakit_nama'];
      $modPendaftaran->dokter_pemeriksa = $json['dokter_pemeriksa'];
      $modPendaftaran->carabayar_nama = $json['carabayar_nama'];
      $modPendaftaran->penjamin_nama = $json['penjamin_nama'];
    }

    if (isset($_POST['RJSurveilansT']) && isset($_POST['RJPendaftaranT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $modPendaftaran = RJPendaftaranT::model()->findByPk($_POST['RJPendaftaranT']['pendaftaran_id']);
      $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

      try {
        $modSurveilans->attributes = $_POST['RJSurveilansT'];
        $modSurveilans->cdl = $_POST['RJSurveilansT']['cdl'];
        $modSurveilans->pendaftaran_id = $_POST['RJPendaftaranT']['pendaftaran_id'];
        $modSurveilans->pasien_id = $modPasien->pasien_id;
        $modSurveilans->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modSurveilans->create_loginpemakai_id = Yii::app()->user->id;
        $modSurveilans->pegawai_id = $modPegawai->pegawai_id;
        $modSurveilans->surveilans_tgl = $format->formatDateTimeForDb($_POST['RJSurveilansT']['surveilans_tgl']);


        if ($modSurveilans->save()) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Surveilans HAis berhasil disimpan");

          $this->redirect(array('index', 'pendaftaran_id' => $modSurveilans->pendaftaran_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");

          $this->refresh();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));

        $this->refresh();
      }
    }
    $modRiwayatSurveilans = RJSurveilansT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id));

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modSurveilans' => $modSurveilans,
      'modRiwayatSurveilans' => $modRiwayatSurveilans,
      'path_view' => $this->path_view,
    ));
  }

  /**
   * Pencarian Pasien untuk transaksi Surveilance.
   * 
   * @param  RJPendaftaranT $model
   * @param  boolean $pagination
   * @return \CActiveDataProvider
   */
  public function searchPasien($model, $pagination = true)
  {
    $criteria = new CDbCriteria();
    $criteria->join = 'left join pasienpulang_t p on p.pendaftaran_id = t.pendaftaran_id and p.carakeluar_id <> 5 and p.pasienbatalpulang_id is null '
      . 'left join pasienadmisi_t a on a.pasienadmisi_id = t.pasienadmisi_id '
      . 'left join pasien_m pa on pa.pasien_id = t.pasien_id';
    $criteria->compare('lower(t.no_pendaftaran)', strtolower($model->no_pendaftaran), true);
    $criteria->compare('lower(pa.nama_pasien)', strtolower($model->nama_pasien), true);
    $criteria->compare('lower(pa.jeniskelamin)', strtolower($model->jeniskelamin), true);
    $criteria->compare('lower(pa.no_rekam_medik)', strtolower($model->no_rekam_medik), true);
    // $criteria->addCondition('p.pasienpulang_id is null');

    $criteria->order = 't.tgl_pendaftaran desc';
    $criteria->addCondition("t.statusperiksa not in ('SUDAH PULANG')");
    $criteria->compare('(case when a.pasienadmisi_id is not null then a.ruangan_id else t.ruangan_id end)', Yii::app()->user->getState('ruangan_id'));

    $prov = new CActiveDataProvider($model, array(
      'criteria' => $criteria,
    ));

    if (!$pagination) {
      $prov->pagination = false;
    }

    return $prov;
  }

  /**
   * Autocomplete Pencarian Pasien untuk transaksi Surveilance.
   * 
   * @param string $term No. Pendaftaran yang akan dicari
   */
  public function actionAutocompletePasien($term = "")
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new RJPendaftaranT;
    $model->no_pendaftaran = $term;

    $res = array();

    foreach ($this->searchPasien($model, false)->data as $item) {


      $item->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($item->tgl_pendaftaran);

      $pasien = PasienM::model()->findByPk($item->pasien_id);
      $modRiwayatSurveilans = RJSurveilansT::model()->findAllByAttributes(array('pasien_id' => $pasien->pasien_id));

      $sub = $item->getJSONKunjunganPasienUntukSurveilance();

      $sub['label'] = $item->no_pendaftaran . " - " . $pasien->namadepan . $pasien->nama_pasien . " - " . $pasien->no_rekam_medik;
      $sub['value'] = $item->pendaftaran_id;
      $sub['riwayat'] = "";

      foreach ($modRiwayatSurveilans as $item2) {
        $sub['riwayat'] .= $this->renderPartial($this->path_view . "_rowRiwayatPasien", array(
          'data' => $item2,
          'modPasien' => $pasien,
        ), true);
      }

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  /**
   * digunakan untuk batal
   */
  public function actionAjaxBatalSurveilans()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $surveilans_id = (isset($_POST['idSurveilans']) ? $_POST['idSurveilans'] : null);
      $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);

      $mod = RJSurveilansT::model()->findByPk($surveilans_id);
      RJSurveilansT::model()->deleteByPk($surveilans_id);
      $modRiwayatSurveilans = RJSurveilansT::model()->findAllByAttributes(array('pendaftaran_id' => $$mod->pendaftaran_id));

      $data['result'] = $this->renderPartial($this->path_view . '_tabelRiwayatSurveilans', array('modRiwayatSurveilans' => $modRiwayatSurveilans), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
