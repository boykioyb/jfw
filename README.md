# JFW  Project

## Introduction

JFW is an project built on the Laravel framework using Domain-Driven Design (DDD) architecture. This project includes modules that facilitate easy expansion and maintenance.

## System Requirements

- PHP >= 8.0
- Composer
- MySQL/MariaDB

## Installation

### 1. Clone the Project

Clone the repository to your local machine:

```bash
git clone https://github.com/yourusername/jfw.git
```
2. Install Dependencies
Navigate to the project directory and install the dependencies:
```bash
cd jfw
composer install
```
3. Configure Environment Variables, 
Copy the .env.example file to .env:
```bash
cp .env.example .env
```
Open the .env file and configure the necessary environment variables (such as database, mail, etc.):
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
4. Generate Application Key, Generate a key for your application:
```bash
php artisan key:generate
```
5. Run Migrations
Run the migrations to create the database tables:
```bash
php artisan migrate
```
6. Run Seeders (Optional)
- If you want to run seeders to populate sample data:
```bash
php artisan db:seed
```
7. Set Up Frontend (If Applicable)
- If your project has a frontend, install the Node.js dependencies:
```bash
npm install
```
8. Compile Assets
```bash
npm run dev
```
9. Start the Server
- Finally, run the Laravel server:
```bash
php artisan serve
```
Open your browser and visit http://localhost:8000 to check the application.

## Project Structure

The project is organized following DDD architecture as shown below:
```bash
app/
└── Modules/
    ├── Product/
    │   ├── Domains/
    │   ├── Infrastructure/
    │   ├── Presentation/
    │   │   ├── API/
    │   │   └── Console/
    │   └── Config/
    ├── User/
    └── ...
```

### Description of Folders
- **Domains**: Contains Entities, Value Objects, and business rules.
- **Infrastructure**: Contains Repositories, Middleware, and classes connecting to external systems.
- **Presentation**: Contains API controllers and console commands.
- **Config**: Contains configuration files for each module.


## Usage
### 1. Create a New Module
To create a new module, use the following command:
```bash
php artisan make:module ModuleName
```
### 2. Create a New Command
   To create a new command within a module, create a file in the Presentation/Console/Commands directory of that module.

### 3. Define API Routes
   To define API routes for a module, open the Presentation/API/Routes/api.php file and add new routes there.

## Support
If you encounter any issues, please check the Issues section on GitHub or open a new Issue.

## License
MIT License. See the LICENSE file for more details.
```bash
### **How to Use the README.md File**

- **Clone the project:** Provide the clone link for your repository.
- **Environment configuration:** Guide on setting up the `.env` file.
- **Project structure:** Introduce how the project is organized according to DDD.
- **Module creation commands:** Include commands for creating modules and new commands.

Feel free to customize any part of this README to better fit your project's specifics! If you have any other requests, let me know!
```
