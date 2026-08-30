<?php
/**
 * Controller untuk Informasi Penyedia 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class InformasiPenawaranController extends MyAuthController{
    public $layout = '//layouts/column1';
    public $khusus_supplier = true;
    /**
     * Halaman index untuk Informasi Penawaran
     */
    public function actionIndex(){
        if (empty(Yii::app()->user->getState('supplier_id'))) {
            $this->layout = $this->layout;
        } else {
            $this->layout = '//layouts/columnPenyedia';
        }
        $this->render('index');
    }
}