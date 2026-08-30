<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>SLKI</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Lookup Ms' => array('index'),
            $model->kriteriahasil_id,
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
                    'label' => 'Luaran Keperawatan',
                    'value' => $model->luarankeperawatan_nama,
                ),
                array(
                    'label' => 'Kriteria Hasil',
                    'value' => $model->kriteriahasil_nama,
                ),
                array(
                    'label' => 'Indikator',
                    'type' => 'raw',
                    'value' => $this->renderPartial($this->path_view . '_indikator', array('kriteriahasil_id' => $model->kriteriahasil_id), true),
                ),
            ),
        ));
        ?>
        <?php //echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->kriteriahasil_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); 
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan SLKI', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>