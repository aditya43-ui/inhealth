<?php
$this->breadcrumbs = array(
    'pejabatpengadaan Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pejabatpengadaan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengaturan <b>Pejabat Pengadaan</b></div>
    </div>
    <div class="panel-body">
        <?php
        if (!empty($_GET['sukses'])) {
            $this->widget('bootstrap.widgets.BootAlert');
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        }
        echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn'));
        ?>

        <div class="cari-lanjut2 search-form" style="display:none">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
                'modDet' => $modDet,
            ));
            ?>
        </div>
        <hr>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Pejabat Pengadaan</b></div>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pejabatpengadaan-m-grid',
                    'dataProvider' => $model->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        [
                            'header' => 'Periode',
                            'name' => 'periodeanggaran_id',
                            'value' => function($data){
                                return $data->anggaran_nama;
                            },
                            'filter' => CHtml::activeDropDownList($model, 'periodeanggaran_id', 
                                        CHtml ::listData(PeriodeanggaranK::model()->findAll(['order'=>'tahunanggaran DESC']), 'periodeanggaran_id', 'anggaran_nama')                                        
                                    ,['empty'=>'-- Pilih --'])
                        ],
                        array(
                            'header' => 'Jabatan',
                            'name' => 'jabatan_pengadaan',
                            'filter' => ''
                        ),
                        array(
                            'header' => 'Nama Pegawai',
                            'name' => 'pegawai_id',
                            'value' => function ($data) {
                                echo $data->pegawai->namaLengkap;
                            },
                            'filter' => ''
                        ),
                        array(
                            'header' => 'Bidang/Bagian/Instalasi',
                            'name' => 'pegawai_id',
                            'value' => function ($data) {
                                $cekinstalasi = PejabatpengadaandetM::model()->findAllByAttributes(array("pejabatpengadaan_id" => $data->pejabatpengadaan_id));

                                if (count($cekinstalasi) > 0) {
                                    foreach ($cekinstalasi as $dt) {
                                        echo '<ul>';
                                        if (!empty($dt->pejabatpengadaan_id)) {
                                            echo '<li>' . $dt->instalasi->instalasi_nama . '</li>';
                                        }
                                        echo '</ul>';
                                    }
                                } else {
                                    echo "-";
                                }
                            },
                            'filter' => ''
                        ),
                        array(
                            'header' => 'No. SK',
                            'name' => 'no_sk',
                            'value' => function($data) {
                                return $data->no_sk;
                            }
                        ),
                        array(
                            'header' => 'Tanggal SK',
                            'name' => 'tgl_sk',
                            'value' => function($data) {
                                return MyFormatter::formatDateTimeForUser($data->tgl_sk);
                            }
                        ),
                        array(
                            'header' => '<center>Status</center>',
                            'value' => '($data->pejabatpengadaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => Yii::t('zii', 'View'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(),
                            ),
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
                            'header' => Yii::t('zii', 'Delete'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'width:80px;'),
                            'template' => '{remove}{add}{delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='glyphicon glyphicon-remove'></i> ",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->pejabatpengadaan_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                    'visible' => '(($data->pejabatpengadaan_aktif) ? TRUE : FALSE)',
                                ),
                                'add' => array(
                                    'label' => "<i class='glyphicon glyphicon-ok'></i> ",
                                    'options' => array('title' => Yii::t('mds', 'Add Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/active",array("id"=>$data->pejabatpengadaan_id))',
                                    'click' => 'function(){active(this);return false;}',
                                    'visible' => '(($data->pejabatpengadaan_aktif) ? FALSE : TRUE)',
                                ),
                                'delete' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                    $("table").find("input[type=text]").each(function(){
                        cekForm(this);
                    });
                     $("table").find("select").each(function(){
                        cekForm(this);
                    });
                    $(".kode-alatmedis").keyup(function() {
                        setKodeAlatMedis(this);
                    });
                    $(".hurufs-only").keyup(function() {
                        setHurufsOnly(this);
                    });
                }',
                ));
                ?>
            </div>
        </div>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Pejabat Pengadaan', array('{icon}' => '<i class="entypo-plus"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
        $content = $this->renderPartial('sistemAdministrator.views.tips.master', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

        $urlPrint = $this->createUrl('print');

        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#pejabatpengadaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>
<script type="text/javascript">
    function cekForm(obj)
    {
        $("#pejabatpengadaan-m-search :input[name='" + obj.name + "']").val(obj.value);
    }

    function nonActive(obj) {
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'GET',
                            url: obj.href,
                            data: {}, //
                            dataType: "json",
                            success: function (data) {
                                $.fn.yiiGridView.update('pejabatpengadaan-m-grid');
                                if (data.sukses > 0) {
                                    myAlert('Data berhasil dinonaktifkan!');
                                } else {
                                    myAlert('Data gagal dinonaktifkan!');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
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
        myConfirm("Yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'GET',
                            url: obj.href,
                            data: {}, //
                            dataType: "json",
                            success: function (data) {
                                $.fn.yiiGridView.update('pejabatpengadaan-m-grid');
                                if (data.sukses > 0) {
                                    myAlert('Data berhasil diaktifkan!');
                                } else {
                                    myAlert('Data gagal diaktifkan!');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
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