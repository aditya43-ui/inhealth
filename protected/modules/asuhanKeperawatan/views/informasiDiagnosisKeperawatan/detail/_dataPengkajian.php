<div class="">
    <div class="row">
        <div class="control-group">
            <?php echo CHtml::label('Pengkajian Kebidanan', 'iskeperawatan', array('class' => 'control-label')); ?>
            <div class="controls" style="margin-top: 5px">
                <?php echo CHtml::checkBox('iskeperawatan', false, array('uncheckValue' => 0, 'onclick' => 'cekListKebidanan(this)', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeHiddenField($modPengkajian, 'anamesa_id', array('readonly' => true, 'class' => 'span1')); ?>
                <?php echo CHtml::activeHiddenField($modPengkajian, 'pemeriksaanfisik_id', array('readonly' => true, 'class' => 'span1')); ?>
                <?php echo CHtml::hiddenField('ASPengkajianaskepT[pengkajianaskep_id]', $modPengkajian->pengkajianaskep_id, array('readonly' => true)); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group keperawatan">
                <?php echo CHtml::label('No. Pengkajian Keperawatan', 'no_pengkajian', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('ASPengkajianaskepT[no_pengkajian]', $modPengkajian->no_pengkajian, array('class' => 'span3', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group kebidanan">
                <?php echo CHtml::label('No. Pengkajian Kebidanan', 'no_pengkajian', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('ASPengkajianaskepT[no_pengkajian]', $modPengkajian->no_pengkajian, array('class' => 'span3', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_tgl', array('class' => 'control-label inline')) ?>
                <div class="controls">
                    <?php echo CHtml::textField('ASPengkajianaskepT[pengkajianaskep_tgl]', $modPengkajian->pengkajianaskep_tgl, array('readonly' => true, 'class' => 'span3')); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">

            <div class="control-group">
                <?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($modPengkajian, 'pegawai_id', array('readonly' => true));
                    $cekPegawai = PegawaiM::model()->findByPk($modPengkajian->pegawai_id);
                    $modPengkajian->pegawai_id = !empty($cekPegawai->pegawai_id) ? $cekPegawai->pegawai_id : '';
                    $modPengkajian->nama_pegawai = !empty($cekPegawai->nama_pegawai) ? $cekPegawai->nama_pegawai : '';
                    ?>

                    <?php echo CHtml::textField('ASPengkajianaskepT[nama_pegawai]', $modPengkajian->nama_pegawai, array('readonly' => true, 'class' => 'span3')); ?>
                </div>
            </div>
        </div>
    </div>
</div>