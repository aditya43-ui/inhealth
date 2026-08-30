<?php
$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
//    '*.js' => false,
    '*.css' => false,
);

$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>
<style type="text/css">
    .flex{
        display: flex;
        flex-wrap: wrap
    }
    
    .flex-same {
        display: inline-block;
        background:#ffffe9;
        margin:10px 0 0 10px;
        flex-grow: 1;
        height:150px;    
        width: calc(100% * (1/4) - 10px - 1px);
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
    
    .flex-same:hover {
        display: inline-block;
        background:#3333;
        margin:10px 0 0 10px;
        flex-grow: 1;
        height:150px;    
        width: calc(100% * (1/4) - 10px - 1px);
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }       
    
    .hide{
        display:none;
    }
    
    .container {
        display: flex; 
        flex-wrap: wrap;
        width:100%;
        margin:10px;
    }
   
    .sidebar {
        flex: 1;
    }
    .main {
        flex: 2;
    }
    
    .flex-1{
        flex:1;
    }
    
    .flex-1-100{
        flex:1 100%;
    }
    
    
    .flex-2{
        flex:2;        
    }
    
    .pt-2{
        padding-top:10px;
    }
    
    .pb-2{
        padding-bottom:10px;
    }
    
    .text-center{
        text-align: center;
    }
    
    .fs-15{
        font-size: 15pt;
    }
    
    .fs-12{
        font-size: 12pt;
    }
    
    .hover{
        cursor: pointer;
    }
    
    .active{
        background:#ffffe9;
    }
    
    .header{
        display:flex;
        border:1px solid #333;
        padding:5px;
        width:100%;
        margin-bottom: 3vw;
        background:#ffffe9;
    }
    
    .body{
        display:flex;
        border:1px solid #333;
        width:100%;
    }
    
    .body-1{
        display:flex;
        border:1px solid #333;
        width:100%;
        background:#ffffe9;
        margin-bottom: 3vw;
    }
    
    h2{
        margin-left: 10px;
    }
</style>
<?php
?>

<div class="container">  
    <?= $this->renderPartial('daftarPasien/layout/_1_header',['profil'=>$profil], true) ?>
    
    <?= $this->renderPartial('daftarPasien/layout/_2_body',[
        'profil'=>$profil,
        'jenisAntrian'=>$jenisAntrian,
        'polilinik'=>$polilinik,
        'jenisKunjungan'=>$jenisKunjungan
    ], true) ?>
</div>

<div id="list-form">
    <?= $this->renderPartial('daftarPasien/_form',['model'=>$model], true) ?>
</div>

<?= $this->renderPartial('daftarPasien/_jsFunction',[], true) ?>

