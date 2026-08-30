<?php
/**
 * 
 * controller transaksi penerimaan sisa kantong darah
 *
 * @package      application.modules.bankDarah
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class PenerimaanSisaKantongDarahController extends MyAuthController
{	        
    public $defaultAction = 'index';
    public $path_view = 'bankDarah.views.penerimaanSisaKantongDarah.';
    public $init = '';            
    
    /**
     * action ini digunakan sebagai halaman utama transaksi keseimbangan cairan
     * parameter yang digunakan dan wajib ada yaitu pendaftaran_id, untuk parameter pasienadmisi_id bersifat optional
     * @param type $publikasi_id
     */
    public function actionIndex($pergeseran_id=null)
    {                                                                      
        if (isset($_POST['BDTerimakantongdetT'])){
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();                        
            try{               
                foreach ($_POST['BDTerimakantongdetT'] as $i => $det){                                                           
                    foreach($_POST['BDTerimakantongdetT'][$i]['detail'] as $d){                                                
                        $modDet = BDTerimakantongdetT::model()->findByPk($d['terimakantongdet_id']);
                        $modDet->attributes = $det;                                                                        
                        
                        $ok = $ok && $modDet->save();                                                                    
                    }                    
                }                                
                
                if($ok){                                                                                               
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index','sukses'=>1));       
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
            
        ));
    }    
    
    public function actionLoadKantongDarah(){
        if (Yii::app()->request->isAjaxRequest){
            $nomor_barcode = isset($_POST['nomor_barcode'])?$_POST['nomor_barcode']:null;                                                
            $tr = '';
            $pesan = '';
            $cri = new CDbCriteria();
            $cri->select = " t.terimakantongdet_id, t.sampel_konfirmasi, t.sampel_imltd, t.sampel_utama, "
                        .  " t.no_pendonor, t.no_identitas, t.gol_darah, t.rhesus, t.jenisterima_nama,  t.no_kantongdarah, t.no_kirimkantong, "
                        .  " t.nomorbarcode_utama, t.nomorbarcode_sample, t.nomorbarcode_sample_imltd";            
            $cri->addCondition(" t.nomorbarcode_utama = '".$nomor_barcode."' OR t.nomorbarcode_sample = '".$nomor_barcode."'  ");//OR t.nomorbarcode_sample_imltd = '".$nomor_barcode."'
            
            $cek = clone $cri;

            $load = InfoterimakantongdarahV::model()->findAll($cri);
            $cekLoad = InfoterimakantongdarahV::model()->find($cek);
            
            if (!empty($cekLoad)){                        
                $initial = Params::cekJenisBarcodeDarah($nomor_barcode);
                
                
                
//                if ($cekLoad->sampel_konfirmasi == true && $initial['konfirmasi'] == Params::PREFIX_KANTONG_DARAH_SAMPLE){
//                    $pesan = " Kantong darah sample pengujian konfirmasi sudah diterima  ";
//                    $sukses = 0;
//                }elseif ($cekLoad->sampel_imltd == true && $initial['imltd'] == Params::PREFIX_KANTONG_DARAH_SKRINING_IMLTD){
//                    $pesan = " Kantong darah sample skrining imltd sudah diterima  ";
//                    $sukses = 0;
//                }elseif ($cekLoad->sampel_imltd == true && $initial['utama'] == Params::PREFIX_KANTONG_DARAH_UTAMA){
//                    $pesan = " Kantong darah utama sudah diterima  ";
//                    $sukses = 0;
                if ($cekLoad->sampel_konfirmasi == true && $cekLoad->sampel_imltd == true && $cekLoad->sampel_utama == true){
                    $pesan = " Kantong darah sudah diterima semua  ";
                    $sukses = 0;
                }else{
                        $sukses = 1;
                        $model = new BDTerimakantongdetT;                                                                            
                        $arr = array();
                        foreach($load as $det){                                                                                                
                            $arr[$det->nomorbarcode_utama]['no_pendonor'] = $det->no_pendonor;
                            $arr[$det->nomorbarcode_utama]['no_identitas'] = $det->no_identitas;
                            $arr[$det->nomorbarcode_utama]['gol_darah'] = $det->gol_darah;
                            $arr[$det->nomorbarcode_utama]['rhesus'] = $det->rhesus;
                            $arr[$det->nomorbarcode_utama]['jenisterima_nama'] = $det->jenisterima_nama;
                            $arr[$det->nomorbarcode_utama]['no_kirimkantong'] = $det->no_kirimkantong;                    
                            $arr[$det->nomorbarcode_utama]['sampel_konfirmasi'] = $det->sampel_konfirmasi;
                            $arr[$det->nomorbarcode_utama]['sampel_imltd'] = $det->sampel_imltd;
                            $arr[$det->nomorbarcode_utama]['sampel_utama'] = $det->sampel_utama;
                            $arr[$det->nomorbarcode_utama]['nomorbarcode'] = $det->nomorbarcode_utama;
                            $arr[$det->nomorbarcode_utama]['nomorbarcode_sample'] = $det->nomorbarcode_sample;                            
                            $arr[$det->nomorbarcode_utama]['det'][$det->terimakantongdet_id]['terimakantongdet_id'] = $det->terimakantongdet_id;
                            $arr[$det->nomorbarcode_utama]['det'][$det->terimakantongdet_id]['no_kantongdarah'] = $det->no_kantongdarah;                            
//                            if ($initial['konfirmasi'] == Params::PREFIX_KANTONG_DARAH_SAMPLE){                                
//                                $arr[$det->nomorbarcode_utama]['nomorbarcode'] = $det->nomorbarcode_sample;
//                                $arr[$det->nomorbarcode_utama]['sampel_imltd'] = '';
//                                $arr[$det->nomorbarcode_utama]['sampel_konfirmasi'] = true;
//                                $arr[$det->nomorbarcode_utama]['sampel_utama'] = '';
//                            }elseif ($initial['imltd'] == Params::PREFIX_KANTONG_DARAH_SKRINING_IMLTD){                                    
//                                $arr[$det->nomorbarcode_utama]['nomorbarcode'] = $det->nomorbarcode_sample_imltd;
//                                $arr[$det->nomorbarcode_utama]['sampel_imltd'] = true;
//                                $arr[$det->nomorbarcode_utama]['sampel_konfirmasi'] = '';
//                                $arr[$det->nomorbarcode_utama]['sampel_utama'] = '';
//                            }elseif ($initial['utama'] == Params::PREFIX_KANTONG_DARAH_UTAMA){                                    
//                                $arr[$det->nomorbarcode_utama]['nomorbarcode'] = $det->nomorbarcode_utama;
//                                $arr[$det->nomorbarcode_utama]['sampel_imltd'] = '';
//                                $arr[$det->nomorbarcode_utama]['sampel_konfirmasi'] = '';
//                                $arr[$det->nomorbarcode_utama]['sampel_utama'] = true;
//                            }
                        }
                        
                        foreach($arr as $d){
                            $model->nomorbarcode_sample = $d['nomorbarcode_sample'];
                            $model->sampel_konfirmasi = $d['sampel_konfirmasi'];
                            $model->sampel_imltd = $d['sampel_imltd'];
                            $model->sampel_utama = $d['sampel_utama'];
                            
                            $tr .= $this->renderPartial($this->path_view.'row/_rowPenerimaan',array('model'=>$model, 'det' =>$d, 'i'=>0),true);
                        }
                        
                    }                               
            }else{
                $pesan = "Data kantong darah tidak ditemukan";
                $sukses = 0;
            }
            
            $dt['sukses'] = $sukses;
            $dt['tr'] = $tr;
            $dt['pesan'] = $pesan;
            echo json_encode($dt);
            Yii::app()->end();
        }
        
    }
}