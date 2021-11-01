<?php
namespace App\Validators\Traits;

use Illuminate\Http\Request;

/**
 * Common Validations trait
 * aggregate common set of validation methods
 *
 */
trait CommonValidations
{
    /**
     * Validate create array
     *
     * @param array $create
     * @param array $data
     * @throws ValidationException
     * @return void
     */
    public function validateCreateArray($create, $data=[])
    {
        $this->setAction('create')->setData($data)->validateArray($create);
    }


    /**
     * Validate create request
     *
     * @param Request $request
     * @param array $data
     * @throws ValidationException
     * @return void
     */
    public function validateCreateRequest(Request $create, $data=[])
    {
        $this->setAction('create')->setData($data)->validateRequest($create);
    }


    /**
     * Validate update array
     *
     * @param array $update
     * @param object|array $entity // the entity to update
     * @param array $data
     * @throws ValidationException
     * @return void
     */
    public function validateUpdateArray($update, $entity, $data=[])
    {
        $this->setAction('update')->setEntity($entity)->setData($data)->validateArray($update);
    }


    /**
     * Validate update request
     *
     * @param Request $update
     * @param object|array $entity // the entity to update
     * @param array $data
     * @throws ValidationException
     * @return void
     */
    public function validateUpdateRequest(Request $update, $entity, $data=[])
    {
        $this->setAction('update')->setEntity($entity)->setData($data)->validateRequest($update);
    }
}
