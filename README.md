
# # sistema-usuarios
Este projeto consiste em uma API backend desenvolvida em PHP, e um frontend em JavaScript. Utiliza MySQL como sistema de banco de dados, com Docker e Docker Compose para simplificar a configuração e a execução do ambiente de desenvolvimento.

## Requisitos

- Docker
- Docker Compose

## Configuração do Ambiente

### Clonando o Repositório

```bash
git clone https://github.com/Deividdasilva/php-docker.git
cd php-docker
```

### Iniciando os Containers

Utilize o Docker Compose para iniciar os containers:

```bash
docker-compose up -d
```

### Acessando a Aplicação

- **Projeto**: [http://localhost:8000](http://localhost:8000)
- **Banco de Dados**: [http://localhost:8080](http://localhost:8080)

## Estrutura do Projeto

- `php-docker/api`: Código-fonte do projeto no modelo MVC.
- `php-docker/docker-compose.yml`: Arquivos de configuração para Docker e Docker Compose.