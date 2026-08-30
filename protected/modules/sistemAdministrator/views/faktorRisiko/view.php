<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Faktor Risiko</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Lookup Ms' => array('index'),
            $model->faktorrisiko_id,
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
                    'label' => 'Diagnosa Keperawatan',
                    'value' => isset($model->diagnosakep_nama) ? $model->diagnosakep_nama : " - ",
                ),
                array(
                    'label' => 'Jenis Faktor Risiko',
                    'value' => isset($model->faktorrisiko_nama) ? $model->faktorrisiko_nama : " - ",
                ),
                array(
                    'label' => 'Faktor Risiko',
                    'value' => isset($model->jenisfaktorrisiko_nama) ? $model->jenisfaktorrisiko_nama : " - ",
                ),
                array(
                    'label' => 'Status',
                    'value' => $model->faktorrisiko_aktif == true ? 'Aktif' : 'Tidak Aktif',
                ),
            ),
        ));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->faktorrisiko_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . '&nbsp;'; ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Faktor Risiko', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>