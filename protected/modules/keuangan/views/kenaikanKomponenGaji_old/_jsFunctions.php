<script type="text/javascript">
	function hitungPersentase(){
		var persentase_kenaikan = $('#persentase_kenaikan').val();
		$('#tblInputKomponenGaji tbody tr').each(function(){
			var jumlah = $(this).find('input[name$="jumlah"]').val();
		// hitung jumlah kenaikan
            jumlah_kenaikan = parseInt(persentase_kenaikan) * parseInt(jumlah) / 100;
			$(this).find('input[name$="jml_kenaikan"]').val(formatNumber(jumlah_kenaikan));
			$(this).find('input[class$="jml_kenaikan"]').val(jumlah_kenaikan);
		// hitung total (jumlah awal + jumlah kenaikan)
            total = parseInt(jumlah) + parseInt(jumlah_kenaikan);
			$(this).find('input[name$="total"]').val(formatNumber(total));
			$(this).find('input[class$="total"]').val(total);
        });
	}
</script>