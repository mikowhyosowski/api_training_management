# Training management API

Konfiguracja

    docker-compose up -d

    docker exec -it "symfony_php" /bin/bash

    php bin/console doctrine:fixtures:load

    php bin/console doctrine:migrations:migrate

Testy:

    php bin/console doctrine:database:create --env=test

    php bin/console doctrine:schema:update --force --env=test

    php bin/phpunit

---

### Dodanie szkolenia

- Admin


    curl -X 'POST' \
        'http://localhost/api/training_offers' \
        -H 'accept: application/ld+json' \
        -H 'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleCI6IjEyMzQ1Njc4OTAwMDAiLCJ1c2VybmFtZSI6ImFkbWluIn0.LCPmlltCKybWMqy1RMSbHBZRe-9riiUVyIDc_4huhAU' \
        -H 'Content-Type: application/ld+json' \
        -d '{
            "name": "Nowe szkolenie zzzz",
            "instructor": {
                "id": 0,
                "firstName": "Mikowhy",
                "lastName": "Osowski"
            },
            "trainingDatetime": "2024-05-28T15:00:00.113Z",
            "price": 1500
        }'


- User (403)


    curl -X 'POST' \
        'http://localhost/api/training_offers' \
        -H 'accept: application/ld+json' \
        -H 'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOiIxMjM0NTY3ODkwMDAiLCJ1c2VybmFtZSI6IkpvaG4gRG9lIiwicm9sZXMiOlsiVVNFUiJdfQ.7Y3Do00q0EXoXY2c9qRIRfo0CC2gnct1Lhf8BAW6-u4' \
        -H 'Content-Type: application/ld+json' \
        -d '{
            "name": "Nowe szkolenie zzzz",
            "instructor": {
                "id": 0,
                "firstName": "Mikowhy",
                "lastName": "Osowski"
            },
            "trainingDatetime": "2024-05-28T15:00:00.113Z",
            "price": 1500
        }'

### Usunięcie szkolenia

- Admin


    curl -X 'DELETE' \
      'http://localhost/api/training_offers/10' \
      -H 'accept: */*' \
      -H 'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleCI6IjEyMzQ1Njc4OTAwMDAiLCJ1c2VybmFtZSI6ImFkbWluIn0.LCPmlltCKybWMqy1RMSbHBZRe-9riiUVyIDc_4huhAU'

- User (403)


    curl -X 'DELETE' \
      'http://localhost/api/training_offers/10' \
      -H 'accept: */*' \
      -H 'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOiIxMjM0NTY3ODkwMDAiLCJ1c2VybmFtZSI6IkpvaG4gRG9lIiwicm9sZXMiOlsiVVNFUiJdfQ.7Y3Do00q0EXoXY2c9qRIRfo0CC2gnct1Lhf8BAW6-u4'

### Edycja szkolenia

- Admin


    curl -X 'PUT' \
      'http://localhost/api/training_offers/10' \
      -H 'accept: application/ld+json' \
      -H 'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleCI6IjEyMzQ1Njc4OTAwMDAiLCJ1c2VybmFtZSI6ImFkbWluIn0.LCPmlltCKybWMqy1RMSbHBZRe-9riiUVyIDc_4huhAU' \
      -H 'Content-Type: application/ld+json' \
      -d '{
          "name": "Nowe szkolenie z",
          "instructor": {
              "id": 10,
              "firstName": "Mikowhy",
              "lastName": "Osowski"
          },
          "trainingDatetime": "2024-05-28T15:00:00.113Z",
          "price": 1500
      }'

- User (403)


    curl -X 'PUT' \
      'http://localhost/api/training_offers/10' \
      -H 'accept: application/ld+json' \
      -H 'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOiIxMjM0NTY3ODkwMDAiLCJ1c2VybmFtZSI6IkpvaG4gRG9lIiwicm9sZXMiOlsiVVNFUiJdfQ.7Y3Do00q0EXoXY2c9qRIRfo0CC2gnct1Lhf8BAW6-u4' \
      -H 'Content-Type: application/ld+json' \
      -d '{
          "name": "Nowe szkolenie z",
          "instructor": {
              "id": 10,
              "firstName": "Mikowhy",
              "lastName": "Osowski"
          },
          "trainingDatetime": "2024-05-28T15:00:00.113Z",
          "price": 1500
      }'

### Pobranie szkolenia

- Admin


    curl -X 'GET' \
        'http://localhost/api/training_offers/10' \
        -H 'accept: application/ld+json' \
        -H 'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleCI6IjEyMzQ1Njc4OTAwMDAiLCJ1c2VybmFtZSI6ImFkbWluIn0.LCPmlltCKybWMqy1RMSbHBZRe-9riiUVyIDc_4huhAU'

- User


    curl -X 'GET' \
        'http://localhost/api/training_offers/10' \
        -H 'accept: application/ld+json' \
        -H 'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOiIxMjM0NTY3ODkwMDAiLCJ1c2VybmFtZSI6IkpvaG4gRG9lIiwicm9sZXMiOlsiVVNFUiJdfQ.7Y3Do00q0EXoXY2c9qRIRfo0CC2gnct1Lhf8BAW6-u4'

### Pobranie listy szkoleń + filtry po training_name, training_date oraz training_instructor

- Admin


    curl -X 'GET' \
        'http://localhost/api/training_offers?page=1&date=2024-05-10&name=name&instructor=instructor_name' \
        -H 'accept: application/ld+json' \
        -H 'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleCI6IjEyMzQ1Njc4OTAwMDAiLCJ1c2VybmFtZSI6ImFkbWluIn0.LCPmlltCKybWMqy1RMSbHBZRe-9riiUVyIDc_4huhAU'

- User


    curl -X 'GET' \
        'http://localhost/api/training_offers?page=1&date=2024-05-10&name=name&instructor=instructor_name' \
        -H 'accept: application/ld+json' \
        -H 'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOiIxMjM0NTY3ODkwMDAiLCJ1c2VybmFtZSI6IkpvaG4gRG9lIiwicm9sZXMiOlsiVVNFUiJdfQ.7Y3Do00q0EXoXY2c9qRIRfo0CC2gnct1Lhf8BAW6-u4'

### Endpoint zwracajacy ilosc (count) szkolen w danym dniu. 

    curl -X 'GET' \
        'http://localhost/api/training_offers/2024/05/10' \
        -H 'accept: application/ld+json'

