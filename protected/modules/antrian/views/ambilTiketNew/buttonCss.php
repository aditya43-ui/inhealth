<style>           
    .k<?php echo $i; ?>btn-tiket<?php echo $i; ?> {
        height: <?php echo (!empty($lokasi->lokasi_karcisantrian_lebartombol) || $lokasi->lokasi_karcisantrian_lebartombol > 0)?$lokasi->lokasi_karcisantrian_tinggitombol.'px':'431px' ?>;
        border:none;
        vertical-align: top;
        font-family: Arial, Helvetica, sans-serif;
        color:white;
        font-size:35px;
        letter-spacing:0px;
        font-weight: bold;
        text-shadow: 2px 2px 6px #000000;
        line-height: 1;   
        padding-top:181px;
        margin-left:0px;
        width:100%;
        <?php 
            if (empty($gambar) || !file_exists(Params::pathAntrianCustomDirectory().$gambar)){
        ?>
                background: url('images/antrian/default.png');
        <?php             
            }else{ 
                $url = str_replace(Yii::getPathOfAlias('webroot').'/', '', Params::pathAntrianCustomDirectory());
        ?>
                background: url('<?php echo $url.$gambar ?>');
        <?php         
            } 
        ?>
        background-repeat: no-repeat;
      
        background-position: center; 
    }
       
    button.k<?php echo $i; ?>btn-tiket<?php echo $i; ?>:active{        
        box-shadow: 2px 4px 3px 2px #222;
        background-repeat: no-repeat;    
    }
    
    button.k<?php echo $i; ?>btn-tiket<?php echo $i; ?>:hover {       
        box-shadow: 2px 4px 3px 2px #222;
        background-repeat: no-repeat;    
    }  
    
    .baris-kata<?php echo $i ?>{        
        text-shadow: none !important;
        font-size:25px;   
        font-family:Oswald;
    }
    
    .baris-singkatan<?php echo $i ?>{            
        text-shadow: none !important;
        font-size:85pt;        
        font-family:Oswald;
    }
    
    .closeall<?php echo $i ?>{        
        height: <?php echo (isset($lokasi->lokasi_karcisantrian_tinggitombol)?$lokasi->lokasi_karcisantrian_tinggitombol.'px':'431px') ?>;
        width: 100%;    
        opacity: 0.5;
    }
        
    .closeall<?php echo $i ?>:after {
        content: '';
        height: 100%;
        border-left: 10px solid #d60a0a;
        position: absolute;
        transform: rotate(28deg);
        left:48%;        
        top:-7%;
    }

    .closeall<?php echo $i ?>:before {
        content: '';
        height: 100%;
        border-left: 10px solid #d60a0a;
        position: absolute;
        transform: rotate(-28deg);
        left:48%;        
        top:-7%;
    }
</style>