<?php 
/**
 * mengenerate data dalam bentuk grafik pie (berdasarkan ppds tahap)
 * issue RSST-2430
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 */
?>

      
        <?php
            foreach(LookupM::getItemsUrutan('golongan_indikator') as $k => $v){      
                $iden = strtolower(str_replace(" ","_",$k));
        ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <?php echo $v ?>
                            </div>
                        </div>
                        <div class="panel-body loading-<?php echo $iden ?>">
                            <?php 
                                if (isset($list[$iden])){                                    
                                    foreach($list[$iden] as $key => $val){
                                        
                            ?>                            
                                        <div class="col-sm-8 clear<?php echo $iden.$key; ?>">
                                            
                                            <canvas id="bar-perilaku<?php echo $key; ?>"></canvas>
                                        </div>              
                            
                                        <div class="col-sm-4">
                                            <div id="legend_perilaku<?php echo $iden.$key; ?>" class="legend-ul"></div>
                                        </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>                
        <?php                
            }
        ?>
    

