<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Penyusutan Aset</b>
        </div>
    </div>
    <div class="panel-body">

        <?php
        if (!empty($_GET['sukses'])) {
            ?>
            <?php echo Yii::app()->user->setFlash('success', "Data Penyusutan Aset berhasil disimpan !"); ?>
        <?php } ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'mapenyusutanaset-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
            'focus' => '#namaBarang',
        ));
        ?>

        <p class="help-block" style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Barang</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_dataBarang', array('model' => $model, 'form' => $form)); ?>
            </div>
        </div>

        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="glyphicon glyphicon-file"></i>  <b> Penyusutan Aset </b></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_penyusutanAset', array('model' => $model, 'form' => $form,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Detail <b>Penyusutan Aset</b></div>
            </div>
            <div class="panel-body overflow-x">
                <table class="items table table-striped table-condensed" id="table-detailpenyusutan">
                    <thead>
                        <tr>
                            <th width="3%">No.</th>
                            <th>Periode Penyusutan</th>
                            <th>Saldo Penyusutan</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
        <br>
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">Penjurnalan</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_penjurnalan', array('model' => $model, 'form' => $form,)); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'button', 'onclick' => 'cekTabel();', 'id'=>'btn_submit', 'disabled' => (isset($_GET['sukses'])) ? true : false)); //formSubmit(this,event) ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->module->id . '/Index'), array('class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'));
            ?>
            <?php // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>$disablePrint)); ?>
            <?php
            $content = $this->renderPartial('manajemenAset.views.tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        cekDisabled('form');
<?php if (isset($_GET['sukses'])) { ?>
            $("input, select, textarea").attr('disabled', true);
<?php } ?>
    });
</script>