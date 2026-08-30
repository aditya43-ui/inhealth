
<?php

class AsetOpnameController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
    public $defaultAction = 'index';
    public $path_view = 'manajemenAset.views.asetOpname.';
    public $path_tips = 'sistemAdministrator.views.tips.';    
   
    public function actionIndex($asetopname_id = null) {
        
        $periode = PeriodeasetopnameK::model()->find("periodeasetopname_aktif = TRUE ORDER BY tanggal_akhir DESC");
        
        $model = new MAAsetopnameT();   
        $model->asetopname_tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->pegawai_nama = !empty($peg)?$peg->namaLengkap:null;
        $model->pegawai_id = !empty($peg)?$peg->pegawai_id:null;
        $model->periodeasetopname_id =  !empty($periode)?$periode->periodeasetopname_id:null;    
        
        $modInv = new MAInvperalatanT;
        
        if (!empty($asetopname_id)){
            $model = MAAsetopnameT::model()->findByPk($asetopname_id);   
            $model->pegawai_nama = $model->pegawai->namaLengkap;
            $model->invperalatan_kode = $model->invperalatan->invperalatan_kode.' - '.$model->invperalatan->invperalatan_namabrg;
        }
                
        $pesan = '';  

        if (isset($_POST['MAAsetopnameT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                
                $modInv = MAInvperalatanT::model()->findByPk($_POST['MAInvperalatanT']['invperalatan_id']);
                $proses = MAInvperalatanT::simpan_data($modInv,$_POST['MAInvperalatanT']);                
                $ok &= $proses['sukses'];   
                $modInv = $proses['model'];
                
                $model->kondisi = $modInv->invperalatan_keadaan;
                $model->lokasiopname_id = $_POST['MAAsetopnameT']['lokasi_id'];
                $proses = MAAsetopnameT::simpan_data($model,$_POST['MAAsetopnameT']);
                $model = $proses['model'];
                $ok &= $proses['sukses'];                
                
                                                                    
                                       
                if ($ok) {                       
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('index', ));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan <br/>".$pesan);
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modInv' => $modInv,            
        ));
    }   
    
    
    public function actionLoadInv(){
        if (Yii::app()->request->isAjaxRequest){
            
            $inv_id = isset($_POST['inv_id'])?$_POST['inv_id']:null;            
            $lokasi_id = isset($_POST['lokasi_id'])?$_POST['lokasi_id']:null;            
            
            $pesan = '';
            
            $load = MAInvperalatanT::model()->findByPk($inv_id);
            
            $modAset = new MAAsetopnameT;
            $modAset->kondisi_awal = $load->invperalatan_keadaan;
            $modAset->lokasiawal_id = $load->lokasi_id;
            
            $lok = LokasiasetM::model()->findByPk($lokasi_id);    
            
            $st_lokasi = 'sama';
            if ($load->lokasi_id != $lokasi_id){
                $st_lokasi = 'beda';
                $pesan = 'Aset '.$load->invperalatan_kode.' - '.$load->invperalatan_namabrg.' dicatat tersimpan di '.$load->lokasi->lokasiaset_namalokasi.'. Apakah data lokasi diubah ke '.$lok->lokasiaset_namalokasi.' untuk aset tersebut?';
                
                $load->lokasi_id = $lokasi_id;
                $load->lokasiaset_namalokasi = $lok->lokasiaset_namalokasi;
                $load->ruangan_id = $lok->ruangan_id;
                $load->ruanganaset_nama = !empty($lok->ruangan->ruangan_nama)?$lok->ruangan->ruangan_nama:'';
            }else{
                $load->lokasiaset_namalokasi = $load->lokasi->lokasiaset_namalokasi;
                $load->ruanganaset_nama = !empty($load->ruangan->ruangan_nama)?$load->ruangan->ruangan_nama:'';
            }
            
            $data['html'] = $this->renderPartial($this->path_view.'form/_2_detail_aset',['model'=>$load,'modAset'=>$modAset],true);
            $data['st_lokasi'] = $st_lokasi;
            $data['pesan'] = $pesan;
            $data['sukses'] = 1;
            
            echo json_encode($data);
        }
    }   
}
