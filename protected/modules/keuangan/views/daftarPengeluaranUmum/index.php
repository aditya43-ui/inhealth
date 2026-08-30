<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengeluaran Umum</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Daftar Pengeluaran Umum',
        );
        Yii::app()->clientScript->registerScript('search', "
					$('#pengeluaran-t-search').submit(function(){
						$.fn.yiiGridView.update('daftarpengeluaran-m-grid', {
							data: $(this).serialize()
						});
						return false;
					});
					$('#btn_reset').click(function(){
						setTimeout(function(){
							$.fn.yiiGridView.update('daftarpengeluaran-m-grid', {
								data: $('#pengeluaran-t-search').serialize()
							});
						}, 1000);
					});
					");
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
        $form = $this->beginWidget(
            'ext.bootstrap.widgets.BootActiveForm',
            array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'id' => 'pengeluaran-t-search',
                'type' => 'horizontal',
                'focus' => '#KUPengeluaranumumT_nopengeluaran',
            )
        );
        ?>
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
                            <?php echo CHtml::label("Tgl. Pengeluaran", 'tglPengeluaran', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modPengeluaran->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modPengeluaran->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modPengeluaran->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modPengeluaran->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modPengeluaran, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modPengeluaran, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($modPengeluaran, 'nopengeluaran', array('class' => 'span3 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php //echo $form->textFieldRow($modPengeluaran,'kelompoktransaksi',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                        ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('id' => 'btn_reset', 'class' => 'btn btn-default', 'type' => 'reset')); ?>
                    <?php
                    $content = $this->renderPartial('tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengeluaran Umum</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget(
                    'ext.bootstrap.widgets.BootGridView',
                    array(
                        'id' => 'daftarpengeluaran-m-grid',
                        'dataProvider' => $modPengeluaran->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'No.',
                                'type' => 'raw',
                                'value' => '$row+1',
                                'htmlOptions' => array('style' => 'text-align: right;'),
                            ),
                            'tglpengeluaran',
                            'nopengeluaran',
                            'jenispengeluaran.jenispengeluaran_nama',
                            array(
                                'header' => 'Harga Satuan (Rp)',
                                'name' => 'hargasatuan',
                                'value' => 'number_format($data->hargasatuan,0,"",".")',
                                'htmlOptions' => array('style' => 'text-align:right;')
                            ),
                            array(
                                'header' => 'Total Harga (Rp)',
                                'name' => 'totalharga',
                                'value' => 'number_format($data->totalharga,0,"",".")',
                                'htmlOptions' => array('style' => 'text-align:right;')
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )
                );
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>