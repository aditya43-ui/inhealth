<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Interpretasi Skor</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Psinterpretasiskor Ms' => array('index'),
            $model->interpretasiskor_id,
        );
        $arrMenu = array();
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'interpretasiskor_id',
                'intepretasi_nama',
                'interpretasijmlskor',
                'interpretasimin',
                'interpretasimax',
                'catatan',
                'interpretasiskor_aktif',
            ),
        )); ?>

        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Interpretasi Skor', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>

<!--/div-->