<div class="white-container">
    <legend class="rim2">Informasi <b>Penggajian Pegawai</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Kppenggajianpeg Ts'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('kppenggajianpeg-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Penggajian Pegawai</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'kppenggajianpeg-t-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'NIP',
                        'name'=>'nomorindukpegawai',
                        'value'=>'$data->pegawai->nomorindukpegawai',
                    ),
                    array(
                        'header'=>'Nama Pegawai',
                        'name'=>'nama_pegawai',
                        'value'=>'$data->pegawai->nama_pegawai',
                    ),
                     array(
                        'header'=>'Jabatan',
                        'value'=>'(isset($data->pegawai->jabatan->jabatan_nama) ? $data->pegawai->jabatan->jabatan_nama : "-")',
                    ),
                    //  array(
                    //     'header'=>'No. Rekening',
                    //     'value'=>'$data->pegawai->norekening',
                    // ),
                    array(
                        'header'=>'NPWP',
                        'value'=>'$data->pegawai->npwp',
                    ),
                    array(
                        'header'=>'Tanggal Penggajian',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglpenggajian)',
                    ),
                    'nopenggajian',
                    'keterangan',
                    'mengetahui',
                    array(
                        'header'=>'Rincian',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i>",Yii::app()->createUrl(\'kepegawaian/PenggajianpegT/detailPenggajian&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Detail Penggajian"))',
                      'htmlOptions'=>array('style'=>'text-align: center; width:60px'),
                        ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="search-form box">
        <?php $this->renderPartial('_search',array('model'=>$model)); ?>
    </fieldset>
</div>