<?php
/**
 * Informasi Pasien Rujukan / Rujukan Penunjang
 * @author  Andyka <andykaputra@.com>
 * @author  Elham Budianto <elhambudianto@.com>
 * @website	   <.com>
 * RSST-2086
 */

class RujukanPenunjangATController extends MyAuthController
{
    public $path_view_rujuk = 'anestesi.views.rujukanPenunjang.';
    
    /**
     * Fungsi load halaman informasi pasien rujukan
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::app()->name." - Pasien Rujukan";
        $model = new PasienkirimkeunitlainV;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');        

        if (isset($_GET['PasienkirimkeunitlainV'])) {
            $model->attributes = $_GET['PasienkirimkeunitlainV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_akhir']);
            $model->statusperiksa = isset($_GET['PasienkirimkeunitlainV']['statusperiksa'])?$_GET['PasienkirimkeunitlainV']['statusperiksa']:null;
        }

        $dataProvider = $model->searchRujukAnestesi();
        $this->render($this->path_view_rujuk.'index',array('dataProvider'=>$dataProvider, 'model'=>$model));
    }
        
}

