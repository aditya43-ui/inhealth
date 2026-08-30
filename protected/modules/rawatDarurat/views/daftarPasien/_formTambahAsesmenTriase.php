<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'tambah-asesmen-triase-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event)',
            ),
        )
    );
?>
<p class="help-block" style="color:#333;padding:10px;">
    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?>
</p>

<div class="panel panel-success">    
    <div class="panel-body">
        <?= $this->renderPartial('rawatDarurat.views.daftarPasien.form/tambah-asesmen-triase/_1_identitasPasien',['model'=>$modDraft, 'form'=>$form], true) ?>
        
        <div class="panel panel-success"> 
            <div class="panel-heading">
                <div class="panel-title"><b>Data Asemsen Triage</b></div>
            </div>
            <div class="panel-body">
                <?= $this->renderPartial('rawatDarurat.views.asesmenTriage.form._formTriageBaru',['model'=>$model, 'form'=>$form], true) ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onKeypress'=>'return formSubmit(this,event)', 'onclick'=>'submitAsesmenTriase();'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'$("#tambahTriage").dialog("close")')
		);
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    var submitAsesmenTriase = () => {
        if (requiredCheck($("#tambah-asesmen-triase-form"))){
            
            tambahTriage('',$("#tambah-asesmen-triase-form"));
            disableOnSubmit($("#idSubmit"));
        }
    }
</script>
