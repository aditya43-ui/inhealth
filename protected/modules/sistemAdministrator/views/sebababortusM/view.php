<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Sebab Abortus</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Pssebababortus Ms' => array('index'),
            $model->sebababortus_id,
        );
        $arrMenu = array();
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'sebababortus_id',
                'kelsebababortus_id',
                'sebababortus_nama',
                'sebababortus_namalain',
                'sebababortus_aktif',
            ),
        ));
        ?>

        <div class="form-actions">
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Sebab Abortus', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
            $this->widget('UserTips', array('type' => 'view'));
            ?>
        </div>
    </div>
</div>