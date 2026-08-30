<?php
$this->breadcrumbs = array(
    'Laporan Stok',
);
$url = Yii::app()->createUrl($this->module->id . '/' . $this->id . '/FrameStock&id=1');
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('#search-laporan').submit(function(){
		$.fn.yiiGridView.update('laporan-grid', {
			data: $(this).serialize()
		});
		return false;
	});
	");
?>
<style>
    #checkBoxList {
        width: 100%;
    }

    #checkBoxList label.checkbox {
        width: 170px;
        display: inline-block;
        margin-right: 10px;
    }

    #checkBoxList label.checkbox label {
        padding-left: 10px;
    }

    #checkBoxList2 {
        width: 100%;
    }

    #checkBoxList2 label.checkbox {
        width: 170px;
        display: inline-block;
        margin-right: 10px;
    }

    #checkBoxList2 label.checkbox label {
        padding-left: 10px;
    }

    #checkBoxList3 {
        width: 100%;
    }

    #checkBoxList3 label.checkbox {
        width: 170px;
        display: inline-block;
        margin-right: 10px;
    }

    #checkBoxList3 label.checkbox label {
        padding-left: 10px;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-newspaper"></i> Laporan <b>Stock</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'type' => 'horizontal',
                    'id' => 'search-laporan',
                    'focus' => '#' . CHtml::activeId($model, 'obatalkes_nama'),
                )); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-search"></i> Pencarian
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo CHtml::hiddenField('type', ''); ?>
                                <?php echo CHtml::hiddenField('filter', 'jenisobatalkes_id', array('disabled' => 'disabled')); ?>
                                <div class="control-group">
                                    <?php echo CHtml::label('Jenis Obat Alkes', 'jenisobatalkes_id', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->dropDownList($model, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->ItemsFarmasi, 'jenisobatalkes_id', 'jenisobatalkes_nama'), array(
                                            'class' => 'form-control', 'multiple' => 'multiple'
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <?php //echo CHtml::hiddenField('filter', 'obatalkes_kategori', array('disabled' => 'disabled')); 
                                ?>
                                <div class="control-group">
                                    <?php echo CHtml::label('Kategori Obat Alkes', 'obatalkes_kategori', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->dropDownList($model, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                                            'class' => 'form-control', 'multiple' => 'multiple'
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php //echo CHtml::hiddenField('filter', 'obatalkes_golongan', array('disabled' => 'disabled')); 
                                ?>
                                <div class="control-group">
                                    <?php echo CHtml::label('Golongan Obat Alkes', 'obatalkes_golongan', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->dropDownList($model, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array(
                                            'class' => 'form-control', 'multiple' => 'multiple'
                                        )); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        $criIns = new CDbCriteria();
                                        //$criIns->addCondition("revenuecenter = true");
                                        $criIns->addCondition(" instalasi_aktif = TRUE ");
                                        $criIns->order = " instalasi_nama ASC ";
                                        echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll($criIns), 'instalasi_id', 'instalasi_nama'), array(
                                            'class' => 'form-control', 'multiple' => 'multiple'
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->dropDownList(
                                            $model,
                                            'ruangan_id',
                                            array(),
                                            array('class' => 'form-control', 'multiple' => 'multiple')
                                        ); ?>
                                    </div>
                                </div>
                                <?php
                                //									$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                //										'id' => 'stok',
                                //										'slide' => true,
                                //										'content' => array(
                                //											'content2' => array(
                                //												'multi' => 'multi',
                                //												'header' => 'Berdasarkan Stok',
                                //												'isi' => CHtml::hiddenField('filter', 'Stok', array('disabled' => 'disabled')) . 
                                //													'<div class="control-group">
                                //														'.CHtml::label('Stok','status', array('class' => 'control-label')).' 
                                //														<div class="controls">
                                //															'.$form->dropDownList($model,'stok', array('2'=>'Stok Keluar','1'=>'Stok Masuk'),array(
                                //															'class'=>'form-control', 'multiple'=>'multiple')).'											
                                //														</div>
                                //													</div>',
                                //												'active' => true,
                                //											),
                                //										),
                                //									));
                                ?>

                                <div id='searching'>
                                    <div class="control-group">
                                        <label class="control-label">Berdasarkan Stok</label>
                                        <div class="controls">
                                            <table id="stok">
                                                <tr>
                                                    <td><?php echo CHtml::checkBox('GFInfostokobatalkesruanganV[qtystok_in]', false, array()) ?> <label for="GFInfostokobatalkesruanganV_qtystok_in">Stok Masuk 0</label></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo CHtml::checkBox('GFInfostokobatalkesruanganV[qtystok_out]', false, array()) ?> <label for="GFInfostokobatalkesruanganV_qtystok_out">Stok Keluar 0</label></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <?php echo CHtml::htmlButton(
                                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                            ); ?>

                            <?php echo CHtml::link(
                                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                                Yii::app()->createUrl($this->module->id . '/laporan/stock'),
                                array(
                                    'title' => 'Ulang',
                                    'class' => 'btn btn-default',
                                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                                )
                            ); ?>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Stock</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial($this->path_view_ku . 'stock/_tableStock', array('model' => $model)); ?>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-chart-bar"></i> Grafik
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial($this->path_view_ku . '_tab'); ?>
                        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
                    </div>
                </div>

                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintStock');
                $this->renderPartial($this->path_view_ku . '_footer', array('urlPrint' => $urlPrint, 'url' => $url));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view_ku . '_jsFunctions', array('model' => $model)); ?>
<script>
    function checkAll() {
        if ($('#pilihSemua').is(':checked')) {
            $('#checkBoxList').each(function() {
                $(this).find('input').attr('checked', true);
            });
        } else {
            $('#checkBoxList').each(function() {
                $(this).find('input').removeAttr('checked');
            });
        }
    }

    function checkAll2() {
        if ($('#pilihSemua2').is(':checked')) {
            $('#checkBoxList2').each(function() {
                $(this).find('input').attr('checked', true);
            });
        } else {
            $('#checkBoxList2').each(function() {
                $(this).find('input').removeAttr('checked');
            });
        }
    }

    function checkAll3() {
        if ($('#pilihSemua3').is(':checked')) {
            $('#checkBoxList3').each(function() {
                $(this).find('input').attr('checked', true);
            });
        } else {
            $('#checkBoxList3').each(function() {
                $(this).find('input').removeAttr('checked');
            });
        }
    }

    $(document).ready(function() {
        checkAll();
        checkAll3();
    });
</script>