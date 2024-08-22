<div>
    <section class="bg-gray-200 py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-gray-800">Bem-vindo à nossa loja de roupas!</h2>
            <p class="mt-4 text-gray-600">Confira nossas últimas coleções e ofertas especiais.</p>
            <a href="#" class="mt-6 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Ver Produtos</a>
        </div>
    </section>

    {{--    <section class="py-12">--}}
    {{--        <div class="container mx-auto px-4">--}}
    {{--            <h2 class="text-3xl font-bold text-gray-800 mb-8">Categorias</h2>--}}
    {{--            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">--}}
    {{--                @foreach($categories->take(3) as $category)--}}
    {{--                    <div class="bg-white p-6 rounded-lg shadow">--}}
    {{--                        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-48 object-cover rounded-t-lg">--}}
    {{--                        <h3 class="mt-4 text-xl font-bold text-gray-800">{{ $category->name }}</h3>--}}
    {{--                    </div>--}}
    {{--                @endforeach--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}

    <section class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Produtos em Destaque</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <img src="produto1.jpg" alt="Produto 1" class="w-full h-48 object-cover rounded-t-lg">
                    <h3 class="mt-4 text-xl font-bold text-gray-800">Produto 1</h3>
                    <p class="mt-2 text-gray-600">R$ 99,90</p>
                    <a href="#" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Comprar</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <img src="produto2.jpg" alt="Produto 2" class="w-full h-48 object-cover rounded-t-lg">
                    <h3 class="mt-4 text-xl font-bold text-gray-800">Produto 2</h3>
                    <p class="mt-2 text-gray-600">R$ 149,90</p>
                    <a href="#" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Comprar</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <img src="produto3.jpg" alt="Produto 3" class="w-full h-48 object-cover rounded-t-lg">
                    <h3 class="mt-4 text-xl font-bold text-gray-800">Produto 3</h3>
                    <p class="mt-2 text-gray-600">R$ 79,90</p>
                    <a href="#" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Comprar</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <img src="produto4.jpg" alt="Produto 4" class="w-full h-48 object-cover rounded-t-lg">
                    <h3 class="mt-4 text-xl font-bold text-gray-800">Produto 4</h3>
                    <p class="mt-2 text-gray-600">R$ 129,90</p>
                    <a href="#" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Comprar</a>
                </div>
            </div>
        </div>
    </section>
</div>

