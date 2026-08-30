
<table class='table table-bordered table-condensed table-striped' id='tabel-list-obat'>
    <thead>
        <tr>
            <th>Nama/Kode Obat Rumah Sakit</th>
            <th>Nama/Kode PRB BPJS</th>
            <th>Signa/<br/>Signa 2</th>
            <th>Cara Penggunaan Obat</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($model as $key => $det){
                echo $this->renderPartial('detail/form/row/_3_detail_obat',['model'=>$det], true);
            }
        ?>
    </tbody>
</table>