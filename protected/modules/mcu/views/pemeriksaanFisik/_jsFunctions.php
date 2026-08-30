<script type="text/javascript">

function printPemeriksaanFisik()
{
    window.open('<?php echo $this->createUrl('printPemeriksaanFisik',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)); ?>','printwin','left=100,top=100,width=793,height=1122');
}

function defaultparamedis()
{
    var paramedis = '<?php echo PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->nama_pegawai; ?>';
    $("#<?php echo CHtml::activeId($modPemeriksaanFisik,'paramedis_nama') ?>").val(paramedis);
}

function batalTambahBagianTubuh(obj){
    myConfirm("Apakah Anda akan membatalkan pemilihan pemeriksaan ini?","Perhatian!",
    function(r){
        if(r){
            var bagiantubuh_id = $(obj).parents('tr').find('input[name$="[bagiantubuh_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[bagiantubuh_id]"][value="'+bagiantubuh_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
			$('#titik_'+bagiantubuh_id).detach();
        }
    }); 
}
function hapusBagianTubuh(obj){
    myConfirm("Apakah Anda akan menghapus pemeriksaan ini?","Perhatian!",
    function(r){
        if(r){
			var bagiantubuh_id = $(obj).parents('tr').find('input[name="bagiantubuh_id"]').val();
			var pemeriksaangambar_id = $(obj).parents('tr').find('input[name="pemeriksaangambar_id"]').val();
			$.ajax({
				type: "POST", 
				url: "<?php echo $this->createUrl('hapusBagianTubuh')?>", 
				data: "bagiantubuh_id=" + bagiantubuh_id + "&pemeriksaangambar_id=" + pemeriksaangambar_id,
				dataType: "json",
				success: function(data){
					if(data.pesan != ""){
						myAlert(data.pesan);
					}else{
						$(obj).parents('tbody').find('input[name="bagiantubuh_id"][value="'+bagiantubuh_id+'"]').each(function(){
							$(this).parents('tr').detach();
						});
						$('#titikbiru_'+bagiantubuh_id).detach();
					}
				  
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
        }
    }); 
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

function titikSebelumSimpan(ptitikX,ptitikY,bagiantubuh_id){
	var titikX = Math.round(ptitikX)-10;
	var titikY = Math.round(ptitikY)-10;
	var color = 'rgba(219, 50, 92, 0.9)';
	var size = '1px';
	$("#imgtag").append(
	$('<div id="titik_'+bagiantubuh_id+'"></div>')
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

function titikSesudahSimpan(titikX,titikY,urutan,bagiantubuh_id){
	var titikX=titikX-15;
	var titikY=titikY-15;
	var nomor = urutan+1;
	var color = 'rgba(0, 128, 255, 0.8)';
	var size = '5px';
	$("#imgtag").append(
		$('<div id="titikbiru_'+bagiantubuh_id+'"><b>'+nomor+'</b></div>')
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
		foreach($modPemeriksaanGambar as $i => $v){ ?>
		titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y.','.$i.','.$v->bagiantubuh_id ?>);	
	<?php }
	}?>
}

function setKeterangan(){
	var td_systolic = $("#<?php echo CHtml::activeId($modPemeriksaanFisik,'td_systolic') ?>").val();
	var td_diastolic = $("#<?php echo CHtml::activeId($modPemeriksaanFisik,'td_diastolic') ?>").val();
	var keterangan = '';
	if((td_systolic < 120) && (td_diastolic < 80)){
		keterangan = 'Normal';
	}else if((td_systolic >= 120 && td_systolic <= 139) && (td_diastolic >= 80 && td_diastolic <= 89)){
		keterangan = 'Hipertensi';
	}else if((td_systolic >= 140 && td_systolic <= 159) && (td_diastolic >= 90 && td_diastolic <= 99)){
		keterangan = 'Hipertensi Grade 1 (Ringan)';
	}else if((td_systolic >= 160 && td_systolic <= 179) && (td_diastolic >= 100 && td_diastolic <= 109)){
		keterangan = 'Hipertensi Grade 2 (Sedang)';
	}else if((td_systolic > 180) && (td_diastolic > 110)){
		keterangan = 'Hipertensi Grade 3 (Berat)';
	}
	$("#<?php echo CHtml::activeId($modPemeriksaanFisik,'kriteria_td') ?>").val(keterangan);
}

$('#MCRiwayatthtR_rectal_tidakdilakukan').click(function(){
    if($(this).is(':checked')){
		$('#MCRiwayatthtR_anus_0').attr('disabled',false);
		$('#MCRiwayatthtR_anus_1').attr('disabled',false);
		$('#MCRiwayatthtR_keterangan_rectal').attr('disabled',false);
	}else{
		$('#MCRiwayatthtR_anus_0').attr('disabled',true);
		$('#MCRiwayatthtR_anus_1').attr('disabled',true);
		$('#MCRiwayatthtR_keterangan_rectal').attr('disabled',true);
	}
});

$(document).ready(function(){
    defaultparamedis();     
//    anatomitubuh();  
	loadTitikSesudahSimpan();
	
	$('#MCRiwayatthtR_rectal_tidakdilakukan').attr('checked',true);
	
	var counter = 0;
    var mouseX = 0;
    var mouseY = 0;
   
    $("#imgtag img").click(function(e) { // make sure the image is click
      var imgtag = $(this).parent(); // get the div to append the tagging list
      mouseX = ( e.pageX - $(imgtag).offset().left ); // x and y axis
      mouseY = ( e.pageY - $(imgtag).offset().top );
		$("#imgtag").append(
		$('<div id="titikklik"></div>')
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
		var html = '<div id="tagit">\n\
				<div class="name"><br>\n\
					<div class="text"><b>Data Pemeriksaan</b></div>\n\
					<table>\n\
						<tr>\n\
							<td>Bagian Tubuh : </td>\n\
							<td>\n\
								<select id="bagiantubuh_id" name="bagiantubuh_id" onkeypress="return $(this).focusNextInputField(event);" class="span2">\n\
								<option value="">-- Pilih --</option>\n\
								<?php foreach ($modBagianTubuh->BagianTubuh as $key => $value){ ?>\n\
									<option value="<?php echo $value->bagiantubuh_id; ?>"><?php echo $value->namabagtubuh; ?></option>\n\
								<?php } ?>\n\
							</select>\n\
							</td>\n\
						</tr>\n\
						<tr>\n\
							<td>Keterangan : </td>\n\
							<td><?php echo CHtml::textArea('keterangan','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?><br>\n\</td>\n\
						</tr>\n\
					</table>\n\
						<input type="button" name="btnsave" value="Tambah" id="btnsave" />\n\
						<input type="button" name="btncancel" value="Cancel" id="btncancel" /><br><br>\n\
					</div>\n\
				</div>';
	  
      $( '#tagit' ).remove( ); // remove any tagit div first
      $( imgtag ).append(html);
      $( '#tagit' ).css({ top:mouseY, left:mouseX });
      
      $('#tagname').focus();
    });
    
	// Save button click - save tags
    $( document ).on( 'click',  '#tagit #btnsave', function(){
      bagiantubuh_id = $('#bagiantubuh_id').val();
      keterangan = $('#keterangan').val();
		var img = $('#imgtag').find( 'img' );
		var id = $( img ).attr( 'id' );
      $.ajax({
        type: "POST", 
        url: "<?php echo $this->createUrl('tambahBagianTubuh')?>", 
        data: "pic_id=" + id + "&bagiantubuh_id=" + bagiantubuh_id + "&keterangan=" + keterangan + "&pic_x=" + mouseX + "&pic_y=" + mouseY + "&type=insert",
        dataType: "json",
        success: function(data){
			if(data.pesan != ""){
				myAlert(data.pesan);
			}else{
				$('#table-bagtubuh > tbody').append(data.form);
				renameInput($('#table-bagtubuh'));
				titikSebelumSimpan(data.axis['x'],data.axis['y'],data.bagiantubuh_id);
			}
//          viewtag( id );
          $('#tagit').fadeOut();
		  $('#titikklik').remove();
        },
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
      });
      
    });
	
	// Cancel the tag box.
    $( document ).on( 'click', '#tagit #btncancel', function() {
      $('#tagit').fadeOut();
      $('#titikklik').remove();
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
	
	
	$('#is_berkacamata').click(function(){
		if(this.checked){
			$('#visus').show();
        }else {
			$('#visus').hide();
        }
	});
	
});
function setRange(obj){
	var mm = $(obj).val();
	
	if(mm < 120){
		$('#tekananDarah').val("< 120");
	}
	if(mm >= 120 && mm <= 129){
		$('#tekananDarah').val("120 - 129");
	}
	if(mm >= 130 && mm <= 139){
		$('#tekananDarah').val("130 - 139");
	}
	if(mm >= 140 && mm <= 149){
		$('#tekananDarah').val("140 - 149");
	}
	if(mm >= 150 && mm <= 159){
		$('#tekananDarah').val("150 - 159");
	}
	if(mm >= 160){
		$('#tekananDarah').val("> 160");
	}
}
</script>
    