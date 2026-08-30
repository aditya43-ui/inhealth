<?php

/**
 * digunakan sebagai informasi distribusi kantong darah
 * RSST-3712
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @author     Yusuf Putra Anugrah <yusufputra@.com>
 * @package    application.modules.bankDarah
 * @subpackage controllers
 * */
class InformasiPenerimaanDistribusiDarahController extends MyAuthController {

    /**
     * Menampilkan informasi penerimaan darah
     */
    public function actionIndex() {

        $model = new BDTerimadistribusidarahT;

        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");

        if (!empty($_GET['BDTerimadistribusidarahT'])) {
            $model->attributes = $_GET['BDTerimadistribusidarahT'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDTerimadistribusidarahT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDTerimadistribusidarahT']['tgl_akhir']);
        }
        $this->render('index', array(
            'model' => $model,
                )
        );
    }

    /**
     * Menampilkan detail penerimaan kantong darah.
     * 
     * @param integer $terimakantongdarah_id
     */
    public function actionLihatDetail($terimadistribusidarah_id) {
        $this->layout = "//layouts/iframe";

        $format = new MyFormatter();
        if ($terimadistribusidarah_id != ' ') {
            $modDistribusi = BDTerimadistribusidarahT::model()->findByPk($terimadistribusidarah_id);
            $modDistribusiDetail = DistribusidarahdetT::model()->findAllByAttributes(array('terimadistribusidarah_id' => $terimadistribusidarah_id));
             if($modDistribusi->petugasdistribusi_pelayanandarah){
                 $modPegawaiDistribusi = PegawaiM::model()->findByPk($modDistribusi->petugasdistribusi_pelayanandarah)->nama_pegawai;
                $modDistribusi->petugasdistribusi_pelayanandarah= $modPegawaiDistribusi;
             }
            $modDistribusi->tgl_terima=MyFormatter::formatDateTimeForUser($modDistribusi->tgl_terima);
            
        }


        $this->render('detail', array('model' => $modDistribusi, 'modDistribusiDetail' => $modDistribusiDetail));
    }

    /**
     *  Membatalkan penerimaan distribusi darah
     *  menghapus id terima distribusi yang relasi dengan DistribusidarahdetT  DistribusidarahT
     */
    public function actionBatalTerima() {
             
             $id = $_POST['id'];  
            $status= true;
            if(isset($_POST['id']))
            {
              try{  
                  $trans = Yii::app()->db->beginTransaction();
             $terimadistribusidarah_id= TerimadistribusidarahT::model()->findByPk($_POST['id'])->terimadistribusidarah_id;
            
             if(!empty($terimadistribusidarah_id)){
                
                $distrubusi = DistribusidarahdetT::model()->updateAll(array('terimadistribusidarah_id'=>null), 'terimadistribusidarah_id ='.$terimadistribusidarah_id);
                $distrubusidet = DistribusidarahT::model()->updateAll(array('terimadistribusidarah_id'=>null), 'terimadistribusidarah_id ='.$terimadistribusidarah_id);
                
                if($distrubusi > 0 || $distrubusidet > 0){
                  $delete = TerimadistribusidarahT::model()->findByPk($_POST['id'])->delete();
                
                }
                
                 if($delete)
                {   
                     
                      $trans->commit();
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            ));
                        exit;               
                    }
                 }else{
                     $trans->rollback();
                 }
                
             }
             
              }catch(Exception $e){
                         $trans->rollback();  
                 }  
              
            } else {
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            ));
                        exit;               
                    }
            }
    }

}
