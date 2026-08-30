<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Status Mental
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <table class='form_predispo'>
                    <tr>
                        <td width='10'><label>1.</label></td>
                        <td width='200'><label>Penampilan</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_penampilan', LookupM::getItemsUrutan('mental_penampilan'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_penampilan'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>2.</label></td>
                        <td><label>Pebicaraan</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_pembicaraan', LookupM::getItemsUrutan('mental_pembicaraan'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_pembicaraan'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>3.</label></td>
                        <td><label>Aktifitas Motorik</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_aktifitasmotorik', LookupM::getItemsUrutan('mental_motorik'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_aktifitasmotorik'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>4.</label></td>
                        <td><label>Alam Perasaan</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_alamperasaan', LookupM::getItemsUrutan('mental_alam_perasaan'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_alamperasaan'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>5.</label></td>
                        <td><label>Afek</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_efek', LookupM::getItemsUrutan('mental_afek'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_efek'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>6.</label></td>
                        <td><label>Interaksi dengan Wawancara</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_interaksiwawancara', LookupM::getItemsUrutan('mental_interaksi_wawancara'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_interaksiwawancara'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>7.</label></td>
                        <td><label>Persepsi</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_persepsi', LookupM::getItemsUrutan('mental_persepsi'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_persepsi'); ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-sm-6">
                <table class='form_predispo'>
                    <tr>
                        <td><label>8.</label></td>
                        <td><label>Proses Pikir</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_prosespikir', LookupM::getItemsUrutan('mental_proses_pikir'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_prosespikir'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='10'><label>9.</label></td>
                        <td width='200'><label>Isi Pikir</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_isipikir', LookupM::getItemsUrutan('mental_isi_pikir'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label></label></td>
                        <td><label>Waham</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_waham', LookupM::getItemsUrutan('mental_waham'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_waham'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='10'><label>10.</label></td>
                        <td width='200'><label>Tingkat Kesadaran</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_kesadaran', LookupM::getItemsUrutan('mental_tingkat_kesadaran'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='10'><label></label></td>
                        <td width='200'><label>Disorientasi</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_disorientasi', LookupM::getItemsUrutan('mental_disorientasi'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_kesadaran'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='10'><label>11.</label></td>
                        <td width='200'><label>Memori</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_memori', LookupM::getItemsUrutan('mental_memori'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_memori'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='10'><label>12.</label></td>
                        <td width='200'><label>Tingkat Konsentrasi dan Berhitung</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_konsentrasi', LookupM::getItemsUrutan('mental_konsentrasi'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_konsentrasi'); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width='10'><label>13.</label></td>
                        <td width='200'><label>Memori</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_penilaian', LookupM::getItemsUrutan('mental_kemampuan_penilaian'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_penilaian'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='10'><label>14.</label></td>
                        <td width='200'><label>Daya Tilik Diri</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'status_dayatitikdiri', LookupM::getItemsUrutan('mental_daya_titik_diri'), array('uncheckValue' => null)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'status_masalahkeperawatan_dayatitikdiri'); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>