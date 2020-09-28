<?php

namespace App\Http\Controllers;

class Mutation extends Controller
{

    /**
     * @param $platform <String> The platform name the data is from
     * @param $data <Object> The raw API response object.
     *
     * @return array|mixed|null
     */
    public function mutate($platform, $data) {
        switch ($platform) {
            case 'shopify':
                return $this->shopify($data);
            case 'woocommerce':
                return $this->woocommerce($data);
            default:
                return null;
        }
    }
    /**
     * Mutate WooCommerce data into our standardised response
     *
     * @param $data Object The API data.
     *
     * @return array Our response object.
     */
    private static function woocommerce($data) {

        $map = function($variants) {
            $output = [];
            forEach($variants as $variant) {
                $output[] = [
                    'variantID' => $variant['id'],
                    'variantWeight' => $variant['weight'],
                    'variantPrice' => [
                        'USD' => $variant['price'],
                    ],
                    'variantInventory' => ($variant['stock_quantity'] ?: 0)
                ];
            }

            return $output;
        };

        $output = [];

        forEach( $data as $product ) {

            $output[] = [
                'productID' => $product['id'],
                'productName' => $product['name'],
                'productVariations' => $map($product['variations'])
            ];
        }

        return $output;
    }

    /**
     * Mutate Shopify data into our standardised response
     *
     * @param $data Object The API data.
     *
     * @return array Our response object.
     */
    private static function shopify($data) {

        function mapVariants($variants) {
            $output = [];
            forEach($variants as $variant) {

                $prices = [];

                forEach($variant['presentment_prices'] as $price) {
                    $prices[strtoupper($price['price']['currency_code'])] = $price['price']['amount'];
                }

                $output[] = [
                    'variantID' => $variant['id'],
                    'variantWeight' => (string)$variant['weight'],
                    'variantPrice' => $prices,
                    'variantInventory' => $variant['inventory_quantity']
                ];
            }

            return $output;
        }

        $products = $data['products'];
        $output = [];

        forEach( $products as $product ) {
            $output[] = [
                'productID' => $product['id'],
                'productName' => $product['title'],
                'productVariations' => mapVariants($product['variants'])
            ];
        }



        return $output;
    }
}
