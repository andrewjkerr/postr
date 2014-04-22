postr
=====

postr currently lives at [akerr.me/postr](https://www.akerr.me/postr) and will remain there until further notice.

(Please note that the cert is currently self-signed so going to postr over HTTPS will display a warning on most modern browsers.)

Back-end
--------

postr is currently hosted on a Digital Ocean VPS with 512MB of RAM, 1 core CPU, and 20GB SSD. The following applications/services are currently powering postr:
* Ubuntu Server LTS 12.04
* PostgreSQL
* nginx
* php-fpm
* OpenSSL (not required)

About
-----

Problem: Keeping up with constant updates from friends/family
Solution: Postr

Postr is a temporary social media site where each user can only have one post at a time. This post is automatically erased when another post is published by that user. A post can be text or a picture (more to be added later) and each post will not be archived so once another post is published, the previous post will be erased indefinitely.

Each post will have a comment system that will allow for replies and recommends. This will enable users to create a meaningful conversation on a post. Users will also be able to 'like' posts.

Postr will give users the ability to follow others, but a user’s followers will only be available to that user (in a future update.) Who a user follows will also be kept to only that user. Any posts made by another user that the current user follows will show up on the Postr feed.
