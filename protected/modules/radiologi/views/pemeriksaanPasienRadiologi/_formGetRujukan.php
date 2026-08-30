
<tr>
	<td>
		<?php
		$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
				'id'=>'rujukaccordion-'.$i,
				'content' => array(
					'content-rujukkeluar-'.$i => array(
						'multi' => 'multi',
						'header' => '<b>Form Rujukan Keluar</b>',
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

