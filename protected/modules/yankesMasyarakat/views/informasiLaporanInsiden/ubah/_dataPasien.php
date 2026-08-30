<?php ?>
<div class="span6">
    <?php
    $ruangan = "";
    $instalasi = "";
    if (!empty($model->ruangan_id)) {
        $cekRuangan = RuanganM::model()->findByPk($model->ruangan_id);
        $ruangan = $cekRuangan->ruangan_nama;
    } else {
        $ruangan = '-';
    }
    if (!empty($model->instalasi_id)) {
        $instalasi = InstalasiM::model()->findByPk($model->instalasi_id)->instalasi_nama;
    }
    $model->tanggal_masukrs = MyFormatter::formatDateTimeForUser($model->tanggal_masukrs);
    ?>
    <div class="control-group">
        <?php
        echo $form->labelEx($model, 'no_rekam_medik', array('class' => 'control-label-left', 'label' => '1. No. Rekam Medik <span class="required">*</span>',));
        ?>
        <div class="controls">
            <?php
            if (!empty($model->diagnosa_id)) {
                $diagnosa = DiagnosaM::model()->findByAttributes(array('diagnosa_id' => $model->diagnosa_id));
                $model->diagnosa_nama = $diagnosa->diagnosa_nama;
                $diagnosa_id = $diagnosa->diagnosa_id;
            }

            $this->widget('MyJuiAutoComplete', array(
                'name' => 'no_rekam_medik',
                'value' => $model->norekammedik,
                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompleteKunjunganPasien') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           tipe: 1,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                    'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.label);
                                setKunjungan(ui.item);
                                return false;
                            }',
                ),
                'htmlOptions' => array(
                    'disabled' => false,
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'class' => 'span3 no_rekam_medik required',
                    'disabled' => !$model->isNewRecord,
                ),
                'tombolDialog' => $model->isNewRecord ? array('idDialog' => 'dialogPasien') : null,
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('2. Nama Pasien', 'nama_pasien', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <?php
            echo CHtml::textField("nama_pasien", $model->nama_pasien, array(
                'readonly' => true,
                'class' => 'span3',
                'onblur' => 'return false;',
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('3. Umur', 'umur', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <?php
            echo CHtml::textField("umur", $model->umur, array(
                'readonly' => true,
                'class' => 'span3',
                'onblur' => 'return false;',
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('4. Jenis Kelamin', 'jeniskelamin', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <?php
            echo CHtml::textField("jeniskelamin", $model->jenis_kelamin, array(
                'readonly' => true,
                'class' => 'span3',
                'onblur' => 'return false;',
            ));
            ?>
        </div>
    </div>
</div>
<div class="span6">
    <div class="control-group">
        <?php echo CHtml::label('5. Instalasi', 'instalasi_pasien', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <?php
            echo CHtml::textField("instalasi_pasien", $instalasi, array(
                'readonly' => true,
                'class' => 'span3',
                'onblur' => 'return false;',
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('6. Ruangan', 'ruangan_pasien', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <?php
            echo CHtml::textField("ruangan_pasien", $ruangan, array(
                'readonly' => true,
                'class' => 'span3',
                'onblur' => 'return false;',
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('7. Penanggung Biaya', 'penanggungbiaya', array('class' => 'control-label-left')) ?>
        <div class="controls">
            <?= $form->radioButtonList($model, 'penanggungjawab_biaya', LookupM::getItemsUrutan('penanggungbiayapasien'), ['template' => ' {input} {label} ', 'separator' => '', 'onChange' => 'pilihPenanggung(this)', 'class' => 'penanggungjawab_biaya']) ?>
        </div>
    </div>
    <div class="control-group">
        <label class=" control-label-left">&nbsp;</label>
        <div class="controls">
            <?= $form->textField($model, 'penanggungjawabpasien_lainnya_ket', ['class' => 'span3', 'placeHolder' => 'Lainnya..', 'readonly' => true]); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label('8. Tanggal Masuk RS', 'tanggalmasukrs', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <?php
            echo CHtml::textField("tanggal_kunjungan", $model->tanggal_masukrs, array(
                'readonly' => true,
                'class' => 'span3',
                'onblur' => 'return false;',
            ));
            echo $form->hiddenField($model, 'pendaftaran_id', array(
                'readonly' => true,
                'class' => 'span3',
                'onblur' => 'return false;',
            ));
            ?>

        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('9. Diagnosa <span class="required">*</span>', 'diagnosa_id', array('class' => 'control-label-left required')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'diagnosa_nama',
                'source' => 'js: function(request, response) {
                    $.ajax({
                            url: "' . $this->createUrl('AutoCompleteDiagnosa') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                    })
                 }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'select' => 'js:function( event, ui ) {
                            $(this).val( ui.item.diagnosa_nama );
                            $("#InsidenrsT_diagnosa_nama").val( ui.item.diagnosa_nama );
                            $("#InsidenrsT_diagnosa_id").val( ui.item.diagnosa_id );
                            return false;
                }',
                ),
                'htmlOptions' => array(
                    'class' => 'required',
                ),
            ));
            echo $form->hiddenField($model, 'diagnosa_id', array(
                'readonly' => true,
                'class' => 'span3',
                'onblur' => 'return false;',
            ));
            ?>
        </div>
    </div>
</div>