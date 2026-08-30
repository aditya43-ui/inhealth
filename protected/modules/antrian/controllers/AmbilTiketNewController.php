<?php 

class AmbilTiketNewController extends Controller
{
        public $layout='//layouts/kiosAntrian'; 
        
        public $pathView = 'antrian.views.ambilTiketNew.';
        
        public function actionIndex($lokasiantrian_id,$jenis_pasien=null,$jenis_tombol=null)
	{
            $criteria = new CdbCriteria();
            $criteria->addCondition('lokasi_karcisantrian_id = '.$lokasiantrian_id);
            $criteria->addCondition('modelantrian_aktif = true');
            $criteria->order = 'modelantrian_singkatan';
            $modLokets = ModelantrianM::model()->findAll($criteria);
            $lokasiAntrian = LokasiKarcisantrianM::model()->findByPk($lokasiantrian_id);
            $model = new ANAntrianT;
                      
            $script = array();
            if ($jenis_tombol=='custom'){      
                foreach($modLokets as $det){
                    if (!empty($det->modelantrian_buka)){
                        $script[$det->modelantrian_buka] = "if (jamsekarang == '".$det->modelantrian_buka."'){disabledTombol();}";
                    }
                    if (!empty($det->modelantrian_tutup)){
                        $script[$det->modelantrian_tutup] = "if (jamsekarang == '".$det->modelantrian_tutup."'){disabledTombol();}";
                    }
                }
                                
                $this->layout = '//layouts/kiosAntrianCustom';
                $this->render($this->pathView.'indexCustom',array('model'=>$model,'modLokets'=>$modLokets, 'lokasiAntrian'=>$lokasiAntrian, 'jenis_pasien'=>$jenis_pasien, 'lokasiantrian_id'=>$lokasiantrian_id, 'script'=>$script));
            }else{
                $this->render($this->pathView.'index',array('model'=>$model,'modLokets'=>$modLokets, 'lokasiAntrian'=>$lokasiAntrian, 'jenis_pasien'=>$jenis_pasien, 'lokasiantrian_id'=>$lokasiantrian_id));
            }
	}
        /**
         * untuk menyimpan tiket (ajax)
         */
        public function actionSimpanTiket(){
            if(Yii::app()->request->isAjaxRequest){
                $data = array();
                $data['pesan'] = "Data gagal disimpan! ";
                if(isset($_POST['data'])){
                    parse_str($_POST['data'],$post);
                    
                    $model = new ANAntrianT;
                    $model->attributes = $post['ANAntrianT'];
                    $model->profilrs_id=Params::DEFAULT_PROFIL_RUMAH_SAKIT;
                    $model->ruangan_id=Params::DEFAULT_RUANGAN_KIOSK;
                    
                    $modelAntrian = ModelantrianM::model()->findByPk($model->modelantrian_id);
                                        
                    $model->tglantrian=date('Y-m-d H:i:s');
                    $model->noantrian=(empty($model->noantrian) ? MyGenerator::noModelAntrianLoket($model->modelantrian_id, $modelAntrian->modelantrian_formatnomor) : $model->noantrian);
                    $delaytombol = $this->actionGetDelayTombolAntrian();
                    // var_dump($model->attributes, $model->validate(), $model->errors); die;
                    if($model->validate()){  
                        $model->save();
                        $data['model'] = $model;
                        $data['delaytombol'] = $delaytombol;
                        $data['pesan'] = "Data berhasil disimpan!";
                    }else{
                        $data['pesan'] = "Data gagal disimpan! ".CHtml::errorSummary($model);
                    }
                }
                echo CJSON::encode($data);
                Yii::app()->end();
            }
        }
        
        public function actionPrint($antrian_id)
        {
            $modAntrian = ANAntrianT::model()->findByPk($antrian_id);
            $this->layout='//layouts/printWindows';
            $this->render($this->pathView.'printNoAntrian',array('modAntrian'=>$modAntrian));
        }

        public function actionGetRunningText()
        {
            //konfig tidak ngambil dari session (state) karena tidak ada login untuk controller ini
            $konfig = KonfigsystemK::model()->find();
            
            $text = $konfig->running_text_kiosk;
            
            echo json_encode($text);
        }
        
        public function actionGetDelayTombolAntrian()
        {
            //konfig tidak ngambil dari session (state) karena tidak ada login untuk controller ini
            $konfig = KonfigsystemK::model()->find();
            
            $delaytombol = $konfig->delaytombolantrian;
            
            return $delaytombol;
        }
	
}