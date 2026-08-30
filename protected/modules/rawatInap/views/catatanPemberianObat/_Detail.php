
<table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pemberian</th>
                    <th>Jam Pemberian</th>
                    <th>Waktu Monitoring</th>
                    <th>Tanda</th>
                    <th>Initial</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($modDetail as $data){?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($data->tanggal_pemberian); ?></td>
                        <td><?php echo $data->jam_pemberian; ?></td>
                        <td><?php echo $data->waktu_monitoring; ?></td>
                        <td><?php echo $data->tanda; ?></td>
                        <td><?php echo $data->initial; ?></td>
                    </tr>
                <?php $no++;} ?>
                
            </tbody>
        </table>
       