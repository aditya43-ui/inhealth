<?php
$this->breadcrumbs = array(
    'Pengaturan Hari Libur',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('kpharilibur-m-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-layer-group"></i> Pengaturan <b>Hari Libur</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

                <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
                <div class="cari-lanjut search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                    )); ?>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Hari Libur</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'kpharilibur-m-grid',
                            'dataProvider' => $model->searchHariLibur(),
                            'filter' => $model,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                        : ($row+1)',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'name' => 'tglharilibur',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglharilibur)',
                                    'filter' => $this->widget(
                                        'MyDateTimePicker',
                                        array(
                                            'model' => $model,
                                            'attribute' => 'tglharilibur',
                                            'mode' => 'date',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2', 'id' => 'tglharilibur', 'placeholder' => $format->formatDateTimeForUser(date("Y-m-d")), 'style' => 'width:25%;'),
                                        ),
                                        true
                                    ),
                                ),
                                'namaharilibur',
                                array(
                                    'name' => 'harilibur_aktif',
                                    'type' => 'raw',
                                    'value' => '(($data->harilibur_aktif) ? "Aktif" : "Tidak Aktif")',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                    'filter' => false,
                                ),
                                array(
                                    'header' => 'Lihat',
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    'template' => '{view}',
                                    'buttons' => array(
                                        'view' => array(),
                                    ),
                                ),
                                array(
                                    'header' => 'Ubah',
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    'template' => '{update}',
                                    'buttons' => array(
                                        'update' => array(),
                                    ),
                                ),
                                array(
                                    'header' => 'Hapus',
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                    'template' => '{remove} {add} {delete}',
                                    'buttons' => array(
                                        'remove' => array(
                                            'label' => "<i class='icon-form-silang'></i>",
                                            'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                            'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->harilibur_id))',
                                            'click' => 'function(){nonActive(this);return false;}',
                                            'visible' => '(($data->harilibur_aktif)? TRUE : FALSE)'
                                        ),
                                        'add' => array(
                                            'label' => "<i class='icon-form-check'></i>",
                                            'options' => array('title' => Yii::t('mds', 'Add Temporary')),
                                            'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/active",array("id"=>$data->harilibur_id))',
                                            'click' => 'function(){active(this);return false;}',
                                            'visible' => '(($data->harilibur_aktif)? FALSE : TRUE)'
                                        ),
                                        'delete' => array(),
                                    )
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                            $("table").find("input[type=text]").each(function(){
                                cekForm(this);
                            })
                            $("table").find("select").each(function(){
                                cekForm(this);
                            })
                            jQuery(\'#tglharilibur\').datepicker(jQuery.extend({
                                showMonthAfterYear:false}, 
                                jQuery.datepicker.regional[\'id\'], 
                               {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                               \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                               \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                            jQuery(\'#tglharilibur\').on(\'click\', function(){jQuery(\'#tglharilibur\').datepicker(\'show\');});		
                            }',
                        )); ?>
                    </div>
                </div>

                <div class="form-actions">
                    <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Tambah Hari Libur', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                        $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                        array('title' => 'Tambah hari libur', 'class' => 'btn btn-danger',)
                    );
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                    $content = $this->renderPartial($this->path_view . 'tips/master', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    $urlPrint = $this->createUrl('print');
                    $js = <<< JSCRIPT
                function print(caraPrint){
                    window.open("${urlPrint}/"+$('#kpharilibur-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }
JSCRIPT;
                    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function cekForm(obj) {
        $("#kpharilibur-m-search :input[name='" + obj.name + "']").val(obj.value);
    }

    function nonActive(obj) {
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('kpharilibur-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal dinonaktifkan!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dinonaktifkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }

    function active(obj) {
        myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('kpharilibur-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal diaktifkan!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal diaktifkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }
</script>