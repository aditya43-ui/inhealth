<?php $this->widget('MyJuiAutoComplete',array(
		'name'=>'jadwalRehab[jadwal]['.$idTabel.'][shift]['.$idShift.'][ruangan_id]['.$idRuangan.'][namapasien]['.$jmlBaris.']',
		'source'=>'js: function(request, response) {
					   $.ajax({
						   url: "'.Yii::app()->createUrl('pendaftaranPenjadwalan/jadwalrehabmedisT/AutoCompletePasien').'",
						   dataType: "json",
						   data: {
							   term: request.term,
							   tipepaket_id: $("#RJTindakanPelayananT_0_tipepaket_id").val(),
							   kelaspelayanan_id: $("#RJPendaftaranT_kelaspelayanan_id").val(),
							   penjamin_id: $("#RJPendaftaranT_penjamin_id").val(),
						   },
						   success: function (data) {
								   response(data);
						   }
					   })
					}',
		'options'=>array(
		   'showAnim'=>'fold',
		   'minLength' => 2,
		   'focus'=> 'js:function( event, ui ) {
				$(this).val( ui.item.nama_pasien);
				return false;
			}',
		   'select'=>'js:function( event, ui ) {
				setTindakan($(this), ui.item);
				return false;
			}',

		),
		'tombolDialog'=>array("idDialog"=>'dialogDaftarTindakanPaket','jsFunction'=>"setDialog(this);"),
		'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)","class"=>'span2 required','placeholder'=>"Ketik nama pasien"),
)); ?>