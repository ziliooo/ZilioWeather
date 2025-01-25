<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zilio's Weather Viewer</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #87CEEB, #f8f9fa);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .container {
            flex: 1;
        }
        .weather-form {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 100%;
            max-width: 300px;
        }
        .form-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .btn {
            border-radius: 25px;
        }
        h1 {
            color: #fff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Zilio's Weather Viewer</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/history">Histórico</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container text-center">
        <h1 class="mb-4">Zilio's Weather Viewer</h1>

        <button id="add-form-btn" class="btn btn-success mb-4">Adicionar Comparação</button>

        <div id="forms-container" class="form-container">
            <div class="weather-form" data-id="1">
                <label for="zipcode-1">CEP:</label>
                <input type="text" id="zipcode-1" class="form-control mb-2" placeholder="Digite o CEP">

                <label for="city-1">Cidade:</label>
                <input type="text" id="city-1" class="form-control mb-2" placeholder="Digite o nome da cidade">

                <button class="search-btn btn btn-primary btn-block" data-id="1">Buscar</button>

                <div id="weather-info-1" class="d-none mt-3">
                    <h4>Clima de <span id="city-name-1"></span></h4>
                        <p><strong>Temperatura:</strong> <span id="temperature-1"></span>°C</p>
                        <p><strong>Descrição:</strong> <span id="description-1"></span></p>
                        <p><strong>Umidade:</strong> <span id="humidity-1"></span>%</p>
                        <p><strong>Pressão atmosférica:</strong> <span id="pressure-1"></span> hPa</p>
                        <p><strong>Vento:</strong> <span id="wind-speed-1"></span> km/h</p>
                        <p><strong>Sensação térmica:</strong> <span id="feels-like-1"></span>°C</p>
                </div>
            </div>
        </div>
    </div>


    <script>
        let formCount = 1; // Contador de formulários

        // Buscar cidade através do CEP usando a API ViaCEP
        $(document).on('blur', '[id^="zipcode-"]', function () {
            const id = $(this).closest('.weather-form').data('id');
            const zipcode = $(`#zipcode-${id}`).val().replace(/\D/g, '');
            if (zipcode.length === 8) { 
                $.getJSON(`https://viacep.com.br/ws/${zipcode}/json/`, function (data) {
                    if (!data.erro) {
                        $(`#city-${id}`).val(data.localidade);
                    } else {
                        alert("CEP não encontrado.");
                    }
                }).fail(function () {
                    alert("Erro ao conectar com o serviço ViaCEP.");
                });
            } else {
                alert("Por favor, insira um CEP válido.");
            }
        });

        // Função para buscar o clima
        function fetchWeather(id) {
            const city = $(`#city-${id}`).val();
            const zipcode = $(`#zipcode-${id}`).val();
            if (!city) {
                alert(`Por favor, informe a cidade no formulário ${id}.`);
                return;
            }

            // Lembre de substituir pela sua chave da API Weatherstack
            const weatherApiKey = 'SEU_TOKEN_AQUI';
            const url = `https://api.weatherstack.com/current?access_key=${weatherApiKey}&query=${encodeURIComponent(city)}`;

            $.getJSON(url, function (data) {
                if (data.success === false || !data.current) {
                    alert(`Erro ao buscar o clima para o formulário ${id}.`);
                } else {
                    const weather = data.current;
                    const temperature = weather.temperature;
                    const description = weather.weather_descriptions[0];
                    const humidity = weather.humidity;
                    const pressure = weather.pressure;
                    const windSpeed = weather.wind_speed;
                    const feelsLike = weather.feelslike;

                    // Atualizar o clima no formulário
                    $(`#city-name-${id}`).text(city);
                    $(`#temperature-${id}`).text(temperature);
                    $(`#description-${id}`).text(description);
                    $(`#humidity-${id}`).text(humidity);
                    $(`#pressure-${id}`).text(pressure);
                    $(`#wind-speed-${id}`).text(windSpeed);
                    $(`#feels-like-${id}`).text(feelsLike);
                    $(`#weather-info-${id}`).removeClass('d-none');

                    // Salvar no histórico
                    saveToHistory(city, zipcode, temperature, description);
                }
            }).fail(function () {
                alert(`Erro ao conectar com a API Weatherstack para o formulário ${id}.`);
            });
        }

        // Salva no histórico
        function saveToHistory(city, zipcode, temperature, description) {
            $.ajax({
                url: '/history',
                method: 'POST',
                data: {
                    city: city,
                    zipcode: zipcode,
                    temperature: temperature,
                    description: description,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log('Histórico salvo:', response.message);
                },
                error: function (xhr) {
                    console.error('Erro ao salvar histórico:', xhr.responseText);
                    alert('Erro ao salvar histórico. Verifique os logs do servidor.');
                }
            });
        }

        $(document).on('click', '.search-btn', function () {
            const id = $(this).data('id');
            fetchWeather(id);
        });

        $('#add-form-btn').on('click', function () {
            formCount++;
            const newForm = `
                <div class="weather-form" data-id="${formCount}">
                    <label for="zipcode-${formCount}">CEP:</label>
                    <input type="text" id="zipcode-${formCount}" class="form-control mb-2" placeholder="Digite o CEP">

                    <label for="city-${formCount}">Cidade:</label>
                    <input type="text" id="city-${formCount}" class="form-control mb-2" placeholder="Digite o nome da cidade">

                    <button class="search-btn btn btn-primary btn-block" data-id="${formCount}">Buscar</button>

                    <!-- Exibição do clima -->
                    <div id="weather-info-${formCount}" class="d-none mt-3">
                        <h4>Clima de <span id="city-name-${formCount}"></span></h4>
                        <p><strong>Temperatura:</strong> <span id="temperature-${formCount}"></span>°C</p>
                        <p><strong>Descrição:</strong> <span id="description-${formCount}"></span></p>
                        <p><strong>Umidade:</strong> <span id="humidity-${formCount}"></span>%</p>
                        <p><strong>Pressão atmosférica:</strong> <span id="pressure-${formCount}"></span> hPa</p>
                        <p><strong>Vento:</strong> <span id="wind-speed-${formCount}"></span> km/h</p>
                        <p><strong>Sensação térmica:</strong> <span id="feels-like-${formCount}"></span>°C</p>
                    </div>
                </div>
            `;
            $('#forms-container').append(newForm);
        });

        // Limpar o campo CEP ao digitar no campo Cidade
        $(document).on('input', '[id^="city-"]', function () {
            const id = $(this).closest('.weather-form').data('id');
            $(`#zipcode-${id}`).val('');
        });
    </script>
</body>
</html>
