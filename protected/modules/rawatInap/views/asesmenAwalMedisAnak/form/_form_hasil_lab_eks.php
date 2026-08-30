<?php
    $drop = LookupM::getItemsUrutan('pemeriksaan_lab');
?>
<table class="table table-bordered table-condensed table-striped form-utama" id="tabel-hasil-eks" del="hasileks">
    <thead>
            <tr>
                <th>Nama Pemeriksaan</th>
                <th>Tgl. Pemeriksaan</th>
                <th>Hasil Pemeriksaan</th>
                <th width="1%"><?= CHtml::link("<i class='fa fa-plus 2x'></i>",'javascript:;',['onclick'=>'addPeriksaLuar(this)','class'=>'btn btn-primary','style'=>'border-radius:50%;padding:5px;color:#fff !important;','rel'=>'tooltip','title'=>'Tambah pemeriksaan hasil lab eksternal','data-placement'=>'left']) ?></th>
            </tr>
    </thead>
    <tbody class="form-body">
        <?php
            if (!empty($model->set_periksa_lab_dari_luar)){
                foreach($model->set_periksa_lab_dari_luar as $i => $det){
                    $det->tgl_pemeriksaan = !empty($det->tgl_pemeriksaan)?MyFormatter::formatDateTimeForUser($det->tgl_pemeriksaan):null;
                    echo $this->renderPartial('rawatInap.views.asesmenAwalMedisAnak.form/row/_row_eks',['model'=>$det,'i'=>$i,'drop'=>$drop], true);
                }
            }
        ?>
    </tbody>
</table>

