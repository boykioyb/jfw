Cấu trúc thư mục
```
app/
├── [ModuleName]/
│   ├── Domains/
│   │   ├── Entities/
│   │   │   └── [EntityName].php                # Các thực thể (Entities)
│   │   ├── Repositories/
│   │   │   └── [EntityRepository].php          # Các interface cho Repository
│   │   ├── Events/
│   │   │   └── ProductCreated.php               # Event khi sản phẩm được tạo
│   │   ├── Services/                           # Nghiệp vụ của domain (tùy chọn)
│   │   └── ValueObjects/                       # Các giá trị đối tượng (Value Objects)
│   │   └── Mappers/                            # Chuyển đổi hoặc ánh xạ dữ liệu giữa các tầng
│   ├── Application/
│   │   ├── Listeners/
│   │   │   └── NotifyAdminWhenProductCreated.php # Listener cho event ProductCreated
│   │   ├── Commands/
│   │   │   └── [CommandUseCase].php            # Các UseCase kiểu Command
│   │   ├── Queries/
│   │   │   └── [QueryUseCase].php              # Các UseCase kiểu Query
│   │   └── DTOs/                               # Các DTO chuyển dữ liệu
│   ├── Infrastructure/
│   │   ├── Persistence/
│   │   │   ├── Migrations/                         # Migration cho cơ sở dữ liệu
│   │   │   ├── Repositories/                       
│   │   │   │   └── Eloquent[EntityRepository].php  # Repository thực thi (implementation)
│   │   └── Config/
│   │       └── module_config.php               # Cấu hình riêng cho từng module
│   │   ├── Providers/
│   │   │   └── ProductServiceProvider.php       # Provider của module Product
│   │   ├── Middleware/
│   │   │   └── ExampleMiddleware.php            # Middleware của module Product
│   │   ├── Policies/
│   │   │   └── ProductPolicy.php                # Policy của Product
│   │   └── Factories/
│   │       └── ProductFactory.php               # Factory để tạo dữ liệu giả (dùng cho test)
│   └── Presentation/
│       ├── API/                                # API dành cho client
│       │   ├── Controllers/                    # Controller xử lý API request
│       │   └── Routes/
│       │       └── api.php                     # Định nghĩa route cho API
│       ├── Console/                            # Console dành cho nội bộ hoặc service
│       │   ├── Controllers/                    # Controller xử lý Console request
│       │   └── Routes/
│       │       └── console.php                 # Định nghĩa route cho console
│       └── Task/
│           └── Schedulers/                     # Các task như cron job hoặc scheduled tasks
```

Chi tiết về từng phần
1. Domains: Đây là nơi chứa các logic nghiệp vụ cốt lõi của từng module.
- Entities: Định nghĩa các đối tượng nghiệp vụ, các thực thể đại diện cho dữ liệu và hành vi cốt lõi.
- Repositories: Chứa các interface của repository, định nghĩa cách lấy và lưu dữ liệu.
- Services: Các dịch vụ thực hiện nghiệp vụ phức tạp liên quan đến nhiều entity (tuỳ chọn).
- ValueObjects: Các đối tượng giá trị không thay đổi, ví dụ như tiền tệ, địa chỉ.

2. Application: Tầng này quản lý các UseCase cụ thể của ứng dụng.
- Commands: Các lệnh thay đổi trạng thái của hệ thống (thêm, xóa, sửa dữ liệu).
- Queries: Các lệnh chỉ truy vấn dữ liệu mà không thay đổi trạng thái hệ thống.
- DTOs: Data Transfer Objects dùng để truyền dữ liệu giữa các tầng.

3. Infrastructure: Quản lý các thành phần liên quan đến hạ tầng kỹ thuật.
- Persistence: Thực thi các repository cụ thể như sử dụng Eloquent để tương tác với database.
- Migrations: Chứa các file migration để quản lý cấu trúc bảng dữ liệu.
- Config: Cấu hình module như cài đặt mặc định, thuế, đơn vị tiền tệ,...

4. Presentation: Tầng này xử lý việc giao tiếp với bên ngoài (API, Web, UI).
- Http/Controllers: Xử lý các request từ người dùng thông qua HTTP.
- Routes: Định nghĩa các endpoint cho API hoặc web.
