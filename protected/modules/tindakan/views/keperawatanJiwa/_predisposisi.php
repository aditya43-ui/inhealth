<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Faktor Predisposisi
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <table class="form_predispo" width="100%">
                    <tr>
                        <td width="20"><label>1.</label></td>
                        <td width="200"><?php echo $form->label($model, 'prediosposisi_gangunajiwa_masalalu', array('label' => "Pernah mengalami ganggunan jiwa di masa lalu ?")) ?></td>
                        <td><?php echo $form->radioButtonList($model, 'prediosposisi_gangunajiwa_masalalu', array(1 => "Ya", 0 => "Tidak"), array('template' => '{input}{label}&nbsp;&nbsp;')); ?></td>
                    </tr>
                    <tr>
                        <td><label>2.</label></td>
                        <td><?php echo $form->label($model, 'prediosposisi_pengobatansebelumnya', array('label' => "Pengobatan Sebelumnya")) ?></td>
                        <td><?php echo $form->radioButtonList($model, 'prediosposisi_pengobatansebelumnya', array(
                                "Berhasil" => "Berhasil",
                                "Kurang Berhasil" => "Kurang Berhasil",
                                "Tidak Berhasil" => "Tidak Berhasil",
                            ), array('template' => '{input}{label}&nbsp;&nbsp;')); ?></td>
                    </tr>
                    <tr>
                        <td><label>3.</label></td>
                        <td colspan="2">
                            <table id="tab_aniaya">
                                <tr>
                                    <td></td>
                                    <td class='rad_center'><label>Pelaku</label></td>
                                    <td class='rad_center'><label>Korban</label></td>
                                    <td class='rad_center'><label>Saksi</label></td>
                                    <td class='rad_center'><label>Usia</label></td>
                                </tr>
                                <tr>
                                    <td><label>Aniaya Fisik</label></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_aniayafisik', array('value' => "Pelaku", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_aniayafisik', array('value' => "Korban", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_aniayafisik', array('value' => "Saksi", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->textField($model, 'prediosposisi_aniayafisik_usia', array('class' => 'span1 numbers-only')); ?></td>
                                </tr>
                                <tr>
                                    <td><label>Aniaya Seksual</label></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_aniayaseksual', array('value' => "Pelaku", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_aniayaseksual', array('value' => "Korban", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_aniayaseksual', array('value' => "Saksi", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->textField($model, 'prediosposisi_aniayaseksual_usia', array('class' => 'span1 numbers-only')); ?></td>
                                </tr>
                                <tr>
                                    <td><label>Penolakan</label></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_penolakan', array('value' => "Pelaku", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_penolakan', array('value' => "Korban", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_penolakan', array('value' => "Saksi", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->textField($model, 'prediosposisi_penolakan_usia', array('class' => 'span1 numbers-only')); ?></td>
                                </tr>
                                <tr>
                                    <td><label>Kekerasan dalam Keluarga</label></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_krt', array('value' => "Pelaku", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_krt', array('value' => "Korban", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_krt', array('value' => "Saksi", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->textField($model, 'prediosposisi_krt_usia', array('class' => 'span1 numbers-only')); ?></td>
                                </tr>
                                <tr>
                                    <td><label>Tindakan Kriminal</label></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_kriminal', array('value' => "Pelaku", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_kriminal', array('value' => "Korban", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->radioButton($model, 'prediosposisi_kriminal', array('value' => "Saksi", "uncheckValue" => null)); ?></td>
                                    <td class='rad_center'><?php echo $form->textField($model, 'prediosposisi_kriminal_usia', array('class' => 'span1 numbers-only')); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>Jelaskan No. 1, 2, 3</label></td>
                        <td>
                            <?php echo $form->textArea($model, 'prediosposisi_penjelasan', array('style' => 'width: 100%')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'prediosposisi_masalahkeperawatan', array('style' => 'width: 100%')); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="form_predispo" width="100%">
                    <tr>
                        <td width="20"><label>4.</label></td>
                        <td width="200"><?php echo $form->label($model, 'prediosposisi_anggotakeluraga_gangguan', array('label' => "Adakah keluarga yang mengalami gangguan jiwa ?")) ?></td>
                        <td><?php echo $form->radioButtonList($model, 'prediosposisi_anggotakeluraga_gangguan', array(1 => "Ya", 0 => "Tidak"), array('template' => '{input}{label}&nbsp;&nbsp;')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $form->label($model, 'prediosposisi_hubungankeluarga', array('label' => "Hubungan Keluarga")) ?></td>
                        <td><?php echo $form->textArea($model, 'prediosposisi_hubungankeluarga', array('rows' => 4, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $form->label($model, 'prediosposisi_gejala', array('label' => "Gejala")) ?></td>
                        <td><?php echo $form->textArea($model, 'prediosposisi_gejala', array('rows' => 4, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $form->label($model, 'prediosposisi_riwayatpengobatan', array('label' => "Riwayat Pengobata/Perawatan")) ?></td>
                        <td><?php echo $form->textArea($model, 'prediosposisi_riwayatpengobatan', array('rows' => 4, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'prediosposisi_masalahkeperawatan_keluarga', array('style' => 'width: 100%')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>5.</label></td>
                        <td><?php echo $form->label($model, 'prediosposisi_pengalamanmasalalu', array('label' => "Pengalaman masa lalu yang tidak menyenangkan")) ?></td>
                        <td><?php echo $form->textArea($model, 'prediosposisi_pengalamanmasalalu', array('rows' => 4, 'style' => 'width: 100%')); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'prediosposisi_masalahkeperawatan_masalalu', array('style' => 'width: 100%')); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>