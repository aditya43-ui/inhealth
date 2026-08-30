<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pengajuanpetty_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php

                $model->pengajuanpetty_tgl = MyFormatter::formatDateTimeForUser($model->pengajuanpetty_tgl);
                echo $form->textField($model, 'pengajuanpetty_untuk', array('class' => 'form-control realtime span4', 'readonly' => true));
                ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'pengajuanpetty_no', array('class' => 'form-control span4', 'readonly' => true)) ?>
        <div class="control-group">
            <?php echo CHtml::label('Kategori <span class="required">*</span>', 'pengajuanpetty_kategori', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'pengajuanpetty_kategori', LookupM::getItems('kategori_pettycash'), array('class' => 'span4')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Alasan Pengajuan <span class="required">*</span>', 'pengajuanpetty_untuk', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'pengajuanpetty_untuk', array('placeholder' => 'Alasan Pengajuan', 'class' => 'form-control autogrow span4')) ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Pegawai yang Mengajukan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true)); ?>
                <?php echo $form->textField($modPegawai, 'nama_pegawai', array('readonly' => true)) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('NIP', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPegawai, 'nomorindukpegawai', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Unit Kerja", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPegawai, 'unitkerja_id', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jabatan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPegawai, 'jabatan_id', array('readonly' => true)); ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pengajuan Anggaran Operasional</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php echo $this->renderPartial($this->path_view . 'table/_tableItems', array('model' => $model, 'form' => $form, 'det' => $det), true); ?>
    </div>
</div>