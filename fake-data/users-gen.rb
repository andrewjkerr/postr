require 'faker'
require 'digest/sha2'

# Stop error message
I18n.enforce_available_locales = false

# Set locale to en-us
Faker::Config.locale = 'en-us'

# Open the file
file = File.open("insert-users.sql", 'w')

500.times do |i|
  
  # Generates fake name to use for username and email
  # Note: Not actually stored in DB!
  name = Faker::Name.name
  
  # Generates fake username
  username = Faker::Internet.user_name(name, %w(. _ -))
  
  # Generates fake email
  email = Faker::Internet.safe_email(name)
  
  # Generates fake password to be hashed!
  # Note: Not actually stored in DB!
  # password = password! :)
  password_hash = '$1$Imi7BgQI$k.UOyWzQc7CanqJX0bKiy1'

  insert_string = "INSERT INTO users (username, email, password_hash) VALUES('#{username}', '#{email}', '#{password_hash}');\n"
  file.write(insert_string)

end