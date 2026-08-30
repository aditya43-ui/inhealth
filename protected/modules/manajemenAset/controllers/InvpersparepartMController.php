<?php
/**
*   - Tab Supporting items
*   @author	Andyka <andykaputra@.com>
*/

class InvpersparepartMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'manajemenAset.views.invpersparepartM.';
        public $init = '';        


        public function actionIndex($id) {
        $model = new MAInvpersparepartM();
        $format = new MyFormatter();
        $modSparepart = InvpersparepartM::model()->findAllByAttributes(array('invperalatan_id'=>$id));
           if(isset($_POST['MAInvpersparepartM'])) {
                $ok = true;
                $transaction = Yii::app()->db->beginTransaction();
                $model = new MAInvpersparepartM();
                $model->attributes = $_POST['MAInvpersparepartM'];
                $model->invperalatan_id = $id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->create_loginpemakai_id  = Yii::app()->user->getState('loginpemakai_id');
                $model->create_time  = date('Y-m-d H:i:s');
                $model->invsparepart_gbr = CUploadedFile::getInstance($model, 'invsparepart_gbr');	
                   if ($model->validate()) {
                    try {
                        $random = rand(0000000, 9999999);
                        $model->invsparepart_gbr = CUploadedFile::getInstance($model, 'invsparepart_gbr');
                        $gambar = $model->invsparepart_gbr;
                        if (!empty($model->invsparepart_gbr)) {
                            $model->invsparepart_gbr = strtolower(str_replace(" ","_",$random . $model->invsparepart_gbr));

                            Yii::import("ext.EPhpThumb.EPhpThumb");

                            $thumb = new EPhpThumb();
                            $thumb->init(); //this is needed

                            $fullImgName = $model->invsparepart_gbr;
                            $fullImgSource = ParamsUrl::pathInvpersparepartDirectory() . $fullImgName;
                            $fullThumbSource = ParamsUrl::pathInvpersparepartTumbsDirectory() . 'kecil_' . $fullImgName;

                            $model->invsparepart_gbr = $fullImgName;                            
                        }                        
                        
                        $ok = $ok && $model->save();
                        
                        if ($ok){     
                            if (!empty($gambar)){
                                
                                if (!file_exists(ParamsUrl::pathInvpersparepartDirectory())){
                                    mkdir(ParamsUrl::pathInvpersparepartDirectory(), 0775, true);
                                }
                                
                                if (!file_exists(ParamsUrl::pathInvpersparepartTumbsDirectory())){
                                    mkdir(ParamsUrl::pathInvpersparepartTumbsDirectory(), 0775, true);
                                }
                                
                                $gambar->saveAs($fullImgSource);
                                $thumb->create($fullImgSource)
                                        ->resize(200, 200)
                                        ->save($fullThumbSource);	
                            }
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('index','id'=>$id));
                        }else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($e,true));
                        }
                    } catch (Exception $e) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($e,true));
                    }
                }
            }
            $this->render('index',array('model' => $model, 'modSparepart'=>$modSparepart));
        }
        
        public function actionDelete(){
            if(Yii::app()->request->isAjaxRequest) {

                //MAInvpersparepartM
                $model = MAInvpersparepartM::model()->findByPk($_POST['id']);
                $modsparepart=$model->invpersparepart_id;

                $cri = new CDbCriteria();
                $cri->addCondition("invpersparepart_id = '".$modsparepart."' ");             
                $up1 = MAInvpersparepartM::model()->deleteAll($cri);


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
        
        public function loadModel($id)
        {
                $model=MAInvpersparepartM::model()->findByAttributes(array('invperalatan_id'=>$id));
                if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
                return $model;
        }
        
        public function actionAutocompleteBarang()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $returnVal = array();
                $nama_barang = isset($_GET['$nama_barang']) ? $_GET['$nama_barang'] : null;
                
                if(empty($nama_barang)){

                        $criteria = new CDbCriteria();
                        $criteria->compare('LOWER(nama_barang)', strtolower($nama_barang), true);
                        $criteria->order = 'nama_barang';
                        $criteria->limit = 5;
                        $models = BarangM::model()->findAll($criteria);
                        foreach($models as $i=>$model)
                        {
                                $attributes = $model->attributeNames();
                                foreach($attributes as $j=>$attribute) {
                                        $returnVal[$i]["$attribute"] = $model->$attribute;
                                }
                                $returnVal[$i]['label'] = $model->$nama_barang;
                                $returnVal[$i]['value'] = $model->$nama_barang;
                        }

                }else{

                        $criteria = new CDbCriteria();
                        $criteria->compare('LOWER(barang_m.barang_id)', strtolower($nama_barang), true);
                        $criteria->join = "JOIN barang_m ON t.barang_id = barang_m.barang_id";
                        $criteria->order = 'barang_m.barang_id, t.barang_nama';
                        $criteria->limit = 50;
                        $models = BarangM::model()->findAll($criteria);
                        foreach($models as $i=>$model)
                        {
                                $attributes = $model->attributeNames();
                                foreach($attributes as $j=>$attribute) {
                                        $returnVal[$i]["$attribute"] = $model->$attribute;
                                }
                                $returnVal[$i]['label'] = $model->pegawai->barang_id.
                                                                        ' - '.$model->$nama_barang;
                                $returnVal[$i]['value'] = $model->$nama_barang;
                        }

                }
					
                echo CJSON::encode($returnVal);
            }else
                throw new CHttpException(403,'Tidak dapat mengurai data');
            Yii::app()->end();
	}
}
