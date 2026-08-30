<?php

class BatalVerifikasiTindakanController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'billingKasir.views.batalVerifikasiTindakan.';

  public function actionIndex($id = null, $pendaftaran_id = null, $linkHalaman = null)
  {
    $successSave = false;
    $format = new MyFormatter;
    $tandaBukti = new TandabuktibayarT;
    $tindakanPelayanan = new TindakanpelayananT;
    $tindakanPelayanan->tgl_tindakan = date('Y-m-d H:i:s');
    $obatalkes = new BKObatalkesPasienT;
    $cekSudahBayar = array();
    $modBayar = new BKPembayaranpelayananT();
    $modPendaftaran = new BKPendaftaranT();
    $modPasien = new BKPasienM();
    $modVerifikasi = new VerifikasitagihanT();
    $modVerifikasi->tglverifikasi = date('d M Y H:i:s');
    $modVerifikasi->noverifikasi = MyGenerator::noVerifikasi();
    $modVerifikasi->notemp = '-- Otomatis --';
    $modTandaBukti = null;
    
    if (!empty($id)) {
      $tindakanPelayanan = TindakanpelayananT::model()->find('verifikasitagihan_id = ' . $id);
      if (!empty($tindakanPelayanan)) {
        $modVerifikasi = VerifikasitagihanT::model()->findByPk($id);
        $modVerifikasi->notemp = $modVerifikasi->noverifikasi;
        $modPendaftaran = BKPendaftaranT::model()->findByPk($tindakanPelayanan->pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($tindakanPelayanan->pasien_id);
      } else {
        $modVerifikasi = new VerifikasitagihanT;
        $modPendaftaran = new BKPendaftaranT;
        $modPasien = new PasienM;
      }
    }

    if (!empty($pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']); 
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    }

    if (count((array)$cekSudahBayar) > 0) {
      Yii::app()->user->setFlash('info', "Sudah melakukan pembayaran");
    }

    if (isset($_POST['VerifikasitagihanT'])) {
      // var_dump($_POST); die;
      
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modVerifikasi->attributes = $_POST['VerifikasitagihanT'];
        $modVerifikasi->create_time = date('Y-m-d H:i:s');
        $modVerifikasi->create_loginpemakai_id = Yii::app()->user->id;
        $modVerifikasi->verifikasioleh_id = Yii::app()->user->getState('pegawai_id');

        if (isset($_POST['biaya_administrasi'])) {
          $modVerifikasi->biaya_administrasi = $_POST['biaya_administrasi'];
        }

        if (isset($_POST['FAPendaftaranT']['pendaftaran_id'])) {
          $modVerifikasi->pendaftaran_id = $_POST['FAPendaftaranT']['pendaftaran_id'];
        }


        // var_dump($modVerifikasi->attributes, $_POST); die;

        if ($modVerifikasi->save()) {
          $sukses = true;
          if($modPendaftaran->instalasi_id == Params::INSTALASI_ID_RI || $modPendaftaran->instalasi_id == Params::INSTALASI_ID_PI || $modPendaftaran->pasienadmisi_id != null){
            $modPendaftaran->verifikasitagihan_id = $modVerifikasi->verifikasitagihan_id;
            $sukses= $modPendaftaran->save();
            // var_dump($sukses);die;
          }
          // var_dump($modPendaftaran->verifikasitagihan_id);die;
          if (isset($_POST['pembayaran'])) {

            // var_dump($_POST['pembayaran']);
            // die;




            $discount_tindakan = 0;
            foreach ($_POST['pembayaran'] as $key => $bayar) {

              $rec = new VerifikasitagihantindakanR;
              // $pend = new PendaftaranT;
              // var_dump($modPendaftaran);die;

              $tindakanPelayanan->attributes = $bayar;
              $tindakanpelayananId = $bayar['tindakanpelayanan_id'];
              $diskon = (isset($bayar['discount_tindakan']) ? $bayar['discount_tindakan'] : 0);
              $tariftindakan = (isset($bayar['tarif_tindakan']) ? $bayar['tarif_tindakan'] : 0);

              if ($diskon <= 0) {
                $persen_diskon = 0;
              } else {
                $persen_diskon = ($diskon / $tariftindakan) * 100;
              }

              $tindakan = TindakanpelayananT::model()->findByPk($tindakanpelayananId);

              $rec->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
              $rec->daftartindakan_id = $tindakan->daftartindakan_id;
              $rec->carabayar_id = $tindakan->carabayar_id;
              $rec->penjamin_id = $tindakan->penjamin_id;
              $rec->verifikasitagihan_id = $modVerifikasi->verifikasitagihan_id;
              
              $rec->qty_tindakan_sebelum = $tindakan->qty_tindakan;
              $rec->qty_tindakan_sesudah = (isset($bayar['qty_tindakan']) ? $bayar['qty_tindakan'] : 0);

              $rec->tarif_satuan_sebelum = $tindakan->tarif_satuan;
              $rec->tarif_satuan_sesudah = (isset($bayar['tarif_tindakan']) ? round($bayar['tarif_tindakan'] / $bayar['qty_tindakan']) : 0);

              $rec->tarif_tindakan_sebelum = $tindakan->tarif_tindakan;
              $rec->tarif_tindakan_sesudah = $rec->qty_tindakan_sesudah * $rec->tarif_satuan_sesudah; //(isset($bayar['tarif_tindakan']) ? $bayar['tarif_tindakan'] : 0);

              $rec->discount_tindakan_sebelum = $tindakan->discount_tindakan;
              $rec->discount_tindakan_sesudah = (isset($bayar['discount_tindakan']) ? $bayar['discount_tindakan'] : 0);

              $rec->subsidiasuransi_tindakan_sebelum = $tindakan->subsidiasuransi_tindakan;
              $rec->subsidiasuransi_tindakan_sesudah = (isset($bayar['subsidiasuransi_tindakan']) ? $bayar['subsidiasuransi_tindakan'] : 0);

              $rec->subsidipemerintah_tindakan_sebelum = $tindakan->subsidipemerintah_tindakan;
              $rec->subsidipemerintah_tindakan_sesudah = $tindakan->subsidipemerintah_tindakan;

              $rec->subsisidirumahsakit_tindakan_sebelum = $tindakan->subsisidirumahsakit_tindakan;
              $rec->subsisidirumahsakit_tindakan_sesudah = (isset($bayar['subsisidirumahsakit_tindakan']) ? $bayar['subsisidirumahsakit_tindakan'] : 0);

              $sukses = $sukses && $rec->save();
              // var_dump($sukses);die;

              // var_dump("Qty : ".$rec->qty_tindakan_sesudah);
              // var_dump($rec->attributes);

              // var_dump($rec->attributes, $tindakan->attributes, $modVerifikasi->attributes); 
              // die;

              $iur_biaya = $rec->tarif_tindakan_sesudah - ($rec->subsidiasuransi_tindakan_sesudah + $rec->subsidipemerintah_tindakan_sesudah + $rec->subsisidirumahsakit_tindakan_sesudah);

              $attr = array(
                'qty_tindakan' => $rec->qty_tindakan_sesudah,
                'tarif_satuan' => $rec->tarif_satuan_sesudah,
                'tarif_tindakan' => $rec->tarif_tindakan_sesudah,
                'tarifcyto_tindakan' => (isset($bayar['tarifcyto_tindakan']) ? $bayar['tarifcyto_tindakan'] : 0),
                'discount_tindakan' => $rec->discount_tindakan_sesudah,
                'pembebasan_tarif' => (isset($bayar['pembebasan_tindakan']) ? $bayar['pembebasan_tindakan'] : 0),
                'subsidiasuransi_tindakan' => $rec->subsidiasuransi_tindakan_sesudah,
                'subsidipemerintah_tindakan' => $rec->subsidipemerintah_tindakan_sesudah,
                'subsisidirumahsakit_tindakan' => $rec->subsisidirumahsakit_tindakan_sesudah,
                'iurbiaya_tindakan' => $iur_biaya,
                'verifikasitagihan_id' => $modVerifikasi->verifikasitagihan_id
              );

              // var_dump($bayar, $attr);

              TindakanpelayananT::model()->updateByPk($tindakanpelayananId, $attr);



              $modTindakankomponen = TindakankomponenT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $tindakanpelayananId), array(
                'order' => 'tindakankomponen_id asc',
              ));

              if (count((array)$modTindakankomponen) > 0) {
                foreach ($modTindakankomponen as $key => $komp) {

                  $nilai = $_POST['komponen'][$tindakanpelayananId][$key];
                  $tindakanKompId = $komp->tindakankomponen_id;

                  $subsidi_rs = (isset($bayar['subsisidirumahsakit_tindakan']) ? $bayar['subsisidirumahsakit_tindakan'] : 0);
                  $subsidi_asuransi = (isset($bayar['subsidiasuransi_tindakan']) ? $bayar['subsidiasuransi_tindakan'] : 0);
                  $iur_biaya = (isset($bayar['iurbiaya_tindakan']) ? $bayar['iurbiaya_tindakan'] : 0);
                  $subsidi_pemerintah = (isset($bayar['subsidipemerintah_tindakan']) ? $bayar['subsidipemerintah_tindakan'] : 0);
                  $tarif_cyto = (isset($bayar['tarifcyto_tindakan']) ? $bayar['tarifcyto_tindakan'] : 0);
                  $pembagi = (isset($bayar['tarif_satuan']) ? $bayar['tarif_satuan'] : 0);
                  $nilai = $nilai;
                  if ($pembagi > 0) {
                    $satuan_subsidi_rs = round(($nilai / $pembagi) * $subsidi_rs);
                    $satuan_subsidi_asu = round(($nilai / $pembagi) * $subsidi_asuransi);
                    $satuan_subsidi_pemerintah = round(($nilai / $pembagi) * $subsidi_pemerintah);
                    $satuan_iurbiaya = round(($nilai / $pembagi) * $iur_biaya);
                    $satuan_tarifcyto = round(($nilai / $pembagi) * $tarif_cyto);
                  } else {
                    $satuan_subsidi_rs = 0;
                    $satuan_subsidi_asu = 0;
                    $satuan_subsidi_pemerintah = 0;
                    $satuan_iurbiaya = 0;
                    $satuan_tarifcyto = 0;
                  }

                  $recdet = new VerifikasitagihankomponenR;

                  $recdet->verifikasitagihantindakan_id = $rec->verifikasitagihantindakan_id;
                  $recdet->komponentarif_id = $komp->komponentarif_id;
                  $recdet->tindakankomponen_id = $komp->tindakankomponen_id;

                  $recdet->tarifkompsatuan_sebelum = $komp->tarif_kompsatuan;
                  $recdet->tarifkompsatuan_sesudah = round($nilai / $rec->qty_tindakan_sesudah);

                  $recdet->tariftindakankomp_sebelum = $komp->tarif_tindakankomp;
                  $recdet->tariftindakankomp_sesudah = $recdet->tarifkompsatuan_sesudah * $rec->qty_tindakan_sesudah;


                  // var_dump($recdet->attributes); die;

                  $sukses = $sukses && $recdet->save();

                  $satuan_iurbiaya = $recdet->tariftindakankomp_sesudah - ($satuan_subsidi_rs + $satuan_subsidi_asu + $satuan_subsidi_pemerintah);

                  $attr = array(
                    'tarif_kompsatuan' => $recdet->tarifkompsatuan_sesudah,
                    'tarif_tindakankomp' => $recdet->tariftindakankomp_sesudah,
                    'subsidirumahsakitkomp' => $satuan_subsidi_rs,
                    'subsidiasuransikomp' => $satuan_subsidi_asu,
                    'subsidipemerintahkomp' => $satuan_subsidi_pemerintah,
                    'iurbiayakomp' => $satuan_iurbiaya,
                    'tarifcyto_tindakankomp' => $satuan_tarifcyto
                  );

                  // var_dump($attr);

                  TindakankomponenT::model()->updateByPk($tindakanKompId, $attr);

                  // var_dump($recdet->attributes);

                }
              } else {

                if(isset($_POST['komponen'])) {
                foreach ($_POST['komponen'][$tindakanpelayananId] as $komponentarif_id => $nilai) {

                  $komp = new TindakankomponenT;
                  $komp->tindakanpelayanan_id = $tindakanpelayananId;
                  $komp->komponentarif_id = $komponentarif_id;
                  $komp->tarif_kompsatuan = 0;
                  $komp->tarif_tindakankomp = 0;
                  $komp->tarifcyto_tindakankomp = 0;
                  $komp->subsidiasuransikomp = 0;
                  $komp->subsidipemerintahkomp = 0;
                  $komp->subsidirumahsakitkomp = 0;
                  $komp->iurbiayakomp = 0;
                  $komp->save();




                  $subsidi_rs = (isset($bayar['subsisidirumahsakit_tindakan']) ? $bayar['subsisidirumahsakit_tindakan'] : 0);
                  $subsidi_asuransi = (isset($bayar['subsidiasuransi_tindakan']) ? $bayar['subsidiasuransi_tindakan'] : 0);
                  $iur_biaya = (isset($bayar['iurbiaya_tindakan']) ? $bayar['iurbiaya_tindakan'] : 0);
                  $subsidi_pemerintah = (isset($bayar['subsidipemerintah_tindakan']) ? $bayar['subsidipemerintah_tindakan'] : 0);
                  $tarif_cyto = (isset($bayar['tarifcyto_tindakan']) ? $bayar['tarifcyto_tindakan'] : 0);
                  $pembagi = (isset($bayar['tarif_satuan']) ? $bayar['tarif_satuan'] : 0);
                  $nilai = $nilai;
                  if ($pembagi > 0) {
                    $satuan_subsidi_rs = round(($nilai / $pembagi) * $subsidi_rs);
                    $satuan_subsidi_asu = round(($nilai / $pembagi) * $subsidi_asuransi);
                    $satuan_subsidi_pemerintah = round(($nilai / $pembagi) * $subsidi_pemerintah);
                    $satuan_iurbiaya = round(($nilai / $pembagi) * $iur_biaya);
                    $satuan_tarifcyto = round(($nilai / $pembagi) * $tarif_cyto);
                  } else {
                    $satuan_subsidi_rs = 0;
                    $satuan_subsidi_asu = 0;
                    $satuan_subsidi_pemerintah = 0;
                    $satuan_iurbiaya = 0;
                    $satuan_tarifcyto = 0;
                  }

                  $recdet = new VerifikasitagihankomponenR;

                  $recdet->verifikasitagihantindakan_id = $rec->verifikasitagihantindakan_id;
                  $recdet->komponentarif_id = $komp->komponentarif_id;;
                  $recdet->tindakankomponen_id = $komp->tindakankomponen_id;

                  $recdet->tarifkompsatuan_sebelum = $komp->tarif_kompsatuan;
                  $recdet->tarifkompsatuan_sesudah = round($nilai / $rec->qty_tindakan_sesudah);

                  $recdet->tariftindakankomp_sebelum = $komp->tarif_tindakankomp;
                  $recdet->tariftindakankomp_sesudah = $recdet->tarifkompsatuan_sesudah * $rec->qty_tindakan_sesudah;


                  // var_dump($recdet->attributes); die;

                  $sukses = $sukses && $recdet->save();
                  // var_dump($sukses); die;

                  $satuan_iurbiaya = $recdet->tariftindakankomp_sesudah - ($satuan_subsidi_rs + $satuan_subsidi_asu + $satuan_subsidi_pemerintah);

                  $attr = array(
                    'tarif_kompsatuan' => $recdet->tarifkompsatuan_sesudah,
                    'tarif_tindakankomp' => $recdet->tariftindakankomp_sesudah,
                    'subsidirumahsakitkomp' => $satuan_subsidi_rs,
                    'subsidiasuransikomp' => $satuan_subsidi_asu,
                    'subsidipemerintahkomp' => $satuan_subsidi_pemerintah,
                    'iurbiayakomp' => $satuan_iurbiaya,
                    'tarifcyto_tindakankomp' => $satuan_tarifcyto
                  );

                  // var_dump($komp->tindakankomponen_id, $attr); die;

                  TindakankomponenT::model()->updateByPk($komp->tindakankomponen_id, $attr);
                }
              }



                // var_dump($bayar);
                //var_dump($_POST['komponen']); die;



                /*
                                $tindakankomp = new TindakankomponenT;
                                $tindakankomp->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
                                $tindakankomp->tindakanpelayanan_id = $tindakanpelayananId;
                                $tindakankomp->tarif_kompsatuan = str_replace(",", "",$bayar['tarif_satuan']);
                                $tindakankomp->tarif_tindakankomp = str_replace(",", "",$bayar['tarif_tindakan']);
                                $tindakankomp->tarifcyto_tindakankomp = str_replace(",", "",$bayar['tarifcyto_tindakan']);
                                $tindakankomp->subsidiasuransikomp = str_replace(",", "",$bayar['subsidiasuransi_tindakan']);
                                $tindakankomp->subsidipemerintahkomp = 0;
                                $tindakankomp->subsidirumahsakitkomp = str_replace(",", "",$bayar['subsisidirumahsakit_tindakan']);
                                $tindakankomp->iurbiayakomp = str_replace(",", "",$bayar['iurbiaya_tindakan']);
                                $tindakankomp->pembayaranjasa_id = null;

                                $tindakankomp->save();
                                 * 
                                 */
              }
              //else{

              //     TindakankomponenT::model()->updateByPk($tindakanKompId,array(
              //     'tarif_kompsatuan'=>str_replace(",", "",$bayar['tarif_satuan']),
              //     'tarif_tindakankomp'=>str_replace(",", "",$bayar['tarif_tindakan'])
              //     ));
              // }

              // $sukses = true;
            }
            //                         exit();
          }

          // die;

          // var_dump($sukses); die;

          if (isset($_POST['pembayaranAlkes'])) {

            // var_dump($_POST['pembayaranAlkes']);

            // var_dump("=============== Update =================");

            foreach ($_POST['pembayaranAlkes'] as $key => $alkes) {

              // $qty_shift = $alkes['qty_oa'] / $alkes['qty_oa_old'];

              // var_dump($alkes);

              $oapasien = ObatalkespasienT::model()->findAllByAttributes(array(
                'pendaftaran_id' => $modVerifikasi->pendaftaran_id,
                'obatalkes_id' => $alkes['obatalkes_id'],
              ), array(
                'condition' => 'oasudahbayar_id is null',
              ));

              foreach ($oapasien as $oaitem) {
                if($alkes['qty_oa']>0){
                  $qty_oa = $alkes['qty_oa'];
                  $qty_shift = $oaitem->qty_oa / $qty_oa;
                }
                $qty_shift = !empty($qty_shift) ? $qty_shift : 0;
                $attr = array(
                  'qty_oa' => $oaitem->qty_oa,
                  'hargasatuan_oa' => $alkes['hargasatuan'],
                  'hargajual_oa' => str_replace(".", "", $alkes['hargajual_oa']) * $qty_shift,
                  'discount' => $alkes['discount'] * $qty_shift,
                  'tarifcyto' => $alkes['tarifcyto'] * $qty_shift,
                  'biayaservice' => $alkes['tarifcyto'] * $qty_shift,
                  'subsidiasuransi' => $alkes['subsidiasuransi'] * $qty_shift,
                  'subsidirs' => $alkes['subsidirs'] * $qty_shift,
                  'iurbiaya' => $alkes['iurbiaya'] * $qty_shift,
                  'verifikasitagihan_id' => $modVerifikasi->verifikasitagihan_id
                );

                BKObatalkesPasienT::model()->updateByPk($oaitem->obatalkespasien_id, $attr);

                // var_dump($attr);
              }

              /*
                            
                            // var_dump($alkes);
                            
                            $obatalkes->attributes = $alkes;
                            $obatalkespasienId = $alkes['obatalkespasien_id'];
                            $diskon_obat = $alkes['discount'];
                            $hargajual = $alkes['hargajual_oa'];
                            
                            
                            if($diskon_obat <= 0){
                                $persen_diskonOA = 0;
                            }else{
                                // $persen_diskonObat = ($diskon_obat / $hargajual) * 100;
                                $persen_diskonOA = $diskon_obat;
                            }
                            
                            // var_dump($diskon_obat);
//                            echo ($persen_diskonOA);exit;

                            $attr = array(
                                'qty_oa'=>$alkes['qty_oa'],
                                'hargasatuan_oa'=>$alkes['hargasatuan'],
                                'hargajual_oa'=>str_replace(".", "",$alkes['hargajual_oa']),
                                'discount'=> $persen_diskonOA,
                                'tarifcyto'=>$alkes['tarifcyto'],
                                'biayaservice'=>$alkes['tarifcyto'],
                                'subsidiasuransi'=>$alkes['subsidiasuransi'],
                                'subsidirs'=>$alkes['subsidirs'],
                                'iurbiaya'=>$alkes['iurbiaya'],
                                'verifikasitagihan_id'=>$modVerifikasi->verifikasitagihan_id
                            );
                            
                            // var_dump($attr); die;
                            
                            BKObatalkesPasienT::model()->updateByPk($obatalkespasienId, $attr);
                             * 
                             */
            }
            $sukses = $sukses && true;
          }

          // die;

          // var_dump($sukses); 
          // die;

          if ($sukses) {
            $this->notifVerifikasiTagihan($modVerifikasi);
            // $this->kirimNotif($modVerifikasi, $_POST);

            // die;
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data nomor verifikasi " . $modVerifikasi->noverifikasi . " berhasil disimpan");
            $this->redirect(array('index', 'id' => $modVerifikasi->verifikasitagihan_id, 'pendaftaran_id'=>$modVerifikasi->pendaftaran_id));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }



    $this->render(
      $this->path_view . 'create',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modTindPelayanan' => $tindakanPelayanan,
        'modVerifikasi' => $modVerifikasi,
        'modTandaBukti' => $modTandaBukti,
        'linkHalaman' => $linkHalaman
      )
    );
  }


  public function actionSimpanCeklisBatalTindakan() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    if (isset($_POST['pembayaran'])) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {
        foreach ($_POST['pembayaran'] as $detail) {

          $verifikasi = null;
          $verifikasi_rencana = null;

          $tindakan = TindakanpelayananT::model()->findByPk($detail['tindakanpelayanan_id']);

          $pendaftaran = PendaftaranT::model()->findByPk($tindakan->pendaftaran_id);

          $verifikasi = new VerifbataltindakanT;

          $verifikasi->tglverifikasibatal = date('Y-m-d H:i:s');
          $verifikasi->tglbataltindakanpelayanan = date('Y-m-d H:i:s');
          $verifikasi->noverifikasi_batal = MyGenerator::noBatalTindakan();
          $verifikasi->keterangan_verifbatal = "";
          // $verifikasi->pendaftaran_id = $tindakan->pendaftaran_id;
          $verifikasi->create_time = date('Y-m-d H:i:s');
          $verifikasi->create_loginpemakai_id = Yii::app()->user->id;
          $verifikasi->create_ruangan = Yii::app()->user->getState('ruangan_id');
          
          $verifikasi->petugas_verif_id = null;
          $verifikasi->mengetahui_id = Yii::app()->user->getState('pegawai_id');
          $verifikasi->petugasbatal_id = Yii::app()->user->getState('pegawai_id');
          $verifikasi->update_time = date('Y-m-d H:i:s');
          $verifikasi->update_loginpemakai_id = Yii::app()->user->id;

          // $verifikasi->verifbataltindakan_id = 4;

          $ok = $ok && $verifikasi->save();

          // var_dump($ok, $verifikasi->getErrors()); die;

          if ((isset($detail['checked']) && $detail['checked'] == 1)) {
            
            // if (!empty($tindakan->verifikasitagihan_id)) {
              $tindakan->verifbataltindakan_id = $verifikasi->verifbataltindakan_id;
              // $tindakan->verifrenctindakan_id = null;
              $tindakan->isverifbataltindakan = false;

              $verifikasi->update_time = date('Y-m-d H:i:s');
              $verifikasi->update_loginpemakai_id = Yii::app()->user->id;

              $ok &= $tindakan->save();
              // $tindakan->save(false, array('verifikasitagihan_id', 'verifrenctindakan_id'));
            // }

          }

        }
        if ($ok) {
          $trans->commit();

          echo CJSON::encode(array(
            'ok'=>1,
            'msg'=>'Verifikasi Tindakan berhasil dibatalkan.',
          ));

        } else {
          $trans->rollback();

          echo CJSON::encode(array(
            'ok'=>0,
            'msg'=>'Verifiasi Tindakan gagal dibatalkan[1].',
          ));
        }

      } catch (Exception $ex) {
        echo CJSON::encode(array(
          'ok'=>0,
          'msg'=>'Verifiasi Tindakan gagal dibatalkan. '.$ex->getMessage(),
        ));
      }

    } else {
      echo CJSON::encode(array(
        'ok'=>0,
        'msg'=>'Data tidak ditemukan.',
      ));
    }


  }

  public function actionSimpanCeklisVerifikasiOA() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    if (isset($_POST['pembayaranAlkes'])) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {

        foreach ($_POST['pembayaranAlkes'] as $detail) {
          $oas = ObatalkespasienT::model()->findAllByAttributes(array(
            'obatalkes_id' => $detail['obatalkes_id']
          ), array(
            'condition'=>'oasudahbayar_id is null'
          ));


          $oa = $oas[0];

          $pendaftaran = PendaftaranT::model()->findByPk($oa->pendaftaran_id);

          $verifikasi = VerifikasitagihanT::model()->findByAttributes(array(
            'pendaftaran_id'=>$oa->pendaftaran_id
          ));

          if (empty($verifikasi)) {
            $verifikasi = new VerifikasitagihanT;
          }

          if ($verifikasi->isNewRecord) {
            $verifikasi->tglverifikasi = date('Y-m-d H:i:s');
            $verifikasi->noverifikasi = MyGenerator::noVerifikasi();
            $verifikasi->keteranganverifikasi = "Verifikasi per tindakan";
            $verifikasi->pendaftaran_id = $oa->pendaftaran_id;
            $verifikasi->create_time = date('Y-m-d H:i:s');
            $verifikasi->create_loginpemakai_id = Yii::app()->user->id;
            $verifikasi->create_ruangan = Yii::app()->user->getState('ruangan_id');
          }
          $verifikasi->verifikasioleh_id = Yii::app()->user->getState('pegawai_id');
          $verifikasi->update_time = date('Y-m-d H:i:s');
          $verifikasi->update_loginpemakai_id = Yii::app()->user->id;

          $ok = $ok && $verifikasi->save();

          if ($pendaftaran->verifikasitagihan_id != $verifikasi->verifikasitagihan_id) {
            $pendaftaran->verifikasitagihan_id = $verifikasi->verifikasitagihan_id;
            $ok = $ok && $pendaftaran->save(false, array('verifikasitagihan_id'));
          }

          foreach ($oas as $oa_det) {
            if ((isset($detail['checked']) && $detail['checked'] == 1)) {
              if (!empty($oa_det->verifikasitagihan_id)) {
                $oa_det->verifikasitagihan_id = null;
                $ok = $ok && $oa_det->save(false, array('verifikasitagihan_id'));
              }
            }
          }

        }


        if ($ok) {
          $trans->commit();

          echo CJSON::encode(array(
            'ok'=>1,
            'msg'=>'Obat Alkes Pasien berhasil diverifikasi.',
          ));

        } else {
          $trans->rollback();

          echo CJSON::encode(array(
            'ok'=>0,
            'msg'=>'Obat Alkes Pasien gagal diverifikasi.',
          ));
        }

      } catch (Exception $ex) {
        echo CJSON::encode(array(
          'ok'=>0,
          'msg'=>'Tindakan gagal diverifikasi. '.$ex->getMessage(),
        ));
      }

    } else {
      echo CJSON::encode(array(
        'ok'=>0,
        'msg'=>'Data tidak ditemukan.',
      ));
    }
  }


  protected function notifVerifikasiTagihan($modVerifikasi)
  {
    $judul = "Verifikasi Tagihan Pasien - " . $modVerifikasi->noverifikasi;

    // $isi .= "Tgl. Verifikasi : ".MyFormatter::formatDateTimeForUser($modVerifikasi->tglverifikasi)."<br/>";
    $isi = "No. Verifikasi : " . $modVerifikasi->noverifikasi . "<br/>";
    $isi .= "Keterangan : " . $modVerifikasi->keteranganverifikasi . "<br/>";

    $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);
    $kasir = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

    $cur = array(
      array('instalasi_id' => $ruanganAkuntansi->instalasi_id, 'ruangan_id' => $ruanganAkuntansi->ruangan_id, 'modul_id' => $ruanganAkuntansi->modul_id),
      array('instalasi_id' => $kasir->instalasi_id, 'ruangan_id' => $kasir->ruangan_id, 'modul_id' => $kasir->modul_id)
    );
    CustomFunction::broadcastNotif($judul, $isi, $cur);
  }

  public function kirimNotif($modVerifikasi, $post)
  {
    $judul = "Verifikasi Tagihan Pasien - " . $modVerifikasi->noverifikasi;
    $pendaftaran = PendaftaranT::model()->findByAttributes(array(
      'no_pendaftaran' => $post['FAPendaftaranT']['no_pendaftaran'],
    ));
    $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);

    $isi = $pasien->no_rekam_medik . " - " . $pasien->nama_pasien;

    $link = Yii::app()->createUrl('/keuangan/verifikasiTagihanKU/informasi', array(
      'InfoverifikasitagihanV[noverifikasi]' => $modVerifikasi->noverifikasi,
      'InfoverifikasitagihanV[tgl_awal]' => date('Y-m-d', strtotime($modVerifikasi->tglverifikasi)),
      'InfoverifikasitagihanV[tgl_akhir]' => date('Y-m-d', strtotime($modVerifikasi->tglverifikasi)),
    ));

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_FINANCE, 'modul_id' => Params::MODUL_ID_KEUANGAN,  'link_proses' => $link), //, 'link_proses'=>$link_rj
    ));

    // var_dump($link, $judul, $isi);
    //  var_dump($pasien->attributes, $pendaftaran->attributes, $modVerifikasi->attributes, $post); die;
  }

  public function actionUpdate()
  {
    echo "Fitur Belum Tersedia";
  }

  public function actionLoadDataPembayaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $model = TindakanpelayananT::model()->findAllByAttributes(
        array(
          'pendaftaran_id' => $pendaftaran_id
        )
      );
      $data = '';
      $i = 0;
      foreach ($model as $key => $val) {
        $data .= $this->renderpartial(
          $this->path_view . '_formTindakan',
          array(
            'is_load' => true,
            'i' => $i,
            'model' => $val
          ),
          true
        );
        $i++;
      }

      $modelObat = BKObatalkesPasienT::model()->findAllByAttributes(
        array(
          'pendaftaran_id' => $pendaftaran_id
        )
      );
      $idx = 0;
      if ($modelObat) {
        $data_obat = '';
        foreach ($modelObat as $key => $val) {
          $data_obat .= $this->renderpartial(
            $this->path_view . '_formObatAlkes',
            array(
              'is_load' => true,
              'i' => $idx,
              'model' => $val
            ),
            true
          );
          $idx++;
        }
      }

      $result = array(
        'tindakan' => $data,
        'alkes' => $data_obat,
      );
      echo json_encode($result);
      Yii::app()->end();
    }
  }

  public function actionGetTarifTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $daftartindakan_id = $_POST['daftartindakan_id'];
      $ruangan_id = $_POST['ruangan_id'];
      $kelaspelayanan_id = $_POST['kelaspelayanan_id'];

      $model = TariftindakanperdaruanganV::model()->findAllByAttributes(
        array(
          'daftartindakan_id' => $daftartindakan_id,
          'ruangan_id' => $ruangan_id,
          'kelaspelayanan_id' => $kelaspelayanan_id
        )
      );

      $data = array();
      $data['tarif_tindakan'] = 0;
      $data['tarifcyto_tindakan'] = 0;

      $data['tarif_medis'] = 0;
      $data['tarif_rsakomodasi'] = 0;
      $data['tarif_paramedis'] = 0;
      $data['tarif_bhp'] = 0;

      foreach ($model as $key => $val) {
        if ($val->komponentarif_id == Params::KOMPONENTARIF_ID_TOTAL) {
          $data['tarif_tindakan'] = $val->harga_tariftindakan;
          $data['tarifcyto_tindakan'] = $val->harga_tariftindakan * ($val->persencyto_tind / 100);
        }
      }

      $data['discount_tindakan'] = 0;
      $data['subsidiasuransi_tindakan'] = 0;
      $data['subsidipemerintah_tindakan'] = 0;
      $data['subsisidirumahsakit_tindakan'] = 0;
      $data['iurbiaya_tindakan'] = 0;
      $data['total_biaya'] = $data['tarif_tindakan'];

      /*
             * tarif_tindakan
             * tarif_rsakomodasi
             * tarif_medis
             * tarif_paramedis
             * tarif_bhp
             * tarif_satuan
             * tarifcyto_tindakan
             * 
             * discount_tindakan
             * subsidiasuransi_tindakan
             * subsidipemerintah_tindakan
             * subsisidirumahsakit_tindakan
             * iurbiaya_tindakan
             * total_biaya
             */

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionAddFormPemakaianBahan()
  {
    //        if (Yii::app()->request->isAjaxRequest)
    //        {
    $idObatAlkes = $_GET['idObatAlkes'];
    $idDaftartindakan = (isset($_GET['idDaftartindakan']) ? $_GET['idDaftartindakan'] : "");
    $idTindPelayanan = (isset($_GET['idTindPelayanan']) ? $_GET['idTindPelayanan'] : "");
    $ruangan_id = (isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : "");

    $model = new BKObatalkesPasienT();
    $model->tglpelayanan = date('Y-m-d H:i:s');

    $modObatAlkes = ObatalkesM::model()->findByPk($idObatAlkes);
    $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
    $persenjual = $this->persenJualRuangan();

    $model->tindakanpelayanan_id = $idTindPelayanan;
    $model->daftartindakan_id = $idDaftartindakan;
    $model->hargasatuan_oa = floor(($persenjual + 100) / 100 * $modObatAlkes->hargajual);
    $model->obatalkes_nama = $modObatAlkes->obatalkes_nama;
    $model->obatalkes_id = $modObatAlkes->obatalkes_id;
    $model->sumberdana_id = $modObatAlkes->sumberdana_id;
    $model->satuankecil_id = $modObatAlkes->satuankecil_id;
    $model->ruangan_id = $ruangan_id;
    $model->tipepaket_id = 1;

    $model->qty_oa = 1;
    $model->tarifcyto = 0;
    $model->iurbiaya = 0;
    $model->discount = 0;
    $model->subsidiasuransi = 0;
    $model->subsidipemerintah = 0;
    $model->subsidirs = 0;

    echo CJSON::encode(
      array(
        'form' => $this->renderpartial(
          $this->path_view . '_formObatAlkes',
          array(
            'is_load' => true,
            'i' => 99,
            'model' => $model
          ),
          true
        ),
      )
    );
    //            Yii::app()->end();
    //        }
  }

  public function actionAddFormPemakaianAlat()
  {
    //        if (Yii::app()->request->isAjaxRequest)
    //        {
    $idAlat = $_GET['idAlat'];
    $idDaftartindakan = (isset($_GET['idDaftartindakan']) ? $_GET['idDaftartindakan'] : "");
    $idTindPelayanan = (isset($_GET['idTindPelayanan']) ? $_GET['idTindPelayanan'] : "");
    $ruangan_id = (isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : "");

    $model = new BKObatalkesPasienT();
    $model->tglpelayanan = date('Y-m-d H:i:s');

    $modAlat = AlatmedisM::model()->findByPk($idAlat);
    $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);

    $model->tindakanpelayanan_id = $idTindPelayanan;
    $model->daftartindakan_id = $idDaftartindakan;
    $model->obatalkes_nama = $modAlat->alatmedis_nama;
    $model->obatalkes_id = $modAlat->alatmedis_id;
    $model->ruangan_id = $ruangan_id;
    $model->sumberdana_id = 0;
    $model->satuankecil_id = 0;
    $model->tipepaket_id = 2;

    $model->hargasatuan_oa = 0;
    $model->qty_oa = 1;
    $model->tarifcyto = 0;
    $model->iurbiaya = 0;
    $model->discount = 0;
    $model->subsidiasuransi = 0;
    $model->subsidipemerintah = 0;
    $model->subsidirs = 0;

    echo CJSON::encode(
      array(
        'form' => $this->renderpartial(
          $this->path_view . '_formObatAlkes',
          array(
            'is_load' => true,
            'i' => 99,
            'model' => $model
          ),
          true
        ),
      )
    );
    //            Yii::app()->end();
    //        }
  }

  protected function persenJualRuangan()
  {
    switch (Yii::app()->user->getState('instalasi_id')) {
      case Params::INSTALASI_ID_RI: case 79: case 38: case 14:
        $persen = Yii::app()->user->getState('ri_persjual');
        break;
      case Params::INSTALASI_ID_RJ:
        $persen = Yii::app()->user->getState('rj_persjual');
        break;
      case Params::INSTALASI_ID_RD:
        $persen = Yii::app()->user->getState('rd_persjual');
        break;
      default:
        $persen = 0;
        break;
    }

    return $persen;
  }


  public function actionInformasi($linkHalaman =null)
  {
    // $format = new CustomFormat;
    $model = new InfobatalverifrenctindakanV;
    $model->tgl_awal = date('d M Y', strtotime('-7 days'));
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['InfobatalverifrenctindakanV'])) {
      $model->attributes = $_GET['InfobatalverifrenctindakanV'];

      $model->tgl_awal = MyFormatter::formatDateTimeForDB($_GET['InfobatalverifrenctindakanV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDB($_GET['InfobatalverifrenctindakanV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'informasi', array('model' => $model, 'linkHalaman' => $linkHalaman));
  }
  

  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';

    $model = VerifikasitagihanT::model()->getModel($id);

    $this->render($this->path_view . 'detail', array('model' => $model));
  }


  public function getJsonKunjungan($data)
  {
    $res = $data->attributes;

    $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
    $pj = PenanggungjawabM::model()->findByPk($pendaftaran->penanggungjawab_id);

    $dokterpenerima = "";
    $dpjp1 = "";
    $dpjp2 = "";
    $dpjp3 = "";

    if (!empty($data->pasienadmisi_id)) {
      $admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);

      if (!empty($admisi->dokterpenerima_id)) {
        $peg = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
        $dokterpenerima = $peg->namaLengkap;
      }
      if (!empty($admisi->pegawai_id)) {
        $peg = PegawaiM::model()->findByPk($admisi->pegawai_id);
        $dpjp1 = $peg->namaLengkap;
      }
      if (!empty($admisi->dpjp2_id)) {
        $peg = PegawaiM::model()->findByPk($admisi->dpjp2_id);
        $dpjp2 = $peg->namaLengkap;
      }
      if (!empty($admisi->dpjp3_id)) {
        $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id);
        $dpjp3 = $peg->namaLengkap;
      }
    }

    $res['dpjp1'] = $dpjp1;
    $res['dpjp2'] = $dpjp2;
    $res['dpjp3'] = $dpjp3;
    $res['dokterpenerima'] = $dokterpenerima;

    $res['jeniskasuspenyakit'] = $data->jeniskasuspenyakit_nama;
    $res['namainstalasi'] = $data->instalasi_nama;
    $res['namaruangan'] = $data->ruangan_nama;

    $res['namapasien'] = $data->nama_pasien;
    $res['tanggal_lahir'] = MyFormatter::formatDateTimeForUser($data->tanggal_lahir);

    // var_dump($data->kelaspelayanan_id); die;
    
    $kelas = KelaspelayananM::model()->findByPk($data->kelaspelayanan_id);

    if(empty($kelas)) {
      $kelas = KelaspelayananM::model()->findByPk($pendaftaran->kelaspelayanan_id);
    }

    $res['kelaspelayanan_id'] = $kelas->kelaspelayanan_nama;
    $res['kelastanggungan'] = null;

    $res['tgl_pendaftaran'] = MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);

    if (!empty($data->no_rekam_medik)) {
      $res['norekammedik'] = $data->no_rekam_medik;
    }

    if (!empty($pendaftaran->asuransipasien_id)) {

      $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);
      
      $kelaspelayanan = Params::KELASPELAYANAN_ID_TANPA_KELAS;
      if(isset($asuransi->kelastanggunganasuransi_id)) {
        $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
        $kelaspelayanan = $kelas->kelaspelayanan_nama;;

      }

      $res['kelastanggungan'] = $kelaspelayanan;
    }

    $res['nama_pj'] = null;
    if (!empty($pj)) {
      $res['nama_pj'] = $pj->nama_pj;
    }


    /*

        $('#FAPasienM_jeniskelamin').val(data.jeniskelamin);
        $('#FAPasienM_nama_pasien').val(data.namapasien);
        $('#FAPasienM_nama_bin').val(data.namabin);
        $('#FAPendaftaranT_carabayar_nama').val(data.carabayar_nama);
        $('#FAPendaftaranT_penjamin_nama').val(data.penjamin_nama);
         */

    return $res;
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $models = BKInformasikasirrawatjalanV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $models = BKInformasikasirrdpulangV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $models = BKInformasikasirinappulangV::model()->findAll($criteria);
      }
      foreach ($models as $i => $model) {
        $returnVal[$i] = $this->getJsonKunjungan($model);
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
