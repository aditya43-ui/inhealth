<?php
    $konfig = KonfigsystemK::model()->find();
?>
<script type="text/javascript">
    
    function refreshLoket(loketId){
        const formloket = $("div[data-loket-id='"+loketId+"']");
        const nomor = formloket.attr("data-loket-ke");
        formloket.addClass("animation-loading");
        
        $.ajax({
            type:'GET',
            url:'<?php echo $this->createUrl('refreshLoket'); ?>',
            data: {
                loket:loketId,
                nomor
            },
            dataType: "json",
            success:function(data){
                if (data.html != ''){
                    formloket.replaceWith(data.html);
                }
                formloket.removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    $(document).ready(function(){
        <?php 
        if($konfig->is_nodejsaktif){ 
            if (!empty($konfig->nodejs_host)){
        ?>
                var chatServer='<?php echo 	$konfig->nodejs_host; ?>';
                var chatPort='<?php echo 	$konfig->nodejs_port; ?>';                                        
        <?php
            }else{
        ?>
                var chatServer='localhost';
                var chatPort='3000';
        <?php
            }
        }
        ?>	
                
        socket = io.connect(chatServer+':'+chatPort,{secure: true});
        socket.emit('subscribe', 'infoAntrian');
        socket.on('infoAntrian', function(data){                
            if (data.panggil == 2 || data.panggil == 1 || data.panggil == 3) { 
                console.log(data.arr);
                refreshLoket(data.arr.loketId);
            }            
        });
        
        $("div[data-loket-id]").each(function(){
            refreshLoket($(this).attr("data-loket-id"));
        });
        
    }); 
    
    
</script>