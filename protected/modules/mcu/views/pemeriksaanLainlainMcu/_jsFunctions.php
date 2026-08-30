<script>
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
     $(document).ready(function(){
        $(".mata").find('input:checkbox').click(function() {
             var cek_lis = $(this).prop('checked');
            $(".mata").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }   
        });
    });
</script>
