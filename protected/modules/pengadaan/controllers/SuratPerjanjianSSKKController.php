<?php
/**
 * 
 * controller surat perjanjian sskk
 *
 * @package      application.modules.pengadaan
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @author      Aida Rahmawati <aidarahmawati@.com>
 * @author      Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class SuratPerjanjianSSKKController extends MyAuthController
{	        
    public $defaultAction = 'index';
    public $path_view = 'pengadaan.views.suratPerjanjianSSKK.';
    public $init = '';        
    public $layout = '//layouts/iframe';
    
    /**
     * action ini digunakan sebagai halaman utama transaksi keseimbangan cairan
     * parameter yang digunakan dan wajib ada yaitu pendaftaran_id, untuk parameter pasienadmisi_id bersifat optional
     * @param type $publikasi_id
     */
    public function actionIndex($id)
    {   
        $modSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        if (empty($modSPK)){
            echo "Surat Perjanjian Kerja tidak ditemukan";die;                        
        }
        
        $dropSuratTemp = KonfigtemplatesuratK::model()->findAllByAttributes(array('jenissurat_id' => Params::JENISSURAT_ID_SSKK, 'konfigtemplatesurat_aktif' => TRUE),array('order' => 'jenissurat_nama'));
        
        $profilRS = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        
        $modSup = ADSupplierM::model()->findByPk($modSPK->supplier_id);
        
        $model = new ADSyaratkhususkontrakT;
        $model->suratperjanjiankerja_id = $modSPK->suratperjanjiankerja_id;   
        $model->nosuratperjanjiankerja = $modSPK->nosuratperjanjiankerja; 
        $model->syaratkhususkontrak_nomor = '-- Otomatis --';
        $model->syaratkhususkontrak_tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));        
        $model->pegppk_id = $modSPK->pejabatpembuatkomitmen_id;
        $model->pegppk_nama = $modSPK->pejabatpembuatkomitmen->namaLengkap;
        $model->wakilpenyedia_nama = $modSPK->supplier->direktursupplier;        
        $model->tanggal_awal = !empty($modSPK->tglawal_pekerjaan)?MyFormatter::formatDateTimeForUser($modSPK->tglawal_pekerjaan):null;
        $model->tanggal_akhir = !empty($modSPK->tglakhir_pekerjaan)?MyFormatter::formatDateTimeForUser($modSPK->tglakhir_pekerjaan):null;        
        $model->jangk_waktu = CustomFunction::hitungHari($modSPK->tglawal_pekerjaan, $modSPK->tglakhir_pekerjaan); 
        $model->nilai_kontrak = $modSPK->nilaikontrak;       
        $model->jumlah_indeks = 0;
        $model->koefisien_tetap = 0;
        $model->koefisien_kontrak = 0;
        $model->cara_pembayaran = $modSPK->kontrakcarapembayaran;
        $model->jumlah_uangmuka = $modSPK->uangmuka_jumlah;
        $model->supplier_id = $modSPK->supplier_id;
        $model->nama_supplier = $modSPK->supplier->supplier_nama;
        $model->alamat_supplier = $modSPK->supplier->supplier_alamat;
        $model->isuangmuka = !empty($modSPK->isuangmuka) ? $modSPK->isuangmuka : '';
        
        $cekSyarat = ADSyaratkhususkontrakT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$modSPK->suratperjanjiankerja_id));
        if (!empty($cekSyarat)){
            $model = $cekSyarat;
            $model->nosuratperjanjiankerja = $modSPK->nosuratperjanjiankerja; 
            $model->jangk_waktu = CustomFunction::hitungHari($model->tanggal_awal, $model->tanggal_akhir);
            $model->tanggal_awal = MyFormatter::formatDateTimeForUser($model->tanggal_awal);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForUser($model->tanggal_akhir);  
            $model->syaratkhususkontrak_tanggal = MyFormatter::formatDateTimeForUser($model->syaratkhususkontrak_tanggal);  
        }
                     
        if (isset($_POST['ADSyaratkhususkontrakT'])){              
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();                        
            try{
                $model->attributes = $_POST['ADSyaratkhususkontrakT'];     
                $model->syaratkhususkontrak_tanggal = MyFormatter::formatDateTimeForDb($model->syaratkhususkontrak_tanggal);
                $model->tanggal_awal = MyFormatter::formatDateTimeForDb($model->tanggal_awal);
                $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($model->tanggal_akhir);  
                if (!empty($model->isuangmuka)) {
                    $model->isuangmuka = true;
                } else {
                    $model->isuangmuka = false;
                }
                if (empty($model->syaratkhususkontrak_id)){
                    $model->syaratkhususkontrak_nomor = MyGenerator::NoSSKK();
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }else{
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                }
                $ok = $ok && $model->save();
                
                if($ok){                                                                                               
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index','id'=>$id,'sukses'=>1));       
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
            'modSPK' => $modSPK,
            'dropSuratTemp' => $dropSuratTemp,
            'profilRS' => $profilRS,
            'modSup' => $modSup
        ));
    }
    
    /**
     * Cetak transaksi uji coba
     * @param type $id
     */
    public function actionPrint($id){
        $this->layout = '//layouts/printWindows';
        $model = ADSyaratkhususkontrakT::model()->findByPk($id);
        $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $modsurat = SuratperjanjiankerjaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
        $modSupplier = SupplierM::model()->findByPk($modsurat->supplier_id);
        $tanggal_awal  = strtotime($model->tanggal_awal);
        $tanggal_akhir   = strtotime($model->tanggal_akhir);
        $diff           = $tanggal_akhir - $tanggal_awal;
        $selisihwaktu=floor($diff / (60 * 60 * 24));
        $model->jangk_waktu = $selisihwaktu;
            
        if (!empty($model->syaratkhususkontrak_id)) {
            $modSPK = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            $criteria->addCondition("konfigtemplatesurat_id=" . $model->konfigtemplatesurat_id);
            $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

            foreach ($modTemplate as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                
                foreach ($attributes as $attributes => $value) {
                   $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                   $isiPesan = str_replace("{{nilai_kontrak}}", "Rp " . number_format($model->nilai_kontrak, 2, ',', '.'), $isiPesan);
                   $isiPesan = str_replace("{{jumlah_uangmuka}}", "Rp " . number_format($model->jumlah_uangmuka, 2, ',', '.'), $isiPesan);
                   $isiPesan = str_replace("{{nomor_dokumen}}",$modsurat->nomor_dokumen, $isiPesan);
                   $isiPesan = str_replace("{{jangka_waktu}}",$model->jangk_waktu, $isiPesan);
                   $isiPesan = str_replace("{{jangk_waktu_huruf}}",trim(ucwords(MyFormatter::kataTerbilang($model->jangk_waktu))), $isiPesan);
                   $isiPesan = str_replace("{{tanggal_awal}}",date('d ', strtotime($model->tanggal_awal)) . MyFormatter::getMonthId(date('m', strtotime($model->tanggal_awal))) . date(' Y', strtotime($model->tanggal_awal)), $isiPesan);  
                   $isiPesan = str_replace("{{tanggal_akhir}}",date('d ', strtotime($model->tanggal_akhir)) . MyFormatter::getMonthId(date('m', strtotime($model->tanggal_akhir))) . date(' Y', strtotime($model->tanggal_akhir)), $isiPesan);
                   $isiPesan = str_replace("{{tglsuratperjanjian}}", date('d', strtotime($modsurat->tglsuratperjanjian))." ".MyFormatter::getMonthId(date('m', strtotime($modsurat->tglsuratperjanjian))).date(' Y', strtotime($modsurat->tglsuratperjanjian)), $isiPesan);
                   $isiPesan = str_replace("{{nama_rumahsakit}}",$modProfilRs->nama_rumahsakit , $isiPesan);
                   $isiPesan = str_replace("{{alamatlokasi_rumahsakit}}",$modProfilRs->alamatlokasi_rumahsakit , $isiPesan);
                   $isiPesan = str_replace("{{no_telp_profilrs}}",$modProfilRs->no_telp_profilrs , $isiPesan);
                   $isiPesan = str_replace("{{website}}",$modProfilRs->website , $isiPesan);
                   $isiPesan = str_replace("{{no_faksimili}}",$modProfilRs->no_faksimili , $isiPesan);
                   $isiPesan = str_replace("{{email}}",$modProfilRs->email , $isiPesan);
                   $isiPesan = str_replace("{{supplier_nama}}",$modSupplier->supplier_nama , $isiPesan);
                   $isiPesan = str_replace("{{supplier_alamat}}",$modSupplier->supplier_alamat , $isiPesan);
                   $isiPesan = str_replace("{{supplier_telp}}",$modSupplier->supplier_telp , $isiPesan);
                   $isiPesan = str_replace("{{supplier_fax}}",$modSupplier->supplier_fax , $isiPesan);
                   $isiPesan = str_replace("{{supplier_website}}",$modSupplier->supplier_website , $isiPesan);
                   $isiPesan = str_replace("{{supplier_email}}",$modSupplier->supplier_email , $isiPesan);
                   $isiPesan = str_replace("{{pegppk_nama}}",$model->pegppk_nama , $isiPesan);
                   $isiPesan = str_replace("{{direktursupplier}}",$modSupplier->direktursupplier , $isiPesan);
                   $isiPesan = str_replace("{{pegpengawas_nama}}",$model->pegpengawas_nama , $isiPesan);
                   $isiPesan = str_replace("{{masa_pemeliharaan}}",$model->pemeliharaan_masa , $isiPesan);
                   $isiPesan = str_replace("{{pemeliharaan_masa_huruf}}",trim(ucwords(MyFormatter::kataTerbilang($model->pemeliharaan_masa))), $isiPesan);
                   $isiPesan = str_replace("{{pemeliharaan_satuan}}",$model->pemeliharaan_satuan , $isiPesan);
                   $isiPesan = str_replace("{{umur_konstruksi}}",$model->umur_konstruksi , $isiPesan);
                   $isiPesan = str_replace("{{umur_kontruksi_huruf}}",trim(ucwords(MyFormatter::kataTerbilang($model->umur_konstruksi))), $isiPesan);
                   $isiPesan = str_replace("{{batas_pedoman}}",$model->batas_pedoman , $isiPesan);
                   $isiPesan = str_replace("{{batas_pedoman_huruf}}",trim(ucwords(MyFormatter::kataTerbilang($model->batas_pedoman))), $isiPesan);
                   $isiPesan = str_replace("{{batas_spp}}",$model->batas_spp , $isiPesan);
                   $isiPesan = str_replace("{{pencairan_jaminan}}",$model->pencairan_jaminan , $isiPesan);
                   $isiPesan = str_replace("{{fasilitas}}",$model->fasilitas , $isiPesan);
                   $isiPesan = str_replace("{{sumber_pembiayan}}",$model->sumber_pembiayan , $isiPesan);
                   $isiPesan = str_replace("{{isuangmuka}}",$model->isuangmuka , $isiPesan);
                   $isiPesan = str_replace("{{pembayaran_pekerjaan}}",$model->pembayaran_pekerjaan , $isiPesan);
                   $isiPesan = str_replace("{{indeks_dikeluarkan}}",$model->indeks_dikeluarkan , $isiPesan);
                   $isiPesan = str_replace("{{indeks_digunakan}}",$model->indeks_digunakan , $isiPesan);
                   $isiPesan = str_replace("{{jumlah_indeks}}",$model->jumlah_indeks , $isiPesan);
                   $isiPesan = str_replace("{{koefisien_tetap}}",$model->koefisien_tetap , $isiPesan);
                   $isiPesan = str_replace("{{koefisien_kontrak}}",$model->koefisien_kontrak , $isiPesan);
                   $isiPesan = str_replace("{{kompensasi}}",$model->kompensasi , $isiPesan);
                   $isiPesan = str_replace("{{ketentuan_denda}}",$model->ketentuan_denda , $isiPesan);
                   $isiPesan = str_replace("{{sanksi}}",$model->sanksi , $isiPesan);
                   $isiPesan = str_replace("{{penyelesaian_perselisihan}}",$model->penyelesaian_perselisihan , $isiPesan);
                }
                       
            }
            $model->dasar=$isiPesan;
            
        }
        
        $this->render('print', array('model' => $model));
    }
    
}