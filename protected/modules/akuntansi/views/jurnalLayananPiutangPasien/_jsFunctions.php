<script type="text/javascript">
function loadDataJurnal(){
    $("#table-piutangpasien").addClass("animation-loading");
    var tgl_awal = $('#tgl_awal').val();
    var tgl_akhir = $('#tgl_akhir').val();
    var instalasi_id = $('#instalasi_id').val();
    if(instalasi_id == null){
      instalasi_id = '';
    }
    var ruangan_id = $('#ruangan_id').val();
    if(ruangan_id == null){
      ruangan_id = '';
    }
    var nopendaftaran = $('#nopendaftaran').val();
    var norekam_medik = $('#norekam_medik').val();

    if(tgl_awal != "" && tgl_akhir != ''){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetFromLoadPiutang'); ?>',
            data: {tgl_awal: tgl_awal ,tgl_akhir: tgl_akhir ,instalasi_id: instalasi_id ,ruangan_id: ruangan_id ,nopendaftaran: nopendaftaran ,norekam_medik: norekam_medik},
            dataType: "json",
            success:function(data){
                if(data.pesan != ''){
                    myAlert(data.pesan);
                }
                $('#table-piutangpasien > tbody').html(data.form);

                renameInput($("#table-piutangpasien"));
                changePilihAll($("#chekboxall"));
                reinstallDatePicker();
                hitungTotal();

                // hitungTotal();
                // formatNumberSemua();
                $("#table-piutangpasien").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak ditemukan!");}
        });
    }else{
        myAlert("Data tidak ditemukan!");
    }

}

function reinstallDatePicker() {
    var tr = $('#table-piutangpasien').find('tbody tr');

    for (var i =0;i<=tr.length;i++){
      jQuery('#JurnalpelayananV_'+i+'_tglbuktijurnal').datetimepicker(
          jQuery.extend(
              {
                showMonthAfterYear: false
              },
          jQuery.datepicker.regional['id'],
              {
                'dateFormat': 'dd M yy',
                'maxDate': 'd',
                'timeText': 'Waktu',
                'hourText': 'Jam',
                'minuteText': 'Menit',
                'secondText': 'Detik',
                'showSecond': true,
                'timeOnlyTitle': 'Pilih Waktu',
                'timeFormat': 'hh:mm:ss',
                'changeYear': true,
                'changeMonth': true,
                'showAnim': 'fold',
                'yearRange': '-80y:+20y'
              }
          )
          );
      jQuery('#JurnalpelayananV_'+(i)+'_tglbuktijurnal_date').on('click', function () {
        jQuery('#JurnalpelayananV_'+(i)+'_tglbuktijurnal').datepicker('show');

      });
    }
}

function changePilihAll(obj){
  if($(obj).is(":checked")){
    $('#table-piutangpasien > tbody').find('tr').each(function(){
        $(this).find('.checklist').attr('checked',true);
        setNol($(this).find('.checklist'));
    });
  }else{
    $('#table-piutangpasien > tbody').find('tr').each(function(){
        $(this).find('.checklist').attr('checked',false);
        setNol($(this).find('.checklist'));
    });
  }
}

function setNol(obj){
  var daftar_tindakan = $(obj).parents("tr").find("input[name$='[daftar_tindakan]']").val();

  if($(obj).parents('tr').find('.checklist').is(":checked")){
    $('#table-piutangpasien > tbody').find('input[name$="[daftar_tindakan]"][value="'+ daftar_tindakan +'"]').each(
        function(){
            $(this).parents("tr").find("input[name$='[checklist]']").attr('checked',true);
            $(this).parents("tr").find('input, textarea').not('input[type="checkbox"]').attr('disabled',false);
            $(this).parents("tr").find('.add-on').show();
            console.log(getCurrentDateJurnal());
            $(this).parents("tr").find("input[name$='[tglbuktijurnal]']").val(getCurrentDateJurnal());
        }
    );

  }else{
    $('#table-piutangpasien > tbody').find('input[name$="[daftar_tindakan]"][value="'+ daftar_tindakan +'"]').each(
        function(){
            $(this).parents("tr").find("input[name$='[checklist]']").attr('checked',false);
            $(this).parents("tr").find('input, textarea').not('input[type="checkbox"]').attr('disabled',true);
            $(this).parents("tr").find('.add-on').hide();
            $(this).parents("tr").find("input[name$='[tglbuktijurnal]']").val('');
            $(this).parents("tr").find("input[name$='[kdrekening5]']").val('');
            $(this).parents("tr").find("input[name$='[nmrekening5]']").val('');
        }
    );

    // $(obj).parents('tr').find('input[name$="[jmlsetoran]"]').val(0);
    // $(obj).parents('tr').find('input[name$="[sisahutang]"]').val(0);
  }
  hitungTotal();
}

function renameInput(obj_table){
    var row = 0;
    // $(obj_table).find("tbody > tr").each(function(){
    //     $(this).find('input[name$="[checklist]"],input[name$="[jenisjurnal_nama]"]').each(function(){ //element <input>
    //         var old_name = $(this).attr("name").replace(/]/g,"");
    //         var old_name_arr = old_name.split("[");
    //         if(old_name_arr.length == 3){
    //             $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
    //             $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
    //         }
    //     });
    //     row++;
    // });

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


    // $(obj_table).find('input[name$="[checklist]"],input[name$="[jenisjurnal_nama]"]').each(function(){
    //     // $(this).find('input,select,textarea').each(function(){ //element <input>
    //         var old_name = $(this).attr("name").replace(/]/g,"");
    //         var old_name_arr = old_name.split("[");
    //         if(old_name_arr.length == 3){
    //             $(this).attr("id",old_name_arr[0]+"_"+row1+"_"+old_name_arr[2]);
    //             $(this).attr("name",old_name_arr[0]+"["+row1+"]["+old_name_arr[2]+"]");
    //         }
    //     // });
    //     row1++;
    // });

}

var cur_id;

function ubahRekening(obj) {
  cur_id = $(obj).parents("tr").index();
  $("#dialogRek").dialog("open");
}

function pilihDialogRekening(data) {
  var obj = $("#table-piutangpasien > tbody > tr").eq(cur_id);

  $(obj).find(".rek1").val(data.rekening1_id);
  $(obj).find(".rek2").val(data.rekening2_id);
  $(obj).find(".rek3").val(data.rekening3_id);
  $(obj).find(".rek4").val(data.rekening4_id);
  $(obj).find(".rek5").val(data.rekeninglast_id);

  $(obj).find(".nama5").val(data.nmrekeninglast);
  $(obj).find(".kode5").val(data.kdrekeninglast);
}

function simpanJurnalRek(){
    if(requiredCheck($('#jurnalpiutangpasien-t-form'))){
        var jml = $('#table-piutangpasien tbody tr').find("input[name$='[checklist]']").length;
        if(jml < 1){
            myAlert('Silakan pilih tabel jurnal piutang terlebih dahulu!');
            return false;
        }
        else{
             $('#table-piutangpasien').find("tbody > tr").each(function(){
                  if(!$(this).find(".checklist").is(":checked")){
                      $(this).find('input,select,textarea').each(function(){
                          $(this).attr('disabled', true);
                      });
                  }
             });

             var row = 0;
                $('#table-piutangpasien').find("tbody > tr").each(function(){
                     if($(this).find(".checklist").is(":checked")){
                        $(this).find('input,select,textarea').each(function(){ //element <input>
                            var old_name = $(this).attr("name").replace(/]/g,"");
                            var old_name_arr = old_name.split("[");
                            if(old_name_arr.length == 3){
                                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                            }
                        });
                        row++;
                     }
                });
                $(".integer, .float, .integer-decimal").each(function(){
                    $(this).val(unformatNumber($(this).val()));
                });
            $('#jurnalpiutangpasien-t-form').submit();
        }
    }
    return false;
}

function hitungTotal() {
   unformatNumberSemua();
    var totalDebit = 0;
    var totalKredit = 0;

    $("#table-piutangpasien").find("tbody > tr").each(function () {
        if ($(this).find(".checklist").is(":checked")){
          var debit = parseFloat($(this).find('input[name$="[saldodebit]"]').val());
          var kredit = parseFloat($(this).find('input[name$="[saldokredit]"]').val());

          totalDebit += debit;
          totalKredit += kredit;
        }
    });

    $("#totalDebit").val(totalDebit);
    $("#totalKredit").val(totalKredit);
    formatNumberSemua();
}

function getCurrentDateJurnal(){
  var val = "";
  var current = new Date();
  var year = current.getFullYear();
  var day = current.getDate();
  var month = current.getMonth();
  var months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sep', 'Okt', 'Nop', 'Des');
  var h = current.getHours();
  if(h<10) {
    h = "0"+h;
  }
  var m = current.getMinutes();
  if(m<10) {
          m = "0"+m;
  }
  var s = current.getSeconds();
  if(s<10) {
    s = "0"+s;
  }

  val = day+' '+ months[month]+' '+year+' '+h+':'+m+':'+s;

  return val;
}

$(document).ready(function(){
  var ins  = jQuery('#instalasi_id');
  var ru  = jQuery('#ruangan_id');

  jQuery(ins).multiselect({
      includeSelectAllOption: true,
      buttonClass: "form-control",
      maxHeight: 300,
      buttonWidth: '182px',
      enableCaseInsensitiveFiltering: true,
      onChange: function(element, checked) {
          var ins  = jQuery('#instalasi_id');
          var ins_all = jQuery('#instalasi_id   option:selected');
          var ru  = jQuery('#ruangan_id');

          var brands = ins_all;
          var selected = [];

          $(brands).each(function(index, brand){
                  selected.push($(this).val());
          });

          ru.addClass('animation-loading');
          //alert(selected);

          jQuery.ajax({
              type:'POST',
              url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
              dataType: "json",
              data: {instalasi_id:selected},
              success: function(data){

                  if (data.sukses != '1'){

                      //toastr.error(data.pesan);
                      ru.addClass('animation-loading');
                  }else{
                      //alert(data.ruangan);
                      ru.html(data.ruangan);
                      ru.multiselect('rebuild');
                      ru.removeClass('animation-loading');
                  }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                  console.log(errorThrown);

              }
          });

      },
      onSelectAll: function() {
          var ins  = jQuery('#instalasi_id');
          var ins_all = jQuery('#instalasi_id   option:selected');
          var ru  = jQuery('#ruangan_id');

          var brands = ins_all;
          var selected = [];

          $(brands).each(function(index, brand){
              selected.push($(this).val());
          });

          ru.addClass('animation-loading');

          jQuery.ajax({
              type:'POST',
              url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
              dataType: "json",
              data: {instalasi_id:selected},
              success: function(data){

                  if (data.sukses != '1'){

                      //toastr.error(data.pesan);
                      ru.addClass('animation-loading');
                  }else{
                          //alert(data.ruangan);
                      ru.html(data.ruangan);
                      ru.multiselect('rebuild');
                      ru.removeClass('animation-loading');
                  }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                  console.log(errorThrown);

              }
          });

      },
          onDeselectAll: function() {
                  var ins  = jQuery('#instalasi_id');
                  var ins_all = jQuery('#instalasi_id  option:selected');
                  var ru  = jQuery('#ruangan_id');

                  var brands = ins_all;
                  var selected = '';


                  ru.addClass('animation-loading');

                  jQuery.ajax({
                          type:'POST',
                          url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                          dataType: "json",
                          data: {instalasi_id:selected},
                          success: function(data){

                                  if (data.sukses != '1'){

                                          //toastr.error(data.pesan);
                                          ru.addClass('animation-loading');
                                  }else{
                                          //alert(data.ruangan);
                                          ru.html(data.ruangan);
                                          ru.multiselect('rebuild');
                                          ru.removeClass('animation-loading');
                                  }
                          },
                          error: function (jqXHR, textStatus, errorThrown) {
                                  console.log(errorThrown);

                          }
                  });

          }
  }).hide();

  jQuery(ru).multiselect({
          includeSelectAllOption: true,
          buttonClass: "form-control",
          maxHeight: 300,
          buttonWidth: '182px',
          enableCaseInsensitiveFiltering: true
  }).hide();
  $('#tglhidden_date').hide();
});
</script>
