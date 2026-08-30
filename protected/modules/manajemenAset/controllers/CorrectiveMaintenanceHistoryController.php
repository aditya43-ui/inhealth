<?php
/**
*   - Corrective Maintenance History
*   @author	Andyka <andykaputra@.com>
*/

class CorrectiveMaintenanceHistoryController extends MyAuthController
{
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'manajemenAset.views.correctiveMaintenanceHistory.';
        public $init = '';        

	public function actionIndex($id)
	{
            $model = MAKorektifmaintenT::model()->findAllByAttributes(array('invperalatan_id'=>$id));

            $this->render($this->path_view.'index',array('model' => $model));
        }       
}
