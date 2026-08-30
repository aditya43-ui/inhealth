<script type="text/javascript">
function getValueRadio(obj){
  var val = "";

  for (var i=0; i<$(obj).length; i++){
    if ( $(obj).eq(i).prop('checked')==true ) {
            val = $(obj).eq(i).val();
            break;
        }
  }

  return val;
}
function resetRadioButton(obj){
  for (var i=0; i<$(obj).length; i++){
    $(obj).eq(i).attr('checked',false);
  }
}
function statusPenggunaCairanMasuk(){
  var index = 0;
  var indexLainnya = 0;
  $('.statuspenggunaan').each(function(){
    if($(this).val()=='1' &&  $(this).prop('checked')==true){
      $('#keteranganMasuk').show();
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('#keteranganMasuk').hide();
    $('#keterangan').val('');
  }
}

function tambahCairanMasuk(){
  var nama_cairan = $('#nama_cairan').val();
  var waktu_pemberian = getValueRadio($('.waktu_pemberian'));
  var jumlah = $('#jumlah').val();
  var statuspenggunaan = getValueRadio($('.statuspenggunaan'));
  var keterangan = $('#keterangan').val();
  var waktu_pemasangan = $('#waktu_pemasangan').val();
  var jam_pemberian = $('#jam_pemberian').val();
  var satuan_jumlah = $('#satuan_jumlah').val();

  if(nama_cairan != ''){
    var statuspenggunaanText = "";
    if(statuspenggunaan=='1'){
      statuspenggunaanText = "Ya";
    }else if(statuspenggunaan=='0'){
      statuspenggunaanText = "Tidak";
    }
    var html = '<tr>' +
      '<td>'+
        '<input type="hidden" class="nama_cairan" value="'+nama_cairan+'" />'+
        '<input type="hidden" class="waktu_pemberian" value="'+waktu_pemberian+'" />'+
        '<input type="hidden" class="jumlah float2" value="'+jumlah+'" />'+
        '<input type="hidden" class="statuspenggunaan" value="'+statuspenggunaan+'" />'+
        '<input type="hidden" class="keterangan" value="'+keterangan+'" />'+
        '<input type="hidden" class="waktu_pemasangan" value="'+waktu_pemasangan+'" />'+
        '<input type="hidden" class="jam_pemberian" value="'+jam_pemberian+'" />'+
        '<input type="hidden" class="satuan_jumlah" value="'+satuan_jumlah+'" />'+
        '<span class="nourut"></span>'+
      '</td>'+
      '<td>'+
        '<span>'+ nama_cairan +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ waktu_pemberian +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jam_pemberian +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jumlah +' '+satuan_jumlah +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ statuspenggunaanText +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ keterangan +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ waktu_pemasangan +'</span>'+
      '</td>'+
      '<td style="text-align: center;">'+
        '<a onclick="batalCairanMasuk(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Cairan Masuk"><i class="icon-remove"></i></a>'+
      '</td>'+
    '</tr>';

    $('#tblCairanMasuk').find('tbody').append(html);
    generateRowCairanMasuk($('#tblCairanMasuk').find('tbody'));

    $('#nama_cairan').val('');
    resetRadioButton($('.waktu_pemberian'));
    $('#jumlah').val('');
    resetRadioButton($('.statuspenggunaan'));
    $('#keterangan').val('');
    $('#waktu_pemasangan').val('');
    $('#jam_pemberian').val('');
    $('#satuan_jumlah').val('');
    hitungTotalCairanMasuk();
  }else{
    myAlert('Nama Cairan Belum Diisi !!')
  }
}

function generateRowCairanMasuk(obj){
  var nourut = 1;
  for(var i=0; i<$(obj).find('.nourut').length; i++){
      var trRow = $(obj).find('.nourut').eq(i);
      trRow.html(nourut);
      nourut++;
  }

  for(var i=0; i<$(obj).find('.nama_cairan').length; i++){
      var trRow = $(obj).find('.nama_cairan').eq(i);
      trRow.attr('id','BalancecairanmasukT_'+i+'_nama_cairan');
      trRow.attr('name','BalancecairanmasukT['+i+'][nama_cairan]');
  }
  for(var i=0; i<$(obj).find('.waktu_pemberian').length; i++){
      var trRow = $(obj).find('.waktu_pemberian').eq(i);
      trRow.attr('id','BalancecairanmasukT_'+i+'_waktu_pemberian');
      trRow.attr('name','BalancecairanmasukT['+i+'][waktu_pemberian]');
  }
  for(var i=0; i<$(obj).find('.jumlah').length; i++){
      var trRow = $(obj).find('.jumlah').eq(i);
      trRow.attr('id','BalancecairanmasukT_'+i+'_jumlah');
      trRow.attr('name','BalancecairanmasukT['+i+'][jumlah]');
  }
  for(var i=0; i<$(obj).find('.statuspenggunaan').length; i++){
      var trRow = $(obj).find('.statuspenggunaan').eq(i);
      trRow.attr('id','BalancecairanmasukT_'+i+'_statuspenggunaan');
      trRow.attr('name','BalancecairanmasukT['+i+'][statuspenggunaan]');
  }
  for(var i=0; i<$(obj).find('.keterangan').length; i++){
      var trRow = $(obj).find('.keterangan').eq(i);
      trRow.attr('id','BalancecairanmasukT_'+i+'_keterangan');
      trRow.attr('name','BalancecairanmasukT['+i+'][keterangan]');
  }
  for(var i=0; i<$(obj).find('.waktu_pemasangan').length; i++){
      var trRow = $(obj).find('.waktu_pemasangan').eq(i);
      trRow.attr('id','BalancecairanmasukT_'+i+'_waktu_pemasangan');
      trRow.attr('name','BalancecairanmasukT['+i+'][waktu_pemasangan]');
  }

  for(var i=0; i<$(obj).find('.jam_pemberian').length; i++){
      var trRow = $(obj).find('.jam_pemberian').eq(i);
      trRow.attr('id','BalancecairanmasukT_'+i+'_jam_pemberian');
      trRow.attr('name','BalancecairanmasukT['+i+'][jam_pemberian]');
  }

  for(var i=0; i<$(obj).find('.satuan_jumlah').length; i++){
      var trRow = $(obj).find('.satuan_jumlah').eq(i);
      trRow.attr('id','BalancecairanmasukT_'+i+'_satuan_jumlah');
      trRow.attr('name','BalancecairanmasukT['+i+'][satuan_jumlah]');
  }

}

function batalCairanMasuk(obj){
    $(obj).parents('tr').remove();
    generateRowCairanMasuk($('#tblCairanMasuk').find('tbody'));
    hitungTotalCairanMasuk();
}

function setCairanKeluar(){
  resetRadioButton($('.statuspenggunaankeluar'));
  statusPenggunaCairanKeluar();
}

function statusPenggunaCairanKeluar(){
  var index = 0;
  var indexLainnya = 0;
  $('.statuspenggunaankeluar').each(function(){
    if($(this).val()=='1' &&  $(this).prop('checked')==true && ($('#nama_cairankeluar').val()=='Muntah' || $('#nama_cairankeluar').val()=='Defekasi')){
      $('#keteranganKeluar').hide();
      $('#keteranganKeluarV2').show();
      indexLainnya = 1;
    }else if($(this).val()=='1' &&  $(this).prop('checked')==true && ($('#nama_cairankeluar').val()!='Muntah' && $('#nama_cairankeluar').val()!='Defekasi')){
      $('#keteranganKeluar').show();
      $('#keteranganKeluarV2').hide();
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('#keteranganKeluar').hide();
    $('#keterangankeluar').val('');

    $('#keteranganKeluarV2').hide();
    $('#keterangankeluar_v2').val('');
  }
}

function tambahCairanKeluar(){
  var nama_cairan = $('#nama_cairankeluar').val();
  var waktu_pemberian = getValueRadio($('.waktu_pemberiankeluar'));
  var jumlah = $('#jumlahkeluar').val();
  var statuspenggunaan = getValueRadio($('.statuspenggunaankeluar'));
  var keterangan_v1 = $('#keterangankeluar').val();
  var keterangan_v2 = $('#keterangankeluar_v2').val();
  var balance_cairan = $('#balance_cairan').val();
  var waktu_pemasangan = $('#waktu_pemasangankeluar').val();
  var jam = $('#jam').val();
  var satuan_jumlah = $('#satuan_jumlahkeluar').val();

  var keterangan = "";

  if(keterangan_v2 != ''){
    keterangan = keterangan_v2;
  }else if(keterangan_v1 != ''){
    keterangan = keterangan_v1;
  }

  if(nama_cairan != ''){
    var statuspenggunaanText = "";
    if(statuspenggunaan=='1'){
      statuspenggunaanText = "Ya";
    }else if(statuspenggunaan=='0'){
      statuspenggunaanText = "Tidak";
    }
    var html = '<tr>' +
      '<td>'+
        '<input type="hidden" class="nama_cairan" value="'+nama_cairan+'" />'+
        '<input type="hidden" class="waktu_pemberian" value="'+waktu_pemberian+'" />'+
        '<input type="hidden" class="jumlah float2" value="'+jumlah+'" />'+
        '<input type="hidden" class="statuspenggunaan" value="'+statuspenggunaan+'" />'+
        '<input type="hidden" class="keterangan" value="'+keterangan+'" />'+
        '<input type="hidden" class="waktu_pemasangan" value="'+waktu_pemasangan+'" />'+
        '<input type="hidden" class="balance_cairan" value="'+balance_cairan+'" />'+
        '<input type="hidden" class="jam" value="'+jam+'" />'+
        '<input type="hidden" class="satuan_jumlah" value="'+satuan_jumlah+'" />'+
        '<span class="nourut"></span>'+
      '</td>'+
      '<td>'+
        '<span>'+ nama_cairan +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jam +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ waktu_pemberian +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jumlah + ' '+ satuan_jumlah +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ statuspenggunaanText +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ keterangan +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ waktu_pemasangan +'</span>'+
      '</td>'+
      '<td style="text-align: center;">'+
        '<a onclick="batalCairanKeluar(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Cairan Keluar"><i class="icon-remove"></i></a>'+
      '</td>'+
    '</tr>';

    $('#tblCairanKeluar').find('tbody').append(html);
    generateRowCairanKeluar($('#tblCairanKeluar').find('tbody'));

    $('#nama_cairankeluar').val('');
    resetRadioButton($('.waktu_pemberiankeluar'));
    $('#jumlahkeluar').val('');
    resetRadioButton($('.statuspenggunaankeluar'));
    $('#keterangankeluar').val('');
    $('#keterangankeluar_v2').val('');
    $('#balance_cairan').val('');
    $('#waktu_pemasangankeluar').val('');
    $('#jam').val();
    $('#satuan_jumlahkeluar').val();
    setCairanKeluar();
  }else{
    myAlert('Nama Cairan Belum Diisi !!')
  }
}

function generateRowCairanKeluar(obj){
  var nourut = 1;
  for(var i=0; i<$(obj).find('.nourut').length; i++){
      var trRow = $(obj).find('.nourut').eq(i);
      trRow.html(nourut);
      nourut++;
  }

  for(var i=0; i<$(obj).find('.nama_cairan').length; i++){
      var trRow = $(obj).find('.nama_cairan').eq(i);
      trRow.attr('id','BalancecairankeluarT_'+i+'_nama_cairan');
      trRow.attr('name','BalancecairankeluarT['+i+'][nama_cairan]');
  }
  for(var i=0; i<$(obj).find('.waktu_pemberian').length; i++){
      var trRow = $(obj).find('.waktu_pemberian').eq(i);
      trRow.attr('id','BalancecairankeluarT_'+i+'_waktu_pemberian');
      trRow.attr('name','BalancecairankeluarT['+i+'][waktu_pemberian]');
  }
  for(var i=0; i<$(obj).find('.jumlah').length; i++){
      var trRow = $(obj).find('.jumlah').eq(i);
      trRow.attr('id','BalancecairankeluarT_'+i+'_jumlah');
      trRow.attr('name','BalancecairankeluarT['+i+'][jumlah]');
  }
  for(var i=0; i<$(obj).find('.statuspenggunaan').length; i++){
      var trRow = $(obj).find('.statuspenggunaan').eq(i);
      trRow.attr('id','BalancecairankeluarT_'+i+'_statuspenggunaan');
      trRow.attr('name','BalancecairankeluarT['+i+'][statuspenggunaan]');
  }
  for(var i=0; i<$(obj).find('.keterangan').length; i++){
      var trRow = $(obj).find('.keterangan').eq(i);
      trRow.attr('id','BalancecairankeluarT_'+i+'_keterangan');
      trRow.attr('name','BalancecairankeluarT['+i+'][keterangan]');
  }
  for(var i=0; i<$(obj).find('.waktu_pemasangan').length; i++){
      var trRow = $(obj).find('.waktu_pemasangan').eq(i);
      trRow.attr('id','BalancecairankeluarT_'+i+'_waktu_pemasangan');
      trRow.attr('name','BalancecairankeluarT['+i+'][waktu_pemasangan]');
  }
  for(var i=0; i<$(obj).find('.balance_cairan').length; i++){
      var trRow = $(obj).find('.balance_cairan').eq(i);
      trRow.attr('id','BalancecairankeluarT_'+i+'_balance_cairan');
      trRow.attr('name','BalancecairankeluarT['+i+'][balance_cairan]');
  }

  for(var i=0; i<$(obj).find('.jam').length; i++){
      var trRow = $(obj).find('.jam').eq(i);
      trRow.attr('id','BalancecairankeluarT_'+i+'_jam');
      trRow.attr('name','BalancecairankeluarT['+i+'][jam]');
  }

  for(var i=0; i<$(obj).find('.satuan_jumlah').length; i++){
      var trRow = $(obj).find('.satuan_jumlah').eq(i);
      trRow.attr('id','BalancecairankeluarT_'+i+'_satuan_jumlah');
      trRow.attr('name','BalancecairankeluarT['+i+'][satuan_jumlah]');
  }
}

function batalCairanKeluar(obj){
    $(obj).parents('tr').remove();
    generateRowCairanKeluar($('#tblCairanKeluar').find('tbody'));
}

function tambahOksigen(){
  var waktu_pemberian = getValueRadio($('.waktu_pemberianoksigen'));
  var jumlah = $('#jumlahoksigen').val();
  var keterangan = $('#list_oksigen').val();
  var jam_pemberian = $('#jam_pemberianoksigen').val();
  var satuan_jumlah = $('#satuan_jumlahoksigen').val();

  if(waktu_pemberian != ''){

    var html = '<tr>' +
      '<td>'+
        '<input type="hidden" class="waktu_pemberian" value="'+waktu_pemberian+'" />'+
        '<input type="hidden" class="jumlah float2" value="'+jumlah+'" />'+
        '<input type="hidden" class="list_oksigen" value="'+keterangan+'" />'+
        '<input type="hidden" class="jam_pemberian" value="'+jam_pemberian+'" />'+
        '<input type="hidden" class="satuan_jumlah" value="'+satuan_jumlah+'" />'+
        '<span class="nourut"></span>'+
      '</td>'+
      '<td>'+
        '<span>'+ waktu_pemberian +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jam_pemberian +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jumlah+ ' '+ satuan_jumlah +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ keterangan +'</span>'+
      '</td>'+
      '<td style="text-align: center;">'+
        '<a onclick="batalOksigen(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Oksigen"><i class="icon-remove"></i></a>'+
      '</td>'+
    '</tr>';

    $('#tblOksigen').find('tbody').append(html);
    generateRowOksigen($('#tblOksigen').find('tbody'));

    resetRadioButton($('.waktu_pemberianoksigen'));
    $('#jumlahoksigen').val('');
    $('#list_oksigen').val('');
    $('#jam_pemberianoksigen').val('');
    $('#satuan_jumlahoksigen').val('');
  }else{
    myAlert('Waktu Pemberian Belum Diisi !!')
  }
}

function generateRowOksigen(obj){
  var nourut = 1;
  for(var i=0; i<$(obj).find('.nourut').length; i++){
      var trRow = $(obj).find('.nourut').eq(i);
      trRow.html(nourut);
      nourut++;
  }

  for(var i=0; i<$(obj).find('.waktu_pemberian').length; i++){
      var trRow = $(obj).find('.waktu_pemberian').eq(i);
      trRow.attr('id','BalancecairanoksigenT_'+i+'_waktu_pemberian');
      trRow.attr('name','BalancecairanoksigenT['+i+'][waktu_pemberian]');
  }
  for(var i=0; i<$(obj).find('.jumlah').length; i++){
      var trRow = $(obj).find('.jumlah').eq(i);
      trRow.attr('id','BalancecairanoksigenT_'+i+'_jumlah');
      trRow.attr('name','BalancecairanoksigenT['+i+'][jumlah]');
  }
  for(var i=0; i<$(obj).find('.list_oksigen').length; i++){
      var trRow = $(obj).find('.list_oksigen').eq(i);
      trRow.attr('id','BalancecairanoksigenT_'+i+'_list_oksigen');
      trRow.attr('name','BalancecairanoksigenT['+i+'][list_oksigen]');
  }

  for(var i=0; i<$(obj).find('.jam_pemberian').length; i++){
      var trRow = $(obj).find('.jam_pemberian').eq(i);
      trRow.attr('id','BalancecairanoksigenT_'+i+'_jam_pemberian');
      trRow.attr('name','BalancecairanoksigenT['+i+'][jam_pemberian]');
  }

  for(var i=0; i<$(obj).find('.satuan_jumlah').length; i++){
      var trRow = $(obj).find('.satuan_jumlah').eq(i);
      trRow.attr('id','BalancecairanoksigenT_'+i+'_satuan_jumlah');
      trRow.attr('name','BalancecairanoksigenT['+i+'][satuan_jumlah]');
  }

}

function batalOksigen(obj){
    $(obj).parents('tr').remove();
    generateRowOksigen($('#tblOksigen').find('tbody'));
}

function tambahDiet(){
  var waktu_pemberian = getValueRadio($('.waktu_pemberiadiet'));
  var jumlah = $('#jumlahdiet').val();
  var keterangan = $('#keterangandiet').val();
  var jam_pemberian = $('#jam_pemberiandiet').val();
  var satuan_jumlah = $('#satuan_jumlahdiet').val();

  if(waktu_pemberian != ''){

    var html = '<tr>' +
      '<td>'+
        '<input type="hidden" class="waktu_pemberian" value="'+waktu_pemberian+'" />'+
        '<input type="hidden" class="jumlah float2" value="'+jumlah+'" />'+
        '<input type="hidden" class="keterangan" value="'+keterangan+'" />'+
        '<input type="hidden" class="jam_pemberian" value="'+jam_pemberian+'" />'+
        '<input type="hidden" class="satuan_jumlah" value="'+satuan_jumlah+'" />'+
        '<span class="nourut"></span>'+
      '</td>'+
      '<td>'+
        '<span>'+ waktu_pemberian +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jam_pemberian +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jumlah + ' '+ satuan_jumlah +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ keterangan +'</span>'+
      '</td>'+
      '<td style="text-align: center;">'+
        '<a onclick="batalDiet(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Oksigen"><i class="icon-remove"></i></a>'+
      '</td>'+
    '</tr>';

    $('#tblDiet').find('tbody').append(html);
    generateRowDiet($('#tblDiet').find('tbody'));

    resetRadioButton($('.waktu_pemberiadiet'));
    $('#jumlahdiet').val('');
    $('#keterangandiet').val('');
    $('#jam_pemberiandiet').val('');
    $('#satuan_jumlahdiet').val('');
  }else{
    myAlert('Waktu Pemberian Belum Diisi !!')
  }
}

function generateRowDiet(obj){
  var nourut = 1;
  for(var i=0; i<$(obj).find('.nourut').length; i++){
      var trRow = $(obj).find('.nourut').eq(i);
      trRow.html(nourut);
      nourut++;
  }


  for(var i=0; i<$(obj).find('.waktu_pemberian').length; i++){
      var trRow = $(obj).find('.waktu_pemberian').eq(i);
      trRow.attr('id','BalancecairandietT_'+i+'_waktu_pemberian');
      trRow.attr('name','BalancecairandietT['+i+'][waktu_pemberian]');
  }
  for(var i=0; i<$(obj).find('.jumlah').length; i++){
      var trRow = $(obj).find('.jumlah').eq(i);
      trRow.attr('id','BalancecairandietT_'+i+'_jumlah');
      trRow.attr('name','BalancecairandietT['+i+'][jumlah]');
  }
  for(var i=0; i<$(obj).find('.keterangan').length; i++){
      var trRow = $(obj).find('.keterangan').eq(i);
      trRow.attr('id','BalancecairandietT_'+i+'_keterangan');
      trRow.attr('name','BalancecairandietT['+i+'][keterangan]');
  }

  for(var i=0; i<$(obj).find('.jam_pemberian').length; i++){
      var trRow = $(obj).find('.jam_pemberian').eq(i);
      trRow.attr('id','BalancecairandietT_'+i+'_jam_pemberian');
      trRow.attr('name','BalancecairandietT['+i+'][jam_pemberian]');
  }

  for(var i=0; i<$(obj).find('.satuan_jumlah').length; i++){
      var trRow = $(obj).find('.satuan_jumlah').eq(i);
      trRow.attr('id','BalancecairandietT_'+i+'_satuan_jumlah');
      trRow.attr('name','BalancecairandietT['+i+'][satuan_jumlah]');
  }
}

function batalDiet(obj){
    $(obj).parents('tr').remove();
    generateRowDiet($('#tblDiet').find('tbody'));
}

function tambahInfus(){
  var nama_program = $('#nama_program').val();
  var waktu = $('#waktu').val();
  var jenis = $('#jenis').val();
  var jumlah = $('#jumlahinfus').val();
  var tetes = $('#tetes').val();
  var keterangan = $('#keteranganinfus').val();
  var satuan_jumlah = $('#satuan_jumlahinfus').val();


  if(nama_program != ''){

    var html = '<tr>' +
      '<td>'+
        '<input type="hidden" class="nama_program" value="'+nama_program+'" />'+
        '<input type="hidden" class="waktu" value="'+waktu+'" />'+
        '<input type="hidden" class="jenis" value="'+jenis+'" />'+
        '<input type="hidden" class="jumlah float2" value="'+jumlah+'" />'+
        '<input type="hidden" class="tetes" value="'+tetes+'" />'+
        '<input type="hidden" class="keterangan" value="'+keterangan+'" />'+
        '<input type="hidden" class="satuan_jumlah" value="'+satuan_jumlah+'" />'+
        '<span>'+ nama_program +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ waktu +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jenis +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jumlah + ' '+satuan_jumlah +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ tetes +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ keterangan +'</span>'+
      '</td>'+
      '<td style="text-align: center;">'+
        '<a onclick="batalInfus(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Infus"><i class="icon-remove"></i></a>'+
      '</td>'+
    '</tr>';

    $('#tblInfus').find('tbody').append(html);
    generateRowInfus($('#tblInfus').find('tbody'));

    $('#nama_program').val('');
    $('#waktu').val('');
    $('#jumlahinfus').val('');
    $('#jenis').val('');
    $('#tetes').val('');
    $('#keteranganinfus').val('');
    $('#satuan_jumlahinfus').val('')
  }else{
    myAlert('Nama Program Belum Diisi !!')
  }
}

function generateRowInfus(obj){
  for(var i=0; i<$(obj).find('.nama_program').length; i++){
      var trRow = $(obj).find('.nama_program').eq(i);
      trRow.attr('id','PrograminfusT_'+i+'_nama_program');
      trRow.attr('name','PrograminfusT['+i+'][nama_program]');
  }
  for(var i=0; i<$(obj).find('.waktu').length; i++){
      var trRow = $(obj).find('.waktu').eq(i);
      trRow.attr('id','PrograminfusT_'+i+'_waktu');
      trRow.attr('name','PrograminfusT['+i+'][waktu]');
  }
  for(var i=0; i<$(obj).find('.jenis').length; i++){
      var trRow = $(obj).find('.jenis').eq(i);
      trRow.attr('id','PrograminfusT_'+i+'_jenis');
      trRow.attr('name','PrograminfusT['+i+'][jenis]');
  }
  for(var i=0; i<$(obj).find('.jumlah').length; i++){
      var trRow = $(obj).find('.jumlah').eq(i);
      trRow.attr('id','PrograminfusT_'+i+'_jumlah');
      trRow.attr('name','PrograminfusT['+i+'][jumlah]');
  }
  for(var i=0; i<$(obj).find('.tetes').length; i++){
      var trRow = $(obj).find('.tetes').eq(i);
      trRow.attr('id','PrograminfusT_'+i+'_tetes');
      trRow.attr('name','PrograminfusT['+i+'][tetes]');
  }
  for(var i=0; i<$(obj).find('.nama_program').length; i++){
      var trRow = $(obj).find('.nama_program').eq(i);
      trRow.attr('id','PrograminfusT_'+i+'_nama_program');
      trRow.attr('name','PrograminfusT['+i+'][nama_program]');
  }
  for(var i=0; i<$(obj).find('.keterangan').length; i++){
      var trRow = $(obj).find('.keterangan').eq(i);
      trRow.attr('id','PrograminfusT_'+i+'_keterangan');
      trRow.attr('name','PrograminfusT['+i+'][keterangan]');
  }
  for(var i=0; i<$(obj).find('.satuan_jumlah').length; i++){
      var trRow = $(obj).find('.satuan_jumlah').eq(i);
      trRow.attr('id','PrograminfusT_'+i+'_satuan_jumlah');
      trRow.attr('name','PrograminfusT['+i+'][satuan_jumlah]');
  }

}

function batalInfus(obj){
    $(obj).parents('tr').remove();
    generateRowInfus($('#tblInfus').find('tbody'));
}

function print(pasienadmisi_id, tanggal)
{
    window.open('<?php echo $this->createUrl('print'); ?>&pasienadmisi_id='+pasienadmisi_id+'&tgl_pencatatan='+tanggal,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
}

function hapusRiwayat(id) {
    myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('hapusRiwayat'); ?>', {id: id}, function(data) {
                if (data.sukses == 1) {
                    myAlert(data.msg);
                    window.location.replace('<?php echo $this->createUrl('index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$model->pasienadmisi_id)); ?>');
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}
function changeIwl(){
  var index = 0;
  var indexLainnya = 0;
  $('.chpoiseIWL').each(function(){
    if($(this).val()=='Dewasa' &&  $(this).prop('checked')==true){
      indexLainnya = 1;
      $('#konstanta').val(formatInteger(15));
      $('.iwldewasa').show();
      $('.iwlanak').hide();
      $('.iwneonatus').hide();
      $('#usia_anak').val(formatInteger(0));
      $('.konstanta_neonatus').hide();
      $('.konstanta_dewasa').show();
      $('#konstanta_neonatus').val(formatInteger(0));
    }else if($(this).val()=='Anak' &&  $(this).prop('checked')==true){
      indexLainnya = 2;
      $('#konstanta').val(formatInteger(30));
      $('.iwldewasa').hide();
      $('.iwlanak').show();
      $('.iwneonatus').hide();
      $('#konstanta_neonatus').val(formatInteger(0));
      $('.konstanta_neonatus').hide();
      $('.konstanta_dewasa').show();
    }else if($(this).val()=='Neonatus' &&  $(this).prop('checked')==true){
      indexLainnya = 3;
      $('#konstanta').val(formatInteger(0));
      $('#konstanta_neonatus').val(formatInteger(0));
      $('.konstanta_dewasa').hide();
      $('.konstanta_neonatus').show();
      $('.iwldewasa').hide();
      $('.iwlanak').hide();
      $('.iwneonatus').show();
      $('#usia_anak').val(formatInteger(0));
    }else{
      index++;
    }
  });

  if(index <= 3 && indexLainnya == 0){
    $('#konstanta').val(formatInteger(0));
    $('.iwldewasa').show();
    $('.iwlanak').hide();
    $('.iwneonatus').hide();
    $('#usia_anak').val(formatInteger(0));
    $('#konstanta_neonatus').val(formatInteger(0));
    $('.konstanta_neonatus').hide();
    $('.konstanta_dewasa').show();
  }
}
function hitungIwl(){
  unformatNumberSemua();
  var konstanta  = parseInt($('#konstanta').val());
  var beratbadan_kg  = parseFloat($('#beratbadan_kg').val());
  var usia_anak  = parseInt($('#usia_anak').val());
  var chpoiseIWL = getValueRadio($('.chpoiseIWL'));

  var iwlperjam = 0;
  if(chpoiseIWL == 'Dewasa'){
    iwlperjam = (konstanta * beratbadan_kg);
    iwlperjam = (iwlperjam/24);

  }else if(chpoiseIWL == 'Anak'){
    iwlperjam = (konstanta - usia_anak);
    iwlperjam = (iwlperjam * beratbadan_kg);
    iwlperjam = (iwlperjam/24);
  }else if(chpoiseIWL == 'Neonatus'){
    konstanta = 0;
    if(beratbadan_kg >= 0.750 && beratbadan_kg <= 1.000){
      konstanta = 64;
    }else if(beratbadan_kg >= 1.001 && beratbadan_kg <= 1.250){
      konstanta = 56;
    }else if(beratbadan_kg >= 1.251 && beratbadan_kg <= 1.500){
      konstanta = 38;
    }else if(beratbadan_kg >= 1.501 && beratbadan_kg <= 1.750){
      konstanta = 23;
    }else if(beratbadan_kg >= 1.751 && beratbadan_kg <= 3.500){
      konstanta = 20;
    }
    $('#konstanta_neonatus').val(konstanta);
    iwlperjam = (konstanta * beratbadan_kg);
    iwlperjam = (iwlperjam/24);
  }

  if (iwlperjam > 0){
     iwlperjam = parseFloat(iwlperjam.toFixed(3));
  }

  $('#iwlperjam_normal').val(iwlperjam);
  $('#jmljamiwl_perhitungan').val(iwlperjam);
  formatNumberSemua();
  totalAkhirIWL();
}

function hitungTotalCairanMasuk(){
  unformatNumberSemua();
  var total = 0;
  $('#tblCairanMasuk').find('tbody tr').each(function(){
    var jumlah  = parseFloat($(this).find('input[name$="[jumlah]"]').val());
    total += jumlah;
  });
  $('#cairanmasuk_total').val(total);
  formatNumberSemua();
}

function hitungIwlKenaikanSuhu(){
  unformatNumberSemua();
  var konstantasuhu  = parseFloat($('#konstantasuhu').val());
  var cairanmasuk_total  = parseFloat($('#cairanmasuk_total').val());
  var kenaikansuhutubuh_jml  = parseFloat($('#kenaikansuhutubuh_jml').val());
  var iwlperjam_normal  = parseFloat($('#iwlperjam_normal').val());

  var jml = (((((konstantasuhu / 100) * cairanmasuk_total) * kenaikansuhutubuh_jml) / 24)+iwlperjam_normal);

  if (jml > 0){
     jml = parseFloat(jml.toFixed(3));
  }
  $('#iwlperjam_kenaikansuhu').val(jml);
  $('#jmljamiwl_perhitungan').val(jml);
  formatNumberSemua();
  totalAkhirIWL();
}

function changeJamPemeriksaan(){
  var jamper = 0;
  if($('#jmljam_pemeriksaan').val() != ''){
      jamper = parseInt($('#jmljam_pemeriksaan').val());
  }

  $('#nilaiperjam').val(formatInteger(jamper));
  totalAkhirIWL();
}

function totalAkhirIWL(){
  unformatNumberSemua();
  var jmljamiwl_perhitungan  = parseFloat($('#jmljamiwl_perhitungan').val());
  var nilaiperjam  = parseInt($('#jmljam_pemeriksaan').val());
  var total = (jmljamiwl_perhitungan * nilaiperjam);
  if (total > 0){
     total = parseFloat(total.toFixed(3));
  }

  $('#iwl_nilaiakhir').val(total);
  formatNumberSemua();
}

function changeTerjadiSuhu(){
  if($('#isterjadikenaikansuhu').prop('checked')==true){
    $('#konstantasuhu').val(10);
    $('#pnlkenaikansuhu').find('input, select').each(function(){
      $(this).attr('disabled',false);
    });
    $('#pnlkenaikansuhu').show();
    hitungTotalCairanMasuk();
    hitungIwlKenaikanSuhu();
  }else{
    $('#pnlkenaikansuhu').find('input, select').each(function(){
      $(this).attr('disabled',true);
      $(this).val('');
    });
    $('#pnlkenaikansuhu').hide();
    hitungIwl();
  }
}

function tambahIwl(){
  var waktu_pemberian_iwl = getValueRadio($('.waktu_pemberian_iwl'));
  var jampemeriksaan = $('#jampemeriksaan').val();
  var chpoiseIWL = getValueRadio($('.chpoiseIWL'));
  var beratbadan_kg = $('#beratbadan_kg').val();
  var iwlperjam_normal = $('#iwlperjam_normal').val();
  var cairanmasuk_total = $('#cairanmasuk_total').val();
  var kenaikansuhutubuh_jml = $('#kenaikansuhutubuh_jml').val();
  var iwlperjam_kenaikansuhu = $('#iwlperjam_kenaikansuhu').val();
  var jmljam_pemeriksaan = $('#jmljam_pemeriksaan').val();
  var iwl_nilaiakhir = $('#iwl_nilaiakhir').val();
  var jmljamiwl_perhitungan = $('#jmljamiwl_perhitungan').val();
  var usia_anak = $('#usia_anak').val();

  var terjadisuhu = "";
  var isterjadikenaikansuhu = false;

  if($('#isterjadikenaikansuhu').prop('checked') == true){
    terjadisuhu = "Ya";
    isterjadikenaikansuhu = true;
  }else{
    terjadisuhu = "Tidak";
    isterjadikenaikansuhu = false;
  }

  if(waktu_pemberian_iwl != '' && jampemeriksaan != '' && chpoiseIWL != ''){

    var html = '<tr>' +
      '<td>'+
        '<input type="hidden" class="waktupemeriksaan" value="'+waktu_pemberian_iwl+'" />'+
        '<input type="hidden" class="jam_pemeriksaan" value="'+jampemeriksaan+'" />'+
        '<input type="hidden" class="kelompokpasien" value="'+chpoiseIWL+'" />'+
        '<input type="hidden" class="beratbadan_kg integer-decimal-3" value="'+beratbadan_kg+'" />'+
        '<input type="hidden" class="iwlperjam_normal integer-decimal-3" value="'+iwlperjam_normal+'" />'+
        '<input type="hidden" class="isterjadikenaikansuhu" value="'+isterjadikenaikansuhu+'" />'+
        '<input type="hidden" class="cairanmasuk_total integer-decimal-3" value="'+cairanmasuk_total+'" />'+
        '<input type="hidden" class="kenaikansuhutubuh_jml float2" value="'+kenaikansuhutubuh_jml+'" />'+
        '<input type="hidden" class="iwlperjam_kenaikansuhu float2" value="'+iwlperjam_kenaikansuhu+'" />'+
        '<input type="hidden" class="jmljam_pemeriksaan" value="'+jmljam_pemeriksaan+'" />'+
        '<input type="hidden" class="iwl_nilaiakhir integer-decimal-3" value="'+iwl_nilaiakhir+'" />'+
        '<input type="hidden" class="usia_anak integer2" value="'+usia_anak+'" />'+
        '<span class="nourut"></span>'+
      '</td>'+
      '<td>'+
        '<span>'+ waktu_pemberian_iwl +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jampemeriksaan +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ chpoiseIWL +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ beratbadan_kg +'</span>'+
      '</td>'+
      '<td class="iwlanakdetail">'+
        '<span>'+ usia_anak +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ iwlperjam_normal +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ terjadisuhu +'</span>'+
      '</td>'+
      '<td>'+
        '<span> Cairan Masuk : '+ cairanmasuk_total +'cc <br/> Jumlah Kenaikan Suhu : '+kenaikansuhutubuh_jml+' <br/> Nilai IWL per jam : '+jmljamiwl_perhitungan+' cc</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ jmljam_pemeriksaan +'</span>'+
      '</td>'+
      '<td>'+
        '<span>'+ iwl_nilaiakhir +'</span>'+
      '</td>'+
      '<td style="text-align: center;">'+
        '<a onclick="batalIWL(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Infus"><i class="icon-remove"></i></a>'+
      '</td>'+
    '</tr>';

    $('#tbliwl').find('tbody').append(html);
    generateRowIWL($('#tbliwl').find('tbody'));

    resetRadioButton($('.waktu_pemberian_iwl'));
    resetRadioButton($('.chpoiseIWL'));
    $('#jampemeriksaan').val('');
    $('#beratbadan_kg').val(formatThousandDecimal_third(0));
    $('#iwlperjam_normal').val(formatThousandDecimal_third(0));
    $('#isterjadikenaikansuhu').attr('checked',false);
    changeTerjadiSuhu();
    $('#jmljamiwl_perhitungan').val(formatThousandDecimal_third(0));
    $('#jmljam_pemeriksaan').val('');
    $('#iwl_nilaiakhir').val(formatThousandDecimal_third(0));
    $('#nilaiperjam').val(formatInteger(0));
    $('#usia_anak').val(formatInteger(0));
  }else{
    myAlert('Waktu Pemeriksaan, Jam Pemeriksaan dan Pilih IWL Belum Diisi !!')
  }
}

function generateRowIWL(obj){
  var index = 0;
  for(var i=0; i<$(obj).find('.nourut').length; i++){
      var trRow = $(obj).find('.nourut').eq(i);
      index++;
      trRow.html(index);
  }
  for(var i=0; i<$(obj).find('.waktupemeriksaan').length; i++){
      var trRow = $(obj).find('.waktupemeriksaan').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_waktupemeriksaan');
      trRow.attr('name','PerhitunganiwlT['+i+'][waktupemeriksaan]');
  }
  for(var i=0; i<$(obj).find('.jam_pemeriksaan').length; i++){
      var trRow = $(obj).find('.jam_pemeriksaan').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_jam_pemeriksaan');
      trRow.attr('name','PerhitunganiwlT['+i+'][jam_pemeriksaan]');
  }
  for(var i=0; i<$(obj).find('.kelompokpasien').length; i++){
      var trRow = $(obj).find('.kelompokpasien').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_kelompokpasien');
      trRow.attr('name','PerhitunganiwlT['+i+'][kelompokpasien]');
      if(trRow.val()=='Dewasa'){
        $(obj).find('.iwlanakdetail').eq(i).hide();
      }else if(trRow.val()=='Anak'){
        $(obj).find('.iwlanakdetail').eq(i).show();
      }else if(trRow.val()=='Neonatus'){
        $(obj).find('.iwlanakdetail').eq(i).hide();
      }
  }
  for(var i=0; i<$(obj).find('.beratbadan_kg').length; i++){
      var trRow = $(obj).find('.beratbadan_kg').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_beratbadan_kg');
      trRow.attr('name','PerhitunganiwlT['+i+'][beratbadan_kg]');
  }
  for(var i=0; i<$(obj).find('.iwlperjam_normal').length; i++){
      var trRow = $(obj).find('.iwlperjam_normal').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_iwlperjam_normal');
      trRow.attr('name','PerhitunganiwlT['+i+'][iwlperjam_normal]');
  }
  for(var i=0; i<$(obj).find('.isterjadikenaikansuhu').length; i++){
      var trRow = $(obj).find('.isterjadikenaikansuhu').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_isterjadikenaikansuhu');
      trRow.attr('name','PerhitunganiwlT['+i+'][isterjadikenaikansuhu]');
  }
  for(var i=0; i<$(obj).find('.cairanmasuk_total').length; i++){
      var trRow = $(obj).find('.cairanmasuk_total').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_cairanmasuk_total');
      trRow.attr('name','PerhitunganiwlT['+i+'][cairanmasuk_total]');
  }
  for(var i=0; i<$(obj).find('.kenaikansuhutubuh_jml').length; i++){
      var trRow = $(obj).find('.kenaikansuhutubuh_jml').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_kenaikansuhutubuh_jml');
      trRow.attr('name','PerhitunganiwlT['+i+'][kenaikansuhutubuh_jml]');
  }
  for(var i=0; i<$(obj).find('.iwlperjam_kenaikansuhu').length; i++){
      var trRow = $(obj).find('.iwlperjam_kenaikansuhu').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_iwlperjam_kenaikansuhu');
      trRow.attr('name','PerhitunganiwlT['+i+'][iwlperjam_kenaikansuhu]');
  }
  for(var i=0; i<$(obj).find('.jmljam_pemeriksaan').length; i++){
      var trRow = $(obj).find('.jmljam_pemeriksaan').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_jmljam_pemeriksaan');
      trRow.attr('name','PerhitunganiwlT['+i+'][jmljam_pemeriksaan]');
  }
  for(var i=0; i<$(obj).find('.iwl_nilaiakhir').length; i++){
      var trRow = $(obj).find('.iwl_nilaiakhir').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_iwl_nilaiakhir');
      trRow.attr('name','PerhitunganiwlT['+i+'][iwl_nilaiakhir]');
  }
  for(var i=0; i<$(obj).find('.usia_anak').length; i++){
      var trRow = $(obj).find('.usia_anak').eq(i);
      trRow.attr('id','PerhitunganiwlT_'+i+'_usia_anak');
      trRow.attr('name','PerhitunganiwlT['+i+'][usia_anak]');
  }
}

function batalIWL(obj){
    $(obj).parents('tr').remove();
    generateRowIWL($('#tbliwl').find('tbody'));
}

function cekVerifikasi(){
    if(requiredCheck($("form"))){
      $(".integer2, .float2, .integer-decimal, .integer-decimal-3").each(function(){
          $(this).val(unformatNumber($(this).val()));
      });
      $('#balancecairan-t-form').submit();

    }
    return false;

}

$(document).ready(function(){
  statusPenggunaCairanMasuk();
  setCairanKeluar();
  changeIwl();
  changeTerjadiSuhu();
});
</script>
