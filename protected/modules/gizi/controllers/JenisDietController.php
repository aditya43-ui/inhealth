<?php
class JenisDietController extends MyAuthController
{
  protected $path_view = 'gizi.views.jenisDiet.';
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public function actionIndex($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPendaftaran = GZPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = GZPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modJenisDiet = new GZJenisdietM;
    $dataPendaftaran = GZPendaftaranT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'tgl_pendaftaran DESC'));
    $modDetails = array();
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

    $cekDietPasien = GZDietPasienT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    if (!empty($cekDietPasien)) {  //Jika Pasien Sudah Melakukan Diet Pasien Sebelumnya
      $modDietPasien = $cekDietPasien;
    } else {
      ////Jika Pasien Belum Pernah melakukan Diet Pasein
      $modDietPasien = new GZDietPasienT;
    }

    if (isset($_POST['GZDietPasienT'])) {
      $modDietPasien->attributes = $_POST['GZDietPasienT'];
      $modDetails = $this->validasiTabular($modPendaftaran, $_POST['GZDietPasienT']);
      $transaction = Yii::app()->db->beginTransaction();
      // var_dump($_POST); die;
      try {
        $jumlah = 0;

        $modDetails = $this->validasiTabular($modPendaftaran, $_POST['GZDietPasienT']);
        foreach ($modDetails as $i => $row) {
          if ($row->save()) {
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$modDetails)) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Pemeriksaan Jenis Diet berhasil disimpan");
          $this->redirect($_POST['url']);
        } else {
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . '<pre>' . print_r($row->getErrors(), 1) . '</pre>');
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . $ex->getMessage());
      }
    }


    $modDietPasien->tgljenisdiet = $format->formatDateTimeForUser($modDietPasien->tgljenisdiet);

    $this->render(
      $this->path_view . 'index',
      array(
        'modPasien' => $modPasien,
        'modDietPasien' => $modDietPasien,
        'modPendaftaran' => $modPendaftaran,
        'modJenisDiet' => $modJenisDiet,
        'modDetails' => $modDetails,
      )
    );
  }

  protected function validasiTabular($modPendaftaran, $data)
  {
    foreach ($data as $i => $row) {

      $format = new MyFormatter();
      $modDetails[$i] = new GZDietPasienT();
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->pasien_id = $modPendaftaran->pasien_id;
      $modDetails[$i]->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
      $modDetails[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;

      $modDetails[$i]->tipediet_id = $row['tipediet_id'];
      $modDetails[$i]->jenisdiet_id = $row['jenisdiet_id'];

      $modDetails[$i]->energikalori = $row['energikalori'];
      $modDetails[$i]->protein = $row['protein'];
      $modDetails[$i]->lemak = $row['lemak'];
      $modDetails[$i]->hidratarang = $row['hidratarang'];
      $modDetails[$i]->diet_kandungan = $row['diet_kandungan'];
      $modDetails[$i]->keterangan = $row['keterangan'];
      $modDetails[$i]->alergidengan = $row['alergidengan'];

      $modDetails[$i]->pegawai_id = $_POST['pegawai_id'];
      $modDetails[$i]->tgljenisdiet = $format->formatDateTimeForDb($_POST['tglJenisDiet']);

      $modDetails[$i]->create_time = date('Y-m-d H:i:s');
      $modDetails[$i]->update_time = date('Y-m-d H:i:s');
      $modDetails[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->id;
      $modDetails[$i]->update_loginpemakai_id =  Yii::app()->user->id;
      $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modDetails[$i]->ahligizi = $_POST['ahligizi'];

      $modDetails[$i]->validate();
    }
    return $modDetails;
  }

  public function actionGetDietPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idJenisDiet = $_POST['idJenisDiet'];

      $modMenuDiet = MenuDietM::model()->findAllByAttributes(array('jenisdiet_id' => $idJenisDiet));
      $modJenisDiet = GZJenisdietM::model()->findByPk($idJenisDiet);
      //            $modBahanMakanan = BahanmakananM::model()->findByPk($bahanmakanan_id);
      //            
      //            $zatGiziBahanEner = ZatBahanMakananM::model()->findByAttributes(array('bahanmakanan_id'=>$bahanmakanan_id,'zatgizi_id'=>1));
      //            $zatGiziBahanPro = ZatBahanMakananM::model()->findByAttributes(array('bahanmakanan_id'=>$bahanmakanan_id,'zatgizi_id'=>3));
      //            $zatGiziBahanLemak = ZatBahanMakananM::model()->findByAttributes(array('bahanmakanan_id'=>$bahanmakanan_id,'zatgizi_id'=>4));
      //            $zatGiziBDD = ZatBahanMakananM::model()->findByAttributes(array('bahanmakanan_id'=>$bahanmakanan_id,'zatgizi_id'=>32));
      //            $zatGiziHidratArang = ZatBahanMakananM::model()->findByAttributes(array('bahanmakanan_id'=>$bahanmakanan_id,'zatgizi_id'=>5));
      //            
      //            $zatEnergi = $zatGiziBahanEner->kandunganbahan;
      //            $zatProtein = $zatGiziBahanPro->kandunganbahan;
      //            $zatLemak = $zatGiziBahanLemak->kandunganbahan;
      //            $zatBDD = $zatGiziBDD->kandunganbahan;
      //            $zatHidratArang = $zatGiziHidratArang->kandunganbahan;

      $modDietPasien = new GZDietPasienT;
      $rand = rand(0, 99999999);
      $nourut = 1;
      $tr = "<tr>
                        <td>" . CHtml::TextField('noUrut', $nourut, array('class' => 'span1 noUrut', 'readonly' => TRUE, 'onClick' => 'setAll(this)')) .
        CHtml::activeHiddenField($modDietPasien, '[' . $rand . ']jenisdiet_id', array('value' => $idJenisDiet, 'class' => 'menudiet_id')) .
        "</td>
                        <td>" . CHtml::activeDropDownList($modDietPasien, '[' . $rand . ']tipediet_id', CHtml::listData(TipeDietM::model()->findAll(), 'tipediet_id', 'tipediet_nama'), array('empty' => '--Pilih--', 'class' => 'span1 katpekerjaan', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                         
                        <td>" . $modJenisDiet->jenisdiet_nama . "</td>   
                        <td>" . CHtml::activetextField($modDietPasien, '[' . $rand . ']energikalori', array('onkeyup' => 'setEnergiKalori(this)', 'value' => 0, 'class' => 'span1 energikalori numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right;')) . "</td>
                        <td>" . CHtml::activetextField($modDietPasien, '[' . $rand . ']protein', array('onkeyup' => 'setProtein(this)', 'value' => 0, 'class' => 'span1 protein numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right;')) . "</td>
                        <td>" . CHtml::activetextField($modDietPasien, '[' . $rand . ']lemak', array('onkeyup' => 'setLemak(this)', 'value' => 0, 'class' => 'span1 lemak numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right;')) . "</td>
                        <td>" . CHtml::activetextField($modDietPasien, '[' . $rand . ']hidratarang', array('onkeyup' => 'setHidratArang(this)', 'value' => 0, 'class' => 'span1 hidratarang numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right;')) . "</td>
                        <td>" . CHtml::activetextField($modDietPasien, '[' . $rand . ']diet_kandungan', array('onkeyup' => 'setDietKandungan(this)', 'value' => 0, 'class' => 'span1 dietkandungan numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px; text-align: right;')) . "</td>
                        <td>" . CHtml::activeTextArea($modDietPasien, '[' . $rand . ']alergidengan', array('class' => 'span1 alergidengan', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                        <td>" . CHtml::activeTextArea($modDietPasien, '[' . $rand . ']keterangan', array('class' => 'span1 keterangan', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                        <td style=\"text-align: center\">" . CHtml::link('<i class="icon-remove"></i>', '#', array(
          'onclick' => 'removeJDiet(this)',
        )) . "</td>    
                     
                      </tr>   
                    ";

      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
