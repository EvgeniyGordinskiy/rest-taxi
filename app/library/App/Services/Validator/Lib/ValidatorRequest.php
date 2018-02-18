<?php
namespace App\Services\Validator\Lib;

use App\Services\Validator\Validator;
use Phalcon\Di;

abstract class ValidatorRequest
{

    protected $inputPost;

    /**
     * ValidatorRequest constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator = null)
    {
        $request = Di::getDefault()->getRequest();
        $this->inputPost = $request->inputPost;
        $validator = $validator ?? new Validator();
        $validator->validating($this->handle());
    }

    /**
     * @return array
     */
   abstract public function handle() : array;

}
