<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'gzpesanmenudiet-t-search',
            'type' => 'horizontal',
        )); ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo Chtml::label("Tgl. Pesan Menu", 'tglpesanmenu', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                        $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                        Sampai dengan
                  </label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2'),
                        )); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo Chtml::label("No Pesan Menu", 'nopesnamenu', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopesanmenu', array('class' => 'span4 angkahuruf-only', 'maxlength' => 20, 'autofocus' => true, 'placeholder' => 'No. Pesan Menu')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">


                <?php
                if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
                    echo $form->dropDownListRow(
                        $model,
                        'instalasi_id',
                        Chtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_id', 'instalasi_nama'),
                        array(
                            'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/ActionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                                'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                            )
                        )
                    );

                ?>
                    <div class="control-group">
                        <?php echo Chtml::label("Ruangan", 'ruangan_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'ruangan_id', array(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                <?php

                    //echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span4', 'maxlength'=>20)); 
                } ?>

                <!--<div class ="control-group">
                            <?php // echo Chtml::label("Jenis Pesanan", 'jenispesanmenu', array('class'=>'control-label')) 
                            ?>
                        <div class="controls">
                            <?php // echo $form->dropDownList($model,'jenispesanmenu', LookupM::getItems('jenispesanmenu'),array('empty'=>'-- Pilih --','class'=>'span4', 'maxlength'=>20)); 
                            ?>
                        </div>
                    </div>-->

                </td>
                <td>
                    <div class="control-group">
                        <?php echo Chtml::label("Nama Pemesan", 'nama_pemesan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'nama_pemesan', array('class' => 'span4 hurufs-only', 'maxlength' => 100, 'placeholder' => 'Nama Pemesan')); ?>
                        </div>
                    </div>

                    <?php echo $form->dropDownListRow($model, 'status_terima', Params::getStatusTerima(), array('class' => 'span4', 'empty' => '-- Pilih --')) ?>
                    <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); 
                    ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php
            //  echo CHtml::htmlButton(
            //     Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            //     array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
            // ); 
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/InformasiPendamping'), array(
                'class' => 'btn btn-default', 'title' => 'Ulang',
                'onclick' => 'return refreshForm(this);'
            ));
            ?>

            <?php
            if (in_array($model->jenispesanmenu, array(Params::JENISPESANMENU_PASIEN, Params::JENISPESANMENU_PENDAMPING))) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')
                );

                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')),
                    array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')
                );

                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')),
                    array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')
                );
            }
            ?>

            <?php
            $content = $this->renderPartial('gizi.views.tips.informasiPesanMenuDiet', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>

    </div>
</div>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintInformasiPendamping');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gzpesanmenudiet-t-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>