<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.numbersOnly',
        'config' => array(
            'defaultZero' => true,
            'allowZero' => true,
            'decimal' => ',',
            'thousands' => '.',
            'precision' => 0,
        )
    ));
?>

<script>
function inputBahanMakanan(){
		unformatNumberSemua();
        var id = $('#idBahan').val();
        var qty= $('#qty').val();
        var ukuran = $('#ukuran').val();
        var merk = $('#merk').val();
        var satuanbahan = $('#satuanbahan').val();
        if (jQuery.isNumeric(id)){
            $.post('<?php echo $urlBahan; ?>',{id:id, qty:qty,ukuran:ukuran,merk:merk, satuanbahan:satuanbahan},function(data){
                $('#tableBahanMakanan tbody').append(data);		
		renameInputRowBahanMakanan('tableBahanMakanan');
                hitungSemua();
                hitungTotalDiscount();	    	
                $("#tableBahanMakanan tbody tr:last .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
                $("#tableBahanMakanan tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
                $("#tableBahanMakanan tbody tr:last .satuanbahan").val(satuanbahan);
				$("#tableBahanMakanan tbody tr:last .tanggal").datepicker(
					jQuery.extend(
						{showMonthAfterYear:true},
						jQuery.datepicker.regional['id'],
						{
							'dateFormat':'dd M yy',
							'changeYear':true,
							'changeMonth':true,
							'showAnim':'fold',
							'yearRange':'-0y:+10y'
						}
					)
				);
				formatNumberSemua();
				$("#tableBahanMakanan tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
				$("#qty, #satuanbahan, #namaBahan, #isBahan, #ukuran, #merk").val("");
            });
        }
        else{
            myAlert('Isi Data dengan Benar');
        }
    }
    
    function hitungSemua(){
        unformatNumberSemua();
        var value = 0;
        var totaldisk = 0;
        var totalppn = 0;
        var totalpph = 0;
        var totalHarganetto = 0;
        
        $('.noUrut').each(function(){
             var netto = parseFloat($(this).parents('tr').find('input[name$="[harganettobahan]"]').val());
                var jml = parseFloat($(this).parents('tr').find('input[name$="[qty_terima]"]').val());
                var persendiskon = parseFloat($(this).parents('tr').find('input[name$="[persendiscount]"]').val());
                var persenppn = parseInt($(this).parents('tr').find('input[name$="[persenppn]"]').val());
                var persenpph = parseFloat($(this).parents('tr').find('input[name$="[persenpph]"]').val());
                
                var jmlQty = (netto*jml);
                if (jmlQty > 0){
                    jmlQty = parseFloat(jmlQty.toFixed(2));
                }
                
                var jmldisk = ((jmlQty * persendiskon)/100);
                if (jmldisk > 0){
                    jmldisk = parseFloat(jmldisk.toFixed(2));
                }
                
                var jmlppn = (((jmlQty - jmldisk)*persenppn)/100);
                if (jmlppn > 0){
                    jmlppn = parseFloat(jmlppn.toFixed(2));
                }
                
                var jmlpph = (((jmlQty - jmldisk)*persenpph)/100);
                if (jmlpph > 0){
                    jmlpph = parseFloat(jmlpph.toFixed(2));
                }
                
                var totalAll = (jmlQty - jmldisk + jmlppn - jmlpph);
                if (totalAll > 0){
                    totalAll = parseFloat(totalAll.toFixed(2));
                }

                $(this).parents('tr').find('.subNetto').val(totalAll);
                $(this).parents('tr').find('input[name$="[harganettobhn]"]').val(netto);
                $(this).parents('tr').find('input[name$="[jmldiscount]"]').val(jmldisk);
                $(this).parents('tr').find('input[name$="[jmlhargappn]"]').val(jmlppn);
                $(this).parents('tr').find('input[name$="[jmlhargapph]"]').val(jmlpph);
            
                value += totalAll;
                totaldisk += jmldisk;
                totalppn += jmlppn;
                totalpph += jmlpph;
                totalHarganetto += jmlQty;
        });
        $("#<?php echo CHtml::activeId($model, 'totalharganetto'); ?>").val(totalHarganetto);
        $(".total_semua").val(value);
        $("#<?php echo CHtml::activeId($model, 'totaldiscount'); ?>").val(totaldisk);
        $("#<?php echo CHtml::activeId($model, 'biayapajak'); ?>").val(totalppn);
        $("#<?php echo CHtml::activeId($model, 'biayapajakpph'); ?>").val(totalpph);
        $("#<?php echo CHtml::activeId($model, 'totalkeseluruhan'); ?>").val(value);
        
        
        formatNumberSemua();
    }
	   	
    function hitung(obj){
		//unformatNumberSemua();
        var netto = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[harganettobahan]"]').val()));
        var jml = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[qty_terima]"]').val()));
        var persendiskon = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[persendiscount]"]').val()));
        var persenppn = parseInt(unformatNumber($(obj).parents('tr').find('input[name$="[persenppn]"]').val()));
        var persenpph = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[persenpph]"]').val()));
        
	var jmlQty = (netto*jml);
        var jmldisk = ((jmlQty * persendiskon)/100);
        var jmlppn = (((jmlQty - jmldisk)*persenppn)/100);
        var jmlpph = (((jmlQty - jmldisk)*persenpph)/100);
        
        var totalAll = (jmlQty - jmldisk + jmlppn + jmlpph);
        
        $(obj).parents('tr').find('.subNetto').val(formatNumber(totalAll));
        $(obj).parents('tr').find('input[name$="[harganettobhn]"]').val(formatNumber(netto));
        $(obj).parents('tr').find('input[name$="[jmldiscount]"]').val(formatNumber(jmldisk));
        $(obj).parents('tr').find('input[name$="[jmlhargappn]"]').val(formatNumber(jmlppn));
        $(obj).parents('tr').find('input[name$="[jmlhargapph]"]').val(formatNumber(jmlpph));
		
		hitungSemua();
     //   hitungTotalDiscount();
		//formatNumberSemua();
		unformatNumberSemua();
		formatNumberSemua();
    }
    
    function hapus(obj) {
        $(obj).parents('tr').remove();
        hitungSemua();
    }
    
    function hitungTotal(obj){
		unformatNumberSemua();
        var netto = $('#TerimabahandetailT_harganettobhn').val();
        var jml = $(obj).val();
        $(obj).parents('tr').find('.subNetto').val(netto*jml);
        hitungSemua();
        hitungTotalDiscount();
		formatNumberSemua();
    }
    
    function hitungTotalDiscount(){
		//unformatNumberSemua();
        var discountPersen = $('#discountpersen').val();
        var totaldiscount = 0;
            if (jQuery.isNumeric(discountPersen)){
                $('.discount').each(function(){
                    if ($(this).parents('tr').find('.cekList').is(':checked')){
                        var subnetto = parseFloat(unformatNumber($(this).parents('tr').find('.subNetto').val()));
                        discount = subnetto*discountPersen/100;
						
						console.log(subnetto, discountPersen);
                        $(this).val(discount);
                        totaldiscount+=discount;
                    }
                });
            }
            else{
                $('.discount').each(function(){
                    var discount = parseFloat($(this).val());
                    if ($(this).parents('tr').find('#checkList').is(':checked')){
                        totaldiscount+=discount;
                    }
                });      
            }
	//	formatNumberSemua();
        $('#GZTerimabahanmakan_totaldiscount').val(formatNumber(totaldiscount));
    }
	
	function renameInputRowBahanMakanan(obj_table){
		var row = 0;
		$('#'+obj_table).find("tbody > tr").each(function(){
		$(this).find("#noUrut").val(row+1);
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
	

	function printData()
	{
		var terimabahanmakan_id = "<?php echo $model->terimabahanmakan_id?>";
		window.open("<?php echo $this->createUrl('detailPenerimaan') ?>&id="+terimabahanmakan_id+"&print=1","",'location=_new, width=1024px');
	}
	
	$(document).ready(function() {
		renameInputRowBahanMakanan('tableBahanMakanan');
                hitungSemua();
//		hitung();
		setTimeout(function() {
			$("#tableBahanMakanan tbody tr .tanggal").each(function() {
				$(this).datepicker(
					jQuery.extend(
						{showMonthAfterYear:true},
						jQuery.datepicker.regional['id'],
						{
							'dateFormat':'dd M yy',
							'changeYear':true,
							'changeMonth':true,
							'showAnim':'fold',
							'yearRange':'-0y:+10y'
						}
					)
				);
			});
		}, 500);
		
		$("form").submit(function(){
			supplier = $("#<?php echo CHtml::activeId($model, 'supplier_id'); ?>").val();
			jumlah = 0;
			if (!jQuery.isNumeric(supplier)){
				myAlert("<?php echo CHtml::encode($model->getAttributeLabel('supplier_id')); ?> harus diisi!");
				return false;
			}
			$(".cekList").each(function(){
				if ($(this).is(":checked")){
					jumlah++;
				}
			});

			if (jumlah < 1){
				myAlert("Pilih Nama Bahan Makanan yang akan diajukan!");
				return false;
			}
                        $('.integer-decimal, .integer2, float2').each(function(){
                        $(this).val(unformatNumber($(this).val()));
                    });
		});
		
		$(".alphanumber").keyup(function()
		{
			$(this).val($(this).val().replace(/[^\w\s]/gi, ''));
		});
	});
</script>