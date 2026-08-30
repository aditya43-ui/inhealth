<?php

class InformasiBarcodeAntrianController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
    public $defaultAction = 'index';
    public $path_view = 'pendaftaranPenjadwalan.views.informasiBarcodeAntrian.';
    public $path_tips = 'sistemAdministrator.views.tips.';           
    
        
    /**
     * halaman informasi
     */
    public function actionIndex(){
                
        $model = new AntrianT();        
        $model->tglantrian = date("Y-m-d");

        if (isset($_GET['AntrianT'])) {
            $model->attributes = $_GET['AntrianT'];  
            $model->tglantrian = !empty($model->tglantrian)?MyFormatter::formatDateTimeForDb($model->tglantrian):null;
        }

        // if (Yii::app()->request->isAjaxRequest){
        //     if (isset($_GET['ajax'])){
        //         $ajax = $_GET['ajax'];
        //         if ($ajax == 'daftar-penunjang-grid')
        //             $path = $this->path_view.'_tabel';                                
                
        //         $this->renderPartial($path,['model'=>$model]);
        //     }
        //     exit;
        // }
        
        $this->render($this->path_view . 'index', array(
            'model' => $model,
        ));
    
    }   
    
    public function actionCheckinBarcode(){
        if (!Yii::app()->request->isAjaxRequest){
            Yii::app()->end();
        }
        
        $antriId = isset($_POST['antriId'])?$_POST['antriId']:null;
        $nomorbarcode = isset($_POST['nomorbarcode'])?$_POST['nomorbarcode']:null;
        $status = isset($_POST['status'])?$_POST['status']:null;
        
        $sukses = 0;
        $loket_id = '';
        $antrian_id = '';
        
        $model = AntrianT::model()->findByPk($antriId);
        if (empty($model)){
            $model = AntrianT::model()->findByAttributes([
                'barcode'=>$nomorbarcode
            ]);
        }
        
        if (empty($model) && !empty($model->jam_panggil)){
            $sukses = 2;
        }else{
            if (empty($status) && !empty($model->jam_panggil) ){
                if ($model->barcode == $nomorbarcode){
                    $model->status_barcode = 'Sudah Barcode';
                    $model->update(['status_barcode']);

                    $sukses = 1;
                    $loket_id = $model->loket_id;
                    $antrian_id = $model->antrian_id;
                }else{
                    $sukses = 2;
                }
             } else if (!empty($model->jam_panggil)){
                $model->status_barcode = 'Sudah Barcode';
                $model->update(['status_barcode']);

                $sukses = 1;
                $loket_id = $model->loket_id;
                $antrian_id = $model->antrian_id;
            } else{
                "Tidak Valid" ;
            }
        }
            
        echo json_encode([
            'sukses'=> $sukses,
            'loket_id' => $loket_id,
            'antrian_id' => $antrian_id
        ]);
    }
    
    public function actionFormJenisKunjungan(){
        if (!Yii::app()->request->isAjaxRequest){
            Yii::app()->end();
        }                                
                
        if (!empty($_GET['id'])){
            $model = AntrianT::model()->findByPk($_GET['id']);
            $data = $this->renderPartial('form/_fastTrack',['model'=>$model] , true);
        }else if (!empty($_POST['id'])){            
            $data = [];
            
            parse_str($_POST['formdata'], $arr);
            $ok = true;
            $pesan = '';
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model = AntrianT::model()->findByPk($_POST['id']);
                $model->attributes = $arr['AntrianT'];
                
                $model->jenis_kunjungan = ParamsConst::JENIS_KUNJUNGAN_ANTRIAN_FASTTRACK;
                
                $ok &= $model->save();
                
                if ($ok){
                    $data['pesan'] = "Berhasil Disimpan!";
                    $trans->commit();
                }else{
                    $trans->rollback();
                    $data['pesan'] = "Data gagal disimpan!";
                }
            }catch(Exception $e){
                $trans->rollback();
                $data['pesan'] = "Data gagal disimpan!";
                $ok &= false;
            }
            
            $data['sukses'] = $ok;
        }
        echo json_encode($data);
    }
    
    public function actionCekNoRm(){
        if (!Yii::app()->request->isAjaxRequest){
            Yii::app()->end();
        }
        parse_str($_GET['formdata'], $arr);

        $get = $arr['AntrianT'];

        $norm = PasienM::model()->findByAttributes([
            'no_rekam_medik' => $get['no_rekam_medik']
        ]);

        $data['ada'] = true;
        $data['id'] = $get['antrian_id'];
        if (empty($norm)){
          $data['ada'] = false;
        }

        echo json_encode($data);
    }
    
    
}
