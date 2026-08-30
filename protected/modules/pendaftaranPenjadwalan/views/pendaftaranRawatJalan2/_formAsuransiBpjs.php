<?php
$disabled = true;
if ($pelayanan == 'RJ') {
    $required = '';
    $value = '';
} else {
    $required = '';
    $value = '-';
}

?>
<div class="control-group" style="display: <?php echo ($pelayanan == 'RJ' || $pelayanan == 'RI') ? 'block' : 'none' ?>">
    <div class="control-label"><?php echo Chtml::label('Jenis Rujukan', 'jenis_rujukan', array('class' => 'control-label')); ?></div>
    <div class="controls form-inline">
        <?php
        echo $form->radioButtonList($modSep, 'jenisfaskes', array("1" => "PCare&nbsp;&nbsp;", "2" => "Rumah Sakit"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
        ?>
    </div>
</div>
<div class="control-group" style="display: <?php echo ($pelayanan == 'RJ' || $pelayanan == 'RI') ? 'block' : 'none' ?>">
    <?php echo CHtml::label("Cari " . $modRujukanBpjs->getAttributeLabel('no_rujukan') . " <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modRujukanBpjs,
            'attribute' => 'no_rujukan',
            'options' => array(
                'focus' => 'js:function( event, ui ) {
                    $(this).val("");
                    return false;
                }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'Nomor Rujukan', 'class' => ($pelayanan == 'RJ' || $pelayanan == 'RI') ? 'span3 required' : 'span3',
                'onkeyup' => "return $(this).focusNextInputField(event)",
                'onblur' => "",
            ),
            'tombolDialog' => array('idDialog' => 'no_rujukan', 'jsFunction' => "getRujukanNoRujukan($('#" . CHtml::activeId($modRujukanBpjs, "no_rujukan") . "').val());"),
        ));
        ?>
        <?php echo $form->error($modRujukanBpjs, 'no_rujukan'); ?>
    </div>
</div>
<div class="control-group" style="display: <?php echo ($pelayanan == 'RJ' || $pelayanan == 'RI') ? 'block' : 'none' ?>">
    <label class="control-label" for="PPRujukanbpjsT_tanggal_rujukan">
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
                'showOn' => false,
                'maxDate' => 'd',
                'dateFormat' => Params::DATE_FORMAT,
            ),
            'htmlOptions' => array('class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
        ));
        ?>
        <?php echo $form->error($modRujukanBpjs, 'tanggal_rujukan'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("Cari " . $modAsuransiPasien->getAttributeLabel('nopeserta') . " <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        echo $form->textField($modAsuransiPasien, 'nopeserta', array('placeholder' => 'No. Peserta', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
        ?>
        <?php echo CHtml::link("<i class='entypo-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk mengecek peserta", "onclick" => "getAsuransiNoKartu($('#" . CHtml::activeId($modAsuransiPasien, "nopeserta") . "').val());return true;")); ?>
        <?php echo $form->error($modAsuransiPasien, 'nopeserta'); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("Cari " . $modAsuransiPasien->getAttributeLabel('nokartuasuransi') . " <span class='required'>*</span>", 'nokartuasuransi', array('class' => 'control-label required')) ?>
    <div class="controls">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modAsuransiPasien,
            'attribute' => 'nokartuasuransi',
            'source' => 'js: function(request, response) {
                                                var penjamin_id = $("#' . CHtml::activeId($model, 'penjamin_id') . '").val();
                                                var pasien_id = $("#' . CHtml::activeId($modPasien, 'pasien_id') . '").val();
                                               $.ajax({
                                                   url: "' . Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/AutocompleteAsuransiKartu') . '",
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
                'minLength' => 3,
                'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') . '").val(ui.item.asuransipasien_id);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'nopeserta') . '").val(ui.item.nopeserta);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') . '").val(ui.item.nokartuasuransi);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') . '").val(ui.item.namapemilikasuransi);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'jenispeserta_id') . '").val(ui.item.jenispeserta_id);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') . '").val(ui.item.nomorpokokperusahaan);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'namaperusahaan') . '").val(ui.item.namaperusahaan);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') . '").val(ui.item.kelastanggunganasuransi_id);
//                                            getAsuransiNoKartu(ui.item.nokartuasuransi);
                                            setAsuransiLama();
                                            return false;
                                        }',
            ),
            'tombolDialog' => array('idDialog' => 'dialogAsuransiBpjs', 'jsFunction' => 'cekAsuransiBpjs()'),
            'htmlOptions' => array(
                'placeholder' => 'No. Kartu Asuransi BPJS', 'rel' => 'tooltip', 'title' => 'No. Peserta',
                'onkeyup' => "; return $(this).focusNextInputField(event)",
                //                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                'class' => 'numbers-only span3', 'maxlength' => 13
            ),
        ));
        ?>
        <?php echo $form->error($modAsuransiPasien, 'nokartuasuransi'); ?>
    </div>
</div>
<?php //echo $form->textFieldRow($modAsuransiPasien,'nokartuasuransi',array('placeholder'=>'Nomor Kartu Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
?>
<?php echo $form->textFieldRow($modAsuransiPasien, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="control-group">
    <div class="control-label"><?php echo Chtml::label('Jenis Peserta', 'jenispeserta_nama', array('class' => 'control-label')); ?></div>
    <div class="controls">
        <?php
        echo $form->textField($modAsuransiPasien, 'jenispeserta_nama', array('placeholder' => 'Jenis Peserta', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
        echo $form->hiddenField($modAsuransiPasien, 'jenispeserta_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
        ?>
    </div>
</div>
<div class="control-group">
    <div class="control-label"><?php echo Chtml::label('Kelas Tanggungan Asuransi', 'kelastanggunganasuransi_nama', array('class' => 'control-label')); ?></div>
    <div class="controls">
        <?php
        echo $form->textField($modAsuransiPasien, 'kelastanggunganasuransi_nama', array('placeholder' => 'Kelas Tanggungan Asuransi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
        echo $form->hiddenField($modAsuransiPasien, 'kelastanggunganasuransi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modRujukanBpjs, 'asalrujukan_id', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList(
            $modRujukanBpjs,
            'asalrujukan_id',
            CHtml::listData($modRujukanBpjs->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'),
            array(
                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    //                                                          'url'=>$this->createUrl('GetRujukanDari',array('encode'=>false,'namaModel'=>'PPRujukanbpjsT')),
                    'url' => Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/GetRujukanDari', array('encode' => false, 'namaModel' => 'PPRujukanbpjsT')),
                    'update' => '#' . CHtml::activeId($modRujukanBpjs, 'rujukandari_id'),
                ),
                'onchange' => "clearRujukanBpjs();",
            )
        ); ?>
        <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                        array('class'=>'btn btn-primary','onclick'=>"{addAsalRujukan(); $('#dialogAddAsalRujukan').dialog('open');}",
                                              'id'=>'btnAddAsalRujukan','onkeyup'=>"return $(this).focusNextInputField(event)",
                                              'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modRujukanBpjs->getAttributeLabel('asalrujukan_id'))) */ ?>
        <?php echo $form->error($modRujukanBpjs, 'asalrujukan_id'); ?>
    </div>
</div>

<?php //echo $form->textFieldRow($modRujukanBpjs,'no_rujukan', array('placeholder'=>'Nomor Rujukan','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); 
?>
<div class="control-group">
    <?php echo $form->labelEx($modRujukanBpjs, 'rujukandari_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList(
            $modRujukanBpjs,
            'rujukandari_id',
            CHtml::listData($modRujukanBpjs->getRujukanDariItems($modRujukanBpjs->asalrujukan_id), 'rujukandari_id', 'namaperujuk'),
            array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaPerujukBpjs();getPPK(this);')
        ); ?>
        <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                        array('class'=>'btn btn-primary','onclick'=>"{addRujukanDari(); $('#dialogAddRujukanDari').dialog('open');}",
                                              'id'=>'btnAddRujukanDari','onkeyup'=>"return $(this).focusNextInputField(event)",
                                              'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modRujukanBpjs->getAttributeLabel('nama_perujuk'))) */ ?>
        <?php echo $form->error($modRujukanBpjs, 'rujukandari_id'); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modSep, 'ppkrujukan', array('placeholder' => 'Kode ppk', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modRujukanBpjs, 'nama_perujuk', array('placeholder' => 'Nama Lengkap Perujuk', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <label for="PPRujukanbpjsT_kddiagnosa_rujukan" class="control-label">Kode Diagnosa Rujukan <span class="required">*</span>
        <!--<i class="entypo-search" onclick="$('#dialogDiagnosaBpjs').dialog('open')", style="cursor:pointer;" rel='tooltip' title='klik untuk mencari diagnosa rujukan'></i>-->
  </label>
    <div class="controls">
        <?php
        /*$this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
            'model' => $modRujukanBpjs,
            'attribute' => 'kddiagnosa_rujukan',
            'data' => explode(',', $modRujukanBpjs->kddiagnosa_rujukan),
            'debugMode' => true,
            'options' => array(
                //'bricket'=>false,
                // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
                'addontab' => true,
                'maxitems' => 10,
                'input_min_size' => 0,
                'cache' => true,
                'newel' => true,
                'addoncomma' => true,
                'select_all_text' => "",
                'autoFocus' => true,
            ),
            'htmlOptions' => array('id' => 'diagnosaRujukanKodeBpjs','class'=>'span3'),
        ));*/
        ?>
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modRujukanBpjs,
            'attribute' => 'kddiagnosa_rujukan',
            'source' => 'js: function(request, response) {
               $.ajax({
                   url: "' . Yii::app()->createUrl('asuransi/Sep/AutocompleteItemSEP') . '",
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
                   $("#' . CHtml::activeId($modRujukanBpjs, 'diagnosa_rujukan') . '").val(ui.item.nama);
                   return false;
               }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3 required',
                'onkeyup' => "return $(this).focusNextInputField(event)",
            ),
        ));
        ?>
        <?php echo $form->error($modRujukanBpjs, 'kddiagnosa_rujukan'); ?>
    </div>
</div>
<div class="control-group">
    <label for="PPRujukanbpjsT_diagnosa_rujukan" class="control-label">Diagnosa Rujukan <span class="required">*</span></label>
    <div class="controls">
        <?php
        /*$this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
            'model' => $modRujukanBpjs,
            'attribute' => 'diagnosa_rujukan',
            'data' => explode(',', $modRujukanBpjs->diagnosa_rujukan),
            'debugMode' => true,
            'options' => array(
                //'bricket'=>false,
                // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
                'addontab' => true,
                'maxitems' => 10,
                'input_min_size' => 0,
                'cache' => true,
                'newel' => true,
                'addoncomma' => true,
                'select_all_text' => "",
                'autoFocus' => true,
            ),
            'htmlOptions' => array('id' => 'diagnosaRujukanBpjs'),
        ));*/
        ?>
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modRujukanBpjs,
            'attribute' => 'diagnosa_rujukan',
            'source' => 'js: function(request, response) {
               $.ajax({
                   url: "' . Yii::app()->createUrl('asuransi/Sep/AutocompleteItemSEP') . '",
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
                   $(this).val(ui.item.nama);
                   return false;
               }',
                'select' => 'js:function( event, ui ) {
                   $(this).val(ui.item.nama);
                   $("#' . CHtml::activeId($modRujukanBpjs, 'kddiagnosa_rujukan') . '").val(ui.item.kode);
                   return false;
               }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3 required',
                'onkeyup' => "return $(this).focusNextInputField(event)",
            ),
        ));
        ?>
        <?php echo $form->error($modRujukanBpjs, 'diagnosa_rujukan'); ?>
    </div>
</div>
<?php
if (Yii::app()->user->getState('isbridging')) {
?>
    <?php echo $form->hiddenField($modSep, 'sep_id', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->hiddenField($modSep, 'tglsep', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    <div class="control-group">
        <label class="control-label">
            No. SEP
            <span class="required sep_oto_manual">*</span>
      </label>
        <div class="controls">
            <?php echo $form->textField($modSep, 'nosep', array('placeholder' => 'No. SEP Manual / Otomatis', 'class' => 'span3 nosep required', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->error($modSep, 'nosep'); ?>
        </div>
    </div>
    <?php echo $form->hiddenField($modSep, 'ppkpelayanan', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->dropDownList($modSep, 'jnspelayanan', array('2' => "Rawat Jalan", '1' => "Rawat Inap"), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaPerujuk();', 'style' => 'display:none;',)); ?>
    <div class="panel panel-success" id="skdp" style="display: <?php echo ($pelayanan == 'RJ') ? 'block' : 'none' ?>">
        <div class="control-group">
            <?php echo CHtml::label("Nomor Surat Kontrol", 'Nomor Surat Kontrol', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSep, 'no_surat', array('placeholder' => 'Nomor Surat Kontrol', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 6, 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Dokter DPJP ", 'nama_dpjp', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSep, 'nama_dpjp', array('placeholder' => 'Dokter DPJP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol', 'onblur' => "if($(this).val()=='') $('#" . CHtml::activeId($modSep, 'kode_dpjp') . "').val('')")); ?>
                <?php echo CHtml::link("<i class='entypo-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk cari DPJP", "onclick" => "$('#dialogDpjp').dialog('open');return true;")); ?>
                <?php echo $form->hiddenField($modSep, 'kode_dpjp', array('placeholder' => 'Dokter DPJP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="control-group form-inline">
        <?php echo CHtml::label("Poli Eksekutif", 'Eksekutif', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->radioButtonList($modSep, 'poli_eksekutif', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
            ?>
        </div>
    </div>
    <div class="control-group form-inline">
        <?php echo CHtml::label("COB", 'COB', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($modSep, 'cob', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
            echo $form->hiddenField($modSep, 'no_asuransi_cob', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
            echo $form->hiddenField($modSep, 'namaasuransi_cob', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
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
    <?php
    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'form-suplesi',
        'content' => array(
            'content-suplesi' => array(
                'header' => '<b>Kecelakaan Lalu Lintas</b>',
                'isi' => $this->renderPartial($this->path_view . '._formSuplesi', array(
                    'form' => $form,
                    'model' => $modSep,
                ), true),
                'active' => $modSep->lakalantas,
            ),
        ),
        'htmlOptions' => array(),
    ));
    ?>
    <?php echo $form->textAreaRow($modSep, 'catatansep', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    <?php
    if (!isset($_GET['sukses'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Verifikasi SEP', array('{icon}' => '<i class="icon-form-check icon-white"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Klik tombol untuk memverifikasi data bpjs', 'class' => 'btn btn-info pull-right verifikasi_bpjs', 'onclick' => "verifikasiBpjs($(this));",));
    }
    ?>
<?php } ?>
<br>
<br>
<br>
<?php echo $this->renderPartial($this->path_view . '_jsFunctionSuplesi', array('model' => $modSep)); ?>