<table class="table table-bordered table-striped table-condensed" id="tableRiwayat">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nomor Transaksi</th>
            <th>Nomor BA</th>
            <th>Tanggal Pembuatan BA</th>
            <th>Termin</th>
            <th>Kepala Bidang/Bagian/Instalasi</th>
            <th>Tim Teknis</th>
            <th>Hasil Uji</th>
            <th>Ubah</th>
            <th>Cetak</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        $models = BaujifungsiT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id), array('order' => 'baujifungsi_id ASC'));
        $spkTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
        foreach ($models as $key => $value) {
            
            $teknisi = "-";
            $modTeknisi = PegtimteknisT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $value->suratperjanjiankerja_id, 'baujifungsi_id' => $value->baujifungsi_id));
            if(count($modTeknisi) > 0){
                $teknisi = "<ul>";
                foreach ($modTeknisi as $key => $val) {
                    $teknisi .= '
                        <li>'.$val->pegawai->namaLengkap.'</li>
                    ';
                }
                $teknisi .= "</ul>";
            }
            
            if(count($spkTermin) <= 0){
                $termin = "<td>Non Termin</td>";
            }else{
                $value->terminke = empty($value->terminke)? 1 : $value->terminke;
                $value->termin_persen = empty($value->termin_persen)? 100 : $value->termin_persen;
                $termin = "<td>".$value->terminke." (".$value->termin_persen."%)</td>";
            }
            
            if(!$value->suratperjanjiankerja->istermin){
                $termin = "<td>Non Termin</td>";
            }
            
            $value->terminke = ($value->terminke == 0)? 1 : $value->terminke;
            $urlDetail = $this->createUrl('Detail', array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'baujifungsi_id' =>  $value->baujifungsi_id));
            $urlEdit = $this->createUrl('Index', array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'baujifungsi_id' => $value->baujifungsi_id));
            echo "<tr>";
            echo "<td>".$no."</td>";
            echo "<td>".Chtml::link($value->baujifungsi_nomor, $urlDetail, array('title' => 'Detail', 'rel' => 'tooltip',"target"=>"iframe1", "onclick"=>"$('#dialogRiwayat').dialog('open');"))."</td>";
            echo "<td>".$value->nomor_beritaacara."</td>";
            echo "<td>". MyFormatter::formatDateTimeForUser($value->baujifungsi_tanggal)."</td>";
            echo $termin;
            echo "<td>".$value->pegawai->namaLengkap."</td>";
            echo "<td>".$teknisi."</td>";
            echo "<td>".$value->hasil_uji."</td>";
            echo '<td>' . CHtml::link('<i class="entypo-pencil"></i>', $urlEdit, array('title' => 'Ubah Data', 'rel' => 'tooltip')) . '</td>';
            echo '<td>' . CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip','onclick'=>"window.open('" . $this->createUrl('print', array('id' => $value->baujifungsi_id)) ."', 'printwin', 'left=100,top=100,width=790,height=1120')")) . '</td>';
            echo "</tr>";
            $no++;
        }
        ?>
    </tbody>
</table>
<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayat',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Berita Acara Uji Coba / Uji Fungsi',
        'autoOpen' => false,
        'width' => 1035,
        'height' => 750,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframe1" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>