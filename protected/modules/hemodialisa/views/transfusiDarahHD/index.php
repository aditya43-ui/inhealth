<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Observasi Transfusi Darah
            <?php if (!empty($_GET['pendaftaran_id'])) {?>
            <span style="float:right; padding: 10px">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), array('/hemodialisa/pemeriksaanAsesmenPerawat', 'pendaftaran_id' => $_GET['pendaftaran_id'], 'konsulpoli_id' => $_GET['konsulpoli_id']), array('class' => 'btn btn-sm btn-danger')); ?>
            </span>
        <?php } ?>
        </div>
    </div>
    <div class="panel-body">
        <!--<legend class="rim2">Pemeriksaan Pasien <b><?php // echo $modPendaftaran->ruangan->ruangan_nama;  ?></b></legend>-->
        <?php
        $this->breadcrumbs = array(
            'Sapendidikan Ms' => array('index'),
            'Manage',
        );
        ?>
        <?php
        $this->renderPartial('_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
        $this->renderPartial('_tabMenu', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
        $this->renderPartial('_jsFunctions', array("modPasien" => $modPasien));
        ?>
        <div>
            <iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
        </div>

    </div></div>