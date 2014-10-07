require 'sequel'
require 'csv'

abort "Error: Setup requires 3 arguments. You must pass the path to the database, the CSV file and whether the CSV uses headers." unless ARGV[0] && ARGV[1] && ARGV[2]

# Set the configuration options.
database_file = ARGV[0]
csv_file = ARGV[1]
are_headers = ARGV[2].downcase == 'true' ? true : false

# Create the database
db = Sequel.sqlite database_file

# Create the table if it doesn't exist.
db.create_table! :players do
    primary_key :id
    String :number, :unique => true, :null => false
    String :name, :null => false
    String :status, :default => 'survivor'
end

# Setup the players variable.
players = db[:players]

# Read in the data from the CSV file.
data = CSV.read csv_file, headers: are_headers

# Store the data in the database.
data.each do |row|
    players.insert :number => row[0], :name => row[1]
end
