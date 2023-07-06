## Description
## Installation

```bash
$ cd BE composer i
$ cd FE yarn
```

## Running the BE

```bash
# development
$ cp .env.example .env
$ php artisan key:generate
$ php artisan jwt:secret
$ sail up -d

# migrate & seed
$ php artisan migrate --seed
```

## Running the FE

```bash
# development
$ yarn dev
```
