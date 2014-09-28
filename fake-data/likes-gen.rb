# Open the file
file = File.open("insert-likes.sql", 'w')

likes = Hash.new {|h,k| h[k] = [] }

499.times do |i|
  
  rand(50).times do
    # Generate post id
    pid = i + 1

    # Generate random user id
    like_uid = rand(500) + 1
  
    if !likes[pid].include?(like_uid)
      insert_string = "INSERT INTO likes VALUES (#{pid}, #{like_uid});\n"
      file.write(insert_string)
      likes[pid].push(like_uid)
    end
  end
end