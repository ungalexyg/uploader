<?php
namespace App\Validators\Traits;

/**
 * Has Ruler trait
 *
 * add functionality related to intreaction with the active "ruler"
 * "ruler" = one of the Rules clases with the predefined sets of rules for entity
 * in App\Lib\Validators\Rules
 * which will generate relevant rules according to set paramenters
 */
trait HasRuler
{
    /**
     * The active Rules class
     *
     * @var object
     */
    protected $ruler;


    /**
     * Set ruler action
     *
     * @param string $action
     * @return this
     */
    public function setAction($action)
    {
        $this->ruler->setAction($action);

        return $this;
    }


    /**
     * Set ruler entity
     *
     * @param array|object
     * @return void
     */
    public function setEntity($entity)
    {
        $this->ruler->setEntity($entity);

        return $this;
    }


    /**
     * Set ruler data reference
     *
     * @param array $data
     * @return this
     */
    public function setData($data)
    {
        $this->ruler->setData($data);

        return $this;
    }


    /**
     * Set ruler sso provider
     *
     * @param string $provider
     * @return this
     */
    public function setProvider($provider)
    {
        $this->ruler->setProvider($provider);

        return $this;
    }


    /**
     * Get ruler generated rules
     *
     * @return array
     */
    protected function getRules()
    {
        return ( !is_null($this->ruler) ? $this->ruler->getRules() : [] );
    }


    /**
     * Get ruler validation messages
     *
     * @return array
     */
    protected function getMessages()
    {
        return ( !is_null($this->ruler) ? $this->ruler->getMessages() : [] );
    }
}
