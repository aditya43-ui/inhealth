
<div class="panel  panel-gradient">    
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Asesmen Spiritual Ulang Rawat Jalan/IGD'
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php                 
            echo $this->renderPartial($this->path_view.'spiritualUlangRJRD/_form',array(
                'model'=>$model,
                'modDet'=>$modDet,
            ));                       
        ?>
    </div>
</div>


