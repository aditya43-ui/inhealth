<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script>
    
    $(".input_spirometri").blur(function() {
        $(".tab_spirometri tbody tr").each(function() {
            
            var prediksi = unformatNumber($(this).find(".prediksi").val());
            var bro_nilai = null;
            var nobro_nilai = null;
            
            if (!$(this).hasClass(".row_fev1_fvc")) {
                $(this).find(".bro_persen").val("");
            }
        
            if (prediksi == null || prediksi == "" || prediksi == 0) {
                return;
            }
            
            prediksi = parseFloat(prediksi);
            
            
            if ($(this).find(".bro_nilai").val().trim() != "") {
                bro_nilai = parseFloat(unformatNumber($(this).find(".bro_nilai").val()));
                $(this).find(".bro_persen").val(formatFloat2(bro_nilai * 100 / prediksi));
            }
            
        });
        
        hitungHasilTes();
    });
    
    function hitungHasilTes() {
        var fvc = parseFloat(unformatNumber($("#SpirometriT_fvc_persen").val()));
        var fev1 = parseFloat(unformatNumber($("#SpirometriT_fev1_persen").val()));
        var fev1_fvc = (fev1 * 100 / fvc);
        
        console.log("Hasil", fvc, fev1, fev1_fvc);
        
        $("#SpirometriT_fev1_fvc_persen").val(formatFloat2(fev1_fvc));
        
        var hasil = "Normal";
        
        var hasil_no = [];
        var hasil_string = "";
        
        if (fvc <= 80) {
            hasil_string = "Restriktif ";
            if (fvc >= 60) {
                hasil_string += "Ringan";
            } else if (fvc >= 30) {
                hasil_string += "Sedang";
            } else {
                hasil_string += "Berat";
            }
            hasil_no.push(hasil_string);
        }
            
        hasil_string = "";    
            
        if (fev1_fvc <= 80) {
            hasil_string += "Obstruktif ";
            if (fev1_fvc >= 60) {
                hasil_string += "Ringan";
            } else if (fev1_fvc >= 30) {
                hasil_string += "Sedang";
            } else {
                hasil_string += "Berat";
            }
            hasil_no.push(hasil_string);
        }
        
        if (hasil_no.length > 0) {
            hasil = hasil_no.join(" / ");
        }
        
        
        $("#SpirometriT_test_spirometri").val(hasil);
    }
    
    function hitungTestSpirometri() {
        if ($("#pakai_bronkhodilator").is(":checked")) {
            $(".radio_reversibilitas").prop("disabled", false);
            $("#SpirometriT_test_reversibilitas_nilai").prop("readonly", false);
        } else {
            $(".radio_reversibilitas").prop("disabled", true);
            $("#SpirometriT_test_reversibilitas_nilai").prop("readonly", true).val("");
            
        }
    }
    
    function setdelete(id) {
         var id = id;
          window.parent.myConfirm('Apa Anda akan menghapus data ini?','Perhatian!',function(r){
            if (r){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('setDelete'); ?>',
                data: {id:id},
                dataType: "json",
                    success:function(data){
                        if(data.status == true){
                            myAlert(data.pesan);	
                            window.location.reload();                        
                        }else{
                            myAlert(data.pesan);	
                        }	
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	    }); 
            }
            });
    }
    
    $(document).ready(function() {
        hitungTestSpirometri();
    });
    
</script>
