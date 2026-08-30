<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));

    $format = new MyFormatter();
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php
                echo CHtml::hiddenField('filter', 'rujukankeluar_id', array('disabled' => 'disabled')) .
                    '<div class="control-group">
                        ' . CHtml::label('Tujuan Rujukan', 'rujukankeluar_id', array('class' => 'control-label')) . ' 
                        <div class="controls">
                            ' . $form->dropDownList($model, 'rujukankeluar_id', CHtml::listData(RujukankeluarM::model()->findAll(), 'rujukankeluar_id', 'rumahsakitrujukan'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )) . '
                    </div>
                </div>';

                // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                //     'id' => 'kunjungan',
                //     'slide' => true,
                //     'content' => array(
                //         'content2' => array(
                //             'header' => '<i class="entypo-doc-text"></i> Berdasarkan Tujuan Rujukan',
                //             'isi' => CHtml::hiddenField('filter', 'rujukankeluar_id', array('disabled' => 'disabled')) .
                //                 '<div class="control-group">
                //                         ' . CHtml::label('Tujuan Rujukan', 'rujukankeluar_id', array('class' => 'control-label')) . ' 
                //                         <div class="controls">
                //                             ' . $form->dropDownList($model, 'rujukankeluar_id', CHtml::listData(RujukankeluarM::model()->findAll(), 'rujukankeluar_id', 'rumahsakitrujukan'), array(
                //                     'class' => 'form-control', 'multiple' => 'multiple'
                //                 )) . '
                //                     </div>
                //                 </div>',
                //             'active' => true,
                //         ),
                //     ),
                //     //                                    'htmlOptions'=>array('class'=>'aw',)
                // ));
                ?>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t(
            'mds',
            '{icon} Search',
            array(
                '{icon}' => '<i class="entypo-check"></i>'
            )
        ), array(
            'class' => 'btn btn-danger',
            'type' => 'submit',
            'id' => 'btn_simpan',
            'title' => 'Cari',
            'ajax' => array(
                'type' => 'GET',
                'url' => array("/" . $this->route),
                'update' => '#tableLaporan',
                'beforeSend' => 'function(){
                $("#tableLaporan").addClass("animation-loading");
            }',
                'complete' => 'function(){
                $("#tableLaporan").removeClass("animation-loading");
            }',
            )
        ));
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'class' => 'btn btn-default',
                'title' => 'Cari',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<script type="text/javascript">
    function cek_all_tindakan(obj) {
        if ($(obj).is(':checked')) {
            $("#rujukankeluar").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#rujukankeluar").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    $(document).ready(function() {
        $('.checkbox').addClass();
    });
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>