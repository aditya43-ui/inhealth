<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'staining-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#no_pendaftaran',
        ));
?>

<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Data Spesimen </b></div>
    </div>
    <div class="panel-body">
        <?php
        $modStainingGambars = MKStainingGambarT::model()->findAllByAttributes(array('staining_id' => $modStaining->staining_id), array('order' => 'staining_gambar_id asc'));
        if (!empty($modStainingGambars)) :
            foreach ($modStainingGambars as $modStainingGambar) :
                ?>
                <div class="panel panel-success">
                    <div class="panel panel-heading">
                        <div class="panel-title"> <b> Data Staining </b></div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php echo CHtml::label("Upload Gambar", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php if (!empty($modStainingGambar->gambar)) : ?>
                                    <img src="<?php echo Params::urlPemeriskaanGambarStaining() . $modStainingGambar->gambar ?>" height="200" width="200"></img>
                                <?php endif;
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"> Pemeriksaan </label>
                            <div class="controls">
                                <?php echo CHtml::textField('pemeriksaanlab_nama', $modStainingGambar->daftartindakan->daftartindakan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>

                        <?php
                        $modStainingDet = MKStainingdetT::model()->findAllByAttributes(array('staining_gambar_id' => $modStainingGambar->staining_gambar_id));
                        if (!empty($modStainingDet)) :
                            foreach ($modStainingDet as $value) :
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-success">
                                            <div class="panel panel-heading">
                                                <div class="panel-title"> <b> Data Pemeriksaan </b></div>
                                            </div>
                                            <div class="panel-body">
                                                <?php if ($modStainingGambar->daftartindakan_id == 3822) : ?>
                                                    <div class="control-group">
                                                        <label class="control-label"> Gram </label>
                                                        <div class="controls">
                                                            <?php echo $form->textField($value, 'gram', array('class' => 'span2', 'readonly' => true)); ?>
                                                        </div>
                                                        <div class="controls">
                                                            <?php echo $form->textField($value, 'gram_morfologi', array('class' => 'span2', 'readonly' => true)); ?>
                                                        </div>
                                                        <div class="controls">
                                                            <?php echo $form->textField($value, 'gram_kuantitas', array('class' => 'span2', 'readonly' => true)); ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="control-group">
                                                    <label class="control-label"> Keterangan </label>
                                                    <div class="controls">
                                                        <?php echo $form->textArea($value, 'keterangan', array('class' => 'span6', 'readonly' => true)); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label"> PPDS </label>
                                    <div class="controls">
                                        <?php echo CHtml::textField('ppds_nama', !empty($modStainingGambar->ppds_id) ? $modStainingGambar->ppds->ppds_nama : "", array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"> PPDS NIM </label>
                                    <div class="controls">
                                        <?php echo CHtml::textField('ppds_nim', !empty($modStainingGambar->ppds_id) ? $modStainingGambar->ppds->ppds_nim : "", array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label"> DPJTM </label>
                                    <div class="controls">
                                        <?php echo CHtml::textField('dpjtm_nama', !empty($modStainingGambar->dpjtm_id) ? $modStainingGambar->dpjtm->namaLengkap : "", array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"> DPJTM NIP</label>
                                    <div class="controls">
                                        <?php echo CHtml::textField('dpjtm_nip', !empty($modStainingGambar->dpjtm_id) ? $modStainingGambar->dpjtm->nomorindukpegawai : "", array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>                       
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <div class="control-group">
                    <label class="control-label"> Tanggal Pemeriksaan </label>
                    <div class="controls">
                        <?php echo CHtml::textField('tanggal_staining', MyFormatter::formatDateTimeForUser($modStaining->tanggal_staining), array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <label class="control-label"> Analis </label>
                    <div class="controls">
                        <?php echo CHtml::textField('analis_nama', $modStaining->analis->namaLengkap, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"> NIP </label>
                    <div class="controls">
                        <?php echo CHtml::textField('analis_NIP', $modStaining->analis->nomorindukpegawai, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
