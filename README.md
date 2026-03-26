# 🐾 Mais Patinhas

Este repositório contém o código-fonte do projeto **Mais Patinhas**, desenvolvido como Trabalho de Conclusão de Curso (TCC) para a **Universidade de Uberaba (Uniube)**.

## 👥 Integrantes da Equipe
* **Walysson** - RA: 5161362
* **Ruan** - RA: 5161636
* **Leandro** - RA: 5161744

## 💻 Sobre o Projeto
O **Mais Patinhas** é uma plataforma focada na adoção de animais. O sistema visa conectar pessoas que desejam adotar um pet com aquelas que têm animais disponíveis, garantindo segurança e confiabilidade através de um sistema de moderação e avaliações de usuários. 

O design da interface baseia-se em um visual limpo, utilizando fundo branco e a cor primária `#ffbd87`.

## ⚙️ Funcionalidades Principais

### Geral
* **Sistema de Autenticação:** Cadastro e login seguros com seleção de tipo de conta (Usuário Comum, Admin, Desenvolvedor).
* **Cadastro de Animais:** Inserção de dados completos do pet (Nome, Raça, Foto e Idade).
* **Cadastro de Usuários:** Registro contendo Nome, E-mail, Senha, Telefone, Endereço, Status e Cargo.
* **Sistema de Avaliações:** Sistema de nota de 1 a 5 estrelas (modelo semelhante ao da Uber). Os usuários avaliam uns aos outros após as interações, ajudando a identificar se um anunciante ou adotante é confiável.

### 👤 Painel do Usuário Comum
* **Landing Page / Início:** Feed de anúncios de animais disponíveis para adoção.
* **Gerenciamento de Anúncios:** Tela dedicada para criar novos anúncios e editar/excluir os já publicados.
* **Chat Interno:** Mensageria em tempo real para comunicação entre anunciantes e potenciais adotantes.
* **Perfil:** Edição de dados pessoais e visualização da própria reputação (estrelas).

### 🛡️ Painel do Administrador
* **Dashboard Admin:** Visão geral e estatísticas de uso da plataforma.
* **Validação de Anúncios:** Fila de moderação. Os anúncios criados por usuários comuns só ficam públicos após a aprovação de um Administrador.
* **Gerenciamento Global:** Controle total (CRUD) sobre todos os anúncios e usuários cadastrados no sistema.
* **Perfil:** Edição de dados do administrador.

### 👨‍💻 Painel do Desenvolvedor (Programador)
* **Dashboard Dev:** Visão técnica e monitoramento da saúde do sistema.
* **Gerenciamento de Erros:** Tela para recebimento, análise e administração de erros/logs do sistema.
* **Gerenciamento de Usuários:** Acesso técnico às contas cadastradas.
* **Sistema de Doações (Em breve):** Estrutura reservada para futuras implementações de arrecadação para o projeto.
* **Perfil:** Edição de dados do desenvolvedor.

---
*Projeto desenvolvido para fins acadêmicos - Uniube.*
