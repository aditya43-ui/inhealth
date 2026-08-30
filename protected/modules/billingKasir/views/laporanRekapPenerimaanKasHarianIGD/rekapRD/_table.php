<h6> Tabel Rekapitulasi Penerimaan <b>Kas Harian IGD</b></h6>
<?php 
    $rim = '';
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $dataRD = $model->searchPenerimaanRD();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)){
      $sort = false;
      $dataRD = $model->searchPrintPenerimaanRD(); 
      $rim = '';
      $template = "{items}";
      if ($caraPrint == "EXCEL")
          $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
?>

<div>
    <div style="<?php echo $rim; ?>">
       <?php
        if(isset($caraPrint)){
       
        }else{
       ?>
       <?php } ?>
        <?php 
        $this->widget($table,array(
            'id'=>'laporanrekapkasharianigd-grid',
            'dataProvider'=>$dataRD,
            'enableSorting'=>$sort,
            'template'=>$template,
            'itemsCssClass'=>'table table-striped table-condensed',
             'mergeHeaders'=>array(
                    array(
                        'name'=>'<p style="margin: 0; text-align: center;">JENIS TARIF</p>',
                        'headerHtmlOptions'=>array('style'=>'background-color:#4bb1cf;'),
                        'start'=>1, 
                        'end'=>9, 
                    ),
                ),

            'columns'=>array( 
        array(
            'header' => 'No.',
            'value' => '$row+1',
			'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
        ),
        array(
            'header' => 'Tanggal',
            'value' => 'date("d/m/Y", strtotime($data->tglclosingkasir))',
        ),
        array(
            'header' => 'Instalasi',
            'name' => 'instalasi_nama',
            'type' => 'raw',
            'value' => '$data->instalasi_nama',
        ),
        array(
            'header' => 'Ruangan',
            'name' => 'ruangan_nama',
            'type' => 'raw',
            'value' => '$data->ruangan_nama',
            'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align:center;font-style:italic;'),
            'footer'=>'TOTAL',
        ),
        array(
            'header' => 'Kelas Pelayanan',
            'name' => 'kelaspelayanan_nama',
            'type' => 'raw',
            'value' => '$data->kelaspelayanan_nama',
        ),
//	RND-5836 field jasars hanya ada untuk tarakan saja (jasars komponen tarifnya tarakan)			
//        array(
//            'header' => 'Jasa RS',
//            'name' => 'jasars',
//            'type' => 'raw',
//            'value' => 'number_format($data->jasars)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalJasaRSRD(),0,"","."),
//        ),
//        array(
//            'header' => 'Jasa Pelayanan',
//            'name' => 'jasapelayanan',
//            'type' => 'raw',
//            'value' => 'number_format($data->jasapelayanan)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalPelayananRD(),0,"","."),
//        ),
//        array(
//            'header' => 'RFS',
//            'name' => 'rfs',
//            'type' => 'raw',
//            'value' => 'number_format($data->rfs)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalRFSRD(),0,"","."),
//        ),
//        array(
//            'header' => 'ADM',
//            'name' => 'adm',
//            'type' => 'raw',
//            'value' => 'number_format($data->adm)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalADMRD(),0,"","."),
//        ),
//        array(
//            'header' => 'RFS Gizi',
//            'name' => 'rfsgizi',
//            'type' => 'raw',
//            'value' => 'number_format(isset($data->rfsgizi) ? $data->rfsgizi:0)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format(isset($data->rfsgizi) ? $data->rfsgizi:0),
//        ),
//        array(
//            'header' => 'AMB',
//            'name' => 'amb',
//            'type' => 'raw',
//            'value' => 'number_format($data->amb)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalAMBRD(),0,"","."),
//        ),
//        array(
//            'header' => 'KONSUL',
//            'name' => 'konsul',
//            'type' => 'raw',
//            'value' => 'number_format($data->konsul)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalKonsulRD(),0,"","."),
//        ),        
//        array(
//            'header' => 'TOTAL',
//            'name' => 'total',
//            'type' => 'raw',
//            'value' => 'number_format($data->total)',
//            'footerHtmlOptions'=>array('style'=>'text-align:left;font-style:italic;'),
//            'footer'=>number_format($model->getTotalTotalRD(),0,"","."),
//        ),
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); 
        ?>
    </div>
    
</div>

<br>