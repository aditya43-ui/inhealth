<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Tautan SDKI-SLKI</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Lookup Ms' => array('index'),
            $model->tautansdki_slki_det_id,
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
                    'value' => $model->tautansdkiSlki->diagnosakep->diagnosakep_nama,
                ),
                array(
                    'label' => 'Tingkat Luaran Keperawatan',
                    'type' => 'raw',
                    'value' => $model->tautansdkiSlki->tingkatluarankeperawatan,
                ),
                array(
                    'label' => 'Nama Luaran Keperawatan',
                    'type' => 'raw',
                    'value' => $model->luarankeperawatan_nama,
                ),
                array(
                    'label' => 'Status',
                    'type' => 'raw',
                    'value' => ($model->tautansdki_slki_aktif == 1) ? "Aktif" : "Tidak Aktif",
                ),
            ),
        ));
        ?>
        <?php //echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->tautansdki_slki_det_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')).'&nbsp;'; 
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tautan SDKI-SLKI', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'));
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>