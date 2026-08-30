<?php

/**
 * Form Tabulasi Preventive Maintenance.
 * 
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @version    2.0.0
 * @package    application.modules.manajemenAset
 * @subpackage controllers
 */

class PrevmaintenTController extends Controller
{
    public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'manajemenAset.views.prevmaintenT.';
    
    
    /**
     * Form transaksi Preventive Maintenance
     * Digunakan untuk menginput jadwal maintenance berdasakan frekuensi peralatan
     * 
     * @param integer $id data invperalatan_t.invperalatan_id
     */
	public function actionIndex($id)
	{
        $inv = InvperalatanT::model()->findByPk($id);
        $model = new PrevmaintenT;
        
        $model->invperalatan_id = $id;
        $model->tglprevmainten = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
        
        $enem = PerhitunganemM::model()->findByAttributes([
            'barang_id' => $inv->barang_id
        ],['order'=>"create_time DESC"]);
        
        if (!empty($enem)){
            $nilaiem = NilaiemasetM::model()->findByAttributes([
               'frekuensi_jenis'=>$enem->frekuensi_inspeksi
            ]);
            
            if (!empty($nilaiem)){
                $model->frekuansi_prev = $nilaiem->frekuensi_inspeksi;
                $model->frekuensi_jml_prev = $nilaiem->frekuensi_jml;
                $model->frekuensi_sat_prev =  $nilaiem->frekuensi_satuan;
            }
        }
        
        $cri = new CDbCriteria();        
        $ipm_cek = PreventifmaintenM::model()->findAllByAttributes([
            'barang_id' => $inv->barang_id,
            'ipmchecklist_list' => true
        ]);
        
        $list_ipm = [];
        foreach($ipm_cek as $det){
            $init = $det->ipmchecklist->ipm_jenis;
            $list_ipm[$init][$det->ipmchecklist_id] = $det->ipmchecklist->ipm_listnama;
        }                
        
        if (isset($_POST['PrevmaintenT']) && isset($_POST['PrevmaintenT']['detail'])) {
            
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                
                $base_date = new DateTime(MyFormatter::formatDateTimeForDB($_POST['PrevmaintenT']['tglprevmainten']));
                $interval_prov = trim(strtolower($_POST['PrevmaintenT']['frekuansi_prev']));
                $interval_satuan = trim(strtolower($_POST['PrevmaintenT']['frekuensi_sat_prev']));
                $interval = $_POST['PrevmaintenT']['frekuensi_jml_prev'];
                $thn_ekonomis = new DateTime(date('Y-m-d', strtotime("+".$inv->invperalatan_umurekonomis." year")));
                
                $format = null;
                $timeInterval = null;
                
                
                if ($interval_prov == 'setiap') {
                    if ($interval_satuan == 'hari') {
                        $format = 'P'.$interval.'D';
                    } else if ($interval_satuan == 'bulan') {
                        $format = 'P'.$interval.'M';
                    } else if ($interval_satuan == 'tahun') {
                        $format = 'P'.$interval.'Y';
                    } else if ($interval_satuan == 'minggu') {
                        $format = 'P'.($interval * 7).'D';
                    }
                }
                
                $ceklis_list = array();
                if (isset($_POST['ceklis'])) {
                    $cnt = 1;
                    foreach ($_POST['ceklis'] as $item) {
                        $ceklis = new IpmchecklistM;
                        $ceklis->ipm_list_nourut = $cnt++;
                        $ceklis->ipm_jenis = 'NON IPM CHECKLIST';
                        $ceklis->ipm_listnama = $item;
                        $ceklis->ipm_ket = "";
                        $ceklis->ipm_aktif = true;
                        $ceklis->create_time = date('Y-m-d H:i:s');
                        $ceklis->create_loginpemakai_id = Yii::app()->user->id;
                        $ceklis->create_ruangan = Yii::app()->user->getState('ruangan_id');

                        if ($ceklis->validate()) {
                            $ok = $ok && $ceklis->save();

                            $ceklis_list[] = $ceklis;
                        } else {
                            $ok = false;
                        }
                    }
                }
                
                
                if (!empty($format)) {
                    $timeInterval = new DateInterval($format);
                    while ($base_date < $thn_ekonomis) {
                        $ok = $ok && $this->simpanPrevMaintenTanggal($_POST, $base_date, $ceklis_list, $id);
                        $base_date->add($timeInterval);
                    }
                } else {
                    $ok = $ok && $this->simpanPrevMaintenTanggal($_POST, $base_date, $ceklis_list, $id);
                }
                
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('index', 'id'=>$id, 'sukses'=>1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ! ");
                    $this->refresh();
                }
                
            } catch (Exception $exc) {
                Yii::app()->user->setFlash('error',"Data gagal disimpan ! ".MyExceptionMessage::getMessage($exc,true));
            }
        }
        
		$this->render($this->path_view.'index', array(
            'model'=>$model,
            'inv'=>$inv,
                    'list_ipm'=>$list_ipm
        ));
	}
    
    /**
     * 
     * Menyimpan data Preventive Maintenance beserta Detail Ceklis-nya.
     * 
     * @param mixed $post Data Post
     * @param DateTime $tgl Tanggal Transaksi Preventive Paintenance
     * @param array $ceklis_list ceklis tambahan dari form
     * @param integer $id nilai invperalatan_t.invperalatan_id
     * @return boolean Hasil penyimpanan sukses atau tidak.
     */
    public function simpanPrevMaintenTanggal($post, $tgl, $ceklis_list, $id) {
        
        $ok = true;
        
        $model = new PrevmaintenT;
        $model->attributes = $post['PrevmaintenT'];
        $model->tglprevmainten = $tgl->format('Y-m-d');
        $model->invperalatan_id = $id;
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
            $ok = $ok && $model->save();

            foreach ($post['PrevmaintenT']['detail'] as $idx => $item) {
                $det = new PrevmaintendetT;
                $det->prevmainten_id = $model->prevmainten_id;
                $det->ipmchecklist_id = $idx;
                $det->ipmchecklist_status = $item['ipmchecklist_id'] == 1 ? true : false;

                $ok = $ok && $det->save();

                //var_dump($det->attributes, $item);
            }

            foreach ($ceklis_list as $item) {
                $det = new PrevmaintendetT;
                $det->prevmainten_id = $model->prevmainten_id;
                $det->ipmchecklist_id = $item->ipmchecklist_id;
                $det->ipmchecklist_status = true;

                $ok = $ok && $det->save();
            }

        } else {
            $ok = false;
        }
        
        return $ok;
    }

    
	public function actionPrint()
	{
		$this->render($this->path_view.'print');
	}

    /**
     * Menambah field ceklis tambahan
     */
    public function actionSetFormCeklis(){
        if (Yii::app()->request->isAjaxRequest) {
            $ceklis_id = isset($_POST['ceklis_id']) ? $_POST['ceklis_id']: '';
            $ceklis = isset($_POST['ceklis']) ? $_POST['ceklis']: '';
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $model = new PreventifmaintenM;

            $model->ipmchecklist_id = $ceklis_id;
            $model->ipmchecklist_list = $ceklis;

            
            

            $form .= $this->renderPartial($this->path_view.'_rowCeklis', array(
                'model' => $model
            ), true);
            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end(); 
        }
    }
    
    /**
     * 
     * Menghapus data preventive maintenance beserta ceklis-nya.
     * 
     * @param integer $id ID pervmainten_t
     * @throws CHttpException Jika gagal dihapus.
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            PrevmaintendetT::model()->deleteAllByAttributes(array(
                'prevmainten_id'=>$id,
            ));
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus.');
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    /**
    * - Form Skip
    * @author  Andyka <andykaputra@.com>
    */
    public function actionSkip($prevmainten_id) {

        $model = PrevmaintenT::model()->findByAttributes(array('prevmainten_id'=>$prevmainten_id));

        if (isset($_POST['PrevmaintenT'])) {
            $model->attributes = $_POST['PrevmaintenT'];
            $model->prevmainten_skip=1;
            $model->prevmainten_pegawaiskip=$_POST['PrevmaintenT']['prevmainten_pegawaiskip'];
            $model->prevmainten_tglskip=MyFormatter::formatDateTimeForDb($_POST['PrevmaintenT']['prevmainten_tglskip']); 
            $model->prevmainten_alasanskip=$_POST['PrevmaintenT']['prevmainten_alasanskip'];
            if ($model->save()) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    //$this->redirect(array('admin','id'=>$model->invasetlain_id));
                    $this->redirect(array('skip','prevmainten_id'=>$prevmainten_id));
            }
        }

        $this->render($this->path_view.'skip', array(
                'model' => $model
        ));
	}
    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model= PrevmaintenT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    
}