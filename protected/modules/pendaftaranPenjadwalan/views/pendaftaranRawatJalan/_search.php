<div class="panel panel-success">
<div id="search-form">
    <div class="col-sm-6 form-horizontal">   
        <div class="control-group">
            <?php echo CHtml::label('Jam Panggil', '', array('class' => 'control-label')) ?> 
            <div class="controls">
                <?php  
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modAntrian,
                        'attribute' => 'jam_panggil',
                        'mode' => 'time',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,                       
                        ),
                        'htmlOptions' => array(
                            'class' => 'span3 tgl_jadwal',
                            'placeholder' => 'Silakan pilih jam panggil',
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label('Barcode', '', array('class' => 'control-label')) ?> 
            <div class="controls">
                <?php echo CHtml::activeTextField($modAntrian, 'barcode', array('placeholder' => 'Ketik Nomor Barcode', 'class' => 'span4',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>           
        <div class="control-group">
            <?php echo CHtml::label('No Antrian', '', array('class' => 'control-label')) ?> 
            <div class="controls">
                <?php echo CHtml::activeTextField($modAntrian, 'noantrian', array('placeholder' => 'Ketik Nomor Antrian', 'class' => 'span4',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>  
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Poliklinik', '', array('class' => 'control-label')) ?> 
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modAntrian, 'ruangan_id', RuanganM::arrRuanganId(Params::INSTALASI_ID_RJ), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Jenis Kunjungan', '', array('class' => 'control-label')) ?> 
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modAntrian, 'jenis_kunjungan', LookupM::getItemsUrutan('jeniskunjunganantrian'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Status', '', array('class' => 'control-label')) ?> 
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modAntrian, 'status_barcode', [
                    'Belum Barcode' => 'Belum Barcode',
                    'Sudah Barcode' => 'Sudah Barcode',
                    'Terlambat' => 'Terlambat',
                ],array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
</div>
<div class="actions clear">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'id' => 'btn_cari', 'onclick' => 'refreshGridAntrian("panel-pencarian")')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>  
</div>
            </div>
