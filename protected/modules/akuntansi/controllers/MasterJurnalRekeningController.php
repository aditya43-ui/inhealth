<?php
class MasterJurnalRekeningController extends MyAuthController
{
   /**
    * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
    * using two-column layout. See 'protected/views/layouts/column2.php'.
    */
   public $layout = '//layouts/column1';
   public $defaultAction = 'index';
   public $path_view = 'akuntansi.views.masterJurnalRekening.';
   /**
    * Lists all models.
    */
   public function actionIndex()
   {
      $this->pageTitle = Yii::app()->name . " - Jurnal Rekening";
      $this->render($this->path_view . 'index');
   }
}
