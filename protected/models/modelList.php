<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 08.08.2019
 * Time: 11:22
 */

class ModelList extends CModel
{
    private $names;
    private $buddies;

    private $title;
    private $dbtable;
    private $formaddress;
    private $buddyPrefix;
    private $buddyNameFieldCaptionEx;
    private $myIDFieldCaptionEx;
    private $myNameFieldCaption;
    private $buddyNameFieldCaption;
    public function Form()
    {
        return $this->formaddress;
    }
    public function Prefix()
    {
        return $this->buddyPrefix;
    }
    public function Header()
    {
        return $this->title;
    }
    public function BuddyField()
    {
        return $this->buddyNameFieldCaption;
    }
    public function MyField()
    {
        return $this->myNameFieldCaption;
    }
    function __construct($title, $what)
    {
        $this->title = $title;
        if ($what == 'employees')
        {
            $this->dbtable = 'people';
            $this->myNameFieldCaption='Name';
            $this->myIDFieldCaptionEx='p.ID';
            $this->buddyNameFieldCaptionEx = 'm.Meeting';
            $this->buddyNameFieldCaption='Meeting';
            $this->buddyPrefix='встреча';
            $this->formaddress='index.php?r=site/insertEmployeeForm';
        }
        else//if ($what == 'meets')
        {
            $this->dbtable = 'meets';
            $this->myNameFieldCaption='Meeting';
            $this->myIDFieldCaptionEx='m.ID';
            $this->buddyNameFieldCaptionEx = 'p.Name';
            $this->buddyNameFieldCaption='Name';
            $this->buddyPrefix='сотрудник';
            $this->formaddress='index.php?r=site/insertMeetingForm';
        }
    }

    /**
     */
    public function NamesList()
    {
        return $this->names;
    }


    public function RelativesList($who)
    {
        return $this->buddies[$who];
    }

    public function QueryNames()
    {
        $sql = "SELECT * FROM $this->dbtable";
        $this->names = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($this->names as $item)
        {
            $idval=$item['ID'];
            $sql = "SELECT $this->buddyNameFieldCaptionEx FROM people p JOIN meets m JOIN relations r ON m.ID=r.MID AND p.ID=r.EID AND $this->myIDFieldCaptionEx=$idval";
            $this->buddies[$item[$this->myNameFieldCaption]] = Yii::app()->db->createCommand($sql)->queryAll();
        }

    }
    public function attributeNames(){
        return array();
    }
}