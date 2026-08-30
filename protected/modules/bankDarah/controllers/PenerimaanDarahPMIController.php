<?php

/**
 * Form Penerimaan Darah dari UTD PMI
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class PenerimaanDarahPMIController extends MyAuthController
{
    public $path_view = "application.modules.bankDarah.views.penerimaanDarahPMI.";
    
    /**
     * Autocomplete data permintaan darah yang belum dilakukan penerimaan.
     * 
     * @param string $term Nomor Permintaan yang Dicari.
     */
	public function actionAutocompletePermintaanDarah($term = "")
	{
		if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $mod = new BDPermintaandarahpmiT;
        $mod->no_permintaan = $term;
        $prov = $mod->searchDialogUntukPenerimaan();
        
        $res = array();
        foreach ($prov->data as $data) {
            $sub = $data->attributes;
            $sub['label'] = $data->no_permintaan." - ".MyFormatter::formatDateTimeForUser($data->tgl_permintaan);
            $sub['value'] = $data->permintaandarahpmi_id;
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
	}

    /**
     * Menampilkan dan menginput form Penerimaan Darah dari UTD PMI
     * Jika sukses di-submit maka akan di-redirect dengan data submit yang
     * di-load.
     * 
     * @param integer $id ID dari penerimaandarahpmi_t
     * @param integer $permintaandarahpmi_id ID dari permintaandarahpmi_t
     */
	public function actionIndex($id = null, $permintaandarahpmi_id = null)
	{
        $permintaan = new PermintaandarahpmiT;
        $model = new PenerimaandarahpmiT;
        
        $model->tgl_penerimaan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->no_penerimaan = '-- Otomatis --';
        $model->petugas_penerima_id = Yii::app()->user->getState('pegawai_id');
        $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->petugas_penerima_nama = $pegawai->namaLengkap;
        if (!empty($permintaandarahpmi_id)) {
            $permintaan = PermintaandarahpmiT::model()->findByPk($permintaandarahpmi_id);
            $permintaan->tgl_permintaan = MyFormatter::formatDateTimeForUser($permintaan->tgl_permintaan);
            
            if (!empty($permintaan->petugas_id)) {
                $mod = PegawaiM::model()->findByPk($permintaan->petugas_id);
                $permintaan->petugas_nama = $mod->nama_pegawai;
            }
            
            if (!empty($permintaan->instalasi_id)) {
                $mod = InstalasiM::model()->findByPk($permintaan->instalasi_id);
                $permintaan->instalasi_nama = $mod->instalasi_nama;
            }
            
            if (!empty($permintaan->ruangan_id)) {
                $mod = RuanganM::model()->findByPk($permintaan->ruangan_id);
                $permintaan->ruangan_nama = $mod->ruangan_nama;
            }
        }
        
        if (!empty($id)) {
            $model = PenerimaandarahpmiT::model()->findByPk($id);
            if (!empty($model->permintaandarahpmi_id)) {
                $permintaan = PermintaandarahpmiT::model()->findByPk($model->permintaandarahpmi_id);
                $permintaan->tgl_permintaan = MyFormatter::formatDateTimeForUser($permintaan->tgl_permintaan);
                
                if (!empty($permintaan->petugas_id)) {
                    $peg = PegawaiM::model()->findByPk($permintaan->petugas_id);
                    $permintaan->petugas_nama = $peg->nama_pegawai;
                }
                
                if (!empty($permintaan->instalasi_id)) {
                    $instalasi = InstalasiM::model()->findByPk($permintaan->instalasi_id);
                    $permintaan->instalasi_nama = $instalasi->instalasi_nama;
                    
                }
                if (!empty($permintaan->ruangan_id)) {
                    $instalasi = RuanganM::model()->findByPk($permintaan->ruangan_id);
                    $permintaan->ruangan_nama = $instalasi->ruangan_nama;
                    
                }
            }
            
            $model->tgl_penerimaan = MyFormatter::formatDateTimeForUser($model->tgl_penerimaan);
            if(substr($model->suhu_diterima, -2) == 00){
                $model->suhu_diterima = $model->suhu_diterima;
            }else{
                $model->suhu_diterima = substr($model->suhu_diterima, 0, -2).','.substr($model->suhu_diterima, -2);
            }
        }
        
        if (isset($_POST['PenerimaandarahpmiT']) && isset($_POST['detail'])) {
            $trans = Yii::app()->db->beginTransaction();
            
            try {
                if ($model->savePenerimaanDarahPMI($_POST)) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index','id'=>$model->penerimaandarahpmi_id, 'sukses'=>1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
                }
            } catch (CException $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data Gagal Disimpan ".MyExceptionMessage::getMessage($e,true));
                
            }
        }
        
		$this->render($this->path_view.'index', array(
            'model'=>$model,
            'permintaan'=>$permintaan,
            'permintaandarahpmi_id'=>$permintaandarahpmi_id,
        ));
	}
    
    
    /**
     * Ajax untuk load baris detail penerimaan berdasarkan detail permintaan
     * darah.
     */
    public function actionSetLoadPermintaan() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        
        $model = BDPermintaandarahpmiT::model()->findByPk($_POST['id']);
        $detail = BDPermintaandarahpmidetT::model()->findAllByAttributes(array(
            'permintaandarahpmi_id'=>$model->permintaandarahpmi_id,
        ));
        
        $res = $model->attributes;
        $res['instalasi_nama'] = null;
        $res['ruangan_nama'] = null;
        $res['nama_petugas'] = null;
        $res['tgl_permintaan'] = MyFormatter::formatDateTimeForUser($model->tgl_permintaan);
        $res['row'] = "";
        
        if (!empty($model->instalasi_id)) {
            $modInstalasi = InstalasiM::model()->findByPk($model->instalasi_id);
            $res['instalasi_nama'] = $modInstalasi->instalasi_nama;
        }
        
        if (!empty($model->ruangan_id)) {
            $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);
            $res['ruangan_nama'] = $modRuangan->ruangan_nama;
        }
        
        if (!empty($model->petugas_id)) {
            $modPegawai = PegawaiM::model()->findByPk($model->petugas_id);
            $res['nama_petugas'] = $modPegawai->nama_pegawai;
        }
        
        $str = "";
        
        foreach ($detail as $idx => $item) {
            $jenis = JeniskomponendarahM::model()->findByPk($item->jeniskomponendarah_id);
            
            $str .= $this->renderPartial($this->path_view."form/_rowDarah", array(
                'item'=>$item,
                'cnt'=>($idx + 1),
                'jenis'=>$jenis,
            ), true);
        }
        
        
        $res['row'] = $str; 
        
        
        echo CJSON::encode($res);
    }
    
    /**
     * Autocomplete pencarian untuk Petugas Penerima di Ruangan Transfusi.
     * 
     * @param string $term Nama Pegawai yang dicari
     */
    public function actionAutocompletePetugasPenerima($term) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $peg = new BDPegawairuanganV;
        $peg->nama_pegawai = $term;
        $peg->ruangan_id = Params::RUANGAN_TRANSFUSI_DARAH;
        
        $prov = $peg->search();
        
        $res = array();
        foreach ($prov->data as $data) {
            $sub = $data->attributes;
            $sub['label'] = $data->nama_pegawai." - ".$data->nomorindukpegawai;
            $sub['value'] = $data->pegawai_id;
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
    }
    
    /**
     * Autocomplete pencarian untuk Petugas Mengetahui di Ruangan Transfusi.
     * 
     * @param string $term Nama Pegawai yang dicari
     */
    public function actionAutocompletePetugasMengetahui($term) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $peg = new BDPegawairuanganV;
        $peg->nama_pegawai = $term;
        $peg->ruangan_id = Params::RUANGAN_TRANSFUSI_DARAH;
        
        $prov = $peg->search();
        
        $res = array();
        foreach ($prov->data as $data) {
            $sub = $data->attributes;
            $sub['label'] = $data->nama_pegawai." - ".$data->nomorindukpegawai;
            $sub['value'] = $data->pegawai_id;
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
    }
    
    /**
         * fungsi untuk print
         */
        public function actionPrint()
        {
            $model = new PenerimaandarahpmiT;
            $penerimaandarahpmi_id = (isset($_GET['id']) ? $_GET['id'] : null);
            $modPenerimaanDarah = PenerimaandarahpmiT::model()->findByPk($penerimaandarahpmi_id);
            $modDetailPenerimaan = PenerimaandarahpmidetT::model()->findAllByAttributes(array('penerimaandarahpmi_id'=>$penerimaandarahpmi_id));
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'Print',array('modPenerimaanDarah'=>$modPenerimaanDarah,'model'=>$model,'modDetailPenerimaan'=>$modDetailPenerimaan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF60('',$ukuranKertasPDF); 
                // $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiTransfusi',array( 'colspan'=>10),true));
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('modPenerimaanDarah'=>$modPenerimaanDarah,'model'=>$model,'modDetailPenerimaan'=>$modDetailPenerimaan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }
    
}