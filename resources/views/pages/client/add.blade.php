<x-layouts.app title="Adicionar Cliente">
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <img src="{{ asset('images/UDP8.png') }}" class="h-16 w-auto bg-gray-100 dark:bg-gray-900" width="300px">
            </div>

          <x-layouts.partials.nav/>

            <div class="mt-16" style="margin-top: 10px;">
                <div class="grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <div
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">
                                Cadastro Cliente
                            </h2>
                            <div class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                <div class="w-full max-w-lg">
                                    @csrf
                                    <div class="flex flex-wrap -mx-3 mb-6"
                                        style="display: grid;grid-template-columns: auto auto auto auto;">
                                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"
                                            style="width: 220px;display: flex;margin-right: 10px;">
                                            <label
                                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                                for="cpf" style="margin-right: 10px;margin-top: 8px;">CPF</label>
                                            <input
                                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                                id="cpf" name="cpf" type="text"
                                                placeholder="000.000.000-00" style="width: 100%;height: 35px;">
                                        </div>

                                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"
                                            style="width: 300px;display: flex;margin-right: 10px;">
                                            <label
                                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                                for="nome" style="margin-right: 10px;margin-top: 8px;">Nome</label>
                                            <input
                                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                                id="nome" name="nome" type="text" placeholder="Jane"
                                                style="width: 100%;height: 35px;">
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"
                                            style="width: 100%;display: flex;">
                                            <label
                                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                                for="nascimento" style="margin-right: 10px;margin-top: -3px;">Data
                                                Nascimento</label>
                                            <input
                                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                                id="nascimento" name="nascimento" type="date" placeholder="Jane"
                                                style="width: 100%;height: 35px;">

                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"
                                            style="width: 200px;display: flex;margin-left: 10px;">
                                            <label
                                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                                for="sexo" style="margin-right: 10px;margin-top: 8px;">Sexo</label>
                                            <div style="display: flex;align-items: center;">

                                                <input type="radio" id="sexo1" name="sexo" value="M">
                                                <label for="sexo1" style="margin-right: 10px;">Masculino</label>
                                                <input type="radio" id="sexo2" name="sexo" value="F">
                                                <label for="sexo2">Feminino</label><br>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3 mb-6"
                                        style="display: grid;grid-template-columns: 40% 25% auto;">
                                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"
                                            style="width: 400px;display: flex;">
                                            <label
                                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                                for="endereco"
                                                style="margin-right: 10px;margin-top: 8px;">Endereço</label>
                                            <input
                                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                                id="endereco" name="endereco" type="text" placeholder="Jane"
                                                style="width: 100%;height: 35px;">

                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"
                                            style="width: 250px;display: flex;">
                                            <label
                                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                                style="margin-right: 10px;margin-top: 8px;">Estado</label>
                                            <select
                                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none"
                                                onchange="carregarCidades()" id="estado" name="estado">
                                                <option>Selecione</option>
                                                <option value="AC">Acre</option>
                                                <option value="AL">Alagoas</option>
                                                <option value="AP">Amapá</option>
                                                <option value="AM">Amazonas</option>
                                                <option value="BA">Bahia</option>
                                                <option value="CE">Ceará</option>
                                                <option value="DF">Distrito Federal</option>
                                                <option value="ES">Espírito Santo</option>
                                                <option value="GO">Goiás</option>
                                                <option value="MA">Maranhão</option>
                                                <option value="MT">Mato Grosso</option>
                                                <option value="MS">Mato Grosso do Sul</option>
                                                <option value="MG">Minas Gerais</option>
                                                <option value="PA">Pará</option>
                                                <option value="PB">Paraíba</option>
                                                <option value="PR">Paraná</option>
                                                <option value="PE">Pernambuco</option>
                                                <option value="PI">Piauí</option>
                                                <option value="RJ">Rio de Janeiro</option>
                                                <option value="RN">Rio Grande do Norte</option>
                                                <option value="RS">Rio Grande do Sul</option>
                                                <option value="RO">Rondônia</option>
                                                <option value="RR">Roraima</option>
                                                <option value="SC">Santa Catarina</option>
                                                <option value="SP">São Paulo</option>
                                                <option value="SE">Sergipe</option>
                                                <option value="TO">Tocantins</option>
                                            </select>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"
                                            style="width: 250px;display: flex;">
                                            <label
                                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                                for="grid-first-name"
                                                style="margin-right: 10px;margin-top: 8px;">Cidade</label>
                                            <select
                                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none"
                                                id="cidade" name="cidade">
                                                <option>Selecione um Estado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <button
                                            id="addClient"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                            style="color: white;background: blue;">Salvar
                                        </button>
                                        <button
                                            id="limpar"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                            style="color: white;background: #b7b7b7;margin-right: 10px;">Limpar
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Cadastre novos
                                clientes!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function formatCPF(cpf) {

            cpf = cpf.replace(/\D/g, '');
            cpf = cpf.slice(0, 11);

            if (cpf.length === 11) {
                cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            } else if (cpf.length === 9) {
                cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})/, '$1.$2.$3');
            } else if (cpf.length === 6) {
                cpf = cpf.replace(/(\d{3})(\d{3})/, '$1.$2');
            }

            return cpf;
        }

        // Exemplo de uso:
        var campoCPF = document.getElementById('cpf');

        campoCPF.addEventListener('input', function() {
            var cpfDigitado = campoCPF.value;
            var cpfFormatado = formatCPF(cpfDigitado);
            campoCPF.value = cpfFormatado;
        });

        function carregarCidades() {
            var estadoSelect = document.getElementById("estado");
            var cidadeSelect = document.getElementById("cidade");

            cidadeSelect.innerHTML = '<option value="">Carregando...</option>';

            if (estadoSelect.value === "") {
                cidadeSelect.innerHTML = '<option value="">Selecione um estado</option>';
                return;
            }

            var estadoId = estadoSelect.value;

            fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios`)
                .then(response => response.json())
                .then(data => {
                    cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';

                    data.forEach(cidade => {
                        var option = document.createElement("option");
                        option.value = cidade.nome;
                        option.text = cidade.nome;
                        cidadeSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.log(error);
                    cidadeSelect.innerHTML = '<option value="">Erro ao carregar cidades</option>';
                });
        }
    </script>
    </x-layout.app>
