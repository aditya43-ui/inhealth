<?php
/**
*   - Untuk menampilkan informasi tab pada detail peralatan
*   @author Andyka <andykaputra@.com>
*/

class InfoPeralatanController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'manajemenAset.views.daftarperalatan.infoPeralatan.';
        public $init = '';          

	public function actionIndex($id)
	{
            $model = MAInvperalatanT::model()->findByPk($id);                       
            
            $this->render($this->path_view.'index',array(
                'model' => $model,
            ));
	}
            
        public function actionDetailinformasi($id) {
            
            $format = new MyFormatter;
            $model = $this->loadModel($id);
            $modelDetail = InvperalatanT::model()->findByPk($id);
            if(!empty($modelDetail->terimapersdetail_id)){
                $terimapersediaan_id = TerimapersdetailT::model()->findByPk($modelDetail->terimapersdetail_id)->terimapersediaan_id;
                $modelDetail->nopenerimaan = TerimapersediaanT::model()->findByPk($terimapersediaan_id)->nopenerimaan;
            }
            $modBarang = $this->loadModelBarang($model->barang_id);
            $data['pemilikbarang_nama'] = !empty($model->pemilikbarang_id) ? $model->pemilik->pemilikbarang_nama : '';
            $dataAsalAset['asalaset_nama'] = !empty($model->asalaset_id) ? $model->asal->asalaset_nama : '';
            $dataLokasi['lokasiaset_namalokasi'] = !empty($model->lokasi_id) ? $model->lokasi->lokasiaset_namalokasi : '';
            
            // Uncomment the following line if AJAX validation is needed

            if (isset($_POST['MAInvperalatanT'])) {
                    $model->attributes = $_POST['MAInvperalatanT'];
                    $model->peralatan_garansihabis = $format->formatDateTimeForDb($model->peralatan_garansihabis);
                    if ($model->save()) {
                            BarangM::model()->updateByPk($model->barang_id, array('barang_statusregister' => true));
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('detailinformasi','id'=>$id));
                    }
            }

            $this->render($this->path_view.'detailinformasi', array(
                    'model' => $model, 'modBarang' => $modBarang, 'data' => $data, 'dataAsalAset' => $dataAsalAset, 'dataLokasi' => $dataLokasi, 'modelDetail' => $modelDetail, 
            ));
	}      
        
        public function loadModel($id) {
            $model = MAInvperalatanT::model()->findByPk($id);
            if ($model === null)
                    throw new CHttpException(404, 'The requested page does not exist.');
            return $model;
	}

	public function loadModelBarang($id) {
            $model = BarangM::model()->findByPk($id);
            if ($model === null)
                    throw new CHttpException(404, 'The requested page does not exist.');
            return $model;
	}
        
    //Untuk menyimpan gambar
    public function actionDetailgambar($id)
    {   
        $model = new InvgambarM();
        $modShow = MAInvgambarM::model()->findAllByAttributes(array('invperalatan_id'=>$id));

        if(isset($_POST['InvgambarM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;

            $data = CUploadedFile::getInstanceByName('InvgambarM[name]');


            try {

                if (isset($_FILES['InvgambarM'])) {

                    $files = $_FILES['InvgambarM'];


                    if (!file_exists(ParamsUrl::pathInvgambarDirectory())) {
                        mkdir(ParamsUrl::pathInvgambarDirectory(),0775, true);
                    }

                    if (!file_exists(ParamsUrl::pathInvgambarTumbsDirectory())) {
                        mkdir(ParamsUrl::pathInvgambarTumbsDirectory(),0775, true);
                    }


                    Yii::import("ext.EPhpThumb.EPhpThumb");




                    foreach ($files['error']['invgambar_nama'] as $idx=>$status) {
                        if ($status != UPLOAD_ERR_OK) {
                            continue;
                        }

                        $name = date('YmdHis')."_".strtolower(str_replace(" ","_",$files["name"]['invgambar_nama'][$idx]));

                        if (is_uploaded_file($files["tmp_name"]['invgambar_nama'][$idx])) {



                            $modDetails = new MAInvgambarM;
                            $modDetails->invperalatan_id = $id;
                            $modDetails->invgambar_nama = $name;
                            $modDetails->create_time = date('Y-m-d H:i:s');
                            $modDetails->create_loginpemakai_id =Yii::app()->user->id;
                            $modDetails->create_ruangan = Yii::app()->user->getState('ruangan_id');

                            $thumb = new EPhpThumb();
                            $thumb->init(); //this is needed
                            $fullImgName = $modDetails->invgambar_nama;
                            $fullImgSource = ParamsUrl::pathInvgambarDirectory() . $fullImgName;
                            $fullThumbSource = ParamsUrl::pathInvgambarTumbsDirectory() . 'kecil_' . $fullImgName;


                            if ($modDetails->save()) {
                                $ok = $ok && move_uploaded_file(
                                    $files["tmp_name"]['invgambar_nama'][$idx], 
                                    ParamsUrl::pathInvgambarDirectory().$name
                                );

                                $thumb->create($fullImgSource)
                                ->resize(200, 200)
                                ->save($fullThumbSource);	
                            } else {
                                $ok = false;
                            }

                        } else $ok = false;

                    }
                }

                if($ok){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
                    $this->refresh();
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Gagal !");
                }
            } catch (Exception $e) {
              $transaction->rollback();
              Yii::app()->user->setFlash('error',"Data pemakaian Bahan gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }

        $this->render($this->path_view.'detailgambar',array(
            'model'=>$model,
            'modShow'=>$modShow,
        ));
    }

    /**
     * Menghapus gambar dari filesystem dan database setelah dilakukan
     * konfirmasi penghapusan.
     */
    public function actionDelete()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $id = $_POST['id'];
        $foto = InvgambarM::model()->findByAttributes(array(
            'invgambar_id'=>$id,
        ));


        if (file_exists(ParamsUrl::pathInvgambarTumbsDirectory() . 'kecil_'.$foto->invgambar_nama)) {
            unlink(ParamsUrl::pathInvgambarTumbsDirectory() . 'kecil_'.$foto->invgambar_nama);
        }

        if (file_exists(ParamsUrl::pathInvgambarDirectory().$foto->invgambar_nama)) {
            unlink(ParamsUrl::pathInvgambarDirectory().$foto->invgambar_nama);
        }

        $delete = MAInvgambarM::model()->deleteByPk($id);

        $ok = 1;

        if ($delete) {
            $ok = 1;
            $msg = "Gambar Peralatan berhasil dihapus.";
        } else {
            $ok = 0;
            $msg = "Gambar Peralatan gagal dihapus.";
        }

        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }
}
