<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zilio's Weather Viewer History</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #c673f7, #f8f9fa);
            background-size: 400% 400%;
        }
        @keyframes gradientAnimation {
            0% { background-position: 100% 0%; }
            50% { background-position: 0% 100%; }
            100% { background-position: 100% 0%; }
        }
        .navbar {
            margin-bottom: 20px;
        }
        table {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .icon-tooltip {
            position: relative;
            display: inline-block;
            font-size: 24px;
            cursor: pointer;
        }

        .tooltip {
            visibility: hidden;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.75);
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 5px;
            font-size: 14px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .icon-tooltip:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }

        .header-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-container h1 {
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Zilio's Weather Viewer History</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/history">Histórico</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="header-container">
            <h1 class="text-center">Zilio's Weather Viewer History</h1>
            
            <span class="icon-tooltip">
                &#x1F4A1;
                <span class="tooltip">Esse histórico exibe apenas as últimas 10 consultas realizadas.</span>
            </span>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Cidade</th>
                    <th>CEP</th>
                    <th>Temperatura</th>
                    <th>Descrição</th>
                    <th>Data da Consulta</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($history->city); ?></td>
                        <td><?php echo e($history->zipcode); ?></td>
                        <td><?php echo e($history->temperature); ?>°C</td>
                        <td><?php echo e($history->description); ?></td>
                        <td><?php echo e($history->created_at->format('d/m/Y H:i')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma consulta registrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Gabriel Zilio\Herd\weather\resources\views/history.blade.php ENDPATH**/ ?>