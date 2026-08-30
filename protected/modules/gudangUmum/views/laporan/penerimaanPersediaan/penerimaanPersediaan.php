<?php
$this->breadcrumbs = array(
    'Laporan Penerimaan Persediaan',
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#barang-m-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('barang-m-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
?>
<?php Yii::app()->clientScript->registerScriptFile('js/dropdownMulti.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Penerimaan Persediaan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $url = Yii::app()->createUrl($this->module->id . '/' . $this->id . '/FramePenerimaanPersediaan&id=1');
        Yii::app()->clientScript->registerScript('search', "
                        $('.search-button').click(function(){
                                $('.search-form').toggle();
                                return false;
                        });
                        $('#laporan-search').submit(function(){
                                $.fn.yiiGridView.update('laporan-grid', {
                                        data: $(this).serialize()
                                });
                                return false;
                        });
                        ");
        ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'laporan-search',
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
                        <div class="control-group">
                            <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                            <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                            <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                            <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                            <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                            <?php echo CHtml::label("Periode Laporan", 'tglpenerimaan', array('class' => 'control-label')) ?>
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
                        <?php
                        echo CHtml::hiddenField('filter', 'supplier_id', array('disabled' => 'disabled')) .
                            '<div class="control-group">
                        ' . CHtml::label('Supplier', 'supplier_id', array('class' => 'control-label')) . ' 
                        <div class="controls">
                            ' . $form->dropDownList($model, 'supplier_id', $model->getDropSuppAktif(), array('multiple' => 'multiple', 'class' => 'form-control')) . '
                        </div>
                    </div>';
                        ?>
                    </div>
                </div>
                <!--<div class="row">
                    <div class="col-sm-6">
                        <div id='searching'>
                            <?php
                            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                'id' => 'kondisi',
                                'slide' => true,
                                'content' => array(
                                    'content2' => array(
                                        'multi' => 'multi',
                                        'header' => 'Berdasarkan Supplier',
                                        'isi' => CHtml::hiddenField('filter', 'supplier_id', array('disabled' => 'disabled')) .
                                            '<div class="control-group">
                                                ' . CHtml::label('Supplier', 'supplier_id', array('class' => 'control-label')) . ' 
                                                <div class="controls">
                                                    ' . $form->dropDownList($model, 'supplier_id', $model->getDropSuppAktif(), array('multiple' => 'multiple', 'class' => 'form-control')) . '
                                                </div>
                                            </div>',
                                        'active' => true,
                                    ),
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                </div>-->
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>

                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'
                        )
                    ); ?>
                </div>
                <?php
                $this->endWidget();
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Persediaan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('penerimaanPersediaan/_penerimaanPersediaan', array('model' => $model)); ?>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintPenerimaanPersediaan');
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-chart-pie"></i> Grafik
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php $this->renderPartial('_footer_pisah', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
    </div>
</div>

<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
<script>
    function konfirmasi() {
        location.reload();
    }

    jQuery(document).ready(function() {
        dropMulti('<?php echo CHtml::activeId($model, 'supplier_id') ?>');
    });
</script>