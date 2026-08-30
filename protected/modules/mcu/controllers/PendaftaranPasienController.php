<?php
Yii::import('pendaftaranPenjadwalan.models.*');

/**
 * Pendaftaran Pasien MCu
 *
 * @author rusdiyanto <rusdiyanto@.com>
 * @package application.modules.mcu
 * @subpackage controllers
 */
class PendaftaranPasienController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view_mcu = "mcu.views.pendaftaranPasien.";
  public $path_view = 'pendaftaranPenjadwalan.views.pendaftaranRawatJalan.';
  public $pasientersimpan = false;
  public $pendaftarantersimpan = false;
  public $karcistersimpan = false;
  public $komponentindakantersimpan = false;
  public $asuransipasientersimpan = false;
  public $septersimpan = false;
  public $permintaanmcutersimpan = false;
  public $rujukantersimpan = false;
  public $rujukankeluartersimpan = false;
  public $konsulpolitersimpan = true;
  public $pengambilansampletersimpan = true; //dilooping / boleh tanpa ini
  public $pasienpenunjangtersimpan = true; //dilooping
  public $hasilpemeriksaantersimpan = true; //dilooping
  public $tindakanpelayanantersimpan = true; //dilooping

  /**
   * Index transaksi pendaftaran
   *
   * @param integer $id
   * @param integer $idSep
   * @param integer $pendaftaran_id
   */
  public function actionIndex($id = null, $idSep = null, $pendaftaran_id = null, $linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pendaftaran Pasien Mcu";
    $format = new MyFormatter();
    $model = new MCPendaftaranT;
    $modPasien = new MCPasienM;
    $modRujukan = new MCRujukanT;
    $modRujukanBpjs = new MCRujukanbpjsT;
    $modTindakan = new MCTindakanPelayananT;
    $modTindakanKarcis = new MCTindakanPelayananKarcisT;
    $modPembayaran = new MCPembayaranpelayananT();
    $modAntrian = new PPAntrianT;
    $modAsuransiPasien = new MCAsuransipasienM;
    $modAsuransiPasienBpjs = new MCAsuransipasienbpjsM;
    $modSep = new MCSepT;
    $modPaketPelayanan = new MCPaketpelayananM;
    $modPasienMasukPenunjang = new MCPasienmasukpenunjangT;
    $modPermintaanMcu = new MCPermintaanmcuT();
    $modPemeriksaanMcu = new PermintaanmcuT();
    $modPegawai = new MCPegawaiM;
    $modPenanggungJawab = new PPPenanggungJawabM;

    $modHasilPemeriksaan = new MCHasilPemeriksaanLabT;
    $modHasilPemeriksaanPA = new MCHasilPemeriksaanPAT;
    $modDetailHasilPemeriksaan = new MCDetailHasilPemeriksaanLabT;
    $modPengambilanSample = new MCPengambilanSampleT;
    $modHasilPemeriksaanRad = new MCHasilpemeriksaanradT;
    $dataTindakans = array();
    $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    $model->is_bpjs = 0;
    $model->ruangan_id = Params::RUANGAN_ID_KLINIK_MCU;
    $model->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_UMUM; // Jenis Kasus Penyakit umum
    $model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    $model->penjamin_id = Params::PENJAMIN_ID_UMUM;
    $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS_MCU;

    $modPemeriksaanMcu->tglrencanaperiksa = date('Y-m-d H:i:s');

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
      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
      }
      //                if(!empty($model->rujukan_id)){
      //                    $modRujukan=MCRujukanT::model()->findByPk($model->rujukan_id);
      //                }
      $dataTindakans = MCTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
      $modPermintaanMcu = MCPermintaanmcuT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
    }

    if (isset($idSep)) {
      $modSep = MCSepT::model()->findByPk($idSep);
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
          if (!empty($pendaftaran_id)) {
            $updatePendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
            if ($updatePendaftaran) {
              $model = $this->loadModel($pendaftaran_id);
              $this->pendaftarantersimpan = true;
            }
          } else {
            $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $_POST['MCPendaftaranT'], $_POST['MCPasienM'], $modAsuransiPasien);
          }
        }
        if (isset($_POST['MCPermintaanmcuT'])) {
          if (isset($_POST['MCPermintaanmcuT'][Params::RUANGAN_ID_LAB_KLINIK]) || isset($_POST['MCTindakanPelayananT'][Params::RUANGAN_ID_LAB_KLINIK])) {
            $modPasienMasukPenunjangs[Params::RUANGAN_ID_LAB_KLINIK] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, Params::RUANGAN_ID_LAB_KLINIK);
            $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjangs[Params::RUANGAN_ID_LAB_KLINIK]);
          }
          if (isset($_POST['MCPermintaanmcuT'][Params::RUANGAN_ID_LAB_ANATOMI]) || isset($_POST['MCTindakanPelayananT'][Params::RUANGAN_ID_LAB_ANATOMI])) {
            $modPasienMasukPenunjangs[Params::RUANGAN_ID_LAB_ANATOMI] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, Params::RUANGAN_ID_LAB_ANATOMI);
          }
          if (isset($_POST['MCPermintaanmcuT'][Params::RUANGAN_ID_RAD]) || isset($_POST['MCTindakanPelayananT'][Params::RUANGAN_ID_RAD])) {
            $modPasienMasukPenunjangs[Params::RUANGAN_ID_RAD] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, Params::RUANGAN_ID_RAD);
          }
          if (isset($_POST['MCPermintaanmcuT'][Params::RUANGAN_ID_FISIOTERAPI]) || isset($_POST['MCTindakanPelayananT'][Params::RUANGAN_ID_FISIOTERAPI])) {
            $modPasienMasukPenunjangs[Params::RUANGAN_ID_FISIOTERAPI] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, Params::RUANGAN_ID_FISIOTERAPI);
          }

          if (count((array)$_POST['MCPermintaanmcuT']) > 0) {
            foreach ($_POST['MCPermintaanmcuT'] as $ruangan_id => $permintaan) {
              //								RSSP-1536
              //								$modKlinik = RuanganM::model()->findByPk($ruangan_id);
              $modKlinik = RuanganM::model()->findByAttributes(array('ruangan_id' => $ruangan_id, 'ruangan_aktif' => true));
              if (!empty($modKlinik)) {
                if ($modKlinik->instalasi_id == Params::INSTALASI_ID_RJ && $ruangan_id != Yii::app()->user->getState('ruangan_id')) {
                  $modKonsulPoli[$ruangan_id] = $this->simpanKonsulPoli($model, $ruangan_id);
                }
              }
            }
          }
          // echo "<pre>";
          // var_dump($_POST);die;
          foreach ($_POST['MCPermintaanmcuT'] as $i => $tindakanmcu) {

            foreach ($_POST['MCPermintaanmcuT'][$i] as $iii => $tindakanPelayanan) {
              $pasienPenunjang = (isset($modPasienMasukPenunjangs[$i]) ? $modPasienMasukPenunjangs[$i] : null);
              $dataTindakans = array();
              $dataTindakans[$iii] = $this->simpanTindakanPelayanan($model, $pasienPenunjang, $tindakanPelayanan);
              $dataPermintaans[$iii] = $this->simpanPermintaanMcu($model, $modPermintaanMcu, $tindakanPelayanan, $dataTindakans[$iii]);
              if (isset($modPasienMasukPenunjangs[$i])) {
                if ($i == Params::RUANGAN_ID_LAB_KLINIK || $i == Params::RUANGAN_ID_LAB) {
                  if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                    $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$iii], $tindakanPelayanan);
                  }
                } else if ($i == Params::RUANGAN_ID_LAB_ANATOMI) {
                  $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjangs[$i], $dataTindakans[$i][$ii], $tindakanPelayanan);
                } else if ($i == Params::RUANGAN_ID_RAD) {
                  $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjangs[$i], $dataTindakans[$iii], $tindakanPelayanan);
                } else if ($i == Params::RUANGAN_ID_FISIOTERAPI) {
                  $this->simpanHasilPemeriksaanRehab($modPasienMasukPenunjangs[$i], $dataTindakans[$iii], $tindakanPelayanan);
                }
              }
            }
          }
        }

        $tmp = array();
        $x = 0;
        if (isset($_POST['MCTindakanPelayananT'])) {
          if (count((array)$_POST['MCTindakanPelayananT']) > 0) {
            $this->permintaanmcutersimpan = true;
            foreach ($_POST['MCTindakanPelayananT'] as $i => $tindakan) {

              if (isset($_POST['MCTindakanPelayananT'][$i])) {
                if (count((array)$_POST['MCTindakanPelayananT'][$i]) > 0) {
                  foreach ($_POST['MCTindakanPelayananT'][$i] as $iii => $tindakanPelayanan) {
                    $pasienPenunjang = (isset($modPasienMasukPenunjangs[$i]) ? $modPasienMasukPenunjangs[$i] : null);
                    $dataTindakans[$iii] = $this->simpanTindakanPelayanan($model, $pasienPenunjang, $tindakanPelayanan);
                    if (isset($modPasienMasukPenunjangs[$i])) {
                      if ($tindakanPelayanan['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK) {
                        if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                          //                                                    $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$iii], $tindakanPelayanan);
                          $this->simpanDetailHasilPemeriksaanLabNon($modHasilPemeriksaan, $dataTindakans[$iii], $tindakanPelayanan);
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

        if ($_POST['MCPendaftaranT']['is_adakarcis']) {
          if (isset($_POST['MCKarcisV'])) {
            if (count((array)$_POST['MCKarcisV']) > 0) {
              foreach ($_POST['MCKarcisV'] as $i => $karcis) {
                if ($karcis['is_pilihtindakan']) {
                  $dataTindakans[$i] = $this->simpanKarcis($modTindakanKarcis, $model, $karcis);
                }
              }
            }
            if (isset($_POST['MCPendaftaranT']['is_bayarkarcis'])) { //fitur belum ada >> RND-666
              if ($_POST['MCPendaftaranT']['is_bayarkarcis']) { //jika di ceklis
              }
            }
          }
        }
        
        $ok_vaksinasi = true;
                    
                    
        if ($_POST['MCPendaftaranT']['is_vaksinasi'] && isset($_POST['RiwayatvaksinasipasienT']['detail'])) {
            $ok_vaksinasi = RiwayatvaksinasipasienT::simpanRiwayat($model->pendaftaran_id, $model->pasien_id, $_POST['RiwayatvaksinasipasienT']['detail']);
        }


        if (!empty($modPasienMasukPenunjangs[Params::RUANGAN_ID_RAD])) {
          $this->tambahPasienHL7($modPasienMasukPenunjangs[Params::RUANGAN_ID_RAD], "Pemeriksaan dari Pasien MCU");
        }



        
        $this->karcistersimpan = true;
        $this->komponentindakantersimpan = true;
        if ($this->pasientersimpan && $this->pendaftarantersimpan && $this->karcistersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->asuransipasientersimpan && $this->permintaanmcutersimpan && $this->pasienpenunjangtersimpan && $this->konsulpolitersimpan) {
          $this->kirimNotifPendaftaranMCU($model, $modPasien);
          $transaction->commit();
          //Di set di form >> Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
          //                      RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
          if ($this->septersimpan) {
            
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1));
          } else {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1));
          }
        } else {
          //('error');
          //($this->pasientersimpan .'<br>'. $this->pendaftarantersimpan .'<br>'.  $this->karcistersimpan .'<br>'.  $this->tindakanpelayanantersimpan .'<br>'.  $this->komponentindakantersimpan .'<br>'.  $this->asuransipasientersimpan .'<br>'.  $this->permintaanmcutersimpan .'<br>'.  $this->pasienpenunjangtersimpan .'<br>'.  $this->konsulpolitersimpan);die;

          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
          if ($this->tindakanpelayanantersimpan == false) {
            Yii::app()->user->setFlash('error', "Data tindakan gagal disimpan !");
          }
        }
      } catch (Exception $exc) {
        //('asasasa4');

        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view_mcu . 'index', array(
      'model' => $model,
      'modPasien' => $modPasien,
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
      'modPemeriksaanMcu' => $modPemeriksaanMcu,
      'modTindakanKarcis' => $modTindakanKarcis,
      'modPenanggungJawab' => $modPenanggungJawab,
      'linkHalaman' => $linkHalaman
    ));
  }

  protected function kirimNotifPendaftaranMCU($model, $modPasien)
  {

    $judul = "Pendaftaran Pasien MCU";
    $isi = $model->no_pendaftaran . " - " . $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;

    $ruangan = RuanganM::model()->findByPk($model->ruangan_id);

    $link = $this->createUrl('/mcu/InformasiDaftarPasienMC/Index', array(
      'MCInfokunjunganmcuV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
      'MCInfokunjunganmcuV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
      'MCInfokunjunganmcuV[no_pendaftaran]' => substr($model->no_pendaftaran, 2),
      'MCInfokunjunganmcuV[nama_pasien]' => $modPasien->nama_pasien,
      'MCInfokunjunganmcuV[no_rekam_medik]' => $modPasien->no_rekam_medik,
      'MCInfokunjunganmcuV[ruangan_id]' => '',
      'MCInfokunjunganmcuV[kelaspelayanan_id]' => '',
      'MCInfokunjunganmcuV[statusperiksa]' => '',
      'MCInfokunjunganmcuV[pegawai_id]' => ''
    ));

    // //($judul, $isi, $link); die;

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id, 'link_proses' => $link), //, 'link_proses'=>$link_rj
      //array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_1, 'modul_id'=>10),
      //array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
      //array('instalasi_id'=>Params::INSTALASI_ID_RM, 'ruangan_id'=>Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id'=>  Params::MODUL_ID_REKAMMEDIS, 'link_proses' => $link),//, 'link_proses' => $link
    ));
  }


  /**
   * Prooses Update data paket tindakan MCu
   * @param integer $id
   * @param integer $pendaftaran_id
   */
  public function actionUpdatePaketTindakanPasien($pendaftaran_id = null)
  {
    $format = new MyFormatter();
    $model = new MCPendaftaranT;
    $modPasien = new MCPasienM;
    $modRujukan = new MCRujukanT;
    $modRujukanBpjs = new MCRujukanbpjsT;
    $modTindakan = new MCTindakanPelayananT;
    $modTindakanKarcis = new MCTindakanPelayananKarcisT;
    $modPembayaran = new MCPembayaranpelayananT();
    $modAntrian = new PPAntrianT;
    $modAsuransiPasien = new MCAsuransipasienM;
    $modAsuransiPasienBpjs = new MCAsuransipasienbpjsM;
    $modSep = new MCSepT;
    $modPaketPelayanan = new MCPaketpelayananM;
    $modPasienMasukPenunjang = new MCPasienmasukpenunjangT;
    $modPermintaanMcu = new MCPermintaanmcuT();
    $modPemeriksaanMcu = new PermintaanmcuT();
    $modPegawai = new MCPegawaiM;
    $modPenanggungJawab = new PPPenanggungJawabM;

    $modHasilPemeriksaan = new MCHasilPemeriksaanLabT;
    $modHasilPemeriksaanPA = new MCHasilPemeriksaanPAT;
    $modDetailHasilPemeriksaan = new MCDetailHasilPemeriksaanLabT;
    $modPengambilanSample = new MCPengambilanSampleT;
    $modHasilPemeriksaanRad = new MCHasilpemeriksaanradT;
    $dataTindakans = array();

    $tipepaket_id = null;

    //==load data
    if (isset($pendaftaran_id)) {
      $model = $this->loadModel($pendaftaran_id);
      $modPasien = MCPasienM::model()->findByPk($model->pasien_id);
      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
      }

      $criteria = new CDbCriteria;
      $criteria->addCondition('tindakanpelayanan_id NOT IN (SELECT tindakanpelayanan_id FROM permintaanmcu_t)');
      $criteria->addCondition('pendaftaran_id = ' . $model->pendaftaran_id);
      $criteria->addCondition('tipepaket_id = ' . Params::TIPEPAKET_ID_NONPAKET);
      $dataTindakans = MCTindakanPelayananT::model()->findAll($criteria);

      $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
      $modPermintaanMcu = MCPermintaanmcuT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
      $modPemeriksaanMcu->tglrencanaperiksa = $modPermintaanMcu->tglrencanaperiksa;
    }

    $pasien_id = (isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null);
    if (!empty($pasien_id)) {
      $modPasien = MCPasienM::model()->findByPk($pasien_id);
      $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
    }

    if (isset($_POST['MCPendaftaranT'])) {

      /*Cek tipe paket ada perubahan paket atau tidak*/
      foreach ($_POST['MCPermintaanmcuT'] as $i => $tindakanmcu) {
        foreach ($_POST['MCPermintaanmcuT'][$i] as $iii => $tindakanPelayanan) {
          $tipepaket_id = $tindakanPelayanan['tipepaket_id'];
        }
      }

      $transaction = Yii::app()->db->beginTransaction();
      try {


        if (isset($_POST['MCPermintaanmcuT'])) {

          /*
                    if (isset($_POST['MCPermintaanmcuT'][Params::RUANGAN_ID_LAB_KLINIK]) || isset($_POST['MCTindakanPelayananT'][Params::RUANGAN_ID_LAB_KLINIK])) {

                        $cekPenunjang = PasienmasukpenunjangT::model()->findByAttributes(
                            array(
                                'pendaftaran_id' => $model->pendaftaran_id,
                                'pendaftaran_id' => $model->pendaftaran_id,
                                'ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK,
                                'ruanganasal_id' => Yii::app()->user->getState('ruangan_id'),
                            )
                        );

                        if(!empty($cekPenunjang->pasienmasukpenunjang_id)){
                            $modPasienMasukPenunjangs[Params::RUANGAN_ID_LAB_KLINIK] = $cekPenunjang;
                            $modHasilPemeriksaan = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $cekPenunjang->pasienmasukpenunjang_id));
                        }else{
                            $modPasienMasukPenunjangs[Params::RUANGAN_ID_LAB_KLINIK] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, Params::RUANGAN_ID_LAB_KLINIK);
                            $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjangs[Params::RUANGAN_ID_LAB_KLINIK]);
                        }

                    }
                    if (isset($_POST['MCPermintaanmcuT'][Params::RUANGAN_ID_LAB_ANATOMI]) || isset($_POST['MCTindakanPelayananT'][Params::RUANGAN_ID_LAB_ANATOMI])) {

                        $cekPenunjang = PasienmasukpenunjangT::model()->findByAttributes(
                            array(
                                'pendaftaran_id' => $model->pendaftaran_id,
                                'pendaftaran_id' => $model->pendaftaran_id,
                                'ruangan_id' => Params::RUANGAN_ID_LAB_ANATOMI,
                                'ruanganasal_id' => Yii::app()->user->getState('ruangan_id'),
                            )
                        );

                        if(!empty($cekPenunjang->pasienmasukpenunjang_id)){
                            $modPasienMasukPenunjangs[Params::RUANGAN_ID_LAB_ANATOMI] = $cekPenunjang;
                        }else{
                            $modPasienMasukPenunjangs[Params::RUANGAN_ID_LAB_ANATOMI] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, Params::RUANGAN_ID_LAB_ANATOMI);
                        }

                    }
                    if (isset($_POST['MCPermintaanmcuT'][Params::RUANGAN_ID_RAD]) || isset($_POST['MCTindakanPelayananT'][Params::RUANGAN_ID_RAD])) {

                        $cekPenunjang = PasienmasukpenunjangT::model()->findByAttributes(
                            array(
                                'pendaftaran_id' => $model->pendaftaran_id,
                                'pendaftaran_id' => $model->pendaftaran_id,
                                'ruangan_id' => Params::RUANGAN_ID_RAD,
                                'ruanganasal_id' => Yii::app()->user->getState('ruangan_id'),
                            )
                        );

                        if(!empty($cekPenunjang->pasienmasukpenunjang_id)){
                            $modPasienMasukPenunjangs[Params::RUANGAN_ID_RAD] = $cekPenunjang;
                        }else{
                            $modPasienMasukPenunjangs[Params::RUANGAN_ID_RAD] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, Params::RUANGAN_ID_RAD);
                        }

                    }
                     *
                     */

          /*Proses jika perubahan paket MCU*/
          if ($modPermintaanMcu->tipepaket_id != $tipepaket_id) {
            /*Proses hapus data-data paket dan tindakan*/
            /*Hapus konsul*/
            MCKonsulpoliT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')));

            /*Hapus Tindakan pelayanan mcu */
            $pasienmasukpenunjang_id = array();
            $tindakanPelayananTemp = TindakanpelayananT::model()->findAll('pendaftaran_id = '.$model->pendaftaran_id.' AND tipepaket_id != '.Params::TIPEPAKET_ID_NONPAKET.'');
            foreach ($tindakanPelayananTemp as $key => $value) {
                /*Simpan pasienmasukpenunjang_id untuk hapus tabel hasil pemeriksaan*/
                if(!empty($value->pasienmasukpenunjang_id)){
                    $pasienmasukpenunjang_id[] = $value->pasienmasukpenunjang_id;
                    $value->detailhasilpemeriksaanlab_id = null;
                    $value->hasilpemeriksaanrad_id = null;
                    $value->hasilpemeriksaanpa_id = null;
                    $value->update();
                }
                /*Hapus pemeriksaan RAD berdasarkan tindakanpelayanan paket*/
                MCHasilpemeriksaanradT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'tindakanpelayanan_id' => $value->tindakanpelayanan_id));
                /*Hapus pemeriksaan RAD berdasarkan tindakanpelayanan paket*/
                MCHasilPemeriksaanPAT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'tindakanpelayanan_id' => $value->tindakanpelayanan_id));
                /*Hapus Detail pemeriksaan berdasarkan tindakanpelayanan paket*/
                MCDetailHasilPemeriksaanLabT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $value->tindakanpelayanan_id));
            }
            /*Hapus hasil pemeriksaan*/
            $criteria=new CDbCriteria;
            $criteria->addInCondition('pasienmasukpenunjang_id', $pasienmasukpenunjang_id);
            $modHasilLab = MCHasilPemeriksaanLabT::model()->findAll($criteria);
            if(count((array)$modHasilLab)){
                foreach ($modHasilLab as $key => $value) {
                    $value->delete();
                }
            }
            /*Hapus Permintaan mcu*/
            MCPermintaanmcuT::model()->deleteAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));

            if (count((array)$_POST['MCPermintaanmcuT']) > 0) {
                foreach ($_POST['MCPermintaanmcuT'] AS $ruangan_id => $permintaan) {
                    $modKlinik = RuanganM::model()->findByAttributes(array('ruangan_id' => $ruangan_id, 'ruangan_aktif' => true));
                    if (!empty($modKlinik)) {
                        if ($modKlinik->instalasi_id == Params::INSTALASI_ID_RJ && $ruangan_id != Yii::app()->user->getState('ruangan_id')) {
                            $modKonsulPoli[$ruangan_id] = $this->simpanKonsulPoli($model, $ruangan_id);
                        }
                    }
                }
            }

            /*Hapus Tindakan dari paket namun tipe paketnya adalan non paket, seperti konsul, surat sehat ,..*/
//            $criteria = new CDbCriteria;
//            $criteria->addCondition('pendaftaran_id = ' . $model->pendaftaran_id);
//            $modTind = MCTindakanPelayananT::model()->findAll($criteria);
//            if (count((array)$modTind)) {
//              foreach ($modTind as $key => $value) {
//                $Permintaan = MCPermintaanmcuT::model()->findByAttributes(array('tindakanpelayanan_id' => $value->tindakanpelayanan_id));
//                if (empty($Permintaan->tindakanpelayanan_id)) {
//                  $value->delete();
//                }
//              }
//            }
            /*
                        foreach ($_POST['MCPermintaanmcuT'] as $i => $tindakanmcu) {

                            foreach ($_POST['MCPermintaanmcuT'][$i] AS $iii => $tindakanPelayanan) {
                                $pasienPenunjang = (isset($modPasienMasukPenunjangs[$i]) ? $modPasienMasukPenunjangs[$i] : null);
                                $dataTindakans = array();
                                $dataTindakans[$iii] = $this->simpanTindakanPelayanan($model, $pasienPenunjang, $tindakanPelayanan);
                                $dataPermintaans[$iii] = $this->simpanPermintaanMcu($model, $modPermintaanMcu, $tindakanPelayanan, $dataTindakans[$iii]);
                                if (isset($modPasienMasukPenunjangs[$i])) {
                                    if ($i == Params::RUANGAN_ID_LAB_KLINIK || $i == Params::RUANGAN_ID_LAB) {
                                        if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                                            $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$iii], $tindakanPelayanan);
                                        }
                                    } else if ($i == Params::RUANGAN_ID_LAB_ANATOMI) {
                                        $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjangs[$i], $dataTindakans[$i][$ii], $tindakanPelayanan);
                                    } else if ($i == Params::RUANGAN_ID_RAD) {
                                        $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjangs[$i], $dataTindakans[$iii], $tindakanPelayanan);
                                    }
                                }
                            }
                        }
                         *
                         */

            /*Hapus Masuk penunjang yang sudah ada tindakan pelayanan*/
//            $criteria = new CDbCriteria;
//            $criteria->addCondition('pendaftaran_id = ' . $model->pendaftaran_id);
//            $modPenunjang = MCPasienmasukpenunjangT::model()->findAll($criteria);
//            if (count((array)$modPenunjang)) {
//              foreach ($modPenunjang as $key => $value) {
//
//                if ($value->ruangan_id == Params::RUANGAN_ID_RAD) {
//                  $hl7 = new HL7;
//                  $hl7->hapusPasien($value->pasienmasukpenunjang_id, "Pemeriksaan dari Pasien MCU");
//                }
//
//                $Tindakan = MCTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $value->pasienmasukpenunjang_id));
//                if (empty($Tindakan->tindakanpelayanan_id)) {
//                  $sampel = PengambilansampleT::model()->deleteAllByAttributes(array(
//                    'pasienmasukpenunjang_id' => $value->pasienmasukpenunjang_id
//                  ));
//                  $value->delete();
//                }
//              }
//            }
          }
        }

        /*Hapus Tindakan pelayanan mcu */
        $pasienmasukpenunjang_id = array();
        $tindakanPelayananTemp = TindakanpelayananT::model()->findAll('pendaftaran_id = '.$model->pendaftaran_id.' AND tipepaket_id = '.Params::TIPEPAKET_ID_NONPAKET.'');
        foreach ($tindakanPelayananTemp as $key => $value) {
            /*Simpan pasienmasukpenunjang_id untuk hapus tabel hasil pemeriksaan*/
            if(!empty($value->pasienmasukpenunjang_id)){
                $pasienmasukpenunjang_id[] = $value->pasienmasukpenunjang_id;
                $value->detailhasilpemeriksaanlab_id = null;
                $value->hasilpemeriksaanrad_id = null;
                $value->hasilpemeriksaanpa_id = null;
                $value->update();
            }

        }

        if (count((array)$pasienmasukpenunjang_id) > 0) {
            $penunjang = PasienmasukpenunjangT::model()->findByAttributes(array(
                'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,
                'ruangan_id'=>Params::RUANGAN_ID_RAD,
            ));

            if (!empty($penunjang)) {
                $hl7 = new HL7;
                $ok = $hl7->hapusPasien($penunjang->pasienmasukpenunjang_id, "Pemeriksaan dari Pasien MCU");
            }
        }


        foreach ($tindakanPelayananTemp as $key => $value) {
            /*Hapus pemeriksaan RAD berdasarkan tindakanpelayanan paket*/

            MCHasilpemeriksaanradT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'tindakanpelayanan_id' => $value->tindakanpelayanan_id));
            /*Hapus pemeriksaan RAD berdasarkan tindakanpelayanan paket*/
            MCHasilPemeriksaanPAT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'tindakanpelayanan_id' => $value->tindakanpelayanan_id));

            /*Hapus Detail pemeriksaan berdasarkan tindakanpelayanan paket*/
            MCDetailHasilPemeriksaanLabT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $value->tindakanpelayanan_id));
        }
        /*Hapus hasil pemeriksaan*/
        $criteria=new CDbCriteria;
        $criteria->addInCondition('pasienmasukpenunjang_id', $pasienmasukpenunjang_id);
        $modHasilLab = MCHasilPemeriksaanLabT::model()->findAll($criteria);
        if(count((array)$modHasilLab)){
            foreach ($modHasilLab as $key => $value) {
                $value->delete();
            }
        }

        /*Hapus Tindakan dari paket/none namun tipe paketnya adalah non paket, seperti konsul, surat sehat ,..*/
        $criteria=new CDbCriteria;
        $criteria->addCondition('pendaftaran_id = '.$model->pendaftaran_id);
        $modTind = MCTindakanPelayananT::model()->findAll($criteria);
        if(count((array)$modTind)){
            foreach ($modTind as $key => $value) {
                $Permintaan = MCPermintaanmcuT::model()->findByAttributes(array('tindakanpelayanan_id' => $value->tindakanpelayanan_id));
                if(empty($Permintaan->tindakanpelayanan_id)){
                    $value->delete();
                }
            }
        }


        if (isset($_POST['MCPermintaanmcuT'])) {
            if (isset($_POST['MCPermintaanmcuT'][Params::RUANGAN_ID_LAB_KLINIK]) || isset($_POST['MCTindakanPelayananT'][Params::RUANGAN_ID_LAB_KLINIK])) {
                $modPasienMasukPenunjangs[Params::RUANGAN_ID_LAB_KLINIK] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, Params::RUANGAN_ID_LAB_KLINIK);
                $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjangs[Params::RUANGAN_ID_LAB_KLINIK]);
            }
            if (isset($_POST['MCPermintaanmcuT'][Params::RUANGAN_ID_LAB_ANATOMI]) || isset($_POST['MCTindakanPelayananT'][Params::RUANGAN_ID_LAB_ANATOMI])) {
                $modPasienMasukPenunjangs[Params::RUANGAN_ID_LAB_ANATOMI] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, Params::RUANGAN_ID_LAB_ANATOMI);
            }
            if (isset($_POST['MCPermintaanmcuT'][Params::RUANGAN_ID_RAD]) || isset($_POST['MCTindakanPelayananT'][Params::RUANGAN_ID_RAD])) {
                $modPasienMasukPenunjangs[Params::RUANGAN_ID_RAD] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, Params::RUANGAN_ID_RAD);
            }

            if (count((array)$_POST['MCPermintaanmcuT']) > 0) {
                foreach ($_POST['MCPermintaanmcuT'] AS $ruangan_id => $permintaan) {
//								RSSP-1536
//								$modKlinik = RuanganM::model()->findByPk($ruangan_id);
                    $modKlinik = RuanganM::model()->findByAttributes(array('ruangan_id' => $ruangan_id, 'ruangan_aktif' => true));
                    if (!empty($modKlinik)) {
                        if ($modKlinik->instalasi_id == Params::INSTALASI_ID_RJ && $ruangan_id != Yii::app()->user->getState('ruangan_id')) {
                            $modKonsulPoli[$ruangan_id] = $this->simpanKonsulPoli($model, $ruangan_id);
                        }
                    }
                }
            }

            foreach ($_POST['MCPermintaanmcuT'] as $i => $tindakanmcu) {

                foreach ($_POST['MCPermintaanmcuT'][$i] AS $iii => $tindakanPelayanan) {
                    $pasienPenunjang = (isset($modPasienMasukPenunjangs[$i]) ? $modPasienMasukPenunjangs[$i] : null);
                    $dataTindakans = array();

                    if (empty($tindakanPelayanan['tindakanpelayanan_id'])) {
                        $permintaan = PermintaanmcuT::model()->findByAttributes(array(
                            'pendaftaran_id'=>$model->pendaftaran_id,
                            'paketpelayanan_id'=>$tindakanPelayanan['paketpelayanan_id'],
                            'tipepaket_id'=>$tindakanPelayanan['tipepaket_id'],
                            'ruangantujuan_id'=>$tindakanPelayanan['ruangantujuan_id'],
                            'daftartindakan_id'=>$tindakanPelayanan['daftartindakan_id'],
                        ));

                        if (!empty($permintaan)) {

//                                    var_dump($permintaan->attributes);

                            continue;
                        }
                    }



                    $dataTindakans[$iii] = $this->simpanTindakanPelayanan($model, $pasienPenunjang, $tindakanPelayanan);
                    $dataPermintaans[$iii] = $this->simpanPermintaanMcu($model, $modPermintaanMcu, $tindakanPelayanan, $dataTindakans[$iii]);
                    if (isset($modPasienMasukPenunjangs[$i])) {
                        if ($i == Params::RUANGAN_ID_LAB_KLINIK || $i == Params::RUANGAN_ID_LAB) {
                            if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                                $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$iii], $tindakanPelayanan);
                            }
                        } else if ($i == Params::RUANGAN_ID_LAB_ANATOMI) {
                            $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjangs[$i], $dataTindakans[$i][$ii], $tindakanPelayanan);
                        } else if ($i == Params::RUANGAN_ID_RAD) {
                            $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjangs[$i], $dataTindakans[$iii], $tindakanPelayanan);
                        }
                    }
                }
            }
        }

        $tmp = array();
        $x = 0;
        if (isset($_POST['MCTindakanPelayananT'])) {
            if (count((array)$_POST['MCTindakanPelayananT']) > 0) {
                $this->permintaanmcutersimpan = true;
                foreach ($_POST['MCTindakanPelayananT'] as $i => $tindakan) {

                    if (isset($_POST['MCTindakanPelayananT'][$i])) {
                        if (count((array)$_POST['MCTindakanPelayananT'][$i]) > 0) {
                            foreach ($_POST['MCTindakanPelayananT'][$i] AS $iii => $tindakanPelayanan) {
                                $pasienPenunjang = (isset($modPasienMasukPenunjangs[$i]) ? $modPasienMasukPenunjangs[$i] : null);
                                $dataTindakans[$iii] = $this->simpanTindakanPelayanan($model, $pasienPenunjang, $tindakanPelayanan);
                                if (isset($modPasienMasukPenunjangs[$i])) {
                                    if ($tindakanPelayanan['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK) {
                                        if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                                            $this->simpanDetailHasilPemeriksaanLabNon($modHasilPemeriksaan, $dataTindakans[$iii], $tindakanPelayanan);
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
        /*Hapus Masuk penunjang yang sudah ada tindakan pelayanan*/
        /*
                $criteria=new CDbCriteria;
                $criteria->addCondition('pendaftaran_id = '.$model->pendaftaran_id);
                $modPenunjang = MCPasienmasukpenunjangT::model()->findAll($criteria);
                if(count((array)$modPenunjang)){
                    foreach ($modPenunjang as $key => $value) {
                        $Tindakan = MCTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $value->pasienmasukpenunjang_id));
                        if(empty($Tindakan->tindakanpelayanan_id)){
                            $value->delete();
                        }
                    }
                }
                 *
                 */


        if (!empty($modPasienMasukPenunjangs[Params::RUANGAN_ID_RAD])) {
          $this->tambahPasienHL7($modPasienMasukPenunjangs[Params::RUANGAN_ID_RAD], "Pemeriksaan dari Pasien MCU");
        }

        $this->karcistersimpan = true;
        $this->komponentindakantersimpan = true;
        $this->pasientersimpan = true;
        $this->pendaftarantersimpan = true;
        $this->komponentindakantersimpan = true;
        $this->permintaanmcutersimpan = true;

        if ($this->pasientersimpan && $this->pendaftarantersimpan && $this->karcistersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->permintaanmcutersimpan && $this->pasienpenunjangtersimpan && $this->konsulpolitersimpan) {
    // //($this->pasientersimpan .'<br>'. $this->pendaftarantersimpan .'<br>'.  $this->karcistersimpan .'<br>'.  $this->tindakanpelayanantersimpan .'<br>'.  $this->komponentindakantersimpan .'<br>'.  $this->asuransipasientersimpan .'<br>'.  $this->permintaanmcutersimpan .'<br>'.  $this->pasienpenunjangtersimpan .'<br>'.  $this->konsulpolitersimpan);
          
          $transaction->commit();
          $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
          if ($this->tindakanpelayanantersimpan == false) {
            Yii::app()->user->setFlash('error', "Data tindakan gagal disimpan !");
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    // //($model->getErrors());die;
    $this->render('update', array(
      'model' => $model,
      'modPasien' => $modPasien,
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
      'modPemeriksaanMcu' => $modPemeriksaanMcu,
      'modTindakanKarcis' => $modTindakanKarcis,
      'modPenanggungJawab' => $modPenanggungJawab,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = MCPendaftaranT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'pppendaftaran-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * proses simpan / ubah data pasien
   * @param type $modPasien
   * @param type $post
   * @return type
   */
  public function simpanPasien($modPasien, $post)
  {

    $format = new MyFormatter();
    if (isset($post['pasien_id']) && (!empty($post['pasien_id']))) {
      $load = new $modPasien;
      $modPasien = $load->findByPk($post['pasien_id']);
    }
    $modPasien->attributes = $post;

    $gelardepan = isset($post['gelardepan']) ? $post['gelardepan'] . ' ' : '';
    $gelarbelakang = isset($post['gelarbelakang']) ? ', ' . $post['gelarbelakang'] : '';
    $modPasien->nama_pasien = $gelardepan . $modPasien->nama_pasien . $gelarbelakang;

    $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
    $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    if (isset($post['tempPhoto'])) {
      $modPasien->photopasien = $post['tempPhoto'];
    }
    if (empty($modPasien->pasien_id)) {
      $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
      $modPasien->profilrs_id = Params::getDefaultProfilRS();
      $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
      $modPasien->ispasienluar = FALSE;
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPasien->create_loginpemakai_id = Yii::app()->user->id;
      $modPasien->create_time = date('Y-m-d H:i:s');
      $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
    } else {
      $modPasien->update_loginpemakai_id = Yii::app()->user->id;
      $modPasien->update_time = date('Y-m-d H:i:s');
    }
    $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
    $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;

    if ($modPasien->save()) {
      $this->pasientersimpan = true;
    }

    return $modPasien;
  }

  /**
   * proses simpan / ubah data pendaftaran
   * @return type
   */
  public function simpanPendaftaran($model, $modPasien, $modRujukan, $post, $postPasien, $modAsuransiPasien)
  {
    $format = new MyFormatter();
    $model = new MCPendaftaranT;
    $model->attributes = $post;
    $model->pasien_id = $modPasien->pasien_id;
    $model->rujukan_id = $modRujukan->rujukan_id;
    $model->instalasi_id = (isset($model->ruangan_id) ? $model->ruangan->instalasi_id : null);
    $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
    $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
    $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
    $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $model->statuspasien = (empty($postPasien['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
    $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
    $model->shift_id = Yii::app()->user->getState('shift_id');
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_time = date("Y-m-d H:i:s");
    if (Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)) {
      $model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
    } else {
      $model->tgl_pendaftaran = date("Y-m-d H:i:s");
    }
    $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
    $model->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
    $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
    $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
    $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
    $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
    $model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;

    $modRuangan = MCRuanganM::model()->findByPk($model->ruangan_id);
    $estimasipelayanan = isset($modRuangan->estimasipelayanan) ? $modRuangan->estimasipelayanan : 15;

    $tgl_awal = date('Y-m-d');
    $tgl_akhir = date('Y-m-d');
    $criteria = new CDbCriteria();
    $criteria->addCondition('ruangan_id = ' . $model->ruangan_id);
    $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_awal, $tgl_akhir);
    $criteria->order = 'tgl_pendaftaran DESC';
    $dataPendaftaran = MCPendaftaranT::model()->find($criteria);

    if (!empty($dataPendaftaran) && $dataPendaftaran->tglakandilayani != null) {
      $tanggal = strtotime($dataPendaftaran->tglakandilayani . ' + ' . $estimasipelayanan . ' minute');
      $tglakandilayani = date('Y-m-d H:i:s', $tanggal);

      if ($tglakandilayani < $model->tgl_pendaftaran) {
        $tglakandilayani = strtotime($tglakandilayani . ' + ' . $estimasipelayanan . ' minute');
        $tglakandilayani = date('Y-m-d H:i:s', $tglakandilayani);
        $model->tglakandilayani = $tglakandilayani;
      } else {
        $tglakandilayani = strtotime($model->tgl_pendaftaran . ' + ' . $estimasipelayanan . ' minute');
        $tglakandilayani = date('Y-m-d H:i:s', $tglakandilayani);
        $model->tglakandilayani = $tglakandilayani;
      }
    } else {
      $tanggal = strtotime($model->tgl_pendaftaran . ' + ' . $estimasipelayanan . ' minute');
      $tglakandilayani = date('Y-m-d H:i:s', $tanggal);
      $model->tglakandilayani = $tglakandilayani;
    }

    $model->tglrenkontrol = $format->formatDateTimeForDb($_POST['PermintaanmcuT']['tglrencanaperiksa']);
    //$model->tglrenkontrol = strtotime($model->tglrenkontrol . ' + 1 years');
    $model->tglrenkontrol = strtotime($model->tglrenkontrol);
    $model->tglrenkontrol = date('Y-m-d H:i:s', $model->tglrenkontrol);
    if ($model->save()) {
      if (!empty($model->antrian_id)) {
        MCAntrianT::model()->updateByPk($model->antrian_id, array('pendaftaran_id' => $model->pendaftaran_id));
      }
      $this->pendaftarantersimpan = true;
    } else {
      $this->pendaftarantersimpan = false;
    }
    return $model;
  }

  /**
   * proses simpan / ubah data permintaan mcu
   * @return type
   */
  public function simpanPermintaanMcu($model, $modPermintaanMcu, $post, $postTindakan)
  {
    $format = new MyFormatter();
    $modPermintaanMcu = new MCPermintaanmcuT;
    $modPermintaanMcu->attributes = $post;
    $modPermintaanMcu->tindakanpelayanan_id = $postTindakan->tindakanpelayanan_id;
    $modPermintaanMcu->pendaftaran_id = $model->pendaftaran_id;
    $modPermintaanMcu->daftartindakan_id = $post['daftartindakan_id'];
    $modPermintaanMcu->tipepaket_id = $post['tipepaket_id'];
    $modPermintaanMcu->paketpelayanan_id = $post['paketpelayanan_id'];
    $modPermintaanMcu->tglpermintaan = date('Y-m-d H:i:s');
    $modPermintaanMcu->tglrencanaperiksa = isset($_POST['PermintaanmcuT']['tglrencanaperiksa']) ? $format->formatDateTimeForDb($_POST['PermintaanmcuT']['tglrencanaperiksa']) : date('Y-m-d H:i:s');
    $modPermintaanMcu->noantrianperm = MyGenerator::noAntrian($model->ruangan_id);
    $modPermintaanMcu->pernahmcu = isset($_POST['PermintaanmcuT']['pernahmcu']) ? $_POST['PermintaanmcuT']['pernahmcu'] : false;
    $modPermintaanMcu->keteranganpermintaan = isset($_POST['PermintaanmcuT']['keteranganpermintaan']) ? $_POST['PermintaanmcuT']['keteranganpermintaan'] : "";
    $modPermintaanMcu->ruangantujuan_id = $post['ruangantujuan_id'];
    $modPermintaanMcu->tarifperpaketmcu = MyFormatter::formatNumberForDb($post['tarif_satuan']);
    $modPermintaanMcu->create_time = date('Y-m-d H:i:s');
    $modPermintaanMcu->update_time = date('Y-m-d H:i:s');
    $modPermintaanMcu->create_loginpemakai_id = Yii::app()->user->id;
    $modPermintaanMcu->update_loginpemakai_id = Yii::app()->user->id;
    $modPermintaanMcu->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modPermintaanMcu->save()) {
      $this->permintaanmcutersimpan = true;
    } else {

      // //($modPermintaanMcu->getErrors());die;
      $this->permintaanmcutersimpan = false;
    }
    return $modPermintaanMcu;
  }

  /**
   * proses simpan data penanggungjawab pasien
   * @param type $modPenanggungjawab
   * @param type $post
   * @return type
   */
  public function simpanPenanggungjawab($modPenanggungjawab, $post)
  {
    $format = new MyFormatter;
    $modPenanggungjawab->attributes = $post;
    $modPenanggungjawab->tgllahir_pj = $format->formatDateTimeForDb($modPenanggungjawab->tgllahir_pj);

    if ($modPenanggungjawab->save()) {
      $this->penanggungjawabtersimpan = true;
    }
    return $modPenanggungjawab;
  }

  /**
   * proses simpan data rujukan
   * @param type $modRujukan
   * @param type $post
   * @return type
   */
  public function simpanRujukan($modRujukan, $post)
  {
    $format = new MyFormatter();
    $modRujukan->attributes = $post;
    $modRujukan->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan']) > 0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
    $modRujukan->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan']) > 0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
    $modRujukan->tanggal_rujukan = $format->formatDateTimeForDb($modRujukan->tanggal_rujukan);

    if ($modRujukan->save()) {
      $this->rujukantersimpan = true;
    }
    return $modRujukan;
  }

  /**
   * proses simpan data rujukan
   * @param type $modRujukan
   * @param type $post
   * @return type
   */
  public function simpanRujukanBpjs($modRujukanBpjs, $post)
  {
    $format = new MyFormatter();
    $modRujukanBpjs->attributes = $post;
    $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan']) > 0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
    $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan']) > 0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
    $modRujukanBpjs->tanggal_rujukan = $format->formatDateTimeForDb($modRujukanBpjs->tanggal_rujukan);

    if ($modRujukanBpjs->save()) {
      $this->rujukantersimpan = true;
    }
    return $modRujukanBpjs;
  }

  /**
   * proses simpan karcis
   * @param type $modTindakan
   * @param type $post
   * @return type
   */
  public function simpanKarcis($modTindakan, $model, $post)
  {
    $modTindakan->attributes = $post;
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->instalasi_id = Params::INSTALASI_ID_MCU;
    $modTindakan->ruangan_id = Params::RUANGAN_ID_KLINIK_MCU;
    $modTindakan->pendaftaran_id = $model->pendaftaran_id;
    $modTindakan->kelaspelayanan_id = $model->kelaspelayanan_id;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->carabayar_id = $model->carabayar_id;
    $modTindakan->penjamin_id = $model->penjamin_id;
    $modTindakan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
    $modTindakan->pasien_id = $model->pasien_id;
    $modTindakan->dokterpemeriksa1_id = $model->pegawai_id;
    $modTindakan->karcis_id = $post['karcis_id'];
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    $modTindakan->qty_tindakan = 1;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7250
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
    $modTindakan->cyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;
    $modTindakan->tarif_rsakomodasi = 0;
    $modTindakan->tarif_medis = 0;
    $modTindakan->tarif_paramedis = 0;
    $modTindakan->tarif_bhp = 0;

    if (!empty($modTindakan->karcis_id)) {
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($model, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
    }

    if ($modTindakan->save()) {
      $this->komponentindakantersimpan &= true;
      $this->karcistersimpan = true;
    } else {
      $this->karcistersimpan = false;
    }

    return $modTindakan;
  }

  /**
   * simpan asuransi pasien
   * @param type $modAsuransiPasien
   * @param type $postPendaftaran
   * @param type $postPasien
   * @param type $postAsuransiPasien
   * @return type
   */
  public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien)
  {
    $format = new MyFormatter();
    $modAsuransiPasien->attributes = $postAsuransiPasien;
    $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
    $modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id']) ? $postPendaftaran['penjamin_id'] : null;
    $modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
    $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
    $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
    if ($modAsuransiPasien->save()) {
      $this->asuransipasientersimpan = true;
    }
    return $modAsuransiPasien;
  }

  public function simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $postSep)
  {
    $reqSep = null;
    $modSep = new MCSepT;
    $bpjs = new Bpjs();

    $modSep->tglsep = date('Y-m-d H:i:s');
    $modSep->nokartuasuransi = $modAsuransiPasienBpjs->nopeserta;
    $modSep->tglrujukan = $modRujukanBpjs->tanggal_rujukan;
    $modSep->norujukan = $modRujukanBpjs->no_rujukan;
    $modSep->ppkrujukan = $postSep['ppkrujukan'];
    $modSep->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
    $modSep->jnspelayanan = ($model->instalasi_id == Params::INSTALASI_ID_RI) ? Params::JENISPELAYANAN_RI : Params::JENISPELAYANAN_RJ;
    $modSep->catatansep = $postSep['catatansep'];
    $data_diagnosa = explode(', ', $modRujukanBpjs->diagnosa_rujukan);
    $modSep->diagnosaawal = isset($data_diagnosa[0]) ? $data_diagnosa[0] : '';
    $modSep->politujuan = $model->ruangan_id;
    $modSep->klsrawat = $modAsuransiPasienBpjs->kelastanggunganasuransi_id;
    $modSep->tglpulang = date('Y-m-d H:i:s');
    $modSep->create_time = date('Y-m-d H:i:s');
    $modSep->create_loginpemakai_id = Yii::app()->user->id;
    $modSep->create_ruangan = Yii::app()->user->getState('ruangan_id');

    $reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $model->pendaftaran_id), true);

    if ($reqSep['metadata']['code'] == 200) {
      $modSep->nosep = $reqSep['response'];
      if ($modSep->save()) {
        $this->septersimpan = true;
      }
    }

    return $modSep;
  }

  /**
   * menentukan tipepaket_id
   * @param type $modPendaftaran
   * @param type $karcis_id
   * @param type $idTindakan
   * @return type
   */
  public function tipePaketKarcis($modPendaftaran, $karcis_id, $tindakan_id)
  {
    $criteria = new CDbCriteria;
    $criteria->with = array('tipepaket');
    $criteria->addCondition("daftartindakan_id = " . $tindakan_id);
    $criteria->addCondition("tipepaket.carabayar_id = " . $modPendaftaran->carabayar_id);
    $criteria->addCondition("tipepaket.penjamin_id = " . $modPendaftaran->penjamin_id);
    $criteria->addCondition("tipepaket.kelaspelayanan_id = " . $modPendaftaran->kelaspelayanan_id);
    $paket = PaketpelayananM::model()->find($criteria);
    $result = Params::TIPEPAKET_ID_NONPAKET;
    if (isset($paket))
      $result = $paket->tipepaket_id;

    return $result;
  }

  
    /**
     * Set Tanggal, Wilayah, dan Jenis Kelamin berdasarkan No KTP
     */
    public function actionInputDariNoKTP() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $no_ktp = $_POST['no_ktp'];
        $str_lens = strlen($no_ktp);

        $res = array(
            'propinsi_id'=>null,
            'kabupaten_id'=>null,
            'kecamatan_id'=>null,
            'tanggal_lahir'=>null,
            'tanggal_lahir_format'=>null,
            'jeniskelamin'=>'',
        );

        if ($str_lens >= 2) {
            $prop = PropinsiM::model()->findByAttributes(array(
                'kode_propinsi'=>substr($no_ktp, 0, 2),
            ));

            if (!empty($prop)) {
                $res['propinsi_id'] = $prop->propinsi_id;

                if ($str_lens >= 4) {
                    $kab = KabupatenM::model()->findByAttributes(array(
                        'propinsi_id'=>$prop->propinsi_id,
                        'kode_kabupaten'=>substr($no_ktp, 2, 2),
                    ));

                    if (!empty($kab)) {
                        $res['kabupaten_id'] = $kab->kabupaten_id;

                        if ($str_lens >= 6) {
                            $kec = KecamatanM::model()->findByAttributes(array(
                                'kabupaten_id'=>$kab->kabupaten_id,
                                'kode_kecamatan'=>substr($no_ktp, 4, 2),
                            ));

                            if (!empty($kec)) {
                                $res['kecamatan_id'] = $kec->kecamatan_id;
                            }
                        }
                    }
                }
            }
        }

        if ($str_lens >= 12) {
            $str_tgl = substr($no_ktp, 6, 6);

            $tgl = substr($str_tgl, 0, 2);
            $bln = substr($str_tgl, 2, 2);
            $thn = substr($str_tgl, 4, 2);

            $thn_min = "19".$thn;
            $thn_max = "20".$thn;
            $thn_real = $thn_max;

            if (($thn_real) > (date('Y') - 16)) {
                $thn_real = $thn_min;
            }
            
            $bln = ((int)$bln > 12) ? "01" : $bln;
                
            $hari_limit = date('t', strtotime($thn_real."-".$bln."-01"));
            $tgl = ($tgl > $hari_limit) ? "01" : $tgl;


            $res['tanggal_lahir'] = $thn_real."-".$bln."-".$tgl;
            $res['tanggal_lahir_format'] = $tgl."/".$bln."/".$thn_real;

            // jenis kelamin
            $res_jk = (int)$tgl - 40;

            if ($res_jk < 0) {
                $res['jeniskelamin'] = 'LAKI-LAKI';
            } else {
                $res['jeniskelamin'] = 'PEREMPUAN';
            }


        }

        echo CJSON::encode($res);
    }
  
  /**
   * untuk menampilkan pasien lama dari autocomplete
   * 1. no_rekam_medik
   * 2. no_identitas_pasien
   * 3. nama_pasien
   * 4. nama_bin (alias)
   */
  public function actionAutocompletePasienLama()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $tanggal_lahir = isset($_GET['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['tanggal_lahir']) : null;
      $no_asuransi_pasien = isset($_GET['no_asuransi_pasien']) ? $_GET['no_asuransi_pasien'] : null;

      if (!empty($no_asuransi_pasien)) {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*, asuransipasien_m.*';
        $criteria->addCondition("asuransipasien_m.nokartuasuransi ILIKE '%" . $no_asuransi_pasien . "%'");
        $criteria->addCondition('ispasienluar = FALSE');
        $criteria->join = 'JOIN asuransipasien_m on asuransipasien_m.pasien_id = t.pasien_id';
        $criteria->limit = 5;
        $models = PasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          // $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . (!empty($model->nama_ayah) ? $model->nama_ayah : "(nama ayah tidak ada)") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->no_identitas_pasien . " - "  . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      } else {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
        $criteria->compare('tanggal_lahir', $tanggal_lahir);
        $criteria->addCondition('ispasienluar = FALSE');
        $criteria->limit = 5;
        $models = PasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          // $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . (!empty($model->nama_ayah) ? $model->nama_ayah : "(nama ayah tidak ada)") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->no_identitas_pasien . " - "  . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  public function actionAutocompleteAsuransi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
      $criteria->addCondition('penjamin_id=' . $penjamin_id);
      $criteria->addCondition('asuransipasien_aktif is true');
      if ($_GET['pasien_id'] == "") {
        $criteria->addCondition('pasien_id is null');
      } else {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      $criteria->limit = 5;
      $models = MCAsuransipasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nopeserta;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        $returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
      }
      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  public function actionAutocompleteAsuransiKartu()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nokartuasuransi = isset($_GET['nokartuasuransi']) ? $_GET['nokartuasuransi'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nokartuasuransi)', strtolower($nokartuasuransi), true);
      $criteria->addCondition('penjamin_id=' . $penjamin_id);
      if ($_GET['pasien_id'] == "") {
        $criteria->addCondition('pasien_id is null');
      } else {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      $criteria->limit = 5;
      $models = MCAsuransipasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nokartuasuransi . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nokartuasuransi;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        $returnVal[$i]['nopeserta'] = $model->nopeserta;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
      }
      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * menampilkan data asuransi terakhir pasien
   * @throws CHttpException
   */
  public function actionSetAsuransiPasienLama()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $criteria = new CDbCriteria();
      $criteria->addCondition("pasien_id = " . $_POST['pasien_id']);
      $criteria->order = 'asuransipasien_id DESC';
      $model = AsuransipasienM::model()->find($criteria);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $data["$attribute"] = $model->$attribute;
      }
      $data["penjamin_nama"] = $model->penjamin->penjamin_nama;
      $data['listPenjamin'] = "";
      $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
      if (count((array)$penjamin) > 1) {
        $data['listPenjamin'] .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }
      $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
      foreach ($penjamin as $value => $name) {
        $data['listPenjamin'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      echo CJSON::encode($data);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Mengurai data pasien berdasarkan pasien_id
   * @throws CHttpException
   */
  public function actionGetDataPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pasien_id)) {
        $criteria->addCondition("pasien_id = " . $pasien_id);
      }
      if (!empty($no_rekam_medik)) {
        $criteria->addCondition("no_rekam_medik = '" . $no_rekam_medik . "'");
      }
      $criteria->addCondition('ispasienluar = FALSE');
      $model = PasienM::model()->find($criteria);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      if ($returnVal['no_mobile_pasien'] == "-" || empty($returnVal['no_mobile_pasien'])) { //RSST-1857
        $returnVal['no_mobile_pasien'] = Params::DEFAULT_NO_MOBILE_PASIEN; //default no mobile pasien
      }
      $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));
      if (!empty($model->pegawai_id)) {
        $returnVal['nomorindukpegawai'] = $model->pegawai->nomorindukpegawai;
        $returnVal['nama_pegawai'] = $model->pegawai->nama_pegawai;
        $returnVal['gelardepan'] = $model->pegawai->gelardepan;
        $returnVal['unit_perusahaan'] = $model->pegawai->unit_perusahaan;
        $returnVal['gelarbelakang_nama'] = isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "";
        $returnVal['jabatan_nama'] = isset($model->pegawai->jabatan->jabatan_nama) ? $model->pegawai->jabatan->jabatan_nama : "";
        $returnVal["nomorindukpegawai"] = $model->pegawai->nomorindukpegawai;
      }
      $returnVal["fingerprint_data"] = null;
      
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new MCPasienM;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
        $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
      }
      if ($encode) {
        echo CJSON::encode($kabupaten);
      } else {
        if (empty($kabupaten)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kabupaten as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown kecamatan
   * @param type $encode jika = true maka return array jika false maka set Dropdown
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new MCPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
        $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kecamatan);
      } else {
        if (empty($kecamatan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kecamatan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown kelurahan
   * @param type $encode jika = true maka return array jika false maka set Dropdown
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new MCPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }
      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
        $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kelurahan);
      } else {
        if (empty($kelurahan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kelurahan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

        /**
         * set dropdown daerah pasien berdasarkan
         * propinsi_id
         * kabupaten_id
         * kecamatan_id
         * kelurahan_id
         * pasien_id
         */
        public function actionSetDropdownDaerahPasien()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $modPasien = new PPPasienM;
                $propinsi_id = $_POST['propinsi_id'];
                $kabupaten_id = $_POST['kabupaten_id'];
                $kecamatan_id = $_POST['kecamatan_id'];
                $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

                $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
                $propinsis = CHtml::listData($propinsis,'propinsi_id','propinsi_nama');
                $propinsiOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($propinsis as $value=>$name)
                {
                    if($value==$propinsi_id)
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                
                if (empty($propinsi_id)) {
                    $kabupatens = array();
                } else {
                    $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
    //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
                    $kabupatens = CHtml::listData($kabupatens,'kabupaten_id','kabupaten_nama');
                    
                }
                
                $kabupatenOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kabupatens as $value=>$name)
                {
                    if($value==$kabupaten_id)
                        $kabupatenOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kabupatenOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                
                
                if (empty($kabupaten_id)) {
                    $kecamatans = array();
                } else {
                    $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
    //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
                    $kecamatans = CHtml::listData($kecamatans,'kecamatan_id','kecamatan_nama');
                    
                }
                $kecamatanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kecamatans as $value=>$name)
                {
                    if($value==$kecamatan_id)
                        $kecamatanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kecamatanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                
                if (empty($kecamatan_id)) {
                    $kelurahans = array();
                } else {
                    $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
                    $kelurahans = CHtml::listData($kelurahans,'kelurahan_id','kelurahan_nama');
                }
                
                $kelurahanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kelurahans as $value=>$name)
                {
                    if($value==$kelurahan_id)
                        $kelurahanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kelurahanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }

                $dataList['listPropinsi'] = $propinsiOption;
                $dataList['listKabupaten'] = $kabupatenOption;
                $dataList['listKecamatan'] = $kecamatanOption;
                $dataList['listKelurahan'] = $kelurahanOption;

                echo json_encode($dataList);
                Yii::app()->end();
            }
        }

  /**
   * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
   */
  public function actionSetTanggalLahir()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['tanggal_lahir'] = date("d/m/Y", strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));
    }
    echo json_encode($data);
    Yii::app()->end();
  }

  /**
   * menampilkan karcis
   */
  public function actionSetKarcis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $modTindakan = new MCTindakanPelayananKarcisT;
      $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
      $ruangan_id = $_POST['ruangan_id'];
      $pasien_id = $_POST['pasien_id'];
      $penjamin_id = $_POST['penjamin_id'];
      $form = '';
      if (!empty($ruangan_id)) {
        $is_pasienbaru = 'true';
        if (!empty($pasien_id)) {
          $modPasien = PasienM::model()->findByPk($pasien_id);
          if (isset($modPasien)) {
            $is_pasienbaru = ($modPasien->statusrekammedis == Params::STATUSREKAMMEDIS_AKTIF) ? 'false' : 'true';
          }
        }
        $criteria = new CdbCriteria();
        $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
        $criteria->addCondition("penjamin_id = " . $penjamin_id);
        if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
          $criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
        }
        $modKarcisV = KarcisV::model()->findAll($criteria);
        if (count((array)$modKarcisV) > 0) {
          $form = "<table width='100%'>";
          $form .= "<thead>";
          $form .= "<th>Karcis</th>";
          $form .= "<th>Harga</th>";
          $form .= "<th>Pilih</th>";
          $form .= "</thead>";
          foreach ($modKarcisV as $i => $karcis) {
            $modTindakan->attributes = $karcis->attributes;
            if ($i == 0) {
              $modTindakan->is_pilihtindakan = 1;
              $modTindakan->karcis_id = $karcis->karcis_id;
              $modTindakan->jenistarif_id = $karcis->jenistarif_id;
              $modTindakan->tarif_satuan = $format->formatNumberForUser($karcis->harga_tariftindakan);
              $form .= '<tr class="checked">
								<td>' . CHtml::label($karcis['karcis_nama'], $karcis['karcis_nama']) . '</td>
								<td style="text-align:right;">' . CHtml::activeTextField($modTindakan, '[' . $i . ']tarif_satuan', array('readonly' => true, 'class' => 'span1 integer', 'style' => 'width:96px;text-align:right;')) . '</td>
								<td><a data-karcis="' . $karcis['karcis_id'] . '"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="pilihKarcis(this);return false;">
									<i class="icon-form-check"></i>
									</a>'
                . CHtml::activeHiddenField($modTindakan, '[' . $i . ']is_pilihtindakan', array('readonly' => true, 'class' => 'span1'))
                . CHtml::activeHiddenField($modTindakan, '[' . $i . ']daftartindakan_id', array('readonly' => true, 'class' => 'span1'))
                . CHtml::activeHiddenField($modTindakan, '[' . $i . ']karcis_id', array('readonly' => true, 'class' => 'span1'))
                . CHtml::activeHiddenField($modTindakan, '[' . $i . ']jenistarif_id', array('readonly' => true, 'class' => 'span1'))
                . '</td>'
                . '</tr>';
            }
          }
          $form .= "</table>";
        }
      }
      $data['listKarcis'] = $form;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * set tabel riwayat kunjungan pasien
   */
  public function actionSetRiwayatKunjunganPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['table'] = "";
      $modPasien = new MCPasienM;
      $modPasien->pasien_id = $_POST['pasien_id'];
      $data['table'] = $this->renderPartial($this->path_view_mcu . '_tableRiwayatPasien', array(
        'modPasien' => $modPasien,
      ), true);
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * set umur dari tanggal lahir (date)
   */
  public function actionSetUmur()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['umur'] = null;
      if (isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])) {
        $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown dokter
   */
  public function actionSetDropdownDokter()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new MCPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getDokterItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listDokter'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown jenis kasus penyakit
   */
  public function actionSetDropdownJeniskasuspenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new MCPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listKasuspenyakit'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /*
     * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
     * and open the template in the editor.
     */

  public function actionSetDropdownKelasPelayanan($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST["$namaModel"]['ruangan_id'];
      $kelasPelayanan = null;
      if ($ruangan_id) {
        $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=' . $ruangan_id . ' and kelaspelayanan_aktif = true');
        $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
      }
      if (empty($kelasPelayanan)) {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        foreach ($kelasPelayanan as $value => $name) {
          echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * set antrian ruangan
   */
  public function actionSetAntrianRuangan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $data = array();
      $data['maxantrianruangan'] = null;
      $data['no_urutantri'] = '001';
      if (!empty($ruangan_id)) {
        $data['no_urutantri'] = MyGenerator::noAntrian($ruangan_id);
        $criteria = new CDbCriteria;
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
        $modJadwalBukaPoli = JadwalbukapoliM::model()->findAll($criteria);
        if (count((array)$modJadwalBukaPoli) > 0) {
          foreach ($modJadwalBukaPoli as $key => $antrian) {
            $data['maxantrianruangan'] = $antrian->maxantiranpoli;
          }
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * set antrian dokter
   */
  public function actionSetAntrianDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $pegawai_id = $_POST['pegawai_id'];
      $data = array();
      $data['maxantriandokter'] = 0;
      if (!empty($ruangan_id) && !empty($pegawai_id)) {
        $criteria = new CDbCriteria;
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
        $criteria->addCondition("pegawai_id = " . $pegawai_id);
        $modJadwalDokter = JadwaldokterM::model()->findAll($criteria);
        if (count((array)$modJadwalDokter) > 0) {
          foreach ($modJadwalDokter as $key => $antrian) {
            $data['maxantriandokter'] = $antrian->maximumantrian;
          }
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk penghitung jumlah pasien berdasarkan dokter dpjp
   */
  public function actionCountDokterDPJP()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $tgl_awal = date('Y-m-d');
      $tgl_akhir = date('Y-m-d');
      if (isset($pegawai_id)) {
        $criteria = new CDbCriteria;
        $criteria->select = 'pendaftaran_id';
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_awal, $tgl_akhir);
        $criteria->addCondition("pegawai_id = " . $pegawai_id);
        $criteria->addCondition("instalasi_id = 111");
        $modPendaftaran = PendaftaranT::model()->findAll($criteria);
        $data['jumlah'] = count((array)$modPendaftaran);
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintStatus($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPenanggungjawab = array();
    if (!empty($modPendaftaran->penanggungjawab_id)) {
      $modPenanggungjawab = PenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    }
    $karcis_id = null;
    $modTindakan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
    $judul_print = 'Kunjungan Rawat Jalan';
    $this->render($this->path_view_mcu . 'printStatus', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPenanggungjawab' => $modPenanggungjawab,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakan' => $modTindakan,
    ));
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintKarcis($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);

    $karcis_id = null;
    $modTindakan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
    $judul_print = 'Karcis ' . $modPendaftaran->ruangan->instalasi->instalasi_nama;
    $this->render($this->path_view_mcu . 'printKarcis', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakan' => $modTindakan,
      'modPegawai' => $modPegawai,
    ));
  }

  /**
   * print kartu pasien
   * @param type $pasien_id
   */
  public function actionPrintKartuPasien($pasien_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul_print = 'Kartu Pasien';
    $this->render(
      $this->path_view_mcu . 'printKartuPasien',
      array(
        'modPasien' => $modPasien,
        'judul_print' => $judul_print
      )
    );
  }

  /**
   * @param type $sep_id
   */
  public function actionPrintSep($sep_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modRujukanBpjs = new MCRujukanbpjsT;
    $modSep = MCSepT::model()->findByPk($sep_id);
    $modAsuransiPasienBpjs = MCAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $modSep->nokartuasuransi));
    $modJenisPeserta = MCJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
    if (isset($modSep->norujukan)) {
      $modRujukanBpjs = MCRujukanbpjsT::model()->findByAttributes(array('no_rujukan' => $modSep->norujukan));
    }
    $modPendaftaran = MCPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $judul_print = 'SURAT ELIGIBILITAS PESERTA';
    $this->render($this->path_view_mcu . 'printSep', array(
      'format' => $format,
      'modSep' => $modSep,
      'judul_print' => $judul_print,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modRujukanBpjs' => $modRujukanBpjs,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modJenisPeserta' => $modJenisPeserta,
    ));
  }

  /**
   * action ketika tombol panggil di klik
   */
  public function actionPanggil($antrian_id, $ket = null)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $modAntrian = MCAntrianT::model()->findByPk($antrian_id);
      if (isset($modAntrian)) {
        if ($modAntrian->panggil_flaq == true) {
          if ($ket == "batal") {
            $modAntrian->panggil_flaq = false;
            if ($modAntrian->update()) {
              //                            $data['pesan'] = "Pemanggilan no. antrian ".$modAntrian->noantrian." dibatalkan !";
            }
          } else {
            $data['pesan'] = "No. antrian " . $modAntrian->noantrian . " sudah dipanggil sebelumnya !";
          }
        } else {
          $modAntrian->panggil_flaq = true;
          if ($modAntrian->update()) {
            //                        $data['pesan'] = "No. antrian ".$modAntrian->noantrian." dipanggil !";
          }
        }
      }
      $attributes = $modAntrian->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $modAntrian->$attribute;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * menampilkan form antrian dari request ajax
   * @param type $record
   * @param type $noantrian
   * @throws CHttpException
   */
  public function actionSetFormAntrian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $record = (isset($_POST['record']) ? $_POST['record'] : "");
      $noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
      $loket_id = (isset($_POST['loket_id']) ? $_POST['loket_id'] : null);
      if (empty($noantrian)) { //antrian baru
        $criteria = new CDbCriteria();
        $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
        $criteria->addCondition("pendaftaran_id IS NULL");
        if ($record == "reset") {
          $criteria->addCondition("panggil_flaq = false");
        }
        if (!empty($loket_id)) {
          $criteria->addCondition("loket_id = " . $loket_id);
        }
        $criteria->order = "noantrian ASC";
        $criteria->limit = 1;
        $modAntrian = MCAntrianT::model()->find($criteria);
      } else {
        $criteria = new CDbCriteria();
        $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
        $criteria->compare("noantrian", trim($noantrian));
        if (!empty($loket_id)) {
          $criteria->addCondition("loket_id = " . $loket_id);
        }
        $cari = MCAntrianT::model()->find($criteria);
        if ($record == 'next') {
          $cari->loket_id = $loket_id;
          $modAntrian = $cari->AntrianBerikut;
        } else if ($record == 'prev') {
          $cari->loket_id = $loket_id;
          $modAntrian = $cari->AntrianSebelum;
        } else {
          $modAntrian = $cari;
        }
      }

      if (!isset($modAntrian)) {
        $modAntrian = new MCAntrianT;
        $data['pesan'] = "Antrian Habis !";
      }
      $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
      $data['form_antrian'] = $this->renderPartial($this->path_view_mcu . '_formPanggilAntrian', array('modAntrian' => $modAntrian), true);
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * untuk menampilkan data diagnosa dari autocomplete
   * 1. diagnosa_kode
   * 2. diagnosa_nama
   */
  public function actionAutocompleteDiagnosaRujukan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $diagnosa_nama = isset($_GET['diagnosa_rujukan']) ? $_GET['diagnosa_rujukan'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(diagnosa_nama)', strtolower($diagnosa_nama), true);
      $criteria->limit = 5;
      $models = DiagnosaM::model()->findAll($criteria);
      $data = array();
      foreach ($models as $i => $model) {
        $data[$i] = array(
          'key' => $model->diagnosa_kode,
          'value' => $model->diagnosa_nama
        );
      }
      echo CJSON::encode($data);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * set bpjs Interface
   */
  public function actionBpjsInterface()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (empty($_GET['param']) or $_GET['param'] === '') {
        die('param can\'not empty value');
      } else {
        $param = $_GET['param'];
      }

      //                if(empty( $_GET['server'] ) OR $_GET['server'] === ''){
      //
      //                }else{
      //                    $server = 'http://'.$_GET['server'];
      //                }

      $bpjs = new Bpjs();

      switch ($param) {
        case '1':
          $query = $_GET['query'];
          print_r($bpjs->search_kartu($query));
          break;
        case '2':
          $query = $_GET['query'];
          print_r($bpjs->search_nik($query));
          break;
        case '3':
          $query = $_GET['query'];
          print_r($bpjs->search_rujukan_no_rujukan($query));
          break;
        case '4':
          $query = $_GET['query'];
          print_r($bpjs->search_rujukan_no_bpjs($query));
          break;
        case '5':
          $query = $_GET['query'];
          $start = $_GET['start'];
          $limit = $_GET['limit'];
          print_r($bpjs->list_rujukan_tanggal($query, $start, $limit));
          break;
        case '6':
          $nokartu = $_GET['no_kartu'];
          $tglsep = $_GET['tgl_sep'];
          $tglrujukan = $_GET['tgl_rujukan'];
          $norujukan = $_GET['no_rujukan'];
          $ppkrujukan = $_GET['ppk_rujukan'];
          $ppkpelayanan = $_GET['ppk_pelayanan'];
          $jnspelayanan = $_GET['jns_pelayanan'];
          $catatan = $_GET['catatan'];
          $diagawal = $_GET['diag_awal'];
          $politujuan = $_GET['poli_tujuan'];
          $klsrawat = $_GET['kls_rawat'];
          $user = $_GET['user'];
          $nomr = $_GET['no_mr'];
          $notrans = $_GET['no_trans'];
          print_r($bpjs->create_sep($nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $notrans));
          break;
        case '7':
          $nosep = $_GET['nosep'];
          $tglpulang = $_GET['tglpulang'];
          $ppkpelayanan = $_GET['ppkpelayanan'];
          print_r($bpjs->update_tanggal_pulang_sep($nosep, $tglpulang, $ppkpelayanan));
          break;
        case '8':
          $nosep = $_GET['nosep'];
          $notrans = $_GET['notrans'];
          $ppkpelayanan = $_GET['ppkpelayanan'];
          print_r($bpjs->mapping_trans($nosep, $notrans, $ppkpelayanan));
          break;
        case '9':
          $nosep = $_GET['nosep'];
          $ppkpelayanan = $_GET['ppkpelayanan'];
          print_r($bpjs->delete_transaksi($nosep, $ppkpelayanan));
          break;
        case '10':
          $nokartu = $_GET['nokartu'];
          print_r($bpjs->riwayat_terakhir($nokartu));
          break;
        case '11':
          $nosep = $_GET['nosep'];
          print_r($bpjs->detail_sep($nosep));
          break;
        case '12':
          $ppkpelayanan = $_GET['ppkrujukan'];
          $start = $_GET['start'];
          $limit = $_GET['limit'];
          print_r($bpjs->detail_ppk_rujukan($ppkpelayanan, $start, $limit));
          break;
        case '99':
          $bpjs->identity_magic();
          break;
        case '100':
          print_r($bpjs->help());
          break;
        default:
          die('error number, please check your parameter option');
          break;
      }
      Yii::app()->end();
    }
  }

  public function actionGetRujukanDari($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];

      if ($encode) {
        echo CJSON::encode($rujukandari);
      } else {
        if (empty($asalrujukan_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id' => $asalrujukan_id), array('order' => 'namaperujuk'));
          $rujukandari = CHtml::listData($rujukandari, 'rujukandari_id', 'namaperujuk');
          foreach ($rujukandari as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
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
        // var_dump($_POST);
        $format = new MyFormatter();
        $model = new MCPendaftaranT();
        $modPasien = new MCPasienM;
        $modPenanggungJawab = null;
        $modRujukan = null;
        $modTindakan = null;

        $model->attributes = $_POST['MCPendaftaranT'];
        $modPasien->attributes = $_POST['MCPasienM'];

        if ($_POST['MCPendaftaranT']['is_adakarcis']) {
          if (isset($_POST['MCKarcisV'])) {
            if (count((array)$_POST['MCKarcisV']) > 0) {
              foreach ($_POST['MCKarcisV'] as $i => $karcis) {
                if ($karcis['is_pilihtindakan']) {
                  $modTindakan = new MCTindakanPelayananT;
                  $modTindakan->attributes = $karcis;
                  $modTindakan->karcis_id = $karcis['karcis_id'];
                }
              }
            }
          }
        }
      }
      echo CJSON::encode(array(
        'content' => $this->renderPartial($this->path_view_mcu . 'verifikasi', array(
          'model' => $model,
          'modPasien' => $modPasien,
          'modPenanggungJawab' => $modPenanggungJawab,
          'modTindakan' => $modTindakan,
          'format' => $format,
        ), true)
      ));
      Yii::app()->end();
    }
  }

  /**
   * Function untuk pemeriksaan MCU (set checklist tindakan mcu)
   */
  public function actionSetChecklistTindakanMcu()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $kelaspelayanan_id = isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null;
      $postPemeriksaan = $post['MCPaketpelayananM'];
      // $r = Params::RUANGAN_ID_LAB_KLINIK.','.Params::RUANGAN_ID_RAD.','.$ruangan_id;

      if ($kelaspelayanan_id != null) {
        $sql = "select t.*
                FROM
                    paketpelayanan_m t
                left JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id
                JOIN tipepaket_m tipe ON tipe.tipepaket_id = t.tipepaket_id
                LEFT JOIN modul_k m ON m.modul_id = r.modul_id "
          . "ORDER BY t.tipepaket_id ASC, t.namatindakan ASC";



        //            $modPemeriksaanmcus = MCPaketpelayananM::model()->findAll($criteria);
      } else if ($kelaspelayanan_id == null) {
        $sql = "select t.*
                FROM
                    paketpelayanan_m t
                left JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id
                JOIN tipepaket_m tipe ON tipe.tipepaket_id = t.tipepaket_id
                LEFT JOIN modul_k m ON m.modul_id = r.modul_id "
          . "ORDER BY t.tipepaket_id ASC, t.namatindakan ASC";
      }
      $modPemeriksaanmcus = MCPaketpelayananM::model()->findAllBySql($sql);

      $content = $this->renderPartial('mcu.views.pendaftaranPasien._checklistPemeriksaanMcu', array('modPemeriksaanmcus' => $modPemeriksaanmcus), true);
      echo CJSON::encode(array(
        'content' => $content,
      ));
      Yii::app()->end();
    }
  }

  /**
   * Function untuk pemeriksaan MCU (set checklist tindakan mcu) diluar paket
   */
  public function actionSetChecklistTindakanMcuDiluarPaket()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $content = "";
      $modPemeriksaan = array();
      parse_str($_POST['data'], $post);
      $postPemeriksaan = $post['MCPaketpelayananM'];

      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : Params::KELASPELAYANAN_ID_KELAS_III);
      $tipepaket_id = (isset($_POST['tipepaket_id']) ? $_POST['tipepaket_id'] : Params::TIPEPAKET_ID_NONPAKET);
      $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : Params::PENJAMIN_ID_UMUM);
      $r_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id'));
      $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $penjamin_id);
      $jenistarif_id = $modJenisTarif->jenistarif_id;
      //			$ruangan_id = Yii::app()->user->getState('ruangan_id');
      //$ruangan_id = array(Params::RUANGAN_ID_LAB_KLINIK, Params::RUANGAN_ID_RAD, Params::RUANGAN_ID_KLINIK_MCU);
      $ruangan_id = array(Params::RUANGAN_ID_LAB_KLINIK, Params::RUANGAN_ID_RAD, Params::RUANGAN_ID_FISIOTERAPI, Yii::app()->user->getState('ruangan_id'));
      //            $kelompoktindakan_id = array(Params::KELOMPOKTINDAKAN_ID_RAD, Params::KELOMPOKTINDAKAN_ID_LAB, Params::KELOMPOKTINDAKAN_ID_MCU, Params::KELOMPOKTINDAKAN_ID_MCU_SPESIALIS); // params KELOMPOKTINDAKAN_ID_MCU_SPESIALIS tidak ada
      $kelompoktindakan_id = array(Params::KELOMPOKTINDAKAN_ID_RAD, Params::KELOMPOKTINDAKAN_ID_LAB, Params::KELOMPOKTINDAKAN_ID_MCU);

      if ($tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($postPemeriksaan['namatindakan']), true);
        if (!empty($kelompoktindakan_id)) {
          $criteria->addInCondition('kelompoktindakan_id', $kelompoktindakan_id);
        }
        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addInCondition('ruangan_id', $ruangan_id);
          //                    $criteria->addCondition('ruangan_id = '.$ruangan_id);
        }
        if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            //dicomment, karena masih belum ditentukan untuk kelas pelayanan jika untuk penunjang
            //$criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
          }
          $criteria->addCondition('tipepaket_id', Params::TIPEPAKET_ID_LUARPAKET);
        }
        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        $criteria->order = 'ruangan_nama,daftartindakan_nama';
        //				$criteria->limit = 100;
        $models = PaketpelayananV::model()->findAll($criteria);

        $content = $this->renderPartial('mcu.views.pendaftaranPasien._checklistPemeriksaanMcuDiluarPaket', array('modPemeriksaan' => $modPemeriksaan), true);
        echo CJSON::encode(array(
          'content' => $content
        ));
        Yii::app()->end();
      } else if ($tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($postPemeriksaan['namatindakan']), true);
        if (!empty($kelaspelayanan_id)) {
          //if (Yii::app()->user->getState('tindakanruangan')) {
          //dicomment, karena masih belum ditentukan untuk kelas pelayanan jika untuk penunjang
          $criteria->addCondition(" (ruangan_id = '" . $r_id . "' AND kelaspelayanan_id = '" . $kelaspelayanan_id . "') "
            . "OR  (ruangan_id = '" . Params::RUANGAN_ID_RAD . "' AND kelaspelayanan_id = '" . Params::KELASPELAYANAN_ID_KELAS_I . "')  "
            . "OR  (ruangan_id = '" . Params::RUANGAN_ID_FISIOTERAPI . "' AND kelaspelayanan_id = '" . Params::KELASPELAYANAN_ID_KELAS_I . "')  "
            . "OR  (ruangan_id = '" . Params::RUANGAN_ID_LAB_KLINIK . "' AND kelaspelayanan_id = '" . Params::KELASPELAYANAN_ID_KELAS_I . "') ");
          // }
        } else {
          $criteria->addCondition(" kelaspelayanan_id IS NULL ");
        }

        if (!empty($penjamin_id)) {
          $criteria->addCondition("penjamin_id = " . $penjamin_id);
        }
        //komen karena filter berdasarkan ruangan saja
        /*if (!empty($kelompoktindakan_id)) {
                    $criteria->addInCondition("kelompoktindakan_id", $kelompoktindakan_id);
                }*/

        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }

        if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            //dicomment, karena masih belum ditentukan untuk kelas pelayanan jika untuk penunjang
            //$criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
          }
        }
        //				$criteria->limit = 100;

        //if (Yii::app()->user->getState('tindakanruangan')) {
        $criteria->order = 'ruangan_nama,daftartindakan_nama';
        $criteria->addInCondition('ruangan_id', $ruangan_id);
        //					$criteria->addCondition('ruangan_id = '.$ruangan_id);
        $modPemeriksaan = MCTariftindakanperdaruanganV::model()->findAll($criteria);
        //} else {
        //    $criteria->order = 'daftartindakan_nama';
        //    $modPemeriksaan = TariftindakanperdaV::model()->findAll($criteria);
        //}
        $content = $this->renderPartial('mcu.views.pendaftaranPasien._checklistPemeriksaanMcuDiluarPaket', array('modPemeriksaan' => $modPemeriksaan, 'tipepaket_id' => $tipepaket_id), true);
        echo CJSON::encode(array(
          'content' => $content
        ));
        Yii::app()->end();
      } else {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($postPemeriksaan['namatindakan']), true);
        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }

        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addInCondition('ruangan_id', $ruangan_id);
        }

        if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
          }
        }

        if (!empty($tipepaket_id)) {
          $criteria->addCondition("tipepaket_id = " . $tipepaket_id);
        }
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        $criteria->order = 'ruangan_nama,daftartindakan_nama';
        //				$criteria->limit = 100;
        $modPemeriksaan = PaketpelayananV::model()->find($criteria);

        $content = $this->renderPartial('mcu.views.pendaftaranPasien._checklistPemeriksaanMcuDiluarPaket', array('modPemeriksaan' => $modPemeriksaan, 'tipepaket_id' => $tipepaket_id), true);
        echo CJSON::encode(array(
          'content' => $content
        ));
        Yii::app()->end();
      }
    }
  }

  /**
   * Fungsi untuk menyimpan data ke model MCPasienmasukpenunjangT
   * @param type $modPendaftaran
   * @param type $modPasien
   * @return MCPasienmasukpenunjangT
   */
  public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $ruangan_id)
  {
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
    $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modPasienMasukPenunjang->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modPasienMasukPenunjang->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    $modPasienMasukPenunjang->pegawai_id = $modPendaftaran->pegawai_id;
    $modPasienMasukPenunjang->pasien_id = $modPendaftaran->pasien_id;
    $modPasienMasukPenunjang->ruangan_id = $ruangan_id;
    $modPasienMasukPenunjang->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
    $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
    $modPasienMasukPenunjang->kunjungan = CustomFunction::getKunjungan($modPasien, $modPasienMasukPenunjang->ruangan_id);
    $modPasienMasukPenunjang->statusperiksa = $modPendaftaran->statusperiksa;
    $modPasienMasukPenunjang->tglmasukpenunjang = MyFormatter::formatDateTimeForDb($_POST['PermintaanmcuT']['tglrencanaperiksa']);
    $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($modPasienMasukPenunjang->ruangan_id, $modPasienMasukPenunjang->tglmasukpenunjang);
    //        RSSP-3041 - cek comment
    //        $modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");

    $modPasienMasukPenunjang->no_urutperiksa = MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
    $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
    $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');
    $modPasienMasukPenunjang->panggilantrian = false;

    if ($modPasienMasukPenunjang->validate()) {
      $modPasienMasukPenunjang->save();
      $this->pasienpenunjangtersimpan &= true;
    } else {
      $this->pasienpenunjangtersimpan &= false;
    }
    return $modPasienMasukPenunjang;
  }

  /**
   * proses simpan LKTindakanPelayananT dan LKTindakanKomponenT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang = null, $post = null)
  {
    $modTindakan = new MCTindakanPelayananT();
    $modPemeriksaanLab = MCPemeriksaanlabM::model()->find('daftartindakan_id = ' . $post['daftartindakan_id']);
    $modPemeriksaanRad = MCPemeriksaanRadM::model()->find('daftartindakan_id = ' . $post['daftartindakan_id']);

    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;
    if (!empty($modPasienMasukPenunjang)) {
      $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
      $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
      $modTindakan->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
    }
    $modTindakan->attributes = $post;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->pasienmasukpenunjang_id = (isset($modPasienMasukPenunjang->pasienmasukpenunjang_id) ? $modPasienMasukPenunjang->pasienmasukpenunjang_id : null);
    if (isset($post['ruangantujuan_id'])) { //khusus untuk form MCPermintaanmcuT
      $modTindakan->ruangan_id = $post['ruangantujuan_id'];
    }
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    //RND-9000
    if (empty($modTindakan->tipepaket_id) || ($modTindakan->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET)) {
      $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan();
    }
    $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
    $modTindakan->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
    if (!empty($modTindakan->karcis_id)) {
      $this->karcistersimpan = true;
      if (isset($post['harga_tariftindakan'])) { //jika dari form karcis
        if (!empty($post['harga_tariftindakan'])) {
          $modTindakan->tarif_satuan = $post['harga_tariftindakan'];
        }
      }
      if ($post['tipepaket_id'] != null) {
        $modTindakan->tipepaket_id = $post['tipepaket_id'];
      } else {
        $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
      }
    } else {
      $modTindakan->tarif_satuan = $post['tarif_satuan'];
      $modTindakan->qty_tindakan = $post['qty_tindakan'];
    }
    if ($post['tipepaket_id'] != null) {
      $modTindakan->tipepaket_id = $post['tipepaket_id'];
    } else {
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id); //RSSP-3226
    }
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    $modTindakan->tarif_satuan = MyFormatter::formatNumberForDb($modTindakan->tarif_satuan);
    $modTindakan->tarif_tindakan = MyFormatter::formatNumberForDb($modTindakan->tarif_satuan) * $modTindakan->qty_tindakan;
    $modTindakan->cyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;
    $modTindakan->tarif_rsakomodasi = 0;
    $modTindakan->tarif_medis = 0;
    $modTindakan->tarif_paramedis = 0;
    $modTindakan->tarif_bhp = 0;

    // //($modTindakan->attributes);die;
    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      }
    } else {
      //($modTindakan->getErrors());die;

      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }

  /**
   * simpan LBHasilPemeriksaanLabT
   */
  public function simpanHasilPemeriksaanRehab($modPasien, $modPasienMasukPenunjang)
  {
    $modHasilPemeriksaan = new HasilpemeriksaanrmT;
    $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaan->kunjunganke = 1;
    $modHasilPemeriksaan->tglpemeriksaanrm = $modPasienMasukPenunjang->tgl_tindakan;
    $modHasilPemeriksaan->nohasilrm = MyGenerator::noHasilPemeriksaanRM();
    $modHasilPemeriksaan->pegawai_id = $modPasienMasukPenunjang->dokterpemeriksa1_id;
    $pemeriksaan = Tindakanrm::model()->findByAttributes(array(
      'daftartindakan_id' => $modPasienMasukPenunjang->daftartindakan_id,
    ));

    if (!empty($pemeriksaan)) {
      $modHasilPemeriksaan->tindakanrm_id = $pemeriksaan->tindakanrm_id;
      $modHasilPemeriksaan->jenistindakanrm_id = $pemeriksaan->jenistindakanrm_id;
    }

    $modHasilPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');

    // //($modHasilPemeriksaan->attributes, $modHasilPemeriksaan->validate(), $modHasilPemeriksaan->errors, $modPasienMasukPenunjang->attributes); die;


    if ($modHasilPemeriksaan->validate()) {
      $modHasilPemeriksaan->save();
    } else {
      $this->hasilpemeriksaantersimpan &= false;
    }
    return $modHasilPemeriksaan;
  }

  /**
   * simpan LBHasilPemeriksaanLabT
   */
  public function simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjang)
  {
    $modHasilPemeriksaan = new MCHasilPemeriksaanLabT;
    $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaan->nohasilperiksalab = MyGenerator::noHasilPemeriksaanLK();
    $modHasilPemeriksaan->tglhasilpemeriksaanlab = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaan->hasil_kelompokumur = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $modHasilPemeriksaan->hasil_jeniskelamin = $modPasien->jeniskelamin;
    $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;
    //		$modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
    $modHasilPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($modHasilPemeriksaan->validate()) {
      $modHasilPemeriksaan->save();
    } else {
      $this->hasilpemeriksaantersimpan &= false;
    }
    return $modHasilPemeriksaan;
  }

  /**
   * simpan MCDetailHasilPemeriksaanLabT
   */
  public function simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $modTindakan, $post)
  {

    $modDetailHasilPemeriksaans = array();
    $modPemeriksaanLab = MCPemeriksaanlabM::model()->find('daftartindakan_id = ' . $post['daftartindakan_id'] . ' AND pemeriksaanlab_aktif = TRUE');
    $pemeriksaanlab_id = isset($modPemeriksaanLab->pemeriksaanlab_id) ? $modPemeriksaanLab->pemeriksaanlab_id : null;
    $date1 = new DateTime($modTindakan->pendaftaran->tgl_pendaftaran);
    $date2 = new DateTime($modTindakan->pasien->tanggal_lahir);
    $umurhari = $date2->diff($date1);
    $criteria = new CDbCriteria();

    if (!empty($pemeriksaanlab_id)) {
      // //("NAMA -> ".$modPemeriksaanLab->pemeriksaanlab_nama);
      $criteria->addCondition('pemeriksaanlab_id = ' . $pemeriksaanlab_id);
    } else {
      $criteria->addCondition('pemeriksaanlab_id is null');
    }
    // $criteria->addCondition("'" . $umurhari . "' BETWEEN hariminlab AND harimakslab");
    $criteria->compare('LOWER(nilairujukan_jeniskelamin)', strtolower($modHasilPemeriksaan->pasien->jeniskelamin), true);
    $criteria->order = 'pemeriksaanlabdet_nourut ASC';


    $tahun = $umurhari->y;
    $bulan = $umurhari->y * 12 + $umurhari->m;
    $hari = $umurhari->format("%a");


    $modPemeriksaanLadDet = PemeriksaanlabdetV::model()->findAll($criteria);
    if (count((array)$modPemeriksaanLadDet) > 0) {
      foreach ($modPemeriksaanLadDet as $i => $pemeriksaanDet) {



        // filter kelompok pemeriksaan
        if (
          strtolower($pemeriksaanDet->satuankelumur) == 'hr'
          && ($hari < $pemeriksaanDet->umurminlab || $hari > $pemeriksaanDet->umurmakslab)
        ) {
          continue;
        }

        if (
          strtolower($pemeriksaanDet->satuankelumur) == 'bln'
          && ($bulan < $pemeriksaanDet->umurminlab || $bulan > $pemeriksaanDet->umurmakslab)
        ) {
          continue;
        }

        if (
          strtolower($pemeriksaanDet->satuankelumur) == 'thn'
          && ($tahun < $pemeriksaanDet->umurminlab || $tahun > $pemeriksaanDet->umurmakslab)
        ) {
          continue;
        }



        // //($pemeriksaanDet->nilairujukan_nama." - ".$pemeriksaanDet->nilairujukan_satuan." :: ".$pemeriksaanDet->satuankelumur." "
        //       . ":: Umur-Min : ". $pemeriksaanDet->umurminlab." :: Umur-Max : ".$pemeriksaanDet->umurmakslab);


        // //("BOOM");

        $modDetailHasilPemeriksaans[$i] = new MCDetailHasilPemeriksaanLabT;
        $modDetailHasilPemeriksaans[$i]->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
        $modDetailHasilPemeriksaans[$i]->pemeriksaanlabdet_id = $pemeriksaanDet->pemeriksaanlabdet_id;
        $modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id = $pemeriksaanDet->pemeriksaanlab_id;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaanlab_id = $modHasilPemeriksaan->hasilpemeriksaanlab_id;
        $modDetailHasilPemeriksaans[$i]->nilairujukan = $pemeriksaanDet->nilairujukan_nama;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_satuan = $pemeriksaanDet->nilairujukan_satuan;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_metode = $pemeriksaanDet->nilairujukan_metode;
        $modDetailHasilPemeriksaans[$i]->create_time = date("Y-m-d H:i:s");
        $modDetailHasilPemeriksaans[$i]->create_loginpemakai_id = Yii::app()->user->id;
        $modDetailHasilPemeriksaans[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');



        //			   $modDetailHasilPemeriksaans[$i]->create_ruangan = $modHasilPemeriksaan->create_ruangan;
        if ($modDetailHasilPemeriksaans[$i]->validate()) {
          $modDetailHasilPemeriksaans[$i]->save();
          $modTindakan->detailhasilpemeriksaanlab_id = $modDetailHasilPemeriksaans[$i]->detailhasilpemeriksaanlab_id;
          $modTindakan->update();
        } else {
      //($modDetailHasilPemeriksaans[$i]->getErrors());die;

          $this->hasilpemeriksaantersimpan &= false;
        }
      }
    }


    // //("Kicker");

    return $modDetailHasilPemeriksaans;
  }

  /**
   * simpan MCDetailHasilPemeriksaanLabT
   */
  public function simpanDetailHasilPemeriksaanLabNon($modHasilPemeriksaan, $modTindakan, $post)
  {

    $modDetailHasilPemeriksaans = array();
    $modPemeriksaanLab = MCPemeriksaanlabM::model()->find('daftartindakan_id = ' . $post['daftartindakan_id'] . ' AND pemeriksaanlab_aktif = TRUE');
    $pemeriksaanlab_id = isset($modPemeriksaanLab->pemeriksaanlab_id) ? $modPemeriksaanLab->pemeriksaanlab_id : null;
    $date1 = new DateTime($modTindakan->pendaftaran->tgl_pendaftaran);
    $date2 = new DateTime($modTindakan->pasien->tanggal_lahir);
    $umurhari = $date2->diff($date1)->format("%a");
    $criteria = new CDbCriteria();

    if (!empty($pemeriksaanlab_id)) {
      $criteria->addCondition('pemeriksaanlab_id = ' . $pemeriksaanlab_id);
    }
    $criteria->addCondition("'" . $umurhari . "' BETWEEN hariminlab AND harimakslab");
    $criteria->compare('LOWER(nilairujukan_jeniskelamin)', strtolower($modHasilPemeriksaan->pasien->jeniskelamin), true);
    $criteria->order = 'pemeriksaanlabdet_nourut ASC';

    $modPemeriksaanLadDet = PemeriksaanlabdetV::model()->findAll($criteria);
    if (count((array)$modPemeriksaanLadDet) > 0) {
      foreach ($modPemeriksaanLadDet as $i => $pemeriksaanDet) {
        $modDetailHasilPemeriksaans[$i] = new MCDetailHasilPemeriksaanLabT;
        $modDetailHasilPemeriksaans[$i]->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
        $modDetailHasilPemeriksaans[$i]->pemeriksaanlabdet_id = $pemeriksaanDet->pemeriksaanlabdet_id;
        $modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id = $pemeriksaanDet->pemeriksaanlab_id;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaanlab_id = $modHasilPemeriksaan->hasilpemeriksaanlab_id;
        $modDetailHasilPemeriksaans[$i]->nilairujukan = $pemeriksaanDet->nilairujukan_nama;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_satuan = $pemeriksaanDet->nilairujukan_satuan;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_metode = $pemeriksaanDet->nilairujukan_metode;
        $modDetailHasilPemeriksaans[$i]->create_time = date("Y-m-d H:i:s");
        $modDetailHasilPemeriksaans[$i]->create_loginpemakai_id = Yii::app()->user->id;
        $modDetailHasilPemeriksaans[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
        //			   $modDetailHasilPemeriksaans[$i]->create_ruangan = $modHasilPemeriksaan->create_ruangan;
        if ($modDetailHasilPemeriksaans[$i]->validate()) {
          $modDetailHasilPemeriksaans[$i]->save();
          $modTindakan->detailhasilpemeriksaanlab_id = $modDetailHasilPemeriksaans[$i]->detailhasilpemeriksaanlab_id;
          $modTindakan->update();
        } else {
      //($modDetailHasilPemeriksaans[$i]->getErrors());die;

          $this->hasilpemeriksaantersimpan &= false;
        }
      }
    }
    return $modDetailHasilPemeriksaans;
  }

  /**
   * simpan LBHasilPemeriksaanPAT
   */
  public function simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $modTindakan, $post)
  {
    $modHasilPemeriksaanPA = new MCHasilPemeriksaanPAT;
    $modHasilPemeriksaanPA->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaanPA->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
    $modHasilPemeriksaanPA->pemeriksaanlab_id = $post['pemeriksaanlab_id'];
    $modHasilPemeriksaanPA->nosediaanpa = MyGenerator::noSediaanPA();
    $modHasilPemeriksaanPA->tglperiksapa = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaanPA->create_time = date("Y-m-d H:i:s");
    $modHasilPemeriksaanPA->create_loginpemakai_id = Yii::app()->user->id;
    $modHasilPemeriksaanPA->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //		$modHasilPemeriksaanPA->create_ruangan = $modPasienMasukPenunjang->ruangan_id;

    if ($modHasilPemeriksaanPA->validate()) {
      $modHasilPemeriksaanPA->save();
      $modTindakan->hasilpemeriksaanpa_id = $modHasilPemeriksaanPA->hasilpemeriksaanpa_id;
      $modTindakan->update();
    } else {
      //($modHasilPemeriksaanPA->getErrors());die;

      $this->hasilpemeriksaantersimpan = false;
    }
  }

  /**
   * Fungsi untuk menyimpan data ke model LBPengambilanSampleT
   */
  public function simpanPengambilanSample($modPasienMasukPenunjang, $post)
  {
    $modPengambilanSample = new MCPengambilanSampleT;
    $modPengambilanSample->attributes = $post;
    $modPengambilanSample->tglpengambilansample = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modPengambilanSample->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    if ($modPengambilanSample->validate()) {
      $modPengambilanSample->save();
      $this->pengambilansampletersimpan &= true;
    } else {
      //($modPengambilanSample->getErrors());die;

      $this->pengambilansampletersimpan &= false;
    }

    return $modPengambilanSample;
  }

  /**
   * simpan MCHasilpemeriksaanradT
   */
  public function simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $modTindakan, $post)
  {
    $modHasilPemeriksaan = new MCHasilpemeriksaanradT;
    $modPemeriksaanRad = MCPemeriksaanRadM::model()->find('daftartindakan_id = ' . $post['daftartindakan_id']);
    $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
    $modHasilPemeriksaan->pemeriksaanrad_id = isset($modPemeriksaanRad->pemeriksaanrad_id) ? $modPemeriksaanRad->pemeriksaanrad_id : null;
    $modHasilPemeriksaan->tglpemeriksaanrad = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
    $modHasilPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
    $modHasilPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');;
    //		$modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;

    if ($modHasilPemeriksaan->validate()) {
      $modHasilPemeriksaan->save();
      //RND-8272
      $dataBroker = $modHasilPemeriksaan->getDataBroker();
      if (!empty($dataBroker)) {
        CustomFunction::postHL7Broker("ADD", $dataBroker);
      }

      $modTindakan->hasilpemeriksaanrad_id = $modHasilPemeriksaan->hasilpemeriksaanrad_id;
      $modTindakan->update();
    } else {
      //($modHasilPemeriksaan->getErrors());die;
      //($modTindakan->getErrors());die;
      $this->hasilpemeriksaantersimpan &= false;
    }
  }

  /**
   * untuk menyimpan data ke konsulpoli_t jika ada pemeriksaan yg dilakukan di luar ruangan MCU
   * LNG-2958
   */
  public function simpanKonsulPoli($modPendaftaran, $ruangan_id)
  {
    $modKonsulPoli = new MCKonsulpoliT;
    $modKonsulPoli->ruangan_id = $ruangan_id;
    $modKonsulPoli->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modKonsulPoli->pasien_id = $modPendaftaran->pasien_id;
    $modKonsulPoli->pegawai_id = $modPendaftaran->pegawai_id;
    $modKonsulPoli->tglkonsulpoli = $modPendaftaran->tgl_pendaftaran;
    $modKonsulPoli->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $modKonsulPoli->catatan_dokter_konsul = "MCU";
    $modKonsulPoli->asalpoliklinikkonsul_id = Yii::app()->user->getState('ruangan_id');
    $modKonsulPoli->no_antriankonsul = MyGenerator::noAntrianKonsulPoli($modKonsulPoli->ruangan_id);
    $modKonsulPoli->create_time = date("Y-m-d H:i:s");
    $modKonsulPoli->create_loginpemakai_id = Yii::app()->user->id;
    $modKonsulPoli->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($modKonsulPoli->validate()) {
      if ($modKonsulPoli->save()) {
        $this->konsulpolitersimpan = true;
      }
    } else {
      $this->konsulpolitersimpan = false;
    }
    return $modKonsulPoli;
  }
  /**
   * untuk autocomplete pegawai
   * @throws CHttpException
   */
  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->limit = 5;
      $models = MCPegawaiM::model()->findAll($criteria);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $returnVal[$i] = $model->attributes;
          if (!empty($nomorindukpegawai)) {
            $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai;
          } else {
            $returnVal[$i]['label'] = $model->nama_pegawai;
          }
          $returnVal[$i]['value'] = $model->pegawai_id;
          $returnVal[$i]['jabatan_nama'] = !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : "";
          $returnVal[$i]['gelarbelakang_nama'] = !empty($model->gelarbelakang_id) ? $model->gelarbelakang->gelarbelakang_nama : "";
        }
      }
      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }
  /**
   * cek tanggal kontrol
   */
  public function actionCekTanggalKontrol()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = $_POST['pasien_id'];
      $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pasien_id' => $pasien_id), array('order' => 'pendaftaran_id DESC'));
      $return = '';
      $status = false;
      if (!empty($modPendaftaran->tglrenkontrol)) {
        $tglpendaftaran = new DateTime(MyFormatter::formatDateTimeForDb($modPendaftaran->tgl_pendaftaran));
        $tglrenkontrol = new DateTime($modPendaftaran->tglrenkontrol);

        if ($tglrenkontrol >= $tglpendaftaran) {
          $status = true;
          $return['tgl_pendaftaran'] = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);
          $return['tglrenkontrol_next'] = MyFormatter::formatDateTimeForUser($modPendaftaran->tglrenkontrol);
          $return['pesan'] = "Pasien ini sudah melakukan pendaftarn MCU pada " . $return['tgl_pendaftaran'] . " dan pemeriksaan MCU yg akan datang normalnya lebih dari tanggal " . $return['tglrenkontrol_next'] . " Apakah ingin tetap mendaftarkan ?";
        }
      }
      echo CJSON::encode(array('status' => $status, 'return' => $return));
    }
    Yii::app()->end();
  }
  /**
   * fungsi untuk cek fingerprint
   */
  public function actionReceiveFingerprint()
  {
    if (Yii::app()->request->isAjaxRequest) {
      // Get ip Address CLient
      if (!empty($_SERVER["HTTP_CLIENT-IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
      } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
      } else {
        $ip = $_SERVER["REMOTE_ADDR"];
      }

      // set some variables
      $host = "192.168.2.8";  // ip Server
      $port = 6000;   // Port TCP Socket
      set_time_limit(0);  // No Timeout
      // create socket
      $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
      if (!socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1)) {
        echo socket_strerror(socket_last_error($socket));
        exit;
      }
      // bind socket to port
      $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
      // start listening for connections
      $result = socket_listen($socket, SOMAXCONN) or die("Could not set up socket listener\n");
      // accept incoming connections
      // spawn another socket to handle communication
      $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
      // read client input
      $input = socket_read($spawn, 10000, PHP_NORMAL_READ) or die("Could not read input\n");
      $input = trim($input);
      $ipfinger = split("\ ", $input);

      if ($ipfinger[1] == $ip) {
        $data = $ipfinger[0];
      } else {
        $data = 'Try again';
      }

      socket_close($spawn);
      socket_close($socket);

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * digunakan untuk mengenerate paket mcu
   */
  public function actionloadDataPaket()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tipepaket_id = isset($_POST['tipepaket_id']) ? $_POST['tipepaket_id'] : null;
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $criteria = new CdbCriteria();
      $criteria->join = " left JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id "
        . " JOIN tipepaket_m tipe ON tipe.tipepaket_id = t.tipepaket_id ";
      $criteria->addCondition(" t.tipepaket_id = '" . $tipepaket_id . "'  ");
      if (!empty($ruangan_id)) {
        //$r = array(Params::RUANGAN_ID_LAB_KLINIK, Params::RUANGAN_ID_RAD, $ruangan_id);
        //$criteria->addInCondition(" t.ruangan_id",$r);
      }
      $criteria->order = "t.tipepaket_id, t.namatindakan";
      $modPemeriksaanmcus = MCPaketpelayananM::model()->findAll($criteria);

      $tabel = '';

      if (!empty($modPemeriksaanmcus)) {
        $model = new MCPermintaanmcuT;
        $i = 0;
        foreach ($modPemeriksaanmcus as $a => $det) {
          $model->ruangan_nama = $det->ruangan->ruangan_nama;
          $model->paketpelayanan_id = $det->paketpelayanan_id;
          $model->daftartindakan_id = $det->daftartindakan_id;
          $model->tipepaket_id = $det->tipepaket_id;
          $model->namatindakan = $det->namatindakan;
          $model->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
          $model->ruangantujuan_id = $det->ruangan_id;
          $model->qty_tindakan = 1;
          $model->tarif_satuan = MyFormatter::formatNumberForPrint($det->tarifpaketpel);
          $model->tarif_tindakan = MyFormatter::formatNumberForPrint(($model->qty_tindakan * $det->tarifpaketpel));

          $tabel .= $this->renderPartial('mcu.views.pendaftaranPasien._rowTindakanPemeriksaanMcuLoad', array('modPermintaanMcu' => $model, 'i' => $i), true);
          $i++;
          
        }
      }

      echo CJSON::encode(array(
        'gen' => $tabel,
        'tabeltarif' => $tabel
      ));
      Yii::app()->end();
    }
  }


  protected function tambahPasienHL7($penunjang, $komentar = "Pasien Daftar Langsung Radiologi")
  {
    $hl7 = new HL7;
    $ok = $hl7->tambahPasien($penunjang->pasienmasukpenunjang_id, $komentar);

    return $ok;
  }
  
    public function actionLoadKTP() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        //$path = "/var/tmp_ektp/ektp_data.json" ;
        $ok = 1;
        $data_res = array();
        try {

            $name = "";
            
            // cek IP Lokal
            $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            socket_connect($sock, "8.8.8.8", 53);
            socket_getsockname($sock, $name); // $name passed by reference
            
            // load IP Publik
            $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
            
            // load data RM
            $alat = AlatscanktppenggunaM::model()->findByAttributes(array(
                'user_ip'=>$ip,
            )) 
            ?? AlatscanktppenggunaM::model()->findByAttributes(array(
                'user_ip'=>$name,
            ));
            
//            var_dump($alat->attributes); die;
            
            $data = null;
            
            if (!empty($alat)) {
                $cr = new CDbCriteria();
                $cr->addCondition("trim(host) = '".trim($alat->id_perangkat)."'");
                $cr->order = 'dataktp_id desc';
                $data = DataktpR::model()->find($cr);
            }
            
            // var_dump($data->attributes); die; 
            

//            var_dump($cr, $ip); die;


            if (!empty($data)) {

                $data_res = CJSON::decode($data->data);
                $pasien = PasienM::model()->findByAttributes(array(
                    'no_identitas_pasien'=>$data_res['nik'],
                ));

                if (!empty($data_res)) {

                    $tgl_arr = explode("-", $data_res['tanggal_lahir']);
                    $tgl_arr[0] = str_pad($tgl_arr[0], 2, "0", STR_PAD_LEFT);
                    $tgl_arr[1] = str_pad($tgl_arr[1], 2, "0", STR_PAD_LEFT);

                    $data_res['tanggal_lahir'] = implode("/", $tgl_arr);

                    if (empty($pasien)) {
                        $data_res['pasien_baru'] = 1;
                        $data_res['pasien_id'] = null;
                    } else {
                        $data_res['pasien_baru'] = 0;
                        $data_res['pasien_id'] = $pasien->pasien_id;
                    }



                    // propinsi
                    $crPropinsi = new CDbCriteria();
                    $crPropinsi->compare('lower(propinsi_nama)', strtolower($data_res['provinsi']), true);
                    $crPropinsi->addCondition('propinsi_aktif = true');


                    $htmlKabData = '<option value="">-- Pilih --</option>';
                    $htmlKecData = '<option value="">-- Pilih --</option>';
                    $htmlKelData = '<option value="">-- Pilih --</option>';

                    $propinsi = PropinsiM::model()->find($crPropinsi);
                    $kabupaten = null;
                    $kecamatan = null;
                    $kelurahan = null;



                    if (!empty($propinsi)) {
                        $crKab = new CDbCriteria();
                        $crKab->compare('propinsi_id', $propinsi->propinsi_id);
                        $crKab->addCondition('kabupaten_aktif = true');
                        $crKab->order = 'kabupaten_nama asc';

                        $list_kab = CHtml::listData(KabupatenM::model()->findAll($crKab), 'kabupaten_id', 'kabupaten_nama');
                        foreach ($list_kab as $id => $label) {
                            $htmlKabData .= '<option value="'.$id.'">'.$label.'</option>';
                        }

                        $crKab->compare('lower(kabupaten_nama)', strtolower($data_res['kotakabupten']), true);

                        $kabupaten = KabupatenM::model()->find($crKab);

                        if (!empty($kabupaten)) {

                            $crKec = new CDbCriteria();
                            $crKec->compare('kabupaten_id', $kabupaten->kabupaten_id);
                            $crKec->addCondition('kecamatan_aktif = true');
                            $crKec->order = 'kecamatan_nama asc';

                            $list_kec = CHtml::listData(KecamatanM::model()->findAll($crKec), 'kecamatan_id', 'kecamatan_nama');
                            foreach ($list_kec as $id => $label) {
                                $htmlKecData .= '<option value="'.$id.'">'.$label.'</option>';
                            }

                            $crKec->compare('lower(kecamatan_nama)', strtolower($data_res['kecamatan']), true);

                            $kecamatan = KecamatanM::model()->find($crKec);

                            if (!empty($kecamatan)) {

                                $crKel = new CDbCriteria();
                                $crKel->compare('kecamatan_id', $kecamatan->kecamatan_id);
                                $crKel->addCondition('kelurahan_aktif = true');
                                $crKel->order = 'kelurahan_nama asc';

                                $list_kel = CHtml::listData(KelurahanM::model()->findAll($crKel), 'kelurahan_id', 'kelurahan_nama');
                                foreach ($list_kel as $id => $label) {
                                    $htmlKelData .= '<option value="'.$id.'">'.$label.'</option>';
                                }

                                $crKel->compare('lower(kelurahan_nama)', strtolower($data_res['desakelurahan']), true);

                                $kelurahan = KelurahanM::model()->find($crKel);



                            }

                        }
                    }

                    $pekerjaan = isset($data_res['pekerjaan']) ? trim($data_res['pekerjaan']) : null;
                    $data_res['pekerjaan_id'] = null;

                    if (!empty($pekerjaan)) {
                        $crKerja = new CDbCriteria();
                        $crKerja->compare('lower(pekerjaan_nama)', strtolower($pekerjaan), true);
                        $crKerja->addCondition('pekerjaan_aktif = true');
                        $kerja = PekerjaanM::model()->find($crKerja);

                        $data_res['pekerjaan_id'] = empty($kerja) ? null : $kerja->pekerjaan_id;
                    }



                    $data_res['propinsi_id'] = empty($propinsi) ? null : $propinsi->propinsi_id;
                    $data_res['kabupaten_id'] = empty($kabupaten) ? null : $kabupaten->kabupaten_id;
                    $data_res['kecamatan_id'] = empty($kecamatan) ? null : $kecamatan->kecamatan_id;
                    $data_res['kelurahan_id'] = empty($kelurahan) ? null : $kelurahan->kelurahan_id;

                    $data_res['kabupaten_list'] = $htmlKabData;
                    $data_res['kecamatan_list'] = $htmlKecData;
                    $data_res['kelurahan_list'] = $htmlKelData;

                    $preview_foto = '<img id="photo-preview" src="data:image/png;base64, '.$data_res['foto64'].'" width="84px"/><br/>';
                    $preview_tandatangan = '<img id="tandatangan-preview" src="data:image/png;base64, '.$data_res['tandatangan64'].'" width="84px"/>';

                    $data_res['foto'] = $preview_foto.$preview_tandatangan;
                    $data_res['foto_bin'] = 'data:image/png;base64, '.$data_res['foto64'];
                    $data_res['foto_sign_bin'] = 'data:image/png;base64, '.$data_res['tandatangan64'];

                    DataktpR::model()->deleteByPk($data->dataktp_id);
                    
//                    DataktpR::model()->deleteAllByAttributes(array(
//                        'host' => $ip
//                    ));

                } else {
                    $ok = 0;
                }
            } else {
                $ok = 0;
            }

        } catch (Exception $ex) {
            // var_dump($ex->getMessage()); die;
            $ok = 0;
        }


        echo CJSON::encode(array('ok'=>$ok, 'ktp'=>$data_res));
    }
    
    public function actionCatatCeklisHakPasien() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $res = array();
        if (isset($_POST['ceklis'])) {
            $res = $_POST['ceklis'];
            Yii::app()->user->setState('ceklis_hak_pasien_'.$this->id,$_POST['ceklis']);
        } else {
            Yii::app()->user->setState('ceklis_hak_pasien_'.$this->id, $res);
        }
        
        echo CJSON::encode(array('ok'=>1, 'data'=>$res));
    }

    public function actionCatatCeklisKewajibanPasien() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $res = array();
        if (isset($_POST['ceklis'])) {
            $res = $_POST['ceklis'];
            Yii::app()->user->setState('ceklis_kewajiban_pasien_'.$this->id,$_POST['ceklis']);
        } else {
            Yii::app()->user->setState('ceklis_kewajiban_pasien_'.$this->id, $res);
        }
        
        echo CJSON::encode(array('ok'=>1, 'data'=>$res));
    }
    
    public function actionSetSudahDibaca() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $pendaftaran = isset($_POST['pendaftaran_id']) && $_POST['pendaftaran_id'] != 0 ? $_POST['pendaftaran_id'] : null;
        
        if (!empty($pendaftaran)) {
            PendaftaranT::model()->updateByPk($pendaftaran, array(
                'isbacahakpasien'=>true,
            ));
            Yii::app()->user->setState('hak_pasien_sudah_baca_'.$this->id, null);
            Yii::app()->user->setState('ceklis_hak_pasien_'.$this->id, null);
            Yii::app()->user->setState('kewajiban_pasien_sudah_baca_'.$this->id, null);
            Yii::app()->user->setState('ceklis_kewajiban_pasien_'.$this->id, null);
            Yii::app()->user->setState('cetakHak'.$this->id, null);
        } else {
            Yii::app()->user->setState('hak_pasien_sudah_baca_'.$this->id, 1);
            Yii::app()->user->setState('kewajiban_pasien_sudah_baca_'.$this->id, 1);
            Yii::app()->user->setState('cetakHak'.$this->id, 1);
            
        }
        
        echo CJSON::encode(['ok'=>1]);
    }
    
    public function cleanUpSessionPasienSudahBaca($id = null) {
        
        if (!empty(Yii::app()->user->getState('hak_pasien_sudah_baca_'.$this->id)) && Yii::app()->user->getState('hak_pasien_sudah_baca_'.$this->id) == 1 && !empty(Yii::app()->user->getState('kewajiban_pasien_sudah_baca_'.$this->id)) && Yii::app()->user->getState('kewajiban_pasien_sudah_baca_'.$this->id) == 1) {
            Yii::app()->user->setState('hak_pasien_sudah_baca_'.$this->id, null);
            Yii::app()->user->setState('ceklis_hak_pasien_'.$this->id, null);
            Yii::app()->user->setState('kewajiban_pasien_sudah_baca_'.$this->id, null);
            Yii::app()->user->setState('ceklis_kewajiban_pasien_'.$this->id, null);
            if (!empty($id)) {
                PendaftaranT::model()->updateByPk($id, array(
                    'isbacahakpasien'=>true,
                ));
            }
        }

        // if (!empty(Yii::app()->user->getState('kewajiban_pasien_sudah_baca_'.$this->id)) && Yii::app()->user->getState('kewajiban_pasien_sudah_baca_'.$this->id) == 1) {
        //     Yii::app()->user->setState('kewajiban_pasien_sudah_baca_'.$this->id, null);
        //     Yii::app()->user->setState('ceklis_kewajiban_pasien_'.$this->id, null);
        //     if (!empty($id)) {
        //         PendaftaranT::model()->updateByPk($id, array(
        //             'isbacahakpasien'=>true,
        //         ));
        //     }
        // }
    }
}
