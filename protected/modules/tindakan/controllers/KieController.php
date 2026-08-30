
<?php

class KieController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatJalan.views.kie.';
    public $succesSave = true;

    public function actionIndex($pendaftaran_id, $kiepasien_id = null) {
        $model = new KiepasienT;
        $modKieDet = new KiepasiendetT;
        $modListKie = ListkieM::model()->findAll('listkie_aktif =  true');
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $model->pegawai_id = $modPendaftaran->pegawai_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->tgl_kie = date('Y-m-d H:i:s');
        $modKieDets = array();
        
        if(isset($_POST['KiepasienT'])){
            $model->attributes = $_POST['KiepasienT'];
            $model->tgl_kie = MyFormatter::formatDateTimeForDb($model->tgl_kie);
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai =  Yii::app()->user->id;
            if($model->validate()){
                $this->succesSave = $model->save();

                if(isset($_POST['KiepasiendetT'])){
                    $details = $_POST['KiepasiendetT'];
                    foreach ($details as $key => $value) {
                        if(!empty($value['listkie_id'])){
                            $modDetail = new KiepasiendetT();
                            $modDetail->attributes = $value;
                            $modDetail->kiepasien_id = $model->kiepasien_id;
                            $modDetail->listkie_id = $value['listkie_id'];
                            $modDetail->jeniskie = $value['jeniskie'];


                            $modDetail->create_time = date('Y-m-d H:i:s');
                            $modDetail->create_loginpemakai =  Yii::app()->user->id;
                            $this->succesSave =  $modDetail->save();
                        }
                        
                    }
                }

            }

            if ($this->succesSave) {
                Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                // 'kiepasien_id'=>$model->kiepasien_id
                $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'kiepasien_id'=>$model->kiepasien_id));
            }
        }
        if($kiepasien_id){
            // var_dump('asdfsd');die;
            $model = KiepasienT::model()->findByPk($kiepasien_id);
            $modKieDets = KiepasiendetT::model()->findAllByAttributes(array('kiepasien_id' => $kiepasien_id));
        }

        $crit = new CDbCriteria();
        // $crit->join = 'JOIN kiepasiendet_t ON t.kiepasien_id = kiepasiendet_t.kiepasien_id';
        $crit->addCondition('pendaftaran_id = '. $pendaftaran_id);
        $modRiwayatKie = KiepasienT::model()->findAll($crit);
        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modKieDet' => $modKieDet,
            'modRiwayatKie' => $modRiwayatKie,
            'modListKie' => $modListKie,
            'modPendaftaran' => $modPendaftaran,
            'modKieDets' => $modKieDets
        ));
    }

    public function actionAjaxDetail()
    {
        if(Yii::app()->request->isAjaxRequest) {
        $kiepasien_id = $_POST['kiepasien_id'];
        $model = KiepasienT::model()->findByPk($kiepasien_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modFarmasi = PenjualanresepT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
        $modListKie = ListkieM::model()->findAll('listkie_aktif =  true');
        $modDetails = KiepasiendetT::model()->findAllByAttributes(array('kiepasien_id' => $kiepasien_id));
        $data['result'] = $this->renderPartial('_viewDetail', array('modListKie'=>$modListKie,'model'=>$model,'modDetails'=>$modDetails,
        // 'modFarmasi' => $modFarmasi,
        'modPendaftaran'=>$modPendaftaran), true);

        echo json_encode($data);
         Yii::app()->end();
        }
    }

    public function actionUpdate($pendaftaran_id, $kiepasien_id){
        $model = KiepasienT::model()->findByPk($kiepasien_id);
        $modKieDet = KiepasiendetT::model()->findAllByAttributes(array('kiepasien_id' => $kiepasien_id));
        $modListKie = ListkieM::model()->findAll('listkie_aktif =  true');
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $crit = new CDbCriteria();
        $crit->join = 'JOIN kiepasiendet_t ON t.kiepasien_id = kiepasiendet_t.kiepasien_id';
        $crit->addCondition('t.pendaftaran_id = '. $pendaftaran_id);
        $modRiwayatKie = KiepasienT::model()->findAll($crit);
        $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'kiepasien_id'=>$model->kiepasien_id));
        // $this->render($this->path_view . 'index', array(
        //     'model' => $model,
        //     'modKieDet' => $modKieDet,
        //     'modRiwayatKie' => $modRiwayatKie,
        //     'modListKie' => $modListKie,
        //     'modPendaftaran' => $modPendaftaran
        // ));
    }
    public function actionPrint($pendaftaran_id, $kiepasien_id)
    {
       $model = KiepasienT::model()->findByPk($kiepasien_id);
       $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
       $modDetails = KiepasiendetT::model()->findAllByAttributes(array('kiepasien_id' => $kiepasien_id));
       $modListKie = ListkieM::model()->findAll('listkie_aktif =  true');
        // var_dump($kiepasien_id);die;
        $judulLaporan='KIE';
        // $caraPrint=$_REQUEST['caraPrint'];
        // if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'print',array('model'=>$model,'modListKie' => $modListKie,'modPendaftaran'=>$modPendaftaran,'modDetails'=>$modDetails,'judulLaporan'=>$judulLaporan));
        // }
        // else if($caraPrint=='EXCEL') {
        //     $this->layout='//layouts/printExcel';
        //     $this->render($this->path_view.'printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        // }
        // else if($_REQUEST['caraPrint']=='PDF') {
        //     $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        //     $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        //     $mpdf = new MyPDF('',$ukuranKertasPDF); 
        //     $mpdf->useOddEven = 2;  
        //     $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        //     $mpdf->WriteHTML($stylesheet,1);  
        //     $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
        //     $mpdf->WriteHTML($this->renderPartial($this->path_view.'printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
        //     $mpdf->Output();
        // }                       
    }


            
    public function actionAjaxBatal()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $kiepasien_id = $_POST['kiepasien_id'];
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
        
            $kie = KiepasienT::model()->findByAttributes(array('kiepasien_id'=>$kiepasien_id));
            if(!empty($kie)){
                KiepasiendetT::model()->deleteAllByAttributes(array('kiepasien_id' => $kiepasien_id));
                $kie->delete();
                // LembarobservasipasienT::model()->deleteAllByAttributes(array('lembarobservasipasien_id'=>$tindakanpelayanan->lembarobservasipasien_id));
                // LembarobservasipasienT::model()->deleteByPk(array('lembarobservasipasien_id' => $tindakanpelayanan->lembarobservasipasien_id));
            }

            // LembarobservasipasienT::model()->deleteByPk($lembarobservasipasien_id);
            // $modRiwayatSpk = LembarobservasipasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            
            // $data['result'] = $this->renderPartial($this->path_view.'_list', array('modRiwayatSpk'=>$modRiwayatSpk), true);
            $data['success'] = true;
            echo json_encode($data);
            Yii::app()->end();
        }
        
    }
   
}