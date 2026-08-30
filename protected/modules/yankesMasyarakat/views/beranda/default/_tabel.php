<div class="col-md-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            Sponsor yang paling banyak memberikan dana sponsor
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-condensed table-bordered table-striped">
            <thead>
                <th>No</th>
                <th>Nama Sponsor</th>
                <th>Jumlah Kegiatan</th>
                <th>Jumlah Dana</th>
            </thead>
            <tbody>
                <?php
                    foreach($tabel['dana'] as $det){
                        echo "<tr>";
                        echo "<td>".$det['no']."</td>";
                        echo "<td>".$det['nama']."</td>";
                        echo "<td>".$det['kegiatan']."</td>";
                        echo "<td style='text-align:right;'>".number_format($det['total_dana'],0,"",".")."</td>";
                        echo "</tr>";
                        if ($det['no'] == 10){
                            break;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            Pegawai paling banyak menerima sponsor
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-condensed table-bordered table-striped">
            <thead>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jumlah Sponsor</th>
            </thead>
            <tbody>
                <?php
                    foreach($tabel['pegawai'] as $det){
                        echo "<tr>";
                        echo "<td>".$det['no']."</td>";
                        echo "<td>".$det['nama']."</td>";
                        echo "<td>".$det['nip']."</td>";
                        echo "<td>".$det['sponsor']."</td>";
                        echo "</tr>";
                        if ($det['no'] == 10){
                            break;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>