<?php
class ChecklistPraOperasiController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'bedahSentral.views.checklistPraOperasi.';
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id, $prepostoperasi_id = null)
    {
      if(!empty($_GET['frame']) && $_GET['frame']==1){
        $this->layout='//layouts/iframe';
      }
      $isterima_type = (isset($_GET['isterima'])?$_GET['isterima']:false);
      $aksitype = (isset($_GET['aksitype'])?$_GET['aksitype']:null);
      $ruangan_id = Yii::app()->user->getState("ruangan_id");


      $modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      $modDetail = array();
      $tglinputan = null;
      $petugaspegawai_id = null;

      if(!empty($prepostoperasi_id) && ($isterima_type == true)){
        $model = PrepostoperasiT::model()->findByPk($prepostoperasi_id);
        $model->tanggal_penginputan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $ruanganBedah = RuanganM::model()->findByPk($model->ruangantujuan_id);
        $uanganAsal = RuanganM::model()->findByPk($model->ruanganasal_id);
        $tglinputan = $model->tanggal_penginputan;
        $petugaspegawai_id = $model->petugas_pengisi;
        $model->isterima = true;
        // $ruanganBedah = RuanganM::model()->findByPk(Params::RUANGAN_ID_BEDAH);
        // $uanganAsal = RuanganM::model()->findByPk($ruangan_id);
        //
      }else if(!empty($prepostoperasi_id) && !empty($aksitype)){
        $model = PrepostoperasiT::model()->findByPk($prepostoperasi_id);
        $tglinputan = $model->tanggal_penginputan;
        $petugaspegawai_id = $model->petugas_pengisi;
        $checklist_diisioleh = null;
        if($aksitype == 'ubahasal'){
          $checklist_diisioleh = "petugasruangan_asal";
          $model->tanggal_penginputan = MyFormatter::formatDateTimeForUser($model->tanggal_penginputan);
          $model->petugas_pengisi_nama = $model->petugasPengisi->namaLengkap;
        }else if($aksitype == 'ubahtujuan'){
          $checklist_diisioleh = "petugasruangan_tujuan";
          $model->tanggal_penginputan = (!empty($model->tglpengisian_ruangantujuan)? MyFormatter::formatDateTimeForUser($model->tglpengisian_ruangantujuan) : null);
          $peg = PegawaiM::model()->findByPk($model->petugaspengisi_ruangantujuan);
          $model->petugas_pengisi_nama = (!empty($peg)? $peg->namaLengkap: null);
        }
        $ruanganBedah = RuanganM::model()->findByPk($model->ruangantujuan_id);
        $uanganAsal = RuanganM::model()->findByPk($model->ruanganasal_id);
        
        $modDetail = PrepostoperasidetailT::model()->findAllByAttributes(array('prepostoperasi_id'=>$model->prepostoperasi_id,'checklist_diisioleh'=>$checklist_diisioleh));
      }else{
        $model = new PrepostoperasiT();
        $ruanganBedah = RuanganM::model()->findByPk(Params::RUANGAN_ID_BEDAH);
        $uanganAsal = RuanganM::model()->findByPk($ruangan_id);
        $model->tanggal_penginputan = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
      }
      
      $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
      $model->ruanganasal_id = $uanganAsal->ruangan_id;
      $model->ruanganasal_nama = $uanganAsal->ruangan_nama;
      //
      // if(Yii::app()->user->getState("instalasi_id") != Params::INSTALASI_ID_IBS){
        $model->instalasitujuan_id = $ruanganBedah->instalasi_id;
        $model->instalasitujuan_nama = $ruanganBedah->instalasi->instalasi_nama;
        $model->ruangantujuan_id = $ruanganBedah->ruangan_id;
        $model->ruangantujuan_nama = $ruanganBedah->ruangan_nama;
      // }

      $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
      $diagnosaUtama = "";
      $diagnosaTambahan = "";
      $diagnosa_id = null;

      if (count($pasienMorbid) > 0) {
          $indexKel2 = 0;
          $indexKel3 = 0;

          foreach ($pasienMorbid as $datamorbid) {
              $diagnosa_id = $datamorbid->diagnosa_id;
              if ($datamorbid->kelompokdiagnosa_id == 2) {
                  if ($indexKel2 > 0) {
                      $diagnosaUtama .= ", ";
                  }
                  $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel2++;
              }

              if ($datamorbid->kelompokdiagnosa_id == 3) {
                  if ($indexKel3 > 0) {
                      $diagnosaTambahan .= ", ";
                  }
                  $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel3++;
              }
          }
      }
      $model->diagnosa = "Diagnosa Utama: " . $diagnosaUtama . " \n\n Diagnosa Tambahan: " . $diagnosaTambahan;

      if(isset($_POST['PrepostoperasiT'])){

          $transaction = Yii::app()->db->beginTransaction();

          try {
              $model->attributes = $_POST['PrepostoperasiT'];
              $model->jenischecklist = "Pra Operasi";
              $model->isterima = (($_POST['PrepostoperasiT']['isterima']==null)?0:$_POST['PrepostoperasiT']['isterima']);
              $model->tanggal_penginputan = (!empty($_POST['PrepostoperasiT']['tanggal_penginputan'])? MyFormatter::formatDateTimeForDb($_POST['PrepostoperasiT']['tanggal_penginputan']) : null);

              if(!empty($aksitype)){
                if($aksitype == 'ubahtujuan'){
                  $model->tglpengisian_ruangantujuan = $model->tanggal_penginputan;
                  $model->petugaspengisi_ruangantujuan =$_POST['PrepostoperasiT']['petugas_pengisi'];
                  $model->tanggal_penginputan = (!empty($tglinputan)? MyFormatter::formatDateTimeForDb($tglinputan) : null);
                  $model->petugas_pengisi = $petugaspegawai_id;
                }
              }

              if(!empty($model->prepostoperasi_id)){
                  $model->update_time = date('Y-m-d H:i:s');
                  $model->update_loginpemakai = Yii::app()->user->getState("loginpemakai_id");
              }else{
                  $model->create_time = date('Y-m-d H:i:s');
                  $model->create_loginpemakai = Yii::app()->user->getState("loginpemakai_id");

                  if($isterima_type == true){
                    $model->isterima = true;
                  }else{
                    $model->isterima = 0;
                  }

                  if($model->isterima == true){
                    $model->tglpengisian_ruangantujuan = $model->tanggal_penginputan;
                    $model->petugaspengisi_ruangantujuan =$_POST['PrepostoperasiT']['petugas_pengisi'];
                    $model->tanggal_penginputan = (!empty($tglinputan)? MyFormatter::formatDateTimeForDb($tglinputan) : null);
                    $model->petugas_pengisi = $petugaspegawai_id;
                  }else{
                    $model->tglpengisian_ruangantujuan = null;
                    $model->petugaspengisi_ruangantujuan = null;
                  }
              }
              $model->create_ruangan = Yii::app()->user->getState("ruangan_id");


              if($model->save()){
                  $detailTersimpan = true;

                  if(!empty($aksitype)){
                    $detailTersimpan = $this->simpanDataDetail($_POST['PrepostoperasidetailT'], $model, $aksitype);
                  }else{
                    if(!empty($_POST['PrepostoperasidetailT'])){
                      foreach($_POST['PrepostoperasidetailT'] as $detailI){
                        if(isset($detailI['status_pengisian']) && !empty($detailI['status_pengisian'])){
                          $modDetails = new PrepostoperasidetailT();
                          $modDetails->attributes = $detailI;
                          $modDetails->jenischecklist = $model->jenischecklist;
                          $modDetails->prepostoperasi_id = $model->prepostoperasi_id;
                          $modDetails->ischeck = true;
                          $modDetails->create_time = date('Y-m-d H:i:s');
                          $modDetails->create_loginpemakai = Yii::app()->user->getState("loginpemakai_id");
                          $modDetails->create_ruangan = Yii::app()->user->getState("ruangan_id");
                          if($model->ruanganasal_id == Yii::app()->user->getState("ruangan_id")){
                              $modDetails->checklist_diisioleh = "petugasruangan_asal";
                          }else if($model->ruangantujuan_id == Yii::app()->user->getState("ruangan_id")){
                              $modDetails->checklist_diisioleh = "petugasruangan_tujuan";
                          }

                          if(!$modDetails->save()){
                            $detailTersimpan = false;
                          }
                        }
                      }
                    }
                  }

                  if($detailTersimpan==true){
                      $this->tersimpan = true;
                  }
              }else{
                  $this->tersimpan = false;
              }

               if($this->tersimpan == true){
                  $transaction->commit();
                  Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                  $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id,'sukses'=>1, 'type'=>$_GET['type'], 'frame'=>$_GET['frame']));
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
          'modAdmisi'=>$modAdmisi,
          'modDetail'=>$modDetail
      ));
  }

  public function simpanDataDetail($post, $modelParent, $aksitype){
    $valid = true;
    $checklist_diisioleh = null;
    if($aksitype == 'ubahasal'){
      $checklist_diisioleh = "petugasruangan_asal";
    }else if($aksitype == 'ubahtujuan'){
      $checklist_diisioleh = "petugasruangan_tujuan";
    }
    $modDetail = PrepostoperasidetailT::model()->findAllByAttributes(array('prepostoperasi_id'=>$modelParent->prepostoperasi_id,'checklist_diisioleh'=>$checklist_diisioleh));

    $oriSize = count($modDetail);
    $modSize = count($_POST['PrepostoperasidetailT']);
    $index = 0;

    if($modSize > 0){
        foreach($_POST['PrepostoperasidetailT'] as $detailI){
          if(!empty($detailI['status_pengisian'])){
            $index = 0;

            if($oriSize > 0){
              foreach($modDetail as $detailJ){
                if($detailI['prepostoperasidesk_id'] == $detailJ->prepostoperasidesk_id){
                  $index = 1;
                  $modUpdate = PrepostoperasidetailT::model()->findByPk($detailJ->prepostoperasidetail_id);
                  $modUpdate->attributes = $detailI;
                  $modUpdate->update_time = date('Y-m-d H:i:s');
                  $modUpdate->update_loginpemakai = Yii::app()->user->getState("loginpemakai_id");
                  if($modUpdate->ruanganasal_id == Yii::app()->user->getState("ruangan_id")){
                      $modUpdate->checklist_diisioleh = Yii::app()->user->getState("nama_pegawai");
                  }

                  if(!$modUpdate->save()){
                    $valid = false;
                  }
                  break;
                }
              }
            }

            if($index == 0){
              $modCreate = new PrepostoperasidetailT();
              $modCreate->attributes = $detailI;
              $modCreate->jenischecklist = $modelParent->jenischecklist;
              $modCreate->prepostoperasi_id = $modelParent->prepostoperasi_id;
              $modCreate->ischeck = true;
              $modCreate->create_time = date('Y-m-d H:i:s');
              $modCreate->create_loginpemakai = Yii::app()->user->getState("loginpemakai_id");
              $modCreate->create_ruangan = Yii::app()->user->getState("ruangan_id");

              if($aksitype == 'ubahasal'){
                $modCreate->checklist_diisioleh = "petugasruangan_asal";
              }else if($aksitype == 'ubahtujuan'){
                $modCreate->checklist_diisioleh = "petugasruangan_tujuan";

              }

              if(!$modCreate->save()){
                $valid = false;
              }
            }
          }
        }
    }

    if($oriSize > 0){
      foreach($modDetail as $detailI){
        $index = 0;

        if($modSize > 0){
          foreach($_POST['PrepostoperasidetailT'] as $detailJ){
            if(!empty($detailJ['status_pengisian'])){
              if($detailI->prepostoperasidesk_id == $detailJ['prepostoperasidesk_id']){
                $index = 1;
                $modUpdate = PrepostoperasidetailT::model()->findByPk($detailI->prepostoperasidetail_id);
                $modUpdate->attributes = $detailJ;
                $modUpdate->update_time = date('Y-m-d H:i:s');
                $modUpdate->update_loginpemakai = Yii::app()->user->getState("loginpemakai_id");
                if($modUpdate->ruanganasal_id == Yii::app()->user->getState("ruangan_id")){
                    $modUpdate->checklist_diisioleh = Yii::app()->user->getState("nama_pegawai");
                }

                if(!$modUpdate->save()){
                  $valid = false;
                }
                break;
              }
            }
          }
        }

        if($index == 0){
          $modDelete = PrepostoperasidetailT::model()->deleteByPk($detailI->prepostoperasidetail_id);

          if(!$modDelete->save()){
            $valid = false;
          }
        }
      }
    }
    return $valid;
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

  public function actionDetail($prepostoperasi_id, $typeruangan)
  {
      $this->layout='//layouts/iframe';

      $model = PrepostoperasiT::model()->findByPk($prepostoperasi_id);
      $modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($model->pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      $checklist_diisioleh = null;

      if(!empty($typeruangan)){
        if($typeruangan == 'asal'){
          $checklist_diisioleh = "petugasruangan_asal";
          $model->tanggal_penginputan = MyFormatter::formatDateTimeForUser($model->tanggal_penginputan);
          $model->petugas_pengisi_nama = $model->petugasPengisi->namaLengkap;
        }else if($typeruangan == 'tujuan'){
          $checklist_diisioleh = "petugasruangan_tujuan";
          $model->tanggal_penginputan = (!empty($model->tglpengisian_ruangantujuan)? MyFormatter::formatDateTimeForUser($model->tglpengisian_ruangantujuan) : null);
          $peg = PegawaiM::model()->findByPk($model->petugaspengisi_ruangantujuan);
          $model->petugas_pengisi_nama = (!empty($peg)? $peg->namaLengkap: null);
        }
      }

      $modDetail = PrepostoperasidetailT::model()->findAllByAttributes(array('prepostoperasi_id'=>$model->prepostoperasi_id,'checklist_diisioleh'=>$checklist_diisioleh));



      $model->ruanganasal_nama = $model->ruanganasal->ruangan_nama;
      $model->instalasitujuan_nama = $model->instalasitujuan->instalasi_nama;
      $model->ruangantujuan_nama = $model->ruangantujuan->ruangan_nama;

      $this->render($this->path_view.'detailRiwayat',array(
        'model'=>$model,
        'modDetail'=>$modDetail
      ));
  }

  public function actionHapusRiwayat(){
      if(Yii::app()->request->isPostRequest)
      {
          $id = $_POST['id'];
          $findData = PrepostoperasiT::model()->findByPk($id);
          $message = "";
          $sukses = 0;

          if($findData->isterima == true){
            $suksesData = PrepostoperasiT::model()->updateByPk($id,array('isterima'=>0));
          }else{
            PrepostoperasidetailT::model()->deleteAllByAttributes(array('prepostoperasi_id'=>$findData->prepostoperasi_id));
            $suksesData = PrepostoperasiT::model()->deleteByPk($id);
          }

          if($suksesData){
              $message = "Data Berhasil Dihapus!";
              $sukses = 1;
          }else{
              $message = "Data gagal Dihapus!";
              $sukses = 0;
          }

          echo CJSON::encode(array(
                  'sukses'=> $sukses,
                  'msg'=>$message,
                  ));
          exit;
          // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
          if(!isset($_GET['ajax']))
                          $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      }
      else
          throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
  }

  public function actionPrint($prepostoperasi_id) {

      $this->layout = '//layouts/printWindows_baru';
      $ruangan_id = Yii::app()->user->getState("ruangan_id");
      $model = PrepostoperasiT::model()->findByPk($prepostoperasi_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
      $modDetail = PrepostoperasidetailT::model()->findAllByAttributes(array('prepostoperasi_id'=>$model->prepostoperasi_id));
      $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));
      $diagnosaUtama = "";
      $diagnosaTambahan = "";
      $diagnosa_id = null;

      if (count($pasienMorbid) > 0) {
          $indexKel2 = 0;
          $indexKel3 = 0;

          foreach ($pasienMorbid as $datamorbid) {
              $diagnosa_id = $datamorbid->diagnosa_id;
              if ($datamorbid->kelompokdiagnosa_id == 2) {
                  if ($indexKel2 > 0) {
                      $diagnosaUtama .= ", ";
                  }
                  $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel2++;
              }

              if ($datamorbid->kelompokdiagnosa_id == 3) {
                  if ($indexKel3 > 0) {
                      $diagnosaTambahan .= ", ";
                  }
                  $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel3++;
              }
          }
      }
      $model->diagnosa_utama = $diagnosaUtama;
      $model->diagnosa_tambahan = $diagnosaTambahan;


      $this->render($this->path_view."Print", array(
          'model'=>$model,
          'modPendaftaran'=>$modPendaftaran,
          'modPasien'=>$modPasien,
          'modDetail'=>$modDetail,
      ));
  }
}
