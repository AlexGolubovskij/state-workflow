<?php

namespace Ringierimu\StateWorkflow\Tests;

use Ringierimu\StateWorkflow\StateWorkflowServiceProvider;
use Ringierimu\StateWorkflow\Tests\Fixtures\Models\User;
use Ringierimu\StateWorkflow\Tests\Fixtures\Traits\ConfigTrait;

/**
 * Class TestCase.
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use ConfigTrait;

    /** @var User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->loadMigrationsFrom(__DIR__.'/Fixtures/database/migrations/');
        $this->withFactories(__DIR__.'/Fixtures/database/factories/');

        $this->user = factory(User::class)->create(
            [
                'user_state' => 'new',
            ]
        );

        auth()->login(factory(User::class)->create(
            [
                'user_state' => 'new',
            ]
        ));
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [StateWorkflowServiceProvider::class];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('workflow', $this->getWorflowConfig());
        parent::getEnvironmentSetUp($app); // TODO: Change the autogenerated stub
    }
}
