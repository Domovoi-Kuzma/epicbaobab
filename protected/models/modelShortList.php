<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 08.08.2019
 * Time: 13:44
 */
/**
 * Class ModelShortList
 *
 * модель для запроса данных, которые отображаются на форме добавления/изменения сотрудника/встречи
 * (это одна форма, модель подкидывает в неё различные параметры в зависимости от...)
 * запрашивается пока только список из опций (список встреч для создания сотр.)/(список сотр. для создания встречи)
 * плюс класс подкидывает некоторые строки типа "список встреч" для отображения в заголовке страницы
 *
 * отображается на viewInsertForm.php
 */
class ModelShortList extends  CFormModel
{
    /**
     * @var string $name
     * текстовое поле на форме.
     */
    public $name;
    /**
     * @var string $id
     * ключ записи, что редактируется. (-1 если новая запись)
     */
    public $id;
    /**
     * @var string $optionstable
     * таблица, из которой берётся список (например встреч для выставления отношений у нового сотрудника)
     */
    public $optionstable;
    /**
     * @var string $maintable
     * таблица, из которой берётся значение текстового поля (например для редактирования сотрудника)
     */
    public $maintable;
    /**
     * @var string $buddyField
     * название колонки из $optionstable с именами, из которой берётся список
     */
    public $buddyField;
    /**
     * @var string $myField
     * название колонки из $maintable с именами, из которой берётся список
     */
    public $myField;
    /**
     * @var string $myIDcaption
     * название колонки из таблицы relations с нашим ID
     */
    public $myIDcaption;
    /**
     * @var string $optionsIDcaption
     * название колонки из таблицы relations с ID отношений к нашему
     */
    public $optionsIDcaption;
    /**
     * @var array $options SQL query result
     */
    public $options;
    /**
     * @var array $checkedoptions contains indices of options array, corresponding to checked options
     */
    public $checkedoptions;

    /**
     * ModelInsertForm constructor.
     * @param $what   опция либо 'employees' для работы со страницей сотрудников,
     *                      либо 'meets' для работы со страницей встреч,
     * @param $id     ключ записи в базе
     */
    function __construct($what, $id=-1)
    {
        $this->id=$id;

        if ($what == 'employees')
        {
            $this->optionstable = 'meets';//editing employee requires list of meetings
            $this->buddyField = 'Meeting';
            $this->maintable = 'people';
            $this->myField = 'Name';
            $this->myIDcaption ='EID';
            $this->optionsIDcaption ='MID';
        }
        else//if ($what == 'meets')
        {
            $this->optionstable = 'people';//editing employee requires list of people (to show in checkbox)
            $this->buddyField = 'Name';
            $this->maintable = 'meets';
            $this->myField = 'Meeting';
            $this->myIDcaption ='MID';
            $this->optionsIDcaption ='EID';
        }
    }

    /**
     * QueryNames
     * 1. выполняет запрос к БД списка пунктов для отображения в списке чекбоксов для выставления отношений у нового сотрудника
     * 2. выполняет запрос к БД имя самого сотрудника
     */
    public function QueryNames(){

        $sql = "SELECT * FROM $this->optionstable";
        $nameslist = Yii::app()->db->createCommand($sql)->queryAll();
        foreach($nameslist as $name)
            $this->options[$name["ID"]] = $name[$this->buddyField];


        $sql = "SELECT ID FROM $this->optionstable JOIN  relations ON ID=$this->optionsIDcaption AND $this->myIDcaption=$this->id";
        $toogled= Yii::app()->db->createCommand($sql)->queryAll();
        foreach($toogled as $name)
            $this->checkedoptions[]=$name["ID"];

        $sql = "SELECT * FROM $this->maintable WHERE ID=$this->id";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if (!empty($result))
            $this->name=$result[0][$this->myField ];
    }
}