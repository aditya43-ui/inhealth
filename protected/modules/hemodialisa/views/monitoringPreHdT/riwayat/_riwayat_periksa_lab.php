
<table class="table table-bordered table-condensed table-striped">
    <thead>
        <tr>
            <th>Nama Pemerikaan</th>
            <th>Tgl Pemerikaan</th>
            <th>Hasil Pemerikaan</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (!empty($model->set_periksa_internal_lab)){
                foreach($model->set_periksa_internal_lab as $det){                    
                    echo '<tr>';
                    echo '<td>'.$det->pemeriksaanlab_nama.'</td>';
                    echo '<td>'.(!empty($det->tglhasilpemeriksaanlab)?MyFormatter::formatDateTimeForUser($det->tglhasilpemeriksaanlab):null).'</td>';
                    echo '<td>'.CHtml::link('<i class="fa fa-list 2x"></i>','javascrip:;',['onclick'=>'lihat_detail('.$det->pasienmasukpenunjang_id.')']).'</td>';
                    echo '</tr>';
                }
            }
        ?>
    </tbody>
</table>