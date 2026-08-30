<script type="text/javascript">

function loadDataPencarian(){
    $("#table-pengajuan > tbody").addClass("animation-loading");
    var tgl_awal = $('#<?php echo CHtml::activeId($model, 'tgl_awal'); ?>').val();
    var tgl_akhir = $('#<?php echo CHtml::activeId($model, 'tgl_akhir') ?>').val();
    var noinvoice = $('#<?php echo CHtml::activeId($model, 'noinvoice') ?>').val();
    var carabayar_id = $('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>').val();
    var penjamin_id = $('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>').val();

    $('#table-pengajuan > tbody').html("");
    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'untukpembayaran') ?>").val('');

    if(tgl_awal !== "" && tgl_akhir !== "" && carabayar_id !== "" && penjamin_id !== ""){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetFromPencarian'); ?>',
            data: {tgl_awal: tgl_awal, tgl_akhir: tgl_akhir, noinvoice: noinvoice, carabayar_id: carabayar_id, penjamin_id: penjamin_id},
            dataType: "json",
            success:function(data){
                if(data.pesan != ''){
                    myAlert(data.pesan);
                }
                $('#table-pengajuan > tbody').html(data.form);
                $("#<?php echo CHtml::activeId($modBuktiKeluar, 'untukpembayaran') ?>").val(data.keterangan);

                renameInput($("#table-pengajuan"));
                hitungTotal();
                changePilihAll($('#chekboxall'));
                $("#table-pengajuan > tbody").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak ditemukan!");}
        });
    }else{
        myAlert("Pencarian bertanda <span class='required'>*</span> harus diisi!");
    }
}

function changePilihAll(obj){
  if($(obj).is(":checked")){
    $('#table-pengajuan > tbody').find('tr').each(function(){
        $(this).find('.checklist').attr('checked',true);
        setNol($(this).find('.checklist'));
    });
  }else{
    $('#table-pengajuan > tbody').find('tr').each(function(){
        $(this).find('.checklist').attr('checked',false);
        setNol($(this).find('.checklist'));
    });
  }
}

function setNol(obj){
  if($(obj).parents('tr').find('.checklist').is(":checked")){
    $(obj).parents('tr').find('input, textarea, select').not('input[type="checkbox"]').attr('disabled',false);
  }else{
    $(obj).parents('tr').find('input, textarea, select').not('input[type="checkbox"]').attr('disabled',true);
  }
    hitungTotal();
}
function renameInput(obj_table){
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

    $(obj_table).find('input[name$="[kiriminvoice_tgl]"]').datetimepicker(
        jQuery.extend(
            {
                showMonthAfterYear:false
            }, 
            jQuery.datepicker.regional['id'],
            {
                'dateFormat':'dd M yy',
                'minDate':'d',
                'timeText':'Waktu',
                'hourText':'Jam',
                'minuteText':'Menit',
                'secondText':'Detik',
                'showSecond':true,
                'timeOnlyTitle':'Pilih Waktu',
                'timeFormat':'hh:mm:ss',
                'changeYear':true,
                'changeMonth':true,
                'showAnim':'fold',
                'yearRange':'-80y:+20y'
            }
        )
    );
    $(obj_table).find('input[name$="[kiriminvoice_tgl]"]').each(function() {
        var obj = $(this);
        $(this).parent().find(".add-on").click(function() {
            $(obj).focus();
        });
    });
}

function hitungTotal() {
     unformatNumberSemua();
    var totaltagihan = 0;

    $("#table-pengajuan").find("tbody > tr").each(function () {
        if ($(this).find(".checklist").is(":checked")){
            totaltagihan += parseFloat($(this).find('input[name$="[totalbayar]"]').val());
        }
    });

    $("#totaltagihan").val(totaltagihan);
    formatNumberSemua();
    hitungKasKeluar();
}

function hitungKasKeluar()
{
    unformatNumberSemua();
    var biayaadministrasi = parseFloat($("#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaadministrasi') ?>").val());
    var biayaongkos_kirim = parseFloat($("#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaongkos_kirim') ?>").val());
    var totaltagihan = parseFloat( $("#totaltagihan").val());

    var jmlkaskeluar = totaltagihan+ biayaadministrasi + biayaongkos_kirim;
    if (jmlkaskeluar > 0){
        jmlkaskeluar = parseFloat(jmlkaskeluar.toFixed(2));
    }

    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar') ?>").val(jmlkaskeluar);
    $("#tblInputRekening > tbody").find('.saldodebit').val(jmlkaskeluar);
    $("#tblInputRekening > tbody").find('.saldokredit').val(jmlkaskeluar);

    formatNumberSemua();
}

function formCarabayar(carabayar)
{
    if(carabayar == 'TRANSFER'){
        $('#divCaraBayarTransfer').slideDown();
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'norekpenerima') ?>").attr('disabled',false);
    } else {
        $('#divCaraBayarTransfer').slideUp();
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'norekpenerima') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'norekpenerima') ?>").attr('disabled',true);
        getDataRekening();
    }
}

function renameRowRekening(obj_table)
{
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
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

function getDataRekening()
{
    var carabayar = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar') ?>").val();
    var bankid = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").val();

    $("#tblInputRekening").find('.tbody').html('');
    if(carabayar !== ''){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('AmbilDataRekening'); ?>',
            data: {carabayar: carabayar, bankid:bankid},//
            dataType: "json",
            success:function(data){
                $("#tblInputRekening > tbody").append(data.replace());
                renameRowRekening($("#tblInputRekening"));
                hitungKasKeluar();

            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    }
    
}

// function print()
// {
//     var tandabuktikeluar_id = "<?php //echo isset($_GET['tandabuktikeluar_id']) ? $_GET['tandabuktikeluar_id'] : null; ?>";
//     window.open("<?php //echo $this->createUrl('print') ?>&id=" + tandabuktikeluar_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
// }

function prosesSimpanKlaim(){
    if(requiredCheck($('#kiriminvoiceklaim-t-form'))){
        var jml = $('#table-pengajuan tbody tr').find("input[name$='[checklist]']").length;
        var debit = 0;
        var kredit = 0;

        $('#table-tblInputRekening tbody tr').each(function(){
            var debit_tr = unformatNumber(parseFloat($(this).find('input[name*="[saldodebit]"]').val()));
            var kredit_tr = unformatNumber(parseFloat($(this).find('input[name*="[saldokredit]"]').val()));

            debit += debit_tr;
            kredit += kredit_tr;
        });
        if(debit != kredit){
            myAlert('Saldo Rekening Debit dan Kredit Harus Sama!');
            return false;
        }

        if(jml < 1){
            myAlert('Silakan pilih Tabel Data Pengajuan Klaim!');
            return false;
        }
        else{
             $('#table-pengajuan').find("tbody > tr").each(function(){
                  if(!$(this).find(".checklist").is(":checked")){
                      $(this).find('input,select,textarea').each(function(){
                          $(this).attr('disabled', true);
                      });
                  }
             });

             var row = 0;
                $('#table-pengajuan').find("tbody > tr").each(function(){
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
            $('#kiriminvoiceklaim-t-form').submit();
        }
    }
    return false;
}

function setKodeAkunBank() {
    var dataRek = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id'); ?> :selected").data('norek');

    if(dataRek != undefined && dataRek != ''){
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val(dataRek);
    }
    getDataRekening();
}

$(document).ready(function(){
    
    formCarabayar($('#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>').val());
    hitungTotal();

    
});
</script>
