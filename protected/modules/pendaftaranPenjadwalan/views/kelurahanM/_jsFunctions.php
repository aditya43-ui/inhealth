<script type="text/javascript">
var buttonMinus = '<?php echo CHtml::link('<i class="entypo-minus-circled"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')); ?>';
function namaLain(nama)
{
	document.getElementById('PPKelurahanM_kelurahan_namalainnya').value = nama.value.toUpperCase();
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
    
   
    
    function clearRow()
    {
        $('#PPKelurahanM_kelurahan_nama').val('');
        $('#PPKelurahanM_kelurahan_namalainnya').val('');
        $('#PPKelurahanM_latitude').val('');
        $('#PPKelurahanM_longitude').val('');
        $('#PPKelurahanM_kode_pos').val('');
    }

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kelurahan tr').length;
    var i = 1;
    $('#tbl-kelurahan tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        i++;
    });
}

    function addRow(obj)
    {   
        var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')) ?>';                
        var no = eval($('#nomor').val())+1;        
        var kelurahan = $('#PPKelurahanM_kelurahan_nama').val();
        var namalain = $('#PPKelurahanM_kelurahan_namalainnya').val();
        
        if ( (kelurahan != '') || (namalain != '') ){
            var td =    '   <td><input name = "PPKelurahanM['+no+'][kelurahan_nama]"  type = "text" id = "PPKelurahanM_'+no+'_kelurahan_nama" class="form-control span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200"  readonly = TRUE value = "'+$('#PPKelurahanM_kelurahan_nama').val()+'"> <span class="required">*<span></td>\n\
                            <td><input name = "PPKelurahanM['+no+'][kelurahan_namalainnya]" type = "text" id = "PPKelurahanM_'+no+'_kelurahan_namalainnya" class="form-control span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200"  readonly = TRUE value = "'+$('#PPKelurahanM_kelurahan_namalainnya').val()+'"> <span class="required">*<span></td>\n\
                            <td><input name = "PPKelurahanM['+no+'][latitude]" type = "text" id = "PPKelurahanM_'+no+'_latitude" class="form-control span3 " onkeypress = "return $(this).focusNextInputField(event);",  readonly = TRUE value = "'+$('#PPKelurahanM_latitude').val()+'"> </td>\n\
                            <td><input name = "PPKelurahanM['+no+'][longitude]" type = "text" id = "PPKelurahanM_'+no+'_longitude" class="form-control span3 " onkeypress = "return $(this).focusNextInputField(event);", readonly = TRUE value = "'+$('#PPKelurahanM_longitude').val()+'"> </td>\n\\n\
                            <td><input name = "PPKelurahanM['+no+'][kode_pos]" type = "text" id = "PPKelurahanM_'+no+'_kode_pos" class="form-control span3 " onkeypress = "return $(this).focusNextInputField(event);", readonly = TRUE value = "'+$('#PPKelurahanM_kode_pos').val()+'"> </td>\n\
                            <td>'+buttonMinus+'</td>';                
            $('#tbl-kelurahan').append('<tr>'+td+'</tr>');
        }else{
            myAlert('Maaf Kelurahan dan Nama  Lain Tidak Boleh Kosong');
        }
                
        $('#nomor').val(no);
        clearRow();
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
</script>