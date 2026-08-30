<script type="text/javascript">

function printPemeriksaanFisik()
{
    window.open('<?php echo $this->createUrl('printPemeriksaanFisik',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)); ?>','printwin','left=100,top=100,width=793,height=1122');
}

function defaultparamedis()
{
    var paramedis = '<?php 
    $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
    if (!empty($pegawai)) echo $pegawai->nama_pegawai; 
    ?>';
    $("#<?php echo CHtml::activeId($modPemeriksaanFisik,'paramedis_nama') ?>").val(paramedis);
}

function batalTambahBagianTubuh(obj){
    myConfirm("Apakah Anda akan membatalkan pemilihan pemeriksaan ini?","Perhatian!",
    function(r){
        if(r){
            var bagiantubuh_id = $(obj).parents('tr').find('input[name$="[bagiantubuh_id]"]').val();
			var gambartubuh_id = $(obj).parents('tr').find('input[name$="[gambartubuh_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[bagiantubuh_id]"][value="'+bagiantubuh_id+'"]').each(function(){
				//$(obj).parents('tbody').find('input[name$="[gambartubuh_id]"][value="'+gambartubuh_id+'"]').each(function(){
					//alert($(this).attr('delete'));
					if ($(this).data('delete') == gambartubuh_id){							
						$(this).parents('tr').detach();
					}	
				//})
                //$(this).parents('tr').detach();
            });
			$("#imgtag"+gambartubuh_id).find('#titik_'+bagiantubuh_id).detach();
        }
    }); 
}
function hapusBagianTubuh(obj){
    myConfirm("Apakah Anda akan menghapus pemeriksaan ini?","Perhatian!",
    function(r){
        if(r){
			var bagiantubuh_id = $(obj).parents('tr').find('input[name="bagiantubuh_id"]').val();
			var pemeriksaangambar_id = $(obj).parents('tr').find('input[name="pemeriksaangambar_id"]').val();
			var gambartubuh_id = $(obj).parents('tr').find('input[name="gambartubuh_id"]').val();
			
			
			$.ajax({
				type: "POST", 
				url: "<?php echo $this->createUrl('hapusBagianTubuh')?>", 
				data: "bagiantubuh_id=" + bagiantubuh_id + "&pemeriksaangambar_id=" + pemeriksaangambar_id+ "&gambartubuh_id=" + gambartubuh_id,
				dataType: "json",
				success: function(data){
					if(data.pesan != ""){
						myAlert(data.pesan);
					}else{
						$(obj).parents('tbody').find('input[name="bagiantubuh_id"][value="'+bagiantubuh_id+'"]').each(function(){
							if ($(this).data('delete') == gambartubuh_id){							
								$(this).parents('tr').detach();
							}							
						});
						$("#imgtag"+gambartubuh_id).find('#titikbiru_'+bagiantubuh_id).detach();
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

function titikSebelumSimpan(ptitikX,ptitikY,bagiantubuh_id, img){
	var titikX = Math.round(ptitikX)-10;
	var titikY = Math.round(ptitikY)-10;
	var color = 'rgba(219, 50, 92, 0.9)';
	var size = '1px';
	$(img).append(
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

function titikSesudahSimpan(titikX,titikY,urutan,bagiantubuh_id, img){
	var titikX=titikX-15;
	var titikY=titikY-15;
	var nomor = urutan+1;
	var color = 'rgba(0, 128, 255, 0.8)';
	var size = '5px';
	$(img).append(
		$('<div id="titikbiru_'+bagiantubuh_id+'"><strong style="position:absolute;top:0;left:7px">'+nomor+'</b></div>')
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

function disableInputHemodinamik() {
	$(".gcs_panel")
			.hide()
			.find(":input")
			.prop("disabled", true);
	
}

function pilihFormHemo() {
	var is_dewasa = $(".cb_pilih_hemo:checked").val();
	
	disableInputHemodinamik();
	
	if (is_dewasa == 0) {
		$(".gcs_dewasa").show().find(":input").prop("disabled", false);
		
	} else {
		$(".gcs_bayi").show().find(":input").prop("disabled", false);
	}
	hitungSkorSedasi();
}

function hitungSkorSedasi() {
	var total = 0;
	$(".input_gcs:not(:disabled)").each(function(data) {
			if (!isNaN(parseInt($(this).val()))) {
			total += parseInt($(this).val());
		}
	});
	$(".namaGCS").val(total);
}

$(document).ready(function() {
	pilihFormHemo();
	$(".cb_pilih_hemo").on("click", pilihFormHemo);
	$(".input_gcs").on("change", hitungSkorSedasi);
});

/*
function imageAnatomi(obj,i){
	var counter = 0;
	var mouseX = 0;
	var mouseY = 0;
	
	$(obj).click(function(e){			
	 var imgtag = $(this).parent(); // get the div to append the tagging list
      mouseX = ( e.pageX - $(imgtag).offset().left ); // x and y axis
      mouseY = ( e.pageY - $(imgtag).offset().top );
	  if (i == ''){
		  i = '';
	  }else{
		  i = i;
	  }
	  $(obj).attr("mousex",mouseX);
	  $(obj).attr("mousey",mouseY);
	  $( '#titikklik'+i ).remove(); // menghapus titik lain selain titik current klik
		$("#imgtag"+i).append(
		$('<div id="titikklik'+i+'"></div>')
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
		var html = '<div id="tagit'+i+'">\n\
				<div class="name"><br>\n\
					<div class="text"><b>Data Pemeriksaan</b></div>\n\
					<table>\n\
						<tr>\n\
							<td>Bagian Tubuh : </td>\n\
							<td>\n\
								<select id="bagiantubuh_id'+i+'" name="bagiantubuh_id" onkeypress="return $(this).focusNextInputField(event);" class="span2">\n\
								<option value="">-- Pilih --</option>\n\
								<?php foreach ($modBagianTubuh->BagianTubuh as $key => $value){ ?>\n\
									<option value="<?php echo $value->bagiantubuh_id; ?>"><?php echo $value->namabagtubuh; ?></option>\n\
								<?php } ?>\n\
							</select>\n\
							</td>\n\
						</tr>\n\
						<tr>\n\
							<td>Keterangan : </td>\n\
							<td><textarea id ="keterangan'+i+'" class="span2" onkeypress="return $(this).focusNextInputField(event);"></textarea><?php //echo CHtml::textArea('keterangan','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?><br>\n\</td>\n\
						</tr>\n\
					</table>\n\
						<input onclick = "simpanAnatomi(this,'+i+')" type="button" name="btnsave" value="Tambah" id="btnsave'+i+'" />\n\
						<input type="button" name="btncancel" value="Cancel" id="btncancel'+i+'" /><br><br>\n\
					</div>\n\
				</div>';
	  
      $( '#tagit'+i ).remove( ); // remove any tagit div first
      $( imgtag ).append(html);
      $( '#tagit'+i ).css({ top:mouseY, left:mouseX });
      
      $('#tagname'+i).focus();
  });
}

function simpanAnatomi(obj,i){
	 
    var  bagiantubuh_id = $('#bagiantubuh_id'+i).val();
    var  keterangan = $('#keterangan'+i).val();
	var img = $('#imgtag'+i).find( 'img' );
	var id = $( img ).attr( 'id' );
	var koorX = $( img ).attr( 'mousex' );
	var koorY = $( img ).attr( 'mousey' );
	$.ajax({
	  type: "POST", 
	  url: "<?php echo $this->createUrl('tambahBagianTubuh')?>", 
	  data: "pic_id=" + id + "&bagiantubuh_id=" + bagiantubuh_id + "&keterangan=" + keterangan + "&pic_x=" + koorX + "&pic_y=" + koorY + "&type=insert",
	  dataType: "json",
	  success: function(data){
		  if(data.pesan != ""){
			  myAlert(data.pesan);
		  }else{
			  $('#table-bagtubuh > tbody').append(data.form);
			  renameInput($('#table-bagtubuh'));
			  titikSebelumSimpan(data.axis['x'],data.axis['y'],data.bagiantubuh_id,'#imgtag');
		  }
          viewtag( id );
		$('#tagit'+i).fadeOut();
		$('#titikklik'+i).remove();
	  },
	  error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
      
  
}

*/

function dbnTorax(){
if($('#DbnTorax').prop('checked')==true){
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'inspeksi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'inspeksi') ?>"]').eq(i); 
            // if(inputData.val()=='normal'){
            //     inputData.attr('checked',true);
            // } 
			inputData.val('Normal');
        } 
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'palpasi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'palpasi') ?>"]').eq(i); 
            // if(inputData.val()=='normal'){
            //     inputData.attr('checked',true);
            // } 
			inputData.val('Normal');
        } 
        
        // $('.au_parurhkanan').val('+');
        // $('.au_parurhkiri').val('+');
        $('.au_paruwhkanan').val('+');
        $('.au_paruwhkiri').val('+');
        $('.au_cardios').val('Reguler');

        // $('#<?php //echo CHtml::activeId($modPemeriksaanFisik, 'inspeksi_keterangan'); ?>').attr('disabled',true);
        // $('#<?php //echo CHtml::activeId($modPemeriksaanFisik, 'palpasi_keterangan'); ?>').attr('disabled',true);
        
    }else{
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'inspeksi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'inspeksi') ?>"]').eq(i); 
                // inputData.attr('checked',false);
			inputData.val('');
        }
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'palpasi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'palpasi') ?>"]').eq(i); 
                // inputData.attr('checked',false);
			inputData.val('');
        }
        //  $('.au_parurhkanan').val('');
        // $('.au_parurhkiri').val('');
        $('.au_paruwhkanan').val('');
        $('.au_paruwhkiri').val('');
        $('.au_cardios').val('');

        // $('#<?php //echo CHtml::activeId($modPemeriksaanFisik, 'inspeksi_keterangan'); ?>').attr('disabled',false);
        // $('#<?php //echo CHtml::activeId($modPemeriksaanFisik, 'palpasi_keterangan'); ?>').attr('disabled',false);
    }
}	

function dbnAbdomen(){
    if($('#DbnAbdomen').prop('checked')==true){
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_inspeksi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_inspeksi') ?>"]').eq(i); 
            // if(inputData.val()=='normal'){
            //     inputData.attr('checked',true);
            // } 
			inputData.val('Normal');
        } 
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_palpasi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_palpasi') ?>"]').eq(i); 
            // if(inputData.val()=='normal'){
            //     inputData.attr('checked',true);
            // } 
			inputData.val('Normal');
        } 
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_1') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_1') ?>"]').eq(i); 
            // if(inputData.val()=='normal'){
            //     inputData.attr('checked',true);
            // } 
			inputData.val('Normal');
        } 
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_2') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_2') ?>"]').eq(i); 
            // if(inputData.val()=='normal'){
            //     inputData.attr('checked',true);
            // } 
			inputData.val('Normal');
        } 
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_3') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_3') ?>"]').eq(i); 
            // if(inputData.val()=='normal'){
            //     inputData.attr('checked',true);
            // } 
			inputData.val('Normal');
        } 
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_4') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_4') ?>"]').eq(i); 
            // if(inputData.val()=='normal'){
            //     inputData.attr('checked',true);
            // } 
			inputData.val('Normal');
        }
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_perkusi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_perkusi') ?>"]').eq(i); 
                //  if(inputData.val()=='normal'){
                //     inputData.attr('checked',true);
                // } 
			inputData.val('Normal');
        }
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_auskultasi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_auskultasi') ?>"]').eq(i); 
                //  if(inputData.val()=='normal'){
                //     inputData.attr('checked',true);
                // } 
			inputData.val('Normal');
        }
        // $('#<?php //echo CHtml::activeId($modPemeriksaanFisik, 'abd_inspeksi_keterangan'); ?>').attr('disabled',true);
        // $('#<?php //echo CHtml::activeId($modPemeriksaanFisik, 'abd_auskultasi_keterangan'); ?>').attr('disabled',true);
        // $('#<?php //echo CHtml::activeId($modPemeriksaanFisik, 'abd_perkusi_keterangan'); ?>').attr('disabled',true);
    }else{
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_inspeksi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_inspeksi') ?>"]').eq(i); 
                // inputData.attr('checked',false);
			// inputData.val('Tidak');
			inputData.val('');
        }
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_palpasi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_palpasi') ?>"]').eq(i); 
            // if(inputData.val()=='normal'){
            //     inputData.attr('checked',true);
            // } 
			// inputData.val('Tidak');
			inputData.val('');
        } 
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_1') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_1') ?>"]').eq(i); 
                // inputData.attr('checked',false);
			// inputData.val('Tidak');
			inputData.val('');
        }
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_2') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_2') ?>"]').eq(i); 
                // inputData.attr('checked',false);
			// inputData.val('Tidak');
			inputData.val('');
        }
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_3') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_3') ?>"]').eq(i); 
                // inputData.attr('checked',false);
			// inputData.val('Tidak');
			inputData.val('');
        }
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_4') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'leopold_4') ?>"]').eq(i); 
                // inputData.attr('checked',false);
			// inputData.val('Tidak');
			inputData.val('');
        }
         for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_perkusi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_perkusi') ?>"]').eq(i); 
                // inputData.attr('checked',false);
			// inputData.val('Tidak');
			inputData.val('');
        }
        for(i = 0; i < $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_auskultasi') ?>"]').length; i++) { 
            var inputData = $('input[name="<?php echo CHtml::activeName($modPemeriksaanFisik, 'abd_auskultasi') ?>"]').eq(i); 
                // inputData.attr('checked',false);
			// inputData.val('Tidak');
			inputData.val('');
        }
        // $('#<?php //echo CHtml::activeId($modPemeriksaanFisik, 'abd_inspeksi_keterangan'); ?>').attr('disabled',false);
        // $('#<?php //echo CHtml::activeId($modPemeriksaanFisik, 'abd_auskultasi_keterangan'); ?>').attr('disabled',false);
        // $('#<?php //echo CHtml::activeId($modPemeriksaanFisik, 'abd_perkusi_keterangan'); ?>').attr('disabled',false);
    }
}

$(document).ready(function(){
    // defaultparamedis();     
//    anatomitubuh();  
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
      
      var displaySensor = 'none';
      
      if(mouseX != 0 && mouseY != 0){
			$.ajax({
				type: "POST", 
				url: "<?php echo $this->createUrl('getBagianTubuhId')?>", 
				data: {kordinat_x: mouseX, kordinat_y: mouseY, gambartubuh_id: gambartubuh_id},
				dataType: "json",
				success: function(data){
                                    
            //if(data.kakitangan == 'ok'){
                displaySensor = 'true';
            //}
            
	//  $( '#titikklik'+no_img ).remove(); // menghapus titik lain selain titik current klik
        $( '[id^=titikklik]' ).remove(); // menghapus titik lain selain titik current klik
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
							<td>Look : </td>\n\
							<td><input type="text" id="look'+no_img+'" class="span2" onkeypress="return $(this).focusNextInputField(event);"><br>\n\</td>\n\
						</tr>\n\
                                                <tr>\n\
							<td>Feel : </td>\n\
							<td><input type="text" id="feel'+no_img+'" class="span2" onkeypress="return $(this).focusNextInputField(event);"><br>\n\</td>\n\
						</tr>\n\
                                                <tr>\n\
							<td>Move : </td>\n\
							<td><input type="text" id="move'+no_img+'" class="span2" onkeypress="return $(this).focusNextInputField(event);"><br>\n\</td>\n\
						</tr>\n\
                                                <tr style="display:'+displaySensor+'">\n\
							<td>Sensory : </td>\n\
							<td>\n\
                                                            <select id="sensory'+no_img+'" name="sensory" onkeypress="return $(this).focusNextInputField(event);" class="span2">\n\
                                                                <option value="">-- Pilih --</option>\n\
                                                                <option value="0">0</option>\n\
                                                                <option value="1">1</option>\n\
                                                                <option value="2">2</option>\n\
                                                                <option value="Not Testable">Not Testable</option>\n\
                                                            </select>\n\
							</td>\n\
						</tr>\n\
                                                <tr style="display:'+displaySensor+'">\n\
							<td>Motorik : </td>\n\
							<td>\n\
                                                            <select id="motorik'+no_img+'" name="motorik" onkeypress="return $(this).focusNextInputField(event);" class="span2">\n\
                                                                <option value="">-- Pilih --</option>\n\
                                                                <option value="0">0</option>\n\
                                                                <option value="1">1</option>\n\
                                                                <option value="2">2</option>\n\
                                                                <option value="3">3</option>\n\
                                                                <option value="4">4</option>\n\
                                                                <option value="5">5</option>\n\
                                                                <option value="Not Testable">Not Testable</option>\n\
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
	  
      //$( '#tagit'+no_img ).remove( ); // remove any tagit div first
       $( '[id^=tagit]' ).remove(); // menghapus titik lain selain titik current klik
      $( imgtag ).append(html);
      $( '#tagit'+no_img ).css({ top:mouseY, left:mouseX });
      
      $('#tagname'+no_img).focus();
      
     mouseY = mouseY.toFixed(7);
    mouseX = mouseX.toFixed(7);
    $('#bagiantubuh_id'+no_img).val(data.bagiantubuh_id);  
    
                                },
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
      
      
    });
	
	/*
	 $("#imgtag2 img").click(function(e) { // make sure the image is click
      var imgtag = $(this).parent(); // get the div to append the tagging list
      mouseX = ( e.pageX - $(imgtag).offset().left ); // x and y axis
      mouseY = ( e.pageY - $(imgtag).offset().top );
	  $( '#titikklik2' ).remove(); // menghapus titik lain selain titik current klik
		$("#imgtag2").append(
		$('<div id="titikklik2"></div>')
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
		var html = '<div id="tagit2">\n\
				<div class="name"><br>\n\
					<div class="text"><b>Data Pemeriksaan</b></div>\n\
					<table>\n\
						<tr>\n\
							<td>Bagian Tubuh : </td>\n\
							<td>\n\
								<select id="bagiantubuh_id2" name="bagiantubuh_id" onkeypress="return $(this).focusNextInputField(event);" class="span2">\n\
								<option value="">-- Pilih --</option>\n\
								<?php foreach ($modBagianTubuh->BagianTubuh as $key => $value){ ?>\n\
									<option value="<?php echo $value->bagiantubuh_id; ?>"><?php echo $value->namabagtubuh; ?></option>\n\
								<?php } ?>\n\
							</select>\n\
							</td>\n\
						</tr>\n\
						<tr>\n\
							<td>Keterangan : </td>\n\
							<td><?php echo CHtml::textArea('keterangan2','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?><br>\n\</td>\n\
						</tr>\n\
					</table>\n\
						<input type="button" name="btnsave" value="Tambah" id="btnsave2" />\n\
						<input type="button" name="btncancel" value="Cancel" id="btncancel2" /><br><br>\n\
					</div>\n\
				</div>';
	  
      $( '#tagit2' ).remove( ); // remove any tagit div first
      $( imgtag ).append(html);
      $( '#tagit2' ).css({ top:mouseY, left:mouseX });
      
      $('#tagname2').focus();
    });*/
    
	// Save button click - save tags
	//#btnsave
	 //$("#tagit1 #btnsave1").click(function(){ 
    $( document ).on( 'click',  '[id^=tagit] [id^=btnsave]', function(){
	  var no_img = $(this).attr('img-no');
      var bagiantubuh_id = $('#bagiantubuh_id'+no_img).val();
      var look = $('#look'+no_img).val();
      var feel = $('#feel'+no_img).val();
      var move = $('#move'+no_img).val();
      var sensory = $('#sensory'+no_img).val();
      var motorik = $('#motorik'+no_img).val();
      var keterangan = $('#keterangan'+no_img).val();
	  var gambartubuh_id = $('#gambartubuh_id'+no_img).val();
      
		var img = $('#imgtag'+no_img).find( 'img' );
		var id = $( img ).attr( 'id' );
		//var koorX = $( img ).attr( 'mousex' );
		//var koorY = $( img ).attr( 'mousey' );
      $.ajax({
        type: "POST", 
        url: "<?php echo $this->createUrl('tambahBagianTubuh')?>", 
        data: "pic_id=" + id + "&bagiantubuh_id=" + bagiantubuh_id + "&look=" + look + "&feel=" + feel + "&move=" + move + "&sensory=" + sensory + "&motorik=" + motorik + "&keterangan=" + keterangan + "&pic_x=" + mouseX + "&pic_y=" + mouseY + "&type=insert"+"&gambartubuh_id="+gambartubuh_id,
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
	/*
	//image 2
	// Save button click - save tags
    $( document ).on( 'click',  '#tagit2 #btnsave2', function(){
      bagiantubuh_id = $('#bagiantubuh_id2').val();
      keterangan = $('#keterangan2').val();
		var img = $('#imgtag2').find( 'img' );
		var id = $( img ).attr( 'id' );
		var gambartubuh_id = $( img ).attr( 'alt' );
		
      $.ajax({
        type: "POST", 
        url: "<?php //echo $this->createUrl('tambahBagianTubuh')?>", 
        data: "pic_id=" + id + "&bagiantubuh_id=" + bagiantubuh_id + "&keterangan=" + keterangan + "&pic_x=" + mouseX + "&pic_y=" + mouseY + "&type=insert",
        dataType: "json",
        success: function(data){
			if(data.pesan != ""){
				myAlert(data.pesan);
			}else{
				$('#table-bagtubuh > tbody').append(data.form);
				renameInput($('#table-bagtubuh'));
				titikSebelumSimpan(data.axis['x'],data.axis['y'],data.bagiantubuh_id,'#imgtag2');
			}
//          viewtag( id );
          $('#tagit2').fadeOut();
		  $('#titikklik2').remove();
        },
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
      });
      
    });
	*/
	
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
    