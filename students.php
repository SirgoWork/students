<?php
//avoid direct access to file
if (!defined('_PS_VERSION_'))
{
    exit;
}

class students extends Module
{
    public $models = ['StudentModel'];
    //tabs to be created in the backoffice menu
    protected $tabs = [
        [
            'name'      => 'Students',
            'className' => 'AdminStudentModel',
            'active'    => 1,
        ],
    ];

    public function __construct()
    {
        $this->name    = 'students';
        $this->version = '1.0';
        //module category
        $this->tab = 'shipping_logistic';

        $this->author     = 'sirgo';
        $this->author_uri = '';

        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => '1.6.99'];
        $this->displayName = 'Students';
        $this->description = 'Implement a full CRUD using the PrestaShop default structure.';
        parent::__construct();
    }
    //add a tab in the backoffice menu
    public function addTab(
        $tabs,
        $id_parent = 0
    )
    {
        foreach ($tabs as $tab)
        {
            $tabModel             = new Tab();
            $tabModel->module     = $this->name;
            $tabModel->active     = $tab['active'];
            $tabModel->class_name = $tab['className'];
            $tabModel->id_parent  = $id_parent;
            //tab text in each language
            foreach (Language::getLanguages(true) as $lang)
            {
                $tabModel->name[$lang['id_lang']] = $tab['name'];
            }
            $tabModel->add();
        }
        return true;
    }
    //remove a tab and its childrens from the backoffice menu
    public function removeTab($tabs)
    {
        foreach ($tabs as $tab)
        {
            $id_tab = (int) Tab::getIdFromClassName($tab["className"]);
            if ($id_tab)
            {
                $tabModel = new Tab($id_tab);
                $tabModel->delete();
            }
        }
        return true;
    }
    public function install()
    {
        foreach ($this->models as $model)
        {
            require_once 'classes/' . $model . '.php';
            //instantiate the module
            $modelInstance = new $model();
            //create the table relative to this model in the database
            //if the table does not exists yet
            $modelInstance->createDatabase();
            //if the table already exists, add to it any column that may be missing.
            //this is useful in the case of new updates that require new columns
            //to exist in the table.
            $modelInstance->createMissingColumns();
        }
        //module installation
        $success = parent::install() && $this->registerHook('leftColumn');
        //if the installation fails, return error
        if (!$success)
        {
            return false;
        }
        //create the tabs in the backoffice menu
        $this->addTab($this->tabs);
        return true;
    }
    public function uninstall(){
        $this->removeTab($this->tabs);
        return parent::uninstall();
    }
    public function hookLeftColumn($params)
    {
        $id_lang = $this->context->language->id;
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('student', 's');
        $sql->leftJoin('student_lang', 'l', 's.id_student = l.id_student AND l.id_lang = '.(int)$id_lang);
        $sql->where('s.active = 1');
        $res = Db::getInstance()->executeS($sql);
        foreach ($res AS $row) {
            $arr[] = $row['name'];
        }
        $this->context->smarty->assign('students', $arr);

        $sql = new DbQuery();
        $sql->select('name, max(average) as rez');
        $sql->from('student', 's');
        $sql->leftJoin('student_lang', 'l', 's.id_student = l.id_student AND l.id_lang = '.(int)$id_lang);
        $sql->where('s.active = 1');
        $res = Db::getInstance()->executeS($sql);
        foreach ($res AS $row) {
            $arr[] = $row['name'];
        }
        $this->context->smarty->assign('students2', $res[0]['name'] );

        $sql = new DbQuery();
        $sql->select('max(average) as rez');
        $sql->from('student', 's');
        $sql->leftJoin('student_lang', 'l', 's.id_student = l.id_student AND l.id_lang = '.(int)$id_lang);
        $res = Db::getInstance()->executeS($sql);
        foreach ($res AS $row) {
            $arr[] = $row['rez'];
        }
        $this->context->smarty->assign('students3', $res[0]['rez'] );
        return $this->display(__FILE__, 'students.tpl');
    }
}