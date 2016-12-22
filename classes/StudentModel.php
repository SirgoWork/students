<?php
require_once 'CustomObjectModel.php';
class StudentModel extends CustomObjectModel
{
    public static $definition = [
        'table'     => 'student',
        'primary'   => 'id_student',
        'multilang' => true,
        'fields'    => [
            'id_student'   => ['type' => self::TYPE_INT, 'validate' => 'isInt'],
            'name'         => ['type' => self::TYPE_STRING, 'db_type' => 'varchar(255)', 'lang' => true],
            'date_birth'   => ['type' => self::TYPE_DATE, 'validate' => 'isDate', 'db_type'  => 'datetime'],
            'active'       => ['type' => self::TYPE_BOOL, 'validate' => 'isBool', 'db_type' => 'int'],
            'average'      => ['type' => self::TYPE_FLOAT, 'validate' => 'isFloat', 'db_type' => 'float'],
        ],
    ];
    public $id_student;
    public $name;
    public $date_birth;
    public $active;
    public $average;
}