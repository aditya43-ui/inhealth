<script type="text/javascript">
		   
    function ubahJnsPeriode(){
        var obj = $("#<?php echo CHtml::activeId($model, 'jns_periode')?>");
        if(obj.val() == 'hari'){
            $('.hari').show();
            $('.bulan').hide();
            $('.tahun').hide();
        }else if(obj.val() == 'bulan'){
            $('.hari').hide();
            $('.bulan').show();
            $('.tahun').hide();
        }else if(obj.val() == 'tahun'){
            $('.hari').hide();
            $('.bulan').hide();
            $('.tahun').show();
        }
    }
    	
	$(document).ready(function() {
		var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');		
		var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');		
		var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');		
		var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');		
		var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');		
		var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');	
		var pelayanan = jQuery('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>');	
		var tujuan = jQuery('#<?php echo CHtml::activeId($model, 'ruangantujuan_id') ?>');	
		var penunjang = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpenunj_id') ?>');	
		var obat = jQuery('#<?php echo CHtml::activeId($model, 'jenisobatalkes_id') ?>');	
		var cara_keluar = jQuery('#<?php echo CHtml::activeId($model, 'carakeluar') ?>');	
		var tindakan = jQuery('#<?php echo CHtml::activeId($model, 'tindakansudahbayar_id') ?>');	
		var shift = jQuery('#<?php echo CHtml::activeId($model, 'shift_id') ?>');	
		var instalasi = jQuery('#<?php echo CHtml::activeId($model, 'instalasi') ?>');	
		
		jQuery(ins).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
					var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
					var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
					var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');
				
					var brands = ins_all;
					var selected = [];
					
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					ru.addClass('animation-loading');
					//alert(selected);

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
						dataType: "json",
						data: {instalasi_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								ru.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								ru.html(data.ruangan);								
								ru.multiselect('rebuild');																
								ru.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});

			},
			onSelectAll: function() {
					var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
					var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
					var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');
					
					var brands = ins_all;
					var selected = [];
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					ru.addClass('animation-loading');

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
						dataType: "json",
						data: {instalasi_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								ru.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								ru.html(data.ruangan);								
								ru.multiselect('rebuild');																
								ru.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});
					
			},
			onDeselectAll: function() {		
				var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
				var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
				var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');
					
				var brands = ins_all;
				var selected = '';

				

				ru.addClass('animation-loading');

				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
					dataType: "json",
					data: {instalasi_id:selected},
					success: function(data){	

						if (data.sukses != '1'){

							//toastr.error(data.pesan);
							ru.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							ru.html(data.ruangan);								
							ru.multiselect('rebuild');															
							ru.removeClass('animation-loading');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { 					
						console.log(errorThrown);

					}
				});

			}
		}).hide();
		
		jQuery(ru).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		/**
		* multi select cara bayar dan penjamin
		 */
		
		
		jQuery(cara).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
					var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
					var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
					var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
				
					var brands = cara_all;
					var selected = [];
					
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					penj.addClass('animation-loading');
					//alert(selected);

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',					
						dataType: "json",
						data: {carabayar_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								penj.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								penj.html(data.penjamin);								
								penj.multiselect('rebuild');																
								penj.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});

			},
			onSelectAll: function() {
					var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
					var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
					var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
					
					var brands = ins_all;
					var selected = [];
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					penj.addClass('animation-loading');

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
						dataType: "json",
						data: {carabayar_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								penj.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								penj.html(data.penjaminan);								
								penj.multiselect('rebuild');																
								penj.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});
					
			},
			onDeselectAll: function() {		
				var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
				var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
				var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
					
				var brands = ins_all;
				var selected = '';

				

				penj.addClass('animation-loading');

				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
					dataType: "json",
					data: {carabayar_id:selected},
					success: function(data){	

						if (data.sukses != '1'){

							//toastr.error(data.pesan);
							penj.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							penj.html(data.penjamin);								
							penj.multiselect('rebuild');															
							penj.removeClass('animation-loading');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { 					
						console.log(errorThrown);

					}
				});

			}
		}).hide();
		
		jQuery(penj).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		
		/**
		* multi select propinsi dan kabupaten
		 */
		 
		 jQuery(prop).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
					var prop  = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
					var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
					var kab  = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
				
					var brands = prop_all;
					var selected = [];
					
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					kab.addClass('animation-loading');
					//alert(selected);

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',					
						dataType: "json",
						data: {propinsi_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								kab.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								kab.html(data.kabupaten);								
								kab.multiselect('rebuild');																
								kab.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});

			},
			onSelectAll: function() {
					var prop  = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
					var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
					var kab  = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
					
					var brands = prop_all;
					var selected = [];
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					kab.addClass('animation-loading');

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',					
						dataType: "json",
						data: {propinsi_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								kab.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								kab.html(data.kabupaten);								
								kab.multiselect('rebuild');																
								kab.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});
					
			},
			onDeselectAll: function() {		
				var prop  = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
				var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
				var kab  = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
					
				var brands = prop_all;
				var selected = '';

				

				kab.addClass('animation-loading');

				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',					
					dataType: "json",
					data: {propinsi_id:selected},
					success: function(data){	

						if (data.sukses != '1'){

							//toastr.error(data.pesan);
							kab.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							kab.html(data.kabupaten);								
							kab.multiselect('rebuild');															
							kab.removeClass('animation-loading');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { 					
						console.log(errorThrown);

					}
				});

			}
		}).hide();
		
		jQuery(kab).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(pelayanan).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(tujuan).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(penunjang).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(obat).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(cara_keluar).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(tindakan).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(shift).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(instalasi).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
});
	
	function checkPilihan(event){
		var namaPeriode = $('#PeriodeName').val();

		if(namaPeriode == ''){
			myAlert('Silakan pilih kategori pencarian!');
			event.preventDefault();
			$('#dtPicker3').datepicker("hide");
			return true;
			;
		}
	}
	
	function setPeriode(){
		namaPeriode = $('#PeriodeName').val();

			$.post('<?php echo $this->createUrl('GantiPeriode'); ?>',{namaPeriode:namaPeriode},function(data){
				$('#BKLaporanrekaptransaksiV_tgl_awal').val(data.periodeawal);
				$('#BKLaporanrekaptransaksiV_tgl_akhir').val(data.periodeakhir);
				$('#PPRuanganM_tgl_awal').val(data.periodeawal);
				$('#PPRuanganM_tgl_akhir').val(data.periodeakhir);
			},'json');
	}

	function tab(index){
		$(this).hide();
		if (index==0){
			$("#filter_tab").val('global');
			$("#div_global").show();
			$("#div_ugd").hide();
			$("#div_rj").hide();        
			$("#div_ri").hide();        
		} else if (index==1){
			$("#filter_tab").val('ugd');
			$("#div_global").hide();
			$("#div_ugd").show();
			$("#div_rj").hide();
			$("#div_ri").hide();
		} else if (index==2){
			$("#filter_tab").val('rj');
			$("#div_global").hide();
			$("#div_ugd").hide();
			$("#div_rj").show();  
			$("#div_ri").hide();  
		} else if (index==3){
			$("#filter_tab").val('ri');
			$("#div_global").hide();
			$("#div_ugd").hide();
			$("#div_rj").hide();        
			$("#div_ri").show();        
		}
	}
	function onReset()
	{
		setTimeout(
			function(){
				$.fn.yiiGridView.update('laporanrekaptransaksi-grid', {
					data: $("#caripasien-form").serialize()
				});
				$.fn.yiiGridView.update('ugd_laporanrekaptransaksi-grid', {
					data: $("#caripasien-form").serialize()
				});
				$.fn.yiiGridView.update('rj_laporanrekaptransaksi-grid', {
					data: $("#caripasien-form").serialize()
				});        
				$.fn.yiiGridView.update('ri_laporanrekaptransaksi-grid', {
					data: $("#caripasien-form").serialize()
				});        
			}, 2000
		);
		return false;
	}   

	$(document).ready(function() {
		$("#tabmenu").children("li").children("a").click(function() {
			$("#tabmenu").children("li").attr('class','');
			$(this).parents("li").attr('class','active');
			$(".icon-pencil").remove();
			// $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
		});

		$("#div_global").show();
		$("#div_ugd").hide();
		$("#div_rj").hide();
		$("#div_ri").hide();
	});
</script>