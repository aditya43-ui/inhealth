<div class="span6">

        <?php echo $form->hiddenField($model, 'diagnosa_awal_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'politujuan_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'jenispeserta_bpjs_kode', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'jenispeserta_bpjs_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'namaasuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'no_asuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'hakkelas_kode', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group">
                <?php echo CHtml::label("No. Kartu BPJS <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getAsuransiNoKartu($('#" . CHtml::activeId($model, "no_kartu_bpjs") . "').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek peserta'></i>", 'nopeserta', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'no_kartu_bpjs', array('placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>

        <div class="control-group ">
                <?php echo CHtml::label("Jenis/Asal Rujukan", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls form-inline">
                        <?php
                        echo $form->radioButtonList($model, 'jenisrujukan', array("1" => "PCare&nbsp;&nbsp;", "2" => "Rumah Sakit"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("No.Rujukan Faskes 1<span class='required'>*</span> <i class=\"icon-search\" onclick=\"getRujukanNoRujukan($('#" . CHtml::activeId($model, "no_rujukan") . "').val());\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'no_rujukan', array('placeholder' => 'No. Rujukan', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>
        <div class="control-group ">
                <label class="control-label">
                        No. SEP
                </label>
                <div class="controls">
                        <?php echo $form->textField($model, 'no_sep', array('placeholder' => 'No. SEP Otomatis', 'class' => 'span3', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Tgl Sep <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_sep',
                                'mode' => 'date',
                                'options' => array(
                                        'dateFormat' => "yy-mm-dd",
                                        'showOn' => false,
                                        'maxDate' => 'd',
                                        'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                        'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 span2 datetime required', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                        )); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Nama PEserta BPJS <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'namapeserta_bpjs', array('placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                </div>
        </div>
        <div class="control-group ">
                <?php echo CHtml::label("Kode PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'kode_ppk_pelayanan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true,)); ?>
                </div>
        </div>
        <div class="control-group ">
                <?php echo CHtml::label("Nama PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'nama_ppk_pelayanan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true,)); ?>
                </div>
        </div>
        <div class="control-group ">
                <?php echo CHtml::label("Jenis Pelayanan <span class='required'>*</span>", 'kelastanggungan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->dropDownList($model, 'jenis_pelayanan',  array('2' => "Rawat Jalan", '1' => "Rawat Inap"), array('empty' => '--Pilih--', 'class' => 'span3 required')); ?>
                </div>
        </div>
        <div class="control-group ">
                <?php echo CHtml::label("Kelas Rawat <span class='required'>*</span>", 'kelastanggungan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->dropDownList($model, 'kelas_tanggungan', array('1' => 'Kelas I', '2' => 'Kelas II', '3' => 'Kelas III'), array(
                                'empty' => '-Pilih-', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        )); ?>
                </div>
        </div>

        <div class="control-group">
                <?php echo CHtml::label("Kode PPK Rujukan <span class='required'>*</span><i class=\"icon-search\" onclick=\"$('#dialogPpk').dialog('open');\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek ppk rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'kode_ppk_rujukan', array('placeholder' => 'Kode PPK Rujukan', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Nama PPK Rujukan <span class='required'>*</span><i class=\"icon-search\" onclick=\"$('#dialogPpk').dialog('open');\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek ppk rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'nama_ppk_rujukan', array('placeholder' => 'Nama PPK Rujukan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>
</div>
<div class="span6">
        <div class="control-group ">
                <label class="control-label required">
                        Tanggal Rujukan
                        <span class="required">*</span>
                </label>
                <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_rujukan',
                                'mode' => 'date',
                                'options' => array(
                                        'dateFormat' => "yy-mm-dd",
                                        'showOn' => false,
                                        'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('class' => 'dtPicker2 datetimemask span2 required', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                        )); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Poli Tujuan <span class='required'>*</span> <i class=\"icon-search\" onclick=\"$('#dialogPoli').dialog('open');\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'politujuan', array('placeholder' => 'Poli Tujuan', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Diagnosa Awal <span class='required'>*</span> <i class=\"icon-search\" onclick=\"$('#dialogDiagnosaBpjs').dialog('open');\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'diagnosa_awal', array('placeholder' => 'Diagnosa Awal', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>
        <div class="control-group form-inline">
                <?php echo CHtml::label("Poli Eksekutif", 'Eksekutif', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php
                        echo $form->radioButtonList($model, 'poli_eksekutif', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>
                </div>
        </div>
        <div class="control-group form-inline">
                <?php echo CHtml::label("COB", 'COB', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php
                        echo $form->hiddenField($model, 'cob', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        echo $form->textField($model, 'cob_status', array('class' => 'span1', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        ?>
                </div>
        </div>
        <div class="control-group form-inline">
                <?php echo CHtml::label("Laka Lantas", 'Lantas', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php
                        echo $form->radioButtonList($model, 'lakalantas', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setLakaLantas(this)'));
                        ?>
                </div>
        </div>
        <div class="control-group ">
                <?php echo CHtml::label("Penjamin", 'Penjamin', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->dropDownList($model, 'penjamin', array('1' => 'Jasa Raharja PT', '2' => 'BPJS Ketenagakerjaan', '3' => 'TASPEN', '4' => 'ASABRI PT'), array(
                                'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        )); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Lokasi Laka Lantas", 'lokasi_lakalantas', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'lokasilakalantas', array('placeholder' => 'Lokasi laka lantas', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("No. Telepon Peserta <span class='required'>*</span>", 'no_telpon_peserta', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'no_telepon_pasien', array('placeholder' => 'Telepon peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("User Pembuat SEP", 'pembuat_sep', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'user_approval_bpjs', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Catatan/Keterangan <span class='required'>*</span>", 'no_telpon_peserta', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textArea($model, 'catatan', array('placeholder' => '', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
        </div>


</div>