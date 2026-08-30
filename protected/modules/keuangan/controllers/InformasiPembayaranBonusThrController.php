<?php
class InformasiPembayaranBonusThrController extends MyAuthController
{
    protected $successSave = true;
    protected $pesan = "succes";
    protected $path_view = "keuangan.views.informasiPembayaranBonusThr.";

    public function actionIndex()
    {
        $model = new InformasipembayaranbonusthrV();
        $format = new MyFormatter();
        $model->tgl_awal=date('Y-m-d');
        $model->tgl_akhir=date('Y-m-d');
        $model->tglnyetor_awal=date('Y-m-d');
        $model->tglnyetor_akhir=date('Y-m-d');
        $model->ceklis = false;

        if(isset($_GET['InformasipembayaranbonusthrV'])){
            $model->attributes=$_GET['InformasipembayaranbonusthrV'];
            $model->ceklis = $_GET['InformasipembayaranbonusthrV']['ceklis'];
            $model->status_penyetoran = $_GET['InformasipembayaranbonusthrV']['status_penyetoran'];
            $model->status_pembatalan = $_GET['InformasipembayaranbonusthrV']['status_pembatalan'];
            $model->tgl_awal = $format->formatDateTimeForDB($_GET['InformasipembayaranbonusthrV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDB($_GET['InformasipembayaranbonusthrV']['tgl_akhir']);
            $model->tglnyetor_awal = $format->formatDateTimeForDB($_GET['InformasipembayaranbonusthrV']['tglnyetor_awal']);
            $model->tglnyetor_akhir = $format->formatDateTimeForDB($_GET['InformasipembayaranbonusthrV']['tglnyetor_akhir']);
        }

        $this->render($this->path_view.'index', array('model'=>$model));
    }

    public function actionRincian($tandabuktikeluar_id)
    {
        if(isset($_GET['caraPrint']) && ($_GET['caraPrint'] =="PRINT")){
            $this->layout = '//layouts/printWindows';
        }else{
            $this->layout = '//layouts/iframe';
        }

        $modBuktiKeluar = TandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);
    		$model = PembbonusthrT::model()->findByAttributes(array('tandabuktikeluar_id'=>$modBuktiKeluar->tandabuktikeluar_id));
    		$modDetail = PembbonusthrdetT::model()->findAllByAttributes(array('pembbonusthr_id'=>$model->pembbonusthr_id));

        $this->render($this->path_view.'_rincian', array(
            'modBuktiKeluar' => $modBuktiKeluar,
            'model' => $model,
            'modDetail' => $modDetail
        ));
	}

    public function actionPembatalanPembayaran()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $transaction = Yii::app()->db->beginTransaction();
            $pesan = 'success';
            $status = 'ok';
            $keterangan = "";

            $tandabuktikeluar_id = isset($_POST['tandabuktikeluar_id'])?$_POST['tandabuktikeluar_id']:null;
            $tglbatal = isset($_POST['tglbatal'])?$_POST['tglbatal']:null;
            $pegawaibatal_id = isset($_POST['pegawaibatal_id'])?$_POST['pegawaibatal_id']:null;
            $keterangan_batal = isset($_POST['keterangan_batal'])?$_POST['keterangan_batal']:null;

            $model = TandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);

            try{
                if(isset($model)){
                    $sukses = true;
                    $moddetails = PembbonusthrT::model()->findAllByAttributes(array('tandabuktikeluar_id'=>$tandabuktikeluar_id));

                    if(count((array)$moddetails) > 0){
                        foreach ($moddetails as $dataDet){
                            $modupdate = PembbonusthrT::model()->updateByPk($dataDet->pembbonusthr_id,array('tglbatalbayar'=> MyFormatter::formatDateTimeForDb($tglbatal),'pegawaibatal_id'=>$pegawaibatal_id,'alasanbatal'=>$keterangan_batal));

                            if(!$modupdate){
                                $sukses = false;
                            }
                        }
                    }
                    $deleteJurnal = true;

                    $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('tandabuktikeluar_id'=>$tandabuktikeluar_id));
                    if (isset($modJurnalBefore)){
                        foreach ($modJurnalBefore as $jurnalBef){
                            $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id'=>$jurnalBef->jurnalrekening_id));
                             if(count((array)$jurnaldetail)>0){
                                    foreach ($jurnaldetail as $jurnaldetBefor) {
                                        $jurnaldetBefor->delete();
                                    }
                                }
                                $deleteJurnal = $jurnalBef->delete();
                        }
                    }


                    if($sukses && $deleteJurnal){
                        $keterangan = "Data Berhasil Dibatalkan! ";
                        $status = 'ok';
                        $transaction->commit();
                    }else{
                        $keterangan = "Data Gagal Dibatalkan! ";
                        $status = 'not';
                        $transaction->rollback();
                    }
                }
            } catch (Exception $ex) {
                $keterangan = "Data Gagal Dibatalkan! ".print_r($ex);
                $status = 'not';
                $transaction->rollback();
            }

            $data['pesan'] = $pesan;
            $data['status'] = $status;
            $data['keterangan'] = $keterangan;

            echo json_encode($data);
            Yii::app()->end();
        }
    }
}
