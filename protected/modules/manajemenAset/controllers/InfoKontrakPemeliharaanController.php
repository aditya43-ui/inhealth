<?php

/**
*   @author rusdiyanto <rusdiyanto@.com>
*/

class InfoKontrakPemeliharaanController extends MyAuthController {
    
    
        public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'manajemenAset.views.infoKontrakPemeliharaan.';
        public $init = ''; 
        
        public function actionIndex($id) {
            $modKontrakPemeliharaan = new MAKontrakpemeliharaanT();
            $modPrevent = new MAPrevmaintenT();
            $format = new MyFormatter();
            
            $modKontrakDetail = MAKontrakpemeliharaanT::model()->findAllByAttributes(array('invperalatan_id'=>$id),array('order'=>'kontrakpem_tgl DESC'));
            
            if(isset($_POST['MAKontrakpemeliharaanT'])) {
                $ok = true;
                $transaction = Yii::app()->db->beginTransaction();
                try{
                    $modKontrakPemeliharaan->attributes = $_POST['MAKontrakpemeliharaanT']; 
                    $modKontrakPemeliharaan->kontrakpem_tgl = $format->formatDateTimeForDb($_POST['MAKontrakpemeliharaanT']['kontrakpem_tgl']);
                    $modKontrakPemeliharaan->kontrakpem_sdtgl = $format->formatDateTimeForDb($_POST['MAKontrakpemeliharaanT']['kontrakpem_sdtgl']);
                    $modKontrakPemeliharaan->invperalatan_id = $id;
                    $modKontrakPemeliharaan->statuskontrak = 'aktif';
                    $modKontrakPemeliharaan->create_time = date('Y-m-d H:i:s');
		    $modKontrakPemeliharaan->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
		    $modKontrakPemeliharaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modKontrakPemeliharaan->kontrakpem_file = CUploadedFile::getInstance($modKontrakPemeliharaan, 'kontrakpem_file');	
                        if (!empty($modKontrakPemeliharaan->kontrakpem_file)){											
                          $filePDF = $modKontrakPemeliharaan->kontrakpem_file;
                          $fileName = $modKontrakPemeliharaan->kontrakpem_file;   
                          $filePath = ParamsUrl::pathKontrakPemeliharaanFileDirectory().$fileName;
                          
                          if (!file_exists(ParamsUrl::pathKontrakPemeliharaanFileDirectory())){
                              mkdir(ParamsUrl::pathKontrakPemeliharaanFileDirectory(),0775,true);
                          }
                          
                          $filePDF->saveAs($filePath);
                        }
                    $ok = $ok && $modKontrakPemeliharaan->save();        
                    
                    /* Proses untuk frekuensi di preventiv */
                    $interval_prov = trim(strtolower($_POST['MAPrevmaintenT']['frekuansi_prev']));
                    $interval_satuan = trim(strtolower($_POST['MAPrevmaintenT']['frekuensi_sat_prev']));
                    $interval = $_POST['MAPrevmaintenT']['frekuensi_jml_prev'];
                    
                    $format = null;
                    $timeInterval = null;
                
                    if ($interval_prov == 'setiap') {
                        if ($interval_satuan == 'hari') {
                            $format = 'P'.$interval.'D';
                        } else if ($interval_satuan == 'bulan') {
                            $format = 'P'.$interval.'M';
                        } else if ($interval_satuan == 'tahun') {
                            $format = 'P'.$interval.'Y';
                        } else if ($interval_satuan == 'minggu') {
                            $format = 'P'.($interval * 7).'D';
                        }
                    }
                    /* end */
                    
                    /* untuk simpan ke table prevmainten_t */         
                    if(isset($_POST['MAPrevmaintenT'])) {
                        if (!empty($format)) {
                            $timeInterval = new DateInterval($format);
                            
                            $base_date1 = new DateTime($modKontrakPemeliharaan->kontrakpem_tgl);
                            $base_date2 = new DateTime($modKontrakPemeliharaan->kontrakpem_sdtgl);
                            while ($base_date1 < $base_date2) {
                                $base_date1->format('Y-m-d');
                                $modPrevent1 = $this->actionSimpanPrevmainten($_POST['MAPrevmaintenT'], $modKontrakPemeliharaan, $modKontrakPemeliharaan->invperalatan_id, $base_date1->format('Y-m-d'));
                                $base_date1->add($timeInterval);
                            }
                                                
                        }else{
                            $modPrevent = $this->actionSimpanPrevmainten($_POST['MAPrevmaintenT'], $modKontrakPemeliharaan, $modKontrakPemeliharaan->invperalatan_id);
                        }
                    }      
                    /* end */
                   
                    if($ok){  
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                        $this->redirect(array('index','id'=>$id));       
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($modKontrakPemeliharaan));
                    }
                } catch (Exception $ex) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
                }  
                
            }
            
            $this->render($this->path_view.'index',array(
                'modKontrakPemeliharaan' => $modKontrakPemeliharaan,
                'modPrevent'=>$modPrevent,
                'modKontrakDetail'=>$modKontrakDetail,
                'format'=>$format
            ));
        }
        
        public function actionDelete($id)
	{
            $id = $id;
            if(isset($id)) {
                $deletePrevmaintent = MAPrevmaintenT::model()->deleteAllByAttributes(array('kontrakpemeliharaan_id'=>$id));
                $model = MAKontrakpemeliharaanT::model()->findByPk($id);
                $path = ParamsUrl::pathKontrakPemeliharaanFileDirectory().$model->kontrakpem_file;
            }
            /* Hapus file kontrak Jika file ada maka hapus */                
            if( !empty($model->kontrakpem_file) && file_exists( $path ) ){
                $model->delete();
                unlink($path);
            }else{
                $model->delete();
            }

            Yii::app()->user->setFlash('success',"Data Berhasil Di hapus");
            $this->redirect(array('index','id'=>$model->invperalatan_id));
        }
        
        /**
         * @author Tantowy <tantowijaya@.com>
         * Simpan preventiv maintenance handel frekuensi
         * @param type $post_prev
         * @param type $modKontrakPemeliharaan
         * @return \MAPrevmaintenT
         */
        public function actionSimpanPrevmainten($post_prev, $modKontrakPemeliharaan, $id, $base_date=null){
            $modPrevent = new MAPrevmaintenT();
            $modPrevent->attributes = $post_prev; 
            $modPrevent->invperalatan_id = $id;
            $modPrevent->kontrakpemeliharaan_id = $modKontrakPemeliharaan->kontrakpemeliharaan_id;
            $modPrevent->tglprevmainten = empty($base_date)? date('Y-m-d') : $base_date;
            $modPrevent->create_time = date('Y-m-d H:i:s');
            $modPrevent->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $modPrevent->create_ruangan = Yii::app()->user->getState('ruangan_id');
            if($modPrevent->validate()){
                $modPrevent->save();
            }
            return $modPrevent;
        }
    
        /**
         * @author Tantowy <tantowijaya@.com>
         * Proses untuk unduh berkas kontrak
         * @param type $id
         */
        public function actionUnduh($id) {
        
            $filename = MAKontrakpemeliharaanT::model()->findByPk($id);
                        
            $path = ParamsUrl::pathKontrakPemeliharaanFileDirectory().$filename->kontrakpem_file;
            
            if (!empty($filename->kontrakpem_file))
            {
                if( file_exists( $path ) ){     
                 
                    Yii::app()->getRequest()->sendFile( $filename->kontrakpem_file , file_get_contents( $path ) );
                }else{
                    Yii::app()->getRequest()->sendFile( 'file_tidak_ditemukan.txt' , file_get_contents(ParamsUrl::pathKontrakPemeliharaanFileDirectory().'file_tidak_ditemukan.txt' ) );
                }
            }else{
                Yii::app()->getRequest()->sendFile( 'file_tidak_ditemukan.txt' , file_get_contents(ParamsUrl::pathKontrakPemeliharaanFileDirectory().'file_tidak_ditemukan.txt' ) );
            }
        }
}
