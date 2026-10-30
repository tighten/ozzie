![Ozzie logo](https://raw.githubusercontent.com/tighten/ozzie/main/ozzie-banner.png)

----

# Ozzie

[![Run tests](https://github.com/tighten/takeout/workflows/Run%20tests/badge.svg?branch=main)](https://github.com/tighten/ozzie/actions?query=workflow%3A%22Run+Tests%22)

**Ozzie** is Tighten's open source projects monitor. Each project is assigned a "debt score" based on how many open issues/PRs there are, and how old they are.

## Local Installation

### MacOS - Valet / Herd

1. Clone the repo (`git clone git@github.com:tighten/ozzie.git && cd ozzie`)
2. Install dependencies (`composer install && npm install`). You will need a Nova username and password to complete the installation.
3. Run `valet secure` (or `herd secure` if you're using Herd) to use `https` for the local domain
4. Update `APP_URL` in `.env` to use your local valet TLD. By default, it will use `https://ozzie.test`
5. Create a [GitHub OAuth Application](https://github.com/settings/developers). If you use Valet/Herd to serve your application locally, you can use the following settings:
    - Application Name: `Local Ozzie`
    - Homepage URL: `https://ozzie.test`
    - Application Description: `Local Version of Ozzie`
    - Authorization Callback URL: `https://ozzie.test/auth/callback`
6. (Optional) Set up [Slack Incoming Webhooks](https://api.slack.com/messaging/webhooks) for notifications:
    - Go to [Your Apps](https://api.slack.com/apps) and create a new app (or select an existing one)
    - Enable **Incoming Webhooks** and create a new webhook for each channel you want to notify
    - Set `SLACK_WEBHOOK_URL` in your `.env` to the webhook URL for your primary notifications channel (e.g. project stats)
    - Set `SLACK_OPS_WEBHOOK_URL` in your `.env` to the webhook URL for your ops notifications channel (e.g. GitHub API errors). If not set, ops notifications will fall back to `SLACK_WEBHOOK_URL`.
7. Copy the example `.env` file: `cp .env.example .env` and modify its settings to match your local install, including the client ID and secret from step 5 and the Slack webhook URLs from step 6
8. Run `php artisan key:generate`
9. Create a database (by default `.env` looks for one named `ozzie`) and run the migrations (`php artisan migrate`)
10. Fetch the projects list (into the database) by using the `php artisan projects:fetch` command. Alternatively, you can seed your `projects` table using a `projects.json` file at the root of the project (see below for more info).
11. Fetch all projects' stats for the first time using `php artisan stats:fetch`

### Sail - Docker

*ensure you have docker installed and running*

For the following steps, you'll need to have the `sail` command available. You can alias it by running:
```shell
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```
[For more info around aliasing check this part of the docs](https://laravel.com/docs/10.x/sail#configuring-a-shell-alias)

1. Clone the repo (`git clone git@github.com:tighten/ozzie.git && cd ozzie`)
2. Install dependencies

    ```shell
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs
    ```

    ```shell
    sail npm install
    ```

3. Create a [GitHub OAuth Application](https://github.com/settings/developers). If you use Valet to serve your application locally, you can use the following settings:
    - Application Name: `Local Ozzie`
    - Homepage URL: `http://localhost`
    - Application Description: `Local Version of Ozzie`
    - Authorization Callback URL: `http://localhost/auth/callback`
4. (Optional) Set up [Slack Incoming Webhooks](https://api.slack.com/messaging/webhooks) for notifications:
    - Go to [Your Apps](https://api.slack.com/apps) and create a new app (or select an existing one)
    - Enable **Incoming Webhooks** and create a new webhook for each channel you want to notify
    - Set `SLACK_WEBHOOK_URL` in your `.env` to the webhook URL for your primary notifications channel (e.g. project stats)
    - Set `SLACK_OPS_WEBHOOK_URL` in your `.env` to the webhook URL for your ops notifications channel (e.g. GitHub API errors). If not set, ops notifications will fall back to `SLACK_WEBHOOK_URL`.
5. Copy the example `.env` file: `cp .env.example .env` and modify its settings to match your local install, including the client ID and secret from step 3 and the Slack webhook URLs from step 4
6. Run `sail artisan key:generate`
7. Run the migrations (`sail artisan migrate`)
8. Fetch the projects list (into the database) by using the `projects:fetch` command. Alternatively, you can seed your `projects` table using a `projects.json` file at the root of the project (see below for more info).
9. Fetch all projects' stats for the first time using `stats:fetch`

> Note: If you're not using a tool like Laravel Valet, run `php artisan serve` and visit your site at http://127.0.0.1:8000; you'll also want to modify your GitHub app settings to use http://127.0.0.1:8000 instead of http://ozzie.test

## Projects and Daily Caching

If you'd like to seed `projects` manually, you can do so using the `projects.json` file in your app root. If you don't create one, the system will fall back to `projects.json.dist`, which also serves as a helpful template for you to create your own `projects.json` file.

Here's what the structure of the file looks like:

```json
[
    {
        "name": "ziggy",
        "namespace": "tighten",
        "packagist_name": "tighten/ziggy",
        "npm_name": "ziggy-js",
        "package_registry": "packagist",
        "maintainers": [
            "mattstauffer"
        ]
    },
]
```

Each project in this file will need its GitHub namespace, the GitHub project name, and the GitHub usernames of all of its maintainers. The registry keys are optional; see below.

## Package Registries

Some projects are published to Packagist, some to npm, and some are GitHub-only. Each project records which one it is in `package_registry`, so we only ever ask the registry a project actually belongs to for download counts:

| Value | Meaning |
| --- | --- |
| `packagist` | A Composer package; download counts come from Packagist using `packagist_name`. |
| `npm` | An npm package; download counts come from npm using `npm_name`. |
| `none` | Not published to either; only GitHub stats are fetched. |
| `unknown` | Not determined yet; it will be detected on the next `stats:fetch`. |

Detection happens automatically:

- `projects:fetch` detects the registry for each new repo as it's ingested.
- `stats:fetch` detects the registry for any project still marked `unknown`.
- If a registry reports that the name we have doesn't exist any more, `stats:fetch` re-detects the project instead of failing the same way the next day.

A project is only matched to an npm package when that package's `repository` points back at the project's GitHub repo, so unrelated packages that happen to share a name aren't claimed. If a registry can't be reached, the project is left exactly as it was rather than being downgraded to `none`.

You can also set the registry by hand in Nova on the Project resource, along with the `packagist_name` and `npm_name` fields, or run the **Detect Package Registry** action to re-run detection for selected projects.

### Changing or Adding Projects

Using the GitHub API, new public repos added to the organization will be added automatically (checked daily) through the `projects:fetch` command.

If you're doing it manually, any changes to projects needs to happen in `projects.json` _first_. Migrating and seeding tables fresh will update the `projects` table with the new info, and the next call of `php artisan stats:fetch` will re-populate project stats.

1. Make a change to `projects.json`
2. Re-run the seeder: `php artisan db:seed`
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

Use Vite to automatically compile JS/CSS on save:

```bash
npm run dev
```

### Running the Linter Tools

This project uses [Duster](https://github.com/tighten/duster) to fix PHP, [Prettier](https://prettier.io/) to fix JS, and [StyleLint](https://stylelint.io/) to lint & fix CSS.

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
