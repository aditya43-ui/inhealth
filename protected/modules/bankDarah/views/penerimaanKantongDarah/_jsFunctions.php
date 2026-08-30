<script type="text/javascript">
function setNol(obj){
    if($(obj).is(":checked")){
        obj.value = 1;
    }else{
        obj.value = 0;
    }
}
function checkAll(tipe){
    
    if (typeof tipe === 'undefined'){
        $("#table-detailbarang > tbody > tr").find('.checklist').each(function(){
            if($(".pilihkantong").prop("checked") == true){
                $(this).prop('checked',true);
            }else{
                $(this).prop('checked',false);
            }
        });
    }else if(tipe == 'pengujian'){
        $("#table-detailbarang > tbody > tr").find('.checklistsample').each(function(){
            if($(".pilihsample").prop("checked") == true){                                
                $(this).prop('checked',true);
            }else{
                $(this).prop('checked',false);
            }
        });
    }else if(tipe == 'imltd'){
        $("#table-detailbarang > tbody > tr").find('.checklistimltd').each(function(){
            if($(".pilihimltd").prop("checked") == true){                
                $(this).prop('checked',true);
            }else{
                $(this).prop('checked',false);
            }
        });
    }
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
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]["+row+"]");
            }
        });
        $(this).find('input[name$="[maininput]"]').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]+"_"+row);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]["+row+"]");
            }
        });
        row++;
    });	
}

function getRuangan(id) {
        
        $.ajax({
          type:'POST',
          url:'<?php echo $this->createUrl('getRuangan'); ?>',
          data:{id:id},
          dataType: "json",
          success:function(data) {
              $('#ruangankirim_nama').val(data.ruangan_nama);
          },          
    });
               
}

function getTanggal(tgl) {
        
        $.ajax({
          type:'POST',
          url:'<?php echo $this->createUrl('getTanggalKirim'); ?>',
          data:{tgl:tgl},
          dataType: "json",
          success:function(data) {
              $('#tglkirimkantongdarah').val(data.tglkirimkantongdarah); 
          },
    });
}

function getPegawai(pegawai_id) {

     $.ajax({
         type:'POST',
         url:'<?php echo $this->createUrl('getPegawai'); ?>',
         data:{pegawai_id:pegawai_id},
         dataType: "json",
         success:function(data) {
            $('#pegawai_nama').val(data.pegawai_nama);
          },
    });
}

function getCoolbox(coolboxdarah_id) {
      $.ajax({
         type:'POST',
         url:'<?php echo $this->createUrl('getCoolbox'); ?>',
         data:{coolboxdarah_id:coolboxdarah_id},
         dataType:"json",
         success:function(data) {
             $('#jenis_coolbox').val(data.coolboxdarah_nama);
         },  
    }); 
}

function getDetailKirim() {
   var kirimkantongdarah_id = $('#kirimkantongdarah_id').val();
    
    $.ajax({
         type:'POST',
         url:'<?php echo $this->createUrl('getDetailKirim'); ?>',
         data:{kirimkantongdarah_id:kirimkantongdarah_id},
         dataType:"json",
         success:function(data) {
            $('#table-detailbarang > tbody').html(data);
            $('#table-detailbarang').removeClass("animation-loading");
            // renameInputRow($("#table-detailbarang"));
         },
         error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}

    })
}

    $(document).ready(function () {
       
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
        
        $("#nokantongutama").focus();
     });    
    
</script>

