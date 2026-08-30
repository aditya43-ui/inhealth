<script>
    function setFormPenilaian() {
        var jenis_evaluasi = $('#jenisevaluasippds_nama').val();
        $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getJenisEvaluasi'); ?>',
        data: {jenis_evaluasi:jenis_evaluasi},
        dataType: "json",
        success:function(data){
            $('#table-penilaian > tbody').html(data);
            $('#table-penilaian').removeClass("animation-loading");
            renameInputRow($("#table-penilaian"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });    
    }
    
    function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    }
    
    function setNilaiMutu(obj) {
     var programstudi_id = $('#PDKEvaluasippdsT_programstudi_id').val();
     var nilai = $(obj).parents('tr').find('.nilaiangka').val();
     var total_nilai= 0;
     var jml= 0;
      $('#table-penilaian > tbody > tr').each(function(){
         total_nilai += parseInt(unformatNumber($(this).find('input[name*="[evaluasippdsdet_nilaiangka]"]').val() ));    
         jml += parseInt(unformatNumber($(this).find('input[name*="[evaluasippdsdet_nilaiangka]"]').length ));
      });
      
      $('#total_rata').val(total_nilai);
      var hasil_pembagian =total_nilai / jml;
      $('#nilai_rata').val(hasil_pembagian.toFixed(2));
     $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getNilaiMutu'); ?>',
        data: {nilai:nilai,programstudi_id:programstudi_id},
        dataType: "json",
        success:function(data){
                $(obj).parents('tr').find('.nilaimutu').val(data.hasil);

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });    
    }
    
function  setFormCatatan(){
    var jenis_evaluasi = $('#jenisevaluasippds_nama').val();

    if(jenis_evaluasi == 'DOPS') {
         $('#formCatatanDefault').hide();
         $('#formCatatanDOPS').show();
    }else if(jenis_evaluasi == 'Mini-PAT (Paramedis)'){
         $('#formCatatanDefault').show();
         $('#formCatatanDOPS').hide();
    }else if(jenis_evaluasi == 'Mini-CEX'){
         $('#formCatatanDefault').hide();
         $('#formCatatanDOPS').show();
    }else{
         $('#formCatatanDefault').show();
         $('#formCatatanDOPS').hide();
    }
}
    
function setFormInformasi(){
    var jenis_evaluasi = $('#jenisevaluasippds_nama').val();
    
    if(jenis_evaluasi == 'DOPS') {
         $('#formDefault').hide();
         $('#formDOPS').show();
         $('#formCBD').hide();
         $('#formMiniCEX').hide();
    }else if(jenis_evaluasi == 'Mini-PAT (Paramedis)'){
         $('#formDefault').show();
         $('#formDOPS').hide();
         $('#formCBD').hide();
         $('#formMiniCEX').hide();
    }else if(jenis_evaluasi == 'Mini-CEX'){
         $('#formDefault').hide();
         $('#formDOPS').hide();
         $('#formCBD').hide();
         $('#formMiniCEX').show();
    }else{
         $('#formDefault').show();
         $('#formDOPS').hide();
         $('#formCBD').hide();
         $('#formMiniCEX').hide();
    }
}

function setUmur(tanggal_lahir)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetUmur'); ?>',
       data: {tanggal_lahir : tanggal_lahir},//
       dataType: "json",
       success:function(data){
           $("#PDKEvaluasippdsT_pasien_umur").val(data.umur);
      
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
$(document).ready(function() {
         
         $('#formDefault').show();
         $('#formDOPS').hide();
         $('#formCBD').hide();
         $('#formMiniCEX').hide();
         $('#formCatatanDefault').show();
         $('#formCatatanDOPS').hide();
         
        <?php if(isset($_GET['sukses'])){ ?>
        $("input, select, textarea").attr("disabled",true);		
       <?php } ?>
           
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
});
</script>
