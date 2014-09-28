# Open the file
file = File.open("insert-follows.sql", 'w')

follows = Hash.new {|h,k| h[k] = [] }

i = 0

while i < 5000 do
  
  # Generate random user ids
  follow_uid = rand(500) + 1
  follower_uid = rand(500) + 1
  
  if !follows[follow_uid].include?(follower_uid)
    insert_string = "INSERT INTO follows (follow_uid, follower_uid) VALUES (#{follow_uid}, #{follower_uid});\n"
    file.write(insert_string)
    follows[follow_uid].push(follower_uid)
    i += 1
  end
end