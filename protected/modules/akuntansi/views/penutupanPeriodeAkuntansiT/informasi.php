<?php $linkHalaman = CustomFunction::getUrlByMenuID(1905); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Penutupan Periode Akuntansi',
);
?>
<div class="panel panel-gradient">
	<div class="panel panel-heading">
		<div class="panel-title">Informasi Penutupan Periode Akuntansi</div>
	</div>
	<div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('#penutupan-info-search').submit(function(){
            $('#penutupan-grid').addClass('animation-loading');
                $.fn.yiiGridView.update('penutupan-grid', {
                    data: $(this).serialize()
                });
            return false;
        });
        ");
        ?>
        
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penutupan Periode Akuntansi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                        'id'=>'penutupan-grid',
                        'dataProvider'=>$model->searchInformasi(),
                        'template'=>"{summary}\n{items}\n{pager}",
                        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                        'columns'=>array(
                            array(
                                'header' => 'No',
                                'type' => 'raw',
                                'value' => '$row+1'
                            ),
                            array(
                                'header'=>'Tanggal Penutupan',
                                'type' => 'raw',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tglpenutupan)',
                            ),
                             array(
                                'header'=>'No Penutupan',
                                'type' => 'raw',
                                'value'=>'$data->nopenutupan',
                            ),
//                            array(
//                                'header'=>'Tgl Penutupan/<br/>No Penutupan',
//                                'name'=>'tglpenutupan',
//                                'type'=>'raw',
//                                'value'=>function($data) {
//                                    return CHtml::link('<u>'.MyFormatter::formatDateTimeForUser($data->tglpenutupan)."/<br/>".$data->nopenutupan.'</u>',
//                                        $this->createUrl('detail', array('id'=>$data->penutupanperiodeakun_id)), array(
//                                            'target'=>'iframeDetail',
//                                            'onclick'=>'$("#dialogDetail").dialog("open");',
//                                            'data-toggle'=>'tooltip',
//                                            'title'=>'Klik untuk melihat detail Penutupan',
//                                        ));
//                                },
//                            ),
                            array(
                                'header'=>'Periode Akuntansi',
                                'name'=>'rekperiod',
                                'type'=>'raw',
                                'value'=>function($data) {
                                    $rek = RekperiodM::model()->findByPk($data->rekperiod_id);
                                    return $rek->deskripsi;
                                }
                            ),
                            array(
                                'header'=>'Saldo Debit',
                                'name'=>'saldodebit',
                                'value'=>'MyFormatter::formatNumberForPrint($data->saldodebit)',
                                'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                'header'=>'Saldo Kredit',
                                'name'=>'saldokredit',
                                'value'=>'MyFormatter::formatNumberForPrint($data->saldokredit)',
                                'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                'header'=>'Detail Penutupan',
                                'type'=>'raw',
                                'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/detail", array("id"=>$data->penutupanperiodeakun_id)),
                                        array("class"=>"", 
                                                  "target"=>"iframeDetail",
                                                  "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk melihat detail Penutupan",
                                        ))',
                                'htmlOptions'=>array('style'=>'text-align: center'),
                            ),
                            array(
                                'header'=>'Petugas',
                                'type'=>'raw',
                                'value'=>function($data) {
                                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                                    return (isset($peg)? $peg->namaLengkap: "-");
                                }
                            ),
                        ),
                        
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Penutupan Periode Akuntansi',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1000,
        'width' => 800,
        'height' => 600,
        'resizable' => true,
        'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));
?>
<iframe name='iframeDetail' width="100%" height="100%" style="border: none;"></iframe>
<?php $this->endWidget(); 
?>