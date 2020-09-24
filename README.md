![Ozzie logo](https://raw.githubusercontent.com/tighten/ozzie/main/ozzie-banner.png)

# Ozzie

**Ozzie** is Tighten's open source projects monitor. Each project is assigned a "debt score" based on how many open issues/PRs there are, and how old they are.

## Local Development

1. Clone the repo
2. Run `composer install && npm install`
3. Copy the .env example file: `cp .env.example .env`
4. Create a [GitHub OAuth Application](https://github.com/settings/developers). If you use `php artisan serve` to serve your application locally, you can use the following settings:
    - Application Name: `Local Ozzie`
    - Homepage URL: `http://127.0.0.1:8000`
    - Application Description: `Local Version of Ozzie`
    - Authorization Callback URL: `http://127.0.0.1:8000/callback`
5. Copy the client ID and secret from the previous step into your .env file
6. Run `php artisan serve` and visit http://127.0.0.1:8000

> Note: If using [Laravel Valet](https://laravel.com/docs/master/valet) or [Laravel Homestead](https://laravel.com/docs/master/homestead), you can configure your local URL to be something like `http://ozzie.test`.

### Compiling the Frontend Assets

Use Laravel Mix to automatically compile JS/CSS on save:

```bash
npm run watch
```

### Running the Linter Tools

This project uses [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) to fix PHP, [Prettier](https://prettier.io/) to fix JS, and [StyleLint](https://stylelint.io/) to lint & fix CSS.

To automatically fix PHP:

```bash
composer fix
```

To automatically fix JS:

```bash
npm run fix-js
```

To automatically fix CSS:

```bash
npm run fix-css
```

## Projects and Daily Caching

Projects are currently stored in a JSON file, `projects.json` in the root directory.

```json
[
    {
        "name": "ozzie",
        "namespace": "tightenco",
        "maintainers": [
            "mattstauffer"
        ]
    },
]
```

The scores and info for each project are cached no more than daily using the `snapshot:today` command. This can be run manually, but is scheduled to run daily. Make sure to run the scheduler when deployed.

Updating this cache manually using the `-f` flag to force all project data to be updated for today's date:

```bash
php artisan snapshot:today -f
```

This does not create a new snapshot for the day; any existing project data for today is updated, and missing projects have a new snapshot created.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

-   [All Contributors](https://github.com/tighten/ozzie/graphs/contributors)

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for details.
