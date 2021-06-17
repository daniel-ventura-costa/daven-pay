# DavenPay

Aplicação de uma versão simplificada de uma fintech de processamento de pagamentos.

![alt text](https://github.com/daniel-ventura-costa/daven-pay/blob/main/public/assets/img/logo_completo.png?raw=true)

### Objetivo: PicPay Simplificado

- [x] Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.
- [x] Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.
- [x] Lojistas só recebem transferências, não enviam dinheiro para ninguém.
- [x] Validar se o usuário tem saldo antes da transferência.

- [x] Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6).

- [ ] A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.

- [ ] No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio (http://o4d9z.mocklab.io/notify).

- [ ] Este serviço deve ser RESTFul.

# Requisitos

### O que será avaliado e valorizamos ❤️

- [ ] Documentação
- [ ] Se for para vaga sênior, foque bastante no desenho de arquitetura
- [ ] Código limpo e organizado (nomenclatura, etc)
- [ ] Conhecimento de padrões (PSRs, design patterns, SOLID)
- [ ] Ser consistente e saber argumentar suas escolhas
- [ ] Apresentar soluções que domina
- [ ] Modelagem de Dados
- [ ] Manutenibilidade do Código
- [ ] Tratamento de erros
- [ ] Cuidado com itens de segurança
- [ ] Arquitetura (estruturar o pensamento antes de escrever)
- [ ] Carinho em desacoplar componentes (outras camadas, service, repository)

### O que será um Diferencial

- [x] Uso de Docker
- [ ] Testes de integração
- [ ] Testes unitários
- [ ] Uso de Design Patterns
- [ ] Documentação
- [ ] Proposta de melhoria na arquitetura


## Apontamentos criados

https://www.linkedin.com/jobs/view/2569683651/?eBP=JOB_SEARCH_ORGANIC&recommendedFlavor=IN_NETWORK&refId=VF4RewcHEJfsbZoBtN3BDA%3D%3D&trackingId=dIuuDGvgV00UDuNaYTmsFA%3D%3D&trk=flagship3_search_srp_jobs

- [ ] usar um microframework para o sistema restful
- [ ] Conhecimento dos riscos comuns de segurança (OWASP).
- [ ] usar um  Redis, ElasticSearch
- [ ] https://www.php.net/supported-versions.php (dizer o porque usou php7 ou 8)
- [ ] Design e desenvolvimento de micro serviços horizontalmente escaláveis;
- [ ] Jobs de alto desempenho e comunicação entre serviços utilizando soluções de fila como Kafka;
- [x] Usar o Mysql para os dados em geral
- [ ] Usar o Mongo para guardar os logs da aplicação
- [ ] Utilizar o Swagger para documentar as APIs
- [x] Utilizar um uuid em vez do id no exemplo de payload
- [ ] Mostrar o historico dos commits, pequenos commits, de maneira frequente
- [ ] Colocar Softdelete e citar o marco civil da internet
- [x] Usar JWT (segurança)
- [ ] mudar o modo de payment na transaction de id para um hash ou algo que não permita o usuario incrementar, pois assim ele descobriria quantos usuarios existem no sistema.
- [x] Explicar por que campo cpf e cnpj, por que o sistema deve tratar isso, e o banco deve ser muito claro e transparente quanto ao dado que ele hospeda naquele campo

### Modelagem do banco de dados

![alt text](https://github.com/daniel-ventura-costa/daven-pay/blob/main/public/assets/img/modelagem_banco_de_dados.jpg?raw=true)

### Modelagem da infra-estrutura

![alt text](https://github.com/daniel-ventura-costa/daven-pay/blob/main/public/assets/img/modelagem_infra.jpg?raw=true)