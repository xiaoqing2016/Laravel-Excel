<?php

namespace Maatwebsite\Excel\Tests\Mixins;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Maatwebsite\Excel\Tests\Data\Stubs\Database\User;
use Maatwebsite\Excel\Tests\TestCase;

class ImportMacroTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);
    }

    /**
     * @test
     */
    public function can_import_directly_into_a_model()
    {
        User::query()->truncate();

        User::import('import-users-with-headings.xlsx');

        $this->assertCount(2, User::all());
        $this->assertEquals([
            'patrick@maatwebsite.nl',
            'taylor@laravel.com'
        ], User::query()->pluck('email')->all());
    }
}