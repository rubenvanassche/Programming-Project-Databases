# CoachCenter
*Awesome* web-service for (~~soccer~~) football stats, (safe) betting with your
friends and such.

This was a project for the course Programming Project Databases at the
University of Antwerp. As this was a group project, the following developers have
built the basics of CoachCenter:

- [JakobStruye](https://github.com/JakobStruye)
- [KristofDM](https://github.com/KristofDM)
- [rubenvanassche](https://github.com/rubenvanassche)
- [Stijn-Flipper](https://github.com/Stijn-Flipper)
- [tomroels](https://github.com/tomroels)

This project uses [Laravel PHP Framework](http://laravel.com/).

## Basic features
- match predictions based upon statistics
- suggestions for users using nice visualization of statistical data
- updating matches and rankings frequently
- e-mail notifications for users when a match is going to play while the user
  hasn't made a bet yet.
- automatically load new data (including unknown matches like finals)

**non-logged users**
- view statistical data
- view match outcomes (including filtering on competition type and time)
- view match predictions

**logged-in users**
- input match predictions
- receive suggestions from system
- creating user groups
  - view bet scores and ranking in this group
  - subscribe to other group (after invitation)

## Extended features
Of course, there's more!

- News feed
- Twitter feed
- Facebook integration
- Search through the data

## Installation
First, you'll need to load some data in the database:

1. Create database `coachcenter`
2. Run the installation script `install/install.sh` (Only if you're on linux, also run from inside the install folder, read `install/readme.txt` first)
3. Load the data as given in `sql/coachcenter.sql` file into this database.

Then you can deploy the site locally using `artisan`:

```sh
$ php artisan serve
```

Now, a local version of the CoachCenter is running in your localhost (usually
`http://localhost:8000`).
