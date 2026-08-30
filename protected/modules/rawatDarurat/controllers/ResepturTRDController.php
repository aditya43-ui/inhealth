<?php
Yii::import('rawatJalan.controllers.ResepturController');
Yii::import('rawatJalan.models.*');
class ResepturTRDController extends ResepturController
{
}
//class ResepturController extends MyAuthController
//{
//    protected $successSave = false;
//    
//    public function actionIndex($pendaftaran_id)
//	{
//            $modPendaftaran=RDPendaftaranT::model()->findByPk($pendaftaran_id);
//            $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
//            
//            $modReseptur = new RDResepturT;
//            $modReseptur->noresep = MyGenerator::noResep();
//            $modReseptur->pegawai_id = $modPendaftaran->pegawai_id;
//            $modReseptur->ruanganreseptur_id = Yii::app()->user->getState('ruangan_id');
//            
//            if(isset($_POST['RDResepturT'])){
//                $transaction = Yii::app()->db->beginTransaction();
//                try {
//                    $this->saveReseptur($_POST, $modPendaftaran);
//                    
//                    if($this->successSave){
//                        $transaction->commit();
//                        Yii::app()->user->setFlash('success',"Data Resep berhasil disimpan");
//                    } else {
//                        $transaction->rollback();
//                        Yii::app()->user->setFlash('error',"Data gagal disimpan ");
//                    }
//                } catch (Exception $exc) {
//                    $transaction->rollback();
//                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
//                    //echo '<pre>'.print_r($_POST,1).'</pre>';
//                }
//            }
//		
//            $this->render('index',array('modPendaftaran'=>$modPendaftaran,
//                                        'modPasien'=>$modPasien,
//                                        'modReseptur'=>$modReseptur,));
//	}
//        
//        protected function saveReseptur($post,$modPendaftaran)
//        {
//            $reseptur = new RDResepturT;
//            $reseptur->pendaftaran_id = $modPendaftaran->pendaftaran_id;
//            $reseptur->tglreseptur = $post['RDResepturT']['tglreseptur'];
//            $reseptur->noresep = $post['RDResepturT']['noresep'];
//            $reseptur->pegawai_id = $post['RDResepturT']['pegawai_id'];
//            $reseptur->ruangan_id = $post['RDResepturT']['ruangan_id'];
//            $reseptur->ruanganreseptur_id = Yii::app()->user->getState('ruangan_id');
//            $reseptur->pasien_id = $modPendaftaran->pasien_id;
//            if($reseptur->validate()){
//                $reseptur->save();
//                $this->saveDetailReseptur($post, $reseptur);
//            } else {
//                $this->successSave = false;
//            }
//        }
//        
//        protected function saveDetailReseptur($post,$reseptur)
//        {
//            $valid = true;
//            for ($i = 0; $i < count((array)$post['obat']); $i++) {
//                $detail = new RDResepturDetailT;
//                $detail->reseptur_id = $reseptur->reseptur_id;
//                $detail->obatalkes_id = $post['obat'][$i];
//                $detail->sumberdana_id = $post['sumberdana'][$i];
//                $detail->satuankecil_id = $post['satuankecil'][$i];
//                $detail->racikan_id = ($post['isRacikan'][$i]) ? Params::RACIKAN_ID_NONRACIKAN : Params::RACIKAN_ID_RACIKAN;
//                $detail->r = 'R/';
//                $detail->rke = $post['Rke'][$i];
//                $detail->qty_reseptur = $post['qty'][$i];
//                $detail->signa_reseptur = $post['signa'][$i];
//                $detail->etiket = $post['etiket'][$i];
//                $detail->kekuatan_reseptur = $post['kekuatan'][$i];
//                $detail->satuankekuatan = $post['satuankekuatan'][$i];
//                $detail->hargasatuan_reseptur = $post['hargasatuan'][$i];
//                $detail->harganetto_reseptur = $post['harganetto'][$i];
//                $detail->hargajual_reseptur = $post['hargajual'][$i] * $post['qty'][$i];
//                
//                $detail->permintaan_reseptur = $post['jmlpermintaan'][$i];
//                $detail->jmlkemasan_reseptur = $post['jmlkemasan'][$i];
//                $valid = $detail->validate() && $valid;
//                if($valid){
//                    $detail->save();
//                }
//            }
//            
//            $this->successSave = ($valid) ? true : false;
//        }
//
//        // Uncomment the following methods and override them if needed
//	/*
//	public function filters()
//	{
//		// return the filter configuration for this controller, e.g.:
//		return array(
//			'inlineFilterName',
//			array(
//				'class'=>'path.to.FilterClass',
//				'propertyName'=>'propertyValue',
//			),
//		);
//	}
//
//	public function actions()
//	{
//		// return external action classes, e.g.:
//		return array(
//			'action1'=>'path.to.ActionClass',
//			'action2'=>array(
//				'class'=>'path.to.AnotherActionClass',
//				'propertyName'=>'propertyValue',
//			),
//		);
//	}
//	*/
//}