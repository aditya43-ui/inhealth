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
                    <?php echo CHtml::label("Tahun Periode <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::dropDownList('tahunperiode', '', CustomFunction::getTahun(null, null), array('empty' => '-- Pilih Tahun --', 'class' => 'span3'))
                        ?>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Transaksi <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::dropDownList('jenisgaji', $model->jenisgaji, LookupM::getItemsUrutan('jenisgaji'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onchange' => 'changeJenisTransaksi();'))
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'loadData();')
            ); ?>
        </div>
    </div>
</div>