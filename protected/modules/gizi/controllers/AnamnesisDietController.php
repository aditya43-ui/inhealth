
<?php

class AnamnesisDietController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.anamnesisDiet.';

  public function actionIndex($pendaftaran_id, $pasien_id = null, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = GZPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = GZPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $dataPendaftaran = GZPendaftaranT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'tgl_pendaftaran DESC'));
    //print_r($lastPendaftaran);
    //echo $modPasien->pasien_id;exit();

    $i = 1;
    if (count((array)$dataPendaftaran) > 1) {
      foreach ($dataPendaftaran as $row) {
        if ($i == 2) {
          $lastPendaftaran = $row->pendaftaran_id;
        }
        $i++;
      }
    } else {
      $lastPendaftaran = $pendaftaran_id;
    }

    $cekAnamnesa = GZAnamnesaDietT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    if (!empty($cekAnamnesa)) {  //Jika Pasien Sudah Melakukan Anamnesa Sebelumnya
      $modAnamnesa = $cekAnamnesa;
    } else {
      ////Jika Pasien Belum Pernah melakukan Anamnesa
      $modAnamnesa = new GZAnamnesaDietT;
      //                $modAnamnesa->pegawai_id=$modPendaftaran->pegawai_id;
      //                $modAnamnesa->tglanamesadiet=date('Y-m-d H:i:s');

    }

    if (isset($_POST['GZAnamnesaDietT'])) {
      // var_dump($_POST);

      $modAnamnesa->attributes = $_POST['GZAnamnesaDietT'];
      $modDetails = $this->validasiTabular($modPendaftaran, $_POST['GZAnamnesaDietT']);
      //                                    echo '<pre>';
      //                                    echo print_r($_POST['GZAnamnesaDietT']);
      //                                    exit();
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;

        //                        if($modAnamnesa->save()){
        //$modDetails = $this->validasiTabular($modPendaftaran, $_POST['GZAnamnesaDietT']);
        foreach ($modDetails as $i => $row) {
          //                                                $modRencanaprodet = new RencanaprodetM;
          //                                                $modRencanaprodet->rencanaproduksi_id = $model->rencanaproduksi_id;
          //                                                
          //                                                $modRencanaprodet->attributes = $row;
          if ($row->save()) {
            $jumlah++;
          }
        }
        //                        }
        //var_dump($jumlah == count((array)$modDetails));
        //die;
        if ($jumlah == count((array)$modDetails)) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Anamnesa Diet berhasil disimpan");
          $this->redirect($_POST['url']);
        } else {
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . '<pre>' .
            print_r($row->getErrors(), 1) . '</pre>');

          //                            Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . $ex->getMessage());
      }
    } else {
      $modDetails = null;
    }


    $modAnamnesa->tglanamesadiet = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modAnamnesa->tglanamesadiet, 'yyyy-MM-dd hh:mm:ss')
    );

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa,
      'modDetails' => $modDetails,
    ));
  }


  protected function validasiTabular($modPendaftaran, $data)
  {
    foreach ($data as $i => $row) {

      //            if(is_integer($row)){
      $format = new MyFormatter();
      $modDetails[$i] = new GZAnamnesaDietT();
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->pasien_id = $modPendaftaran->pasien_id;
      $modDetails[$i]->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
      $modDetails[$i]->jeniswaktu_id = $modDetails[$i]['jeniswaktu_id'];
      $modDetails[$i]->bahanmakanan_id = $row['bahanmakanan_id'];
      $modDetails[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      //                $modDetails[$i]->pekerjaan_id = $modPendaftaran->pekerjaan_id;
      $modDetails[$i]->menudiet_id = $row['menudiet_id'];
      $modDetails[$i]->katpekerjaan = $row['katpekerjaan'];
      $modDetails[$i]->beratbahan = MyFormatter::formatNumberForDb($row['beratbahan']);
      $modDetails[$i]->energikalori = MyFormatter::formatNumberForDb($row['energikalori']);
      $modDetails[$i]->protein = MyFormatter::formatNumberForDb($row['protein']);
      $modDetails[$i]->lemak = MyFormatter::formatNumberForDb($row['lemak']);
      $modDetails[$i]->hidratarang = MyFormatter::formatNumberForDb($row['hidratarang']);
      $modDetails[$i]->urt = $row['urt'];
      $modDetails[$i]->tglanamesadiet = $format->formatDateTimeForDb($_POST['tglAnamnesadiet']);
      $modDetails[$i]->pegawai_id = $_POST['pegawai_id'];
      $modDetails[$i]->keterangan = $row['keterangan'];
      $modDetails[$i]->create_time = date('Y-m-d H:i:s');
      $modDetails[$i]->update_time = date('Y-m-d H:i:s');
      $modDetails[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->id;
      $modDetails[$i]->update_loginpemakai_id =  Yii::app()->user->id;
      $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modDetails[$i]->ahligizi = $_POST['ahligizi'];
      //                    echo '<pre>';
      //                    echo print_r($modDetails[$i]->attributes);
      //                    echo '</pre>';
      $modDetails[$i]->validate();
      // var_dump($modDetails[$i]->attributes, $modDetails[$i]->errors);
      //            }    

    }
    return $modDetails;
  }

  /**
   * Untuk menambahkan row pada tabel
   */
  public function actionGetKomposisiMakanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $jeniswaktu_id = (isset($_POST['jeniswaktu_id']) ? $_POST['jeniswaktu_id'] : null);
      $menudiet_id = (isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null);
      $bahanmakanan_id = (isset($_POST['bahanmakanan_id']) ? $_POST['bahanmakanan_id'] : null);

      $modJeniswaktu = JeniswaktuM::model()->findByPk($jeniswaktu_id);
      $modMenuDiet = MenuDietM::model()->findByPk($menudiet_id);
      $modBahanMakanan = BahanmakananM::model()->findByPk($bahanmakanan_id);


      $zatGiziBahanEner = ZatBahanMakananM::model()->findByAttributes(array('bahanmakanan_id' => $bahanmakanan_id, 'zatgizi_id' => 1));
      $zatGiziBahanPro = ZatBahanMakananM::model()->findByAttributes(array('bahanmakanan_id' => $bahanmakanan_id, 'zatgizi_id' => 3));
      $zatGiziBahanLemak = ZatBahanMakananM::model()->findByAttributes(array('bahanmakanan_id' => $bahanmakanan_id, 'zatgizi_id' => 4));
      $zatGiziBDD = ZatBahanMakananM::model()->findByAttributes(array('bahanmakanan_id' => $bahanmakanan_id, 'zatgizi_id' => 32));
      $zatGiziHidratArang = ZatBahanMakananM::model()->findByAttributes(array('bahanmakanan_id' => $bahanmakanan_id, 'zatgizi_id' => 5));

      $zatEnergi = (isset($zatGiziBahanEner->kandunganbahan) ? number_format($zatGiziBahanEner->kandunganbahan, 2, ",", "") : 0);
      $zatProtein = (isset($zatGiziBahanPro->kandunganbahan) ? number_format($zatGiziBahanPro->kandunganbahan, 2, ",", "") : 0);
      $zatLemak = (isset($zatGiziBahanLemak->kandunganbahan) ? number_format($zatGiziBahanLemak->kandunganbahan, 2, ",", "") : 0);
      $zatBDD = (isset($zatGiziBDD->kandunganbahan) ? $zatGiziBDD->kandunganbahan : 0);
      $zatHidratArang = (isset($zatGiziHidratArang->kandunganbahan) ? number_format($zatGiziHidratArang->kandunganbahan, 2, ",", "") : 0);
      //            
      $modAnamnesa = new GZAnamnesaDietT;
      $nourut = 1;
      $tr = "<tr>
                        <td>" . CHtml::TextField('noUrut', $nourut, array('class' => 'span1 noUrut', 'readonly' => TRUE, 'onClick' => 'setAll(this)')) .
        CHtml::activeHiddenField($modAnamnesa, '[' . $jeniswaktu_id . ']menudiet_id', array('value' => $menudiet_id, 'class' => 'menudiet_id')) .
        CHtml::activeHiddenField($modAnamnesa, '[' . $jeniswaktu_id . ']bahanmakanan_id', array('value' => $bahanmakanan_id, 'class' => 'bahanmakanan_id')) .
        CHtml::activeHiddenField($modAnamnesa, '[' . $jeniswaktu_id . ']jeniswaktu_id', array('value' => $jeniswaktu_id, 'class' => 'jeniswaktu_id')) .
        "</td>
						<td>" . $modJeniswaktu->jeniswaktu_nama .
        "</td>
						<td>" . $modMenuDiet->menudiet_nama .
        "</td>
                        <td>" . $modBahanMakanan->namabahanmakanan . "</td>
                        <td>" . $modBahanMakanan->satuanbahan . "</td>
                        
                        <td>" . CHtml::activetextField($modAnamnesa, '[' . $jeniswaktu_id . ']beratbahan', array('onkeyup' => 'setBeratBahan(this);', 'value' => 0, 'class' => 'span1  beratbahan numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right')) . "</td>
                        <td>" . CHtml::activetextField($modAnamnesa, '[' . $jeniswaktu_id . ']energikalori', array('value' => (empty($zatEnergi) ?  "0" : $zatEnergi), 'class' => 'span1 energikalori numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right', 'onkeyup' => 'setBeratBahan(this);')) .
        CHtml::activeHiddenField($modAnamnesa, '[' . $jeniswaktu_id . ']energikalori2', array('value' => (empty($zatEnergi) ?  "0" : $zatEnergi), 'class' => 'span1 energikalori2 numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right')) .
        "</td>
                        <td>" . CHtml::activetextField($modAnamnesa, '[' . $jeniswaktu_id . ']protein', array('value' => (empty($zatProtein) ?  "0" : $zatProtein), 'class' => 'span1 protein numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right', 'onkeyup' => 'setBeratBahan(this);')) . "</td>
                        <td>" . CHtml::activetextField($modAnamnesa, '[' . $jeniswaktu_id . ']lemak', array('value' => (empty($zatLemak) ?  "0" : $zatLemak), 'class' => 'span1 lemak numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right', 'onkeyup' => 'setBeratBahan(this);')) . "</td>
                        <td>" . CHtml::activetextField($modAnamnesa, '[' . $jeniswaktu_id . ']hidratarang', array('value' => (empty($zatHidratArang) ?  "0" : $zatHidratArang), 'class' => 'span1 hidratarang numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right', 'onkeyup' => 'setBeratBahan(this);')) .
        CHtml::activeHiddenField($modAnamnesa, '[' . $jeniswaktu_id . ']bdd', array('value' => (empty($zatBDD) ?  "0" : $zatBDD), 'class' => 'span1 bdd numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right')) .
        "</td>
                        <td>" . CHtml::activeDropDownList($modAnamnesa, '[' . $jeniswaktu_id . ']katpekerjaan', LookupM::getItems('katpekerjaan'), array('empty' => '--Pilih--', 'class' => 'span1 katpekerjaan', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                        <td>" . CHtml::activeTextField($modAnamnesa, '[' . $jeniswaktu_id . ']urt', array('class' => 'span1 urt', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                        <td>" . CHtml::activeTextArea($modAnamnesa, '[' . $jeniswaktu_id . ']keterangan', array('class' => 'span1 keterangan', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                        <td>" . CHtml::link("<span class='icon-remove'>&nbsp;</span>", '', array('href' => '#', 'onclick' => 'hapusList(this);return false;', 'style' => 'text-decoration:none;')) . "</td>
                      </tr>   
                    ";

      $data['tr'] = $tr;
      $data['sat'] = $modBahanMakanan->satuanbahan;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
?>
