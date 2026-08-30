<?php

class InformasiStockOpnameObatAlkesController extends MyAuthController
{
        public $defaultAction ='index';
        public $path_view ='gudangFarmasi.views.informasiStockOpnameObatAlkes.';

        public function actionIndex($linkHalaman = null)
        {
            $model=new GFInformasistokopnameV;
            $format = new MyFormatter();
            $model->tgl_awal  = date('Y-m-d');
            $model->tgl_akhir = date('Y-m-d');

            if(isset($_GET['GFInformasistokopnameV'])){
                $model->attributes=$_GET['GFInformasistokopnameV'];
                $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasistokopnameV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasistokopnameV']['tgl_akhir']);
            }

            if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(1286);

            $this->render($this->path_view.'index',array(
              'format' => $format,
              'model' => $model,
            'linkHalaman' => $linkHalaman
          ));
	}
	/**
	 * menampilkan link untuk print detail stock opname
	 * @return type
	 */
	public function getUrlPrint(){
		return $this->createUrl("stockOpnameObatAlkes/print");
	}

  public function actionBatalStockOpname() {
      if (!Yii::app()->request->isAjaxRequest) {
          Yii::app()->end();
      }

      $id = $_POST['id'];
      $ok = 1;
      $msg = "";

      $trans = Yii::app()->db->beginTransaction();
      try {
          $stokopname = StokopnamedetT::model()->findAllByAttributes(array('stokopname_id'=>$id));

          foreach ($stokopname as $det) {
            StokobatalkesT::model()->deleteAllByAttributes(array('stokopnamedet_id'=>$det->stokopnamedet_id));
            StokopnamedetT::model()->deleteByPk($det->stokopnamedet_id);
          }

          $jurnalOri = JurnalrekeningT::model()->findAllByAttributes(array('stokopname_id'=>$id));
          $checkjurnalPos = false;

          if(count((array)$jurnalOri) > 0){
            foreach ($jurnalOri as $orig) {
              $oriJurpos = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id'=>$orig->jurnalrekening_id),array('condition'=>'jurnalposting_id IS NOT NULL'));

              if(count((array)$oriJurpos)>0){
                $checkjurnalPos = true;
              }else{
                $delJurdet = JurnaldetailT::model()->deleteAllByAttributes(array('jurnalrekening_id'=>$orig->jurnalrekening_id));
                JurnalrekeningT::model()->deleteByPk($orig->jurnalrekening_id);
              }
            }
          }

          if($checkjurnalPos == true){
            $ok = 0;
             $msg = "Data Stock Opname gagal dibatalkan. Karena Jurnal Sudah Diposting.";
          }

          if ($ok == 1) {
              $delStok = StokopnameT::model()->deleteByPk($id);

              if($delStok == true){
                  $trans->commit();
              }
          } else {
              $trans->rollback();
          }
      } catch (Exception $ex) {
          $trans->rollback();
          $ok = 0;
          $msg = "Data Stock Opname gagal dibatalkan : ".$ex->getMessage();
      }

      echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
  }
}
