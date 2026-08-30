<?php 
    $baseUrl = Yii::app()->createUrl("/");
    $gets = '';
?>
<script type ='text/javascript'>

    function submitLogin(id)
    {
        $('#loginform .form-actions').addClass('animation-loading-1');
        $.ajax({
            url: '<?php echo $this->createUrl('ajaxLogin') ?>',
            data: $('#loginform').serialize(),
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if(data.pesan != ''){
                    myAlert(data.pesan);
                }
                if(data.sukses == 1){
                    if(id == 'detail'){
                        window.location.href = "<?php echo $baseUrl;?>?r="+data.urlPenawaran;
                    }else{
                        $('#logindialog').dialog('close');
                        var frameObj = $('[name="iframeDetail"]');
                        $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+data.urlPenawaran);
                        $('#dialogDetail').dialog('open');
                        $("#password").val("");
                    }
                }
                $('#loginform .form-actions').removeClass('animation-loading-1');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                $('#loginform .form-actions').removeClass('animation-loading-1');
            },
            cache: false
        });
    }
    
    function submitLoginDetail()
    {
        $('#logindet .form-actions').addClass('animation-loading-1');
        $.ajax({
            url: '<?php echo $this->createUrl('ajaxLoginDetail') ?>',
            data: $('#logindet').serialize(),
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if(data.pesan != ''){
                    myAlert(data.pesan);
                }
                if(data.sukses == 1){
                    $('#logindetail').dialog('close');
                    window.location = "<?php echo $baseUrl;?>?r="+data.urlDetail;
                    $("#password").val("");
                }
                $('#logindet .form-actions').removeClass('animation-loading-1');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                $('#logindet .form-actions').removeClass('animation-loading-1');
            },
            cache: false
        });
    }
    
    document.getElementById("PenawaranpenyediaT_penawaranpenyedia_file").onchange = function () {
        if(this.files[0].size>3000000){
            myAlert("ukuran maks : 3Mb");
            $("#PenawaranpenyediaT_penawaranpenyedia_file").attr("src","blank");
            $('#PenawaranpenyediaT_penawaranpenyedia_file').wrap('<form>').closest('form').get(0).reset();
            $('#PenawaranpenyediaT_penawaranpenyedia_file').unwrap();     
            return false;
        }
        if(this.files[0].type.indexOf("pdf")==-1){
            myAlert("Tipe file harus PDF");
            $("#PenawaranpenyediaT_penawaranpenyedia_file").attr("src","blank");
            $('#PenawaranpenyediaT_penawaranpenyedia_file').wrap('<form>').closest('form').get(0).reset();
            $('#PenawaranpenyediaT_penawaranpenyedia_file').unwrap();         
            return false;
        }   
    };
    
</script>