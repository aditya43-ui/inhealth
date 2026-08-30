<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'POST',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'
        ),
    )
);
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
        <?php echo CHtml::label("Tanggal Pembayaran", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget(
                    'MyDateTimePicker',
                    array(
                        'model' => $mBuktBayar,
                        'attribute' => 'tgl_awal',
                        'mode' => 'datetime',

                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'onchange' => 'setTanggalClosing()'
                        ),

                    )
                );
                ?>
            </div>
        </div>
        <div class="control-group">
        <?php echo CHtml::label("Sampai Dengan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget(
                    'MyDateTimePicker',
                    array(
                        'model' => $mBuktBayar,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    )
                );
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label("Cara Pembayaran", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($mBuktBayar, 'carapembayaran', 
                    CHtml::listData(LookupM::model()->findAll("lookup_type = 'carapembayaran'"), 'lookup_name', 'lookup_name'),
                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Pembayaran", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($mBuktBayar, 'jnspembayar_id', 
                    CHtml::listData(JnspembayarM::model()->findAll("jnspembayar_aktif = true ORDER BY jnspembayar_nama ASC"), 'jnspembayar_id', 'jnspembayar_nama'),
                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                ?>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Ruangan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($mBuktBayar, 'ruangan_id',
                        CHtml::listData(
                            $mBuktBayar->getRuanganKasir(), 'ruangan_id', 'ruangan_nama'
                        ),
                        array(
                            'inline'=>true,
                            'empty'=>'-- Pilih --',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'class' => 'span3',
                        )
                    );
                ?>
            </div>
        </div>
        <!-- <div class="control-group">
            <?php //echo CHtml::label("Shift", 'shift_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                    //echo CHtml::hiddenField('filter', 'shift_id', array('disabled' => 'disabled')); 
                    //echo  $form->dropDownList($mBuktBayar, 'shift_id', CHtml::listData(ShiftM::model()->getShiftRuangan(Yii::app()->user->getState('ruangan_id')), 'shift_id', 'shiftJam'), array(
                    //    'class' => 'span3', 'multiple' => 'multiple','onchange'=>'setFilterTanggalShift(this)',
                    //));
                ?>
            </div>
        </div> -->
        
        <div class="control-group">
            <?php echo CHtml::label('Loket Kasir', 'shift_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($mBuktBayar, 'loket_id', CHtml::listData(LoketM::model()->findAll('loket_aktif = true and iskasir = true order by loket_nama ASC'), 'loket_id', 'loket_nama'), array(
                    'class' => 'span3', 'multiple' => 'multiple'
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Create Login Pemakai', 'loginpemakai_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
				$query = "
					SELECT pegawai_m.nama_pegawai, loginpemakai_k.loginpemakai_id FROM loginpemakai_k 
					JOIN ruanganpemakai_k ON ruanganpemakai_k.loginpemakai_id = loginpemakai_k.loginpemakai_id
					JOIN pegawai_m ON loginpemakai_k.pegawai_id = pegawai_m.pegawai_id
					WHERE ruanganpemakai_k.ruangan_id = ". Yii::app()->user->getState('ruangan_id') ."
				";
				$pegawai = Yii::app()->db->createCommand($query)->queryAll();
				echo $form->dropDownList($mBuktBayar, 'create_loginpemakai_id',
					CHtml::listData($pegawai, 'loginpemakai_id', 'nama_pegawai'),
					array(
						'inline'=>true,
						'empty'=>'-- Pilih --',
						'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'class' => 'span3',
					)
				);
            ?>
            </div>
        </div>
        
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onClick' => 'onReset()')
    ); ?>
</div>
<?php
$this->endWidget();
?>
<script>
    function onReset() {
        window.open("<?php echo Yii::app()->createUrl($this->route); ?>", "_self");
    }

    function setFilterTanggalShift(obj) {
        $.post('<?php echo $this->createUrl('setTglShift'); ?>', {
            id: $(obj).val()
        }, function(data) {
            $("#BKTandabuktibayarT_tgl_awal").val(data.awal);
            $("#BKTandabuktibayarT_tgl_akhir").val(data.akhir);

        }, 'json');
    }

    $(document).ready(function() {
        // setFilterTanggalShift($("#BKTandabuktibayarT_shift_id"));
        var shift_id = jQuery('#<?php echo CHtml::activeId($mBuktBayar, 'shift_id') ?>');
        jQuery(shift_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        var loket_id = jQuery('#<?php echo CHtml::activeId($mBuktBayar, 'loket_id') ?>');
        jQuery(loket_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>