<tr data-idx="<?php echo $i; ?>" class="row_main">
    <td><?php

    $modJenis->tgltransaksi = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

    $cr_jenis = new CDbCriteria;
    $data_bayar = JnspembayarM::model()->findAll($cr_jenis);

    $option_bayar = array();
    $list_data_bayar = CHtml::listData($data_bayar, 'jnspembayar_id', 'jnspembayar_nama');


    foreach ($data_bayar as $item) {

        $rek = JnspembrekM::model()->findByAttributes(array(
            'jnspembayar_id'=>$item->jnspembayar_id,
            'debitkredit'=>'D',
        ), array(
            'order'=>'jnspembrek_id asc',
        ));

        $rek5 = new Rekening5M;
        if (!empty($rek)) {
            $rek5 = Rekening5M::model()->findByPk($rek->rekening5_id);
            if (empty($rek5)) {
                $rek5 = new Rekening5M;
            }
        }
        $dateJthTempo = date('Y-m-d H:i:s');
        if(!empty($item->jatuhtempo)){
          $dateJthTempo = date('Y-m-d H:i:s',strtotime($dateJthTempo.'+'.$item->jatuhtempo.' days'));
        }
        $jatuhtempo = MyFormatter::formatDateTimeForUser($dateJthTempo);
        $option_bayar[$item->jnspembayar_id] = array(
            'data-ispiutangbank'=>$item->ispiutangbank ? 1 : 0,
            'data-ispembayarandigital'=>$item->ispembayarandigital ? 1 : 0,
            'data-rekening'=>$item->ispembayarandigital ? ($rek5->kdrekening5." - ".$rek5->nmrekening5) : "",
            'data-tgljatuhtempo'=>$jatuhtempo,
        );

    }

    echo CHtml::activeDropDownList($modJenis, '[detail]['.$i.']jnspembayar_id', $list_data_bayar, array(
        'empty'=>'-- Pilih --',
        'class'=>'main_jenis',
        'onchange'=>'pilihJenis(this);',
        'options'=>$option_bayar,
    )); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']jumlahpembayaran', array('class'=>'span2 integer-decimal_old integer2 main_nominal',
            'readonly'=>false, 'onblur'=>'cekBayarBank(this);')); ?>
    </td>
    <td rowspan="2">
        <?php echo CHtml::link('<i class="entypo-minus"></i>', '#', array(
            'onclick'=>'hapusBayar(this); return false;',
            'class'=>'btn btn-red'
        )); ?>
    </td>
</tr>
<tr data-idx="<?php echo $i; ?>"class="row_detail">
    <td colspan="2" >
        <?php /* echo $this->renderPartial($this->path_view."jenis._gopay", array(
            'modJenis'=>$modJenis,
            'i'=>$i,
        ), true); */ ?>
        <?php /* echo $this->renderPartial($this->path_view."jenis._ovo", array(
            'modJenis'=>$modJenis,
            'i'=>$i,
        ), true); */ ?>
        <?php echo $this->renderPartial($this->path_view."jenis._digital", array(
            'modJenis'=>$modJenis,
            'i'=>$i,
        ), true); ?>
        <?php echo $this->renderPartial($this->path_view."jenis._debit", array(
            'modJenis'=>$modJenis,
            'i'=>$i,
        ), true); ?>

    </td>
</tr>
