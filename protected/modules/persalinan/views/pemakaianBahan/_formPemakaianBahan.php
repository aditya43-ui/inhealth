<fieldset id="formNonRacikan" class="table-bordered">
                <legend class="table-bordered radio">
                    Pemakaian Bahan
                </legend>
                
                <div class="control-group">
                    <label class="control-label" for="namaObat">Nama Obat</label>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('idObat'); ?>
<!--<div class="input-append" style='display:inline'>-->
                    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'name'=>'namaObatNonRacik',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/ObatReseptur').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                                   idSumberDana: $("#idSumberDana").val(),
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                             'options'=>array(
                                                   'showAnim'=>'fold',
                                                   'minLength' => 2,
                                                   'focus'=> 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                                                   'select'=>'js:function( event, ui ) {
                                                        $("#idObat").val(ui.item.obatalkes_id); 
                                                        $("#jumlahBahan").val(1); 
                                                        
                                                        $("#namaObat").val(ui.item.obatalkes_nama);
                                                        
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions'=>array(
                                                
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogAlkes'),
                                        )); 
                        ?>
<!--</div>-->
                         <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlkes").dialog("open");return false;')); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="jumlah">Jumlah</label>
                    <div class="controls">
                        <?php echo CHtml::textField('jumlahBahan', '', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeypress'=>"return isNumberKey(event);",'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 number numbersOnly')) ?>
                        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                array('onclick'=>'validasi();return false;',
                                      'class'=>'btn btn-primary numbersOnly',
                                      'onkeypress'=>"validasi();return $(this).focusNextInputField(event)",
                                      'rel'=>"tooltip",
                                      'title'=>"Klik untuk menambahkan resep",)); ?>
                    </div>
                </div>
            </fieldset>

<fieldset>
    <legend>
        <?php //echo CHtml::dropDownList('daftartindakanPemakaianBahan', '',array()) ?>
        <?php //echo CHtml::link('<i class="icon-plus icon-white"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlkes").dialog("open");return false;')); ?>
        <!--Pemakaian Bahan-->
    </legend>
    <br>
    <table class="items table table-striped table-bordered table-condensed" id="tblInputPemakaianBahan">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th>Nama Alkes</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Sub Total</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <div>
        <b>Total Pemakaian Bahan : </b>
        <?php echo CHtml::textField("totPemakaianBahan", 0,array('readonly'=>true,'class'=>'inputFormTabel currency')); ?>
    </div>
</fieldset>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogAlkes',
    'options'=>array(
        'title'=>'Alat Kesehatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$moObatAlkes = new PSObatAlkesM('search');
$moObatAlkes->unsetAttributes();
if(isset($_GET['PSObatAlkesM']))
    $moObatAlkes->attributes = $_GET['PSObatAlkesM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rjobat-alkes-m-grid',
	'dataProvider'=>$moObatAlkes->search(),
	'filter'=>$moObatAlkes,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                'obatalkes_kategori',
		'obatalkes_nama',
                'obatalkes_golongan',
                array(
                    'name'=>'satuankecilNama',
                    'value'=>'$data->satuankecil->satuankecil_nama',
                ),
                array(
                    'name'=>'sumberdanaNama',
                    'value'=>'$data->sumberdana->sumberdana_nama',
                ),
                'minimalstok',
		//'hargajual',
                array(
                    'name'=>'hargajual',
                    'value'=>'number_format($data->hargajual)',
                ),
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "inputPemakaianBahan($data->obatalkes_id);$(\'#dialogAlkes\').dialog(\'close\');return false;"))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>

<script type="text/javascript">
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
function inputPemakaianBahan(idObatAlkes)
{
    var idDaftartindakan = $('#daftartindakanPemakaianBahan').val();
    var jumlahBahan = $('#jumlahBahan').val();
    if (jumlahBahan == ''){
        $('#jumlahBahan').val(1);
    }
//    if(idDaftartindakan == null){
//        myAlert('Belum ada Tindakan');
//        return false;
//    }
        
    jQuery.ajax({'url':'<?php echo $this->createUrl('addFormPemakaianBahan')?>',
                 'data':{idObatAlkes:idObatAlkes, idDaftartindakan:idDaftartindakan},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
                         $('#namaObatNonRacik').val(data.namaObat);
                         $("#idObat").val(idObatAlkes); 
                         
                         $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
                         $('#tblInputPemakaianBahan > tbody').append(data.form);
                         
                         $('#tblInputPemakaianBahan tr:last').find('input[name*="qty"]').val($('#jumlahBahan').val());
                         $('#jumlahBahan').attr('value',1);
                         renameInput('pemakaianBahan', 'obatalkes_id');
                         renameInput('pemakaianBahan', 'hargajual');
                         renameInput('pemakaianBahan', 'qty');
                         renameInput('pemakaianBahan', 'subtotal');
                         renameInput('pemakaianBahan', 'daftartindakan_id');
                         
                         renameInput('pemakaianBahan', 'hargasatuan');
                         renameInput('pemakaianBahan', 'harganetto');
                         renameInput('pemakaianBahan', 'sumberdana_id');
                         renameInput('pemakaianBahan', 'satuankecil_id');
                         hitungTotal();
                         
                         $('.qty').each(function(){
                             hitungSubTotal(this);
                         });

                         $("#tblInputPemakaianBahan > tbody > tr:last .currency").maskMoney({"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
                         $('.currency').each(function(){this.value = formatNumber(this.value)});
                         $("#tblInputPemakaianBahan > tbody > tr:last .number").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
                         $('.number').each(function(){this.value = formatNumber(this.value)});
                 } ,
                 'cache':false});

    function renameInput(modelName,attributeName)
    {
        var i = -1;
        $('#tblInputPemakaianBahan tr').each(function(){
            if($(this).has('input[name$="[obatalkes_id]"]').length){
                i++;
            }
            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        });
    }
}
 
function removeObat(obj)
{
    myConfirm('Apakah Anda akan menghapus obat?', 'Perhatian!', function(r){
        if(r){
            $(obj).parent().parent().remove();

            renameInputAfterRemove('pemakaianBahan', 'obatalkes_id');
            renameInputAfterRemove('pemakaianBahan', 'hargajual');
            renameInputAfterRemove('pemakaianBahan', 'qty');
            renameInputAfterRemove('pemakaianBahan', 'subtotal');
            renameInputAfterRemove('pemakaianBahan', 'daftartindakan_id');

            renameInputAfterRemove('pemakaianBahan', 'hargasatuan');
            renameInputAfterRemove('pemakaianBahan', 'harganetto');
            renameInputAfterRemove('pemakaianBahan', 'sumberdana_id');
            renameInputAfterRemove('pemakaianBahan', 'satuankecil_id');
        }
    });
    hitungTotal();
}

function renameInputAfterRemove(modelName,attributeName)
{
    var i = -1;
    $('#tblInputPemakaianBahan tr').each(function(){
        if($(this).has('input[name$="[obatalkes_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    });
}

function hitungSubTotal(obj)
{
    var qty = obj.value;
    var harga = unformatNumber($(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[hargajual]"]').val());
    var subtotal = qty * harga;
    $(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[subtotal]"]').val(formatNumber(subtotal));
    hitungTotal(); 
}
    
function hitungTotal()
{
    var total = 0;
    $('#tblInputPemakaianBahan').find('input[name$="[subtotal]"]').each(function(){
        total = total + unformatNumber(this.value);
    });
    $('#totPemakaianBahan').val(formatNumber(total));
}
function validasi(){
    var idObat = $('#idObat').val();
    var jumlahObat = $('#qty').val();
    if (idObat == ''){
        
        myAlert('Obat Belum Diisi');
    } else if (jumlahObat == ''){
        myAlert('jumlah Obat Belum Diisi')
    } else if (jumlahObat < 1){
        myAlert('jumlah Obat Tidak Sesuai')
    } else {
        inputPemakaianBahan(idObat);
    }
    
}

function cekInput()
{
    $('.currency').each(function(){this.value = unformatNumber(this.value)});
    $('.number').each(function(){this.value = unformatNumber(this.value)});
    return true;
}
</script>

<?php 
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>   