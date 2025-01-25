Olá, estarei documentando nesse arquivo o processo de desenvolvimento da aplicação! 

Inicialmente, as tecnologias escolhidas foram Laravel para salvar os dados, e Blade para o frontend.

O donwload do laravel foi feito utilizando o programa HERD, que pode ser encontrado em: https://herd.laravel.com. Foi criado um repositório Laravel, e o formato de armazenamento de dados escolhido foi o SQLite, devido sua praticidade para o projeto, e também foi utilizado o programa TablePlus para visualização do banco de dados, quando necessário.

Foi construída a primeira tela da aplicação utilizando um template de bootstrap, porém posteriormente, a tela foi mudada completamente, sendo ajustada até o seu resultado final.

Foi integrada a API do ViaCEP, para que fosse possível identificar a cidade utilizando o CEP. Uma vez que a API do ViaCEP estava funcionando, foi a vez de consumir a API WeatherStack, a qual utiliza o nome da cidade para que as buscas sejam feitas.

Após funcionando o retorno das APIs com as informações necessárias, chegou a hora de criar o banco de dados através de uma migration e a lógica para salvar utilizando um Controller.

Com o salvamento funcionando, foi utilizada a tela de Home/Comparação, para ser produzida a tela de histórico, a qual teve sua estilização alterada para que ficasse utilizável.

Estando pronta a aba de históricos, foi a vez de voltar para a página de Home, para que fosse possível criar a ferramenta de comparação de climas, foi criado um botão para adicionar um novo modal de busca.

Com tudo finalizado, a aplicação foi testada por terceiros, e aprovada!

Segue abaixo um exemplo de como ela funciona:

![Gif demonstrando o funcionamento da aplicação](https://i.imgur.com/0mrjYqT.gif)

Você também pode ter essa ferramenta de comparação de datas em sua máquina, basta:
<li> Criar uma conta gratuita na API WeatherStack; </li>
<li> Fazer o donwload do laravel utilizando o HERD; </li>
<li> Clonar este repositório em sua máquina; </li>
<li> No caminho resources/views/home.blade.php, na linha 125, você deve colocar seu Token da Api WeatherStack; </li>
<li> Abra seu localhost utilizando o link <b>"nome_do_seu_repositorio".test</b>; </li>
<li> Se divirta descobrindo o tempo de várias cidades! </li>
