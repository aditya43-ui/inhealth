<?php
/**
* - digunakan sebagai Informasi Kalibrasi
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>

<?php
class InformasiKalibrasiController extends MyAuthController
{    
    public function actionIndex(){
        
        
       
        $model = new InfoinvkalibrasiV('search');
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        if (isset($_GET['InfoinvkalibrasiV'])){
            $model->attributes = $_GET['InfoinvkalibrasiV'];            
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['InfoinvkalibrasiV']['tgl_awal']); 
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['InfoinvkalibrasiV']['tgl_akhir']);             
            $model->pelaksanadet_nama = isset($_GET['InfoinvkalibrasiV']['pelaksanadet_nama'])?$_GET['InfoinvkalibrasiV']['pelaksanadet_nama']:null;             
        }
        
        $this->render('index',
            array(
                'model'=>$model,
            )
        );
    }
    
    public function actionDetail($id){
        
        $model = InvkalibarasiT::model()->findByPk($id);
        $model->lokasiaset_namalokasi = !empty($model->lokasi->lokasiaset_namalokasi)?$model->lokasi->lokasiaset_namalokasi:'';               
        
        $modBarang = InvperalatanT::model()->findByPk($model->invperalatan_id);
        $modVendor = SupplierM::model()->findByPk($model->supplier_id);
        $modPegawai = PegawaiM::model()->findByPk($model->pegpelaksana_id);
        $model->invperalatan_nama = $modBarang->invperalatan_namabrg;
        $model->no_aset = $modBarang->invperalatan_kode;
        $model->tglkalibrasi = MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($model->tglkalibrasi)));
        $model->berlaku_sdtgl = MyFormatter::formatDateTimeForUser($model->berlaku_sdtgl);
        $model->peralatan_noseri = $modBarang->peralatan_noseri;
        
        if(!empty($modVendor)){
            $model->vendor_nama = $modVendor->supplier_nama;
        }else{
            $model->vendor_nama = '-';
        }

        $this->render('_detail',
            array(
                'model'=>$model,
            )
        );
    }
    
    public function actionDelete() {
		/*if (Yii::app()->request->isPostRequest) {
			$model = InvkalibarasiT::model()->findByPk($id);
			$model->delete();
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
         * */
        if(Yii::app()->request->isPostRequest)
        {
            $id = $_POST['id'];
            $load = $this->loadModel($id);
            $id_inv = $load->invperalatan_id;      
            
            $delAll = MAInvkalibrasidetT::model()->deleteAll(" invkalibrasi_id = ".$id);
            
            $load->delete();
            
            $up = MAInvkalibarasiT::model()->find(' invperalatan_id = '.$id_inv.' AND invkalibrasi_id != '.$id.' ORDER BY create_time DESC');
            if (!empty($up)){
                $up->is_aktif = true;
                $up->save();
            }
                        
            if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                        ));
                    exit;
                }
	                    
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
    
    public function loadModel($id)
	{
		$model=InvkalibarasiT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' . 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'. 'file_tidak_ditemukan.txt'));
        }
    }
}