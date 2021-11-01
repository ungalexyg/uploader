<?php
namespace App\Validators\CustomRules;

// use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

/**
 * Base Custom Rule
 */
class BaseCustomRule implements Rule
{
    /**
     * SSO/Context Provider
     *
     * @var null|string
     */
    protected $provider = null;


    /**
     * Validation action
     *
     * @var null|string
     */
    protected $action = null;


    /**
     * Validate entity
     *
     * @var null|object
     */
    protected $entity = null;


    /**
     * Ref data
     *
     * @var null|array
     */
    protected $data = [];


    /**
     * Validation message
     *
     * @var string
     */
    protected $message = '';


    /**
     * Construct
     *
     * @param string] $action
     * @param object $user
     * @param string $provider
     * @param array $data
     * @return void
     */
    public function __construct($action=null, $entity=null, $provider=null, $data=[])
    {
        $this->action   = $action;
        $this->entity   = $entity;
        $this->provider = $provider;
        $this->data     = $data;
    }

    /**
     * Custom validation
     * should be implemented by the child classes
     *
     * @param string $attribute
     * @param string $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return false;
    }

    /**
     * Return validation message
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
