<?php

/**
 *       - digunakan untuk menampilkan data dari view infohukumpoinpeg_v
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */
$this->breadcrumbs = array(
    'Informasi Cuti Pegawai',
);
Yii::app()->clientScript->registerScript('search', "
$('#kpinfohukumanpoinpeg-v-search').submit(function(){
    $.fn.yiiGridView.update('kpinfohukumanpoinpeg-v-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Cuti Pegawai</b>
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
                <?php echo $this->renderPartial($this->path_view . 'search._searchInfo', array('model' => $model)) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Cuti Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . 'table._tableInfo', array('model' => $model)) ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->renderPartial($this->path_view . 'dialog._dialogDetail', array('model' => $model)) ?>
<?php echo $this->renderPartial($this->path_view . 'dialog._dialogApprove', array('model' => $model)) ?>
<script type="text/javascript">
    function formPembatalanCuti(id) {
        myConfirm("Anda yakin untuk membatalakan cuti data ini?", "Peringatan", function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusPembatalanCuti'); ?>',
                    data: {
                        id: id
                    }, //
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 'ok') {
                            myAlert(data.keterangan);
                            $.fn.yiiGridView.update('kpinfohukumanpoinpeg-v-grid', {
                                data: $(this).serialize()
                            });
                        } else {
                            myAlert(data.keterangan);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
</script>