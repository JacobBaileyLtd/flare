<?php

namespace JacobBaileyLtd\Flare\Admin\Models;

use Illuminate\Support\Str;
use JacobBaileyLtd\Flare\Traits\Permissionable;
use JacobBaileyLtd\Flare\Contracts\PermissionsContract;
use JacobBaileyLtd\Flare\Traits\ModelAdmin\ModelWriteable;
use JacobBaileyLtd\Flare\Traits\ModelAdmin\ModelValidation;
use JacobBaileyLtd\Flare\Traits\Attributes\AttributeAccess;
use JacobBaileyLtd\Flare\Contracts\ModelAdmin\ModelWriteableContract;
use JacobBaileyLtd\Flare\Contracts\ModelAdmin\ModelValidationContract;

abstract class ManagedModel implements PermissionsContract, ModelValidationContract, ModelWriteableContract
{
    use AttributeAccess, ModelValidation, ModelWriteable, Permissionable;

    /**
     * Managed Model Instance
     * 
     * @var string
     */
    public $managedModel;

    /**
     * Model Instance
     *
     * @var object
     */
    public $model;

    /**
     * Validation Rules for onCreate, onEdit actions.
     * 
     * @var array
     */
    protected $summary_fields = [];

    public function __construct()
    {
        if (!isset($this->managedModel) || $this->managedModel === null) {
            throw new Exception('You have a ManagedModel which does not have a model assigned to it.', 1);
        }

        $this->model = new $this->managedModel();
    }

    /**
     * ShortName of a ModelAdmin Class.
     *
     * @return string
     */
    public static function ShortName()
    {
        return (new \ReflectionClass(new static()))->getShortName();
    }

    /**
     * Title of a ModelAdmin Class.
     *
     * @return string
     */
    public static function Title()
    {
        if (!isset(static::$title) || !static::$title) {
            return str_replace('Managed', '',  static::ShortName());
        }

        return static::$title;
    }

    /**
     * Plural of the ModelAdmin Class Title.
     *
     * @return string
     */
    public static function PluralTitle()
    {
        if (!isset(static::$pluralTitle) || !static::$pluralTitle) {
            return Str::plural(str_replace(' Managed', '',  static::Title()));
        }

        return static::$pluralTitle;
    }

    /**
     * URL Prefix to a ModelAdmin Top Level Page.
     *
     * @return string
     */
    public static function UrlPrefix()
    {
        if (!isset(static::$urlPrefix) || !static::$urlPrefix) {
            return strtolower(str_replace('Managed', '',  static::PluralTitle()));
        }

        return static::$urlPrefix;
    }

    /**
     * Formats and returns the Summary fields
     * 
     * @return
     */
    public function getSummaryFields()
    {
        $summary_fields = [];

        foreach ($this->summary_fields as $field => $fieldTitle) {

            if (in_array($field, $this->model->getFillable())) {
                if (!$field) {
                    $field = $fieldTitle;
                    $fieldTitle = Str::title($fieldTitle);
                }

                $summary_fields[$field] = $fieldTitle;
                continue;
            }

            if(($methodBreaker = strpos($field, '.'))!==false) {
                $method = substr($field, 0, $methodBreaker);

                if (method_exists($this->model, $method)) {
                    
                    if(method_exists($this->model->$method(), $submethod = str_replace($method.'.', '', $field))) {
                        $this->model->$method()->$submethod();

                        $summary_fields[$field] = $fieldTitle;
                    } 

                } 
                
            }

        }

        if (count($summary_fields)) {
            return $summary_fields;
        }

        return [$this->model->primaryKey];
    }
}