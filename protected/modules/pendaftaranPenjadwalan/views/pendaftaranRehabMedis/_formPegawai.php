<div class="control-group">
    <?php echo CHtml::label("Cari NIP <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label required')) ?>
    <div class="controls">
        <?php echo $form->hiddenField($modPasien, 'pegawai_penanggungjawab_id', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modPegawai,
            'attribute' => 'nomorindukpegawai',
            'source' => 'js: function(request, response) {
                                               var pasien_id = $("#' . CHtml::activeId($modPasien, 'pegawai_penanggungjawab_id') . '").val();
                                               $.ajax({
													url: "' . $this->createUrl('AutocompletePegawai') . '",
													dataType: "json",
													data: {
														nomorindukpegawai: request.term,
													},
													success: function (data) {
														 response(data);
													}
                                               })
                                            }',
            'options' => array(
                'minLength' => 1,
                'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($modPasien, 'pegawai_penanggungjawab_id') . '").val(ui.item.pegawai_id);
                                            $("#' . CHtml::activeId($modPegawai, 'nomorindukpegawai') . '").val(ui.item.nomorindukpegawai);
                                            $("#' . CHtml::activeId($modPegawai, 'nama_pegawai') . '").val(ui.item.nama_pegawai);
                                            $("#' . CHtml::activeId($modPegawai, 'gelardepan') . '").val(ui.item.gelardepan);
                                            $("#' . CHtml::activeId($modPegawai, 'gelarbelakang_nama') . '").val(ui.item.gelarbelakang_nama);
                                            $("#' . CHtml::activeId($modPegawai, 'unit_perusahaan') . '").val(ui.item.unit_perusahaan);
                                            $("#' . CHtml::activeId($modPegawai, 'jabatan_nama') . '").val(ui.item.jabatan_nama);
                                            return false;
                                        }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'No. Induk Pegawai',
                'onkeyup' => "return $(this).focusNextInputField(event)",
                'onblur' => "if($(this).val()=='') setPegawaiReset()",
                'class' => 'form-control delapan span4',
            ),
        ));
        ?>
        <?php echo $form->error($modPegawai, 'nomorindukpegawai'); ?>

    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("Cari " . $modPegawai->getAttributeLabel('nama_pegawai') . " <span class='required'>*</span>", 'nokartuasuransi', array('class' => 'control-label required')) ?>
    <div class="controls">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modPegawai,
            'attribute' => 'nama_pegawai',
            'source' => 'js: function(request, response) {
												$.ajax({
													url: "' . $this->createUrl('AutocompletePegawai') . '",
													dataType: "json",
													data: {
														nama_pegawai: request.term,
													},
													success: function (data) {
														response(data);
													}
												})
                                            }',
            'options' => array(
                'minLength' => 1,
                'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
										}',
                'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($modPasien, 'pegawai_penanggungjawab_id') . '").val(ui.item.pegawai_id);
                                            $("#' . CHtml::activeId($modPegawai, 'nomorindukpegawai') . '").val(ui.item.nomorindukpegawai);
                                            $("#' . CHtml::activeId($modPegawai, 'nama_pegawai') . '").val(ui.item.nama_pegawai);
                                            $("#' . CHtml::activeId($modPegawai, 'gelardepan') . '").val(ui.item.gelardepan);
                                            $("#' . CHtml::activeId($modPegawai, 'gelarbelakang_nama') . '").val(ui.item.gelarbelakang_nama);
                                            $("#' . CHtml::activeId($modPegawai, 'unit_perusahaan') . '").val(ui.item.unit_perusahaan);
                                            $("#' . CHtml::activeId($modPegawai, 'jabatan_nama') . '").val(ui.item.jabatan_nama);
                                            return false;
                                        }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'Nama Pegawai',
                'onkeyup' => "return $(this).focusNextInputField(event)",
                'onblur' => "if($(this).val()=='') setPegawaiReset()",
                'class' => 'form-control delapan span4'
            ),
        ));
        ?>
        <?php echo $form->error($modPegawai, 'nama_pegawai'); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modPegawai, 'unit_perusahaan', array('class' => 'span4 form-control', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Unit / Perusahaan', 'readonly' => true)); ?>
<div class="control-group">
    <?php echo CHtml::label("Jabatan", 'jabatan_nama', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $modPegawai->jabatan_nama = (!empty($modPegawai->jabatan_id) ? $modPegawai->jabatan->jabatan_nama : "");
        echo $form->textField($modPegawai, 'jabatan_nama', array('class' => 'span4 form-control', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Jabatan', 'readonly' => true));
        ?>
        <?php echo $form->error($modPegawai, 'jabatan_id'); ?>
    </div>
</div>