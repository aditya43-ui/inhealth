<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $dataProvider = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        
        echo $this->renderPartial('application.views.headerReport.headerLaporan',
            array(
                'judulLaporan'=>$data['judulLaporan'],
                'periode'=>$data['periode']
            )
        );        
    } else{
        $dataProvider = $model->searchGroupTable();
        $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php
    if(isset($caraPrint)){
        $this->widget($table,
        array(
            'id'=>'tableLaporanReg',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-responsive table-striped table-bordered table-condensed',
            'mergeColumns' => array('no_rekam_medik'),
            'columns'=>array(
                array(
                    'header'=>'No. RM',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_pendaftaran',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien',
                ),
                array(
                    'header'=>'Unit',
                    'type'=>'raw',
                    'value'=>'$data->instalasi_nama',
                ),
                array(
                    'header'=>'Ruangan',
                    'type'=>'raw',
                    'value'=>'$data->ruangan_nama',
                ),
                array(
                    'header'=>'Penjamin P3',
                    'type'=>'raw',
                    'value'=>'$data->penjamin_nama',
                ),
             ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );
    }else{
    $this->widget($table,
        array(
            'id'=>'tableLaporanReg',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'mergeColumns' => array('no_rekam_medik'),
            'columns'=>array(
                array(
                    'header'=>'No. RM',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_pendaftaran',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien',
                ),
                array(
                    'header'=>'Unit',
                    'type'=>'raw',
                    'value'=>'$data->instalasi_nama',
                ),
                array(
                    'header'=>'Ruangan',
                    'type'=>'raw',
                    'value'=>'$data->ruangan_nama',
                ),
                array(
                    'header'=>'Penjamin P3',
                    'type'=>'raw',
                    'value'=>'$data->penjamin_nama',
                ),
                array(
                    'header'=>'Detail Transaksi',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'value'=>'
                        CHtml::Link("<i class=\"icon-form-detail\"></i>",
                            Yii::app()->controller->createUrl("laporan/detailTransaksiFarmasi",array("id"=>$data->pendaftaran_id,"frame"=>true)
                        ),
                            array(
                                "class"=>"", 
                                "target"=>"iframeDetailTrans",
                                "onclick"=>"$(\"#dialogDetailTrans\").dialog(\"open\");",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk melihat detail transaksi",
                            )
                        )',
                    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                ),
             ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );
    }
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetailTrans',
    'options'=>array(
        'title'=>'Rincian Tagihan',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>700,
        'minHeight'=>400,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeDetailTrans" width="100%" height="400"></iframe>
<?php
    $this->endWidget();
?>