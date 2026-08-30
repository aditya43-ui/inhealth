<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'penelitian-t-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);'),
    'focus'=>'#',
)); ?>
<?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <?php if (isset($_GET['riskregister_id'])) { ?>
            <div class="panel-title"><strong>Ubah Risk Register</strong></div>
            <span style="float:right; padding: 10px">
                <?php echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-left-bold"></i>')), 
                        Yii::app()->createUrl('yankesMasyarakat/informasiRiskRegister/index'),
                        array('class'=>'btn btn-success')); ?>
            </span>
            <?php }else{ ?>
            <div class="panel-title"><strong>Risk Register</strong></div>
            <?php } ?>
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><b>Risk Register</b></div>
                </div>
                <div class="panel-body">
                    <?php echo $this->renderPartial('_form', array(
                        'model'=>$model,
                        'form'=>$form,
                            )); ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><b>Risk Register</b></div>
                </div>
                <div class="panel-body">
                    <?php echo $this->renderPartial('_formRisk', array(
                        'model'=>$model,
                        'form'=>$form,
                            )); ?>
                </div>
            </div>
            <div class="form-actions">
                <?php
                $disabled = (isset($_GET['sukses']))? true : false;
                ?>
                <?php 
                if (!isset($_GET['sukses'])){
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}'=>'<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary','type'=>'submit'));
                }else{
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}'=>'<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary','type'=>'submit', 'disabled'=>true));
                }                
                ?>
                &nbsp;
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), array('class'=>'btn btn-danger',
                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl('Index').'";}); return false;'
                ));?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>
<?php $this->endWidget(); ?>