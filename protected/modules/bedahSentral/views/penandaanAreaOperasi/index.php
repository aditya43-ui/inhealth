<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'terdugatb-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#RKAnamnesaT_keluhanutama_annoninput .maininput',
));
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                Penandaan Area Operasi
            </div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial('_row_1', array('form' => $form, 'pendaftaran' => $pendaftaran, 'jenis' => $jenis)); ?>
            <?php 
                $this->renderPartial('_row_2', array(
                    'form' => $form, 
                    'gambartubuh_id' => $gambartubuh_id,
                    'pendaftaran' => $pendaftaran, 
                    'jenis' => $jenis,
                    'modBagianTubuh' => $modBagianTubuh, 
                    'modGambarTubuh' => $modGambarTubuh,
                    'modPasien' => $modPasien, 
                    'modAreaOperasi' => $modAreaOperasi, 
                    'modAreaDetOp' => $modAreaDetOp, 
                )); 
            ?>
            <?php
                if(($jenis == 'lihat')){
                    echo CHtml::link('Kembali', $this->createUrl('index', array('pendaftaran_id' => $_GET['pendaftaran_id'])), array(
                        'class'=>'btn btn-danger'
                    )); 
                } else {
            ?>
            <?php
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('title' => 'Simpan', 'class' => 'btn btn-success', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    );
            ?>
            <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl('jurnalRekPenjamin/admin'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-warning',
                            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );
                }
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
    function requiredCheck(obj) {
        var kosong = 0;
        $(obj).find('input,select,textarea').each(function() {
            if ($(this).parents(".control-group").find("label").hasClass('required') === true) {
                $(this).parents(".control-group").removeClass("error").removeClass("success");
            }
        });
        $(obj).find('input,select,textarea').each(function() {
            if ($(this).parents(".control-group").find("label").hasClass('required') === true || $(this).hasClass('required')) {
                if (($(this).val() === "") && !$(this).is(":disabled")) {
                    if ($(this).is(":hidden")) { //untuk element type:hidden 
                        var radio_checked = false;
                        $(this).parent().find(".radio").each(function () { //mengecek element radio button
                            if ($(this).find("input").is(":checked")) {
                                radio_checked = true;
                            }
                        });
                        if (radio_checked == false) {
                            $(this).parents(".control-group").addClass("error");
                            $(this).addClass("error");
                            kosong++;
                            console.log($(this));
                        } else {
                            $(this).parents(".control-group").removeClass("error");
                            $(this).removeClass("error");
                        }
                    } else {
                        $(this).parents(".control-group").addClass("error");
                        $(this).addClass("error");
                        console.log($(this));
                        kosong++;
                    }
                } else {
                    $(this).parents(".control-group").removeClass("error");
                    $(this).removeClass("error");
                }
            }
        });
        if (kosong > 0) {
            window.parent.myAlert("Silahkan isi yang bertanda bintang <span class='required'>*</span> !"); //("+kosong+" input)
            return false;
        } else {
            return true;
        }
    }

    function renameInputRow(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find("#no_urut").val(row+1);
            $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
                var new_name = $(this).attr("name").replace("ii",(row));
                $(this).attr("name",new_name);
            });
            $(this).find('span[name$="[operasi_nama]"]').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 2){
                    $(this).attr("name","["+row+"]["+old_name_arr[1]+"]");
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                console.log(old_name, old_name_arr, old_name_arr.length);
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
                if(old_name_arr.length == 4){
                    $(this).attr("id",old_name_arr[0]+"_" + old_name_arr[1] + "_"+row+"_"+old_name_arr[3]);
                    $(this).attr("name",old_name_arr[0]+"[" + old_name_arr[1] + "]["+row+"]["+old_name_arr[3]+"]");
                }
            });
            row++;
        });
        
    }
</script>
<!-- open dialog petugas OK -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPetugasOK',
        'options' => array(
            'title' => 'Daftar Petugas Kamar Operasi',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modPeg = new PegawaiM('search');
    $modPeg->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modPeg->pegawai_aktif = true;
    // $modPeg->unsetAttributes();
    if (isset($_GET['PegawaiM'])) {
        $modPeg->attributes = $_GET['PegawaiM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'petugasOK-m-grid',
        'dataProvider' => $modPeg->search(),
        'filter' => $modPeg,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
                "id" => "selectPetugasOK",
                "onClick" => "
                    $(\'.petugasok_id\').val($data->pegawai_id);
                    $(\'.petugasok_nama\').val(\'$data->namaLengkap\');
                    $(\'#dialogPetugasOK\').dialog(\'close\');
                    return false;"
                    ))',
            ),
            'nomorindukpegawai',
            [
                'header'=>'Nama',
                'name'=>'nama_pegawai',
                'value'=>'$data->namaLengkap'
            ],
            
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
?>
<!-- open dialog petugas RI -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPetugasRI',
        'options' => array(
            'title' => 'Daftar Petugas Rawat Inap',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modPeg = new PegawaiM('search');
    $modPeg->instalasi_id = 4;
    $modPeg->pegawai_aktif = true;
    // $modPeg->unsetAttributes();
    if (isset($_GET['PegawaiM'])) {
        $modPeg->attributes = $_GET['PegawaiM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'petugasRI-m-grid',
        'dataProvider' => $modPeg->search(),
        'filter' => $modPeg,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
                "id" => "selectPetugasRI",
                "onClick" => "
                    $(\'.pertugasrawatinap_id\').val($data->pegawai_id);
                    $(\'.pertugasrawatinap_nama\').val(\'$data->namaLengkap\');
                    $(\'#dialogPetugasRI\').dialog(\'close\');
                    return false;"
                    ))',
            ),
            'nomorindukpegawai',
            [
                'header'=>'Nama',
                'name'=>'nama_pegawai',
                'value'=>'$data->namaLengkap'
            ],
            
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
?>