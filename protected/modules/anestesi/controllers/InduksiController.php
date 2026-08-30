<?php
/**
 * 
 * controller utama transaksi tabulasi induksi
 * 
 * @package      application.modules.anestesi
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class InduksiController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'anestesi.views.induksi.';
    public $init = '';
    public $simpan_induksi = true;
    public $simpan_induksi_det = true;    
    public $layout = '//layouts/iframe';

    /**
     * Digunakan untuk menampilkan transaksi induksi
     * @param type $pasienanastesi_id
     * @param type $praanestesi_induksi_id
     */
    public function actionIndex($pasienanastesi_id,$praanestesi_induksi_id=null) {
        
        
        $model = new ATPraanestesiInduksiT();
        $modDet = new ATPraanestesiInduksidetT();                
                
        $criteria = new CDbCriteria();
        $criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
        $modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);                                
        $load = array();
        
        
        
        
//        if (!empty($praanestesi_induksi_id)){                                    
//            $cekData = ATPraanestesiInduksidetT::model()->findAllByAttributes(array('praanestesi_induksi_id' =>$praanestesi_induksi_id));                                                
//            
//            foreach ($cekData as $det){
//                $load[$det->kelompokinduksi]['kelompok'] = $det->kelompokinduksi;
//                $load[$det->kelompokinduksi]['det'][$det->praanestesi_induksidet_id]['id'] = $det->praanestesi_induksidet_id;
//                $load[$det->kelompokinduksi]['det'][$det->praanestesi_induksidet_id]['ukuran'] = $det->ukuran;
//                $load[$det->kelompokinduksi]['det'][$det->praanestesi_induksidet_id]['keterangan'] = $det->keterangan;
//                $load[$det->kelompokinduksi]['det'][$det->praanestesi_induksidet_id]['kelompok'] = $det->kelompokinduksi;
//            }
//        }else{
            $cekInduksi = ATPraanestesiInduksiT::model()->findByAttributes(array('pasienanastesi_id'=>$pasienanastesi_id),array('order'=>'create_time DESC'));
            if (!empty($cekInduksi)){
                $model = $cekInduksi;
                
                $cekData = ATPraanestesiInduksidetT::model()->findAllByAttributes(array('praanestesi_induksi_id' =>$cekInduksi->praanestesi_induksi_id));
            
                foreach ($cekData as $det){
                    $load[$det->kelompokinduksi]['kelompok'] = $det->kelompokinduksi;
                    $load[$det->kelompokinduksi]['det'][$det->praanestesi_induksidet_id]['id'] = $det->praanestesi_induksidet_id;
                    $load[$det->kelompokinduksi]['det'][$det->praanestesi_induksidet_id]['ukuran'] = $det->ukuran;
                    $load[$det->kelompokinduksi]['det'][$det->praanestesi_induksidet_id]['keterangan'] = $det->keterangan;
                    $load[$det->kelompokinduksi]['det'][$det->praanestesi_induksidet_id]['kelompok'] = $det->kelompokinduksi;
                }
            }
        //}               
        
        if (isset($_POST['ATPraanestesiInduksiT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->pasienanastesi_id = $modKunjungan->pasienanastesi_id;
                $model->pendaftaran_id = $modKunjungan->pendaftaran_id;
                $model->pasien_id = $modKunjungan->pasien_id;
                $model->pasienmasukpenunjang_id = $modKunjungan->pasienmasukpenunjang_id;
                $induksi = $this->saveInduksi($model,$_POST['ATPraanestesiInduksiT']);
                
                $this->saveInduksiDet($modDet,$induksi,$_POST['ATPraanestesiInduksidetT']);
                
                if (isset($_POST['hapus'])){
                    $idDel = array();
                    foreach($_POST['hapus'] as $del){
                        $idDel[] = $del;
                    }
                    
                    $criDel = new CDbCriteria();
                    $criDel->addInCondition("praanestesi_induksidet_id", $idDel);
                    ATPraanestesiInduksidetT::model()->deleteAll($criDel);
                }
                                                    
                if ($this->simpan_induksi && $this->simpan_induksi_det) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'pasienanastesi_id'=>$pasienanastesi_id));
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
            'modDet' => $modDet,     
            'load' => $load
        ));
    }      
    
    /**
     * fungsi simpan induksi
     * @param type $model
     * @param type $post
     * @return type
     */
    public function saveInduksi($model, $post){        
                
        $model->attributes = $post;                 
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        $this->simpan_induksi = $this->simpan_induksi && $model->save();                                                     
        
        return $model;
    }              
    
    /**
     * fungsi simpan induksi det
     * @param type $modDet
     * @param type $model
     * @param type $post
     * @return type
     */
    public function saveInduksiDet($modDet,$model,$post){        
        
        foreach ($post as $det){
            if (!empty($det['praanestesi_induksidet_id'])){
                $modDet = ATPraanestesiInduksidetT::model()->findByPk($det['praanestesi_induksidet_id']);                
                $modDet->praanestesi_induksi_id = $model->praanestesi_induksi_id;
                $modDet->attributes = $det;
            }else{
                $modDet = new ATPraanestesiInduksidetT;
                $modDet->praanestesi_induksi_id = $model->praanestesi_induksi_id;
                $modDet->attributes = $det;
            }
        
            $this->simpan_induksi_det = $this->simpan_induksi_det && $modDet->save();            
        }
                                                            
        return $this->simpan_induksi_det;
    }     
}
