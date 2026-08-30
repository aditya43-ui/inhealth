<?php
class PemindahanPasienController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rawatJalan.views.pemindahanPasien.';
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id)
    {
      $pasienditerima = ((!empty($_GET['pasienditerima']) && ($_GET['pasienditerima'] == 'diterima'))? $_GET['pasienditerima'] : "");
      $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
      $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $ruangan_id = Yii::app()->user->getState("ruangan_id");
      $modRuangan = RuanganM::model()->findByPk($ruangan_id);
      $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      $model = PemindahanpasienT::model()->findByAttributes(array('ruangantujuan_id'=>$ruangan_id, 'pendaftaran_id'=>$modPendaftaran->pendaftaran_id),array('condition'=>'(ispasienditerima IS NULL OR ispasienditerima = false)','order'=>'tanggal_pemindahan DESC'));

      if(!empty($pasienditerima) && !empty($model) && !empty($model->pemindahanpasien_id)){
        $model->tanggal_pemindahan = (!empty($model->tanggal_pemindahan)? MyFormatter::formatDateTimeForUser($model->tanggal_pemindahan) : null);
        $model->observasiterakhir = (!empty($model->observasiterakhir)? MyFormatter::formatDateTimeForUser($model->observasiterakhir) : null);
        $model->ruanganasal_nama = $model->ruanganasal->ruangan_nama;
        $model->isriwayatalergi = (($model->isriwayatalergi==true)?1:0);
        $model->ispemberitahudiagnosa = (($model->ispemberitahudiagnosa==true)?1:0);
        $model->tanggal_prosedur = (!empty($model->tanggal_prosedur)? MyFormatter::formatDateTimeForUser($model->tanggal_prosedur) : null);
        $model->tglpemasangan_kateter = (!empty($model->tglpemasangan_kateter)? MyFormatter::formatDateTimeForUser($model->tglpemasangan_kateter) : null);
        $model->tglpemasangan_perawatan = (!empty($model->tglpemasangan_perawatan)? MyFormatter::formatDateTimeForUser($model->tglpemasangan_perawatan) : null);
        $model->ispasienditerima = true;
      }else{
          $model = new PemindahanpasienT();
          $model->ruanganasal_id = $ruangan_id;
          $model->ruanganasal_nama = (!empty($modRuangan)?$modRuangan->ruangan_nama : "");
          $model->tanggal_pemindahan = MyFormatter::formatDateTImeForUser(date('Y-m-d'));
          $model->observasiterakhir = MyFormatter::formatDateTImeForUser(date('Y-m-d'));

          if(isset($modAdmisi)){
            $model->pegawai_mengetahui = $modAdmisi->dokterpenerima_id;
          }else{
            $model->pegawai_mengetahui = $modPendaftaran->pegawai_id;
          }
      }
      $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
      $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;

      $tindakanUtama = "";
      $tindakanTambahan = "";

      $modMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'ruangan_id'=>$ruangan_id));

      if(count((array)$modMorbid) >0){
          $indexKel2=0;
          $indexKel3=0;
          foreach ($modMorbid as $datamorbid){
              if($datamorbid->kelompokdiagnosa_id == 2){
                  if($indexKel2 > 0){
                      $tindakanUtama .= ", ";
                  }
                  $tindakanUtama .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel2++;
              }

              if($datamorbid->kelompokdiagnosa_id == 3){
                  if($indexKel3 > 0){
                      $tindakanTambahan .= ", ";
                  }
                  $tindakanTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel3++;
              }
          }
      }
      $model->diagnosa = "Diagnosa Utama : ".$tindakanUtama." \n\n\n Diagnosa Tambahan : ".$tindakanTambahan;


      $anamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id,'create_ruangan'=>$ruangan_id));

      if(isset($anamnesa)){
        if(!empty($anamnesa->riwayatalergiobat)){
          $model->isriwayatalergi = 1;
        }else{
          $model->isriwayatalergi = 0;
        }

        if($ruangan_id == Params::RUANGAN_ID_PERAWATAN_DARURAT){
          $model->riwayatreaksi = $anamnesa->riwayatreaksi;
          $model->intervensimedik = $anamnesa->intervensimedik;
        }
      }

      if(isset($_POST['PemindahanpasienT'])){

          $transaction = Yii::app()->db->beginTransaction();
          try {
              $model->attributes = $_POST['PemindahanpasienT'];
              if(empty($pasienditerima)){
                $model->tanggal_pemindahan = (!empty($_POST['PemindahanpasienT']['tanggal_pemindahan'])? MyFormatter::formatDateTimeForDb($_POST['PemindahanpasienT']['tanggal_pemindahan']) : null);
                $model->tanggal_prosedur = (!empty($_POST['PemindahanpasienT']['tanggal_prosedur'])? MyFormatter::formatDateTimeForDb($_POST['PemindahanpasienT']['tanggal_prosedur']) : null);
                $model->tglpemasangan_kateter = (!empty($_POST['PemindahanpasienT']['tglpemasangan_kateter'])? MyFormatter::formatDateTimeForDb($_POST['PemindahanpasienT']['tglpemasangan_kateter']) : null);
                $model->tglpemasangan_perawatan = (!empty($_POST['PemindahanpasienT']['tglpemasangan_perawatan'])? MyFormatter::formatDateTimeForDb($_POST['PemindahanpasienT']['tglpemasangan_perawatan']) : null);
                $model->jam_pemindahan = (!empty($_POST['PemindahanpasienT']['jam_pemindahan'])? $_POST['PemindahanpasienT']['jam_pemindahan'] : null);
                $model->observasiterakhir = (!empty($_POST['PemindahanpasienT']['observasiterakhir'])? MyFormatter::formatDateTimeForDb($_POST['PemindahanpasienT']['observasiterakhir']) : null);
                $model->infuscvc = (!empty($_POST['PemindahanpasienT']['infuscvc'])? $_POST['PemindahanpasienT']['infuscvc'] : "-");
                $model->vasscore = (!empty($_POST['PemindahanpasienT']['vasscore'])? $_POST['PemindahanpasienT']['vasscore'] : "-");
                $arrAlat = array();
                
                if(!empty($_POST['PemindahanpasienT']['alat1_ket'])){
                  $arrAlat[] = $_POST['PemindahanpasienT']['alat1_ket'];
                }
                if(!empty($_POST['PemindahanpasienT']['alat2_ket'])){
                  $arrAlat[] = $_POST['PemindahanpasienT']['alat2_ket'];
                }
                if(!empty($_POST['PemindahanpasienT']['alat3_ket'])){
                  $arrAlat[] = $_POST['PemindahanpasienT']['alat3_ket'];
                }

                if(count((array)$arrAlat) > 0){
                  $model->peralatanyangdigunakan = implode('|',$arrAlat);
                }
              }
              $model->tanggal_penerimaan = (!empty($_POST['PemindahanpasienT']['tanggal_penerimaan'])? MyFormatter::formatDateTimeForDb($_POST['PemindahanpasienT']['tanggal_penerimaan']) : null);


              if(!empty($model->pemindahanpasien_id)){
                  $model->update_time = date('Y-m-d H:i:s');
                  $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
              }else{
                  $model->create_time = date('Y-m-d H:i:s');
                  $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
              }
              $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
              $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");

              if(!empty($_POST['Kelengkapandok'])){
                $arrKelengkapan = array();
                foreach ($_POST['Kelengkapandok'] as $kel) {
                  if($kel['iskelengkapan']==1){
                      $arrKelengkapan[] = array('nama'=>$kel['datakelengkapan_nama'],'keterangan'=>!empty($kel['keterangan']) ? $kel['keterangan'] : "-");
                  }
                }

                if(count((array)$arrKelengkapan) > 0){
                  $model->kelengkapan_dokumen = json_encode($arrKelengkapan);
                }
              }

              $tersimpanDiagnosa = true;
              
              if($model->save()){
                  $this->tersimpan = true;
                  if(!empty($_POST['DiagnosakeperawatanT'])){
                    foreach ($_POST['DiagnosakeperawatanT'] as $detailDiagnosa) {
                      $modDet = new DiagnosakeperawatanT();
                      $modDet->attributes = $detailDiagnosa;
                      $modDet->pemindahanpasien_id = $model->pemindahanpasien_id;
                      if(!$modDet->save()){
                        $tersimpanDiagnosa = false;
                      }
                    }
                  }
              }else{
                  $this->tersimpan = false;
              }

               if($this->tersimpan == true && $tersimpanDiagnosa == true){
                  $transaction->commit();
                  Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                  $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id,'pemindahanpasien_id'=>$model->pemindahanpasien_id,'pasienditerima'=>$pasienditerima,'sukses'=>1));
              }else{
                  Yii::app()->user->setFlash('error',"Data gagal disimpan!");
              }
          } catch (Exception $ex) {
              $transaction->rollback();
              Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
          }
      }

      $this->render($this->path_view.'index',array(
          'modPendaftaran'=>$modPendaftaran,
          'modPasien'=>$modPasien,
          'model'=>$model,
      ));
  }

  public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
  {
      if(Yii::app()->request->isAjaxRequest) {
          $instalasi_id = null;
          if($model_nama !=='' && $attr == ''){
              $instalasi_id = $_POST["$model_nama"]['instalasitujuan_id'];
          }
           else if ($model_nama == '' && $attr !== '') {
              $instalasi_id = $_POST["$attr"];
          }
           else if ($model_nama !== '' && $attr !== '') {
              $instalasi_id = $_POST["$model_nama"]["$attr"];
          }
          $models = null;
          $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

          if($encode){
              echo CJSON::encode($models);
          } else {
              echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
              if(count($models) > 0){
                  foreach($models as $value=>$name){
                      echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                  }
              }
          }
      }
      Yii::app()->end();
  }

  public function actionDetail($pemindahanpasien_id)
  {
      $this->layout='//layouts/iframe';
      $model = PemindahanpasienT::model()->findByPk($pemindahanpasien_id);

      $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($model->pendaftaran_id);
      $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

      $model->observasiterakhir = (!empty($model->observasiterakhir)?MyFormatter::formatDateTimeForUser($model->observasiterakhir):"");

      $this->render($this->path_view.'detail',array(
        'model'=>$model,
        'modPendaftaran'=>$modPendaftaran,
        'modPasien'=>$modPasien,
        'modAdmisi'=>$modAdmisi
      ));
  }


    public function actionPrint($id)
    {
      $model = PemindahanpasienT::model()->findByPk($id);

      $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($model->pendaftaran_id);
      $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

      $this->layout='//layouts/printWindows';
      $this->render($this->path_view.'Print',array(
        'model'=>$model,
        'modPendaftaran'=>$modPendaftaran,
        'modPasien'=>$modPasien,
        'modAdmisi'=>$modAdmisi
      ));
    }

    public function actionAutocompletePPA($term = "") {

        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modPPA=new PegawairuanganV('search');
        $modPPA->unsetAttributes();
        $modPPA->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPPA->nama_pegawai = $term;

        $prov = $modPPA->search();
        $prov->sort->defaultOrder = 'nama_pegawai';

        $res = array();
        foreach ($prov->data as $item)  {
            $sub = $item->attributes;
            $sub['nama_pegawai'] = $item->namaLengkap;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->namaLengkap;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    public function actionAutocompleteDPJP($term = "") {

        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modPPA=new PegawaiM('search');
        $modPPA->unsetAttributes();
        $modPPA->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK;
        // $modPPA->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPPA->nama_pegawai = $term;

        $prov = $modPPA->search();
        $prov->sort->defaultOrder = 'nama_pegawai';

        $res = array();
        foreach ($prov->data as $item)  {
            $sub = $item->attributes;
            $sub['nama_pegawai'] = $item->namaLengkap;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->namaLengkap;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }
}
