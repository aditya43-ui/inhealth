<script type="text/javascript">

function tambahObat(){
  var nama_obat = $('#nama_obat').val();
  var nama_obatpel = $('#namaobat_pel').val();
  if($('#ischeckObat').prop('checked')==true){
    nama_obat = nama_obatpel;
  }

  var dosis = $('#dosis').val();
  var frekuensi = $('#frekuensi').val();
  var cara_pemberian = $('#cara_pemberian').val();
  var waktu_pemberian = $('#waktu_pemberian').val();
  var jumlah_obat = $('#jumlah_obat').val();
  var tindaklanjut = $('#tindaklanjut').val();
  var keterangan = $('#keterangan').val();

  if(nama_obat != ''){
    var html = '<tr>' +
      '<td>'+
        '<input type="hidden" class="nama_obat" value="'+nama_obat+'" />'+
        '<input type="hidden" class="dosis" value="'+dosis+'" />'+
        '<input type="hidden" class="frekuensi" value="'+frekuensi+'" />'+
        '<input type="hidden" class="cara_pemberian" value="'+cara_pemberian+'" />'+
        '<input type="hidden" class="waktu_pemberian" value="'+waktu_pemberian+'" />'+
        '<input type="hidden" class="jumlah_obat" value="'+jumlah_obat+'" />'+
        '<input type="hidden" class="tindaklanjut" value="'+tindaklanjut+'" />'+
        '<input type="hidden" class="keterangan" value="'+keterangan+'" />'+
        '<span>'+ nama_obat +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ frekuensi +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ dosis +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ cara_pemberian +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ waktu_pemberian +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jumlah_obat +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ tindaklanjut +'</span>'+
      '</td>'+
      '<td style="text-align: center;">'+
        '<a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan obat"><i class="icon-remove"></i></a>'+
      '</td>'+
    '</tr>';

    $('#tblObat').find('tbody').append(html);
    generateRowObat($('#tblObat').find('tbody'));

    $('#nama_obat').val('');
    $('#dosis').val('');
    $('#frekuensi').val('');
    $('#cara_pemberian').val('');
    $('#waktu_pemberian').val('');
    $('#jumlah_obat').val('');
    $('#tindaklanjut').val('');
    $('#keterangan').val('');
    $('#namaobat_pel').val('');
  }else{
    myAlert('Nama Obat Belum Diisi !!')
  }
}

function generateRowObat(obj){

  for(var i=0; i<$(obj).find('.nama_obat').length; i++){
      var trRow = $(obj).find('.nama_obat').eq(i);
      trRow.attr('id','RekonobatadmisidetT_'+i+'_nama_obat');
      trRow.attr('name','RekonobatadmisidetT['+i+'][nama_obat]');
  }
  for(var i=0; i<$(obj).find('.dosis').length; i++){
      var trRow = $(obj).find('.dosis').eq(i);
      trRow.attr('id','RekonobatadmisidetT_'+i+'_dosis');
      trRow.attr('name','RekonobatadmisidetT['+i+'][dosis]');
  }
  for(var i=0; i<$(obj).find('.frekuensi').length; i++){
      var trRow = $(obj).find('.frekuensi').eq(i);
      trRow.attr('id','RekonobatadmisidetT_'+i+'_frekuensi');
      trRow.attr('name','RekonobatadmisidetT['+i+'][frekuensi]');
  }
  for(var i=0; i<$(obj).find('.cara_pemberian').length; i++){
      var trRow = $(obj).find('.cara_pemberian').eq(i);
      trRow.attr('id','RekonobatadmisidetT_'+i+'_cara_pemberian');
      trRow.attr('name','RekonobatadmisidetT['+i+'][cara_pemberian]');
  }
  for(var i=0; i<$(obj).find('.waktu_pemberian').length; i++){
      var trRow = $(obj).find('.waktu_pemberian').eq(i);
      trRow.attr('id','RekonobatadmisidetT_'+i+'_waktu_pemberian');
      trRow.attr('name','RekonobatadmisidetT['+i+'][waktu_pemberian]');
  }
  for(var i=0; i<$(obj).find('.jumlah_obat').length; i++){
      var trRow = $(obj).find('.jumlah_obat').eq(i);
      trRow.attr('id','RekonobatadmisidetT_'+i+'_jumlah_obat');
      trRow.attr('name','RekonobatadmisidetT['+i+'][jumlah_obat]');
  }
  for(var i=0; i<$(obj).find('.tindaklanjut').length; i++){
      var trRow = $(obj).find('.tindaklanjut').eq(i);
      trRow.attr('id','RekonobatadmisidetT_'+i+'_tindaklanjut');
      trRow.attr('name','RekonobatadmisidetT['+i+'][tindaklanjut]');
  }
  for(var i=0; i<$(obj).find('.keterangan').length; i++){
      var trRow = $(obj).find('.keterangan').eq(i);
      trRow.attr('id','RekonobatadmisidetT_'+i+'_keterangan');
      trRow.attr('name','RekonobatadmisidetT['+i+'][keterangan]');
  }

}

function batalObat(obj){
    $(obj).parents('tr').remove();
    generateRowObat($('#tblObat').find('tbody'));
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

$(document).ready(function(){
  setChangeCekObat();
});
</script>
