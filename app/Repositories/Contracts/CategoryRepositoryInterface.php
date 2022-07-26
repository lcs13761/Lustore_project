
<?php

namespace App\Repositories\Contracts;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function getCategoryById(int $id);
    public function createCategory(array $data);
    public function updateCategory(Category $category, array $data);
    public function destroyCategory(Category $category);
}
