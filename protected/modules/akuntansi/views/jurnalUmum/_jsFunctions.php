<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js'); ?>

<script type="text/javascript">
    
    var periodeID = <?php echo json_encode($redirect[0]); ?>;
    var urlRedirect = "<?php echo $redirect[1]; ?>";
    
    /*
    function cekSessionPeriode()
    {
        if(periodeID.length > 1 || periodeID.length == 0)
        {
            myAlert('Periode tidak valid, silakan cek kembali!');
            window.location.href = urlRedirect;
        }
    }
    */
    // cekSessionPeriode();

	function getDataRekening(rekening1_id,rekening2_id,rekening3_id,rekening4_id,rekening5_id)
	{
		var jenis_rekening = $("#isJenisRekenig").val();
		if(jenis_rekening != ''){
			$.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getDataRekening');?>', {
				jenis_rekening:jenis_rekening, rekening1_id:rekening1_id, rekening2_id:rekening2_id,rekening3_id:rekening3_id, rekening4_id:rekening4_id, rekening5_id:rekening5_id
			},
				function(data){
					if(data != null){
						$("#tabel-detail > tbody").append(data.form);
						$("#tabel-detail").find('[class*="integer2"]').maskMoney(//input[name*="[ii]"]
							{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
						);
						$("#tabel-detail > tbody > tr:last").find('[class*="integerFloat"]').maskMoney(
							{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
						);
						renameInputRow($("#tabel-detail"));
					}
			}, "json");    
		}else{
			myAlert('Silakan pilih rekening terlebih dahulu!');
		}
	}

	/**
	* rename input grid
	*/ 
	function renameInputRow(obj_table){
		var row = 0;
		$(obj_table).find("tbody > tr").each(function(){
			$(this).find('input[name$="[nourut]"]').val(row+1);
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
	
    function batalInputJurnal(obj)
    {
        myConfirm("Apakah Anda yakin akan membatalkan jurnal?",'Perhatian!',function(r){
            if(r){
                $(obj).parents('tr').detach();
				hitungTotalUang();
            }   
        });
    }
    
    function hitungTotalUang()
    {
        var saldokredit = 0;
        var saldodebit = 0;
        $('#tabel-detail tbody tr').each(
            function(){
                saldodebit += parseFloat(unformatNumber($(this).find('input[name$="[saldodebit]"]').val()));
                saldokredit += parseFloat(unformatNumber($(this).find('input[name$="[saldokredit]"]').val()));
            }
        );
        $("#totalSaldoDebit").val(formatThousandDecimal(saldodebit));
        $("#totalSaldoKredit").val(formatThousandDecimal(saldokredit));
    }
    
    
    var is_submit = false;
    function simpanJurnalUmum(params)
    {
        if (is_submit) return false;
		jenis_simpan = params;
		if(requiredCheck($("#form-jurnal-umum"))){
			var detail = 0;
			var rekening = 0;
			var status = false;
			$('#tabel-detail tbody tr').each(
				function(){
					detail++;
				}
			);
			var totalSaldoDebit = $("#totalSaldoDebit").val();
            var totalSaldoKredit = $("#totalSaldoKredit").val();
			
            if(totalSaldoDebit !== totalSaldoKredit){
                myAlert('Saldo kredit dan debit tidak sama, silakan cek kembali!');
                return false;
				status = true;
            }else if ((totalSaldoDebit == 0) && (totalSaldoKredit == 0)){
				myAlert('Total 0, debit/kredit tidak boleh bernilai 0!');
                return false;
				status = true;
			}
			
			if(detail > 0 && status != true){
                
                is_submit = true;
                
				$('.integer').each(
					function(){
						this.value = unformatNumber(this.value)
					}
				);
				$.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanJurnalUmum');?>', {jenis_simpan:jenis_simpan, data:$('#form-jurnal-umum').serialize()},
					function(data){
						if(data.status == 'ok')
						{
							if(data.action == 'insert')
							{
								myAlert("Simpan data berhasil");
								$("#reseter").click();
								$("#inputJurnalUmum").find("input[name$='[nobuktijurnal]']").val(data.pesan.nobuktijurnal);
                                                                $("#inputJurnalUmum").find("input[name$='[kodejurnal]']").val(data.pesan.kodejurnal);
                                                                $("#inputJurnalUmum").find("input[name$='[rekperiod_id]']").val(data.pesan.rekperiod_id);
								$("#tabel-detail > tbody").find('tr').detach();
                                                                location.reload();
							}else{
								myAlert("Simpan data berhasil");
							}
						}
                        
                        
                        is_submit = false;
				}, "json");
			}else{
				myAlert('Detail jurnal masih kosong!');
			}

			$(".animation-loading").removeClass("animation-loading");
			$("form").find('.float').each(function(){
				$(this).val(formatFloat($(this).val()));
			});
			$("form").find('.integer').each(function(){
				$(this).val(formatInteger($(this).val()));
			});
		}
		return false; 
    }
	
	/**
	 * class integer di unformat 
	 * @returns {undefined}
	 */
	function unformatNumberSemua(){
		$(".integer").each(function(){
			$(this).val(parseInt(unformatNumber($(this).val())));
		});
	}
	/**
	 * class integer di format kembali
	 * @returns {undefined}
	 */
	function formatNumberSemua(){
		$(".integer").each(function(){
			$(this).val(formatInteger($(this).val()));
		});
	}

	/**
	* untuk print alokasi anggaran
	 */
	function print(caraPrint)
	{
		var jurnalrekening_id = '<?php echo isset($model->jurnalrekening_id) ? $model->jurnalrekening_id : null ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&jurnalrekening_id='+jurnalrekening_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
	}

	$(document).ready(function(){
		formatNumberSemua();
		renameInputRow($("#table-postingjurnal"))
	});
        
        
        function setSaldoNormal(obj)
        {
            //$("#AKRekeningakuntansiV_rekening5_nb").val($(obj).val());
            //$.fn.yiiGridView.update('list-rekening-m-grid', {data: $("#list-rekening-m-grid :input").serialize()});
        }
</script>
