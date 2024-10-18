## Dashboard Power BI com Laravel
Esse projeto é um sistema de acompanhamento de estoque feito para a empresa Orbit com parceria com a Univesp para o projeto integrador 2.

### Funcionalidades
- Cadastros de: Unidades de Medidas, Dias da Semana trabalhados, Plantas, Tanques e Dados de consumos dos tanques
- Leitura de gráficos dinamicos para acompanhamento do estoque

### Requisitos
- Docker
- Laravel
- Node

### Instalação

#### Clone o repositório:
```bash
git clone git@github.com:txrangel/projetointegrador2.git
cd projetointegrador2
```

#### Rodar as migrações:
```bash
./vendor/bin/sail artisan migrate
```
#### Iniciar o servidor:

```bash
./vendor/bin/sail up
```

```bash
composer update
npm install
npm run dev
```

### Melhorias Futuras
- Arrumar os requests das alterações para ignorar o id do objeto editado
- Criar factorys e seeders automaticos das tabelas
- Criar testes automatizados
- Ajustar os retornos para serem em um alert e nao um json
- Demonstrar grafico de estoque por tempo