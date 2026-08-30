<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saruangan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#SARuanganM_instalasi_id',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));

$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model, $modRiwayatRuangan); ?>
<?php //echo CJSON::encode($model); ?>

<div class="row multi hide">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'instalasi_id',  CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'ruangan_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'ruangan_namalainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'ruangan_singkatan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'ruangan_lokasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php //echo $form->textFieldRow($model, 'kode_bpjs', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <div class="control-group">
            <label class="control-label">Kode BPJS</label>
            <div class="controls">
                <?php echo $form->textField($model,'kode_bpjs',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::htmlButton('<i class="entypo-search"></i>',
                        array('onclick'=>'$("#dialogKodeBpjs").dialog("open"); return false;',
                                  'class'=>'btn btn-mini btn-primary',
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk mencari data Kode BPJS")); ?>
            </div>
        </div>

        <?php echo $form->dropDownListRow($model, 'modul_id',  CHtml::listData(ModulK::model()->findAll(array(
            'condition' => 'modul_aktif = true',
            'order' => 'modul_nama'
        )), 'modul_id', 'modul_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'estimasipelayanan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->dropDownListRow($model, 'ruangan_filesuara', SARuanganM::getFileSuaraAntrian(), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>

        <div class="control-group">
            <label class="control-label">Browse File</label>
            <div class="controls">
                <?php echo Chtml::activeFileField($model, 'ruangan_image', array('maxlength' => 254, 'Hint' => 'Isi Jika Akan Menambahkan Logo', 'placeholder' => $model->getAttributeLabel('ruangan_image'))); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'is_klinikanak', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?><label>Klinik Anak</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'is_jiwa', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?><label>Klinik Jiwa</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'is_saraf', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?><label>Klinik Saraf</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'is_nicu', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?><label>NICU</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'is_tindakan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?><label>Ruangan Tindakan</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'ruangan_aktif', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?><label>Aktif</label>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Jenis Kasus Penyakit', array('class' => 'control-label required')); ?>
            <div class="controls multi hide">

                <?php
                $arrJenisKasusPenyakit = array();
                foreach ($modKasusPenyakitRuangan as $jenisKasusPenyakit) {
                    $arrJenisKasusPenyakit[] = $jenisKasusPenyakit['jeniskasuspenyakit_id'];
                }
                $this->widget(
                    'application.extensions.emultiselect.EMultiSelect',
                    array('sortable' => true, 'searchable' => true)
                );
                echo CHtml::dropDownList(
                    'jeniskasuspenyakit_id[]',
                    $arrJenisKasusPenyakit,
                    CHtml::listData(SAJenisKasusPenyakitM::model()->findAll(array('order' => 'jeniskasuspenyakit_nama')), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'),
                    array('multiple' => 'multiple', 'key' => 'jeniskasuspenyakit_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                );
                ?>

            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Kelas Pelayanan', array('class' => 'control-label required')); ?>
            <div class="controls multi hide">

                <?php
                $arrKelasRuangan = array();
                foreach ($modKelasRuangan as $jenisKelasRuangan) {
                    $arrKelasRuangan[] = $jenisKelasRuangan['kelaspelayanan_id'];
                }
                $this->widget(
                    'application.extensions.emultiselect.EMultiSelect',
                    array('sortable' => true, 'searchable' => true)
                );
                echo CHtml::dropDownList(
                    'kelaspelayanan_id[]',
                    $arrKelasRuangan,
                    CHtml::listData(SAKelasPelayananM::model()->findAll(array('order' => 'kelaspelayanan_nama')), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                    array('multiple' => 'multiple', 'key' => 'kelaspelayanan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                );
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Pegawai', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php

                $arrRuanganPegawai = array();
                foreach ($modRuanganPegawai as $dataRuanganPegawai) {
                    if (!empty($dataRuanganPegawai['pegawai_id'])) {
                        $arrRuanganPegawai[] = $dataRuanganPegawai['pegawai_id'];
                    }
                }
                $this->widget(
                    'application.extensions.emultiselect.EMultiSelect',
                    array('sortable' => true, 'searchable' => true)
                );
                echo CHtml::dropDownList(
                    'pegawai_id[]',
                    $arrRuanganPegawai,
                    CHtml::listData(SAPegawaiM::model()->findAll(array('condition' => 'pegawai_aktif = true', 'order' => 'nama_pegawai')), 'pegawai_id', 'namaLengkap'),
                    array('multiple' => 'multiple', 'key' => 'pegawai_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                );
                ?>
            </div>
        </div>
   
    </div>
</div>
   
        <?php //echo $form->textFieldRow($modRiwayatRuangan,'tglpenetapanruangan',array('class'=>'inputRequire','style'=>'width: 124px;','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,)); 
        ?>
        <?php //echo $form->textField($modRiwayatRuangan,'nopenetapanruangan',array('class'=>'inputRequire','style'=>'width: 124px;','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$modRiwayatRuangan->getAttributeLabel('nopenetapanruangan'))); 
        ?>
        <?php //echo $form->textField($modRiwayatRuangan,'tentangpenetapan',array('class'=>'inputRequire','style'=>'width: 124px;','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$modRiwayatRuangan->getAttributeLabel('tentangpenetapan'))); 
        ?>


<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        '',
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Ruangan', array('{icon}' => '<i class="icon-file icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>



<?php
/* ====================================== Widget Dialog Penjamin ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));

$modPegawai = new PegawaiM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawaiM'])) {
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'grouplayanan-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modPegawai->searchPegawai(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link(
                    "<i class='icon-form-check'></i>",
                    "javascript:;",
                    array(
                        "class" => "btn-small",
                        "id" => "selectpegawai",
                        "onclick" => '
                        setPegawai(' . $data->pegawai_id . ',"' . $data->nama_pegawai . '");	
                                        $("#dialogPegawai").dialog("close");'

                    )
                );
            },
        ),
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            // $("#pegawai_id").val($("#nama_pegawai").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Group Layanan ====================================== */
?>



<?php
/* ====================================== Widget Dialog Penjamin ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTindakan',
    'options' => array(
        'title' => 'Pencarian Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));

$modTindakan = new DaftartindakanM('search');
$modTindakan->unsetAttributes();
if (isset($_GET['DaftartindakanM'])) {
    $modTindakan->attributes = $_GET['DaftartindakanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'grouplayanan-grid2',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modTindakan->searchDialog2(),
    'filter' => $modTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link(
                    "<i class='icon-form-check'></i>",
                    "javascript:;",
                    array(
                        "class" => "btn-small",
                        "id" => "selectTindakan",
                        "onclick" => '
                        setTindakan(' . $data->daftartindakan_id . ',"' . $data->daftartindakan_nama . '");	
                                        $("#dialogTindakan").dialog("close");'

                    )
                );
            },
        ),
        'daftartindakan_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            // $("#daftartindakan_id").val($("#daftartindakan_nama").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Group Layanan ====================================== */
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKodeBpjs',
    'options' => array(
        'title' => 'Pencarian Kode Bpjs',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('_searchKodeBpjs',array('model'=>$model));
$this->endWidget();
?>

<script type="text/javascript">

function setTindakan(daftartindakan_id, daftartindakan_nama) {  // post data
        var daftartindakan_id = daftartindakan_id;
        var daftartindakan_nama = daftartindakan_nama;

        if (cekData(daftartindakan_id) == true) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('addTindakan'); ?>',
                data: {
                    daftartindakan_id: daftartindakan_id,
                    daftartindakan_nama: daftartindakan_nama
                }, //
                dataType: "json",
                success: function(data) {
                    if (data.sukses != 0) {

                        $("#jenis-tindakan").find("tbody").append(data.tr);
                        generateTindakan($('#jenis-tindakan').find('tbody'));
                        // renameInputRow($("#jenis-tindakan"), 'tindakan');
                    } else {
                        myAlert(data.pesan);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            myAlert("Data Sudah Ditambahkan pada Tabel Daftar Tindakan", "Perhatian");
            return false;
        }
    }

    function generateTindakan(obj) {
        for (var i = 0; i < $(obj).find('.daftarTindakanlist').length; i++) {
            console.log(i);
            var trRow = $(obj).find('.daftarTindakanlist').eq(i);
            trRow.attr('id', 'SADaftarTindakanM_tindakan_' + i + '_daftartindakan_id');
            trRow.attr('name', 'SADaftarTindakanM[tindakan][' + i + '][daftartindakan_id]');
        }
    }

    function generatePegawai(obj) {
        for (var i = 0; i < $(obj).find('.daftarPegawailist').length; i++) {
            console.log(i);
            var trRow = $(obj).find('.daftarPegawailist').eq(i);
            trRow.attr('id', 'SARuanganM_pegawai_' + i + '_pegawai_id');
            trRow.attr('name', 'SARuanganM[pegawai][' + i + '][pegawai_id]');
        }
    }

    function setPegawai(pegawai_id, nama_pegawai) {
        var pegawai_id = pegawai_id;
        var nama_pegawai = nama_pegawai;

        if (cekData2(pegawai_id) == true) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('addPegawai'); ?>',
                data: {
                    pegawai_id: pegawai_id,
                    nama_pegawai: nama_pegawai
                }, //
                dataType: "json",
                success: function(data) {
                    if (data.sukses != 0) {
                        $("#jenis-pegawai").find("tbody").append(data.tr);
                        generatePegawai($('#jenis-pegawai').find('tbody'));
                    } else {
                        myAlert(data.pesan);
                    }
                    $("#SARuanganpegawaiM_nama_pegawai").val('');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            myAlert("Data Sudah Ditambahkan pada Tabel Daftar Pegawai", "Perhatian");
            return false;
        }
    }


    function renameInputRow2(obj_table, get) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("nama_pegawai").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr.length == 4) {
                    $(this).attr("pegawai_id", old_name_arr[0] + "_" + get + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("nama_pegawai", old_name_arr[0] + "[" + get + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });
            row++;
        });
    }




    function renameInputRow(obj_table, get) {  //cek row input
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("daftartindakan_id").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr.length == 4) {
                    $(this).attr("daftartindakan_id", old_name_arr[2] + "_" + get + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("daftartindakan_nama", old_name_arr[2] + "[" + get + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });
            row++;
        });
    }


    function hapusBaris2(obj) {

myConfirm(" Apakah Anda yakin akan menghapus/membatalkan data ini?", " Perhatian ", function(r) {
    if (r) {
        $(obj).parents('tr').detach();
        renameInputRow($("#jenis-pegawai"), 'pegawai');
    } else {
        return false;
    }
})

}

    function hapusBaris(obj) {

        myConfirm(" Apakah Anda yakin akan menghapus/membatalkan data ini?", " Perhatian ", function(r) {
            if (r) {
                $(obj).parents('tr').detach();
                renameInputRow($("#jenis-tindakan"), 'tindakan');
            } else {
                return false;
            }
        })

    }

    function cekData(daftartindakan_id) {  //cek data
        var ok = true;
        $($("#jenis-tindakan")).find("tbody > tr").each(function() {
            $(this).find("td").attr("style", "");

            if ($(this).find(".daftarTindakan").val() == daftartindakan_id) {
                $(this).find("td").attr("style", "border:1px solid red !important;");
                ok = ok && false;
            } else {
                ok = ok && true;
            }
        });

        if (ok == true) {
            return true;
        } else {
            return false;
        }
    }


    function cekData2(pegawai_id) {
        var ok = true;
        $($("#jenis-pegawai")).find("tbody > tr").each(function() {
            $(this).find("td").attr("style", "");

            if ($(this).find(".daftarPegawai").val() == pegawai_id) {
                $(this).find("td").attr("style", "border:1px solid red !important;");
                ok = ok && false;
            } else {
                ok = ok && true;
            }
        });

        if (ok == true) {
            return true;
        } else {
            return false;
        }
    }



    function namaLain(nama) {
        document.getElementById('SARuanganM_1_ruangan_namalainnya').value = nama.value.toUpperCase();
    }

    $(document).ready(function () {

        setTimeout(() => {

            $('.multi').removeClass('hide');
            
        }, 1000);
        
    });
</script>