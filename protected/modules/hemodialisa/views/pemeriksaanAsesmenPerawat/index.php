<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Asesmen Perawat
        </div>
        <?php 
        $module = Yii::app()->controller->module->id;
        if ($module == 'mcu') { ?>
                <div class="panel-options">
                   
                    <?php echo CHtml::link(Yii::t('mds', '<div style="color:white">{icon} Kembali</div>', array('{icon}' => '<i style="color:white" class="entypo-back"></i>')), $this->createUrl('/'.$this->module->id.'/InformasiDaftarPasienMC/Index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-red')) . "&nbsp&nbsp"; ?>
                </div>
        <?php }elseif ($module == 'rawatDarurat') { ?>
                <div class="panel-options">
                   <?php echo CHtml::link(Yii::t('mds', '<div style="color:white">{icon} Kembali</div>', array('{icon}' => '<i style="color:white" class="entypo-back"></i>')), $this->createUrl('/'.$this->module->id.'/DaftarPasien/Index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-red')) . "&nbsp&nbsp"; ?>
                </div>
        <?php }else if($module == 'rawatJalan'){ ?>
		<div class="panel-options">
			<?php echo CHtml::link(Yii::t('mds', '<div style="color:white">{icon} Kembali</div>', array('{icon}' => '<i style="color:white" class="entypo-back"></i>')), $this->createUrl('/'.$this->module->id.'/DaftarPasien/Index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-red')) . "&nbsp&nbsp"; ?>	
		</div>
       <?php }else if($module == 'rawatInap'){ ?>
		<div class="panel-options">
			<?php echo CHtml::link(Yii::t('mds', '<div style="color:white">{icon} Kembali</div>', array('{icon}' => '<i style="color:white" class="entypo-back"></i>')), $this->createUrl('/'.$this->module->id.'/PasienRawatInap/Index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-red')) . "&nbsp&nbsp"; ?>	
		</div>
         <?php }else if($module == 'perawatanIntensif'){ ?>
		<div class="panel-options">
			<?php echo CHtml::link(Yii::t('mds', '<div style="color:white">{icon} Kembali</div>', array('{icon}' => '<i style="color:white" class="entypo-back"></i>')), $this->createUrl('/'.$this->module->id.'/PasienRawatIntensif/Index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-red')) . "&nbsp&nbsp"; ?>	
		</div>
        <?php }else if($module == 'rehabMedis'){ ?>
		<div class="panel-options">
			<?php echo CHtml::link(Yii::t('mds', '<div style="color:white">{icon} Kembali</div>', array('{icon}' => '<i style="color:white" class="entypo-back"></i>')), $this->createUrl('/'.$this->module->id.'/DaftarPasien/Index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-red')) . "&nbsp&nbsp"; ?>		
		</div>
        <?php }else if($module == 'hemodialisa'){ ?>
                <div class="panel-options">
			<?php echo CHtml::link(Yii::t('mds', '<div style="color:white">{icon} Kembali</div>', array('{icon}' => '<i style="color:white" class="entypo-back"></i>')), $this->createUrl('/'.$this->module->id.'/DaftarPasien/Index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-red')) . "&nbsp&nbsp"; ?>		
		</div>
        <?php } ?>
    </div>
    <div class="panel-body">
        <?php 
            $this->widget('bootstrap.widgets.BootAlert');
            $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
            //$this->renderPartial($this->path_view.'_tabMenu',array());
            $this->renderPartial($this->path_view.'_menuAsesmen',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
            $this->renderPartial($this->path_view.'_dialog',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
            $this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien)); ?>

    </div>
</div>


