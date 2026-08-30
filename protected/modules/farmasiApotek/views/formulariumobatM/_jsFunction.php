<script type="text/javascript">
    function hapusBaris(obj) {
        $(obj).parent().parent('tr').detach();
    }

    function submitDiagnosaobat(){
        var obatalkes_id = $('#obatalkes_id').val();
        var jenisformularium = $('#jenisformularium').val();
        var carabayar_id = $('#carabayar_id').val();
        var penjamin_id = $('#penjamin_id').val();
        var is_aktif = $('#is_aktif').prop('checked');
        if(obatalkes_id == '' && jenisformularium == '' && carabayar_id == '' && penjamin_id == ''){
            myAlert('Silakan lengkapi data terlebih dahulu!');
        }else{
            $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetTabel'); ?>', {
                obatalkes_id:obatalkes_id, 
                jenisformularium:jenisformularium,
                carabayar_id:carabayar_id,
                penjamin_id:penjamin_id,
                is_aktif:is_aktif,
            },
            function(data){
                $('#tabelKasuspenyakitobat tbody').append(data.return);
                renameInputRow($('#tabelKasuspenyakitobat'));
                clearData();
            }, "json");
        }   
    }

    function renameInputRow(obj_table){
        var row = 0;	
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find('.nourut').val(row+1);
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

    function setSimpan() {
        $('#dataawal-t-form').submit();
    }

    function clearData()
    {
        var obatalkes_id = $('#obatalkes_id').val("");
        var obatalkes = $('#obatalkes').val("");
        var jenisformularium = $('#jenisformularium').val("");
        var carabayar_id = $('#carabayar_id').val("");
        var penjamin_id = $('#penjamin_id').val("");
    }

    $(document).ready(function() {
		var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');		
		var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');		
		/**
		* multi select cara bayar dan penjamin
		 */
		
		jQuery(cara).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
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
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true
		}).hide();
    });
</script>