<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - controller utama transaksi  work order
* RSST-1692
*/


class PenghapusanAsetController extends MyAuthController
{	
    //public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'manajemenAset.views.penghapusanAset.';    
    public $init = '';        

    public function actionIndex($penghapusanaset_id=null)
    {       
        $model = new MAPenghapusanasetT;
        $model->tglpenghapusan = date('d M Y');
        //$model->nopenghapusan = '-Otomatis-';
        
        $modDet = new MAPenghapusanasetdetT;
        $viewPengeluaran = new MAInfopengeluaranasetV;
        $viewPengeluaran->tgl_awal = date('Y-m-d');
        $viewPengeluaran->tgl_akhir = date('Y-m-d');
        
        
        if (!empty($penghapusanaset_id)){
            $model = MAPenghapusanasetT::model()->findByPk($penghapusanaset_id);
            //$model->nopenghapusan = MyGenerator::noPenghapusanAset();
            $model->pegmenyetujui_nama = !empty($model->pegmenyetujui_id)?$model->pegMenyetujui->namaLengkap:null;
            $model->pegmengetahui_nama = !empty($model->pegmengetahui_id)?$model->pegMengetahui->namaLengkap:null;
        }
        
        
        
        if (isset($_POST['MAPenghapusanasetT'])){
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['MAPenghapusanasetT'];      
                $model->tglpenghapusan = MyFormatter::formatDateTimeForDb($model->tglpenghapusan);
                $model->tgl_sk_penghapusan = MyFormatter::formatDateTimeForDb($model->tgl_sk_penghapusan);
                $model->ruanganpenghapusan_id = Yii::app()->user->getState('ruangan_id');
                $model->pegpenghapusan_id = Yii::app()->user->getState('pegawai_id');
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                $ok = $ok && $model->save();
                
                if (isset($_POST['MAPenghapusanasetdetT'])){
                    foreach ($_POST['MAPenghapusanasetdetT'] as $ii => $det){
                        if ($det['ispilih'] == 1){
                            $modDet = new MAPenghapusanasetdetT;
                            $modDet->attributes = $det;
                            $modDet->penghapusanaset_id = $model->penghapusanaset_id;

                            $ok = $ok && $modDet->save();                        

                            $ok = $ok && MAInvperalatanT::model()->updateByPk($modDet->invperalatan_id,array('tglpenghapusan'=>$model->tglpenghapusan,'tipepenghapusan'=>$model->carapenghapusan));
                        }
                        
                    }
                }
                
                if($ok){
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index','penghapusanaset_id'=>$model->penghapusanaset_id,'sukses'=>1));       
                }else{                        
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }
        
        if (isset($_GET['MAInfopengeluaranasetV'])){
            $viewPengeluaran->attributes = $_GET['MAInfopengeluaranasetV'];               
            $viewPengeluaran->tgl_awal = $_GET['MAInfopengeluaranasetV']['tgl_awal'];    
            $viewPengeluaran->tgl_akhir = $_GET['MAInfopengeluaranasetV']['tgl_akhir'];    
        }

        $this->render($this->path_view.'index',array(
           'modDet' => $modDet,
           'model' => $model,
           'viewPengeluaran' => $viewPengeluaran
        ));
    }
        
    
}
