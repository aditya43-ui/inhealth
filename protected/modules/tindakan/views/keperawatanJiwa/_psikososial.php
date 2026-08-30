<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Psikososial
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <table class='form_predispo' width="100%">
                    <tr>
                        <td width='10'><label>1.</label></td>
                        <td width='200'><label>Genogram</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_genogram', array('rows' => 4, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>Jelaskan</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_penjelasan', array('rows' => 4, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_masalahkeperawatan', array('rows' => 4, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td><label>2.</label></td>
                        <td><label>Konsep Diri</label></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>a. Gambaran Diri</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_gambarandiri', array('rows' => 2, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>b. Identitas</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_identitas', array('rows' => 2, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>c. Peran</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_peran', array('rows' => 2, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>d. Ideal Diri</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_idealdiri', array('rows' => 2, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>e. Harga Diri</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_hargadiri', array('rows' => 2, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_masalahkeperawatan_konsepdiri', array('rows' => 4, 'style' => 'width: 100%')); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table class='form_predispo' width="100%">
                    <tr>
                        <td width='10'><label>3.</label></td>
                        <td width='200'><label>Hubungan Sosial</label></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>a. Orang yang berarti</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_sosial_orangberarti', array('rows' => 2, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>b. Pesan serta dalam kegiatan kelompok/masyarakat</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_sosial_peran_dalam_kelompok', array('rows' => 2, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>c. Hambatan dalam berhubungan dengan olrang lain</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_sosial_hambatan', array('rows' => 2, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_masalahkeperawatan_sosial', array('rows' => 4, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td width='10'><label>4.</label></td>
                        <td width='200'><label>Spiritual</label></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>a. Nilai dan Keyakinan</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_spiritual_nilai', array('rows' => 2, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>b. Kegiatan Ibadah</label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_spiritual_ibadah', array('rows' => 2, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td><?php echo $form->textArea($model, 'psikososial_masalahkeperawatan_spiritual', array('rows' => 4, 'style' => 'width: 100%')); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>