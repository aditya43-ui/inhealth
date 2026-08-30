<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'search-laporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        table {
            margin-bottom: 0px;
        }

        .form-actions {
            padding: 4px;
            margin-top: 5px;
        }

        .nav-tabs>li>a {
            display: block;
            cursor: pointer;
        }

        .nav-tabs>.active a:hover {
            cursor: pointer;
        }
    </style>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-search"></i> Pencarian
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= CHtml::hiddenField('hitung', '0'); ?>
                    <div class="control-group">
                        <?= CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
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
                        <?= CHtml::label("Unit Kerja", 'unitkerja_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?= $form->dropDownList($model, 'unitkerja_id', $unit, ['class' => 'form-control', 'multiple' => 'multiple']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <?= CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onClick' => 'getData()', 'id' => 'btn_simpan')); ?>
                <!--?= CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onClick'=>'cari()', 'id' => 'btn_simpan')); ?-->
                <?= CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->route) . '";}); return false;')); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function refreshForm() {
        window.location.href = "<?= Yii::app()->createUrl($this->route); ?>";
    }

    function ubahJnsPeriode() {
        var obj = $("#<?= CHtml::activeId($model, 'jns_periode') ?>");
        if (obj.val() == 'hari') {
            $('.hari').show();
            $('.bulan').hide();
            $('.tahun').hide();
        } else if (obj.val() == 'bulan') {
            $('.hari').hide();
            $('.bulan').show();
            $('.tahun').hide();
        } else if (obj.val() == 'tahun') {
            $('.hari').hide();
            $('.bulan').hide();
            $('.tahun').show();
        }
    }

    function cari() {
        var tgl_awal = $("#SEPegawaimutasiR_tgl_awal").val();
        var tgl_akhir = $("#SEPegawaimutasiR_tgl_akhir").val();
        var unit_id = $("#SEPegawaimutasiR_unitkerja_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getData') ?>',
            dataType: "json",
            data: {
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir,
                unit_id: unit_id
            },
            success: function(data) {
                console.log(data);
            }
        });
    }
    ubahJnsPeriode();
</script>