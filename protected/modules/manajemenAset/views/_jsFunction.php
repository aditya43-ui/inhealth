<script>
    /**
     * Mengecek element bernilai kosong dengan label yg memiliki class "required"
     * @param {type} <form>
     * @returns {Boolean}
     */
    function cekDisabled(obj) {
        var kosong = 0;
        $(obj).find('input,select,textarea').each(function () {
            if ($(this).parents(".control-group").find("label").hasClass('required') === true) {
                $(this).parents(".control-group").removeClass("error").removeClass("success");
            }
        });
        $(obj).find('input,select,textarea').each(function () {
            if ($(this).parents(".control-group").find("label").hasClass('required') === true || $(this).hasClass('required')) {
                if (($(this).val() === "")) {
                    if ($(this).is(":hidden")) { //untuk element type:hidden 
                        var radio_checked = false;
                        $(this).parent().find(".radio").each(function () { //mengecek element radio button
                            if ($(this).find("input").is(":checked")) {
                                radio_checked = true;
                            }
                        });
                        if (radio_checked == false) {
//                            $(this).parents(".control-group").addClass("error");
//                            $(this).addClass("error");
                            kosong++;
                        } else {
//                            $(this).parents(".control-group").removeClass("error");
//                            $(this).removeClass("error");
                        }
                    } else {
//                        $(this).parents(".control-group").addClass("error");
//                        $(this).addClass("error");
                        kosong++;
                    }
                } else {
                    $(this).parents(".control-group").removeClass("error");
                    $(this).removeClass("error");
                }
            }
        });
        if (kosong > 0) {
            $(obj).find(".submit").prop('disabled', true);
        } else {
            <?php if(!isset($_GET['sukses'])){?>
                    
            $(obj).find(".submit").prop('disabled', false);
            
            <?php }?>
        }
    }
</script>