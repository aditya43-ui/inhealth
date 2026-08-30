<?php
/**
 * digunakan untuk mengelola menu observasi donor darah
 * RSST-1498
 * @package application.modules.rekamMedis
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class InaktifBerkasRekamMedisController extends MyAuthController
{	        
    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.inaktifBerkasRekamMedis.';
    public $init = '';        
       
    /**
     * fungsi simpan observasi donor darah
     * @param type $daftardonasi_id
     * @param type $observasipendonor_id
     */
    public function actionIndex($inaktifrekammedis_id=null)
    {               
        $model = new RKInaktifrekammedisT;        
        $model->tglinaktifrekammedis = date('d M Y H:i:s');
        $model->noretensiinaktif = '-- Otomatis --';
        $peg = RKPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->pegawai_pelaksana_id = !empty($peg)?$peg->pegawai_id:null;
        $model->pegawai_pelaksana_nama = !empty($peg)?$peg->namaLengkap:null;
        
        $modDet = new RKInaktifrekammedisdetT;
        $modDet->inaktifrekammedis_id = $inaktifrekammedis_id;
        
        $modDok = new RKRetensirekammedikV;
        $modDok->inaktifrekammedis_id = $inaktifrekammedis_id;
        $modDok->tgl_awal = date('d M Y');
        $modDok->tgl_akhir = date('d M Y');
        
        if (isset($_GET['RKRetensirekammedikV'])){
            $modDok->attributes = $_GET['RKRetensirekammedikV'];
            $modDok->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['RKRetensirekammedikV']['tgl_awal']);
            $modDok->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['RKRetensirekammedikV']['tgl_akhir']);
            $modDok->no_rekam_medik_akhir = isset($_GET['RKRetensirekammedikV']['no_rekam_medik_akhir'])?$_GET['RKRetensirekammedikV']['no_rekam_medik_akhir']:null;
        }
                        
        $cekInaktif = RKInaktifrekammedisT::model()->findByPk($inaktifrekammedis_id);
        if (!empty($cekInaktif)){
            $model = $cekInaktif;            
            $model->tglinaktifrekammedis = MyFormatter::formatDateTimeForDb($model->tglinaktifrekammedis);
            $model->pegawai_pelaksana_nama = !empty($model->pegawai_pelaksana_id)?$model->pegpelaksana->namaLengkap:null;
            $model->pegawai_penanggungjawab_nama = !empty($model->pegawai_penanggungjawab_id)?$model->pegtaggungjawab->namaLengkap:null;                                                       
        }               
                
        
        if (isset($_POST['RKInaktifrekammedisT'])){

            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{                                
                $model->attributes = $_POST['RKInaktifrekammedisT'];    
                $model->noretensiinaktif = MyGenerator::noInaktifDokRM();
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');                
                $model->tglinaktifrekammedis = MyFormatter::formatDateTimeForDb($model->tglinaktifrekammedis);
                
                if (!empty($model->inaktifrekammedis_id)){
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                    
                }else{
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }
                                                          
                $ok = $ok && $model->save();                                                                                                              

                $idPasien = array();
                $idDok = array();
                
                foreach($_POST['RKInaktifrekammedisdetT'] as $det){
                    if ($det['pilih'] == 1){
                        if (!empty($det['inaktifrekammedisdet_id'])){
                            $modDet = RKInaktifrekammedisdetT::model()->FindByPk($det['inaktifrekammedisdet_id']);;
                            $modDet->attributes = $det;
                        }else{
                            $modDet = new RKInaktifrekammedisdetT;
                            $modDet->inaktifrekammedis_id = $model->inaktifrekammedis_id;
                            $modDet->attributes = $det;
                        }

                        $idPasien[] = $det['pasien_id'];
                        $idDok[] = $det['dokrekammedis_id'];

                        $ok = $ok && $modDet->save();
                    }
                }
                
                $criPas = new CDbCriteria();
                $criPas->addInCondition(" pasien_id ", $idPasien);
                $ok = $ok && RKPasienM::model()->updateAll(array('statusrekammedis' => Params::STATUSREKAMMEDIS_NON_AKTIF),$criPas);
                
                $criDok = new CDbCriteria();
                $criDok->addInCondition(" dokrekammedis_id ", $idDok);
                $ok = $ok && RKDokrekammedisM::model()->updateAll(array('statusrekammedis' => Params::STATUSREKAMMEDIS_NON_AKTIF,'tgl_in_aktif'=>date('Y-m-d')),$criDok);
                
                if($ok){                                                                                    
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index','inaktifrekammedis_id'=>$model->inaktifrekammedis_id,'sukses'=>1));       
                }else{                        
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model).CHtml::errorSummary($modDet));
                }
            } catch (Exception $exc) {                
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }
        
                 
        $this->render($this->path_view.'index',array(
            'model' => $model,            
            'modDet'=>$modDet,            
            'modDok'=>$modDok
        ));
    }           
}
