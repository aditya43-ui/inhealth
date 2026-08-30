<?php
/**
 * Digunakan untuk mengakses Transaksi Pemusnahan Rekam Medis
 * 
 * @author     Andyka <andykaputra@.com>
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @website	   <.com>
 * @package    application.modules.rekamMedis
 * @subpackage controllers
 * @ctegory    controller
 */
class PemusnahanrekammedisTController extends MyAuthController
{

    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.pemusnahanRekamMedisT.';

    /**
     * Form untuk memilih data Dok RM Inaktif yang akan diusnahkan.
     * Jika disimpan, maka status pemusnahan pada detail inaktif RM akan ikut berubah.
     */
    public function actionIndex()
    {
        $format = new MyFormatter();

        $modDetails = array();
        $model = new RKPemusnahanrekammedisT;
        $model->tglpemusnahanrekammedis = date('Y-m-d H:i:s');
        $model->nopemusnahanrekammedis = '-- Otomatis --';
        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
        
        $modPasien = new RKPasienM();
        $modPasien->tglkunjunganterakhir = date('Y-m-d');
        $modPasien->tglkunjungan_akhir = date('Y-m-d');

        if(isset($_GET['RKPasienM'])){
            $modPasien->attributes = $_GET['RKPasienM'];			
            $modPasien->tglkunjunganterakhir = $format->formatDateTimeForDb($_GET['RKPasienM']['tglkunjunganterakhir']);
            $modPasien->tglkunjungan_akhir = $format->formatDateTimeForDb($_GET['RKPasienM']['tglkunjungan_akhir']);
            $modPasien->no_rekam_medik = $_GET['RKPasienM']['no_rekam_medik'];
            $modPasien->no_rekam_medik_akhir = $_GET['RKPasienM']['no_rekam_medik_akhir'];
            if (isset($_GET['RKPasienM']['instalasiterakhir_id'])) {
                $modPasien->instalasiterakhir_id = $_GET['RKPasienM']['instalasiterakhir_id'];
            }
            if (isset($_GET['RKPasienM']['ruanganakhir_id'])) {
                $modPasien->ruanganakhir_id = $_GET['RKPasienM']['ruanganakhir_id'];
            }
            $modPasien->nama_pasien = $_GET['RKPasienM']['nama_pasien'];
        }

        if(isset($_POST['RKPemusnahanrekammedisT']))
        {   
            $transaction = Yii::app()->db->beginTransaction();
            
            $ok = true;
            try {
                $model->attributes = $_POST['RKPemusnahanrekammedisT'];
                $model->tglpemusnahanrekammedis = isset($_POST['RKPemusnahanrekammedisT']['tglpemusnahanrekammedis']) ? $format->formatDateTimeForDb($_POST['RKPemusnahanrekammedisT']['tglpemusnahanrekammedis']) : date('Y-m-d H:i:s');
                $model->nopemusnahanrekammedis = MyGenerator::noPemusnahanDokRM();
                
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                
                
                if ($model->validate()) {
                    $ok = $ok && $model->save();
                } else {
                    $ok = false;
                }

                if(count($_POST['Dokumen']) > 0){
                    foreach($_POST['Dokumen'] as $i=>$details){
                        if(!isset($details['cekList'])) {
                            continue;
                        }
                        if($details['cekList'] != 1) {
                            continue;
                            //$modDetails[$i] = $this->simpanPemusnahan($model, $_POST['RKPemusnahanrekammedisT'], $details);
                        }
                        
                        
                        $detail = new PemusnahanrekammedisdetT;
                        $detail->attributes = $details;
                        $detail->pemusnahanrekammedis_id = $model->pemusnahanrekammedis_id;
                        $detail->masafungsirm = $details['masa_fungsi'];
                        
                        if ($detail->validate())
                        {
                            $ok = $ok && $detail->save();
                            InaktifrekammedisdetT::model()->updateByPk($detail->inaktifrekammedisdet_id, array(
                                'is_pemusnahan'=>true,
                            ));
                            $modDetails[] = $detail;
                        } else {
                            $ok = false;
                        }
                        
                    }
                }
                
                if($ok){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success',"Data Retensi Dokumen Rekam Medis berhasil disimpan !");
                    $this->redirect(array('index'));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Retensi Dokumen Rekam Medis gagal disimpan !");
                    $this->redirect(array('index'));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
                                . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
                                . "</a>";
                Yii::app()->user->setFlash('error',"Data Retensi Dokumen Rekam Medis gagal disimpan ! ".$btn_ulang." ".MyExceptionMessage::getMessage($exc,true));
                $this->redirect(array('index'));
            }
        }

        if (empty($models)){
                $models = null;
        }

        $this->render($this->path_view.'index',array(
                'model'=>$model,
                'models'=>$models,
                'modPasien'=>$modPasien,
        ));
    }
    
    /**
     * Autocompelte Pegawai Retensi
     * @param type $term
     */
    public function actionAutocompletePegawaiRetensi($term = "") {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $cr = new CDbCriteria();
        $cr->compare('instalasi_id', Yii::app()->user->getState('instalasi_id'));
        $cr->addCondition('pegawai_aktif = true');
        $cr->order = ('nama_pegawai asc');
        $cr->compare('lower(nama_pegawai)', strtolower($term), true); 
        
        $mod = PegawairuanganV::model()->findAll($cr);
        $res = array();
        
        foreach($mod as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->nama_pegawai." - ".$item->nomorindukpegawai;
            $sub['value'] = $item->pegawai_id;
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
        
    }
    
    /**
     * Autocomplete pegawai Mengetahui
     * @param type $term
     */
    public function actionAutocompletePegawaiMengetahui($term = "") {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $cr = new CDbCriteria();
        $cr->addCondition('pegawai_aktif = true');
        $cr->order = ('nama_pegawai asc');
        $cr->compare('lower(nama_pegawai)', strtolower($term), true); 
        
        $mod = PegawaiM::model()->findAll($cr);
        $res = array();
        
        foreach($mod as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->nama_pegawai." - ".$item->nomorindukpegawai;
            $sub['value'] = $item->pegawai_id;
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
        
    }
}