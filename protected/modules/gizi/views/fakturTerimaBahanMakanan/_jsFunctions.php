<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.numbersOnly',
        'config' => array(
            'defaultZero' => true,
            'allowZero' => true,
            'decimal' => ',',
            'thousands' => '.',
            'precision' => 0,
        )
    ));
?>

<script>
    
    
    function setTerimaBahanMakan(id) {
        $.post('<?php echo $this->createUrl('getTerimaBahanMakanan'); ?>', {id: id}, function(data) {
            // set terima bahan makanan
            $("#GZTerimabahanmakan_terimabahanmakan_id").val(data.terima.terimabahanmakan_id);
            $("#GZTerimabahanmakan_nopenerimaanbahan").val(data.terima.nopenerimaanbahan);
            $("#GZTerimabahanmakan_sumberdanabhn").val(data.terima.sumberdanabhn);
            $("#GZTerimabahanmakan_tglterimabahan").val(data.terima.tglterimabahan);
            $("#GZTerimabahanmakan_tglsurjalan").val(data.terima.tglsurjalan);
            $("#GZTerimabahanmakan_nosuratjalan").val(data.terima.nosuratjalan);
            $("#GZTerimabahanmakan_keterangan_terima_bahan").val(data.terima.keterangan_terima_bahan);
            $("#GZTerimabahanmakan_supplier_nama").val(data.terima.supplier_nama);
            $("#GZTerimabahanmakan_totaldiscount").val(data.terima.totaldiscount);
            $("#discountpersen").val(Math.round(data.terima.totaldiscount * 100 / data.terima.totalharganetto));
            $("#GZTerimabahanmakan_biayapengiriman").val(data.terima.biayapengiriman);
            $("#GZTerimabahanmakan_biayatransportasi").val(data.terima.biayatransportasi);
            $("#GZTerimabahanmakan_biayapajak").val(data.terima.biayapajak);
            $("#GZTerimabahanmakan_supplier_id").val(data.terima.supplier_id);
            $("#GZTerimabahanmakan_nopengajuan").val(data.terima.nopengajuan);
            
            $("#<?php echo CHtml::activeId($model, 'pajak_id') ?>").val(data.terima.pajak_id);
            $("#<?php echo CHtml::activeId($model, 'pajak_nama') ?>").val(data.terima.pajak_nama);
            
            $("#<?php echo CHtml::activeId($model, 'jmluangmukabeli') ?>").val(data.terima.jumlahuangmuka);
            $("#<?php echo CHtml::activeId($modUangmuka, 'nopembayaran') ?>").val(data.terima.nobayaruangmuka);
            $("#<?php echo CHtml::activeId($modUangmuka, 'tgluangmukabeli') ?>").val(data.terima.tglbayaruangmuka);
            $("#<?php echo CHtml::activeId($modUangmuka, 'jumlahuang') ?>").val(data.terima.jumlahuangmuka);
            if(data.checkuangmuka==true){
                $('#divuangmukabeli').show();
            }else{
                $('#divuangmukabeli').hide();
            }
            // insert table
            $("#tableBahanMakanan tbody").html(data.terima.detail);
            renameInputRowBahanMakanan('tableBahanMakanan');
            //hitungSemua();
            //hitungTotalDiscount();
           hitungSemua();
           loadJatuhTempo();
           
            $("#tableBahanMakanan tbody tr:last .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
            //$("#tableBahanMakanan tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
            //$("#tableBahanMakanan tbody tr:last .satuanbahan").val(satuanbahan);
            $("#tableBahanMakanan tbody tr .tanggal").datepicker(
                jQuery.extend(
                    {showMonthAfterYear:true},
                    jQuery.datepicker.regional['id'],
                    {
                        'dateFormat':'dd M yy',
                        'changeYear':true,
                        'changeMonth':true,
                        'showAnim':'fold',
                        'yearRange':'-0y:+10y'
                    }
                )
            );
//            formatNumberSemua();
            $("#tableBahanMakanan tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
            $("#qty, #satuanbahan, #namaBahan, #isBahan, #ukuran, #merk").val("");
        }, 'json');
    }
    
function inputBahanMakanan(){
		unformatNumberSemua();
        var id = $('#idBahan').val();
        var qty= $('#qty').val();
        var ukuran = $('#ukuran').val();
        var merk = $('#merk').val();
        var satuanbahan = $('#satuanbahan').val();
        if (jQuery.isNumeric(id)){
            $.post('<?php echo $urlBahan; ?>',{id:id, qty:qty,ukuran:ukuran,merk:merk, satuanbahan:satuanbahan},function(data){
                $('#tableBahanMakanan tbody').append(data);		
                renameInputRowBahanMakanan('tableBahanMakanan');
                hitungSemua();
                hitungTotalDiscount();	    	
                $("#tableBahanMakanan tbody tr:last .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
				//$("#tableBahanMakanan tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
                $("#tableBahanMakanan tbody tr:last .satuanbahan").val(satuanbahan);
				$("#tableBahanMakanan tbody tr:last .tanggal").datepicker(
					jQuery.extend(
						{showMonthAfterYear:true},
						jQuery.datepicker.regional['id'],
						{
							'dateFormat':'dd M yy',
							'changeYear':true,
							'changeMonth':true,
							'showAnim':'fold',
							'yearRange':'-0y:+10y'
						}
					)
				);
				formatNumberSemua();
				$("#tableBahanMakanan tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
				$("#qty, #satuanbahan, #namaBahan, #isBahan, #ukuran, #merk").val("");
            });
        }
        else{
            myAlert('Isi Data dengan Benar');
        }
    }
    
    function hitungSemua(){
		unformatNumberSemua();
//        var value = 0;
        var totalharga = 0;
        var totaldiskon = 0;
        var totalppn = 0;
        var totalpph = 0;
        var totalsubtotal = 0;
        $('.noUrut').each(function(){
//            hitung(this);
            $(this).parents('tr').find('#checkList').attr('name','checkList['+(noUrut-1)+']');
            var netto = parseFloat($(this).parents('tr').find('input[name$="[harganettobahan]"]').val());
            var jml = parseFloat($(this).parents('tr').find('input[name$="[qty_terima]"]').val());
            var persendiskon = parseFloat($(this).parents('tr').find('input[name$="[persendiscount]"]').val());
            var persenppn = parseFloat($(this).parents('tr').find('input[name$="[persenppn]"]').val());
            var persenpph = parseFloat($(this).parents('tr').find('input[name$="[persenpph]"]').val());

            var jmlQty = (netto * jml);
            if (jmlQty > 0){
                    jmlQty = parseFloat(jmlQty.toFixed(2));
                }
                
                
            var jmldiskon = ((jmlQty * persendiskon)/100);
            if (jmldiskon > 0){
                    jmldiskon = parseFloat(jmldiskon.toFixed(2));
                }
                
            var jmlppn = (((jmlQty - jmldiskon) * persenppn)/100);
            if (jmlppn > 0){
                    jmlppn = parseFloat(jmlppn.toFixed(2));
                }
                
            var jmlpph = (((jmlQty - jmldiskon) * persenpph)/100);
                if (jmlpph > 0){
                    jmlpph = parseFloat(jmlpph.toFixed(2));
                }
                
            var subtotal = (jmlQty - jmldiskon + jmlppn - jmlpph);
                if (subtotal > 0){
                    subtotal = parseFloat(subtotal.toFixed(2));
                }
                
            $(this).parents('tr').find('.subNetto').val(subtotal);
            $(this).parents('tr').find('.jmldiscount').val(jmldiskon);
            $(this).parents('tr').find('.jmlhargappn').val(jmlppn);
            $(this).parents('tr').find('.jmlhargapph').val(jmlpph);
            $(this).parents('tr').find('.hargajualbhn').val(subtotal);
            
//            $(this).parents('tr').find('input[name$="[harganettobhn]"]').val(netto);
            
            // totalharga += netto;
            totalharga += parseFloat(netto*jml);
            totaldiskon += jmldiskon;
            totalppn += jmlppn;
            totalpph += jmlpph;
            totalsubtotal += subtotal;

        });
        $(".total_semua").val(totalsubtotal);
        $('#<?php echo CHtml::activeId($model, 'totalharganetto') ?>').val(totalharga);
        $('#<?php echo CHtml::activeId($model, 'totaldiscount') ?>').val(totaldiskon);
        $('#<?php echo CHtml::activeId($model, 'pajakppn') ?>').val(totalppn);
        $('#<?php echo CHtml::activeId($model, 'pajakpph') ?>').val(totalpph);
        $('#<?php echo CHtml::activeId($model, 'totalkeseluruhan') ?>').val(totalsubtotal);
        
        var jmluangmukabeli = parseFloat($("#<?php echo CHtml::activeId($model, 'jmluangmukabeli') ?>").val());
        var totalhutang = (totalsubtotal - jmluangmukabeli);
        $("#<?php echo CHtml::activeId($model, 'totalhutangusaha') ?>").val(totalhutang);
        formatNumberSemua();
    }
	   	
    function hitung(obj){
        var netto = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[harganettobahan]"]').val()));
        var jml = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[qty_terima]"]').val()));
        var persendiskon = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[persendiscount]"]').val()));
        var persenppn = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[persenppn]"]').val()));
        var persenpph = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[persenpph]"]').val()));
        
        var jmlQty = (netto * jml);
        var jmldiskon = ((jmlQty * persendiskon)/100);
        var jmlppn = (((jmlQty - jmldiskon) * persenppn)/100);
        var jmlpph = (((jmlQty - jmldiskon) * persenpph)/100);
        
        var subtotal = (jmlQty - jmldiskon + jmlppn - jmlpph);
        
        $(obj).parents('tr').find('.subNetto').val(formatNumber(subtotal));
        $(obj).parents('tr').find('.jmldiscount').val(formatNumber(jmldiskon));
        $(obj).parents('tr').find('.jmlhargappn').val(formatNumber(jmlppn));
        $(obj).parents('tr').find('.jmlhargapph').val(formatNumber(jmlpph));
        $(obj).parents('tr').find('input[name$="[harganettobhn]"]').val(formatNumber(netto));
	
    }
    
    function hapus(obj) {
        $(obj).parents('tr').remove();
        hitungSemua();
    }
    
    function hitungTotal(obj){
		unformatNumberSemua();
        var netto = $(obj).parents('tr').find('.harganettobahan').val();
        var jml = $(obj).val();
        $(obj).parents('tr').find('.subNetto').val(netto*jml);
        hitungSemua();
        hitungTotalDiscount();
		formatNumberSemua();
    }
    
    function hitungTotalDiscount(){
		//unformatNumberSemua();
        var discountPersen = $('#discountpersen').val();
        var totaldiscount = 0;
            if (jQuery.isNumeric(discountPersen)){
                $('.discount').each(function(){
                    if ($(this).parents('tr').find('.cekList').is(':checked')){
                        var subnetto = parseFloat(unformatNumber($(this).parents('tr').find('.subNetto').val()));
                        var discount = subnetto*discountPersen/100;
						
                        $(this).val(formatNumber(discount));
                        totaldiscount+=discount;
                    }
                });
            }
            else{
                $('.discount').each(function(){
                    var discount = parseFloat($(this).val());
                    if ($(this).parents('tr').find('#checkList').is(':checked')){
                        totaldiscount+=discount;
                    }
                });      
            }
	//	formatNumberSemua();
        $('#GZTerimabahanmakan_totaldiscount').val(formatNumber(totaldiscount));
    }
	
	function renameInputRowBahanMakanan(obj_table){
		var row = 0;
		$('#'+obj_table).find("tbody > tr").each(function(){
		$(this).find("#noUrut").val(row+1);
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
	

	function printData()
	{
		var terimabahanmakan_id = "<?php echo $model->terimabahanmakan_id?>";
		window.open("<?php echo $this->createUrl('detailPenerimaan') ?>&id="+terimabahanmakan_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
	}
	
        function setTotalHarga() {
            var discountPersen = parseFloat(unformatNumber($('#discountpersen').val()));
            var totalHarga = 0;
            $('.cancel').each(function(){
                qty = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[qty_terima]"]').val()));
                satuan =  parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[harganettobahan]"]').val()));
                $(this).parents('tr').find('.subNetto').val(qty*satuan);
                totalHarga += parseFloat(qty*satuan);
            });
            var diskonHarga = 0;
            $('#<?php echo CHtml::activeId($model, 'totalharganetto') ?>').val(formatNumber(totalHarga));
                    $("#tothargabruto").val(formatNumber(totalHarga));
            if(jQuery.isNumeric(discountPersen)){
                diskonHarga = totalHarga*discountPersen/100; 
                $('#<?php echo CHtml::activeId($model, 'totaldiscount') ?>').val(formatNumber(diskonHarga));
            }
            totPPN($("#<?php echo CHtml::activeId($model, 'pajakppn') ?>"));

            var pph22 = unformatNumber($('#<?php echo CHtml::activeId($model, 'persenpph_22') ?>').val());
            var totSementara = totalHarga - diskonHarga;
            var pph = (pph22/100) * totSementara;
            $('#<?php echo CHtml::activeId($model, 'pajakpph') ?>').val(formatNumber(pph));
            getTotalSeluruh();
          
	}
        
        function totPPN()
	{                 
		if ($('#termasukPPN').is(":checked")){
			var total_harga = unformatNumber($("#<?php echo CHtml::activeId($model, 'totalharganetto') ?>").val());
			var discount = unformatNumber($("#<?php echo CHtml::activeId($model, 'totaldiscount') ?>").val());

			var totSementara = total_harga - discount;

			var ppn = (10/100) * totSementara;

			$("#<?php echo CHtml::activeId($model, 'pajakppn') ?>").val(formatNumber(ppn));
		}else{
			$("#<?php echo CHtml::activeId($model, 'pajakppn') ?>").val(formatNumber(0));
		}

		getTotalSeluruh();
	}
        
        function getTotalSeluruh()
	{
		unformatNumberSemua();
		var totalharga = $("#<?php echo CHtml::activeId($model, 'totalharganetto') ?>").val();
		var diskon = $("#<?php echo CHtml::activeId($model, 'totaldiscount') ?>").val();
//		var biayaadmin = $("#<?php // echo CHtml::activeId($model, 'biayaadministrasi') ?>").val();
		var pajakpph = $("#<?php echo CHtml::activeId($model, 'pajakpph') ?>").val();
		var pajakppn = $("#<?php echo CHtml::activeId($model, 'pajakppn') ?>").val();
//		var totalkeseluruhan = (parseInt(totalharga) - parseInt(diskon)) + parseInt(biayaadmin) + parseInt(pajakpph) + parseInt(pajakppn);
var totalkeseluruhan = (parseInt(totalharga) - parseInt(diskon)) + parseInt(pajakpph) + parseInt(pajakppn);

		$("#<?php echo CHtml::activeId($model, 'totalkeseluruhan') ?>").val(totalkeseluruhan);
		formatNumberSemua();
	}
        
	$(document).ready(function() {
		renameInputRowBahanMakanan('tableBahanMakanan');
//		hitung();
                hitungSemua();
		setTimeout(function() {
			$("#tableBahanMakanan tbody tr .tanggal").each(function() {
				$(this).datepicker(
					jQuery.extend(
						{showMonthAfterYear:true},
						jQuery.datepicker.regional['id'],
						{
							'dateFormat':'dd M yy',
							'changeYear':true,
							'changeMonth':true,
							'showAnim':'fold',
							'yearRange':'-0y:+10y'
						}
					)
				);
			});
		}, 500);
		
		$("form").submit(function(){
			supplier = $("#<?php echo CHtml::activeId($model, 'supplier_id'); ?>").val();
			jumlah = 0;
			$(".cekList").each(function(){
				if ($(this).is(":checked")){
					jumlah++;
				}
			});

			if (jumlah < 1){
				myAlert("Pilih Nama Bahan Makanan yang akan diajukan!");
				return false;
			}
		});
		
		$(".alphanumber").keyup(function()
		{
			$(this).val($(this).val().replace(/[^\w\s]/gi, ''));
		});
	});
    
    function persenPpn(obj)
    {
        if(obj.checked==true){ //Jika tidak termasuk PPN
            var jumlahPPN = parseFloat(unformatNumber($('#GZTerimabahanmakan_totalharganetto').val())) * (parseFloat(10/100));
            $('#termasukPPN').val(jumlahPPN);
            $('#GZTerimabahanmakan_pajakppn').val(formatNumber(jumlahPPN));
            $('#termasukPPH').removeAttr('readonly');
        }else{//Jika Termasuk PPN
            $('#termasukPPH').removeAttr('checked'); 
            $('#GZTerimabahanmakan_pajakppn').val(0);
            $('#termasukPPH').attr('readonly','TRUE');
            $('#GZTerimabahanmakan_pajakppn').val(0);     
            $('#totalPPH').val(0);
            $('#termasukPPH').val(0);  
            $('#termasukPPN').val(0);     
        }
       hitungSemua();

    }
    
    function setVerifikasiHpp() {
            if (requiredCheck($("form"))) {
                var index = 0;
                var pesanharga = "";
                var kecilHpp = 0;
                var cekpph = 0;
                
                $('#tableBahanMakanan tbody tr').each(function () {
                    unformatNumberSemua();
                   var hargaLama =  parseFloat($(this).find('input[name$="[harganettomaster]"]').val());
                   var hargabaru =  parseFloat($(this).find('input[name$="[harganettobahan]"]').val());
                   var namaBahan =  $(this).find('input[name$="[namabahanmaster]"]').val();
                   var persenpph =  parseFloat($(this).find('input[name$="[persenpph]"]').val());

                   if(hargaLama != hargabaru){
                       kecilHpp += 1;
                       if(index>0){
                            pesanharga +=","; 
                         }
                         pesanharga +=namaBahan+" ("+hargabaru+")";
                          index++;
                   }else{
                       if(kecilHpp > 1){
                           kecilHpp -=1;
                       }
                   }
                   
                   if(persenpph > 0){
                       cekpph += 1;
                   }else{
                       if(cekpph > 1){
                           cekpph -= 1;
                       }
                   }
                   
                   

                   $(this).find('input[name$="[hppcheck]"]').val(0);
                   formatNumberSemua();
                });
                
                if(cekpph > 0){
                    if($('#<?php echo CHtml::activeId($model,'pajak_id'); ?>').val() == ''){
                         myAlert("Jenis Pajak harus diisi ");
                        return false;
                    }
                }
                
                if(kecilHpp > 0){
                    $.alerts.okButton = "Ya";
                    $.alerts.cancelButton = "Tidak";
                    myConfirm("Harga Netto '"+pesanharga+"' berbeda dengan yang ada di master. Apakah Anda ingin melakukan update harga otomatis?","Perhatian!",function(r) {
                    if (r){
                        $('#tableBahanMakanan tbody tr').each(function () {
                            $(this).find('input[name$="[hppcheck]"]').val(1);
                        });
                        $('.integer-decimal, .integer2, .float2').each(function(){
                            $(this).val(unformatNumber($(this).val()));
                        });
                         $("#gzterimabahanmakan-form").submit();
                   }else{
                       $('#tableBahanMakanan tbody tr').each(function () {
                            $(this).find('input[name$="[hppcheck]"]').val(0);
                        });
                        $('.integer-decimal, .integer2, .float2').each(function(){
                            $(this).val(unformatNumber($(this).val()));
                        });
                       $("#gzterimabahanmakan-form").submit();
                   }
               });
                }else{
                   $('#tableBahanMakanan tbody tr').each(function () {
                       $(this).find('input[name$="[hppcheck]"]').val(1);
                   });
                   $('.integer-decimal, .integer2, .float2').each(function(){
                        $(this).val(unformatNumber($(this).val()));
                    });
                   $("#gzterimabahanmakan-form").submit();
                }
            }
            return false;
	}
        
function loadJatuhTempo()
{
    var tanggalfaktur = $('#<?php echo CHtml::activeId($model, 'tglfaktur'); ?>').val();
    var supplierid = $('#<?php echo CHtml::activeId($model, 'supplier_id'); ?>').val();
   
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('loadJatuhTempo'); ?>',
        data: {tgl_faktur: tanggalfaktur,supplier_id:supplierid},
        dataType: "json",
        success:function(data){
            $('#<?php echo CHtml::activeId($model, 'tgljatuhtempo'); ?>').val(data.value);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
     
</script>