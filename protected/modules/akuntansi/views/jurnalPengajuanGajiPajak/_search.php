

<div class="col-sm-6" id="form_cari">
    <div class="control-group">
        <label class="control-label">Periode Gaji</label>
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
        <label class="control-label">Kategori Pegawai Asal</label>
        <div class="controls">
            <?php echo CHtml::dropDownList('form_cari[kategori]', null, LookupM::getItems('kategoriasalpegawai'), array('empty'=>'-- Pilih --','readonly' => false, 'class'=>'span2', 'onchange'=>'getDataPengajuanPeriode()')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Jumlah Pegawai yang Diajukan</label>
        <div class="controls">
            <?php echo CHtml::textField('jumlah_pegawai', 0, array('readonly' => true, 'class'=>'integer2 span3')); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Total Pengajuan Gaji</label>
        <div class="controls">
            <?php echo CHtml::textField('total_pengajuan', 0, array('readonly' => true, 'class'=>'integer2 span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Total BPJS Ketenagakerjaan</label>
        <div class="controls">
            <?php echo CHtml::textField('total_bpjsketenagakerjaan', 0, array('readonly' => true, 'class'=>'integer2 span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Total BPJS Kesehatan</label>
        <div class="controls">
            <?php echo CHtml::textField('total_bpjskesehatan', 0, array('readonly' => true, 'class'=>'integer2 span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Total PPh 21</label>
        <div class="controls">
            <?php echo CHtml::textField('total_pajak', 0, array('readonly' => true, 'class'=>'integer2 span3')); ?>
        </div>
    </div>
</div>
<?php echo CHtml::hiddenField('form_cari[penggajianpeg_id]', '', array('readonly' => true, 'class'=>'penggajianpeg_id')); ?>
<div class="clear"></div>