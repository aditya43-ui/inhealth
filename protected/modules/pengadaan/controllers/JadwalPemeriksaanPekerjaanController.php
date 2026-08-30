<?php
/**
 * 
 * controller transaksi persiapan pengadaan
 *
 * @package      application.modules.pengadaan
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class JadwalPemeriksaanPekerjaanController extends MyAuthController
{	        
    public $defaultAction = 'index';
    public $path_view = 'pengadaan.views.jadwalPemeriksaanPekerjaan.';
    public $init = '';        

    
    /**
     * action ini digunakan sebagai halaman utama transaksi keseimbangan cairan
     * parameter yang digunakan dan wajib ada yaitu pendaftaran_id, untuk parameter pasienadmisi_id bersifat optional
     * @param type $publikasi_id
     */
    public function actionIndex($pengadaanjadwalpemeriksaan_id=null)
    {                                     
        $model = new ADPengadaanjadwalpemeriksaanT();
        $model->pengadaanjadwalpemeriksaan_tanggal = date('d M Y H:i:s');       
        $model->pengadaanjadwalpemeriksaan_nomor = '-- Otomatis --';
        
        $modDet = new ADPengadaanjadwalpemeriksaandetT;        
        $loadDet = null;        
        
        $modRiwayat = new ADPengadaanjadwalpemeriksaanT;
        $modRiwayat->default = 'ada';
        
        if (!empty($pengadaanjadwalpemeriksaan_id)){
            $model = ADPengadaanjadwalpemeriksaanT::model()->findByPk($pengadaanjadwalpemeriksaan_id);
            $model->nosuratperjanjiankerja = $model->suratperjanjiankerja->nosuratperjanjiankerja;
            $model->nama_pekerjaan = $model->suratperjanjiankerja->namapekerjaan;
            
            $criDet = new CDbCriteria();
            $loadDet = ADPengadaanjadwalpemeriksaandetT::model()->findAllByAttributes(array('pengadaanjadwalpemeriksaan_id' => $model->pengadaanjadwalpemeriksaan_id));
            $modDet->pengadaanjadwalpemeriksaan_id = $pengadaanjadwalpemeriksaan_id;
                        
            $modRiwayat->default = '';
            $modRiwayat->suratperjanjiankerja_id = $model->suratperjanjiankerja_id;
        }
        
        
        if (isset($_GET['ADPengadaanjadwalpemeriksaanT'])){
            $modRiwayat->attributes = $_GET['ADPengadaanjadwalpemeriksaanT'];
            $modRiwayat->default = isset($_GET['ADPengadaanjadwalpemeriksaanT']['default'])?$_GET['ADPengadaanjadwalpemeriksaanT']['default']:null;            
        }
               
        if (isset($_POST['ADPengadaanjadwalpemeriksaanT'])){            
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['ADPengadaanjadwalpemeriksaanT'];
                $model->pengadaanjadwalpemeriksaan_nomor = MyGenerator::NoJadwalPekerjaanPemeriksaan();
                $model->pengadaanjadwalpemeriksaan_tanggal = MyFormatter::formatDateTimeForDb($model->pengadaanjadwalpemeriksaan_tanggal);
                $model->tanggal_pemeriksaan = MyFormatter::formatDateTimeForDb($model->tanggal_pemeriksaan);
                $model->pengadaanjadwalpemeriksaan_status = Params::STATUS_JADWAL_PEKERJAAN_PEMERIKSAAN_DIAJUKAN;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                
                $ok = $ok && $model->save();

                foreach($_POST['ADPengadaanjadwalpemeriksaandetT'] as $det){
                    $modDetail = new ADPengadaanjadwalpemeriksaandetT;
                    $modDetail->attributes = $det;
                    $modDetail->pengadaanjadwalpemeriksaan_id = $model->pengadaanjadwalpemeriksaan_id;
                    
                    $ok = $ok && $modDetail->save();  
                }
                
                if($ok){                                                                                               
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index','pengadaanjadwalpemeriksaan_id'=>$model->pengadaanjadwalpemeriksaan_id,'sukses'=>1));       
                }else{                             
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {                
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }       
                                  
        }
                
        
        $this->render($this->path_view.'index',array(
            'model' => $model,            
            'modDet' => $modDet,        
            'modRiwayat' => $modRiwayat,
            'loadDet' => $loadDet
        ));
    }        
    
    public function actionAutoCompleteSPK(){
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();            
            if (isset($_GET['term'])){
                $criteria->addCondition(" t.nosuratperjanjiankerja ilike '%".$_GET['term']."%' OR nomor_dokumen ilike '%".$_GET['term']."%' ");
            }
            
            $criteria->addCondition(" (t.suratperjanjiankerja_status NOT IN ('".Params::STATUS_SPK_TERVERIFIKASI."','".Params::STATUS_SPK_TERBAYAR."') OR t.suratperjanjiankerja_status is null  OR t.suratperjanjiankerja_status = '' ) ");
            $criteria->order = " t.nosuratperjanjiankerja ASC, t.nomor_dokumen ASC ";
            $criteria->limit = 5;
            $models = SuratperjanjiankerjaT::model()->findAll($criteria);
            $returnVal = array();   
           
            foreach($models as $i=>$model)
            {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nosuratperjanjiankerja.' - '.$model->nomor_dokumen;
                    $returnVal[$i]['value'] = $model->suratperjanjiankerja_id;                                        
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}