#<?php 

[site]
SiteName=artscene.v2
Language=lt
Theme=naujas
DefaultPage=index
OwnerMail=artscene@fluxus.lt

[db]
#db_host=localhost:/var/run/mysqld/mysqld.sock
db_host=localhost
db_user=root
db_password=
db_name=artscene

[control]
AdminCount=15

[avnews]
image_dir=/f/sites/scene/art.scene.lt/htdocs/news_files/
image_url=/news_files/
im_convert=/usr/bin/convert
newslist_page=news
item_count=5
headlines_count=5

[forum]
fresh_count=10

[avworks]
thumbnails_dir=/f/sites/scene/art.scene.lt/htdocs/files/thumbs/
thumbnails_url=../files/thumbs/
works_dir=/f/sites/scene/art.scene.lt/htdocs/files/
works_url=../files/
convert_exec=/usr/bin/convert
works_list_page=works
fresh_count=10

[users]
default_group=2
page=simple


[index]
template=index.html
columns=login_box;darbai_column;news_column
login_box=users-login
news_column=news-news;darbai-darbai_list-show_fresh_works;forum-forum-show_fresh_threads
darbai_column=darbai-darbai_list-show_index_top;darbai-darbai_list-show_index_new

[simple]
template=simple.html
columns=login_box;menu_content
login_box=users-login
menu_content=content-menuitem-show_output-about

[twocolumn]
template=twocolumn.html
columns=login_box;first_column;menu_content
login_box=users-login
first_column=polls-user_polls
menu_content=content-menuitem-show_output-about

[news]
template=twocolumn.html
columns=login_box;first_column;menu_content
login_box=users-login
first_column=news-news-show_subcontent
menu_content=news-news

[works]
template=simple_empty.html
columns=login_box;menu_content
login_box=users-login
menu_content=darbai-darbai-show_list

[userinfo]
template=twocolumn.html
columns=login_box;menu_content;first_column
login_box=users-login
first_column=users-login-show_userinfo;users-messages-show_message_submit;news-news-show_user_headlines;users-login-show_draugeliai
menu_content=content-menuitem-show_output-works_user

[workinfo]
template=workitem.html
columns=login_box;menu_content
login_box=users-login
menu_content=darbai-darbai-show_item
