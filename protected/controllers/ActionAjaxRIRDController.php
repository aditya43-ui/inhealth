<?php
/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAjaxRIRDController extends Controller
{
    public $validRujukan = true;
    public $validPulang = false;
    public function actionAddPasienPulang()
    {
        $validRujukan = true;
        $validPasienPulang = false;
        
        $pasienadmisi_id = null;
        
        $pendaftaran_id = Yii::app()->session['pendaftaran_id'];
        $pasien_id = Yii::app()->session['pasien_id'];
        $modelPulang = new PasienpulangT;
        $modRujukanKeluar = new PasiendirujukkeluarT;
        
        $modMasukKamar = '';
        
        $modelPulang->tglpasienpulang = date('Y-m-d H:i:s');
        $modelPulang->pendaftaran_id = $pendaftaran_id;
        $modelPulang->pasien_id = $pasien_id;
        
        if(Yii::app()->user->getState('instalasi_id')== Params::INSTALASI_ID_RD)
        {
            $modRD = InfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasien_id'=>$pasien_id));
        }
        else
        {
            $modRD = PasienrawatinapV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasien_id'=>$pasien_id));
        }
        $modRujukanKeluar->pegawai_id = PendaftaranT::model()->findByPk($pendaftaran_id)->pegawai_id;
        $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id'); //ruangan asal itu diasumsikan ruangan terakhir dia dari mana
        
        $format = new MyFormatter();
        $date1 = $format->formatDateTimeForDb($modRD->tgl_pendaftaran);
        $date2 = date('Y-m-d H:i:s');
        $diff = abs(strtotime($date2) - strtotime($date1));
        $hours   = floor(($diff)/3600); 
        
        $modelPulang->lamarawat = $hours;
        
        if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) //kondisi apabila dari rawat inap, maka akan update ke masukkamar_t
        {
            $idMasukKamar = Yii::app()->session['idMasukKamar'];
            $modMasukKamar = MasukkamarT::model()->findByPk($idMasukKamar);
            $pasienadmisi_id = $modMasukKamar->pasienadmisi_id;
            $modMasukKamar->tglkeluarkamar = date('Y-m-d H:i:s');
            $modMasukKamar->jamkeluarkamar = date('H:i:s');
            $sql = "select date(tglmasukkamar) as tglmasukkamar from masukkamar_t where masukkamar_id = $idMasukKamar";
            
            //menghitung lama rawat
            $tglMasukKamar = Yii::app()->db->createCommand($sql)->queryRow();
            $date1 = $tglMasukKamar['tglmasukkamar'];
            $modMasukKamar->lamadirawat_kamar = $this->hitungLamaDirawat($date1);
            
            $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
            
            $modelPulang->lamarawat = $modMasukKamar->lamadirawat_kamar;
            
        }
       

        if(isset($_POST['PasienpulangT'])) 
        {   
            $transaction = Yii::app()->db->beginTransaction();
            try{
                if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) //kondisi apabila dari rawat inap, maka akan update ke masukkamar_t
                {   
                    $modelPulang = $this->savePasienPulang($modelPulang,$_POST['PasienpulangT'],$pasienadmisi_id);
                }
                else
                {
                    $modelPulang = $this->savePasienPulang($modelPulang,$_POST['PasienpulangT']);
                }

                if(isset($_POST['pakeRujukan']))
                {
                    $modelPulang->pakeRujukan = true;
                    $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar,$modelPulang,$_POST['PasiendirujukkeluarT']);
                }

                if(isset($_POST['isDead']))
                {
                    $modPasien = PasienM::model()->findByPk(Yii::app()->session['pasien_id']);
                    $modPasien->tgl_meninggal = $_POST['PasienpulangT']['tgl_meninggal'];
                    $modPasien->save();
                }
                if($this->validPulang && $this->validRujukan)
                {   
                    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                    $this->updatePendaftaran($modPendaftaran,$modelPulang);

                    if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) //kondisi apabila dari rawat inap, maka akan update ke masukkamar_t
                    {
                        $idMasukKamar = Yii::app()->session['idMasukKamar'];
                        
                        $modMasukKamar = MasukkamarT::model()->findByPk($idMasukKamar);
                        
                        $this->updateMasukKamar($modMasukKamar,$_POST['MasukkamarT']);
                        
                        $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
                        
                        $this->updatePasienAdmisi($modPasienAdmisi, $modelPulang);

                    }
                    
                    $transaction->commit();

                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                            ));
                        exit;               
                    }
                }  
            }
            catch(Exception $exc){
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }

        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formPasienPulang', 
                        array('modelPulang'=>$modelPulang,
                              'modRujukanKeluar'=>$modRujukanKeluar,
                              'modMasukKamar'=>$modMasukKamar,
                              'modRD'=>$modRD), true)));
            exit;               
        }
    }
    
    public function actionAddPindahKamar()
    {
        $idMasukKamar = Yii::app()->session['idMasukKamar'];
        $pendaftaran_id = Yii::app()->session['pendaftaran_id'];
        $pasien_id = Yii::app()->session['pasien_id'];
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        $modPindahKamar = new PindahkamarT;
        $modPindahKamar->tglpindahkamar = date('Y-m-d H:i:s');
        $modPindahKamar->jampindahkamar = date('H:i:s');
        $modDataPasien = PasienrawatinapV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        if(isset($_POST['PindahkamarT']))
        {
            $modPindahKamar->attributes =  $_POST['PindahkamarT'];
            $modPindahKamar->pasien_id = $modPasienAdmisi->pasien_id;
            $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id');
            $modPindahKamar->pendaftaran_id = $modPasienAdmisi->pendaftaran_id;
            $modPindahKamar->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
            $modPindahKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
            $modPindahKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
            $modPindahKamar->pegawai_id = $modPasienAdmisi->pegawai_id;
            $modPindahKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
            $modPindahKamar->nopindahkamar = MyGenerator::noMasukKamar($modPindahKamar->ruangan_id);
            if($modPindahKamar->save())
            {
                $modMasukKamar = MasukkamarT::model()->findByPk($idMasukKamar);
                $modMasukKamar->pindahkamar_id = $modPindahKamar->pindahkamar_id;
                $modMasukKamar->save();
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                        ));
                    exit;               
                }
            }
        }
        
        if (Yii::app()->request->isAjaxRequest)
        {   
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formPindahKamar', array('modPindahKamar'=>$modPindahKamar,'modPendaftaran'=>$modPendaftaran,'modDataPasien'=>$modDataPasien), true)));
            exit;               
        }
    }
    
    public function actionBuatSessionPendaftaranPasien()
    {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $pasien_id = $_POST['pasien_id'];
        
        Yii::app()->session['pendaftaran_id'] =  $pendaftaran_id;
        Yii::app()->session['pasien_id'] = $pasien_id;
        
        $status = false;
        
        if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) //apabila instalasi_id dari session login di rawat inap, 
                                                                           //maka akan membuat sesion masukkamar_id
        {
            $idMasukKamar = $_POST['idMasukKamar'];
            Yii::app()->session['idMasukKamar'] = $idMasukKamar;
            $kamarRuangan = MasukkamarT::model()->findByPk($idMasukKamar)->kamarruangan_id;
            $status = (!empty ($kamarRuangan) ? TRUE : FALSE); //kondisi untuk memeriksa apakah pasien sudah ada di sebuah kamar atau belum
        }
        
        echo CJSON::encode(array(
                'pendaftaran_id'=>Yii::app()->session['pendaftaran_id'], 
                'pasien_id'=>Yii::app()->session['pasien_id'],
                'status'=>$status));
        
    }
    
    public function actionBuatSessionMasukKamar()
    {
        
        $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
        $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
        
        $masukkamar_id = null;
        
        if(!empty($_POST['masukkamar_id']))
        {
            $masukkamar_id = (isset($_POST['masukkamar_id']) ? $_POST['masukkamar_id'] : null);
            Yii::app()->session['masukkamar_id'] = $masukkamar_id;
        }
        Yii::app()->session['kelaspelayanan_id'] =  $kelaspelayanan_id;
        Yii::app()->session['pendaftaran_id'] =  $pendaftaran_id;
        Yii::app()->session['masukkamar_id'] = $masukkamar_id;
        
        echo CJSON::encode(array(
                'kelaspelayanan_id'=>Yii::app()->session['kelaspelayanan_id'], 
                'pendaftaran_id'=>Yii::app()->session['pendaftaran_id'],
                'masukkamar_id'=>Yii::app()->session['masukkamar_id']));
        
    }
    
    public function actionAddMasukKamarRI()
    {
        $pendaftaran_id = (isset(Yii::app()->session['pendaftaran_id']) ? Yii::app()->session['pendaftaran_id'] : null);
        $kamarruangan_id = (isset($_POST['kamarruangan_id']) ? $_POST['kamarruangan_id'] : null);
        $masukkamar_id = (isset(Yii::app()->session['masukkamar_id']) ? Yii::app()->session['masukkamar_id'] : null);
        $kelaspelayanan_id = (isset(Yii::app()->session['kelaspelayanan_id']) ? Yii::app()->session['kelaspelayanan_id'] : null);
        $ruangan_id = Yii::app()->user->getState('ruangan_id');
        if(isset($kamarruangan_id)){
            $modMasukKamar = MasukkamarT::model()->findByPk($masukkamar_id);
        }else{
            $modMasukKamar = new MasukkamarT();
        }
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

        $modMasukKamar->ruangan_id = (isset($kamarruangan_id) ? $modMasukKamar->ruangan_id : $ruangan_id);
        $modMasukKamar->tglmasukkamar = date('Y-m-d H:i:s');
        $modMasukKamar->jammasukkamar = date('H:i:s');

        $modDataPasien = PasienrawatinapV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));        
        
        if(isset($_POST['MasukkamarT']))
        {
            $modMasukKamar->attributes =  $_POST['MasukkamarT'];
            $modMasukKamar->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
            $modMasukKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
            $modMasukKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
            $modMasukKamar->pegawai_id = $modPasienAdmisi->pegawai_id;
            $modMasukKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
            $modMasukKamar->nomasukkamar = MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
            $modMasukKamar->shift_id = Yii::app()->user->getState('shift_id');
            $modMasukKamar->create_time = date('Y-m-d H:i:s');
            $modMasukKamar->create_loginpemakai_id = Yii::app()->user->id;
            $modMasukKamar->create_ruangan = Yii::app()->user->getState('ruangan_id');

            $kamarruanganidupdate = $_POST['MasukkamarT']['kamarruangan_id'];
//            $cekidkamar = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            $cekidkamar = PendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
           if(empty($kamarruanganidupdate)){ 
                   PasienadmisiT::model()->updateByPk($cekidkamar->pasienadmisi_id, array('kamarruangan_id'=>$kamarruanganidupdate));
                   KamarruanganM::model()->updateByPk($modDataPasien->kamarruangan_id,array('kamarruangan_status'=>true));
            } 
            if($modMasukKamar->save())
            {
                KamarruanganM::model()->updateByPk($kamarruanganidupdate, array('kamarruangan_status'=>false));
                
                //update kamarruangan di pasienadmisi_t
//                $modPasienAdmisi = PasienadmisiT::model()->findByPk($modDataPasien->pasienadmisi_id);
//                $modPasienAdmisi->kamarruangan_id = $modMasukKamar->kamarruangan_id;
//                $modPasienAdmisi->save();
                
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                        ));
                    exit;               
                }
            }
            else
            {
                
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
                        ));
                    exit;               
                }
            }
        }
        
        if (Yii::app()->request->isAjaxRequest)
        {   

            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formMasukKamar', array('modMasukKamar'=>$modMasukKamar,'modDataPasien'=>$modDataPasien), true)));
            exit;               
        }
    }
    
    public function actionInsertMasukKamar()
    {
        $pendaftaran_id = Yii::app()->session['pendaftaran_id'];
        $idKelasPelayanan = Yii::app()->session['idKelasPelayanan'];
        $idRuangan = Yii::app()->user->getState('ruangan_id');
        $modMasukKamar = new MasukkamarT;
        $format = new MyFormatter();
        $modMasukKamar->tglmasukkamar = date('Y-m-d H:i:s');
        $modMasukKamar->jammasukkamar = date('H:i:s');
        $modDataPasien = PasienridariruanganlainV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $modMasukKamar->kamarruangan_id = $modDataPasien->kamarruangan_id;
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($modDataPasien->pasienadmisi_id);
        if(isset($_POST['MasukkamarT']))
        {
            $modMasukKamar->attributes =  $_POST['MasukkamarT'];
            $modMasukKamar->carabayar_id=$modDataPasien->carabayar_id;
            $modMasukKamar->kelaspelayanan_id= $modPasienAdmisi->kelaspelayanan_id;
            $modMasukKamar->ruangan_id= Yii::app()->user->getState('ruangan_id');
            $modMasukKamar->pasienadmisi_id=$modDataPasien->pasienadmisi_id;
            $modMasukKamar->pegawai_id= $modPasienAdmisi->pegawai_id;
            $modMasukKamar->tglmasukkamar= $format->formatDateTimeForDb($_POST['MasukkamarT']['tglmasukkamar']);
            $modMasukKamar->jammasukkamar = $format->formatTime($_POST['MasukkamarT']['jammasukkamar']);
            $modMasukKamar->penjamin_id=$modDataPasien->penjamin_id;
            $modMasukKamar->shift_id=Yii::app()->user->getState('shift_id');
            $modMasukKamar->nomasukkamar=MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
            $modMasukKamar->tglkeluarkamar=null;
            $modMasukKamar->jamkeluarkamar=null;
            $modMasukKamar->lamadirawat_kamar=null;
            if($modMasukKamar->save())
            {
                //update kamarruangan di pasienadmisi_t
//                $modPasienAdmisi = PasienadmisiT::model()->findByPk($modDataPasien->pasienadmisi_id);
//                $modPasienAdmisi->kamarruangan_id = $modMasukKamar->kamarruangan_id;
//                $modPasienAdmisi->save();
                $modPindahKamar = PindahkamarT::model()->findByPk($modDataPasien->pindahkamar_id);
                $modPindahKamar->masukkamar_id = $modMasukKamar->masukkamar_id;
                $modPindahKamar->save();
                
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                        ));
                    exit;               
                }
            }
            else
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
                        ));
                    exit;               
                }
            }
        }
        
        if (Yii::app()->request->isAjaxRequest)
        {   
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formInsertMasukKamar', array('modMasukKamar'=>$modMasukKamar,'modDataPasien'=>$modDataPasien), true)));
            exit;               
        }
    }
    
    protected function savePasienPulang($modPasienPulang,$attrPasienPulang,$pasienadmisi_id='')
    {
        $modelPulangNew = new PasienpulangT;
        $modelPulangNew->attributes = $attrPasienPulang;
        $modelPulangNew->satuanlamarawat = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? Params::SATUAN_LAMARAWAT_RD : Params::SATUAN_LAMARAWAT_RI;
        $modelPulangNew->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_time = date( 'Y-m-d H:i:s');
        $modelPulangNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
        $modelPulangNew->pasienadmisi_id = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? null : $pasienadmisi_id;

        if($modelPulangNew->save())
        {
            $this->validPulang = true;
        }
        
        return $modelPulangNew;
    }
    
    protected function saveRujukanKeluar($modRujukanKeluar,$modelPulang,$attrRujukanKeluar)
    {
        $modRujukanKeluarNew = new PasiendirujukkeluarT;
        $modRujukanKeluarNew->attributes = $attrRujukanKeluar;
        $modRujukanKeluarNew->pendaftaran_id = $modelPulang->pendaftaran_id;
        $modRujukanKeluarNew->pasien_id = $modelPulang->pasien_id;
        $modRujukanKeluarNew->create_time = date( 'Y-m-d H:i:s');
//        $modRujukanKeluarNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modRujukanKeluarNew->create_loginpemakai_id = Yii::app()->user->id;
        if($modRujukanKeluarNew->save())
        {
            'benar';
        }
        else
        {
            $this->validRujukan = false;
        }
        return $modRujukanKeluarNew;
    }
    
    protected function updatePendaftaran($modPendaftaran,$modelPulang)
    {
        $daftar = PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa'=>date( 'Y-m-d H:i:s'), 'pasienpulang_id'=>$modelPulang->pasienpulang_id,'statusperiksa'=>'SUDAH PULANG'));
        if ($daftar){
            return $modPendaftaran;
        }
        else{
            throw new Exception('Data Pasien Pulang Gagal Diupdate');
        }
    }
    
    protected function updatePasienAdmisi($modPasienAdmisi,$modelPulang)
    {
        
        $modPasienAdmisi->pasienpulang_id = $modelPulang->pasienpulang_id;
        $modPasienAdmisi->tglpulang = $modelPulang->tglpasienpulang;
//        $modPasienAdmisi->statuskeluar = 1;
        $modPasienAdmisi->save();
        return $modPasienAdmisi;
    }
    
    protected function updateMasukKamar($modMasukKamar,$attrMasukKamar)
    {
        $modMasukKamar->attributes = $attrMasukKamar;
        $modMasukKamar->save();
    }
    
    protected function hitungLamaDirawat($date)
    {echo $date;
        $today=date("Y-m-d");
        list($y,$m,$d)=explode('-',$date);
        list($ty,$tm,$td)=explode('-',$today);
        if($td-$d<0){
            $day=($td+30)-$d;
            $tm--;
        }
        else
        {
            $day=$td-$d;
        }
        return $day;
    }
    
    public function actionGetKamarKosong($encode=false)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            if(isset($_POST['kelaspelayanan_id']))
            {
                $ruangan_id = $_POST['ruangan_id'];
                $kelaspelayanan_id = ($_POST['kelaspelayanan_id'] == '' ? 0 : $_POST['kelaspelayanan_id']);
                
                $kamarKosong = array();
                if(!empty($ruangan_id)) {
                    $kamarKosong = KamarruanganM::model()->findAllByAttributes(
                        array(
                            'ruangan_id'=>$ruangan_id,
                            'kelaspelayanan_id'=>$kelaspelayanan_id,
                            'kamarruangan_status'=>(isset($_POST['is_status']) ? $_POST['is_status'] : true)
                        )
                    );
                    $kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
                }                
            }else{
                $ruangan_id = $_POST['ruangan_id'];
                $kamarKosong = array();
                if(!empty($ruangan_id))
                {
                    $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));
                    $kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
                }
            }
            
            if($encode){
                echo CJSON::encode($kamarKosong);
            } else {
                if(empty($kamarKosong)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                }else{
                    if(count((array)$kamarKosong) > 1)
                    {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                    }
                    foreach($kamarKosong as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
    public function actionBatalPindahKamar()
    {

        if (Yii::app()->request->isAjaxRequest){
            $idPindahKamar = $_POST['idPindahKamar'];
            $idMasukKamar = $_POST['idMasukKamar'];

            $modPindahKamar = PindahkamarT::model()->findByPk($idPindahKamar);
            $modMasukKamar = MasukkamarT::model()->findByPk($idMasukKamar);
            $modMasukKamarBaru = MasukkamarT::model()->findByPk($modPindahKamar->masukkamar_id);

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $success = false;
                $modPasienAdmisi = PasienadmisiT::model()->findByPK(
                    $modPindahKamar->pasienadmisi_id
                );
                $modPasienAdmisi->ruangan_id = $modMasukKamar->ruangan_id;
                $modPasienAdmisi->kelaspelayanan_id = $modMasukKamar->kelaspelayanan_id;
                $modPasienAdmisi->kamarruangan_id = $modMasukKamar->kamarruangan_id;

                $updatePasienAdmisi = $modPasienAdmisi->save();   
                
                $modMasukKamar->pindahkamar_id = null;
                
                $updateMasukKamar = $modMasukKamar->save();
                
                $updateKamar1 = KamarruanganM::model()->updateByPk($modPindahKamar->kamarruangan_id, array('kamarruangan_status'=>true));
                $updateKamar2 = KamarruanganM::model()->updateByPk($modPasienAdmisi->kamarruangan_id, array('kamarruangan_status'=>false));
                
                $modPindahKamar->masukkamar_id = null;
                $modPindahKamar->save();
                if($updatePasienAdmisi && $updateMasukKamar ) //TIDAK PERLU DI VALIDASI >> && $updateKamar1 && $updateKamar2
                {
                    
                     //Hapus masukkamar baru
                     if (isset($modMasukKamarBaru)?$modMasukKamarBaru->delete():true){
                         //Hapus pindah kamar
                        if($modPindahKamar->delete()){
                            $success = true;
                            echo CJSON::encode(array(
                                   'status'=>'true',
                                   'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>"
                                   ));
                        }
                     }
                }
                
                if ($success){
                    $transaction->commit();
                }
                else{
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                $transaction->rollback();
            }

            
            Yii::app()->end();
        }
    }
    
    // New Functiion GetKelasPelayanan , 15 Maret 2013
    public function actionGetKelasPelayanan($encode=false)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            $kamarKosong = array();
            $kelaspelayanan = array();
            if(!empty($ruangan_id))
            {
                
                $kamarKosong = KamarruanganM::model()->findAllByAttributes(
                    array(
                        'ruangan_id'=>$ruangan_id,
                        'kamarruangan_status'=>(isset($_POST['is_status']) ? $_POST['is_status'] : 't')
                    ),
                    array(
                        'order'=>'kelaspelayanan_id'
                    )
                );
                
                $kelas = null;
                foreach($kamarKosong as $val)
                {
                    if($kelas != $val->kelaspelayanan_id)
                    {
                        $kelas = $val->kelaspelayanan_id;
                        $kls_pelayanan = KelaspelayananM::model()->findByAttributes(
                            array(
                                'kelaspelayanan_id'=>$val->kelaspelayanan_id
                            )
                        );
                        $kelaspelayanan[] = $kls_pelayanan;
                    }
                }
            }
            
            if($encode)
            {
                $kelas_temp = array();
                foreach ($kelaspelayanan as $key => $value) {
                     $kelas_temp[$key] = KelaspelayananM::model()->findByPk($value->kelaspelayanan_id);
                }
                $kelaspelayanan = CHtml::listData($kelas_temp,'kelaspelayanan_id','kelaspelayanan_nama');                
                echo CJSON::encode($kelaspelayanan);
            }else{
                if(count((array)$kelaspelayanan) == 0)
                {
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                    foreach($kelaspelayanan as $key=>$val)
                    {
                        echo CHtml::tag(
                            'option', array('value'=>$val->kelaspelayanan_id), CHtml::encode($val->kelaspelayanan_nama),true
                        );
                    }                    
                }
            }
        }
        Yii::app()->end();
    }
    // End New Function
    
    /**
     * digunakan untuk menampilkan kelas pelayanan apabila belum memilih kamar ruangan di pendaftaran rawat inap
     * digunakan :
     * 1 pendaftaran rawat inap
     * @param type $encode
     * @param type $namaModel 
     */
    public function actionGetKelasPelayananRI($encode=false, $namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST['ruangan'];
            $kelaspelayanan = array();
            if(!empty($ruangan_id)) {
                $kelasRuangan = KelasruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
                
                foreach ($kelasRuangan as $key => $value) {
                     $kelaspelayanan[$key] = KelaspelayananM::model()->findByPk($value->kelaspelayanan_id);
                }
                $kelaspelayanan = CHtml::listData($kelaspelayanan,'kelaspelayanan_id','kelaspelayanan_nama');
            }
            
            if($encode){
                echo CJSON::encode($kelaspelayanan);
            } else {
                if(empty($kelaspelayanan)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                    foreach($kelaspelayanan as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
    
    
    public function actionBuatSessionUbahStatusKamarPasien()
    {
        $idKamarruangan = $_POST['idKamarruangan'];
        if(!empty($_POST['idKamarruangan']))
        {
            $idKamarruangan = $_POST['idKamarruangan'];
            Yii::app()->session['idKamarruangan'] = $idKamarruangan;
        }
        Yii::app()->session['kamarruangan_id'] =  $idKamarruangan;
        echo CJSON::encode(array(
            'kamarruangan_id'=>Yii::app()->session['kamarruangan_id']));
        
    }
    
     public function actionUbahStatusPeriksaRJ()
     {
           $format = new MyFormatter();
        $pendaftaran_id = Yii::app()->session['pendaftaran_id'];
        $format = new MyFormatter();
        $model = PendaftaranT::model()->findByPk($pendaftaran_id);
        $pasien_id = $model->pasien_id;
        $model->statusperiksa = Params::STATUSPERIKSA_BATAL_PERIKSA;
        $modBatalPeriksa = new PasienbatalperiksaR;
        $model->tglselesaiperiksa = date('Y-m-d H:i:s');
         
              $modBatalPeriksa->tglbatal = date('Y-m-d H:i:s'); 
              
              
              
        if(isset($_POST['PendaftaranT']))
        {
             $model = new PendaftaranT;
             $model->pasien_id = $pasien_id;
                   $model->pendaftaran_id = $modBatalPeriksa->pendaftaran_id;
              
            $model->tglselesaiperiksa = $_POST['PendaftaranT']['tglselesaiperiksa']; 
           $model->tglselesaiperiksa = $format->formatDateTimeForDb($_GET['PendaftaranT']['tglselesaiperiksa']);
                       
                    
           $update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>$_POST['PendaftaranT']['statusperiksa'],'tglselesaiperiksa'=>($_POST['PendaftaranT']['tglselesaiperiksa'])));
           if($update)
            {
               if(isset($_POST['PendaftaranT']['statusperiksa']) == "BATAL PERIKSA"){
                   
                   
                       
                   
                   $modBatalPeriksa = new PasienbatalperiksaR;
                   $modBatalPeriksa->pendaftaran_id = $pendaftaran_id;
                   $modBatalPeriksa->pasien_id = $model->pasien_id;
                   $modBatalPeriksa->tglbatal = $_POST['PasienbatalperiksaR']['tglbatal'];
                    $modBatalPeriksa->tglbatal = $format->formatDateTimeForDb($_GET['PasienbatalperiksaR']['tglbatal']);
                   $modBatalPeriksa->keterangan_batal = $_POST['PasienbatalperiksaR']['keterangan_batal'];
                   $modBatalPeriksa->create_time = date('Y-m-d');
                   $modBatalPeriksa->update_time = date('Y-m-d');
                   $modBatalPeriksa->create_loginpemakai_id = Yii::app()->user->id;
                   $modBatalPeriksa->update_loginpemakai_id = Yii::app()->user->id;
                   $modBatalPeriksa->create_ruangan = Yii::app()->user->getState('ruangan_id');

                   if($modBatalPeriksa->validate()){
                       if($modBatalPeriksa->save()){
                           PendaftaranT::model()->updateByPk($pendaftaran_id,array('pasienbatalperiksa_id'=>$modBatalPeriksa->pasienbatalperiksa_id));

                       }
                   }
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                            ));
                        exit;               
                    }
               }
               
               if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                        ));
                    exit;               
                }
            }
            else
            {
                
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
                        ));
                    exit;               
                }
            }
        }
        
        if (Yii::app()->request->isAjaxRequest)
        {   
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_ubahStatusPeriksa', array('model'=>$model,'modBatalPeriksa'=>$modBatalPeriksa),true)));
            exit;               
        }
    }
     public function actionUbahStatusKamarPasien()
     {
        $idKamarruangan = Yii::app()->session['kamarruangan_id'];
        $model = KamarruanganM::model()->findByPk($idKamarruangan);
   
        if(isset($_POST['KamarruanganM']))
        {
           $update = KamarruanganM::model()->updateByPk($idKamarruangan,array('keterangan_kamar'=>$_POST['KamarruanganM']['keterangan_kamar'],'kamarruangan_status'=>true));
           if($update)
            {
               if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                        ));
                    exit;               
                }
            }
            else
            {
                
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
                        ));
                    exit;               
                }
            }
        }
        
        if (Yii::app()->request->isAjaxRequest)
        {   
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_ubahStatusKamarPasien', array('model'=>$model),true)));
            exit;               
        }
    }
    
     public function actionUbahStatusPeriksaRD()
     {
        $pendaftaran_id = Yii::app()->session['pendaftaran_id'];
        $format = new MyFormatter();
        $model = PendaftaranT::model()->findByPk($pendaftaran_id);
        $model->statusperiksa = Params::STATUSPERIKSA_BATAL_PERIKSA;
        $modBatalPeriksa = new PasienbatalperiksaR;
        $model->tglselesaiperiksa = date('Y-m-d h:i:s');       
        if(isset($_POST['PendaftaranT']))
        {
           $update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>$_POST['PendaftaranT']['statusperiksa'],'tglselesaiperiksa'=>($_POST['PendaftaranT']['tglselesaiperiksa'])));
           if(isset($_POST['PendaftaranT']['statusperiksa']) == "BATAL PERIKSA"){
               $modBatalPeriksa = new PasienbatalperiksaR;
               $modBatalPeriksa->pendaftaran_id = $pendaftaran_id;
               $modBatalPeriksa->pasien_id = $model->pasien_id;
               $modBatalPeriksa->tglbatal = $format->formatDateTimeForDb($_POST['PasienbatalperiksaR']['tglbatal']);
               $modBatalPeriksa->keterangan_batal = $_POST['PasienbatalperiksaR']['keterangan_batal'];
               $modBatalPeriksa->create_time = date('Y-m-d');
               $modBatalPeriksa->update_time = date('Y-m-d');
               $modBatalPeriksa->create_loginpemakai_id = Yii::app()->user->id;
               $modBatalPeriksa->update_loginpemakai_id = Yii::app()->user->id;
               $modBatalPeriksa->create_ruangan = Yii::app()->user->getState('ruangan_id');
               
               if($modBatalPeriksa->validate()){
                   if($modBatalPeriksa->save()){
                       PendaftaranT::model()->updateByPk($pendaftaran_id,array('pasienbatalperiksa_id'=>$modBatalPeriksa->pasienbatalperiksa_id));
                       
                   }
               }
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                        ));
                    exit;               
                }
           }
           
           if($update)
            {
               if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                        ));
                    exit;               
                }
            }
            else
            {
                
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
                        ));
                    exit;               
                }
            }
        }
        
        if (Yii::app()->request->isAjaxRequest)
        {   
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_ubahStatusPeriksa', array('model'=>$model,'modBatalPeriksa'=>$modBatalPeriksa),true)));
            exit;               
        }
    }
    
    /*
     * Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */
         public function actionUbahStatusPeriksaPasien()
         {
            $idpendaftaran = $_POST['idpendaftaran'];
            $status = $_POST['status'];
            $model = PendaftaranT::model()->findByPk($idpendaftaran);
            $modBatalPeriksa = new PasienbatalperiksaR;
            $model->tglselesaiperiksa = date('Y-m-d H:i:s');
			$ok = true;
            $update = false;
            if(isset($_POST['status']))
            {
				// $trans = Yii::app()->db->beginTransaction();
//                print_r(55);
               if($status == "ANTRIAN"){
                   $update = PendaftaranT::model()->updateByPk($idpendaftaran,array('statusperiksa'=>'SEDANG PERIKSA'));
               }else{
//                   print_r($status);
                   if($status == "SEDANG PERIKSA"){
//                       print_r(6);
                        $update = PendaftaranT::model()->updateByPk($idpendaftaran,array('statusperiksa'=>'SUDAH DI PERIKSA'));
						if ($update) {
							$ok = $ok && PendaftaranT::model()->broadcastNotifSudahPeriksa($idpendaftaran);
						}
                        
                   } else if($status == "SUDAH DI PERIKSA"){
//                       print_r(6);
                        $update = PendaftaranT::model()->updateByPk($idpendaftaran,array('statusperiksa'=>'SEDANG PERIKSA'));
						if ($update) {
							$ok = $ok && PendaftaranT::model()->broadcastNotifSudahPeriksa($idpendaftaran);
						}
                        
                   } else if($status == "SEDANG DIRAWAT INAP"){
//                       print_r(2);
                       $update = PendaftaranT::model()->updateByPk($idpendaftaran,array('statusperiksa'=>'SUDAH PULANG'));
                   }
               }
               if($update)
               {
                        if (Yii::app()->request->isAjaxRequest)
                        {
                            echo CJSON::encode(array(
                                'status'=>'proses_form', 
                                'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                                ));
                            exit;               
                        }
               }else{
                   
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
                            ));
                        exit;               
                    }
                }
            }
        }
    /*
     * end Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */
    
}
?>
