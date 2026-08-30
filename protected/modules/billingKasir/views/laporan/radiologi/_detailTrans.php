<?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printDetailTransRad');
    $id_pendaftaran = $data['pendaftaran_id'];
?>
<script>
    function printDetail(params)
    {
        var url = <?php echo "'" . $urlPrint ."'";?>;
        var id_pendaftaran = <?php echo $id_pendaftaran;?>;
        window.open(url+"/"+$('#searchLaporan').serialize()+"&caraPrint="+params+"&id_pendaftaran="+id_pendaftaran,"",'location=_new, width=900px');
//        window.open(url"/$('#searchLaporan').serialize()+"&caraPrint="+params+"&id_pendaftaran="+id_pendaftaran,"",'location=_new, width=900px');
    }
</script>

<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = false;
    $dataProvider = $model->searchDetailTableRadiologi();
    $template = "{summary}\n{items}\n{pager}";
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tableLaporanTrans',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Tanggal Transaksi',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->tgl_tindakan))',
                ),
                array(
                    'header'=>'No. Transaksi',
                    'name'=>'no_pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_pendaftaran',
                ),
//                array(
//                    'header'=>'Kode Jenis',
//                    'type'=>'raw',
//                    'value'=>'$data->daftartindakan_kode',
//                ),
//                array(
//                    'header'=>'Nama Items',
//                    'type'=>'raw',
//                    'value'=>'$data->daftartindakan_nama',
//                ),
                array(
                    'header'=>'Harga',
                    'type'=>'raw',
                    'value'=>'number_format($data->tarif_tindakan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Harga P3',
                    'type'=>'raw',
                    'value'=>'number_format($data->subsidiasuransi_tindakan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Harga Lab',
                    'type'=>'raw',
                    'value'=>'number_format($data->tarif_rsakomodasi,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
             ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );
?>
<?php
    $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons'=>array(
            array(
                'label'=>'Print',
                'icon'=>'entypo-print',
                'url'=>"#",
                'htmlOptions'=>
                    array(
                        'onclick'=>'printDetail(\'PRINT\');return false;'
                    )
           ),
            array(
                'label'=>'',
                'items'=>array(
                    array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>"#", 'itemOptions'=>array('onclick'=>'printDetail(\'PDF\');return false;')),
                    array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>"#", 'itemOptions'=>array('onclick'=>'printDetail(\'EXCEL\');return false;')),
                )
            ),
        ),
    ));              
 ?>