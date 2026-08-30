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
                <?php echo CHtml::activeTelField($modKirimKeUnitLain, 'tgl_kirimpasien', ['readonly' => true]) ?>
                <?php
                        //  $this->widget('MyDateTimePicker', array(
                        //          'model' => $modKirimKeUnitLain,
                        //          'attribute' => 'tgl_kirimpasien',
                        //          'value'=>null,
                        //          'mode' => 'datetime',
                        //          'options' => array(
                        //                  'dateFormat' => Params::DATE_FORMAT,
                        //                 //  'maxDate' => 'd',
                        //          ),
                        //          'htmlOptions' => array(
                        //                  'readonly' => true,
                        //                  'onkeypress' => "return $(this).focusNextInputField(event)",
                        //                  'class'=>'span3 htpd',
                        //          ),
                        //  ));
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
        */ ?>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Jenis Pemeriksaan</th>
                    <th>Tgl. Rencana Pemeriksaan <span class="required">*</span></th>
                    <th>Hari Ini</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                echo CHtml::hiddenField('tgl_sekarang', MyFormatter::formatDateTimeForUser(date('Y-m-d')), array(
                    'class'=>'tgl_sekarang'
                ));
                
                if(count($modPermintaanJenis) > 0) { 
                        foreach ($modPermintaanJenis as $i => $value) {
                            
                ?>
                    <tr>
                        <td><?= $value->jenispemeriksaanlab_nama ?? '' ?></td>
                        <td width="220"><?php 

                        echo $form->hiddenField($value, '['.$value->jenispemeriksaanlab_id.']jenispemeriksaanlab_id', array('class' => 'span2'));

                        $this->widget('MyDateTimePicker', array(
                            'model' => $value,
                            'attribute' => '['.$value->jenispemeriksaanlab_id.']tgl_rencanapemeriksaan',
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