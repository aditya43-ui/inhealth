<?php
/**
*   - Untuk menampilkan informasi tab dokumen lain pada detail peralatan
*   @author Andyka <andykaputra@.com>
*/

class InvperalatandokTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'manajemenAset.views.invperalatandokT.';
        public $init = '';          
    
        public function actionIndex($id)
        {   
            $format  = new MyFormatter();
            $model   = new MAInvperalatandokT();
            $modShow = InvperalatandokT::model()->findAllByAttributes(array('invperalatan_id'=>$id));
            
            if(isset($_POST['MAInvperalatandokT']))
            {
                    $transaction = Yii::app()->db->beginTransaction();
                    $model->attributes = $_POST['MAInvperalatandokT']; 
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id =Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->invperalatan_id = $id;
                    $model->invperalatandok_file = CUploadedFile::getInstance($model, 'invperalatandok_file');
                    if ($model->validate()) {
                        try {
                        $file = $model->invperalatandok_file;
                        if (!empty($model->invperalatandok_file)) {
                        $fullImgName = str_replace(' ','_',strtolower(date('dmY_s').$file));
                        $fullImgSource = ParamsUrl::pathInvperizinanDirectory() . $fullImgName;
                        
                        $model->invperalatandok_file = str_replace(' ','_',strtolower(date('dmY_s').$file));
                        if ($model->save()) {
                            
                            if (!file_exists(ParamsUrl::pathInvperizinanDirectory())){
                                mkdir(ParamsUrl::pathInvperizinanDirectory(),0775,true);
                            }
                            
                            $file->saveAs($fullImgSource);
                        }
                    }
                    else{
                        $model->save();
                    }
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->redirect(array('index','id'=>$id));
                    } catch (Exception $e) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($e,true));
                    }
                }
            }
            $this->render($this->path_view.'index',array(
                'model'=>$model,
                'modShow'=>$modShow,
            ));
        }
        
        public function actionUnduh($id) {
        
            $filename = MAInvperalatandokT::model()->findByPk($id);
                        
            $path = ParamsUrl::pathInvperizinanDirectory().$filename->invperalatandok_file;
            
            if (!empty($filename->invperalatandok_file))
            {
                if( file_exists( $path ) ){     
                 
                    Yii::app()->getRequest()->sendFile( $filename->invperalatandok_file , file_get_contents( $path ) );
                }else{
                    Yii::app()->getRequest()->sendFile( 'file_tidak_ditemukan.txt' , file_get_contents(ParamsUrl::pathPegawaiFileDirectory().'file_tidak_ditemukan.txt' ) );
                }
            }else{
                Yii::app()->getRequest()->sendFile( 'file_tidak_ditemukan.txt' , file_get_contents(ParamsUrl::pathPegawaiFileDirectory().'file_tidak_ditemukan.txt' ) );
            }
        }
        public function actionDelete(){
            if(Yii::app()->request->isAjaxRequest) {

                //MAInvperalatandokT
                $model = MAInvperalatandokT::model()->findByPk($_POST['id']);
                $modperalatandok=$model->invperalatandok_id;

                $cri = new CDbCriteria();
                $cri->addCondition("invperalatandok_id = '".$modperalatandok."' ");             
                $up1 = MAInvperalatandokT::model()->deleteAll($cri);


                if($model->delete()){
                    $data['status'] = 'gagal';
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal dihapus.');
                }else{
                    $data['status'] = 'sukses';
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus.');
                }


                echo CJSON::encode($data);
                }
            Yii::app()->end();
        }
}
