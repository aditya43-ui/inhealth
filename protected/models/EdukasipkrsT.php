<?php

/**
 * This is the model class for table "edukasipkrs_t".
 * menambah kolom topikedukasi
 * RSST-3414
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package application.models
 * The followings are the available columns in table 'edukasipkrs_t':
 * @property integer $edukasipkrs_id
 * @property string $tgledukasi
 * @property integer $instalasi_id
 * @property integer $ruangan_id
 * @property string $juduledukasi
 * @property boolean $bentukedukasi_individu
 * @property boolean $bentukedukasi_kelompokkecil
 * @property boolean $bentukedukasi_kelompoksedang
 * @property boolean $bentukedukasi_kelompokbesar
 * @property boolean $metode_ceramah
 * @property boolean $metode_demontrsasi
 * @property boolean $metode_diskusi
 * @property boolean $metode_wawancara
 * @property boolean $sarana_leaflet
 * @property boolean $sarana_poster
 * @property boolean $sarana_microphone
 * @property boolean $sarana_ohp
 * @property boolean $sarana_lcd
 * @property boolean $sarana_lainnya
 * @property string $saraba_lainntaket
 * @property integer $jml_pasien
 * @property integer $jml_keluargapasien
 * @property integer $jml_lakilaki
 * @property integer $jml_perempuan
 * @property integer $dokterpenyuluh
 * @property integer $paramedispenyuluh
 * @property integer $penyuluhlainnya
 * @property string $pertanyaan
 * @property integer $edukator1_id
 * @property integer $edukator2_id
 * @property integer $edukator3_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 */
class EdukasipkrsT extends CActiveRecord
{
      public $tgl_awal,$tgl_akhir,$data,$jumlah;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EdukasipkrsT the static model class
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
		return 'edukasipkrs_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('topikedukasi,create_time, create_loginpemakai_id', 'required'),
			array('instalasi_id, ruangan_id, jml_pasien, jml_keluargapasien, jml_lakilaki, jml_perempuan, dokterpenyuluh, paramedispenyuluh, penyuluhlainnya, edukator1_id, edukator2_id, edukator3_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('topikedukasi,saraba_lainntaket', 'length', 'max'=>50),
			array('topikedukasi,file_lampiran, tgledukasi, juduledukasi, bentukedukasi_individu, '
                            . 'bentukedukasi_kelompokkecil, bentukedukasi_kelompoksedang, bentukedukasi_kelompokbesar, '
                            . 'metode_ceramah, metode_demontrsasi, metode_diskusi, metode_wawancara, sarana_leaflet,'
                            . 'sarana_poster, sarana_microphone, sarana_ohp, sarana_lcd, sarana_lainnya, pertanyaan, '
                            . 'update_time, metode_ceramah_nilai, metode_demonstrasi_nilai, '
                            . 'metode_diskusi_nilai, metode_wawancara_nilai', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('topikedukasi,edukasipkrs_id, tgledukasi, instalasi_id, ruangan_id, juduledukasi, bentukedukasi_individu, bentukedukasi_kelompokkecil, bentukedukasi_kelompoksedang, bentukedukasi_kelompokbesar, metode_ceramah, metode_demontrsasi, metode_diskusi, metode_wawancara, sarana_leaflet, sarana_poster, sarana_microphone, sarana_ohp, sarana_lcd, sarana_lainnya, saraba_lainntaket, jml_pasien, jml_keluargapasien, jml_lakilaki, jml_perempuan, dokterpenyuluh, paramedispenyuluh, penyuluhlainnya, pertanyaan, edukator1_id, edukator2_id, edukator3_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'edukasipkrs_id' => 'Edukasipkrs',
                        'topikedukasi'=>'Topik Edukasi',
			'tgledukasi' => 'Tgledukasi',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'juduledukasi' => 'Juduledukasi',
			'bentukedukasi_individu' => 'Bentukedukasi Individu',
			'bentukedukasi_kelompokkecil' => 'Bentukedukasi Kelompokkecil',
			'bentukedukasi_kelompoksedang' => 'Bentukedukasi Kelompoksedang',
			'bentukedukasi_kelompokbesar' => 'Bentukedukasi Kelompokbesar',
			'metode_ceramah' => 'Metode Ceramah',
			'metode_demontrsasi' => 'Metode Demontrsasi',
			'metode_diskusi' => 'Metode Diskusi',
			'metode_wawancara' => 'Metode Wawancara',
			'sarana_leaflet' => 'Sarana Leaflet',
			'sarana_poster' => 'Sarana Poster',
			'sarana_microphone' => 'Sarana Microphone',
			'sarana_ohp' => 'Sarana Ohp',
			'sarana_lcd' => 'Sarana Lcd',
			'sarana_lainnya' => 'Sarana Lainnya',
			'saraba_lainntaket' => 'Saraba Lainntaket',
			'jml_pasien' => 'Jml Pasien',
			'jml_keluargapasien' => 'Jml Keluargapasien',
			'jml_lakilaki' => 'Jml Lakilaki',
			'jml_perempuan' => 'Jml Perempuan',
			'dokterpenyuluh' => 'Dokterpenyuluh',
			'paramedispenyuluh' => 'Paramedispenyuluh',
			'penyuluhlainnya' => 'Penyuluhlainnya',
			'pertanyaan' => 'Pertanyaan',
			'edukator1_id' => 'Edukator1',
			'edukator2_id' => 'Edukator2',
			'edukator3_id' => 'Edukator3',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('edukasipkrs_id',$this->edukasipkrs_id);
		$criteria->compare('tgledukasi',$this->tgledukasi,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('juduledukasi',$this->juduledukasi,true);
		$criteria->compare('bentukedukasi_individu',$this->bentukedukasi_individu);
		$criteria->compare('bentukedukasi_kelompokkecil',$this->bentukedukasi_kelompokkecil);
		$criteria->compare('bentukedukasi_kelompoksedang',$this->bentukedukasi_kelompoksedang);
		$criteria->compare('bentukedukasi_kelompokbesar',$this->bentukedukasi_kelompokbesar);
		$criteria->compare('metode_ceramah',$this->metode_ceramah);
                $criteria->compare('topikedukasi',$this->topikedukasi);
		$criteria->compare('metode_demontrsasi',$this->metode_demontrsasi);
		$criteria->compare('metode_diskusi',$this->metode_diskusi);
		$criteria->compare('metode_wawancara',$this->metode_wawancara);
		$criteria->compare('sarana_leaflet',$this->sarana_leaflet);
		$criteria->compare('sarana_poster',$this->sarana_poster);
		$criteria->compare('sarana_microphone',$this->sarana_microphone);
		$criteria->compare('sarana_ohp',$this->sarana_ohp);
		$criteria->compare('sarana_lcd',$this->sarana_lcd);
		$criteria->compare('sarana_lainnya',$this->sarana_lainnya);
		$criteria->compare('saraba_lainntaket',$this->saraba_lainntaket,true);
		$criteria->compare('jml_pasien',$this->jml_pasien);
		$criteria->compare('jml_keluargapasien',$this->jml_keluargapasien);
		$criteria->compare('jml_lakilaki',$this->jml_lakilaki);
		$criteria->compare('jml_perempuan',$this->jml_perempuan);
		$criteria->compare('dokterpenyuluh',$this->dokterpenyuluh);
		$criteria->compare('paramedispenyuluh',$this->paramedispenyuluh);
		$criteria->compare('penyuluhlainnya',$this->penyuluhlainnya);
		$criteria->compare('pertanyaan',$this->pertanyaan,true);
		$criteria->compare('edukator1_id',$this->edukator1_id);
		$criteria->compare('edukator2_id',$this->edukator2_id);
		$criteria->compare('edukator3_id',$this->edukator3_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}