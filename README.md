# Coding challenge - Analytics dashboard 
All the steps were taken based on following:

#### Installing Symfony 5
This step has been taken based on symfony regular installation document.

##### Preparing docker environment
a `docker` directory is created in root directory of project and all of configuration files are located there.
for starting the project, you need to run next command:

`bash build.sh`

and for destroying all those dockers, you can just run next command:

`bash destroy.sh`

##### Create Entities
Two required entities were created including their related repositories.
The entities:
- Hotel
- Review

you should execute following command to run database migration on your docker machine:

`cd docker`<br/>
`docker-compose exec php php bin/console make:migration`<br/>
`docker-compose exec php php bin/console doctrine:migrations:migrate`

##### Data Fixtures
Since we need some specific data for the entities, these fixtures are prepared.
The `HotelFixture` will create **10** number of records and `ReviewFixture` will create **100K** number of records.

in order to running them  on  dockers, you need tto execute following commands:

`cd docker`<br/>
`docker-compose exec php php bin/console doctrine:fixtures:load`

#### API
Preparing two number of different API end-points:

- Hotel end-point: `/api/hotel/all` <br/>
this end-point is responsible for returning all the existing hotels in a list to show them in a drop down on the front-end.<br/><br/>
It is good to mention that all the hotels data to desire format with using a DTO layer.

- Analytics end-point: `/api/analytics` <br/>
this end-point is responsible for returning analytics data based on parameters which are sent.<br/><br/>
by receiving request, all the parameters will be validate, if it is rejected by validation method, you will get an error.<br/><br/>
after that, `ReviewRepository` will get inputs and return appropriate collection of data.<br/><br/>
then a DTO will start to transforming last data into desire format and finally will be return as the end-point response.

#### Vue2
For the front-end, Vue2 with encore is using, all the related codes are written based on *TypeScript* language.
because of time limitation, I created an index page which is responsible to create main page, so the routing is handled 
by back-end, but I believe that it is better to have two different project for back-end and front-end separately.

#### Automation Tests
For the automation test, I used PHPUnit for  the back-end Unit tests and Jest for implementing front-end unit tests.

Please **Note** that the .env file and .env.test are configured based on docker configurations, so if you want to run them out of dockers, you should take care of this.

To Run PHPUnit:<br/>
`cd docker`<br/>
`docker-compose exec php ./vendor/bin/phpunit`

To Run Jest tests:<br/>
`npm run test:unit`


#####Thanks for your time.