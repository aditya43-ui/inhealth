<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Resep</b>
            </div>
        </div>
        <div class="panel-body" id="form-dataresep">
            <?php echo CHtml::hiddenField('deposit', $modDeposit, array()); ?>
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
                        'htmlOptions' => array(
                            'readonly' => true, 'class' => 'dtPicker3 col-sm-8', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    )); ?>
                    <?php echo $form->error($modReseptur, 'tglreseptur'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modReseptur, 'noresep', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modReseptur, 'noresep', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;', 'readonly' => true));
                    ?>
                    <?php //echo $form->textFieldRow($modReseptur,'noresep', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Jenis Resep', 'Jenis Resep', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::dropDownList(
                        'jenisresep',
                        '',
                        array(0 => 'Non Racikan', 1 => 'Racikan'),
                        array('key' => 'jenisresep', 'class' => 'span3', 'onchange' => 'formjenisresep(this.value); setDropDownRke();')
                    );
                    ?><br>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->label($modReseptur, 'pegawai_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($modReseptur, 'pegawai_id', array('class' => 'pegawai_reseptur')); ?>
                    <?php
                    $peg = PegawaiM::model()->findByPk($modReseptur->pegawai_id);
                    if (empty($peg)) $peg = new PegawaiM;

                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'nama_pegawai_reseptur',
                        'value' => $peg->namaLengkap,
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/getDokterDPJP') . '",
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
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                     $(this).val( ui.item.label);
                                     return false;
                                 }',
                            'select' => 'js:function( event, ui ) {
                                     $(".pegawai_reseptur").val(ui.item.value); 
                                     return false;
                                 }',
                        ),
                        'htmlOptions' => array(
                            'class' => 'inputFormTabel col-sm-8', 'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'nama_pegawai_reseptur'
                        ),
                        'tombolDialog' => array(
                            'idDialog' => 'dialogDokterDPJP',
                        ),
                    ));
                    ?>
                </div>
            </div>


            <?php
            // $metaRuangan = RuanganM::model()->findByPk($modReseptur->ruangan_id);
            // $modReseptur->ruangan_id = $metaRuangan->ruangan_nama;
            // echo $form->textFieldRow($modReseptur,'ruangan_id',array('readonly'=>true, 'id'=>'nama_apotek_reseptur'));
            // $modReseptur->ruangan_id = $metaRuangan->ruangan_id;
            echo $form->hiddenField($modReseptur, 'ruangan_id');
            ?>
            <div class="control-group">
                <label class="control-label" for="iter">Iter</label>
                <div class="controls">
                    <?php echo CHtml::textField('iter', '0', array('readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1  numbers-only')) ?>
                </div>
            </div>
        </div>
    </div>


</div>
<div class="col-sm-6" id='formjenisresep'>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <div id="judul_racikan" hidden>
                    <i class='fas fa-tablets'></i> Data <b>Obat (Racikan)</b>
                </div>
                <div id="judul_non_racikan">
                    <i class='fas fa-tablets'></i> Data <b>Obat (Non Racikan)</b> <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'terapiobat_reset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk me-refresh form obat non racik')); ?>
                </div>
            </div>
        </div>
        <div class="panel-body" id="form-nonracikan">
            <?php echo CHtml::hiddenField('therapiobat_id', '', array('readonly' => true)) ?>
            <div class="control-group">
                <?php echo CHtml::label('Kelas Therapi', 'therapiobat_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="input-append" style='display:inline'>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'therapiobat_nama',
                            'source' => 'js: function(request, response) {
                                                               $.ajax({
                                                                   url: "' . $this->createUrl('AutoCompleteTherapiObat') . '",
                                                                   dataType: "json",
                                                                   data: {
                                                                       term: request.term,
                                                                       therapiobat_id: $("#therapiobat_id").val(),
                                                                   },
                                                                   success: function (data) {
                                                                           response(data);
                                                                   }
                                                               })
                                                            }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                                            $(this).val( ui.item.label);
                                                            return false;
                                                        }',
                                'select' => 'js:function( event, ui ) {
                                                            $("#therapiobat_id").val(ui.item.therapiobat_id); 
                                                            $("#therapiobat_nama").val(ui.item.therapiobat_nama); 
                                                            setOAJoinTerapi();
                                                            return false;
                                                        }',
                            ),
                            'htmlOptions' => array('class' => 'col-sm-8'),
                            'tombolDialog' => array('idDialog' => 'dialogTerapiObat'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                <?php echo CHtml::hiddenField('obatalkes_kode'); ?>
                <?php echo CHtml::hiddenField('ruanganapotek_id'); ?>
                <?php echo CHtml::hiddenField('therapiobat_id2', '', array('readonly' => true)) ?>
                <label class="control-label" for="namaObat">Nama Obat</label>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'namaObatNonRacik',
                        'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
                                                           dataType: "json",
                                                           data: {
                                                               term: request.term,
                                                               ruangantujuan_id: $("#RIResepturT_ruangan_id").val(),
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
                                                   $(this).val( ui.item.label);
                                                   $("#form-nonracikan #obatalkes_id").val(ui.item.obatalkes_id);
                                                   $("#obatalkes_kode").val(ui.item.obatalkes_kode);
                                                   setThreapiobat_id(ui.item.obatalkes_id);
                                                   $("#form-nonracikan #signa").val(ui.item.signa);
                                                    return false;
                                                }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogObat', 'idTombol' => 'tombolDialogOa'),
                        'htmlOptions' => array("rel" => "tooltip", "title" => "Pencarian Data Obat/Alkes", 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'col-sm-8'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Signa</label>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'signa',
                        'value' => '',
                        'source' => 'js: function(request, response) {
                                    $.ajax({
                                    url: "' . $this->createUrl('getSignaFarmasi') . '",
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
                            'minLength' => 1,
                            'focus' => 'js:function( event, ui ) {
                                     $(this).val( ui.item.value);
                                     return false;
                                 }',
                            'select' => 'js:function( event, ui ) {
                                     $("#signa").val(ui.item.value); 
                                     is_signa_select = true;
                                     return false;
                                 }',

                            'close' => 'js:function(event, ui) {
                                    if (!is_signa_select) {
                                        $(this).val("");
                                    }
                                    is_signa_select = false;
                                }'
                        ),
                        'htmlOptions' => array(
                            'class' => 'inputFormTabel span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'signa'
                        ),
                    ));
                    ?>
                    <?php // echo CHtml::dropDownList('signa', '', LookupM::getItems('signa_oa'),array('class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                    ?>
                </div>

                <div class="controls">
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                        'class' => 'btn btn-primary',
                        'onclick' => 'form_tambah_signa();', 'data-toggle' => 'tooltip', 'title' => 'Tambah Signa',
                    ));
                    ?>

                    <?php // echo CHtml::dropDownList('signa', '', LookupM::getItems('signa_oa'),array()); 
                    ?>
                </div>
            </div>
            <div class="control-group">
                <!--<label class="control-label">Cara Penggunaan Obat</label>-->
                <div class="controls" style="margin-left: 60px;">
                    <?php // echo CHtml::dropDownList('etiketnonracikan', '', LookupM::getItems('etiket'),array('style'=>'width:150px;')); 
                    ?>
                    <?php echo CHtml::dropDownList('etiketnonracikan1', '', LookupM::getItems('etiket_1'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                    <?php echo CHtml::dropDownList('etiketnonracikan2', '', LookupM::getItems('etiket_2'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                    <?php echo CHtml::dropDownList('etiketnonracikan3', '', LookupM::getItems('etiket_3'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                    <?php echo CHtml::dropDownList('etiketnonracikan4', '', LookupM::getItems('etiket_4'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="qty">Jumlah</label>
                <div class="controls">
                    <?php echo CHtml::textField('qtyNonRacik', '1', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only')) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for=""></label>
                <div class="controls">
                    <?php echo CHtml::htmlButton(
                        '<i class="icon-plus icon-white"></i>',
                        array(
                            'onclick' => 'tambahObatNonRacik(this);return false;',
                            'class' => 'btn btn-danger',
                            'onkeypress' => "tambahObatNonRacik(this);return false;",
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan ke tabel resep",
                        )
                    ); ?>
                </div>
            </div>
        </div>
        <div class="panel-body" id="form-racikan">
            <div id="formanak">
                <div class="control-group ">
                    <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                    <label class="control-label" for="racikanKe">R ke</label>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('racikanKe', '', CustomFunction::getDaftarAngka(), array('disabled' => false, 'class' => 'inputFormTabel span1', 'onkeypress' => "return $(this).focusNextInputField(event)")) ?>
                        <?php echo CHtml::htmlButton(
                            '<i class="icon-plus icon-white"></i> Racikan Baru',
                            array(
                                'onclick' => 'racikanBaru(this);return false;',
                                'class' => 'btn btn-primary',
                                'id' => 'tombolracikanbaru',
                                'onkeypress' => "racikanBaru(this);return false;",
                                'disabled' => true,
                                'rel' => "tooltip",
                                'title' => "Klik untuk input racikan baru",
                            )
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Signa</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'signaracikan',
                            'value' => '',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                    url: "' . $this->createUrl('getSignaFarmasi') . '",
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
                                'minLength' => 1,
                                'focus' => 'js:function( event, ui ) {
                                     $(this).val( ui.item.value);
                                     return false;
                                 }',
                                'select' => 'js:function( event, ui ) {
                                     $("#signaracikan").val(ui.item.value); 
                                     is_signa_select = true;
                                     return false;
                                 }',

                                'close' => 'js:function(event, ui) {
                                    if (!is_signa_select) {
                                        $(this).val("");
                                    }
                                    is_signa_select = false;
                                }'
                            ),
                            'htmlOptions' => array(
                                'class' => 'inputFormTabel span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'signaracikan'
                            ),
                        )); ?>
                        <?php // echo CHtml::dropDownList('signaracikan', '', LookupM::getItems('signa_oa'),array('class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                        ?>
                    </div>

                    <div class="controls">
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                            'class' => 'btn btn-primary',
                            'onclick' => 'form_tambah_signa();', 'data-toggle' => 'tooltip', 'title' => 'Tambah Signa',
                        ));
                        ?>

                        <?php // echo CHtml::dropDownList('signa', '', LookupM::getItems('signa_oa'),array()); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <!--<label class="control-label">Cara Penggunaan Obat</label>-->
                    <div class="controls" style="margin-left: 60px;">
                        <?php // echo CHtml::dropDownList('etiketracikan', '', LookupM::getItems('etiket'),array('style'=>'width:150px;')); 
                        ?>
                        <?php echo CHtml::dropDownList('etiketracikan1', '', LookupM::getItems('etiket_1'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketracikan2', '', LookupM::getItems('etiket_2'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketracikan3', '', LookupM::getItems('etiket_3'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketracikan4', '', LookupM::getItems('etiket_4'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="jmlKemasan">Jumlah Permintaan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('jmlKemasanObat', '', array('disabled' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1  numbers-only', 'onblur' => 'hitungJumlahObat()')) ?>
                        <?php echo CHtml::dropDownList('satuansediaan', '', LookupM::getItems(Params::LOOKUPTYPE_SEDIAANOBATRACIKAN), array('class' => 'inputFormTabel span1', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
            <fieldset class="well">
                <div class="control-group">
                    <label class="control-label" for="namaObatRacik">Nama Obat</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'namaObatRacik',
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                                   ruangantujuan_id: $("#RIResepturT_ruangan_id").val(),
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
                                                        $(this).val( ui.item.label);
                                                        $("#form-racikan #obatalkes_id").val(ui.item.obatalkes_id);
                                                        $("#obatalkes_kode").val(ui.item.obatalkes_kode);
                                                        $("#form-racikan #kekuatanObat").val(ui.item.kekuatan);
                                                        hitungJumlahObat();
                                                        return false;
                                                    }',
                            ),
                            'htmlOptions' => array('class' => 'span2', "rel" => "tooltip", "title" => "Pencarian Data Obat/Alkes", 'disabled' => false, 'onkeypress' => "return $(this).focusNextInputField(event)"),
                            'tombolDialog' => array('idDialog' => 'dialogObatRacikan', 'idTombol' => 'tombolDialogOaRacikan'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="permintaan">Permintaan Dosis</label>
                    <div class="controls">
                        <?php echo CHtml::textField('permintaan', '', array('disabled' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 float2', 'onblur' => 'hitungJumlahObat()', 'style' => 'text-align:right;width:80px;')) ?>
                        <?php echo CHtml::dropDownList('', '', LookupM::getItems('satuankekuatan'), array('id' => 'satuan_kekuatan_reseptur', 'class' => 'inputFormTabel span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:80px;')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="kekuatanObat">Kekuatan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('kekuatanObat', '', array('disabled' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 float2', 'readonly' => false, 'onblur' => 'hitungJumlahObat()', "rel" => "tooltip", "title" => "Kekuatan diambil dari data obat yang dipilih",)) ?>
                        <span id="satuanKekuatanObat"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="qty">Jumlah Obat</label>
                    <div class="controls">
                        <?php echo CHtml::textField('qtyRacik', '', array('readonly' => false, 'onkeyup' => '$("#qty").val($(this).val());', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'float2', "rel" => "tooltip", "title" => "Jumlah Obat = Permintaan Dosis X Jumlah Permintaan / Kekuatan", 'style' => 'width:50px;', 'onblur' => 'hitungJumlahObatQty();')) ?>
                    </div>
                </div>
            </fieldset>

            <div class="control-group">
                <label class="control-label" for=""></label>
                <div class="controls">
                    <?php echo CHtml::htmlButton(
                        '<i class="icon-plus icon-white"></i>',
                        array(
                            'onclick' => 'tambahObatRacik(this);return false;',
                            'class' => 'btn btn-danger',
                            'id' => 'tomboltambahracikan',
                            'onkeypress' => "tambahObatRacik(this);return false;",
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan ke tabel resep",
                            'disabled' => true,
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clear"></div>
<p>&nbsp;</p>
<?php

echo $this->renderPartial('dialog/_dpjp', array(), true);
echo $this->renderPartial('dialog/_terapi', array(), true);
echo $this->renderPartial('dialog/_oaNonRacikan', array(), true);
echo $this->renderPartial('dialog/_oaRacikan', array(), true);

?>

<?php echo $this->renderPartial('_jsFunction', array(
    'modPasien' => $modPasien,
    'modPendaftaran' => $modPendaftaran,
    'modReseptur' => $modReseptur,
    'modObatDialog' => new PIObatalkesM('searchObatFarmasiRuangan'),
), true); ?>