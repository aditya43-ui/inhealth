
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <b>
                <?php echo $model->isNewRecord ? "Tambah" : "Ubah"; ?>
                Program Rujuk Balik
            </b>
        </div>
    </div>
    <div class="panel-body">
        <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'prb-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array(
                    'onKeyPress' => 'return disableKeyPress(event)', 
                    'enctype' => 'multipart/form-data', 
                    'onsubmit' => 'return requiredCheck(this);'),               
                ));  
            
                $this->widget('bootstrap.widgets.BootAlert');
        ?>
            <?= CHtml::hiddenField('jenis_dialog','') ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Data Pasien</div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial('tambah/form/_1_pasien_sep', array('model' => $modPasienSep, 'form'=>$form)); ?>
                </div>
            </div>
        
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Data Program Rujukan Balik</div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial('tambah/form/_2_program_rujuk_balik', array('model' => $model, 'form'=>$form)); ?>
                </div>
            </div>
        
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Obat Program Rujukan Balik</div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial('tambah/form/_3_obat_program_rujuk_balik', array('base' => $model, 'model' => $modObat, 'form'=>$form)); ?>
                </div>
            </div>

            <div class="form-actions">
                <?= $this->renderPartial('tambah/_button',['model'=>$model]); ?>
            </div>
        <?php
            $this->endWidget(); 
        ?>
    </div>
</div>

<?= $this->renderPartial('tambah/_jsFunction',[], true) ?>
<?= $this->renderPartial('tambah/_dialog',[], true) ?>
