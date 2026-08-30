<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Asesmen Keperawatan
            <?php $pendaftaran_id = $_GET['id'];?>
            <?php if (!empty($pendaftaran_id)) 
               
         {?>
            <span style="float:right; padding: 10px">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), array('/hemodialisa/pemeriksaanAsesmenPerawat', 'pendaftaran_id' =>$pendaftaran_id, 'konsulpoli_id' => $_GET['konsulpoli_id']), array('class' => 'btn btn-sm btn-danger')); ?>
            </span>
        <?php } ?>
        </div>
    </div>
    <div class="panel-body" style="height: 2000px;">
        
        <iframe src="<?= $this->createUrl('/rawatDarurat/CPPT/index', ['pendaftaran_id' => $_GET['id']]) ?>" frameborder="0" width="100%" height="100%"></iframe>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        // $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        //     'id' => 'resikojatuh-form',
        //     'enableAjaxValidation' => false,
        //     'type' => 'horizontal',
        //     'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        // ));

//        echo $this->renderPartial($this->path_view . '_dataPasien', array(
//            'modPendaftaran' => $modPendaftaran,
//            'modPasien' => $modPasien,
//                ), true);

        // echo $this->renderPartial($this->path_perkembangan . 'index', array(
        //     'model' => $model,
        //     'modPendaftaran' => $modPendaftaran,
        //     'modPasien' => $modPasien,
        //     'modPenunjang' => $modPenunjang,
        //     'modAdmisi' => $modAdmisi,
        //     'path_perkembangan' => $this->path_perkembangan
        //         ), true);

//        echo $this->renderPartial($this->path_view.'_tabMenu', array(
//           
//        ), true);                        
//        
        ?>
        <!--        <div>
                <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
                </div>-->
        <?php
        //$content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
        //$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
        <?php
        // $this->endWidget();

        echo $this->renderPartial($this->path_view . '_jsFunction', array(), true);
        ?>


    </div>
</div>
