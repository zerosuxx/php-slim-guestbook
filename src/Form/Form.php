<?php

namespace Guestbook\Form;

use Guestbook\Filter\FilterInterface;
use Guestbook\Validator\ValidationException;
use Guestbook\Validator\ValidatorInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Form
 * @package Guestbook\Form
 */
class Form
{
    /**
     * @var array
     */
    private $inputs = [];

    /**
     * @var FilterInterface[]
     */
    private $filters = [];

    /**
     * @var ValidatorInterface[]
     */
    private $validators = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    public function input($name, FilterInterface $filter, ValidatorInterface $validator = null) {
        if(in_array($name, $this->inputs)) {
            throw new \InvalidArgumentException(sprintf('An input named "%s" has already been added!', $name));
        }
        $this->inputs[] = $name;
        $this->data[$name] = null;
        $this->filters[$name] = $filter;
        if($validator) {
            $this->validators[$name] = $validator;
        }
    }

    public function handle(ServerRequestInterface $request)
    {
        $postData = $request->getParsedBody();
        foreach ($this->inputs as $name) {
            $value = isset($postData[$name]) ? $postData[$name] : null;
            $filter = $this->filters[$name];
            $this->data[$name] = $filter->filter($value);
        }
        return $this;
    }

    public function validate()
    {
        $data = $this->getData();
        $errors = [];
        foreach($this->validators as $name => $validator) {
            try {
                $validator->validate($data[$name]);
            } catch (ValidationException $ex) {
                $errors[] = $ex->getMessage();
            }
        }
        if($errors) {
            throw new ValidationException(implode("\n", $errors));
        }
    }


}