<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
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
    }
    
//    $("input, select, textarea").attr("disabled",false);
//    $("#form-fakturpembelian :input").attr("readonly",false);
    
//    $("#<?php // echo CHtml::activeId($modPenerimaanBarang,'keteranganfaktur'); ?>").attr("readonly",false);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>").attr("readonly",true);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>").attr("readonly",true);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>").attr("readonly",true);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>").attr("readonly",true);
//    $("#<?php // echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>").attr("readonly",true);
//    $("#<?php // echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>").attr("readonly",true);
    
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
	
	
    $('#table-obatalkespasien tbody tr').each(function(){
		
        var jmlterima  = parseInt($(this).find('input[name$="[jmlterima]"]').val());
        var harganetto  = parseInt($(this).find('input[name$="[harganettoper]"]').val());
        var persendis  = parseFloat($(this).find('input[name$="[persendiscount]"]').val());
        var jmldis  = parseInt($(this).find('input[name$="[jmldiscount]"]').val());
		var persen_ppn  = parseInt($(this).find('input[name$="[persenppn]"]').val());
		var hpp  = parseInt($(this).find('input[name$="[hargasatuanper]"]').val());
        		
		//alert(persen_ppn);
        //subtotal = harganetto * jmlterima;
        //totnetto += subtotal;
        
        //if(subtotal <= 0){
            subtotal = 0;
        //}
        
        var ppn = 0;
        var rpppn = 0;
        var pph = 0;
        var rppph = 0;
		
		//if(persendis > 0){
          //  jmldis = harganetto * (persendis/100);
            totdisc += jmldis;
            //$(this).find('input[name$="[jmldiscount]"]').val(jmldis);
            //subtotal = subtotal - (subtotal * (persendis/100));
        //}else{
          //  totdisc += jmldis;
            //$(this).find('input[name$="[persendiscount]"]').val(formatFloat((jmldis/subtotal) * 100));
            //subtotal = subtotal - jmldis;
        //} 
        
		
		
        /*
        if ($('#diskonSemua').is(":checked")) {
            persendis = $('#<?php //echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val();
            $('#<?php //echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val(persendis);
            $(this).find('input[name$="[persendiscount]"]').val(persendis);
        } else {
            persendis = jmldis = 0;
            $('#<?php //echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val(0);
            $('#<?php //echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(0);
        }
        */
		   
		
        
       // if($('#termasukPPN').is(':checked')){
            ppn = persen_ppn;
            rpppn = (harganetto - jmldis) * (ppn/100);          
       // }
        //persenppn += (rpppn * jmlterima);
        
        //if($('#termasukPPH').is(':checked')){
          //  pph = '<?php //echo Yii::app()->user->getState('persenpph'); ?>';
           // rppph = harganetto * (pph/100);            
        //}
        
        subhpp = ( (harganetto - jmldis) + rppph + rpppn);
        
		subtotal = Math.round(subhpp) * jmlterima;
		
        persenpph += (rppph * jmlterima);
        
        /*if(persendis > 0){
            jmldis = subtotal * (persendis/100);
            totdisc += jmldis;
            $(this).find('input[name$="[jmldiscount]"]').val(jmldis);
            subtotal = subtotal - (subtotal * (persendis/100));
        }else{
            totdisc += jmldis;
            $(this).find('input[name$="[persendiscount]"]').val(formatFloat((jmldis/subtotal) * 100));
            subtotal = subtotal - jmldis;
        } */   
		
		//subhpp = (harganetto + rppph + rpppn) * jmlterima;
        
        total += subtotal;
        
        
        totbruto += subtotal;
		
		tothpp += subhpp;
		
		totppn += rpppn;
		
		totnettqty += harganetto * jmlterima;
		//alert(Math.round(rpppn));
		totppnterima += (Math.round(rpppn) * jmlterima);
		totpphterima += (Math.round(rppph) * jmlterima);
		totdisterima += (Math.round(jmldis) * jmlterima);
				
        
        $(this).find('input[name$="[subtotal]"]').val(Math.round(subtotal));
        $(this).find('input[name$="[jmldiscount]"]').val(Math.round(jmldis));
        $(this).find('input[name$="[persenppn]"]').val(Math.round(ppn));
        $(this).find('input[name$="[persenpph]"]').val(Math.round(pph));
		$(this).find('input[name$="[hargasatuanper]"]').val(Math.round(subhpp));
		$(this).find('input[name$="[jmlppn]"]').val(Math.round(rpppn));
    });
    $('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(Math.round(totdisc));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>').val(Math.round(totnettqty));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(Math.round(totppnterima));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(Math.round(totpphterima));
	$('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(Math.round(totdisterima));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val(Math.round(totbruto));
    $('#total').val(Math.round(total));    
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalharga'); ?>').val(Math.round(total));
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalpajakpph'); ?>').val(Math.round(totpphterima));
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalpajakppn'); ?>').val(Math.round(totppnterima));
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'jmldiscount'); ?>').val(Math.round(totdisterima));
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'harganetto'); ?>').val(Math.round(totnettqty));
    formatNumberSemua();
	
	hitungTotalFaktur();
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
	
    $('#table-obatalkespasien tbody tr').each(function(){
		
        var jmlterima  = parseInt($(this).find('input[name$="[jmlterima]"]').val());
        var harganetto  = parseInt($(this).find('input[name$="[harganettoper]"]').val());
        var persendis  = parseFloat($(this).find('input[name$="[persendiscount]"]').val());
        var jmldis  = parseInt($(this).find('input[name$="[jmldiscount]"]').val());
		var persen_ppn  = parseInt($(this).find('input[name$="[persenppn]"]').val());
		var hpp  = parseInt($(this).find('input[name$="[hargasatuanper]"]').val());
        		
	
        
        var ppn = 0;
        var rpppn = 0;
        var pph = 0;
        var rppph = 0;
		
		//if(persendis > 0){
            //jmldis = harganetto * (persendis/100);
            totdisc += jmldis;
          //  $(this).find('input[name$="[jmldiscount]"]').val(Math.round(jmldis));
        //} 
        
		
	
		ppn = persen_ppn;
		rpppn = (harganetto - jmldis) * (ppn/100);          
    
        
        subhpp = hpp;
        
		subtotal = Math.round(subhpp) * jmlterima;
		
        persenpph += (rppph * jmlterima);
                       
        total += subtotal;
        
        
        totbruto += subtotal;
		
		tothpp += subhpp;
		
		totppn += rpppn;
		
		totnettqty += harganetto * jmlterima;
		
		totppnterima += (Math.round(rpppn) * jmlterima);
		totpphterima += (Math.round(rppph) * jmlterima);
		totdisterima += (Math.round(jmldis) * jmlterima);
                
		$(this).find('input[name$="[jmlppn]"]').val(Math.round(rpppn));
    });
    $('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(Math.round(totdisc));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>').val(Math.round(totnettqty));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(Math.round(totppnterima));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(Math.round(totpphterima));
	$('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(Math.round(totdisterima));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val(Math.round(totbruto));
    $('#total').val(Math.round(total));    
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalharga'); ?>').val(Math.round(total));
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalpajakpph'); ?>').val(Math.round(totpphterima));
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalpajakppn'); ?>').val(Math.round(totppnterima));
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'jmldiscount'); ?>').val(Math.round(totdisterima));
	$('#<?php echo CHtml::activeId($modPenerimaanBarang,'harganetto'); ?>').val(Math.round(totnettqty));
    formatNumberSemua();
	
	hitungTotalFaktur();
}

function hitungTotalFaktur(){
    unformatNumberSemua();
    
	var jmldiskonasli = parseInt($("#<?php echo CHtml::activeId($modPenerimaanBarang, 'jmldiscount'); ?>").val()); 
	
	var totalnetto = parseInt($("#<?php echo CHtml::activeId($modFakturPembelian, 'totharganetto'); ?>").val()); 
	var jmldiscount = parseInt($("#<?php echo CHtml::activeId($modFakturPembelian, 'jmldiscount'); ?>").val()); 
	var persendiscount = parseFloat($("#<?php echo CHtml::activeId($modFakturPembelian, 'persendiscount'); ?>").val()); 
	var totalppn = parseInt($("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakppn'); ?>").val()); 
	var totalpph = parseInt($("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakpph'); ?>").val()); 
    var diskontot = 0;
	var totalseluruh = 0;
	
	diskontot = totalnetto*(persendiscount/100);
	
	var totalseluruh = totalnetto - (jmldiskonasli+diskontot) + totalppn - totalpph;
	
	if (diskontot == 0){
		$("#<?php echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(jmldiskonasli+diskontot);
	}else{
		$("#<?php echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(jmldiskonasli+diskontot);
	}
	$("#<?php echo CHtml::activeId($modFakturPembelian, 'totalhargabruto') ?>").val(totalseluruh);
	
    formatNumberSemua();
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
	
	var jmldiscount = parseInt(unformatNumber($(obj).parents("tr").find('input[name$="[jmldiscount]"]').val()));
	var satuan = parseInt(unformatNumber($(obj).parents("tr").find('.netto').val()));
	var persen = 0;
	
	persen = (jmldiscount/satuan)*100;
	
	$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(persen);		
}

function setPersenDisFaktur(obj){
	/*unformatNumberSemua();
    
	var jmldiscount = parseInt(unformatNumber($(obj).val()));
	var satuan = parseInt(unformatNumber($("#<?php echo CHtml::activeId($modFakturPembelian, 'totharganetto') ?>").val()));
	var persen = 0;
	
	persen = Math.round((jmldiscount/satuan)*100,2);
	
	$("#<?php echo CHtml::activeId($modFakturPembelian, 'persendiscount') ?>").val(persen.toFixed(2));	
	formatNumberSemua();*/
}

function setJmlDiskonFaktur(obj){
   // var persen = parseFloat(unformatNumber($(obj).val()));	
   // var satuan = parseFloat(unformatNumber($("#<?php //echo CHtml::activeId($modFakturPembelian, 'totharganetto') ?>").val()));
    
	
	
//	$("#<?php//echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(formatNumber(satuan * (persen / 100)));
}

function setPersenPPN(obj){	
    //$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
	var ppnpersen = parseInt($(obj).parents("tr").find('input[name$="[persenppn]"]').val());	
	
	if (ppnpersen > 0){
		ppnpersen = <?php echo Params::DEFAULT_PPN; ?>;
	}
	
	$(obj).parents("tr").find('input[name$="[persenppn]"]').val(ppnpersen);		
}

function setPersenPPH(obj){	
    //$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
	var pphpersen = parseInt($(obj).parents("tr").find('input[name$="[persenpph]"]').val());
	
	$(obj).parents("tr").find('input[name$="[persenpph]"]').val(pphpersen);		
}

function setHPP(obj){	
    //$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
	unformatNumberSemua();
	var hpp = parseInt($(obj).parents("tr").find('input[name$="[hargasatuanper]"]').val());	
	var ppnpersen = parseInt($(obj).parents("tr").find('input[name$="[persenppn]"]').val());
	var diskonpersen = parseFloat($(obj).parents("tr").find('input[name$="[persendiscount]"]').val());
	var jmlterima = parseInt($(obj).parents("tr").find('input[name$="[jmlterima]"]').val());
	
	var harganetto = 0;	
	
	harganetto = hpp / (((100 - diskonpersen + ppnpersen)/100)  - ((ppnpersen*diskonpersen)/10000));	
		
	$(obj).parents("tr").find('input[name$="[harganettoper]"]').val(Math.round(harganetto));		
	
	$(obj).parents("tr").find('input[name$="[subtotal]"]').val(hpp*jmlterima);		
	
	formatNumberSemua();
}

function setJmlDiskon(obj){
    var persen = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[persendiscount]"]').val()));	
    var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));
    var qty = $(obj).parents("tr").find(".qty").val();
    
    console.log(persen, satuan, qty);
    
    //$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(satuan * qty * persen / 100));
	$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(satuan * (persen / 100)));
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
/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
	
//	$('.float2').each(function(){
  //      $(this).val(parseFloat(unformatNumber($(this).val())));
    //});
}
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
	
	//$('.float2').each(function(){
      //  $(this).val(formatFloat($(this).val()));
    //});
}

function pilihSatuan(obj){
    unformatNumberSemua();
    var satuanobat = $(obj).val();
    
    if(satuanobat == '<?php echo PARAMS::SATUAN_KECIL; ?>'){
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
	var total_harga_bruto = parseFloat($('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val());  
	var total_uang_muka = 0;
	if(persen_uang_muka > 100){
		myAlert('Total persen uang muka tidak boleh lebih dari 100');
		$(obj).val(0);
		return false;
	}
	
	if(persen_uang_muka > 0){
		total_uang_muka = total_harga_bruto * (persen_uang_muka / 100);
	}else{
		total_uang_muka = 0;
	}
		
	$('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').val(total_uang_muka);      
	formatNumberSemua();
}
function setPersenUangMuka(obj){
	unformatNumberSemua();
	
	var uang_muka = parseFloat($(obj).val());
	var total_harga_bruto = parseFloat($('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val());  
	var total_persen_uang_muka = 0;
	
	if(uang_muka > 0){
		total_persen_uang_muka = Math.round((uang_muka * 100) / (total_harga_bruto));
	}
	
	$('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').val(total_persen_uang_muka);      
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
        var harganetto = parseFloat($(this).find(".harganetto").val());
        var hargabeli = parseFloat(unformatNumber($(this).find(".netto").val()));
        var obatalkes_nama = $(this).find(".obatalkes_nama").val();
        
        
        if (harganetto != hargabeli) {
            beda_netto = true;
            oa_det += obatalkes_nama + " : " + formatNumber(harganetto) + " -> " + formatNumber(hargabeli) + "<br/>";
        }
        //console.log("Komparasi Netto", harganetto, hargabeli);
    });
    
    if (beda_netto) {
        myConfirm("Harga Beli obat berbeda dengan yang ada di Master Obat: <br/>" + oa_det + "Anda yakin untuk melanjutkan ?", "Peringatan", function(r) {
            if (r) {
                $("#penerimaanbarang-form").submit();
                $("#btn_submit").prop('disabled', true);
            }
        });
    }else{
        $("#penerimaanbarang-form").submit();
        $("#btn_submit").prop('disabled', true);
    }            
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
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('verifikasi'); ?>',
	   data: $("form").serialize(),
	   dataType: "json",
	   success:function(data){
			if (data.ok == 1){							
				$('#dialog-verifikasi > .dialog-content').html(data.content);
			}else{
				$('#dialog-verifikasi > .dialog-content').html('');
				$('#dialog-verifikasi').dialog("close");
				alert(data.msg);
				formatNumberSemua();
			}
	   },
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
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
    
    if (!requiredCheck(obj)) return false;
    
    $("#table-obatalkespasien tbody tr").each(function() {
        var harganetto = parseFloat($(this).find(".harganetto").val());
        var hargabeli = parseFloat(unformatNumber($(this).find(".netto").val()));
        var obatalkes_nama = $(this).find(".obatalkes_nama").val();
        
        
        if (harganetto != hargabeli) {
            beda_netto = true;
            oa_det += obatalkes_nama + " : " + formatNumber(harganetto) + " -> " + formatNumber(hargabeli) + "<br/>";
        }
        //console.log("Komparasi Netto", harganetto, hargabeli);
    });
    
    if (beda_netto) {
        myConfirm("Harga Beli obat berbeda dengan yang ada di Master Obat: <br/>" + oa_det + "Anda yakin untuk melanjutkan ?", "Peringatan", function(r) {
            if (r) {
				callverifikasi();
                //$("#penerimaanbarang-form").submit();
                //$("#btn_submit").prop('disabled', true);				
            }else{
				
			}
        });
    }else{
		callverifikasi();
        //$("#penerimaanbarang-form").submit();
        //$("#btn_submit").prop('disabled', true);
    }                	            
    
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
   
   formatNumberSemua();
}


/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    
    
    
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