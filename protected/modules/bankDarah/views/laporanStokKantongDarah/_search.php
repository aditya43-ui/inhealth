<?php

/**
 ** - digunakan sebagai informasi stok kantong darah
 **  @author Aida Rahmawati <aidarahmawati@.com>
 **/
?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'laporanstokkantongdarah-v-search',
    'type' => 'horizontal',
    'focus' => '#',
));
$format = new MyFormatter();
?>

<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Periode Laporan", 'waktu_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
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
                echo $form->dropDownList($model, 'singkatan_komp', CHtml::listData(KomponendarahM::model()->findAll($criteria), 'singkatan_komp', 'singkatan_komp'), array('class' => 'span4', 'empty' => '-- Pilih --')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("Golongan Darah", 'gol_darah', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'gol_darah', LookupM::getItems('golongandarah'), array('class' => 'span2', 'empty' => '-- Pilih --')) ?>
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
    //        $tips = array(
    //            '0' => 'tanggal',
    //            '1' => 'cari',
    //            '2' => 'ulang'
    //        );
    //        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
    //        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>