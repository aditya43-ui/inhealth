<?php

/**
 * @author          Yusuf Putra Anugrah<yusufputra@.com>
 * @version         2.0.0
 * @documentation   http://kbase..com
 * @issue           RSST-2164
 * - Menambahkan Menu Informasi Daftar Rekam Medis Inaktif
 * -  
 */
?>
<?php $linkHalaman = CustomFunction::getUrlByMenuID(3583); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('#penerimaankantongdarah-r-search').submit(function(){
        $.fn.yiiGridView.update('penerimaankantongdarah-r-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$this->breadcrumbs = array(
    'Informasi Daftar Retensi Rekam Medis',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Daftar Retensi Rekam Medis</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Daftar Retensi Rekam Medis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'penerimaankantongdarah-r-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'replaceUrl' => true,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'Tanggal Retensi',
                            'value' => function ($data) {
                                echo MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglinaktifrekammedis)));
                            },
                        ),
                        array(
                            'header' => 'No. Retensi',
                            'value' => function ($data) {
                                echo $data->noretensiinaktif;
                            },
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'value' => function ($data) {
                                echo $data->no_rekam_medik;
                            },
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'value' => function ($data) {
                                echo $data->nama_pasien;
                            },
                        ),
                        array(
                            'header' => 'Tanggal Lahir',
                            'value' => function ($data) {
                                if (!empty($data->tanggal_lahir)) {
                                    echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                                } else {
                                    echo '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Jenis Kelamin',
                            'value' => function ($data) {
                                if (!empty($data->jeniskelamin)) {
                                    echo $data->jeniskelamin;
                                } else {
                                    echo '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Alamat',
                            'value' => function ($data) {
                                if (!empty($data->alamat_pasien)) {
                                    echo $data->alamat_pasien;
                                } else {
                                    echo '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Kunjungan Terakhir',
                            'value' => function ($data) {
                                echo MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglkunjunganterakhir)));
                            },
                        ),
                        array(
                            'header' => 'Masa Fungsi',
                            'value' => function ($data) {
                                if (!empty($data->masafungsirm)) {
                                    echo $data->masafungsirm;
                                } else {
                                    echo '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Aktifkan',
                            'type' => 'raw',
                            'value' => '!empty($data->pasien_id)?CHtml::link("<span style=\'font-size:20px;color:green;\'><i class=\'glyphicon glyphicon-ok-sign\'></i> </span>", "javascript:inaktifRecord($data->pasien_id,$data->no_rekam_medik)",array("id"=>"$data->pasien_id","rel"=>"tooltip","title"=>"Inaktif Aktif","data-placement"=>"left")):CHtml::link("<i class=\'glyphicon glyphicon-ok-sign\'></i> ", "javascript:inaktifRecord($data->pasien_id,$data->no_rekam_medik)",array("id"=>"$data->pasien_id","rel"=>"tooltip","title"=>"Inaktif daftar"));',
                            'htmlOptions' => array('style' => 'text-align: center; width:80px'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/delete');
        ?>
    </div>
</div>
<script>
    function inaktifRecord(id, nomor) {
        var id = id;
        var nomor = nomor;
        var url = '<?php echo $url; ?>';
        myConfirm('Apakah Anda akan mengaktifkan kembali dokumen rekam medis no.' + nomor + '?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'sukses') {
                            $.fn.yiiGridView.update('penerimaankantongdarah-r-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>