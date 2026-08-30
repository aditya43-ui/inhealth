<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pilihpendaftaran-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        'focus'=>'#',
)); 

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');

?>

<?php echo $form->errorSummary($modKirimKeUnitLain); ?>

<div class="row" style="margin-top: 30px;">
    <div class="col-sm-12">
    <div class="control-group">
    <?php echo CHtml::label("Tanggal Kirim Permintaan", 'tgl_kirimpasien', array('class'=>'control-label required')); ?>
            <div class="controls">
                <?php

                echo CHtml::activeTextField($modKirimKeUnitLain, 'tgl_kirimpasien', ['readonly' => true]);
                        
                     ?>
            </div>
        </div>
        <?php /*
        <div class="control-group">
            <label for="" class="control-label">Tgl. Rencana Pemeriksaan <span class="required">*</span></label>
            <div class="controls">
                <?php
                         $this->widget('MyDateTimePicker', array(
                                 'model' => $modKirimKeUnitLain,
                                 'attribute' => 'tglrencanapemeriksaan',
                                 'value'=>null,
                                 'mode' => 'datetime',
                                 'options' => array(
                                         'dateFormat' => Params::DATE_FORMAT,
                                        //  'maxDate' => 'd',
                                 ),
                                 'htmlOptions' => array(
                                         'readonly' => true,
                                         'onkeypress' => "return $(this).focusNextInputField(event)",
                                         'class'=>'span3 htpd required',
                                 ),
                         ));
                     ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label('Jenis Pemeriksaan', 'jenispemeriksaanrad_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPermintaan, 'jenispemeriksaanrad_nama', array('readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pemeriksaan', 'pemeriksaanrad_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modPermintaan, 'pemeriksaanrad_id',array('class'=>'control-label')); ?>
                <?php echo CHtml::activeTextField($modPermintaan, 'pemeriksaanrad_nama', array('readonly'=>true)); ?>
            </div>
        </div>
        */
        ?>
        <div class="control-group">
            <div class="controls" style="margin-left: 140px; margin-top: 10px;">
                <?php echo $form->checkBox($modKirimKeUnitLain, 'is_elektif', array('id'=>'is_elektif')); ?>
                <label for="is_elektif">Pemeriksaan Elektif</label>
            </div>
        </div>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Jenis Pemeriksaan</th>
                    <th>Pemeriksaan</th>
                    <th>Kode Tindakan</th>
                    <th>Tgl. Rencana Pemeriksaan <span class="required">*</span></th>
                    <th>Hari Ini</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                echo CHtml::hiddenField('tgl_sekarang', MyFormatter::formatDateTimeForUser(date('Y-m-d')), array(
                    'class'=>'tgl_sekarang'
                ));
                
                if(count($modPermintaan) > 0) { 
                        foreach ($modPermintaan as $i => $value) {
                            if($value->is_cito) {
                                $bgColor = 'style="background: #F5B9B9 !important"';
                            } else {
                                $bgColor = '';
                            }
                            
                ?>
                    <tr <?= $bgColor ?>>
                        <td>
                            <?= $value->jenispemeriksaanrad_nama ?? '' ?>
                            <?php echo CHtml::activeHiddenField($value, '['.$value->permintaankepenunjang_id.']is_cito') ?>
                        </td>
                        <td><?= $value->pemeriksaanrad_nama ?? '' ?></td>
                        <td><?= $value->pemeriksaanrad_kode ?? '' ?></td>
                        <td width="220"><?php 
                        $this->widget('MyDateTimePicker', array(
                            'model' => $value,
                            'attribute' => '['.$value->permintaankepenunjang_id.']tgl_rencanapemeriksaan',
                            'value'=>null,
                            'mode' => 'date',
                            'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                   //  'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                    'readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class'=>'tgl_rencanapemeriksaan required',
                                    'style' => 'width: 150px;',
                            ),
                        ));
                        ?></td>
                        <td width="50"><?php echo CHtml::htmlButton('<i class="entypo-check"></i>', array(
                            'onclick'=>'setHariIni(this);', 'class'=>'btn btn-success'
                        )); ?></td>
                    </tr>
                <?php   } 
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class='form-actions' style='float:left'>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array(
            'class' => 'btn btn-danger', 'type' => 'submit',
            'onKeypress' => 'return formSubmit(this,event)',
            'id' => 'btn_simpan',
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
<script>
    function setHariIni(obj) {
        $(obj).parents("tr").find(".tgl_rencanapemeriksaan").val($(".tgl_sekarang").val());
    }
</script>