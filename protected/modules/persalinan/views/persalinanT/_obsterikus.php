<fieldset id="panel-obs" hidden>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success ">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo CHtml::checkBox('isstatusobs', false, array('class'=>'panel_statusobs','onclick'=>'panelToggleObs(this, "panel-form-statusobs");')) ?>
                    Status Obstetrikus
                </div>
            </div>
            <div class="panel-body panel-form-statusobs" style="display:none">
                <?php $this->renderPartial($this->path_view.'obsteri/_statusobsterikus',array('modPemeriksaan'=>$modPemeriksaan,'form'=>$form,'model'=>$model)); ?>
            </div>
        </div>
        <div class="panel panel-success ">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo CHtml::checkBox('iskala1', false, array('class'=>'panel_kala1','onclick'=>'panelToggleObs(this, "panel-form-kala1");')) ?>
                    KALA I
                </div>
            </div>
            <div class="panel-body panel-form-kala1" style="display:none">
                <?php $this->renderPartial($this->path_view.'obsteri/_kala1',array('modKala'=>$modKala,'form'=>$form)); ?>
            </div>
        </div>
        <div class="panel panel-success ">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo CHtml::checkBox('iskala2', false, array('class'=>'panel_kala2','onclick'=>'panelToggleObs(this, "panel-form-kala2");')) ?>
                    KALA II
                </div>
            </div>
            <div class="panel-body panel-form-kala2" style="display:none">
            <?php $this->renderPartial($this->path_view.'obsteri/_kala2',array('modKala'=>$modKala,'form'=>$form)); ?>
            </div>
        </div>
        <div class="panel panel-success ">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo CHtml::checkBox('iskala3', false, array('class'=>'panel_kala3','onclick'=>'panelToggleObs(this, "panel-form-kala3");')) ?>
                    KALA III
                </div>
            </div>
            <div class="panel-body panel-form-kala3" style="display:none">
                <?php $this->renderPartial($this->path_view.'obsteri/_kala3',array('modPemeriksaan'=>$modPemeriksaan, 'modKala'=>$modKala,'form'=>$form)); ?>
            </div>
        </div>
        <div class="panel panel-success ">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo CHtml::checkBox('iskala4', false, array('class'=>'panel_kala4','onclick'=>'panelToggleObs(this, "panel-form-kala4");')) ?>
                    KALA IV (Kondisi Ibu)
                </div>
            </div>
            <div class="panel-body panel-form-kala4" style="display:none">
                <?php $this->renderPartial($this->path_view.'obsteri/_kala4',array('modPemeriksaan'=>$modPemeriksaan, 'modKala'=>$modKala,'form'=>$form)); ?>
        
            </div>
        </div>
        <div class="panel panel-success ">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo CHtml::checkBox('ispersaliankala4', false, array('class'=>'panel_persaliankala4','onclick'=>'panelToggleObs(this, "panel-form-persaliankala4");')) ?>
                    Pemantauan Persalinan Kala IV
                </div>
            </div>
            <div class="panel-body panel-form-persaliankala4" style="display:none">
            <?php echo $this->renderPartial($this->path_view . "obsteri/_pemantauanPersalinan", array('model' => $modKala), true); ?>
            </div>
        </div>
        <div class="panel panel-success ">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo CHtml::checkBox('isperlukaanjalanlahir', false, array('class'=>'panel_perlukaanjalanlahir','onclick'=>'panelToggleObs(this, "panel-form-perlukaanjalanlahir");')) ?>
                    Perlukaan Jalan Lahir
                </div>
            </div>
            <div class="panel-body panel-form-perlukaanjalanlahir" style="display:none">
                <?php $this->renderPartial($this->path_view.'obsteri/_pelukaanJalanLahir',array('modPemeriksaan'=>$modPemeriksaan,'form'=>$form)); ?>
            </div>
        </div>

        <div class="panel panel-success ">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo CHtml::checkBox('isnifas', false, array('class'=>'panel_nifas','onclick'=>'panelToggleObs(this, "panel-form-nifas");')) ?>
                    Nifas
                </div>
            </div>
            <div class="panel-body panel-form-nifas" style="display:none">
            <?php $this->renderPartial($this->path_view.'obsteri/_nifas',array('modPemeriksaan'=>$modPemeriksaan,'form'=>$form)); ?>
            </div>
        </div>
    </div>
</div>
</fieldset>
