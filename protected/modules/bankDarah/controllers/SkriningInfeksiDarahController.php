<?php
/**
 * Controller untuk skrining IMLTD
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id> 
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author  Aida Rahmawati <aidarahmawati@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
*/
class SkriningInfeksiDarahController extends Controller
{
    // public $layout = '//layouts/iframe';
    public $path_view = "bankDarah.views.skriningInfeksiDarah.";
    public $prev_url = null;
    public $simpankantong = false;
    public $simpanskrining = false;
    
    /**
     * Form Transaksi Skrining IMLTD Darah
     * 
     * @param type $nomorbarcode_sample
     * @param type $kantongdarah_id
     * @param type $referal
     */
    public function actionIndex($nomorbarcode_sample, $kantongdarah_id = null, $referal = null){
        //$kantong = KantongdarahT::model()->findByAttributes(array('nomorbarcode_sample_imltd'=>$nomorbarcode_sample));
        $kantong = KantongdarahT::model()->findByAttributes(array('nomorbarcode_sample'=>$nomorbarcode_sample));
        $criTerima = new CDbCriteria();        
        $criTerima->select = " t.*,  t.terimakantongdet_id ";
        $criTerima->join =  "LEFT JOIN kantongdarah_t kantong ON kantong.kantongdarah_id = t.kantongdarah_id ";
        //$criTerima->addCondition(" kantong.nomorbarcode_sample_imltd =  '".$nomorbarcode_sample."' ");
        $criTerima->addCondition(" kantong.nomorbarcode_sample =  '".$nomorbarcode_sample."' ");
        
        $modTerima = TerimakantongdetT::model()->findAll($criTerima);        
        
        
        if (empty($_GET['pengujianke'])) {
            $model = new SkriningimltdT();
            $model->tglskrining = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
            $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $model->petugasskrining_id = $pegawai->pegawai_id;
            $model->petugasskrining_nama = $pegawai->namaLengkap;
        } else {
            $model = SkriningimltdT::model()->findByAttributes(array('nomorbarcode_sample' => $_GET['nomorbarcode_sample'], 'pengujian_ke' => $_GET['pengujianke'])); 
            $model->tglskrining = MyFormatter::formatDateTimeForUser($model->tglskrining);
            $model->petugasskrining_nama = $model->petugasskrining->namaLengkap;            
        }
        
        if (empty($referal)) {
            $this->prev_url = Yii::app()->request->urlReferrer;
        } else {
            $this->prev_url = $referal;
        }
        
        $model->hbsag = (empty($model->hbsag) || !$model->hbsag) ? 0 : 1;
        $model->antihiv = (empty($model->antihiv) || !$model->antihiv) ? 0 : 1;
        $model->antihvc = (empty($model->antihvc) || !$model->antihvc) ? 0 : 1;
        $model->sifilis = (empty($model->sifilis) || !$model->sifilis) ? 0 : 1;             
        
        
        if (isset($_POST['SkriningimltdT'])) {

            if (isset($_POST['redirect_url'])) {
                $this->prev_url = $_POST['redirect_url'];
            }
            
            $trans = Yii::app()->db->beginTransaction();
            $pengujian_ke = 1;
            try {
                if(count($modTerima) > 0){
                    foreach($modTerima as $terima){
                        if (!empty($_GET['skriningimltd_id']) && !empty($_GET['pengujianke'])) {
                            $model = SkriningimltdT::model()->findAllByAttributes(array('nomorbarcode_sample' => $_GET['nomorbarcode_sample'], 'pengujian_ke' => $_GET['pengujianke']));
                            foreach($model as $mod){
                                $mod->attributes = $_POST['SkriningimltdT']; 
                                $mod->tglskrining = MyFormatter::formatDateTimeForDb($mod->tglskrining);
                                $mod->tgl_kadaluarsa = !empty($mod->tgl_kadaluarsa) ? MyFormatter::formatDateTimeForDb($mod->tgl_kadaluarsa) : null;
                                $mod->tgl_kadaluarsa_antihiv = !empty($_POST['SkriningimltdT']['tgl_kadaluarsa_antihiv']) ? MyFormatter::formatDateTimeForDb($_POST['SkriningimltdT']['tgl_kadaluarsa_antihiv']) : null;
                                $mod->tgl_kadaluarsa_antihcv = !empty($_POST['SkriningimltdT']['tgl_kadaluarsa_antihcv']) ? MyFormatter::formatDateTimeForDb($_POST['SkriningimltdT']['tgl_kadaluarsa_antihcv']) : null;
                                $mod->tgl_kadaluarsa_sifilis = !empty($_POST['SkriningimltdT']['tgl_kadaluarsa_sifilis']) ? MyFormatter::formatDateTimeForDb($_POST['SkriningimltdT']['tgl_kadaluarsa_sifilis']) : null;
                                $mod->nomorbarcode_sample = !empty($_POST['barcode_kantong']) ? $_POST['barcode_kantong'] : $mod->nomorbarcode_sample; 
                                $mod->update_time = date('Y-m-d H:i:s');
                                $mod->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id'); 
                                $this->simpanskrining = $mod->save() && true;
                            }
                            $this->simpankantong = true;                             
                        } else {
                            $model = new SkriningimltdT();
                            $model->create_time = date('Y-m-d H:i:s');
                            $model->create_loginpemakai_id = Yii::app()->user->id;
                            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            
                            /** cari no_sample **/
                            $modKantong = KantongdarahT::model()->findByPk($terima->kantongdarah_id);
                            $modCarinomorbarcode = SkriningimltdT::model()->findByAttributes(array('kantongdarah_id'=>$modKantong->kantongdarah_id));                        

                            if(empty($modCarinomorbarcode)) {
                                $model->pengujian_ke = 1;
                            }else if($modCarinomorbarcode){
                                $model->pengujian_ke = 2;
                            }             
                            $pengujian_ke = $model->pengujian_ke;
                            /** end **/
                            $model->nomorbarcode_sample = !empty($modKantong->nomorbarcode_sample) ? $modKantong->nomorbarcode_sample : $modKantong->nomorbarcode_sample;
                            $model->hbsag = !empty($model->hbsag) && $model->hbsag != 0;
                            $model->antihiv = !empty($model->antihiv) && $model->antihiv != 0;
                            $model->antihvc = !empty($model->antihvc) && $model->antihvc != 0;
                            $model->sifilis = !empty($model->sifilis) && $model->sifilis != 0;
                            $model->attributes = $_POST['SkriningimltdT'];
                            $model->kantongdarah_id = $terima->kantongdarah_id;
                            $model->tglskrining = MyFormatter::formatDateTimeForDb($model->tglskrining);
                            $model->shift_id = Yii::app()->user->getState('shift_id');
                            $model->asalruangan_id = $kantong->create_ruangan;
                            $model->tgl_kadaluarsa = !empty($model->tgl_kadaluarsa) ? MyFormatter::formatDateTimeForDb($model->tgl_kadaluarsa) : null;
                            $model->tgl_kadaluarsa_antihiv = !empty($_POST['SkriningimltdT']['tgl_kadaluarsa_antihiv']) ? MyFormatter::formatDateTimeForDb($_POST['SkriningimltdT']['tgl_kadaluarsa_antihiv']) : null;
                            $model->tgl_kadaluarsa_antihcv = !empty($_POST['SkriningimltdT']['tgl_kadaluarsa_antihcv']) ? MyFormatter::formatDateTimeForDb($_POST['SkriningimltdT']['tgl_kadaluarsa_antihcv']) : null;
                            $model->tgl_kadaluarsa_sifilis = !empty($_POST['SkriningimltdT']['tgl_kadaluarsa_sifilis']) ? MyFormatter::formatDateTimeForDb($_POST['SkriningimltdT']['tgl_kadaluarsa_sifilis']) : null;

                            $model->terimakantongdet_id = $terima->terimakantongdet_id;
                            $this->simpanskrining = $model->save() && true;
                            if($this->simpanskrining){
                                $kantongdarah = KantongdarahT::model()->updateByPk($terima->kantongdarah_id,array('skriningimltd_id'=>$model->skriningimltd_id));
                                if($kantongdarah){
                                    $this->simpankantong = true;
                                }
                            }
                        }
                        
                    }
                }
                
                if ($this->simpanskrining == true && $this->simpankantong = true) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
                    if (empty($_GET['pengujian_ke'])) {
                        $this->redirect(array('index', 'nomorbarcode_sample' => $nomorbarcode_sample, 'pengujianke' => $pengujian_ke, 'link' => 1, 'sukses' => 1));
                    } else {
                        $this->redirect(array('index', 'nomorbarcode_sample' => $nomorbarcode_sample, 'pengujianke' => $_GET['pengujian_ke'], 'link' => 1, 'sukses' => 1));
                    }
                } else {                    
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan !");
                }
            } catch(Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        
		$this->render($this->path_view.'index', array(
            'kantong'=>$kantong,
            'modTerima'=>$modTerima,
            'model'=>$model,
        ));
	}

	public function actionPrint()
	{
		$this->render('print');
	}
    
    /**
     * mengenerate list pegawai sesuai yang diketikkan
     * @param type $term
     */
    public function actionAutocompleteGetPetugas($term) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        $cr = new CDbCriteria;
        $cr->compare('lower(nama_pegawai)', strtolower($term), true);
        $cr->addCondition('pegawai_aktif = true');
        $cr->addCondition('ruangan_id ='.Yii::app()->user->getState('ruangan_id'));
        $cr->order = 'nama_pegawai';
        $cr->limit = 15;
        
        $model = PegawairuanganV::model()->findAll($cr);
        $res = array();
        
        
        foreach ($model as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->nama_pegawai;
            $sub['value'] = $item->pegawai_id;
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
        
    }
    
    /**
     * Verifikasi 2
     */
    public function actionPersetujuanVerifikator1() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $ok = 1;
        $simpan = true;
        $msg = "Verifikasi Berhasil Dilakukan. ";
        $ex = explode(",", $_POST['nomorbarcode_sample']);
        $nomorbarcode_sample = $ex[0];
        $pengujian_ke = $ex[1];
        $modSkrining= SkriningimltdT::model()->findAllByAttributes(array('nomorbarcode_sample' => $nomorbarcode_sample, 'pengujian_ke' => $pengujian_ke));
        foreach($modSkrining as $value) {
            $value->tgl_verifikasi1 = date('d M Y H:i:s');
            $simpan = $simpan && $value->save(); 
        }

        if ($simpan) {
            $ok = 1;
            $msg = "Verifikasi untuk <b>".$nomorbarcode_sample."pengujian pertama </b> Berhasil Dilakukan. ";
        } else {
            $ok = 0;
            $msg = "Verifikasi Gagal Dilakukan. ";
        }
        
        echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
        Yii::app()->end();   
    }
    
    /**
     * Verifikasi 2
     */
    public function actionPersetujuanVerifikator2() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $ok = 1;
        $simpan = true;
        $msg = "Verifikasi Berhasil Dilakukan. ";
        $ex = explode(",", $_POST['nomorbarcode_sample']);
        $nomorbarcode_sample = $ex[0];
        $pengujian_ke = $ex[1];
        $modSkrining= SkriningimltdT::model()->findAllByAttributes(array('nomorbarcode_sample' => $nomorbarcode_sample, 'pengujian_ke' => $pengujian_ke));
        foreach($modSkrining as $value) {
            $value->tgl_verifikasi2 = date('d M Y H:i:s');
            $simpan = $simpan && $value->save(); 
        }

        if ($simpan) {
            $ok = 1;
            $msg = "Verifikasi untuk <b>".$nomorbarcode_sample." pengujian kedua</b> Berhasil Dilakukan. ";
        } else {
            $ok = 0;
            $msg = "Verifikasi Gagal Dilakukan. ";
        }
        
        echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
        Yii::app()->end();   
    }
}