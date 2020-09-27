<?php

class APITest extends TestCase {

    public function testForInvalidStoreID() {
        $response = $this->call('GET', '/f/o/o/b/a/r');
        $this->assertEquals(404, $response->status());
    }

    public function testForErroneousStoreID() {
        $response = $this->call('GET', '/stores/111111111/products');
        $this->assertEquals(404, $response->status());
    }

    public function testForMissingStoreID() {
        $response = $this->call('GET', '/stores/products');
        $this->assertEquals(404, $response->status());
    }

    public function testForIncorrectVerbOnStoreID() {
        $response = $this->call('POST', '/stores/1/products');
        $this->assertEquals(405, $response->status());
        $response = $this->call('PUT', '/stores/1/products');
        $this->assertEquals(405, $response->status());
    }

    public function testShopify()
    {
        $this->get('/stores/1/products')->seeJsonEquals([
            [
                'productID' => 632910392,
                'productName' => "IPod Nano - 8GB",
                'productVariations' => [
                    [
                        'variantID' => 808950810,
                        'variantWeight' => "1.25",
                        'variantPrice' => [
                            'USD' => "199.00"
                        ],
                        'variantInventory' => 10
                    ],
                    [
                        'variantID' => 49148385,
                        'variantWeight' => "1.25",
                        'variantPrice' => [
                            'USD' => "199.00"
                        ],
                        'variantInventory' => 20
                    ]
                ]
            ],
            [
                'productID' => 	921728736,
                'productName' => "IPod Touch 8GB",
                'productVariations' => [
                    [
                        'variantID' => 447654529,
                        'variantWeight' => "1.25",
                        'variantPrice' => [
                            'USD' => "199.00"
                        ],
                        'variantInventory' => 13
                    ]
                ]
            ]
        ]);
    }

    public function testWooCommerce() {
        $this->get('/stores/2/products')->seeJsonEquals([
            [
                'productID' => 799,
                'productName' => "Ship Your Idea",
                'productVariations' => [
                    [
                        'variantID' => 733,
                        'variantWeight' => '',
                        'variantPrice' => [
                            'USD' => "9.00"
                        ],
                        'variantInventory' => 0
                    ],
                    [
                        'variantID' => 732,
                        'variantWeight' => "1.6kg",
                        'variantInventory' => 0,
                        'variantPrice' => [
                            'USD' => "9.00"
                        ],
                    ]
                ]
            ],
            [
                'productID' => 	794,
                'productName' => "Premium Quality",
                'productVariations' => []
            ]
        ]);
    }
}
