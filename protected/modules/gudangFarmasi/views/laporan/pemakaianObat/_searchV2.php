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
        'id' => 'search-laporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?php
            $tahun = date('Y');
            $arrTahun = array();

            while ($tahun > 2016) {
                $arrTahun[$tahun] = $tahun;
                $tahun--;
            }

            echo $form->dropDownListRow($model, 'tahun', $arrTahun, array('class' => 'form-control span3'));
            echo $form->dropDownListRow($model, 'bulan', Params::getBulan2(), array('class' => 'form-control span3'));
            echo $form->hiddenField($model, 'tabmenu', array('readonly' => true))
            ?>
            <div class="control-group">
                <?php echo CHtml::label('Kategori', 'obatalkes_kategori', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
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

            <div class="control-group" id="cari-pakaiobat">
                <?php echo CHtml::label('Status', 'status', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'status', LookupM::getItems('status_obatterpakai'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>

            <div class="control-group" id="cari-rekappakaiobat" style='display:none;'>
                <?php echo CHtml::label('Jenis Penjualan', 'status', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jenispenjualan', LookupM::getItems('jenispenjualan'), array(
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
    <div class="form-actions">
        <?php echo CHtml::htmlButton('<i class="entypo-search"></i> Cari', array(
            'title' => 'Cari', 'type' => 'submit', 'class' => 'btn btn-danger',
        )); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>