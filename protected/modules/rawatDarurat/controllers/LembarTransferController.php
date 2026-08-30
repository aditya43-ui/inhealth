<?php
class LembarTransferController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatDarurat.views.lembarTransfer.';
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id, $formtransferpasien_id = null)
    {
        $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $ruangan_id = Yii::app()->user->getState("ruangan_id");

        $pegawaiId = $modPendaftaran->pegawai_id;

        if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS){
            $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
            $pegawaiId = $modPendaftaran->pegawai_id;
        }else if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD){
            if(Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_VK){
                $modPendaftaran = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
                $pegawaiId = $modPendaftaran->pegawai_id;
            }
        }

        if(!empty($formtransferpasien_id)){
           $model = RDFormtransferpasienT::model()->findByPk($formtransferpasien_id);
           $pegawaiId = $model->dokterpengirim_id;
           $model->tanggal_transfer = MyFormatter::formatDateTimeForUser($model->tanggal_transfer);
        }else{
            $model = new RDFormtransferpasienT();
            $model->tanggal_transfer = date('d M Y');
            $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        }

        $modAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);

        if(isset($modAdmisi)){
            if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI){
                $pegawaiId = $modAdmisi->pegawai_id;
            }
        }

        $modRuangan = RuanganM::model()->findByPk($ruangan_id);

        if(isset($modRuangan)){
            $ruangan = $modRuangan->ruangan_nama;
            $instalasi = $modRuangan->instalasi->instalasi_nama;
        }

        $model->dokterpengirim_id = $pegawaiId;

        $model->ruanganasal_nama = $instalasi ." / ". $ruangan;
        $model->ruanganasal_id = $ruangan_id;

        $tindakanUtama = "";
        $tindakanTambahan = "";

        $modMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'ruangan_id'=>$ruangan_id));

        if(count($modMorbid) >0){
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
        $model->diagnosamasukrs = "Diagnosa Utama: ".$tindakanUtama." \n\n\n Diagnosa Penyerta: ".$tindakanTambahan;
        $modAnamnesis = AnamnesaT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'create_ruangan'=>$ruangan_id));
        $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'create_ruangan'=>$ruangan_id));
        $modAsesmenAwalKep = AsesmenawalkeperawatanT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'create_ruangan_id'=>$ruangan_id));

        if(empty($formtransferpasien_id)){
          if(isset($modAnamnesis)){
              $model->jamringkas_riwayatpasien = date('H:i:s', strtotime($modAnamnesis->tglanamnesis));
              $model->dokter_keluhanutama = $modAnamnesis->keluhanutama;
              $model->riwayatpenyakitterdahulu = $modAnamnesis->riwayatpenyakitterdahulu;
          }

          if(isset($modPemeriksaanFisik)){
              $model->dokter_keadaanumum = $modPemeriksaanFisik->keadaanumum;
              $model->ttvdokter_td_systolic = $modPemeriksaanFisik->td_systolic;
              $model->ttvdokter_td_diastolic = $modPemeriksaanFisik->td_diastolic;
              $model->ttvdokter_suhutubuh = $modPemeriksaanFisik->suhutubuh;
              $model->ttvdokter_nadi = $modPemeriksaanFisik->detaknadi;
          }

          if(isset($modAsesmenAwalKep)){
              $model->riwayatalergi = "Riwayat Alergi Obat : ".$modAsesmenAwalKep->riwayatalergiobat." \n\n\n Riwayat Alergi Makanan: ".$modAsesmenAwalKep->riwayatalergimakanan." \n\n\n Riwayat Alergi Lainnya: ".$modAsesmenAwalKep->riwayatalergilainnya;
          }
        }

        $modTindakans = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'ruangan_id'=>$ruangan_id));

        $modRiwayatResepBHP = ObatalkespasienT::model()->findAllByAttributes(array('oa'=>'BM','pendaftaran_id'=>$model->pendaftaran_id,'ruangan_id'=>$ruangan_id));

        $modRiwayatResep = ResepturT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'ruanganreseptur_id'=>$ruangan_id),array('order'=>'create_time DESC'));

        if(isset($_POST['RDFormtransferpasienT'])){
            $transaction = Yii::app()->db->beginTransaction();

            try {
                $model->attributes = $_POST['RDFormtransferpasienT'];
                $model->tanggal_transfer = (!empty($_POST['RDFormtransferpasienT']['tanggal_transfer'])? MyFormatter::formatDateTimeForDb($_POST['RDFormtransferpasienT']['tanggal_transfer']) : null);

                if(!empty($model->formtransferpasien_id)){
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }else{
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                    $model->ispasienditerima = false;
                }
                $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");


                if($model->save()){
                    $this->tersimpan = true;
                }else{
                    $this->tersimpan = false;
                }

                 if($this->tersimpan == true){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                    $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id,'sukses'=>1,'type'=>$_GET['type'],'frame'=>$_GET['frame']));
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
            'modTindakans'=>$modTindakans,
            'modRiwayatResep'=>$modRiwayatResep,
            'modRiwayatResepBHP'=>$modRiwayatResepBHP,


        ));
    }

    public function actionAjaxDetailResep()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $idReseptur = $_POST['idReseptur'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
            $modReseptur = ResepturT::model()->findByPk($idReseptur);
            $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$idReseptur));

            $data['result'] = $this->renderPartial($this->path_view.'_viewDetailResep', array('modDetailResep'=>$modDetailResep,'modPendaftaran'=>$modPendaftaran, 'modReseptur'=>$modReseptur), true);

            echo json_encode($data);
             Yii::app()->end();
        }
    }

    public function actionPrintReseptur($idReseptur = null)
    {
        $pendaftaran_id = $_GET['id'];
        $criteria=new CDbCriteria;
        if (empty($idReseptur)) {
            $criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
        } else {
            $criteria->compare('reseptur_id', $idReseptur);
        }
        $maxtime = ResepturT::model()->find($criteria);
        $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$maxtime->reseptur_id));
        $modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $judulLaporan='Reseptur';
        $caraPrint=$_REQUEST['caraPrint'];
        If(isset($_GET['idReseptur'])){
            $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$_GET['idReseptur']));
            if($caraPrint=='PRINT') {
                    $this->layout='//layouts/printWindows';
                    $this->render($this->path_view.'_viewDetailResep',array('modPendaftaran'=>$modPendaftaran,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'modDetailResep'=>$modDetailResep, 'modReseptur'=>$maxtime));
            }
        }else{
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'_viewDetailResep',array('modPendaftaran'=>$modPendaftaran,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,"modDetailResep"=>$modDetailResep, 'modReseptur'=>$maxtime));
            }
        }
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


    public function actionDetail($pendaftaran_id, $formtransferpasien_id)
    {
       $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RDFormtransferpasienT::model()->findByPk($formtransferpasien_id);
        $ruangan_id = Yii::app()->user->getState("ruangan_id");


        if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS){
            $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
        }else if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD){
            if(Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_VK){
                $modPendaftaran = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
            }
        }

        $tindakanUtama = "";
        $tindakanTambahan = "";

        $modMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'ruangan_id'=>$ruangan_id));

        if(count($modMorbid) >0){
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
        $model->diagnosamasukrs = "<p>Diagnosa Utama: ".$tindakanUtama."</p>  <p>Diagnosa Penyerta: ".$tindakanTambahan."</p>";
        $modAnamnesis = AnamnesaT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'create_ruangan'=>$ruangan_id));
        $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'create_ruangan'=>$ruangan_id));

        if(isset($modAnamnesis)){
            $model->jamringkas_riwayatpasien = date('H:i:s', strtotime($modAnamnesis->tglanamnesis));
            $model->dokter_keluhanutama = $modAnamnesis->keluhanutama;
            //$model->riwayatpenyakitterdahulu = $modAnamnesis->riwayatpenyakitterdahulu;
        }

        if(isset($modPemeriksaanFisik)){
            $model->dokter_keadaanumum = $modPemeriksaanFisik->keadaanumum;
            $model->ttvdokter_td_systolic = $modPemeriksaanFisik->td_systolic;
            $model->ttvdokter_td_diastolic = $modPemeriksaanFisik->td_diastolic;
            $model->ttvdokter_suhutubuh = $modPemeriksaanFisik->suhutubuh;
            $model->ttvdokter_nadi = $modPemeriksaanFisik->detaknadi;
        }

        $modAsesmenAwalKep = AsesmenawalkeperawatanT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'create_ruangan_id'=>$ruangan_id));
        $riwayatalergiobat = "Tidak ada";
        $riwayatalergimakanan = "Tidak ada";
        $riwayatalergilainnya = "Tidak ada";
        if(isset($modAsesmenAwalKep)){
            $riwayatalergiobat = (!empty($modAsesmenAwalKep->riwayatalergiobat)?$modAsesmenAwalKep->riwayatalergiobat:"Tidak ada");
            $riwayatalergimakanan = (!empty($modAsesmenAwalKep->riwayatalergimakanan)?$modAsesmenAwalKep->riwayatalergimakanan:"Tidak ada");
            $riwayatalergilainnya = (!empty($modAsesmenAwalKep->riwayatalergilainnya)?$modAsesmenAwalKep->riwayatalergilainnya:"Tidak ada");
        }
        //$model->riwayatalergi = "<p>Riwayat Alergi Obat : ".$riwayatalergiobat."</p> <p>Riwayat Alergi Makanan: ".$riwayatalergimakanan."</p> <p>Riwayat Alergi Lainnya: ".$riwayatalergilainnya."</p>";

        $modTindakans = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'ruangan_id'=>$ruangan_id));

        $modRiwayatResepBHP = ObatalkespasienT::model()->findAllByAttributes(array('oa'=>'BM','pendaftaran_id'=>$model->pendaftaran_id,'ruangan_id'=>$ruangan_id));

        $modRiwayatResep = ResepturT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'ruanganreseptur_id'=>$ruangan_id),array('order'=>'create_time DESC'));

        $this->layout='//layouts/iframe';
        $this->render($this->path_view.'detailLembarPasien',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modTindakans'=>$modTindakans,'modRiwayatResepBHP'=>$modRiwayatResepBHP, 'modRiwayatResep'=>$modRiwayatResep));
    }

//
//
//
//
//    public function actionHapusEws(){
//        if(Yii::app()->request->isPostRequest)
//        {
//            $id = $_POST['id'];
//            $pendaftaranId = $_POST['pendaftaran_id'];
//
//
//            $deleteDetail = EwspasiendetT::model()->deleteAllByAttributes(array('ewspasien_id'=>$id));
//            $deleteData = EwspasienT::model()->deleteByPk($id);
//
//            $message = "";
//            $sukses = 0;
//
//            if($deleteDetail && $deleteData){
//                $message = "Data Berhasil Dihapus!";
//                $sukses = 1;
//            }else{
//                $message = "Data gagal Dihapus!";
//                $sukses = 0;
//            }
//
//            echo CJSON::encode(array(
//                    'sukses'=> $sukses,
//                    'msg'=>$message,
//                    ));
//            exit;
//            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//            if(!isset($_GET['ajax']))
//                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//        }
//        else
//            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
//    }
//
//    public function actionPrint($ewspasien_id, $pendaftaran_id)
//    {
//        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
//        $model = EwspasienT::model()->findByPk($ewspasien_id);
//        $modDetail = EwspasiendetT::model()->findAllByAttributes(array('ewspasien_id'=>$ewspasien_id));
//
//
//        $this->layout='//layouts/printWindows';
//        $this->render($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modDetail'=>$modDetail,'modPasien'=>$modPasien));
//    }
//
//
}
