<div class="row-fluid">
    <div class="col-sm-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center;">No.</th>
                    <th>Nama Tim Teknis</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($modTeknisi)){
                    foreach ($modTeknisi as $key => $value) {
                        echo "
                        <tr>
                            <td  style='text-align: center;'>".
                                CHtml::textField('nama_pegawai', ($key+1), array('class'=>'span1', 'readonly'=>true, 'style'=>'text-align: center;'))
                            ."</td>
                            <td>".
                                CHtml::textField('nama_pegawai', $value->pegawai->nama_pegawai, array('class'=>'span3', 'readonly'=>true, 'style'=>'width: 260px;'))
                            ."</td>
                            <td>".
                                CHtml::textField('nomorindukpegawai', $value->pegawai->nomorindukpegawai, array('class'=>'span3', 'readonly'=>true, 'style'=>'width: 260px;'))
                            ."</td>
                            <td>".
                                CHtml::textField('jabatan_nama', $value->jabatan_timteknis, array('class'=>'span3', 'readonly'=>true, 'style'=>'width: 260px;'))
                            ."</td>
                        </tr>
                        ";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>