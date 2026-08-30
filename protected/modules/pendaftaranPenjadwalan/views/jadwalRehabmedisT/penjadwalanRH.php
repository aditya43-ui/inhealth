<style>
    .checkbox-inline {
        display: block;
        padding-left: 0;
        margin-left: 0 !important;
    }

    .checkbox-inline>input {
        float: none;
        margin: 5px 8px 0 0 !important;
    }

    label.checkbox {
        display: inline-block;
        width: 150px;
    }

    ul.classInline {
        display: inline-block;
        list-style: none;
    }

    ul.classInline li {
        display: inline-block;
        margin-right: 5px;
    }

    .beds {
        margin-top: -30px;
    }

    .icon-minus {
        margin-top: -15px;
        margin-left: 10px;
    }

    table .spans2 {
        float: none;
        margin-left: 0;
        width: 90px;
    }

    table .spans3 {
        float: none;
        margin-left: 0;
        width: 110px;
    }

    .lfloat {
        float: left;
    }

    .lclear {
        float: none;
        clear: both;
    }

    #batalForm {
        margin-left: 15px;
    }

    table .spanBed {
        float: none;
        margin-left: 0;
        width: 70px;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Buat Jadwal Rehab Medis',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b>
                <i class="glyphicon glyphicon-briefcase"></i> Buat Jadwal Rehab Medis</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data jadwal berhasil disimpan!");
        }
        ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penjadwalan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
        ?>
        <div class="row">
            <div class="col-sm-6">
                <div class='errorTable2'></div>
                <?php /*
                <div class="control-group">
                    <?php echo CHtml::label('Jadwal <span class="required">*</span>', 'Jadwal Hari',array('class' => 'control-label'));?>
                    <div class="controls">
                        <?php
                        echo CHtml::dropDownList('jadwalRH[IdHari]', '', CHtml::listData(PPJadwalhariM::model()->findAllByAttributes(array('jadwalhari_aktif' => true)), 'jadwalhari_id', 'jadwalhari_nama'), array('empty' => '-- Pilih --',
                            'id' => 'IdHari',
                            'onchange' => '$("#inputForm").html("");',
                            'ajax' => array('url' => $this->createUrl('ajaxListHari'),
                                'type' => 'POST',
                                'update' => '#inputHari')
                        ));
                        ?>
                    </div>
                </div>
                 * 
                 */ ?>
                <div class="control-group">
                    <?php echo CHtml::label('Kirim SMS', 'Jadwal Hari', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo CHtml::checkBox('jadwalRH[kirim_sms]', true) . ' <label>Pasien</label>';
                        ?>
                    </div>
                </div>
                <div class="control-group jadwalRH_hari_nama">
                    <?php echo CHtml::label('Hari <span class="required">*</span>', 'Jadwal Hari', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $arr_hari = array(
                            1 => "Senin",
                            2 => "Selasa",
                            3 => "Rabu",
                            4 => "Kamis",
                            5 => "Jumat",
                            6 => "Sabtu",
                            0 => "Minggu",
                        );
                        $idx = 0;
                        foreach ($arr_hari as $nilai => $item) {
                            $this->NamaHari($item, $nilai, $idx++);
                        }
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan <span class="required">*</span>', 'Ruangan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $type_list2 = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => Params::INSTALASI_ID_REHAB,
                            'ruangan_aktif' => true,
                        )), 'ruangan_id', 'ruangan_nama');
                        echo CHtml::checkBoxList('jadwalRH[ruangan]', $selected_Array2 = array(), $type_list2);
                        ?>
                    </div>
                </div>
                <div class="control-group" style='margin-left:120px;'>
                    <div class="controls">
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Buat Jadwal', array('{icon}' => '<i class="icon-list-alt icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onClick' => 'generateInput();')); ?>
                        &nbsp;
                        <?php
                        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('penjadwalanRH'), array('class' => 'btn btn-default'));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Shift <span class="required">*</span>', 'Shift', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $type_list = CHtml::listData(ShiftM::model()->findAllByAttributes(array('shift_aktif' => true), array('order' => 'shift_urutan ASC')), 'shift_id', 'shift_nama');
                        echo CHtml::checkBoxList('jadwalRH[shift]', $selected_Array = array(), $type_list);
                        ?>
                    </div>
                </div>
            </div>
            <div class="span12"></div>
            <div id='inputForm'></div>
        </div>
        <table style="width: 100%; border: none;">
            <?php
            if (isset($_GET['totalData'])) {
                $totalData = $_GET['totalData'];
                echo '<tr><td colspan="5" class="totalDataView">';
                //                echo $this->renderPartial($this->path_view . 'PrintPdf', array('model' => $model, 'totalData' => $totalData));
                echo '<br>';
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan jadwal', 'class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button', 'disabled' => true)
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl($this->module->id . "/" . $this->id . "/" . $this->action->id),
                    array('title' => 'Ulang', 'class' => 'btn btn-default')
                );
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')
                );
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $js = <<< JSCRIPT
function print(caraPrint)
{
	window.open("${urlPrint}"+"&totalData="+"${totalData}"+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                echo '</td></tr>';
            }
            ?>
            <tr>
                <!--<td colspan="5"><div id='inputForm'></div></td>-->
            </tr>
            <tr>
                <td colspan="5">
                    <div id='submitForm' class="lfloat">
                        <?php
                        //                                       echo  CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')),
                        //                                                    array('class'=>'btn btn-primary', 'type'=>'button','onsubmit'=>'return requiredCheck(this);'));
                        ?>
                    </div>
                    <div id='batalForm' class="lfloat">
                    </div>
                    <?php
                    if (@$_GET['totalData']) {
                    } else {
                    ?>
                        <div class="untukdisable">
                            <div class="lfloat">
                                <?php
                                echo CHtml::htmlButton(
                                    Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
                                    array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'title' => 'Simpan jadwal',  'type' => 'button', 'disabled' => true)
                                );
                                ?>
                            </div>
                            <div class="lfloat">
                                <?php
                                echo CHtml::link(
                                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                                    Yii::app()->createUrl($this->module->id . '/jadwalrehabmedisT/penjadwalanRH'),
                                    array('title' => 'Ulang', 'class' => 'btn btn-default')
                                );
                                ?>
                            </div>
                            <div class="lfloat">
                                &nbsp;
                                <?php
                                echo CHtml::htmlButton(
                                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                                    array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)
                                );
                                ?>
                            </div>
                            <?php
                            $tips = array(
                                '0' => 'simpan',
                                '1' => 'ulang',
                                '2' => 'print',
                            );
                            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="lclear"></div>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function generateInput() {
        $('.totalDataView').hide();
        var idhari = $('#IdHari').val();
        var shiftId = $('#jadwalRH_shift').find("input[name*='shift']:checked").val();
        var ruanganId = $('#jadwalRH_ruangan').find("input[name*='ruangan']:checked").val();
        //	alert(shiftId);
        if (idhari != '') {
            if (shiftId == undefined) {
                myAlert('Mohon pilih Shift!');
            } else {
                if (ruanganId == undefined) {
                    myAlert('Mohon pilih Ruangan!');
                } else {
                    $.post('<?php echo $this->createUrl('ajaxGenerateInputForm') ?>', $('#penjadwalan-form').serialize(), function(data) {
                        $('#inputForm').html(data.form);
                        $('#submitForm').html(data.submit);
                        $('#batalForm').html(data.batal);
                    }, 'json');
                    $('.untukdisable').hide();
                }
            }
        } else {
            myAlert('Mohon pilih Jadwal Hari!');
        }
    }

    function insertInputJadwal(idTabel, idShift, idRuangan, Ruangan, obj) {
        parent = $(obj).parents("#tabelForm_" + idTabel + " tr td");
        //    var jmlBaris = parent.find(".inputDokter").length; //komen RSSP-269
        var jmlBaris = 0;
        $("#tabelForm_" + idTabel + " tr td #div_" + idTabel + "_" + idShift + "_" + idRuangan + "").find("input[name*='no_urut']").each(function() { // RSSP-269
            if (jmlBaris == 0)
                jmlBaris++;
            jmlBaris = parseInt(jmlBaris) + parseInt($(this).val());
        });
        var input = '';
        $.post("<?php echo $this->createUrl('ajaxListBed') ?>", {
            id_Ruangan: Ruangan,
            idTabel: idTabel,
            idShift: idShift,
            idRuangan: idRuangan,
            jmlBaris: jmlBaris
        }, function(data) {
            //		input += '<li><div class="input-append"><input type="text" class="spans3" name="jadwalRehab[jadwal]['+idTabel+'][shift]['+idShift+'][ruangan_id]['+idRuangan+'][namapasien]['+jmlBaris+']" id="namaPasien_'+idTabel+'_'+idShift+'_'+idRuangan+'_'+jmlBaris+'" style="float:left;" onkeypress="return $(this).focusNextInputField(event)" class="ui-autocomplete-input" autocomplete="on" role="textbox" aria-autocomplete="list" aria-haspopup="true"><span class="add-on"><a href="javascript:void(0);" id="" onclick="setDialog(this);"><i class="icon-list"></i><i class="entypo-search"></i></a></span></div></li>'; // komen . jangan disini, render lewat controller RSSP-269
            input += '<li>' + data.input + '</li>';
            input += '<input type="hidden" class="span1" name="jadwalRehab[jadwal][' + idTabel + '][shift][' + idShift + '][ruangan_id][' + idRuangan + '][no_urut][' + jmlBaris + ']" value=' + jmlBaris + ' > '; // RSSP-269
            input += '<input type="hidden" class="span1" name="jadwalRehab[jadwal][' + idTabel + '][shift][' + idShift + '][ruangan_id][' + idRuangan + '][pasien_id][' + jmlBaris + ']">';
            input += '<li><input type="text" class="spans2 beds" name="jadwalRehab[jadwal][' + idTabel + '][shift][' + idShift + '][ruangan_id][' + idRuangan + '][jeniskelamin]" disabled></li>';
            input += '<li><a href="javascript:void(0)" onclick="removeThis(this)" title"Batalkan pasien"><i class="icon icon-minus"></i></a></li>';
            input = '<ul class="div_' + idTabel + '_' + idShift + '_' + jmlBaris + ' classInline">' + input + '</ul>';
            if (parent.find(""))
                $('#div_' + idTabel + '_' + idShift + '_' + idRuangan).append(input);
            id_autocomplete = 'jadwalRehab_jadwal_' + idTabel + '_shift_' + idShift + '_ruangan_id_' + idRuangan + '_namapasien_' + jmlBaris + ''; // RSSP-269
            jQuery('#' + id_autocomplete + '').autocomplete( // RSSP-269
                {
                    'showAnim': 'fold',
                    'minLength': 2,
                    'focus': function(event, ui) {
                        $(this).val(ui.item.nama_pasien);
                        return false;
                    },
                    'select': function(event, ui) {
                        $(this).parents('ul').find("input[name*='jeniskelamin']").val(ui.item.jeniskelamin);
                        $(this).parents('ul').find("input[name*='pasien_id']").val(ui.item.value);
                        return false;
                    },
                    'source': function(request, response) {
                        $.ajax({
                            url: "<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/jadwalrehabmedisT/AutoCompletePasien'); ?>",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function(data) {
                                response(data);
                            }
                        })
                    }
                }
            );
            $('#jadwalRehab_' + idTabel + '_' + idShift + '_' + idRuangan + '_' + jmlBaris).html(data.options);
            cekDisabled('form');
        }, 'json');
    }

    function setDialog(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogPasien";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }

    function checkValidasi() {
        var ceknama = true;
        var cekbed = true;
        $("input[name*='namapasien']").each(function() {
            var isinama = $(this).val();
            if (isinama != '') {
                ceknama = false;
            }
        });
        $("select[name*='bed']").each(function() {
            var isibed = $(this).val();
            if (isibed != '' && isibed != null) {
                cekbed = false;
            }
        });
        if (ceknama == true) {
            myAlert('Nama Pasien atau data masih ada yang kosong!');
            return false;
        }
        return true;
    }

    function clientValidationFunc(obj) {
        url = $("form").attr("action");
        error = "<div class='alert alert-block alert-error blockAlert'><p>Silakan perbaiki kesalahan input berikut:</p><ul></ul></div>";
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: $("form").serialize(),
            success: function(result) {
                myAlert('Jadwal Berhasil dibuat!');
                if (result.error == 'no') {
                    $("form").submit();
                } else {
                    myAlert('Silakan isikan data yang belum lengkap dan buat jadwal terlebih dahulu!')
                    $("form").find(".error").removeClass("error");
                    $(".errorTable .blockAlert").remove();
                    $(".errorTable2 .blockAlert").remove();
                    for (var i in result.error) {
                        $('[name="' + i + '"]').addClass("error");
                        for (var x = 0; x < result.error[i].length; x++) {
                            if ($('[name="' + i + '"]').parents(".tableJadwal tr td").find(".errorTable .blockAlert").length < 1) {
                                $('[name="' + i + '"]').parents(".tableJadwal tr td").find(".errorTable").append(error);
                                $('[name="' + i + '"]').parents(".tableJadwal tr td").find(".errorTable ul").append('<li>' + result.error[i][x] + '</li>');
                            } else {
                                $('[name="' + i + '"]').parents(".tableJadwal tr td").find(".errorTable ul").append('<li>' + result.error[i][x] + '</li>');
                            }
                        }
                    }
                    if (result.error2.length > 0) {
                        for (var i = 0; i < result.error2.length; i++) {
                            $('[name="' + result.error2[i] + '"]').addClass("error");
                            if ($('form table tr:first').find(".errorTable2 .blockAlert").length < 1) {
                                $('form table tr:first').find(".errorTable2").append(error);
                                $('form table tr:first').find(".errorTable2 ul").append('<li>' + result.error2[i] + '</li>');
                            } else {
                                $('form table tr:first').find(".errorTable2 ul").append('<li>' + result.error2[i] + '</li>');
                            }
                        }
                    }
                }
                $('#inputForm').html('');
            }
        });
    }

    function removeThis(obj) {
        $(obj).parents(".classInline").remove();
    }

    function setTindakanAuto(pasien_id) {
        dialog = "#dialogPasien";
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        var tanggal1 = $(obj).parents('table').prev().find("input[name*='jadwalrehabmedis_tgl']").val();
        var tanggal2 = $(obj).parents('table').find("input[name*='jadwalrehabmedis_tgl']").val();
        var idpasien3 = $(obj).parents('table').prevAll().find("input[name*='pasien_id']");
        var idpasien = $(obj).parents('ul').prev().find("input[name*='pasien_id']").val();
        var idpasien2 = $(obj).parents('ul').prevAll().find("input[name*='pasien_id']");
        var datanya = 0;
        $.get('<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/jadwalrehabmedisT/infoPasien'); ?>', {
            pasien_id: pasien_id
        }, function(data) {
            if (data.pasien != idpasien) {
                idpasien2.each(function() {
                    if ($(this).val() == data.pasien) {
                        if (tanggal1 == tanggal2) {
                            datanya = 1;
                        }
                    }
                });
                //			if(tanggal1 == tanggal2){
                //				idpasien3.each(function() {
                //					if($( this ).val() == data.pasien){
                //						datanya = 1;
                //					}
                //				});
                //			}
                if (datanya != 1) {
                    $(obj).parents('ul').find("input[name*='pasien_id']").val(data.pasien);
                    $(obj).parents('ul').find("input[name*='namapasien']").val(data.namapasien);
                    $(obj).parents('ul').find("input[name*='jeniskelamin']").val(data.jeniskelamin);
                    cekDisabled('form');
                } else {
                    myAlert('Pasien Sudah diplih pada tanggal ini');
                }
            } else {
                myAlert('Pasien Sudah diplih sebelumnya');
            }
        }, "json");
        $(dialog).dialog("close");
    }
    $(document).ready(function() {
        $('form').bind('click keyup select change', function(event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function() {
            cekDisabled('form');
        });
        cekDisabled('form');
        <?php if (isset($_GET['sukses'])) { ?>
            $('form').find("input,select,textarea").attr("disabled", true);
        <?php } ?>
    });
</script>
<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
//========= Dialog buat cari data Pasien=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 350,
        'resizable' => false,
    ),
));
$modPasien = new PPPasienM('searchDialogPasienHD');
if (isset($_GET['PPPasienM'])) {
    $modPasien->attributes = $_GET['PPPasienM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modPasien->searchDialogPasienHD(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "
													setTindakanAuto($data->pasien_id);  
                                                                                                        cekDisabled(\'form\'); 
                                                "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'tanggal_lahir',
        'alamat_pasien',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        }',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>