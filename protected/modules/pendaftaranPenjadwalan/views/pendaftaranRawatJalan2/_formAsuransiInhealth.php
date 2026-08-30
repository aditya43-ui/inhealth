<div class="control-group">
    <?php echo CHtml::label("Cari " . $modAsuransiPasienInhealth->getAttributeLabel('nopeserta') . " <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        echo $form->textField($modAsuransiPasienInhealth, 'nopeserta', array('placeholder' => 'No. Peserta', 'class' => 'numbers-only span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
        ?>
        <?php echo CHtml::link("<i class='entypo-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk mengecek peserta", "onclick" => "EligibilitasPeserta($('#" . CHtml::activeId($modAsuransiPasienInhealth, "nopeserta") . "').val());return true;")); ?>
        <?php echo $form->error($modAsuransiPasienInhealth, 'nopeserta'); ?>
        <?php echo $form->hiddenField($modAsuransiPasienInhealth, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("Cari " . $modAsuransiPasienInhealth->getAttributeLabel('nokartuasuransi') . " <span class='required'>*</span>", 'nokartuasuransi', array('class' => 'control-label required')) ?>
    <div class="controls">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modAsuransiPasienInhealth,
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
                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'asuransipasien_id') . '").val(ui.item.asuransipasien_id);
                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'nopeserta') . '").val(ui.item.nopeserta);
                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'nokartuasuransi') . '").val(ui.item.nokartuasuransi);
                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'namapemilikasuransi') . '").val(ui.item.namapemilikasuransi);
                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'jenispeserta_id') . '").val(ui.item.jenispeserta_id);
                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'nomorpokokperusahaan') . '").val(ui.item.nomorpokokperusahaan);
                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'namaperusahaan') . '").val(ui.item.namaperusahaan);
                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'kelastanggunganasuransi_id') . '").val(ui.item.kelastanggunganasuransi_id);
                    setAsuransiLama();
                    return false;
                }',
            ),
            'tombolDialog' => array('idDialog' => 'dialogAsuransiBpjs', 'jsFunction' => 'cekAsuransiInhealth()'),
            'htmlOptions' => array(
                'placeholder' => 'No. Kartu Asuransi Inhealth', 'rel' => 'tooltip', 'title' => 'No. Peserta',
                'onkeyup' => "; return $(this).focusNextInputField(event)",
                'class' => 'numbers-only span3', 'maxlength' => 13
            ),
        ));
        ?>
        <?php echo $form->error($modAsuransiPasienInhealth, 'nokartuasuransi'); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modAsuransiPasienInhealth, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo $form->textFieldRow($modRujukanInhealth, 'no_rujukan', array('placeholder' => 'Kode rujukan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <label class="control-label">
        Tanggal Rujukan
        <span class="required">*</span>
  </label>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modRujukanInhealth,
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
        <?php echo $form->error($modRujukanInhealth, 'tanggal_rujukan'); ?>
    </div>
</div>
<div class="control-group">
    <div class="control-label"><?php echo Chtml::label('Kelas Tanggungan Asuransi', 'kelastanggunganasuransi_nama', array('class' => 'control-label')); ?></div>
    <div class="controls">
        <?php
        echo $form->textField($modAsuransiPasienInhealth, 'kelastanggunganasuransi_nama', array('placeholder' => 'Kelas Tanggungan Asuransi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
        echo $form->hiddenField($modAsuransiPasienInhealth, 'kelastanggunganasuransi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modRujukanInhealth, 'asalrujukan_id', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList(
            $modRujukanInhealth,
            'asalrujukan_id',
            CHtml::listData($modRujukanInhealth->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'),
            array(
                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/GetRujukanDari', array('encode' => false, 'namaModel' => 'PPRujukanInhealthT')),
                    'update' => '#' . CHtml::activeId($modRujukanInhealth, 'rujukandari_id'),
                ),
                'onchange' => ""
            )
        ); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modRujukanInhealth, 'rujukandari_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList(
            $modRujukanInhealth,
            'rujukandari_id',
            CHtml::listData($modRujukanInhealth->getRujukanDariItems($modRujukanInhealth->asalrujukan_id), 'rujukandari_id', 'namaperujuk'),
            array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaPerujukInhealth();getPPKInhealth(this);')
        ); ?>
    </div>
</div>
<?php echo $form->hiddenField($modSepInhealthT, 'jnspelayanan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modSepInhealthT, 'ppkrujukan', array('placeholder' => 'Kode ppk', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modRujukanInhealth, 'nama_perujuk', array('placeholder' => 'Nama Lengkap Perujuk', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <label class="control-label">
        No. SJP <span class="required">*</span>
  </label>
    <div class="controls">
        <?php echo $form->textField($modSepInhealthT, 'nosep', array('placeholder' => 'Otomatis', 'class' => 'span3 nosep required', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->error($modSepInhealthT, 'nosep'); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Diagnosa Utama <span class="required">*</span></label>
    <div class="controls">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modSepInhealthT,
            'attribute' => 'diagnosaawal',
            'source' => 'js: function(request, response) {
               $.ajax({
                   url: "' . Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/GetDiagnosaInhealth') . '",
                   dataType: "json",
                   data: {
                       term: request.term,
                       param: "mixed",
                   },
                   success: function (data) {
                       response(data);
                   }
               })
           }',
            'options' => array(
                'minLength' => 3,
                'focus' => 'js:function( event, ui ) {
                   $(this).val(ui.item.diagnosa_kode);
                   return false;
               }',
                'select' => 'js:function( event, ui ) {
                   $(this).val(ui.item.diagnosa_kode);
                   return false;
               }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'Kode/Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3 required',
                'onkeyup' => "return $(this).focusNextInputField(event)",
            ),
        ));
        ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Diagnosa Tambahan</label>
    <div class="controls">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modSepInhealthT,
            'attribute' => 'kodediagnosatambahan',
            'source' => 'js: function(request, response) {
               $.ajax({
                   url: "' . Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/GetDiagnosaInhealth') . '",
                   dataType: "json",
                    data: {
                        term: request.term,
                        param: "mixed",
                    },
                    success: function (data) {
                        response(data);
                    }
               })
           }',
            'options' => array(
                'minLength' => 3,
                'focus' => 'js:function( event, ui ) {
                   $(this).val(ui.item.diagnosa_kode);
                   return false;
               }',
                'select' => 'js:function( event, ui ) {
                   $(this).val(ui.item.diagnosa_kode);
                   return false;
               }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'Kode/Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3',
                'onkeyup' => "return $(this).focusNextInputField(event)",
            ),
        ));
        ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Kecelakaan</label>
    <div class="controls">
        <?php echo $form->dropDownList(
            $modSepInhealthT,
            'lakalantas',
            array('0' => "Tidak/Biasa", '1' => "Kecelakaan Kerja", '2' => "Kecelakaan Lalu Lintas"),
            array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")
        ); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Informasi Tambahan</label>
    <div class="controls">
        <?php echo $form->textArea($modSepInhealthT, 'catatansep', array('placeholder' => 'Informasi tambahan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>

<?php
if (!isset($_GET['sukses'])) {
    echo CHtml::link(Yii::t('mds', '{icon} Verifikasi SJP', array('{icon}' => '<i class="icon-form-check icon-white"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Klik tombol untuk memverifikasi SJP', 'class' => 'btn btn-info pull-right verifikasi_bpjs', 'onclick' => "verifikasiSjp(this,'lama');",));
}
?>
<br>
<br>
<br>
<?php echo $this->renderPartial(
    $this->path_view . '_jsFunctionInhealth',
    array(
        'model' => $model,
        'modRujukanInhealth' => $modRujukanInhealth,
        'modAsuransiPasienInhealth' => $modAsuransiPasienInhealth,
        'modSepInhealthT' => $modSepInhealthT,
        'modPasien' => $modPasien
    )
);
?>