<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fa fa-stethoscope"></i> Pemeriksaan Asesmen Pasien
        </div>
        <?php
        $this->breadcrumbs = array(
            'Informasi Pasien' => Yii::app()->request->getUrlReferrer(),
            'Pemeriksaan Asesmen Pasien'
        );
        ?>
        <!-- <?php
        $module = "";
        // $module = Yii::app()->controller->module->id;
       
        if ($module == 'mcu') { ?>
        <?php } else { ?>
            <div class="panel-options">
                <?php //echo CHtml::link('<i class="entypo-back"></i> Kembali', '#', array('class' => 'btn btn-default', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>
            </div>
        <?php } ?> -->
    </div>
    <div class="panel-body">
        <?php if(Yii::app()->user->getState('instalasi_id') == 2 || Yii::app()->user->getState('instalasi_id') == 4){?>
            <?php  
            $controller_url = 'DaftarPasien';
            if(Yii::app()->user->getState('modul_id') == 86) { //MCU
                if(!empty($this->init_urlcontroller_informasi)){
                    $controller_url = $this->init_urlcontroller_informasi;
                }
                
            }?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl($controller_url.'/Index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success',)); ?>
        <?php }?>

        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi));
        //$this->renderPartial($this->path_view.'_tabMenu',array());
        $this->renderPartial($this->path_view . '_menuAsesmen', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi));
        $this->renderPartial($this->path_view . '_dialog', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi));
        $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien)); ?>


    </div>
</div>