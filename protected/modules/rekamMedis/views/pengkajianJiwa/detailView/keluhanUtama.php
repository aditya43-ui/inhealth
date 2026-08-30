<div class="panel panel-success panel_detail" id='panel_2'>
    <div class="panel-heading">
        <div class="panel-title">Keluhan Utama</div>
    </div>
    <div class="panel-body">
        <div>
            <div class="label_d">Keluhan Utama</div>
            <div class="kolon_d">:</div>
            <div class="body_d"><?php echo $model->keluhanutama; ?></div>
        </div>
        <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
            'diagnosa'=>$diagnosa,
            'label_diagnosa'=>'Diagnosa Gangguan',
            'jenisdiagnosa'=>'diagnosa_gangguan',
            'kelompokdiagnosa'=>'keluhanutama',
        )); ?>
    </div>
</div>