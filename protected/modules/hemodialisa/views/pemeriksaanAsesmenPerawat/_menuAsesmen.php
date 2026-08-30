<style>
    .garis-tepi{
        border:1px solid #333;
        border-radius:10%;
        height:100%;
        min-height: 120px;
        text-align: center;
        vertical-align: middle;
        margin:0px;        
        padding:5px;
    }
</style>
<div class="panel panel-success">    
<?php    
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view."_listMenu",array('modPendaftaran'=>$modPendaftaran),true); ?>
    </div>
</div>