 <?php

/**
 * This is the model class for table "rujukan_t".
 *
 * The followings are the available columns in table 'rujukan_t':
 * @property integer $rujukan_id
 * @property integer $asalrujukan_id
 * @property string $no_rujukan
 * @property string $nama_perujuk
 * @property string $tanggal_rujukan
 * @property string $diagnosa_rujukan
 * @property boolean $aktif_rujukan
 * @property integer $rujukandari_id
 *
 * The followings are the available model relations:
 * @property AsalrujukanM $asalrujukan
 * @property RujukandariM $rujukandari
 * @property PendaftaranT[] $pendaftaranTs
 */
class MORujukanT extends RujukanT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RujukanT the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
} 