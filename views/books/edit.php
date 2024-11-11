<h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($title); ?></h1>

<form action="/books/edit/<?php echo $book->id; ?>" method="POST" class="space-y-4">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($book->title); ?>" required class="mt-1 block w-full border-gray-300">
    </div>

    <div>
        <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
        <input type="text" name="isbn" id="isbn" value="<?php echo htmlspecialchars($book->isbn); ?>" required class="mt-1 block w-full border-gray-300">
    </div>

    <div>
        <label for="publication_year" class="block text-sm font-medium text-gray-700">Publication Year</label>
        <input type="number" name="publication_year" id="publication_year" value="<?php echo htmlspecialchars($book->publication_year); ?>" required class="mt-1 block w-full border-gray-300">
    </div>

    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
        <select name="category_id" id="category_id" required class="mt-1 block w-full border-gray-300">
            <option value="">Select a category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->id; ?>" <?php echo $category->id == $book->category_id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category->category_name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="authors" class="block text-sm font-medium text-gray-700">Authors</label>
        <select name="authors[]" id="authors" multiple class="mt-1 block w-full border-gray-300">
            <?php foreach ($authors as $author): ?>
                <option value="<?php echo $author->id; ?>" 
                    <?php echo in_array($author->id, $linkedAuthors) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($author->first_name . ' ' . $author->last_name); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small>Select one or more authors</small>
    </div>


    <div>
        <label for="publisher_id" class="block text-sm font-medium text-gray-700">Publisher</label>
        <select name="publisher_id" id="publisher_id" required class="mt-1 block w-full border-gray-300">
            <option value="">Select a publisher</option>
            <?php foreach ($publishers as $publisher): ?>
                <option value="<?php echo $publisher->id; ?>" <?php echo $publisher->id == $book->publisher_id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($publisher->publisher_name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    

    <div class="mt-6">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-bold rounded">Update Book</button>
    </div>
</form>

<div class="mt-4">
    <a href="/books" class="text-blue-500">Back to Books List</a>
</div>
