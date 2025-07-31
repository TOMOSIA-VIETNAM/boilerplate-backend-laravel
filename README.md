# I. Project Overview

Structure Project Sample

# II. System Requirements

-   PHP: 8.3
-   Laravel: 11.31
-   MYSQL 8.0
-   OS: Macos, Linux
-   Sail (Docker) 8.2
-   UI: Vite, Tailwind
-   Filament: 3.0 (Admin Panel)

# III. Getting started

## Installation

### 1. Clone the repository

    git clone git@github.com:TOMOSIA-VIETNAM/winner_scout.git

### 2. Switch to the repo folder

    cd winner_scout

### 3. Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

### 4. Install Laravel Sail

    docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php82-composer:latest composer install --ignore-platform-reqs

### 5. Open file `~/.zshrc` and add alias to shell

    sudo vim ~/.zshrc

Add this alias to `~/.zshrc` file

    alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'

### 6. Modify hosts file

    sudo vim /etc/hosts

Add this line to hosts file

    127.0.0.1 winner_scout.loc

## Sail/Docker for Development

### 1. Backend

    sail up -d
    sail composer install
    sail composer dump-autoload
    sail artisan key:generate
    sail artisan optimize
    sail artisan migrate
    sail artisan db:seed
    sail artisan storage:link

Document api for [scramble]('https://scramble.dedoc.co/')

Url document local: http://template-laravel-module.loc/api-docs

### 2. Frontend

    sail npm install

#### 2.1 For development

    sail npm run dev

#### 2.2 For production

    sail npm run build

## Convention Fixer

### 1. Check coding convention

    sail pint --test

### 2. Check and fix coding convention

    sail pint -v

# IV. Admin Panel (Filament)

## 1. Access Admin Panel

Document Filament at:

    https://filamentphp.com/docs

## 2. Default Login Credentials

-   **Email**: admin@admin.com
-   **Password**: password

## 3. Features

-   **Admin Management**: Complete CRUD operations for administrators
-   **Multi-language Support**: English (EN) and Japanese (JP)
-   **Language Switching**: Real-time language switching in admin panel
-   **Authentication**: Secure admin authentication with separate guard
-   **Modern UI**: Beautiful and responsive admin interface


## 4. Module Structure

The Admin module follows Laravel modular structure:

```shell
modules/Admin/
├── Filament/
│   ├── Resources/
│   │   └── AdminResource.php
│   ├── Pages/
│   │   ├── CreateAdmin.php
│   │   ├── EditAdmin.php
│   │   └── ListAdmins.php
│   └── Widgets/
├── Http/
│   ├── Controllers/
│   └── Middleware/
│       └── SetLocale.php
├── lang/
│   ├── en/
│   │   └── common.php
│   └── ja/
│       └── common.php
├── Providers/
│   ├── AdminServiceProvider.php
│   ├── FilamentServiceProvider.php
│   └── RouteServiceProvider.php
└── View/
    └── Components/
```

## 5. Database Setup

### Run Migrations and Seeders

    sail artisan migrate
    sail artisan db:seed --class=AdminSeeder

This will create the admin table and insert the default admin user.

# V. Development flow

## 1. Git flow

Create a `feature` branch from the `develop` branch  
↓  
Development (during the process, if there is a topic regarding the source code, etc.)  
↓  
Create a pull request from `feature` branch to `develop` branch  
↓  
Review  
↓  
Merge into `develop` on GitHub  
↓  
Release `main` branch to production

## 2. Git convention

### 2.1. Naming branch

-   `<type>/<issue_number><issue_name>`
-   Example:
    ```shell
      - feature/issue-352-payment-api
      - bugfix/issue-352-bug-payment
      - release/v2.1-release-payment-api
    ```

### 2.2. Commit message

-   `<type>: <description>`
-   Example:
    ```shell
      - feat: Implement Admin UI dashboard
      - refactor: Admin UI dashboard
      - fix: Bug validation email when user register
      - revert: Revert commit
    ```

# Laravel Modular Architecture Project

## 📋 Tổng quan

Dự án Laravel với kiến trúc modular hiện đại, tách biệt rõ ràng giữa core containers và feature modules. Sử dụng các pattern như Actions, Repositories, DTOs, Events, và Resources để đảm bảo tính maintainable và scalable.

## 🏗️ Kiến trúc tổng thể

```
app/
├── Containers/          # Core business logic containers
│   ├── User/            # User domain
│   └── Blog/            # Blog domain
├── Core/                # Shared core components
│   ├── Actions/         # Base action classes
│   ├── Repositories/    # Base repository classes
│   └── Services/        # Shared services
├── Models/              # Global models
├── Providers/           # Application providers
└── Http/                # HTTP layer
├── modules/             # Feature modules
│   ├── Admin/           # Admin interface module
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   ├── Middleware/
│   │   │   └── Requests/
│   │   ├── Providers/
│   │   ├── resources/
│   │   │   └── Views/
│   │   ├── routes/
│   │   └── View/
│   │   └── Api/             # API module
│   │       ├── Http/
│   │       │   ├── Controllers/
│   │       │   ├── Resources/
│   │       │   └── Requests/
│   │       ├── Providers/
│   │       ├── resources/
│   │       ├── routes/
│   │       ├── Transforms/
│   │       └── Traits/
│   └── database/           # Database migrations & seeders
```

## 🎯 Core Containers

### User Container
**Vị trí**: `app/Containers/User/`

**Chức năng**: Quản lý domain User với đầy đủ business logic

**Cấu trúc**:
```
User/
├── Actions/             # Business logic actions
│   ├── CreateUserAction.php
│   ├── UpdateUserAction.php
│   ├── DeleteUserAction.php
│   ├── GetUserByIdAction.php
│   ├── GetUsersAction.php
│   ├── UploadAvatarAction.php
│   └── DeleteAvatarAction.php
├── Data/
│   └── DTOs/           # Data Transfer Objects
│       ├── CreateUserDTO.php
│       ├── UpdateUserDTO.php
│       └── UploadAvatarDTO.php
├── Events/             # Domain events
│   ├── UserCreated.php
│   ├── UserUpdated.php
│   └── UserDeleted.php
├── Listeners/          # Event listeners
├── Models/
│   └── User.php        # Eloquent model
├── Repositories/
│   ├── IUserRepository.php    # Interface
│   └── UserRepository.php     # Implementation
└── Validators/         # Custom validators
    └── UserValidator.php
```

### Blog Container
**Vị trí**: `app/Containers/Blog/`

**Chức năng**: Quản lý domain Blog với CRUD operations

**Cấu trúc**:
```
Blog/
├── Actions/
│   ├── CreateBlogAction.php
│   ├── UpdateBlogAction.php
│   ├── DeleteBlogAction.php
│   ├── GetBlogByIdAction.php
│   └── GetBlogsAction.php
├── Data/
│   ├── DTOs/
│   │   ├── CreateBlogDTO.php
│   │   └── UpdateBlogDTO.php
│   └── ValueObjects/
├── Events/
│   ├── BlogCreated.php
│   ├── BlogUpdated.php
│   └── BlogDeleted.php
├── Listeners/
├── Models/
│   └── Blog.php
└── Repositories/
    ├── IBlogRepository.php
    └── BlogRepository.php
```

## 🔧 Core Components

### Base Classes

#### BaseAction
**Vị trí**: `app/Core/Actions/BaseAction.php`

**Chức năng**: Abstract base class cho tất cả Actions
- Cung cấp common methods
- Dependency injection container
- Error handling patterns

#### BaseRepository
**Vị trí**: `app/Core/Repositories/BaseRepository.php`

**Chức năng**: Abstract base class cho tất cả Repositories
- Common CRUD operations
- Pagination support
- Query building utilities

### Shared Services
**Vị trí**: `app/Core/Services/`

**Chức năng**: 
- `FileUploadService.php`: File upload logic
- Shared utilities và helpers

### Data Transfer Objects (DTOs)
**Vị trí**: `app/Containers/{Container}/Data/DTOs/`

**Chức năng**: 
- Validate và transform input data
- Ensure data consistency
- Type safety

**Ví dụ**:
```php
class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $role = 'user',
        public string $status = 'active'
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            email: $request->input('email'),
            role: $request->input('role', 'user'),
            status: $request->input('status', 'active')
        );
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'in:user,manager,admin',
            'status' => 'in:active,inactive'
        ];
    }
}
```

## 🎨 Feature Modules

### Admin Module
**Vị trí**: `modules/Admin/`

**Chức năng**: Web interface cho administrators

**Cấu trúc**:
```
Admin/
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   ├── BlogController.php
│   │   ├── UserAvatarController.php
│   │   ├── AuthController.php
│   │   └── Controller.php
│   ├── Middleware/
│   └── Requests/
├── Providers/
│   ├── AdminServiceProvider.php
│   ├── RouteServiceProvider.php
│   ├── ValidationProvider.php
│   └── ViewServiceProvider.php
├── resources/
│   └── Views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── index.blade.php
│       ├── users/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── show.blade.php
│       │   └── avatar.blade.php
│       └── blogs/
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
├── routes/
│   └── admin.php
└── View/
```

**Tính năng**:
- Dashboard với thống kê real-time
- User management (CRUD, avatar upload)
- Blog management (CRUD, status management)
- Modern UI với Bootstrap 5 và Font Awesome
- Responsive design với gradient themes

### API Module
**Vị trí**: `modules/Api/`

**Chức năng**: RESTful API endpoints

**Cấu trúc**:
```
Api/
├── Http/
│   ├── Controllers/
│   │   ├── ApiController.php
│   │   ├── UserController.php
│   │   ├── UserAvatarController.php
│   │   ├── AuthController.php
│   │   └── Controller.php
│   ├── Resources/
│   │   └── UserResource.php
│   └── Requests/
├── Providers/
│   ├── ApiServiceProvider.php
│   ├── RouteServiceProvider.php
│   └── ValidationProvider.php
├── resources/
├── routes/
│   └── api.php
├── Transforms/
│   └── UserTransform.php
└── Traits/
```

**Tính năng**:
- RESTful API endpoints
- JSON responses với proper formatting
- Pagination support
- Error handling
- Resource transformation
- Response transformation với Transforms

## 🔄 Service Layer Architecture

### Actions Pattern
Thay thế traditional Service layer bằng Actions:

**Ưu điểm**:
- Single responsibility principle
- Easy testing
- Clear business logic separation
- Dependency injection friendly

**Ví dụ**:
```php
class CreateUserAction extends BaseAction
{
    public function __construct(
        private IUserRepository $userRepository,
        private UserValidator $validator
    ) {}

    public function execute(CreateUserDTO $dto): User
    {
        // Validate input
        $this->validator->validate($dto->toArray());
        
        // Business logic
        $user = $this->userRepository->create($dto->toArray());
        
        // Dispatch events
        event(new UserCreated($user));
        
        return $user;
    }
}
```

### Repository Pattern
**Interface**: `IUserRepository`
**Implementation**: `UserRepository`

**Chức năng**:
- Data access abstraction
- Query optimization
- Caching support
- Database agnostic

## 🎯 Key Features

### 1. Avatar Upload System
**Chức năng**:
- File upload với validation
- Image processing
- Storage management
- URL generation

**Implementation**:
- `FileUploadService` trong Core container
- `UploadAvatarAction` trong User container
- Admin và API endpoints với dedicated controllers

### 2. Blog Management
**Chức năng**:
- Full CRUD operations
- Status management (draft, published, archived)
- Slug generation
- Featured image support

### 3. Dashboard Analytics
**Chức năng**:
- User statistics
- Role-based metrics
- Recent activity tracking
- Visual charts và tables

### 4. Modern UI/UX
**Design System**:
- Bootstrap 5 framework
- Font Awesome icons
- Custom CSS variables
- Gradient themes (Cyan/Blue-green)
- Responsive design
- Smooth animations

## 🛠️ Technical Stack

### Backend
- **Framework**: Laravel 10+
- **Database**: SQLite (development), MySQL/PostgreSQL (production)
- **Architecture**: Modular with Domain-Driven Design
- **Patterns**: Repository, Action, DTO, Event

### Frontend
- **CSS Framework**: Bootstrap 5.3.2
- **Icons**: Font Awesome 6.4.2
- **Fonts**: Google Fonts (Inter)
- **Styling**: Custom CSS với CSS Variables

### Development Tools
- **Package Manager**: Composer
- **Version Control**: Git
- **IDE Support**: Laravel IDE Helper

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.1+
- Composer
- SQLite (for development)

### Installation Steps

1. **Clone repository**:
```bash
git clone <repository-url>
cd template-laravel-module
```

2. **Install dependencies**:
```bash
composer install
```

3. **Environment setup**:
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup**:
```bash
php artisan migrate
php artisan db:seed
```

5. **Storage setup**:
```bash
php artisan storage:link
```

6. **Start development server**:
```bash
php artisan serve
```

### Configuration

#### Database Configuration
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

#### File Storage
```env
FILESYSTEM_DISK=public
```

## 📁 Directory Structure

```
├── app/
│   ├── Containers/
│   │   ├── User/
│   │   │   ├── Actions/
│   │   │   ├── Data/
│   │   │   │   └── DTOs/
│   │   │   ├── Events/
│   │   │   ├── Listeners/
│   │   │   ├── Models/
│   │   │   ├── Repositories/
│   │   │   └── Validators/
│   │   └── Blog/
│   │       ├── Actions/
│   │       ├── Data/
│   │       │   ├── DTOs/
│   │       │   └── ValueObjects/
│   │       ├── Events/
│   │       ├── Listeners/
│   │       ├── Models/
│   │       └── Repositories/
│   ├── Core/
│   │   ├── Actions/
│   │   ├── Repositories/
│   │   └── Services/
│   ├── Models/
│   ├── Providers/
│   └── Http/
├── modules/
│   ├── Admin/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   ├── Middleware/
│   │   │   └── Requests/
│   │   ├── Providers/
│   │   ├── resources/
│   │   │   └── Views/
│   │   ├── routes/
│   │   └── View/
│   └── Api/
│       ├── Http/
│       │   ├── Controllers/
│       │   ├── Resources/
│       │   └── Requests/
│       ├── Providers/
│       ├── resources/
│       ├── routes/
│       ├── Transforms/
│       └── Traits/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── routes/
├── storage/
└── config/
```

## 🔧 Service Providers

### Core Providers
- `AppServiceProvider`: Main application provider
- `RouteServiceProvider`: Route configuration

### Container Providers
- `UserServiceProvider`: User container bindings
- `BlogServiceProvider`: Blog container bindings

### Module Providers
- `AdminServiceProvider`: Admin module configuration
- `ApiServiceProvider`: API module configuration
- `ValidationProvider`: Custom validation rules
- `ViewServiceProvider`: View configuration

## 🧪 Testing Strategy

### Testing Overview
Dự án sử dụng PHPUnit để testing với coverage đầy đủ cho cả unit tests và feature tests. Tất cả tests đã được viết và pass thành công.

### Test Results Summary
- **Tổng số tests:** 16 tests
- **Tests passed:** 16 ✅
- **Tests failed:** 0 ❌
- **Tổng số assertions:** 110
- **Test coverage:** Unit tests + Feature tests

### Unit Tests
**Vị trí**: `tests/Unit/`

**Mục đích**: Test các business logic components độc lập

#### Test Structure
```
tests/Unit/
├── Actions/
│   └── GetUsersActionTest.php    # Test GetUsersAction
├── Repositories/
│   └── UserRepositoryTest.php    # Test UserRepository
├── DTOs/
│   └── CreateUserDTOTest.php     # Test DTO validation
└── ExampleTest.php               # Basic unit test
```

**Test Coverage**:
- ✅ Action execution với filters
- ✅ Pagination logic
- ✅ Search functionality
- ✅ Role filtering
- ✅ Error handling
- ✅ Default values

### Feature Tests
**Vị trí**: `tests/Feature/`

**Mục đích**: Test API endpoints và integration

#### Test Structure
```
tests/Feature/
├── Api/
│   └── UserControllerTest.php    # Test API endpoints
├── Admin/
│   └── UserControllerTest.php    # Test Admin interface
└── ExampleTest.php               # Basic feature test
```

**Test Coverage**:
- ✅ API endpoints (GET, POST, PUT, DELETE)
- ✅ Authentication với Sanctum
- ✅ JSON response structure
- ✅ Pagination metadata
- ✅ Search functionality
- ✅ Filtering by role/department
- ✅ Error handling
- ✅ Validation errors

### Running Tests

#### Chạy tất cả tests
```bash
php artisan test
```

#### Chạy unit tests
```bash
php artisan test --testsuite=Unit
```

#### Chạy feature tests
```bash
php artisan test --testsuite=Feature
```

#### Chạy specific test file
```bash
php artisan test tests/Unit/Actions/GetUsersActionTest.php
```

#### Chạy specific test method
```bash
php artisan test --filter test_can_get_users_with_pagination
```

#### Chạy tests với coverage
```bash
php artisan test --coverage
```

#### Chạy tests với verbose output
```bash
php artisan test -v
```

### Test Configuration

#### PHPUnit Configuration
**File**: `phpunit.xml`

```xml
<testsuites>
    <testsuite name="Unit">
        <directory suffix="Test.php">./tests/Unit</directory>
    </testsuite>
    <testsuite name="Feature">
        <directory suffix="Test.php">./tests/Feature</directory>
    </testsuite>
</testsuites>
```

#### Test Environment
- **Database**: SQLite in-memory cho tests
- **Authentication**: Laravel Sanctum
- **Factories**: UserFactory với realistic data
- **Seeders**: Test data generation

### Testing Best Practices

#### 1. Test Naming Convention
```php
// Unit tests
public function test_can_get_users_with_pagination()
public function test_returns_empty_paginator_when_no_users()
public function test_uses_default_per_page_when_not_specified()

// Feature tests
public function test_can_get_users_list()
public function test_can_search_users_by_name()
public function test_returns_correct_user_data_structure()
```

#### 2. Test Structure (AAA Pattern)
```php
public function test_example()
{
    // Arrange - Setup test data
    $user = User::factory()->create();
    
    // Act - Execute the action
    $response = $this->getJson('/api/v1/users');
    
    // Assert - Verify results
    $response->assertStatus(200);
}
```

#### 3. Mocking Strategy
```php
// Mock repositories for unit tests
$this->mockRepository
    ->shouldReceive('findWithFilters')
    ->with(['role' => 'admin'], 10)
    ->once()
    ->andReturn($expectedPaginator);
```

#### 4. Database Testing
```php
use RefreshDatabase; // Reset database for each test
use WithFaker;       // Generate fake data
```

### Test Data Management

#### Factories
**File**: `database/factories/UserFactory.php`

```php
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'role' => fake()->randomElement(['user', 'manager', 'admin']),
            'status' => fake()->randomElement(['active', 'inactive']),
            'department' => fake()->optional()->jobTitle(),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }
}
```

#### Seeders
**File**: `database/seeders/UserSeeder.php`

```php
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create test users with specific roles
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);
    }
}
```

### Continuous Integration

### Performance Testing

#### Database Query Testing
```php
public function test_optimized_user_query()
{
    DB::enableQueryLog();
    
    $users = User::with(['permissions', 'activities'])->get();
    
    $this->assertLessThan(5, count(DB::getQueryLog()));
}
```

#### Memory Usage Testing
```php
public function test_memory_efficient_pagination()
{
    $memoryBefore = memory_get_usage();
    
    User::paginate(1000);
    
    $memoryAfter = memory_get_usage();
    $memoryUsed = $memoryAfter - $memoryBefore;
    
    $this->assertLessThan(10 * 1024 * 1024, $memoryUsed); // 10MB limit
}
```

## 📈 Monitoring & Logging

### Application Monitoring
- Laravel Telescope (development)
- Error tracking
- Performance monitoring

### Logging Strategy
- Structured logging
- Error logging
- Access logging

## 🤝 Contributing

### Code Standards
- PSR-12 coding standards
- Laravel conventions
- Type hints và return types
- PHPDoc comments

### Git Workflow
- Feature branches
- Pull request reviews
- Semantic commit messages

## 📝 API Documentation

### User Endpoints
```
GET    /api/users          # List users
POST   /api/users          # Create user
GET    /api/users/{id}     # Get user
PUT    /api/users/{id}     # Update user
DELETE /api/users/{id}     # Delete user
POST   /api/users/{id}/avatar  # Upload avatar
DELETE /api/users/{id}/avatar  # Delete avatar
```

### Blog Endpoints
```
GET    /api/blogs          # List blogs
POST   /api/blogs          # Create blog
GET    /api/blogs/{id}     # Get blog
PUT    /api/blogs/{id}     # Update blog
DELETE /api/blogs/{id}     # Delete blog
```

## 🎨 UI/UX Guidelines

### Color Scheme
- **Primary**: Cyan (#00d2ff)
- **Secondary**: Blue (#3a7bd5)
- **Success**: Teal (#0fb9b1)
- **Warning**: Yellow (#f7b731)
- **Danger**: Red (#eb4d4b)

### Typography
- **Font Family**: Inter
- **Weights**: 300, 400, 500, 600, 700
- **Responsive**: Mobile-first approach

### Components
- **Cards**: Rounded corners, shadows
- **Buttons**: Gradient backgrounds
- **Tables**: Clean headers, hover effects
- **Forms**: Focus states, validation

## 🔄 Future Enhancements

### Planned Features
- Real-time notifications
- Advanced search & filtering
- Export functionality
- Multi-language support
- Advanced analytics
- API rate limiting
- Webhook system

### Technical Improvements
- GraphQL API
- Microservices architecture
- Docker containerization
- CI/CD pipeline
- Automated testing
- Performance optimization

## 📞 Support

### Documentation
- Inline code documentation
- API documentation
- User guides
- Developer guides

### Contact
- Issue tracking
- Feature requests
- Bug reports
- Technical support

---
