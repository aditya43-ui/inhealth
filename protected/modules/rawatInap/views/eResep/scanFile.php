<?php
$this->breadcrumbs = array(
    'Scan Resep',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Scan Resep
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pelayananpasien-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event);',
                'onsubmit' => 'return beforeSubmit(this);',
            ), //DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#instalasi_id',

        )); ?>

        <?php //echo $this->renderPartial($this->path_view.'_ringkasDataPasien', array('form'=>$form,'modKunjungan'=>$modKunjungan), true); 
        ?>
        <?php
        //check apakah Prescribing atau tidak;
        if ($this->init_modul == 'PC') {
        ?>
            <?php echo $this->renderPartial($this->path_view . '_ringkasDataPasienPC', array('form' => $form, 'modKunjungan' => $modKunjungan), true); ?>
        <?php
        } else {
        ?>
            <?php echo $this->renderPartial($this->path_view . '_ringkasDataPasien', array('form' => $form, 'modKunjungan' => $modKunjungan), true); ?>
        <?php
        }
        ?>
        <?php echo $this->renderPartial($this->path_view . '_formInputObatScan', array('form' => $form, 'modReseptur' => $modReseptur), true); ?>
        <?php echo $this->renderPartial($this->path_view . '_dpjp', array('form' => $form, 'modReseptur' => $modReseptur), true); ?>
        <?php echo $this->renderPartial($this->path_view . '_jsFunctionScan', array('form' => $form, 'modReseptur' => $modReseptur, 'modKunjungan' => $modKunjungan), true); ?>
        <div class="clear"></div>
        <div class="form-actions">
            <?php /* <input type="button" value="Cari" class="btn" style="padding:3px;" margin="6px;" width="50px;" onclick="location.href='Scanner:';" /> */ ?>
            <?php
            if (!$modReseptur->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('class' => 'btn btn-danger submit', 'id' => 'btn_submit', 'disabled' => true)
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                // echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printRecordTerakhir(\'PRINT\')')); 
                // echo CHtml::htmlButton(Yii::t('mds','{icon} Print Resep',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printResep(\'PRINT\')')); 
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan','class' => 'btn btn-danger submit', 'id' => 'btn_submit', 'type' => 'submit')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        //'disabled'=>true,
                        'title' => 'Ulang',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                // echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-info', 'type'=>'button','disabled'=>'disabled')); 
                // echo CHtml::htmlButton(Yii::t('mds','{icon} Print Resep',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-info', 'type'=>'button','disabled'=>'disabled')); 
            }
            ?>

            <?php $content = $this->renderPartial('rawatInap.views.tips.tips', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content)); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>