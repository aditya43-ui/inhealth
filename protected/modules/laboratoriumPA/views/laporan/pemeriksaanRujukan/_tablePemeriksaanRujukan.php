<?php 
    $rim = 'width:600px;overflow-x:none;';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $data = $model->searchTableLaporan();
    $dataRS = $modelRS->searchTableLaporan();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)){
      $sort = false;
      $data = $model->searchPrintLaporan();
      $dataRS = $modelRS->searchPrintLaporan();
      $rim = '';
      $template = "{items}";
      if ($caraPrint == "EXCEL")
          $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
?>
<div id="div_rujukanLuar">
    <?php
        if(isset($caraPrint)){
       
        }else{
       ?>
            <legend class="rim">Table Pemeriksaan Rujukan - Dari Luar</legend>
       <?php } ?>
        <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
            'id'=>'tableRujukanLuar',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'mergeColumns' => array(
                'no',
                'no_pendaftaran',
            ),            
            'columns'=>array(
                array(
                    'header' => '<center>No.</center>',
                    'name'=>'no',
                    'type'=>'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'text-align:center'),
                    /*
                    'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Total',
                     * 
                     */
                ),
                array(
                    'header' => '<center>No. Pendaftaran Lab</center>',
                    'name'=>'no_pendaftaran',
                    'type'=>'raw',
                    'value' => '$data->no_pendaftaran'
                ),
                array(
                    'header' => '<center>Tanggal</center>',
                    'type'=>'raw',
                    'value' => '$data->tglmasukpenunjang'
                ),
                array(
                    'header' => '<center>Kode</center>',
                    'type'=>'raw',
                    'value' => '$data->daftartindakan_kode'
                ),
                array(
                    'header' => '<center>Jenis Pemeriksaan</center>',
                    'type'=>'raw',
                    'value' => '$data->daftartindakan_nama'
                ),
                array(
                    'header' => '<center>Tarif</center>',
                    'name'=>'tarif_satuan',
                    'type'=>'raw',
                    'value' => 'number_format($data->tarif_satuan)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    /*
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'sum(tarif_satuan)',
                     * 
                     */
                ),
            ),
        )); ?> 
</div>
<div id="div_rujukanRS">
    <legend class="rim">Table Pemeriksaan Rujukan - Dari RS</legend>
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
            'id'=>'tableRujukanRS',
            'dataProvider'=>$dataRS,
                'template'=>$template,
                'enableSorting'=>$sort,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                    'header' => '<center>No</center>',
                    'type'=>'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'text-align:center'),
                    'footerHtmlOptions'=>array('colspan'=>4,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Total',
                ),
                array(
                    'header' => '<center>No. Pendaftaran Lab</center>',
                    'type'=>'raw',
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => '<center>Nama Pasien</center>',
                    'type'=>'raw',
                    'value' => '$data->nama_pasien'
                ),
                array(
                    'header' => '<center>No. RM / Pelayanan</center>',
                    'type'=>'raw',
                    'value' => '$data->no_rekam_medik." / ".$data->daftartindakan_nama'
                ),
                array(
                    'header' => '<center>Total</center>',
                    'name'=>'total',
                    'type'=>'raw',
                    'value' => 'number_format($data->total)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'sum(total)',
                ),
                array(
                    'header' => '<center>Bayar</center>',
                    'name'=>'jmlbayar_tindakan',
                    'type'=>'raw',
                    'value' => 'number_format($data->jmlbayar_tindakan)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'sum(jmlbayar_tindakan)',
                ),
                array(
                    'header' => '<center>Sisa</center>',
                    'name'=>'jmlsisabayar_tindakan',
                    'type'=>'raw',
                    'value' => 'CustomFunction::FormatNumber($data->jmlsisabayar_tindakan)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'sum(jmlsisabayar_tindakan)',
                ),
            ),
        )); ?> 
</div>
