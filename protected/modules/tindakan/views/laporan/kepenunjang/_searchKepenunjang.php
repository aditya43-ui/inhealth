<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        label.checkbox {
            width: 185px;
            display: inline-block;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
            <?php //$format = new MyFormatter(); 
            ?>
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
            <div id='searching'>
                <?php
                echo CHtml::hiddenField('filter', 'ruanganpenunj_id', array('disabled' => 'disabled')) .
                    '<div class="control-group">
                    ' . CHtml::label('Ruangan Penunjang', 'ruanganpenunj_id', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'ruanganpenunj_id', $model->getRuanganKepenunjang(), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )) . '
                    </div>
                </div>';

                // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                //     'id' => 'penunjang',
                //     'slide' => true,
                //     'content' => array(
                //         'content2' => array(
                //             'multi' => 'multi',
                //             'header' => 'Berdasarkan Ruangan Penunjang',
                //             'isi' => CHtml::hiddenField('filter', 'ruanganpenunj_id', array('disabled' => 'disabled')) .
                //                 '<div class="control-group">
                //                     ' . CHtml::label('Ruangan Penunjang', 'ruanganpenunj_id', array('class' => 'control-label')) . ' 
                //                     <div class="controls">
                //                         ' . $form->dropDownList($model, 'ruanganpenunj_id', $model->getRuanganKepenunjang(), array(
                //                     'class' => 'form-control', 'multiple' => 'multiple'
                //                 )) . '
                //                     </div>
                //                 </div>',
                //             'active' => true,
                //         ),
                //     ),
                // ));
                ?>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'ajax' => array(
                'type' => 'GET',
                'url' => array("/" . $this->route),
                'update' => '#tableLaporan',
                'beforeSend' => 'function(){
			$("#tableLaporan").addClass("animation-loading");
		}',
                'complete' => 'function(){
			$("#tableLaporan").removeClass("animation-loading");
		}',
            ))
        );
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  
  //$("#big").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script type="text/javascript">
    function cek_all_tindakan(obj) {
        if ($(obj).is(':checked')) {
            $("#penunjang").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#penunjang").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
</script>
<?php $this->renderPartial('rawatJalan.views.laporan._jsFunctions', array('model' => $model)); ?>