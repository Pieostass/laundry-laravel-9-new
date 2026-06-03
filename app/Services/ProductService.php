<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function findAll(): Collection
    {
        return Product::with('category')->get();
    }

    public function findById(int $id): Product
    {
        return Product::with('category')->findOrFail($id);
    }

    public function findAllActivePaged(int $perPage = 12): LengthAwarePaginator
    {
        return Product::with('category')
            ->active()
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function findByCategoryIdPaged(int $categoryId, int $perPage = 12): LengthAwarePaginator
    {
        return Product::with('category')
            ->active()
            ->where('category_id', $categoryId)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function searchByName(string $keyword, int $perPage = 12): LengthAwarePaginator
    {
        return Product::with('category')
            ->active()
            ->where('name', 'like', "%{$keyword}%")
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function searchProducts(?string $keyword, ?int $categoryId, int $perPage = 10): LengthAwarePaginator
    {
        return Product::with('category')
            ->when($keyword, fn($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function findAllCategories(): Collection
    {
        return Category::orderBy('name')->get();
    }

    public function countActive(): int
    {
        return Product::where('active', true)->count();
    }

    public function save(array $data, ?UploadedFile $image = null): Product
    {
        if ($image) {
            $data['image_url'] = $this->storeImage($image);
        }

        return Product::create([
            'name'           => $data['name'],
            'description'    => $data['description'] ?? null,
            'price'          => $data['price'],
            'stock_quantity' => $data['stock_quantity'],
            'image_url'      => $data['image_url'] ?? null,
            'category_id'    => $data['category_id'],
            'active'         => true,
        ]);
    }

    public function update(int $id, array $data, ?UploadedFile $image = null): Product
    {
        $product = $this->findById($id);

        if ($image) {
            if ($product->image_url && !str_starts_with($product->image_url, 'http')) {
                $oldPath = public_path($product->image_url);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['image_url'] = $this->storeImage($image);
        }

        $product->update([
            'name'           => $data['name'],
            'description'    => $data['description'] ?? null,
            'price'          => $data['price'],
            'stock_quantity' => $data['stock_quantity'],
            'image_url'      => $data['image_url'] ?? $product->image_url,
            'category_id'    => $data['category_id'],
        ]);

        return $product->fresh('category');
    }

    public function deactivate(int $id): void
    {
        $this->findById($id)->update(['active' => false]);
    }

    // ✅ Thêm mới: Ẩn/Hiện sản phẩm
    public function toggleActive(int $id): void
    {
        $product = $this->findById($id);
        $product->update(['active' => !$product->active]);
    }

    // ✅ Thêm mới: Xóa hẳn khỏi DB
    public function delete(int $id): void
    {
        $product = $this->findById($id);

        if ($product->image_url && !str_starts_with($product->image_url, 'http')) {
            $oldPath = public_path($product->image_url);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $product->delete();
    }

    private function storeImage(UploadedFile $file): string
    {
        $filename  = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $directory = '/home/anhnguyen/domains/globalmart24.com/public_html/uploads/products';

        $file->move($directory, $filename);

        return 'uploads/products/' . $filename;
    }
}