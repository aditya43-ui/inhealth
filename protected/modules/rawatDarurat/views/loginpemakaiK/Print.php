<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sajenis-kelas-m-grid',
                'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    'nama_pemakai',
                    'katakunci_pemakai',
                    'lastlogin',
                    'tglpembuatanlogin',
                    'tglupdatelogin',
            array
                (
                        'name'=>'loginpemakai_aktif',
                        'type'=>'raw',
                        'value'=>'($data->loginpemakai_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
             ), 
              
	
    )); ?>
