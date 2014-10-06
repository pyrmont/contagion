require 'sinatra'
require 'sequel'

# Set the configuration options.
database_file = 'database.sqlite'

# Retrieve information from the database.
store = Sequel.sqlite database_file
players = store[:players]

# Set the index route.
get '/' do
    erb :index
end

# Set the submission route.
post '/submit' do
    player = players.where(:number => params[:player_id])

    # if player.exists?
      # redirect to success
    # else
      # redirect to failure
    # end
end

# Set the route for a successful update to the database.
get '/success' do
    'Success!'
end

# Set the route for a failed update to the database.
get '/failure' do
    'Failure!'
end

# Set the super secret route for a listing of all players.
get '/list' do
    @players = players.all

    erb :list
end