<script type="text/javascript">

function tambahObat(){
  var nama_obat = $('#<?php echo CHtml::activeId($model, 'nama_obat'); ?>').val();
  var nama_obatpel = $('#namaobat_pel').val();
  if($('#ischeckObat').prop('checked')==true){
    nama_obat = nama_obatpel;
  }
  var reaksialergi = $('#<?php echo CHtml::activeId($model, 'reaksialergi'); ?>').val();
  var bentukreaksi = $('#<?php echo CHtml::activeId($model, 'bentukreaksi'); ?>').val();


  if(nama_obat != ''){
    var html = '<tr>' +
      '<td>'+
        '<input type="hidden" class="nama_obat" value="'+nama_obat+'" />'+
        '<input type="hidden" class="reaksialergi" value="'+reaksialergi+'" />'+
        '<input type="hidden" class="bentukreaksi" value="'+bentukreaksi+'" />'+
        '<span>'+ nama_obat +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ reaksialergi +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ bentukreaksi +'</span>'+
      '</td>'+
      '<td style="text-align: center;">'+
        '<a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan obat"><i class="icon-remove"></i></a>'+
      '</td>'+
    '</tr>';

    $('#tblObat').find('tbody').append(html);
    generateRowObat($('#tblObat').find('tbody'));

    $('#<?php echo CHtml::activeId($model, 'nama_obat'); ?>').val('');
    $('#<?php echo CHtml::activeId($model, 'reaksialergi'); ?>').val('');
    $('#<?php echo CHtml::activeId($model, 'bentukreaksi'); ?>').val('');
    $('#namaobat_pel').val('');
  }else{
    myAlert('Nama Obat Belum Diisi !!')
  }
}

function generateRowObat(obj){

  for(var i=0; i<$(obj).find('.nama_obat').length; i++){
      var trRow = $(obj).find('.nama_obat').eq(i);
      trRow.attr('id','RekonsiliasiobatdetT_'+i+'_nama_obat');
      trRow.attr('name','RekonsiliasiobatdetT['+i+'][nama_obat]');
  }
  for(var i=0; i<$(obj).find('.reaksialergi').length; i++){
      var trRow = $(obj).find('.reaksialergi').eq(i);
      trRow.attr('id','RekonsiliasiobatdetT_'+i+'_reaksialergi');
      trRow.attr('name','RekonsiliasiobatdetT['+i+'][reaksialergi]');
  }
  for(var i=0; i<$(obj).find('.bentukreaksi').length; i++){
      var trRow = $(obj).find('.bentukreaksi').eq(i);
      trRow.attr('id','RekonsiliasiobatdetT_'+i+'_bentukreaksi');
      trRow.attr('name','RekonsiliasiobatdetT['+i+'][bentukreaksi]');
  }

}

function setChangeCekObat(){
  if($('#ischeckObat').prop('checked')==true){
    $('#obat_original').hide();
    $('#obat_pelayanan').show();
  }else{
    $('#obat_original').show();
    $('#obat_pelayanan').hide();
  }
}

function batalObat(obj){
    $(obj).parents('tr').remove();
    generateRowObat($('#tblObat').find('tbody'));
}

$(document).ready(function(){
  setChangeCekObat();
});
</script>
