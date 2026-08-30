<?php $linkHalaman = CustomFunction::getUrlByMenuID(2617); ?>
<?php
$this->breadcrumbs = array(
    'Transaksi Asuhan Keperawatan',
);
?>
<style>
tr td .add-on {
    margin: 0 !important;
}

.groupUkurans {
    display: inline;
}

table ul {
    margin-top: 10px;
}

#asuhankeperawatan ul li,
.boxtindakan .isi_inter ul li,
.boxtindakan .ambil_inter ul li,
.boxtindakan .ambil_kolab ul li,
.boxtindakan .isi_kolab ul li {
    list-style: none;
    margin-left: -20px;
    margin-right: 5px;
    padding: 5px;
    margin-bottom: 1px;
}

li.warna {
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -o-border-radius: 3px;
    border-radius: 3px;
    background: #DDD;
}

input[type="checkbox"] {
    margin-right: 5px;
    line-height: 10px;
    margin-top: -5px;
}

.boxtindakan {
    width: 300px;
    max-width: 400px;
}

table .span2 {
    float: left;
}

.tdtindakan label {
    display: table;
    margin-left: 18px;
    margin-top: -18px;
}

</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjasuhankeperawatan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RIInfokunjunganriV_no_rekam_medik',
));
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Asuhan keperawatan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'tgl_pendaftaran', array('readonly' => true, 'placeholder' => 'Tanggal Pendaftaran')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">No. Pendaftaran</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'no_pendaftaran', array('readonly' => true, 'class' => 'span2', 'placeholder' => 'No. Pendaftaran')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'umur', array('readonly' => true, 'placeholder' => 'Umur')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskasuspenyakit_nama', array('readonly' => true, 'placeholder' => 'Jenis Kasus Penyakit')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <div class="control-label">
                        <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'no_rek')); ?>
                        <span class="required">*</span></div>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPasien,
                            'attribute' => 'no_rekam_medik',
                            'value' => '',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/PasienRawatInap'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
                                              $("#' . CHtml::activeId($modPasien, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
                                              $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                              $("#' . CHtml::activeId($modPasien, 'umur') . '").val(ui.item.umur);     
                                              $("#' . CHtml::activeId($modPasien, 'jeniskasuspenyakit_nama') . '").val(ui.item.jeniskasuspenyakit_nama);
                                              $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                              $("#' . CHtml::activeId($modPasien, 'nama_pasien') . '").val(ui.item.nama_pasien);     
                                              $("#' . CHtml::activeId($modPasien, 'jeniskelamin') . '").val(ui.item.jeniskelamin);  
                                              $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);  
                                              $("#' . CHtml::activeId($modPasien, 'nama_bin') . '").val(ui.item.nama_bin);   
                                              $("#' . CHtml::activeId($model, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);     
                                              $("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.pasien_id);    
                                              $("#' . CHtml::activeId($model, 'pasienadmisi_id') . '").val(ui.item.pasienadmisi_id);
                                              $("#diagnosa_nama").val(ui.item.diagnosa); 
                                              $("#' . CHtml::activeId($modAnamnesa, 'keluhanutama') . '").val(ui.item.keluhanutama); 
                                              $("#' . CHtml::activeId($modAnamnesa, 'keluhantambahan') . '").val(ui.item.keluhantambahan); 
                                              $("#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '").val(ui.item.riwayatpenyakitterdahulu); 
                                              $("#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '").val(ui.item.riwayatpenyakitkeluarga); 
                                              $("#' . CHtml::activeId($modPeriksaFisik, 'tekanandarah') . '").val(ui.item.tekanandarah); 
                                              $("#' . CHtml::activeId($modPeriksaFisik, 'detaknadi') . '").val(ui.item.detaknadi); 
                                              $("#' . CHtml::activeId($modPeriksaFisik, 'pernapasan') . '").val(ui.item.pernapasan); 
                                              $("#' . CHtml::activeId($modPeriksaFisik, 'suhutubuh') . '").val(ui.item.suhutubuh); 
                                              $("#' . CHtml::activeId($modPeriksaFisik, 'paramedis_nama') . '").val(ui.item.pegawai); 
                                              $("#' . CHtml::activeId($modPeriksaFisik, 'beratbadan_kg') . '").val(ui.item.beratbadan); 
                                              $("#' . CHtml::activeId($modPeriksaFisik, 'tinggibadan_cm') . '").val(ui.item.tinggibadan); 
                                              $("#' . CHtml::activeId($modPeriksaFisik, 'kelainanpadabagtubuh') . '").val(ui.item.kelainanpadabagtubuh); 
                                              if (!jQuery.isNumeric(ui.item.diagnosa_id)){
                                                  ui.item.diagnosa_id = 0;
                                              }
                                              $("#' . CHtml::activeId($model, 'diagnosa_id') . '").val(ui.item.diagnosa_id); 
                                              setRiwayat();
//                                              $("#PIInfokunjunganriV_no_rekam_medik").blur();
                                                  }',
                            ),
                            'htmlOptions' => array(
                                'readonly' => false,
                                'placeholder' => 'No. Rekam Medik',
                                'size' => 20,
                                'class' => 'span3',
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pendaftaran_id') . '").val(""); ',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDaftarPasien', 'idTombol' => 'tombolPasienDialog'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true, 'placeholder' => 'Jenis Kelamin')); ?>
                        <?php echo CHtml::activeHiddenField($model, 'pasien_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'required')); ?>
                        <?php echo CHtml::activeHiddenField($model, 'pasienadmisi_id', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true, 'placeholder' => 'Nama Pasien')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly' => true, 'placeholder' => 'Nama Panggilan')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->hiddenField($model, 'diagnosa_id', array('class' => 'control-label')); ?>
                    <label class="control-label">Diagnosa</label>
                    <div class="controls">
                        <?php echo CHtml::textField('diagnosa_nama', '', array('readonly' => true, 'placeholder' => 'Nama Diagnosa')); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($modAnamnesa, 'keluhanutama', array('rows' => 3, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keluhan Utama')); ?>
                <?php echo $form->textAreaRow($modAnamnesa, 'keluhantambahan', array('rows' => 3, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keluhan Tambahan')); ?>
                <?php echo $form->textFieldRow($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'Riwayat Penyakit Terdahulu')); ?>
                <?php echo $form->textFieldRow($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'Riwayat Penyakit Keluarga')); ?>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPeriksaFisik, 'Tekanan Darah', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPeriksaFisik, 'tekanandarah', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'placeholder' => '0/0')) . " <label style='color:black'>Mm/Hg<label>"; ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPeriksaFisik, 'Detak Nadi', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPeriksaFisik, 'detaknadi', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'placeholder' => '0')) . " <label style='color:black'> /Menit<label>"; ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPeriksaFisik, 'Suhu Tubuh', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPeriksaFisik, 'suhutubuh', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'placeholder' => '0')) . " <label style='color:black'>° Celcius<label>"; ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPeriksaFisik, 'Berat Badan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPeriksaFisik, 'beratbadan_kg', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'placeholder' => '0')) . " <label style='color:black'>Kg/Gr<label>"; ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPeriksaFisik, 'Tinggi Badan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPeriksaFisik, 'tinggibadan_cm', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'placeholder' => '0')) . " <label style='color:black'>M/Cm<label>"; ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modPeriksaFisik, 'pernapasan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'placeholder' => 'Pernapasan')); ?>
                <?php echo $form->textFieldRow($modPeriksaFisik, 'paramedis_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'Nama Paramedis')); ?>
                <?php echo $form->textFieldRow($modPeriksaFisik, 'kelainanpadabagtubuh', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'placeholder' => 'Kelainan Bagian Tubuh')); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengkajian</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_dataPengkajian', array('modPengkajian' => $modPengkajian, 'form' => $form)); ?>
            </div>
        </div>


        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo CHtml::checkBox('cekRiwayatPasien', false, array('onkeypress' => "return $(this).focusNextInputField(event)")) ?>
                    Riwayat Asuhan Keperawatan
                </div>
            </div>
            <div class="panel-body " id="divRiwayatPasien" style="display:none;">
                <div class="control-group">
                    <iframe src="" id="riwayatAsuhanKeperawatan" width="100%" onload="javascript:resizeIframe(this);">
                    </iframe>
                    <div id="alertriwayat">
                        <div class="alert alert-block alert-error">
                            Data Riwayat Asuhan Keperawatan tidak ditemukan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Rencana dan Implementasi Keperawatan
                </div>
            </div>
            <div class="panel-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td><?php echo $form->labelEx($model, 'tglaskep', array('class' => 'control-label')) ?></td>
                        <td style="padding-right:30px;">
                            <?php echo $form->textField($model, 'tglaskep', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td style="padding-left:30px;">
                            <?php echo CHtml::label("Paramedis <span class='required'>*</span>", 'paramedis_nama', array('class' => 'control-label')) ?>
                            <?php echo CHtml::activeHiddenField($model, 'pegawai_id', array('class' => 'required')); ?>
                        </td>
                        <td style="padding-right:50px;">
                            <!--<?php
                                //                        $this->widget('MyJuiAutoComplete', array(
                                //                            'model' => $model,
                                //                            'attribute' => 'paramedis_nama',
                                //                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/getPerawat'),
                                //                            'options' => array(
                                //                                'showAnim' => 'fold',
                                //                                'minLength' => 2,
                                //                                'focus' => 'js:function( event, ui ) {
                                //                                        $(this).val(ui.item.nama_pegawai);
                                //                                        return false;
                                //                                    }',
                                //                                'select' => 'js:function( event, ui ) {
                                //                                                $(this).val(ui.item.nama_pegawai);
                                //                                                $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                //                                                    return false;
                                //                                              }'
                                //                            ),
                                //                            'htmlOptions' => array('class' => '', 'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegawai_id') . '").val(""); ')
                                //                        ));
                                ?>-->
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'paramedis_nama',
                                'value' => '',
                                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/getPerawat'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        $(this).val(ui.item.nama_pegawai);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.nama_pegawai);
                                                $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id);
//                                                $("#RIInfokunjunganriV_no_rekam_medik").blur();
                                                    return false;
                                              }'
                                ),
                                'htmlOptions' => array(
                                    'readonly' => false,
                                    'placeholder' => 'Nama Paramedis',
                                    'size' => 20,
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogParamedis'), //'idTombol'=>'tombolPasienDialog'),
                            ));
                            ?>
                        </td>
                    </tr>
                </table>
                <!--
        <?php echo $form->textFieldRow($model, 'ruangan_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'pegawai_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'shift_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'pasienadmisi_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'diagnosakeperawatan_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'tglaskep', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($model, 'evaluasi_subjektif', array('rows' => 6, 'cols' => 50, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($model, 'evaluasi_objektif', array('rows' => 6, 'cols' => 50, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'tglassesment', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'evaluasi_assesment', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textAreaRow($model, 'askep_tujuan', array('rows' => 6, 'cols' => 50, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($model, 'askep_kriteriahasil', array('rows' => 6, 'cols' => 50, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>  
-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rencana dan Implementasi Keperawatan</b>
                </div>
            </div>
            <div class="panle-body table-responsive">
                <table width="100%" class="table table-striped table-condensed" id='asuhankeperawatan'>
                    <thead>
                        <tr>
                            <th>Diagnosa <span style="color:red">*</span></th>
                            <th width="200">Intervensi</th>
                            <th width="200">Implementasi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td width="67">
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'diagnosakeperawatan_nama',
                                    'value' => 'dialogDetailData',
                                    'sourceUrl' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/getDiagnosaKeperawatan') . '",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           idDiagnosa: $("#' . Chtml::activeId($model, 'diagnosa_id') . '").val(),
                                                       },
                                                       success: function (data) {
                                                               response(data);                        
                                                       }
                                                   })
                                                }',
                                    'options' => array(
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.label);
                                                return false;
                                            }',
                                        'select' => 'js:function( event, ui ) {
                                                  submitDiagnosa(ui.item.diagnosakeperawatan_id);
                                                      }'
                                    ),
                                    'htmlOptions' => array('class' => 'span2'), 'tombolDialog' => array('idDialog' => 'dialogDetailData', 'jsFunction' => "updateGrid();$('#dialogDetailData').dialog('open');"),
                                ));
                                ?> </td>
                            <td colspan="2">
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Evaluasi Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-striped table-condensed" id='asuhankeperawatan2'>
                    <thead>
                        <tr>
                            <th>Diagnosa</th>
                            <th>Subjektif</th>
                            <th>Objektif</th>
                            <th>Assesment</th>
                            <!--<th>Planning</th>-->
                            <th>Tujuan</th>
                            <th>Kriteria Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Planning Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-striped table-condensed" id="asuhankeperawatan3">
                    <thead>
                        <tr>
                            <th>Diagnosa</th>
                            <th colspan='2'>Planning</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php
            //        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->module->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('perawatanIntensif.views.tips.transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$noRekamMedik = CHtml::activeId($modPasien, 'no_rekam_medik');
$pendaftaran_id = CHtml::activeId($model, 'pendaftaran_id');
$tglAskep = Chtml::activeId($model, 'tglaskep');
$paramedis = CHtml::activeId($model, 'paramedis_nama');
$diagnosaKeperawatan = CHtml::activeId($model, 'diagnosakeperawatan_nama');
$idDiagnosaKeperawatan = CHtml::activeId($model, 'diagnosakeperawatan_id');
$urlHalamanIni = Yii::app()->createUrl($this->module->id . '/asuhanKeperawatan/index');
$diagnosa_id = CHtml::activeId($model, 'diagnosa_id');
$getDiagnosaKeperawatan = Yii::app()->createUrl($this->module->id . '/asuhanKeperawatan/getDiagnosaKeperawatan');
$getRiwayatPasienDariAsuhanKeperawatan = Yii::app()->createUrl('actionAjax/getRiwayatAsuhan');
$getDataAsuhanKeperawatan = Yii::app()->createUrl('actionAjax/getDataAsuhanKeperawatan');
$urlRiwayat = Yii::app()->createUrl($this->module->id . '/asuhanKeperawatan/getRiwayatPasien');
?>
<?php Yii::app()->clientScript->registerScript('onready', "
    $(document).ready(function(){
        $('#asuhankeperawatan').find('.inputAutoComplete').addClass('span2');
        $('.detailDiagnosa').find('input, textarea').attr('readOnly','true');
        $('form').submit(function(){     
                if (cekValidasi() == false)
                    return false;
                else{
                    return true;
                }
        });
        $('#cekRiwayatPasien').click(function(){
            if ($(this).is(':checked')){
                getRiwayat();
                $('#divRiwayatPasien').slideDown();
                $('#RI1206110002').trigger('click');
            }
            else{
                $('#divRiwayatPasien').slideUp();
            }
        });
        setValidasiCekDisabled($('#rjasuhankeperawatan-t-form'), validasiDataTable);
    });
    function validasiDataTable(){
            var trAsuh = $('#asuhankeperawatan3 > tbody > tr').length;
            if (trAsuh == 0){
                return false;
            }else{
                return true;
            }
    }
    function warnai(obj){
        if ($(obj).is('checked')){
            $(obj).parent('li').addClass('warna');
        }
        else{
            $(obj).parent('li').addClass('warna');
        }
    }
    function getRiwayat(){
        var noRekamMedik = $('#${noRekamMedik}').val();
        var pendaftaran_id = $('#${pendaftaran_id}').val();
        var noRekamMedik = noRekamMedik.split(' - ');
        var noRekamMedik = noRekamMedik[0];
        $.post('${urlRiwayat}',{pendaftaran_id:pendaftaran_id}, function(data){
            if (data.div != ''){
                $('#alertriwayat').addClass('hide');
                $('#tablehide').removeClass('hide');
                $('#divRiwayatPasien table tbody tr').remove();
                $('#divRiwayatPasien').html(data.div);
                $('#testing').redactor({'autoresize':false,'fixed':true,'lang':'en','toolbar':'smini'});
            }
            else{
                $('#tablehide').addClass('hide');
                $('#alertriwayat').removeClass('hide');
            }
        }, 'json');
        getUpdateData(noRekamMedik);
    }
    function getUpdateData(value){
        var pendaftaran_id = $().val();
        $.post('${getDiagnosaKeperawatan}', {noRekamMedik:value}, function(data){
        }, 'json');
    }
    function updateGrid(){
        var diagnosa_id = $('#${diagnosa_id}').val();
        if (diagnosa_id == ''){
            diagnosa_id =0;
        }else if (diagnosa_id == 0){
            diagnosa_id = '';
        }
        var url = document.URL+'&RIDiagnosakeperawatanM%5Bdiagnosa_id%5D='+diagnosa_id;
        $.fn.yiiGridView.update('rjdiagnosakeperawatan-m-grid', {
            url: url,
        }); 
    }
    function submitDiagnosa(bata){
        $.post('${getDiagnosaKeperawatan}',{idDiagnosaKeperawatan:bata}, function(data){
            var validasi = true;
            $('#asuhankeperawatan').find('#AsuhankeperawatanT_diagnosakeperawatan_id').each(function(){
                if ($(this).val() == data.id){
                    validasi = false;
                };
            });
            if (validasi == false){
                myAlert('Data Diagnosa kperawatan telah ada');
                $('#RIInfokunjunganriV_no_rekam_medik').blur();
            }else{
                $('#asuhankeperawatan').append(data.tr);
                $('#asuhankeperawatan2').append(data.tr2);
                $('#asuhankeperawatan3').append(data.tr3);
                 noUrut = 1;
                 $('.urutan').parents('#asuhankeperawatan').find('.urutan').each(function() {
//                      $(this).parents('tr').find('.intervensi_check').attr('name', 'rencana_intervensi['+(noUrut-1)+'][]');
//                      $(this).parents('tr').find('.implementasi_check').attr('name', 'rencana_implementasi['+(noUrut-1)+'][]');
                      $(this).val(noUrut);
                      noUrut = noUrut + 1;
                 });
                $('#asuhankeperawatan2').find('textarea').redactor({
                   toolbar : 'smini'
                });
                 noUrut = 1;
                 $('.urutan').parents('#asuhankeperawatan2').find('.urutan').each(function() {
                      $(this).val(noUrut);
                      noUrut = noUrut + 1;
                 });
                 noUrut = 1;
                 $('.urutan').parents('#asuhankeperawatan3').find('.urutan').each(function() {
                      $(this).parents('tr').find('.isi_inter ul').addClass(''+noUrut+'');
                      $(this).parents('tr').find('.isi_kolab ul').addClass(''+noUrut+'');
                      $(this).parents('tr').find('.ambil_inter ul').addClass(''+noUrut+'');
                      $(this).parents('tr').find('.ambil_kolab ul').addClass(''+noUrut+'');
                      $(this).val(noUrut);
                      noUrut = noUrut + 1;
                 });
                 $('#RIInfokunjunganriV_no_rekam_medik').blur();
            }
        },'json');
    }
    function submitIntervensi(obj){
        var value = $(obj).val();
        var urutan = $(obj).parents('tr').find('#urutan').val();
        var text = $(obj).attr('textdata');
        var isKolab = $(obj).attr('kolaborasi');
        var valuedata = $(obj).attr('valuedata');
        var intervensi = '<input type=checkbox id=evaluasi_inter kolaborasi='+isKolab+' name=evaluasi_intervensi['+(urutan-1)+'][] onclick=ambilIntervensi(this) textData=\"'+text+'\" value='+value+' valuedata='+valuedata+'>';
        if (isKolab == 1){
            isKolab = 'kolab';
        }else{
            isKolab = 'inter';
        }
        if ($(obj).is(':checked')){
                $(obj).parent('li').addClass('warna');
                $('#asuhankeperawatan3 tbody tr').find('.isi_'+isKolab+' ul.'+urutan+'').append('<li>'+intervensi+text+'</li>');
        }
        else{
            $(obj).parent('li').removeClass('warna');
            $('#asuhankeperawatan3').find('.isi_'+isKolab+' ul.'+urutan+' input[valuedata='+valuedata+']').parent('li').remove();
            $('#asuhankeperawatan3').find('.block .ambil_'+isKolab+' ul.'+urutan+' input[valuedata='+valuedata+']').parent('li').remove();
        }
        $('#RIInfokunjunganriV_no_rekam_medik').blur();
    }
    function ambilIntervensi(obj){
        var value = $(obj).val();
        var urutan = $(obj).parents('tr').find('#urutan').val();
        var text = $(obj).attr('textData');
        var isKolab = $(obj).attr('kolaborasi');
        var valuedata = $(obj).attr('valuedata');
        var intervensi = '<input type=checkbox id=ambil_intervensi kolaborasi='+isKolab+' name=ambil_intervensi['+(urutan-1)+'][] onclick=remove(this) textData=\"'+text+'\" value='+value+' valuedata='+valuedata+' checked=checked>';
        if (isKolab == 1){
            isKolab = 'kolab';
        }else{
            isKolab = 'inter';
        }
        if ($(obj).is(':checked')){
            $(obj).parent('li').addClass('warna');
            $('#asuhankeperawatan3 tbody tr').find('.ambil_'+isKolab+' ul.'+urutan+'').append('<li>'+intervensi+text+'</li>');
        }
        else{
            $(obj).parent('li').removeClass('warna');
            $('#asuhankeperawatan3').find('.block .ambil_'+isKolab+' ul.'+urutan+' input[valuedata='+valuedata+']').parent('li').remove();
        }
        $('#RIInfokunjunganriV_no_rekam_medik').blur();
    }
    function remove(obj){
        var urutan = $(obj).parents('tr').find('#urutan').val();
        var text = $(obj).attr('textData');
        var valuedata = $(obj).attr('valuedata');
        if ($(obj).is(':checked')){
        }
        else{
            $(obj).parents('tr').find('input[valuedata='+valuedata+']').parent('li').removeClass('hide');
            $(obj).parent('li').remove();
        }
        $('#RIInfokunjunganriV_no_rekam_medik').blur();
    }
    function setRiwayat(){
        var id = $('#${pendaftaran_id}').val();
        clearTable();
        $('#alertriwayat').addClass('hide');
        $('#cekRiwayatPasien').attr('checked','checked');
        $('#riwayatAsuhanKeperawatan').attr('src','${urlRiwayat}&id='+id);
        $('#divRiwayatPasien').slideDown('medium');
    }
    function clearTable(){
        $('table#asuhankeperawatan tbody tr').remove();
        $('table#asuhankeperawatan2 tbody tr').remove();
        $('table#asuhankeperawatan3 tbody tr').remove();
        $('#RIInfokunjunganriV_no_rekam_medik').blur();
    }
    function cekValidasi(){
        var valueDiagnosa = $('#AsuhankeperawatanT_diagnosakeperawatan_id').length;
        var valueRM = $('#${noRekamMedik}').val();
        var valueParam = $('#${paramedis}').val();
        var valueTglAskep = $('#${tglAskep}').val();
        if (valueRM == ''){
            myAlert('No. Rekam Medik Pasien Belum Diisi');
            return false;
        }
        else if (valueTglAskep == ''){
            myAlert('Tanggal Asuhan Keperawatan Belum Diisi');
            return false;
        }
        else if (valueParam == ''){
            myAlert('Nama Paramedis Belum Diisi');
            return false;
        }
        else if (valueDiagnosa < 1){
            myAlert('Belum Ada Diagnosa Keperawatan yang dipilih!');
            return false;
        }
        else{
            return true;
        }
    }
    function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    }
", CClientScript::POS_HEAD); ?>
<?php
$modDiagnosaKeperawatan = new DiagnosakepM('search');
$modDiagnosaKeperawatan->unsetAttributes();
//$modDiagnosaKeperawatan->diagnosa_id = 0;
if (isset($_GET['DiagnosakepM'])) {
    $modDiagnosaKeperawatan->attributes = $_GET['DiagnosakepM'];
}
?>
<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Detail Data Diagnosa Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'resizable' => false,
    ),
));
?>
<div id="diagnosakeperawatan" width="100%" onload="javascript:resizeIframe(this);">
    <?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'rjdiagnosakeperawatan-m-grid',
        'dataProvider' => $modDiagnosaKeperawatan->search(),
        'filter' => $modDiagnosaKeperawatan,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'diagnosakeperawatan_id',
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectObat",
                            "onClick" => "submitDiagnosa($data->diagnosakep_id);$(\'#dialogDetailData\').dialog(\'close\');return false;"))',
            ),
            //'diagnosa_id',
            'diagnosakep_kode',
            'diagnosakep_nama',
            /*
      'diagnosa_keperawatan_aktif',
     */
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    ?>
</div>
<?php
$this->endWidget();
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailData2',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailData2" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<div style='display:none'>
    <?php $this->widget('ext.redactorjs.Redactor', array('name' => 'test', 'toolbar' => 'mini', 'height' => '100px')) ?>
</div>
<?php
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogParamedis',
    'options' => array(
        'title' => 'Daftar Paramedis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
?>
<?php
$modParamedis = new ParamedisV('search');
$modParamedis->unsetAttributes();
$modParamedis->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['ParamedisV'])) {
    $modParamedis->attributes = $_GET['ParamedisV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'paramedisYangMengajukan-m-grid',
    'dataProvider' => $modParamedis->search(),
    'filter' => $modParamedis,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                "id" => "selectDokter",
                                "href"=>"",
                                "onClick"=>"$(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                  $(\"#dialogParamedis\").dialog(\"close\");
                                  $(\"#' . CHtml::activeId($model, 'paramedis_nama') . '\").val(\"$data->nama_pegawai\");
//                                  $(\"#PIInfokunjunganriV_no_rekam_medik\").blur();
                                  return false;
                                ",
                               ))',
        ),
        //            'pegawai_id',
        'gelardepan',
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Paramedis',
        ),
        'gelarbelakang_nama',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => Chtml::activeDropDownList($modParamedis, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('style' => 'width:170px;', 'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")),
        ),
        array(
            'name' => 'agama',
            'type' => 'raw',
            'filter' => Chtml::activeDropDownList($modParamedis, 'agama', LookupM::getItems('agama'), array('style' => 'width:170px;', 'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$modPasienSearch = new RIInfopasienmasukkamarV('searchRILagi');
$modPasienSearch->statusperiksa = "SEDANG DIRAWAT INAP";
// $modPasien->tgl_pendaftaran = date('Y-m-d');
if (isset($_GET['RIInfopasienmasukkamarV'])) {
    $modPasienSearch->attributes = $_GET['RIInfopasienmasukkamarV'];
    $format = new MyFormatter();
    $modPasienSearch->tgl_pendaftaran  = (isset($_REQUEST['RIInfopasienmasukkamarV']['tgl_pendaftaran']) ? $format->formatDateTimeForDb($_REQUEST['RIInfopasienmasukkamarV']['tgl_pendaftaran']) : null);
    $modPasienSearch->statusperiksa  = $_REQUEST['RIInfopasienmasukkamarV']['statusperiksa'];
    $modPasienSearch->ceklis = 0;
    //    $modPasien->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RIInfopasienmasukkamarV']['tgl_awal']);
    //    $modPasien->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RIInfopasienmasukkamarV']['tgl_akhir']);
}
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDaftarPasien',
    'options' => array(
        'title' => 'Daftar Pasien',
        'autoOpen' => false,
        'resizable' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
    ),
));
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarpasien-v-grid',
    'dataProvider' => $modPasienSearch->searchRILagi(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'filter' => $modPasienSearch,
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPendaftaran",
                                    "onClick" => "cekdata(\"$data->pendaftaran_id\");
                                        $(\"#' . CHtml::activeId($modPasien, 'tgl_pendaftaran') . '\").val(\"$data->tgl_pendaftaran\");
                                        $(\"#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '\").val(\"$data->no_pendaftaran\");
                                        $(\"#' . CHtml::activeId($modPasien, 'umur') . '\").val(\"$data->umur\");
                                        $(\"#' . CHtml::activeId($modPasien, 'jeniskasuspenyakit_nama') . '\").val(\"$data->jeniskasuspenyakit_nama\");
                                        $(\"#' . CHtml::activeId($modPasien, 'jeniskelamin') . '\").val(\"$data->jeniskelamin\");
                                        $(\"#' . CHtml::activeId($modPasien, 'no_rekam_medik') . '\").val(\"$data->no_rekam_medik\");
                                        $(\"#' . CHtml::activeId($modPasien, 'nama_pasien') . '\").val(\"$data->nama_pasien\"); 
                                        $(\"#' . CHtml::activeId($modPasien, 'nama_bin') . '\").val(\"$data->nama_bin\");
                                        $(\"#' . CHtml::activeId($modPasien, 'tglpindahkamar') . '\").val(\"$data->tglmasukkamar\");
                                        $(\"#' . CHtml::activeId($modPasien, 'masukkamar_id') . '\").val(\"$data->masukkamar_id \");
                                        $(\"#' . CHtml::activeId($modPasien, 'pendaftaran_id') . '\").val(\"$data->pendaftaran_id \");
                                        $(\"#' . CHtml::activeId($modPasien, 'pasien_id') . '\").val(\"$data->pasien_id \");
                                        $(\"#' . CHtml::activeId($modPasien, 'pasienadmisi_id') . '\").val(\"$data->pasienadmisi_id \");
                                        $(\"#PIAsuhankeperawatanT_pendaftaran_id\").val(\"$data->pendaftaran_id \");
                                        $(\"#PIAsuhankeperawatanT_pasien_id\").val(\"$data->pasien_id \");
                                        $(\"#PIAsuhankeperawatanT_pasienadmisi_id\").val(\"$data->pasienadmisi_id \");
                                        $(\"#PIPindahkamarT_ruangan_id\").val(\"$data->ruangan_nama \");
                                        $(\"#PIMasukKamarT_carabayar_id\").val(\"$data->carabayar_nama \");
                                        $(\"#PIMasukKamarT_penjamin_id\").val(\"$data->penjamin_nama \");
                                        $(\"#PIMasukKamarT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_nama \");
                                        $(\"#PIMasukKamarT_pegawai_id\").val(\"$data->nama_pegawai \");
                                        $(\"#PIMasukKamarT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_nama \");
//                                        $(\"#RIInfokunjunganriV_no_rekam_medik\").blur();
setRiwayat();
                                        $(\"#dialogDaftarPasien\").dialog(\"close\");
                                    "))',
        ),
        'no_rekam_medik',
        //tgl_pendaftaran',
        // array(
        //     'name'=>'tgl_pendaftaran',
        //     'value'=>'$data->tgl_pendaftaran',
        //     'filter'=>$this->widget('MyDateTimePicker',array(
        //     'model'=>$modPasien,
        //     'attribute'=>'tgl_pendaftaran',
        //     'mode'=>'date',
        //     'options'=> array(
        //         'dateFormat'=>Params::DATE_FORMAT
        //     ),
        //         'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','onclick'=>'showDateTime();'),
        //     ),true
        //     ),
        //     'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
        // ),
        'no_pendaftaran',
        'nama_pasien',
        'alamat_pasien',
        'penjamin_nama',
        'nama_pegawai',
        'jeniskasuspenyakit_nama',
        array(
            'name' => 'statusperiksa',
            'type' => 'raw',
            'value' => '$data->statusperiksa',
            'filter' => CHtml::activeDropDownList(
                $modPasienSearch,
                'statusperiksa',
                LookupM::getItems('statusperiksa'),
                array('options' => array('ANTRIAN' => array('selected' => true)))
            ),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            jQuery(\'#RJInfokunjunganrjV_tgl_pendaftaran\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'id\'], {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
        }',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
function cekdata(pendaftaran_id) {

    console.log('cek data ini');
    if (pendaftaran_id != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataAnamnesaFisik'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#diagnosa_nama").val(data.diagnosa);
                $("#<?php echo CHtml::activeId($modAnamnesa, 'keluhanutama'); ?>").val(data.keluhanutama);
                $("#<?php echo CHtml::activeId($modAnamnesa, 'keluhantambahan'); ?>").val(data
                    .keluhantambahan);
                $("#<?php echo CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu'); ?>").val(data
                    .riwayatpenyakitterdahulu);
                $("#<?php echo CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga'); ?>").val(data
                    .riwayatpenyakitkeluarga);
                $("#<?php echo CHtml::activeId($modPeriksaFisik, 'tekanandarah'); ?>").val(data
                    .tekanandarah);
                $("#<?php echo CHtml::activeId($modPeriksaFisik, 'detaknadi'); ?>").val(data.detaknadi);
                $("#<?php echo CHtml::activeId($modPeriksaFisik, 'pernapasan'); ?>").val(data.pernapasan);
                $("#<?php echo CHtml::activeId($modPeriksaFisik, 'suhutubuh'); ?>").val(data.suhutubuh);
                $("#<?php echo CHtml::activeId($modPeriksaFisik, 'paramedis_nama'); ?>").val(data.pegawai);
                $("#<?php echo CHtml::activeId($modPeriksaFisik, 'beratbadan_kg'); ?>").val(data
                .beratbadan);
                $("#<?php echo CHtml::activeId($modPeriksaFisik, 'tinggibadan_cm'); ?>").val(data
                    .tinggibadan);
                $("#<?php echo CHtml::activeId($modPeriksaFisik, 'kelainanpadabagtubuh'); ?>").val(data
                    .kelainanpadabagtubuh);

                console.log('load anamnesa periksa fisik');

                loadRiwayatAnemnesa(pendaftaran_id);
                loadRiwayatPeriksaFisik(pendaftaran_id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
}


function setTindakan(obj) {

    var item = [];
    var i = 0;

    if($(obj).is(':checked')) {
        var nama = $(obj).val();
        item[0] = nama;
    }

    console.log('item intervensi ini: ');
    console.log(item);


    var diagnosisaskepdet_id = $(obj).parents('tr').find('.diagnosisaskepdet_id').val();


    var intervensidet_id = item.join(',');
    $(obj).parents('tr').find('.tindakannya').each(function() {
        $(this).find("#table-tindakannya").addClass("animation-loading");
    });
    $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('/asuhanKeperawatan/RencanaKeperawatan/setTindakan'); ?>',
        data: {
            intervensidet_id: intervensidet_id,
            diagnosisaskepdet_id: diagnosisaskepdet_id
        },
        dataType: "json",
        success: function(data) {
            $(obj).parents('tr').find('.tindakannya').each(function() {
                // $(this).find('#table-tindakannya').html("");
                if($(obj).is(":checked")) {
                    console.log('tambahkan ' + '.intervensidet_' + intervensidet_id);
                    $(this).find('#table-tindakannya').append(data.tabel);
                } else {
                    console.log('uncek intervensi dengan nilai ' + $(obj).val());
                    $('.intervensidet_' + $(obj).val()).remove();
                }
                $(this).find("#table-tindakannya").removeClass("animation-loading");

                console.log();
                
            });
            renameInputImplementasi();
            setPlanning();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}


function loadRiwayatAnemnesa(pendaftaran_id) {
		$('#anemnesa').addClass("animation-loading");
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('loadRiwayatAnemnesa'); ?>',
			data: {pendaftaran_id: pendaftaran_id},
			dataType: "json",
			success: function (data) {
				$('#anemnesa table > tbody').html(data.rows);
				$('#anemnesa table > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$('#anemnesa').removeClass("animation-loading");
				renameInputRowRiwayat($("#anemnesa"));
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function loadRiwayatPeriksaFisik(pendaftaran_id) {
		$('#periksafisik').addClass("animation-loading");
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('loadRiwayatPeriksaFisik'); ?>',
			data: {pendaftaran_id: pendaftaran_id},
			dataType: "json",
			success: function (data) {
				$('#periksafisik table > tbody').html(data.rows);
				$('#periksafisik table > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$('#periksafisik').removeClass("animation-loading");
				renameInputRowRiwayat($("#periksafisik"));
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function renameInputRowRiwayat(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > tr").each(function () {
			$(this).find('span').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			$(this).find('input,select,textarea').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			row++;
		});

		//====button visibility
		//init
		$(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().show();
		$(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().show();
		//set
		$(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
		$(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
		var rowCount = $(obj_table).find('tbody tr').length;
		if (rowCount == 1) {
			$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
			$(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
			id = $(obj_table).find('tr:first-child input[name*="[datapenunjang_id]"]').val();
			if (id != "") {
				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
			}
		}
		//====end button visibility

	}

    function cekListPeriksa(obj) {
        console.log('cek periksa di klik');

		$(obj).parents('table').find('tr').each(function () {
			$(this).find('input[name$="[isperiksafisik]"]').val(0);
			$(this).find('input[name$="[isperiksafisik]"]').prop('checked', false);
		});

		$(obj).val(1);
		$(obj).prop('checked', true);

		var periksa_id = $(obj).parents('tr').find('input[name$="[pemeriksaanfisik_id]"]').val();
		$('#PengkajianaskepT_pemeriksaanfisik_id').val(periksa_id);

	}

	function cekListAnamesa(obj) {

        console.log('cek anamnesa di klik');
		$(obj).parents('table').find('tr').each(function () {
			$(this).find('input[name$="[isanamesa]"]').val(0);
			$(this).find('input[name$="[isanamesa]"]').prop('checked', false);
		});

		$(obj).val(1);
		$(obj).prop('checked', true);

		var anamesa_id = $(obj).parents('tr').find('input[name$="[anamesa_id]"]').val();
		$('#PengkajianaskepT_anamesa_id').val(anamesa_id);

	}


function setPlanning() {
    
    $('.diagnosakep_tr1').each(function () {

        var diagnosa = $(this).val();
        var implementasi = [];

        $(this).closest('tr').find('.dt-indikator').each(function () {
            implementasi.push("- " + $(this).val());
        });

        console.log('cek implementasi ini:');
        console.log(implementasi);

        implementasi_join = implementasi.join('<br>');

        $('.diagnosa-tr3[value="' + diagnosa + '"]').closest('tr').find('.intv-checked-tr3').html('<b>' + implementasi_join + '</b>');


    });
}

function renameInputImplementasi()
    {
        var row = 0;
        $('#table-rencana').find("tbody > .rencanaaskepdet").each(function () {
            $(this).find("#table-tindakannya").each(function () {
                $(this).find("tbody").each(function () {
                    var row2 = 0;
                    var row3 = 0;
    
                    $(this).find('.impls').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 5) {
                            $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                            $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                        }
                        row3++;
    
                    });
    
                    $(this).find('.impls_id').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 5) {
                            $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                            $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                        }
                        row3++;
    
                    });
                    
                    $(this).find('input[name$="[indikatorimplkepdet_id]"]').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 5) {
                            $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                            $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                        }
                        row3++;
                    });

                    $(this).find('.implsdet').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 6) {
                            $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + row2 + "_" + old_name_arr[4]);
                            $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + row2 + "][" + old_name_arr[4] + "][indikatorimplkepdet_id]");
                        }
                        row2++;

                    });
                });
            });
            row++;
        });
    }
</script>