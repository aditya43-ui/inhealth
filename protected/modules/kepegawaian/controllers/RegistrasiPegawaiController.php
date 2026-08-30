<?php

class RegistrasiPegawaiController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionGetTemplateFingerUser()
  {
    if (isset($_GET['idAlat'])) {
      $data = AlatfingerM::model()->findByPk($_GET['idAlat'])->attributes;
      $Connect = $this->connection($data['ipfinger']);
      $key = $data['keyfinger'];
      if ($Connect) {
        $soap_request = "<GetUserTemplate><ArgComKey xsi:type=\"xsd:integer\">" . $key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN><FingerID xsi:type=\"xsd:integer\">Finger Number</FingerID></Arg></GetUserTemplate>";
        $newLine = "\r\n";
        fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
        fputs($Connect, "Content-Type: text/xml" . $newLine);
        fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
        fputs($Connect, $soap_request . $newLine);
        $buffer = "";
        while ($Response = fgets($Connect, 1024)) {
          $buffer = $buffer . $Response;
        }
        $buffer = $this->ParseData($buffer, "<GetUserTemplateResponse>", "</GetUserTemplateResponse>");
        $buffer = explode("\r\n", $buffer);

        $result = array();
        for ($a = 0; $a < count((array)$buffer); $a++) {
          $data = $this->ParseData($buffer[$a], "<Row>", "</Row>");
          $hasil = $this->ParseData($data, "<Size>", "</Size>");
          print_r($hasil);

          /*
						$hasil = $this->ParseData($data,"<PIN>","</PIN>");
						if (!empty($hasil))
						{
							$result[$a]['no'] = $a;
							$result[$a]['pin']=$this->ParseData($data,"<PIN2>","</PIN2>");
							$result[$a]['name']=$this->ParseData($data,"<Name>","</Name>");
						}*/
        }

        $form = '';
        foreach ($result as $val) {
          $form .= '<tr><td>' . $val['no'] . '</td><td>' . $val['pin'] . '</td><td>' . $val['name'] . '</td></tr>';
        }

        $rec = array(
          'status' => ($result > 0 ? 1 : 0),
          'form' => $form
        );
        echo json_encode($rec);
      }
    }
  }

  public function actionGetFingerUser()
  {
    if (Yii::app()->request->isAjaxRequest) {

      if (isset($_GET['idAlat'])) {
        $data = AlatfingerM::model()->findByPk($_GET['idAlat'])->attributes;
        $Connect = $this->connection($data['ipfinger']);
        $key = $data['keyfinger'];
        if ($Connect) {
          $soap_request = "<GetUserInfo><ArgComKey xsi:type=\"xsd:integer\">" . $key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetUserInfo>";
          $newLine = "\r\n";
          fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
          fputs($Connect, "Content-Type: text/xml" . $newLine);
          fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
          fputs($Connect, $soap_request . $newLine);
          $buffer = "";
          while ($Response = fgets($Connect, 1024)) {
            $buffer = $buffer . $Response;
          }
          $buffer = $this->ParseData($buffer, "<GetUserInfoResponse>", "</GetUserInfoResponse>");
          $buffer = explode("\r\n", $buffer);

          $result = array();
          for ($a = 0; $a < count((array)$buffer); $a++) {
            $data = $this->ParseData($buffer[$a], "<Row>", "</Row>");
            $hasil = $this->ParseData($data, "<PIN>", "</PIN>");
            if (!empty($hasil)) {
              $result[$a]['no'] = $a;
              $result[$a]['pin'] = $this->ParseData($data, "<PIN2>", "</PIN2>");
              $result[$a]['name'] = $this->ParseData($data, "<Name>", "</Name>");
            }
          }
          $form = '';
          foreach ($result as $val) {
            $form .= '<tr><td>' . $val['no'] . '</td><td>' . $val['pin'] . '</td><td>' . $val['name'] . '</td></tr>';
          }

          $rec = array(
            'status' => ($result > 0 ? 1 : 0),
            'form' => $form
          );
          echo json_encode($rec);
        }
      }
      Yii::app()->end();
    }
  }

  public function actionUpdataStatusFinger()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $idAlat = $_GET['idAlat'];
      $result = AlatfingerM::model()->updateByPk(
        $idAlat,
        array('alat_aktif' => false)
      );

      echo json_encode($result);
      Yii::app()->end();
    }
  }

  public function actionInformasiKoneksi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $is_aktif = false;
      if (isset($_GET['idAlat'])) {
        $idAlat = $_GET['idAlat'];
        $value = AlatfingerM::model()->updateByPk(
          $idAlat,
          array('alat_aktif' => true)
        );
        $data = AlatfingerM::model()->findByPk($idAlat)->attributes;
        $connection = $this->cekConnection($data['ipfinger']);
        if (!$connection) {
          $value = AlatfingerM::model()->updateByPk(
            $idAlat,
            array('alat_aktif' => false)
          );
        }

        $form = '
					<div id="infokoneksi" tag="' . $idAlat . '">
						<div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">Status</label>
							<div class="controls" id="status-connection">' . ($connection ? 'Success' : '<div class=\'error\'>Failed</div>') . '</div>
						</div>
						<div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">IP</label>
							<div class="controls" id="ip-connection">
								' .
          ($connection ? CHtml::link(
            $data['ipfinger'],
            '#',
            array(
              'onClick' => 'getInformasiUser("' . $_GET['idAlat'] . '");return false;',
              'rel' => 'tooltip',
              'data-original-title' => 'Click untuk mengetahui data User',
            )
          ) : $data['ipfinger'])
          . '
							</div>
						</div>
						<div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">Lokasi</label>
							<div class="controls" id="lokasi-connection">' . $data['lokasifinger'] . '</div>
						</div>
					</div>
				';
        $is_aktif = true;
      }
      $result = array(
        'form' => $form,
        'is_aktif' => $is_aktif,
      );

      echo json_encode($result);
      Yii::app()->end();
    }
  }

  public function actionSimpanRegistrasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_REQUEST['data'], $data_parsing);

      $transaction = Yii::app()->db->beginTransaction();
      $data_alat = array();
      foreach ($data_parsing['alatfinger_id'] as $val) {
        $modAlat = AlatfingerM::model()->findByPk(
          $val,
          'alat_aktif = true'
        );
        if ($modAlat) {
          if (isset($data_parsing['KPRegistrasifingerprint'])) {
            $data = array_filter($data_parsing['KPRegistrasifingerprint'], 'strlen');
            $data_alat[$val]['POST'] = count((array)$data);

            if (count((array)$data) > 0) {
              $modDetails = $this->validasiTabular($data);
              $jumlah = 0;
              foreach ($modDetails as $i => $v) {
                $cek_id = KPRegistrasifingerprint::model()->findByAttributes(
                  array(
                    'nofingerprint' => $v->nofingerprint
                  )
                );
                if (is_null($cek_id->pegawai_id)) {
                  $update = KPRegistrasifingerprint::model()->updateByPk(
                    $v->pegawai_id,
                    array(
                      'nofingerprint' => $v->nofingerprint,
                      'update_time' => date('Y-m-d')
                    )
                  );
                  if ($update) {
                    $fingerHistori = new KPNofingeralatM;
                    $fingerHistori->create_loginpemakai_id = Yii::app()->user->id;
                    $fingerHistori->update_loginpemakai_id = Yii::app()->user->id;
                    $fingerHistori->alatfinger_id = $modAlat->alatfinger_id;
                    $fingerHistori->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $fingerHistori->pegawai_id = $v->pegawai_id;
                    $fingerHistori->tglregistrasifinger = date('Y-m-d H:i:s');
                    $fingerHistori->create_time = date('Y-m-d H:i:s');
                    $fingerHistori->nofinger = $v->nofingerprint;
                    if ($fingerHistori->save() && ($this->insertData($v, $modAlat->ipfinger, $modAlat->keyfinger))) {
                      $jumlah++;
                    }
                  }
                }
              }
              $data_alat[$val]['simpan'] = $jumlah;
            }
          }
        }
      }
      $is_success = true;
      foreach ($data_alat as $key => $val) {
        if ($val['POST'] != $val['simpan'] || $is_success == false) {
          $is_success = false;
        }
      }

      $result = array();
      if ($is_success) {
        $transaction->commit();
        $result = array(
          'is_success' => 1,
          'pesan' => 'simpan data berhasil'
        );
      } else {
        $transaction->rollback();
        $result = array(
          'is_success' => 0,
          'pesan' => 'simpan data gagal'
        );
      }

      echo json_encode($result);
      Yii::app()->end();
    }
  }

  public function actionAdmin()
  {
    $model = new KPRegistrasifingerprint();
    $modPegawai = new KPPegawaiM();

    $modDetails = array();
    $model->pegawai_id = 0;
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_GET['idAlat']) && !isset($_GET['disconnect'])) {
        AlatfingerM::model()->updateAll(array('alat_aktif' => false));
        $idAlat = $_GET['idAlat'];
        $value = AlatfingerM::model()->updateByPk($idAlat, array('alat_aktif' => true));
        $result['success'] = $value;
        $result['data'] = AlatfingerM::model()->findByPk($idAlat)->attributes;
        $result['connection'] = $this->cekConnection($result['data']['ipfinger']);
        $result['time'] = date('d M Y');
        echo json_encode($result);
        Yii::app()->end();
      } else if (isset($_GET['idAlat']) && isset($_GET['disconnect'])) {
        $value = AlatfingerM::model()->updateAll(array('alat_aktif' => false));
        $result['success'] = true;
        echo json_encode($result);
        Yii::app()->end();
      }
    }

    if (isset($_GET['KPRegistrasifingerprint'])) {
      $model->unsetAttributes();
      $model->attributes = $_GET['KPRegistrasifingerprint'];
      $model->jabatansampai = $_GET['KPRegistrasifingerprint']['jabatansampai'];
      $model->nipsampai = $_GET['KPRegistrasifingerprint']['nipsampai'];
      $model->namasampai = $_GET['KPRegistrasifingerprint']['namasampai'];
      $model->kelompoksampai = $_GET['KPRegistrasifingerprint']['kelompoksampai'];
    }

    $this->render('index', array(
      'model' => $model, 'modDetails' => $modDetails, 'modPegawai' => $modPegawai
    ));
  }

  private function connection($ip)
  {
    $result = false;
    if (fsockopen($ip, "80", $errno, $errstr, 1)) {
      $result = fsockopen($ip, "80", $errno, $errstr, 1);
    }
    return $result;
  }

  private function cekConnection($ip)
  {
    $result = false;
    if (fsockopen($ip, "80", $errno, $errstr, 1)) {
      $result = true;
    }
    return $result;
  }

  protected function insertData($model, $IP, $Key)
  {
    $Connect = $this->connection($IP);
    if ($Connect) {
      $soap_request = "<SetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg>
                        <PIN>" . $model->nofingerprint . "</ PIN>
                        <Name>" . $model->nama_pegawai . "</Name>
                        </Arg></SetUserInfo>";
      $newLine = "\r\n";
      fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
      fputs($Connect, "Content-Type: text/xml" . $newLine);
      fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
      fputs($Connect, $soap_request . $newLine);
      $buffer = "";
      while ($Response = fgets($Connect, 1024)) {
        $buffer = $buffer . $Response;
      }
      $buffer = $this->ParseData($buffer, "<Information>", "</Information>");
      if ($buffer == 'Successfully!') {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  protected function ParseData($data, $p1, $p2)
  {
    $data = " " . $data;
    $hasil = "";
    $awal = strpos($data, $p1);
    if ($awal != "") {
      $akhir = strpos(strstr($data, $p1), $p2);
      if ($akhir != "") {
        $hasil = substr($data, $awal + strlen($p1), $akhir - strlen($p1));
      }
    }
    return $hasil;
  }

  protected function validasiTabular($data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = KPRegistrasifingerprint::model()->findByPk($i);
      $modDetails[$i]->nofingerprint = $row;
      $modDetails[$i]->validate();
    }
    return $modDetails;
  }

  public function actionInformasi()
  {

    $model = new KPRegistrasifingerprint('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPRegistrasifingerprint']))
      $model->attributes = $_GET['KPRegistrasifingerprint'];

    $this->render('informasi', array(
      'model' => $model,
    ));
  }

  public function loadModel($id)
  {
    $model = KPRegistrasifingerprint::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }
}
