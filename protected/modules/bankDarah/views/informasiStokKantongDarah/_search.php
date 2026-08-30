<?php

/**
 ** - digunakan sebagai informasi stok kantong darah
 **  @author Aida Rahmawati <aidarahmawati@.com>
 **/
?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'stokkantongdarah-r-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
));
$format = new MyFormatter();
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("Komponen Darah", 'komponendarah_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $criteria = new CDbCriteria();
                $criteria->select = 'singkatan_komp';
                $criteria->group = 'singkatan_komp';
                $criteria->order = 'singkatan_komp ASC';
                $criteria->addCondition('komponendarah_aktif = true');
                echo $form->dropDownList($model, 'singkatan_komp', CHtml::listData(KomponendarahM::model()->findAll($criteria), 'singkatan_komp', 'singkatan_komp'), array('empty' => '-- Pilih --')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("Golongan Darah", 'gol_darah', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'gol_darah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --')) ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>