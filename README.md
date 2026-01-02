# 🛒 Microsserviço de Catálogo de Supermercado

Este projeto é um microsserviço containerizado desenvolvido para o gerenciamento de produtos de um supermercado. Ele demonstra a aplicação prática de Docker e Docker Compose para criar um ambiente de desenvolvimento isolado, seguro e escalável.

## 🚀 Tecnologias Utilizadas

*   **PHP 8.2 + Apache**: Backend e Frontend da aplicação.
*   **MySQL 5.7**: Banco de dados para persistência dos produtos.
*   **Docker & Docker Compose**: Orquestração dos containers.
*   **HTML/CSS**: Interface gráfica para gerenciamento.

## 📋 Funcionalidades Implementadas

1.  **CRUD de Produtos**:
    *   Cadastro de novos produtos (Nome, Categoria, Preço, Fornecedor).
    *   Listagem de estoque em tempo real.
    *   Exclusão de registros.
2.  **Segurança**:
    *   Uso de *Prepared Statements* no PHP para prevenção de SQL Injection.
    *   Credenciais de banco de dados isoladas via variáveis de ambiente (`.env`).
3.  **Infraestrutura**:
    *   Criação automática da tabela de banco de dados na inicialização.
    *   Persistência de dados através de Volumes Docker.
4.  **Interface de Usuário**:
    *   Inclusão de HTML e CSS para melhoria da interface de acesso e usabilidade.

## ⚙️ Como Executar o Projeto

### Pré-requisitos
*   Docker e Docker Compose instalados.

### Passo a Passo

1.  **Clone o repositório** (ou baixe os arquivos).

2.  **Configure as Variáveis de Ambiente**:
    O projeto utiliza um arquivo `.env` para guardar senhas sensíveis. Crie um arquivo `.env` na raiz do projeto baseando-se no exemplo fornecido:
    
    *Linux/Mac:*
    ```bash
    cp .env.example .env
    ```
    *Windows:*
    Copie e cole o arquivo `.env.example` renomeando-o para `.env`.

3.  **Suba os Containers**:
    ```bash
    docker compose up --build
    ```

4.  **Acesse a Aplicação**:
    Abra o navegador em: http://localhost

5. ## 🔗 Links
   [![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/pedropaulosneto/)
