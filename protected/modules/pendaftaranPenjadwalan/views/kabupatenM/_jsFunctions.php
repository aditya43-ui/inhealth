<script type="text/javascript">
var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')); ?>';
var confirmMessage = '<?php echo Yii::t('mds','Do You want to remove?') ?>';
function namaLain(nama)
{
	document.getElementById('PPKabupatenM_kabupaten_namalainnya').value = nama.value.toUpperCase();
}

function addRow(obj)
{
   // var tr = $('#tbl-kabupaten tr:first').html();
    //$('#tbl-kabupaten tr:last').after('<tr>'+tr+'</tr>');
   // $('#tbl-kabupaten tr:last td:last').append(''+buttonMinus+'');
    //renameInput('PPKabupatenM','kabupaten_nama');
   // renameInput('PPKabupatenM','kabupaten_namalainnya');
   
    var buttonMinus = '<?php echo CHtml::link('<i class="entypo-minus-circled"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')) ?>';                
    var no = eval($('#nomor').val())+1;        
    var kabupaten = $('#PPKabupatenM_kabupaten_nama').val();
    var namalain = $('#PPKabupatenM_kabupaten_namalainnya').val();

    if ( (kabupaten != '') || (namalain != '') ){
        var td =    '   <td><input name = "PPKabupatenM['+no+'][kabupaten_nama]"  type = "text" id = "PPKabupatenM_'+no+'_kabupaten_nama" class="span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200"  readonly = TRUE value = "'+$('#PPKabupatenM_kabupaten_nama').val()+'"> <span class="required">*<span></td>\n\
                        <td><input name = "PPKabupatenM['+no+'][kabupaten_namalainnya]" type = "text" id = "PPKabupatenM_'+no+'_kabupaten_namalainnya" class="span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200"  readonly = TRUE value = "'+$('#PPKabupatenM_kabupaten_namalainnya').val()+'"> <span class="required">*<span></td>\n\
                        <td><input name = "PPKabupatenM['+no+'][latitude]" type = "text" id = "PPKabupatenM_'+no+'_latitude" class="span3 " onkeypress = "return $(this).focusNextInputField(event);",  readonly = TRUE value = "'+$('#PPKabupatenM_latitude').val()+'"> </td>\n\
                        <td><input name = "PPKabupatenM['+no+'][longitude]" type = "text" id = "PPKabupatenM_'+no+'_longitude" class="span3 " onkeypress = "return $(this).focusNextInputField(event);", readonly = TRUE value = "'+$('#PPKabupatenM_longitude').val()+'"> </td>\n\
                        <td>'+buttonMinus+'</td>';                
        $('#tbl-kabupaten').append('<tr>'+td+'</tr>');
    }else{
        myAlert('Maaf Kabupaten dan Nama  Lain Tidak Boleh Kosong');
    }

    $('#nomor').val(no);
    clearRow();
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kabupaten tr').length;
    var i = 1;
    $('#tbl-kabupaten tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'['+i+']['+attributeName+']');
        i++;
    });
}

function delRow(obj)
    {
        var no = $('#nomor').val();
        myConfirm("Yakin Akan Menghapus Data ini?","Perhatian!",function(r) {
            if (r){
                 $(obj).parent().parent().remove();
            //renameInput('RDKabupatenM','kabupaten_nama');
            //renameInput('RDKabupatenM','kabupaten_namalainnya');
                $('#nomor').val(eval(no)-1);
           }
       });        
    }

    function registerJSlocation(id,modelName,i)
    {
       $('#'+id).on('click', function(){ 
               $('#'+id).coordinate_picker({'lat_selector':'#'+modelName+'_'+i+'_latitude','long_selector':'#'+modelName+'_'+i+'_longitude','default_lat':'-7.091932','default_long':'107.672491','edit_zoom':12,'pick_zoom':7})                                
           });

   }
        
    function changeSize()
    {            
        window.parent.document.getElementById('frame').style= 'overflow-y:scroll;height:600px;';            
    }
           
    function clearRow()
    {
        $('#PPKabupatenM_kabupaten_nama').val('');
        $('#PPKabupatenM_kabupaten_namalainnya').val('');
        $('#PPKabupatenM_latitude').val('');
        $('#PPKabupatenM_longitude').val('');
    }
    
    function changePropinsi(){
        var propinsi = $('#PPKabupatenM_propinsi_id').val();
        var kodekabupaten_kemenkes_nama = $('#PPKabupatenM_kodekabupaten_kemenkes_nama').val();
        
        if(propinsi != ''){
            $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownKabupatenKemenkes'); ?>',
            data: {propinsi_id: propinsi, kemenkesnamakota: kodekabupaten_kemenkes_nama},
            dataType: "json",
            success: function (data) {    
                $("#<?php echo CHtml::activeId($model, 'kodekabupaten_kemenkes') ?>").empty();
                $("#<?php echo CHtml::activeId($model, 'kodekabupaten_kemenkes') ?>").html(data.form);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        }
         
    }
    
    $(document).ready(function(){
        changePropinsi();
    });
    
</script>