<?php
namespace App\Services\Validator\Lib;

use App\Services\Validator\Validator;
use Phalcon\Di;

abstract class ValidatorRequest
{

    protected $request;

    /**
     * ValidatorRequest constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator = null)
    {
        $request = Di::getDefault()->getRequest();
        $this->request = $request;
        $validator = $validator ?? new Validator();
        $data = $validator->validating($this->handle());
        $request->setData($data);
    }

    /**
     * @return array
     */
   abstract public function handle() : array;

}
