<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}
	
/** control accordion uang muka */
$('#form-uangmuka > div > .accordion-heading').click(function(){
    var is_uangmuka = $("#<?php echo CHtml::activeId($modPenerimaanBarang, "is_uangmuka"); ?>");
    if(is_uangmuka.val() > 0){ //hide
        is_uangmuka.val(0);
    }else{//show
        is_uangmuka.val(1);
		$('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').attr("readonly",true);
    }
    
//    $("#form-uangmuka :input").attr("readonly",false);
});

/** control accordion faktur pembelian */
$('#form-fakturpembelian > div > .accordion-heading').click(function(){
    var is_langsungfaktur = $("#<?php echo CHtml::activeId($modPenerimaanBarang, "is_langsungfaktur"); ?>");
    if(is_langsungfaktur.val() > 0){ //hide
        is_langsungfaktur.val(0);
    }else{//show
        is_langsungfaktur.val(1);
        loadJatuhTempo();
    }
});

function tambahObatAlkes()
{
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlah = $('#qty_input').val();
	var statusobat = $("#statusobat").val();
    var nobatch = $('#nobatch').val();
	var tipesatuan = $("#tipesatuan").val();
	var supplier_id = $("#<?php echo CHtml::activeId($modPenerimaanBarang, 'supplier_id') ?>").val();
    var tgl_kadaluarsa = $('#<?php echo CHtml::activeId($modPenerimaanBarang,'tglkadaluarsa'); ?>').val()
    
    if(tgl_kadaluarsa != ''){
        if(obatalkes_id != '')
        {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormPenerimaanBarang'); ?>',
                data: {supplier_id:supplier_id, tipesatuan:tipesatuan, statusobat:statusobat,obatalkes_id:obatalkes_id,jumlah:jumlah,tgl_kadaluarsa:tgl_kadaluarsa, nobatch:nobatch},//
                dataType: "json",
                success:function(data){
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );
					$("#table-obatalkespasien").find('input[name*="[ii]"][class*="float2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
                    );
					$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integerfloat"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
                    );

                    $("#table-obatalkespasien").find('tbody').find('tr:last').find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney({ "symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2 });

                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                    jQuery('input[name$="[tglkadaluarsa]"]').datetimepicker(
                            jQuery.extend(
                                {
                                    showMonthAfterYear:false
                                }, 
                                jQuery.datepicker.regional['id'],
                                {
//                                    'dateFormat':'dd M yy',
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
                        ).mask("99/99/9999 99:99:99");
                    
                    hitungTotal();
                    $("#table-obatalkespasien").find(".satuanobat").change();
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

var totppnterima = 0;
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
	var totpphterima = 0;
	var totdisterima = 0;
	
	var totdisfaktur = 0;
    
    totppnterima = 0;
	
	
    $('#table-obatalkespasien tbody tr').each(function(){
//		setJmlDiskon2($(this).find('input[name$="[persendiscount]"]'));		
		
        var jmlterima  = parseFloat($(this).find('input[name$="[jmlterima]"]').val());
        var harganetto  = parseFloat($(this).find('input[name$="[harganettoper]"]').val());
        var persendis  = parseFloat($(this).find('input[name$="[persendiscount]"]').val());
//        var jmldis  = parseFloat($(this).find('.jmldiscount_raw').val());
		var persen_ppn  = parseInt($(this).find('input[name$="[persenppn]"]').val());
		var persen_pph  = parseInt($(this).find('input[name$="[persenpph]"]').val());
//		var hpp  = parseFloat(unformatNumber($(this).find('input[name$="[hargasatuanper]"]').val()));
        	var kemasanbesar = parseInt($(this).find('input[name$="[kemasanbesar]"]').val());
                
        if((typeof kemasanbesar === "undefined") || isNaN(kemasanbesar)){
            kemasanbesar = 0;
        }
        
        if(kemasanbesar >0){
            jmlterima = (jmlterima * kemasanbesar);
        }
         var totalJml = (harganetto * jmlterima);
         if (totalJml > 0){
            totalJml = parseFloat(totalJml.toFixed(2));
        }
        var jmlDiskon = ((totalJml * persendis)/100);
         if (jmlDiskon > 0){
            jmlDiskon = parseFloat(jmlDiskon.toFixed(2));
        }
        var jmlPpn = (((totalJml-jmlDiskon) * persen_ppn)/100);
         if (jmlPpn > 0){
            jmlPpn = parseFloat(jmlPpn.toFixed(2));
        }
        var jmlPph = (((totalJml-jmlDiskon) * persen_pph)/100);
         if (jmlPph > 0){
            jmlPph = parseFloat(jmlPph.toFixed(2));
        }
        var subtotal = (totalJml - jmlDiskon + jmlPpn - jmlPph); 
         if (subtotal > 0){
            subtotal = parseFloat(subtotal.toFixed(2));
        }
        
        totnetto += totalJml;
        totdisc += jmlDiskon;
        totppn += jmlPpn;
        totpph += jmlPph;
        totbruto += subtotal;
        
				
        
        $(this).find('input[name$="[subtotal]"]').val(subtotal);
        $(this).find('input[name$="[jmldiscount]"]').val(jmlDiskon);
        $(this).find('input[name$="[hargasatuanper]"]').val(subtotal);
        $(this).find('input[name$="[jmlppn]"]').val(jmlPpn);
        $(this).find('input[name$="[jmlpph]"]').val(jmlPph);
    });
	
    $('#<?php echo CHtml::activeId($modPenerimaanBarang,'jmldiscount'); ?>').val(totdisc);
    $('#<?php echo CHtml::activeId($modPenerimaanBarang,'harganetto'); ?>').val(totnetto);
    $('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalpajakppn'); ?>').val(totppn);
    $('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalpajakpph'); ?>').val(totpph);
    $('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalharga'); ?>').val(totbruto);

    <?php if(Yii::app()->user->getState('isfakturdigudang') == true){ ?>
    $('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(totdisc);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>').val(totnetto);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(totppn);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(totpph);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val(totbruto);
    
    $('#<?php echo CHtml::activeId($modFakturPembelian,'jmluangmukabeli'); ?>').val(parseFloat($('#<?php echo CHtml::activeId($modPenerimaanBarang,'jumlahuang'); ?>').val()));
    var jmluangmukabeli  = parseFloat($('#<?php echo CHtml::activeId($modFakturPembelian,'jmluangmukabeli'); ?>').val());
    var totalusaha = (totbruto - jmluangmukabeli);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalhutangusaha'); ?>').val(totalusaha);
    <?php } ?>
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
	var totpphterima = 0;
	var totdisterima = 0;
	var totaldiskon = 0;
	
	var totdisfaktur = 0;
    
    totppnterima = 0;
	
    $('#table-obatalkespasien tbody tr').each(function(){		
		setJmlDiskon2($(this).find('input[name$="[persendiscount]"]'));		
		
        var jmlterima  = parseInt($(this).find('input[name$="[jmlterima]"]').val());
        var harganetto  = parseFloat(unformatNumber($(this).find('input[name$="[harganettoper]"]').val()));
        var persendis  = parseFloat($(this).find('input[name$="[persendiscount]"]').val());
        var jmldis  = parseFloat($(this).find('input[name$="[jmldiscount]"]').val());
		var persen_ppn  = parseInt($(this).find('input[name$="[persenppn]"]').val());
		var hpp  = parseFloat(unformatNumber($(this).find('input[name$="[hargasatuanper]"]').val()));
        		
        //console.log("netto, persen diskon, jml diskon, hpp",harganetto, persendis, jmldis, hpp);        
	
        
        var ppn = 0;
        var rpppn = 0;
        var pph = 0;
        var rppph = 0;		
		
        totdisc += jmldis;
	
		ppn = persen_ppn;
		rpppn = (harganetto - jmldis) * (ppn/100);          
    
        
        subhpp = hpp;
        
   
        
		var subtotal = Math.round((subhpp * jmlterima));
		
		
        persenpph += ((rppph*100)/100) * jmlterima;
                       
        total += (subtotal);
        
        
        totbruto += (subtotal);
		
		tothpp += subhpp;
		
		totppn += ((rpppn*100)/100);
		
		totnettqty += harganetto * jmlterima;
		
		totppnterima += ( ((rpppn*100)/100) * jmlterima);
		totpphterima += (( ((rppph*100)/100) * jmlterima));
		totdisterima += ((jmldis * jmlterima));
                      
                
		$(this).find('input[name$="[subtotal]"]').val(formatThousandDecimal(((subtotal))));
        $(this).find('input[name$="[jmldiscount]"]').val(formatThousandDecimal(jmldis));
        $(this).find('input[name$="[persenppn]"]').val(formatThousandDecimal(ppn));
        $(this).find('input[name$="[persenpph]"]').val(formatThousandDecimal(pph));
		$(this).find('input[name$="[jmlppn]"]').val(formatThousandDecimal(rpppn));
    });
	
	totdisfaktur = (totdisterima/totnettqty)*100;
	
	$('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val((totdisfaktur.toFixed(2)));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(formatThousandDecimal(totdisterima));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>').val(Math.round(totnettqty));
	
    $('#total').val(formatThousandDecimal(Math.round(total)));    
	
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'persendiscount'); ?>').val((totdisfaktur.toFixed(2)));
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'jmldiscount'); ?>').val(formatThousandDecimal(totdisterima));
	
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'harganetto'); ?>').val((totnettqty));
    formatNumberSemua();
	hitungTotalTerima('copy');
	hitungTotalFaktur('copy');
	
}

function hitungTotalFaktur(copy){
	// setJmlDiskonFaktur($('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>'));
	
    unformatNumberSemua();
    
	var jmldiskonasli = parseInt($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'jmldiscount'); ?>").val()); 
	
	var totalnetto = parseFloat($("#<?php echo CHtml::activeId($modFakturPembelian, 'totharganetto'); ?>").val()); 
	var jmldiscount = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modFakturPembelian, 'jmldiscount'); ?>").val())); 
	var persendiscount = parseFloat(($("#<?php echo CHtml::activeId($modFakturPembelian, 'persendiscount'); ?>").val())); 
	var persenppn = parseFloat($("#<?php echo CHtml::activeId($modFakturPembelian, 'persenppn'); ?>").val()); 
        var persenpph = parseFloat($("#<?php echo CHtml::activeId($modFakturPembelian, 'persenpph'); ?>").val()); 
	var totalppn = parseFloat($("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakppn'); ?>").val()); 
	var totalpph = parseFloat($("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakpph'); ?>").val()); 
	var totalbruto = parseFloat(unformatNumber($('#total').val())); 
        var diskontot = 0;
	var totalseluruh = 0;
	var ppntot = 0;
        var pphtot = 0;
    
     //console.log("diskon ",formatThousandDecimal(persendiscount));
	
	diskontot = jmldiscount;//(totalnetto*(persendiscount/100));
        totalppn = (persenppn/100) * totalnetto;
	ppntot = Math.round(totalppn);
        
        totalpph = (persenpph/100) * totalnetto;
	pphtot = Math.round(totalpph);
    
    console.log(ppntot);
		
    // console.log("Diskon", diskontot);
    
    totalnetto = totalbruto - ppntot + diskontot;
    
//	var totalseluruh = totalbruto;
	var totalseluruh = totalbruto + ppntot + pphtot ;
	//if (diskontot == 0){
		//$("#<?php //echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(diskontot);
	//}else{
		//$("#<?php //echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(diskontot);
	//}
	$("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakppn') ?>").val(ppntot);
        $("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakpph') ?>").val(pphtot);
	
	$("#<?php echo CHtml::activeId($modFakturPembelian, 'totalhargabruto') ?>").val(Math.round(totalseluruh));
	
	if (typeof copy === 'undefined'){
		$("#<?php echo CHtml::activeId($modPenerimaanBarang, 'harganetto') ?>").val(Math.round(totalnetto));
		$("#<?php echo CHtml::activeId($modPenerimaanBarang, 'persendiscount') ?>").val((persendiscount));
		$("#<?php echo CHtml::activeId($modPenerimaanBarang, 'jmldiscount') ?>").val(Math.round(diskontot));
		$("#<?php echo CHtml::activeId($modPenerimaanBarang, 'persenppn') ?>").val(Math.round(persenppn));
		$("#<?php echo CHtml::activeId($modPenerimaanBarang, 'totalpajakppn') ?>").val(Math.round(ppntot));
		$("#<?php echo CHtml::activeId($modPenerimaanBarang, 'totalpajakpph') ?>").val(totalpph);
		$("#<?php echo CHtml::activeId($modPenerimaanBarang, 'totalharga') ?>").val(Math.round(totalseluruh));
	}
	
    formatNumberSemua();
}

function hitungTotalTerima(copy){
	
    unformatNumberSemua();
    		
	var totalnetto = parseInt($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'harganetto'); ?>").val()); 
	var jmldiscount = parseInt(unformatNumber($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'jmldiscount'); ?>").val())); 
	var persendiscount = parseFloat($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'persendiscount'); ?>").val()); 
	var persenppn = parseFloat($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'persenppn'); ?>").val()); 
	var totalppn = parseInt($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'totalpajakppn'); ?>").val()); 
	var totalpph = parseInt($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'totalpajakpph'); ?>").val()); 
    var totalbruto = parseFloat(unformatNumber($('#total').val())); 
    var diskontot = 0;
	var totalseluruh = 0;
	var ppntot = 0;
    
    // console.log(persendiscount);
	
    diskontot = jmldiscount;//(totalnetto*(persendiscount/100));
	ppntot = Math.round(totppnterima);
		
    // console.log("Diskon", diskontot);


    totalnetto = totalbruto - ppntot + diskontot;

	var totalseluruh = totalbruto;

    console.log("Total Terima : ", totalnetto, diskontot, ppntot, totalseluruh);
	
	console.log("informasi harga terima barang",totalseluruh,);
	
	$("#<?php echo CHtml::activeId($modPenerimaanBarang, 'totalpajakppn') ?>").val(ppntot);
	$("#<?php echo CHtml::activeId($modPenerimaanBarang, 'totalharga') ?>").val(Math.round(totalseluruh));
	
    formatNumberSemua();
	console.log($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'totalpajakppn') ?>").val());
}

/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('.add-on').each(function(){ //element <input>
            var old_name = $(this).attr("id");
            var old_name_arr = old_name.split("_");
            
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]+"_"+old_name_arr[3]);
                
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
        $(this).find('input[name$="[tglkadaluarsa]"]').each(function(){ //element <input>
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
    setJmlDiskonFaktur($("#GFFakturpembelianT_persendiscount"), true);
    
}

function setPersenDisTerima(obj){
	unformatNumberSemua();
    
	var jmldiscount = parseInt(unformatNumber($(obj).val()));
	var satuan = parseInt(unformatNumber($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'harganetto') ?>").val()));
	var persen = 0;
	
	persen = ((jmldiscount/satuan)*100);
	
	$("#<?php echo CHtml::activeId($modPenerimaanBarang, 'persendiscount') ?>").val(persen.toFixed(2));	
	formatNumberSemua();
}

function setJmlDiskonFaktur(obj, update_faktur){
    var persen = parseFloat(unformatNumber($(obj).val()));	
    var satuan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modFakturPembelian, 'totharganetto') ?>").val()));
    
    if (update_faktur == true) {
        $(".persendiscount_terima").each(function() {
            $(this).val($(obj).val());
        });
        $(".persendiscount_terima").each(function() {
            setJmlDiskon(this);
            hitungTotal();
        });
    } else {
        

        var jmldiscount = Math.round(satuan * (persen / 100));

        $("#<?php echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(jmldiscount);
    }
}

function setJmlDiskonTerima(obj){
    var persen = parseFloat(unformatNumber($(obj).val()));	
    var satuan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'harganetto') ?>").val()));
    
	var jmldiscount = Math.round(satuan * (persen / 100));
	
	$("#<?php echo CHtml::activeId($modPenerimaanBarang, 'jmldiscount') ?>").val(jmldiscount);
}

function setPersenPPN(obj){	
    //$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
	var ppnpersen = parseInt($(obj).parents("tr").find('input[name$="[persenppn]"]').val());	
	
	if (ppnpersen > 0){
		ppnpersen = <?php echo Params::DEFAULT_PPN; ?>;
	}
	
	$(obj).parents("tr").find('input[name$="[persenppn]"]').val(ppnpersen);		
}
/**
 * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @returns {set persen ppn -- dalam field yang sama} 
 **/

function setPersenPPNTerima(obj, update_faktur){	
    //$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
	var ppnpersen = parseInt($(obj).val());	
	
	if (ppnpersen > 0){
		ppnpersen = <?php echo Params::DEFAULT_PPN; ?>;
	}
	
    if (update_faktur== true) {
        $(".ppn_terima").each(function() {
            $(this).val(ppnpersen);
        });
        
        $(".ppn_terima").each(function() {
            hitungTotal();
        });
    }
    $(obj).val(ppnpersen);
}

/**
 * @author	Deni Hamdani <denihamdani@piindonesia.co.id>
 * @returns {set persen pph -- dalam field yang sama} 
 **/

function setPersenPPHTerima(obj, update_faktur){	
    //$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
	var pphpersen = parseInt($(obj).val());	
	
    if (update_faktur== true) {
        $(".pph_terima").each(function() {
            $(this).val(pphpersen);
        });
        
        $(".pph_terima").each(function() {
            hitungTotal();
        });
    }
    $(obj).val(pphpersen);
}

/**
 * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @returns {set persen diskon -- dalam field yang sama} 
 **/

function setPersenDiskonTerima(obj){
   	unformatNumberSemua();
    
	var jmldiscount = parseInt(unformatNumber($(obj).val()));
	var satuan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modFakturPembelian, 'totharganetto') ?>").val()));
	var persen = 0;
	
	persen = Math.round((jmldiscount/satuan)*100);
	
	$("#<?php echo CHtml::activeId($modFakturPembelian, 'persendiscount') ?>").val(formatThousandDecimal(persen.toFixed));	
	formatNumberSemua();
}


function setNettoUbah(obj){	   	
	var netto = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[harganettoper]"]').val()));	
	
	console.log("netto ubah",formatThousandDecimal(netto));
    console.log("netto ubah",netto);
	//alert(netto);
	$(obj).parents("tr").find('input[name$="[harganettoubah]"]').val(formatThousandDecimal(netto));			
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

            //console.log(hpp, diskonpersen, ppnpersen, harganetto);

			$(obj).parents("tr").find('input[name$="[harganettoper]"]').val(formatThousandDecimal(harganetto));		

			$(obj).parents("tr").find('input[name$="[subtotal]"]').val(formatThousandDecimal(hpp*jmlterima));		
		}
	}
			
	formatNumberSemua();
}

function setJmlDiskon(obj){
    var persen = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[persendiscount]"]').val()));	
    var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));
    var qty = $(obj).parents("tr").find(".qty").val();
    
    
    //$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(satuan * qty * persen / 100));
	var jmldiskon = ((satuan * (persen / 100)));
	
    console.log("Persen 1", persen, satuan, qty, jmldiskon);
	//alert(jmldiskon);
	
	$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatThousandDecimal(jmldiskon));
}

function setJmlDiskon2(obj){

    var persen = parseFloat(($(obj).parents("tr").find('input[name$="[persendiscount]"]').val()));	
    var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));
    var qty = $(obj).parents("tr").find(".qty").val();
    
    
    //console.log(" Jml Diskon persen,satuan,qty ",persen, satuan, qty);
    
    //$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(satuan * qty * persen / 100));
	var jmldiskon = (satuan * (persen / 100));
	//console.log(" jml diskonya ",jmldiskon);
	//alert(formatNumber(jmldiskon));
    console.log("Persen 2", persen, satuan, qty, jmldiskon);
	
	$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val((jmldiskon.toFixed(2)));
	$(obj).parents("tr").find('.jmldiscount_raw').val(jmldiskon);
    
    console.log($(obj).parents("tr").find(".jmldiscount_raw"), jmldiskon);
}

function setPersenDiskonFaktur(obj){
    var obj_persen = $('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>');
    obj_persen.val(0);
    if($(obj).is(':checked')){
        obj_persen.attr('readonly',false);
    }else{
        obj_persen.attr('readonly',true);
    }
    setPersenDiskonDetail();
        
}

function setPersenDiskonDetail(){
    var persen = $('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val();
    
    $('#table-obatalkespasien tr').each(function(){
        $(this).find('input[name$="[persendiscount]"]').val(persen);
        $(this).find('input[name$="[jmldiscount]"]').val(0);
    });
    hitungTotal();
}

function pilihSatuan(obj){
    unformatNumberSemua();
    var satuanobat = $(obj).val();
    
    if(satuanobat == '<?php echo PARAMS::SATUANOBAT_KECIL; ?>'){
        $(obj).parents('tr').find('.satuankecil').show();
        $(obj).parents('tr').find('.satuanbesar').hide();
        $(obj).parents('tr').find('.netto').val($(obj).parents('tr').find('.netto').val() / $(obj).parents('tr').find('.kemasanbesar').val());
    }else{
        $(obj).parents('tr').find('.satuanbesar').show();
        $(obj).parents('tr').find('.satuankecil').hide();
        $(obj).parents('tr').find('.netto').val($(obj).parents('tr').find('.netto').val() * $(obj).parents('tr').find('.kemasanbesar').val());
    }
    formatNumberSemua();
    hitungTotal();
}

function persenPpn(obj){
    if(obj.checked==true){
        var ppn = '<?php echo Yii::app()->user->getState('persenppn'); ?>';
//        $('#<?php //echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(ppn);
        $('#ppn').val(ppn);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",false);
    }else{
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(0);
        $('#ppn').val(ppn);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",true);
    }
    hitungTotal();
}

function persenPph(obj){
    if(obj.checked==true){
        var pph = '<?php echo Yii::app()->user->getState('persenpph'); ?>';
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(pph);
        $('#pph').val(pph);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",false);
    }else{
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(0);
        $('#pph').val(pph);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",true);
    }
    hitungTotal();
}

function batalObat(obj){
    myConfirm('Apakah anda akan membatalkan penerimaan barang obat ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach(); 
        }
    }); 
    hitungTotal();
}

function persenUangMuka(obj){
    if(obj.checked==true){
        $('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').attr("readonly",false);
		$('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').val(0);
        $('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').val(0);
        $('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').attr("readonly",true);
    }else{
        $('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').attr("readonly",true);
        $('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').val(0);
        $('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').val(0);
        $('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').attr("readonly",false);
    }
}

function setUangMuka(obj){
	unformatNumberSemua();
	
	var persen_uang_muka = parseFloat($(obj).val());
	//var total_harga_bruto = parseFloat($('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val());  
	var total_harga_bruto = parseFloat($('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalharga'); ?>').val());  
	var total_uang_muka = 0;
	if(persen_uang_muka > 100){
		myAlert('Total persen uang muka tidak boleh lebih dari 100');
		$(obj).val(0);
		$('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').val(0);
		return false;
	}
	
	//alert(persen_uang_muka);
	
	if(persen_uang_muka > 0){
		total_uang_muka = Math.round(total_harga_bruto * (persen_uang_muka / 100));
	}else{
		total_uang_muka = 0;
	}
	
	//alert()
		
	$('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').val((total_uang_muka));      
	formatNumberSemua();
}


function setPersenUangMuka(obj){
	unformatNumberSemua();
	
	var uang_muka = parseFloat($(obj).val());
	//var total_harga_bruto = parseFloat($('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val());  
	var total_harga_bruto = parseFloat($('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalharga'); ?>').val());  
	var total_persen_uang_muka = 0;
	
	if(uang_muka > 0){
		total_persen_uang_muka = (uang_muka / total_harga_bruto) * 100;
		//alert(total_harga_bruto);
	}
	
	
	
	$('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').val(roundToTwo(total_persen_uang_muka));      
	formatNumberSemua();
}
/**
* untuk print rencana kebutuhan
 */
function print(caraPrint)
{
    var penerimaanbarang_id = $('#penerimaanbarang_id').val();
    window.open('<?php echo $this->createUrl('print'); ?>&penerimaanbarang_id='+penerimaanbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}


function validasi(obj) {
	if ($("#table-obatalkespasien tbody tr").length == 0) {
		myAlert("Harus ada Obat / Alat Kesehatan yang ditambahkan.");
		return false;
	}
    
    var oa_det = "";
    var beda_netto = false;
    
    if (!requiredCheck(obj)) return false;
    
    $("#table-obatalkespasien tbody tr").each(function() {
        var harganetto = unformatNumber(parseFloat($(this).find(".harganetto").val()));
        var hargabeli = unformatNumber(parseFloat($(this).find(".netto").val()));
        var obatalkes_nama = $(this).find(".obatalkes_nama").val();
        console.log(hargabeli);
        
        if (harganetto != hargabeli) {
            beda_netto = true;
            oa_det += obatalkes_nama + " : " + formatThousandDecimal(harganetto) + " -> " + formatThousandDecimal(hargabeli) + "<br/>";
        }
    });
    
    if (beda_netto) {
        myConfirm("Harga Beli obat berbeda dengan yang ada di Master Obat: <br/>" + oa_det + "Anda yakin untuk melanjutkan ?", "Peringatan", function(r) {
            if (r) {
                 $(".integer2, .float2, .integer-decimal").each(function(){
                    $(this).val(unformatNumber($(this).val()));
                });
                $("#penerimaanbarang-form").submit();
                $("#btn_submit").prop('disabled', true);
            }
        });
    }else{
         $(".integer2, .float2, .integer-decimal").each(function(){
                $(this).val(unformatNumber($(this).val()));
            });
        $("#penerimaanbarang-form").submit();
        $("#btn_submit").prop('disabled', true);
    }            
    return false;
}

function checkVerifikasi(){
   $(".integer2, .float2, .integer-decimal").each(function(){
       $(this).val(unformatNumber($(this).val()));
   });
$("#penerimaanbarang-form").submit();
return false;
}

/**
 * - digunakan untuk berpindah dialog box sesuai checkbox berdasarkan master oa
 * @param {type} obj
 * @returns {change dialog box show}
 */
function setValue(obj){								
	if($(obj).is(":checked")){
		//alert('chek');
		$("#obatalkes_nama").parent().find("a").removeAttr("onclick");
		$("#obatalkes_nama").parent().find("a").attr("onclick",'$("#dialogObatAlkes").dialog("open");return false;');
	}else{
		//alert('unchek');
		$("#obatalkes_nama").parent().find("a").removeAttr("onclick");
		$("#obatalkes_nama").parent().find("a").attr("onclick",'$("#dialogObatAlkesSupplier").dialog("open");return false;');
	}
}

function refreshDialogOA(){        
	$("#obatalkes_nama").addClass("animation-loading-1");
	var su = $("#<?php echo CHtml::activeId($modPenerimaanBarang, 'supplier_id') ?> option:selected").text();
	if (su == "-- Pilih --"){
		su = "(Supplier Belum Dipilih)";
	}
	setTimeout(function(){
                $("#suppliernama").html(su);
				$("#obatalkes_nama").removeClass("animation-loading-1");
				var supplier_id = $('#<?php echo CHtml::activeId($modPenerimaanBarang,"supplier_id") ?>').val();        
				
				$(".dialog_supplier_id").val(supplier_id);        
				$.fn.yiiGridView.update('obatalkessupplier-m-grid', {
					data: {
						"GFObatSupplierM[supplier_id]":supplier_id,			
					}
				});
	},500);
}

function cekTipeSatuan(obj){
	var tipesatuan = $(obj).val();
	
	if (tipesatuan == '<?php echo Params::SATUANOBAT_KECIL ?>'){
		$("#ceksatuankecil").attr("style","display:block;");
		$("#ceksatuanbesar").attr("style","display:none;");
	}else if (tipesatuan == '<?php echo Params::SATUANOBAT_BESAR ?>'){
		$("#ceksatuankecil").attr("style","display:none;");
		$("#ceksatuanbesar").attr("style","display:block;");
	}
}


function callverifikasi(){
	$(".verifikasi-action").removeClass("animation-loading");
	$('#dialog-verifikasi').dialog("open");
        $(".integer2, .float2, .integer-decimal").each(function(){
        $(this).val(unformatNumber($(this).val()));
    });
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('verifikasi'); ?>',
	   data: $("form").serialize(),
	   dataType: "json",
	   success:function(data){
			if (data.ok == 1){							
				$('#dialog-verifikasi > .dialog-content').html(data.content);	
                formatNumberSemua();			
			}else{
				$('#dialog-verifikasi > .dialog-content').html('');
				$('#dialog-verifikasi').dialog("close");
				alert(data.msg);
				formatNumberSemua();
			}
	   },
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); formatNumberSemua();}
	});
	//untuk verifikasi hilangkan srbac loading
	$(".verifikasi-action").removeClass("animation-loading");
	
}

function setVerifikasi(obj){    
    
	if ($("#table-obatalkespasien tbody tr").length == 0) {
		myAlert("Harus ada Obat / Alat Kesehatan yang ditambahkan.");
		return false;
	}
    
    var oa_det = "";
    var beda_netto = false;
	var cekValidasi = true;	
    var cekpph = 0;
    var pesanharga = "";
    var kecilHpp = 0;
    var index = 0;
    
    if (!requiredCheck(obj)) return false;
    
    $("#table-obatalkespasien tbody tr").each(function() {
        unformatNumberSemua();
        var harganetto = parseFloat($(this).find(".harganetto").val());
        var hargabeli = parseFloat($(this).find(".netto").val());
        var obatalkes_nama = $(this).find(".obatalkes_nama").val();
        var persenpph =  parseFloat($(this).find('input[name$="[persenpph]"]').val());
        
        if(harganetto != hargabeli){
            kecilHpp += 1;
            if(index>0){
                pesanharga +=","; 
            }
            pesanharga += obatalkes_nama + " : " + formatThousandDecimal(harganetto) + " -> " + formatThousandDecimal(hargabeli) + "<br/>";
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
    <?php if(Yii::app()->user->getState('ispenerimaanlangsung') == true){ ?>
    if(cekpph > 0){
        if($('#<?php echo CHtml::activeId($modPenerimaanBarang,'pajak_id'); ?>').val() === ''){
            myAlert("Jenis PPh harus diisi! ");
            return false;
        }
    }
    <?php } ?>
    <?php if(Yii::app()->user->getState('isfakturdigudang') == true){ ?>
    if(kecilHpp > 0){
        myConfirm("Harga Netto '"+pesanharga+"' berbeda dengan yang ada di master. Apakah Anda ingin melakukan update harga otomatis?","Perhatian!",function(r) {
        if (r){
            $('#table-obatalkespasien tbody tr').each(function () {
                $(this).find('input[name$="[hppcheck]"]').val(1);
            });
            callverifikasi();
        }else{
            $('#table-obatalkespasien tbody tr').each(function () {
                $(this).find('input[name$="[hppcheck]"]').val(0);
            });
            callverifikasi();
        }
    });
    }else{
        $('#table-obatalkespasien tbody tr').each(function () {
            $(this).find('input[name$="[hppcheck]"]').val(1);
        });
        callverifikasi();
    }        
    <?php }else{ ?>
         callverifikasi();
    <?php } ?> 	            
    
    return false;
}


/**
* tombol batal pada dialogbox
* @param {type} dialog_id
* @returns {undefined} 
*/
function batalDialog(dialog_id){
   if(confirm("Apakah anda yakin akan membatalkan ini ?")) 
       $('#'+dialog_id).dialog("close");
   
   //formatNumberSemua();
}


function formatThousandDecimalSemua() {
    $(".integerfloat").each(function() {
        $(this).val(formatThousandDecimal($(this).val()));
    });
}


function loadJatuhTempo()
{
    var tanggalfaktur = $('#<?php echo CHtml::activeId($modFakturPembelian, 'tglfaktur'); ?>').val();
    var supplierid = $('#<?php echo CHtml::activeId($modPenerimaanBarang, 'supplier_id'); ?>').val();
    if(tanggalfaktur != '' && supplierid != ''){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/gudangFarmasi/FakturPembelian/loadJatuhTempo'); ?>',
            data: {tgl_faktur: tanggalfaktur,supplier_id:supplierid},
            dataType: "json",
            success:function(data){
                $('#<?php echo CHtml::activeId($modFakturPembelian, 'tgljatuhtempo'); ?>').val(data.value);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
	$("#form-fakturpembelian .accordion-heading a").click(function()
	{
        //setTimeout(function() {
            console.log($(this));
            if ($(this).find("button").hasClass("btn-primary")) {
                $("#GFPenerimaanBarangT_is_langsungfaktur").val(1);
            } else {
                $("#GFPenerimaanBarangT_is_langsungfaktur").val(0);
            }
        //}, 100);
        
			// return false;
	});
    
    
    var satuanobat = $('#GFRencDetailkebT_satuanobat').val();
    $('#satuankecil').hide();
    $('#satuanbesar').hide();
    
    if(satuanobat == 'SATUANKECIL'){
        $('#satuankecil').show();
        $('#satuanbesar').hide();
    }else{
        $('#satuanbesar').show();
        $('#satuankecil').hide();
    }
    
    
    $("#table-obatalkespasien").find(".satuanobat").change();
    
    var penerimaanbarang_id = '<?php echo $modPenerimaanBarang->penerimaanbarang_id; ?>';
    var permintaanpembelian_id = '<?php echo isset($modPermintaanPembelian->permintaanpembelian_id) ? $modPermintaanPembelian->permintaanpembelian_id : null; ?>';
    if(penerimaanbarang_id != ""){
        $("#table-obatalkespasien :input").attr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();
        
        $("#penerimaanbarang-form :input").attr("readonly",true);
        $("#penerimaanbarang-form .dtPicker3").attr("readonly",true);
        $("#penerimaanbarang-form .add-on").remove();
        
        $("input, select, textarea").attr("disabled",true);
        
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }
    
    if(permintaanpembelian_id != ""){
        renameInputRowObatAlkes($("#table-obatalkespasien"));   
        
        hitungTotal();
    }

    // Notifikasi supplier 1
    <?php 
        if(isset($_GET['smscp1'])){
            if($_GET['smscp1']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS SUPPLIER', isinotifikasi:'<?php echo $modPenerimaanBarang->supplier->supplier_nama; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
    // Notifikasi supplier 2
    <?php 
        if(isset($_GET['smscp2'])){
            if($_GET['smscp2']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS SUPPLIER 2', isinotifikasi:'<?php echo $modPenerimaanBarang->supplier->supplier_nama; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($modPenerimaanBarang->penerimaanbarang_id)){
    ?>
        var params = [];
       // params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI ?>, judulnotifikasi:'Penerimaan Supplier', isinotifikasi:'Telah dilakukan penerimaan obat alkes dengan <?php echo $modPenerimaanBarang->nosuratjalan ?> pada <?php echo $modPenerimaanBarang->tglterima ?>'}; // 16 
	    params = {instalasi_id:<?php echo Params::INSTALASI_ID_FARMASI; ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI ?>, judulnotifikasi:'Penerimaan Supplier', isinotifikasi:'Penerimaan Obat & Alkes dari <?php echo $modPenerimaanBarang->supplier->supplier_nama ?>'}; // 16 
        insert_notifikasi(params);

        var params = [];
        //params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_AKUNTANSI ?>, judulnotifikasi:'Penerimaan Supplier', isinotifikasi:'Telah dilakukan penerimaan obat alkes dengan <?php echo $modPenerimaanBarang->nosuratjalan ?> pada <?php echo $modPenerimaanBarang->tglterima ?>'}; // 16 
		params = {instalasi_id:<?php echo Params::INSTALASI_ID_KEUANGAN; ?>, modul_id:<?php echo Params::MODUL_ID_AKUNTANSI ?>, judulnotifikasi:'Penerimaan Supplier', isinotifikasi:'Penerimaan Obat & Alkes dari <?php echo $modPenerimaanBarang->supplier->supplier_nama ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
			
	$(".alphanumber").keyup(function()
	{
		$(this).val($(this).val().replace(/[^\w\s]/gi, ''));
	});
    
});
</script>