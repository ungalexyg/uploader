<?php

namespace App\Validators\Rulers;


/**
 * Base ruler
 */
class BaseRuler
{
    /**
     * Validation action
     * should be one of the constants in ValidationAction enum
     * used as one of the pre defined parent keys in $this->base_rules in child classes
     *
     * @var null|string
     */
    public $action = null;


    /**
     * Rules entity
     *
     * @var null|object
     */
    protected $entity = null;


    /**
     * Rules data, bag with extra data for specific cases
     *
     * @var array
     */
    protected $data = [];


    /**
     * Base validation rules
     * the base array which the will be parsed to the actual validation rules.
     *
     * @var array
     */
    protected $base_rules = [];


    /**
     * Validation rules
     * the actual valid validation rules that will be used
     *
     * @var array
     */
    protected $rules = [];


    /**
     * Predefined custom validation error messages
     *
     * @var array
     */
    protected $messages = [];


    /**
     * SSO Provider
     *
     * @var null|string
     */
    protected $provider;


    /**
     * Custom rules path
     *
     * @var string
     */
    protected $rules_path = 'App\Validators\CustomRules';


    /**
     * Generate & return validation rules from pre defined base ules
     *
     * @return array
     */
    public function getRules()
    {
        return $this->applyRules();
    }


    /**
     * Get validation error messages
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages[$this->action] ?? [];
    }


    /**
     * Set action rules
     *
     * @param string $action
     * @return self
     */
    public function setAction($action)
    {
        if(!isset($this->base_rules[$action]))
        {
            throw new \Exception("Invalid rules action : $action");
        }

        $this->action = $action;

        return $this;
    }


    /**
     * Set entity for the rules
     *
     * @param object|array $entity
     * @return self
     */
    public function setEntity($entity)
    {
        if(!is_array($entity))
        {
            $entity = (object) $entity;
        }

        $this->entity = $entity;

        return $this;
    }


    /**
     * Set data for the rules
     *
     * @param array $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }


    /**
     * Generating the rules array
     *
     * @return array
     */
    protected function applyRules()
    {
        $this->ssoRules();
        $this->parseRules();
        $this->customRules();
        return $this->rules;
    }


    /**
     * Parse the base rules
     *
     * @return void
     */
    protected function parseRules()
    {
        $this->rules = [];

        foreach($this->base_rules[$this->action] as $attr => $rules)
        {
            !is_array($rules) ? $rules = explode('|', $rules) : null;

            !isset($this->rules[$attr]) ? $this->rules[$attr] = [] : null;

            foreach($rules as $rule)
            {
                $this->rules[$attr][] = $this->applyPlacements($rule);
            }
        }

        return $this;
    }



    /**
     * Apply common rules on placements
     *
     * @param string $rule
     * @return string
     */
    protected function applyPlacements($rule)
    {
        if(preg_match_all("/{{(.*?)}}/", $rule, $matches))  // locate common rule placement, e.g: {{value}}
        {
            list($placeholder, $key) = array_merge($matches[0], $matches[1]); // list the placeholder & the inner key form the results to vars

            $custom_rule = $this->rules_path.'\\'.$key;

            if(class_exists($custom_rule))
            {
                $rule = new $custom_rule($this->action, $this->entity, $this->provider, $this->data);
            }
        }

        return $rule;
    }


    /**
     * Apply custom rules
     *
     * @notes:
     * 1) this method serving as hook to the final adjustment point in the 'rules generation process',
     * allowing to extend the base rules with custom rules in the child classes.
     * 2) the usage is optional, it should be implemented only when custom rules need to be added.
     * 3) if implemented, custom rules should be added to the property $this->rules which should be returned to perform the validation.
     * 4) the properties $this->action, $this->entity, $this->provider, $this->data are set & available for custom handling
     *
     * @example:
     *
     *   protected function customRules()
     *   {
     *       // add validation rules to fields   
     *       $this->rules['username'][] = new UniqueUsernameRule(); // add custom rule to attribute
     *
     *       // conditional handling based on data values  
     *       if($this->data['something'] == 'something' )
     *       {
     *          // do specific stuff ...
     *       }
     *
     *       return $this;
     *   }
     *
     * @return array $this->rules
     */
    protected function customRules()
    {
        return $this;
    }


    #######################################
    # SSO Provider method
    #######################################


    /**
     * Set SSO provider for the rules
     *
     * @note:
     * the relevant sso provider already set via middleware
     * and the context of the rules will be applied accordingly.
     * so, the $provider param is absolutely optional,
     * for rare cases that might require extra flexibility.
     *
     * @param Object $user
     * @return self
     */
    public function setProvider($provider=null)
    {
        $this->provider = $provider ?? $this->getProvider();

        return $this;
    }


    /**
     * Get the active SSO provider
     *
     * @return void
     */
    protected function getProvider()
    {
        /* ------------------------------------------ */
        // return $this->provider ? $this->provider : (defined('ACTIVE_SSO_PROVIDER') ? ACTIVE_SSO_PROVIDER : SSOProviders::DEFAULT);
        return ''; //SSO providers not supported yet
        /* ------------------------------------------ */
    }


   /**
     * Set SSO rules
     *
     * @return self
     */
    protected function ssoRules()
    {
        if(is_null($this->provider))
        {
            $this->setProvider(); // if the provider not set specifically, check if it should be set via middleware
        }

        $action_rules = $this->base_rules[$this->action];

        $sso_rules = $this->base_rules[$this->action][$this->provider] ?? [];

        /* ------------------------------------------ */
        // $providers = SSOProviders::getValuesArray();
        $providers = []; // SSO Providers not supported 
        /* ------------------------------------------ */

        foreach($providers as $provider => $v) // clean base rules from sso base rules
        {
            unset($action_rules[$provider]);
        }

        $this->base_rules[$this->action] = array_merge($action_rules, $sso_rules); // merge action rules only with the active sso

        return $this;
    }


}
