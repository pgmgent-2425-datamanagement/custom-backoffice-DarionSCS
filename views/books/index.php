<h1 class="text-2xl font-bold mb-4"><?php echo $title; ?></h1>

<form method="GET" action="/books" class="mb-4">
    <div class="flex space-x-4">
        <!-- Category Filter -->
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category" id="category" class="mt-1 block w-full border-gray-300" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>" 
                        <?php echo $category->id == $selectedCategory ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category->category_name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Author Filter -->
        <div>
            <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
            <input type="text" name="author" id="author" 
                   value="<?php echo isset($authorName) ? htmlspecialchars($authorName) : ''; ?>" 
                   placeholder="Search by author name" 
                   class="mt-1 block w-full border-gray-300">
        </div>

        <!-- Book Name Filter -->
        <div>
            <label for="book_name" class="block text-sm font-medium text-gray-700">Book Name</label>
            <input type="text" name="book_name" id="book_name" 
                   value="<?php echo isset($bookName) ? htmlspecialchars($bookName) : ''; ?>" 
                   placeholder="Search by book name" 
                   class="mt-1 block w-full border-gray-300">
        </div>
        <!-- Sort Options -->
                <div>
            <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
            <select name="sort" id="sort" class="mt-1 block w-full border-gray-300" onchange="this.form.submit()">
                <option value="">Default</option>
                <option value="title_asc" <?php echo isset($sort) && $sort == 'title_asc' ? 'selected' : ''; ?>>Title (A-Z)</option>
                <option value="title_desc" <?php echo isset($sort) && $sort == 'title_desc' ? 'selected' : ''; ?>>Title (Z-A)</option>
                <option value="year_asc" <?php echo isset($sort) && $sort == 'year_asc' ? 'selected' : ''; ?>>Publication Year (Oldest)</option>
                <option value="year_desc" <?php echo isset($sort) && $sort == 'year_desc' ? 'selected' : ''; ?>>Publication Year (Newest)</option>
                <option value="id_asc" <?php echo isset($sort) && $sort == 'id_asc' ? 'selected' : ''; ?>>ID (Ascending)</option>
                <option value="id_desc" <?php echo isset($sort) && $sort == 'id_desc' ? 'selected' : ''; ?>>ID (Descending)</option>
            </select>
        </div>

        <div class="hidden">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-bold rounded">Search</button>
        </div>
    </div>
</form>




<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publication Year</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publisher</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Authors</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        <?php foreach($books as $book): ?>
        <tr>
        <td class="px-6 py-4 whitespace-nowrap">
            <?php if ($book->getImage()): ?>
                <img src="<?php echo htmlspecialchars($book->getImage()->image_url); ?>" alt="Cover Image" class="w-16 h-24">
            <?php else: ?>
                <span>No image</span>
            <?php endif; ?>
        </td>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($book->id); ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($book->title); ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($book->isbn); ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($book->publication_year); ?></td>
            <td class="px-6 py-4 whitespace-nowrap">
                <?php echo htmlspecialchars($book->getCategory()->category_name ?? 'Unknown'); ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <?php echo htmlspecialchars($book->getPublisher()->publisher_name ?? 'Unknown'); ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <?php
                    $authors = $book->getAuthors();
                    $authorNames = array_map(function($author) {
                        return htmlspecialchars($author['first_name'] . ' ' . $author['last_name']);
                    }, $authors);
                    echo implode(', ', $authorNames);
                ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <!-- Edit Button -->
                <a href="/books/edit/<?php echo $book->id; ?>" class="text-blue-500 hover:underline mr-4">Edit</a>

                <!-- Delete Form -->
                <form action="/books/delete/<?php echo $book->id; ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this book?');">
                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                </form>
            </td>


        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!-- Pagination Controls -->
<div class="flex items-center justify-between mt-4">
    <?php 
    // Build the query string (slugs)
        $queryParams = http_build_query([
            'category' => $selectedCategory,
            'author' => $authorName,
            'sort' => $sort
        ]); 
    ?>
    <?php if ($page > 1): ?>
        <a href="/books?page=<?php echo $page - 1; ?>&<?php echo $queryParams; ?>" class="text-blue-500">Previous</a>
    <?php endif; ?>

    <div class="flex space-x-2">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/books?page=<?php echo $i; ?>&<?php echo $queryParams; ?>" 
               class="px-3 py-1 border <?php echo $i == $page ? 'bg-blue-500 text-white' : 'text-blue-500'; ?>">
               <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>

    <?php if ($page < $totalPages): ?>
        <a href="/books?page=<?php echo $page + 1; ?>&<?php echo $queryParams; ?>" class="text-blue-500">Next</a>
    <?php endif; ?>
</div>


<div class="mt-8">
    <a href="/books/create" class="text-white bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded">Add New Book</a>
</div>


