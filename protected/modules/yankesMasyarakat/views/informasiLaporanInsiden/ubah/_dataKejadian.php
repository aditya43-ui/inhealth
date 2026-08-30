<div class="span6">
    <div class="control-group">
        <?php echo CHtml::label('1. Tanggal Pelaporan <span class="required">*</span>', 'insidenrs_tgllapor', array('class' => 'control-label-left required')) ?>
        <div class="controls">
            <?php
            echo $form->textField($model, 'insidenrs_tgllapor', array('class' => 'span3', 'readonly' => true));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('2. Tanggal dan Waktu Insiden <span class="required">*</span>', 'insidenrs_tglinsiden', array('class' => 'control-label-left required')) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'insidenrs_tglinsiden',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'readonly' => false,
                    'class' => 'dtPicker2-5 span3 required',
                    'placeholder' => 'Pilih Tanggal Insiden',
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('3. Insiden <span class="required">*</span>', 'insidenrs_tglinsiden', array('class' => 'control-label-left required')) ?>
        <div class="controls"> 
            <?php echo $form->textField($model, 'insidenrs_nama', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('4. Kronologis <span class="required">*</span>', 'insidenrs_kronologis', array('class' => 'control-label-left required')) ?>
        <div class="controls"> 
            <?php echo $form->textArea($model, 'insidenrs_kronologis', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('5. Jenis Insiden <span class="required">*</span>', 'insidenrs_jenis', array('class' => 'control-label-left required')) ?>
        <div class="controls"> 
            <?php
            echo $form->dropDownList($model, 'insidenrs_jenis', LookupM::getItems('jenisinsiden'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'span3 required'));
            ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label('6. Orang yang Pertama Melaporkan <span class="required">*</span>', 'insidenrs_pelapor', array('class' => 'control-label-left required')) ?>
        <div class="controls"> 
            <?php
            echo $form->dropDownList($model, 'insidenrs_pelapor', LookupM::getItems('pelaporinsidenpertama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'span3 required'));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('7. Insiden yang menyangkut pasien', 'insidenrs_menyangkutpasien', array('class' => 'control-label-left required')) ?>
        <div class="controls"> 
            <?php
            echo $form->dropDownList($model, 'insidenrs_menyangkutpasien', LookupM::getItems('jenispasien'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'span3 required'));
            ?>
        </div>
    </div>
    <div class="control-group">

        <?php echo CHtml::label('8. Ruangan Kejadian <span class="required">*</span>', 'lokasikejadian_id', array('class' => 'control-label-left required')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'lokasikejadian_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutoCompleteRuangan') . '",
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
                    'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function(event, ui ) {
                            $("#InsidenrsT_lokasikejadian_id").val(ui.item.ruangan_id);
                            $(this).val(ui.item.label);
                            refreshDialog();
                            return false;
                        }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikan nama ruangan',
                    'onblur' => 'if($(this).val()==""){clearRuangan();}',
                ),
                'tombolDialog' => array('idDialog' => 'dialogRuangan', 'idTombol' => 'tombolDialogRuangan'),
            ));
            echo CHtml::activeHiddenField($model, 'lokasikejadian_id', array('class' => 'span3', 'readonly' => true));
            ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label-margin">Unit Kerja Kejadian </label>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'unitkerjatempat_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true, 'placeholder' => 'unit kerja')); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'unitkerja',
                'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('AutocompleteUnitKerjaRuangan') . '",
                        dataType: "json",
                        data: {
                            term: request.term,
                            ruangan_id: $("#InsidenrsT_lokasikejadian_id").val()
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function(event, ui ) {
                        return false;
                    }',
                    'select' => 'js:function(event, ui ) {
                        $("#InsidenrsT_unitkerjatempat_id").val(ui.item.unitkerja_id);
                        $("#InsidenrsT_mengetahui_id").val(ui.item.kepalaunitpeg_id);
                        $("#InsidenrsT_mengetahui_nama").val(ui.item.kepalaunitpeg_nama);
                        $(this).val(ui.item.label);
                        return false;
                    }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 ', 'placeholder' => 'Ketikan nama Unit Kerja',
                    'onblur' => 'if($(this).val() == ""){ $("#InsidenrsT_unitkerjatempat_id").val(""); }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogUnitKerja'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">        
        <?php echo CHtml::label('Mengetahui Atasan Kejadian <span class="required">*</span>', 'lokasikejadian_id', array('class' => 'control-label-margin required')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'mengetahui_id', array('readonly' => true));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'mengetahui_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/actionAutoComplete/DropPetugasSemua') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                unitkerja_id:$("#' . CHtml::activeId($model, 'unitkerjatempat_id') . '").val(),
                                default:getDefault()
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function(event, ui ) {
                            setPetugas(ui.item);
                            return false;
                        }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikan nama petugas',
                    'onblur' => 'if($(this).val()==""){$("#' . CHtml::activeId($model, 'mengetahui_id') . '").val("");}',
                ),
                'tombolDialog' => array('idDialog' => 'dialogPetugas', 'jsFunction' => 'refreshPetugas();'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Mengetahui Kepala Instalasi <span class="required">*</span>', '', array('class' => 'control-label-margin')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'mengetahui_kepalainstalasi_kejadian_id', array('class' => 'span3', 'readonly' => true));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'mengetahui_kepalainstalasi_kejadian_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('getPegawai') . '",
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
                    'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function(event, ui ) {
                            $(this).val(ui.item.nama_pegawai);
                            $("#InsidenrsT_mengetahui_kepalainstalasi_kejadian_id").val( ui.item.value );
                            return false;
                        }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Pilih Nama Pegawai',
                ),
                'tombolDialog' => array('idDialog' => 'dialogKepalaInstalasiKejadian', 'idTombol' => 'tombolDialogPenelitian'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('9. Ruangan Penyebab <span class="required">*</span>', 'ruanganpenyebab_id', array('class' => 'control-label-left required')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'ruanganpenyebab_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteRuangan') . '",
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
                    'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function(event, ui ) {
                            $("#InsidenrsT_ruanganpenyebab_id").val(ui.item.ruangan_id);
                            $(this).val(ui.item.label);
                            refreshDialogPenyebab();
                            return false;
                        }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikan nama ruangan',
                    'onblur' => 'if($(this).val()==""){clearRuanganUnit();}',
                ),
                'tombolDialog' => array('idDialog' => 'dialogRuanganPenyebab'),
            ));
            echo CHtml::activeHiddenField($model, 'ruanganpenyebab_id', array('class' => 'span3 ', 'readonly' => true));
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label-margin">Unit Kerja Penyebab</label>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'unitkerjapenyebab_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true, 'placeholder' => 'unit kerja')); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'unitkerjapenyebab_nama',
                'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('AutocompleteUnitKerjaRuangan') . '",
                        dataType: "json",
                        data: {
                            term: request.term,
                            ruangan_id: $("#InsidenrsT_ruanganpenyebab_id").val()
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function(event, ui ) {
                        return false;
                    }',
                    'select' => 'js:function(event, ui ) {
                        $("#InsidenrsT_unitkerjapenyebab_id").val(ui.item.unitkerja_id);
                        $("#InsidenrsT_mengetahui_kepalaunitpenyebab_id").val(ui.item.kepalaunitpeg_id);
                        $("#InsidenrsT_mengetahui_kepalaunitpenyebab_nama").val(ui.item.kepalaunitpeg_nama);
                        $(this).val(ui.item.label);
                        return false;
                    }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'placeholder' => 'Ketikan nama Unit Kerja',
                    'onblur' => 'if($(this).val() == ""){ $("#InsidenrsT_unitkerjapenyebab_id").val(""); }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogUnitKerjaPenyebab'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">        
        <?php echo CHtml::label('Mengetahui Atasan Penyebab <span class="required">*</span>', 'lokasikejadian_id', array('class' => 'control-label-margin required')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'mengetahui_kepalaunitpenyebab_id', array('readonly' => true));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'mengetahui_kepalaunitpenyebab_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/actionAutoComplete/DropPetugasSemua') . '",
                            dataType: "json",
                            data: {
                                unitkerjapenyebab_id:$("#' . CHtml::activeId($model, 'unitkerjapenyebab_id') . '").val(),
                                term: request.term,
                                default:getDefault1()
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function(event, ui ) {
                            setPetugas1(ui.item);
                            return false;
                        }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikan nama petugas',
                    'onblur' => 'if($(this).val()==""){$("#' . CHtml::activeId($model, 'mengetahui_kepalaunitpenyebab_id') . '").val("");}',
                ),
                'tombolDialog' => array('idDialog' => 'dialogPetugas1', 'jsFunction' => 'refreshPetugas1();'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Mengetahui Kepala Instalasi <span class="required">*</span>', '', array('class' => 'control-label-margin')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'mengetahui_kepalainstalasi_penyebab_id', array('class' => 'span3', 'readonly' => true));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'mengetahui_kepalainstalasi_penyebab_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('getPegawai') . '",
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
                    'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function(event, ui ) {
                            $(this).val(ui.item.nama_pegawai);
                            $("#InsidenrsT_mengetahui_kepalainstalasi_penyebab_id").val( ui.item.value );
                            return false;
                        }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Pilih Nama Pegawai',
                ),
                'tombolDialog' => array('idDialog' => 'dialogKepalaInstalasiPenyebab', 'idTombol' => 'tombolDialogPenelitian'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('10. Akibat Insiden Terhadap Pasien <span class="required">*</span>', 'insidenrs_akibat', array('class' => 'control-label-left required')) ?>
        <div class="controls"> 
            <?php
            echo $form->dropDownList($model, 'insidenrs_akibat', LookupM::getItems('akibatinsiden'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'span3 required'));
            ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label('11. Tindakan yang dilakukan setelah kejadian <span class="required">*</span>', 'tindakan_setelah', array('class' => 'control-label-left required')) ?>
        <div class="controls"> 
            <?php echo $form->textArea($model, 'tindakan_setelah', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('12. Tindakan dilakukan oleh <span class="required">*</span>', 'tindakan_oleh', array('class' => 'control-label-left required')) ?>
        <div class="controls"> 
            <?php /* echo $form->dropDownList($model,'tindakan_oleh',LookupM::getItems('tindakaninsidenoleh'), 
              array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",
              'class'=>'span3', 'onchange' => 'setTindakanLainnya()')); */ ?> 
            <?php echo $form->checkBox($model, 'tindakan_olehdokter', array('value' => 1, 'uncheckValue' => 0,)); ?> <label>Dokter</label>
            <?php echo $form->checkBox($model, 'tindakan_olehperawat', array('value' => 1, 'uncheckValue' => 0,)); ?> <label>Perawat</label>
            <?php echo $form->checkBox($model, 'tindakan_olehpetugaslain', array('value' => 1, 'uncheckValue' => 0, 'onclick' => 'setTindakanLainnya();')); ?> <label>Petugas Lainnya</label>
            <br>

        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label(' ', 'tindakan_olehlainnya', array('class' => 'control-label-left')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'tindakan_olehlainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> 
        </div>
    </div>
</div>
<div class="span6">
    <div class="control-group kejadian">
        <?php echo CHtml::label('13. Kejadian yang sama terjadi di unit lain <span class="required">*</span>', 'terjadiunitlain', array('class' => 'control-label-left')); ?>
        <div class='controls'>
            <?php echo $form->checkBox($model, 'terjadiunitlain_ya', array(($model->terjadiunitlain_ya != "") ? ' ' : 'checked' => false, 'class' => 'pilih required')); ?> <label>Ya</label> 
            <?php echo $form->checkBox($model, 'terjadiunitlain_tidak', array('class' => 'required')); ?> <label>Tidak</label>                        
        </div>
    </div>    
    <div class="control-group">
        <?php echo CHtml::label('14. Langkah/Tindakan apa yang telah diambil pada Unit Kerja tersebut untuk mencegah terulang kejadian yang sama?', 'tindakan_pencegahan', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <?php echo $form->textArea($model, 'tindakan_pencegahan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('15. Tipe Insiden', 'tipeinsiden', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <?php
            if (!empty($model->insidenrs_id)) {
                $cekInsiden = InsidenrsdetT::model()->findByAttributes(array('insidenrs_id' => $model->insidenrs_id));
                $model->tipeinsidensebelumnya = $cekInsiden->subtipeinsiden->tipeinsiden_id;
            }
            echo Chtml::activeDropDownList($model, 'tipeinsidensebelumnya', Chtml::listData(TipeinsidenM::model()->findAllByAttributes(array('tipeinsiden_aktif' => true)), 'tipeinsiden_id', 'tipeinsiden_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'disabled' => 'true'));
            ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('16. Sub Tipe Insiden', 'tipetindakan', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <table id="table-insiden-detail" class="table table-bordered table-condensed" width="100%">
                <thead>
                    <tr>
                        <td colspan="2">Subtipe Insiden Sebelumnya</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($model->insidenrs_id)) {
                        $cekInsiden = InsidenrsdetT::model()->findAllByAttributes(array('insidenrs_id' => $model->insidenrs_id));
                        foreach ($cekInsiden as $i => $det) {
                            echo $this->renderPartial($this->path_update . '/_rowUpdate', array('modInsiden' => $det, 'i' => $i));
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('', 'perubahan_ada', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <?php echo CHtml::activeCheckBox($model, 'perubahan_ada', array('onclick' => 'setPerubahan();')); ?> <label>Ubah Subtipe Insiden</label>
        </div>
    </div>

    <div class="control-group" id="ganti" style="display: none">
        <?php echo CHtml::label('Tipe Insiden', 'tipeinsiden', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <?php echo $form->textField($model, 'insidenrs_id', array('style' => 'display:none', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> 
            <?php echo Chtml::activeDropDownList($model, 'tipeinsiden', Chtml::listData(TipeinsidenM::model()->findAllByAttributes(array('tipeinsiden_aktif' => true)), 'tipeinsiden_id', 'tipeinsiden_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setTipeInsiden(); showHideTabel(this);')); ?> 
        </div>
    </div>
    <div class="control-group" id="baru" style="display: none">
        <?php echo CHtml::label('Sub Tipe Insiden Terbaru', 'tipetindakan', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <table id="table-insiden" class="table table-bordered table-condensed" width="100%">
                <thead>
                    <tr>
                        <td colspan="2">Subtipe Insiden</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

