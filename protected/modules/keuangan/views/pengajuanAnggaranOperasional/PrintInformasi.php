<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
?>
<?php
if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent"> <?php echo $judulLaporan   ?> </div>
                        <br>
                <?php  
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->printSearchInformasi();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else if ($caraPrint == "PDF") {
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
    
} else {
    $data = $model->printSearchInformasi();
    $template = "{items}";
}

$this->widget($table, array(
    'id' => 'informasistokbarang-grid',
    'dataProvider' => $data,
    'template'=>"{items}",
    //	'filter'=>$model,
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns'=>array( 
    array(
            'header' => 'No.',				
            'filter' => false,
            'value' => '$row+1',
            'headerHtmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'header' => 'Tgl. Pengajuan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->pengajuanpetty_tgl)'
        ),
        array(
            'header' => 'No. Pengajuan',
            'type' => 'raw',
            'value' => '$data->pengajuanpetty_no',            	
        ),
        array(
            'header' => 'Ruangan',
             'type' => 'raw',
            'value' => '$data->ruangan_nama',
        ),
        array(
            'header' => 'Kategori',
            'type' => 'raw',
            'value' => '$data->pengajuanpetty_kategori'
        ),
        array(
            'header' => 'Alasan Pengajuan',
            'type' => 'raw',
            'value' => '$data->pengajuanpetty_untuk'
        ),
        array(
            'header' => 'Pegawai yang Mengajukan',
            'type' => 'raw',
            'value' => '$data->namaLengkapMengajukan'
        ),
        array(
            'header'=>'Pegawai Mengetahui',
            'type'=>'raw',
            'value' => function($data){
                return (isset($data->atasan_id)? $data->namaLengkapAtasan : "-");
            }
        ),
        array(
            'header'=>'Pegawai Menyetujui',
            'type'=>'raw',
            'value'=>function($data){
                return (isset($data->direktur_id)? $data->namaLengkapDirektur : "-");
            },
        ),
        array(
            'header'=>'Status',
            'type'=>'raw',
            'value'=>function($data){
                return $data->pengajuanpetty_status;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>   

<?php
}
if ($caraPrint == 'PDF'){
?>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
</div>
<div class="content">
     <br>
    <div class="judulcontent"> <?php echo $judulLaporan   ?> </div>
     <br>
<?php  
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->printSearchInformasi();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else if ($caraPrint == "PDF") {
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
    
} else {
    $data = $model->printSearchInformasi();
    $template = "{items}";
}

$this->widget($table, array(
    'id' => 'informasistokbarang-grid',
    'dataProvider' => $data,
    'template'=>"{items}",
    //	'filter'=>$model,
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns'=>array( 
    array(
            'header' => 'No.',				
            'filter' => false,
            'value' => '$row+1',
            'headerHtmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'header' => 'Tgl. Pengajuan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->pengajuanpetty_tgl)'
        ),
        array(
            'header' => 'No. Pengajuan',
            'type' => 'raw',
            'value' => '$data->pengajuanpetty_no',            	
        ),
        array(
            'header' => 'Ruangan',
             'type' => 'raw',
            'value' => '$data->ruangan_nama',
        ),
        array(
            'header' => 'Kategori',
            'type' => 'raw',
            'value' => '$data->pengajuanpetty_kategori'
        ),
        array(
            'header' => 'Alasan Pengajuan',
            'type' => 'raw',
            'value' => '$data->pengajuanpetty_untuk'
        ),
        array(
            'header' => 'Pegawai yang Mengajukan',
            'type' => 'raw',
            'value' => '$data->namaLengkapMengajukan'
        ),
        array(
            'header'=>'Pegawai Mengetahui',
            'type'=>'raw',
            'value' => function($data){
                return (isset($data->atasan_id)? $data->namaLengkapAtasan : "-");
            }
        ),
        array(
            'header'=>'Pegawai Menyetujui',
            'type'=>'raw',
            'value'=>function($data){
                return (isset($data->direktur_id)? $data->namaLengkapDirektur : "-");
            },
        ),
        array(
            'header'=>'Status',
            'type'=>'raw',
            'value'=>function($data){
                return $data->pengajuanpetty_status;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>
</div>
<div class="">
</div>
<?php
}

 ?>