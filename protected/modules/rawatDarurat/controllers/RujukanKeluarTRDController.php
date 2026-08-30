<?php
Yii::import('rawatJalan.controllers.RujukanKeluarController');
Yii::import('rawatJalan.models.*');
class RujukanKeluarTRDController extends RujukanKeluarController
{
}
//class RujukanKeluarController extends MyAuthController
//{
//	public function actionIndex($pendaftaran_id)
//	{
//            $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
//            $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
//            
//            $modRujukanKeluar = new RDPasienDirujukKeluarT;
//            $modRujukanKeluar->pendaftaran_id = $pendaftaran_id;
//            $modRujukanKeluar->pasien_id = $modPendaftaran->pasien_id;
//            $modRujukanKeluar->pegawai_id = $modPendaftaran->pegawai_id;
//            $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
//            $modRujukanKeluar->tgldirujuk = date('d M Y H:i:s');
//            $modRujukanKeluar->diagnosasementara_ruj = $modRujukanKeluar->getDiagnosaSementara($pendaftaran_id);
//            if(isset($_POST['RDPasienDirujukKeluarT'])) {
//                $modRujukanKeluar->attributes = $_POST['RDPasienDirujukKeluarT'];
//                if($modRujukanKeluar->validate()){
//                    $modRujukanKeluar->save();
//                    Yii::app()->user->setFlash('success',"Data berhasil disimpan");
//                }
//            }
//		
//            $modRiwayatRujukanKeluar = RDPasienDirujukKeluarT::model()->with('rujukankeluar','pendaftaran')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id),array('order'=>'t.create_time DESC'));
//            
//            $this->render('index',array('modPendaftaran'=>$modPendaftaran,
//                                        'modPasien'=>$modPasien,
//                                        'modRujukanKeluar'=>$modRujukanKeluar,
//                                        'modRiwayatRujukanKeluar'=>$modRiwayatRujukanKeluar));
//	}
//        
//        public function actionAjaxDetailRujukanKeluar()
//        {
//            if(Yii::app()->request->isAjaxRequest) {
//            $idPasienDirujuk = $_POST['idPasienDirujuk'];
//            $modRujukanKeluar = RDPasienDirujukKeluarT::model()->findByPk($idPasienDirujuk);
//            $data['result'] = $this->renderPartial('_viewRujukanKeluar', array('modRujukanKeluar'=>$modRujukanKeluar), true);
//
//            echo json_encode($data);
//             Yii::app()->end();
//            }
//        }
//
//	// Uncomment the following methods and override them if needed
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