<tr data-row="0">
    <td>
        <?php echo $inven->invperalatan_namabrg; ?>
    </td>
    <td class="no_aset">
        <?php echo $inven->invperalatan_kode." / ".$inven->invperalatan_noregister; ?>
        
    </td>
    <td class="merk">
        <?php echo $inven->invperalatan_merk." / ".$inven->invperalatan_ukuran." / ".$inven->invperalatan_bahan ?>
    </td>
    <td class="thn_beli">
        <?php echo $inven->invperalatan_thnpembelian; ?>
        
    </td>
    <td>
        <?php echo $detail->pengeluaranaset_keadaan; ?>
        
    </td>
    <td>
        <?php echo $detail->ket_pengeluaranaset; ?>
        
    </td>
    <td>
        
    </td>
</tr>