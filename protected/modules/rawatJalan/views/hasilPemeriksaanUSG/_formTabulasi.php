<style>
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:96%;width:97%;
    }

    select[disabled]{
        background:#eeeeee;
    }
</style>

<div class="panel panel-success panel_choise" id="choise_trs1" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo $form->radioButton($model, 'is_trimester', array('onclick' => 'choiseTrimester(this)', 'value' => 1, 'class'=>'pilih_trs', 'uncheckValue'=>null)); ?> TRIMESTER I</div>
    </div>
    <div class="panel-body" >
        <?php echo CHtml::activeHiddenField($model, 'trimesterkehamilan', array('value'=>1)); ?>
        <div class="formtrs1">
            <?php if(isset($_GET['pemeriksaanusgpasien_id'])){ ?>
                <?php if($model->is_trimester == 1){ ?>
                    <?php $this->renderPartial($this->path_view.'_formTrimester1',array('model'=>$model,'modDetail'=>$modDetail, 'form'=>$form, 'modDetailUsg'=>$modDetailUsg)) ?>
                 <?php } ?>
            <?php }else{ ?>
            <?php $this->renderPartial($this->path_view.'_formTrimester1',array('model'=>$model,'modDetail'=>$modDetail, 'form'=>$form, 'modDetailUsg'=>$modDetailUsg)) ?>
            <?php } ?>
        </div>
    </div>
</div>
<div class="panel panel-success panel_choise" id="choise_trs2" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo $form->radioButton($model, 'is_trimester', array('onclick' => 'choiseTrimester(this)', 'value' => 2, 'class'=>'pilih_trs', 'uncheckValue'=>null)); ?> TRIMESTER II</div>
    </div>
    <div class="panel-body" >
        <?php echo CHtml::activeHiddenField($model, 'trimesterkehamilan', array('value'=>2)); ?>
        <div class="formtrs2">
            <?php if(isset($_GET['pemeriksaanusgpasien_id'])){ ?>
                <?php if($model->is_trimester == 2){ ?>
                    <?php $this->renderPartial($this->path_view.'_formTrimester2',array('model'=>$model,'modDetail'=>$modDetail, 'form'=>$form, 'modDetailUsg'=>$modDetailUsg)) ?>
                 <?php } ?>
            <?php }else{ ?>
            <?php  $this->renderPartial($this->path_view.'_formTrimester2',array('model'=>$model,'modDetail'=>$modDetail, 'form'=>$form, 'modDetailUsg'=>$modDetailUsg)) ?>
            <?php } ?>
        </div>
    </div>
</div>
<div class="panel panel-success panel_choise" id="choise_trs3" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo $form->radioButton($model, 'is_trimester', array('onclick' => 'choiseTrimester(this)', 'value' => 3, 'class'=>'pilih_trs', 'uncheckValue'=>null)); ?> TRIMESTER III</div>
    </div>
    <div class="panel-body" >
        <?php echo CHtml::activeHiddenField($model, 'trimesterkehamilan', array('value'=>3)); ?>
        <div class="formtrs3">
            <?php if(isset($_GET['pemeriksaanusgpasien_id'])){ ?>
                <?php if($model->is_trimester == 3){ ?>
                <?php $this->renderPartial($this->path_view.'_formTrimester3',array('model'=>$model,'modDetail'=>$modDetail, 'form'=>$form, 'modDetailUsg'=>$modDetailUsg)) ?>
                <?php } ?>
             <?php }else{ ?>
                <?php $this->renderPartial($this->path_view.'_formTrimester3',array('model'=>$model,'modDetail'=>$modDetail, 'form'=>$form, 'modDetailUsg'=>$modDetailUsg)) ?>
            <?php } ?>
        </div>
    </div>
</div>



