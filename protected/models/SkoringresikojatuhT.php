<?php

/**
 * This is the model class for table "skoringresikojatuh_t".
 *
 * The followings are the available columns in table 'skoringresikojatuh_t':
 * @package application.models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0 
 * @link    <http://piindonesia.co.id>
 * @property integer $skoringresikojatuh_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $riwayatjatuh_keterangan
 * @property integer $riwayatjatuh_skor
 * @property string $statusmental_keterangan
 * @property integer $statusmental_skor
 * @property string $pengobatan_keterangan
 * @property integer $pengobatan_skor
 * @property string $mobgayaberjalan_keterangan
 * @property integer $mobgayaberjalan_skor
 * @property string $mobilitasalatbantu_keterangan
 * @property integer $mobilitasalatbantu_skor
 * @property string $kondisipenyakit_keterangan
 * @property integer $konsidipenyakit_skor
 * @property integer $totalskor
 * @property string $totalskor_keterangan
 * @property string $imp_rt_rodaterkunci
 * @property string $imp_rt_menutuppagarbrankard_kanan
 * @property string $imp_rt_orientasikanpasien
 * @property string $imp_rt_beritandasegitiakuning
 * @property string $imp_rt_beripinkuning
 * @property string $imp_rt_pasangfiksasifisik
 * @property string $imp_rr_rodaterkunci
 * @property string $imp_rr_menutuppagarbrankard_kanan
 * @property string $imp_rr_orientasipasien
 * @property string $tgl_skoring
 * @property integer $pegawaiskoring_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $imp_rt_menutuppagarbrankard_kiri
 * @property string $imp_rr_menutuppagarbrankard_kiri
 */
class SkoringresikojatuhT extends CActiveRecord
{
	public $pegawaiskoring_nama, $isresikojatuh;
	public $anak_usia_text, $anak_jeniskelamin_text, $anak_diagnosis_text, $anak_gangguankognitif_text, $anak_faktorlingkungan_text, $anak_pembedahan_text, $anak_medikamentosa_text, $totalskor_anak, $totalskor_keterangan_anak;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SkoringresikojatuhT the static model class
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
		return 'skoringresikojatuh_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tgl_skoring, pegawaiskoring_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasien_id, riwayatjatuh_skor, statusmental_skor, pengobatan_skor, mobgayaberjalan_skor, mobilitasalatbantu_skor, konsidipenyakit_skor, totalskor, pegawaiskoring_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('riwayatjatuh_keterangan, statusmental_keterangan, pengobatan_keterangan, mobgayaberjalan_keterangan, imp_rt_rodaterkunci, imp_rt_menutuppagarbrankard_kanan, imp_rt_orientasikanpasien, imp_rt_beritandasegitiakuning, imp_rt_beripinkuning, imp_rt_pasangfiksasifisik, imp_rr_rodaterkunci, imp_rr_menutuppagarbrankard_kanan, imp_rr_orientasipasien, imp_rt_menutuppagarbrankard_kiri, imp_rr_menutuppagarbrankard_kiri', 'length', 'max'=>255),
			array('mobilitasalatbantu_keterangan, kondisipenyakit_keterangan, totalskor_keterangan', 'length', 'max'=>225),
			array('jenisresikojatuh', 'length', 'max'=>20),
            array('anak_usia_keterangan, anak_jeniskelamin_keterangan, anak_diagnosis_keterangan, anak_gangguankognitif_keterangan, anak_faktorlingkungan_keterangan, anak_pembedahan_keterangan, anak_medikamentosa_keterangan', 'safe'),
            array('anak_usia_skor, anak_jeniskelamin_skor, anak_diagnosis_skor, anak_gangguankognitif_skor, anak_faktorlingkungan_skor, anak_pembedahan_skor, anak_medikamentosa_skor', 'safe'),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_id, pasien_id, riwayatjatuh_keterangan, riwayatjatuh_skor, statusmental_keterangan, statusmental_skor, pengobatan_keterangan, pengobatan_skor, mobgayaberjalan_keterangan, mobgayaberjalan_skor, mobilitasalatbantu_keterangan, mobilitasalatbantu_skor, kondisipenyakit_keterangan, konsidipenyakit_skor, totalskor, totalskor_keterangan, imp_rt_rodaterkunci, imp_rt_menutuppagarbrankard_kanan, imp_rt_orientasikanpasien, imp_rt_beritandasegitiakuning, imp_rt_beripinkuning, imp_rt_pasangfiksasifisik, imp_rr_rodaterkunci, imp_rr_menutuppagarbrankard_kanan, imp_rr_orientasipasien, tgl_skoring, pegawaiskoring_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, imp_rt_menutuppagarbrankard_kiri, imp_rr_menutuppagarbrankard_kiri, jenisresikojatuh', 'safe', 'on'=>'search'),
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
                    'pegawai'=> array(self::BELONGS_TO,'PegawaiM','pegawaiskoring_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(			
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'riwayatjatuh_keterangan' => 'Riwayatjatuh Keterangan',
			'riwayatjatuh_skor' => 'Riwayatjatuh Skor',
			'statusmental_keterangan' => 'Statusmental Keterangan',
			'statusmental_skor' => 'Statusmental Skor',
			'pengobatan_keterangan' => 'Pengobatan Keterangan',
			'pengobatan_skor' => 'Pengobatan Skor',
			'mobgayaberjalan_keterangan' => 'Mobgayaberjalan Keterangan',
			'mobgayaberjalan_skor' => 'Mobgayaberjalan Skor',
			'mobilitasalatbantu_keterangan' => 'Mobilitasalatbantu Keterangan',
			'mobilitasalatbantu_skor' => 'Mobilitasalatbantu Skor',
			'kondisipenyakit_keterangan' => 'Kondisipenyakit Keterangan',
			'konsidipenyakit_skor' => 'Konsidipenyakit Skor',
			'totalskor' => 'Totalskor',
			'totalskor_keterangan' => 'Totalskor Keterangan',
			'imp_rt_rodaterkunci' => 'Imp Rt Rodaterkunci',
			'imp_rt_menutuppagarbrankard_kanan' => 'Imp Rt Menutuppagarbrankard Kanan',
			'imp_rt_orientasikanpasien' => 'Imp Rt Orientasikanpasien',
			'imp_rt_beritandasegitiakuning' => 'Imp Rt Beritandasegitiakuning',
			'imp_rt_beripinkuning' => 'Imp Rt Beripinkuning',
			'imp_rt_pasangfiksasifisik' => 'Imp Rt Pasangfiksasifisik',
			'imp_rr_rodaterkunci' => 'Imp Rr Rodaterkunci',
			'imp_rr_menutuppagarbrankard_kanan' => 'Imp Rr Menutuppagarbrankard Kanan',
			'imp_rr_orientasipasien' => 'Imp Rr Orientasipasien',
			'tgl_skoring' => 'Tgl. Skoring',
			'pegawaiskoring_id' => 'Pegawai Skoring',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'imp_rt_menutuppagarbrankard_kiri' => 'Imp Rt Menutuppagarbrankard Kiri',
			'imp_rr_menutuppagarbrankard_kiri' => 'Imp Rr Menutuppagarbrankard Kiri',
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
		
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('riwayatjatuh_keterangan',$this->riwayatjatuh_keterangan,true);
		$criteria->compare('riwayatjatuh_skor',$this->riwayatjatuh_skor);
		$criteria->compare('statusmental_keterangan',$this->statusmental_keterangan,true);
		$criteria->compare('statusmental_skor',$this->statusmental_skor);
		$criteria->compare('pengobatan_keterangan',$this->pengobatan_keterangan,true);
		$criteria->compare('pengobatan_skor',$this->pengobatan_skor);
		$criteria->compare('mobgayaberjalan_keterangan',$this->mobgayaberjalan_keterangan,true);
		$criteria->compare('mobgayaberjalan_skor',$this->mobgayaberjalan_skor);
		$criteria->compare('mobilitasalatbantu_keterangan',$this->mobilitasalatbantu_keterangan,true);
		$criteria->compare('mobilitasalatbantu_skor',$this->mobilitasalatbantu_skor);
		$criteria->compare('kondisipenyakit_keterangan',$this->kondisipenyakit_keterangan,true);
		$criteria->compare('konsidipenyakit_skor',$this->konsidipenyakit_skor);
		$criteria->compare('totalskor',$this->totalskor);
		$criteria->compare('totalskor_keterangan',$this->totalskor_keterangan,true);
		$criteria->compare('imp_rt_rodaterkunci',$this->imp_rt_rodaterkunci,true);
		$criteria->compare('imp_rt_menutuppagarbrankard_kanan',$this->imp_rt_menutuppagarbrankard_kanan,true);
		$criteria->compare('imp_rt_orientasikanpasien',$this->imp_rt_orientasikanpasien,true);
		$criteria->compare('imp_rt_beritandasegitiakuning',$this->imp_rt_beritandasegitiakuning,true);
		$criteria->compare('imp_rt_beripinkuning',$this->imp_rt_beripinkuning,true);
		$criteria->compare('imp_rt_pasangfiksasifisik',$this->imp_rt_pasangfiksasifisik,true);
		$criteria->compare('imp_rr_rodaterkunci',$this->imp_rr_rodaterkunci,true);
		$criteria->compare('imp_rr_menutuppagarbrankard_kanan',$this->imp_rr_menutuppagarbrankard_kanan,true);
		$criteria->compare('imp_rr_orientasipasien',$this->imp_rr_orientasipasien,true);
		$criteria->compare('tgl_skoring',$this->tgl_skoring,true);
		$criteria->compare('pegawaiskoring_id',$this->pegawaiskoring_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('imp_rt_menutuppagarbrankard_kiri',$this->imp_rt_menutuppagarbrankard_kiri,true);
		$criteria->compare('imp_rr_menutuppagarbrankard_kiri',$this->imp_rr_menutuppagarbrankard_kiri,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}