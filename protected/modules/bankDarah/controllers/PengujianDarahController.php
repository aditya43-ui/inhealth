<?php
/**
 * @package     application.modules.bankDarah
 * @subpackage  controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Elham Budianto <elhambudianto@.com>
 * @author      Aida Rahmawati <aidarahmawati@.com>
 * @author      Andyka Putra <andykaputra@.com>
 * @version     2.0.0
 * @link        <http://172.9.1.15/simpp/docs/>
 * @link        <http://piindonesia.co.id> 
*/
class PengujianDarahController extends MyAuthController
{	    
    public $layout= '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'bankDarah.views.pengujianDarah.';
    public $init = '';        

    //public function actionIndex($terimakantongdet_id,$pengujiandarah_id=null)
    /**
     * action ini digunakan untuk masuk ke halaman transaksi pengujian golongan darah
     * @param type $nomorbarcode_sample
     * @param type $pengujiandarah_id
     * @param type $iframe
     * @param type $link
     */
    public function actionIndex($nomorbarcode_sample = null,$pengujiandarah_id=null,$iframe=null,$link=null)    
    {   
        if($iframe == 1){
           $this->layout =  '//layouts/iframe';
        }
        
        $model = new BDPengujiandarahT;
        $model->tglpengujian = date('d M Y H:i:s');
        if(!empty(Yii::app()->user->getState('pegawai_id'))){
            $petugasPengujian = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $model->petugaspengujian_id = $petugasPengujian->pegawai_id;
            $model->petugaspengujian_nama = $petugasPengujian->namaLengkap;
        }
        $model->tglpengujian = date('d M Y H:i:s');
        //load data ketika transaksi di menu transaksi pengujian sudah disimpan
        if (!empty($pengujiandarah_id) && !empty($nomorbarcode_sample)){
            $model = BDPengujiandarahT::model()->findBYPk($pengujiandarah_id);
            $model->petugaspengujian_nama = $model->petugaspengujian->namaLengkap;
            $model->tglpengujian = MyFormatter::formatDateTimeForUser($model->tglpengujian);
            $model->tgl_kadaluarsa = MyFormatter::formatDateTimeForUser($model->tgl_kadaluarsa);
            
            $criTerima = new CDbCriteria();        
            $criTerima->select = "  t.*, r_kirim.ruangan_nama as ruangankirim_nama, r_kirim.ruangan_id as ruangankirim_id, kantong.nomorbarcode_sample, kantong.gol_darah, kantong.rhesus, pendonor.pendonor_id  ";
            $criTerima->join =   "  JOIN kirimkantongdarah_t kirim ON kirim.kirimkantongdarah_id = t.kirimkantongdarah_id "
                    .        "  JOIN ruangan_m r_kirim ON r_kirim.ruangan_id = kirim.ruangankirim_id  "                                        
                    .        "  JOIN terimakantongdet_t det ON det.terimakantongdarah_id = t.terimakantongdarah_id "
                    .        "  JOIN kantongdarah_t kantong ON kantong.kantongdarah_id = det.kantongdarah_id "
                    .        "  LEFT JOIN pendonor_m pendonor ON pendonor.pendonor_id = kantong.pendonor_id  ";
            $criTerima->addCondition(" kantong.nomorbarcode_sample =  '".$nomorbarcode_sample."' ");
            $modTerima = BDTerimakantongdarahT::model()->find($criTerima);

            $modTerima->tglterimakantong = MyFormatter::formatDateTimeForUser($modTerima->tglterimakantong);
            $modTerima->ruangankirim_nama = $modTerima->ruangankirim_nama;        
            $modTerima->create_ruangan = $modTerima->ruangankirim_id;        
            $modTerima->nomorbarcode_sample = $modTerima->nomorbarcode_sample;

            $modTerimaDet = BDTerimakantongdetT::model()->findByAttributes(array('terimakantongdarah_id'=>$modTerima->terimakantongdarah_id));        
            $modTerimaDet->jenisterima_nama = $modTerimaDet->jeniskantongdarah->nama_jenis;
            //cek untuk nomor pengujian 
            $criteriaPengujian = new CDbCriteria();
            $criteriaPengujian->addCondition("nomorbarcode_sample = '".$nomorbarcode_sample."'");
            $criteriaPengujian->order = 'pengujiandarah_id ASC';
            $modPengujian = PengujiandarahT::model()->find($criteriaPengujian);
            if(!empty($modPengujian)){
                $model->goldar1 = $modPengujian->gol_darah;
                if ($modPengujian->rhesus == Params::RHESUS_POSITIF){
                    $model->rhesus1 = Params::PENGUJIAN_GOLDARAH_POSITIF;
                }else if($modPengujian->rhesus == Params::RHESUS_NEGATIF ){
                    $model->rhesus1 = Params::PENGUJIAN_GOLDARAH_NEGATIF;
                }else{
                    $model->rhesus1 = '';
                }
            }else{
                $model->pengujian_ke = 1;
                $model->goldar1 = '';
                $model->rhesus1 = '';
            }
        } else if (empty($pengujiandarah_id)){
            $criTerima = new CDbCriteria();        
            $criTerima->select = "  t.*, r_kirim.ruangan_nama as ruangankirim_nama, r_kirim.ruangan_id as ruangankirim_id, kantong.nomorbarcode_sample, kantong.gol_darah, kantong.rhesus, pendonor.pendonor_id  ";
            $criTerima->join =   "  JOIN kirimkantongdarah_t kirim ON kirim.kirimkantongdarah_id = t.kirimkantongdarah_id "
                        .        "  JOIN ruangan_m r_kirim ON r_kirim.ruangan_id = kirim.ruangankirim_id  "                                        
                        .        "  JOIN terimakantongdet_t det ON det.terimakantongdarah_id = t.terimakantongdarah_id "
                        .        "  JOIN kantongdarah_t kantong ON kantong.kantongdarah_id = det.kantongdarah_id "
                        .        "  LEFT JOIN pendonor_m pendonor ON pendonor.pendonor_id = kantong.pendonor_id  ";
            $criTerima->addCondition(" kantong.nomorbarcode_sample =  '".$nomorbarcode_sample."' ");
            $modTerima = BDTerimakantongdarahT::model()->find($criTerima);
            $modTerima->tglterimakantong = MyFormatter::formatDateTimeForUser($modTerima->tglterimakantong);
            $modTerima->ruangankirim_nama = $modTerima->ruangankirim_nama;  
            $modTerima->create_ruangan = $modTerima->ruangankirim_id;        
            $modTerima->nomorbarcode_sample = $modTerima->nomorbarcode_sample;
            
            //cek untuk nomor pengujian 
            $criteriaPengujian = new CDbCriteria();
            $criteriaPengujian->addCondition("nomorbarcode_sample = '".$nomorbarcode_sample."'");
            $modPengujian = PengujiandarahT::model()->find($criteriaPengujian);
            if(!empty($modPengujian)){
                $model->pengujian_ke = $modPengujian->pengujian_ke + 1;
                $model->goldar1 = $modPengujian->gol_darah;
                if ($modPengujian->rhesus == Params::RHESUS_POSITIF){
                    $model->rhesus1 = Params::PENGUJIAN_GOLDARAH_POSITIF;
                }else if($modPengujian->rhesus == Params::RHESUS_NEGATIF ){
                    $model->rhesus1 = Params::PENGUJIAN_GOLDARAH_NEGATIF;
                }else{
                    $model->rhesus1 = '';
                }
            }else{
                $model->pengujian_ke = 1;
                $model->goldar1 = '';
                $model->rhesus1 = '';
            }
            
            $modTerimaDet = BDTerimakantongdetT::model()->findByAttributes(array('terimakantongdarah_id'=>$modTerima->terimakantongdarah_id));        
            $modTerimaDet->jenisterima_nama = $modTerimaDet->jeniskantongdarah->nama_jenis;
        }else{
            //load model pertama kali ketika akan membuat transaksi di menu transaksi
            $model   = new BDPengujiandarahT;
            $model->tglpengujian = date('d M Y H:i:s');
            $modTerima   = new BDTerimakantongdarahT;
            $modTerimaDet = null;
        }
        
        if (isset($_POST['BDPengujiandarahT'])){            
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{                                
                $gol_darah_awal = $_POST['BDTerimakantongdarahT']['gol_darah'];
                $rhesus_awal = $_POST['BDTerimakantongdarahT']['rhesus'];
                
                $model->attributes = $_POST['BDPengujiandarahT'];     
                $model->tglpengujian = MyFormatter::formatDateTimeForDb($model->tglpengujian);
                //$model->terimakantongdet_id = $_POST['BDTerimakantongdetT']['terimakantongdet_id'];   
                $model->nomorbarcode_sample = $_POST['BDTerimakantongdarahT']['nomorbarcode_sample'];                
                $model->shift_id = Yii::app()->user->getState('shift_id');
                $model->asalruangan_id = $_POST['BDTerimakantongdarahT']['create_ruangan'];
                $nomorbarcode_sample = $_POST['BDTerimakantongdarahT']['nomorbarcode_sample'];
                
                if (!empty($model->pengujiandarah_id)){
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                    
                }else{
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }                                  
                
                if (isset($_POST['BDPengujiandarahT']['det'])){
                    $i = 1;
                    foreach ($_POST['BDPengujiandarahT']['det'] as $det){
                        if (!empty($model->pengujiandarah_id)) {
                            $modDet = BDPengujiandarahT::model()->findByPk($_GET['pengujiandarah_id']);
                        } else {
                            $modDet = new BDPengujiandarahT;
                        }
                        
                        $modDet->attributes = $model->attributes;
                        $modDet->attributes = $det;
                        $modDet->gol_darah_awal = $gol_darah_awal;
                        $modDet->rhesus_awal = $rhesus_awal;
                        $modDet->lot_anti_a = !empty($det['lot_anti_a']) ? $det['lot_anti_a'] : null;
                        $modDet->lot_anti_b = !empty($det['lot_anti_b']) ? $det['lot_anti_b'] : null;
                        $modDet->lot_anti_d = !empty($det['lot_anti_d']) ? $det['lot_anti_d'] : null;
                        $modDet->tgl_kadaluarsa = !empty($det['tgl_kadaluarsa']) ? MyFormatter::formatDateTimeForDb($det['tgl_kadaluarsa']) : null;
                        
                        if (empty($modDet->sel_a)){
                            $modDet->sel_a = Params::PENGUJIAN_GOLDARAH_NONE;
                        }
                        if (empty($modDet->sel_b)){
                            $modDet->sel_b = Params::PENGUJIAN_GOLDARAH_NONE;
                        }
                        if (empty($modDet->sel_o)){
                            $modDet->sel_o = Params::PENGUJIAN_GOLDARAH_NONE;
                        }
                        if (empty($modDet->anti_a)){
                            $modDet->anti_a = Params::PENGUJIAN_GOLDARAH_NONE;
                        }
                        if (empty($modDet->anti_b)){
                            $modDet->anti_b = Params::PENGUJIAN_GOLDARAH_NONE;
                        }
                        if (empty($modDet->anti_d)){
                            $modDet->anti_d = Params::PENGUJIAN_GOLDARAH_NONE;
                        }
                        if (empty($modDet->anti_ab)){
                            $modDet->anti_ab = Params::PENGUJIAN_GOLDARAH_NONE;
                        }
                        
                        //$modDet->pengujian_ke = $i;
                        
                        $ok = $ok && $modDet->save();
                                                
                        
                        $golDarah = $modDet->gol_darah;
                        $rhesus =   $modDet->rhesus;  
                        $pengujiandarah_id = $modDet->pengujiandarah_id;
                        
                        $i++;
                    }
                }
                
                /* Tidak dipakai, karena pengubahan golongan darah dan rhesus harus melalui mutu pada transaksi pelulusan komponen darah
                if ($_POST['BDTerimakantongdarahT']['berubahdata'] == 'ya'){
                    $arr = array(
                        'gol_darah' => $golDarah,
                        'rhesus' =>  ($rhesus == Params::RHESUS_POSITIF)?Params::PENGUJIAN_GOLDARAH_POSITIF:Params::PENGUJIAN_GOLDARAH_NEGATIF
                    );

                    PendonorM::model()->updateByPk($_POST['BDTerimakantongdarahT']['pendonor_id'],$arr);
                }
                */
                
                if ($ok){
                    $arrUp = array(
                        'pengujiandarah_id' => $pengujiandarah_id
                    );
                    $up = KantongdarahT::model()->updateAll($arrUp," nomorbarcode_sample = '".$nomorbarcode_sample."' ");
                }
                /*if ($model->hasil_uji == Params::HASIL_GOLDARAH_COCOK){
                    $criteria = new CDbCriteria();
                    $criteria->addCondition("nomorbarcode_sample = :nomorbarcode_sample");
                    $criteria->params[':nomorbarcode_sample'] = $_POST['BDTerimakantongdarahT']['nomorbarcode_sample'];
                    $ok = $ok && KantongdarahdetT::model()->updateAll(array('pengujiandarah_id'=>$model->pengujiandarah_id), $criteria);
                }else{
                    if ($model->pengujian_ke == 2 ){
                        $criteria = new CDbCriteria();
                        $criteria->addCondition("nomorbarcode_sample = :nomorbarcode_sample2");
                        $criteria->params[':nomorbarcode_sample2'] = $_POST['BDTerimakantongdarahT']['nomorbarcode_sample'];
                                                
                        $ok = $ok && KantongdarahdetT::model()->updateAll(array('pengujiandarah_id'=>$model->pengujiandarah_id), $criteria);
                        
                        if ($cekKeberapa->gol_darah == $model->gol_darah && $cekKeberapa->rhesus == $model->rhesus ){
                            
                            $arr = array(
                                'gol_darah' => $model->gol_darah,
                                'rhesues' =>  ($model->rhesus == Params::RHESUS_POSITIF)?Params::PENGUJIAN_GOLDARAH_POSITIF:Params::PENGUJIAN_GOLDARAH_NEGATIF
                            );
                            
                            PendonorM::model()->updateByPk($_POST['BDTerimakantongdarahT']['pendonor_id'],$rr);
                        }
                    }
                }*/
                
                                                
                if($ok){           
                    
                    
                    
                    
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    if(!empty($link)){
                        $this->redirect(array('/bankDarah/InformasiSampelDarah/index','sukses'=>1));
                    }else{
                        $this->redirect(array('index','nomorbarcode_sample'=>$nomorbarcode_sample,'pengujiandarah_id'=>$pengujiandarah_id,'sukses'=>1,'iframe'=>$iframe));       
                    }
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
            'modTerimaDet'=>$modTerimaDet,
            'modTerima'=>$modTerima,
            'link'=>$link
        ));

    }
    
    /**
     * auto compele, pencarian kanting darah
     */
    public function actionAutocompleteKantongDarah()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nomorbarcode = isset($_GET['nomorbarcode']) ? $_GET['nomorbarcode'] : null;
            $criteria=new CDbCriteria;
            $criteria->addCondition("t.terimakantongdarah_id IS NOT NULL "); 
            $criteria->addCondition(" t.nomorbarcode_sample IS NOT NULL "); 
            $criteria->compare('LOWER(t.nomorbarcode_sample)', strtolower($nomorbarcode), true);
            $criteria->select = 't.*, t.kantongdarah_id, t.nomorbarcode_sample, t.kantongdarahdet_id, kantongdarah.rhesus, kantongdarah.gol_darah, '
                    . 'jeniskantongdarah_m.nama_jenis, jeniskantongdarah_m.jeniskantongdarah_id, '
                    . 'terima.terimakantongdet_id, skrining.skriningimltd_id, skrining.hbsag,terimakantongdarah_t.ruanganterima_id, '
                    . 'skrining.antihiv, skrining.antihvc, skrining.sifilis, pengujiandarah_t.hasil_uji,p.pendonor_id,'
                    . 'terimakantongdarah_t.tglterimakantong,ruangan.ruangan_nama';
            $criteria->join = 'LEFT JOIN kantongdarah_t as kantongdarah ON t.kantongdarah_id=kantongdarah.kantongdarah_id '
                            . ' LEFT JOIN daftardonasi_t ON kantongdarah.daftarpendonor_id=daftardonasi_t.daftardonasi_id '
                            . ' LEFT JOIN pendonor_m as p ON daftardonasi_t.pendonor_id=p.pendonor_id '
                            . ' JOIN jeniskantongdarah_m ON t.jeniskantongdarah_id = jeniskantongdarah_m.jeniskantongdarah_id '
                            . ' LEFT JOIN terimakantongdet_t terima ON t.terimakantongdarah_id = terima.terimakantongdarah_id '
                            . ' LEFT JOIN terimakantongdarah_t ON t.terimakantongdarah_id = terimakantongdarah_t.terimakantongdarah_id '
                            . ' LEFT JOIN skriningimltd_t as skrining ON t.skriningimltd_id = skrining.skriningimltd_id '
                            . ' LEFT JOIN pengujiandarah_t ON t.pengujiandarah_id = pengujiandarah_t.pengujiandarah_id '
                            . ' JOIN kirimkantongdarah_t kirim ON terimakantongdarah_t.kirimkantongdarah_id = kirim.kirimkantongdarah_id '
                            . ' JOIN ruangan_m ruangan ON kirim.ruangankirim_id = ruangan.ruangan_id'; 
            $criteria->limit=5;
            $models = BDInformasisampeldarah::model()->findAll($criteria);
            
            $criteriaPengujian = new CDbCriteria();
            $criteriaPengujian->addCondition("nomorbarcode_sample = '".$nomorbarcode."'");
            $modPengujian = PengujiandarahT::model()->find($criteriaPengujian);
            if(!empty($modPengujian)){
                $pengujian_ke = $modPengujian->pengujian_ke + 1;
                $goldar1 = $modPengujian->gol_darah;
                if ($modPengujian->rhesus == Params::RHESUS_POSITIF){
                    $rhesus1 = Params::PENGUJIAN_GOLDARAH_POSITIF;
                }else if($modPengujian->rhesus == Params::RHESUS_NEGATIF ){
                    $rhesus1 = Params::PENGUJIAN_GOLDARAH_NEGATIF;
                }else{
                    $rhesus1 = '';
                }
            }else{
                $pengujian_ke = 1;
                $goldar1 = '';
                $rhesus1 = '';
            }
            
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorbarcode_sample;
                $returnVal[$i]["tglterimakantong"] = MyFormatter::formatDateTimeForUser($model->tglterimakantong);
                $returnVal[$i]["gol_darah"] = $model->gol_darah;
                $returnVal[$i]["rhesus"] = $model->rhesus;
                $returnVal[$i]["jenisterima_nama"] = $model->nama_jenis;
                $returnVal[$i]["ruangan_nama"] = $model->ruangan_nama;
                $returnVal[$i]["ruanganterima_id"] = $model->ruanganterima_id;
                $returnVal[$i]["terimakantongdet_id"] = $model->terimakantongdet_id;
                $returnVal[$i]["pendonor_id"] = $model->pendonor_id;
                $returnVal[$i]["kantongdarahdet_id"] = $model->kantongdarahdet_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
  
    
    /**
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * @param type nomorbarcode_sample
     * untuk menampilkan detail data, yang sudah tersimpan 
     */
    public function actionlihatDetail($nomorbarcode_sample)
    {                           
        $this->layout = "//layouts/iframe";
        
        $model = BDPengujiandarahT::model()->findByAttributes(array('nomorbarcode_sample'=>$nomorbarcode_sample));
        $model->petugaspengujian_nama = $model->petugaspengujian->namaLengkap;
        $modDet = BDPengujiandarahT::model()->findAllByAttributes(array('nomorbarcode_sample'=>$nomorbarcode_sample));
        
        $this->render($this->path_view.'detail',array(
            'model' => $model,               
            'modDet' => $modDet,               
        ));
    }
    
    /**
     * load hasil kesimpulan, pemeriksaan anti
     */
    public function actionKonfirmasiHasilUji(){
        if (Yii::app()->request->isAjaxRequest){
            $anti_a = isset($_POST['anti_a'])?$_POST['anti_a']:null;
            $anti_b = isset($_POST['anti_b'])?$_POST['anti_b']:null;
            $anti_d = isset($_POST['anti_d'])?$_POST['anti_d']:null;
            $anti_ab = isset($_POST['anti_ab'])?$_POST['anti_ab']:null;
            
            $sel_a = isset($_POST['sel_a'])?$_POST['sel_a']:null;
            $sel_b = isset($_POST['sel_b'])?$_POST['sel_b']:null;
            $sel_o = isset($_POST['sel_o'])?$_POST['sel_o']:null;
            
            $arr = array(
                'anti_a' => $anti_a,
                'anti_b' => $anti_b,
                'anti_d' => $anti_d,
                'anti_ab' => $anti_ab,
                'sel_a' => $sel_a,
                'sel_b' => $sel_b,
                'sel_o' => $sel_o,
            );
            
            $hasil = CustomFunction::ujiKonfirmasiGolDarah($arr);
                        
            $data['sukses'] = 1;
            $data['pesan'] = '';            
            $data['gol_darah'] = $hasil['gol_darah'];
            $data['rhesus'] = $hasil['rhesus'];
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
}
