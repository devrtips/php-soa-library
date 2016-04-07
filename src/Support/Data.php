<?php

namespace Devrtips\Soa\Support;

class Data
{
    protected $data = [];
    protected $valid = false;
    protected $validator;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Filter only the given list of keys from data.
     * 
     * @param array $filter List of keys
     * @return Data $this
     */
    public function filter(array $filter)
    {
        $this->data = $this->data + $filter;

        return $this;
    }

    /**
     * Get key from data.
     * 
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return (isset($this->data[$key])) ? $this->data[$key] : null;
    }

    /**
     * Return all data.
     * 
     * @return mixed
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Validate data with the given rules.
     * 
     * @param array $rules List of keys
     * @return Data $this
     */
    public function validate(array $rules)
    {
        $this->validator = app('validator')->make($this->data, $rules);
        
        $this->valid = $this->validator->passes();

        return $this;
    }

    /**
     * Filter and validate data. If both key and value are specified, use value as validation
     * ruleset.
     * 
     * @param array $rules List of fields and validation rules
     * @return Data $this
     */
    public function filterAndValidate(array $fields)
    {
        $filterFields = [];
        $validationRules = [];

        foreach ($fields as $key => $val) {
            if (is_numeric($key)) {
                $filterFields[] = $val;
            } else {
                $filterFields[] = $key;
                $validationRules[$key] = $val;
            }
        }

        return $this->filter($filterFields)
            ->validate($validationRules);
    }

    /**
     * Return validation errors.
     * 
     * @return array
     */
    public function errors()
    {
        try {
            return $this->validator->errors()->toArray();    
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Check if data is invalid.
     * 
     * @return bool
     */
    public function invalid()
    {
        return (bool) !$this->valid;
    }

    /**
     * Check if data is valid.
     * 
     * @return bool
     */
    public function valid()
    {
        return (bool) $this->valid;
    }
}