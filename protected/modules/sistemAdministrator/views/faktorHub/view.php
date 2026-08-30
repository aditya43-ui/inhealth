<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kondisi Klinis Terkait</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Lookup Ms' => array('index'),
            $model->faktorhub_id,
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
                    'label' => 'Nama Kondisi Klinis Terkait',
                    'value' => $model->faktorhub_nama,
                ),
                array(
                    'label' => 'Indikator',
                    'type' => 'raw',
                    'value' => $this->renderPartial($this->path_view . '_indikator', array('faktorhub_id' => $model->faktorhub_id), true),
                ),
            ),
        ));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->faktorhub_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . '&nbsp;'; ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kondisi Klinis Terkait', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>