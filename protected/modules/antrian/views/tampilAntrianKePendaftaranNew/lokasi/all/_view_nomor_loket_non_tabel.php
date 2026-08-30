<?php
$data = (explode(" ", $lok['loket_nama']));                                
?>
<div class='col-md-12' style='vertical-align:middle;text-align:center;padding:0px !important;margin:0px !important;display: table;'>                                                                                                        
    <div class='bantrianluar col-md-8'  style='text-align:center;padding:0px !important;margin:0px !important;display:table-cell;'>
        <span style='text-align:center; color:white;font-family:oswald; font-weight:bolder; margin-top:1vw; font-size:1vw;'>NOMOR</span>
        <br/>
        <span class='no-antrian' style='text-align:center; color:white;font-family:oswald; font-weight:bolder; padding-top:1vw; font-size:2.8vw;'>X-000</span>
    </div>
    <div class='col-md-4'  style='text-align:center;padding:0px !important;margin:0px !important;'>
        <div class='cantrianluar'>
            <div class='col-md-12 cantrian'>
                <span style='color:#fff;text-align:center; font-size:1.2vw; font-family:oswald; font-weight:bolder;'>
                   <?= !empty($data[0])?$data[0]:null ?> 
                </span>
                <br/>
                <span style='color:#fff;text-align:center; font-size:2.8vw; margin-top:-1vw; font-family:oswald; font-weight:bolder;'>
                   <?= !empty($data[1])?$data[1]:null ?>
                </span>                                               
            </div>            
        </div>
    </div>    
</div> 