<?php
/**
 * 
 * controller transaksi publikasi
 *
 * @package      application.modules.gudangUmum
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class PeminjamanBarangController extends MyAuthController
{	        
    public $defaultAction = 'index';
    public $path_view = 'gudangUmum.views.peminjamanBarang.';
    public $init = '';        

    
    /**
     * action ini digunakan sebagai halaman utama transaksi keseimbangan cairan
     * parameter yang digunakan dan wajib ada yaitu pendaftaran_id, untuk parameter pasienadmisi_id bersifat optional
     * @param type $publikasi_id
     */
    public function actionIndex($peminjamanbrg_nomor=null)
    {                                     
        $model = new GUPeminjamanbrgT();
        $model->peminjamanbrg_tanggal = date('d M Y');
        $model->tanggal_awal = date('d M Y');
        $model->tanggal_akhir = date('d M Y');
        $model->peminjamanbrg_nomor = '-- Otomatis --';
        
        $modDet = null;
        
        if (!empty($peminjamanbrg_nomor)){
            $model = GUPeminjamanbrgT::model()->findByAttributes(array('peminjamanbrg_nomor' => $peminjamanbrg_nomor));
            $model->pegpeminjam_nama = $model->pegpeminjam->namaLengkap;
            $model->nip = $model->pegpeminjam->nomorindukpegawai;
            $model->jabatan_nama = (!empty($model->pegpeminjam->jabatan_id)?$model->pegpeminjam->jabatan->jabatan_nama:'');
            $model->namaunitkerja = (!empty($model->pegpeminjam->unitkerja_id)?$model->pegpeminjam->unitkerja->namaunitkerja:'');
            $model->ruangan_nama = $model->ruangan->ruangan_nama;
            
            $modDet = GUPeminjamanbrgT::model()->findAll(" peminjamanbrg_nomor = '".$peminjamanbrg_nomor."' ");
        }
        
        if (isset($_POST['GUPeminjamanbrgT'])){            
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['GUPeminjamanbrgT'];
                $model->peminjamanbrg_tanggal = MyFormatter::formatDateTimeForDb($model->peminjamanbrg_tanggal);
                $model->tanggal_awal = MyFormatter::formatDateTimeForDb($model->tanggal_awal);
                $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($model->tanggal_akhir);
                $model->peminjamanbrg_nomor = MyGenerator::NoPeminjamanBarang();                
                                
                foreach ($_POST['detail'] as $det){
                    $modDet = new GUPeminjamanbrgT();
                    $modDet->attributes = $model->attributes;
                    $modDet->attributes = $det;
                    $modDet->create_time = date('Y-m-d H:i:s');
                    $modDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modDet->create_ruangan = Yii::app()->user->getState('ruangan_id');

                    $ok = $ok && $modDet->save();                    
                }
                
                if($ok){                                                                                                                                                                                            
                    
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index','peminjamanbrg_nomor'=>$model->peminjamanbrg_nomor,'sukses'=>1));       
                }else{                             
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {                
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }       
            
            $modDet = null;
        }
        
        $this->render($this->path_view.'index',array(
            'model' => $model,            
            'modDet' => $modDet
        ));
    }    
}
