<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pengajuanlpj-t',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'),
        ));

$detail = isset($detail) ? $detail : '';
?>
<?= CHtml::hiddenField('jenis_dialog', ''); ?>
<?= CHtml::hiddenField('no_row', ''); ?>
<div class="panel  panel-success form-dis">
    <div class="panel-heading">
        <div class="panel-title">Pengajuan <strong>Kasbon</strong></div>
    </div>
    <div class="panel-body">                        
        <?php echo $this->renderPartial($this->path_view . 'informasi/_detail', array('model' => $model, 'form' => $form)); ?>
    </div>
</div>

<div class="panel  panel-success form-dis">
    <div class="panel-heading">
        <div class="panel-title"><strong>Approval </strong></div>
    </div>
    <div class="panel-body">                        
        <?php 
            echo $this->renderPartial($this->path_view . 'lpj/_2_formApproval', array(
            'model' => $model,
            'form' => $form,
            'modLPJ' => $modLPJ
        ));
        ?>
    </div>
</div>
<div class="panel  panel-success form-dis">
    <div class="panel-heading">
        <div class="panel-title"><strong>Tabel Pembuatan LPJ Pengajuan Kasbon </strong></div>
    </div>
    <div class="panel-body">                        
        <?php
        echo $this->renderPartial($this->path_view . 'lpj/_3_tabel_lpj', array(
            'model' => $model,
            'form' => $form,
            'modLPJ' => $modLPJ
        ));
        ?>
    </div>
</div>


<div class="form-actions">
<?= $this->renderPartial($this->path_view . '_button', ['model' => $model]); ?>
</div>

<?php
$this->endWidget();
?>