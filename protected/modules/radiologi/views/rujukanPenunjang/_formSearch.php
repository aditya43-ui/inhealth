<fieldset>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'search-penunjangrujukan-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '',
        'htmlOptions' => array(),
    ));
    Yii::app()->clientScript->registerScript('search', "
    $('#search-penunjangrujukan-form').submit(function(){
		$.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
			data: $(this).serialize()
		});
		return false;
    });
    ");
    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Rujukan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label(CHtml::activeCheckBox($model, 'isPilihTglRencana',['checked'=>false])."Tgl. Rencana Pemeriksaan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_rencana_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_rencana_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_rencana_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_rencana_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_rencana_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_rencana_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="noPendaftaran" class="control-label">No. Pendaftaran</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'alphanumeric-only span4', 'maxlength' => 20, 'id' => 'noPendaftaran', 'autofocus' => true, 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                    <!--<input class ="alphanumeric-only" type="text" value="" maxlength="20" placeholder="No. pendaftaran" id="noPendaftaran" name="PasienkirimkeunitlainV[no_pendaftaran]" autofocus=true onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">-->
                </div>
            </div>
            <div class="control-group">
                <label for="noRekamMedik" class="control-label">No. Rekam Medik</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'numbers-only span4', 'maxlength' => 10, 'id' => 'noRekamMedik', 'autofocus' => true, 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                    <!--<input class ="numbers-only" type="text" value="" maxlength="10" placeholder="No. rekam medik" id="noRekamMedik" name="PasienkirimkeunitlainV[no_rekam_medik]" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">-->
                </div>
            </div>
            <div class="control-group">
                <?php echo Chtml::label("Dokter Pengirim", 'pegawai_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($model, 'namaDokter', array('placeholder' => 'Dokter PJP', 'class' => 'span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50));
                    $this->widget('MyJuiAutoComplete', array(
                        'attribute' => 'nama_pegawai',
                        'model' => $model,
                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/ListDokter'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
									$(this).val( ui.item.nama_pegawai);
									$("#' . CHtml::activeId($model, 'namaDokter') . '").val( ui.item.nama_pegawai);
									return false;
								}',
                            'select' => 'js:function( event, ui ) {
									$("#' . CHtml::activeId($model, 'namaDokter') . '").val( ui.item.nama_pegawai);
								}'
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogDokter'),
                        'htmlOptions' => array('onblur' => 'cekClear();', 'placeholder' => 'Dokter Pengirim', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'hurufs-only span4'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label for="namaPasien" class="control-label">Nama Pasien</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'hurufs-only span4', 'maxlength' => 50, 'id' => 'namaPasien', 'autofocus' => true, 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                    <!--<input class ="hurufs-only" type="text" value="" maxlength="50" placeholder="Ketik nama pasien" id="namaPasien" name="PasienkirimkeunitlainV[nama_pasien]" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">-->
                </div>
            </div>
            <div class="control-group hide">
                    <?php echo Chtml::label("NIK", 'pasien_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pasien_id', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                    </div>
                </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo Chtml::label('Jenis Penjamin', 'crabayar_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC"), 'carabayar_id', 'carabayar_nama'), array(
                        'empty' => '-- Pilih --',
                        'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                            'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                        ),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model, 'penjamin_id', array(), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
            <div class="control-group">
                <?php echo Chtml::label("Instalasi", 'instalasiasal_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_id', 'instalasi_nama'), array(
                        'empty' => '-- Pilih --',
                        'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/actionDynamic/GetRuanganAsalDariInstalasiAsal', array('encode' => false, 'namaModel' => get_class($model))),
                            'success' => 'function(data){$("#' . CHtml::activeId($model, "ruanganasal_id") . '").html(data); }',
                        ),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model, 'ruanganasal_id', array(), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
            <div class="control-group">
                <?php echo CHtml::label("Status Periksa", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'statusperiksa', LookupM::getItems('statusperiksa'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        );
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
        <?php
        $content = $this->renderPartial('../tips/informasiPasienRujukan', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</fieldset>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Dokter Pengirim',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modDokter = new DokterV('search');
$modDokter->unsetAttributes();
if (isset($_GET['DokterV'])) {
    $modDokter->attributes = $_GET['DokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $modDokter->searchAllDokter(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"
                            $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->namaLengkap\");
                            $(\"#' . CHtml::activeId($model, 'namaDokter') . '\").val(\"$data->nama_pegawai\");
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        //'gelardepan',
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class' => 'hurufs-only')),
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id',  Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });                '
        . '}',
));
$this->endWidget();
?>
<script>
    function cekClear() {
        var nama_pegawai = $("#PasienkirimkeunitlainV_nama_pegawai").val();
        if (nama_pegawai == '') {
            $("#PasienkirimkeunitlainV_namaDokter").val('');
        }
    }
</script>