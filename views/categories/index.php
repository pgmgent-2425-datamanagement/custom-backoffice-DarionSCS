<h1 class="text-2xl font-bold mb-4"><?php echo $title; ?></h1>

<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        <?php foreach ($categories as $category): ?>
        <tr>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($category->id); ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($category->category_name); ?></td>
            <td class="px-6 py-4 whitespace-nowrap">
                <a href="/categories/edit/<?php echo $category->id; ?>" class="text-blue-500 hover:underline mr-4">Edit</a>
                <form action="/categories/delete/<?php echo $category->id; ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="mt-8">
    <a href="/categories/create" class="text-white bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded">Add New Category</a>
</div>
