<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pengajuan Anggaran Operasional</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php
        $this->breadcrumbs = array(
            'Transaksi Pengajuan Anggaran Operasional',
        );
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'sapegawai-m-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekSubmit(this);return false;'),
            'focus' => '#',
        ));
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo $form->errorSummary($model); ?>
        <!--<div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pegawai</b></div>
            </div>
            <div class="panel-body">
                <?php // echo $this->renderPartial($this->path_view.'form._formPegawai', array('modPegawai'=>$modPeg, 'form'=>$form, 'model' => $model)) 
                ?>
            </div>
        </div>-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Form <b>Pengajuan Anggaran Operasional</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'form._form', array('modPegawai' => $modPeg, 'form' => $form, 'model' => $model, 'det' => $modDet)) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Pegawai Approval
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'form._formBerwenang', array('form' => $form, 'model' => $model)) ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
                );
            } else {
                echo CHtml::htmlButton(
                    $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true)
                );
            }
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    //								'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'
                )
            );
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => true, 'type' => 'button'));
            }
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
                '2' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php echo $this->renderPartial($this->path_view . 'js._jsFunctions', array('model' => $model, 'modDet' => $modDet)); ?>
<?php echo $this->renderPartial($this->path_view . 'dialog._dialogPeg', array('model' => $model)); ?>