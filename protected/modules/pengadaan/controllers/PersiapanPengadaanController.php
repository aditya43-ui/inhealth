<?php
/**
 * 
 * controller transaksi persiapan pengadaan
 *
 * @package      application.modules.pengadaan
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author     Aida Rahmawati <aidarahmawati@.com>
 * @author      Andyka Putra <andykaputra@.com>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class PersiapanPengadaanController extends MyAuthController
{           
    public $defaultAction = 'index';
    public $path_view = 'pengadaan.views.persiapanPengadaan.';
    public $init = '';        

    
    /**
     * action ini digunakan sebagai halaman utama transaksi keseimbangan cairan
     * parameter yang digunakan dan wajib ada yaitu pendaftaran_id, untuk parameter pasienadmisi_id bersifat optional
     * @param type $publikasi_id
     */
    public function actionIndex($persiapanpengadaan_id=null, $rencanaumumpengadaan_id = null)
    {                                     
        $model = new ADPersiapanpengadaanT();
        $model->persiapanpengadaan_nomor = '-- Otomatis --';
        $model->rencanaumumpengadaan_kategori = ucfirst(strtolower(Params::KATEGORI_PENGADAAN_PENYEDIA)); 
        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->pegawaipembuat_id =!empty($peg)?$peg->pegawai_id:'';
        $model->pegawaipembuat_nama =!empty($peg)?$peg->namaLengkap:'';        
        $unit = UnitkerjaM::model()->findByPk($peg->unitkerja_id);
        //$model->unitkerja_id =!empty($unit)?$unit->unitkerja_id:'';
        //$model->namaunitkerja =!empty($unit)?$unit->namaunitkerja:'';
        $modDokRUP = new ADPengadaandokumenpendukungT;
        
        $modDet = null;
        $modDok = new ADPengadaandokumenpendukungT;
        $temp = '';
        
        $modRiwayat = new ADRiwayatpengadaanR();  
        $modRiwayat->persiapanpengadaan_id = $persiapanpengadaan_id;
        if (!empty($persiapanpengadaan_id)){
            $modRiwayat->riwayatpengadaan_catatan = 'Mengubah Persiapan Pengadaan';
        }
        
        $loadRiwayat = array();               
        
        if (!empty($rencanaumumpengadaan_id)) {
            $modRencana = RencanaumumpengadaanT::model()->findByPk($rencanaumumpengadaan_id);
            $model->namaunitkerja = $modRencana->unitkerja->namaunitkerja;
            $model->unitkerja_id = $modRencana->unitkerja->unitkerja_id;
            $model->instalasi_id = $modRencana->unitkerja->instalasi->instalasi_id;
            $model->instalasi_nama = $modRencana->unitkerja->instalasi->instalasi_nama;
            $model->rencanaumumpengadaan_kategori = $modRencana->rencanaumumpengadaan_kategori;
            $model->rencanaumumpengadaan_nomor = $modRencana->rencanaumumpengadaan_nomor;
            $model->periodeanggaran_id = $modRencana->periodeanggaran_id;
            $model->rencanaumumpengadaan_id = $modRencana->rencanaumumpengadaan_id;
            $modDokRUP = ADPengadaandokumenpendukungT::model()->findAll(" rencanaumumpengadaan_id ='".$rencanaumumpengadaan_id."'");
        }
        
        if (!empty($persiapanpengadaan_id)){
            $model = ADPersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $persiapanpengadaan_id));  
            if(!empty($model)){
                $model->pegawaipembuat_nama = !empty($model->pegawaipembuat->namaLengkap) ? $model->pegawaipembuat->namaLengkap : '';
                $model->namaunitkerja = !empty($model->unitkerja->namaunitkerja) ? $model->unitkerja->namaunitkerja : '';
                $model->instalasi_nama = !empty($model->unitkerja->instalasi->instalasi_nama) ? $model->unitkerja->instalasi->instalasi_nama : '';
                $model->rencanaumumpengadaan_kategori = !empty($model->rencanaumumpengadaan->rencanaumumpengadaan_kategori) ? $model->rencanaumumpengadaan->rencanaumumpengadaan_kategori : '';
                $model->rencanaumumpengadaan_nomor = !empty($model->rencanaumumpengadaan->rencanaumumpengadaan_nomor) ? $model->rencanaumumpengadaan->rencanaumumpengadaan_nomor : '';

                $model->persiapanpengadaan_tanggal = MyFormatter::formatDateTimeForDb($model->persiapanpengadaan_tanggal);
                $model->pemanfaatanbarang_tglawal = (!empty($model->pemanfaatanbarang_tglawal))?MyFormatter::formatDateTimeForUser($model->pemanfaatanbarang_tglawal):null;
                $model->pemanfaatanbarang_tglakhir = (!empty($model->pemanfaatanbarang_tglakhir))?MyFormatter::formatDateTimeForUser($model->pemanfaatanbarang_tglakhir):null;
                $model->pemilihanpenyedia_tglawal = (!empty($model->pemilihanpenyedia_tglawal))?MyFormatter::formatDateTimeForUser($model->pemilihanpenyedia_tglawal):null;
                $model->pemilihanpenyedia_tglakhir = (!empty($model->pemilihanpenyedia_tglakhir))?MyFormatter::formatDateTimeForUser($model->pemilihanpenyedia_tglakhir):null;
                $model->pelaksanaankontrak_tglawal = (!empty($model->pelaksanaankontrak_tglawal))?MyFormatter::formatDateTimeForUser($model->pelaksanaankontrak_tglawal):null;
                $model->pelaksanaankontrak_tglakhir = (!empty($model->pelaksanaankontrak_tglakhir))?MyFormatter::formatDateTimeForUser($model->pelaksanaankontrak_tglakhir):null;
                $modDokRUP = ADPengadaandokumenpendukungT::model()->findAll(" rencanaumumpengadaan_id ='".$model->rencanaumumpengadaan_id."'");
            }else{
                echo 'Data tidak ditemukan'; die();
            }
            $modDet = ADPersiapanpengadaandetT::model()->findAll(" persiapanpengadaan_id = '".$persiapanpengadaan_id."' ");
            
            $cekDok = ADPengadaandokumenpendukungT::model()->find(" persiapanpengadaan_id = '".$persiapanpengadaan_id."' ");
            
            $modDok = $cekDok;
            
            $loadRiwayat = ADRiwayatpengadaanR::model()->findAllByAttributes(array('persiapanpengadaan_id' => $persiapanpengadaan_id)); 
            $modDokRUP = new ADPengadaandokumenpendukungT;
        }
        
        if (isset($_POST['ADPersiapanpengadaanT'])){   
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['ADPersiapanpengadaanT'];
                $model->persiapanpengadaan_tanggal = MyFormatter::formatDateTimeForDb($model->persiapanpengadaan_tanggal);
                $model->pemanfaatanbarang_tglawal = (!empty($model->pemanfaatanbarang_tglawal))?MyFormatter::formatDateTimeForDb($model->pemanfaatanbarang_tglawal):null;
                $model->pemanfaatanbarang_tglakhir = (!empty($model->pemanfaatanbarang_tglakhir))?MyFormatter::formatDateTimeForDb($model->pemanfaatanbarang_tglakhir):null;
                $model->pemilihanpenyedia_tglawal = (!empty($model->pemilihanpenyedia_tglawal))?MyFormatter::formatDateTimeForDb($model->pemilihanpenyedia_tglawal):null;
                $model->pemilihanpenyedia_tglakhir = (!empty($model->pemilihanpenyedia_tglakhir))?MyFormatter::formatDateTimeForDb($model->pemilihanpenyedia_tglakhir):null;
                $model->pelaksanaankontrak_tglawal = (!empty($model->pelaksanaankontrak_tglawal))?MyFormatter::formatDateTimeForDb($model->pelaksanaankontrak_tglawal):null;
                $model->pelaksanaankontrak_tglakhir = (!empty($model->pelaksanaankontrak_tglakhir))?MyFormatter::formatDateTimeForDb($model->pelaksanaankontrak_tglakhir):null;                                
                $model->persiapanpengadaan_pagu = empty($model->persiapanpengadaan_pagu)?0:$model->persiapanpengadaan_pagu;

                if (empty($model->persiapanpengadaan_id)){
                    $model->persiapanpengadaan_status = Params::STATUS_PERSIAPAN_DIAJUKAN;
                    $model->persiapanpengadaan_nomor = MyGenerator::NoPersiapanPengadaan();    
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $st_trans = 'baru';
                }else{                    
                    if ($model->persiapanpengadaan_status == Params::STATUS_PERSIAPAN_REVISI) {
                        $model->persiapanpengadaan_status = Params::STATUS_PERSIAPAN_DIAJUKAN;
                    }
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                    
                    $st_trans = 'ubah';
                }
                
                $ok = $ok && $model->save();

                // Kirim SMS Dari PPK ke Kepala Unit Pegawai
                $nama_modul = Yii::app()->controller->module->id;
                $nama_controller = Yii::app()->controller->id;
                $nama_action = Yii::app()->controller->action->id;
                $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
                //LoadSMS
                $criteria = new CDbCriteria;
                $criteria->compare('modul_id', $modul_id);
                $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
                $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
                $criteria->addCondition(" statussms = true AND tujuansms = 'pegawai' ");
                $modSmsgateway = SmsgatewayM::model()->find($criteria);

                //Load Kepala Unit
                $cri = new CdbCriteria;
                $cri->join = " JOIN unitkerja_m u ON u.kepalaunitpeg_id = t.pegawai_id";
                $cri->addCondition("u.unitkerja_id = ".Params::UNITKERJA_ID_PENGADAAN_DAN_JASA); 
                if (!empty($modSmsgateway)) {
                    $template = $modSmsgateway->templatesms;
                } else {
                    $template = "Kepala Unit: Persiapan Pengadaan nomor {{nomor_pp}} tanggal {{tanggal_pp}} dengan metode {{metode_pengadaan}} nama unit kerja {{nama_unitkerja}} pekerjaan {{nama_pekerjaan}}. Mohon untuk segera dilakukan Review Persiapan Pengadaan.";
                }
                $modKepalaUnit = PegawaiM::model()->find($cri);

                if (!empty($modKepalaUnit)) {
                    $isiPesan = $template;
                    $attributes = $model->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        $isiPesan = str_replace("{{nomor_pp}}", $model->persiapanpengadaan_nomor, $isiPesan);
                        $isiPesan = str_replace("{{tanggal_pp}}", $model->persiapanpengadaan_tanggal, $isiPesan);
                        $isiPesan = str_replace("{{metode_pengadaan}}", $model->metodepengadaan_nama, $isiPesan);

                        $isiPesan = str_replace("{{nama_unitkerja}}", $model->unitkerja->namaunitkerja, $isiPesan);
                        $isiPesan = str_replace("{{nama_pekerjaan}}", $model->rencanaumumpengadaan->nama_pekerjaan, $isiPesan);
                    }
                    $api = new MyAPI();
                    if (!empty($modKepalaUnit->nomobile_pegawai)) {
                        $res = $api->smsBlastSend(array($modKepalaUnit->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                        CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
                    }//END OF if (!empty($modKepalaUnit->nomobile_pegawai))
                }//END of if (!empty($modKepalaUnit))
                //END OF Kirim SMS Dari PPK ke Kepala Unit Pegawai
                
                $renUp = RencanaumumpengadaanT::model()->findByPk($model->rencanaumumpengadaan_id);
                $renUp->rencanaumumpengadaan_status = Params::RENCANA_UMUM_PENGADAAN_STATUS_PERSIAPAN;
                $ok = $ok && $renUp->save();
                
                $modPengadaan = PengadaanprogramT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
                if (!empty($modPengadaan)) {
                    $modPengadaan->persiapanpengadaan_id = $model->persiapanpengadaan_id;
                    $ok = $ok && $modPengadaan->save(); 
                } else {
                    
                }
                                
                foreach ($_POST['ADPersiapanpengadaandetT']['detail'] as $det){                    
                    $modDet = new ADPersiapanpengadaandetT;  
                    
                    if (!empty($det['persiapanpengadaandet_id'])){
                        $cekDet = ADPersiapanpengadaandetT::model()->findByPk($det['persiapanpengadaandet_id']); 
                        $modDet = $cekDet;                        
                        $modDet->attributes = $det;   
                    }else{
                        $modDet = new ADPersiapanpengadaandetT();
                        $modDet->attributes = $model->attributes;
                        $modDet->attributes = $det;              
                        $modDet->persiapanpengadaan_id = $model->persiapanpengadaan_id;
                    }  
                    $modDet->harga_estimasi = $det["harga_estimasi"];
                    $modDet->jumlah_pajak = $det["jumlah_pajak"];
                    $modDet->jumlah_harga = $det["jumlah_harga"];
                    $ok = $ok && $modDet->save(); 
                      

                }     

                                
                
                if (isset($_POST['ADPengadaandokumenpendukungT'])){                                                     
                    foreach ($_POST['ADPengadaandokumenpendukungT'] as $i => $load){                                        
                        foreach($load['det'] as $a => $det){
                            $dokumen_pendukung = null;
                            $modDok = ADPengadaandokumenpendukungT::model()->findByPk($det['dokumenpendukungpengadaan_id']);                        
                            if (empty($modDok)){
                                $modDok = new ADPengadaandokumenpendukungT();
                                $modDok->attributes = $model->attributes;                        
                                $modDok->attributes = $load; 
                                $modDok->attributes = $det;    
                                $modDok->persiapanpengadaan_id = $model->persiapanpengadaan_id;
                                $modDok->rencanaumumpengadaan_id = null;
                                $modDok->create_time = date('Y-m-d H:i:s');
                                $modDok->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modDok->create_ruangan = Yii::app()->user->getState('ruangan_id');

                                $modDok->dokumenpendukungpengadaan_file = CUploadedFile::getInstance($modDok, '['.$i.'][det]['.$a.']dokumenpendukungpengadaan_file');

                                if (!empty($modDok->dokumenpendukungpengadaan_file)){
                                    $dokumen_pendukung = $modDok->dokumenpendukungpengadaan_file;                                    
                                    $fullImgName = $modDok->dokumenpendukungpengadaan_nama."_".$model->persiapanpengadaan_nomor.'.'.$dokumen_pendukung->getExtensionName();
                                    $fullImgSource = Params::pathDokPersiapanPengadaanDirectory() . $fullImgName;

                                    $modDok->dokumenpendukungpengadaan_file = $fullImgName;
                                    
                                    $ok = $ok && $modDok->save();
                                }

                            }else{
                                $modDok->attributes = $det;                               
                                $modDok->rencanaumumpengadaan_id = null;
                                $modDok->update_time = date('Y-m-d H:i:s');
                                $modDok->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                            
                                $modDok->dokumenpendukungpengadaan_file = $modDok->temp_file;

                                $ok = $ok && $modDok->save();  

                                $modDok = new ADPengadaandokumenpendukungT();                                
                                $modDok->attributes = $model->attributes;                        
                                $modDok->attributes = $load;
                                $modDok->attributes = $det;    
                                $modDok->persiapanpengadaan_id = $model->persiapanpengadaan_id;
                                $modDok->rencanaumumpengadaan_id = null;
                                $modDok->create_time = date('Y-m-d H:i:s');
                                $modDok->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modDok->create_ruangan = Yii::app()->user->getState('ruangan_id');                            
                                $modDok->dokumenpendukungpengadaan_file = CUploadedFile::getInstance($modDok, '['.$i.'][det]['.$a.']dokumenpendukungpengadaan_file');
                                
                                if (!empty($modDok->dokumenpendukungpengadaan_file)){
                                    $dokumen_pendukung = $modDok->dokumenpendukungpengadaan_file;                                
                                    $fullImgName = $modDok->dokumenpendukungpengadaan_nama."_".$model->persiapanpengadaan_nomor.'.'.$dokumen_pendukung->getExtensionName();
                                    $fullImgSource = Params::pathDokPersiapanPengadaanDirectory() . $fullImgName;

                                    $modDok->dokumenpendukungpengadaan_file = $fullImgName;                                                                                                                                    
                                    
                                    $ok = $ok && $modDok->save();
                                }else{
                                //    $modDok->dokumenpendukungpengadaan_file = $modDok->temp_file;
                                }
                            }
                                                                                   
                            if (!empty($dokumen_pendukung)){        
//                            if ($modDok->dokumenpendukungpengadaan_file != $temp){
//                                if (!empty($temp)){
//                                    if (file_exists(Params::pathDokPersiapanPengadaanDirectory().$temp)){
//                                        unlink(Params::pathDokPersiapanPengadaanDirectory().$temp);
//                                    }
//                                }
//                            }                            
                                if (!file_exists(Params::pathDokPersiapanPengadaanDirectory())){
                                    mkdir(Params::pathDokPersiapanPengadaanDirectory(),0775, true);                                    
                                }
                                
                                $dokumen_pendukung->saveAs($fullImgSource);
                            }
                        }                                                                                                                          
                    }
                }                
                                
                if ($model->total_hargaseluruhnya > 200000000 && $_POST['ADPersiapanpengadaanT']['jenispengadaan_id'] !== Params::JENIS_PENGADAAN_ID_JASA_KONSULTASI) {
                    $model->persiapanpengadaan_status = Params::STATUS_PERSIAPAN_DISETUJUI;
                    $ok = $ok && $model->save() && $this->simpanInfoUmum($model);
                } else if ($model->total_hargaseluruhnya > 100000000 && $_POST['ADPersiapanpengadaanT']['jenispengadaan_id'] == Params::JENIS_PENGADAAN_ID_JASA_KONSULTASI) {
                    $model->persiapanpengadaan_status = Params::STATUS_PERSIAPAN_DISETUJUI;
                    $ok = $ok && $model->save() && $this->simpanInfoUmum($model);
                } else if ($model->total_hargaseluruhnya < 10000000 && $_POST['ADPersiapanpengadaanT']['metodepengadaan_id'] != Params::METODE_PENGADAAN_ID_EPURCHASING) {
                    $model->persiapanpengadaan_status = Params::STATUS_PERSIAPAN_DISETUJUI;
                    $ok = $ok && $model->save() && $this->simpanInfoUmum($model);
                }
                
                if ($st_trans == 'baru'){
                    $ok = $ok && $this->simpanRiwayat($model,null,$st_trans,1);
                    
                }elseif ($st_trans == 'ubah'){
                    for ($i=1;$i<=2;$i++){
                        $ok = $ok && $this->simpanRiwayat($model,$_POST['ADRiwayatpengadaanR'],$st_trans,$i);
                    }
                }
                
                if($ok){                                                                                         
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index','persiapanpengadaan_id'=>$model->persiapanpengadaan_id,'sukses'=>1));
                }else{                             
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            
            }catch (Exception $exc) {                
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }       
            
            $modDet = null;            
        }
        
        $dok = ADDokumenpengadaanM::model()->findByAttributes(array('dokumenpengadaan_jenistransaksi' => Params::DOKUMEN_PENGADAAN_PERSIAPAN_PENGADAAN));
        
        $this->render($this->path_view.'index',array(
            'model' => $model,            
            'modDet' => $modDet,
            'modDok' => $modDok,
            'modDokRUP' => $modDokRUP,
            'dok' => $dok,
            'modRiwayat' => $modRiwayat,
            'loadRiwayat' => $loadRiwayat
        ));
        
    }  
    
    /**
     * load data rencana umum pengadaan sesuai primary keynya
     */
    public function actionLoadRUP(){
        if (Yii::app()->request->isAjaxRequest){
            
            $kategori = isset($_POST['kategori'])?$_POST['kategori']:null;            
            $rencanaumumpengadaan_id = isset($_POST['rencanaumumpengadaan_id'])?$_POST['rencanaumumpengadaan_id']:null;
            $persiapanpengadaan_id = isset($_POST['persiapanpengadaan_id'])?$_POST['persiapanpengadaan_id']:null;
                        
            $mod_rup = ADRencanaumumpengadaanT::model()->findByPk($rencanaumumpengadaan_id);
            $mod_pp = ADPersiapanpengadaanT::model()->findByPk($persiapanpengadaan_id);
            
            $cri = new CDbCriteria();
            $cri->group = " t.*, pro.programkerja_nama, pro.programkerja_kode, pro.programkerja_id, sub_pro.subprogramkerja_nama, sub_pro.subprogramkerja_kode, jenis.jenispengadaan_id, jenis.jenispengadaan_nama, t.rencanaumumpengadaan_id, subkeg.subkegiatanprogram_id, subkeg.subkegiatanprogram_nama, subkeg.subkegiatanprogram_kode";
            $cri->select = $cri->group;
            $cri->join =    "   LEFT JOIN subprogramkerja_m sub_pro ON sub_pro.subprogramkerja_id = t.subprogram_id"
                        .   "   LEFT JOIN programkerja_m pro ON pro.programkerja_id = sub_pro.programkerja_id "
                        .   "   LEFT JOIN pengadaanjenis_t pengjenis ON pengjenis.rencanaumumpengadaan_id = t.rencanaumumpengadaan_id "
                        .   "   LEFT JOIN jenispengadaan_m jenis ON jenis.jenispengadaan_id = pengjenis.jenispengadaan_id "
                        .   "   LEFT JOIN subkegiatanprogram_m subkeg ON subkeg.subkegiatanprogram_id = t.subkegiatanprogram_id ";
            $cri->addCondition(" t.rencanaumumpengadaan_id = '".$rencanaumumpengadaan_id."' ");
            $load = ADRencanaumumpengadaanT::model()->findAll($cri);
            
            $data['sukses'] = 1;
            
            $ren = array();
            
            foreach($load as $det){                                
                $ren[$det->rencanaumumpengadaan_id]['programkerja_nama'] = $det->programkerja_kode." - ".$det->programkerja_nama;
                $ren[$det->rencanaumumpengadaan_id]['programkerja_id'] = $det->programkerja_id;
                $ren[$det->rencanaumumpengadaan_id]['subprogram_id'] = $det->subprogram_id;
                $ren[$det->rencanaumumpengadaan_id]['subprogramkerja_nama'] = $det->subprogramkerja_nama;
                $ren[$det->rencanaumumpengadaan_id]['nama_pekerjaan'] = $det->nama_pekerjaan;
                $ren[$det->rencanaumumpengadaan_id]['rencanaumumpengadaan_nomor'] = $det->rencanaumumpengadaan_nomor;                
                $ren[$det->rencanaumumpengadaan_id]['rencanaumumpengadaan_id'] = $det->rencanaumumpengadaan_id;                
                $ren[$det->rencanaumumpengadaan_id]['total_pagu'] = number_format($det->total_pagu,2,"",".");
                $ren[$det->rencanaumumpengadaan_id]['dpa_pagu'] = !empty($det->dpa_pagu)?$det->dpa_pagu:'';
                $ren[$det->rencanaumumpengadaan_id]['jenispengadaan_id'][$det->jenispengadaan_id] = $det->jenispengadaan_id;
                $ren[$det->rencanaumumpengadaan_id]['jenispengadaan'][$det->jenispengadaan_id] = $det->jenispengadaan_nama;
                $ren[$det->rencanaumumpengadaan_id]['metodepengadaan_id'] = $det->metodepengadaan_id;
                $ren[$det->rencanaumumpengadaan_id]['metodepengadaan_nama'] = $det->metode_pengadaan;
                $ren[$det->rencanaumumpengadaan_id]['pemanfaatanbarang_tglawal'] = !empty($det->pemanfaatanbarang_tglawal)? MyFormatter::formatDateTimeForUser($det->pemanfaatanbarang_tglawal):null;
                $ren[$det->rencanaumumpengadaan_id]['pemanfaatanbarang_tglakhir'] = !empty($det->pemanfaatanbarang_tglakhir)? MyFormatter::formatDateTimeForUser($det->pemanfaatanbarang_tglakhir):null;
                $ren[$det->rencanaumumpengadaan_id]['pelaksanaankontrak_tglawal'] = !empty($det->pelaksanaankontrak_tglawal)?MyFormatter::formatDateTimeForUser($det->pelaksanaankontrak_tglawal):null;
                $ren[$det->rencanaumumpengadaan_id]['pelaksanaankontrak_tglakhir'] = !empty($det->pelaksanaankontrak_tglakhir)?MyFormatter::formatDateTimeForUser($det->pelaksanaankontrak_tglakhir):null;
                $ren[$det->rencanaumumpengadaan_id]['pemilihanpenyedia_tglawal'] = !empty($det->pemilihanpenyedia_tglawal)?MyFormatter::formatDateTimeForUser($det->pemilihanpenyedia_tglawal):null;
                $ren[$det->rencanaumumpengadaan_id]['pemilihanpenyedia_tglakhir'] = !empty($det->pemilihanpenyedia_tglakhir)?MyFormatter::formatDateTimeForUser($det->pemilihanpenyedia_tglakhir):null;
                $ren[$det->rencanaumumpengadaan_id]['swakelola_tipe'] = $det->swakelola_tipe;
                $ren[$det->rencanaumumpengadaan_id]['subkegiatanprogram_id'] = $det->subkegiatanprogram_id;                
                $ren[$det->rencanaumumpengadaan_id]['subkegiatanprogram_nama'] = $det->subkegiatanprogram_kode." - ".$det->subkegiatanprogram_nama;
                $ren[$det->rencanaumumpengadaan_id]['kode_rup'] = $det->kode_rup;
                $ren[$det->rencanaumumpengadaan_id]['total_hargaseluruhnya'] = $det->total_pagu;
                $ren[$det->rencanaumumpengadaan_id]['total_pajak'] = $det->total_pajak;
                $ren[$det->rencanaumumpengadaan_id]['total_harga'] = $det->total_harga;
            }
            
            $persiapan = ADPersiapanpengadaanT::model()->findByPk($persiapanpengadaan_id);
                        
            $data['metodepengadaan_id'] = !empty($persiapan->metodepengadaan_id)?$persiapan->metodepengadaan_id:$ren[$rencanaumumpengadaan_id]['metodepengadaan_id'];
            $data['metodepengadaan_nama'] = !empty($persiapan->metodepengadaan_id)?$persiapan->metodepengadaan->metodepengadaan_nama:$ren[$rencanaumumpengadaan_id]['metodepengadaan_nama'];
            $data['programkerja_nama'] = $ren[$rencanaumumpengadaan_id]['programkerja_nama'];
            $data['programkerja_id'] = $ren[$rencanaumumpengadaan_id]['programkerja_id'];
            $data['subprogram_id'] = $ren[$rencanaumumpengadaan_id]['subprogram_id'];
            $data['subprogramkerja_nama'] = $ren[$rencanaumumpengadaan_id]['subprogramkerja_nama'];
            $data['nama_pekerjaan'] = $ren[$rencanaumumpengadaan_id]['nama_pekerjaan'];
            $data['total_pagu'] = $ren[$rencanaumumpengadaan_id]['total_pagu'];
            $data['dpa_pagu'] = !empty($persiapan->dpa_pagu)?$persiapan->dpa_pagu:$ren[$rencanaumumpengadaan_id]['dpa_pagu'];
            $data['jenispengadaan_id'] = implode($ren[$rencanaumumpengadaan_id]['jenispengadaan_id'],",");
            $data['jenispengadaan'] = implode($ren[$rencanaumumpengadaan_id]['jenispengadaan'],",");
            $data['rencanaumumpengadaan_nomor'] = $ren[$rencanaumumpengadaan_id]['rencanaumumpengadaan_nomor'];
            $data['rencanaumumpengadaan_id'] = $ren[$rencanaumumpengadaan_id]['rencanaumumpengadaan_id'];
            $data['pemanfaatanbarang_tglawal'] = !empty($persiapan)?MyFormatter::formatDateTimeForUser($persiapan->pemanfaatanbarang_tglawal):$ren[$rencanaumumpengadaan_id]['pemanfaatanbarang_tglawal'];
            $data['pemanfaatanbarang_tglakhir'] = !empty($persiapan)?MyFormatter::formatDateTimeForUser($persiapan->pemanfaatanbarang_tglakhir):$ren[$rencanaumumpengadaan_id]['pemanfaatanbarang_tglakhir'];
            $data['pelaksanaankontrak_tglawal'] = !empty($persiapan)?MyFormatter::formatDateTimeForUser($persiapan->pelaksanaankontrak_tglawal):$ren[$rencanaumumpengadaan_id]['pelaksanaankontrak_tglawal'];
            $data['pelaksanaankontrak_tglakhir'] = !empty($persiapan)?MyFormatter::formatDateTimeForUser($persiapan->pelaksanaankontrak_tglakhir):$ren[$rencanaumumpengadaan_id]['pelaksanaankontrak_tglakhir'];
            $data['pemilihanpenyedia_tglawal'] = !empty($persiapan)?MyFormatter::formatDateTimeForUser($persiapan->pemilihanpenyedia_tglawal):$ren[$rencanaumumpengadaan_id]['pemilihanpenyedia_tglawal'];
            $data['pemilihanpenyedia_tglakhir'] = !empty($persiapan)?MyFormatter::formatDateTimeForUser($persiapan->pemilihanpenyedia_tglakhir):$ren[$rencanaumumpengadaan_id]['pemilihanpenyedia_tglakhir'];
            $data['swakelola_tipe'] = !empty($persiapan)?$persiapan->swakelola_tipe:$ren[$rencanaumumpengadaan_id]['swakelola_tipe'];
            $data['subkegiatanprogram_id'] = !empty($persiapan)?$persiapan->subkegiatanprogram_id:$ren[$rencanaumumpengadaan_id]['subkegiatanprogram_id'];
            $data['subkegiatanprogram_nama'] = !empty($persiapan->subkegiatanprogram_id)? $persiapan->subkegiatanprogram->subkegiatanprogram_kode." - ".$persiapan->subkegiatanprogram->subkegiatanprogram_nama : $ren[$rencanaumumpengadaan_id]['subkegiatanprogram_nama'];                        
            $data['kode_rup'] = $ren[$rencanaumumpengadaan_id]['kode_rup'];
            $data['total_hargaseluruhnya'] = $ren[$det->rencanaumumpengadaan_id]['total_hargaseluruhnya']; 
            $data['total_pajak'] = $ren[$det->rencanaumumpengadaan_id]['total_pajak']; 
            $data['total_harga'] = $ren[$det->rencanaumumpengadaan_id]['total_harga']; 
            
            $tr = '';
            $det = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id'=>$rencanaumumpengadaan_id));
            
            if (empty($persiapanpengadaan_id)){
                if (!empty($det)){
                    $modDet = new ADPersiapanpengadaandetT;
                    foreach($det as $i => $d){                    
                        $modDet->persiapanpengadaandet_nama = $d->rencanaumumpengadaandet_nama;
                        $modDet->persiapanpengadaandet_satuan = $d->rencanaumumpengadaandet_satuan;
                        $modDet->persiapanpengadaandet_volume = $d->rencanaumumpengadaandet_volume;
                        $modDet->harga_estimasi = $d->rencanaumumpengadaandet_harga;
                        $modDet->jumlah_pajak = $d->rencanaumumpengadaandet_jmlpajak;
                        $modDet->jumlah_harga = $d->rencanaumumpengadaandet_jumlah;
                        $modDet->barang_id = $d->barang_id;
                        $modDet->jenis_barang = $d->jenis_barang;
                        $modDet->pajak_persen = MyFormatter::formatNumberForPrint($d->rencanaumumpengadaandet_pajak,2);
                        $modDet->dokumenpelaksanaananggarandet_id = $d->dokumenpelaksanaananggarandet_id;
//                        $modDet->sisapagu_pengadaan = $d->dokumenpelaksanaananggarandet->sisapagu_pengadaan;
                        $modDet->jumlah_hargalama = $d->rencanaumumpengadaandet_jumlah;
                        $modDet->rencanaumumpengadaandet_id = $d->rencanaumumpengadaandet_id;

                        $tr .= $this->renderPartial($this->path_view.'form/_rowHPS',array('model'=>$modDet, 'i'=>$i),true);
                    }
                }
            }else{
                $modDet = ADPersiapanpengadaandetT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $persiapanpengadaan_id));
                foreach($modDet as $i => $d){                                        
                    $d->pajak_persen = MyFormatter::formatNumberForPrint($d->pajak_persen,2);
//                    $d->sisapagu_pengadaan = $d->dokumenpelaksanaananggarandet->sisapagu_pengadaan;
                    $d->jumlah_hargalama = $d->jumlah_harga;
                    $tr .= $this->renderPartial($this->path_view.'form/_rowHPS',array('model'=>$d, 'i'=>$i),true);
                }
            }
                                    
            $jenispengadaan_id = array();
            $jenis = PengadaanjenisT::model()->findAllByAttributes(array('rencanaumumpengadaan_id'=>$rencanaumumpengadaan_id));
            
            if (!empty($jenis)){
                foreach($jenis as $j){
                    $jenispengadaan_id[] = $j->jenispengadaan_id;
                }
            }
            
            $trDok = '';
            $cri = new CDbCriteria();
            if (strtolower($kategori) == strtolower(Params::KATEGORI_PENGADAAN_PENYEDIA)){
                if (!empty($jenispengadaan_id)){                    
                    $cri->addInCondition(" jenispengadaan_id ",$jenispengadaan_id);
                }else{
                    $cri->addCondition(" dokumenpengadaan_id is null ");
                }
                
            }elseif(strtolower($kategori) == strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA)){
                $cri->addCondition(" jenispengadaan_id IS NULL ");
            }else{
                $cri->addCondition(" dokumenpengadaan_id is null ");
            }
            $cond = '';
            if (!empty($mod_pp->metodepengadaan_id)){
                $cond = "AND metodepengadaan_id = '".$mod_pp->metodepengadaan_id."' ";
            }elseif (!empty($mod_rup->metodepengadaan_id)){
                $cond = "AND metodepengadaan_id = '".$mod_rup->metodepengadaan_id."' ";
            }else{
                $cond = "AND metodepengadaan_id is NULL ";
            }
            $cri->addCondition(" dokumenpengadaan_aktif = TRUE AND dokumenpengadaan_jenistransaksi = '".Params::DOKUMEN_PENGADAAN_PERSIAPAN_PENGADAAN."'  ".$cond);
            $cri->order = " dokumenpengadaan_urutan ASC ";
            $dok = ADDokumenpengadaanM::model()->findAll($cri);
            
            $cekDok = array();            
            if (!empty($persiapanpengadaan_id)){
                $loadDok = ADPengadaandokumenpendukungT::model()->findAllByAttributes(array('persiapanpengadaan_id'=>$persiapanpengadaan_id));
                
                if (!empty($loadDok)){
                    foreach($loadDok as $file){
                        $cekDok[$file->persiapanpengadaan_id][$rencanaumumpengadaan_id][$file->dokumenpengadaan_id]['det'][$file->dokumenpendukungpengadaan_id]['file'] = $file->dokumenpendukungpengadaan_file;
                        $cekDok[$file->persiapanpengadaan_id][$rencanaumumpengadaan_id][$file->dokumenpengadaan_id]['det'][$file->dokumenpendukungpengadaan_id]['id'] = $file->dokumenpendukungpengadaan_id;
                    }
                }
            }
            
            if (!empty($dok)){
                foreach($dok as $i => $d){                    
                    $class = '';
                    $jenis = array();                        
                    $tipe = array();
                    
                    if ($d->file_zip){
                        $tipe[] = '.zip';
                        $jenis[] = 'zip';
                    }

                    if ($d->file_rar){
                        $tipe[] = '.rar';
                        $jenis[] = 'rar';
                    }

                    if ($d->file_word){
                        $tipe[] = '.doc';
                        $tipe[] = '.docx';
                        $jenis[] = 'word';
                    }

                    if ($d->file_pdf){
                        $tipe[] = '.pdf';
                        $jenis[] = 'pdf';
                    }

                    if ($d->file_excel){
                        $tipe[] = '.xls';
                        $tipe[] = '.xlsx';
                        $jenis[] = 'excel';
                    }

                    if ($d->file_image){
                        $tipe[] = 'image/*';
                        $jenis[] = 'image';
                    }

                    if ($d->dokumenpengadaan_wajib){
                        $class =' required ';
                    } else {
                        $class = ' ';
                    }
                                        
                    $modDok = new ADPengadaandokumenpendukungT();
                    $modDok->dokumenpendukungpengadaan_nama = $d->dokumenpengadaan_nama;
                    $modDok->dokumenpengadaan_id = $d->dokumenpengadaan_id;                    
                    
                    
                    if (isset($cekDok[$persiapanpengadaan_id][$rencanaumumpengadaan_id][$d->dokumenpengadaan_id]['det'])){
                        $dok_det = $cekDok[$persiapanpengadaan_id][$rencanaumumpengadaan_id][$d->dokumenpengadaan_id]['det'];                        
                    }else{
                        $dok_det[0]['id'] = null;
                        $dok_det[0]['file'] = null;
                    }                    
                    $trDok .= $this->renderPartial($this->path_view.'form/_rowDokDukung',array('jenis'=>$jenis,'tipe'=>$tipe,'required'=>$class,'modDok'=>$modDok, 'i'=>$i, 'det'=>$dok_det),true);
                    
                }
            }
            
            $tblSumberdana = "";
            $modPengadaanSumberDana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $rencanaumumpengadaan_id));
            if(count($modPengadaanSumberDana)){
                $tblSumberdana .= "<table class='table table-condensed table-bordered table-striped'>";
                $tblSumberdana .= "
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Sumber Dana</th>
                            <th>Nilai Pagu</th>
                        </tr>
                    </thead>
                    <tbody>
                ";
                foreach ($modPengadaanSumberDana as $key => $value) {
                    $tblSumberdana .= "<tr>";
                    $tblSumberdana .= "<td>".(!empty($value->mappingrekeninganggaran_id) ? $value->mappingrekeninganggaran->kodeanggaran : "-")."</td>";
                    $tblSumberdana .= "<td>".(!empty($value->mappingrekeninganggaran_id) ? $value->mappingrekeninganggaran->nama_rekeninganggaran5 : "-")."</td>";
                    $tblSumberdana .= "<td>".$value->asal_dana."</td>";
                    $tblSumberdana .= "<td style='text-align: right'>".number_format($value->pagu,2)."</td>";
                    $tblSumberdana .= "</tr>";
                }
                $tblSumberdana .= "</tbody></table>";
            }
            
            $trDok2 = '';
            $dok2 = ADPengadaandokumenpendukungT::model()->findAll(" rencanaumumpengadaan_id ='".$rencanaumumpengadaan_id."'");
                    
            if (!empty($dok2)){
                foreach($dok2 as $i => $d){        
                    $trDok2 .= $this->renderPartial($this->path_view.'form/_rowDokRUP',array('modDok'=>$d, 'i'=>$i),true);
                }
            }
            
            $data['sumberDana'] = $tblSumberdana;
            $data['tr'] = $tr;
            $data['dokDukung'] = $trDok;
            $data['dokRUP'] = $trDok2;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
   /**
     * Proses unduh lampiran riwayat
     * @param integer $riwayatpengadaan_id
     */
    public function actionUnduh($riwayatpengadaan_id) {

        $filename = ADRiwayatpengadaanR::model()->findByPk($riwayatpengadaan_id);

        $path = Params::pathLampiranRiwayatPengadaanDirectory() . $filename->riwayatpengadaan_lampiran;

        if (!empty($filename->riwayatpengadaan_lampiran)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->riwayatpengadaan_lampiran, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' . 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot') .'/data/'. 'file_tidak_ditemukan.txt'));
        }
    }
    
    /**
     * Proses unduh dokumen pendukung
     * @param integer $dokumenpendukungpengadaan_id
     */
    public function actionUnduhDok($dokumenpendukungpengadaan_id) {

        $filename = ADPengadaandokumenpendukungT::model()->findByPk($dokumenpendukungpengadaan_id);

        $path = Params::pathDokPersiapanPengadaanDirectory() . $filename->dokumenpendukungpengadaan_file;

        if (!empty($filename->dokumenpendukungpengadaan_file)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->dokumenpendukungpengadaan_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot') .'/data/'.'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot') .'/data/'. 'file_tidak_ditemukan.txt'));
        }
    }
    
    /**
     * Proses unduh dokumen pendukung RUP
     * @param integer $dokumenpendukungpengadaan_id
     */
    public function actionUnduhDokRUP($dokumenpendukungpengadaan_id) {

        $filename = ADPengadaandokumenpendukungT::model()->findByPk($dokumenpendukungpengadaan_id);

        $path = Params::pathDokRencanaUmumPengadaanDirectory() . $filename->dokumenpendukungpengadaan_file;

        if (!empty($filename->dokumenpendukungpengadaan_file)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->dokumenpendukungpengadaan_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot') .'/data/'.'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot') .'/data/'. 'file_tidak_ditemukan.txt'));
        }
    }
    
    /**
     * 
     * @param type $modPersiapan
     * @param type $post
     * @return type
     */
    public function simpanInfoUmum($modPersiapan){
        $ok = true;
        $modInfo = new InfoumumpengadaanT();
        $modInfo->attributes = $modPersiapan;
        $modInformasi = ADInformasipersiapanpengadaanV::model()->findByAttributes(array('rencanaumumpengadaan_id' => $modPersiapan->rencanaumumpengadaan_id));
        $modInfo->persiapanpengadaan_id = $modPersiapan->persiapanpengadaan_id; 
        $modInfo->pegpa_id = $modInformasi->pegawaipa_id; 
        $modInfo->pegkpa_id = $modInformasi->pegawaikpa_id;
        $modInfo->pegppk_id = $modInformasi->pegawaippk_id;
        $modInfo->infoumumpengadaan_status = 'Dilanjutkan'; 
        $modInfo->create_loginpemakai_id = Yii::app()->user->id;
        $modInfo->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modInfo->create_time = date ('Y-m-d H:i:s');
        $ok = $ok && $modInfo->save();

        return $ok;
    }
    /**
     * Simpan riwayat 
     * @param type $model
     * @param type $post
     * @param type $st_trans
     * @param type $i
     * @return type
     */
    public function simpanRiwayat($model,$post,$st_trans,$i){
        $ok = true;
        $dokumenpendukung = '';
        $riwayat = new ADRiwayatpengadaanR();                
        if ($st_trans == 'ubah'){
            $riwayat->attributes = $post;
        }
        $riwayat->pegawai_id = Yii::app()->user->getState('pegawai_id');                    
        $peg = ADPegawaiM::model()->findByPk($riwayat->pegawai_id);
        $cekjab = PejabatpengadaanM::model()->findAllByAttributes(array('pegawai_id'=>$riwayat->pegawai_id));
        if(count($cekjab) == 1){
            $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id'=>$riwayat->pegawai_id));
        }else if(count($cekjab) > 1){
            $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id'=>$riwayat->pegawai_id, 'jabatan_pengadaan' => 'PPK'));
        }
        $riwayat->nama_pegawai = !empty($peg)?$peg->namaLengkap:'';                    
        $riwayat->jabatan_pengadaan = !empty($jab)?$jab->jabatan_pengadaan:'';                    
        $riwayat->create_time = date('Y-m-d H:i:s');
        $riwayat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $riwayat->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $riwayat->tanggal_update = date('Y-m-d H:i:s');            
        $riwayat->persiapanpengadaan_id = $model->persiapanpengadaan_id;    
        if ($i == 1){
            $riwayat->status_berkas = ucwords(strtolower($model->persiapanpengadaan_status));
            $riwayat->riwayatpengadaan_lampiran = CUploadedFile::getInstance($riwayat, 'riwayatpengadaan_lampiran');                                
            
            if (!empty($riwayat->riwayatpengadaan_lampiran)){
                $dokumenpendukung = $riwayat->riwayatpengadaan_lampiran;

                $fullImgName = str_replace(' ','_',strtolower(date('dmY_s').$dokumenpendukung));
                $fullImgSource = Params::pathLampiranRiwayatPengadaanDirectory() . $fullImgName;

                $riwayat->riwayatpengadaan_lampiran = $fullImgName;
            }
        }else{
            $riwayat->riwayatpengadaan_catatan = null;
            $riwayat->status_berkas = Params::STATUS_PERSIAPAN_DIAJUKAN;   
                                        
        }        
        
        $riwayat->rencanaumumpengadaan_id = null;
        
        $ok = $ok && $riwayat->save();                                      
        
        if (!empty($dokumenpendukung)){                     
            
            if (!file_exists(Params::pathLampiranRiwayatPengadaanDirectory())){
                mkdir(Params::pathLampiranRiwayatPengadaanDirectory(),0775, true);                                    
            }
            
            $dokumenpendukung->saveAs($fullImgSource);
        }                                        
        
        return $ok;
        
    }
    
    public function actionLoadDokPengadaan(){
        if (Yii::app()->request->isAjaxRequest){
            $metodepengadaan_id = isset($_POST['metodepengadaan_id'])?$_POST['metodepengadaan_id']:null;
            $persiapanpengadaan_id = isset($_POST['persiapanpengadaan_id'])?$_POST['persiapanpengadaan_id']:null;
            $rencanaumumpengadaan_id = isset($_POST['rencanaumumpengadaan_id'])?$_POST['rencanaumumpengadaan_id']:null;
            
            $mod_rup = ADRencanaumumpengadaanT::model()->findByPk($rencanaumumpengadaan_id);
            $mod_pp = ADPersiapanpengadaanT::model()->findByPk($persiapanpengadaan_id);
            
            $html = '';
            
            $jenispengadaan_id = array();
            $jenis = PengadaanjenisT::model()->findAllByAttributes(array('rencanaumumpengadaan_id'=>$rencanaumumpengadaan_id));
            
            if (!empty($jenis)){
                foreach($jenis as $j){
                    $jenispengadaan_id[] = $j->jenispengadaan_id;
                }
            }
            
            $trDok = '';
            
            $cri = new CDbCriteria();
            if (strtolower($mod_rup->rencanaumumpengadaan_kategori) == strtolower(Params::KATEGORI_PENGADAAN_PENYEDIA)){
                if (!empty($jenispengadaan_id)){                            
                    $cri->addInCondition(" jenispengadaan_id ",$jenispengadaan_id);
                }else{
                    $cri->addCondition(" dokumenpengadaan_id is null ");
                }
                
            }elseif(strtolower($mod_rup->rencanaumumpengadaan_kategori) == strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA)){
                $cri->addCondition(" jenispengadaan_id IS NULL ");
            }else{
                $cri->addCondition(" dokumenpengadaan_id is null ");
            }
            $cond = '';
            
            if (!empty($metodepengadaan_id)){
                
                $cond = " AND metodepengadaan_id = ".$metodepengadaan_id;
            }else{
                $cond = " AND metodepengadaan_id is NULL ";
            }
            $cri->addCondition(" dokumenpengadaan_aktif = TRUE AND dokumenpengadaan_jenistransaksi ilike '".Params::DOKUMEN_PENGADAAN_PERSIAPAN_PENGADAAN."'  ".$cond);
            $cri->order = " dokumenpengadaan_urutan ASC ";
            $dok = ADDokumenpengadaanM::model()->findAll($cri);
            
            $cekDok = array();
            
            if (!empty($persiapanpengadaan_id)){
                $loadDok = ADPengadaandokumenpendukungT::model()->findAllByAttributes(array('persiapanpengadaan_id'=>$persiapanpengadaan_id),array('order'=>'dokumenpendukungpengadaan_id'));
                
                if (!empty($loadDok)){
                    foreach($loadDok as $file){
                        $cekDok[$file->persiapanpengadaan_id][$rencanaumumpengadaan_id][$file->dokumenpengadaan_id]['file'] = $file->dokumenpendukungpengadaan_file;
                        $cekDok[$file->persiapanpengadaan_id][$rencanaumumpengadaan_id][$file->dokumenpengadaan_id]['id'] = $file->dokumenpendukungpengadaan_id;
                    }
                }
            }            
            
            if (!empty($dok)){
                foreach($dok as $i => $d){                    
                    $class = '';
                    $jenis = array();                        
                    $tipe = array();
                    
                    if ($d->file_zip){
                        $tipe[] = '.zip';
                        $jenis[] = 'zip';
                    }

                    if ($d->file_rar){
                        $tipe[] = '.rar';
                        $jenis[] = 'rar';
                    }

                    if ($d->file_word){
                        $tipe[] = '.doc';
                        $tipe[] = '.docx';
                        $jenis[] = 'word';
                    }

                    if ($d->file_pdf){
                        $tipe[] = '.pdf';
                        $jenis[] = 'pdf';
                    }

                    if ($d->file_excel){
                        $tipe[] = '.xls';
                        $tipe[] = '.xlsx';
                        $jenis[] = 'excel';
                    }

                    if ($d->file_image){
                        $tipe[] = 'image/*';
                        $jenis[] = 'image';
                    }

                    if ($d->dokumenpengadaan_wajib){
                        $class =' required ';
                    } else {
                        $class = ' ';
                    }
                                        
                    $modDok = new ADPengadaandokumenpendukungT();
                    
                    if (isset($cekDok[$persiapanpengadaan_id][$rencanaumumpengadaan_id][$d->dokumenpengadaan_id]['id'])){
                        $modDok->dokumenpendukungpengadaan_file = $cekDok[$persiapanpengadaan_id][$rencanaumumpengadaan_id][$d->dokumenpengadaan_id]['file'];
                        $modDok->dokumenpendukungpengadaan_id = $cekDok[$persiapanpengadaan_id][$rencanaumumpengadaan_id][$d->dokumenpengadaan_id]['id'];
                    }
                    $modDok->dokumenpendukungpengadaan_nama = $d->dokumenpengadaan_nama;
                    $modDok->dokumenpengadaan_id = $d->dokumenpengadaan_id;
                    $modDok->temp_file = $modDok->dokumenpendukungpengadaan_file;
                    
                    
                    $html .= $this->renderPartial($this->path_view.'form/_rowDokDukung',array('jenis'=>$jenis,'tipe'=>$tipe,'required'=>$class,'modDok'=>$modDok, 'i'=>$i),true);
                }
            }
            
            $data['sukses'] = 1;
            $data['html'] = $html;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
}