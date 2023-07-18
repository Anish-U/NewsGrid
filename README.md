# NewsGrid - News Portal

## Introduction

Developed an Online News Portal, that allows various users to easily create, read, bookmark and download news articles. Integrated [mPDF](https://mpdf.github.io/), a PHP library which generates PDF files from UTF-8 encoded HTML. Wrote clean, well documented, reusable code and incorporated the best development practices at my best.
<br>

Technologies used:

- Front end: HTML, CSS, JavaScript, Bootstrap (for Admin Panel only)
- Back end: PHP, MySQL
- Library: mPDF Library
  <br>

This project aims to develop a computerized and easy to access the day-to-day news without having to wait. “NewsGrid” is aimed at developing such an efficient website that helps in providing up to date news about various happenings around the world.

```
Admin login details: 
email - admin@admin.com
password - Admin123
```

#### [View Screenshots](https://github.com/Anish-U/NewsGrid#project-screenshots)

## Module Description

The entire project as a whole can be divided into 4 modules, the
four modules being:

- [Admin Module](https://github.com/Anish-U/NewsGrid#admin-module)
- [Author Module](https://github.com/Anish-U/NewsGrid#author-module)
- [Free User](https://github.com/Anish-U/NewsGrid#user-module)
- [Premium User](https://github.com/Anish-U/NewsGrid#premium-user-module)

### Admin Module

- Admin can modify and delete user account and restrict them from entering the logged-in portal of NewsGrid.
- Admin can modify and delete Author account and restricting inactive authors from writing new articles on NewsGrid.
- Admin can add, modify and delete categories under which various articles are written.
- Admin can delete all the News Articles present in the NewsGrid Portal, decides whether the particular article should stay or not.
- Admin manages the Trending section of the portal, chooses which article goes under Trending section and is displayed on carousel
- Admin can manage his account credentials (i.e.) can change password.

<hr style="font-size: 10px;margin: auto;" width="90%" >

### Author Module

- Author can write new articles and post in the NewsGrid portal by selecting the appropriate category in which the article is written and to be displayed.
- Author can modify and delete articles written by him only.
- Author can manage his account credentials (i.e.) can change password & name.

<hr style="font-size: 10px;margin: auto;" width="90%" >

### User Module

- User can browse through NewsGrid website and search for articles under various categories present in the portal.
- User can search for articles based in his preferred categories like Sports, Entertainment, Politics, etc.
- User can search for a particular article based on specific keywords like title of the article or category name, trending.
- User can sort articles date wise and view articles posted on particular date of choice or between a span of days.
- User can also look up the trending articles of the week.
- User can manage his account credentials (i.e.) can change password.

<hr style="font-size: 10px;margin: auto;" width="90%" >

### Premium User Module

- A Premium User can basically do everything a free user can do. User can browse through NewsGrid website and search for articles under various categories present in the portal.
- User can search for a particular article based on specific keywords like title of the article or category name, trending, date.
- Premium User can download an article of his choice in PDF format from any web browser from NewsGrid Portal.
- Premium User can bookmark an article for future references and all the bookmarked articles are visible separately on the Bookmarks Page.
- Premium User can manage his account credentials (i.e.) can change password.

---

## Project Diagrams

#### Activity Diagram
<img src="https://github.com/Anish-U/NewsGrid/blob/10688607a9c5eb8d4b967baccaac7e2d78adfaad/Diagrams/AD.jpg" width="500">

#### Entity Relationship Diagram
<img src="https://github.com/Anish-U/NewsGrid/blob/10688607a9c5eb8d4b967baccaac7e2d78adfaad/Diagrams/ER.jpeg" width="500">

#### Database Design
<img src="https://github.com/Anish-U/NewsGrid/blob/10688607a9c5eb8d4b967baccaac7e2d78adfaad/Diagrams/RS.jpeg" width="500">

---

## Project Screenshots

#### Home Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/home.png" width="500">

#### Categories Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/categories.png" width="500">

#### Search Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/search.png" width="500">

#### Login & Signup Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/login.png" width="500">

#### Bookmarks Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/bookmarks.png" width="500">

#### Change Password Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/changePassword.png" width="500">

#### Author Dashboard Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/authorPanelDashboard.png" width="500">

#### Add Article Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/authorPanelAddArticle.png" width="500">

#### Edit Article Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/authorPanelEditArticle.png" width="500">

#### All Articles Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/authorPanelArticles.png" width="500">

#### Author Change Name Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/authorPanelChangeName.png" width="500">

#### Admin Login Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/adminPanelLogin.png" width="500">

#### Admin Manage Articles Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/adminPanelArticles.png" width="500">

#### Admin Manage Category Page
<img src="https://github.com/Anish-U/NewsGrid/blob/master/screenshots/adminPanelCategories.png" width="500">

---

## Development setup

#### 1. Retrieve the project (if you haven't done so already)

```git
 $ git clone https://github.com/Anish-U/NewsGrid.git
```
or download the project via GitHub

#### 2. Move project folder to htdocs folder

if you cannot find the htdocs folder please follow the below links,

- [Where to find htdocs in XAMPP Mac](https://stackoverflow.com/questions/45518021/where-to-find-htdocs-in-xampp-mac)
- [Find htdocs path, no matter where file is stored](https://stackoverflow.com/questions/5536730/find-htdocs-path-no-matter-where-file-is-stored)
- [htdocs path in linux](https://stackoverflow.com/questions/1582851/htdocs-path-in-linux)
- [https://stackoverflow.com/questions/1582851/htdocs-path-in-linux](https://stackoverflow.com/questions/44989243/unable-to-find-htdocs-on-xampp)

#### 3. Restore Database

- Goto phpMyAdmin and create a Database names `news-portal`.
- Now Select Import.
- Find 'File to import:' section and choose the file 'news-portal.sql' which is located under project folder and hit GO.

#### 4.Setup Database Configurations

- Go to project folder -> includes -> database.inc.php.
- Setup your configurations related to MySQL.
  - Eg: Server Name -> `localhost`, MySQL Username -> `root`.

#### 5. Start Server

- Start the server and run http://localhost:8888/Folder_name/index.php (replace the port number 8888 to your port).
- Alternatively you can also run the command on your terminal
  ```terminal
     php -S localhost:8888 (replace the port number to your choice)
  ```
