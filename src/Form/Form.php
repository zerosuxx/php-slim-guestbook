<?php

namespace Guestbook\Form;

use Guestbook\Filter\FilterInterface;
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
     * @var array
     */
    private $data = [];

    public function input($name, FilterInterface $filter) {
        if(in_array($name, $this->inputs)) {
            throw new \InvalidArgumentException(sprintf('An input named "%s" has already been added!', $name));
        }
        $this->inputs[] = $name;
        $this->filters[$name] = $filter;
        $this->data[$name] = null;
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

    public function getData()
    {
        return $this->data;
    }
}