# sunnah-website
This is the front end code for sunnah.com . It is built atop the Yii MVC framework.

The top level structure is divided into application code (application folder) that includes MVC code and the public folder which contains index.php, css, js, etc. Your webserver should point to the public folder. The Yii framework code needs to reside on the machine as well; its location is hardcoded into public/index.php .

Under the applications folder, here are the important locations:

config/main.php : All the configuration options, including URL routes, database connections, etc.

Yii divides its MVC stuff into "modules" that share code. Think of them as sections of a website. For example, an admin section vs. a public section. 

modules/default/controllers: All controller classes. There are three main controllers: the search page, the index and sitewide pages, and the collection controller which includes actions for displaying collections, books, and ahadith.

modules/default/models: All model classes. Each kind of object has a model class. E.g. hadith, book, collection.

modules/default/views: Each controller has actions which have view code. This folder contains the view code.

modules/default/views/layouts: Other view code corresponding to side menus, search box, widgets, etc.

modules/views: Sitewide view code like column layout, footer.

modules/views/site: Not used. This folder is for view code that needs to be the same across modules.

# Launching the Dev Container

Launching the dev container is composed of two simple commands. First, building the image, then running it.

In order to build the image, run the following command in the same directory as the Dockerfile:

`docker build -t {username}/{imagename} .`

Once the docker image builds, run it by doing the following:

`docker run -d -p 80:80 -p 3306:3306 {username}/{imagename}` 

If you've used the ports above, you should be able to access the webserver as well as mysqld using ports 80 and 3306, respectively, via localhost.
