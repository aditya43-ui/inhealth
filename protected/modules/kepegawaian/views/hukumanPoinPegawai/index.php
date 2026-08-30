<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-gavel"></i> Transaksi <b>Hukuman Poin Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pegawai' => Yii::app()->request->getUrlReferrer(),
            'Transaksi Hukuman Poin Pegawai',
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pegawai</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'form._formPegawai', array('modPegawai' => $modPeg, 'form' => $form, 'model' => $model)) ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Form <b>Hukuman Poin</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'form._form', array('modPegawai' => $modPeg, 'form' => $form, 'model' => $model, 'det' => $det)) ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit')
            );
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/admin'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Nilai Point', array('{icon}'=>'<i class="'.MyIcon::getIcons('pengaturan').'"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 

            $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit2b', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php echo $this->renderPartial($this->path_view . 'js._jsFunctions', array('model' => $model, 'modDet' => $modDet)); ?>