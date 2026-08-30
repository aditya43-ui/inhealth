
<table class="table table-bordered table-striped table-condensed" id="tabel-adl">
    <thead>
        <tr>
            <th>NO</th>
            <th>FUNGSI</th>
            <th>SKOR</th>
            <th>KETERANGAN</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 0;

            foreach($loadMaster as $det){
                $modDet = new RMAsesmenFisioterapiGeriatridetT;
                $modDet->attributes = $det;
                $modDet->asesmen_fisioterapi_geriatridet_id = isset($det['asesmen_fisioterapi_geriatridet_id'])?$det['asesmen_fisioterapi_geriatridet_id']:null;
                echo $this->renderPartial($this->path_view.'tabel/_rowADP',array('model' => $modDet, 'i'=>$i, 'master' => $det),true);
                $i++;
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="text-align: right;">
                <label>Total Skor :</label>
            </td>
            <td>
                <?php
                    echo $form->textField($model,'total_skor',array('class' => 'total_skor numbers-only span1', 'readonly'=>true));
                    echo $form->hiddenField($model,'keterangan_skor',array('class' => 'keterangan_skor', 'readonly'=>true));
                ?>
            </td>
            <td></td>
        </tr>
    </tfoot>
</table>

<table border="0" id="tabel-keterangan-skor" style="margin-left:50px;" hidden>
    <tr>
        <td colspan="3"><label>Total Skor Indeks Barthel</label></td>
    </tr>
    <tr no-row="20">
        <td width="10%">&nbsp;</td>
        <td><label>20</label></td>
        <td><label>: Mandiri</label></td>
    </tr>
    <tr no-row="12-19">
        <td>&nbsp;</td>
        <td><label>12-19</label></td>
        <td><label>: Ketergantungan Ringan</label></td>
    </tr>
    <tr  no-row="9-11">
        <td>&nbsp;</td>
        <td><label>9-11</label></td>
        <td><label>: Ketergantungan Sedang</label></td>
    </tr>
    <tr no-row="5-8">
        <td>&nbsp;</td>
        <td><label>5-8</label></td>
        <td><label>: Ketergantungan Berat</label></td>
    </tr>
    <tr no-row="0-4">
        <td>&nbsp;</td>
        <td><label>0-4</label></td>
        <td><label>: Ketergantungan Total</label></td>
    </tr>
</table>
