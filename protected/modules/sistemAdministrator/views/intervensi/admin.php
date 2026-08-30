<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Tautan SDKI-SIKI</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Bataskarakteristik Ms' => array('index'),
            'Manage',
        );
        $tab = $this->hasTab;
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
                    <i class="entypo-credit-card"></i> Tabel <b>Tautan SDKI-SIKI</b>
                </div>
            </div>
            <div class="panel-body table-responsive">

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
					'value' => '$data->intervensidet_id',
				),*/
                        array(
                            'header' => 'Diagnosa Keperawatan',
                            'name' => 'diagnosakep_nama',
                            'value' => 'isset($data->diagnosakep_nama) ? $data->diagnosakep_nama : " - "',
                        ),
                        array(
                            'header' => 'Nama Intervensi',
                            'name' => 'intervensi_nama',
                            'value' => 'isset($data->intervensi->intervensi_nama) ? $data->intervensi->intervensi_nama : " - "',
                        ),
                        array(
                            'header' => 'Indikator',
                            'name' => 'intervensidet_indikator',
                            'value' => 'isset($data->intervensidet_indikator) ? $data->intervensidet_indikator : " - "',
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->intervensidet_aktif == true ? \'Aktif\': \'Tidak Aktif\')',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),

                        ),
                        array(
                            'header' => 'Lihat',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            //'class' => 'bootstrap.widgets.BootButtonColumn',
                            //'template' => '{view}',
                            //'buttons' => array(
                            //'view' => array(
                            //'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->intervensi_id,"tab"=>$data->hasTab))',
                            'value' => function ($data) use ($tab) {
                                echo Chtml::link("<i class='icon-form-lihat'></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view', array('id' => $data->intervensi_id, 'tab' => ($tab == TRUE) ? 'frame' : null)));
                            }
                            //),
                        ),
                        array(
                            'header' => 'Ubah',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            //'class' => 'bootstrap.widgets.BootButtonColumn',
                            //'template' => '{update}',
                            //'buttons' => array(
                            //	'update' => array(
                            //'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->intervensi_id,"tab"=>$data->hasTab))',
                            'value' => function ($data) use ($tab) {
                                echo Chtml::link("<i class='icon-form-ubah'></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update', array('id' => $data->intervensi_id, 'tab' => ($tab == TRUE) ? 'frame' : null)));
                            }
                            //	),
                            //),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->intervensidet_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->intervensidet_id)",array("id"=>"$data->intervensidet_id","rel"=>"tooltip","title"=>"Menonaktifkan Intervensi"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->intervensidet_id)",array("id"=>"$data->intervensidet_id","rel"=>"tooltip","title"=>"Hapus Intervensi")):CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->intervensidet_id)",array("id"=>"$data->intervensidet_id","rel"=>"tooltip","title"=>"Hapus Intervensi"));',
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
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Tautan SDKI-SIKI', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => ($this->hasTab == TRUE) ? 'frame' : null)),
                array('title' => 'Tambah Tautan SDKI-SIKI', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $tips = array(
                '0' => 'lihat',
                '1' => 'ubah',
                '2' => 'nonaktif',
                '3' => 'hapus',
                '7' => 'pencarianlanjut',
                '8' => 'cari',
                '4' => 'masterPDF',
                '5' => 'masterEXCEL',
                '6' => 'masterPRINT',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('content' => $content));
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
        $("input[name='SAIntervensidetM[intervensi_nama]']").focus();
    });
</script>