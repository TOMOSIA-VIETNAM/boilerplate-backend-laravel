<?php

namespace Tests\Unit\Actions;

use App\Containers\User\Actions\GetUsersAction;
use App\Containers\User\Repositories\IUserRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class GetUsersActionTest extends TestCase
{
    use RefreshDatabase;

    private GetUsersAction $action;
    private $mockRepository;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->mockRepository = Mockery::mock(IUserRepository::class);
        $this->action = new GetUsersAction($this->mockRepository);
    }

    public function test_can_get_users_with_pagination()
    {
        // Arrange
        $users = User::factory(15)->create();
        $expectedPaginator = new LengthAwarePaginator(
            $users->take(10),
            15,
            10,
            1
        );

        $filters = [
            'per_page' => 10,
            'paginate' => true
        ];

        $this->mockRepository
            ->shouldReceive('findWithFilters')
            ->with([], 10)
            ->once()
            ->andReturn($expectedPaginator);

        // Act
        $result = $this->action->execute($filters);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(15, $result->total());
        $this->assertEquals(10, $result->perPage());
        $this->assertEquals(1, $result->currentPage());
    }

    public function test_can_get_users_with_search()
    {
        // Arrange
        $searchTerm = 'john';
        $users = User::factory(5)->create(['name' => 'John Doe']);
        $expectedPaginator = new LengthAwarePaginator(
            $users,
            5,
            10,
            1
        );

        $filters = [
            'search' => $searchTerm,
            'per_page' => 10,
            'paginate' => true
        ];

        $this->mockRepository
            ->shouldReceive('findWithFilters')
            ->with(['search' => $searchTerm], 10)
            ->once()
            ->andReturn($expectedPaginator);

        // Act
        $result = $this->action->execute($filters);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(5, $result->total());
    }

    public function test_can_get_users_with_role_filter()
    {
        // Arrange
        $role = 'admin';
        $users = User::factory(3)->create(['role' => 'admin']);
        $expectedPaginator = new LengthAwarePaginator(
            $users,
            3,
            10,
            1
        );

        $filters = [
            'role' => $role,
            'per_page' => 10,
            'paginate' => true
        ];

        $this->mockRepository
            ->shouldReceive('findWithFilters')
            ->with(['role' => $role], 10)
            ->once()
            ->andReturn($expectedPaginator);

        // Act
        $result = $this->action->execute($filters);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(3, $result->total());
    }

    public function test_returns_empty_paginator_when_no_users()
    {
        // Arrange
        $expectedPaginator = new LengthAwarePaginator(
            collect(),
            0,
            10,
            1
        );

        $filters = [
            'per_page' => 10,
            'paginate' => true
        ];

        $this->mockRepository
            ->shouldReceive('findWithFilters')
            ->with([], 10)
            ->once()
            ->andReturn($expectedPaginator);

        // Act
        $result = $this->action->execute($filters);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(0, $result->total());
        $this->assertTrue($result->isEmpty());
    }

    public function test_uses_default_per_page_when_not_specified()
    {
        // Arrange
        $users = User::factory(20)->create();
        $expectedPaginator = new LengthAwarePaginator(
            $users->take(15),
            20,
            15,
            1
        );

        $filters = [
            'paginate' => true
        ];

        $this->mockRepository
            ->shouldReceive('findWithFilters')
            ->with([], 15)
            ->once()
            ->andReturn($expectedPaginator);

        // Act
        $result = $this->action->execute($filters);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(15, $result->perPage());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
} 