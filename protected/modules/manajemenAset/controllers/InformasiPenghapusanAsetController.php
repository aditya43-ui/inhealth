<?php
/**
* - digunakan sebagai informasi penghapusan aset
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php
class InformasiPenghapusanAsetController extends MyAuthController
{    
    public function actionIndex(){
        
        $model = new InfopenghapusanasetV('searchInformasi');
        $model->tgl_awal= date("Y-m-d");
        $model->tgl_akhir= date("Y-m-d");        
        if (isset($_GET['InfopenghapusanasetV'])){
            $model->attributes = $_GET['InfopenghapusanasetV'];    
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['InfopenghapusanasetV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['InfopenghapusanasetV']['tgl_akhir']);
        }
        $this->render('index',
            array(
                'model'=>$model,
            )
        );
    }
    
    public function actionUbahStatusInProgress(){
        if(Yii::app()->request->isPostRequest)
		{
			$id = $_POST['id'];
            $model = WorkorderT::model()->findByPk($id);
            $model->status_pemeliharaan = 'SEDANG';
            $model->save();
            if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data berhasil ditambahkan.</div>",
                        ));
                    exit;
                }
		}
		else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }
    
    public function actionDetail($id){
        
        $this->layout = '//layouts/iframe';
        $model = InfopenghapusanasetV::model()->findByAttributes(array('penghapusanaset_id'=>$id));
        $model->tglpenghapusan = MyFormatter::formatDateTimeForUser($model->tglpenghapusan);
        $model->tgl_sk_penghapusan = MyFormatter::formatDateTimeForUser($model->tgl_sk_penghapusan);
        $modelDetail = PenghapusanasetdetT::model()->findAllByAttributes(array('penghapusanaset_id'=>$id));
        $this->render('_detail',
            array(
                'model'=>$model,
                'modelDetail'=>$modelDetail,
            )
        );
    }
    
    public function actionBatalPenghapusan()
    {
       if (Yii::app()->request->isAjaxRequest) {
           $id = $_POST['id']; 
            $modDetailPenghapusan = PenghapusanasetdetT::model()->findAllByAttributes(array('penghapusanaset_id'=>$id));
            foreach($modDetailPenghapusan as $modDet){
                $modPeralatan = InvperalatanT::model()->findByPk($modDet->invperalatan_id);
                $modPeralatan->tglpenghapusan = NULL;
                $modPeralatan->tipepenghapusan = NULL;
                $modPeralatan->save();
            }
            $modDetail = PenghapusanasetdetT::model()->deleteAllByAttributes(array('penghapusanaset_id'=>$id));
           
            $model= PenghapusanasetT::model()->findByPk($id);
            $model->delete();
             if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                        ));
                    exit;
                }
           //$modPeralatan= InvperalatanT::model()->findByPk($model->invperalatan_id);
           
            Yii::app()->end();

       }
       
    }
    
}