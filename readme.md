## Ozzie
Get-Your-Shit-Together-Ness

Simple Github project analytics. Issue and Pull request tracking, with calculated debt score.

### Setup

Ozzie runs on Laravel `5.5` and by default uses data storage to track project debt scores daily.

#### 1. Clone repository

	$ git clone git@github.com:tightenco/ozzie.git

#### 2. Install dependencies
NPM and Yarn are both supported.

	$ composer install
	$ npm install

If you're using Yarn instead

	$ yarn

#### 3.Migrate database

Choose a database configuration before migration. ([Laravel documentation](https://laravel.com/docs/5.5/database)).

	$ php artisan migrate

#### 5. Github settings
Currently Github is the only supported VCS. The following `.env` variables need to be set. You'll need to create a client id and secret through Github. ([documentation](https://github.com/settings/applications/new))

	GITHUB_CLIENT_ID=
	GITHUB_CLIENT_SECRET=

#### 6. Project Repositories
Projects are currently stored in a json file, `projects.json` in the root directory.

	[
		{
        "name": "ozzie",
        "namespace": "tightenco",
        "maintainers": [
            "mattstauffer"
        	]
    	},
	]

#### 7. Run Artisan Command
**In order to cache these results daily, this artisan command needs to be ran once a day.**

	$ php artisan projects:save
