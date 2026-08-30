<?php
$this->breadcrumbs = array(
    'Transfer Batch Closing Kasir',
);

//Yii::app()->clientScript->registerScript('search', "
//$('#search-form form').submit(function(){
//        $('#informasiclosingkasir-m-grid').addClass('animation-loading');
//	$.fn.yiiGridView.update('informasiclosingkasir-m-grid', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>
<fieldset>
    <legend class="rim2">Transfer Batch Closing Kasir</legend>
    <?php if (isset($_GET['flash_msg'])) Yii::app()->user->setFlash($_GET['flash_msg']['type'], $_GET['flash_msg']['msg']);
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <div id="search-form">

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'post',
            'id' => 'transferbatchclosingkasir',
            'type' => 'horizontal',
        )); ?>
        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Closing Kasir',  CHtml::activeId($model, 'tgl_awal'), array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $model->tgl_awal = $format->formatDateINA($model->tgl_awal);
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => 'dd M yy',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                $model->tgl_awal = $format->formatDateMediumForDB($model->tgl_awal);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Sampai Dengan', CHtml::activeId($model, 'tgl_akhir'), array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $model->tgl_akhir = $format->formatDateINA($model->tgl_akhir);
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => 'dd M yy',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                $model->tgl_akhir = $format->formatDateMediumForDB($model->tgl_akhir);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php if (!isset($_GET['flash_msg'])) echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'searchForm();')); ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onclick' => 'resetForm();')
            ); ?>
            <?php
            //$content = $this->renderPartial('../tips/informasi',array(),true);
            //$this->widget('TipsMasterData',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>



        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
            'id' => 'informasiclosingkasir-m-grid',
            'dataProvider' => $model->searchBatchClosingKasir(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'mergeHeaders' => array(
                array(
                    'name' => '<p style="margin: 0; text-align: center;">Penerimaan</p>',
                    'start' => 5,
                    'end' => 6,
                ),
            ),
            'columns' => array(
                array(
                    'name' => 'tglclosingkasir',
                    'header' => 'Tgl. Closing Kasir',
                    'type' => 'raw',
                    'value' => '$data->tglclosingkasir',
                ),
                array(
                    'name' => 'closingdari',
                    'header' => 'Closing Dari <br> Sampai Dengan',
                    'type' => 'raw',
                    'value' => '$data->closingdari." <br> ".$data->sampaidengan',
                ),
                'nama_pegawai',
                'shift_nama',
                array(
                    'name' => 'closingsaldoawal',
                    'type' => 'raw',
                    'value' => '"Rp ".MyFunction::formatNumber($data->closingsaldoawal)',
                ),
                array(
                    'name' => 'terimauangmuka',
                    'type' => 'raw',
                    'value' => '"Rp ".MyFunction::formatNumber($data->terimauangmuka)',
                ),
                array(
                    'name' => 'terimauangpelayanan',
                    'type' => 'raw',
                    'value' => '"Rp ".MyFunction::formatNumber($data->terimauangpelayanan)',
                ),
                array(
                    'name' => 'nilaiclosingtrans',
                    'type' => 'raw',
                    'value' => '"Rp ".MyFunction::formatNumber($data->nilaiclosingtrans)',
                ),
                array(
                    'header' => 'Setor Ke Bank',
                    'type' => 'raw',
                    'value' => 'empty($data->setorbank_id) ? "<p style=\"margin: 0; text-align: center;\">-</p>" 
                            : $data->tgldisetor." ".CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("ClosingKasir/RincianSetoran",array("idSetor"=>$data->setorbank_id)),
                                                        array("class"=>"", 
                                                              "target"=>"iframeRincianSetoran",
                                                              "onclick"=>"$(\"#dialogRincianSetoran\").dialog(\"open\");",
                                                              "rel"=>"tooltip",
                                                              "title"=>"Klik untuk melihat Rincian Setoran",
                                                        ))',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
        <div class="form-actions">
            <?php if (!isset($_GET['flash_msg'])) echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => '$(this).parent().addClass("animation-loading");')); ?>
            <?php
            $content = $this->renderPartial('../tips/informasi', array(), true);
            $this->widget('TipsMasterData', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>

</fieldset>
<?php
$this->renderPartial('_jsFunctions', array());
?>