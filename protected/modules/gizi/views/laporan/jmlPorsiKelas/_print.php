<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

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
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
                        <br>
                <?php $itemsCssClass="table table-striped table-condensed";
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
          $itemsCssClass='table border';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php 
        $kelas = KelaspelayananM::model()->findAll('kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama');
                
        $columns =array();
        $columns = array(
                array(
                    'header'=>'No.',
                    'value' => $row,
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                ),
                 array(
                        'header' => 'Jenis Diet',
                        'value' => '$data->jenisdiet_nama',
                        'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>'JUMLAH',                        
                    ),
            );
        
        foreach($kelas as $kelas):
            
            $columns[] = array(
                'header'=>$kelas->kelaspelayanan_nama,
                'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),'.$kelas->kelaspelayanan_id.'),0,"",".")',
                'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),$kelas->kelaspelayanan_id),0,"","."),
            );
        endforeach;
        $columns[] =  array(
                        'header' => 'Jumlah',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"JML"))',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("kelas"),"TOTAL")),
                    );
        $columns[] = array(
                        'header' => '(%)',
                        'value' => '"-"',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>'-',
                    );
       
        $this->widget($table,array(
            'id'=>'tableLaporan',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>$itemsCssClass,
            'columns'=> $columns,
         
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));?>
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
    <div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
     <br>
<?php $itemsCssClass="table table-striped table-condensed";
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
          $itemsCssClass='table border';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php 
        $kelas = KelaspelayananM::model()->findAll('kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama');
                
        $columns =array();
        $columns = array(
                array(
                    'header'=>'No.',
                    'value' => $row,
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                ),
                 array(
                        'header' => 'Jenis Diet',
                        'value' => '$data->jenisdiet_nama',
                        'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>'JUMLAH',                        
                    ),
            );
        
        foreach($kelas as $kelas):
            
            $columns[] = array(
                'header'=>$kelas->kelaspelayanan_nama,
                'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),'.$kelas->kelaspelayanan_id.'),0,"",".")',
                'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),$kelas->kelaspelayanan_id),0,"","."),
            );
        endforeach;
        $columns[] =  array(
                        'header' => 'Jumlah',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"JML"))',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("kelas"),"TOTAL")),
                    );
        $columns[] = array(
                        'header' => '(%)',
                        'value' => '"-"',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>'-',
                    );
       
        $this->widget($table,array(
            'id'=>'tableLaporan',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>$itemsCssClass,
            'columns'=> $columns,
         
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));?>
</div>

<?php
}
if ($caraPrint == 'GRAFIK'){
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
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?> </div>
                        <br>
                        <?php  $itemsCssClass="table table-striped table-condensed";
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
          $itemsCssClass='table border';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php 
        $kelas = KelaspelayananM::model()->findAll('kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama');
                
        $columns =array();
        $columns = array(
                array(
                    'header'=>'No.',
                    'value' => $row,
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                ),
                 array(
                        'header' => 'Jenis Diet',
                        'value' => '$data->jenisdiet_nama',
                        'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>'JUMLAH',                        
                    ),
            );
        
        foreach($kelas as $kelas):
            
            $columns[] = array(
                'header'=>$kelas->kelaspelayanan_nama,
                'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),'.$kelas->kelaspelayanan_id.'),0,"",".")',
                'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),$kelas->kelaspelayanan_id),0,"","."),
            );
        endforeach;
        $columns[] =  array(
                        'header' => 'Jumlah',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"JML"))',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("kelas"),"TOTAL")),
                    );
        $columns[] = array(
                        'header' => '(%)',
                        'value' => '"-"',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>'-',
                    );
       
        $this->widget($table,array(
            'id'=>'tableLaporan',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>$itemsCssClass,
            'columns'=> $columns,
         
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));?>
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
?>