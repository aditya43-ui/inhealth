<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}
function replaceseparators(num)
  {
    var num_parts = num.toString().replace(".", ",");
    return num_parts;
  }
function tambahObatAlkes()
{
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlah = $('#qty_input').val();
    var tgl_kadaluarsa = $('#tgl_kadaluarsa').val();
    
    if(tgl_kadaluarsa != ''){
        if(obatalkes_id != '')
        {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormPenerimaanBarang'); ?>',
                data: {obatalkes_id:obatalkes_id,jumlah:jumlah,tgl_kadaluarsa:tgl_kadaluarsa},//
                dataType: "json",
                success:function(data){
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );
                    renameInputRowObatAlkes($("#table-obatalkespasien"));                    
                    hitungTotal();
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            myAlert("Isikan item obat terlebih dahulu");
        }
    }else{
        myAlert("Isikan tanggal kadaluarsa terlebih dahulu");
    }
}

//function unformatNumberSemua(){
//    $(".integer2").each(function(){
//        $(this).val(parseInt(unformatNumber($(this).val())));
//    });
//     $(".float2").each(function(){
//        $(this).val(parseFloat(unformatNumber($(this).val())));
//    });
//    $(".integerfloat").each(function(){
//        $(this).val(parseFloat(unformatNumber($(this).val())));
//    });
//}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
//function formatNumberSemua(){
//    $(".float2").each(function(){
//        $(this).val(formatFloat($(this).val()));
//    });
//    $(".integerfloat").each(function(){
//        $(this).val(formatThousandDecimal($(this).val()));
//    });
//    $(".integer2").each(function(){
//        $(this).val(formatNumber($(this).val()));
//    });
//}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
    var persenppn = 0;
    var persenpph = 0;
    var totnetto = 0;
    var totdisc = 0;
    var totbruto = 0
	var tothpp = 0;
	var subhpp = 0;
	var totppn = 0;
	var totpph = 0;
	var totnettqty = 0;	
	var totppnterima = 0;
	var totpphterima = 0;
	var totdisterima = 0;
	
	var totdisfaktur = 0;
	
    $('#table-obatalkespasien tbody tr').each(function(){
//		setJmlDiskon2($(this).find('input[name$="[persendiscount]"]'));		
        var jmlterima  = parseFloat($(this).find('input[name$="[jmlterima]"]').val());
        var harganetto  = parseFloat($(this).find('input[name$="[harganettoper]"]').val());
        var persendis  = parseFloat($(this).find('input[name$="[persendiscount]"]').val());
//        var jmldis  = parseFloat($(this).find('input[name$="[jmldiscount]"]').val());
        var persen_ppn  = parseInt($(this).find('input[name$="[persenppn]"]').val());
        var persen_pph  = parseFloat($(this).find('input[name$="[persenpph]"]').val());
//        var hpp  = parseFloat(unformatNumber($(this).find('input[name$="[hargasatuanper]"]').val()));
        var kemasanbesar = parseInt($(this).find('input[name$="[kemasanbesar]"]').val());
                
        if((typeof kemasanbesar === "undefined") || isNaN(kemasanbesar)){
            kemasanbesar = 0;
        }
        
        if(kemasanbesar >0){
            jmlterima = (jmlterima * kemasanbesar);
        }
           //Rumus Baru     
                
         var JumlahNetto = (harganetto * jmlterima);
         if (JumlahNetto > 0){
            JumlahNetto = parseFloat(JumlahNetto.toFixed(2));
        }
         //diskon
         var jmlDiskon = (JumlahNetto * (persendis/100));
         if (jmlDiskon > 0){
            jmlDiskon = parseFloat(jmlDiskon.toFixed(2));
        }
         // ppn
         var jmlPPn = ((JumlahNetto - jmlDiskon) * (persen_ppn/100));
         if (jmlPPn > 0){
            jmlPPn = parseFloat(jmlPPn.toFixed(2));
        }
         //pph
         var jmlPPh = ((JumlahNetto - jmlDiskon) * (persen_pph/100));
         if (jmlPPh > 0){
            jmlPPh = parseFloat(jmlPPh.toFixed(2));
        }
         var subtotal = (JumlahNetto - jmlDiskon + jmlPPn - jmlPPh);
         if (subtotal > 0){
            subtotal = parseFloat(subtotal.toFixed(2));
        }
         totdisc += jmlDiskon;
         totppn += jmlPPn;
         totpph += jmlPPh;
         totbruto += subtotal;
         totnetto += JumlahNetto;
				
        $(this).find('input[name$="[subtotal]"]').val(subtotal);
        $(this).find('input[name$="[jmldiscount]"]').val(jmlDiskon);
        $(this).find('input[name$="[jmlppn]"]').val(jmlPPn);
        $(this).find('input[name$="[jmlpph]"]').val(jmlPPh);
        $(this).find('input[name$="[hargasatuanper]"]').val(subtotal);
    });
	 
    $('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(totdisc);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>').val(totnetto);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(totppn);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(totpph);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val(totbruto);
    
    var jmluangmukabeli  = parseFloat($('#<?php echo CHtml::activeId($modFakturPembelian,'jmluangmukabeli'); ?>').val());
    var totalusaha = (totbruto - jmluangmukabeli);
    
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalhutangusaha'); ?>').val(totalusaha);
	
    formatNumberSemua();
}

function hitungTotalByHPP(){
    unformatNumberSemua();
    var total = 0;
    var persenppn = 0;
    var persenpph = 0;
    var totnetto = 0;
    var totdisc = 0;
    var totbruto = 0
	var tothpp = 0;
	var subhpp = 0;
	var totppn = 0;
	var totpph = 0;
	var totnettqty = 0;
	var totppnterima = 0;
	var totpphterima = 0;
	var totdisterima = 0;
	var totaldiskon = 0;
	
	var totdisfaktur = 0;
	
    $('#table-obatalkespasien tbody tr').each(function(){		
		setJmlDiskon2($(this).find('input[name$="[persendiscount]"]'));		
		
        var jmlterima  = parseInt($(this).find('input[name$="[jmlterima]"]').val());
        var harganetto  = parseFloat(unformatNumber($(this).find('input[name$="[harganettoper]"]').val()));
        var persendis  = parseFloat($(this).find('input[name$="[persendiscount]"]').val());
        var jmldis  = parseFloat($(this).find('input[name$="[jmldiscount]"]').val());
		var persen_ppn  = parseInt($(this).find('input[name$="[persenppn]"]').val());
		var hpp  = parseFloat(unformatNumber($(this).find('input[name$="[hargasatuanper]"]').val()));
        		
      //  console.log("netto, persen diskon, jml diskon, hpp",harganetto, persendis, jmldis, hpp);        
	
        
        var ppn = 0;
        var rpppn = 0;
        var pph = 0;
        var rppph = 0;		
		
		//if(persendis > 0){
		//	//setPersenDiskon()
            //jmldis = harganetto * (persendis/100);
            totdisc += jmldis;
            //$(this).find('input[name$="[jmldiscount]"]').val(jmldis);
            //subtotal = subtotal - (subtotal * (persendis/100));
			//setPersenDiskon();
        //}else{
            //totdisc += jmldis;
			
            //$(this).find('input[name$="[persendiscount]"]').val(formatFloat(parseFloat(jmldis/harganetto) * 100));
            //subtotal = subtotal - jmldis;
        //} 
        
		//alert(jmldis);
	
		ppn = persen_ppn;
		rpppn = (harganetto - jmldis) * (ppn/100);          
    
        
        subhpp = hpp;
        
   
        
		subtotal = (subhpp * jmlterima);
		
		//console.log("subtotal by hpp",subtotal);
		
        persenpph += ( (Math.floor(rppph*100)/100) * jmlterima);
                       
        total += Math.round(subtotal);
        
        
        totbruto += Math.round(subtotal);
		
		tothpp += subhpp;
		
		totppn += (Math.floor(rpppn*100)/100);
		
		totnettqty += harganetto * jmlterima;
		
		totppnterima += ( (Math.floor(rpppn*100)/100) * jmlterima);
		totpphterima += (( (Math.floor(rppph*100)/100) * jmlterima));
		totdisterima += ((jmldis * jmlterima));
                
       // console.log("H Total ", subtotal);
                
		$(this).find('input[name$="[subtotal]"]').val(formatThousandDecimal(Math.round(subtotal)));
        $(this).find('input[name$="[jmldiscount]"]').val(formatThousandDecimal(jmldis));
        $(this).find('input[name$="[persenppn]"]').val(formatThousandDecimal(ppn));
        $(this).find('input[name$="[persenpph]"]').val(formatThousandDecimal(pph));
		$(this).find('input[name$="[jmlppn]"]').val(formatThousandDecimal(rpppn));
    });
	
	totdisfaktur = (parseFloat(totdisterima.toFixed(2))/totnettqty)*100;
	
	$('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val((totdisfaktur.toFixed(2)));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(Math.round(totdisterima));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>').val(Math.round(totnettqty));
    //$('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(Math.round(totppnterima));
    //$('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(Math.round(totpphterima));
	//$('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(Math.round(totdisterima));
    //$('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val(Math.round(totbruto));
	
    $('#total').val(formatThousandDecimal(Math.round(total)));    
	
	
    formatNumberSemua();
	
	hitungTotalFaktur('copy');
	
}

function setNettoUbah(obj){	   	
	var netto = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[harganettoper]"]').val()));	
	
	//console.log("netto ubah",formatThousandDecimal(netto));
	//alert(netto);
	$(obj).parents("tr").find('input[name$="[harganettoubah]"]').val(formatThousandDecimal(netto));			
}

function hitungTotalFaktur(copy){
	setJmlDiskonFaktur($('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>'));
	
    unformatNumberSemua();
    
	var jmldiskonasli = parseInt($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'jmldiscount'); ?>").val()); 
	
	var totalnetto = parseInt($("#<?php echo CHtml::activeId($modFakturPembelian, 'totharganetto'); ?>").val()); 
	var jmldiscount = parseInt(unformatNumber($("#<?php echo CHtml::activeId($modFakturPembelian, 'jmldiscount'); ?>").val())); 
	var persendiscount = parseFloat(($("#<?php echo CHtml::activeId($modFakturPembelian, 'persendiscount'); ?>").val())); 
	var persenppn = parseFloat($("#<?php echo CHtml::activeId($modFakturPembelian, 'persenppn'); ?>").val()); 
	var totalppn = parseInt($("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakppn'); ?>").val()); 
	var totalpph = parseInt($("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakpph'); ?>").val()); 
    var diskontot = 0;
	var totalseluruh = 0;
	var ppntot = 0;
    
  //  console.log("diskon ",formatThousandDecimal(persendiscount));
	
	diskontot = jmldiscount;//(totalnetto*(persendiscount/100));
        var afterdiskon = (totalnetto - diskontot);
	ppntot = Math.floor(afterdiskon*(persenppn/100));
		
    // console.log("tot netto, diskontot, ppntot, totalpph", totalnetto,diskontot,ppntot,totalpph);
    
    var totalseluruh = afterdiskon + ppntot - totalpph;
    
//	var totalseluruh = totalnetto - diskontot + ppntot - totalpph;
	
	//if (diskontot == 0){
		//$("#<?php //echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(diskontot);
	//}else{
		//$("#<?php //echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(diskontot);
	//}
	
	//console.log(totalseluruh);
	
	$("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakppn') ?>").val(ppntot);
	
	$("#<?php echo CHtml::activeId($modFakturPembelian, 'totalhargabruto') ?>").val(Math.round(totalseluruh));
	
        var pph22 = unformatNumber($('#GFFakturpembelianT_persenpph_22').val());
	$('#GFFakturpembelianT_totalpajakpph').val(formatNumber((pph22/100) * totalnetto));
	
    formatNumberSemua();
}

function setPersenDiskon(obj){
	
	var jmldiscount = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[jmldiscount]"]').val()));
	var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));
	var persen = 0;
	
	persen =((jmldiscount/satuan)*100);		
	
	//alert(persen);
	$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(formatFloat(parseFloat(persen)));		
}

function setPersenDisFaktur(obj){
	unformatNumberSemua();
    
	var jmldiscount = parseInt(unformatNumber($(obj).val()));
	var satuan = parseInt(unformatNumber($("#<?php echo CHtml::activeId($modFakturPembelian, 'totharganetto') ?>").val()));
	var persen = 0;
	
	persen = ((jmldiscount/satuan)*100);
	
	$("#<?php echo CHtml::activeId($modFakturPembelian, 'persendiscount') ?>").val(persen.toFixed(2));	
	formatNumberSemua();
}

function setJmlDiskonFaktur(obj){
    var persen = parseFloat(unformatNumber($(obj).val()));	
    var satuan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modFakturPembelian, 'totharganetto') ?>").val()));
    
	var jmldiscount = Math.round(satuan * (persen / 100));
	
	$("#<?php echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(jmldiscount);
}

function setPersenPPN(obj){	
    //$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
	var ppnpersen = parseInt($(obj).parents("tr").find('input[name$="[persenppn]"]').val());	
	
	if (ppnpersen > 0){
		ppnpersen = <?php echo Params::DEFAULT_PPN; ?>;
	}
	
	$(obj).parents("tr").find('input[name$="[persenppn]"]').val(ppnpersen);		
}

function setHPP(obj){	
    //$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
	unformatNumberSemua();
	var hpp = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[hargasatuanper]"]').val()));	
	var nettoubah  = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[harganettoubah]"]').val()));	
	var ppnpersen = parseFloat($(obj).parents("tr").find('input[name$="[persenppn]"]').val());
	var diskonpersen = parseFloat($(obj).parents("tr").find('input[name$="[persendiscount]"]').val());
	var jmlterima = parseFloat($(obj).parents("tr").find('input[name$="[jmlterima]"]').val());

//alert(hpp);
	var harganetto = 0;	
	
	if (hpp == 0){
		$(obj).parents("tr").find('input[name$="[harganettoper]"]').val(formatThousandDecimal(nettoubah));		
	}else{
		if (parseInt(diskonpersen) == 100){
			$(obj).parents("tr").find('input[name$="[hargasatuanper]"]').val(formatThousandDecimal(0));
			myAlert("HPP tidak bisa lebih dari 0, karena diskon di set 100%");
		}else{
            
            
            
			harganetto = ((hpp / (((100 - diskonpersen + ppnpersen)/100)  -  (ppnpersen*diskonpersen)/10000)));	

          //  console.log(hpp, diskonpersen, ppnpersen, harganetto);

			$(obj).parents("tr").find('input[name$="[harganettoper]"]').val(formatThousandDecimal(harganetto));		

			$(obj).parents("tr").find('input[name$="[subtotal]"]').val(formatThousandDecimal(hpp*jmlterima));		
		}
	}
			
	formatNumberSemua();
}

/**
 * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @returns {set persen ppn -- dalam field yang sama} 
 **/

function setPersenPPNTerima(obj){	
    //$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
	var ppnpersen = parseInt($(obj).val());	
	
	if (ppnpersen > 0){
		ppnpersen = <?php echo Params::DEFAULT_PPN; ?>;
	}
	
	$(obj).val(ppnpersen);		
}

function setJmlDiskon(obj){
    var persen = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[persendiscount]"]').val()));	
    var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));
    var qty = $(obj).parents("tr").find(".qty").val();
    
    //console.log(persen, satuan, qty);
    
    //$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(satuan * qty * persen / 100));
	jmldiskon = Math.round((satuan * (persen / 100)));
	
	//alert(jmldiskon);
	
	$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(jmldiskon));
}

function setJmlDiskon2(obj){

    var persen = parseFloat($(obj).parents("tr").find('input[name$="[persendiscount]"]').val());	
    var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));

    var qty = $(obj).parents("tr").find(".qty").val();
    
    //console.log(" Jml Diskon persen,satuan,qty ",persen, satuan, qty);
    
    //$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(satuan * qty * persen / 100));
	var jmldiskon = (satuan * (persen / 100));
	//console.log(" jml diskonya ",jmldiskon);
	//alert(formatNumber(jmldiskon));
	
	$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val((jmldiskon.toFixed(2)));
}

//function persenPpn(obj){
//    if(obj.checked == true){
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",false);        
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr('checked',true);
//        $('#termasukPPN').val(1);
//    }else{
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",true);
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').removeAttr('checked');
//        $('#termasukPPN').val(0);
//    }    
//    hitungTotal();
//}

//function persenPph(obj){
//    if(obj.checked == true){
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",false);
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr('checked',true);
//        $('#termasukPPH').val(1);
//    }else{
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",true);
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').removeAttr('checked');
//        $('#termasukPPH').val(0);
//    }    
//    hitungTotal();
//}

/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
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
    $('#obatalkes_id').val('');
    $('#obatalkes_nama').val('');
    $('#qty_input').val(1);
}

/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
 /*
function unformatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
} */
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
 /*
function formatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}
*/

function setJmlDiscountNol(obj) 
{
    $(obj).parents("tr").find(".jmldisc").val(0);
}

function setPersenDiscountNol(obj) 
{
    $(obj).parents("tr").find(".persendisc").val(0);
}

function pilihSatuan(obj){
    var satuanobat = $(obj).val();
    
    if(satuanobat == '<?php echo PARAMS::SATUAN_KECIL; ?>'){
        $(obj).parents('tr').find('.satuankecil').show();
        $(obj).parents('tr').find('.satuanbesar').hide();
    }else{
        $(obj).parents('tr').find('.satuanbesar').show();
        $(obj).parents('tr').find('.satuankecil').hide();
    }
}

function persenPpn(obj){
    if($(obj).is(":checked")){
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",false);        
    }else{
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",true);
    }   
    hitungTotal();
}

function persenPph(obj){
    if($(obj).is(":checked")){
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",false);
        
    }else{
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",true);
    }
    hitungTotal();
}

function checkAll(obj){
   if($("#checklist").is(':checked')){
        $("#table-obatalkespasien").find("input[name$='[checklist]'][type='checkbox']").each(function(){
            $(this).attr('checked',true);
        });
    }else{
        $("#table-obatalkespasien").find("input[name$='[checklist]'][type='checkbox']").each(function(){
            $(this).removeAttr('checked');
        });
    } 
    hitungTotal();
}

/**
* untuk print rencana kebutuhan
 */
function print(caraPrint)
{
    var fakturpembelian_id = $('#fakturpembelian_id').val();
    window.open('<?php echo $this->createUrl('print'); ?>&fakturpembelian_id='+fakturpembelian_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function tombolSimpan(){
    if(requiredCheck($("form"))){
        // return false;
        $(".animation-loading").removeClass("animation-loading");
            var index = 0;
            var pesanharga = "";
            var kecilHpp = 0;
            var cekpph = 0;

            $('#table-obatalkespasien tbody tr').each(function () {
                unformatNumberSemua();
               var hargaLama =  parseFloat($(this).find('input[name$="[harganettopermaster]"]').val());
               var hargabaru =  parseFloat($(this).find('input[name$="[harganettoper]"]').val());
               var namaBahan =  $(this).find('input[name$="[namaobatmaster]"]').val();
               var persenpph =  $(this).find('input[name$="[persenpph]"]').val();

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
                if($('#<?php echo CHtml::activeId($modFakturPembelian,'pajak_id'); ?>').val() === ''){
                     myAlert("Jenis Pajak harus diisi ");
                    return false;
                }
            }
            
            if(kecilHpp > 0){
                myConfirm("Harga Netto '"+pesanharga+"' berbeda dengan yang ada di master. Apakah anda ingin melakukan update harga otomatis?","Perhatian!",function(r) {
                if (r){
                    $('#table-obatalkespasien tbody tr').each(function () {
                        $(this).find('input[name$="[hppcheck]"]').val(1);
                    });
                      $('.integer-decimal, .float2, .integer2').each(function(){
                        $(this).val(unformatNumber($(this).val()));
                    });
                     $('#fakturpembelian-form').submit();
               }else{
                   $('#table-obatalkespasien tbody tr').each(function () {
                        $(this).find('input[name$="[hppcheck]"]').val(0);
                    });
                      $('.integer-decimal, .float2, .integer2').each(function(){
                        $(this).val(unformatNumber($(this).val()));
                    });
                   $('#fakturpembelian-form').submit();
               }
           });
            }else{
               $('#table-obatalkespasien tbody tr').each(function () {
                   $(this).find('input[name$="[hppcheck]"]').val(1);
               });
                 $('.integer-decimal, .float2, .integer2').each(function(){
                    $(this).val(unformatNumber($(this).val()));
                });
               $('#fakturpembelian-form').submit();
            }
    }
    return false;
}

function setFakturObatAlkes(penerimaanbarang_id){
	$('#table-obatalkespasien').addClass('animation-loading');
	$('#table-obatalkespasien > tbody > tr').detach();
	if(penerimaanbarang_id != ''){
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('loadPenerimaanBarang'); ?>',
			data: {penerimaanbarang_id:penerimaanbarang_id},//
			dataType: "json",
			success:function(data){
				if(data.pesan == ''){
					$('#table-obatalkespasien > tbody').append(data.form);
					$("#table-obatalkespasien").find('input[name$="[ii][penerimaanbarang_id]"]').val(penerimaanbarang_id);
					$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
					);
					$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integerfloat"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
					);
					$("#table-obatalkespasien").find('input[name*="[ii]"][class*="float2"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
					);
                                        if(data.dataUangMuka != null && data.dataUangMuka != ''){
                                            $('#<?php echo CHtml::activeId($modFakturPembelian, 'jmluangmukabeli'); ?>').val(data.dataUangMuka.jumlahuang);
                                            $("#<?php echo CHtml::activeId($modUangmuka, 'nopembayaran') ?>").val(data.dataUangMuka.nopembayaran);
                                            $("#<?php echo CHtml::activeId($modUangmuka, 'tgluangmukabeli') ?>").val(data.dataUangMuka.tgluangmukabeli);
                                            $("#<?php echo CHtml::activeId($modUangmuka, 'jumlahuang') ?>").val(data.dataUangMuka.jumlahuang);
                                            if(data.checkuangmuka==true){
                                                $('#divuangmukabeli').show();
                                            }else{
                                                $('#divuangmukabeli').hide();
                                            }
                                        }
                                        $('#<?php echo CHtml::activeId($modFakturPembelian, 'pajak_id'); ?>').val(data.pajak_id);
                                        $('#<?php echo CHtml::activeId($modFakturPembelian, 'pajak_nama'); ?>').val(data.pajak_nama);
					renameInputRowObatAlkes($("#table-obatalkespasien"));                    
					hitungTotal();
                                        loadJatuhTempo();
				}else{
					myAlert(data.pesan);
				}
				$('#table-obatalkespasien').removeClass('animation-loading');
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
    }else{
        myAlert("Isikan tanggal kadaluarsa terlebih dahulu");
    }
}

function loadJatuhTempo()
{
    var tanggalfaktur = $('#<?php echo CHtml::activeId($modFakturPembelian, 'tglfaktur'); ?>').val();
    var supplierid = $('#<?php echo CHtml::activeId($modPenerimaanBarang, 'supplier_id'); ?>').val();
   
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('loadJatuhTempo'); ?>',
        data: {tgl_faktur: tanggalfaktur,supplier_id:supplierid},
        dataType: "json",
        success:function(data){
            $('#<?php echo CHtml::activeId($modFakturPembelian, 'tgljatuhtempo'); ?>').val(data.value);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}


/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var satuanobat = $('#GFRencDetailkebT_satuanobat').val();
    $('#satuankecil').hide();
    $('#satuanbesar').hide();
	
	$("#GFFakturpembelianT_biayamaterai").val(formatNumber($("#GFFakturpembelianT_biayamaterai").val()));
	
    if(satuanobat == 'SATUANKECIL'){
        $('#satuankecil').show();
        $('#satuanbesar').hide();
    }else{
        $('#satuanbesar').show();
        $('#satuankecil').hide();
    }
    
    var penerimaanbarang_id = '<?php echo $modPenerimaanBarang->penerimaanbarang_id; ?>';
    var penerimaanbarang_id = '<?php echo $modFakturPembelian->fakturpembelian_id; ?>';
    if(penerimaanbarang_id != ""){
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }
    if(fakturpembelian_id != ""){
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }
    
    $("#diskonSemua").change(function()
    {
        $('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').prop("readonly", !$(this).is(":checked")).val(0);
        hitungTotal();
    });
});
</script>