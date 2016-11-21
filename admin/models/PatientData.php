<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "patient_data".
 *
 * @property string $id
 * @property string $title
 * @property string $language
 * @property string $financial
 * @property string $fname
 * @property string $lname
 * @property string $mname
 * @property string $DOB
 * @property string $street
 * @property string $postal_code
 * @property string $city
 * @property string $state
 * @property string $country_code
 * @property string $drivers_license
 * @property string $ss
 * @property string $occupation
 * @property string $phone_home
 * @property string $phone_biz
 * @property string $phone_contact
 * @property string $phone_cell
 * @property integer $pharmacy_id
 * @property string $status
 * @property string $contact_relationship
 * @property string $date
 * @property string $sex
 * @property string $referrer
 * @property string $referrerID
 * @property integer $providerID
 * @property integer $ref_providerID
 * @property string $email
 * @property string $email_direct
 * @property string $ethnoracial
 * @property string $race
 * @property string $ethnicity
 * @property string $interpretter
 * @property string $migrantseasonal
 * @property string $family_size
 * @property string $monthly_income
 * @property string $homeless
 * @property string $financial_review
 * @property string $pubpid
 * @property string $pid
 * @property string $genericname1
 * @property string $genericval1
 * @property string $genericname2
 * @property string $genericval2
 * @property string $hipaa_mail
 * @property string $hipaa_voice
 * @property string $hipaa_notice
 * @property string $hipaa_message
 * @property string $hipaa_allowsms
 * @property string $hipaa_allowemail
 * @property string $squad
 * @property integer $fitness
 * @property string $referral_source
 * @property string $usertext1
 * @property string $usertext2
 * @property string $usertext3
 * @property string $usertext4
 * @property string $usertext5
 * @property string $usertext6
 * @property string $usertext7
 * @property string $usertext8
 * @property string $userlist1
 * @property string $userlist2
 * @property string $userlist3
 * @property string $userlist4
 * @property string $userlist5
 * @property string $userlist6
 * @property string $userlist7
 * @property string $pricelevel
 * @property string $regdate
 * @property string $contrastart
 * @property string $completed_ad
 * @property string $ad_reviewed
 * @property string $vfc
 * @property string $mothersname
 * @property string $guardiansname
 * @property string $allow_imm_reg_use
 * @property string $allow_imm_info_share
 * @property string $allow_health_info_ex
 * @property string $allow_patient_portal
 * @property string $deceased_date
 * @property string $deceased_reason
 * @property integer $soap_import_status
 * @property string $cmsportal_login
 */
class PatientData extends \yii\db\ActiveRecord
{
    private $fullName;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DOB', 'date', 'financial_review', 'regdate', 'contrastart', 'ad_reviewed', 'deceased_date'], 'safe'],
            [['occupation', 'fullName'], 'string'],
            [['pharmacy_id', 'providerID', 'ref_providerID', 'pid', 'fitness', 'soap_import_status'], 'integer'],
            [['pid'], 'required'],
            [['title', 'language', 'financial', 'fname', 'lname', 'mname', 'street', 'postal_code', 'city', 'state', 'country_code', 'drivers_license', 'ss', 'phone_home', 'phone_biz', 'phone_contact', 'phone_cell', 'status', 'contact_relationship', 'sex', 'referrer', 'referrerID', 'email', 'email_direct', 'ethnoracial', 'race', 'ethnicity', 'interpretter', 'migrantseasonal', 'family_size', 'monthly_income', 'homeless', 'pubpid', 'genericname1', 'genericval1', 'genericname2', 'genericval2', 'usertext1', 'usertext2', 'usertext3', 'usertext4', 'usertext5', 'usertext6', 'usertext7', 'usertext8', 'userlist1', 'userlist2', 'userlist3', 'userlist4', 'userlist5', 'userlist6', 'userlist7', 'pricelevel', 'vfc', 'mothersname', 'guardiansname', 'allow_imm_reg_use', 'allow_imm_info_share', 'allow_health_info_ex', 'deceased_reason'], 'string', 'max' => 255],
            [['hipaa_mail', 'hipaa_voice', 'hipaa_notice', 'hipaa_allowsms', 'hipaa_allowemail', 'completed_ad'], 'string', 'max' => 3],
            [['hipaa_message'], 'string', 'max' => 20],
            [['squad'], 'string', 'max' => 32],
            [['referral_source'], 'string', 'max' => 30],
            [['allow_patient_portal'], 'string', 'max' => 31],
            [['cmsportal_login'], 'string', 'max' => 60],
            [['pid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'language' => 'Language',
            'financial' => 'Financial',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'mname' => 'Mname',
            'DOB' => 'Dob',
            'street' => 'Street',
            'postal_code' => 'Postal Code',
            'city' => 'City',
            'state' => 'State',
            'country_code' => 'Country Code',
            'drivers_license' => 'Drivers License',
            'ss' => 'Ss',
            'occupation' => 'Occupation',
            'phone_home' => 'Phone Home',
            'phone_biz' => 'Phone Biz',
            'phone_contact' => 'Phone Contact',
            'phone_cell' => 'Phone Cell',
            'pharmacy_id' => 'Pharmacy ID',
            'status' => 'Status',
            'contact_relationship' => 'Contact Relationship',
            'date' => 'Date',
            'sex' => 'Sex',
            'referrer' => 'Referrer',
            'referrerID' => 'Referrer ID',
            'providerID' => 'Provider ID',
            'ref_providerID' => 'Ref Provider ID',
            'email' => 'Email',
            'email_direct' => 'Email Direct',
            'ethnoracial' => 'Ethnoracial',
            'race' => 'Race',
            'ethnicity' => 'Ethnicity',
            'interpretter' => 'Interpretter',
            'migrantseasonal' => 'Migrantseasonal',
            'family_size' => 'Family Size',
            'monthly_income' => 'Monthly Income',
            'homeless' => 'Homeless',
            'financial_review' => 'Financial Review',
            'pubpid' => 'Pubpid',
            'pid' => 'Pid',
            'genericname1' => 'Genericname1',
            'genericval1' => 'Genericval1',
            'genericname2' => 'Genericname2',
            'genericval2' => 'Genericval2',
            'hipaa_mail' => 'Hipaa Mail',
            'hipaa_voice' => 'Hipaa Voice',
            'hipaa_notice' => 'Hipaa Notice',
            'hipaa_message' => 'Hipaa Message',
            'hipaa_allowsms' => 'Hipaa Allowsms',
            'hipaa_allowemail' => 'Hipaa Allowemail',
            'squad' => 'Squad',
            'fitness' => 'Fitness',
            'referral_source' => 'Referral Source',
            'usertext1' => 'Usertext1',
            'usertext2' => 'Usertext2',
            'usertext3' => 'Usertext3',
            'usertext4' => 'Usertext4',
            'usertext5' => 'Usertext5',
            'usertext6' => 'Usertext6',
            'usertext7' => 'Usertext7',
            'usertext8' => 'Usertext8',
            'userlist1' => 'Userlist1',
            'userlist2' => 'Userlist2',
            'userlist3' => 'Userlist3',
            'userlist4' => 'Userlist4',
            'userlist5' => 'Userlist5',
            'userlist6' => 'Userlist6',
            'userlist7' => 'Userlist7',
            'pricelevel' => 'Pricelevel',
            'regdate' => 'Regdate',
            'contrastart' => 'Contrastart',
            'completed_ad' => 'Completed Ad',
            'ad_reviewed' => 'Ad Reviewed',
            'vfc' => 'Vfc',
            'mothersname' => 'Mothersname',
            'guardiansname' => 'Guardiansname',
            'allow_imm_reg_use' => 'Allow Imm Reg Use',
            'allow_imm_info_share' => 'Allow Imm Info Share',
            'allow_health_info_ex' => 'Allow Health Info Ex',
            'allow_patient_portal' => 'Allow Patient Portal',
            'deceased_date' => 'Deceased Date',
            'deceased_reason' => 'Deceased Reason',
            'soap_import_status' => 'Soap Import Status',
            'cmsportal_login' => 'Cmsportal Login',
            'fullName' => 'pat. Full Name',
        ];
    }
    public function setFullName()
    {
        $tmpname = $this->lname;
        (isset($this->fname)) ? $tmpname = $tmpname.' '.$this->fname : $tmpname = $tmpname;
        (isset($this->mname)) ? $tmpname = $tmpname.' '.$this->mname : $tmpname = $tmpname;
        $this->fullName = $tmpname;
    }
    
    public function getFullName()
    {
        $this->setFullName();
        return $this->fullName;
    }
}
