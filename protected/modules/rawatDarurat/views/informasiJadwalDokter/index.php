<?php
$this->breadcrumbs = array(
    'Informasi Jadwal Dokter'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Jadwal Dokter</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        //$arrMenu = array();
        //               array_push($arrMenu,array('label'=>Yii::t('mds','Pencarian pasien'), 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //$this->menu=$arrMenu;
        //$this->widget('bootstrap.widgets.BootAlert');
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
                        <?php echo $form->dropDownListRow($model, 'jadwaldokter_hari', $listHari, array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData(RDPendaftaran::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                    <div class="col-sm-6">
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
                                        'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);",
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
                                        'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);",
                                    ),
                                )); ?><?php echo $form->error($model, 'jadwaldokter_tutup'); ?>
                            </div>
                        </div>
                        <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RDPendaftaran::model()->getRuanganItems(($_GET['r'] == 'rawatDarurat/InformasiJadwalDokter/Index') ? Params::INSTALASI_ID_RD : Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onchange' => "listDokterRuangan(this.value)", 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array(
                            'title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)',
                            'ajax' => array(
                                'type' => 'GET',
                                'url' => array("/" . $this->route),
                                'update' => '#pencarianjadwal-grid',
                                'beforeSend' => 'function(){
                                              $("#pencarianjadwal-grid").addClass("animation-loading");
                                          }',
                                'complete' => 'function(){
                                              $("#pencarianjadwal-grid").removeClass("animation-loading");
                                          }',
                            )
                        )
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php $content = $this->renderPartial('rawatDarurat.views.tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'create', 'content' => $content)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jadwal Dokter</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_tableJadwalDokter', array('model' => $model)); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>