<?php
/**
*   - Preventif Maintenance History
*   @author	Andyka <andykaputra@.com>
*/

class PreventifMaintenanceHistoryController extends MyAuthController
{
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'manajemenAset.views.preventifMaintenanceHistory.';
        public $init = '';        

	public function actionIndex($id)
	{
            $model = MAWorkorderT::model()->findAllByAttributes(array('invperalatan_id'=>$id));

            $this->render($this->path_view.'index',array('model' => $model));
        }       
}
