<div class="panel panel-success panel_detail" id='panel_6'>
    <div class="panel-heading">
        <div class="panel-title">Sosial-Kultur-Spiritual</div>
    </div>
    <div class="panel-body">
        <ol style="list-style: decimal">
            <li>
                Konsep Diri
                
                <ol style="list-style: lower-alpha">
                    <li>
                        Citra Tubuh :<br/>
                        <?php echo empty($model->konsepdiri_citratubuh) ? "-" : $model->konsepdiri_citratubuh; ?>
                    </li>
                    <li>
                        Identitas :<br/>
                        <?php echo empty($model->konsepdiri_identitas) ? "-" : $model->konsepdiri_identitas; ?>
                    </li>
                    <li>
                        Peran :<br/>
                        <?php echo empty($model->konsepdiri_peran) ? "-" : $model->konsepdiri_peran; ?>
                    </li>
                    <li>
                        Ideal Diri :<br/>
                        <?php echo empty($model->konsepdiri_idealdiri) ? "-" : $model->konsepdiri_idealdiri; ?>
                    </li>
                    <li>
                        Harga Diri :<br/>
                        <?php echo empty($model->konsepdiri_hargadiri) ? "-" : $model->konsepdiri_hargadiri; ?>
                    </li>
                </ol>
                
                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                    'diagnosa'=>$diagnosa,
                    'label_diagnosa'=>'Diagnosa Gangguan',
                    'jenisdiagnosa'=>'diagnosa_gangguan',
                    'kelompokdiagnosa'=>'konsepdiri',
                )); ?>
                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                    'diagnosa'=>$diagnosa,
                    'label_diagnosa'=>'Diagnosa Psikososial',
                    'jenisdiagnosa'=>'diagnosa_psikososial',
                    'kelompokdiagnosa'=>'konsepdiri',
                )); ?>
                
            </li>
            <li>
                Hubungan Sosial

                <ol style="list-style: lower-alpha">
                    <li>
                        Orang Terdekat :<br/>
                        <?php echo empty($model->hubsosial_orangterdekat) ? "-" : $model->hubsosial_orangterdekat; ?>
                    </li>
                    <li>
                        Peran serta dalam kegiatan kelompok/masyarakat :<br/>
                        <?php echo empty($model->hubsosial_peransertadlmkegiatan) ? "-" : $model->hubsosial_peransertadlmkegiatan; ?>
                    </li>
                    <li>
                        Hambatan dalam berhubungan dengan orang lain :<br/>
                        <?php echo empty($model->hubsosial_hambatandlmhubdgnoranglain) ? "-" : $model->hubsosial_hambatandlmhubdgnoranglain; ?>
                    </li>
                </ol>
                
                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                    'diagnosa'=>$diagnosa,
                    'label_diagnosa'=>'Diagnosa Gangguan',
                    'jenisdiagnosa'=>'diagnosa_gangguan',
                    'kelompokdiagnosa'=>'hubungan_sosial',
                )); ?>
                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                    'diagnosa'=>$diagnosa,
                    'label_diagnosa'=>'Diagnosa Psikososial',
                    'jenisdiagnosa'=>'diagnosa_psikososial',
                    'kelompokdiagnosa'=>'hubungan_sosial',
                )); ?>
            </li>
            <li>
                Spiritual
                <ol style="list-style: lower-alpha">
                    <li>
                        Nilai dan keyakinan :<br/>
                        <?php echo empty($model->spiritual_nilaikeyakinan) ? "-" : $model->spiritual_nilaikeyakinan; ?>
                    </li>
                    <li>
                        Kegiatan ibadah :<br/>
                        <?php echo empty($model->spiritual_kegiatanibadah) ? "-" : $model->spiritual_kegiatanibadah; ?>
                    </li>
                    <li>
                        Pengaruh spiritual terhadap koping individu :<br/>
                        <?php echo empty($model->spiritual_pengaruhterhadapkoping) ? "-" : $model->spiritual_pengaruhterhadapkoping; ?>
                    </li>
                </ol>
                
                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                    'diagnosa'=>$diagnosa,
                    'label_diagnosa'=>'Diagnosa Gangguan',
                    'jenisdiagnosa'=>'diagnosa_gangguan',
                    'kelompokdiagnosa'=>'spiritual',
                )); ?>
            </li>
        </ol>
    </div>
</div>