<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label('Kode Kabupaten/Kota', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('kode_kabupaten', '', array('class' => 'span3', 'placeholder' => 'Kode Kabupaten/Kota')); ?>
            </div>
        </div>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => false, 'onclick' => 'searchData();return false;', 'title' => "Klik untuk mencari Kecamatan", 'rel' => "tooltip",)
        ); ?>
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
</div>