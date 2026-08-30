<?php
/**
 * This is the model class for table "suratstudiluarmcu_t".
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'suratstudiluarmcu_t':
 * @property integer $suratstudiluarmcu_id
 * @property string $negaratujuan
 * @property string $masaberlaku
 * @property string $nomorsurat
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $nopasport
 * @property integer $pegawai_id
 * @property boolean $heartdease_yes
 * @property boolean $heartdease_no
 * @property boolean $hypertension_yes
 * @property boolean $hypertension_no
 * @property boolean $lungdisease_yes
 * @property boolean $lungdisease_no
 * @property boolean $asthma_yes
 * @property boolean $asthma_no
 * @property boolean $liverdisease_yes
 * @property boolean $liverdisease_no
 * @property boolean $diabetes_yes
 * @property boolean $diabetes_no
 * @property boolean $kidneydisease_yes
 * @property boolean $kidneydisease_no
 * @property boolean $leprosy_yes
 * @property boolean $leprosy_no
 * @property boolean $sexsuallytransmiedinfection_yes
 * @property boolean $sexsuallytransmiedinfection_no
 * @property boolean $pyschiatricillnes_yes
 * @property boolean $pyschiatricillnes_no
 * @property boolean $hepatitis_yes
 * @property boolean $hepatitis_no
 * @property boolean $druguse_yes
 * @property boolean $druguse_no
 * @property boolean $epilepsi_yes
 * @property boolean $epilepsi_no
 * @property boolean $malaria_yes
 * @property boolean $malaria_no
 * @property boolean $tubercolosis_yes
 * @property boolean $tubercolosis_no
 * @property boolean $hiv_aids_yes
 * @property boolean $hiv_aids_no
 * @property boolean $denguehemorrhagicfever_yes
 * @property boolean $denguehemorrhagicfever_no
 * @property boolean $otherdisease_yes
 * @property string $otherdisease_keterangan
 * @property integer $height
 * @property integer $weight
 * @property integer $sistolic_bloodpressure
 * @property integer $diastolic_bloodpressure
 * @property boolean $skin_normal
 * @property boolean $skin_abnormal
 * @property string $vision_right
 * @property string $vision_left
 * @property boolean $ears_normal
 * @property boolean $ears_abnormal
 * @property boolean $eyes_normal
 * @property boolean $eyes_abnormal
 * @property boolean $heart_normal
 * @property boolean $heart_abnormal
 * @property boolean $lungs_normal
 * @property boolean $lungs_abnormal
 * @property boolean $liver_normal
 * @property boolean $liver_abnormal
 * @property boolean $spleen_normal
 * @property boolean $spleen_abnormal
 * @property boolean $tyrhoidgland_normal
 * @property boolean $tyrhoidgland_abnormal
 * @property boolean $lymphnodes_normal
 * @property boolean $lymphnodes_abnormal
 * @property boolean $ekternalgenitalia_normal
 * @property boolean $ekternalgenitalia_abnormal
 * @property boolean $hemia_normal
 * @property boolean $hemia_abnormal
 * @property boolean $mental_normal
 * @property boolean $mental_abnormal
 * @property boolean $otherphyscal_yes
 * @property string $otherphyscal_keterangan
 * @property boolean $serologicalhiv_positive
 * @property boolean $serologicalhiv_negative
 * @property boolean $serologicalsyphilis_positive
 * @property boolean $serologicalsyphilis_negative
 * @property boolean $hepatitis_b_positive
 * @property boolean $hepatitis_b_negative
 * @property boolean $blood_malaria_positive
 * @property boolean $blood_malaria_negative
 * @property string $blood_malaria_species
 * @property boolean $tuberculosis_positive
 * @property boolean $tuberculosis_negative
 * @property boolean $stool_parasites_positive
 * @property boolean $stool_parasites_negative
 * @property string $stool_parasites_species
 * @property boolean $haematology_normal
 * @property boolean $haematology_abnormal
 * @property boolean $urinalysis_normal
 * @property boolean $urinalysis_abnormal
 * @property boolean $urinetest_amphetamine_positive
 * @property boolean $urinetest_amphetamine_negative
 * @property boolean $urinetest_morphine_positive
 * @property boolean $urinetest_morphine_negative
 * @property boolean $mariyuana_positive
 * @property boolean $mariyuana_negative
 * @property boolean $checkup_leprosy_positive
 * @property boolean $checkup_leprosy_negative
 * @property string $conclusion
 * @property string $tgl_pemeriksaan
 * @property string $keperluan
 * @property boolean $serologicalsyphilis_vdrl
 * @property boolean $serologicalsyphilis_tpha
 * @property integer $pulse
 */
class SuratstudiluarmcuT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SuratstudiluarmcuT the static model class
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
		return 'suratstudiluarmcu_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('negaratujuan, masaberlaku, nomorsurat, pegawai_id, tgl_pemeriksaan', 'required'),
			array('pasien_id, pendaftaran_id, pegawai_id, height, weight, sistolic_bloodpressure, diastolic_bloodpressure, pulse', 'numerical', 'integerOnly'=>true),
			array('negaratujuan', 'length', 'max'=>20),
			array('nomorsurat, blood_malaria_species, stool_parasites_species', 'length', 'max'=>100),
			array('nopasport, otherdisease_keterangan, otherphyscal_keterangan', 'length', 'max'=>200),
			array('vision_right, vision_left', 'length', 'max'=>5),
            array('checkup_leprosy_positive, checkup_leprosy_negative', 'safe'),
            array('pregnancy_positive, pregnancy_negative', 'safe'),
			array('heartdease_yes, heartdease_no, hypertension_yes, hypertension_no, lungdisease_yes, lungdisease_no, asthma_yes, asthma_no, liverdisease_yes, liverdisease_no, diabetes_yes, diabetes_no, kidneydisease_yes, kidneydisease_no, leprosy_yes, leprosy_no, sexsuallytransmiedinfection_yes, sexsuallytransmiedinfection_no, pyschiatricillnes_yes, pyschiatricillnes_no, hepatitis_yes, hepatitis_no, druguse_yes, druguse_no, epilepsi_yes, epilepsi_no, malaria_yes, malaria_no, tubercolosis_yes, tubercolosis_no, hiv_aids_yes, hiv_aids_no, denguehemorrhagicfever_yes, denguehemorrhagicfever_no, otherdisease_yes, skin_normal, skin_abnormal, ears_normal, ears_abnormal, eyes_normal, eyes_abnormal, heart_normal, heart_abnormal, lungs_normal, lungs_abnormal, liver_normal, liver_abnormal, spleen_normal, spleen_abnormal, tyrhoidgland_normal, tyrhoidgland_abnormal, lymphnodes_normal, lymphnodes_abnormal, ekternalgenitalia_normal, ekternalgenitalia_abnormal, hemia_normal, hemia_abnormal, mental_normal, mental_abnormal, otherphyscal_yes, serologicalhiv_positive, serologicalhiv_negative, serologicalsyphilis_positive, serologicalsyphilis_negative, hepatitis_b_positive, hepatitis_b_negative, blood_malaria_positive, blood_malaria_negative, tuberculosis_positive, tuberculosis_negative, stool_parasites_positive, stool_parasites_negative, haematology_normal, haematology_abnormal, urinalysis_normal, urinalysis_abnormal, urinetest_amphetamine_positive, urinetest_amphetamine_negative, urinetest_morphine_positive, urinetest_morphine_negative, mariyuana_positive, mariyuana_negative, checkup_leprosy_positive, checkup_leprosy_negative, conclusion, keperluan, serologicalsyphilis_vdrl, serologicalsyphilis_tpha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('suratstudiluarmcu_id, negaratujuan, masaberlaku, nomorsurat, pasien_id, pendaftaran_id, nopasport, pegawai_id, heartdease_yes, heartdease_no, hypertension_yes, hypertension_no, lungdisease_yes, lungdisease_no, asthma_yes, asthma_no, liverdisease_yes, liverdisease_no, diabetes_yes, diabetes_no, kidneydisease_yes, kidneydisease_no, leprosy_yes, leprosy_no, sexsuallytransmiedinfection_yes, sexsuallytransmiedinfection_no, pyschiatricillnes_yes, pyschiatricillnes_no, hepatitis_yes, hepatitis_no, druguse_yes, druguse_no, epilepsi_yes, epilepsi_no, malaria_yes, malaria_no, tubercolosis_yes, tubercolosis_no, hiv_aids_yes, hiv_aids_no, denguehemorrhagicfever_yes, denguehemorrhagicfever_no, otherdisease_yes, otherdisease_keterangan, height, weight, sistolic_bloodpressure, diastolic_bloodpressure, skin_normal, skin_abnormal, vision_right, vision_left, ears_normal, ears_abnormal, eyes_normal, eyes_abnormal, heart_normal, heart_abnormal, lungs_normal, lungs_abnormal, liver_normal, liver_abnormal, spleen_normal, spleen_abnormal, tyrhoidgland_normal, tyrhoidgland_abnormal, lymphnodes_normal, lymphnodes_abnormal, ekternalgenitalia_normal, ekternalgenitalia_abnormal, hemia_normal, hemia_abnormal, mental_normal, mental_abnormal, otherphyscal_yes, otherphyscal_keterangan, serologicalhiv_positive, serologicalhiv_negative, serologicalsyphilis_positive, serologicalsyphilis_negative, hepatitis_b_positive, hepatitis_b_negative, blood_malaria_positive, blood_malaria_negative, blood_malaria_species, tuberculosis_positive, tuberculosis_negative, stool_parasites_positive, stool_parasites_negative, stool_parasites_species, haematology_normal, haematology_abnormal, urinalysis_normal, urinalysis_abnormal, urinetest_amphetamine_positive, urinetest_amphetamine_negative, urinetest_morphine_positive, urinetest_morphine_negative, mariyuana_positive, mariyuana_negative, checkup_leprosy_positive, checkup_leprosy_negative, conclusion, tgl_pemeriksaan, keperluan, serologicalsyphilis_vdrl, serologicalsyphilis_tpha, pulse', 'safe', 'on'=>'search'),
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
			'suratstudiluarmcu_id' => 'Suratstudiluarmcu',
			'negaratujuan' => 'Negaratujuan',
			'masaberlaku' => 'Masaberlaku',
			'nomorsurat' => 'Nomorsurat',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'nopasport' => 'Nopasport',
			'pegawai_id' => 'Pegawai',
			'heartdease_yes' => 'Heartdease Yes',
			'heartdease_no' => 'Heartdease No',
			'hypertension_yes' => 'Hypertension Yes',
			'hypertension_no' => 'Hypertension No',
			'lungdisease_yes' => 'Lungdisease Yes',
			'lungdisease_no' => 'Lungdisease No',
			'asthma_yes' => 'Asthma Yes',
			'asthma_no' => 'Asthma No',
			'liverdisease_yes' => 'Liverdisease Yes',
			'liverdisease_no' => 'Liverdisease No',
			'diabetes_yes' => 'Diabetes Yes',
			'diabetes_no' => 'Diabetes No',
			'kidneydisease_yes' => 'Kidneydisease Yes',
			'kidneydisease_no' => 'Kidneydisease No',
			'leprosy_yes' => 'Leprosy Yes',
			'leprosy_no' => 'Leprosy No',
			'sexsuallytransmiedinfection_yes' => 'Sexsuallytransmiedinfection Yes',
			'sexsuallytransmiedinfection_no' => 'Sexsuallytransmiedinfection No',
			'pyschiatricillnes_yes' => 'Pyschiatricillnes Yes',
			'pyschiatricillnes_no' => 'Pyschiatricillnes No',
			'hepatitis_yes' => 'Hepatitis Yes',
			'hepatitis_no' => 'Hepatitis No',
			'druguse_yes' => 'Druguse Yes',
			'druguse_no' => 'Druguse No',
			'epilepsi_yes' => 'Epilepsi Yes',
			'epilepsi_no' => 'Epilepsi No',
			'malaria_yes' => 'Malaria Yes',
			'malaria_no' => 'Malaria No',
			'tubercolosis_yes' => 'Tubercolosis Yes',
			'tubercolosis_no' => 'Tubercolosis No',
			'hiv_aids_yes' => 'Hiv Aids Yes',
			'hiv_aids_no' => 'Hiv Aids No',
			'denguehemorrhagicfever_yes' => 'Denguehemorrhagicfever Yes',
			'denguehemorrhagicfever_no' => 'Denguehemorrhagicfever No',
			'otherdisease_yes' => 'Otherdisease Yes',
			'otherdisease_keterangan' => 'Otherdisease Keterangan',
			'height' => 'Height',
			'weight' => 'Weight',
			'sistolic_bloodpressure' => 'Sistolic Bloodpressure',
			'diastolic_bloodpressure' => 'Diastolic Bloodpressure',
			'skin_normal' => 'Skin Normal',
			'skin_abnormal' => 'Skin Abnormal',
			'vision_right' => 'Vision Right',
			'vision_left' => 'Vision Left',
			'ears_normal' => 'Ears Normal',
			'ears_abnormal' => 'Ears Abnormal',
			'eyes_normal' => 'Eyes Normal',
			'eyes_abnormal' => 'Eyes Abnormal',
			'heart_normal' => 'Heart Normal',
			'heart_abnormal' => 'Heart Abnormal',
			'lungs_normal' => 'Lungs Normal',
			'lungs_abnormal' => 'Lungs Abnormal',
			'liver_normal' => 'Liver Normal',
			'liver_abnormal' => 'Liver Abnormal',
			'spleen_normal' => 'Spleen Normal',
			'spleen_abnormal' => 'Spleen Abnormal',
			'tyrhoidgland_normal' => 'Tyrhoidgland Normal',
			'tyrhoidgland_abnormal' => 'Tyrhoidgland Abnormal',
			'lymphnodes_normal' => 'Lymphnodes Normal',
			'lymphnodes_abnormal' => 'Lymphnodes Abnormal',
			'ekternalgenitalia_normal' => 'Ekternalgenitalia Normal',
			'ekternalgenitalia_abnormal' => 'Ekternalgenitalia Abnormal',
			'hemia_normal' => 'Hemia Normal',
			'hemia_abnormal' => 'Hemia Abnormal',
			'mental_normal' => 'Mental Normal',
			'mental_abnormal' => 'Mental Abnormal',
			'otherphyscal_yes' => 'Otherphyscal Yes',
			'otherphyscal_keterangan' => 'Otherphyscal Keterangan',
			'serologicalhiv_positive' => 'Serologicalhiv Positive',
			'serologicalhiv_negative' => 'Serologicalhiv Negative',
			'serologicalsyphilis_positive' => 'Serologicalsyphilis Positive',
			'serologicalsyphilis_negative' => 'Serologicalsyphilis Negative',
			'hepatitis_b_positive' => 'Hepatitis B Positive',
			'hepatitis_b_negative' => 'Hepatitis B Negative',
			'blood_malaria_positive' => 'Blood Malaria Positive',
			'blood_malaria_negative' => 'Blood Malaria Negative',
			'blood_malaria_species' => 'Blood Malaria Species',
			'tuberculosis_positive' => 'Tuberculosis Positive',
			'tuberculosis_negative' => 'Tuberculosis Negative',
			'stool_parasites_positive' => 'Stool Parasites Positive',
			'stool_parasites_negative' => 'Stool Parasites Negative',
			'stool_parasites_species' => 'Stool Parasites Species',
			'haematology_normal' => 'Haematology Normal',
			'haematology_abnormal' => 'Haematology Abnormal',
			'urinalysis_normal' => 'Urinalysis Normal',
			'urinalysis_abnormal' => 'Urinalysis Abnormal',
			'urinetest_amphetamine_positive' => 'Urinetest Amphetamine Positive',
			'urinetest_amphetamine_negative' => 'Urinetest Amphetamine Negative',
			'urinetest_morphine_positive' => 'Urinetest Morphine Positive',
			'urinetest_morphine_negative' => 'Urinetest Morphine Negative',
			'mariyuana_positive' => 'Mariyuana Positive',
			'mariyuana_negative' => 'Mariyuana Negative',
			'checkup_leprosy_positive' => 'Checkup Leprosy Positive',
			'checkup_leprosy_negative' => 'Checkup Leprosy Negative',
			'conclusion' => 'Conclusion',
			'tgl_pemeriksaan' => 'Tgl. Pemeriksaan',
			'keperluan' => 'Keperluan',
			'serologicalsyphilis_vdrl' => 'Serologicalsyphilis Vdrl',
			'serologicalsyphilis_tpha' => 'Serologicalsyphilis Tpha',
			'pulse' => 'Pulse',
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

		$criteria->compare('suratstudiluarmcu_id',$this->suratstudiluarmcu_id);
		$criteria->compare('negaratujuan',$this->negaratujuan,true);
		$criteria->compare('masaberlaku',$this->masaberlaku,true);
		$criteria->compare('nomorsurat',$this->nomorsurat,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('nopasport',$this->nopasport,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('heartdease_yes',$this->heartdease_yes);
		$criteria->compare('heartdease_no',$this->heartdease_no);
		$criteria->compare('hypertension_yes',$this->hypertension_yes);
		$criteria->compare('hypertension_no',$this->hypertension_no);
		$criteria->compare('lungdisease_yes',$this->lungdisease_yes);
		$criteria->compare('lungdisease_no',$this->lungdisease_no);
		$criteria->compare('asthma_yes',$this->asthma_yes);
		$criteria->compare('asthma_no',$this->asthma_no);
		$criteria->compare('liverdisease_yes',$this->liverdisease_yes);
		$criteria->compare('liverdisease_no',$this->liverdisease_no);
		$criteria->compare('diabetes_yes',$this->diabetes_yes);
		$criteria->compare('diabetes_no',$this->diabetes_no);
		$criteria->compare('kidneydisease_yes',$this->kidneydisease_yes);
		$criteria->compare('kidneydisease_no',$this->kidneydisease_no);
		$criteria->compare('leprosy_yes',$this->leprosy_yes);
		$criteria->compare('leprosy_no',$this->leprosy_no);
		$criteria->compare('sexsuallytransmiedinfection_yes',$this->sexsuallytransmiedinfection_yes);
		$criteria->compare('sexsuallytransmiedinfection_no',$this->sexsuallytransmiedinfection_no);
		$criteria->compare('pyschiatricillnes_yes',$this->pyschiatricillnes_yes);
		$criteria->compare('pyschiatricillnes_no',$this->pyschiatricillnes_no);
		$criteria->compare('hepatitis_yes',$this->hepatitis_yes);
		$criteria->compare('hepatitis_no',$this->hepatitis_no);
		$criteria->compare('druguse_yes',$this->druguse_yes);
		$criteria->compare('druguse_no',$this->druguse_no);
		$criteria->compare('epilepsi_yes',$this->epilepsi_yes);
		$criteria->compare('epilepsi_no',$this->epilepsi_no);
		$criteria->compare('malaria_yes',$this->malaria_yes);
		$criteria->compare('malaria_no',$this->malaria_no);
		$criteria->compare('tubercolosis_yes',$this->tubercolosis_yes);
		$criteria->compare('tubercolosis_no',$this->tubercolosis_no);
		$criteria->compare('hiv_aids_yes',$this->hiv_aids_yes);
		$criteria->compare('hiv_aids_no',$this->hiv_aids_no);
		$criteria->compare('denguehemorrhagicfever_yes',$this->denguehemorrhagicfever_yes);
		$criteria->compare('denguehemorrhagicfever_no',$this->denguehemorrhagicfever_no);
		$criteria->compare('otherdisease_yes',$this->otherdisease_yes);
		$criteria->compare('otherdisease_keterangan',$this->otherdisease_keterangan,true);
		$criteria->compare('height',$this->height);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('sistolic_bloodpressure',$this->sistolic_bloodpressure);
		$criteria->compare('diastolic_bloodpressure',$this->diastolic_bloodpressure);
		$criteria->compare('skin_normal',$this->skin_normal);
		$criteria->compare('skin_abnormal',$this->skin_abnormal);
		$criteria->compare('vision_right',$this->vision_right,true);
		$criteria->compare('vision_left',$this->vision_left,true);
		$criteria->compare('ears_normal',$this->ears_normal);
		$criteria->compare('ears_abnormal',$this->ears_abnormal);
		$criteria->compare('eyes_normal',$this->eyes_normal);
		$criteria->compare('eyes_abnormal',$this->eyes_abnormal);
		$criteria->compare('heart_normal',$this->heart_normal);
		$criteria->compare('heart_abnormal',$this->heart_abnormal);
		$criteria->compare('lungs_normal',$this->lungs_normal);
		$criteria->compare('lungs_abnormal',$this->lungs_abnormal);
		$criteria->compare('liver_normal',$this->liver_normal);
		$criteria->compare('liver_abnormal',$this->liver_abnormal);
		$criteria->compare('spleen_normal',$this->spleen_normal);
		$criteria->compare('spleen_abnormal',$this->spleen_abnormal);
		$criteria->compare('tyrhoidgland_normal',$this->tyrhoidgland_normal);
		$criteria->compare('tyrhoidgland_abnormal',$this->tyrhoidgland_abnormal);
		$criteria->compare('lymphnodes_normal',$this->lymphnodes_normal);
		$criteria->compare('lymphnodes_abnormal',$this->lymphnodes_abnormal);
		$criteria->compare('ekternalgenitalia_normal',$this->ekternalgenitalia_normal);
		$criteria->compare('ekternalgenitalia_abnormal',$this->ekternalgenitalia_abnormal);
		$criteria->compare('hemia_normal',$this->hemia_normal);
		$criteria->compare('hemia_abnormal',$this->hemia_abnormal);
		$criteria->compare('mental_normal',$this->mental_normal);
		$criteria->compare('mental_abnormal',$this->mental_abnormal);
		$criteria->compare('otherphyscal_yes',$this->otherphyscal_yes);
		$criteria->compare('otherphyscal_keterangan',$this->otherphyscal_keterangan,true);
		$criteria->compare('serologicalhiv_positive',$this->serologicalhiv_positive);
		$criteria->compare('serologicalhiv_negative',$this->serologicalhiv_negative);
		$criteria->compare('serologicalsyphilis_positive',$this->serologicalsyphilis_positive);
		$criteria->compare('serologicalsyphilis_negative',$this->serologicalsyphilis_negative);
		$criteria->compare('hepatitis_b_positive',$this->hepatitis_b_positive);
		$criteria->compare('hepatitis_b_negative',$this->hepatitis_b_negative);
		$criteria->compare('blood_malaria_positive',$this->blood_malaria_positive);
		$criteria->compare('blood_malaria_negative',$this->blood_malaria_negative);
		$criteria->compare('blood_malaria_species',$this->blood_malaria_species,true);
		$criteria->compare('tuberculosis_positive',$this->tuberculosis_positive);
		$criteria->compare('tuberculosis_negative',$this->tuberculosis_negative);
		$criteria->compare('stool_parasites_positive',$this->stool_parasites_positive);
		$criteria->compare('stool_parasites_negative',$this->stool_parasites_negative);
		$criteria->compare('stool_parasites_species',$this->stool_parasites_species,true);
		$criteria->compare('haematology_normal',$this->haematology_normal);
		$criteria->compare('haematology_abnormal',$this->haematology_abnormal);
		$criteria->compare('urinalysis_normal',$this->urinalysis_normal);
		$criteria->compare('urinalysis_abnormal',$this->urinalysis_abnormal);
		$criteria->compare('urinetest_amphetamine_positive',$this->urinetest_amphetamine_positive);
		$criteria->compare('urinetest_amphetamine_negative',$this->urinetest_amphetamine_negative);
		$criteria->compare('urinetest_morphine_positive',$this->urinetest_morphine_positive);
		$criteria->compare('urinetest_morphine_negative',$this->urinetest_morphine_negative);
		$criteria->compare('mariyuana_positive',$this->mariyuana_positive);
		$criteria->compare('mariyuana_negative',$this->mariyuana_negative);
		$criteria->compare('checkup_leprosy_positive',$this->checkup_leprosy_positive);
		$criteria->compare('checkup_leprosy_negative',$this->checkup_leprosy_negative);
		$criteria->compare('conclusion',$this->conclusion,true);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('keperluan',$this->keperluan,true);
		$criteria->compare('serologicalsyphilis_vdrl',$this->serologicalsyphilis_vdrl);
		$criteria->compare('serologicalsyphilis_tpha',$this->serologicalsyphilis_tpha);
		$criteria->compare('pulse',$this->pulse);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}