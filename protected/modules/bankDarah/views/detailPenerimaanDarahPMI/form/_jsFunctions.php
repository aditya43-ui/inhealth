<script>

    function setDetailPenerimaan(penerimaandarahpmi_id) {
        $.post('<?php echo $this->createUrl('SetLoadDetailPenerimaan'); ?>', {penerimaandarahpmi_id: penerimaandarahpmi_id}, function(data) {
            $("#detail > tbody").html('');
            $("#detail > tbody").html(data.row);
            $('#detail > tbody > tr').each(function(){
                jQuery('input[name$="[tgl_aftap]"]').datepicker(
                    jQuery.extend(
                        {
                            showMonthAfterYear: false,
                            /*onSelect: function(date) {
                                
                            },*/
                        },
                        jQuery.datepicker.regional['id'],
                        {
                            'dateFormat': 'dd M yy',
                            'showSecond': false,
                            'timeOnlyTitle': 'Pilih Waktu',
                            'timeFormat': 'hh:mm:ss',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                            'yearRange': '-80y:+20y',
                            
                        }
                    ),
                );
                $('input[name$="[tgl_aftap]"]').each(function () {
                    var obj = $(this);
                    $(this).parent().find(".add-on").click(function () {
                        $(obj).focus();
                    });
                });
                jQuery('input[name$="[tgl_kadaluarsa]"]').datepicker(
                    jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['id'],
                        {
                            'dateFormat': 'dd M yy',
                            'showSecond': false,
                            'timeOnlyTitle': 'Pilih Waktu',
                            'timeFormat': 'hh:mm:ss',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                            'yearRange': '-80y:+20y',
                        }
                    )
                    );
                $('input[name$="[tgl_kadaluarsa]"]').each(function () {
                    var obj = $(this);
                    $(this).parent().find(".add-on").click(function () {
                        $(obj).focus();
                    });
                });
            });
        }, 'json');
    }
    
    function cekNoKantongDarah(obj){
        nomor = $(obj).val();
        no_urut = $(obj).parents('tr').find(".no_urut").val();
        ada = 0;
        jenis = $(obj).parents('tr').find(".jeniskomponendarah_id").val();
        //jeniskomponendarah_id = "";
        jeniskomponendarah_id = new Array();
        $('#detail > tbody > tr').each(function(){
            nomorTemp = $(this).find(".no_kantongdarah").val();
            if(nomor == nomorTemp && nomor !== ""){
                
                if(no_urut != $(this).find(".no_urut").val()){
                    //jeniskomponendarah_id = $(this).find(".jeniskomponendarah_id").val();
                    jeniskomponendarah_id.push($(this).find(".jeniskomponendarah_id").val());
                }
            }
        });
        for(var index=0;index<jeniskomponendarah_id.length;index++){
            if(jenis == jeniskomponendarah_id[index]){
                myAlert("No. Kantong Darah tidak boleh sama");
                $(obj).val('');
                return false;
            }
        }
    }
    
    function cekAllTglAftap(){
        if ($("#cekTglAftap").is(":checked")) {
            tgl_aftap = "";
            x = 1;
            $('#detail > tbody > tr').each(function(){
                if(x==1){
                    tgl_aftap = $(this).find('input[name$="[tgl_aftap]"]').val();
                }
                x++;
            });
            $(".tgl_aftap").val(tgl_aftap);
        }else{
            tgl_aftap = $(".tgl_aftap").val();
            x = 1;
            $('#detail > tbody > tr').each(function(){
                if(x==1){
                    $(this).find('input[name$="[tgl_aftap]"]').val(tgl_aftap);
                }else{
                    $(this).find('input[name$="[tgl_aftap]"]').val("");
                }
                x++;
            });
        }
    }
    
    function cekAllTglKadaluarsa(){
        if ($("#cekTglExp").is(":checked")) {
            tgl_kadaluarsa = "";
            x = 1;
            $('#detail > tbody > tr').each(function(){
                if(x==1){
                    tgl_kadaluarsa = $(this).find('input[name$="[tgl_kadaluarsa]"]').val();
                }
                x++;
            });
            $(".tgl_kadaluarsa").val(tgl_kadaluarsa);
        }else{
            tgl_kadaluarsa = $(".tgl_kadaluarsa").val();
            x = 1;
            $('#detail > tbody > tr').each(function(){
                if(x==1){
                    $(this).find('input[name$="[tgl_kadaluarsa]"]').val(tgl_kadaluarsa);
                }else{
                    $(this).find('input[name$="[tgl_kadaluarsa]"]').val("");
                }
                x++;
            });
        }
    }

    $(document).ready(function() {
        <?php 
        if(isset($_GET['detil']) && !isset($_GET['sukses'])){ //ini berarti transaksi dari menu informasi
            if(isset($_GET['penerimaandarahpmi_id']) && !empty($_GET['penerimaandarahpmi_id'])){
            ?>
                setDetailPenerimaan('<?=$_GET['penerimaandarahpmi_id']?>');
            <?php
            }
        }
        ?>
    });
</script>