<?php
echo "  <td rowspan='".($row)."' style='vertical-align:middle;background:#88007d;>
            <div 
                id='loket_".$lok['loket_id']."'  
                class='antrian loketAntrian_".$lok['loket_id']."'
                data-loket-no='".$lok['loket_no']."' 
                data-antrian='".$lok['loket_id']."'
                data-loket_id='".$lok['loket_id']."'                                            
                > 
                <div class='bantrianluar'>
                     <div class='col-md-12 bantrian' style='text-align:center;'>                                                                                                        
                          <span style='text-align:center; color:white;font-family:oswald; font-weight:bolder; margin-top:1vw; font-size:1vw;'>NOMOR</span>
                          <br/>
                          <span class='no-antrian' style='text-align:center; color:white;font-family:oswald; font-weight:bolder; padding-top:1vw; font-size:2.8vw;'>X-000</span>
                      </div>
                </div>
            </div>
        </td>";
echo "  <td rowspan='".($row)."'  style='text-align:center;vertical-align:middle;background:#3a3c4a;'>
            <div class='cantrianluar'>
                <div class='col-md-12 cantrian'>

                    <span style='color:#fff;text-align:center; font-size:1vw; font-family:oswald; font-weight:bolder;'>
                       ".strtoupper($lok['loket_nama'])."
                    </span>
                    <br/>
                    <span style='color:#fff;text-align:center; font-size:2.8vw; margin-top:-1vw; font-family:oswald; font-weight:bolder;'>
                        ".strtoupper($lok['loket_singkatan'])."
                    </span>                                               
                </div>
            </div>
        </td>";