<div class="row-fluid">
    <div class="span6">

        <?php echo $form->hiddenField($modAsuransiPasien, 'nokartuasuransi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->hiddenField($modAsuransiPasien, 'nopeserta', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'tglcetakkartuasuransi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->hiddenField($modAsuransiPasien, 'kelastanggunganasuransi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php // echo $form->hiddenField($modAsuransiPasien,'jenispeserta_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo $form->hiddenField($model, 'namaasuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'no_asuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'hakkelas_kode', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <div class="rujukanBpjs clsrujukan">
            <div class="control-group ">
                <?php echo CHtml::label("Jenis/Asal Rujukan", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls form-inline">
                    <?php
                    echo $form->radioButtonList($model, 'jenispeserta_id', array("1" => "PCare&nbsp;&nbsp;", "2" => "Rumah Sakit"), array('onkeyup' => "return $(this).focusNextInputField(event)", "class"=>"jenispeserta_id jenisfaskes_bpjs"));
                    ?>
                </div>
            </div>
        </div>
        <div class="control-group clsrujukan">
            <?php echo CHtml::label("No.Rujukan <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modRujukanBpjs, 'no_rujukan', array('placeholder' => 'No. Rujukan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array('class' => 'rujukanTombol', "rel" => "tooltip", "title" => "klik untuk mengecek rujukan", "onclick" => "$('#dialogNoRujukan').dialog('open');")); ?>
                <?php echo $form->error($modRujukanBpjs, 'no_rujukan'); ?>
            </div>
        </div>
        <div class="rujukanBpjs clsrujukan">
            <div class="control-group ">
                <label class="control-label" for="ARRujukanbpjsT_tanggal_rujukan">
                    Tanggal Rujukan
                    <span class="required">*</span>
                </label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modRujukanBpjs,
                        'attribute' => 'tanggal_rujukan',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class' => 'dtPicker2 span3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                    )); ?>
                    <?php echo $form->error($modRujukanBpjs, 'tanggal_rujukan'); ?>
                </div>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("No. Kartu BPJS <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopeserta', array('placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk mengecek peserta", "onclick" => "getAsuransiNoKartu($('#" . CHtml::activeId($model, "nopeserta") . "').val());return true;")); ?>
                <?php echo $form->error($model, 'nopeserta'); ?>
                <?php echo $form->hiddenField($model, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </div>
        </div>

        <div class="control-group " hidden>
            <label class="control-label">
                No. SEP
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'nosep', array('placeholder' => 'No. SEP Otomatis', 'class' => 'span3', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'nosep'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglsep', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                if(!empty($modPengajuanApproval) && !empty($modPengajuanApproval->tgl_sep)){
                    $model->tglsep = (!empty($modPengajuanApproval->tgl_sep)? MyFormatter::formatDateTimeForUser(date('Y-m-d',strtotime((String)MyFormatter::formatDateTimeForDb($modPengajuanApproval->tgl_sep)))) : null);
                    echo $form->textField($model, 'tglsep', array('class' => 'span3', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);"));
                }else{
                    $model->tglsep = MyFormatter::formatDateTimeForUser($model->tglsep);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglsep',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 span3 datetime', 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                }
                 ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modAsuransiPasien, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group ">
            <?php echo $form->labelEx($modAsuransiPasien, 'jenispeserta_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modAsuransiPasien, 'jenispersertakode_bpjs'); ?>
                <?php echo $form->textField($modAsuransiPasien, 'jenispeserta_bpjs', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Kode PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ppkpelayanan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Nama PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ppkpelayanan_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($modAsuransiPasien,'kelastanggunganasuransi_id', CHtml::listData(ARPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama') ,array('disabled'=>false,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",));  ?>
        <?php echo $form->hiddenField($model, 'klsRawatNaik'); ?>     
        
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

        <?php echo $form->dropDownListRow($model, 'jnspelayanan',  LookupM::getItems('jenispelayanan'), array('empty' => '--Pilih--', 'class' => 'span3')); ?>
        <div class="control-group ">
            <?php echo CHtml::label("Kelas Rawat <span class='required'>*</span>", 'kelastanggungan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'klsrawat', CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true and kelasbpjs_id is not null order by urutankelas ASC'),'kelasbpjs_id','kelaspelayanan_nama'), array(
                    'empty' => '-Pilih-', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                )); ?>
            </div>
        </div>
        <?php 
        echo $form->hiddenField($model, 'klsRawatNaik');
        echo $form->dropDownListRow($model,'penanggungjwb_naikkls_id', CHtml::listData(PenjaminpasienM::model()->findAllByAttributes(array(
            'is_penanggungjwbnaikklsbpjs'=>true,
        ), array(
            'order'=>'penjamin_nama'
        )), 'penjamin_id', 'penjamin_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

        <div class="control-group clsrujukan">
            <?php echo CHtml::label("Kode PPK Rujukan <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'ppkrujukan',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteItemSEP') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                item: "ppk",
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.kode);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $(this).val(ui.item.kode);
                            $("#' . CHtml::activeId($model, 'ppkrujukan_nama') . '").val(ui.item.nama);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Kode PPK', 'rel' => 'tooltip', 'title' => 'Ketik kode ppk untuk mencari data ppk', 'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group clsrujukan">
            <?php echo CHtml::label("Nama PPK Rujukan <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'ppkrujukan_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteItemSEP') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                item: "ppk",
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.nama);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $(this).val(ui.item.nama);
                            $("#' . CHtml::activeId($model, 'ppkrujukan') . '").val(ui.item.kode);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Nama PPK', 'rel' => 'tooltip', 'title' => 'Ketik nama ppk untuk mencari data ppk', 'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="span6">

        <div class="control-group">
            <?php echo CHtml::label("Poli Tujuan <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'politujuan',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteItemSEP') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                item: "poli",
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.kode);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $(this).val(ui.item.kode);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Kode Poli', 'rel' => 'tooltip', 'title' => 'Ketik poli untuk mencari data poli', 'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Diagnosa Awal <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'diagnosaawal',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteItemSEP') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                item: "diagnosa",
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.kode);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $(this).val(ui.item.kode);
                            $("#' . CHtml::activeId($model, 'nama_diagnosaawal') . '").val(ui.item.nama);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
                <?php echo $form->hiddenField($model, 'nama_diagnosaawal', array('placeholder' => 'Diagnosa Awal', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'jenis_kunjungan', array('class'=>'control-label', 'label'=>'Jenis Kunjungan <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenis_kunjungan', LookupM::getItemsUrutan('bpjs_jnskunjungan'), array(
                    'class'=>'span3', 'onchange'=>'pilihJenisKunjunganBPJS();'
                )); ?>
                <?php echo $form->dropDownListRow($model, 'flag_procedure', LookupM::getItemsUrutan('bpjs_flagprocedure'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
                <?php echo $form->dropDownListRow($model, 'kode_penunjang', LookupM::getItemsUrutan('bpjs_kdpenunjang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'asesmen_pelayanan', array('class'=>'control-label', 'label'=>'Asesmen Pelayanan')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'asesmen_pelayanan', LookupM::getItemsUrutan('bpjs_asesmenpelayanan'), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
            </div>
        </div>

        <div class="rujukan" id="skdp" hidden>
            <div class="control-group">
                <?php echo CHtml::label("<span id='lablenosuratkontrol'>Nomor Surat Kontrol</span>", 'Nomor Surat Kontrol', array('class'=>'control-label'))?>
                <div class="controls">
                        <?php echo $form->textField($model,'no_surat',array('placeholder'=>'Nomor Surat Kontrol','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30, 'rel'=>'tooltip', 'title'=>'Isi jika pasien dengan surat kontrol')); ?>
                        <?php echo CHtml::link("<i class='icon-search'></i>",'javascript:void(0)',array("rel"=>"tooltip","title"=>"klik untuk car Surat Kontrol Pasien","onclick"=>"cariSuratKontrol(); return true;"));?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("<span id='lablendpjpsuratkontrol'>DPJP Pemberi Surat Kontrol<span>", 'nama_dpjp', array('class'=>'control-label'))?>
                <div class="controls">
                    <?php echo $form->textField($model,'nama_dpjp',array('placeholder'=>'DPJP Pemberi Surat Kontrol','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'rel'=>'tooltip', 'title'=>'Isi jika pasien dengan surat kontrol','onblur'=>"if($(this).val()=='') $('#".CHtml::activeId($model, 'kode_dpjp')."').val('')")); ?>
                    <?php echo CHtml::link("<i class='icon-search'></i>",'javascript:void(0)',array("rel"=>"tooltip","title"=>"klik untuk cari DPJP","onclick"=>"$('#dialogDpjp').dialog('open');return true;"));?>
                    <?php echo $form->hiddenField($model,'kode_dpjp',array('placeholder'=>'Dokter DPJP','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
        <div class="control-group">
                <?php 
                    echo CHtml::label('DPJP yang Melayani <span class="required">*</span>', 'nama_dpjp', array('class'=>'control-label'));
                ?>
                <div class="controls">
                    <?php echo $form->textField($model,'dpjpygmelayani_nama',array('placeholder'=>'Dokter DPJP','class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'rel'=>'tooltip', 'title'=>'Isi jika pasien dengan surat kontrol','onblur'=>"if($(this).val()=='') $('#".CHtml::activeId($model, 'kode_dpjp')."').val('')")); ?>
                    <?php echo CHtml::link("<i class='icon-search'></i>",'javascript:void(0)',array("rel"=>"tooltip","title"=>"klik untuk cari DPJP","onclick"=>"$('#dialogDpjpMelayani').dialog('open');return true;"));?>
                    <?php echo $form->hiddenField($model,'dpjpygmelayani_kode',array('placeholder'=>'Dokter DPJP','class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
        </div>
        <div class="control-group form-inline">
            <?php echo CHtml::label("Poli Eksekutif", 'Eksekutif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->radioButtonList($model, 'is_polieksekutif', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group form-inline">
            <?php echo CHtml::label("COB", 'COB', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'is_cob', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                echo $form->textField($model, 'status_nosep', array('class' => 'span1', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group form-inline">
            <?php echo CHtml::label("Katarak", 'Katarak', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->radioButtonList($model, 'katarak', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status Kecelakaan <span class="required">*</span>', '', array('class'=>'control-label'))?>
            <div class="controls">
                <?php 
                $model->statuskecelakaan_kode = $model->statuskecelakaan_kode == 0 ? "0" : $model->statuskecelakaan_kode;
                echo $form->dropDownList($model,'statuskecelakaan_kode',LookupM::getItemsUrutan('bpjs_statuskecelakaan'), array('class'=>'span3','onchange'=>'setChangeStatusKecelakaan()')); ?>
            </div>
        </div>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'form-suplesi',
            'content' => array(
                'content-suplesi' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => 'cekSuplesi(this)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Kecelakaan Lalu Lintas')) . '<b><span class="judulasuransi">Kecelakaan Lalu Lintas',
                    'isi' => $this->renderPartial($this->path_view . '_formSuplesi', array(
                        'form' => $form,
                        'model' => $model,
                    ), true),
                    'active' => false,
                ),
            ),
            'htmlOptions' => array(),
        ));
        ?>

        <div class="control-group">
            <?php echo CHtml::label("No. Telepon Peserta <span class='required'>*</span>", 'no_telpon_peserta', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_telpon_peserta', array('placeholder' => 'Telepon peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("User Pembuat SEP", 'pembuat_sep', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pembuat_sep', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'catatansep', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogSuratKontrol',
    'options'=>array(
        'title'=>'Surat Kontrol',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>400,
        'resizable'=>false,
    ),
)); ?>
<table width="100%" id="tab_sc">
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td id="sc_nama_pasien"></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td id="sc_jeniskelamin"></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td id="sc_tanggal_lahir"></td>
    </tr>
    <tr>
        <td>No. Surat</td>
        <td>:</td>
        <td id="sc_nosurat"></td>
    </tr>
    <tr>
        <td>Tanggal Entri</td>
        <td>:</td>
        <td id="sc_tanggal_entri"></td>
    </tr>
    <tr>
        <td>Tanggal Rencana Kontrol</td>
        <td>:</td>
        <td id="sc_tanggal_rencana"></td>
    </tr>
    <tr>
        <td>Poliklinik Tujuan</td>
        <td>:</td>
        <td id="sc_poli_tujuan"></td>
    </tr>
    <tr>
        <td>Dokter Tujuan Kontrol</td>
        <td>:</td>
        <td id="sc_dokter_kontrol"></td>
    </tr>
    <tr>
        <td>No SEP</td>
        <td>:</td>
        <td id="sc_no_sep"></td>
    </tr>
    <tr>
        <td>Tanggal SEP</td>
        <td>:</td>
        <td id="sc_tgl_sep"></td>
    </tr>
    <tr>
        <td style="color: red; font-weight: bold; text-align: center;" id="sc_status" colspan="3"></td>
    </tr>
    <tr>
        <td style="text-align: center" colspan="3">
            <?php echo CHtml::htmlButton('OK', array('class'=>'btn btn-success', 'onclick'=>'setSuratKontrol();')); ?>
        </td>
    </tr>
</table>
<?php
$this->endWidget();

?>

<script>

    function pilihJenisKunjunganBPJS() {
        var jenis = $("#<?php echo CHtml::activeId($model, 'jenis_kunjungan') ?>").val();

        if (jenis == "0") {
            $("#<?php echo CHtml::activeId($model, 'flag_procedure') ?>").val(null).prop("readonly", true).prop("disabled", true);
            $("#<?php echo CHtml::activeId($model, 'kode_penunjang') ?>").val(null).prop("readonly", true).prop("disabled", true);
        } else {
            $("#<?php echo CHtml::activeId($model, 'flag_procedure') ?>").prop("readonly", false).prop("disabled", false);
            $("#<?php echo CHtml::activeId($model, 'kode_penunjang') ?>").prop("readonly", false).prop("disabled", false);
        }

        if (jenis == "2") {
            $("#<?php echo CHtml::activeId($model, 'asesmen_pelayanan') ?>").val(4);
        }
    }

    $(document).ready(function() {
        pilihJenisKunjunganBPJS();
    });

</script>