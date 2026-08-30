<?php
$this->breadcrumbs=array(
	'UnitDosis',
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'unitdosis-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onsubmit'=>'return cekInput();'),
)); ?>
<div class="white-container">
    <legend class="rim2">Unit <b>Dosis</b></legend>
    <fieldset class="box">
        <legend class="rim">Data Pasien</legend>
	<?php $this->renderPartial('_formInfoPasien',array('modInfoRI'=>$modInfoRI)); ?>
    </fieldset>
    <fieldset class="box">
        <legend class="rim">Unit Dosis</legend>
	<?php $this->renderPartial('_formUnitDosis',array('form'=>$form,'modUnitDosis'=>$modUnitDosis)); ?>
    </fieldset>
    <?php $this->endWidget(); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Dosis</b></h6>
        <table id="tblDaftarResep" class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align:center;">No</th>
                    <th rowspan="2" style="text-align:center;">Obat</th>
                    <th rowspan="2" style="text-align:center;">Satuan Kecil</th>
                    <th rowspan="2" style="text-align:center;">Dosis</th>
                    <th colspan="2" style="text-align:center;">Jumlah</th>
                    <th colspan="4" style="text-align:center;">Tanggal Intruksi</th>
                    <th rowspan="2" style="text-align:center;">Etiket</th>
                    <th rowspan="2" style="text-align:center;"></th>
                    <th style="text-align:center;display:none;" id="th_hari">Hari</th>
                </tr>
                <tr id="td_bawah">
                    <th style="text-align:center;">Hari</th>
                    <th style="text-align:center;">Obat</th>
                    <th style="text-align:center;">Mulai</th>
                    <th style="text-align:center;">Jam</th>
                    <th style="text-align:center;">Stop</th>
                    <th style="text-align:center;">Jam</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $trObat = $this->renderPartial('_rowObat',array('modUnitDosisDetail'=>$modUnitDosisDetail,'modUnitDosis'=>$modUnitDosis,'removeButton'=>true),true); 
                    echo $trObat;
                ?>
            </tbody>
        </table>
    </div>
    <?php // $this->renderPartial('_footerInputDosis',array('form'=>$form,'modUnitDosis'=>$modUnitDosis,'diagnosa'=>$diagnosa,'jenisdiet'=>$jenisdiet)); ?>
    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                        array('class' => 'btn btn-danger', 'type'=>'submit','onclick'=>'cekObat();return false;', 'onKeypress'=>'return formSubmit(this,event)' ,'')); ?>
            <?php				
			$content = $this->renderPartial('../tips/tips',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
			?>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogObat',
    'options'=>array(
        'title'=>'Pencarian Obat',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modObatDialog = new PCObatAlkesM('searchObatFarmasiRuangan');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['PCObatAlkesM']))
    $modObatDialog->attributes = $_GET['PCObatAlkesM'];
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatAlkesDialog-m-grid',
    'dataProvider'=>$modObatDialog->searchObatFarmasiRuangan(),
    'filter'=>$modObatDialog,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#PCUnitdosisdetailT_0_obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#PCUnitdosisdetailT_0_obatalkesNama\").val(\"$data->obatalkes_kode - $data->obatalkes_nama\");
                            $(\"#dialogObat\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'name'=>'tglkadaluarsa',
            'filter'=>'',
        ),
        
        array(
          'name'=>'satuankecil.satuankecil_nama',
            'header'=>'Satuan Kecil',
        ),
        array(
            'name'=>'satuanbesar.satuanbesar_nama',
            'header'=>'Satuan Besar',
        ),
        array(
            'header'=>'Generik',
            'name'=>'generik_nama',
            'value'=>'(isset($data->generik->generik_nama) ? $data->generik->generik_nama : "")',
            'filter'=>CHtml::activeTextField($modObatDialog, 'generik_nama').CHtml::activeHiddenField($modObatDialog, 'generik_id'),
        ),
        array(
            'header'=>'HJA Resep',
            'type'=>'raw',
            'value'=>'number_format($data->hjaresep, 0, ",", ".")',
            'filter'=>'',
            'htmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
            'header'=>'HJA Non Resep',
            'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
            'filter'=>'',
            'htmlOptions'=>array('style'=>'text-align:right;'),
        ),

        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php $this->renderPartial('_jsFunctions'); ?>
<script type="text/javascript">
var trObat = new String(<?php echo CJSON::encode($this->renderPartial('_rowObat',array('modUnitDosisDetail'=>$modUnitDosisDetail,'modUnitDosis'=>$modUnitDosis,'removeButton'=>true),true));?>);
var trObatFirst = new String(<?php echo CJSON::encode($this->renderPartial('_rowObat',array('modUnitDosisDetail'=>$modUnitDosisDetail,'modUnitDosis'=>$modUnitDosis,'removeButton'=>false),true));?>);
function submitObat()
{
    if($('#formNonRacikan .pilihNonRacik').is(':checked'))
         var qtyObat = parseFloat($('#qtyNonRacik').val());
         var jmlHari = parseFloat($('#hariNonRacik').val());
    if($('#formRacikan .pilihRacik').is(':checked')) {
         var qtyObat = parseFloat($('#qtyRacik').val());
         var jmlHari = parseFloat($('#hariRacik').val());
    }
    idObat = $('#idObat').val();
    qtyObat = qtyObat;
    jmlHari = jmlHari;

    if(idObat==''){
        alert('Silakan pilih obat terlebih dahulu!');
    }else{
        $.post('<?php echo Yii::app()->createUrl('rawatInap/ActionAjax/ObatUnitDosis');?>', { idObat:idObat,qtyObat:qtyObat,jmlHari:jmlHari},
        function(data){
            $('#tblDaftarResep').append(data.tr);
            $("#tblDaftarResep tr:last").find(".numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null})
                $('#tblDaftarResep tbody').each(function(){
                    jQuery('.dtPicker2').datepicker(
                        jQuery.extend(
                            {
                                showMonthAfterYear:false
                            }, 
                            jQuery.datepicker.regional['id'],
                            {
                                'dateFormat':'dd M yy',
                                'maxDate':'d',
                                'timeText':'Waktu',
                                'hourText':'Jam',
                                'minuteText':'Menit',
                                'secondText':'Detik',
                                'showSecond':true,
                                'timeOnlyTitle':'Pilih Waktu',
                                'timeFormat':'hh:mm:ss',
                                'changeYear':true,
                                'changeMonth':true,
                                'showAnim':'fold',
                                'yearRange':'-80y:+20y',
                            }
                        )
                    );
                });  
                $('#tblDaftarResep tbody').each(function(){
                jQuery('.dtPicker3').datetimepicker(
                    jQuery.extend(
                        {
                            showMonthAfterYear:false
                        }, 
                        jQuery.datepicker.regional['id'],
                        {
                            'dateFormat':'dd M yy',
                            'maxDate':'d',
                            'timeText':'Waktu',
                            'hourText':'Jam',
                            'minuteText':'Menit',
                            'secondText':'Detik',
                            'showSecond':true,
                            'timeOnlyTitle':'Pilih Waktu',
                            'timeFormat':'hh:mm:ss',
                            'changeYear':true,
                            'changeMonth':true,
                            'showAnim':'fold',
                            'timeOnly':true,
                            'yearRange':'-80y:+20y'
                        }
                    )
                );
            }); 
            clearInputan();
        },'json');        
        if($('#formNonRacikan #pilihRacik').is(':checked'))
            $('#namaObatNonRacik').val('');
        if($('#formRacikan #pilihRacik').is(':checked')) {
            $('#namaObatRacik').val();
        }
        $('#idObatAlkes').val('');
        $('#qtyObat').val('1');
        
    }   
}
function cekObat(){
   noUrut = 0;
     $('#noUrut').each(function() {
          $(this).length;
          noUrut++;
     });
     
    if(noUrut<1){
     alert('Anda Belum memilih Obat Yang Akan Diminta');  
     return false;
    }else{
       $('#riunitdosis-t-form').submit();
    }
    return false;
}

function remove(obj)
{
    if(confirm('Apakah Anda akan menghapus obat?'))
        $(obj).parent().parent().remove();
}

function adaRmax(Rke)
{
    var ada = false;
    $('#tblDaftarResep').find('input[name="Rke[]"]').each(function(){
       if(Rke == this.value)
           ada = true;
    });
    
    return ada;
}

function enableRacikan()
{
    $('#formRacikan input[type="text"]').removeAttr('disabled');
    $('#formRacikan input[type="text"]').removeAttr('readonly');
    $('#formRacikan select').removeAttr('disabled');
    $('#formRacikan button').removeAttr('disabled');
    $('#formNonRacikan input[type="text"]').attr('disabled','disabled');
    $('#formNonRacikan select').attr('disabled','disabled');
    $('#formNonRacikan button').attr('disabled','disabled');
    $('#racikanKe').focus();
}

function enableNonRacikan()
{
    $('#formNonRacikan input[type="text"]').removeAttr('disabled');
    $('#formNonRacikan select').removeAttr('disabled');
    $('#formNonRacikan button').removeAttr('disabled');
    $('#formRacikan input[type="text"]').attr('disabled','disabled');
    $('#formRacikan select').attr('disabled','disabled');
    $('#formRacikan button').attr('disabled','disabled');
}

function clearRacikan()
{
    $('#formRacikan input[type="text"]').val('');
    $('#satuanKekuatanObat').html('');
    $('#racikanKe').focus();
}

function clearNonRacikan()
{
    $('#formNonRacikan input[type="text"]').val('');
    $('#satuanKekuatanObat').html('');
    $('#racikanKe').focus();
}

function clearInputan()
{
    $('#idObat').val('');
    $('#hargaSatuan').val('');
    $('#hargaNetto').val('');
    $('#hargaJual').val('');
    $('#kekuatan').val('');
    $('#satuanKekuatan').val('');
    $('#jmlPermintaan').val('');
    $('#jmlKemasan').val('');
    $('#qty').val('');
    $('#namaObat').val('');
    $('#idSumberDana').val('');
    $('#namaSumberDana').val('');
    $('#idSatuanKecil').val('');
    noUrut = 1;
     $('.noUrut').each(function() {
          $(this).val(noUrut);
          noUrut++;
     });
    $('#tblDaftarResep').append(data.tr);
        $("#tblDaftarResep tr:last").find(".numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null})
            $('#tblDaftarResep tbody').each(function(){
                jQuery('.dtPicker2').datepicker(
                    jQuery.extend(
                        {
                            showMonthAfterYear:false
                        }, 
                        jQuery.datepicker.regional['id'],
                        {
                            'dateFormat':'dd M yy',
                            'maxDate':'d',
                            'timeText':'Waktu',
                            'hourText':'Jam',
                            'minuteText':'Menit',
                            'secondText':'Detik',
                            'showSecond':true,
                            'timeOnlyTitle':'Pilih Waktu',
                            'timeFormat':'hh:mm:ss',
                            'changeYear':true,
                            'changeMonth':true,
                            'showAnim':'fold',
                            'yearRange':'-80y:+20y',
                        }
                    )
                );
            });  
            $('#tblDaftarResep tbody').each(function(){
            jQuery('.dtPicker3').datetimepicker(
                jQuery.extend(
                    {
                        showMonthAfterYear:false
                    }, 
                    jQuery.datepicker.regional['id'],
                    {
                        'dateFormat':'dd M yy',
                        'maxDate':'d',
                        'timeText':'Waktu',
                        'hourText':'Jam',
                        'minuteText':'Menit',
                        'secondText':'Detik',
                        'showSecond':true,
                        'timeOnlyTitle':'Pilih Waktu',
                        'timeFormat':'hh:mm:ss',
                        'changeYear':true,
                        'changeMonth':true,
                        'showAnim':'fold',
                        'timeOnly':true,
                        'yearRange':'-80y:+20y'
                    }
                )
            );
        }); 
    clearRacikan(); clearNonRacikan();
}

function addRke(){
    RkeMax = 1;
    if($('#formNonRacikan #pilihRacik').is(':checked'))
        
         $('#tblDaftarResep tbody').find('input[name="rke"]').each(function(){
              $(this).val(RkeMax);
              RkeMax++;
         });
        $('#tblDaftarResep tbody').parents().find('input[name="r"]').val('');
        RkeMax++;
    if($('#formRacikan .pilihNonRacik').is(':checked')) {
        $('#tblDaftarResep tbody').find('input[name="r"]').each(function(){
              $(this).val('R/');
              RkeMax++;
         });
    }    
}

function setDialog(obj){
    idObat = 1;
    $("#obatAlkesDialog-m-grid").find("tr").removeClass("yellow_background");
    $.get('<?php echo Yii::app()->createUrl($this->route, array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'idAdmisi'=>$modPendaftaran->pasienadmisi_id));?>',{test:'aing',idObat:idObat},function(data){
        $("#tableObat").html(data);
    });
    parent = $(obj).parents(".input-append").find("input").attr("id");
    dialog = "#dialogObat";
    $(dialog).attr("parent-dialog",parent);
    $(dialog).dialog("open");
}

function setObatAuto(idObatAlkes){
    idObat = idObatAlkes;
    dialog = "#dialogObat";
    parent = $(dialog).attr("parent-dialog");
    obj = $("#"+parent);
    $.get('<?php echo Yii::app()->createUrl('ActionAutoComplete/obatUnitDosis'); ?>',{idObat: idObat},function(data){
        $(obj).val(data[0].obatalkes_nama);
        $(obj).val(data[0].obatalkes_id);
        setObat(obj,data[0]);
    },"json");
    console.log(obj);
    $(dialog).dialog("close");
    
}

function setObat(obj,item)
{    
    $(obj).parents('tr').find('input[name$="[obatalkesNama]"]').val(item.obatalkes_nama);
    $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val(item.obatalkes_id);
    $(obj).parents('tr').find('input[name$="[harganetto]"]').val(formatNumber(item.harganetto));
    $(obj).parents('tr').find('input[name$="[hargajual]"]').val(formatNumber(item.hargajual));
    $(obj).parents('tr').find('input[name$="[hargasatuan]"]').val(formatNumber(item.harganetto));
    $(obj).parents('tr').find('select[name$="[satuankecil_id]"]').val(item.satuankecil_id);
    $(obj).parents('tr').find('input[name$="[sumberdana_id]"]').val(item.sumberdana_id);
}

function cekInput()
{
    $('.currency').each(function(){this.value = unformatNumber(this.value)});
    $('.number').each(function(){this.value = unformatNumber(this.value)});
    return true;
}

function setTgl(){
$("#tblDaftarResep tr:last").find(".numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null})
    $('#tblDaftarResep tbody').each(function(){
        jQuery('.dtPicker2').datepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                }, 
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'maxDate':'d',
                    'timeText':'Waktu',
                    'hourText':'Jam',
                    'minuteText':'Menit',
                    'secondText':'Detik',
                    'showSecond':true,
                    'timeOnlyTitle':'Pilih Waktu',
                    'timeFormat':'hh:mm:ss',
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-80y:+20y',
                }
            )
        );
    });  
    $('#tblDaftarResep tbody').each(function(){
    jQuery('.dtPicker3').datetimepicker(
        jQuery.extend(
            {
                showMonthAfterYear:false
            }, 
            jQuery.datepicker.regional['id'],
            {
                'dateFormat':'dd M yy',
                'maxDate':'d',
                'timeText':'Waktu',
                'hourText':'Jam',
                'minuteText':'Menit',
                'secondText':'Detik',
                'showSecond':true,
                'timeOnlyTitle':'Pilih Waktu',
                'timeFormat':'hh:mm:ss',
                'changeYear':true,
                'changeMonth':true,
                'showAnim':'fold',
                'timeOnly':true,
                'yearRange':'-80y:+20y'
            }
        )
    );
});
}
function addRowObat(obj)
{
    $(obj).parents('table').children('tbody').append(trObat.replace());
    <?php 
        $attributes = $modUnitDosisDetail->attributeNames(); 
        foreach($attributes as $i=>$attribute){
            echo "renameInput('RIUnitdosisdetailT','$attribute');";
        }
    ?>
    renameInput('RIUnitdosisdetailT','obatalkesNama');
    renameInput('RIUnitdosisdetailT','obatalkes_id');
    renameInput('RIUnitdosisdetailT','tglinsmulai');
    renameInput('RIUnitdosisdetailT','jaminsmulai');
    renameInput('RIUnitdosisdetailT','tglinsstop');
    renameInput('RIUnitdosisdetailT','jaminsstop');
    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
    jQuery('input[name$="[obatalkesNama]"]').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
                                                                                    $(this).val( ui.item.label);
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
                                                                                    setObat(this, ui.item);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/obatUnitDosis');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        term: request.term,
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                });   
    jQuery('.dtpicker2').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
    jQuery('.dtpicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y','timeOnly':true}));
}

function batalObat(obj)
{
    if(confirm('Apakah Anda yakin akan membatalkan obat ?')){
        $(obj).parents('tr').next('tr').detach();
        $(obj).parents('tr').detach();
        
        <?php 
            foreach($attributes as $i=>$attribute){
                echo "renameInput('RIUnitdosisdetailT','$attribute');";
            }
        ?>
        renameInput('PCUnitdosisdetailT','obatalkesNama');
        renameInput('PCUnitdosisdetailT','obatalkes_id');
        renameInput('PCUnitdosisdetailT','tglinsmulai');
        renameInput('PCUnitdosisdetailT','jaminsmulai');
        renameInput('PCUnitdosisdetailT','tglinsstop');
        renameInput('PCUnitdosisdetailT','jaminsstop');
        var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();        
    }
}
function renameInput(modelName,attributeName)
{
    var trLength = $('#tblDaftarResep tr').length;
    var i = -1;
    $('#tblDaftarResep tr').each(function(){
        if($(this).has('input[name$="[obatalkes_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('input[name^="obatalkesNama["]').attr('name','obatalkesNama['+i+']');
        $(this).find('input[name^="obatalkesNama["]').attr('id','obatalkesNama'+i+'');
        $(this).find('input[id="row"]').attr('value',i);
        $(this).find('input[id="row"]').attr('value',i);
        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
        jQuery('input[name$="[obatalkesNama]"]').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
                                                                                    $(this).val( ui.item.label);
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
                                                                                    setObat(this, ui.item);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/obatUnitDosis');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        term: request.term
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                });   
        jQuery('#tblDaftarResep tr:last .dtpicker2').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
        jQuery('#tblDaftarResep tr:last .dtpicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y','timeOnly':true}));
    });
    noUrut = 1;
     $('.noUrut').each(function() {
          $(this).val(noUrut);
          noUrut++;
     });
}
function setHari(obj){
    var jmlHari = $(obj).val();
    var jmlDosis1 = parseInt($(obj).parents("tr").find("input[name$='[dosis1]']").val());        
    var jmlDosis2 = parseInt($(obj).parents("tr").find("input[name$='[dosis2]']").val());        
    alert(jmlHari);
    alert(jmlDosis1);
    alert(jmlDosis2);
}
setInterval(function(){setTgl()},1000);
</script>