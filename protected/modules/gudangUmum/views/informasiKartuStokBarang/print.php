<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
$this->widget('ext.bootstrap.widgets.BootGridView',array(
                                'id'=>'informasi-grid',
                                'dataProvider'=>$model->searchInformasiPrint(),
                                'template'=>"{items}",
                                'itemsCssClass'=>'table border',
                                'columns'=>array(
                                    array(
                                        'header'=>'Instalasi/<br>Ruangan',
                                        'name'=>'ruangan_nama',
                                        'type'=>'raw',
                                        'value'=>'$data->instalasi_nama."/<br>".$data->ruangan_nama',
                                    ),
                                    array(
                                        'name'=>'tgltransaksi',
                                        'header'=>'Tgl. Transaksi',
                                        'type'=>'raw',
                                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgltransaksi)',
                                        'htmlOptions'=>array('style'=>'text-align:right;'),
                                    ),
                                    'jenisbarang_nama',
                                    'barang_type',
                                    array(
                                        'header'=>'No. Transaksi',
                                        'type'=>'raw',
                                        'value'=>'$data->noTransaksi',
                                    ),
                                    array(
                                        'header'=>'Keterangan',
                                        'type'=>'raw',
                                        'value'=>'$data->keteranganTransaksi',
                                    ),
                                    
                                   
                                    
                                    'barang_kode',
                                    'barang_nama',
                                    array(
                                        'header'=>'Harga',
                                        'type'=>'raw',
                                        'value'=>'MyFormatter::formatNumberForPrint($data->inventarisasi_hargasatuan)',
                                        'htmlOptions'=>array(
                                            'style'=>'text-align: right;',
                                        ),
                                    ),
                                    array(
                                        'name'=>'qtystok_in',
                                        'value'=>'$data->qtystok_in." ".$data->barang_satuan',
                                        'htmlOptions'=>array(
                                            'style'=>'text-align: right',
                                        )
                                    ),
                                    array(
                                        'name'=>'qtystok_out',
                                        'value'=>'$data->qtystok_out." ".$data->barang_satuan',
                                        'htmlOptions'=>array(
                                            'style'=>'text-align: right',
                                        )
                                    ),
                                ),
                                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                            )); ?>
<script>
    window.print(); 
</script>

