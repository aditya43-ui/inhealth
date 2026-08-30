<div class="row-fluid bpjs-igd">
    <div class="span6">
        <?php echo $form->hiddenField($modAsuransiPasienBpjs, 'nokartuasuransi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->hiddenField($modAsuransiPasien, 'nopeserta', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo $form->hiddenField($modAsuransiPasienBpjs, 'tglcetakkartuasuransi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->hiddenField($modAsuransiPasien, 'kelastanggunganasuransi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->hiddenField($modAsuransiPasien,'jenispeserta_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo $form->hiddenField($modSep, 'namaasuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modSep, 'no_asuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modSep, 'hakkelas_kode', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group">
            <?php echo CHtml::label("No. Kartu BPJS <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSep, 'nopeserta', array('placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk mengecek peserta", "onclick" => "getAsuransiNoKartuIGD($('#" . CHtml::activeId($modSep, "nopeserta") . "').val());return true;")); ?>
                <?php echo $form->error($modSep, 'nopeserta'); ?>
                <?php echo $form->hiddenField($modSep, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </div>
        </div>

        <div class="control-group ">
            <label class="control-label">
                No. SEP
            </label>
            <div class="controls">
                <?php echo $form->textField($modSep, 'nosep', array('placeholder' => 'No. SEP Otomatis', 'class' => 'span3', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->error($modSep, 'nosep'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modSep, 'tglsep', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                if (!empty($modPengajuanApproval) && !empty($modPengajuanApproval->tgl_sep)) {
                    $modSep->tglsep = (!empty($modPengajuanApproval->tgl_sep) ? MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime((string)MyFormatter::formatDateTimeForDb($modPengajuanApproval->tgl_sep)))) : null);
                    echo $form->textField($modSep, 'tglsep', array('class' => 'span3', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);"));
                } else {
                    $modSep->tglsep = date('Y-m-d');
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modSep,
                        'attribute' => 'tglsep',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'placeholder' => '00/00/0000', 'class' => 'dtPicker2 span3 datetime tglsep', 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                }
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modAsuransiPasienBpjs, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3 namapemilikasuransiIGD', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group ">
            <?php echo $form->labelEx($modAsuransiPasienBpjs, 'jenispeserta_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modAsuransiPasienBpjs, 'jenispersertakode_bpjs'); ?>
                <?php echo $form->textField($modAsuransiPasienBpjs, 'jenispeserta_bpjs', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Kode PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSep, 'ppkpelayanan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Nama PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSep, 'ppkpelayanan_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id', CHtml::listData(ARPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama'), array('disabled' => false, 'empty' => '-- Pilih --', 'class' => 'span3 kelastanggunganasuransi_idIGD', 'onkeyup' => "return $(this).focusNextInputField(event)",));  ?>
        <?php echo $form->hiddenField($modSep, 'klsRawatNaik'); ?>

        <div class="control-group">
            <label class="control-label">Prolanis PRB</label>
            <div class="controls">
                <?php echo CHtml::textField("bpjs_prolanis", "-", array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Dinsos</label>
            <div class="controls">
                <?php echo CHtml::textField("bpjs_dinsos", "-", array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>

        <?php echo $form->dropDownListRow($modSep, 'jnspelayanan',  LookupM::getItems('jenispelayanan'), array('empty' => '--Pilih--', 'class' => 'span3')); ?>
        <div class="control-group ">
            <?php echo CHtml::label("Kelas Rawat <span class='required'>*</span>", 'kelastanggungan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modSep, 'klsrawat', CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true and kelasbpjs_id is not null order by urutankelas ASC'), 'kelasbpjs_id', 'kelaspelayanan_nama'), array(
                    'empty' => '-Pilih-', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                )); ?>
            </div>
        </div>
        <?php
        echo $form->hiddenField($modSep, 'klsRawatNaik');
        echo $form->dropDownListRow($modSep, 'penanggungjwb_naikkls_id', CHtml::listData(PenjaminpasienM::model()->findAllByAttributes(array(
            'is_penanggungjwbnaikklsbpjs' => true,
        ), array(
            'order' => 'penjamin_nama'
        )), 'penjamin_id', 'penjamin_nama'), array('disabled' => true, 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

        <div class="control-group clsrujukan hidden">
            <?php echo CHtml::label("Kode PPK Rujukan", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modSep,
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
                            $("#' . CHtml::activeId($modSep, 'ppkrujukan_nama') . '").val(ui.item.nama);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Kode PPK', 'rel' => 'tooltip', 'title' => 'Ketik kode ppk untuk mencari data ppk', 'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group clsrujukan hidden">
            <?php echo CHtml::label("Nama PPK Rujukan", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modSep,
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
                            $("#' . CHtml::activeId($modSep, 'ppkrujukan') . '").val(ui.item.kode);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Nama PPK', 'rel' => 'tooltip', 'title' => 'Ketik nama ppk untuk mencari data ppk', 'class' => 'span3',
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
                    'model' => $modSep,
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
                    'model' => $modSep,
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
                            $("#' . CHtml::activeId($modSep, 'nama_diagnosaawal') . '").val(ui.item.nama);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
                <?php echo $form->hiddenField($modSep, 'nama_diagnosaawal', array('placeholder' => 'Diagnosa Awal', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modSep, 'jenis_kunjungan', array('class' => 'control-label', 'label' => 'Jenis Kunjungan <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modSep, 'jenis_kunjungan', LookupM::getItemsUrutan('bpjs_jnskunjungan'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onchange' => 'pilihJenisKunjunganBPJS();'
                )); ?>
                <?php echo $form->dropDownListRow($modSep, 'flag_procedure', LookupM::getItemsUrutan('bpjs_flagprocedure'), array('empty' => '-- Pilih --', 'class' => 'span2')); ?>
                <?php echo $form->dropDownListRow($modSep, 'kode_penunjang', LookupM::getItemsUrutan('bpjs_kdpenunjang'), array('empty' => '-- Pilih --', 'class' => 'span2')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modSep, 'asesmen_pelayanan', array('class' => 'control-label', 'label' => 'Asesmen Pelayanan')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modSep, 'asesmen_pelayanan', LookupM::getItemsUrutan('bpjs_asesmenpelayanan'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>


        <div class="control-group">
            <?php
            echo CHtml::label('DPJP yang Melayani <span class="required">*</span>', 'nama_dpjp', array('class' => 'control-label'));
            ?>
            <div class="controls">
                <?php echo $form->textField($modSep, 'dpjpygmelayani_nama', array('placeholder' => 'Dokter DPJP', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol', 'onblur' => "if($(this).val()=='') $('#" . CHtml::activeId($modSep, 'kode_dpjp') . "').val('')")); ?>
                <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk cari DPJP", "onclick" => "$('#dialogDpjpMelayaniIGD').dialog('open');return true;")); ?>
                <?php echo $form->hiddenField($modSep, 'dpjpygmelayani_kode', array('placeholder' => 'Dokter DPJP', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group form-inline">
            <?php echo CHtml::label("Poli Eksekutif", 'Eksekutif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->radioButtonList($modSep, 'is_polieksekutif', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group form-inline">
            <?php echo CHtml::label("COB", 'COB', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($modSep, 'is_cob', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                echo $form->textField($modSep, 'status_nosep', array('class' => 'span1', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group form-inline">
            <?php echo CHtml::label("Katarak", 'Katarak', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->radioButtonList($modSep, 'katarak', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status Kecelakaan <span class="required">*</span>', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modSep, 'statuskecelakaan_kode', LookupM::getItemsUrutan('bpjs_statuskecelakaan'), array('class' => 'span3', 'onchange' => 'setChangeStatusKecelakaan()')); ?>
            </div>
        </div>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'form-suplesi',
            'content' => array(
                'content-suplesi' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => 'cekSuplesi(this)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Kecelakaan Lalu Lintas')) . '<b><span class="judulasuransi">Kecelakaan Lalu Lintas',
                    'isi' => $this->renderPartial('_formSuplesi', array(
                        'form' => $form,
                        'model' => $modSep,
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
                <?php echo $form->textField($modSep, 'no_telpon_peserta', array('placeholder' => 'Telepon peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("User Pembuat SEP", 'pembuat_sep', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSep, 'pembuat_sep', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($modSep, 'catatansep', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogSuratKontrol',
    'options' => array(
        'title' => 'Surat Kontrol',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 400,
        'resizable' => false,
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
            <?php echo CHtml::htmlButton('OK', array('class' => 'btn btn-success', 'onclick' => 'setSuratKontrol();')); ?>
        </td>
    </tr>
</table>
<?php
$this->endWidget();

?>

<div class="bpjs-manual hidden">
    <?php
    $read_only = '';
    if (isset($readdata)) {
        $read_only = " readonly = true  ";
    }
    ?>
    <div class="control-group">

        <?php $controller = Yii::app()->controller->id;

        $classNoPst = $controller !== 'pendaftaranRawatDarurat' ? 'control-label required jks_spec' : 'control-label jks_spec';
        $req = $controller !== 'pendaftaranRawatDarurat' ? " <span class='required jks_spec'>*</span>" : "";

        ?>
        <?php echo CHtml::label($modAsuransiPasien->getAttributeLabel('nopeserta') . $req, 'nopeserta', array('class' => $classNoPst)) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modAsuransiPasien,
                'attribute' => 'nopeserta',
                'source' => 'js: function(request, response) {
                                                    var penjamin_id = $("#' . CHtml::activeId($model, 'penjamin_id') . '").val();
                                                    var pasien_id = $("#' . CHtml::activeId($modPasien, 'pasien_id') . '").val();
                                                $.ajax({
                                                    url: "' . $this->createUrl('AutocompleteAsuransi') . '",
                                                    dataType: "json",
                                                    data: {
                                                        nopeserta: request.term,
                                                        penjamin_id: penjamin_id,
                                                        pasien_id: pasien_id,
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
                                                $(this).val(ui.item.value);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') . '").val(ui.item.asuransipasien_id);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'nopeserta') . '").val(ui.item.nokartuasuransi);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') . '").val(ui.item.nokartuasuransi);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') . '").val(ui.item.namapemilikasuransi);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'jenispeserta_id') . '").val(ui.item.jenispeserta_id);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') . '").val(ui.item.nomorpokokperusahaan);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'namaperusahaan') . '").val(ui.item.namaperusahaan);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') . '").val(ui.item.kelastanggunganasuransi_id);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'nominal_tanggungan') . '").val(formatNumber(ui.item.nominal_tanggungan));
                                                setAsuransiLama();
                                                return false;
                                            }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'No. Peserta', 'rel' => 'tooltip', 'title' => 'No. Peserta',
                    'onkeyup' => "setNoKartuAsuransi(); return $(this).focusNextInputField(event)",
                    'maxlength' => 13,
                    //                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                    'class' => 'span3 angkahuruf-only all-caps nopeserta'
                ),
            ));
            ?>
            <?php echo $form->error($modAsuransiPasien, 'nopeserta'); ?>

        </div>
    </div>
    <?php echo $form->hiddenField($modAsuransiPasien, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3 asuransipasien_id', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
    <div class="control-group">
        <?php echo CHtml::label($modAsuransiPasien->getAttributeLabel('nokartuasuransi') . $req, 'nokartuasuransi', array('class' => $classNoPst)) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modAsuransiPasien,
                'attribute' => 'nokartuasuransi',
                'source' => 'js: function(request, response) {
                                                    var penjamin_id = $("#' . CHtml::activeId($model, 'penjamin_id') . '").val();
                                                    var pasien_id = $("#' . CHtml::activeId($modPasien, 'pasien_id') . '").val();
                                                $.ajax({
                                                    url: "' . $this->createUrl('AutocompleteAsuransiKartu') . '",
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
                'options' => array(
                    'minLength' => 1,
                    'focus' => 'js:function( event, ui ) {
                                                $(this).val( "");
                                                return false;
                                            }',
                    'select' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') . '").val(ui.item.asuransipasien_id);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'nopeserta') . '").val(ui.item.nokartuasuransi);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') . '").val(ui.item.nokartuasuransi);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') . '").val(ui.item.namapemilikasuransi);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'jenispeserta_id') . '").val(ui.item.jenispeserta_id);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') . '").val(ui.item.nomorpokokperusahaan);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'namaperusahaan') . '").val(ui.item.namaperusahaan);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') . '").val(ui.item.kelastanggunganasuransi_id);
                                                $("#' . CHtml::activeId($modAsuransiPasien, 'nominal_tanggungan') . '").val(formatNumber(ui.item.nominal_tanggungan));
                                                setAsuransiLama();
                                                return false;
                                            }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogAsuransi', 'jsFunction' => 'cekAsuransi()'),
                'htmlOptions' => array(
                    'placeholder' => 'No. Kartu Asuransi', 'rel' => 'tooltip', 'title' => 'No. Peserta',
                    'onkeyup' => "; return $(this).focusNextInputField(event)",
                    'maxlength' => 13,
                    //                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                    'class' => 'span3 angkahuruf-only all-caps nokartuasuransi'
                ),
            ));
            ?>
            <?php echo $form->error($modAsuransiPasien, 'nokartuasuransi'); ?>
        </div>
    </div>
    <?php //echo $form->textFieldRow($modAsuransiPasien,'nokartuasuransi',array('placeholder'=>'Nomor Kartu Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
    ?>
    <?php //echo $form->textFieldRow($modAsuransiPasien,'namapemilikasuransi',array('placeholder'=>'Nama Lengkap Pemilik Asuransi','class'=>'span3 all-caps', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
    ?>
    <div class="control-group">
        <?php echo CHtml::label($modAsuransiPasien->getAttributeLabel('namapemilikasuransi') . $req, 'namapemilikasuransi', array('class' => $classNoPst)) ?>
        <div class="controls">
            <?php echo $form->textField($modAsuransiPasien, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3 all-caps namapemilikasuransi', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($modAsuransiPasien, 'nomorpokokperusahaan', array('placeholder' => 'Nomor Pokok Perusahaan', 'class' => 'span3 nomorpokokperusahaan', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <div class="control-group">
        <label class="control-label">
            <?php echo $form->labelEx($modAsuransiPasien, 'kelastanggunganasuransi_id', array('class' => 'control-label')) ?>
            <?php if (strtolower($this->id) != "pendaftaranrawatdarurat") : ?>
                <span class="required">*</span>
            <?php endif; ?>
        </label>
        <div class="controls">
            <?php
            if (isset($statusMenu)) {
                echo $form->dropDownList($modAsuransiPasien, 'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('disabled' => true, 'empty' => '-- Pilih --', 'class' => 'span3 kelastanggunganasuransi_id required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekPerbedaanKelas(this);'));
            } else {
                echo $form->dropDownList($modAsuransiPasien, 'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('disabled' => true, 'empty' => '-- Pilih --', 'class' => 'span3 kelastanggunganasuransi_id required', 'onkeyup' => "return $(this).focusNextInputField(event)"));
            }
            ?>
        </div>
        <div class="controls cekKelas" <?php (!isset($admisi) ? Params::HIDDEN_HARGA : null) ?>>
            <?php // echo CHtml::checkBox('is_kelas', false, array('rel' => 'tooltip', 'title' => 'Klik untuk naik kelas', 'onclick'=>'hakKelas(this)')); 
            ?>
            <!--label>Naik Kelas</label-->
        </div>
    </div>

    <?php echo $form->textFieldRow($modAsuransiPasien, 'nominal_tanggungan', array('placeholder' => 'Nominal Tanggungan Asuransi', 'class' => 'span3 integer nominal_tanggungan', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
    <?php echo $form->textFieldRow($modAsuransiPasien, 'namaperusahaan', array('placeholder' => 'Nama Perusahaan Asuransi', 'class' => 'span3 all-caps namaperusahaan', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <div class="control-group">
        <label class="control-label">Status Konfirmasi</label>
        <div class="controls">

            <?php
            echo CHtml::activeRadioButton($modAsuransiPasien, 'status_konfirmasi', array(
                'value' => 1,
                'uncheckValue' => null,
                'id' => 'konfirmasi_sudah',
                'onchange' => '$("#PPAsuransipasienM_tgl_konfirmasi").prop("disabled", false);',
                // 'onchange'=>'switchOtomatis(this)',
                'class' => 'rb_kon',
                'checked' => 'checked',
            )) . "Sudah ";
            echo CHtml::activeRadioButton($modAsuransiPasien, 'status_konfirmasi', array(
                'value' => 0,
                'uncheckValue' => null,
                'onchange' => '$("#PPAsuransipasienM_tgl_konfirmasi").prop("disabled", true);',
                'class' => 'rb_kon',
                'id' => 'konfirmasi_sudah',
                'checked' => false,
            )) . "Belum ";
            ?>
            <?php //echo $form->checkBox($modAsuransiPasien,'status_konfirmasi', array('onkeypress'=>"return $(this).focusNextInputField(event)",'checked'=>false)); 
            ?>
            <?php echo $form->error($modAsuransiPasien, 'tgl_konfirmasi'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modAsuransiPasien, 'tgl_konfirmasi', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $modAsuransiPasien->tgl_konfirmasi = (!empty($modAsuransiPasien->tgl_konfirmasi) ? date("d/m/Y H:i:s", strtotime($modAsuransiPasien->tgl_konfirmasi)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $modAsuransiPasien,
                'attribute' => 'tgl_konfirmasi2',
                'mode' => 'datetime',
                'options' => array(
                    //                                    'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('class' => 'span3 dtPicker3 tgl_konfirmasi', 'onkeyup' => "return $(this).focusNextInputField(event)",),
            )); ?>
            <?php echo $form->error($modAsuransiPasien, 'tgl_konfirmasi2'); ?>
        </div>
    </div>
</div>

<script>
    function pilihJenisKunjunganBPJS() {
        var jenis = $("#<?php echo CHtml::activeId($modSep, 'jenis_kunjungan') ?>").val();

        if (jenis == "0") {
            $("#<?php echo CHtml::activeId($modSep, 'flag_procedure') ?>").val(null).prop("readonly", true).prop("disabled", true);
            $("#<?php echo CHtml::activeId($modSep, 'kode_penunjang') ?>").val(null).prop("readonly", true).prop("disabled", true);
        } else {
            $("#<?php echo CHtml::activeId($modSep, 'flag_procedure') ?>").prop("readonly", false).prop("disabled", false);
            $("#<?php echo CHtml::activeId($modSep, 'kode_penunjang') ?>").prop("readonly", false).prop("disabled", false);
        }

        if (jenis == "0") {
            $("#PPSepT_asesmen_pelayanan").val("");
        }

        if (jenis == "2") {
            $("#PPSepT_asesmen_pelayanan").val(5);
        }
    }

    function setChangeStatusKecelakaan() {
        if ($('#<?php echo CHtml::activeId($modSep, 'statuskecelakaan_kode') ?>').val() != '' && ($('#<?php echo CHtml::activeId($modSep, 'statuskecelakaan_kode') ?>').val() == 1 || $('#<?php echo CHtml::activeId($modSep, 'statuskecelakaan_kode') ?>').val() == 2 || $('#<?php echo CHtml::activeId($modSep, 'statuskecelakaan_kode') ?>').val() == 3)) {
            tampilKecelakaan();
            cekSuplesi($('input:radio[name="PPSepT[suplesi_jasaraharja]"]:checked'));
            setPropinsi();
            $("#<?php echo CHtml::activeId($modSep, 'is_lakalantas') ?>").val(1);

            $('.frminput_suplesi').show();
            $('.frminput_lppolisi').show();

            // if($('#<?php //echo CHtml::activeId($modSep,'statuskecelakaan_kode') 
                        ?>').val() == 3){
            //     $('#<?php //echo CHtml::activeId($modSep,'no_suplesi') 
                        ?>').val('');
            //     setRadioButton($(".suplesi_jasaraharja"), 0);
            //     $('.frminput_suplesi').hide();
            //     $('.frminput_lppolisi').show();
            // }else{
            //     $('.frminput_suplesi').show();
            //     $('.frminput_lppolisi').hide();
            // }
        } else if ($('#<?php echo CHtml::activeId($modSep, 'statuskecelakaan_kode') ?>').val() == 0) {
            sembunyiKecelakaan();
            $("#<?php echo CHtml::activeId($modSep, 'is_lakalantas') ?>").val(0);
        } else {
            sembunyiKecelakaan();
            $("#<?php echo CHtml::activeId($modSep, 'is_lakalantas') ?>").val(0);
        }
    }

    function tampilKecelakaan() {
        $('#form-suplesi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-suplesi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-suplesi').removeClass().addClass("accordion-body in collapse");
        $('#content-suplesi').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-suplesi').removeAttr("style").attr("style", "height:auto");
        $('#content-suplesi').find("input,select,textarea").removeAttr("disabled");
        $('#content-suplesi').find(".nosep").attr("readonly", true);
    }

    function sembunyiKecelakaan() {
        $('#content-suplesi').find(".required").addClass("not-required").removeClass("required");
        $('#form-suplesi > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-suplesi > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-suplesi').removeClass().addClass("accordion-body collapse");
        $('#content-suplesi').removeAttr("style").attr("style", "height:0px");
        $('#content-suplesi').find("input,select,textarea").attr("disabled", true);
    }

    function cekSuplesi(obj) {
        if ($(obj).val() == 1) {
            $("#PPSepT_no_suplesi").addClass("required");
            $("#PPSepT_no_suplesi").attr('disabled', false);
            $('.cari_suplesi').show();
        } else {
            $("#PPSepT_no_suplesi").attr('disabled', 'disabled');
            $("#PPSepT_no_suplesi").removeClass("required");
            $("#PPSepT_no_suplesi").removeClass("error");
            $("#PPSepT_no_suplesi").parents(".control-group").removeClass("error");
            $('.cari_suplesi').hide();
        }
    }

    function setPropinsi() {
        var setting = {
            url: "<?php echo $this->createUrl('propinsi/bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=1',
            beforeSend: function() {},
            success: function(data) {
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                }
                var list = obj.response.list;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('SetDropdownPropinsi'); ?>',
                    data: {
                        propinsiList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_id') ?>").empty();
                        $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_id') ?>").append(data.form);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function(data) {}
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function setKabupaten(obj) {
        var katakunci = $(obj).val();

        var propinsi = $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_id') ?> option:selected").text();
        $("#<?php echo CHtml::activeId($model, 'propinsi_lakalantas_nama') ?>").val(propinsi);

        isi = "";
        if (katakunci != '') {
            var isi = katakunci;
            var aksi = 1; // 1 untuk mencari data fasilitas kesehatan
        }

        if (isi == "") {
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('kabupaten/bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {},
            success: function(data) {
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                }
                var list = obj.response.list;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('SetDropdownKabupaten'); ?>',
                    data: {
                        propinsiList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_id') ?>").empty();
                        $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_id') ?>").append(data.form);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function(data) {
                myAlert('Terjadi kesalahan saat briging');
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function setKecamatan(obj) {
        var katakunci = $(obj).val();

        var kabupaten = $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_id') ?> option:selected").text();
        $("#<?php echo CHtml::activeId($model, 'kabupaten_lakalantas_nama') ?>").val(kabupaten);

        isi = "";
        if (katakunci != '') {
            var isi = katakunci;
            var aksi = 1; // 1 untuk mencari data fasilitas kesehatan
        }

        if (isi == "") {
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('kecamatan/bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {},
            success: function(data) {
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                }
                var list = obj.response.list;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('SetDropdownKecamatan'); ?>',
                    data: {
                        kabupatenList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_id') ?>").empty();
                        $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_id') ?>").append(data.form);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function(data) {
                myAlert('Terjadi kesalahan saat briging');
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function setKecamatanValue(obj) {
        var kecamatan = $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_id') ?> option:selected").text();
        $("#<?php echo CHtml::activeId($model, 'kecamatan_lakalantas_nama') ?>").val(kecamatan);
    }

    $(document).ready(function() {
        pilihJenisKunjunganBPJS();
        sembunyiKecelakaan();
    });
</script>