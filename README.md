![Ozzie logo](https://raw.githubusercontent.com/tighten/ozzie/main/ozzie-banner.png)

# Ozzie

**Ozzie** is Tighten's open source projects monitor. Each project is assigned a "debt score" based on how many open issues/PRs there are, and how old they are.

## Local Installation

1. Clone the repo (`git clone git@github.com:tighten/ozzie.git && cd ozzie`)
2. Install dependencies (`composer install && npm install`)
3. Create a [GitHub OAuth Application](https://github.com/settings/developers). If you use Valet to serve your application locally, you can use the following settings:
    - Application Name: `Local Ozzie`
    - Homepage URL: `http://ozzie.test`
    - Application Description: `Local Version of Ozzie`
    - Authorization Callback URL: `http://ozzie.test/callback`
4. Copy the example `.env` file: `cp .env.example .env` and modify its settings to match your local install, including the client ID and secret from the previous step
5. Create a database table (by default `.env` looks for one named `ozzie`) and run the migrations (`php artisan migrate`)
6. Copy `projects.json.dist` to `projects.json` and modify it for your organization. This list is used to initially seed the `projects` table
7. Fetch your projects' stats for the first time using `php artisan stats:fetch`

> Note: If you're not using a tool like Laravel Valet, run `php artisan serve` and visit your site at http://127.0.0.1:8000; you'll also want to modify your GitHub app settings to use http://127.0.0.1:8000 instead of http://ozzie.test

## Projects and Daily Caching

Your list of projects is initially defined by the `projects.json` file in your app root. If you don't create one, the system will fall back to `projects.json.dist`, which also serves as a helpful template for you to create your own `projects.json` file.

Here's what the structure of the file looks like:

```json
[
    {
        "name": "ozzie",
        "namespace": "tighten",
        "maintainers": [
            "mattstauffer"
        ]
    },
]
```

You can see you'll define the GitHub namespace, the GitHub project name, and the GitHub usernames of all of its maintainers.

### Changing or Adding Projects

The list of projects resides in `projects.json`, and is seeded to the `projects` table using `database/seeds/ProjectsSeeder.php`. This means that any changes to projects needs to happen in `projects.json` _first_. Migrating and seeding tables fresh will update the `projects` table with the new info, and the next call of `php artisan stats:fetch` will re-populate project stats.

1. Make a change to `projects.json`
2. Drop and re-migrate all tables: `php artisan migrate:fresh --seed`
3. Fetch all project stats: `php artisan stats:fetch`

### Daily Caching

Every time the `php artisan stats:snapshot` command is run, it captures the scores for each project (for historical comparison).

If you're using the scheduler, it'll already be scheduled to run every day (see the docs for how to [set up the scheduler cron job](https://laravel.com/docs/scheduling)).

By default, re-running the command on the same day will not update the day's existing snapshots. To override this behavior, use the `-f` flag, which will both create any missing snapshots for the day *and* update all existing snapshots for the day.

```bash
php artisan stats:snapshot -f
```

## Local Development

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

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

-   [All Contributors](https://github.com/tighten/ozzie/graphs/contributors)

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for details.
