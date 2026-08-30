<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - controller utama transaksi  work order
* RSST-1692
*/


class WorkOrderController extends MyAuthController
{	
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'manajemenAset.views.workOrder.';    
    public $init = '';        

    public function actionIndex($prevmainten_id)
    {       
        $modPrevenMain = MAPrevmaintenT::model()->findByPk($prevmainten_id);
        $model = new MAWorkorderT;
        $model->tglpemeliharaan = MyFormatter::formatDateTimeForUser($modPrevenMain->tglprevmainten);
        $model->jenisperalatan = $modPrevenMain->invperalatan->invperalatan_namabrg;
        $model->nomoraset = $modPrevenMain->invperalatan->invperalatan_kode;
        $model->lokasi_id = $modPrevenMain->invperalatan->lokasi_id;        
        
        if (isset($_POST['MAWorkorderT'])){

            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['MAWorkorderT'];                
                $model->workorder_tgl = !empty($model->workorder_tgl)?MyFormatter::formatDateTimeForDb($model->workorder_tgl):null;
                $model->tglpemeliharaan = !empty($model->tglpemeliharaan)?MyFormatter::formatDateTimeForDb($model->tglpemeliharaan):null;
                $model->tglpemeliharaan_selesai = !empty($model->tglpemeliharaan_selesai)?MyFormatter::formatDateTimeForDb($model->tglpemeliharaan_selesai):null;
                $model->status_pemeliharaan = ParamsConst::STATUS_WO_OPEN;
                $model->workorder_no = MyGenerator::noWorkOrder();
                $model->prevmainten_id = $modPrevenMain->prevmainten_id;
                $model->kontrakpemeliharaan_id = $modPrevenMain->kontrakpemeliharaan_id;
                $model->invperalatan_id = $modPrevenMain->invperalatan_id;
                $model->wo_pegawai_id = Yii::app()->user->getState('pegawai_id');
                $model->wo_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->lokasi_id = $modPrevenMain->invperalatan->lokasi_id;
                $model->workorder_tgl = date('Y-m-d H:i:s');
                $model->create_time = date('Y-m-d H:i:s');                
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');                
                if (($_POST['MAWorkorderT']['isinternal']) == 1){
                    $model->jenisteknisi = ParamsConst::JENIS_TEKNISI_INTERNAL;
                }else{
                    $model->jenisteknisi = ParamsConst::JENIS_TEKNISI_EKSTERNAL;
                }                
                
                $ok = $ok && $model->save();

                if($ok){
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index','prevmainten_id'=>$prevmainten_id,'sukses'=>1));       
                }else{                        
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }

        $this->render($this->path_view.'index',array(
           'modPrevenMain' => $modPrevenMain,
           'model' => $model
        ));
    }
                
}
