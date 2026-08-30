

<?php
$cnt = 0;
if (count($load_model) > 0) {    
?>
    <div class="lis-antrian " nolist = '1'>
        <table width="100%" id="page">
            <?php if ($layar->is_tampilnamamodel){ ?>
            <thead>
                <tr>
                    <?php 
                        $i = 0; 
                        $no_mod = 0;
                        foreach($load_model as $mod){
                            $td = '';
                            
                            if ($i!= 0 && $i % 6 ==0)
                                $no_mod++;                            
                            
                            $hide = '';
                            if ($no_mod > 0)
                                $hide='hide';
                            
                            if ($i == 0){
                                $td = "<td nolist='".$no_mod."' width='0.5%' class='".$hide."'></td>";
                            }
                            echo "  
                                ".$td."
                                <td nolist='".$no_mod."' class='modelname ".$hide."' colspan='2' style='font-size:3vw;color:#fff;font-weight:bold;text-align:center;'><div class='dantrianluar'><div class='dantrian'>".strtoupper($mod['modelantrian_singkatan'])."<p><span style='font-size:0.8vw'>".strtoupper($mod['modelantrian_nama'])."</span></p></div></div></td>                                    
                                <td nolist='".$no_mod."' class='".$hide."' width='0.5%'></td>
                            ";
                            $i++;
                        }
                    ?>
                </tr>
            </thead>
            <?php } ?>
            <tbody>                
                    <?php 
                                        
                        $a = 1;
                        $mod_tr = 0;
                        foreach($nomor_loket as $lok){
                            
                            if ( (($a-1) != 0) && (($a-1) % 4) ==0)
                                $mod_tr++;                            

                            $tr_h = '';
                            if ($mod_tr > 0)
                                $tr_h='hide';
                            
                            echo "<tr nolist='".$mod_tr."' class='".$tr_h."'>";
                            $i = 0;           
                            $no_mod = 0;
                            foreach($load_model as $mod){                                                             
                                if (isset($lok[$mod['modelantrian_id']])){                                        
                                    if ($i!= 0 && $i % 6 ==0)
                                        $no_mod++;                            

                                    $hide = '';
                                    if ($no_mod > 0)
                                        $hide='hide';                                                                    
                                    
                                    $row = 1;
                                    if ($a == $mod['baris']){
                                        $row = $nomor - $lok[$mod['modelantrian_id']]['baris'] + 1;
                                    }
                                    $td = '';
                                    if ($i == 0){
                                        $td = "<td nolist='".$no_mod."' class='".$hide."' width='0.5%'></td>";
                                    }
                                    $data = array();                                
                                    $data = (explode(" ", $lok[$mod['modelantrian_id']]['loket_nama']));                                
                                    echo "     
                                        ".$td."
                                       <td nolist='".$no_mod."' class='".$hide."' rowspan='".($row)."' style='vertical-align:middle;background:#88007d;'>
                                           <div 
                                               id='loket_".$lok[$mod['modelantrian_id']]['loket_id']."'  
                                               class='antrian loketAntrian_".$lok[$mod['modelantrian_id']]['loket_id']."'
                                               data-loket-no='".$lok[$mod['modelantrian_id']]['loket_no']."' 
                                               data-antrian='".$lok[$mod['modelantrian_id']]['loket_id']."'
                                               data-loket_id='".$lok[$mod['modelantrian_id']]['loket_id']."'                                            
                                               > 
                                               <div class='bantrianluar'>
                                                    <div class='col-md-12 bantrian' style='text-align:center;'>                                                                                                        
                                                         <span style='text-align:center; color:white;font-family:oswald; font-weight:bolder; margin-top:1vw; font-size:1vw;'>NOMOR</span>
                                                         <br/>
                                                         <span class='no-antrian' style='text-align:center; color:white;font-family:oswald; font-weight:bolder; padding-top:1vw; font-size:2.8vw;'>X-000</span>
                                                     </div>
                                               </div>
                                            </div>
                                       </td>
                                       <td nolist='".$no_mod."' class='".$hide."' rowspan='".($row)."'  style='text-align:center;vertical-align:middle;background:#3a3c4a;'>
                                            <div class='cantrianluar'>
                                                <div class='col-md-12 cantrian'>

                                                    <span style='color:#fff;text-align:center; font-size:1vw; font-family:oswald; font-weight:bolder;'>
                                                       ".strtoupper($data[0])."
                                                    </span>
                                                    <br/>
                                                    <span style='color:#fff;text-align:center; font-size:2.8vw; margin-top:-1vw; font-family:oswald; font-weight:bolder;'>
                                                        ".strtoupper($data[1])."
                                                    </span>                                               
                                                </div>
                                            </div>
                                       </td>
                                       <td nolist='".$no_mod."' class='".$hide."' rowspan='".($row)."'
                                        <span style='color:#b5b5b5;'></span>
                                       </td>
                                   ";
                                    $i++;
                                }                               
                            }
                            echo "</tr>";
                            $a++;
                        }//".$this->renderPartial($pathview . '/_formAntrian', array('model' => $model))."                                           
                    ?>                
            </tbody>
        </table>
    </div>
<?php

}
?>
