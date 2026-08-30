<style type="text/css">
    body {
        left: 0;
        top: 0;
        z-index: -150;
        width: 100vw;
        height: 100vh;
        background-size: cover;   
        font-family: 'Roboto', sans-serif;

    }   
    
    .header-antrian{
        color: #d86373;
        font-weight: bold;
        font-size: 2.2vw;
        background: #fff;
        padding:25px;
    }

    header{
        margin-top: 47px;
    }

    .flex{
        /* display: flex; */
        flex-wrap: wrap;
        padding:2vw;
        justify-content:center;
        /* margin-top: -50px */
    }  
    .flex-form {
        flex-wrap: wrap;
        /* padding:1vw; */
        justify-content:center;
        margin-top: -50px

    }

    .flex-1 {
        flex: 1 auto;

    }
    .flex-2 {
        flex: 2;
    }
    
    .flex-100 {
        flex: 1 100%;
        margin-top: -80px
    }
    
    .text-center{
        justify-content:left;
    }
    
    .box-antrian{
        margin:2px;
        width:20%;
        border-radius: 25px;
    }
    
    .header-no-antrian{
        color:#fff;
        font-weight:bold;
        background:#00cc00;
        border-radius:2vw 2vw 0 0;
        height:2.5vw;    
        padding-top:1.0vw;
        font-size:1.5vw;
        text-align:center;
    }
    
    .body-no-antrian{
        color:#333;
        font-weight:bold;        
        border-radius:1 1 2vw 2vw;
        font-size:1.4vw;
        text-align:left;
    }
    
    .no-antrian{
        font-size:2.2vw;   
        background:transparent;
    }

    .bg-1{
        background:#FAF8F1;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-2{
        background:#FAEAB1;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-3{
        background:#E5BA73;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-4{
        background:#CCD6A6;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-5{
        background:#DAE2B6;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-6{
        background:#F4EAD5;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-7{
        background:#FFFBE9;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-8{
        background:#F2F7A1;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-9{
        background:#FF9E9E;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-10{
        background:#FED049;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-11{
        background:#009EFF;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-12{
        background:#D6E4E5;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }        
    
    .bg-13{
        background:#9ED5C5;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }    

    .bg-14{
        background:#B3FFAE;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }   

    .loket{
        font-size:1.6em;   
        text-align:center;
        padding:0.7vw;
        width: 19.2vw;
        /* margin:0 2vw 1vw 2vw; */
        /* flex: 0 1 calc(40% - 8px);  */
        border:1px solid #fff;
        background-color: #46a36f;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        margin-bottom: 2px;
        font-weight: bold;

    }
    
    .stretch{
        align-self:stretch;
        /* border-radius: 10px; */
        font-family: "Times New Roman", Times, serif;
        display: flex;
        align-items: center;
        justify-content: center;       
    }
    
    footer{
        color:#fff;
        background: #333;
        font-size:2vw;
        padding:0.5vw;
        /* position:fixed; */
        width:100%;
        bottom:0;
    }
    
    .container {
        width: 100%;
        display: flex;
        flex-flow: row wrap;   
        justify-content: center;
        font-size:0.9vw;
      }
      
    .item.odd{
        text-align:center;
        border-left:2px solid #bbbdba;        
        border-right:2px solid #bbbdba; 
        border-top:2px solid #bbbdba; 
        border-bottom:2px solid #bbbdba; 
        flex: 0 2 calc(36% - 10px); 
        padding:0.4vw;
        margin: 0.5px;
        height: 34px;
        font-weight: bold;
        font-family: 'monospace';
    }
      
    .item.even {
        text-align:center;
        background: #bbbdba;
        margin: 2px;
        border-left:2px solid #ededed;        
        border-right:2px solid #ededed;        
        flex: 0 2 calc(25% - 10px); 
        padding:0.5vw;
        height: 36px;
    }

    .text-antrian-6kata {
        font-size:1.75em;
    }
    .text-antrian-5katakebawah {
        font-size:2em;
    }

    @media screen and (min-width: 768px) {
        .item.odd{
            text-align:center;
            border-left:2px solid #bbbdba;        
            border-right:2px solid #bbbdba; 
            border-top:2px solid #bbbdba; 
            border-bottom:2px solid #bbbdba; 
            flex: 0 1 calc(36% - 10px); /* change value for medium screens */
            /* padding:0.4vw; */
            margin: 0.5px;
            height: 37.5px;
            font-family: 'Montserrat', sans-serif;
            font-weight: bold;
        }
        .text-antrian-6kata {
            font-size:0.9em;
        }
        .text-antrian-5katakebawah {
            font-size:1.3em;
        }
        .item.even {
            text-align:center;
            background: #bbbdba;
            margin: 2px;
            border-left:2px solid #ededed;        
            border-right:2px solid #ededed;        
            flex: 0 1 calc(50% - 10px); /* change value for medium screens */
            padding:0.5vw;
            height: 36px;
        }
       
    }

    @media screen and (min-width: 1024px) {
        .item.odd{
            text-align:center;
            border-left:2px solid #bbbdba;        
            border-right:2px solid #bbbdba; 
            border-top:2px solid #bbbdba; 
            border-bottom:2px solid #bbbdba; 
            flex: 0 1 calc(33.33% - 10px); /* change value for large screens */
            /* padding:1.4vw; */
            /* height: 157px; */
            margin: 0.5px;
            height: 50px;
            font-family: 'Monospace', sans-serif;
            font-weight: bold;
        }
        .item.even {
            text-align:center;
            background: #bbbdba;
            margin: 2px;
            border-left:2px solid #ededed;        
            border-right:2px solid #ededed;        
            flex: 0 1 calc(33.33% - 10px); /* change value for large screens */
            padding:0.5vw;
            height: 36px;
        }

        .text-antrian-6kata {
            font-size:1.32em;
        }
        .text-antrian-5katakebawah {
            font-size:2em;
        }

        .box-antrian{
            margin:2px;
            width:24%;
            border-radius: 25px;
        }

        .loket{
            font-size:1.6em;   
            text-align:center;
            padding:0.7vw;
            width: 23.6vw;
            /* margin:0 2vw 1vw 2vw; */
            /* flex: 0 1 calc(40% - 8px);  */
            border:1px solid #fff;
            background-color: #46a36f;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            margin-bottom: 2px;
            font-weight: bold;

        }
       
    }

    <?php
        $profil = ProfilrumahsakitM::model()->find();

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
   
    .background {
        position: fixed;
        left: 0;
        top: 0;
        z-index: -100;
        width: 100vw;
        height: 100vh;
        /*background: url("<?php echo Yii::app()->request->baseUrl; ?>/images/jadwal_dokter/BG-06.jpg") center center no-repeat;*/
        background: url("<?php echo Params::urlProfilRSDirectory() . $profil->logo_rumahsakit; ?>") center center no-repeat;
        /* background: url("<?php //echo Yii::app()->request->baseUrl; 
                            ?>/images/antrian/antrianbaru.jpg") center center no-repeat; */
        background-size: cover;
        opacity: 0.2;
        /* filter: blur(25px) brightness(125%);
        -webkit-filter: blur(25px) brightness(125%);
        -moz-filter: blur(25px) brightness(125%); */
    }

</style>

 <div class="background"></div>
<!-- <header class="flex" style="padding-bottom: 5px;">
    <div class="flex-1">
        
        <img src="<?php //$res ?>" width="12%" >
    </div>
    <div class="flex-1">
        &nbsp;
    </div>
    <div class="flex-100 text-center">
        <span class="header-antrian">SILAHKAN MENUJU KE PETUGAS BARCODE</span>
    </div>
</header>    -->
<header></header>
<div id="form-list-antrian" class="container flex-form" style="padding-top: 10px;">
    <?php
        foreach($loket as $key => $val){
            $start++;
            echo $this->renderPartial('antrian/_list',['loket'=>$val,'loketId'=>$key, 'i'=>$start]);
        }
    ?>    
</div>

<footer>
    <marquee direction="left" scrollamount="7" align="center">
        NOMOR YANG TERTERA DIATAS DILAYAR HARAP MENUJU KE PETUGAS BARCODE
    </marquee>
</footer>

<?= $this->renderPartial('_jsFunction',[], true) ?>


