<?php
/**
*   - Info Corrective Maintenance
*   @author	Andyka <andykaputra@.com> dan rusdiyanto <rusdiyanto@.com>
*/

class InfoCorrectiveMaintenanceController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'manajemenAset.views.infocorrectivemaintenance.';
        public $init = '';        

	public function actionIndex()
	{                        
            
            $model  = new MAInfokorektifmaintenV();
            $model->tgl_awal = date('Y-m-d');
            $model->tgl_akhir = date('Y-m-d');
            
            if ($this->module->id != 'manajemenAset'){
                $r = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
                $model->ruangpemohon_id = $r->ruangan_id;
                $model->ruangpemohon_nama = $r->ruangan_nama;
            }
            
            if (isset($_GET['MAInfokorektifmaintenV'])){
                $model->attributes = $_GET['MAInfokorektifmaintenV'];
                $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInfokorektifmaintenV']['tgl_awal']); 
                $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInfokorektifmaintenV']['tgl_akhir']);                            
                $model->teknisipemeliharaanaset_id = isset($_GET['MAInfokorektifmaintenV']['teknisipemeliharaanaset_id'])?$_GET['MAInfokorektifmaintenV']['teknisipemeliharaanaset_id']:null;                
            }
            
            $aset = PenanggungjawabasetM::model()->find(" pegawai_id = ".Yii::app()->user->getState('pegawai_id')." AND penanggungjawabaset_aktif = TRUE ");
            if (!empty($aset)){
                $model->is_pj_asset = true;
                $model->pegpemohon_id = Yii::app()->user->getState('pegawai_id');
            }
            
            if (Yii::app()->request->isAjaxRequest){                
                if (isset($_GET['ajax'])){
                    $ajax = $_GET['ajax'];
                    if ($ajax == 'corectivemaintenance-r-grid'){
                        echo $this->renderPartial($this->path_view.'grid/_grid_informasi',array('model' => $model), true);
                    }else if ($ajax == 'lokasi-grid'){
                        echo $this->renderPartial($this->path_view.'grid/_grid_lokasi_aset',['model'=>$model], true);
                    }else if ($ajax == 'ruangan-grid'){
                        echo $this->renderPartial($this->path_view.'grid/_grid_daftar_ruangan',[], true);
                    }else if ($ajax == 'teknisi-grid'){
                        echo $this->renderPartial($this->path_view.'grid/_peg_penerima',['model'=>$model], true);
                    }
                    exit;
                }
            }else{            
                $this->render($this->path_view.'index',array('model' => $model));
            }
        }
        
        public function actionSetStatus() {
             if(Yii::app()->request->isAjaxRequest) {
			$korektifmainten_id = isset($_POST['korektifmainten_id'])?$_POST['korektifmainten_id'] : null;	
			$modKorektif = KorektifmaintenT::model()->findByPk($korektifmainten_id);
                        $trans = Yii::app()->db->beginTransaction();
                        try{                                       
                            if ((ucwords($modKorektif->korektifmainten_status)) == ParamsConst::STATUSDOKUMENOPEN || $modKorektif->korektifmainten_status == ParamsConst::STATUSDOKUMENPENDING ){                                                                
                                if (ucwords($modKorektif->korektifmainten_status) == ParamsConst::STATUSDOKUMENOPEN ){                                    
                                    $modKorektif->korekfitmainten_progress = date('Y-m-d H:i:s');
                                }
                                
                                $modKorektif->korektifmainten_status = ParamsConst::STATUSDOKUMENINPROGRESS; 
                                $modKorektif->pegprogress_id = Yii::app()->user->getState('pegawai_id');
                            }else if ($modKorektif->korektifmainten_status == ParamsConst::STATUSDOKUMENFINISH ){
                                $modKorektif->korektifmainten_status = ParamsConst::STATUSDOKUMENCLOSE; 
                                $modKorektif->korektifmainten_close = date('Y-m-d H:i:s');
                            }          
                            
                            $modKorektif->update_time = date('Y-m-d H:i:s'); 
                            $modKorektif->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                            $modKorektif->update(); 

                            if ($modKorektif->korektifmainten_status == ParamsConst::STATUSDOKUMENINPROGRESS){
                                $model = new RiwayatpendingcmT;                                
                                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $model->create_time = $modKorektif->update_time;
                                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $model->korektifmainten_id = $modKorektif->korektifmainten_id;
                                $model->status = $modKorektif->korektifmainten_status;

                                $model->save();
                            }

                            $trans->commit();
                            $data['status'] = true;                            
                        }catch(Exception $e){
                            $trans->rollback();
                            $data['status'] = false;
                            $data['pesan'] = 'Update Gagal Di Lakukan !<br/>'.$e->getMessage();
                        }
			echo json_encode($data); 
                        Yii::app()->end();
		}
        }
        
        public function actionDetail($id){
                                
            $model= KorektifmaintenT::model()->findByAttributes(array('korektifmainten_id' => $id));        
            $model->korektifmainten_tgl = !empty($model->korektifmainten_tgl)?MyFormatter::formatDateTimeForUser($model->korektifmainten_tgl,'long'):'';
            
            $lok = LokasiasetM::model()->findByPk($model->lokasi_id);   
            
            
            $model->lokasiaset_namalokasi = trim(!empty($lok)?$lok->lokasiaset_namalokasi:null);            
            $model->area_nama = trim(!empty($lok->ruangan->area->area_nama)?'Area '.$lok->ruangan->area->area_nama:null);            
            $model->gedung_nama = trim(!empty($lok->ruangan->gedung->gedung_nama)?'Gedung '.$lok->ruangan->gedung->gedung_nama:null);            
            $model->ruangan_nama = trim(!empty($lok->ruangan->ruangan_nama)?$lok->ruangan->ruangan_nama:null);            
            $model->ruangan_lokasi = trim(!empty($lok->ruangan->ruangan_lokasi)?$lok->ruangan->ruangan_lokasi:null);                                    
            $model->kode_internal = trim(!empty($lok->kode_internal)?$lok->kode_internal:null);                                    
    
            
            $format = new MyFormatter();
            
            $modR = new MARiwayatstatuscmV;
            $modR->korektifmainten_id = $id;
            
            $modT = new MATeknisipemeliharaanasetT();

            $this->render($this->path_view.'_detailInfo', array(
                'model'=>$model,    
                'format'=>$format,
                'modR'=>$modR
            ));
    } 
    
    public function actionInsertPemeliharaanAset()
    {
        $model = new KorektifmaintenT; 
        $format = new MyFormatter();
        $pesan = '';
        $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
        $ok = true;
          if (isset($_POST['KorektifmaintenT'])) {
            if (!empty($_POST['KorektifmaintenT'])) { 
                $model= KorektifmaintenT::model()->findByPk($_POST['KorektifmaintenT']['korektifmainten_id']);
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->korektifmainten_status = ParamsConst::STATUSDOKUMENFINISH; 
                $model->korektifmainten_tglpawal = !empty($_POST['KorektifmaintenT']['korektifmainten_tglpawal'])?MyFormatter::formatDateTimeForDb($_POST['KorektifmaintenT']['korektifmainten_tglpawal']):null;
                $model->korektifmainten_tglpakhir = !empty($_POST['KorektifmaintenT']['korektifmainten_tglpakhir'])?MyFormatter::formatDateTimeForDb($_POST['KorektifmaintenT']['korektifmainten_tglpakhir']):null;
                $model->kondisi_barang = $_POST['KorektifmaintenT']['kondisi_barang'];                
                $model->pegfinish_id = Yii::app()->user->getState('pegawai_id');
                $model->iskorektifinternal = null;
                $model->pegteknisiint_id = null;
                $model->teknisiperalatan_id = null;
               
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->update()) {
                        $ok &= true;
                        foreach($_POST['MATeknisipemeliharaanasetT'] as $det){
                            $modTek = new MATeknisipemeliharaanasetT;
                            $cek = MATeknisipemeliharaanasetT::model()->findByPk($det['teknisipemeliharaanaset_id']);
                            if (!empty($cek)){
                                $modTek = $cek;
                            }
                            $modTek->attributes = $det;
                            $modTek->korektifmainten_id = $model->korektifmainten_id;
                            
                            if (empty($modTek->teknisipemeliharaanaset_id)){
                                $modTek->create_time = date('Y-m-d H:i:s');
                                $modTek->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modTek->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            }else{
                                $modTek->update_time = date('Y-m-d H:i:s');
                                $modTek->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                        
                            }
                            $ok &= $modTek->save();  

                            if (!$ok){
                                $pesan .= MyExceptionMessage::getErrorMessage($modTek);
                            }
                        }

                        if (isset($_POST['row_teknisi_hapus'])){
                            $cri = new CDbCriteria();
                            $cri->addInCondition("teknisipemeliharaanaset_id", $_POST['row_teknisi_hapus']);
                            $del = MATeknisipemeliharaanasetT::model()->deleteAll($cri);
                        }
                        
                        if ($ok){                            
                            $transaction->commit();
                            echo CJSON::encode(
                                array(
                                    'status'=>'proses_form',
                                    'div'=>"<div class='flash-success'>Pemeliharaan Aset Berhasil Di Simpan!.</div>",
                                )
                            );
                        }else{
                            $transaction->rollback();
                            echo CJSON::encode(
                                array(
                                    'status'=>'proses_form',
                                    'div'=>"<div class='flash-error'>Data gagal disimpan.".$pesan."</div>",
                                )
                            );
                        }
                    } else {
                        $transaction->rollback();
                        echo CJSON::encode(
                            array(
                                'status'=>'proses_form',
                                'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                            )
                        );
                    }
                    exit;
                } catch (Exception $exc) {
                    $transaction->rollback();
                    echo CJSON::encode(
                        array(
                            'status'=>'proses_form',
                            'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                        )
                    );   
                    exit;
                }
                
            } else {
                echo CJSON::encode(
                    array(
                            'status'=>'proses_form',
                            'div'=>"<div class='flash-success'>>Pemeliharaan Aset Berhasilr Di Lakukan!.</div>",
                        )
                );
                exit;
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $model = KorektifmaintenT::model()->findByPk($_GET['id']);
            $model->korektifmainten_tglpawal = MyFormatter::formatDateTimeForUser($model->korekfitmainten_progress);
            $model->korektifmainten_tglpakhir = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
            
            $modT = new MATeknisipemeliharaanasetT;
            
            echo CJSON::encode(
                array(
                'status'=>'create_form',
                'div'=>$this->renderPartial($this->path_view.'_formPemeliharaanAset', array('model'=>$model,'menu'=>$menu, 'modT'=>$modT), true))
            );
            exit;
        }
    } 
       

    public function actionSimpanPending(){
        if (Yii::app()->request->isAjaxRequest){
            
            $id = isset($_POST['id'])?$_POST['id']:null;
            $jenis = isset($_POST['jenis'])?$_POST['jenis']:null;
            
            $model = new RiwayatpendingcmT;
            $model->korektifmainten_id  = $id;
            $data['status'] = $jenis;
            if ($jenis == 'load'){                
                $model->create_time = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
                        
                $form = $this->renderPartial($this->path_view.'status/_pending',['model'=>$model], true);
                        
                $data['form'] = $form;
            }else{
                $ok = true;
                $trans = Yii::app()->db->beginTransaction();
                try{
                    parse_str($_POST['formdata'], $arr);

                    $model->attributes = $arr['RiwayatpendingcmT'];
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_time = MyFormatter::formatDateTimeForDb($model->create_time);
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->korektifmainten_id = $id;
                    $model->status = ParamsConst::STATUSDOKUMENPENDING;
                    
                    $ok &= $model->save();
                    
                    $modKorek = KorektifmaintenT::model()->findByPk($id);
                    $modKorek->korektifmainten_status = $model->status;
                    $modKorek->korektifmainten_pending = $model->create_time;
                    $ok &= $modKorek->update();
                    
                    if ($ok){                                                                       
                        $trans->commit();
                        $pesan = 'Data berhasil diubah';
                        $sukses = 1;
                    }else{
                        $trans->rollback();
                        $pesan = 'Data gagal simpan';
                        $sukses = 0;
                    }
                    
                }catch(Exception $e){
                    $trans->rollback();
                    $pesan = 'Data gagal simpan.<br/>'.$e->getMessage();
                    $sukses = 0;
                }
                
                $data['pesan'] = $pesan;
                $data['sukses'] = $sukses;
            }
            
            echo json_encode($data);
        }
    }
    
    public function actionSetTeknisi(){
        if (Yii::app()->request->isAjaxRequest){
                                    
            
            if (isset($_POST['formdata'])){
                $ok = true;
                $trans = Yii::app()->db->beginTransaction();
                $sukses = 0;
                $pesan = 'Data gagal disimpan!';
                try{
                    $modKor = MAKorektifmaintenT::model()->findByPk($_POST['id']);
                    parse_str($_POST['formdata'], $arr);
                    parse_str($_POST['setdata'], $arr_hapus);
                    $pesan = '';
                    foreach($arr['MATeknisipemeliharaanasetT'] as $det){
                        $model = new MATeknisipemeliharaanasetT;
                        $cek = MATeknisipemeliharaanasetT::model()->findByPk($det['teknisipemeliharaanaset_id']);
                        if (!empty($cek)){
                            $model = $cek;
                        }
                        $model->attributes = $det;
                        $model->korektifmainten_id = $modKor->korektifmainten_id;
                        $model->jenis_teknisi = 'Internal';
                        if (empty($model->teknisipemeliharaanaset_id)){
                            $model->create_time = date('Y-m-d H:i:s');
                            $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        }else{
                            $model->update_time = date('Y-m-d H:i:s');
                            $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                        
                        }
                        $ok &= $model->save();  
                        
                        if (!$ok){
                            $pesan .= MyExceptionMessage::getErrorMessage($model);
                        }
                    }
                    
                    if (isset($arr_hapus['teknisi_hapus'])){
                        $cri = new CDbCriteria();
                        $cri->addInCondition("teknisipemeliharaanaset_id", $arr_hapus['teknisi_hapus']);
                        $del = MATeknisipemeliharaanasetT::model()->deleteAll($cri);
                    }
                    
                    if ($ok){
                        $trans->commit();
                        $sukses = 1;
                        $pesan = 'Data berhasil disimpan!';
                    }else{                        
                        $trans->rollback();
                    }
                }catch(Exception $e){
                    $trans->rollback();
                    $pesan .= $e->getMessage();
                }
                
                echo json_encode([
                    'sukses'=>$sukses,
                    'pesan'=>$pesan
                ]);
            }else{
                $id = isset($_GET['id'])?$_GET['id']:null;
                $modKor = MAKorektifmaintenT::model()->findByPk($id);
                
                $model = new MATeknisipemeliharaanasetT;                
                $model->korektifmainten_id = $id;
                
                $modDet = MATeknisipemeliharaanasetT::model()->findAllByAttributes([
                    'korektifmainten_id' => $id,
                    'jenis_teknisi' => 'Internal'
                ]);
                
                $html = $this->renderPartial($this->path_view.'setTeknisi/index',[
                    'modKor'=>$modKor,
                    'model'=>$model,
                    'modDet'=>$modDet], true);
            
                echo json_encode($html);
            }
                        
            Yii::app()->end();
        }
    }
    
    public function actionPrintInfo() {
        
        $model = new MAInfokorektifmaintenV;          

        if (isset($_GET['MAInfokorektifmaintenV'])){
                $model->attributes = $_GET['MAInfokorektifmaintenV'];
                $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInfokorektifmaintenV']['tgl_awal']); 
                $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInfokorektifmaintenV']['tgl_akhir']);                            
                $model->teknisipemeliharaanaset_id = isset($_GET['MAInfokorektifmaintenV']['teknisipemeliharaanaset_id'])?$_GET['MAInfokorektifmaintenV']['teknisipemeliharaanaset_id']:null;                
            }
        
        $judulLaporan = 'Data Corrective Maintance';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 20, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
        }
    }
}
