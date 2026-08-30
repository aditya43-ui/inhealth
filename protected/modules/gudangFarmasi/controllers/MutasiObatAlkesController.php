<?php

class MutasiObatAlkesController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.mutasiObatAlkes.';
  public $path_oa = 'gudangFarmasi.views.mutasiObatAlkes.';

  public $mutasidetailtersimpan = true; //looping
  public $stokobatalkestersimpan = true; //looping
  public $succesSave = true; //looping
  public $pesan = "";

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionIndex($mutasioaruangan_id = null, $pesanobatalkes_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Mutasi Obat Alkes";
    $modPemesanan = new InformasipesanobatalkesV;
    $model = new GFMutasioaruanganT;
    $format = new MyFormatter;

    //$model->instalasitujuan_id = Params::INSTALASI_ID_FARMASI;
    $modDetails = array();
    $modStoks = array();
    $modelPesanObat = array();
    $pesan = '';
    $instalasiTujuans = CHtml::listData(GFInstalasiM::getInstalasiTujuanMutasis(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($model->instalasitujuan_id), 'ruangan_id', 'ruangan_nama');
    //$ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($model->instalasitujuan_id),'ruangan_id','ruangan_nama');
    // Uncomment the following line if AJAX validation is needed

    // Error :Array to String
    if (!empty($mutasioaruangan_id)) {
      $model = GFMutasioaruanganT::model()->findByPk($mutasioaruangan_id);
      $model->instalasitujuan_id = $model->ruangantujuan->instalasi_id;
      $model->pegawaimengetahui_nama = (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : "");
      $ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($model->instalasitujuan_id), 'ruangan_id', 'ruangan_nama');
      $modDetails = $this->loadModelDetails($model->mutasioaruangan_id);
      if (isset($model->pesanobatalkes_id)) {
        $modPemesanan = InformasipesanobatalkesV::model()->findByAttributes(array('mutasioaruangan_id' => $mutasioaruangan_id));
        $modPemesanan->tglpemesanan = MyFormatter::formatDateTimeForUser($modPemesanan->tglpemesanan);
      }
    }
    if (!empty($pesanobatalkes_id)) {

      if (empty($mutasioaruangan_id)) {

        $this->setReferrer();


        $modelPesanObat = GFPesanobatalkesT::model()->findByPk($pesanobatalkes_id);
        if (!empty($modelPesanObat)) {
          $r = RuanganM::model()->findByPk($modelPesanObat->ruanganpemesan_id);
          $model->ruangantujuan_id = $modelPesanObat->ruanganpemesan_id;
          $model->instalasitujuan_id = $r->instalasi_id;

          $instalasiTujuans = CHtml::listData(GFInstalasiM::getInstalasiTujuanMutasis(), 'instalasi_id', 'instalasi_nama');
          $ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($model->instalasitujuan_id), 'ruangan_id', 'ruangan_nama');


          $modDetailPesan = GFPesanoadetailT::model()->findAllByAttributes(array('pesanobatalkes_id' => $pesanobatalkes_id));
          $ruangan_id = Yii::app()->user->getState('ruangan_id');
          $totalharganetto = 0;
          $totalhargajual = 0;
          if (count((array)$modDetailPesan) > 0) {
            $ii = 0;
            foreach ($modDetailPesan as $a => $detail) {
              $oa = ObatalkesM::model()->findByPk($detail->obatalkes_id);

              $modDetails[$ii] = new GFMutasioadetailT();
              $modDetails[$ii]->stokobatalkes_id = null; //$stok->stokobatalkes_id;
              $modDetails[$ii]->jmlmutasi = $detail->jmlpesan; //$stok->qtystok_terpakai;
              $modDetails[$ii]->jmlpesan = $detail->jmlpesan; //$stok->qtystok_terpakai;
              $modDetails[$ii]->harganetto = $oa->harganetto; //$stok->HPP;
              $modDetails[$ii]->hargajualsatuan = $oa->hargajual; //$stok->HargaJualSatuan;
              $modDetails[$ii]->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
              $modDetails[$ii]->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
              $modDetails[$ii]->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
              $modDetails[$ii]->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;
              $modDetails[$ii]->tglkadaluarsa = $oa->tglkadaluarsa; //$format->formatDateTimeForUser($stok->tglkadaluarsa);
              //$modDetails[$ii]->jmlstok = 0; //$stok->qtystok;
              $modDetails[$ii]->jmlstok = $oa->stokObatRuangan; //$stok->qtystok;//$oa->StokObatRuangan
              $modDetails[$ii]->tglterima = $format->formatDateTimeForUser(date('Y-m-d H:i:s'));
              $modDetails[$ii]->pesanoadetail_id = $detail->pesanoadetail_id;
              $totalharganetto += $modDetails[$ii]->harganetto;
              $totalhargajual += $modDetails[$ii]->hargajualsatuan;
              $ii++;
              // }
              // }else{
              //     $pesan = "Stok obat ".$detail->obatalkes->obatalkes_nama." tidak mencukupi!";
              // }
            }
          }

          $model->pesanobatalkes_id = $modelPesanObat->pesanobatalkes_id;
          $model->totalharganettomutasi = ($totalharganetto);
          $model->totalhargajual = ($totalhargajual);

          $Pemesan = InformasipesanobatalkesV::model()->findByAttributes(array('nopemesanan' => $modelPesanObat->nopemesanan));
          $modPemesanan->nopemesanan = $Pemesan->nopemesanan;
          $modPemesanan->tglpemesanan = $Pemesan->tglpemesanan;
          $modPemesanan->ruanganpemesan_id = $Pemesan->ruanganpemesan_id;
          $modPemesanan->ruanganpemesan_nama = $Pemesan->ruanganpemesan_nama;
          $modPemesanan->pegawaipemesan_id = $Pemesan->pegawaipemesan_id;
          $modPemesanan->pegawaipemesan_nama = $Pemesan->pegawaipemesan_nama;
          $modPemesanan->tglpemesanan = MyFormatter::formatDateTimeForUser($modPemesanan->tglpemesanan);
        }
      }
    } else {
      $this->cleanReferrer();
    }

    if (isset($_POST['GFMutasioaruanganT'])) {
      
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['GFMutasioaruanganT'];
        $model->tglmutasioa = date("Y-m-d H:i:s");
        $model->nomutasioa = MyGenerator::noMutasi();
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->pegawaimutasi_id = Yii::app()->user->getState('pegawai_id');
        $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
        if (isset($totalharganetto)){
            $model->totalharganettomutasi = ($totalharganetto);
        }
        if (isset($totalhargajual)){
            $model->totalhargajual = ($totalhargajual);
        }
        // var_dump($model->attributes); die;

        if ($model->save()) {
          if (!empty($model->pesanobatalkes_id)) {
            PesanobatalkesT::model()->updateByPk($model->pesanobatalkes_id, array('mutasioaruangan_id' => $model->mutasioaruangan_id));
          }
          if (isset($_POST['GFMutasioadetailT'])) {
            if (count((array)$_POST['GFMutasioadetailT']) > 0) {
              //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
              $detailGroups = array();
              foreach ($_POST['GFMutasioadetailT'] as $i => $postDetail) {
                $modDetails[$i] = new GFMutasioadetailT;
                $modDetails[$i]->attributes = $postDetail;
                //$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                $modDetails[$i]->stokobatalkes_id = null; //$modStok->stokobatalkes_id;
                //$modDetails[$i]->tglterima = $modStok->tglterima;
                $modDetails[$i]->pesanoadetail_id = $postDetail['pesanoadetail_id'];
                //$obatalkes_id = $postDetail['obatalkes_id'];
                $modDetails[$i] = $this->simpanMutasiDetail2($model, $postDetail);
                $this->simpanStokObatAlkesOut2($modDetails[$i]);
                /*
                                if(isset($detailGroups[$obatalkes_id])){
                                    $detailGroups[$obatalkes_id]['jmlmutasi'] += $postDetail['jmlmutasi'];
                                }else{
                                    $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                                    $detailGroups[$obatalkes_id]['jmlmutasi'] = $postDetail['jmlmutasi'];
                                }*/
              }
              //END GROUP
            } /*
                        $obathabis = "";
                        //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                        foreach($detailGroups AS $i => $detail){
                            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['jmlmutasi'], Yii::app()->user->getState('ruangan_id'));
                            if(count((array)$modStokOAs) > 0){
                                foreach($modStokOAs AS $i => $stok){
                                    $modDetails[$i] = $this->simpanMutasiDetail($model, $stok);
                                    $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                                }
                            }else{
                                $this->stokobatalkestersimpan &= false;
                                $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                            }
                        } */

            //var_dump($this->mutasidetailtersimpan && $this->stokobatalkestersimpan);
            //die;
            $this->insertNotifMutasi($model);


            // perjurnalan
            if (Yii::app()->user->getState('isjurnalotomatis') == true) {
              $modDetailMutasi = MutasioadetailT::model()->findAllByAttributes(array('mutasioaruangan_id' => $model->mutasioaruangan_id));

              if (count((array)$modDetailMutasi) > 0) {
                foreach ($modDetailMutasi as $detailMutasi) {
                  $barang = ObatalkesM::model()->findByPk($detailMutasi->obatalkes_id);

                  if (isset($barang)) {
                    $modJnsObatalkesRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id' => $barang->jenisobatalkes_id, 'ismutasioa' => true, 'ruangan_id' => $model->ruangantujuan_id));
                    if (count((array)$modJnsObatalkesRek) > 0) {
                      $modJurnalRekening = $this->saveJurnalRekening($model, $detailMutasi);

                      foreach ($modJnsObatalkesRek as $jnsoaRek) {
                        $this->saveJurnalDetail($modJurnalRekening, $detailMutasi, $jnsoaRek);
                      }
                      $this->mutasidetailtersimpan = $this->succesSave;
                    }
                  }
                }
              }
            }
            // var_dump($this->mutasidetailtersimpan, $this->stokobatalkestersimpan); die;
            if ($this->mutasidetailtersimpan && $this->stokobatalkestersimpan) {
              $transaction->commit();
              $sukses = 1;
              $this->redirect(array('index', 'mutasioaruangan_id' => $model->mutasioaruangan_id, 'pesanobatalkes_id' => $pesanobatalkes_id, 'sukses' => $sukses));
            } else {
              $transaction->rollback();
              $model->mutasioaruangan_id = null;
              Yii::app()->user->setFlash('error', "Data detail mutasi obat alkes gagal disimpan !");
              if (!$this->stokobatalkestersimpan) {
                Yii::app()->user->setFlash('error', "Data detail mutasi obat alkes gagal disimpan ! Stok obat berikut tidak mencukupi !:" . $obathabis);
              }
              //                            echo "-".$this->mutasidetailtersimpan."<br>";
              //                            echo "-".$this->stokobatalkestersimpan."<br>";
              //                            exit;
            }
          }
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data mutasi obat alkes gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'modDetails' => $modDetails,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
      'pesan' => $pesan,
      'modelPesanObat' => $modelPesanObat,
      'modPemesanan' => $modPemesanan,
    ));
  }

  public function actionGetPesanObatAlkesDariMutasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPesanObatAlkes = $_POST['idPesanObatAlkes'];
      $modMutasiDetail = new GFMutasioadetailT;
      //$modDetailPesanObatAlkes = PesanoadetailT::model()->with('obatalkes','sumberdana','satuankecil')->findAll('pesanobatalkes_id='.$idPesanObatAlkes.'');
      $modDetailPesanObatAlkes = GFPesanoadetailT::model()->findAllByAttributes(array('pesanobatalkes_id' => $idPesanObatAlkes));
      $modelPesanObat = GFPesanobatalkesT::model()->findByPk($idPesanObatAlkes);
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $format = new MyFormatter;
      $stok = null;
      $totalHargaSub = 0;
      $totalHargaNetto = 0;
      //$totalharganetto = 0;
      //$totalhargajual = 0;
      $tr = "";
      $no = 1;
      $data = array();

      $modDetailPesanObatAlkes = GFPesanoadetailT::model()->findAllByAttributes(array('pesanobatalkes_id' => $idPesanObatAlkes));
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $totalharganetto = 0;
      $totalhargajual = 0;
      if (count((array)$modDetailPesanObatAlkes) > 0) {
        $ii = 0;
        foreach ($modDetailPesanObatAlkes as $a => $detail) {
          $oa = ObatalkesM::model()->findByPk($detail->obatalkes_id);
          //$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail->obatalkes_id, $detail->jmlpesan, $ruangan_id);
          //if(count((array)$modStokOAs) > 0){
          //foreach($modStokOAs AS $i => $stok){
          $modDetails[$ii] = new GFMutasioadetailT();
          $modDetails[$ii]->stokobatalkes_id = null; //$stok->stokobatalkes_id;
          $modDetails[$ii]->jmlmutasi = $detail->jmlpesan; //$stok->qtystok_terpakai;
          $modDetails[$ii]->jmlpesan = $detail->jmlpesan; //$stok->qtystok_terpakai;
          $modDetails[$ii]->harganetto = $oa->hpp; //$stok->HPP;
          $modDetails[$ii]->hargajualsatuan = $oa->hargajual; //$stok->HargaJualSatuan;
          $modDetails[$ii]->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
          $modDetails[$ii]->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
          $modDetails[$ii]->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
          $modDetails[$ii]->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;
          $modDetails[$ii]->tglkadaluarsa = $oa->tglkadaluarsa; //$format->formatDateTimeForUser($stok->tglkadaluarsa);
          //$modDetails[$ii]->jmlstok = 0; //$stok->qtystok;//disini
          $modDetails[$ii]->jmlstok = $oa->stokObatRuangan; //$stok->qtystok;//disini
          $modDetails[$ii]->tglterima = $format->formatDateTimeForUser(date('Y-m-d H:i:s'));
          $modDetails[$ii]->pesanoadetail_id = $detail->pesanoadetail_id;
          $totalharganetto += $modDetails[$ii]->harganetto;
          $totalhargajual += $modDetails[$ii]->hargajualsatuan;
          $ii++;
          // }
          // }else{
          //     $pesan = "Stok obat ".$detail->obatalkes->obatalkes_nama." tidak mencukupi!";
          // }
        }
      }


      foreach ($modDetails as $tampilDetail) {
        $tr .= $this->renderPartial($this->path_view . '_rowMutasiDetail', array('modMutasiDetail' => $tampilDetail, 'pesan' => ""), true);
      };
      $modPesanObatAlkes =  PesanobatalkesT::model()->findByPk($idPesanObatAlkes);
      $data['tr'] = $tr;
      $data['ruangan_id'] = $modPesanObatAlkes->ruanganpemesan_id;
      //if (!empty($stok)) $data['stok'] = $stok;


      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function insertNotifMutasi($model)
  {
    //var_dump($model->attributes); die;

    $ruangan = RuanganM::model()->findByPk($model->ruangantujuan_id);
    $asal = RuanganM::model()->findByPk($model->ruanganasal_id);
    $judul = 'Mutasi Obat Alkes';

    $isi = "Mutasi Asal : " . $asal->ruangan_nama . "<br/>No. Mutasi : ";
    $isi .= CHtml::link($model->nomutasioa, $this->createUrl('print', array(
      'mutasioaruangan_id' => $model->mutasioaruangan_id,
    )), array('target' => '_blank'));

    $link = "";
    if (!empty($ruangan->modul_id)) {
      $modul = ModulK::model()->findByPk($ruangan->modul_id);
      $link = Yii::app()->createUrl($modul->url_modul . "/informasiMutasiMasuk" . $modul->modul_key . "/index", array(
        'GFInformasimutasioaruanganV[tgl_awal]' => date('Y-m-d', strtotime($model->tglmutasioa)),
        'GFInformasimutasioaruanganV[tgl_akhir]' => date('Y-m-d', strtotime($model->tglmutasioa)),
        'GFInformasimutasioaruanganV[nomutasioa]' => $model->nomutasioa,
        'GFInformasimutasioaruanganV[ruanganasalmutasi_id]' => '',
        'GFInformasimutasioaruanganV[instalasiasalmutasi_id]' => '',
        'GFInformasimutasioaruanganV[statuspesan]' => '',
        'GFInformasimutasioaruanganV[status_terima]' => '',
        'GFInformasimutasioaruanganV[pegawaipenerima_id]' => '',
      ));
    }

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id, 'link_proses' => $link),
      array('instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id),
      // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
    ));

    //var_dump($ok); die;
  }

  /**
   * untuk menyimpan MutasioadetailT
   * @param type $modMutasi
   * @param type $postDetail
   */
  protected function simpanMutasiDetail2($modMutasi, $postDetail)
  {
    $modMutasiDetail = new GFMutasioadetailT;
    $modMutasiDetail->attributes = $postDetail;
    $modMutasiDetail->mutasioaruangan_id = $modMutasi->mutasioaruangan_id;
    //$modMutasiDetail->stokobatalkes_id = $modStokOa->stokobatalkes_id;
    //$modMutasiDetail->jmlmutasi = $modStokOa->qtystok_terpakai;
    //$modMutasiDetail->harganetto = $modStokOa->HPP;
    //$modMutasiDetail->hargajualsatuan = $modStokOa->HargaJualSatuan;
    //$modMutasiDetail->sumberdana_id = (isset($modStokOa->penerimaandetail->sumberdana_id) ? $modStokOa->penerimaandetail->sumberdana_id : $modStokOa->obatalkes->sumberdana_id);
    //$modMutasiDetail->obatalkes_id = $modStokOa->obatalkes_id;
    //$modMutasiDetail->tglkadaluarsa = $modStokOa->tglkadaluarsa;
    //$modMutasiDetail->jmlstok = $modStokOa->qtystok;
    //$modMutasiDetail->tglterima = MyFormatter::formatDateTimeForDb($modStokOa->tglterima);
    $modMutasiDetail->tglkadaluarsa = MyFormatter::formatDateTimeForDb($modMutasiDetail->tglkadaluarsa);
    $modMutasiDetail->jmlpesan = (empty($modMutasiDetail->jmlpesan) ? 0 : $modMutasiDetail->jmlpesan);
    $modMutasiDetail->persendiscount = (empty($modMutasiDetail->persendiscount) ? 0 : $modMutasiDetail->persendiscount);
    $modMutasiDetail->totalharga = ($modMutasiDetail->harganetto * $modMutasiDetail->jmlmutasi);
    //$modMutasiDetail->satuankecil_id = $modStokOa->satuankecil_id;

    // var_dump($modMutasiDetail->attributes);

    if ($modMutasiDetail->save()) {
      $this->mutasidetailtersimpan &= true;
    } else {
      $this->mutasidetailtersimpan &= false;
    }
    return $modMutasiDetail;
  }

  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modMutasi
   * @param type $modMutasiDetail
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesOut2($modMutasiDetail)
  {
    $format = new MyFormatter;
    $oa = ObatalkesM::model()->findByPk($modMutasiDetail->obatalkes_id);
    //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modMutasiDetail->attributes; //$modStokOa->attributes; //duplicate
    $modStokOaNew->attributes = $oa->attributes; //$modStokOa->attributes; //duplicate
    //$modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modMutasiDetail->jmlmutasi;
    $modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
    $modStokOaNew->mutasioadetail_id = $modMutasiDetail->mutasioadetail_id;
    // $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = $modStokOaNew->ruangan_id = Yii::app()->user->ruangan_id;
    $modStokOaNew->persenppn = $oa->ppn_persen;
    $modStokOaNew->persenmargin = $oa->margin;

    if (empty($modStokOaNew->tglkadaluarsa)) {
      $modStokOaNew->tglkadaluarsa = date('Y-m-d', strtotime('+1 year'));
    }

    // $modStokOaNew->validate();
    // var_dump($modStokOaNew->errors); die;

    if ($modStokOaNew->validate()) {
      $modStokOaNew->save();

      if (in_array($modStokOaNew->ruangan_id, array(Params::RUANGAN_ID_GUDANG_FARMASI, Params::RUANGAN_ID_APOTEK_1))) {
        StokobatalkesT::notifStokOALewatMinimalRuangan($modStokOaNew->obatalkes_id, $modStokOaNew->ruangan_id);
      }

      // $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  /**
   * untuk menyimpan MutasioadetailT
   * @param type $modMutasi
   * @param type $postDetail
   */
  protected function simpanMutasiDetail($modMutasi, $modStokOa)
  {
    $modMutasiDetail = new GFMutasioadetailT;
    $modMutasiDetail->mutasioaruangan_id = $modMutasi->mutasioaruangan_id;
    $modMutasiDetail->stokobatalkes_id = $modStokOa->stokobatalkes_id;
    $modMutasiDetail->jmlmutasi = $modStokOa->qtystok_terpakai;
    $modMutasiDetail->harganetto = $modStokOa->HPP;
    $modMutasiDetail->hargajualsatuan = $modStokOa->HargaJualSatuan;
    $modMutasiDetail->sumberdana_id = (isset($modStokOa->penerimaandetail->sumberdana_id) ? $modStokOa->penerimaandetail->sumberdana_id : $modStokOa->obatalkes->sumberdana_id);
    $modMutasiDetail->obatalkes_id = $modStokOa->obatalkes_id;
    $modMutasiDetail->tglkadaluarsa = $modStokOa->tglkadaluarsa;
    $modMutasiDetail->jmlstok = $modStokOa->qtystok;
    $modMutasiDetail->tglterima = MyFormatter::formatDateTimeForDb($modStokOa->tglterima);
    $modMutasiDetail->tglkadaluarsa = MyFormatter::formatDateTimeForDb($modMutasiDetail->tglkadaluarsa);
    $modMutasiDetail->jmlpesan = (empty($modMutasiDetail->jmlpesan) ? 0 : $modMutasiDetail->jmlpesan);
    $modMutasiDetail->persendiscount = (empty($modMutasiDetail->persendiscount) ? 0 : $modMutasiDetail->persendiscount);
    $modMutasiDetail->totalharga = ($modMutasiDetail->harganetto * $modMutasiDetail->jmlmutasi);
    $modMutasiDetail->satuankecil_id = $modStokOa->satuankecil_id;

    if ($modMutasiDetail->save()) {
      $this->mutasidetailtersimpan &= true;
    } else {
      $this->mutasidetailtersimpan &= false;
    }
    return $modMutasiDetail;
  }
  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modMutasi
   * @param type $modMutasiDetail
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesOut($stokobatalkesasal_id, $modMutasiDetail)
  {
    $format = new MyFormatter;
    $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modMutasiDetail->jmlmutasi;
    $modStokOaNew->mutasioadetail_id = $modMutasiDetail->mutasioadetail_id;
    $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    if ($modStokOaNew->validateStok()) {
      $modStokOaNew->save();
      $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GFMutasioaruanganT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }
  /**
   * Memanggil data dari model detail.
   * @param integer the ID of the model to be loaded
   */
  public function loadModelDetails($id)
  {
    $criteria = new CdbCriteria();
    $criteria->addCondition('mutasioaruangan_id = ' . $id);
    $criteria->join = "LEFT JOIN stokobatalkes_t ON stokobatalkes_t.mutasioadetail_id = t.mutasioadetail_id";
    $criteria->select = "*, stokobatalkes_t.stokobatalkes_id AS stokobatalkes_id";
    $models = GFMutasioadetailT::model()->findAll($criteria);
    if ($models === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $models;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gfmutasioaruangan-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionAutocompleteNoPemesanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nopemesanan)', strtolower($_GET['term']), true);
      $criteria->addCondition('mutasioaruangan_id is null');
      $criteria->compare('ruangantujuan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'nopemesanan';
      $criteria->limit = 5;
      $models = InformasipesanobatalkesV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['tglpemesanan'] = MyFormatter::formatDateTimeForUser($returnVal[$i]['tglpemesanan']);
        $returnVal[$i]['label'] = $model->nopemesanan;
        $returnVal[$i]['value'] = $model->nopemesanan;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->join = "join ruanganpegawai_m p on p.pegawai_id = t.pegawai_id";
      $criteria->addCondition("p.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' ");
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = GFPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan obat
   * @return row table
   */
  public function actionSetFormMutasiDetail()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $jumlah = $_POST['jumlah'];
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $pesanobatalkes_id = $_POST['pesanobatalkes_id'];
      if (isset($_POST['pesanobatalkes_id'])) {
        if (!empty($_POST['pesanobatalkes_id'])) {
          $modInfoOa = GFInformasipesanobatalkesV::model()->findByAttributes(array('pesanobatalkes_id' => $pesanobatalkes_id));
          $ruangan_id = $modInfoOa->ruanganpemesan_id; //RSN-332
        }
      }

      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modMutasiDetail = new GFMutasioadetailT;
      $oa = ObatalkesM::model()->findByPk($obatalkes_id);
      $jmlStok = $oa->stokObatRuangan;
      //			$tglKadaluarsaStok = StokobatalkesT::getTanggalKadaluarsaBerdasarkanStok($obatalkes_id, $ruangan_id);
      $criteria = new CDbCriteria();
      $criteria->select = "tglkadaluarsa";
      $criteria->compare('obatalkes_id', $obatalkes_id);
      $criteria->addCondition("ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'tglterima DESC';
      $tglKadaluarsaRuangan = StokobatalkesT::model()->find($criteria);

      //var_dump($tglKadaluarsaStok);die;
      //$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      //if(count((array)$modStokOAs) > 0){
      $totalharganetto = 0;
      $totalhargajual = 0;
      //    foreach($modStokOAs AS $i => $stok){
      $modMutasiDetail->stokobatalkes_id = null; //$stok->stokobatalkes_id;
      $modMutasiDetail->jmlmutasi = $jumlah; //$stok->qtystok_terpakai;
      $modMutasiDetail->harganetto = floor($oa->harganetto); //$stok->HPP;
      $modMutasiDetail->hargajualsatuan = floor($oa->hargajual); //$stok->HargaJualSatuan;
      $modMutasiDetail->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
      $modMutasiDetail->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
      $modMutasiDetail->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
      $modMutasiDetail->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;
      //                    $modMutasiDetail->tglkadaluarsa = $oa->tglkadaluarsa; RSPMC-1923 //$format->formatDateTimeForUser($stok->tglkadaluarsa);
      $modMutasiDetail->tglkadaluarsa = $tglKadaluarsaRuangan->tglkadaluarsa;
      $modMutasiDetail->jmlstok = $jmlStok; //$stok->qtystok;
      $modMutasiDetail->tglterima = $format->formatDateTimeForUser(date('Y-m-d H:i:s')); //$format->formatDateTimeForUser($stok->tglterima);
      $totalharganetto += $modMutasiDetail->harganetto;
      $totalhargajual += $modMutasiDetail->hargajualsatuan;

      //	var_dump($modMutasiDetail->tglkadaluarsa);

      $form .= $this->renderPartial($this->path_view . '_rowMutasiDetail', array('modMutasiDetail' => $modMutasiDetail), true);
      //}
      //}else{
      //    $pesan = "Stok tidak mencukupi!";
      //}

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasitujuan_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (count((array)$models) > 1) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } elseif (count((array)$models) == 0) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionAutocompleteObatAlkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $is_nobatch_tglkadaluarsa = isset($_GET['is_nobatch_tglkadaluarsa']) ? $_GET['is_nobatch_tglkadaluarsa'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'obatalkes_nama';
      $criteria->limit = 5;
      if ($is_nobatch_tglkadaluarsa == 1) {
        $models = GFInformasistokobatalkesV::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->obatalkes_nama . " (Stok=" . $model->qtystok . ")";
          $returnVal[$i]['value'] = $model->obatalkes_id;
        }
      } else {
        $models = ObatalkesM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->obatalkes_nama . " (Stok=" . $model->StokObatRuangan . ")";
          $returnVal[$i]['value'] = $model->obatalkes_id;
        }
      }


      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk print data rencana kebutuhan farmasi
   */
  public function actionPrint($mutasioaruangan_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $model = GFMutasioaruanganT::model()->findByPk($mutasioaruangan_id);
    $modDetails = GFMutasioadetailT::model()->findAllByAttributes(array('mutasioaruangan_id' => $mutasioaruangan_id));

    $judul_print = 'Mutasi Obat Alkes';

    $this->render($this->path_view . 'print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
      'modDetails' => $modDetails,
      'caraprint' => $caraprint
    ));
  }

  protected function saveJurnalRekening($model, $dtDetail)
  {

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PERSEDIAAN;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglmutasioa);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->nomutasioa;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglmutasioa);
    $modJurnalRekening->nobku = "";
    $ruangan_nama = "";
    $modRuangan = RuanganM::model()->findByPk($model->ruangantujuan_id);

    if (isset($modRuangan)) {
      $ruangan_nama = $modRuangan->ruangan_nama;
    }

    $modJurnalRekening->urianjurnal = 'Mutasi Obat Alkes ' . $dtDetail->obatalkes->obatalkes_nama . " Ruangan " . $ruangan_nama . " - " . $model->nomutasioa;

    $periodeID = $modJurnalRekening->currentPeriod;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $model->create_ruangan;
    $modJurnalRekening->mutasioaruangan_id = $model->mutasioaruangan_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $postRekenings, $modelRek)
  {
    $valid = true;
    $modJurnalPosting = null;
    $modObatAlkes = ObatalkesM::model()->findByPk($postRekenings->obatalkes_id);

    // $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
    // $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
    // $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
    // $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);

    $modelJurnalDetail = new JurnaldetailT();

    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
    // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
    // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
    // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
    // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;

    // $totalHasilQty = ($modObatAlkes->hpp * $postRekenings->jmlmutasi);
    $totalHasilQty = $postRekenings->totalharga;

    if ($modelRek->debitkredit == 'K') {
      $modelJurnalDetail->nourut = 2;
      $modelJurnalDetail->saldokredit = $totalHasilQty;
      $modelJurnalDetail->saldodebit = 0;
    } else if ($modelRek->debitkredit == 'D') {
      $modelJurnalDetail->nourut = 1;
      $modelJurnalDetail->saldodebit = $totalHasilQty;
      $modelJurnalDetail->saldokredit = 0;
    }

    if ($modelJurnalDetail->validate()) {
      $modelJurnalDetail->save();

      //                if(Yii::app()->user->getState('ispostingotomatis'))
      //                {
      //                    $modJurnalPosting = new JurnalpostingT;
      //                    $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
      //                    $modJurnalPosting->keterangan = "Posting automatis";
      //                    $modJurnalPosting->create_time = date('Y-m-d H:i:s');
      //                    $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
      //                    $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
      //                    $modJurnalPosting->jurnaldetail_id = $modelJurnalDetail->jurnaldetail_id;
      //                    $modJurnalPosting->periodeposting_id = $modelJurnalDetail->jurnalposting_id;
      //
      //                    $periode = PeriodepostingM::model()->findByAttributes(array('rekperiode_id'=>$modJurnalRekening->rekperiod_id));
      //                    if (!empty($periode)) {
      //                        $modJurnalPosting->periodeposting_id = $periode->periodeposting_id;
      //                    }
      //
      //                    if($modJurnalPosting->validate()){
      //                        if($modJurnalPosting->save()){
      //                            JurnaldetailT::model()->updateByPk($modelJurnalDetail->jurnaldetail_id, array('jurnalposting_id'=>$modJurnalPosting->jurnalposting_id));
      //                        }
      //                    }
      //                }
    } else {
      //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
      $valid = false;
    }

    return $valid;
  }
}
