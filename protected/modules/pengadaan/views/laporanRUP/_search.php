<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'laporanrup-v-search',
        'type' => 'horizontal',
    ));
    $format = new MyFormatter();
    ?>
    <div class="row-fluid">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label"> Periode Anggaran </label>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'periodeanggaran_id', $model->getPeriodeAnggaran(), array('empty' => '--Pilih--', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> Kode Kegiatan</label>
                <div class="controls">
                    <?php
                    echo $form->textField($model, 'kode_kegiatan', array('class' => 'span4',));
                    ?>
                </div>
            </div>  
            <div class="control-group">
                <label class="control-label"> Pejabat Pembuat Komitmen </label>
                <div class="controls">
                    <?php
                    echo $form->textField($model, 'nama_ppk', array('class' => 'span4',));
                    ?>
                </div>
            </div>  
            <div class="control-group">
                <label class="control-label"> Kuasa Pengguna Anggaran </label>
                <div class="controls">
                    <?php
                    echo $form->textField($model, 'nama_kpa', array('class' => 'span4',));
                    ?>
                </div>
            </div>  
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label"> Unit Kerja </label>
                <div class="controls">
                    <?php
                    echo $form->textField($model, 'namaunitkerja', array('class' => 'span4',));
                    ?>
                </div>
            </div>
            <div class = "control-group">
                <?php echo Chtml::label("Status", 'rencanaumumpengadaan_status', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->dropDownList($model, 'rencanaumumpengadaan_status', LookupM::getItems('statusrencanaumumpengadaan'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'class' => 'span4'));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $this->widget('bootstrap.widgets.BootAlert');
    ?>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array(
            'class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('index') . '";}); return false;')) . "&nbsp;";
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>