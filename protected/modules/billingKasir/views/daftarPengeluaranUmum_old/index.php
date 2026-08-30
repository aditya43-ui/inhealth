<div class="white-container">
    <legend class="rim2">Informasi <b>Pengeluaran Umum</b></legend>
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
            'focus' => '#BKPengeluaranumumT_nopengeluaran',
        )
    );

    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pengeluaran Umum</b></h6>
        <?php

        $this->widget(
            'ext.bootstrap.widgets.BootGridView',
            array(
                'id' => 'daftarpengeluaran-m-grid',
                'dataProvider' => $modPengeluaran->searchInformasi(),
                'template' => "{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-condensed',
                'columns' => array(
                    array(
                        'header' => 'No.',
                        'type' => 'raw',
                        'value' => '$row+1',
                        'htmlOptions' => array('style' => 'width:20px')
                    ),
                    'tglpengeluaran',
                    'nopengeluaran',
                    'jenispengeluaran.jenispengeluaran_nama',
                    array(
                        'header' => 'Harga Satuan (Rp)',
                        'name' => 'hargasatuan',
                        'value' => 'MyFormatter::formatNumberForPrint($data->hargasatuan)'
                    ),
                    array(
                        'header' => 'Total Harga (Rp)',
                        'name' => 'totalharga',
                        'value' => 'MyFormatter::formatNumberForPrint($data->totalharga)'
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            )
        );

        ?>
    </div>
    <fieldset class="box">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php $modPengeluaran->tgl_awal = $format->formatDateTimeForUser($modPengeluaran->tgl_awal); ?>
                                <?php echo CHtml::label('Tgl. Pengeluaran', 'tglPengeluaran', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget(
                                        'MyDateTimePicker',
                                        array(
                                            'model' => $modPengeluaran,
                                            'attribute' => 'tgl_awal',
                                            'mode' => 'date',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'span3 dtPicker3',
                                                'onkeypress' => "return $(this).focusNextInputField(event)"
                                            ),
                                        )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php $modPengeluaran->tgl_akhir = $format->formatDateTimeForUser($modPengeluaran->tgl_akhir); ?>
                                <?php echo CHtml::label('Sampai Dengan', 'sampaiDengan', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php

                                    $this->widget(
                                        'MyDateTimePicker',
                                        array(
                                            'model' => $modPengeluaran,
                                            'attribute' => 'tgl_akhir',
                                            'mode' => 'date',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'minDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                            ),
                                        )
                                    );

                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php echo $form->textFieldRow($modPengeluaran, 'nopengeluaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            <?php //echo $form->textFieldRow($modPengeluaran,'kelompoktransaksi',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                            ?>
                        </td>
                    </tr>
                </table>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('id' => 'btn_reset', 'class' => 'btn btn-default', 'type' => 'reset')); ?>
                    <?php
                    $content = $this->renderPartial('tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>