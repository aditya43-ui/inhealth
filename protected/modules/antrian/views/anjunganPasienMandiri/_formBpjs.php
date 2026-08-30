<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data BPJS & Rujukan</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($modSep,'tglsep', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php  
                            $modSep->tglsep = MyFormatter::formatDateTimeForUser(empty($modSep->tglsep) ? date("Y-m-d") : date("Y-m-d", strtotime($modSep->tglsep)));
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$modSep,
                                            'attribute'=>'tglsep',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                //'showOn' => false,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker3','onkeyup'=>"return $(this).focusNextInputField(event)",),
                        )); ?>
                        <?php  echo $form->error($modSep, 'tglsep'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Rujukan", '', array('class'=>'control-label'))?>
                    <div class="controls form-inline">
                        <?php
                        echo $form->radioButtonList($modSep,'jenisfaskes',array("1"=>"PCare&nbsp;&nbsp;","2"=>"Rumah Sakit"), array('onkeyup'=>"return $(this).focusNextInputField(event)"));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::label("Cari ".$modAsuransiPasien->getAttributeLabel('nopeserta')." <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getAsuransiNoKartu($('#".CHtml::activeId($modAsuransiPasien,"nopeserta")."').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek peserta'></i>", 'nopeserta', array('class'=>'control-label'))?>
                        <div class="controls">
                            <?php
                                echo $form->textField($modAsuransiPasien, 'nopeserta', array(
                                    'placeholder'=>'No. Peserta','rel'=>'tooltip','title'=>'No. Peserta','maxlength'=>13,
                                    'onkeyup'=>"setNoBpjs();return $(this).focusNextInputField(event)",
                                    'onblur'=>"",
                                    'class'=>'numbers-only'
                                ));
                                
                            ?>
                            <?php echo $form->error($modAsuransiPasien,'nopeserta'); ?>
                            <?php echo $form->hiddenField($modAsuransiPasien,'asuransipasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                        </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::label("Cari ".$modAsuransiPasien->getAttributeLabel('nokartuasuransi')." <span class='required'>*</span>", 'nokartuasuransi', array('class'=>'control-label required'))?>
                        <div class="controls">
                            <?php
                                $this->widget('MyJuiAutoComplete', array(
                                                'model'=>$modAsuransiPasien,
                                                'attribute'=>'nokartuasuransi',
                                                'source'=>'js: function(request, response) {
                                                                var penjamin_id = $("#'.CHtml::activeId($model,'penjamin_id').'").val();
                                                                var pasien_id = $("#'.CHtml::activeId($modPasien,'pasien_id').'").val();
                                                               $.ajax({
                                                                   url: "'.$this->createUrl('AutocompleteAsuransiKartu').'",
                                                                   dataType: "json",
                                                                   data: {
                                                                       nokartuasuransi: request.term,
                                                                       penjamin_id: penjamin_id,
                                                                       pasien_id: pasien_id,
                                                                   },
                                                                   success: function (data) {
                                                                           response(data);
                                                                   }
                                                               })
                                                            }',
                                                 'options'=>array(
                                                       'minLength' => 1,
                                                        'focus'=> 'js:function( event, ui ) {
                                                             $(this).val( "");
                                                             return false;
                                                         }',
                                                       'select'=>'js:function( event, ui ) {
                                                            $(this).val(ui.item.value);
                                                            $("#'.CHtml::activeId($modAsuransiPasien,'asuransipasien_id').'").val(ui.item.asuransipasien_id);
                                                            $("#'.CHtml::activeId($modAsuransiPasien,'nopeserta').'").val(ui.item.nopeserta);
                                                            $("#'.CHtml::activeId($modAsuransiPasien,'nokartuasuransi').'").val(ui.item.nokartuasuransi);
                                                            $("#'.CHtml::activeId($modAsuransiPasien,'namapemilikasuransi').'").val(ui.item.namapemilikasuransi);
                                                            $("#'.CHtml::activeId($modAsuransiPasien,'jenispeserta_id').'").val(ui.item.jenispeserta_id);
                                                            $("#'.CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan').'").val(ui.item.nomorpokokperusahaan);
                                                            $("#'.CHtml::activeId($modAsuransiPasien,'namaperusahaan').'").val(ui.item.namaperusahaan);
                                                            $("#'.CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id').'").val(ui.item.kelastanggunganasuransi_id);
                                                            getAsuransiNoKartu(ui.item.nokartuasuransi);
                                                            setAsuransiLama();
                                                            return false;
                                                        }',
                                                ),
                                                'tombolDialog'=>array('idDialog'=>'dialogAsuransiBpjs','jsFunction'=>'cekAsuransiBpjs()'),
                                                'htmlOptions'=>array('placeholder'=>'No. Kartu Asuransi BPJS','rel'=>'tooltip','title'=>'No. Peserta','maxlength'=>13,
                                                    'onkeyup'=>"setNoBpjsReverse();",
                //                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                                                    'class'=>'numbers-only'),
                                            ));
                            ?>
                            <?php echo $form->error($modAsuransiPasien,'nokartuasuransi'); ?>
                      </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAsuransiPasien,'namapemilikasuransi', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAsuransiPasien,'namapemilikasuransi',array('placeholder'=>'Nama Lengkap Pemilik Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo CHtml::checkBox('pemilikasuransisesuai', false, array(
                            'rel'=>'tooltip',
                            'title'=>'Cek untuk disesuaikan dengan Nama Pasien',
                            'onchange'=>'if ($(this).is(":checked")) {'
                            . '$("#'.CHtml::activeId($modAsuransiPasien,'namapemilikasuransi').'").val($("#'.CHtml::activeId($modPasien,'nama_pasien').'").val());'
                            . '} else {'
                            . '$("#'.CHtml::activeId($modAsuransiPasien,'namapemilikasuransi').'").val(pemilik_bpjs);'
                            . '}',
                        )); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo $form->labelEx($modAsuransiPasien,'jenispeserta_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modAsuransiPasien,'jenispersertakode_bpjs'); ?>
                        <?php echo $form->textField($modAsuransiPasien,'jenispeserta_bpjs', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                
                    </div>
                </div>
                <?php
                    echo $form->hiddenField($modAsuransiPasien,'kelastanggunganasuransi_id', array('class'=>'kelastanggunganasuransi_id_bpjs'));
                    if (isset($statusMenu)){
                        echo $form->dropDownListRow($modAsuransiPasien,'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'cekPerbedaanKelas(this);'));
                    }else{
                        echo $form->dropDownListRow($modAsuransiPasien,'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",));
                    }
                ?>

                <div class="control-group">
                    <label class="control-label">Prolanis PRB</label>
                    <div class="controls">
                        <?php echo CHtml::textField("bpjs_prolanis", "-", array('readonly'=>true, 'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dinsos</label>
                    <div class="controls">
                        <?php echo CHtml::textField("bpjs_dinsos", "-", array('readonly'=>true, 'class'=>'span3')); ?>
                    </div>
                </div>
                
                        <div class="control-group">
                            <?php echo $form->labelEx($modRujukanBpjs,'asalrujukan_id', array('class'=>'control-label')) ?>
                            <div class="controls">
                            <?php echo $form->dropDownList($modRujukanBpjs,'asalrujukan_id', CHtml::listData($modRujukanBpjs->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'),
                                                              array('class'=>'span3 rujukandari_id','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                                    'ajax'=>array('type'=>'POST',
                                                                                  'url'=>$this->createUrl('GetRujukanDari',array('encode'=>false,'namaModel'=>'PPRujukanbpjsT')),
                                                                                  'update'=>'#'.CHtml::activeId($modRujukanBpjs, 'rujukandari_id'),),
                                                                    'onchange'=>"clearRujukanBpjs();",)); ?>
                                <?php echo $form->error($modRujukanBpjs, 'asalrujukan_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                                  <?php echo CHtml::label("Cari ".$modRujukanBpjs->getAttributeLabel('no_rujukan')." <span class='required'>*</span> <i class=\"icon-search\" onclick=\"$('#dialogNoRujukan #norujukan').val($('#PPAsuransipasienbpjsM_nopeserta').val()); $('#dialogNoRujukan').dialog('open'); cariDataNoRujukan();\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class'=>'control-label'))?>
                                <div class="controls">
                                    <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                                        'model'=>$modRujukanBpjs,
                                                        'attribute'=>'no_rujukan',
                                                         'options'=>array(
                                                                'focus'=> 'js:function( event, ui ) {
                                                                     $(this).val("");
                                                                     return false;
                                                                 }',
                                                        ),
                                                        'htmlOptions'=>array('placeholder'=>'Nomor Rujukan',
                
                                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                            'onblur'=>"",
                                                            'class'=>'angkahuruf-only'),
                                                    ));
                                    ?>
                                    <?php echo $form->error($modRujukanBpjs,'no_rujukan'); ?>
                                </div>
                        </div>
                
                        <div class="control-group">
                            <?php echo $form->labelEx($modRujukanBpjs,'rujukandari_id', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modRujukanBpjs,'rujukandari_id',CHtml::listData($modRujukanBpjs->getRujukanDariItems($modRujukanBpjs->asalrujukan_id), 'rujukandari_id', 'namaperujuk'),
                                                                  array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setNamaPerujukBpjs(); getPPK(this)')); ?>
                                <?php /* echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>',
                                                                array('class'=>'btn btn-primary','onclick'=>"{addRujukanDari(); $('#dialogAddRujukanDari').dialog('open');}",
                                                                      'id'=>'btnAddRujukanDari','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                                      'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modRujukanBpjs->getAttributeLabel('nama_perujuk'))) */ ?>
                                <?php echo $form->error($modRujukanBpjs, 'rujukandari_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                                <?php echo CHtml::label("PPK Rujukan <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getBpjsPPKRujukan($('#".CHtml::activeId($modSep,"ppkrujukan")."').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek PPK Rujukan'></i>", 'ppkrujukan', array('class'=>'control-label'))?>
                                <div class="controls">
                
                                    <?php echo $form->textField($modSep,'ppkrujukan', array('placeholder'=>'','class'=>'span3 all-caps','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                </div>
                        </div>
                        <?php echo $form->textFieldRow($modRujukanBpjs,'nama_perujuk', array('placeholder'=>'Nama Lengkap Perujuk','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                        <div class="control-group">
                            <label class="control-label required" for="PPRujukanbpjsT_tanggal_rujukan">
                            Tanggal Rujukan
                            <span class="required">*</span>
                          </label>
                            <div class="controls">
                                <?php
                                         $modRujukanBpjs->tanggal_rujukan = (!empty($modRujukanBpjs->tanggal_rujukan) ? date("d/m/Y H:i:s",strtotime($modRujukanBpjs->tanggal_rujukan)) : null);
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$modRujukanBpjs,
                                                        'attribute'=>'tanggal_rujukan',
                                                        'mode'=>'datetime',
                                                        'options'=> array(
                        //                                    'dateFormat'=>Params::DATE_FORMAT,
                                                            'showOn' => false,
                                                            'maxDate' => 'd',
                                                        ),
                                                        'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
                                )); ?>
                
                                <?php echo $form->error($modRujukanBpjs, 'tanggal_rujukan'); ?>
                            </div>
                        </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                            <label for="PPRujukanbpjsT_kddiagnosa_rujukan" class="control-label">Kode Diagnosa Awal <span class="required">*</span><i class="icon-search" onclick="$('#dialogDiagnosa').dialog('open')", style="cursor:pointer;" rel='tooltip' title='klik untuk mencari diagnosa rujukan'></i></label>
                            <div class="controls">
                                <?php
                                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                        'model'=>$modRujukanBpjs,
                                        'attribute'=>'kddiagnosa_rujukan',
                                        'data'=> explode(',', $modRujukanBpjs->kddiagnosa_rujukan),
                                        'debugMode'=>true,
                                        'options'=>array(
                                            'addontab'=> true,
                                            'maxitems'=> 10,
                                            'input_min_size'=> 0,
                                            'cache'=> true,
                                            'newel'=> true,
                                            'addoncomma'=>true,
                                            'select_all_text'=> "",
                                            'autoFocus'=>true,
                                        ),
                                        'htmlOptions'=>array('id'=>'diagnosaRujukanKodeBpjs'),
                                    ));
                                ?>
                                <?php echo $form->error($modRujukanBpjs, 'kddiagnosa_rujukan'); ?>
                        </div>
                </div>
                <div class="control-group">
                                <label for="PPRujukanbpjsT_diagnosa_rujukan" class="control-label">Diagnosa Awal <span class="required">*</span></label>
                                <div class="controls">
                                    <?php
                                        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                            'model'=>$modRujukanBpjs,
                                            'attribute'=>'diagnosa_rujukan',
                                            'data'=> explode(',', $modRujukanBpjs->diagnosa_rujukan),
                                            'debugMode'=>true,
                                            'options'=>array(
                                                'addontab'=> true,
                                                'maxitems'=> 10,
                                                'input_min_size'=> 0,
                                                'cache'=> true,
                                                'newel'=> true,
                                                'addoncomma'=>true,
                                                'select_all_text'=> "",
                                                'autoFocus'=>true,
                                            ),
                                            'htmlOptions'=>array('id'=>'diagnosaRujukanBpjs'),
                                        ));
                                    ?>
                                    <?php echo $form->error($modRujukanBpjs, 'diagnosa_rujukan'); ?>
                            </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Spesialis/Subspesialis</label>
                    <div class="controls">
                        <?php echo $form->textField($modSep, 'politujuan', array('readonly'=>true, 'class'=>'span3')); ?>
                        <?php 
                        $modSep->poli_eksekutif = $modSep->isNewRecord ? "0" : $modSep->poli_eksekutif;
                        echo $form->radioButtonListRow($modSep, 'poli_eksekutif', array(
                            1 => 'Ya', 0 => 'Tidak'
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modSep, 'jenis_kunjungan', array('class'=>'control-label', 'label'=>'Jenis Kunjungan <span class="required">*</span>')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modSep, 'jenis_kunjungan', LookupM::getItemsUrutan('bpjs_jnskunjungan'), array(
                            'class'=>'span3', 'onchange'=>'pilihJenisKunjunganBPJS();'
                        )); ?>
                        <?php echo $form->dropDownListRow($modSep, 'flag_procedure', LookupM::getItemsUrutan('bpjs_flagprocedure'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
                        <?php echo $form->dropDownListRow($modSep, 'kode_penunjang', LookupM::getItemsUrutan('bpjs_kdpenunjang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modSep, 'asesmen_pelayanan', array('class'=>'control-label', 'label'=>'Asesmen Pelayanan')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modSep, 'asesmen_pelayanan', LookupM::getItemsUrutan('bpjs_asesmenpelayanan'), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="panel panel-success rujukan" id="skdp">
                    <div class="control-group">
                        <?php echo CHtml::label("Nomor Surat Kontrol", 'Nomor Surat Kontrol', array('class'=>'control-label'))?>
                        <div class="controls">
                                <?php echo $form->textField($modSep,'no_surat',array('placeholder'=>'Nomor Surat Kontrol','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>6, 'rel'=>'tooltip', 'title'=>'Isi jika pasien dengan surat kontrol')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Dokter DPJP", 'nama_dpjp', array('class'=>'control-label'))?>
                        <div class="controls">
                            <?php echo $form->textField($modSep,'nama_dpjp',array('placeholder'=>'Dokter DPJP','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'rel'=>'tooltip', 'title'=>'Isi jika pasien dengan surat kontrol','onblur'=>"if($(this).val()=='') $('#".CHtml::activeId($model, 'kode_dpjp')."').val('')")); ?>
                            <?php echo CHtml::link("<i class='icon-search'></i>",'javascript:void(0)',array("rel"=>"tooltip","title"=>"klik untuk cari DPJP","onclick"=>"$('#dialogDpjp').dialog('open');return true;"));?>
                            <?php echo $form->hiddenField($modSep,'kode_dpjp',array('placeholder'=>'Dokter DPJP','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                        <?php 
                        $dpjp_req = "";
                        // if (in_array($act, array("pendaftaranrawatjalan", "pendaftaranrawatdarurat"))) { //, 'pendaftaranpersalinan'))) {
                            echo CHtml::label('DPJP yang Melayani <span class="required">*</span>', 'nama_dpjp', array('class'=>'control-label'));
                            $dpjp_req = "required";
                        //} else {
                        //    echo CHtml::label("DPJP yang Melayani", 'nama_dpjp', array('class'=>'control-label'));
                        //}
                        ?>
                        <div class="controls">
                            <?php echo $form->textField($modSep,'dpjpygmelayani_nama',array('placeholder'=>'Dokter DPJP','class'=>'span3 '.$dpjp_req, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'rel'=>'tooltip', 'title'=>'Isi jika pasien dengan surat kontrol','onblur'=>"if($(this).val()=='') $('#".CHtml::activeId($model, 'kode_dpjp')."').val('')")); ?>
                            <?php echo CHtml::link("<i class='icon-search'></i>",'javascript:void(0)',array("rel"=>"tooltip","title"=>"klik untuk cari DPJP","onclick"=>"$('#dialogDpjpMelayani').dialog('open');return true;"));?>
                            <?php echo $form->hiddenField($modSep,'dpjpygmelayani_kode',array('placeholder'=>'Dokter DPJP','class'=>'span3 '.$dpjp_req, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                        </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("No. Telepon Peserta <span class='required'>*</span>", 'no_telpon_peserta', array('class'=>'control-label'))?>
                    <div class="controls">
                            <?php echo $form->textField($modSep,'no_telpon_peserta',array('placeholder'=>'Telepon peserta','class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    </div>
                </div>
                <?php
                    // if (Yii::app()->user->getState('isbridging')) {
                ?>
                <?php echo $form->hiddenField($modSep,'sep_id', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <label class="control-label">
                    <?php echo CHtml::checkBox('isSepManual','',array('onchange'=>'setSEP(this)')); ?>
                    No. SEP
                    <!--<span class="required">*</span>-->
                  </label>
                    <div class="controls">
                        <?php echo $form->textField($modSep,'nosep',array('placeholder'=>'No. SEP Manual / Otomatis','class'=>'span3 nosep', 'disabled'=>'disabled' ,'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->error($modSep, 'nosep'); ?>
                        <?php echo "<i class=\"icon-search\" onclick=\"cekSEP($('#".CHtml::activeId($modSep,"nosep")."').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek SEP'></i>"; ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($modSep,'nosep', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php //echo $form->hiddenField($modSep,'ppkpelayanan', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php //echo $form->dropDownListRow($modSep,'jnspelayanan',LookupM::getItems('jenispelayanan'), array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setNamaPerujuk();')); ?>
                <?php echo $form->textAreaRow($modSep,'catatansep', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php //} ?>
            </div>
        </div>
    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogNoRujukan',
    'options' => array(
        'title' => 'Pencarian Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('_pencarianRujukanBpjs');
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Pencarian Diagnosa Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDiagnosa = new PPDiagnosaM('search');
$modDiagnosa->unsetAttributes();
if (isset($_GET['PPDiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['PPDiagnosaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDiagnosa->search(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "
                                            setDiagnosaBpjs(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");

                                        $(\"#dialogDiagnosa\").dialog(\"close\");
                                    "))',
        ),
        'diagnosa_kode',
        //'diagnosa_nama',
        array(
            'header' => 'Nama',
            'name' => 'diagnosa_namalainnya',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDpjp',
    'options' => array(
        'title' => 'Pencarian Dokter DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('_pencarianDpjp');
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDpjpMelayani',
    'options' => array(
        'title' => 'Pencarian Dokter DPJP yang Melayani',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('_pencarianDpjpMelayani');
$this->endWidget();
?>



<script>
/**
 * fungsi BPJS
 */
function resetFormBpjs(){
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'asuransipasien_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispeserta_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'namaperusahaan') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val('');
    $(".kelastanggunganasuransi_id_bpjs").val('');
    $("#<?php echo CHtml::activeId($modRujukanBpjs,'asalrujukan_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modRujukanBpjs,'no_rujukan') ?>").val('');
    $("#<?php echo CHtml::activeId($modRujukanBpjs,'rujukandari_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk') ?>").val('');
    $("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan') ?>").val('');
    $("#diagnosaRujukanKodeBpjs").each(function(){
        $(this).find('option').detach();
    });
    $("#diagnosaRujukanKodeBpjs").each(function(){
        $(this).parent().find('.holder .bit-box').detach();
    });
    $("#diagnosaRujukanBpjs").each(function(){
        $(this).find('option').detach();
    });
    $("#diagnosaRujukanBpjs").each(function(){
        $(this).parent().find('.holder .bit-box').detach();
    });
    $("#<?php echo CHtml::activeId($modSep,'sep_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modSep,'ppkrujukan') ?>").val('');
    $("#<?php echo CHtml::activeId($modSep,'catatansep') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispersertakode_bpjs') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispeserta_bpjs') ?>").val('');
}



function getAsuransiNoKartu(isi, databpjs)
{
    //if (<?php // echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
    if (isi=="") {myAlert('Isi data terlebih dahulu!'); return false;};
    var aksi = 4; // 1 untuk mencari data peserta berdasarkan Nomor Kartu

        resetFormBpjs();

    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
            var obj = JSON.parse(data);

            if(obj != null && obj.response !=null){
                if(obj.response.rujukan != null && obj.response.rujukan != undefined){
                    var rujukan = obj.response.rujukan;
                    var peserta = rujukan.peserta;
                }else{
                    var peserta = obj.response.peserta;
                }

            if (peserta.statusPeserta.keterangan == 'AKTIF') {

                var provRujukan = (rujukan != null) ? rujukan.provPerujuk : null;

                setKelasTanggunganDrop();

                if (provRujukan != null) {
                    getRujukanDari(provRujukan.kode);
                }

                var prolanis = peserta.informasi.prolanisPRB;
                var dinsos = peserta.informasi.noSKTM;

                if (prolanis == null) {
                    prolanis = "-";
                }

                if (dinsos == null) {
                    dinsos = "-";
                }

                $("#bpjs_prolanis").val(dinsos);
                $("#bpjs_dinsos").val(dinsos);

                $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
                
                if (provRujukan != null) {
                    $("#<?php echo CHtml::activeId($modSep,'ppkrujukan') ?>").val(provRujukan.kode);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(provRujukan.nama);
                }

                $("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val(peserta.noKartu);
                $("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val(peserta.noKartu);
                $("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val(peserta.nama);
                $("#PPAsuransipasienbpjsM_kelastanggunganasuransi_id").val(peserta.hakKelas.kode);
                $(".kelastanggunganasuransi_id_bpjs").val(peserta.hakKelas.kode);
                $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
            $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);

                <?php if($this->id == "pendaftaranRawatDarurat"){ ?>
                    getPPKPelayanan();
                <?php }else if($this->id == "pendaftaranRawatInapDariRJRD"){ ?>
                    if($('#instalasiasalRI_id').val() != undefined && $('#instalasiasalRI_id').val() == '<?php echo Params::INSTALASI_ID_RD; ?>'){
                        getPPKPelayanan();
                    }
                <?php } ?>

                if(rujukan != null && rujukan != undefined){
                    $("#<?php echo CHtml::activeId($modRujukanBpjs,'no_rujukan') ?>").val(rujukan.noKunjungan);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk') ?>").val(rujukan.provPerujuk.nama);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan') ?>").val(rujukan.tglKunjungan);
                    setDiagnosaBpjs(rujukan.diagnosa.kode,rujukan.diagnosa.nama);
                }
                $("#<?php echo CHtml::activeId($modSep,'no_telpon_peserta') ?>").val($("#<?php echo CHtml::activeId($modPasien,'no_mobile_pasien') ?>").val());
            }

            }else{
                if (obj != null) {
                    if (typeof obj.metaData !== 'undefined'){
                        if(obj.metaData.message != 'Rujukan Tidak Ada'){
                            myAlert(obj.metaData.message);
                        }
                    }else{
                            if (typeof databpjs !== 'undefined'){
                                    $("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val(databpjs.nopeserta);
                                    $("#<?php echo CHtml::activeId($modAsuransiPasien,'asuransipasien_id') ?>").val(databpjs.asuransipasien_id);
                                    $("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val(databpjs.nokartuasuransi);
                                    $("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val(databpjs.namapemilikasuransi);
                                    $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispeserta_id') ?>").val(databpjs.jenispeserta_id);
                                    $("#<?php echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val(databpjs.kelastanggunganasuransi_id); // <<tidak sama dengan kelaspelayanan_id
                                    $(".kelastanggunganasuransi_id_bpjs").val(databpjs.kelastanggunganasuransi_id);
                            }
                    }
                }else{

                        if (typeof databpjs !== 'undefined'){
                                $("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val(databpjs.nopeserta);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien,'asuransipasien_id') ?>").val(databpjs.asuransipasien_id);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val(databpjs.nokartuasuransi);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val(databpjs.namapemilikasuransi);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispeserta_id') ?>").val(databpjs.jenispeserta_id);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val(databpjs.kelastanggunganasuransi_id); // <<tidak sama dengan kelaspelayanan_id
                                $(".kelastanggunganasuransi_id_bpjs").val(databpjs.kelastanggunganasuransi_id);
                        }
                }
                //alert(3);
            }
        },
        error: function(data){
            $("#content-bpjs").removeClass("animation-loading");
        }
    }

    if(typeof ajax_request !== 'undefined')
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function getAsuransiNoPeserta(isi)
{
    // if (<?php // echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
    if (isi=="") {myAlert('Isi data terlebih dahulu!'); return false;};
    var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu

        resetFormBpjs();

    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
            var obj = JSON.parse(data);

            if(obj != null && obj.response !=null){
                var peserta = obj.response.peserta;

        getAsuransiNoKartu(peserta.noKartu);
                setKelasTanggunganDrop();
                getRujukanDari(peserta.provUmum.kdProvider);
                $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
                $("#<?php echo CHtml::activeId($modSep,'ppkrujukan') ?>").val(peserta.provUmum.kdProvider);
                $("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val(peserta.noKartu);
                $("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val(peserta.noKartu);
                $("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val(peserta.nama);
                $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
            $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);

            $("#<?php echo CHtml::activeId($modSep,'no_telpon_peserta') ?>").val($("#<?php echo CHtml::activeId($modPasien,'no_mobile_pasien') ?>").val());



//              $("#<?php // echo CHtml::activeId($modRujukanBpjs,'no_rujukan') ?>").val(noKunjungan);
//              $("#<?php // echo CHtml::activeId($modRujukanBpjs,'nama_perujuk') ?>").val(provRujukan.nama);
//              $("#<?php // echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan') ?>").val(tglKunjungan);

//              setDiagnosaBpjs(diagnosa.kode,diagnosa.nama);
//              $("#PPSepT_ppkrujukan").val(provRujukan.kode);
            $("#PPAsuransipasienbpjsM_nopeserta").val(peserta.noKartu);
            $("#PPAsuransipasienbpjsM_nokartuasuransi").val(peserta.noKartu);
            $("#PPAsuransipasienbpjsM_namapemilikasuransi").val(peserta.nama);
//              $("#PPAsuransipasienbpjsM_jenispeserta_id").val(peserta.jenisPeserta.kode);
            $("#PPAsuransipasienbpjsM_kelastanggunganasuransi_id").val(peserta.hakKelas.kode);
            $(".kelastanggunganasuransi_id_bpjs").val(peserta.hakKelas.kode);
            <?php if($this->id == "pendaftaranRawatDarurat"){ ?>
                    getPPKPelayanan();
                <?php }else if($this->id == "pendaftaranRawatInapDariRJRD"){ ?>
                    if($('#instalasiasalRI_id').val() != undefined && $('#instalasiasalRI_id').val() == '<?php echo Params::INSTALASI_ID_RD; ?>'){
                        getPPKPelayanan();
                    }
                <?php } ?>
//              pemilik_bpjs = peserta.nama;
//            jQuery.expr[':'].contains = function(a, i, m) {
//              return jQuery(a).text().toUpperCase()
//                      .indexOf(m[3].toUpperCase()) >= 0;
//            };
//				if (peserta != null){
//
////                                        getJenisPesertaBpjs(peserta.jenisPeserta.kode);
//
//
////					$("#<?php // echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val(peserta.hakKelas.kode); // <<tidak sama dengan kelaspelayanan_id
//					// OVERWRITES old selecor
//
//					// $("#<?php // echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").find(peserta.kelasTanggungan.nmKelas).attr("selected",true);
//				}else{
//
//					if (typeof databpjs !== 'undefined'){
//						$("#<?php // echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val(databpjs.nopeserta);
//						$("#<?php // echo CHtml::activeId($modAsuransiPasien,'asuransipasien_id') ?>").val(databpjs.asuransipasien_id);
//						$("#<?php // echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val(databpjs.nokartuasuransi);
//						$("#<?php // echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val(databpjs.namapemilikasuransi);
//						$("#<?php // echo CHtml::activeId($modAsuransiPasien,'jenispeserta_id') ?>").val(databpjs.jenispeserta_id);
//						$("#<?php // echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val(databpjs.kelastanggunganasuransi_id); // <<tidak sama dengan kelaspelayanan_id
//					}
//				}
            }else{
                if (obj != null) {
                    if (typeof obj.metaData !== 'undefined'){
                            myAlert(obj.metaData.message);
                    }
                }
            }
        },
        error: function(data){
            $("#content-bpjs").removeClass("animation-loading");
        }
    }

    if(typeof ajax_request !== 'undefined')
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}


function setDiagnosa(kode_diagnosa,nama_diagnosa){

var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
var randomId = '';
for (var i = 0; i < 32; i++) {
    var rnum = Math.floor(Math.random() * chars.length);
    randomId += chars.substring(rnum, rnum + 1);
}

var op = '<option id="opt_'+randomId+'" class="selected" selected="selected" value="'+nama_diagnosa+'">'+nama_diagnosa+'</option>';
var list = '<li id="pt_'+randomId+'" class="bit-box" rel="'+nama_diagnosa+'">'+nama_diagnosa+'<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
var opKode = '<option id="opt_'+randomId+'" class="selected" selected="selected" value="'+kode_diagnosa+'">'+kode_diagnosa+'</option>';
var listKode = '<li id="pt_'+randomId+'" class="bit-box" rel="'+kode_diagnosa+'">'+kode_diagnosa+'<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
var objSelect = $('select#diagnosaRujukan').parent().find('select');
var objList = $('select#diagnosaRujukan').parent().find('ul li.bit-input');
var objSelectKode = $('select#diagnosaRujukanKode').parent().find('select');
var objListKode = $('select#diagnosaRujukanKode').parent().find('ul li.bit-input');

objSelect.append(op);
objList.before(list);
objSelectKode.append(opKode);
objListKode.before(listKode);

}

function setDiagnosaBpjs(kode_diagnosa,nama_diagnosa){


    console.log("ADDER");

var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
var randomId = '';
for (var i = 0; i < 32; i++) {
    var rnum = Math.floor(Math.random() * chars.length);
    randomId += chars.substring(rnum, rnum + 1);
}

var op = '<option id="opt_'+randomId+'" class="selected" selected="selected" value="'+nama_diagnosa+'">'+nama_diagnosa+'</option>';
var list = '<li id="pt_'+randomId+'" class="bit-box" rel="'+nama_diagnosa+'">'+nama_diagnosa+'<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
var opKode = '<option id="opt_'+randomId+'" class="selected" selected="selected" value="'+kode_diagnosa+'">'+kode_diagnosa+'</option>';
var listKode = '<li id="pt_'+randomId+'" class="bit-box" rel="'+kode_diagnosa+'">'+kode_diagnosa+'<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
var objSelect = $('select#diagnosaRujukanBpjs').parent().find('select');
var objList = $('select#diagnosaRujukanBpjs').parent().find('ul li.bit-input');
var objSelectKode = $('select#diagnosaRujukanKodeBpjs').parent().find('select');
var objListKode = $('select#diagnosaRujukanKodeBpjs').parent().find('ul li.bit-input');

objSelect.append(op);
objList.before(list);
objSelectKode.append(opKode);
objListKode.before(listKode);

console.log("ADDER");

}

function removeItemDiagnosa(id){
$('li#'+id).remove();
var id_opt = id.replace('pt_','opt_');
$('option#'+id_opt).remove();
}

function setNoKartuAsuransi(){
  var nopeserta       = $("input[name$='[nopeserta]']").val();
  $("input[name$='[nokartuasuransi]']").val(nopeserta);
}

function setNoBpjs(){
  var nopeserta= $("#PPAsuransipasienbpjsM_nopeserta").val();
  $("#PPAsuransipasienbpjsM_nokartuasuransi").val(nopeserta);
}

function setNoBpjsReverse(){
  var nokartuasuransi = $("#PPAsuransipasienbpjsM_nokartuasuransi").val();
  //alert(nokartuasuransi);
  $("#PPAsuransipasienbpjsM_nopeserta").val(nokartuasuransi);
}

function setKelasTanggunganDrop(){
	<?php
		$drop_kelasbpjs = CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama');

		$drop_bpjs = '';
		if (count((array)$drop_kelasbpjs)>0){

			if (count((array)$drop_kelasbpjs)>1){
				$drop_bpjs .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			}

			foreach($drop_kelasbpjs as $value=>$name)
			{
				$drop_bpjs .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
			}
		}

		$drop_kelas = CHtml::listData(PPPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama');
		$drop_asuran = '';

		if (count((array)$drop_kelas)>0){

			if (count((array)$drop_kelas)>1){
				$drop_asuran .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			}

			foreach($drop_kelas as $value1=>$name1)
			{
				$drop_asuran .= CHtml::tag('option', array('value'=>$value1),CHtml::encode($name1),true);
			}
		}
	?>
	var dropdown_kelasbpjs = '<?php echo $drop_bpjs; ?>';
	var dropdown_kelas = '<?php echo $drop_asuran; ?>';

	<?php if (isset($statusMenu)){ ?>
		var carabayar = $("#PPPasienAdmisiT_carabayar_id option:selected").val();
	<?php }else{ ?>
		var carabayar = $("#PPPendaftaranT_carabayar_id option:selected").val();
	<?php } ?>

	if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>){
		$("#PPAsuransipasienM_nokartuasuransi").attr('maxlength',13);
		$("#PPAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelasbpjs);
	}else{
		$("#PPAsuransipasienM_nokartuasuransi").attr('maxlength',24);
		$("#PPAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelas);
	}

}

function getPPKPelayanan()
{
	// if (<?php // echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {
	// } else {
	//	myAlert('Fitur Bridging tidak aktif!');
	//	return false;
	//}

        var jenis_rujukan = 2;
        var kodeppkpelayanan = '<?php echo Yii::app()->user->getState('ppkpelayanan'); ?>';

	var aksi = 16;
	var setting = {
		url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
		type: 'GET',
		dataType: 'html',
		data: 'param=' + aksi + '&kodeppkpelayanan=' + kodeppkpelayanan + '&jenis_rujukan=' +jenis_rujukan,
		beforeSend: function () {
			$("#content-bpjs").addClass("animation-loading");
		},
		success: function (data) {
                    $("#content-bpjs").removeClass("animation-loading");
                    var obj = JSON.parse(data);
                    if(obj.metaData.code == '201'){
//				myAlert(obj.metaData.message);
                    }else{
                        if (obj.response != null) {
                            var faskes = obj.response.faskes;
                            $('#<?php echo CHtml::activeId($model,'ppkpelayanan_nama'); ?>').val(faskes[0].nama);

                            <?php if($this->id == "pendaftaranRawatDarurat"){ ?>
                                $('#<?php echo CHtml::activeId($modSep,'ppkrujukan'); ?>').val(faskes[0].kode);
                                $('#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk'); ?>').val(faskes[0].nama);
                            <?php }else if($this->id == "pendaftaranRawatInapDariRJRD"){ ?>
                                if($('#instalasiasalRI_id').val() != undefined && $('#instalasiasalRI_id').val() == '<?php echo Params::INSTALASI_ID_RD; ?>'){
                                    $('#<?php echo CHtml::activeId($modSep,'ppkrujukan'); ?>').val(faskes[0].kode);
                                    $('#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk'); ?>').val(faskes[0].nama);
                                }
                            <?php } ?>
                        }
                    }
		},
		error: function (data) {
			$("#content-bpjs").removeClass("animation-loading");
		}
	}

	if (typeof ajax_request !== 'undefined')
		ajax_request.abort();
	ajax_request = $.ajax(setting);
}


function getRujukanDari(kodeppk){
    var asarujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id') ?>").val();
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetRujukanDariBpjs'); ?>',
        data: {kodeppk: kodeppk, asarujukan: asarujukan},
        dataType: "json",
        success:function(data){
             $("#<?php echo CHtml::activeId($modRujukanBpjs,'asalrujukan_id') ?>").val(data.asalrujukan);
             $("#<?php echo CHtml::activeId($modRujukanBpjs,'rujukandari_id') ?>").html(data.datarujukandari);
           $("#<?php echo CHtml::activeId($modRujukanBpjs,'rujukandari_id') ?>").val(data.rujukandari);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    }
    
    function getRujukanNoRujukan(isi)
    {
    //if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
    if (isi=="") {myAlert('Isi data terlebih dahulu!'); return false;};
    var aksi = 3; // 3 untuk mencari data rujukan berdasarkan Nomor rujukan
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
            var obj = JSON.parse(data);
    
            if(obj.response.rujukan!=null){
               var rujukan = obj.response.rujukan;
               var noKunjungan = rujukan.noKunjungan;
               var tglKunjungan = rujukan.tglKunjungan;
               var peserta = rujukan.peserta;    //array
               var provKunjungan = rujukan.provKunjungan;    //array
               var keluhan = rujukan.keluhan;
               var diagnosa = rujukan.diagnosa;    //array
               var catatan = rujukan.catatan;
               var pemFisikLain = rujukan.pemFisikLain;
               var provRujukan = rujukan.provPerujuk;    //array
               var poliRujukan = rujukan.poliRujukan;    //array

               getRujukanDari(provRujukan.kode);
 //              getJenisPesertaBpjs(peserta.jenisPeserta.kode);
 $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
               $("#<?php echo CHtml::activeId($modAsuransiPasien,'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
               $("#<?php echo CHtml::activeId($modSep,'ppkrujukan') ?>").val(peserta.provUmum.kdProvider);

               $("#<?php echo CHtml::activeId($modSep,'politujuan') ?>").val(rujukan.poliRujukan.kode);

               $("#<?php echo CHtml::activeId($modRujukanBpjs,'no_rujukan') ?>").val(noKunjungan);
               $("#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk') ?>").val(provRujukan.nama);
               $("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan') ?>").val(tglKunjungan);

               setDiagnosaBpjs(diagnosa.kode,diagnosa.nama);
               $("#PPSepT_ppkrujukan").val(provRujukan.kode);
               $("#PPAsuransipasienbpjsM_nopeserta").val(peserta.noKartu);
               $("#PPAsuransipasienbpjsM_nokartuasuransi").val(peserta.noKartu);
               $("#PPAsuransipasienbpjsM_namapemilikasuransi").val(peserta.nama);
 //              $("#PPAsuransipasienbpjsM_jenispeserta_id").val(peserta.jenisPeserta.kode);
               $("#PPAsuransipasienbpjsM_kelastanggunganasuransi_id").val(peserta.hakKelas.kode);
               $(".kelastanggunganasuransi_id_bpjs").val(peserta.hakKelas.kode);
             }else{
               myAlert(obj.metadata.message);
             }
        },
        error: function(data){
            $("#content-bpjs").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined')
        ajax_request.abort();
    ajax_request = $.ajax(setting);
    }

    function cekSEP(nosep) {
        var setting = {
            url : "<?php echo $this->createUrl('cekSEP'); ?>",
            type : 'POST',
            dataType : 'json',
            data : {nosep: nosep},
            beforeSend: function(){
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data){
                $("#content-bpjs").removeClass("animation-loading");
                console.log(data);
                var obj = data;
                if(obj.response!=null){
                    myAlert(
                        "Nama Peserta : " + obj.response.peserta.nama + "\n" +
                        "Nomor Kartu : " + obj.response.peserta.noKartu + "\n" +
                        "No. Sep : " + obj.response.noSep
                    );
                    $("#PPSepT_ppkrujukan").val(obj.response.provRujukan.kdProvider);
                    $("#PPRujukanbpjsT_no_rujukan").val(obj.response.noRujukan);
                    getAsuransiNoKartu(obj.response.peserta.noKartu);
                    if (obj.rujukan.rujukandari_id.toString().trim() != "") {
                        $("#PPRujukanbpjsT_asalrujukan_id").val(obj.rujukan.asalrujukan_id);
                        $("#PPRujukanbpjsT_rujukandari_id")
                                .html(obj.rujukan.listrujukandari_id)
                                .val(obj.rujukan.rujukandari_id)
                                .change();
                    }
                }else{
                myAlert(obj.metadata.message);
                }
            },
            error: function(data){
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if(typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }


    function setKodeRuanganBPJS() {
        var ruangan_id = $("#PPPendaftaranT_ruangan_id").val();

        $.post('<?php echo $this->createUrl('getRuanganSpesialisBPJS') ?>', {
            ruangan_id: $(this).val(),
        }, function(data) {
            if (data.ok == 1) {
                $("#PPSepT_politujuan").val(data.kode);
            }
        }, 'json');
    }

    function pilihJenisKunjunganBPJS() {
        var jenis = $("#PPSepT_jenis_kunjungan").val();

        if (jenis == "0") {
            $("#PPSepT_flag_procedure").val(null).prop("readonly", true).prop("disabled", true);
            $("#PPSepT_kode_penunjang").val(null).prop("readonly", true).prop("disabled", true);
        } else {
            $("#PPSepT_flag_procedure").prop("readonly", false).prop("disabled", false);
            $("#PPSepT_kode_penunjang").prop("readonly", false).prop("disabled", false);
        }

        if (jenis == "2" || jenis == "0") {
            $("#PPSepT_asesmen_pelayanan").val(4);
        }
    }

    function setNoTelpBPJS() {
        $("#PPSepT_no_telpon_peserta").val($("#PPPasienM_no_mobile_pasien").val());
    }

    $("#PPPasienM_no_mobile_pasien").on("blur", setNoTelpBPJS);
    $("#PPPendaftaranT_ruangan_id").on("change", setKodeRuanganBPJS);

    $(document).ready(function() {
        //pilihJenisKunjunganBPJS();
    });

</script>