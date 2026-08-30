<?php
$this->breadcrumbs = array(
    'Informasi Pembebasan Tarif',
);

Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('informasipembebasantarif-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset>
    <legend class="rim2">Informasi Pembebasan Tarif</legend>
    <div id="divSearch-form">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'informasipembebasantarif-t-search',
            'type' => 'horizontal',
        )); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'informasipembebasantarif-m-grid',
            'dataProvider' => $model->searchInformasi(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                'tglpembebasan',
                'nama_pegawai',
                array(
                    'name' => 'nama_pasien',
                    'header' => 'Nama Pasien / No. RM',
                    'type' => 'raw',
                    'value' => '$data->nama_pasien." / ".$data->no_rekam_medik',
                ),
                'daftartindakan_nama',
                'komponentarif_nama',
                array(
                    'name' => 'jmlpembebasan',
                    'type' => 'raw',
                    'value' => '"Rp ".number_format($data->jmlpembebasan)',
                )
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    Pencarian
                </div>
            </div>
            <div class="panel-body">
                <table>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo CHtml::label('Tgl. Pembebasan',  CHtml::activeId($model, 'tgl_awal'), array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
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
                                    )); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Sampai Dengan', CHtml::activeId($model, 'tgl_akhir'), array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
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
                                    )); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3')); ?>
                            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3')); ?>
                        </td>
                        <td>
                            <?php echo $form->textFieldRow($model, 'nama_pegawai', array('class' => 'span3')); ?>
                            <?php echo $form->textFieldRow($model, 'daftartindakan_nama', array('class' => 'span3')); ?>
                        </td>
                    </tr>
                </table>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
                    <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onclick' => 'resetForm();')
        ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
                <?php $this->endWidget(); ?>

            </div>
        </div>
    </div>
</fieldset>
<script>
    function resetForm() {
        window.open("<?php echo $this->createUrl("/" . $this->route); ?>", "_self");
    }
</script>