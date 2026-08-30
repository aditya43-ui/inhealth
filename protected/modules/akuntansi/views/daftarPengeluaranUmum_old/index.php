<?php
$this->breadcrumbs = array(
    'Daftar Pengeluaran Kas',
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
    )
);

?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Pengeluaran Kas</b></legend>
    <?php
    $this->widget(
        'ext.bootstrap.widgets.HeaderGroupGridView',
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
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                'tglpengeluaran',
                'nopengeluaran',
                array(
                    'header' => 'Kelompok <br> Transaksi',
                    'type' => 'raw',
                    'value' => '$data->kelompoktransaksi',
                ),
                array(
                    'header' => 'Jenis Pengeluaran',
                    'type' => 'raw',
                    'value' => '$data->jenispengeluaran->jenispengeluaran_nama',
                    'footerHtmlOptions' => array('colspan' => 6, 'style' => 'text-align:right;font-style:italic;'),
                    'footer' => 'Jumlah Total',
                ),
                'volume',
                array(
                    'header' => 'Harga',
                    'name' => 'hargasatuan',
                    'value' => 'number_format($data->hargasatuan)',
                    'htmlOptions' => array('style' => 'width:100px;text-align:right'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(hargasatuan)',
                ),
                array(
                    'header' => 'Total Harga',
                    'name' => 'totalharga',
                    'value' => 'number_format($data->totalharga)',
                    'htmlOptions' => array('style' => 'width:100px;text-align:right'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(totalharga)',
                ),
                array(
                    'header' => 'Keterangan',
                    'type' => 'raw',
                    'value' => '$data->keterangankeluar',
                    'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                    'footer' => '-',
                ),
                array(
                    'header' => 'Lihat Detail',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailPengeluaranUmum",array("pengeluaranumum_id"=>$data->pengeluaranumum_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeDetPengeluaran",
                                          "onclick"=>"$(\"#dialogDetPengeluaran\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk detail Pengeluaran",
                                    ))',
                    'htmlOptions' => array(
                        'style' => 'text-align: left;'
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 100px; text-align: left;',
                    ),
                    'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                    'footer' => '',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
    );
    ?>
    <fieldset class='box'>
        <legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
        <table width='100%' class="table-condensed">
            <tr>
                <td>
                    <div class="control-group">
                        <?php // $modPengeluaran->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPengeluaran->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); 
                        ?>
                        <?php echo CHtml::label('Tgl. Pengeluaran Kas', 'tglPengeluaranKas', array('class' => 'control-label inline')) ?>
                        <div class="controls">
                            <?php
                            $this->widget(
                                'MyDateTimePicker',
                                array(
                                    'model' => $modPengeluaran,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'datetime',
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
                        <?php // $modPengeluaran->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPengeluaran->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); 
                        ?>
                        <?php echo CHtml::label('Sampai Dengan', 'sampaiDengan', array('class' => 'control-label inline')) ?>
                        <div class="controls">
                            <?php

                            $this->widget(
                                'MyDateTimePicker',
                                array(
                                    'model' => $modPengeluaran,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'minDate' => 'd',
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
                </td>
                <td>
                    <?php echo $form->textFieldRow($modPengeluaran, 'nopengeluaran', array('class' => 'span2', 'style' => 'width:140px;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Pengeluaran', 'jenisPengeluaran', array('class' => 'control-label inline')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPengeluaran, 'jenispengeluaran_id', CHtml::listData(
                                JenispengeluaranM::model()->findAll(),
                                'jenispengeluaran_id',
                                'jenispengeluaran_nama'
                            ), array('class' => 'span2', 'style' => 'width:140px;', 'empty' => '-- Pilih --'));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </fieldset>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetPengeluaran',
    'options' => array(
        'title' => 'Detail Pembayaran',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetPengeluaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>