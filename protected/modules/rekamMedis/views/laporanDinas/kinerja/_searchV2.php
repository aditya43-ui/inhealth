<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <?php
    $tahun = date('Y');
    $arrTahun = array();
    while ($tahun > 2016) {
        $arrTahun[$tahun] = $tahun;
        $tahun--;
    }
    ?>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow($model, 'tahun', $arrTahun, array('class' => 'form-control span3')); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow($model, 'bulan', Params::getBulan2(), array('class' => 'form-control span3')); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton('<i class="entypo-search"></i> Cari', array(
            'type' => 'submit', 'class' => 'btn btn-danger',
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