<div class="row">
<div class="col-md-12">
	<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Pengaturan Jadwal Dokter</div>
	</div>
	<div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Jadwal Dokter'=>array('index'),
            'Pengaturan',
    );


    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('#JadwaldokterM_ruangan_id').focus();
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rdjadwaldokter-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    if (isset($_GET['sukses'])):
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    endif;
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="search-form cari-lanjut" style="display:none;border:#333 solid 1px;padding:5px;border-radius: 5px;">
    <?php $this->renderPartial($this->path_view.'_search',array(
            'model'=>$model,
    )); ?>
    </div><!-- search-form -->

    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'rdjadwaldokter-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    ////'jadwaldokter_id',
                    array(
                            'name'=>'jadwaldokter_id',
                            'value'=>'$data->jadwaldokter_id',
                            'filter'=>false,
                    ),
    //		array(
    //                        'name'=>'instalasi_id',
    //                        'filter'=>  CHtml::listData(RuanganM::model()->InstalasiItems, 'instalasi_id', 'instalasi_nama'),
    //                        'value'=>'$data->instalasi->instalasi_nama',
    //                ),
                    array(
                            'header'=>'Ruangan',
                            'name'=>'ruangan_id',
                            'filter'=> CHtml::dropDownList('JadwaldokterM[ruangan_id]',$model->ruangan_id, CHtml::listData(PPPendaftaranT::model()->getRuanganJadwalDokter(), 'ruangan_id', 'ruangan_nama'),array('empty'=>'--Pilih--')),
                            'value'=>'$data->ruangan->ruangan_nama',
                    ),
					array(
                        'name'=>'pegawai_id',
                        'filter'=>  CHtml::dropDownList('JadwaldokterM[pegawai_id]',$model->pegawai_id,CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'), array('empty'=>'--Pilih--')),
                        'value'=>'(isset($data->pegawai->nama_pegawai) ? $data->pegawai->namaLengkap : "")',
                    ),
                    array(
                        'header'=>'Tanggal',
                        'name'=>'jadwaldokter_tgl',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->jadwaldokter_tgl)',
                        'filter'=>  CHtml::dropDownList('JadwaldokterM[bulan]', $model->bulan, Params::getBulan(), array('empty'=>'-- Pilih --')),
                    ),
                    'jadwaldokter_hari',
                    'jadwaldokter_buka',
                    array(
							'htmlOptions' => array('style'=>'text-align:center;'),
							'headerHtmlOptions' => array('style'=>'text-align:center;'),
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                             'buttons'=>array(
                                'view' => array (
                                    'options'=>array('rel'=>'tooltip','title'=>'Lihat Jadwal Dokter'),
                                    ),
                             ),
                    ),
                    array(
							'htmlOptions' => array('style'=>'text-align:center;'),
							'headerHtmlOptions' => array('style'=>'text-align:center;'),
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                'update' => array (
                                    'options'=>array('rel'=>'tooltip','title'=>'Ubah Jadwal Dokter'),
                                    ),
                             ),
                    ),
                    array(
							'htmlOptions' => array('style'=>'text-align:center;'),
							'headerHtmlOptions' => array('style'=>'text-align:center;'),
                            'header'=>Yii::t('zii','Delete'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(
                                            'delete'=> array(
                                                'options'=>array('rel'=>'tooltip','title'=>'Hapus Jadwal Dokter'),
                                            ),
                            )
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
    )); ?>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Jadwal Dokter', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('penjadwalan', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-danger', 'title' => 'Tambah jadwal dokter')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
   
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rdjadwaldokter-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>
        </div>
</div>

<script type="text/javascript">
 function cekForm(obj)
{
    $("#rdjadwaldokter-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
</script>
	</div>
</div>
</div>
