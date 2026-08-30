<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="row-fluid" id='formjenisresep'>
    <div class="col-sm-12">
        <div id="form-nonracikan">
            <?php echo CHtml::hiddenField('therapiobat_id', '', array('readonly' => true)) ?>
            <div class="control-group hide">
                <?php echo CHtml::label('Kelas Terapi', 'therapiobat_id', array('class' => 'control-label')) ?>
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
                            'tombolDialog' => array('idDialog' => 'dialogTerapiObat'),
                            'htmlOptions' => array('class' => 'span3'),
                        ));
                        ?>
                    </div>
                </div>
                <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                <?php echo CHtml::hiddenField('obatalkes_kode'); ?>
                <?php echo CHtml::hiddenField('obatalkes_nama'); ?>
                <?php echo CHtml::hiddenField('st_fornas'); ?>
                <?php echo CHtml::hiddenField('hargastuan_reseptur'); ?>
                <?php echo CHtml::hiddenField('sumberdana_id'); ?>
                <?php echo CHtml::hiddenField('ruanganapotek_id'); ?>
                <?php echo CHtml::hiddenField('therapiobat_id2', '', array('readonly' => true)) ?>
            </div>
            <div class="control-group hidden">
                <label class="control-label" for="namaObat">Nama Obat <span class="required">*</span></label>
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
									ruangantujuan_id: $("#RJResepturT_ruangan_id").val(),
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
                        'htmlOptions' => array("class" => "span3", 'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?><br>
                     <?php echo CHtml::textField('obatlain', '', array('readonly' => false, 'class' => 'namaobatlain hidden','placeholder'=>'Silahkan Memasukkan Nama Obat Lain')) ?>
                </div>
                
            </div>
            <div class="control-group ">
               <!-- data obat berasal dari get API -->
                <label class="control-label" for="namaObat">Nama Obat <span class="required">*</span></label>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'namaObatNonRacikDariApi',
                        'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . $this->createUrl('/rawatJalan/reseptur/AutocompleteObatApi') . '",
								dataType: "json",
								data: {
									term: request.term,
									ruangantujuan_id: $("#RJResepturT_ruangan_id").val(),
                                    stokdepo:1
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
								setObatDariApi(ui.item.kode, ui.item.jenis, ui.item.stFornas, ui.item.satuan, ui.item.nama, ui.item.HJual, ui.item.HPP);
								return false;
							}',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogObatDariApi'),
                        'htmlOptions' => array("class" => "span3", 'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?><br>
                     <?php echo CHtml::textField('obatlain', '', array('readonly' => false, 'class' => 'namaobatlain hidden','placeholder'=>'Silahkan Memasukkan Nama Obat Lain')) ?>
                </div>
                
            </div>
            
            <div class="control-group ">
                <label class="control-label" for="qty">Jumlah <span class="required">*</span></label>
                <div class="controls">
                    <?php echo CHtml::textField('qtyNonRacik', '', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);', 'onkeyup' => 'ceklist(this)', 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 number-char qty')) ?>
                </div>
                <div class="controls">
                    <?php
                        $formulaobatkronis_data = FormulaobatkronisM::model()->findAll('is_aktif = true');
                        $list_formulaobatkronis = CHtml::listData($formulaobatkronis_data, 'formulaobatkronis_id', 'jumlahMinMax');
                        $option_formulaobatkronis = array();

                        foreach ($formulaobatkronis_data as $item) {
                            $option_formulaobatkronis[$item->formulaobatkronis_id] = array(
                                'data-jumlahobat' => $item->jumlahobat,
                            );
                        }

                        
                    ?>
                           
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Signa <span class="required">*</span></label>
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
                            'class' => 'inputFormTabel span2 input_signa', 'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'signa'
                        ),
                    ));
                    ?>
                </div>
                <div class="controls">
                    <?php 
                        echo CHtml::dropDownList('formulaobatkronis_id','', LookupM::getItemsUrutan('sediaannonracikan'), array('id'=>'sediaanobatnonracikan','class'=>'span2', 'empty' => '-- Pilih --')); 
                    ?>
                </div>
                <div class="controls">
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                        'class' => 'btn btn-green',
                        'onclick' => 'form_tambah_signa();', 'data-toggle' => 'tooltip', 'title' => 'Tambah Signa',
                    ));
                    ?>

                    <?php // echo CHtml::dropDownList('signa', '', LookupM::getItems('signa_oa'),array()); 
                    ?>
                </div>
            </div>
            <?php echo CHtml::hiddenField('tempWaktu'); ?>
            <div class="control-group" <?= ((Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RI) || (Yii::app()->user->getState('modul_id') == 72)) ? '' : 'hidden' ?>>
                <label class="control-label">Waktu <span class="required">*</span></label>
                <div class="controls">
                    <?php $dataWaktu = ['Pagi' => 'Pagi', 'Siang' => 'Siang', 'Sore' => 'Sore', 'Malam' => 'Malam'] ?>
                    <?php echo CHtml::checkBoxList('waktu', [], $dataWaktu, ['onchange' => 'waktu(this)']); ?>
                </div>
            </div>

            <div class="control-group" hidden>
                <label class="control-label">Dosis</label>
                <div class="controls">
                    <?php //echo CHtml::dropDownList('dosisnon', '', LookupM::getItemsUrutan('etiket_1'), ['class' => 'dosis']) ?>
                    <?php echo CHtml::textField('dosisnon', '', array('readonly' => false, 'class' => 'dosis','placeholder'=>'Silahkan masukan dosis')) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"><?= (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RI) ? '' : 'Waktu Pemberian / ' ?> Instruksi </label>
                <div class="controls">
                    <?php //echo CHtml::dropDownList('etiketwaktunon', '', LookupM::getItemsUrutan('etiket_2'), ['class' => 'etiketwaktu']) ?>
                    <?php echo CHtml::textField('etiketwaktunon', '', array('readonly' => false, 'class' => 'etiketwaktu','placeholder'=>'Silahkan masukan waktu pemberian')) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Keterangan</label>
                <div class="controls">
                    <?= CHtml::textArea('keterangannon', '', ['class' => 'keterangan']) ?>
                </div>
            </div>

            <div class="control-group hide">
                <label class="control-label">Etiket</label>
                <div class="controls">
                    <?php // echo CHtml::dropDownList('etiketnonracikan', '', LookupM::getItems('etiket'),array('class'=>'span3')); 
                    ?>
                    <?php echo CHtml::dropDownList('etiketnonracikan1', '', LookupM::getItems('etiket_1'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                    <?php echo CHtml::dropDownList('etiketnonracikan2', '', LookupM::getItems('etiket_2'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                    <?php echo CHtml::dropDownList('etiketnonracikan3', '', LookupM::getItems('etiket_3'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                    <?php echo CHtml::dropDownList('etiketnonracikan4', '', LookupM::getItems('etiket_4'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label" for=""></label>
                <div class="controls">
                    <?php echo CHtml::htmlButton(
                        '<i class="icon-plus icon-white"></i>',
                        array(
                            'onclick' => 'tambahObatNonRacik(this);return false;',
                            'class' => 'btn btn-primary',
                            'onkeypress' => "tambahObatNonRacik(this);return false;",
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan ke tabel resep",
                        )
                    ); ?>
                </div>
            </div>
        </div>
        <div id="form-racikan">
            <div id="formanak">
                <div class="control-group ">
                    <?php echo CHtml::hiddenField('sumberdana_id'); ?>
                    <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                    <label class="control-label" for="racikanKe">R ke</label>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('racikanKe', '', CustomFunction::getDaftarAngka(), array('disabled' => false, 'class' => 'inputFormTabel span1', 'onkeypress' => "return $(this).focusNextInputField(event)")) ?>
                        <?php echo CHtml::htmlButton(
                            '<i class="entypo-plus"></i> Racikan Baru',
                            array(
                                'onclick' => 'racikanBaru(this);return false;',
                                'class' => 'btn btn-green',
                                'id' => 'tombolracikanbaru',
                                'onkeypress' => "racikanBaru(this);return false;",
                                'disabled' => true,
                                'rel' => "tooltip",
                                'title' => "Klik untuk input racikan baru",
                            )
                        ); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label" for="jmlKemasan">Sediaan <span class="required">*</span></label>
                    <div class="controls">
                        <?php // CHtml::textField('jmlKemasanObat', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1  numbers-only', 'style' => 'text-align: right;'))
                        //echo CHtml::textField('qtyRacik', '', array('disabled'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1', 'style'=>'text-align: right;'));                                                
                        ?>
                        <?php echo CHtml::dropDownList('satuansediaan', '', LookupM::getItems(Params::LOOKUPTYPE_SEDIAANOBATRACIKAN), array('class' => 'inputFormTabel span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '--- Pilih ---')); ?>
                        <?php echo CHtml::hiddenField('satuansediaan_text', ''); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Signa <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo CHtml::textField('signa_a', '', array('class' => 'numbers-only span1', 'onblur' => 'hitungJumlahPermintaan(this)', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        // $this->widget('MyJuiAutoComplete', array(
                        //     'name' => 'signaracikan',
                        //     'value' => '',
                        //     'source' => 'js: function(request, response) {
                        //             $.ajax({
                        //             url: "' . $this->createUrl('getSignaFarmasi') . '",
                        //             dataType: "json",
                        //             data: {
                        //                 term: request.term,
                        //             },
                        //             success: function (data) {
                        //                 response(data);
                        //             }
                        //         })
                        //     }',
                        //     'options' => array(
                        //         'showAnim' => 'fold',
                        //         'minLength' => 1,
                        //         'focus' => 'js:function( event, ui ) {
                        //              $(this).val( ui.item.value);
                        //              return false;
                        //          }',
                        //         'select' => 'js:function( event, ui ) {
                        //              $("#signaracikan").val(ui.item.value); 
                        //              is_signa_select = true;
                        //              return false;
                        //          }',
                        //         'close' => 'js:function( event, ui ) {
                        //              if (!is_signa_select) {
                        //                 $(this).val("");
                        //              }
                        //              is_signa_select = false;
                        //              return false;
                        //          }',

                        //     ),
                        //     'htmlOptions' => array(
                        //         //                                'onblur'=>'$(this).val("");','class'=>'inputFormTabel span2','onkeypress'=>"return $(this).focusNextInputField(event)", 'id'=>'signaracikan'
                        //         'class' => 'inputFormTabel span2 input_signa', 'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'signaracikan'
                        //     ),
                        // ));
                        ?>
                    </div>
                    <div class="controls">X</div>
                    <div class="controls">
                        <?php echo CHtml::textField('signa_b', '', array('class' => 'numbers-only span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onblur' => 'hitungJumlahPermintaan(this)')); ?>
                        <?php
                        //  CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                        //     'class' => 'btn btn-green',
                        //     'onclick' => 'form_tambah_signa();', 'data-toggle' => 'tooltip', 'title' => 'Tambah Signa',
                        // ));
                        ?>
                    </div>
                   
                </div>
            
                <div class="control-group">
                    <label class="control-label">Hari <span class="required">*</span></label>
                    <div class="controls">
                        <?php // CHtml::dropDownList('dosisracik', '', LookupM::getItemsUrutan('etiket_1'), ['class' => 'dosis']) ?>
                        <?php echo CHtml::textField('dosisracik', '', array('readonly' => false, 'class' => 'dosis numbers-only span2', 'onblur' => 'hitungJumlahPermintaan(this)')) ?>
                    </div>
                </div>
                <?php echo CHtml::hiddenField('tempWaktuRacik'); ?>
                <div class="control-group" <?= (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RI) ? '' : 'hidden' ?>>
                    <label class="control-label">Waktu <span class="required">*</span></label>
                    <div class="controls">
                        <?php $dataWaktu = ['Pagi' => 'Pagi', 'Siang' => 'Siang', 'Sore' => 'Sore', 'Malam' => 'Malam'] ?>
                        <?php echo CHtml::checkBoxList('wakturacik', [], $dataWaktu, ['onchange' => 'waktuRacik(this)']); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?= (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RI) ? '' : 'Waktu Pemberian / ' ?> Instruksi </label>
                    <div class="controls">
                        <?php //CHtml::dropDownList('etiketwakturacik', '', LookupM::getItemsUrutan('etiket_2'), ['class' => 'etiketwaktu']) ?>
                        <?php echo CHtml::textField('etiketwakturacik', '', array('readonly' => false, 'class' => 'etiketwaktu','placeholder'=>'Silahkan masukan waktu pemberian')) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Jumlah Permintaan</label>
                    <div class="controls">
                        <?php //CHtml::dropDownList('etiketwakturacik', '', LookupM::getItemsUrutan('etiket_2'), ['class' => 'etiketwaktu']) ?>
                        <?php echo CHtml::textField('jumlahpermintaan_obatracikan', '', array('readonly' => true, 'class' => 'jumlahpermintaan_obatracikan span2')) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Keterangan</label>
                    <div class="controls">
                        <?= CHtml::textArea('keteranganracik', '', ['class' => 'keterangan']) ?>
                    </div>
                </div>

                <div class="control-group hide">
                    <label class="control-label">Etiket</label>
                    <div class="controls">
                        <?php // echo CHtml::dropDownList('etiketracikan', '', LookupM::getItems('etiket'),array('style'=>'width:150px;')); 
                        ?>
                        <?php echo CHtml::dropDownList('etiketracikan1', '', LookupM::getItems('etiket_1'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketracikan2', '', LookupM::getItems('etiket_2'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketracikan3', '', LookupM::getItems('etiket_3'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                        <?php echo CHtml::dropDownList('etiketracikan4', '', LookupM::getItems('etiket_4'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
                    </div>
                </div>

                <!-- <div class="control-group ">
                <label class="control-label" for="">Tarif Embalase</label>
                <div class="controls">
                    <?php //echo CHtml::textField('tarifembalase', '', array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 integer-decimal', 'style' => 'text-align: right;')) 
                    ?>
                </div> 
            </div> -->
            </div>
            <fieldset class="well">
                <div class="control-group hidden">
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
										ruangantujuan_id: $("#RJResepturT_ruangan_id").val(),
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
                                    setObat(ui.item.obatalkes_id);
									return false;
								}',
                            ),
                            'htmlOptions' => array('class' => 'span2', 'disabled' => false, 'onkeypress' => "return $(this).focusNextInputField(event)"),
                            'tombolDialog' => array('idDialog' => 'dialogObatRacikan', 'idTombol' => 'tombolDialogOaRacikan'),
                        ));
                        ?><br>
                        <?php echo CHtml::textField('obatlain', '', array('readonly' => false, 'class' => 'namaobatlain hidden','placeholder'=>'Silahkan Memasukkan Nama Obat Lain')) ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label" for="namaObat">Nama Obat <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'namaObatRacikDariApi',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/rawatJalan/reseptur/AutocompleteObatApi') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        ruangantujuan_id: $("#RJResepturT_ruangan_id").val(),
                                        stokdepo:1
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
                                    setObatRacikanDariApi(ui.item.kode, ui.item.jenis, ui.item.stFornas, ui.item.satuan, ui.item.nama, ui.item.HJual, ui.item.HPP);
                                    return false;
                                }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRacikanObatDariApi'),
                            'htmlOptions' => array("class" => "span3", 'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                    
                </div>
                <div class="control-group ">
                    <label class="control-label" for="permintaan">Permintaan Dosis <span class="required">*</span></label>
                    <div class="controls">
                        <?php //echo CHtml::textField('permintaan', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1  integer2', 'onblur' => 'hitungJumlahObat()', 'style' => 'text-align: right;')) ?>
                        <?php echo CHtml::textField('permintaan', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1', 'style' => 'text-align: right;')) ?>
                        <?php echo CHtml::dropDownList('satuan_permintaandosis', '', LookupM::getItemsUrutan('satuankekuatan'), array('class' => 'inputFormTabel span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '--- Pilih ---')); ?>
                        <?php //echo Chtml::button("Pecahan", array('onclick' => '$("#dialogPecahanDosis").dialog("open");', 'class' => 'btn btn-primary' )); 
                        ?>
                        <?php echo CHtml::hiddenField('pembilang'); ?>
                        <?php echo CHtml::hiddenField('penyebut'); ?>
                    </div>
                </div>
                <div class="control-group" hidden>
                    <label class="control-label" for="qty">Jumlah Obat</label>
                    <div class="controls">
                    <?php echo CHtml::textField('qtyRacik', '', array('readonly'=>false,'onkeyup'=>'$("#qty").val($(this).val()); ceklist(this);','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'qty',"rel"=>"tooltip","title"=>"Jumlah Obat = Permintaan Dosis X Jumlah Permintaan / Kekuatan",'style'=>'width:50px;'))    //hitungJumlahObatQty(); ?> 
                    <?php echo CHtml::dropDownList('formulaobatkronis_id','', FormulaobatkronisM::getDropdown(), array('id'=>'formulaobatkronis_id','class'=>'span2', 'empty' => '-- Pilih --', 'readonly' => true, 'disabled' => true)); ?>
                           <?php echo CHtml::checkBox("is_obatkronis", false, array('id'=>'is_obatkronis','onclick'=>'ceklist(this)', 'uncheckValue'=>null, 'checked' => false)) ?><label>Obat Kronis</label>           
           
                    </div>
                </div>
            </fieldset>
            <div class="control-group ">
                <label class="control-label" for=""></label>
                <div class="controls">
                    <?php echo CHtml::htmlButton(
                        '<i class="icon-plus icon-white"></i>',
                        array(
                            'onclick' => 'tambahObatRacik(this);return false;',
                            'class' => 'btn btn-primary',
                            'id' => 'tomboltambahracikan',
                            'onkeypress' => "tambahObatRacik(this);return false;",
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan ke tabel resep",
                            'disabled' => false,
                        )
                    ); ?>
                </div>
            </div>
            <!--<div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 42%;float:right;margin-top:-70px;'>-->
            <!--<font style='font-size:9pt'>Keterangan : </font><br>-->
            <!--<font style='font-size:8pt'>Jumlah = Permintaan*Jumlah Kemasan/Kekuatan</font>-->
        </div>
    </div>
</div>

<?php
$this->renderPartial($this->path_view . '_dialogObatNonRacikan');
?>

<?php
$this->renderPartial($this->path_view . '_dialogObatRacikan');
?>


<?php
if(empty($modReseptur->ruangan_id)) {
    $ruangan_id = Yii::app()->user->getState('ruangan_id');
} else {
    $ruangan_id = $modReseptur->ruangan_id;
}
$ru = RuanganM::model()->findByPk($ruangan_id);


//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTerapiObat',
    'options' => array(
        'title' => 'Kelas Terapi Obat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

$modTherapiobat = new RJTherapiobatM('searchDialog');
$modTherapiobat->unsetAttributes();
if (isset($_GET['RJTherapiobatM'])) {
    $modTherapiobat->attributes = $_GET['RJTherapiobatM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'therapiobat-grid',
    'dataProvider' => $modTherapiobat->searchDialog(),
    'filter' => $modTherapiobat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
												$(\"#therapiobat_id\").val(\"$data->therapiobat_id\"); 
												$(\"#therapiobat_nama\").val(\"$data->therapiobat_nama\"); 
                                                $(\'#dialogTerapiObat\').dialog(\'close\');
												setOAJoinTerapi();
											return false;"))',
        ),
        'therapiobat_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObat',
    'options' => array(
        'title' => 'Daftar Obat Alkes - <span class="rid">' . $ru->ruangan_nama . '</span>',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$modObatDialog = new RJObatAlkesM('searchObatFarmasiRuangan');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['RJObatAlkesM'])) {
    $modObatDialog->attributes = $_GET['RJObatAlkesM'];
    //	if(isset($_GET['RJObatAlkesM']['therapiobat_id'])){
    $modObatDialog->therapiobat_id = isset($_GET['RJObatAlkesM']['therapiobat_id']) ? $_GET['RJObatAlkesM']['therapiobat_id'] : null;
    //	}
    //	if(isset($_GET['RJObatAlkesM']['ruangan_id'])){
    $modObatDialog->ruangan_id = isset($_GET['RJObatAlkesM']['ruangan_id']) ? $_GET['RJObatAlkesM']['ruangan_id'] : null;
    //	}
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialog-m-grid',
    //    'dataProvider'=>$modObatDialog->searchObatFarmasi(),
    'dataProvider' => $modObatDialog->searchObatFarmasiRuangan(),
    'filter' => $modObatDialog,
    'template' => "{items}\n{pager}",
    //    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#form-nonracikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#form-nonracikan #namaObatNonRacik\").val(\"$data->obatalkes_nama\");
							setThreapiobat_id(\"$data->obatalkes_id\");
							$(\"#form-nonracikan #signa\").val(\"$data->signa\");
							$(\"#dialogObat\").dialog(\"close\");
                            return false;
                ",
                ))',
            'filter' => CHtml::activeHiddenField($modObatDialog, 'therapiobat_id') . CHtml::activeHiddenField($modObatDialog, 'ruangan_id'), //RND-7948
        ),
        array(
            'header' => 'Jenis Obat Alkes',
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
            'filter' =>  CHtml::activeDropDownList($modObatDialog, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll(array(
                'condition' => 'jenisobatalkes_aktif = true',
                'order' => 'jenisobatalkes_nama'
            )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'obatalkes_kategori',
            'filter' => CHtml::activeDropDownList($modObatDialog, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --'))
        ),
        array(
            'name' => 'obatalkes_golongan',
            'filter' => CHtml::activeDropDownList($modObatDialog, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --'))
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'header' => 'Nama Obat dan Alkes Lainnya',
            // 'name'=>'obatalkes_namalain',
            'filter' => CHtml::activeHiddenField($modObatDialog, 'obatalkes_namalain') . CHtml::activeTextField($modObatDialog, 'obatalkes_namalain'),
            'value' => '$data->obatalkes_namalain'
        ),
        // 'obatalkes_namalain',
        array(
            'header' => 'Tanggal Kadaluarsa',
            'name' => 'tglkadaluarsa',
            'filter' => '',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)'
        ),         /*
        array(
            'name'=>'satuankecil.satuankecil_nama',
            'header'=>'Satuan Kecil',
        ),
        array(
            'name'=>'satuanbesar.satuanbesar_nama',
            'header'=>'Satuan Besar',
        ), */
        // dicomment karena RND-5732
        //        array(
        //            'header'=>'HJA Resep',
        //            'type'=>'raw',
        //            'value'=>'number_format($data->hjaresep, 0, ",", ".")',
        //            'filter'=>'',
        //            'htmlOptions'=>array('style'=>'text-align:right;'),
        //        ),
        //        array(
        //            'header'=>'HJA Non Resep',
        //            'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
        //            'filter'=>'',
        //            'htmlOptions'=>array('style'=>'text-align:right;'),
        //        ),
        array(
            'name' => 'hargajual',
            'value' => 'MyFormatter::formatNumberForPrint($data->hargajual)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
            'visible' => Params::HIDDEN_GRID_HARGA
        ),
        /*
        array(
            'header'=>'Stok - Satuan',
            'type'=>'raw',
            'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id,"'.$modObatDialog->ruangan_id.'")." - ".$data->satuankecil->satuankecil_nama',
            'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
        ), */


    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObatRacikan',
    'options' => array(
        'title' => 'Daftar Obat Alkes Racikan - <span class="rid">' . $ru->ruangan_nama . '</span>',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$modObatDialogRacikan = new RJObatAlkesM('searchObatFarmasi');
$modObatDialogRacikan->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['RJObatAlkesM'])) {
    $modObatDialogRacikan->attributes = $_GET['RJObatAlkesM'];
    if (isset($_GET['RJObatAlkesM']['ruangan_id'])) {
        $modObatDialogRacikan->ruangan_id = $_GET['RJObatAlkesM']['ruangan_id'];
    }
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialogRacikan-m-grid',
    'dataProvider' => $modObatDialogRacikan->searchObatFarmasiRuangan(),
    'filter' => $modObatDialogRacikan,
    'template' => "{items}\n{pager}",
    //    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                           
                            $(\"#form-racikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#form-racikan #namaObatRacik\").val(\"$data->obatalkes_nama\");
                            $(\"#form-racikan #kekuatanObat\").val(\"".(number_format($data->kekuatan, 2, ",", ""))."\");
							setObat(\"$data->obatalkes_id\");
                            $(\"#dialogObatRacikan\").dialog(\"close\");
                            return false;
                ",
               ))',
            'filter' => CHtml::activeHiddenField($modObatDialogRacikan, 'therapiobat_id') . CHtml::activeHiddenField($modObatDialogRacikan, 'ruangan_id'), //RND-7948
        ),
        array(
            'header' => 'Jenis Obat Alkes',
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
            'filter' =>  CHtml::activeDropDownList($modObatDialogRacikan, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll(array(
                'condition' => 'jenisobatalkes_aktif = true',
                'order' => 'jenisobatalkes_nama'
            )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'obatalkes_kategori',
            'filter' => CHtml::activeDropDownList($modObatDialogRacikan, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --'))
        ),
        array(
            'name' => 'obatalkes_golongan',
            'filter' => CHtml::activeDropDownList($modObatDialogRacikan, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --'))
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'header' => 'Tanggal Kadaluarsa',
            'name' => 'tglkadaluarsa',
            'filter' => '',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)'
        ),         /*
        array(
            'name'=>'satuankecil.satuankecil_nama',
            'header'=>'Satuan Kecil',
        ),
        array(
            'name'=>'satuanbesar.satuanbesar_nama',
            'header'=>'Satuan Besar',
        ), */
        // dicomment karena RND-5732
        //        array(
        //            'header'=>'HJA Resep',
        //            'type'=>'raw',
        //            'value'=>'number_format($data->hjaresep, 0, ",", ".")',
        //            'filter'=>'',
        //            'htmlOptions'=>array('style'=>'text-align:right;'),
        //        ),
        //        array(
        //            'header'=>'HJA Non Resep',
        //            'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
        //            'filter'=>'',
        //            'htmlOptions'=>array('style'=>'text-align:right;'),
        //        ),
        array(
            'name' => 'hargajual',
            'value' => 'MyFormatter::formatNumberForPrint($data->hargajual)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        /*
            array(
            'header'=>'Stok - Satuan',
            'type'=>'raw',
            'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id,"'.$modObatDialogRacikan->ruangan_id.'")." - ".$data->satuankecil->satuankecil_nama',
                'htmlOptions'=>array(
                    'style'=>'text-align: right',
                ),
            ),
            */


    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<script>
    $(function(){
        var sediaan  = jQuery('#sediaanobatnonracikan');
 
        jQuery(sediaan).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '102px',
                enableCaseInsensitiveFiltering: true
        }).hide();
    })
</script>