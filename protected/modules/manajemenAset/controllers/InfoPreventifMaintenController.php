<?php
/**
*   - Info Preventif Maintenance
*   @author	Andyka <andykaputra@.com>
*/

class InfoPreventifMaintenController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'manajemenAset.views.infopreventifmainten.';
        public $init = '';        

	public function actionIndex()
	{
            $criteria = new CDbCriteria();
            $format = new MyFormatter();	
            
            $model  = new MAInfoprevmaintenV;
            $model->tgl_awal = date('Y-m-d');
            $model->tgl_akhir = date('Y-m-d');
            if (isset($_GET['MAInfoprevmaintenV'])){
                $model->attributes = $_GET['MAInfoprevmaintenV'];
                $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInfoprevmaintenV']['tgl_awal']); 
                $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInfoprevmaintenV']['tgl_akhir']);
                $model->invperalatan_namabrg = $_GET['MAInfoprevmaintenV']['invperalatan_namabrg'];
                $model->invperalatan_kode = $_GET['MAInfoprevmaintenV']['invperalatan_kode'];
            }
            
            $criteria->addBetweenCondition('DATE(tglprevmainten)', $model->tgl_awal, $model->tgl_akhir);
            $criteria->compare('LOWER(invperalatan_namabrg)',strtolower($model->invperalatan_namabrg),true);
            $criteria->compare('LOWER(invperalatan_kode)',strtolower($model->invperalatan_kode),true);
            $modShow  = MAInfoprevmaintenV::model()->findAll($criteria);
            
            $this->render($this->path_view.'index',array('model' => $model, 'modShow' => $modShow, 'format'=>$format));
        }
        
        public function actionSetStatus() {
             if(Yii::app()->request->isAjaxRequest) {
			$korektifmainten_id = isset($_POST['korektifmainten_id'])?$_POST['korektifmainten_id'] : null;	
			$modKorektif = KorektifmaintenT::model()->findByPk($korektifmainten_id);
			if (!empty($modKorektif) && $modKorektif->korektifmainten_status == Params::STATUSDOKUMENOPEN){                   
                                $modKorektif->korektifmainten_status = Params::STATUSDOKUMENINPROGRESS; 
                                $modKorektif->update_time = date('Y-m-d H:i:s'); 
                                $modKorektif->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modKorektif->update(); 
                                $data['status'] = true;
			}else{
				$data['status'] = false;
				$data['pesan'] = 'Update Gagal Di Lakukan !';
			} 
			echo json_encode($data); 
                        Yii::app()->end();
		}
        }
       
                
}
