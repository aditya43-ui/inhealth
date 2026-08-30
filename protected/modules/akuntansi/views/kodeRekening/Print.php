
<?php 


if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>4));      

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
	$itemCssClass='table table-bordered table-striped table-condensed';
    if (isset($caraPrint)){
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
		}
		if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDFNonRp';
        }
		$itemCssClass='table border';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
  ?>  

<?php
$this->widget($table,
    array(
        'id'=>'AKRekeningakuntansi-v',
        'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
        'columns'=>array(
            /*
            array(
              'header' => 'No.',
              'type'=>'raw',
              'value'=>'$row+1',
              'htmlOptions'=>array('style'=>'width:20px'),
              'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ), /*
            array(
               'header'=>'Kode Struktur',
               'type'=>'raw',
               'value'=>'$data->kdrekening1',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px;'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Kelompok',
               'type'=>'raw',
               'value'=>'$data->kdrekening2',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Jenis',
               'type'=>'raw',
               'value'=>'$data->kdrekening3',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Obyek',
               'type'=>'raw',
               'value'=>'($data->kdrekening4 == null ? "-" : $data->kdrekening4)',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ), */
            array(
               'header'=>'Kode Akun',
               'type'=>'raw',
               'value'=>'($data->kode == null ? "-" : $data->kode)',
               'htmlOptions'=>array('style'=>'width:80px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ), /*
            array(
               'header'=>'Nama Struktur',
               'type'=>'raw',
               'value'=>'isset($data->nmrekening1) ? $data->nmrekening1: "-"',
               'htmlOptions'=>array('style'=>'width:80px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ), 
            array(
               'header'=>'Nama Kelompok',
               'type'=>'raw',
               'value'=>'isset($data->nmrekening2) ? $data->nmrekening2: "-"',
               'htmlOptions'=>array('style'=>'width:80px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Nama Jenis',
               'type'=>'raw',
               'value'=>'isset($data->nmrekening3) ? $data->nmrekening3: "-"',
               'htmlOptions'=>array('style'=>'width:80px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Nama Obyek',
               'type'=>'raw',
               'value'=>'isset($data->nmrekening4) ? $data->nmrekening4 : "-"',
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
             * 
             */
            array(
               'header'=>'Nama Akun',
               'type'=>'raw',
               'value'=>function($data) {
                    $tab = "";
                    switch($data->akun) {
                        //case 2: $tab = "&emsp;"; break;
                        //case 3: $tab = "&emsp;&emsp;"; break;
                        //case 4: $tab = "&emsp;&emsp;&emsp;"; break;
                        //case 5: $tab = "&emsp;&emsp;&emsp;&emsp;"; break;
						case 2: $tab = ""; break;
                        case 3: $tab = ""; break;
                        case 4: $tab = ""; break;
                        case 5: $tab = ""; break;
                        default: $tab = "";
                    }
                    return $tab.$data->nama;
               }, //'isset($data->nama) ? $data->nama: "-"',
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Saldo Normal',
               'type'=>'raw',
               'value'=>'($data->saldo_normal == null ? "" : ($data->saldo_normal == "D" ? "Debit" : "Kredit"))',
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ), /*
            array(
               'header'=>'Kelompok Rekening',
               'type'=>'raw',
               'value'=>'($data->kelompokrek == null ? "-" : $data->kelompokrek)',
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
             * 
             */
            array(
               'header'=>'keterangan',
               'type'=>'raw',
			   'value'=>function ($data){
				   if (strtolower($data->keterangan) == 'null'){
					   return '';
				   }
			   },
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ), /*
            array(
               'header'=>'Status',
               'type'=>'raw',
               'value'=>'($data->aktif == null ? "-" : ($data->aktif == true ? "Aktif" : "Non Aktif"))',
               'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ), */
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )
);
?>