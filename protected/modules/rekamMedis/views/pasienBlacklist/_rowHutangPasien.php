<tr>
    <td>
		<span name="hutangPasien[ii][tglpembayaran]"><?php echo (!empty($modHutang->tglpembayaran) ? MyFormatter::formatDateTimeForUser($modHutang->tglpembayaran) : "") ?></span>
    </td>
    <td>
        <span name="hutangPasien[ii][instalasi_nama]"><?php echo (!empty($modHutang->instalasi_nama) ? $modHutang->instalasi_nama : "") ?></span>
    </td>
    <td>
        <span name="hutangPasien[ii][no_pendaftaran]"><?php echo (!empty($modHutang->no_pendaftaran) ? $modHutang->no_pendaftaran : "") ?></span>
    </td>
	<td>
        <span name="hutangPasien[ii][no_rekam_medik]"><?php echo (!empty($modHutang->no_rekam_medik) ? $modHutang->no_rekam_medik : "") ?></span>
    </td>
    <td>
        <span name="hutangPasien[ii][nama_pasien]"><?php echo (!empty($modHutang->nama_pasien) ? $modHutang->nama_pasien : "") . ' / ' . (!empty($modHutang->nama_bin) ? $modHutang->nama_bin : "") ?></span>
    </td>
	<td>
        <span name="hutangPasien[ii][totalsisatagihan]"><?php echo (!empty($modHutang->totalsisatagihan) ? $modHutang->totalsisatagihan : "") ?></span>
    </td>
    <td>
        <span name="hutangPasien[ii][totalsubsidiasuransi]"><?php echo (!empty($modHutang->totalsubsidiasuransi) ? $modHutang->totalsubsidiasuransi : "") ?></span>
    </td>
	<td>
        <span name="hutangPasien[ii][totalsubsidirs]"><?php echo (!empty($modHutang->totalsubsidirs) ? $modHutang->totalsubsidirs : "") ?></span>
    </td>
	<td>
        <span name="hutangPasien[ii][totaliurbiaya]"><?php echo (!empty($modHutang->totaliurbiaya) ? $modHutang->totaliurbiaya : "") ?></span>
    </td>
	<td>
        <span name="hutangPasien[ii][totaldiscount]"><?php echo (!empty($modHutang->totaldiscount) ? $modHutang->totaldiscount : "") ?></span>
    </td>
	<td>
        <span name="hutangPasien[ii][totalpembebasan]"><?php echo (!empty($modHutang->totalpembebasan) ? $modHutang->totalpembebasan : "") ?></span>
    </td>
	<td>
        <span name="hutangPasien[ii][jmlbayarangsuran]"><?php echo (!empty($modHutang->jmlbayarangsuran) ? $modHutang->jmlbayarangsuran : "") ?></span>
    </td>
	<td><?php echo CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("pasienBlacklist/Rincian",array("id"=>$modHutang->pendaftaran_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframePembayaran",
                                          "onclick"=>"$(\"#dialogPembayaran\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk melihat rincian tagihan pasien",
                                    )); ?></td>
</tr>