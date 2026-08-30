<?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
    <thead>
        <tr>                  
            <th>Nama Barang</th>
            <th>Nomor Aset</th>  
            

        </tr>
    </thead>
    <tbody>
        <?php
            foreach($modDetail as $det ){
        ?>
        <tr>
            <td><?php echo $det->invperalatan_namabrg ?></td>
            <td><?php echo $det->invperalatan_kode ?></td>

        </tr>
        
        
        <?php
            }
        ?>
    </tbody>
</table>