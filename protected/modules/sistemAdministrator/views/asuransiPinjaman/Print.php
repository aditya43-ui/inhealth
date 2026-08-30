
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan , 'colspan'=>10));      
  $itemCssClass='table table-striped table-condensed';
  $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
        
        echo "
             <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass='table border';
        
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	 'id'=>'sapremiasuransi-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		////'asalaset_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->premiasuransi_id',
                        'filter'=>false,
                    ),
                    array(
                        'header'=>'Umur',
                        'value'=>'$data->umur',
                       // 'filter'=>Chtml::activeTextField($model, 'umur', array('class' => 'numbers-only', 'style'=>'text-align:right;')),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                    ),
                    array(
                        'header'=>'Tahun',
                        'value'=>'$data->tahun',
                      //  'filter'=>Chtml::activeTextField($model, 'tahun', array('class' => 'numbers-only', 'style'=>'text-align:right;')),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                    ),                    
                    array(
                        'header'=>'Persen',                        
                        'value' => 'str_replace(".",",",$data->persen);',
                      //  'filter'=>Chtml::activeTextField($model, 'persen', array('class' => 'comadesimal-only', 'style'=>'text-align:right;')),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                    ),  
            ),
    )); 
?>