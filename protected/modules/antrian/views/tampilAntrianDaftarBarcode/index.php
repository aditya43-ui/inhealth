<style type="text/css">
    body {
        left: 0;
        top: 0;
        z-index: -150;
        width: 100vw;
        height: 100vh;
        background-size: cover;            
    }   
    
    .header-antrian{
        color: #d86373;
        font-weight: bold;
        font-size: 2.2vw;
        background: #fff;
        padding:25px;
    }

    .flex{
        display: flex;
        flex-wrap: wrap;
        padding:2vw;
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
        width:19%;
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
        background:powderblue;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-2{
        background:darkblue;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-3{
        background:darkcyan;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-4{
        background:green;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-5{
        background:grey;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-6{
        background:seagreen;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-7{
        background:orange;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-8{
        background:chocolate;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-9{
        background:hotpink;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-10{
        background:dodgerblue;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-11{
        background:cornflowerblue;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }
    
    .bg-12{
        background:navy;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }        
    
    .bg-13{
        background:seagreen;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }    

    .bg-14{
        background:lightseagreen;
        border-radius: 15px;
        font-size:15px;
        font-family: "Times New Roman", Times, serif;
    }   

    .loket{
        font-size:1.0vw;   
        text-align:center;
        padding:0.5vw;
        margin:0 2vw 1vw 2vw;
        flex: 0 1 calc(40% - 8px); 
        border:1px solid #fff;
    }
    
    .stretch{
        align-self:stretch;
        border-radius: 10px;
        font-family: "Times New Roman", Times, serif;
        
    }
    
    footer{
        color:#fff;
        background: #333;
        font-size:2vw;
        padding:0.5vw;
        position:fixed;
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
        background:#ededed;
        border-left:2px solid #bbbdba;        
        border-right:2px solid #bbbdba;        
        flex: 0 2 calc(25% - 10px); 
        padding:0.5vw;
        height: 36px;
    }
      
    .item.even {
        text-align:center;
        background: #bbbdba;
        border-left:2px solid #ededed;        
        border-right:2px solid #ededed;        
        flex: 0 2 calc(25% - 10px); 
        padding:0.5vw;
        height: 36px;
    }
</style>
<?php
    $profil = ProfilrumahsakitM::model()->find();
?>
 
<header class="flex" style="padding-bottom: 5px;">
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
        <img src="<?= $res ?>" width="12%" >
    </div>
    <div class="flex-1">
        &nbsp;
    </div>
    <div class="flex-100 text-center">
        <span class="header-antrian">SILAHKAN MENUJU KE PETUGAS BARCODE</span>
    </div>
</header>   

<div id="form-list-antrian" class="container flex" style="padding-top: 10px;">
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


