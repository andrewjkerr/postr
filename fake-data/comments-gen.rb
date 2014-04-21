require 'faker'

# Stop error message
I18n.enforce_available_locales = false

# Set locale to en-us
Faker::Config.locale = 'en-us'

# Open the file
file = File.open("insert-comments.sql", 'w')

j = 0
comments = Hash.new {|h,k| h[k] = [] }

500.times do |i|
  pid = i

  rand(50).times do
    # Generate random user id
    comment_uid = rand(501)
  
    if !comments[pid].include?(comment_uid)
      cid = j
      comment = Faker::Lorem.sentence
      insert_string = "INSERT INTO comments (pid, comment_uid, comment) VALUES (#{pid}, #{comment_uid}, '#{comment}');\n"
      file.write(insert_string)
      comments[pid].push(comment_uid)
      j += 1
    end
  end
end