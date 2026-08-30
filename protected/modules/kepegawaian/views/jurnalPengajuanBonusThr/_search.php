<div class="row">
    <div class="col-sm-6" id="form_cari">
        <div class="control-group">
            <label class="control-label">Periode</label>
            <div class="controls">
                <?php
                $this->widget('MyMonthPicker', array(
                    'name' => 'form_cari[periodegaji]',
                    'value' => MyFormatter::formatMonthForUser(date('Y-m')),
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                        'yearRange' => "-100y:+0y",
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => "span2 periode_gaji",
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'onchange' => 'getDataPengajuanPeriode();',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis Transaksi</label>
            <div class="controls">
                <?php echo CHtml::dropDownList('form_cari[jenisgaji]', null, LookupM::getItems('jenisgaji'), array('empty' => '-- Pilih --', 'readonly' => false, 'class' => 'span2', 'onchange' => 'getDataPengajuanPeriode()')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jumlah Pegawai yang Diajukan</label>
            <div class="controls">
                <?php echo CHtml::textField('jumlah_pegawai', 0, array('readonly' => true, 'class' => 'integer2 span1')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Total Pengajuan <span class="jenistransaksi">THR</span></label>
            <div class="controls">
                <?php echo CHtml::textField('total_pengajuan', 0, array('readonly' => true, 'class' => 'integer-decimal span2')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Total PPh 21</label>
            <div class="controls">
                <?php echo CHtml::textField('total_pph21', 0, array('readonly' => true, 'class' => 'integer-decimal span2')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Total Take Home Pay</label>
            <div class="controls">
                <?php echo CHtml::textField('total_thp', 0, array('readonly' => true, 'class' => 'integer-decimal span2')); ?>
            </div>
        </div>
    </div>
</div>

<?php echo CHtml::hiddenField('form_cari[pengbonusthrdetail_id]', '', array('readonly' => true, 'class' => 'pengbonusthrdetail_id')); ?>