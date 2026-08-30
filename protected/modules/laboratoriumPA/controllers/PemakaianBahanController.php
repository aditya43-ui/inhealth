<?php
Yii::import('laboratoriumPA.controllers.PemakaianBmhpController');
class PemakaianBahanController extends PemakaianBmhpController
{
    public $path_view = "laboratoriumPA.views.pemakaianBahan.";
    public $path_view_bmhp = "laboratoriumPA.views.pemakaianBmhp.";
    public $obatalkespasientersimpan = true; //dilooping
    
    public function actionPrint($pasienmasukpenunjang_id) 
    {
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;    
        $modPasienMasukPenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));     
        $modObatAlkesPasien = LBObatalkespasienT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));

        $judul_print = 'Pemakaian Bahan '.$modPasienMasukPenunjang->ruangan_nama;
        $this->render($this->path_view.'printPemakaianBahan', array(
                            'format'=>$format,
                            'judul_print'=>$judul_print,
                            'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                            'modObatAlkesPasien'=>$modObatAlkesPasien,
        ));
    }
	
	public function actionAddFormPemakaianBahan()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $idObatAlkes = (isset($_POST['idObatAlkes']) ? $_POST['idObatAlkes'] : null);
            $idDaftartindakan = (isset($_POST['idDaftartindakan']) ? $_POST['idDaftartindakan'] : "");
            $modObatAlkes = ObatalkesM::model()->findByPk($idObatAlkes);
            $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $persenjual = $this->persenJualRuangan();
            $modObatAlkes->hargajual = round($modObatAlkes->hargajual); //floor(($persenjual + 100 ) / 100 * $modObatAlkes->hargajual);
            $modObatAlkes->statusoa = Params::OA_STATUS_DIGUNAKAN;
            
            echo CJSON::encode(array(
                'pendaftaran_id'=>$pendaftaran_id,
                'namaObat'=>$modObatAlkes->obatalkes_nama,
                'form'=>$this->renderPartial('_formAddPemakaianBahan', array('modObatAlkes'=>$modObatAlkes,'modDaftartindakan'=>$modDaftartindakan,
                    'modPendaftaran'=>$modPendaftaran,
                    ), true),
                ));
            exit;               
        }
    }
    
    public function actionInformasi() {
        $model = new LBObatalkespasienT;
        $model->unsetAttributes();
		$format = new MyFormatter();
//        $model->tglAwal = date('Y-m-d').' 00:00:00';
//        $model->tglAkhir = date('Y-m-d').' 23:59:59';
		$model->tglAwal = date('Y-m-d');
		$model->tglAkhir = date('Y-m-d');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if (isset($_GET['LBObatalkespasienT'])) {
            $model->attributes = $_GET['LBObatalkespasienT'];
//            $model->tglAwal = MyFormatter::formatDateTimeForDb($_GET['LBObatalkespasienT']['tglAwal']).' 00:00:00';
//            $model->tglAkhir = MyFormatter::formatDateTimeForDb($_GET['LBObatalkespasienT']['tglAkhir'].' 23:59:59');            
            $model->tglAwal = $format->formatDateTimeForDb($_GET['LBObatalkespasienT']['tglAwal']);
            $model->tglAkhir = $format->formatDateTimeForDb($_GET['LBObatalkespasienT']['tglAkhir']);		
			$model->no_pendaftaran = $_GET['LBObatalkespasienT']['no_pendaftaran'];
            $model->no_rekam_medik = $_GET['LBObatalkespasienT']['no_rekam_medik'];
            $model->nama_pasien = $_GET['LBObatalkespasienT']['nama_pasien'];
            $model->carabayar_id = $_GET['LBObatalkespasienT']['carabayar_id'];
            $model->penjamin_id = $_GET['LBObatalkespasienT']['penjamin_id'];
            
            $model->jenisobatalkes_id = $_GET['LBObatalkespasienT']['jenisobatalkes_id'];
            $model->obatalkes_kategori = $_GET['LBObatalkespasienT']['obatalkes_kategori'];
            $model->obatalkes_golongan = $_GET['LBObatalkespasienT']['obatalkes_golongan'];
            $model->obatalkes_nama = $_GET['LBObatalkespasienT']['obatalkes_nama'];
            $model->prefix_pendaftaran = isset($_GET['LBObatalkespasienT']['prefix_pendaftaran'])?$_GET['LBObatalkespasienT']['prefix_pendaftaran']:'';
        }
        $this->render('laboratoriumPA.views.pemakaianBahan.informasi', array('model' => $model));
    }

 
}