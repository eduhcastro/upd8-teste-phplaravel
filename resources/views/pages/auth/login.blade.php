<x-layouts.app title="Projeto">

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

        <div class="max-w-7xl mx-auto p-6 lg:p-8 bg-white rounded-lg shadow-lg" style="width: 370px;">
            <div class="mt-8">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/UDP8.png') }}" class="h-16 w-auto bg-gray-100 dark:bg-gray-900"
                        width="300px">
                </div>
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf
                    <div class="mb-4" style="display: flex;">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username"
                            style="margin-top: 10px;margin-right: 10px;">Usuario</label>
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="username" name="username" type="text" placeholder="Username" value="admin">
                    </div>

                    <div class="mb-4" style="display: flex;margin-top: 11px;">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password"
                            style="margin-top: 10px;margin-right: 20px;">Senha</label>
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="password" name="password" type="password" value="12345">
                    </div>
                    <div class="md:flex md:items-center" style="margin-top: 15px;">
                        <div class="md:w-1/3"></div>
                        <div class="">
                            <button type="button"
                                id="login"
                                class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                                style="width: 310px;background: #35a2db;">
                                Entrar
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    
    </div>
</x-layouts.app>
