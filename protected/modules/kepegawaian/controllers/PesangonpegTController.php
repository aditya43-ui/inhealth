<?php
Yii::import("penggajian.models.*");
class PesangonpegTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'create';
  public $path_view = 'kepegawaian.views.pesangonpegT.';

  public function actionCreate($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pesangon Pegawai";
    $format = new MyFormatter();
    $model = new KPPesangonpegT;
    $model->tglpesangon = date('Y-m-d H:i:s');
    $model->pemotong_id = Yii::app()->user->getState('pegawai_id');
    $model->keterangan = "PENGAJUAN PESANGON " . PegawaiM::model()->findByPk($model->pemotong_id)->nama_pegawai . date(' - Y');

    if (!empty($model->pemotong_id)) {
      $model->pemotong = PegawaiM::model()->findByPk($model->pemotong_id)->nama_pegawai;
    }

    $model->penerimaanbersih = 0;
    $model->totalpajak = 0;
    $model->totalpotongan = 0;
    $model->totalterima = 0;
    $modPegawai = new KPPegawaiM();
    $komponen = new PesangonkompT();

    $mon = (int)date('m');
    $tahun = (int)date('Y');
    $mon--;
    if ($mon == 0) {
      $mon = 12;
      $tahun--;
    }

    $model->periodegaji = Params::getBulan3()[$mon] . ' ' . $tahun;
    $model->no_temp = '-- Otomatis --';
    $model->kode_objekpajakpes = '21-401-01';

    if (isset($_GET['id'])) {
      $model = KPPesangonpegT::model()->findByPk($_GET['id']);
      $model->periodegaji = Params::getBulan3()[(int)date('m', strtotime($model->periodegaji))] . ' ' . date('Y', strtotime($model->periodegaji));
      $modPegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);
      $model->no_temp = $model->nopesangon;
      $model->kode_objekpajakpes = '21-401-01';
    }


    if (isset($_POST['KPPesangonpegT'])) {
      //            echo '<pre>';
      //            print_r($_POST);
      //            exit();
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['KPPesangonpegT'];
        var_dump($_POST['KPPesangonpegT']); //die();
        $model->pegawai_id = $_POST['KPPesangonpegT']['pegawai_id'];
        $model->tglpesangon = $format->formatDateTimeForDb($model->tglpesangon);
        $model->nopesangon = MyGenerator::noPesangon($model->tglpesangon);
        // $model->harikerja = $_POST['KPPesangonpegT']['harikerja'];
        $model->periodegaji = MyFormatter::formatMonthForDb($model->periodegaji) . '-01';
        $data = $_POST['PesangonkompT'];

        /* RSPMC-424 */
        $model->pph21perbulan = isset($_POST['KPPesangonpegT']['pph21']) ? $_POST['KPPesangonpegT']['pph21'] : null;
        $model->pph21pertahun = $model->pph21perbulan * 12;

        $model->ptkppertahun = isset($_POST['KPPesangonpegT']['ptkp']) ? $_POST['KPPesangonpegT']['ptkp'] : null;
        //                $model->potonganpensiun = $_POST['GJPesangonpegT']['iuranpensiun'];
        $modPegawaiPost = PegawaiM::model()->findByPk($model->pegawai_id);
        if (isset($modPegawaiPost->ptkp_id)) {
          $modPtkpM = PtkpM::model()->findByPk($modPegawaiPost->ptkp_id);
          $model->kodeptkp = $modPtkpM->kodeptkp . "/" . $modPtkpM->jmltanggunan;
        }

        // $periode = date('Y-m-d', strtotime($model->periodegaji['tahun'].'-'.$model->periodegaji['bulan'].'-01'));
        // $model->periodegaji = $periode;


        // var_dump($model->attributes); die;

        $ok = $ok && $model->save();



        // var_dump($model->attributes);
        // die;
        //var_dump($data); die;

        // var_dump($_POST); die;

        if ($ok) {
          $jumlah = 0;
          if (count((array)$data) > 0) {
            foreach ($data as $i => $v) {



              $row = new PesangonkompT();
              $row->komponengaji_id = $i;
              $row->jumlah = $v['jumlah'];
              $row->qty = $v['qty'];
              $row->satuan = $v['satuan'];
              $row->unit = $v['unit'];
              $row->pesangonpeg_id = $model->pesangonpeg_id;

              // var_dump($row->attributes, $v); die;
              if ($row->save()) {
                $jumlah++;
                //                                
                //                                
                //                                if (isset($_POST['data_jasa'][$i])) {
                //                                    foreach ($_POST['data_jasa'][$i] as $id) {
                //                                        $jasa = PembjasadetailT::model()->findByPk($id);
                //                                        $jasa->pesangonkomp_id = $row->pesangonkomp_id;
                //                                        $jasa->save();
                //                                    }
                //                                }
                //                                
                //                                if (isset($_POST['data_askep'][$i])) {
                //                                    foreach ($_POST['data_askep'][$i] as $id) {
                //                                        $jasa = PembjasaperawatT::model()->findByPk($id);
                //                                        $jasa->pesangonpeg_id = $row->pesangonpeg_id;
                //                                        $jasa->save();
                //                                    }
                //                                }
              }
            }
          }

          if ((count((array)$data) > 0) && ($jumlah == count((array)$data))) {
            $ok = $ok && true;
            //                        
            //                        Yii::app()->db
            //                            ->createCommand("select ins_afterpenggajianpeg_fix(".$model->pesangonpeg_id.")")
            //                            ->query();

          } else {
            $ok = $ok && false;
          }
        }

        //if ((count((array)$data) > 0) && ($jumlah == count((array)$data))) {

        // var_dump($ok); die;
        //                exit();
        if ($ok) {
          $transaction->commit();

          Yii::app()->user->setFlash('success', 'Data ' . $model->pegawai->nama_pegawai . ' berhasil disimpan.');
          $this->redirect(array('create', 'id' => $model->pesangonpeg_id, 'sukses' => 1));
        } else {
          //var_dump($model->getErrors());die;
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(3361);

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modPegawai' => $modPegawai,
      'komponen' => $komponen,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function actionGetTanggalPeriode()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $periode = $_POST['periode'];

      $odate = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb("01 " . $periode)));
      $monthAwal = date('m', strtotime($odate)) - 1;
      $konfig = KonfigsystemK::model()->find();
      $day = 0;
      if ($monthAwal < 10) {
        $monthAwal = '0' . $monthAwal;
      }
      if (isset($konfig->cutoff_penggajian)) {
        $day = $konfig->cutoff_penggajian;
      }
      $dayAwal = $day + 1;
      if ($dayAwal < 9) {
        $dayAwal = '0' . $dayAwal;
      }
      $year = date('Y', strtotime($odate));
      $periodeAkhir = date('m-Y', strtotime(MyFormatter::formatDateTimeForDb("01 " . $periode)));
      $tgl_awal = $dayAwal . "-" . $monthAwal . "-" . $year;
      $tgl_akhir = $day . "-" . $periodeAkhir;

      $dateAwal = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($tgl_awal)));
      $dateAkhir = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($tgl_akhir)));

      $data = array('tgl_awal' => MyFormatter::formatDateTimeForUser($dateAwal), 'tgl_akhir' => MyFormatter::formatDateTimeForUser($dateAkhir));
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetKomponenGaji()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $odate = date('Y-m-d');
      // $odate = date('Y-m-d', strtotime('-1 month'));
      $pegawai_id = $_POST['pegawai_id'];
      $periode = $_POST['periode'];


      $odate = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb("01 " . $periode)));

      $monthAwal = date('m', strtotime($odate)) - 1;
      $konfig = KonfigsystemK::model()->find();
      $day = 0;
      if ($monthAwal < 10) {
        $monthAwal = '0' . $monthAwal;
      }
      if (isset($konfig->cutoff_penggajian)) {
        $day = $konfig->cutoff_penggajian;
      }
      $dayAwal = $day + 1;
      if ($dayAwal < 9) {
        $dayAwal = '0' . $dayAwal;
      }
      $year = date('Y', strtotime($odate));
      $periodeAkhir = date('m-Y', strtotime(MyFormatter::formatDateTimeForDb("01 " . $periode)));
      $tgl_awal = $dayAwal . "-" . $monthAwal . "-" . $year;
      $tgl_akhir = $day . "-" . $periodeAkhir;

      $tglgaji_awal = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($tgl_awal)));
      $tglgaji_akhir = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($tgl_akhir)));

      // var_dump($periode, $odate); die;

      $tr = '';
      $peg = PegawaiM::model()->findByPk($pegawai_id);

      // --------------------------------------------------------------

      $modGaji = PesangonpegT::model()->findByAttributes(array(
        'pegawai_id' => $pegawai_id,
        'periodegaji' => $odate,
      ));

      // var_dump($odate); die;

      $ndate = MyFormatter::getMonthId(date('m', strtotime($odate))) . " " . date('Y', strtotime($odate));

      $data['sudah_ada'] = empty($modGaji) ? 0 : 1;
      $data['sudah_ada_msg'] = empty($modGaji) ? '' : "Pegawai " . $peg->namaLengkap . " sudah diajukan penggajian untuk periode " . $ndate . ".";

      // --------------------------------------------------------------

      $modKomponen = array();
      $komponen = new PesangonkompT();
      $a = 1;


      $data['sukses'] = 0;

      $kom_id = array();

      if ($peg->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK) {
        $modKomponen = KomponengajiM::model()->findAll('komponengaji_aktif = true AND (kelompokpegawai_id = ' . $peg->kelompokpegawai_id . ') order by ispotongan IS TRUE ASC, nourutgaji');
      } // else {
      //    $modKomponen = KomponengajiM::model()->findAll('komponengaji_aktif = true AND (kelompokpegawai_id = '.$peg->kelompokpegawai_id.' OR kelompokpegawai_id IS NULL) order by ispotongan IS TRUE ASC, nourutgaji');
      // }


      $cr = new CDbCriteria();
      $cr->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
      $cr->order = 'k.nourutgaji, k.komponengaji_nama';
      $cr->compare('t.pegawai_id', $pegawai_id);
      $modKomponenPegawai = KomponengajipegawaiM::model()->findAll($cr);

      foreach ($modKomponenPegawai as $item) {
        $kom = KomponengajiM::model()->findByPk($item->komponengaji_id);
        // var_dump($kom->attributes);
        array_push($modKomponen, $kom);
      }




      $modKomponenBeta = array_merge($modKomponen);
      $modKomponenAlpha = array();
      $modKomponen = array();

      $off = 999;


      foreach ($modKomponenBeta as $item) {
        $nourut = $item->nourutgaji . "_" . $item->komponengaji_nama;

        if (empty($nourut) || trim($nourut) == "") {
          $nourut = $off++;
        }

        $modKomponenAlpha[$nourut] = $item;
      }

      ksort($modKomponenAlpha);

      foreach ($modKomponenAlpha as $idx => $val) {
        $potongan = $val->ispotongan ? 2 : 1;
        $tipekomponen = empty($val->tipekomponengaji) ? "LAIN-LAIN" : $val->tipekomponengaji;

        if (empty($modKomponen[$potongan])) {
          $modKomponen[$potongan] = array();
        }
        if (empty($modKomponen[$potongan][$tipekomponen])) {
          $modKomponen[$potongan][$tipekomponen] = array();
        }

        $modKomponen[$potongan][$tipekomponen][$idx] = $val;
      }



      $listJaga = $peg->getUangJagaBulan($odate);

      if (count((array)$modKomponen > 0)) {
        $komponen = new PesangonkompT();
        $a = 1;
        foreach ($modKomponen as $j => $detail) {

          $tr .= '<tr><td colspan="5" style="font-weight: bold;">' . ($j == 1 ? 'Penerimaan' : 'Potongan') . '</td></tr>';


          foreach ($detail as $k => $detail2) {

            $tr .= '<tr><td colspan="5" style="font-weight: bold; padding-left: 20px;">' . $k . '</td></tr>';

            foreach ($detail2 as $i => $v) {

              $val = 0;
              $qty = 1;

              $mod_jasa = array();
              $mod_askep = array();

              $modKomponenPegawai = KomponengajipegawaiM::model()->findByAttributes(array(
                'komponengaji_id' => $v->komponengaji_id,
                'pegawai_id' => $peg->pegawai_id
              ));

              if (!empty($modKomponenPegawai)) {
                $val = $modKomponenPegawai->nilaigaji;
              }

              switch ($v->komponengaji_kode) {
                case 'JM':
                  $val = $peg->getUangJasaMedisSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'OSP':
                  //    $qty = $listJaga[$v->komponengaji_kode];
                  //    break;
                case 'OSM':
                  //    $qty = $listJaga[$v->komponengaji_kode];
                  $val = $v->nominal_satuan;
                  break;
                case 'GP':
                  if ($peg->kelompokpegawai_id == 1) {
                    if ($peg->kelompokpegawai_id == $v->kelompokpegawai_id) $val = $val = $peg->gajipokok;
                    else {
                      $val = 0;
                    }
                  } else if (empty($v->kelompokpegawai_id) && $peg->kelompokpegawai_id != 1) {
                    $val = $peg->gajipokok;
                  }
                  break;
                case 'SIP':
                  $val = $peg->nilaiSIP;
                  break;
                case 'FLAB':
                  $val = $peg->getUangRujukInternalBulan($odate, Params::RUANGAN_ID_LAB_KLINIK);
                  break;
                case 'FRAD':
                  $val = $peg->getUangRujukInternalBulan($odate, Params::RUANGAN_ID_RAD);
                  break;
                  // case 'PRM':
                  //    $qty = TindakanpelayananT::model()->getTotalTindakanAsuhanKeperawatan($odate, $pegawai_id);
                  //    break;
                case 'PRM':
                  $val = $peg->getUangJasaParamedisSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'LMBR':
                  $criterialm = new CDbCriteria;
                  $criterialm->addBetweenCondition('tglmulai', $tglgaji_awal, $tglgaji_akhir);
                  $criterialm->addCondition('pegawai_id =' . $pegawai_id);
                  $lembur = RealisasilemburdetT::model()->findAll($criterialm);
                  $qtyLm = 1;
                  $valLm = 0;

                  if (count((array)$lembur) > 0) {
                    foreach ($lembur as $item) {
                      //                                        $qtyLm += $item->total_jam;
                      $valLm = $item->total_nilai_lembur;
                    }
                  }
                  //                                    $lembur = $peg->getLembur($odate, 1);
                  $qty = $qtyLm;
                  $val = $valLm;
                  break;
                case 'LMOC':
                  $lembur = $peg->getLembur($odate, 2);
                  $qty = $lembur['qty'];
                  $val = $lembur['val'];
                  break;
                case 'JO':
                  $val = $peg->getUangJasaApotekSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'JTS':
                  $val = $peg->getUangJasaSopirSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'JTL':
                  $val = $peg->getUangJasaLaundrySudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'JTKG':
                  $val = $peg->getUangJasaGiziSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'JR':
                  $val = $peg->getUangJasaRadiograferSudahBayar($odate, $mod_jasa, $mod_askep);
                  break;
                case 'THR':
                  $modKomponenPeg = KomponengajipegawaiM::model()->findAll('(komponengaji_id = 1 or komponengaji_id = 2 or komponengaji_id = 4) and pegawai_id = ' . $peg->pegawai_id);
                  $total = 0;
                  if (!empty($modKomponenPeg)) {
                    $val_thr = 0;
                    foreach ($modKomponenPeg as $key => $value) {
                      $val_thr += $value->nilaigaji;
                    }
                  }

                  if ($peg->kategoripegawai == 'PEGAWAI TETAP') {
                    $total = $val_thr;
                  } else {
                    $jmlBln = CustomFunction::getTotalBulan(date('Y-m-d'), $peg->tglditerima);
                    if ($jmlBln <= 12) {
                      $total = ($jmlBln / 12) * $val_thr;
                    } else {
                      $total = $val_thr;
                    }
                  }

                  $val = $total;
                  break;
              }

              $val = MyFormatter::formatNumberForPrint($val);

              $tr .= $this->renderPartial($this->path_view . '_rowKomponenGaji', array(
                'v' => $v,
                'komponen' => $komponen,
                'val' => $val,
                'qty' => $qty,
                'mod_jasa' => $mod_jasa,
                'mod_askep' => $mod_askep,
              ), true);
              $a++;
            }
          }
        }

        $data['sukses'] = 1;
      }

      if ($data['sukses'] == 0) {
        $data['pesan'] = 'Komponen Gaji tidak Ditemukan';
      }


      /*
            // $modKomponen = $this->getKomponenGajiPegawai($pegawai_id);
            
            if ($peg->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK) {
                $modKomponen = KomponengajiM::model()->findAll('komponengaji_aktif = true AND (kelompokpegawai_id = '.$peg->kelompokpegawai_id.') order by ispotongan IS TRUE ASC, nourutgaji');
            } else {
                $modKomponen = KomponengajiM::model()->findAll('komponengaji_aktif = true AND (kelompokpegawai_id = '.$peg->kelompokpegawai_id.' OR kelompokpegawai_id IS NULL) order by ispotongan IS TRUE ASC, nourutgaji');
            }

            
            
            // print_r($listJaga); die;



            
             * 
             */
      //var_dump($i);


      // presensi
      $cr = new CDbCriteria();
      $cr->select = 't.pegawai_id, t.tglpresensi::date';
      $cr->addCondition("t.statusscan_id = 1 and t.statuskehadiran_id = 1");
      $cr->group = 't.pegawai_id, t.tglpresensi::date';
      $cr->addBetweenCondition('t.tglpresensi::date', date('Y-m-01', strtotime($odate)), date('Y-m-t', strtotime($odate)));
      $cr->compare('t.pegawai_id', $pegawai_id);

      $presensi = PresensiT::model()->findAll($cr);


      $data['row'] = $tr;
      $data['harikerja'] = count((array)$presensi);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionAmbilPph()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pkp = $_POST['pkp'];

      // $sql = "SELECT persentarifpenghsl FROM potonganpph21_m WHERE penghasilandari >= $pkp AND sampaidgn_thn <=$pkp ";
      // $persen_pph = Yii::app()->db->createCommand($sql)->queryAll();

      $conditions = "penghasilandari <= " . $pkp . " AND sampaidgn_thn >=" . $pkp . " ";
      $criteria = new CDbCriteria;
      $criteria->addCondition($conditions);
      $modpph = Potonganpph21M::model()->findAll($criteria);

      foreach ($modpph as $key => $pph) {
        $data['percent'] = $pph->persentarifpenghsl;
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionHitungKeterlambatan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pegawai_id = $_POST['pegawai_id'];
      $periodegaji = $_POST['periodegaji'];
      $periodegaji_awal = MyFormatter::formatMonthForDb($periodegaji) . '-01';
      $periodegaji_akhir = date('Y-m-t', strtotime($periodegaji_awal));

      $sql = "SELECT count(terlambat_mnt) as jumlah FROM presensi_t WHERE statuskehadiran_id = 1 "
        . " and statusscan_id = 1 and pegawai_id = " . $pegawai_id . " AND terlambat_mnt > " . Params::WAKTU_KETERLAMBATAN_1 . " AND terlambat_mnt <= " . Params::WAKTU_KETERLAMBATAN_2 . " and DATE(tglpresensi) BETWEEN '" . $periodegaji_awal . "' AND '" . $periodegaji_akhir . "'";
      $result = Yii::app()->db->createCommand($sql)->queryRow();

      $sql2 = "SELECT count(terlambat_mnt) as jumlah FROM presensi_t WHERE statuskehadiran_id = 1 "
        . " and statusscan_id = 1 and pegawai_id = " . $pegawai_id . " AND terlambat_mnt > " . Params::WAKTU_KETERLAMBATAN_2 . " AND DATE(tglpresensi) BETWEEN '" . $periodegaji_awal . "' AND '" . $periodegaji_akhir . "'";
      $result2 = Yii::app()->db->createCommand($sql2)->queryRow();

      $data['lama15'] = $result['jumlah'];
      $data['lama60'] = $result2['jumlah'];

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetPtkpNew()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $data['status'] = '';
      $data['ptkp'] = '0';
      $pegawai_id = $_POST['pegawai_id'];
      $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
      if (!empty($modPegawai)) {
        $ptkp = PtkpM::model()->findByPk($modPegawai->ptkp_id);
      }

      if (!empty($ptkp)) {
        $data['status'] = 'ada';
        $data['ptkp'] = $ptkp->wajibpajak_thn;
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }


  public function actionInformasi($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pesangon Pegawai";
    $model = new KPPesangonpegT('search');
    $model->unsetAttributes();  // clear any default values
    $model->periodegaji = date('Y-m');
    //        $model->kategoripegawaiasal = $this->kategoripegawaiasal;
    if (isset($_GET['KPPesangonpegT'])) {
      $model->attributes = $_GET['KPPesangonpegT'];
      $model->status = $_GET['KPPesangonpegT']['status'];
      $model->periodegaji = MyFormatter::formatMonthForDB($model->periodegaji);
      $model->nomorindukpegawai = !empty($_GET['KPPesangonpegT']['nomorindukpegawai']) ? $_GET['KPPesangonpegT']['nomorindukpegawai'] : '';
      $model->nama_pegawai = !empty($_GET['KPPesangonpegT']['nama_pegawai']) ? $_GET['KPPesangonpegT']['nama_pegawai'] : '';
      $model->kelompokpegawai_id = !empty($_GET['KPPesangonpegT']['kelompokpegawai_id']) ? $_GET['KPPesangonpegT']['kelompokpegawai_id'] : '';
      $model->jabatan_id = !empty($_GET['KPPesangonpegT']['jabatan_id']) ? $_GET['KPPesangonpegT']['jabatan_id'] : '';
    }
    
    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(3360);

    $this->render($this->path_view . 'informasi', array(
      'model' => $model, 'linkHalaman' => $linkHalaman
    ));
  }

  public function actionPegawaiResign()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->select = "t.pegawai_id, t.nomorindukpegawai, t.nama_pegawai, t.alamatemail, t.tempatlahir_pegawai, t.tgl_lahirpegawai, t.jeniskelamin, jabatan_m.jabatan_nama, t.jabatan_id, t.no_rekening, t.bank_no_rekening, t.npwp, t.notelp_pegawai, t.nomobile_pegawai, t.agama, t.statusperkawinan, t.ptkp_id, t.alamat_pegawai, t.kategoripegawai, t.kode_objekpajak, t.photopegawai, t.gelardepan, t.gelarbelakang_id";
      $criteria->group = $criteria->select;
      $criteria->join = "LEFT JOIN jabatan_m ON jabatan_m.jabatan_id = t.jabatan_id JOIN resign_t ON resign_t.pegawai_id = t.pegawai_id";
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->addCondition('t.pegawai_aktif = false');
      $criteria->order = 'nama_pegawai ASC';
      $models = PegawaiM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionApproveMenyetujui($pesangonpeg_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PesangonpegT::model()->findByPk($pesangonpeg_id);
    $modelpegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.pesangonpeg_id', $pesangonpeg_id);
    $crkom->order = 'k.ispotongan asc, t.pesangonkomp_id';


    $kom = PesangonkompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PesangonpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");


    //		
    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
    //		$modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    if ($approve) {
      $update = PesangonpegT::model()->updateByPk($pesangonpeg_id, array('tgl_menyetujui' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMenyetujui', 'pesangonpeg_id' => $pesangonpeg_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    //		if($tolak){
    //			$update = ADPembelianbarangT::model()->updateByPk($rencanakebfarmasi_id,array('statusrencana'=>"DITOLAK"));
    //			if($update){
    //				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    //				$this->redirect(array('menyetujui','rencanakebfarmasi_id'=>$rencanakebfarmasi_id,'sukses'=>1,'ditolak'=>1));
    //			}else{
    //				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
    //			}
    //		}
    $judulLaporan = 'Pesangon Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpesangon);
    $this->render($this->path_view . '_menyetujui', array(
      'format' => $format,
      'modelpegawai' => $modelpegawai,
      'model' => $model,
      'kom' => $kom,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      //				'modDetailBeli'=>$modDetailBeli
    ));
  }

  public function actionprintApproveMenyetujui($pesangonpeg_id)
  {
    $format = new MyFormatter();
    $model = PesangonpegT::model()->findByPk($pesangonpeg_id);
    $modelpegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.pesangonpeg_id', $pesangonpeg_id);
    $crkom->order = 'k.ispotongan asc, t.pesangonkomp_id';


    $kom = PesangonkompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PesangonpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");
    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
    //		$modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    $judulLaporan = 'Pesangon Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpesangon);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionApproveMengetahui($pesangonpeg_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PesangonpegT::model()->findByPk($pesangonpeg_id);
    $modelpegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.pesangonpeg_id', $pesangonpeg_id);
    $crkom->order = 'k.ispotongan asc, t.pesangonkomp_id';


    $kom = PesangonkompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PesangonpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");
    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    if ($approve) {
      $update = PesangonpegT::model()->updateByPk($pesangonpeg_id, array('tgl_mengetahui' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMengetahui', 'pesangonpeg_id' => $pesangonpeg_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Pesangon Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpesangon);
    $this->render($this->path_view . '_mengetahui', array(
      'format' => $format,
      'modelpegawai' => $modelpegawai,
      'model' => $model,
      'kom' => $kom,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      //				'modDetailBeli'=>$modDetailBeli
    ));
  }

  public function actionApproveMengetahuiPT($pesangonpeg_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PesangonpegT::model()->findByPk($pesangonpeg_id);
    $modelpegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.pesangonpeg_id', $pesangonpeg_id);
    $crkom->order = 'k.ispotongan asc, t.pesangonkomp_id';


    $kom = PesangonkompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PesangonpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");
    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    if ($approve) {
      $update = PesangonpegT::model()->updateByPk($pesangonpeg_id, array('tgl_mengetahuipt' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMengetahuiPT', 'pesangonpeg_id' => $pesangonpeg_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Pesangon Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpesangon);
    $this->render($this->path_view . '_mengetahuipt', array(
      'format' => $format,
      'modelpegawai' => $modelpegawai,
      'model' => $model,
      'kom' => $kom,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      //				'modDetailBeli'=>$modDetailBeli
    ));
  }

  public function actionPrintApproveMengetahui($pesangonpeg_id)
  {
    $format = new MyFormatter();

    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));

    $model = PesangonpegT::model()->findByPk($pesangonpeg_id);
    $modelpegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.pesangonpeg_id', $pesangonpeg_id);
    $crkom->order = 'k.ispotongan asc, t.pesangonkomp_id';


    $kom = PesangonkompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PesangonpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");

    $judulLaporan = 'Pesangon Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpesangon);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintApproveMengetahuiPT($pesangonpeg_id)
  {
    $format = new MyFormatter();

    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));

    $model = PesangonpegT::model()->findByPk($pesangonpeg_id);
    $modelpegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);


    $crkom = new CDbCriteria;
    $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $crkom->compare('t.pesangonpeg_id', $pesangonpeg_id);
    $crkom->order = 'k.ispotongan asc, t.pesangonkomp_id';


    $kom = PesangonkompT::model()->findAll($crkom);

    if (empty($model)) {
      $model = new PesangonpegT;
    }
    $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id) ? $modelpegawai->jabatan->jabatan_nama : "";
    $model->totalterima = number_format($model->totalterima, 0, "", ".");
    $model->totalpotongan = number_format($model->totalpotongan, 0, "", ".");
    $model->penerimaanbersih = number_format($model->penerimaanbersih, 0, "", ".");
    $model->totalpajak = number_format($model->totalpajak, 0, "", ".");

    $judulLaporan = 'Pesangon Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpesangon);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMengetahuiPT', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMengetahuiPT', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahuiPT', array('format' => $format, 'model' => $model, 'modelpegawai' => $modelpegawai, 'kom' => $kom, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionBatalPesangonPeg()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $pesangonpeg_id = isset($_POST['pesangonpeg_id']) ? $_POST['pesangonpeg_id'] : null;
        $pesan = '';
        $status = false;

        $deletePesangonkompT = PesangonkompT::model()->deleteAllByAttributes(array('pesangonpeg_id' => $pesangonpeg_id));

        if ($deletePesangonkompT) {
          $modPesangonpegT = PesangonpegT::model()->deleteByPk($pesangonpeg_id);

          if ($modPesangonpegT) {
            $transaction->commit();
            $status = true;
            $pesan = "Pesangon Pegawai berhasil dibatalkan";
          } else {
            $transaction->rollback();
            $status = false;
            $pesan = "Pesangon Pegawai gagal dibatalkan!";
          }
        } else {
          $transaction->rollback();
          $status = false;
          $pesan = "Pesangon Pegawai gagal dibatalkan!";
        }
      } catch (Exception $ex) {
        $status = false;
        $pesan = "Pesangon Pegawai gagal dibatalkan!";
        $transaction->rollback();
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
