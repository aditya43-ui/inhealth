<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengaturan <b>Tanda dan Gejala</b></div>
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
        <div class="cari-lanjut search-form" style="display:none">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <hr>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Tanda dan Gejala</b></div>
            </div>
            <div class="panel-body overflow-x">

                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
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
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1): ($row+1)',
                        ),
                        array(
                            'header' => 'Diagnosa Keperawatan',
                            'name' => 'diagnosakep_nama',
                            'value' => 'isset($data->diagnosakep->diagnosakep_nama) ? $data->diagnosakep->diagnosakep_nama : " - "',
                            'filter' => Chtml::textField('SATandagejalaM[diagnosakep_nama]', $model->diagnosakep_nama, array('placeholder' => 'Ketik Diagnosa Keperawatan')),
                        ),
                        array(
                            'header' => 'Jenis Tanda dan Gejala',
                            'name' => 'jenistandagejala_id',
                            'value' => '$data->jenistandagejala_nama." - ".$data->subjenistandagejala_nama',
                            'filter' => Chtml::dropDownList('SATandagejalaM[jenistandagejala_id]', $model->jenistandagejala_id, $model->getDropDownJenis(), array('empty' => '--Pilih--')),
                        ),
                        array(
                            'header' => 'Tanda dan Gejala',
                            'name' => 'tandagejala_daftar_nama',
                            'value' => '$data->tandagejala_daftar_nama',
                            'filter' => Chtml::textField('SATandagejalaM[tandagejala_daftar_nama]', $model->tandagejala_daftar_nama, array('placeholder' => 'Ketik Tanda dan Gejala')),
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->tandagejala_aktif == true ? \'Aktif\': \'Tidak Aktif\')',
                            'filter' => CHtml::dropDownList('SATandagejalaM[tandagejala_aktif]', $model->tandagejala_aktif, array(0 => 'Tidak Aktif', 1 => 'Aktif'), array('empty' => '--Pilih--')),
                        ),
                        array(
                            'header' => Yii::t('zii', 'View'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->tandagejala_id))',
                                ),
                            ),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Update'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->tandagejala_id))',
                                ),
                            ),
                        ),
                        array(
                            'header' => '<center>Hapus</center>',
                            'type' => 'raw',
                            'value' => '($data->tandagejala_aktif)?'
                            . 'CHtml::link("<i class=\'glyphicon glyphicon-remove\'></i> ","javascript:removeTemporary($data->tandagejala_id)",array("id"=>"$data->tandagejala_id","rel"=>"tooltip","title"=>"Klik untuk menonaktifkan tanda dan gejala"))." ".CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->tandagejala_id)",array("id"=>"$data->tandagejala_id","rel"=>"tooltip","title"=>"Hapus Tanda dan Gejala")):'
                            . 'CHtml::link("<i class=\'glyphicon glyphicon-ok\'></i> ","javascript:addTemporary($data->tandagejala_id)",array("id"=>"$data->tandagejala_id","rel"=>"tooltip","title"=>"Klik untuk mengaktifkan tanda dan gejala"))." ".CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->tandagejala_id)",array("id"=>"$data->tandagejala_id","rel"=>"tooltip","title"=>"Hapus Tanda dan Gejala"));',
                            'htmlOptions' => array('style' => 'text-align: center; width:80px'),
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
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Tanda dan Gejala', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
        $content = $this->renderPartial('sistemAdministrator.views/tips/master', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

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
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('bataskarakteristik-m-grid');
                            } else {
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                        }, "json");
            }
        });
    }

    function addTemporary(id) {
        var url = '<?php echo $url . "/addTemporary"; ?>';
        myConfirm("Yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!", function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('bataskarakteristik-m-grid');
                            } else {
                                myAlert('Data Gagal di Aktifkan')
                            }
                        }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm("Yakin Akan Menghapus Data ini ?", "Perhatian!", function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('bataskarakteristik-m-grid');
                            } else if (data.status == 'gagal_form') {
                                myAlert('Data Gagal di Hapus')
                            }
                        }, "json");
            }
        });
    }

    $(document).ready(function () {
        $("input[name='SATandagejalaM[tandagejala_indikator]']").focus();
    });

</script>