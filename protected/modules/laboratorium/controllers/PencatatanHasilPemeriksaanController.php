<?php
Yii::import('laboratorium.controllers.PemeriksaanPasienLaboratoriumController');
/**
 * ada kondisi :
 * 1. untuk pemeriksaan klinik (LBHasilPemeriksaanLabT & LBDetailHasilPemeriksaanLabT)
 * 2. untuk pemeriksaan anatomi (LBHasilPemeriksaanPAT)
 * digunakan untuk menyimpan fung - fungsi javascript unyuk tabulasi menu asesmen awal kebidanan
 * 
 * @package application.modules.laboratorium
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class PencatatanHasilPemeriksaanController extends PemeriksaanPasienLaboratoriumController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "laboratorium.views.pemeriksaanPasienLaboratorium.";
  public $path_view_pendaftaran = "laboratorium.views.pendaftaranLaboratorium.";

  /**
   * Tambah / Ubah Pemeriksaan Laboratorium.
   * @param type $pasienmasukpenunjang_id
   */
  public function actionIndex($id = null, $idAntrian = null)
  {
    // echo CJSON::encode($_POST); die;
    $this->pageTitle = Yii::app()->name . " - Pencatatan Hasil Pemeriksaan";
    $pasienmasukpenunjang_id = $id;
    $format = new MyFormatter();
    $modKunjungan = new LBPasienMasukPenunjangV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modPemeriksaanLab = new LBTarifpemeriksaanlabruanganV;
    $modHasilPemeriksaan = new LBHasilPemeriksaanLabT;
    $modTindakan = new LBTindakanPelayananT;
    $modPasienMorbiditas = new LBPasienmorbiditasT();
    $dataHasilPemeriksaanPAs = array();
    $dataDetails = array();
    $modAnamnesa = new LBAnamnesaT;
    $modPemeriksaan = new LBPemeriksaanfisikT;
    $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : $pasienmasukpenunjang_id);
    if (!empty($pasienmasukpenunjang_id)) {
      $loadModKunjungan = $this->loadModPasienMasukPenunjang($pasienmasukpenunjang_id);
      if (isset($loadModKunjungan)) {
        $modKunjungan = $loadModKunjungan;
        $modKunjungan->dokterperujuk = $modKunjungan->getDokterPerujuk();
        if ($loadModKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
          $loadHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $loadModKunjungan->pasienmasukpenunjang_id));
          //RSPMC-663
          //                    if(strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)){
          //                        Yii::app()->user->setFlash('warning', "Pasien dengan status sudah diperiksa tidak bisa merubah tindakan pemeriksaan !");
          //                    }else{
          $modHasilPemeriksaan = $loadHasilPemeriksaan;
          //                    }
        } else if ($loadModKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI) {
        }
      }
    }
    // var_dump($_POST);die;
    // var_dump($_POST['LBHasilPemeriksaanLabT']);die;
    // var_dump($_POST['LBHasilPemeriksaanPAT']);die;
    // || isset($_POST['LBHasilPemeriksaanPAT'])
    if (isset($_POST['pasienmasukpenunjang_id']) && (isset($_POST['LBHasilPemeriksaanLabT']) || isset($_POST['LBHasilPemeriksaanPAT']))) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
          $modHasilPemeriksaan->attributes = $_POST['LBHasilPemeriksaanLabT'];
          //                    $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG; RSPMC-492
          $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH;
          $modHasilPemeriksaan->tglhasilpemeriksaanlab = $format->formatDateTimeForDb($_POST['LBHasilPemeriksaanLabT']['tglhasilpemeriksaanlab']);
          $modHasilPemeriksaan->tglpengambilanhasil = $format->formatDateTimeForDb($_POST['LBHasilPemeriksaanLabT']['tglpengambilanhasil']);
          $modHasilPemeriksaan->catatanlabklinik = (isset($_POST['LBHasilPemeriksaanLabT']['catatanlabklinik']) ? $_POST['LBHasilPemeriksaanLabT']['catatanlabklinik'] : null);
          $modHasilPemeriksaan->kesimpulan = (isset($_POST['LBHasilPemeriksaanLabT']['kesimpulan']) ? $_POST['LBHasilPemeriksaanLabT']['kesimpulan'] : null);
          $modHasilPemeriksaan->update_time = date('Y-m-d H:i:s');
          $modHasilPemeriksaan->update_loginpemakai_id = Yii::app()->user->id;
          if ($modHasilPemeriksaan->update()) {
            $this->hasilpemeriksaantersimpan = true;
          } else {
            $this->hasilpemeriksaantersimpan = false;
          }
        }
        
        if (isset($_POST['LBDetailHasilPemeriksaanLabT'])) {
          if (count((array)$_POST['LBDetailHasilPemeriksaanLabT']) > 0) {
            foreach ($_POST['LBDetailHasilPemeriksaanLabT'] as $i => $postDetail) {
              $dataDetails[$i] = $this->ubahDetailHasilPemeriksaanLab($postDetail);
            }
          }
        }
        
        if (isset($_POST['LBHasilPemeriksaanPAT'])) {
          if (count((array)$_POST['LBHasilPemeriksaanPAT']) > 0) {
            foreach ($_POST['LBHasilPemeriksaanPAT'] as $i => $postDetail) {
              $dataDetails[$i] = $this->ubahHasilPemeriksaanPA($postDetail);
            }
          }
        }
        // var_dump($hasilpemeriksaantersimpan); die;
        if ($this->hasilpemeriksaantersimpan) {
          
          $pasien = PasienmasukpenunjangV::model()->find(" pasienmasukpenunjang_id = '" . $pasienmasukpenunjang_id . "' ");
          $up = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
          $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
          $modul = RuanganM::model()->findByPk($pasien->ruanganasal_id);
          if ($pasien->ruanganasal_id != Params::RUANGAN_ID_LAB_KLINIK) {


            $judul = 'Hasil Pemeriksaan Laboratorium';
            $isi =  $peg->namaLengkap . ' sudah mencatatkan / mengubah data hasil pemeriksaan untuk pasien ' . $pasien->nama_pasien . ' (No RM' . $pasien->no_rekam_medik . ' - ' . $pasien->no_pendaftaran . ') pada tanggal ' . MyFormatter::formatDateTimeForUser($modHasilPemeriksaan->tglhasilpemeriksaanlab);

            $this->broadcastNotifHasilPemeriksaan($judul, $isi, $pasien, $modul);
          } else {

            $judul = 'Pasien sudah periksa Laboratorium';
            $isi = $pasien->no_pendaftaran . " - " . $pasien->no_rekam_medik . ' ' . $pasien->nama_pasien;

            $arr = array(
              'pendaftaran_id' => $pasien->pendaftaran_id,
              'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
            );

            $isi .= CHtml::link('<br/><u>Klik ini untuk melakukan pembayaran.</u>', Yii::app()->createUrl('/billingKasir/PembayaranTagihanPasienPenunjang/index', $arr));


            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => Params::MODUL_ID_BILLINGKASIR),
            ));

            PendaftaranT::model()->updateByPk($pasien->pendaftaran_id, array(
              'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA
            ));
          }
          

          $up = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
          
          //$up->statusperiksa = Params::STATUSPERIKSA_SEDANG_PERIKSA; //RSPMC-492
          //                        $up->statusperiksa = Params::STATUSPERIKSA_SUDAH_DIPERIKSA; //RSPMC-492
          $up->statusperiksa = Params::STATUSPERIKSA_SUDAH_DIPERIKSA;
          $up->update_time = date('Y-m-d H:i:s');
          $up->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          
          // IHS-3299
          //echo '<pre>'; print_r($up->getErrors());exit;
          $up->save();

          


          //                        die;
          
          // echo CJSON::encode($modKunjungan->pasien_id);die;
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pemeriksaan pasien laboratorium " .$modKunjungan->nama_pasien. " berhasil disimpan !");
          $this->redirect(array('index', 'id' => $modKunjungan->pasienmasukpenunjang_id, 'sukses' => 1));
        } else {

          // exit('asdasds');
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data hasil pemeriksaan laboratorium gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback(); var_dump($exc->getMessage()); die;
        Yii::app()->user->setFlash('error', "Data hasil pemeriksaan laboratorium gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
      // exit('111');

    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render('index', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modTindakan' => $modTindakan,
      'dataDetails' => $dataDetails,
      'modAnamnesa' => $modAnamnesa,
      'modPemeriksaan' => $modPemeriksaan,
      'modPasienMorbiditas' => $modPasienMorbiditas,
    ));
  }


  protected function broadcastNotifHasilPemeriksaan($judul, $isi, $pasien, $modul)
  {

    $link = null;


    // var_dump($pasien->instalasiasal_id); die;

    // rawat jalan
    if ($pasien->instalasiasal_id == Params::INSTALASI_ID_RJ) {
      $link = Yii::app()->createUrl('/rawatJalan/daftarPasien/index', array(
        'RJInfokunjunganrjV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RJInfokunjunganrjV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'RJInfokunjunganrjV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'RJInfokunjunganrjV[nama_pasien]'=>$model->pasien->nama_pasien,
        //'RJInfokunjunganrjV[no_rekam_medik]'=>$model->pasien->no_rekam_medik,
        'RJInfokunjunganrjV[ceklis]' => false,
        'RJInfokunjunganrjV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RJInfokunjunganrjV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran))
      ));
    }

    if ($pasien->instalasiasal_id == Params::INSTALASI_ID_RD) {
      $link = Yii::app()->createUrl('/rawatDarurat/DaftarPasien/Index', array(
        'RDInfoKunjunganRDV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RDInfoKunjunganRDV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RDInfoKunjunganRDV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'RDInfoKunjunganRDV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'RDInfoKunjunganRDV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'RDInfoKunjunganRDV[nama_pasien]'=>$pasien->pasien->nama_pasien,
        //'RDInfoKunjunganRDV[no_rekam_medik]'=>$pasien->pasien->no_rekam_medik,
        'RDInfoKunjunganRDV[ceklis]' => 0
      ));
    }

    if ($pasien->ruanganasal_id == Params::RUANGAN_ID_VK) {
      $link = Yii::app()->createUrl('/persalinan/DaftarPasien/Index', array(
        'PSInfokunjunganpersalinanV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'PSInfokunjunganpersalinanV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'PSInfokunjunganpersalinanV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'PSInfokunjunganpersalinanV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'PSInfokunjunganpersalinanV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'PSInfokunjunganpersalinanV[nama_pasien]'=>$pasien->pasien->nama_pasien,
        //'PSInfokunjunganpersalinanV[no_rekam_medik]'=>$pasien->pasien->no_rekam_medik,
        'PSInfokunjunganpersalinanV[ceklis]' => 0
      ));
    }


    if ($pasien->instalasiasal_id == Params::INSTALASI_ID_HD) {
      $link = Yii::app()->createUrl('/hemodialisa/DaftarPasien/index', array(
        'HDInfoKunjunganRDV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'HDInfoKunjunganRDV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'HDInfoKunjunganRDV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'HDInfoKunjunganRDV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'HDInfoKunjunganRDV[ceklis]' => 0,
        //'HDInfoKunjunganRDV[no_rekam_medik]'=>$model->pasien->no_rekam_medik,
        'HDInfoKunjunganRDV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'HDInfoKunjunganRDV[nama_pasien]'=>$model->pasien->nama_pasien,
      ));
    }
    //        echo $link; die;

    if ($pasien->instalasiasal_id == Params::INSTALASI_ID_RI) {
      $link = Yii::app()->createUrl('/rawatInap/PasienRawatInap/Index', array(
        'RIInfopasienmasukkamarV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RIInfopasienmasukkamarV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RIInfopasienmasukkamarV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'RIInfopasienmasukkamarV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'RIInfopasienmasukkamarV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'RIInfopasienmasukkamarV[nama_pasien]' => $model->pasien->nama_pasien,
        //'RIInfopasienmasukkamarV[no_rekam_medik]' => $pasien->pasien->no_rekam_medik,
        'RIInfopasienmasukkamarV[prefix_pendaftaran]' => substr($pasien->no_pendaftaran, 0, 2),
        'RIInfopasienmasukkamarV[ruangan_id]' => $pasien->ruangan_id,
        'RIInfopasienmasukkamarV[ceklis]' => '',
        'RIInfopasienmasukkamarV[ceklisAdmisi]' => '',
        'RIInfopasienmasukkamarV[is_nursestation]' => '',
      ));
    }

    if ($pasien->instalasiasal_id == Params::INSTALASI_ID_ICU) {
      $link = Yii::app()->createUrl('/perawatanIntensif/PasienRawatIntensif/Index', array(
        'PIInfopasienmasukkamarV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'PIInfopasienmasukkamarV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'PIInfopasienmasukkamarV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'PIInfopasienmasukkamarV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'PIInfopasienmasukkamarV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'PIInfopasienmasukkamarV[nama_pasien]' => $model->pasien->nama_pasien,
        //'PIInfopasienmasukkamarV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
        'PIInfopasienmasukkamarV[prefix_pendaftaran]' => substr($pasien->no_pendaftaran, 0, 2),
        'PIInfopasienmasukkamarV[ruangan_id]' => $pasien->ruangan_id,
        'PIInfopasienmasukkamarV[ceklis]' => '',
        'PIInfopasienmasukkamarV[ceklisAdmisi]' => '',
        'PIInfopasienmasukkamarV[is_nursestation]' => '',
      ));
    }

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $pasien->instalasiasal_id, 'ruangan_id' => $pasien->ruanganasal_id, 'modul_id' => $modul->modul_id, 'link_proses' => $link),
    ));


    //        echo $link; die;

  }

  /**
   * set form hasil pemeriksaan
   * @param type $pasienmasukpenunjang_id
   * @param type $frame
   * @param type $caraPrint
   */
  public function actionPrint($pasienmasukpenunjang_id, $frame = null, $caraPrint = null)
  {
    if ($frame == 1) {
      $this->layout = '//layouts/iframe';
    } else {
      $this->layout = '//layouts/printWindows';
    }

    $format = new MyFormatter();
    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    //asumsi hasilpemeriksaanlab_t 1-1 pasienmasukpenunjang_t
    $modKunjungan = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modDetailHasilPemeriksaans = array(); //$this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);
    $modDetailPeriksa = LBDetailHasilPemeriksaanLabT::model()->findByAttributes(array('hasilpemeriksaanlab_id' => $modHasilPemeriksaan->hasilpemeriksaanlab_id), array('order' => 'detailhasilpemeriksaanlab_id desc'));
    // $data = array();
    $data2 = array();

    $sys = TrxSysRes::model()->findByAttributes(array(
      'ono'=>$modHasilPemeriksaan->hasilpemeriksaanlab_id
    ));
    $sysdata = TrxSysResDt::model()->findAllByAttributes(array(
      'ono'=>$modHasilPemeriksaan->hasilpemeriksaanlab_id
    ), array(
      'order'=>'disp_seq asc'
    ));

    if (!empty($sys)) {
      $modHasilPemeriksaan->catatanlabklinik = $sys->comment;
      $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH;
      $modHasilPemeriksaan->save(false);
    }

    $id_jenis_base = 1;
    $arr_jenis = array();
    $cnt = 1;
    foreach ($sysdata as $dt) {
      if (empty($arr_jenis[$dt->test_group])) {
        $arr_jenis[$dt->test_group] = $id_jenis_base++;
      }

      $id_jenis = $arr_jenis[$dt->test_group];
      $dtperiksa = $dt->order_testid;
      $kelompokdet = $dt->test_nm;
      $nilairujukan_id = $dt->disp_seq;

      if ($dt->data_typ == "ST" && !empty($dt->result_value)) {
        $dt->test_nm .= " : ".$dt->result_value;
      }

      $dt->result_value .= $dt->result_ft;

      $data2["$id_jenis"]["jenispemeriksaanlab_nama"] = $dt->test_group;
      $data2["$id_jenis"]["jenispemeriksaanlab_id"] = $id_jenis;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->order_testnm;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->order_testid;

      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->test_cd;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->disp_seq;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $kelompokdet;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->test_nm;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->result_value;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = "";
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = "";
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->ref_range;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['status'] = $dt->flag;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['tipe'] = $dt->data_typ;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['metode'] = $dt->test_comment;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['satuan'] = $dt->unit;
      
      // var_dump($dt->attributes);

    }

    
    $modHasilLis = [];
    $modOrderLis = LaborderlisV::model()->findByAttributes(['no_masukpenunjang' => $modKunjungan->no_masukpenunjang]);
    if(!empty($modOrderLis)) {
      $modHasilLis = LisR::model()->findAllByAttributes(['his_reg_no' => $modOrderLis->ordernumber]);
    }

    $this->render('printHasilPemeriksaan', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'modDetailPeriksa'=> $modDetailPeriksa,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint,
      'data' => $data2,
      'modHasilLis' => $modHasilLis
    ));
  }
  /**
   * set form hasil pemeriksaan Patologi Anatomi
   * @param type $pasienmasukpenunjang_id
   * @param type $frame
   * @param type $caraPrint
   */
  public function actionPrintPA($pasienmasukpenunjang_id, $frame = null, $caraPrint = null)
  {
    if ($frame == 1) {
      $this->layout = '//layouts/iframe';
    } else {
      $this->layout = '//layouts/printWindows';
    }
    $format = new MyFormatter();
    $judulLaporan = "Hasil Pemeriksaan Patologi Anatomi";
    $modKunjungan = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modHasilPemeriksaanPAs = $this->loadHasilPemeriksaanPAs($modKunjungan);
    $this->render('printHasilPemeriksaanPA', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaanPAs' => $modHasilPemeriksaanPAs,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint,
    ));
  }

  /**
   * load LBDetailHasilPemeriksaanLabT
   * @param type $modHasilPemeriksaan
   */
  public function loadDetailHasilPemeriksaans($modHasilPemeriksaan)
  {
    $criteria = new CDbCriteria();
    $criteria->join = "
                        JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
						JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id  
                        JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                        JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
    $criteria->order = "jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    //$criteria->order = "pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = LBDetailHasilPemeriksaanLabT::model()->findAll($criteria);

    

    return $modDetailHasilPemeriksaans;
  }
  /**
   * load LBHasilPemeriksaanPAT
   * @param type $modPasienMasukPenunjang
   * @return type
   */
  public function loadHasilPemeriksaanPAs($modPasienMasukPenunjang)
  {
    $criteria = new CDbCriteria();
    $criteria->join = "JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id";
    $criteria->addCondition('t.pasienmasukpenunjang_id = ' . $modPasienMasukPenunjang->pasienmasukpenunjang_id);
    $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC";
    $modHasilPemeriksaanPAs = LBHasilPemeriksaanPAT::model()->findAll($criteria);
    return $modHasilPemeriksaanPAs;
  }
  /**
   * simpan LBDetailHasilPemeriksaanLabT
   * @param type $post
   * @return type
   */
  public function ubahDetailHasilPemeriksaanLab($post)
  {
    $modDetailHasilPemeriksaans = LBDetailHasilPemeriksaanLabT::model()->findByPk($post['detailhasilpemeriksaanlab_id']);
    $modDetailHasilPemeriksaans->hasilpemeriksaan = $post['hasilpemeriksaan'];
    $modDetailHasilPemeriksaans->update_time = date("Y-m-d H:i:s");
    $modDetailHasilPemeriksaans->update_loginpemakai_id = Yii::app()->user->id;
    $modDetailHasilPemeriksaans->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($modDetailHasilPemeriksaans->validate()) {
      $modDetailHasilPemeriksaans->update();
    } else {
      $this->hasilpemeriksaantersimpan &= false;
    }
    return $modDetailHasilPemeriksaans;
  }
  /**
   * simpan LBHasilPemeriksaanPAT
   * @param type $post
   * @return type
   */
  public function ubahHasilPemeriksaanPA($post)
  {
    $modHasilPemeriksaanPA = LBHasilPemeriksaanPAT::model()->findByPk($post['hasilpemeriksaanpa_id']);
    $modHasilPemeriksaanPA->attributes = $post;
    $modHasilPemeriksaanPA->tglperiksapa = MyFormatter::formatDateTimeForDB($modHasilPemeriksaanPA->tglperiksapa);
    $modHasilPemeriksaanPA->makroskopis = $post['makroskopis'] ?? null;
    $modHasilPemeriksaanPA->mikroskopis = $post['mikroskopis'] ?? null;
    $modHasilPemeriksaanPA->kesimpulanpa = $post['kesimpulanpa'] ?? null;
    $modHasilPemeriksaanPA->saranpa = $post['saranpa'] ?? null;
    $modHasilPemeriksaanPA->catatanpa = $post['catatanpa'] ?? null;
    $modHasilPemeriksaanPA->update_time = date("Y-m-d H:i:s");
    $modHasilPemeriksaanPA->update_loginpemakai_id = Yii::app()->user->id;
    $modHasilPemeriksaanPA->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modHasilPemeriksaanPA->statushasilperiksapa = "SUDAH";
    // var_dump($modHasilPemeriksaanPA->attributes); die;
    if ($modHasilPemeriksaanPA->validate()) {
      $modHasilPemeriksaanPA->update();
    } else {
      $this->hasilpemeriksaantersimpan &= false;
    }
    return $modHasilPemeriksaanPA;
  }

  /**
   * set form hasil pemeriksaan
   */
  public function actionSetFormHasilPemeriksaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rows = "";
      //asumsi hasilpemeriksaanlab_t 1-1 pasienmasukpenunjang_t
      $modHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']));
      $hasilPemeriksaan = array();
      $attributes = $modHasilPemeriksaan->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $hasilPemeriksaan["$attribute"] = $modHasilPemeriksaan->$attribute;
      }
      $hasilPemeriksaan['tglhasilpemeriksaanlab'] = date('d/m/Y H:i:s', strtotime($modHasilPemeriksaan->tglhasilpemeriksaanlab));
      $hasilPemeriksaan['tglpengambilanhasil'] = date('d/m/Y H:i:s', strtotime($modHasilPemeriksaan->tglpengambilanhasil));

      $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);
      $rows = $this->renderPartial("_rowsHasilPemeriksaan", array('modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans), true);
      echo CJSON::encode(array(
        'hasilPemeriksaan' => $hasilPemeriksaan,
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }
  /**
   * set form hasil pemeriksaan patologi anatomi
   */
  public function actionSetFormHasilPemeriksaanPA()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($_POST['pasienmasukpenunjang_id']);
      $dataHasilPemeriksaanPAs = $this->loadHasilPemeriksaanPAs($modPasienMasukPenunjang);
      $rows = $this->renderPartial("_rowsHasilPemeriksaanPA", array('format' => $format, 'dataHasilPemeriksaanPAs' => $dataHasilPemeriksaanPAs), true);
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * mengenerate riwayat anamnesa
   */
  public function actionSetRiwayatAnamnesa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
      $modPasienMasukPenunjang = LBPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
      $anamnesa = LBAnamnesaT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
      if (!empty($anamnesa)) {
        $modAnamnesa = $anamnesa;
      } else {
        $modAnamnesa = new LBAnamnesaT();
        $modAnamnesa->pendaftaran_id = $pendaftaran_id;
      }
      $modAnamnesa->pendaftaran_id = $modAnamnesa->pendaftaran_id;
      $rows .= $this->renderPartial("laboratorium.views.pencatatanHasilPemeriksaan._riwayatAnamnesa", array('i' => 0, 'modAnamnesa' => $modAnamnesa), true);
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * mengenerate riwayat pemeriksaan fisik
   */
  public function actionSetRiwayatPemeriksaanFisik()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
      $modPasienMasukPenunjang = LBPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
      $periksafisik = LBPemeriksaanfisikT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
      if (!empty($periksafisik)) {
        $modPemeriksaan = $periksafisik;
      } else {
        $modPemeriksaan = new LBPemeriksaanfisikT;
        $modPemeriksaan->pendaftaran_id = $pendaftaran_id;
      }
      $rows .= $this->renderPartial("laboratorium.views.pencatatanHasilPemeriksaan._riwayatPemeriksaanFisik", array('i' => 0, 'modPemeriksaan' => $modPemeriksaan), true);
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * mengenerate riwayat diagnosa
   */
  public function actionSetRiwayatDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
      $modPasienMasukPenunjang = LBPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
      $modPasienMorbiditas = new LBPasienmorbiditasT();
      $rows .= $this->renderPartial("laboratorium.views.pencatatanHasilPemeriksaan._riwayatDiagnosa", array('i' => 0, 'modPasienMorbiditas' => $modPasienMorbiditas, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang), true);
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * set tindakan pelayanan     
   */
  public function actionSetTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $drop = '<option value="">-- Pilih --</option>';

      $modTindakans = LBTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {

          $pemeriksaan = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id));
          if (!empty($pemeriksaan)) {
            $modTindakan->pemeriksaanlab_id = $pemeriksaan->pemeriksaanlab_id;
            $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
            $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
            $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
            $modTindakan->tarif_satuan = $format->formatNumberForUser($modTindakan->tarif_satuan);

            $rows .= $this->renderPartial($this->path_view_pendaftaran . "_rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $modTindakan), true);
          }
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows,
        'drop' => $drop,
      ));
    }
    Yii::app()->end();
  }

  public function actionCekTandaTanganDigital() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $pegawai_id = Yii::app()->user->getState('pegawai_id');
    $peg = PegawaiM::model()->findByPk($pegawai_id);

    if (empty($peg) || empty($peg->nomobile_pegawai)) {
      echo CJSON::encode(array(
        'ok'=>0,
        'msg'=>'Anda harus memiliki Nomor Mobile untuk melakukan ini.'
      ));

      Yii::app()->end();
    }

    $model1 = TtdelktronikpegawaiskT::model()->findByAttributes(array(
      'pegawai_id'=>$pegawai_id,
    ));

    if (empty($model1)) {
      echo CJSON::encode(array(
        'ok'=>0,
        'msg'=>'Pegawai tidak tercantum pada SK Direktur Tanda Tangan Elektronik'
      ));

      Yii::app()->end();
    }

    $cr = new CDbCriteria;
    $cr->compare('pegawai_id', $pegawai_id);
    $cr->addCondition("tglberlaku_akhir::date >= current_date");
    $cr->order = "tglberlaku_awal asc";

    $model2 = TtdelktronikpegawaiskT::model()->find($cr);

    if (empty($model2)) {
      echo CJSON::encode(array(
        'ok'=>0,
        'msg'=>'Masa Berlaku Sk Direktur Tanda Tangan Elektronik Anda sudah berakhir, Silahkan perbaharui ke Bagian Kepegawaian.'
      ));

      Yii::app()->end();
    }

    $pass = Yii::app()->user->getState('otp_kode');
    $limit = Yii::app()->user->getState('otp_limit');
    $generate_baru = 0;

    if (!empty($pass)) {
      if (time() > $limit) {
        $generate_baru = 1;
      }
    } else {
      $generate_baru = 1;
    }

    if ($generate_baru) {
      $res = OPTTTD::generateOTP();
      
    
    

      if ($res === false) {
        echo CJSON::encode(array(
          'ok'=>0,
          'msg'=>'Anda harus login.'
        ));

        Yii::app()->end();
      }

      $wa = new WhatsApp;
      $wa->kirimIndividu($peg->nomobile_pegawai, "Kode OTP Verifikasi eSign Anda adalah ".$res['kode'].". OTP akan kadaluarsa dalam 2 menit.");

      $limit = strtotime('+2 minutes');
      $pass = Yii::app()->user->getState('otp_kode');
      Yii::app()->user->setState('otp_limit', $limit);

      // kirim pesan


      // var_dump($peg->attributes); die;

    }
    echo CJSON::encode(array(
      'ok'=>1,
      'no_telp'=>$peg->nomobile_pegawai,
      'counter_baru'=>1,
      'limit'=>empty($limit) ? 0 : $limit - time(),
    ));

  }

  public function actionVerifikasiTandaTanganDigital() {

    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $ok = 1;
    $msg = "Proses berhasil dilakukan.";

    $verifikasi = $_POST['verifikasi'];
    $id = $_POST['id'];

    $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));


    // /*
    $ok2 = OPTTTD::veifikasiOTP($verifikasi);

    if ($ok2 == 2) {
      $ok = 0;
      $msg = "Masa OTP sudah Habis, harap generate ulang.";
      goto out;
    } else if ($ok2 == 1) {
      $ok = 0;
      $msg = "Verifikasi tidak Valid.";
      goto out;
    }
    // */


    $trans = Yii::app()->db->beginTransaction();
    $oktrans = true;
    try {
      $model = new TandatangandigitalT;
      $model->profilrs_id = Yii::app()->user->getState('profilrs_id');
      $model->create_time = $model->update_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai = $model->update_loginpemakai = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->create_petugaspengisi_id = Yii::app()->user->getState('pegawai_id');

      // hitung no seri
      $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
        'pasienmasukpenunjang_id'=>$id,
      ));
      $hasil = HasilpemeriksaanlabT::model()->findByAttributes(array(
        'pasienmasukpenunjang_id'=>$id,
      ));

      $serial = "No. RM : ".$penunjang->no_rekam_medik.", No. Masuk Penunjang : ".$penunjang->no_masukpenunjang
      .", No. Pendaftaran : ".$penunjang->no_pendaftaran.", ".$hasil->create_time.", 1";

      $serial_hasil = Yii::app()->db
              ->createCommand("select encode(pgp_sym_encrypt('".$serial."','ttd_innova_".$pegawai->nomobile_pegawai.$pegawai->pegawai_id."','compress-algo=1, cipher-algo=aes256'),'BASE64') as simpan")
              ->queryRow();

      $model->no_seri = $serial_hasil['simpan'];
      
      
      
      $arr_seri = explode("\n", $model->no_seri);

      $nama_file = "hasil_periksa_lab-".time()."-".strtolower(str_replace(" ", "_", $penunjang->nama_pasien)).".pdf";
      //var_dump($nama_file); die;

      // generate PDF
      $this->printPDF($id, $nama_file);

      $model->nama_file = $nama_file;
      $model->path_file = Params::pathHasilPeriksaLab().$nama_file;

      // simpan data
      if ($model->validate()) {
        $oktrans = $oktrans && $model->save();
      } else {
        $oktrans = false;
      }

      $cr = new CDbCriteria;
      $cr->compare('pegawai_id', Yii::app()->user->getState('pegawai_id'));
      $cr->addCondition("tglberlaku_akhir::date >= current_date");
      $cr->order = "tglberlaku_awal asc";

      $sk = TtdelktronikpegawaiskT::model()->find($cr);

      // detail
      $det = new TandatangandigitaldetT();
      $det->attributes = $model->attributes;
      $det->user_agent = $_SERVER['HTTP_USER_AGENT']." - ".$_SERVER['SERVER_ADDR'];
      $det->nama_pegawai = Yii::app()->user->getState('nama_pegawai');
      $det->nip_pegawai = Yii::app()->user->getState('nomorindukpegawai');
      $det->nomor_sk = $sk->nomor_sk;
      $det->kode_otp = $verifikasi;
      $det->nomobile_verifikasi = $pegawai->nomobile_pegawai;
      $det->verifikasi_sebagai = $pegawai->jabatan->jabatan_nama ?? "-";

      // var_dump($det->attributes); die;

      if ($det->validate()) {
        $oktrans = $oktrans && $det->save();
      } else {
        $oktrans = false;
      }

      $hasil->tandatangandigital_id = $det->tandatangandigital_id;
      $oktrans = $oktrans && $hasil->save();

      // var_dump($_SERVER);


      // var_dump($oktrans, $det->attributes, $sk->attributes, $model->attributes);
      // die;

      if ($oktrans) {
        $trans->commit();
        $msg = "Verifikasi berhasil dilakukan.";
      } else {
        $trans->rollback();
        $ok = 0;
        $msg = "Verifikasi gagal dilakukan.";
      }

    } catch (CException $ex) {
      $ok = 0;
      $msg = "Gagal dilakulkan verifikasi. ".$ex->getMessage();
    }

    out:
    echo CJSON::encode(array(
      'ok'=>$ok,
      'msg'=>$msg,
    ));
  }


  /**
   * set form hasil pemeriksaan
   * @param type $pasienmasukpenunjang_id
   * @param type $frame
   * @param type $caraPrint
   */
  public function printPDF($pasienmasukpenunjang_id, $nama_file)
  {
    $format = new MyFormatter();
    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    //asumsi hasilpemeriksaanlab_t 1-1 pasienmasukpenunjang_t
    $modKunjungan = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);

    $data = array();


    foreach ($modDetailHasilPemeriksaans as $dt) {
      $jenispemeriksaanlab_id = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
      $kelompokdet = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
      $nilairujukan_id = $dt->pemeriksaandetail->nilairujukan_id;
      $dtperiksa = $dt->pemeriksaanlab_id . $dt->tindakanpelayanan_id;
      //	if (isset($data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"])){
      //	$total = $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"] = $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"] + 1;
      //	}else{
      //	$total = 1;
      //	}


      $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_nama"] = $dt->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
      $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_id"] = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->pemeriksaanlab->pemeriksaanlab_nama;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->pemeriksaanlab_id;
      /*$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"] = $total;			
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;			
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;			
			$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama.' '.(($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-')?$dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan:'');									*/
      //change
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;
      //$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"]['total'] = $kelompokdet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_min;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_max;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama . ' ' . (($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-') ? $dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan : '');
    }

    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    //$mpdf->useOddEven = 2;
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    //$mpdf->WriteHTML($style, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
    $mpdf->WriteHTML($this->renderPartial('printHasilPemeriksaan', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => 'PRINT',
      'data' => $data
    ), true));
    $mpdf->Output(Params::pathHasilPeriksaLab().$nama_file, "F");
    
    
  }

  public function actionGetInfoTTD() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];

    $hasil = HasilpemeriksaanlabT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id'=>$id,
    ));

    if (!empty($hasil->tandatangandigital_id)) {
      $ttd = TandatangandigitalT::model()->findByPk($hasil->tandatangandigital_id);
      $ttddet = TandatangandigitaldetT::model()->findByAttributes(array(
        'tandatangandigital_id'=>$hasil->tandatangandigital_id,
      ));


      $str = Yii::app()->user->getState('nama_rumahsakit')." Menyatakan bahwa : <br/><br/>";
      $str .= "Dokumen dengan judul : ".$ttd->nama_file."<br/><br/>";
      $str .= "No. Seri : ".$ttd->no_seri."<br/><br/>";
      $str .= "Telah ditandatangani oleh Pihak Rumah Sakit sebagai Berikut :<br/>";
      $str .= "<strong>";
      $str .= $ttddet->verifikasi_sebagai." - ".$ttddet->nama_pegawai." - ".$ttddet->user_agent." ";
      $str .= "pada ".MyFormatter::formatDateTimeForUser($ttd->create_time)." ";
      $str .= "No. SK Direktur Izin Tanda Tangan Elektronik : ".$ttddet->nomor_sk."<br/><br/>";
      $str .= "</strong>";
      $str .= "Benar dan tercatat dalam audit trail kami.";

      // var_dump($ttd->attributes, $ttddet->attributes); die;

      echo $str;
    }

  }

}
