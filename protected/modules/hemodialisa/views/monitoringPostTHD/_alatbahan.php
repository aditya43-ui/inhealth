<div class="panel-body">
    <div class="row-fluid">
        <div class="span12">
                <table class="table table-striped">
                    <tr>
                        <th style="width: 50px"><center>No</center></th>
                        <th><center>Nama Alat dan Bahan</center></th>
                        <th style="width: 50px;"><center>Jumlah</center></th>
                    </tr>
                    <?php if(count($modAlatBahan) > 0) : 
                        $i=1;
                        foreach ($modAlatBahan as $row) :
                    ?>
                    <tr>
                        <td><center><?= $i; ?></center></td>
                        <td><center><?php
                        $obatalkes = ObatalkesM::model()->findByPk($row->obatalkes_id);
                        echo $obatalkes->obatalkes_nama; ?></center></td>
                        <td><center><?= $row->qty_reseptur; ?></center></td>
                    </tr>
                    <?php 
                    $i++;
                    endforeach;
                    else : ?>
                    <tr>
                        <td colspan="3"><center>Tidak ada data</center></td>
                    </tr>
                    <?php endif; ?>
                </table>
        </div>
    </div>
</div>
