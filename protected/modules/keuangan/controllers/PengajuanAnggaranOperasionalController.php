<?php

/**
 *       - digunakan sebagai url utama untuk mengelola informasi dan tambah pengajuan anggaran operasional
 *       @author			M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *	@createdDate	28 Desember 2017
 *       @website		<piindonesia.co.id>
 */
class PengajuanAnggaranOperasionalController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'keuangan.views.pengajuanAnggaranOperasional.';
  public $path_pengaluaran_umum = 'keuangan.views.pengeluaranUmum.';
  public $saveDetail = true;

  /**
   * @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @createdDate	28 Desember 2017
   * - digunakan sebagai url untuk masuk ke transaksi pengajuan anggaran operasional
   */
  public function actionIndex($id = null, $linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pengajuan Anggaran Operasional";
    $format = new MyFormatter;
    $model = new KUPengajuanpettyT;
    $modDet = new KUPengajuanpettydetT;
    $model->pengajuanpetty_kategori = Params::KATEGORI_PETTYCASH_MEDIS;

    if (!empty(Yii::app()->user->getState('pegawai_id'))) {
      $modPeg = KUPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modPeg->jabatan_id = (!empty($modPeg->jabatan_id) ? $modPeg->jabatan->jabatan_nama : null);
      $model->pegawai_id = $modPeg->pegawai_id;
      $modPeg->nama_pegawai = $modPeg->namaLengkap;
      $modPeg->unitkerja_id = (!empty($modPeg->unitkerja_id) ? $modPeg->unitkerja->namaunitkerja : null);
    } else {
      $modPeg = new KUPegawaiM;
    }

    $model->pengajuanpetty_no = '-- Otomatis --';
    $model->pengajuanpetty_tgl = date('d F Y H:i:s');

    $konfig = ApprovalotorisasiM::model()->find();
    if (isset($konfig->managerkeuangan)) {
      $model->accdirektur_id = $konfig->managerkeuangan->pegawai_id;
      $model->accdirektur_nama = $konfig->managerkeuangan->namaLengkap;
    }

    if (isset($_POST['KUPengajuanpettyT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['KUPengajuanpettyT'];
        $model->pengajuanpetty_no = MyGenerator::noPengajuanAnggaranOperasional();
        $model->pengajuanpetty_tgl =  MyFormatter::formatDateTimeForDb($model->pengajuanpetty_tgl);
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
        $model->create_time = date('Y-m-d H:i:s');
        $model->profilrs_id = Yii::app()->user->getState('profilrs_id');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->pengajuanpetty_status = Params::STATUS_PETTY_CASH_PENGAJUAN;
        //                        $model->diketahuiatasan_tgl = $model->pengajuanpetty_tgl;
        $model->unitkerja_id = Yii::app()->user->getState('unitkerja_id');

        $ok = $ok && $model->save();


        if ($ok) {
          if (isset($_POST['KUPengajuanpettydetT'])) {

            foreach ($_POST['KUPengajuanpettydetT'] as $key => $postDetail) {
              if (isset($_POST['KUPengajuanpettydetT'][$key])) {

                $modDet = new KUPengajuanpettydetT;
                $modDet->attributes = $_POST['KUPengajuanpettydetT'][$key];
                $modDet->pengajuanpetty_id = $model->pengajuanpetty_id;
                $ok = $ok && $modDet->save();
              }
            }
          }
        }

        //   $ok = false;
        // die;
        if ($ok) {
          //								$judul = "Pengajuan Anggaran Operasional";
          //								$isi = $model->pengajuanpetty_no.", yang mengajukan ".$model->pegawai->namaLengkap.' pada tanggal '.MyFormatter::formatDateTimeForUser($model->pengajuanpetty_tgl);
          //
          //								$ok = CustomFunction::broadcastNotif($judul, $isi, array(
          //										array('instalasi_id'=> Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_FINANCE, 'modul_id'=> Params::MODUL_ID_KEUANGAN),
          //										array('instalasi_id'=> Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_BENDAHARA, 'modul_id'=> Params::MODUL_ID_KEUANGAN),
          //								));
          $this->notifPengajuanAnggaranOperasional($model);
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data nomor pengajuan ' . $model->pengajuanpetty_no . ' berhasil disimpan.');
          $this->redirect(array('index', 'id' => $model->pegawai_id, 'sukses' => 1, 'pengajuanpetty_id' => $model->pengajuanpetty_id));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', " Data Gagal Disimpan.");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penilaiaan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(2158);

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'modDet' => $modDet,
      'modPeg' => $modPeg,
      'linkHalaman' => $linkHalaman
    ));
  }

  protected function notifPengajuanAnggaranOperasional($model)
  {

    $judul = "Pengajuan Anggaran Operasional ";

    // $isi = "Tanggal : ".MyFormatter::formatDateTimeForUser($model->pengajuanpetty_untuk)."<br/>";
    $isi = "No. Pengajuan : " . $model->pengajuanpetty_no . "<br/>";
    $isi .= "Kategory : " . $model->pengajuanpetty_kategori . "<br/>";

    $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);
    $kasir = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

    $cur = array(
      array('instalasi_id' => $ruanganAkuntansi->instalasi_id, 'ruangan_id' => $ruanganAkuntansi->ruangan_id, 'modul_id' => $ruanganAkuntansi->modul_id),
      array('instalasi_id' => $kasir->instalasi_id, 'ruangan_id' => $kasir->ruangan_id, 'modul_id' => $kasir->modul_id)
    );
    CustomFunction::broadcastNotif($judul, $isi, $cur);
  }

  /**
   * @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @createdDate	28 Desember 2017
   * - digunakan sebagai url untuk masuk ke informasi pengajuan anggaran operasional
   */
  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Pengajuan Anggaran Operasional";
    $model  = new KUInfopengajuanpettyV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KUInfopengajuanpettyV'])) {
      $model->attributes = $_GET['KUInfopengajuanpettyV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'informasi', array('model' => $model));
  }

  /**
   * - digunakan untuk menampilkan detail data poin pegawai, untuk melihat jumlah poin per nilai poin
   * @param type $id
   */
  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $model = KPPoinpegawaiR::model()->findByPk($id);
    $modDet = KPPoinpegdetR::model()->findAllByAttributes(array('poinpegawai_id' => $model->poinpegawai_id));

    $model->poinpegawai_tgl = MyFormatter::formatDateTimeForDb($model->poinpegawai_tgl);

    $this->render($this->path_view . 'detail/_detailInfo', array(
      'model' => $model,
      'modDet' => $modDet,
      'judulLaporan' => 'Informasi Hukuman Poin Pegawai'
    ));
  }

  /**
   *  @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   *  - digunakan untuk menampilkan data pegawai berdaarkan auto complate, ketika mengetikkan nama pegawai
   */
  public function actionAutoCompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }

      if (!isset($_GET['filter'])) {
        $_GET['filter'] = null;
      }
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (isset($_GET['pegawai_id'])) {
        if (!empty($_GET['pegawai_id'])) {
          $criteria->addCondition("t.pegawai_id = " . $_GET['pegawai_id']);
        }
      }
      $criteria->compare('LOWER(t.nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 't.nama_pegawai';
      $criteria->limit = 5;

      if ($_GET['filter'] == 'atasan') {
        $criteria->addCondition(" ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
      } elseif ($_GET['filter'] == 'direktur') {
        $criteria->select = " t.gelardepan, t.nama_pegawai, t.gelarbelakang_nama, t.pegawai_id, t.jabatan_id ";
        $criteria->join = " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id ";
        $criteria->addCondition(" p.unitkerja_id = " . Params::UNITKERJA_ID_DIREKTUR . " ");
        $criteria->group = $criteria->select;
      } elseif ($_GET['filter'] == 'keuangan') {
        $criteria->select = " t.gelardepan, t.nama_pegawai, t.gelarbelakang_nama, t.pegawai_id, t.jabatan_id ";
        $criteria->join = " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id ";
        $criteria->addInCondition(" p.unitkerja_id", array(
          Params::UNITKERJA_ID_BENDAHARA,
          Params::UNITKERJA_ID_FINANCE,
          Params::UNITKERJA_ID_KEUANGAN
        ));
        $criteria->group = $criteria->select;
      } elseif ($_GET['filter'] == 'kabidyanmed') {
        $criteria->select = " t.gelardepan, t.nama_pegawai, t.gelarbelakang_nama, t.pegawai_id, t.jabatan_id ";
        $criteria->join = " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id ";
        $criteria->addCondition(" p.unitkerja_id = " . Params::UNITKERJA_ID_PELAYANAN_MEDIS . " ");
        $criteria->group = $criteria->select;
      }
      //$models = PegawaiV::model()->findAll($criteria);
      $models = PegawairuanganV::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        if (!empty($model->jabatan_id)) {
          $returnVal[$i]['jabatan_nama'] = JabatanM::model()->findByPk($model->jabatan_id)->jabatan_nama;
        } else {
          $returnVal[$i]['jabatan_nama'] = '';
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  /**
   * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * - digunakan untuk mencetak prinout data pengajuan anggaran operasional
   * @param type $pengajuanpetty_id
   * @param type $caraPrint
   */
  public function actionPrint($pengajuanpetty_id, $caraPrint = null)
  {
    if (empty($caraPrint)) {
      $this->layout = '//layouts/iframe';
    } else {
      $this->layout = '//layouts/printWindows';
    }

    $pengajuanpetty_id = $_GET['pengajuanpetty_id'];

    $model = KUPengajuanpettyT::model()->findByPk($pengajuanpetty_id);

    if (!empty($model->tandabuktikeluar_id)) {
      $modDet = KUPengpettydetR::model()->findAllByAttributes(array('pengajuanpetty_id' => $pengajuanpetty_id));
      $model->pengajuanpetty_total = KUTandabuktikeluarT::model()->findByPk($model->tandabuktikeluar_id)->jmlkaskeluar;
    } else {
      $modDet = KUPengajuanpettydetT::model()->findAllByAttributes(array('pengajuanpetty_id' => $pengajuanpetty_id));
    }



    $judul_print = 'Pengajuan Anggaran Operasional';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    $this->render($this->path_view . 'Print', array(
      'judul_print' => $judul_print,
      'model' => $model,
      'modDet' => $modDet,

    ));
  }

  public function actionRincian($pengajuanpetty_id, $caraPrint = null)
  {
    if (empty($caraPrint)) {
      $this->layout = '//layouts/iframe';
    } else {
      $this->layout = '//layouts/printWindows';
    }

    $model = KUPengajuanpettyT::model()->findByPk($pengajuanpetty_id);
    $modDet = KUPengajuanpettydetT::model()->findAllByAttributes(array('pengajuanpetty_id' => $pengajuanpetty_id));

    $judul_print = 'Pengajuan Anggaran Operasional';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    $this->render($this->path_view . 'Rincian', array(
      'judul_print' => $judul_print,
      'model' => $model,
      'modDet' => $modDet,

    ));
  }

  public function actionGetApprove()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pengajuanpetty_id = isset($_POST['pengajuanpetty_id']) ? $_POST['pengajuanpetty_id'] : null;
      $filter = isset($_POST['filter']) ? $_POST['filter'] : null;

      $update = PengajuanpettyT::model()->findByPk($pengajuanpetty_id);
      $ok = true;
      //var_dump($pengajuanpetty_id);
      if ($filter == 'atasan') {

        $update->update_time = date('Y-m-d H:i:s');
        $update->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $update->diketahuiatasan_id = Yii::app()->user->getState('pegawai_id');
        $update->diketahuiatasan_tgl = date('Y-m-d H:i:s');
        $ok = $ok && $update->save();

        if ($ok) {
          $data['sukses'] = 1;
          $data['pesan'] = "Data Berhasil Disimpan";
        } else {
          $data['sukses'] = 0;
          $data['pesan'] = "Data Gagal Disimpan";
        }
      } elseif ($filter == 'direktur') {
        $update->update_time = date('Y-m-d H:i:s');
        $update->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $update->accdirektur_id = Yii::app()->user->getState('pegawai_id');
        $update->accdirektur_tgl = date('Y-m-d H:i:s');
        $ok = $ok && $update->save();

        if ($ok) {
          $data['sukses'] = 1;
          $data['pesan'] = "Data Berhasil Disimpan";
        } else {
          $data['sukses'] = 0;
          $data['pesan'] = "Data Gagal Disimpan";
        }
      }
      //var_dump($data);die;
      echo json_encode($data);
    }
    Yii::app()->end();
  }

  /**
   * - digunakan untuk menampilkan fungsi approve
   * @param type $id
   */
  public function actionApprove($id)
  {
    $this->layout = '//layouts/iframe';
    $model = KUPengajuanpettyT::model()->findByPk($id);

    $modBukti = new KUTandabuktikeluarT;
    $modBukti->tglkaskeluar = date('d M Y');
    $modBukti->nokaskeluar = '-- Otomastis --';
    $modBukti->carabayarkeluar = Params::CARAPEMBAYARAN_TUNAI;
    $modBukti->untukpembayaran = 'Pengajuan Anggaran Operasional';

    $modPengUmum = new KUPengeluaranumumT;
    $modPengUmum->volume = 1;

    $modDetR = new KUPengpettydetR;

    if (!empty($model->pengajuanpetty_id)) {
      $modDet = KUPengajuanpettydetT::model()->findAllByAttributes(array('pengajuanpetty_id' => $model->pengajuanpetty_id));
    } else {
      $modDet = new KUPengajuanpettydetT;
    }



    if (!empty($model->pegawai_id)) {
      $modPegawai = KUPegawaiM::model()->findByPk($model->pegawai_id);
      $modPegawai->unitkerja_id = (!empty($modPegawai->unitkerja_id)) ? $modPegawai->unitkerja->namaunitkerja : null;
      $modPegawai->jabatan_id = (!empty($modPegawai->jabatan_id)) ? $modPegawai->jabatan->jabatan_nama : null;
      $modBukti->namapenerima = $modPegawai->namaLengkap;
      $modBukti->alamatpenerima = $modPegawai->alamat_pegawai;
    } else {
      $modPegawai = new KUPegawaiM;
    }

    if (isset($_POST['KUTandabuktikeluarT'])) {

      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {






        $modBukti->attributes = $_POST['KUTandabuktikeluarT'];
        $modBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modBukti->create_time = date('Y-m-d H:i:s');
        $modBukti->tglkaskeluar = isset($_POST['KUTandabuktikeluarT']['tglkaskeluar']) ? MyFormatter::formatDateTimeForDb($_POST['KUTandabuktikeluarT']['tglkaskeluar']) : date('Y-m-d H:i:s');
        $modBukti->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $modBukti->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modBukti->biayaadministrasi = 0;
        $modBukti->tahun = date('Y');
        $modBukti->untukpembayaran = 'Pengajuan Anggaran Operasional';
        $modBukti->nokaskeluar = MyGenerator::noKasKeluar();
        $modBukti->shift_id = Yii::app()->user->getState('shift_id');
        //echo "goal"; die;
        $ok = $ok && $modBukti->save();


        $modPengUmum->attributes = $_POST['KUPengeluaranumumT'];
        $modPengUmum->tandabuktikeluar_id = $modBukti->tandabuktikeluar_id;
        $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
        $modPengUmum->tglpengeluaran = $modBukti->tglkaskeluar;
        $modPengUmum->hargasatuan = $modPengUmum->totalharga = $modBukti->jmlkaskeluar;
        $modPengUmum->keterangankeluar = $modBukti->keterangan_pengeluaran;
        $modPengUmum->biayaadministrasi = 0;
        $modPengUmum->satuanvol = 'KALI';

        if ($modPengUmum->validate()) {
          $ok = $ok && $modPengUmum->save();
          $modBukti->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
          $ok = $ok && $modBukti->save();
        } else $ok = false;

        // var_dump($ok, $modPengUmum->errors, $modPengUmum->attributes, $modBukti->attributes, $_POST); die;


        if ($ok) {
          if (isset($_POST['KUPengpettydetR'])) {
            foreach ($_POST['KUPengpettydetR'] as $key => $postDetail) {
              if (isset($_POST['KUPengpettydetR'][$key])) {
                if ($_POST['KUPengpettydetR'][$key]['pilih'] == 1) {
                  $modDet = new KUPengpettydetR;
                  $modDet->attributes = $_POST['KUPengpettydetR'][$key];
                  $ok = $ok && $modDet->save();
                }
              }
            }
          }
        }

        // die;

        if ($ok) {
          $modPetty = KUPengajuanpettyT::model()->findByPk($id);
          $modPetty->pengajuanpetty_status = Params::STATUS_PETTY_CASH_DISETUJUI;
          $modPetty->update_time = date("Y-m-d H:i:s");
          $modPetty->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $modPetty->diketahuikeuangan_id = Yii::app()->user->getState('pegawai_id');
          $modPetty->diketahuikeuangan_tgl = date("Y-m-d");
          $modPetty->tandabuktikeluar_id = $modBukti->tandabuktikeluar_id;
          $modPetty->save();
        }

        if (isset($_POST['RekeningakuntansiV'])) {
          // var_dump("Insert Jurnal...");
          $modJurnalRekening = $this->saveJurnalRekening($modPetty, $modBukti);
          $ok = $ok && $this->saveJurnalDetail($modJurnalRekening, $_POST['RekeningakuntansiV']);
        }



        // var_dump($modBukti->attributes, $modPetty->attributes, $_POST); die;
        // var_dump($ok);
        // die;

        if ($ok) {

          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
          $sukses = 1;
          $this->redirect(array('approve', 'sukses' => $sukses, 'id' => $model->pengajuanpetty_id));
        } else {

          Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan');
          $trans->rollback();
        }
      } catch (Exception $e) {
        echo $e->getMessage();
        die;
        Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan');
        $trans->rollback();
      }
    }

    $this->render($this->path_view . 'form/_approve', array(
      'modPengUmum' => $modPengUmum,
      'model' => $model,
      'modBukti' => $modBukti,
      'modDet' => $modDet,
      'modPegawai' => $modPegawai,
      'modDetR' => $modDetR
    ));
  }

  public function actionGetDataRekeningByJnsPengeluaran()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $jenispengeluaran_id = isset($_POST['jenispengeluaran_id']) ? $_POST['jenispengeluaran_id'] : null;
      $criteria = new CDbCriteria;
      if (!empty($jenispengeluaran_id)) {
        $criteria->addCondition('jenispengeluaran_id = ' . $jenispengeluaran_id);
      }
      $criteria->order = 'rekening5_id ASC';
      $model = KUJenispengeluaranrekeningV::model()->findAll($criteria);
      if ($model) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . 'form.__formKodeRekening', array('model' => $model, 'dariDialog' => true), true)
        );
      }
      Yii::app()->end();
    }
  }


  protected function saveJurnalRekening($modPetty, $modBukti)
  {



    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $modJurnalRekening = new KUJurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $modBukti->tglkaskeluar;
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modBukti->tglkaskeluar, 'JKK');
    $modJurnalRekening->noreferensi = $modBukti->nokaskeluar;
    $modJurnalRekening->tglreferensi = $modBukti->tglkaskeluar;
    $modJurnalRekening->urianjurnal = "Realisasi Anggaran Operasional " . $modPetty->pengajuanpetty_no;
    $modJurnalRekening->tandabuktikeluar_id = $modBukti->tandabuktikeluar_id;
    $modJurnalRekening->nobku = "";


    /*
		  $attributes = array(
		  'jenisjurnal_aktif' => true
		  );
		  $jenisjurnal_id = JenisjurnalM::model()->findByAttributes($attributes);
		  $modJurnalRekening->jenisjurnal_id = $jenisjurnal_id->jenisjurnal_id;
		 *
		 */

    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = $modBukti->tglkaskeluar;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      // $this->succesSave = true;
    } else {
      // $this->succesSave = false;

      if (empty($modJurnalRekening->rekperiod_id)) {
        throw new CDbException("Periode Akuntansi Belum di-set");
      } else {
        throw new CDbException($modJurnalRekening->getErrors());
      }
    }
    // var_dump($modJurnalRekening->attributes, $modBukti->attributes, $modPetty->attributes); die;
    return $modJurnalRekening;
  }


  protected function saveJurnalDetail($modJurnalRekening, $rekeningakuntansi)
  {

    $valid = true;
    foreach ($rekeningakuntansi as $i => $data) {

      $model = new KUJurnaldetailT();
      // $model->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $model->uraiantransaksi = isset($data['nama_rekening']) ? $data['nama_rekening'] : "";
      $model->saldodebit = isset($data['saldodebit']) ? $data['saldodebit'] : 0;
      $model->saldokredit = isset($data['saldokredit']) ? $data['saldokredit'] : 0;
      $model->nourut = $i + 1;
      $model->rekening5_id = isset($data['rekening5_id']) ? $data['rekening5_id'] : null;
      $model->catatan = "";
      if ($model->validate()) {
        $model->save();

        // var_dump($model->attributes);
      } else {
        throw new CDbException($model->getErrors());
        $valid = false;
        break;
      }
    }

    return $valid;

    // $this->succesSave = $valid;
  }


  /**
   * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * - digunakan untuk mengubah status
   */
  public function actionChangeStatus()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pengajuanpetty_id = isset($_POST['pengajuanpetty_id']) ? $_POST['pengajuanpetty_id'] : null;
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $kategori = isset($_POST['kategori']) ? $_POST['kategori'] : null;

      $update = PengajuanpettyT::model()->findByPk($pengajuanpetty_id);
      $ok = true;


      $update->update_time = date('Y-m-d H:i:s');
      $update->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
      if ($kategori == Params::KATEGORI_PETTYCASH_MEDIS) {
        $update->kabidyanmed_id = Yii::app()->user->getState('pegawai_id');
        $update->kabidyanmed_tgl = date('Y-m-d H:i:s');
      } else {
        $update->diketahuikeuangan_id = Yii::app()->user->getState('pegawai_id');
        $update->diketahuikeuangan_tgl = date('Y-m-d H:i:s');
        $update->accdirektur_tgl = date('Y-m-d H:i:s');
      }
      $update->pengajuanpetty_status = $status;
      $ok = $ok && $update->save();

      if ($ok) {
        $data['sukses'] = 1;
        $data['pesan'] = "Data Berhasil Disimpan";
      } else {
        $data['sukses'] = 0;
        $data['pesan'] = "Data Gagal Disimpan";
      }

      echo json_encode($data);
    }
    Yii::app()->end();
  }

  /**
   * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * - digunakan untuk mencetak prinout data pengajuan anggaran operasional untuk semua pengajuan dalam periode tertentu
   * @param type $pengajuanpetty_id
   * @param type $caraPrint
   */
  public function actionPrintInfo()
  {

    if ($_GET['caraPrint'] == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else {
      $this->layout = '//layouts/printWindows';
    }

    $cri = new CDbCriteria();
    $cri->join =  " JOIN pengajuanpetty_t pp ON pp.pengajuanpetty_id = t.pengajuanpetty_id "
      .  " JOIN pegawai_m p ON p.pegawai_id = pp.pegawai_id ";
    $cri->addBetweenCondition("DATE(pp.pengajuanpetty_tgl)", MyFormatter::formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_awal']), MyFormatter::formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_akhir']));
    $cri->compare(" LOWER(pp.pengajuanpetty_no) ", strtolower($_GET['KUInfopengajuanpettyV']['pengajuanpetty_no']), true);
    $cri->compare(" LOWER(p.nama_pegawai) ", strtolower($_GET['KUInfopengajuanpettyV']['pembuat_nama']), true);

    if (!empty($_GET['KUInfopengajuanpettyV']['ruangan_id'])) {
      $cri->addCondition("pp.ruangan_id = :ruangan_id");
      $cri->params[':ruangan_id'] = $_GET['KUInfopengajuanpettyV']['ruangan_id'];
    }

    if (!empty($_GET['KUInfopengajuanpettyV']['pengajuanpetty_status'])) {
      $cri->addCondition("pp.pengajuanpetty_status = :pengajuanpetty_status");
      $cri->params[':pengajuanpetty_status'] = $_GET['KUInfopengajuanpettyV']['pengajuanpetty_status'];
    }
    $cri->order = " pp.pengajuanpetty_no ASC, pp.pengajuanpetty_tgl DESC ";

    $modDet = KUPengajuanpettydetT::model()->findAll($cri);

    $data = array();
    foreach ($modDet as $det) {
      $nopengajuan = $det->pengajuanpetty->pengajuanpetty_no;
      $tgl = $det->pengajuanpetty->pengajuanpetty_tgl;
      $nama = $det->pengajuanpetty->pegawai->namaLengkap;
      $unit = !empty($det->pengajuanpetty->pegawai->unitkerja_id) ? $det->pengajuanpetty->pegawai->unitkerja->namaunitkerja : '';
      $untuk = $det->pengajuanpetty->pengajuanpetty_untuk;

      $data["$nopengajuan"]['no'] = $nopengajuan;
      $data["$nopengajuan"]['tgl'] = MyFormatter::formatDateTimeForUser($tgl);
      $data["$nopengajuan"]['nama'] = $nama;
      $data["$nopengajuan"]['unit'] = $unit;
      $data["$nopengajuan"]['untuk'] = $untuk;
      $data["$nopengajuan"]['nopengajuan']["$det->pengajuanpettydet_id"]["item"] = $det->pengajuanpettydet_item;
      $data["$nopengajuan"]['nopengajuan']["$det->pengajuanpettydet_id"]["qty"] = $det->pengajuanpettydet_qty;
      $data["$nopengajuan"]['nopengajuan']["$det->pengajuanpettydet_id"]["hargasatuan"] = $det->pengajuanpettydet_hargasatuan;
      $data["$nopengajuan"]['nopengajuan']["$det->pengajuanpettydet_id"]["subtotal"] = $det->pengajuanpettydet_subtotal;
    }



    $judul_print = 'Pengajuan Anggaran Operasional<br> Periode ' . MyFormatter::formatDateTimeForUser($_GET['KUInfopengajuanpettyV']['tgl_awal']) . ' s/d ' . MyFormatter::formatDateTimeForUser($_GET['KUInfopengajuanpettyV']['tgl_akhir']);
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    $this->render($this->path_view . 'PrintInfo', array(
      'judul_print' => $judul_print,
      'modDet' => $modDet,
      'data' => $data,
      'caraPrint' => $_GET['caraPrint']
    ));
  }


  public function actionAmbilDataRekening()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $rekening1_id = isset($_POST['rekening1_id']) ? $_POST['rekening1_id'] : null;
      $rekening2_id = isset($_POST['rekening2_id']) ? $_POST['rekening2_id'] : null;
      $rekening3_id = isset($_POST['rekening3_id']) ? $_POST['rekening3_id'] : null;
      $rekening4_id = isset($_POST['rekening4_id']) ? $_POST['rekening4_id'] : null;
      $rekening5_id = isset($_POST['rekening5_id']) ? $_POST['rekening5_id'] : null;
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $criteria = new CDbCriteria;

      //			dicomment karena : RND-8713
      //			$data = array();
      //			$params = array();
      //			foreach($_POST['id_rekening'] as $key=>$val)
      //			{
      //				if($key != 'status')
      //				{
      //					if(strlen(trim($val)) > 0)
      //					{
      //						$data[] = $key . ' = :' . $key;
      //						$params[(string) ':'.$key] = $val;
      //					}
      //				}
      //			}
      //
      //			$criteria = new CDbCriteria;
      //			$criteria->select = '*';
      //			$criteria->condition = implode($data, ' AND ');
      //			$criteria->params = $params;

      if (!empty($rekening5_id)) {
        $criteria->addCondition("rekeninglast_id = " . $rekening5_id);
      }
      if (!empty($rekening4_id)) {
        $criteria->addCondition("rekening4_id = " . $rekening4_id);
      }
      if (!empty($rekening3_id)) {
        $criteria->addCondition("rekening3_id = " . $rekening3_id);
      }
      if (!empty($rekening2_id)) {
        $criteria->addCondition("rekening2_id = " . $rekening2_id);
      }
      if (!empty($rekening1_id)) {
        $criteria->addCondition("rekening1_id = " . $rekening1_id);
      }

      $model = KURekeningakuntansiV::model()->findAll($criteria);
      if ($model) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . 'form.__formKodeRekening', array('model' => $model, 'status' => $_POST['status']), true)
        );
      }
      Yii::app()->end();
    }
  }

  public function actionMengetahui($pengajuanpetty_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PengajuanpettyT::model()->findByPk($pengajuanpetty_id);
    $modDet = PengajuanpettydetT::model()->findAllByAttributes(array('pengajuanpetty_id' => $pengajuanpetty_id));

    if ($approve) {
      $update = PengajuanpettyT::model()->updateByPk($pengajuanpetty_id, array('diketahuiatasan_tgl' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('mengetahui', 'pengajuanpetty_id' => $pengajuanpetty_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Pengajuan Anggaran Operasional';
    $deskripsi = '';
    $this->render($this->path_view . '_mengetahui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDet' => $modDet
    ));
  }

  public function actionMenyetujui($pengajuanpetty_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PengajuanpettyT::model()->findByPk($pengajuanpetty_id);
    $modDet = PengajuanpettydetT::model()->findAllByAttributes(array('pengajuanpetty_id' => $pengajuanpetty_id));

    if ($approve) {
      $update = PengajuanpettyT::model()->updateByPk($pengajuanpetty_id, array('accdirektur_tgl' => date("Y-m-d H:i:s"), 'pengajuanpetty_status' => Params::STATUS_PETTY_CASH_DISETUJUI));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('menyetujui', 'pengajuanpetty_id' => $pengajuanpetty_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    if ($tolak) {
      $update = PengajuanpettyT::model()->updateByPk($pengajuanpetty_id, array('accdirektur_tgl' => date("Y-m-d"), 'pengajuanpetty_status' => Params::STATUS_PETTY_CASH_DITOLAK));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('menyetujui', 'pengajuanpetty_id' => $pengajuanpetty_id, 'sukses' => 1, 'ditolak' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Pengajuan Anggaran Operasional';
    $deskripsi = '';
    $this->render($this->path_view . '_menyetujui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDet' => $modDet
    ));
  }

  public function actionPrintInformasi()
  {
    $model  = new KUInfopengajuanpettyV;
    $format = new MyFormatter();

    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KUInfopengajuanpettyV'])) {
      $model->attributes = $_GET['KUInfopengajuanpettyV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];

    $periode = "";
    $judulLaporan = "Pengajuan Anggaran Operasional";
    //        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'PrintInformasi', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'PrintInformasi', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintInformasi', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
