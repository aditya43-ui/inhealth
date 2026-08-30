<?php 
    $rim = '';
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $dataRI = $model->searchPenerimaanRI();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)){
      $sort = false;
      $dataRI = $model->searchPrintPenerimaanRI(); 
      $rim = '';
      $template = "{items}";
      if ($caraPrint == "EXCEL")
          $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
?>

<div class="biru">
    <div class="white" style="<?php echo $rim; ?>">
       <?php
        if(isset($caraPrint)){
       
        }else{
       ?>
        <!--<legend class="rim"> Tabel Rekap Penerimaan Sejenis Rawat Inap </legend>-->
       <?php } ?>
        <?php 
        $this->widget($table,array(
            'id'=>'laporanrekapterimasejenisri-grid',
            'dataProvider'=>$dataRI,
            'enableSorting'=>$sort,
            'template'=>$template,
            'itemsCssClass'=>'table table-striped table-condensed',
             'mergeHeaders'=>array(
                    array(
                        'name'=>'<p style="margin: 0; text-align: center;">JENIS TARIF</p>',
                        'headerHtmlOptions'=>array('style'=>'background-color:#4bb1cf;'),
                        'start'=>2, 
                        'end'=>7, 
                    ),
                ),

            'columns'=>array( 
        array(
            'header' => 'No.',
            'value' => '$row+1'
        ),
        array(
            'header' => 'Ruangan / Nama',
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => '$data->ruangan_nama." / ".$data->nama_pasien',
            'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:center;font-style:italic;'),
            'footer'=>'TOTAL',
        ),
//	RND-5836 hanya ada untuk tarakan saja
//        array(
//            'header' => 'Jasa RS',
//            'name' => 'jasars',
//            'type' => 'raw',
//            'value' => 'number_format($data->jasars)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalJasaRSRI(),0,"","."),
//        ),
//        array(
//            'header' => 'Jasa Pelayanan',
//            'name' => 'jasapelayanan',
//            'type' => 'raw',
//            'value' => 'number_format($data->jasapelayanan)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalPelayananRI(),0,"","."),
//        ),
//        array(
//            'header' => 'RFS',
//            'name' => 'rfs',
//            'type' => 'raw',
//            'value' => 'number_format($data->rfs)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalRFSRI(),0,"","."),
//        ),
//        array(
//            'header' => 'ADM',
//            'name' => 'adm',
//            'type' => 'raw',
//            'value' => 'number_format($data->adm)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalADMRI(),0,"","."),
//        ),
//        array(
//            'header' => 'AMB',
//            'name' => 'amb',
//            'type' => 'raw',
//            'value' => 'number_format($data->amb)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalAMBRI(),0,"","."),
//        ),
//        array(
//            'header' => 'KONSUL',
//            'name' => 'konsul',
//            'type' => 'raw',
//            'value' => 'number_format($data->konsul)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalKonsulRI(),0,"","."),
//        ),
//        array(
//            'header' => 'TOTAL',
//            'name' => 'total',
//            'type' => 'raw',
//            'value' => 'number_format($data->total)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalTotalRI(),0,"","."),
//        ),
        array(
            'header' => 'RFS Gizi',
            'name' => 'rfsgizi',
            'type' => 'raw',
            'value' => 'number_format(isset($data->rfsgizi) ? $data->rfsgizi:0)',
            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
            'footer'=>number_format(isset($data->rfsgizi) ? $data->rfsgizi:0),
        ),
        array(
            'header' => 'KETERANGAN',
            'name' => 'carapembayaran',
            'type' => 'raw',
            'value' => '$data->carapembayaran',
            'footer'=>'&nbsp;',
        ),
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); 
        ?>
    </div>
    
</div>

<br>