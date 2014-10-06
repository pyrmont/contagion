Contagion
=========

[Zedtown](http://www.zedtown.com/) is a giant game of zombie-themed tag. Players take up toy dart blasters and fight for their life against hordes of vicious zombies. Over the course of an afternoon, as survivors are hunted down and tagged by zombies they become zombies themselves, spreading the virus and dooming humanity.

Contagion is a simple web app for tracking infections in Zedtown. A user can submit a player ID and, if the ID matches a player in the database, Contagion will mark that player as having been infected.

Installation
------------

Contagion requires an SQLite database with a table called `players`. The table must include columns for `player_id`, `full_name` and `status`.

```bash
git clone git://github.com/pyrmont/contagion.git  # Warning: read-only.
cd contagion
bundle install
bundle exec ruby app.rb # Kick it off in development mode
```

Copyright
---------

Contagion is placed in the [public domain](http://creativecommons.org/publicdomain/zero/1.0/).