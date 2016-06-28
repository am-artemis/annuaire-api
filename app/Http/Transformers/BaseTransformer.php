<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;

class BaseTransformer extends TransformerAbstract
{
    /**
     * List of fields available.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * List of minimal set of fields to filter before sending the response if null, all fields will be sent.
     *
     * @var array
     */
    protected $fields_minimal = null;


    public function setFieldsMinimal($array)
    {
        $this->fields_minimal = $array;
    }

    public function itemArray($model, $transformer, $resourceKey = null)
    {
        // Transforme le model
        $resource = $this->item($model, $transformer, $resourceKey);

        return $this->arraySerialize($resource);
    }

    private function arraySerialize($resource)
    {
        // Instancie le manager
        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer());

        // Retourne la resource sous la forme d'un array
        return $manager->createData($resource)->toArray();;
    }


    // Transformer functions

    public function collectionArray($collection, $transformer, $resourceKey = null)
    {
        // Transforme la collection
        $resource = $this->collection($collection, $transformer, $resourceKey);

        $result = $this->arraySerialize($resource);

        return $result['data'];
    }

    /**
     * Filter an array with given fields.
     *
     * @param $data
     *
     * @return array
     */
    protected function filter($data)
    {
        $filter = $this->getFilter();

        $filtered_array = array_filter($data, function ($value, $key) use ($filter) {
            return in_array($key, $filter);
        }, ARRAY_FILTER_USE_BOTH);

        return $filtered_array;
    }

    /**
     * Get filter set to apply
     *
     * @return array
     */
    protected function getFilter()
    {
        // Dependency injection don't work in Transformers for the moment
        $request = app()->request;

        // Set the fields
        if ($request->has('fields')) {
            $request_fields = explode(',', $request->input('fields'));

            // If $this->fields_minimal is not null, let the possiblity to query all (by defaul all is sent if $fields_minimal is null)
            if (in_array('all', $request_fields) or in_array('*', $request_fields)) {
                return $this->fields;
            } elseif (in_array('min', $request_fields)) {
                // Permits to use 'min' to define the minimal config (May not be kept in the future)
                return array_unique(array_merge($this->fields_minimal, $request_fields));
            }

            return array_intersect($this->fields, $request_fields);
        } else {
            // If nothing specified, return all the available fields or the minimal set
            if (is_null($this->fields_minimal)) {
                return $this->fields;
            } else {
                return $this->fields_minimal;
            }
        }
    }
}
