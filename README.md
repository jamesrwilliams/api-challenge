# API Challenge

An API built on [Laravel Lumen](https://lumen.laravel.com/) for producing a standardised API between WooCommerce and Shopify API calls.

Currently, this project maps the following response formats:

1. [Shopify](https://shopify.dev/docs/admin-api/rest/reference/products/product#index-2020-07)
2. [WooCommerce](https://woocommerce.github.io/woocommerce-rest-api-docs/#list-all-products)

**Please Note:** Currently this project uses mocked data loaded from local JSON files under: `/storage/app/*-fake.json`. In addition, the lookup for each store ID and it's associated platform is also mocked in the `sites.json` file.

## Getting started

First install the project dependencies using [composer](https://getcomposer.org), by running:

```
composer install
```

Then start the application server by running the following command:

```
php -S localhost:8000 -t public
```

## Platform Configuration

Each platform's unique API response is mapped to our unified schema using a unique mapping function that can be found in the [Mutations.php Controller](./app/Http/Controllers/Mutation.php).

## Adding a new platform

To add a platform you will need to follow these steps:

1. Create a JSON file of mocked data in the `storage/app/` directory that matches the `[PLATFORM]-fake.json` nomenclature.
2. Add a new entry in to the `stores.json` file with the same `[PLATFORM]` value as used before for its value.
3. Create a new mutator method on the [Mutations.php Controller](./app/Http/Controllers/Mutation.php) and update the switch statement to support the new mutator.

## Response Schema

Below is an example of the response format this API produces:

```
{
    productID: string,
    productName: string,
    productVariations: array [
        variantID: number
        variantWeight: string
        variantPrice: 
        variantInventory: number
    ]
}
```

## Running the tests

Test for [Laravel Lumen](https://lumen.laravel.com/docs/8.x/testing) are implemented using [PHPUnit](https://phpunit.de/). These tests (found in the `./test directory) can be executed by running the following command:

```
./vendor/bin/phpunit tests
```

## Issues / Edge cases

- **Products with no variations** - Currently product weight and values are only made available via product variations. There would need to add some form of handling for products that do not have any variations.
- **WooCommerce** - Currency potentially not passed by default as property of products, would need a establish a way of understanding the default currency and returning that in a standard format. for this example we're assuming USD.
