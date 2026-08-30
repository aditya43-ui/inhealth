<?php

/**
 * This is the model class for table "kelahiranbayi_t".
 *
 * The followings are the available columns in table 'kelahiranbayi_t':
 * @property integer $kelahiranbayi_id
 * @property integer $ruangan_id
 * @property integer $persalinan_id
 * @property integer $nourutbayi
 * @property string $tgllahirbayi
 * @property string $jamlahir
 * @property string $namabayi
 * @property string $jeniskelamin
 * @property double $bb_gram
 * @property double $tb_cm
 * @property boolean $islahirtunggal
 * @property string $lahirkembar
 * @property integer $jmlkembar
 * @property string $kelainanbayi
 * @property string $warnakulit
 * @property string $denyutjantung
 * @property string $responrefleks
 * @property string $pernapasan
 * @property string $interpretasi
 * @property string $catatan_bayi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class KelahiranbayiT extends CActiveRecord
{
        public $metodeApgar;
        public $menitke;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelahiranbayiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kelahiranbayi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menitke, metodeApgar, ruangan_id, persalinan_id, nourutbayi, tgllahirbayi, jamlahir, namabayi, jeniskelamin, bb_gram, tb_cm, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, persalinan_id, nourutbayi, jmlkembar', 'numerical', 'integerOnly'=>true),
			array('bb_gram, tb_cm', 'numerical'),
                        //array('menitke', 'unique'),
			array('namabayi, lahirkembar, tingkat_aspiksia', 'length', 'max'=>100),
			array('metodeApgar, jeniskelamin', 'length', 'max'=>20),
			array('interpretasi, penilaianbayi_barulahir', 'length', 'max'=>50),
			array('penilaianbbl_penyulit', 'length', 'max'=>200),
                        array('islahirtunggal','cekLahir'),
			array('waktu_pemberianasi, islahirtunggal, kelainanbayi, warnakulit, denyutjantung, responrefleks, pernapasan, catatan_bayi, update_time, update_loginpemakai_id', 'safe'),
                        array('bayilahir_aspiksia_ketlainlain, bayilahir_is_normal, bayilahir_is_aspiksia, bayilahir_is_cacatbawaan, bayilahir_is_hiportemi, bayilahir_normal_tindakan, bayilahir_aspiksia_tindakan, bayilahir_cacatbawaan_keterangan, bayilahir_hiportemi_tindakan, is_pemberianasi, waktu_pemberianasi, alasantidak_pemberianasi, ld_cm, ll_cm, lk_cm, masalah_lain, penatalaksanaan_masalahlain, hasilpenatalaksanaan_masalahlain','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelahiranbayi_id, ruangan_id, persalinan_id, nourutbayi, tgllahirbayi, jamlahir, namabayi, jeniskelamin, bb_gram, tb_cm, islahirtunggal, lahirkembar, jmlkembar, kelainanbayi, warnakulit, denyutjantung, responrefleks, pernapasan, interpretasi, catatan_bayi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, ld_cm, ll_cm, lk_cm, masalah_lain, penatalaksanaan_masalahlain, hasilpenatalaksanaan_masalahlain, tingkat_aspiksia, penilaianbayi_barulahir, penilaianbbl_penyulit', 'safe', 'on'=>'search'),
		);
	}
        
        public function cekLahir(){
            if (!$this->hasErrors()){
                if ($this->islahirtunggal){
                    if ((!empty($this->lahirkembar))&&(!empty($this->jmlkembar))){
                        $this->addError('islahirtunggal,lahirkembar,jmlkembar', 'Data tidak sesuai');
                    }
                }
                else{
                    if ((empty($this->lahirkembar))&&(empty($this->jmlkembar))){
                        $this->addError('islahirtunggal,lahirkembar,jmlkembar', 'Data tidak sesuai');
                    }
                }
            }
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                        'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),                        
                        'persalinan'=>array(self::BELONGS_TO,'PersalinanT','persalinan_id'),                  
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelahiranbayi_id' => 'ID',
			'ruangan_id' => 'Ruangan',
			'persalinan_id' => 'Persalinan',
			'nourutbayi' => 'No. Urut',
			'tgllahirbayi' => 'Tanggal Lahir',
			'jamlahir' => 'Jam Lahir',
			'namabayi' => 'Nama Bayi',
			'jeniskelamin' => 'Jenis Kelamin',
			'bb_gram' => 'Berat Badan',
			'tb_cm' => 'Tinggi Badan',
			'islahirtunggal' => 'Lahir Tunggal',
			'lahirkembar' => 'Lahir Kembar',
			'jmlkembar' => 'Jumlah Kembar',
			'kelainanbayi' => 'Kelainan Bayi',
			'warnakulit' => 'Warna Kulit',
			'denyutjantung' => 'Denyut Jantung',
			'responrefleks' => 'Respon Refleks',
			'pernapasan' => 'Pernapasan',
			'interpretasi' => 'Interpretasi',
			'catatan_bayi' => 'Catatan Bayi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'menitke' => 'Menit Ke',
			'ld_cm' => 'Lingkar Dada',
			'll_cm' => 'Lingkar Lengan',
			'lk_cm' => 'Lingkar Kepala',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kelahiranbayi_id',$this->kelahiranbayi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('persalinan_id',$this->persalinan_id);
		$criteria->compare('nourutbayi',$this->nourutbayi);
		$criteria->compare('LOWER(tgllahirbayi)',strtolower($this->tgllahirbayi),true);
		$criteria->compare('LOWER(jamlahir)',strtolower($this->jamlahir),true);
		$criteria->compare('LOWER(namabayi)',strtolower($this->namabayi),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('bb_gram',$this->bb_gram);
		$criteria->compare('tb_cm',$this->tb_cm);
		$criteria->compare('islahirtunggal',$this->islahirtunggal);
		$criteria->compare('LOWER(lahirkembar)',strtolower($this->lahirkembar),true);
		$criteria->compare('jmlkembar',$this->jmlkembar);
		$criteria->compare('LOWER(kelainanbayi)',strtolower($this->kelainanbayi),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(denyutjantung)',strtolower($this->denyutjantung),true);
		$criteria->compare('LOWER(responrefleks)',strtolower($this->responrefleks),true);
		$criteria->compare('LOWER(pernapasan)',strtolower($this->pernapasan),true);
		$criteria->compare('LOWER(interpretasi)',strtolower($this->interpretasi),true);
		$criteria->compare('LOWER(catatan_bayi)',strtolower($this->catatan_bayi),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kelahiranbayi_id',$this->kelahiranbayi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('persalinan_id',$this->persalinan_id);
		$criteria->compare('nourutbayi',$this->nourutbayi);
		$criteria->compare('LOWER(tgllahirbayi)',strtolower($this->tgllahirbayi),true);
		$criteria->compare('LOWER(jamlahir)',strtolower($this->jamlahir),true);
		$criteria->compare('LOWER(namabayi)',strtolower($this->namabayi),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('bb_gram',$this->bb_gram);
		$criteria->compare('tb_cm',$this->tb_cm);
		$criteria->compare('islahirtunggal',$this->islahirtunggal);
		$criteria->compare('LOWER(lahirkembar)',strtolower($this->lahirkembar),true);
		$criteria->compare('jmlkembar',$this->jmlkembar);
		$criteria->compare('LOWER(kelainanbayi)',strtolower($this->kelainanbayi),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(denyutjantung)',strtolower($this->denyutjantung),true);
		$criteria->compare('LOWER(responrefleks)',strtolower($this->responrefleks),true);
		$criteria->compare('LOWER(pernapasan)',strtolower($this->pernapasan),true);
		$criteria->compare('LOWER(interpretasi)',strtolower($this->interpretasi),true);
		$criteria->compare('LOWER(catatan_bayi)',strtolower($this->catatan_bayi),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}