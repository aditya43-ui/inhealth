<script type="text/javascript">
	/**
	 * menentukan pemilihan table / model
	 * @returns {undefined}
	 */
	function setTableModel(){
		var pattern = $("select[name$='[pattern]']").val();
		if(pattern === 'dao'){
			$("select[name$='[table_uji]']").parents('.control-group').show();
			$("select[name$='[model_uji]']").parents('.control-group').hide();
		}else{
			$("select[name$='[model_uji]']").parents('.control-group').show();
			$("select[name$='[table_uji]']").parents('.control-group').hide();
		}
		
	}
	setTableModel();
	/**
	 * mulai pengujian
	 * @returns {undefined}
	 */
	function mulaiPengujian(){
		var method = $("#dataForm_method").val();
		var type = '';
		var data = '';
		if(method == 'ajaxget'){
			type = 'GET';
			data = $("form").serialize();
		}else if(method == 'ajaxpost'){
			type = 'POST';
			data = {
				'dataForm[method]':$("select[name$='[method]']").val(),
				'dataForm[refreshinterval]':$("input[name$='[refreshinterval]']").val(),
				'dataForm[pattern]':$("select[name$='[pattern]']").val(),
				'dataForm[table_uji]':$("select[name$='[table_uji]']").val(),
				'dataForm[model_uji]':$("select[name$='[model_uji]']").val(),
			}
		}
		var refresh = $("input[name$='[refreshinterval]']").val() * 1000;
		//$("#btn_mulai").parent().addClass("animation-loading");
		$("#btn_mulai").addClass("animation-loading");
		$("#load_data").addClass("animation-loading");
		$("#load_data").show();
			
		$.ajax({
			type:type,
			url:'<?php echo $this->createUrl('AjaxPengujian'); ?>',
			data: data,
			dataType: "json",
			success:function(data){
				console.log(data);
				if(refresh > 0) {
					setTimeout(function(){mulaiPengujian();},refresh);
				}else{
					//$("#btn_mulai").parent().removeClass("animation-loading");
					$("#btn_mulai").removeClass("animation-loading");
					$("#load_data").removeClass("animation-loading");
					$("#load_data").hide();
					$("input[name$='[refreshinterval]']").val(<?php echo $dataForm['refreshinterval'] ?>);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
			
	}
	/**
	 * hentikan pengujian
	 */
	function hentikanPengujian(){
		$("input[name$='[refreshinterval]']").val(0);
		
	}
</script>