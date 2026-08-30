<fieldset>
    <table>
        <tr>
            <td colspan="2">
                <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlkes").dialog("open");return false;')); ?>
                <?php echo CHtml::radioButton('pilihAlkes', true, array('value'=>'bahan','onclick'=>'pilihAlkesMedis(this);')); ?>
                Pemakaian Bahan
                <?php echo CHtml::radioButton('pilihAlkes', false, array('value'=>'medis','onclick'=>'pilihAlkesMedis(this);')); ?>
                Alat Medis
            </td>
        </tr>
        <tr>
            <td width="230px">
                <?php echo CHtml::dropDownList('daftartindakanPemakaianBahan', '',array(),array('empty'=>'Uraian Tindakan')) ?>
            </td>
            <td>
                <?php $this->widget('MyJuiAutoComplete',array(
                            'name'=>'pakaiBahan',
                            'value'=>'',
                            'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.$this->createUrl('PemakaianBahan').'",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                                   tipepaket_id: $("#GZTindakanPelayananT_0_tipepaket_id").val(),
                                                   kelaspelayanan_id: $("#GZPendaftaranT_kelaspelayanan_id").val(),
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
                                    inputPemakaianBahan(ui.item.obatalkes_id);
                                    return false;
                                }',

                            ),
                            'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2', 'placeholder'=>'Pemakaian Bahan'),
                            'tombolDialog'=>array('idDialog'=>'dialogAlkes'),
                )); ?>
                <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlatmedis").dialog("open");return false;')); ?>
                
                <?php $this->widget('MyJuiAutoComplete',array(
                            'name'=>'alatMedis',
                            'value'=>'',
                            'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.$this->createUrl('PemakaianAlatMedis').'",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
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
                                    inputAlatmedis(ui.item.alatmedis_id);
                                    return false;
                                }',

                            ),
                            'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2', 'placeholder'=>'Alat Medis'),
                            'tombolDialog'=>array('idDialog'=>'dialogAlatmedis'),
                )); ?>
            </td>
        </tr>
    </table>     
    <table class="items table table-striped table-bordered table-condensed" id="tblInputPemakaianBahan">        
        <thead>
            <tr>
        <div>
            <legend class="rim">Tabel Pemakaian Bahan</legend>
        </div>
            </tr>
            <tr>
                <th>Uraian Tindakan</th>
                <th>Nama Alkes</th>
<!--<th>Harga</th>-->
                <th>Jumlah</th>
<!--<th>Sub Total</th>-->
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
        'width'=>600,
        'height'=>600,
        'resizable'=>false,
    ),
));

$moObatAlkes = new GZObatAlkesM('search');
$moObatAlkes->unsetAttributes();
if(isset($_GET['GZObatAlkesM']))
    $moObatAlkes->attributes = $_GET['GZObatAlkesM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'gzobat-alkes-m-grid',
	'dataProvider'=>$moObatAlkes->searchObatFarmasi(),
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
                    'value'=>'number_format($data->hjaresep)',
                ),
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "inputPemakaianBahan($data->obatalkes_id);return false;"))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">   
$('#alatMedis').parent().addClass('hide');
function pilihAlkesMedis(obj)
{
    $('#tblInputPemakaianBahan > tbody').html('');
    $('#totPemakaianBahan').val('0');
    if(obj.value=='bahan'){
        $('#alatMedis').parent().addClass('hide');
        $('#pakaiBahan').parent().removeClass('hide');
    } else if(obj.value=='medis') {
        $('#pakaiBahan').parent().addClass('hide');
        $('#alatMedis').parent().removeClass('hide');
    }
} 

function inputPemakaianBahan(obatalkes_id)
{
    var daftartindakan_id = $('#daftartindakanPemakaianBahan option:selected').val();
    if(daftartindakan_id == ''){
        myAlert('Belum ada Tindakan');
        return false;
    }
        
    jQuery.ajax({'url':'<?php echo $this->createUrl(Yii::app()->controller->id.'/addFormPemakaianBahan')?>',
                 'data':{obatalkes_id:obatalkes_id, daftartindakan_id:daftartindakan_id},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
                         $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
                         $('#tblInputPemakaianBahan > tbody').append(data.form);
                         renameInput('pemakaianBahan', 'obatalkes_id');
                         renameInput('pemakaianBahan', 'hargajual');
                         renameInput('pemakaianBahan', 'hargasatuan');
                         renameInput('pemakaianBahan', 'harganetto');
                         renameInput('pemakaianBahan', 'qty');
                         renameInput('pemakaianBahan', 'subtotal');
                         renameInput('pemakaianBahan', 'daftartindakan_id');
                         renameInput('pemakaianBahan', 'sumberdana_id');
                         renameInput('pemakaianBahan', 'satuankecil_id');
                         hitungTotal();
    
                        $("#tblInputPemakaianBahan > tbody tr:last .currency").maskMoney({"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
//                        $('.currency').each(function(){this.value = formatNumber(this.value)});
                        $("#tblInputPemakaianBahan > tbody tr:last .number").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null,"allowDecimal":true});
//                        $('.number').each(function(){this.value = formatNumber(this.value)});
                 } ,
                 'cache':false});
    
        function renameInput(modelName,attributeName)
        {
            var i = -1;
            $('#tblInputPemakaianBahan tr').each(function(){
                if($(this).has('input[name$="[obatalkes_id]"]').length){
                    i++;
                }
                $(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
                $(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
            });
        }
}
 
function removeObat(obj)
{        
    myConfirm('Apakah Anda akan menghapus obat?','Perhatian!',
    function(r){
        if(r){
           $(obj).parent().parent().remove();
        }
    }); 
    
    renameInputAfterRemove('pemakaianBahan', 'obatalkes_id');
    renameInputAfterRemove('pemakaianBahan', 'hargajual');
    renameInputAfterRemove('pemakaianBahan', 'qty');
    renameInputAfterRemove('pemakaianBahan', 'subtotal');
    renameInputAfterRemove('pemakaianBahan', 'daftartindakan_id');

    renameInputAfterRemove('pemakaianBahan', 'hargasatuan');
    renameInputAfterRemove('pemakaianBahan', 'harganetto');
    renameInputAfterRemove('pemakaianBahan', 'sumberdana_id');
    renameInputAfterRemove('pemakaianBahan', 'satuankecil_id');
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
    var qty = unformatNumber(obj.value);
    var harga = unformatNumber($(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[hargajual]"]').val());
    var subtotal = qty * harga;
    $(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[subtotal]"]').val(formatNumber(subtotal));
    hitungTotal();
//    $('.currency').each(function(){this.value = formatNumber(this.value)});
//    $('.number').each(function(){this.value = formatNumber(this.value)});
}
    
function hitungTotal()
{
    var total = 0;
    $('#tblInputPemakaianBahan').find('input[name$="[subtotal]"]').each(function(){
        total = total + unformatNumber(this.value);
    });
    $('#totPemakaianBahan').val(formatNumber(total));
}

function inputAlatmedis(alatmedis_id)
{
    var daftartindakan_id = $('#daftartindakanPemakaianBahan option:selected').val();
    if(daftartindakan_id == ''){
        myAlert('Belum ada Tindakan');
        return false;
    }
    
    jQuery.ajax({'url':'<?php echo $this->createUrl(Yii::app()->controller->id.'/addFormPemakaianAlat')?>',
                 'data':{alatmedis_id:alatmedis_id, daftartindakan_id:daftartindakan_id},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
                     if(!sudahAdaAlat(alatmedis_id)){
                         $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
                         $('#tblInputPemakaianBahan > tbody').append(data.form);
                         renameInput('pemakaianAlat', 'alatmedis_id');
                         renameInput('pemakaianAlat', 'hargajual');
                         renameInput('pemakaianAlat', 'hargasatuan');
                         renameInput('pemakaianAlat', 'harganetto');
                         renameInput('pemakaianAlat', 'qty');
                         renameInput('pemakaianAlat', 'subtotal');
                         renameInput('pemakaianAlat', 'daftartindakan_id');
                         renameInput('pemakaianAlat', 'sumberdana_id');
                         hitungTotal();
                     }
    
                        $("#tblInputPemakaianBahan > tbody tr:last .currency").maskMoney({"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
                        $('.currency').each(function(){this.value = formatNumber(this.value)});
                        $("#tblInputPemakaianBahan > tbody tr:last .number").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
                        $('.number').each(function(){this.value = formatNumber(this.value)});
                 } ,
                 'cache':false});
        function sudahAdaAlat(alatmedis_id)
        {
             var ada;
             $('#tblInputPemakaianBahan').find('input[name$="[alatmedis_id]"]').each(function(){
                 var cek = true;
                 if(this.value!=alatmedis_id){
                     ada = cek && ada;
                 } else {
                     myAlert('Sudah ada!');
                     ada = cek && true;
                 }
             });

            return ada;
        }

        function renameInput(modelName,attributeName)
        {
            var i = -1;
            $('#tblInputPemakaianBahan tr').each(function(){
                if($(this).has('input[name$="[alatmedis_id]"]').length){
                    i++;
                }
                $(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
                $(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
            });
        }
}
</script>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogAlatmedis',
    'options'=>array(
        'title'=>'Alat Medis',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modAlat = new AlatmedisM('search');
$modAlat->unsetAttributes();
if(isset($_GET['AlatmedisM']))
    $modAlat->attributes = $_GET['AlatmedisM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'almes-m-grid',
	'dataProvider'=>$modAlat->search(),
	'filter'=>$modAlat,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                'jenisalatmedis.jenisalatmedis_nama',
                'alatmedis_nama',
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "inputAlatmedis($data->alatmedis_id);return false;"))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>