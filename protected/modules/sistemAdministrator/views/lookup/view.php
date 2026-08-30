<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i>
            <?php
            if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                echo 'Lihat <b>Etiket</b>';
            } else {
                echo 'Lihat <b>Lookup</b>';
            }
            ?>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
            if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                $this->breadcrumbs = array(
                    'Etiket' => array('index'),
                    $model->lookup_id,
                );
            } else {
                $this->breadcrumbs = array(
                    'Lookup Ms' => array('index'),
                    $model->lookup_id,
                );
            }

        $this->menu = array(
            //        array('label'=>Yii::t('mds','View').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
        );

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'lookup_type',
                'lookup_kode',
                'lookup_urutan',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->lookup_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        ));
        ?>
        <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->lookup_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-danger')
            );
        ?>
        <?php
            if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Pengaturan Etiket', array('{icon}' => '<i class="icon-file icon-white"></i>')),
                    $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                    array('class' => 'btn btn-success',)
                );
            } else {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Pengaturan Lookup', array('{icon}' => '<i class="icon-file icon-white"></i>')),
                    $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                    array('class' => 'btn btn-success',)
                );
            }
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>