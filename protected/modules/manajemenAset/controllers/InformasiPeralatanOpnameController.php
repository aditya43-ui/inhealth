
<?php

class InformasiPeralatanOpnameController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
    public $defaultAction = 'index';
    public $path_view = 'manajemenAset.views.informasiPeralatanOpname.';
    public $path_tips = 'sistemAdministrator.views.tips.';    
       

   /**
    * Halaman Index Informasi Peralatan Opname 
    */
    public function actionIndex(){

        $periode = PeriodeasetopnameK::model()->find("periodeasetopname_aktif = TRUE ORDER BY tanggal_akhir DESC");
        $lokasi_id = PenanggungjawabasetM::getDropIdByPegawai(Yii::app()->user->getState('pegawai_id'));
        
        $model = new MAInformasiperalatanopnameV;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->periodeasetopname_id =  !empty($periode)?$periode->periodeasetopname_id:null;    
        $model->ada_pj_aset = !empty($lokasi_id)?true:false;
        
        
        if (isset($_GET['MAInformasiperalatanopnameV'])) {
            $model->attributes = $_GET['MAInformasiperalatanopnameV'];  
            $model->tgl_awal = isset($_GET['MAInformasiperalatanopnameV']['tgl_awal'])?MyFormatter::formatDateTimeForDb($_GET['MAInformasiperalatanopnameV']['tgl_awal']):null;
            $model->tgl_akhir = isset($_GET['MAInformasiperalatanopnameV']['tgl_akhir'])?MyFormatter::formatDateTimeForDb($_GET['MAInformasiperalatanopnameV']['tgl_akhir']):null;
        }
        
        if (empty($model->lokasi_id)){
            $model->lokasi_id = $lokasi_id;
        }

        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'informasi-peralatan-opname-grid'){
                    $this->renderPartial($this->path_view.'grid/_tabel',['model'=>$model]);
                }else if ($ajax == 'barang-grid'){
                    $this->renderPartial($this->path_view.'grid/_grid_barang',[]);
                }else if ($ajax == 'lokasi-grid'){
                    $this->renderPartial($this->path_view.'grid/_grid_lokasi',['model'=>$model]);
                }else if ($ajax == 'ruangan-grid'){
                    $this->renderPartial($this->path_view.'grid/_grid_ruangan',[]);
                }
            }
        }else{        
            $this->render($this->path_view . 'index', array(
                'model' => $model,            
            ));
        }
    
    }
       
    /**
     * memverifikasi aset opanem, hanya pegawai selain PIC aset yang bisa mengakes
     */
    public function actionVerifikasi($asetopname_id){
        $this->layout = '//layouts/iframe';
        $modAset = MAAsetopnameT::model()->findByPk($asetopname_id);  
        
        
        $model = MAInvperalatanT::model()->findByPk($modAset->invperalatan_id);               
        $model->tanggal_perolehan = !empty($model->tanggal_perolehan)?MyFormatter::formatDateTimeForUser($model->tanggal_perolehan):null;
        $model->lokasi_id = !empty($modAset->lokasiopname_id)?$modAset->lokasiopname_id:null;
        $model->lokasiaset_namalokasi = !empty($modAset->lokasiopname->lokasiaset_namalokasi)?$modAset->lokasiopname->lokasiaset_namalokasi:null;
        $model->ruanganaset_nama = !empty($modAset->lokasiopname->ruangan->ruangan_nama)?$modAset->lokasiopname->ruangan->ruangan_nama:null;
        
        $pesan = '';  

        if (isset($_POST['MAAsetopnameT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                
                $proses = MAInvperalatanT::simpan_data($model,$_POST['MAInvperalatanT']);                
                $ok &= $proses['sukses'];   
                $model = $proses['model'];
                
                $modAset->tanggal_verifikasi = date('Y-m-d H:i:s');
                $modAset->pegawaiverifikasi_id = Yii::app()->user->getState('pegawai_id');
                $modAset->lokasi_id = $model->lokasi_id;
                $proses = MAAsetopnameT::simpan_data($modAset,$_POST['MAAsetopnameT']);
                $modAset = $proses['model'];
                $ok &= $proses['sukses'];                
                
                                                                    
                                       
                if ($ok) {                       
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('verifikasi', 'asetopname_id' => $modAset->asetopname_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan <br/>".$pesan);
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'verifikasi/index', array(
            'model' => $model,
            'modAset' => $modAset
        ));
    }
                
}
