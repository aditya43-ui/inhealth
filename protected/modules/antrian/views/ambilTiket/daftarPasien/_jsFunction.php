<script type="text/javascript">
    
    const setFormJenisKunjungan = (value) => {
        value = value.toLowerCase();
        
        if (value == 'sekarang'){
            $(".byclick[data-id-form='form-dokter']").trigger('click');
        }
    }
    
    $(document).ready(function(){
        let formId = '';                
        
        $(".byclick").click(function(){
            $(".form-pilihan").addClass("hide");
            $(".byclick").removeClass("active");
            
            formId = $(this).attr("data-id-form");            
            $("#"+formId).removeClass("hide");
            $(this).addClass("active");                        
        });
    });
</script>