<table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>Jenis Darah <span class="required">*</span></th>
            <th>Gol. Darah <span class="required">*</span></th>
            <th>Rhesus</th>
            <th>Jumlah <span class="required">*</span></th>
            <!--<th>Tgl. Perlu <span class="required">*</span></th>
            <th>No. PPUP</th>-->
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="tab_detail">
        <?php 
        if(count($arrDetail) > 0){
            foreach ($arrDetail as $key => $value) {
                echo '<tr>';
                echo '<td>'.($key+1).'</td>';
                echo '<td>'.$value->jeniskomponendarah->jeniskomponenedarah_nama.'</td>';
                echo '<td>'.$value->golongandarah.'</td>';
                echo '<td>'.CustomFunction::cekNamaRhesus($value->rhesus).'</td>';
                echo '<td style="text-align:right">'.number_format($value->jumlah).'</td>';
                /*echo '<td>'. MyFormatter::formatDateTimeForUser($value->tgl_perlu).'</td>';
                echo '<td>'.$value->no_ppup.'</td>';*/
                echo '<td>'.$value->keterangan_det.'</td>';
                echo '<td></td>';
                echo '</tr>';
            }
        }else{
            echo $this->renderPartial("_rowTabel", array('sendiri'=>true,'form'=>$form,'model'=>$model,'modDetail'=>$modDetail), true); 
        }
        ?>
    </tbody>
</table>