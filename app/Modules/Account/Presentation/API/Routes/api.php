<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Account\Presentation\API\Controllers\AccountController;

// Định nghĩa các route cho module {{ moduleName }}
Route::prefix('accounts')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('{{ name_lower }}.index');
});
