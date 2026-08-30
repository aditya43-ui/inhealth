<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

  $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
					array(
						'header' => 'No.',
						'value' => '$row+1',
					),
                    'nama_pemakai',
        
                    array(
                        'header'=>'Nama Login',
                        'value'=>'$data->nama_pemakai',
                        'filter'=>CHtml::activeTextField($model,'nama_pemakai'),
                    ),
           
					array(
						'name'=>'lastlogin',
						'value'=>'MyFormatter::formatDateTimeForUser($data->lastlogin)',
						'filter'=>false,
					),
             
                    array(
                        'header' => 'Status',
                        'value'=>'($data->loginpemakai_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),

              ),
	
    )); ?>
