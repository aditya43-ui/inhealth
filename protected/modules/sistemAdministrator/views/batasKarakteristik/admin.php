<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Faktor Penyebab</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Bataskarakteristik Ms' => array('index'),
            'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('bataskarakteristik-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Faktor Penyebab</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Tabel <b>Faktor Penyebab</b></h6>-->
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
                }
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'bataskarakteristik-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,

                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        /*
				array(
					'header' => 'ID',
					'value' => '$data->bataskarakteristikdet_id',
				),
				 * 
				 */
                        array(
                            'header' => 'Diagnosa Keperawatan',
                            'name' => 'diagnosakep_nama',
                            'value' => 'isset($data->diagnosakep_nama) ? $data->diagnosakep_nama : " - "',
                        ),
                        array(
                            'header' => 'Jenis Penyebab',
                            'name' => 'bataskarakteristik_nama',
                            'value' => 'isset($data->bataskarakteristik->bataskarakteristik_nama) ? $data->bataskarakteristik->bataskarakteristik_nama : " - "',
                        ),
                        array(
                            'header' => 'Nama Faktor Penyebab',
                            'name' => 'faktorpenyebab_daftar_id',
                            //					'value' => 'isset($data->bataskarakteristikdet_indikator) ? $data->bataskarakteristikdet_indikator : " - "',
                            'value' => function ($data) {
                                if (!empty($data->faktorpenyebab_daftar_id)) {
                                    $cekFaktor = FaktorpenyebabDaftarM::model()->findByPk($data->faktorpenyebab_daftar_id);
                                    echo !empty($cekFaktor) ? $cekFaktor->faktorpenyebab_daftar_nama : '-';
                                } else {
                                    echo '-';
                                }
                            },
                            'filter' => CHtml::activeDropDownList($model, 'faktorpenyebab_daftar_id', CHtml::listData($model->FaktorPenyebabItems, 'faktorpenyebab_daftar_id', 'faktorpenyebab_daftar_nama'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'header' => 'Status',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'value' => '($data->bataskarakteristikdet_aktif == true ? \'Aktif\': \'Tidak Aktif\')',
                            'filter' => CHtml::dropDownList(
                                'aktif',
                                $model->aktif,
                                array(
                                    '1' => 'Aktif',
                                    '0' => 'Tidak Aktif',
                                ),
                                array('empty' => '-- Pilih --')
                            )
                        ),
                        array(
                            'header' => 'Lihat',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->bataskarakteristik_id))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->bataskarakteristik_id))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->bataskarakteristikdet_aktif)?CHtml::link("<i class=\'glyphicon glyphicon-remove\'></i> ","javascript:removeTemporary($data->bataskarakteristikdet_id)",array("id"=>"$data->bataskarakteristikdet_id","rel"=>"tooltip","title"=>"Menonaktifkan Faktor Penyebab"))." ".CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->bataskarakteristikdet_id)",array("id"=>"$data->bataskarakteristikdet_id","rel"=>"tooltip","title"=>"Hapus Faktor Penyebab")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->bataskarakteristikdet_id)",array("id"=>"$data->bataskarakteristikdet_id","rel"=>"tooltip","title"=>"Hapus Faktor Penyebab"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
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
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Tambah Faktor Penyebab', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
        array('title' => 'Tambah Faktor Penyebab', 'class' => 'btn btn-danger')
    );
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    $content = $this->renderPartial('sistemAdministrator.views/tips/master', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#bataskarakteristik-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#bataskarakteristik-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>
</div>

<script>
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('bataskarakteristik-m-grid');
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
                            $.fn.yiiGridView.update('bataskarakteristik-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }

    $(document).ready(function() {
        $("input[name='SABataskarakteristikdetM[varSort1]']").focus();
    });
</script>