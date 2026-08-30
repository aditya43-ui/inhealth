
<tr>
	<td>
		<?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
				'id'=>'rujukaccordion-'.$i,
				'content' => array(
					'content-rujukkeluar-'.$i => array(
						'multi' => 'multi',
						'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Tampilkan Rujukan Keluar')) . '<b> <span class="judulasuransi">Form Rujukan Keluar</span> </b> &nbsp &nbsp <span class="refreshasuransi" style="display:none;">',
						'isi' => $this->renderPartial('_formRujukKeluar', array(
							//'form' => $form,
							'i' => $i,
							'modRujukKeluar' => $modRujukKeluar,   
							'modPasienMasukPenunjang'=>$modPasienMasukPenunjang
								), true),
						'active' => empty($modRujukKeluar->pemeriksaankeluar_id)?false:true,
					),
				),
                'htmlOptions'=>array(
                    'class'=>'acc_rujukan',
                )
			));
		?>
	</td>
</tr>


