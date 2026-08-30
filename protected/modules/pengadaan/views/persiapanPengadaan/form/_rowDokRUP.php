<tr>
    <td style="text-align: center;"><?php echo !empty($modDok->dokumenpendukungpengadaan_nama) ? $modDok->dokumenpendukungpengadaan_nama : ''; ?></td>
    <td style="text-align: center;"><?php echo !empty($modDok->dokumenpendukungpengadaan_file) ? CHtml::link($modDok->dokumenpendukungpengadaan_file, $this->createUrl('UnduhDokRUP', array('dokumenpendukungpengadaan_id' => $modDok->dokumenpendukungpengadaan_id)), array('title' => 'Unduh Dokumen', 'rel' => 'tooltip')) : ''; ?></td>
</tr>