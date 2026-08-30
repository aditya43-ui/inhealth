<?php 
    if(($tab)!='luar'){ 
        $model=$modelRS;
    }
    $itemCssClass = 'table table-striped table-condensed';
    //$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    if ($tab == 'luar'){
        $table = 'ext.bootstrap.widgets.BootGroupGridView';
    }else{
        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    }
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
        if ($caraPrint=='PDF') {
            if ($tab == 'luar'){
                $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
            }else{
                $table = 'ext.bootstrap.widgets.HeaderGroupGridViewPDF';                
            }
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
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass = 'table border';
    } else{
        $data = $model->searchTableLaporan();
        $template = "{summary}\n{items}\n{pager}";
    }
    ?>
<?php 
if ($tab == 'luar'){
?>
<div id="div_rujukanLuar">
    <?php
        if(isset($caraPrint)){
       
        }else{
       ?>
            <legend class="rim">Tabel Pemeriksaan Rujukan - Dari Luar</legend>
       <?php } ?>
        <?php $this->widget($table,array(
            'id'=>'tableRujukanLuar',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>$itemCssClass,
            'mergeColumns' => array(
                'no',
                'no_pendaftaran',
            ),            
            'columns'=>array(
                array(
                    'header' => '<center>No.</center>',
                    'name'=>'no',
                    'type'=>'raw',
                    'value' => $row,
                    'htmlOptions'=>array('style'=>'text-align:center'),
                    /*
                    'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Total',
                     * 
                     */
                ),
                 array(
                        'header' => '<center>Tanggal Masuk Penunjang</center>',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s", strtotime($data->tglmasukpenunjang)))',
                     ),
                array(
                    'header' => '<center>No. Pendaftaran Lab</center>',
                    'name'=>'no_pendaftaran',
                    'type'=>'raw',
                    'value' => '$data->no_pendaftaran'
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
                    'value' => 'number_format($data->tarif_satuan,0,"",".")',
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
<?php
}else{
?>
<div id="div_rujukanRS">
    <?php
        if(isset($caraPrint)){
       
        }else{
       ?>
            <legend class="rim">Tabel Pemeriksaan Rujukan RS</legend>
       <?php } ?>
        <?php $this->widget($table,array(
            'id'=>'tableRujukanRS',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>$itemCssClass,                 
            'columns'=>array(
                array(
                    'header' => '<center>No.</center>',
                    'name'=>'no',
                    'type'=>'raw',
                    'value' => $row,
                    'htmlOptions'=>array('style'=>'text-align:center'),
                    'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Total',
                    /*
                    'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Total',
                     * 
                     */
                ),
                 array(
                    'header' => '<center>Tanggal Masuk Penunjang</center>',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)'
                ),
                array(
                    'header' => '<center>No. Pendaftaran Lab</center>',
                    'type'=>'raw',
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => '<center>No Rekam Medik</center>',
                    'value' => '$data->no_rekam_medik'
                ),
                array(
                    'header' => '<center>Nama Pasien</center>',
                    'type'=>'raw',
                    'value' => '$data->namadepan." ".$data->nama_pasien'
                ),
                array(
                    'header' => '<center>Pelayanan</center>',
                    'type'=>'raw',
                    'value' => '$data->daftartindakan_nama'
                ),
                array(
                    'header' => '<center>Total</center>',
                    'name'=>'total',
                    'type'=>'raw',
                    'value' => 'number_format($data->total,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'sum(total)',
                ),
                array(
                    'header' => '<center>Bayar</center>',
                    'name'=>'jmlbayar_tindakan',
                    'type'=>'raw',
                    'value' => 'number_format($data->jmlbayar_tindakan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'sum(jmlbayar_tindakan)',
                ),
                array(
                    'header' => '<center>Sisa</center>',
                    'name'=>'jmlsisabayar_tindakan',
                    'type'=>'raw',
                    'value' => 'number_format($data->jmlsisabayar_tindakan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'sum(jmlsisabayar_tindakan)',
                ),
            ),
        )); ?> 
</div>
<?php
}
?>