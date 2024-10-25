<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container {
            max-width: 80%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Usuários</h2>

        <div class="text-end mb-4">
            <a href="/create-user" class="btn btn-primary">Novo Usuário</a>
        </div>

        <!-- Filtros de Nome e Situação -->
        <div class="row mb-4">
            <div class="col-md-3">
                <input type="text" id="filter-name" class="form-control" placeholder="Buscar por Nome">
            </div>
            <div class="col-md-2">
                <select id="filter-situacao" class="form-select">
                    <option value="">Todos</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>
            <div class="col-md-1">
                <button id="filter-btn" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>

        <!-- Tabela de Usuários -->
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Situação</th>
                    <th>Data de Admissão</th>
                    <th>Data de Cadastro</th>
                    <th>Última Atualização</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['situacao']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($user['data_admissao'])); ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($user['created_at'])); ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($user['updated_at'])); ?></td>
                            <td>
                                <a href="/edit-user?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $user['id']; ?>">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Nenhum usuário encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            function loadUsers() {
                $.ajax({
                    url: '/users',
                    method: 'GET',
                    success: function (data) {
                        $('#userTable').html(data);
                    }
                });
            }

            // Filtro de nome e situação
            $('#filter-btn').on('click', function() {
                const filterName = $('#filter-name').val().toLowerCase();
                const filterSituacao = $('#filter-situacao').val().toLowerCase();

                $('#userTable tr').each(function() {
                    const name = $(this).find('td:nth-child(2)').text().toLowerCase();
                    const situacao = $(this).find('td:nth-child(4)').text().toLowerCase();

                    let nameMatches = name.includes(filterName);
                    let situacaoMatches = (filterSituacao === "") || (situacao === filterSituacao);

                    if (nameMatches && situacaoMatches) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Evento para o botão de excluir
            $(document).on('click', '.delete-btn', function () {
                const userId = $(this).data('id');
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você não poderá reverter isso!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/delete-user?id=${userId}`;
                    }
                });
            });
        });
    </script>
</body>
</html>
