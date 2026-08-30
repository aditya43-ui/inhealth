<?php
Yii::import('rawatInap.controllers.PasienRawatInapController'); //Untuk menggunakan function saveAkomodasi()
class PemeriksaanAsesmenPerawatController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'hemodialisa.views.pemeriksaanAsesmenPerawat.';
        public $init = 'HD';
        public $init_resiko = 'HD';
        public $init_awalbidan = 'HD';
	
	public function actionIndex($pendaftaran_id, $pasienadmisi_id=null)
	{
            $modPendaftaran = HDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modAdmisi = HDPasienAdmisiT::model()->findByPk($pasienadmisi_id);
			$format = new MyFormatter();
			
			//if(Yii::app()->user->getState('akomodasiotomatis') == true){ //RND-7757
                                //$transaction_ako = Yii::app()->db->beginTransaction();
				//$ok = PasienRawatInapController::saveAkomodasi($modPendaftaran, $modAdmisi);
                                //var_dump($ok); die;
                                //
                                
                               // if ($ok) {
                                 //   $transaction_ako->commit();
                                    //Yii::app()->user->setFlash('success',"Biaya akomodasi pasien otomatis diperbaharui!");
                               //     $transaction_ako->rollback();
                                    //Yii::app()->user->setFlash('error',"Biaya akomodasi pasien gagal tersimpan. Silakan cek tarif akomodasi!");
                               // }                                                                
			//}

			
            $this->render($this->path_view.'index',array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'modAdmisi'=>$modAdmisi,
            ));
	}
}
