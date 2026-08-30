<?php

/**
 * 
 *   @author	Rusdiyanto <rusdiyanto@.com>
 *   @website	<.com>
 */
class KalibrasiController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'manajemenAset.views.kalibrasi.';

    public function actionIndex() {

        $model = new MAInvkalibarasiT();
        $model->nokalibrasi = '-- Otomatis --';
        
        $modDet = new MAInvkalibrasidetT;

        $modRiwayatKalibarasi = array();
        if (isset($_GET['id'])) {
            $modRiwayatKalibarasi = MAInvkalibarasiT::model()->findAll('invperalatan_id=' . $_GET['id']);
        }
        /**
         * @auhor   M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
         * - digunakan untuk membedakan mana transaksi yang menggunakan iframe mana yang tidak
         */
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
            $load = InvperalatanT::model()->findByPk($_GET['id']);
            $model->invperalatan_id = $load->invperalatan_id;
            $model->invperalatan_kode = $load->invperalatan_kode;
            $model->invperalatan_namabrg = $load->invperalatan_namabrg;
            $model->peralatan_noseri =  $load->peralatan_noseri;
            $model->lokasi_id = $load->lokasi_id;


            $modRiwayatKalibarasi = new MAInvkalibarasiT;
            $modRiwayatKalibarasi->invperalatan_id = $model->invperalatan_id;
//            $modRiwayatKalibarasi->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }

        $model->tglkalibrasi = date('Y-m-d H:i:s');
        $model->berlaku_sdtgl = date('Y-m-d');
        $format = new MyFormatter();



        if (isset($_POST['MAInvkalibarasiT'])) {
            $ok = true;
            $pesan = '';
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['MAInvkalibarasiT'];
                $model->nokalibrasi = MyGenerator::noInvKalibrasi();
                $model->tglkalibrasi = $format->formatDateTimeForDb($_POST['MAInvkalibarasiT']['tglkalibrasi']);
                $model->berlaku_sdtgl = $format->formatDateTimeForDb($_POST['MAInvkalibarasiT']['berlaku_sdtgl']);
                $model->create_time = date('Y-m-d H:i:s');
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->lampiran_berkas = CUploadedFile::getInstance($model, 'lampiran_berkas');
                $model->lokasi_id = !empty($model->invperalatan->lokasi_id) ? $model->invperalatan->lokasi_id : null;
                $model->ruangan_id = !empty($model->invperalatan->ruangan_id) ? $model->invperalatan->ruangan_id : null;
                
                if (!empty($model->lampiran_berkas)) {
                    $filePDF = $model->lampiran_berkas;
                    $fileName = $model->lampiran_berkas;
                    $filePath = ParamsUrl::pathKalibrasiPdfDirectory() . $fileName;
                    
                    if (!file_exists(ParamsUrl::pathKalibrasiPdfDirectory())){
                         mkdir(ParamsUrl::pathKalibrasiPdfDirectory(), 0755, true);
                    }
                    
                    $filePDF->saveAs($filePath);
                }

                $ok = $ok && $model->save();

                $up = MAInvkalibarasiT::model()->updateAll([
                    'is_aktif' => false
                        ], " is_aktif = TRUE AND invperalatan_id = " . $model->invperalatan_id . " AND invkalibrasi_id != " . $model->invkalibrasi_id . " ");

                if (isset($_POST['MAInvkalibrasidetT'])){
                    $psn = '';
                    foreach($_POST['MAInvkalibrasidetT'] as $det){
                        $modPeg = new MAInvkalibrasidetT;
                        $modPeg->attributes = $det;
                        $modPeg->invkalibrasi_id = $model->invkalibrasi_id;
                        
                        $ok &= $modPeg->save();
                        
                        if (!$ok){
                            $psn .= MyExceptionMessage::getErrorMessage($modPeg);
                        }
                    }
                    
                    $pesan .= '<br/>Inv Kalibrasi Pegawai : <br/>'.$psn;
                }
                

                if ($ok) {



                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    if (!isset($_GET['frame'])) {
                        $this->redirect(array('index', 'sukses' => 1, 'id' => $model->invperalatan_id));
                    } else {
                        $this->redirect(array('index', 'sukses' => 1, 'frame' => 'frame', 'id' => $_GET['id']));
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modRiwayatKalibarasi' => $modRiwayatKalibarasi,
            'format' => $format,
            'modDet' => $modDet
        ));
    }

    /**
     * @author  Yusuf Putra Anugrah<yusufputra@.com>
     * @version 2.0.0
     * @issue   RSST-1810
     * -digunakan untuk mmendownload file yang di upload, hanya berlaku pada kalibrasi yang ada di transaksi detail peralatan via iframe
     */
    public function actionUnduh($id) {

        $filename = InvkalibarasiT::model()->findByPk($id);

        $path = Params::pathKalibrasiPdfDirectory() . $filename->lampiran_berkas;

        if (!empty($filename->lampiran_berkas)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->lampiran_berkas, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/file_tidak_ditemukan.txt'));
        }
    }

    /**
     * @author  Yusuf Putra Anugrah<yusufputra@.com>
     * @version 2.0.0
     * @issue   RSST-1810
     * -digunakan untuk menghapus data inv kalibrasi yang sudah disimpan, hanya berlaku pada kalibrasi yang ada di transaksi detail peralatan via iframe
     */
    public function actionDelete() {
        if (Yii::app()->request->isAjaxRequest) {

            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $id = $_POST['id'];
                $model = MAInvkalibarasiT::model()->findByPk($id);

                $inv_id = $model->invperalatan_id;
                
                $temp_image = $model->lampiran_berkas;
                if (!empty($temp_image)) {                    
                    if (file_exists(Params::pathKalibrasiPdfDirectory() . $temp_image)) {
                        unlink(Params::pathKalibrasiPdfDirectory() . $temp_image);
                    }
                }
                
                $ok &= $model->delete();

                $cri = new CDbCriteria();
                $cri->addCondition(" invperalatan_id = '".$inv_id."' AND invkalibrasi_id != ".$id." ");
                $cri->order = " invkalibrasi_id DESC ";
                $load = MAInvkalibarasiT::model()->find($cri);                   
                if (!empty($load)){
                    $load->is_aktif = true;                    
                    $load->update_time = date('Y-m-d H:i:s');
                    $load->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $load->islaikpakai = ($load->islaikpakai)?true:false;                    
                    $load->update();
                }
                                
                if ($ok) {
                     $trans->commit();
                    $data['status'] = 'sukses';
                } else {
                     $trans->rollback();
                    $data['status'] = 'gagal';
                }
            }catch(Exeption $e){
                $trans->rollback();
                $data['status'] = 'gagal';
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal dihapus.');
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionGetInvPeralatan() {
        if (Yii::app()->request->isAjaxRequest) {
            $invperalatan_id = $_POST['invperalatan_id'];
            $format = new MyFormatter();
            $modRiwayatKalibarasi = MAInvkalibarasiT::model()->findAll('invperalatan_id =' . $invperalatan_id);

            $tr = $this->renderPartial($this->path_view . 'detailRiwayat', array(
                'modRiwayatKalibarasi' => $modRiwayatKalibarasi,
                'format' => $format
                    ), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

}
