
**ETUDERS - Timetable creator tool for [TOBB ETU](https://www.etu.edu.tr/en)**


This is a timetable creator tool for students in [TOBB ETU](https://www.etu.edu.tr/en). This project has been deployed with heroku free plan.


This tool needs a [TOBB ETU UBS](https://ubs.etu.edu.tr/) student credentials to work, you should set these credentials in env. variables using these commands:
```
set txtLogin=TOBB_ETU_USERNAME
set txtPassword=TOBB_ETU_PASSWORD
```

Firstly, you need [python2](https://www.python.org/downloads/) and pipenv(`pip install --user pipenv`) 


After that, execute this command:

```
pipenv install
```

This will download all packages in the Pipfile and install all dependencies for you.

Lastly, execute this command:
In windows:

```
waitress-serve --listen=*:8000 wsgi:application
```
In unix:

```
gunicorn --listen=*:8000 wsgi:application
```

You can access your website in `127.0.0.1:8000`