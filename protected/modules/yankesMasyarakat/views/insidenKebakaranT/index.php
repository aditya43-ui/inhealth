<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gradingrisiko-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>
<style>
    .form-horizontal .control-label{
        width: 150px !important;
        text-align: left;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Formulir Laporan Insiden Kebakaran </b> </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="panel panel-success">
                <div class="panel panel-heading">
                    <div class="panel-title"> <b> Data Pelaporan </b> </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view.'/form/_1_dataPelaporan', array('model' => $model, 'form' => $form))?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="panel panel-success">
                <div class="panel panel-heading">
                    <div class="panel-title"> <b> Data Kejadian </b> </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view.'/form/_2_dataKejadian', array('model' => $model, 'form' => $form))?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                    'type' => 'submit', 'disabled' => true)); echo "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                    'type' => 'submit'));"&nbsp;";
            }
            echo "&nbsp;";
            
            if (empty($_GET['is_edit'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('index'), array('class' => 'btn btn-danger',
                    'onclick' => 'return refreshForm(this);'));
                ?>
                <?php
                if (!empty($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue', 'disabled' => false, 'type' => 'button', 'onclick' => 'myAlert("Coming Soon")'));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue', 'disabled' => true, 'type' => 'button'));
                }
                ?>
                <?php
                $content = $this->renderPartial('pengadaan.views.tips/transaksi', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            }else{
                echo '<a class="btn btn-danger" onclick="tutup()" style="color:#fff;" href="#"><i class="fa fa-times"></i> Batal</a>';
            }
            
            if (!empty($_GET['is_detail'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue show', 'disabled' => false, 'type' => 'button', 'onclick' => 'myAlert("Coming Soon")'));
            }
            ?>
        </div>
    </div>
</div>
<script>
function tutup(){
    window.parent.$("#dialogUbah").dialog("close"); 
}
</script>
<?php $this->renderPartial($this->path_view.'/_dialog', array('model' => $model, 'form' => $form))?>
<?php $this->endWidget(); ?>
