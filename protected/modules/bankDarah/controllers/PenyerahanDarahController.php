<?php

/**
 * Form dan Printout Penyerahan Darah
 * 
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @version    2.0.0
 * @package    application.modules.bankDarah
 * @subpackage controllers
 */
class PenyerahanDarahController extends MyAuthController
{
  public $path_view = 'bankDarah.views.penyerahanDarah.';

  /**
   * Form Penyerahan Darah. Dimunculkan jika transkasi Penyiapan darah
   * sudah dilakukan
   * 
   * @param type $id ID Permintaan Darah
   */
  public function actionIndex($id = null, $penyerahandarah_ke = null, $frame = 0)
  {
    if ($frame == 1) {
      $this->layout = "//layouts/iframe";
    }

    $model = new PenyerahandarahT;
    $model->tglpenyerahan = date("d M Y H:i:s");
    $peg = BDPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
    if (!empty($peg)) {
      $model->peg_ygmenyerahkan_id = $peg->pegawai_id;
      $model->peg_ygmenyerahkan_nama = $peg->namaLengkap;
    }

    if (!empty($id)) {
      $model->permintaandarah_id = $id;

      $permintaan = PermintaandarahT::model()->findByPk($id);

      $cri = new CDbCriteria();
      $cri->join = "  LEFT JOIN penyerahandarah_t serah ON serah.penyiapandarah_id = t.penyiapandarah_id ";
      if (isset($_GET['sukses'])) {
        $cri->addCondition(" t.permintaandarah_id = '" . $id . "' AND penyerahandarah_ke = '" . $penyerahandarah_ke . "' AND serah.penyerahandarah_id is not null ");
      } else {
        if ($frame == 1) {
          $cri->addCondition(" t.permintaandarah_id = '" . $id . "' AND penyerahandarah_ke = '" . $penyerahandarah_ke . "' AND serah.penyerahandarah_id is not null ");
        } else {
          $cri->addCondition(" t.permintaandarah_id = '" . $id . "' AND serah.penyerahandarah_id is null ");
        }
      }
      $cri->order = " t.tglpenyiapandarah DESC ";
      $penyiapan = PenyiapandarahT::model()->findAll($cri);

      $pendaftaran = PendaftaranT::model()->findByPk($permintaan->pendaftaran_id);
      $model->pendaftaran_id = $pendaftaran->pendaftaran_id;
    } else {
      $permintaan = new PermintaandarahT;
      $penyiapan = array();
      $pendaftaran = new PendaftaranT;
    }

    if (isset($_POST['PenyerahandarahT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      $gen = MyGenerator::penyerahanDarahKe($_POST['PenyerahandarahT']['permintaandarah_id']);
      foreach ($_POST['PenyerahandarahT']['detail'] as $penyiapandarah_id => $detail) {
        $submodel = new PenyerahandarahT;
        $submodel->attributes = $_POST['PenyerahandarahT'];
        $submodel->attributes = $detail;
        $submodel->penyiapandarah_id = $penyiapandarah_id;
        $submodel->penyerahandarah_ke = $gen;

        $submodel->tglverifikasi = !empty($submodel->tglverifikasi) ? MyFormatter::formatDateTimeForDb($submodel->tglverifikasi) : null;
        $submodel->tglpenyerahan = !empty($submodel->tglpenyerahan) ? MyFormatter::formatDateTimeForDb($submodel->tglpenyerahan) : null;

        $submodel->create_time = date('Y-m-d H:i:s');
        $submodel->create_loginpemakai_id = Yii::app()->user->id;
        $submodel->create_ruangan = Yii::app()->user->getState('ruangan_id');


        if ($submodel->validate()) {
          $ok = $ok && $submodel->save();
          $id = $submodel->permintaandarah_id;
        } else {
          $ok = false;
        }
      }

      try {
        if ($ok) {

          $this->notifPenyerahanDarah($submodel);

          $trans->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
          $this->redirect(array('index', 'id' => $id, 'frame' => $frame, 'sukses' => 1, 'penyerahandarah_ke' => $submodel->penyerahandarah_ke));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $this->redirect(array('index', 'id' => $submodel->permintaandarah_id, 'frame' => $frame));
        }
      } catch (Exception $exc) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $this->redirect(array('index', 'id' => $submodel->permintaandarah_id, 'frame' => $frame));
      }
    }


    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'permintaan' => $permintaan,
      'penyiapan' => $penyiapan,
      'pendaftaran' => $pendaftaran,
    ));
  }


  public function notifPenyerahanDarah($penyerahan)
  {
    $permintaan = PermintaandarahT::model()->findByPk($penyerahan->permintaandarah_id);
    $ruangan = RuanganM::model()->findByPk($permintaan->ruanganpemesan_id);
    $pasien = PasienM::model()->findByPk($permintaan->pasien_id);

    $judul = "Darah sudah Diserahkan (" . $permintaan->no_permintaandarah . ")";
    $isi = "No. Permintaan : " . $permintaan->no_permintaandarah . "<br/>"
      . "Pasien : " . $pasien->no_rekam_medik . " - " . $pasien->namadepan . $pasien->nama_pasien;

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
    ));


    // var_dump($judul, $isi, $penyerahan->attributes, $permintaan->attributes);
    // die;
  }

  /**
   * Fungsi pritout (STUB)
   */
  public function actionPrint()
  {
    $this->render('print');
  }


  // ---------------------- AJAX AUTO COMPLETE -----------------------------//

  /**
   * Pencarian pegawai ruangan login berdasarkan nama pegawai
   * @param String $term Nama Pegawai yang dicari
   */
  public function actionAutocompletePetugasVerifikator($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new BDPegawaiM;
    $model->nama_pegawai = $term;
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $prov = $model->searchDialogPenyerahanDarah();
    $prov->criteria->limit = 15;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->nomorindukpegawai . " - " . $item->nama_pegawai;
      $sub['value'] = $item->pegawai_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  /**
   * Pencarian pegawai ruangan login berdasarkan nama pegawai
   * @param String $term Nama Pegawai yang dicari
   */
  public function actionAutocompletePetugasMenyerahkan($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new BDPegawaiM;
    $model->nama_pegawai = $term;
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $prov = $model->searchDialogPenyerahanDarah();
    $prov->criteria->limit = 15;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->nomorindukpegawai . " - " . $item->nama_pegawai;
      $sub['value'] = $item->pegawai_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  /**
   * Pencarian pegawai ruangan login berdasarkan nama pegawai
   * @param String $term Nama Pegawai yang dicari
   */
  public function actionAutocompletePetugasTransporter($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new BDPegawaiM;
    $model->nama_pegawai = $term;
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $prov = $model->searchDialogPenyerahanDarah();
    $prov->criteria->limit = 15;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->nomorindukpegawai . " - " . $item->nama_pegawai;
      $sub['value'] = $item->pegawai_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }


  /**
   * Fungsi load permintaan darah yang sudah dilakukan Penyiapan Darah
   * dan belum dilakukan transaksi penyiapan darah.
   * 
   * @param string $term No. Permintaan Darah yang dicari.
   */
  public function actionAutocompletePermintaanDarahSudahSiap($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new BDInfopermintaandarahpasien;
    $model->no_permintaandarah = strtolower($term);

    $prov = $model->searchInformasi();
    $prov->pagination = false;

    $res = array();

    $cnt = 0;
    foreach ($prov->data as $item) {

      if ($cnt == 20) break;



      $penyiapan = PenyiapandarahT::model()->findByAttributes(array(
        'permintaandarah_id' => $item->permintaandarah_id,
      ));

      if (empty($penyiapan)) continue;


      $cnt++;


      $sub = $item->attributes;

      $pendaftaran = PendaftaranT::model()->findByPk($item->pendaftaran_id);

      $pendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran);

      $ruangan_id = $pendaftaran->ruangan_id;
      $kelaspelayanan_id = $pendaftaran->kelaspelayanan_id;
      $penjamin_id = $pendaftaran->penjamin_id;

      if (!empty($pendaftaran->pasienadmisi_id)) {
        $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
        $ruangan_id = $admisi->ruangan_id;
        $kelaspelayanan_id = $admisi->kelaspelayanan_id;
        $penjamin_id = $admisi->penjamin_id;
      }

      $ruangan = RuanganM::model()->findByPk($ruangan_id);
      $kelas = KelaspelayananM::model()->findByPk($kelaspelayanan_id);

      if (empty($ruangan)) {
        $ruangan = new RuanganM;
      }

      if (empty($kelas)) {
        $kelas = new KelaspelayananM;
      }

      $diagnosapasien = PasienmorbiditasT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran->pendaftaran_id,
        'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
      ));

      $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);

      if (empty($penjamin)) {
        $penjamin = new PenjaminpasienM;
      }

      if (empty($pendaftaran->pasien)) {
        $pendaftaran->pasien = new PasienM;
      } else {
        $pendaftaran->pasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($pendaftaran->pasien->tanggal_lahir);
      }

      if (empty($pendaftaran->pegawai)) {
        $pendaftaran->pegawai = new PegawaiM;
      }

      $diagnosa_nama = "";
      if (!empty($diagnosapasien)) {
        $diagnosa = DiagnosaM::model()->findByPk($diagnosapasien->diagnosa_id);
        $diagnosa_nama = $diagnosa->diagnosa_kode . " " . $diagnosa->diagnosa_nama;
      }

      $sub['diagnosa_nama'] = $diagnosa_nama;
      $sub['nama_pegawai'] = $pendaftaran->pegawai->namaLengkap;
      $sub['nama_pasien'] = $pendaftaran->pasien->nama_pasien;
      $sub['penjamin_nama'] = $penjamin->penjamin_nama;
      $sub['kelaspelayanan_nama'] = $kelas->kelaspelayanan_nama;
      $sub['ruangan_nama'] = $ruangan->ruangan_nama;
      $sub['pasien'] = $pendaftaran->pasien->attributes;
      $sub['pendaftaran'] = $pendaftaran->attributes;

      $sub['label'] = $item->no_permintaandarah . " - " . $pendaftaran->no_pendaftaran . " - " . $pendaftaran->pasien->nama_pasien;
      $sub['value'] = $item->permintaandarah_id;


      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }


  // ---------------------- END  AUTO COMPLETE -----------------------------//


  /**
   * Load data penyiapan darah
   * form Penyiapan Darah
   */
  public function actionLoadPenyiapan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];

    $model = new PenyerahandarahT;

    $model->permintaandarah_id = $id;

    $permintaan = PermintaandarahT::model()->findByPk($id);
    $penyiapan = PenyiapandarahT::model()->findAllByAttributes(array(
      'permintaandarah_id' => $id,
    ));

    $pendaftaran = PendaftaranT::model()->findByPk($permintaan->pendaftaran_id);
    $model->pendaftaran_id = $pendaftaran->pendaftaran_id;

    $html = "";

    foreach ($penyiapan as $row => $detail) :

      $item = UjikompatibilitasT::model()->findByPk($detail->ujikompatibilitas_id);

      $html .= $this->renderPartial($this->path_view . "form/_rowPenyerahan", array(
        'model' => $model,
        'item' => $item,
        'row' => $row,
        'detail' => $detail,
      ), true);

    endforeach;



    $html_penyiapan = $this->renderPartial($this->path_view . 'form/_formPenyiapan', array(
      'permintaan' => $permintaan,
      'penyiapan' => $penyiapan,
    ), true);

    echo CJSON::encode(array(
      'html' => $html,
      'html_penyiapan' => $html_penyiapan,
    ));
  }

  public function actionDetail($id = null, $penyerahandarah_ke = null, $frame = 0)
  {
    if ($frame == 1) {
      $this->layout = "//layouts/iframe";
    }

    $model = PenyerahandarahT::model()->findByPk($id);
    $model->tglpenyerahan = date("d M Y H:i:s");
    $peg = BDPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
    if (!empty($peg)) {
      $model->peg_ygmenyerahkan_id = $peg->pegawai_id;
      $model->peg_ygmenyerahkan_nama = $peg->namaLengkap;
    }

    if (!empty($id)) {
      $model->permintaandarah_id = $id;

      $permintaan = PermintaandarahT::model()->findByPk($id);

      $cri = new CDbCriteria();
      $cri->join = "  LEFT JOIN penyerahandarah_t serah ON serah.penyiapandarah_id = t.penyiapandarah_id ";
      if (isset($_GET['sukses'])) {
        $cri->addCondition(" t.permintaandarah_id = '" . $id . "' AND penyerahandarah_ke = '" . $penyerahandarah_ke . "' AND serah.penyerahandarah_id is not null ");
      } else {
        if ($frame == 1) {
          $cri->addCondition(" t.permintaandarah_id = '" . $id . "' AND penyerahandarah_ke = '" . $penyerahandarah_ke . "' AND serah.penyerahandarah_id is not null ");
        } else {
          $cri->addCondition(" t.permintaandarah_id = '" . $id . "' AND serah.penyerahandarah_id is null ");
        }
      }
      $cri->order = " t.tglpenyiapandarah DESC ";
      $penyiapan = PenyiapandarahT::model()->findAll($cri);

      $pendaftaran = PendaftaranT::model()->findByPk($permintaan->pendaftaran_id);
      $model->pendaftaran_id = $pendaftaran->pendaftaran_id;
    } else {
      $permintaan = new PermintaandarahT;
      $penyiapan = array();
      $pendaftaran = new PendaftaranT;
    }


    $this->render($this->path_view . 'print', array(
      'model' => $model,
      'permintaan' => $permintaan,
      'penyiapan' => $penyiapan,
      'pendaftaran' => $pendaftaran,
    ));
  }
}
