<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$format = new MyFormatter();

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'guinvperalatan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);','onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
    'focus' => '#',
        ));
?>    

<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Merk",'invperalatan_merk');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatan_merk', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Ukuran",'invperalatan_ukuran');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatan_ukuran', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Bahan",'invperalatan_bahan');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatan_bahan', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Tipe/Model",'peralatan_model');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'peralatan_model', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("No. Pabrik",'invperalatan_nopabrik');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatan_nopabrik', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("No. Rangka",'invperalatan_norangka');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatan_norangka', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("No. Mesin",'invperalatan_nomesin');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatan_nomesin', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("No. Polisi",'invperalatan_nopolisi');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatan_nopolisi', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("No. BPKB",'invperalatan_nobpkb');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatan_nobpkb', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("No. Seri",'peralatan_noseri');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'peralatan_noseri', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Manufacturer",'peralatan_manufacturer');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'peralatan_manufacturer', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Nilai Perolehan",'invperalatan_harga');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatan_harga', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Akum Susut",'invperalatan_akumsusut');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatan_akumsusut', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Umur Ekonomis",'invperalatan_umurekonomis');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invperalatan_umurekonomis', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Garansi Habis",'peralatan_garansihabis');?>
            </label>
            <div class="controls">
                <?php 
                    $model->peralatan_garansihabis = $format->formatDateTimeForUser($model->peralatan_garansihabis);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'peralatan_garansihabis', 
                        'mode'=>'date',
                        'options'=>array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                        'class' => "span4 required",
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));  
                ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Kondisi",'invperalatan_keadaan');?>
            </label>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($model, 'invperalatan_keadaan', LookupM::getItems('kondisi_barang'), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Daya Listrik",'peralatan_dayalistrik');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'peralatan_dayalistrik', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Keterangan",'invperalatan_ket');?>
            </label>
            <div class="controls">
                <?php echo $form->textArea($model, 'invperalatan_ket', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
</div>


<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
    ?>
</div>

<?php $this->endWidget(); ?>