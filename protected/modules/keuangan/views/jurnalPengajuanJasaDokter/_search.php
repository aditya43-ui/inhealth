

<div class="col-sm-6" id="form_cari">
    <div class="control-group">
        <label class="control-label">Periode Pengajuan Jasa</label>
        <div class="controls">
            <?php
            $this->widget('MyMonthPicker', array(
                            'name' => 'form_cari[periodegaji]',
                            'value' => MyFormatter::formatMonthForUser(date('Y-m')),
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                                'yearRange' => "-100y:+0y",
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'class' => "span2 periode_gaji",
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onchange' => 'getDataPengajuanPeriode();',
                            ),
                        )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Jumlah Dokter yang Diajukan</label>
        <div class="controls">
            <?php echo CHtml::textField('jumlah_pegawai', 0, array('readonly' => true, 'class'=>'integer2 span3')); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Total Pengajuan Jasa</label>
        <div class="controls">
            <?php echo CHtml::textField('total_pengajuan', 0, array('readonly' => true, 'class'=>'integer2 span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Total Pajak Dokter (PPh 21)</label>
        <div class="controls">
            <?php echo CHtml::textField('total_pajak', 0, array('readonly' => true, 'class'=>'integer2 span3')); ?>
        </div>
    </div>
</div>
<?php echo CHtml::hiddenField('form_cari[pembayaranjasa_id]', '', array('readonly' => true, 'class'=>'pembayaranjasa_id')); ?>
<div class="clear"></div>