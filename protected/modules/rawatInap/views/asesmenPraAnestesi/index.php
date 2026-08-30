
<div class="panel  panel-success">    
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Asesmen Pra Bedah'
        );

        $instalasi = InstalasiM::model()->findByPk(Yii::app()->user->getState('instalasi_id'));
        $ins_exp = explode(" ", $instalasi->instalasi_nama);
        
        $this->widget('bootstrap.widgets.BootAlert'); 
        
        echo CHtml::hiddenField("jnsDialog",'');
        echo CHtml::hiddenField("norow",'');
        ?>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Riwayat Asesmen Pra Bedah
                </div>
            </div>
            <div class="panel-body">
                <?php                 
                    echo $this->renderPartial($this->path_view.'grid/_daftarRiwayat',array(
                        'model'=>$model,                
                    )); 
                ?>
            </div>
        </div>
               
        <?php

            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'lembar-perencanaan-pulang-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)', 
                'onsubmit' => 'return requiredCheck(this);'),               
            ));

            echo $this->renderPartial($this->path_view.'_form',array(
                'model'=>$model,
                'form'=>$form
            )); 

            echo '<div class="form-actions">';
            echo $this->renderPartial($this->path_view.'_button',['model'=>$model], true);
            echo '</div>';


            $this->endWidget(); 
        ?>            
    </div>
</div>
<?php
    $dropSatuanDosis = LookupM::getItemsUrutan('satuankekuatan');
?>
<?= $this->renderPartial($this->path_view.'_dialog',[], true) ?>
<?= $this->renderPartial($this->path_view.'_jsFunction',['detail'=>!empty($detail)?$detail:0,'model'=>$model], true) ?>

<script>

<?php //if(isset($_GET['sukses']) && in_array($instalasi->instalasi_id, array(2, 3, 4))):?>
         //   window.open('<?php //echo Yii::app()->createUrl(strtolower($ins_exp[0]) . ucfirst($ins_exp[1]).'/RekamMedikElektronikPasienRJ/index&pendaftaran_id=' . $_GET['pendaftaran_id'] . '&type=Dokter&active_tab=prabedah'); ?>');
        <?php //endif;?>

</script>
