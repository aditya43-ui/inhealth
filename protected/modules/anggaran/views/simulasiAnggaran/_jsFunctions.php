<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function loadRowDetail(){
	var periode = $('#konfiganggaran_id').val();
	var unitkerja = $('#unitkerja_id').val();
	var anggaran = $('#anggaran_id').val();
	if((periode != '')&&(unitkerja != '')&&(anggaran != '')){
		$('#table-simulasianggaranpengeluaran').addClass('animation-loading');
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('LoadRowDetail'); ?>',
			data: {anggaran:anggaran,periode:periode,unitkerja:unitkerja},//
			dataType: "json",
			success:function(data){
				$('#table-simulasianggaranpengeluaran > tbody > tr').detach();
				$('#table-simulasianggaranpengeluaran > tbody > th').detach();
				$('#kenaikan_keseluruhan').val(0);
				if(data.form == ''){	
					data.form = '<th colspan="6"><i>Data tidak ditemukan</i></th>'
				}
				$('#table-simulasianggaranpengeluaran > tbody').append(data.form);
				$("#table-simulasianggaranpengeluaran .integer").maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
				);
				$("#table-simulasianggaranpengeluaran").removeClass("animation-loading");
				tombolhitung();
			},
			 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}else{	
		myAlert("Periode Anggaran, Unit Anggaran dan Anggaran harus terisi");
		$('#table-simulasianggaranpengeluaran > tbody > tr').detach();
		return false;
	}
}

function hitungrupiah(obj){
	//unformatNumberSemua();
	$(obj).parents('tr').find("input[name$='[kenaikan_rupiah]']").addClass('animation-loading-1');
	$(obj).parents('tr').find("input[name$='[total_nilaianggaran]']").addClass('animation-loading-1');
	$('#table-simulasianggaranpengeluaran > tbody > tr').each(function(){
		var nilai_anggaran = parseInt(unformatNumber($(this).find('input[name$="[nilai_anggaran]"]').val()));
		var kenaikan_persen = parseInt(unformatNumber($(this).find('input[name$="[kenaikan_persen]"]').val()));
		$(this).find("input[name$='[kenaikan_rupiah]']").val(formatNumber(parseInt((kenaikan_persen/100)*nilai_anggaran))); // rupiah
		var res_rupiah = parseInt(unformatNumber($(this).find('input[name$="[kenaikan_rupiah]"]').val()));
		$(this).find("input[name$='[total_nilaianggaran]']").val(formatNumber(nilai_anggaran+res_rupiah));
	});
	setTimeout(function(){
		$(obj).parents('tr').find("input[name$='[kenaikan_rupiah]']").removeClass('animation-loading-1');
		$(obj).parents('tr').find("input[name$='[total_nilaianggaran]']").removeClass('animation-loading-1');
	},300);
	//formatNumberSemua();
}
function hitungpersen(obj){
	//unformatNumberSemua();
	$(obj).parents('tr').find("input[name$='[kenaikan_persen]']").addClass('animation-loading-1');
	$(obj).parents('tr').find("input[name$='[total_nilaianggaran]']").addClass('animation-loading-1');
	$('#table-simulasianggaranpengeluaran > tbody > tr').each(function(){
		var nilai_anggaran = parseInt(unformatNumber($(this).find('input[name$="[nilai_anggaran]"]').val()));
		var kenaikan_rupiah = parseInt(unformatNumber($(this).find('input[name$="[kenaikan_rupiah]"]').val()));
		$(this).find("input[name$='[kenaikan_persen]']").val(formatNumber(parseInt((100/nilai_anggaran)*kenaikan_rupiah))); // persen
		$(this).find("input[name$='[total_nilaianggaran]']").val(formatNumber(nilai_anggaran+kenaikan_rupiah));
	});
	setTimeout(function(){
		$(obj).parents('tr').find("input[name$='[kenaikan_persen]']").removeClass('animation-loading-1');
		$(obj).parents('tr').find("input[name$='[total_nilaianggaran]']").removeClass('animation-loading-1');
	},300);
	//formatNumberSemua();
}

function hitungsemua(){
	var kenaikan_keseluruhan = $('#kenaikan_keseluruhan').val();
	$('#table-simulasianggaranpengeluaran > tbody > tr').each(function(){
		var kenaikan_persen = parseInt($(this).find('input[name$="[kenaikan_persen]"]').val(kenaikan_keseluruhan));
		hitungrupiah($(this).find("input[name$='[kenaikan_rupiah]']"));
	});
}

function tombolhitung(){
	var jml_program = $('#table-simulasianggaranpengeluaran tbody tr').length;
	if(jml_program <= 1){
		$('#tombolhitung').attr('disabled',true);
	}else{
		$('#tombolhitung').attr('disabled',false);
	}
}

function tombolSimpan(){
	if(requiredCheck($("simulasianggaran-form"))){
        var jmlsimulasi = $('#table-simulasianggaranpengeluaran tbody tr').length;
		if (jmlsimulasi == 0){
                myAlert('Tabel simulasi tidak boleh kosong!');
		}else{
            $('#simulasianggaran-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(unformatNumber($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(unformatNumber($(this).val()));
        });
    }
    return false;
}

function print(caraPrint)
{
    window.open('<?php echo $this->createUrl('print'); ?>&nosimulasianggaran=<?php echo isset($_GET['nosimulasianggaran'])?$_GET['nosimulasianggaran']:''; ?>&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$( document ).ready(function(){
	tombolhitung();
});
</script>
