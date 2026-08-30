<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::label('Kode Provinsi', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('kode_propinsi', '', array('class' => 'span3', 'placeholder' => 'Ketikan Kode Provinsi')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary span12', 'type' => 'button', 'disabled' => false, 'onclick' => 'searchData();return false;', 'title' => "Klik untuk mencari Kabupaten", 'rel' => "tooltip",)); ?>
        </div>

    </div>
</div>