<?php
/**
 * controller utama asesmen edukasi
 * 
 * @package application.controllers.rawatInap
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Andyka Putra <andykaputra@.com>
 * @author     Yusuf Putra Anugrah <yusufputra@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class AsesmenEdukasiController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatInap.views.asesmenEdukasi.';
    public $init = '';        

    /**
     * action utama untuk masuk ke transaksi asesmen edukasi
     * @param type $pendaftaran_id
     * @param type $asesmen_id
     * @param type $pasienmasukpenunjang_id
     * @param type $ubah
     */
    public function actionIndex($pendaftaran_id,$asesmen_id=null,$pasienmasukpenunjang_id=null,$ubah=null,$konsulpoli_id=null)
    {
        $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPendaftaran->kelaspelayanan_nama = (!empty($modPendaftaran->kelaspelayanan_id))?$modPendaftaran->kelaspelayanan->kelaspelayanan_nama:null;
        $modPendaftaran->nama_pegawai = (!empty($modPendaftaran->pegawai_id))?$modPendaftaran->pegawai->namaLengkap:null;
        
        $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $cekSuku = SukuM::model()->findByPk($modPasien->suku_id);
        $cekPendidikan = PendidikanM::model()->findByPk($modPasien->pendidikan_id);
        $modPasien->umurtahun = CustomFunction::getUmurTahun($modPasien->tanggal_lahir, $modPendaftaran->tgl_pendaftaran);
        $modPasien->sukubangsa = !empty($cekSuku) ? $cekSuku->suku_nama : '';
        $modPasien->pendidikan = !empty($cekPendidikan) ? $cekPendidikan->pendidikan_nama : '';
        if (!empty($pasienmasukpenunjang_id)){
            $modPenunjang = RIPasienMasukPenunjangT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,'pendaftaran_id'=>$pendaftaran_id));
            // echo '<pre>';var_dump($modPenunjang);die;
        }else{
            $modPenunjang = new RIPasienMasukPenunjangT;
        }
        
        $model = new RIAsesmenedukasiT;
        $modDet = new RIAsesmenedukasiDetT;
        
        $cekEdukasi = RIAsesmenedukasiT::model()->findByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
            'asesmenedukasi_id'=>$asesmen_id
        ));

        $modelRiwayat = new RIAsesmenedukasiT;
        $modelRiwayat->pendaftaran_id = $pendaftaran_id;

        if (isset($_GET['RIAsesmenedukasiT']) && $_GET['ajax'] == 'riwayatcppt-t-grid') {
            $modelRiwayat->attributes = $_GET['RIAsesmenedukasiT'];
            $modelRiwayat->create_ruangan = $_GET['RIAsesmenedukasiT']['create_ruangan'] ?? null;
        }
        
        if (!empty($cekEdukasi)){
            $model = $cekEdukasi;
            $getDet = RIAsesmenedukasiDetT::model()->findAllByAttributes(array('asesmenedukasi_id'=>$cekEdukasi->asesmenedukasi_id));
            if(!empty($ubah)){
                $getDet2 = RIAsesmenedukasiDetT::model()->findByAttributes(array('asesmenedukasi_id'=>$cekEdukasi->asesmenedukasi_id,'kel_data'=>$ubah));
            }else{
                $getDet2 = null;
            }
        }else{            
            $getDet = null;
            $getDet2 = null;
            
            $model->tgl_edukasi = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
            $model->menerimaedukasi_bersedia = true;
            $model->bahasa_indonesia = true;
            $model->kemampuanbahasa_baik = true;
            $model->kebutuhanpenerjemah_tidak = true;
            $model->bacatulis_baik = true;
            $model->hambatanedukasi_tidakada = true;
            $model->bicara_normal = true;
            $model->kebutuhanprivasi_tidak = true;
        }
        
        if (isset($_POST['RIAsesmenedukasiT'])){
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            
            try{
                $model->attributes = $_POST['RIAsesmenedukasiT'];
                $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $model->pasien_id = $modPendaftaran->pasien_id;   
                if (!empty($modPenunjang->pasienmasukpenunjang_id)){
                    $model->pasienmasukpenunjang_id = $modPenunjang->pasienmasukpenunjang_id;   
                }
                
                if (empty($cekEdukasi)){
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }else{
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                    
                }

                // var_dump($model->attributes, $_POST['RIAsesmenedukasiT']); die;
                
                $ok = $ok = $model->save();
                
                
                if ($this->init == 'HD'){
                    $this->ubah_status($pendaftaran_id, $konsulpoli_id);
                }
                
                //fungsi save
                if (isset($_POST['RIAsesmenedukasiDetT'])){

                    foreach($_POST['RIAsesmenedukasiDetT'] as $ii => $val){
                        if (empty($val['asesmenedukasi_det_id'])){
                            $modDet = new RIAsesmenedukasiDetT;
                            $modDet->attributes = $_POST['RIAsesmenedukasiDetT'][$ii];
                            //$modDet->tglpemeriksaan = MyFormatter::formatDateTimeForDb(date("Y-m-d",strtotime($val['tglpemeriksaan']))).' '.$val['jam_awal'];
                            $modDet->asesmenedukasi_id  = $model->asesmenedukasi_id;
                            $modDet->kel_data  = $val['kel_id'];
                            $modDet->create_time = date('d M Y H:i:s');
                            $modDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                            $modDet->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            
                            
                            //$selisih = CustomFunction::getSelisihJam($val['jam_awal'], $val['jam_akhir']);
                                                        
                            //$modDet->durasi = ($selisih['jam']*60)+$selisih['menit'];
                        }else{
                            $modDet = RIAsesmenedukasiDetT::model()->findByPk($val['asesmenedukasi_det_id']);
                            $modDet->attributes = $_POST['RIAsesmenedukasiDetT'][$ii];
                            //$modDet->tglpemeriksaan = MyFormatter::formatDateTimeForDb(date("Y-m-d", strtotime($val['tglpemeriksaan']))).' '.$val['jam_awal'];
                            $modDet->update_time = date('d M Y H:i:s');
                            $modDet->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                            
                            
                            //$selisih = CustomFunction::getSelisihJam($val['jam_awal'], $val['jam_akhir']);
                                                        
                            //$modDet->durasi = ($selisih['jam']*60)+$selisih['menit'];
                                                        
                        }
                        $modDet->namapenerima_edukasi= $val['namapenerima_edukasi'];
                        $modDet->materiedukasi= $val['materiedukasi'];
                        $ok = $ok && $modDet->save();
                       
                   }
                    
                    
                }
                
                
                if ($ok){
                    
                    if (!empty($modPenunjang->pasienmasukpenunjang_id)){
                        $up = PasienmasukpenunjangT::model()->findByPk($modPenunjang->pasienmasukpenunjang_id);
                        
                        if ($up->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA && $up->statusperiksa != Params::STATUSPERIKSA_SUDAH_PULANG){
                            $up->statusperiksa = Params::STATUSPERIKSA_SEDANG_PERIKSA;
                            $up->save();
                        }                        
                    }
                    
                    $p = PendaftaranT::model()->findByPk($model->pendaftaran_id);
                    $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
                    
                    $waktumulaiperiksa_now = date('Y-m-d H:i:s');
                    if (empty($p->waktumulaiperiksa)) {
                        $updateWaktuPeriksa = PendaftaranT::model()->updateByPk($p->pendaftaran_id, array('waktumulaiperiksa' => $waktumulaiperiksa_now));
                    }
                    
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data sukses disimpan!");
                    if(isset($_GET['is_pendaftaran'])){ //kondisi handle untuk assesmen setelah pendaftaran RI
                        if (!empty($modPenunjang->pasienmasukpenunjang_id)){
                            $this->redirect(array('index','pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'asesmen_id'=>$model->asesmenedukasi_id,'is_pendaftaran'=>1,'sukses'=>1,'pasienmasukpenunjang_id'=>$modPenunjang->pasienmasukpenunjang_id,'konsulpoli_id'=>$konsulpoli_id));
                        }else{
                            $this->redirect(array('index','pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'asesmen_id'=>$model->asesmenedukasi_id,'is_pendaftaran'=>1,'sukses'=>1,'konsulpoli_id'=>$konsulpoli_id));
                        }
                    }else{
                        if (!empty($pasienmasukpenunjang_id)){
                            $this->redirect(array('index','pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'asesmen_id'=>$model->asesmenedukasi_id,'sukses'=>1, 'pasienmasukpenunjang_id'=>$modPenunjang->pasienmasukpenunjang_id,'konsulpoli_id'=>$konsulpoli_id));
                        }else{
                            $this->redirect(array('index','pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'asesmen_id'=>$model->asesmenedukasi_id,'sukses'=>1,'konsulpoli_id'=>$konsulpoli_id));
                        }
                    }
                    
                }else{
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            }catch(Exception $e){
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($e,true));
            }
                                                                       
        }

        $this->render($this->path_view.'index',array(
            'modPendaftaran'=>$modPendaftaran,                
            'modPasien' => $modPasien,
            'model' => $model,
            'modDet' => $modDet,
            'getDet' => $getDet,
            'getDet2' => $getDet2,
            'modelRiwayat' => $modelRiwayat,
            'modPenunjang' => $modPenunjang
        ));
    }     
    
    public function ubah_status($pendaftaran_id, $konsulpoli_id){
        $pen = PendaftaranT::model()->findByPk($pendaftaran_id);
        $pen->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
        $pen->update_time = date('Y-m-d H:i:s');
        $pen->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $pen->save();
        
        $konsul = KonsulpoliT::model()->findByPk($konsulpoli_id);
        
        if (!empty($konsul)){            
            if (in_array($konsul->poliasal->instalasi_id, RuanganrawatinapV::loadInstalasi())){
                $konsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                $konsul->update_time = date('Y-m-d H:i:s');
                $konsul->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $konsul->save();
            }
        }                
    }
    
    /**
     * tambah data
     */
    function actionTambahHasil(){
        if (Yii::app()->request->isAjaxRequest){
            $kel_id = isset($_POST['kel_id'])?$_POST['kel_id']:null;
            $label = isset($_POST['label'])?$_POST['label']:null;
            $label_sebelum = isset($_POST['label_sebelum'])?$_POST['label_sebelum']:null;
            $nama_penerima = isset($_POST['nama_penerima'])?$_POST['nama_penerima']:null;
            
            if ($label_sebelum == null){
                $label = $label;
            }else{
                $label = $label_sebelum.', '.$label;
            }
            
            $modDet = new RIAsesmenedukasiDetT;
            $modDet->materiedukasi = $label;
            $modDet->namapenerima_edukasi = $nama_penerima;
                        
            $tr = $this->renderPartial($this->path_view.'form/_rowTabel',array('modDet'=>$modDet),true);
            
            $data['sukses'] = 1;
            $data['html'] = $tr;
           
            
            echo json_encode($data);
            
            Yii::app()->end();
        }
    }
    
    /**
     * hapus data
     */
    function actionHapusHasil(){
        if (Yii::app()->request->isAjaxRequest){
            
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $det_id = isset($_POST['det_id'])?$_POST['det_id']:null;

                $ok = true;

                $del = AsesmenedukasiDetT::model()->findByPk($det_id);
                $kel_id = $del->kel_data;
                
                $data['kel_id'] = $kel_id;
                
                if ($del->delete()){
                    $trans->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Data berhasil Dihapus';
                }else{
                    $trans->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data gagal dihapus';
                }
                
            }catch(Exception $e){
                $trans->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Data gagal dihapus';
            }
            
            echo json_encode($data);
            
            Yii::app()->end();
        }
    }
    
    /**
     * fungsi untuk mencetak prinout
     * @param type $id
     */
    public function actionPrint($id, $asesmen_id = null){
        $this->layout='//layouts/printWindows';
        $modPendaftaran = PendaftaranT::model()->findByPk($id);
        $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
        
        if (!empty($asesmen_id)) {
            $model = RIAsesmenedukasiT::model()->findByPk($asesmen_id);
            if (empty($model)) {
                echo "404 - Data tidak ditemukan";
                Yii::app()->exit();
            }
        } else {
            $model = RIAsesmenedukasiT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
        }
        
        $modDet = RIAsesmenedukasiDetT::model()->findAllByAttributes(array('asesmenedukasi_id'=>$model->asesmenedukasi_id));
        $cekAsesmen = RIAsesmenedukasiT::model()->findByAttributes(array('pendaftaran_id'=>$id,'pasien_id'=>$modPendaftaran->pasien_id));
       // var_dump(count($modDet ));die;
        $this->render($this->path_view.'Print',array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'model'=>$model,
            'modDet'=>$modDet,
        ));
    }

    public function actionReviewVerifikasiDpjp($asesmenedukasi_id, $type)
    {
        $this->layout = '//layouts/iframe';
        $model = RIAsesmenedukasiT::model()->findByPk($asesmenedukasi_id);
        $model->verifikasidpjp_tanggal = date('d M Y H:i:s');

        if (isset($_POST['RIAsesmenedukasiT'])) {
            $model->attributes = $_POST['RIAsesmenedukasiT'];
            $model->verifikasidpjp_tanggal = (!empty($_POST['RIAsesmenedukasiT']['verifikasidpjp_tanggal']) ? MyFormatter::formatDateTimeForDb($_POST['RIAsesmenedukasiT']['verifikasidpjp_tanggal']) : null);
            $model->isverifikasidpjp = true;

            if ($model->save()) {
                $this->redirect(array('reviewVerifikasiDpjp', 'asesmenedukasi_id' => $asesmenedukasi_id, 'type' => $type, 'sukses' => 1));
            }
        }

        if ($type == 'verifikasi') {
            $this->render($this->path_view . '_verifikasiDpjp', array(
                'model' => $model
            ));
        }
        if ($type == 'review') {
            $this->render($this->path_view . '_hasilReview', array(
                'model' => $model
            ));
        }
    }

    public function actionReviewVerifikasiSupervisi($asesmenedukasi_id, $type)
    {
        $this->layout = '//layouts/iframe';
        $model = RIAsesmenedukasiT::model()->findByPk($asesmenedukasi_id);
        $model->verifikasidpjp_tanggal = date('d M Y H:i:s');

        if (isset($_POST['RIAsesmenedukasiT'])) {
            $model->attributes = $_POST['RIAsesmenedukasiT'];
            $model->verifikasisupervisi_tanggal = (!empty($_POST['RIAsesmenedukasiT']['verifikasisupervisi_tanggal']) ? MyFormatter::formatDateTimeForDb($_POST['RIAsesmenedukasiT']['verifikasisupervisi_tanggal']) : null);
            $model->verifikasidpjp_hasilreview = (!empty($_POST['RIAsesmenedukasiT']['verifikasidpjp_hasilreview']) ? $_POST['RIAsesmenedukasiT']['verifikasidpjp_hasilreview'] : null);
            $model->verifikasisupervisi_keterangan = (!empty($_POST['RIAsesmenedukasiT']['verifikasisupervisi_keterangan']) ? $_POST['RIAsesmenedukasiT']['verifikasisupervisi_keterangan'] : null);
            $model->isverifikasisupervisi = true;


            if ($model->save()) {
                $this->redirect(array('reviewVerifikasiSupervisi', 'asesmenedukasi_id' => $asesmenedukasi_id, 'type' => $type, 'sukses' => 1));
            }
        }

        if ($type == 'verifikasi') {
            $this->render($this->path_view . '_verifikasiSupervisi', array(
                'model' => $model
            ));
        }
        if ($type == 'review') {
            $this->render($this->path_view . '_hasilReview', array(
                'model' => $model
            ));
        }
    }
}
