# User Container

Container này quản lý tất cả các chức năng liên quan đến User trong hệ thống.

## Models

### User Model
Model chính quản lý thông tin người dùng với các quan hệ và tính năng sau:

#### Quan hệ (Relationships)
- `permissions()` - BelongsToMany với Permission model
- `activities()` - HasMany với Activity model  
- `blogs()` - HasMany với Blog model
- `publishedBlogs()` - HasMany với Blog model (chỉ blogs đã publish)
- `recentActivities()` - HasMany với Activity model (chỉ activities gần đây)
- `loginActivities()` - HasMany với Activity model (chỉ login activities)

#### Methods
- `hasPermission(string $permission)` - Kiểm tra user có permission cụ thể
- `hasAnyPermission(array $permissions)` - Kiểm tra user có bất kỳ permission nào
- `hasAllPermissions(array $permissions)` - Kiểm tra user có tất cả permissions
- `isAdmin()` - Kiểm tra user có role admin
- `isManager()` - Kiểm tra user có role manager
- `isActive()` - Kiểm tra user có status active
- `getAvatarUrlAttribute()` - Lấy URL avatar

#### Scopes
- `active()` - Lọc users có status active
- `withRole($role)` - Lọc users theo role
- `inDepartment($department)` - Lọc users theo department
- `withAvatar()` - Lọc users có avatar
- `withoutAvatar()` - Lọc users không có avatar

### Activity Model
Model quản lý hoạt động của user:

#### Quan hệ
- `user()` - BelongsTo với User model

#### Scopes
- `forUser($userId)` - Lọc activities theo user
- `withAction($action)` - Lọc activities theo action
- `recent($days = 30)` - Lọc activities gần đây

### Permission Model
Model quản lý quyền hạn trong hệ thống:

#### Quan hệ
- `users()` - BelongsToMany với User model

#### Scopes
- `forGuard($guard)` - Lọc permissions theo guard
- `withName($name)` - Lọc permissions theo tên

## Services

### ActivityService
Service quản lý việc ghi log hoạt động của user:

#### Methods
- `log(User $user, string $action, string $description, array $properties)` - Ghi log activity
- `logLogin(User $user, Request $request)` - Ghi log đăng nhập
- `logLogout(User $user)` - Ghi log đăng xuất
- `logUserCreated(User $user, User $createdBy)` - Ghi log tạo user
- `logUserUpdated(User $user, User $updatedBy, array $changes)` - Ghi log cập nhật user
- `logUserDeleted(User $user, User $deletedBy)` - Ghi log xóa user
- `getUserActivities(User $user, int $perPage)` - Lấy activities của user
- `getRecentActivities(int $perPage)` - Lấy activities gần đây
- `getActivitiesByAction(string $action, int $perPage)` - Lấy activities theo action

## Database Tables

### users
- `id` - Primary key
- `name` - Tên user
- `email` - Email (unique)
- `password` - Mật khẩu (hashed)
- `role` - Vai trò (user, manager, admin)
- `department` - Phòng ban
- `status` - Trạng thái (active, inactive)
- `avatar` - Đường dẫn avatar
- `email_verified_at` - Thời gian xác thực email
- `created_at`, `updated_at` - Timestamps

### permissions
- `id` - Primary key
- `name` - Tên permission (unique)
- `description` - Mô tả permission
- `guard_name` - Tên guard (default: web)
- `created_at`, `updated_at` - Timestamps

### activities
- `id` - Primary key
- `user_id` - Foreign key tới users
- `action` - Hành động
- `description` - Mô tả
- `ip_address` - IP address
- `user_agent` - User agent
- `properties` - JSON properties
- `created_at`, `updated_at` - Timestamps

### user_permissions (Pivot Table)
- `id` - Primary key
- `user_id` - Foreign key tới users
- `permission_id` - Foreign key tới permissions
- `created_at`, `updated_at` - Timestamps

## Usage Examples

### Kiểm tra quyền
```php
$user = User::find(1);

// Kiểm tra permission cụ thể
if ($user->hasPermission('users.create')) {
    // User có quyền tạo user
}

// Kiểm tra role
if ($user->isAdmin()) {
    // User là admin
}
```

### Ghi log activity
```php
$activityService = app(ActivityService::class);

// Ghi log đăng nhập
$activityService->logLogin($user, $request);

// Ghi log tùy chỉnh
$activityService->log($user, 'profile.updated', 'User updated profile');
```

### Lấy activities
```php
// Lấy activities của user
$activities = $user->activities()->paginate(15);

// Lấy activities gần đây
$recentActivities = $user->recentActivities;

// Lấy login activities
$loginActivities = $user->loginActivities;
```

### Lọc users
```php
// Lấy tất cả admin users
$admins = User::withRole('admin')->get();

// Lấy active users trong department
$activeUsers = User::active()->inDepartment('IT')->get();

// Lấy users có avatar
$usersWithAvatar = User::withAvatar()->get();
``` 