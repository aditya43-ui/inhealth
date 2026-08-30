<div class="block-tabel">
	<table class="items table table-striped table-condensed">
		<thead>
			<tr>
                <th style="width: 30px">No Urut</th>
				<th style="width: 150px">Hubungan Keluarga</th>
				<th style="width: 200px">Nama</th>
				<th style="width: 150px">Jenis Kelamin</th>
				<th style="width: 150px">No. Peserta</th>
			</tr>
		</thead>
		<tbody>
			<?php 
                $tblisi = 4;
                for ($i=0; $i < $tblisi; $i++){
                    ?>
                        <tr>
                            <td>
                                <?php echo ($i +1); ?>
                                <?php echo CHtml::hiddenField('Tanggunganbpjs['.$i.'][nourutkel]',($i +1),array()); ?>
                            </td>
                            <td>
                                <?php echo CHtml::dropDownList('Tanggunganbpjs['.$i.'][hubkeluarga]','',LookupM::getItems('hubungankeluarga'),array('class'=>'span3','empty'=>'- Pilih -')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField('Tanggunganbpjs['.$i.'][susunankel_nama]','',array('class'=>'span3')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::dropDownList('Tanggunganbpjs['.$i.'][susunankel_jk]','',LookupM::getItems('jeniskelamin'),array('class'=>'span3','empty'=>'- Pilih -')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField('Tanggunganbpjs['.$i.'][nopesertabpjs]','',array('class'=>'span3')); ?>
                            </td>
                        </tr>
                    <?php
                }
            ?>
		</tbody>
	</table>
</div>	
