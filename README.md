This repository contain test application

You can start App in such ways:

+ Using Built-in web server:
`php -S 127.0.0.1:8000 -t public/`

+ Using Docker (server run on **localhost:8080**):
`make up`

------

App contain routes like:

- `POST /auth/token` - for generate md5 token
(for getting token please use **admin**:**admin**)
- `GET /costs` - for fetching all data
- `GET /cost/{id}` - for fetching one item