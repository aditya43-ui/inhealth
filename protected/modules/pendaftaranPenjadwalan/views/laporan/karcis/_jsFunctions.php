<?php
$url = Yii::app()->createUrl($this->route);
$urlModule = Yii::app()->createUrl($this->module->id);
$urlGrafik = Yii::app()->createUrl($this->module->id."/".$this->id."/UpdateGrafik");
$js = <<< JS
    var params = $('#search-laporan :input').serialize();
    function refreshGrafikGaris(carabayar_nama){
        $('#garis').addClass("animation-loading");
        $('#speedo').addClass("animation-loading");
        $.ajax({
            type: "POST",
            url: "${urlGrafik}",
            data: params+"&carabayar_nama="+carabayar_nama,
            dataType: "json",
            success: function(data) {
                plot_garis.destroy();
                plot_garis.title.text = data.title;
                plot_garis.series[0].data = data.garis.result;
                plot_garis.axes.xaxis.ticks = data.garis.index;
                plot_garis.axes.xaxis.tickOptions = (data.garis.index.length > 8 ) ? {angle:-30} : {angle:-0};
                plot_garis.replot({resetAxes:['yaxis'],axes:{yaxis:{min:0, pad:5}}});
                $('#garis').removeClass("animation-loading");
                $('#speedo').removeClass("animation-loading");
                setValue_speedo(data.speedo.result);
            },
            error: function(error){
//                myAlert('Update Grafik Garis dan Speedo Gagal!');
                console.log(error);
                $('#garis').removeClass("animation-loading");
                $('#speedo').removeClass("animation-loading");
            }
        });
    }
    $('#batang').bind('jqplotClick', function (ev, seriesIndex, pointIndex, data,jqplot) {
        $(".jqplot-target").attr("style","position:relative;width:100%;");
        var carabayar_nama = "";
        if(data != null){
            carabayar_nama = jqplot.data[0][[data.data[0]][0]-1][0];
        }
        refreshGrafikGaris(carabayar_nama);
    });
    $('#pie').bind('jqplotClick', function (ev, seriesIndex, pointIndex, data,jqplot) {
        $(".jqplot-target").attr("style","position:relative;width:100%;");
        var carabayar_nama = "";
        if(data != null){
            carabayar_nama = data.data[0];
        }
        refreshGrafikGaris(carabayar_nama);
    });
    refreshGrafikGaris("");
    ubahJnsPeriode();
JS;

Yii::app()->clientScript->registerScript('diagram',$js, CClientScript::POS_READY)
?>
<script type="text/javascript">
    function refreshForm(){
        window.location.href = "<?php echo $url;?>";
    }
    function konfirmasiBatal(){
        var conf = confirm("Apakah Anda akan membatalkan ini?");
        if(conf == true){
            window.location.href = "<?php echo $urlModule;?>&modul_id=39";
        }
    }
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
		var batal = jQuery('#<?php echo CHtml::activeId($model, 'create_loginpemakai_id') ?>');	
		var sps = jQuery('#PPLaporankarcispasien_spesialis_id');
		
		// multiselect spesialis
		jQuery(sps).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
				var sps = jQuery('#PPLaporankarcispasien_spesialis_id');
				var sps_all = jQuery('#PPLaporankarcispasien_spesialis_id option:selected');
				var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');
				
				var brands = sps_all;
				var selected = [];
				
				var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
				var selectedIns = [];

				$(ins_all).each(function(index, brand){
					selectedIns.push($(this).val());
				});
			
				$(brands).each(function(index, brand){
					selected.push($(this).val());
				});

				ru.addClass('animation-loading');
				// alert(selected);

				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByJenisKasusPenyakitMultiselect') ?>',					
					dataType: "json",
					data: {jeniskasuspenyakit_id:selected, instalasi_id:selectedIns},
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
				var sps = jQuery('#PPLaporankarcispasien_spesialis_id');
				var sps_all = jQuery('#PPLaporankarcispasien_spesialis_id option:selected');
				var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

				var brands = sps_all;
				var selected = [];
				
			
				$(brands).each(function(index, brand){
					selected.push($(this).val());
				});

				var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
				var selectedIns = [];

				$(ins_all).each(function(index, brand){
					selectedIns.push($(this).val());
				});

				ru.addClass('animation-loading');
				// alert(selected);

				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByJenisKasusPenyakitMultiselect') ?>',					
					dataType: "json",
					data: {jeniskasuspenyakit_id:selected, instalasi_id:selectedIns},
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
				var sps = jQuery('#PPLaporankarcispasien_spesialis_id');
				var sps_all = jQuery('#PPLaporankarcispasien_spesialis_id option:selected');
				var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

				var brands = sps_all;
				var selected = '';
				
			
				ru.addClass('animation-loading');
				// alert(selected);

				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByJenisKasusPenyakitMultiselect') ?>',					
					dataType: "json",
					data: {jeniskasuspenyakit_id:selected},
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

		jQuery(ins).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
					var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
					var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
					var sps  = jQuery('#PPLaporankarcispasien_spesialis_id');
				
					var brands = ins_all;
					var selected = [];
					
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					sps.addClass('animation-loading');
					//alert(selected);

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetJenisKasusPenyakitByInstalasiMultiselect') ?>',					
						dataType: "json",
						data: {instalasi_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								sps.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								sps.html(data.spesialis);								
								sps.multiselect('rebuild');																
								sps.removeClass('animation-loading');
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
					var sps  = jQuery('#PPLaporankarcispasien_spesialis_id');
				
					var brands = ins_all;
					var selected = [];
					
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					sps.addClass('animation-loading');
					//alert(selected);

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetJenisKasusPenyakitByInstalasiMultiselect') ?>',					
						dataType: "json",
						data: {instalasi_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								sps.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								sps.html(data.spesialis);								
								sps.multiselect('rebuild');																
								sps.removeClass('animation-loading');
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
				var sps  = jQuery('#PPLaporankarcispasien_spesialis_id');
			
				var brands = ins_all;
				var selected = '';
				
				sps.addClass('animation-loading');
				//alert(selected);

				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetJenisKasusPenyakitByInstalasiMultiselect') ?>',					
					dataType: "json",
					data: {instalasi_id:selected},
					success: function(data){	
						
						if (data.sukses != '1'){
							
							//toastr.error(data.pesan);
							sps.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							sps.html(data.spesialis);								
							sps.multiselect('rebuild');																
							sps.removeClass('animation-loading');
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

		jQuery(batal).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
});
</script>