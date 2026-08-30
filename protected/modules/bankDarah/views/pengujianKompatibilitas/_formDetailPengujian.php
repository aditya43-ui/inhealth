<tr>
    <td>
        <?php echo $modKantong->no_kantongdarah; ?>
    </td>
    <td>
        <?php echo $modKantong->nama_jenis; ?>
        <?php echo CHtml::hiddenField('stokkantongdarah',$modKantong->stokkantongdarah_id,array('class'=>'span2 kantongdarah','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPengujianDarah, '[ii]anti_a',LookupM::getItems('tipedarah'),array('onchange' => 'pengujianKompatibilitas(this)','class'=>'span2 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPengujianDarah, '[ii]anti_b',LookupM::getItems('tipedarah'),array('onchange' => 'pengujianKompatibilitas(this)','class'=>'span2 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPengujianDarah, '[ii]anti_ab',LookupM::getItems('tipedarah'),array('onchange' => 'pengujianKompatibilitas(this)','class'=>'span2 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPengujianDarah, '[ii]anti_d',LookupM::getItems('tipedarah'),array('onchange' => 'pengujianKompatibilitas(this)','class'=>'span2 required' ,'empty'=>'-- Pilih --')) ?>

    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPengujianDarah, '[ii]sel_a',LookupM::getItems('tipedarah'),array('onchange' => 'pengujianKompatibilitas(this)','class'=>'span2 required','empty'=>'-- Pilih --')) ?>

    </td>
     <td>
        <?php echo CHtml::activeDropDownList($modPengujianDarah, '[ii]sel_b',LookupM::getItems('tipedarah'),array('onchange' => 'pengujianKompatibilitas(this)','class'=>'span2 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPengujianDarah, '[ii]sel_o',LookupM::getItems('tipedarah'),array('onchange' => 'pengujianKompatibilitas(this)','class'=>'span2 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
      <?php echo CHtml::activeTextField($modPengujianDarah,'[ii]ket_hasiluji', array('class'=>'span3','readonly'=>true)) ?>
    </td>
    <td>
        <?php echo CHtml::activehiddenField($modUjiKompatibilitas,'[ii]stokkantongdarah_id', array('class'=>'span3 required','readonly'=>false)) ?>
        <?php echo CHtml::activehiddenField($modUjiKompatibilitas,'[ii]nomorbarcode', array('class'=>'span3 required','readonly'=>false)) ?>

       <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[ii]ujikomp_mayor',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'span2 required','empty'=>'-- Pilih --')) ?>
    </td>
    <td>
       <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[ii]ujikomp_minor',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'span2 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[ii]ujikomp_autokontrol',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'span2 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[ii]ujikomp_dct',LookupM::getItems('ujikompabilitasmayor'),array('onchange'=>'ujiSilang(this);','class'=>'span2 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td>
        <?php echo CHtml::activetextArea($modUjiKompatibilitas,'[ii]ujikomp_kesimpulan', array('class'=>'span3 required','readonly'=>true)) ?>

    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modUjiKompatibilitas, '[ii]rilis',LookupM::getItems('rilis'),array('class'=>'span2 required','empty'=>'-- Pilih --')) ?>

    </td>
    <td><?php echo CHtml::link('<icon class="glyphicon glyphicon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        