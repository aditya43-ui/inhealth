<div class="white-container">
    <iframe src="" id="iframe_dashboard" style="width: 100%; height: 100%;" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe>
    <?php echo $this->renderPartial('_jsFunctions'); ?>
</div>
<div id="dialog" title="Perhatian!" style="display:none" style="min-width: 600px;">
    <div id="msgstr"></div>
</div>

<script>
   $(document).ready(function(){
        $.ajax({
            type:'GET',
            url:'<?php echo $this->createUrl('PegawaiM/GetMasaAktifPegawai'); ?>',
            success:function(data){
                // console.log(data.str)
                json = JSON.parse(data)
                // // myAlert(data.str)
                // console.log(json.show)
                if(json.show){
                    // console.log(data.str)
                    $("#dialog").dialog();

                    $('#msgstr').append(json.table)
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    });
</script>