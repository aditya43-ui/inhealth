<?php
/**
 * 
 * controller utama transaksi tabulasi daftar titik keselamatan pasien
 * 
 * @package      application.modules.anestesi
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Elham Budianto <elhambudianto@.com>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class DaftarTitikKeselamatanController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'anestesi.views.praAnestesi.daftarTitikKeselamatan.';
    public $init = '';
    public $simpan_titik = true;    
    public $layout = '//layouts/iframe';

    /**
     * Digunakan untuk menampilkan transaksi aftar titik keselamatan pasien
     * @param type $pasienanastesi_id
     * @param type $praanestesi_induksi_id
     */
    public function actionIndex($pasienanastesi_id,$praanestesi_ttkkeselamanan_id=null) {
        
        if (!empty($pasienanastesi_id)){
            $model = ATPraanestesiTtkkeselamananT::model()->findByAttributes(array('pasienanastesi_id'=>$pasienanastesi_id));                                    
            if(empty($model)){
                $model = new ATPraanestesiTtkkeselamananT();
            }
        }else{ 
            $model = new ATPraanestesiTtkkeselamananT();
        }          
        $criteria = new CDbCriteria();
        $criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
        $modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);                                
        
        $model->pendaftaran_id = $modKunjungan->pendaftaran_id;
        $model->pasien_id = $modKunjungan->pasien_id;
        $model->pasienanastesi_id = $modKunjungan->pasienanastesi_id;
        $model->pasienmasukpenunjang_id = $modKunjungan->pasienmasukpenunjang_id;
                
        if (!empty($praanestesi_ttkkeselamanan_id)){
            $model = ATPraanestesiTtkkeselamananT::model()->findByPk($praanestesi_ttkkeselamanan_id);                                    
        }               
                        
        if (isset($_POST['ATPraanestesiTtkkeselamananT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                
                $this->saveDaftarTitikKeselamatan($model,$_POST['ATPraanestesiTtkkeselamananT']);
                                                                                   
                if ($this->simpan_titik) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'pasienanastesi_id'=>$pasienanastesi_id,'praanestesi_ttkkeselamanan_id' => $model->praanestesi_ttkkeselamanan_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,               
        ));
    }      
    
    /**
     * fungsi simpan induksi
     * @param type $model
     * @param type $post
     * @return type
     */
    public function saveDaftarTitikKeselamatan($model, $post){        
                
        $model->attributes = $post;                 
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        $this->simpan_titik = $this->simpan_titik && $model->save();                                                     
        
        return $model;
    }                  
}
