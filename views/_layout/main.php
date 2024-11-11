<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= ($title ?? '') . ' ' . $_ENV['SITE_NAME'] ?></title>
    <link rel="stylesheet" href="/css/main.css?v=
    <?php if( $_ENV['DEV_MODE'] == "true" ) { echo time(); }; ?>
    ">
  </head>
  <body class="bg-gray-100 flex flex-col min-h-screen">
  <!-- Navbar -->
  <header class="bg-gray-800 text-gray-100 shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <div class="text-xl font-semibold">BrandName</div>
      <nav class="space-x-6">
        <a href="/" class="hover:text-gray-300">Home</a>
        <a href="#" class="hover:text-gray-300">Item 2</a>
        <a href="#" class="hover:text-gray-300">Item 3</a>
        <a href="#" class="hover:text-gray-300">Item 4</a>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow container mx-auto p-6">
    <?= $content; ?>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-800 text-gray-400 py-4">
    <div class="container mx-auto text-center">
      &copy; <?= date('Y'); ?> - BrandName
    </div>
  </footer>
</body>

</html>
