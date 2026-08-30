<div class="white-container">
    <legend class="rim2">Informasi Setoran <b>Kasir ke Bendahara</b></legend>

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'setorankasir-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));

    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#setorankasir-form').submit(function(){
            $.fn.yiiGridView.update('setorankasir-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>

    <div class="block-tabel">
        <h6>Tabel Setoran <b>Kasir ke Bendahara</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'setorankasir-grid',
            'dataProvider' => $model->searchInformasi(),
            'template' => "{summary}\n{items}{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'name' => 'tglsetorankasir',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglsetorankasir)',
                ),
                'nosetorankasir',
                'ruangan_nama',
                array(
                    'name' => 'setorankasirdari',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->setorankasirdari)',
                ),
                array(
                    'name' => 'sampaidengan',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->sampaidengan)',
                ),
                array(
                    'name' => 'jmluangsetorankasir',
                    'value' => 'MyFormatter::formatNumberForPrint($data->jmluangsetorankasir)',
                    'htmlOptions' => array(
                        'style' => 'text-align: right;',
                    )
                ),
                array(
                    'header' => 'Pegawai Setoran',
                    'name' => 'nama_pegawai',
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->gelardepan . $data->nama_pegawai . ", " . $data->gelarbelakang_nama;
                    }
                ),
                array(
                    'header' => 'Tgl. Diterima Bendahara',
                    'name' => 'tglditerimabendahara',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglditerimabendahara)',
                ),
                array(
                    'header' => 'Pegawai Bendahara',
                    'name' => 'nama_bendahara',
                    'type' => 'raw',
                    'value' => function ($data) {
                        if (empty($data->bendaharapenerima_id)) {
                            return CHtml::link('<i class="icon-form-check"></i>', $this->createUrl('terima', array('id' => $data->setorankasir_id)), array(
                                'rel' => 'tooltip',
                                'title' => 'Klik untuk penerimaan setoran',
                                'target' => 'iframeTerimaRincianSetoran',
                                'onclick' => '$("#dialogTerimaRincianSetoran").dialog("open");',
                            ));
                        }
                        return $data->gelardepan_bendahara . $data->nama_bendahara . ", " . $data->gelarbelakang_bendahara;
                    }
                ),
                array(
                    'header' => 'Detail',
                    'type' => 'raw',
                    'value' => function ($data) {
                        return CHtml::link('<i class="icon-form-rincianrs"></i>', $this->createUrl('print', array('id' => $data->setorankasir_id, 'frame' => 1)), array(
                            'rel' => 'tooltip',
                            'title' => 'Klik untuk melihat setoran',
                            'target' => 'iframeRincianSetoran',
                            'onclick' => '$("#dialogRincianSetoran").dialog("open");'
                        ));
                    }
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
    <fieldset class="box">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    Pencarian Setoran
                </div>
            </div>
            <div class="panel-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal); ?>
                                <?php echo CHtml::label('Tgl. Setoran', 'tgl_awal', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tgl_awal',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                <?php $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir); ?>
                                <?php echo CHtml::label('Sampai Dengan', 'tgl_akhir', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tgl_akhir',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            //                                                    'minDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )); ?>

                                </div>
                            </div>
                            <?php echo $form->textFieldRow($model, 'nosetorankasir', array('class' => 'span3')); ?>
                        </td>
                    </tr>
                </table>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </fieldset>

    <?php $this->endwidget(); ?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianSetoran',
    'options' => array(
        'title' => 'Rincian Setoran Kasir',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'height' => 700,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianSetoran" width="100%" height="600"></iframe>
<?php
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogTerimaRincianSetoran',
    'options' => array(
        'title' => 'Terima Rincian Setoran Kasir',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'height' => 700,
        'resizable' => true,
        'close' => 'js:function(event, ui) {'
            .
            '$.fn.yiiGridView.update("setorankasir-grid", {
			data: $("#setorankasir-form").serialize()
        });'
            . '}',
    ),
));
?>
<iframe src="" name="iframeTerimaRincianSetoran" width="100%" height="600"></iframe>
<?php
$this->endWidget();
?>