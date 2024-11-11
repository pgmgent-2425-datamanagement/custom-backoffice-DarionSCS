<h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($title); ?></h1>

<form action="/authors/edit/<?php echo $author->id; ?>" method="POST" class="space-y-4">
    <div>
        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($author->first_name); ?>" required class="mt-1 block w-full border-gray-300">
    </div>

    <div>
        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($author->last_name); ?>" required class="mt-1 block w-full border-gray-300">
    </div>

    <div>
        <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
        <textarea name="bio" id="bio" class="mt-1 block w-full border-gray-300"><?php echo htmlspecialchars($author->bio); ?></textarea>
    </div>

    <div class="mt-6">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-bold rounded">Update Author</button>
    </div>
</form>

<div class="mt-4">
    <a href="/authors" class="text-blue-500">Back to Authors List</a>
</div>
