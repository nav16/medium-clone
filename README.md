# Medium-Clone

This is a clone/copy of [medium.com](https://medium.com).

It gives the medium's some functionality in dirty way.


__demo__: [http://blog.iteching.info](http://blog.iteching.info)

## Features

__The repos used:__

__Inline Editor:__ https://github.com/daviferreira/medium-editor

![screenshot](https://raw.github.com/imnpandey/medium-clone/master/demo-images/post.jpg)
![screenshot](https://raw.github.com/imnpandey/medium-clone/master/demo-images/post-edit.jpg)

![screenshot](https://raw.github.com/imnpandey/medium-clone/master/demo-images/new-post.jpg)
![screenshot](https://raw.github.com/imnpandey/medium-clone/master/demo-images/new-post-placeholder1.jpg)

__Design:__ Copied from Medium (to save time)
__Time__ into project I guess its around 24 - 48 hrs mainly took time to copy the design.


## Some More

![screenshot](https://raw.github.com/imnpandey/medium-clone/master/demo-images/profile.jpg)
![screenshot](https://raw.github.com/imnpandey/medium-clone/master/demo-images/profile-edit.jpg)

##Tables

 ```sql
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(160) NOT NULL,
  `subtitle` varchar(250) NOT NULL,
  `post` longtext NOT NULL,
  `datetime` int(20) NOT NULL,
  `view` int(5) NOT NULL DEFAULT '0',
  `fk_u_id` int(100) NOT NULL,
  PRIMARY KEY (`id`)
)

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(1024) NOT NULL,
  `email_code` varchar(32) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `password_recover` int(11) NOT NULL DEFAULT '0',
  `type` int(1) NOT NULL DEFAULT '0',
  `allow_email` int(11) NOT NULL DEFAULT '1',
  `bio` varchar(120) NOT NULL,
  `profile` varchar(55) NOT NULL,
  PRIMARY KEY (`user_id`)
)

 ```
## License

Do what you want to do!<br>
Fork/ Download have fun.<br>
