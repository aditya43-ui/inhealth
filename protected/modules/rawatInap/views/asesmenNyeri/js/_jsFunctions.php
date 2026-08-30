<?php
/**
* - digunakan untuk menampung semua script javascript, agar mudah di tracing
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
*/

?>
<script type="text/javascript">
/**
 * - digunalam umtuk menandakan status umur
 * @param {type} umur
 * @param {type} st
 * @returns {undefined}
 */
function cekUmur(umur, st){	
    /*
	var yes = $("#nyeriYes").prop("checked");
	
	if (yes){
		if (typeof st  === "undefined"){
			if (umur == '<?php //echo Params::SKALA_NYERI_BERDASARKAN_UMUR_1; ?>'){
				st = 'lebih';
			}else if (umur == '<?php //echo Params::SKALA_NYERI_BERDASARKAN_UMUR_2; ?>'){
				st = 'kurang';
			}
		}				
		
		var no = $("#<?php //echo CHtml::activeId($modFisik, 'skala_wongbaker_nrs') ?>").val();
		
	
		if (st == 'lebih'){
			$(".umurlebih").addClass('borderradius');
			$(".umurkurang").removeClass('borderradius');
			$("#<?php //echo CHtml::activeId($modFisik, 'skalanyeri_statusumur') ?>").val('<?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_1; ?>');
			getNomor(no);			
		}else if (st == 'kurang'){
			$(".umurkurang").addClass('borderradius');
			$(".umurlebih").removeClass('borderradius');		
			$("#<?php //echo CHtml::activeId($modFisik, 'skalanyeri_statusumur') ?>").val('<?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_2; ?>');			
			getNyeriFlaccs(no);
		}
	}
        */ 
}
    
function resetNyeri(obj){
	if ($(obj).prop('checked') == true){
		
	}
}

function resetSkala(obj){
	//var umur = $("#<?php //echo CHtml::activeId($modFisik, 'skalanyeri_statusumur') ?>").val();
	
	//cekUmur(umur);
}

function disablePanel(obj){
    $(obj).focus();
    return false;
}

function adaNyeri(pilih_nyeri){
    var count = 0;
    
    var nyeriYes = $("#nyeriYes").prop("checked");    
        
    if (nyeriYes){
        var val = $("#nyeriYes").attr('value');
    }else{
        val = 0;
    }
    
    
    if (typeof pilih_nyeri != 'undefined'){
        $("#nyeri_dewasa, #nyeri_anak").find("input:text, select, textarea, .field").each(function(){
            if($(this).is(":checked")){

            }else{
                if ($(this).val() != ''){            
                    //alert($(this).attr('id'));
                    count++;
                }
            }
         });
     }else{
         $("#nyeri_dewasa, #nyeri_anak, #periksa_nyeri").find("input:text, select, textarea, .field").each(function(){
            if($(this).is(":checked")){

            }else{
                if ($(this).val() != ''){            
                    //alert($(this).attr('id'));
                    count++;
                }
            }
         });
     }
    
    
    if (val == 0){
        
        var tr = $("#table-bagtubuh > tbody > tr").length;
        
        if (tr > 0){
            alert("Silakan hapus terlebih dahulu, data pada lokasi nyari");
            $("#nyeriYes").prop("checked",true);
            return false;
        }
        
        $("#nyeri_dewasa").attr("style","cursor:not-allowed");
        $("#disableDewasa").addClass("disable-panel");
        
        $("#nyeri_anak").attr("style","cursor:not-allowed");
        $("#disableAnak").addClass("disable-panel");
        
        $("#lokasi_nyeri").attr("style","cursor:not-allowed");
        $("#disableLokasiNyeri").addClass("disable-panel");
        
        $("#periksa_nyeri").attr("style","cursor:not-allowed");
        $("#disablePeriksaNyeri").addClass("disable-panel");
        
        $("#nyeri_dewasa, #nyeri_anak, #lokasi_nyeri, #periksa_nyeri").find("input, select, textarea").not(".pilih_nyeri").each(function(){
           $(this).attr("disabled","disabled");           
           $(this).val("");            
        });
                
        
        $("#nyeriAnak, #nyeriDewasa").prop("checked",false);
        resetFormFlasCCs();
        
        $("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").removeClass('required');
        $("#<?php echo CHtml::activeId($model, 'scoreanak') ?>").removeClass('required');
        
        
    }else if (val == 1){
        
        $("#nyeri_dewasa").attr("style","");
        $("#disableDewasa").addClass("disable-panel");
        
        $("#nyeri_anak").attr("style","");
        $("#disableAnak").addClass("disable-panel");
        
        $("#lokasi_nyeri").attr("style","");
        $("#disableLokasiNyeri").removeClass("disable-panel");
        
        $("#periksa_nyeri").attr("style","");
        $("#disablePeriksaNyeri").removeClass("disable-panel");
        
        $("#nyeri_dewasa, #nyeri_anak, #lokasi_nyeri, #periksa_nyeri").find("input, select, textarea").each(function(){
           $(this).removeAttr("disabled");
           //$(this).val('');
        });
        
        $("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").addClass('required');
        $("#<?php echo CHtml::activeId($model, 'scoreanak') ?>").addClass('required');
        
        
        <?php if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_ICU): ?>
        
        $("#nyeriDewasa").prop("checked", true);
        pilihNyeri('dewasa','dewasa');

        <?php endif; ?>
    }
    
    //$("#<?php echo CHtml::activeId($model, 'is_keluhannyeri_dewasa') ?>").val('anak');
    
    pilihNyeri();
    
}

function pilihNyeri(status,load){
    var is_nyeri = $('#status-nyeri input[type="radio"]:checked').val();
    var is_dewasa = $(".pilih_nyeri:checked").val();
    
    $(".panel_nyeri").each(function() {
        var ceklis = $(this).find(".pilih_nyeri").is(":checked");
        
        if (is_nyeri == 1 && ceklis) {
            $(this).find(".panel-body").show().find(".input").prop("disabled", false);
        } else {
            $(this).find(".panel-body").hide().find(".input").prop("disabled", true);
        }
    });
}

function pilihScala(skor){
    var keterangan;
    
    if (skor == 0){
        keterangan = '<?php echo Params::SKALA_NYERI_0; ?>';
    }else if (skor >= 1 && skor <= 2){
        keterangan = '<?php echo Params::SKALA_NYERI_1_2; ?>';
    }else if (skor >= 3 && skor <= 4){
        keterangan = '<?php echo Params::SKALA_NYERI_3_4; ?>';
    }else if (skor >= 5 && skor <= 6){
        keterangan = '<?php echo Params::SKALA_NYERI_5_6; ?>';
    }else if (skor >= 7 && skor <= 8){
        keterangan = '<?php echo Params::SKALA_NYERI_7_8; ?>';
    }else if (skor >= 9 && skor <= 10){
        keterangan = '<?php echo Params::SKALA_NYERI_9_10; ?>';
    }
    //if(skor != 0){
        $("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val(skor);
        $("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").val(keterangan);
    //}
    
    $(".nyeri-nomor").css("border", "none");
    $(".nyeri-nomor").css("border-radius", "5px");
    $("#nyerinomor_" + skor).css("border", "1px solid black");
}

function getSkorFla(id,skor,obj){
    $("#skor_"+id).html(skor);    
    $(obj).parents("tr").find('.params').val(skor);
    $(obj).parents("tr").find('.nilai').val(skor);
    $(obj).parents("tr").find('.kategoriid').val(id);        
    
    totalSkorFla();
}

function totalSkorFla(){
    var total = 0;
    
    $("#master_falsccs > tbody > tr").each(function(){
        $(this).find('.nilai').parents('tr').find('.params-nilai0').attr('style','');
        $(this).find('.nilai').parents('tr').find('.params-nilai1').attr('style','');
        $(this).find('.nilai').parents('tr').find('.params-nilai2').attr('style','');
        //alert($(this).find('.nilai').attr('value'));
        if ($(this).find('.nilai').val() != ''){                         
            $(this).find('.nilai').parents('tr').find('.params-nilai'+$(this).find('.nilai').val()).attr('style','border:4px solid #333 !important;');
            total = total + parseInt($(this).find('.nilai').val());
        }else{            
            total = total + 0;
        }
    });
    
    $("#totalskor").html(total);
    
    if (total == 0){
        var keterangan = 'tidak nyeri';
    }else if(total >= 1 && total <= 3){
        var keterangan = 'nyeri ringan';
    }else if(total >= 4 && total <= 6){
        var keterangan = 'nyeri sedang';
    }else if(total >= 7 && total <= 10){
        var keterangan = 'nyeri berat sekali';
    }
    
    $("#<?php echo CHtml::activeId($model, 'scoreanak') ?>").val(total);
    $("#<?php echo CHtml::activeId($model, 'keterangananak') ?>").val(keterangan);
}

function resetFormFlasCCs(){
    $("#master_falsccs > tbody > tr").each(function(){
        
        $(this).find('.borderflaccs').each(function(){
            $(this).attr('style','');
        });
        
        $(this).find('.field').each(function(){
            $(this).val('');
        });
        
        
        $(this).find('.labelname').each(function(){
            $(this).html('');
        });        
    });
    
    $("#master_falsccs > tfoot > tr").each(function(){       
        $(this).find('.field').each(function(){
            $(this).val('');
        });       
    });
    
    $("#totalskor").html('');    
}

function cekNyeriMenjalar(){
    if ($("#menjalarYes").prop("checked") == true){        
        $("#<?php echo CHtml::activeId($model, 'nyerimenjalarke') ?>").removeAttr('disabled');
    }else if ($("#menjalarNo").prop("checked") == true){
        $("#<?php echo CHtml::activeId($model, 'nyerimenjalarke') ?>").val('');
        $("#<?php echo CHtml::activeId($model, 'nyerimenjalarke') ?>").attr('disabled','disabled');
    }
}


function batalTambahBagianTubuh(obj){
	var conf = confirm("Apakah Anda yakin akan membatalkan pemilihan pemeriksaan ini ?");
	
    //myConfirm("Apakah Anda akan membatalkan pemilihan pemeriksaan ini?","Perhatian!",
   // function(r){
        if(conf){
            var bagiantubuh_id = $(obj).parents('tr').find('input[name$="[bagiantubuh_id]"]').val();
			var gambartubuh_id = $(obj).parents('tr').find('input[name$="[gambartubuh_id]"]').val();
			var kordinat_tubuh_x = $(obj).parents('tr').find('.kordinat_tubuh_x').val();
			var kordinat_tubuh_y = $(obj).parents('tr').find('.kordinat_tubuh_y').val();
			var keterangan_periksa_gbr = $(obj).parents('tr').find('.keterangan_periksa_gbr').val();
			
			kordinat_tubuh_x = kordinat_tubuh_x.replace(/\./g,'_');
			kordinat_tubuh_y = kordinat_tubuh_y.replace(/\./g,'_');
			
            $(obj).parents('tbody').find('input[name$="[bagiantubuh_id]"][value="'+bagiantubuh_id+'"]').each(function(){
				//$(obj).parents('tbody').find('input[name$="[gambartubuh_id]"][value="'+gambartubuh_id+'"]').each(function(){
					//alert($(this).attr('delete'));
					if ($(this).data('delete') == gambartubuh_id+'_'+kordinat_tubuh_x+'_'+kordinat_tubuh_y){							
						$(this).parents('tr').detach();
					}	
				//})
                //$(this).parents('tr').detach();
            });
			$("#imgtag"+gambartubuh_id).find('#titik_'+bagiantubuh_id+'_'+kordinat_tubuh_x+'_'+kordinat_tubuh_y).detach();
			renameInputRow($('#table-bagtubuh'));
        }
   // }); 
}

function hapusBagianTubuh(obj){
	
	var bagiantubuh_id = $(obj).parents('tr').find('.bagiantubuh_id').val();
	var pemeriksaangambarnyeri_id = $(obj).parents('tr').find('.pemeriksaangambarnyeri_id').val();
	var gambartubuh_id = $(obj).parents('tr').find('.gambartubuh_id').val();
	var kordinat_tubuh_x = $(obj).parents('tr').find('.kordinat_tubuh_x').val();
	var kordinat_tubuh_y = $(obj).parents('tr').find('.kordinat_tubuh_y').val();
	var keterangan_periksa_gbr = $(obj).parents('tr').find('.keterangan_periksa_gbr').val();
	var pendaftaran_id = <?php echo !empty($modPendaftaran->pendaftaran_id)?$modPendaftaran->pendaftaran_id:"''"; ?>;
	
	
	var koor_tubuh_x = kordinat_tubuh_x.replace(/\./g,'_');
	var koor_tubuh_y = kordinat_tubuh_y.replace(/\./g,'_');
	
	var conf = confirm("Apakah Anda yakin akan menghapus pemeriksaan ini ?");
	
    //myConfirm("Apakah Anda akan menghapus pemeriksaan ini?","Perhatian!",
    //function(r){
        if(conf){									
			$.ajax({				
				type: "POST", 
				url: "<?php echo $this->createUrl('HapusBagianTubuh')?>", 
				data: "bagiantubuh_id=" + bagiantubuh_id + "&pemeriksaangambarnyeri_id=" + pemeriksaangambarnyeri_id+ "&gambartubuh_id=" + gambartubuh_id+"&kordinat_tubuh_x="+kordinat_tubuh_x+"&kordinat_tubuh_y="+kordinat_tubuh_y+"&keterangan_periksa_gbr="+keterangan_periksa_gbr+"&pendaftaran_id="+pendaftaran_id,
				dataType: "json",
				success: function(data){
					if(data.ok == 0){
						myAlert(data.pesan);
					}else{
						
						
						$(obj).parents('tbody').find('input[name$="[bagiantubuh_id]"][value="'+bagiantubuh_id+'"]').each(function(){							
								if ($(this).data('delete') == gambartubuh_id+'_'+koor_tubuh_x+'_'+koor_tubuh_y){							
									$(this).parents('tr').detach();
								}								
						});
						$("#imgtag"+gambartubuh_id).find('#titikbiru_'+bagiantubuh_id+'_'+koor_tubuh_x+'_'+koor_tubuh_y).detach();
						renameInputRow($('#table-bagtubuh'));
						
						alert(data.pesan);
					}
				  
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
        }
    //}); 
}

function renameInput(obj_table){
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
	
}

function titikSebelumSimpan(ptitikX,ptitikY,bagiantubuh_id, img){
	var titikX = Math.round(ptitikX)-10;
	var titikY = Math.round(ptitikY)-10;
	var color = 'rgba(219, 50, 92, 0.9)';
	var size = '1px';
	
	var xtitik = ptitikX.replace(/\./g,'_');
	var ytitik = ptitikY.replace(/\./g,'_');			
	
	
	$(img).append(
	$('<div id="titik_'+bagiantubuh_id+'_'+xtitik+'_'+ytitik+'"></div>')
			.css('position', 'absolute')
			.css('top', titikY + 'px')
			.css('left', titikX + 'px')
			.css('width', size)
			.css('height', size)
			.css('background-color', color)
			.css('cursor', 'pointer')
			.css('display', 'block')
			.css('padding', '5px')
			.css('-webkit-border-radius', '50%')
			.css('-moz-border-radius', '50%')
			.css('border-radius', '50%')
	);
}

function titikSesudahSimpan(titikX,titikY,urutan,bagiantubuh_id, img){
	var x_titik = titikX.toFixed(7);
	var y_titik = titikY.toFixed(7);	
		
	var titikX=titikX-15;
	var titikY=titikY-15;
	var nomor = urutan+1;
	var color = 'rgba(0, 128, 255, 0.8)';
	var size = '5px';
	
	x_titik = x_titik.replace(/\./g,'_');
	y_titik = y_titik.replace(/\./g,'_');
	
	$(img).append(
		$('<div id="titikbiru_'+bagiantubuh_id+'_'+x_titik+'_'+y_titik+'"><strong style="position:absolute;top:0;left:7px;color:#fff;">'+nomor+'</b></div>')
			.css('position', 'absolute')
			.css('top', titikY + 'px')
			.css('left', titikX + 'px')
			.css('width', size)
			.css('height', size)
			.css('background-color', color)
			.css('cursor', 'pointer')
			.css('display', 'block')
			.css('padding', '10px')
			.css('-webkit-border-radius', '50%')
			.css('-moz-border-radius', '50%')
			.css('border-radius', '50%')
			.css('vertical-align','middle')
	);
}

function loadTitikSesudahSimpan(){
	<?php if(!empty($modPemeriksaanGambar)){
		$j = 1;
		foreach($modPemeriksaanGambar as $i => $v){ ?>
		titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y.','.$i.','.$v->bagiantubuh_id ?>, '#imgtag<?php echo $v->gambartubuh_id; ?>');	
		
	<?php $j++;}
	}?>
}


$(document).ready(function(){
    

                pilihNyeri();
                
                var skor = $("#RIAsesmentnyeriT_score_skalanyeri").val();
                if (skor != "") {
                    $(".nyeri-nomor").css("border-radius", "5px");
                    $("#nyerinomor_" + skor).css("border", "1px solid black");
                }
                
                adaNyeri();

        
        
    /*
    loadTitikSesudahSimpan();
	
	
	var counter = 0;
    var mouseX = 0;
    var mouseY = 0;
   
    $("[id^=imgtag] img").click(function(e) { // make sure the image is click
        var imgtag = $(this).parent(); // get the div to append the tagging list
        var no_img = $(this).attr('img-no');
        var gambartubuh_id = $(this).attr('alt');
        mouseX = ( e.pageX - $(imgtag).offset().left ); // x and y axis
        mouseY = ( e.pageY - $(imgtag).offset().top );
      
        if(mouseX != 0 && mouseY != 0){
            $.ajax({
                type: "POST", 
                url: "<?php echo $this->createUrl('getBagianTubuhId')?>", 
                data: "kordinat_x=" + mouseX + "&kordinat_y=" + mouseY,
                dataType: "json",
                success: function(data){   
                    $( '#titikklik'+no_img ).remove(); // menghapus titik lain selain titik current klik
                    $("#imgtag"+no_img).append(
                    $('<div id="titikklik'+no_img+'"></div>')
                                    .css('position', 'absolute')
                                    .css('top', Math.round(mouseY)-10 + 'px')
                                    .css('left', Math.round(mouseX)-10 + 'px')
                                    .css('width', '5px')
                                    .css('height', '5px')
                                    .css('background-color', 'rgba(219, 50, 92, 0.5)')
                                    .css('cursor', 'pointer')
                                    .css('display', 'block')
                                    .css('padding', '5px')
                                    .css('-webkit-border-radius', '50%')
                                    .css('-moz-border-radius', '50%')
                                    .css('border-radius', '50%')
                    );
                    var html = '<div id="tagit'+no_img+'">\n\
                                    <div class="name"><br>\n\
                                            <div class="text"><b>Data Pemeriksaan</b></div>\n\
                                            <table>\n\
                                                    <tr>\n\
                                                            <td>Bagian Tubuh : </td>\n\
                                                            <td>\n\<input type="hidden" id="gambartubuh_id'+no_img+'" value="'+gambartubuh_id+'">\n\
                                                            ';

                                            if(data.pesan != ""){
                                                    html += '<select id="bagiantubuh_id'+no_img+'" name="bagiantubuh_id" onkeypress="return $(this).focusNextInputField(event);" class="span2">\n\
								<option value="">-- Pilih --</option>\n\
								<?php foreach ($modBagianTubuh->BagianTubuh as $key => $value){ ?>\n\
									<option value="<?php echo $value->bagiantubuh_id; ?>"><?php echo $value->namabagtubuh; ?></option>\n\
								<?php } ?>\n\
                                                            </select>\n\
                                                            <br><i><small>Koordinat belum disetting.</small></i>\n\
                                                            ';
                                            }
                                            else{
                                                    html += '<input type="hidden" name="bagiantubuh_id" id="bagiantubuh_id'+no_img+'" value="'+data.bagiantubuh_id+'" class="span2"/>\n\
                                                                    ';
                                                    html += '<input type="text" name="namabagtubuh" id="namabagtubuh'+no_img+'" value="'+data.namabagtubuh+'" class="span2"/>\n\
                                                                    ';	
                                            }

                            html += '		</td>\n\
                                                    </tr>\n\
                                                    <tr>\n\
							<td>Keterangan : </td>\n\
							<td><textarea id ="keterangan'+no_img+'" class="span2" onkeypress="return $(this).focusNextInputField(event);"></textarea><?php //echo CHtml::textArea('keterangan','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?><br>\n\</td>\n\
						</tr>\n\
                                            </table>\n\
                                                    <input img-no="'+no_img+'" type="button" name="btnsave" value="Tambah" id="btnsave'+no_img+'" />\n\
                                                    <input img-no="'+no_img+'" type="button" name="btncancel" value="Cancel" id="btncancel'+no_img+'" /><br><br>\n\
                                            </div>\n\
                                    </div>';

                                $( '#tagit'+no_img ).remove( ); // remove any tagit div first
                                $( imgtag ).append(html);
                                $( '#tagit'+no_img ).css({ top:mouseY, left:mouseX });

                                $('#tagname'+no_img).focus();

    //					}

                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
    }
      /*
	  $( '#titikklik'+no_img ).remove(); // menghapus titik lain selain titik current klik
		$("#imgtag"+no_img).append(
		$('<div id="titikklik'+no_img+'"></div>')
				.css('position', 'absolute')
				.css('top', Math.round(mouseY)-10 + 'px')
				.css('left', Math.round(mouseX)-10 + 'px')
				.css('width', '5px')
				.css('height', '5px')
				.css('background-color', 'rgba(219, 50, 92, 0.5)')
				.css('cursor', 'pointer')
				.css('display', 'block')
				.css('padding', '5px')
				.css('-webkit-border-radius', '50%')
				.css('-moz-border-radius', '50%')
				.css('border-radius', '50%')
		);
		var html = '<div id="tagit'+no_img+'">\n\
				<div class="name"><br>\n\
					<div class="text"><b>Data Pemeriksaan</b></div>\n\
					<table>\n\
						<tr>\n\
							<td>Bagian Tubuh : </td>\n\
							<td>\n\
								<input type="hidden" id="gambartubuh_id'+no_img+'" value="'+gambartubuh_id+'">\n\
								<select id="bagiantubuh_id'+no_img+'" name="bagiantubuh_id" onkeypress="return $(this).focusNextInputField(event);" class="span2">\n\
								<option value="">-- Pilih --</option>\n\
								<?php foreach ($modBagianTubuh->BagianTubuh as $key => $value){ ?>\n\
									<option value="<?php echo $value->bagiantubuh_id; ?>"><?php echo $value->namabagtubuh; ?></option>\n\
								<?php } ?>\n\
							</select>\n\
							</td>\n\
						</tr>\n\
						<tr>\n\
							<td>Keterangan : </td>\n\
							<td><textarea id ="keterangan'+no_img+'" class="span2" onkeypress="return $(this).focusNextInputField(event);"></textarea><?php //echo CHtml::textArea('keterangan','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?><br>\n\</td>\n\
						</tr>\n\
					</table>\n\
						<input img-no="'+no_img+'" type="button" name="btnsave" value="Tambah" id="btnsave'+no_img+'" />\n\
						<input img-no="'+no_img+'" type="button" name="btncancel" value="Cancel" id="btncancel'+no_img+'" /><br><br>\n\
					</div>\n\
				</div>';
	  
      $( '#tagit'+no_img ).remove( ); // remove any tagit div first
      $( imgtag ).append(html);
      $( '#tagit'+no_img ).css({ top:mouseY, left:mouseX });
      
      $('#tagname'+no_img).focus();
      *//*
    });
                            
	
	
    
	// Save button click - save tags
	//#btnsave
	 //$("#tagit1 #btnsave1").click(function(){ 
    $( document ).on( 'click',  '[id^=tagit] [id^=btnsave]', function(){
	  var no_img = $(this).attr('img-no');
      var bagiantubuh_id = $('#bagiantubuh_id'+no_img).val();
      var keterangan = $('#keterangan'+no_img).val();
	  var gambartubuh_id = $('#gambartubuh_id'+no_img).val();
		var img = $('#imgtag'+no_img).find( 'img' );
		var id = $( img ).attr( 'id' );
		//var koorX = $( img ).attr( 'mousex' );
		//var koorY = $( img ).attr( 'mousey' );
      $.ajax({
        type: "POST", 
        url: "<?php echo $this->createUrl('tambahBagianTubuh')?>", 
        data: "pic_id=" + id + "&bagiantubuh_id=" + bagiantubuh_id + "&keterangan=" + keterangan + "&pic_x=" + mouseX + "&pic_y=" + mouseY + "&type=insert"+"&gambartubuh_id="+gambartubuh_id,
        dataType: "json",
        success: function(data){
			if(data.pesan != ""){
				myAlert(data.pesan);
			}else{
				$('#table-bagtubuh > tbody').append(data.form);
				renameInput($('#table-bagtubuh'));
				titikSebelumSimpan(data.axis['x'],data.axis['y'],data.bagiantubuh_id,'#imgtag'+no_img);
			}
//          viewtag( id );
          $('#tagit'+no_img).fadeOut();
		  $('#titikklik'+no_img).remove();
        },
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
      });
      
    });
	
	
	// Cancel the tag box.
    $( document ).on( 'click', '[id^=tagit] [id^=btncancel]', function() {
	  var no_img = $(this).attr('img-no');
      $('#tagit'+no_img).fadeOut();
      $('#titikklik'+no_img).remove();
    });
    
	// mouseover the taglist 
	$('#taglist').on( 'mouseover', 'li', function( ) {
      id = $(this).attr("id");
      $('#view_' + id).css({ opacity: 1.0 });
    }).on( 'mouseout', 'li', function( ) {
        $('#view_' + id).css({ opacity: 0.0 });
    });
	
	// mouseover the tagboxes that is already there but opacity is 0.
	$( '#tagbox' ).on( 'mouseover', '.tagview', function( ) {
		var pos = $( this ).position();
		$(this).css({ opacity: 1.0 }); // div appears when opacity is set to 1.
	}).on( 'mouseout', '.tagview', function( ) {
		$(this).css({ opacity: 0.0 }); // hide the div by setting opacity to 0.
	});
    
	// Remove tags.
    $( '#taglist' ).on('click', '.remove', function() {
      id = $(this).parent().attr("id");
      // Remove the tag
	  $.ajax({
        type: "POST", 
        url: "savetag.php", 
        data: "tag_id=" + id + "&type=remove",
        success: function(data) {
			var img = $('#imgtag').find( 'img' );
			var id = $( img ).attr( 'id' );
			//get tags if present
			viewtag( id );
        }
      });
    });
	
	// load the tags for the image when page loads.
    var img = $('#imgtag').find( 'img' );
	var id = $( img ).attr( 'id' );
    */ 
	        
    // setValidasiCekDisabled($("#rjanamnesa-t-form"), function() {                   
    //     return true;
    //      });
	
});

/**
    * print status
    */
   function printAsesmen()
   {
       window.open('<?php echo $this->createUrl('printAsesmen',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
   }

</script>