# Protótipo do projeto BioJapi
A idéia do projeto era fazer uma rede social focada em ciência cidadã, inspirado em sites como o WikiAves. 
> O objetivo é um cidadão publicar um registro de alguma espécie da Serra do Japi, e identificar a espécie, com validação de especialistas. Além disso, os usuários poderiam ver os posts uns dos outros, e interagirem de acordo para gerar um incentivo para a população se adentrar na área, e ajudar na categorização de espécies da serra.

## Sistemas feitos:
- Criação de conta, login e recuperação de senha;
- Publicação e exclusão de posts;
- Publicação, edição e exclusão de comentários;
- Edição de perfil;
- Ferramenta de busca por categoria de espécies (mamífero, ave, etc.), por nome popular, nome científico, e por usuário.
## Sistemas que faltaram ser feitos nesse protótipo:
- Adição de especialistas, juntamente de suas funcionalidades;
- Adição de espécies;
- Adição de administradores, junto de suas funcionalidades;
- Sistema para baixar um relatório dos posts feitos.
---
No geral, nosso foco foi em garantir uma boa experiência como rede social, para só então focarmos em outros detalhes, como especialistas.

Utilizamos a biblioteca [Dotenv](https://github.com/vlucas/phpdotenv), e [Resend](https://resend.com/emails) para o PHP, e usamos a [Leaflet](https://leafletjs.com/) para a criação de mapas interativos via JS de forma gratuita.
