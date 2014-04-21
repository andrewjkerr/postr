#!/bin/bash

clear
echo "FAKE POSTR DATA GENERATION"
echo "Made by Andrew Kerr <andrewjkerr.com>"
echo
echo "--Generating USERS--"
ruby users-gen.rb
echo "Outputed SQL: insert-users.sql"
echo
echo "--Generating FOLLOWS--"
ruby follows-gen.rb
echo "Outputed SQL: insert-follows.sql"
echo
echo "--Generating POSTS--"
ruby posts-gen.rb
echo "Outputed SQL: insert-posts.sql"
echo
echo "--Generating LIKES--"
ruby likes-gen.rb
echo "Outputed SQL: insert-likes.sql"
echo
echo "--Generating COMMENTS--"
ruby comments-gen.rb
echo "Outputed SQL: insert-comments.sql"
echo
echo "FAKE POSTR DATA GENERATION IS COMPLETE!"