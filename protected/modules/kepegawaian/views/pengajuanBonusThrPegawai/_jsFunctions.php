<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">

function pilihSemua(obj){
  if($(obj).is(":checked")){
    $('#tblbonus tbody tr').each(function () {
       $(this).find('.cekList').attr('checked',true);
       setNol($(this).find('.cekList'));
   });
  }else{
    $('#tblbonus tbody tr').each(function () {
       $(this).find('.cekList').attr('checked',false);
       setNol($(this).find('.cekList'));
   });
  }
}

function pilihSemuaThr(obj){
  if($(obj).is(":checked")){
    $('#tblthr tbody tr').each(function () {
       $(this).find('.cekList').attr('checked',true);
       setNol($(this).find('.cekList'));
   });
  }else{
    $('#tblthr tbody tr').each(function () {
       $(this).find('.cekList').attr('checked',false);
       setNol($(this).find('.cekList'));
   });
  }
}

function setNol(obj){
    if($(obj).is(":checked")){
        obj.value = 1;
    }else{
        obj.value = 0;
    }
}
 function getLabel(){
     var value = $('#<?php echo CHtml::activeId($model, 'jenisgaji'); ?>').val();

     if(value == 'Bonus'){
        $('#tablepegawaiThr').hide();
        $('#tablepegawaiBonus').show();
     }else{
         $('#tablepegawaiThr').show();
     $('#tablepegawaiBonus').hide();
     }

     $('.ketlabel').html(value);
     getKeterangan();
 }

 function getKeterangan(){
     var jenis = $('#<?php echo CHtml::activeId($model, 'jenisgaji'); ?>').val();
     var periode = $('#<?php echo CHtml::activeId($model, 'periodebonusthr'); ?>').val();

     $('#<?php echo CHtml::activeId($model, 'keteranganpengajuan'); ?>').val('Pengajuan '+jenis +' Periode '+ periode);
 }

function addDetail()
{
    var jenis = $('#<?php echo CHtml::activeId($model, 'jenisgaji'); ?>').val();
    var nama_pegawai = $('#nama_pegawai').val();
    var nip = $('#nip').val();
    var instalasi_id = $('#instalasi_id').val();
    var ruangan_id = $('#ruangan_id').val();
    var unitkerja_id = $('#unitkerja_id').val();
    var kategoripegawai = $('#kategoripegawai').val();
    var kelompokpegawai_id = $('#kelompokpegawai_id').val();
    var jabatan_id = $('#jabatan_id').val();

    $("#tblbonus > tbody").html("");
    $("#tblthr > tbody").html("");

    if(jenis != ''){
        $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/addDetailPegawai'); ?>', {jenis: jenis, nama_pegawai:nama_pegawai, nip: nip, instalasi_id:instalasi_id, ruangan_id:ruangan_id, unitkerja_id:unitkerja_id, kategoripegawai:kategoripegawai, kelompokpegawai_id:kelompokpegawai_id, jabatan_id:jabatan_id},
        function (data) {
            if (data != null) {
                if(data.form != ''){
                  if(data.jenisgaji == 'Bonus'){
                      $("#tblbonus > tbody").append(data.form.replace());
                      // $("#tblbonus .integer2").maskMoney(
                      //     {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                      // );
                  }else{
                      $("#tblthr > tbody").append(data.form.replace());
                      // $("#tblthr .integer2").maskMoney(
                      //     {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                      // );
                  }
                  generateFormatNumber();
                }else{
                  myAlert('Data tidak ditemukan.!');
                }
            }
        }, "json");
    }else{
        myAlert('Silakan Jenis Gaji Harus Diisi!!!');
    }

}

function generateFormatNumber(){
  unformatNumberSemua();
  formatNumberSemua();
}

function simpanPengajuan(){
    if(requiredCheck($("form"))){
        // return false;
        $(".animation-loading").removeClass("animation-loading");
        var index = 0;
        var jenisgaji = $('#<?php echo CHtml::activeId($model, 'jenisgaji'); ?>').val();

            if(jenisgaji == 'Bonus'){
                $('#tblbonus tbody tr').each(function () {
                   if($(this).find('.cekList').is(":checked")){
                       index += 1;
                   }
               });
            }else{
                $('#tblthr tbody tr').each(function () {
                   if($(this).find('.cekList').is(":checked")){
                       index += 1;
                   }
               });
            }

            if(index == 0){
               myAlert("Tabel Pengajuan "+ jenisgaji +" Pegawai harus dipilih !!!");
               return false;
           }else{
               if(jenisgaji == 'Bonus'){
                $('#tblbonus tbody tr').each(function () {
                  if($(this).find('.cekList').is(":checked")){
                      $(this).find('input').attr('disabled',false);
                   }else{
                       $(this).find('input').attr('disabled',true);
                   }
               });
            }else{
                $('#tblthr tbody tr').each(function () {
                   if($(this).find('.cekList').is(":checked")){
                      $(this).find('input').attr('disabled',false);
                   }else{
                       $(this).find('input').attr('disabled',true);
                   }
               });
            }

                $('.integer-decimal, .float2, .integer2').each(function(){
                   $(this).val(unformatNumber($(this).val()));
               });
              $('#pengajuanbonusthrpeg-t-form').submit();
           }
    }
    return false;
}

</script>
