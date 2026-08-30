<?php

/**
 * digunakan untuk pencarian
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
?>
<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));

    $format = new MyFormatter();
    ?>

    <?php //echo CHtml::hiddenField('type', ''); 
    ?>
    <?php //echo CHtml::hiddenField('src', ''); 
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
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
                <?php echo CHtml::label('Jenis', 'jenisobatalkes_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->ItemsFarmasi, 'jenisobatalkes_id', 'jenisobatalkes_nama'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Kategori', 'obatalkes_kategori', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label('Golongan', 'obatalkes_golongan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        ); ?>
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
    </div>
</div>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php $this->renderPartial($this->path_view_gudang . '_jsFunctions', array('model' => $model)); ?>