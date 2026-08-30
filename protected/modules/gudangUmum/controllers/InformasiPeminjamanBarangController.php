<?php
/**
 * Digunakan untuk mengakases Informasi Peminjaman Barang di modul Gudang Umum
 * @author Aida Rahmawati<aidarahmawati@.com>
 * @package application.modules.gudangUmum
 * @subpackage controllers
 */
class InformasiPeminjamanBarangController extends MyAuthController
{
    public $path_view = 'gudangUmum.views.informasiPeminjamanBarang.';
    
    /**
     * Load seluruh data Peminjaman Barang 
     */
    public function actionIndex() {
        $model = new GUPeminjamanbrgT();
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        if (isset($_GET['GUPeminjamanbrgT'])) {
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['GUPeminjamanbrgT']['tgl_awal']);;
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['GUPeminjamanbrgT']['tgl_akhir']);
            $model->pegpeminjam_nama =$_GET['GUPeminjamanbrgT']['pegpeminjam_nama'];
            $model->peminjamanbrg_nomor =$_GET['GUPeminjamanbrgT']['peminjamanbrg_nomor'];
            $model->ruangan_nama =$_GET['GUPeminjamanbrgT']['ruangan_nama'];
        }

        $this->render($this->path_view.'index',
                array(
                'model'=>$model, 
        ));
    }
    
    /**
     * Menampilkan detail peminjaman barang
     * @param type $id
     */
    public function actionDetail($id){
        $this->layout = '//layouts/iframe';
        $model = GUPeminjamanbrgT::model()->findByAttributes(array('peminjamanbrg_nomor' => $id));
        $this->render($this->path_view.'_detailIndex',
                array(
                    'model' => $model,
                ));
    }
    
    /**
     * Menyimpan pengembalian barang 
     * @param type $id
     */
    public function actionPengembalian($id){
        $this->layout = '//layouts/iframe';
        $model = PeminjamanbrgT::model()->findByAttributes(array('peminjamanbrg_nomor' => $id));
        $model->pegpengembali_id = $model->pegpeminjam_id;
        $model->pengembalian_tanggal = date('d M Y');
        if (isset($_POST['PeminjamanbrgT'])) {
            try {
                $modDet = PeminjamanbrgT::model()->findAllByAttributes(array('peminjamanbrg_nomor' => $id));
                foreach($modDet as $det){
                    $det->attributes = $det;
                    $det->peminjamanbrg_nomor = $id;
                    $det->pengembalian_tanggal = MyFormatter::formatDateTimeForUser($_POST['PeminjamanbrgT']['pengembalian_tanggal']);
                    $det->pengembalian_catatan = $_POST['PeminjamanbrgT']['pengembalian_catatan'];
                    $det->status_pengembalian = "DIKEMBALIKAN";
                    $det->pegpengembali_id = $_POST['PeminjamanbrgT']['pegpengembali_id'];
                    if ($det->save()) {
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->redirect(array('pengembalian','id'=>$id,'sukses'=>1));
                    } else {
                         Yii::app()->user->setFlash('error',"Data gagal disimpan !");
                    }
                }
            } catch (Exception $ex) {
                 Yii::app()->user->setFlash('error',"Data gagal disimpan !".MyExceptionMessage::getMessage($ex,true));
            }
        }
        $this->render($this->path_view.'pengembalian',
                array(
                    'model' => $model,
                ));
    }
}

