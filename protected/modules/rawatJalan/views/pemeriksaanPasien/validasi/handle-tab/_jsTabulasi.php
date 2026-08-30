<script type='text/javascript'>
    
    function approveDialog(){     
        const form = $("#frameDetailDialog").contents().find('form.form-iframe'); 
        let status = true;

        const changed = form.attr("changed");            

        if (changed == 'true'){
            myConfirm("Data belum disimpan. Apakah Anda ingin close dialog ini ?","Perhatian!", function(r){
                if (r){                      
                     status  = true;
                }else{
                     $("#dialogDetailData").dialog("open");
                }
            });               
        }        
    }
    
    const cekSimpanTabulasi = (frameObj, tabObj, dari = 'tab') => {    
        const form = $("#frame").contents().find('form.form-iframe');       
        const active = $("#tab-periksa").find("li.active").length;
        
        let status = true;
                
        if (active == 0){
            status = true;            
        }else{   
            const changed = form.attr("changed");            
            if (changed == 'true'){
                myConfirm("Data belum disimpan. Apakah Anda ingin pindah tabulasi?","Perhatian!", function(r){
                    if (r){          
                        status = true;
                        approveFrame(tabObj, frameObj);                        
                    }else{
                        status = false;
                    }
                });    
                return false;
            }else{            
                status = true;
            }
        }                                        
        return status;
    }        
</script>
