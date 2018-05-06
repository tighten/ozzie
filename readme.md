## Ozzie
Get-Your-Shit-Together-Ness

Simple GitHub project analytics. Issue and Pull Request tracking, with calculated debt score.

### Setup

Ozzie runs on Laravel `5.5` and by default uses data storage to track project debt scores daily.

#### 1. Clone repository
```
git clone git@github.com:tightenco/ozzie.git
```
#### 2. Install dependencies
NPM and Yarn are both supported.

```bash
composer install
npm install
```

If you're using Yarn instead

```bash
yarn
```

#### 3.Migrate database

Choose a database configuration before migration. ([Laravel documentation](https://laravel.com/docs/5.5/database)).

```bash
php artisan migrate
```

#### 5. GitHub settings
Currently GitHub is the only supported VCS. The following `.env` variables need to be set. You'll need to create a client id and secret through GitHub. ([documentation](https://github.com/settings/applications/new))

```
GITHUB_CLIENT_ID=
GITHUB_CLIENT_SECRET=
```

#### 6. Project Repositories
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

#### 7. Run Artisan Command
**In order to cache these results daily, make sure to run the scheduler.**

```bash
php artisan projects:save
```
