<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<script type="text/javascript">

	
	function removeDataRekening(obj)
	{
		$(obj).parent().parent('tr').detach();
	}

	function getDataRekening(params)
	{
		$("#tblInputRekening > tbody").find('tr').detach();
		$.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByJnsPenerimaan'); ?>', {jenispenerimaan_id: params},
		function (data) {
			if (data != null) {
				$("#tblInputRekening > tbody").append(data.replace());
				renameRowRekening();
			}
		}, "json");
	}

	function renameRowRekening()
	{
		var idx = 0;
		$("#tblInputRekening > tbody").find('tr').each(
				function ()
				{
					unMaskMoneyInput(this);
					maskMoneyInput(this);
					$(this).find('input').each(
							function ()
							{
								/*
								 if($(this).find('class^="currency"'))
								 {
								 this.value = formatNumber(this.value)
								 }
								 */

								var name_field = $(this).attr('name');
								var id_field = $(this).attr('id');
								$(this).attr('name', name_field.replace('99', idx));
								$(this).attr('id', id_field.replace('99', idx));

							}
					);
					idx++;
				}
		);
	}

	function print(caraPrint)
	{
		if ($('#url').val() == '') {
			myAlert('Lakukan transaksi terlebih dahulu dengan benar!');
			return false;
		}
		window.open($('#url').val() + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
	}

	function unMaskMoneyInput(tr)
	{
		$(tr).find('input.currency:text').unmaskMoney();
	}

	function maskMoneyInput(tr)
	{
		$(tr).find('input.currency:text').maskMoney(
				{
					"symbol": "Rp. ",
					"defaultZero": true,
					"allowZero": true,
					"decimal": ".",
					"thousands": ",",
					"precision": 0
				}
		);
	}
    
    $(document).ready(function() {
        setValidasiCekDisabled("#guinvasetlain-t-form", function() {
            return true;
        });
    });
</script>