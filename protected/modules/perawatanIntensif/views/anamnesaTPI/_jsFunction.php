<script>
    
    function cekCeklisRadio() {
        $(".panel_radio_group").each(function() {
            var obj = $(this);
            
            console.log("Kick");
            
            var v = $(obj).find(".panel_radio_ceklis:checked").val();
            if ($(obj).find(".panel_radio_text").data("ceklis") != v) {
                $(obj).find(".panel_radio_text").val("").prop("disabled", true);
            } else {
                $(obj).find(".panel_radio_text").prop("disabled", false);
            }
        });
    }
    
    $(document).ready(function() {
        $(".panel_radio_ceklis").on('click', cekCeklisRadio);
        
        cekCeklisRadio();
    });
    
</script>