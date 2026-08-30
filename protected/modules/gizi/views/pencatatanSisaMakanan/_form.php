<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sisamakananpasien-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
    ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<?php echo $this->renderPartial($this->path_view."_infoPasien", array(
    'form'=>$form, 'model'=>$model, 'kunjungan'=>$kunjungan,
), true); ?>
<?php 
echo $this->renderPartial($this->path_view."_riwayat", array(
    'form'=>$form, 'model'=>$model, 'kunjungan'=>$kunjungan,
), true); ?>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tambah Pencatatan Sisa Makanan Rumah Sakit (Comstok/Recal)</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'hariperawatke', array('class' => 'span1 integer', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

                <div class="control-group ">
                    <?php echo $form->label($model, 'auditor_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenfield($model, 'auditor_id', array('class' => 'auditor_id')); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'auditor_nama',
                            'value' => empty($model->auditor) ? "" : $model->auditor->namaLengkap,
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutocompleteAuditor') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                        $("#' . CHtml::activeId($model, 'auditor_id') . '").val(ui.item.pegawai_id); 
                                        return false;
                                    }',
                            ),
                            'htmlOptions' => array('class' => 'span3'),
                            'tombolDialog' => array('idDialog' => 'dialogAuditor'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tgl_audit', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_audit',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('class' => 'dtPicker2 span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'jam_audit', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jam_audit',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('class' => 'dtPicker2 span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'jenisdiet_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'jenisdiet_id', array('class' => 'span3 integer jenisdiet_id', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'jenisdiet_nama',
                            'value' => empty($model->jenisdiet) ? "" : $model->jenisdiet->jenisdiet_nama,
                            'sourceUrl' => $this->createUrl('autocompleteJenisDiet'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'select' => 'js:function( event, ui ) {
                                          $(".jenisdiet_id").val(ui.item.jenisdiet_id);
                                          $(".jenisdiet_nama").val(ui.item.jenisdiet_nama);
                                          return false;
                                    }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "if(event.keyCode == 13 ){submitDietPasien();}return $(this).focusNextInputField(event)",
                                //                                            'onclick'=>'submitObat(); return false;',
                                'class' => 'span3 jenisdiet_nama',
                                'placeholder' => 'Ketikan Jenis Diet',
                            ), 'tombolDialog' => array('idDialog' => 'dialogJenisDiet'),
                        ));
                        ?>   
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <?php
                $diagnosa_utama = "";
                $diagnosa_penyerta = "";

                if (!empty($kunjungan)) {
                    $diagnosa_utama_data = PasienmorbiditasT::model()->findByAttributes(array(
                        'pendaftaran_id' => $kunjungan->pendaftaran_id,
                        'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
                    ));
                    $diagnosa_penyerta_data = PasienmorbiditasT::model()->findByAttributes(array(
                        'pendaftaran_id' => $kunjungan->pendaftaran_id,
                        'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_TAMBAH,
                    ));

                    if (!empty($diagnosa_utama_data)) {
                        $diagnosa_utama = empty($diagnosa_utama_data->diagnosa) ? "" : ($diagnosa_utama_data->diagnosa->diagnosa_kode." - ".$diagnosa_utama_data->diagnosa->diagnosa_nama);
                    }
                    if (!empty($diagnosa_penyerta_data)) {
                        $diagnosa_penyerta = empty($diagnosa_penyerta_data->diagnosa) ? "" : ($diagnosa_penyerta_data->diagnosa->diagnosa_kode." - ".$diagnosa_penyerta_data->diagnosa->diagnosa_nama);
                    }
                }
                ?>
                <u>Diagnosa:</u>
                <div class="control-group">
                    <label class='control-label'>Utama</label>
                    <div class='controls'>
                        <?php echo CHtml::textArea('diagnosa_utama', $diagnosa_utama, array('readonly'=>true, 'class'=>'span3', 'rows'=>4)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class='control-label'>Penyerta</label>
                    <div class='controls'>
                        <?php echo CHtml::textArea('diagnosa_penyerta', $diagnosa_penyerta, array('readonly'=>true, 'class'=>'span3', 'rows'=>4)); ?>
                        
                    </div>
                </div>
                <?php echo $form->dropDownListRow($model, 'tipediet_id', CHtml::listData(TipeDietM::model()->findAll('tipediet_aktif = true order by tipediet_nama'), 'tipediet_id', 'tipediet_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
            <div class="col-sm-6">
                <div class='control-group'>
                    <?php echo $form->labelEx($model, 'sisamakanan_image', array('class' => 'control-label', 'onkeypress' => "return nextFocus(this,event)")) ?>
                    <?php if (!empty($model->sisamakanan_image)) { ?>
                        <img src="<?php echo Params::urlPromoDirectory() . $model->sisamakanan_image ?> " style="width: 20%;padding:10px;display: block;">
                    <?php } else {
                        echo "<span style='padding:10px 25px;'> Gambar Sisa Makanan Belum Diset</span>";
                    } ?>
                    <div class="controls">
                        <?php echo Chtml::activeFileField($model, 'sisamakanan_image', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Gambar Sisa Makanan')); ?>
                    </div>
                </div>
            </div>
        </div>
        


        <br/>
        <div class="panel panel-darkk" style="">
            <span class="group-title">
                Sisa Makanan
            </span>
            <div class="panel-body">
                <ol>
                    <?php
                    $jenis = JeniswaktuM::model()->findAllByAttributes(array(
                        'jeniswaktu_aktif' => true,
                        ), array(
                        'order' => 'urutan',
                    ));

                    $persen = PersensisamakananM::model()->findAllByAttributes(array(
                        'persensisamakanan_aktif' => true,
                        ), array(
                        'order' => 'urutan'
                    ));

                    $list_persen = CHtml::listData($persen, 'persensisamakanan_id', 'persensisamakanan_nama');
                    $option_persen = array();
                    foreach ($persen as $item) {
                        $option_persen[$item->persensisamakanan_id] = array(
                            'data-skor' => in_array($item->persensisamakanan_nama, array('25 % (1/4 Porsi)', '0 % (0 Porsi)')) ? 1 : 0,
                        );
                    }


                    foreach ($jenis as $item):
                        $makanan = JenismakananM::model()->findAllByAttributes(array(
                            'jeniswaktu_id' => $item->jeniswaktu_id,
                            ), array(
                            'order' => 'urutan'
                        ));

                        if (count($makanan) == 0) {
                            continue;
                        }
                        ?>
                        <li><?php echo $item->jeniswaktu_nama ?><br/>
                            <ul>
                                <?php
                                foreach ($makanan as $item2):

                                    if ($model->isNewRecord) {
                                        $det = new SisamakananpasiendetT;
                                        $det->jenismakanan_id = $item2->jenismakanan_id;
                                    } else {
                                        $det = SisamakananpasiendetT::model()->findByAttributes(array(
                                            'sisamakananpasien_id' => $model->sisamakananpasien_id,
                                            'jenismakanan_id' => $item2->jenismakanan_id,
                                        ));

                                        if (empty($det)) {
                                            $det = new SisamakananpasiendetT;
                                            $det->jenismakanan_id = $item2->jenismakanan_id;
                                        }
                                    }
                                    ?>
                                    <li>
                                        <?php echo $item2->jenismakanan_nama ?><br/>
                                        <div class="control-group persensisamakanan_base">
                                            <?php echo $form->labelEx($det, 'persensisamakanan_id', array('class' => 'control-label')); ?>
                                            <div class="controls">
                                                <?php
                                                foreach ($persen as $persen_item) {
                                                    echo '<div class="radio-inline">';
                                                    echo $form->radioButton($det, '[' . $det->jenismakanan_id . ']persensisamakanan_id', array(
                                                        'value' => $persen_item->persensisamakanan_id, 'class' => 'persensisamakanan_id', 'uncheckValue'=>null, 'data-skor' => in_array($persen_item->persensisamakanan_nama, array('25 % (1/4 Porsi)', '0 % (0 Porsi)')) ? 1 : 0,
                                                    )) . CHtml::label($persen_item->persensisamakanan_nama, '');
                                                    echo '</div>';
                                                };
                                                ?>
                                            </div>
                                        </div>
                                        <?php echo $form->textAreaRow($det, '[' . $det->jenismakanan_id . ']keterangan', array('class' => 'span4', 'rows' => 4)); ?>
                                    </li>


                                <?php endforeach; ?>
                            </ul>
                        </li>

                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
        <br/>
        <div class="panel panel-darkk" style="">
            <span class="group-title">
                Audit Score
            </span>
            <div class="panel-body">
                <?php echo $form->textFieldRow($model, 'jml_jenismenu', array('class' => 'span1 jml_jenismenu', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'jml_4dan5', array('class' => 'span1 jml_4dan5', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'auditscore_persen', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'auditscore_persen', array('class' => 'span1 auditscore_persen', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <a href="javascript:;" class="nohover" rel="tooltip" title="Rumus = (Total Sisa Makanan 25% dan Sisa Makanan 0% : Jumlah Jenis Menu) x 100%" data-html=">true"> <i class="<?php echo MyIcon::getIcons('info') ?>"></i></a>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kesimpulan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'kesimpulan', array('class' => 'span3 audit_kesimpulan', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <a href="javascript:;" class="nohover" rel="tooltip" title="Audi Score >= 20% = Terpenuhi<br/>Audit Score < 20% = Tidak Terpenuhi" data-html=">true"> <i class="<?php echo MyIcon::getIcons('info') ?>"></i></a>

                    </div>
                </div>



            </div>
        </div>

    </div>
</div>



<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('create'),
            array('class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);'));
        ?>
        <?php // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan SisamakananpasienT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>



<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogJenisDiet',
    'options' => array(
        'title' => 'Daftar Jenis Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 400,
        'resizable' => false,
    ),
));

$modJenisdietM = new JenisdietM('search');
$modJenisdietM->unsetAttributes();
$modJenisdietM->jenisdiet_aktif = true;
if (isset($_GET['JenisdietM'])) {
    $modJenisdietM->attributes = $_GET['JenisdietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jenisdiet-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modJenisdietM->search(),
    'filter' => $modJenisdietM,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                                "id" => "selectPasien",
                                                "onClick" => "$(\".jenisdiet_id\").val(\"$data->jenisdiet_id\");
                                                              $(\".jenisdiet_nama\").val(\"$data->jenisdiet_nama\");
                                                              $(\"#dialogJenisDiet\").dialog(\"close\");    
                                                    "))',
        ),
        array(
            'header' => 'Nama Jenis Diet',
            'name' => 'jenisdiet_nama',
            'type' => 'raw',
            'value' => '$data->jenisdiet_nama',
        ),
        array(
            'header' => 'Nama Lain Jenis Diet',
            'name' => 'jenisdiet_namalainnya',
            'type' => 'raw',
            'value' => '$data->jenisdiet_namalainnya',
        ),
        array(
            'header' => 'Keterangan',
            'name' => 'jenisdiet_keterangan',
            'type' => 'raw',
            'value' => '$data->jenisdiet_keterangan',
        ),
        array(
            'header' => 'Catatan',
            'name' => 'jenisdiet_catatan',
            'type' => 'raw',
            'value' => '$data->jenisdiet_catatan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAuditor',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new GZPegawairuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
//$modPegawai->ruangan_id = 0;
if (isset($_GET['GZPegawairuanganV']))
    $modPegawai->attributes = $_GET['GZPegawairuanganV'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzpegawairuangan-v-grid',
    'dataProvider' => $modPegawai->searchDialog(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
		array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "onclick" => "
                    $('.auditor_id').val(".$data->pegawai_id.");
                    $('#auditor_nama').val('".$data->namaLengkap."');
                    $('#dialogAuditor').dialog('close');
                    return false;
                "));
            },
		),
        'nama_pegawai',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),
        'alamat_pegawai',		
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>



<script>

    function hitungSisaMakanan() {
        var total = $(".persensisamakanan_base").length;
        var ceklis = 0;

        $(".persensisamakanan_id:checked").each(function () {
            ceklis += parseInt($(this).data('skor'));
        });

        var audit = ceklis * 100 / total;
        var kesimpulan = "";

        if (audit >= 20) {
            kesimpulan = "Terpenuhi";
        } else {
            kesimpulan = "Tidak Terpenuhi";
        }

        $(".jml_jenismenu").val(total);
        $(".jml_4dan5").val(ceklis);
        $(".auditscore_persen").val(formatFloat2(audit));
        $(".audit_kesimpulan").val(kesimpulan);
    }

    $(".persensisamakanan_id").on('click', hitungSisaMakanan);

    $(document).ready(function () {
        hitungSisaMakanan();
    });

</script>
