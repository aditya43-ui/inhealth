<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penerimaan Umum</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Daftar Penerimaan Umum',
        );
        Yii::app()->clientScript->registerScript('search', "
				$('#penerimaan-t-search').submit(function(){
					$.fn.yiiGridView.update('daftarpenerimaan-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");
        ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Penerimaan", 'tglPenerimaan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modPenerimaan->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modPenerimaan->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modPenerimaan->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modPenerimaan->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modPenerimaan, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modPenerimaan, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("No Penerimaan", 'nopenerimaan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPenerimaan, 'nopenerimaan', array('class' => 'span3 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($modPenerimaan, 'namapenandatangan', array('class' => 'span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php //echo $form->textFieldRow($modPenerimaan,'nippenandatangan',array('class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                        ?>
                        <div class="control-group">
                            <?php echo Chtml::label("Kelompok Transaksi", 'kelompoktransaksi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modPenerimaan, 'kelompoktransaksi', LookupM::getItems('kelompoktransaksi'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi_penerimaanumum', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Umum</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'penerimaan-t-search',
                    'type' => 'horizontal',
                    'focus' => '#BKPenerimaanUmumT_nopenerimaan'
                )); ?>
                <div class="block-tabel">
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'daftarpenerimaan-m-grid',
                        'dataProvider' => $modPenerimaan->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            'tglpenerimaan',
                            'nopenerimaan',
                            array(
                                'header' => 'Nama Penerimaan',
                                'value' => '$data->jenispenerimaan->jenispenerimaan_nama',
                            ),
                            'namapenandatangan',
                            'kelompoktransaksi',
                            'volume',
                            'satuanvol',
                            array(
                                'header' => 'Harga Satuan (Rp)',
                                'name' => 'hargasatuan',
                                'value' => 'number_format($data->hargasatuan,0,"",".")',
                                'htmlOptions' => array('style' => 'text-align: right;'),
                            ),
                            array(
                                'placeholder' => 'Total Harga (Rp)',
                                'name' => 'totalharga',
                                'value' => 'number_format($data->totalharga,0,"",".")',
                                'htmlOptions' => array('style' => 'text-align: right;'),
                            ),
                            array(
                                'header' => 'Retur Penerimaan Umum',
                                'type' => 'raw',
                                'htmlOptions' => array(
                                    'style' => 'width: 100px; text-align:left;',
                                ),
                                'value' => 'CHtml::link("<i class=\'icon-form-retur\'></i> ",Yii::app()->createUrl("billingKasir/returPenerimaanUmum/index",array("frame"=>1,"idPenerimaan"=>$data->penerimaanumum_id)) ,array("title"=>"Klik untuk Meretur Penerimaan Umum","target"=>"iframeRetur", "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");", "rel"=>"tooltip"))',
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
// ===========================Dialog Retur=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRetur',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Retur Penerimaan Umum',
        'autoOpen' => false,
        'zIndex' => 1002,
        'minWidth' => 1100,
        'height' => 100,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpenerimaan-m-grid', {
							data: $(this).serialize()
						}); }",
    ),
));
?>
<iframe src="" name="iframeRetur" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Retur================================
