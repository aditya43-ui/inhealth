<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Metode Apgar</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Psmetodeapgar Ms' => array('index'),
            $model->metodeapgar_id,
        );

        $arrMenu = array();
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'metodeapgar_id',
                'akronim',
                'kriteria',
                'nilai_2',
                'nilai_1',
                'nilai_0',
                'metodeapgar_aktif',
            ),
        ));
        ?>

        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Metode Apgar', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>
<!--/div-->