# Jogo - Encontre os Erros

<div align="center">

**CRUD de Usuários - Identificação e Correção de Erros**

</div>

---

## Informações

- **Discente:** Isabella Balas Rech
- **Docente:** Ícaro Caldeira Botelho

---

## Sobre o Projeto

Este projeto consiste em um CRUD (Create, Read, Update, Delete) básico de usuários desenvolvido em PHP com MySQL. O objetivo é identificar e corrigir erros de **sintaxe**, **execução** e **segurança**.

---

## Erros Encontrados em P1

### Síntaxe e Execução (3 erros)

| # | Erro | Linha | Descrição | Solução |
|---|------|-------|-----------|---------|
| 1️ | Falta de ponto e vírgula | 57 | `$stmt->bind_param()` sem `;` | Adicionar `;` ao final |
| 2️ | Falta de ponto e vírgula | 62 | `$conn->query()` sem `;` | Adicionar `;` ao final |
| 3️ | Falta de validação | 111 | `while()` sem verificar se query falhou | Adicionar `if ($resultado) { }` |

### Segurança (1 erro)

| # | Erro | Linha | Descrição | Solução |
|---|------|-------|-----------|---------|
| | CSRF + Validação inadequada | 30-44 | Exclusão via GET sem token CSRF | Mudar para POST com token CSRF + validar ID |

---

## Erros Encontrados em P2

### Validação de Entrada (3 erros)

| # | Erro | Linha | Descrição | Solução |
|---|------|-------|-----------|---------|
| 1️ | Campos vazios - Cadastro | 29-30 | Nome e email podem ser vazios | Validar com `empty()` e `trim()` |
| 2️ | Campos vazios - Edição | 68-70 | ID, nome e email sem validação | Validar ID com `filter_var()` e campos com `empty()` |
| 3️ | XSS (Cross-Site Scripting) | 152, 157 | Dados exibidos sem sanitização | Usar `htmlspecialchars()` |

---

## Status das Correções

### P1 - cod.php
- Erro 1: Ponto e vírgula no `bind_param`
- Erro 2: Ponto e vírgula no `query`
- Erro 3: Validação do resultado da query
- Erro 4 (Segurança): Proteção CSRF e validação de ID

### P2 - cod.php
- Erro 1: Validação de campos vazios no cadastro
- Erro 2: Validação de campos e ID na edição
- Erro 3: Sanitização com `htmlspecialchars()` contra XSS

---

## Tecnologias Utilizadas

- ![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)
- ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)
- ![HTML5](https://img.shields.io/badge/HTML5-E34C26?style=flat&logo=html5&logoColor=white)


<div align="center">

</div>
