<?php

Yii::import('pendaftaranPenjadwalan.models.PPInformasikamarinapV');

class InformasikamarinapVController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new INInformasikamarinapV;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['INInformasikamarinapV'])) {
      $model->attributes = $_POST['INInformasikamarinapV'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->ruangan_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['INInformasikamarinapV'])) {
      $model->attributes = $_POST['INInformasikamarinapV'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->ruangan_id));
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }



  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex($instalasi_id = '')
  {
    //		$model = INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
    $model = INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');

    //            $row = $this->renderKamarRuangan($model);
    $row = '';
    if ((isset($_POST['ajax'])) && (isset($_POST['ruangan']))) {
      $ruangan = $_POST['ruangan'];
      $model = INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =" . $ruangan . " and " : "") . 'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
      $row = $this->renderKamarRuangan($model);

      echo json_encode($row);
      Yii::app()->end();
    }

    $this->render('index', array(
      'model' => $model,
      'row' => $row,
      'instalasi_id' => $instalasi_id,

    ));
  }

  protected function renderKamarRuangan($model)
  {
    $result = '';
    $tempRuangan = '';
    $list1 = array();
    $jml = 0;
    foreach ($model as $i => $row) {
      $tempJumlah = 0;
      $list1[$row->ruangan_id]['name'] = $row->ruangan_nama;
      $list1[$row->ruangan_id]['ruangan_id'] = $row->ruangan_id;
      $list1[$row->ruangan_id]['kamar_id'] = $row->kamarruangan_id;
      $list1[$row->ruangan_id]['kelaspelayanan_id'] = $row->kelaspelayanan_id;
      $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['name'] = $row->kamarruangan_nokamar;
      $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan'] = $row->kelaspelayanan_nama;
      $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan_id'] = $row->kelaspelayanan_id;
      $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['ruangan_id'] = $row->ruangan_id;
      $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['jml'] = $row->kamarruangan_jmlbed;
      $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['name'] = $row->kamarruangan_nokamar;
      $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['no'] = $row->kamarruangan_nobed;
      $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['status'] = $row->kamarruangan_status;
      $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['id'] = $row->kamarruangan_id;
    }

    foreach ($list1 as $i => $v) {

      $result .= '<div class="contentKamar">';
      $ruangan = RuanganM::model()->findByPk($v['ruangan_id']);
      $tarifumum = PPInformasikamarinapV::model()->getTarif($v['kelaspelayanan_id'], $v['ruangan_id'], 1);
      $tarifbpjs = PPInformasikamarinapV::model()->getTarif($v['kelaspelayanan_id'], $v['ruangan_id'], 3);
      $tarifjamkespa = PPInformasikamarinapV::model()->getTarif($v['kelaspelayanan_id'], $v['ruangan_id'], 4);

      $dataRuangan = '';

      if (!empty($ruangan)) {
        if (!empty($ruangan->ruangan_image)) {
          if (file_exists(Params::pathKamarRuanganDirectory() . $ruangan->ruangan_image)) {
            $file_exist = $ruangan->ruangan_image;
          } else {
            $file_exist = 'no_photo.jpeg';
          }
        } else {
          $file_exist = 'no_photo.jpeg';
        }
        $dataRuangan .= '<table width=\'300\'>';
        $dataRuangan .= '<tr><td rowspan=2><img src=\'' . Params::pathKamarRuanganDirectory() . $file_exist . '\' class=\'image_ruangan\'></td><td>Fasilitas</td><td>' . ((!empty($ruangan->ruangan_fasilitas)) ? $ruangan->ruangan_fasilitas : " - ") . '</td></tr>';
        $dataRuangan .= '<tr><td>Lokasi</td><td>' . ((!empty($ruangan->ruangan_lokasi)) ? $ruangan->ruangan_lokasi : " - ") . '</td></tr>';
        $dataRuangan .= '<tr><td>Jumlah Bed</td><td>{$jmlbed}</td></tr>';
        $dataRuangan .= '<tr><td>Jumlah Terisi</td><td>{$jmlterisi}</td></tr>';
        $dataRuangan .= '<tr><td>Jumlah Dibooking</td><td>{$jmlbooked}</td></tr>';
        $dataRuangan .= '<tr><td><b>Tarif</b></td></tr>';
        if (count((array)$tarifbpjs) > 0) :
          $dataRuangan .= '<tr><td><b>Tarif Bpjs</b></td></tr>';
          foreach ($tarifbpjs as $tarifbpjs) :
            $dataRuangan .= '<tr><td>' . $tarifbpjs->daftartindakan_nama . '</td><td style=\'text-align:center;\'>Rp' . number_format($tarifbpjs->harga_tariftindakan, 0, '', '.') . '</td></tr>';
          endforeach;
        endif;
        if (count((array)$tarifjamkespa) > 0) :
          $dataRuangan .= '<tr><td><b>Tarif Jamkespa</b></td></tr>';
          foreach ($tarifjamkespa as $tarifjamkespa) :
            $dataRuangan .= '<tr><td>' . $tarifjamkespa->daftartindakan_nama . '</td><td style=\'text-align:center;\'>Rp' . number_format($tarifjamkespa->harga_tariftindakan, 0, '', '.') . '</td></tr>';
          endforeach;
        endif;
        if (count((array)$tarifumum) > 0) :
          $dataRuangan .= '<tr><td><b>Tarif Umum</b></td></tr>';
          foreach ($tarifumum as $tarifumum) :
            $dataRuangan .= '<tr><td>' . $tarifumum->daftartindakan_nama . '</td><td style=\'text-align:center;\'>Rp' . number_format($tarifumum->harga_tariftindakan, 0, '', '.') . '</td></tr>';
          endforeach;
        endif;

        $dataRuangan .= '</table>';
      }
      foreach ($v['kamar'] as $j => $w) {
        $jml_kasur = 0;
        $jml_terisi = 0;
        $jml_booked = 0;
        foreach ($w['kamar'] as $t => $bed) {
          $jml_kasur += count((array)$bed['bed']);
          foreach ($bed['bed'] as $d => $e) {
            $kamar = MasukkamarT::model()->find('kamarruangan_id = ' . $e['id'] . ' order by tglmasukkamar desc');
            if (!empty($kamar)) {
              $jml_terisi += 1;
            }
            $booking = BookingkamarT::model()->find('kamarruangan_id = ' . $e['id'] . ' AND statuskonfirmasi = \'SUDAH KONFIRMASI\'');
            if (!empty($booking)) {
              $jml_booked += 1;
            }
          }
        }
        $vars = array(
          '{$jmlbed}' => $jml_kasur,
          '{$jmlterisi}' => $jml_terisi,
          '{$jmlbooked}' => $jml_booked,
        );
        $result .= '<div class="pintu"></div><h3 class="popover-title"><img src=\'' . Yii::app()->baseUrl . '/images/blue-home-icon.png\' style=\'height:30px;\'/>' . $v['name'] . ' - ' . $w['kelaspelayanan'] . ' - ' . $w['jml'] . ' Bed <a  onclick="return false;" href="" class="pull-right popover-default" data-content="' . strtr($dataRuangan, $vars) . '"  data-placement="left"  data-html="true"  data-toggle="popover" data-trigger="hover" ><img src=\'' . Yii::app()->baseUrl . '/images/fasilitas.png\' style=\'height:30px;\'/>Detail</a></h3>
                                <ul>';
        foreach ($w['kamar'] as $x => $y) {
          $result .= '<li class="bed">
                                    <div class="panel panel-success panel-custom">
                                        <div class="panel-heading">
                                            <div class="panel-title">' . $y['name'] . '</div>
                                        </div>
                                        <div class="panel-body">';
          foreach ($y['bed'] as $a => $b) {
            $kamar = MasukkamarT::model()->find('kamarruangan_id = ' . $b['id'] . ' order by tglmasukkamar desc');
            $booking = BookingkamarT::model()->find('kamarruangan_id = ' . $b['id'] . ' AND statuskonfirmasi = \'SUDAH KONFIRMASI\'');
            if (isset($booking)) {
              $booked = 1;
            } else {
              $booked = 0;
            }

            $dataPasien = '';
            $jeniskelamin = isset($kamar->admisi->pasien->jeniskelamin) ? $kamar->admisi->pasien->jeniskelamin : '';
            if (!empty($kamar)) {
              $dataPasien .= '<table >';
              $dataPasien .= '<tr><td>No. RM </td><td>: ' . $kamar->admisi->pasien->no_rekam_medik . '</td></tr>';
              $dataPasien .= '<tr><td>Nama </td><td>: ' . $kamar->admisi->pasien->nama_pasien . '</td></tr>';
              $dataPasien .= '<tr><td>Jenis Kelamin </td><td>: ' . $kamar->admisi->pasien->jeniskelamin . '</td></tr>';
              $dataPasien .= '</table>';
            }
            //jangan dirapikan
            $jeniskelamin = isset($kamar->admisi->pasien->jeniskelamin) ? $kamar->admisi->pasien->jeniskelamin : '';
            $dataPasienHover = '';
            if (!empty($kamar)) {
              $ultah = new DateTime($kamar->admisi->pasien->tanggal_lahir);
              $sekarang = new DateTime('today');
              $umur = $sekarang->diff($ultah)->y;


              $dataPasienHover .= 
$kamar->admisi->pasien->nama_pasien .'
'. $umur .' tahun
'. $kamar->admisi->pasien->jeniskelamin .'
'. date('d-m-Y', strtotime($kamar->admisi->pasien->tanggal_lahir)) .'
'. $kamar->admisi->pasien->no_rekam_medik .'
'. $kamar->admisi->pasien->alamat_pasien;
            }

            if (!empty($booking)) {
              $ultah = new DateTime($booking->pasien->tanggal_lahir);
              $sekarang = new DateTime('today');
              $umur = $sekarang->diff($ultah)->y;


              $dataPasienHover .= 
$booking->pasien->nama_pasien .'
'. $umur .' tahun
'. $booking->pasien->jeniskelamin .'
'. date('d-m-Y', strtotime($booking->pasien->tanggal_lahir)) .'
'. $booking->pasien->no_rekam_medik .'
'. $booking->pasien->alamat_pasien;
            }

            $b['no'] = '<span class="no_kamar">' . $b['no'] . '</span>';
            if ($jeniskelamin == 'LAKI-LAKI') {
              $jeniskelaminket = '<span class="jk" >L</span>';
            } else if ($jeniskelamin == 'PEREMPUAN') {
              $jeniskelaminket = '<span class="jk" >P</span>';
            } else {
              $jeniskelaminket = '<span class="jk"></span>';
            }


            if ($booked == 0) {
              if ($v['ruangan_id'] == Params::RUANGAN_ID_ANAK) :
                $result .= '<div class="detail_bed" style="float: left"><a onclick="return false;" style="text-align:left;width:100%;margin-bottom:5px;" href="" class="btn ' . (($b['status']) ? 'btn-green' : 'btn-red') . '" data-placement="right"  data-html="true" title="'.$dataPasienHover.'" data-toggle="popover" data-trigger="hover"  data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" ><img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ? 'anak-kosong' : 'anak-isi') . '.png\'/><br><br>' .  $jeniskelaminket . $b['no'] . '</a></div>';
              elseif ($v['ruangan_id'] == Params::RUANGAN_ID_PRIA) :
                $result .= '<div class="detail_bed" style="float: left"><a onclick="return false;" style="text-align:left;width:100%;margin-bottom:5px;"  href="" class="btn ' . (($b['status']) ? 'btn-green' : 'btn-red') . '" data-placement="right"  data-html="true" title="'.$dataPasienHover.'" data-toggle="popover" data-trigger="hover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" ><img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ? 'pria-kosong' : 'pria-isi') . '.png\'/><br><br>' .  $jeniskelaminket . $b['no'] . '</a></div>';
              elseif ($v['ruangan_id'] == Params::RUANGAN_ID_WANITA) :
                $result .= '<div class="detail_bed" style="float: left"><a onclick="return false;" style="text-align:left;width:100%;margin-bottom:5px;"  href="" class="btn ' . (($b['status']) ? 'btn-green' : 'btn-red') . '" data-placement="right"  data-html="true" title="'.$dataPasienHover.'" data-toggle="popover" data-trigger="hover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" ><img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ? 'wanita-kosong' : 'wanita-isi') . '.png\'/><br><br>' . $jeniskelaminket . $b['no'] . '</a></div>';
              elseif ($v['ruangan_id'] == Params::RUANGAN_ID_ICU) :
                $result .= '<div class="detail_bed" style="float: left"><a onclick="return false;" style="text-align:left;width:100%;margin-bottom:5px;"  href="" class="btn ' . (($b['status']) ? 'btn-green' : 'btn-red') . '" data-placement="right"  data-html="true" title="'.$dataPasienHover.'" data-toggle="popover" data-trigger="hover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" ><img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ? 'icu-kosong' : 'icu-isi') . '.png\'/><br><br>' .  $jeniskelaminket . $b['no'] . '</a></div>';
              elseif ($v['ruangan_id'] == Params::RUANGAN_ID_PERINATOLOGI) :
                $result .= '<div class="detail_bed" style="float: left"><a onclick="return false;" style="text-align:left;width:100%;margin-bottom:5px;"  href="" class="btn ' . (($b['status']) ? 'btn-green' : 'btn-red') . '" data-placement="right"  data-html="true" title="'.$dataPasienHover.'" data-toggle="popover" data-trigger="hover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" ><img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ? 'perina-kosong' : 'perina-isi') . '.png\'/><br><br>' . $jeniskelaminket . $b['no'] . '</a></div>';
              elseif ($v['ruangan_id'] == Params::RUANGAN_ID_BERSALIN) :
                $result .= '<div class="detail_bed" style="float: left"><a onclick="return false;" style="text-align:left;width:100%;margin-bottom:5px;"  href="" class="btn ' . (($b['status']) ? 'btn-green' : 'btn-red') . '" data-placement="right"  data-html="true" title="'.$dataPasienHover.'" data-toggle="popover" data-trigger="hover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" ><img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ? 'wanita-kosong' : 'wanita-isi') . '.png\'/><br><br>' . $jeniskelaminket . $b['no'] . '</a></div>';
              elseif ($v['ruangan_id'] == Params::RUANGAN_ID_BEDAH) :
                $result .= '<div class="detail_bed" style="float: left"><a onclick="return false;" style="text-align:left;width:100%;margin-bottom:5px;"  href="" class="btn ' . (($b['status']) ? 'btn-green' : 'btn-red') . '" data-placement="right"  data-html="true" title="'.$dataPasienHover.'" data-toggle="popover" data-trigger="hover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" ><img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ? 'bedah-kosong' : 'bedah-isi') . '.png\'/><br><br>'  . $jeniskelaminket . $b['no'] . '</a></div>';
              else :
                if ($jeniskelamin == 'LAKI-LAKI') :
                  $result .= '<div class="detail_bed" style="float: left"><a onclick="return false;"  style="text-align:left;width:100%;margin-bottom:5px;"  href="" class="btn ' . (($b['status']) ? 'btn-green' : 'btn-red') . '" data-placement="right"  data-html="true" title="'.$dataPasienHover.'" data-toggle="popover" data-trigger="hover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" ><img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ? 'pria-kosong' : 'pria-isi') . '.png\'/><br><br>' . $jeniskelaminket . $b['no'] . '</a></div>';
                elseif ($jeniskelamin == 'PEREMPUAN') :
                  $result .= '<div class="detail_bed" style="float: left"><a onclick="return false;"  style="text-align:left;width:100%;margin-bottom:5px;"  href="" class="btn ' . (($b['status']) ? 'btn-green' : 'btn-red') . '" data-placement="right"  data-html="true" title="'.$dataPasienHover.'" data-toggle="popover" data-trigger="hover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" ><img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ? 'pria-kosong' : 'wanita-isi') . '.png\'/><br><br>'  . $jeniskelaminket . $b['no'] . '</a></div>';
                else :
                  $result .= '<div class="detail_bed" style="float: left"><a onclick="return false;" style="text-align:left;width:100%;margin-bottom:5px;"  href="" class="btn ' . (($b['status']) ? 'btn-green' : 'btn-red') . '" data-placement="right"  data-html="true" title="'.$dataPasienHover.'" data-toggle="popover" data-trigger="hover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" ><img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ? 'pria-kosong' : 'wanita-isi') . '.png\'/><br><br>'  . $jeniskelaminket . $b['no'] . '</a></div>';
                endif;
              endif;
            } else {
              $result .= '<div class="detail_bed" style="float: left"><a data-html=true style="text-align:left;width:100%;margin-bottom:5px;"  href="" class="btn ' . (($b['status']) ? 'btn-danger' : 'btn-primary') . '" data-placement="right" data-html="true" title="'.$dataPasienHover.'" rel="popover" data-toggle="popover" data-trigger="hover" data-content="' . (($b['status']) ? 'Sudah dibooking' : $dataPasien) . '" onclick="return false"><img src=\'' . Yii::app()->baseUrl . '/images/' . 'RanjangRumahSakit3' . '.png\'/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $jeniskelaminket . $b['no'] . '</a></div>';
              // $result .= '<div class="detail_bed" style="float: left"><a data-html=true style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-green' : 'btn-red') . '" data-placement="right"  data-html="true" title="'.$dataPasienHover.'" data-toggle="popover" data-trigger="hover" data-content="' . (($b['status']) ? 'Sudah dibooking' : $dataPasien) . '" ><img src=\'' . Yii::app()->baseUrl . '/images/' . 'RanjangRumahSakit3' . '.png\'/>' . $jeniskelaminket . $b['no'] . '</a></div>';
            }
          }
          $jumlahBed = PPInformasikamarinapV::model()->findAll("kamarruangan_nokamar = '" . $w['name'] . "' AND ruangan_id = '" . $v['ruangan_id'] . "' AND kelaspelayanan_id = '" . $v['kelaspelayanan_id'] . "' ");
          $bed = '';

          foreach ($jumlahBed as $data) :
            $bed = $data->kamarruangan_jmlbed;
          endforeach;



          $result .= '</div>
                                    </div>
                                </li>';
        }
        $result .= '</ul>';
      }

      $result .= '</div>';
    }

    //            exit();
    return $result;
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new INInformasikamarinapV('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['INInformasikamarinapV']))
      $model->attributes = $_GET['INInformasikamarinapV'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = INInformasikamarinapV::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ininformasikamarinap-v-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new INInformasikamarinapV;
    $model->attributes = $_REQUEST['INInformasikamarinapV'];
    $judulLaporan = 'Data INInformasikamarinapV';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
