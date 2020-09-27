<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Mutation as Mutation;

class ProductsController extends Controller
{

    public function storeProducts($storeId) {

        $type = $this->queryStoreType($storeId);

        if(!$type) {
            return response()->json([
                'error' => [
                    'code' => '404',
                    'message' => 'Not found'
                ]
            ], 404);
        } else {

            $data = $this->loadData($type);
            $mutation = new Mutation();
            $response =  $mutation->mutate($type, $data);

            return response()->json($response);
        }

    }

    /**
     *
     * This function currently mocks a DB call to fetch a store ID mapping.
     *
     * @param $storeID <string> The storeID we're fetching products for.
     *
     * @return string|null The store type string or null if not found.
     */
    private function queryStoreType($storeID) {

        $mappings = storage_path('app/stores.json');
        $mappings = json_decode(file_get_contents($mappings), true);

        if(array_key_exists($storeID, $mappings)) {
            return $mappings[$storeID];
        } else {
            return null;
        }

    }

    private function loadData($type) {
        $filePath = storage_path('app/'. $type . '-fake.json');
        return json_decode(file_get_contents($filePath), true);
    }

}
