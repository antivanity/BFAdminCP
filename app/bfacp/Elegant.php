<?php namespace BFACP;

use Illuminate\Database\Eloquent\Model AS Eloquent;
use Illuminate\Support\Facades\Validator;

class Elegant extends Eloquent
{
    /**
     * Validation rules
     *
     * @var array
     */
    protected static $rules = [];

    /**
     * Custom messages
     *
     * @var array
     */
    protected static $messages = [];

    /**
     * Validation errors
     *
     * @var Illuminate\Support\MessageBag
     */
    protected $errors = [];

    /**
     * Validator instance
     *
     * @var Illuminate\Validation\Validators
     */
    protected $validator;

    public function __construct(array $attributes = array(), Validator $validator = null)
    {
        parent::__construct($attributes);

        $this->validator = $validator ?: \App::make('validator');
    }

    /**
     * Listen for save event
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            return $model->validate();
        });
    }

    /**
     * Validates current attributes against rules
     */
    public function validate()
    {
        $v = $this->validator->make($this->attributes, static::$rules, static::$messages);

        if ($v->fails())
        {
            $this->setErrors($v->messages());
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Set error message bag
     *
     * @var Illuminate\Support\MessageBag
     */
    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Retrieve error message bag
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Inverse of wasSaved
     */
    public function hasErrors()
    {
        return ! empty($this->errors);
    }

    /**
     * Retrieve the validation rules
     */
    public function getRules()
    {
        return static::$rules;
    }
}
