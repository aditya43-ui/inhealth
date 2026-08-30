<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAjaxGZController extends MyAuthController
{
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
      //            
      $modDietPasien = new GZDietPasienT;
      $nourut = 1;
      $tr = "<tr>
                        <td>" . CHtml::TextField('noUrut', $nourut, array('class' => 'span1 noUrut', 'readonly' => TRUE, 'onClick' => 'setAll(this)')) .
        CHtml::activeHiddenField($modDietPasien, '[' . $idJenisDiet . ']jenisdiet_id', array('value' => $idJenisDiet, 'class' => 'menudiet_id')) .
        "</td>
                        <td>" . CHtml::activeDropDownList($modDietPasien, '[' . $idJenisDiet . ']tipediet_id', CHtml::listData(TipeDietM::model()->findAll(), 'tipediet_id', 'tipediet_nama'), array('empty' => '--Pilih--', 'class' => 'span1 katpekerjaan', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                         
                        <td>" . $modJenisDiet->jenisdiet_nama . "</td>   
                        <td>" . CHtml::activetextField($modDietPasien, '[' . $idJenisDiet . ']energikalori', array('onkeyup' => 'setEnergiKalori(this)', 'value' => 0, 'class' => 'span1 energikalori numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                        <td>" . CHtml::activetextField($modDietPasien, '[' . $idJenisDiet . ']protein', array('onkeyup' => 'setProtein(this)', 'value' => 0, 'class' => 'span1 protein numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                        <td>" . CHtml::activetextField($modDietPasien, '[' . $idJenisDiet . ']lemak', array('onkeyup' => 'setLemak(this)', 'value' => 0, 'class' => 'span1 lemak numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                        <td>" . CHtml::activetextField($modDietPasien, '[' . $idJenisDiet . ']hidratarang', array('onkeyup' => 'setHidratArang(this)', 'value' => 0, 'class' => 'span1 hidratarang numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                        <td>" . CHtml::activetextField($modDietPasien, '[' . $idJenisDiet . ']diet_kandungan', array('onkeyup' => 'setDietKandungan(this)', 'value' => 0, 'class' => 'span1 dietkandungan numbersOnly', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                        <td>" . CHtml::activeTextArea($modDietPasien, '[' . $idJenisDiet . ']alergidengan', array('class' => 'span1 alergidengan', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                        <td>" . CHtml::activeTextArea($modDietPasien, '[' . $idJenisDiet . ']keterangan', array('class' => 'span1 keterangan', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>
                     
                      </tr>   
                    ";

      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetJenisKonsul()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idKelasPelayan = $_POST['kelasPelayan_id'];

      $criteria = new CDbCriteria;
      $criteria->select = 'count(daftartindakan_m.daftartindakan_id),daftartindakan_m.daftartindakan_id,daftartindakan_m.daftartindakan_nama,
                                t.kelaspelayanan_id, sum(t.harga_tariftindakan) as harga_tariftindakan,(t.persendiskon_tind) as persendiskon_tind,
                                (t.hargadiskon_tind) as hargadiskon_tind, (t.persencyto_tind) as persencyto_tind';
      $criteria->group = 'daftartindakan_m.daftartindakan_id,daftartindakan_m.daftartindakan_nama,t.kelaspelayanan_id,
                                daftartindakan_m.daftartindakan_id,t.persendiskon_tind, t.persencyto_tind, t.hargadiskon_tind';
      $criteria->compare('daftartindakan_m.daftartindakan_konsul', true);
      $criteria->compare('t.kelaspelayanan_id', $idKelasPelayan);
      $criteria->join = 'LEFT JOIN daftartindakan_m ON t.daftartindakan_id = daftartindakan_m.daftartindakan_id';

      $modTindakan = TariftindakanM::model()->findAll($criteria);

      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial('_formTarifKonsul', array(
          'modTindakan' => $modTindakan,
          'idKelasPelayan' => $idKelasPelayan
        ), true)
      ));
      exit;
    }
  }

  public function actionBatalMenuDiet()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPesanDiet = $_POST['idPesanDiet'];
      $modelPesan = new PesanmenudietT;
      $model = PesanmenudietT::model()->findByPk($idPesanDiet);
      $modDetail = PesanmenudetailT::model()->findAllByAttributes(array('pesanmenudiet_id' => $model->pesanmenudiet_id));
      $modPegawai = PesanmenupegawaiT::model()->findAllByAttributes(array('pesanmenudiet_id' => $model->pesanmenudiet_id));

      $totDet = count((array)$modDetail);
      $totPeg = count((array)$modPegawai);

      if (isset($_POST['PesanmenupegawaiT']) || isset($_POST['PesanmenudetailT'])) {
        if (count((array)$modDetail) > 0 || count((array)$modPegawai) > 0) {
          if (count((array)$modPegawai) > 0) {
            // Untuk Menghapus Pesan Menu Diet untuk Pegawai
            if (count((array)$_POST['PesanmenupegawaiT']) > 0) {
              foreach ($_POST['PesanmenupegawaiT'] as $i => $v) {
                if (isset($v['checkList'])) {
                  if (empty($v['kirimmenupegawai_id'])) {
                    $detail = false;
                  } else {
                    $detail = true;
                    $updatePesanPegawai = PesanmenupegawaiT::model()->updateByPk($v['pesanmenupegawai_id'], array('kirimmenupegawai_id' => null));
                    $updateKirimPegawai = KirimmenupegawaiT::model()->updateByPk($v['kirimmenupegawai_id'], array('pesanmenupegawai_id' => null));
                    if (count((array)$modPegawai) <= 1) {
                      $updatePesanDiet = KirimmenudietT::model()->updateByPk($V['kirimmenudiet_id'], array('pesanmenudiet_id' => null));
                      $updateKirimDiet = PesanmenudietT::model()->updateByPk($idPesanDiet, array('kirimmenudiet_id' => null));
                    }
                  }

                  if ($detail == true) {
                    $deletePegawai = PesanmenupegawaiT::model()->deleteByPk($v['pesanmenupegawai_id']);
                    if ($updatePesanPegawai && $updatePesanDiet && $updateKirimPegawai && $updateKirimDiet) {
                      $delete = true;
                    } else {
                      $delete = false;
                    }
                  } else {
                    $deletePegawai = PesanmenupegawaiT::model()->deleteByPk($v['pesanmenupegawai_id']);
                    if ($deletePegawai) {
                      $delete = true;
                    } else {
                      $delete = false;
                    }
                  }
                  $totPeg = count(PesanmenupegawaiT::model()->findAllByAttributes(array('pesanmenudiet_id' => $idPesanDiet)));
                }
              }
              if ($delete == true) {
                if ($totPeg < 1) {
                  PesanmenudietT::model()->deleteByPk($idPesanDiet);
                }
                echo CJSON::encode(array(
                  'status' => 'proses_form',
                  'pesan' => 'Berhasil',
                  'keterangan' => '',
                  'total' => $totPeg,
                  'div' => "<div class='flash-success'>Pemesanan Menu Diet <b></b> berhasil dibatalkan </div>",
                ));
                exit;
              } else {
                echo CJSON::encode(array(
                  'status' => 'proses_form',
                  'pesan' => 'Gagal',
                  'keterangan' => '',
                  'total' => $totPeg,
                  'div' => "<div class='flash-success'>Pemesanan Menu Diet <b></b> gagal dibatalkan </div>",
                ));
                exit;
              }
            }
          } else {
            if (count((array)$_POST['PesanmenudetailT']) > 0) {
              $jml = 0;
              foreach ($_POST['PesanmenudetailT'] as $i => $v) {
                if (isset($v['checkList'])) {
                  //                            foreach($modDetail as $i=>$detail){
                  if (empty($v['kirimmenupasien_id'])) {
                    $details = false;
                  } else {
                    $details = true;
                    $updatePesanPasien = PesanmenudetailT::model()->updateByPk($v['pesanmenudetail_id'], array('kirimmenupasien_id' => null));
                    $updateKirimPasien = KirimmenupasienT::model()->updateByPk($v['kirimmenupasien_id'], array('pesanmenudetail_id' => null));

                    if (count((array)$modDetail) <= 1) {
                      $updatePesanDiet = KirimmenudietT::model()->updateByPk($v['kirimenudiet_id'], array('pesanmenudiet_id' => null));
                      $updateKirimDiet = PesanmenudietT::model()->updateByPk($idPesanDiet, array('kirimmenudiet_id' => null));
                    }
                  }
                  //                            }
                  // Untuk Menghapus menu Gizi dari PesanmenudetailT                    
                  if ($details == true) {
                    $deleteDetail = PesanmenudetailT::model()->deleteByPk($v['pesanmenudetail_id']);
                    if ($updatePesanPasien && $updatePesanDiet && $updateKirimPasien && $updateKirimDiet && $deleteDetail) {
                      $tindakan = true;
                    } else {
                      $tindakan = false;
                    }
                  } else {
                    $deleteDetail = PesanmenudetailT::model()->deleteByPk($v['pesanmenudetail_id']);
                    if ($deleteDetail) {
                      $tindakan = true;
                    } else {
                      $tindakan = false;
                    }
                  }
                  $jml++;
                  $totDet = count(PesanmenudetailT::model()->findAllByAttributes(array('pesanmenudiet_id' => $idPesanDiet)));
                }
              }
              if ($tindakan == true) {
                if ($totDet < 1) {
                  PesanmenudietT::model()->deleteByPk($idPesanDiet);
                }
                // Untuk Menghapus Data Kirim Menu Diet dari PesanmenudietT
                echo CJSON::encode(array(
                  'status' => 'proses_form',
                  'pesan' => 'Berhasil',
                  'keterangan' => '',
                  'total' => $totDet,
                  'div' => "<div class='flash-success'>Pemesanan Menu Diet <b></b> berhasil dibatalkan </div>",
                ));
                exit;
              } else {
                echo CJSON::encode(array(
                  'status' => 'proses_form',
                  'pesan' => 'Gagal',
                  'keterangan' => '',
                  'total' => $totDet,
                  'div' => "<div class='flash-success'>Pemesanan Menu Diet <b></b> gagal dibatalkan </div>",
                ));
                exit;
              }
              //                echo $jml;
            }
          }
        }
      }
      /* 
       * Tidak dipake .. ini untuk bypass penghapusan ke PesanmenudietT 
       else{
           if(count((array)$model) > 0){
               $deletePesan = PesanmenudietT::model()->deleteByPk($idPesanDiet);
               if($deletePesan){
                   if (Yii::app()->request->isAjaxRequest)
                   {
                       echo CJSON::encode(array(
                           'status'=>'proses_form', 
                           'pesan'=>'Berhasil',
                           'keterangan'=>'',
                           'total'=>$totDet,
                           'div'=>"<div class='flash-success'>Pengiriman Menu Diet <b></b> berhasil dibatalkan </div>",
                           ));
                       exit;               
                   }
               }else{
                   if (Yii::app()->request->isAjaxRequest)
                   {
                       echo CJSON::encode(array(
                           'status'=>'proses_form', 
                           'pesan'=>'Gagal',
                           'keterangan'=>'',
                           'total'=>$totDet,
                           'div'=>"<div class='flash-success'>Pengiriman Menu Diet <b></b> gagal dibatalkan </div>",
                           ));
                       exit;               
                   }
               }
           }
       }
       /*
        * 
        */
      echo CJSON::encode(array(
        'status' => 'create_form',
        'idPesan' => $idPesanDiet,
        'total' => $totDet,
        'div' => $this->renderPartial('_formBatalPesanDiet', array('modelPesan' => $modelPesan, 'modDetail' => $modDetail, 'modPegawai' => $modPegawai, 'model' => $model), true)
      ));
      exit;
    }
  }
}
