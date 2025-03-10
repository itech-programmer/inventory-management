<?php

namespace App\Repositories;

use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll(): Collection
    {
        return Category::with(['provider:id,name'])
        ->get(['id', 'name', 'parent_id', 'provider_id']);
    }

    public function findById(int $id): ?Category
    {
        return Category::with('provider')->find($id);
    }

    public function getSubcategories(int $categoryId): Collection
    {
        return Category::where('parent_id', $categoryId)->get();
    }

    public function getByProvider(int $providerId): Collection
    {
        return Category::where('provider_id', $providerId)->get();
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(int $id, array $data): ?Category
    {
        $category = Category::find($id);
        if ($category) {
            $category->update($data);
        }
        return $category;
    }

    public function delete(int $id): bool
    {
        return Category::destroy($id) > 0;
    }
}
