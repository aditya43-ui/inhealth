<?php
/**
 * digunakan untuk menyimpan fungsi - fungsi javascript 
 * RSST-1498
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<script type="text/javascript">
function adaNyeri(obj){
    var id = $(obj).attr('id');
    
    if (id == 'nyeriYes'){
        $("#disableDewasa").removeClass("disable-panel");
        
        $("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val(1);
        $("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").val('Sedikit Nyeri');
    }else{
        $("#disableDewasa").addClass("disable-panel");
        
        $("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val(0);
        $("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").val('Tidak Nyeri');
    }
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
    
    $("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val(skor);
    $("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").val(keterangan);
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
	
    //myConfirm("Apakah anda akan membatalkan pemilihan pemeriksaan ini ?","Perhatian!",
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
			renameInput($('#table-bagtubuh'));
        }
   // }); 
}

function hapusBagianTubuh(obj){
	
	var bagiantubuh_id = $(obj).parents('tr').find('.bagiantubuh_id').val();
	var gambarnyeri_id = $(obj).parents('tr').find('.gambarnyeri_id').val();
	var gambartubuh_id = $(obj).parents('tr').find('.gambartubuh_id').val();
	var kordinat_tubuh_x = $(obj).parents('tr').find('.kordinat_tubuh_x').val();
	var kordinat_tubuh_y = $(obj).parents('tr').find('.kordinat_tubuh_y').val();
	var keterangan_periksa_gbr = $(obj).parents('tr').find('.keterangan_periksa_gbr').val();
	
	
	
	var koor_tubuh_x = kordinat_tubuh_x.replace(/\./g,'_');
	var koor_tubuh_y = kordinat_tubuh_y.replace(/\./g,'_');
	
	var conf = confirm("Apakah Anda yakin akan menghapus pemeriksaan ini ?");
	
    //myConfirm("Apakah anda akan menghapus pemeriksaan ini ?","Perhatian!",
    //function(r){
        if(conf){									
			$.ajax({				
				type: "POST", 
				url: "<?php echo $this->createUrl('HapusBagianTubuh')?>", 
				data: "bagiantubuh_id=" + bagiantubuh_id + "&gambarnyeri_id=" + gambarnyeri_id+ "&gambartubuh_id=" + gambartubuh_id+"&kordinat_tubuh_x="+kordinat_tubuh_x+"&kordinat_tubuh_y="+kordinat_tubuh_y+"&keterangan_periksa_gbr="+keterangan_periksa_gbr,
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
                                               
						renameInput($('#table-bagtubuh'));
						
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
		$('<div id="titikbiru_'+bagiantubuh_id+'_'+x_titik+'_'+y_titik+'"><strong style="position:absolute;top:0;left:7px;color:#fff;">'+nomor+'</strong></div>')
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
		titikSesudahSimpan(<?php echo $v->kordinat_tubuh_x; ?>, <?php echo $v->kordinat_tubuh_y.','.$i.','.$v->bagiantubuh_id ?>, '#imgtag<?php echo $v->gambartubuh_id; ?>');	
		
	<?php $j++;}
	}?>
}



$(document).ready(function(){
             cekNyeriMenjalar();                  
    loadTitikSesudahSimpan();
    
    <?php if ($model->keluhannyeri == false){ ?>
        $("#disableDewasa").addClass("disable-panel");
    <?php } ?>
	
	
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
                                            <div class="text"><strong>Data Pemeriksaan</strong></div>\n\
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
					<div class="text"><strong>Data Pemeriksaan</strong></div>\n\
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
      */
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
        
	
});
</script>