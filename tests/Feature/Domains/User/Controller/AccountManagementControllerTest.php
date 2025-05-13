<?php

namespace Tests\Feature\Domains\User\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AccountManagementControllerTest extends TestCase
{
    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "AccountManagementControllerTest::testRules" tests/Feature/
     */
    public function testRules(): void
    {
        $data = [
            "username" => "akuoke"
        ];

        $rules = [
            "username" => "required|min:8|max:255|lowercase",
        ];

        $rules1 = [
            "username" => ["required","min:8","max:255","lowercase", ],
            "name" => ["required","min:8","max:255"],
            "telephone" => ["required", "regex:^\+(?:[0-9][0-9]?)-\d{3}-\d{4}-\d+^"],
            "agreedTermsOfUse" => "required",
        ];

        $rules2 = [
            "email" => ["required","email","max:255"],
            "password" => ["required", Password::min(8)->letters()->numbers()->symbols()->mixedCase()],
        ];

        $rules3 = $rules1 + $rules2;

        // echo "\$rules1 : ". PHP_EOL;
        // var_dump(json_encode($rules1,JSON_PRETTY_PRINT));
        // echo "\$rules2 : ". PHP_EOL;
        // var_dump(json_encode($rules2,JSON_PRETTY_PRINT));
        // echo "\$rules3 : ". PHP_EOL;
        // var_dump(json_encode($rules3,JSON_PRETTY_PRINT));

        $validator = Validator::make($data, $rules3);
        $validatorAgain = Validator::make($data, $rules);
        self::assertNotNull($validator->fails());
        self::assertNotNull($validatorAgain->fails());
    }

    /**
     * @test
     * @return void
     * 
     * Command to run this only unit test function
     * vendor/bin/phpunit --filter "AccountControllerTest::testfunctionName" tests/Feature/
     */
    public function testfunctionName(): void
    {
        self::markTestIncomplete();
    }
}
