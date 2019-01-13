
**ETUDERS - Timetable creator tool for [TOBB ETU](https://www.etu.edu.tr/en)**


This is a timetable creator tool for students in [TOBB ETU](https://www.etu.edu.tr/en). This project has been deployed with heroku free plan.

Here is some screenshots from the application(In Turkish):
<p align="center">
  <img width="800" src="https://user-images.githubusercontent.com/15220477/50602859-a458a900-0ec9-11e9-8ea9-29d2cd6bbc13.png">
</p>
<p align="center">
  <img width="800" src="https://user-images.githubusercontent.com/15220477/50602880-b0dd0180-0ec9-11e9-9fc1-6a5c67af2b70.png">
</p>
<p align="center">
  <img width="800" src="https://user-images.githubusercontent.com/15220477/50602884-b33f5b80-0ec9-11e9-847b-d37c5eed6c16.png">
</p>
<p align="center">
  <img width="800" src="https://user-images.githubusercontent.com/15220477/50602890-b4708880-0ec9-11e9-8574-4c6bc0a1fed1.png">
</p>
<p align="center">
  <img width="800" src="https://user-images.githubusercontent.com/15220477/50602892-b63a4c00-0ec9-11e9-8c6d-df7d690d7b3f.png">
</p>


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
waitress-serve --listen=*:8000 etuders:application
```
In unix:

```
gunicorn --listen=*:8000 etuders:application
```

You can access your website in `127.0.0.1:8000`
