# jdcook-symfony1

## Api-Platform
1. Run `docker compose build cli; docker compose up -d --build; docker compose exec web bash`
2. Run `./bin/console doctrine:migration:migrate` and choose `yes`.
3. Run `./bin/console doctrine:fixtures:load` and type `yes`.
4. Browse to http://localhost:8010/api and http://localhost:8010/api/graphql
