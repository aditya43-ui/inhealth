<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = false;
    $dataProvider = $model->searchTableGroupRadiologi();
    $template = "{summary}\n{items}\n{pager}";
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tableDetail',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-responsive table-bordered table-striped table-condensed',
            'mergeColumns' => array('no_rekam_medik'),
            'columns'=>array(
                array(
                    'header'=>'No. Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                ),
                array(
                    'header'=>'No. Registrasi',
                    'name'=>'no_pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_pendaftaran',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien',
                ),
                array(
                    'header'=>'Initial P3',
                    'type'=>'raw',
                    'value'=>'$data->penjamin_nama',
                ),
                array(
                    'header'=>'Detail Transaksi',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'value'=>'
                        CHtml::Link("<i class=\"icon-list-alt\"></i>",
                            Yii::app()->controller->createUrl("laporan/detailTransaksiRad",array("id"=>$data->pendaftaran_id,"frame"=>true)
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