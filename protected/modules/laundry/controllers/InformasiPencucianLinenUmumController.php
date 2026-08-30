<?php

class InformasiPencucianLinenUmumController extends MyAuthController {

    public $path_view = 'laundry.views.informasi.pencucianLinenUmum.';

    public function actionIndex() {
        $this->pageTitle = Yii::app()->name . " - Pencucian Linen";
        $format = new MyFormatter();
        $model = new LAInformasipencucianlinenumumV('searchInformasi');
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");

        if (isset($_GET['LAInformasipencucianlinenumumV'])) {
            $model->attributes = $_GET['LAInformasipencucianlinenumumV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LAInformasipencucianlinenumumV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LAInformasipencucianlinenumumV']['tgl_akhir']);
        }

        $this->render($this->path_view . 'index', array(
            'format' => $format,
            'model' => $model
        ));
    }

    public function actionDetail($id = null, $caraPrint = null) {
        $this->layout = 'iframe';

        $model = PencucianlinenumumT::model()->findByPk($id);
        $modDetail = PencucianlinenumumdetT::model()->findAllByAttributes(array('pencucianlinenumum_id' => $id));
        $modBahan = PencucianlinenumumbahanT::model()->findAllByAttributes(array('pencucianlinenumum_id' => $id));

        $this->layout = '//layouts/_auto';
        $target = $this->path_view . '_detailRincian';
        
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {            
            $this->render($target, array('model' => $model,  'caraPrint' => $caraPrint, 'modBahan' => $modBahan,'modDetail'=>$modDetail));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model,'caraPrint' => $caraPrint, 'modBahan' => $modBahan,'modDetail'=>$modDetail));
        } else if ($caraPrint == 'PDF') {
            $this->layout = '//layouts/_auto_pdf';
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);            
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/global-prinout-pdf.css');
            $mpdf->WriteHTML($stylesheet, 1);

            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model,'caraPrint' => $caraPrint,'modBahan' => $modBahan,'modDetail'=>$modDetail), true));
            $mpdf->Output('PencucianLinenUmum' . '_' . date('Y-m-d') . '.pdf', 'I');
        }else{
            $this->render($target, array(
                'model' => $model,
                'modDetail' => $modDetail,
                'modBahan' => $modBahan,
                'caraPrint' => $caraPrint
            ));
        }
    }

    public function actionBatal(){
        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['id'])?$_POST['id']:null;                        
            $trans = Yii::app()->db->beginTransaction();            
            try{
                PencucianlinenumumdetT::model()->deleteAll(" pencucianlinenumum_id = ".$id);
                PencucianlinenumumbahanT::model()->deleteAll(" pencucianlinenumum_id = ".$id);
                PencucianlinenumumT::model()->deleteByPk($id);
                
                $trans->commit();                
                $sukses = 1;
            }catch(Exception $e){
                $trans->rollback();
                $sukses = 0;
            }
            
            echo json_encode([
                'sukses'=>$sukses
            ]);            
        }
        exit;
    }

}
