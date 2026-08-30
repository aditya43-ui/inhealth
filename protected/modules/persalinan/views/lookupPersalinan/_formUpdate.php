<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kategoriobat-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#LookupM_lookup_type',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php //echo $form->textFieldRow($model,'lookup_type',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LookupM_lookup_name','')", 'maxlength'=>100,)); 
?>
<?php echo $form->textFieldRow($model, 'lookup_name', array('class' => 'custom-only', 'onkeypress' => "return nextFocus(this,event,'LookupM_lookup_value','LookupM_lookup_type')", 'maxlength' => 200)); ?>
<?php echo $form->textFieldRow($model, 'lookup_value', array('class' => 'custom-only', 'onkeypress' => "return nextFocus(this,event,'LookupM_lookup_kode','LookupM_lookup_name')", 'maxlength' => 200)); ?>
<?php echo $form->textFieldRow($model, 'lookup_kode', array('class' => 'custom-only', 'onkeypress' => "return nextFocus(this,event,'LookupM_lookup_urutan','LookupM_lookup_value')", 'maxlength' => 50)); ?>
<?php echo $form->textFieldRow($model, 'lookup_urutan', array('class' => 'numbers-only', 'onkeypress' => "return nextFocus(this,event,'LookupM_lookup_aktif','LookupM_lookup_kode')", 'style' => 'text-align:right;')); ?>
<?php echo $form->checkBoxRow($model, 'lookup_aktif', array('onkeypress' => "return nextFocus(this,event,'LookupM_lookup_aktif','LookupM_lookup_kode')")); ?>

<!--	<table id="tbl-Lookup" class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th>Nama</th>
                <th>Value</th>
                <th>Kode</th>
                <th>Urutan</th>
                <th>Aktif</th>
                <th></th>
            </tr>
            </thead>
            <?php //$modLookup = LookupM::model()->findAllByAttributes(array('lookup_type'=>$model->lookup_type)); 
            ?>
            <tbody>
            <?php //foreach($modLookup as $x=>$row){ 
            ?>
            
               
            <tr>
                    
                <td>
                        <?php // echo $form->hiddenField($row, '['.$x.']lookup_id');
                        ?>
                        <?php // echo $form->hiddenField($row, '['.$x.']lookup_type');
                        ?>
                        <?php //echo $form->textField($row,'['.$x.']lookup_name',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LookupM_lookup_value','LookupM_lookup_type')", 'maxlength'=>200,'placeholder'=>$model->getAttributeLabel('lookup_name'))); 
                        ?>
                        <span class="required">*</span>
                    </td>
                    <td>
                        <?php //echo $form->textField($row,'['.$x.']lookup_value',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LookupM_lookup_kode','LookupM_lookup_name')", 'maxlength'=>200, 'placeholder'=> $model->getAttributeLabel('lookup_value'))); 
                        ?>
                    </td>
                    <td>
                        <?php //echo $form->textField($row,'['.$x.']lookup_kode',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LookupM_lookup_urutan','LookupM_lookup_value')", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('lookup_kode'))); 
                        ?>
                    </td>
                   <td>
                        <?php //echo $form->textField($row,'['.$x.']lookup_urutan',array( 'class'=>'span3 numbersOnly', 'style'=>'width:80px', 'onkeypress'=>"return nextFocus(this,event,'LookupM_lookup_aktif','LookupM_lookup_kode')", 'placeholder'=> $model->getAttributeLabel('lookup_urutan'))); 
                        ?>
                    </td>
                   <td>
                        <?php //echo $form->checkBox($row,'['.$x.']lookup_aktif',array('class'=>'span1 lookupAktif','style'=>'width:80px')); 
                        ?>
                   </td>
                    <td>
                        <?php //echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'addRow(this)','id'=>'row1-plus')); 
                        ?>
                    </td>
                    
                </tr>
            
            <?// } ?>
                <tbody>
        </table>-->

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan ' . $this->nama, array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT
$(document).ready(function(){
    $('.numbersOnly').keyup(function() {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
           this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });
});

function addRow(obj)
{
    var tr = $('#tbl-Lookup tbody tr:first').html();
    $('#tbl-Lookup tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-Lookup tr:last td:last').append('$buttonMinus');
        renameInput('LookupM','lookup_id');
        renameInput('LookupM','lookup_name');
        renameInput('LookupM','lookup_value');
        renameInput('LookupM','lookup_kode');
        renameInput('LookupM','lookup_urutan');
        renameInput('LookupM','lookup_type');
        renameInput('LookupM','lookup_aktif');
$('#tbl-Lookup tr:last').find('input').val('');
$('#tbl-Lookup tr:last').find(".lookupAktif").val(1);
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-Lookup tbody tr').length;
    var i = 1;
    $('#tbl-Lookup tbody tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}

function delRow(obj)
{
    myConfirm("$confimMessage","Perhatian!",
    function(r){
        if(r){
            return false;
        }else{
            $(obj).parent().parent().remove();
            renameInput('SALookupM','lookup_id');
            renameInput('SALookupM','lookup_name');
            renameInput('SALookupM','lookup_value');
            renameInput('SALookupM','lookup_kode');
            renameInput('SALookupM','lookup_urutan');
        }
    }); 
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>