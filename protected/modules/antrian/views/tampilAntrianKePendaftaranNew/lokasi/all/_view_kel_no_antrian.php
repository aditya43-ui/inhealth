    
    <?php
        if (isset($tab[$mod['modelantrian_id']])){                     
            foreach($tab[$mod['modelantrian_id']] as $lok){                      
                echo $this->renderPartial($pathview.'lokasi/all/_view_nomor_loket_non_tabel',['lok'=>$lok, 'row'=>1]);                
            }            
        }
    ?>
