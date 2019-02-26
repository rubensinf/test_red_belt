# test_red_belt

Teste proposto:

Criação de um CRUD de controle de incidencias.

Propostas atendidas:

- ID único para cada incidente;
- Campos obrigatórios de cadastros validados na classe;
- Status 'Aberto' por default;
- CRUD funcionando para todas as ações;

More infos:

- CRUD desenvolvido utilizando PHP OO;
- Conexão com o banco de dados utilizando PDO;
- Script de autoload de classes;
- Utilização de 'Binds' para INSERT / UPDATE / DELETE
- Metodo setData() para varrer os dados e limpar possíveis códigos maliciosos;
- Filtro de dados feito através de filter_input e filter_input_array
- Front-end desenvolvido com auxilio do Bootstrap 4;
- Banco de dados MySQL (MariaDB)


INSTRUÇÕES:

Alterar a constante 'BASE' nos arquivos 'index', 'update' e 'new' .php.

define("BASE", "your_env_address");

db name: 'rb_test'

Dump da base gzipado na pasta 'database' 
