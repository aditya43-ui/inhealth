<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tahun Periode Jasa <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::dropDownList('tahunperiode', '', CustomFunction::getTahun(null, null), array('empty' => '-- Pilih Tahun --', 'class' => 'span3'))
                        ?>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Pajak", 'jenis_pajak', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('pajak_id', $model->pajak_id, array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo CHtml::textField('pajak_nama', $model->pajak_nama, array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'loadDataFaktur();')
            ); ?>
        </div>
    </div>
</div>