<?php

class InfoDokterPoliKlinikController extends MyAuthController
{
  /**
   * @return array action filters
   */
  public $_lastHari = null;
  public $path_view = 'pendaftaranPenjadwalan.views.infoDokterPoliKlinik.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Informasi Jadwal Dokter";
    $model = new PPJadwaldokterM('searchJadwalRJ');
    $model->instalasi_id = Params::INSTALASI_ID_RJ;
    $listHari = array(
      'Senin' => 'Senin',
      'Selasa' => 'Selasa',
      'Rabu' => 'Rabu',
      'Kamis' => 'Kamis',
      'Jumat' => 'Jumat',
      'Sabtu' => 'Sabtu',
      'Minggu' => 'Minggu',
    );

    /**
     * handling ajax request dari form search 
     */
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_GET['PPJadwaldokterM'])) {
        $mulai = (!empty($_GET['PPJadwaldokterM']['jadwaldokter_mulai'])) ? date('Y-m-d', strtotime('01 ' . $_GET['PPJadwaldokterM']['jadwaldokter_mulai'])) : date('Y-m-d');
        $tgl = explode('-', $mulai);
        $day = cal_days_in_month(CAL_GREGORIAN, $tgl[1], $tgl[0]);
        //var_dump($_GET['PPJadwaldokterM']);
        $grid = $this->createGrid($day, $tgl[1], $tgl[0], $_GET['PPJadwaldokterM']);
        echo json_encode($grid);
      }


      if (isset($_POST['data'])) {

        $id = $_POST['data'];
        $modJadwal = JadwaldokterM::model()->findByPk($id);
        if (isset($_POST['JadwaldokterM'])) {
          $id = $_POST['JadwaldokterM']['jadwaldokter_id'];
          $modJadwal = JadwaldokterM::model()->findByPk($id);
          $modJadwal->attributes = $_POST['JadwaldokterM'];
          if ($modJadwal->save()) {
            $modDokter = JadwaldokterV::model()->findByAttributes(array(
              'pegawai_id' => $modJadwal->pegawai_id
            ));
            // echo CJSON::encode($_POST);die;

            $kodepoli = $modDokter->kode_bpjs;
            $kodesubspesialis = $modDokter->spesialissubspesialis_kodebpjs;
            $kodedokter = $modDokter->kodedokter_bpjs;
            $jammulai = $_POST['JadwaldokterM']['jadwaldokter_mulai'];
            $jamArrayMulai = explode(" ", $jammulai);
            $jamArrayMulai[0] = substr($jamArrayMulai[0], 0, 5);
            $jamArrayMulai = implode('', $jamArrayMulai);
            $jamMulai = $jamArrayMulai;
            // echo CJSON::encode($jamArrayMulai);die;
            $jamtutup = $_POST['JadwaldokterM']['jadwaldokter_tutup'];
            $jamArrayTutup = explode(" ", $jamtutup);
            $jamArrayTutup[0] = substr($jamArrayTutup[0], 0, 5);
            $jamArrayTutup = implode('', $jamArrayTutup);
            $jamTutup = $jamArrayTutup;
            // echo CJSON::encode($jamArrayTutup);die;
            $hari = $modDokter->jadwaldokter_hari;

            $harikirim = 1;
            switch (strtolower($hari)) {
              case 'senin':
                $harikirim = 1;
                break;
              case 'selasa':
                $harikirim = 2;
                break;

              case 'rabu':
                $harikirim = 3;
                break;

              case 'kamis':
                $harikirim = 4;
                break;

              case 'jumat':
                $harikirim = 5;
                break;

              case 'sabtu':
                $harikirim = 6;
                break;

              case 'minggu':
                $harikirim = 7;
                break;

              case 'hari libur nasional':
                $harikirim = 8;
                break;

              default:
                $harikirim = 1;
                break;
            }
            // echo CJSON::encode($harikirim);die;
            $jadwal[] = array("hari" => $harikirim, "buka" => $jamMulai, "tutup" => $jamTutup);

            if ($this->updateJadwalDokterWSBPJS($kodepoli, $kodesubspesialis, $kodedokter, $jadwal)) {
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.' . $kodedokter . 'kdpoli' . $kodepoli);
            } else {
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan. tapi' . $kodedokter . 'kdpoli' . $kodepoli);
            }
          }
        }
        $pegawai = (!empty($modJadwal->ruangan_id)) ? CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id' => $modJadwal->ruangan_id)), 'pegawai_id', 'nama_pegawai') : array();
        $ruangan = (!empty($modJadwal->instalasi_id)) ? CHtml::listData(RuanganM::model()->findAll('instalasi_id = ?', array($modJadwal->instalasi_id)), 'ruangan_id', 'ruangan_nama') : array();
        $return = $this->renderPartial('_createForm', array('pegawai' => $pegawai, 'model' => $modJadwal, 'ruangan' => $ruangan, 'listHari' => $listHari), true);
        echo json_encode($return);
      }

      if (isset($_GET['JadwaldokterM'])) {
        // echo "oke";
      }
      Yii::app()->end();
    }

    $tgl = explode('-', date('Y-m-d'));
    $model->unsetAttributes();
    $model->jadwaldokter_mulai = MyFormatter::formatMonthForUser(date('Y-m'));

    if (isset($_REQUEST['PPJadwaldokterM'])) {
      $model->attributes = $_REQUEST['PPJadwaldokterM'];
      $tgl = explode('-', MyFormatter::formatMonthForDb($model->jadwaldokter_mulai));
    }

    $day = cal_days_in_month(CAL_GREGORIAN, $tgl[1], $tgl[0]);
    $grid = $this->createGrid($day, $tgl[1], $tgl[0], $model->attributes);

    $this->render(
      $this->path_view . 'index',
      array('model' => $model, 'listHari' => $listHari, 'grid' => $grid)
    );
  }

  protected function gridHari($data, $row)
  {
    if ($this->_lastHari != $data->jadwaldokter_hari) {
      return $data->jadwaldokter_hari;
    } else {
      return '';
    }
  }



  protected function gridDokter($data, $row)
  {
    $this->_lastHari = $data->jadwaldokter_hari;
    return $data->pegawai->nama_pegawai;
  }

  /**
   * method untuk membuat calendar jadwal dokter
   * @param sting $jumlahhari
   * @param string $bulan
   * @param string $tahun
   * @param array $variable
   * @return string berupa grid calender dengan jadwal dokter
   */
  protected function createGrid($jumlahhari, $bulan, $tahun, $variable = null)
  {
    $tglMulai = strtotime($tahun . '-' . $bulan . '-' . '01');
    return $this->renderPartial($this->path_view . "_createGrid", array('tglMulai' => $tglMulai, 'bulan' => $bulan, 'tahun' => $tahun, 'jumlahHari' => $jumlahhari, 'variable' => $variable), true);
  }

  public function actionListDokterRuangan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['idRuangan'])) {
        $idRuangan = $_POST['idRuangan'];
        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');

        if (empty($data)) {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        $dataList['listDokter'] = $option;
      } else {
        $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionUbahDokterJadwal()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idJadwal = $_POST['idJadwal'];
      $idDokter = $_POST['idDokter'];
      $dokterSebelumnya = $_POST['dokterSebelumnya'];

      $criteria = new CDbCriteria;
      if (!empty($dokterSebelumnya)) {
        $criteria->addCondition("pegawai_id = " . $dokterSebelumnya);
      }

      if (JadwaldokterM::model()->updateAll(array(
        'pegawai_id' => $idDokter,
        'update_loginpemakai_id' => Yii::app()->user->id,
        'update_time' => date('Y-m-d H:i:s')
      ), $criteria)) {
        $data['status'] = 'OK';
      } else {
        $data['status'] = 'gagal';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function updateJadwalDokterWSBPJS($kodepoli, $kodesubspesialis, $kodedokter, $jadwal)
  {
    $url          = 'http://165.22.51.146:1805/wsbpjs/updatejadwaldokter/RSWB'; //url {{base_url}}/wsbpjs/updatejadwaldokter/{kode_faskes}
    $method       = 'POST'; //method

    //Request Body//
    $body = array("kodepoli" => $kodepoli, "kodesubspesialis" => $kodesubspesialis ? $kodesubspesialis : $kodepoli, "kodedokter" => $kodedokter, "jadwal" => $jadwal);
    // echo CJSON::encode($body);die;
    //End Request Body//

    //Generate Signature
    // *Don't change this
    $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
    // $requestBody  = strtolower(hash('sha256', $jsonBody));
    // $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $secret;
    // $signature    = hash_hmac('sha256', $stringToSign, $secret);
    // $timestamp    = Date('YmdHis');
    //End Generate Signature


    $ch = curl_init($url);

    $headers = array(
      'Accept: application/json',
      'Content-Type: application/json',
      // 'va: ' . $va,
      // 'signature: ' . $signature,
      // 'timestamp: ' . $timestamp
    );

    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_POST, count($body));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $err = curl_error($ch);
    $ret = curl_exec($ch);
    // echo CJSON::encode( $ret );die;
    curl_close($ch);
    if ($err) {
      return false;
    } else {
      return true;
    }
  }

  public function actionUbahJamBukaDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idJadwal = $_POST['idJadwal'];
      $jamMulai = $_POST['jamMulai'];
      $jamTutup = $_POST['jamTutup'];
      $jamBuka = $jamMulai . ' s/d ' . $jamTutup;

      if (JadwaldokterM::model()->updateByPk(
        $idJadwal,
        array(
          'jadwaldokter_buka' => $jamBuka,
          'jadwaldokter_mulai' => $jamMulai,
          'jadwaldokter_tutup' => $jamTutup,
          'update_loginpemakai_id' => Yii::app()->user->id,
          'update_time' => date('Y-m-d H:i:s')
        )
      )) {
        $data['status'] = 'OK';
      } else {
        $data['status'] = 'gagal';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  //get all jadwal dokter
  public function actionGetAllJadwalDokter()
  {
    $jadwal = $_POST['jadwal'];
    $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : "";
    $jadwal = strtotime('01-' . $jadwal);
    $bulan = date('m', $jadwal);
    $tahun = date('Y', $jadwal);
    $hari_per_bulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
    $totalerror = 0;
    $sukses = 0;
    for ($hari = 1; $hari <= $hari_per_bulan; $hari++) {
      $tgl = new DateTime("$tahun-$bulan-$hari"); // Create a new DateTime object for the current date
      $tgl = $tgl->format('Y-m-d');
      $antrianonlinebpjs = new AntrianOnlineBpjs();
      $modRuangan = RuanganM::model()->findByPk($ruangan_id);
      $body = $modRuangan->kode_bpjs . '/' . $tgl;
      $response_antrianol = CJSON::decode($antrianonlinebpjs->ref_jadwaldokter($body));
      if (!empty($response_antrianol['metaData']['code']) && $response_antrianol['metaData']['code'] == '200') {
        $listData = (!empty($response_antrianol['response']) ? $response_antrianol['response'] : array());
        $terupdate = true;
        if (!empty($listData)) {
          foreach ($listData as $listResp) {
            $modPegawai = PegawaiM::model()->findByAttributes(array('kodedokter_bpjs' => $listResp['kodedokter']));
            if (!empty($modPegawai)) {
              $jadwal = JadwaldokterM::model()->findByAttributes(array('ruangan_id' => $ruangan_id, 'jadwaldokter_tgl' => $tgl, 'pegawai_id' => $modPegawai->pegawai_id));
              
              if(!empty($jadwal)){
                $jadwal1 = $listResp['jadwal'];
                $jadwal1 = explode('-', $jadwal1);
                $jadwaldokter_mulai = date('H:i:s', strtotime($jadwal1[0]));
                $jadwaldokter_tutup = date('H:i:s', strtotime($jadwal1[1]));
                $jadwaldokter_buka = $jadwaldokter_mulai . ' S/d ' . $jadwaldokter_tutup;
                $kuota = $listResp['kapasitaspasien'];

                $terupdate = JadwaldokterM::model()->updateByPk($jadwal->jadwaldokter_id, array('jadwaldokter_buka' => $jadwaldokter_buka, 'jadwaldokter_mulai' => $jadwaldokter_mulai, 'jadwaldokter_tutup' => $jadwaldokter_tutup, 'maximumantrian' => $kuota, 'maximumbpjsantrian' => $kuota, 'maksbuatjanji' => $kuota));
                if ($terupdate) {
                  $sukses = 1;
                }
              }
            }
          }
        }
      } else {
        if (!empty($response_antrianol['metaData']['code'])) {
        }
      }
    }
    if ($sukses == 1) {
      $pesan = "Data Berhasil Di Sinkronisasikan dari BPJS!!";
    }
    $dataAr['sukses'] =  $sukses;
    $dataAr['msg'] =  $pesan;

    echo json_encode($dataAr);
    Yii::app()->end();
  }
  public function actionGetSycnJadwalDokterBPJS()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $ruangan_id = $_POST['ruangan_id'];
      $tanggal = (!empty($_POST['tanggal']) ? MyFormatter::formatDateTimeForDb($_POST['tanggal']) : null);
      $ruangan = RuanganM::model()->findByPk($ruangan_id);
      $sukses = 0;
      $pesan = "Data Gagal Di Sinkronisasikan dari BPJS !!";

      if (!empty($ruangan) && !empty($ruangan->kode_bpjs)) {
        $jadwal = JadwaldokterM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'jadwaldokter_tgl' => $tanggal));

        if (Yii::app()->user->getState('antreanonlinewsbpjs')) {
          $antrianonlinebpjs = new AntrianOnlineBpjs();
          $res_poli = CJSON::decode($antrianonlinebpjs->ref_poli());
          foreach ($res_poli['response'] as $res) {
            if ($res['kdsubspesialis'] == $ruangan->kode_bpjs) {
              $ruangan->kode_bpjs = $res['kdpoli'];
              break;
            }
          }
          $body = $ruangan->kode_bpjs . '/' . $tanggal;
          $response_antrianol = CJSON::decode($antrianonlinebpjs->ref_jadwaldokter($body));
          if (!empty($response_antrianol['metaData']['code']) && $response_antrianol['metaData']['code'] == '200') {
            $listData = (!empty($response_antrianol['response']) ? $response_antrianol['response'] : array());
            $terupdate = true;
            if (!empty($listData)) {
              foreach ($listData as $listResp) {
                if (!empty($jadwal)) {
                  foreach ($jadwal as $jdw) {
                    // var_dump($jdw->jadwaldokter_id);
                    $crt_peg = new CDbCriteria();
                    $crt_peg->compare('LOWER(nama_pegawai)', $listResp['namadokter'], true);

                    $peg = PegawaiM::model()->findByAttributes(array('kodedokter_bpjs' => $listResp['kodedokter']));

                    if (!empty($peg)) {
                      if ($peg->pegawai_id == $jdw->pegawai_id) {
                        $jadwal1 = $listResp['jadwal'];

                        $jadwal1 = explode('-', $jadwal1);
                        $jadwaldokter_mulai = date('H:i:s', strtotime($jadwal1[0]));
                        $jadwaldokter_tutup = date('H:i:s', strtotime($jadwal1[1]));
                        $jadwaldokter_buka = $jadwaldokter_mulai . ' S/d ' . $jadwaldokter_tutup;
                        $kuota = $listResp['kapasitaspasien'];

                        $terupdate = JadwaldokterM::model()->updateByPk($jdw->jadwaldokter_id, array('jadwaldokter_buka' => $jadwaldokter_buka, 'jadwaldokter_mulai' => $jadwaldokter_mulai, 'jadwaldokter_tutup' => $jadwaldokter_tutup, 'maximumantrian' => $kuota, 'maximumbpjsantrian' => $kuota, 'maksbuatjanji' => $kuota));

                        if ($terupdate) {
                          $sukses = 1;
                        }
                        break;
                      }
                    }
                  }
                }
              }
            }
          } else {
            if (!empty($response_antrianol['metaData']['code'])) {
              $sukses = 0;
              $pesan = "Data Gagal Di Sinkronisasikan dari BPJS " . $response_antrianol['metaData']['message'] . " !!";
            }
          }
        }
      } else {
        $sukses = 0;
        $pesan = "Data Gagal Di Sinkronisasikan dari BPJS Karena Kode Ruangan BPJS Salah !!";
      }

      if ($sukses == 1) {
        $pesan = "Data Berhasil Di Sinkronisasikan dari BPJS!!";
      }
      $dataAr['sukses'] =  $sukses;
      $dataAr['msg'] =  $pesan;

      echo json_encode($dataAr);
      Yii::app()->end();
    }
  }
}
