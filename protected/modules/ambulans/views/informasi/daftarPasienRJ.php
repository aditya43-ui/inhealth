<style>
    .button-status {
        margin-right: 8px;
    }

    .badge-status {
        position: relative;
        top: 12px;
        left: 8px;
    }

    .btn-status {
        min-width: 190px;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rawat Jalan',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Informasi <b>Pasien Rawat Jalan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $urlTindakLanjut = Yii::app()->createUrl('actionAjax/pasienRujukRI');
        Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <?php $this->renderPartial('_searchPasienRJ', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Jalan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarPasien-grid',
                    'dataProvider' => $model->searchDaftarPasien(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        'no_urutantri',
                        //'pendaftaran.pasienpulang_id',	
                        array(
                            'name' => 'tgl_pendaftaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        ),
                        array(
                            'header' => 'No. Pendaftaran </br> No. Rekam Medik',
                            'name' => 'No_pendaftaran' . '/<br>' . 'No_rekam_medik',
                            'type' => 'raw',
                            'value' => '"$data->no_pendaftaran"."<br>"."$data->no_rekam_medik"',
                        ),
                        array(
                            'name' => 'nama_pasien' . '/<br>' . 'Alias',
                            'header' => 'Nama Pasien' . '/<br>' . 'Panggilan',
                            'type' => 'raw',
                            'value' => '"$data->NamaPasienNamaBin"',
                        ),
                        array(
                            'name' => 'alamat_pasien' . '/<br>' . 'RT RW',
                            'type' => 'raw',
                            'value' => '"$data->alamat_pasien"."<br>"."$data->RTRW"',
                        ),
                        array(
                            'name' => 'Penjamin' . '/<br>' . 'Jenis Penjamin',
                            'type' => 'raw',
                            'value' => '"$data->penjamin_nama"."<br>"."$data->carabayar_nama"',
                        ),
                        'nama_pegawai',
                        'jeniskasuspenyakit_nama',
                        //'statusperiksa',
                        array(
                            'header' => 'Status Periksa',
                            'type' => 'raw',
                            'value' => '$data->getStatus($data->statusperiksa,$data->pendaftaran_id)',
                        ),
                        array(
                            'header' => 'Pemakaian Ambulans',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => '(empty($data->pemakaianambulans_id)) ? CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",
												   Yii::app()->controller->createUrl("pemakaianAmbulanPasienRS/index",array("instalasi_id"=>Params::INSTALASI_ID_RJ,"pendaftaran_id"=>$data->pendaftaran_id,
																												 "modul_id"=>Yii::app()->session["modul_id"])),
												   array("class"=>"btn-small","rel"=>"tooltip","title"=>"Klik untuk pemakaian Ambulans")) : ""',
                        )
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<script>
    //document.getElementById('AMInfokunjunganrjV_tgl_awal_date').setAttribute("style","display:none;");
    //document.getElementById('AMInfokunjunganrjV_tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {
        var checklist = $('#AMInfokunjunganrjV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('AMInfokunjunganrjV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('AMInfokunjunganrjV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('AMInfokunjunganrjV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('AMInfokunjunganrjV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
</script>