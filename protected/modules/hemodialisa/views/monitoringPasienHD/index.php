<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Monitoring Pasien Hemodialisa
        </div>
        <?php if (!empty($_GET['pendaftaran_id'])) { ?>
            <span style="float:right; padding: 10px">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl('/hemodialisa/pemeriksaanAsesmenPerawat', array('pendaftaran_id' => isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : '')), array('class' => 'btn btn-sm btn-danger')); ?>
            </span>
        <?php } ?>
    </div>
    <div class="panel-body">
        <!--<legend class="rim2">Pemeriksaan Pasien <b><?php // echo $modPendaftaran->ruangan->ruangan_nama;   ?></b></legend>-->
        <?php
        $this->breadcrumbs = array(
            'Sapendidikan Ms' => array('index'),
            'Manage',
        );
        ?>
        <?php
        $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
        $this->renderPartial('_tabMenu', array());
        $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien));
        ?>
       <div>
            <iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
        </div>

    </div>
</div>