<style type="text/css">
    .tampil-noantrian{
        height: 100px;
        width:100%;
        border:1px solid #333;
/*        background: 
             linear-gradient(to top left,
                 rgba(0,0,0,0) 0%,
                 rgba(0,0,0,0) calc(50% - 0.8px),
                 rgba(0,0,0,1) 50%,
                 rgba(0,0,0,0) calc(50% + 0.8px),
                 rgba(0,0,0,0) 100%),
             linear-gradient(to top right,
                 rgba(0,0,0,0) 0%,
                 rgba(0,0,0,0) calc(50% - 0.8px),
                 rgba(0,0,0,1) 50%,
                 rgba(0,0,0,0) calc(50% + 0.8px),
                 rgba(0,0,0,0) 100%);*/
        text-align: center;
        margin:5px;
    }
    
    .tampil-noantrian > .no-antrian{
        margin-top: 35%;
        background: rgb(255, 255, 255, 0.8);
        padding:5px;
        border-radius: 10%;
        border:1px solid rgb(0, 0, 0, 0.2);
        width: 70%;
        margin: auto;
        margin-top: 35%;
        color:#333;
        font-weight: bold;
    }
    
    tr.status-reservasi td{
        background:#ffe599 !important;                    
    }
    
    tr.status-fasttrack td{
        background:#ea9999 !important;                    
    }
    
    tr.status-sekarang td{
        background:#fff !important;                    
    }
    
    .box-antrian{
        margin:1px;
        box-shadow: 5px 5px 5px #dbdbdb;
        background:#fff;
        /*border: 1px solid #dbdbdb;*/
        width:100%;
        /*background:#fff;*/
        border-radius:2vw ;
    }
    
    .header-no-antrian{
        color:#fff;
        font-weight:bold;
        background:#00cc00;
        border-radius:2vw 2vw 0 0;
        height:2vw;    
        padding-top:0.2vw;
        font-size:1vw;
        text-align:center;
    }
    
    .body-no-antrian{
        display:inline;
        color:#333;
        font-weight:bold;        
        border-radius:0 0 2vw 2vw;
        font-size:1vw;
        text-align:center;
    }
    
    .no-antrian{
        font-size:1.5vw;   
        background:transparent;
    }
    
    .loket{
        font-size:1.1vw;   
        background:transparent;
    }
    
    .stretch{
        align-self:stretch;
    }
</style>
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Pemanggilan Antrian</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Pemanggilan Antrian'
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php                 
        echo $this->renderPartial('_form',array(
           'model' => $model
        )); ?>
    </div>
</div>
<?= $this->renderPartial('_dialog',[], true) ?>
<?= $this->renderPartial('_jsFunction',['model'=>$model], true) ?>


