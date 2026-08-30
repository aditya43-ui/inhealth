<?php
$this->breadcrumbs = array(
    'Informasi Mutasi Barang',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Mutasi Barang</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('gumutasibrg-t-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Mutasi Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_table', array('model' => $model)); ?>
            </div>
        </div>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <!--search-form-->
        <?php
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        //        $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gumutasibrg-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <script>
            function setPegawai(nama, id) {
                $("#pegpengirim_id").val(id);
                $("#pegpengirim").val(nama);
                $("#dialogPegawai2").dialog("close");
            }
        </script>
        <?php
        //========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDetail',
            'options' => array(
                'title' => 'Detail Mutasi Barang',
                'autoOpen' => false,
                'modal' => true,
                'zIndex' => 1002,
                'width' => 750,
                'height' => 420,
                'resizable' => false,
                'close' => 'js:function(){$.fn.yiiGridView.update("gumutasibrg-t-grid", {
                        data: $("#gumutasibrg-t-search").serialize()
                });}',
            ),
        ));
        echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
        $this->endWidget();
        ?>
        <?php
        //========= Dialog untuk Melihat detail Pesan Barang =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDetailPesan',
            'options' => array(
                'title' => 'Detail Pemesanan Barang',
                'autoOpen' => false,
                'modal' => true,
                'zIndex' => 1002,
                'width' => 750,
                'height' => 500,
                'resizable' => false,
            ),
        ));
        echo '<iframe src="" name="frameDetailPesan" style="width: 100%; height: 98%;"></iframe>';
        $this->endWidget();
        ?>
        <?php
        //=============================== Dialog Pegawai =======================================
        $this->beginWidget(
            'zii.widgets.jui.CJuiDialog',
            array(
                'id' => 'dialogPegawai2',
                'options' => array(
                    'title' => 'Pegawai Pengirim',
                    'autoOpen' => false,
                    'width' => 840,
                    'height' => 420,
                    'resizable' => true,
                ),
            )
        );
        $modPegawai = new PegawaiM('search');
        $modPegawai->unsetAttributes();
        $modPegawai->pegawai_aktif = true;
        if (isset($_GET['PegawaiM'])) {
            $modPegawai->attributes = $_GET['PegawaiM'];
        }
        $prov = $modPegawai->search();
        $prov->sort->defaultOrder = 'nama_pegawai';
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'pegawai-m-grid',
            'dataProvider' => $prov,
            'filter' => $modPegawai,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => function ($data) {
                        return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                            "class" => "btn-small",
                            "onclick" => " setPegawai('" . $data->namaLengkap . "'," . $data->pegawai_id . "); return false; "
                        ));
                    },
                ),
                array(
                    'name' => 'nama_pegawai',
                    // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                    'value' => '$data->namaLengkap',
                ),
                array(
                    'name' => 'jabatan_id',
                    'type' => 'raw',
                    'value' => function ($data) {
                        if (empty($data->jabatan_id)) return "-";
                        $jabatan = JabatanM::model()->findByPk($data->jabatan_id);
                        return $jabatan->jabatan_nama;
                    },
                    'filter' => CHtml::activeDropDownlist(
                        $modPegawai,
                        'jabatan_id',
                        CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true'), 'jabatan_id', 'jabatan_nama'),
                        array(
                            'empty' => '--- Pilih ---', 'class' => 'span3',
                        )
                    ),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        //=============================== END Pegawai =======================================
        ?>
    </div>
</div>
<script>
</script>