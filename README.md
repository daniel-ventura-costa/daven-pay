![alt text](https://github.com/daniel-ventura-costa/daven-pay/blob/main/public/assets/img/logo_completo.png?raw=true)

# DavenPay
Aplicação de uma versão simplificada de uma fintech brasileira ;)

## Objetivos da fintech DavenPay
- [x] Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.
- [x] Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.
- [x] Lojistas só recebem transferências, não enviam dinheiro para ninguém.
- [x] Validar se o usuário tem saldo antes da transferência.
- [x] Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6).
- [x] A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.
- [ ] No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio (http://o4d9z.mocklab.io/notify).
- [x] Este serviço deve ser RESTFul.

# Requisitos

## O que será avaliado e valorizamos ❤️

- [ ] Documentação
- [ ] Se for para vaga sênior, foque bastante no desenho de arquitetura
- [x] Código limpo e organizado (nomenclatura, etc)
- [x] Conhecimento de padrões (PSRs, design patterns, SOLID)
- [ ] Ser consistente e saber argumentar suas escolhas
- [ ] Apresentar soluções que domina
- [x] Modelagem de dados
- [ ] Manutenibilidade do código
- [x] Tratamento de erros
- [x] Cuidado com itens de segurança
- [x] Arquitetura (estruturar o pensamento antes de escrever)
- [ ] Carinho em desacoplar componentes (outras camadas, service, repository)

## O que será um diferencial

- [x] Uso de Docker
- [ ] Testes de integração
- [x] Testes unitários
- [x] Uso de Design Patterns
- [x] Documentação (Swagger)
- [x] Proposta de melhoria na arquitetura


## Apontamentos criados

- [x] Usar um microframework para o sistema restful (LUMEN)
- [x] Conhecimento dos riscos comuns de segurança (OWASP)
- [ ] https://www.php.net/supported-versions.php (dizer o porque usou php7 ou 8)
- [ ] Design e desenvolvimento de micro serviços horizontalmente escaláveis;
- [x] Jobs de alto desempenho e comunicação entre serviços utilizando soluções de fila como Kafka;
- [x] Usar o Mysql para os dados em geral
- [x] Usar Redis como banco de dados para armazenar os jobs (emails, sms)
- [x] Utilizar o Swagger para documentar as APIs
- [x] Mostrar o historico dos commits, pequenos commits, de maneira frequente
- [x] Explicar por que campo cpf e cnpj, por que o sistema deve tratar isso, e o banco deve ser muito claro e transparente quanto ao dado que ele hospeda naquele campo

## Proposta de melhoria na arquitetura
- [x] Utilizar UUID em vez do id como no exemplo de payload, algo que não permita um atacante incrementar o número.
- [x] Usar JWT para autenticação (segurança)
- [x] Colocar SoftDelete e citar o marco civil da internet

## Adicione estas entradas no seu arquivo de hosts


## Rodando códigos de analise estática
```
docker run -it --rm -v ${pwd}:/project -w /project jakzal/phpqa phpmd app html cleancode,codesize,controversial,design,naming,unusedcode --reportfile phpmd.html
docker run -it --rm -v ${pwd}:/project -w /project jakzal/phpqa phpstan analyse --level 1 app
```
## Realizar o migrate das tabelas e popular com registros
```
docker exec -it instancia01-davenpay php artisan migrate:refresh
docker exec -it instancia01-davenpay php artisan db:seed
```
## Gera a cobertura de código e testa a aplicação
```
vendor/bin/phpunit --testdox-html ./reports/testdox.html
vendor/bin/phpunit --coverage-html ./reports/coverage
```

## Modelagem do banco de dados

![alt text](https://github.com/daniel-ventura-costa/daven-pay/blob/main/public/assets/img/modelagem_banco_de_dados_1.jpg?raw=true)

## Diagrama da infra-estrutura em Docker

![alt text](https://github.com/daniel-ventura-costa/daven-pay/blob/main/public/assets/img/modelagem_infra_1.jpg?raw=true)