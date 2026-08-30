<script type="text/javascript">
function print(caraPrint)
{
    var settlementpayment_id = '<?php echo (isset($_GET['settlementpayment_id']) ? $_GET['settlementpayment_id'] : null); ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&settlementpayment_id='+settlementpayment_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}


var trTindakan = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowUraianSettlement',array('modSettlementPaymentDetails'=>$modSettlementPaymentDetails,'form'=>$form,'modSettlementPaymentDetail'=>$modSettlementPaymentDetail,'removeButton'=>true),true));?>);
var trLamp = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowLampiranSettlement',array('modSettlementPaymentLamps'=>$modSettlementPaymentLamps,'modSettlementPaymentLamp'=>$modSettlementPaymentLamp,'removeButton'=>true),true));?>);

function addRowLamp(obj){
    $(obj).parents('table').children('tbody').append(trLamp.replace());
    // renameInput('SettlementpaymentlampT','lampiran');
    // renameInput('SettlementpaymentlampT','noreferensi');
    // renameInput('SettlementpaymentlampT','keterangan');
    renameInputRow($('#tblInputTindakan'))
}

function batalLamp(obj)
{
    myConfirm("Apakah anda yakin akan membatalkan uraian?","Perhatian!",function(r) {
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();

            <?php
                // foreach($attributes as $i=>$attribute){
                //     echo "renameInput('SettlementpaymentdetT','$attribute');";
                // }
            ?>
            
        }
    });
}

function addRowUraian(obj)
{
    $(obj).parents('table').children('tbody').append(trTindakan.replace());

    renameInput('SettlementpaymentdetT','tgltransaksi');
    renameInput('SettlementpaymentdetT','jenispengeluaran_id');
    renameInput('SettlementpaymentdetT','jenispengeluaran_nama');
    renameInput('SettlementpaymentdetT','volume');
    renameInput('SettlementpaymentdetT','satuanvol');
    renameInput('SettlementpaymentdetT','hargasatuan');
    renameInput('SettlementpaymentdetT','totalharga');
    renameInput('SettlementpaymentdetT','rekening5_id');
    renameInput('SettlementpaymentdetT','rekening5_nama');
    // renameInput('SettlementpaymentdetT','tgltransaksi');
    // jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
    $('#tblInputUraian tbody').each(function(){
        jQuery('input[name$="[tgltransaksi]"]').datetimepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                },
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'maxDate':'d',
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
    });

    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
    maskMoneyInput($('#tblInputUraian > tbody > tr:last'));

    jQuery('input[name$="[jenispengeluaran_nama]"]').autocomplete(
        {
            'showAnim':'fold',
            'minLength':2,
            'focus':function(event, ui )
            {
                $(this).val( ui.item.label);
                return false;
            },
            'select':function( event, ui )
            {
                var is_ada = false;
                $("#tblInputUraian .jen").each(function() {
                    if ($(this).val() == ui.item.daftartindakan_id) is_ada = true;
                });

                if (is_ada) {
                    $(this).val("");
                    myAlert("Tindakan yang dipilih sudah ditambahkan sebelumnya. Silahkan ubah jumlah-nya.");
                    return false;
                }
                setPengeluaran(this, ui.item);
                return false;
            },
            'source':function(request, response)
            {
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl('rawatJalan/tindakan/DaftarTindakan');?>",
                    dataType: "json",
                    data:{
                        term: request.term,

                    },
                    success: function (data) {
                        response(data);
                    }
                })
            }
        }
    );


}


function batalUraian(obj)
{
    myConfirm("Apakah anda yakin akan membatalkan Uraian?",'Perhatian!',function(r){
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();


            renameInput('SettlementpaymentdetT','tgltransaksi');
            renameInput('SettlementpaymentdetT','jenispengeluaran_id');
            renameInput('SettlementpaymentdetT','jenispengeluaran_nama');
            renameInput('SettlementpaymentdetT','tgltransaksi');
            renameInput('SettlementpaymentdetT','volume');
            renameInput('SettlementpaymentdetT','satuanvol');
            renameInput('SettlementpaymentdetT','hargasatuan');
            renameInput('SettlementpaymentdetT','totalharga');
            renameInput('SettlementpaymentdetT','rekening5_id');
            renameInput('SettlementpaymentdetT','rekening5_nama');
        }
    });
}
function deleteTindakan(obj,idTindakanpelayanan)
{
    myConfirm("Apakah anda yakin akan menghapus tindakan?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxDeleteTindakanPelayanan') ?>', {idTindakanpelayanan: idTindakanpelayanan}, function(data){
                if(data.success)
                {
                    $(obj).parent().parent().detach();
                    myAlert('Data berhasil dihapus !!');
                } else {
                    myAlert('Data Gagal dihapus');
                }
            }, 'json');
        }
    });
}

function renameListTindakan(modelName,attributeName)
{
    var trLength = $('#tblInputUraian tr').length;
    var i = -1;
    $('#tblInputUraian tr').each(function(){
        if($(this).has('input[name$="[tgltransaksi]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('input[name^="jenispengeluaran_nama["]').attr('name','jenispengeluaran_nama['+i+']');
        $(this).find('input[name^="jenispengeluaran_id["]').attr('id','jenispengeluaran_id_'+i+'');

    });
}

function setPengeluaran(obj, item){
    $(obj).parents('tr').find('input[name$="[jenispengeluaran_id]"]').val(item.jenispengeluaran_id);
    $(obj).parents('tr').find('input[name$="[jenispengeluaran_nama]"]').val(item.jenispengeluaran_nama);
}
function setRekening(obj, item){
    console.log(item)
    $(obj).parents('tr').find('input[name$="[rekening5_id]"]').val(item.rekening5_id);
    $(obj).parents('tr').find('input[name$="[rekening5_nama]"]').val(item.nmrekening5);
}

function setDialogJenisPengeluaran(obj){
    $("#penjaminpasien-m-grid").find("tr").removeClass("yellow_background");

    parent = $(obj).parents(".input-append").find("input").attr("id");
    dialog = "#dialogJenisPengeluaran";
    $(dialog).attr("parent-dialog",parent);
    $(dialog).dialog("open");

}

function setDialogRekening(obj){
    $("#rekdebit-m-grid").find("tr").removeClass("yellow_background");

    parent = $(obj).parents(".input-append").find("input").attr("id");
    dialog = "#dialogRekDebit";
    $(dialog).attr("parent-dialog",parent);
    $(dialog).dialog("open");

}
function setPengeluaranAuto(jenispengeluran_id){

    dialog = "#dialogJenisPengeluaran";

    parent = $(dialog).attr("parent-dialog");

    console.log(parent)

    replacement = parent.substring(0, 24);

    obj = $("#"+parent);
    objrep = $("#"+replacement+'rekening5_nama');
    objrepid = $("#"+replacement+'rekening5_id');

    $.get('<?php echo Yii::app()->createUrl('keuangan/settlementPaymentT/DaftarJenisPengeluaran'); ?>',{
        jenispengeluaran_id:jenispengeluran_id
    },function(data){
        console.log(data)
        $(obj).val(data[0].jenispengeluaran_id);
        $(obj).val(data[0].jenispengeluaran_nama);

        $(objrepid).val(data[0].rekening5_id);
        $(objrep).val(data[0].kdrekening5 + '-' + data[0].nmrekening5);

        console.log(objrep)
        console.log(objrepid)
        console.log('meow ?>')
        // str_replace()
        setPengeluaran(obj,data[0]);

    },"json");
}

function renameInputRow(obj_table){
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
function setRekeningAuto(rekening5_id){

dialog = "#dialogRekDebit";

parent = $(dialog).attr("parent-dialog");
obj = $("#"+parent);

$.get('<?php echo Yii::app()->createUrl('keuangan/settlementPaymentT/DaftarRekeningDebit'); ?>',{
    rekening5_id:rekening5_id
},function(data){

    console.log(data)
    // $(obj).val(data[0].kategoritindakan_nama);
    $(obj).val(data[0].rekening5_id);
    $(obj).val(data[0].kdrekening5 +' - '+ data[0].nmrekening5);
    setRekening(obj,data[0]);

},"json");
}
function renameInput(modelName,attributeName)
{
    var trLength = $('#tblInputUraian tr').length;
    var i = -1;
    $('#tblInputUraian tr').each(function(){
        if($(this).has('input[name$="[tgltransaksi]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    });
}


function toTitleCase(str) {
  return str.replace(
    /\w\S*/g,
    function(txt) {
      return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    }
  );
}

function unMaskMoneyInput(tr)
{
    $(tr).find('.integer2:text').unmaskMoney();
}

function maskMoneyInput(tr)
{
    $(tr).find('.integer-decimal:text').maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2});
}
function hitungTotalUraian(obj)
{
    var volume = unformatNumber($(obj).parents('tr').find('input[name$="[volume]"]').val());
    var hargasatuan = unformatNumber($(obj).parents('tr').find('input[name$="[hargasatuan]"]').val());

    $(obj).parents('tr').find('input[name$="[totalharga]"]').val(formatThousandDecimal(volume*hargasatuan));

    // $('#totalrow').val()
}
function simpanDataTransaksi(){

    // var length = $('#tblInputUraian').length();
    var detail = 0;
    var totalhargarow = 0;
    $('#tblInputUraian tbody tr').each(
            function(){
                detail++;
            }
    );
    $("#tblInputUraian tbody tr .totalharga").each(function() {
        totalhargarow += parseFloat(unformatNumber($(this).val()));
        });

    var total =  parseFloat(unformatNumber($('#SettlementpaymentT_realisasipembelian').val()));
    if (totalhargarow != total) {
        myAlert('Harga Uraian Tidak Sesuai Dengan Realisasi Pembelian');
        return false;
    }

    $('#advancepayment-t-form').submit()
}
function setJenisTransaksi(obj){
	if ($('#AdvancepaymentT_profilrs_id').val() == '') {
		myAlert('Pilih dulu klinik');
		$('#AdvancepaymentT_jenistransaksi').val('')
		return false;
	}
	if ($(obj).val() == 'ADVANCE PAYMENT') {
		generateNoPengajuan('AP',$('#AdvancepaymentT_profilrs_id').val());
	}else if ($(obj).val() == 'REQUEST OF PAYMENT') {
		generateNoPengajuan('ROP',$('#AdvancepaymentT_profilrs_id').val());
	}

	$('#jenis_transaksi').text(toTitleCase($(obj).val()))
}


// cla
function generateNoPengajuan(kode, klinik){
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GenerateNoPengajuan'); ?>',
        data: {klinik:klinik,kode:kode},
        dataType: "json",
        success:function(data){
            $('#AdvancepaymentT_nopengajuan').val(data.no)
			if (kode == 'AP') {
				$('#KUTandabuktikeluarT_untukpembayaran').val('Advance Payment '+'-'+ $('#AdvancepaymentT_nopengajuan').val())
			}else if (kode == 'ROP') {
				$('#KUTandabuktikeluarT_untukpembayaran').val('Request Of Payment '+'-'+ $('#AdvancepaymentT_nopengajuan').val())

			}
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setKlinik(obj){
    // $('#profilrs_id').val()

      setTimeout(function(){
                $.fn.yiiGridView.update('pegawai-m-grid', {
                    data: {
                        "PegawaiM[profilrs_id]":$(obj).val(),
                    }
                });
    },500);
}
function setCaraBayar(obj){
    // console.log($(obj).val())
    if ($(obj).val() == 'TRANSFER') {
        $('#transfer').show();
    }else{
        $('#transfer').hide();
    }
}
function setCaraBayarKeluar(obj){
    // console.log($(obj).val())
    if ($(obj).val() == 'TRANSFER') {
        $('#transferkeluar').show();
    }else{
        $('#transferkeluar').hide();
    }
}
function calculate(){
    var jumlahpembayaran = parseFloat(unformatNumber($('#AdvancepaymentT_jmlpembayaran').val()));
    var biayaadmin = parseFloat(unformatNumber($('#KUTandabuktikeluarT_biayaadministrasi').val()));
    var total = 0;
    total = jumlahpembayaran + biayaadmin;

    $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatThousandDecimal(total))
}

function calculateTotalRow(){
    var totalhargarow = 0;
    $("#tblInputUraian tbody tr .totalharga").each(function() {
        totalhargarow += parseFloat(unformatNumber($(this).val()));
        });
    $('#totalrow').val(formatThousandDecimal(totalhargarow))
    console.log(totalhargarow)
}
// function setBank(obj){
    
//     $.ajax({
//         type:'POST',
//         url:'<?php echo $this->createUrl('SetBank'); ?>',
//         data: {profilrs_id:$(obj).val()},//
//         dataType: "json",
//         success:function(data){
//         //    console.log(data)
//            $("#KUTandabuktikeluarT_bank_id").html(data.option);
//         },
//         error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
//     });

// }
// function setBankKeluar(obj){
    
//     $.ajax({
//         type:'POST',
//         url:'<?php echo $this->createUrl('SetBankKeluar'); ?>',
//         data: {profilrs_id:$(obj).val()},//
//         dataType: "json",
//         success:function(data){
//            console.log(data)
//            $("#TandabuktikeluarT_bank_id").html(data.option);
//         },
//         error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
//     });

// }

function setBankKeluar(obj,klinik){
    var profilrs_id = null
    if (!obj) {
        profilrs_id = klinik        
    }else{
        profilrs_id = $(obj).val()
    }
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetBankKeluar'); ?>',
        data: {profilrs_id:profilrs_id},//
        dataType: "json",
        success:function(data){
        //    console.log(data)
           $("#TandabuktikeluarT_bank_id").html(data.option);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });

}

function setPotongGaji(){

    // format tanggal pengajuan
    var tanggalpengajuan = $('#AdvancepaymentT_tglpengajuan').val();
    var dateCustom = new Date(tanggalpengajuan);
    var tgljatuhtempo = new Date(dateCustom.getFullYear(), dateCustom.getMonth() + 1, 0);
    // end format

    var sisa = parseFloat(unformatNumber($('#SettlementpaymentT_sisapengembalian').val()));
    var checkBox = document.getElementById("SettlementpaymentT_ispotonggaji");
    if (checkBox.checked == true){
        $('#bayartempo').hide();
        $('#potongangaji').show();

        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        var tglsetttlement = $('#SettlementpaymentT_tglsettlement').val();
        var tgladvance = $('#AdvancepaymentT_tglpengajuan').val();
        if(tglsetttlement > tgladvance){
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = monthNames[today.getMonth() + 1] //January is 0!
            var yyyy = today.getFullYear();
        }else{
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = monthNames[today.getMonth()] //January is 0!
            var yyyy = today.getFullYear();
        }
        
        var month = mm + ' ' + yyyy;
       
        $('#SettlementpaymentT_ispotonggaji').prop('checked', true);
        $('#SettlementpaymentT_periodegaji').val(month)
        $('#SettlementpaymentT_totalpotongan').val(formatThousandDecimal(sisa));
        // set null
        $('#SettlementpaymentT_totalpiutang').val(formatThousandDecimal(0));
        $('#SettlementpaymentT_tgljatuhtempo').val(null);
        
    }else{
        
        $('#bayartempo').show();
        $('#potongangaji').hide();
        $('#SettlementpaymentT_totalpiutang').val(formatThousandDecimal(sisa));
        
        $('#SettlementpaymentT_periodegaji').val(null);
        $('#SettlementpaymentT_totalpotongan').val(null);
    }
}


function hitungRealisasi(){
    var jmladvance = parseFloat(unformatNumber($('#AdvancepaymentT_jmlpembayaran').val()));
    var realisasi = parseFloat(unformatNumber($('#SettlementpaymentT_realisasipembelian').val()));
    var sisarealisasi = 0;
    if(realisasi > jmladvance){
        sisarealisasi = realisasi-jmladvance;
        $('#SettlementpaymentT_jmlpembayaran2').val(formatThousandDecimal(sisarealisasi));

    }else{
        sisarealisasi = jmladvance - realisasi;
    }
    $('#SettlementpaymentT_jmlpembayaran').val(formatThousandDecimal(sisarealisasi));

}

function hitungTotal(){
    //deklarasi
    var jmladvance = parseFloat(unformatNumber($('#AdvancepaymentT_jmlpembayaran').val()));
    var jmlpembayaran = parseFloat(unformatNumber($('#AdvancepaymentT_jmlpembayaran').val()));
    var realisasi = parseFloat(unformatNumber($('#SettlementpaymentT_realisasipembelian').val()));

    var biayaadmin = parseFloat(unformatNumber($('#KUTandabuktibayarT_biayaadministrasi').val()));

    var total = 0;
    var totalpengembalian = 0;
    var sisarealisasi = 0;
    var kasmasuk = 0;

    //perhitungan
    total = jmlpembayaran - realisasi;
    sisarealisasi = jmladvance - realisasi;


    var jmlpengembalian = parseFloat(unformatNumber($('#SettlementpaymentT_jmlpembayaran').val()));


    SettlementpaymentT_jmlpembayaran

    kasmasuk = jmlpengembalian - biayaadmin;
    totalpengembalian = sisarealisasi - jmlpengembalian;

    //assign to field
    $('#SettlementpaymentT_sisarealisasi').val(formatThousandDecimal(sisarealisasi))
    var sisaReallisasiAdvancePayment = parseFloat(unformatNumber($('#SettlementpaymentT_sisarealisasi').val()));
    sisapengembalian = sisaReallisasiAdvancePayment - jmlpengembalian;

    $('#SettlementpaymentT_sisapengembalian').val(formatThousandDecimal(sisapengembalian));
    // realisaisi
    //logic

    if(realisasi > jmladvance){
        $('#hutangrealisasi').show();
        $('#bayarhutangrealisasi').show();
        console.log('hitung lagi')
        var hutang = realisasi-jmladvance;
        $("label[for=SettlementpaymentT_jmlpembayaran]").html("Jumlah Pembayaran<span class='required'>*</span>");
        $('#SettlementpaymentT_kekuranganrealisasi').val(formatThousandDecimal(hutang));
        // $('#SettlementpaymentT_jmlpembayaran').val(formatThousandDecimal(hutang));

        var jmlbayarrealisasi =  parseFloat(unformatNumber($('#SettlementpaymentT_jmlpembayaran2').val()));
        var kekuranganrealisasi =   parseFloat(unformatNumber($('#SettlementpaymentT_kekuranganrealisasi').val()));
        var biayaadminkeluar =   parseFloat(unformatNumber($('#TandabuktikeluarT_biayaadministrasi').val()));
        var jmlkaskeluar = jmlbayarrealisasi + biayaadminkeluar;
        var sisakekurangan = kekuranganrealisasi - jmlbayarrealisasi;
        if (jmlbayarrealisasi > kekuranganrealisasi) {
            myAlert('Jumlah Pembayaran Tidak Boleh Melebihi Hutang Realisasi Pembelian');
            // $('#SettlementpaymentT_jmlpembayaran2').val(formatThousandDecimal(0))
            return false;
        }
        
        if( sisakekurangan != 0){
            $('#hutang').show();
            console.log('masuk sini');
            $('#SettlementpaymentT_totalhutang').val(formatThousandDecimal(sisakekurangan));

        }else{
            $('#hutang').hide();
            console.log('masuk sini2');

        }
        if (jmlkaskeluar > 0) {
            $('#TandabuktikeluarT_jmlkaskeluar').val(formatThousandDecimal(jmlkaskeluar));
            $('#bayarhutangrealisasi').show();
        }else{
            $('#TandabuktikeluarT_jmlkaskeluar').val(formatThousandDecimal(0));

            $('#bayarhutangrealisasi').hide();
        }
        $('#SettlementpaymentT_sisakekurangan').val(formatThousandDecimal(sisakekurangan));

    }else{
        $('#hutangrealisasi').hide();
        $('#bayarhutangrealisasi').hide();

        $('#SettlementpaymentT_kekuranganrealisasi').val(formatThousandDecimal(0));
        $('#SettlementpaymentT_jmlpembayaran').val(formatThousandDecimal(0));



    }
    if (sisarealisasi > 0) {
            $('#lebih').show();
            $('#lebihbayar').show();
            $("label[for=SettlementpaymentT_jmlpembayaran]").html("Jumlah Pengembalian<span class='required'>*</span>");
            
            $('#piutang').hide();
            // Sisa Advance Payment - Jumlah Pengembalian
            $('#KUTandabuktibayarT_uangditerima').val(formatThousandDecimal(kasmasuk));

    }else{
        $('#lebih').hide();
        $('#sisa').hide();

        $('#piutang').hide();
    }

    if (sisapengembalian  > 0) {
        $('#piutang').show();
        $('#potongangaji').hide();
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        var tanggalpengajuan = $('#AdvancepaymentT_tglpengajuan').val();
        var dateCustom = new Date(tanggalpengajuan);
        var tgljatuhtempo = new Date(dateCustom.getFullYear(), dateCustom.getMonth() + 1, 0);
    
        var sisa = parseFloat(unformatNumber($('#SettlementpaymentT_sisapengembalian').val()));
        $('#SettlementpaymentT_totalpiutang').val(formatThousandDecimal(sisa));
        
    }else{
        $('#piutang').hide();
        $('#SettlementpaymentT_ispotonggaji').prop('checked', false);
        $('#SettlementpaymentT_totalpotongan').val(formatThousandDecimal(0));
        $('#SettlementpaymentT_periodegaji').val(null)
    }



}


function setBank(obj,klinik){
    var profilrs_id = null
    if (!obj) {
        profilrs_id = klinik
    }else{
        profilrs_id = $(obj).val()
    }
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetBank'); ?>',
        data: {profilrs_id:profilrs_id},//
        dataType: "json",
        success:function(data){
        //    console.log(data)
           $("#KUTandabuktibayarT_bank_id").html(data.option);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });

}



function setCaraBayar(obj){
    // console.log($(obj).val())
    if ($(obj).val() == 'TRANSFER') {
        $('#transfer').show();
    }else{
        $('#transfer').hide();
    }
}
$(document).ready(function(){
    $('#transfer').hide();
    $('#transferkeluar').hide();
    $('#bayarhutangrealisasi').hide();
    $('#AdvancepaymentT_jmlpembayaran').val(formatThousandDecimal($('#AdvancepaymentT_jmlpembayaran').val()))
    $('#SettlementpaymentT_jmladvance').val(formatThousandDecimal($('#SettlementpaymentT_jmladvance').val()))
    $('#KUTandabuktikeluarT_biayaadministrasi').val(formatThousandDecimal($('#KUTandabuktikeluarT_biayaadministrasi').val()))
    $('#TandabuktikeluarT_biayaadministrasi').val(formatThousandDecimal($('#TandabuktikeluarT_biayaadministrasi').val()))
    $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatThousandDecimal($('#KUTandabuktikeluarT_jmlkaskeluar').val()))

    setBank('',$('#SettlementpaymentT_profilrs_id').val())
    setBankKeluar('',$('#SettlementpaymentT_profilrs_id').val())

    var noset = $('#SettlementpaymentT_nosettlement').val();
    
    
    $('#SettlementpaymentT_jmlpembayaran').val(formatThousandDecimal(0));
    $('#SettlementpaymentT_realisasipembelian').val(formatThousandDecimal(0));
    $('#SettlementpaymentT_sisarealisasi').val(formatThousandDecimal(0));
    $('#KUTandabuktibayarT_biayaadministrasi').val(formatThousandDecimal(0));
    $('#TandabuktikeluarT_biayaadministrasi').val(formatThousandDecimal(0));
    $('#SettlementpaymentT_ispotonggaji').prop('checked', false);
    $('#SettlementpaymentT_sebagaipembayaran').val('Settlement Advance Payment ' +'-'+noset);
    $('#lebih').hide();
    $('#piutang').hide();
    $('#lebihbayar').hide();
    $('#hutangrealisasi').hide();
    $('#sisa').hide();
    $('#hutang').hide();

})
</script>
