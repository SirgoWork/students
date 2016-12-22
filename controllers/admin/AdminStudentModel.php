<?php
require_once _PS_MODULE_DIR_ . 'students/classes/StudentModel.php';
class AdminStudentModelController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap  = true;
        $this->table      = 'student';
        $this->identifier = 'id_student';
        $this->className  = 'StudentModel';
        parent::__construct();
        $id_lang = $this->context->language->id;
        $this->_join .= ' LEFT JOIN '._DB_PREFIX_.'student_lang b ON (b.id_student = a.id_student AND b.id_lang = '. $id_lang . ')';
        $this->_select .= ' b.name as name';
        //data to the grid of the "view" action
        $this->fields_list = [
            'id_student'       => [
                'title' => $this->l('ID'),
                'type'  => 'text',
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ],
            'name'     => [
                'title' => $this->l('Name'),
                'type'  => 'text',
            ],
            'date_birth' => [
                'title' => $this->l('Date of Birth'),
                'type'  => 'datetime',
            ],
            'active'   => [
                'title'  => $this->l('Now studying'),
                'active' => 'status',
                'align'  => 'text-center',
                'class'  => 'fixed-width-sm'
            ],
            'average' => [
                'title' => $this->l('Average Score'),
                'type'  => 'float',
            ],
        ];
        $this->actions = ['edit', 'delete'];
        $this->bulk_actions = array(
            'delete' => array(
                'text'    => $this->l('Delete selected'),
                'icon'    => 'icon-trash',
                'confirm' => $this->l('Delete selected items?'),
            ),
        );
        //fields to add/edit form
        $this->fields_form = [
            'legend' => [
                'title' => $this->l('General Information'),
            ],
            'input'  => [
                'name'   => [
                    'type'     => 'text',
                    'label'    => $this->l('Name'),
                    'name'     => 'name',
                    'required' => true,
                    'lang' => true
                ],
                'date_birth'   => [
                    'type'     => 'date',
                    'label'    => $this->l('Date of Birth'),
                    'name'     => 'date_birth',
                    'required' => true,
                    'lang' => false
                ],
                'active' => [
                    'type'   => 'switch',
                    'label'  => $this->l('Now studying'),
                    'name'   => 'active',
                    'values' => [
                        [
                            'id'    => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Yes'),
                        ],
                        [
                            'id'    => 'active_off',
                            'value' => 0,
                            'label' => $this->l('No'),
                        ],
                    ],
                ],
                'average' => [
                    'type'   => 'text',
                    'label'  => $this->l('Average Score'),
                    'name'     => 'average',
                    'required' => true,
                    'lang' => false
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
            ],
        ];
    }
    public function initContent()
    {
        parent::initContent();
    }
}