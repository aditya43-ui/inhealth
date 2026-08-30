<?php
/**
 * Halaman Petunjuk Penggunaan
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class PetunjukPenggunaanPenyediaController extends MyAuthController{
    public $layout = '//layouts/columnPenyedia';
    public $khusus_supplier = true;
    
    /**
     * Halaman Index Petunjuk Penggunaan
     */
    public function actionIndex(){
        $this->layout = '//layouts/columnPenyedia';
        $model = SupplierM::model()->findByPk(Yii::app()->user->getState('supplier_id'));
        $modPetunjuk = PetunjukpenggunaanT::model()->findByAttributes(array('petunjukpenggunaan_modul' => 'Pengadaan', 'petunjukpenggunaan_deskripsi' => 'Petunjuk Penggunaan Modul Supplier'));
        
        $this->render('index', array('model' => $model, 'modPetunjuk' => $modPetunjuk));
    }
}