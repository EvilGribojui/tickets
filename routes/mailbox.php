<?php

use Illuminate\Support\Facades\Route;

Route::get('/mailbox', function () {
    return view('mailbox.index');
});

Route::get('/mailbox/{id}', function ($id) {
    // Логика для отображения конкретного письма
    return view('mailbox.show', ['id' => $id]);
});

