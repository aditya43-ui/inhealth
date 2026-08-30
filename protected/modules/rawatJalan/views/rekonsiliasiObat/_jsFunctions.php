<script type="text/javascript">
function changeIsAlergi(obj){
    var value = $(obj).val();

    if(value == true){
      $('#<?php echo CHtml::activeId($model, 'namaobat'); ?>').attr('disabled',false);
    }else{
      $('#<?php echo CHtml::activeId($model, 'namaobat'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'namaobat'); ?>').val('');
    }
}

function tambahObat(){
  var namaobat = $('#namaobat').val();
  var frekuensi = $('#frekuensi').val();
  var rute = $('#rute').val();

  if(namaobat != '' || frekuensi != '' || rute != ''){
    var html = '<tr>' +
      '<td>'+
        '<input type="hidden" class="nama_obat" value="'+namaobat+'" />'+
        '<input type="hidden" class="frekuensi_dosis" value="'+frekuensi+'" />'+
        '<input type="hidden" class="rute" value="'+rute+'" />'+
        '<span>'+ namaobat +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ frekuensi +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ rute +'</span>'+
      '</td>'+
      '<td style="text-align: center;">'+
        '<?php echo CHtml::checkbox('islanjutadmisi',false,array('class'=>'islanjutadmisi')); ?>'+
      '</td>'+
      '<td style="text-align: center;">'+
        '<a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan obat"><i class="icon-remove"></i></a>'+
      '</td>'+
    '</tr>';

    $('#tblObat').find('tbody').append(html);
    generateRowObat($('#tblObat').find('tbody'));

    $('#namaobat').val('');
    $('#frekuensi').val('');
    $('#rute').val('');
  }else{
    myAlert('Nama Obat atau frekuensi dan dosis atau rute Belum Diisi !!')
  }
}

function generateRowObat(obj){

  for(var i=0; i<$(obj).find('.nama_obat').length; i++){
      var trRow = $(obj).find('.nama_obat').eq(i);
      trRow.attr('id','RekonsiliasiobatdetT_'+i+'_nama_obat');
      trRow.attr('name','RekonsiliasiobatdetT['+i+'][nama_obat]');
  }
  for(var i=0; i<$(obj).find('.frekuensi_dosis').length; i++){
      var trRow = $(obj).find('.frekuensi_dosis').eq(i);
      trRow.attr('id','RekonsiliasiobatdetT_'+i+'_frekuensi_dosis');
      trRow.attr('name','RekonsiliasiobatdetT['+i+'][frekuensi_dosis]');
  }
  for(var i=0; i<$(obj).find('.rute').length; i++){
      var trRow = $(obj).find('.rute').eq(i);
      trRow.attr('id','RekonsiliasiobatdetT_'+i+'_rute');
      trRow.attr('name','RekonsiliasiobatdetT['+i+'][rute]');
  }
  for(var i=0; i<$(obj).find('.islanjutadmisi').length; i++){
      var trRow = $(obj).find('.islanjutadmisi').eq(i);
      trRow.attr('id','RekonsiliasiobatdetT_'+i+'_islanjutadmisi');
      trRow.attr('name','RekonsiliasiobatdetT['+i+'][islanjutadmisi]');
      // trRow.attr('value',false);
  }
}

function batalObat(obj){
    $(obj).parents('tr').remove();
    generateRowObat($('#tblObat').find('tbody'));
}

$(document).ready(function(){

});
</script>
