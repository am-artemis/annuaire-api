<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;

use Illuminate\Http\Request;

class BaseTransformer extends TransformerAbstract
{
    // Request functions

    protected $fields = [];
    protected $fields_min = [];
    protected $fields_all = [];

    function __construct(Request $request = null) {
        if ($request and $request->has('fields')) {
            $fields = explode(',', $request->input('fields'));

            if (in_array('all', $fields)) {
                $this->fields = $this->fields_all;
            } elseif (in_array('min', $fields)) {
                $this->fields = $this->fields_min;
            } else {
                $this->fields = ['self'];
            }

            $this->fields = array_merge($this->fields, array_diff($fields, ['min', 'all']));
        }
    }

    public function filter($data) {
        $fields = $this->fields;

        if (empty($fields)) {
            return $data;
        } else {
            return array_filter($data, function ($value, $key) use ($fields) {
                return in_array($key, $fields);
            }, ARRAY_FILTER_USE_BOTH);
        }
    }


    // Transformer functions

    public function itemArray($model, $transformer, $resourceKey = null) {
        // Transforme le model
        $resource = $this->item($model, $transformer, $resourceKey);

        return $this->arraySerialize($resource);
    }

    public function collectionArray($collection, $transformer, $resourceKey = null) {
        // Transforme la collection
        $resource = $this->collection($collection, $transformer, $resourceKey);

        $result = $this->arraySerialize($resource);

        return $result['data'];
    }

    private function arraySerialize($resource) {
        // Instancie le manager
        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer());

        // Retourne la resource sous la forme d'un array
        return $manager->createData($resource)->toArray();;
    }


}
