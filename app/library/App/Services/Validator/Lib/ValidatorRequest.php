<?php
namespace App\Services\Validator\Lib;

use App\Services\Validator\Validator;
use PhalconApi\Http\Request;

abstract class ValidatorRequest extends Request
{

    protected $inputPost;
    /**
     * ValidatorRequest constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator = null)
    {
        $validator = $validator ?? new Validator();
        $this->inputPost = $this->getJsonRawBody();
        $validator->validating($this->handle());
    }

    /**
     * @return array
     */
   abstract public function handle() : array;

}
