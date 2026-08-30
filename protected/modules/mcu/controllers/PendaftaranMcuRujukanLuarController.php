<?php
Yii::import('mcu.controllers.PendaftaranPasienController');
class PendaftaranMcuRujukanLuarController extends PendaftaranPasienController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "mcu.views.pendaftaranMcuRujukanLuar.";
  public $path_view_mcu = "mcu.views.pendaftaranPasien.";

  public $pasientersimpan = false;
  public $pendaftarantersimpan = false;
  public $karcistersimpan = false;
  public $komponentindakantersimpan = false;
  public $asuransipasientersimpan = false;
  public $septersimpan = false;
  public $permintaanmcutersimpan = false;
  public $rujukantersimpan = false;
  public $rujukankeluartersimpan = false;
  public $pengambilansampletersimpan = true; //dilooping / boleh tanpa ini
  public $pasienpenunjangtersimpan = true; //dilooping
  public $hasilpemeriksaantersimpan = true; //dilooping

  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null, $idSep = null, $pendaftaran_id = null)
  {
    $format = new MyFormatter();
    $model = new MCPendaftaranT;
    $modPasien = new MCPasienM;
    $modRujukanKeluar = new MCPasiendirujukkeluarT();
    $modRujukan = new MCRujukanT;
    $modRujukanBpjs = new MCRujukanbpjsT;
    $modTindakan = new MCTindakanPelayananT;
    $modPembayaran = new MCPembayaranpelayananT();
    $modAntrian = new MCAntrianT;
    $modAsuransiPasien = new MCAsuransipasienM;
    $modAsuransiPasienBpjs = new MCAsuransipasienbpjsM;
    $modSep = new MCSepT;
    $modPaketPelayanan = new MCPaketpelayananM;
    $modPasienMasukPenunjang = new MCPasienmasukpenunjangT;
    $modPermintaanMcu = new MCPermintaanmcuT();
    $modPegawai = new MCPegawaiM;

    $modHasilPemeriksaan = new MCHasilPemeriksaanLabT;
    $modHasilPemeriksaanPA = new MCHasilPemeriksaanPAT;
    $modDetailHasilPemeriksaan = new MCDetailHasilPemeriksaanLabT;
    $modPengambilanSample = new MCPengambilanSampleT;
    $modHasilPemeriksaanRad = new MCHasilpemeriksaanradT;
    $dataTindakans = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    $modPasien->agama = Params::DEFAULT_AGAMA;
    $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    $model->is_bpjs = 0;
    $modRujukanKeluar->is_pasienrujukankeluar = 1;
    $modRujukanKeluar->alasandirujuk = "JAMINAN LAYANAN KESEHATAN MCU";
    $modRujukanKeluar->tgldirujuk = date('Y-m-d H:i:s');
    $modRujukanKeluar->tglberlakusurat = date('Y-m-d H:i:s');
    $modRujukanKeluar->sampaidengan = date('Y-m-d H:i:s');
    $modRujukanKeluar->nosuratrujukan = "-- Otomatis --";

    if (isset($_POST['buatjanjipoli_id'])) {
      if (!empty($_POST['buatjanjipoli_id'])) {
        $modJanjipoli = MCBuatJanjiPoliT::model()->findByPk($_POST['buatjanjipoli_id']);
        if (!empty($modJanjipoli->pasien_id)) {
          $modPasien = MCPasienM::model()->findByPk($modJanjipoli->pasien_id);
          $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
          $modPasien->no_rekam_medik = null;
          $modPasien->pasien_id = null;
        }
        if (!empty($modJanjipoli->ruangan_id))
          $model->ruangan_id = $modJanjipoli->ruangan_id;
        if (!empty($modJanjipoli->pegawai_id))
          $model->pegawai_id = $modJanjipoli->pegawai_id;
      }
    }

    //==load data
    if (isset($id)) {
      $model = $this->loadModel($id);
      if (isset($idSep)) {
        $model->is_bpjs = 1;
        $modRujukanBpjs = MCRujukanbpjsT::model()->findByPk($model->rujukan_id);
        $modAsuransiPasienBpjs = MCAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
      }
      $modPasien = MCPasienM::model()->findByPk($model->pasien_id);
      $dataTindakans = MCTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
      $modPermintaanMcu = MCPermintaanmcuT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
    }

    if (isset($idSep)) {
      $modSep = MCSepT::model()->findByPk($idSep);
    }

    if (isset($_GET['pasiendirujukkeluar_id'])) {
      $pasiendirujukkeluar_id = isset($_GET['pasiendirujukkeluar_id']) ? $_GET['pasiendirujukkeluar_id'] : null;
      $modRujukanKeluar = MCPasiendirujukkeluarT::model()->findByPk($pasiendirujukkeluar_id);
    }

    $pasien_id = (isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null);
    if (!empty($pasien_id)) {
      $modPasien = MCPasienM::model()->findByPk($pasien_id);
      $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
    }

    if (isset($_POST['MCPendaftaranT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPasien = $this->simpanPasien($modPasien, $_POST['MCPasienM']);

        if ($_POST['MCPendaftaranT']['is_bpjs']) {
          if (isset($_POST['MCRujukanbpjsT'])) {
            $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['MCRujukanbpjsT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }

        if (isset($_POST['MCAsuransipasienM'])) {
          if (isset($_POST['MCAsuransipasienM']['asuransipasien_id'])) {
            if (!empty($_POST['MCAsuransipasienM']['asuransipasien_id'])) {
              $modAsuransiPasien = MCAsuransipasienM::model()->findByPk($_POST['MCAsuransipasienM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['MCPendaftaranT'], $modPasien, $_POST['MCAsuransipasienM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['MCAsuransipasienbpjsM'])) {
          if (isset($_POST['MCAsuransipasienbpjsM']['asuransipasien_id'])) {
            if (!empty($_POST['MCAsuransipasienbpjsM']['asuransipasien_id'])) {
              $modAsuransiPasienBpjs = MCAsuransipasienM::model()->findByPk($_POST['MCAsuransipasienbpjsM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['MCPendaftaranT'], $modPasien, $_POST['MCAsuransipasienbpjsM']);
        } else {
          $this->asuransipasientersimpan = true;
        }


        if ($_POST['MCPendaftaranT']['is_bpjs']) {
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanBpjs, $_POST['MCPendaftaranT'], $_POST['MCPasienM'], $modAsuransiPasienBpjs);
          $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['MCSepT']);
        } else {
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $_POST['MCPendaftaranT'], $_POST['MCPasienM'], $modAsuransiPasien);
        }

        //				if(isset($_POST['MCPermintaanmcuT'])){
        //					if(count((array)$_POST['MCPermintaanmcuT']) > 0){
        //						foreach($_POST['MCPermintaanmcuT'][0] as $i => $pemeriksaan){
        //								$dataPermintaans[$i] = $this->simpanPermintaanMcu($model,$modPermintaanMcu,$pemeriksaan);
        //						}
        //					}
        //				}

        $tmpmcu = array();
        if (isset($_POST['MCPermintaanmcuT'])) {
          if (count((array)$_POST['MCPermintaanmcuT']) > 0) {
            foreach ($_POST['MCPermintaanmcuT'] as $i => $tindakanmcu) {
              foreach ($tindakanmcu as $ii => $tindakans) {
                $tmpmcu[$tindakans['ruangantujuan_id']][] = $tindakans['daftartindakan_id'];
              }
              foreach ($tmpmcu as $ruangan => $daftartindakan) {
                if ($ruangan == Params::RUANGAN_ID_LAB_ANATOMI || $ruangan == Params::RUANGAN_ID_LAB_KLINIK || $ruangan == Params::RUANGAN_ID_RAD || $ruangan == Params::RUANGAN_ID_LAB) {
                  $modPasienMasukPenunjangs[$ruangan] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, $ruangan);
                  if (isset($_POST['MCPermintaanmcuT'][$i])) {
                    if (count((array)$_POST['MCPermintaanmcuT'][$i]) > 0) {
                      if ($ruangan == Params::RUANGAN_ID_LAB_KLINIK || $ruangan == Params::RUANGAN_ID_LAB) {
                        $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjangs[$ruangan]);
                      }
                      foreach ($_POST['MCPermintaanmcuT'][$i] as $iii => $tindakanPelayanan) {
                        if ($modPasienMasukPenunjangs[$ruangan]['ruangan_id'] == $tindakanPelayanan['ruangantujuan_id']) {
                          $dataTindakans[$iii] = $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjangs[$ruangan], $tindakanPelayanan);
                          $dataPermintaans[$iii] = $this->simpanPermintaanMcu($model, $modPermintaanMcu, $tindakanPelayanan, $dataTindakans[$iii]);

                          if ($tindakanPelayanan['ruangantujuan_id'] == Params::RUANGAN_ID_LAB_KLINIK || $tindakanPelayanan['ruangantujuan_id'] == Params::RUANGAN_ID_LAB) {
                            if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                              $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$iii], $tindakanPelayanan);
                            }
                          } else if ($tindakanPelayanan['ruangantujuan_id'] == Params::RUANGAN_ID_LAB_ANATOMI) {
                            $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjangs[$i], $dataTindakans[$i][$ii], $tindakanPelayanan);
                          } else if ($tindakanPelayanan['ruangantujuan_id'] == Params::RUANGAN_ID_RAD) {
                            $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjangs[$i], $dataTindakans[$iii], $tindakanPelayanan);
                          }
                        }
                      }
                    }
                  }
                } else {
                  foreach ($_POST['MCPermintaanmcuT'][$i] as $iii => $tindakanPelayanan) {
                    $modPasienMasukPenunjangs[$ruangan] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, $ruangan);
                    $dataTindakans[$iii] = $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjangs[$ruangan], $tindakanPelayanan);
                    $dataPermintaans[$iii] = $this->simpanPermintaanMcu($model, $modPermintaanMcu, $tindakanPelayanan, $dataTindakans[$iii]);
                  }
                }
              }
            }
          }
        }

        if ($_POST['MCPasiendirujukkeluarT']['is_pasienrujukankeluar']) {
          if (isset($_POST['MCPasiendirujukkeluarT'])) {
            $modRujukanKeluar = $this->simpanRujukanKeluar($modRujukanKeluar, $model, $_POST['MCPasiendirujukkeluarT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }

        $tmp = array();
        if (isset($_POST['MCTindakanPelayananT'])) {
          if (count((array)$_POST['MCTindakanPelayananT']) > 0) {
            $this->permintaanmcutersimpan = true;
            foreach ($_POST['MCTindakanPelayananT'] as $i => $tindakan) {
              foreach ($tindakan as $ii => $tindakans) {
                $tmp[$tindakans['ruangan_id']][] = $tindakans['daftartindakan_id'];
              }
              foreach ($tmp as $ruangan => $daftartindakan) {
                $modPasienMasukPenunjangs[$ruangan] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, $ruangan);
                if (isset($_POST['MCTindakanPelayananT'][$i])) {
                  if (count((array)$_POST['MCTindakanPelayananT'][$i]) > 0) {
                    if ($ruangan == Params::RUANGAN_ID_LAB_KLINIK) {
                      $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjangs[$ruangan]);
                    }
                    foreach ($_POST['MCTindakanPelayananT'][$i] as $iii => $tindakanPelayanan) {
                      if ($modPasienMasukPenunjangs[$ruangan]['ruangan_id'] == $tindakanPelayanan['ruangan_id']) {
                        $dataTindakans[$iii] = $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjangs[$ruangan], $tindakanPelayanan);

                        if ($tindakanPelayanan['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK) {
                          if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                            $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$iii], $tindakanPelayanan);
                          }
                        } else if ($tindakanPelayanan['ruangan_id'] == Params::RUANGAN_ID_LAB_ANATOMI) {
                          $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjangs[$i], $dataTindakans[$i][$ii], $tindakanPelayanan);
                        } else if ($tindakanPelayanan['ruangan_id'] == Params::RUANGAN_ID_RAD) {
                          $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjangs[$i], $dataTindakans[$iii], $tindakanPelayanan);
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }

        $this->komponentindakantersimpan = true;
        if ($this->pasientersimpan && $this->pendaftarantersimpan && $this->komponentindakantersimpan && $this->asuransipasientersimpan && $this->permintaanmcutersimpan && $this->rujukankeluartersimpan) {
          $transaction->commit();
          //Di set di form >> Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
          //                      RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
          if ($this->septersimpan) {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'pasiendirujukkeluar_id' => $modRujukanKeluar->pasiendirujukkeluar_id, 'idSep' => $modSep->sep_id, 'sukses' => 1));
          } else {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'pasiendirujukkeluar_id' => $modRujukanKeluar->pasiendirujukkeluar_id, 'sukses' => 1));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    $this->render('index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modRujukanKeluar' => $modRujukanKeluar,
      'modRujukan' => $modRujukan,
      'modRujukanBpjs' => $modRujukanBpjs,
      'modTindakan' => $modTindakan,
      'modAntrian' => $modAntrian,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'dataTindakans' => $dataTindakans,
      'modSep' => $modSep,
      'modPaketPelayanan' => $modPaketPelayanan,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modPermintaanMcu' => $modPermintaanMcu,
      'modPegawai' => $modPegawai,
    ));
  }

  /**
   * proses simpan data rujukan keluar
   * @param type $modRujukanKeluar
   * @param type $post
   * @return type
   */
  public function simpanRujukanKeluar($modRujukanKeluar, $model, $post)
  {
    $format = new MyFormatter();
    $modRujukanKeluar->attributes = $post;
    $modRujukanKeluar->nosuratrujukan = MyGenerator::noSuratRujukanKeluar();
    $modRujukanKeluar->pasien_id = $model->pasien_id;
    $modRujukanKeluar->pasienadmisi_id = isset($model->pasienadmisi_id) ? $model->pasienadmisi_id : null;
    $modRujukanKeluar->pendaftaran_id = $model->pendaftaran_id;
    $modRujukanKeluar->ruanganasal_id = $model->ruangan_id;
    $modRujukanKeluar->ruanganasal_id = $model->ruangan_id;
    $modRujukanKeluar->tgldirujuk = $format->formatDateTimeForDb($modRujukanKeluar->tgldirujuk);
    $modRujukanKeluar->tglberlakusurat = $format->formatDateTimeForDb($modRujukanKeluar->tglberlakusurat);
    $modRujukanKeluar->sampaidengan = $format->formatDateTimeForDb($modRujukanKeluar->sampaidengan);
    $modRujukanKeluar->create_time = date('Y-m-d H:i:s');
    $modRujukanKeluar->create_loginpemakai_id = Yii::app()->user->id;
    $modRujukanKeluar->pegawai_id = $model->pegawai_id;

    if ($modRujukanKeluar->validate()) {
      $modRujukanKeluar->save();
      $this->rujukankeluartersimpan = true;
    }
    return $modRujukanKeluar;
  }

  /**
   * form verifikasi sebelum submit
   * @param type $id
   */
  public function actionVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $this->layout = '//layouts/iframe';
      if (isset($_POST['MCPendaftaranT'])) {
        $format = new MyFormatter();
        $model = new MCPendaftaranT();
        $modPasien = new MCPasienM;
        $modRujukanKeluar = new MCPasiendirujukkeluarT();
        $modPenanggungJawab = null;
        $modRujukan = null;
        $modTindakan = null;

        $model->attributes = $_POST['MCPendaftaranT'];
        $modPasien->attributes = $_POST['MCPasienM'];
        $modRujukanKeluar->attributes = $_POST['MCPasiendirujukkeluarT'];
      }
      echo CJSON::encode(array(
        'content' => $this->renderPartial('verifikasi', array(
          'model' => $model,
          'modPasien' => $modPasien,
          'modPenanggungJawab' => $modPenanggungJawab,
          'modRujukanKeluar' => $modRujukanKeluar,
          'modTindakan' => $modTindakan,
          'format' => $format,
        ), true)
      ));
      Yii::app()->end();
    }
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintSuratMcu($pendaftaran_id, $pasiendirujukeluar_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPenanggungjawab = array();
    if (!empty($modPendaftaran->penanggungjawab_id)) {
      $modPenanggungjawab = MCPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    }
    $modRujukanKeluar = MCPasiendirujukkeluarT::model()->findByPk($pasiendirujukeluar_id);
    $karcis_id = null;
    $judul_print = 'Pendaftaran Pasien MCU Rujukan Keluar';
    $this->render($this->path_view . 'printSuratMcu', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPenanggungjawab' => $modPenanggungjawab,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modRujukanKeluar' => $modRujukanKeluar,
    ));
  }

  /**
   * set tglberlakusurat dari rujukan
   */
  public function actionSetTglAkhir()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter();
      $data['tglAkhir'] = null;
      $estimasihari = 1;
      if (isset($_POST['tglberlakusurat']) && !empty($_POST['tglberlakusurat'])) {
        if (!empty($_POST['tglberlakusurat'])) {
          $tglberlakusurat = $format->formatDateTimeForDb($_POST['tglberlakusurat']);
          $tanggal = strtotime($tglberlakusurat . ' + ' . $estimasihari . ' months');
          $tglsampaidengan = date('Y-m-d H:i:s', $tanggal);
        } else {
          $tanggal = date('Y-m-d H:i:s');
          $tanggal = strtotime($tanggal . ' + ' . $estimasihari . ' months');
          $tglsampaidengan = date('Y-m-d H:i:s', $tanggal);
        }
        $data['tglAkhir'] = (!empty($tglsampaidengan) ? date("d/m/Y", strtotime($tglsampaidengan)) : null);
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
