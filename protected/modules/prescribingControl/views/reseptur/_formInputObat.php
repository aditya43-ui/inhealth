<table style="width: 100%; border: none;">
    <tr>
        <td width="50%">
            <div class="control-group">
                <?php $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                <?php echo $form->labelEx($modReseptur, 'tglreseptur', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modReseptur,
                        'attribute' => 'tglreseptur',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                            'yearRange' => "-60:+0",
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
<?php echo $form->error($modReseptur, 'tglreseptur'); ?>
                </div>
            </div>
            <div class="control-group">
                    <?php echo $form->labelEx($modReseptur, 'noresep', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modReseptur, 'noresep_belakang', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:100px;'));
                    ?>
<?php //echo $form->textFieldRow($modReseptur,'noresep', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>

        </td>

        <td width="50%">
            <?php echo $form->dropDownListRow($modReseptur, 'pegawai_id', CHtml::listData($modReseptur->DokterItems, 'pegawai_id', 'nama_pegawai'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
<?php echo $form->dropDownListRow($modReseptur, 'ruangan_id', CHtml::listData($modReseptur->ApotekRawatJalan, 'ruangan_id', 'ruangan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>

    <tr>
        <td>
            <fieldset id="formNonRacikan" class="box2">

<?php // echo CHtml::radioButton('pilihNonRacik', true, array('onclick'=>'enableNonRacikan();','onkeypress'=>"return $(this).focusNextInputField(event)"))  ?>
                <legend class="rim">Non Racikan</legend>
                <div class="control-group">
                    <label class="control-label" for="namaObat">Nama Obat</label>
                    <div class="controls">
                        <div class="input-append" style='display:inline'>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'namaObatNonRacik',
                                'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('ObatReseptur') . '",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                                   idSumberDana: $("#idSumberDana").val(),
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
//                                                   'focus'=> 'js:function( event, ui ) {
//                                                        $(this).val( ui.item.label);
//                                                        return false;
//                                                    }',
                                    'select' => 'js:function( event, ui ) {
                                                        $("#idObat").val(ui.item.obatalkes_id); 
                                                        $("#hargaSatuan").val(ui.item.hargajual); 
                                                        $("#hargaNetto").val(ui.item.harganetto); 
                                                        $("#hargaJual").val(ui.item.hargajual); 
                                                        $("#satuanKekuatan").val(ui.item.satuankekuatan);
                                                        $("#kekuatan").val(ui.item.kekuatan);
                                                        $("#jmlKemasan").val(ui.item.kemasanbesar); 
                                                        $("#namaObat").val(ui.item.obatalkes_nama);
                                                        $("#jmlStok").val(ui.item.minimalstok);
                                                        $("#idSumberDana").val(ui.item.sumberdana_id);
                                                        $("#namaSumberDana").val(ui.item.sumberdana_nama);
                                                        $("#idSatuanKecil").val(ui.item.satuankecil_id);
                                                        $("#isRacikan").val("0");
                                                        $("#signa").focus();
                                                        return false;
                                                    }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogObat'),
                                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>      
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Signa</label>
                    <div class="controls">
<?php echo CHtml::textField('signa', '', array('placeholder' => '-- Aturan Pakai --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="qty">Jumlah</label>
                    <div class="controls">
                        <?php echo CHtml::textField('qtyNonRacik', '', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only')) ?>
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'addDataResep();$("#namaObatNonRacik").focus();return false;',
                            'class' => 'btn btn-danger',
                            'onkeypress' => 'addDataResep();$("#namaObatNonRacik").focus();return false;',
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan resep",));
                        ?>
                    </div>
                </div>
            </fieldset>
            <?php echo CHtml::hiddenField('idObat', '', array('readonly' => true)) ?>
            <?php echo CHtml::hiddenField('hargaSatuan', '', array('readonly' => true)) ?>
            <?php echo CHtml::hiddenField('hargaNetto', '', array('readonly' => true)) ?>
            <?php echo CHtml::hiddenField('hargaJual', '', array('readonly' => true)) ?>
            <?php echo CHtml::hiddenField('kekuatan', '', array('readonly' => true)) ?>
            <?php echo CHtml::hiddenField('satuanKekuatan', '', array('readonly' => true)) ?>
            <?php echo CHtml::hiddenField('jmlPermintaan', '', array('readonly' => true)) ?>
            <?php echo CHtml::hiddenField('jmlKemasan', '', array('readonly' => true)) ?>
            <?php echo CHtml::hiddenField('qty', '', array('readonly' => true)) ?>
            <?php echo CHtml::hiddenField('namaObat', '', array('readonly' => true)) ?>
            <?php echo CHtml::hiddenField('idSumberDana', '', array('readonly' => true)) ?>
            <?php echo CHtml::hiddenField('namaSumberDana', '', array('readonly' => true)) ?>
<?php echo CHtml::hiddenField('idSatuanKecil', '', array('readonly' => true)) ?>
<?php echo CHtml::hiddenField('isRacikan', '', array('readonly' => true)) ?>
        </td>
        <td>
            <fieldset id="formRacikan" class="box2">
                <legend class="rim">Racikan</legend>
<?php // echo CHtml::radioButton('pilihRacik', false, array('onclick'=>'enableRacikan();','onkeypress'=>"return $(this).focusNextInputField(event)"))  ?>

                <!--<div class="control-group">
                                    <label class="control-label" for="racikanKe">R ke</label>
                                    <div class="controls">
<?php //echo CHtml::dropDownList('racikanKe', '', CustomFunction::getDaftarAngka(),array('disabled'=>true,'class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)"))  ?>
                                    </div>
                                </div>-->

                <div class="control-group">
                    <label class="control-label" for="namaObatRacik">R ke / Nama Obat</label>
                    <div class="controls">
                        <div class="input-append" style='display:inline'>
                            <?php echo CHtml::dropDownList('racikanKe', '', CustomFunction::getDaftarAngka(), array('class' => 'inputFormTabel span1', 'onkeypress' => "return $(this).focusNextInputField(event)")) ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'namaObatRacik',
                                'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('ObatReseptur') . '",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                                   idSumberDana: $("#idSumberDana").val(),
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
//                                                   'focus'=> 'js:function( event, ui ) {
//                                                        $(this).val( ui.item.label);
//                                                        return false;
//                                                    }',
                                    'select' => 'js:function( event, ui ) {
                                                        $("#idObat").val(ui.item.obatalkes_id);  
                                                        $("#hargaSatuan").val(ui.item.hargajual); 
                                                        $("#hargaNetto").val(ui.item.harganetto); 
                                                        $("#hargaJual").val(ui.item.hargajual); 
                                                        $("#satuanKekuatan").val(ui.item.satuankekuatan);
                                                        $("#kekuatan").val(ui.item.kekuatan);
                                                        $("#jmlKemasan").val(ui.item.kemasanbesar); 
                                                        $("#namaObat").val(ui.item.obatalkes_nama);
                                                        $("#jmlStok").val(ui.item.minimalstok);
                                                        $("#jmlKemasanObat").val(ui.item.kemasanbesar); 
                                                        $("#kekuatanObat").val(ui.item.kekuatan);
                                                        $("#satuanKekuatanObat").html(ui.item.satuankekuatan); 
                                                        $("#idSumberDana").val(ui.item.sumberdana_id);
                                                        $("#namaSumberDana").val(ui.item.sumberdana_nama);
                                                        $("#idSatuanKecil").val(ui.item.satuankecil_id);
                                                        $("#isRacikan").val("1");
                                                        $("#signa_racik").focus();
                                                        return false;
                                                    }',
                                ),
                                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)"),
                                'tombolDialog' => array('idDialog' => 'dialogObat'),
                            ));
                            ?>
                        </div> 
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="permintaan">Permintaan</label>
                    <div class="controls">
<?php echo CHtml::textField('permintaan', '', array('onblur' => 'hitungQtyRacikan();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only')) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="jmlKemasan">Jml Kemasan</label>
                    <div class="controls">
<?php echo CHtml::textField('jmlKemasanObat', '', array('onblur' => 'hitungQtyRacikan();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only')) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="kekuatanObat">Kekuatan</label>
                    <div class="controls">
<?php echo CHtml::textField('kekuatanObat', '', array('onblur' => 'hitungQtyRacikan();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only')) ?>
                        <span id="satuanKekuatanObat"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Signa</label>
                    <div class="controls">
<?php echo CHtml::textField('signa_racik', '', array('placeholder' => '-- Aturan Pakai --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="qty">Jumlah</label>
                    <div class="controls">
                        <?php echo CHtml::textField('qtyRacik', '', array("onblur" => "$('#qty').val(this.value);", 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only')) ?>
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'addDataResep();$("#namaObatRacik").focus();return false;',
                            'class' => 'btn btn-danger',
                            'onkeypress' => 'addDataResep();$("#namaObatRacik").focus();return false;',
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan resep",
                        ));
                        ?>
                    </div>
                </div>
                <div style="float: right;margin-top:-100px; ">
                    <div style='border:1px solid #cccccc;padding:5px;font-size:11px;'>
                        Keterangan : <br>
                        Rumus Perhitungan Jumlah : <br>
                        Permintaan * Jml Kemasan / Kekuatan
                    </div>
                </div>
            </fieldset>
        </td>
    </tr>
</table>

<script type="text/javascript">
    function cekObat() {
        banyaknyaObat = $('#obat').length;
        if (banyaknyaObat < 1) {
            myAlert('Anda Belum memimlih Obat Yang Akan Diminta');
            return false;
        } else {
            $('#rjreseptur-t-form').submit();
        }
        return false;
    }
    function hitungQtyRacikan()
    {
        var permintaan = $('#permintaan').val();
        var jmlKemasan = $('#jmlKemasanObat').val();
        var kekuatan = $('#kekuatanObat').val();
        var qty = permintaan * jmlKemasan / kekuatan;

        if (jQuery.isNumeric(permintaan)) {
            $('#jmlPermintaan').val(permintaan);
        }
        if (jQuery.isNumeric(kekuatan)) {
            $('#kekuatan').val(kekuatan);
        }
        if (jQuery.isNumeric(jmlKemasan)) {
            $('#jmlKemasan').val(jmlKemasan);
        }
        if (jQuery.isNumeric(qty)) {
            $('#qty').val(qty);
        }
        if (jQuery.isNumeric(qty)) {
            $('#qtyRacik').val(qty);
        }
    }

    function addDataResep()
    {
        var R = 'R/';
        var signa = $('#signa').val();
        var qty = $('#qty').val();
        var idSumberDana = $('#idSumberDana').val();
        //var namaSumberDana = $('#namaSumberDana').val();
        var idObat = $('#idObat').val();
        var namaObat = $('#namaObat').val();
        var temp = 0;
        var RkeMax = 0;
        var idSatuanKecil = $('#idSatuanKecil').val();
        var hargaSatuan = $('#hargaSatuan').val();
        var hargaNetto = $('#hargaNetto').val();
        var hargaJual = $('#hargaJual').val();
        var kekuatan = $('#kekuatan').val();
        var satuanKekuatan = $('#satuanKekuatan').val();
        var jmlPermintaan = $('#jmlPermintaan').val();
        var jmlKemasan = $('#jmlKemasan').val();
        var i = $('#tblDaftarResep tr').length;
        var isRacikan = $('#isRacikan').val();
        var subTotal = qty * hargaJual;

        if (idObat == '') {
            myAlert('Obat Masih Kosong');
            return false;
        }

        $('#tblDaftarResep tr').each(function (j) {
            $(this).attr('id', 'tr_' + j);
        });

        var ceklist = '<?php echo CHtml::checkBox("penjualanResep[0][detailreseptur_id]", true, array('onchange' => 'hitungTotalSemua();', 'uncheckValue' => '0', 'value' => 1)) ?>';
        var inputR = '<?php echo CHtml::textField('R[]', '', array()) ?>';
        var inputRke = '<?php echo CHtml::textField('Rke[]', '', array('readonly' => true, 'style' => 'width:15px;')) ?>';
        var inputObat = '<?php echo CHtml::hiddenField('obat[]', '', array('readonly' => true, 'class' => 'inputFormTable span1')) ?>';
        var inputHargaSatuan = '<?php echo CHtml::hiddenField('hargasatuan[]', '', array('readonly' => true, 'class' => 'inputFormTable span1')) ?>';
        var inputHargaNetto = '<?php echo CHtml::hiddenField('harganetto[]', '', array('readonly' => true, 'class' => 'inputFormTable span1')) ?>';
        var inputHargaJual = '<?php echo CHtml::textField('hargajual[]', '', array('readonly' => true, 'class' => 'inputFormTabel lebar2 currency')) ?>';
        var inputKekuatan = '<?php echo CHtml::hiddenField('kekuatan[]', '', array('readonly' => true, 'class' => 'inputFormTable span1')) ?>';
        var inputJmlPermintaan = '<?php echo CHtml::hiddenField('jmlpermintaan[]', '', array('readonly' => true, 'class' => 'inputFormTable span1')) ?>';
        var inputJmlKemasan = '<?php echo CHtml::hiddenField('jmlkemasan[]', '', array('readonly' => true, 'class' => 'inputFormTable span1')) ?>';
        var inputSatuanKekuatan = '<?php echo CHtml::hiddenField('satuankekuatan[]', '', array('readonly' => true, 'class' => 'inputFormTable span1')) ?>';
        var inputSatuan = <?php echo json_encode(CHtml::dropDownList('satuankecil[]', '', CHtml::listData(SatuankecilM::model()->findAll(), 'satuankecil_id', 'satuankecil_nama'), array('empty' => '-- Pilih --', 'class' => 'inputFormTabel lebar3'))); ?>;
        var inputSigna = '<?php echo CHtml::textField('signa[]', '', array('placeholder' => '-- Aturan Pakai --', 'class' => 'span2')) ?>';
        var inputQty = '<?php echo CHtml::textField('qty[]', '', array('readonly' => false, 'class' => 'inputFormTabel lebar2 float numberOnly', 'onblur' => 'hitungSubTotal(this);')) ?>';
        var inputSumberDana = <?php echo json_encode(CHtml::dropDownList('sumberdana[]', '', CHtml::listData(SumberdanaM::model()->findAll(), 'sumberdana_id', 'sumberdana_nama'), array('empty' => '-- Pilih --', 'class' => 'inputFormTabel lebar3-5'))); ?>;
        var inputEtiket = <?php echo json_encode(CHtml::dropDownList('etiket[]', '', LookupM::getItems('etiket'), array('class' => 'inputFormTabel span3'))); ?>;
        var inputIsRacikan = '<?php echo CHtml::hiddenField('isRacikan[]', '', array()) ?>';
        var iconRemove = '<a onclick="removeObat(this);return false;" rel="tooltip" href="javascript:void(0);" data-original-title="Klik untuk menghapus Obat"><i class="icon-form-silang"></i></a>';
        var inputSubTotal = '<?php echo CHtml::textField('subTotal[]', '', array('readonly' => true, 'class' => 'inputFormTabel lebar2 currency')) ?>';
        //var iconRemove = '';

        $('#tblDaftarResep').find('input[name="Rke[]"]').each(function () {
            temp = this.value;
            if (temp == '')
                temp = 0;
            if (temp < this.value)
                temp = this.value;
            RkeMax = temp;
        });

        if ($('#formNonRacikan #pilihRacik').is(':checked')) {
            var signa = $('#signa').val();
            RkeMax++;
        }
        if ($('#formRacikan #pilihRacik').is(':checked')) {
            var signa = $('#signa_racik').val();
            RkeMax = $('#racikanKe').val();
            if (adaRmax(RkeMax))
                R = '';
        }

        var row = '<tr id="tr_' + i + '">' +
                '<td>' + R + inputIsRacikan + '</td>' +
                '<td>' + inputRke + '</td>' +
                '<td>' + inputObat + namaObat + inputHargaSatuan + inputHargaNetto + inputKekuatan + inputSatuanKekuatan + '</td>' +
                '<td>' + inputSumberDana + '</td>' +
                '<td>' + inputSatuan + inputJmlPermintaan + inputJmlKemasan + '</td>' +
                '<td>' + inputQty + '</td>' +
                '<td>' + inputHargaJual + '</td>' +
                '<td>' + inputSubTotal + '</td>' +
                '<td>' + inputSigna + '</td>' +
                '<td>' + inputEtiket + '</td>' +
                '<td>' + iconRemove + '</td>' +
                '</tr>';
        //if($('#idObat').val() == '' || $('#namaObat').val() == ''){myAlert('Maaf Anda Belum Mengisi Nama Obat.');$('#namaObat').focus();return;}
        $('#tblDaftarResep > tbody').append(row);
        $('#tr_' + i).find('select[name="satuankecil[]"]').attr('value', idSatuanKecil);
        $('#tr_' + i).find('input[name="qty[]"]').attr('value', qty);
        $('#tr_' + i).find('input[name="Rke[]"]').attr('value', RkeMax);
        $('#tr_' + i).find('select[name="sumberdana[]"]').attr('value', idSumberDana);
        $('#tr_' + i).find('input[name="obat[]"]').attr('value', idObat);
        $('#tr_' + i).find('input[name="hargasatuan[]"]').attr('value', hargaSatuan);
        $('#tr_' + i).find('input[name="harganetto[]"]').attr('value', hargaNetto);
        $('#tr_' + i).find('input[name="hargajual[]"]').attr('value', hargaJual);
        $('#tr_' + i).find('input[name="subTotal[]"]').attr('value', subTotal);
        $('#tr_' + i).find('input[name="kekuatan[]"]').attr('value', kekuatan);
        $('#tr_' + i).find('input[name="satuankekuatan[]"]').attr('value', satuanKekuatan);
        $('#tr_' + i).find('input[name="jmlpermintaan[]"]').attr('value', jmlPermintaan);
        $('#tr_' + i).find('input[name="jmlkemasan[]"]').attr('value', jmlKemasan);
        $('#tr_' + i).find('input[name="isRacikan[]"]').attr('value', isRacikan);
        $('#tr_' + i).find('input[name="signa[]"]').attr('value', signa);

        $("#tblDaftarResep > tbody > tr:last .currency").maskMoney({"symbol": "Rp ", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0});
        $('.currency').each(function () {
            this.value = formatInteger(this.value)
        });
        $("#tblDaftarResep > tbody > tr:last .number").maskMoney({"defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 1, "symbol": null});
        $('.number').each(function () {
            this.value = formatNumber(this.value)
        });
        clearInputan();
        hitungTotalHargaReseptur();
    }

    function hitungSubTotal(obj)
    {
        var qty = unformatNumber($(obj).parents('tr').find('input[name="qty[]"]').val());
        var harga = unformatNumber($(obj).parents('tr').find('input[name="hargajual[]"]').val());
        subTotal = qty * harga;

        $(obj).parents('tr').find('input[name="subTotal[]"]').val(formatInteger(subTotal));
        hitungTotalHargaReseptur();
    }

    function hitungTotalHargaReseptur()
    {
        totalHarga = 0;
        $('#tblDaftarResep').find('input[name="subTotal[]"]').each(function () {
            totalHarga = totalHarga + unformatNumber(this.value);
        });
        $('#totalHargaReseptur').val(formatInteger(totalHarga));
    }

    function removeObat(obj)
    {
        myConfirm("Apakah Anda akan menghapus obat?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parent().parent().remove();
                hitungTotalHargaReseptur();
            }
        });

    }

    function adaRmax(Rke)
    {
        var ada = false;
        $('#tblDaftarResep').find('input[name="Rke[]"]').each(function () {
            if (Rke == this.value)
                ada = true;
        });

        return ada;
    }

    function enableRacikan()
    {
        $('#formRacikan input[type="text"]').removeAttr('disabled');
        $('#formRacikan input[type="text"]').removeAttr('readonly');
        $('#formRacikan select').removeAttr('disabled');
        $('#formRacikan button').removeAttr('disabled');
        $('#formNonRacikan input[type="text"]').attr('disabled', 'disabled');
        $('#formNonRacikan select').attr('disabled', 'disabled');
        $('#formNonRacikan button').attr('disabled', 'disabled');
        $('#formNonRacikan input[type="radio"]').removeAttr('checked');
        $('#racikanKe').focus();
    }

    function enableNonRacikan()
    {
        $('#formNonRacikan input[type="text"]').removeAttr('disabled');
        $('#formNonRacikan select').removeAttr('disabled');
        $('#formNonRacikan button').removeAttr('disabled');
        $('#formRacikan input[type="text"]').attr('disabled', 'disabled');
        $('#formRacikan select').attr('disabled', 'disabled');
        $('#formRacikan button').attr('disabled', 'disabled');
        $('#formRacikan input[type="radio"]').removeAttr('checked');
    }

    function clearRacikan()
    {
        $('#formRacikan input[type="text"]').val('');
        $('#satuanKekuatanObat').html('');
        $('#racikanKe').focus();
    }

    function clearNonRacikan()
    {
        $('#formNonRacikan input[type="text"]').val('');
        $('#satuanKekuatanObat').html('');
        $('#racikanKe').focus();
    }

    function clearInputan()
    {
        $('#idObat').val('');
        $('#hargaSatuan').val('');
        $('#hargaNetto').val('');
        $('#hargaJual').val('');
        $('#kekuatan').val('');
        $('#satuanKekuatan').val('');
        $('#jmlPermintaan').val('');
        $('#jmlKemasan').val('');
        $('#qty').val('');
        $('#signa').val('');
        $('#namaObat').val('');
        $('#idSumberDana').val('');
        $('#namaSumberDana').val('');
        $('#idSatuanKecil').val('');
        clearRacikan();
        clearNonRacikan();
    }

    function cekInput()
    {
        $('.currency').each(function () {
            this.value = unformatNumber(this.value)
        });
        $('.number').each(function () {
            this.value = unformatNumber(this.value)
        });
        return true;
    }
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObat',
    'options' => array(
        'title' => 'Pencarian Obat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modObatDialog = new PCObatAlkesM('searchObatFarmasiRuangan');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['PCObatAlkesM']))
    $modObatDialog->attributes = $_GET['PCObatAlkesM'];
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialog-m-grid',
    'dataProvider' => $modObatDialog->searchObatFarmasiRuangan(),
    'filter' => $modObatDialog,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            
                                $(\"#namaObatNonRacik\").val(\"$data->obatalkes_kode - $data->obatalkes_nama\");
                                $(\"#isRacikan\").val(\"0\");
                                $(\"#signa\").focus();
                            
                            
                                $(\"#namaObatRacik\").val(\"$data->obatalkes_kode - $data->obatalkes_nama\");
                                $(\"#isRacikan\").val(\"1\");
                                $(\"#signa_racik\").focus();
                            
                            $(\"#idObat\").val(\"$data->obatalkes_id\");
                            $(\"#jenisObatAlkes_id\").val(\"$data->jenisobatalkes_id\");
                            $(\"#satuanKekuatan\").val(\"$data->satuankekuatan\");
                            $(\"#kekuatan\").val(\"$data->kekuatan\");
                            $(\"#jmlKemasan\").val(\"$data->kemasanbesar\");
                            $(\"#namaObat\").val(\"$data->obatalkes_kode - $data->obatalkes_nama\");
                            $(\"#jmlStok\").val(\"$data->minimalstok\");
                            $(\"#kekuatanObat\").val(\"$data->kekuatan\");
                            $(\"#satuanKekuatanObat\").html(\"$data->satuankekuatan\"); 
                            $(\"#idSumberDana\").val(\"$data->sumberdana_id\");
                            $(\"#discountObat\").val(\"$data->diskonJual\");
                            $(\"#idSatuanKecil\").val(\"$data->satuankecil_id\");
                            $(\"#kategoriObat\").val(\"$data->obatalkes_kategori\");
                            $(\"#kadaluarsa\").val(\"$data->kadaluarsa\");
                            //$(\"#isRacikan\").val(1);
                            $(\"#hjaresep\").val(\"$data->hjaresep\");
                            $(\"#hjanonresep\").val(\"$data->hjanonresep\");
                            $(\"#hpp\").val(\"$data->hpp\");
                            
                            $(\"#idNonRacikan\").val(\"1\");
                            $(\"#stokObat\").val(\"$data->stokObatRuangan\");
                            $(\"#hargaNetto\").val(\"$data->harganetto\");
                            $(\"#hargaJual\").val(\"$data->hargajual\");
                            $(\"#idSumberDana\").val(\"$data->sumberdana_id\");
                            $(\"#namaSumberDana\").val(\"$data->namaSumberDana\");

                            $(\"#dialogObat\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'name' => 'tglkadaluarsa',
            'filter' => '',
        ),
        array(
            'name' => 'satuankecil.satuankecil_nama',
            'header' => 'Satuan Kecil',
        ),
        array(
            'name' => 'satuanbesar.satuanbesar_nama',
            'header' => 'Satuan Besar',
        ),
        array(
            'header' => 'Generik',
            'name' => 'generik_nama',
            'value' => '(isset($data->generik->generik_nama) ? $data->generik->generik_nama : "")',
            'filter' => CHtml::activeTextField($modObatDialog, 'generik_nama') . CHtml::activeHiddenField($modObatDialog, 'generik_id'),
        ),
        array(
            'header' => 'HJA Resep',
            'type' => 'raw',
            'value' => 'number_format($data->hjaresep, 0, ",", ".")',
            'filter' => '',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'HJA Non Resep',
            'value' => 'number_format($data->hjanonresep, 0, ",", ".")',
            'filter' => '',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>