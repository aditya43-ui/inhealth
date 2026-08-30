<?php
    $itemCssClass = 'table table-bordered table-striped table-condensed';
    $data = $model->searchLaporanCarabayar();
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $template = "{summary}\n{items}\n{pager}";
    if(isset($caraPrint)){
        $data = $model->searchPrintLaporanCarabayar();
        $template = '{items}';
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
        if ($caraPrint=='PDF') {         
            $table = 'ext.bootstrap.widgets.HeaderGroupGridViewPDF';                            
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
    }
        
    $this->widget($table,
        array(
            'id'=>'tableGroupPemeriksaanCaraBayar',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>true,
            'itemsCssClass'=>$itemCssClass,
            'columns'=>array(
                array(
                    'header' => '<center>No.</center>',
                    'type'=>'raw',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                    'htmlOptions'=>array(
                        'style'=>'text-align:center'
                    ),
                    'footerHtmlOptions'=>array(
                        'colspan'=>7,
                        'style'=>'text-align:right;font-style:italic;'
                    ),
                    'footer'=>'Total',
                ),
                array(
                    'header' => 'Tanggal Tindakan',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_tindakan)'
                ),
                array(
                    'header' => '<center>No. Pendaftaran</center>',
                    'type'=>'raw',
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => '<center>Nama Pasien</center>',
                    'type'=>'raw',
                    'value' => function($data){
                        $p = PasienM::model()->findByPk($data->pasien_id);
                        
                        return $p->namadepan.' '.$p->nama_pasien;
                    },
                ),
                array(
                    'header' => '<center>Alamat Pasien</center>',
                    'type'=>'raw',
                    'name' => 'alamat_pasien',
                ),
                array(
                    'header' => '<center>Jenis Penjamin</center>',
                    'type'=>'raw',
                    'name' => 'carabayar_nama',
                ),
                array(
                    'header' => '<center>Penjamin</center>',
                    'type'=>'raw',
                    'name' => 'penjamin_nama',
                ),
                array(
                    'header' => '<center>Total Biaya</center>',
                    'type'=>'raw',
                    'name' => 'total_biaya',
                    'value'=>'number_format($data->total_biaya,0,",",".")',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(total_biaya)',
                ),
                array(
                    'header' => '<center>Bayar</center>',
                    'type'=>'raw',
                    'name' => 'bayartindakan',
                    'value'=>'number_format($data->bayartindakan,0,",",".")',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(bayartindakan)',
                ),
                array(
                    'header' => '<center>Sisa</center>',
                    'type'=>'raw',
                    'name' => 'sisatindakan',
                    'value'=>'number_format($data->sisatindakan)',
                    'htmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(sisatindakan)',
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            }',                    
        )
    );
?>



