<legend class="rim2">Penjadwalan Dokter IGD</legend>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'carijadwal-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#RDJadwaldokterM_jadwaldokter_hari',
    'method' => 'GET',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));

Yii::app()->clientScript->registerScript('cariPasien', "
$('#carijadwal-form').submit(function(){
	$.fn.yiiGridView.update('pencarianjadwal-grid', {
		data: $(this).serialize()
	});
	return false;
});
"); ?>
<?php
$timePickerUpdate = <<< timePicker
jQuery('.jam').timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'onSelect':function(){},'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
timePicker;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pencarianjadwal-grid',
    'dataProvider' => $model->searchJadwalIGD(),
    //                'filter'=>$model,
    'template' => "{pager}\n{items}",

    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'name' => 'pegawai_id',
            'type' => 'raw',
            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formDokter\',array(\'data\'=>$data),true)',
            'htmlOptions' => array('style' => 'width:100px;'),
        ),

        array(
            'header' => 'Senin',
            'type' => 'raw',
            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'idPegawai\'=>$data[pegawai_id],\'hariCari\'=>\'Senin\'),true)',
            'htmlOptions' => array('style' => "width:200px;"),
        ),
        array(
            'header' => 'Selasa',
            'type' => 'raw',
            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'idPegawai\'=>$data[pegawai_id],\'hariCari\'=>\'Selasa\'),true)',
            'htmlOptions' => array('style' => "width:200px;"),
        ),
        array(
            'header' => 'Rabu',
            'type' => 'raw',
            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'idPegawai\'=>$data[pegawai_id],\'hariCari\'=>\'Rabu\'),true)',
            'htmlOptions' => array('style' => "width:200px;"),
        ),
        array(
            'header' => 'Kamis',
            'type' => 'raw',
            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'idPegawai\'=>$data[pegawai_id],\'hariCari\'=>\'Kamis\'),true)',
            'htmlOptions' => array('style' => "width:200px;"),
        ),
        array(
            'header' => 'Jumat',
            'type' => 'raw',
            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'idPegawai\'=>$data[pegawai_id],\'hariCari\'=>\'Jumat\'),true)',
            'htmlOptions' => array('style' => "width:200px;"),
        ),
        array(
            'header' => 'Sabtu',
            'type' => 'raw',
            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'idPegawai\'=>$data[pegawai_id],\'hariCari\'=>\'Sabtu\'),true)',
            'htmlOptions' => array('style' => "width:200px;"),
        ),
        array(
            'header' => 'Minggu',
            'type' => 'raw',
            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'idPegawai\'=>$data[pegawai_id],\'hariCari\'=>\'Minggu\'),true)',
            'htmlOptions' => array('style' => "width:200px;"),
        ),




    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                           ' . $timePickerUpdate . ' 
                            }',
));


?>
<hr>
</hr>
<fieldset>
    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
    <table class="table">
        <tr>
            <td>
                <?php //echo $form->dropDownListRow($model,'jadwaldokter_hari', $listHari ,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); 
                ?>
                <?php echo $form->dropDownListRow(
                    $model,
                    'ruangan_id',
                    CHtml::listData(PPPendaftaranT::model()->getRuanganItems(Params::INSTALASI_ID_RD), 'ruangan_id', 'ruangan_nama'),
                    array(
                        'empty' => '-- Pilih --',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    )
                ); ?>
                <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData(PPPendaftaranT::model()->getDokterItemsInstalasi(Params::INSTALASI_ID_RD), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </td>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'jadwaldokter_mulai', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jadwaldokter_mulai',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                        )); ?> <?php echo $form->error($model, 'jadwaldokter_mulai'); ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'jadwaldokter_tutup', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jadwaldokter_tutup',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                        )); ?><?php echo $form->error($model, 'jadwaldokter_tutup'); ?>

                    </div>
                </div>
            </td>
        </tr>
    </table>
</fieldset>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('informasiJadwalDokter/index'), array('class' => 'btn btn-danger')); ?>
    <?php
    $content = $this->renderPartial('../tips/informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>


<?php $this->endWidget(); ?>