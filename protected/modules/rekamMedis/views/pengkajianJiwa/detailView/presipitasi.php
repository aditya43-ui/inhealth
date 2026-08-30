<div class="panel panel-success panel_detail"  id='panel_4'>
    <div class="panel-heading">
        <div class="panel-title">Faktor Presipitasi</div>
    </div>
    <div class="panel-body">
        <ol style="list-style: decimal">
            <li>
                <div>
                    Peristiwa yang dialami dalam waktu dekan<br/>
                    <?php echo $model->presipitasi_peristiwabrdialami ?>
                </div>
            </li>
            <li>
                <div>
                    Perubahan aktivitas hidup sehari-hari<br/>
                    <?php echo $model->presipitasi_perubahanadl ?>
                </div>
            </li>
            <li>
                <div>
                    Perubahan Fisik<br/>
                    <?php echo $model->presipitasi_perubahanfisik ?>
                </div>
            </li>
            <li>
                <div>
                    Lingkungan penuh kritik<br/>
                    <?php echo $model->presipitasi_lingkunganpenuhkritik ?>
                </div>
            </li>
        </ol>
        <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
            'diagnosa'=>$diagnosa,
            'label_diagnosa'=>'Diagnosa Gangguan',
            'jenisdiagnosa'=>'diagnosa_gangguan',
            'kelompokdiagnosa'=>'faktorpersipitasi',
        )); ?>
    </div>
</div>