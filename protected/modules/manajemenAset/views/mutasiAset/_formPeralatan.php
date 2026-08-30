<?php
/**
 * Berisi tabel detail mutasi aset peralatan
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * 
 */
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
        <i class="glyphicon glyphicon-file"></i> Data Aset
        </div>
    </div>
    <div class="panel-body overflow-x">
        <table class="table table-bordered table-striped datatable" id="tableDetailBarang">
            <thead>
                <tr>
                    <th width="100">Nama Aset</th>
                    <th>Kode Aset</th>
                    <th>Merk/Ukuran/Bahan</th>
                    <th width="100">Tahun Beli</th>
                    <th width="100">Keadaan Aset</th>
                    <th width="100">Keterangan</th>
                    <th width="100" class="button-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($model->isNewRecord) {
                    echo $this->renderPartial('ajaxLoadAset', array(), true); 
                } else {
                    foreach ($detail as $item) {
                        $inven = InvperalatanT::model()->findByPk($item->invperalatan_id);
                        echo $this->renderPartial('rowAset', array(
                            'inven'=>$inven, 'detail'=>$item
                        ), true);
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>









