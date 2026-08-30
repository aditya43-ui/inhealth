<?php
/**
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 * @author Rusdiyanto <rusdiyanto@.com>
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @author Aida Rahmawati <aidarahmawati@gmail.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
*/
class PengirimanKantongDarahController extends MyAuthController {
    
        public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'bankDarah.views.pengirimanKantongDarah.';
        public $pendonortersimpan = false;
        public $pendaftardonasisimpan = false;
        public $simpandetailkantong = false;
        
    /**
     * digunakan untuk masuk ke menu transksi pengiriman kantong darah
     * @param type $kirimkantongdarah_id
     */
    public function actionIndex($kirimkantongdarah_id = null) {
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'barang-m-grid') {
                $this->renderPartial($this->path_view . '_dialogKantongDarah');
                Yii::app()->end();
            }
        }
        $modKirimKantong = new BDKirimkantongdarahT();
        $modKirimKantong->no_kirimkantong = '--Otomatis--';
        $modKirimKantong->tglkirimkantongdarah = date('Y-m-d H:i:s');
        // $modKirimKantong->ruangantujuan_id = Params::RUANGAN_TRANSFUSI_ITD_LT_5;
        $modLoginPemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
        $modKirimKantong->petugaskirim_id = $modLoginPemakai->pegawai_id;
        $modKirimKantong->ruangankirim_id = Yii::app()->user->getState('ruangan_id');
        $modRuangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
        $modKirimKantong->ruangankirim_nama = $modRuangan->ruangan_nama;
        $modKirimKantongDetail = new BDKirimkantongdetT();
        $modMonitoringKantong = new BDMonitoringkantongT();
        $format = new MyFormatter(); 
        
         if(isset($_POST['BDKirimkantongdarahT'])) {
            // echo '<pre>';var_dump($_POST);die;
            $modKirimKantong->attributes=$_POST['BDKirimkantongdarahT'];
            //$modKirimKantong->coolboxdarah_id=$_POST['BDKirimkantongdarahT']['coolboxdarah_id'];
            //$modKirimKantong->jml_coolbox=$_POST['BDKirimkantongdarahT']['jml_coolbox'];
            //$modKirimKantong->jml_icepack=$_POST['BDKirimkantongdarahT']['jml_icepack'];
            $modKirimKantong->no_kirimkantong = MyGenerator::noPengiriman();
            //$modKirimKantong->kantongdarah_id=$_POST['BDKirimkantongdarahT']['kantongdarah_id'];
            $modKirimKantong->tglkirimkantongdarah = $format->formatDateTimeForDb($_POST['BDKirimkantongdarahT']['tglkirimkantongdarah']);
            $modKirimKantong->create_time = date('Y-m-d H:i:s');                
            $modKirimKantong->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $modKirimKantong->create_ruangan = Yii::app()->user->getState('ruangan_id');
             if (isset($_POST['BDKirimkantongdetT'])){
                if ($modKirimKantong->validate()){
                    $transaction = Yii::app()->db->beginTransaction();
                    try{
                        $success = true;
                        if($modKirimKantong->save()){
                            $no_urut_terkahir = $_POST['no_urut'];
                            $modKirimKantongDetail = $this->validasiTabular($modKirimKantong, $_POST['BDKirimkantongdetT'],$no_urut_terkahir);
                                          
                        }
                        else{
                            $success = false;
                        }
                        if ($success == true && $this->simpandetailkantong == true){
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('index','kirimkantongdarah_id'=>$modKirimKantong->kirimkantongdarah_id,'sukses'=>1));
                        }
                        else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                        }
                    }
                    catch (Exception $ex){ var_dump($ex->getMessage(), $ex->getTraceAsString()); die;
                         $transaction->rollback();
                         Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
                    }
                }
            }else{
                $modKirimKantong->validate();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
            }
		}
        $this->render($this->path_view.'index',array(
           'modKirimKantong'=>$modKirimKantong,
           'modKirimKantongDetail'=>$modKirimKantongDetail,
           'modMonitoringKantong'=> $modMonitoringKantong,
           'format'=>$format,
        ));
        
    }
    
    /**
     * fungsi simpan detail kirim kantong detail t
     * @param type $model
     * @param type $data
     * @param type $no_urut_terkahir
     * @return \BDKirimkantongdetT
     */
     protected function validasiTabular($model, $data,$no_urut_terkahir){
        $valid = true;     
        // echo '<pre>';
        // echo '<pre>';var_dump($data);die;      
        foreach ($data as $ii =>$row){
            if($row['pilih'] == '1') {
                $modDetails[$ii] = new BDKirimkantongdetT;
                $modDetails[$ii]->attributes = $row;            
                $modDetails[$ii]->kirimkantongdarah_id = $model->kirimkantongdarah_id;
                $modDetails[$ii]->jmlkirim = $no_urut_terkahir;
                $modDetails[$ii]->nomorbarcode = $row['nomorbarcode_utama'];
                if($row['ada_samplekonfirmasi'] == '1') {
                    $modDetails[$ii]->ada_samplekonfirmasi = 'Ada';
                } else {
                    $modDetails[$ii]->ada_samplekonfirmasi = 'Tidak Ada';
                }
                if($row['ada_sampleimltd'] == '1') {
                    $modDetails[$ii]->ada_sampleimltd = 'Ada';
                } else {
                    $modDetails[$ii]->ada_sampleimltd = 'Tidak Ada';
                }
                if($row['ada_kantongdarah'] == '1') {
                    $modDetails[$ii]->ada_kantongdarah = 'Ada';
                } else {
                    $modDetails[$ii]->ada_kantongdarah = 'Tidak Ada';
                }
                // var_dump($modDetails[$ii]->save());
                $modDetails[$ii]->validate();                                     
                $valid = $modDetails[$ii]->validate() && $valid;      
                if ($modDetails[$ii]->save()){
                    
                    $coolBox = PenggunaanCoolboxdetT::model()->findByAttributes(array('kantongdarah_id'=>$modDetails[$ii]->kantongdarah_id));
                    $coolBox->kirimkantongdet_id = $modDetails[$ii]->kirimkantongdet_id;
                    $coolBox->save();        
                    // var_dump($coolBox->save());
                    $this->simpandetailkantong = true;
                }
            }
        }
        return $this->simpandetailkantong;
    }
    
    /**
     * menegenerate kantong darah
     */
     public function actionGetKantong(){
        if (Yii::app()->request->isAjaxRequest){
            $kantongdarah_id = isset($_POST['kantongdarah_id'])?$_POST['kantongdarah_id']:null;
            $no_penggunaan_coolbox = isset($_POST['no_penggunaan_coolbox'])?$_POST['no_penggunaan_coolbox']:null;
            $nomorbarcode_utama = isset($_POST['nomorbarcode_utama'])?$_POST['nomorbarcode_utama']:null;
            
            $cri = new CDbCriteria();
//            if (is_array($no_penggunaan_coolbox)){ 
//                foreach ($no_penggunaan_coolbox as $key => $val){
//                    if ($no_penggunaan_coolbox[$key] == ""){
//                        $no_penggunaan_coolbox[$key] = null;
//                    }
//                }
//                $cri->addInCondition("cool.no_penggunaan_coolbox", $no_penggunaan_coolbox);                
//            }else{
//                if (!empty($no_penggunaan_coolbox)){
//                    $cri->addCondition("cool.no_penggunaan_coolbox = '".$no_penggunaan_coolbox."' ");
//                }else{
//                    $cri->addCondition("cool.no_penggunaan_coolbox is null  ");
//                }
//            }
            
           
            if (is_array($nomorbarcode_utama)){ 
                foreach ($nomorbarcode_utama as $key => $val){
                    if ($nomorbarcode_utama[$key] == ""){
                        $nomorbarcode_utama[$key] = null;
                    }
                }
                $cri->addInCondition("t.nomorbarcode_utama", $nomorbarcode_utama);                
            }else{
                if (!empty($nomorbarcode_utama)){
                    $cri->addCondition("t.nomorbarcode_utama = '".$nomorbarcode_utama."' ");
                }else{
                    $cri->addCondition("t.nomorbarcode_utama is null  ");
                }
            }
            
            $cri->select = " t.*, cool.no_penggunaan_coolbox, jns_cool.coolboxdarah_nama, jns_kantong.nama_jenis, cooldet.no_kantongpabrik ";
            $cri->join = " LEFT JOIN kirimkantongdet_t kirimdet ON kirimdet.kantongdarah_id = t.kantongdarah_id "
                        . 'LEFT JOIN penggunaan_coolboxdet_t cooldet ON cooldet.kantongdarah_id = t.kantongdarah_id '
                        . ' JOIN penggunaan_coolbox_t cool ON cool.penggunaan_coolbox_id = cooldet.penggunaan_coolbox_id '
                        . 'LEFT JOIN coolboxdarah_m jns_cool ON jns_cool.coolboxdarah_id = cool.coolboxdarah_id '
                        . 'LEFT JOIN jeniskantongdarah_m jns_kantong on jns_kantong.jeniskantongdarah_id = t.jeniskantongdarah_id';
            $cri->addCondition(" t.terimakantongdarah_id is null AND kirimdet.kirimkantongdarah_id IS NULL ");
            $cri->addCondition(" t.nomorbarcode_utama IS NOT NULL ");
            $kantong = BDKantongdarahT::model()->findAll($cri);
            
            $res = array();
            if (!empty($kantong)){
                foreach ($kantong as $det){                
                        $res[$det->nomorbarcode_utama]['no_penggunaan_coolbox'] = $det->no_penggunaan_coolbox;
                    $res[$det->nomorbarcode_utama]['coolboxdarah_nama'] = $det->coolboxdarah_nama;
                    $res[$det->nomorbarcode_utama]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
                    $res[$det->nomorbarcode_utama]['nomorbarcode_sample'] = $det->nomorbarcode_sample;
//                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['no_identitas'] = $det->no_identitas;
//                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['no_formulir'] = $det->no_formulir;
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['no_kantongpabrik'] = $det->no_kantongpabrik;
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['nomorbarcode_sample'] = $det->nomorbarcode_sample;
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['gol_darah'] = $det->gol_darah;
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['rhesus'] = $det->rhesus;
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['nama_jenis'] = $det->nama_jenis;
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['jeniskantongdarah_id'] = $det->jeniskantongdarah_id;                
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['komponendarah_id'] = $det->komponendarah_id;                
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['kantongdarah_id'] = $det->kantongdarah_id;                
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['komponendarah_id'] = $det->komponendarah_id;
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['kantongdarah_id'] = $det->kantongdarah_id;
                    $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['nomorbarcode'] = $det->no_kantongdarah; 

                }

                $tr = '';
                $no = 0;

                foreach($res as $sam){
                    $a = 1;
                    foreach ($sam['sampel'] as $det){                    
                        $modKirimKantongDetail = new BDKirimkantongdetT();  
                        $modKirimKantongDetail->kantongdarah_id = $det['kantongdarah_id'];  
                        $modKirimKantongDetail->jeniskantongdarah_id = $det['jeniskantongdarah_id'];  
                        $modKirimKantongDetail->komponendarah_id = $det['komponendarah_id'];
                        //$modKirimKantongDetail->nomorbarcode = $det['no_kantongdarah'];
                        $modKirimKantongDetail->nomorbarcode_utama = $det['nomorbarcode_utama'];
                        $modKirimKantongDetail->nomorbarcode_sample = $det['nomorbarcode_sample'];
                        $modKirimKantongDetail->nama_jenis = $det['nama_jenis'];
                        $modKirimKantongDetail->no_kantongpabrik = $det['no_kantongpabrik'];
                        $modKirimKantongDetail->no_penggunaan_coolbox = $sam['no_penggunaan_coolbox'];
                        $modKirimKantongDetail->coolboxdarah_nama = $sam['coolboxdarah_nama'];
                        $modKirimKantongDetail->coolboxdarah_nama = $sam['coolboxdarah_nama'];
                        $modKirimKantongDetail->count_sampel = count($sam['sampel']);
                        $tr .= $this->renderPartial($this->path_view.'_detailKantongDarah', array('no'=>$no+1,'modKantong'=>$det, 'modKirimKantongDetail'=>$modKirimKantongDetail,'a'=>$a), true);                    
                        $a++;
                        $no++;
                    }                
                }
                $data['tr'] = $tr;
                $data['ditemukan'] = 1;
            }else{
                $tr = '';
                $data['ditemukan'] = 0;
                $data['tr'] = $tr;
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * menegenerate kantong darah
     */
     public function actionAutoCompleteGetKantong(){
        if (Yii::app()->request->isAjaxRequest){                        
            
            $cri = new CDbCriteria();
            $cri->select = " t.*, cool.no_penggunaan_coolbox, jns_cool.coolboxdarah_nama, jns_kantong.nama_jenis ";
            $cri->join = " LEFT JOIN kirimkantongdet_t kirimdet ON kirimdet.kantongdarah_id = t.kantongdarah_id "
                        . 'LEFT JOIN penggunaan_coolboxdet_t cooldet ON cooldet.kantongdarah_id = t.kantongdarah_id '
                        . ' JOIN penggunaan_coolbox_t cool ON cool.penggunaan_coolbox_id = cooldet.penggunaan_coolbox_id '
                        . 'LEFT JOIN coolboxdarah_m jns_cool ON jns_cool.coolboxdarah_id = cool.coolboxdarah_id '
                        . 'LEFT JOIN jeniskantongdarah_m jns_kantong on jns_kantong.jeniskantongdarah_id = t.jeniskantongdarah_id';
            $cri->addCondition(" t.terimakantongdarah_id is null AND kirimdet.kirimkantongdarah_id IS NULL ");
            $cri->addCondition(" t.nomorbarcode_utama IS NOT NULL ");
            if (!empty($_GET['coolboxdarah_id'])){
                $cri->addCondition(" jns_cool.coolboxdarah_id =  ".$_GET['coolboxdarah_id']." ");
            }else{
                $cri->addCondition(" t.kantongdarah_id is null ");
            }
            $cri->compare("LOWER(t.nomorbarcode_utama)", strtolower($_GET['term']),true);
            
            $modKantong = BDKantongdarahT::model()->findAll($cri);            
            
            $kanUtam = array();
                        
            foreach ($modKantong as $d){                                               
                $kanUtam[$d->nomorbarcode_utama]['no_penggunaan_coolbox'] = $d->no_penggunaan_coolbox;
                $kanUtam[$d->nomorbarcode_utama]['nomorbarcode_utama'] = $d->nomorbarcode_utama;
                $kanUtam[$d->nomorbarcode_utama]['nomorbarcode_sample'] = $d->nomorbarcode_sample;
                $kanUtam[$d->nomorbarcode_utama]['gol_darah'] = $d->gol_darah;
                $kanUtam[$d->nomorbarcode_utama]['rhesus'] = $d->rhesus;
                $kanUtam[$d->nomorbarcode_utama]['nama_jenis'] = $d->nama_jenis;
                $kanUtam[$d->nomorbarcode_utama]['jeniskantongdarah_id'] = $d->jeniskantongdarah_id;                
                $kanUtam[$d->nomorbarcode_utama]['label'] = $d->nomorbarcode_utama;                
                $kanUtam[$d->nomorbarcode_utama]['value'] = $d->nomorbarcode_utama;
            }                        
            
            $returnVal = array();
            $i = 0;
            foreach ($kanUtam as $d){
                $returnVal[$i]['nomorbarcode_utama'] = $d['nomorbarcode_utama'];
                $returnVal[$i]['label'] = $d['nomorbarcode_utama'];                
                $returnVal[$i]['value'] = $d['nomorbarcode_utama'];  
                
                $i++;
            }
            
            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }
    
    /**
     * Digunakan untuk mencetak dokumen
     * @author Elham Budianto <elhambudianto1@gmail.com>
     * @author Andyka Putra <andykaputra@.com>
     * @param type $caraPrint
     * @param type $kirimkantongdarah_id
     */
    public function actionPrint($caraPrint,$kirimkantongdarah_id) {
        $jumlah = 0;
        $model = BDKirimkantongdarahT::model()->findByPk($kirimkantongdarah_id);
        $criteria=new CDbCriteria;

        $criteria->select = 'kantongdarah.nomorbarcode_utama';
        $criteria->join = 'JOIN kantongdarah_t kantongdarah ON kantongdarah.kantongdarah_id = t.kantongdarah_id ';
        $criteria->addCondition('t.kirimkantongdarah_id = '.$kirimkantongdarah_id);
        $criteria->group = 'kantongdarah.nomorbarcode_utama ';
        $modDetail = KirimkantongdetT::model()->findAll($criteria); 
        
        foreach($modDetail as $detail){
            $jumlah = $jumlah + $detail->jmlkirim;
        }
        $judulLaporan = 'INSTALASI TRANSFUSI DARAH RSUD DR. SOETOMO SURABAYA <br> FORMULIR DISTRIBUSI DARAH PELAYANAN DONOR';
        
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows4';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan ,'modDetail'=>$modDetail,'jumlah'=>$jumlah,'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF60('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerHalaman', array('judulLaporan' => $judulLaporan, 'colspan' => 10), true));
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI_LANDSCAPE, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan ,'modDetail'=>$modDetail,'jumlah'=>$jumlah,'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }
}

