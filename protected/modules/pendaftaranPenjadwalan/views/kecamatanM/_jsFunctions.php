<script type="text/javascript">
var buttonMinus = '<?php echo CHtml::link('<i class="entypo-minus-circled></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')); ?>';
var confirmMessage = '<?php echo Yii::t('mds','Do You want to remove?') ?>';
function namaLain(nama)
{
	document.getElementById('PPKecamatanM_kecamatan_namalainnya').value = nama.value.toUpperCase();
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

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kecamatan tr').length;
    var i = 1;
    $('#tbl-kecamatan tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        i++;
    });
}

    function addRow(obj)
    {   
        var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')) ?>';                
        var no = eval($('#nomor').val())+1;        
        var kabupaten = $('#PPKecamatanM_kecamatan_nama').val();
        var namalain = $('#PPKecamatanM_kecamatan_namalainnya').val();
        
        if ( (kabupaten != '') || (namalain != '') ){
            var td =    '   <td><input name = "PPKecamatanM['+no+'][kecamatan_nama]"  type = "text" id = "PPKecamatanM_'+no+'_kecamatan_nama" class="span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200"  readonly = TRUE value = "'+$('#PPKecamatanM_kecamatan_nama').val()+'"> <span class="required">*<span></td>\n\
                            <td><input name = "PPKecamatanM['+no+'][kecamatan_namalainnya]" type = "text" id = "PPKecamatanM_'+no+'_kecamatan_namalainnya" class="span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200"  readonly = TRUE value = "'+$('#PPKecamatanM_kecamatan_namalainnya').val()+'"> <span class="required">*<span></td>\n\
                            <td><input name = "PPKecamatanM['+no+'][latitude]" type = "text" id = "PPKecamatanM_'+no+'_latitude" class="span3 " onkeypress = "return $(this).focusNextInputField(event);",  readonly = TRUE value = "'+$('#PPKecamatanM_latitude').val()+'"> </td>\n\
                            <td><input name = "PPKecamatanM['+no+'][longitude]" type = "text" id = "PPKecamatanM_'+no+'_longitude" class="span3 " onkeypress = "return $(this).focusNextInputField(event);", readonly = TRUE value = "'+$('#PPKecamatanM_longitude').val()+'"> </td>\n\
                            <td>'+buttonMinus+'</td>';                
            $('#tbl-kecamatan').append('<tr>'+td+'</tr>');
        }else{
            myAlert('Maaf Kecamatan dan Nama  Lain Tidak Boleh Kosong');
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
    
     function clearRow()
    {
        $('#PPKecamatanM_kecamatan_nama').val('');
        $('#PPKecamatanM_kecamatan_namalainnya').val('');
        $('#PPKecamatanM_latitude').val('');
        $('#PPKecamatanM_longitude').val('');
    }
    
    function changeKabupaten(){
        var kota = $('#PPKecamatanM_kabupaten_id').val();
        var kodekecamatan_kemenkes_nama = $('#PPKecamatanM_kodekecamatan_kemenkes_nama').val();
        
        if(kota != ''){
            $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownKecamatanKemenkes'); ?>',
            data: {kabupaten_id: kota, kemenkesnamakecamatan: kodekecamatan_kemenkes_nama},
            dataType: "json",
            success: function (data) {    
                $("#<?php echo CHtml::activeId($model, 'kodekecamatan_kemenkes') ?>").empty();
                $("#<?php echo CHtml::activeId($model, 'kodekecamatan_kemenkes') ?>").html(data.form);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        }
         
    }
    
    $(document).ready(function(){
        changeKabupaten();
        console.log("Kick");
    });
    
    
</script>