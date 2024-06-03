<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $model["title"] ?? "" ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <script src="https://kit.fontawesome.com/1659def098.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="grid min-h-screen overflow-hidden lg:grid-cols-[280px_1fr] border-2 border-slate-200">
        <aside class="bg-slate-100 border-2 border-slate-200">
            <div class="flex flex-column content-center items-center">
                <a href="/admin" class="text-xl font-medium px-8 py-4">FurniTuu. Dashboard</a>
            </div>
            <hr>
            <div class="flex flex-col mx-5 mt-5 bg-slate-100 gap-2 text-sm text-slate-400">
                <div class="flex gap-3 items-center hover:bg-slate-200 hover:text-slate-900 p-2 rounded-md">
                    <i class="fa-solid fa-house"></i>
                    <a href="/" class="flex gap-2 w-full pr-5 ">Home</a>
                </div>
                <div class="flex gap-3 items-center bg-slate-200 hover:text-slate-900 hover:bg-slate-100 p-2 rounded-md">
                    <i class="fa-solid fa-folder-open"></i>
                    <a href="" class="flex gap-2 w-full pr-5">Products</a>
                </div>
                <div class="flex gap-3 items-center hover:bg-slate-200 hover:text-slate-900 p-2 rounded-md">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <a href="" class="flex gap-2 w-full pr-5">Orders</a>
                </div>
                <div class="flex gap-3 items-center hover:bg-slate-200 hover:text-slate-900 p-2 rounded-md">
                    <i class="fa-solid fa-gears"></i>
                    <a href="" class="flex gap-2 w-full pr-5">Setting</a>
                </div>
                <div class="flex gap-3 items-center hover:bg-slate-200 hover:text-slate-900 p-2 rounded-md">
                    <i class="fa-solid fa-door-open"></i>
                    <a href="/users/logout" class="flex gap-2 w-full pr-5">Logout</a>
                </div>
            </div>
        </aside>
        <div class="bg-slate-50 w-full text-xl items-center font-bold">
            <h1 class="bg-slate-100 px-8 py-4">Hello, <?= $model["user"] ?? "Admin" ?>!</h1>
            <hr>
            <div>
                <form action="/admin" method="post" class="mx-10">
                    <div class="space-y-12">
                      <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                          <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                          <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                              <input type="text" name="name" id="name" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Kruzo Aero">
                            </div>
                          </div>
                        </div>
                        <div class="sm:col-span-4">
                          <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                          <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                              <input type="number" name="price" id="price" autocomplete="price" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" style="-webkit-appearance: none" placeholder="1000000">
                            </div>
                          </div>
                        </div>
                        <div class="sm:col-span-4">
                          <label for="image" class="block text-sm font-medium leading-6 text-gray-900">Image</label>
                          <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                              <input type="text" name="image" id="image" autocomplete="image" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="kruzo_ero.png">
                            </div>
                          </div>
                        </div>
                    </div>
                  
                    <div class="flex items-center justify-start gap-x-4">
                      <button type="button" class="text-sm font-semibold leading-6 bg-slate-50 text-gray-900" onclick="resetFormInputs()" >Cancel</button>
                      <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                    </div>
                </form>
            </div>
            <div class="my-8 mx-10">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
                    <div class="relative w-full overflow-auto">
                      <table class="w-full caption-bottom text-sm">
                        <thead class="[&amp;_tr]:border-b">
                          <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 w-[100px]">
                              No
                            </th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                              Nama
                            </th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                              Harga
                            </th>
                            <th class="h-12 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                                Image
                            </th>
                          </tr>
                        </thead>
                        <tbody class="[&amp;_tr:last-child]:border-0">
                        <?php $no = 1; ?>
                        <?php foreach ($model["products"] as $product) { ?>
                          <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-medium"><?= $no++ ?></td>
                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0"><?= $product->name ?></td>
                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">Rp <?= $product->price ?></td>
                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 text-right">
                                <img src="/assets/imgs/<?= $product->image ?>"
                                     alt="<?= $product->image ?>"
                                     class="w-20 min-w-20 max-w-28"
                                >
                            </td>
                          </tr>
                        <?php } ?>

                        </tbody>
                      </table>
                    </div>
                  </div>
            </div>
        </div>
    </div>

    <script>
        function resetFormInputs() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
            });
        }
    </script>
</body>
</html>