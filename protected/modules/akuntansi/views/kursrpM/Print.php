<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
    $template = "{summary}\n{items}\n{pager}";
    if (isset($caraPrint)){
        $template = "{items}";
    }
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');   
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));      

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-bordered datatable',
	'columns'=>array(
		////'kursrp_id',
		array(
				'header'=>'ID',
				'value'=>'$data->kursrp_id',
		),
		array(
				'name'=>'matauang_id',
				'value'=>'$data->matauang->matauang',
		),
		array(
				'name'=>'tglkursrp',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglkursrp)',
		),
		'nilai',
		'rupiah',
		array(
			'header'=>'Aktif',
			'value'=>' ($data->kursrp_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
		), 
	),
)); 
?>