<?php

/**
 * Form dan Printout Penyiapan Darah
 * 
 * @author  Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author  Elham Budianto <elhambudianto@.com>
 * @version 2.0.0
 * @package application.modules.bankDarah
 * @subpackage controllers
 * 
 */
class PenyiapanDarahNewController extends MyAuthController
{
  public $path_view = "bankDarah.views.penyiapanDarahNew.";
  public function actionIndex($id = null, $ujidarahtube_id = null, $frame = 0, $penyiapandarah_ke = null, $pendaftaran_id = null, $pasienkirimkeunitlain_id = null)
  {
    if ($frame) {
      $this->layout = "//layouts/iframe";
    }

    $this->pageTitle = Yii::app()->name . " - Penyiapan Darah";
    $model = new PenyiapandarahT;
    $pengujianKompat = array();

    if (!empty($pasienkirimkeunitlain_id)) {
      $modPasienKirimKeunitlain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

      $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

      $cekPenyiapan = PenyiapandarahT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));

      if (isset($_GET['sukses'])) {
        if (!empty($cekPenyiapan)) {
          $model = $cekPenyiapan;
          $model->peg_penerimapermintaan_nama = !empty($model->penerimapermintaan->namaLengkap) ? $model->penerimapermintaan->namaLengkap : '';
        }
      }

      $model->tglpenyiapandarah = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
      $model->pasienkirimkeunitlain_id = $modPasienKirimKeunitlain->pasienkirimkeunitlain_id;


      $modPemeriksaanGolDar = PemeriksaangoldarT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);

      // echo '<pre>';var_dump($modPemeriksaanGolDar);die;
     
      
    } 

    if(empty($modPasienKirimKeUnitLain)) {
      $modPasienKirimKeUnitLain = new PasienkirimkeunitlainT();
    }
    if(empty($pendaftaran)) {
      $pendaftaran = new PendaftaranT();
    }
    if(empty($modPemeriksaanGolDar)) {
      $modPemeriksaanGolDar = [];
    }


    if (isset($_POST['PenyiapandarahT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      try {
        $gen = MyGenerator::penyiapanDarahKe($pasienkirimkeunitlain_id);
        foreach ($_POST['PenyiapandarahT']['detail'] as $pemeriksaangoldar_id => $detail) {
          $submodel = new PenyiapandarahT;
          $submodel->attributes = $_POST['PenyiapandarahT'];
          $submodel->attributes = $detail;
          $submodel->penyiapandarah_ke = $gen;
          $submodel->pemeriksaangoldar_id = $pemeriksaangoldar_id;
          $submodel->hasilujicocokserasi_id = $detail['hasilujicocokserasi_id'];
          $submodel->tglpenyiapandarah = MyFormatter::formatDateTimeForDb($submodel->tglpenyiapandarah);
          if (!empty($detail['peg_referal_id'])) {
            $submodel->tgl_referal = MyFormatter::formatDateTimeForDb($submodel->tgl_referal);
          } else {
            $submodel->tgl_referal = null;
          }
          $submodel->pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id;
          $submodel->pasienmasukpenunjang_id = $modPasienKirimKeunitlain->pasienmasukpenunjang_id;
          $submodel->tglpelabelan = MyFormatter::formatDateTimeForDb($submodel->tglpelabelan);
          // $submodel->permintaandarah_id = $id;
          $submodel->pendaftaran_id = $pendaftaran->pendaftaran_id;
          $submodel->create_time = date('Y-m-d H:i:s');
          $submodel->create_loginpemakai_id = Yii::app()->user->id;
          $submodel->create_ruangan = Yii::app()->user->getState('ruangan_id');
          //$submodel->lamapenyiapan_detik = $submodel->lamapenyiapan_detik[0] * $submodel->lamapenyiapan_detik[1];

          // echo '<pre>';var_dump($submodel->validate(), $submodel->getErrors());die;
          if ($submodel->validate()) {
            $ok = $ok && $submodel->save();
            if($ok) {
              PemeriksaangoldarT::model()->updateByPk($pemeriksaangoldar_id, ['penyiapandarah_id' => $submodel->penyiapandarah_id, 'tanggal_keluardarah' => date('Y-m-d H:i:s')]);
              StokkantongdarahT::model()->updateByPk($detail['stokkantongdarah_id'], ['penyiapandarah_id' => $submodel->penyiapandarah_id]);
            }
          } else {
            $ok = false;
          }
        }
        // die;
        if ($ok) {
          
          $trans->commit();
          $this->notifPenyiapanDarah($modPasienKirimKeunitlain, $pendaftaran);
          Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
          $this->redirect(array('index', 'penyiapandarah_ke' => $submodel->penyiapandarah_ke, 'frame' => $frame, 'sukses' => 1, 'pendaftaran_id' => $pendaftaran_id, 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          //$this->redirect(array('index', 'id' => $submodel->permintaandarah_id, 'frame'=>$frame));         
        }
      } catch (Exception $exc) {
        echo '<pre>';var_dump($exc);die;
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        //$this->redirect(array('index', 'id' => $submodel->permintaandarah_id, 'frame'=>$frame)); 
      }
    }


    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'permintaan' => $modPasienKirimKeUnitLain,
      'pendaftaran' => $pendaftaran,
      'pengujianKompat' => $pengujianKompat,
      'modPemeriksaanGolDar' => $modPemeriksaanGolDar
    ));
  }

  function actionSetKirimDarah() {
    $pemeriksaangoldar_id = $_POST['pemeriksaangoldar_id'];

    $modPemeriksaanGoldar = PemeriksaangoldarT::model()->findByPk($pemeriksaangoldar_id);

    $model = new PenyiapandarahT;

    $data['row'] = $this->renderPartial($this->path_view . 'form/_rowPenyiapan', [
                    'model' => $model,
                    'modPemeriksaanGoldar' => $modPemeriksaanGoldar
                  ], true);

    echo json_encode($data);

  }

  public function notifPenyiapanDarah($modPasienKirimKeUnitLain, $modPendaftaran)
  {

      $judul = "Penyiapan Darah";

      $tujuan = RuanganM::model()->findByPk($modPasienKirimKeUnitLain->create_ruangan);

      $isi = $modPendaftaran->no_pendaftaran . ' - ' . $modPendaftaran->pasien->no_rekam_medik . ' - ' . $modPendaftaran->pasien->nama_pasien;
      $isi .= '<br> Status : <b>Darah Telah Disiapkan</b>';

      $ok = CustomFunction::broadcastNotif($judul, $isi, array(
        array('instalasi_id' => $tujuan->instalasi_id, 'ruangan_id' => $tujuan->ruangan_id, 'modul_id' => $tujuan->modul_id),
      ));
  }

  /**
   * Menampilkan detail penyiapan darah
   * @param type $permintaandarah_id
   * @param type $ujidarahtube_id
   * @param type $tglpenyiapandarah
   * @param type $frame
   */
  public function actionDetail($permintaandarah_id, $ujidarahtube_id, $penyiapandarah_ke, $frame = '')
  {

    if ($frame == 1) {
      $this->layout = '//layouts/iframe';
    }

    $cri = new CDbCriteria();
    $cri->join = " JOIN ujikompatibilitas_t ujikomp ON ujikomp.ujikompatibilitas_id = t.ujikompatibilitas_id ";
    $cri->addCondition(" permintaandarah_id = '" . $permintaandarah_id . "' and  ujikomp.ujidarahpasien_id  = '" . $ujidarahtube_id . "' AND t.penyiapandarah_ke='" . $penyiapandarah_ke . "' ");
    $model = PenyiapandarahT::model()->find($cri);
    $permintaan = PermintaandarahT::model()->findByPk($permintaandarah_id);
    $pendaftaran = PendaftaranT::model()->findByPk($permintaan->pendaftaran_id);


    $model->tglpenyiapandarah = MyFormatter::formatDateTimeForUser($model->tglpenyiapandarah);
    $model->permintaandarah_id = $permintaan->permintaandarah_id;
    if (!empty($model->peg_penerimapermintaan_id)) {
      $pegawai = PegawaiM::model()->findByPk($model->peg_penerimapermintaan_id);
      $model->peg_penerimapermintaan_nama = $pegawai->nama_pegawai;
    }
    $pengujianSlide = UjidarahpasienT::model()->findByAttributes(array(
      'permintaandarah_id' => $permintaandarah_id,
      'metodedarah_id' => Params::METODE_DARAH_ID_SLIDE_TEST
    ), array(
      'order' => 'ujidarahpasien_id desc'
    ));


    /**
     * Ketika membaca kode transaksi Uji Kompatibilitas (PengujiankompabilitasController), 
     * data pengujian darah-nya disimpan dengan metodedarah_id -> 2 (TUBE TEST)
     */
    $pengujianTube = UjidarahpasienT::model()->findByPk($ujidarahtube_id);

    $pengujianKompat = array();
    if (!empty($pengujianTube)) {
      $criUji = new CDbCriteria();
      $criUji->select = " t.*, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,', ',gelar.gelarbelakang_nama) as nama_penguji, jenis.nama_jenis, siap.peg_referal_id, siap.peg_pelabelan "
        . " ,siap.tgl_referal, siap.tglpelabelan, siap.tglpenyiapandarah, siap.peg_referal_id, siap.peg_pelabelan, siap.peg_penerimapermintaan_id"
        . " ";
      $criUji->join = "   JOIN penyiapandarah_t siap ON siap.ujikompatibilitas_id = t.ujikompatibilitas_id "
        .   "   JOIN pegawai_m peg ON peg.pegawai_id = t.peg_pemeriksa_id "
        .   "   LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id  "
        .   "   JOIN stokkantongdarah_t stok ON stok.stokkantongdarah_id = t.stokkantongdarah_id   "
        .   "   left JOIN jeniskantongdarah_m jenis ON jenis.jeniskantongdarah_id = stok.jeniskantongdarah_id "
        .   "   ";
      $criUji->addCondition(" ujidarahpasien_id = '" . $pengujianTube->ujidarahpasien_id . "' AND siap.penyiapandarah_id is not null AND siap.penyiapandarah_ke = '" . $penyiapandarah_ke . "' ");
      $cekUji = UjikompatibilitasT::model()->findAll($criUji);

      foreach ($cekUji as $uji) {
        $pengujianKompat[$uji->ujikompatibilitas_ke]['tglujikompatibilitas'] = MyFormatter::formatDateTimeForUser($uji->tglujikompabilitas);
        $pengujianKompat[$uji->ujikompatibilitas_ke]['nama_penguji'] = $uji->nama_penguji;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ujikompatibilitas_id'] = $uji->ujikompatibilitas_id;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['nomorbarcode'] = $uji->nomorbarcode;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['nama_jenis'] = $uji->nama_jenis;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ujikomp_mayor'] = $uji->ujikomp_mayor;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ujikomp_minor'] = $uji->ujikomp_minor;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ujikomp_autokontrol'] = $uji->ujikomp_autokontrol;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ujikomp_dct'] = $uji->ujikomp_dct;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ujikomp_kesimpulan'] = $uji->ujikomp_kesimpulan;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['peg_pelabelan'] = $uji->peg_pelabelan;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['peg_referal_id'] = $uji->peg_referal_id;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['peg_penerimapermintaan_id'] = $uji->peg_penerimapermintaan_id;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['tgl_referal'] = $uji->tgl_referal;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['tglpelabelan'] = $uji->tglpelabelan;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['tglpenyiapandarah'] = $uji->tglpenyiapandarah;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['anti_a'] = $uji->anti_a;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['anti_b'] = $uji->anti_b;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['anti_ab'] = $uji->anti_ab;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['anti_d'] = $uji->anti_d;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['sel_a'] = $uji->sel_a;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['sel_b'] = $uji->sel_b;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['sel_o'] = $uji->sel_o;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ket_hasiluji'] = $uji->ket_hasiluji;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ujikomp_mayor'] = $uji->ujikomp_mayor;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ujikomp_minor'] = $uji->ujikomp_minor;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ujikomp_autokontrol'] = $uji->ujikomp_autokontrol;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ujikomp_dct'] = $uji->ujikomp_dct;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['ujikomp_kesimpulan'] = $uji->ujikomp_kesimpulan;
        $pengujianKompat[$uji->ujikompatibilitas_ke]['det'][$uji->ujikompatibilitas_id]['rilis'] = $uji->rilis;
      }
    }
    $this->render($this->path_view . 'detail', array(
      'model' => $model,
      'permintaan' => $permintaan,
      'pendaftaran' => $pendaftaran,
      'pengujianSlide' => $pengujianSlide,
      'pengujianTube' => $pengujianTube,
      'pengujianKompat' => $pengujianKompat,
    ));
  }

  /**
   * Digunakan untuk melihat mencetak label penyiapan darah
   * @author Aida Rahmawati <aidarahmawati@.com>
   * @param type $id
   */
  public function actionPrint($id, $penyiapandarah_ke)
  {
    $this->layout = '//layouts/printWindows';
    $permintaan = PermintaandarahT::model()->findByPk($id);
    $penyiapan = PenyiapandarahT::model()->findByPk($id);
    $pendaftaran = PendaftaranT::model()->findByPk($permintaan->pendaftaran_id);
    $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);

    $cri = new CDbCriteria();
    $cri->join = " JOIN penyiapandarah_t siap ON siap.ujikompatibilitas_id = t.ujikompatibilitas_id ";
    $cri->addCondition(" siap.penyiapandarah_ke = '" . $penyiapandarah_ke . "' AND siap.permintaandarah_id = '" . $id . "' ");
    $pengujian = UjikompatibilitasT::model()->find($cri);
    $uji = PenyiapandarahT::model()->findAllByAttributes(array('permintaandarah_id' => $id, 'penyiapandarah_ke' => $penyiapandarah_ke));
    $format = new MyFormatter;
    $this->render('print', array(
      'permintaan' => $permintaan,
      'penyiapan' => $penyiapan,
      'pendaftaran' => $pendaftaran,
      'pasien' => $pasien,
      'pengujian' => $pengujian,
      'format' => $format,
      'uji' => $uji,
      'penyiapandarah_ke' => $penyiapandarah_ke
    ));
  }

  public function actionPrintLabel($pendaftaran_id, $pasienkirimkeunitlain_id, $penyiapandarah_ke)
  {
    $this->layout = '//layouts/printWindows';
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPenyiapan = PenyiapandarahT::model()->findAllByAttributes(['penyiapandarah_ke' => $penyiapandarah_ke, 'pendaftaran_id' => $pendaftaran_id, 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);
      $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);
      $modKirimUnit = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
      if(!empty($modPenyiapan)) {
        $posisi = 'L'; 
        $mpdf = new MyPDF60('', array(50, 90));
        // $mpdf->mirrorMargins = 2;
        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
        ob_clean();
        $mpdf->WriteHTML($formatkonten, 1);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);

        if(count($modPenyiapan) > 0) {
          foreach ($modPenyiapan as $i => $data) {
            $mpdf->AddPage($posisi, '', '', '', '', 1, 1, 0, 1, 0, 0);
            $mpdf->SetHTMLFooter('<span><hr></span>');
            $mpdf->WriteHTML(
                $this->renderPartial('printLabel', array(
                    'modPendaftaran' => $modPendaftaran,
                    'modPenyiapan' => $data,
                    'modPenunjang' => $modPenunjang,
                    'modKirimUnit' => $modKirimUnit
                ), true)
            );
        }
      }
        $mpdf->SetJS('this.print();');
        $mpdf->Output();
      } else {
        echo 'Data Penyiapan Darah Tidak Ditemukan';
      }
  }

  /**
   * Load pegawai untuk Petugas Lab Referal
   * 
   * @param string $term
   */
  public function actionAutocompletePetugas($term)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $cr = new CDbCriteria;
    $cr->addCondition('pegawai_aktif = true');
    $cr->order = 'nama_pegawai';
    $cr->compare('lower(nama_pegawai)', strtolower($term = null), true);
    $cr->limit = 15;

    $model = BDPegawaiM::model()->findAll($cr);

    $res = array();

    foreach ($model as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->nama_pegawai;
      $sub['value'] = $item->pegawai_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  /**
   * Load pegawai untuk Petugas Labeling
   * 
   * @param string $term
   */
  public function actionAutocompletePetugasLabeling($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $cr = new CDbCriteria;
    $cr->addCondition('pegawai_aktif = true');
    $cr->order = 'nama_pegawai';
    $cr->compare('lower(nama_pegawai)', strtolower($term), true);
    $cr->limit = 15;

    $model = BDPegawaiM::model()->findAll($cr);

    $res = array();

    foreach ($model as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->nama_pegawai;
      $sub['value'] = $item->pegawai_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  /**
   * Fungsi load permintaan darah yang sudah dilakukan Uji Kompatibilitas
   * dan belum dilakukan transaksi penyiapan darah.
   * 
   * @param string $term No. Permintaan Darah yang dicari.
   */
  public function actionAutocompletePermintaanDarah($term = null)
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

      $uji = UjidarahpasienT::model()->findByAttributes(array(
        'metodedarah_id' => Params::METODE_DARAH_ID_TUBE_TEST,
        'permintaandarah_id' => $item->permintaandarah_id,
      ));

      if (empty($uji)) continue;


      $penyiapan = PenyiapandarahT::model()->findByAttributes(array(
        'permintaandarah_id' => $item->permintaandarah_id,
      ));

      if (!empty($penyiapan)) continue;


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

  /**
   * Load data pengujian darah via slide/tube test, kompatibilitas, dan
   * form Penyiapan Darah
   */
  public function actionLoadPengujian()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];

    $permintaan = PermintaandarahT::model()->findByPk($id);
    $pengujianSlide = UjidarahpasienT::model()->findByAttributes(array(
      'permintaandarah_id' => $id,
      'metodedarah_id' => Params::METODE_DARAH_ID_SLIDE_TEST
    ), array(
      'order' => 'ujidarahpasien_id desc'
    ));


    /**
     * Ketika membaca kode transaksi Uji Kompatibilitas (PengujiankompabilitasController), 
     * data pengujian darah-nya disimpan dengan metodedarah_id -> 2 (TUBE TEST)
     */
    $pengujianTube = UjidarahpasienT::model()->findByAttributes(array(
      'permintaandarah_id' => $id,
      'metodedarah_id' => Params::METODE_DARAH_ID_TUBE_TEST
    ), array(
      'order' => 'ujidarahpasien_id desc'
    ));

    $pengujianKompat = array();
    if (!empty($pengujianTube)) {
      $pengujianKompat = UjikompatibilitasT::model()->findAllByAttributes(array(
        'ujidarahpasien_id' => $pengujianTube->ujidarahpasien_id,
        'rilis' => 'rilis',
      ));
    }


    $html = $this->renderPartial($this->path_view . 'form/_formSlideTest', array(
      'permintaan' => $permintaan,
      'pengujianSlide' => $pengujianSlide
    ), true)
      . $this->renderPartial($this->path_view . 'form/_formTubeTest', array(
        'permintaan' => $permintaan,
        'pengujianTube' => $pengujianTube
      ), true)
      . $this->renderPartial($this->path_view . 'form/_formKompat', array(
        'permintaan' => $permintaan,
        'pengujianTube' => $pengujianTube,
        'pengujianKompat' => $pengujianKompat,
      ), true);


    $html_penyiapan = "";
    foreach ($pengujianKompat as $row => $item) {
      $html_penyiapan .= $this->renderPartial($this->path_view . 'form/_rowPenyiapan', array(
        'item' => $item,
        'model' => new PenyiapandarahT,
        'isAjax' => true,
        'row' => $row,
      ), true);
    }

    echo CJSON::encode(array(
      'html' => $html,
      'html_penyiapan' => $html_penyiapan,
    ));
  }
}
