<div class="span12">
    <table class="table table-bordered table-condensed table-striped" id="tabel_kuesioner">
        <thead>
            <tr>
                <th style="text-align:center;">No</th>
                <th>Jenis Dokumen Diperiksa</th>
                <th style="text-align:center;">Lengkap Sesuai</th>
                <th style="text-align:center;">Lengkap Tidak Sesuai / Tidak Lengkap</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $modPertanyaan = LookupM::model()->findAll("lookup_type = 'dokumenpemeriksaanadministratif' ORDER BY lookup_urutan ASC");            
            
            /* end */
            $no = 1;
            foreach ($modPertanyaan as $value) {
                echo '<tr>';
                echo '<td style="text-align:center;"><label>'.$no.'</label></td>';
                echo '<td><label>'.$value->lookup_name;echo CHtml::hiddenField('DokumenpemeriksaanadministratifT['.$value->lookup_urutan.'][jenis_dokumen]', $value->lookup_name, array('class'=>'span4')).'</label></td>';
                echo '<td style="text-align:center;">'.CHtml::radioButtonList('DokumenpemeriksaanadministratifT['.$value->lookup_urutan.'][islengkap]', 'islengkap', array(1=>'',), array('onclick'=>'setValidasi(this,'.$value->lookup_urutan.')','class'=>'cekLengkap','labelOptions'=>array('style'=>'display:inline'))).'</td>';
                echo '<td style="text-align:center;">'.CHtml::radioButtonList('DokumenpemeriksaanadministratifT['.$value->lookup_urutan.'][islengkap]', 0, array(0=>'',), array('onclick'=>'setValidasi(this,'.$value->lookup_urutan.')','class'=>'cekLengkap','labelOptions'=>array('style'=>'display:inline'))).'</td>';
                echo '<td>'.CHtml::textArea('DokumenpemeriksaanadministratifT['.$value->lookup_urutan.'][keterangan]', '', array('class'=>'span3')).'</td>';
                echo '</tr>';
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>