<style>        
     .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }        
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Ubah <b>Penilaian MKDU</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penilaianmkdu_t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
               'onKeyPress' => 'return disableKeyPress(event)',                   
                ),
        ));
?>       
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Pencarian
                </div>
            </div>
            <div class="panel-body" id="form-pencarian">
                <?php echo $this->renderPartial($this->path_view.'formUbah/_formCari',array('model'=>$model,'form'=>$form),true); ?>
            </div>
        </div>
        
        <?php echo $this->renderPartial($this->path_view.'formUbah/_formPenilaianMkdu',array('model'=>$model,'form'=>$form),true); ?>
        <hr/>
        <?php echo $this->renderPartial($this->path_view.'formUbah/_tabelDet',array('modDet'=>$modDet,'model'=>$model,'form'=>$form, 'nilai'=>$nilai),true); ?>

        <?php echo $this->renderPartial($this->path_view.'formUbah/_button',array('model'=>$model)); ?>                  
        
        <?php
                      
        
        echo $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model, 'modDet' => $modDet, 'nilai'=>$nilai), true);
        $this->endWidget();   
        ?>
        
        
    </div>
</div>
