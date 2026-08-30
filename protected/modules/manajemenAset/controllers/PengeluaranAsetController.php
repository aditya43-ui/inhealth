<?php
/**
*   @author	Rusdiyanto <rusdiyanto@.com>
*   @website	<.com>
*/
class PengeluaranAsetController extends MyAuthController {
        public $layout = '//layouts/column1';
	public $defaultAction = 'index';
        public $path_view ='manajemenAset.views.pengeluaranAset.';
    
    public function actionIndex() {
        
        $model = new MAPengeluaranasetT();
        $model->penerimaaset='RSUD DR. SOETOMO';
        /* $model->nopengeluaranaset ='--Otomatis--'; format belum adas*/
        $model->tglpengeluaranaset = date('Y-m-d');
        $model->tglsuratperintah = date('Y-m-d');
	$model->tglpenyerahan = date('Y-m-d');
        $modDetail = new MAPengeluaranasetdetT();
        $format = new MyFormatter();
        if(isset($_POST['MAPengeluaranasetT']) && isset($_POST['MAPengeluaranasetdetT'])) {
		$transaction = Yii::app()->db->beginTransaction();
                $ok = true;           
                try {
                $model->attributes=$_POST['MAPengeluaranasetT'];
		$model->tglpengeluaranaset = $format->formatDateTimeForDb($model->tglpengeluaranaset);
                $model->tglsuratperintah = $format->formatDateTimeForDb($model->tglsuratperintah);
		$model->tglpenyerahan = $format->formatDateTimeForDb($model->tglpenyerahan);
               /* $model->nopengeluaranaset ='000001'; */
                $model->create_time = date('Y-m-d H:i:s');
		$model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
		$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    if ($model->validate()) {         
                        $ok = $ok && $model->save();                   
                            foreach ($_POST['MAPengeluaranasetdetT'] as $item) {
                            $detail = new MAPengeluaranasetdetT;
                            $detail->attributes = $item;
                            $detail->pengeluaranaset_id = $model->pengeluaranaset_id;
                            $detail->pengeluaranaset_keadaan = $item['pengeluaranaset_keadaan'];
                            $detail->ket_pengeluaranaset = $item['ket_pengeluaranaset'];
                            $ok = $ok && $detail->save();
                        }
                    }
                    if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash("success", "<strong>Berhasil!</strong> Data berhasil disimpan.");          
                    $this->redirect(array('index', 'id'=>$model->pengeluaranaset_id,'sukses'=>1));
                    
                    } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash("gagal", "Data gagal disimpan.");    
                    $this->refresh();
                    }
                } catch (Exception $ex) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash("error", "Error! Data gagal disimpan. ".MyExceptionMessage::getMessage($ex,true));
                    $this->refresh();
               }               
        }
        $this->render($this->path_view.'index',array(
           'model'=>$model,
           'modDetail'=>$modDetail,
           'format'=>$format
            
        ));
    }
    
     protected function validasiTabular($model, $data){
        $valid = true;
        foreach ($data as $i=>$row){
            $modDetails[$i] = new MAPengeluaranasetdetT;
            $modDetails[$i]->attributes = $row;
            $modDetails[$i]->pengeluaranaset_id = $model->pengeluaranaset_id;
            $valid = $modDetails[$i]->validate() && $valid;
        }
        return $modDetails;
    }
      public function actionGetBarang(){
        if (Yii::app()->request->isAjaxRequest){
            $invperalatan_id = $_POST['invperalatan_id'];
            $modBarang = InvperalatanT::model()->findByPk($invperalatan_id);
            $modDetail = new MAPengeluaranasetdetT();
            $modDetail->invperalatan_id = $invperalatan_id;            
            $tr = $this->renderPartial($this->path_view.'_detailPemakaianBarang', array('modBarang'=>$modBarang, 'modDetail'=>$modDetail), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    public function actionInformasi(){
        $model = new MAInfopengeluaranasetV();
        $model->tgl_awal = date('Y-m-d');
       $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['MAInfopengeluaranasetV'])){
            $model->attributes = $_GET['MAInfopengeluaranasetV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInfopengeluaranasetV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInfopengeluaranasetV']['tgl_akhir']);            
           // $model->instalasiasal_id = isset($_GET['MAInfopengeluaranasetV']['instalasiasal_id'])?$_GET['MAInfopengeluaranasetV']['instalasiasal_id']:null;
           // $model->instalasitujuan_id = isset($_GET['MAInfopengeluaranasetV']['instalasitujuan_id'])?$_GET['MAInfopengeluaranasetV']['instalasitujuan_id']:null;
        }
        
        $this->render($this->path_view.'informasi',array('model'=>$model));
    }
    public function actionLihatDetail($pengeluaranaset_id){
        $this->layout = "//layouts/iframe";
        
        $model = InfopengeluaranasetV::model()->find('pengeluaranaset_id='.$pengeluaranaset_id);
        $model->tglpengeluaranaset= MyFormatter::formatDateTimeForUser($model->tglpengeluaranaset);
        $model->tglsuratperintah=MyFormatter::formatDateTimeForUser($model->tglsuratperintah);
        $model->tglpenyerahan=MyFormatter::formatDateTimeForUser($model->tglpenyerahan);
        $cri=new CDbCriteria;
        $cri->addCondition('t.pengeluaranaset_id='.$pengeluaranaset_id);
        
        $detail = InfopengeluaranasetV::model()->findAll($cri);
        
        $this->render($this->path_view.'detail',array('model'=>$model,'detail'=>$detail));
    }
    
     public function actionAjaxGetPeralatan($term) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $cr = new CDbCriteria;
        $term = strtolower($term);
        $cr->addCondition("lower(invperalatan_namabrg) ilike '%".$term."%' or invperalatan_kode ilike '&".$term."&'");
        $cr->limit = 20;
        
        $peralatan = InvperalatanT::model()->findAll($cr);
        
        $res = array();
        
        foreach($peralatan as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->invperalatan_namabrg." - ".$item->invperalatan_kode;
            $sub['value'] = $item->invperalatan_id;
            
            $res[] = $sub;
        }  
        echo CJSON::encode($res);
        
    }
}

