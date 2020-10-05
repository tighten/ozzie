![Ozzie logo](https://raw.githubusercontent.com/tighten/ozzie/main/ozzie-banner.png)

# Ozzie

**Ozzie** is Tighten's open source projects monitor. Each project is assigned a "debt score" based on how many open issues/PRs there are, and how old they are.

## Local Development

1. Clone the repo
2. Run `composer install && npm install`
3. Copy the .env example file: `cp .env.example .env` and modify its settings
4. Create a [GitHub OAuth Application](https://github.com/settings/developers). If you use `php artisan serve` to serve your application locally, you can use the following settings:
    - Application Name: `Local Ozzie`
    - Homepage URL: `http://127.0.0.1:8000`
    - Application Description: `Local Version of Ozzie`
    - Authorization Callback URL: `http://127.0.0.1:8000/callback`
5. Copy the client ID and secret from the previous step into your .env file
6. (optional) Copy `projects.json.dist` to `projects.json` and modify it for your organization
7. Run `php artisan serve` and visit http://127.0.0.1:8000

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

The list of projects is currently stored in a JSON file, `projects.json`, in the root directory.

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

The scores for each project are recorded in a daily snapshot (for historical comparison) using the `snapshot:today` command. This can be run manually, but it's also scheduled to run daily. Make sure to [set up the scheduler cron job](https://laravel.com/docs/scheduling) on any server where this project is deployed.

By default, re-running the command will not update the day's existing snapshots. To override this behavior, use the `-f` flag, which will create any missing snapshots for the day and update all existing snapshots.

```bash
php artisan snapshot:today -f
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

-   [All Contributors](https://github.com/tighten/ozzie/graphs/contributors)

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for details.
