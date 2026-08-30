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
</script>
