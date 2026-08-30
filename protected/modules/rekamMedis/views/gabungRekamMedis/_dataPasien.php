<div class="control-group">
    <?php echo CHtml::label($rm_label, 'pasien_id', array('class' => 'control-label required')); ?>
    <div class="controls">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'name' => 'pasien' . "[" . $id . '][no_rekam_medik]',
            'source' => 'js: function(request, response) {
			console.log(request);
			$.ajax({
                        url: "' . $this->createUrl('autocompleteNoRM') . '",
                        dataType: "json",
                        data: {
                            no_rm: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
		}',
            'options' => array(
                'minLength' => 3,
                'focus' => 'js:function( event, ui ) {
				$(this).val("");
				return false;
			}',
                'select' => 'js:function( event, ui ) {
				$(this).val(ui.item.no_rekam_medik	);
				$("#pasien_' . $id . '_no_rekam_medik").val(ui.item.no_rekam_medik);
				inputPasien(ui.item, ' . $id . ');
				return false;
			}',
            ),
            // 'tombolDialog'=>array('idDialog'=>'dialogPasien'),
            'htmlOptions' => array(
                'class' => 'span4 required',
                'placeholder' => 'No. Rekam Medik',
                'rel' => 'tooltip',
                // 'title' => 'Ketik nama pasien atau klik icon untuk mencari data pasien',
                'onkeyup' => "return $(this).focusNextInputField(event)",
            ),
        ));
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Nama Pasien', '', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::hiddenField('pasien[' . $id . '][pasien_id]', null, array('class' => 'input_' . $id)); ?>
        <?php echo CHtml::textField('pasien[' . $id . '][nama_pasien]', null, array('disabled' => true, 'class' => 'span4 input_' . $id)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Tgl. Lahir', '', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::textField('pasien[' . $id . '][tanggal_lahir]', null, array('disabled' => true, 'class' => 'span4 input_' . $id)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Jenis Kelamin', '', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::textField('pasien[' . $id . '][jeniskelamin]', null, array('disabled' => true, 'class' => 'span4 input_' . $id)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Alamat Pasien', '', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::textField('pasien[' . $id . '][alamat_pasien]', null, array('class' => 'span4', 'disabled' => true)); ?>
    </div>
</div>