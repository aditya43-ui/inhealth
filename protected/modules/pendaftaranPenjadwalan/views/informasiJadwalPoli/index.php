<?php
$this->breadcrumbs = array(
    'Informasi Penjadwalan Poliklinik'
);
?>
<style>
    .table>tbody>tr:hover {
        filter: none;
    }

    .table>tbody>tr>td:hover {
        background: #fff;
        filter: brightness(.85);
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-calendar"></i> Penjadwalan <b>Poliklinik</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
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
                            <?php echo CHtml::activeLabel($model, 'jammulai', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'jammulai',
                                    'mode' => 'time',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'span2',
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event);",
                                    ),
                                )); ?> <?php echo $form->error($model, 'jammulai'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($model, 'jamtutup', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'jamtutup',
                                    'mode' => 'time',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'span2',
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event);",
                                    ),
                                )); ?><?php echo $form->error($model, 'jamtutup'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php //echo $form->dropDownListRow($model,'hari', CustomFunction::getNamaHari() ,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); 
                        ?>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($model, 'ruangan_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList(
                                    $model,
                                    'ruangan_id',
                                    CHtml::listData(PPPendaftaranT::model()->getRuanganItems(Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama'),
                                    array(
                                        'empty' => '-- Pilih --',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    )
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penjadwalan Poliklinik</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $timePickerUpdate = <<< timePicker
jQuery('.jam').timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'onSelect':function(){},'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
timePicker;
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pencarianjadwal-grid',
                    'dataProvider' => $model->searchInformasi(),
                    //                'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered datatable',
                    'columns' => array(
                        'ruangan.ruangan_nama',
                        array(
                            'header' => 'Senin',
                            'type' => 'raw',
                            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Senin\'),true)',
                            'htmlOptions' => array('style' => "width:200px;"),
                        ),
                        array(
                            'header' => 'Selasa',
                            'type' => 'raw',
                            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Selasa\'),true)',
                            'htmlOptions' => array('style' => "width:200px;"),
                        ),
                        array(
                            'header' => 'Rabu',
                            'type' => 'raw',
                            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Rabu\'),true)',
                            'htmlOptions' => array('style' => "width:200px;"),
                        ),
                        array(
                            'header' => 'Kamis',
                            'type' => 'raw',
                            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Kamis\'),true)',
                            'htmlOptions' => array('style' => "width:200px;"),
                        ),
                        array(
                            'header' => 'Jumat',
                            'type' => 'raw',
                            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Jumat\'),true)',
                            'htmlOptions' => array('style' => "width:200px;"),
                        ),
                        array(
                            'header' => 'Sabtu',
                            'type' => 'raw',
                            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Sabtu\'),true)',
                            'htmlOptions' => array('style' => "width:200px;"),
                        ),
                        array(
                            'header' => 'Minggu',
                            'type' => 'raw',
                            'value' => '$this->grid->getOwner()->renderPartial(\'' . $this->path_view . '_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Minggu\'),true)',
                            'htmlOptions' => array('style' => "width:200px;"),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                           ' . $timePickerUpdate . ' 
                            }',
                ));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>