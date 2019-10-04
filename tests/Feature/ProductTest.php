<?php

namespace Tests\Feature;

use Tests\TestCase;
use Arr;
use Artisan;

class ProductTest extends TestCase
{
    /**
     * Default json pagination structure.
     *
     * @param array
     */
    protected $jsonPaginationStructure = [
        'current_page',
        'data' => [
            '*' => [
                'id',
                'name',
                'amount',
                'stock',
                'created_at',
                'updated_at',
                'type' => [
                    'name'
                ]
            ]
        ],
        'first_page_url',
        'from',
        'last_page',
        'last_page_url',
        'next_page_url',
        'path',
        'per_page',
        'prev_page_url',
        'to',
        'total'
    ];

    /**
    * Test unauthorized list.
    *
    * @return void
    */
   public function testDatabase()
    {
        print "\nCreating database for testing.\n";

        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');

        $this->assertDatabaseHas('users', [
            'api_token' => 'kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS'
        ]);

        $this->assertDatabaseHas('product_types', [
            'name' => 'seringa'
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Balanca 1',
            'stock' => 25,
            'amount' => 199.90,
            'created_at' => '2019-10-03 17:00:00',
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Aparelho de Pressao 1',
            'created_at' => '2019-10-03 17:00:00',
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Aparelho de Pressao 1',
            'created_at' => '2019-10-03 16:00:00',
        ]);

        $this->assertDatabaseHas('products', [
            'product_type_id' => 17,
            'stock' => 310,
        ]);
    }

    /**
     * Test unauthorized list.
     *
     * @return void
     */
    public function testUnauthorized()
    {
        print "\nTesting authentication.\n";

        //check unauthorized
        $withoutApiToken = $this->json('GET', route('api.v1.products.index'));

        $withoutApiToken
            ->assertJson(['message' => 'Unauthenticated.'], 'Checking user unauthorized.')
            ->assertStatus(401, 'Checking status code.');
    }


    /**
     * Test simple search.
     *
     * @return void
     */
    public function testSimpleSearch()
    {
        print "\nTesting index route.\n";

        //without search parameters
        $parameters = [
            'api_token' => 'kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS'
        ];

        $simpleSearch = $this->withHeaders(['Accept' => 'application/json'])
                            ->json('GET', route('api.v1.products.index', $parameters));

        //check returned all products
        $simpleSearch
            ->assertStatus(200)
            ->assertJsonFragment(
            [
                'total' => 50
            ]);
    }

    /**
     * Test simple search.
     *
     * @return void
     */
    public function testChangePage()
    {
        print "\nTesting index route with change page.\n";

        //without search parameters
        $parameters = [
            'api_token' => 'kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS',
            'page' => 3
        ];

        $simpleSearch = $this->withHeaders(['Accept' => 'application/json'])
                            ->json('GET', route('api.v1.products.index', $parameters));

        //check returned all products
        $simpleSearch
            ->assertStatus(200)
            ->assertJsonFragment(
            [
                'current_page' => 3
            ]);
    }

    /**
     * Test type search.
     *
     * @return void
     */
    public function testTypeSearch()
    {
        print "\nTesting index route with type search.\n";

        //with type search
        $parameters = [
            'api_token' => 'kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS',
            'q' => 'seringa'
        ];

        $typeSearch = $this->withHeaders(['Accept' => 'application/json'])
                            ->json('GET', route('api.v1.products.index', $parameters));

        $typeSearch
            ->assertJsonStructure($this->jsonPaginationStructure)
            ->assertStatus(200);

        $jsonResponse = $typeSearch->decodeResponseJson();

        // checks if is type equals "seringa"
        $isCorrectType = true;
        foreach($jsonResponse['data'] as $jsonDataItems) {
            if($jsonDataItems['type']['name'] !== 'seringa') {
                $isCorrectType = false;
            }
        }

        $this->assertTrue($isCorrectType);
    }

    /**
     * Test for list route.
     *
     * @return void
     */
    public function testFilterSearch()
    {
        print "\nTesting index route with filter search.\n";

        //with type search
        $parameters = [
            'api_token' => 'kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS',
            'filter' => 'stock:25,amount:199.90'
        ];

        $filterSearch = $this
                            ->withHeaders(['Accept' => 'application/json'])
                            ->json('GET', route('api.v1.products.index', $parameters));

        $filterSearch
            ->assertJsonStructure($this->jsonPaginationStructure)
            ->assertStatus(200);

        $jsonResponse = $filterSearch->decodeResponseJson();

        // checks if is filtered correctly
        $isCorrectFiltered = true;
        foreach($jsonResponse['data'] as $jsonDataItems) {
            if($jsonDataItems['amount'] !== "199.90" || $jsonDataItems['stock'] !== 25) {
                $isCorrectFiltered = false;
            }
        }

        $this->assertTrue($isCorrectFiltered);
    }

    /**
     * Test for list route.
     *
     * @return void
     */
    public function testSortList()
    {
        print "\nTesting index route with sort.\n";

        //with type search
        $parameters = [
            'api_token' => 'kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS',
            'sort' => 'name:asc,created_at:desc'
        ];

        $sortResults = $this
                        ->withHeaders(['Accept' => 'application/json'])
                        ->json('GET', route('api.v1.products.index', $parameters));

        $sortResults
            ->assertJsonStructure($this->jsonPaginationStructure)
            ->assertStatus(200);

        $jsonResponse = array_slice($sortResults->decodeResponseJson()['data'], 0, 3);

        // checks if result give this expected object
        $expected = [
            'names' => ['Aparelho de Pressao 1', 'Aparelho de Pressao 1', 'Balanca 1'],
            'creation_dates' => ['2019-10-03 17:00:00', '2019-10-03 16:00:00', '2019-10-03 17:00:00']
        ];

        $namesIsCorrect = Arr::pluck($jsonResponse, 'name') === $expected['names'];
        $creationDateIsCorrect = Arr::pluck($jsonResponse, 'created_at') == $expected['creation_dates'];

        $this->assertTrue($namesIsCorrect);
        $this->assertTrue($creationDateIsCorrect);
    }

    /**
     * Test for list route.
     *
     * @return void
     */
    public function testSearchWrongParameters()
    {
        print "\nTesting index route with wrong parameters.\n";

        //with type search
        $parameters =  [
            'api_token' => 'kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS',
            'filter' => 'amou:932.90,stock:25,created_at:',
            'q'      => 'sering',
            'sort'   => 'name:,brand:BUZNL'
        ];

        $passingWrongParameters = $this
            ->withHeaders(['Accept' => 'application/json'])
            ->json('GET', route('api.v1.products.index', $parameters));

        $passingWrongParameters
            ->assertJsonStructure($this->jsonPaginationStructure)
            ->assertStatus(200);

        $jsonResponse = $passingWrongParameters->decodeResponseJson();

        //checks if the only filter corrected, "stock", will be used
        //all others will be ignored
        $isCorrectFiltered = true;
        foreach($jsonResponse['data'] as $jsonDataItems) {
            if($jsonDataItems['stock'] !== 310) {
                $isCorrectFiltered = false;
            }
        }

        $this->assertTrue($isCorrectFiltered);
    }

    /**
     * Test for find route.
     *
     * @return void
     */
    public function testFindRoute()
    {
        print "\nTesting find route.\n";

        $parameters =  [
            'api_token' => 'kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS',
            'id'        => 1
        ];

        $passingWrongParameters = $this
            ->withHeaders(['Accept' => 'application/json'])
            ->json('GET', route('api.v1.products.show', $parameters));

        $passingWrongParameters
            ->assertStatus(200);
    }

    /**
     * Test for create route.
     *
     * @return void
     */
    public function testCreateRoute()
    {
        print "\nTesting create route.\n";

        $parameters =  [
            'api_token' => 'kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS',
        ];

        $body = [
            'name'   => 'Estetoscópio Littmann Classic III Black Edition',
            'brand'  => 'BUNZL',
            'type'   => 'estetoscopio',
            'stock'  =>  350,
            'amount' =>  759.90
        ];

        $store = $this
            ->withHeaders(['Accept' => 'application/json'])
            ->json('POST', route('api.v1.products.store', $parameters), $body);

        $store
            ->assertStatus(201)
            ->assertJsonFragment([
                'name'   => 'Estetoscópio Littmann Classic III Black Edition',
                'brand'  => 'BUNZL',
                'type'   => [
                    'name' => 'estetoscopio'
                ],
                'stock'  =>  350,
                'amount' =>  759.90
            ]);
    }

    /**
     * Test for update route.
     *
     * @return void
     */
    public function testUpdateRoute()
    {
        print "\nTesting update route.\n";

        $body = [
            'name' => 'teste',
            'brand' => 'BUNZL',
            'type' => 'luva'
        ];

        $update = $this
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/x-www-form-urlencoded'])
            ->json('PUT', route('api.v1.products.index')."/21?api_token=kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS", $body);

        $update
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'teste',
                'brand' => 'BUNZL',
                'type' => [
                    'name' => 'luva'
                ]
            ]);
    }

    /**
     * Test for delete route.
     *
     * @return void
     */
    public function testDeleteRoute()
    {
        print "\nTesting delete route.\n";

        $passingWrongParameters = $this
            ->withHeaders(['Accept' => 'application/json'])
            ->json("delete", route('api.v1.products.index')."/28?api_token=kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS");

        $passingWrongParameters
            ->assertStatus(204);
    }
}
