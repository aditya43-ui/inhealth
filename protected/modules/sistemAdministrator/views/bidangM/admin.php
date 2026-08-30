<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-layer-group"></i> Pengaturan <b>Bidang</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Sabidang Ms' => array('index'),
                    'Manage',
                );
                $arrMenu = array();
                $this->menu = $arrMenu;
                Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('sabidang-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");
                $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
                <div class="cari-lanjut search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                    )); ?>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Bidang</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'sabidang-m-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array( //
                                ////'bidang_id',
                                array(
                                    'name' => 'bidang_id',
                                    'value' => '$data->bidang_id',
                                    'filter' => false,
                                ),
                                array(
                                    'name' => 'golongan_id',
                                    'filter' => CHtml::dropDownList('SABidangM[golongan_id]', $model->golongan_id, CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'), array('empty' => '-- Pilih --')),
                                    'value' => '$data->golongan->golongan_nama',
                                ),
                                array(
                                    'name' => 'bidang_kode',
                                    'filter' => Chtml::activeTextField($model, 'bidang_kode', array('class' => 'angkadot-only'))
                                ),
                                array(
                                    'name' => 'bidang_nama',
                                    'filter' => Chtml::activeTextField($model, 'bidang_nama', array('class' => 'custom-only'))
                                ),
                                array(
                                    'name' => 'bidang_namalainnya',
                                    'filter' => Chtml::activeTextField($model, 'bidang_namalainnya', array('class' => 'custom-only'))
                                ),
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->bidang_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                ),
                                //		array(
                                //                        'header'=>'Aktif',
                                //                        'class'=>'CCheckBoxColumn',     
                                //                        'selectableRows'=>0,
                                //                        'id'=>'rows',
                                //                        'checked'=>'$data->bidang_aktif',
                                //                ),
                                array(
                                    'header' => Yii::t('zii', 'View'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{view}',
                                ),
                                array(
                                    'header' => Yii::t('zii', 'Update'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{update}',
                                    'buttons' => array(
                                        'update' => array(
                                            'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                        ),
                                    ),
                                ),
                                array(
                                    'header' => 'Hapus',
                                    'type' => 'raw',
                                    'value' => '($data->bidang_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->bidang_id)",array("id"=>"$data->bidang_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->bidang_id)",array("id"=>"$data->bidang_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->bidang_id)",array("id"=>"$data->bidang_id","rel"=>"tooltip","title"=>"Hapus"));',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){
									jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
									$("table").find("input[type=text]").each(function(){
										cekForm(this);
									})
									 $("table").find("select").each(function(){
										cekForm(this);
									})
								}',
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo CHtml::link(
    Yii::t('mds', '{icon} Tambah Bidang', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
    $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
    array('title' => 'Tambah Bidang', 'class' => 'btn btn-danger',)
);
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
$content = $this->renderPartial($this->path_tips . 'master', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sabidang-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sabidang-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
</div>
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('sabidang-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!')
                        }
                    }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('sabidang-m-grid');
                        } else if (data.status == 'gagal_form') {
                            myAlert('Maaf data ini tidak bisa dihapus dikarenakan digunakan pada table lain.')
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
    $(document).ready(function() {
        $('input[name="SABidangM[bidang_kode]"]').focus();
    })
</script>