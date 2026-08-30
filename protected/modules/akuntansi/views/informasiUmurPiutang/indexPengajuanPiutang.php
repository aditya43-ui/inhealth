<style>
    .pagination {
        text-align: right;
        display: inline;
    }
</style>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#rekonsiliasibank-info-search').submit(function(){
	$('#informasirekonsiliasibank-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasirekonsiliasibank-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
$format = new MyFormatter();
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'rekonsiliasibank-info-search',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'rekonsiliasibank_no'),
        )); ?>
        <?php $this->renderPartial($this->path_view . '_searchPengajuanPiutang', array(
            'model' => $model, 'format' => $format, 'form' => $form
        )); ?>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('id' => 'btn_resset', 'class' => 'btn btn-default', 'type' => 'reset')); ?>
            <?php
            $tips = array(
                '0' => 'tanggal',
                '1' => 'cari',
                '2' => 'ulang2',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <!--<div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan Piutang</b></div>-->
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Umur Piutang Perorangan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
            'id' => 'informasirekonsiliasibank-grid',
            'dataProvider' => $model->searchInformasi(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'value' => '$row+1',
                    'footer' => ' '
                ),
                array(
                    'header' => 'Tanggal Invoice',
                    'name' => 'tglpembayaran',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembayaran)',
                    'footer' => ' '
                ),
                array(
                    'header' => 'No. Invoice',
                    'name' => 'nopembayaran',
                    'value' => '$data->nopembayaran',
                    'footer' => ' '
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'name' => 'pasien_id',
                    'value' => function ($data) {
                        $modsup = PasienM::model()->findByPk($data->pasien_id);
                        return $modsup->no_rekam_medik;
                    },
                    'footer' => ' '
                ),
                array(
                    'header' => 'Nama',
                    'name' => 'nama_pasien',
                    'value' => '$data->namadepan." ".$data->nama_pasien',
                    'footer' => 'Total',
                    'footerHtmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Total Piutang (Rp)',
                    'name' => 'totaliurbiaya',
                    'value' => 'number_format($data->totaliurbiaya,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => 'sum(totaliurbiaya)',
                    'footerHtmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Sisa Piutang (Rp)',
                    'name' => 'totalsisatagihan',
                    'value' => 'number_format($data->totalsisatagihan,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => 'sum(totalsisatagihan)',
                    'footerHtmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Umur Piutang',
                    'name' => 'lama_piutang',
                    'value' => function ($data) {
                        if ($data->totalsisatagihan == 0) {
                            return '0 Hari';
                        } else {
                            return number_format($data->lama_piutang, 0, "", ".") . " Hari";
                        }
                    },
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => ' '
                ),
                array(
                    'header' => '0-30 Hari (Rp)',
                    'name' => 'sd_0_30',
                    'value' => function ($data) {
                        if ($data->sd_0_30 == 0) {
                            return '-';
                        } else {
                            return number_format($data->sd_0_30, 0, '', '.');
                        }
                    },
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => 'sum(sd_0_30)',
                    'footerHtmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => '31-60 Hari (Rp)',
                    'name' => 'sd_31_60',
                    'value' => function ($data) {
                        if ($data->sd_31_60 == 0) {
                            return '-';
                        } else {
                            return number_format($data->sd_31_60, 0, '', '.');
                        }
                    },
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => 'sum(sd_31_60)',
                    'footerHtmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => '61-90 Hari (Rp)',
                    'name' => 'sd_31_60',
                    'value' => function ($data) {
                        if ($data->sd_31_60 == 0) {
                            return '-';
                        } else {
                            return number_format($data->sd_31_60, 0, '', '.');
                        }
                    },
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => 'sum(sd_31_60)',
                    'footerHtmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => '> 90 Hari (Rp)',
                    'name' => 'sd_91',
                    'value' => function ($data) {
                        if ($data->sd_91 == 0) {
                            return '-';
                        } else {
                            return number_format($data->sd_91, 0, '', '.');
                        }
                    },
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer' => 'sum(sd_91)',
                    'footerHtmlOptions' => array('style' => 'text-align: right;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>
</div>