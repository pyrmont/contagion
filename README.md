Contagion
=========

Contagion is a simple web app for tracking infections in [Zedtown](http://www.zedtown.com/). A user can submit a player ID and, if the ID matches a player in the database, Contagion will mark that player as having been infected.

Setup
-----

Before running Contagion, it is necessary to:

* run `setup.rb` with a CSV file containing player numbers and names;
* rename `authentication.example` to `authentication` and replace the password and token; and
* change the permissions on `authentication` to 600.

```bash
git clone git://github.com/pyrmont/contagion.git
cd contagion
bundle install

# Last argument should be false if CSV does not contain a header row.
bundle exec ruby setup.rb database.sqlite /path/to/datafile.csv true

echo "your_password your_token" > authentication
chmod 600 authentication

bundle exec ruby app.rb
```

Explanation
-----------

Running `setup.rb` creates an SQLite database with a table called `players`. If the table already exists, it will be dropped.

Contagion uses a very simple and easily circumvented authentication system that stores the password and token in plain text in a filed called `authentication`. This system should be replaced with a more secure system in production.

Copyright
---------

Original work is placed in the [public domain](http://creativecommons.org/publicdomain/zero/1.0/). Please note that images, fonts, stylesheets and other third party files that are included in this project remain the property of their respective owners and may be subject to copyright.
