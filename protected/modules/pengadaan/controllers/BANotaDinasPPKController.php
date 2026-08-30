<?php
/**
 * 
 * controller transaksi BA Nota Dinas PPK
 *
 * @package      application.modules.pengadaan
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Yusuf Putra Anugrah <yusufputra@.com> 
 * @author      Aida Rahmawati <aidarahmawati@.com> 
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class BANotaDinasPPKController extends MyAuthController
{	        
    public $defaultAction = 'index';
    public $path_view = 'pengadaan.views.bANotaDinasPPK.';
    public $init = '';        
    public $layout = '//layouts/iframe';
    
    /**
     * action ini digunakan sebagai halaman utama transaksi keseimbangan cairan
     * parameter yang digunakan dan wajib ada yaitu pendaftaran_id, untuk parameter pasienadmisi_id bersifat optional
     * @param type $publikasi_id
     */
    public function actionIndex($suratperjanjiankerja_id, $notadinasppk_id = null)
    {                                     
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $model = ADNotadinasppkT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        if (empty($notadinasppk_id)){
            $model = new ADNotadinasppkT();
            $model->notadinasppk_nomor = '-- Otomatis --';
            $model->notadinasppk_tanggal = date('d M Y H:i:s');
            $model->suratperjanjiankerja_id = $suratperjanjiankerja_id;
            $model->pegppk_id = $modSPK->pejabatpembuatkomitmen_id;
            $model->pegppk_nama = $modSPK->pejabatpembuatkomitmen->namaLengkap;
            $model->kepada = 'Tim Teknis Pengadaan Barang dan Jasa';
            $model->pekerjaan = $modSPK->namapekerjaan;
            $model->pegppk_nama = $model->pegppk->namaLengkap;
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id));
            $cekNota = ADNotadinasppkT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekNota)+1;
            $model->termin_jumlah = !empty($cekTermin) ? count($cekTermin) : 0;
            $model->termin_angka = !empty($cekNota) ? count($cekNota)+1 : 1;            
            $modTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id, 'urutan'=>$jumlahpemeriksaan));
            if(!empty($modTermin)){
                $model->terminke = $modTermin->terminke;
                $model->termin_persen = $modTermin->jumlah_persen;
                $model->total_pembayaran = $modTermin->jumlah_harga; 
            }
        }else{
            $model = ADNotadinasppkT::model()->findByPk($notadinasppk_id);
             $model->notadinasppk_tanggal = MyFormatter::formatDateTimeForUser($model->notadinasppk_tanggal);
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$model->suratperjanjiankerja_id));
            $model->termin_jumlah = !empty($cekTermin) ? count($cekTermin) : 0;
            
            $model->pegppk_nama = $model->pegppk->namaLengkap;
            
            if($model->terminke == 'I'){
                $model->termin_angka = 1;  
            }else if($model->terminke == 'II'){
                $model->termin_angka = 2;  
            }else if($model->terminke == 'III'){
                $model->termin_angka = 3;  
            }
        }
        
        if (isset($_POST['ADNotadinasppkT'])){                  
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();                        
            try{
                $model->attributes = $_POST['ADNotadinasppkT'];                
                $model->notadinasppk_tanggal = MyFormatter::formatDateTimeForDb($model->notadinasppk_tanggal);
                if (empty($model->notadinasppk_id)){
                    $model->notadinasppk_nomor = MyGenerator::NoNotaDinasPPK();
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
                    $this->redirect(array('index','suratperjanjiankerja_id'=>$suratperjanjiankerja_id,'notadinasppk_id'=>$model->notadinasppk_id,'sukses'=>1));       
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
            'modSPK' => $modSPK
        ));
    }
    
    /**
     * Cetak transaksi uji coba
     * @param type $id
     */
    public function actionPrint($id){
        $this->layout = '//layouts/printWindows';
        $model = ADNotadinasppkT::model()->findByPk($id);
        $modsurat= SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
        $modSupplier = SupplierM::model()->findByPk($modsurat->supplier_id);
        if(!empty($model->notadinasppk_id)){
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria1 = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            if ($modsurat->istermin == true) {
                $criteria->addCondition("konfigtemplatesurat_nama = 'Nota Dinas PPK - Termin'");
            } else {
                $criteria->addCondition("konfigtemplatesurat_nama = 'Nota Dinas PPK'");
            }
            $modTemplate1 = KonfigtemplatesuratK::model()->findAll($criteria);
            

            foreach ($modTemplate1 as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                   $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                   $isiPesan = str_replace("{{notadinasppk_tanggal}}", date('d', strtotime($model->notadinasppk_tanggal))." ".MyFormatter::getMonthId(date('m', strtotime($model->notadinasppk_tanggal))).date(' Y', strtotime($model->notadinasppk_tanggal)), $isiPesan);
                  
                   $isiPesan = str_replace("{{notadinasppk_supplier}}",$modSupplier->supplier_nama , $isiPesan);
                   $isiPesan = str_replace("{{nomor_dokumen_spk}}",$modsurat->nomor_dokumen , $isiPesan);
                }
                       
            }
            $model->dasar=$isiPesan;
            
        }
        $this->render('print', array('model' => $model,'modsurat' => $modsurat));
    }
    
    /**
     * Detail Nota Dinas PPK
     * @param type $id
     */
    public function actionDetail($id){
        $model = ADNotadinasppkT::model()->findByPk($id);
        $model->notadinasppk_tanggal = MyFormatter::formatDateTimeForUser($model->notadinasppk_tanggal);
        $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$model->suratperjanjiankerja_id));
        $model->termin_jumlah = !empty($cekTermin) ? count($cekTermin) : 0;
        $model->pegppk_nama = $model->pegppk->namaLengkap; 
        if($model->terminke == 'I'){
            $model->termin_angka = 1;  
        }else if($model->terminke == 'II'){
            $model->termin_angka = 2;  
        }else if($model->terminke == 'III'){
            $model->termin_angka = 3;  
        }
        $this->render('detail', array('model' => $model)); 
    }
    
    /**
     * Menampilkan tabel riwayat Penyerahan Barang dan Jasa
     */
    public function actionGetRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $_GET['suratperjanjiankerja_id'] = $_POST['suratperjanjiankerja_id'];
            $suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
            $modDetail = NotadinasppkT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $tr = '';
            if (!empty($modDetail)) {
                $i = 1;
                foreach($modDetail as $i => $data){
                    $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);     
                    if ($modSPK->istermin == true) {
                        $termin = $data->terminke . ' (' . $data->termin_persen . '%)';
                    } else {
                        $termin = 'Non Termin';
                    }
                    $urlDetail = $this->createUrl('detail', array('id' =>$data->notadinasppk_id));

                    $tr .= '<tr>';
                    $tr .= '<td>'. ($i+1) .'</td>';
                    $tr .= '<td>' . CHtml::link($data->notadinasppk_nomor, $urlDetail, array('title' => 'Detail', 'rel' => 'tooltip', "target" => "frame2", "onclick" => "$('#dialog2').dialog('open');")) . '</td>';
                    $tr .= '<td>'. $data->nomor_notadinas .'</td>';
                    $tr .= '<td>'. MyFormatter::formatDateTimeForUser($data->notadinasppk_tanggal) .'</td>';
                    $tr .= '<td>'. $termin .'</td>';
                    $tr .= '<td>'. $modSPK->namapekerjaan .'</td>';
                    $tr .= '<td>'. $data->pegppk->namaLengkap .'</td>';
                    $tr .= '<td> <div align=center>' . 
                            CHtml::link("<i class ='glyphicon glyphicon-pencil' style='font-size:12px;'> </i>", 
                            Yii::app()->createUrl('pengadaan/BANotaDinasPPK/index&suratperjanjiankerja_id=' . $suratperjanjiankerja_id . '&notadinasppk_id=' . $data->notadinasppk_id)) . 
                            '</div> </td>';
                    $tr .= '<td>' . CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip', 'onclick' => "window.open('" . $this->createUrl('print', array('id' => $data->notadinasppk_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')")) . '</td>';

                    $tr .= '</tr>';
                }
            }

            $data['tr'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }
}