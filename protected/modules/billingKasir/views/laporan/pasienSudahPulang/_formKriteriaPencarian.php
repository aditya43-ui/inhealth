<style>
    td label.checkbox {
        width: 150px;
        display: inline-block;

    }

    .checkbox.inline+.checkbox.inline {
        margin-left: 0;
    }
</style>
<fieldset>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <?php echo  Yii::t('mds', 'Search Patient') ?>
            </div>
        </div>
        <div class="panel-body">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="50%">
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Pembayaran', 'tgl_pendaftaran', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>

                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Sampai Dengan', 'sampaiDengan', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //                                                    'minDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>

                            </div>
                        </div>

                    </td>
                    <td>
                        <?php
                        echo '<table id="penjamin_tbl" style="margin-left:72px;">
                        <tr>
                            <td>' . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label>Cara&nbsp;Bayar</label></td>
                            <td>' . $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                'update' => '#penjamin',  //selector to update
                            ),
                        )) . '&nbsp;' . CHtml::checkBox('cek_penjamin', true, array('onchange' => 'cek_all_penjamin(this)', 'value' => 'cek_penjamin')) . ' <label>Cek Semua</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Penjamin</label>
                            </td>
                            <td>
                                <div id="penjamin"><label>Data tidak ditemukan.</label></div>
                            </td>
                        </tr>
                     </table>';
                        ?>
                        <?php echo CHtml::hiddenField('filter_tab', 'all'); ?>
                        <?php //echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                        ?>
                        <?php //echo $form->textFieldRow($model,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                        ?>
                        <?php //echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                        ?>
                        <?php //echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</fieldset>

<script type="text/javascript">
    function cek_all_ruangan(obj) {
        if ($(obj).is(':checked')) {
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }

    function cek_all_penjamin(obj) {
        if ($(obj).is(':checked')) {
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
</script>