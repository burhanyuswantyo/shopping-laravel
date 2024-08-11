<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex flex-col">
          <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
              <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead>
                    <tr>
                      <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No
                      </th>
                      <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Nama
                        Produk
                      </th>
                      <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                        Harga</th>
                      <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                        Kuantiti</th>
                      <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                        Kategori</th>
                      <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Aksi
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200">
                    @forelse ($products as $product)
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                          {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $product->price }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $product->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $product->category->name }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                          <button type="button"
                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                        </td>
                      </tr>
                    @empty
                    @endforelse

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="p-4">
          {{ $products->links() }}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
