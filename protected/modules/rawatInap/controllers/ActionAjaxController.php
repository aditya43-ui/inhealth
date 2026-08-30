<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAjaxController extends MyAuthController
{
  public function actionCekHakAkses()
  {
    if (!Yii::app()->user->checkAccess('Pembatalan Pulang')) {
      //throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
      $data['cekAkses'] = false;
    } else {
      //echo 'punya hak akses';
      $data['cekAkses'] = true;
      $data['userid'] = Yii::app()->user->id;
      $data['username'] = Yii::app()->user->name;
    }

    echo CJSON::encode($data);
    Yii::app()->end();
  }

  public function actiondataPasien()
  {
    $pasien_id = $_POST['pasien_id'];
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $modPasien = RIPasienM::model()->findByPk($pasien_id);
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $form = $this->renderPartial('/_ringkasDataPasien', array(
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
    ), true);
    $data['form'] = $form;
    echo CJSON::encode($data);
  }

  public function actionLoadFormDiagnosis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idDiagnosa = $_POST['idDiagnosa'];
      $idKelDiagnosa = $_POST['idKelDiagnosa'];
      $tglDiagnosa = $_POST['tglDiagnosa'];

      $modDiagnosaicdixM = DiagnosaicdixM::model()->findAll();
      $modSebabDiagnosa = SebabdiagnosaM::model()->findAll();
      $modDiagnosa = DiagnosaM::model()->findByPk($idDiagnosa);

      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial('/diagnosaTRI/_formLoadDiagnosis', array(
          'modDiagnosa' => $modDiagnosa,
          'idKelDiagnosa' => $idKelDiagnosa,
          'modDiagnosaicdixM' => $modDiagnosaicdixM,
          'modSebabDiagnosa' => $modSebabDiagnosa,
          'tglDiagnosa' => $tglDiagnosa
        ), true)
      ));
      exit;
    }
  }

  public function actionloadDataPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = RIInfokunjunganriV::model()->findByAttributes(array('no_rekam_medik' => $_POST['no_rekam_medik']));
      $post = array(
        'tgl_pendaftaran' => $data->tgl_pendaftaran,
        'no_pendaftaran' => $data->no_pendaftaran,
        'umur' => $data->umur,
        'jeniskasuspenyakit_nama' => $data->jeniskasuspenyakit_nama,
        'instalasi_nama' => $data->instalasi_nama,
        'ruangan_nama' => $data->ruangan_nama,
        'pendaftaran_id' => $data->pendaftaran_id,
        'pasien_id' => $data->pasien_id,
        'jeniskelamin' => $data->jeniskelamin,
        'statusperkawinan' => $data->statusperkawinan,
        'nama_pasien' => $data->nama_pasien,
        'nama_bin' => $data->nama_bin,
      );
      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }

  public function actionLoadTindakanKomponenPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];

      $tindakans = TindakanpelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id,));
      foreach ($tindakans as $i => $tindakan) {
        $returnVal[$tindakan->tindakanpelayanan_id]['daftartindakan_id'] = $tindakan->daftartindakan_id;
        $returnVal[$tindakan->tindakanpelayanan_id]['daftartindakan_nama'] = $tindakan->daftartindakan->daftartindakan_nama;
        $komponens = TindakankomponenT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id));
        foreach ($komponens as $j => $komponen) {
          $tindKomponenId = $komponen->tindakankomponen_id;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tindakankomponen_id'] = $tindKomponenId;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['komponentarif_id'] = $komponen->komponentarif_id;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['komponentarif_nama'] = $komponen->komponentarif->komponentarif_nama;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tarif_kompsatuan'] = $komponen->tarif_kompsatuan;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tarif_tindakankomp'] = $komponen->tarif_tindakankomp;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tarifcyto_tindakankomp'] = $komponen->tarifcyto_tindakankomp;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['subsidiasuransikomp'] = $komponen->subsidiasuransikomp;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['subsidipemerintahkomp'] = $komponen->subsidipemerintahkomp;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['subsidirumahsakitkomp'] = $komponen->subsidirumahsakitkomp;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['iurbiayakomp'] = $komponen->iurbiayakomp;
        }
      }

      $form = $this->renderPartial('_formPembebasanTarif', array('data' => $returnVal), true);
      $returnVal['tabelPembebasanTarif'] = $form;

      echo CJSON::encode($returnVal);
    }
  }

  /*
         * Ajax for ObatAlkes rawatInap/UnitDosis
         */
  public function actionObatUnitDosis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idObat = $_POST['idObat'];
      $qtyObat = $_POST['qtyObat'];
      $jmlHari = $_POST['jmlHari'];

      $modDetailUnitDosis = new UnitdosisdetailT;

      $modObatAlkes = ObatalkesM::model()->findByPk($idObat);
      $tr = "<tr>
                            <td style='text-align:center'>" . CHtml::TextField('noUrut', '', array('value' => '1', 'class' => 'span1 noUrut', 'readonly' => TRUE)) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']obatalkes_id', array('value' => $modObatAlkes->obatalkes_id, 'class' => 'obatAlkes')) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']sumberdana_id', array('value' => $modObatAlkes->sumberdana_id)) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']satuankecil_id', array('value' => $modObatAlkes->satuankecil_id)) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']satuanbesar_id', array('value' => $modObatAlkes->satuanbesar_id)) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']harganettorenc', array('value' => $modObatAlkes->harganetto)) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']minimalstok', array('value' => $modObatAlkes->minimalstok)) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']tglkadaluarsa', array('value' => $modObatAlkes->tglkadaluarsa)) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']jmlkemasan', array('value' => $modObatAlkes->kemasanbesar)) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']harganetto', array('value' => $modObatAlkes->harganetto)) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']hargajual', array('value' => $modObatAlkes->hargajual)) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']hargasatuan', array('value' => $modObatAlkes->harganetto)) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']r', array('value' => '')) .
        CHtml::activeHiddenField($modDetailUnitDosis, '[' . $idObat . ']rke', array('value' => '')) .
        "</td>
                            <td>" . $modObatAlkes->obatalkes_kode . "-" . $modObatAlkes->obatalkes_nama . "</td>
                            <td>" . $modObatAlkes->satuankecil->satuankecil_nama . "</td>
                            <td style='text-align:center'>" . CHtml::activeTextField($modDetailUnitDosis, '[' . $idObat . ']dosis1', array('value' => '1', 'class' => 'span1 numbersOnly', 'readonly' => true)) .
        " X " . CHtml::activeTextField($modDetailUnitDosis, '[' . $idObat . ']dosis2', array('value' => '1', 'class' => 'span1 numbersOnly', 'readonly' => true)) . "</td>
                            <td style='text-align:center'>" . CHtml::activeTextField($modDetailUnitDosis, '[' . $idObat . ']jmlhari', array('value' => $jmlHari, 'class' => 'span1 numbersOnly', 'readonly' => true)) . "</td>
                            <td style='text-align:center'>" . CHtml::activeTextField($modDetailUnitDosis, '[' . $idObat . ']jmlObat', array('value' => $qtyObat, 'class' => 'span1 numbersOnly', 'readonly' => true)) . "</td>
                            <td><div class='input-append'>" . CHtml::activeTextField($modDetailUnitDosis, '[' . $idObat . ']tglinsmulai', array('value' => date('d M Y'), 'class' => 'span1 tglmulai dtPicker2', 'style' => 'float:left;width:60px', 'readonly' => true)) . "<span class=add-on id=UnitdosisdetailT_" . $idObat . "_tglinsmulai><i class='icon-calendar'></i></span></div></td>
                            <td><div class='input-append'>" . CHtml::activeTextField($modDetailUnitDosis, '[' . $idObat . ']jaminsmulai', array('value' => '00:00:00', 'class' => 'span1 jammulai dtPicker3', 'style' => 'float:left;width:60px', 'readonly' => true)) . "<span class=add-on id=UnitdosisdetailT_" . $idObat . "_jaminsmulai><i class='icon-time'></i></span></div></td>
                            <td><div class='input-append'>" . CHtml::activeTextField($modDetailUnitDosis, '[' . $idObat . ']tglinsstop', array('value' => date('d M Y'), 'class' => 'span1 tglstop dtPicker2', 'style' => 'float:left;width:60px', 'readonly' => true)) . "<span class=add-on id=UnitdosisdetailT_" . $idObat . "_tglinsstop><i class='icon-calendar'></i></span></div></td>
                            <td><div class='input-append'>" . CHtml::activeTextField($modDetailUnitDosis, '[' . $idObat . ']jaminsstop', array('value' => '00:00:00', 'class' => 'span1 jamstop dtPicker3', 'style' => 'float:left;width:60px', 'readonly' => true)) . "<span class=add-on id=UnitdosisdetailT_" . $idObat . "_jaminsmulai><i class='icon-time'></i></span></div></td>                            
                            <td>" . CHtml::activeDropDownList($modDetailUnitDosis, '[' . $idObat . ']etiket', LookupM::getItems('etiket'), array()) . "</td>
                            <td>" . CHtml::link("<span class='icon-remove'>&nbsp;</span>", '', array('href' => '', 'onclick' => 'remove(this);return false;', 'style' => 'text-decoration:none;')) . "</td>
                         </tr>   
                        ";

      $data['tr'] = $tr;
      $data["idObat"] = $idObat;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /*
         * end Ajax for ObatAlkes rawatInap/UnitDosis
         */
}
