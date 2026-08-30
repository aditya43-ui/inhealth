<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js'); ?>
<?php

$this->widget('bootstrap.widgets.BootAlert');


$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
        ));
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Riwayat Pengkajian Gizi</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_tableRiwayat', ['modRiwayat' => $modRiwayat]) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tgl_konsultasi', array('class' => 'control-label', 'label'=>'Tgl. Asuhan Gizi')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_konsultasi',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'class'=>'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>

        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Ahli Gizi <span class="required">*</span>', 'Ahli Gizi', array('class' => 'control-label')) ?>
            <div class="controls">

                <?php
                if (!empty($model->ahligizi_id)) {
                    $peg = PegawaiM::model()->findByPk($model->ahligizi_id);
                    if (!empty($peg))  {
                        $model->ahligizi_nama = $peg->namaLengkap;
                    }
                }
                
                
    
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'ahligizi_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/ActionAutoComplete/autocompleteAhliGizi') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#ahligizi_nama").val(ui.item.label);
                            $("#ahligizi_id").val(ui.item.value);                                    
                            return false;
                        }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogAhliGizi'),
                    'htmlOptions' => array('class' => 'span3 required', 'id'=>'ahligizi_nama')
                ));
                ?>


                <?php 
                    echo $form->hiddenField($model, 'ahligizi_id',  
                        array('id'=>'ahligizi_id', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                ?>

            </div>
        </div>


    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel-body">
            <span class="group-title" style="top:12px">
                A. Antropometri
            </span>
            <div class="panel panel-default" style="border: 1px solid black !important;">
                <div class="panel-heading"
                    style="display: flex; justify-content: center; background-color: white !important;">
                    <div class="panel-title" style="color: black !important">
                        Antropometri <b>Dewasa</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="control-group">
                                <?php echo $form->label($model, 'andewasabb', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->andewasabb)) $model->andewasabb = 0 ?>
                                    <?php  echo $form->textField($model, 'andewasabb', array('class'=>'span1 number-char'))." ".CHtml::label("Kg", ''); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'andewasatl', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->andewasatl)) $model->andewasatl = 0 ?>
                                    <?php  echo $form->textField($model, 'andewasatl', array('class'=>'span1 number-char'))." ".CHtml::label("Cm", ''); ?>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-3">
                            <div class="control-group">
                                <?php echo $form->label($model, 'andewasatb', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->andewasatb)) $model->andewasatb = 0 ?>
                                    <?php  echo $form->textField($model, 'andewasatb', array('class'=>'span1 number-char'))." ".CHtml::label("Cm", ''); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'andewasatbest', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->andewasatbest)) $model->andewasatbest = 0 ?>
                                    <?php  echo $form->textField($model, 'andewasatbest', array('class'=>'span1 number-char'))." ".CHtml::label("Cm", ''); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="control-group">
                                <?php echo $form->label($model, 'andewasabbi', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->andewasabbi)) $model->andewasabbi = 0 ?>
                                    <?php  echo $form->textField($model, 'andewasabbi', array('class'=>'span1 number-char'))." ".CHtml::label("Kg", ''); ?>
                                </div>
                            </div>
                            <div class="control-group">
                            <?= CHtml::label("Lingkar Lengan Atas", '', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php if(empty($model->andewasalla)) $model->andewasalla = 0 ?>
                                    <?php  echo $form->textField($model, 'andewasalla', array('class'=>'span1 number-char'))." ".CHtml::label("cm", ''); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="control-group">
                                <?php echo $form->label($model, 'andewasaimt', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->andewasaimt)) $model->andewasaimt = 0 ?>
                                    <?php  echo $form->textField($model, 'andewasaimt', array('class'=>'span1 number-char'))." ".CHtml::label("Kg/m<sup>2</sup>", ''); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'andewasallap', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->andewasaimt)) $model->andewasaimt = 0 ?>
                                    <?php  echo $form->textField($model, 'andewasallap', array('class'=>'span1 number-char'))." ".CHtml::label("%", ''); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- ./row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $form->radioButtonListInlineRow($model, 'andestatus_gizi', ['Buruk' => 'Buruk','Kurang' => 'Kurang', 'Normal' => 'Normal', 'Lebih' => 'Lebih', 'Obesitas' => 'Obesitas']); ?>
                        </div>
                    </div>
                    <!-- ./row -->
                </div>
                <!-- ./panel-body -->

                <div class="panel-heading"
                    style="display: flex; justify-content: center; background-color: white !important;border-top: 0.5px solid grey !important;">
                    <div class="panel-title" style="color: black !important">
                        Antropometri <b>Anak</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananakbb', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananakbb)) $model->ananakbb = 0 ?>
                                    <?php  echo $form->textField($model, 'ananakbb', array('class'=>'span3 number-char')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananakbbu', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananakbbu)) $model->ananakbbu = 0; ?>
                                    <?php  echo $form->textField($model, 'ananakbbu', array('class'=>'span3 number-char')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananakbbtb', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananakbbtb)) $model->ananakbbtb = 0; ?>
                                    <?php  echo $form->textField($model, 'ananakbbtb', array('class'=>'span3 number-char')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananakimtu', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananakimtu)) $model->ananakimtu = 0 ?>
                                    <?php  echo $form->textField($model, 'ananakimtu', array('class'=>'span3 number-char')); ?>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-3">
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananaktb', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananaktb)) $model->ananaktb = 0 ?>
                                    <?php  echo $form->textField($model, 'ananaktb', array('class'=>'span3 number-char')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananaktbu', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananaktbu)) $model->ananaktbu = 0 ?>
                                    <?php  echo $form->textField($model, 'ananaktbu', array('class'=>'span3 number-char')); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananakbbi', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananakbbi)) $model->ananakbbi = 0 ?>
                                    <?php  echo $form->textField($model, 'ananakbbi', array('class'=>'span3 number-char')); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananakpjgbdn', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananakpjgbdn)) $model->ananakpjgbdn = 0 ?>
                                    <?php  echo $form->textField($model, 'ananakpjgbdn', array('class'=>'span3 number-char')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananakpjgbdnu', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananakpjgbdnu)) $model->ananakpjgbdnu = 0 ?>
                                    <?php  echo $form->textField($model, 'ananakpjgbdnu', array('class'=>'span3 number-char')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananakbbip', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananakbbip)) $model->ananakbbip = 0 ?>
                                    <?php  echo $form->textField($model, 'ananakbbip', array('class'=>'span3 number-char')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananaklla', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananaklla)) $model->ananaklla = 0 ?>
                                    <?php  echo $form->textField($model, 'ananaklla', array('class'=>'span3 number-char')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananakllau', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananakllau)) $model->ananakllau = 0 ?>
                                    <?php  echo $form->textField($model, 'ananakllau', array('class'=>'span3 number-char')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananakutb', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php if(empty($model->ananakutb)) $model->ananakutb = 0 ?>
                                    <?php  echo $form->textField($model, 'ananakutb', array('class'=>'span3 number-char')); ?>

                                </div>

                            </div>
                        </div>

                        <!-- ./row -->

                        <!-- ./row -->
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <?php echo $form->radioButtonListInlineRow($model, 'ananakstatus_gizi', ['Buruk' => 'Buruk','Kurang' => 'Kurang', 'Normal' => 'Normal', 'Lebih' => 'Lebih', 'Obesitas' => 'Obesitas']); ?>
                        </div>
                        <div class="col-sm-3">
                            <div class="control-group">
                                <?php echo $form->label($model, 'ananakket', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php  echo $form->textArea($model, 'ananakket', array('class'=>'span3', 'cols' => 7)); ?>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- ./panel-body -->
                </div>
                <!-- ./panel-default -->
            </div>
        </div>
    </div>
    <br>
    <div class="col-sm-12">
        <div class="panel panel-dark">
            <span class="group-title">
                B. Biokimia
            </span>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->label($model, 'isbiokimianormal') ?>
                    <div class="controls">
                        <?php echo $form->CheckBox($model, 'isbiokimianormal', array('uncheckValue' => false, 'onclick' => 'unCheck(this)')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $form->CheckBox($model, 'isbiokimiabermasalah', array('uncheckValue' => null, 'onclick'=>'setBiokim(this)')) . CHtml::label("Bermasalah", '', array('style' => 'margin-right:20px'))?>
                        <?php echo $form->textArea($model, 'biokim', array('class'=>'span5 biokim', 'rows'=>10, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="col-sm-12">
        <div class="panel panel-dark">
            <span class="group-title">
                C. Fisik Klinik
            </span>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->label($model, 'isfisklinormal') ?>
                    <div class="controls">
                        <?php echo $form->CheckBox($model, 'isfisklinormal', array('uncheckValue' => false, 'onclick' => 'uncheckfisik()')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $form->CheckBox($model, 'isfisklibermasalah', array('uncheckValue' => null, 'onclick'=>'setFisikKlinik(this)')) . CHtml::label("Bermasalah", '', array('style' => 'margin-right:20px'))?>
                        <?php echo $form->textArea($model, 'fisklinik', array('class'=>'span5 fisklinik', 'rows'=>10, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="col-sm-12">
        <div class="panel panel-dark">
            <span class="group-title">
                D. Riwayat Gizi
            </span>
            <div class="panel-body">
                <h3>Dahulu</h3>

                <div class="control-group">
                    <div class="controls">
                        <?php echo '<span class="span2">Alergi </span>'. $form->CheckBox($model, 'isalergitidak', array('id' => 'alergitidak','uncheckValue' => false, 'onclick'=>'setAlergi("tidak")')) . CHtml::label("Tidak", '', array('style' => 'margin-right:40px'))?>
                        <?php echo $form->CheckBox($model, 'isalergiada', array('id' => 'alergiada','uncheckValue' => false, 'onclick'=>'setAlergi("ada")')) . CHtml::label("Ada", '', array('style' => 'margin-right:76px')) ?>

                        <?php  echo $form->textField($model, 'alergi', array('class'=>'span3 alergi', 'readonly' => true)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?php echo '<span class="span2">Pola Makan </span>'. $form->CheckBox($model, 'ispolamakanteratur', array('id' => 'ispolamakanteratur','uncheckValue' => false, 'onclick'=>'setPolaMakan("teratur")')) . CHtml::label("Teratur", '', array('style' => 'margin-right:32px'))?>
                        <?php echo $form->CheckBox($model, 'ispolamakantidak', array('id' => 'ispolamakantidak','uncheckValue' => false, 'onclick'=>'setPolaMakan("tidakTeratur")')) . CHtml::label("Tidak Teratur", '', array('style' => 'margin-right:32px')) ?>

                        <?php  echo $form->textField($model, 'polamakan', array('class'=>'span3 polamakan', 'readonly' => true)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?php echo '<span class="span2">Susunan Menu </span>'. $form->CheckBox($model, 'issusunanmakanseimbang', array('id' => 'issusunanmakanseimbang','uncheckValue' => false, 'onclick'=>'setSusunanMakan("seimbang")')) . CHtml::label("Seimbang", '', array('style' => 'margin-right:17px'))?>
                        <?php echo $form->CheckBox($model, 'issusunanmakantidak', array('id' => 'issusunanmakantidak','uncheckValue' => false, 'onclick'=>'setSusunanMakan("tidakseimbang")')) . CHtml::label("Tidak Seimbang", '', array('style' => 'margin-right:17px')) ?>

                        <?php  echo $form->textField($model, 'susunanmakan', array('class'=>'span3 susunanmakan', 'readonly' => true)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?php echo '<span class="span2">ASI </span>' .$form->CheckBox($model, 'isasidiberikan', array('id' => 'isasidiberikan','uncheckValue' => false, 'onclick'=>'setAsi("diberikan")')) . CHtml::label("Diberikan", '', array('style' => 'margin-right:20px'))?>
                        <?php echo $form->CheckBox($model, 'isasitidak', array('id' => 'isasitidak','uncheckValue' => false, 'onclick'=>'setAsi("tidakdiberikan")')) . CHtml::label("Tidak Diberikan", '', array('style' => 'margin-right:20px')) ?>

                        <?php  echo $form->textField($model, 'asi', array('class'=>'span3 asi', 'readonly' => true)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?php echo CHtml::label("", '', array('class' => 'span1', 'style' => 'margin-right:145px'))?>
                        <?php echo CHtml::CheckBox('lainlain2',false, array('id' => 'isasilainlain','uncheckValue' => false, 'onclick'=>'setLainlain()')) . CHtml::label("Lain-lain", '', array('style' => 'margin-right:54px')) ?>

                        <?php  echo $form->textField($model, 'lainlain', array('class'=>'span3 lainlain', 'readonly' => true)) ?>
                    </div>
                </div>


                <h3>Sekarang</h3>
                <div class="control-group">
                    <div class="controls">
                        <?php echo '<span class="span2">Nafsu Makan </span>' .$form->CheckBox($model, 'isnmbaik', array('id' => 'isnmbaik','uncheckValue' => false, 'onclick'=>'setNM("baik")')) . CHtml::label("Baik", '', array('style' => 'margin-right:20px'))?>
                        <?php echo $form->CheckBox($model, 'isnmkurang', array('id' => 'isnmkurang','uncheckValue' => false, 'onclick'=>'setNM("kurang")')) . CHtml::label("Kurang", '', array('style' => 'margin-right:20px')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?php echo '<span class="span2">Keluhan </span>' .$form->CheckBox($model, 'iskelsulit', array('id' => 'iskelsulit','uncheckValue' => false)) . CHtml::label("Sulit Menelan", '', array('style' => 'margin-right:20px'))?>

                        <?php echo $form->CheckBox($model, 'iskelsulitmengunyah', array('id' => 'iskelsulitmengunyah','uncheckValue' => false)) . CHtml::label("Sulit Mengunyah", '', array('style' => 'margin-right:20px')) ?>

                        <?php echo $form->CheckBox($model, 'iskelmual', array('id' => 'iskelmual','uncheckValue' => false)) . CHtml::label("Mual", '', array('style' => 'margin-right:20px')) ?>

                        <?php echo $form->CheckBox($model, 'iskelmuntah', array('id' => 'iskelmuntah','uncheckValue' => false)) . CHtml::label("Muntah", '', array('style' => 'margin-right:20px')) ?>
                        <br>
                        <?php echo CHtml::label("", '', array('class' => 'span1', 'style' => 'margin-right:57px'))?>
                        <?php echo $form->CheckBox($model, 'iskellainlain', array('id' => 'iskellainlain','uncheckValue' => false)) . CHtml::label("Lain-lain", '', array('style' => 'margin-right:20px')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?php echo '<span class="span2">Jenis Diet </span>' .$form->CheckBox($model, 'isjdoral', array('id' => 'isjdoral','uncheckValue' => false, 'onclick' => 'setJenisDiet("oral")')) . CHtml::label("Oral", '', array('style' => 'margin-right:40px'))?>
                        <?php  echo $form->textField($model, 'jdoral', array('class'=>'span3 jdoral', 'readonly' => true)) ?>
                        <br>
                        <?php echo CHtml::label("", '', array('class' => 'span1', 'style' => 'margin-right:57px'))?>
                        <?php echo $form->CheckBox($model, 'isjdenteral', array('id' => 'isjdenteral','uncheckValue' => false, 'onclick' => 'setJenisDiet("enternal")')) . CHtml::label("Enteral", '', array('style' => 'margin-right:20px'))?>
                        <?php  echo $form->textField($model, 'jdenteral', array('class'=>'span3 jdenteral', 'readonly' => true)) ?>
                        <br>
                        <?php echo CHtml::label("", '', array('class' => 'span1', 'style' => 'margin-right:57px'))?>
                        <?php echo $form->CheckBox($model, 'isjdparenteral', array('id' => 'isjdparenteral','uncheckValue' => false, 'onclick' => 'setJenisDiet("parenteral")')) . CHtml::label("Parenteral", '', array('style' => 'margin-right:20px'))?>
                        <?php  echo $form->textField($model, 'jdparenteral', array('class'=>'span3 jdparenteral', 'readonly' => true)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?php echo '<span class="span2">Rute Pemberian Diet </span>' .$form->CheckBox($model, 'isrpdoral', array('id' => 'isrpdoral','uncheckValue' => false, 'onclick'=>'setRPD("oral")')) . CHtml::label("Oral", '', array('style' => 'margin-right:20px'))?>
                        <?php echo $form->CheckBox($model, 'isrpdlewatpipa', array('id' => 'isrpdlewatpipa','uncheckValue' => false, 'onclick'=>'setRPD("lewatPipa")')) . CHtml::label("Lewat Pipa", '', array('style' => 'margin-right:20px')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="col-sm-12">
        <div class="panel panel-dark">
            <span class="group-title">
                E. Riwayat Personal Terkait Penyakit
            </span>
            <div class="panel-body">
                <?php  echo $form->textFieldRow($model, 'rptpriwayatpenyakit', array('class'=>'rptpriwayatpenyakit', 'size'=>250)) ?>
                <?php  echo $form->textFieldRow($model, 'rptpdiagnosismedis', array('class'=>'rptpdiagnosismedis', 'size'=>250)) ?>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'konfirmForm()', 'id' => 'btn_simpan'));
    ?>

        <?php
    
    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'', array(
                                'pendaftaran_id'=>$pendaftaran_id,
                                'pasienadmisi_id'=>$pasienadmisi_id,
                            )), 
                            array('class' => 'btn btn-default',
                                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    if($model->isNewRecord){
	echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
    }else{
	echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();return false",'disabled'=>FALSE  ));
    }
    
    ?>


        <?php 
            $tips = array(
                '0' => 'waktutime',
                '1' => 'autocomplete-search',
                '2' => 'simpan'
            );
           $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
                      $this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
    </div>

    <?php $this->endWidget(); ?>


    <?php
//=============================== Dialog AHLI GIZI =======================================
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogAhliGizi',
        'options' => array(
            'title' => 'Ahli Gizi',
            'autoOpen' => false,
            'width' => 840,
            'height' => 420,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$modAhliGizi = new PegawaiV('search');
$modAhliGizi->unsetAttributes();
$modAhliGizi->ruangan_id = Params::RUANGAN_ID_GIZI;
$modAhliGizi->jabatan_id = Params::JABATAN_ID_AHLI_GIZI;
$modAhliGizi->pegawai_aktif = true;
if (isset($_GET['PegawaiV'])) {
    $modAhliGizi->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $modAhliGizi->search(),
    'filter' => $modAhliGizi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                        "onclick" => ""
                    . "$(\"#ahligizi_nama\").val(\"".$data->namaLengkap."\");
                        $(\"#ahligizi_id\").val(\"".$data->pegawai_id."\");"
                    . "$(\"#dialogAhliGizi\").dialog(\"close\");"
                    . "; return false; "
                ));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END AHLI GIZI =======================================

?>


    <script>
    
    function konfirmForm() {
        var is_simpan = false;
        if(requiredCheck($('#rjanamnesa-t-form'))) {
            window.parent.myConfirm('Apakah anda yakin akan menyimpan data?', 'Perhatian!', function(r) {
                if(r) {
                    is_simpan = true;
                    $('#rjanamnesa-t-form').submit();

                } 
            });
        } else {
            is_simpan = false;
        }
    }
    /**
     * print status
     */
    function print() {
        window.open(
            '<?php echo $this->createUrl('print',array('pendaftaran_id'=>$pendaftaran_id, 'pasienadmisi_id'=>$pasienadmisi_id)); ?>',
            'printwin', 'left=100,top=100,width=640,height=480');
    }

    $(function () { 
        setBiokim($('#AsesmengiziT_isbiokimiabermasalah'));
        setFisikKlinik($('#AsesmengiziT_isfisklibermasalah'));
        
        setReadOnly('issusunanmakantidak', 'AsesmengiziT_susunanmakan'); 
        setReadOnly('isjdoral', 'AsesmengiziT_jdoral'); 
        setReadOnly('alergiada', 'AsesmengiziT_alergi'); 
        setReadOnly('ispolamakantidak', 'AsesmengiziT_polamakan'); 
        setReadOnly('isasitidak', 'AsesmengiziT_asi'); 
        setReadOnly('isasilainlain', 'AsesmengiziT_lainlain'); 
        setReadOnly('isjdenteral', 'AsesmengiziT_jdenteral'); 
        setReadOnly('isjdparenteral', 'AsesmengiziT_jdparenteral'); 
        
    });

    function setReadOnly(idCheckBox, idField) {
        if($('#' + idCheckBox).is(':checked')) {
            $('#' + idField).attr('readonly', false);
        }
    }

    function setBiokim(obj) {
        if($(obj).is(':checked')) {
            $('#AsesmengiziT_isbiokimianormal').attr('checked', false);
            $('.biokim').prop('readonly', false);
        } else {
            $('.biokim').prop('readonly', true);
            $('.biokim').val('');
        }
    }

    function unCheck() {
        $('#AsesmengiziT_isbiokimiabermasalah').attr('checked', false);
        $('.biokim').prop('readonly', true);
        $('.biokim').val('');
    }

    function uncheckfisik() {
        $('#AsesmengiziT_isfisklibermasalah').attr('checked', false);
        $('.fisklinik').prop('readonly', true);
        $('.fisklinik').val('');
    }

    function setFisikKlinik(obj) {
        if ($(obj).is(':checked')) {
            $('#AsesmengiziT_isfisklinormal').attr('checked', false);
            $('.fisklinik').prop('readonly', false);
        } else {
            $('.fisklinik').prop('readonly', true);
            $('.fisklinik').val('');
        }
    }

    function setAlergi(param) {
        stat = $('.alergi').prop('readonly');

        if (param == 'ada') {
            $('#alergitidak').prop('checked', false);
            $('.alergi').prop('readonly', false);
            if (stat) {
                $('.alergi').prop('readonly', false);
            } else {
                $('.alergi').prop('readonly', true);
                $('.alergi').val('');
            }
        } else {
            $('#alergiada').prop('checked', false);
            $('.alergi').prop('readonly', true);
            $('.alergi').val('');
        }
    }

    function setPolaMakan(param) {
        stat = $('.polamakan').prop('readonly');

        if (param == 'teratur') {
            $('#ispolamakantidak').prop('checked', false);
            $('.polamakan').prop('readonly', true);
            $('.polamakan').val('');
        } else {
            $('#ispolamakanteratur').prop('checked', false);
            if (stat) {
                $('.polamakan').prop('readonly', false);
            } else {
                $('.polamakan').prop('readonly', true);
            }
        }
    }

    function setSusunanMakan(param) {
        stat = $('.susunanmakan').prop('readonly');

        if (param == 'seimbang') {
            $('#issusunanmakantidak').prop('checked', false);
            $('.susunanmakan').prop('readonly', true);
            $('.susunanmakan').val('');
        } else {
            $('#issusunanmakanseimbang').prop('checked', false);
            if (stat) {
                $('.susunanmakan').prop('readonly', false);
            } else {
                $('.susunanmakan').prop('readonly', true);
            }
        }
    }

    function setAsi(param) {
        stat = $('.asi').prop('readonly');

        if (param == 'diberikan') {
            $('#isasitidak').prop('checked', false);
            $('.asi').prop('readonly', true);
            $('.asi').val('');
        } else {
            $('#isasidiberikan').prop('checked', false);
            if (stat) {
                $('.asi').prop('readonly', false);
            } else {
                $('.asi').prop('readonly', true);
            }
        }
    }

    function setLainlain() {
        stat = $('.lainlain').prop('readonly');

        if (stat) {
            $('.lainlain').prop('readonly', false);
        } else {
            $('.lainlain').prop('readonly', true);
        }
    }

    function setNM(param) {

        if (param == 'baik') {
            $('#isnmkurang').prop('checked', false);
        } else {
            $('#isnmbaik').prop('checked', false);
        }
    }

    function setJenisDiet(param) {
        statOral = $('.jdoral').prop('readonly');
        statEnternal = $('.jdenteral').prop('readonly');
        statParenteral = $('.jdparenteral').prop('readonly');

        if (param == 'oral') {
            if (statOral) {
                $('.jdoral').prop('readonly', false);
            } else {
                $('.jdoral').prop('readonly', true);
            }
        }

        if (param == 'enternal') {
            if (statEnternal) {
                $('.jdenteral').prop('readonly', false);
            } else {
                $('.jdenteral').prop('readonly', true);
            }
        }

        if (param == 'parenteral') {
            if (statParenteral) {
                $('.jdparenteral').prop('readonly', false);
            } else {
                $('.jdparenteral').prop('readonly', true);
            }
        }


    }

    function setRPD(param) {
        if (param == 'oral') {
            $('#isrpdlewatpipa').prop('checked', false);
        } else {
            $('#isrpdoral').prop('checked', false);
        }
    }

    $(document).ready(function() {
        $('.number-char').on('keypress', function(event) {
            var karakter = String.fromCharCode(event.which);

            // Regular expression untuk memeriksa apakah karakter adalah angka atau karakter selain huruf
            var pattern = /^[A-Za-z]+$/;

            if (pattern.test(karakter)) {
            event.preventDefault();
            }
        });

        $('input').on('focus', function(){
            if ($(this).val() === "0") {
                $(this).val("");
            }
        });
    });

    </script>


<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',
array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pengkajian',
        'autoOpen' => false,
        'width' => 840,
        'height' => 600,
        'resizable' => true,
    ),
)
);
?>
<iframe name="iframeDetail" frameborder="0" width="100%" height="98%"></iframe>
<?php
$this->endWidget();
?>