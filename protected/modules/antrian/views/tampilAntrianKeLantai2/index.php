<style type="text/css">
    body {
        left: 0;
        top: 0;
        z-index: -100;
        width: 100vw;
        height: 100vh;
        background: url("<?php echo Yii::app()->request->baseUrl; ?>/images/jadwal_dokter/BG-06.jpg") center center no-repeat;            
        background-size: cover;            
    }   
    
    .header-antrian{
        color: #d86373;
        font-weight: bold;
        font-size: 1.5vw;
        background: #fff;
        padding:10px;
    }

    .flex{
        display: flex;
        flex-wrap: wrap;
        padding:2vw;
        justify-content:center;
    }  
    
    .flex-1 {
        flex: 1;
    }
    .flex-2 {
        flex: 2;
    }
    
    .flex-100 {
        flex: 1 100%;
    }
    
    .text-center{
        justify-content:center;
    }
    
    .box-antrian{
        margin:1px;
        box-shadow: 5px 5px 5px #dbdbdb;
        background:#fff;
        /*border: 1px solid #dbdbdb;*/
        width:24.75%;
        /*background:#fff;*/
        border-radius:2vw ;
    }
    
    .header-no-antrian{
        color:#fff;
        font-weight:bold;
        background:#5ec196;
        border-radius:2vw 2vw 0 0;
        height:2.5vw;    
        padding-top:0.5vw;
        font-size:1.5vw;
        text-align:center;
    }
    
    .body-no-antrian{
        display:inline;
        color:#333;
        font-weight:bold;        
        border-radius:0 0 2vw 2vw;
        font-size:1.5vw;
        text-align:center;
    }
    
    .no-antrian{
        font-size:2.5vw;   
        background:transparent;
    }
    
    .loket{
        font-size:1.3vw;   
        background:transparent;
    }
    
    .stretch{
        align-self:stretch;
    }
    
    .container-dipanggil .box-antrian{
        width:40%;
    }
       
    .container-dipanggil .header-no-antrian{
        font-size:4vw;
        height:6vw; 
        background:#00cc00 !important;
    }        
    
    .container-dipanggil .body-no-antrian .no-antrian{
        font-size:7vw !important;
    }
    
    .container-dipanggil .body-no-antrian .kunjungan-fasttrack{
        font-size:3.2vw !important;
    }
    
    .container-dipanggil .body-no-antrian .loket{
        font-size:3.6vw !important;
    }
    
    
</style>
<?php
    $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>
 
<header class="flex" style="padding-bottom: 0px;">
    <div class="flex-1">
        <?php        
            $path = Params::pathProfilRSDirectory().$profil->logo_rumahsakit;

            $res = "";
            $ext = "png";
            if (file_exists($path)) {
                $content = file_get_contents($path);
                $ext_data = pathinfo($path);

                if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
                    $ext = $ext_data['extension'];
                }

                $res = "data:image/".$ext.";base64,". base64_encode($content);
            }
        ?>
        <img src="<?= $res ?>" width="10%" style="position:fixed;">
    </div>
    <div class="flex-1">
        &nbsp;
    </div>
    <div class="flex-100 text-center">
        <span class="header-antrian">NOMOR YANG TERTERA DI LAYAR SILAHKAN MENUJU KE PETUGAS BARCODE</span>
    </div>
</header>   

<div id="form-list-antrian" class="content flex">
    <div class="flex-100 flex text-center container-dipanggil" style="padding-top: 0px;">
 
</div>
    </div>
</div>

<?= $this->renderPartial('_jsFunction',[], true) ?>


