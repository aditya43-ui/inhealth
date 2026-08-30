<?php
/**
 * controller Informasi Rencana Tindakan Anestesi
 * @author Rusdiyanto <rusdiyanto@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.anestesi
 * @subpackage controllers
 * @category controller
 */
class InformasiTindakanAnestesiController extends MyAuthController {
        public $layout='//layouts/iframe';
    	public $path_view='anestesi.views.informasiTindakanAnestesi.';
        
        /**
        * fungsi digunakan untuk update data RencanaanestesiT
        * @param integer $pasienanastesi_id
        */
        public function actionIndex($pendaftaran_id, $pasienkirimkeunitlain_id, $pasienanastesi_id = null) {         
             if (empty($pasienanastesi_id)){
                $cekRencana = EvaluasianestesiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));
            }else{
                $cekRencana = EvaluasianestesiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienanastesi_id'=>$pasienanastesi_id));
            }  
            
            if(!empty($cekRencana)) {
                $modEvaluasi = $cekRencana;
            }else{
                $modEvaluasi = new EvaluasianestesiT();
            }
            
            if (empty($modEvaluasi->tglpemberiinformasi)) {
                $modEvaluasi->tglpemberiinformasi = date('d M Y H:i:s');
                $modEvaluasi->tglterimainformasi_walipasien = date('d M Y H:i:s');
            } else {
                $modEvaluasi->tglpemberiinformasi = MyFormatter::formatDateTimeForUser($modEvaluasi->tglpemberiinformasi);
                $modEvaluasi->tglterimainformasi_walipasien = MyFormatter::formatDateTimeForUser($modEvaluasi->tglterimainformasi_walipasien);
            }
            
            $modPasienAnestesi = ATPasienanastesiT::model()->findByPk($pasienanastesi_id); 
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            
            if (!empty($modPendaftaran->pasienadmisi_id)) {
                $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
                $modEvaluasi->ruanganasal_id = $modAdmisi->ruangan_id;
            } else {
                $modEvaluasi->ruanganasal_id = $modPendaftaran->ruangan_id;
            }
            
            $modRuangan = RuanganM::model()->findByPk($modEvaluasi->ruanganasal_id);
            $modEvaluasi->ruangan_nama = $modRuangan->ruangan_nama;
            
            if(isset($_POST['EvaluasianestesiT'])) {
                 $transaction = Yii::app()->db->beginTransaction();
                 $ok = true;
                    try{
                        $modEvaluasi->attributes = $_POST['EvaluasianestesiT'];
                        $modEvaluasi->tglpemberiinformasi = MyFormatter::formatDateTimeFordb($modEvaluasi->tglpemberiinformasi);
                        $modEvaluasi->tglterimainformasi_walipasien= MyFormatter::formatDateTimeFordb($modEvaluasi->tglterimainformasi_walipasien);
                        $modEvaluasi->namawali_pasien = !empty($_POST['EvaluasianestesiT']['namawali_pasien']) ? $_POST['EvaluasianestesiT']['namawali_pasien'] : "";
                        $modEvaluasi->pegawai_pemberiinformasi_id = !empty($_POST['EvaluasianestesiT']['pegawai_pemberiinformasi_id']) ? $_POST['EvaluasianestesiT']['pegawai_pemberiinformasi_id'] : "";
                        $modEvaluasi->ruanganasal_id = !empty($_POST['EvaluasianestesiT']['ruanganasal_id']) ? $_POST['EvaluasianestesiT']['ruanganasal_id'] : "";
                        $modEvaluasi->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
			$modEvaluasi->update_time = date('Y-m-d H:i:s');
                        $ok = $ok && $modEvaluasi->save();

                        if ($ok){
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('index','pendaftaran_id' => $pendaftaran_id, 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'pasienanastesi_id'=>$modPasienAnestesi->pasienanastesi_id,'sukses'=>1));
                        }
                        else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                        }
                    } catch (Exception $ex) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
                    } 
            }
            $this->render($this->path_view.'index',array(
                'modPasienAnestesi'=>$modPasienAnestesi,
                'modEvaluasi'=>$modEvaluasi
            ));
        }
        
    
    /**
     * digunakan untuk cetak pdf dan print
     * @param type $pendaftaran_id integer
     * @param type $pasienkirimkeunitlain_id integer
     * @param type $pasienanastesi_id integer
     */
    public function actionPrint($pendaftaran_id, $pasienkirimkeunitlain_id, $pasienanastesi_id = null){
        $this->layout='//layouts/iframe';
        $modEvaluasi = new EvaluasianestesiT();
         if (empty($pasienanastesi_id)){
                $cekRencana = EvaluasianestesiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));
                $modEvaluasi = $cekRencana;
                
         }else{
                $cekRencana = EvaluasianestesiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienanastesi_id'=>$pasienanastesi_id));
                $modEvaluasi = $cekRencana;   
         }
         
         if (empty($modEvaluasi->tglpemberiinformasi)) {
                $modEvaluasi->tglpemberiinformasi = date('d M Y H:i:s');
                $modEvaluasi->tglterimainformasi_walipasien = date('d M Y H:i:s');
            } else {
                $modEvaluasi->tglpemberiinformasi = MyFormatter::formatDateTimeForUser($modEvaluasi->tglpemberiinformasi);
                $modEvaluasi->tglterimainformasi_walipasien = MyFormatter::formatDateTimeForUser($modEvaluasi->tglterimainformasi_walipasien);
            }
            
            $modPasienAnestesi = ATPasienanastesiT::model()->findByPk($pasienanastesi_id); 
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            
            if (!empty($modPendaftaran->pasienadmisi_id)) {
                $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
                $modEvaluasi->ruanganasal_id = $modAdmisi->ruangan_id;
            } else {
                $modEvaluasi->ruanganasal_id = $modPendaftaran->ruangan_id;
            }
            $modRuangan = RuanganM::model()->findByPk($modEvaluasi->ruanganasal_id);
            $modEvaluasi->ruangan_nama = $modRuangan->ruangan_nama;
       
        if(isset($_GET['print'])){
            $judulLaporan="PERNYATAAN PEMBERIAN INFORMASI
            DAN PERSETUJUAN TINDAKAN SEDASI & ANESTESI";
            
            if ($_GET['print'] == 'print') {
               $this->layout='//layouts/printWindows';
               $this->render('print', array('caraprint'=>$_GET['print'],'modPendaftaran'=>$modPendaftaran,'modPasienAnestesi'=>$modPasienAnestesi,'modEvaluasi'=>$modEvaluasi));
           } else if ($_GET['print'] == 'excel') {
               $this->layout = '//layouts/printExcel';
               $this->render('print', array('caraprint'=>$_GET['print'],'modPendaftaran'=>$modPendaftaran,'modPasienAnestesi'=>$modPasienAnestesi,'modEvaluasi'=>$modEvaluasi));
           } else if ($_GET['print'] == 'pdf') {
               $kertas = Params::getUkuranKertas();
               $mpdf = new MyPDF('', $kertas['F4']);
               $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait

               $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/csstindakananastesipdf.css');
               $mpdf->WriteHTML($stylesheet, 1);
               $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerTindakanAnastesi', array(), true));
               $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 10, 10, 10, 30, 10, 10);
               $mpdf->WriteHTML($this->renderPartial('print_pdf', array('caraprint'=>$_GET['print'],'modPendaftaran'=>$modPendaftaran,'modPasienAnestesi'=>$modPasienAnestesi,'modEvaluasi'=>$modEvaluasi), true));
               $mpdf->WriteHTML("<pagebreak>");
               $mpdf->WriteHTML($this->renderPartial('tabel_PrintPDF2', array('caraprint'=>$_GET['print'],'modPendaftaran'=>$modPendaftaran,'modPasienAnestesi'=>$modPasienAnestesi,'modEvaluasi'=>$modEvaluasi), true));
               $mpdf->WriteHTML("<pagebreak>");
               $mpdf->WriteHTML($this->renderPartial('tabel_PrintPDF3', array('caraprint'=>$_GET['print'],'modPendaftaran'=>$modPendaftaran,'modPasienAnestesi'=>$modPasienAnestesi,'modEvaluasi'=>$modEvaluasi), true));
               $mpdf->Output("document" . '_' . date('Y-m-d') . '.pdf', 'I');
           }
        }else{
            $this->render('print', array( 
                'modPasienAnestesi'=>$modPasienAnestesi,
                'modEvaluasi'=>$modEvaluasi));
        }
        
        
        
    }
}

