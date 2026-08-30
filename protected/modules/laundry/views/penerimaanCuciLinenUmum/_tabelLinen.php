<?php
/**
 * view ini digunakan untuk menampilkan data penerimaan dalam bentuk tabel
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://172.9.1.15/simpp/docs/> 
 */

echo CHtml::css('#table-linen thead tr th{vertical-align:middle;}'); ?>

<table class="table table-striped table-condensed table-bordered" id="table-linen">
    <thead>
        <tr>
            <th>Nama Linen <span class="required">*</span></th>
            <th>Jumlah <span class="required">*</span></th>
            <th>Satuan <span class="required">*</span></th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php echo $this->renderPartial($this->path_view.'_tabelPengajuanLinen',array('modDetail'=>$modDetail),true);?>
    </tbody>
</table>
