<?php 
$jeniskantong = '-';
if (!empty($cekKantong)) {
    $jenisKantong = JeniskantongdarahM::model()->findByPk($cekKantong->jeniskantongdarah_id);
    $jeniskantong = $jenisKantong->nama_jenis;
}
$radioTemplate = '{input} <span style="margin-right: 30px;">{label}</span>';
?>
<div class="panel panel-darkk">
    <span class="group-title">
        Data Kantong Darah
    </span>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Jenis Kantong Darah", "", array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('jeniskantong', $jeniskantong, array('readonly' => true,'class'=>'span3')); ?>
                </div>
            </div>            
            <?php
            $cekPenggunaanCoolbox = PenggunaanCoolboxdetT::model()->findByAttributes(array('daftardonasi_id' => $_GET['daftardonasi_id']));
            if (!empty($cekPenggunaanCoolbox)) {
                if (date('Y-m-d', (strtotime($model->create_time))) == date('Y-m-d')) {
                    ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Pilih Coolbox <span class="required">*</span> ', '', array('class' => 'control-label required')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPenggunaan, 'penggunaan_coolbox_id', CHtml::listData(PenggunaanCoolboxT::model()->findAllByAttributes(array('tgl_penggunaan_coolbox' => date('Y-m-d'))), 'penggunaan_coolbox_id', 'coolboxdarah.coolboxdarah_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>				 
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Pilih Coolbox <span class="required">*</span> ', '', array('class' => 'control-label required')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPenggunaan, 'penggunaan_coolbox_id', CHtml::listData(PenggunaanCoolboxT::model()->findAll(), 'penggunaan_coolbox_id', 'coolboxdarah.coolboxdarah_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>				 
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Pilih Coolbox <span class="required">*</span> ', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPenggunaan, 'penggunaan_coolbox_id', CHtml::listData(PenggunaanCoolboxT::model()->findAllByAttributes(array('tgl_penggunaan_coolbox' => date('Y-m-d'))), 'penggunaan_coolbox_id', 'coolboxdarah.coolboxdarah_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>				 
                    </div>
                </div>
            <?php } ?>
            <div class="control-group">
                <label class="control-label">Volume Kantong Darah</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'volume', array('class' => 'span3')); ?> <label>ml</label>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <label class="control-label">Sampel Konfirmasi Golongan Darah</label>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'ada_sampelkonfirmasi', array('Ada' => 'Ada', 'Tidak Ada' => 'Tidak Ada'), array('readonly' => false, 'template' => $radioTemplate)); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Sampel Skrining IMLTD</label>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'ada_sampelimltd', array('Ada' => 'Ada', 'Tidak Ada' => 'Tidak Ada'), array('readonly' => false, 'template' => $radioTemplate)); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Kantong Darah</label>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'ada_kantongdarah', array('Ada' => 'Ada', 'Tidak Ada' => 'Tidak Ada'), array('readonly' => false, 'template' => $radioTemplate)); ?>
                </div>
            </div>
        </div>
    </div>
</div>