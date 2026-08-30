<tr>
    <td>
        <?php echo $detail->bahanmakanan->namabahanmakanan; ?>
    </td>
    <!--<td>
        <?php //echo ; ?>
    </td>-->
    <td style = "text-align:right;">
        <?php echo number_format($detail->qty_terima,0,"",".").' '.$detail->satuanbahan; ?>
    </td>
    <td style = "text-align:right;">
        <?php echo number_format($detail->harganettobhn,0,"","."); ?>
    </td>
    <td style = "text-align:right;">
        <?php echo number_format($detail->harganettobhn,0,"","."); ?>
    </td>
    <td style = "text-align:right;">
        <?php echo number_format($detail->qty_terima * $detail->harganettobhn,0,"","."); ?>
    </td>
</tr>