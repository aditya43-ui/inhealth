<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>SIKI</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Lookup Ms' => array('index'),
            $model->implementasikep_id,
        );
        $this->menu = array(
            //        array('label'=>Yii::t('mds','View').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
        );
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'Intervensi Keperawatan',
                    'value' => $model->jenisintervensi->jenisintervensi_nama,
                ),
                array(
                    'label' => 'Jenis Intervensi Keperawatan',
                    'value' => $model->jenistindakan,
                ),
                array(
                    'label' => 'Indikator',
                    'type' => 'raw',
                    'value' => $this->renderPartial($this->path_view . '_indikator', array('implementasikep_id' => $model->implementasikep_id), true),
                ),
            ),
        ));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} SIKI', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>