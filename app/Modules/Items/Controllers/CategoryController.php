<?php

namespace App\Modules\Items\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Items\Models\Category;

class CategoryController extends Controller
{

    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function index()
    {

    }
    public function store() {}
    public function show() {}
    public function update() {}
    public function delete() {}

}