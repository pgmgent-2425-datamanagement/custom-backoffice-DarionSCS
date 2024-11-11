<h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($title); ?></h1>

<form action="/categories/edit/<?php echo $category->id; ?>" method="POST" class="space-y-4">
    <div>
        <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
        <input type="text" name="category_name" id="category_name" value="<?php echo htmlspecialchars($category->category_name); ?>" required class="mt-1 block w-full border-gray-300">
    </div>

    <div class="mt-6">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-bold rounded">Update Category</button>
    </div>
</form>

<div class="mt-4">
    <a href="/categories" class="text-blue-500">Back to Categories List</a>
</div>
